<?php

namespace App\Livewire\ESD\Insulatif;

use App\Models\ESD\Insulatif\InsulatifCheck;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class InsulatifCheckManagement extends Component
{
    use WithPagination;

    public $check_id;
    public $register_no;
    public $result;
    public $result_scientific;
    public $judgement;
    public $remarks;
    public $next_date;

    public $search = '';
    public $filterJudgement = '';
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    public $filterNextDateFrom = '';
    public $filterNextDateUntil = '';

    // Properti untuk print
    public $printPreview = false;
    public $printRegisterFilter = '';
    public $printJudgementFilter = '';
    public $printDateFrom = '';
    public $printDateUntil = '';

    public $modalTitle = 'Add New Insulatif Check';
    public $checkToDelete = null;

    protected function rules()
    {
        return [
            'register_no' => 'required|min:3|max:100',
            'result' => 'nullable|numeric',
            'remarks' => 'nullable|string|max:500',
            'next_date' => 'nullable|date',
        ];
    }

    protected $messages = [
        'register_no.required' => 'Register number is required.',
        'register_no.min' => 'Register number must be at least 3 characters.',
        'result.numeric' => 'Result measurement must be a number.',
        'next_date.date' => 'Next date must be a valid date.',
    ];

    /**
     * Generate PDF untuk print
     */
    public function printPDF()
    {
        if (!auth()->user()->can('view insulatif check')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        // Validasi minimal satu filter dipilih
        if (empty($this->printRegisterFilter) && empty($this->printJudgementFilter) && empty($this->printDateFrom) && empty($this->printDateUntil)) {
            $this->dispatch('notify', message: 'Please select at least one filter (Register No, Judgement, or Date Range)!', type: 'error');
            return;
        }

        // Query data untuk print
        $query = InsulatifCheck::with('creator');

        // Filter by Register No
        if (!empty($this->printRegisterFilter)) {
            $query->where('register_no', 'like', '%' . $this->printRegisterFilter . '%');
        }

        // Filter by Judgement
        if (!empty($this->printJudgementFilter)) {
            $query->where('judgement', $this->printJudgementFilter);
        }

        // Filter by Date Range
        if (!empty($this->printDateFrom)) {
            $query->whereDate('created_at', '>=', $this->printDateFrom);
        }

        if (!empty($this->printDateUntil)) {
            $query->whereDate('created_at', '<=', $this->printDateUntil);
        }

        $details = $query->orderBy('created_at', 'desc')->get();

        if ($details->isEmpty()) {
            $this->dispatch('notify', message: 'No data found for the selected filters!', type: 'warning');
            return;
        }

        // Data untuk PDF
        $data = [
            'details' => $details,
            'title' => 'ESD INSULATIVE SUPPORT SURFACE REPORT',
            'date_from' => $this->printDateFrom,
            'date_until' => $this->printDateUntil,
            'register_filter' => $this->printRegisterFilter,
            'judgement_filter' => $this->printJudgementFilter,
            'generated_by' => auth()->user()->name,
            'generated_at' => Carbon::now()->format('d M Y H:i:s'),
            'prepared_by' => auth()->user()->name,
            'checked_by' => null,
            'approved_by' => null,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('livewire.esd.insulatif.insulatif-check-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return response()->streamDownload(
            function () use ($pdf) {
                echo $pdf->output();
            },
            'insulatif-check-' . Carbon::now()->format('Ymd_His') . '.pdf'
        );
    }

    public function resetPrintFilters()
    {
        $this->printRegisterFilter = '';
        $this->printJudgementFilter = '';
        $this->printDateFrom = '';
        $this->printDateUntil = '';
        $this->printPreview = false;
        $this->dispatch('notify', message: 'Print filters have been reset!', type: 'success');
    }

    public function mount()
    {
        $this->resetJudgement();
    }

    public function resetJudgement()
    {
        // Result Judgement: < 1,000,000,000,000 = NG, ≥ 1,000,000,000,000 = OK
        if ($this->result !== null && $this->result !== '') {
            $this->judgement = floatval($this->result) >= 1000000000000 ? 'OK' : 'NG';
            $this->result_scientific = sprintf('%.2E', floatval($this->result));
        } else {
            $this->judgement = null;
            $this->result_scientific = null;
        }
    }

    public function updatedResult($value)
    {
        if ($value === '' || $value === null) {
            $this->result = null;
        }
        $this->resetJudgement();
    }

    public function resetForm()
    {
        $this->reset(['check_id', 'register_no', 'result', 'result_scientific', 'judgement', 'remarks', 'next_date']);
        $this->resetJudgement();
        $this->register_no = 'ISP/2505-001';
        $this->modalTitle = 'Add New Insulatif Check';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterJudgement', 'filterDateFrom', 'filterDateUntil', 'filterNextDateFrom', 'filterNextDateUntil']);
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterJudgement()
    {
        $this->resetPage();
    }

    public function updatedFilterDateFrom()
    {
        $this->resetPage();
    }

    public function updatedFilterDateUntil()
    {
        $this->resetPage();
    }

    public function updatedFilterNextDateFrom()
    {
        $this->resetPage();
    }

    public function updatedFilterNextDateUntil()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->check_id) {
            if (!auth()->user()->can('edit insulatif check')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create insulatif check')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $this->resetJudgement();

        $data = [
            'register_no' => $this->register_no,
            'result' => $this->result,
            'result_scientific' => $this->result_scientific,
            'judgement' => $this->judgement,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
        ];

        if ($this->check_id) {
            $check = InsulatifCheck::find($this->check_id);
            if (!$check) {
                $this->dispatch('notify', message: 'Insulatif check not found!', type: 'error');
                return;
            }

            $check->update($data);
            $message = 'Insulatif check updated successfully!';
        } else {
            InsulatifCheck::create($data);
            $message = 'Insulatif check created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'insulatif-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit insulatif check')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $check = InsulatifCheck::find($id);

        if (!$check) {
            $this->dispatch('notify', message: 'Insulatif check not found!', type: 'error');
            return;
        }

        $this->check_id = $check->id;
        $this->register_no = $check->register_no;
        $this->result = $check->result;
        $this->result_scientific = $check->result_scientific;
        $this->judgement = $check->judgement;
        $this->remarks = $check->remarks;
        $this->next_date = $check->next_date ? Carbon::parse($check->next_date)->format('Y-m-d') : null;
        $this->modalTitle = 'Edit Insulatif Check';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete insulatif check')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $check = InsulatifCheck::find($id);

        if (!$check) {
            $this->dispatch('notify', message: 'Insulatif check not found!', type: 'error');
            return;
        }

        $this->checkToDelete = $check;
        $this->dispatch('open-modal', 'delete-insulatif-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete insulatif check')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $check = InsulatifCheck::find($this->checkToDelete->id);

        if (!$check) {
            $this->dispatch('notify', message: 'Insulatif check not found!', type: 'error');
            $this->checkToDelete = null;
            return;
        }

        $registerNo = $check->register_no;
        $check->delete();

        $this->checkToDelete = null;
        $this->dispatch('notify', message: "Insulatif check '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-insulatif-modal');
    }

    public function cancelDelete()
    {
        $this->checkToDelete = null;
        $this->dispatch('close-modal', 'delete-insulatif-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view insulatif check')) {
            abort(403, 'Unauthorized access.');
        }

        $checks = InsulatifCheck::with('creator')
            ->when($this->search, function ($query) {
                $query->where('register_no', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterJudgement, function ($query) {
                $query->where('judgement', $this->filterJudgement);
            })
            ->when($this->filterDateFrom, function ($query) {
                $query->whereDate('created_at', '>=', $this->filterDateFrom);
            })
            ->when($this->filterDateUntil, function ($query) {
                $query->whereDate('created_at', '<=', $this->filterDateUntil);
            })
            ->when($this->filterNextDateFrom, function ($query) {
                $query->whereDate('next_date', '>=', $this->filterNextDateFrom);
            })
            ->when($this->filterNextDateUntil, function ($query) {
                $query->whereDate('next_date', '<=', $this->filterNextDateUntil);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.esd.insulatif.insulatif-check-management', [
            'checks' => $checks,
        ]);
    }
}