<?php

namespace App\Livewire\HR\ComelateEmployee;

use App\Models\HR\ComelateEmployee;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class ComelateEmployeeManagement extends Component
{
    use WithPagination;
    
    // Properties untuk filter dan search
    public $search = '';
    public $departmentFilter = '';
    public $shiftFilter = '';
    public $dateFrom = '';
    public $dateUntil = '';
    public $yearFilter = '';
    public $monthFilter = '';
    public $reason_to_delete = '';
    public $deleteId = null;
    public $perPage = 10;
    public $showFilters = false;
    
    // Properties untuk view modal
    public $showViewModal = false;
    public $showDeleteModal = false;
    public $selectedComelate = null;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'departmentFilter' => ['except' => ''],
        'shiftFilter' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateUntil' => ['except' => ''],
        'yearFilter' => ['except' => ''],
        'monthFilter' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingDepartmentFilter()
    {
        $this->resetPage();
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
    
    protected function getQuery()
    {
        return ComelateEmployee::query()
            ->with(['employee', 'creator'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nik', 'like', '%' . $this->search . '%')
                      ->orWhere('name', 'like', '%' . $this->search . '%')
                      ->orWhere('department', 'like', '%' . $this->search . '%')
                      ->orWhere('nama_security', 'like', '%' . $this->search . '%')
                      ->orWhereHas('employee', function ($subQuery) {
                          $subQuery->where('name', 'like', '%' . $this->search . '%')
                                   ->orWhere('nik', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->departmentFilter, function ($query) {
                $query->where('department', $this->departmentFilter);
            })
            ->when($this->shiftFilter, function ($query) {
                $query->where('shift', $this->shiftFilter);
            })
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
            });
    }
    
    protected function getCurrentPageRecords()
    {
        return $this->getQuery()
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate($this->perPage);
    }
    
    // Generate CSV content as string
    protected function generateCsvContent($records)
    {
        ob_start();
        $file = fopen('php://output', 'w');
        
        fwrite($file, "\xEF\xBB\xBF");
        
        fputcsv($file, [
            'No', 'NIK', 'Name', 'Department', 'Status', 'Shift', 
            'Jam Masuk', 'Jam Datang', 'Terlambat (Menit)', 'Alasan Terlambat', 
            'Nama Security', 'Tanggal', 'Created At', 'Created By'
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
            
            $createdAt = '-';
            if ($record->created_at) {
                try {
                    $createdAt = Carbon::parse($record->created_at)->format('d-m-Y H:i');
                } catch (\Exception $e) {
                    $createdAt = '-';
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
                $createdAt,
                $record->creator->name ?? '-',
            ]);
        }
        
        fclose($file);
        return ob_get_clean();
    }
    
    // Export all current filtered data
    public function exportCurrentFiltered()
    {
        if (!auth()->user()->can('export comelate employee')) {
            $this->dispatch('notify', message: 'You do not have permission to export comelate employee!', type: 'error');
            return;
        }
        
        $records = $this->getQuery()->get();
        
        if ($records->isEmpty()) {
            $this->dispatch('notify', message: 'No data available to export.', type: 'warning');
            return;
        }
        
        $csvContent = $this->generateCsvContent($records);
        $fileName = 'data_keterlambatan_' . date('Y-m-d_H-i-s') . '.csv';
        
        $this->dispatch('download-csv', [
            'content' => $csvContent,
            'fileName' => $fileName
        ]);
    }
    
    public function getDepartmentsProperty()
    {
        return ComelateEmployee::select('department')
            ->distinct()
            ->whereNotNull('department')
            ->orderBy('department')
            ->pluck('department');
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
    
    public function formatCountJam($minutes)
    {
        if (!$minutes || $minutes == 0) {
            return '-';
        }
        
        if ($minutes >= 60) {
            $hours = floor($minutes / 60);
            $remainingMinutes = $minutes % 60;
            
            if ($remainingMinutes > 0) {
                return $hours . ' jam ' . $remainingMinutes . ' menit';
            }
            return $hours . ' jam';
        }
        
        return $minutes . ' menit';
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
    
    public function canEdit($createdAt)
    {
        if (!$createdAt) {
            return false;
        }
        $hoursDiff = Carbon::parse($createdAt)->diffInHours(now());
        return $hoursDiff <= 24;
    }
    
    public function view($id)
    {
        if (!auth()->user()->can('view comelate employee')) {
            $this->dispatch('notify', message: 'You do not have permission to view comelate employee!', type: 'error');
            return;
        }
        
        $this->selectedComelate = ComelateEmployee::with(['employee', 'creator', 'updater'])->findOrFail($id);
        $this->showViewModal = true;
    }
    
    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete comelate employee')) {
            $this->dispatch('notify', message: 'You do not have permission to delete comelate employee!', type: 'error');
            return;
        }
        
        $this->deleteId = $id;
        $this->reason_to_delete = '';
        $this->showDeleteModal = true;
    }
    
    public function delete()
    {
        if (!auth()->user()->can('delete comelate employee')) {
            $this->dispatch('notify', message: 'You do not have permission to delete comelate employee!', type: 'error');
            return;
        }
        
        $this->validate([
            'reason_to_delete' => 'required|min:5|max:500',
        ]);
        
        if (!$this->deleteId) {
            $this->dispatch('notify', message: 'No record selected for deletion.', type: 'error');
            return;
        }
        
        $comelate = ComelateEmployee::findOrFail($this->deleteId);
        
        $comelate->update([
            'deleted_by' => auth()->id(),
            'deleted_reason' => $this->reason_to_delete,
            'deleted_at' => now(),
        ]);
        
        $comelate->delete();
        
        session()->flash('message', 'Data deleted successfully.');
        $this->dispatch('notify', message: 'Data deleted successfully.', type: 'success');
        
        $this->showDeleteModal = false;
        $this->reset(['deleteId', 'reason_to_delete']);
        $this->resetPage();
    }
    
    public function checkEdit($id)
    {
        if (!auth()->user()->can('edit comelate employee')) {
            $this->dispatch('notify', message: 'You do not have permission to edit comelate employee!', type: 'error');
            return;
        }
        
        $record = ComelateEmployee::find($id);
        
        if (!$record) {
            session()->flash('error', 'Record not found.');
            return redirect()->route('hr.comelate.index');
        }
        
        if (!$this->canEdit($record->created_at)) {
            session()->flash('error', 'This record cannot be edited because it is more than 24 hours old.');
            return redirect()->route('hr.comelate.index');
        }
        
        return redirect()->route('hr.comelate.edit', $id);
    }
    
    public function clearFilters()
    {
        $this->reset(['search', 'departmentFilter', 'shiftFilter', 'dateFrom', 'dateUntil', 'yearFilter', 'monthFilter']);
        $this->resetPage();
    }
    
    public function closeDeleteModal()
    {
        $this->reset(['deleteId', 'reason_to_delete']);
        $this->dispatch('close-delete-modal');
    }
    
    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }
    
    public function render()
    {
        if (!auth()->user()->can('view comelate employee')) {
            abort(403, 'Unauthorized access.');
        }
        
        $comelateEmployees = $this->getCurrentPageRecords();
        
        $totalData = ComelateEmployee::count();
        $pendingCount = ComelateEmployee::where('status', 'Pending')->count();
        $approvedCount = ComelateEmployee::where('status', 'Approved')->count();
        $rejectedCount = ComelateEmployee::where('status', 'Rejected')->count();
        
        return view('livewire.hr.comelate-employee.index', [
            'comelateEmployees' => $comelateEmployees,
            'totalData' => $totalData,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
        ]);
    }
}