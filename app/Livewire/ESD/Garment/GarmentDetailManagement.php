<?php

namespace App\Livewire\ESD\Garment;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Garment\Garment;
use App\Models\ESD\Garment\GarmentDetail;
use Carbon\Carbon;

class GarmentDetailManagement extends Component
{
    use WithPagination;

    public $detail_id;
    public $nik;
    public $name;
    public $d1;
    public $d1_scientific;
    public $judgement_d1;
    public $d2;
    public $d2_scientific;
    public $judgement_d2;
    public $d3;
    public $d3_scientific;
    public $judgement_d3;
    public $d4;
    public $d4_scientific;
    public $judgement_d4;
    public $remarks;
    public $next_date;

    public $search = '';
    public $filterNik = '';
    public $filterName = '';
    public $filterJudgementD1 = '';
    public $filterJudgementD2 = '';
    public $filterJudgementD3 = '';
    public $filterJudgementD4 = '';
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    public $filterNextDateFrom = '';
    public $filterNextDateUntil = '';

    public $modalTitle = 'Add New Garment Measurement';
    public $detailToDelete = null;
    
    public $garments = [];

    protected function rules()
    {
        return [
            'nik' => 'required|exists:tb_hr_employee,id',
            'd1' => 'nullable|numeric|min:0',
            'd2' => 'nullable|numeric|min:0',
            'd3' => 'nullable|numeric|min:0',
            'd4' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string|max:500',
            'next_date' => 'nullable|date',
        ];
    }

    protected $messages = [
        'nik.required' => 'NIK is required.',
        'nik.exists' => 'Selected employee does not exist.',
        'd1.numeric' => 'D1 measurement must be a number.',
        'd2.numeric' => 'D2 measurement must be a number.',
        'd3.numeric' => 'D3 measurement must be a number.',
        'd4.numeric' => 'D4 measurement must be a number.',
        'next_date.date' => 'Next date must be a valid date.',
    ];

    public function mount()
    {
        $this->loadGarments();
        $this->resetJudgements();
    }

    public function loadGarments()
    {
        $this->garments = Garment::whereIn('status', [1, 2, 3])
            ->orderBy('nik')
            ->get();
    }

    public function resetJudgements()
    {
        // Standard: >= 1.00E+4 and < 1.00E+11 Ohm (10,000 - 99,999,999,999 Ohm)
        $minStandard = 10000; // 1.00E+4
        $maxStandard = 100000000000; // 1.00E+11 (exclusive)
    
        // Handle D1
        if ($this->d1 !== null && $this->d1 !== '') {
            $this->judgement_d1 = ($this->d1 >= $minStandard && $this->d1 < $maxStandard) ? 'OK' : 'NG';
            $this->d1_scientific = sprintf('%.2E', floatval($this->d1));
        } else {
            $this->judgement_d1 = null;
            $this->d1_scientific = null;
        }
        
        // Handle D2
        if ($this->d2 !== null && $this->d2 !== '') {
            $this->judgement_d2 = ($this->d2 >= $minStandard && $this->d2 < $maxStandard) ? 'OK' : 'NG';
            $this->d2_scientific = sprintf('%.2E', floatval($this->d2));
        } else {
            $this->judgement_d2 = null;
            $this->d2_scientific = null;
        }
        
        // Handle D3
        if ($this->d3 !== null && $this->d3 !== '') {
            $this->judgement_d3 = ($this->d3 >= $minStandard && $this->d3 < $maxStandard) ? 'OK' : 'NG';
            $this->d3_scientific = sprintf('%.2E', floatval($this->d3));
        } else {
            $this->judgement_d3 = null;
            $this->d3_scientific = null;
        }
        
        // Handle D4
        if ($this->d4 !== null && $this->d4 !== '') {
            $this->judgement_d4 = ($this->d4 >= $minStandard && $this->d4 < $maxStandard) ? 'OK' : 'NG';
            $this->d4_scientific = sprintf('%.2E', floatval($this->d4));
        } else {
            $this->judgement_d4 = null;
            $this->d4_scientific = null;
        }
    }

    public function updatedD1()
    {
        $this->resetJudgements();
    }

    public function updatedD2()
    {
        $this->resetJudgements();
    }

    public function updatedD3()
    {
        $this->resetJudgements();
    }

    public function updatedD4()
    {
        $this->resetJudgements();
    }

