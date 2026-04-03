<?php

namespace App\Livewire\ESD\Stock;

use Livewire\Component;
use App\Models\ESD\Stock\Material;
use App\Models\ESD\Stock\Transaction;
use Carbon\Carbon;

class TransactionManagement extends Component
{
    public $transactionDate;
    public $items = [];
    public $selectedMaterial = null;
    public $searchMaterial = '';
    public $materials = [];
    
    // Transaction summary
    public $totalItems = 0;
    public $totalQuantity = 0;
    
    // Current item being added
    public $currentMaterialId = null;
    public $currentMaterial = null;
    public $currentQty = 1;
    public $currentType = 'in'; // in or out
    public $currentPic = '';
    public $currentKeterangan = '';
    
    public $editMode = false;
    public $editingTransactionId = null;
    
    protected $rules = [
        'transactionDate' => 'required|date',
        'items.*.material_id' => 'required|exists:tb_esd_materials,id',
        'items.*.qty' => 'required|integer|min:1',
        'items.*.type' => 'required|in:in,out',
        'items.*.pic' => 'required|string|max:100',
        'items.*.keterangan' => 'nullable|string|max:500',
    ];
    
    protected $messages = [
        'transactionDate.required' => 'Transaction date is required.',
        'items.*.material_id.required' => 'Material is required.',
        'items.*.qty.required' => 'Quantity is required.',
        'items.*.qty.min' => 'Quantity must be at least 1.',
        'items.*.type.required' => 'Transaction type is required.',
        'items.*.pic.required' => 'PIC is required.',
    ];
    
    public function mount()
    {
        $this->transactionDate = Carbon::now()->format('Y-m-d');
        $this->items = [];
        $this->currentPic = auth()->user()->name;
        $this->loadMaterials();
    }
    
    public function loadMaterials()
    {
        $this->materials = Material::orderBy('sap_code')->get();
    }
    
    public function updatedSearchMaterial()
    {
        if (strlen($this->searchMaterial) >= 2) {
            $this->materials = Material::where('sap_code', 'like', '%' . $this->searchMaterial . '%')
                ->orWhere('description', 'like', '%' . $this->searchMaterial . '%')
                ->orderBy('sap_code')
                ->get();
        } else {
            $this->loadMaterials();
        }
    }
    
    public function selectMaterial($materialId)
    {
        $this->currentMaterialId = $materialId;
        $this->currentMaterial = Material::find($materialId);
        $this->searchMaterial = $this->currentMaterial->sap_code . ' - ' . $this->currentMaterial->description;
        $this->resetValidation('currentMaterialId');
    }
    
    public function addItem()
    {
        $this->validate([
            'currentMaterialId' => 'required|exists:tb_esd_materials,id',
            'currentQty' => 'required|integer|min:1',
            'currentType' => 'required|in:in,out',
            'currentPic' => 'required|string|max:100',
        ], [
            'currentMaterialId.required' => 'Please select a material.',
            'currentQty.required' => 'Quantity is required.',
            'currentQty.min' => 'Quantity must be at least 1.',
            'currentPic.required' => 'PIC is required.',
        ]);
        
        // Check if enough stock for OUT transaction
        if ($this->currentType === 'out') {
            $material = Material::find($this->currentMaterialId);
            if ($material->last_stock < $this->currentQty) {
                $this->dispatch('notify', 
                    message: "Insufficient stock! Available: {$material->last_stock} {$material->unit}", 
                    type: 'error');
                return;
            }
        }
        
        $this->items[] = [
            'material_id' => $this->currentMaterialId,
            'material' => $this->currentMaterial,
            'qty' => $this->currentQty,
            'type' => $this->currentType,
            'pic' => $this->currentPic,
            'keterangan' => $this->currentKeterangan,
            'temp_id' => uniqid(),
        ];
        
        $this->calculateSummary();
        $this->resetCurrentItem();
        $this->dispatch('notify', message: 'Item added to transaction!', type: 'success');
    }
    
    public function resetCurrentItem()
    {
        $this->currentMaterialId = null;
        $this->currentMaterial = null;
        $this->searchMaterial = '';
        $this->currentQty = 1;
        $this->currentType = 'in';
        $this->currentKeterangan = '';
        // Keep PIC as is
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
        if (!auth()->user()->can('create transaction')) {
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
            
            foreach ($this->items as $item) {
                $material = Material::find($item['material_id']);
                
                // Create transaction record
                Transaction::create([
                    'date' => $this->transactionDate,
                    'material_id' => $item['material_id'],
                    'type' => $item['type'],
                    'transaction_type' => $item['type'] === 'in' ? 'IN' : 'OUT',
                    'qty' => $item['qty'],
                    'pic' => $item['pic'],
                    'keterangan' => $item['keterangan'],
                ]);
                
                // Update material stock
                if ($item['type'] === 'in') {
                    $material->increment('in', $item['qty']);
                    $material->increment('last_stock', $item['qty']);
                } else {
                    $material->increment('out', $item['qty']);
                    $material->decrement('last_stock', $item['qty']);
                }
            }
            
            \DB::commit();
            
            $this->dispatch('notify', message: 'Transaction saved successfully!', type: 'success');
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
        $this->currentPic = auth()->user()->name;
    }
    
    public function render()
    {
        return view('livewire.esd.stock.transaction-management');
    }
}