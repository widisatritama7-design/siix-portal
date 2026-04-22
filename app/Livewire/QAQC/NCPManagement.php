<?php

namespace App\Livewire\QAQC;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\QAQC\NCP;
use App\Models\HR\Employee;
use Illuminate\Support\Facades\Cache;

class NCPManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $ncp_id;
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
    
    public $search = '';
    public $modalTitle = 'Add New NCP';
    public $ncpToDelete = null;
    public $employeeSearch = '';
    public $showEmployeeDropdown = false;

    // For edit mode file upload
    public $newFile;
    public $removeFile = false;

    protected function rules()
    {
        return [
            'employee_id' => 'required',
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:100',
            'section' => 'nullable|string|max:100',
            'remarks' => 'nullable|string',
            'newFile' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:2048',
        ];
    }

    protected $messages = [
        'employee_id.required' => 'Employee is required.',
        'name.required' => 'Employee name is required.',
        'department.required' => 'Department is required.',
        'newFile.max' => 'File size must not exceed 2MB.',
        'newFile.mimes' => 'File must be a PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, or PNG.',
    ];

    // OPTIMIZED: Get employees for dropdown with caching
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

    // NEW: Search employees with lazy loading
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

    public function resetForm()
    {
        $this->reset(['ncp_id', 'employee_id', 'name', 'department', 'status_display', 'section', 'ncp_number', 'status', 'remarks', 'file', 'existingFile', 'newFile', 'removeFile']);
        $this->modalTitle = 'Add New NCP';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function selectEmployee($id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            $this->employee_id = $employee->id;
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
        $this->reset(['employee_id', 'name', 'department', 'status_display']);
    }

    private function toRomanNumeral($number)
    {
        $romanNumerals = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
        ];
        return $romanNumerals[$number] ?? '';
    }

    // OPTIMIZED: Generate NCP Number
    private function generateNCPNumber()
    {
        $year = date('y');
        $month = (int)date('m');
        $romanMonth = $this->toRomanNumeral($month);
        
        $lastNCP = NCP::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastNCP) {
            $parts = explode('/', $lastNCP->ncp_number);
            $sequence = (int)end($parts) + 1;
        } else {
            $sequence = 1;
        }
        
        return "NCP/{$year}/{$romanMonth}/{$sequence}";
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

        if ($this->ncp_id) {
            $ncp = NCP::find($this->ncp_id);
            if (!$ncp) {
                $this->dispatch('notify', message: 'NCP not found!', type: 'error');
                return;
            }

            $ncp->employee_id = $this->employee_id;
            $ncp->section = $this->section;
            $ncp->status = $this->status;
            $ncp->remarks = $this->remarks;

            if ($this->removeFile) {
                if ($ncp->file && \Storage::disk('public')->exists($ncp->file)) {
                    \Storage::disk('public')->delete($ncp->file);
                }
                $ncp->file = null;
            } elseif ($this->newFile) {
                if ($ncp->file && \Storage::disk('public')->exists($ncp->file)) {
                    \Storage::disk('public')->delete($ncp->file);
                }
                $fileName = time() . '_' . $this->newFile->getClientOriginalName();
                $filePath = $this->newFile->storeAs('ncp-files', $fileName, 'public');
                $ncp->file = $filePath;
            }

            $ncp->save();
            $message = 'NCP updated successfully!';
        } else {
            NCP::create([
                'employee_id' => $this->employee_id,
                'section' => $this->section,
                'remarks' => $this->remarks,
                'status' => 'open',
                'ncp_number' => $this->generateNCPNumber(),
            ]);
            $message = 'NCP created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'ncp-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit ncp')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $ncp = NCP::with('employee')->find($id);

        if (!$ncp) {
            $this->dispatch('notify', message: 'NCP not found!', type: 'error');
            return;
        }

        $this->ncp_id = $ncp->id;
        $this->employee_id = $ncp->employee_id;
        $this->name = $ncp->employee->name ?? '';
        $this->department = $ncp->employee->department ?? '';
        $this->section = $ncp->section;
        $this->ncp_number = $ncp->ncp_number;
        $this->status = $ncp->status;
        $this->remarks = $ncp->remarks;
        $this->existingFile = $ncp->file;
        $this->modalTitle = 'Edit NCP';
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
        $this->dispatch('open-modal', 'delete-ncp-modal');
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

        if ($ncp->file && \Storage::disk('public')->exists($ncp->file)) {
            \Storage::disk('public')->delete($ncp->file);
        }

        $ncpNumber = $ncp->ncp_number;
        $ncp->delete();

        $this->ncpToDelete = null;
        $this->dispatch('notify', message: "NCP '{$ncpNumber}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-ncp-modal');
    }

    public function cancelDelete()
    {
        $this->ncpToDelete = null;
        $this->dispatch('close-modal', 'delete-ncp-modal');
    }

    // OPTIMIZED: Render with specific select queries
    public function render()
    {
        if (!auth()->user()->can('view ncp')) {
            abort(403, 'Unauthorized access.');
        }

        // Check if user has 'view ncp all' permission
        $canViewAll = auth()->user()->can('view ncp all');
        
        $ncps = NCP::with(['employee' => function($query) {
                $query->select('id', 'nik', 'name', 'department');
            }, 'creator' => function($query) {
                $query->select('id', 'name');
            }])
            ->when(!$canViewAll, function ($query) {
                // If user doesn't have 'view ncp all' permission, only show their own records
                $query->where('created_by', auth()->id());
            })
            ->when($this->search, function ($query) {
                $query->where('ncp_number', 'like', '%' . $this->search . '%')
                      ->orWhere('section', 'like', '%' . $this->search . '%')
                      ->orWhere('remarks', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.qaqc.ncp-management', [
            'ncps' => $ncps,
            'statuses' => NCP::getStatuses(),
            'employees' => $this->employees,
            'canViewAll' => $canViewAll,
        ]);
    }
}