<?php

namespace App\Models\ESD\Worksurface;

use App\Models\ESD\Worksurface\Worksurface;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WorksurfaceDetail extends Model 
{
    use HasFactory;

    protected $table = 'tb_esd_worksurface_details';

    protected $fillable = [
        'worksurface_id',
        'area',
        'location',
        'item',
        'a1',
        'a1_scientific',
        'judgement_a1',
        'a2',
        'judgement_a2',
        'a3',              // ✅ baru
        'judgement_a3',    // ✅ baru
        'a4_1',            // ✅ baru
        'a4_2',            // ✅ baru
        'a4_3',            // ✅ baru
        'a4_4',            // ✅ baru
        'a4_5',            // ✅ baru
        'remarks',
        'created_at',
        'next_date',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'a4_1' => 'boolean',
        'a4_2' => 'boolean',
        'a4_3' => 'boolean',
        'a4_4' => 'boolean',
        'a4_5' => 'boolean',
        'next_date' => 'date',
    ];

    public static function itemOptions(): array
    {
        $options = [];
        foreach (['TABLE', 'RACK', 'TROLLEY'] as $type) {
            for ($i = 1; $i <= 5; $i++) {
                $options[] = "{$type} LAYER {$i}";
            }
        }
        return $options;
    }

    public function worksurface()
    {
        return $this->belongsTo(Worksurface::class);
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
