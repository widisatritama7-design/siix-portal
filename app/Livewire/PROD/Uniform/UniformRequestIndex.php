<?php

namespace App\Livewire\PROD\Uniform;

use App\Models\PROD\Uniform\MasterUniform;
use App\Models\PROD\Uniform\UniformRequest;
use App\Models\PROD\Uniform\UniformRequestLock;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HR\Employee;

class UniformRequestIndex extends Component
{
    use WithPagination;

    public $search = '';
    
    // Filter properties
    public $adminFeedbackFilter = '';
    public $misscStatusFilter = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $verificationFilter = '';
    public $signatureFilter = '';

    // Modal properties
    public $showMisscModal = false;
    public $selectedRequestId = null;
    public $selectedRequestNumber = '';
    public $currentMisscStatus = '';
    public $selectedStatus = '';

    // Tambahkan di class UniformRequestIndex
    public $selectedRequests = [];
    public $selectAll = false;

    // Di bagian properties
    public $showBulkModal = false;
    public $bulkData = [];

    public $allItemsSigned = false;

    protected $listeners = ['refreshTable' => '$refresh'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedAdminFeedbackFilter()
    {
        $this->resetPage();
    }

    public function updatedMisscStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    public function updatedVerificationFilter()
    {
        $this->resetPage();
    }

    public function updatedSignatureFilter()
    {
        $this->resetPage();
    }

    // Method untuk toggle selection
    public function toggleSelect($id)
    {
        if (in_array($id, $this->selectedRequests)) {
            $this->selectedRequests = array_diff($this->selectedRequests, [$id]);
        } else {
            $this->selectedRequests[] = $id;
        }
        $this->selectAll = count($this->selectedRequests) == $this->getTotalCount();
    }

    // TAMBAHKAN: Method untuk cek lock status
    public function getLockStatus($requestId)
    {
        // Hapus lock yang expired
        UniformRequestLock::where('expires_at', '<', now())->delete();
        
        $lock = UniformRequestLock::where('request_id', $requestId)
            ->where('expires_at', '>', now())
            ->first();
        
        if ($lock) {
            return [
                'is_locked' => true,
                'locked_by' => $lock->user_name,
                'expires_at' => $lock->expires_at,
                'is_owner' => $lock->session_id === session()->getId()
            ];
        }
        
        return [
            'is_locked' => false,
            'locked_by' => null,
            'expires_at' => null,
            'is_owner' => false
        ];
    }

    // TAMBAHKAN: Method untuk force release lock (opsional untuk admin)
    public function forceReleaseLock($requestId)
    {
        if (!auth()->user()->can('feedback uniform request admin')) {
            $this->dispatch('notify', message: 'You do not have permission to force release lock!', type: 'error');
            return;
        }
        
        UniformRequestLock::where('request_id', $requestId)->delete();
        $this->dispatch('notify', message: 'Lock released successfully!', type: 'success');
        $this->dispatch('refreshTable');
    }

    public function forceReleaseCreateLock()
    {
        if (!auth()->user()->can('feedback uniform request admin')) {
            $this->dispatch('notify', message: 'You do not have permission to force release lock!', type: 'error');
            return;
        }
        
        \App\Models\PROD\Uniform\UniformRequestLock::whereNull('request_id')->delete();
        $this->dispatch('notify', message: 'Create lock released successfully!', type: 'success');
        $this->dispatch('refreshTable');
    }

    public function toggleSelectAll()
    {
    // Hanya select request yang memenuhi syarat
    $selectableIds = [];
    foreach ($this->getFilteredRequests() as $request) {
        // Cek missc_status
        if (!isset($request->missc_status) || $request->missc_status !== 'On Process') {
            continue;
        }
        
        $items = $request->items ?? [];
        $hasSelectableItem = false;
        
        foreach ($items as $item) {
            // ============ GUNAKAN NULL COALESCING UNTUK AMAN ============
            $isManual = isset($item['is_manual']) && $item['is_manual'] === true;
            $isNewEmployee = isset($item['reason_type']) && $item['reason_type'] === 'new_employee';
            $verificationStatus = $item['verification_status'] ?? null;
            
            // Manual atau New Employee: LANGSUNG BISA
            if ($isManual || $isNewEmployee) {
                $hasSelectableItem = true;
                break;
            }
            
            // System: harus sudah diverifikasi
            if ($verificationStatus === 'approved') {
                $hasSelectableItem = true;
                break;
            }
        }
        
        if ($hasSelectableItem) {
            $selectableIds[] = $request->id;
        }
    }
    
    // Jika semua selectable sudah dipilih, unselect semua
    $allSelected = count(array_intersect($this->selectedRequests, $selectableIds)) === count($selectableIds) && count($selectableIds) > 0;
    
    if ($allSelected) {
        $this->selectedRequests = array_diff($this->selectedRequests, $selectableIds);
        $this->selectAll = false;
    } else {
        // Tambahkan semua selectable yang belum dipilih
        $this->selectedRequests = array_unique(array_merge($this->selectedRequests, $selectableIds));
        $this->selectAll = true;
    }
    }

    private function getFilteredRequests()
    {
        $query = UniformRequest::query();
        
        if (auth()->user()->can('view uniform request one user')) {
            $employee = Employee::where('nik', auth()->user()->nik)->first();
            $userDepartment = $employee ? $employee->department : null;
            
            if ($userDepartment) {
                $query->where(function($q) use ($userDepartment) {
                    $q->where('items', 'like', '%"employee_department":"' . $userDepartment . '"%')
                    ->orWhere('items', 'like', '%"manual_department":"' . $userDepartment . '"%')
                    ->orWhere('items', 'like', '%"reason_type":"new_employee"%');
                });
            } else {
                $query->where('items', 'like', '%"reason_type":"new_employee"%');
            }
        }
        
        $query->when($this->search, function ($query) {
            $query->where('request_number', 'like', '%' . $this->search . '%');
        })
        ->when($this->dateFrom, function ($query) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        })
        ->when($this->dateTo, function ($query) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        })
        ->when($this->misscStatusFilter, function ($query) {
            $query->where('missc_status', $this->misscStatusFilter);
        })
        ->orderByDesc('id');
        
