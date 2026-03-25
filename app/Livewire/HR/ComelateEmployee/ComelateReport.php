<?php

namespace App\Livewire\HR\ComelateEmployee;

use App\Models\HR\ComelateEmployee;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class ComelateReport extends Component
{
    public $dateFrom = '';
    public $dateUntil = '';
    public $yearFilter = '';
    public $monthFilter = '';
    public $departmentFilter = '';
    
    public $previewData = [];
    public $totalRecords = 0;
    public $hasFiltered = false;
    
    protected $rules = [
        'dateFrom' => 'nullable|date',
        'dateUntil' => 'nullable|date|after_or_equal:dateFrom',
        'yearFilter' => 'nullable|string',
        'monthFilter' => 'nullable|string',
        'departmentFilter' => 'nullable|string',
    ];
    
    public function getDepartmentsProperty()
    {
        return ComelateEmployee::select('department')
            ->distinct()
            ->whereNotNull('department')
            ->orderBy('department')
            ->pluck('department');
    }
    
    public function getYearsProperty()
    {
        return ComelateEmployee::query()
            ->selectRaw('YEAR(tanggal) as year')
            ->whereNotNull('tanggal')
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
        return ComelateEmployee::query()
            ->with(['employee'])
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('tanggal', '>=', $this->dateFrom);
            })
            ->when($this->dateUntil, function ($query) {
                $query->whereDate('tanggal', '<=', $this->dateUntil);
            })
            ->when($this->yearFilter, function ($query) {
                $query->whereYear('tanggal', $this->yearFilter);
            })
            ->when($this->monthFilter, function ($query) {
                $query->whereMonth('tanggal', $this->monthFilter);
            })
            ->when($this->departmentFilter, function ($query) {
                $query->where('department', $this->departmentFilter);
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc');
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
        
        $fileName = 'laporan_keterlambatan_' . date('Y-m-d_H-i-s') . '.csv';
        
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
                'No', 'NIK', 'Name', 'Department', 'Status', 'Shift', 
                'Schedule In', 'Actual In', 'Late (Minutes)', 'Reason', 
                'Security Name', 'Date'
            ]);
            
            $index = 0;
            foreach ($records as $record) {
                $index++;
                
                // Format status
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
                
                $jamMasuk = $record->jam_masuk ?: '-';
                
                $jamDatang = '-';
                if ($record->jam) {
                    try {
                        $jamDatang = Carbon::parse($record->jam)->format('H:i');
                    } catch (\Exception $e) {
                        $jamDatang = '-';
                    }
                }
                
                $tanggal = '-';
                if ($record->tanggal) {
                    try {
                        $tanggal = Carbon::parse($record->tanggal)->format('d/m/Y');
                    } catch (\Exception $e) {
                        $tanggal = '-';
                    }
                }
                
                fputcsv($file, [
                    $index,
                    $record->employee->nik ?? $record->nik,
                    $record->employee->name ?? $record->name,
                    $record->employee->department ?? $record->department,
                    $status,
                    $shiftText,
                    $jamMasuk,
                    $jamDatang,
                    $record->count_jam ?: 0,
                    $record->alasan_terlambat ?: '-',
                    $record->nama_security ?: '-',
                    $tanggal,
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
    
    public function resetFilters()
    {
        $this->reset(['dateFrom', 'dateUntil', 'yearFilter', 'monthFilter', 'departmentFilter']);
        $this->hasFiltered = false;
        $this->previewData = [];
        $this->totalRecords = 0;
        $this->dispatch('notify', message: 'Filters reset', type: 'info');
    }
    
    public function render()
    {
        return view('livewire.hr.comelate-employee.report', [
            'departments' => $this->departments,
            'years' => $this->years,
            'months' => $this->months,
        ])->layout('layouts.app');
    }
}