<?php

namespace App\Models\PROD\WIP;

use App\Models\PROD\WIP\DetailWip;
use App\Models\PROD\WIP\MasterModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MasterWip extends Model
{
    use HasFactory;

    protected $table = 'tb_prod_master_wips';

    protected $fillable = [
        'model',
        'part_number',
        'dj', 
        'lot_qty',
        'acceptance_status',
        'approval',
        'created_by', 
        'updated_by'
    ]; 

    public function masterModels()
    {
        return $this->belongsTo(MasterModel::class, 'model');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detailWips()
    {
        return $this->hasMany(DetailWip::class, 'master_wips_id');
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

    public function getStatus()
    {
        $latestDetail = $this->detailWips()->latest()->first();
        
        if (!$latestDetail) {
            return 'Open';
        }
        
        return $latestDetail->status;
    }

    public function isFinished()
    {
        return $this->getStatus() === 'Finished';
    }

    public function isInProgress()
    {
        return $this->getStatus() === 'In Progress';
    }

    public function isOpen()
    {
        return $this->detailWips()->count() === 0;
    }

    public function getLatestStatus()
    {
        return $this->detailWips()
                    ->orderBy('created_at', 'desc')
                    ->first()
                    ->status ?? 'Default Status';
    }

}
