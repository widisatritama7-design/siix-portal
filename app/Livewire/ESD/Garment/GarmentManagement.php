<?php

namespace App\Livewire\ESD\Garment;

use App\Models\ESD\Garment\Garment;
use App\Models\ESD\Garment\GarmentDetail;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class GarmentManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $departmentFilter = '';
    public $statusFilter = '';
    public $scheduleFilter = ''; // 'this_week', 'custom_range'
    public $dateFrom = '';
    public $dateTo = '';
    public $perPage = 10;
    
    public $statusOptions = [
        1 => 'Permanent',
        2 => 'Contract',
        3 => 'Magang',
    ];
    
    public $scheduleOptions = [
        '' => 'All Schedules',
        'this_week' => 'Jadwal Minggu Ini',
        'custom_range' => 'Custom Date Range',
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
            
        // Set default date range for current week
        $this->setDefaultDateRange();
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

    public function updatedScheduleFilter()
    {
        if ($this->scheduleFilter === 'this_week') {
            $this->setDefaultDateRange();
        } elseif ($this->scheduleFilter === '') {
            $this->dateFrom = '';
            $this->dateTo = '';
        }
        $this->resetPage();
    }
    
    public function updatedDateFrom()
    {
        if ($this->dateFrom && $this->scheduleFilter !== 'custom_range') {
            $this->scheduleFilter = 'custom_range';
        }
        $this->resetPage();
    }
    
    public function updatedDateTo()
    {
        if ($this->dateTo && $this->scheduleFilter !== 'custom_range') {
            $this->scheduleFilter = 'custom_range';
        }
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }
    
    protected function setDefaultDateRange()
    {
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SATURDAY);
        
        $this->dateFrom = $startOfWeek->format('Y-m-d');
        $this->dateTo = $endOfWeek->format('Y-m-d');
    }
    
    protected function applyScheduleFilter($query)
    {
        if ($this->scheduleFilter === 'this_week' && $this->dateFrom && $this->dateTo) {
            // Filter untuk jadwal minggu ini
            $niks = GarmentDetail::whereBetween('next_date', [
                    $this->dateFrom,
                    $this->dateTo
                ])
                ->pluck('nik')
                ->toArray();
                
            if (!empty($niks)) {
                $query->whereIn('id', $niks);
            } else {
                // Jika tidak ada data, return empty result
                $query->whereRaw('1 = 0');
            }
        } elseif ($this->scheduleFilter === 'custom_range' && $this->dateFrom && $this->dateTo) {
            // Filter untuk custom date range
            $niks = GarmentDetail::whereBetween('next_date', [
                    $this->dateFrom,
                    $this->dateTo
                ])
                ->pluck('nik')
                ->toArray();
                
            if (!empty($niks)) {
                $query->whereIn('id', $niks);
            } else {
                $query->whereRaw('1 = 0');
            }
        }
        
        return $query;
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->departmentFilter = '';
        $this->statusFilter = '';
        $this->scheduleFilter = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->perPage = 10;
        $this->resetPage();
    }
    
    public function applyDateRange()
    {
        if ($this->dateFrom && $this->dateTo) {
            $this->scheduleFilter = 'custom_range';
            $this->resetPage();
        }
    }
    
    public function clearDateRange()
    {
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->scheduleFilter = '';
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
            ->when($this->scheduleFilter || ($this->dateFrom && $this->dateTo), function ($query) {
                $this->applyScheduleFilter($query);
            })
            ->orderBy('department', 'asc')
            ->orderBy('nik', 'asc')
            ->paginate($this->perPage);

        return view('livewire.esd.garment.garment-management', [
            'garments' => $garments,
            'departments' => $this->departments,
            'statusOptions' => $this->statusOptions,
            'scheduleOptions' => $this->scheduleOptions,
        ]);
    }
}