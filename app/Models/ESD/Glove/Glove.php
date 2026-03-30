<?php

namespace App\Models\ESD\Glove;

use App\Models\ESD\Glove\GloveDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Glove extends Model 
{
    use HasFactory;

    protected $table = 'tb_esd_gloves';
    
    protected $fillable =['sap_code','description','delivery' , 'status'];

    public function gloveDetails()
    {
        return $this->hasMany(GloveDetail::class);
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
