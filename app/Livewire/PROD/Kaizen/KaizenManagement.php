<?php

namespace App\Livewire\PROD\Kaizen;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\PROD\Kaizen\Kaizen;
use App\Models\HR\Employee;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class KaizenManagement extends Component
{
    use WithPagination, WithFileUploads;

    // Form properties
    public $kaizen_id;
    public $nik;
    public $name;
    public $process;
    public $line;
    public $title;
    public $description;
    public $new_photos = [];
    public $existingPhotos = [];
    public $photoToDelete = null;
    
    // Approval/Status properties
    public $approval_status;
    public $status_kaizen;
    public $comment;
    public $comment_spv;
    
    // Filters
    public $search = '';
    public $filterApprovalStatus = '';
    public $filterKaizenStatus = '';
    public $dateFrom = '';
    public $dateTo = '';
    
    // Modal state
    public $modalTitle = 'Add New Kaizen';
    public $kaizenToDelete = null;
    public $kaizenToView = null;
    public $viewingPhotos = false;
    public $viewPhotoUrls = [];

    public $photoPreviewUrls = [];
    public $currentPhotoIndex = 0;
    public $currentPhotoList = [];

    protected function rules()
    {
        return [
            'nik' => 'required|exists:tb_hr_employee,nik', // Fixed: tb_hr_employee
            'name' => 'required|string',
            'process' => 'required|in:SMT,MI,ROUTER,LASER,PREPARATION,TECHNICIAN,MAINTENANCE,ESD,UTILITY,PE,QUALITY,MATERIAL',
            'line' => 'nullable|string|required_if:process,SMT,MI,ROUTER,LASER',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'new_photos.*' => 'nullable|image|max:5120',
            'approval_status' => 'nullable|in:Pending,Accepted,Rejected',
            'status_kaizen' => 'nullable|in:Pending,Approved,Rejected',
            'comment' => 'nullable|string|max:255',
            'comment_spv' => 'nullable|string|max:255',
        ];
    }

    protected $messages = [
        'nik.required' => 'NIK is required.',
        'nik.exists' => 'Employee not found.',
        'process.required' => 'Process is required.',
        'title.required' => 'Title is required.',
        'description.required' => 'Description is required.',
        'line.required_if' => 'Line is required for this process.',
        'new_photos.*.image' => 'File must be an image.',
        'new_photos.*.max' => 'Image must not exceed 5MB.',
    ];

    public function viewPhoto($photoPath, $allPhotos = [])
    {
        $this->photoPreviewUrls = array_map(fn($p) => Storage::disk('public')->url($p), $allPhotos);
        $this->currentPhotoIndex = array_search($photoPath, $allPhotos);
        $this->currentPhotoList = $allPhotos;
        $this->dispatch('open-modal', 'photo-preview-modal');
    }

    public function nextPhoto()
    {
        if ($this->currentPhotoIndex < count($this->currentPhotoList) - 1) {
            $this->currentPhotoIndex++;
        }
    }

    public function previousPhoto()
    {
        if ($this->currentPhotoIndex > 0) {
            $this->currentPhotoIndex--;
        }
    }

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'kaizen_id', 'nik', 'name', 'process', 'line', 'title', 
            'description', 'new_photos', 'approval_status', 'status_kaizen',
            'comment', 'comment_spv'
        ]);
        $this->existingPhotos = [];
        $this->modalTitle = 'Add New Kaizen';
        $this->resetValidation();
    }

    public function updatedNik($value)
    {
        if ($value) {
            $employee = Employee::where('nik', $value)->first();
            $this->name = $employee?->name ?? null;
        } else {
            $this->name = null;
        }
    }

    public function updatedProcess($value)
    {
        $this->line = null;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterApprovalStatus()
    {
        $this->resetPage();
    }

    public function updatedFilterKaizenStatus()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    public function getLineOptionsProperty()
    {
        return match ($this->process) {
            'SMT', 'ROUTER' => collect(range(1, 17))->mapWithKeys(fn($l) => [$l => "Line $l"]),
            'LASER' => collect(range(1, 6))->mapWithKeys(fn($l) => [$l => "Line $l"]),
            'MI' => collect(range(1, 5))->mapWithKeys(fn($l) => [$l => "Line $l"]),
            default => [],
        };
    }

    public function getShowLineFieldProperty()
    {
        return in_array($this->process, ['SMT', 'MI', 'ROUTER', 'LASER']);
    }

    public function removeNewPhoto($index)
    {
        unset($this->new_photos[$index]);
        $this->new_photos = array_values($this->new_photos);
    }

    public function removeExistingPhoto($index)
    {
        $this->photoToDelete = $index;
        $this->dispatch('open-modal', 'delete-photo-modal');
    }

    public function confirmDeletePhoto()
    {
        if ($this->photoToDelete !== null && isset($this->existingPhotos[$this->photoToDelete])) {
            $photoPath = $this->existingPhotos[$this->photoToDelete];
            
            if (Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }
            
            unset($this->existingPhotos[$this->photoToDelete]);
            $this->existingPhotos = array_values($this->existingPhotos);
            
            $this->dispatch('notify', message: 'Photo deleted successfully!', type: 'success');
        }
        
        $this->photoToDelete = null;
        $this->dispatch('close-modal', 'delete-photo-modal');
    }

    public function cancelDeletePhoto()
    {
        $this->photoToDelete = null;
        $this->dispatch('close-modal', 'delete-photo-modal');
    }

    public function save()
    {
        if ($this->kaizen_id) {
            if (!auth()->user()->can('edit kaizen')) {
                $this->dispatch('notify', message: 'You do not have permission to edit!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create kaizen')) {
                $this->dispatch('notify', message: 'You do not have permission to create!', type: 'error');
                return;
            }
        }

        $this->validate();

        $photoPaths = $this->existingPhotos;
        
        if (!empty($this->new_photos)) {
            foreach ($this->new_photos as $photo) {
                if ($photo instanceof TemporaryUploadedFile) {
                    $path = $photo->store('kaizen-photos', 'public');
                    $photoPaths[] = $path;
                }
            }
        }

        $data = [
            'nik' => $this->nik,
            'name' => $this->name,
            'process' => $this->process,
            'line' => $this->line,
            'title' => $this->title,
            'description' => $this->description,
            'photo' => $photoPaths,
        ];

        if ($this->kaizen_id) {
            $kaizen = Kaizen::find($this->kaizen_id);
            if (!$kaizen) {
                $this->dispatch('notify', message: 'Kaizen not found!', type: 'error');
                return;
            }
            
            $kaizen->update($data);
            $message = 'Kaizen updated successfully!';
        } else {
            $data['approval_status'] = 'Pending';
            $data['status_kaizen'] = 'Pending';
            Kaizen::create($data);
            $message = 'Kaizen created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message, type: 'success');
        $this->dispatch('close-modal', 'kaizen-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit kaizen')) {
            $this->dispatch('notify', message: 'You do not have permission to edit!', type: 'error');
            return;
        }

        $kaizen = Kaizen::find($id);

        if (!$kaizen) {
            $this->dispatch('notify', message: 'Kaizen not found!', type: 'error');
            return;
        }

        $this->kaizen_id = $kaizen->id;
        $this->nik = $kaizen->nik;
        $this->name = $kaizen->name;
        $this->process = $kaizen->process;
        $this->line = $kaizen->line;
        $this->title = $kaizen->title;
        $this->description = $kaizen->description;
        $this->existingPhotos = is_array($kaizen->photo) ? $kaizen->photo : [];
        $this->new_photos = [];
        $this->modalTitle = 'Edit Kaizen';
    }

    public function view($id)
    {
        $kaizen = Kaizen::with('creator', 'updater')->find($id);
        
        if (!$kaizen) {
            $this->dispatch('notify', message: 'Kaizen not found!', type: 'error');
            return;
        }
        
        $this->kaizenToView = $kaizen;
        $this->viewPhotoUrls = is_array($kaizen->photo) 
            ? array_map(fn($p) => Storage::disk('public')->url($p), $kaizen->photo)
            : [];
        $this->dispatch('open-modal', 'view-kaizen-modal');
    }

    public function updateApprovalStatus($id, $status, $comment = null)
    {
        if (!auth()->user()->can('kaizen check')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $kaizen = Kaizen::find($id);
        
        if (!$kaizen) {
            $this->dispatch('notify', message: 'Kaizen not found!', type: 'error');
            return;
        }
        
        if (in_array($kaizen->approval_status, ['Accepted', 'Rejected'])) {
            $this->dispatch('notify', message: 'This kaizen has already been processed!', type: 'error');
            return;
        }
        
        $kaizen->approval_status = $status;
        $kaizen->comment = $comment;
        $kaizen->save();
        
        $this->dispatch('notify', message: "Approval status updated to {$status}!", type: 'success');
    }

    public function updateKaizenStatus($id, $status, $commentSpv = null)
    {
        if (!auth()->user()->can('kaizen approve')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $kaizen = Kaizen::find($id);
        
        if (!$kaizen) {
            $this->dispatch('notify', message: 'Kaizen not found!', type: 'error');
            return;
        }
        
        if ($kaizen->status_kaizen === 'Approved') {
            $this->dispatch('notify', message: 'This kaizen has already been approved!', type: 'error');
            return;
        }
        
        $kaizen->status_kaizen = $status;
        $kaizen->comment_spv = $commentSpv;
        $kaizen->save();
        
        $this->dispatch('notify', message: "Kaizen status updated to {$status}!", type: 'success');
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete kaizen')) {
            $this->dispatch('notify', message: 'You do not have permission to delete!', type: 'error');
            return;
        }

        $kaizen = Kaizen::find($id);

        if (!$kaizen) {
            $this->dispatch('notify', message: 'Kaizen not found!', type: 'error');
            return;
        }

        $this->kaizenToDelete = $kaizen;
        $this->dispatch('open-modal', 'delete-kaizen-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete kaizen')) {
            $this->dispatch('notify', message: 'You do not have permission to delete!', type: 'error');
            return;
        }

        $kaizen = Kaizen::find($this->kaizenToDelete->id);

        if (!$kaizen) {
            $this->dispatch('notify', message: 'Kaizen not found!', type: 'error');
            $this->kaizenToDelete = null;
            return;
        }

        if (is_array($kaizen->photo)) {
            foreach ($kaizen->photo as $photo) {
                if (Storage::disk('public')->exists($photo)) {
                    Storage::disk('public')->delete($photo);
                }
            }
        }

        $title = $kaizen->title;
        $kaizen->delete();

        $this->kaizenToDelete = null;
        $this->dispatch('notify', message: "Kaizen '{$title}' has been deleted successfully!", type: 'success');
        $this->dispatch('close-modal', 'delete-kaizen-modal');
    }

    public function cancelDelete()
    {
        $this->kaizenToDelete = null;
        $this->dispatch('close-modal', 'delete-kaizen-modal');
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->filterApprovalStatus = '';
        $this->filterKaizenStatus = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    public function render()
    {
        if (!auth()->user()->can('view kaizen')) {
            abort(403, 'Unauthorized access.');
        }

        $kaizens = Kaizen::with('creator', 'updater', 'employee')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('nik', 'like', '%' . $this->search . '%')
                      ->orWhere('name', 'like', '%' . $this->search . '%')
                      ->orWhere('process', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterApprovalStatus, function ($query) {
                $query->where('approval_status', $this->filterApprovalStatus);
            })
            ->when($this->filterKaizenStatus, function ($query) {
                $query->where('status_kaizen', $this->filterKaizenStatus);
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('created_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('created_at', '<=', $this->dateTo);
            })
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.prod.kaizen.kaizen-management', [
            'kaizens' => $kaizens,
        ]);
    }
}