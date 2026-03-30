<?php

namespace App\Livewire\ESD\GB;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\GB\GroundMonitorBox;
use App\Models\ESD\GB\GroundMonitorBoxDetail;
use Carbon\Carbon;

class GroundMonitorBoxShow extends Component
{
    use WithPagination;

    public $groundMonitorBox;
    
    // Filter properties
    public $filterDateFrom;
    public $filterDateUntil;
    public $filterNextDateFrom;
    public $filterNextDateUntil;
    public $search = '';
    
    // Form properties
    public $detail_id;
    public $ground_monitor_box_id;
    public $register_no;
    public $area;
    public $location;
    public $g_3;
    public $g_4;
    public $remarks;
    public $next_date;
    public $modalTitle = 'Add New Measurement';
    public $detailToDelete = null;
    
    // Ground Monitor Box list for dropdown
    public $groundMonitorBoxes;

    protected function rules()
    {
        return [
            'ground_monitor_box_id' => 'required|exists:tb_esd_ground_monitor_boxes,id',
            'g_3' => 'required|in:YES,NO',
            'g_4' => 'required|in:YES,NO',
            'remarks' => 'nullable|string|max:255',
            'next_date' => 'nullable|date',
        ];
    }
    
    protected function messages()
    {
        return [
            'ground_monitor_box_id.required' => 'Register number is required.',
            'ground_monitor_box_id.exists' => 'Selected Ground Monitor Box does not exist.',
            'g_3.required' => 'G1 measurement is required.',
            'g_3.in' => 'G1 must be YES or NO.',
            'g_4.required' => 'G2 measurement is required.',
            'g_4.in' => 'G2 must be YES or NO.',
            'remarks.max' => 'Remarks cannot exceed 255 characters.',
            'next_date.date' => 'Next date must be a valid date.',
        ];
    }

    public function mount($id)
    {
        $this->groundMonitorBox = GroundMonitorBox::with('creator')->findOrFail($id);
        
        if (!auth()->user()->can('view ground monitor box')) {
            abort(403, 'Unauthorized access.');
        }
        
        $this->loadGroundMonitorBoxes();
    }

    public function loadGroundMonitorBoxes()
    {
        $this->groundMonitorBoxes = GroundMonitorBox::orderBy('register_no')->get();
    }

    public function updatedGroundMonitorBoxId($value)
    {
        if ($value) {
            $groundMonitorBox = GroundMonitorBox::find($value);
            if ($groundMonitorBox) {
                $this->area = $groundMonitorBox->area;
                $this->location = $groundMonitorBox->location;
                $this->register_no = $groundMonitorBox->register_no;
            }
        } else {
            $this->area = null;
            $this->location = null;
            $this->register_no = null;
        }
    }

    public function resetForm()
    {
        $this->reset(['detail_id', 'ground_monitor_box_id', 'register_no', 'area', 'location', 
                      'g_3', 'g_4', 'remarks', 'next_date']);
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
            if (!auth()->user()->can('edit ground monitor box details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create ground monitor box details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }
    
        // Set ground_monitor_box_id from the current Ground Monitor Box
        $this->ground_monitor_box_id = $this->groundMonitorBox->id;
    
        $this->validate([
            'g_3' => 'required|in:YES,NO',
            'g_4' => 'required|in:YES,NO',
            'remarks' => 'nullable|string|max:255',
            'next_date' => 'nullable|date',
        ]);
    
        $data = [
            'ground_monitor_box_id' => $this->ground_monitor_box_id,
            'g_3' => $this->g_3,
            'g_4' => $this->g_4,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
        ];
    
        if ($this->detail_id) {
            $detail = GroundMonitorBoxDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
                return;
            }
            
            $detail->update($data);
            $message = 'Measurement updated successfully!';
        } else {
            GroundMonitorBoxDetail::create($data);
            $message = 'Measurement created successfully!';
        }
    
        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'detail-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit ground monitor box details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }
    
        $detail = GroundMonitorBoxDetail::with('groundMonitorBox')->find($id);
    
        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            return;
        }
    
        $this->detail_id = $detail->id;
        $this->ground_monitor_box_id = $detail->ground_monitor_box_id;
        $this->register_no = $detail->groundMonitorBox->register_no ?? '';
        $this->area = $detail->groundMonitorBox->area ?? '';
        $this->location = $detail->groundMonitorBox->location ?? '';
        $this->g_3 = $detail->g_3;
        $this->g_4 = $detail->g_4;
        $this->remarks = $detail->remarks;
        $this->next_date = $detail->next_date ? Carbon::parse($detail->next_date)->format('Y-m-d') : null;
        $this->modalTitle = 'Edit Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete ground monitor box details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = GroundMonitorBoxDetail::with('groundMonitorBox')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $detail;
        $this->dispatch('open-modal', 'delete-detail-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete ground monitor box details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = GroundMonitorBoxDetail::find($this->detailToDelete->id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $registerNo = $detail->groundMonitorBox->register_no ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Measurement for '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function render()
    {
        $details = GroundMonitorBoxDetail::with(['groundMonitorBox', 'creator'])
            ->where('ground_monitor_box_id', $this->groundMonitorBox->id)
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

        return view('livewire.esd.gb.ground-monitor-box-show', [
            'details' => $details,
        ]);
    }
}