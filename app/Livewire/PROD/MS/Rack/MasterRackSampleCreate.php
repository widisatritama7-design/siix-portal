<?php

namespace App\Livewire\PROD\MS\Rack;

use App\Models\PROD\MS\MasterRackSample;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MasterRackSampleCreate extends Component
{
    // Form fields
    public $add_mode = 'rack'; // rack, column, sheet
    public $type_rack;
    public $add_columns = 1;
    public $sheets_per_column = 10;
    public $target_column = 1;
    public $add_sheets = 5;
    
    // Data untuk display
    public $current_columns = 0;
    public $existingColumns = [];
    public $existingSheets = [];
    public $rackSummary = '';

    protected function rules()
    {
        $rules = [
            'add_mode' => 'required|in:rack,column,sheet',
            'type_rack' => 'required|string|max:50',
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

    protected $messages = [
        'type_rack.required' => 'Rack type is required.',
        'add_mode.required' => 'Please select add mode.',
        'add_columns.required' => 'Number of columns is required.',
        'add_columns.min' => 'Minimum 1 column.',
        'sheets_per_column.required' => 'Sheets per column is required.',
        'target_column.required' => 'Target column is required.',
        'add_sheets.required' => 'Number of sheets is required.',
    ];

    public function updatedTypeRack()
    {
        $this->loadExistingData();
    }

    public function updatedAddMode()
    {
        $this->loadExistingData();
    }

    public function loadExistingData()
    {
        if (!$this->type_rack) {
            $this->current_columns = 0;
            $this->existingColumns = [];
            $this->existingSheets = [];
            $this->rackSummary = 'Masukkan Type Rack untuk melihat data existing.';
            return;
        }

        $racks = MasterRackSample::where('type_rack', $this->type_rack)
            ->orderBy('column_rack')
            ->orderBy('sheet_rack')
            ->get();

        if ($racks->isEmpty()) {
            $this->current_columns = 0;
            $this->existingColumns = [];
            $this->existingSheets = [];
            $this->rackSummary = "📦 Type Rack: {$this->type_rack}\n✨ Rack belum ada (Rack Baru)";
            return;
        }

        // Hitung columns
        $columns = $racks->pluck('column_rack')->unique()->sort()->values();
        $this->current_columns = $columns->count();
        $this->existingColumns = $columns->toArray();

        // Group sheets per column
        $sheetsData = $racks->groupBy('column_rack');
        $this->existingSheets = [];
        foreach ($sheetsData as $column => $sheets) {
            $maxSheet = $sheets->max('sheet_rack');
            $this->existingSheets[] = [
                'column' => $column,
                'max_sheet' => $maxSheet,
                'total_sheets' => $sheets->count()
            ];
        }

        // Summary
        $totalSheets = $racks->count();
        $this->rackSummary = "📦 Type Rack: {$this->type_rack}\n"
            . "🧱 Total Column: {$columns->count()}\n"
            . "📄 Total Sheet: {$totalSheets}";
    }

    public function getTargetColumnOptions()
    {
        if (!$this->type_rack) {
            return [];
        }
        
        return MasterRackSample::where('type_rack', $this->type_rack)
            ->pluck('column_rack', 'column_rack')
            ->unique()
            ->toArray();
    }

    public function save()
    {
        $this->validate();
        
        DB::beginTransaction();
        
        try {
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
            
            DB::commit();
            
            // Set notifikasi success
            session()->flash('message', "Berhasil! Total rack dibuat: {$created}");
            session()->flash('type', 'success');
            
            // LANGSUNG REDIRECT KE HALAMAN LIST
            return redirect()->route('prod.ms.master-rack');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', message: 'Error: ' . $e->getMessage(), type: 'error');
        }
    }
    
    public function back()
    {
        return redirect()->route('prod.ms.master-rack');
    }
    
    public function render()
    {
        return view('livewire.prod.ms.rack.master-rack-sample-create', [
            'targetColumnOptions' => $this->getTargetColumnOptions(),
        ]);
    }
}