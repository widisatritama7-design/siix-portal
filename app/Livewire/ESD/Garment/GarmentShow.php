<?php

namespace App\Livewire\ESD\Garment;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\ESD\Garment\Garment;
use App\Models\ESD\Garment\GarmentDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GarmentShow extends Component
{
    use WithPagination, WithFileUploads;

    public $garment;
    
    // Filter properties
    public $filterDateFrom;
    public $filterDateUntil;
    public $filterNextDateFrom;
    public $filterNextDateUntil;
    public $search = '';
    
    // Form properties
    public $detail_id;
    public $nik;
    public $name;
    public $d1;
    public $d1_scientific;
    public $judgement_d1;
    public $d2;
    public $d2_scientific;
    public $judgement_d2;
    public $d3;
    public $d3_scientific;
    public $judgement_d3;
    public $d4;
    public $d4_scientific;
    public $judgement_d4;
    public $remarks;
    public $next_date;
    public $modalTitle = 'Add New Measurement';
    public $detailToDelete = null;
    
    // Photo properties for camera
    public $existingPhotos = [];
    public $capturedPhotos = [];
    public $photosToDelete = [];

    protected function rules()
    {
        return [
            'nik' => 'required|exists:tb_hr_employee,id',
            'd1' => 'nullable|numeric|min:0',
            'd2' => 'nullable|numeric|min:0',
            'd3' => 'nullable|numeric|min:0',
            'd4' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'next_date' => 'nullable|date',
        ];
    }

    public function mount($id)
    {
        $this->garment = Garment::findOrFail($id);
        
        if (!auth()->user()->can('view garment')) {
            abort(403, 'Unauthorized access.');
        }
        
        $this->existingPhotos = [];
        $this->capturedPhotos = [];
        $this->photosToDelete = [];
    }

    public function updatedD1()
    {
        $this->resetJudgements();
    }

    public function updatedD2()
    {
        $this->resetJudgements();
    }

    public function updatedD3()
    {
        $this->resetJudgements();
    }

    public function updatedD4()
    {
        $this->resetJudgements();
    }

    public function resetJudgements()
    {
        $minStandard = 10000; // 1.00E+4
        $maxStandard = 100000000000; // 1.00E+11

        if ($this->d1 !== null && $this->d1 !== '') {
            $this->judgement_d1 = ($this->d1 >= $minStandard && $this->d1 < $maxStandard) ? 'OK' : 'NG';
            $this->d1_scientific = sprintf('%.2E', floatval($this->d1));
        } else {
            $this->judgement_d1 = null;
            $this->d1_scientific = null;
        }
        
        if ($this->d2 !== null && $this->d2 !== '') {
            $this->judgement_d2 = ($this->d2 >= $minStandard && $this->d2 < $maxStandard) ? 'OK' : 'NG';
            $this->d2_scientific = sprintf('%.2E', floatval($this->d2));
        } else {
            $this->judgement_d2 = null;
            $this->d2_scientific = null;
        }
        
        if ($this->d3 !== null && $this->d3 !== '') {
            $this->judgement_d3 = ($this->d3 >= $minStandard && $this->d3 < $maxStandard) ? 'OK' : 'NG';
            $this->d3_scientific = sprintf('%.2E', floatval($this->d3));
        } else {
            $this->judgement_d3 = null;
            $this->d3_scientific = null;
        }
        
        if ($this->d4 !== null && $this->d4 !== '') {
            $this->judgement_d4 = ($this->d4 >= $minStandard && $this->d4 < $maxStandard) ? 'OK' : 'NG';
            $this->d4_scientific = sprintf('%.2E', floatval($this->d4));
        } else {
            $this->judgement_d4 = null;
            $this->d4_scientific = null;
        }
    }

    public function addCapturedPhoto($photoData)
    {
        try {
            // Batasi maksimal 5 foto
            if (count($this->capturedPhotos) >= 5) {
                throw new \Exception('Maximum 5 photos allowed');
            }
            
            // Debug logging
            \Log::info('addCapturedPhoto called', [
                'type' => gettype($photoData),
                'length' => is_string($photoData) ? strlen($photoData) : 0
            ]);
            
            // Extract base64 data
            if (is_string($photoData) && preg_match('/^data:image\/(\w+);base64,/', $photoData, $matches)) {
                $imageType = $matches[1];
                $base64String = explode(',', $photoData)[1];
                $imageData = base64_decode($base64String);
                
                if ($imageData === false) {
                    throw new \Exception('Failed to decode base64');
                }
                
                // Generate filename
                $filename = 'camera_' . time() . '_' . uniqid() . '.' . $imageType;
                $relativePath = 'garment-photos/' . $this->garment->id;
                $fullPath = $relativePath . '/' . $filename;
                
                // Save menggunakan Storage facade
                $saved = Storage::disk('public')->put($fullPath, $imageData);
                
                if ($saved) {
                    $this->capturedPhotos[] = [
                        'path' => $fullPath,
                        'preview' => Storage::url($fullPath)
                    ];
                    
                    \Log::info('Photo saved successfully', ['path' => $fullPath]);
                    $this->dispatch('notify', message: 'Photo added successfully', type: 'success');
                } else {
                    throw new \Exception('Storage put failed');
                }
            } else {
                throw new \Exception('Invalid base64 format');
            }
            
        } catch (\Exception $e) {
            \Log::error('Camera photo error: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error: ' . $e->getMessage(), type: 'error');
        }
    }

    public function removeCapturedPhoto($index)
    {
        if (isset($this->capturedPhotos[$index])) {
            // Hapus file dari storage (belum tersimpan di database)
            $path = $this->capturedPhotos[$index]['path'];
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            unset($this->capturedPhotos[$index]);
            $this->capturedPhotos = array_values($this->capturedPhotos);
            
            $this->dispatch('notify', message: 'Photo removed', type: 'success');
        }
    }

    public function removeExistingPhoto($index)
    {
        if (isset($this->existingPhotos[$index])) {
            $this->photosToDelete[] = $this->existingPhotos[$index];
            unset($this->existingPhotos[$index]);
            $this->existingPhotos = array_values($this->existingPhotos);
        }
    }

    public function resetForm()
    {
        $this->reset(['detail_id', 'nik', 'name', 
                    'd1', 'd1_scientific', 'judgement_d1',
                    'd2', 'd2_scientific', 'judgement_d2',
                    'd3', 'd3_scientific', 'judgement_d3',
                    'd4', 'd4_scientific', 'judgement_d4',
                    'remarks', 'next_date']);
        
        // HAPUS bagian ini - jangan hapus foto yang sudah disimpan!
        // foreach ($this->capturedPhotos as $photo) {
        //     if (Storage::disk('public')->exists($photo['path'])) {
        //         Storage::disk('public')->delete($photo['path']);
        //     }
        // }
        
        // Cukup kosongkan array saja
        $this->existingPhotos = [];
        $this->capturedPhotos = [];
        $this->photosToDelete = [];
        
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
            if (!auth()->user()->can('edit garment details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create garment details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->nik = $this->garment->id;
        $this->name = $this->garment->name;

        $this->validate();
        $this->resetJudgements();

        $photoPaths = [];
        
        if ($this->detail_id) {
            if (!empty($this->existingPhotos)) {
                $photoPaths = $this->existingPhotos;
            }
            
            if (!empty($this->photosToDelete)) {
                foreach ($this->photosToDelete as $oldPhoto) {
                    if (Storage::disk('public')->exists($oldPhoto)) {
                        Storage::disk('public')->delete($oldPhoto);
                    }
                }
            }
        }
        
        // Tambahkan foto baru ke path
        foreach ($this->capturedPhotos as $photo) {
            $photoPaths[] = $photo['path'];
        }

        $data = [
            'nik' => $this->nik,
            'name' => $this->name,
            'd1' => $this->d1,
            'd1_scientific' => $this->d1_scientific,
            'judgement_d1' => $this->judgement_d1,
            'd2' => $this->d2,
            'd2_scientific' => $this->d2_scientific,
            'judgement_d2' => $this->judgement_d2,
            'd3' => $this->d3,
            'd3_scientific' => $this->d3_scientific,
            'judgement_d3' => $this->judgement_d3,
            'd4' => $this->d4,
            'd4_scientific' => $this->d4_scientific,
            'judgement_d4' => $this->judgement_d4,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
            'photo_verification' => !empty($photoPaths) ? json_encode($photoPaths) : null,
        ];

        try {
            // Mulai transaction
            \DB::beginTransaction();
            
            if ($this->detail_id) {
                $detail = GarmentDetail::find($this->detail_id);
                if (!$detail) {
                    throw new \Exception('Measurement record not found!');
                }
                
                $detail->update($data);
                $message = 'Measurement updated successfully!';
            } else {
                $detail = GarmentDetail::create($data);
                $message = 'Measurement created successfully!';
            }
            
            // Commit transaction
            \DB::commit();
            
            // Reset form TANPA menghapus file
            $this->resetForm();
            
            $this->dispatch('notify', message: $message);
            $this->dispatch('close-modal', 'detail-form-modal');
            
        } catch (\Exception $e) {
            // Rollback jika error
            \DB::rollBack();
            
            // Hanya hapus foto jika SAVE GAGAL
            foreach ($this->capturedPhotos as $photo) {
                if (Storage::disk('public')->exists($photo['path'])) {
                    Storage::disk('public')->delete($photo['path']);
                }
            }
            
            Log::error('Failed to save measurement: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Failed to save: ' . $e->getMessage(), type: 'error');
        }
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit garment details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = GarmentDetail::with('garment')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            return;
        }

        $this->detail_id = $detail->id;
        $this->nik = $detail->nik;
        $this->name = $detail->name;
        $this->d1 = $detail->d1;
        $this->d1_scientific = $detail->d1_scientific;
        $this->judgement_d1 = $detail->judgement_d1;
        $this->d2 = $detail->d2;
        $this->d2_scientific = $detail->d2_scientific;
        $this->judgement_d2 = $detail->judgement_d2;
        $this->d3 = $detail->d3;
        $this->d3_scientific = $detail->d3_scientific;
        $this->judgement_d3 = $detail->judgement_d3;
        $this->d4 = $detail->d4;
        $this->d4_scientific = $detail->d4_scientific;
        $this->judgement_d4 = $detail->judgement_d4;
        $this->remarks = $detail->remarks;
        $this->next_date = $detail->next_date ? Carbon::parse($detail->next_date)->format('Y-m-d') : null;
        
        $this->existingPhotos = $detail->photo_verification ? json_decode($detail->photo_verification, true) : [];
        $this->capturedPhotos = [];
        $this->photosToDelete = [];
        
        $this->modalTitle = 'Edit Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete garment details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = GarmentDetail::with('garment')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $detail;
        $this->dispatch('open-modal', 'delete-detail-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete garment details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = GarmentDetail::find($this->detailToDelete->id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Measurement record not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }
        
        if ($detail->photo_verification) {
            $photos = json_decode($detail->photo_verification, true);
            if (is_array($photos)) {
                foreach ($photos as $photo) {
                    if (Storage::disk('public')->exists($photo)) {
                        Storage::disk('public')->delete($photo);
                    }
                }
            }
        }

        $nik = $detail->garment->nik ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Measurement for '{$nik}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function render()
    {
        $details = GarmentDetail::with(['garment', 'creator'])
            ->where('nik', $this->garment->id)
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
            ->paginate(10);
    
        return view('livewire.esd.garment.garment-show', [
            'details' => $details,
        ]);
    }
}