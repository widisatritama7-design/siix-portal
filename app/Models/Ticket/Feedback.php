<?php

namespace App\Models\Ticket;

use App\Models\Ticket\Ticket;
use App\Models\User;
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
            $feedback->ticket()->update(['status' => $feedback->status]);
        });
    }
}
