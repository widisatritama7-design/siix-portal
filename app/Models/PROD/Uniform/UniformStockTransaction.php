<?php

namespace App\Models\PROD\Uniform;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniformStockTransaction extends Model
{
    use HasFactory;

    protected $table = 'tb_prod_uniform_stock_transactions';

    protected $fillable = [
        'master_uniform_id',
        'transaction_type', // 'IN', 'OUT', 'OPNAME'
        'qty_change',
        'qty_before',
        'qty_after',
        'reference_id', // ID dari request atau transaksi in
        'reference_type', // 'uniform_request', 'stock_in', 'stock_opname'
        'description',
        'performed_by',
        'performed_at',
    ];

    protected $casts = [
        'qty_change' => 'integer',
        'qty_before' => 'integer',
        'qty_after' => 'integer',
        'performed_at' => 'datetime',
    ];

    public function uniform()
    {
        return $this->belongsTo(MasterUniform::class, 'master_uniform_id');
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by', 'name');
    }
}