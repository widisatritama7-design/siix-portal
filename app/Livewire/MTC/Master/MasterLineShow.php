<?php

namespace App\Livewire\MTC\Master;

use App\Models\HR\Employee;
use App\Models\MTC\Daily\DailyFuji;
use App\Models\MTC\Master\MasterLine;
use App\Models\MTC\Master\MasterLocation;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class MasterLineShow extends Component
{
    use WithPagination;

    public $line;
    
    // Filter properties
    public $search = '';
    public $selectedStatus = '';
    
    // Daily Fuji properties
    public $selectedDailyFuji = null;
    public $showDailyFujiModal = false;
    
    // Form properties untuk edit langsung di show page (opsional)
    public $line_id;
    public $location_id;
    public $line_number;
    public $status;
    public $nik;
    public $trouble_desc;
    public $machine_type;
    public $modalTitle = 'Edit Line';

    protected $rules = [
        'location_id' => 'required|exists:tb_mtc_master_locations,id',
        'line_number' => 'required|string|max:255',
        'status' => 'required|in:Running,Maintenance,No Schedule,Trouble',
        'nik' => 'nullable|exists:hr_employees,ID',
        'trouble_desc' => 'nullable|string',
        'machine_type' => 'required|in:fuji,panasonic,both',
    ];

    protected $messages = [
        'location_id.required' => 'Location is required.',
        'location_id.exists' => 'Selected location is invalid.',
        'line_number.required' => 'Line number is required.',
        'status.required' => 'Status is required.',
        'machine_type.required' => 'Machine type is required.',
        'nik.exists' => 'Selected employee is invalid.',
    ];

    protected $listeners = [
        'refreshDailyFujiTable' => '$refresh'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedStatus()
    {
        $this->resetPage();
    }

    public function mount($id)
    {
        $this->line = MasterLine::with(['location', 'location.area', 'employee', 'creator', 'updater', 'machines'])
            ->findOrFail($id);
        
        if (!auth()->user()->can('view master line')) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'selectedStatus']);
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->reset([
            'line_id', 'location_id', 'line_number', 'status', 
            'nik', 'trouble_desc', 'machine_type'
        ]);
        $this->resetValidation();
        $this->modalTitle = 'Edit Line';
    }

    public function createDailyFuji()
    {
        if (!auth()->user()->can('create daily fuji')) {
            $this->dispatch('notify', message: 'You do not have permission to create daily fuji!', type: 'error');
            return;
        }
        $this->dispatch('open-daily-fuji-form', masterLineId: $this->line->id);
    }
    
    public function editDailyFuji($id)
    {
        if (!auth()->user()->can('edit daily fuji')) {
            $this->dispatch('notify', message: 'You do not have permission to edit daily fuji!', type: 'error');
            return;
        }
        $this->dispatch('open-daily-fuji-form', masterLineId: $this->line->id, id: $id);
    }

    public function viewDailyFujiDetails($dailyFujiId)
    {
        $this->selectedDailyFuji = DailyFuji::with(['creator', 'updater', 'approvedBy', 'masterLine'])
            ->findOrFail($dailyFujiId);
        $this->showDailyFujiModal = true;
    }
    
    public function closeDetailModal()
    {
        $this->showDailyFujiModal = false;
        $this->selectedDailyFuji = null;
    }

    public function getLocationsProperty()
    {
        return MasterLocation::with('area')->orderBy('location_name')->get();
    }

    public function getEmployeesProperty()
    {
        return Employee::orderBy('name')->get();
    }

    public function render()
    {
        $locations = $this->locations;
        $employees = $this->employees;
        
        $dailyFujisQuery = DailyFuji::with(['creator', 'updater', 'approvedBy', 'masterLine'])
            ->where('master_line_id', $this->line->id);
        
        if ($this->search) {
            $dailyFujisQuery->where(function($query) {
                $query->where('group', 'like', '%' . $this->search . '%')
                      ->orWhere('status', 'like', '%' . $this->search . '%')
                      ->orWhere('approval', 'like', '%' . $this->search . '%');
            });
        }
        
        if ($this->selectedStatus) {
            $dailyFujisQuery->where('status', $this->selectedStatus);
        }
        
        $dailyFujis = $dailyFujisQuery->orderBy('created_at', 'desc')->paginate(5);

        return view('livewire.mtc.master.master-line-show', [
            'locations' => $locations,
            'employees' => $employees,
            'dailyFujis' => $dailyFujis,
        ]);
    }
}