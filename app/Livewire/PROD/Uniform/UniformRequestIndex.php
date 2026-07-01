<?php

namespace App\Livewire\PROD\Uniform;

use App\Models\PROD\Uniform\MasterUniform;
use App\Models\PROD\Uniform\UniformRequest;
use Livewire\Component;
use Livewire\WithPagination;

class UniformRequestIndex extends Component
{
    use WithPagination;

    public $search = '';
    
    // Filter properties
    public $adminFeedbackFilter = '';
    public $costingFeedbackFilter = '';
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
    public $showBulkModal = false;
    public $bulkData = [];

    protected $listeners = ['refreshTable' => '$refresh'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedAdminFeedbackFilter()
    {
        $this->resetPage();
    }

    public function updatedCostingFeedbackFilter()
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

    public function toggleSelectAll()
    {
        // Hanya select request yang costing statusnya On Process atau Checked
        $selectableIds = [];
        foreach ($this->getFilteredRequests() as $request) {
            $costingStatus = $this->getCostingFeedbackStatus($request);
            if (in_array($costingStatus['status'], ['On Process', 'Checked'])) {
                $selectableIds[] = $request->id;
            }
        }
        
        // Jika semua selectable sudah dipilih, unselect semua
        $allSelected = count(array_intersect($this->selectedRequests, $selectableIds)) === count($selectableIds);
        
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
        // Ambil request yang sedang ditampilkan (sesuai filter)
        $query = UniformRequest::query();
        
        if (auth()->user()->can('view uniform request one user')) {
            $query->where('created_by', auth()->user()->name);
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
            $costingStatus = $this->getCostingFeedbackStatus($request);
            if (in_array($costingStatus['status'], ['On Process', 'Checked'])) {
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

    public function openBulkModal()
    {
        if (empty($this->selectedRequests)) {
            $this->dispatch('notify', message: 'Please select at least one request!', type: 'error');
            return;
        }
        
        // Filter hanya request yang costing statusnya On Process atau Checked
        $validRequests = [];
        foreach ($this->selectedRequests as $id) {
            $request = UniformRequest::find($id);
            if ($request) {
                $costingStatus = $this->getCostingFeedbackStatus($request);
                if (in_array($costingStatus['status'], ['On Process', 'Checked'])) {
                    $validRequests[] = $id;
                }
            }
        }
        
        if (empty($validRequests)) {
            $this->dispatch('notify', message: 'No valid requests selected! Only requests with "On Process" or "Checked" costing feedback can be bulk processed.', type: 'error');
            return;
        }
        
        // Update selected requests dengan yang valid saja
        $this->selectedRequests = $validRequests;
        
        $this->bulkData = [];
        $costingData = [];
        
        foreach ($this->selectedRequests as $id) {
            $request = UniformRequest::find($id);
            if (!$request) continue;
            
            $items = $request->items ?? [];
            
            foreach ($items as $index => $item) {
                // Cek apakah item memiliki costing_feedback
                if (empty($item['costing_feedback'])) {
                    continue;
                }
                
                // Cek status costing_feedback (Create Missc atau Create Stock Manual)
                $costingFeedback = $item['costing_feedback'];
                $isCreateMissc = stripos($costingFeedback, 'Create Missc') !== false;
                $isCreateStockManual = stripos($costingFeedback, 'Create Stock Manual') !== false;
                
                // Jika Create Missc atau Create Stock Manual, tambahkan ke data
                if ($isCreateMissc || $isCreateStockManual) {
                    $uniform = MasterUniform::find($item['master_uniform_id']);
                    $itemCode = $uniform ? $uniform->item_code : 'N/A';
                    $description = $uniform ? $uniform->description : 'N/A';
                    
                    $type = $isCreateMissc ? 'Create Missc' : 'Create Stock Manual';
                    $qty = $item['qty'] ?? 0;
                    
                    $key = $itemCode . '|' . $type;
                    
                    if (!isset($costingData[$key])) {
                        $costingData[$key] = [
                            'item_code' => $itemCode,
                            'description' => $description,
                            'qty' => 0,
                            'type' => $type,
                            'request_numbers' => []
                        ];
                    }
                    
                    $costingData[$key]['qty'] += $qty;
                    if (!in_array($request->request_number, $costingData[$key]['request_numbers'])) {
                        $costingData[$key]['request_numbers'][] = $request->request_number;
                    }
                }
            }
        }
        
        $this->bulkData = array_values($costingData);
        $this->showBulkModal = true;
        
        if (empty($this->bulkData)) {
            $this->dispatch('notify', message: 'No items with Costing Feedback (Create Missc/Create Stock Manual) found in selected requests!', type: 'warning');
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

    // Helper function to get costing feedback status
    public function getCostingFeedbackStatus($request)
    {
        $items = $request->items ?? [];
        
        if (empty($items)) {
            return ['status' => 'Open', 'color' => 'gray'];
        }
        
        $totalItems = count($items);
        $checkedCount = 0;
        $onProcessCount = 0;
        $openCount = 0;
        
        foreach ($items as $item) {
            $verificationStatus = $item['verification_status'] ?? '';
            
            // 1. Jika verification_status = rejected, anggap sudah terisi
            if ($verificationStatus === 'rejected') {
                $checkedCount++;
            } 
            // 2. Jika costing_feedback terisi, anggap sudah terisi
            elseif (!empty($item['costing_feedback'])) {
                $checkedCount++;
            }
            // 3. Jika verification_status = approved dan costing_feedback kosong
            elseif ($verificationStatus === 'approved' && empty($item['costing_feedback'])) {
                $onProcessCount++;
            }
            // 4. Jika verification_status kosong atau lainnya
            else {
                $openCount++;
            }
        }
        
        // Semua sudah terisi (termasuk rejected)
        if ($checkedCount == $totalItems) {
            return ['status' => 'Checked', 'color' => 'green'];
        }
        
        // Ada yang sudah terisi tapi belum semua
        if ($checkedCount > 0 || $onProcessCount > 0) {
            return ['status' => 'On Process', 'color' => 'yellow'];
        }
        
        return ['status' => 'Open', 'color' => 'gray'];
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
        
        foreach ($items as $item) {
            $verificationStatus = $item['verification_status'] ?? '';
            $isManual = isset($item['is_manual']) && $item['is_manual'];
            
            // Jika manual, skip verification (dianggap completed)
            if ($isManual) {
                $completedCount++;
                $manualCount++;
                continue;
            }
            
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
        
        // Jika semua item adalah manual
        if ($manualCount == $totalItems) {
            return ['status' => 'N/A', 'color' => 'gray'];
        }
        
        // Jika semua sudah selesai (approved, rejected, atau manual)
        if ($completedCount == $totalItems) {
            // Jika semua approved (tidak ada rejected dan tidak ada manual)
            if ($approvedCount == $totalItems) {
                return ['status' => 'Approved', 'color' => 'green'];
            }
            // Jika ada manual, tapi tidak ada pending
            if ($manualCount > 0 && $pendingCount == 0) {
                return ['status' => 'Completed', 'color' => 'blue'];
            }
            // Jika ada yang rejected (selesai semua)
            return ['status' => 'Completed', 'color' => 'blue'];
        }
        
        // Jika ada yang sudah selesai tapi belum semua
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
        
        if ($request) {
            $request->delete();
            $this->dispatch('notify', message: 'Request deleted successfully!');
        }
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

        $this->selectedRequestId = $id;
        $this->selectedRequestNumber = $request->request_number;
        $this->currentMisscStatus = $request->missc_status;
        $this->selectedStatus = '';
        $this->showMisscModal = true;
    }

    public function closeMisscModal()
    {
        $this->showMisscModal = false;
        $this->selectedRequestId = null;
        $this->selectedRequestNumber = '';
        $this->currentMisscStatus = '';
        $this->selectedStatus = '';
    }

    public function confirmUpdateMisscStatus()
    {
        if (empty($this->selectedStatus)) {
            $this->dispatch('notify', message: 'Please select a status!', type: 'error');
            return;
        }

        $request = UniformRequest::find($this->selectedRequestId);
        
        if (!$request) {
            $this->dispatch('notify', message: 'Request not found!', type: 'error');
            $this->closeMisscModal();
            return;
        }

        // Validate status transition
        if ($request->missc_status === 'Accepted') {
            $this->dispatch('notify', message: 'Cannot change status - already Accepted!', type: 'error');
            $this->closeMisscModal();
            return;
        }

        if ($request->missc_status === $this->selectedStatus) {
            $this->dispatch('notify', message: 'Status is already ' . $this->selectedStatus, type: 'error');
            $this->closeMisscModal();
            return;
        }

        $request->updateMisscStatus($this->selectedStatus);
        
        $message = $this->selectedStatus === 'Accepted' 
            ? 'Request accepted successfully!' 
            : 'Request status updated to ' . $this->selectedStatus;
            
        $this->dispatch('notify', message: $message);
        $this->closeMisscModal();
        $this->dispatch('refreshTable');
    }

    public function resetFilters()
    {
        $this->adminFeedbackFilter = '';
        $this->costingFeedbackFilter = '';
        $this->misscStatusFilter = '';
        $this->verificationFilter = '';
        $this->signatureFilter = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        // Check permission for view
        if (!auth()->user()->can('view uniform request') && !auth()->user()->can('view uniform request one user')) {
            abort(403, 'Unauthorized access.');
        }

        $query = UniformRequest::with('creator');

        // PRIORITAS: Jika user memiliki 'view uniform request one user'
        if (auth()->user()->can('view uniform request one user')) {
            $query->where('created_by', auth()->user()->name);
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

        $requests = $query->paginate(10);

        // Apply feedback status filters manually after pagination
        if ($this->adminFeedbackFilter || $this->costingFeedbackFilter || 
            $this->verificationFilter || $this->signatureFilter) {
            
            $filteredRequests = [];
            foreach ($requests as $request) {
                $adminStatus = $this->getAdminFeedbackStatus($request);
                $costingStatus = $this->getCostingFeedbackStatus($request);
                $verificationStatus = $this->getVerificationStatus($request);
                $signatureStatus = $this->getSignatureStatus($request);
                
                $adminMatch = !$this->adminFeedbackFilter || $adminStatus['status'] == $this->adminFeedbackFilter;
                $costingMatch = !$this->costingFeedbackFilter || $costingStatus['status'] == $this->costingFeedbackFilter;
                $verificationMatch = !$this->verificationFilter || $verificationStatus['status'] == $this->verificationFilter;
                $signatureMatch = !$this->signatureFilter || $signatureStatus['status'] == $this->signatureFilter;
                
                if ($adminMatch && $costingMatch && $verificationMatch && $signatureMatch) {
                    $filteredRequests[] = $request;
                }
            }
            
            // Re-paginate filtered results
            $currentPage = request()->get('page', 1);
            $perPage = 10;
            $total = count($filteredRequests);
            $requests = new \Illuminate\Pagination\LengthAwarePaginator(
                array_slice($filteredRequests, ($currentPage - 1) * $perPage, $perPage),
                $total,
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

        return view('livewire.prod.uniform.uniform-request-index', [
            'requests' => $requests,
        ]);
    }
}