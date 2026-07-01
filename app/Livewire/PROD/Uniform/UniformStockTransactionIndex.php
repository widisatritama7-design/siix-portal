<?php

namespace App\Livewire\PROD\Uniform;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PROD\Uniform\UniformStockTransaction;
use Carbon\Carbon;

class UniformStockTransactionIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $transactionType = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $perPage = 10;

    protected $listeners = ['refreshTable' => '$refresh'];

    public function resetFilters()
    {
        $this->search = '';
        $this->transactionType = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedTransactionType()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    public function render()
    {
        if (!auth()->user()->can('view master uniform')) {
            abort(403, 'Unauthorized access.');
        }

        $query = UniformStockTransaction::with('uniform');

        // Search
        $query->when($this->search, function ($q) {
            $q->where(function ($query) {
                $query->where('description', 'like', '%' . $this->search . '%')
                    ->orWhere('reference_id', 'like', '%' . $this->search . '%')
                    ->orWhere('performed_by', 'like', '%' . $this->search . '%')
                    ->orWhereHas('uniform', function ($subQuery) {
                        $subQuery->where('item_code', 'like', '%' . $this->search . '%')
                            ->orWhere('description', 'like', '%' . $this->search . '%');
                    });
            });
        });

        // Filter by transaction type
        $query->when($this->transactionType, function ($q) {
            $q->where('transaction_type', $this->transactionType);
        });

        // Filter by date range
        $query->when($this->dateFrom, function ($q) {
            $q->whereDate('performed_at', '>=', $this->dateFrom);
        });

        $query->when($this->dateTo, function ($q) {
            $q->whereDate('performed_at', '<=', $this->dateTo);
        });

        $transactions = $query->orderBy('performed_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.prod.uniform.uniform-stock-transaction-index', [
            'transactions' => $transactions,
        ]);
    }
}