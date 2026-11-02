<?php

namespace App\Models\PROD\Tray;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterRack extends Model
{
    protected $table = 'tb_prod_master_rack';

    protected $fillable = [
        'rack_number',
        'area',
        'created_by',
        'updated_by',
    ];

    public function locators(): HasMany
    {
        return $this->hasMany(MasterLocator::class, 'master_rack_id');
    }

    public function trays(): HasMany
    {
        return $this->hasMany(MasterTray::class, 'master_rack_id');
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