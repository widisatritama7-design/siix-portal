<?php

namespace App\Models\Ticket;

use App\Models\Ticket\CategoryTicket;
use App\Models\Ticket\Feedback;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tb_tc_tickets';

    protected $fillable = [
        'title',
        'description',
        'file',
        'status',
        'priority',
        'category_id',
        'assigned_role',
        'approval',
        'approval_at',
        'approval_user',
        'approval_user_at',
        'comment_manager',
        'comments_user',
        'name',
        'email_user',
        'registration_no'
    ];

    protected $dates = [
        'closed_at',
    ];

    protected $casts = [
        'file' => 'array',
    ];

    public function getActivityTimeline(): array
    {
        $status = strtolower($this->status);

        $activities = [];

        $activities[] = [
            'title' => 'Ticket Created - New Issue Reported',
            'description' => 'A new ticket has been submitted by the user.',
            'status' => 'open',
            'created_at' => $this->created_at,
        ];

        if (in_array($status, ['in progress', 'pending', 'closed'])) {
            $activities[] = [
                'title' => 'Ticket In Progress - Technician Assigned',
                'description' => 'Ticket is currently being handled.',
                'status' => 'in_progress',
                'created_at' => $this->updated_at,
            ];
        }

        if (in_array($status, ['pending', 'closed'])) {
            $activities[] = [
                'title' => 'Ticket Pending - Waiting for User Response',
                'description' => 'Waiting on additional input from the user.',
                'status' => 'pending',
                'created_at' => $this->updated_at,
            ];
        }

        if ($status === 'closed') {
            $activities[] = [
                'title' => 'Ticket Closed - Issue Resolved',
                'description' => 'The ticket has been resolved and marked as closed.',
                'status' => 'closed',
                'created_at' => $this->closed_at ?? now(),
            ];
        }

        return $activities;
    }
    
    public function category()
    {
        return $this->belongsTo(CategoryTicket::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->ticket_number = self::generateTicketNumber();
            $model->created_by = Auth::id();
            
            $model->approval = 'Waiting Approval';
            $model->approval_user = 'Waiting Approval';
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();

            if ($model->isDirty('status') && $model->status === 'Closed') {
                $model->closed_at = Carbon::now('Asia/Jakarta');
            } elseif ($model->isDirty('status') && $model->status !== 'Closed') {
                $model->closed_at = null;
            }
        });
    }

    public static function generateTicketNumber()
    {
        $today = Carbon::today()->format('d-m-Y');
        $latestTicket = self::whereDate('created_at', Carbon::today())->latest('id')->first();

        if ($latestTicket) {
            $latestNumber = intval(substr($latestTicket->ticket_number, -4)) + 1;
        } else {
            $latestNumber = 1;
        }

        return sprintf('TC/%s/%04d', $today, $latestNumber);
    }

    public function getFileUrlAttribute()
    {
        return Storage::url($this->photo_before);
    }    

    public function assignToRole($role)
    {
        $this->assigned_role = $role;
        $this->save();
    }
}
