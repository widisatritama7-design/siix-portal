<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Jig;

class JigDetail extends Model
{
    use HasFactory;

    protected $connection = 'mysql_esd'; // Koneksi database yang digunakan
    protected $table = 'jig_details'; // Nama tabel

    protected $fillable = [
        'jigs_id',
        'location',
        'j1',
        'judgement_j1',
        'j2',
        'judgement_j2',
        'next_date',
        'created_by',
        'updated_by',
        'remarks'
    ];

    /**
     * Relasi dengan model Jigs
     */
    public function jig()
    {
        return $this->belongsTo(Jig::class, 'jigs_id');
    }

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
            if (empty($model->created_by)) {
                $model->created_by = Auth::id();
            }
        });

        // Set the updater on updating event
        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }

    // Anda dapat menambahkan relasi lain jika diperlukan
}
