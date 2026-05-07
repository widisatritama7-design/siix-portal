<?php

namespace App\Livewire\PROD\WIP;

use Livewire\Component;
use App\Models\PROD\WIP\RackLosePack;

class AddColumn extends Component
{
    public $selectedRack = null;
    public $selectedSheet = null;
    public $newColumnName = '';
    public $availableRacks = [];
    public $availableSheets = [];
    
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
            ->get()
            ->toArray(); // Tambahkan toArray() untuk konsistensi
    }
    
    public function loadSheets()
    {
        if ($this->selectedRack) {
            $this->availableSheets = RackLosePack::where('no_rack', $this->selectedRack)
                ->select('sheet_rack')
                ->distinct()
                ->orderBy('sheet_rack')
                ->get()
                ->toArray(); // Tambahkan toArray()
        } else {
            $this->availableSheets = [];
        }
    }
    
    public function updatedSelectedRack()
    {
        $this->selectedSheet = null;
        $this->newColumnName = '';
        $this->loadSheets();
    }
    
    public function addColumn()
    {
        $this->validate([
            'selectedRack' => 'required|string',
            'selectedSheet' => 'required|string',
            'newColumnName' => 'required|string|max:255',
        ]);
        
        $newColumnName = strtoupper(trim($this->newColumnName)); // Tambahkan trim()
        
        // Cek apakah column sudah ada
        $exists = RackLosePack::where('no_rack', $this->selectedRack)
            ->where('sheet_rack', $this->selectedSheet)
            ->where('column_rack', $newColumnName)
            ->exists();
        
        if ($exists) {
            $this->errorMessage = "Column '{$newColumnName}' sudah ada pada sheet '{$this->selectedSheet}'!";
            $this->showErrorAlert = true;
            return;
        }
        
        // Tambah column baru
        try {
            RackLosePack::create([
                'no_rack' => $this->selectedRack,
                'sheet_rack' => $this->selectedSheet,
                'column_rack' => $newColumnName,
            ]);
            
            $sheetName = $this->selectedSheet;
            $columnName = $newColumnName;
            
            $this->reset(['selectedSheet', 'newColumnName']);
            $this->loadSheets();
            
            $this->successMessage = "Column '{$columnName}' berhasil ditambahkan ke sheet '{$sheetName}'!";
            $this->showSuccessAlert = true;
            
            // Emit event untuk refresh halaman utama
            $this->dispatch('column-added');
            
        } catch (\Exception $e) {
            $this->errorMessage = "Gagal menambahkan column: " . $e->getMessage();
            $this->showErrorAlert = true;
        }
    }
    
    // Method untuk reset alert (opsional)
    public function resetAlerts()
    {
        $this->showSuccessAlert = false;
        $this->showErrorAlert = false;
    }
    
    public function render()
    {
        return view('livewire.prod.wip.add-column');
    }
}