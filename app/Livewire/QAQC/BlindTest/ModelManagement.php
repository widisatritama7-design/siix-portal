<?php

namespace App\Livewire\QAQC\BlindTest;

use App\Models\QAQC\BlindTest\Customer;
use App\Models\QAQC\BlindTest\Model;
use Livewire\Component;
use Livewire\WithPagination;

class ModelManagement extends Component
{
    use WithPagination;

    public $model_id;
    public $customer_id = '';
    public $model_name = '';
    public $search = '';
    public $modalTitle = 'Add New Model';
    public $modelToDelete = null;

    // View
    public $viewData = null;

    // Tab
    public $activeTab = 'all';

    protected function rules()
    {
        return [
            'customer_id' => 'required|exists:tb_qaqc_customer,id',
            'model_name' => 'required|string|max:255',
        ];
    }

    protected $messages = [
        'customer_id.required' => 'Customer is required.',
        'customer_id.exists' => 'Selected customer is invalid.',
        'model_name.required' => 'Model name is required.',
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
        $this->reset(['model_id', 'customer_id', 'model_name']);
        $this->modalTitle = 'Add New Model';
        $this->resetValidation();
    }

    public function save()
    {
        if ($this->model_id) {
            if (!auth()->user()->can('edit model')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create model')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        if ($this->model_id) {
            $model = Model::find($this->model_id);
            if (!$model) {
                $this->dispatch('notify', message: 'Model not found!', type: 'error');
                return;
            }

            $model->update([
                'customer_id' => $this->customer_id,
                'model_name' => strtoupper($this->model_name),
                'updated_by' => auth()->id(),
            ]);

            $message = 'Model updated successfully!';
        } else {
            Model::create([
                'customer_id' => $this->customer_id,
                'model_name' => strtoupper($this->model_name),
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            $message = 'Model created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal-model');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit model')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $model = Model::find($id);
        if (!$model) {
            $this->dispatch('notify', message: 'Model not found!', type: 'error');
            return;
        }

        $this->model_id = $model->id;
        $this->customer_id = $model->customer_id;
        $this->model_name = $model->model_name;
        $this->modalTitle = 'Edit Model';
        $this->dispatch('open-modal-model');
    }

    public function view($id)
    {
        $model = Model::with(['customer', 'creator', 'updater'])->find($id);
        if (!$model) {
            $this->dispatch('notify', message: 'Model not found!', type: 'error');
            return;
        }

        $this->viewData = $model;
        $this->dispatch('open-modal-view');
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete model')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $model = Model::find($id);
        if (!$model) {
            $this->dispatch('notify', message: 'Model not found!', type: 'error');
            return;
        }

        $this->modelToDelete = $model;
        $this->dispatch('open-modal-delete');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete model')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $model = Model::find($this->modelToDelete->id);
        if (!$model) {
            $this->dispatch('notify', message: 'Model not found!', type: 'error');
            $this->modelToDelete = null;
            return;
        }

        $name = $model->model_name;
        $model->delete();

        $this->modelToDelete = null;
        $this->dispatch('notify', message: "Model '{$name}' has been deleted successfully!");
        $this->dispatch('close-modal-delete');
    }

    public function cancelDelete()
    {
        $this->modelToDelete = null;
        $this->dispatch('close-modal-delete');
    }

    public function render()
    {
        if (!auth()->user()->can('view model')) {
            abort(403, 'Unauthorized access.');
        }

        $query = Model::with(['customer', 'creator', 'updater']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('model_name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('customer', function ($cq) {
                        $cq->where('customer_name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        $models = $query->orderByDesc('id')->paginate(10);

        return view('livewire.qaqc.blind-test.model-management', [
            'models' => $models,
            'customers' => Customer::orderBy('customer_name')->get(),
        ]);
    }
}