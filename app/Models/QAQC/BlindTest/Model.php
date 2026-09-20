<?php

namespace App\Models\QAQC\BlindTest;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Model extends EloquentModel
{
    protected $table = 'tb_qaqc_model';

    protected $fillable = [
        'customer_id',
        'model_name',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke Customer
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
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