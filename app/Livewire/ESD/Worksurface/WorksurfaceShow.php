<?php

namespace App\Livewire\ESD\Worksurface;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Worksurface\Worksurface;
use App\Models\ESD\Worksurface\WorksurfaceDetail;
use Carbon\Carbon;

class WorksurfaceShow extends Component
{
    use WithPagination;

    public $worksurface;

    // Filter properties
    public $filterDateFrom;
    public $filterDateUntil;
    public $filterNextDateFrom;
    public $filterNextDateUntil;
    public $search = '';

    // Form properties
    public $detail_id;
    public $worksurface_id;
    public $register_no;
    public $area;
    public $location;
    public $layer_count;
    public $category;
    public $item;
    public $a1;
    public $a1_scientific;
    public $judgement_a1;
    public $a2;
    public $judgement_a2;
    public $a3;
    public $judgement_a3;
    public $a4_1;
    public $a4_2;
    public $a4_3;
    public $a4_4;
    public $a4_5;
    public $remarks;
    public $next_date;
    public $modalTitle = 'Add New Measurement';
    public $detailToDelete = null;

    // Worksurface list for dropdown
    public $worksurfaces;
    public $itemSearch = '';
    public $showItemDropdown = false;

    protected function rules()
    {
        return [
            'worksurface_id' => 'required|exists:tb_esd_worksurfaces,id',
            'item' => 'nullable|string|max:100',
            'a1' => 'nullable|numeric',
            'a2' => 'nullable|numeric',
            'a3' => 'nullable|numeric',
            'a4_1' => 'nullable|boolean',
            'a4_2' => 'nullable|boolean',
            'a4_3' => 'nullable|boolean',
            'a4_4' => 'nullable|boolean',
            'a4_5' => 'nullable|boolean',
            'remarks' => 'nullable|string',
            'next_date' => 'nullable|date',
        ];
    }

    protected function messages()
    {
        return [
            'worksurface_id.required' => 'Worksurface equipment is required.',
            'worksurface_id.exists' => 'Selected worksurface does not exist.',
            'item.string' => 'Item must be a string.',
            'item.max' => 'Item cannot exceed 100 characters.',
            'a1.numeric' => 'A1 measurement must be a number.',
            'a2.numeric' => 'A2 measurement must be a number.',
            'a3.numeric' => 'A3 measurement must be a number.',
            'a4_1.boolean' => 'A4.1 must be Yes or No.',
            'a4_2.boolean' => 'A4.2 must be Yes or No.',
            'a4_3.boolean' => 'A4.3 must be Yes or No.',
            'a4_4.boolean' => 'A4.4 must be Yes or No.',
            'a4_5.boolean' => 'A4.5 must be Yes or No.',
            'next_date.date' => 'Next date must be a valid date.',
        ];
    }

    public function mount($id)
    {
        $this->worksurface = Worksurface::with('creator')->findOrFail($id);

        if (!auth()->user()->can('view worksurface')) {
            abort(403, 'Unauthorized access.');
        }

        $this->loadWorksurfaces();
    }

    public function loadWorksurfaces()
    {
        $this->worksurfaces = Worksurface::orderBy('register_no')->get();
    }

    public function updatedA1()
    {
        $this->resetJudgements();
    }

    public function updatedA2()
    {
        $this->resetJudgements();
    }

    public function updatedA3()
    {
        $this->resetJudgements();
    }

    public function resetJudgements()
    {
        // A1 Judgement: < 1,000,000,000 is OK
        if ($this->a1 !== null && $this->a1 !== '') {
            $this->judgement_a1 = floatval($this->a1) < 1000000000 ? 'OK' : 'NG';
            $this->a1_scientific = sprintf('%.2E', floatval($this->a1));
        }

        // A2 Judgement: < 100 is OK
        if ($this->a2 !== null && $this->a2 !== '') {
            $this->judgement_a2 = floatval($this->a2) < 100 ? 'OK' : 'NG';
        }

        // A3 Judgement: < 100 is OK (Clear Acrylic Static Field Voltage)
        if ($this->a3 !== null && $this->a3 !== '') {
            $this->judgement_a3 = floatval($this->a3) < 100 ? 'OK' : 'NG';
        }
    }

