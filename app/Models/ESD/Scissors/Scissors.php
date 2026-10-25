<?php

namespace App\Models\ESD\Scissors;

use App\Models\ESD\Scissors\ScissorsDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Scissors extends Model 
{
    use HasFactory;

    protected $table = 'tb_esd_scissors';
    
    protected $fillable = [
        'register_no',
        'area',
        'location',
        'status',
        'created_by',
        'updated_by',
    ];

    public function scissorsDetails()
    {
        return $this->hasMany(ScissorsDetail::class);
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