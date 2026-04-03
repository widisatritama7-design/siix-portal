<?php

namespace App\Livewire\ESD\Glove;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Glove\Glove;
use App\Models\ESD\Glove\GloveDetail;
use Carbon\Carbon;

class GloveShow extends Component
{
    use WithPagination;

    public $glove;
    
    // Filter properties
    public $filterDateFrom;
    public $filterDateUntil;
    public $filterNextDateFrom;
    public $filterNextDateUntil;
    public $search = '';
    
    // Form properties
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
    public $modalTitle = 'Add New Measurement';
    public $detailToDelete = null;
    
    // Glove list for dropdown
    public $gloves;

    protected function rules()
    {
        return [
            'glove_id' => 'required|exists:tb_esd_gloves,id',
            'c1' => 'nullable|numeric', // hapus required, min
            'remarks' => 'nullable|string|max:255',
            'next_date' => 'nullable|date',
        ];
    }
    
    protected function messages()
    {
        return [
            'glove_id.required' => 'SAP Code is required.',
            'glove_id.exists' => 'Selected glove does not exist.',
            'c1.numeric' => 'C1 measurement must be a number.',
            'remarks.max' => 'Remarks cannot exceed 255 characters.',
            'next_date.date' => 'Next date must be a valid date.',
        ];
    }

    public function mount($id)
    {
        $this->glove = Glove::with('creator')->findOrFail($id);
        
        if (!auth()->user()->can('view glove')) {
            abort(403, 'Unauthorized access.');
        }
        
        $this->loadGloves();
    }

    public function loadGloves()
    {
        $this->gloves = Glove::orderBy('sap_code')->get();
    }

    public function updatedC1()
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
        }
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
        $this->reset(['detail_id', 'glove_id', 'sap_code', 'description', 'delivery', 
                      'c1', 'c1_scientific', 'judgement', 'remarks', 'next_date']);
        $this->modalTitle = 'Add New Measurement';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset(['filterDateFrom', 'filterDateUntil', 'filterNextDateFrom', 'filterNextDateUntil', 'search']);
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
    
        // Set glove_id from the current glove
        $this->glove_id = $this->glove->id;
    
        $this->validate([
            'c1' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
            'next_date' => 'nullable|date',
        ]);
    
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
                $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
                return;
            }
            
            $detail->update($data);
            $message = 'Measurement updated successfully!';
        } else {
            GloveDetail::create($data);
            $message = 'Measurement created successfully!';
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
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
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
        $this->modalTitle = 'Edit Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete glove details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = GloveDetail::with('glove')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
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
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $sapCode = $detail->glove->sap_code ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Measurement for '{$sapCode}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function render()
    {
        $details = GloveDetail::with(['glove', 'creator'])
            ->where('glove_id', $this->glove->id)
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
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.esd.glove.glove-show', [
            'details' => $details,
        ]);
    }
}