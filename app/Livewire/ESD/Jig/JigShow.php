<?php

namespace App\Livewire\ESD\Jig;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Jig\Jig;
use App\Models\ESD\Jig\JigDetail;
use Carbon\Carbon;

class JigShow extends Component
{
    use WithPagination;

    public $jig;
    
    // Filter properties
    public $filterDateFrom;
    public $filterDateUntil;
    public $filterNextDateFrom;
    public $filterNextDateUntil;
    public $search = '';
    
    // Form properties
    public $detail_id;
    public $jigs_id;
    public $location;
    public $j1;
    public $judgement_j1;
    public $j2;
    public $judgement_j2;
    public $remarks;
    public $next_date;
    public $modalTitle = 'Add New Measurement';
    public $detailToDelete = null;
    
    // Jig list for dropdown
    public $jigs;

    protected function rules()
    {
        return [
            'jigs_id' => 'required|exists:tb_esd_jigs,id',
            'j1' => 'nullable|numeric|min:0',
            'j2' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
            'next_date' => 'nullable|date',
        ];
    }
    
    protected function messages()
    {
        return [
            'jigs_id.required' => 'Register number is required.',
            'jigs_id.exists' => 'Selected jig does not exist.',
            'j2.required' => 'J2 measurement is required.',
            'j2.numeric' => 'J2 measurement must be a number.',
            'j2.min' => 'J2 measurement must be at least 0.',
            'j1.numeric' => 'J1 measurement must be a number.',
            'j1.min' => 'J1 measurement must be at least 0.',
            'next_date.date' => 'Next date must be a valid date.',
        ];
    }

    public function mount($id)
    {
        $this->jig = Jig::with('creator')->findOrFail($id);
        
        if (!auth()->user()->can('view jig')) {
            abort(403, 'Unauthorized access.');
        }
        
        $this->loadJigs();
    }

    public function loadJigs()
    {
        $this->jigs = Jig::orderBy('register_no')->get();
    }

    public function updatedJ1()
    {
        $this->resetJudgementJ1();
    }

    public function updatedJ2()
    {
        $this->resetJudgementJ2();
    }

    public function resetJudgementJ1()
    {
        if ($this->j1 !== null && $this->j1 !== '') {
            // Standard: > 1.00 is NG
            $this->judgement_j1 = floatval($this->j1) > 1.00 ? 'NG' : 'OK';
        }
    }

    public function resetJudgementJ2()
    {
        if ($this->j2 !== null && $this->j2 !== '') {
            // Standard: > 100 is NG
            $this->judgement_j2 = floatval($this->j2) > 100 ? 'NG' : 'OK';
        }
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
        $this->reset(['detail_id', 'jigs_id', 'location', 'j1', 'judgement_j1', 
                      'j2', 'judgement_j2', 'remarks', 'next_date']);
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
    
        // Set jigs_id from the current jig
        $this->jigs_id = $this->jig->id;
    
        $this->validate([
            'j1' => 'nullable|numeric|min:0',
            'j2' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
            'next_date' => 'nullable|date',
        ]);
    
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
                $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
                return;
            }
            
            $detail->update($data);
            $message = 'Measurement updated successfully!';
        } else {
            JigDetail::create($data);
            $message = 'Measurement created successfully!';
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
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
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
        $this->modalTitle = 'Edit Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete jig details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = JigDetail::with('jig')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
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
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $registerNo = $detail->jig->register_no ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Measurement for '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function render()
    {
        $details = JigDetail::with(['jig', 'creator'])
            ->where('jigs_id', $this->jig->id)
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

        return view('livewire.esd.jig.jig-show', [
            'details' => $details,
        ]);
    }
}