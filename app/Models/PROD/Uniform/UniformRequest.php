<?php

namespace App\Models\PROD\Uniform;

use App\Models\HR\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UniformRequest extends Model
{
    protected $table = 'tb_prod_uniform_requests';

    protected $fillable = [
        'request_number',
        'items',
        'missc_status',
        'missc_accept_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'items' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'missc_accept_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::user()->name;
                $model->updated_by = Auth::user()->name;
            }
            if (empty($model->request_number)) {
                $model->request_number = self::generateRequestNumber();
            }
            // Set default missc_status
            if (empty($model->missc_status)) {
                $model->missc_status = 'Waiting';
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::user()->name;
            }
        });
    }

    public static function generateRequestNumber()
    {
        $year = date('Y');
        $month = date('m');
        
        $lastRequest = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastRequest) {
            $lastNumber = intval(substr($lastRequest->request_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return "UNF-RQ/{$year}{$month}/{$newNumber}";
    }

    public function getItemsDetailAttribute()
    {
        $items = $this->items ?? [];
        $details = [];
        
        foreach ($items as $item) {
            $employee = Employee::find($item['employee_id']);
            $uniform = MasterUniform::find($item['master_uniform_id']);
            
            $details[] = [
                'employee_id' => $item['employee_id'],
                'employee_name' => $employee->name ?? '-',
                'employee_nik' => $employee->nik ?? '-',
                'employee_department' => $employee->department ?? '-',
                'master_uniform_id' => $item['master_uniform_id'],
                'item_code' => $uniform->item_code ?? '-',
                'description' => $uniform->description ?? '-',
                'size' => $uniform->size ?? '-',
                'qty' => $item['qty'],
                'reason' => $item['reason'],
                'group' => $item['group'],
                'request_date' => $item['request_date'],
                'remarks' => $item['remarks'],
                'admin_feedback' => $item['admin_feedback'] ?? null,
                'admin_feedback_datetime' => $item['admin_feedback_datetime'] ?? null,
                'costing_feedback' => $item['costing_feedback'] ?? null,
                'costing_feedback_datetime' => $item['costing_feedback_datetime'] ?? null,
            ];
        }
        
        return $details;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'name');
    }

    public function addAdminFeedback($rowIndex, $feedback)
    {
        $items = $this->items;
        if (isset($items[$rowIndex])) {
            $items[$rowIndex]['admin_feedback'] = $feedback;
            $items[$rowIndex]['admin_feedback_datetime'] = now()->toDateTimeString();
            $this->update(['items' => $items]);
        }
    }

    public function addCostingFeedback($rowIndex, $feedback)
    {
        $items = $this->items;
        if (isset($items[$rowIndex])) {
            $items[$rowIndex]['costing_feedback'] = $feedback;
            $items[$rowIndex]['costing_feedback_datetime'] = now()->toDateTimeString();
            $this->update(['items' => $items]);
        }
    }

    // Helper method to update MISSC status
    public function updateMisscStatus($status)
    {
        $this->missc_status = $status;
        
        if ($status === 'Accepted') {
            $this->missc_accept_at = now();
        }
        
        $this->save();
    }
}