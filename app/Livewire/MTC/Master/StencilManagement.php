<?php

namespace App\Livewire\MTC\Master;

use App\Models\HR\Employee;
use App\Models\MTC\Master\MasterStencil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class StencilManagement extends Component
{
    use WithPagination, WithFileUploads;

    // Form properties
    public $isEditMode = false;
    public $stencil_id;
    public $register_no;
    public $customer;
    public $category;
    public $tooling_type;
    public $location;
    public $status;
    public $line_name;
    public $count_stencil;
    public $nik;
    public $input_count_stencil; // <-- TAMBAHKAN PROPERTY INI
    public $received_date;
    public $registration_date;
    public $sek_cust_id;
    public $fabricator;
    public $model;
    public $description;
    public $application;
    public $pin_qty;
    public $jig_qty;
    public $design_by;
    public $qualified_date;
    public $results;
    public $amount_solder;
    public $rack;
    public $rack_number;
    public $bit_size;
    public $remarks;
    public $photo = [];
    public $existing_photos = [];
    
    // Filter properties
    public $search = '';
    public $selectedStatus = '';
    public $selectedCustomer = '';
    
    // Activity modal
    public $showActivityModal = false;
    public $selectedStencilForActivity = null;
    public $activityPage = 1;
    public $perPageActivities = 10;
    
    #[Url(as: 'tab', history: true)]
    public $activeTab = 'in_use_with_line';
    
    public $tabCounts = [];
    public $isSaving = false;

    public $stencilToDelete = null;

    protected $rules = [
        'register_no' => 'required|string|max:255',
        'customer' => 'required|string|max:255',
        'category' => 'required',
        'tooling_type' => 'required',
        'location' => 'required',
        'status' => 'required',
        'nik' => 'nullable|exists:tb_hr_employee,id',
        'input_count_stencil' => 'nullable|numeric|min:0', // <-- TAMBAHKAN RULE
    ];

    public function mount($id = null)
    {
        if ($id && request()->routeIs('mtc.stencil.edit')) {
            $this->loadStencilForEdit($id);
        }
        if ($id && request()->routeIs('mtc.stencil.update-status')) {
            $this->loadStencilForUpdateStatus($id);
        }
        $this->loadInitialData();
    }

    public function loadStencilForEdit($id)
    {
        $stencil = MasterStencil::find($id);
        if ($stencil) {
            $this->isEditMode = true;
            $this->stencil_id = $stencil->id;
            $this->register_no = $stencil->register_no;
            $this->customer = $stencil->customer;
            $this->category = $stencil->category;
            $this->tooling_type = $stencil->tooling_type;
            $this->location = $stencil->location;
            $this->status = $stencil->status;
            $this->line_name = $stencil->line_name;
            $this->count_stencil = $stencil->count_stencil;
            $this->nik = $stencil->nik;
            $this->received_date = $stencil->received_date;
            $this->registration_date = $stencil->registration_date;
            $this->sek_cust_id = $stencil->sek_cust_id;
            $this->fabricator = $stencil->fabricator;
            $this->model = $stencil->model;
            $this->description = $stencil->description;
            $this->application = $stencil->application;
            $this->pin_qty = $stencil->pin_qty;
            $this->jig_qty = $stencil->jig_qty;
            $this->design_by = $stencil->design_by;
            $this->qualified_date = $stencil->qualified_date;
            $this->results = $stencil->results;
            $this->amount_solder = $stencil->amount_solder;
            $this->rack = $stencil->rack;
            $this->rack_number = $stencil->rack_number;
            $this->bit_size = $stencil->bit_size;
            $this->remarks = $stencil->remarks;
            $this->existing_photos = $stencil->photo ?? [];
        }
    }

    public function loadStencilForUpdateStatus($id)
    {
        $stencil = MasterStencil::find($id);
        if ($stencil) {
            $this->stencil_id = $stencil->id;
            $this->register_no = $stencil->register_no;
            $this->status = $stencil->status;
            $this->line_name = $stencil->line_name;
            $this->nik = $stencil->nik;
            $this->input_count_stencil = null; // <-- RESET
        }
    }

    public function loadInitialData()
    {
        $this->tabCounts = $this->calculateTabCounts();
    }

    private function calculateTabCounts()
    {
        $counts = MasterStencil::select([
            DB::raw("COUNT(*) as total"),
            DB::raw("SUM(CASE WHEN status = 'In Use' THEN 1 ELSE 0 END) as in_use"),
            DB::raw("SUM(CASE WHEN status = 'In Use' AND line_name IS NOT NULL AND line_name != '' AND line_name != '-' THEN 1 ELSE 0 END) as in_use_with_line"),
            DB::raw("SUM(CASE WHEN status = 'Prepared' AND line_name IS NOT NULL AND line_name != '' AND line_name != '-' THEN 1 ELSE 0 END) as prepared"),
            DB::raw("SUM(CASE WHEN status = 'Cleaning' THEN 1 ELSE 0 END) as cleaning"),
            DB::raw("SUM(CASE WHEN status = 'Stand By' THEN 1 ELSE 0 END) as stand_by"),
            DB::raw("SUM(CASE WHEN status = 'Disposed' THEN 1 ELSE 0 END) as disposed"),
        ])->first();
        
        return [
            'all' => $counts->total,
            'in_use' => $counts->in_use,
            'in_use_with_line' => $counts->in_use_with_line,
            'prepared' => $counts->prepared,
            'cleaning' => $counts->cleaning,
            'stand_by' => $counts->stand_by,
            'disposed' => $counts->disposed,
        ];
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function updateTabCounts()
    {
        $this->tabCounts = $this->calculateTabCounts();
    }

    public function saveStencil()
    {
        $this->validate();
        
        try {
            $photoPaths = $this->existing_photos;
            foreach ($this->photo as $p) {
                $photoPaths[] = $p->store('stencil-photos', 'public');
            }
            
            $data = [
                'register_no' => $this->register_no,
                'customer' => $this->customer,
                'category' => $this->category,
                'tooling_type' => $this->tooling_type,
                'location' => $this->location,
                'status' => $this->status,
                'line_name' => $this->line_name,
                'count_stencil' => $this->count_stencil,
                'nik' => $this->nik,
                'received_date' => $this->received_date,
                'registration_date' => $this->registration_date,
                'sek_cust_id' => $this->sek_cust_id,
                'fabricator' => $this->fabricator,
                'model' => $this->model,
                'description' => $this->description,
                'application' => $this->application,
                'pin_qty' => $this->pin_qty,
                'jig_qty' => $this->jig_qty,
                'design_by' => $this->design_by,
                'qualified_date' => $this->qualified_date,
                'results' => $this->results,
                'amount_solder' => $this->amount_solder,
                'rack' => $this->rack,
                'rack_number' => $this->rack_number,
                'bit_size' => $this->bit_size,
                'remarks' => $this->remarks,
                'photo' => $photoPaths,
            ];
            
            if ($this->isEditMode) {
                MasterStencil::where('id', $this->stencil_id)->update($data);
                session()->flash('success', 'Stencil updated successfully!');
            } else {
                MasterStencil::create($data);
                session()->flash('success', 'Stencil created successfully!');
            }
            
            return redirect()->route('mtc.stencil.index');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function saveStatusUpdate()
    {
        $rules = [
            'status' => 'required|in:In Use,Prepared,Cleaning,Stand By,Disposed',
            'nik' => 'required|exists:tb_hr_employee,id',
        ];
        
        if (in_array($this->status, ['In Use', 'Prepared'])) {
            $rules['line_name'] = 'required|string';
        }
        
        if ($this->status === 'Cleaning') {
            $rules['input_count_stencil'] = 'required|numeric|min:1';
        }
        
        $this->validate($rules);
        
        try {
            $stencil = MasterStencil::findOrFail($this->stencil_id);
            $oldStatus = $stencil->status;
            
            $updateData = [
                'status' => $this->status,
                'nik' => $this->nik,
            ];
            
            if (in_array($this->status, ['In Use', 'Prepared'])) {
                $updateData['line_name'] = $this->line_name;
            } else {
                $updateData['line_name'] = null;
            }
            
            if ($this->status === 'Cleaning' && !empty($this->input_count_stencil)) {
                $updateData['count_stencil'] = $this->input_count_stencil;
            }
            
            if ($oldStatus === 'Cleaning' && $this->status !== 'Cleaning') {
                $updateData['count_stencil'] = null;
            }
            
            // Update dan pastikan ada perubahan
            $stencil->update($updateData);
            
            // Force log jika perlu
            activity()
                ->performedOn($stencil)
                ->causedBy(auth()->user())
                ->withProperties([
                    'old' => ['status' => $oldStatus],
                    'attributes' => ['status' => $this->status]
                ])
                ->log("Status changed from '{$oldStatus}' to '{$this->status}'");
            
            session()->flash('success', "Status changed from '{$oldStatus}' to '{$this->status}' successfully!");
            
            return redirect()->route('mtc.stencil.index');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function deleteStencil()
    {
        if ($this->stencilToDelete) {
            $this->stencilToDelete->delete();
            session()->flash('success', 'Stencil deleted successfully!');
            $this->refreshData();
            $this->stencilToDelete = null;
        }
    }

    public function refreshData()
    {
        $this->tabCounts = $this->calculateTabCounts();
        $this->resetPage();
    }

    public function viewActivity($id)
    {
        $this->selectedStencilForActivity = MasterStencil::find($id);
        $this->activityPage = 1;
        $this->showActivityModal = true;
    }

    // PERBAIKAN: Method setActivityPage (HARUS ADA untuk pagination)
    public function setActivityPage($page)
    {
        $this->activityPage = max(1, $page);
    }

    public function closeActivityModal()
    {
        $this->showActivityModal = false;
        $this->selectedStencilForActivity = null;
        $this->activityPage = 1;
    }

    public function removePhoto($index)
    {
        if (isset($this->existing_photos[$index])) {
            Storage::disk('public')->delete($this->existing_photos[$index]);
            unset($this->existing_photos[$index]);
            $this->existing_photos = array_values($this->existing_photos);
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->selectedStatus = '';
        $this->selectedCustomer = '';
        $this->resetPage();
    }

    public function getStatusColorClass($status)
    {
        $colors = [
            'In Use' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
            'Prepared' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
            'Cleaning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
            'Stand By' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
            'Disposed' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
            'Not in Use' => 'bg-gray-100 text-gray-800',
            'Damaged' => 'bg-red-100 text-red-800',
            'Under Repair' => 'bg-orange-100 text-orange-800',
        ];
        return $colors[$status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getEmployeesProperty()
    {
        return Employee::whereIn('status', [1, 2, 3])
            ->orWhereNull('status')
            ->get()
            ->mapWithKeys(function($employee) {
                return [$employee->id => $employee->nik . ' - ' . $employee->name];
            })
            ->toArray();
    }

    public function getLineOptionsProperty()
    {
        $options = [];
        for ($i = 1; $i <= 17; $i++) {
            $options["SMT $i"] = "SMT $i";
        }
        return $options;
    }

    public function getCustomersProperty()
    {
        return MasterStencil::whereNotNull('customer')->distinct()->pluck('customer')->toArray();
    }

    public function getCategoriesProperty()
    {
        return ['STENCIL' => 'STENCIL', 'JIG' => 'JIG', 'MACHINE' => 'MACHINE'];
    }

    public function getToolingTypesProperty()
    {
        $types = MasterStencil::whereNotNull('tooling_type')->distinct()->pluck('tooling_type')->toArray();
        if (empty($types)) {
            return ['METAL MASK' => 'METAL MASK', 'JIG ASSY' => 'JIG ASSY'];
        }
        return array_combine($types, $types);
    }

    public function getActivitiesProperty()
    {
        if (!$this->selectedStencilForActivity) {
            return collect();
        }
        
        // Pastikan menggunakan nama class yang benar
        $activities = Activity::where(function($query) {
                $query->where('subject_type', 'App\Models\MTC\Master\MasterStencil')
                    ->orWhere('subject_type', 'App\Models\MasterStencil')
                    ->orWhere('subject_type', 'App\Models\MTC\Master\Jig');
            })
            ->where('subject_id', $this->selectedStencilForActivity->id)
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPageActivities, ['*'], 'page', $this->activityPage);
        
        // Debug: cek apakah ada data
        \Log::info('Activity count for stencil ID ' . $this->selectedStencilForActivity->id . ': ' . $activities->total());
            
        return $activities;
    }

    public function confirmDelete($id)
    {
        $this->stencilToDelete = MasterStencil::find($id);
        $this->dispatch('open-modal', 'delete-stencil-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view stencil')) {
            abort(403, 'You do not have permission to view stencil.');
        }

        // Jika ini halaman edit, render view edit
        if (request()->routeIs('mtc.stencil.edit') || request()->routeIs('mtc.stencil.create')) {
            return view('livewire.mtc.master.stencil-management.edit', [
                'employees' => $this->employees,
                'lineOptions' => $this->lineOptions,
                'customers' => $this->customers,
                'categories' => $this->categories,
                'toolingTypes' => $this->toolingTypes,
            ]);
        }
        
        // Jika ini halaman update status
        if (request()->routeIs('mtc.stencil.update-status')) {
            return view('livewire.mtc.master.stencil-management.update-status', [
                'employees' => $this->employees,
                'lineOptions' => $this->lineOptions,
            ]);
        }

        // Halaman index (list)
        $query = MasterStencil::with('employee')
            ->when($this->activeTab !== 'all', function ($q) {
                $statusMap = [
                    'in_use' => 'In Use',
                    'in_use_with_line' => 'In Use',
                    'prepared' => 'Prepared',
                    'cleaning' => 'Cleaning',
                    'stand_by' => 'Stand By',
                    'disposed' => 'Disposed',
                ];
                
                if (isset($statusMap[$this->activeTab])) {
                    $q->where('status', $statusMap[$this->activeTab]);
                    
                    // Untuk tab 'in_use_with_line' dan 'prepared', hanya tampilkan yang line_name terisi
                    if (in_array($this->activeTab, ['in_use_with_line', 'prepared'])) {
                        $q->whereNotNull('line_name')
                          ->where('line_name', '!=', '')
                          ->where('line_name', '!=', '-');
                    }
                }
            })
            ->when($this->search, function ($q) {
                $q->where(function($query) {
                    $query->where('register_no', 'like', '%' . $this->search . '%')
                        ->orWhere('customer', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedStatus, function ($q) {
                $q->where('status', $this->selectedStatus);
            })
            ->when($this->selectedCustomer, function ($q) {
                $q->where('customer', 'like', '%' . $this->selectedCustomer . '%');
            });
        
        // Sorting
        if (in_array($this->activeTab, ['in_use_with_line', 'prepared'])) {
            // Sort by line_name (SMT 1, SMT 2, ...)
            $query->orderByRaw("CAST(SUBSTRING_INDEX(line_name, ' ', -1) AS UNSIGNED) ASC");
        } 
        else {
            // Sort by rack_number
            $query->orderByRaw("
                CASE 
                    WHEN rack_number IS NULL OR rack_number = '' OR rack_number = '-' THEN 1 
                    ELSE 0 
                END ASC
            ");
            $query->orderByRaw("CAST(rack_number AS UNSIGNED) ASC");
        }
        
        $stencils = $query->paginate(10);
        
        return view('livewire.mtc.master.stencil-management.index', [
            'stencils' => $stencils,
            'activities' => $this->activities,
        ]);
    }
}