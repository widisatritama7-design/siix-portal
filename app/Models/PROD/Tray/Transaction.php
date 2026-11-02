<?php

namespace App\Models\PROD\Tray;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ⬅ Tambahkan
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use SoftDeletes; // ⬅ Tambahkan

    protected $table = 'tb_prod_transaction';

    protected $fillable = [
        'master_tray_id',
        'transaction_type',
        'qty_in',
        'qty_out',
        'reason',
        'delete_reason', // ⬅ Tambahkan
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'qty_in'  => 'integer',
        'qty_out' => 'integer',
    ];

    public function tray(): BelongsTo
    {
        return $this->belongsTo(MasterTray::class, 'master_tray_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}