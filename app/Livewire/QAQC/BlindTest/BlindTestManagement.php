<?php

namespace App\Livewire\QAQC\BlindTest;

use App\Models\HR\Employee;
use App\Models\QAQC\BlindTest\BlindTest;
use App\Models\QAQC\BlindTest\Customer;
use App\Models\QAQC\BlindTest\Deffect;
use App\Models\QAQC\BlindTest\Model as QaqcModel;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class BlindTestManagement extends Component
{
    use WithPagination;

    // ==================== FORM PROPERTIES ====================
    public $blind_test_id;
    public $employee_id = '';
    public $employee_nik = '';
    public $employee_name = '';
    public $employee_department = '';
    public $shift = '';
    public $group = '';
    public $customer_id = '';
    public $model_id = '';
    public $blind_test_items = [];
    public $time_test = '';
    public $duration_minutes = '';
    public $check_by_qc = '';
    public $check_by_prod = '';
    public $acknowledge_by_spv = '';
    public $acknowledge_qc_spv = '';

    // ==================== APPROVAL ====================
    public $approvalType = null;
    public $approvalRemark = '';
    public $approvalBlindTestId = null;

    // ==================== EMPLOYEE SEARCH ====================
    public $employeeSearch = '';
    public $showEmployeeDropdown = false;

    // ==================== SEARCH & FILTER ====================
    public $search = '';
    public $filterDepartment = '';
    public $filterShift = '';
    public $filterGroup = '';
    public $filterCustomer = '';
    public $filterModel = '';
    public $filterResult = '';

    // ==================== TABS ====================
    public $activeTab = 'all';
    public $tabCounts = [
        'all'         => 0,
        'open'        => 0,
        'in_progress' => 0,
        'closed'      => 0,
        'rejected'    => 0,
        'deleted'     => 0,
    ];

    // ==================== MODAL STATE ====================
    public $modalTitle = 'Add New Blind Test';
    public $blindTestToDelete = null;
    public $deleteReason = '';
    public $viewData = null;

    // ==================== VALIDATION ====================
    protected function rules()
    {
        return [
            'employee_id'   => 'required|exists:tb_hr_employee,id',
            'shift'         => 'required|string|max:50',
            'group'         => 'nullable|string|max:50',
            'customer_id'   => 'required|exists:tb_qaqc_customer,id',
            'model_id'      => 'required|exists:tb_qaqc_model,id',
            'blind_test_items' => 'required|array|min:1',
            'blind_test_items.*.deffect_item_id'    => 'required|exists:tb_qaqc_deffect,id',
            'blind_test_items.*.component_location' => 'required|string|max:255',
            'time_test'         => 'required',
            'duration_minutes'  => 'nullable|integer|min:1|max:600',
        ];
    }

    protected $messages = [
        'employee_id.required' => 'Employee is required.',
        'shift.required' => 'Shift is required.',
        'customer_id.required' => 'Customer is required.',
        'model_id.required' => 'Model is required.',
        'blind_test_items.required' => 'Minimal 1 soal harus diisi.',
        'blind_test_items.*.deffect_item_id.required' => 'Deffect item wajib diisi.',
        'blind_test_items.*.component_location.required' => 'Component location wajib diisi.',
        'time_test.required' => 'Time test wajib diisi.',
        'duration_minutes.integer' => 'Durasi harus berupa angka.',
        'duration_minutes.min' => 'Durasi minimal 1 menit.',
        'duration_minutes.max' => 'Durasi maksimal 600 menit.',
    ];

    // ==================== WATCHERS ====================
    public function updatedSearch()           { $this->resetPage(); }
    public function updatedFilterDepartment() { $this->resetPage(); }
    public function updatedFilterShift()      { $this->resetPage(); }
    public function updatedFilterGroup()      { $this->resetPage(); }
    public function updatedFilterCustomer()   { $this->resetPage(); $this->filterModel = ''; }
    public function updatedFilterModel()      { $this->resetPage(); }
    public function updatedFilterResult()     { $this->resetPage(); }
    public function updatedCustomerId()       { $this->model_id = ''; }

    // ==================== TAB & FILTER ====================
    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset([
            'search', 'filterDepartment', 'filterShift', 'filterGroup',
            'filterCustomer', 'filterModel', 'filterResult',
        ]);
        $this->resetPage();
    }

    // ==================== FORM ACTIONS ====================
    public function resetForm()
    {
        $this->reset([
            'blind_test_id', 'employee_id', 'employee_nik', 'employee_name',
            'employee_department', 'shift', 'group', 'customer_id', 'model_id',
            'time_test', 'duration_minutes',
            'check_by_qc', 'check_by_prod', 'acknowledge_by_spv',
            'acknowledge_qc_spv', 'employeeSearch',
        ]);
        $this->blind_test_items = [
            ['deffect_item_id' => '', 'component_location' => ''],
        ];
        $this->modalTitle = 'Add New Blind Test';
        $this->resetValidation();
    }

    public function addItem()
    {
        $this->blind_test_items[] = ['deffect_item_id' => '', 'component_location' => ''];
    }

    public function removeItem($index)
    {
        unset($this->blind_test_items[$index]);
        $this->blind_test_items = array_values($this->blind_test_items);
    }

    public function save()
    {
        $isEdit = (bool) $this->blind_test_id;

        if ($isEdit) {
            if (!auth()->user()->can('edit blind test')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create blind test')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $model = QaqcModel::where('id', $this->model_id)
            ->where('customer_id', $this->customer_id)->first();
        if (!$model) {
            $this->addError('model_id', 'Model tidak sesuai dengan customer yang dipilih.');
            return;
        }

        $items = [];
        foreach ($this->blind_test_items as $item) {
            $items[] = [
                'deffect_item_id'    => (int) $item['deffect_item_id'],
                'component_location' => strtoupper(trim($item['component_location'])),
            ];
        }

        $data = [
            'employee_id'       => $this->employee_id,
            'shift'             => strtoupper($this->shift),
            'group'             => $this->group ? strtoupper($this->group) : null,
            'customer_id'       => $this->customer_id,
            'model_id'          => $this->model_id,
            'blind_test_items'  => $items,
            'time_test'         => $this->time_test,
            'duration_minutes'  => $this->duration_minutes !== '' ? (int) $this->duration_minutes : null,
            'updated_by'        => auth()->id(),
        ];

        if ($isEdit) {
            $bt = BlindTest::find($this->blind_test_id);
            if (!$bt) {
                $this->dispatch('notify', message: 'Blind test not found!', type: 'error');
                return;
            }

            // Guard: hanya boleh edit kalau masih pending
            if ($bt->status !== 'pending') {
                $this->dispatch('notify', message: 'Test sudah dimulai/selesai, tidak bisa diedit!', type: 'error');
                return;
            }

            $bt->update($data);
            $message = 'Blind test updated successfully!';
        } else {
            $data['status'] = 'pending';
            $data['created_by'] = auth()->id();
            BlindTest::create($data);
            $message = 'Blind test created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal-blind-test');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit blind test')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $bt = BlindTest::with('employee')->find($id);
        if (!$bt) {
            $this->dispatch('notify', message: 'Blind test not found!', type: 'error');
            return;
        }

        // Guard: hanya boleh edit kalau masih pending
        if ($bt->status !== 'pending') {
            $this->dispatch('notify', message: 'Test sudah dimulai/selesai, tidak bisa diedit!', type: 'error');
            return;
        }

        $this->blind_test_id        = $bt->id;
        $this->employee_id          = $bt->employee_id;
        $this->employee_nik         = $bt->employee->nik ?? '';
        $this->employee_name        = $bt->employee->name ?? '';
        $this->employee_department  = $bt->employee->department ?? '';
        $this->shift                = $bt->shift;
        $this->group                = $bt->group;
        $this->customer_id          = $bt->customer_id;
        $this->model_id             = $bt->model_id;
        $this->blind_test_items     = $bt->blind_test_items ?? [];
        $this->time_test            = $bt->time_test ? $bt->time_test->format('H:i') : '';
        $this->duration_minutes     = $bt->duration_minutes ?? '';
        $this->check_by_qc          = $bt->check_by_qc;
        $this->check_by_prod        = $bt->check_by_prod;
        $this->acknowledge_by_spv   = $bt->acknowledge_by_spv;
        $this->acknowledge_qc_spv   = $bt->acknowledge_qc_spv;
        $this->modalTitle           = 'Edit Blind Test';

        $this->dispatch('open-modal-blind-test');
    }

    public function view($id)
    {
        $bt = BlindTest::withTrashed()->with([
            'employee', 'customer', 'model',
            'checkerQc', 'checkerProd', 'acknowledgerSpv', 'acknowledgerQcSpv',
        ])->find($id);

        if (!$bt) {
            $this->dispatch('notify', message: 'Blind test not found!', type: 'error');
            return;
        }

        $this->viewData = $bt;
        $this->dispatch('open-modal-view');
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete blind test')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $bt = BlindTest::find($id);
        if (!$bt) {
            $this->dispatch('notify', message: 'Blind test not found!', type: 'error');
            return;
        }

        // Guard: hanya boleh delete kalau masih pending
        if ($bt->status !== 'pending') {
            $this->dispatch('notify', message: 'Test sudah dimulai/selesai, tidak bisa dihapus!', type: 'error');
            return;
        }

        $this->blindTestToDelete = $bt;
        $this->deleteReason = '';
        $this->dispatch('open-modal-delete');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete blind test')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        if (empty($this->deleteReason)) {
            $this->dispatch('notify', message: 'Alasan hapus wajib diisi!', type: 'error');
            return;
        }

        $bt = BlindTest::find($this->blindTestToDelete->id);
        if (!$bt) {
            $this->dispatch('notify', message: 'Blind test not found!', type: 'error');
            $this->blindTestToDelete = null;
            return;
        }

        // Double guard
        if ($bt->status !== 'pending') {
            $this->dispatch('notify', message: 'Test sudah dimulai/selesai, tidak bisa dihapus!', type: 'error');
            $this->blindTestToDelete = null;
            $this->deleteReason = '';
            $this->dispatch('close-modal-delete');
            return;
        }

        $bt->deleted_by = auth()->id();
        $bt->deleted_reason = $this->deleteReason;
        $bt->save();
        $bt->delete();

        $this->blindTestToDelete = null;
        $this->deleteReason = '';
        $this->dispatch('notify', message: 'Blind test deleted successfully!');
        $this->dispatch('close-modal-delete');
    }

    public function cancelDelete()
    {
        $this->blindTestToDelete = null;
        $this->deleteReason = '';
        $this->dispatch('close-modal-delete');
    }

    // ==================== APPROVAL ====================
    public function openApprovalModal($id, $type)
    {
        $this->approvalBlindTestId = $id;
        $this->approvalType = $type;
        $this->approvalRemark = '';
        $this->dispatch('open-modal-approval');
    }

    public function approve()
    {
        if (!$this->approvalBlindTestId || !$this->approvalType) return;

        $bt = BlindTest::find($this->approvalBlindTestId);
        if (!$bt) {
            $this->dispatch('notify', message: 'Blind test not found!', type: 'error');
            return;
        }

        $userId = auth()->id();
        $now = now();
        $label = '';

        switch ($this->approvalType) {
            case 'qc':
                if (!auth()->user()->can('check blind test qc')) {
                    $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                    return;
                }
                $bt->check_by_qc = $userId;
                $bt->check_by_qc_at = $now;
                $label = 'Check By QC';
                break;

            case 'prod':
                if (!auth()->user()->can('check blind test prod')) {
                    $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                    return;
                }
                $bt->check_by_prod = $userId;
                $bt->check_by_prod_at = $now;
                $label = 'Check By Prod';
                break;

            case 'spv':
                if (!auth()->user()->can('acknowledge blind test spv')) {
                    $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                    return;
                }
                $bt->acknowledge_by_spv = $userId;
                $bt->acknowledge_by_spv_at = $now;
                $label = 'Acknowledge By SPV';
                break;

            case 'qc_spv':
                if (!auth()->user()->can('acknowledge blind test qc spv')) {
                    $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                    return;
                }
                $bt->acknowledge_qc_spv = $userId;
                $bt->acknowledge_qc_spv_at = $now;
                $label = 'Acknowledge QC SPV';
                break;

            default:
                return;
        }

        $bt->updated_by = $userId;
        $bt->save();

        $this->dispatch('notify', message: "{$label} approved successfully!", type: 'success');
        $this->dispatch('close-modal-approval');

        $this->approvalType = null;
        $this->approvalRemark = '';
        $this->approvalBlindTestId = null;

        if ($this->blind_test_id) {
            $bt->refresh();
            $this->check_by_qc = $bt->check_by_qc;
            $this->check_by_prod = $bt->check_by_prod;
            $this->acknowledge_by_spv = $bt->acknowledge_by_spv;
            $this->acknowledge_qc_spv = $bt->acknowledge_qc_spv;
        }
    }

    // ==================== EMPLOYEE SEARCH ====================
    public function searchEmployees($search)
    {
        if (strlen($search) < 2) return [];

        return Employee::where(function ($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            })
            ->whereIn('status', [1, 2, 3])
            ->limit(20)
            ->get()
            ->map(fn ($e) => [
                'id' => $e->id,
                'nik' => $e->nik ?? '-',
                'name' => $e->name ?? '-',
                'department' => $e->department ?? '-',
                'label' => ($e->nik ?? '') . ' - ' . ($e->name ?? '') . ' (' . ($e->department ?? '') . ')',
            ]);
    }

    public function selectEmployee($id)
    {
        $e = Employee::where('id', $id)->whereIn('status', [1, 2, 3])->first();
        if (!$e) {
            $this->dispatch('notify', message: 'Invalid employee selection!', type: 'error');
            return;
        }

        $this->employee_id = $e->id;
        $this->employee_nik = $e->nik;
        $this->employee_name = $e->name;
        $this->employee_department = $e->department;
        $this->employeeSearch = '';
        $this->showEmployeeDropdown = false;
        $this->resetErrorBag('employee_id');
    }

    public function clearEmployee()
    {
        $this->employee_id = '';
        $this->employee_nik = '';
        $this->employee_name = '';
        $this->employee_department = '';
        $this->resetValidation();
    }

    // ==================== RENDER ====================
    public function render()
    {
        if (!auth()->user()->can('view blind test')) {
            abort(403, 'Unauthorized access.');
        }

        // Hitung tab counts
        $this->tabCounts = [
            'all'         => BlindTest::count(),
            'open'        => BlindTest::where('status', 'pending')->count(),
            'in_progress' => BlindTest::where('status', 'in_progress')->count(),
            'closed'      => BlindTest::where('status', 'completed')->count(),
            'rejected'    => BlindTest::where('overall_result', 'FAIL')->count(),
            'deleted'     => BlindTest::onlyTrashed()->count(),
        ];

        // Query utama
        $query = BlindTest::with(['employee', 'customer', 'model', 'creator']);

        // Tab logic
        switch ($this->activeTab) {
            case 'open':
                $query->where('status', 'pending');
                break;
            case 'in_progress':
                $query->where('status', 'in_progress');
                break;
            case 'closed':
                $query->where('status', 'completed');
                break;
            case 'rejected':
                $query->where('overall_result', 'FAIL');
                break;
            case 'deleted':
                $query->onlyTrashed();
                break;
            case 'all':
            default:
                // tampilkan semua non-deleted
                break;
        }

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('employee', fn ($eq) => $eq->where('nik', 'like', '%'.$this->search.'%')
                            ->orWhere('name', 'like', '%'.$this->search.'%'))
                    ->orWhereHas('customer', fn ($cq) => $cq->where('customer_name', 'like', '%'.$this->search.'%'))
                    ->orWhereHas('model', fn ($mq) => $mq->where('model_name', 'like', '%'.$this->search.'%'));
            });
        }

        // Filters
        if ($this->filterDepartment) {
            $query->whereHas('employee', fn ($q) => $q->where('department', $this->filterDepartment));
        }
        if ($this->filterShift) {
            $query->where('shift', $this->filterShift);
        }
        if ($this->filterGroup) {
            $query->where('group', $this->filterGroup);
        }
        if ($this->filterCustomer) {
            $query->where('customer_id', $this->filterCustomer);
        }
        if ($this->filterModel) {
            $query->where('model_id', $this->filterModel);
        }
        if ($this->filterResult) {
            $query->where('overall_result', $this->filterResult);
        }

        $blindTests = $query->orderByDesc('id')->paginate(10);

        // Data dropdown filter
        $departments = Employee::query()
            ->whereIn('status', [1, 2, 3])          // ← filter status
            ->whereNotNull('department')
            ->where('department', '!=', '')
            ->distinct()
            ->orderBy('department')
            ->pluck('department');

        $shifts = ['NS', '1', '2', '3'];
        $groups = ['NS', 'A', 'B', 'C'];

        return view('livewire.qaqc.blind-test.blind-test-management', [
            'blindTests'  => $blindTests,
            'customers'   => Customer::orderBy('customer_name')->get(),
            'deffects'    => Deffect::orderBy('deffect_item_name')->get(),
            'allModels'   => QaqcModel::with('customer')->orderBy('model_name')->get(),
            'users'       => User::select('id', 'name')->orderBy('name')->get(),
            'departments' => $departments,
            'shifts'      => $shifts,
            'groups'      => $groups,
        ]);
    }
}