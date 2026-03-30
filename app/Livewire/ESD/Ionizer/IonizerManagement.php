<?php

namespace App\Livewire\ESD\Ionizer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Ionizer\Ionizer;

class IonizerManagement extends Component
{
    use WithPagination;

    public $ionizer_id;
    public $register_no;
    public $area;
    public $location;
    public $gap;
    public $status = 'In Use';

    public $search = '';
    public $modalTitle = 'Add New Ionizer';
    public $ionizerToDelete = null;

    protected function rules()
    {
        return [
            'register_no' => 'required|min:3|unique:tb_esd_ionizers,register_no,' . ($this->ionizer_id ?? 'NULL'),
            'area' => 'required|min:2',
            'location' => 'required|min:2',
            'gap' => 'nullable|string',
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
        $this->reset(['ionizer_id', 'register_no', 'area', 'location', 'gap', 'status']);
        $this->status = 'In Use';
        $this->modalTitle = 'Add New Ionizer';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->ionizer_id) {
            if (!auth()->user()->can('edit ionizer')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create ionizer')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'register_no' => $this->register_no,
            'area' => $this->area,
            'location' => $this->location,
            'gap' => $this->gap,
            'status' => $this->status,
        ];

        if ($this->ionizer_id) {
            $ionizer = Ionizer::find($this->ionizer_id);
            if (!$ionizer) {
                $this->dispatch('notify', message: 'Ionizer not found!', type: 'error');
                return;
            }

            $ionizer->update($data);
            $message = 'Ionizer updated successfully!';
        } else {
            Ionizer::create($data);
            $message = 'Ionizer created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'ionizer-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit ionizer')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $ionizer = Ionizer::find($id);

        if (!$ionizer) {
            $this->dispatch('notify', message: 'Ionizer not found!', type: 'error');
            return;
        }

        $this->ionizer_id = $ionizer->id;
        $this->register_no = $ionizer->register_no;
        $this->area = $ionizer->area;
        $this->location = $ionizer->location;
        $this->gap = $ionizer->gap;
        $this->status = $ionizer->status;
        $this->modalTitle = 'Edit Ionizer';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete ionizer')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $ionizer = Ionizer::find($id);

        if (!$ionizer) {
            $this->dispatch('notify', message: 'Ionizer not found!', type: 'error');
            return;
        }

        $this->ionizerToDelete = $ionizer;
        $this->dispatch('open-modal', 'delete-ionizer-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete ionizer')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $ionizer = Ionizer::find($this->ionizerToDelete->id);

        if (!$ionizer) {
            $this->dispatch('notify', message: 'Ionizer not found!', type: 'error');
            $this->ionizerToDelete = null;
            return;
        }

        $registerNo = $ionizer->register_no;
        $ionizer->delete();

        $this->ionizerToDelete = null;
        $this->dispatch('notify', message: "Ionizer '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-ionizer-modal');
    }

    public function cancelDelete()
    {
        $this->ionizerToDelete = null;
        $this->dispatch('close-modal', 'delete-ionizer-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view ionizer')) {
            abort(403, 'Unauthorized access.');
        }

        $ionizers = Ionizer::with('creator')
            ->when($this->search, function ($query) {
                $query->where('register_no', 'like', '%' . $this->search . '%')
                    ->orWhere('area', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.esd.ionizer.ionizer-management', [
            'ionizers' => $ionizers,
        ]);
    }
}