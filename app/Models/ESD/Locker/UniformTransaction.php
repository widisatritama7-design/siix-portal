<?php

namespace App\Models\ESD\Locker;

use App\Models\HR\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class UniformTransaction extends Model
{
    use HasFactory;

    protected $table = 'tb_esd_uniform_transactions';

    protected $fillable = [
        'employee_id',
        'phone',
        'locker_id',
        'type',
        'status',
        'access_code',
        'expires_at',
        'stored_at',
        'taken_at',
        'notes'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'stored_at' => 'datetime',
        'taken_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->access_code)) {
                do {
                    $code = strtoupper(substr(md5(uniqid() . $model->employee_id . now()), 0, 10));
                } while (self::where('access_code', $code)->exists());
                
                $model->access_code = $code;
            }
            
            if (empty($model->expires_at)) {
                $model->expires_at = now()->addHours(24);
            }
        });
    }

    /**
     * SETTER: Enkripsi phone sebelum disimpan
     */
    public function setPhoneAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['phone'] = null;
            return;
        }

        // Cek apakah sudah terenkripsi
        try {
            Crypt::decryptString($value);
            // Jika berhasil decrypt, berarti sudah terenkripsi
            $this->attributes['phone'] = $value;
        } catch (\Exception $e) {
            // Jika belum terenkripsi, encrypt
            $this->attributes['phone'] = Crypt::encryptString($value);
        }
    }

    /**
     * GETTER: Dekripsi phone saat diambil dari database
     */
    public function getPhoneAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            // Jika gagal decrypt (data lama/tidak terenkripsi), return apa adanya
            Log::warning('Phone decryption failed, using raw value', [
                'id' => $this->id ?? 'new',
                'error' => $e->getMessage()
            ]);
            return $value;
        }
    }

    /**
     * Format nomor ke internasional (untuk WhatsApp)
     */
    public function getFormattedPhoneAttribute()
    {
        $phone = $this->phone; // Sudah otomatis decrypt via getter
        
        if (!$phone) {
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (empty($phone)) {
            return null;
        }
        
        // Format ke internasional
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 1) === '8') {
            $phone = '62' . $phone;
        }
        
        return $phone;
    }

    // Relasi
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function locker()
    {
        return $this->belongsTo(Locker::class, 'locker_id');
    }

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

    public function isValid()
    {
        return $this->expires_at !== null && $this->expires_at->isFuture();
    }

    public function isExpired()
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'on_progress', 'waiting_pickup'])
                     ->where('expires_at', '>', now());
    }

    public function scopeByEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeWaitingPickup($query)
    {
        return $query->where('status', 'waiting_pickup');
    }
}