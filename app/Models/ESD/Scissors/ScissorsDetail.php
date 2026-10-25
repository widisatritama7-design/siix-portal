<?php

namespace App\Models\ESD\Scissors;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\ESD\Scissors\Scissors;

class ScissorsDetail extends Model 
{
    use HasFactory;

    protected $table = 'tb_esd_scissors_details';

    protected $fillable = [
        'scissors_id',
        's_1',
        's_1_scientific',
        'judgement_s_1',
        's_2',
        'judgement_s_2',
        's_3_1',         // ✅ baru
        's_3_2',
        'remarks',
        'next_date',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        's_3_1' => 'boolean',   // ✅ baru
        's_3_2' => 'boolean',   // ✅ baru
        'next_date' => 'date',
    ];

    public function scissors()
    {
        return $this->belongsTo(Scissors::class);
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