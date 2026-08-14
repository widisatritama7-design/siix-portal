<?php

namespace App\Livewire\ESD\Locker;

use App\Models\ESD\Locker;
use App\Models\ESD\UniformTransaction;
use Livewire\Component;

class AdminMonitoring extends Component
{
    public $lockers = [];
    public $transactions = [];
    public $selectedLocker = null;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->lockers = Locker::with(['employee', 'transactions' => function($query) {
            $query->latest()->limit(1);
        }])->get();

        $this->transactions = UniformTransaction::with(['employee', 'locker'])
            ->whereIn('status', ['pending', 'on_progress', 'waiting_pickup'])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
    }

    public function refreshData()
    {
        $this->loadData();
        $this->dispatch('refreshed');
    }

    public function getLockerStatusBadge($locker)
    {
        $statuses = [
            'available' => 'bg-green-100 text-green-800',
            'occupied' => 'bg-red-100 text-red-800',
            'maintenance' => 'bg-gray-100 text-gray-800'
        ];

        return $statuses[$locker->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getLockerStatusText($locker)
    {
        $texts = [
            'available' => 'Tersedia',
            'occupied' => 'Terisi',
            'maintenance' => 'Maintenance'
        ];

        return $texts[$locker->status] ?? $locker->status;
    }

    public function render()
    {
        $stats = [
            'total' => Locker::count(),
            'available' => Locker::available()->count(),
            'occupied' => Locker::occupied()->count(),
            'maintenance' => Locker::maintenance()->count(),
            'transactions_active' => UniformTransaction::whereIn('status', ['pending', 'on_progress', 'waiting_pickup'])->count()
        ];

        return view('livewire.esd.locker.admin-monitoring', [
            'stats' => $stats
        ]);
    }
}