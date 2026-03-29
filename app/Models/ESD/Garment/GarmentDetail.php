<?php

namespace App\Models\ESD\Garment;

use App\Models\User;
use App\Models\ESD\Garment\Garment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GarmentDetail extends Model 
{
    use HasFactory;

    protected $table = 'tb_esd_garment_details';

    protected $fillable = [
        'nik',
        'name',
        'd1',
        'd1_scientific',
        'judgement_d1',
        'd2',
        'd2_scientific',
        'judgement_d2',
        'd3',
        'd3_scientific',
        'judgement_d3',
        'd4',
        'd4_scientific',
        'judgement_d4',
        'next_date',
        'remarks',
    ];

    public function garment()
    {
        return $this->belongsTo(Garment::class, 'nik', 'id');
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
