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
        'phone',
        'email',        // Tambahkan email
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

    // ============================================================
    // SETTER & GETTER UNTUK PHONE (Masih dipertahankan untuk backward compatibility)
    // ============================================================
    
    /**
     * SETTER: Simpan phone apa adanya (tidak dienkripsi lagi)
     * Karena sekarang pakai email, phone hanya untuk backup
     */
    public function setPhoneAttribute($value)
    {
        // Simpan apa adanya, tanpa enkripsi (karena primary sekarang email)
        $this->attributes['phone'] = $value;
    }

    /**
     * GETTER: Ambil phone apa adanya
     */
    public function getPhoneAttribute($value)
    {
        return $value;
    }

    /**
     * Format nomor ke internasional (untuk WhatsApp - jika masih digunakan)
     */
    public function getFormattedPhoneAttribute()
    {
        $phone = $this->phone;
        
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

    // ============================================================
    // RELASI
    // ============================================================

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function locker()
    {
        return $this->belongsTo(Locker::class, 'locker_id');
    }

    // ============================================================
    // METHODS
    // ============================================================

    /**
     * Generate access code untuk transaksi
     */
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

    /**
     * Cek apakah kode akses masih valid
     */
    public function isValid()
    {
        return $this->expires_at !== null && $this->expires_at->isFuture();
    }

    /**
     * Cek apakah kode akses sudah expired
     */
    public function isExpired()
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    /**
     * Cek apakah transaksi masih aktif
     */
    public function isActive()
    {
        return in_array($this->status, ['pending', 'on_progress', 'waiting_pickup']) 
               && $this->isValid();
    }

    /**
     * Cek apakah transaksi sudah selesai
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    // ============================================================
    // SCOPES
    // ============================================================

    /**
     * Scope untuk transaksi aktif (belum selesai)
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'on_progress', 'waiting_pickup'])
                     ->where('expires_at', '>', now());
    }

    /**
     * Scope untuk transaksi berdasarkan employee
     */
    public function scopeByEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    /**
     * Scope untuk transaksi berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk transaksi selesai
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope untuk transaksi waiting pickup
     */
    public function scopeWaitingPickup($query)
    {
        return $query->where('status', 'waiting_pickup');
    }

    /**
     * Scope untuk transaksi pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk transaksi on progress
     */
    public function scopeOnProgress($query)
    {
        return $query->where('status', 'on_progress');
    }

    /**
     * Scope untuk transaksi berdasarkan locker
     */
    public function scopeByLocker($query, $lockerId)
    {
        return $query->where('locker_id', $lockerId);
    }

    /**
     * Scope untuk transaksi berdasarkan tipe (store/take)
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope untuk transaksi yang belum expired
     */
    public function scopeNotExpired($query)
    {
        return $query->where('expires_at', '>', now());
    }

    /**
     * Scope untuk transaksi yang sudah expired
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    /**
     * Scope untuk transaksi dengan email (yang pakai notifikasi email)
     */
    public function scopeHasEmail($query)
    {
        return $query->whereNotNull('email')->where('email', '!=', '');
    }

    /**
     * Scope untuk transaksi tanpa email (backward compatibility)
     */
    public function scopeNoEmail($query)
    {
        return $query->whereNull('email')->orWhere('email', '');
    }

    // ============================================================
    // HELPER METHODS
    // ============================================================

    /**
     * Dapatkan email untuk notifikasi (prioritas: email > phone)
     */
    public function getNotificationEmail()
    {
        if (!empty($this->email)) {
            return $this->email;
        }
        
        // Fallback: jika tidak ada email, gunakan null
        return null;
    }

    /**
     * Dapatkan phone untuk notifikasi (backup)
     */
    public function getNotificationPhone()
    {
        return $this->formatted_phone;
    }

    /**
     * Cek apakah transaksi memiliki email
     */
    public function hasEmail()
    {
        return !empty($this->email);
    }

    /**
     * Cek apakah transaksi memiliki phone
     */
    public function hasPhone()
    {
        return !empty($this->phone);
    }

    /**
     * Dapatkan status dalam bahasa Indonesia
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu',
            'on_progress' => 'Dalam Proses',
            'waiting_pickup' => 'Siap Diambil',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'expired' => 'Kadaluarsa'
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Dapatkan warna status untuk badge
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'yellow',
            'on_progress' => 'blue',
            'waiting_pickup' => 'green',
            'completed' => 'gray',
            'cancelled' => 'red',
            'expired' => 'red'
        ];

        return $colors[$this->status] ?? 'gray';
    }

    /**
     * Dapatkan tipe dalam bahasa Indonesia
     */
    public function getTypeLabelAttribute()
    {
        return $this->type === 'store' ? 'Menyimpan' : 'Mengambil';
    }
}