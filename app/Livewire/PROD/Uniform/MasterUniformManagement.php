<?php

namespace App\Livewire\PROD\Uniform;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PROD\Uniform\MasterUniform;
use App\Models\PROD\Uniform\UniformStockTransaction;

class MasterUniformManagement extends Component
{
    use WithPagination;

    public $uniform_id;
    public $item_code;
    public $description;
    public $size;
    public $price;
    public $qty; // Tambahkan ini

    public $search = '';
    public $modalTitle = 'Add New Uniform';
    public $uniformToDelete = null;

    // Property untuk Stock Management
    public $showStockModal = false;
    public $stockUniformId = null;
    public $stockUniform = null;
    public $stockAction = 'in'; // 'in' or 'opname'
    public $stockQty = 1;
    public $stockDescription = '';
    public $stockOpnameQty = 0;
    
    // Property untuk View History
    public $showHistoryModal = false;
    public $historyUniformId = null;
    public $historyUniform = null;
    public $historyTransactions = [];

    public $perPage = 10;
    public $perPageOptions = [10, 25, 50, 100, 'all'];

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    protected function rules()
    {
        return [
            'item_code' => 'required|string|max:100|unique:tb_prod_master_uniform,item_code,' . $this->uniform_id,
            'description' => 'required|string|max:255',
            'size' => 'required|string|max:50',
            'price' => 'required|numeric|min:0|max:999999999.99',
            'qty' => 'nullable|integer|min:0', // Validasi qty
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
        'qty.integer' => 'Qty must be a number.',
        'qty.min' => 'Qty cannot be negative.',
    ];

    public function resetForm()
    {
        $this->reset(['uniform_id', 'item_code', 'description', 'size', 'price', 'qty']);
        $this->modalTitle = 'Add New Uniform';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
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

        $cleanPrice = str_replace(['.', ','], '', $this->price);
        $cleanPrice = (float) $cleanPrice;

        $data = [
            'item_code' => $this->item_code,
            'description' => $this->description,
            'size' => $this->size,
            'price' => $cleanPrice,
            'qty' => $this->qty ?? 0,
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
        $this->price = $uniform->price;
        $this->qty = $uniform->qty;
        $this->modalTitle = 'Edit Uniform';
    }

    // ==================== STOCK MANAGEMENT ====================

    public function openStockModal($id, $action = 'in')
    {
        if (!auth()->user()->can('edit master uniform')) {
            $this->dispatch('notify', message: 'You do not have permission to manage stock!', type: 'error');
            return;
        }

        $uniform = MasterUniform::find($id);
        if (!$uniform) {
            $this->dispatch('notify', message: 'Uniform not found!', type: 'error');
            return;
        }

        $this->stockUniformId = $id;
        $this->stockUniform = $uniform;
        $this->stockAction = $action;
        $this->stockQty = 1;
        $this->stockDescription = '';
        $this->stockOpnameQty = $uniform->qty;
        $this->showStockModal = true;
    }

    public function saveStockIn()
    {
        if (!auth()->user()->can('edit master uniform')) {
            $this->dispatch('notify', message: 'You do not have permission to manage stock!', type: 'error');
            return;
        }

        $this->validate([
            'stockQty' => 'required|integer|min:1',
            'stockDescription' => 'nullable|string|max:255',
        ]);

        $uniform = MasterUniform::find($this->stockUniformId);
        if (!$uniform) {
            $this->dispatch('notify', message: 'Uniform not found!', type: 'error');
            return;
        }

        $oldQty = $uniform->qty;
        $newQty = $oldQty + $this->stockQty;

        // Update qty
        $uniform->qty = $newQty;
        $uniform->save();

        // Create transaction history
        UniformStockTransaction::create([
            'master_uniform_id' => $uniform->id,
            'transaction_type' => 'IN',
            'qty_change' => $this->stockQty,
            'qty_before' => $oldQty,
            'qty_after' => $newQty,
            'reference_id' => 'STOCK_IN-' . now()->format('YmdHis'),
            'reference_type' => 'stock_in',
            'description' => $this->stockDescription ?: 'Stock In',
            'performed_by' => auth()->user()->name,
            'performed_at' => now(),
        ]);

        $this->dispatch('notify', message: "Stock added successfully! Current stock: {$newQty}");
        $this->showStockModal = false;
        $this->resetPage();
    }

    public function saveStockOpname()
    {
        if (!auth()->user()->can('edit master uniform')) {
            $this->dispatch('notify', message: 'You do not have permission to manage stock!', type: 'error');
            return;
        }

        $this->validate([
            'stockOpnameQty' => 'required|integer|min:0',
            'stockDescription' => 'nullable|string|max:255',
        ]);

        $uniform = MasterUniform::find($this->stockUniformId);
        if (!$uniform) {
            $this->dispatch('notify', message: 'Uniform not found!', type: 'error');
            return;
        }

        $oldQty = $uniform->qty;
        $newQty = $this->stockOpnameQty;
        $qtyChange = $newQty - $oldQty;

        // Update qty
        $uniform->qty = $newQty;
        $uniform->save();

        // Create transaction history
        UniformStockTransaction::create([
            'master_uniform_id' => $uniform->id,
            'transaction_type' => 'OPNAME',
            'qty_change' => $qtyChange,
            'qty_before' => $oldQty,
            'qty_after' => $newQty,
            'reference_id' => 'OPNAME-' . now()->format('YmdHis'),
            'reference_type' => 'stock_opname',
            'description' => $this->stockDescription ?: 'Stock Opname',
            'performed_by' => auth()->user()->name,
            'performed_at' => now(),
        ]);

        $this->dispatch('notify', message: "Stock opname completed! Stock adjusted from {$oldQty} to {$newQty}");
        $this->showStockModal = false;
        $this->resetPage();
    }

    // ==================== HISTORY ====================

    public function openHistoryModal($id)
    {
        $uniform = MasterUniform::find($id);
        if (!$uniform) {
            $this->dispatch('notify', message: 'Uniform not found!', type: 'error');
            return;
        }

        $this->historyUniformId = $id;
        $this->historyUniform = $uniform;
        $this->historyTransactions = UniformStockTransaction::where('master_uniform_id', $id)
            ->orderBy('performed_at', 'desc')
            ->get()
            ->toArray();
        
        $this->showHistoryModal = true;
    }

    // ==================== DELETE ====================

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
        if (!auth()->user()->can('view master uniform')) {
            abort(403, 'Unauthorized access.');
        }

        $query = MasterUniform::query()
            ->when($this->search, function ($query) {
                $query->where('item_code', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('size', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id');

        // Jika perPage = 'all', ambil semua data tanpa paginasi
        if ($this->perPage === 'all') {
            $uniforms = $query->get();
            // Buat paginator manual untuk semua data
            $uniforms = new \Illuminate\Pagination\LengthAwarePaginator(
                $uniforms,
                $uniforms->count(),
                $uniforms->count(),
                1,
                ['path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath()]
            );
        } else {
            $uniforms = $query->paginate($this->perPage);
        }

        return view('livewire.prod.uniform.master-uniform-management', [
            'uniforms' => $uniforms,
        ]);
    }
}