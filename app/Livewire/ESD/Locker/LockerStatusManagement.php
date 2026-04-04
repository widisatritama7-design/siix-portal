<?php

namespace App\Livewire\ESD\Locker;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Locker\LockerStatus;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;

class LockerStatusManagement extends Component
{
    use WithPagination;

    // Form properties
    public $locker_id;
    public $locker_number;
    public $nik;
    public $name;
    public $dept;
    public $status = 'Available';
    
    // Filter properties
    public $search = '';
    public $filterStatus = '';
    public $filterDept = '';
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    
    public $modalTitle = 'Add New Locker';
    public $detailToDelete = null;
    public $showDetailModal = false;
    public $selectedLocker = null;
    public $showActivityModal = false;
    public $selectedLockerForActivity = null;
    public $activityPage = 1;
    public $perPageActivities = 10;

    // For inline status update
    public $editingId = null;
    public $editingStatus = null;

    // Status options
    public $statusOptions = [
        'Filled' => 'Filled',
        'On Process Measure' => 'On Process Measure',
        'Finish' => 'Finish',
        'Available' => 'Available'
    ];

    protected function rules()
    {
        return [
            'locker_number' => 'required|string|max:20|unique:tb_esd_locker_statuses,locker_number,' . $this->locker_id,
            'nik' => 'nullable|string|max:20',
            'name' => 'nullable|string|max:100',
            'dept' => 'nullable|string|max:100',
            'status' => 'required|string|in:Filled,On Process Measure,Finish,Available',
        ];
    }

    protected function messages()
    {
        return [
            'locker_number.required' => 'Locker number is required.',
            'locker_number.unique' => 'Locker number already exists.',
            'status.required' => 'Status is required.',
            'nik.max' => 'NIK cannot exceed 20 characters.',
            'name.max' => 'Name cannot exceed 100 characters.',
            'dept.max' => 'Department cannot exceed 100 characters.',
        ];
    }

    public function mount()
    {
        //
    }

    public function getStatusColor($status)
    {
        return match($status) {
            'Filled' => 'success',
            'On Process Measure' => 'warning',
            'Finish' => 'info',
            'Available' => 'danger',
            default => 'gray',
        };
    }

    public function getStatusLabel($status)
    {
        return $status;
    }

    // Inline status update methods
    public function startEditingStatus($id, $currentStatus)
    {
        $this->editingId = $id;
        $this->editingStatus = $currentStatus;
    }

    public function cancelEditing()
    {
        $this->editingId = null;
        $this->editingStatus = null;
    }

    public function updateStatus($id)
    {
        if (!auth()->user()->can('edit locker')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            $this->cancelEditing();
            return;
        }

        $locker = LockerStatus::find($id);
        if ($locker) {
            $oldStatus = $locker->status;
            $locker->update(['status' => $this->editingStatus]);
            
            $this->dispatch('notify', message: "Status changed from '{$oldStatus}' to '{$this->editingStatus}'", type: 'success');
        }
        
        $this->cancelEditing();
    }

    public function resetForm()
    {
        $this->reset([
            'locker_id', 'locker_number', 'nik', 'name', 'dept', 'status'
        ]);
        $this->status = 'Available';
        $this->modalTitle = 'Add New Locker';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset([
            'search', 'filterStatus', 'filterDept', 'filterDateFrom', 'filterDateUntil'
        ]);
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedFilterDept()
    {
        $this->resetPage();
    }

    public function updatedFilterDateFrom()
    {
        $this->resetPage();
    }

    public function updatedFilterDateUntil()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->locker_id) {
            if (!auth()->user()->can('edit locker')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create locker')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'locker_number' => $this->locker_number,
            'nik' => $this->nik,
            'name' => $this->name,
            'dept' => $this->dept,
            'status' => $this->status,
        ];

        if ($this->locker_id) {
            $locker = LockerStatus::find($this->locker_id);
            if (!$locker) {
                $this->dispatch('notify', message: 'Locker not found!', type: 'error');
                return;
            }
            $locker->update($data);
            $message = 'Locker updated successfully!';
        } else {
            LockerStatus::create($data);
            $message = 'Locker created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'locker-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit locker')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $locker = LockerStatus::find($id);

        if (!$locker) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            return;
        }

        $this->locker_id = $locker->id;
        $this->locker_number = $locker->locker_number;
        $this->nik = $locker->nik;
        $this->name = $locker->name;
        $this->dept = $locker->dept;
        $this->status = $locker->status;
        $this->modalTitle = 'Edit Locker';
    }

