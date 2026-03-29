<?php

namespace App\Livewire\ESD\EG;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\EG\EquipmentGround;
use App\Models\ESD\EG\EquipmentGroundDetail;

class EquipmentGroundShow extends Component
{
    use WithPagination;

    public $equipmentGround;
    
    // Filter properties
    public $filterDateFrom;
    public $filterDateUntil;
    public $filterNextDateFrom;
    public $filterNextDateUntil;
    public $search = '';
    
    // Form properties
    public $detail_id;
    public $equipment_ground_id;
    public $area;
    public $location;
    public $measure_results_ohm;
    public $measure_results_volts;
    public $judgement_ohm;
    public $judgement_volts;
    public $remarks;
    public $next_date;
    public $modalTitle = 'Add New Measurement';
    public $detailToDelete = null;
    
    // Machines list for dropdown
    public $machines;

    protected function rules()
    {
        return [
            'equipment_ground_id' => 'required|exists:equipment_grounds,id',
            'measure_results_ohm' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
            'measure_results_volts' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
            'remarks' => 'nullable|string',
            'next_date' => 'nullable|date',
        ];
    }
    
    protected function messages()
    {
        return [
            'equipment_ground_id.required' => 'Machine name is required.',
            'equipment_ground_id.exists' => 'Selected machine does not exist.',
            'measure_results_ohm.required' => 'Ohm measurement is required.',
            'measure_results_ohm.numeric' => 'Ohm measurement must be a number.',
            'measure_results_ohm.regex' => 'Ohm measurement can have up to 3 decimal places.',
            'measure_results_volts.required' => 'Volts measurement is required.',
            'measure_results_volts.numeric' => 'Volts measurement must be a number.',
            'measure_results_volts.regex' => 'Volts measurement can have up to 3 decimal places.',
            'next_date.date' => 'Next date must be a valid date.',
        ];
    }

    public function mount($id)
    {
        $this->equipmentGround = EquipmentGround::with('creator')->findOrFail($id);
        
        if (!auth()->user()->can('view equipment grounds')) {
            abort(403, 'Unauthorized access.');
        }
        
        $this->loadMachines();
    }

    public function loadMachines()
    {
        $this->machines = EquipmentGround::orderBy('machine_name')->get();
    }

    public function updatedMeasureResultsOhm()
    {
        $this->resetJudgement();
    }

    public function updatedMeasureResultsVolts()
    {
        $this->resetJudgement();
    }

    public function resetJudgement()
    {
        if ($this->measure_results_ohm !== null && $this->measure_results_ohm !== '') {
            $this->judgement_ohm = floatval($this->measure_results_ohm) < 1.0 ? 'OK' : 'NG';
        }
        
        if ($this->measure_results_volts !== null && $this->measure_results_volts !== '') {
            $this->judgement_volts = floatval($this->measure_results_volts) < 2.0 ? 'OK' : 'NG';
        }
    }

    public function updatedEquipmentGroundId($value)
    {
        if ($value) {
            $machine = EquipmentGround::find($value);
            if ($machine) {
                $this->area = $machine->area;
                $this->location = $machine->location;
            }
        } else {
            $this->area = null;
            $this->location = null;
        }
    }

    public function resetForm()
    {
        $this->reset(['detail_id', 'equipment_ground_id', 'area', 'location', 
                      'measure_results_ohm', 'measure_results_volts', 'judgement_ohm', 
                      'judgement_volts', 'remarks', 'next_date']);
        $this->modalTitle = 'Add New Measurement';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset(['filterDateFrom', 'filterDateUntil', 'filterNextDateFrom', 'filterNextDateUntil', 'search']);
        $this->resetPage();
    }

    public function save()
    {
        if ($this->detail_id) {
            if (!auth()->user()->can('edit equipment ground details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create equipment ground details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }
    
        // Set equipment_ground_id from the current equipment ground
        $this->equipment_ground_id = $this->equipmentGround->id;
    
        $this->validate([
            'measure_results_ohm' => 'required|numeric|min:0',
            'measure_results_volts' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
            'next_date' => 'nullable|date',
        ]);
    
        $this->resetJudgement();
    
        $data = [
            'equipment_ground_id' => $this->equipment_ground_id,
            'measure_results_ohm' => $this->measure_results_ohm,
            'measure_results_volts' => $this->measure_results_volts,
            'judgement_ohm' => $this->judgement_ohm,
            'judgement_volts' => $this->judgement_volts,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
        ];
    
        if ($this->detail_id) {
            $detail = EquipmentGroundDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
                return;
            }
            
            $detail->update($data);
            $message = 'Measurement updated successfully!';
        } else {
            EquipmentGroundDetail::create($data);
            $message = 'Measurement created successfully!';
        }
    
        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'detail-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit equipment ground details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }
    
        $detail = EquipmentGroundDetail::with('equipmentGround')->find($id);
    
        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            return;
        }
    
        $this->detail_id = $detail->id;
        $this->equipment_ground_id = $detail->equipment_ground_id;
        $this->area = $detail->equipmentGround->area ?? null;
        $this->location = $detail->equipmentGround->location ?? null;
        $this->measure_results_ohm = $detail->measure_results_ohm;
        $this->measure_results_volts = $detail->measure_results_volts;
        $this->judgement_ohm = $detail->judgement_ohm;
        $this->judgement_volts = $detail->judgement_volts;
        $this->remarks = $detail->remarks;
        $this->next_date = $detail->next_date ? \Carbon\Carbon::parse($detail->next_date)->format('Y-m-d') : null;
        $this->modalTitle = 'Edit Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete equipment ground details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = EquipmentGroundDetail::with('equipmentGround')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $detail;
        $this->dispatch('open-modal', 'delete-detail-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete equipment ground details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = EquipmentGroundDetail::find($this->detailToDelete->id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $machineName = $detail->equipmentGround->machine_name ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Measurement for '{$machineName}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function render()
    {
        $details = EquipmentGroundDetail::with(['equipmentGround', 'creator'])
            ->where('equipment_ground_id', $this->equipmentGround->id)
            ->when($this->filterDateFrom, function ($query) {
                $query->whereDate('created_at', '>=', $this->filterDateFrom);
            })
            ->when($this->filterDateUntil, function ($query) {
                $query->whereDate('created_at', '<=', $this->filterDateUntil);
            })
            ->when($this->filterNextDateFrom, function ($query) {
                $query->whereDate('next_date', '>=', $this->filterNextDateFrom);
            })
            ->when($this->filterNextDateUntil, function ($query) {
                $query->whereDate('next_date', '<=', $this->filterNextDateUntil);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.esd.eg.equipment-ground-show', [
            'details' => $details,
        ]);
    }
}