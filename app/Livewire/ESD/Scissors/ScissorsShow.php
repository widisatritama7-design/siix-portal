<?php

namespace App\Livewire\ESD\Scissors;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Scissors\Scissors;
use App\Models\ESD\Scissors\ScissorsDetail;
use Carbon\Carbon;

class ScissorsShow extends Component
{
    use WithPagination;

    public $scissors;
    
    // Filter properties
    public $filterDateFrom;
    public $filterDateUntil;
    public $filterNextDateFrom;
    public $filterNextDateUntil;
    public $search = '';
    
    // Form properties
    public $detail_id;
    public $scissors_id;
    public $s_1;
    public $s_1_scientific;
    public $judgement_s_1;
    public $s_2;
    public $judgement_s_2;
    public $s_3_1;         // ✅ baru
    public $s_3_2;         // ✅ baru
    public $remarks;
    public $next_date;
    public $modalTitle = 'Add New Measurement';
    public $detailToDelete = null;

    protected function rules()
    {
        return [
            'scissors_id' => 'required|exists:tb_esd_scissors,id',
            's_1' => 'nullable|numeric',
            's_2' => 'nullable|numeric',
            's_3_1' => 'nullable|boolean',   // ✅ baru
            's_3_2' => 'nullable|boolean',   // ✅ baru
            'remarks' => 'nullable|string',
            'next_date' => 'nullable|date',
        ];
    }
    
    protected function messages()
    {
        return [
            'scissors_id.required' => 'Scissors is required.',
            'scissors_id.exists' => 'Selected scissors does not exist.',
            's_1.numeric' => 'S-1 resistance must be a number.',
            's_2.numeric' => 'S-2 voltage must be a number.',
            's_3_1.boolean' => 'S-3.1 must be Yes or No.',
            's_3_2.boolean' => 'S-3.2 must be Yes or No.',
            'next_date.date' => 'Next date must be a valid date.',
        ];
    }

    public function mount($id)
    {
        $this->scissors = Scissors::with('creator')->findOrFail($id);
        
        if (!auth()->user()->can('view scissors')) {
            abort(403, 'Unauthorized access.');
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

    public function resetForm()
    {
        $this->reset([
            'detail_id', 'scissors_id', 
            's_1', 's_1_scientific', 'judgement_s_1',
            's_2', 'judgement_s_2',
            's_3_1', 's_3_2',   // ✅ baru
            'remarks', 'next_date'
        ]);
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
    
        $this->scissors_id = $this->scissors->id;
    
        $this->validate();
    
        $this->resetJudgements();
    
        $data = [
            'scissors_id' => $this->scissors_id,
            's_1' => $this->s_1,
            's_1_scientific' => $this->s_1_scientific,
            'judgement_s_1' => $this->judgement_s_1,
            's_2' => $this->s_2,
            'judgement_s_2' => $this->judgement_s_2,
            's_3_1' => $this->s_3_1,   // ✅ baru
            's_3_2' => $this->s_3_2,   // ✅ baru
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
        ];
    
        if ($this->detail_id) {
            $detail = ScissorsDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
                return;
            }
            
            $detail->update($data);
            $message = 'Measurement updated successfully!';
        } else {
            ScissorsDetail::create($data);
            $message = 'Measurement created successfully!';
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
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            return;
        }
    
        $this->detail_id = $detail->id;
        $this->scissors_id = $detail->scissors_id;
        $this->s_1 = $detail->s_1;
        $this->s_1_scientific = $detail->s_1_scientific;
        $this->judgement_s_1 = $detail->judgement_s_1;
        $this->s_2 = $detail->s_2;
        $this->judgement_s_2 = $detail->judgement_s_2;
        $this->s_3_1 = $detail->s_3_1;   // ✅ baru
        $this->s_3_2 = $detail->s_3_2;   // ✅ baru
        $this->remarks = $detail->remarks;
        $this->next_date = $detail->next_date ? Carbon::parse($detail->next_date)->format('Y-m-d') : null;
        $this->modalTitle = 'Edit Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete scissors details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = ScissorsDetail::with('scissors')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
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
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $registerNo = $detail->scissors->register_no ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Measurement for '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function render()
    {
        $details = ScissorsDetail::with(['scissors', 'creator'])
            ->where('scissors_id', $this->scissors->id)
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

        return view('livewire.esd.scissors.scissors-show', [
            'details' => $details,
        ]);
    }
}