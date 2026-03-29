<?php

namespace App\Livewire\ESD\EG;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\EG\EquipmentGround;

class EquipmentGroundManagement extends Component
{
    use WithPagination;

    public $equipment_ground_id;
    public $machine_name;
    public $area;
    public $location;
    public $status = 'In Use';

    public $search = '';
    public $modalTitle = 'Add New Equipment Ground';
    public $equipmentGroundToDelete = null;

    protected function rules()
    {
        return [
            'machine_name' => 'required|min:3',
            'area' => 'required|min:2',
            'location' => 'required|min:2',
            'status' => 'required|in:In Use,Not In Use,Under Repair,Damage,Disposed',
        ];
    }

    protected $messages = [
        'machine_name.required' => 'Machine name is required.',
        'machine_name.min' => 'Machine name must be at least 3 characters.',
        'area.required' => 'Area is required.',
        'area.min' => 'Area must be at least 2 characters.',
        'location.required' => 'Location is required.',
        'location.min' => 'Location must be at least 2 characters.',
        'status.required' => 'Status is required.',
        'status.in' => 'Status must be one of: In Use, Not In Use, Under Repair, Damage, Disposed.',
    ];

    public function resetForm()
    {
        $this->reset(['equipment_ground_id', 'machine_name', 'area', 'location', 'status']);
        $this->status = 'In Use';
        $this->modalTitle = 'Add New Equipment Ground';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->equipment_ground_id) {
            if (!auth()->user()->can('edit equipment grounds')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create equipment grounds')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'machine_name' => $this->machine_name,
            'area' => $this->area,
            'location' => $this->location,
            'status' => $this->status,
        ];

        if ($this->equipment_ground_id) {
            $equipmentGround = EquipmentGround::find($this->equipment_ground_id);
            if (!$equipmentGround) {
                $this->dispatch('notify', message: 'Equipment Ground not found!', type: 'error');
                return;
            }

            $equipmentGround->update($data);
            $message = 'Equipment Ground updated successfully!';
        } else {
            EquipmentGround::create($data);
            $message = 'Equipment Ground created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'equipment-ground-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit equipment grounds')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $equipmentGround = EquipmentGround::find($id);

        if (!$equipmentGround) {
            $this->dispatch('notify', message: 'Equipment Ground not found!', type: 'error');
            return;
        }

        $this->equipment_ground_id = $equipmentGround->id;
        $this->machine_name = $equipmentGround->machine_name;
        $this->area = $equipmentGround->area;
        $this->location = $equipmentGround->location;
        $this->status = $equipmentGround->status;
        $this->modalTitle = 'Edit Equipment Ground';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete equipment grounds')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $equipmentGround = EquipmentGround::find($id);

        if (!$equipmentGround) {
            $this->dispatch('notify', message: 'Equipment Ground not found!', type: 'error');
            return;
        }

        $this->equipmentGroundToDelete = $equipmentGround;
        $this->dispatch('open-modal', 'delete-equipment-ground-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete equipment grounds')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $equipmentGround = EquipmentGround::find($this->equipmentGroundToDelete->id);

        if (!$equipmentGround) {
            $this->dispatch('notify', message: 'Equipment Ground not found!', type: 'error');
            $this->equipmentGroundToDelete = null;
            return;
        }

        $machineName = $equipmentGround->machine_name;
        $equipmentGround->delete();

        $this->equipmentGroundToDelete = null;
        $this->dispatch('notify', message: "Equipment Ground '{$machineName}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-equipment-ground-modal');
    }

    public function cancelDelete()
    {
        $this->equipmentGroundToDelete = null;
        $this->dispatch('close-modal', 'delete-equipment-ground-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view equipment grounds')) {
            abort(403, 'Unauthorized access.');
        }

        $equipmentGrounds = EquipmentGround::with('creator')
            ->when($this->search, function ($query) {
                $query->where('machine_name', 'like', '%' . $this->search . '%')
                    ->orWhere('area', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.esd.eg.equipment-ground-management', [
            'equipmentGrounds' => $equipmentGrounds,
        ]);
    }
}