    public function viewDetail($id)
    {
        $this->selectedLocker = LockerStatus::with('creator', 'updater')->find($id);
        $this->showDetailModal = true;
    }

    public function viewActivity($id)
    {
        $this->selectedLockerForActivity = LockerStatus::find($id);
        $this->activityPage = 1;
        $this->showActivityModal = true;
        
        // Debug: cek apakah ada data
        \Log::info('View Activity for Locker ID: ' . $id);
    }

    public function setActivityPage($page)
    {
        $this->activityPage = $page;
    }

    public function closeActivityModal()
    {
        $this->showActivityModal = false;
        $this->selectedLockerForActivity = null;
        $this->activityPage = 1;
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete locker')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $locker = LockerStatus::find($id);

        if (!$locker) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $locker;
        $this->dispatch('open-modal', 'delete-locker-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete locker')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $locker = LockerStatus::find($this->detailToDelete->id);

        if (!$locker) {
            $this->dispatch('notify', message: 'Locker not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $lockerNumber = $locker->locker_number ?? 'Unknown';
        $locker->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Locker '{$lockerNumber}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-locker-modal');
    }

    public function cancelDelete()
    {
        $this->detailToDelete = null;
        $this->dispatch('close-modal', 'delete-locker-modal');
    }

    public function getActivitiesProperty()
    {
        if (!$this->selectedLockerForActivity) {
            return collect();
        }
        
        $activities = Activity::where(function($query) {
                $query->where('subject_type', 'App\Models\ESD\Locker\LockerStatus')
                      ->orWhere('subject_type', 'App\Models\LockerStatus');
            })
            ->where('subject_id', $this->selectedLockerForActivity->id)
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPageActivities, ['*'], 'page', $this->activityPage);
            
        return $activities;
    }

    public function render()
    {
        if (!auth()->user()->can('view locker')) {
            abort(403, 'Unauthorized access.');
        }
    
        // Ambil semua data tanpa pagination, batasi 20 data
        $allLockers = LockerStatus::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('locker_number', 'like', '%' . $this->search . '%')
                        ->orWhere('nik', 'like', '%' . $this->search . '%')
                        ->orWhere('name', 'like', '%' . $this->search . '%')
                        ->orWhere('dept', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterDept, function ($query) {
                $query->where('dept', 'like', '%' . $this->filterDept . '%');
            })
            ->when($this->filterDateFrom, function ($query) {
                $query->whereDate('created_at', '>=', $this->filterDateFrom);
            })
            ->when($this->filterDateUntil, function ($query) {
                $query->whereDate('created_at', '<=', $this->filterDateUntil);
            })
            ->orderBy('locker_number', 'asc')
            ->limit(20) // Batasi 20 data
            ->get();
    
        // Pisahkan menjadi 2 bagian (masing-masing 10)
        $leftLockers = $allLockers->slice(0, 10);
        $rightLockers = $allLockers->slice(10, 10);
    
        // Get unique departments for filter
        $departments = LockerStatus::whereNotNull('dept')->select('dept')->distinct()->pluck('dept');
    
        return view('livewire.esd.locker.locker-status-management', [
            'leftLockers' => $leftLockers,
            'rightLockers' => $rightLockers,
            'allLockers' => $allLockers,
            'departments' => $departments,
            'activities' => $this->activities,
        ]);
    }
}