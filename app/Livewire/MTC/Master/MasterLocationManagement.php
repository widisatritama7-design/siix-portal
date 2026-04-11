<?php

namespace App\Livewire\MTC\Master;

use App\Models\MTC\Master\MasterLocation;
use App\Models\MTC\Master\MasterArea;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MasterLocationManagement extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'tailwind';

    // Properties untuk form
    public $location_id;
    public $area_id;
    public $location_name;
    public $photo;
    public $existing_photo;
    
    // Properties untuk search, filter dan delete
    public $search = '';
    public $selectedArea = '';
    public $locationToDelete;
    
    // Modal title
    public $modalTitle = 'Add New Location';

    protected $rules = [
        'area_id' => 'required|exists:tb_mtc_master_areas,id',
        'location_name' => 'required|string|max:255|unique:tb_mtc_master_locations,location_name',
        'photo' => 'nullable|image|max:2048', // max 2MB
    ];

    protected $messages = [
        'area_id.required' => 'Area is required.',
        'area_id.exists' => 'Selected area is invalid.',
        'location_name.required' => 'Location name is required.',
        'location_name.unique' => 'This location name already exists.',
        'location_name.max' => 'Location name cannot exceed 255 characters.',
        'photo.image' => 'File must be an image.',
        'photo.max' => 'Image size cannot exceed 2MB.',
    ];

    public function resetForm()
    {
        $this->reset(['location_id', 'area_id', 'location_name', 'photo']);
        $this->resetValidation();
        $this->modalTitle = 'Add New Location';
        $this->existing_photo = null;
    }

    public function edit($id)
    {
        // Check permission untuk edit
        if (!auth()->user()->can('edit master location')) {
            $this->dispatch('notify', message: 'You do not have permission to edit location!', type: 'error');
            return;
        }

        try {
            $location = MasterLocation::findOrFail($id);
            $this->location_id = $location->id;
            $this->area_id = $location->area_id;
            $this->location_name = $location->location_name;
            $this->existing_photo = $location->photo;
            $this->modalTitle = 'Edit Location';
            $this->resetValidation();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Location not found!', type: 'error');
        }
    }

    public function save()
    {
        // Check permission untuk create atau edit
        if ($this->location_id) {
            if (!auth()->user()->can('edit master location')) {
                $this->dispatch('notify', message: 'You do not have permission to update location!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create master location')) {
                $this->dispatch('notify', message: 'You do not have permission to create location!', type: 'error');
                return;
            }
        }

        // Update rules untuk edit mode
        if ($this->location_id) {
            $this->rules['location_name'] = 'required|string|max:255|unique:tb_mtc_master_locations,location_name,' . $this->location_id;
        } else {
            $this->rules['location_name'] = 'required|string|max:255|unique:tb_mtc_master_locations,location_name';
        }
        
        $this->validate();

        try {
            $photoPath = $this->existing_photo;
            
            // Handle photo upload
            if ($this->photo) {
                // Delete old photo if exists
                if ($this->existing_photo && Storage::disk('public')->exists($this->existing_photo)) {
                    Storage::disk('public')->delete($this->existing_photo);
                }
                
                $photoPath = $this->photo->store('mtc/locations', 'public');
            }

            if ($this->location_id) {
                // Update existing location
                $location = MasterLocation::findOrFail($this->location_id);
                $location->update([
                    'area_id' => $this->area_id,
                    'location_name' => $this->location_name,
                    'photo' => $photoPath,
                ]);
                $message = 'Location updated successfully!';
            } else {
                // Create new location
                MasterLocation::create([
                    'area_id' => $this->area_id,
                    'location_name' => $this->location_name,
                    'photo' => $photoPath,
                ]);
                $message = 'Location created successfully!';
            }

            $this->resetForm();
            $this->dispatch('close-modal', 'location-form-modal');
            $this->dispatch('notify', message: $message, type: 'success');
            
        } catch (\Exception $e) {
            Log::error('Error saving location: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to save location!', type: 'error');
        }
    }

    public function confirmDelete($id)
    {
        // Check permission untuk delete
        if (!auth()->user()->can('delete master location')) {
            $this->dispatch('notify', message: 'You do not have permission to delete location!', type: 'error');
            return;
        }

        try {
            $this->locationToDelete = MasterLocation::withCount(['machines', 'lines'])->findOrFail($id);
            $this->dispatch('open-modal', 'delete-location-modal');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Location not found!', type: 'error');
        }
    }

    public function delete()
    {
        // Check permission untuk delete
        if (!auth()->user()->can('delete master location')) {
            $this->dispatch('notify', message: 'You do not have permission to delete location!', type: 'error');
            return;
        }

        try {
            $location = MasterLocation::findOrFail($this->locationToDelete->id);
            
            // Check if location has machines or lines
            if ($location->machines()->count() > 0) {
                $this->dispatch('notify', 
                    message: 'Cannot delete location because it has ' . $location->machines()->count() . ' machine(s) associated!', 
                    type: 'warning'
                );
                $this->dispatch('close-modal', 'delete-location-modal');
                return;
            }
            
            if ($location->lines()->count() > 0) {
                $this->dispatch('notify', 
                    message: 'Cannot delete location because it has ' . $location->lines()->count() . ' line(s) associated!', 
                    type: 'warning'
                );
                $this->dispatch('close-modal', 'delete-location-modal');
                return;
            }
            
            // Delete photo if exists
            if ($location->photo && Storage::disk('public')->exists($location->photo)) {
                Storage::disk('public')->delete($location->photo);
            }
            
            $locationName = $location->location_name;
            $location->delete();
            
            $this->dispatch('close-modal', 'delete-location-modal');
            $this->dispatch('notify', message: "Location '{$locationName}' deleted successfully!", type: 'success');
            $this->locationToDelete = null;
            
        } catch (\Exception $e) {
            Log::error('Error deleting location: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to delete location!', type: 'error');
        }
    }

    public function render()
    {
        // Check permission untuk view
        if (!auth()->user()->can('view master location')) {
            abort(403, 'You do not have permission to view master location.');
        }

        $areas = MasterArea::orderBy('area_name')->get();

        $locations = MasterLocation::with(['area', 'creator', 'updater', 'machines', 'lines'])
            ->when($this->search, function ($query) {
                $query->where('location_name', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedArea, function ($query) {
                $query->where('area_id', $this->selectedArea);
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('livewire.mtc.master.master-location-management', [
            'locations' => $locations,
            'areas' => $areas,
        ]);
    }
}