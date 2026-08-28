<?php

namespace App\Models\MTC\Daily;

use App\Models\MTC\Master\MasterLine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyFujiStandardCheckHistory extends Model
{
    use HasFactory;

    protected $table = 'tb_mtc_daily_fuji_standard_check_histories';

    protected $fillable = [
        'standard_check_id',
        'master_line_id',
        'user_id',
        'action',
        'changes',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function standardCheck()
    {
        return $this->belongsTo(DailyFujiStandardCheck::class, 'standard_check_id');
    }

    public function masterLine()
    {
        return $this->belongsTo(MasterLine::class, 'master_line_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}