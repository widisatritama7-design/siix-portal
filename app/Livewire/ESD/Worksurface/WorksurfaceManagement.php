<?php

namespace App\Livewire\ESD\Worksurface;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\Worksurface\Worksurface;

class WorksurfaceManagement extends Component
{
    use WithPagination;

    public $worksurface_id;
    public $register_no;
    public $area;
    public $location;
    public $layer_count;
    public $category;
    public $status = 'In Use';

    public $search = '';
    public $filterArea = '';
    public $filterLocation = '';
    public $filterCategory = '';
    public $modalTitle = 'Add New Worksurface';
    public $worksurfaceToDelete = null;

    // Get unique values for filters
    public function getAreasProperty()
    {
        return Worksurface::select('area')->distinct()->orderBy('area')->pluck('area');
    }

    public function getLocationsProperty()
    {
        return Worksurface::select('location')->distinct()->orderBy('location')->pluck('location');
    }

    public function getCategoriesProperty()
    {
        return Worksurface::select('category')->distinct()->orderBy('category')->pluck('category');
    }

    protected function rules()
    {
        return [
            'register_no' => 'required|min:3|max:100|unique:tb_esd_worksurfaces,register_no,' . ($this->worksurface_id ?? 'NULL'),
            'area' => 'required|min:2|max:100',
            'location' => 'required|min:2|max:100',
            'layer_count' => 'nullable|integer|min:1|max:10',
            'category' => 'nullable|max:100',
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
        'layer_count.integer' => 'Layer count must be a number.',
        'layer_count.min' => 'Layer count must be at least 1.',
        'layer_count.max' => 'Layer count must be at most 10.',
        'status.required' => 'Status is required.',
        'status.in' => 'Status must be one of: In Use, Not In Use, Under Repair, Damage, Disposed.',
    ];

    public function resetForm()
    {
        $this->reset([
            'worksurface_id', 'register_no', 'area', 'location', 'layer_count', 'category', 'status'
        ]);
        $this->status = 'In Use';
        $this->modalTitle = 'Add New Worksurface';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterArea', 'filterLocation', 'filterCategory']);
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

    public function updatedFilterCategory()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->worksurface_id) {
            if (!auth()->user()->can('edit worksurface')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create worksurface')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'register_no' => $this->register_no,
            'area' => $this->area,
            'location' => $this->location,
            'layer_count' => $this->layer_count,
            'category' => $this->category,
            'status' => $this->status,
        ];

        if ($this->worksurface_id) {
            $worksurface = Worksurface::find($this->worksurface_id);
            if (!$worksurface) {
                $this->dispatch('notify', message: 'Worksurface not found!', type: 'error');
                return;
            }

            $worksurface->update($data);
            $message = 'Worksurface updated successfully!';
        } else {
            Worksurface::create($data);
            $message = 'Worksurface created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'worksurface-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit worksurface')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $worksurface = Worksurface::find($id);

        if (!$worksurface) {
            $this->dispatch('notify', message: 'Worksurface not found!', type: 'error');
            return;
        }

        $this->worksurface_id = $worksurface->id;
        $this->register_no = $worksurface->register_no;
        $this->area = $worksurface->area;
        $this->location = $worksurface->location;
        $this->layer_count = $worksurface->layer_count;
        $this->category = $worksurface->category;
        $this->status = $worksurface->status;
        $this->modalTitle = 'Edit Worksurface';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete worksurface')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $worksurface = Worksurface::find($id);

        if (!$worksurface) {
            $this->dispatch('notify', message: 'Worksurface not found!', type: 'error');
            return;
        }

        $this->worksurfaceToDelete = $worksurface;
        $this->dispatch('open-modal', 'delete-worksurface-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete worksurface')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $worksurface = Worksurface::find($this->worksurfaceToDelete->id);

        if (!$worksurface) {
            $this->dispatch('notify', message: 'Worksurface not found!', type: 'error');
            $this->worksurfaceToDelete = null;
            return;
        }

        $registerNo = $worksurface->register_no;
        $worksurface->delete();

        $this->worksurfaceToDelete = null;
        $this->dispatch('notify', message: "Worksurface '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-worksurface-modal');
    }

    public function cancelDelete()
    {
        $this->worksurfaceToDelete = null;
        $this->dispatch('close-modal', 'delete-worksurface-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view worksurface')) {
            abort(403, 'Unauthorized access.');
        }

        $areas = Worksurface::select('area')->distinct()->orderBy('area')->pluck('area');
        $locations = Worksurface::select('location')->distinct()->orderBy('location')->pluck('location');
        $categories = Worksurface::select('category')->distinct()->orderBy('category')->pluck('category');

        $worksurfaces = Worksurface::with('creator')
            ->when($this->search, function ($query) {
                $query->where('register_no', 'like', '%' . $this->search . '%')
                    ->orWhere('area', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%')
                    ->orWhere('category', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterArea, function ($query) {
                $query->where('area', $this->filterArea);
            })
            ->when($this->filterLocation, function ($query) {
                $query->where('location', $this->filterLocation);
            })
            ->when($this->filterCategory, function ($query) {
                $query->where('category', $this->filterCategory);
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('livewire.esd.worksurface.worksurface-management', [
            'worksurfaces' => $worksurfaces,
            'areas' => $areas,
            'locations' => $locations,
            'categories' => $categories,
        ]);
    }
}