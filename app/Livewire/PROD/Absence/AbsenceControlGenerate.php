<?php
// app/Livewire/PROD/Absence/AbsenceControlGenerate.php

namespace App\Livewire\PROD\Absence;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HR\Employee;
use App\Models\PROD\Absence\AbsenceControl;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AbsenceControlGenerate extends Component
{
    use WithPagination;

    public $startDate = '';
    public $endDate = '';
    public $selectedDepartment = '';
    public $departments = [];
    public $employeeGroups = [];
    public $employeeShifts = [];
    public $selectedEmployees = [];
    public $selectAllCheckbox = false;
    public $isGenerating = false;
    public $generatedMessage = null;
    
    // User Access Properties
    public $userDepartment = null;
    public $isOneUserAccess = false;
    
    protected $paginationTheme = 'tailwind';
    
    public $groupOptions = [
        'NS' => 'NS (Sabtu & Minggu Libur)',
        'NS1' => 'NS1 (Minggu Libur)',
        'GA' => 'GA (Minggu Libur)',
        'GB' => 'GB (Minggu Libur)',
        'GC' => 'GC (Minggu Libur)',
        'TB' => 'TB (Minggu Libur)',
        'TA' => 'TA (Minggu Libur)',
        'TC' => 'TC (Minggu Libur)',
        'A3G3S' => 'A3G3S (Minggu Libur)',
        'B3G3S' => 'B3G3S (Minggu Libur)',
        'C3G3S' => 'C3G3S (Minggu Libur)',
    ];
    
    public $shiftOptions = [
        '1' => 'Shift 1',
        '2' => 'Shift 2',
        '3' => 'Shift 3',
        'NS' => 'NS (Non Shift)',
        'NS1' => 'NS1 (Non Shift 1)',
    ];
    
    public $holidayConfig = [
        'NS' => ['Saturday', 'Sunday'],
        'NS1' => ['Sunday'],
        'GA' => ['Sunday'],
        'GB' => ['Sunday'],
        'GC' => ['Sunday'],
        'TB' => ['Sunday'],
        'TA' => ['Sunday'],
        'TC' => ['Sunday'],
        'A3G3S' => ['Sunday'],
        'B3G3S' => ['Sunday'],
        'C3G3S' => ['Sunday'],
    ];
    
    public function mount()
    {
        $this->checkUserAccess();
        $this->loadDepartments();
        $this->setDefaultDateRange();
    }
    
    /**
     * Check user access and set department filter
     */
    private function checkUserAccess()
    {
        $user = auth()->user();
        
        // Check if user has 'view absence report one user' permission
        if ($user && $user->can('view absence report one user')) {
            $this->isOneUserAccess = true;
            
            // Get user's department from employee data
            $employee = Employee::where('nik', $user->username)
                ->orWhere('email', $user->email)
                ->first();
            
            if ($employee && $employee->department) {
                $this->userDepartment = $employee->department;
                $this->selectedDepartment = $employee->department; // Auto select department
            }
            
            Log::info('One User Access Generate - Department: ' . $this->userDepartment);
        }
    }
    
    /**
     * Load departments based on user access
     */
    private function loadDepartments()
    {
        if ($this->isOneUserAccess && $this->userDepartment) {
            // Only load user's department
            $this->departments = [$this->userDepartment];
        } else {
            // Load all departments
            $this->departments = Employee::whereIn('status', ['1', '2', '3'])
                ->where('nik', 'REGEXP', '^[0-9]+$')
                ->select('department')
                ->distinct()
                ->pluck('department')
                ->toArray();
        }
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
    
    public function updatedSelectedDepartment()
    {
        // Prevent changing department for one user access
        if ($this->isOneUserAccess && $this->userDepartment) {
            $this->selectedDepartment = $this->userDepartment;
            $this->dispatch('notify', message: 'You can only generate data for your department!', type: 'error');
            return;
        }
        
        $this->resetPage();
        $this->employeeGroups = [];
        $this->employeeShifts = [];
        $this->selectedEmployees = [];
        $this->selectAllCheckbox = false;
    }
    
    public function updatedSelectAllCheckbox($value)
    {
        if ($value) {
            $currentPageEmployeeIds = $this->getCurrentPageEmployeeIds();
            $this->selectedEmployees = array_merge($this->selectedEmployees, $currentPageEmployeeIds);
            $this->selectedEmployees = array_unique($this->selectedEmployees);
        } else {
            $currentPageEmployeeIds = $this->getCurrentPageEmployeeIds();
            $this->selectedEmployees = array_diff($this->selectedEmployees, $currentPageEmployeeIds);
            $this->selectedEmployees = array_values($this->selectedEmployees);
        }
    }
    
    public function selectAll()
    {
        $allEmployeeIds = Employee::where('department', $this->selectedDepartment)
            ->whereIn('status', ['1', '2', '3'])
            ->where('nik', 'REGEXP', '^[0-9]+$')
            ->pluck('id')
            ->toArray();
        
        $this->selectedEmployees = $allEmployeeIds;
        $this->selectAllCheckbox = true;
    }
    
    public function deselectAll()
    {
        $this->selectedEmployees = [];
        $this->selectAllCheckbox = false;
    }
    
    private function getCurrentPageEmployeeIds()
    {
        $employees = Employee::where('department', $this->selectedDepartment)
            ->whereIn('status', ['1', '2', '3'])
            ->where('nik', 'REGEXP', '^[0-9]+$')
            ->orderBy(DB::raw('CAST(nik AS UNSIGNED)'), 'asc')
            ->paginate(10);
        
        return $employees->pluck('id')->toArray();
    }
    
    public function selectAllGroup($group)
    {
        $employees = Employee::where('department', $this->selectedDepartment)
            ->whereIn('status', ['1', '2', '3'])
            ->where('nik', 'REGEXP', '^[0-9]+$')
            ->get();
        
        foreach ($employees as $employee) {
            if (in_array($employee->id, $this->selectedEmployees)) {
                $this->employeeGroups[$employee->id] = $group;
            }
        }
    }
    
    public function selectAllShift($shift)
    {
        $employees = Employee::where('department', $this->selectedDepartment)
            ->whereIn('status', ['1', '2', '3'])
            ->where('nik', 'REGEXP', '^[0-9]+$')
            ->get();
        
        foreach ($employees as $employee) {
            if (in_array($employee->id, $this->selectedEmployees)) {
                $this->employeeShifts[$employee->id] = $shift;
            }
        }
    }
    
    public function generate()
    {
        // Check permission for one user access
        if ($this->isOneUserAccess && !$this->userDepartment) {
            $this->generatedMessage = [
                'type' => 'error',
                'message' => 'You do not have permission to generate data!'
            ];
            return;
        }
        
        if (empty($this->selectedEmployees)) {
            $this->generatedMessage = [
                'type' => 'error',
                'message' => 'Please select at least one employee to generate'
            ];
            return;
        }
        
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'selectedDepartment' => 'required',
        ]);
        
        $this->isGenerating = true;
        $this->generatedMessage = null;
        
        DB::beginTransaction();
        try {
            $result = $this->generateForSelectedEmployees();
            
            if ($result['success']) {
                DB::commit();
                $this->generatedMessage = [
                    'type' => 'success',
                    'message' => $result['message']
                ];
                $this->dispatch('notify', message: $result['message'], type: 'success');
            } else {
                DB::rollBack();
                $this->generatedMessage = [
                    'type' => 'error',
                    'message' => $result['message']
                ];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->generatedMessage = [
                'type' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
        
        $this->isGenerating = false;
    }
    
    private function generateForSelectedEmployees()
    {
        $employees = Employee::whereIn('id', $this->selectedEmployees)
            ->where('department', $this->selectedDepartment)
            ->whereIn('status', ['1', '2', '3'])
            ->where('nik', 'REGEXP', '^[0-9]+$')
            ->get();
        
        if ($employees->isEmpty()) {
            return [
                'success' => false,
                'message' => 'No selected employees found'
            ];
        }
        
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);
        
        $generated = 0;
        $updatedGroups = 0;
        $updatedShifts = 0;
        
        foreach ($employees as $employee) {
            $selectedGroup = $this->employeeGroups[$employee->id] ?? $employee->actual_group;
            
            if (empty($selectedGroup) || !isset($this->groupOptions[$selectedGroup])) {
                $selectedGroup = 'NS1';
            }
            
            if ($employee->actual_group !== $selectedGroup) {
                $employee->actual_group = $selectedGroup;
                $employee->save();
                $updatedGroups++;
            }
            
            $selectedShift = $this->employeeShifts[$employee->id] ?? $employee->actual_shift;
            
            if (empty($selectedShift) || !isset($this->shiftOptions[$selectedShift])) {
                $selectedShift = '1';
            }
            
            if ($employee->actual_shift !== $selectedShift) {
                $employee->actual_shift = $selectedShift;
                $employee->save();
                $updatedShifts++;
            }
            
            $holidays = $this->holidayConfig[$selectedGroup] ?? ['Sunday'];
            
            $currentDate = clone $start;
            
            while ($currentDate <= $end) {
                $dateStr = $currentDate->format('Y-m-d');
                $dayName = $currentDate->format('l');
                
                $isHoliday = in_array($dayName, $holidays);
                $statusDate = $isHoliday ? 'Holiday' : 'Normal';
                $actualShift = $isHoliday ? null : $selectedShift;
                
                AbsenceControl::updateOrCreate(
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
        
        return [
            'success' => true,
            'message' => "Generated {$generated} records for " . $employees->count() . " employees. Updated {$updatedGroups} groups and {$updatedShifts} shifts."
        ];
    }
    
    public function generateAll()
    {
        $allEmployeeIds = Employee::where('department', $this->selectedDepartment)
            ->whereIn('status', ['1', '2', '3'])
            ->where('nik', 'REGEXP', '^[0-9]+$')
            ->pluck('id')
            ->toArray();
        
        $this->selectedEmployees = $allEmployeeIds;
        $this->generate();
    }
    
    public function render()
    {
        $employeesPaginated = collect();
        $currentPageEmployees = [];
        
        if ($this->selectedDepartment) {
            $employeesPaginated = Employee::where('department', $this->selectedDepartment)
                ->whereIn('status', ['1', '2', '3'])
                ->where('nik', 'REGEXP', '^[0-9]+$')
                ->orderBy(DB::raw('CAST(nik AS UNSIGNED)'), 'asc')
                ->paginate(10);
            
            $currentPageEmployees = $employeesPaginated->items();
            
            foreach ($currentPageEmployees as $employee) {
                if (!isset($this->employeeGroups[$employee->id])) {
                    $this->employeeGroups[$employee->id] = $employee->actual_group ?? 'NS1';
                }
                
                if (!isset($this->employeeShifts[$employee->id])) {
                    $this->employeeShifts[$employee->id] = $employee->actual_shift ?? '1';
                }
            }
        }
        
        return view('livewire.prod.absence.absence-control-generate', [
            'employeesPaginated' => $employeesPaginated,
            'currentPageEmployees' => $currentPageEmployees,
            'isOneUserAccess' => $this->isOneUserAccess,
            'userDepartment' => $this->userDepartment,
        ]);
    }
}