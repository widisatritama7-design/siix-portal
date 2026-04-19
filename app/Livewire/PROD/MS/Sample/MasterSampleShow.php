<?php

namespace App\Livewire\PROD\MS\Sample;

use App\Models\HR\Employee;
use App\Models\PROD\MS\DetailMasterSample;
use App\Models\PROD\MS\HistoryMasterSample;
use App\Models\PROD\MS\MasterSample;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class MasterSampleShow extends Component
{
    use WithPagination;
    
    public $masterSample;
    public $activeRelationTab = 'history';
    public $perPage = 5;
    public $selectedLoanId = null;
    public $selectedNik = null;
    public $employees = [];
    
    // Properties for Activity Modal
    public $showActivityModal = false;
    public $selectedRecordForActivity = null;
    public $selectedRecordType = null; // 'history' or 'detail'
    public $activityPage = 1;
    public $perPageActivities = 10;
    
    public function mount($id, $tab = 'history')
    {
        $this->activeRelationTab = $tab;
        $this->masterSample = MasterSample::with(['rack'])->findOrFail($id);
        
        if (!auth()->user()->can('view master sample')) {
            abort(403, 'Unauthorized access.');
        }
        
        $this->loadEmployees();
    }
    
    private function loadEmployees()
    {
        $this->employees = Employee::query()
            ->whereIn('status', [1, 2, 3])
            ->select('id', 'nik', 'name')
            ->get();
    }
    
    private function safeDecodeType($type)
    {
        if (is_null($type)) return [];
        if (is_array($type)) return $type;
        $decoded = json_decode($type, true);
        return is_array($decoded) ? $decoded : [];
    }
    
    public function isDetailsUpdated($record)
    {
        // Implement your logic to check if details are updated for ECR
        // This is a placeholder - adjust based on your business logic
        return true;
    }
    
    public function openUpdateInDateModal($loanId)
    {
        $this->selectedLoanId = $loanId;
        $this->selectedNik = null;
        $this->loadEmployees();
    }   

    public function cancelUpdateInDate()
    {
        $this->selectedLoanId = null;
        $this->selectedNik = null;
    }

    public function confirmUpdateInDate()
    {
        $this->validate([
            'selectedNik' => 'required|exists:tb_hr_employee,id',
        ]);
        
        $record = HistoryMasterSample::find($this->selectedLoanId);
        
        if (!$record) {
            $this->dispatch('notify', message: 'Record not found!', type: 'error');
            return;
        }
        
        // Update NIK and In Date
        $record->nik = $this->selectedNik;
        $record->in_date = now();
        $record->status = 'stand_by';
        $record->save();
        
        // Clear any session flags if needed
        if ($record->status === 'ecr') {
            session()->forget("details_updated_{$this->masterSample->id}");
            
            if (isset($record->details_updated)) {
                $record->update(['details_updated' => false]);
            }
        }
        
        $this->dispatch('notify', message: 'In Date and NIK updated successfully!', type: 'success');
        
        $this->selectedLoanId = null;
        $this->selectedNik = null;
        $this->resetPage();
    }
    
    public function updateInDate()
    {
        $this->validate([
            'selectedNik' => 'required|exists:employees,ID',
        ]);
        
        $record = HistoryMasterSample::find($this->selectedLoanId);
        
        if (!$record) {
            $this->dispatch('notify', message: 'Record not found!', type: 'error');
            $this->dispatch('close-modal');
            return;
        }
        
        // Update NIK and In Date
        $record->nik = $this->selectedNik;
        $record->in_date = now();
        $record->status = 'stand_by';
        $record->save();
        
        // Clear any session flags if needed
        if ($record->status === 'ecr') {
            session()->forget("details_updated_{$this->masterSample->id}");
            
            if (isset($record->details_updated)) {
                $record->update(['details_updated' => false]);
            }
        }
        
        $this->dispatch('notify', message: 'In Date and NIK updated successfully!', type: 'success');
        $this->dispatch('close-modal');
        
        $this->selectedLoanId = null;
        $this->selectedNik = null;
        $this->resetPage();
    }
    
    public function deleteLoan($id)
    {
        HistoryMasterSample::find($id)?->delete();
        $this->dispatch('notify', message: 'Loan history deleted!', type: 'success');
        $this->resetPage();
    }
    
    public function deleteExpired($id)
    {
        DetailMasterSample::find($id)?->delete();
        $this->dispatch('notify', message: 'Expired history deleted!', type: 'success');
        $this->resetPage();
    }
    
    public function setRelationTab($tab)
    {
        $this->activeRelationTab = $tab;
        $this->resetPage();
    }
    
    // Activity Modal Methods
    public function viewActivity($id, $type)
    {
        if ($type === 'history') {
            $this->selectedRecordForActivity = HistoryMasterSample::find($id);
            $this->selectedRecordType = 'history';
        } elseif ($type === 'detail') {
            $this->selectedRecordForActivity = DetailMasterSample::find($id);
            $this->selectedRecordType = 'detail';
        }
        
        $this->activityPage = 1;
        $this->showActivityModal = true;
    }

    public function closeActivityModal()
    {
        $this->showActivityModal = false;
        $this->selectedRecordForActivity = null;
        $this->selectedRecordType = null;
        $this->activityPage = 1;
    }

    public function setActivityPage($page)
    {
        $this->activityPage = $page;
    }

    /**
     * Get employee name by ID
     */
    public function getEmployeeName($id)
    {
        if (empty($id)) {
            return '-';
        }
        
        $employee = Employee::where('id', $id)->first();
        return $employee ? $employee->name . ' (' . $employee->nik . ')' : $id;
    }

    /**
     * Get user name by ID
     */
    public function getUserName($id)
    {
        if (empty($id)) {
            return '-';
        }
        
        $user = User::find($id);
        return $user ? $user->name : $id;
    }

    /**
     * Get possible model namespaces for activity lookup
     */
    private function getPossibleModelNamespaces($type)
    {
        $namespaces = [];
        
        if ($type === 'history') {
            $namespaces = [
                'App\Models\PROD\MS\HistoryMasterSample',
                'App\Models\HistoryMasterSample',
                'App\PROD\MS\HistoryMasterSample',
                'HistoryMasterSample'
            ];
        } elseif ($type === 'detail') {
            $namespaces = [
                'App\Models\PROD\MS\DetailMasterSample',
                'App\Models\DetailMasterSample',
                'App\PROD\MS\DetailMasterSample',
                'DetailMasterSample'
            ];
        }
        
        return $namespaces;
    }

    public function getActivitiesProperty()
    {
        if (!$this->selectedRecordForActivity) {
            return collect();
        }
        
        // Get all possible namespaces for the model type
        $possibleNamespaces = $this->getPossibleModelNamespaces($this->selectedRecordType);
        
        // Search for activities using any of the possible namespaces
        $activities = Activity::where(function($query) use ($possibleNamespaces) {
                foreach ($possibleNamespaces as $namespace) {
                    $query->orWhere('subject_type', $namespace);
                }
            })
            ->where('subject_id', $this->selectedRecordForActivity->id)
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPageActivities, ['*'], 'page', $this->activityPage);
            
        // If no activities found with the current namespace, try to update the activity records
        if ($activities->isEmpty() && $this->selectedRecordForActivity) {
            // This handles cases where activities were logged with a different namespace
            // You might want to run a one-time migration script to update old activity records
            $correctNamespace = $this->selectedRecordType === 'history' 
                ? 'App\Models\PROD\MS\HistoryMasterSample'
                : 'App\Models\PROD\MS\DetailMasterSample';
                
            // Update old activities to use the correct namespace (optional)
            Activity::where(function($query) use ($possibleNamespaces, $correctNamespace) {
                    foreach ($possibleNamespaces as $namespace) {
                        if ($namespace !== $correctNamespace) {
                            $query->orWhere('subject_type', $namespace);
                        }
                    }
                })
                ->where('subject_id', $this->selectedRecordForActivity->id)
                ->update(['subject_type' => $correctNamespace]);
            
            // Refetch activities with the correct namespace
            $activities = Activity::where('subject_type', $correctNamespace)
                ->where('subject_id', $this->selectedRecordForActivity->id)
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPageActivities, ['*'], 'page', $this->activityPage);
        }
        
        return $activities;
    }
    
    private function canAddLoan()
    {
        $expiredDate = $this->masterSample->latestDetail?->expired_date;
        if ($expiredDate && now()->greaterThanOrEqualTo($expiredDate->startOfDay())) return false;
        $lastRecord = $this->masterSample->historydDetails()->latest('out_date')->first();
        return !$lastRecord || !is_null($lastRecord->in_date);
    }
    
    public function getHistoriesProperty()
    {
        return HistoryMasterSample::where('master_sample_id', $this->masterSample->id)
            ->with(['employee', 'masterLine.location'])
            ->orderByDesc('created_at')
            ->paginate($this->perPage);
    }
    
    public function getDetailsProperty()
    {
        return DetailMasterSample::where('master_sample_id', $this->masterSample->id)
            ->with(['checkedBy', 'knowladgeBy', 'approvedBy'])
            ->orderByDesc('created_at')
            ->paginate($this->perPage)
            ->through(function ($item) {
                if ($item->expired_date) {
                    $expired = Carbon::parse($item->expired_date)->startOfDay();
                    $diff = Carbon::today()->diffInDays($expired, false);
                    $item->days_left = $diff > 0 ? "$diff hari" : ($diff === 0 ? 'Hari ini' : ($diff < 0 ? 'Lewat ' . abs($diff) . ' hari' : '-'));
                } else {
                    $item->days_left = '-';
                }
                return $item;
            });
    }
    
    public function render()
    {
        return view('livewire.prod.ms.sample.master-sample-show', [
            'histories' => $this->histories,
            'details' => $this->details,
            'canAddLoan' => $this->canAddLoan(),
            'canAddExpired' => $this->masterSample->details()->count() === 0,
            'activities' => $this->activities,
        ]);
    }
}