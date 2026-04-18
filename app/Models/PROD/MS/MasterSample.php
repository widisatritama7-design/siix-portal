<?php

namespace App\Models\PROD\MS;

use App\Models\HR\Employee;
use App\Models\PROD\MS\DetailMasterSample;
use App\Models\PROD\MS\HistoryMasterSample;
use App\Models\PROD\MS\MasterRackSample;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MasterSample extends Model
{
    use HasFactory;
    
    protected $table = 'tb_prod_master_samples';

    protected $fillable = [
        'model_name',
        'customer',
        'sample_ok',
        'sample_ok_backup',
        'sample_ng',
        'sample_blank',
        'name_or_mc',
        'rack_id',
        'rack_backup',
        'remarks',
        'qr_sample_ok',
        'qr_sample_ng',
        'qr_sample_blank',
        'qr_sample_ok_backup',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'id');
    }

    public function rack()
    {
        return $this->belongsTo(MasterRackSample::class, 'rack_id');
    }

    public function details()
    {
        return $this->hasMany(DetailMasterSample::class, 'master_sample_id');
    }

    public function historydDetails()
    {
        return $this->hasMany(HistoryMasterSample::class, 'master_sample_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function latestDetail()
    {
        return $this->hasOne(DetailMasterSample::class)->latestOfMany('expired_date');
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
