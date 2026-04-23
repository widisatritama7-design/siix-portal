<?php

namespace App\Models\QAQC;

use App\Models\HR\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NCP extends Model
{
    use SoftDeletes;

    protected $table = 'tb_qaqc_ncp';

    protected $fillable = [
        'employee_id',
        'section',
        'ncp_number',
        'status',
        'file',
        'remarks',
        'part_description',
        'part_number',
        'supplier',
        'customer',
        'model_affected',
        'lot_no',
        'lot_qty',
        'rejected_qty',
        'failure_rate',
        'defect_details',
        'do_no',
        'packing_list_no',
        'disposition',
        'approved_by',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_reason',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'defect_details' => 'array',
        'lot_qty' => 'integer',
        'rejected_qty' => 'integer',
        'failure_rate' => 'decimal:2',
    ];

    const STATUS_OPEN = 'open';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_CLOSED = 'closed';
    const STATUS_REJECTED = 'rejected';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_OPEN => 'Open',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_CLOSED => 'Closed',
            self::STATUS_REJECTED => 'Rejected',
        ];
    }

    public function getStatusBadgeColor(): string
    {
        return match($this->status) {
            self::STATUS_OPEN => 'yellow',
            self::STATUS_IN_PROGRESS => 'blue',
            self::STATUS_CLOSED => 'green',
            self::STATUS_REJECTED => 'red',
            default => 'gray',
        };
    }

    public function getStatusText(): string
    {
        return self::getStatuses()[$this->status] ?? ucfirst($this->status);
    }

    public function calculateFailureRate(): ?float
    {
        if ($this->lot_qty && $this->lot_qty > 0 && $this->rejected_qty) {
            return ($this->rejected_qty / $this->lot_qty) * 100;
        }
        return null;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // TAMBAHKAN RELASI DELETER INI
    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function scopeOpen($query)
    {
        return $query->where('status', self::STATUS_OPEN);
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', self::STATUS_IN_PROGRESS);
    }

    public function scopeClosed($query)
    {
        return $query->where('status', self::STATUS_CLOSED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = auth()->id();
            }
            if ($model->lot_qty && $model->rejected_qty) {
                $model->failure_rate = $model->calculateFailureRate();
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
            if ($model->lot_qty && $model->rejected_qty) {
                $model->failure_rate = $model->calculateFailureRate();
            }
        });
    }
}