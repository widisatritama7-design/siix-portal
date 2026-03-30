<?php

namespace App\Livewire\ESD\Glove;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Glove\Glove;

class GloveManagement extends Component
{
    use WithPagination;

    public $glove_id;
    public $sap_code;
    public $description;
    public $delivery;
    public $status = 'In Use';

    public $search = '';
    public $modalTitle = 'Add New Glove';
    public $gloveToDelete = null;

    protected function rules()
    {
        return [
            'sap_code' => 'required|min:3|unique:tb_esd_gloves,sap_code,' . ($this->glove_id ?? 'NULL'),
            'description' => 'required|min:2',
            'delivery' => 'nullable|string',
            'status' => 'required|in:In Use,Not In Use,Under Repair,Damage,Disposed',
        ];
    }

    protected $messages = [
        'sap_code.required' => 'SAP code is required.',
        'sap_code.min' => 'SAP code must be at least 3 characters.',
        'sap_code.unique' => 'SAP code already exists.',
        'description.required' => 'Description is required.',
        'description.min' => 'Description must be at least 2 characters.',
        'status.required' => 'Status is required.',
        'status.in' => 'Status must be one of: In Use, Not In Use, Under Repair, Damage, Disposed.',
    ];

    public function resetForm()
    {
        $this->reset(['glove_id', 'sap_code', 'description', 'delivery', 'status']);
        $this->status = 'In Use';
        $this->modalTitle = 'Add New Glove';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->glove_id) {
            if (!auth()->user()->can('edit glove')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create glove')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'sap_code' => $this->sap_code,
            'description' => $this->description,
            'delivery' => $this->delivery,
            'status' => $this->status,
        ];

        if ($this->glove_id) {
            $glove = Glove::find($this->glove_id);
            if (!$glove) {
                $this->dispatch('notify', message: 'Glove not found!', type: 'error');
                return;
            }

            $glove->update($data);
            $message = 'Glove updated successfully!';
        } else {
            Glove::create($data);
            $message = 'Glove created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'glove-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit glove')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $glove = Glove::find($id);

        if (!$glove) {
            $this->dispatch('notify', message: 'Glove not found!', type: 'error');
            return;
        }

        $this->glove_id = $glove->id;
        $this->sap_code = $glove->sap_code;
        $this->description = $glove->description;
        $this->delivery = $glove->delivery;
        $this->status = $glove->status;
        $this->modalTitle = 'Edit Glove';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete glove')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $glove = Glove::find($id);

        if (!$glove) {
            $this->dispatch('notify', message: 'Glove not found!', type: 'error');
            return;
        }

        $this->gloveToDelete = $glove;
        $this->dispatch('open-modal', 'delete-glove-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete glove')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $glove = Glove::find($this->gloveToDelete->id);

        if (!$glove) {
            $this->dispatch('notify', message: 'Glove not found!', type: 'error');
            $this->gloveToDelete = null;
            return;
        }

        $sapCode = $glove->sap_code;
        $glove->delete();

        $this->gloveToDelete = null;
        $this->dispatch('notify', message: "Glove '{$sapCode}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-glove-modal');
    }

    public function cancelDelete()
    {
        $this->gloveToDelete = null;
        $this->dispatch('close-modal', 'delete-glove-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view glove')) {
            abort(403, 'Unauthorized access.');
        }

        $gloves = Glove::with('creator')
            ->when($this->search, function ($query) {
                $query->where('sap_code', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.esd.glove.glove-management', [
            'gloves' => $gloves,
        ]);
    }
}