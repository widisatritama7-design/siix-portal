<?php

namespace App\Livewire\PROD\WIP;

use Livewire\Component;
use App\Models\PROD\WIP\RackLosePack;

class AddSheet extends Component
{
    public $selectedRack = null;
    public $newSheetName = '';
    public $availableRacks = [];
    
    public $showSuccessAlert = false;
    public $successMessage = '';
    public $showErrorAlert = false;
    public $errorMessage = '';
    
    public function mount()
    {
        $this->loadRacks();
    }
    
    public function loadRacks()
    {
        $this->availableRacks = RackLosePack::select('no_rack')
            ->distinct()
            ->orderBy('no_rack')
            ->get();
    }
    
    public function addSheet()
    {
        $this->validate([
            'selectedRack' => 'required|string',
            'newSheetName' => 'required|string|max:255',
        ]);
        
        $newSheetName = strtoupper($this->newSheetName);
        
        // Cek apakah sheet sudah ada
        $exists = RackLosePack::where('no_rack', $this->selectedRack)
            ->where('sheet_rack', $newSheetName)
            ->exists();
        
        if ($exists) {
            $this->errorMessage = "Sheet '{$newSheetName}' sudah ada pada rack '{$this->selectedRack}'!";
            $this->showErrorAlert = true;
            return;
        }
        
        // Dapatkan jumlah column dari sheet yang ada
        $firstSheet = RackLosePack::where('no_rack', $this->selectedRack)
            ->select('sheet_rack')
            ->first();
        
        $maxColumns = 4;
        if ($firstSheet) {
            $maxColumns = RackLosePack::where('no_rack', $this->selectedRack)
                ->where('sheet_rack', $firstSheet->sheet_rack)
                ->count();
        }
        
        // Buat sheet baru dengan column
        for ($i = 1; $i <= $maxColumns; $i++) {
            RackLosePack::create([
                'no_rack' => $this->selectedRack,
                'sheet_rack' => $newSheetName,
                'column_rack' => 'COLUMN ' . $i,
            ]);
        }
        
        $this->reset(['selectedRack', 'newSheetName']);
        $this->loadRacks();
        
        $this->successMessage = "Sheet '{$newSheetName}' berhasil ditambahkan dengan {$maxColumns} column!";
        $this->showSuccessAlert = true;
    }
    
    public function render()
    {
        return view('livewire.prod.wip.add-sheet')
            ->layout('layouts.app');
    }
}