<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspDeviceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'esp_device_id',
        'status',
        'rssi',
        'locker_data'
    ];

    protected $casts = [
        'locker_data' => 'array',
        'rssi' => 'integer'
    ];

    // ============ RELASI ============
    public function device()
    {
        return $this->belongsTo(EspDevice::class);
    }

    // ============ SCOPE ============
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}