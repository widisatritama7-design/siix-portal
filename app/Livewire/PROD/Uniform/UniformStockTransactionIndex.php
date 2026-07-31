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
    public $uniformStatus = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $perPage = 10;

    protected $listeners = ['refreshTable' => '$refresh'];

    public function resetFilters()
    {
        $this->search = '';
        $this->transactionType = '';
        $this->uniformStatus = '';
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

    public function updatedUniformStatus()
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

    // Method untuk mendapatkan query dengan filter yang sama
    private function getFilteredQuery()
    {
        $query = UniformStockTransaction::with('uniform');

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

        $query->when($this->transactionType, function ($q) {
            $q->where('transaction_type', $this->transactionType);
        });

        $query->when($this->uniformStatus, function ($q) {
            $q->whereHas('uniform', function ($subQuery) {
                $subQuery->where('status', $this->uniformStatus);
            });
        });

        $query->when($this->dateFrom, function ($q) {
            $q->whereDate('performed_at', '>=', $this->dateFrom);
        });

        $query->when($this->dateTo, function ($q) {
            $q->whereDate('performed_at', '<=', $this->dateTo);
        });

        return $query;
    }

    // Method untuk export CSV (opsional)
    public function exportCsv()
    {
        if (!auth()->user()->can('view master uniform')) {
            abort(403, 'Unauthorized access.');
        }

        $query = $this->getFilteredQuery();
        $transactions = $query->orderBy('performed_at', 'desc')->get();

        $filename = 'stock_transactions_' . Carbon::now()->format('Ymd_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($transactions) {
            $handle = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($handle, [
                'Date & Time',
                'Item Code',
                'Description',
                'Size',
                'Status',
                'Type',
                'Change',
                'Before',
                'After',
                'Description',
                'Performed By',
                'Reference ID'
            ]);

            // Data
            foreach ($transactions as $transaction) {
                fputcsv($handle, [
                    Carbon::parse($transaction->performed_at)->format('d/m/Y H:i'),
                    $transaction->uniform->item_code ?? '-',
                    $transaction->uniform->description ?? '-',
                    $transaction->uniform->size ?? '-',
                    $transaction->uniform->status ?? '-',
                    $transaction->transaction_type,
                    ($transaction->qty_change >= 0 ? '+' : '') . $transaction->qty_change,
                    $transaction->qty_before,
                    $transaction->qty_after,
                    $transaction->description ?? '-',
                    $transaction->performed_by ?? '-',
                    $transaction->reference_id ?? '-'
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function render()
    {
        if (!auth()->user()->can('view master uniform')) {
            abort(403, 'Unauthorized access.');
        }

        $query = $this->getFilteredQuery();
        $transactions = $query->orderBy('performed_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.prod.uniform.uniform-stock-transaction-index', [
            'transactions' => $transactions,
        ]);
    }
}