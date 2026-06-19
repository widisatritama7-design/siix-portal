<?php

namespace App\Livewire\PROD\Uniform;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PROD\Uniform\UniformRequest;
use App\Models\PROD\Uniform\MasterUniform;
use App\Models\HR\Employee;
use App\Mail\PROD\UniformRequestCreatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\LengthAwarePaginator;

class UniformRequestForm extends Component
{
    use WithPagination;

    public $requestId;
    public $rows = [];
    public $perPage = 10;
    
    // Current row for adding new item
    public $current_employee_id = null;
    public $current_master_uniform_id = null;
    public $current_qty = 1;
    public $current_reason = '';
    public $current_group = '';
    public $current_request_date = '';
    public $current_remarks = '';
    
    // Manual input (untuk admin)
    public $manualNik = '';
    public $manualName = '';
    public $manualDepartment = '';
    public $isManualInput = false;
    
    // For dropdown
    public $employeeSearch = '';
    public $uniformSearch = '';
    
    // Loading state
    public $isSaving = false;
    
    // User department for filtering (untuk user dengan akses one user)
    public $userDepartment = null;

    protected $rules = [
        'rows' => 'required|array|min:1',
        'rows.*.employee_id' => 'nullable|exists:tb_hr_employee,id',
        'rows.*.master_uniform_id' => 'required|exists:tb_prod_master_uniform,id',
        'rows.*.qty' => 'required|integer|min:1',
        'rows.*.reason' => 'required|string',
        'rows.*.group' => 'required|string|max:100',
        'rows.*.request_date' => 'required|date',
        'rows.*.remarks' => 'nullable|string',
    ];

    protected $messages = [
        'rows.required' => 'At least one row is required.',
        'rows.*.master_uniform_id.required' => 'Uniform is required.',
        'rows.*.qty.min' => 'Quantity must be at least 1.',
        'rows.*.group.required' => 'Group is required.',
    ];

    /**
     * Check if user can input manual
     */
    public function getCanManualInputProperty()
    {
        return auth()->user()->can('feedback uniform request admin');
    }

    /**
     * Get all employees for dropdown
     * - Hanya status 1, 2, 3
     * - Jika one user, filter berdasarkan department user
     */
    public function getEmployeesProperty()
    {
        $query = Employee::query()
            ->select('id', 'nik', 'name', 'department')
            ->whereIn('status', [1, 2, 3])
            ->orderBy('name');
        
        // CEK: Jika user hanya memiliki akses 'view uniform request one user'
        $isOneUser = auth()->user()->can('view uniform request one user');
        $isFullAccess = auth()->user()->can('view uniform request');
        
        // Jika one user (dan tidak punya full access), filter berdasarkan department
        if ($isOneUser && !$isFullAccess) {
            if ($this->userDepartment) {
                $query->where('department', $this->userDepartment);
            }
        }
        
        return $query->get()
            ->mapWithKeys(fn ($employee) => [
                $employee->id => $employee->nik . ' - ' . $employee->name . ' (' . $employee->department . ')'
            ]);
    }

    /**
     * Get all uniforms for dropdown
     */
    public function getUniformsProperty()
    {
        return MasterUniform::query()
            ->orderBy('item_code')
            ->get()
            ->mapWithKeys(fn ($uniform) => [
                $uniform->id => $uniform->item_code . ' - ' . $uniform->description . ' (' . $uniform->size . ')'
            ]);
    }

    public function mount($id = null)
    {
        $this->current_request_date = date('Y-m-d');
        
        // STEP 1: Ambil NIK dari user login (users.nik)
        $user = auth()->user();
        if ($user) {
            $userNik = trim($user->nik ?? '');
            
            if (!empty($userNik)) {
                $employee = Employee::where('nik', $userNik)
                    ->whereIn('status', [1, 2, 3])
                    ->first();
                
                if (!$employee) {
                    $employee = Employee::whereRaw('LOWER(nik) = ?', [strtolower($userNik)])
                        ->whereIn('status', [1, 2, 3])
                        ->first();
                }
                
                if ($employee) {
                    $this->userDepartment = $employee->department;
                } else {
                    \Log::warning('No active employee (status 1,2,3) found with NIK: ' . $userNik);
                    $this->userDepartment = null;
                }
            }
        }
        
        if ($id) {
            $this->requestId = $id;
            $request = UniformRequest::find($id);
            
            if ($request) {
                foreach ($request->items as $item) {
                    $employee = Employee::find($item['employee_id'] ?? null);
                    $uniform = MasterUniform::find($item['master_uniform_id']);
                    
                    $this->rows[] = [
                        'employee_id' => $item['employee_id'] ?? null,
                        'employee_nik' => $employee->nik ?? ($item['manual_nik'] ?? '-'),
                        'employee_name' => $employee->name ?? ($item['manual_name'] ?? '-'),
                        'employee_department' => $employee->department ?? ($item['manual_department'] ?? '-'),
                        'master_uniform_id' => $item['master_uniform_id'],
                        'item_code' => $uniform->item_code ?? '-',
                        'description' => $uniform->description ?? '-',
                        'size' => $uniform->size ?? '-',
                        'qty' => $item['qty'],
                        'reason' => $item['reason'],
                        'group' => $item['group'],
                        'request_date' => $item['request_date'],
                        'remarks' => $item['remarks'],
                        'admin_feedback' => $item['admin_feedback'] ?? null,
                        'admin_feedback_datetime' => $item['admin_feedback_datetime'] ?? null,
                        'costing_feedback' => $item['costing_feedback'] ?? null,
                        'costing_feedback_datetime' => $item['costing_feedback_datetime'] ?? null,
                        'manual_nik' => $item['manual_nik'] ?? null,
                        'manual_name' => $item['manual_name'] ?? null,
                        'manual_department' => $item['manual_department'] ?? null,
                        'is_manual' => $item['is_manual'] ?? false,
                    ];
                }
            }
        }
    }

