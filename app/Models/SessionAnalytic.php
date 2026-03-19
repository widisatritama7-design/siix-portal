<?php
// app/Models/SessionAnalytic.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionAnalytic extends Model
{
    protected $table = 'session_analytics';
    
    protected $fillable = [
        'user_id', 'login_at', 'logout_at', 'duration_seconds', 'ip_address', 'user_agent'
    ];

    protected $casts = [
        'login_at' => 'datetime',
        'logout_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getDurationMinutesAttribute()
    {
        return $this->duration_seconds ? round($this->duration_seconds / 60, 1) : null;
    }
}