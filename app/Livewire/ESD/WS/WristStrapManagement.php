<?php

namespace App\Livewire\ESD\WS;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\WS\WristStrap;
use Carbon\Carbon;

class WristStrapManagement extends Component
{
    use WithPagination;

    public $strap_id;
    public $register_no;
    public $result;
    public $result_scientific;
    public $judgement;
    public $remarks;
    public $type;
    public $next_date;

    public $search = '';
    public $filterType = '';
    public $filterJudgement = '';
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    public $filterNextDateFrom = '';
    public $filterNextDateUntil = '';

    public $modalTitle = 'Add New Wrist Strap';
    public $strapToDelete = null;

    protected function rules()
    {
        return [
            'register_no' => 'required|min:3|max:100', // Hapus unique
            'result' => 'nullable|numeric', // Diubah jadi nullable, hapus min/max
            'type' => 'nullable|string|max:50',
            'remarks' => 'nullable|string|max:500',
            'next_date' => 'nullable|date',
        ];
    }

    protected $messages = [
        'register_no.required' => 'Register number is required.',
        'register_no.min' => 'Register number must be at least 3 characters.',
        'result.numeric' => 'Result measurement must be a number.',
        'next_date.date' => 'Next date must be a valid date.',
    ];

    public function mount()
    {
        $this->resetJudgement();
    }

    public function resetJudgement()
    {
        // Result Judgement: < 35,000,000 = OK, ≥ 35,000,000 = NG
        if ($this->result !== null && $this->result !== '') {
            $this->judgement = floatval($this->result) < 35000000 ? 'OK' : 'NG';
            $this->result_scientific = sprintf('%.2E', floatval($this->result));
        }
    }

    public function updatedResult()
    {
        $this->resetJudgement();
    }

    public function resetForm()
    {
        $this->reset(['strap_id', 'register_no', 'result', 'result_scientific', 'judgement', 'remarks', 'type', 'next_date']);
        $this->modalTitle = 'Add New Wrist Strap';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterType', 'filterJudgement', 'filterDateFrom', 'filterDateUntil', 'filterNextDateFrom', 'filterNextDateUntil']);
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterType()
    {
        $this->resetPage();
    }

    public function updatedFilterJudgement()
    {
        $this->resetPage();
    }

    public function updatedFilterDateFrom()
    {
        $this->resetPage();
    }

    public function updatedFilterDateUntil()
    {
        $this->resetPage();
    }

    public function updatedFilterNextDateFrom()
    {
        $this->resetPage();
    }

    public function updatedFilterNextDateUntil()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->strap_id) {
            if (!auth()->user()->can('edit wrist strap')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create wrist strap')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $this->resetJudgement();

        $data = [
            'register_no' => $this->register_no,
            'result' => $this->result,
            'result_scientific' => $this->result_scientific,
            'judgement' => $this->judgement,
            'remarks' => $this->remarks,
            'type' => $this->type,
            'next_date' => $this->next_date,
        ];

        if ($this->strap_id) {
            $strap = WristStrap::find($this->strap_id);
            if (!$strap) {
                $this->dispatch('notify', message: 'Wrist strap not found!', type: 'error');
                return;
            }

            $strap->update($data);
            $message = 'Wrist strap updated successfully!';
        } else {
            WristStrap::create($data);
            $message = 'Wrist strap created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'wrist-strap-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit wrist strap')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $strap = WristStrap::find($id);

        if (!$strap) {
            $this->dispatch('notify', message: 'Wrist strap not found!', type: 'error');
            return;
        }

        $this->strap_id = $strap->id;
        $this->register_no = $strap->register_no;
        $this->result = $strap->result;
        $this->result_scientific = $strap->result_scientific;
        $this->judgement = $strap->judgement;
        $this->remarks = $strap->remarks;
        $this->type = $strap->type;
        $this->next_date = $strap->next_date ? Carbon::parse($strap->next_date)->format('Y-m-d') : null;
        $this->modalTitle = 'Edit Wrist Strap';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete wrist strap')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $strap = WristStrap::find($id);

        if (!$strap) {
            $this->dispatch('notify', message: 'Wrist strap not found!', type: 'error');
            return;
        }

        $this->strapToDelete = $strap;
        $this->dispatch('open-modal', 'delete-wrist-strap-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete wrist strap')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $strap = WristStrap::find($this->strapToDelete->id);

        if (!$strap) {
            $this->dispatch('notify', message: 'Wrist strap not found!', type: 'error');
            $this->strapToDelete = null;
            return;
        }

        $registerNo = $strap->register_no;
        $strap->delete();

        $this->strapToDelete = null;
        $this->dispatch('notify', message: "Wrist strap '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-wrist-strap-modal');
    }

    public function cancelDelete()
    {
        $this->strapToDelete = null;
        $this->dispatch('close-modal', 'delete-wrist-strap-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view wrist strap')) {
            abort(403, 'Unauthorized access.');
        }

        $types = WristStrap::select('type')->distinct()->orderBy('type')->pluck('type');

        $straps = WristStrap::with('creator')
            ->when($this->search, function ($query) {
                $query->where('register_no', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterType, function ($query) {
                $query->where('type', $this->filterType);
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

        return view('livewire.esd.ws.wrist-strap-management', [
            'straps' => $straps,
            'types' => $types,
        ]);
    }
}