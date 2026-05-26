<?php

namespace App\Livewire\PROD\Uniform;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PROD\Uniform\UniformRequest;
use App\Models\PROD\Uniform\MasterUniform;
use App\Models\HR\Employee;
use App\Mail\PROD\UniformRequestCreatedMail;
use Illuminate\Support\Facades\Mail;

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
    
    // For dropdown
    public $employeeSearch = '';
    public $uniformSearch = '';
    
    // Loading state
    public $isSaving = false;

    protected $rules = [
        'rows' => 'required|array|min:1',
        'rows.*.employee_id' => 'required|exists:tb_hr_employee,id',
        'rows.*.master_uniform_id' => 'required|exists:tb_prod_master_uniform,id',
        'rows.*.qty' => 'required|integer|min:1',
        'rows.*.reason' => 'required|string',
        'rows.*.group' => 'required|string|max:100',
        'rows.*.request_date' => 'required|date',
        'rows.*.remarks' => 'nullable|string',
    ];

    protected $messages = [
        'rows.required' => 'At least one row is required.',
        'rows.*.employee_id.required' => 'Employee is required.',
        'rows.*.master_uniform_id.required' => 'Uniform is required.',
        'rows.*.qty.min' => 'Quantity must be at least 1.',
        'rows.*.reason.min' => 'Reason must be at least 5 characters.',
        'rows.*.group.required' => 'Group is required.',
    ];

    // Get all employees for dropdown
    public function getEmployeesProperty()
    {
        return Employee::query()
            ->select('id', 'nik', 'name', 'department')
            ->whereIn('status', [1, 2, 3]) // or whatever your column name is
            ->orderBy('name')
            ->get()
            ->mapWithKeys(fn ($employee) => [
                $employee->id => $employee->nik . ' - ' . $employee->name . ' (' . $employee->department . ')'
            ]);
    }

    // Get all uniforms for dropdown
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
        
        if ($id) {
            $this->requestId = $id;
            $request = UniformRequest::find($id);
            
            if ($request) {
                foreach ($request->items as $item) {
                    $employee = Employee::find($item['employee_id']);
                    $uniform = MasterUniform::find($item['master_uniform_id']);
                    
                    $this->rows[] = [
                        'employee_id' => $item['employee_id'],
                        'employee_nik' => $employee->nik ?? '-',
                        'employee_name' => $employee->name ?? '-',
                        'employee_department' => $employee->department ?? '-',
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
                    ];
                }
            }
        }
    }

    public function addRow()
    {
        $this->validate([
            'current_employee_id' => 'required|exists:tb_hr_employee,id',
            'current_master_uniform_id' => 'required|exists:tb_prod_master_uniform,id',
            'current_qty' => 'required|integer|min:1',
            'current_reason' => 'required|string',
            'current_group' => 'required|string|max:100',
            'current_request_date' => 'required|date',
        ]);

        $employee = Employee::find($this->current_employee_id);
        $uniform = MasterUniform::find($this->current_master_uniform_id);

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
        ];

        // RESET FORM KE KOSONG
        $this->current_employee_id = null;
        $this->current_master_uniform_id = null;
        $this->current_qty = 1;
        $this->current_reason = '';
        $this->current_group = '';
        $this->current_request_date = date('Y-m-d');
        $this->current_remarks = '';
        $this->employeeSearch = '';
        $this->uniformSearch = '';

        session()->flash('success', 'Row added successfully!');
    }

    public function removeRow($index)
    {
        // Hitung index sebenarnya berdasarkan pagination
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $this->perPage;
        $realIndex = $offset + $index;
        
        unset($this->rows[$realIndex]);
        $this->rows = array_values($this->rows);
        
        session()->flash('success', 'Row removed successfully!');
    }

    public function save()
    {
        $this->isSaving = true;
        
        try {
            $this->validate();

            $itemsForDb = [];
            foreach ($this->rows as $row) {
                $itemsForDb[] = [
                    'employee_id' => $row['employee_id'],
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

            // Send email notification
            try {
                Mail::to(['widifajarsatritama@gmail.com', 'sek.esd@siix-global.com'])
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

    public function render()
    {
        // Paginate rows manually
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $this->perPage;
        $paginatedRows = array_slice($this->rows, $offset, $this->perPage);
        
        $totalRows = count($this->rows);
        $lastPage = ceil($totalRows / $this->perPage);
        
        return view('livewire.prod.uniform.uniform-request-form', [
            'paginatedRows' => $paginatedRows,
            'totalRows' => $totalRows,
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
            'perPage' => $this->perPage,
        ]);
    }
}