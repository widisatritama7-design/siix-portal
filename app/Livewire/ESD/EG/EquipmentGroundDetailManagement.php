<?php

namespace App\Livewire\ESD\EG;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\EG\EquipmentGround;
use App\Models\ESD\EG\EquipmentGroundDetail;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class EquipmentGroundDetailManagement extends Component
{
    use WithPagination;

    public $detail_id;
    public $equipment_ground_id;
    public $machine_name;
    public $area;
    public $location;
    public $measure_results_ohm;
    public $judgement_ohm;
    public $measure_results_volts;
    public $judgement_volts;
    public $remarks;
    public $next_date;

    public $search = '';
    public $selectedMachines = []; // Array untuk menyimpan machine IDs yang dipilih
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    public $filterNextDateFrom = '';
    public $filterNextDateUntil = '';
    
    // Untuk search machine di dropdown
    public $machineSearch = '';
    public $printMachineSearch = '';

    public $modalTitle = 'Add New Measurement Detail';
    public $detailToDelete = null;

    // Properti untuk print
    public $printSelectedMachines = [];
    public $printDateFrom = '';
    public $printDateUntil = '';

    protected function rules()
    {
        return [
            'equipment_ground_id' => 'required|exists:tb_esd_equipment_grounds,id',
            'measure_results_ohm' => 'required|numeric',
            'measure_results_volts' => 'required|numeric',
            'remarks' => 'nullable|string|max:500',
            'next_date' => 'nullable|date',
        ];
    }

    public function resetJudgement()
    {
        if ($this->measure_results_ohm !== null && $this->measure_results_ohm !== '') {
            $this->judgement_ohm = floatval($this->measure_results_ohm) >= 1.00 ? 'NG' : 'OK';
        } else {
            $this->judgement_ohm = null;
        }
        
        if ($this->measure_results_volts !== null && $this->measure_results_volts !== '') {
            $this->judgement_volts = floatval($this->measure_results_volts) >= 2.00 ? 'NG' : 'OK';
        } else {
            $this->judgement_volts = null;
        }
    }

    public function updatedMeasureResultsOhm()
    {
        $this->resetJudgement();
    }

    public function updatedMeasureResultsVolts()
    {
        $this->resetJudgement();
    }

    public function updatedEquipmentGroundId($value)
    {
        if ($value) {
            $equipment = EquipmentGround::find($value);
            if ($equipment) {
                $this->area = $equipment->area;
                $this->location = $equipment->location;
                $this->machine_name = $equipment->machine_name;
            }
        } else {
            $this->area = null;
            $this->location = null;
            $this->machine_name = null;
        }
    }

    // Tambah machine ke filter
    public function addMachineFilter($machineId)
    {
        if (!in_array($machineId, $this->selectedMachines)) {
            $this->selectedMachines[] = $machineId;
        }
        $this->machineSearch = '';
        $this->resetPage();
    }

    // Remove machine dari filter
    public function removeMachineFilter($machineId)
    {
        $this->selectedMachines = array_values(array_diff($this->selectedMachines, [$machineId]));
        $this->resetPage();
    }

    // Tambah machine ke print filter
    public function addPrintMachine($machineId)
    {
        if (!in_array($machineId, $this->printSelectedMachines)) {
            $this->printSelectedMachines[] = $machineId;
        }
        $this->printMachineSearch = '';
    }

    // Remove machine dari print filter
    public function removePrintMachine($machineId)
    {
        $this->printSelectedMachines = array_values(array_diff($this->printSelectedMachines, [$machineId]));
    }

    public function resetForm()
    {
        $this->reset([
            'detail_id', 'equipment_ground_id', 'machine_name', 'area', 'location',
            'measure_results_ohm', 'judgement_ohm', 'measure_results_volts',
            'judgement_volts', 'remarks', 'next_date'
        ]);
        $this->modalTitle = 'Add New Measurement Detail';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->selectedMachines = [];
        $this->filterDateFrom = '';
        $this->filterDateUntil = '';
        $this->filterNextDateFrom = '';
        $this->filterNextDateUntil = '';
        $this->search = '';
        $this->resetPage();
    }

    public function updatedSearch()
    {
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

        $this->validate();
        $this->resetJudgement();

        $data = [
            'equipment_ground_id' => $this->equipment_ground_id,
            'measure_results_ohm' => $this->measure_results_ohm,
            'judgement_ohm' => $this->judgement_ohm,
            'measure_results_volts' => $this->measure_results_volts,
            'judgement_volts' => $this->judgement_volts,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
        ];

        if ($this->detail_id) {
            $detail = EquipmentGroundDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Measurement detail not found!', type: 'error');
                return;
            }
            $detail->update($data);
            $message = 'Measurement detail updated successfully!';
        } else {
            EquipmentGroundDetail::create($data);
            $message = 'Measurement detail created successfully!';
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
            $this->dispatch('notify', message: 'Measurement detail not found!', type: 'error');
            return;
        }

        $this->detail_id = $detail->id;
        $this->equipment_ground_id = $detail->equipment_ground_id;
        $this->machine_name = $detail->equipmentGround->machine_name ?? '';
        $this->area = $detail->equipmentGround->area ?? '';
        $this->location = $detail->equipmentGround->location ?? '';
        $this->measure_results_ohm = $detail->measure_results_ohm;
        $this->judgement_ohm = $detail->judgement_ohm;
        $this->measure_results_volts = $detail->measure_results_volts;
        $this->judgement_volts = $detail->judgement_volts;
        $this->remarks = $detail->remarks;
        $this->next_date = $detail->next_date;
        $this->modalTitle = 'Edit Measurement Detail';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete equipment ground details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = EquipmentGroundDetail::with('equipmentGround')->find($id);
        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement detail not found!', type: 'error');
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
            $this->dispatch('notify', message: 'Measurement detail not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $machineName = $this->detailToDelete->equipmentGround->machine_name ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Measurement for '{$machineName}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function printPDF()
    {
        if (!auth()->user()->can('view equipment ground details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        if (empty($this->printSelectedMachines) && empty($this->printDateFrom) && empty($this->printDateUntil)) {
            $this->dispatch('notify', message: 'Please select at least one filter!', type: 'error');
            return;
        }

        $query = EquipmentGroundDetail::with(['equipmentGround', 'creator']);

        if (!empty($this->printSelectedMachines)) {
            $query->whereIn('equipment_ground_id', $this->printSelectedMachines);
        }

        if (!empty($this->printDateFrom)) {
            $query->whereDate('created_at', '>=', $this->printDateFrom);
        }

        if (!empty($this->printDateUntil)) {
            $query->whereDate('created_at', '<=', $this->printDateUntil);
        }

        $details = $query->orderBy('created_at', 'desc')->get();

        if ($details->isEmpty()) {
            $this->dispatch('notify', message: 'No data found for the selected filters!', type: 'warning');
            return;
        }

        $selectedMachineNames = EquipmentGround::whereIn('id', $this->printSelectedMachines)->pluck('machine_name')->toArray();

        $data = [
            'details' => $details,
            'title' => 'ESD EQUIPMENT GROUND MEASUREMENT REPORT',
            'date_from' => $this->printDateFrom,
            'date_until' => $this->printDateUntil,
            'machine_names' => $selectedMachineNames,
            'generated_by' => auth()->user()->name,
            'generated_at' => Carbon::now()->format('d M Y H:i:s'),
        ];

        $pdf = Pdf::loadView('livewire.esd.eg.equipment-ground-detail-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return response()->streamDownload(
            function () use ($pdf) {
                echo $pdf->output();
            },
            'equipment-ground-measurement-' . Carbon::now()->format('Ymd_His') . '.pdf'
        );
    }

    public function resetPrintFilters()
    {
        $this->printSelectedMachines = [];
        $this->printDateFrom = '';
        $this->printDateUntil = '';
        $this->dispatch('notify', message: 'Print filters have been reset!', type: 'success');
    }

    public function render()
    {
        if (!auth()->user()->can('view equipment ground details')) {
            abort(403, 'Unauthorized access.');
        }

        $allMachines = EquipmentGround::orderBy('machine_name')->get();
        
        // Filter machines untuk dropdown (searchable)
        $availableMachines = EquipmentGround::when($this->machineSearch, function($query) {
            $query->where('machine_name', 'like', '%' . $this->machineSearch . '%');
        })->orderBy('machine_name')->get();
        
        $printAvailableMachines = EquipmentGround::when($this->printMachineSearch, function($query) {
            $query->where('machine_name', 'like', '%' . $this->printMachineSearch . '%');
        })->orderBy('machine_name')->get();
        
        $details = EquipmentGroundDetail::with(['equipmentGround', 'creator'])
            ->when($this->search, function ($query) {
                $query->whereHas('equipmentGround', function ($q) {
                    $q->where('machine_name', 'like', '%' . $this->search . '%')
                        ->orWhere('area', 'like', '%' . $this->search . '%')
                        ->orWhere('location', 'like', '%' . $this->search . '%');
                });
            })
            ->when(!empty($this->selectedMachines), function ($query) {
                $query->whereIn('equipment_ground_id', $this->selectedMachines);
            })
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
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.esd.eg.equipment-ground-detail-management', [
            'details' => $details,
            'allMachines' => $allMachines,
            'availableMachines' => $availableMachines,
            'printAvailableMachines' => $printAvailableMachines,
        ]);
    }
}