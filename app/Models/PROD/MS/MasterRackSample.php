<?php

namespace App\Models\PROD\MS;

use App\Models\PROD\MS\MasterSample;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MasterRackSample extends Model
{
    use HasFactory;

    protected $table = 'tb_prod_master_rack_samples';

    protected $fillable = [
        'type_rack',
        'column_rack',
        'sheet_rack',
    ];

    public function samples()
    {
        return $this->hasMany(MasterSample::class, 'rack_id');
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
