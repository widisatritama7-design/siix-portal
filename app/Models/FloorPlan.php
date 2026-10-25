<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FloorPlan extends Model
{
    use HasFactory;

    // Sesuaikan dengan nama tabel di database kamu
    protected $table = 'tb_floor_plans';
    
    // Izinkan semua kolom diisi
    protected $guarded = [];

    // Relasi: 1 FloorPlan punya banyak FloorItem (kotak-kotak)
    public function items(): HasMany
    {
        return $this->hasMany(FloorItem::class, 'floor_plan_id');
    }
}