        return $query->get();
    }

    public function getSelectableCount()
    {
        $count = 0;
        foreach ($this->getFilteredRequests() as $request) {
            // Cek apakah ada item yang System atau Manual
            $items = $request->items ?? [];
            $hasSystemOrManual = false;
            
            foreach ($items as $item) {
                // Cek jika item bukan manual (System)
                if (!isset($item['is_manual']) || $item['is_manual'] !== true) {
                    $hasSystemOrManual = true;
                    break;
                }
            }
            
            if ($hasSystemOrManual) {
                $count++;
            }
        }
        return $count;
    }

    public function getTotalCount()
    {
        $query = UniformRequest::query();
        
        if (auth()->user()->can('view uniform request one user')) {
            $query->where('created_by', auth()->user()->name);
        }
        
        return $query->count();
    }

    public function getAllIds()
    {
        $query = UniformRequest::query();
        
        if (auth()->user()->can('view uniform request one user')) {
            $query->where('created_by', auth()->user()->name);
        }
        
        return $query->pluck('id')->toArray();
    }

    public function getSelectedCount()
    {
        return count($this->selectedRequests);
    }

    // ==================== BULK CREATE MISSC FUNCTIONS ====================

    public function openBulkModal()
    {
        if (empty($this->selectedRequests)) {
            $this->dispatch('notify', message: 'Please select at least one request!', type: 'error');
            return;
        }
        
        $this->bulkData = [];
        $misscData = [];
        
        foreach ($this->selectedRequests as $id) {
            $request = UniformRequest::find($id);
            if (!$request) continue;
            
            // ============ CEK STATUS MISSC ============
            if (!isset($request->missc_status) || $request->missc_status !== 'On Process') {
                continue;
            }
            
            $items = $request->items ?? [];
            
            foreach ($items as $item) {
                // ============ CEK STATUS ITEM ============
                $isManual = isset($item['is_manual']) && $item['is_manual'] === true;
                $isNewEmployee = isset($item['reason_type']) && $item['reason_type'] === 'new_employee';
                $verificationStatus = $item['verification_status'] ?? null;
                
                // ============ CEK KELAYAKAN ============
                $canBeProcessed = false;
                $statusLabel = '';
                $statusColor = '';
                $reasonNotProcessed = '';
                $typeLabel = '';
                
                if ($isManual) {
                    // MANUAL: Langsung bisa diproses
                    $canBeProcessed = true;
                    $statusLabel = 'Ready';
                    $statusColor = 'green';
                    $typeLabel = 'Manual';
                } elseif ($isNewEmployee) {
                    // NEW EMPLOYEE: Langsung bisa diproses
                    $canBeProcessed = true;
                    $statusLabel = 'Ready';
                    $statusColor = 'green';
                    $typeLabel = 'New Employee';
                } elseif ($verificationStatus === 'approved') {
                    // SYSTEM: Harus sudah diverifikasi
                    $canBeProcessed = true;
                    $statusLabel = 'Verified';
                    $statusColor = 'blue';
                    $typeLabel = 'System';
                } else {
                    // SYSTEM: Belum diverifikasi atau rejected
                    $canBeProcessed = false;
                    $statusLabel = $verificationStatus === 'rejected' ? 'Rejected' : 'Pending';
                    $statusColor = 'red';
                    $typeLabel = 'System';
                    $reasonNotProcessed = $verificationStatus === 'rejected' ? 'Item has been rejected' : 'Waiting for user verification';
                }
                
                // ============ AMBIL DATA ============
                $uniform = MasterUniform::find($item['master_uniform_id'] ?? null);
                $itemCode = $uniform ? $uniform->item_code : 'N/A';
                $description = $uniform ? $uniform->description : 'N/A';
                
                $qty = $item['qty'] ?? 0;
                $department = $item['employee_department'] ?? $item['manual_department'] ?? 'N/A';
                
                $key = $itemCode . '|' . $department . '|' . ($isNewEmployee ? 'new_employee' : 'regular') . '|' . ($isManual ? 'manual' : 'system');
                
                if (!isset($misscData[$key])) {
                    $misscData[$key] = [
                        'item_code' => $itemCode,
                        'description' => $description,
                        'qty' => 0,
                        'department' => $department,
                        'is_new_employee' => $isNewEmployee,
                        'is_manual' => $isManual,
                        'type' => $typeLabel,
                        'status' => $statusLabel,
                        'status_color' => $statusColor,
                        'can_be_processed' => $canBeProcessed,
                        'reason_not_processed' => $reasonNotProcessed,
                        'verification_status' => $verificationStatus,
                        'request_numbers' => []
                    ];
                }
                
                $misscData[$key]['qty'] += $qty;
                if (!in_array($request->request_number, $misscData[$key]['request_numbers'])) {
                    $misscData[$key]['request_numbers'][] = $request->request_number;
                }
            }
        }
        
        // Kelompokkan berdasarkan new_employee
        $groupedData = [
            'regular' => [],
            'new_employee' => []
        ];
        
        foreach ($misscData as $key => $data) {
            if ($data['is_new_employee']) {
                $groupedData['new_employee'][] = $data;
            } else {
                $groupedData['regular'][] = $data;
            }
        }
        
        $this->bulkData = $groupedData;
        $this->showBulkModal = true;
        
        // Cek apakah ada data
        $totalItems = count($groupedData['regular']) + count($groupedData['new_employee']);
        
        if ($totalItems === 0) {
            $this->dispatch('notify', message: 'No items found in selected requests with status "On Process"!', type: 'warning');
            $this->showBulkModal = false;
        }
    }

    public function closeBulkModal()
    {
        $this->showBulkModal = false;
        $this->bulkData = [];
    }

    // Helper function to check if all items are manual
    public function isAllManual($request)
    {
        $items = $request->items ?? [];
        
        if (empty($items)) {
            return false;
        }
        
        foreach ($items as $item) {
            if (!isset($item['is_manual']) || $item['is_manual'] !== true) {
                return false;
            }
        }
        
        return true;
    }

    // Helper function to get admin feedback status
    public function getAdminFeedbackStatus($request)
    {
        // CEK: Jika semua item manual, return N/A
        if ($this->isAllManual($request)) {
            return ['status' => 'N/A', 'color' => 'gray'];
        }
        
        $items = $request->items ?? [];
        $totalItems = count($items);
        
        if ($totalItems == 0) {
            return ['status' => 'Open', 'color' => 'gray'];
        }
        
        // Filter manual items untuk diabaikan dari perhitungan
        $nonManualItems = array_filter($items, function($item) {
            return !isset($item['is_manual']) || $item['is_manual'] !== true;
        });
        
        $totalNonManual = count($nonManualItems);
        
        if ($totalNonManual === 0) {
            return ['status' => 'N/A', 'color' => 'gray'];
        }
        
        $filledCount = 0;
        foreach ($nonManualItems as $item) {
            if (!empty($item['admin_feedback']) && $item['admin_feedback'] !== 'N/A (Manual Input)') {
                $filledCount++;
            }
        }
        
        if ($filledCount == 0) {
            return ['status' => 'Open', 'color' => 'gray'];
        } elseif ($filledCount == $totalNonManual) {
            return ['status' => 'Checked', 'color' => 'green'];
        } else {
            return ['status' => 'On Process', 'color' => 'yellow'];
        }
    }

    // Helper function to get verification status
    public function getVerificationStatus($request)
    {
        $items = $request->items ?? [];
        
        if (empty($items)) {
            return ['status' => 'Waiting', 'color' => 'gray'];
        }
        
        $totalItems = count($items);
        $completedCount = 0;
        $approvedCount = 0;
        $rejectedCount = 0;
        $manualCount = 0;
        $pendingCount = 0;
        $systemCount = 0;
        
        foreach ($items as $item) {
            $verificationStatus = $item['verification_status'] ?? '';
            $isManual = isset($item['is_manual']) && $item['is_manual'] === true;
            $isNewEmployee = isset($item['reason_type']) && $item['reason_type'] === 'new_employee';
            
            // Jika manual atau new employee, skip verification (dianggap N/A)
            if ($isManual || $isNewEmployee) {
                $completedCount++;
                $manualCount++;
                continue;
            }
            
            // Ini adalah system item
            $systemCount++;
            
            if ($verificationStatus === 'approved') {
                $completedCount++;
                $approvedCount++;
            } elseif ($verificationStatus === 'rejected') {
                $completedCount++;
                $rejectedCount++;
            } else {
                $pendingCount++;
            }
        }
        
        // Jika tidak ada system items (semua manual/new employee)
        if ($systemCount == 0) {
            return ['status' => 'N/A', 'color' => 'gray'];
        }
        
        // Jika semua system items sudah selesai (approved atau rejected)
        if ($pendingCount == 0) {
            // Jika semua system items approved
            if ($rejectedCount == 0) {
                return ['status' => 'Approved', 'color' => 'green'];
            }
            // Ada yang rejected
            return ['status' => 'Completed', 'color' => 'blue'];
        }
        
        // Jika ada system items yang masih pending
        if ($completedCount > 0) {
            return ['status' => 'On Process', 'color' => 'yellow'];
        }
        
        return ['status' => 'Waiting', 'color' => 'gray'];
    }

    // Helper function to get signature status
    public function getSignatureStatus($request)
    {
        $items = $request->items ?? [];
        
        if (empty($items)) {
            return ['status' => 'Waiting', 'color' => 'gray'];
        }
        
        $totalItems = count($items);
        $signedCount = 0;
        $rejectedCount = 0;
        $pendingCount = 0;
        $manualCount = 0;
        
        foreach ($items as $item) {
            $verificationStatus = $item['verification_status'] ?? '';
            $isSigned = !empty($item['digital_signature']);
            $isManual = isset($item['is_manual']) && $item['is_manual'];
            
            // Manual items tetap perlu signature
            if ($isManual) {
                $manualCount++;
                if ($isSigned) {
                    $signedCount++;
                } else {
                    $pendingCount++;
                }
                continue;
            }
            
            // Jika item rejected, dianggap selesai (tidak perlu signature)
            if ($verificationStatus === 'rejected') {
                $rejectedCount++;
            } elseif ($isSigned) {
                $signedCount++;
            } else {
                $pendingCount++;
            }
        }
        
        // Jika semua item sudah selesai (signed ATAU rejected)
        if ($signedCount + $rejectedCount == $totalItems) {
            // Jika semua signed (tidak ada rejected)
            if ($signedCount == $totalItems) {
                return ['status' => 'Signed', 'color' => 'green'];
            }
            // Jika ada yang rejected (selesai semua, dengan atau tanpa signed)
            return ['status' => 'Completed', 'color' => 'blue'];
        }
        
        // Jika ada yang sudah selesai tapi belum semua
        if ($signedCount > 0 || $rejectedCount > 0) {
            return ['status' => 'On Process', 'color' => 'yellow'];
        }
        
        return ['status' => 'Waiting', 'color' => 'gray'];
    }

    public function delete($id)
    {
        // Check permission for delete
        if (!auth()->user()->can('delete uniform request')) {
            $this->dispatch('notify', message: 'You do not have permission to delete!', type: 'error');
            return;
        }

        // If user has 'view uniform request one user' (prioritized), only allow delete their own requests
        if (auth()->user()->can('view uniform request one user')) {
            $request = UniformRequest::where('id', $id)->where('created_by', auth()->user()->name)->first();
            if (!$request) {
                $this->dispatch('notify', message: 'You do not have permission to delete this request!', type: 'error');
                return;
            }
        }

        $request = UniformRequest::find($id);
        
        if (!$request) {
            $this->dispatch('notify', message: 'Request not found!', type: 'error');
            return;
        }

        // ==================== CEK: Apakah request sudah ACCEPTED? ====================
        if ($request->missc_status === 'Accepted') {
            $this->dispatch('notify', message: 'Cannot delete request! Status already Accepted.', type: 'error');
            return;
        }
        // ==================== END CEK ====================

        // ==================== CEK: Apakah ada item yang sudah SIGNED? ====================
        $items = $request->items ?? [];
        $hasSignature = false;
        foreach ($items as $item) {
            if (!empty($item['digital_signature'])) {
                $hasSignature = true;
                break;
            }
        }
        
        if ($hasSignature) {
            $this->dispatch('notify', message: 'Cannot delete request! Items already signed.', type: 'error');
            return;
        }
        // ==================== END CEK ====================

        // CEK: Apakah request sudah memiliki admin feedback?
        $items = $request->items ?? [];
        $hasAdminFeedback = false;
        $nonManualItems = [];
        
        foreach ($items as $item) {
            // Skip manual items
            if (isset($item['is_manual']) && $item['is_manual'] === true) {
                continue;
            }
            
            $nonManualItems[] = $item;
            
            // Cek apakah ada admin_feedback yang terisi
            if (!empty($item['admin_feedback']) && $item['admin_feedback'] !== 'N/A (Manual Input)') {
                $hasAdminFeedback = true;
            }
        }
        
        // Jika ada admin feedback, tidak boleh dihapus
        if ($hasAdminFeedback) {
            $this->dispatch('notify', message: 'Cannot delete request! Admin feedback already exists.', type: 'error');
            return;
        }
        
        // Jika tidak ada non-manual items (semua manual), bisa dihapus langsung tanpa return stock
        if (empty($nonManualItems)) {
            $request->delete();
            $this->dispatch('notify', message: 'Request deleted successfully! (All items are manual, no stock to return)', type: 'success');
            return;
        }

        // ============ KEMBALIKAN STOCK UNTUK ITEM SYSTEM ============
        try {
            foreach ($nonManualItems as $item) {
                $uniform = MasterUniform::find($item['master_uniform_id']);
                if ($uniform) {
                    $oldQty = $uniform->qty;
                    $newQty = $oldQty + $item['qty'];
                    
                    $uniform->qty = $newQty;
                    $uniform->save();
                    
                    // Catat transaksi
                    \App\Models\PROD\Uniform\UniformStockTransaction::create([
                        'master_uniform_id' => $uniform->id,
                        'transaction_type' => 'IN',
                        'qty_change' => $item['qty'],
                        'qty_before' => $oldQty,
                        'qty_after' => $newQty,
                        'reference_id' => $request->request_number,
                        'reference_type' => 'uniform_request_deletion',
                        'description' => 'Delete request: ' . $request->request_number . ' - Return stock for ' . $uniform->item_code,
                        'performed_by' => auth()->user()->name,
                        'performed_at' => now(),
                    ]);
                }
            }
            
            // Hapus request setelah stock dikembalikan
            $request->delete();
            
            $this->dispatch('notify', message: 'Request deleted successfully! Stock has been returned for ' . count($nonManualItems) . ' item(s).', type: 'success');
            $this->dispatch('refreshTable');
            
        } catch (\Exception $e) {
            \Log::error('Error deleting uniform request: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error deleting request: ' . $e->getMessage(), type: 'error');
        }
    }

    public function canDeleteRequest($request)
    {
        // Cek department access
        if (auth()->user()->can('view uniform request one user')) {
            if (!$this->checkItemDepartmentAccess($request)) {
                return false;
            }
        }
        
        // ==================== CEK: Apakah request sudah ACCEPTED? ====================
        if ($request->missc_status === 'Accepted') {
            return false;
        }
        // ==================== END CEK ====================
        
        // ==================== CEK: Apakah ada item yang sudah SIGNED? ====================
        $items = $request->items ?? [];
        foreach ($items as $item) {
            if (!empty($item['digital_signature'])) {
                return false;
            }
        }
        // ==================== END CEK ====================
        
        $items = $request->items ?? [];
        
        foreach ($items as $item) {
            // Skip manual items
            if (isset($item['is_manual']) && $item['is_manual'] === true) {
                continue;
            }
            
            // Jika ada admin_feedback yang terisi, tidak boleh dihapus
            if (!empty($item['admin_feedback']) && $item['admin_feedback'] !== 'N/A (Manual Input)') {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Cek apakah ada item yang sudah signed
     */
    public function hasSignedItems($request)
    {
        $items = $request->items ?? [];
        foreach ($items as $item) {
            if (!empty($item['digital_signature'])) {
                return true;
            }
        }
        return false;
    }

    public function hasAdminFeedback($request)
    {
        $items = $request->items ?? [];
        
        foreach ($items as $item) {
            // Skip manual items
            if (isset($item['is_manual']) && $item['is_manual'] === true) {
                continue;
            }
            
            if (!empty($item['admin_feedback']) && $item['admin_feedback'] !== 'N/A (Manual Input)') {
                return true;
            }
        }
        
        return false;
    }

    public function openMisscModal($id)
    {
        // Check permission
        if (!auth()->user()->can('update uniform request missc status')) {
            $this->dispatch('notify', message: 'You do not have permission to update MISSC status!', type: 'error');
            return;
        }

        $request = UniformRequest::find($id);
        
        if (!$request) {
            $this->dispatch('notify', message: 'Request not found!', type: 'error');
            return;
        }

        if ($request->missc_status === 'Accepted') {
            $this->dispatch('notify', message: 'Cannot update - already Accepted!', type: 'error');
            return;
        }

        // ==================== CEK VERIFICATION STATUS ====================
        $items = $request->items ?? [];
        $hasPendingVerification = false;
        $hasSystemItems = false;
        $allItemsSigned = true;
        
        foreach ($items as $item) {
            $isManual = isset($item['is_manual']) && $item['is_manual'];
            $isNewEmployee = isset($item['reason_type']) && $item['reason_type'] === 'new_employee';
            
            if ($isManual || $isNewEmployee) {
                if (empty($item['digital_signature'])) {
                    $allItemsSigned = false;
                }
                continue;
            }
            
            $hasSystemItems = true;
            $verificationStatus = $item['verification_status'] ?? '';
            
            if ($verificationStatus !== 'approved' && $verificationStatus !== 'rejected') {
                $hasPendingVerification = true;
                break;
            }
            
            if (empty($item['digital_signature'])) {
                $allItemsSigned = false;
            }
        }
        
        if (!$hasSystemItems) {
            foreach ($items as $item) {
                if (empty($item['digital_signature'])) {
                    $allItemsSigned = false;
                    break;
                }
            }
        }
        
        $this->allItemsSigned = $allItemsSigned;
        
        if ($hasPendingVerification) {
            $this->dispatch('notify', message: 'Cannot update MISSC Status - System items must be verified (Approved or Rejected) first!', type: 'error');
            return;
        }
        // ==================== END CEK ====================

        // ==================== AUTO SELECT STATUS ====================
        $currentStatus = $request->missc_status ?? 'Waiting';
        
        if ($currentStatus === 'Waiting') {
            $this->selectedStatus = 'On Process';
        } elseif ($currentStatus === 'On Process' && $allItemsSigned) {
            $this->selectedStatus = 'Accepted';
        } else {
            $this->selectedStatus = ''; // Tidak ada perubahan
        }
        // ==================== END AUTO SELECT ====================

        // Set modal properties
        $this->selectedRequestId = $id;
        $this->selectedRequestNumber = $request->request_number;
        $this->currentMisscStatus = $request->missc_status;
        $this->showMisscModal = true;
    }

    public function closeMisscModal()
    {
        $this->showMisscModal = false;
        $this->selectedRequestId = null;
        $this->selectedRequestNumber = '';
        $this->currentMisscStatus = '';
        $this->selectedStatus = '';
        $this->allItemsSigned = false; // Reset
    }

    public function confirmUpdateMisscStatus()
    {
        if (empty($this->selectedStatus)) {
            $this->dispatch('notify', message: 'No status change needed!', type: 'warning');
            $this->closeMisscModal();
            return;
        }

        $request = UniformRequest::find($this->selectedRequestId);
        
        if (!$request) {
            $this->dispatch('notify', message: 'Request not found!', type: 'error');
            $this->closeMisscModal();
            return;
        }

        if ($request->missc_status === 'Accepted') {
            $this->dispatch('notify', message: 'Cannot change status - already Accepted!', type: 'error');
            $this->closeMisscModal();
            return;
        }

        if ($request->missc_status === $this->selectedStatus) {
            $this->dispatch('notify', message: 'Status is already ' . $this->selectedStatus, type: 'warning');
            $this->closeMisscModal();
            return;
        }

        // ==================== VALIDASI UNTUK ACCEPT ====================
        if ($this->selectedStatus === 'Accepted') {
            $items = $request->items ?? [];
            $allItemsSigned = true;
            foreach ($items as $item) {
                if (empty($item['digital_signature'])) {
                    $allItemsSigned = false;
                    break;
                }
            }
            
            if (!$allItemsSigned) {
                $this->dispatch('notify', message: 'Cannot accept - All items must be signed first!', type: 'error');
                return;
            }
        }
        // ==================== END VALIDASI ====================

        $request->updateMisscStatus($this->selectedStatus);
        
        $message = $this->selectedStatus === 'Accepted' 
            ? '✅ Request accepted successfully!' 
            : '🔄 Request status updated to ' . $this->selectedStatus;
            
        $this->dispatch('notify', message: $message);
        $this->closeMisscModal();
        $this->dispatch('refreshTable');
    }

    public function resetFilters()
    {
        $this->adminFeedbackFilter = '';
        $this->misscStatusFilter = '';
        $this->verificationFilter = '';
        $this->signatureFilter = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->search = '';
        $this->resetPage();
    }

    /**
     * Cek apakah request memiliki item dengan department user atau New Employee
     */
    private function checkItemDepartmentAccess($request)
    {
        if (!auth()->user()->can('view uniform request one user')) {
            return true;
        }
        
        $employee = Employee::where('nik', auth()->user()->nik)->first();
        if (!$employee) {
            return false;
        }
        
        $userDepartment = $employee->department;
        $items = $request->items ?? [];
        
        foreach ($items as $item) {
            // HAPUS pengecekan reason_type 'new_employee' - ini yang menyebabkan semua bisa lihat
            
            // Cek employee_department
            if (isset($item['employee_department']) && $item['employee_department'] === $userDepartment) {
                return true;
            }
            
            // Cek manual_department
            if (isset($item['manual_department']) && $item['manual_department'] === $userDepartment) {
                return true;
            }
        }
        
        return false;
    }

    public function debugItems()
    {
        $items = $this->request->items ?? [];
        $employee = Employee::where('nik', auth()->user()->nik)->first();
        $userDepartment = $employee ? $employee->department : null;
        
        $results = [];
        foreach ($items as $index => $item) {
            $results[] = [
                'index' => $index,
                'employee_department' => $item['employee_department'] ?? null,
                'manual_department' => $item['manual_department'] ?? null,
                'reason_type' => $item['reason_type'] ?? null,
                'is_manual' => $item['is_manual'] ?? null,
                'matches_user_department' => (
                    ($item['employee_department'] ?? '') === $userDepartment ||
                    ($item['manual_department'] ?? '') === $userDepartment ||
                    ($item['reason_type'] ?? '') === 'new_employee'
                )
            ];
        }
        
        dd([
            'user_department' => $userDepartment,
            'items' => $results
        ]);
    }

    public function debugDepartmentAccess()
    {
        $employee = Employee::where('nik', auth()->user()->nik)->first();
        $userDepartment = $employee ? $employee->department : null;
        
        // Ambil semua request
        $allRequests = UniformRequest::all();
        $results = [];
        
        foreach ($allRequests as $request) {
            $items = $request->items ?? [];
            $hasAccess = false;
            $matchedDepartments = [];
            
            foreach ($items as $item) {
                // Cek employee_department
                if (isset($item['employee_department'])) {
                    $matchedDepartments[] = $item['employee_department'];
                    if ($item['employee_department'] === $userDepartment) {
                        $hasAccess = true;
                    }
                }
                
                // Cek manual_department
                if (isset($item['manual_department'])) {
                    $matchedDepartments[] = $item['manual_department'];
                    if ($item['manual_department'] === $userDepartment) {
                        $hasAccess = true;
                    }
                }
            }
            
            $results[] = [
                'request_number' => $request->request_number,
                'user_department' => $userDepartment,
                'request_departments' => array_unique($matchedDepartments),
                'has_access' => $hasAccess,
                'should_be_visible' => $hasAccess // Karena kita sudah hapus pengecualian new_employee
            ];
        }
        
        dd($results);
    }

    public function canEditRequest($request)
    {
        // Cek department access
        if (auth()->user()->can('view uniform request one user')) {
            if (!$this->checkItemDepartmentAccess($request)) {
                return false;
            }
        }
        
        // Cek missc status - hanya bisa edit jika masih Waiting
        if ($request->missc_status != 'Waiting') {
            return false;
        }
        
        $items = $request->items ?? [];
        
        if (empty($items)) {
            return false;
        }
        
        foreach ($items as $item) {
            // Cek apakah sudah ada signature
            if (!empty($item['digital_signature'])) {
                return false;
            }
            
            // Cek apakah sudah ada admin_feedback (bukan N/A)
            $adminFeedback = $item['admin_feedback'] ?? '';
            if (!empty($adminFeedback) && 
                $adminFeedback !== 'N/A (Manual Input)' &&
                $adminFeedback !== 'N/A (New Employee)') {
                return false;
            }
        }
        
        return true;
    }

    /**
     * End edit session untuk user sendiri
     */
    public function endEditSession()
    {
        $sessionId = session()->getId();
        
        // Cari lock edit milik sendiri
        $lock = UniformRequestLock::whereNotNull('request_id')
            ->where('session_id', $sessionId)
            ->first();
        
        if ($lock) {
            // Hapus lock dari database
            $lock->delete();
            
            $this->dispatch('notify', message: 'Edit session ended successfully! You can now create a new request.', type: 'success');
            $this->dispatch('refreshTable');
        } else {
            $this->dispatch('notify', message: 'No active edit session found.', type: 'warning');
        }
    }

    public function forceReleaseAllLocks()
    {
        if (!auth()->user()->can('feedback uniform request admin')) {
            $this->dispatch('notify', message: 'You do not have permission to force release lock!', type: 'error');
            return;
        }
        
        // Hapus semua lock yang ada
        UniformRequestLock::truncate(); // Hati-hati dengan truncate
        // Atau gunakan delete jika tidak mau truncate
        // UniformRequestLock::whereNotNull('id')->delete();
        
        $this->dispatch('notify', message: 'All locks released successfully!', type: 'success');
        $this->dispatch('refreshTable');
    }

    public function render()
    {
        // Check permission for view
        if (!auth()->user()->can('view uniform request') && !auth()->user()->can('view uniform request one user')) {
            abort(403, 'Unauthorized access.');
        }

        $query = UniformRequest::with('creator');

        // Apply basic filters first
        $query->when($this->search, function ($query) {
                $query->where('request_number', 'like', '%' . $this->search . '%');
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('created_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('created_at', '<=', $this->dateTo);
            })
            ->when($this->misscStatusFilter, function ($query) {
                $query->where('missc_status', $this->misscStatusFilter);
            })
            ->orderByDesc('id');

        // Get all requests first (tanpa pagination)
        $allRequests = $query->get();

        // Filter by department using collection
        if (auth()->user()->can('view uniform request one user')) {
            $allRequests = $allRequests->filter(function($request) {
                return $this->checkItemDepartmentAccess($request);
            });
        }

        // Apply feedback status filters
        if ($this->adminFeedbackFilter || 
            $this->verificationFilter || $this->signatureFilter) {
            
            $allRequests = $allRequests->filter(function($request) {
                $adminStatus = $this->getAdminFeedbackStatus($request);
                $verificationStatus = $this->getVerificationStatus($request);
                $signatureStatus = $this->getSignatureStatus($request);
                
                $adminMatch = !$this->adminFeedbackFilter || $adminStatus['status'] == $this->adminFeedbackFilter;
                $verificationMatch = !$this->verificationFilter || $verificationStatus['status'] == $this->verificationFilter;
                $signatureMatch = !$this->signatureFilter || $signatureStatus['status'] == $this->signatureFilter;
                
                return $adminMatch && $verificationMatch && $signatureMatch;
            });
        }

        // Paginate manually
        $currentPage = request()->get('page', 1);
        $perPage = 10;
        $total = $allRequests->count();
        
        $requests = new \Illuminate\Pagination\LengthAwarePaginator(
            $allRequests->forPage($currentPage, $perPage)->values(),
            $total,
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('livewire.prod.uniform.uniform-request-index', [
            'requests' => $requests,
        ]);
    }
}