<?php

namespace App\Livewire\PROD\Uniform;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PROD\Uniform\UniformRequest;
use App\Models\PROD\Uniform\MasterUniform;
use App\Models\PROD\Uniform\UniformStockTransaction;
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
    public $current_uniforms = []; // Array untuk multiple uniforms
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
    
    // User department for filtering
    public $userDepartment = null;
    
    // Untuk paginasi table uniform
    public $uniformPage = 1;
    public $uniformPerPage = 5;
    protected $listeners = ['refreshUniformPage' => '$refresh'];

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

    public function getCanManualInputProperty()
    {
        return auth()->user()->can('feedback uniform request admin');
    }

    public function getEmployeesProperty()
    {
        $query = Employee::query()
            ->select('id', 'nik', 'name', 'department')
            ->whereIn('status', [1, 2, 3])
            ->orderBy('name');
        
        $isOneUser = auth()->user()->can('view uniform request one user');
        $isFullAccess = auth()->user()->can('view uniform request');
        
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

    // Ambil uniform yang memiliki stock > 0 dan belum ada di current_uniforms
    public function getAvailableUniformsProperty()
    {
    // Ambil ID uniform yang sudah ada di cart
    $existingUniformIds = collect($this->current_uniforms)->pluck('master_uniform_id')->toArray();
    
    // Hitung qty yang sudah di-cart per uniform
    $cartQtyMap = [];
    foreach ($this->current_uniforms as $item) {
        $cartQtyMap[$item['master_uniform_id']] = ($cartQtyMap[$item['master_uniform_id']] ?? 0) + $item['qty'];
    }
    
    // Hitung qty yang sudah di-request items (rows)
    $requestQtyMap = [];
    foreach ($this->rows as $row) {
        $requestQtyMap[$row['master_uniform_id']] = ($requestQtyMap[$row['master_uniform_id']] ?? 0) + $row['qty'];
    }
    
    $query = MasterUniform::query()
        ->where('qty', '>', 0);
    
    // Filter berdasarkan search
    if ($this->uniformSearch) {
        $query->where(function($q) {
            $q->where('item_code', 'like', '%' . $this->uniformSearch . '%')
                ->orWhere('description', 'like', '%' . $this->uniformSearch . '%')
                ->orWhere('size', 'like', '%' . $this->uniformSearch . '%');
        });
    }
    
    // Exclude uniform yang sudah ada di cart
    if (!empty($existingUniformIds)) {
        $query->whereNotIn('id', $existingUniformIds);
    }
    
    $uniforms = $query->orderBy('item_code')->get();
    
    // Tambahkan qty yang sudah dipesan (cart + rows) ke setiap uniform
    $availableUniforms = [];
    foreach ($uniforms as $uniform) {
        $reservedQty = ($cartQtyMap[$uniform->id] ?? 0) + ($requestQtyMap[$uniform->id] ?? 0);
        $availableQty = $uniform->qty - $reservedQty;
        
        // Hanya yang available_qty > 0
        if ($availableQty > 0) {
            $uniform->available_qty = $availableQty;
            $uniform->reserved_qty = $reservedQty;
            $availableUniforms[] = $uniform;
        }
    }
    
    // Paginate manual dengan LengthAwarePaginator
    $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage('uniformPage');
    $perPage = $this->uniformPerPage;
    $total = count($availableUniforms);
    $items = array_slice($availableUniforms, ($currentPage - 1) * $perPage, $perPage);
    
    return new \Illuminate\Pagination\LengthAwarePaginator(
        $items,
        $total,
        $perPage,
        $currentPage,
        [
            'path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath(),
            'pageName' => 'uniformPage',
            'query' => request()->query(),
        ]
    );
    }

    public function mount($id = null)
    {
        $this->current_request_date = date('Y-m-d');
        $this->current_uniforms = [];
        $this->current_master_uniform_id = null;
        
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

    // Add uniform to current employee's uniform list
    public function addUniformToCurrent()
    {
        $this->validate([
            'current_master_uniform_id' => 'required|exists:tb_prod_master_uniform,id',
            'current_qty' => 'required|integer|min:1',
            'current_reason' => 'required|string',
            'current_remarks' => 'nullable|string',
        ]);

        $uniform = MasterUniform::find($this->current_master_uniform_id);
        
        // Cek stock tersedia
        if ($uniform->qty < $this->current_qty) {
            session()->flash('error', 'Insufficient stock! Available: ' . $uniform->qty . ', Requested: ' . $this->current_qty);
            return;
        }
        
        // Check if uniform already added
        $exists = collect($this->current_uniforms)->contains('master_uniform_id', $this->current_master_uniform_id);
        
        if ($exists) {
            session()->flash('error', 'This uniform has already been added for this employee!');
            return;
        }

        $this->current_uniforms[] = [
            'master_uniform_id' => $this->current_master_uniform_id,
            'item_code' => $uniform->item_code ?? '-',
            'description' => $uniform->description ?? '-',
            'size' => $uniform->size ?? '-',
            'qty' => $this->current_qty,
            'reason' => $this->current_reason,
            'remarks' => $this->current_remarks,
            'stock_available' => $uniform->qty,
        ];

        // Reset uniform fields
        $this->current_master_uniform_id = null;
        $this->current_qty = 1;
        $this->uniformSearch = '';

        session()->flash('success', 'Uniform added to list!');
    }

    // Remove uniform from current employee's list
    public function removeUniformFromCurrent($index)
    {
        unset($this->current_uniforms[$index]);
        $this->current_uniforms = array_values($this->current_uniforms);
        // Reset page untuk refresh tabel uniform
        $this->uniformPage = 1;
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
                'current_uniforms' => 'required|array|min:1',
                'current_group' => 'required|string|max:100',
                'current_request_date' => 'required|date',
            ]);
        } else {
            $this->validate([
                'current_employee_id' => 'required|exists:tb_hr_employee,id',
                'current_uniforms' => 'required|array|min:1',
                'current_group' => 'required|string|max:100',
                'current_request_date' => 'required|date',
            ]);
        }

        // Get employee data
        $employee = null;
        $isManual = false;
        
        if ($this->isManualInput && $isAdmin) {
            $isManual = true;
            $employeeData = [
                'nik' => $this->manualNik,
                'name' => $this->manualName,
                'department' => $this->manualDepartment,
            ];
        } else {
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
        }

        // Create rows for each uniform
        foreach ($this->current_uniforms as $uniformItem) {
            $rowData = [
                'master_uniform_id' => $uniformItem['master_uniform_id'],
                'item_code' => $uniformItem['item_code'],
                'description' => $uniformItem['description'],
                'size' => $uniformItem['size'],
                'qty' => $uniformItem['qty'],
                'reason' => $uniformItem['reason'],
                'group' => $this->current_group,
                'request_date' => $this->current_request_date,
                'remarks' => $uniformItem['remarks'] ?? null,
                'admin_feedback' => null,
                'admin_feedback_datetime' => null,
                'costing_feedback' => null,
                'costing_feedback_datetime' => null,
            ];

            if ($isManual) {
                $rowData['employee_id'] = null;
                $rowData['employee_nik'] = $employeeData['nik'];
                $rowData['employee_name'] = $employeeData['name'];
                $rowData['employee_department'] = $employeeData['department'];
                $rowData['manual_nik'] = $employeeData['nik'];
                $rowData['manual_name'] = $employeeData['name'];
                $rowData['manual_department'] = $employeeData['department'];
                $rowData['is_manual'] = true;
            } else {
                $rowData['employee_id'] = $employee->id;
                $rowData['employee_nik'] = $employee->nik ?? '-';
                $rowData['employee_name'] = $employee->name ?? '-';
                $rowData['employee_department'] = $employee->department ?? '-';
                $rowData['manual_nik'] = null;
                $rowData['manual_name'] = null;
                $rowData['manual_department'] = null;
                $rowData['is_manual'] = false;
            }

            $this->rows[] = $rowData;
        }

        $countUniforms = count($this->current_uniforms);
        
        // RESET FORM
        $this->current_employee_id = null;
        $this->current_master_uniform_id = null;
        $this->current_qty = 1;
        $this->current_uniforms = [];
        $this->current_reason = '';
        $this->current_group = '';
        $this->current_request_date = date('Y-m-d');
        $this->current_remarks = '';
        $this->employeeSearch = '';
        $this->uniformSearch = '';
        $this->isManualInput = false;
        $this->manualNik = '';
        $this->manualName = '';
        $this->manualDepartment = '';

        $this->resetPage();

        session()->flash('success', $countUniforms . ' uniform(s) added successfully for employee!');
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
            
            // CEK STOCK SEBELUM CREATE
            $stockErrors = [];
            $stockData = [];
            foreach ($this->rows as $row) {
                $uniform = MasterUniform::find($row['master_uniform_id']);
                if (!$uniform) {
                    $stockErrors[] = "Uniform not found! (ID: " . $row['master_uniform_id'] . ")";
                    continue;
                }
                
                // Cek stock tersedia
                if ($uniform->qty < $row['qty']) {
                    $stockErrors[] = "Insufficient stock for {$uniform->item_code} - {$uniform->description} ({$uniform->size}). Available: {$uniform->qty}, Requested: {$row['qty']}";
                }
                
                $stockData[] = [
                    'uniform' => $uniform,
                    'qty_requested' => $row['qty'],
                    'employee_nik' => $row['employee_nik'] ?? $row['manual_nik'] ?? '-',
                    'employee_name' => $row['employee_name'] ?? $row['manual_name'] ?? '-',
                    'employee_department' => $row['employee_department'] ?? $row['manual_department'] ?? '-',
                ];
            }
            
            if (!empty($stockErrors)) {
                session()->flash('error', implode('<br>', $stockErrors));
                $this->isSaving = false;
                return;
            }
            
            // Validasi employee
            foreach ($this->rows as $row) {
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
                    'remarks' => $row['remarks'] ?? null,
                    'admin_feedback' => $row['admin_feedback'] ?? null,
                    'admin_feedback_datetime' => $row['admin_feedback_datetime'] ?? null,
                    'costing_feedback' => $row['costing_feedback'] ?? null,
                    'costing_feedback_datetime' => $row['costing_feedback_datetime'] ?? null,
                ];
                
                if (isset($row['is_manual']) && $row['is_manual']) {
                    $itemData['manual_nik'] = $row['manual_nik'];
                    $itemData['manual_name'] = $row['manual_name'];
                    $itemData['manual_department'] = $row['manual_department'];
                    $itemData['is_manual'] = true;
                }
                
                $itemsForDb[] = $itemData;
            }

            $isUpdate = false;
            $request = null;
            
            if ($this->requestId) {
                // UPDATE: Kurangi stock sesuai perubahan qty
                $request = UniformRequest::find($this->requestId);
                $oldItems = $request->items ?? [];
                
                // Hitung selisih qty per uniform
                $qtyDiff = [];
                foreach ($oldItems as $oldItem) {
                    $key = $oldItem['master_uniform_id'];
                    $qtyDiff[$key] = ($qtyDiff[$key] ?? 0) - $oldItem['qty'];
                }
                foreach ($itemsForDb as $newItem) {
                    $key = $newItem['master_uniform_id'];
                    $qtyDiff[$key] = ($qtyDiff[$key] ?? 0) + $newItem['qty'];
                }
                
                // Update stock berdasarkan selisih
                foreach ($qtyDiff as $uniformId => $diff) {
                    if ($diff == 0) continue;
                    
                    $uniform = MasterUniform::find($uniformId);
                    if ($uniform) {
                        $oldQty = $uniform->qty;
                        $newQty = $oldQty - $diff;
                        
                        if ($newQty < 0) {
                            session()->flash('error', "Insufficient stock for {$uniform->item_code}! Available: {$oldQty}, Need: " . ($diff));
                            $this->isSaving = false;
                            return;
                        }
                        
                        $uniform->qty = $newQty;
                        $uniform->save();
                        
                        // Catat transaksi
                        UniformStockTransaction::create([
                            'master_uniform_id' => $uniform->id,
                            'transaction_type' => $diff > 0 ? 'OUT' : 'IN',
                            'qty_change' => -$diff,
                            'qty_before' => $oldQty,
                            'qty_after' => $newQty,
                            'reference_id' => $request->request_number,
                            'reference_type' => 'uniform_request_edit',
                            'description' => 'Edit request: ' . $request->request_number . ' - ' . ($diff > 0 ? 'Added ' . $diff . ' items' : 'Removed ' . abs($diff) . ' items'),
                            'performed_by' => auth()->user()->name,
                            'performed_at' => now(),
                        ]);
                    }
                }
                
                $request->update(['items' => $itemsForDb]);
                session()->flash('success', 'Request updated successfully! Stock adjusted.');
                $isUpdate = true;
            } else {
                // CREATE: Kurangi stock
                $request = UniformRequest::create(['items' => $itemsForDb]);
                
                // Kurangi stock untuk setiap item
                foreach ($stockData as $data) {
                    $uniform = $data['uniform'];
                    $oldQty = $uniform->qty;
                    $newQty = $oldQty - $data['qty_requested'];
                    
                    $uniform->qty = $newQty;
                    $uniform->save();
                    
                    // Buat deskripsi dengan NIK, Name, Department
                    $employeeInfo = $data['employee_nik'] . ' - ' . $data['employee_name'] . ' (' . $data['employee_department'] . ')';
                    
                    // Catat transaksi OUT
                    UniformStockTransaction::create([
                        'master_uniform_id' => $uniform->id,
                        'transaction_type' => 'OUT',
                        'qty_change' => -$data['qty_requested'],
                        'qty_before' => $oldQty,
                        'qty_after' => $newQty,
                        'reference_id' => $request->request_number,
                        'reference_type' => 'uniform_request',
                        'description' => 'Request: ' . $request->request_number . ' - ' . $employeeInfo,
                        'performed_by' => auth()->user()->name,
                        'performed_at' => now(),
                    ]);
                }
                
                session()->flash('success', 'Request created successfully! Stock has been updated.');
            }

            try {
                Mail::to('SEK.Admin01@siix-global.com')
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
        return request()->get('page', 1);
    }

    public function resetPage()
    {
        $this->dispatch('resetPage');
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
        
        // Ambil uniform dengan stock > 0
        $availableUniforms = $this->available_uniforms;
        
        return view('livewire.prod.uniform.uniform-request-form', [
            'paginatedRows' => $paginator,
            'availableUniforms' => $availableUniforms,
        ]);
    }
}