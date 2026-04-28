<?php

namespace App\Livewire\PROD\MS\Sample;

use App\Models\PROD\MS\DetailMasterSample;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class SampleChecksManagement extends Component
{
    use WithPagination;

    // Active tab
    public $activeTab = 'checks';
    
    // Search per tab
    public $searchChecks = '';
    public $searchKnowledge = '';
    public $searchApprovals = '';

    // Bulk action selections
    public $selectedChecks = [];
    public $selectedKnowledge = [];
    public $selectedApprovals = [];
    
    public $selectAllChecks = false;
    public $selectAllKnowledge = false;
    public $selectAllApprovals = false;

    protected function getListeners()
    {
        return [
            'refreshComponent' => '$refresh',
        ];
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
        $this->resetBulkSelections();
    }

    public function resetBulkSelections()
    {
        $this->selectedChecks = [];
        $this->selectedKnowledge = [];
        $this->selectedApprovals = [];
        $this->selectAllChecks = false;
        $this->selectAllKnowledge = false;
        $this->selectAllApprovals = false;
    }

    public function updatedSelectAllChecks($value)
    {
        if ($value) {
            $this->selectedChecks = $this->getChecksQuery()->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedChecks = [];
        }
    }

    public function updatedSelectAllKnowledge($value)
    {
        if ($value) {
            $this->selectedKnowledge = $this->getKnowledgeQuery()->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedKnowledge = [];
        }
    }

    public function updatedSelectAllApprovals($value)
    {
        if ($value) {
            $this->selectedApprovals = $this->getApprovalsQuery()->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedApprovals = [];
        }
    }

    public function updatedSearchChecks()
    {
        $this->resetPage();
        $this->resetBulkSelections();
    }

    public function updatedSearchKnowledge()
    {
        $this->resetPage();
        $this->resetBulkSelections();
    }

    public function updatedSearchApprovals()
    {
        $this->resetPage();
        $this->resetBulkSelections();
    }

    public function getChecksQuery()
    {
        $userId = Auth::id();
        
        return DetailMasterSample::query()
            ->with(['masterSample', 'updater'])
            ->where('checked_by', $userId)
            ->whereNull('check_date')
            ->when($this->searchChecks, function ($query) {
                $query->whereHas('masterSample', function ($q) {
                    $q->where('model_name', 'like', '%' . $this->searchChecks . '%');
                });
            });
    }

    public function getKnowledgeQuery()
    {
        $userId = Auth::id();
        
        return DetailMasterSample::query()
            ->with(['masterSample', 'updater', 'checkedBy'])
            ->where('knowladge_by', $userId)
            ->whereNull('knowladge_date')
            ->whereNotNull('check_date')
            ->when($this->searchKnowledge, function ($query) {
                $query->whereHas('masterSample', function ($q) {
                    $q->where('model_name', 'like', '%' . $this->searchKnowledge . '%');
                });
            });
    }

    public function getApprovalsQuery()
    {
        $userId = Auth::id();
        
        return DetailMasterSample::query()
            ->with(['masterSample', 'updater', 'checkedBy', 'approvedBy'])
            ->where('approved_by', $userId)
            ->whereNull('approve_date')
            ->whereNotNull('check_date')
            ->whereNotNull('knowladge_date')
            ->when($this->searchApprovals, function ($query) {
                $query->whereHas('masterSample', function ($q) {
                    $q->where('model_name', 'like', '%' . $this->searchApprovals . '%');
                });
            });
    }

    public function markAsChecked()
    {
        if (!auth()->user()->can('check master sample')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        if (empty($this->selectedChecks)) {
            $this->dispatch('notify', message: 'Please select items to mark as checked!', type: 'warning');
            return;
        }

        $userId = Auth::id();
        $count = 0;

        foreach ($this->selectedChecks as $id) {
            $record = DetailMasterSample::find($id);
            if ($record && $record->checked_by == $userId && !$record->check_date) {
                $record->check_date = now();
                $record->saveQuietly();
                $count++;
            }
        }

        $this->resetBulkSelections();
        $this->dispatch('notify', message: "{$count} item(s) marked as checked successfully!", type: 'success');
        $this->dispatch('refreshComponent');
    }

    public function markAsKnowledge()
    {
        if (!auth()->user()->can('knowladge master sample')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        if (empty($this->selectedKnowledge)) {
            $this->dispatch('notify', message: 'Please select items to mark as knowledge!', type: 'warning');
            return;
        }

        $userId = Auth::id();
        $count = 0;

        foreach ($this->selectedKnowledge as $id) {
            $record = DetailMasterSample::find($id);
            if ($record && $record->knowladge_by == $userId && !$record->knowladge_date) {
                $record->knowladge_date = now();
                $record->saveQuietly();
                $count++;
            }
        }

        $this->resetBulkSelections();
        $this->dispatch('notify', message: "{$count} item(s) marked as knowledge successfully!", type: 'success');
        $this->dispatch('refreshComponent');
    }

    public function markAsApproved()
    {
        if (!auth()->user()->can('approve master sample')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        if (empty($this->selectedApprovals)) {
            $this->dispatch('notify', message: 'Please select items to mark as approved!', type: 'warning');
            return;
        }

        $userId = Auth::id();
        $count = 0;

        foreach ($this->selectedApprovals as $id) {
            $record = DetailMasterSample::find($id);
            if ($record && $record->approved_by == $userId && !$record->approve_date) {
                $record->approve_date = now();
                $record->saveQuietly();
                $count++;
            }
        }

        $this->resetBulkSelections();
        $this->dispatch('notify', message: "{$count} item(s) marked as approved successfully!", type: 'success');
        $this->dispatch('refreshComponent');
    }

    public function goToSample($masterSampleId)
    {
        return redirect()->to("/prod/ms/master-sample/{$masterSampleId}/details");
    }   

    public function getTabCounts()
    {
        return [
            'checks' => $this->getChecksQuery()->count(),
            'knowledge' => $this->getKnowledgeQuery()->count(),
            'approvals' => $this->getApprovalsQuery()->count(),
        ];
    }

    public function render()
    {
        $tabCounts = $this->getTabCounts();
        
        // Get data based on active tab
        $checks = $this->activeTab === 'checks' ? $this->getChecksQuery()->paginate(10) : collect();
        $knowledge = $this->activeTab === 'knowledge' ? $this->getKnowledgeQuery()->paginate(10) : collect();
        $approvals = $this->activeTab === 'approvals' ? $this->getApprovalsQuery()->paginate(10) : collect();

        // Check permissions for display
        $canViewChecks = auth()->user()->can('check master sample');
        $canViewKnowledge = auth()->user()->can('knowladge master sample');
        $canViewApprovals = auth()->user()->can('approve master sample');

        return view('livewire.prod.ms.sample.sample-checks-management', [
            'checks' => $checks,
            'knowledge' => $knowledge,
            'approvals' => $approvals,
            'tabCounts' => $tabCounts,
            'canViewChecks' => $canViewChecks,
            'canViewKnowledge' => $canViewKnowledge,
            'canViewApprovals' => $canViewApprovals,
        ]);
    }
}