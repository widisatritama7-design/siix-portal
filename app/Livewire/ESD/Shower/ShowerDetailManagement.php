<?php

namespace App\Livewire\ESD\Shower;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Shower\Shower;
use App\Models\ESD\Shower\ShowerDetail;
use Carbon\Carbon;

class ShowerDetailManagement extends Component
{
    use WithPagination;

    public $detail_id;
    public $shower_id;
    public $register_no;
    public $area;
    public $location;
    public $check_body;
    public $velocity;
    public $judgement;
    public $remarks;
    public $next_date;

    public $search = '';
    public $filterShower = '';
    public $filterCheckBody = '';
    public $filterJudgement = '';
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    public $filterNextDateFrom = '';
    public $filterNextDateUntil = '';

    public $modalTitle = 'Add New Shower Check';
    public $detailToDelete = null;

    protected function rules()
    {
        return [
            'shower_id' => 'required|exists:tb_esd_showers,id',
            'check_body' => 'required|boolean',
            'velocity' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:500',
            'next_date' => 'nullable|date|after_or_equal:today',
        ];
    }

    protected $messages = [
        'shower_id.required' => 'Register number is required.',
        'shower_id.exists' => 'Selected shower does not exist.',
        'check_body.required' => 'Check body status is required.',
        'check_body.boolean' => 'Check body must be true or false.',
        'velocity.required' => 'Velocity is required.',
        'velocity.numeric' => 'Velocity must be a number.',
        'velocity.min' => 'Velocity cannot be negative.',
        'remarks.max' => 'Remarks cannot exceed 500 characters.',
        'next_date.date' => 'Next date must be a valid date.',
        'next_date.after_or_equal' => 'Next date must be today or a future date.',
    ];

    public function mount()
    {
        $this->resetJudgement();
        $this->remarks = null;
    }

    public function resetJudgement()
    {
        // Enhanced judgement logic to handle out of spec values
        if ($this->velocity !== null && $this->velocity !== '') {
            $velocityValue = floatval($this->velocity);
            if ($velocityValue >= 80 && $velocityValue <= 100) {
                $this->judgement = 'OK';
            } elseif ($velocityValue < 80) {
                $this->judgement = 'NG (Below Standard)';
            } elseif ($velocityValue > 100) {
                $this->judgement = 'NG (Above Standard)';
            } else {
                $this->judgement = 'NG';
            }
        } else {
            $this->judgement = null;
        }
    }

    public function updatedVelocity($value)
    {
        if ($value === '' || $value === null) {
            $this->velocity = null;
        }
        $this->resetJudgement();
        
        // Auto-generate remarks for out of spec values if remarks is empty
        if ($value !== null && $value !== '') {
            $velocityValue = floatval($value);
            $isOutOfSpec = ($velocityValue < 80 || $velocityValue > 100);
            
            if ($isOutOfSpec && empty($this->remarks)) {
                if ($velocityValue < 80) {
                    $this->remarks = "⚠️ Velocity is below standard range (80-100 m/s). Needs corrective action.";
                } elseif ($velocityValue > 100) {
                    $this->remarks = "⚠️ Velocity is above standard range (80-100 m/s). Needs corrective action.";
                }
            } elseif (!$isOutOfSpec && empty($this->remarks)) {
                $this->remarks = "✓ Velocity is within standard range (80-100 m/s).";
            }
        }
    }