    public function toggleManualInput()
    {
        $this->isManualInput = !$this->isManualInput;
        if ($this->isManualInput) {
            $this->current_employee_id = null;
            $this->employeeSearch = '';
        } else {
            $this->manualNik = '';
            $this->manualName = '';
            $this->manualDepartment = '';
        }
    }

    public function addRow()
    {
        $isAdmin = auth()->user()->can('feedback uniform request admin');
        
        // Validasi berdasarkan mode
        if ($this->isManualInput && $isAdmin) {
            $this->validate([
                'manualNik' => 'required|string',
                'manualName' => 'required|string',
                'manualDepartment' => 'required|string',
                'current_master_uniform_id' => 'required|exists:tb_prod_master_uniform,id',
                'current_qty' => 'required|integer|min:1',
                'current_reason' => 'required|string',
                'current_group' => 'required|string|max:100',
                'current_request_date' => 'required|date',
            ]);
        } else {
            $this->validate([
                'current_employee_id' => 'required|exists:tb_hr_employee,id',
                'current_master_uniform_id' => 'required|exists:tb_prod_master_uniform,id',
                'current_qty' => 'required|integer|min:1',
                'current_reason' => 'required|string',
                'current_group' => 'required|string|max:100',
                'current_request_date' => 'required|date',
            ]);
        }

        $uniform = MasterUniform::find($this->current_master_uniform_id);
        
        if ($this->isManualInput && $isAdmin) {
            // Manual input
            $this->rows[] = [
                'employee_id' => null,
                'employee_nik' => $this->manualNik,
                'employee_name' => $this->manualName,
                'employee_department' => $this->manualDepartment,  // TAMBAHKAN
                'master_uniform_id' => $this->current_master_uniform_id,
                'item_code' => $uniform->item_code ?? '-',
                'description' => $uniform->description ?? '-',
                'size' => $uniform->size ?? '-',
                'qty' => $this->current_qty,
                'reason' => $this->current_reason,
                'group' => $this->current_group,
                'request_date' => $this->current_request_date,
                'remarks' => $this->current_remarks,
                'admin_feedback' => null,
                'admin_feedback_datetime' => null,
                'costing_feedback' => null,
                'costing_feedback_datetime' => null,
                'manual_nik' => $this->manualNik,
                'manual_name' => $this->manualName,
                'manual_department' => $this->manualDepartment,  // TAMBAHKAN
                'is_manual' => true,
            ];
            
            $this->manualNik = '';
            $this->manualName = '';
            $this->manualDepartment = '';
        } else {
            // Regular input
            $employee = Employee::find($this->current_employee_id);
            
            if (!$employee) {
                session()->flash('error', 'Employee not found!');
                return;
            }
            
            if (!in_array($employee->status, [1, 2, 3])) {
                session()->flash('error', 'Employee ' . $employee->nik . ' - ' . $employee->name . ' is not active!');
                return;
            }
            
            $isOneUser = auth()->user()->can('view uniform request one user');
            $isFullAccess = auth()->user()->can('view uniform request');
            
            if ($isOneUser && !$isFullAccess && $this->userDepartment) {
                if ($employee->department !== $this->userDepartment) {
                    session()->flash('error', 'You can only select employees from your department: ' . $this->userDepartment);
                    return;
                }
            }

            $this->rows[] = [
                'employee_id' => $this->current_employee_id,
                'employee_nik' => $employee->nik ?? '-',
                'employee_name' => $employee->name ?? '-',
                'employee_department' => $employee->department ?? '-',
                'master_uniform_id' => $this->current_master_uniform_id,
                'item_code' => $uniform->item_code ?? '-',
                'description' => $uniform->description ?? '-',
                'size' => $uniform->size ?? '-',
                'qty' => $this->current_qty,
                'reason' => $this->current_reason,
                'group' => $this->current_group,
                'request_date' => $this->current_request_date,
                'remarks' => $this->current_remarks,
                'admin_feedback' => null,
                'admin_feedback_datetime' => null,
                'costing_feedback' => null,
                'costing_feedback_datetime' => null,
                'manual_nik' => null,
                'manual_name' => null,
                'manual_department' => null,
                'is_manual' => false,
            ];
        }

        // RESET FORM
        $this->current_employee_id = null;
        $this->current_master_uniform_id = null;
        $this->current_qty = 1;
        $this->current_reason = '';
        $this->current_group = '';
        $this->current_request_date = date('Y-m-d');
        $this->current_remarks = '';
        $this->employeeSearch = '';
        $this->uniformSearch = '';
        $this->isManualInput = false;

        $this->resetPage();

        session()->flash('success', 'Row added successfully!');
    }

