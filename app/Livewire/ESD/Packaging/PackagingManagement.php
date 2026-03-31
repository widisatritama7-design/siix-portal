<?php

namespace App\Livewire\ESD\Packaging;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Packaging\Packaging;

class PackagingManagement extends Component
{
    use WithPagination;

    public $packaging_id;
    public $category;
    public $project;
    public $model;
    public $oracle;
    public $sap_code;
    public $material;
    public $material_desc;
    public $size;
    public $supplier;
    public $status = 'In Use';

    public $search = '';
    public $filterCategory = '';
    public $modalTitle = 'Add New Packaging';
    public $packagingToDelete = null;

    // Get unique categories for filter dropdown
    public function getCategoriesProperty()
    {
        return Packaging::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
    }

    protected function rules()
    {
        return [
            'category' => 'required|min:2|max:100',
            'project' => 'nullable|max:100',
            'model' => 'nullable|max:100',
            'oracle' => 'nullable|max:50',
            'sap_code' => 'nullable|max:50',
            'material' => 'required|min:2|max:100',
            'material_desc' => 'nullable|max:255',
            'size' => 'nullable|max:50',
            'supplier' => 'nullable|max:100',
            'status' => 'required|in:In Use,Not In Use,Under Repair,Damage,Disposed',
        ];
    }

    protected $messages = [
        'category.required' => 'Category is required.',
        'category.min' => 'Category must be at least 2 characters.',
        'material.required' => 'Material is required.',
        'material.min' => 'Material must be at least 2 characters.',
        'status.required' => 'Status is required.',
        'status.in' => 'Status must be one of: In Use, Not In Use, Under Repair, Damage, Disposed.',
    ];

    public function resetForm()
    {
        $this->reset([
            'packaging_id', 'category', 'project', 'model', 'oracle', 
            'sap_code', 'material', 'material_desc', 'size', 'supplier', 'status'
        ]);
        $this->status = 'In Use';
        $this->modalTitle = 'Add New Packaging';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterCategory']);
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterCategory()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->packaging_id) {
            if (!auth()->user()->can('edit packaging')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create packaging')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'category' => $this->category,
            'project' => $this->project,
            'model' => $this->model,
            'oracle' => $this->oracle,
            'sap_code' => $this->sap_code,
            'material' => $this->material,
            'material_desc' => $this->material_desc,
            'size' => $this->size,
            'supplier' => $this->supplier,
            'status' => $this->status,
        ];

        if ($this->packaging_id) {
            $packaging = Packaging::find($this->packaging_id);
            if (!$packaging) {
                $this->dispatch('notify', message: 'Packaging not found!', type: 'error');
                return;
            }

            $packaging->update($data);
            $message = 'Packaging updated successfully!';
        } else {
            Packaging::create($data);
            $message = 'Packaging created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'packaging-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit packaging')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $packaging = Packaging::find($id);

        if (!$packaging) {
            $this->dispatch('notify', message: 'Packaging not found!', type: 'error');
            return;
        }

        $this->packaging_id = $packaging->id;
        $this->category = $packaging->category;
        $this->project = $packaging->project;
        $this->model = $packaging->model;
        $this->oracle = $packaging->oracle;
        $this->sap_code = $packaging->sap_code;
        $this->material = $packaging->material;
        $this->material_desc = $packaging->material_desc;
        $this->size = $packaging->size;
        $this->supplier = $packaging->supplier;
        $this->status = $packaging->status;
        $this->modalTitle = 'Edit Packaging';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete packaging')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $packaging = Packaging::find($id);

        if (!$packaging) {
            $this->dispatch('notify', message: 'Packaging not found!', type: 'error');
            return;
        }

        $this->packagingToDelete = $packaging;
        $this->dispatch('open-modal', 'delete-packaging-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete packaging')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $packaging = Packaging::find($this->packagingToDelete->id);

        if (!$packaging) {
            $this->dispatch('notify', message: 'Packaging not found!', type: 'error');
            $this->packagingToDelete = null;
            return;
        }

        $material = $packaging->material;
        $packaging->delete();

        $this->packagingToDelete = null;
        $this->dispatch('notify', message: "Packaging '{$material}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-packaging-modal');
    }

    public function cancelDelete()
    {
        $this->packagingToDelete = null;
        $this->dispatch('close-modal', 'delete-packaging-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view packaging')) {
            abort(403, 'Unauthorized access.');
        }

        $categories = Packaging::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $packagings = Packaging::with('creator')
            ->when($this->search, function ($query) {
                $query->where('category', 'like', '%' . $this->search . '%')
                    ->orWhere('project', 'like', '%' . $this->search . '%')
                    ->orWhere('model', 'like', '%' . $this->search . '%')
                    ->orWhere('material', 'like', '%' . $this->search . '%')
                    ->orWhere('oracle', 'like', '%' . $this->search . '%')
                    ->orWhere('sap_code', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterCategory, function ($query) {
                $query->where('category', $this->filterCategory);
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('livewire.esd.packaging.packaging-management', [
            'packagings' => $packagings,
            'categories' => $categories,
        ]);
    }
}