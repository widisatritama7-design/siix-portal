<?php

namespace App\Livewire\MTC\Master;

use App\Models\HR\Employee;
use App\Models\MTC\Master\MasterStencil;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class StencilManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Properties untuk form update status
    public $stencil_id;
    public $register_no;
    public $customer;
    public $rack_number;
    public $status;
    public $line_name;
    public $count_stencil;
    public $nik;
    public $input_count_stencil;
    
    // Employee info
    public $employee_name = '';
    public $employee_nik = '';
    
    // Properties untuk search dan filter
    public $search = '';
    public $selectedStatus = '';
    public $selectedCustomer = '';
    
    // Properties untuk modal
    public $showUpdateModal = false;
    public $showActivityModal = false;
    public $selectedStencilForActivity = null;
    public $activityPage = 1;
    public $perPageActivities = 10;
    
    // Loading state
    public $isSaving = false;

    public $activeTab = 'in_use_with_line';
    public $tabCounts = [];

    protected $rules = [
        'status' => 'required|in:In Use,Prepared,Cleaning,Stand By,Disposed',
        'nik' => 'required',
        'line_name' => 'required_if:status,In Use,Prepared',
        'input_count_stencil' => 'required_if:status,Cleaning|nullable|numeric|min:1',
    ];

    protected $messages = [
        'status.required' => 'Status is required.',
        'nik.required' => 'NIK is required.',
        'line_name.required_if' => 'Line name is required for In Use or Prepared status.',
        'input_count_stencil.required_if' => 'Count is required for Cleaning status.',
        'input_count_stencil.numeric' => 'Count must be a number.',
        'input_count_stencil.min' => 'Count must be at least 1.',
    ];

    // Listeners untuk refresh data
    protected $listeners = [
        'refreshStencilTable' => '$refresh'
    ];

    public function mount()
    {
        $this->updateTabCounts();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
        $this->updateTabCounts();
    }

    public function updateTabCounts()
    {
        $baseQuery = MasterStencil::query();
        
        $this->tabCounts = [
            'all' => (clone $baseQuery)->count(),
            'in_use' => (clone $baseQuery)->where('status', 'In Use')->count(),
            'in_use_with_line' => (clone $baseQuery)
                ->where('status', 'In Use')
                ->whereNotNull('line_name')
                ->where('line_name', '!=', '')
                ->count(),
            'prepared' => (clone $baseQuery)->where('status', 'Prepared')->count(),
            'cleaning' => (clone $baseQuery)->where('status', 'Cleaning')->count(),
            'stand_by' => (clone $baseQuery)->where('status', 'Stand By')->count(),
            'disposed' => (clone $baseQuery)->where('status', 'Disposed')->count(),
        ];
    }

    public function getEmployeesProperty()
    {
        return Employee::query()
            ->select('ID', 'nik', 'name')
            ->orderBy('nik')
            ->orderBy('name')
            ->get()
            ->mapWithKeys(fn ($employee) => [
                $employee->ID => $employee->nik . ' - ' . $employee->name
            ]);
    }

    public function getLineOptionsProperty()
    {
        return collect(range(1, 17))
            ->mapWithKeys(fn ($n) => ["SMT $n" => "SMT $n"]);
    }

    public function getStatusColorClass($status)
    {
        $colors = [
            'In Use'   => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
            'Prepared' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
            'Cleaning' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
            'Stand By' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
            'Disposed' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
        ];
        return $colors[$status] ?? 'bg-gray-100 text-gray-800';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedStatus()
    {
        $this->resetPage();
    }

    public function updatingSelectedCustomer()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->selectedStatus = '';
        $this->selectedCustomer = '';
        $this->resetPage();
        $this->dispatch('notify', message: 'Filters reset successfully!', type: 'success');
    }

    public function updatedNik($value)
    {
        if ($value) {
            $employee = Employee::find($value);
            if ($employee) {
                $this->employee_name = $employee->name;
                $this->employee_nik = $employee->nik;
            }
        } else {
            $this->employee_name = '';
            $this->employee_nik = '';
        }
    }

    public function updateStatus($id)
    {
        if (!auth()->user()->can('edit stencil')) {
            $this->dispatch('notify', message: 'You do not have permission to update status!', type: 'error');
            return;
        }

        try {
            $stencil = MasterStencil::findOrFail($id);
            $this->stencil_id = $stencil->id;
            $this->register_no = $stencil->register_no;
            $this->customer = $stencil->customer;
            $this->rack_number = $stencil->rack_number;
            $this->status = $stencil->status;
            $this->line_name = $stencil->line_name;
            $this->count_stencil = $stencil->count_stencil;
            $this->nik = $stencil->nik;
            
            if ($this->nik) {
                $employee = Employee::find($this->nik);
                if ($employee) {
                    $this->employee_name = $employee->name;
                    $this->employee_nik = $employee->nik;
                }
            }
            
            $this->input_count_stencil = null;
            $this->resetValidation();
            
            $this->showUpdateModal = true;
        } catch (\Exception $e) {
            Log::error('Error opening update modal: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Stencil not found!', type: 'error');
        }
    }

    public function saveStatusUpdate()
    {
        $this->isSaving = true;
        
        if (!auth()->user()->can('edit stencil')) {
            $this->dispatch('notify', message: 'You do not have permission to update status!', type: 'error');
            $this->isSaving = false;
            return;
        }
    
        $this->validate();
    
        try {
            $stencil = MasterStencil::findOrFail($this->stencil_id);
            $oldStatus = $stencil->status;
            
            $updateData = [
                'nik' => $this->nik,
                'status' => $this->status,
                'line_name' => in_array($this->status, ['In Use', 'Prepared']) ? $this->line_name : null,
            ];
    
            if ($this->status === 'Cleaning' && isset($this->input_count_stencil)) {
                $updateData['count_stencil'] = $this->input_count_stencil;
            }
    
            if ($oldStatus === 'Cleaning' && $this->status !== 'Cleaning') {
                $updateData['count_stencil'] = null;
            }
    
            $stencil->update($updateData);
    
            $this->showUpdateModal = false;
            $this->resetForm();
            
            $message = "Status changed from '{$oldStatus}' to '{$this->status}' successfully!";
            $this->dispatch('notify', message: $message, type: 'success');
            $this->dispatch('refreshStencilTable');
            $this->updateTabCounts();
            
        } catch (\Exception $e) {
            Log::error('Error updating stencil status: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to update status: ' . $e->getMessage(), type: 'error');
        } finally {
            $this->isSaving = false;
        }
    }

    public function viewActivity($id)
    {
        $this->selectedStencilForActivity = MasterStencil::find($id);
        $this->activityPage = 1;
        $this->showActivityModal = true;
    }

    public function closeActivityModal()
    {
        $this->showActivityModal = false;
        $this->selectedStencilForActivity = null;
        $this->activityPage = 1;
    }

    public function setActivityPage($page)
    {
        $this->activityPage = $page;
    }

    /**
     * Get employee name by ID
     */
    public function getEmployeeName($id)
    {
        if (empty($id)) {
            return '-';
        }
        
        $employee = Employee::where('id', $id)->first();
        return $employee ? $employee->name . ' (' . $employee->nik . ')' : $id;
    }

    /**
     * Get user name by ID
     */
    public function getUserName($id)
    {
        if (empty($id)) {
            return '-';
        }
        
        $user = User::find($id);
        return $user ? $user->name : $id;
    }

    public function getActivitiesProperty()
    {
        if (!$this->selectedStencilForActivity) {
            return collect();
        }
        
        $activities = Activity::where(function($query) {
                $query->where('subject_type', 'App\Models\MTC\Master\MasterStencil')
                      ->orWhere('subject_type', 'App\Models\MasterStencil')
                      ->orWhere('subject_type', 'like', '%MasterStencil%')
                      ->orWhere('subject_type', 'App\Models\Jig');
            })
            ->where('subject_id', $this->selectedStencilForActivity->id)
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPageActivities, ['*'], 'page', $this->activityPage);
            
        return $activities;
    }

    public function closeUpdateModal()
    {
        $this->showUpdateModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'stencil_id', 'register_no', 'customer', 'rack_number', 'status', 'line_name', 
            'count_stencil', 'nik', 'input_count_stencil', 'employee_name', 'employee_nik'
        ]);
        $this->resetValidation();
    }

    public function render()
    {
        if (!auth()->user()->can('view stencil')) {
            abort(403, 'You do not have permission to view stencil.');
        }
    
        $employees = $this->employees;
        $lineOptions = $this->lineOptions;
    
        $stencils = MasterStencil::with(['employee', 'creator', 'updater'])
            ->when($this->activeTab !== 'all', function ($query) {
                $statusMap = [
                    'in_use' => 'In Use',
                    'in_use_with_line' => 'In Use',
                    'prepared' => 'Prepared',
                    'cleaning' => 'Cleaning',
                    'stand_by' => 'Stand By',
                    'disposed' => 'Disposed',
                ];
                
                if (isset($statusMap[$this->activeTab])) {
                    $query->where('status', $statusMap[$this->activeTab]);
                    
                    if ($this->activeTab === 'in_use_with_line') {
                        $query->whereNotNull('line_name')
                              ->where('line_name', '!=', '');
                    }
                }
            })
            ->when($this->search, function ($query) {
                $query->where('register_no', 'like', '%' . $this->search . '%')
                    ->orWhere('customer', 'like', '%' . $this->search . '%')
                    ->orWhere('rack_number', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedStatus, function ($query) {
                $query->where('status', $this->selectedStatus);
            })
            ->when($this->selectedCustomer, function ($query) {
                $query->where('customer', 'like', '%' . $this->selectedCustomer . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
    
        $customers = MasterStencil::select('customer')
            ->distinct()
            ->whereNotNull('customer')
            ->where('customer', '!=', '')
            ->pluck('customer')
            ->toArray();
    
        return view('livewire.mtc.master.stencil-management', [
            'stencils' => $stencils,
            'employees' => $employees,
            'lineOptions' => $lineOptions,
            'customers' => $customers,
            'activities' => $this->activities,
        ]);
    }
}