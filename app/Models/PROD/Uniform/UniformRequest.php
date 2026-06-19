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
                // Admin Feedback
                'admin_feedback' => $item['admin_feedback'] ?? null,
                'admin_feedback_datetime' => $item['admin_feedback_datetime'] ?? null,
                // Verification (after admin feedback)
                'verification_status' => $item['verification_status'] ?? null, // 'approved' or 'rejected'
                'verification_datetime' => $item['verification_datetime'] ?? null,
                'verification_by' => $item['verification_by'] ?? null,
                'verification_note' => $item['verification_note'] ?? null,
                // Costing Feedback
                'costing_feedback' => $item['costing_feedback'] ?? null,
                'costing_feedback_datetime' => $item['costing_feedback_datetime'] ?? null,
                // Digital Signature (after costing feedback)
                'digital_signature' => $item['digital_signature'] ?? null, // 'SIGNED'
                'signature_datetime' => $item['signature_datetime'] ?? null,
                'signature_name' => $item['signature_name'] ?? null,
                'signature_position' => $item['signature_position'] ?? null,
            ];
        }
        
        return $details;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'name');
    }

    // Admin Feedback
    public function addAdminFeedback($rowIndex, $feedback)
    {
        $items = $this->items;
        if (isset($items[$rowIndex])) {
            $items[$rowIndex]['admin_feedback'] = $feedback;
            $items[$rowIndex]['admin_feedback_datetime'] = now()->toDateTimeString();
            $this->update(['items' => $items]);
        }
    }

    // Verification
    public function verifyItem($rowIndex, $status, $note = null)
    {
        $items = $this->items;
        if (isset($items[$rowIndex])) {
            $items[$rowIndex]['verification_status'] = $status;
            $items[$rowIndex]['verification_datetime'] = now()->toDateTimeString();
            $items[$rowIndex]['verification_by'] = Auth::user()->name;
            $items[$rowIndex]['verification_note'] = $note;
            $this->update(['items' => $items]);
        }
    }

    // Costing Feedback
    public function addCostingFeedback($rowIndex, $feedback)
    {
        $items = $this->items;
        if (isset($items[$rowIndex])) {
            $items[$rowIndex]['costing_feedback'] = $feedback;
            $items[$rowIndex]['costing_feedback_datetime'] = now()->toDateTimeString();
            $this->update(['items' => $items]);
        }
    }

    // Digital Signature
    public function addDigitalSignature($rowIndex, $name, $position)
    {
        $items = $this->items;
        if (isset($items[$rowIndex])) {
            $items[$rowIndex]['digital_signature'] = 'SIGNED';
            $items[$rowIndex]['signature_datetime'] = now()->toDateTimeString();
            $items[$rowIndex]['signature_name'] = $name;
            $items[$rowIndex]['signature_position'] = $position;
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

    // Check if all items are verified and signed
    public function isFullyProcessed()
    {
        $items = $this->items ?? [];
        foreach ($items as $item) {
            if (empty($item['verification_status']) || empty($item['digital_signature'])) {
                return false;
            }
        }
        return true;
    }

    // Get verification statistics
    public function getVerificationStats()
    {
        $items = $this->items ?? [];
        $total = count($items);
        $approved = 0;
        $rejected = 0;
        $pending = 0;
        
        foreach ($items as $item) {
            $status = $item['verification_status'] ?? null;
            if ($status === 'approved') {
                $approved++;
            } elseif ($status === 'rejected') {
                $rejected++;
            } else {
                $pending++;
            }
        }
        
        return [
            'total' => $total,
            'approved' => $approved,
            'rejected' => $rejected,
            'pending' => $pending,
        ];
    }

    public function getSignatureImageAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return $value; // Return base64 image
    }

    // Get signature statistics
    public function getSignatureStats()
    {
        $items = $this->items ?? [];
        $total = count($items);
        $signed = 0;
        $unsigned = 0;
        
        foreach ($items as $item) {
            if (!empty($item['digital_signature'])) {
                $signed++;
            } else {
                $unsigned++;
            }
        }
        
        return [
            'total' => $total,
            'signed' => $signed,
            'unsigned' => $unsigned,
        ];
    }

    public function updateSalaryDeduction($itemIndex, $data)
    {
        $items = $this->items;
        
        if (!isset($items[$itemIndex])) {
            return false;
        }
        
        $items[$itemIndex]['salary_deduction'] = $data['deduction'] ?? 'no';
        $items[$itemIndex]['deduction_amount'] = $data['amount'] ?? null;
        $items[$itemIndex]['payroll_period'] = $data['period'] ?? null;
        $items[$itemIndex]['salary_updated_by'] = auth()->user()->name;
        $items[$itemIndex]['salary_updated_at'] = now()->toDateTimeString();
        
        $this->update(['items' => $items]);
        return true;
    }
}