    public function updatedWorksurfaceId($value)
    {
        if ($value) {
            $worksurface = Worksurface::find($value);
            if ($worksurface) {
                $this->register_no = $worksurface->register_no;
                $this->area = $worksurface->area;
                $this->location = $worksurface->location;
                $this->layer_count = $worksurface->layer_count;
                $this->category = $worksurface->category;
            }
        } else {
            $this->register_no = null;
            $this->area = null;
            $this->location = null;
            $this->layer_count = null;
            $this->category = null;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'detail_id', 'worksurface_id', 'register_no', 'area', 'location', 'layer_count', 'category',
            'item', 'a1', 'a1_scientific', 'judgement_a1', 'a2', 'judgement_a2',
            'a3', 'judgement_a3', 'a4_1', 'a4_2', 'a4_3', 'a4_4', 'a4_5',
            'remarks', 'next_date'
        ]);
        // ✅ Reset item dropdown
        $this->itemSearch = '';
        $this->showItemDropdown = false;
        $this->modalTitle = 'Add New Measurement';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset(['filterDateFrom', 'filterDateUntil', 'filterNextDateFrom', 'filterNextDateUntil', 'search']);
        $this->resetPage();
    }

    public function selectItem($value)
    {
        $this->item = strtoupper($value);
        $this->itemSearch = strtoupper($value);
        $this->showItemDropdown = false;
    }

    public function clearItem()
    {
        $this->item = null;
        $this->itemSearch = '';
        $this->showItemDropdown = false;
    }

    public function getItemOptionsProperty()
    {
        $options = [];

        foreach (['TABLE', 'RACK', 'TROLLEY'] as $type) {
            for ($i = 1; $i <= 5; $i++) {
                $options[] = "{$type} LAYER {$i}";
            }
        }

        return $options;
    }

    public function getFilteredItemOptionsProperty()
    {
        $all = $this->itemOptions;

        if (empty($this->itemSearch)) {
            return $all;
        }

        $term = strtolower($this->itemSearch);

        return array_values(array_filter($all, function ($opt) use ($term) {
            return str_contains(strtolower($opt), $term);
        }));
    }

    public function save()
    {
        if ($this->detail_id) {
            if (!auth()->user()->can('edit worksurface details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create worksurface details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        // Set worksurface_id from the current worksurface
        $this->worksurface_id = $this->worksurface->id;

        $this->validate();

        $this->resetJudgements();

        $data = [
            'worksurface_id' => $this->worksurface_id,
            'item' => strtoupper($this->item),
            'a1' => $this->a1,
            'a1_scientific' => $this->a1_scientific,
            'judgement_a1' => $this->judgement_a1,
            'a2' => $this->a2,
            'judgement_a2' => $this->judgement_a2,
            'a3' => $this->a3,
            'judgement_a3' => $this->judgement_a3,
            'a4_1' => $this->a4_1,
            'a4_2' => $this->a4_2,
            'a4_3' => $this->a4_3,
            'a4_4' => $this->a4_4,
            'a4_5' => $this->a4_5,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
        ];

        if ($this->detail_id) {
            $detail = WorksurfaceDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
                return;
            }

            $detail->update($data);
            $message = 'Measurement updated successfully!';
        } else {
            WorksurfaceDetail::create($data);
            $message = 'Measurement created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'detail-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit worksurface details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = WorksurfaceDetail::with('worksurface')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            return;
        }

        $this->detail_id = $detail->id;
        $this->worksurface_id = $detail->worksurface_id;
        $this->register_no = $detail->worksurface->register_no ?? '';
        $this->area = $detail->worksurface->area ?? '';
        $this->location = $detail->worksurface->location ?? '';
        $this->layer_count = $detail->worksurface->layer_count ?? '';
        $this->category = $detail->worksurface->category ?? '';
        $this->item = $detail->item;
        $this->itemSearch = $detail->item;
        $this->a1 = $detail->a1;
        $this->a1_scientific = $detail->a1_scientific;
        $this->judgement_a1 = $detail->judgement_a1;
        $this->a2 = $detail->a2;
        $this->judgement_a2 = $detail->judgement_a2;
        $this->a3 = $detail->a3;
        $this->judgement_a3 = $detail->judgement_a3;
        $this->a4_1 = $detail->a4_1;
        $this->a4_2 = $detail->a4_2;
        $this->a4_3 = $detail->a4_3;
        $this->a4_4 = $detail->a4_4;
        $this->a4_5 = $detail->a4_5;
        $this->remarks = $detail->remarks;
        $this->next_date = $detail->next_date ? Carbon::parse($detail->next_date)->format('Y-m-d') : null;
        $this->modalTitle = 'Edit Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete worksurface details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = WorksurfaceDetail::with('worksurface')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $detail;
        $this->dispatch('open-modal', 'delete-detail-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete worksurface details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = WorksurfaceDetail::find($this->detailToDelete->id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $registerNo = $detail->worksurface->register_no ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Measurement for '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function render()
    {
        $details = WorksurfaceDetail::with(['worksurface', 'creator'])
            ->where('worksurface_id', $this->worksurface->id)
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

        return view('livewire.esd.worksurface.worksurface-show', [
            'details' => $details,
        ]);
    }
}