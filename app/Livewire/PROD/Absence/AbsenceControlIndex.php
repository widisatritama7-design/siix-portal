<?php
// app/Livewire/PROD/Absence/AbsenceControlIndex.php

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
            $employee = Employee::where('nik', $user->username) // or however you map user to employee
                ->orWhere('email', $user->email)
                ->first();
            
            if ($employee && $employee->department) {
                $this->userDepartment = $employee->department;
                $this->departmentFilter = $employee->department; // Force filter to user's department
            }
            
            Log::info('One User Access - Department: ' . $this->userDepartment);
        }
    }
    
    /**
     * Get departments for filter dropdown (respect user access)
     */
    private function getAvailableDepartments()
    {
        if ($this->isOneUserAccess && $this->userDepartment) {
            // Return only user's department
            return collect([$this->userDepartment]);
        }
        
        // Return all departments
        return Employee::whereIn('status', ['1', '2', '3'])
            ->where('nik', 'REGEXP', '^[0-9]+$')
            ->select('department')
            ->distinct()
            ->pluck('department');
    }
    
    /**
     * Get groups for filter dropdown (respect user access)
     */
    private function getAvailableGroups()
    {
        $query = Employee::whereIn('status', ['1', '2', '3'])
            ->where('nik', 'REGEXP', '^[0-9]+$')
            ->whereNotNull('actual_group');
        
        // Apply department filter if one user access
        if ($this->isOneUserAccess && $this->userDepartment) {
            $query->where('department', $this->userDepartment);
        } elseif ($this->departmentFilter) {
            $query->where('department', $this->departmentFilter);
        }
        
        return $query->select('actual_group')
            ->distinct()
            ->pluck('actual_group');
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
        // Prevent changing department for one user access
        if ($this->isOneUserAccess && $this->userDepartment) {
            $this->departmentFilter = $this->userDepartment;
            $this->dispatch('notify', message: 'You can only view data from your department!', type: 'error');
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
        
        // Untuk one user access, department filter tetap dipertahankan
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
    }

    public function deleteAllData()
    {
        // Check permission for one user access
        if ($this->isOneUserAccess) {
            $this->dispatch('notify', message: 'You do not have permission to delete data!', type: 'error');
            return;
        }
        
        try {
            $deleted = AbsenceControl::deleteForDateRange($this->startDate, $this->endDate);
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
        // Check permission for one user access
        if ($this->isOneUserAccess) {
            $this->dispatch('notify', message: 'You do not have permission to bulk update!', type: 'error');
            return;
        }
        
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
        // Check permission for one user access
        if ($this->isOneUserAccess) {
            $this->dispatch('notify', message: 'You do not have permission to bulk update!', type: 'error');
            return;
        }
        
        $this->validate([
            'bulkField' => 'required|in:' . implode(',', array_keys($this->bulkFields)),
            'bulkValue' => 'required',
        ]);
        
        try {
            $query = Employee::whereIn('id', $this->selectedEmployees);
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
    
    private function getCurrentPageEmployeeIds()
    {
        $query = Employee::query()
            ->whereIn('status', ['1', '2', '3'])
            ->whereRaw('CAST(nik AS UNSIGNED) IS NOT NULL')
            ->whereRaw('nik REGEXP "^[0-9]+$"');
        
        // Apply department filter based on user access
        if ($this->isOneUserAccess && $this->userDepartment) {
            $query->where('department', $this->userDepartment);
        } elseif ($this->departmentFilter) {
            $query->where('department', $this->departmentFilter);
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
    
    // ==================== RENDER METHOD ====================
    
    public function render()
    {
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

        // ==================== 2. GET EMPLOYEES WITH PAGINATION ====================
        $query = Employee::query()
            ->whereIn('status', ['1', '2', '3'])
            ->whereRaw('CAST(nik AS UNSIGNED) IS NOT NULL')
            ->whereRaw('nik REGEXP "^[0-9]+$"');
        
        // Apply department filter based on user access
        if ($this->isOneUserAccess && $this->userDepartment) {
            $query->where('department', $this->userDepartment);
        } elseif ($this->departmentFilter) {
            $query->where('department', $this->departmentFilter);
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
        ]);
    }
}