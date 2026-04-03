<?php

namespace App\Livewire\ESD\Magazine;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Magazine\Magazine;
use App\Models\ESD\Magazine\MagazineDetail;
use Carbon\Carbon;

class MagazineShow extends Component
{
    use WithPagination;

    public $magazine;
    
    // Filter properties
    public $filterDateFrom;
    public $filterDateUntil;
    public $filterNextDateFrom;
    public $filterNextDateUntil;
    public $search = '';
    
    // Form properties
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
    public $modalTitle = 'Add New Measurement';
    public $detailToDelete = null;
    
    // Magazine list for dropdown
    public $magazines;

    protected function rules()
    {
        return [
            'magazine_id' => 'required|exists:tb_esd_magazines,id',
            'm1' => 'nullable|numeric', // hapus required, min, max
            'm2' => 'nullable|numeric', // hapus required, min, max
            'remarks' => 'nullable|string',
            'next_date' => 'nullable|date',
        ];
    }
    
    protected function messages()
    {
        return [
            'magazine_id.required' => 'Register number is required.',
            'magazine_id.exists' => 'Selected magazine does not exist.',
            'm1.numeric' => 'M1 measurement must be a number.',
            'm2.numeric' => 'M2 measurement must be a number.',
            'next_date.date' => 'Next date must be a valid date.',
        ];
    }

    public function mount($id)
    {
        $this->magazine = Magazine::with('creator')->findOrFail($id);
        
        if (!auth()->user()->can('view magazine')) {
            abort(403, 'Unauthorized access.');
        }
        
        $this->loadMagazines();
    }

    public function loadMagazines()
    {
        $this->magazines = Magazine::orderBy('register_no')->get();
    }

    public function updatedM1()
    {
        $this->resetJudgements();
    }

    public function updatedM2()
    {
        $this->resetJudgements();
    }

    public function resetJudgements()
    {
        // M1 Judgement: >= 10,000 and < 100,000,000,000 is OK
        if ($this->m1 !== null && $this->m1 !== '') {
            $this->judgement_m1 = (floatval($this->m1) >= 10000 && floatval($this->m1) < 100000000000) ? 'OK' : 'NG';
            $this->m1_scientific = sprintf('%.2E', floatval($this->m1));
        }

        // M2 Judgement: < 100 is OK
        if ($this->m2 !== null && $this->m2 !== '') {
            $this->judgement_m2 = floatval($this->m2) < 100 ? 'OK' : 'NG';
        }
    }

    public function resetForm()
    {
        $this->reset(['detail_id', 'magazine_id', 'register_no', 
                      'm1', 'm1_scientific', 'judgement_m1',
                      'm2', 'judgement_m2', 'remarks', 'next_date']);
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
    
        // Set magazine_id from the current magazine
        $this->magazine_id = $this->magazine->id;
    
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
                $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
                return;
            }
            
            $detail->update($data);
            $message = 'Measurement updated successfully!';
        } else {
            MagazineDetail::create($data);
            $message = 'Measurement created successfully!';
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
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
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
        $this->modalTitle = 'Edit Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete magazine details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = MagazineDetail::with('magazine')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
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
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $registerNo = $detail->magazine->register_no ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Measurement for '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function render()
    {
        $details = MagazineDetail::with(['magazine', 'creator'])
            ->where('magazines_id', $this->magazine->id)
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

        return view('livewire.esd.magazine.magazine-show', [
            'details' => $details,
        ]);
    }
}