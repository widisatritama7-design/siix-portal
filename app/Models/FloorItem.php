<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FloorItem extends Model
{
    use HasFactory;

    protected $table = 'tb_floor_items';
    protected $guarded = [];

    // TAMBAHKAN INI
    protected $casts = [
        'config' => 'array',
        'points' => 'array', // Agar points otomatis jadi array
    ];

    public function floorPlan(): BelongsTo
    {
        return $this->belongsTo(FloorPlan::class, 'floor_plan_id');
    }
}