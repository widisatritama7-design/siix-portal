<?php

namespace App\Models\PROD\FCT;

use App\Models\PROD\FCT\PCB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanLog extends Model
{
    use HasFactory;

    protected $table = 'tb_prod_scan_logs';
    
    protected $fillable = [
        'serial_number',
        'pcb_id', // Tambahkan ini
        'process',
        'result',
        'box_type',
        'notes'
    ];

    // Relasi ke PCB menggunakan pcb_id
    public function pcb()
    {
        return $this->belongsTo(PCB::class, 'pcb_id', 'id');
    }

    // Relasi menggunakan serial_number
    public function pcbBySerial()
    {
        return $this->belongsTo(PCB::class, 'serial_number', 'serial_number');
    }

    // Scope
    public function scopeProcess($query, $process)
    {
        return $query->where('process', $process);
    }

    public function scopeResult($query, $result)
    {
        return $query->where('result', $result);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeOk($query)
    {
        return $query->where('result', 'ok');
    }

    public function scopeNg($query)
    {
        return $query->where('result', 'ng');
    }
}