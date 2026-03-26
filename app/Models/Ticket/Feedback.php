<?php

namespace App\Models\Ticket;

use App\Models\Ticket\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'tb_tc_feedback';

    protected $fillable = [
        'ticket_id',
        'user_id',
        'status',
        'comments',
        'photo',
        'email_user',
        'file',
    ];

    protected $casts = [
        'photo' => 'array',
        'file' => 'array'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::updating(function ($feedback) {
            // Update the ticket status when feedback status changes
            if ($feedback->isDirty('status')) {
                $ticket = $feedback->ticket; // Get the ticket through relationship
                if ($ticket) {
                    $ticket->status = $feedback->status;
                    
                    // Set closed_at if status is Closed
                    if ($feedback->status === 'Closed') {
                        $ticket->closed_at = Carbon::now('Asia/Jakarta');
                    } elseif ($ticket->closed_at) {
                        $ticket->closed_at = null;
                    }
                    
                    $ticket->save(); // Save the ticket
                }
            }
        });
    }
}