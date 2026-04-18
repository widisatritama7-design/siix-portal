<?php

namespace App\Models\PROD\WIP;

use App\Models\PROD\WIP\MasterWip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MasterModel extends Model
{
    use HasFactory;

    protected $table = 'tb_prod_master_models';

    protected $fillable = [
        'model',
        'customer',
        'part_number',
        'created_by',
        'updated_by',
    ];

    public function masterWips()
    {
        return $this->hasMany(MasterWip::class, 'model');
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
