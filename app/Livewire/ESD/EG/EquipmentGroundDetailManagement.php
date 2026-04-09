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
    public $filterMachine = '';
    public $filterArea = '';
    public $filterLocation = '';
    public $filterJudgementOhm = '';
    public $filterJudgementVolts = '';
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    public $filterNextDateFrom = '';
    public $filterNextDateUntil = '';

    public $modalTitle = 'Add New Measurement Detail';
    public $detailToDelete = null;

    // Properti untuk print
    public $printPreview = false;
    public $printMachineName = '';
    public $printArea = '';
    public $printLocation = '';
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

    protected $messages = [
        'equipment_ground_id.required' => 'Machine name is required.',
        'equipment_ground_id.exists' => 'Selected machine does not exist.',
        'measure_results_ohm.required' => 'Ohm measurement result is required.',
        'measure_results_ohm.numeric' => 'Ohm measurement result must be a number.',
        'measure_results_volts.required' => 'Volts measurement result is required.',
        'measure_results_volts.numeric' => 'Volts measurement result must be a number.',
        'next_date.date' => 'Next date must be a valid date.',
    ];

    public function mount()
    {
        $this->resetJudgement();
    }

    public function resetJudgement()
    {
        // Standard Ohm: < 1.00 Ohm
        if ($this->measure_results_ohm !== null && $this->measure_results_ohm !== '') {
            $this->judgement_ohm = floatval($this->measure_results_ohm) >= 1.00 ? 'NG' : 'OK';
        } else {
            $this->judgement_ohm = null;
        }
        
        // Standard Volts: < 2.00 Volts
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
        $this->reset([
            'search', 'filterMachine', 'filterArea', 'filterLocation',
            'filterJudgementOhm', 'filterJudgementVolts',
            'filterDateFrom', 'filterDateUntil',
            'filterNextDateFrom', 'filterNextDateUntil'
        ]);
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

    public function cancelDelete()
    {
        $this->detailToDelete = null;
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    /**
     * Generate PDF untuk print
     */
    public function printPDF()
    {
        if (!auth()->user()->can('view equipment ground details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        // Validasi minimal satu filter dipilih
        if (empty($this->printMachineName) && empty($this->printArea) && empty($this->printLocation) && empty($this->printDateFrom) && empty($this->printDateUntil)) {
            $this->dispatch('notify', message: 'Please select at least one filter (Machine Name, Area, Location, or Date Range)!', type: 'error');
            return;
        }

        // Query data untuk print
        $query = EquipmentGroundDetail::with(['equipmentGround', 'creator']);

        // Filter by Machine Name
        if (!empty($this->printMachineName)) {
            $query->whereHas('equipmentGround', function ($q) {
                $q->where('machine_name', 'like', '%' . $this->printMachineName . '%');
            });
        }

        // Filter by Area
        if (!empty($this->printArea)) {
            $query->whereHas('equipmentGround', function ($q) {
                $q->where('area', 'like', '%' . $this->printArea . '%');
            });
        }

        // Filter by Location
        if (!empty($this->printLocation)) {
            $query->whereHas('equipmentGround', function ($q) {
                $q->where('location', 'like', '%' . $this->printLocation . '%');
            });
        }

        // Filter by Date Range
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

        // Data untuk PDF
        $data = [
            'details' => $details,
            'title' => 'ESD EQUIPMENT GROUND MEASUREMENT REPORT',
            'date_from' => $this->printDateFrom,
            'date_until' => $this->printDateUntil,
            'machine_name' => $this->printMachineName,
            'area' => $this->printArea,
            'location' => $this->printLocation,
            'generated_by' => auth()->user()->name,
            'generated_at' => Carbon::now()->format('d M Y H:i:s'),
            'prepared_by' => auth()->user()->name,
            'checked_by' => null,
            'approved_by' => null,
        ];

        // Generate PDF
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
        $this->printMachineName = '';
        $this->printArea = '';
        $this->printLocation = '';
        $this->printDateFrom = '';
        $this->printDateUntil = '';
        $this->printPreview = false;
        $this->dispatch('notify', message: 'Print filters have been reset!', type: 'success');
    }

    public function render()
    {
        if (!auth()->user()->can('view equipment ground details')) {
            abort(403, 'Unauthorized access.');
        }

        $machines = EquipmentGround::orderBy('machine_name')->get();
        
        $details = EquipmentGroundDetail::with(['equipmentGround', 'creator'])
            ->when($this->search, function ($query) {
                $query->whereHas('equipmentGround', function ($q) {
                    $q->where('machine_name', 'like', '%' . $this->search . '%')
                        ->orWhere('area', 'like', '%' . $this->search . '%')
                        ->orWhere('location', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterMachine, function ($query) {
                $query->where('equipment_ground_id', $this->filterMachine);
            })
            ->when($this->filterArea, function ($query) {
                $query->whereHas('equipmentGround', function ($q) {
                    $q->where('area', 'like', '%' . $this->filterArea . '%');
                });
            })
            ->when($this->filterLocation, function ($query) {
                $query->whereHas('equipmentGround', function ($q) {
                    $q->where('location', 'like', '%' . $this->filterLocation . '%');
                });
            })
            ->when($this->filterJudgementOhm, function ($query) {
                $query->where('judgement_ohm', $this->filterJudgementOhm);
            })
            ->when($this->filterJudgementVolts, function ($query) {
                $query->where('judgement_volts', $this->filterJudgementVolts);
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
            'machines' => $machines,
        ]);
    }
}