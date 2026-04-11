<?php

namespace App\Models\MTC\Master;

use App\Models\HR\Employee;
use App\Models\MTC\Daily\DailyFuji;
use App\Models\MTC\Daily\DailyPanasonic;
use App\Models\MTC\Master\MasterMachine;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MasterLine extends Model
{
    use HasFactory;

    protected $table = 'tb_mtc_master_lines';

    protected $fillable = [
        'location_id', 
        'line_number', 
        'status', 
        'nik',
        'trouble_desc', 
        'machine_type'
    ];

    protected $appends = [
        'daily_check_status',
        'daily_check_approval',
        'daily_check_last_update',
        'daily_check_group'
    ];

    public function location()
    {
        return $this->belongsTo(MasterLocation::class);
    }

    // public function historyMasterSamples()
    // {
    //     return $this->hasMany(HistoryMasterSample::class, 'master_line_id');
    // }

    public function dailyFujis()
    {
        return $this->hasMany(DailyFuji::class, 'master_line_id');
    }

    public function dailyPanasonics()
    {
        return $this->hasMany(DailyPanasonic::class, 'master_line_id');
    }

    public function machines()
    {
        return $this->hasMany(MasterMachine::class, 'line_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'ID');
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

    public function hasDailyCheckToday()
    {
        $today = now()->format('Y-m-d');
        
        switch ($this->machine_type) {
            case 'fuji':
                return $this->dailyFujis()
                    ->whereDate('created_at', $today)
                    ->exists();
                
            case 'panasonic':
                return $this->dailyPanasonics()
                    ->whereDate('created_at', $today)
                    ->exists();
                
            case 'both':
                return $this->dailyFujis()
                    ->whereDate('created_at', $today)
                    ->exists() || 
                    $this->dailyPanasonics()
                    ->whereDate('created_at', $today)
                    ->exists();
                
            default:
                return false;
        }
    }

    public function getDailyCheckStatusAttribute(): string
    {
        $latestRecord = $this->getLatestDailyCheckRecord();
        
        if (!$latestRecord) {
            return 'No Check';
        }
        
        return $latestRecord->status ?? 'No Check';
    }

    public function getDailyCheckApprovalAttribute(): string
    {
        $latestRecord = $this->getLatestDailyCheckRecord();
        
        if (!$latestRecord) {
            return 'No Check';
        }
        
        return $latestRecord->approval ?? 'Pending';
    }

    public function getDailyCheckLastUpdateAttribute(): ?string
    {
        $latestRecord = $this->getLatestDailyCheckRecord();
        
        return $latestRecord?->updated_at?->format('d M Y H:i');
    }

    public function getDailyCheckGroupAttribute(): ?string
    {
        $latestRecord = $this->getLatestDailyCheckRecord();
        
        return $latestRecord?->group;
    }

    public function getDailyCheckStatusColorAttribute(): string
    {
        return match($this->daily_check_status) {
            'Checked' => 'success',
            'On Progress' => 'warning',
            'Delay' => 'danger',
            'No Check' => 'gray',
            default => 'gray'
        };
    }

    public function getDailyCheckApprovalColorAttribute(): string
    {
        return match($this->daily_check_approval) {
            'Approved' => 'success',
            'Rejected' => 'danger',
            'Pending' => 'warning',
            'No Check' => 'gray',
            default => 'gray'
        };
    }

    private function getLatestDailyCheckRecord()
    {
        $latestFuji = $this->dailyFujis()->latest()->first();
        $latestPanasonic = $this->dailyPanasonics()->latest()->first();
        
        $latestRecord = null;
        $latestDate = null;
        
        if ($latestFuji && (!$latestDate || $latestFuji->created_at->gt($latestDate))) {
            $latestRecord = $latestFuji;
            $latestDate = $latestFuji->created_at;
        }
        
        if ($latestPanasonic && (!$latestDate || $latestPanasonic->created_at->gt($latestDate))) {
            $latestRecord = $latestPanasonic;
            $latestDate = $latestPanasonic->created_at;
        }
        
        return $latestRecord;
    }

    public function getHasDailyCheckAttribute(): bool
    {
        return $this->dailyFujis()->exists() || $this->dailyPanasonics()->exists();
    }

    public function getTodayDailyCheckStatusAttribute(): string
    {
        $today = now()->format('Y-m-d');
        
        $todayFuji = $this->dailyFujis()->whereDate('updated_at', $today)->latest()->first();
        $todayPanasonic = $this->dailyPanasonics()->whereDate('updated_at', $today)->latest()->first();
        
        $todayRecord = null;
        $latestDate = null;
        
        if ($todayFuji && (!$latestDate || $todayFuji->updated_at->gt($latestDate))) {
            $todayRecord = $todayFuji;
            $latestDate = $todayFuji->updated_at;
        }
        
        if ($todayPanasonic && (!$latestDate || $todayPanasonic->updated_at->gt($latestDate))) {
            $todayRecord = $todayPanasonic;
            $latestDate = $todayPanasonic->updated_at;
        }
        
        return $todayRecord?->status ?? 'No Check Today';
    }
}