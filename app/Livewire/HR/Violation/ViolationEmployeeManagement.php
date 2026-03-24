<?php

namespace App\Livewire\HR\Violation;

use App\Models\HR\ViolationEmployee;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class ViolationEmployeeManagement extends Component
{
    use WithPagination;
    
    // Properties untuk filter dan search
    public $search = '';
    public $categoryFilter = '';
    public $shiftFilter = '';
    public $dateFrom = '';
    public $dateUntil = '';
    public $yearFilter = '';
    public $monthFilter = '';
    public $perPage = 10;
    
    // Properties untuk sub category filter
    public $selectedSubCategories = [];
    public $subCategoryOptions = [
        'Tidak Ada Stiker (SIM & STNK Lengkap)' => 'Tidak Ada Stiker (SIM & STNK Lengkap)',
        'Tidak membawa STNK/Tidak ada STNK' => 'Tidak membawa STNK/Tidak ada STNK',
        'STNK Expired' => 'STNK Expired',
        'Tidak membawa SIM/Tidak ada SIM' => 'Tidak membawa SIM/Tidak ada SIM',
        'SIM Expired' => 'SIM Expired',
        'Plat Kendaraan Mati' => 'Plat Kendaraan Mati',
        'Kendaraan tidak sesuai standar (cth. Tidak ada spion,tidak ada plat No dll)' => 'Kendaraan tidak sesuai standar',
    ];
    
    // Properties untuk view modal
    public $showViewModal = false;
    public $selectedViolation = null;
    public $showSubCategoryModal = false;
    public $selectedSubCategoriesModal = [];
    
    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'shiftFilter' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateUntil' => ['except' => ''],
        'yearFilter' => ['except' => ''],
        'monthFilter' => ['except' => ''],
        'perPage' => ['except' => 10],
        'selectedSubCategories' => ['except' => []],
    ];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingCategoryFilter()
    {
        $this->resetPage();
        // Reset sub categories when category changes
        if ($this->categoryFilter !== 'Kendaraan') {
            $this->selectedSubCategories = [];
        }
    }
    
    public function updatingShiftFilter()
    {
        $this->resetPage();
    }
    
    public function updatingDateFrom()
    {
        $this->resetPage();
    }
    
    public function updatingDateUntil()
    {
        $this->resetPage();
    }
    
    public function updatingYearFilter()
    {
        $this->resetPage();
    }
    
    public function updatingMonthFilter()
    {
        $this->resetPage();
    }
    
    public function updatingPerPage()
    {
        $this->resetPage();
    }
    
    public function updatingSelectedSubCategories()
    {
        $this->resetPage();
    }
    
    public function getCategoriesProperty()
    {
        return ViolationEmployee::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->orderBy('category')
            ->pluck('category');
    }
    
    public function getShiftsProperty()
    {
        return [
            'NS' => 'Non Shift',
            '1' => 'Shift 1',
            '2' => 'Shift 2',
            '3' => 'Shift 3',
        ];
    }
    
    public function getYearsProperty()
    {
        return ViolationEmployee::query()
            ->selectRaw('YEAR(date) as year')
            ->whereNotNull('date')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year', 'year');
    }
    
    public function getMonthsProperty()
    {
        return [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
    }
    
    public function getHasActiveFiltersProperty()
    {
        return !empty($this->categoryFilter) || 
               !empty($this->selectedSubCategories) || 
               !empty($this->shiftFilter) || 
               !empty($this->dateFrom) || 
               !empty($this->dateUntil) || 
               !empty($this->yearFilter) || 
               !empty($this->monthFilter);
    }
    
    public function getActiveFiltersCountProperty()
    {
        $count = 0;
        if (!empty($this->categoryFilter)) $count++;
        if (!empty($this->selectedSubCategories)) $count += count($this->selectedSubCategories);
        if (!empty($this->shiftFilter)) $count++;
        if (!empty($this->dateFrom)) $count++;
        if (!empty($this->dateUntil)) $count++;
        if (!empty($this->yearFilter)) $count++;
        if (!empty($this->monthFilter)) $count++;
        return $count;
    }
    
    public function formatShift($shift)
    {
        return match($shift) {
            'NS' => 'Non Shift',
            '1' => 'Shift 1',
            '2' => 'Shift 2',
            '3' => 'Shift 3',
            default => $shift,
        };
    }
    
    public function getSubCategoryCount($subCategory)
    {
        if (is_array($subCategory)) {
            return count($subCategory);
        }
        
        if (is_string($subCategory)) {
            $decoded = json_decode($subCategory, true);
            return is_array($decoded) ? count($decoded) : 0;
        }
        
        return 0;
    }
    
    public function getSubCategoryColor($count)
    {
        if ($count >= 5) return 'red';
        if ($count >= 3) return 'orange';
        return 'blue';
    }
    
    public function viewSubCategories($subCategories)
    {
        // If it's a string, decode it
        if (is_string($subCategories)) {
            $this->selectedSubCategoriesModal = json_decode($subCategories, true) ?? [];
        } else {
            $this->selectedSubCategoriesModal = $subCategories ?? [];
        }
        $this->showSubCategoryModal = true;
    }
    
    public function removeSubCategory($subCategory)
    {
        $this->selectedSubCategories = array_values(array_filter($this->selectedSubCategories, function($item) use ($subCategory) {
            return $item !== $subCategory;
        }));
        $this->resetPage();
    }
    
    public function view($id)
    {
        $this->selectedViolation = ViolationEmployee::with(['employee', 'creator', 'updater'])->findOrFail($id);
        $this->showViewModal = true;
    }
    
    public function create()
    {
        return redirect()->route('hr.violation.create');
    }
    
    public function edit($id)
    {
        return redirect()->route('hr.violation.edit', $id);
    }
    
    public function clearFilters()
    {
        $this->reset(['search', 'categoryFilter', 'shiftFilter', 'dateFrom', 'dateUntil', 'yearFilter', 'monthFilter', 'selectedSubCategories']);
        $this->resetPage();
    }
    
    public function render()
    {
        $violations = ViolationEmployee::query()
            ->with(['employee', 'creator', 'updater'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nik', 'like', '%' . $this->search . '%')
                      ->orWhere('name', 'like', '%' . $this->search . '%')
                      ->orWhere('dept', 'like', '%' . $this->search . '%')
                      ->orWhere('plat_motor', 'like', '%' . $this->search . '%')
                      ->orWhere('security_name', 'like', '%' . $this->search . '%')
                      ->orWhereHas('employee', function ($subQuery) {
                          $subQuery->where('name', 'like', '%' . $this->search . '%')
                                   ->orWhere('nik', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category', $this->categoryFilter);
            })
            ->when(!empty($this->selectedSubCategories), function ($query) {
                $query->where(function ($q) {
                    foreach ($this->selectedSubCategories as $subCat) {
                        $q->orWhereJsonContains('sub_category', $subCat);
                    }
                });
            })
            ->when($this->shiftFilter, function ($query) {
                $query->where('shift', $this->shiftFilter);
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('date', '>=', $this->dateFrom);
            })
            ->when($this->dateUntil, function ($query) {
                $query->whereDate('date', '<=', $this->dateUntil);
            })
            ->when($this->yearFilter, function ($query) {
                $query->whereYear('date', $this->yearFilter);
            })
            ->when($this->monthFilter, function ($query) {
                $query->whereMonth('date', $this->monthFilter);
            })
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        
        return view('livewire.hr.violation-employee.index', [
            'violations' => $violations,
        ]);
    }
}