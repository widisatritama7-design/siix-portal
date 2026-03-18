<?php

namespace App\Models\DCC;

use Carbon\Carbon;
use App\Models\User;
use App\Models\DCC\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submission extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "tb_dcc_submissions";

    protected $fillable = [
        'description',
        'revision',
        'documentation',
        'remarks',
        'received_by',
        'status',
        'dept',
        'pic',
        'status_distribute',
        'due_date',
        'category_document',
        'created_by',
        'updated_by',
        'deleted_at',
        'emails',
        'reason',
        'reason_to_delete',
    ];

    protected $casts = [
        'due_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'emails' => 'array',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept', 'dept_name');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get due date label with color
     */
    public function getDueDateLabelAttribute()
    {
        $today = Carbon::today();
        $due = $this->due_date;

        if (!$due) {
            return ['label' => '-', 'color' => 'gray'];
        }

        if (empty($this->status_distribute)) {
            return ['label' => 'Rejected', 'color' => 'gray'];
        }

        if ($this->status_distribute === 'Distributed') {
            return ['label' => 'Distributed', 'color' => 'success'];
        }

        if ($this->status_distribute === 'Waiting Distribute') {
            if ($due->isToday()) {
                return ['label' => 'Today', 'color' => 'danger'];
            }

            if ($due->isFuture()) {
                $daysDiff = $today->diffInDays($due);
                return [
                    'label' => $daysDiff . ' Day' . ($daysDiff > 1 ? 's' : ''),
                    'color' => 'success'
                ];
            }

            // overdue
            $daysDiff = $due->diffInDays($today);
            return [
                'label' => 'Overdue ' . $daysDiff . ' Day' . ($daysDiff > 1 ? 's' : ''),
                'color' => 'danger'
            ];
        }

        return ['label' => '-', 'color' => 'gray'];
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'Waiting Received' => 'yellow',
            'Received' => 'blue',
            'Completed' => 'green',
            'Rejected' => 'red',
            default => 'gray',
        };
    }

    /**
     * Check if user can receive this submission
     */
    public function canReceive()
    {
        return $this->status === 'Waiting Received' && auth()->user()->can('receive submissions');
    }

    /**
     * Check if can mark as distributed
     */
    public function canMarkDistributed()
    {
        return $this->status === 'Received' && $this->status_distribute !== 'Distributed';
    }

    /**
     * Check if can edit (within 24 hours)
     */
    public function canEdit()
    {
        return Carbon::now()->diffInMinutes($this->created_at) < 1440;
    }

    /**
     * Check if can delete (within 24 hours)
     */
    public function canDelete()
    {
        return Carbon::now()->diffInMinutes($this->created_at) < 1440;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::id();
            if (!$model->status) {
                $model->status = 'Waiting Received';
            }
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}