<?php

namespace App\Models\ESD\Packaging;

use App\Models\ESD\Packaging\Packaging;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PackagingDetail extends Model 
{
    use HasFactory;

    protected $table = 'tb_esd_packaging_details';
    
    protected $fillable = [
        'packaging_id','f1', 'f1_scientific', 'judgement_f1', 'f2', 'judgement_f2', 'next_date','remarks', 'created_by',
    ];

    public function packaging()
    {
        return $this->belongsTo(Packaging::class);
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
            if (empty($model->created_by)) {
                $model->created_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}
