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
    
    // Daily Fuji properties for view modal
    public $selectedDailyFuji = null;
    public $showDailyFujiModal = false;
    
    // Form properties untuk edit line (opsional, jika ada modal edit line)
    public $line_id;
    public $location_id;
    public $line_number;
    public $status;
    public $nik;
    public $trouble_desc;
    public $machine_type;
    public $modalTitle = 'Edit Line';

    public $showApprovalModal = false;
    public $approvalDailyFujiId = null;

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

    // Listeners untuk refresh data
    protected $listeners = [
        'refreshDailyFujiTable' => '$refresh'
    ];

    public function openApprovalModal($dailyFujiId)
    {
        if (!auth()->user()->can('edit daily fuji')) {
            $this->dispatch('notify', message: 'You do not have permission to approve!', type: 'error');
            return;
        }
        
        $this->approvalDailyFujiId = $dailyFujiId;
        $this->showApprovalModal = true;
    }

    public function closeApprovalModal()
    {
        $this->showApprovalModal = false;
        $this->approvalDailyFujiId = null;
    }

    public function setApproval($status)
    {
        if (!auth()->user()->can('edit daily fuji')) {
            $this->dispatch('notify', message: 'You do not have permission to approve!', type: 'error');
            return;
        }
        
        $dailyFuji = DailyFuji::find($this->approvalDailyFujiId);
        
        if (!$dailyFuji) {
            $this->dispatch('notify', message: 'Record not found!', type: 'error');
            $this->closeApprovalModal();
            return;
        }
        
        // Cek apakah sudah approved
        if ($dailyFuji->approval === 'Approved') {
            $this->dispatch('notify', message: 'This record is already approved!', type: 'error');
            $this->closeApprovalModal();
            return;
        }
        
        // Cek status harus Checked dulu
        if ($dailyFuji->status !== 'Checked') {
            $this->dispatch('notify', message: 'Cannot approve. Status must be "Checked" first!', type: 'error');
            $this->closeApprovalModal();
            return;
        }
        
        $dailyFuji->approval = $status;
        $dailyFuji->approved_by = auth()->id();
        $dailyFuji->save();
        
        $this->dispatch('notify', message: "Inspection has been {$status}!", type: 'success');
        $this->closeApprovalModal();
        $this->dispatch('refreshDailyFujiTable');
    }

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
        $this->line = MasterLine::with([
            'location', 
            'location.area', 
            'employee', 
            'creator', 
            'updater', 
            'machines'
        ])->findOrFail($id);
        
        // Check permission
        if (!auth()->user()->can('view master line')) {
            abort(403, 'Unauthorized access.');
        }
    }

    /**
     * Reset filters untuk Daily Fuji table
     */
    public function resetFilters()
    {
        $this->reset(['search', 'selectedStatus']);
        $this->resetPage();
    }

    /**
     * Reset form untuk edit line (jika menggunakan modal edit)
     */
    public function resetForm()
    {
        $this->reset([
            'line_id', 'location_id', 'line_number', 'status', 
            'nik', 'trouble_desc', 'machine_type'
        ]);
        $this->resetValidation();
        $this->modalTitle = 'Edit Line';
    }

    /**
     * Navigate ke halaman create Daily Fuji
     */
    public function createDailyFuji()
    {
        if (!auth()->user()->can('create daily fuji')) {
            $this->dispatch('notify', message: 'You do not have permission to create daily fuji!', type: 'error');
            return;
        }
        
        // Redirect ke halaman create terpisah
        return redirect()->route('mtc.daily-fuji.create', $this->line->id);
    }
    
    /**
     * Navigate ke halaman edit Daily Fuji
     */
    public function editDailyFuji($id)
    {
        if (!auth()->user()->can('edit daily fuji')) {
            $this->dispatch('notify', message: 'You do not have permission to edit daily fuji!', type: 'error');
            return;
        }
        
        $dailyFuji = DailyFuji::find($id);
        
        // Cek apakah masih dalam shift yang sama
        if (now()->greaterThan($dailyFuji->getShiftEnd())) {
            $this->dispatch('notify', message: 'Cannot edit! The inspection shift has ended.', type: 'error');
            return;
        }
        
        return redirect()->route('mtc.daily-fuji.edit', [
            'masterLineId' => $this->line->id,
            'dailyFujiId' => $id
        ]);
    }

    /**
     * View Daily Fuji details dalam modal (read-only)
     */
    public function viewDailyFujiDetails($dailyFujiId)
    {
        $this->selectedDailyFuji = DailyFuji::with([
            'creator', 
            'updater', 
            'approvedBy', 
            'masterLine'
        ])->findOrFail($dailyFujiId);
        
        $this->showDailyFujiModal = true;
    }
    
    /**
     * Close detail modal
     */
    public function closeDetailModal()
    {
        $this->showDailyFujiModal = false;
        $this->selectedDailyFuji = null;
    }

    /**
     * Get locations untuk dropdown (jika menggunakan modal edit line)
     */
    public function getLocationsProperty()
    {
        return MasterLocation::with('area')->orderBy('location_name')->get();
    }

    /**
     * Get employees untuk dropdown (jika menggunakan modal edit line)
     */
    public function getEmployeesProperty()
    {
        return Employee::orderBy('name')->get();
    }

    /**
     * Render component
     */
    public function render()
    {
        $locations = $this->locations;
        $employees = $this->employees;
        
        // Query Daily Fuji records untuk line ini
        $dailyFujisQuery = DailyFuji::with(['creator', 'updater', 'approvedBy', 'masterLine'])
            ->where('master_line_id', $this->line->id);
        
        // Apply search filter
        if ($this->search) {
            $dailyFujisQuery->where(function($query) {
                $query->where('group', 'like', '%' . $this->search . '%')
                      ->orWhere('status', 'like', '%' . $this->search . '%')
                      ->orWhere('approval', 'like', '%' . $this->search . '%');
            });
        }
        
        // Apply status filter
        if ($this->selectedStatus) {
            $dailyFujisQuery->where('status', $this->selectedStatus);
        }
        
        // Paginate results
        $dailyFujis = $dailyFujisQuery->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.mtc.master.master-line-show', [
            'locations' => $locations,
            'employees' => $employees,
            'dailyFujis' => $dailyFujis,
        ]);
    }
}