<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WristStrap extends Model
{
    use HasFactory;

    // Jika koneksi menggunakan 'mysql_esd'
    protected $connection = 'mysql_esd';

    // Nama tabel jika berbeda dari default (plural nama model)
    protected $table = 'wrist_straps';

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'register_no',
        'result',
        'result_scientific',
        'judgement',
        'remarks',
        'type',
        'next_date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the transaction.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Boot method to attach model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Set the creator on creating event
        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });

        // Set the updater on updating event
        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}
