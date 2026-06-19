<?php

namespace App\Models\PROD\Uniform;

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
        'price', // Tambahkan ini
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'price' => 'decimal:2', // Untuk formatting 2 desimal
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

    // Accessor untuk format price dengan Rupiah (IDR)
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Accessor untuk price tanpa format (untuk input)
    public function getPriceAttribute($value)
    {
        return (float) $value;
    }

    // Mutator untuk memastikan price disimpan sebagai decimal
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (float) str_replace(',', '', $value);
    }

    // Relasi ke User untuk created_by (by name)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'name');
    }

    // Relasi ke User untuk updated_by (by name)
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'name');
    }

    // Relasi ke UniformRequest (opsional, untuk melihat request yang memuat uniform ini)
    public function uniformRequests()
    {
        return $this->hasMany(UniformRequest::class, 'master_uniform_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::user()->name;
                $model->updated_by = Auth::user()->name;
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::user()->name;
            }
        });
    }
}