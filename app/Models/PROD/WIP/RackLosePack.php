<?php

namespace App\Models\PROD\WIP;

use App\Models\PROD\WIP\DetailWip;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RackLosePack extends Model
{
    use HasFactory;

    protected $table = 'tb_prod_rack_lose_packs';

    protected $fillable = [
        'no_rack',
        'sheet_rack',
        'column_rack',
    ];

    public function detailWip()
    {
        return $this->hasOne(DetailWip::class, 'rack_lose_pack_id');
    }

    public function getStatusAttribute(): string
    {
        return $this->detailWip()->exists() ? 'Used' : 'Available';
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

    public function isAvailable(): bool
    {
        return !$this->detailWip()->exists();
    }

    public function isUsed(): bool
    {
        return $this->detailWip()->exists();
    }

    public function scopeAvailable($query)
    {
        return $query->whereDoesntHave('detailWip');
    }

    public function scopeUsed($query)
    {
        return $query->whereHas('detailWip');
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