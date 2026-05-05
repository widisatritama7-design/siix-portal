<?php
// app/Livewire/PROD/WIP/MasterWipScan.php

namespace App\Livewire\PROD\WIP;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PROD\WIP\MasterWip;
use App\Models\PROD\WIP\DetailWip;
use App\Models\PROD\WIP\RackLosePack;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MasterWipScan extends Component
{
    use WithPagination;

    public $masterWip;
    public $masterWipId;
    public $search_hu = '';
    public $perPage = 10;
    
    // Modal
    public $showRackModal = false;
    public $selectedDetailId = null;
    public $selectedNoHu = null;
    public $rackSearch = '';
    public $availableRacks = [];
    
    // Modal Add Manual
    public $showAddManualModal = false;
    public $manualNoHu = '';
    public $manualQty = 1;
    public $manualPartNumber = '';
    public $manualModel = '';
    
    protected $queryString = [
        'search_hu' => ['except' => ''],
        'perPage' => ['except' => 10],
        'page' => ['except' => 1],
    ];
    
    public function mount($id)
    {
        $this->masterWipId = $id;
        $this->masterWip = MasterWip::with(['creator', 'updater'])->find($id);
        
        if (!$this->masterWip) {
            session()->flash('error', 'WIP not found!');
            return redirect()->route('prod.wip.index');
        }
        
        // Set default values for manual add
        $this->manualPartNumber = $this->masterWip->part_number;
        $this->manualModel = $this->masterWip->model;
    }
    
    public function getStatisticsProperty()
    {
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
    
    public function scan($noHu)
    {
        if ($this->masterWip->isFinished()) {
            $this->dispatch('notify', message: 'This WIP is already finished.', type: 'error');
            return;
        }
        
        // Format: @part_number@no_hu@model@@qty@@
        $pattern = '/^@(?P<part_number>[^@]+)@(?P<no_hu>[^@]+)@(?P<model>[^@]+)@@(?P<qty>\d+)@@$/';
        
        if (!preg_match($pattern, $noHu, $matches)) {
            $this->dispatch('notify', message: 'Invalid No HU format. Expected: @part_number@no_hu@model@@qty@@', type: 'error');
            return;
        }
        
        $scannedPartNumber = trim($matches['part_number']);
        $scannedNoHu = trim($matches['no_hu']);
        $scannedModel = trim($matches['model']);
        $qty = (int)$matches['qty'];
        
        // VALIDASI PART NUMBER - HARUS SAMA!
        if ($scannedPartNumber !== $this->masterWip->part_number) {
            $this->dispatch('notify', message: "Part Number mismatch! Scanned: {$scannedPartNumber}, Expected: {$this->masterWip->part_number}", type: 'error');
            return;
        }
        
        // Validate model
        if ($scannedModel !== $this->masterWip->model) {
            $this->dispatch('notify', message: "Model mismatch! Scanned: {$scannedModel}, Expected: {$this->masterWip->model}", type: 'error');
            return;
        }
        
        // CEK DUPLICATE - TAMPILKAN ERROR DAN BATALKAN SCAN
        $existingDetail = DetailWip::where('master_wips_id', $this->masterWip->id)
            ->where('no_hu', 'like', "%{$scannedNoHu}%")
            ->exists();
            
        if ($existingDetail) {
            $this->dispatch('notify', message: "Duplicate No HU detected! No HU '{$scannedNoHu}' has already been scanned in this WIP.", type: 'error');
            return;
        }
        
        $lastDetail = DetailWip::where('master_wips_id', $this->masterWip->id)->latest()->first();
        $currentAcm = $lastDetail->acm ?? 0;
        
        // Check if exceeds lot quantity
        if (($currentAcm + $qty) > $this->masterWip->lot_qty) {
            $remaining = $this->masterWip->lot_qty - $currentAcm;
            $this->dispatch('notify', message: "Qty exceeds remaining lot quantity! Remaining: {$remaining}", type: 'error');
            return;
        }
        
        $this->processScan($scannedNoHu, $qty, $scannedPartNumber, $scannedModel);
    }
    
    private function processScan($noHu, $qty, $partNumber, $model)
    {
        $lastDetail = DetailWip::where('master_wips_id', $this->masterWip->id)->latest()->first();
        $currentAcm = $lastDetail->acm ?? 0;
        
        // Check if exceeds lot quantity
        if (($currentAcm + $qty) > $this->masterWip->lot_qty) {
            $remaining = $this->masterWip->lot_qty - $currentAcm;
            $this->dispatch('notify', message: "Qty exceeds remaining lot quantity! Remaining: {$remaining}", type: 'error');
            return;
        }
        
        try {
            DB::beginTransaction();
            
            // Construct the new no_hu string
            $newNoHu = "@{$partNumber}@{$noHu}@{$model}@@{$qty}@@";
            
            $acm = $currentAcm + $qty;
            $balance = $this->masterWip->lot_qty - $acm;
            $status = $balance > 0 ? 'In Progress' : 'Finished';
            
            DetailWip::create([
                'master_wips_id' => $this->masterWip->id,
                'no_hu' => $newNoHu,
                'qty' => $qty,
                'acm' => $acm,
                'balance' => $balance,
                'status' => $status,
                'ng_count' => 0,
                'created_by' => Auth::id(),
            ]);
            
            DB::commit();
            
            $this->dispatch('notify', message: "Scan successful! Qty: {$qty}", type: 'success');
            
            // Refresh data
            $this->masterWip = MasterWip::find($this->masterWipId);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error scanning: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error processing scan: ' . $e->getMessage(), type: 'error');
        }
    }
    
    // ========== ADD MANUAL METHODS ==========
    
    public function openAddManualModal()
    {
        $this->showAddManualModal = true;
        $this->manualNoHu = '';
        $this->manualQty = 1;
        $this->manualPartNumber = $this->masterWip->part_number;
        $this->manualModel = $this->masterWip->model;
    }
    
    public function closeAddManualModal()
    {
        $this->showAddManualModal = false;
        $this->manualNoHu = '';
        $this->manualQty = 1;
    }

    private function validateNoHuFormat($noHu)
    {
        $pattern = '#^@[^@]+@[^@]+@[^@]+@@\d+@@$#';
        
        if (!preg_match($pattern, $noHu)) {
            return false;
        }
        
        $invalidPatterns = ['/\[/', '/\)/', '/>/', '/\x1B/', '/\x1D/', '/\x1E/', '/\x1F/'];
        foreach ($invalidPatterns as $pattern) {
            if (preg_match($pattern, $noHu)) {
                return false;
            }
        }
        
        return true;
    }
    
    public function addManualScan()
    {
        $this->validate([
            'manualNoHu' => 'required|string|min:1',
            'manualQty' => 'required|integer|min:1'
        ]);
        
        if ($this->masterWip->isFinished()) {
            $this->dispatch('notify', message: 'This WIP is already finished.', type: 'error');
            $this->closeAddManualModal();
            return;
        }
        
        $inputText = trim($this->manualNoHu);
        $newQty = (int)$this->manualQty;
        
        // VALIDASI FORMAT - CEK APAKAH FORMATNYA STANDARD ATAU MENGANDUNG KARAKTER INVALID
        if (!$this->validateNoHuFormat($inputText)) {
            $this->dispatch('notify', message: 'Invalid No HU format! Format harus standard: @part_number@no_hu@model@@qty@@ (tanpa karakter khusus seperti [)> )', type: 'error');
            return;
        }
        
        // Check if input is full format or just No HU
        $pattern = '/^@(?P<part_number>[^@]+)@(?P<no_hu>[^@]+)@(?P<model>[^@]+)@@(?P<qty>\d+)@@$/';
        
        if (preg_match($pattern, $inputText, $matches)) {
            // Input is full format, extract the No HU
            $noHu = trim($matches['no_hu']);
            $scannedPartNumber = trim($matches['part_number']);
            $scannedModel = trim($matches['model']);
            $scannedQty = (int)$matches['qty'];
            
            // Validate part number
            if ($scannedPartNumber !== $this->masterWip->part_number) {
                $this->dispatch('notify', message: "Part Number mismatch! Scanned: {$scannedPartNumber}, Expected: {$this->masterWip->part_number}", type: 'error');
                return;
            }
            
            // Validate model
            if ($scannedModel !== $this->masterWip->model) {
                $this->dispatch('notify', message: "Model mismatch! Scanned: {$scannedModel}, Expected: {$this->masterWip->model}", type: 'error');
                return;
            }
            
            // Gunakan qty dari scan jika ada, tapi tetap validasi dengan manual qty
            if ($scannedQty != $newQty) {
                $this->dispatch('notify', message: "Warning: Qty in format ({$scannedQty}) berbeda dengan manual qty ({$newQty}). Menggunakan qty: {$newQty}", type: 'warning');
            }
        } else {
            // Input is just No HU - Cek apakah No HU mengandung karakter invalid
            $invalidChars = ['[', ']', ')', '>', '<', '(', '{', '}', '|', '\\'];
            foreach ($invalidChars as $char) {
                if (strpos($noHu, $char) !== false) {
                    $this->dispatch('notify', message: "Invalid No HU! Tidak boleh mengandung karakter: " . implode(' ', $invalidChars), type: 'error');
                    return;
                }
            }
            $noHu = $inputText;
        }
        
        $lastDetail = DetailWip::where('master_wips_id', $this->masterWip->id)->latest()->first();
        $currentAcm = $lastDetail->acm ?? 0;
        
        // Check if exceeds lot quantity
        if (($currentAcm + $newQty) > $this->masterWip->lot_qty) {
            $remaining = $this->masterWip->lot_qty - $currentAcm;
            $this->dispatch('notify', message: "Qty exceeds remaining lot quantity! Remaining: {$remaining}", type: 'error');
            return;
        }
        
        // CEK DUPLICATE UNTUK ADD MANUAL
        $existingDetail = DetailWip::where('master_wips_id', $this->masterWip->id)
            ->where('no_hu', 'like', "%{$noHu}%")
            ->first();
            
        if ($existingDetail) {
            if ($existingDetail->qty == $newQty) {
                $this->dispatch('notify', message: "Duplicate No HU detected! No HU '{$noHu}' with quantity {$newQty} already exists in this WIP.", type: 'error');
                return;
            } else {
                $this->dispatch('notify', message: "Warning: No HU '{$noHu}' already exists with different quantity ({$existingDetail->qty}). Adding new record with quantity {$newQty}.", type: 'warning');
            }
        }
        
        try {
            DB::beginTransaction();
            
            // Build the NO HU dengan format STANDARD (clean)
            $cleanNoHu = preg_replace('/[^A-Za-z0-9\-]/', '', $noHu);
            $newNoHu = "@{$this->masterWip->part_number}@{$cleanNoHu}@{$this->masterWip->model}@@{$newQty}@@";
            
            $acm = $currentAcm + $newQty;
            $balance = $this->masterWip->lot_qty - $acm;
            $status = $balance > 0 ? 'In Progress' : 'Finished';
            
            DetailWip::create([
                'master_wips_id' => $this->masterWip->id,
                'no_hu' => $newNoHu,
                'qty' => $newQty,
                'acm' => $acm,
                'balance' => $balance,
                'status' => $status,
                'ng_count' => 0,
                'created_by' => Auth::id(),
            ]);
            
            DB::commit();
            
            $this->dispatch('notify', message: "Manual add successful! No HU: {$cleanNoHu}, Qty: {$newQty}", type: 'success');
            
            // Refresh data
            $this->masterWip = MasterWip::find($this->masterWipId);
            $this->closeAddManualModal();
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error manual add: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error adding manual: ' . $e->getMessage(), type: 'error');
        }
    }
    
    // ========== EXISTING METHODS ==========
    
    public function updateNg($detailId, $ngCount)
    {
        try {
            $detailWip = DetailWip::find($detailId);
            if (!$detailWip) {
                $this->dispatch('notify', message: 'Detail not found', type: 'error');
                return;
            }
            
            $ng = (int)$ngCount;
            $qty = (int)$detailWip->qty;
            
            if ($ng > $qty) {
                $this->dispatch('notify', message: "NG quantity cannot exceed OK quantity ({$qty})", type: 'error');
                return;
            }
            
            DB::beginTransaction();
            
            $detailWip->update([
                'ng_count' => $ng,
                'updated_by' => Auth::id(),
            ]);
            
            $this->recalculateAllDetails($detailWip->master_wips_id);
            
            DB::commit();
            
            $this->dispatch('notify', message: 'NG quantity updated', type: 'success');
            
            // Refresh data
            $this->masterWip = MasterWip::find($this->masterWipId);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating NG: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error updating NG: ' . $e->getMessage(), type: 'error');
        }
    }
    
    public function updateRemarks($detailId, $remarks)
    {
        try {
            $detailWip = DetailWip::find($detailId);
            if (!$detailWip) {
                return;
            }
            
            $detailWip->update([
                'remarks' => $remarks,
                'updated_by' => Auth::id(),
            ]);
            
            $this->dispatch('notify', message: 'Remarks updated', type: 'success');
            
        } catch (\Exception $e) {
            Log::error('Error updating remarks: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error updating remarks', type: 'error');
        }
    }
    
    public function deleteDetail($detailId)
    {
        try {
            $detailWip = DetailWip::find($detailId);
            if (!$detailWip) {
                $this->dispatch('notify', message: 'Detail not found', type: 'error');
                return;
            }
            
            DB::beginTransaction();
            
            $noHu = $detailWip->no_hu;
            $masterWipsId = $detailWip->master_wips_id;
            
            $detailWip->delete();
            
            $this->recalculateAllDetails($masterWipsId);
            
            DB::commit();
            
            $this->dispatch('notify', message: "Detail No HU: {$noHu} deleted", type: 'success');
            
            // Refresh data
            $this->masterWip = MasterWip::find($this->masterWipId);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting detail: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error deleting detail: ' . $e->getMessage(), type: 'error');
        }
    }
    
    private function recalculateAllDetails($masterWipsId)
    {
        $masterWip = MasterWip::find($masterWipsId);
        if (!$masterWip) {
            return;
        }
        
        $allDetails = DetailWip::where('master_wips_id', $masterWipsId)
            ->orderBy('id', 'asc')
            ->get();
            
        if ($allDetails->isEmpty()) {
            return;
        }
        
        $runningAcm = 0;
        $hasReachedLotQty = false;
        
        foreach ($allDetails as $detail) {
            $detailTotal = ($detail->qty ?? 0) + ($detail->ng_count ?? 0);
            $runningAcm += $detailTotal;
            $balance = $masterWip->lot_qty - $runningAcm;
            
            if ($balance <= 0 || $hasReachedLotQty) {
                $status = 'Finished';
                $hasReachedLotQty = true;
            } else {
                $status = 'In Progress';
            }
            
            if ($detail->acm != $runningAcm || $detail->balance != $balance || $detail->status != $status) {
                $detail->update([
                    'acm' => $runningAcm,
                    'balance' => $balance,
                    'status' => $status,
                ]);
            }
        }
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
            $query = RackLosePack::query()
                ->select('id', 'no_rack', 'sheet_rack', 'column_rack')
                ->whereDoesntHave('detailWip');
            
            if ($this->rackSearch) {
                $query->where(function($q) {
                    $q->where('no_rack', 'like', "%{$this->rackSearch}%")
                      ->orWhere('sheet_rack', 'like', "%{$this->rackSearch}%")
                      ->orWhere('column_rack', 'like', "%{$this->rackSearch}%");
                });
            }
            
            $racks = $query->orderBy('no_rack')
                ->orderBy('sheet_rack')
                ->orderBy('column_rack')
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
            
            $detailWip = DetailWip::find($this->selectedDetailId);
            if (!$detailWip) {
                $this->dispatch('notify', message: 'Detail WIP not found', type: 'error');
                return;
            }
            
            // Check if rack is already used
            $rackInUse = DetailWip::where('rack_lose_pack_id', $rackId)
                ->where('id', '!=', $this->selectedDetailId)
                ->exists();
                
            if ($rackInUse) {
                $rack = RackLosePack::find($rackId);
                $this->dispatch('notify', message: "Rack {$rack->no_rack} - Sheet {$rack->sheet_rack} already used", type: 'error');
                return;
            }
            
            DB::beginTransaction();
            
            $detailWip->update([
                'rack_lose_pack_id' => $rackId,
                'updated_by' => Auth::id(),
            ]);
            
            DB::commit();
            
            $this->dispatch('notify', message: 'Rack assigned successfully', type: 'success');
            $this->closeRackModal();
            
            // Refresh data
            $this->masterWip = MasterWip::find($this->masterWipId);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving rack: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error saving rack: ' . $e->getMessage(), type: 'error');
        }
    }
    
    public function render()
    {
        return view('livewire.prod.wip.master-wip-scan', [
            'masterWip' => $this->masterWip,
            'statistics' => $this->statistics,
            'details' => $this->details,
        ]);
    }
}