<?php

namespace App\Models\PROD\Patrol;

use App\Models\MTC\Master\MasterLine;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultPatrol extends Model
{
    use HasFactory;

    protected $table = 'tb_prod_result_patrol';

    protected $fillable = [
        'shift',
        'group',
        'master_line_id',
        'standard_patrol_items',
        'finding_patrol_items',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'standard_patrol_items' => 'array',
        'finding_patrol_items'  => 'array',
        'created_at'            => 'datetime',
        'updated_at'            => 'datetime',
    ];

    public function masterLine(): BelongsTo
    {
        return $this->belongsTo(MasterLine::class, 'master_line_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}