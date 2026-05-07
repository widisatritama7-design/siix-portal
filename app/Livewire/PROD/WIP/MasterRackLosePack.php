<?php

namespace App\Livewire\PROD\WIP;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PROD\WIP\RackLosePack;
use App\Models\PROD\WIP\DetailWip;

class MasterRackLosePack extends Component
{
    use WithPagination;

    // Filter properties
    public $search = '';
    public $status = '';
    public $perPage = 20;
    
    // Add Rack
    public $newRackNo = '';
    public $newRackSheetCount = 1;
    public $newRackColumnCount = 4;
    
    // Delete properties
    public $selectedRackNo = null;
    public $selectedSheetForDelete = null;
    public $selectedColumnsForDelete = [];
    public $availableRacksForDelete = [];
    public $availableSlotsForDelete = [];
    
    // Modal
    public $showDetailModal = false;
    public $selectedRack = null;
    
    // Modal Add Sheet
    public $showAddSheetModal = false;
    public $selectedRackForAddSheet = null;
    public $newSheetName = '';
    public $availableRacksForAddSheet = [];
    
    // Modal Add Column
    public $showAddColumnModal = false;
    public $selectedRackForAddColumn = null;
    public $selectedSheetForAddColumn = null;
    public $newColumnName = '';
    public $availableRacksForAddColumn = [];
    public $availableSheetsForAddColumn = [];
    
