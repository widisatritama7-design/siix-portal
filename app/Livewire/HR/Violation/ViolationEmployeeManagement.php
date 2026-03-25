<?php

namespace App\Livewire\HR\Violation;

use App\Models\HR\ViolationEmployee;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

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
    public $showFilters = false;
    public $deleteId = null;
    public $showDeleteModal = false;
    
    // Export date range
    public $exportDateFrom = '';
    public $exportDateUntil = '';
    public $showExportModal = false;
    
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
    
    protected function getQuery()
    {
        return ViolationEmployee::query()
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
            });
    }
    
    // Export with date range
    public function exportWithDateRange()
    {
        if (!auth()->user()->can('export violation employee')) {
            $this->dispatch('notify', message: 'You do not have permission to export violation employee!', type: 'error');
            return;
        }
        
        $this->validate([
            'exportDateFrom' => 'required|date',
            'exportDateUntil' => 'required|date|after_or_equal:exportDateFrom',
        ]);
        
        $records = ViolationEmployee::with(['employee', 'creator'])
            ->whereDate('date', '>=', $this->exportDateFrom)
            ->whereDate('date', '<=', $this->exportDateUntil)
            ->orderBy('date', 'asc')
            ->get();
        
        if ($records->isEmpty()) {
            $this->dispatch('notify', message: 'No data available for the selected date range.', type: 'warning');
            $this->showExportModal = false;
            return;
        }
        
        $this->showExportModal = false;
        
        $fileName = 'violation_' . $this->exportDateFrom . '_to_' . $this->exportDateUntil . '_' . date('Y-m-d') . '.csv';
        
        return response()->streamDownload(function() use ($records) {
            $this->generateCSVContent($records);
        }, $fileName, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
    
    // Export all filtered data
    public function exportCurrentFiltered()
    {
        if (!auth()->user()->can('export violation employee')) {
            $this->dispatch('notify', message: 'You do not have permission to export violation employee!', type: 'error');
            return;
        }
        
        $records = $this->getQuery()->get();
        
        if ($records->isEmpty()) {
            $this->dispatch('notify', message: 'No data available to export.', type: 'warning');
            return;
        }
        
        $fileName = 'violation_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        return response()->streamDownload(function() use ($records) {
            $this->generateCSVContent($records);
        }, $fileName, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
    
    // Generate CSV content
    protected function generateCSVContent($records)
    {
        $output = fopen('php://output', 'w');
        
        // Add UTF-8 BOM for Excel
        fwrite($output, "\xEF\xBB\xBF");
        
        // Headers
        fputcsv($output, [
            'No', 'NIK', 'Name', 'Department', 'Status', 'Shift', 'Category',
            'Tidak Ada Stiker', 'Tidak membawa STNK', 'STNK Expired',
            'Tidak membawa SIM', 'SIM Expired', 'Plat Kendaraan Mati',
            'Kendaraan Tidak Sesuai', 'Plat Motor', 'Nama Security',
            'Alasan', 'Remarks', 'Tanggal Kejadian', 'Created At', 'Created By'
        ]);
        
        $index = 0;
        foreach ($records as $record) {
            $index++;
            
            // Status mapping
            $statusCode = $record->employee->status ?? $record->status ?? null;
            $status = match((int)$statusCode) {
                1 => 'Permanent',
                2 => 'Contract',
                3 => 'Magang',
                default => 'Unknown',
            };
            
            // Shift mapping
            $shiftText = match($record->shift) {
                'NS' => 'Non Shift',
                '1' => 'Shift 1',
                '2' => 'Shift 2',
                '3' => 'Shift 3',
                default => $record->shift ?? '-',
            };
            
            // Parse sub categories
            $subCategories = $this->parseSubCategories($record->sub_category);
            
            // Check sub categories
            $hasNoStiker = in_array('Tidak Ada Stiker (SIM & STNK Lengkap)', $subCategories) ? '✓' : '';
            $hasNoStnk = in_array('Tidak membawa STNK/Tidak ada STNK', $subCategories) ? '✓' : '';
            $hasStnkExpired = in_array('STNK Expired', $subCategories) ? '✓' : '';
            $hasNoSim = in_array('Tidak membawa SIM/Tidak ada SIM', $subCategories) ? '✓' : '';
            $hasSimExpired = in_array('SIM Expired', $subCategories) ? '✓' : '';
            $hasPlatMati = in_array('Plat Kendaraan Mati', $subCategories) ? '✓' : '';
            $hasKendaraanTidakSesuai = in_array('Kendaraan tidak sesuai standar (cth. Tidak ada spion,tidak ada plat No dll)', $subCategories) ? '✓' : '';
            
            // Format date
            $tanggalKejadian = $record->date ? Carbon::parse($record->date)->format('d/m/Y') : '-';
            $createdAt = $record->created_at ? Carbon::parse($record->created_at)->format('d-m-Y H:i') : '-';
            
            fputcsv($output, [
                $index,
                $record->employee->nik ?? $record->nik,
                $record->employee->name ?? $record->name,
                $record->employee->department ?? $record->dept,
                $status,
                $shiftText,
                $record->category ?? '-',
                $hasNoStiker,
                $hasNoStnk,
                $hasStnkExpired,
                $hasNoSim,
                $hasSimExpired,
                $hasPlatMati,
                $hasKendaraanTidakSesuai,
                $record->plat_motor ?? '-',
                $record->security_name ?? '-',
                $record->alasan ?? '-',
                $record->remarks ?? '-',
                $tanggalKejadian,
                $createdAt,
                $record->creator->name ?? '-',
            ]);
        }
        
        fclose($output);
    }
    
    protected function parseSubCategories($subCategory)
    {
        if (empty($subCategory)) {
            return [];
        }
        
        if (is_array($subCategory)) {
            return $subCategory;
        }
        
        $decoded = json_decode($subCategory, true);
        if (is_array($decoded)) {
            return $decoded;
        }
        
        return [];
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
        if (!auth()->user()->can('view violation employee')) {
            $this->dispatch('notify', message: 'You do not have permission to view violation employee!', type: 'error');
            return;
        }
        
        if (is_string($subCategories)) {
            $this->selectedSubCategoriesModal = json_decode($subCategories, true) ?? [];
        } else {
            $this->selectedSubCategoriesModal = $subCategories ?? [];
        }
        $this->showSubCategoryModal = true;
    }
    
    public function view($id)
    {
        if (!auth()->user()->can('view violation employee')) {
            $this->dispatch('notify', message: 'You do not have permission to view violation employee!', type: 'error');
            return;
        }
        
        $this->selectedViolation = ViolationEmployee::with(['employee', 'creator', 'updater'])->findOrFail($id);
        $this->showViewModal = true;
    }
    
    public function create()
    {
        if (!auth()->user()->can('create violation employee')) {
            $this->dispatch('notify', message: 'You do not have permission to create violation employee!', type: 'error');
            return;
        }
        
        return redirect()->route('hr.violation.create');
    }
    
    public function edit($id)
    {
        if (!auth()->user()->can('edit violation employee')) {
            $this->dispatch('notify', message: 'You do not have permission to edit violation employee!', type: 'error');
            return;
        }
        
        return redirect()->route('hr.violation.edit', $id);
    }
    
    public function clearFilters()
    {
        $this->reset(['search', 'categoryFilter', 'shiftFilter', 'dateFrom', 'dateUntil', 'yearFilter', 'monthFilter', 'selectedSubCategories']);
        $this->resetPage();
    }
    
    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }
    
    public function openExportModal()
    {
        $this->exportDateFrom = '';
        $this->exportDateUntil = '';
        $this->showExportModal = true;
    }
    
    public function closeExportModal()
    {
        $this->showExportModal = false;
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete violation employee')) {
            $this->dispatch('notify', message: 'You do not have permission to delete violation employee!', type: 'error');
            return;
        }
        
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if (!auth()->user()->can('delete violation employee')) {
            $this->dispatch('notify', message: 'You do not have permission to delete violation employee!', type: 'error');
            return;
        }
        
        if (!$this->deleteId) {
            $this->dispatch('notify', message: 'No record selected for deletion.', type: 'error');
            return;
        }
        
        $violation = ViolationEmployee::findOrFail($this->deleteId);
        
        // Delete photo if exists
        if ($violation->photo) {
            \Storage::disk('public')->delete($violation->photo);
        }
        
        $violation->delete();
        
        session()->flash('message', 'Data deleted successfully.');
        $this->dispatch('notify', message: 'Data deleted successfully.', type: 'success');
        
        $this->showDeleteModal = false;
        $this->reset(['deleteId']);
        $this->resetPage();
    }
    
    public function render()
    {
        if (!auth()->user()->can('view violation employee')) {
            abort(403, 'Unauthorized access.');
        }
        
        $violations = $this->getQuery()
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        
        return view('livewire.hr.violation-employee.index', [
            'violations' => $violations,
        ]);
    }
}