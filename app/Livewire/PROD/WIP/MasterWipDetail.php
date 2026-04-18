<?php
// app/Livewire/PROD/WIP/MasterWipDetail.php

namespace App\Livewire\PROD\WIP;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PROD\WIP\MasterWip;
use App\Models\PROD\WIP\DetailWip;
use App\Models\PROD\WIP\RackLosePack;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MasterWipDetail extends Component
{
    use WithPagination;

    public $masterWipId;
    public $masterWip;
    public $search_hu = '';
    public $perPage = 10;
    
    // Untuk modal rack
    public $showRackModal = false;
    public $selectedDetailId = null;
    public $selectedNoHu = null;
    public $rackSearch = '';
    public $availableRacks = [];
    
    protected $queryString = [
        'search_hu' => ['except' => ''],
        'perPage' => ['except' => 10],
        'page' => ['except' => 1],
    ];
    
    // Mount dengan parameter dari route
    public function mount($id = null)
    {
        // Ambil ID dari parameter route
        $this->masterWipId = $id;
        
        // Load data MasterWip
        $this->masterWip = MasterWip::with(['creator', 'updater'])->find($this->masterWipId);
        
        if (!$this->masterWip) {
            session()->flash('error', 'WIP not found!');
            return redirect()->route('prod.wip.index');
        }
    }
    
    public function getStatisticsProperty()
    {
        if (!$this->masterWip) {
            return [
                'total_scans' => 0,
                'total_qty' => 0,
                'total_ng' => 0,
                'current_acm' => 0,
                'remaining_qty' => 0,
                'progress_percentage' => 0,
            ];
        }
        
        $totalQty = DetailWip::where('master_wips_id', $this->masterWip->id)->sum('qty');
        $totalNg = DetailWip::where('master_wips_id', $this->masterWip->id)->sum('ng_count');
        $currentAcm = DetailWip::where('master_wips_id', $this->masterWip->id)->max('acm') ?? 0;
        
        return [
            'total_scans' => DetailWip::where('master_wips_id', $this->masterWip->id)->count(),
            'total_qty' => $totalQty,
            'total_ng' => $totalNg,
            'current_acm' => $currentAcm,
            'remaining_qty' => max($this->masterWip->lot_qty - $currentAcm, 0),
            'progress_percentage' => $this->masterWip->lot_qty > 0 
                ? round($currentAcm / $this->masterWip->lot_qty * 100, 2)
                : 0,
        ];
    }
    
    public function getDetailsProperty()
    {
        if (!$this->masterWip) {
            return new \Illuminate\Pagination\LengthAwarePaginator([], 0, $this->perPage);
        }
        
        $query = DetailWip::where('master_wips_id', $this->masterWip->id)
            ->with(['creator', 'rackLosePack']);
        
        if ($this->search_hu) {
            $query->where('no_hu', 'like', "%{$this->search_hu}%");
        }
        
        return $query->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
    }
    
    public function updatingSearchHu()
    {
        $this->resetPage();
    }
    
    public function updatingPerPage()
    {
        $this->resetPage();
    }
    
    public function resetSearch()
    {
        $this->search_hu = '';
        $this->resetPage();
    }
    
    public function openRackModal($detailId, $noHu)
    {
        $this->selectedDetailId = $detailId;
        $this->selectedNoHu = $noHu;
        $this->showRackModal = true;
        $this->rackSearch = '';
        $this->loadAvailableRacks();
    }
    
    public function closeRackModal()
    {
        $this->showRackModal = false;
        $this->selectedDetailId = null;
        $this->selectedNoHu = null;
        $this->availableRacks = [];
        $this->rackSearch = '';
    }
    
    public function loadAvailableRacks()
    {
        try {
            // Gunakan model RackLosePack dengan scope available
            $query = RackLosePack::available() // Hanya rack yang belum digunakan
                ->select('id', 'no_rack', 'sheet_rack', 'column_rack');
            
            if ($this->rackSearch) {
                $query->where(function($q) {
                    $q->where('no_rack', 'like', "%{$this->rackSearch}%")
                      ->orWhere('sheet_rack', 'like', "%{$this->rackSearch}%")
                      ->orWhere('column_rack', 'like', "%{$this->rackSearch}%");
                });
            }
            
            $racks = $query->groupedOrder() // Gunakan scope groupedOrder dari model
                ->limit(50)
                ->get();
            
            // Group by no_rack
            $grouped = [];
            foreach ($racks as $rack) {
                if (!isset($grouped[$rack->no_rack])) {
                    $grouped[$rack->no_rack] = [
                        'no_rack' => $rack->no_rack,
                        'items' => []
                    ];
                }
                $grouped[$rack->no_rack]['items'][] = $rack;
            }
            
            $this->availableRacks = $grouped;
            
            // Debug: log jumlah racks yang ditemukan
            \Log::info('Racks loaded: ' . $racks->count());
            
        } catch (\Exception $e) {
            Log::error('Error loading racks: ' . $e->getMessage());
            $this->availableRacks = [];
            $this->dispatch('notify', message: 'Error loading racks: ' . $e->getMessage(), type: 'error');
        }
    }
    
    public function updatedRackSearch()
    {
        $this->loadAvailableRacks();
    }
    
    public function saveRackSelection($rackId)
    {
        try {
            if (!$this->selectedDetailId) {
                $this->dispatch('notify', message: 'Detail ID not found', type: 'error');
                return;
            }
            
            // Cek apakah detail wip ada
            $detailWip = DetailWip::find($this->selectedDetailId);
            if (!$detailWip) {
                $this->dispatch('notify', message: 'Detail WIP not found', type: 'error');
                return;
            }
            
            // Cek apakah rack sudah digunakan
            $rackInUse = DetailWip::where('rack_lose_pack_id', $rackId)
                ->where('id', '!=', $this->selectedDetailId)
                ->exists();
            
            if ($rackInUse) {
                $rack = RackLosePack::find($rackId);
                $this->dispatch('notify', message: "Column {$rack->column_rack} di {$rack->sheet_rack} sudah digunakan oleh WIP lain", type: 'error');
                return;
            }
            
            DB::beginTransaction();
            
            $detailWip->update([
                'rack_lose_pack_id' => $rackId,
                'updated_by' => Auth::id(),
                'updated_at' => now()
            ]);
            
            DB::commit();
            
            $this->dispatch('notify', message: 'Rack column selected successfully!', type: 'success');
            $this->closeRackModal();
            
            // Refresh component
            $this->dispatch('$refresh');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving rack: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error saving rack: ' . $e->getMessage(), type: 'error');
        }
    }
    
    public function render()
    {
        return view('livewire.prod.wip.master-wip-detail', [
            'masterWip' => $this->masterWip,
            'statistics' => $this->statistics,
            'details' => $this->details,
        ])->layout('layouts.app');
    }
}