<?php

namespace App\Livewire\ESD\Stock;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Stock\Material;
use Carbon\Carbon;

class MaterialManagement extends Component
{
    use WithPagination;

    // Form properties
    public $material_id;
    public $sap_code;
    public $description;
    public $type;
    public $qty_first;
    public $in = 0;
    public $out = 0;
    public $last_stock = 0;
    public $minimum_stock;
    public $unit;
    public $information;
    public $assign_request = 'Not Request';
    public $qty_request;
    public $remarks;
    public $consumable = 'Weekly';
    public $pic = [];
    
    // Filter properties
    public $search = '';
    public $filterType = '';
    public $filterConsumable = '';
    public $filterPic = '';
    public $filterLowStock = false;
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    
    public $modalTitle = 'Add New Material';
    public $detailToDelete = null;
    public $showDetailModal = false;
    public $selectedMaterial = null;

    // For inline editing
    public $editingField = null;
    public $editingId = null;
    public $editingValue = null;

    public $showTransactionModal = false;
    public $selectedMaterialForTransactions = null;
    public $transactionPage = 1;
    public $perPageTransactions = 5;

    // Options
    public $typeOptions = [
        'Spare Part' => 'Spare Part',
        'Indirect Material' => 'Indirect Material',
        'Office Supply' => 'Office Supply'
    ];
    
    public $consumableOptions = [
        'Weekly' => 'Weekly',
        'Monthly' => 'Monthly',
        'By PR' => 'By PR'
    ];
    
    public $assignRequestOptions = [
        'Request' => 'Request',
        'Not Request' => 'Not Request'
    ];
    
    public $picOptions = [
        'ESD' => 'ESD',
        'Utility' => 'Utility'
    ];

    protected function rules()
    {
        return [
            'sap_code' => 'required|string|max:50|unique:tb_esd_materials,sap_code,' . $this->material_id,
            'description' => 'required|string|max:255',
            'type' => 'required|string|in:Spare Part,Indirect Material,Office Supply',
            'qty_first' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:20',
            'information' => 'required|string',
            'assign_request' => 'nullable|string|in:Request,Not Request',
            'qty_request' => 'nullable|integer|min:0',
            'remarks' => 'nullable|string|max:500',
            'consumable' => 'required|string|in:Weekly,Monthly,By PR',
            'pic' => 'nullable|array',
        ];
    }

    protected function messages()
    {
        return [
            'sap_code.required' => 'SAP Code is required.',
            'sap_code.unique' => 'SAP Code already exists.',
            'description.required' => 'Description is required.',
            'type.required' => 'Type is required.',
            'qty_first.required' => 'Initial quantity is required.',
            'qty_first.min' => 'Initial quantity cannot be negative.',
            'minimum_stock.required' => 'Minimum stock is required.',
            'minimum_stock.min' => 'Minimum stock cannot be negative.',
            'unit.required' => 'Unit is required.',
            'information.required' => 'Information is required.',
            'consumable.required' => 'Consumable is required.',
        ];
    }

    public function viewTransactions($materialId)
    {
        $this->selectedMaterialForTransactions = Material::with('transactions.creator')->find($materialId);
        $this->transactionPage = 1;
        $this->showTransactionModal = true;
    }

    public function setTransactionPage($page)
    {
        $this->transactionPage = $page;
    }

    public function closeTransactionModal()
    {
        $this->showTransactionModal = false;
        $this->selectedMaterialForTransactions = null;
        $this->transactionPage = 1;
    }

    public function mount()
    {
        $this->calculateLastStock();
    }

    public function calculateLastStock()
    {
        $this->last_stock = ($this->qty_first ?: 0) + ($this->in ?: 0) - ($this->out ?: 0);
    }

    public function updatedQtyFirst()
    {
        $this->calculateLastStock();
    }

    public function updatedIn()
    {
        $this->calculateLastStock();
    }

    public function updatedOut()
    {
        $this->calculateLastStock();
    }

    public function updatedSapCode($value)
    {
        $this->sap_code = strtoupper($value);
    }

    public function getTypeColor($type)
    {
        return match($type) {
            'Spare Part' => 'info',
            'Indirect Material' => 'warning',
            'Office Supply' => 'success',
            default => 'gray',
        };
    }

    public function getConsumableColor($consumable)
    {
        return match($consumable) {
            'Weekly' => 'info',
            'Monthly' => 'warning',
            'By PR' => 'success',
            default => 'gray',
        };
    }

    // Inline editing methods
    public function startEditing($id, $field, $value)
    {
        $this->editingId = $id;
        $this->editingField = $field;
        $this->editingValue = $value;
    }

    public function cancelEditing()
    {
        $this->editingId = null;
        $this->editingField = null;
        $this->editingValue = null;
    }

