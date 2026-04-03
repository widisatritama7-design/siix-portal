<?php

namespace App\Models\ESD\Stock;

use App\Models\ESD\Stock\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Material extends Model
{
    use HasFactory;

    protected $table = 'tb_esd_materials';

    protected $fillable = [
        'sap_code',
        'description',
        'type',
        'qty_first',
        'in',
        'out',
        'last_stock',
        'minimum_stock',
        'unit',
        'information',
        'assign_request',
        'qty_request',
        'remarks',
        'consumable',
        'pic'
    ];

    protected $casts = [
        'qty_first' => 'integer',
        'in' => 'integer',
        'out' => 'integer',
        'last_stock' => 'integer',
        'minimum_stock' => 'integer',
        'unit',
        'information',
        'price',
        'total_price',
        'pic' => 'array',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}
