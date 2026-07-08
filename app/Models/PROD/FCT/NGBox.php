<?php

namespace App\Models\PROD\FCT;

use App\Models\PROD\FCT\PCB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NGBox extends Model
{
    use HasFactory;

    protected $table = 'tb_prod_ng_boxes';
    
    protected $fillable = [
        'serial_number',
        'pcb_id', // Tambahkan ini
        'blocked_at_process',
        'is_locked',
        'unlock_code',
        'locked_at', // Tambahkan ini
        'unlocked_at',
        'unlocked_by'
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'locked_at' => 'datetime',
        'unlocked_at' => 'datetime'
    ];

    // Relasi ke PCB menggunakan pcb_id
    public function pcb()
    {
        return $this->belongsTo(PCB::class, 'pcb_id', 'id');
    }

    // Relasi menggunakan serial_number (untuk backward compatibility)
    public function pcbBySerial()
    {
        return $this->belongsTo(PCB::class, 'serial_number', 'serial_number');
    }

    // Scope
    public function scopeLocked($query)
    {
        return $query->where('is_locked', true);
    }

    public function scopeUnlocked($query)
    {
        return $query->where('is_locked', false);
    }

    // Method unlock
    public function unlock($code, $unlockedBy)
    {
        if ($this->unlock_code !== $code) {
            return [
                'success' => false,
                'message' => 'Invalid unlock code'
            ];
        }

        if (!$this->is_locked) {
            return [
                'success' => false,
                'message' => 'Box is already unlocked'
            ];
        }

        try {
            $this->is_locked = false;
            $this->unlocked_at = now();
            $this->unlocked_by = $unlockedBy;
            $this->save();
            
            // Update PCB status
            if ($this->pcb) {
                $this->pcb->status = 'in_progress';
                $this->pcb->save();
            }
            
            return [
                'success' => true,
                'message' => 'Box unlocked successfully'
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error unlocking box: ' . $e->getMessage()
            ];
        }
    }

    // Generate unlock code
    public static function generateUnlockCode()
    {
        do {
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('unlock_code', $code)->exists());
        
        return $code;
    }
}