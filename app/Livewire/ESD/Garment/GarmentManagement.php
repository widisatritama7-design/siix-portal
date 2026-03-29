<?php

namespace App\Livewire\ESD\Garment;

use App\Models\ESD\Garment\Garment;
use Livewire\Component;
use Livewire\WithPagination;

class GarmentManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $departmentFilter = '';
    public $statusFilter = '';
    public $perPage = 10;
    
    public $statusOptions = [
        1 => 'Permanent',
        2 => 'Contract',
        3 => 'Magang',
    ];
    
    public $departments = [];

    public function mount()
    {
        // Ambil list department unik dari database
        $this->departments = Garment::whereIn('status', [1, 2, 3])
            ->whereNotNull('department')
            ->distinct()
            ->pluck('department')
            ->toArray();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedDepartmentFilter()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->departmentFilter = '';
        $this->statusFilter = '';
        $this->perPage = 10;
        $this->resetPage();
    }

    public function render()
    {
        if (!auth()->user()->can('view garment')) {
            abort(403, 'Unauthorized access.');
        }

        $garments = Garment::query()
            ->whereIn('status', [1, 2, 3]) // Hanya menampilkan status 1,2,3
            ->when($this->departmentFilter, function ($query) {
                $query->where('department', $this->departmentFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nik', 'like', '%' . $this->search . '%')
                        ->orWhere('name', 'like', '%' . $this->search . '%')
                        ->orWhere('department', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('department', 'asc')
            ->orderBy('nik', 'asc')
            ->paginate($this->perPage);

        return view('livewire.esd.garment.garment-management', [
            'garments' => $garments,
            'departments' => $this->departments,
            'statusOptions' => $this->statusOptions,
        ]);
    }
}