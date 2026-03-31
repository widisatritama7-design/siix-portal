<?php

namespace App\Models\ESD\Magazine;

use App\Models\ESD\Magazine\Magazine;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MagazineDetail extends Model
{
    use HasFactory;

    protected $table = 'tb_esd_magazine_details';

    protected $fillable = [
        'magazines_id',
        'm1',
        'm1_scientific',
        'judgement_m1',
        'm2',
        'judgement_m2',
        'remarks',
        'next_date'
    ];

    public function magazine()
    {
        return $this->belongsTo(Magazine::class, 'magazines_id');
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
