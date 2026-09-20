<?php

namespace App\Models\QAQC\BlindTest;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class Customer extends Model
{
    protected $table = 'tb_qaqc_customer';

    protected $fillable = [
        'customer_name',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke Model
     */
    public function models(): HasMany
    {
        return $this->hasMany(Model::class, 'customer_id');
    }

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