<?php

namespace App\Livewire\ESD\Scissors;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Scissors\Scissors;

class ScissorsManagement extends Component
{
    use WithPagination;

    public $scissors_id;
    public $register_no;
    public $area;
    public $location;
    public $status = 'In Use';

    public $search = '';
    public $modalTitle = 'Add New Scissors';
    public $scissorsToDelete = null;

    protected function rules()
    {
        return [
            'register_no' => 'required|min:3|max:100|unique:tb_esd_scissors,register_no,' . ($this->scissors_id ?? 'NULL'),
            'area' => 'required|in:PRODUCTION 01,PRODUCTION 02,WH MATERIAL,WH FINISH GOOD',
            'location' => 'required|min:2|max:100',
            'status' => 'required|in:In Use,Not In Use,Under Repair,Damage,Disposed',
        ];
    }

    protected $messages = [
        'register_no.required' => 'Register number is required.',
        'register_no.min' => 'Register number must be at least 3 characters.',
        'register_no.unique' => 'Register number already exists.',
        'area.required' => 'Area is required.',
        'area.in' => 'Area must be one of: PRODUCTION 01, PRODUCTION 02, WH MATERIAL, WH FINISH GOOD.',
        'location.required' => 'Location is required.',
        'location.min' => 'Location must be at least 2 characters.',
        'status.required' => 'Status is required.',
        'status.in' => 'Status must be one of: In Use, Not In Use, Under Repair, Damage, Disposed.',
    ];

    public function resetForm()
    {
        $this->reset(['scissors_id', 'register_no', 'area', 'location', 'status']);
        $this->status = 'In Use';
        $this->modalTitle = 'Add New Scissors';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->scissors_id) {
            if (!auth()->user()->can('edit scissors')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create scissors')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'register_no' => $this->register_no,
            'area' => $this->area,
            'location' => $this->location,
            'status' => $this->status,
        ];

        if ($this->scissors_id) {
            $scissors = Scissors::find($this->scissors_id);
            if (!$scissors) {
                $this->dispatch('notify', message: 'Scissors not found!', type: 'error');
                return;
            }

            $scissors->update($data);
            $message = 'Scissors updated successfully!';
        } else {
            Scissors::create($data);
            $message = 'Scissors created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'scissors-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit scissors')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $scissors = Scissors::find($id);

        if (!$scissors) {
            $this->dispatch('notify', message: 'Scissors not found!', type: 'error');
            return;
        }

        $this->scissors_id = $scissors->id;
        $this->register_no = $scissors->register_no;
        $this->area = $scissors->area;
        $this->location = $scissors->location;
        $this->status = $scissors->status;
        $this->modalTitle = 'Edit Scissors';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete scissors')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $scissors = Scissors::find($id);

        if (!$scissors) {
            $this->dispatch('notify', message: 'Scissors not found!', type: 'error');
            return;
        }

        $this->scissorsToDelete = $scissors;
        $this->dispatch('open-modal', 'delete-scissors-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete scissors')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $scissors = Scissors::find($this->scissorsToDelete->id);

        if (!$scissors) {
            $this->dispatch('notify', message: 'Scissors not found!', type: 'error');
            $this->scissorsToDelete = null;
            return;
        }

        $registerNo = $scissors->register_no;
        $scissors->delete();

        $this->scissorsToDelete = null;
        $this->dispatch('notify', message: "Scissors '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-scissors-modal');
    }

    public function cancelDelete()
    {
        $this->scissorsToDelete = null;
        $this->dispatch('close-modal', 'delete-scissors-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view scissors')) {
            abort(403, 'Unauthorized access.');
        }

        $scissors = Scissors::with('creator')
            ->when($this->search, function ($query) {
                $query->where('register_no', 'like', '%' . $this->search . '%')
                    ->orWhere('area', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('livewire.esd.scissors.scissors-management', [
            'scissors' => $scissors,
        ]);
    }
}