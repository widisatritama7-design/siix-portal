<?php

namespace App\Models\ESD\Loan;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentLoan extends Model
{
    protected $table = 'tb_esd_equipment_loans';

    protected $fillable = [
        'employee_id',
        'loan_date',
        'return_date',
        'equipment_loan',
        'status',
        'created_by',
        'updated_by',
        'confirm_by',
        'approve_by'
    ];

    protected $casts = [
        'loan_date' => 'date',
        'return_date' => 'date',
    ];

    public static function getEquipmentLabels(): array
    {
        return [
            'wrist_strap' => 'Wrist Strap',
            'sepatu_putih' => 'Sepatu Putih',
            'sepatu_safety' => 'Sepatu Safety'
        ];
    }

    public function getEquipmentLabelAttribute(): string
    {
        return self::getEquipmentLabels()[$this->equipment_loan] ?? $this->equipment_loan;
    }

    public static function getStatusLabels(): array
    {
        return [
            'borrowed' => 'Borrowed / Dipinjam',
            'returned' => 'Returned / Dikembalikan',
            'confirmed' => 'Confirmed / Dikonfirmasi',
            'approved' => 'Approved / Disetujui'
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::getStatusLabels()[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'borrowed' => 'yellow',
            'returned' => 'green',
            'confirmed' => 'blue',
            'approved' => 'purple',
            default => 'gray'
        };
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'name');
    }

    public function confirmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirm_by', 'name');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approve_by', 'name');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['borrowed', 'confirmed']);
    }

    public function scopeNotReturned($query)
    {
        return $query->where('status', '!=', 'returned');
    }
}
