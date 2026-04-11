<?php

namespace App\Models\MTC\Master;

use App\Models\MTC\Master\MasterArea;
use App\Models\MTC\Master\MasterLine;
use App\Models\MTC\Master\MasterMachine;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MasterLocation extends Model
{
    use HasFactory;

    protected $table = 'tb_mtc_master_locations';

    protected $fillable = ['area_id', 'location_name', 'photo'];

    public function area()
    {
        return $this->belongsTo(MasterArea::class, 'area_id', 'id');
    }

    public function machines()
    {
        return $this->hasMany(MasterMachine::class, 'location_id', 'id');
    }

    public function lines()
    {
        return $this->hasMany(MasterLine::class, 'location_id', 'id');
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
