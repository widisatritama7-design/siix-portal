<?php

namespace App\Livewire\ESD\Patrol;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Patrol\Patrol;
use Carbon\Carbon;

class PatrolManagement extends Component
{
    use WithPagination;

    public $patrol_id;
    public $area;
    public $location;
    public $v_1;
    public $v_2;
    public $v_3;
    public $judgement_v3;
    public $v_4;
    public $remarks;
    public $next_date; // Added next_date

    public $search = '';
    public $filterArea = '';
    public $filterLocation = '';
    public $filterV1 = '';
    public $filterV2 = '';
    public $filterJudgementV3 = '';
    public $filterV4 = '';
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    public $filterNextDateFrom = ''; // Added filter for next date from
    public $filterNextDateUntil = ''; // Added filter for next date until

    public $modalTitle = 'Add New Patrol Record';
    public $patrolToDelete = null;

    protected function rules()
    {
        return [
            'area' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'v_1' => 'required|in:Connected,Not Connected',
            'v_2' => 'required|in:Good,Not Good',
            'v_3' => 'required|numeric|min:0|max:100',
            'v_4' => 'required|in:Good,Not Good',
            'remarks' => 'nullable|string|max:500',
            'next_date' => 'nullable|date|after_or_equal:today', // Added validation for next_date
        ];
    }

    protected $messages = [
        'area.required' => 'Area is required.',
        'location.required' => 'Location is required.',
        'v_1.required' => 'V1 status is required.',
        'v_1.in' => 'V1 must be Connected or Not Connected.',
        'v_2.required' => 'V2 status is required.',
        'v_2.in' => 'V2 must be Good or Not Good.',
        'v_3.required' => 'V3 value is required.',
        'v_3.numeric' => 'V3 must be a number.',
        'v_3.min' => 'V3 must be at least 0.',
        'v_3.max' => 'V3 cannot exceed 100.',
        'v_4.required' => 'V4 status is required.',
        'v_4.in' => 'V4 must be Good or Not Good.',
        'next_date.date' => 'Next date must be a valid date.',
        'next_date.after_or_equal' => 'Next date must be today or a future date.',
    ];

    public function updatedV3($value)
    {
        $this->updateJudgementV3();
    }

    public function updateJudgementV3()
    {
        if ($this->v_3 !== null && $this->v_3 !== '') {
            $v3Value = floatval($this->v_3);
            $this->judgement_v3 = ($v3Value >= 35 && $v3Value <= 65) ? 'Good' : 'Not Good';
        } else {
            $this->judgement_v3 = null;
        }
    }

    public function updatedArea()
    {
        $this->location = null;
        $this->resetValidation('location');
    }

    public function getLocationOptionsProperty()
    {
        return match ($this->area) {
            'WH Material' => [
                'Receiving' => 'Receiving',
                'IQC' => 'IQC',
                'Material' => 'Material',
            ],
            'Production 01' => [
                'SMT' => 'SMT',
                'Manual Insert' => 'Manual Insert',
                'Laser' => 'Laser',
                'Router' => 'Router',
                'Coating' => 'Coating',
                'Preparation' => 'Preparation',
                'OQC' => 'OQC',
            ],
            'Production 02' => [
                'Backend Plan A' => 'Backend Plan A',
                'Backend Plan B' => 'Backend Plan B',
                'Kojima' => 'Kojima',
                'V-Cut' => 'V-Cut',
            ],
            'WH Finish Good' => [
                'Finish Good' => 'Finish Good',
            ],
            default => [],
        };
    }