    public function updateAssignRequest($id, $value)
    {
        if (!auth()->user()->can('edit material')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $material = Material::find($id);
        if ($material) {
            $material->update(['assign_request' => $value]);
            $this->dispatch('notify', message: 'Assign request updated successfully!', type: 'success');
        }
        
        $this->cancelEditing();
    }

    public function updateQtyRequest($id, $value)
    {
        if (!auth()->user()->can('edit material')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $material = Material::find($id);
        if ($material) {
            $material->update(['qty_request' => $value ?: null]);
            $this->dispatch('notify', message: 'Qty request updated successfully!', type: 'success');
        }
        
        $this->cancelEditing();
    }

    public function updateRemarks($id, $value)
    {
        if (!auth()->user()->can('edit material')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $material = Material::find($id);
        if ($material) {
            $material->update(['remarks' => $value]);
            $this->dispatch('notify', message: 'Remarks updated successfully!', type: 'success');
        }
        
        $this->cancelEditing();
    }

    public function resetForm()
    {
        $this->reset([
            'material_id', 'sap_code', 'description', 'type', 'qty_first', 'in', 'out',
            'last_stock', 'minimum_stock', 'unit', 'information', 'assign_request',
            'qty_request', 'remarks', 'consumable', 'pic'
        ]);
        $this->in = 0;
        $this->out = 0;
        $this->last_stock = 0;
        $this->assign_request = 'Not Request';
        $this->consumable = 'Weekly';
        $this->pic = [];
        $this->modalTitle = 'Add New Material';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset([
            'search', 'filterType', 'filterConsumable', 'filterPic', 'filterLowStock',
            'filterDateFrom', 'filterDateUntil'
        ]);
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterType()
    {
        $this->resetPage();
    }

    public function updatedFilterConsumable()
    {
        $this->resetPage();
    }

    public function updatedFilterPic()
    {
        $this->resetPage();
    }

    public function updatedFilterLowStock()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->material_id) {
            if (!auth()->user()->can('edit material')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create material')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'sap_code' => $this->sap_code,
            'description' => $this->description,
            'type' => $this->type,
            'qty_first' => $this->qty_first,
            'in' => $this->in ?: 0,
            'out' => $this->out ?: 0,
            'last_stock' => $this->last_stock,
            'minimum_stock' => $this->minimum_stock,
            'unit' => $this->unit,
            'information' => $this->information,
            'assign_request' => $this->assign_request,
            'qty_request' => $this->qty_request,
            'remarks' => $this->remarks,
            'consumable' => $this->consumable,
            'pic' => $this->pic,
        ];

        if ($this->material_id) {
            $material = Material::find($this->material_id);
            if (!$material) {
                $this->dispatch('notify', message: 'Material not found!', type: 'error');
                return;
            }
            $material->update($data);
            $message = 'Material updated successfully!';
        } else {
            Material::create($data);
            $message = 'Material created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'material-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit material')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $material = Material::find($id);

        if (!$material) {
            $this->dispatch('notify', message: 'Material not found!', type: 'error');
            return;
        }

        $this->material_id = $material->id;
        $this->sap_code = $material->sap_code;
        $this->description = $material->description;
        $this->type = $material->type;
        $this->qty_first = $material->qty_first;
        $this->in = $material->in;
        $this->out = $material->out;
        $this->last_stock = $material->last_stock;
        $this->minimum_stock = $material->minimum_stock;
        $this->unit = $material->unit;
        $this->information = $material->information;
        $this->assign_request = $material->assign_request ?? 'Not Request';
        $this->qty_request = $material->qty_request;
        $this->remarks = $material->remarks;
        $this->consumable = $material->consumable ?? 'Weekly';
        $this->pic = $material->pic ?? [];
        $this->modalTitle = 'Edit Material';
    }

    public function viewDetail($id)
    {
        $this->selectedMaterial = Material::with('creator', 'updater')->find($id);
        $this->showDetailModal = true;
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete material')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $material = Material::find($id);

        if (!$material) {
            $this->dispatch('notify', message: 'Material not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $material;
        $this->dispatch('open-modal', 'delete-material-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete material')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $material = Material::find($this->detailToDelete->id);

        if (!$material) {
            $this->dispatch('notify', message: 'Material not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $sapCode = $material->sap_code ?? 'Unknown';
        $material->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Material '{$sapCode}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-material-modal');
    }

    public function cancelDelete()
    {
        $this->detailToDelete = null;
        $this->dispatch('close-modal', 'delete-material-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view material')) {
            abort(403, 'Unauthorized access.');
        }

        $materials = Material::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('sap_code', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhere('type', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterType, function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->filterConsumable, function ($query) {
                $query->where('consumable', $this->filterConsumable);
            })
            ->when($this->filterPic, function ($query) {
                $query->whereJsonContains('pic', $this->filterPic);
            })
            ->when($this->filterLowStock, function ($query) {
                $query->whereRaw('last_stock <= minimum_stock');
            })
            ->when($this->filterDateFrom, function ($query) {
                $query->whereDate('created_at', '>=', $this->filterDateFrom);
            })
            ->when($this->filterDateUntil, function ($query) {
                $query->whereDate('created_at', '<=', $this->filterDateUntil);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get unique values for filters
        $types = Material::select('type')->distinct()->pluck('type');

        return view('livewire.esd.stock.material-management', [
            'materials' => $materials,
            'types' => $types,
        ]);
    }
}