    // Alerts
    public $showSuccessAlert = false;
    public $successMessage = '';
    public $showErrorAlert = false;
    public $errorMessage = '';
    
    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'perPage' => ['except' => 20],
    ];
    
    public function mount()
    {
        $this->loadAvailableRacksForDelete();
        $this->loadAvailableRacksForAddSheet();
        $this->loadAvailableRacksForAddColumn();
    }

    // Load racks for add sheet
    public function loadAvailableRacksForAddSheet()
    {
        $this->availableRacksForAddSheet = RackLosePack::select('no_rack')
            ->groupBy('no_rack')
            ->orderBy('no_rack')
            ->get();
    }

    // Load racks for add column
    public function loadAvailableRacksForAddColumn()
    {
        $this->availableRacksForAddColumn = RackLosePack::select('no_rack')
            ->groupBy('no_rack')
            ->orderBy('no_rack')
            ->get();
    }

    // Load sheets for add column - PASTIKAN METHOD INI BERJALAN
    public function loadSheetsForAddColumn()
    {
        \Log::info('loadSheetsForAddColumn called with rack: ' . $this->selectedRackForAddColumn);
        
        if ($this->selectedRackForAddColumn) {
            $this->availableSheetsForAddColumn = RackLosePack::where('no_rack', $this->selectedRackForAddColumn)
                ->select('sheet_rack')
                ->groupBy('sheet_rack')
                ->orderBy('sheet_rack')
                ->get();
            
            \Log::info('Sheets found: ' . $this->availableSheetsForAddColumn->count());
        } else {
            $this->availableSheetsForAddColumn = collect();
            \Log::info('No rack selected, sheets cleared');
        }
    }

    // Open Add Sheet Modal
    public function openAddSheetModal()
    {
        $this->reset(['selectedRackForAddSheet', 'newSheetName']);
        $this->loadAvailableRacksForAddSheet();
        $this->showAddSheetModal = true;
    }

    // Close Add Sheet Modal
    public function closeAddSheetModal()
    {
        $this->showAddSheetModal = false;
        $this->reset(['selectedRackForAddSheet', 'newSheetName']);
    }

    // Tambahkan method ini untuk debugging dan memastikan data ada
    public function getAvailableRacksForAddColumnProperty()
    {
        return RackLosePack::select('no_rack')
            ->groupBy('no_rack')
            ->orderBy('no_rack')
            ->get();
    }

    // Panggil ini di mount dan openAddColumnModal
    public function openAddColumnModal()
    {
        $this->reset(['selectedRackForAddColumn', 'selectedSheetForAddColumn', 'newColumnName']);
        
        // Load data segar dari database
        $this->availableRacksForAddColumn = RackLosePack::select('no_rack')
            ->groupBy('no_rack')
            ->orderBy('no_rack')
            ->get();
        
        $this->availableSheetsForAddColumn = collect();
        $this->showAddColumnModal = true;
        
        // Debug: Log ke browser console
        $this->dispatch('racks-loaded', racks: $this->availableRacksForAddColumn->toArray());
    }

    // Update method updatedSelectedRackForAddColumn
    public function updatedSelectedRackForAddColumn($value)
    {
        \Log::info('Rack selected: ' . $value);
        
        $this->selectedSheetForAddColumn = null;
        
        if ($value) {
            $this->availableSheetsForAddColumn = RackLosePack::where('no_rack', $value)
                ->select('sheet_rack')
                ->groupBy('sheet_rack')
                ->orderBy('sheet_rack')
                ->get();
                
            \Log::info('Sheets found: ' . $this->availableSheetsForAddColumn->count());
        } else {
            $this->availableSheetsForAddColumn = collect();
        }
    }

    // Close Add Column Modal
    public function closeAddColumnModal()
    {
        $this->showAddColumnModal = false;
        $this->reset(['selectedRackForAddColumn', 'selectedSheetForAddColumn', 'newColumnName']);
    }

    // Add Sheet method - PERBAIKAN
    public function addSheet()
    {
        // Debug: cek apakah method dipanggil
        \Log::info('addSheet dipanggil', [
            'selectedRackForAddSheet' => $this->selectedRackForAddSheet,
            'newSheetName' => $this->newSheetName
        ]);
        
        $validated = $this->validate([
            'selectedRackForAddSheet' => 'required|string',
            'newSheetName' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s]+$/',
        ], [
            'selectedRackForAddSheet.required' => 'Pilih rack terlebih dahulu!',
            'newSheetName.required' => 'Nama sheet harus diisi!',
            'newSheetName.regex' => 'Nama sheet hanya boleh berisi huruf, angka, dan spasi!',
        ]);

        // Cek apakah sheet sudah ada
        $exists = RackLosePack::where('no_rack', $this->selectedRackForAddSheet)
            ->where('sheet_rack', $this->newSheetName)
            ->exists();

        if ($exists) {
            $this->errorMessage = "Sheet '{$this->newSheetName}' sudah ada pada rack '{$this->selectedRackForAddSheet}'!";
            $this->showErrorAlert = true;
            return;
        }

        // Dapatkan jumlah column dari sheet pertama yang ada di rack ini
        $firstSheet = RackLosePack::where('no_rack', $this->selectedRackForAddSheet)
            ->select('sheet_rack')
            ->groupBy('sheet_rack')
            ->first();
        
        $maxColumns = 4; // default
        
        if ($firstSheet) {
            $maxColumns = RackLosePack::where('no_rack', $this->selectedRackForAddSheet)
                ->where('sheet_rack', $firstSheet->sheet_rack)
                ->count();
        }

        // Buat column untuk sheet baru
        for ($i = 1; $i <= $maxColumns; $i++) {
            RackLosePack::create([
                'no_rack' => $this->selectedRackForAddSheet,
                'sheet_rack' => $this->newSheetName,
                'column_rack' => 'Column ' . $i,
            ]);
        }

        $sheetNameAdded = $this->newSheetName;
        
        // Refresh semua data
        $this->refreshAllData();
        
        // Reset form
        $this->selectedRackForAddSheet = null;
        $this->newSheetName = '';
        
        // Tutup modal
        $this->showAddSheetModal = false;
        
        $this->successMessage = "Sheet '{$sheetNameAdded}' berhasil ditambahkan dengan {$maxColumns} column!";
        $this->showSuccessAlert = true;
        
        // Auto hide alert after 3 seconds
        $this->dispatch('hide-alert');
    }

    // Add Column method - VERSI PALAMING SIMPLE UNTUK TEST
    public function addColumn()
    {
        try {
            // Debug ke log
            \Log::info('=== ADD COLUMN START ===');
            \Log::info('selectedRackForAddColumn: ' . $this->selectedRackForAddColumn);
            \Log::info('selectedSheetForAddColumn: ' . $this->selectedSheetForAddColumn);
            \Log::info('newColumnName: ' . $this->newColumnName);
            
            // Validasi manual
            if (empty($this->selectedRackForAddColumn)) {
                $this->errorMessage = 'Pilih rack terlebih dahulu!';
                $this->showErrorAlert = true;
                \Log::error('Rack is empty');
                return;
            }
            
            if (empty($this->selectedSheetForAddColumn)) {
                $this->errorMessage = 'Pilih sheet terlebih dahulu!';
                $this->showErrorAlert = true;
                \Log::error('Sheet is empty');
                return;
            }
            
            if (empty($this->newColumnName)) {
                $this->errorMessage = 'Nama column harus diisi!';
                $this->showErrorAlert = true;
                \Log::error('Column name is empty');
                return;
            }
            
            // Cek apakah column sudah ada
            $exists = RackLosePack::where('no_rack', $this->selectedRackForAddColumn)
                ->where('sheet_rack', $this->selectedSheetForAddColumn)
                ->where('column_rack', $this->newColumnName)
                ->exists();
                
            \Log::info('Column exists: ' . ($exists ? 'YES' : 'NO'));
            
            if ($exists) {
                $this->errorMessage = "Column '{$this->newColumnName}' sudah ada pada sheet '{$this->selectedSheetForAddColumn}'!";
                $this->showErrorAlert = true;
                return;
            }
            
            // Tambah column baru
            $newColumn = RackLosePack::create([
                'no_rack' => $this->selectedRackForAddColumn,
                'sheet_rack' => $this->selectedSheetForAddColumn,
                'column_rack' => $this->newColumnName,
            ]);
            
            \Log::info('Column created with ID: ' . ($newColumn ? $newColumn->id : 'FAILED'));
            
            $sheetName = $this->selectedSheetForAddColumn;
            $columnNameAdded = $this->newColumnName;
            
            // Refresh semua data
            $this->refreshAllData();
            
            // Reset form
            $this->selectedRackForAddColumn = null;
            $this->selectedSheetForAddColumn = null;
            $this->newColumnName = '';
            
            // Tutup modal
            $this->showAddColumnModal = false;
            
            $this->successMessage = "Column '{$columnNameAdded}' berhasil ditambahkan ke sheet '{$sheetName}'!";
            $this->showSuccessAlert = true;
            
            // Dispatch event untuk hide alert
            $this->dispatch('alert-shown');
            
            \Log::info('=== ADD COLUMN END ===');
            
        } catch (\Exception $e) {
            \Log::error('Error in addColumn: ' . $e->getMessage());
            $this->errorMessage = 'Terjadi kesalahan: ' . $e->getMessage();
            $this->showErrorAlert = true;
        }
    }

    // Refresh all data method
    public function refreshAllData()
    {
        $this->loadAvailableRacksForDelete();
        $this->loadAvailableRacksForAddSheet();
        $this->loadAvailableRacksForAddColumn();
        $this->loadSheetsForAddColumn();
        $this->availableSlotsForDelete = collect();
        
        // Reset pagination
        $this->resetPage();
    }

    // Tambahkan method ini di akhir class, sebelum render()
    public function debugCheckData()
    {
        // Cek data via Query Builder langsung
        $racks = \DB::table('tb_prod_rack_lose_packs')
            ->select('no_rack')
            ->distinct()
            ->orderBy('no_rack')
            ->get();
        
        \Log::info('Total racks in DB: ' . $racks->count());
        \Log::info('Racks: ' . $racks->toJson());
        
        $this->availableRacksForAddColumn = $racks;
        $this->dispatch('racks-loaded', racks: $racks->toArray());
        
        $this->successMessage = 'Found ' . $racks->count() . ' racks: ' . $racks->pluck('no_rack')->implode(', ');
        $this->showSuccessAlert = true;
    }
    
    public function getRacksProperty()
    {
        $query = RackLosePack::with(['detailWip.masterWip']);
        
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('no_rack', 'like', "%{$this->search}%")
                  ->orWhere('sheet_rack', 'like', "%{$this->search}%")
                  ->orWhere('column_rack', 'like', "%{$this->search}%");
            });
        }
        
        if ($this->status === 'available') {
            $query->whereDoesntHave('detailWip');
        } elseif ($this->status === 'used') {
            $query->whereHas('detailWip');
        }
        
        return $query->orderBy('no_rack')
            ->orderBy('sheet_rack')
            ->orderBy('column_rack')
            ->paginate($this->perPage);
    }
    
    public function getTotalStatsProperty()
    {
        return [
            'total' => RackLosePack::count(),
            'available' => RackLosePack::whereDoesntHave('detailWip')->count(),
            'used' => RackLosePack::whereHas('detailWip')->count(),
            'totalWip' => DetailWip::whereNotNull('rack_lose_pack_id')->count(),
        ];
    }
    
    public function loadAvailableRacksForDelete()
    {
        $allRacks = RackLosePack::select('no_rack')
            ->selectRaw('COUNT(*) as total_slots')
            ->groupBy('no_rack')
            ->get();
        
        $availableRacks = collect();
        
        foreach ($allRacks as $rack) {
            $availableSlotsCount = RackLosePack::where('no_rack', $rack->no_rack)
                ->whereDoesntHave('detailWip')
                ->count();
            
            if ($availableSlotsCount > 0) {
                $availableRacks->push((object)[
                    'no_rack' => $rack->no_rack,
                    'total_slots' => $rack->total_slots,
                    'available_slots' => $availableSlotsCount
                ]);
            }
        }
        
        $this->availableRacksForDelete = $availableRacks;
    }
    
    public function loadAvailableSlotsForDelete()
    {
        if (empty($this->selectedRackNo)) {
            $this->availableSlotsForDelete = collect();
            $this->selectedColumnsForDelete = [];
            return;
        }
        
        $slots = RackLosePack::where('no_rack', $this->selectedRackNo)
            ->whereDoesntHave('detailWip')
            ->orderBy('sheet_rack')
            ->orderBy('column_rack')
            ->get();
        
        $this->availableSlotsForDelete = $slots->map(function ($slot) {
            return (object)[
                'id' => $slot->id,
                'no_rack' => $slot->no_rack,
                'sheet_rack' => $slot->sheet_rack,
                'column_rack' => $slot->column_rack,
                'display_name' => $slot->sheet_rack . ' - ' . $slot->column_rack,
            ];
        });
    }
    
    public function updatedSelectedRackNo()
    {
        $this->selectedSheetForDelete = null;
        $this->selectedColumnsForDelete = [];
        $this->loadAvailableSlotsForDelete();
    }
    
    public function updatedSelectedSheetForDelete()
    {
        $this->selectedColumnsForDelete = [];
    }
    
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function updatedStatus()
    {
        $this->resetPage();
    }
    
    public function updatedPerPage()
    {
        $this->resetPage();
    }
    
    public function resetFilters()
    {
        $this->search = '';
        $this->status = '';
        $this->perPage = 20;
        $this->resetPage();
    }
    
    public function selectAllColumnsInSheet()
    {
        if (empty($this->selectedRackNo) || empty($this->selectedSheetForDelete)) {
            return;
        }
        
        $this->selectedColumnsForDelete = $this->availableSlotsForDelete
            ->filter(function($slot) {
                return $slot->sheet_rack === $this->selectedSheetForDelete;
            })
            ->pluck('id')
            ->toArray();
    }
    
    public function clearSelectedColumns()
    {
        $this->selectedColumnsForDelete = [];
    }
    
    public function addRack()
    {
        $this->validate([
            'newRackNo' => 'required|string|max:255',
            'newRackSheetCount' => 'required|integer|min:1|max:20',
            'newRackColumnCount' => 'required|integer|min:1|max:4',
        ]);
        
        for ($sheet = 1; $sheet <= $this->newRackSheetCount; $sheet++) {
            $sheetName = 'Sheet ' . $sheet;
            
            for ($column = 1; $column <= $this->newRackColumnCount; $column++) {
                $columnName = 'Column ' . $column;
                
                $exists = RackLosePack::where('no_rack', $this->newRackNo)
                    ->where('sheet_rack', $sheetName)
                    ->where('column_rack', $columnName)
                    ->exists();
                    
                if ($exists) {
                    $this->errorMessage = "Kombinasi Rack '{$this->newRackNo}' - {$sheetName} - {$columnName} sudah ada!";
                    $this->showErrorAlert = true;
                    return;
                }
            }
        }
        
        for ($sheet = 1; $sheet <= $this->newRackSheetCount; $sheet++) {
            $sheetName = 'Sheet ' . $sheet;
            
            for ($column = 1; $column <= $this->newRackColumnCount; $column++) {
                $columnName = 'Column ' . $column;
                
                RackLosePack::create([
                    'no_rack' => $this->newRackNo,
                    'sheet_rack' => $sheetName,
                    'column_rack' => $columnName,
                ]);
            }
        }
        
        $totalSlots = $this->newRackSheetCount * $this->newRackColumnCount;
        
        $this->newRackNo = '';
        $this->newRackSheetCount = 1;
        $this->newRackColumnCount = 4;
        
        $this->refreshAllData();
        
        $this->successMessage = "Rack berhasil ditambahkan dengan {$totalSlots} slot!";
        $this->showSuccessAlert = true;
    }
    
    public function deleteColumns()
    {
        if (empty($this->selectedColumnsForDelete)) {
            $this->errorMessage = 'Pilih column yang akan dihapus!';
            $this->showErrorAlert = true;
            return;
        }
        
        $count = 0;
        $errors = [];
        $successNames = [];
        
        foreach ($this->selectedColumnsForDelete as $columnId) {
            $column = RackLosePack::find($columnId);
            
            if (!$column) {
                $errors[] = "Column ID $columnId tidak ditemukan!";
                continue;
            }
            
            if (!$column->isAvailable()) {
                $errors[] = "Column {$column->column_rack} pada {$column->sheet_rack} sedang terisi WIP!";
                continue;
            }
            
            $successNames[] = $column->sheet_rack . ' - ' . $column->column_rack;
            $column->delete();
            $count++;
        }
        
        $this->selectedColumnsForDelete = [];
        $this->selectedSheetForDelete = null;
        $this->selectedRackNo = null;
        
        $this->refreshAllData();
        
        if ($count > 0) {
            $this->successMessage = "$count column berhasil dihapus!";
            $this->showSuccessAlert = true;
        }
        
        if (!empty($errors)) {
            $this->errorMessage = implode(' ', $errors);
            $this->showErrorAlert = true;
        }
    }
    
    public function showDetail($rackId)
    {
        $this->selectedRack = RackLosePack::with(['detailWip.masterWip'])->find($rackId);
        $this->showDetailModal = true;
    }
    
    public function closeModal()
    {
        $this->showDetailModal = false;
        $this->selectedRack = null;
    }
    
    public function releaseRack($rackId)
    {
        $rack = RackLosePack::with('detailWip')->find($rackId);
        
        if ($rack && $rack->detailWip) {
            $rack->detailWip->update(['rack_lose_pack_id' => null]);
            
            $this->showDetailModal = false;
            $this->selectedRack = null;
            $this->refreshAllData();
            
            $this->successMessage = 'WIP berhasil dilepas dari rack!';
            $this->showSuccessAlert = true;
        }
    }
    
    public function render()
    {
        return view('livewire.prod.wip.master-rack-lose-pack', [
            'racks' => $this->racks,
            'totalStats' => $this->totalStats,
        ])->layout('layouts.app');
    }
}