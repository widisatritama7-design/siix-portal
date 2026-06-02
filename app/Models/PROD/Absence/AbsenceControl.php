<?php

namespace App\Models\PROD\Absence;

use App\Models\HR\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbsenceControl extends Model
{
    protected $table = 'tb_prod_absence_control';

    protected $fillable = [
        'employee_id',
        'date',
        'actual_shift',
        'status_date',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date' => 'date',
        'actual_shift' => 'string',
        'status_date' => 'string',
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
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::user()->name;
            }
        });
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function getDisplayShiftAttribute()
    {
        return $this->status_date === 'Normal' ? $this->actual_shift : '-';
    }

    public function getBgColorAttribute()
    {
        return $this->status_date === 'Holiday' ? '#ffcccc' : '#ffffff';
    }

    public function getTextColorAttribute()
    {
        return $this->status_date === 'Holiday' ? '#cc0000' : '#000000';
    }

    public function getFormattedDateAttribute()
    {
        return $this->date ? $this->date->format('d-m-Y') : '-';
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    public function scopeByEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->whereHas('employee', function ($q) use ($department) {
            $q->where('department', $department);
        });
    }

    public function scopeNormalOnly($query)
    {
        return $query->where('status_date', 'Normal');
    }

    public function scopeHolidayOnly($query)
    {
        return $query->where('status_date', 'Holiday');
    }

    public static function getStatusDateColor($statusDate)
    {
        return $statusDate === 'Holiday' ? 'bg-red-500 text-white' : 'bg-white text-black';
    }

    public function isHoliday()
    {
        return $this->status_date === 'Holiday';
    }

    public static function generateForDateRange($startDate, $endDate, $employeeId = null)
    {
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);
        
        $query = Employee::query();
        if ($employeeId) {
            $query->where('id', $employeeId);
        }
        $employees = $query->get();
        
        $holidays = self::getHolidayDates($startDate, $endDate);
        
        $generated = 0;
        $skipped = 0;
        
        DB::beginTransaction();
        try {
            foreach ($employees as $employee) {
                $currentDate = clone $start;
                while ($currentDate <= $end) {
                    $dateStr = $currentDate->format('Y-m-d');
                    $isHoliday = in_array($dateStr, $holidays);
                    $statusDate = $isHoliday ? 'Holiday' : 'Normal';
                    $actualShift = $isHoliday ? null : $employee->actual_shift;
                    
                    self::updateOrCreate(
                        [
                            'employee_id' => $employee->id,
                            'date' => $dateStr,
                        ],
                        [
                            'actual_shift' => $actualShift,
                            'status_date' => $statusDate,
                        ]
                    );
                    
                    $generated++;
                    $currentDate->addDay();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'generated' => $generated,
                'skipped' => $skipped
            ];
        }
        
        return [
            'success' => true,
            'message' => 'Data berhasil digenerate',
            'generated' => $generated,
            'skipped' => $skipped
        ];
    }
    
    private static function getHolidayDates($startDate, $endDate)
    {
        return [];
    }

    public static function getEmployeeSummary($employeeId, $startDate, $endDate, $absenceData = [])
    {
        $totalDates = self::where('employee_id', $employeeId)
            ->whereBetween('date', [$startDate, $endDate])
            ->count();
        
        $normalDates = self::where('employee_id', $employeeId)
            ->whereBetween('date', [$startDate, $endDate])
            ->where('status_date', 'Normal')
            ->count();
        
        $holidayDates = self::where('employee_id', $employeeId)
            ->whereBetween('date', [$startDate, $endDate])
            ->where('status_date', 'Holiday')
            ->count();
        
        $absenceTypes = ['SD', 'IJ', 'A', 'CT', 'CK', 'CM'];
        $absenceCount = [];
        $totalAbsence = 0;
        
        foreach ($absenceData as $item) {
            if (isset($item['employee_id']) && $item['employee_id'] == $employeeId) {
                $type = $item['jenis_ketidakhadiran'] ?? '';
                if (in_array($type, $absenceTypes)) {
                    $absenceCount[$type] = ($absenceCount[$type] ?? 0) + 1;
                    $totalAbsence++;
                }
            }
        }
        
        $totalPresent = $totalDates - $totalAbsence;
        $ratio = $totalDates > 0 ? ($totalAbsence / $totalDates) * 100 : 0;
        $attendanceRatio = 100 - $ratio;
        
        return [
            'total_dates' => $totalDates,
            'normal_dates' => $normalDates,
            'holiday_dates' => $holidayDates,
            'absence' => [
                'total' => $totalAbsence,
                'by_type' => $absenceCount,
                'types' => $absenceTypes
            ],
            'total_present' => $totalPresent,
            'absence_ratio' => round($ratio, 2),
            'attendance_ratio' => round($attendanceRatio, 2),
            'target' => 100,
            'meet_target' => $attendanceRatio >= 100,
            'status' => $attendanceRatio >= 100 ? 'Memenuhi Target' : 'Belum Memenuhi Target'
        ];
    }
    
    public static function getTableView($employeeId, $startDate, $endDate)
    {
        return self::with('employee')
            ->where('employee_id', $employeeId)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'asc')
            ->get();
    }
    
    public static function deleteForDateRange($startDate, $endDate, $employeeId = null)
    {
        $query = self::whereBetween('date', [$startDate, $endDate]);
        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }
        return $query->delete();
    }
}