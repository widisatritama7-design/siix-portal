<?php

namespace App\Livewire\PROD\Uniform;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PROD\Uniform\MasterUniform;

class MasterUniformManagement extends Component
{
    use WithPagination;

    public $uniform_id;
    public $item_code;
    public $description;
    public $size;
    public $price; // Tambahkan ini

    public $search = '';
    public $modalTitle = 'Add New Uniform';
    public $uniformToDelete = null;

    protected function rules()
    {
        return [
            'item_code' => 'required|string|max:100|unique:tb_prod_master_uniform,item_code,' . $this->uniform_id,
            'description' => 'required|string|max:255',
            'size' => 'required|string|max:50',
            'price' => 'required|numeric|min:0|max:999999999.99', // Validasi price
        ];
    }

    protected $messages = [
        'item_code.required' => 'Item code is required.',
        'item_code.unique' => 'This item code already exists.',
        'description.required' => 'Description is required.',
        'size.required' => 'Size is required.',
        'price.required' => 'Price is required.',
        'price.numeric' => 'Price must be a number.',
        'price.min' => 'Price cannot be negative.',
        'price.max' => 'Price is too high.',
    ];

    public function resetForm()
    {
        $this->reset(['uniform_id', 'item_code', 'description', 'size', 'price']);
        $this->modalTitle = 'Add New Uniform';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        // Check permission for create or edit
        if ($this->uniform_id) {
            if (!auth()->user()->can('edit master uniform')) {
                $this->dispatch('notify', message: 'You do not have permission to edit!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create master uniform')) {
                $this->dispatch('notify', message: 'You do not have permission to create!', type: 'error');
                return;
            }
        }

        $this->validate();

        // Bersihkan price dari titik dan koma
        $cleanPrice = str_replace(['.', ','], '', $this->price);
        $cleanPrice = (float) $cleanPrice;

        $data = [
            'item_code' => $this->item_code,
            'description' => $this->description,
            'size' => $this->size,
            'price' => $cleanPrice, // Simpan sebagai angka murni
        ];

        if ($this->uniform_id) {
            $uniform = MasterUniform::find($this->uniform_id);
            if (!$uniform) {
                $this->dispatch('notify', message: 'Uniform not found!', type: 'error');
                return;
            }

            $uniform->update($data);
            $message = 'Uniform updated successfully!';
        } else {
            MasterUniform::create($data);
            $message = 'Uniform created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'uniform-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit master uniform')) {
            $this->dispatch('notify', message: 'You do not have permission to edit!', type: 'error');
            return;
        }

        $uniform = MasterUniform::find($id);

        if (!$uniform) {
            $this->dispatch('notify', message: 'Uniform not found!', type: 'error');
            return;
        }

        $this->uniform_id = $uniform->id;
        $this->item_code = $uniform->item_code;
        $this->description = $uniform->description;
        $this->size = $uniform->size;
        $this->price = $uniform->price; // Ambil nilai price
        $this->modalTitle = 'Edit Uniform';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete master uniform')) {
            $this->dispatch('notify', message: 'You do not have permission to delete!', type: 'error');
            return;
        }

        $uniform = MasterUniform::find($id);

        if (!$uniform) {
            $this->dispatch('notify', message: 'Uniform not found!', type: 'error');
            return;
        }

        $this->uniformToDelete = $uniform;
        $this->dispatch('open-modal', 'delete-uniform-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete master uniform')) {
            $this->dispatch('notify', message: 'You do not have permission to delete!', type: 'error');
            return;
        }

        $uniform = MasterUniform::find($this->uniformToDelete->id);

        if (!$uniform) {
            $this->dispatch('notify', message: 'Uniform not found!', type: 'error');
            $this->uniformToDelete = null;
            return;
        }

        $itemCode = $uniform->item_code;
        $uniform->delete();

        $this->uniformToDelete = null;
        $this->dispatch('notify', message: "Uniform '{$itemCode}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-uniform-modal');
    }

    public function cancelDelete()
    {
        $this->uniformToDelete = null;
        $this->dispatch('close-modal', 'delete-uniform-modal');
    }

    public function render()
    {
        // Check permission for view
        if (!auth()->user()->can('view master uniform')) {
            abort(403, 'Unauthorized access.');
        }

        $uniforms = MasterUniform::query()
            ->when($this->search, function ($query) {
                $query->where('item_code', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('size', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.prod.uniform.master-uniform-management', [
            'uniforms' => $uniforms,
        ]);
    }
}