<?php

namespace App\Models\PROD\Kaizen;

use App\Models\HR\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Kaizen extends Model
{
    use HasFactory;

    protected $table = 'tb_prod_kaizens';

    protected $fillable = [
        'nik',
        'name',
        'process',
        'line',
        'title',
        'description',
        'photo',
        'approval_status',
        'status_kaizen',
        'comment',
        'comment_spv',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'photo' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'id');
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
