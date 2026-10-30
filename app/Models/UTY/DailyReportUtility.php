<?php

namespace App\Models\UTY;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyReportUtility extends Model
{
    use HasFactory;

    protected $table = 'tb_uty_daily_report_utility';

    protected $fillable = [
        'shift',
        'report_category',
        'problem_desc',
        'photo_before',
        'action_desc',
        'photo_after',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'shift'        => 'integer',
        'photo_before' => 'array',
        'photo_after'  => 'array',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}