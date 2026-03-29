<?php

namespace App\Livewire\ESD\Flooring;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Flooring\Flooring;
use App\Models\ESD\Flooring\FlooringDetail;
use Carbon\Carbon;

class FlooringShow extends Component
{
    use WithPagination;

    public $flooring;
    
    // Filter properties
    public $filterDateFrom;
    public $filterDateUntil;
    public $filterNextDateFrom;
    public $filterNextDateUntil;
    public $search = '';
    
    // Form properties
    public $detail_id;
    public $flooring_id;
    public $register_no;
    public $area;
    public $location;
    public $b1;
    public $b1_scientific;
    public $judgement;
    public $remarks;
    public $next_date;
    public $modalTitle = 'Add New Measurement';
    public $detailToDelete = null;
    
    // Flooring list for dropdown
    public $floorings;

    protected function rules()
    {
        return [
            'flooring_id' => 'required|exists:tb_esd_floorings,id',
            'b1' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
            'next_date' => 'nullable|date',
        ];
    }
    
    protected function messages()
    {
        return [
            'flooring_id.required' => 'Register number is required.',
            'flooring_id.exists' => 'Selected flooring does not exist.',
            'b1.required' => 'B1 measurement is required.',
            'b1.numeric' => 'B1 measurement must be a number.',
            'b1.min' => 'B1 measurement must be at least 0.',
            'next_date.date' => 'Next date must be a valid date.',
        ];
    }

    public function mount($id)
    {
        $this->flooring = Flooring::with('creator')->findOrFail($id);
        
        if (!auth()->user()->can('view flooring')) {
            abort(403, 'Unauthorized access.');
        }
        
        $this->loadFloorings();
    }

    public function loadFloorings()
    {
        $this->floorings = Flooring::orderBy('register_no')->get();
    }

    public function updatedB1()
    {
        $this->resetJudgement();
    }

    public function resetJudgement()
    {
        if ($this->b1 !== null && $this->b1 !== '') {
            // Standard: < 1.00E+9 Ohm (1,000,000,000 Ohm)
            $this->judgement = floatval($this->b1) > 1000000000 ? 'NG' : 'OK';
            // Convert to scientific notation with 2 decimal places
            $this->b1_scientific = sprintf('%.2E', floatval($this->b1));
        }
    }

    public function updatedFlooringId($value)
    {
        if ($value) {
            $flooring = Flooring::find($value);
            if ($flooring) {
                $this->area = $flooring->area;
                $this->location = $flooring->location;
                $this->register_no = $flooring->register_no;
            }
        } else {
            $this->area = null;
            $this->location = null;
            $this->register_no = null;
        }
    }

    public function resetForm()
    {
        $this->reset(['detail_id', 'flooring_id', 'register_no', 'area', 'location', 
                      'b1', 'b1_scientific', 'judgement', 'remarks', 'next_date']);
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
            if (!auth()->user()->can('edit flooring details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create flooring details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }
    
        // Set flooring_id from the current flooring
        $this->flooring_id = $this->flooring->id;
    
        $this->validate([
            'b1' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
            'next_date' => 'nullable|date',
        ]);
    
        $this->resetJudgement();
    
        $data = [
            'flooring_id' => $this->flooring_id,
            'b1' => $this->b1,
            'b1_scientific' => $this->b1_scientific,
            'judgement' => $this->judgement,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
        ];
    
        if ($this->detail_id) {
            $detail = FlooringDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
                return;
            }
            
            $detail->update($data);
            $message = 'Measurement updated successfully!';
        } else {
            FlooringDetail::create($data);
            $message = 'Measurement created successfully!';
        }
    
        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'detail-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit flooring details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }
    
        $detail = FlooringDetail::with('flooring')->find($id);
    
        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            return;
        }
    
        $this->detail_id = $detail->id;
        $this->flooring_id = $detail->flooring_id;
        $this->register_no = $detail->flooring->register_no ?? '';
        $this->area = $detail->flooring->area ?? '';
        $this->location = $detail->flooring->location ?? '';
        $this->b1 = $detail->b1;
        $this->b1_scientific = $detail->b1_scientific;
        $this->judgement = $detail->judgement;
        $this->remarks = $detail->remarks;
        $this->next_date = $detail->next_date ? Carbon::parse($detail->next_date)->format('Y-m-d') : null;
        $this->modalTitle = 'Edit Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete flooring details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = FlooringDetail::with('flooring')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $detail;
        $this->dispatch('open-modal', 'delete-detail-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete flooring details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = FlooringDetail::find($this->detailToDelete->id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $registerNo = $detail->flooring->register_no ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Measurement for '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function render()
    {
        $details = FlooringDetail::with(['flooring', 'creator'])
            ->where('flooring_id', $this->flooring->id)
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

        return view('livewire.esd.flooring.flooring-show', [
            'details' => $details,
        ]);
    }
}