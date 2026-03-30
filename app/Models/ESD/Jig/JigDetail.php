<?php

namespace App\Models\ESD\Jig;

use App\Models\ESD\Jig\Jig;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class JigDetail extends Model
{
    use HasFactory;

    protected $table = 'tb_esd_jig_details';

    protected $fillable = [
        'jigs_id',
        'location',
        'j1',
        'judgement_j1',
        'j2',
        'judgement_j2',
        'next_date',
        'created_by',
        'updated_by',
        'remarks'
    ];

    public function jig()
    {
        return $this->belongsTo(Jig::class, 'jigs_id');
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
