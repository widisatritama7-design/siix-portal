<?php

namespace App\Models;

use App\Models\EspDeviceLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'name',
        'status',
        'ip_address',
        'rssi',
        'uptime_seconds',
        'last_seen_at',
        'locker_data'
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
        'locker_data' => 'array',
        'uptime_seconds' => 'integer',
        'rssi' => 'integer'
    ];

    // ============ RELASI ============
    public function logs()
    {
        return $this->hasMany(EspDeviceLog::class);
    }

    // ============ SCOPE ============
    public function scopeOnline($query)
    {
        return $query->where('status', 'connected')
                     ->where('last_seen_at', '>=', now()->subMinutes(2));
    }

    public function scopeOffline($query)
    {
        return $query->where('status', 'disconnected')
                     ->orWhere('last_seen_at', '<', now()->subMinutes(2));
    }

    // ============ ACCESSORS ============
    public function getIsOnlineAttribute(): bool
    {
        return $this->status === 'connected' 
            && $this->last_seen_at 
            && $this->last_seen_at->diffInMinutes(now()) < 2;
    }

    public function getUptimeHumanAttribute(): string
    {
        if (!$this->uptime_seconds) return '-';
        
        $days = floor($this->uptime_seconds / 86400);
        $hours = floor(($this->uptime_seconds % 86400) / 3600);
        $minutes = floor(($this->uptime_seconds % 3600) / 60);
        
        $parts = [];
        if ($days > 0) $parts[] = $days . 'd';
        if ($hours > 0) $parts[] = $hours . 'h';
        if ($minutes > 0) $parts[] = $minutes . 'm';
        
        return implode(' ', $parts) ?: '< 1m';
    }

    public function getLockersAttribute(): array
    {
        return $this->locker_data ?? [];
    }

    // ============ METHODS ============
    public function getLockerStatus(string $code): ?array
    {
        foreach ($this->lockers as $locker) {
            if ($locker['code'] === $code) {
                return $locker;
            }
        }
        return null;
    }

    public function updateStatus(): void
    {
        $this->status = $this->is_online ? 'connected' : 'disconnected';
        $this->save();
    }
}