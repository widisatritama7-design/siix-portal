<?php

namespace App\Livewire\PROD\WIP;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PROD\WIP\MasterModel;

class MasterModelManagement extends Component
{
    use WithPagination;

    public $model_id;
    public $model;
    public $customer;
    public $part_number;

    public $search = '';
    public $modalTitle = 'Add New Model';
    public $modelToDelete = null;

    protected function rules()
    {
        return [
            'model' => 'required|min:2|unique:tb_prod_master_models,model,' . $this->model_id,
            'customer' => 'required|min:2',
            'part_number' => 'nullable|string|max:255',
        ];
    }

    protected $messages = [
        'model.required' => 'Model name is required.',
        'model.min' => 'Model name must be at least 2 characters.',
        'model.unique' => 'This model name already exists.',
        'customer.required' => 'Customer name is required.',
        'customer.min' => 'Customer name must be at least 2 characters.',
    ];

    public function resetForm()
    {
        $this->reset(['model_id', 'model', 'customer', 'part_number']);
        $this->modalTitle = 'Add New Model';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->model_id) {
            if (!auth()->user()->can('edit master models')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create master models')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'model' => $this->model,
            'customer' => $this->customer,
            'part_number' => $this->part_number,
        ];

        if ($this->model_id) {
            $masterModel = MasterModel::find($this->model_id);
            if (!$masterModel) {
                $this->dispatch('notify', message: 'Model not found!', type: 'error');
                return;
            }

            $masterModel->update($data);
            $message = 'Model updated successfully!';
        } else {
            MasterModel::create($data);
            $message = 'Model created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'model-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit master models')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $masterModel = MasterModel::find($id);

        if (!$masterModel) {
            $this->dispatch('notify', message: 'Model not found!', type: 'error');
            return;
        }

        $this->model_id = $masterModel->id;
        $this->model = $masterModel->model;
        $this->customer = $masterModel->customer;
        $this->part_number = $masterModel->part_number;
        $this->modalTitle = 'Edit Model';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete master models')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $masterModel = MasterModel::find($id);

        if (!$masterModel) {
            $this->dispatch('notify', message: 'Model not found!', type: 'error');
            return;
        }

        // Check if model has related WIP records
        if ($masterModel->masterWips()->count() > 0) {
            $this->dispatch('notify', message: 'Cannot delete model that has associated WIP records!', type: 'error');
            return;
        }

        $this->modelToDelete = $masterModel;
        $this->dispatch('open-modal', 'delete-model-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete master models')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $masterModel = MasterModel::find($this->modelToDelete->id);

        if (!$masterModel) {
            $this->dispatch('notify', message: 'Model not found!', type: 'error');
            $this->modelToDelete = null;
            return;
        }

        $modelName = $masterModel->model;
        $masterModel->delete();

        $this->modelToDelete = null;
        $this->dispatch('notify', message: "Model '{$modelName}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-model-modal');
    }

    public function cancelDelete()
    {
        $this->modelToDelete = null;
        $this->dispatch('close-modal', 'delete-model-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view master models')) {
            abort(403, 'Unauthorized access.');
        }

        $models = MasterModel::with(['creator', 'updater'])
            ->when($this->search, function ($query) {
                $query->where('model', 'like', '%' . $this->search . '%')
                    ->orWhere('customer', 'like', '%' . $this->search . '%')
                    ->orWhere('part_number', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.prod.wip.master-model-management', [
            'models' => $models,
        ]);
    }
}