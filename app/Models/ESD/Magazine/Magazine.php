<?php

namespace App\Models;

use App\Models\User;
use App\Models\ActivityLog;
use App\Models\MagazineDetail;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Magazine extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $connection = 'mysql_esd'; // Koneksi yang digunakan
    protected $table = 'magazines'; // Nama tabel

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'register_no','status'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['register_no','status']);
    }

    public function activityLog()
    {
        return $this->hasMany(ActivityLog::class, 'subject_id', 'id');
    }    

    // public function magazineDetails()
    // {
    //     return $this->hasMany(MagazineDetail::class);
    // }

    public function magazineDetails()
    {
        return $this->hasMany(MagazineDetail::class, 'magazines_id');
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
            $model->created_by = Auth::id();
        });

        // Set the updater on updating event
        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}
