<?php

namespace App\Livewire\PROD\Uniform;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PROD\Uniform\UniformRequest;

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
        $allManual = true;
        
        foreach ($items as $item) {
            $verificationStatus = $item['verification_status'] ?? '';
            $isManual = isset($item['is_manual']) && $item['is_manual'];
            
            // Cek apakah semua item manual
            if (!$isManual) {
                $allManual = false;
            }
            
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
        if ($allManual && $manualCount == $totalItems) {
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
        $completedCount = 0; // Items yang sudah selesai (signed atau rejected)
        $signedCount = 0;
        $rejectedCount = 0;
        $pendingCount = 0;
        
        foreach ($items as $item) {
            $verificationStatus = $item['verification_status'] ?? '';
            $isSigned = !empty($item['digital_signature']);
            
            // Jika item rejected, dianggap selesai (tidak perlu signature)
            if ($verificationStatus === 'rejected') {
                $completedCount++;
                $rejectedCount++;
            } elseif ($isSigned) {
                $completedCount++;
                $signedCount++;
            } else {
                $pendingCount++;
            }
        }
        
        // Jika semua sudah selesai (signed atau rejected)
        if ($completedCount == $totalItems) {
            // Jika semua signed (tidak ada rejected)
            if ($signedCount == $totalItems) {
                return ['status' => 'Signed', 'color' => 'green'];
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

    // Helper function to get admin feedback status
    public function getAdminFeedbackStatus($request)
    {
        $items = $request->items ?? [];
        $totalItems = count($items);
        
        if ($totalItems == 0) {
            return ['status' => 'Open', 'color' => 'gray'];
        }
        
        $filledCount = 0;
        foreach ($items as $item) {
            if (!empty($item['admin_feedback'])) {
                $filledCount++;
            }
        }
        
        if ($filledCount == 0) {
            return ['status' => 'Open', 'color' => 'gray'];
        } elseif ($filledCount == $totalItems) {
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