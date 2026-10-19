<?php

namespace App\Models\QAQC\ScanXray;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\MTC\Master\MasterLine;
use App\Models\QAQC\BlindTest\Customer;
use App\Models\QAQC\BlindTest\Model as BlindTestModel;
use App\Models\User;

class ScanXray extends EloquentModel
{
    protected $table = 'tb_qaqc_scan_xray';

    protected $fillable = [
        'customer_id',
        'model_id',
        'pcb_type',
        'phase',
        'shift',
        'group',
        'master_line_id',
        'lot_qty',
        'pic_xray',              // ⬅️ BARU
        'first_piece_items',
        'second_first_items',
        'middle_piece_items',
        'second_middle_items',
        'last_piece_items',
        'second_last_items',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'first_piece_items'   => 'array',
        'second_first_items'  => 'array',      // ⬅️ BARU
        'middle_piece_items'  => 'array',
        'second_middle_items' => 'array',      // ⬅️ BARU
        'last_piece_items'    => 'array',
        'second_last_items'   => 'array',      // ⬅️ BARU
        'created_at'          => 'datetime',
        'updated_at'          => 'datetime',
    ];

    public const PCB_TYPE_OPTIONS = ['SINGLE', 'LH', 'RH'];

    public const PHASES = 
    [
        'first',
        'second_first',      // ⬅️ BARU
        'middle',
        'second_middle',     // ⬅️ BARU
        'last',
        'second_last',       // ⬅️ BARU
        'completed',
    ];

    // ==================== RELASI ====================

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(BlindTestModel::class, 'model_id');
    }

    public function masterLine(): BelongsTo
    {
        return $this->belongsTo(MasterLine::class, 'master_line_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ==================== DEFAULT STRUCTURE ====================

    public static function defaultItemStructure(): array
    {
        return [
            'time_scan'          => null,
            'ok_qty'             => 0,
            'ng_qty'             => 0,
            'reject_rate'        => 0,
            'status_running'     => '',
            'filling_ratio'      => null,
            'qty_hold'           => 0,
            'status_after_check' => ['ok' => 0, 'ng' => 0],
            'ncp_id'             => null,
            'remarks'            => '',
            'pictures'           => [],
            'pictures_new'       => [],
            'judgements'         => [],
            'side_single'        => ['pcb_a' => [''], 'pcb_b' => [''], 'pcb_c' => [''], 'pcb_circuit' => ['']],
            'side_lh'            => ['pcb_a' => [''], 'pcb_b' => [''], 'pcb_c' => [''], 'pcb_circuit' => ['']],
            'side_rh'            => ['pcb_a' => [''], 'pcb_b' => [''], 'pcb_c' => [''], 'pcb_circuit' => ['']],
        ];
    }

    public static function standardRows(string $groupKey): int
    {
        return match ($groupKey) {
            'first_piece_items', 'last_piece_items'   => 3,
            'middle_piece_items'                       => 4,
            'second_first_items', 'second_last_items' => 3,
            'second_middle_items'                      => 4,
            default                                    => 3,
        };
    }

    // ==================== HELPERS ====================

    public function getActiveSideAttribute(): ?string
    {
        return match ($this->pcb_type) {
            'SINGLE' => 'side_single',
            'LH'     => 'side_lh',
            'RH'     => 'side_rh',
            default  => null,
        };
    }

    public function isLocked(): bool
    {
        return $this->created_at && $this->created_at->diffInHours(now()) >= 24;
    }

    public function canEditGroup(string $groupKey): bool
    {
        return match ($this->phase) {
            'first'         => $groupKey === 'first_piece_items',
            'second_first'  => $groupKey === 'second_first_items',
            'middle'        => $groupKey === 'middle_piece_items',
            'second_middle' => $groupKey === 'second_middle_items',
            'last'          => $groupKey === 'last_piece_items',
            'second_last'   => $groupKey === 'second_last_items',
            'completed'     => false,
            default         => false,
        };
    }

    public static function defaultSecondPieceStructure(): array
    {
        return [
            'time_scan'      => null,
            'status_running' => '',
            'side_single'    => ['pcb_a' => [''], 'pcb_b' => [''], 'pcb_c' => [''], 'pcb_circuit' => ['']],
            'side_lh'        => ['pcb_a' => [''], 'pcb_b' => [''], 'pcb_c' => [''], 'pcb_circuit' => ['']],
            'side_rh'        => ['pcb_a' => [''], 'pcb_b' => [''], 'pcb_c' => [''], 'pcb_circuit' => ['']],
        ];
    }

    public function getPhaseLabelAttribute(): string
    {
        return match ($this->phase) {
            'first'         => 'First Piece',
            'second_first'  => 'Second Piece (First)',
            'middle'        => 'Middle Piece',
            'second_middle' => 'Second Piece (Middle)',
            'last'          => 'Last Piece',
            'second_last'   => 'Second Piece (Last)',
            'completed'     => 'Completed',
            default         => '-',
        };
    }

    public static function nextPhase(string $current, bool $hasNg = false): string
    {
        return match ($current) {
            'first'         => $hasNg ? 'second_first' : 'middle',
            'second_first'  => 'middle',
            'middle'        => $hasNg ? 'second_middle' : 'last',
            'second_middle' => 'last',
            'last'          => $hasNg ? 'second_last' : 'completed',
            'second_last'   => 'completed',
            default         => 'completed',
        };
    }
}