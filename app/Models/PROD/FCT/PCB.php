<?php

namespace App\Models\PROD\FCT;

use App\Models\PROD\FCT\NGBox;
use App\Models\PROD\FCT\ScanLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PCB extends Model
{
    use HasFactory;

    protected $table = 'tb_prod_pcbs';
    
    protected $fillable = [
        'serial_number',
        'status',
        'current_process',
        'fct_completed',
        'led_test_completed',
        'visual_inspection_completed',
        'fct_completed_at',
        'led_test_completed_at',
        'visual_inspection_completed_at'
    ];

    protected $casts = [
        'fct_completed' => 'boolean',
        'led_test_completed' => 'boolean',
        'visual_inspection_completed' => 'boolean',
        'fct_completed_at' => 'datetime',
        'led_test_completed_at' => 'datetime',
        'visual_inspection_completed_at' => 'datetime'
    ];

    // Relasi ke ScanLog menggunakan pcb_id
    public function scanLogs()
    {
        return $this->hasMany(ScanLog::class, 'pcb_id', 'id');
    }

    // Relasi ke NGBox menggunakan pcb_id
    public function ngBoxes()
    {
        return $this->hasMany(NGBox::class, 'pcb_id', 'id');
    }

    public function ngBox()
    {
        return $this->hasOne(NGBox::class, 'pcb_id', 'id')->where('is_locked', true);
    }

    // Method untuk cek proses
    public function canProceedToNextProcess($nextProcess)
    {
        switch ($nextProcess) {
            case 'fct':
                return true;
            case 'led_test':
                return $this->fct_completed;
            case 'visual_inspection':
                return $this->led_test_completed;
            default:
                return false;
        }
    }

    // Method untuk complete process
    public function completeProcess($process)
    {
        switch ($process) {
            case 'fct':
                $this->fct_completed = true;
                $this->fct_completed_at = now();
                $this->current_process = 'fct';
                break;
            case 'led_test':
                $this->led_test_completed = true;
                $this->led_test_completed_at = now();
                $this->current_process = 'led_test';
                break;
            case 'visual_inspection':
                $this->visual_inspection_completed = true;
                $this->visual_inspection_completed_at = now();
                $this->current_process = 'visual_inspection';
                break;
            default:
                return false;
        }
        
        // Cek apakah semua proses selesai
        if ($this->fct_completed && $this->led_test_completed && $this->visual_inspection_completed) {
            $this->status = 'completed';
            $this->current_process = 'completed';
        } else {
            $this->status = 'in_progress';
        }
        
        $this->save();
        return true;
    }

    public function block($process)
    {
        $this->status = 'blocked';
        $this->current_process = $process;
        $this->save();
    }

    // Scope
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeBlocked($query)
    {
        return $query->where('status', 'blocked');
    }
}