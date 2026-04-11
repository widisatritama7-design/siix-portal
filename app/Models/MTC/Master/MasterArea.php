<?php

namespace App\Models\MTC\Master;

use App\Models\MTC\Master\MasterLocation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MasterArea extends Model
{
    use HasFactory;

    protected $table = 'tb_mtc_master_areas';

    protected $fillable = ['area_name'];

    public function locations()
    {
        return $this->hasMany(MasterLocation::class, 'area_id', 'id');
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
