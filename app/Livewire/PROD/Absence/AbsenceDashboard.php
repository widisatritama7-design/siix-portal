<?php
// app/Livewire/PROD/Absence/AbsenceDashboard.php

namespace App\Livewire\PROD\Absence;

use Livewire\Component;
use App\Models\HR\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AbsenceDashboard extends Component
{
    public $startDate = '';
    public $endDate = '';
    public $selectedDepartment = '';
    public $departments = [];
    public $absenceTypes = ['CT', 'SD', 'IJ', 'A', 'CK', 'CM'];
    public $shiftTypes = ['1', '2', '3', 'NS', 'NS1', 'GA', 'GB', 'GC', 'TA', 'TB', 'TC', 'A3G3S', 'B3G3S', 'C3G3S'];

    public function mount()
    {
        $this->setDefaultDateRange();
        $this->departments = Employee::whereIn('status', ['1', '2', '3'])
            ->where('nik', 'REGEXP', '^[0-9]+$')
            ->select('department')
            ->distinct()
            ->pluck('department')
            ->toArray();
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

    public function getDailyAccumulationData()
    {
        // Get raw data from database
        $results = DB::table('tb_prod_absence_control')
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->where('status_date', 'Normal')
            ->whereIn('actual_shift', $this->absenceTypes);
        
        if ($this->selectedDepartment) {
            $employeeIds = Employee::where('department', $this->selectedDepartment)->pluck('id');
            $results->whereIn('employee_id', $employeeIds);
        }
        
        $results = $results->select('date', 'actual_shift', DB::raw('count(*) as total'))
            ->groupBy('date', 'actual_shift')
            ->get();
        
        // Convert to simple array with string dates
        $dataArray = [];
        foreach ($results as $row) {
            $dateStr = date('Y-m-d', strtotime($row->date));
            $shift = $row->actual_shift;
            $dataArray[$dateStr][$shift] = $row->total;
        }
        
        // Build daily data
        $dailyData = [];
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);
        $current = clone $start;
        
        while ($current <= $end) {
            $dateStr = $current->format('Y-m-d');
            $dailyData[] = [
                'date' => $dateStr,
                'display_date' => $current->format('d M'),
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
        // Get total normal days per day
        $normalQuery = DB::table('tb_prod_absence_control')
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->where('status_date', 'Normal');
        
        if ($this->selectedDepartment) {
            $employeeIds = Employee::where('department', $this->selectedDepartment)->pluck('id');
            $normalQuery->whereIn('employee_id', $employeeIds);
        }
        
        $normalData = $normalQuery->select('date', DB::raw('count(*) as total_normal'))
            ->groupBy('date')
            ->get();
        
        $totalNormalPerDay = [];
        foreach ($normalData as $row) {
            $dateStr = date('Y-m-d', strtotime($row->date));
            $totalNormalPerDay[$dateStr] = $row->total_normal;
        }
        
        // Get absence count per day
        $absenceQuery = DB::table('tb_prod_absence_control')
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->where('status_date', 'Normal')
            ->whereIn('actual_shift', $this->absenceTypes);
        
        if ($this->selectedDepartment) {
            $employeeIds = Employee::where('department', $this->selectedDepartment)->pluck('id');
            $absenceQuery->whereIn('employee_id', $employeeIds);
        }
        
        $absenceData = $absenceQuery->select('date', DB::raw('count(*) as total_absence'))
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
            $percentage = $totalNormal > 0 ? round(($present / $totalNormal) * 100, 2) : 100;
            
            $percentageData[] = [
                'date' => $dateStr,
                'display_date' => $current->format('d M'),
                'percentage' => $percentage,
                'present' => $present,
                'total_normal' => $totalNormal,
                'absence' => $totalAbsence,
            ];
            $current->addDay();
        }
        
        return $percentageData;
    }
    
    public function getShiftStackedData()
    {
        // Get all normal (non-holiday) absence control data
        $query = DB::table('tb_prod_absence_control')
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->where('status_date', 'Normal');
        
        if ($this->selectedDepartment) {
            $employeeIds = Employee::where('department', $this->selectedDepartment)->pluck('id');
            $query->whereIn('employee_id', $employeeIds);
        }
        
        $data = $query->select('actual_shift', DB::raw('count(*) as total'))
            ->groupBy('actual_shift')
            ->get();
        
        $result = [];
        $totalAll = 0;
        
        // Initialize all shift types
        foreach ($this->shiftTypes as $shift) {
            $result[$shift] = 0;
        }
        
        foreach ($data as $row) {
            $shift = $row->actual_shift;
            if ($shift && isset($result[$shift])) {
                $result[$shift] = $row->total;
                $totalAll += $row->total;
            } elseif ($shift && in_array($shift, $this->absenceTypes)) {
                $key = 'absence_' . $shift;
                if (!isset($result[$key])) {
                    $result[$key] = 0;
                }
                $result[$key] = $row->total;
                $totalAll += $row->total;
            }
        }
        
        // Add absence types with zero
        foreach ($this->absenceTypes as $type) {
            $key = 'absence_' . $type;
            if (!isset($result[$key])) {
                $result[$key] = 0;
            }
        }
        
        $result['total'] = $totalAll;
        
        return $result;
    }
    
    public function getShiftStackedChartData()
    {
        $data = $this->getShiftStackedData();
        
        $colors = [
            '1' => '#3b82f6',
            '2' => '#10b981',
            '3' => '#f59e0b',
            'NS' => '#8b5cf6',
            'NS1' => '#ec4898',
            'GA' => '#06b6d4',
            'GB' => '#ef4444',
            'GC' => '#84cc16',
            'TA' => '#f97316',
            'TB' => '#14b8a6',
            'TC' => '#6366f1',
            'A3G3S' => '#a855f7',
            'B3G3S' => '#d946ef',
            'C3G3S' => '#f43f5e',
            'absence_SD' => '#fbbf24',
            'absence_IJ' => '#fcd34d',
            'absence_A' => '#fef08a',
            'absence_CT' => '#fde047',
            'absence_CK' => '#fef9c3',
            'absence_CM' => '#fef08a',
        ];
        
        $labels = [];
        $values = [];
        $backgroundColors = [];
        
        // Include shift types (1,2,3,NS,NS1,dll)
        foreach ($this->shiftTypes as $shift) {
            $value = $data[$shift] ?? 0;
            if ($value > 0) {
                $labels[] = $shift;
                $values[] = $value;
                $backgroundColors[] = $colors[$shift] ?? '#9ca3af';
            }
        }
        
        // Include absence types
        foreach ($this->absenceTypes as $type) {
            $key = 'absence_' . $type;
            $value = $data[$key] ?? 0;
            if ($value > 0) {
                $labels[] = $type . ' (Absence)';
                $values[] = $value;
                $backgroundColors[] = $colors[$key] ?? '#9ca3af';
            }
        }
        
        // If no data, add dummy data to show chart
        if (empty($labels)) {
            $labels = ['No Data'];
            $values = [0];
            $backgroundColors = ['#9ca3af'];
        }
        
        return [
            'labels' => $labels,
            'values' => $values,
            'backgroundColors' => $backgroundColors,
            'total' => $data['total'],
        ];
    }

    public function render()
    {
        $dailyData = $this->getDailyAccumulationData();
        $percentageData = $this->getDailyPercentageData();
        $shiftStackedData = $this->getShiftStackedChartData();
        
        // Prepare chart data for percentage line chart
        $percentageChartData = [
            'labels' => array_column($percentageData, 'display_date'),
            'values' => array_column($percentageData, 'percentage'),
        ];
        
        return view('livewire.prod.absence.absence-dashboard', [
            'dailyData' => $dailyData,
            'percentageData' => $percentageData,
            'percentageChartData' => $percentageChartData,
            'shiftStackedData' => $shiftStackedData,
        ]);
    }
}