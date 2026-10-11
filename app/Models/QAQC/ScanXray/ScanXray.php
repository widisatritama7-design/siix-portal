<?php

namespace App\Models\QAQC\ScanXray;

use App\Models\MTC\Master\MasterLine;
use App\Models\QAQC\BlindTest\Customer;
use App\Models\QAQC\BlindTest\Model as BlindTestModel;
use App\Models\QAQC\NCP;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanXray extends Model
{
    use HasFactory;

    protected $table = 'tb_qaqc_scan_xray';

    protected $fillable = [
        'customer_id',
        'model_id',
        'shift',
        'group',
        'master_line_id',
        'lot_qty',
        'first_piece_items',
        'middle_piece_items',
        'last_piece_items',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'first_piece_items'  => 'array',
        'middle_piece_items' => 'array',
        'last_piece_items'   => 'array',
        'lot_qty'            => 'integer',
        'created_at'         => 'datetime',
        'updated_at'         => 'datetime',
    ];

    // ============ RELATIONSHIPS ============

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function model()
    {
        return $this->belongsTo(BlindTestModel::class, 'model_id');
    }

    public function masterLine()
    {
        return $this->belongsTo(MasterLine::class, 'master_line_id');
    }

    public function ncp()
    {
        return $this->belongsTo(NCP::class, 'ncp_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ============ HELPERS ============

    /**
     * Default struktur 1 grup piece item.
     */
    public static function defaultItemStructure(): array
    {
        return [
            'side_lh' => [
                'pcb_a'       => [],
                'pcb_b'       => [],
                'pcb_c'       => [],
                'pcb_circuit' => [],
            ],
            'side_rh' => [
                'pcb_a'       => [],
                'pcb_b'       => [],
                'pcb_c'       => [],
                'pcb_circuit' => [],
            ],
            'time_scan'          => null,
            'ok_qty'             => 0,
            'ng_qty'             => 0,
            'reject_rate'        => 0,
            'status_running'     => null,
            'filling_ratio'      => null,
            'pictures'           => null,
            'qty_hold'           => 0,
            'status_after_check' => [
                'ok' => null,
                'ng' => null,
            ],
            'ncp_id'             => null,
            'remarks'            => null,
        ];
    }

    // ============ BOOT ============

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = auth()->id();
                $model->updated_by = auth()->id();
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });
    }
}