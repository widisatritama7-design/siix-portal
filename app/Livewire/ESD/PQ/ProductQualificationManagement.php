<?php

namespace App\Livewire\ESD\PQ;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\PQ\ProductQualification;

class ProductQualificationManagement extends Component
{
    use WithPagination;

    public $pq_id;
    public $clause;
    public $control_item;

    public $search = '';
    public $modalTitle = 'Add New Product Qualification';
    public $pqToDelete = null;

    protected function rules()
    {
        return [
            'clause' => 'required|string|max:100',
            'control_item' => 'required|string|max:255',
        ];
    }

    protected $messages = [
        'clause.required' => 'Clause is required.',
        'clause.max' => 'Clause must not exceed 100 characters.',
        'control_item.required' => 'Control item is required.',
        'control_item.max' => 'Control item must not exceed 255 characters.',
    ];

    public function resetForm()
    {
        $this->reset(['pq_id', 'clause', 'control_item']);
        $this->modalTitle = 'Add New Product Qualification';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->pq_id) {
            if (!auth()->user()->can('edit pq')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create pq')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'clause' => $this->clause,
            'control_item' => $this->control_item,
        ];

        if ($this->pq_id) {
            $pq = ProductQualification::find($this->pq_id);
            if (!$pq) {
                $this->dispatch('notify', message: 'Product Qualification not found!', type: 'error');
                return;
            }

            $pq->update($data);
            $message = 'Product Qualification updated successfully!';
        } else {
            ProductQualification::create($data);
            $message = 'Product Qualification created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'pq-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit pq')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $pq = ProductQualification::find($id);

        if (!$pq) {
            $this->dispatch('notify', message: 'Product Qualification not found!', type: 'error');
            return;
        }

        $this->pq_id = $pq->id;
        $this->clause = $pq->clause;
        $this->control_item = $pq->control_item;
        $this->modalTitle = 'Edit Product Qualification';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete pq')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $pq = ProductQualification::find($id);

        if (!$pq) {
            $this->dispatch('notify', message: 'Product Qualification not found!', type: 'error');
            return;
        }

        $this->pqToDelete = $pq;
        $this->dispatch('open-modal', 'delete-pq-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete pq')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $pq = ProductQualification::find($this->pqToDelete->id);

        if (!$pq) {
            $this->dispatch('notify', message: 'Product Qualification not found!', type: 'error');
            $this->pqToDelete = null;
            return;
        }

        $clause = $pq->clause;
        $pq->delete();

        $this->pqToDelete = null;
        $this->dispatch('notify', message: "Product Qualification '{$clause}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-pq-modal');
    }

    public function cancelDelete()
    {
        $this->pqToDelete = null;
        $this->dispatch('close-modal', 'delete-pq-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view pq')) {
            abort(403, 'Unauthorized access.');
        }
    
        // Ambil semua data dan group berdasarkan clause
        $allQualifications = ProductQualification::with('creator')
            ->when($this->search, function ($query) {
                $query->where('clause', 'like', '%' . $this->search . '%')
                    ->orWhere('control_item', 'like', '%' . $this->search . '%');
            })
            ->orderBy('clause', 'asc')
            ->orderBy('control_item', 'asc')
            ->get();
    
        // Group berdasarkan clause
        $groupedQualifications = $allQualifications->groupBy('clause');
    
        // Urutkan berdasarkan jumlah item terbanyak ke paling sedikit
        // Jika jumlah sama, urutkan berdasarkan clause alphabetically
        $groupedQualifications = $groupedQualifications->sortByDesc(function ($items, $clause) {
            return $items->count();
        })->sort(function ($a, $b) {
            // Jika jumlah sama, urutkan berdasarkan clause
            if ($a->count() == $b->count()) {
                return strcmp($a->first()->clause, $b->first()->clause);
            }
            // Urutkan berdasarkan jumlah descending
            return $b->count() <=> $a->count();
        });
    
        return view('livewire.esd.pq.product-qualification-management', [
            'groupedQualifications' => $groupedQualifications,
        ]);
    }
}