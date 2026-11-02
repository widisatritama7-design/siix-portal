<?php

namespace App\Models\PROD\Tray;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterLocator extends Model
{
    protected $table = 'tb_prod_master_locator';

    protected $fillable = [
        'master_rack_id',
        'locator_number',
        'created_by',
        'updated_by',
    ];

    public function rack(): BelongsTo
    {
        return $this->belongsTo(MasterRack::class, 'master_rack_id');
    }

    public function trays(): HasMany
    {
        return $this->hasMany(MasterTray::class, 'master_locator_id');
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