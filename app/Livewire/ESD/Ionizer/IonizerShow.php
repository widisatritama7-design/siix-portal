<?php

namespace App\Livewire\ESD\Ionizer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Ionizer\Ionizer;
use App\Models\ESD\Ionizer\IonizerDetail;
use Carbon\Carbon;

class IonizerShow extends Component
{
    use WithPagination;

    public $ionizer;
    
    // Filter properties
    public $filterDateFrom;
    public $filterDateUntil;
    public $filterNextDateFrom;
    public $filterNextDateUntil;
    public $search = '';
    
    // Form properties
    public $detail_id;
    public $ionizer_id;
    public $register_no;
    public $area;
    public $location;
    public $pm_1;
    public $pm_2;
    public $pm_3;
    public $c1_before;
    public $judgement_c1_before;
    public $c2_before;
    public $judgement_c2_before;
    public $c3_before;
    public $judgement_c3_before;
    public $c1;
    public $judgement_c1;
    public $c2;
    public $judgement_c2;
    public $c3;
    public $judgement_c3;
    public $remarks;
    public $next_date;
    public $modalTitle = 'Add New Measurement';
    public $detailToDelete = null;
    
    // Ionizer list for dropdown
    public $ionizers;

    protected function rules()
    {
        return [
            'ionizer_id' => 'required|exists:tb_esd_ionizers,id',
            'pm_1' => 'required|in:FLASH,NO',
            'pm_2' => 'required|in:OK,NO',
            'pm_3' => 'required|in:YES,NO',
            'c1_before' => 'required|numeric',
            'c2_before' => 'required|numeric',
            'c3_before' => 'required|numeric',
            'c1' => 'required|numeric',
            'c2' => 'required|numeric',
            'c3' => 'required|numeric',
            'remarks' => 'nullable|string',
            'next_date' => 'nullable|date',
        ];
    }
    
    protected function messages()
    {
        return [
            'ionizer_id.required' => 'Register number is required.',
            'ionizer_id.exists' => 'Selected ionizer does not exist.',
            'pm_1.required' => 'PM 1 is required.',
            'pm_1.in' => 'PM 1 must be FLASH or NO.',
            'pm_2.required' => 'PM 2 is required.',
            'pm_2.in' => 'PM 2 must be OK or NO.',
            'pm_3.required' => 'PM 3 is required.',
            'pm_3.in' => 'PM 3 must be YES or NO.',
            'c1_before.required' => 'C1 Before measurement is required.',
            'c1_before.numeric' => 'C1 Before must be a number.',
            'c2_before.required' => 'C2 Before measurement is required.',
            'c2_before.numeric' => 'C2 Before must be a number.',
            'c3_before.required' => 'C3 Before measurement is required.',
            'c3_before.numeric' => 'C3 Before must be a number.',
            'c1.required' => 'C1 measurement is required.',
            'c1.numeric' => 'C1 must be a number.',
            'c2.required' => 'C2 measurement is required.',
            'c2.numeric' => 'C2 must be a number.',
            'c3.required' => 'C3 measurement is required.',
            'c3.numeric' => 'C3 must be a number.',
            'next_date.date' => 'Next date must be a valid date.',
        ];
    }

    public function mount($id)
    {
        $this->ionizer = Ionizer::with('creator')->findOrFail($id);
        
        if (!auth()->user()->can('view ionizer')) {
            abort(403, 'Unauthorized access.');
        }
        
        $this->loadIonizers();
        $this->resetJudgements();
    }

    public function loadIonizers()
    {
        $this->ionizers = Ionizer::orderBy('register_no')->get();
    }

    public function resetJudgements()
    {
        // C1 Before Judgement (< 8.0)
        if ($this->c1_before !== null && $this->c1_before !== '') {
            $this->judgement_c1_before = floatval($this->c1_before) >= 8.0 ? 'NG' : 'OK';
        }
        
        // C2 Before Judgement (< 8.0)
        if ($this->c2_before !== null && $this->c2_before !== '') {
            $this->judgement_c2_before = floatval($this->c2_before) >= 8.0 ? 'NG' : 'OK';
        }
        
        // C3 Before Judgement (± 35)
        if ($this->c3_before !== null && $this->c3_before !== '') {
            $this->judgement_c3_before = (floatval($this->c3_before) <= -35.0 || floatval($this->c3_before) >= 35.0) ? 'NG' : 'OK';
        }
        
        // C1 Judgement (< 8.0)
        if ($this->c1 !== null && $this->c1 !== '') {
            $this->judgement_c1 = floatval($this->c1) >= 8.0 ? 'NG' : 'OK';
        }
        
        // C2 Judgement (< 8.0)
        if ($this->c2 !== null && $this->c2 !== '') {
            $this->judgement_c2 = floatval($this->c2) >= 8.0 ? 'NG' : 'OK';
        }
        
        // C3 Judgement (± 35)
        if ($this->c3 !== null && $this->c3 !== '') {
            $this->judgement_c3 = (floatval($this->c3) <= -35.0 || floatval($this->c3) >= 35.0) ? 'NG' : 'OK';
        }
    }

