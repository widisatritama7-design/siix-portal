<?php

namespace App\Livewire\QAQC\ScanXray;

use App\Models\MTC\Master\MasterLine;
use App\Models\QAQC\BlindTest\Customer;
use App\Models\QAQC\BlindTest\Model as BlindTestModel;
use App\Models\QAQC\ScanXray\ScanXray;
use Livewire\Component;
use Livewire\WithPagination;

class ScanXrayIndex extends Component
{
    use WithPagination;

    // ============ SEARCH & FILTER ============
    public $search = '';

    public $filterCustomerId = null;
    public $filterModelId = null;
    public $filterDateFrom = null;
    public $filterDateUntil = null;
    public $filterYear = null;
    public $filterMonth = null;
    public $filterMasterLineId = null;

    // ============ DELETE ============
    public $scanToDelete = null;

    // Reset pagination saat filter berubah
    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedFilterCustomerId(): void
    {
        $this->filterModelId = null;
        $this->resetPage();
    }
    public function updatedFilterModelId(): void { $this->resetPage(); }
    public function updatedFilterDateFrom(): void { $this->resetPage(); }
    public function updatedFilterDateUntil(): void { $this->resetPage(); }
    public function updatedFilterYear(): void { $this->resetPage(); }
    public function updatedFilterMonth(): void { $this->resetPage(); }
    public function updatedFilterMasterLineId(): void { $this->resetPage(); }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->filterCustomerId = null;
        $this->filterModelId = null;
        $this->filterDateFrom = null;
        $this->filterDateUntil = null;
        $this->filterYear = null;
        $this->filterMonth = null;
        $this->filterMasterLineId = null;
        $this->resetPage();
    }

    public function hasActiveFilter(): bool
    {
        return $this->search
            || $this->filterCustomerId
            || $this->filterModelId
            || $this->filterDateFrom
            || $this->filterDateUntil
            || $this->filterYear
            || $this->filterMonth
            || $this->filterMasterLineId;
    }

    // ============ SUMMARY ============
    /**
     * Hitung summary dari 3 grup (first, middle, last) untuk 1 scan.
     * Return array: first, middle, last, total.
     */
    public function buildSummary(ScanXray $scan): array
    {
        $groups = [
            'first'  => $scan->first_piece_items  ?? [],
            'middle' => $scan->middle_piece_items ?? [],
            'last'   => $scan->last_piece_items   ?? [],
        ];

        $summary = [];
        $totalOk = 0;
        $totalNg = 0;

        foreach ($groups as $key => $item) {
            $ok = (int) ($item['ok_qty'] ?? 0);
            $ng = (int) ($item['ng_qty'] ?? 0);
            $total = $ok + $ng;
            $rejectRate = $total > 0 ? round(($ng / $total) * 100, 2) : 0;

            $summary[$key] = [
                'ok_qty'         => $ok,
                'ng_qty'         => $ng,
                'reject_rate'    => $rejectRate,
                'status_running' => $item['status_running'] ?? null,
            ];

            $totalOk += $ok;
            $totalNg += $ng;
        }

        $grandTotal = $totalOk + $totalNg;
        $summary['total'] = [
            'ok_qty'      => $totalOk,
            'ng_qty'      => $totalNg,
            'reject_rate' => $grandTotal > 0 ? round(($totalNg / $grandTotal) * 100, 2) : 0,
        ];

        return $summary;
    }

    // ============ DELETE ============
    public function confirmDelete($id): void
    {
        if (!auth()->user()->can('delete scan xray')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $this->scanToDelete = ScanXray::find($id);
        if (!$this->scanToDelete) {
            $this->dispatch('notify', message: 'Data not found!', type: 'error');
            return;
        }

        $this->dispatch('open-modal-delete');
    }

    public function delete(): void
    {
        if (!auth()->user()->can('delete scan xray')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        if ($this->scanToDelete) {
            ScanXray::find($this->scanToDelete->id)?->delete();
            $this->dispatch('notify', message: 'Scan X-Ray deleted successfully!');
        }

        $this->scanToDelete = null;
        $this->dispatch('close-modal-delete');
    }

    public function cancelDelete(): void
    {
        $this->scanToDelete = null;
        $this->dispatch('close-modal-delete');
    }

    // ============ RENDER ============
    public function render()
    {
        if (!auth()->user()->can('view scan xray')) {
            abort(403, 'Unauthorized access.');
        }

        $query = ScanXray::with(['customer', 'model', 'masterLine.location', 'creator']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('customer', fn ($qq) => $qq->where('customer_name', 'like', '%' . $this->search . '%'))
                  ->orWhereHas('model', fn ($qq) => $qq->where('model_name', 'like', '%' . $this->search . '%'))
                  ->orWhere('shift', 'like', '%' . $this->search . '%')
                  ->orWhere('group', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterCustomerId) {
            $query->where('customer_id', $this->filterCustomerId);
        }

        if ($this->filterModelId) {
            $query->where('model_id', $this->filterModelId);
        }

        if ($this->filterDateFrom) {
            $query->whereDate('created_at', '>=', $this->filterDateFrom);
        }

        if ($this->filterDateUntil) {
            $query->whereDate('created_at', '<=', $this->filterDateUntil);
        }

        if ($this->filterYear) {
            $query->whereYear('created_at', $this->filterYear);
        }

        if ($this->filterMonth) {
            $query->whereMonth('created_at', $this->filterMonth);
        }

        if ($this->filterMasterLineId) {
            $query->where('master_line_id', $this->filterMasterLineId);
        }

        $customers = Customer::orderBy('customer_name')->get();
        $models = $this->filterCustomerId
            ? BlindTestModel::where('customer_id', $this->filterCustomerId)->orderBy('model_name')->get()
            : collect();
        $masterLines = MasterLine::with('location')
            ->join('tb_mtc_master_locations as loc', 'loc.id', '=', 'tb_mtc_master_lines.location_id')
            ->orderBy('loc.location_name', 'asc')
            ->orderBy('tb_mtc_master_lines.line_number', 'asc')
            ->select('tb_mtc_master_lines.*')
            ->get();

        $currentYear = (int) now()->format('Y');
        $years = range($currentYear, $currentYear - 4);

        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
        ];

        return view('livewire.qaqc.scan-xray.scan-xray-index', [
            'scans'       => $query->orderByDesc('id')->paginate(10),
            'customers'   => $customers,
            'models'      => $models,
            'masterLines' => $masterLines,
            'years'       => $years,
            'months'      => $months,
        ]);
    }
}