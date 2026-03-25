<?php

namespace App\Livewire\HR\Violation;

use App\Models\HR\ViolationEmployee;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class ViolationReport extends Component
{
    public $dateFrom = '';
    public $dateUntil = '';
    public $yearFilter = '';
    public $monthFilter = '';
    public $departmentFilter = '';
    public $categoryFilter = '';
    
    public $previewData = [];
    public $totalRecords = 0;
    public $hasFiltered = false;
    
    // For sub category modal
    public $showSubCategoryModal = false;
    public $selectedSubCategoriesModal = [];
    
    // All sub categories for checklist
    protected $allSubCategories = [
        'Tidak Ada Stiker (SIM & STNK Lengkap)',
        'Tidak membawa STNK/Tidak ada STNK',
        'STNK Expired',
        'Tidak membawa SIM/Tidak ada SIM',
        'SIM Expired',
        'Plat Kendaraan Mati',
        'Kendaraan tidak sesuai standar (cth. Tidak ada spion,tidak ada plat No dll)',
    ];
    
    protected $rules = [
        'dateFrom' => 'nullable|date',
        'dateUntil' => 'nullable|date|after_or_equal:dateFrom',
        'yearFilter' => 'nullable|string',
        'monthFilter' => 'nullable|string',
        'departmentFilter' => 'nullable|string',
        'categoryFilter' => 'nullable|string',
    ];
    
    public function getDepartmentsProperty()
    {
        return ViolationEmployee::select('dept')
            ->distinct()
            ->whereNotNull('dept')
            ->orderBy('dept')
            ->pluck('dept');
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
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];
    }
    
    public function getCategoriesProperty()
    {
        return ViolationEmployee::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->orderBy('category')
            ->pluck('category');
    }
    
    public function getSubCategoryColor($count)
    {
        if ($count >= 5) return 'red';
        if ($count >= 3) return 'orange';
        return 'blue';
    }
    
    public function viewSubCategories($subCategories)
    {
        if (is_string($subCategories)) {
            $this->selectedSubCategoriesModal = json_decode($subCategories, true) ?? [];
        } else {
            $this->selectedSubCategoriesModal = $subCategories ?? [];
        }
        $this->showSubCategoryModal = true;
    }
    
    public function applyFilter()
    {
        $this->validate();
        $this->hasFiltered = true;
        $this->loadPreview();
        $this->dispatch('notify', message: 'Data found: ' . $this->totalRecords . ' records', type: 'success');
    }
    
    public function loadPreview()
    {
        $query = $this->getFilteredQuery();
        $this->totalRecords = $query->count();
        $this->previewData = $query->limit(20)->get();
    }
    
    protected function getFilteredQuery()
    {
        return ViolationEmployee::query()
            ->with(['employee', 'creator'])
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
            ->when($this->departmentFilter, function ($query) {
                $query->where('dept', $this->departmentFilter);
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category', $this->categoryFilter);
            })
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc');
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
    
    public function export()
    {
        $this->validate();
        
        if (!$this->hasFiltered) {
            $this->dispatch('notify', message: 'Please apply filter first.', type: 'warning');
            return;
        }
        
        $records = $this->getFilteredQuery()->get();
        
        if ($records->isEmpty()) {
            $this->dispatch('notify', message: 'No data available to export.', type: 'warning');
            return;
        }
        
        $fileName = 'laporan_violation_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
        
        $callback = function() use ($records) {
            $file = fopen('php://output', 'w');
            
            fwrite($file, "\xEF\xBB\xBF");
            
            fputcsv($file, [
                'No', 'NIK', 'Name', 'Department', 'Status', 'Shift', 'Category',
                'Tidak Ada Stiker (SIM & STNK Lengkap)',
                'Tidak membawa STNK/Tidak ada STNK',
                'STNK Expired',
                'Tidak membawa SIM/Tidak ada SIM',
                'SIM Expired',
                'Plat Kendaraan Mati',
                'Kendaraan tidak sesuai standar (cth. Tidak ada spion,tidak ada plat No dll)',
                'Plat Motor', 'Nama Security', 'Alasan', 'Remarks', 'Date Input', 'Date Actual', 'PIC'
            ]);
            
            $index = 0;
            foreach ($records as $record) {
                $index++;
                
                $statusCode = $record->employee->status ?? $record->status;
                $status = match((int)$statusCode) {
                    1 => 'Permanent',
                    2 => 'Contract',
                    3 => 'Magang',
                    default => 'Unknown',
                };
                
                $shiftText = match($record->shift) {
                    'NS' => 'Non Shift',
                    '1' => 'Shift 1',
                    '2' => 'Shift 2',
                    '3' => 'Shift 3',
                    default => $record->shift ?? '-',
                };
                
                $selectedSubCategories = $this->parseSubCategories($record->sub_category);
                
                $date = '-';
                if ($record->date) {
                    try {
                        $date = Carbon::parse($record->date)->format('d/m/Y');
                    } catch (\Exception $e) {
                        $date = '-';
                    }
                }
                
                $createdAt = '-';
                if ($record->created_at) {
                    try {
                        $createdAt = Carbon::parse($record->created_at)->format('d/m/Y H:i');
                    } catch (\Exception $e) {
                        $createdAt = '-';
                    }
                }
                
                $row = [
                    $index,
                    $record->employee->nik ?? $record->nik,
                    $record->employee->name ?? $record->name,
                    $record->employee->department ?? $record->dept,
                    $status,
                    $shiftText,
                    $record->category ?? '-',
                ];
                
                foreach ($this->allSubCategories as $subCat) {
                    $row[] = in_array($subCat, $selectedSubCategories) ? '✓' : '';
                }
                
                $row[] = $record->plat_motor ?? '-';
                $row[] = $record->security_name ?? '-';
                $row[] = $record->alasan ?? '-';
                $row[] = $record->remarks ?? '-';
                $row[] = $date;
                $row[] = $createdAt;
                $row[] = $record->creator->name ?? '-';
                
                fputcsv($file, $row);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
    
    public function resetFilters()
    {
        $this->reset(['dateFrom', 'dateUntil', 'yearFilter', 'monthFilter', 'departmentFilter', 'categoryFilter']);
        $this->hasFiltered = false;
        $this->previewData = [];
        $this->totalRecords = 0;
        $this->dispatch('notify', message: 'Filters reset', type: 'info');
    }
    
    public function render()
    {
        return view('livewire.hr.violation-employee.report', [
            'departments' => $this->departments,
            'years' => $this->years,
            'months' => $this->months,
            'categories' => $this->categories,
        ])->layout('layouts.app');
    }
}