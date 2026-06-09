<?php

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
    public $accessError = null;
    
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
        
        // Debug logging
        Log::info('AbsenceControlGenerate Mounted - User Access:', [
            'user_id' => auth()->id(),
            'user_name' => auth()->user()?->name,
            'user_username' => auth()->user()?->username,
            'can_view_one_user' => auth()->user()?->can('view absence report one user'),
            'isOneUserAccess' => $this->isOneUserAccess,
            'userDepartment' => $this->userDepartment,
            'selectedDepartment' => $this->selectedDepartment,
            'accessError' => $this->accessError
        ]);
    }
    
    /**
     * Check user access and set department filter - FIXED
     */
    private function checkUserAccess()
    {
        $user = auth()->user();
        
        if (!$user) {
            Log::warning('No authenticated user found');
            return;
        }
        
        // Check if user has 'view absence report one user' permission
        if ($user->can('view absence report one user')) {
            $this->isOneUserAccess = true;
            
            // Try multiple methods to find employee (HANYA STATUS 1,2,3)
            $employee = null;
            
            // Method 1: Cari berdasarkan NIK dari username (HANYA STATUS 1,2,3)
            if (!empty($user->username)) {
                $employee = Employee::where('nik', $user->username)
                    ->whereIn('status', ['1', '2', '3'])
                    ->first();
                if ($employee) {
                    Log::info('Employee found by NIK: ' . $user->username);
                }
            }
            
            // Method 2: Cari berdasarkan email (HANYA STATUS 1,2,3)
            if (!$employee && !empty($user->email)) {
                $employee = Employee::where('email', $user->email)
                    ->whereIn('status', ['1', '2', '3'])
                    ->first();
                if ($employee) {
                    Log::info('Employee found by email: ' . $user->email);
                }
            }
            
            // Method 3: Cari berdasarkan nama (HANYA STATUS 1,2,3)
            if (!$employee && !empty($user->name)) {
                $employee = Employee::where('name', 'like', '%' . $user->name . '%')
                    ->whereIn('status', ['1', '2', '3'])
                    ->first();
                if ($employee) {
                    Log::info('Employee found by name: ' . $user->name);
                }
            }
            
            // Method 4: Cari berdasarkan user_id jika ada (HANYA STATUS 1,2,3)
            if (!$employee && !empty($user->id)) {
                $employee = Employee::where('user_id', $user->id)
                    ->whereIn('status', ['1', '2', '3'])
                    ->first();
                if ($employee) {
                    Log::info('Employee found by user_id: ' . $user->id);
                }
            }
            
            // Set department if employee found
            if ($employee && !empty($employee->department)) {
                $this->userDepartment = trim($employee->department);
                $this->selectedDepartment = $this->userDepartment; // Auto select department
                $this->accessError = null;
                
                Log::info('One User Access Generate ACTIVE - Department: ' . $this->userDepartment . ' - Employee Status: ' . $employee->status);
            } else {
                // Employee not found - set error
                $this->accessError = 'Data karyawan tidak ditemukan atau status karyawan tidak aktif. Hubungi administrator.';
                $this->isOneUserAccess = false; // Disable one user access
                
                Log::error('Employee not found for user: ' . $user->name . 
                        ', NIK: ' . $user->username . 
                        ', Email: ' . $user->email);
            }
        } else {
            Log::info('User does not have view absence report one user permission');
        }
    }
    
    /**
     * Load departments based on user access - FIXED
     */
    private function loadDepartments()
    {
        if ($this->isOneUserAccess && $this->userDepartment) {
            // Only load user's department
            $this->departments = [trim($this->userDepartment)];
        } else {
            // Load all departments with trim
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
        
        Log::info('Departments loaded:', ['departments' => $this->departments, 'count' => count($this->departments)]);
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
        // Prevent changing department for one user access - FIXED
        if ($this->isOneUserAccess && $this->userDepartment) {
            $this->selectedDepartment = $this->userDepartment;
            $this->dispatch('notify', message: 'You can only generate data for ' . $this->userDepartment . ' department!', type: 'error');
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
    
    /**
     * Get current page employee IDs - FIXED
     */
    private function getCurrentPageEmployeeIds()
    {
        if (!$this->selectedDepartment) {
            return [];
        }
        
        $employees = Employee::where(DB::raw('TRIM(department)'), '=', trim($this->selectedDepartment))
            ->whereIn('status', ['1', '2', '3'])
            ->where('nik', 'REGEXP', '^[0-9]+$')
            ->orderBy(DB::raw('CAST(nik AS UNSIGNED)'), 'asc')
            ->paginate(10);
        
        return $employees->pluck('id')->toArray();
    }
    
    public function selectAll()
    {
        if (!$this->selectedDepartment) {
            $this->dispatch('notify', message: 'Please select department first!', type: 'error');
            return;
        }
        
        $allEmployeeIds = Employee::where(DB::raw('TRIM(department)'), '=', trim($this->selectedDepartment))
            ->whereIn('status', ['1', '2', '3'])
            ->where('nik', 'REGEXP', '^[0-9]+$')
            ->pluck('id')
            ->toArray();
        
        $this->selectedEmployees = $allEmployeeIds;
        $this->selectAllCheckbox = true;
        
        $this->dispatch('notify', message: count($allEmployeeIds) . ' employees selected', type: 'info');
    }
    
    public function deselectAll()
    {
        $this->selectedEmployees = [];
        $this->selectAllCheckbox = false;
        
        $this->dispatch('notify', message: 'All employees deselected', type: 'info');
    }
    
    public function selectAllGroup($group)
    {
        if (!$this->selectedDepartment) {
            return;
        }
        
        $employees = Employee::where(DB::raw('TRIM(department)'), '=', trim($this->selectedDepartment))
            ->whereIn('status', ['1', '2', '3'])
            ->where('nik', 'REGEXP', '^[0-9]+$')
            ->get();
        
        foreach ($employees as $employee) {
            if (in_array($employee->id, $this->selectedEmployees)) {
                $this->employeeGroups[$employee->id] = $group;
            }
        }
        
        $this->dispatch('notify', message: "Group set to {$group} for all selected employees", type: 'info');
    }
    
    public function selectAllShift($shift)
    {
        if (!$this->selectedDepartment) {
            return;
        }
        
        $employees = Employee::where(DB::raw('TRIM(department)'), '=', trim($this->selectedDepartment))
            ->whereIn('status', ['1', '2', '3'])
            ->where('nik', 'REGEXP', '^[0-9]+$')
            ->get();
        
        foreach ($employees as $employee) {
            if (in_array($employee->id, $this->selectedEmployees)) {
                $this->employeeShifts[$employee->id] = $shift;
            }
        }
        
        $this->dispatch('notify', message: "Shift set to {$shift} for all selected employees", type: 'info');
    }
    
    public function generate()
    {
        // Check permission for one user access - FIXED
        if ($this->isOneUserAccess) {
            if (!$this->userDepartment) {
                $this->generatedMessage = [
                    'type' => 'error',
                    'message' => 'You do not have permission to generate data! ' . ($this->accessError ?? '')
                ];
                return;
            }
            
            // Ensure selected department matches user's department
            if (trim($this->selectedDepartment) !== trim($this->userDepartment)) {
                $this->selectedDepartment = $this->userDepartment;
                $this->generatedMessage = [
                    'type' => 'error',
                    'message' => 'You can only generate data for your department: ' . $this->userDepartment
                ];
                return;
            }
        }
        
        if (empty($this->selectedEmployees)) {
            $this->generatedMessage = [
                'type' => 'error',
                'message' => 'Please select at least one employee to generate'
            ];
            return;
        }
        
        if (!$this->selectedDepartment) {
            $this->generatedMessage = [
                'type' => 'error',
                'message' => 'Please select department first!'
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
            Log::error('Generate error: ' . $e->getMessage());
            $this->generatedMessage = [
                'type' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
        
        $this->isGenerating = false;
    }
    
    /**
     * Generate for selected employees - FIXED
     */
    private function generateForSelectedEmployees()
    {
        $employees = Employee::whereIn('id', $this->selectedEmployees)
            ->where(DB::raw('TRIM(department)'), '=', trim($this->selectedDepartment))
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
        if (!$this->selectedDepartment) {
            $this->generatedMessage = [
                'type' => 'error',
                'message' => 'Please select department first!'
            ];
            return;
        }
        
        $allEmployeeIds = Employee::where(DB::raw('TRIM(department)'), '=', trim($this->selectedDepartment))
            ->whereIn('status', ['1', '2', '3'])
            ->where('nik', 'REGEXP', '^[0-9]+$')
            ->pluck('id')
            ->toArray();
        
        $this->selectedEmployees = $allEmployeeIds;
        $this->generate();
    }
    
    /**
     * Debug method to check user access - ADD THIS FOR DEBUGGING
     */
    public function debugUserAccess()
    {
        $user = auth()->user();
        
        // Try to find employee with different methods
        $employeeByNik = Employee::where('nik', $user->username)->first();
        $employeeByEmail = Employee::where('email', $user->email)->first();
        $employeeByName = Employee::where('name', 'like', '%' . $user->name . '%')->first();
        
        $allDepartments = Employee::whereIn('status', ['1', '2', '3'])
            ->select('department', DB::raw('COUNT(*) as total'))
            ->groupBy('department')
            ->get();
        
        $debug = [
            'user_info' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
            ],
            'permissions' => [
                'view absence report one user' => $user->can('view absence report one user'),
            ],
            'employee_search' => [
                'by_nik' => $employeeByNik ? [
                    'id' => $employeeByNik->id,
                    'nik' => $employeeByNik->nik,
                    'name' => $employeeByNik->name,
                    'department' => $employeeByNik->department,
                ] : null,
                'by_email' => $employeeByEmail ? [
                    'id' => $employeeByEmail->id,
                    'nik' => $employeeByEmail->nik,
                    'name' => $employeeByEmail->name,
                    'department' => $employeeByEmail->department,
                ] : null,
                'by_name' => $employeeByName ? [
                    'id' => $employeeByName->id,
                    'nik' => $employeeByName->nik,
                    'name' => $employeeByName->name,
                    'department' => $employeeByName->department,
                ] : null,
            ],
            'current_access_state' => [
                'isOneUserAccess' => $this->isOneUserAccess,
                'userDepartment' => $this->userDepartment,
                'selectedDepartment' => $this->selectedDepartment,
                'accessError' => $this->accessError,
            ],
            'available_departments_in_db' => $allDepartments->toArray(),
            'loaded_departments' => $this->departments,
        ];
        
        // Return as JSON or dump
        dd($debug);
    }
    
    public function render()
    {
        // FIXED: Early validation for one user access without department
        if ($this->isOneUserAccess && empty($this->userDepartment)) {
            return view('livewire.prod.absence.absence-control-generate', [
                'employeesPaginated' => collect(),
                'currentPageEmployees' => [],
                'isOneUserAccess' => true,
                'userDepartment' => null,
                'accessError' => $this->accessError ?? 'Department not found for your account',
            ]);
        }
        
        $employeesPaginated = collect();
        $currentPageEmployees = [];
        
        if ($this->selectedDepartment) {
            $employeesPaginated = Employee::where(DB::raw('TRIM(department)'), '=', trim($this->selectedDepartment))
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
            'accessError' => $this->accessError,
        ]);
    }
}