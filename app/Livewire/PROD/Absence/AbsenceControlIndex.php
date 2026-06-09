<?php

namespace App\Livewire\PROD\Absence;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HR\Employee;
use App\Models\PROD\Absence\AbsenceControl;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AbsenceControlIndex extends Component
{
    use WithPagination;

    public $startDate = '';
    public $endDate = '';
    public $isGenerating = false;
    public $search = '';
    public $departmentFilter = '';
    public $groupFilter = '';
    
    // Bulk Action Properties
    public $showBulkModal = false;
    public $selectedEmployees = [];
    public $selectAll = false;
    public $bulkField = '';
    public $bulkValue = '';
    
    // Inline Edit Properties
    public $editingEmployeeId = null;
    public $editingDate = null;
    public $editingValue = null;
    
    // User Access Properties
    public $userDepartment = null;
    public $isOneUserAccess = false;
    public $accessError = null;
    
    protected $paginationTheme = 'tailwind';
    
    public $bulkFields = [
        'actual_group' => 'Actual Group',
        'actual_section' => 'Actual Section',
        'actual_process' => 'Actual Process',
        'actual_route' => 'Actual Route',
        'actual_titik_jemputan' => 'Titik Jemputan',
        'actual_shift' => 'Actual Shift',
    ];
    
    public $bulkGroupOptions = [
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
    
    public $bulkShiftOptions = [
        '1' => 'Shift 1',
        '2' => 'Shift 2',
        '3' => 'Shift 3',
        'NS' => 'NS (Non Shift)',
        'NS1' => 'NS1 (Non Shift 1)',
    ];
    
    public $inlineShiftOptions = [
        '1' => 'Shift 1',
        '2' => 'Shift 2',
        '3' => 'Shift 3',
        'NS' => 'NS',
        'NS1' => 'NS1',
        '' => 'Holiday'
    ];

    public function mount()
    {
        $this->checkUserAccess();
        $this->setDefaultDateRange();
        
        // Debug logging
        Log::info('AbsenceControlIndex Mounted - User Access:', [
            'user_id' => auth()->id(),
            'user_name' => auth()->user()?->name,
            'user_username' => auth()->user()?->username,
            'user_email' => auth()->user()?->email,
            'can_view_one_user' => auth()->user()?->can('view absence report one user'),
            'isOneUserAccess' => $this->isOneUserAccess,
            'userDepartment' => $this->userDepartment,
            'departmentFilter' => $this->departmentFilter,
            'accessError' => $this->accessError
        ]);
    }
    
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
                $this->departmentFilter = $this->userDepartment;
                $this->accessError = null;
                
                Log::info('One User Access ACTIVE - Department: ' . $this->userDepartment . ' - Employee Status: ' . $employee->status);
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
     * Get departments for filter dropdown (respect user access) - FIXED
     */
    private function getAvailableDepartments()
    {
        if ($this->isOneUserAccess && $this->userDepartment) {
            // Return only user's department
            return collect([trim($this->userDepartment)]);
        }
        
        // Return all departments with trim
        $departments = Employee::whereIn('status', ['1', '2', '3'])
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
            ->values();
        
        return $departments;
    }
    
    /**
     * Get groups for filter dropdown (respect user access) - FIXED
     */
    private function getAvailableGroups()
    {
        $query = Employee::whereIn('status', ['1', '2', '3'])
            ->where('nik', 'REGEXP', '^[0-9]+$')
            ->whereNotNull('actual_group');
        
        // Apply department filter with trim
        if ($this->isOneUserAccess && $this->userDepartment) {
            $query->where(DB::raw('TRIM(department)'), '=', trim($this->userDepartment));
        } elseif ($this->departmentFilter) {
            $query->where(DB::raw('TRIM(department)'), '=', trim($this->departmentFilter));
        }
        
        return $query->select('actual_group')
            ->distinct()
            ->pluck('actual_group')
            ->filter()
            ->values();
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

    public function updatedSearch()
    {
        $this->resetPage();
        $this->selectedEmployees = [];
        $this->selectAll = false;
    }

    public function updatedDepartmentFilter()
    {
        // Prevent changing department for one user access - FIXED
        if ($this->isOneUserAccess && $this->userDepartment) {
            $this->departmentFilter = $this->userDepartment;
            $this->dispatch('notify', message: 'You can only view data from ' . $this->userDepartment . ' department!', type: 'error');
            return;
        }
        
        $this->resetPage();
        $this->selectedEmployees = [];
        $this->selectAll = false;
    }

    public function updatedGroupFilter()
    {
        $this->resetPage();
        $this->selectedEmployees = [];
        $this->selectAll = false;
    }

    public function resetFilters()
    {
        $this->search = '';
        
        // For one user access, keep department filter - FIXED
        if ($this->isOneUserAccess && $this->userDepartment) {
            $this->departmentFilter = $this->userDepartment;
            $this->groupFilter = '';
        } else {
            $this->departmentFilter = '';
            $this->groupFilter = '';
        }
        
        $this->resetPage();
        $this->selectedEmployees = [];
        $this->selectAll = false;
        
        $this->dispatch('notify', message: 'Filters have been reset', type: 'info');
    }

    public function deleteAllData()
    {
        // HAPUS 5 baris ini jika one user access boleh delete:
        // if ($this->isOneUserAccess) {
        //     $this->dispatch('notify', message: 'You do not have permission to delete data!', type: 'error');
        //     return;
        // }
        
        try {
            // TAMBAHKAN ini untuk one user access:
            if ($this->isOneUserAccess && $this->userDepartment) {
                $employeeIds = Employee::where(DB::raw('TRIM(department)'), '=', trim($this->userDepartment))
                    ->pluck('id')
                    ->toArray();
                
                $deleted = AbsenceControl::whereIn('employee_id', $employeeIds)
                    ->whereBetween('date', [$this->startDate, $this->endDate])
                    ->delete();
            } else {
                $deleted = AbsenceControl::deleteForDateRange($this->startDate, $this->endDate);
            }
            
            $this->dispatch('notify', message: "Deleted {$deleted} records successfully!", type: 'success');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Error: ' . $e->getMessage(), type: 'error');
        }
    }
    
    // ==================== INLINE EDIT METHODS ====================
    
    private function canEditDate($date)
    {
        $today = Carbon::today();
        $editDate = Carbon::parse($date);
        
        // Hanya bisa edit tanggal hari ini atau yang akan datang
        return $editDate->greaterThanOrEqualTo($today);
    }

    public function startEdit($employeeId, $date, $currentValue)
    {
        Log::info('startEdit dipanggil', [
            'employee_id' => $employeeId,
            'date' => $date,
            'current_value' => $currentValue
        ]);
        
        // Cek apakah tanggal bisa diedit (hari ini atau future)
        $today = Carbon::today();
        $editDate = Carbon::parse($date);
        
        if ($editDate->lessThan($today)) {
            $this->dispatch('notify', message: 'Tidak bisa edit tanggal yang sudah lewat!', type: 'error');
            return;
        }
        
        // Cek apakah value adalah ketidakhadiran (tetap tidak bisa diedit)
        $absenceTypes = ['CT', 'SD', 'IJ', 'A', 'CK', 'CM'];
        if (in_array($currentValue, $absenceTypes)) {
            $this->dispatch('notify', message: 'Tidak bisa edit data ketidakhadiran!', type: 'error');
            return;
        }
        
        $this->editingEmployeeId = $employeeId;
        $this->editingDate = $date;
        
        // Jika current value adalah 'H' (holiday), set editingValue kosong atau shift default
        if ($currentValue === 'H') {
            $this->editingValue = '1'; // default shift 1
        } else {
            $this->editingValue = $currentValue;
        }
        
        Log::info('Editing started', [
            'employee_id' => $this->editingEmployeeId,
            'date' => $this->editingDate,
            'value' => $this->editingValue
        ]);
    }

    public function saveEdit()
    {
        Log::info('saveEdit dipanggil', [
            'employee_id' => $this->editingEmployeeId,
            'date' => $this->editingDate,
            'value' => $this->editingValue
        ]);
        
        if (!$this->editingEmployeeId || !$this->editingDate) {
            Log::info('Tidak ada data editing');
            return;
        }
        
        try {
            DB::beginTransaction();
            
            // Cek apakah user memilih Holiday (value kosong)
            $isHoliday = ($this->editingValue === '');
            
            if ($isHoliday) {
                // Jika memilih Holiday
                $absenceControl = AbsenceControl::updateOrCreate(
                    [
                        'employee_id' => $this->editingEmployeeId,
                        'date' => $this->editingDate,
                    ],
                    [
                        'actual_shift' => null,
                        'status_date' => 'Holiday',
                    ]
                );
                
                Log::info('Holiday updated', ['id' => $absenceControl->id]);
                
                // Update tb_hr_employee - actual_shift (set null atau kosong)
                DB::table('tb_hr_employee')
                    ->where('id', $this->editingEmployeeId)
                    ->update(['actual_shift' => null]);
            } else {
                // Jika memilih shift normal
                $absenceControl = AbsenceControl::updateOrCreate(
                    [
                        'employee_id' => $this->editingEmployeeId,
                        'date' => $this->editingDate,
                    ],
                    [
                        'actual_shift' => $this->editingValue,
                        'status_date' => 'Normal',
                    ]
                );
                
                Log::info('Shift updated', [
                    'id' => $absenceControl->id,
                    'status_date' => $absenceControl->status_date
                ]);
                
                // Update tb_hr_employee - actual_shift
                DB::table('tb_hr_employee')
                    ->where('id', $this->editingEmployeeId)
                    ->update(['actual_shift' => $this->editingValue]);
            }
            
            DB::commit();
            
            $message = $isHoliday ? 'Berhasil diubah menjadi Holiday!' : 'Shift berhasil diupdate!';
            $this->dispatch('notify', message: $message, type: 'success');
            
            // Reset
            $this->editingEmployeeId = null;
            $this->editingDate = null;
            $this->editingValue = null;
            
            // Refresh data
            $this->resetPage();
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saveEdit: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error: ' . $e->getMessage(), type: 'error');
        }
    }
    
    public function cancelEdit()
    {
        $this->editingEmployeeId = null;
        $this->editingDate = null;
        $this->editingValue = null;
    }
    
    // ==================== BULK ACTION METHODS ====================
    
    public function openBulkModal()
    {
        // HAPUS 5 baris ini:
        // if ($this->isOneUserAccess) {
        //     $this->dispatch('notify', message: 'You do not have permission to bulk update!', type: 'error');
        //     return;
        // }
        
        if (empty($this->selectedEmployees) && !$this->selectAll) {
            $this->dispatch('notify', message: 'Please select at least one employee', type: 'error');
            return;
        }
        $this->bulkField = '';
        $this->bulkValue = '';
        $this->dispatch('open-bulk-modal');
    }
    
    public function closeBulkModal()
    {
        $this->dispatch('close-bulk-modal');
        $this->bulkField = '';
        $this->bulkValue = '';
    }
    
    public function updatedSelectAll($value)
    {
        if ($value) {
            $employeeIds = $this->getCurrentPageEmployeeIds();
            $this->selectedEmployees = $employeeIds;
        } else {
            $this->selectedEmployees = [];
        }
    }
    
    public function updatedSelectedEmployees()
    {
        $this->selectAll = false;
    }
    
    public function applyBulkUpdate()
    {
        // HAPUS 5 baris ini:
        // if ($this->isOneUserAccess) {
        //     $this->dispatch('notify', message: 'You do not have permission to bulk update!', type: 'error');
        //     return;
        // }
        
        $this->validate([
            'bulkField' => 'required|in:' . implode(',', array_keys($this->bulkFields)),
            'bulkValue' => 'required',
        ]);
        
        try {
            $query = Employee::whereIn('id', $this->selectedEmployees);
            
            // TAMBAHKAN ini untuk one user access:
            if ($this->isOneUserAccess && $this->userDepartment) {
                $query->where(DB::raw('TRIM(department)'), '=', trim($this->userDepartment));
            }
            
            $count = $query->count();
            $this->dispatch('close-bulk-modal');
            
            $query->update([$this->bulkField => $this->bulkValue]);
            
            $this->dispatch('notify', message: "Successfully updated {$count} employees - {$this->bulkFields[$this->bulkField]} set to '{$this->bulkValue}'", type: 'success');
            
            $this->selectedEmployees = [];
            $this->selectAll = false;
            $this->bulkField = '';
            $this->bulkValue = '';
            
            $this->resetPage();
            
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Error: ' . $e->getMessage(), type: 'error');
        }
    }
    
    /**
     * Get current page employee IDs - FIXED
     */
    private function getCurrentPageEmployeeIds()
    {
        $query = Employee::query()
            ->whereIn('status', ['1', '2', '3'])
            ->whereRaw('CAST(nik AS UNSIGNED) IS NOT NULL')
            ->whereRaw('nik REGEXP "^[0-9]+$"');
        
        // Apply department filter with TRIM - FIXED
        if ($this->isOneUserAccess && $this->userDepartment) {
            $query->where(DB::raw('TRIM(department)'), '=', trim($this->userDepartment));
        } elseif ($this->departmentFilter) {
            $query->where(DB::raw('TRIM(department)'), '=', trim($this->departmentFilter));
        }
        
        $employees = $query
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nik', 'like', '%' . $this->search . '%')
                      ->orWhere('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->groupFilter, function ($query) {
                $query->where('actual_group', $this->groupFilter);
            })
            ->orderBy(DB::raw('CAST(nik AS UNSIGNED)'), 'asc')
            ->paginate(10);
            
        return $employees->pluck('id')->toArray();
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
                'departmentFilter' => $this->departmentFilter,
                'accessError' => $this->accessError,
            ],
            'available_departments_in_db' => $allDepartments->toArray(),
        ];
        
        // Return as JSON or dump
        dd($debug);
    }
    
    // ==================== RENDER METHOD - FIXED ====================
    
    public function render()
    {
        // FIXED: Early validation for one user access without department
        if ($this->isOneUserAccess && empty($this->userDepartment)) {
            return view('livewire.prod.absence.absence-control-index', [
                'tableData' => [],
                'employees' => collect(),
                'dateHeaders' => [],
                'departments' => collect(),
                'groups' => collect(),
                'isOneUserAccess' => true,
                'userDepartment' => null,
                'accessError' => $this->accessError ?? 'Department not found for your account',
            ]);
        }
        
        // ==================== 1. BUILD DATES LIST ====================
        $datesList = [];
        $dateHeaders = [];
        
        if ($this->startDate && $this->endDate) {
            $start = Carbon::parse($this->startDate);
            $end = Carbon::parse($this->endDate);
            $current = clone $start;
            
            while ($current <= $end) {
                $dateStr = $current->format('Y-m-d');
                $datesList[] = $dateStr;
                $dateHeaders[] = [
                    'date' => $dateStr,
                    'display' => $current->format('d'),
                    'day' => $current->format('D'),
                    'month' => $current->format('M')
                ];
                $current->addDay();
            }
        }

        // ==================== 2. GET EMPLOYEES WITH PAGINATION - FIXED ====================
        $query = Employee::query()
            ->whereIn('status', ['1', '2', '3'])
            ->whereRaw('CAST(nik AS UNSIGNED) IS NOT NULL')
            ->whereRaw('nik REGEXP "^[0-9]+$"');
        
        // Apply department filter with TRIM for consistency - FIXED
        if ($this->isOneUserAccess && $this->userDepartment) {
            $query->where(DB::raw('TRIM(department)'), '=', trim($this->userDepartment));
        } elseif ($this->departmentFilter) {
            $query->where(DB::raw('TRIM(department)'), '=', trim($this->departmentFilter));
        }
        
        $employees = $query
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nik', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->groupFilter, function ($query) {
                $query->where('actual_group', $this->groupFilter);
            })
            ->orderBy(DB::raw('CAST(nik AS UNSIGNED)'), 'asc')
            ->paginate(10);

        // ==================== 3. GET ABSENCE CONTROL DATA FOR DAILY DISPLAY ====================
        $employeeIds = $employees->pluck('id')->toArray();
        $absenceMap = [];
        $statusMap = [];
        
        if (!empty($employeeIds) && !empty($datesList)) {
            $controls = DB::table('tb_prod_absence_control')
                ->whereIn('employee_id', $employeeIds)
                ->whereBetween('date', [$this->startDate, $this->endDate])
                ->get();
            
            foreach ($controls as $control) {
                $empId = $control->employee_id;
                $date = $control->date;
                $shift = $control->actual_shift;
                $status = $control->status_date;
                $absenceMap[$empId][$date] = $shift;
                $statusMap[$empId][$date] = $status;
            }
        }

        // ==================== 4. GET ABSENCE CONTROL DATA FOR ACCUMULATION ====================
        $absenceControlData = [];
        
        if (!empty($employeeIds) && !empty($datesList)) {
            $allAbsenceControls = AbsenceControl::whereIn('employee_id', $employeeIds)
                ->whereBetween('date', [$this->startDate, $this->endDate])
                ->get();
            
            $absenceTypes = ['CT', 'SD', 'IJ', 'A', 'CK', 'CM'];
            
            foreach ($allAbsenceControls as $control) {
                $empId = $control->employee_id;
                $shift = $control->actual_shift;
                
                if (!is_null($shift) && in_array($shift, $absenceTypes)) {
                    if (!isset($absenceControlData[$empId][$shift])) {
                        $absenceControlData[$empId][$shift] = 0;
                    }
                    $absenceControlData[$empId][$shift]++;
                }
            }
        }

        // ==================== 5. BUILD TABLE DATA ====================
        $tableData = [];
        $no = ($employees->currentPage() - 1) * $employees->perPage() + 1;

        foreach ($employees as $employee) {
            $employeeAbsenceMap = $absenceMap[$employee->id] ?? [];
            $employeeStatusMap = $statusMap[$employee->id] ?? [];
            
            $dailyData = [];
            $dailyStatus = [];
            foreach ($datesList as $date) {
                $dailyData[$date] = $employeeAbsenceMap[$date] ?? '';
                $dailyStatus[$date] = $employeeStatusMap[$date] ?? 'Normal';
            }
            
            $totalValidDates = 0;
            $totalHoliday = 0;
            
            foreach ($datesList as $date) {
                $statusDate = $employeeStatusMap[$date] ?? 'Normal';
                $actualShift = $employeeAbsenceMap[$date] ?? null;
                
                if ($statusDate === 'Holiday') {
                    $totalHoliday++;
                } else {
                    if (!is_null($actualShift) && $actualShift !== '') {
                        $totalValidDates++;
                    }
                }
            }
            
            $totalDates = $totalValidDates;
            
            $empAbsence = $absenceControlData[$employee->id] ?? [];
            $absenceCount = [
                'SD' => $empAbsence['SD'] ?? 0,
                'IJ' => $empAbsence['IJ'] ?? 0,
                'A' => $empAbsence['A'] ?? 0,
                'CK' => $empAbsence['CK'] ?? 0,
                'CT' => $empAbsence['CT'] ?? 0,
            ];
            
            $totalPresent = 0;
            foreach ($datesList as $date) {
                $actualShift = $employeeAbsenceMap[$date] ?? null;
                $statusDate = $employeeStatusMap[$date] ?? 'Normal';
                $absenceTypes = ['CT', 'SD', 'IJ', 'A', 'CK', 'CM'];
                
                if ($statusDate !== 'Holiday' && !is_null($actualShift) && $actualShift !== '' && !in_array($actualShift, $absenceTypes)) {
                    $totalPresent++;
                }
            }
            
            $totalAbsence = array_sum($absenceCount);
            $ratio = $totalDates > 0 ? ($totalPresent / $totalDates) * 100 : 0;
            
            $tableData[] = [
                'no' => $no++,
                'employee' => $employee,
                'daily_data' => $dailyData,
                'daily_status' => $dailyStatus,
                'absence_count' => $absenceCount,
                'total_absence' => $totalAbsence,
                'total_dates' => $totalDates,
                'total_holiday' => $totalHoliday,
                'total_present' => $totalPresent,
                'ratio' => $ratio,
                'target' => 100,
                'meet_target' => $ratio >= 100
            ];
        }
        
        // ==================== GET FILTER OPTIONS ====================
        $departments = $this->getAvailableDepartments();
        $groups = $this->getAvailableGroups();

        return view('livewire.prod.absence.absence-control-index', [
            'tableData' => $tableData,
            'employees' => $employees,
            'dateHeaders' => $dateHeaders,
            'departments' => $departments,
            'groups' => $groups,
            'isOneUserAccess' => $this->isOneUserAccess,
            'userDepartment' => $this->userDepartment,
            'accessError' => $this->accessError,
        ]);
    }
}