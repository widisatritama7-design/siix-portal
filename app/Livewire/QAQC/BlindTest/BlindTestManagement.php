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

    // ==================== BANK SOAL PAGINATION ====================
    public $questionPage = 1;
    public $questionPerPage = 5;
    public $searchQuestion = '';

    // ==================== FORM PROPERTIES ====================
    public $blind_test_id;
    public $section = '';
    public $customer_id = '';
    public $model_id = '';          // optional filter
    public $question_ids = [];      // array soal

    // Multi employee picker
    public $selectedEmployees = [];
    public $employeeSearch = '';
    public $tempShift = '';
    public $tempGroup = '';

    // Timing
    public $duration_minutes = '';

    // ==================== APPROVAL ====================
    public $approvalType = null;
    public $approvalRemark = '';
    public $approvalBlindTestId = null;

    // ==================== SEARCH & FILTER ====================
    public $search = '';
    public $filterDepartment = '';
    public $filterShift = '';
    public $filterGroup = '';
    public $filterSection = '';
    public $filterCustomer = '';
    public $filterModel = '';
    public $filterResult = '';

    // ==================== TABS ====================
    public $activeTab = 'all';
    public $tabCounts = [
        'all' => 0, 'open' => 0, 'in_progress' => 0,
        'closed' => 0, 'rejected' => 0, 'deleted' => 0,
    ];

    // ==================== MODAL STATE ====================
    public $modalTitle = 'Add New Blind Test';
    public $blindTestToDelete = null;
    public $deleteReason = '';
    public $viewData = null;

    public const SECTIONS = ['QC', 'SMT', 'BE', 'MI'];

    /* ================= BANK SOAL PAGINATION ================= */

    public function setQuestionPage($page)
    {
        $this->questionPage = $page;
    }

    public function updatedSearchQuestion()
    {
        $this->questionPage = 1;
    }

    /**
     * Toggle pilih/hapus soal. Validasi total item tidak boleh > 5.
     */
    public function toggleQuestion($id)
    {
        $question = Question::find($id);
        if (!$question) {
            $this->dispatch('notify', message: 'Question tidak ditemukan!', type: 'error');
            return;
        }

        $itemCount = count($question->items ?? []);

        // Kalau sudah dipilih → hapus (toggle off)
        if (in_array($id, $this->question_ids)) {
            $this->question_ids = array_values(array_diff($this->question_ids, [$id]));
            return;
        }

        // Hitung total kalau soal ini ditambahkan
        $currentTotal = $this->getTotalSelectedItems();
        $newTotal = $currentTotal + $itemCount;

        if ($newTotal > 5) {
            $this->dispatch(
                'notify',
                message: "Total defect tidak boleh lebih dari 5. Saat ini: {$currentTotal}, soal ini: {$itemCount} → total {$newTotal}.",
                type: 'error'
            );
            return;
        }

        $this->question_ids[] = $id;

        if ($newTotal === 5) {
            $this->dispatch('notify', message: 'Total defect sudah 5. Siap disimpan!', type: 'success');
        }
    }

    /**
     * Hitung total item semua soal yang dipilih.
     */
    public function getTotalSelectedItems(): int
    {
        if (empty($this->question_ids)) return 0;

        return Question::whereIn('id', $this->question_ids)
            ->get()
            ->sum(fn($q) => count($q->items ?? []));
    }

    /**
     * Reset pagination bank soal saat filter berubah.
     */
    public function updatedSection()
    {
        $this->question_ids = [];
        $this->customer_id = '';
        $this->model_id = '';
        $this->questionPage = 1;
        $this->searchQuestion = '';

        // Reset employee karena filter department berubah
        $this->selectedEmployees = [];
        $this->employeeSearch = '';
        $this->tempShift = '';
        $this->tempGroup = '';
    }

    public function updatedCustomerId()
    {
        $this->model_id = '';
        $this->question_ids = [];
        $this->questionPage = 1;
        $this->searchQuestion = '';
    }

    public function updatedModelId()
    {
        $this->question_ids = [];
        $this->questionPage = 1;
        $this->searchQuestion = '';
    }

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
            'duration_minutes'  => 'required|integer|min:1|max:600',
        ];
    }

    protected $messages = [
        'section.required'           => 'Section is required.',
        'customer_id.required'       => 'Customer is required.',
        'question_ids.required'      => 'Minimal pilih 1 soal.',
        'question_ids.min'           => 'Minimal pilih 1 soal.',
        'selectedEmployees.required' => 'Minimal 1 employee harus dipilih.',
        'selectedEmployees.min'      => 'Minimal 1 employee harus dipilih.',
        'duration_minutes.required'  => 'Durasi wajib diisi.',
        'duration_minutes.min'       => 'Durasi minimal 1 menit.',
        'duration_minutes.max'       => 'Durasi maksimal 600 menit.',
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
        ]);
        $this->resetPage();
    }

    // ==================== FORM ACTIONS ====================
    public function resetForm()
    {
        $this->reset([
            'blind_test_id', 'section', 'customer_id', 'model_id', 'question_ids',
            'selectedEmployees', 'employeeSearch', 'tempShift', 'tempGroup',
            'duration_minutes',
        ]);
        $this->modalTitle = 'Add New Blind Test';
        $this->resetValidation();
    }

    /* ================= EMPLOYEE MULTI PICKER ================= */

    public function addEmployee($id)
    {
        $e = Employee::where('id', $id)->whereIn('status', [1, 2, 3])->first();
        if (!$e) {
            $this->dispatch('notify', message: 'Invalid employee!', type: 'error');
            return;
        }

        // Validasi department sesuai section
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

        foreach ($this->selectedEmployees as $emp) {
            if ($emp['id'] == $e->id) {
                $this->dispatch('notify', message: 'Employee sudah ditambahkan!', type: 'warning');
                return;
            }
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
     * Kalau semua soal dari 1 model → pakai model itu.
     * Kalau beda model → pakai model pertama (untuk backward compat).
     */
    protected function resolveModelId($questions): ?int
    {
        $modelIds = $questions->pluck('model_id')->unique()->filter()->values();

        if ($modelIds->count() === 1) {
            return (int) $modelIds->first();
        }

        return $modelIds->first() ? (int) $modelIds->first() : null;
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

        $this->validate();

        // ========== VALIDASI: total item semua soal harus tepat 5 ==========
        if (empty($this->question_ids)) {
            $this->addError('question_ids', 'Minimal pilih 1 soal.');
            return;
        }

        // Soal boleh dari model berbeda — yang penting section + customer sama
        $questions = Question::whereIn('id', $this->question_ids)
            ->where('section', $this->section)
            ->where('customer_id', $this->customer_id)
            ->get();

        if ($questions->count() !== count($this->question_ids)) {
            $this->addError('question_ids', 'Ada soal yang tidak sesuai dengan section/customer.');
            return;
        }

        // Hitung total defect item
        $allItems = collect();
        foreach ($questions as $q) {
            foreach ($q->items ?? [] as $item) {
                $allItems->push($item);
            }
        }

        $totalItems = $allItems->count();

        if ($totalItems !== 5) {
            $this->addError('question_ids', "Total defect item harus tepat 5. Saat ini: {$totalItems}.");
            return;
        }

        // Convert question items → blind_test_items
        $blindTestItems = $allItems
            ->map(fn ($i) => [
                'deffect_item_id'    => (int) $i['deffect_id'],
                'deffect_name'       => $i['deffect_name'] ?? null,
                'component_location' => strtoupper(trim((string) ($i['location'] ?? ''))),
            ])
            ->values()
            ->toArray();

        // Snapshot gabungan semua soal
        $questionSnapshot = $questions->map(fn($q) => [
            'id'       => $q->id,
            'text'     => $q->question_text,
            'model_id' => $q->model_id,
            'items'    => $q->items,
        ])->values()->toArray();

        // Soal pertama (backward compat)
        $firstQuestionId = $questions->first()->id;

        // Resolve model_id (dari soal-soal yang dipilih)
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
                'duration_minutes'  => (int) $this->duration_minutes,
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
                'duration_minutes'  => (int) $this->duration_minutes,
                'time_test'         => null,
                'status'            => 'pending',
                'created_by'        => auth()->id(),
                'updated_by'        => auth()->id(),
            ]);
            $count++;
        }

        $this->resetForm();
        $this->dispatch('notify', message: "{$count} blind test berhasil dibuat!");
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
        $this->duration_minutes = $bt->duration_minutes;

        // Load question_ids (multiple), fallback ke question_id kalau kosong
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

        // Kalau section belum dipilih, jangan tampilkan employee
        if (empty($this->section)) {
            return [];
        }

        // Map section → department yang diizinkan
        $allowedDepartments = match ($this->section) {
            'QC'  => ['IQC', 'QA/QC'],
            'SMT' => ['PROD.1'],
            'MI'  => ['PROD.1'],
            'BE'  => ['PROD.2'],
            default => [],
        };

        if (empty($allowedDepartments)) {
            return [];
        }

        return Employee::where(function ($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            })
            ->whereIn('status', [1, 2, 3])
            ->whereIn('department', $allowedDepartments)
            ->limit(20)
            ->get()
            ->map(fn ($e) => [
                'id'         => $e->id,
                'nik'        => $e->nik ?? '-',
                'name'       => $e->name ?? '-',
                'department' => $e->department ?? '-',
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

        $formModels = $this->customer_id
            ? QaqcModel::where('customer_id', $this->customer_id)->orderBy('model_name')->get()
            : collect();

        // Query bank soal: filter section + customer, model optional
        $questionsQuery = ($this->section && $this->customer_id)
            ? Question::where('section', $this->section)
                ->where('customer_id', $this->customer_id)
                ->when($this->model_id, fn($q) => $q->where('model_id', $this->model_id))
            : null;

        if ($questionsQuery && $this->searchQuestion) {
            $questionsQuery->where(function ($q) {
                $q->where('id', 'like', '%' . $this->searchQuestion . '%')
                ->orWhere('question_text', 'like', '%' . $this->searchQuestion . '%');
            });
        }

        $questions = $questionsQuery
            ? $questionsQuery->orderByDesc('id')->get()
            : collect();

        // Soal terpilih (multiple)
        $selectedQuestions = !empty($this->question_ids)
            ? Question::whereIn('id', $this->question_ids)->get()
            : collect();

        $totalSelectedItems = $selectedQuestions->sum(fn($q) => count($q->items ?? []));

        return view('livewire.qaqc.blind-test.blind-test-management', [
            'blindTests'         => $blindTests,
            'customers'          => Customer::orderBy('customer_name')->get(),
            'allModels'          => QaqcModel::with('customer')->orderBy('model_name')->get(),
            'filterModels'       => $filterModels,
            'formModels'         => $formModels,
            'questions'          => $questions,
            'selectedQuestions'  => $selectedQuestions,
            'totalSelectedItems' => $totalSelectedItems,
            'users'              => User::select('id', 'name')->orderBy('name')->get(),
            'departments'        => $departments,
            'shifts'             => ['NS', '1', '2', '3'],
            'groups'             => ['NS', 'A', 'B', 'C'],
            'sections'           => self::SECTIONS,
        ]);
    }
}