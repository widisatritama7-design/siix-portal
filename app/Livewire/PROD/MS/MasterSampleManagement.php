<?php

namespace App\Livewire\PROD\MS;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PROD\MS\MasterSample;
use App\Models\PROD\MS\MasterRackSample;
use App\Models\PROD\MS\DetailMasterSample;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MasterSampleManagement extends Component
{
    use WithPagination;

    // Form fields
    public $master_sample_id;
    public $model_name;
    public $customer;
    public $name_or_mc;
    public $rack_id;
    public $rack_backup;
    public $sample_ok;
    public $sample_ok_backup = false;
    public $sample_ng;
    public $sample_blank = false;
    public $remarks;
    public $status = 'ACTIVE';
    
    // Search & Filters
    public $search = '';
    public $filterCustomer = '';
    public $filterNameOrMc = '';
    
    // Detail (Expired History)
    public $details = [];
    public $modalTitle = 'Add New Master Sample';
    public $sampleToDelete = null;
    
    // Customer & Name/MC options for select
    public $customerOptions = [];
    public $nameOrMcOptions = [];
    
    // Available racks
    public $availableRacks = [];
    
    // For display
    public $currentRackInfo = '';

    // Tabs
    public $activeTab = 'active';
    public $tabCounts = [];

    public $updatingStatusSample = null;
    public $selectedStatus = 'ACTIVE';

    protected function rules()
    {
        return [
            'model_name' => 'required|min:3|max:255',
            'customer' => 'required|string|max:255',
            'name_or_mc' => 'required|string|max:255',
            'rack_id' => 'nullable|exists:tb_prod_master_rack_samples,id',
            'rack_backup' => 'nullable|string|max:255',
            'sample_ok' => 'nullable|string|max:255',
            'sample_ok_backup' => 'boolean',
            'sample_ng' => 'nullable|string|max:255',
            'sample_blank' => 'boolean',
            'remarks' => 'nullable|string',
            'status' => 'nullable|string|in:ACTIVE,NOT USE,EOL,UNDER PE',
            'details' => 'required|array|min:1',
            'details.*.updated_date' => 'required|date',
            'details.*.expired_date' => 'required|date|after_or_equal:details.*.updated_date',
            'details.*.date_alarm' => 'required|date',
            'details.*.checked_by' => 'nullable|exists:users,id',
            'details.*.knowladge_by' => 'nullable|exists:users,id',
            'details.*.approved_by' => 'nullable|exists:users,id',
        ];
    }

    protected $messages = [
        'model_name.required' => 'Model name is required.',
        'model_name.min' => 'Model name must be at least 3 characters.',
        'customer.required' => 'Customer is required.',
        'name_or_mc.required' => 'Name/MC is required.',
        'details.required' => 'Expired history is required.',
        'details.*.expired_date.after_or_equal' => 'Expired date must be after or equal to updated date.',
    ];

    public function mount()
    {
        $this->loadOptions();
        $this->initDetail();
        $this->updateTabCounts();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
        $this->updateTabCounts();
    }

    public function updateTabCounts()
    {
        $now = now()->startOfDay();
        
        $this->tabCounts = [
            'active' => MasterSample::whereHas('details', fn($q) => $q->where('expired_date', '>', $now))->count(),
            'expired' => MasterSample::where('status', 'ACTIVE')
                ->whereHas('details', fn($q) => $q->where('expired_date', '<=', $now))->count(),
            'eol' => MasterSample::where('status', 'EOL')->count(),
            'under_pe' => MasterSample::where('status', 'UNDER PE')->count(),
            'expire_this_month' => MasterSample::where('status', 'ACTIVE')
                ->whereHas('details', fn($q) =>
                    $q->whereBetween('expired_date', [
                        $now->copy()->startOfMonth(),
                        $now->copy()->endOfMonth(),
                    ])
                )->count(),
            'all' => MasterSample::count(),
        ];
    }

    public function loadOptions()
    {
        // Load customer options
        $this->customerOptions = MasterSample::query()
            ->whereNotNull('customer')
            ->distinct()
            ->pluck('customer', 'customer')
            ->toArray();
            
        // Load name_or_mc options
        $this->nameOrMcOptions = MasterSample::query()
            ->whereNotNull('name_or_mc')
            ->where('name_or_mc', '!=', '')
            ->distinct()
            ->pluck('name_or_mc', 'name_or_mc')
            ->toArray();
            
        // Load available racks (unused racks)
        $this->loadAvailableRacks();
    }
    
    public function loadAvailableRacks()
    {
        $query = MasterRackSample::query();
        
        if ($this->master_sample_id) {
            // Perbaiki: gunakan nama tabel yang benar (tb_prod_master_samples) bukan master_samples
            $query->whereDoesntHave('samples', function ($q) {
                $q->where('tb_prod_master_samples.id', '!=', $this->master_sample_id);
            });
        } else {
            $query->whereDoesntHave('samples');
        }
        
        $this->availableRacks = $query->get()->mapWithKeys(fn ($rack) => [
            $rack->id => "Type: {$rack->type_rack} - Column: {$rack->column_rack} - Sheet: {$rack->sheet_rack}"
        ])->toArray();
    }
    
    public function initDetail()
    {
        if (empty($this->details)) {
            $this->details = [
                [
                    'updated_date' => Carbon::now()->format('Y-m-d'),
                    'expired_date' => Carbon::now()->addYear()->format('Y-m-d'),
                    'date_alarm' => Carbon::now()->addYear()->subMonth()->format('Y-m-d'),
                    'checked_by' => null,
                    'knowladge_by' => null,
                    'approved_by' => null,
                ]
            ];
        }
    }
    
    public function updatedCustomer()
    {
        $this->generateSampleNumber();
        $this->updateCurrentRackInfo();
    }
    
    public function updatedNameOrMc()
    {
        $this->generateSampleNumber();
        $this->updateCurrentRackInfo();
    }
    
    public function updatedRackId()
    {
        $this->updateCurrentRackInfo();
    }
    
    public function updateCurrentRackInfo()
    {
        if ($this->rack_id && isset($this->availableRacks[$this->rack_id])) {
            $this->currentRackInfo = $this->availableRacks[$this->rack_id];
        } else {
            $this->currentRackInfo = '';
        }
    }
    
    public function generateSampleNumber()
    {
        if (!$this->customer || !$this->name_or_mc) {
            return;
        }
        
        $customer = strtoupper($this->customer);
        $nameOrMc = strtoupper($this->name_or_mc);
        
        // Find last sequence
        $last = MasterSample::where('sample_ok', 'like', "{$customer}-OK-{$nameOrMc}-%")
            ->orderByDesc('sample_ok')
            ->first();
            
        $next = 1;
        if ($last && preg_match('/(\d{3})$/', $last->sample_ok, $m)) {
            $next = ((int) $m[1]) + 1;
        }
        
        $seq = str_pad($next, 3, '0', STR_PAD_LEFT);
        
        $this->sample_ok = "{$customer}-OK-{$nameOrMc}-{$seq}";
        $this->sample_ng = "{$customer}-NG-{$nameOrMc}-{$seq}";
    }
    
    public function addDetailRow()
    {
        $this->details[] = [
            'updated_date' => Carbon::now()->format('Y-m-d'),
            'expired_date' => Carbon::now()->addYear()->format('Y-m-d'),
            'date_alarm' => Carbon::now()->addYear()->subMonth()->format('Y-m-d'),
            'checked_by' => null,
            'knowladge_by' => null,
            'approved_by' => null,
        ];
    }
    
    public function removeDetailRow($index)
    {
        if (count($this->details) > 1) {
            unset($this->details[$index]);
            $this->details = array_values($this->details);
        }
    }
    
    public function updatedDetailUpdatedDate($value, $key)
    {
        $index = explode('.', $key)[0];
        if ($value) {
            $date = Carbon::parse($value);
            $this->details[$index]['expired_date'] = $date->copy()->addYear()->format('Y-m-d');
            $this->details[$index]['date_alarm'] = $date->copy()->addYear()->subMonth()->format('Y-m-d');
        }
    }
    
    public function resetForm()
    {
        $this->reset([
            'master_sample_id', 'model_name', 'customer', 'name_or_mc', 
            'rack_id', 'rack_backup', 'sample_ok', 'sample_ok_backup',
            'sample_ng', 'sample_blank', 'remarks', 'status'
        ]);
        $this->details = [];
        $this->modalTitle = 'Add New Master Sample';
        $this->currentRackInfo = '';
        $this->resetValidation();
        $this->initDetail();
        $this->loadAvailableRacks();
    }
    
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function updatedFilterCustomer()
    {
        $this->resetPage();
    }
    
    public function updatedFilterNameOrMc()
    {
        $this->resetPage();
    }
    
    public function save()
    {
        // Permission check
        if ($this->master_sample_id) {
            if (!auth()->user()->can('edit master sample')) {
                $this->dispatch('notify', message: 'You do not have permission to edit!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create master sample')) {
                $this->dispatch('notify', message: 'You do not have permission to create!', type: 'error');
                return;
            }
        }
        
        $this->validate();
        
        DB::beginTransaction();
        
        try {
            // Prepare data
            $data = [
                'model_name' => $this->model_name,
                'customer' => strtoupper($this->customer),
                'name_or_mc' => strtoupper($this->name_or_mc),
                'rack_id' => $this->rack_id,
                'rack_backup' => $this->rack_backup,
                'sample_ok' => $this->sample_ok,
                'sample_ok_backup' => $this->sample_ok_backup,
                'sample_ng' => $this->sample_ng,
                'sample_blank' => $this->sample_blank,
                'remarks' => $this->remarks,
                'status' => $this->status ?? 'ACTIVE',
            ];
            
            if ($this->master_sample_id) {
                $masterSample = MasterSample::find($this->master_sample_id);
                if (!$masterSample) {
                    throw new \Exception('Master sample not found');
                }
                $masterSample->update($data);
                $message = 'Master sample updated successfully!';
                
                // Update details
                foreach ($this->details as $detailData) {
                    if (isset($detailData['id'])) {
                        $detail = DetailMasterSample::find($detailData['id']);
                        if ($detail) {
                            $detail->update($this->prepareDetailData($detailData));
                        }
                    } else {
                        $masterSample->details()->create($this->prepareDetailData($detailData));
                    }
                }
            } else {
                $masterSample = MasterSample::create($data);
                
                // Create details
                foreach ($this->details as $detailData) {
                    $masterSample->details()->create($this->prepareDetailData($detailData));
                }
                $message = 'Master sample created successfully!';
            }
            
            DB::commit();
            
            $this->resetForm();
            $this->dispatch('notify', message: $message);
            $this->dispatch('close-modal', 'master-sample-form-modal');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', message: 'Error: ' . $e->getMessage(), type: 'error');
        }
    }
    
    private function prepareDetailData($detailData)
    {
        $data = [
            'updated_date' => $detailData['updated_date'],
            'expired_date' => $detailData['expired_date'],
            'date_alarm' => $detailData['date_alarm'],
            'checked_by' => $detailData['checked_by'] ?? null,
            'knowladge_by' => $detailData['knowladge_by'] ?? null,
            'approved_by' => $detailData['approved_by'] ?? null,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ];
        
        if (!empty($data['checked_by'])) {
            $data['check_date'] = now();
        }
        if (!empty($data['knowladge_by'])) {
            $data['knowladge_date'] = now();
        }
        if (!empty($data['approved_by'])) {
            $data['approve_date'] = now();
        }
        
        return $data;
    }
    
    public function edit($id)
    {
        if (!auth()->user()->can('edit master sample')) {
            $this->dispatch('notify', message: 'You do not have permission to edit!', type: 'error');
            return;
        }
        
        $masterSample = MasterSample::with('details')->find($id);
        
        if (!$masterSample) {
            $this->dispatch('notify', message: 'Master sample not found!', type: 'error');
            return;
        }
        
        $this->master_sample_id = $masterSample->id;
        $this->model_name = $masterSample->model_name;
        $this->customer = $masterSample->customer;
        $this->name_or_mc = $masterSample->name_or_mc;
        $this->rack_id = $masterSample->rack_id;
        $this->rack_backup = $masterSample->rack_backup;
        $this->sample_ok = $masterSample->sample_ok;
        $this->sample_ok_backup = (bool) $masterSample->sample_ok_backup;
        $this->sample_ng = $masterSample->sample_ng;
        $this->sample_blank = (bool) $masterSample->sample_blank;
        $this->remarks = $masterSample->remarks;
        $this->status = $masterSample->status ?? 'ACTIVE';
        $this->modalTitle = 'Edit Master Sample';
        
        // Load details
        $this->details = [];
        foreach ($masterSample->details as $detail) {
            $this->details[] = [
                'id' => $detail->id,
                'updated_date' => $detail->updated_date,
                'expired_date' => $detail->expired_date,
                'date_alarm' => $detail->date_alarm,
                'checked_by' => $detail->checked_by,
                'knowladge_by' => $detail->knowladge_by,
                'approved_by' => $detail->approved_by,
            ];
        }
        
        if (empty($this->details)) {
            $this->initDetail();
        }
        
        $this->loadAvailableRacks();
        $this->updateCurrentRackInfo();
    }
    
    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete master sample')) {
            $this->dispatch('notify', message: 'You do not have permission to delete!', type: 'error');
            return;
        }
        
        $masterSample = MasterSample::find($id);
        
        if (!$masterSample) {
            $this->dispatch('notify', message: 'Master sample not found!', type: 'error');
            return;
        }
        
        $this->sampleToDelete = $masterSample;
        $this->dispatch('open-modal', 'delete-master-sample-modal');
    }
    
    public function delete()
    {
        if (!auth()->user()->can('delete master sample')) {
            $this->dispatch('notify', message: 'You do not have permission to delete!', type: 'error');
            return;
        }
        
        $masterSample = MasterSample::find($this->sampleToDelete->id);
        
        if (!$masterSample) {
            $this->dispatch('notify', message: 'Master sample not found!', type: 'error');
            $this->sampleToDelete = null;
            return;
        }
        
        $sampleName = $masterSample->model_name;
        
        // Delete related details first
        $masterSample->details()->delete();
        $masterSample->delete();
        
        $this->sampleToDelete = null;
        $this->dispatch('notify', message: "Master sample '{$sampleName}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-master-sample-modal');
    }
    
    public function cancelDelete()
    {
        $this->sampleToDelete = null;
        $this->dispatch('close-modal', 'delete-master-sample-modal');
    }
    
    public function getUserOptions($permission)
    {
        return User::permission($permission)->pluck('name', 'id')->toArray();
    }

    public function updateStatus($id, $newStatus)
    {
        if (!auth()->user()->can('edit master sample')) {
            $this->dispatch('notify', message: 'You do not have permission to update status!', type: 'error');
            return;
        }
        
        $masterSample = MasterSample::find($id);
        
        if (!$masterSample) {
            $this->dispatch('notify', message: 'Master sample not found!', type: 'error');
            return;
        }
        
        // Update status
        $masterSample->update(['status' => $newStatus]);
        
        $this->dispatch('notify', message: "Sample status successfully updated to {$newStatus}", type: 'success');
    }

    public function openUpdateStatusModal($id)
    {
        if (!auth()->user()->can('edit master sample')) {
            $this->dispatch('notify', message: 'You do not have permission to update status!', type: 'error');
            return;
        }
        
        $masterSample = MasterSample::find($id);
        
        if (!$masterSample) {
            $this->dispatch('notify', message: 'Master sample not found!', type: 'error');
            return;
        }
        
        $this->updatingStatusSample = $masterSample;
        $this->selectedStatus = $masterSample->status ?? 'ACTIVE';
        $this->dispatch('open-modal', 'update-status-modal');
    }

    public function confirmUpdateStatus()
    {
        if (!$this->updatingStatusSample) {
            $this->dispatch('notify', message: 'No sample selected!', type: 'error');
            return;
        }
        
        $this->updateStatus($this->updatingStatusSample->id, $this->selectedStatus);
        $this->updatingStatusSample = null;
        $this->selectedStatus = 'ACTIVE';
        $this->dispatch('close-modal', 'update-status-modal');
    }

    public function cancelUpdateStatus()
    {
        $this->updatingStatusSample = null;
        $this->selectedStatus = 'ACTIVE';
        $this->dispatch('close-modal', 'update-status-modal');
    }

    public function goToShow($id)
    {
        return redirect()->route('prod.ms.master-sample.show', ['id' => $id, 'tab' => 'history']);
    }
    
    public function render()
    {
        if (!auth()->user()->can('view master sample')) {
            abort(403, 'Unauthorized access.');
        }
        
        $query = MasterSample::with(['rack', 'creator', 'details']);
        
        // Apply tab filter
        $now = now()->startOfDay();
        switch ($this->activeTab) {
            case 'active':
                $query->whereHas('details', function ($q) use ($now) {
                    $q->where('expired_date', '>', $now);
                });
                break;
            case 'expired':
                $query->where('status', 'ACTIVE')
                      ->whereHas('details', function ($q) use ($now) {
                          $q->where('expired_date', '<=', $now);
                      });
                break;
            case 'eol':
                $query->where('status', 'EOL');
                break;
            case 'under_pe':
                $query->where('status', 'UNDER PE');
                break;
            case 'expire_this_month':
                $query->where('status', 'ACTIVE')
                      ->whereHas('details', function ($q) use ($now) {
                          $q->whereBetween('expired_date', [
                              $now->copy()->startOfMonth(),
                              $now->copy()->endOfMonth(),
                          ]);
                      });
                break;
            case 'all':
            default:
                // No filter
                break;
        }
        
        // Apply search and filters
        $query->when($this->search, function ($q) {
            $q->where(function ($query) {
                $query->where('model_name', 'like', '%' . $this->search . '%')
                      ->orWhere('customer', 'like', '%' . $this->search . '%')
                      ->orWhere('name_or_mc', 'like', '%' . $this->search . '%')
                      ->orWhere('sample_ok', 'like', '%' . $this->search . '%')
                      ->orWhere('sample_ng', 'like', '%' . $this->search . '%');
            });
        })
        ->when($this->filterCustomer, function ($query) {
            $query->where('customer', $this->filterCustomer);
        })
        ->when($this->filterNameOrMc, function ($query) {
            $query->where('name_or_mc', $this->filterNameOrMc);
        })
        ->orderBy('id', 'asc');
        
        $masterSamples = $query->paginate(10);
        
        // Update tab counts
        $this->updateTabCounts();
        
        // Prepare data for view with computed fields
        $masterSamples->getCollection()->transform(function ($sample) {
            $latestDetail = $sample->details->sortByDesc('expired_date')->first();
            
            // Latest Expired Date
            if ($latestDetail && $latestDetail->expired_date) {
                $sample->latest_expired_date = Carbon::parse($latestDetail->expired_date)->format('Y-m-d');
            } else {
                $sample->latest_expired_date = match ($sample->status) {
                    'EOL' => 'EOL',
                    'NOT USE' => 'Not Use',
                    null => 'Expire Not Set',
                    default => '-',
                };
            }
            
            // Status Expire
            if (!$latestDetail || !$latestDetail->expired_date) {
                $sample->latest_status = match ($sample->status) {
                    'EOL' => 'EOL',
                    'NOT USE' => 'Not Use',
                    default => 'Expire Not Set',
                };
            } else {
                $sample->latest_status = Carbon::parse($latestDetail->expired_date)->isFuture() ? 'Active' : 'Expired';
            }
            
            // Days Remaining
            if (!$latestDetail || !$latestDetail->expired_date) {
                $sample->days_remaining = match ($sample->status) {
                    'EOL' => 'EOL',
                    'NOT USE' => 'Not Use',
                    default => '-',
                };
            } else {
                $today = Carbon::today();
                $expired = Carbon::parse($latestDetail->expired_date)->startOfDay();
                $diff = $today->diffInDays($expired, false);
                
                $sample->days_remaining = match (true) {
                    $diff > 0 => "$diff days",
                    $diff === 0 => 'Today',
                    $diff < 0 => 'Overdue ' . abs($diff) . ' days',
                };
            }
            
            // Latest History (Loan) Info
            $latestHistory = $sample->historydDetails()->orderByDesc('out_date')->first();
            $sample->latest_history_location = optional($latestHistory?->masterLine?->location)->location_name ?? '-';
            $sample->latest_history_line = optional($latestHistory?->masterLine)->line_number ?? '-';
            $sample->latest_history_remarks = $latestHistory?->remarks ?? '-';
            
            // Loan Status
            $loanStatus = $latestHistory?->status ?? '-';
            $sample->loan_status = match ($loanStatus) {
                'in_use' => 'In Use',
                'loaning' => 'Loaning',
                'ecr' => 'ECR',
                'stand_by' => 'Stand By',
                '-' => 'No History',
                default => ucfirst($loanStatus),
            };
            
            return $sample;
        });
        
        return view('livewire.prod.ms.master-sample-management', [
            'masterSamples' => $masterSamples,
            'customerFilterOptions' => $this->customerOptions,
            'nameFilterOptions' => $this->nameOrMcOptions,
            'checkedByOptions' => $this->getUserOptions('check master sample'),
            'knowledgeByOptions' => $this->getUserOptions('knowladge master sample'),
            'approvedByOptions' => $this->getUserOptions('approve master sample'),
            'activeTab' => $this->activeTab,
            'tabCounts' => $this->tabCounts,
        ]);
    }
}