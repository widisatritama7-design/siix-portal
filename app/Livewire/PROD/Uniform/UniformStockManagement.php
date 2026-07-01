<?php

namespace App\Livewire\PROD\Uniform;

use Livewire\Component;
use App\Models\PROD\Uniform\MasterUniform;
use App\Models\PROD\Uniform\UniformStockTransaction;
use Carbon\Carbon;

class UniformStockManagement extends Component
{
    public $transactionDate;
    public $transactionType = 'in'; // 'in' or 'opname'
    public $items = [];
    
    // Current item being added
    public $searchUniform = '';
    public $uniforms = [];
    public $currentUniformId = null;
    public $currentUniform = null;
    public $currentQty = 1;
    public $currentOpnameQty = 0;
    public $currentDescription = '';
    
    // Summary
    public $totalItems = 0;
    public $totalQuantity = 0;
    
    protected $rules = [
        'transactionDate' => 'required|date',
        'items.*.uniform_id' => 'required|exists:tb_prod_master_uniform,id',
        'items.*.qty' => 'required|integer|min:1',
        'items.*.description' => 'nullable|string|max:500',
    ];
    
    protected $messages = [
        'transactionDate.required' => 'Transaction date is required.',
        'items.*.uniform_id.required' => 'Uniform is required.',
        'items.*.qty.required' => 'Quantity is required.',
        'items.*.qty.min' => 'Quantity must be at least 1.',
    ];
    
    public function mount()
    {
        $this->transactionDate = Carbon::now()->format('Y-m-d');
        $this->items = [];
        $this->loadUniforms();
    }
    
    public function loadUniforms()
    {
        $this->uniforms = MasterUniform::orderBy('item_code')->get();
    }
    
    public function updatedSearchUniform()
    {
        if (strlen($this->searchUniform) >= 2) {
            $this->uniforms = MasterUniform::where('item_code', 'like', '%' . $this->searchUniform . '%')
                ->orWhere('description', 'like', '%' . $this->searchUniform . '%')
                ->orWhere('size', 'like', '%' . $this->searchUniform . '%')
                ->orderBy('item_code')
                ->get();
        } else {
            $this->loadUniforms();
        }
    }
    
    public function selectUniform($uniformId)
    {
        $this->currentUniformId = $uniformId;
        $this->currentUniform = MasterUniform::find($uniformId);
        $this->currentOpnameQty = $this->currentUniform->qty;
        $this->searchUniform = $this->currentUniform->item_code . ' - ' . $this->currentUniform->description . ' (' . $this->currentUniform->size . ') - Stock: ' . $this->currentUniform->qty;
        $this->resetValidation('currentUniformId');
    }
    
    public function addItem()
    {
        $this->validate([
            'currentUniformId' => 'required|exists:tb_prod_master_uniform,id',
        ], [
            'currentUniformId.required' => 'Please select a uniform.',
        ]);
        
        // Validate based on transaction type
        if ($this->transactionType === 'in') {
            $this->validate([
                'currentQty' => 'required|integer|min:1',
            ], [
                'currentQty.required' => 'Quantity is required.',
                'currentQty.min' => 'Quantity must be at least 1.',
            ]);
            $qty = $this->currentQty;
        } else {
            // Opname
            $this->validate([
                'currentOpnameQty' => 'required|integer|min:0',
            ], [
                'currentOpnameQty.required' => 'Stock quantity is required.',
                'currentOpnameQty.min' => 'Stock quantity cannot be negative.',
            ]);
            $qty = $this->currentOpnameQty;
        }
        
        // Check if uniform already added
        $exists = collect($this->items)->contains('uniform_id', $this->currentUniformId);
        if ($exists) {
            $this->dispatch('notify', message: 'This uniform has already been added!', type: 'error');
            return;
        }
        
        $this->items[] = [
            'uniform_id' => $this->currentUniformId,
            'uniform' => $this->currentUniform,
            'qty' => $qty,
            'old_qty' => $this->currentUniform->qty,
            'description' => $this->currentDescription,
            'temp_id' => uniqid(),
        ];
        
        $this->calculateSummary();
        $this->resetCurrentItem();
        $this->dispatch('notify', message: 'Item added to transaction!', type: 'success');
    }
    
    public function resetCurrentItem()
    {
        $this->currentUniformId = null;
        $this->currentUniform = null;
        $this->searchUniform = '';
        $this->currentQty = 1;
        $this->currentOpnameQty = 0;
        $this->currentDescription = '';
    }
    
    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateSummary();
        $this->dispatch('notify', message: 'Item removed from transaction!', type: 'warning');
    }
    
    public function calculateSummary()
    {
        $this->totalItems = count($this->items);
        $this->totalQuantity = array_sum(array_column($this->items, 'qty'));
    }
    
    public function saveTransaction()
    {
        if (!auth()->user()->can('edit master uniform')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }
        
        if (empty($this->items)) {
            $this->dispatch('notify', message: 'Please add at least one item!', type: 'error');
            return;
        }
        
        $this->validate();
        
        try {
            \DB::beginTransaction();
            $transactionTypeLabel = $this->transactionType === 'in' ? 'IN' : 'OPNAME';
            
            foreach ($this->items as $item) {
                $uniform = MasterUniform::find($item['uniform_id']);
                $oldQty = $uniform->qty;
                
                if ($this->transactionType === 'in') {
                    $newQty = $oldQty + $item['qty'];
                    $qtyChange = $item['qty'];
                    $description = 'Stock In: ' . ($item['description'] ?? 'Stock addition');
                } else {
                    // Opname
                    $newQty = $item['qty']; // qty adalah hasil opname
                    $qtyChange = $newQty - $oldQty;
                    $description = 'Stock Opname: ' . ($item['description'] ?? 'Physical stock count');
                }
                
                // Update qty di MasterUniform
                $uniform->qty = $newQty;
                $uniform->save();
                
                // Create transaction history
                UniformStockTransaction::create([
                    'master_uniform_id' => $item['uniform_id'],
                    'transaction_type' => $transactionTypeLabel,
                    'qty_change' => $qtyChange,
                    'qty_before' => $oldQty,
                    'qty_after' => $newQty,
                    'reference_id' => $transactionTypeLabel . '-' . Carbon::now()->format('YmdHis') . '-' . $item['uniform']->item_code,
                    'reference_type' => $this->transactionType === 'in' ? 'stock_in' : 'stock_opname',
                    'description' => $description . ' - ' . $item['uniform']->item_code,
                    'performed_by' => auth()->user()->name,
                    'performed_at' => $this->transactionDate . ' ' . now()->format('H:i:s'),
                ]);
            }
            
            \DB::commit();
            
            $typeText = $this->transactionType === 'in' ? 'Stock In' : 'Stock Opname';
            $this->dispatch('notify', message: $typeText . ' saved successfully! ' . $this->totalItems . ' item(s) processed.', type: 'success');
            $this->resetTransaction();
            
        } catch (\Exception $e) {
            \DB::rollBack();
            $this->dispatch('notify', message: 'Error saving transaction: ' . $e->getMessage(), type: 'error');
        }
    }
    
    public function resetTransaction()
    {
        $this->items = [];
        $this->totalItems = 0;
        $this->totalQuantity = 0;
        $this->resetCurrentItem();
        $this->transactionDate = Carbon::now()->format('Y-m-d');
    }
    
    public function render()
    {
        return view('livewire.prod.uniform.uniform-stock-management');
    }
}