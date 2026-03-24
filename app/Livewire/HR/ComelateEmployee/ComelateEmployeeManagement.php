<?php

namespace App\Livewire\HR\ComelateEmployee;

use App\Models\HR\ComelateEmployee;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class ComelateEmployeeManagement extends Component
{
    use WithPagination;
    
    // Properties untuk filter dan search (index)
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
    
    // Properties untuk view modal
    public $showViewModal = false;
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
    
    // Reset page when filters change
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
    
    // Get years for filter
    public function getYearsProperty()
    {
        return ComelateEmployee::query()
            ->selectRaw('YEAR(tanggal) as year')
            ->whereNotNull('tanggal')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year', 'year');
    }
    
    // Get months for filter
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
    
    // Format count_jam to readable string
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
    
    // Format shift display
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
    
    // Check if record can be edited (within 24 hours)
    public function canEdit($createdAt)
    {
        if (!$createdAt) {
            return false;
        }
        $hoursDiff = Carbon::parse($createdAt)->diffInHours(now());
        return $hoursDiff <= 24;
    }
    
    // Open view modal
    public function view($id)
    {
        $this->selectedComelate = ComelateEmployee::with(['employee', 'creator', 'updater'])->findOrFail($id);
        $this->showViewModal = true;
    }
    
    // Confirm delete - open modal with reason
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->reason_to_delete = '';
        $this->dispatch('open-delete-modal', ['id' => $id]);
    }
    
    // Delete data with reason
    public function delete()
    {
        $this->validate([
            'reason_to_delete' => 'required|min:5|max:500',
        ]);
        
        if (!$this->deleteId) {
            $this->dispatch('notify', message: 'No record selected for deletion.', type: 'error');
            return;
        }
        
        $comelate = ComelateEmployee::findOrFail($this->deleteId);
        
        // Store deletion reason and who deleted it
        $comelate->update([
            'deleted_by' => auth()->id(),
            'deleted_reason' => $this->reason_to_delete,
            'deleted_at' => now(),
        ]);
        
        $comelate->delete();
        
        session()->flash('message', 'Data deleted successfully.');
        $this->dispatch('notify', message: 'Data deleted successfully.', type: 'success');
        $this->dispatch('close-delete-modal'); // Ini yang menutup modal
        
        // Reset properties
        $this->reset(['deleteId', 'reason_to_delete']);
        $this->resetPage();
    }
    
    // Check if record can be edited before redirecting
    public function checkEdit($id)
    {
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
    
    // Clear filters
    public function clearFilters()
    {
        $this->reset(['search', 'departmentFilter', 'shiftFilter', 'dateFrom', 'dateUntil', 'yearFilter', 'monthFilter']);
        $this->resetPage();
    }
    
    // Close delete modal
    public function closeDeleteModal()
    {
        $this->reset(['deleteId', 'reason_to_delete']);
        $this->dispatch('close-delete-modal');
    }
    
    public function render()
    {
        $comelateEmployees = ComelateEmployee::query()
            ->with(['employee', 'creator', 'updater'])
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
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate($this->perPage);
        
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