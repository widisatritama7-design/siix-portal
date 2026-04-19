<?php

namespace App\Livewire\PROD\MS\Rack;

use App\Models\PROD\MS\MasterRackSample;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MasterRackSampleManagement extends Component
{
    use WithPagination;

    // Form fields - Single Add
    public $rack_id;
    public $type_rack;
    public $column_rack;
    public $sheet_rack;
    
    // Bulk Add Fields
    public $add_mode = 'rack'; // rack, column, sheet
    public $add_columns = 1;
    public $sheets_per_column = 10;
    public $target_column = 1;
    public $add_sheets = 5;
    
    // Modal
    public $modalTitle = 'Add New Rack';
    public $modalMode = 'single'; // single, bulk
    public $selectedSheet = null;
    public $rackToDelete = null;
    
    // Filters & Tabs
    public $activeRackType = null;
    public $search = '';
    
    // Statistics
    public $totalRacks = 0;
    public $totalColumns = 0;
    public $totalSheets = 0;

    protected function rules()
    {
        if ($this->modalMode === 'single') {
            return [
                'type_rack' => 'required|string|max:50',
                'column_rack' => 'required|string|max:10',
                'sheet_rack' => 'required|string|max:10',
            ];
        } else {
            $rules = [
                'type_rack' => 'required|string|max:50',
                'add_mode' => 'required|in:rack,column,sheet',
            ];
            
            if (in_array($this->add_mode, ['rack', 'column'])) {
                $rules['add_columns'] = 'required|integer|min:1|max:100';
                $rules['sheets_per_column'] = 'required|integer|min:1|max:50';
            }
            
            if ($this->add_mode === 'sheet') {
                $rules['target_column'] = 'required|integer|min:1';
                $rules['add_sheets'] = 'required|integer|min:1|max:50';
            }
            
            return $rules;
        }
    }

    protected $messages = [
        'type_rack.required' => 'Rack type is required.',
        'column_rack.required' => 'Column rack is required.',
        'sheet_rack.required' => 'Sheet rack is required.',
        'add_columns.required' => 'Number of columns is required.',
        'add_columns.min' => 'Minimum 1 column.',
        'sheets_per_column.required' => 'Sheets per column is required.',
        'target_column.required' => 'Target column is required.',
        'add_sheets.required' => 'Number of sheets is required.',
    ];

    public function mount()
    {
        $this->loadStatistics();
        
        // Set default rack type pertama
        $firstRack = MasterRackSample::select('type_rack')
            ->groupBy('type_rack')
            ->orderBy('type_rack')
            ->first();
            
        $this->activeRackType = $firstRack?->type_rack;
    }

    public function loadStatistics()
    {
        $this->totalRacks = MasterRackSample::count();
        $this->totalColumns = MasterRackSample::distinct('column_rack')->count('column_rack');
        $this->totalSheets = MasterRackSample::count();
    }

    public function getRackTypes()
    {
        return MasterRackSample::select('type_rack')
            ->selectRaw('COUNT(DISTINCT column_rack) as total_columns')
            ->selectRaw('COUNT(*) as total_sheets')
            ->groupBy('type_rack')
            ->orderBy('type_rack')
            ->get();
    }

    public function getRackData()
    {
        $query = MasterRackSample::with(['samples' => function($query) {
            $query->with(['historydDetails' => function($q) {
                $q->latest('out_date')->limit(1);
            }, 'details' => function($q) {
                $q->latest('expired_date');
            }]);
        }]);
        
        // Jika ada type rack yang dipilih, filter
        if ($this->activeRackType) {
            $query->where('type_rack', $this->activeRackType);
        }
        
        // Apply search
        $query->when($this->search, function($q) {
            $q->where(function($query) {
                $query->where('column_rack', 'like', '%' . $this->search . '%')
                    ->orWhere('sheet_rack', 'like', '%' . $this->search . '%');
            });
        });
        
        $racks = $query->orderBy('type_rack')
            ->orderBy('column_rack', 'asc')
            ->orderBy('sheet_rack', 'asc')
            ->get()
            ->groupBy('column_rack');
            
        return $racks;
    }

    public function getSheetAvailability($rack)
    {
        $defaultResponse = [
            'status' => 'unknown',
            'label' => 'Unknown',
            'color' => 'gray',
            'bg_color' => '#f3f4f6',
            'text_color' => '#6b7280',
            'border_color' => '#e5e7eb',
            'dot_color' => '#9ca3af',
            'sample_count' => 0,
            'samples' => []
        ];
        
        if ($rack->samples->isEmpty()) {
            return array_merge($defaultResponse, [
                'status' => 'available',
                'label' => 'Available',
                'color' => 'success',
                'bg_color' => '#dcfce7',
                'text_color' => '#166534',
                'border_color' => '#86efac',
                'dot_color' => '#10b981',
                'sample_count' => 0
            ]);
        }
        
        $sampleInfo = [];
        $hasInUse = false;
        $hasExpired = false;
        
        foreach ($rack->samples as $sample) {
            $latestHistory = $sample->historydDetails->first();
            $latestDetail = $sample->details->sortByDesc('expired_date')->first();
            $expiredDate = $latestDetail?->expired_date;
            
            $status = 'filled';
            if ($latestHistory && in_array($latestHistory->status, ['in_use', 'loaning'])) {
                $status = 'in_use';
                $hasInUse = true;
            } elseif ($expiredDate && Carbon::parse($expiredDate)->isPast()) {
                $status = 'expired';
                $hasExpired = true;
            }
            
            $sampleInfo[] = [
                'id' => $sample->id,
                'model_name' => $sample->model_name,
                'customer' => $sample->customer,
                'name_or_mc' => $sample->name_or_mc,
                'status' => $status,
                'sample_ok' => $sample->sample_ok,
                'sample_ng' => $sample->sample_ng,
                'expired_date' => $expiredDate ? Carbon::parse($expiredDate)->format('Y-m-d') : null,
            ];
        }
        
        if ($hasInUse) {
            return array_merge($defaultResponse, [
                'status' => 'in_use',
                'label' => 'In Use',
                'color' => 'warning',
                'bg_color' => '#fef3c7',
                'text_color' => '#92400e',
                'border_color' => '#fcd34d',
                'dot_color' => '#f59e0b',
                'sample_count' => count($sampleInfo),
                'samples' => $sampleInfo
            ]);
        }
        
        if ($hasExpired) {
            return array_merge($defaultResponse, [
                'status' => 'expired',
                'label' => 'Expired',
                'color' => 'gray',
                'bg_color' => '#f3f4f6',
                'text_color' => '#6b7280',
                'border_color' => '#d1d5db',
                'dot_color' => '#6b7280',
                'sample_count' => count($sampleInfo),
                'samples' => $sampleInfo
            ]);
        }
        
        return array_merge($defaultResponse, [
            'status' => 'filled',
            'label' => 'Filled',
            'color' => 'danger',
            'bg_color' => '#fee2e2',
            'text_color' => '#991b1b',
            'border_color' => '#fecaca',
            'dot_color' => '#ef4444',
            'sample_count' => count($sampleInfo),
            'samples' => $sampleInfo
        ]);
    }
    
    public function openSheetDetail($rackId, $column)
    {
        $rack = MasterRackSample::with(['samples' => function($query) {
                $query->with(['historydDetails' => function($q) {
                    $q->latest('out_date')->limit(1);
                }, 'details' => function($q) {
                    $q->latest('expired_date');
                }]);
            }])
            ->find($rackId);
            
        if (!$rack) {
            $this->dispatch('notify', message: 'Sheet not found!', type: 'error');
            return;
        }
        
        $this->selectedSheet = [
            'sheet' => $rack,
            'column' => $column,
            'availability' => $this->getSheetAvailability($rack)
        ];
        
        $this->dispatch('open-sheet-modal');
    }
    
    public function openSingleModal()
    {
        $this->resetForm();
        $this->modalMode = 'single';
        $this->modalTitle = 'Add Single Rack';
        $this->dispatch('open-modal', 'rack-form-modal');
    }
    
    public function openBulkModal()
    {
        $this->resetForm();
        $this->modalMode = 'bulk';
        $this->modalTitle = 'Bulk Add Racks';
        $this->add_mode = 'rack';
        $this->add_columns = 1;
        $this->sheets_per_column = 10;
        $this->target_column = 1;
        $this->add_sheets = 5;
        $this->dispatch('open-modal', 'rack-form-modal');
    }
    
    public function resetForm()
    {
        $this->reset(['rack_id', 'type_rack', 'column_rack', 'sheet_rack']);
        $this->resetValidation();
    }
    
    public function edit($id)
    {
        $rack = MasterRackSample::find($id);
        
        if (!$rack) {
            $this->dispatch('notify', message: 'Rack not found!', type: 'error');
            return;
        }
        
        $this->rack_id = $rack->id;
        $this->type_rack = $rack->type_rack;
        $this->column_rack = $rack->column_rack;
        $this->sheet_rack = $rack->sheet_rack;
        $this->modalMode = 'single';
        $this->modalTitle = 'Edit Rack';
        
        $this->dispatch('open-modal', 'rack-form-modal');
    }
    
    public function save()
    {
        $this->validate();
        
        DB::beginTransaction();
        
        try {
            if ($this->modalMode === 'single') {
                $this->saveSingle();
            } else {
                $this->saveBulk();
            }
            
            DB::commit();
            $this->loadStatistics();
            $this->dispatch('close-modal', 'rack-form-modal');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', message: 'Error: ' . $e->getMessage(), type: 'error');
        }
    }
    
    private function saveSingle()
    {
        $data = [
            'type_rack' => $this->type_rack,
            'column_rack' => $this->column_rack,
            'sheet_rack' => $this->sheet_rack,
        ];
        
        if ($this->rack_id) {
            $rack = MasterRackSample::find($this->rack_id);
            if (!$rack) {
                throw new \Exception('Rack not found');
            }
            $rack->update($data);
            $message = 'Rack updated successfully!';
        } else {
            $exists = MasterRackSample::where('type_rack', $this->type_rack)
                ->where('column_rack', $this->column_rack)
                ->where('sheet_rack', $this->sheet_rack)
                ->exists();
                
            if ($exists) {
                throw new \Exception('Rack already exists!');
            }
            
            MasterRackSample::create($data);
            $message = 'Rack created successfully!';
        }
        
        $this->dispatch('notify', message: $message);
        $this->resetForm();
        
        // Refresh rack type if needed
        if (!$this->activeRackType) {
            $firstRack = MasterRackSample::select('type_rack')
                ->groupBy('type_rack')
                ->orderBy('type_rack')
                ->first();
            $this->activeRackType = $firstRack?->type_rack;
        }
    }
    
    private function saveBulk()
    {
        $typeRack = $this->type_rack;
        $mode = $this->add_mode;
        $created = 0;
        
        // Mode RACK (buat rack baru dari awal)
        if ($mode === 'rack') {
            $addColumns = (int) $this->add_columns;
            $sheets = (int) $this->sheets_per_column;
            
            for ($col = 1; $col <= $addColumns; $col++) {
                for ($sheet = 1; $sheet <= $sheets; $sheet++) {
                    MasterRackSample::firstOrCreate([
                        'type_rack' => $typeRack,
                        'column_rack' => (string) $col,
                        'sheet_rack' => (string) $sheet,
                    ]);
                    $created++;
                }
            }
        }
        
        // Mode COLUMN (tambah column baru di rack yang sudah ada)
        if ($mode === 'column') {
            $addColumns = (int) $this->add_columns;
            $sheets = (int) $this->sheets_per_column;
            
            $startColumn = MasterRackSample::where('type_rack', $typeRack)
                ->max('column_rack') + 1;
            
            for ($c = 0; $c < $addColumns; $c++) {
                $column = $startColumn + $c;
                for ($sheet = 1; $sheet <= $sheets; $sheet++) {
                    MasterRackSample::firstOrCreate([
                        'type_rack' => $typeRack,
                        'column_rack' => (string) $column,
                        'sheet_rack' => (string) $sheet,
                    ]);
                    $created++;
                }
            }
        }
        
        // Mode SHEET (tambah sheet di column tertentu)
        if ($mode === 'sheet') {
            $column = (int) $this->target_column;
            $addSheet = (int) $this->add_sheets;
            
            $startSheet = MasterRackSample::where('type_rack', $typeRack)
                ->where('column_rack', (string) $column)
                ->max('sheet_rack') + 1;
            
            for ($s = 0; $s < $addSheet; $s++) {
                MasterRackSample::firstOrCreate([
                    'type_rack' => $typeRack,
                    'column_rack' => (string) $column,
                    'sheet_rack' => (string) ($startSheet + $s),
                ]);
                $created++;
            }
        }
        
        $this->dispatch('notify', message: "Success! {$created} racks created.", type: 'success');
        $this->resetForm();
        
        // Refresh rack type if needed
        if (!$this->activeRackType) {
            $firstRack = MasterRackSample::select('type_rack')
                ->groupBy('type_rack')
                ->orderBy('type_rack')
                ->first();
            $this->activeRackType = $firstRack?->type_rack;
        }
    }
    
    public function confirmDelete($id)
    {
        $rack = MasterRackSample::find($id);
        
        if (!$rack) {
            $this->dispatch('notify', message: 'Rack not found!', type: 'error');
            return;
        }
        
        if ($rack->samples()->exists()) {
            $this->dispatch('notify', message: 'Cannot delete rack that has samples!', type: 'error');
            return;
        }
        
        $this->rackToDelete = $rack;
        $this->dispatch('open-modal', 'delete-rack-modal');
    }
    
    public function delete()
    {
        if (!$this->rackToDelete) {
            $this->dispatch('notify', message: 'No rack selected!', type: 'error');
            return;
        }
        
        $rackName = "{$this->rackToDelete->type_rack} - Col {$this->rackToDelete->column_rack} - Sheet {$this->rackToDelete->sheet_rack}";
        $this->rackToDelete->delete();
        
        $this->rackToDelete = null;
        $this->dispatch('notify', message: "Rack '{$rackName}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-rack-modal');
        $this->loadStatistics();
        
        // Refresh rack type if needed
        $remainingRacks = MasterRackSample::where('type_rack', $this->activeRackType)->exists();
        if (!$remainingRacks) {
            $firstRack = MasterRackSample::select('type_rack')
                ->groupBy('type_rack')
                ->orderBy('type_rack')
                ->first();
            $this->activeRackType = $firstRack?->type_rack;
        }
    }
    
    public function cancelDelete()
    {
        $this->rackToDelete = null;
        $this->dispatch('close-modal', 'delete-rack-modal');
    }
    
    public function closeSheetModal()
    {
        $this->selectedSheet = null;
        $this->dispatch('close-modal', 'sheet-detail-modal');
    }
    
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $rackTypes = $this->getRackTypes();
        $rackData = $this->getRackData();
        
        return view('livewire.prod.ms.rack.master-rack-sample-management', [
            'rackTypes' => $rackTypes,
            'rackData' => $rackData,
            'activeRackType' => $this->activeRackType,
        ]);
    }
}