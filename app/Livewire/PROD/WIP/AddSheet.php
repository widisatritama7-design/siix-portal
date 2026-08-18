<?php

namespace App\Livewire\PROD\WIP;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AddSheet extends Component
{
    public $selectedRack = null;
    public $newSheetName = '';
    public $availableRacks = [];
    
    public $showSuccessAlert = false;
    public $successMessage = '';
    public $showErrorAlert = false;
    public $errorMessage = '';
    
    public $totalData = 0;
    public $debugMessage = '';
    public $tableName = 'tb_prod_rack_lose_packs';
    public $connectionName = '';
    public $rawCount = 0;
    public $rawRacks = [];
    
    public function mount()
    {
        try {
            $this->connectionName = DB::connection()->getDatabaseName();
            
            // PAKAI DB FACADE 100%
            $this->totalData = DB::table('tb_prod_rack_lose_packs')->count();
            $this->rawCount = $this->totalData;
            
            Log::info('=== ADD SHEET MOUNT DEBUG ===');
            Log::info('Database: ' . $this->connectionName);
            Log::info('Total data: ' . $this->totalData);
            
            // Ambil semua rack untuk debug
            $this->rawRacks = DB::table('tb_prod_rack_lose_packs')
                ->select('no_rack')
                ->distinct()
                ->pluck('no_rack')
                ->toArray();
            
            Log::info('Raw racks found: ' . json_encode($this->rawRacks));
            
            // LOAD RACKS PAKAI DB FACADE
            $this->loadRacks();
            
            if ($this->availableRacks->isNotEmpty()) {
                $this->debugMessage = '✅ Data ditemukan! Total: ' . $this->totalData . ', Rack unik: ' . $this->availableRacks->count();
            } else {
                // Jika masih kosong, coba cara lain
                Log::warning('Available racks still empty, trying alternative query...');
                
                // Coba query alternatif
                $racks = DB::select('SELECT DISTINCT no_rack FROM tb_prod_rack_lose_packs ORDER BY no_rack');
                $this->availableRacks = collect($racks);
                
                Log::info('Alternative query result: ' . count($racks));
                
                if ($this->availableRacks->isNotEmpty()) {
                    $this->debugMessage = '✅ Data ditemukan (alternate query)! Total: ' . $this->totalData . ', Rack unik: ' . $this->availableRacks->count();
                } else {
                    $this->debugMessage = '⚠️ Data ditemukan (' . $this->totalData . ' records) tapi tidak bisa di-load.';
                }
            }
            
        } catch (\Exception $e) {
            Log::error('Mount error: ' . $e->getMessage());
            $this->debugMessage = 'Error: ' . $e->getMessage();
            $this->errorMessage = 'Error: ' . $e->getMessage();
            $this->showErrorAlert = true;
        }
    }
    
    public function loadRacks()
    {
        try {
            // Ambil sebagai array biasa
            $racks = DB::table('tb_prod_rack_lose_packs')
                ->select('no_rack')
                ->distinct()
                ->orderBy('no_rack')
                ->get()
                ->map(function($item) {
                    return (object) ['no_rack' => $item->no_rack];
                });
            
            $this->availableRacks = $racks;
            
            Log::info('Racks loaded: ' . $this->availableRacks->count());
            Log::info('Racks data: ' . json_encode($this->availableRacks));
            
        } catch (\Exception $e) {
            Log::error('Load racks error: ' . $e->getMessage());
            $this->availableRacks = collect();
        }
    }
    
    public function addSheet()
    {
        Log::info('=== ADD SHEET BUTTON CLICKED ===');
        Log::info('Selected Rack: "' . ($this->selectedRack ?? 'null') . '"');
        Log::info('New Sheet Name: "' . ($this->newSheetName ?? 'null') . '"');
        
        if (empty($this->selectedRack)) {
            $this->errorMessage = 'Silakan pilih rack terlebih dahulu!';
            $this->showErrorAlert = true;
            return;
        }
        
        if (empty($this->newSheetName)) {
            $this->errorMessage = 'Silakan isi nama sheet!';
            $this->showErrorAlert = true;
            return;
        }
        
        DB::beginTransaction();
        
        try {
            $newSheetName = strtoupper(trim($this->newSheetName));
            
            Log::info('Processing: Rack="' . $this->selectedRack . '", Sheet="' . $newSheetName . '"');
            
            // CEK PAKAI DB
            $exists = DB::table('tb_prod_rack_lose_packs')
                ->where('no_rack', $this->selectedRack)
                ->where('sheet_rack', $newSheetName)
                ->exists();
            
            if ($exists) {
                $this->errorMessage = "Sheet '{$newSheetName}' sudah ada pada rack '{$this->selectedRack}'!";
                $this->showErrorAlert = true;
                DB::rollBack();
                return;
            }
            
            // Dapatkan jumlah column
            $firstSheet = DB::table('tb_prod_rack_lose_packs')
                ->where('no_rack', $this->selectedRack)
                ->select('sheet_rack')
                ->first();
            
            $maxColumns = 4;
            if ($firstSheet) {
                $maxColumns = DB::table('tb_prod_rack_lose_packs')
                    ->where('no_rack', $this->selectedRack)
                    ->where('sheet_rack', $firstSheet->sheet_rack)
                    ->count();
                Log::info('Found existing sheet: ' . $firstSheet->sheet_rack . ' with ' . $maxColumns . ' columns');
            }
            
            // Buat sheet baru
            $createdCount = 0;
            for ($i = 1; $i <= $maxColumns; $i++) {
                $data = [
                    'no_rack' => $this->selectedRack,
                    'sheet_rack' => $newSheetName,
                    'column_rack' => 'COLUMN ' . $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                Log::info('Creating: ' . json_encode($data));
                
                $created = DB::table('tb_prod_rack_lose_packs')->insert($data);
                
                if ($created) {
                    $createdCount++;
                }
            }
            
            DB::commit();
            
            $this->selectedRack = null;
            $this->newSheetName = '';
            $this->loadRacks();
            
            $this->successMessage = "Sheet '{$newSheetName}' berhasil ditambahkan dengan {$createdCount} column!";
            $this->showSuccessAlert = true;
            
            Log::info('Add sheet success: ' . $newSheetName . ' with ' . $createdCount . ' columns');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->errorMessage = 'Error: ' . $e->getMessage();
            $this->showErrorAlert = true;
            Log::error('Add sheet error: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
        }
    }
    
    public function render()
    {
        return view('livewire.prod.wip.add-sheet');
    }
}