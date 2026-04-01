<?php

namespace App\Livewire\ESD\Insulatif;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Insulatif\InsulatifCheck;
use Carbon\Carbon;

class InsulatifCheckManagement extends Component
{
    use WithPagination;

    public $check_id;
    public $register_no;
    public $result;
    public $result_scientific;
    public $judgement;
    public $remarks;

    public $search = '';
    public $filterJudgement = '';
    public $filterDateFrom = '';
    public $filterDateUntil = '';

    public $modalTitle = 'Add New Insulatif Check';
    public $checkToDelete = null;

    protected function rules()
    {
        return [
            'register_no' => 'required|min:3|max:100',
            'result' => 'required|numeric|min:0|max:9999999999999',
            'remarks' => 'nullable|string|max:500',
        ];
    }

    protected $messages = [
        'register_no.required' => 'Register number is required.',
        'register_no.min' => 'Register number must be at least 3 characters.',
        'result.required' => 'Result measurement is required.',
        'result.numeric' => 'Result measurement must be a number.',
        'result.min' => 'Result measurement must be at least 0.',
        'result.max' => 'Result measurement must be less than 10,000,000,000,000.',
    ];

    public function mount()
    {
        $this->resetJudgement();
    }

    public function resetJudgement()
    {
        // Result Judgement: < 1,000,000,000,000 = NG, ≥ 1,000,000,000,000 = OK
        if ($this->result !== null && $this->result !== '') {
            $this->judgement = floatval($this->result) >= 1000000000000 ? 'OK' : 'NG';
            $this->result_scientific = sprintf('%.2E', floatval($this->result));
        }
    }

    public function updatedResult()
    {
        $this->resetJudgement();
    }

    public function resetForm()
    {
        $this->reset(['check_id', 'register_no', 'result', 'result_scientific', 'judgement', 'remarks']);
        $this->modalTitle = 'Add New Insulatif Check';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterJudgement', 'filterDateFrom', 'filterDateUntil']);
        $this->resetPage();
    }

    public function updatedSearch()
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

    public function save()
    {
        if ($this->check_id) {
            if (!auth()->user()->can('edit insulatif check')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create insulatif check')) {
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
        ];

        if ($this->check_id) {
            $check = InsulatifCheck::find($this->check_id);
            if (!$check) {
                $this->dispatch('notify', message: 'Insulatif check not found!', type: 'error');
                return;
            }

            $check->update($data);
            $message = 'Insulatif check updated successfully!';
        } else {
            InsulatifCheck::create($data);
            $message = 'Insulatif check created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'insulatif-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit insulatif check')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $check = InsulatifCheck::find($id);

        if (!$check) {
            $this->dispatch('notify', message: 'Insulatif check not found!', type: 'error');
            return;
        }

        $this->check_id = $check->id;
        $this->register_no = $check->register_no;
        $this->result = $check->result;
        $this->result_scientific = $check->result_scientific;
        $this->judgement = $check->judgement;
        $this->remarks = $check->remarks;
        $this->modalTitle = 'Edit Insulatif Check';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete insulatif check')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $check = InsulatifCheck::find($id);

        if (!$check) {
            $this->dispatch('notify', message: 'Insulatif check not found!', type: 'error');
            return;
        }

        $this->checkToDelete = $check;
        $this->dispatch('open-modal', 'delete-insulatif-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete insulatif check')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $check = InsulatifCheck::find($this->checkToDelete->id);

        if (!$check) {
            $this->dispatch('notify', message: 'Insulatif check not found!', type: 'error');
            $this->checkToDelete = null;
            return;
        }

        $registerNo = $check->register_no;
        $check->delete();

        $this->checkToDelete = null;
        $this->dispatch('notify', message: "Insulatif check '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-insulatif-modal');
    }

    public function cancelDelete()
    {
        $this->checkToDelete = null;
        $this->dispatch('close-modal', 'delete-insulatif-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view insulatif check')) {
            abort(403, 'Unauthorized access.');
        }

        $checks = InsulatifCheck::with('creator')
            ->when($this->search, function ($query) {
                $query->where('register_no', 'like', '%' . $this->search . '%');
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
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.esd.insulatif.insulatif-check-management', [
            'checks' => $checks,
        ]);
    }
}