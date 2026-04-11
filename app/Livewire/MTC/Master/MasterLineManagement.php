<?php

namespace App\Livewire\MTC\Master;

use App\Models\MTC\Master\MasterLine;
use App\Models\MTC\Master\MasterLocation;
use App\Models\HR\Employee;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterLineManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Properties untuk form
    public $line_id;
    public $location_id;
    public $line_number;
    public $status;
    public $nik;
    public $trouble_desc;
    public $machine_type;
    
    // Properties untuk search, filter dan delete
    public $search = '';
    public $selectedLocation = '';
    public $selectedMachineType = '';
    public $selectedStatus = '';
    public $lineToDelete;
    
    // Modal title
    public $modalTitle = 'Add New Line';

    protected $rules = [
        'location_id' => 'required|exists:tb_mtc_master_locations,id',
        'line_number' => 'required|string|max:255', // Hapus unique:tb_mtc_master_lines,line_number
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

    public function resetForm()
    {
        $this->reset([
            'line_id', 'location_id', 'line_number', 'status', 
            'nik', 'trouble_desc', 'machine_type'
        ]);
        $this->resetValidation();
        $this->modalTitle = 'Add New Line';
        $this->status = 'Running';
        $this->machine_type = 'fuji';
    }

    public function edit($id)
    {
        // Check permission untuk edit
        if (!auth()->user()->can('edit master line')) {
            $this->dispatch('notify', message: 'You do not have permission to edit line!', type: 'error');
            return;
        }

        try {
            $line = MasterLine::findOrFail($id);
            $this->line_id = $line->id;
            $this->location_id = $line->location_id;
            $this->line_number = $line->line_number;
            $this->status = $line->status;
            $this->nik = $line->nik;
            $this->trouble_desc = $line->trouble_desc;
            $this->machine_type = $line->machine_type;
            $this->modalTitle = 'Edit Line';
            $this->resetValidation();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Line not found!', type: 'error');
        }
    }

    public function save()
    {
        // Check permission untuk create atau edit
        if ($this->line_id) {
            if (!auth()->user()->can('edit master line')) {
                $this->dispatch('notify', message: 'You do not have permission to update line!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create master line')) {
                $this->dispatch('notify', message: 'You do not have permission to create line!', type: 'error');
                return;
            }
        }
    
        // Validasi tanpa unique untuk line_number
        $this->validate();
    
        try {
            if ($this->line_id) {
                // Update existing line
                $line = MasterLine::findOrFail($this->line_id);
                $line->update([
                    'location_id' => $this->location_id,
                    'line_number' => $this->line_number,
                    'status' => $this->status,
                    'nik' => $this->nik,
                    'trouble_desc' => $this->trouble_desc,
                    'machine_type' => $this->machine_type,
                ]);
                $message = 'Line updated successfully!';
            } else {
                // Create new line
                MasterLine::create([
                    'location_id' => $this->location_id,
                    'line_number' => $this->line_number,
                    'status' => $this->status,
                    'nik' => $this->nik,
                    'trouble_desc' => $this->trouble_desc,
                    'machine_type' => $this->machine_type,
                ]);
                $message = 'Line created successfully!';
            }
    
            $this->resetForm();
            $this->dispatch('close-modal', 'line-form-modal');
            $this->dispatch('notify', message: $message, type: 'success');
            
        } catch (\Exception $e) {
            Log::error('Error saving line: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to save line!', type: 'error');
        }
    }

    public function confirmDelete($id)
    {
        // Check permission untuk delete
        if (!auth()->user()->can('delete master line')) {
            $this->dispatch('notify', message: 'You do not have permission to delete line!', type: 'error');
            return;
        }

        try {
            $this->lineToDelete = MasterLine::withCount(['machines'])->findOrFail($id);
            $this->dispatch('open-modal', 'delete-line-modal');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Line not found!', type: 'error');
        }
    }

    public function delete()
    {
        // Check permission untuk delete
        if (!auth()->user()->can('delete master line')) {
            $this->dispatch('notify', message: 'You do not have permission to delete line!', type: 'error');
            return;
        }

        try {
            $line = MasterLine::findOrFail($this->lineToDelete->id);
            
            // Check if line has related machines
            if ($line->machines()->count() > 0) {
                $this->dispatch('notify', 
                    message: 'Cannot delete line because it has ' . $line->machines()->count() . ' machine(s) associated!', 
                    type: 'warning'
                );
                $this->dispatch('close-modal', 'delete-line-modal');
                return;
            }
            
            $lineNumber = $line->line_number;
            $line->delete();
            
            $this->dispatch('close-modal', 'delete-line-modal');
            $this->dispatch('notify', message: "Line '{$lineNumber}' deleted successfully!", type: 'success');
            $this->lineToDelete = null;
            
        } catch (\Exception $e) {
            Log::error('Error deleting line: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to delete line!', type: 'error');
        }
    }

    public function getEmployeesProperty()
    {
        return Employee::orderBy('name')->get();
    }

    public function getLocationsProperty()
    {
        return MasterLocation::with('area')->orderBy('location_name')->get();
    }

    public function render()
    {
        // Check permission untuk view
        if (!auth()->user()->can('view master line')) {
            abort(403, 'You do not have permission to view master line.');
        }

        $locations = $this->locations;
        $employees = $this->employees;

        $lines = MasterLine::with(['location', 'location.area', 'employee', 'creator', 'updater', 'machines'])
            ->when($this->search, function ($query) {
                $query->where('line_number', 'like', '%' . $this->search . '%')
                      ->orWhere('trouble_desc', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedLocation, function ($query) {
                $query->where('location_id', $this->selectedLocation);
            })
            ->when($this->selectedMachineType, function ($query) {
                $query->where('machine_type', $this->selectedMachineType);
            })
            ->when($this->selectedStatus, function ($query) {
                $query->where('status', $this->selectedStatus);
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('livewire.mtc.master.master-line-management', [
            'lines' => $lines,
            'locations' => $locations,
            'employees' => $employees,
        ]);
    }
}