<?php

namespace App\Livewire\HR;

use App\Models\HR\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeManagement extends Component
{
    use WithPagination;
    
    // Properties untuk filter dan search
    public $search = '';
    public $statusFilter = '';
    public $departmentFilter = '';
    public $perPage = 10;
    public $comelatePage = 1;
    public $violationPage = 1;
    public $employeeCallPage = 1;
    public $perPageComelate = 5;
    public $perPageViolation = 5;
    public $perPageEmployeeCall = 5;
    public $activeTab = 'comelate'; // 'comelate', 'violation', or 'employeecall'
    
    // Properties untuk view modal
    public $showViewModal = false;
    public $selectedEmployee = null;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'departmentFilter' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];
    
    // Reset page when filters change
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingStatusFilter()
    {
        $this->resetPage();
    }
    
    public function updatingDepartmentFilter()
    {
        $this->resetPage();
    }
    
    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function setComelatePage($page)
    {
        $this->comelatePage = $page;
    }
    
    public function setViolationPage($page)
    {
        $this->violationPage = $page;
    }
    
    public function setEmployeeCallPage($page)
    {
        $this->employeeCallPage = $page;
    }
    
    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }
    
    public function getDepartmentsProperty()
    {
        return Employee::whereIn('status', [1, 2, 3]) // Add this to only show departments from active employees
            ->select('department')
            ->distinct()
            ->whereNotNull('department')
            ->pluck('department');
    }
    
    public function view($id)
    {
        // CEK AKSES
        if (!auth()->user()->can('view employee')) {
            $this->dispatch('notify', message: 'You do not have permission to view employee!', type: 'error');
            return;
        }

        $this->comelatePage = 1;
        $this->violationPage = 1;
        $this->employeeCallPage = 1;
        $this->activeTab = 'comelate';
        $this->selectedEmployee = Employee::with(['comelateEmployees' => function($query) {
            $query->orderBy('tanggal', 'desc')
                  ->orderBy('jam', 'desc');
        }, 'violationEmployees' => function($query) {
            $query->orderBy('date', 'desc')
                  ->orderBy('created_at', 'desc');
        }, 'employeeCalls' => function($query) {
            $query->orderBy('date_call', 'desc')
                  ->orderBy('created_at', 'desc');
        }])->findOrFail($id);
        
        $this->showViewModal = true;
    }
    
    // Helper function untuk mendapatkan label status
    public function getStatusLabel($status)
    {
        return match($status) {
            1 => 'Permanent',
            2 => 'Contract',
            3 => 'Magang',
            default => 'Unknown',
        };
    }
    
    // Helper function untuk mendapatkan badge color status
    public function getStatusColor($status)
    {
        return match($status) {
            1 => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
            2 => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
            3 => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300',
        };
    }
    
    // Helper function untuk format shift
    public function formatShift($shift)
    {
        return match($shift) {
            'NS' => 'Non Shift',
            '1' => 'Shift 1',
            '2' => 'Shift 2',
            '3' => 'Shift 3',
            default => $shift,
        };
    }
    
    // Helper function untuk format delay
    public function formatDelay($minutes)
    {
        if (!$minutes || $minutes == 0) {
            return '-';
        }
        
        if ($minutes >= 60) {
            $hours = floor($minutes / 60);
            $remainingMinutes = $minutes % 60;
            
            if ($remainingMinutes > 0) {
                return $hours . ' jam ' . $remainingMinutes . ' menit';
            }
            return $hours . ' jam';
        }
        
        return $minutes . ' menit';
    }

    public function render()
    {
        // CEK AKSES VIEW
        if (!auth()->user()->can('view employee')) {
            abort(403, 'Unauthorized access.');
        }

        $employees = Employee::query()
            ->with(['comelateEmployees', 'violationEmployees', 'employeeCalls'])
            ->whereIn('status', [1, 2, 3]) // Filter only status 1, 2, 3
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nik', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('department', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->departmentFilter, function ($query) {
                $query->where('department', $this->departmentFilter);
            })
            ->orderBy('department', 'asc')
            ->orderBy('nik', 'asc')
            ->paginate($this->perPage);
        
        $statusOptions = [
            1 => 'Permanent',
            2 => 'Contract',
            3 => 'Magang',
        ];
        
        return view('livewire.hr.employee-management', [
            'employees' => $employees,
            'totalEmployees' => Employee::whereIn('status', [1, 2, 3])->count(),
            'permanentEmployees' => Employee::where('status', 1)->count(),
            'contractEmployees' => Employee::where('status', 2)->count(),
            'internEmployees' => Employee::where('status', 3)->count(),
            'statusOptions' => $statusOptions,
        ]);
    }
}