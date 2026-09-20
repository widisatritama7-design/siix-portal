<?php

namespace App\Models\QAQC\BlindTest;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Deffect extends Model
{
    protected $table = 'tb_qaqc_deffect';

    protected $fillable = [
        'deffect_item_name',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke User pembuat
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi ke User yang update
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}