<?php

namespace App\Livewire\ESD\Soldering;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Soldering\Soldering;

class SolderingManagement extends Component
{
    use WithPagination;

    public $soldering_id;
    public $register_no;
    public $area;
    public $location;
    public $type;
    public $spec;
    public $line;
    public $status = 'In Use';

    public $search = '';
    public $filterArea = '';
    public $filterLocation = '';
    public $filterType = '';
    public $filterLine = '';
    public $modalTitle = 'Add New Soldering';
    public $solderingToDelete = null;

    // Get unique values for filters
    public function getAreasProperty()
    {
        return Soldering::select('area')->distinct()->orderBy('area')->pluck('area');
    }

    public function getLocationsProperty()
    {
        return Soldering::select('location')->distinct()->orderBy('location')->pluck('location');
    }

    public function getTypesProperty()
    {
        return Soldering::select('type')->distinct()->orderBy('type')->pluck('type');
    }

    public function getLinesProperty()
    {
        return Soldering::select('line')->distinct()->orderBy('line')->pluck('line');
    }

    protected function rules()
    {
        return [
            'register_no' => 'required|min:3|max:100|unique:tb_esd_solderings,register_no,' . ($this->soldering_id ?? 'NULL'),
            'area' => 'required|min:2|max:100',
            'location' => 'required|min:2|max:100',
            'type' => 'nullable|max:100',
            'spec' => 'nullable|max:100',
            'line' => 'nullable|max:50',
            'status' => 'required|in:In Use,Not In Use,Under Repair,Damage,Disposed',
        ];
    }

    protected $messages = [
        'register_no.required' => 'Register number is required.',
        'register_no.min' => 'Register number must be at least 3 characters.',
        'register_no.unique' => 'Register number already exists.',
        'area.required' => 'Area is required.',
        'area.min' => 'Area must be at least 2 characters.',
        'location.required' => 'Location is required.',
        'location.min' => 'Location must be at least 2 characters.',
        'status.required' => 'Status is required.',
        'status.in' => 'Status must be one of: In Use, Not In Use, Under Repair, Damage, Disposed.',
    ];

    public function resetForm()
    {
        $this->reset([
            'soldering_id', 'register_no', 'area', 'location', 'type', 'spec', 'line', 'status'
        ]);
        $this->status = 'In Use';
        $this->modalTitle = 'Add New Soldering';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterArea', 'filterLocation', 'filterType', 'filterLine']);
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterArea()
    {
        $this->resetPage();
    }

    public function updatedFilterLocation()
    {
        $this->resetPage();
    }

    public function updatedFilterType()
    {
        $this->resetPage();
    }

    public function updatedFilterLine()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->soldering_id) {
            if (!auth()->user()->can('edit soldering')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create soldering')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'register_no' => $this->register_no,
            'area' => $this->area,
            'location' => $this->location,
            'type' => $this->type,
            'spec' => $this->spec,
            'line' => $this->line,
            'status' => $this->status,
        ];

        if ($this->soldering_id) {
            $soldering = Soldering::find($this->soldering_id);
            if (!$soldering) {
                $this->dispatch('notify', message: 'Soldering not found!', type: 'error');
                return;
            }

            $soldering->update($data);
            $message = 'Soldering updated successfully!';
        } else {
            Soldering::create($data);
            $message = 'Soldering created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'soldering-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit soldering')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $soldering = Soldering::find($id);

        if (!$soldering) {
            $this->dispatch('notify', message: 'Soldering not found!', type: 'error');
            return;
        }

        $this->soldering_id = $soldering->id;
        $this->register_no = $soldering->register_no;
        $this->area = $soldering->area;
        $this->location = $soldering->location;
        $this->type = $soldering->type;
        $this->spec = $soldering->spec;
        $this->line = $soldering->line;
        $this->status = $soldering->status;
        $this->modalTitle = 'Edit Soldering';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete soldering')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $soldering = Soldering::find($id);

        if (!$soldering) {
            $this->dispatch('notify', message: 'Soldering not found!', type: 'error');
            return;
        }

        $this->solderingToDelete = $soldering;
        $this->dispatch('open-modal', 'delete-soldering-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete soldering')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $soldering = Soldering::find($this->solderingToDelete->id);

        if (!$soldering) {
            $this->dispatch('notify', message: 'Soldering not found!', type: 'error');
            $this->solderingToDelete = null;
            return;
        }

        $registerNo = $soldering->register_no;
        $soldering->delete();

        $this->solderingToDelete = null;
        $this->dispatch('notify', message: "Soldering '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-soldering-modal');
    }

    public function cancelDelete()
    {
        $this->solderingToDelete = null;
        $this->dispatch('close-modal', 'delete-soldering-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view soldering')) {
            abort(403, 'Unauthorized access.');
        }

        $areas = Soldering::select('area')->distinct()->orderBy('area')->pluck('area');
        $locations = Soldering::select('location')->distinct()->orderBy('location')->pluck('location');
        $types = Soldering::select('type')->distinct()->orderBy('type')->pluck('type');
        $lines = Soldering::select('line')->distinct()->orderBy('line')->pluck('line');

        $solderings = Soldering::with('creator')
            ->when($this->search, function ($query) {
                $query->where('register_no', 'like', '%' . $this->search . '%')
                    ->orWhere('area', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%')
                    ->orWhere('type', 'like', '%' . $this->search . '%')
                    ->orWhere('spec', 'like', '%' . $this->search . '%')
                    ->orWhere('line', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterArea, function ($query) {
                $query->where('area', $this->filterArea);
            })
            ->when($this->filterLocation, function ($query) {
                $query->where('location', $this->filterLocation);
            })
            ->when($this->filterType, function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->filterLine, function ($query) {
                $query->where('line', $this->filterLine);
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('livewire.esd.soldering.soldering-management', [
            'solderings' => $solderings,
            'areas' => $areas,
            'locations' => $locations,
            'types' => $types,
            'lines' => $lines,
        ]);
    }
}