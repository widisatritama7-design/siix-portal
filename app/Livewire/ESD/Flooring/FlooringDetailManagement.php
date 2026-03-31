<?php

namespace App\Livewire\ESD\Flooring;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Flooring\Flooring;
use App\Models\ESD\Flooring\FlooringDetail;
use Carbon\Carbon;

class FlooringDetailManagement extends Component
{
    use WithPagination;

    public $detail_id;
    public $flooring_id;
    public $register_no;
    public $area;
    public $location;
    public $b1;
    public $b1_scientific;
    public $judgement;
    public $remarks;
    public $next_date;

    public $search = '';
    public $filterFlooring = '';
    public $filterArea = '';
    public $filterLocation = '';
    public $filterJudgement = '';
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    public $filterNextDateFrom = '';
    public $filterNextDateUntil = '';

    public $modalTitle = 'Add New Flooring Measurement';
    public $detailToDelete = null;

    protected function rules()
    {
        return [
            'flooring_id' => 'required|exists:tb_esd_floorings,id',
            'b1' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:500',
            'next_date' => 'nullable|date',
        ];
    }

    protected $messages = [
        'flooring_id.required' => 'Register number is required.',
        'flooring_id.exists' => 'Selected flooring does not exist.',
        'b1.required' => 'B1 measurement result is required.',
        'b1.numeric' => 'B1 measurement result must be a number.',
        'b1.min' => 'B1 measurement result must be at least 0.',
        'next_date.date' => 'Next date must be a valid date.',
    ];

    public function mount()
    {
        $this->resetJudgement();
    }

    public function resetJudgement()
    {
        if ($this->b1 !== null && $this->b1 !== '') {
            // Standard: < 1.00E+9 Ohm (1,000,000,000 Ohm)
            $this->judgement = floatval($this->b1) >= 1000000000 ? 'NG' : 'OK';
            // Convert to scientific notation with 2 decimal places
            $this->b1_scientific = sprintf('%.2E', floatval($this->b1));
        }
    }

    public function updatedB1()
    {
        $this->resetJudgement();
    }

    public function updatedFlooringId($value)
    {
        if ($value) {
            $flooring = Flooring::find($value);
            if ($flooring) {
                $this->area = $flooring->area;
                $this->location = $flooring->location;
                $this->register_no = $flooring->register_no;
            }
        } else {
            $this->area = null;
            $this->location = null;
            $this->register_no = null;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'detail_id', 'flooring_id', 'register_no', 'area', 'location',
            'b1', 'b1_scientific', 'judgement', 'remarks', 'next_date'
        ]);
        $this->modalTitle = 'Add New Flooring Measurement';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset([
            'search', 'filterFlooring', 'filterArea', 'filterLocation',
            'filterJudgement', 'filterDateFrom', 'filterDateUntil',
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
            if (!auth()->user()->can('edit flooring details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create flooring details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'flooring_id' => $this->flooring_id,
            'b1' => $this->b1,
            'b1_scientific' => $this->b1_scientific,
            'judgement' => $this->judgement,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
        ];

        if ($this->detail_id) {
            $detail = FlooringDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Flooring measurement not found!', type: 'error');
                return;
            }

            $detail->update($data);
            $message = 'Flooring measurement updated successfully!';
        } else {
            FlooringDetail::create($data);
            $message = 'Flooring measurement created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'detail-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit flooring details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = FlooringDetail::with('flooring')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Flooring measurement not found!', type: 'error');
            return;
        }

        $this->detail_id = $detail->id;
        $this->flooring_id = $detail->flooring_id;
        $this->register_no = $detail->flooring->register_no ?? '';
        $this->area = $detail->flooring->area ?? '';
        $this->location = $detail->flooring->location ?? '';
        $this->b1 = $detail->b1;
        $this->b1_scientific = $detail->b1_scientific;
        $this->judgement = $detail->judgement;
        $this->remarks = $detail->remarks;
        $this->next_date = $detail->next_date;
        $this->modalTitle = 'Edit Flooring Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete flooring details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = FlooringDetail::with('flooring')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Flooring measurement not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $detail;
        $this->dispatch('open-modal', 'delete-detail-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete flooring details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = FlooringDetail::find($this->detailToDelete->id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Flooring measurement not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $registerNo = $this->detailToDelete->flooring->register_no ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Measurement for '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function cancelDelete()
    {
        $this->detailToDelete = null;
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view flooring details')) {
            abort(403, 'Unauthorized access.');
        }

        $floorings = Flooring::orderBy('register_no')->get();
        
        $details = FlooringDetail::with(['flooring', 'creator'])
            ->when($this->search, function ($query) {
                $query->whereHas('flooring', function ($q) {
                    $q->where('register_no', 'like', '%' . $this->search . '%')
                        ->orWhere('area', 'like', '%' . $this->search . '%')
                        ->orWhere('location', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterFlooring, function ($query) {
                $query->where('flooring_id', $this->filterFlooring);
            })
            ->when($this->filterArea, function ($query) {
                $query->whereHas('flooring', function ($q) {
                    $q->where('area', 'like', '%' . $this->filterArea . '%');
                });
            })
            ->when($this->filterLocation, function ($query) {
                $query->whereHas('flooring', function ($q) {
                    $q->where('location', 'like', '%' . $this->filterLocation . '%');
                });
            })
            ->when($this->filterJudgement, function ($query) {
                $query->where('judgement', $this->filterJudgement);
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

        return view('livewire.esd.flooring.flooring-detail-management', [
            'details' => $details,
            'floorings' => $floorings,
        ]);
    }
}