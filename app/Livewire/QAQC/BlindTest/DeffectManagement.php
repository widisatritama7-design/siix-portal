<?php

namespace App\Livewire\QAQC\BlindTest;

use App\Models\QAQC\BlindTest\Deffect;
use Livewire\Component;
use Livewire\WithPagination;

class DeffectManagement extends Component
{
    use WithPagination;

    public $deffect_id;
    public $deffect_item_name = '';
    public $search = '';
    public $modalTitle = 'Add New Deffect Item';
    public $deffectToDelete = null;

    // View
    public $viewData = null;

    // Tab
    public $activeTab = 'all';

    protected function rules()
    {
        return [
            'deffect_item_name' => 'required|string|max:255|unique:tb_qaqc_deffect,deffect_item_name,' . ($this->deffect_id ?? 'NULL') . ',id',
        ];
    }

    protected $messages = [
        'deffect_item_name.required' => 'Deffect item name is required.',
        'deffect_item_name.unique' => 'Deffect item name already exists.',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->reset(['deffect_id', 'deffect_item_name']);
        $this->modalTitle = 'Add New Deffect Item';
        $this->resetValidation();
    }

    public function save()
    {
        if ($this->deffect_id) {
            if (!auth()->user()->can('edit deffect')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create deffect')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        if ($this->deffect_id) {
            $deffect = Deffect::find($this->deffect_id);
            if (!$deffect) {
                $this->dispatch('notify', message: 'Deffect item not found!', type: 'error');
                return;
            }

            $deffect->update([
                'deffect_item_name' => strtoupper($this->deffect_item_name),
                'updated_by' => auth()->id(),
            ]);

            $message = 'Deffect item updated successfully!';
        } else {
            Deffect::create([
                'deffect_item_name' => strtoupper($this->deffect_item_name),
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            $message = 'Deffect item created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal-deffect');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit deffect')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $deffect = Deffect::find($id);
        if (!$deffect) {
            $this->dispatch('notify', message: 'Deffect item not found!', type: 'error');
            return;
        }

        $this->deffect_id = $deffect->id;
        $this->deffect_item_name = $deffect->deffect_item_name;
        $this->modalTitle = 'Edit Deffect Item';
        $this->dispatch('open-modal-deffect');
    }

    public function view($id)
    {
        $deffect = Deffect::with(['creator', 'updater'])->find($id);
        if (!$deffect) {
            $this->dispatch('notify', message: 'Deffect item not found!', type: 'error');
            return;
        }

        $this->viewData = $deffect;
        $this->dispatch('open-modal-view');
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete deffect')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $deffect = Deffect::find($id);
        if (!$deffect) {
            $this->dispatch('notify', message: 'Deffect item not found!', type: 'error');
            return;
        }

        $this->deffectToDelete = $deffect;
        $this->dispatch('open-modal-delete');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete deffect')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $deffect = Deffect::find($this->deffectToDelete->id);
        if (!$deffect) {
            $this->dispatch('notify', message: 'Deffect item not found!', type: 'error');
            $this->deffectToDelete = null;
            return;
        }

        $name = $deffect->deffect_item_name;
        $deffect->delete();

        $this->deffectToDelete = null;
        $this->dispatch('notify', message: "Deffect item '{$name}' has been deleted successfully!");
        $this->dispatch('close-modal-delete');
    }

    public function cancelDelete()
    {
        $this->deffectToDelete = null;
        $this->dispatch('close-modal-delete');
    }

    public function render()
    {
        if (!auth()->user()->can('view deffect')) {
            abort(403, 'Unauthorized access.');
        }

        $query = Deffect::with(['creator', 'updater']);

        if ($this->search) {
            $query->where('deffect_item_name', 'like', '%' . $this->search . '%');
        }

        $deffects = $query->orderByDesc('id')->paginate(10);

        return view('livewire.qaqc.blind-test.deffect-management', [
            'deffects' => $deffects,
        ]);
    }
}