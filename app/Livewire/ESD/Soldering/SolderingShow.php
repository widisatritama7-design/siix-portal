<?php

namespace App\Livewire\ESD\Soldering;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Soldering\Soldering;
use App\Models\ESD\Soldering\SolderingDetail;
use Carbon\Carbon;

class SolderingShow extends Component
{
    use WithPagination;

    public $soldering;
    
    // Filter properties
    public $filterDateFrom;
    public $filterDateUntil;
    public $filterNextDateFrom;
    public $filterNextDateUntil;
    public $search = '';
    
    // Form properties
    public $detail_id;
    public $soldering_id;
    public $register_no;
    public $area;
    public $location;
    public $type;
    public $spec;
    public $line;
    public $e1;
    public $judgement;
    public $next_date;
    public $modalTitle = 'Add New Measurement';
    public $detailToDelete = null;
    
    // Soldering list for dropdown
    public $solderings;

    protected function rules()
    {
        return [
            'soldering_id' => 'required|exists:tb_esd_solderings,id',
            'e1' => 'nullable|numeric', // diubah dari required|numeric|min:0|max:9.99
            'next_date' => 'nullable|date',
        ];
    }
    
    protected function messages()
    {
        return [
            'soldering_id.required' => 'Soldering equipment is required.',
            'soldering_id.exists' => 'Selected soldering does not exist.',
            'e1.numeric' => 'E1 measurement must be a number.',
            'next_date.date' => 'Next date must be a valid date.',
        ];
    }

    public function mount($id)
    {
        $this->soldering = Soldering::with('creator')->findOrFail($id);
        
        if (!auth()->user()->can('view soldering')) {
            abort(403, 'Unauthorized access.');
        }
        
        $this->loadSolderings();
    }

    public function loadSolderings()
    {
        $this->solderings = Soldering::orderBy('register_no')->get();
    }

    public function updatedE1()
    {
        $this->resetJudgement();
    }

    public function resetJudgement()
    {
        // E1 Judgement: < 10 is OK
        if ($this->e1 !== null && $this->e1 !== '') {
            $this->judgement = floatval($this->e1) < 10 ? 'OK' : 'NG';
        }
    }

    public function updatedSolderingId($value)
    {
        if ($value) {
            $soldering = Soldering::find($value);
            if ($soldering) {
                $this->register_no = $soldering->register_no;
                $this->area = $soldering->area;
                $this->location = $soldering->location;
                $this->type = $soldering->type;
                $this->spec = $soldering->spec;
                $this->line = $soldering->line;
            }
        } else {
            $this->register_no = null;
            $this->area = null;
            $this->location = null;
            $this->type = null;
            $this->spec = null;
            $this->line = null;
        }
    }

    public function resetForm()
    {
        $this->reset(['detail_id', 'soldering_id', 'register_no', 'area', 'location', 'type', 'spec', 'line', 
                      'e1', 'judgement', 'next_date']);
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
            if (!auth()->user()->can('edit soldering details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create soldering details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }
    
        // Set soldering_id from the current soldering
        $this->soldering_id = $this->soldering->id;
    
        $this->validate();
    
        $this->resetJudgement();
    
        $data = [
            'soldering_id' => $this->soldering_id,
            'e1' => $this->e1,
            'judgement' => $this->judgement,
            'next_date' => $this->next_date,
        ];
    
        if ($this->detail_id) {
            $detail = SolderingDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
                return;
            }
            
            $detail->update($data);
            $message = 'Measurement updated successfully!';
        } else {
            SolderingDetail::create($data);
            $message = 'Measurement created successfully!';
        }
    
        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'detail-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit soldering details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }
    
        $detail = SolderingDetail::with('soldering')->find($id);
    
        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            return;
        }
    
        $this->detail_id = $detail->id;
        $this->soldering_id = $detail->soldering_id;
        $this->register_no = $detail->soldering->register_no ?? '';
        $this->area = $detail->soldering->area ?? '';
        $this->location = $detail->soldering->location ?? '';
        $this->type = $detail->soldering->type ?? '';
        $this->spec = $detail->soldering->spec ?? '';
        $this->line = $detail->soldering->line ?? '';
        $this->e1 = $detail->e1;
        $this->judgement = $detail->judgement;
        $this->next_date = $detail->next_date ? Carbon::parse($detail->next_date)->format('Y-m-d') : null;
        $this->modalTitle = 'Edit Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete soldering details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = SolderingDetail::with('soldering')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $detail;
        $this->dispatch('open-modal', 'delete-detail-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete soldering details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = SolderingDetail::find($this->detailToDelete->id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $registerNo = $detail->soldering->register_no ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Measurement for '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function render()
    {
        $details = SolderingDetail::with(['soldering', 'creator'])
            ->where('soldering_id', $this->soldering->id)
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

        return view('livewire.esd.soldering.soldering-show', [
            'details' => $details,
        ]);
    }
}