    public function updatedShowerId($value)
    {
        if ($value) {
            $shower = Shower::find($value);
            if ($shower) {
                $this->area = $shower->area;
                $this->location = $shower->location;
                $this->register_no = $shower->register_no;
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
            'detail_id', 'shower_id', 'register_no', 'area', 'location',
            'check_body', 'velocity', 'judgement', 'remarks', 'next_date'
        ]);
        $this->check_body = false;
        $this->remarks = null;
        $this->modalTitle = 'Add New Shower Check';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset([
            'search', 'filterShower', 'filterCheckBody', 'filterJudgement',
            'filterDateFrom', 'filterDateUntil', 'filterNextDateFrom', 'filterNextDateUntil'
        ]);
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterShower()
    {
        $this->resetPage();
    }

    public function updatedFilterCheckBody()
    {
        $this->resetPage();
    }

    public function updatedFilterJudgement()
    {
        $this->resetPage();
    }

    public function updatedFilterDateFrom()
    {
        $this->resetPage();
    }

    public function updatedFilterDateUntil()
    {
        $this->resetPage();
    }

    public function updatedFilterNextDateFrom()
    {
        $this->resetPage();
    }

    public function updatedFilterNextDateUntil()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->detail_id) {
            if (!auth()->user()->can('edit shower details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create shower details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        // Reset judgement before save
        $this->resetJudgement();
        
        // Check if velocity is out of spec
        $velocityValue = floatval($this->velocity);
        $isOutOfSpec = ($velocityValue < 80 || $velocityValue > 100);
        
        // Auto-generate remarks if still empty
        if (empty($this->remarks)) {
            if ($isOutOfSpec) {
                if ($velocityValue < 80) {
                    $this->remarks = "⚠️ Velocity is below standard range (80-100 m/s). Needs corrective action.";
                } elseif ($velocityValue > 100) {
                    $this->remarks = "⚠️ Velocity is above standard range (80-100 m/s). Needs corrective action.";
                }
            } else {
                $this->remarks = "✓ Velocity is within standard range (80-100 m/s).";
            }
        }

        $data = [
            'shower_id' => $this->shower_id,
            'check_body' => $this->check_body,
            'velocity' => $this->velocity,
            'judgement' => $this->judgement,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
        ];

        if ($this->detail_id) {
            $detail = ShowerDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Shower check not found!', type: 'error');
                return;
            }

            $detail->update($data);
            $message = 'Shower check updated successfully!';
            if ($isOutOfSpec) {
                $message .= ' ⚠️ Warning: Velocity is outside the standard range (80-100 m/s)!';
            }
        } else {
            ShowerDetail::create($data);
            $message = 'Shower check created successfully!';
            if ($isOutOfSpec) {
                $message .= ' ⚠️ Warning: Velocity is outside the standard range (80-100 m/s)!';
            }
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message, type: $isOutOfSpec ? 'warning' : 'success');
        $this->dispatch('close-modal', 'detail-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit shower details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = ShowerDetail::with('shower')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Shower check not found!', type: 'error');
            return;
        }

        $this->detail_id = $detail->id;
        $this->shower_id = $detail->shower_id;
        $this->register_no = $detail->shower->register_no ?? '';
        $this->area = $detail->shower->area ?? '';
        $this->location = $detail->shower->location ?? '';
        $this->check_body = (bool) $detail->check_body;
        $this->velocity = $detail->velocity;
        $this->judgement = $detail->judgement;
        $this->remarks = $detail->remarks;
        $this->next_date = $detail->next_date ? Carbon::parse($detail->next_date)->format('Y-m-d') : null;
        $this->modalTitle = 'Edit Shower Check';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete shower details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = ShowerDetail::with('shower')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Shower check not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $detail;
        $this->dispatch('open-modal', 'delete-detail-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete shower details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = ShowerDetail::find($this->detailToDelete->id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Shower check not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $registerNo = $this->detailToDelete->shower->register_no ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Check for '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function cancelDelete()
    {
        $this->detailToDelete = null;
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view shower details')) {
            abort(403, 'Unauthorized access.');
        }

        $showers = Shower::orderBy('register_no')->get();
        
        $details = ShowerDetail::with(['shower', 'creator'])
            ->when($this->search, function ($query) {
                $query->whereHas('shower', function ($q) {
                    $q->where('register_no', 'like', '%' . $this->search . '%')
                        ->orWhere('area', 'like', '%' . $this->search . '%')
                        ->orWhere('location', 'like', '%' . $this->search . '%');
                })->orWhere('remarks', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterShower, function ($query) {
                $query->where('shower_id', $this->filterShower);
            })
            ->when($this->filterCheckBody !== '' && $this->filterCheckBody !== null, function ($query) {
                $query->where('check_body', $this->filterCheckBody);
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

        return view('livewire.esd.shower.shower-detail-management', [
            'details' => $details,
            'showers' => $showers,
        ]);
    }
}