    public function updatedNik($value)
    {
        if ($value) {
            $garment = Garment::find($value);
            if ($garment) {
                $this->name = $garment->name;
            }
        } else {
            $this->name = null;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'detail_id', 'nik', 'name',
            'd1', 'd1_scientific', 'judgement_d1',
            'd2', 'd2_scientific', 'judgement_d2',
            'd3', 'd3_scientific', 'judgement_d3',
            'd4', 'd4_scientific', 'judgement_d4',
            'remarks', 'next_date'
        ]);
        $this->modalTitle = 'Add New Garment Measurement';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset([
            'search', 'filterNik', 'filterName',
            'filterJudgementD1', 'filterJudgementD2',
            'filterJudgementD3', 'filterJudgementD4',
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
            if (!auth()->user()->can('edit garment details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create garment details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        // Reset judgements before save to ensure all fields are properly set
        $this->resetJudgements();

        $data = [
            'nik' => $this->nik,
            'name' => $this->name,
            'd1' => $this->d1,
            'd1_scientific' => $this->d1_scientific,
            'judgement_d1' => $this->judgement_d1,
            'd2' => $this->d2,
            'd2_scientific' => $this->d2_scientific,
            'judgement_d2' => $this->judgement_d2,
            'd3' => $this->d3,
            'd3_scientific' => $this->d3_scientific,
            'judgement_d3' => $this->judgement_d3,
            'd4' => $this->d4,
            'd4_scientific' => $this->d4_scientific,
            'judgement_d4' => $this->judgement_d4,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
        ];

        if ($this->detail_id) {
            $detail = GarmentDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Garment measurement not found!', type: 'error');
                return;
            }

            $detail->update($data);
            $message = 'Garment measurement updated successfully!';
        } else {
            GarmentDetail::create($data);
            $message = 'Garment measurement created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'detail-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit garment details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = GarmentDetail::with('garment')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Garment measurement not found!', type: 'error');
            return;
        }

        $this->detail_id = $detail->id;
        $this->nik = $detail->nik;
        $this->name = $detail->name;
        $this->d1 = $detail->d1;
        $this->d1_scientific = $detail->d1_scientific;
        $this->judgement_d1 = $detail->judgement_d1;
        $this->d2 = $detail->d2;
        $this->d2_scientific = $detail->d2_scientific;
        $this->judgement_d2 = $detail->judgement_d2;
        $this->d3 = $detail->d3;
        $this->d3_scientific = $detail->d3_scientific;
        $this->judgement_d3 = $detail->judgement_d3;
        $this->d4 = $detail->d4;
        $this->d4_scientific = $detail->d4_scientific;
        $this->judgement_d4 = $detail->judgement_d4;
        $this->remarks = $detail->remarks;
        $this->next_date = $detail->next_date ? Carbon::parse($detail->next_date)->format('Y-m-d') : null;
        $this->modalTitle = 'Edit Garment Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete garment details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = GarmentDetail::with('garment')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Garment measurement not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $detail;
        $this->dispatch('open-modal', 'delete-detail-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete garment details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = GarmentDetail::find($this->detailToDelete->id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Garment measurement not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $nik = $this->detailToDelete->nik ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Measurement for NIK '{$nik}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function cancelDelete()
    {
        $this->detailToDelete = null;
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view garment details')) {
            abort(403, 'Unauthorized access.');
        }

        $garmentsList = Garment::whereIn('status', [1, 2, 3])
            ->orderBy('nik')
            ->get();
        
        $details = GarmentDetail::with(['garment', 'creator'])
            ->when($this->search, function ($query) {
                $query->whereHas('garment', function ($q) {
                    $q->where('nik', 'like', '%' . $this->search . '%')
                        ->orWhere('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterNik, function ($query) {
                $query->where('nik', $this->filterNik);
            })
            ->when($this->filterName, function ($query) {
                $query->whereHas('garment', function ($q) {
                    $q->where('name', 'like', '%' . $this->filterName . '%');
                });
            })
            ->when($this->filterJudgementD1, function ($query) {
                $query->where('judgement_d1', $this->filterJudgementD1);
            })
            ->when($this->filterJudgementD2, function ($query) {
                $query->where('judgement_d2', $this->filterJudgementD2);
            })
            ->when($this->filterJudgementD3, function ($query) {
                $query->where('judgement_d3', $this->filterJudgementD3);
            })
            ->when($this->filterJudgementD4, function ($query) {
                $query->where('judgement_d4', $this->filterJudgementD4);
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

        return view('livewire.esd.garment.garment-detail-management', [
            'details' => $details,
            'garmentsList' => $garmentsList,
        ]);
    }
}