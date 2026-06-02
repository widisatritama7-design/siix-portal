<?php

namespace App\Models\PROD\Absence;

use App\Models\HR\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AbsenceReport extends Model
{
    protected $table = 'tb_prod_absence_reports';

    protected $fillable = [
        'report_number',
        'items',
        'check_by',
        'check_at',
        'approved_by',
        'approved_at',
        'accepted_by',
        'accepted_at',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'items' => 'array',
        'check_at' => 'datetime',
        'approved_at' => 'datetime',
        'accepted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::user()->name;
                $model->updated_by = Auth::user()->name;
            }
            if (empty($model->report_number)) {
                $model->report_number = self::generateReportNumber();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::user()->name;
            }
        });
    }

    public static function generateReportNumber()
    {
        $year = date('Y');
        $month = date('m');
        
        $lastReport = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastReport) {
            $lastNumber = intval(substr($lastReport->report_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return "ABS-RP/{$year}{$month}/{$newNumber}";
    }

    // Ambil semua items dengan detail employee
    public function getItemsDetailAttribute()
    {
        $items = $this->items ?? [];
        $details = [];
        
        foreach ($items as $item) {
            $employee = Employee::find($item['employee_id']);
            $details[] = [
                'employee_id' => $item['employee_id'],
                'employee_nik' => $employee->nik ?? '-',
                'employee_name' => $employee->name ?? '-',
                'employee_department' => $employee->department ?? '-',
                'group' => $item['group'] ?? '-',
                'line' => $item['line'] ?? '-',
                'jenis_ketidakhadiran' => $item['jenis_ketidakhadiran'] ?? '-',
                'keterangan' => $item['keterangan'] ?? '-',
            ];
        }
        
        return $details;
    }

    // Ambil semua employee unik dari items
    public function getEmployeesAttribute()
    {
        $items = $this->items ?? [];
        $employeeIds = array_unique(array_column($items, 'employee_id'));
        return Employee::whereIn('id', $employeeIds)->get();
    }

    // Relasi ke User
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'name');
    }

    public function checker()
    {
        return $this->belongsTo(User::class, 'check_by', 'name');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'name');
    }

    public function accepter()
    {
        return $this->belongsTo(User::class, 'accepted_by', 'name');
    }

    // Methods untuk update status
    public function check()
    {
        $this->update([
            'status' => 'checked',
            'check_by' => Auth::user()->name,
            'check_at' => now(),
        ]);
    }

    public function approve()
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => Auth::user()->name,
            'approved_at' => now(),
        ]);
    }

    public function accept()
    {
        $this->update([
            'status' => 'accepted',
            'accepted_by' => Auth::user()->name,
            'accepted_at' => now(),
        ]);
    }

    // Scope filters
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeChecked($query)
    {
        return $query->where('status', 'checked');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function getAbsenceByEmployee($employeeId)
    {
        $items = $this->items ?? [];
        $absences = [];
        
        foreach ($items as $item) {
            if (isset($item['employee_id']) && $item['employee_id'] == $employeeId) {
                $absences[] = $item;
            }
        }
        
        return $absences;
    }

    public function getTotalAbsenceByEmployee($employeeId)
    {
        return count($this->getAbsenceByEmployee($employeeId));
    }

    public function getAbsenceByType($employeeId, $type)
    {
        $items = $this->items ?? [];
        $count = 0;
        
        foreach ($items as $item) {
            if (isset($item['employee_id']) && $item['employee_id'] == $employeeId 
                && isset($item['jenis_ketidakhadiran']) && $item['jenis_ketidakhadiran'] == $type) {
                $count++;
            }
        }
        
        return $count;
    }
}