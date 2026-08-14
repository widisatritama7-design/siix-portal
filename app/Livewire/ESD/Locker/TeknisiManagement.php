<?php

namespace App\Livewire\ESD\Locker;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Locker\Locker;
use App\Models\ESD\Locker\UniformTransaction;

class TeknisiManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $showDetail = false;
    public $selectedTransaction = null;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function viewDetail($id)
    {
        $this->selectedTransaction = UniformTransaction::with(['employee', 'locker'])
            ->find($id);

        if (!$this->selectedTransaction) {
            $this->dispatch('notify', message: 'Transaksi tidak ditemukan!', type: 'error');
            return;
        }

        $this->showDetail = true;
        $this->dispatch('open-modal', 'transaction-detail-modal');
    }

    public function render()
    {
        $transactions = UniformTransaction::with(['employee', 'locker'])
            ->when($this->search, function ($query) {
                $query->whereHas('employee', function($q) {
                    $q->where('nik', 'like', '%' . $this->search . '%')
                      ->orWhere('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $statusCounts = [
            'pending' => UniformTransaction::where('status', 'pending')->count(),
            'on_progress' => UniformTransaction::where('status', 'on_progress')->count(),
            'waiting_pickup' => UniformTransaction::where('status', 'waiting_pickup')->count(),
            'completed' => UniformTransaction::where('status', 'completed')->count()
        ];

        return view('livewire.esd.locker.teknisi-management', [
            'transactions' => $transactions,
            'statusCounts' => $statusCounts
        ]);
    }
}