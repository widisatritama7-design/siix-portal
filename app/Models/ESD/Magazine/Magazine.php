<?php

namespace App\Models\ESD\Magazine;

use App\Models\ESD\Magazine\MagazineDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Magazine extends Model
{
    use HasFactory;

    protected $table = 'tb_esd_magazines';

    protected $fillable = [
        'register_no','status'
    ]; 

    public function magazineDetails()
    {
        return $this->hasMany(MagazineDetail::class, 'magazines_id');
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
