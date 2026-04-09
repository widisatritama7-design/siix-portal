<?php

namespace App\Livewire\ESD\Glove;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Glove\Glove;
use App\Models\ESD\Glove\GloveDetail;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class GloveDetailManagement extends Component
{
    use WithPagination;

    public $detail_id;
    public $glove_id;
    public $sap_code;
    public $description;
    public $delivery;
    public $c1;
    public $c1_scientific;
    public $judgement;
    public $remarks;
    public $next_date;

    public $search = '';
    public $filterGlove = '';
    public $filterSapCode = '';
    public $filterDescription = '';
    public $filterDelivery = '';
    public $filterJudgement = '';
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    public $filterNextDateFrom = '';
    public $filterNextDateUntil = '';

    public $modalTitle = 'Add New Glove Measurement';
    public $detailToDelete = null;

    // Properti untuk print
    public $printPreview = false;
    public $printSapCode = '';
    public $printDescription = '';
    public $printDelivery = '';
    public $printDateFrom = '';
    public $printDateUntil = '';

    protected function rules()
    {
        return [
            'glove_id' => 'required|exists:tb_esd_gloves,id',
            'c1' => 'nullable|numeric',
            'remarks' => 'nullable|string|max:255',
            'next_date' => 'nullable|date',
        ];
    }

    protected $messages = [
        'glove_id.required' => 'SAP Code is required.',
        'glove_id.exists' => 'Selected glove does not exist.',
        'c1.numeric' => 'C1 measurement result must be a number.',
        'remarks.max' => 'Remarks cannot exceed 255 characters.',
        'next_date.date' => 'Next date must be a valid date.',
    ];

    public function mount()
    {
        $this->resetJudgement();
    }

    public function resetJudgement()
    {
        if ($this->c1 !== null && $this->c1 !== '') {
            // Standard: < 35,000,000 Ohm (3.5E+7 Ohm)
            // OK if value < 35,000,000
            // NG if value >= 35,000,000
            $this->judgement = floatval($this->c1) >= 35000000 ? 'NG' : 'OK';
            // Convert to scientific notation with 2 decimal places
            $this->c1_scientific = sprintf('%.2E', floatval($this->c1));
        } else {
            $this->judgement = null;
            $this->c1_scientific = null;
        }
    }

    public function updatedC1()
    {
        $this->resetJudgement();
    }

    public function updatedGloveId($value)
    {
        if ($value) {
            $glove = Glove::find($value);
            if ($glove) {
                $this->sap_code = $glove->sap_code;
                $this->description = $glove->description;
                $this->delivery = $glove->delivery;
            }
        } else {
            $this->sap_code = null;
            $this->description = null;
            $this->delivery = null;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'detail_id', 'glove_id', 'sap_code', 'description', 'delivery',
            'c1', 'c1_scientific', 'judgement', 'remarks', 'next_date'
        ]);
        $this->modalTitle = 'Add New Glove Measurement';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset([
            'search', 'filterGlove', 'filterSapCode', 'filterDescription', 'filterDelivery',
            'filterJudgement', 'filterDateFrom', 'filterDateUntil',
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
            if (!auth()->user()->can('edit glove details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create glove details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $this->resetJudgement();

        $data = [
            'glove_id' => $this->glove_id,
            'c1' => $this->c1,
            'c1_scientific' => $this->c1_scientific,
            'judgement' => $this->judgement,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
        ];

        if ($this->detail_id) {
            $detail = GloveDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Glove measurement not found!', type: 'error');
                return;
            }

            $detail->update($data);
            $message = 'Glove measurement updated successfully!';
        } else {
            GloveDetail::create($data);
            $message = 'Glove measurement created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'detail-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit glove details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = GloveDetail::with('glove')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Glove measurement not found!', type: 'error');
            return;
        }

        $this->detail_id = $detail->id;
        $this->glove_id = $detail->glove_id;
        $this->sap_code = $detail->glove->sap_code ?? '';
        $this->description = $detail->glove->description ?? '';
        $this->delivery = $detail->glove->delivery ?? '';
        $this->c1 = $detail->c1;
        $this->c1_scientific = $detail->c1_scientific;
        $this->judgement = $detail->judgement;
        $this->remarks = $detail->remarks;
        $this->next_date = $detail->next_date ? Carbon::parse($detail->next_date)->format('Y-m-d') : null;
        $this->modalTitle = 'Edit Glove Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete glove details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = GloveDetail::with('glove')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Glove measurement not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $detail;
        $this->dispatch('open-modal', 'delete-detail-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete glove details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = GloveDetail::find($this->detailToDelete->id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Glove measurement not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $sapCode = $this->detailToDelete->glove->sap_code ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Measurement for '{$sapCode}' has been deleted successfully!");
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
        if (!auth()->user()->can('view glove details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        // Validasi minimal satu filter dipilih
        if (empty($this->printSapCode) && empty($this->printDescription) && empty($this->printDelivery) && empty($this->printDateFrom) && empty($this->printDateUntil)) {
            $this->dispatch('notify', message: 'Please select at least one filter (SAP Code, Description, Delivery, or Date Range)!', type: 'error');
            return;
        }

        // Query data untuk print
        $query = GloveDetail::with(['glove', 'creator']);

        // Filter by SAP Code
        if (!empty($this->printSapCode)) {
            $query->whereHas('glove', function ($q) {
                $q->where('sap_code', 'like', '%' . $this->printSapCode . '%');
            });
        }

        // Filter by Description
        if (!empty($this->printDescription)) {
            $query->whereHas('glove', function ($q) {
                $q->where('description', 'like', '%' . $this->printDescription . '%');
            });
        }

        // Filter by Delivery
        if (!empty($this->printDelivery)) {
            $query->whereHas('glove', function ($q) {
                $q->where('delivery', 'like', '%' . $this->printDelivery . '%');
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
            'title' => 'ESD GLOVE MEASUREMENT REPORT',
            'date_from' => $this->printDateFrom,
            'date_until' => $this->printDateUntil,
            'sap_code' => $this->printSapCode,
            'description' => $this->printDescription,
            'delivery' => $this->printDelivery,
            'generated_by' => auth()->user()->name,
            'generated_at' => Carbon::now()->format('d M Y H:i:s'),
            'prepared_by' => auth()->user()->name,
            'checked_by' => null,
            'approved_by' => null,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('livewire.esd.glove.glove-detail-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return response()->streamDownload(
            function () use ($pdf) {
                echo $pdf->output();
            },
            'glove-measurement-' . Carbon::now()->format('Ymd_His') . '.pdf'
        );
    }

    public function resetPrintFilters()
    {
        $this->printSapCode = '';
        $this->printDescription = '';
        $this->printDelivery = '';
        $this->printDateFrom = '';
        $this->printDateUntil = '';
        $this->printPreview = false;
        $this->dispatch('notify', message: 'Print filters have been reset!', type: 'success');
    }

    public function render()
    {
        if (!auth()->user()->can('view glove details')) {
            abort(403, 'Unauthorized access.');
        }

        $gloves = Glove::orderBy('sap_code')->get();
        
        $details = GloveDetail::with(['glove', 'creator'])
            ->when($this->search, function ($query) {
                $query->whereHas('glove', function ($q) {
                    $q->where('sap_code', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhere('delivery', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterGlove, function ($query) {
                $query->where('glove_id', $this->filterGlove);
            })
            ->when($this->filterSapCode, function ($query) {
                $query->whereHas('glove', function ($q) {
                    $q->where('sap_code', 'like', '%' . $this->filterSapCode . '%');
                });
            })
            ->when($this->filterDescription, function ($query) {
                $query->whereHas('glove', function ($q) {
                    $q->where('description', 'like', '%' . $this->filterDescription . '%');
                });
            })
            ->when($this->filterDelivery, function ($query) {
                $query->whereHas('glove', function ($q) {
                    $q->where('delivery', 'like', '%' . $this->filterDelivery . '%');
                });
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

        return view('livewire.esd.glove.glove-detail-management', [
            'details' => $details,
            'gloves' => $gloves,
        ]);
    }
}