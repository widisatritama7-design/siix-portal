<?php

namespace App\Livewire\MTC\Master;

use App\Models\HR\Employee;
use App\Models\MTC\Master\MasterStencil;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

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
    
    // Loading state
    public $isSaving = false;

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

    /**
     * Get employees for searchable dropdown
     */
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

    /**
     * Get all line options (SMT 1 to SMT 17)
     */
    public function getLineOptionsProperty()
    {
        return collect(range(1, 17))
            ->mapWithKeys(fn ($n) => ["SMT $n" => "SMT $n"]);
    }

    /**
     * Get status color class
     */
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

    /**
     * Reset filters
     */
    public function resetFilters()
    {
        $this->search = '';
        $this->selectedStatus = '';
        $this->selectedCustomer = '';
        $this->resetPage();
        $this->dispatch('notify', message: 'Filters reset successfully!', type: 'success');
    }

    /**
     * Update employee info when NIK changes
     */
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

    /**
     * Open update status modal
     */
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
            
            // Set employee info
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

    /**
     * Save status update
     */
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
            $oldLineName = $stencil->line_name;
            
            // Prepare update data
            $updateData = [
                'nik' => $this->nik,
                'status' => $this->status,
                'line_name' => in_array($this->status, ['In Use', 'Prepared']) ? $this->line_name : null,
            ];

            // Jika status baru Cleaning, replace count_stencil dengan input
            if ($this->status === 'Cleaning' && isset($this->input_count_stencil)) {
                $updateData['count_stencil'] = $this->input_count_stencil;
            }

            // Jika status lama Cleaning dan status baru bukan Cleaning, reset count_stencil
            if ($oldStatus === 'Cleaning' && $this->status !== 'Cleaning') {
                $updateData['count_stencil'] = null;
            }

            $stencil->update($updateData);

            $this->showUpdateModal = false;
            $this->resetForm();
            
            $message = "Status changed from '{$oldStatus}' to '{$this->status}' successfully!";
            $this->dispatch('notify', message: $message, type: 'success');
            $this->dispatch('refreshStencilTable');
            
        } catch (\Exception $e) {
            Log::error('Error updating stencil status: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to update status: ' . $e->getMessage(), type: 'error');
        } finally {
            $this->isSaving = false;
        }
    }

    /**
     * Close update modal
     */
    public function closeUpdateModal()
    {
        $this->showUpdateModal = false;
        $this->resetForm();
    }

    /**
     * Reset form
     */
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
        // Check permission untuk view
        if (!auth()->user()->can('view stencil')) {
            abort(403, 'You do not have permission to view stencil.');
        }

        $employees = $this->employees;
        $lineOptions = $this->lineOptions;

        $stencils = MasterStencil::with(['employee', 'creator', 'updater'])
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

        // Get unique customers for filter
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
        ]);
    }
}