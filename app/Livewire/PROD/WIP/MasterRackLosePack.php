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
        
        $this->loadAvailableRacksForDelete();
        $this->availableSlotsForDelete = collect();
        
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
        
        $this->loadAvailableRacksForDelete();
        $this->availableSlotsForDelete = collect();
        
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
            $this->loadAvailableRacksForDelete();
            
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