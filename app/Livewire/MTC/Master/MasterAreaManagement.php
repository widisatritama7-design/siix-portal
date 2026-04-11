<?php

namespace App\Livewire\MTC\Master;

use App\Models\MTC\Master\MasterArea;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class MasterAreaManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Properties untuk form
    public $area_id;
    public $area_name;
    
    // Properties untuk search dan delete
    public $search = '';
    public $areaToDelete;
    
    // Modal title
    public $modalTitle = 'Add New Area';

    protected $rules = [
        'area_name' => 'required|string|max:255|unique:tb_mtc_master_areas,area_name',
    ];

    protected $messages = [
        'area_name.required' => 'Area name is required.',
        'area_name.unique' => 'This area name already exists.',
        'area_name.max' => 'Area name cannot exceed 255 characters.',
    ];

    // Hapus method updated() jika tidak diperlukan
    // Atau biarkan kosong, tapi jangan panggil validateOnly jika tidak ada property yang di-validate

    public function resetForm()
    {
        $this->reset(['area_id', 'area_name']);
        $this->resetValidation();
        $this->modalTitle = 'Add New Area';
    }

    public function edit($id)
    {
        // Check permission untuk edit
        if (!auth()->user()->can('edit master area')) {
            $this->dispatch('notify', message: 'You do not have permission to edit area!', type: 'error');
            return;
        }

        try {
            $area = MasterArea::findOrFail($id);
            $this->area_id = $area->id;
            $this->area_name = $area->area_name;
            $this->modalTitle = 'Edit Area';
            $this->resetValidation();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Area not found!', type: 'error');
        }
    }

    public function save()
    {
        // Check permission untuk create atau edit
        if ($this->area_id) {
            if (!auth()->user()->can('edit master area')) {
                $this->dispatch('notify', message: 'You do not have permission to update area!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create master area')) {
                $this->dispatch('notify', message: 'You do not have permission to create area!', type: 'error');
                return;
            }
        }

        // Update rules untuk edit mode
        if ($this->area_id) {
            $this->rules['area_name'] = 'required|string|max:255|unique:tb_mtc_master_areas,area_name,' . $this->area_id;
        } else {
            $this->rules['area_name'] = 'required|string|max:255|unique:tb_mtc_master_areas,area_name';
        }
        
        $this->validate();

        try {
            if ($this->area_id) {
                // Update existing area
                $area = MasterArea::findOrFail($this->area_id);
                $area->update([
                    'area_name' => $this->area_name,
                ]);
                $message = 'Area updated successfully!';
            } else {
                // Create new area
                MasterArea::create([
                    'area_name' => $this->area_name,
                ]);
                $message = 'Area created successfully!';
            }

            $this->resetForm();
            $this->dispatch('close-modal', 'area-form-modal');
            $this->dispatch('notify', message: $message, type: 'success');
            
        } catch (\Exception $e) {
            Log::error('Error saving area: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to save area!', type: 'error');
        }
    }

    public function confirmDelete($id)
    {
        // Check permission untuk delete
        if (!auth()->user()->can('delete master area')) {
            $this->dispatch('notify', message: 'You do not have permission to delete area!', type: 'error');
            return;
        }

        try {
            $this->areaToDelete = MasterArea::withCount('locations')->findOrFail($id);
            $this->dispatch('open-modal', 'delete-area-modal');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Area not found!', type: 'error');
        }
    }

    public function delete()
    {
        // Check permission untuk delete
        if (!auth()->user()->can('delete master area')) {
            $this->dispatch('notify', message: 'You do not have permission to delete area!', type: 'error');
            return;
        }

        try {
            $area = MasterArea::findOrFail($this->areaToDelete->id);
            
            // Check if area has locations
            if ($area->locations()->count() > 0) {
                $this->dispatch('notify', 
                    message: 'Cannot delete area because it has ' . $area->locations()->count() . ' location(s) associated!', 
                    type: 'warning'
                );
                $this->dispatch('close-modal', 'delete-area-modal');
                return;
            }
            
            $areaName = $area->area_name;
            $area->delete();
            
            $this->dispatch('close-modal', 'delete-area-modal');
            $this->dispatch('notify', message: "Area '{$areaName}' deleted successfully!", type: 'success');
            $this->areaToDelete = null;
            
        } catch (\Exception $e) {
            Log::error('Error deleting area: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to delete area!', type: 'error');
        }
    }

    public function render()
    {
        // Check permission untuk view
        if (!auth()->user()->can('view master area')) {
            abort(403, 'You do not have permission to view master area.');
        }

        $areas = MasterArea::with(['creator', 'updater', 'locations'])
            ->when($this->search, function ($query) {
                $query->where('area_name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.mtc.master.master-area-management', [
            'areas' => $areas,
        ]);
    }
}