    public function removeRow($index)
    {
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $this->perPage;
        $realIndex = $offset + $index;
        
        unset($this->rows[$realIndex]);
        $this->rows = array_values($this->rows);

        $this->resetPage();
        
        session()->flash('success', 'Row removed successfully!');
    }

    public function save()
    {
        $this->isSaving = true;
        
        try {
            $this->validate();

            $isOneUser = auth()->user()->can('view uniform request one user');
            $isFullAccess = auth()->user()->can('view uniform request');
            
            foreach ($this->rows as $row) {
                // Jika manual input, skip validasi employee
                if (isset($row['is_manual']) && $row['is_manual']) {
                    continue;
                }
                
                $employee = Employee::find($row['employee_id']);
                
                if (!$employee) {
                    session()->flash('error', 'Employee not found! (ID: ' . $row['employee_id'] . ')');
                    $this->isSaving = false;
                    return;
                }
                
                if (!in_array($employee->status, [1, 2, 3])) {
                    session()->flash('error', 'Employee ' . $employee->nik . ' - ' . $employee->name . ' is not active!');
                    $this->isSaving = false;
                    return;
                }
                
                if ($isOneUser && !$isFullAccess && $this->userDepartment) {
                    if ($employee->department !== $this->userDepartment) {
                        session()->flash('error', 'You can only create requests for employees from your department: ' . $this->userDepartment);
                        $this->isSaving = false;
                        return;
                    }
                }
            }

            $itemsForDb = [];
            foreach ($this->rows as $row) {
                $itemData = [
                    'employee_id' => $row['employee_id'] ?? null,
                    'master_uniform_id' => $row['master_uniform_id'],
                    'qty' => $row['qty'],
                    'reason' => $row['reason'],
                    'group' => $row['group'],
                    'request_date' => $row['request_date'],
                    'remarks' => $row['remarks'],
                    'admin_feedback' => $row['admin_feedback'] ?? null,
                    'admin_feedback_datetime' => $row['admin_feedback_datetime'] ?? null,
                    'costing_feedback' => $row['costing_feedback'] ?? null,
                    'costing_feedback_datetime' => $row['costing_feedback_datetime'] ?? null,
                ];
                
                // Jika manual input, tambahkan field manual
                if (isset($row['is_manual']) && $row['is_manual']) {
                    $itemData['manual_nik'] = $row['manual_nik'];
                    $itemData['manual_name'] = $row['manual_name'];
                    $itemData['manual_department'] = $row['manual_department'];
                    $itemData['is_manual'] = true;
                }
                
                $itemsForDb[] = $itemData;
            }

            $isUpdate = false;
            
            if ($this->requestId) {
                $request = UniformRequest::find($this->requestId);
                $request->update(['items' => $itemsForDb]);
                session()->flash('success', 'Request updated successfully!');
                $isUpdate = true;
            } else {
                $request = UniformRequest::create(['items' => $itemsForDb]);
                session()->flash('success', 'Request created successfully!');
            }

            try {
                Mail::to('sek.esd@siix-global.com')
                    ->send(new UniformRequestCreatedMail($request, $isUpdate));
            } catch (\Exception $e) {
                \Log::error('Failed to send uniform request email: ' . $e->getMessage());
            }

            $this->isSaving = false;
            return redirect()->route('prod.uniform.request.index');
            
        } catch (\Exception $e) {
            $this->isSaving = false;
            throw $e;
        }
    }

    public function getPage()
    {
        // Ambil dari request atau default 1
        return request()->get('page', 1);
    }

    public function resetPage()
    {
        // Redirect ke halaman 1
        $this->dispatch('resetPage');
        // Atau gunakan JavaScript
    }

    public function render()
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = $this->perPage;
        $totalRows = count($this->rows);
        
        $offset = ($currentPage - 1) * $perPage;
        $paginatedRows = array_slice($this->rows, $offset, $perPage);
        
        $paginator = new LengthAwarePaginator(
            $paginatedRows,
            $totalRows,
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
        
        return view('livewire.prod.uniform.uniform-request-form', [
            'paginatedRows' => $paginator,
        ]);
    }
}