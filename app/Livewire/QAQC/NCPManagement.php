<?php

namespace App\Livewire\QAQC;

use App\Models\HR\Employee;
use App\Models\QAQC\NCP;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class NCPManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $ncp_id;
    public $nik = '';
    public $employee_id = '';
    public $name = '';
    public $department = '';
    public $status_display = '';
    public $section = '';
    public $ncp_number = '';
    public $status = '';
    public $remarks = '';
    public $file;
    public $existingFile = '';
    
    // New fields
    public $part_description = '';
    public $part_number = '';
    public $supplier = '';
    public $customer = '';
    public $model_affected = '';
    public $lot_no = '';
    public $lot_qty = '';
    public $rejected_qty = '';
    public $failure_rate = '';
    public $do_no = '';
    public $packing_list_no = '';
    public $disposition = [];
    public $disposition_details = [];
    public $disposition_others = '';
    public $approved_by = '';
    
    // JSON defect details
    public $defect_details = [];
    public $defect_index = null;
    
    public $search = '';
    public $modalTitle = 'Add New NCP';
    public $ncpToDelete = null;
    public $employeeSearch = '';
    public $showEmployeeDropdown = false;

    // For edit mode file upload
    public $newFile;
    public $removeFile = false;

    public $viewNcpId = null;
    public $viewData = null;

    public $deleteReason = '';
    
    public $activeTab = 'all';

    protected function rules()
    {
        $rules = [
            'employee_id' => 'required',
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:100',
            'section' => 'nullable|string|max:100',
            'remarks' => 'nullable|string',
            'newFile' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:2048',
            'part_description' => 'nullable|string|max:255',
            'part_number' => 'nullable|string|max:100',
            'supplier' => 'nullable|string|max:255',
            'customer' => 'nullable|string|max:255',
            'model_affected' => 'nullable|string|max:100',
            'lot_no' => 'nullable|string|max:100',
            'lot_qty' => 'nullable|integer|min:0',
            'rejected_qty' => 'nullable|integer|min:0',
            'do_no' => 'nullable|string|max:100',
            'packing_list_no' => 'nullable|string|max:100',
            'disposition' => 'nullable|array',
            'disposition_others' => 'nullable|string|max:255',
            'defect_details' => 'nullable|array',
            'defect_details.*.serial_number' => 'nullable|string',
            'defect_details.*.defect_description' => 'nullable|string',
            'defect_details.*.quantity' => 'nullable|integer|min:1',
            'defect_details.*.defect_remarks' => 'nullable|string',
        ];

        // Add status validation only for edit mode
        if ($this->ncp_id) {
            $rules['status'] = 'required|in:open,in_progress,closed,rejected';
        }

        return $rules;
    }

    protected $messages = [
        'employee_id.required' => 'Employee is required.',
        'name.required' => 'Employee name is required.',
        'department.required' => 'Department is required.',
        'newFile.max' => 'File size must not exceed 2MB.',
        'newFile.mimes' => 'File must be a PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, or PNG.',
        'lot_qty.integer' => 'Lot quantity must be a number.',
        'rejected_qty.integer' => 'Rejected quantity must be a number.',
        'rejected_qty.min' => 'Rejected quantity cannot be negative.',
        'defect_details.*.quantity.min' => 'Quantity must be at least 1.',
        'status.required' => 'Status is required.',
    ];

    public function view($id)
    {
        if (!auth()->user()->can('view ncp')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $ncp = NCP::with(['employee', 'creator', 'approver', 'deleter'])->find($id);
        
        if (!$ncp) {
            $this->dispatch('notify', message: 'NCP not found!', type: 'error');
            return;
        }
        
        $this->viewData = $ncp;
        $this->dispatch('open-modal-view');
    }

    public function getEmployeesProperty()
    {
        return Cache::remember('ncp_employees_list', 300, function () {
            return Employee::query()
                ->select('id', 'nik', 'name', 'department', 'status')
                ->whereIn('status', [1, 2, 3])
                ->orderBy('nik')
                ->orderBy('name')
                ->limit(100)
                ->get()
                ->mapWithKeys(fn ($employee) => [
                    $employee->id => $employee->nik . ' - ' . $employee->name . ' (' . $employee->department . ')'
                ]);
        });
    }

    public function searchEmployees($search)
    {
        if (strlen($search) < 2) {
            return [];
        }
        
        return Employee::where('nik', 'like', "%{$search}%")
            ->orWhere('name', 'like', "%{$search}%")
            ->whereIn('status', [1, 2, 3])
            ->limit(20)
            ->get()
            ->map(fn($employee) => [
                'id' => $employee->id,
                'label' => $employee->nik . ' - ' . $employee->name . ' (' . $employee->department . ')'
            ]);
    }

    public function addDefectDetail()
    {
        $this->defect_details[] = [
            'serial_number' => '',
            'defect_description' => '',
            'quantity' => 1,
            'defect_remarks' => '',
        ];
    }

    public function removeDefectDetail($index)
    {
        unset($this->defect_details[$index]);
        $this->defect_details = array_values($this->defect_details);
    }

    public function editDefectDetail($index)
    {
        $this->defect_index = $index;
    }

    public function resetForm()
    {
        $this->reset([
            'ncp_id', 'employee_id', 'nik', 'name', 'department', 'status_display',
            'section', 'ncp_number', 'status', 'remarks', 'file', 'existingFile', 
            'newFile', 'removeFile', 'part_description', 'part_number', 'supplier',
            'customer', 'model_affected', 'lot_no', 'lot_qty', 'rejected_qty',
            'failure_rate', 'do_no', 'packing_list_no', 'disposition', 'disposition_details', 
            'approved_by', 'defect_details'
        ]);
        $this->modalTitle = 'Add New NCP';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedLotQty()
    {
        $this->calculateFailureRate();
    }

    public function updatedRejectedQty()
    {
        $this->calculateFailureRate();
    }

    private function calculateFailureRate()
    {
        if ($this->lot_qty && $this->lot_qty > 0 && $this->rejected_qty !== '') {
            $this->failure_rate = round(($this->rejected_qty / $this->lot_qty) * 100, 2);
        } else {
            $this->failure_rate = '';
        }
    }

    public function selectEmployee($id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            $this->employee_id = $employee->id;
            $this->nik = $employee->nik;
            $this->name = $employee->name;
            $this->department = $employee->department;
            $this->status_display = match((int)$employee->status) {
                1 => 'Permanent',
                2 => 'Contract',
                3 => 'Magang',
                default => 'Unknown',
            };
        }
        $this->employeeSearch = '';
        $this->showEmployeeDropdown = false;
    }

    public function clearEmployee()
    {
        $this->reset(['employee_id', 'nik','name', 'department', 'status_display']);
    }

    private function toRomanNumeral($number)
    {
        $romanNumerals = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
        ];
        return $romanNumerals[$number] ?? '';
    }

    private function generateNCPNumber()
    {
        $year = date('y');
        $month = (int)date('m');
        $romanMonth = $this->toRomanNumeral($month);
        
        $lastNCP = NCP::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', $month)
            ->whereNull('deleted_at')
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastNCP) {
            $parts = explode('/', $lastNCP->ncp_number);
            $sequence = (int)end($parts) + 1;
        } else {
            $sequence = 1;
        }
        
        $exists = NCP::where('ncp_number', "NCP/{$year}/{$romanMonth}/{$sequence}")
            ->withTrashed()
            ->exists();
        
        while ($exists) {
            $sequence++;
            $exists = NCP::where('ncp_number', "NCP/{$year}/{$romanMonth}/{$sequence}")
                ->withTrashed()
                ->exists();
        }
        
        return "NCP/{$year}/{$romanMonth}/{$sequence}";
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function getTabCountsProperty()
    {
        $canViewAll = auth()->user()->can('view ncp all');
        
        $baseQuery = NCP::query();
        $deletedQuery = NCP::onlyTrashed();
        
        if (!$canViewAll) {
            $currentUserNik = auth()->user()->nik;
            if ($currentUserNik) {
                $currentUserEmployee = Employee::where('nik', $currentUserNik)->first();
                if ($currentUserEmployee && $currentUserEmployee->department) {
                    $baseQuery->whereHas('employee', function ($empQuery) use ($currentUserEmployee) {
                        $empQuery->where('department', $currentUserEmployee->department);
                    });
                    $deletedQuery->whereHas('employee', function ($empQuery) use ($currentUserEmployee) {
                        $empQuery->where('department', $currentUserEmployee->department);
                    });
                } else {
                    return [
                        'all' => 0, 'open' => 0, 'in_progress' => 0, 
                        'closed' => 0, 'rejected' => 0, 'deleted' => 0
                    ];
                }
            } else {
                return [
                    'all' => 0, 'open' => 0, 'in_progress' => 0, 
                    'closed' => 0, 'rejected' => 0, 'deleted' => 0
                ];
            }
        }
        
        return [
            'all' => (clone $baseQuery)->whereNull('deleted_at')->count(),
            'open' => (clone $baseQuery)->whereNull('deleted_at')->where('status', 'open')->count(),
            'in_progress' => (clone $baseQuery)->whereNull('deleted_at')->where('status', 'in_progress')->count(),
            'closed' => (clone $baseQuery)->whereNull('deleted_at')->where('status', 'closed')->count(),
            'rejected' => (clone $baseQuery)->whereNull('deleted_at')->where('status', 'rejected')->count(),
            'deleted' => (clone $deletedQuery)->count(),
        ];
    }

    public function save()
    {
        if ($this->ncp_id) {
            if (!auth()->user()->can('edit ncp')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create ncp')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $dispositionString = null;
        if (!empty($this->disposition)) {
            $dispositionParts = [];
            foreach ($this->disposition as $selectedOption) {
                $detailText = $this->disposition_details[$selectedOption] ?? '';
                if (!empty($detailText)) {
                    $dispositionParts[] = $selectedOption . ': ' . $detailText;
                } else {
                    $dispositionParts[] = $selectedOption;
                }
            }
            $dispositionString = implode(', ', $dispositionParts);
        }

        $data = [
            'employee_id' => $this->employee_id,
            'section' => $this->section,
            'remarks' => $this->remarks,
            'part_description' => $this->part_description,
            'part_number' => $this->part_number,
            'supplier' => $this->supplier,
            'customer' => $this->customer,
            'model_affected' => $this->model_affected,
            'lot_no' => $this->lot_no,
            'lot_qty' => $this->lot_qty ?: null,
            'rejected_qty' => $this->rejected_qty ?: null,
            'do_no' => $this->do_no,
            'packing_list_no' => $this->packing_list_no,
            'disposition' => $dispositionString,
            'defect_details' => !empty($this->defect_details) ? $this->defect_details : null,
        ];

        if ($this->ncp_id) {
            $ncp = NCP::find($this->ncp_id);
            if (!$ncp) {
                $this->dispatch('notify', message: 'NCP not found!', type: 'error');
                return;
            }

            $data['status'] = $this->status;
            
            if ($this->approved_by) {
                $data['approved_by'] = $this->approved_by;
            }

            $ncp->update($data);

            if ($this->removeFile) {
                if ($ncp->file && \Storage::disk('public')->exists($ncp->file)) {
                    \Storage::disk('public')->delete($ncp->file);
                }
                $ncp->file = null;
                $ncp->save();
            } elseif ($this->newFile) {
                if ($ncp->file && \Storage::disk('public')->exists($ncp->file)) {
                    \Storage::disk('public')->delete($ncp->file);
                }
                $fileName = time() . '_' . $this->newFile->getClientOriginalName();
                $filePath = $this->newFile->storeAs('ncp-files', $fileName, 'public');
                $ncp->file = $filePath;
                $ncp->save();
            }

            $message = 'NCP updated successfully!';
        } else {
            $data['status'] = 'open';
            $data['ncp_number'] = $this->generateNCPNumber();
            $data['created_by'] = auth()->id();
            
            NCP::create($data);
            $message = 'NCP created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal-ncp');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit ncp')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $ncp = NCP::with('employee', 'approver')->find($id);

        if (!$ncp) {
            $this->dispatch('notify', message: 'NCP not found!', type: 'error');
            return;
        }

        $this->ncp_id = $ncp->id;
        $this->employee_id = $ncp->employee_id;
        $this->nik = $ncp->employee->nik ?? '';
        $this->name = $ncp->employee->name ?? '';
        $this->department = $ncp->employee->department ?? '';
        $this->section = $ncp->section;
        $this->ncp_number = $ncp->ncp_number;
        $this->status = $ncp->status;
        $this->remarks = $ncp->remarks;
        $this->existingFile = $ncp->file;
        
        $this->part_description = $ncp->part_description;
        $this->part_number = $ncp->part_number;
        $this->supplier = $ncp->supplier;
        $this->customer = $ncp->customer;
        $this->model_affected = $ncp->model_affected;
        $this->lot_no = $ncp->lot_no;
        $this->lot_qty = $ncp->lot_qty;
        $this->rejected_qty = $ncp->rejected_qty;
        $this->failure_rate = $ncp->failure_rate;
        $this->do_no = $ncp->do_no;
        $this->packing_list_no = $ncp->packing_list_no;
        
        if ($ncp->disposition) {
            $this->disposition = [];
            $this->disposition_details = [];
            
            $parts = explode(', ', $ncp->disposition);
            foreach ($parts as $part) {
                if (str_contains($part, ': ')) {
                    list($option, $detail) = explode(': ', $part, 2);
                    $this->disposition[] = trim($option);
                    $this->disposition_details[trim($option)] = trim($detail);
                } else {
                    $this->disposition[] = trim($part);
                    $this->disposition_details[trim($part)] = '';
                }
            }
        } else {
            $this->disposition = [];
            $this->disposition_details = [];
        }
        
        $this->approved_by = $ncp->approved_by;
        $this->defect_details = $ncp->defect_details ?? [];
        
        $this->modalTitle = 'Edit NCP';
        $this->dispatch('open-modal-ncp');
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete ncp')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $ncp = NCP::find($id);

        if (!$ncp) {
            $this->dispatch('notify', message: 'NCP not found!', type: 'error');
            return;
        }

        $this->ncpToDelete = $ncp;
        $this->deleteReason = '';
        $this->dispatch('open-modal-delete');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete ncp')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $ncp = NCP::find($this->ncpToDelete->id);

        if (!$ncp) {
            $this->dispatch('notify', message: 'NCP not found!', type: 'error');
            $this->ncpToDelete = null;
            return;
        }

        if (empty($this->deleteReason)) {
            $this->dispatch('notify', message: 'Please provide a reason for deletion!', type: 'error');
            return;
        }

        $ncp->deleted_by = auth()->id();
        $ncp->deleted_reason = $this->deleteReason;
        $ncp->save();
        
        $ncp->delete();

        $ncpNumber = $ncp->ncp_number;
        
        $this->ncpToDelete = null;
        $this->deleteReason = '';
        
        $this->dispatch('notify', message: "NCP '{$ncpNumber}' has been deleted successfully!");
        $this->dispatch('close-modal-delete');
    }

    public function cancelDelete()
    {
        $this->ncpToDelete = null;
        $this->deleteReason = '';
        $this->dispatch('close-modal-delete');
    }

    public function render()
    {
        if (!auth()->user()->can('view ncp')) {
            abort(403, 'Unauthorized access.');
        }

        $canViewAll = auth()->user()->can('view ncp all');
        
        $query = NCP::with(['employee' => function($query) {
                $query->select('id', 'nik', 'name', 'department');
            }, 'creator' => function($query) {
                $query->select('id', 'name');
            }, 'approver' => function($query) {
                $query->select('id', 'name');
            }, 'deleter' => function($query) {
                $query->select('id', 'name');
            }]);
        
        // Filter berdasarkan tab
        switch ($this->activeTab) {
            case 'deleted':
                $query->onlyTrashed();
                break;
            default:
                $query->whereNull('deleted_at');
                if ($this->activeTab !== 'all') {
                    $query->where('status', $this->activeTab);
                }
                break;
        }
        
        // Apply department filter
        if (!$canViewAll) {
            $currentUserNik = auth()->user()->nik;
            if ($currentUserNik) {
                $currentUserEmployee = Employee::where('nik', $currentUserNik)->first();
                if ($currentUserEmployee && $currentUserEmployee->department) {
                    $query->whereHas('employee', function ($empQuery) use ($currentUserEmployee) {
                        $empQuery->where('department', $currentUserEmployee->department);
                    });
                } else {
                    $query->whereRaw('1 = 0');
                }
            } else {
                $query->whereRaw('1 = 0');
            }
        }
        
        // Apply search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('ncp_number', 'like', '%' . $this->search . '%')
                    ->orWhere('section', 'like', '%' . $this->search . '%')
                    ->orWhere('remarks', 'like', '%' . $this->search . '%')
                    ->orWhere('part_number', 'like', '%' . $this->search . '%')
                    ->orWhere('part_description', 'like', '%' . $this->search . '%');
            });
        }
        
        $ncps = $query->orderByDesc('id')->paginate(10);

        return view('livewire.qaqc.ncp-management', [
            'ncps' => $ncps,
            'statuses' => NCP::getStatuses(),
            'employees' => $this->employees,
            'canViewAll' => $canViewAll,
            'users' => \App\Models\User::select('id', 'name')->orderBy('name')->get(),
            'tabCounts' => $this->tabCounts,
        ]);
    }
}