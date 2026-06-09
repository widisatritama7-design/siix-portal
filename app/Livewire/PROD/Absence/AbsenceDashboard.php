<?php

namespace App\Livewire\PROD\Absence;

use Livewire\Component;
use App\Models\HR\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AbsenceDashboard extends Component
{
    public $startDate = '';
    public $endDate = '';
    public $selectedDepartment = '';
    public $departments = [];
    public $absenceTypes = ['CT', 'SD', 'IJ', 'A', 'CK', 'CM'];
    public $shiftTypes = ['1', '2', '3', 'NS', 'NS1', 'GA', 'GB', 'GC', 'TA', 'TB', 'TC', 'A3G3S', 'B3G3S', 'C3G3S'];
    
    // User Access Properties
    public $userDepartment = null;
    public $isOneUserAccess = false;
    public $accessError = null;

    public function mount()
    {
        $this->checkUserAccess();
        $this->setDefaultDateRange();
        $this->loadDepartments();
        
        Log::info('AbsenceDashboard Mounted - User Access:', [
            'user_id' => auth()->id(),
            'user_name' => auth()->user()?->name,
            'can_view_one_user' => auth()->user()?->can('view absence report one user'),
            'isOneUserAccess' => $this->isOneUserAccess,
            'userDepartment' => $this->userDepartment,
            'selectedDepartment' => $this->selectedDepartment,
        ]);
    }
    
    private function checkUserAccess()
    {
        $user = auth()->user();
        
        if (!$user) {
            return;
        }
        
        if ($user->can('view absence report one user')) {
            $this->isOneUserAccess = true;
            
            $employee = null;
            
            if (!empty($user->username)) {
                $employee = Employee::where('nik', $user->username)
                    ->whereIn('status', ['1', '2', '3'])
                    ->first();
            }
            
            if (!$employee && !empty($user->email)) {
                $employee = Employee::where('email', $user->email)
                    ->whereIn('status', ['1', '2', '3'])
                    ->first();
            }
            
            if (!$employee && !empty($user->name)) {
                $employee = Employee::where('name', 'like', '%' . $user->name . '%')
                    ->whereIn('status', ['1', '2', '3'])
                    ->first();
            }
            
            if (!$employee && !empty($user->id)) {
                $employee = Employee::where('user_id', $user->id)
                    ->whereIn('status', ['1', '2', '3'])
                    ->first();
            }
            
            if ($employee && !empty($employee->department)) {
                $this->userDepartment = trim($employee->department);
                $this->selectedDepartment = $this->userDepartment;
                $this->accessError = null;
                
                Log::info('One User Access Dashboard ACTIVE - Department: ' . $this->userDepartment);
            } else {
                $this->accessError = 'Data karyawan tidak ditemukan atau status karyawan tidak aktif. Hubungi administrator.';
                $this->isOneUserAccess = false;
                
                Log::error('Employee not found for dashboard user: ' . $user->name);
            }
        }
    }
    
    private function loadDepartments()
    {
        if ($this->isOneUserAccess && $this->userDepartment) {
            $this->departments = [trim($this->userDepartment)];
        } else {
            $this->departments = Employee::whereIn('status', ['1', '2', '3'])
                ->where('nik', 'REGEXP', '^[0-9]+$')
                ->whereNotNull('department')
                ->where('department', '!=', '')
                ->select('department')
                ->distinct()
                ->pluck('department')
                ->map(function($dept) {
                    return trim($dept);
                })
                ->filter()
                ->values()
                ->toArray();
        }
    }
    
    public function updatedSelectedDepartment()
    {
        if ($this->isOneUserAccess && $this->userDepartment) {
            $this->selectedDepartment = $this->userDepartment;
            $this->dispatch('notify', message: 'You can only view data from ' . $this->userDepartment . ' department!', type: 'error');
            return;
        }
        
        $this->dispatch('notify', message: 'Filtering data for department: ' . ($this->selectedDepartment ?: 'All Departments'), type: 'info');
    }

    public function setDefaultDateRange()
    {
        $today = Carbon::now();
        
        if ($today->day >= 21) {
            $this->startDate = Carbon::now()->startOfMonth()->addDays(20)->format('Y-m-d');
            $this->endDate = Carbon::now()->startOfMonth()->addMonth()->addDays(19)->format('Y-m-d');
        } else {
            $this->startDate = Carbon::now()->subMonth()->startOfMonth()->addDays(20)->format('Y-m-d');
            $this->endDate = Carbon::now()->startOfMonth()->addDays(19)->format('Y-m-d');
        }
    }
    
    private function getEmployeeIdsByDepartment()
    {
        if (empty($this->selectedDepartment)) {
            return Employee::whereIn('status', ['1', '2', '3'])
                ->where('nik', 'REGEXP', '^[0-9]+$')
                ->pluck('id')
                ->toArray();
        }
        
        return Employee::whereIn('status', ['1', '2', '3'])
            ->where('nik', 'REGEXP', '^[0-9]+$')
            ->where(DB::raw('TRIM(department)'), '=', trim($this->selectedDepartment))
            ->pluck('id')
            ->toArray();
    }
    
    private function applyDepartmentFilter($query)
    {
        if (!empty($this->selectedDepartment)) {
            $employeeIds = Employee::whereIn('status', ['1', '2', '3'])
                ->where(DB::raw('TRIM(department)'), '=', trim($this->selectedDepartment))
                ->pluck('id');
            
            if ($employeeIds->isNotEmpty()) {
                $query->whereIn('employee_id', $employeeIds);
            } else {
                $query->whereRaw('1 = 0');
            }
        }
        return $query;
    }

    public function getDailyAccumulationData()
    {
        $employeeIds = [];
        
        if (!empty($this->selectedDepartment)) {
            $employeeIds = Employee::whereIn('status', ['1', '2', '3'])
                ->where(DB::raw('TRIM(department)'), '=', trim($this->selectedDepartment))
                ->pluck('id')
                ->toArray();
        } elseif ($this->isOneUserAccess && !empty($this->userDepartment)) {
            $employeeIds = Employee::whereIn('status', ['1', '2', '3'])
                ->where(DB::raw('TRIM(department)'), '=', trim($this->userDepartment))
                ->pluck('id')
                ->toArray();
        } else {
            $employeeIds = Employee::whereIn('status', ['1', '2', '3'])
                ->where('nik', 'REGEXP', '^[0-9]+$')
                ->pluck('id')
                ->toArray();
        }
        
        if (empty($employeeIds)) {
            $dailyData = [];
            $start = Carbon::parse($this->startDate);
            $end = Carbon::parse($this->endDate);
            $current = clone $start;
            
            while ($current <= $end) {
                $dailyData[] = [
                    'date' => $current->format('Y-m-d'),
                    'display_date' => $current->format('d M Y'),
                    'CT' => 0,
                    'SD' => 0,
                    'IJ' => 0,
                    'A' => 0,
                    'CK' => 0,
                    'CM' => 0,
                    'total' => 0,
                ];
                $current->addDay();
            }
            return $dailyData;
        }
        
        $results = DB::table('tb_prod_absence_control')
            ->whereIn('employee_id', $employeeIds)
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->where('status_date', 'Normal')
            ->whereIn('actual_shift', $this->absenceTypes)
            ->select('date', 'actual_shift', DB::raw('count(*) as total'))
            ->groupBy('date', 'actual_shift')
            ->get();
        
        $dataArray = [];
        foreach ($results as $row) {
            $dateStr = date('Y-m-d', strtotime($row->date));
            $shift = $row->actual_shift;
            $dataArray[$dateStr][$shift] = $row->total;
        }
        
        $dailyData = [];
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);
        $current = clone $start;
        
        while ($current <= $end) {
            $dateStr = $current->format('Y-m-d');
            $dailyData[] = [
                'date' => $dateStr,
                'display_date' => $current->format('d M Y'),
                'CT' => $dataArray[$dateStr]['CT'] ?? 0,
                'SD' => $dataArray[$dateStr]['SD'] ?? 0,
                'IJ' => $dataArray[$dateStr]['IJ'] ?? 0,
                'A' => $dataArray[$dateStr]['A'] ?? 0,
                'CK' => $dataArray[$dateStr]['CK'] ?? 0,
                'CM' => $dataArray[$dateStr]['CM'] ?? 0,
                'total' => ($dataArray[$dateStr]['CT'] ?? 0) + ($dataArray[$dateStr]['SD'] ?? 0) + 
                        ($dataArray[$dateStr]['IJ'] ?? 0) + ($dataArray[$dateStr]['A'] ?? 0) + 
                        ($dataArray[$dateStr]['CK'] ?? 0) + ($dataArray[$dateStr]['CM'] ?? 0),
            ];
            $current->addDay();
        }
        
        return $dailyData;
    }
    
    public function getDailyPercentageData()
    {
        $employeeIds = [];
        
        if (!empty($this->selectedDepartment)) {
            $employeeIds = Employee::whereIn('status', ['1', '2', '3'])
                ->where(DB::raw('TRIM(department)'), '=', trim($this->selectedDepartment))
                ->pluck('id')
                ->toArray();
        } elseif ($this->isOneUserAccess && !empty($this->userDepartment)) {
            $employeeIds = Employee::whereIn('status', ['1', '2', '3'])
                ->where(DB::raw('TRIM(department)'), '=', trim($this->userDepartment))
                ->pluck('id')
                ->toArray();
        } else {
            $employeeIds = Employee::whereIn('status', ['1', '2', '3'])
                ->where('nik', 'REGEXP', '^[0-9]+$')
                ->pluck('id')
                ->toArray();
        }
        
        if (empty($employeeIds)) {
            $percentageData = [];
            $start = Carbon::parse($this->startDate);
            $end = Carbon::parse($this->endDate);
            $current = clone $start;
            
            while ($current <= $end) {
                $percentageData[] = [
                    'date' => $current->format('Y-m-d'),
                    'display_date' => $current->format('d M Y'),
                    'percentage' => 0,
                    'present' => 0,
                    'total_normal' => 0,
                    'absence' => 0,
                ];
                $current->addDay();
            }
            return $percentageData;
        }
        
        $normalData = DB::table('tb_prod_absence_control')
            ->whereIn('employee_id', $employeeIds)
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->where('status_date', 'Normal')
            ->select('date', DB::raw('count(*) as total_normal'))
            ->groupBy('date')
            ->get();
        
        $totalNormalPerDay = [];
        foreach ($normalData as $row) {
            $dateStr = date('Y-m-d', strtotime($row->date));
            $totalNormalPerDay[$dateStr] = $row->total_normal;
        }
        
        $absenceData = DB::table('tb_prod_absence_control')
            ->whereIn('employee_id', $employeeIds)
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->where('status_date', 'Normal')
            ->whereIn('actual_shift', $this->absenceTypes)
            ->select('date', DB::raw('count(*) as total_absence'))
            ->groupBy('date')
            ->get();
        
        $absencePerDay = [];
        foreach ($absenceData as $row) {
            $dateStr = date('Y-m-d', strtotime($row->date));
            $absencePerDay[$dateStr] = $row->total_absence;
        }
        
        $percentageData = [];
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);
        $current = clone $start;
        
        while ($current <= $end) {
            $dateStr = $current->format('Y-m-d');
            $totalNormal = $totalNormalPerDay[$dateStr] ?? 0;
            $totalAbsence = $absencePerDay[$dateStr] ?? 0;
            $present = $totalNormal - $totalAbsence;
            $percentage = $totalNormal > 0 ? round(($present / $totalNormal) * 100, 2) : 0;
            
            $percentageData[] = [
                'date' => $dateStr,
                'display_date' => $current->format('d M Y'),
                'percentage' => $percentage,
                'present' => $present,
                'total_normal' => $totalNormal,
                'absence' => $totalAbsence,
            ];
            $current->addDay();
        }
        
        return $percentageData;
    }
    
    public function getShiftStackedChartData()
    {
        $employeeIds = [];
        
        if (!empty($this->selectedDepartment)) {
            $employeeIds = Employee::whereIn('status', ['1', '2', '3'])
                ->where(DB::raw('TRIM(department)'), '=', trim($this->selectedDepartment))
                ->pluck('id')
                ->toArray();
        } elseif ($this->isOneUserAccess && !empty($this->userDepartment)) {
            $employeeIds = Employee::whereIn('status', ['1', '2', '3'])
                ->where(DB::raw('TRIM(department)'), '=', trim($this->userDepartment))
                ->pluck('id')
                ->toArray();
        } else {
            $employeeIds = Employee::whereIn('status', ['1', '2', '3'])
                ->where('nik', 'REGEXP', '^[0-9]+$')
                ->pluck('id')
                ->toArray();
        }
        
        if (empty($employeeIds)) {
            return [
                'shifts' => $this->shiftTypes,
                'absenceData' => [],
                'total_absence' => 0,
            ];
        }
        
        $absenceRecords = DB::table('tb_prod_absence_control as ac')
            ->whereIn('ac.employee_id', $employeeIds)
            ->whereBetween('ac.date', [$this->startDate, $this->endDate])
            ->where('ac.status_date', 'Normal')
            ->whereIn('ac.actual_shift', $this->absenceTypes)
            ->select(
                'ac.actual_shift as absence_type',
                'ac.employee_id'
            )
            ->get();
        
        if ($absenceRecords->isEmpty()) {
            return [
                'shifts' => $this->shiftTypes,
                'absenceData' => [],
                'total_absence' => 0,
            ];
        }
        
        $employeeIdsWithAbsence = $absenceRecords->pluck('employee_id')->unique()->toArray();
        
        $employeeShifts = Employee::whereIn('id', $employeeIdsWithAbsence)
            ->select('id', 'actual_shift')
            ->get()
            ->keyBy('id');
        
        $shifts = $this->shiftTypes;
        
        $absenceData = [];
        foreach ($shifts as $shift) {
            $absenceData[$shift] = [
                'CT' => 0,
                'SD' => 0,
                'IJ' => 0,
                'A' => 0,
                'CK' => 0,
                'CM' => 0,
                'total' => 0
            ];
        }
        
        foreach ($absenceRecords as $record) {
            $absenceType = $record->absence_type;
            $employeeShift = $employeeShifts[$record->employee_id]->actual_shift ?? null;
            
            if (!empty($employeeShift) && isset($absenceData[$employeeShift])) {
                if (in_array($absenceType, $this->absenceTypes)) {
                    $absenceData[$employeeShift][$absenceType]++;
                    $absenceData[$employeeShift]['total']++;
                }
            }
        }
        
        $totalAbsence = 0;
        foreach ($absenceData as $shift) {
            $totalAbsence += $shift['total'];
        }
        
        $absenceColors = [
            'CT' => '#ef4444',
            'SD' => '#f97316',
            'IJ' => '#eab308',
            'A'  => '#22c55e',
            'CK' => '#3b82f6',
            'CM' => '#a855f7',
        ];
        
        // Get max value for scaling
        $maxAbsence = 0;
        foreach ($shifts as $shift) {
            if ($absenceData[$shift]['total'] > $maxAbsence) {
                $maxAbsence = $absenceData[$shift]['total'];
            }
        }
        $maxAbsence = $maxAbsence > 0 ? $maxAbsence : 1;
        
        return [
            'shifts' => $shifts,
            'absenceData' => $absenceData,
            'absenceColors' => $absenceColors,
            'total_absence' => $totalAbsence,
            'max_absence' => $maxAbsence,
        ];
    }
    
    public function getSummaryData()
    {
        $dailyData = $this->getDailyAccumulationData();
        
        $totalAbsence = [
            'CT' => collect($dailyData)->sum('CT'),
            'SD' => collect($dailyData)->sum('SD'),
            'IJ' => collect($dailyData)->sum('IJ'),
            'A' => collect($dailyData)->sum('A'),
            'CK' => collect($dailyData)->sum('CK'),
            'CM' => collect($dailyData)->sum('CM'),
        ];
        
        $totalAllAbsence = array_sum($totalAbsence);
        
        $percentageData = $this->getDailyPercentageData();
        $avgPercentage = collect($percentageData)->avg('percentage') ?? 0;
        
        $employeeQuery = Employee::whereIn('status', ['1', '2', '3'])
            ->where('nik', 'REGEXP', '^[0-9]+$');
        
        if (!empty($this->selectedDepartment)) {
            $employeeQuery->where(DB::raw('TRIM(department)'), '=', trim($this->selectedDepartment));
        } elseif ($this->isOneUserAccess && !empty($this->userDepartment)) {
            $employeeQuery->where(DB::raw('TRIM(department)'), '=', trim($this->userDepartment));
        }
        
        $totalEmployees = $employeeQuery->count();
        
        return [
            'total_employees' => $totalEmployees,
            'avg_percentage' => round($avgPercentage, 2),
            'total_absence' => $totalAllAbsence,
            'total_CT' => $totalAbsence['CT'],
            'total_SD' => $totalAbsence['SD'],
            'total_IJ' => $totalAbsence['IJ'],
            'total_A' => $totalAbsence['A'],
            'total_CK' => $totalAbsence['CK'],
            'total_CM' => $totalAbsence['CM'],
        ];
    }
    
    public function resetFilters()
    {
        if (!$this->isOneUserAccess) {
            $this->selectedDepartment = '';
        }
        $this->setDefaultDateRange();
        $this->dispatch('notify', message: 'Filters have been reset', type: 'info');
    }

    public function render()
    {
        $dailyData = $this->getDailyAccumulationData();
        $percentageData = $this->getDailyPercentageData();
        $shiftStackedData = $this->getShiftStackedChartData();
        $summaryData = $this->getSummaryData();
        
        return view('livewire.prod.absence.absence-dashboard', [
            'dailyData' => $dailyData,
            'percentageData' => $percentageData,
            'shiftStackedData' => $shiftStackedData,
            'summaryData' => $summaryData,
        ]);
    }
}