<?php

namespace App\Models\DCC;

use App\Models\DCC\Submission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Department extends Model
{
    use HasFactory;

    protected $table = "tb_dcc_departments";

    protected $fillable = ['dept_name', 'emails'];

    protected $casts = [
        'emails' => 'array',
    ];

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'dept', 'dept_name');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getEmailsListAttribute()
    {
        if (is_string($this->emails)) {
            // Handle string with commas
            return array_map('trim', explode(',', $this->emails));
        }
        return $this->emails ?? [];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::id();
            // Convert array to JSON string if needed
            if (is_array($model->emails)) {
                $model->emails = json_encode($model->emails);
            }
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
            // Convert array to JSON string if needed
            if (is_array($model->emails)) {
                $model->emails = json_encode($model->emails);
            }
        });
    }
}