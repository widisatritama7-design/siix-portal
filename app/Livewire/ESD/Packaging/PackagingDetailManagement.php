<?php

namespace App\Livewire\ESD\Packaging;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Packaging\Packaging;
use App\Models\ESD\Packaging\PackagingDetail;
use Carbon\Carbon;

class PackagingDetailManagement extends Component
{
    use WithPagination;

    public $detail_id;
    public $packaging_id;
    public $category;
    public $project;
    public $model;
    public $material;
    public $f1;
    public $f1_scientific;
    public $judgement_f1;
    public $f2;
    public $judgement_f2;
    public $remarks;
    public $next_date;

    public $search = '';
    public $filterPackaging = '';
    public $filterJudgementF1 = '';
    public $filterJudgementF2 = '';
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    public $filterNextDateFrom = '';
    public $filterNextDateUntil = '';

    public $modalTitle = 'Add New Packaging Measurement';
    public $detailToDelete = null;

    protected function rules()
    {
        return [
            'packaging_id' => 'required|exists:tb_esd_packagings,id',
            'f1' => 'required|numeric|min:10000|max:99999999999',
            'f2' => 'required|numeric|min:0|max:99',
            'remarks' => 'nullable|string|max:500',
            'next_date' => 'nullable|date',
        ];
    }

    protected $messages = [
        'packaging_id.required' => 'Packaging material is required.',
        'packaging_id.exists' => 'Selected packaging does not exist.',
        'f1.required' => 'F1 measurement result is required.',
        'f1.numeric' => 'F1 measurement result must be a number.',
        'f1.min' => 'F1 measurement result must be at least 10,000 Ω.',
        'f1.max' => 'F1 measurement result must be less than 100,000,000,000 Ω.',
        'f2.required' => 'F2 measurement result is required.',
        'f2.numeric' => 'F2 measurement result must be a number.',
        'f2.min' => 'F2 measurement result must be at least 0.',
        'f2.max' => 'F2 measurement result must be less than 100.',
        'next_date.date' => 'Next date must be a valid date.',
    ];

    public function mount()
    {
        $this->resetJudgements();
    }

    public function resetJudgements()
    {
        // F1 Judgement: >= 10,000 and < 100,000,000,000 is OK
        if ($this->f1 !== null && $this->f1 !== '') {
            $this->judgement_f1 = (floatval($this->f1) >= 10000 && floatval($this->f1) < 100000000000) ? 'OK' : 'NG';
            $this->f1_scientific = sprintf('%.2E', floatval($this->f1));
        }

        // F2 Judgement: < 100 is OK
        if ($this->f2 !== null && $this->f2 !== '') {
            $this->judgement_f2 = floatval($this->f2) < 100 ? 'OK' : 'NG';
        }
    }

    public function updatedF1()
    {
        $this->resetJudgements();
    }

    public function updatedF2()
    {
        $this->resetJudgements();
    }

    public function updatedPackagingId($value)
    {
        if ($value) {
            $packaging = Packaging::find($value);
            if ($packaging) {
                $this->category = $packaging->category;
                $this->project = $packaging->project;
                $this->model = $packaging->model;
                $this->material = $packaging->material;
            }
        } else {
            $this->category = null;
            $this->project = null;
            $this->model = null;
            $this->material = null;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'detail_id', 'packaging_id', 'category', 'project', 'model', 'material',
            'f1', 'f1_scientific', 'judgement_f1',
            'f2', 'judgement_f2', 'remarks', 'next_date'
        ]);
        $this->modalTitle = 'Add New Packaging Measurement';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset([
            'search', 'filterPackaging', 'filterJudgementF1',
            'filterJudgementF2', 'filterDateFrom', 'filterDateUntil',
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
            if (!auth()->user()->can('edit packaging details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create packaging details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'packaging_id' => $this->packaging_id,
            'f1' => $this->f1,
            'f1_scientific' => $this->f1_scientific,
            'judgement_f1' => $this->judgement_f1,
            'f2' => $this->f2,
            'judgement_f2' => $this->judgement_f2,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
        ];

        if ($this->detail_id) {
            $detail = PackagingDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Packaging measurement not found!', type: 'error');
                return;
            }

            $detail->update($data);
            $message = 'Packaging measurement updated successfully!';
        } else {
            PackagingDetail::create($data);
            $message = 'Packaging measurement created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'detail-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit packaging details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = PackagingDetail::with('packaging')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Packaging measurement not found!', type: 'error');
            return;
        }

        $this->detail_id = $detail->id;
        $this->packaging_id = $detail->packaging_id;
        $this->category = $detail->packaging->category ?? '';
        $this->project = $detail->packaging->project ?? '';
        $this->model = $detail->packaging->model ?? '';
        $this->material = $detail->packaging->material ?? '';
        $this->f1 = $detail->f1;
        $this->f1_scientific = $detail->f1_scientific;
        $this->judgement_f1 = $detail->judgement_f1;
        $this->f2 = $detail->f2;
        $this->judgement_f2 = $detail->judgement_f2;
        $this->remarks = $detail->remarks;
        $this->next_date = $detail->next_date ? Carbon::parse($detail->next_date)->format('Y-m-d') : null;
        $this->modalTitle = 'Edit Packaging Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete packaging details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = PackagingDetail::with('packaging')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Packaging measurement not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $detail;
        $this->dispatch('open-modal', 'delete-detail-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete packaging details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = PackagingDetail::find($this->detailToDelete->id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Packaging measurement not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $material = $detail->packaging->material ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Measurement for '{$material}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function cancelDelete()
    {
        $this->detailToDelete = null;
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view packaging details')) {
            abort(403, 'Unauthorized access.');
        }

        $packagings = Packaging::orderBy('material')->get();
        
        $details = PackagingDetail::with(['packaging', 'creator'])
            ->when($this->search, function ($query) {
                $query->whereHas('packaging', function ($q) {
                    $q->where('category', 'like', '%' . $this->search . '%')
                        ->orWhere('project', 'like', '%' . $this->search . '%')
                        ->orWhere('model', 'like', '%' . $this->search . '%')
                        ->orWhere('material', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterPackaging, function ($query) {
                $query->where('packaging_id', $this->filterPackaging);
            })
            ->when($this->filterJudgementF1, function ($query) {
                $query->where('judgement_f1', $this->filterJudgementF1);
            })
            ->when($this->filterJudgementF2, function ($query) {
                $query->where('judgement_f2', $this->filterJudgementF2);
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

        return view('livewire.esd.packaging.packaging-detail-management', [
            'details' => $details,
            'packagings' => $packagings,
        ]);
    }
}