<?php

namespace App\Models;

use App\Models\Soldering;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SolderingDetail extends Model
{
    use HasFactory;

    protected $connection = 'mysql_esd';

    protected $fillable = [
        'soldering_id',
        'area',
        'location',
        'actual_setting',
        'actual_temp',
        'e1',
        'e2',
        'tip_condition',
        'stand_condition',
        'judgement',
        'judgement_e2',
        'remarks',
        'problem',
        'action',
        'result',
        'next_date',
        'spec',
        'line',
        'running_customer',
        'shift',
        'judgement_temp',
        'running_status',
        'overall_judgement',
        'created_by',
        'updated_by'
    ];

    public function soldering()
    {
        return $this->belongsTo(Soldering::class);
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
                $model->created_by = Auth::id() ?? 267;
            }
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id() ?? 267;  // Default to 267 if no user is logged in
        });

        static::saved(function ($detail) {
            $soldering = $detail->soldering;

            if ($soldering) {
                $updates = [];

                if (!empty($detail->spec)) {
                    $updates['spec'] = $detail->spec;
                }

                if (!empty($detail->line)) {
                    $updates['line'] = $detail->line;
                }

                if (!empty($detail->running_customer)) {
                    $updates['running_customer'] = $detail->running_customer;
                }

                if (!empty($updates)) {
                    $soldering->update($updates);
                }

                // Update the `last_measured` field to the latest `created_at` of the `SolderingDetail`
                $latestMeasured = $soldering->solderingDetails()
                    ->latest('created_at')
                    ->value('created_at');

                $soldering->update([
                    'last_measured' => $latestMeasured
                ]);
            }
        });
    }
}
