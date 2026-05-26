<?php

namespace App\Livewire\PROD\Absence;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PROD\Absence\AbsenceReport;

class AbsenceReportIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $dateFrom = '';
    public $dateTo = '';

    protected $listeners = ['refreshTable' => '$refresh'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        // Check permission for delete
        if (!auth()->user()->can('delete absence report')) {
            $this->dispatch('notify', message: 'You do not have permission to delete!', type: 'error');
            return;
        }

        // If user has 'view absence report one user' (prioritized), only allow delete their own reports
        if (auth()->user()->can('view absence report one user')) {
            $report = AbsenceReport::where('id', $id)->where('created_by', auth()->user()->name)->first();
            if (!$report) {
                $this->dispatch('notify', message: 'You do not have permission to delete this report!', type: 'error');
                return;
            }
        }

        $report = AbsenceReport::find($id);
        
        if ($report && $report->status === 'draft') {
            $report->delete();
            $this->dispatch('notify', message: 'Report deleted successfully!');
        } else {
            $this->dispatch('notify', message: 'Cannot delete report that is already processed!', type: 'error');
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    public function render()
    {
        // Check permission for view
        if (!auth()->user()->can('view absence report') && !auth()->user()->can('view absence report one user')) {
            abort(403, 'Unauthorized access.');
        }

        $query = AbsenceReport::with('creator');

        // PRIORITAS: Jika user memiliki 'view absence report one user', maka hanya tampilkan data milik sendiri
        // (walaupun juga memiliki 'view absence report')
        if (auth()->user()->can('view absence report one user')) {
            $query->where('created_by', auth()->user()->name);
        }

        $reports = $query
            ->when($this->search, function ($query) {
                $query->where('report_number', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('created_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('created_at', '<=', $this->dateTo);
            })
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.prod.absence.absence-report-index', [
            'reports' => $reports,
        ]);
    }
}