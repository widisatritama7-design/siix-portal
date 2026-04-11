<?php

namespace App\Livewire\MTC\Master;

use App\Models\MTC\Master\MasterMachine;
use App\Models\MTC\Master\MasterLocation;
use App\Models\MTC\Master\MasterLine;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterMachineManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Properties untuk form
    public $machine_id;
    public $location_id;
    public $line_id;
    public $name;
    public $model_type;
    public $mfg_date;
    public $maker;
    public $serial_no;
    public $power_voltage;
    public $power_amper;
    public $no_of_phases;
    public $air_supply;
    public $n2_supply;
    public $status;
    
    // Properties untuk search, filter dan delete
    public $search = '';
    public $selectedLocation = '';
    public $selectedLine = '';
    public $selectedStatus = '';
    public $machineToDelete;
    
    // Modal title
    public $modalTitle = 'Add New Machine';

    // Options
    public $statusOptions = [
        'Running' => 'Running',
        'Maintenance' => 'Maintenance',
        'Offline' => 'Offline',
    ];

    public $statusColors = [
        'Running' => 'success',
        'Maintenance' => 'warning',
        'Offline' => 'danger',
    ];

    protected $rules = [
        'location_id' => 'required|exists:tb_mtc_master_locations,id',
        'line_id' => 'nullable|exists:tb_mtc_master_lines,id',
        'name' => 'required|string|max:255',
        'model_type' => 'nullable|string|max:255',
        'mfg_date' => 'nullable|date',
        'maker' => 'required|string|max:255',
        'serial_no' => 'required|string|max:255|unique:tb_mtc_master_machines,serial_no',
        'power_voltage' => 'nullable|string|max:255',
        'power_amper' => 'nullable|string|max:255',
        'no_of_phases' => 'nullable|string|max:255',
        'air_supply' => 'nullable|string|max:255',
        'n2_supply' => 'nullable|string|max:255',
        'status' => 'required|in:Running,Maintenance,Offline',
    ];

    protected $messages = [
        'location_id.required' => 'Location is required.',
        'location_id.exists' => 'Selected location is invalid.',
        'name.required' => 'Machine name is required.',
        'maker.required' => 'Maker is required.',
        'serial_no.required' => 'Serial number is required.',
        'serial_no.unique' => 'This serial number already exists.',
        'status.required' => 'Status is required.',
        'line_id.exists' => 'Selected line is invalid.',
        'mfg_date.date' => 'Invalid date format.',
    ];

    public function resetForm()
    {
        $this->reset([
            'machine_id', 'location_id', 'line_id', 'name', 'model_type',
            'mfg_date', 'maker', 'serial_no', 'power_voltage', 'power_amper',
            'no_of_phases', 'air_supply', 'n2_supply', 'status'
        ]);
        $this->resetValidation();
        $this->modalTitle = 'Add New Machine';
        $this->status = 'Running';
    }

    public function updatedLocationId()
    {
        // Reset line selection when location changes
        $this->line_id = null;
    }

    public function edit($id)
    {
        // Check permission untuk edit
        if (!auth()->user()->can('edit master machine')) {
            $this->dispatch('notify', message: 'You do not have permission to edit machine!', type: 'error');
            return;
        }

        try {
            $machine = MasterMachine::findOrFail($id);
            $this->machine_id = $machine->id;
            $this->location_id = $machine->location_id;
            $this->line_id = $machine->line_id;
            $this->name = $machine->name;
            $this->model_type = $machine->model_type;
            $this->mfg_date = $machine->mfg_date ? $machine->mfg_date->format('Y-m-d') : null;
            $this->maker = $machine->maker;
            $this->serial_no = $machine->serial_no;
            $this->power_voltage = $machine->power_voltage;
            $this->power_amper = $machine->power_amper;
            $this->no_of_phases = $machine->no_of_phases;
            $this->air_supply = $machine->air_supply;
            $this->n2_supply = $machine->n2_supply;
            $this->status = $machine->status;
            $this->modalTitle = 'Edit Machine';
            $this->resetValidation();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Machine not found!', type: 'error');
        }
    }

    public function save()
    {
        // Check permission untuk create atau edit
        if ($this->machine_id) {
            if (!auth()->user()->can('edit master machine')) {
                $this->dispatch('notify', message: 'You do not have permission to update machine!', type: 'error');
                return;
            }
            // Update rules untuk edit mode - ignore unique for current record
            $this->rules['serial_no'] = 'required|string|max:255|unique:tb_mtc_master_machines,serial_no,' . $this->machine_id;
        } else {
            if (!auth()->user()->can('create master machine')) {
                $this->dispatch('notify', message: 'You do not have permission to create machine!', type: 'error');
                return;
            }
        }
        
        $this->validate();

        try {
            if ($this->machine_id) {
                // Update existing machine
                $machine = MasterMachine::findOrFail($this->machine_id);
                $machine->update([
                    'location_id' => $this->location_id,
                    'line_id' => $this->line_id,
                    'name' => $this->name,
                    'model_type' => $this->model_type,
                    'mfg_date' => $this->mfg_date,
                    'maker' => $this->maker,
                    'serial_no' => $this->serial_no,
                    'power_voltage' => $this->power_voltage,
                    'power_amper' => $this->power_amper,
                    'no_of_phases' => $this->no_of_phases,
                    'air_supply' => $this->air_supply,
                    'n2_supply' => $this->n2_supply,
                    'status' => $this->status,
                ]);
                $message = 'Machine updated successfully!';
            } else {
                // Create new machine
                MasterMachine::create([
                    'location_id' => $this->location_id,
                    'line_id' => $this->line_id,
                    'name' => $this->name,
                    'model_type' => $this->model_type,
                    'mfg_date' => $this->mfg_date,
                    'maker' => $this->maker,
                    'serial_no' => $this->serial_no,
                    'power_voltage' => $this->power_voltage,
                    'power_amper' => $this->power_amper,
                    'no_of_phases' => $this->no_of_phases,
                    'air_supply' => $this->air_supply,
                    'n2_supply' => $this->n2_supply,
                    'status' => $this->status,
                ]);
                $message = 'Machine created successfully!';
            }

            $this->resetForm();
            $this->dispatch('close-modal', 'machine-form-modal');
            $this->dispatch('notify', message: $message, type: 'success');
            
        } catch (\Exception $e) {
            Log::error('Error saving machine: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to save machine!', type: 'error');
        }
    }

    public function confirmDelete($id)
    {
        // Check permission untuk delete
        if (!auth()->user()->can('delete master machine')) {
            $this->dispatch('notify', message: 'You do not have permission to delete machine!', type: 'error');
            return;
        }

        try {
            $this->machineToDelete = MasterMachine::findOrFail($id);
            $this->dispatch('open-modal', 'delete-machine-modal');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Machine not found!', type: 'error');
        }
    }

    public function delete()
    {
        // Check permission untuk delete
        if (!auth()->user()->can('delete master machine')) {
            $this->dispatch('notify', message: 'You do not have permission to delete machine!', type: 'error');
            return;
        }

        try {
            $machine = MasterMachine::findOrFail($this->machineToDelete->id);
            $machineName = $machine->name;
            $machine->delete();
            
            $this->dispatch('close-modal', 'delete-machine-modal');
            $this->dispatch('notify', message: "Machine '{$machineName}' deleted successfully!", type: 'success');
            $this->machineToDelete = null;
            
        } catch (\Exception $e) {
            Log::error('Error deleting machine: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to delete machine!', type: 'error');
        }
    }

    public function getLinesProperty()
    {
        if (!$this->location_id) {
            return collect();
        }
        return MasterLine::where('location_id', $this->location_id)
            ->orderBy('line_number')
            ->get();
    }

    public function getLocationsProperty()
    {
        return MasterLocation::with('area')->orderBy('location_name')->get();
    }

    public function getAllLinesProperty()
    {
        return MasterLine::with('location')->orderBy('line_number')->get();
    }

    public function render()
    {
        // Check permission untuk view
        if (!auth()->user()->can('view master machine')) {
            abort(403, 'You do not have permission to view master machine.');
        }

        $locations = $this->locations;
        $allLines = $this->all_lines;

        $machines = MasterMachine::with(['location', 'line', 'line.location', 'creator', 'updater'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('serial_no', 'like', '%' . $this->search . '%')
                      ->orWhere('maker', 'like', '%' . $this->search . '%')
                      ->orWhere('model_type', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedLocation, function ($query) {
                $query->where('location_id', $this->selectedLocation);
            })
            ->when($this->selectedLine, function ($query) {
                $query->where('line_id', $this->selectedLine);
            })
            ->when($this->selectedStatus, function ($query) {
                $query->where('status', $this->selectedStatus);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.mtc.master.master-machine-management', [
            'machines' => $machines,
            'locations' => $locations,
            'allLines' => $allLines,
        ]);
    }
}