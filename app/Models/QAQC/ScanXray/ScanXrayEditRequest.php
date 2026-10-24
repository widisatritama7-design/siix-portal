<?php

namespace App\Models\QAQC\ScanXray;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScanXrayEditRequest extends Model
{
    protected $table = 'tb_qaqc_scan_xray_edit_requests';

    protected $fillable = [
        'scan_xray_id',
        'requested_groups',
        'reason',
        'status',
        'requested_by',
        'approved_by',
        'approved_at',
        'rejected_at',
        'reject_reason',
        'expires_at',
    ];

    protected $casts = [
        'requested_groups' => 'array',
        'approved_at'      => 'datetime',
        'rejected_at'      => 'datetime',
        'expires_at'       => 'datetime',
    ];

    /**
     * Master list group yang bisa diminta untuk diedit.
     * Key = field di JSON scan_xray, Value = label tampilan.
     */
    public const GROUPS = [
        'first_piece_items'   => 'First Piece',
        'second_first_items'  => 'Second Piece (First)',
        'middle_piece_items'  => 'Middle Piece',
        'second_middle_items' => 'Second Piece (Middle)',
        'last_piece_items'    => 'Last Piece',
        'second_last_items'   => 'Second Piece (Last)',
    ];

    // ==================== RELASI ====================

    public function scanXray(): BelongsTo
    {
        return $this->belongsTo(ScanXray::class, 'scan_xray_id');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // ==================== HELPER ====================

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved'
            && (!$this->expires_at || $this->expires_at->isFuture());
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isRevoked(): bool
    {
        return $this->status === 'revoked';
    }

    public function isActive(): bool
    {
        return in_array($this->status, ['pending', 'approved'], true);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Cek apakah group tertentu sudah di-approve untuk diedit.
     */
    public function allowsGroup(string $groupKey): bool
    {
        if (!$this->isApproved()) return false;
        return in_array($groupKey, $this->requested_groups ?? [], true);
    }

    /**
     * Label group yang diminta (untuk ditampilkan).
     */
    public function groupLabels(): array
    {
        return array_map(
            fn ($key) => self::GROUPS[$key] ?? $key,
            $this->requested_groups ?? []
        );
    }
}