    public function updatedC1Before()
    {
        $this->resetJudgements();
    }

    public function updatedC2Before()
    {
        $this->resetJudgements();
    }

    public function updatedC3Before()
    {
        $this->resetJudgements();
    }

    public function updatedC1()
    {
        $this->resetJudgements();
    }

    public function updatedC2()
    {
        $this->resetJudgements();
    }

    public function updatedC3()
    {
        $this->resetJudgements();
    }

    public function updatedIonizerId($value)
    {
        if ($value) {
            $ionizer = Ionizer::find($value);
            if ($ionizer) {
                $this->area = $ionizer->area;
                $this->location = $ionizer->location;
                $this->register_no = $ionizer->register_no;
            }
        } else {
            $this->area = null;
            $this->location = null;
            $this->register_no = null;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'detail_id', 'ionizer_id', 'register_no', 'area', 'location',
            'pm_1', 'pm_2', 'pm_3',
            'c1_before', 'judgement_c1_before',
            'c2_before', 'judgement_c2_before',
            'c3_before', 'judgement_c3_before',
            'c1', 'judgement_c1',
            'c2', 'judgement_c2',
            'c3', 'judgement_c3',
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
            if (!auth()->user()->can('edit ionizer details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create ionizer details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }
    
        // Set ionizer_id from the current ionizer
        $this->ionizer_id = $this->ionizer->id;
    
        $this->validate([
            'pm_1' => 'required|in:FLASH,NO',
            'pm_2' => 'required|in:OK,NO',
            'pm_3' => 'required|in:YES,NO',
            'c1_before' => 'required|numeric',
            'c2_before' => 'required|numeric',
            'c3_before' => 'required|numeric',
            'c1' => 'required|numeric',
            'c2' => 'required|numeric',
            'c3' => 'required|numeric',
            'remarks' => 'nullable|string',
            'next_date' => 'nullable|date',
        ]);
    
        $this->resetJudgements();
    
        $data = [
            'ionizer_id' => $this->ionizer_id,
            'pm_1' => $this->pm_1,
            'pm_2' => $this->pm_2,
            'pm_3' => $this->pm_3,
            'c1_before' => $this->c1_before,
            'judgement_c1_before' => $this->judgement_c1_before,
            'c2_before' => $this->c2_before,
            'judgement_c2_before' => $this->judgement_c2_before,
            'c3_before' => $this->c3_before,
            'judgement_c3_before' => $this->judgement_c3_before,
            'c1' => $this->c1,
            'judgement_c1' => $this->judgement_c1,
            'c2' => $this->c2,
            'judgement_c2' => $this->judgement_c2,
            'c3' => $this->c3,
            'judgement_c3' => $this->judgement_c3,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
        ];
    
        if ($this->detail_id) {
            $detail = IonizerDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
                return;
            }
            
            $detail->update($data);
            $message = 'Measurement updated successfully!';
        } else {
            IonizerDetail::create($data);
            $message = 'Measurement created successfully!';
        }
    
        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'detail-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit ionizer details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }
    
        $detail = IonizerDetail::with('ionizer')->find($id);
    
        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            return;
        }
    
        $this->detail_id = $detail->id;
        $this->ionizer_id = $detail->ionizer_id;
        $this->register_no = $detail->ionizer->register_no ?? '';
        $this->area = $detail->ionizer->area ?? '';
        $this->location = $detail->ionizer->location ?? '';
        
        $this->pm_1 = $detail->pm_1;
        $this->pm_2 = $detail->pm_2;
        $this->pm_3 = $detail->pm_3;
        
        $this->c1_before = $detail->c1_before;
        $this->judgement_c1_before = $detail->judgement_c1_before;
        $this->c2_before = $detail->c2_before;
        $this->judgement_c2_before = $detail->judgement_c2_before;
        $this->c3_before = $detail->c3_before;
        $this->judgement_c3_before = $detail->judgement_c3_before;
        
        $this->c1 = $detail->c1;
        $this->judgement_c1 = $detail->judgement_c1;
        $this->c2 = $detail->c2;
        $this->judgement_c2 = $detail->judgement_c2;
        $this->c3 = $detail->c3;
        $this->judgement_c3 = $detail->judgement_c3;
        
        $this->remarks = $detail->remarks;
        $this->next_date = $detail->next_date ? Carbon::parse($detail->next_date)->format('Y-m-d') : null;
        
        $this->modalTitle = 'Edit Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete ionizer details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = IonizerDetail::with('ionizer')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $detail;
        $this->dispatch('open-modal', 'delete-detail-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete ionizer details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = IonizerDetail::find($this->detailToDelete->id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $registerNo = $detail->ionizer->register_no ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Measurement for '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function render()
    {
        $details = IonizerDetail::with(['ionizer', 'creator'])
            ->where('ionizer_id', $this->ionizer->id)
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

        return view('livewire.esd.ionizer.ionizer-show', [
            'details' => $details,
        ]);
    }
}