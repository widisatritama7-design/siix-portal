<?php

namespace App\Livewire\HR;

use App\Models\HR\EmployeeCall;
use App\Models\HR\Employee;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class EmployeeCallManagement extends Component
{
    use WithPagination;
    
    // Properties untuk filter dan search
    public $search = '';
    public $categoryFilter = '';
    public $dateFrom = '';
    public $dateUntil = '';
    public $perPage = 10;
    
    // Properties untuk modals
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    
    // Properties untuk form
    public $editId = null;
    public $nik = '';
    public $category = '';
    public $date_call = '';
    public $employeeName = '';
    public $employeeNik = '';
    public $employeeDept = '';
    public $employeeStatus = '';
    public $infoMessage = '';
    
    // Properties untuk delete
    public $deleteId = null;
    public $deleteName = '';
    
    // Employees for dropdown
    public $employees = [];
    
    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateUntil' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];
    
    protected $rules = [
        'nik' => 'required',
        'category' => 'required',
        'date_call' => 'required|date',
    ];
    
    protected $messages = [
        'nik.required' => 'Please select an employee',
        'category.required' => 'Category is required',
        'date_call.required' => 'Date is required',
    ];
    
    public function getCategoryOptionsProperty()
    {
        return [
            'Violation' => 'Violation',
            'Comelate' => 'Comelate',
        ];
    }
    
    public function loadEmployees()
    {
        $this->employees = Employee::query()
            ->whereIn('status', [1, 2, 3])
            ->orderBy('nik')
            ->get()
            ->mapWithKeys(fn ($employee) => [
                $employee->id => $employee->nik . ' - ' . $employee->name,
            ])
            ->toArray();
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }
    
    public function updatingDateFrom()
    {
        $this->resetPage();
    }
    
    public function updatingDateUntil()
    {
        $this->resetPage();
    }
    
    public function updatingPerPage()
    {
        $this->resetPage();
    }
    
    public function updatedDateCall()
    {
        $this->updateInfoMessage();
        $this->loadEmployees();
    }
    
    public function updatedNik()
    {
        $this->updateInfoMessage();
    }
    
    public function updatedCategory()
    {
        $this->updateInfoMessage();
    }
    
    public function updateInfoMessage()
    {
        $status = [];
        
        if ($this->date_call) {
            $dateFormatted = Carbon::parse($this->date_call)->format('d M Y');
            $status[] = "✓ Tanggal: " . $dateFormatted;
        }
        
        if ($this->nik) {
            $employee = Employee::find($this->nik);
            if ($employee) {
                $this->employeeName = $employee->name;
                $this->employeeNik = $employee->nik;
                $this->employeeDept = $employee->department;
                $this->employeeStatus = match($employee->status) {
                    1 => 'Permanent',
                    2 => 'Contract',
                    3 => 'Magang',
                    default => 'Unknown',
                };
                $status[] = "✓ Karyawan: " . $employee->nik . ' - ' . $employee->name;
            }
        }
        
        if ($this->category) {
            $status[] = "✓ Kategori: " . $this->category;
        }
        
        if (count($status) === 3) {
            $this->infoMessage = "✅ " . implode(' | ', $status) . " - Siap disimpan";
        } elseif (count($status) > 0) {
            $this->infoMessage = "⏳ " . implode(' | ', $status) . " - Lengkapi data";
        } else {
            $this->infoMessage = "📅 Silahkan pilih tanggal terlebih dahulu";
        }
    }
    
    public function openCreateModal()
    {
        // CEK AKSES
        if (!auth()->user()->can('create employee call')) {
            $this->dispatch('notify', message: 'You do not have permission to create employee call!', type: 'error');
            return;
        }
        
        $this->resetForm();
        $this->date_call = Carbon::now()->format('Y-m-d');
        $this->loadEmployees();
        $this->updateInfoMessage();
        $this->showCreateModal = true;
    }
    
    public function openEditModal($id)
    {
        // CEK AKSES
        if (!auth()->user()->can('edit employee call')) {
            $this->dispatch('notify', message: 'You do not have permission to edit employee call!', type: 'error');
            return;
        }
        
        $call = EmployeeCall::findOrFail($id);
        $this->editId = $call->id;
        $this->nik = $call->nik;
        $this->category = $call->category;
        $this->date_call = $call->date_call;
        
        // Load employee data
        $employee = Employee::find($call->nik);
        if ($employee) {
            $this->employeeName = $employee->name;
            $this->employeeNik = $employee->nik;
            $this->employeeDept = $employee->department;
            $this->employeeStatus = match($employee->status) {
                1 => 'Permanent',
                2 => 'Contract',
                3 => 'Magang',
                default => 'Unknown',
            };
        }
        
        $this->loadEmployees();
        $this->updateInfoMessage();
        $this->showEditModal = true;
    }
    
    public function openDeleteModal($id)
    {
        // CEK AKSES
        if (!auth()->user()->can('delete employee call')) {
            $this->dispatch('notify', message: 'You do not have permission to delete employee call!', type: 'error');
            return;
        }
        
        $call = EmployeeCall::findOrFail($id);
        $this->deleteId = $call->id;
        $this->deleteName = $call->employee->name ?? '-';
        $this->showDeleteModal = true;
    }
    
    public function save()
    {
        // CEK AKSES
        if (!auth()->user()->can('create employee call')) {
            $this->dispatch('notify', message: 'You do not have permission to create employee call!', type: 'error');
            return;
        }
        
        $this->validate();
        
        // Check if employee already called today
        $existsToday = EmployeeCall::where('nik', $this->nik)
            ->whereDate('date_call', $this->date_call)
            ->exists();
        
        if ($existsToday) {
            $this->addError('nik', 'Employee ini sudah dipanggil hari ini!');
            return;
        }
        
        EmployeeCall::create([
            'nik' => $this->nik,
            'category' => $this->category,
            'date_call' => $this->date_call,
            'time_call' => now()->format('H:i:s'),
        ]);
        
        session()->flash('message', 'Employee call record created successfully.');
        $this->resetForm();
        $this->showCreateModal = false;
        $this->dispatch('notify', message: 'Record created successfully', type: 'success');
    }
    
    public function update()
    {
        // CEK AKSES
        if (!auth()->user()->can('edit employee call')) {
            $this->dispatch('notify', message: 'You do not have permission to edit employee call!', type: 'error');
            return;
        }
        
        $this->validate();
        
        $call = EmployeeCall::findOrFail($this->editId);
        $call->update([
            'nik' => $this->nik,
            'category' => $this->category,
            'date_call' => $this->date_call,
        ]);
        
        session()->flash('message', 'Employee call record updated successfully.');
        $this->resetForm();
        $this->showEditModal = false;
        $this->dispatch('notify', message: 'Record updated successfully', type: 'success');
    }
    
    public function delete()
    {
        // CEK AKSES
        if (!auth()->user()->can('delete employee call')) {
            $this->dispatch('notify', message: 'You do not have permission to delete employee call!', type: 'error');
            return;
        }
        
        $call = EmployeeCall::findOrFail($this->deleteId);
        $call->delete();
        
        session()->flash('message', 'Employee call record deleted successfully.');
        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->deleteName = '';
        $this->dispatch('notify', message: 'Record deleted successfully', type: 'success');
    }
    
    public function resetForm()
    {
        $this->reset(['editId', 'nik', 'category', 'date_call', 'employeeName', 'employeeNik', 'employeeDept', 'employeeStatus', 'infoMessage']);
        $this->resetValidation();
    }
    
    public function clearFilters()
    {
        $this->reset(['search', 'categoryFilter', 'dateFrom', 'dateUntil']);
        $this->resetPage();
    }
    
    public function render()
    {
        // CEK AKSES VIEW
        if (!auth()->user()->can('view employee call')) {
            abort(403, 'Unauthorized access.');
        }
        
        $calls = EmployeeCall::query()
            ->with(['employee', 'creator', 'updater'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('employee', function ($subQuery) {
                        $subQuery->where('name', 'like', '%' . $this->search . '%')
                                 ->orWhere('nik', 'like', '%' . $this->search . '%');
                    })->orWhere('category', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category', $this->categoryFilter);
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('date_call', '>=', $this->dateFrom);
            })
            ->when($this->dateUntil, function ($query) {
                $query->whereDate('date_call', '<=', $this->dateUntil);
            })
            ->orderBy('date_call', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        
        return view('livewire.hr.employee-call-management', [
            'calls' => $calls,
        ]);
    }
}