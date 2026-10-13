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
        'pcb_type',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'pcb_type'   => 'array', // auto encode/decode JSON
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Opsi PCB Type yang tersedia
     */
    public const PCB_TYPES = [
        'SINGLE' => 'Single',
        'LH'     => 'LH',
        'RH'     => 'RH',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Accessor label untuk ditampilkan (mis. "LH, RH")
     */
    public function getPcbTypeLabelAttribute(): string
    {
        $types = $this->pcb_type ?? [];
        if (empty($types)) {
            return '-';
        }
        return implode(', ', $types);
    }
}