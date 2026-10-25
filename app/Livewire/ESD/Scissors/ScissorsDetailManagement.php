<?php

namespace App\Livewire\ESD\Scissors;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Scissors\Scissors;
use App\Models\ESD\Scissors\ScissorsDetail;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ScissorsDetailManagement extends Component
{
    use WithPagination;

    public $detail_id;
    public $scissors_id;
    public $register_no;
    public $s_1;
    public $s_1_scientific;
    public $judgement_s_1;
    public $s_2;
    public $judgement_s_2;
    public $remarks;
    public $next_date;

    public $search = '';
    public $filterScissors = '';
    public $filterJudgementS1 = '';
    public $filterJudgementS2 = '';
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    public $filterNextDateFrom = '';
    public $filterNextDateUntil = '';

    public $modalTitle = 'Add New Scissors Measurement';
    public $detailToDelete = null;

    // Properti untuk print
    public $printPreview = false;
    public $printRegisterNo = '';
    public $printDateFrom = '';
    public $printDateUntil = '';

    protected function rules()
    {
        return [
            'scissors_id' => 'required|exists:tb_esd_scissors,id',
            's_1' => 'nullable|numeric',
            's_2' => 'nullable|numeric',
            'remarks' => 'nullable|string|max:500',
            'next_date' => 'nullable|date',
        ];
    }

    protected $messages = [
        'scissors_id.required' => 'Scissors is required.',
        'scissors_id.exists' => 'Selected scissors does not exist.',
        's_1.numeric' => 'S-1 resistance must be a number.',
        's_2.numeric' => 'S-2 voltage must be a number.',
        'next_date.date' => 'Next date must be a valid date.',
    ];

    public function mount()
    {
        $this->resetJudgements();
    }

    public function resetJudgements()
    {
        // S-1 Judgement: >= 10,000 and < 100,000,000,000 is OK
        if ($this->s_1 !== null && $this->s_1 !== '') {
            $this->judgement_s_1 = (floatval($this->s_1) >= 10000 && floatval($this->s_1) < 100000000000) ? 'OK' : 'NG';
            $this->s_1_scientific = sprintf('%.2E', floatval($this->s_1));
        } else {
            $this->judgement_s_1 = null;
            $this->s_1_scientific = null;
        }

        // S-2 Judgement: < 100 is OK
        if ($this->s_2 !== null && $this->s_2 !== '') {
            $this->judgement_s_2 = floatval($this->s_2) < 100 ? 'OK' : 'NG';
        } else {
            $this->judgement_s_2 = null;
        }
    }

    public function updatedS1()
    {
        $this->resetJudgements();
    }

    public function updatedS2()
    {
        $this->resetJudgements();
    }

    public function updatedScissorsId($value)
    {
        if ($value) {
            $scissor = Scissors::find($value);
            if ($scissor) {
                $this->register_no = $scissor->register_no;
            }
        } else {
            $this->register_no = null;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'detail_id', 'scissors_id', 'register_no',
            's_1', 's_1_scientific', 'judgement_s_1',
            's_2', 'judgement_s_2', 'remarks', 'next_date'
        ]);
        $this->modalTitle = 'Add New Scissors Measurement';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset([
            'search', 'filterScissors', 'filterJudgementS1',
            'filterJudgementS2', 'filterDateFrom', 'filterDateUntil',
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
            if (!auth()->user()->can('edit scissors details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create scissors details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $this->resetJudgements();

        $data = [
            'scissors_id' => $this->scissors_id,
            's_1' => $this->s_1,
            's_1_scientific' => $this->s_1_scientific,
            'judgement_s_1' => $this->judgement_s_1,
            's_2' => $this->s_2,
            'judgement_s_2' => $this->judgement_s_2,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
        ];

        if ($this->detail_id) {
            $detail = ScissorsDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Scissors measurement not found!', type: 'error');
                return;
            }

            $detail->update($data);
            $message = 'Scissors measurement updated successfully!';
        } else {
            ScissorsDetail::create($data);
            $message = 'Scissors measurement created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'detail-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit scissors details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = ScissorsDetail::with('scissors')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Scissors measurement not found!', type: 'error');
            return;
        }

        $this->detail_id = $detail->id;
        $this->scissors_id = $detail->scissors_id;
        $this->register_no = $detail->scissors->register_no ?? '';
        $this->s_1 = $detail->s_1;
        $this->s_1_scientific = $detail->s_1_scientific;
        $this->judgement_s_1 = $detail->judgement_s_1;
        $this->s_2 = $detail->s_2;
        $this->judgement_s_2 = $detail->judgement_s_2;
        $this->remarks = $detail->remarks;
        $this->next_date = $detail->next_date ? Carbon::parse($detail->next_date)->format('Y-m-d') : null;
        $this->modalTitle = 'Edit Scissors Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete scissors details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = ScissorsDetail::with('scissors')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Scissors measurement not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $detail;
        $this->dispatch('open-modal', 'delete-detail-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete scissors details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = ScissorsDetail::find($this->detailToDelete->id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Scissors measurement not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $registerNo = $this->detailToDelete->scissors->register_no ?? 'Unknown';
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
        if (!auth()->user()->can('view scissors details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        if (empty($this->printRegisterNo) && empty($this->printDateFrom) && empty($this->printDateUntil)) {
            $this->dispatch('notify', message: 'Please select at least one filter (Register No or Date Range)!', type: 'error');
            return;
        }

        $query = ScissorsDetail::with(['scissors', 'creator']);

        if (!empty($this->printRegisterNo)) {
            $query->whereHas('scissors', function ($q) {
                $q->where('register_no', 'like', '%' . $this->printRegisterNo . '%');
            });
        }

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

        $data = [
            'details' => $details,
            'title' => 'ESD SCISSORS MEASUREMENT REPORT',
            'date_from' => $this->printDateFrom,
            'date_until' => $this->printDateUntil,
            'register_no' => $this->printRegisterNo,
            'generated_by' => auth()->user()->name,
            'generated_at' => Carbon::now()->format('d M Y H:i:s'),
            'prepared_by' => auth()->user()->name,
            'checked_by' => null,
            'approved_by' => null,
        ];

        $pdf = Pdf::loadView('livewire.esd.scissors.scissors-detail-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return response()->streamDownload(
            function () use ($pdf) {
                echo $pdf->output();
            },
            'scissors-measurement-' . Carbon::now()->format('Ymd_His') . '.pdf'
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
        if (!auth()->user()->can('view scissors details')) {
            abort(403, 'Unauthorized access.');
        }

        $scissors = Scissors::orderBy('register_no')->get();
        
        $details = ScissorsDetail::with(['scissors', 'creator'])
            ->when($this->search, function ($query) {
                $query->whereHas('scissors', function ($q) {
                    $q->where('register_no', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterScissors, function ($query) {
                $query->where('scissors_id', $this->filterScissors);
            })
            ->when($this->filterJudgementS1, function ($query) {
                $query->where('judgement_s_1', $this->filterJudgementS1);
            })
            ->when($this->filterJudgementS2, function ($query) {
                $query->where('judgement_s_2', $this->filterJudgementS2);
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

        return view('livewire.esd.scissors.scissors-detail-management', [
            'details' => $details,
            'scissors' => $scissors,
        ]);
    }
}