<?php

namespace App\Models\PROD\WIP;

use App\Models\PROD\WIP\DetailWip;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RackLosePack extends Model
{
    use HasFactory;

    protected $table = 'tb_prod_rack_lose_packs';

    protected $fillable = [
        'no_rack',
        'sheet_rack',
        'column_rack',
    ];

    // === PERBAIKI RELASI DENGAN ERROR HANDLING ===
    public function detailWip()
    {
        try {
            return $this->hasOne(DetailWip::class, 'rack_lose_pack_id');
        } catch (\Exception $e) {
            Log::warning('DetailWip relation error: ' . $e->getMessage());
            return null;
        }
    }

    // === PERBAIKI METHOD DENGAN ERROR HANDLING ===
    public function getStatusAttribute(): string
    {
        try {
            // Cek via DB langsung untuk menghindari error relasi
            $exists = DB::table('tb_prod_detail_wips')
                ->where('rack_lose_pack_id', $this->id)
                ->exists();
            return $exists ? 'Used' : 'Available';
        } catch (\Exception $e) {
            Log::warning('Status check error: ' . $e->getMessage());
            return 'Available';
        }
    }

    public function getLabelAttribute(): string
    {
        return "{$this->no_rack} - {$this->sheet_rack} - {$this->column_rack}";
    }

    public function getDisplayNameAttribute(): string
    {
        return "{$this->no_rack} | {$this->sheet_rack} | {$this->column_rack}";
    }

    public function getShortDisplayAttribute(): string
    {
        $sheetNum = preg_replace('/[^0-9]/', '', $this->sheet_rack);
        $columnNum = preg_replace('/[^0-9]/', '', $this->column_rack);
        
        return "{$this->no_rack}-S{$sheetNum}-C{$columnNum}";
    }

    public function getSheetNumberAttribute(): string
    {
        return preg_replace('/[^0-9]/', '', $this->sheet_rack);
    }

    public function getColumnNumberAttribute(): string
    {
        return preg_replace('/[^0-9]/', '', $this->column_rack);
    }

    // === PERBAIKI METHOD DENGAN ERROR HANDLING ===
    public function isAvailable(): bool
    {
        try {
            return !DB::table('tb_prod_detail_wips')
                ->where('rack_lose_pack_id', $this->id)
                ->exists();
        } catch (\Exception $e) {
            Log::warning('isAvailable check error: ' . $e->getMessage());
            return true;
        }
    }

    public function isUsed(): bool
    {
        return !$this->isAvailable();
    }

    // === PERBAIKI SCOPE DENGAN ERROR HANDLING ===
    public function scopeAvailable($query)
    {
        try {
            return $query->whereDoesntHave('detailWip');
        } catch (\Exception $e) {
            Log::warning('scopeAvailable error: ' . $e->getMessage());
            return $query;
        }
    }

    public function scopeUsed($query)
    {
        try {
            return $query->whereHas('detailWip');
        } catch (\Exception $e) {
            Log::warning('scopeUsed error: ' . $e->getMessage());
            return $query;
        }
    }

    public function scopeByRack($query, string $rackNo)
    {
        return $query->where('no_rack', $rackNo);
    }

    public function scopeBySheet($query, string $sheet)
    {
        return $query->where('sheet_rack', 'LIKE', "%{$sheet}%");
    }

    public function scopeByColumn($query, string $column)
    {
        return $query->where('column_rack', 'LIKE', "%{$column}%");
    }

    public function scopeGroupedOrder($query)
    {
        return $query->orderBy('no_rack')
            ->orderBy('sheet_rack')
            ->orderBy('column_rack');
    }
}