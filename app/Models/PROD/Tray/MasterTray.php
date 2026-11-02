<?php

namespace App\Models\PROD\Tray;

use App\Models\QAQC\BlindTest\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class MasterTray extends Model
{
    protected $table = 'tb_prod_master_tray';

    protected $fillable = [
        'master_rack_id',
        'master_locator_id',
        'customer_id',
        'part_number_tray',
        'item_code_sap',
        'desc',
        'model',
        'cav_tray',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'cav_tray' => 'integer',
    ];

    public function rack(): BelongsTo
    {
        return $this->belongsTo(MasterRack::class, 'master_rack_id');
    }

    public function locator(): BelongsTo
    {
        return $this->belongsTo(MasterLocator::class, 'master_locator_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'master_tray_id');
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