<?php
// app/Http/Controllers/PROD/Absence/AbsenceControlPrintController.php

namespace App\Http\Controllers\PROD\Absence;

use App\Http\Controllers\Controller;
use App\Models\HR\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AbsenceControlPrintController extends Controller
{
    public function print($startDate, $endDate, $department = null, $group = null)
    {
        // Parse dates
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        // Build dates list
        $datesList = [];
        $current = clone $start;
        
        while ($current <= $end) {
            $datesList[] = $current->format('Y-m-d');
            $current->addDay();
        }
        
        // Get employees based on filters
        $employees = Employee::query()
            ->whereIn('status', ['1', '2', '3'])
            ->whereRaw('CAST(nik AS UNSIGNED) IS NOT NULL')
            ->whereRaw('nik REGEXP "^[0-9]+$"')
            ->when($department, function ($query) use ($department) {
                $query->where('department', $department);
            })
            ->when($group, function ($query) use ($group) {
                $query->where('actual_group', $group);
            })
            ->orderBy(DB::raw('CAST(nik AS UNSIGNED)'), 'asc')
            ->get();
        
        $employeeIds = $employees->pluck('id')->toArray();
        
        // Get absence control data
        $absenceMap = [];
        $statusMap = [];
        
        if (!empty($employeeIds) && !empty($datesList)) {
            $controls = DB::table('tb_prod_absence_control')
                ->whereIn('employee_id', $employeeIds)
                ->whereBetween('date', [$startDate, $endDate])
                ->get();
            
            foreach ($controls as $control) {
                $empId = $control->employee_id;
                $date = $control->date;
                $absenceMap[$empId][$date] = $control->actual_shift;
                $statusMap[$empId][$date] = $control->status_date ?? 'Normal';
            }
        }
        
        // Prepare data per employee
        $employeeData = [];
        $grandTotals = [
            'SD' => 0,
            'IJ' => 0,
            'A' => 0,
            'CK' => 0,
            'CT' => 0,
            'total_dates' => 0,
            'total_present' => 0,
            'total_employees' => 0
        ];
        
        $statusMapEmployee = [
            '1' => 'Permanent',
            '2' => 'Contract',
            '3' => 'Magang',
            '4' => 'Finish Contract',
            '5' => 'Resign',
        ];
        
        foreach ($employees as $index => $employee) {
            $employeeAbsenceMap = $absenceMap[$employee->id] ?? [];
            $employeeStatusMap = $statusMap[$employee->id] ?? [];
            
            $absenceCount = ['SD' => 0, 'IJ' => 0, 'A' => 0, 'CK' => 0, 'CT' => 0];
            $totalValidDates = 0;
            $totalPresent = 0;
            
            foreach ($datesList as $date) {
                $actualShift = $employeeAbsenceMap[$date] ?? null;
                $statusDate = $employeeStatusMap[$date] ?? 'Normal';
                
                if ($statusDate !== 'Holiday') {
                    if (!is_null($actualShift) && $actualShift !== '') {
                        $totalValidDates++;
                        
                        if (in_array($actualShift, ['SD', 'IJ', 'A', 'CK', 'CT'])) {
                            $absenceCount[$actualShift]++;
                        } else {
                            $totalPresent++;
                        }
                    }
                }
            }
            
            $totalAbsence = array_sum($absenceCount);
            $ratio = $totalValidDates > 0 ? ($totalPresent / $totalValidDates) * 100 : 0;
            
            $employeeData[] = [
                'no' => $index + 1,
                'nik' => $employee->nik,
                'name' => $employee->name,
                'department' => $employee->department,
                'status' => $statusMapEmployee[$employee->status] ?? $employee->status,
                'doj' => $employee->contract_date ? Carbon::parse($employee->contract_date)->format('d-m-Y') : '-',
                'group' => $employee->actual_group ?? '-',
                'absence' => $absenceCount,
                'total_absence' => $totalAbsence,
                'total_dates' => $totalValidDates,
                'total_present' => $totalPresent,
                'ratio' => $ratio,
            ];
            
            // Accumulate grand totals
            $grandTotals['SD'] += $absenceCount['SD'];
            $grandTotals['IJ'] += $absenceCount['IJ'];
            $grandTotals['A'] += $absenceCount['A'];
            $grandTotals['CK'] += $absenceCount['CK'];
            $grandTotals['CT'] += $absenceCount['CT'];
            $grandTotals['total_dates'] += $totalValidDates;
            $grandTotals['total_present'] += $totalPresent;
            $grandTotals['total_employees']++;
        }
        
        // Calculate grand total percentage ratio
        $grandTotals['total_absence'] = $grandTotals['SD'] + $grandTotals['IJ'] + $grandTotals['A'] + $grandTotals['CK'] + $grandTotals['CT'];
        $grandTotals['ratio'] = $grandTotals['total_dates'] > 0 
            ? ($grandTotals['total_present'] / $grandTotals['total_dates']) * 100 
            : 0;
        
        // Get department string for display
        $departmentString = $department ?: 'All Departments';
        $groupString = $group ?: 'All Groups';
        
        $data = [
            'startDate' => $start->format('d F Y'),
            'endDate' => $end->format('d F Y'),
            'departmentString' => $departmentString,
            'groupString' => $groupString,
            'employeeData' => $employeeData,
            'grandTotals' => $grandTotals,
            'printedBy' => auth()->user()->name ?? 'System',
            'printedAt' => now()->format('d F Y H:i'),
        ];
        
        $pdf = Pdf::loadView('livewire.prod.absence.absence-control-report', $data);
        $pdf->setPaper('A4', 'landscape');
        
        $filename = 'absence-control-report-' . ($department ?: 'all') . '-' . $startDate . '-to-' . $endDate . '.pdf';
        $filename = str_replace(' ', '-', $filename);
        
        return $pdf->stream($filename);
    }
}