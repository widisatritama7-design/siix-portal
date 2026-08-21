<?php

namespace App\Models\ESD\Locker;

use App\Models\ESD\Locker\UniformTransaction;
use App\Models\HR\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Locker extends Model
{
    use HasFactory;

    protected $table = 'tb_esd_locker';

    protected $fillable = [
        'code',
        'status',
        'employee_id',
        'locked_until',
        'is_open',
        'opened_at'
    ];

    protected $casts = [
        'locked_until' => 'datetime',
        'is_open' => 'boolean',
        'opened_at' => 'datetime'
    ];

    // Relasi
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(UniformTransaction::class, 'locker_id');
    }

    // Cek apakah loker tersedia
    public function isAvailable()
    {
        return $this->status === 'available' && 
               ($this->locked_until === null || $this->locked_until->isPast());
    }

    // Cek apakah loker terkunci (sedang dalam proses 15 detik)
    public function isLocked()
    {
        return $this->locked_until !== null && $this->locked_until->isFuture();
    }

    // ============ SCOPE ============

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')
                     ->where(function($q) {
                         $q->whereNull('locked_until')
                           ->orWhere('locked_until', '<', now());
                     });
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeNg($query)
    {
        return $query->where('status', 'ng');
    }

    public function scopeFinished($query)
    {
        return $query->where('status', 'finished');
    }

    // ============ STATUS METHODS ============

    public function markAsOpen()
    {
        $this->update([
            'status' => 'open',
            'is_open' => true,
            'opened_at' => now()
        ]);
    }

    public function markAsInProgress()
    {
        $this->update([
            'status' => 'in_progress',
            'is_open' => true,
            'opened_at' => now()
        ]);
    }

    public function markAsNg()
    {
        $this->update([
            'status' => 'ng',
            'is_open' => false,
            'opened_at' => null
        ]);
    }

    public function markAsFinished()
    {
        $this->update([
            'status' => 'finished',
            'is_open' => true,
            'opened_at' => now()
        ]);
    }

    public function markAsAvailable()
    {
        $this->update([
            'status' => 'available',
            'employee_id' => null,
            'locked_until' => null,
            'is_open' => false,
            'opened_at' => null
        ]);
    }

    // ============ METODE UNTUK API ESP32 ============
    
    /**
     * Update status loker terbuka (dipanggil oleh ESP32)
     */
    public function setOpen()
    {
        $this->update([
            'is_open' => true,
            'opened_at' => now()
        ]);
    }

    /**
     * Update status loker tertutup (dipanggil oleh ESP32)
     */
    public function setClosed()
    {
        $this->update([
            'is_open' => false,
            'opened_at' => null
        ]);
    }

    /**
     * Cek apakah loker HARUS terbuka (untuk ESP32)
     * TRUE = buka relay
     * FALSE = tutup relay
     */
    public function shouldBeOpen()
    {
        // Jika status available tapi locked_until future (sedang proses buka)
        if ($this->status === 'available' && $this->locked_until !== null && $this->locked_until->isFuture()) {
            return true;
        }
        
        $statusesThatNeedOpen = ['open', 'in_progress', 'finished'];
        
        if (in_array($this->status, $statusesThatNeedOpen)) {
            if ($this->locked_until === null) {
                return false;
            }
            
            if ($this->locked_until->isFuture()) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Auto close - dipanggil oleh Job setelah 15 detik
     */
    public function autoClose()
    {
        // Cek apakah loker masih dalam status yang membutuhkan terbuka
        // Jika sudah expired, tutup
        if (in_array($this->status, ['open', 'in_progress', 'finished'])) {
            if ($this->locked_until !== null && $this->locked_until->isPast()) {
                // Tutup loker secara fisik
                $this->setClosed();
                
                Log::info('Locker auto closed after 15 seconds', [
                    'code' => $this->code,
                    'status' => $this->status
                ]);
                
                // Jika status open dan sudah expired, biarkan tetap open
                // Tapi is_open = false (fisik tertutup)
                // Teknisi akan mengambil alih nanti
            }
        }
    }
}