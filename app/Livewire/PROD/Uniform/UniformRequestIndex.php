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
        $totalItems = count($items);
        
        if ($totalItems == 0) {
            return ['status' => 'Open', 'color' => 'gray'];
        }
        
        $filledCount = 0;
        foreach ($items as $item) {
            if (!empty($item['costing_feedback'])) {
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

    public function render()
    {
        // Check permission for view
        if (!auth()->user()->can('view uniform request') && !auth()->user()->can('view uniform request one user')) {
            abort(403, 'Unauthorized access.');
        }

        $query = UniformRequest::with('creator');

        // PRIORITAS: Jika user memiliki 'view uniform request one user', maka hanya tampilkan data milik sendiri
        // (walaupun juga memiliki 'view uniform request')
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
        if ($this->adminFeedbackFilter || $this->costingFeedbackFilter) {
            $filteredRequests = [];
            foreach ($requests as $request) {
                $adminStatus = $this->getAdminFeedbackStatus($request);
                $costingStatus = $this->getCostingFeedbackStatus($request);
                
                $adminMatch = !$this->adminFeedbackFilter || $adminStatus['status'] == $this->adminFeedbackFilter;
                $costingMatch = !$this->costingFeedbackFilter || $costingStatus['status'] == $this->costingFeedbackFilter;
                
                if ($adminMatch && $costingMatch) {
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