<?php

namespace App\Models\PROD\Patrol;

use App\Models\MTC\Master\MasterLine; // <-- Tambahkan ini
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StandardPatrol extends Model
{
    use HasFactory;

    protected $table = 'tb_prod_standard_patrol';

    protected $fillable = [
        'line',
        'master_line_id', // JSON Array
        'item_check',
        'standard',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'master_line_id' => 'array', // Otomatis convert JSON <-> Array
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ==========================================
    // TAMBAHKAN METHOD INI UNTUK RELASI MANUAL
    // ==========================================
    
    /**
     * Mengambil data MasterLine berdasarkan array ID di kolom master_line_id.
     * Dipanggil dengan: $standardPatrol->getMasterLines()
     */
    public function getMasterLines()
    {
        $ids = $this->master_line_id ?? [];
        
        if (empty($ids)) {
            return collect();
        }

        return MasterLine::whereIn('id', $ids)->get();
    }
}