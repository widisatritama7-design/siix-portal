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
        'qty',
        'status', // Tambahkan status di fillable
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'price' => 'decimal:2',
        'qty' => 'integer',
    ];

    // Konstanta untuk status
    const STATUS_MANUAL = 'Manual';
    const STATUS_SYSTEM = 'System';
    const STATUS_NOT_USE = 'Not Use';

    // Array semua status
    const STATUSES = [
        self::STATUS_MANUAL,
        self::STATUS_SYSTEM,
        self::STATUS_NOT_USE,
    ];

    // Array status dengan label
    const STATUS_LABELS = [
        self::STATUS_MANUAL => 'Manual',
        self::STATUS_SYSTEM => 'System (Misc)',
        self::STATUS_NOT_USE => 'Not Use',
    ];

    // Array status dengan warna badge
    const STATUS_COLORS = [
        self::STATUS_MANUAL => 'blue',
        self::STATUS_SYSTEM => 'green',
        self::STATUS_NOT_USE => 'gray',
    ];

    // Array status dengan icon
    const STATUS_ICONS = [
        self::STATUS_MANUAL => 'user',
        self::STATUS_SYSTEM => 'cpu-chip',
        self::STATUS_NOT_USE => 'x-mark',
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

    // Accessor untuk status dengan label
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    // Accessor untuk status dengan warna
    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'gray';
    }

    // Accessor untuk status dengan icon
    public function getStatusIconAttribute(): string
    {
        return self::STATUS_ICONS[$this->status] ?? 'circle';
    }

    // Accessor untuk mengecek apakah status aktif
    public function getIsActiveAttribute(): bool
    {
        return $this->status !== self::STATUS_NOT_USE;
    }

    // Accessor untuk mengecek apakah status Manual
    public function getIsManualAttribute(): bool
    {
        return $this->status === self::STATUS_MANUAL;
    }

    // Accessor untuk mengecek apakah status System
    public function getIsSystemAttribute(): bool
    {
        return $this->status === self::STATUS_SYSTEM;
    }

    // Accessor untuk mengecek apakah status Not Use
    public function getIsNotUseAttribute(): bool
    {
        return $this->status === self::STATUS_NOT_USE;
    }

    // Scope untuk filter status
    public function scopeManual($query)
    {
        return $query->where('status', self::STATUS_MANUAL);
    }

    public function scopeSystem($query)
    {
        return $query->where('status', self::STATUS_SYSTEM);
    }

    public function scopeNotUse($query)
    {
        return $query->where('status', self::STATUS_NOT_USE);
    }

    public function scopeActive($query)
    {
        return $query->where('status', '!=', self::STATUS_NOT_USE);
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
            if ($model->status === null) {
                $model->status = self::STATUS_MANUAL; // Default status Manual
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::user()->name;
            }
        });
    }
}