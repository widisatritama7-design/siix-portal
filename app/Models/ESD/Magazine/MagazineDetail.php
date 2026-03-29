<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Magazine;

class MagazineDetail extends Model
{
    use HasFactory;

    protected $connection = 'mysql_esd'; // Koneksi database yang digunakan
    protected $table = 'magazine_details'; // Nama tabel

    protected $fillable = [
        'magazines_id',
        'm1',
        'm1_scientific',
        'judgement_m1',
        'm2',
        'judgement_m2',
        'remarks',
        'next_date'
    ];

    /**
     * Relasi dengan model Magazines
     */
    public function magazine()
    {
        return $this->belongsTo(Magazine::class, 'magazines_id');
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