    public function resetForm()
    {
        $this->reset([
            'patrol_id', 'area', 'location', 'v_1', 'v_2', 'v_3', 
            'judgement_v3', 'v_4', 'remarks', 'next_date' // Added next_date
        ]);
        $this->modalTitle = 'Add New Patrol Record';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset([
            'search', 'filterArea', 'filterLocation', 'filterV1', 
            'filterV2', 'filterJudgementV3', 'filterV4', 
            'filterDateFrom', 'filterDateUntil', 'filterNextDateFrom', 'filterNextDateUntil' // Added next date filters
        ]);
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterArea()
    {
        $this->filterLocation = null;
        $this->resetPage();
    }

    public function updatedFilterLocation()
    {
        $this->resetPage();
    }

    public function updatedFilterV1()
    {
        $this->resetPage();
    }

    public function updatedFilterV2()
    {
        $this->resetPage();
    }

    public function updatedFilterJudgementV3()
    {
        $this->resetPage();
    }

    public function updatedFilterV4()
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

    public function updatedFilterNextDateFrom() // Added method
    {
        $this->resetPage();
    }

    public function updatedFilterNextDateUntil() // Added method
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->patrol_id) {
            if (!auth()->user()->can('edit patrol')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create patrol')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $this->updateJudgementV3();

        $data = [
            'area' => $this->area,
            'location' => $this->location,
            'v_1' => $this->v_1,
            'v_2' => $this->v_2,
            'v_3' => $this->v_3,
            'judgement_v3' => $this->judgement_v3,
            'v_4' => $this->v_4,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date, // Added next_date
        ];

        if ($this->patrol_id) {
            $patrol = Patrol::find($this->patrol_id);
            if (!$patrol) {
                $this->dispatch('notify', message: 'Patrol record not found!', type: 'error');
                return;
            }

            $patrol->update($data);
            $message = 'Patrol record updated successfully!';
        } else {
            Patrol::create($data);
            $message = 'Patrol record created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'patrol-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit patrol')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $patrol = Patrol::find($id);

        if (!$patrol) {
            $this->dispatch('notify', message: 'Patrol record not found!', type: 'error');
            return;
        }

        $this->patrol_id = $patrol->id;
        $this->area = $patrol->area;
        $this->location = $patrol->location;
        $this->v_1 = $patrol->v_1;
        $this->v_2 = $patrol->v_2;
        $this->v_3 = $patrol->v_3;
        $this->judgement_v3 = $patrol->judgement_v3;
        $this->v_4 = $patrol->v_4;
        $this->remarks = $patrol->remarks;
        $this->next_date = $patrol->next_date ? Carbon::parse($patrol->next_date)->format('Y-m-d') : null; // Added next_date
        $this->modalTitle = 'Edit Patrol Record';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete patrol')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $patrol = Patrol::find($id);

        if (!$patrol) {
            $this->dispatch('notify', message: 'Patrol record not found!', type: 'error');
            return;
        }

        $this->patrolToDelete = $patrol;
        $this->dispatch('open-modal', 'delete-patrol-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete patrol')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $patrol = Patrol::find($this->patrolToDelete->id);

        if (!$patrol) {
            $this->dispatch('notify', message: 'Patrol record not found!', type: 'error');
            $this->patrolToDelete = null;
            return;
        }

        $location = $patrol->location;
        $patrol->delete();

        $this->patrolToDelete = null;
        $this->dispatch('notify', message: "Patrol record '{$location}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-patrol-modal');
    }

    public function cancelDelete()
    {
        $this->patrolToDelete = null;
        $this->dispatch('close-modal', 'delete-patrol-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view patrol')) {
            abort(403, 'Unauthorized access.');
        }

        $patrols = Patrol::with('creator')
            ->when($this->search, function ($query) {
                $query->where('area', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%')
                    ->orWhere('remarks', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterArea, function ($query) {
                $query->where('area', $this->filterArea);
            })
            ->when($this->filterLocation, function ($query) {
                $query->where('location', $this->filterLocation);
            })
            ->when($this->filterV1, function ($query) {
                $query->where('v_1', $this->filterV1);
            })
            ->when($this->filterV2, function ($query) {
                $query->where('v_2', $this->filterV2);
            })
            ->when($this->filterJudgementV3, function ($query) {
                $query->where('judgement_v3', $this->filterJudgementV3);
            })
            ->when($this->filterV4, function ($query) {
                $query->where('v_4', $this->filterV4);
            })
            ->when($this->filterDateFrom, function ($query) {
                $query->whereDate('created_at', '>=', $this->filterDateFrom);
            })
            ->when($this->filterDateUntil, function ($query) {
                $query->whereDate('created_at', '<=', $this->filterDateUntil);
            })
            ->when($this->filterNextDateFrom, function ($query) { // Added filter for next date from
                $query->whereDate('next_date', '>=', $this->filterNextDateFrom);
            })
            ->when($this->filterNextDateUntil, function ($query) { // Added filter for next date until
                $query->whereDate('next_date', '<=', $this->filterNextDateUntil);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.esd.patrol.patrol-management', [
            'patrols' => $patrols,
        ]);
    }
}