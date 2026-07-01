<?php

namespace App\Models\PROD\Uniform;

use App\Models\PROD\Uniform\UniformStockTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MasterUniform extends Model
{
    use HasFactory;

    protected $table = 'tb_prod_master_uniform';

    protected $fillable = [
        'item_code',
        'description',
        'size',
        'price',
        'qty', // Tambahkan kolom qty
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'price' => 'decimal:2',
        'qty' => 'integer',
    ];

    public function getFormattedItemCodeAttribute(): string
    {
        return strtoupper($this->item_code);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->description} - {$this->size}";
    }

    public function getDisplayNameAttribute(): string
    {
        return "[{$this->item_code}] {$this->description} ({$this->size})";
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getPriceAttribute($value)
    {
        return (float) $value;
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (float) str_replace(',', '', $value);
    }

    public function getQtyAttribute($value)
    {
        return (int) $value;
    }

    // Relasi ke User
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'name');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'name');
    }

    // Relasi ke UniformRequest
    public function uniformRequests()
    {
        return $this->hasMany(UniformRequest::class, 'master_uniform_id');
    }

    // Relasi ke Stock Transaction
    public function stockTransactions()
    {
        return $this->hasMany(UniformStockTransaction::class, 'master_uniform_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::user()->name;
                $model->updated_by = Auth::user()->name;
            }
            if ($model->qty === null) {
                $model->qty = 0;
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::user()->name;
            }
        });
    }
}