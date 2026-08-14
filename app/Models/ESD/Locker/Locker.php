<?php

namespace App\Models\ESD\Locker;

use App\Models\ESD\Locker\UniformTransaction;
use App\Models\HR\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    use HasFactory;

    protected $table = 'tb_esd_locker';

    protected $fillable = [
        'code',
        'status',
        'employee_id',
        'locked_until'
    ];

    protected $casts = [
        'locked_until' => 'datetime'
    ];

    // Relasi ke Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    // Relasi ke UniformTransaction
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

    // Cek apakah loker terkunci
    public function isLocked()
    {
        return $this->locked_until !== null && $this->locked_until->isFuture();
    }

    // Scope untuk loker yang available
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')
                     ->where(function($q) {
                         $q->whereNull('locked_until')
                           ->orWhere('locked_until', '<', now());
                     });
    }

    // Scope untuk loker yang open (sedang digunakan)
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    // Scope untuk loker yang in_progress (sedang diproses teknisi)
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    // Scope untuk loker yang NG (reject)
    public function scopeNg($query)
    {
        return $query->where('status', 'ng');
    }

    // Scope untuk loker yang finished (selesai)
    public function scopeFinished($query)
    {
        return $query->where('status', 'finished');
    }

    // Update status ke open (saat store)
    public function markAsOpen()
    {
        $this->update(['status' => 'open']);
    }

    // Update status ke in_progress (teknisi mengambil)
    public function markAsInProgress()
    {
        $this->update(['status' => 'in_progress']);
    }

    // Update status ke NG (teknisi menolak/reject)
    public function markAsNg()
    {
        $this->update(['status' => 'ng']);
    }

    // Update status ke finished (teknisi selesai)
    public function markAsFinished()
    {
        $this->update(['status' => 'finished']);
    }

    // Update status ke available (reset)
    public function markAsAvailable()
    {
        $this->update([
            'status' => 'available',
            'employee_id' => null,
            'locked_until' => null
        ]);
    }
}