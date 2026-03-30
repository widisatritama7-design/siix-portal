<?php

namespace App\Models\ESD\Ionizer;

use App\Models\ESD\Ionizer\Ionizer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class IonizerDetail extends Model 
{
    use HasFactory;

    protected $table = 'tb_esd_ionizer_details';

    protected $fillable = [
        'ionizer_id',
        'area',
        'location',
        'pm_1',
        'pm_2',
        'pm_3',
        'c1_before',
        'judgement_c1_before',
        'c2_before',
        'judgement_c2_before',
        'c3_before',
        'judgement_c3_before',
        'c1',
        'judgement_c1',
        'c2',
        'judgement_c2',
        'c3',
        'judgement_c3',
        'remarks',
        'next_date',
    ];

    public function ionizer()
    {
        return $this->belongsTo(Ionizer::class);
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
