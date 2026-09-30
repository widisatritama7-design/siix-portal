<?php

namespace App\Livewire\QAQC\BlindTest;

use App\Models\HR\Employee;
use App\Models\QAQC\BlindTest\BlindTest;
use App\Models\QAQC\BlindTest\Customer;
use App\Models\QAQC\BlindTest\Model as QaqcModel;
use App\Models\QAQC\BlindTest\Question;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class BlindTestManagement extends Component
{
    use WithPagination;

    public const DEFAULT_DURATION_MINUTES = 5;

    // ==================== FORM PROPERTIES ====================
    public $blind_test_id;
    public $section = '';
    public $customer_id = '';
    public $model_id = '';
    public $question_ids = [];      // array soal (biasanya cuma 1 dari bank soal)

    // Multi employee picker
    public $selectedEmployees = [];
    public $employeeSearch = '';
    public $tempShift = '';
    public $tempGroup = '';

    // Timing (fixed 5 menit)
    public $duration_minutes = 5;

    // ==================== APPROVAL ====================
    public $approvalType = null;
    public $approvalRemark = '';
    public $approvalBlindTestId = null;

    // ==================== SEARCH & FILTER ====================
    public $search = '';
    public $bankMonth = '';   // '' = bulan ini, format 'YYYY-MM'
    public $filterDepartment = '';
    public $filterShift = '';
    public $filterGroup = '';
    public $filterSection = '';
    public $filterCustomer = '';
    public $filterModel = '';
    public $filterResult = '';
    public $filterDateFrom = '';
    public $filterDateTo   = '';

    // ==================== CALENDAR (by date) ====================
    public $calendarMonth = '';      // 'YYYY-MM', default = bulan ini
    public $selectedDate = '';       // 'YYYY-MM-DD', default = hari ini

    // ==================== TABS ====================
    public $activeTab = 'all';
    public $tabCounts = [
        'all' => 0, 'open' => 0, 'in_progress' => 0,
        'closed' => 0, 'rejected' => 0, 'deleted' => 0,
    ];

    // ==================== MODAL STATE ====================
    public $modalTitle = 'Create Blind Test';
    public $blindTestToDelete = null;
    public $deleteReason = '';
    public $viewData = null;

    public const SECTIONS = ['QC', 'SMT', 'BE', 'MI'];

    // ==================== VALIDATION ====================
    protected function rules()
    {
        return [
            'section'           => 'required|in:QC,SMT,BE,MI',
            'customer_id'       => 'required|exists:tb_qaqc_customer,id',
            'question_ids'      => 'required|array|min:1',
            'question_ids.*'    => 'exists:tb_qaqc_question,id',
            'selectedEmployees' => 'required|array|min:1',
            'selectedEmployees.*.id'    => 'required|exists:tb_hr_employee,id',
            'selectedEmployees.*.shift' => 'required|string|max:50',
            'selectedEmployees.*.group' => 'nullable|string|max:50',
        ];
    }

    protected $messages = [
        'section.required'           => 'Section is required.',
        'customer_id.required'       => 'Customer is required.',
        'question_ids.required'      => 'Question wajib dipilih.',
        'question_ids.min'           => 'Question wajib dipilih.',
        'selectedEmployees.required' => 'Minimal 1 employee harus dipilih.',
        'selectedEmployees.min'      => 'Minimal 1 employee harus dipilih.',
    ];

    // ==================== WATCHERS ====================
    public function updatedSearch()           { $this->resetPage(); }
    public function updatedFilterDepartment() { $this->resetPage(); }
    public function updatedFilterShift()      { $this->resetPage(); }
    public function updatedFilterGroup()      { $this->resetPage(); }
    public function updatedFilterSection()    { $this->resetPage(); }
    public function updatedFilterCustomer()   { $this->resetPage(); $this->filterModel = ''; }
    public function updatedFilterModel()      { $this->resetPage(); }
    public function updatedFilterResult()     { $this->resetPage(); }
    public function updatedFilterDateFrom()   { $this->resetPage(); }
    public function updatedFilterDateTo()     { $this->resetPage(); }
    public function updatedBankMonth()
    {
        // Tidak perlu resetPage karena bank soal tidak paginated
    }

    public function mount()
    {
        $this->calendarMonth = now()->format('Y-m');
        $this->selectedDate  = now()->format('Y-m-d');   // default = hari ini
    }

    public function updatedCalendarMonth()
    {
        // Kalau ganti bulan, reset pilihan tanggal ke tanggal 1 bulan itu
        if ($this->calendarMonth) {
            $this->selectedDate = \Carbon\Carbon::createFromFormat('Y-m', $this->calendarMonth)
                ->startOfMonth()->format('Y-m-d');
        }
        $this->resetPage();
    }

    public function selectDate($date)
    {
        // Klik tanggal → filter tabel, klik ulang → clear
        if ($this->selectedDate === $date) {
            $this->selectedDate = '';
        } else {
            $this->selectedDate = $date;
        }
        $this->resetPage();
    }

    public function goToToday()
    {
        $this->calendarMonth = now()->format('Y-m');
        $this->selectedDate  = now()->format('Y-m-d');
        $this->resetPage();
    }

    public function clearDate()
    {
        $this->selectedDate = '';
        $this->resetPage();
    }

    public function prevMonth()
    {
        $d = $this->calendarMonth
            ? \Carbon\Carbon::createFromFormat('Y-m', $this->calendarMonth)
            : now();

        $this->calendarMonth = $d->copy()->subMonth()->format('Y-m');

        if ($this->selectedDate) {
            $this->selectedDate = \Carbon\Carbon::createFromFormat('Y-m', $this->calendarMonth)
                ->startOfMonth()->format('Y-m-d');
        }
        $this->resetPage();
    }

    public function nextMonth()
    {
        $d = $this->calendarMonth
            ? \Carbon\Carbon::createFromFormat('Y-m', $this->calendarMonth)
            : now();

        $this->calendarMonth = $d->copy()->addMonth()->format('Y-m');

        if ($this->selectedDate) {
            $this->selectedDate = \Carbon\Carbon::createFromFormat('Y-m', $this->calendarMonth)
                ->startOfMonth()->format('Y-m-d');
        }
        $this->resetPage();
    }

    // ==================== TAB & FILTER ====================
    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset([
            'search', 'filterDepartment', 'filterShift', 'filterGroup', 'filterSection',
            'filterCustomer', 'filterModel', 'filterResult',
            'filterDateFrom', 'filterDateTo',
        ]);
        $this->resetPage();
    }

    // ==================== FORM ACTIONS ====================
    public function resetForm()
    {
        $this->reset([
            'blind_test_id', 'section', 'customer_id', 'model_id', 'question_ids',
            'selectedEmployees', 'employeeSearch', 'tempShift', 'tempGroup',
        ]);
        $this->duration_minutes = self::DEFAULT_DURATION_MINUTES;
        $this->modalTitle = 'Create Blind Test';
        $this->resetValidation();
    }

    /**
     * Dipanggil dari halaman utama saat user klik 1 soal di bank soal.
     * Auto-set section, customer, model dari soal, durasi fixed 5 menit.
     */
    public function openCreateModal($questionId)
    {
        $this->resetForm();

        $question = Question::with('model')->find($questionId);
        if (!$question) {
            $this->dispatch('notify', message: 'Question tidak ditemukan!', type: 'error');
            return;
        }

        $this->section          = $question->section;
        $this->customer_id      = $question->customer_id;
        $this->model_id         = $question->model_id;
        $this->question_ids     = [$question->id];
        $this->duration_minutes = self::DEFAULT_DURATION_MINUTES;

        $this->modalTitle = 'Create Blind Test';
        $this->dispatch('open-modal-blind-test');
    }

    // ==================== EMPLOYEE MULTI PICKER ====================

    public function getSelectedEmployeeIds(): array
    {
        return collect($this->selectedEmployees)
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->toArray();
    }

    public function addEmployee($id)
    {
        $e = Employee::where('id', $id)->whereIn('status', [1, 2, 3])->first();
        if (!$e) {
            $this->dispatch('notify', message: 'Invalid employee!', type: 'error');
            return;
        }

        $selectedIds = $this->getSelectedEmployeeIds();
        if (in_array((int) $e->id, $selectedIds, true)) {
            $this->dispatch('notify', message: 'Employee sudah ada di daftar!', type: 'warning');
            return;
        }

        $allowedDepartments = match ($this->section) {
            'QC'  => ['IQC', 'QA/QC'],
            'SMT' => ['PROD.1'],
            'MI'  => ['PROD.1'],
            'BE'  => ['PROD.2'],
            default => [],
        };

        if (!in_array($e->department, $allowedDepartments, true)) {
            $this->dispatch(
                'notify',
                message: "Employee department ({$e->department}) tidak sesuai untuk section {$this->section}!",
                type: 'error'
            );
            return;
        }

        if (empty($this->tempShift)) {
            $this->dispatch('notify', message: 'Shift wajib dipilih!', type: 'error');
            return;
        }
        if (empty($this->tempGroup)) {
            $this->dispatch('notify', message: 'Group wajib dipilih!', type: 'error');
            return;
        }

        $this->selectedEmployees[] = [
            'id'         => $e->id,
            'nik'        => $e->nik,
            'name'       => $e->name,
            'department' => $e->department,
            'shift'      => strtoupper($this->tempShift),
            'group'      => strtoupper($this->tempGroup),
        ];

        $this->employeeSearch = '';
        $this->tempShift = '';
        $this->tempGroup = '';

        $this->dispatch('employee-added');
    }

    public function removeEmployee($index)
    {
        unset($this->selectedEmployees[$index]);
        $this->selectedEmployees = array_values($this->selectedEmployees);
    }

    /* ================= HELPER: MODEL ID ================= */

    /**
     * Resolve model_id untuk kolom `model_id` di blind_test.
     * - Kalau cuma 1 model → pakai model itu
     * - Kalau lebih dari 1 model → return null (multi-model disimpan di snapshot)
     */
    protected function resolveModelId($questions): ?int
    {
        $modelIds = collect();

        foreach ($questions as $q) {
            $items = $q->items ?? [];

            // Format baru: group per model
            if (!empty($items) && isset($items[0]['model_id'])) {
                foreach ($items as $group) {
                    if (!empty($group['model_id'])) {
                        $modelIds->push((int) $group['model_id']);
                    }
                }
            } else {
                // Format lama: flat, model dari kolom model_id
                if ($q->model_id) {
                    $modelIds->push((int) $q->model_id);
                }
            }
        }

        $unique = $modelIds->unique()->values();

        // Cuma 1 model → simpan
        if ($unique->count() === 1) {
            return $unique->first();
        }

        // Multi model → null
        return null;
    }

    /**
     * Ambil semua defect dari question (support format lama & baru).
     */
    protected function extractDefects($question): array
    {
        $raw = $question->items ?? [];
        $all = [];

        if (!empty($raw) && isset($raw[0]['model_id'])) {
            // Format baru: group per model
            foreach ($raw as $group) {
                foreach ($group['items'] ?? [] as $it) {
                    $all[] = $it;
                }
            }
        } else {
            // Format lama: flat
            foreach ($raw as $it) {
                $all[] = $it;
            }
        }

        return $all;
    }

    /* ================= SAVE ================= */

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

        // Paksa durasi 5 menit
        $this->duration_minutes = self::DEFAULT_DURATION_MINUTES;

        $this->validate();

        if (empty($this->question_ids)) {
            $this->addError('question_ids', 'Question wajib dipilih.');
            return;
        }

        $questions = Question::whereIn('id', $this->question_ids)
            ->where('section', $this->section)
            ->where('customer_id', $this->customer_id)
            ->get();

        if ($questions->count() !== count($this->question_ids)) {
            $this->addError('question_ids', 'Ada soal yang tidak sesuai dengan section/customer.');
            return;
        }

        // Kumpulkan defect
        $allItems = collect();
        foreach ($questions as $q) {
            foreach ($this->extractDefects($q) as $item) {
                $allItems->push($item);
            }
        }

        $blindTestItems = $allItems
            ->map(fn ($i) => [
                'deffect_item_id'    => (int) ($i['deffect_id'] ?? $i['deffect_item_id'] ?? 0),
                'deffect_name'       => $i['deffect_name'] ?? null,
                'component_location' => strtoupper(trim((string) ($i['location'] ?? $i['component_location'] ?? ''))),
            ])
            ->values()
            ->toArray();

        $questionSnapshot = $questions->map(fn($q) => [
            'id'       => $q->id,
            'text'     => $q->question_text,
            'model_id' => $q->model_id,
            'items'    => $q->items,
        ])->values()->toArray();

        $firstQuestionId = $questions->first()->id;
        $resolvedModelId = $this->resolveModelId($questions);

        // ========== EDIT MODE ==========
        if ($isEdit) {
            $bt = BlindTest::find($this->blind_test_id);
            if (!$bt || $bt->status !== 'pending') {
                $this->dispatch('notify', message: 'Test tidak bisa diedit!', type: 'error');
                return;
            }

            $emp = $this->selectedEmployees[0] ?? null;
            if (!$emp) {
                $this->addError('selectedEmployees', 'Employee tidak boleh kosong.');
                return;
            }

            $bt->update([
                'employee_id'       => $emp['id'],
                'shift'             => strtoupper($emp['shift'] ?? ''),
                'group'             => $emp['group'] ? strtoupper($emp['group']) : null,
                'section'           => $this->section,
                'customer_id'       => $this->customer_id,
                'model_id'          => $resolvedModelId,
                'question_id'       => $firstQuestionId,
                'question_ids'      => $this->question_ids,
                'question_snapshot' => $questionSnapshot,
                'blind_test_items'  => $blindTestItems,
                'duration_minutes'  => self::DEFAULT_DURATION_MINUTES,
                'updated_by'        => auth()->id(),
            ]);

            $this->resetForm();
            $this->dispatch('notify', message: 'Blind test updated successfully!');
            $this->dispatch('close-modal-blind-test');
            return;
        }

        // ========== CREATE MODE ==========
        $count = 0;

        foreach ($this->selectedEmployees as $emp) {
            BlindTest::create([
                'employee_id'       => $emp['id'],
                'shift'             => strtoupper($emp['shift'] ?? ''),
                'group'             => $emp['group'] ? strtoupper($emp['group']) : null,
                'section'           => $this->section,
                'customer_id'       => $this->customer_id,
                'model_id'          => $resolvedModelId,
                'question_id'       => $firstQuestionId,
                'question_ids'      => $this->question_ids,
                'question_snapshot' => $questionSnapshot,
                'blind_test_items'  => $blindTestItems,
                'duration_minutes'  => self::DEFAULT_DURATION_MINUTES,
                'time_test'         => null,
                'status'            => 'pending',
                'created_by'        => auth()->id(),
                'updated_by'        => auth()->id(),
            ]);
            $count++;
        }

        $this->resetForm();
        $this->dispatch('notify', message: "{$count} blind test berhasil dibuat! (durasi 5 menit)");
        $this->dispatch('close-modal-blind-test');
    }

    /* ================= EDIT ================= */

    public function edit($id)
    {
        if (!auth()->user()->can('edit blind test')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $bt = BlindTest::with('employee')->find($id);
        if (!$bt || $bt->status !== 'pending') {
            $this->dispatch('notify', message: 'Test tidak bisa diedit!', type: 'error');
            return;
        }

        $this->blind_test_id    = $bt->id;
        $this->section          = $bt->section;
        $this->customer_id      = $bt->customer_id;
        $this->model_id         = $bt->model_id;
        $this->duration_minutes = self::DEFAULT_DURATION_MINUTES;

        $this->question_ids = is_array($bt->question_ids)
            ? $bt->question_ids
            : ($bt->question_id ? [$bt->question_id] : []);

        $this->selectedEmployees = [[
            'id'         => $bt->employee->id,
            'nik'        => $bt->employee->nik,
            'name'       => $bt->employee->name,
            'department' => $bt->employee->department,
            'shift'      => $bt->shift,
            'group'      => $bt->group,
        ]];
        $this->modalTitle = 'Edit Blind Test';
        $this->dispatch('open-modal-blind-test');
    }

    /* ================= VIEW ================= */

    public function view($id)
    {
        $bt = BlindTest::withTrashed()->with([
            'employee', 'customer', 'model', 'question',
            'checkerQc', 'checkerProd', 'acknowledgerSpv', 'acknowledgerQcSpv',
        ])->find($id);

        if (!$bt) {
            $this->dispatch('notify', message: 'Blind test not found!', type: 'error');
            return;
        }

        $this->viewData = $bt;
        $this->dispatch('open-modal-view');
    }

    /* ================= DELETE ================= */

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete blind test')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $bt = BlindTest::find($id);
        if (!$bt || $bt->status !== 'pending') {
            $this->dispatch('notify', message: 'Test tidak bisa dihapus!', type: 'error');
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
        if (!$bt || $bt->status !== 'pending') {
            $this->dispatch('notify', message: 'Test tidak bisa dihapus!', type: 'error');
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

    /* ================= APPROVAL ================= */

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
    }

    /* ================= EMPLOYEE SEARCH ================= */

    public function searchEmployees($search)
    {
        if (strlen($search) < 2) return [];
        if (empty($this->section)) return [];

        $allowedDepartments = match ($this->section) {
            'QC'  => ['IQC', 'QA/QC'],
            'SMT' => ['PROD.1'],
            'MI'  => ['PROD.1'],
            'BE'  => ['PROD.2'],
            default => [],
        };

        if (empty($allowedDepartments)) return [];

        $selectedIds = $this->getSelectedEmployeeIds();

        return Employee::where(function ($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            })
            ->whereIn('status', [1, 2, 3])
            ->whereIn('department', $allowedDepartments)
            ->limit(20)
            ->get()
            ->map(fn ($e) => [
                'id'               => $e->id,
                'nik'              => $e->nik ?? '-',
                'name'             => $e->name ?? '-',
                'department'       => $e->department ?? '-',
                'already_selected' => in_array((int) $e->id, $selectedIds, true),
            ]);
    }

    /* ================= RENDER ================= */

    public function render()
    {
        if (!auth()->user()->can('view blind test')) {
            abort(403, 'Unauthorized access.');
        }

        $this->tabCounts = [
            'all'         => BlindTest::count(),
            'open'        => BlindTest::where('status', 'pending')->count(),
            'in_progress' => BlindTest::where('status', 'in_progress')->count(),
            'closed'      => BlindTest::where('status', 'completed')->count(),
            'rejected'    => BlindTest::where('overall_result', 'FAIL')->count(),
            'deleted'     => BlindTest::onlyTrashed()->count(),
        ];

        $query = BlindTest::with(['employee', 'customer', 'model', 'question', 'creator']);

        switch ($this->activeTab) {
            case 'open':        $query->where('status', 'pending'); break;
            case 'in_progress': $query->where('status', 'in_progress'); break;
            case 'closed':      $query->where('status', 'completed'); break;
            case 'rejected':    $query->where('overall_result', 'FAIL'); break;
            case 'deleted':     $query->onlyTrashed(); break;
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('employee', fn ($eq) => $eq->where('nik', 'like', '%'.$this->search.'%')
                            ->orWhere('name', 'like', '%'.$this->search.'%'))
                    ->orWhereHas('customer', fn ($cq) => $cq->where('customer_name', 'like', '%'.$this->search.'%'))
                    ->orWhereHas('model', fn ($mq) => $mq->where('model_name', 'like', '%'.$this->search.'%'));
            });
        }

        if ($this->filterDepartment) $query->whereHas('employee', fn ($q) => $q->where('department', $this->filterDepartment));
        if ($this->filterShift)      $query->where('shift', $this->filterShift);
        if ($this->filterGroup)      $query->where('group', $this->filterGroup);
        if ($this->filterSection)    $query->where('section', $this->filterSection);
        if ($this->filterCustomer)   $query->where('customer_id', $this->filterCustomer);
        if ($this->filterModel) {
            $query->where(function ($q) {
                $q->where('model_id', $this->filterModel)
                ->orWhere('question_snapshot', 'like', '%"model_id":' . (int) $this->filterModel . '%');
            });
        };
        if ($this->filterResult)     $query->where('overall_result', $this->filterResult);

        if ($this->filterDateFrom) $query->whereDate('created_at', '>=', $this->filterDateFrom);
        if ($this->filterDateTo)   $query->whereDate('created_at', '<=', $this->filterDateTo);

        // Filter by selectedDate dari calendar
        if ($this->selectedDate) {
            $query->whereDate('created_at', $this->selectedDate);
        }

        $blindTests = $query->orderByDesc('id')->paginate(10);

        $departments = Employee::query()
            ->whereIn('status', [1, 2, 3])
            ->whereNotNull('department')
            ->where('department', '!=', '')
            ->distinct()
            ->orderBy('department')
            ->pluck('department');

        $filterModels = $this->filterCustomer
            ? QaqcModel::where('customer_id', $this->filterCustomer)->orderBy('model_name')->get()
            : collect();

        // ============ BANK SOAL PER SECTION (by month) ============
        $bankDate = $this->bankMonth
            ? \Carbon\Carbon::createFromFormat('Y-m', $this->bankMonth)
            : now();

        $startOfMonth = $bankDate->copy()->startOfMonth()->startOfDay();
        $endOfMonth   = $bankDate->copy()->endOfMonth()->endOfDay();

        $questionBank = [];
        foreach (self::SECTIONS as $sec) {
            $questionBank[$sec] = Question::with(['customer', 'model', 'models'])
                ->where('section', $sec)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->orderByDesc('id')
                ->get();
        }

        // Soal terpilih (untuk ditampilkan di modal)
        $selectedQuestion = !empty($this->question_ids)
            ? Question::with(['customer', 'model'])->find($this->question_ids[0])
            : null;

        // ============ CALENDAR DATA ============
        $calMonth = $this->calendarMonth
            ? \Carbon\Carbon::createFromFormat('Y-m', $this->calendarMonth)
            : now();

        $calStart = $calMonth->copy()->startOfMonth()->startOfDay();
        $calEnd   = $calMonth->copy()->endOfMonth()->endOfDay();

        // Hitung jumlah blind test per tanggal
        $dailyCounts = BlindTest::whereBetween('created_at', [$calStart, $calEnd])
            ->selectRaw('DATE(created_at) as d, COUNT(*) as total')
            ->groupBy('d')
            ->pluck('total', 'd')
            ->toArray();

        return view('livewire.qaqc.blind-test.blind-test-management', [
            'blindTests'        => $blindTests,
            'customers'         => Customer::orderBy('customer_name')->get(),
            'allModels'         => QaqcModel::with('customer')->orderBy('model_name')->get(),
            'filterModels'      => $filterModels,
            'users'             => User::select('id', 'name')->orderBy('name')->get(),
            'departments'       => $departments,
            'shifts'            => ['NS', '1', '2', '3'],
            'groups'            => ['NS', 'A', 'B', 'C'],
            'sections'          => self::SECTIONS,
            'questionBank'      => $questionBank,
            'selectedQuestion'  => $selectedQuestion,
            'bankDate'          => $bankDate,   // ← TAMBAH INI
            'calMonth'     => $calMonth,
            'dailyCounts'  => $dailyCounts,
        ]);
    }
}