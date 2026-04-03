<?php

namespace App\Livewire\ESD\Shower;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Shower\Shower;

class ShowerManagement extends Component
{
    use WithPagination;

    public $shower_id;
    public $register_no;
    public $area;
    public $location;

    public $search = '';
    public $modalTitle = 'Add New Shower';
    public $showerToDelete = null;

    protected function rules()
    {
        return [
            'register_no' => 'required|min:3|unique:tb_esd_showers,register_no,' . ($this->shower_id ?? 'NULL'),
            'area' => 'required|min:2',
            'location' => 'required|min:2',
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
    ];

    public function resetForm()
    {
        $this->reset(['shower_id', 'register_no', 'area', 'location']);
        $this->modalTitle = 'Add New Shower';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->shower_id) {
            if (!auth()->user()->can('edit shower')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create shower')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'register_no' => $this->register_no,
            'area' => $this->area,
            'location' => $this->location,
        ];

        if ($this->shower_id) {
            $shower = Shower::find($this->shower_id);
            if (!$shower) {
                $this->dispatch('notify', message: 'Shower not found!', type: 'error');
                return;
            }

            $shower->update($data);
            $message = 'Shower updated successfully!';
        } else {
            Shower::create($data);
            $message = 'Shower created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'shower-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit shower')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $shower = Shower::find($id);

        if (!$shower) {
            $this->dispatch('notify', message: 'Shower not found!', type: 'error');
            return;
        }

        $this->shower_id = $shower->id;
        $this->register_no = $shower->register_no;
        $this->area = $shower->area;
        $this->location = $shower->location;
        $this->modalTitle = 'Edit Shower';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete shower')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $shower = Shower::find($id);

        if (!$shower) {
            $this->dispatch('notify', message: 'Shower not found!', type: 'error');
            return;
        }

        $this->showerToDelete = $shower;
        $this->dispatch('open-modal', 'delete-shower-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete shower')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $shower = Shower::find($this->showerToDelete->id);

        if (!$shower) {
            $this->dispatch('notify', message: 'Shower not found!', type: 'error');
            $this->showerToDelete = null;
            return;
        }

        $registerNo = $shower->register_no;
        
        // Delete related shower details first
        $shower->showerDetails()->delete();
        $shower->delete();

        $this->showerToDelete = null;
        $this->dispatch('notify', message: "Shower '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-shower-modal');
    }

    public function cancelDelete()
    {
        $this->showerToDelete = null;
        $this->dispatch('close-modal', 'delete-shower-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view shower')) {
            abort(403, 'Unauthorized access.');
        }

        $showers = Shower::with('creator', 'showerDetails')
            ->when($this->search, function ($query) {
                $query->where('register_no', 'like', '%' . $this->search . '%')
                    ->orWhere('area', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.esd.shower.shower-management', [
            'showers' => $showers,
        ]);
    }
}