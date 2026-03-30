<?php

namespace App\Livewire\ESD\GB;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\GB\GroundMonitorBox;

class GroundMonitorBoxManagement extends Component
{
    use WithPagination;

    public $ground_monitor_box_id;
    public $register_no;
    public $area;
    public $location;
    public $status = 'In Use';

    public $search = '';
    public $modalTitle = 'Add New Ground Monitor Box';
    public $groundMonitorBoxToDelete = null;

    protected function rules()
    {
        return [
            'register_no' => 'required|min:3|unique:tb_esd_ground_monitor_boxs,register_no,' . ($this->ground_monitor_box_id ?? 'NULL'),
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
        $this->reset(['ground_monitor_box_id', 'register_no', 'area', 'location', 'status']);
        $this->status = 'In Use';
        $this->modalTitle = 'Add New Ground Monitor Box';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->ground_monitor_box_id) {
            if (!auth()->user()->can('edit ground monitor box')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create ground monitor box')) {
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

        if ($this->ground_monitor_box_id) {
            $groundMonitorBox = GroundMonitorBox::find($this->ground_monitor_box_id);
            if (!$groundMonitorBox) {
                $this->dispatch('notify', message: 'Ground Monitor Box not found!', type: 'error');
                return;
            }

            $groundMonitorBox->update($data);
            $message = 'Ground Monitor Box updated successfully!';
        } else {
            GroundMonitorBox::create($data);
            $message = 'Ground Monitor Box created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'ground-monitor-box-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit ground monitor box')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $groundMonitorBox = GroundMonitorBox::find($id);

        if (!$groundMonitorBox) {
            $this->dispatch('notify', message: 'Ground Monitor Box not found!', type: 'error');
            return;
        }

        $this->ground_monitor_box_id = $groundMonitorBox->id;
        $this->register_no = $groundMonitorBox->register_no;
        $this->area = $groundMonitorBox->area;
        $this->location = $groundMonitorBox->location;
        $this->status = $groundMonitorBox->status;
        $this->modalTitle = 'Edit Ground Monitor Box';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete ground monitor box')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $groundMonitorBox = GroundMonitorBox::find($id);

        if (!$groundMonitorBox) {
            $this->dispatch('notify', message: 'Ground Monitor Box not found!', type: 'error');
            return;
        }

        $this->groundMonitorBoxToDelete = $groundMonitorBox;
        $this->dispatch('open-modal', 'delete-ground-monitor-box-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete ground monitor box')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $groundMonitorBox = GroundMonitorBox::find($this->groundMonitorBoxToDelete->id);

        if (!$groundMonitorBox) {
            $this->dispatch('notify', message: 'Ground Monitor Box not found!', type: 'error');
            $this->groundMonitorBoxToDelete = null;
            return;
        }

        $registerNo = $groundMonitorBox->register_no;
        $groundMonitorBox->delete();

        $this->groundMonitorBoxToDelete = null;
        $this->dispatch('notify', message: "Ground Monitor Box '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-ground-monitor-box-modal');
    }

    public function cancelDelete()
    {
        $this->groundMonitorBoxToDelete = null;
        $this->dispatch('close-modal', 'delete-ground-monitor-box-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view ground monitor box')) {
            abort(403, 'Unauthorized access.');
        }

        $groundMonitorBoxes = GroundMonitorBox::with('creator')
            ->when($this->search, function ($query) {
                $query->where('register_no', 'like', '%' . $this->search . '%')
                    ->orWhere('area', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.esd.gb.ground-monitor-box-management', [
            'groundMonitorBoxes' => $groundMonitorBoxes,
        ]);
    }
}