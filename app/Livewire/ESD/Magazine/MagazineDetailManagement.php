<?php

namespace App\Livewire\ESD\Magazine;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Magazine\Magazine;
use App\Models\ESD\Magazine\MagazineDetail;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class MagazineDetailManagement extends Component
{
    use WithPagination;

    public $detail_id;
    public $magazine_id;
    public $register_no;
    public $m1;
    public $m1_scientific;
    public $judgement_m1;
    public $m2;
    public $judgement_m2;
    public $remarks;
    public $next_date;

    public $search = '';
    public $filterMagazine = '';
    public $filterJudgementM1 = '';
    public $filterJudgementM2 = '';
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    public $filterNextDateFrom = '';
    public $filterNextDateUntil = '';

    public $modalTitle = 'Add New Magazine Measurement';
    public $detailToDelete = null;

    // Properti untuk print
    public $printPreview = false;
    public $printRegisterNo = '';
    public $printDateFrom = '';
    public $printDateUntil = '';

    protected function rules()
    {
        return [
            'magazine_id' => 'required|exists:tb_esd_magazines,id',
            'm1' => 'nullable|numeric',
            'm2' => 'nullable|numeric',
            'remarks' => 'nullable|string|max:500',
            'next_date' => 'nullable|date',
        ];
    }

    protected $messages = [
        'magazine_id.required' => 'Register number is required.',
        'magazine_id.exists' => 'Selected magazine does not exist.',
        'm1.numeric' => 'M1 measurement result must be a number.',
        'm2.numeric' => 'M2 measurement result must be a number.',
        'next_date.date' => 'Next date must be a valid date.',
    ];

    public function mount()
    {
        $this->resetJudgements();
    }

    public function resetJudgements()
    {
        // M1 Judgement: >= 10,000 and < 100,000,000,000 is OK
        if ($this->m1 !== null && $this->m1 !== '') {
            $this->judgement_m1 = (floatval($this->m1) >= 10000 && floatval($this->m1) < 100000000000) ? 'OK' : 'NG';
            $this->m1_scientific = sprintf('%.2E', floatval($this->m1));
        } else {
            $this->judgement_m1 = null;
            $this->m1_scientific = null;
        }

        // M2 Judgement: < 100 is OK
        if ($this->m2 !== null && $this->m2 !== '') {
            $this->judgement_m2 = floatval($this->m2) < 100 ? 'OK' : 'NG';
        } else {
            $this->judgement_m2 = null;
        }
    }

    public function updatedM1()
    {
        $this->resetJudgements();
    }

    public function updatedM2()
    {
        $this->resetJudgements();
    }

    public function updatedMagazineId($value)
    {
        if ($value) {
            $magazine = Magazine::find($value);
            if ($magazine) {
                $this->register_no = $magazine->register_no;
            }
        } else {
            $this->register_no = null;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'detail_id', 'magazine_id', 'register_no',
            'm1', 'm1_scientific', 'judgement_m1',
            'm2', 'judgement_m2', 'remarks', 'next_date'
        ]);
        $this->modalTitle = 'Add New Magazine Measurement';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset([
            'search', 'filterMagazine', 'filterJudgementM1',
            'filterJudgementM2', 'filterDateFrom', 'filterDateUntil',
            'filterNextDateFrom', 'filterNextDateUntil'
        ]);
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->detail_id) {
            if (!auth()->user()->can('edit magazine details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create magazine details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $this->resetJudgements();

        $data = [
            'magazines_id' => $this->magazine_id,
            'm1' => $this->m1,
            'm1_scientific' => $this->m1_scientific,
            'judgement_m1' => $this->judgement_m1,
            'm2' => $this->m2,
            'judgement_m2' => $this->judgement_m2,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
        ];

        if ($this->detail_id) {
            $detail = MagazineDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Magazine measurement not found!', type: 'error');
                return;
            }

            $detail->update($data);
            $message = 'Magazine measurement updated successfully!';
        } else {
            MagazineDetail::create($data);
            $message = 'Magazine measurement created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'detail-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit magazine details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = MagazineDetail::with('magazine')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Magazine measurement not found!', type: 'error');
            return;
        }

        $this->detail_id = $detail->id;
        $this->magazine_id = $detail->magazines_id;
        $this->register_no = $detail->magazine->register_no ?? '';
        $this->m1 = $detail->m1;
        $this->m1_scientific = $detail->m1_scientific;
        $this->judgement_m1 = $detail->judgement_m1;
        $this->m2 = $detail->m2;
        $this->judgement_m2 = $detail->judgement_m2;
        $this->remarks = $detail->remarks;
        $this->next_date = $detail->next_date ? Carbon::parse($detail->next_date)->format('Y-m-d') : null;
        $this->modalTitle = 'Edit Magazine Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete magazine details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = MagazineDetail::with('magazine')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Magazine measurement not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $detail;
        $this->dispatch('open-modal', 'delete-detail-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete magazine details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = MagazineDetail::find($this->detailToDelete->id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Magazine measurement not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $registerNo = $this->detailToDelete->magazine->register_no ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Measurement for '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function cancelDelete()
    {
        $this->detailToDelete = null;
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    /**
     * Generate PDF untuk print
     */
    public function printPDF()
    {
        if (!auth()->user()->can('view magazine details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        // Validasi minimal satu filter dipilih
        if (empty($this->printRegisterNo) && empty($this->printDateFrom) && empty($this->printDateUntil)) {
            $this->dispatch('notify', message: 'Please select at least one filter (Register No or Date Range)!', type: 'error');
            return;
        }

        // Query data untuk print
        $query = MagazineDetail::with(['magazine', 'creator']);

        // Filter by Register No
        if (!empty($this->printRegisterNo)) {
            $query->whereHas('magazine', function ($q) {
                $q->where('register_no', 'like', '%' . $this->printRegisterNo . '%');
            });
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
            'title' => 'ESD MAGAZINE MEASUREMENT REPORT',
            'date_from' => $this->printDateFrom,
            'date_until' => $this->printDateUntil,
            'register_no' => $this->printRegisterNo,
            'generated_by' => auth()->user()->name,
            'generated_at' => Carbon::now()->format('d M Y H:i:s'),
            'prepared_by' => auth()->user()->name,
            'checked_by' => null,
            'approved_by' => null,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('livewire.esd.magazine.magazine-detail-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return response()->streamDownload(
            function () use ($pdf) {
                echo $pdf->output();
            },
            'magazine-measurement-' . Carbon::now()->format('Ymd_His') . '.pdf'
        );
    }

    public function resetPrintFilters()
    {
        $this->printRegisterNo = '';
        $this->printDateFrom = '';
        $this->printDateUntil = '';
        $this->printPreview = false;
        $this->dispatch('notify', message: 'Print filters have been reset!', type: 'success');
    }

    public function render()
    {
        if (!auth()->user()->can('view magazine details')) {
            abort(403, 'Unauthorized access.');
        }

        $magazines = Magazine::orderBy('register_no')->get();
        
        $details = MagazineDetail::with(['magazine', 'creator'])
            ->when($this->search, function ($query) {
                $query->whereHas('magazine', function ($q) {
                    $q->where('register_no', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterMagazine, function ($query) {
                $query->where('magazines_id', $this->filterMagazine);
            })
            ->when($this->filterJudgementM1, function ($query) {
                $query->where('judgement_m1', $this->filterJudgementM1);
            })
            ->when($this->filterJudgementM2, function ($query) {
                $query->where('judgement_m2', $this->filterJudgementM2);
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

        return view('livewire.esd.magazine.magazine-detail-management', [
            'details' => $details,
            'magazines' => $magazines,
        ]);
    }
}