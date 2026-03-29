<?php

namespace App\Livewire\ESD\Flooring;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Flooring\Flooring;

class FlooringManagement extends Component
{
    use WithPagination;

    public $flooring_id;
    public $register_no;
    public $area;
    public $location;
    public $status = 'In Use';

    public $search = '';
    public $modalTitle = 'Add New Flooring';
    public $flooringToDelete = null;

    protected function rules()
    {
        return [
            'register_no' => 'required|min:3|unique:tb_esd_floorings,register_no,' . ($this->flooring_id ?? 'NULL'),
            'area' => 'required|min:2',
            'location' => 'required|min:2',
            'status' => 'required|in:In Use,Not In Use,Under Repair,Damage,Disposed',
        ];
    }

    protected $messages = [
        'register_no.required' => 'Register number is required.',
        'register_no.min' => 'Register number must be at least 3 characters.',
        'register_no.unique' => 'Register number already exists.',
        'area.required' => 'Area is required.',
        'area.min' => 'Area must be at least 2 characters.',
        'location.required' => 'Location is required.',
        'location.min' => 'Location must be at least 2 characters.',
        'status.required' => 'Status is required.',
        'status.in' => 'Status must be one of: In Use, Not In Use, Under Repair, Damage, Disposed.',
    ];

    public function resetForm()
    {
        $this->reset(['flooring_id', 'register_no', 'area', 'location', 'status']);
        $this->status = 'In Use';
        $this->modalTitle = 'Add New Flooring';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->flooring_id) {
            if (!auth()->user()->can('edit flooring')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create flooring')) {
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

        if ($this->flooring_id) {
            $flooring = Flooring::find($this->flooring_id);
            if (!$flooring) {
                $this->dispatch('notify', message: 'Flooring not found!', type: 'error');
                return;
            }

            $flooring->update($data);
            $message = 'Flooring updated successfully!';
        } else {
            Flooring::create($data);
            $message = 'Flooring created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'flooring-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit flooring')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $flooring = Flooring::find($id);

        if (!$flooring) {
            $this->dispatch('notify', message: 'Flooring not found!', type: 'error');
            return;
        }

        $this->flooring_id = $flooring->id;
        $this->register_no = $flooring->register_no;
        $this->area = $flooring->area;
        $this->location = $flooring->location;
        $this->status = $flooring->status;
        $this->modalTitle = 'Edit Flooring';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete flooring')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $flooring = Flooring::find($id);

        if (!$flooring) {
            $this->dispatch('notify', message: 'Flooring not found!', type: 'error');
            return;
        }

        $this->flooringToDelete = $flooring;
        $this->dispatch('open-modal', 'delete-flooring-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete flooring')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $flooring = Flooring::find($this->flooringToDelete->id);

        if (!$flooring) {
            $this->dispatch('notify', message: 'Flooring not found!', type: 'error');
            $this->flooringToDelete = null;
            return;
        }

        $registerNo = $flooring->register_no;
        $flooring->delete();

        $this->flooringToDelete = null;
        $this->dispatch('notify', message: "Flooring '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-flooring-modal');
    }

    public function cancelDelete()
    {
        $this->flooringToDelete = null;
        $this->dispatch('close-modal', 'delete-flooring-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view flooring')) {
            abort(403, 'Unauthorized access.');
        }

        $floorings = Flooring::with('creator')
            ->when($this->search, function ($query) {
                $query->where('register_no', 'like', '%' . $this->search . '%')
                    ->orWhere('area', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.esd.flooring.flooring-management', [
            'floorings' => $floorings,
        ]);
    }
}