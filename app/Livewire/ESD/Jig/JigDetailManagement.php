<?php

namespace App\Livewire\ESD\Jig;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Jig\Jig;
use App\Models\ESD\Jig\JigDetail;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class JigDetailManagement extends Component
{
    use WithPagination;

    public $detail_id;
    public $jigs_id;
    public $location;
    public $j1;
    public $judgement_j1;
    public $j2;
    public $judgement_j2;
    public $remarks;
    public $next_date;

    public $search = '';
    public $filterJig = '';
    public $filterLocation = '';
    public $filterJudgementJ1 = '';
    public $filterJudgementJ2 = '';
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    public $filterNextDateFrom = '';
    public $filterNextDateUntil = '';

    public $modalTitle = 'Add New Jig Measurement';
    public $detailToDelete = null;

    // Properti untuk print
    public $printPreview = false;
    public $printRegisterNo = '';
    public $printLocation = '';
    public $printDateFrom = '';
    public $printDateUntil = '';

    protected function rules()
    {
        return [
            'jigs_id' => 'required|exists:tb_esd_jigs,id',
            'j1' => 'nullable|numeric|min:0',
            'j2' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:500',
            'next_date' => 'nullable|date',
        ];
    }

    protected $messages = [
        'jigs_id.required' => 'Register number is required.',
        'jigs_id.exists' => 'Selected jig does not exist.',
        'j2.required' => 'J2 measurement result is required.',
        'j2.numeric' => 'J2 measurement result must be a number.',
        'j2.min' => 'J2 measurement result must be at least 0.',
        'j1.numeric' => 'J1 measurement result must be a number.',
        'j1.min' => 'J1 measurement result must be at least 0.',
        'next_date.date' => 'Next date must be a valid date.',
    ];

    public function resetJudgementJ1()
    {
        if ($this->j1 !== null && $this->j1 !== '') {
            // Standard: < 1.00 Ohm (OK if < 1.00, NG if >= 1.00)
            $this->judgement_j1 = floatval($this->j1) >= 1.00 ? 'NG' : 'OK';
        } else {
            $this->judgement_j1 = null;
        }
    }

    public function resetJudgementJ2()
    {
        if ($this->j2 !== null && $this->j2 !== '') {
            // Standard: < 100 Volt (OK if < 100, NG if >= 100)
            $this->judgement_j2 = floatval($this->j2) >= 100 ? 'NG' : 'OK';
        } else {
            $this->judgement_j2 = null;
        }
    }

    public function updatedJ1()
    {
        $this->resetJudgementJ1();
    }

    public function updatedJ2()
    {
        $this->resetJudgementJ2();
    }

    public function updatedJigsId($value)
    {
        if ($value) {
            $jig = Jig::find($value);
            if ($jig) {
                $this->location = $jig->location;
            }
        } else {
            $this->location = null;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'detail_id', 'jigs_id', 'location', 'j1', 'judgement_j1',
            'j2', 'judgement_j2', 'remarks', 'next_date'
        ]);
        $this->modalTitle = 'Add New Jig Measurement';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset([
            'search', 'filterJig', 'filterLocation', 'filterJudgementJ1',
            'filterJudgementJ2', 'filterDateFrom', 'filterDateUntil',
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
            if (!auth()->user()->can('edit jig details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create jig details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $this->resetJudgementJ1();
        $this->resetJudgementJ2();

        $data = [
            'jigs_id' => $this->jigs_id,
            'j1' => $this->j1,
            'judgement_j1' => $this->judgement_j1,
            'j2' => $this->j2,
            'judgement_j2' => $this->judgement_j2,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
        ];

        if ($this->detail_id) {
            $detail = JigDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Jig measurement not found!', type: 'error');
                return;
            }

            $detail->update($data);
            $message = 'Jig measurement updated successfully!';
        } else {
            JigDetail::create($data);
            $message = 'Jig measurement created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'detail-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit jig details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = JigDetail::with('jig')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Jig measurement not found!', type: 'error');
            return;
        }

        $this->detail_id = $detail->id;
        $this->jigs_id = $detail->jigs_id;
        $this->location = $detail->jig->location ?? '';
        $this->j1 = $detail->j1;
        $this->judgement_j1 = $detail->judgement_j1;
        $this->j2 = $detail->j2;
        $this->judgement_j2 = $detail->judgement_j2;
        $this->remarks = $detail->remarks;
        $this->next_date = $detail->next_date ? Carbon::parse($detail->next_date)->format('Y-m-d') : null;
        $this->modalTitle = 'Edit Jig Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete jig details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = JigDetail::with('jig')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Jig measurement not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $detail;
        $this->dispatch('open-modal', 'delete-detail-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete jig details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = JigDetail::find($this->detailToDelete->id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Jig measurement not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $registerNo = $this->detailToDelete->jig->register_no ?? 'Unknown';
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
        if (!auth()->user()->can('view jig details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        // Validasi minimal satu filter dipilih
        if (empty($this->printRegisterNo) && empty($this->printLocation) && empty($this->printDateFrom) && empty($this->printDateUntil)) {
            $this->dispatch('notify', message: 'Please select at least one filter (Register No, Location, or Date Range)!', type: 'error');
            return;
        }

        // Query data untuk print
        $query = JigDetail::with(['jig', 'creator']);

        // Filter by Register No
        if (!empty($this->printRegisterNo)) {
            $query->whereHas('jig', function ($q) {
                $q->where('register_no', 'like', '%' . $this->printRegisterNo . '%');
            });
        }

        // Filter by Location
        if (!empty($this->printLocation)) {
            $query->whereHas('jig', function ($q) {
                $q->where('location', 'like', '%' . $this->printLocation . '%');
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
            'title' => 'ESD JIG MEASUREMENT REPORT',
            'date_from' => $this->printDateFrom,
            'date_until' => $this->printDateUntil,
            'register_no' => $this->printRegisterNo,
            'location' => $this->printLocation,
            'generated_by' => auth()->user()->name,
            'generated_at' => Carbon::now()->format('d M Y H:i:s'),
            'prepared_by' => auth()->user()->name,
            'checked_by' => null,
            'approved_by' => null,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('livewire.esd.jig.jig-detail-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return response()->streamDownload(
            function () use ($pdf) {
                echo $pdf->output();
            },
            'jig-measurement-' . Carbon::now()->format('Ymd_His') . '.pdf'
        );
    }

    public function resetPrintFilters()
    {
        $this->printRegisterNo = '';
        $this->printLocation = '';
        $this->printDateFrom = '';
        $this->printDateUntil = '';
        $this->printPreview = false;
        $this->dispatch('notify', message: 'Print filters have been reset!', type: 'success');
    }

    public function render()
    {
        if (!auth()->user()->can('view jig details')) {
            abort(403, 'Unauthorized access.');
        }

        $jigs = Jig::orderBy('register_no')->get();
        
        $details = JigDetail::with(['jig', 'creator'])
            ->when($this->search, function ($query) {
                $query->whereHas('jig', function ($q) {
                    $q->where('register_no', 'like', '%' . $this->search . '%')
                        ->orWhere('location', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterJig, function ($query) {
                $query->where('jigs_id', $this->filterJig);
            })
            ->when($this->filterLocation, function ($query) {
                $query->whereHas('jig', function ($q) {
                    $q->where('location', 'like', '%' . $this->filterLocation . '%');
                });
            })
            ->when($this->filterJudgementJ1, function ($query) {
                $query->where('judgement_j1', $this->filterJudgementJ1);
            })
            ->when($this->filterJudgementJ2, function ($query) {
                $query->where('judgement_j2', $this->filterJudgementJ2);
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

        return view('livewire.esd.jig.jig-detail-management', [
            'details' => $details,
            'jigs' => $jigs,
        ]);
    }
}