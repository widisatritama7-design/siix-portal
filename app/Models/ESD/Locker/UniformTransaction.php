<?php

namespace App\Models\ESD\Locker;

use App\Models\HR\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniformTransaction extends Model
{
    use HasFactory;

    protected $table = 'tb_esd_uniform_transactions';

    protected $fillable = [
        'employee_id',
        'locker_id',
        'type',
        'status',
        'access_code',
        'expires_at',
        'stored_at',
        'taken_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'stored_at' => 'datetime',
        'taken_at' => 'datetime'
    ];

    /**
     * Boot method untuk auto-generate access_code saat creating
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate access code otomatis jika belum ada
            if (empty($model->access_code)) {
                do {
                    $code = strtoupper(substr(md5(uniqid() . $model->employee_id . now()), 0, 10));
                } while (self::where('access_code', $code)->exists());
                
                $model->access_code = $code;
            }
            
            // Set expires_at jika belum ada
            if (empty($model->expires_at)) {
                $model->expires_at = now()->addHours(24);
            }
        });
    }

    // Relasi ke Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    // Relasi ke Locker
    public function locker()
    {
        return $this->belongsTo(Locker::class, 'locker_id');
    }

    // Generate access code unik (manual)
    public function generateAccessCode()
    {
        do {
            $code = strtoupper(substr(md5(uniqid() . $this->employee_id . now()), 0, 10));
        } while (self::where('access_code', $code)->exists());

        $this->access_code = $code;
        $this->expires_at = now()->addHours(24);
        $this->save();

        return $this->access_code;
    }

    // Cek apakah kode masih berlaku
    public function isValid()
    {
        return $this->expires_at !== null && $this->expires_at->isFuture();
    }

    // Cek apakah transaksi sudah expired
    public function isExpired()
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    // Scope untuk transaksi aktif
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'on_progress', 'waiting_pickup'])
                     ->where('expires_at', '>', now());
    }

    // Scope untuk transaksi berdasarkan employee
    public function scopeByEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    // Scope untuk transaksi berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk transaksi yang sudah selesai
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Scope untuk transaksi yang menunggu pickup
    public function scopeWaitingPickup($query)
    {
        return $query->where('status', 'waiting_pickup');
    }
}