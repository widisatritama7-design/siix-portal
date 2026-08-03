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

    // User department for filtering
    public $userDepartment = null;
    public $hasValidEmployee = false;

    public $printNcpId = null;
    public $printData = null;

    protected function rules()
    {
        $rules = [
            'employee_id' => 'required|exists:tb_hr_employee,id',
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

    public function printNCP($id)
    {
        if (!auth()->user()->can('view ncp')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $ncp = NCP::with(['employee', 'creator', 'approver'])->find($id);
        
        if (!$ncp) {
            $this->dispatch('notify', message: 'NCP not found!', type: 'error');
            return;
        }

        // Check if user has valid employee record
        if (!$this->hasValidEmployeeRecord()) {
            $this->dispatch('notify', message: 'You do not have a valid employee record!', type: 'error');
            return;
        }

        // Validate that NCP belongs to same department
        $canViewAll = $this->canViewAll();
        $userDepartment = $this->getUserDepartment();
        
        if (!$canViewAll && $ncp->employee && $userDepartment && $ncp->employee->department !== $userDepartment) {
            $this->dispatch('notify', message: 'You can only print NCPs from your department!', type: 'error');
            return;
        }

        // Check if NCP is complete
        if (!$this->canPrintNCP($id)) {
            $this->dispatch('notify', message: 'Cannot print - NCP data incomplete! Need at least 1 defect or disposition.', type: 'error');
            return;
        }

        // Generate new serial number
        $ncp->serial_number_barcode = NCP::generateSerialNumberBarcode();
        
        // Increment print count - fix untuk null/0
        if ($ncp->print_count === null || $ncp->print_count == 0) {
            $ncp->print_count = 1;
        } else {
            $ncp->print_count = $ncp->print_count + 1;
        }
        
        $ncp->last_printed_at = now();
        $ncp->save();

        // Set data untuk print
        $this->printNcpId = $ncp->id;
        $this->printData = $ncp;

        // Dispatch event untuk print
        $this->dispatch('print-ncp-pdf', $ncp->id);
        
        $this->dispatch('notify', message: 'NCP printed successfully! (Print #' . $ncp->print_count . ')', type: 'success');
    }

    public function updatedSection($value)
    {
        $this->section = strtoupper($value);
    }

    public function canPrintNCP($ncpId)
    {
        $ncp = NCP::find($ncpId);
        if (!$ncp) {
            return false;
        }
        
        // Minimal harus ada employee_id dan ncp_number
        if (empty($ncp->employee_id) || empty($ncp->ncp_number)) {
            return false;
        }
        
        // Cek apakah ada defect details
        $hasDefect = !empty($ncp->defect_details) && count($ncp->defect_details) > 0;
        
        // Cek apakah ada disposition
        $hasDisposition = !empty($ncp->disposition);
        
        // Harus ada minimal 1 defect ATAU 1 disposition
        return $hasDefect || $hasDisposition;
    }

    /**
     * Get current user's employee data
     * Only returns if user has valid NIK with status 1,2,3
     */
    private function getCurrentUserEmployee()
    {
        $currentUserNik = auth()->user()->nik;
        
        if (!$currentUserNik) {
            return null;
        }
        
        return Employee::where('nik', $currentUserNik)
            ->whereIn('status', [1, 2, 3])
            ->first();
    }

    /**
     * Get current user's department
     */
    private function getUserDepartment()
    {
        $employee = $this->getCurrentUserEmployee();
        return $employee ? $employee->department : null;
    }

    /**
     * Check if current user has valid employee record
     */
    private function hasValidEmployeeRecord()
    {
        return $this->getCurrentUserEmployee() !== null;
    }

    /**
     * Check if user can view all NCPs
     */
    private function canViewAll()
    {
        return auth()->user()->can('view ncp all');
    }

    /**
     * Get all employees for dropdown
     * - Hanya status 1, 2, 3
     * - Filter berdasarkan department user (kecuali memiliki akses all)
     */
    public function getEmployeesProperty()
    {
        $userDepartment = $this->getUserDepartment();
        $canViewAll = $this->canViewAll();
        
        // Jika user tidak memiliki employee valid, return empty
        if (!$this->hasValidEmployeeRecord()) {
            return collect([]);
        }
        
        return Cache::remember('ncp_employees_list_' . ($canViewAll ? 'all' : 'dept_' . $userDepartment), 300, function () use ($userDepartment, $canViewAll) {
            $query = Employee::query()
                ->select('id', 'nik', 'name', 'department')
                ->whereIn('status', [1, 2, 3]);
            
            // Jika tidak memiliki akses all, filter berdasarkan department
            if (!$canViewAll && $userDepartment) {
                $query->where('department', $userDepartment);
            }
            
            return $query->orderBy('nik')
                ->orderBy('name')
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
        
        $userDepartment = $this->getUserDepartment();
        $canViewAll = $this->canViewAll();
        
        // Jika user tidak memiliki employee valid, return empty
        if (!$this->hasValidEmployeeRecord()) {
            return [];
        }
        
        $query = Employee::where(function($query) use ($search) {
                $query->where('nik', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            })
            ->whereIn('status', [1, 2, 3]);
        
        // Jika tidak memiliki akses all, filter berdasarkan department
        if (!$canViewAll && $userDepartment) {
            $query->where('department', $userDepartment);
        }
        
        return $query->limit(20)
            ->get()
            ->map(fn($employee) => [
                'id' => $employee->id,
                'nik' => $employee->nik ?? '-',
                'name' => $employee->name ?? '-',
                'department' => $employee->department ?? '-',
                'section' => $employee->section ?? '-',
                'label' => ($employee->nik ?? '') . ' - ' . ($employee->name ?? '') . ' (' . ($employee->department ?? '') . ')'
            ]);
    }

    public function mount()
    {
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
                    $this->hasValidEmployee = true;
                    
                    // HANYA set data untuk tampilan, JANGAN set employee_id
                    // Biarkan user memilih employee sendiri
                    $this->nik = $employee->nik;
                    $this->name = $employee->name;
                    $this->department = $employee->department;
                    $this->status_display = match((int)$employee->status) {
                        1 => 'Permanent',
                        2 => 'Contract',
                        3 => 'Magang',
                        default => 'Unknown',
                    };
                    
                    // HAPUS INI:
                    // $this->employee_id = $employee->id; // <-- JANGAN DIISI!
                } else {
                    \Log::warning('No active employee (status 1,2,3) found with NIK: ' . $userNik);
                    $this->userDepartment = null;
                    $this->hasValidEmployee = false;
                }
            }
        }
    }

    public function view($id)
    {
        if (!auth()->user()->can('view ncp')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        // Check if user has valid employee record
        if (!$this->hasValidEmployeeRecord()) {
            $this->dispatch('notify', message: 'You do not have a valid employee record!', type: 'error');
            return;
        }

        $ncp = NCP::with(['employee', 'creator', 'approver', 'deleter'])->find($id);
        
        if (!$ncp) {
            $this->dispatch('notify', message: 'NCP not found!', type: 'error');
            return;
        }
        
        // Validate that NCP belongs to same department (kecuali memiliki akses all)
        $userDepartment = $this->getUserDepartment();
        $canViewAll = $this->canViewAll();
        
        if (!$canViewAll && $ncp->employee && $userDepartment && $ncp->employee->department !== $userDepartment) {
            $this->dispatch('notify', message: 'You can only view NCPs from your department!', type: 'error');
            return;
        }
        
        $this->viewData = $ncp;
        $this->dispatch('open-modal-view');
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
        
        // JANGAN auto-fill employee_id di resetForm!
        // Biarkan user memilih employee
        // Hanya set data user untuk tampilan
        $currentUserEmployee = $this->getCurrentUserEmployee();
        if ($currentUserEmployee) {
            // Hanya set untuk tampilan, JANGAN set employee_id
            $this->nik = $currentUserEmployee->nik;
            $this->name = $currentUserEmployee->name;
            $this->department = $currentUserEmployee->department;
            $this->status_display = match((int)$currentUserEmployee->status) {
                1 => 'Permanent',
                2 => 'Contract',
                3 => 'Magang',
                default => 'Unknown',
            };
        }
        
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
        // Verify employee has valid status
        $currentUserEmployee = $this->getCurrentUserEmployee();
        $canViewAll = $this->canViewAll();
        
        if (!$currentUserEmployee) {
            $this->dispatch('notify', message: 'You do not have a valid employee record!', type: 'error');
            return;
        }
        
        $query = Employee::where('id', $id)->whereIn('status', [1, 2, 3]);
        
        // Jika tidak memiliki akses all, filter berdasarkan department
        if (!$canViewAll) {
            $query->where('department', $currentUserEmployee->department);
        }
        
        $employee = $query->first();
            
        if (!$employee) {
            $this->dispatch('notify', message: 'Invalid employee selection!', type: 'error');
            $this->employee_id = null;
            $this->nik = null;
            $this->name = null;
            $this->department = null;
            return;
        }
        
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
        
        $this->employeeSearch = '';
        $this->showEmployeeDropdown = false;
        
        // Reset error
        $this->resetErrorBag('employee_id');
    }

    public function clearEmployee()
    {
        $this->employee_id = null;
        $this->nik = null;
        $this->name = null;
        $this->department = null;
        $this->status_display = null;
        $this->section = null;
        
        // Reset form validation
        $this->resetValidation();
    }

    private function toRomanNumeral($number)
    {
        $romanNumerals = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
        ];
        return $romanNumerals[$number] ?? '';
    }

    /**
     * Generate NCP Number dengan aturan khusus:
     * - Tahun 2026: dimulai dari 760
     * - Tahun 2027 dan seterusnya: reset ke 1
     * - Format: NCP/YY/MM/XXXX
     */
    private function generateNCPNumber()
    {
        $year = date('y');
        $fullYear = date('Y');
        $month = (int)date('m');
        $romanMonth = $this->toRomanNumeral($month);
        
        // Tentukan starting sequence berdasarkan tahun
        $startSequence = 1; // default untuk 2027+
        
        if ($fullYear == 2026) {
            // Tahun 2026 dimulai dari 760
            $startSequence = 760;
        }
        // Tahun lain (2027+) dimulai dari 1
        
        // Cari NCP terakhir di tahun yang sama
        $lastNCP = NCP::whereYear('created_at', $fullYear)
            ->whereNull('deleted_at')
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastNCP) {
            // Extract sequence number from last NCP number
            // Format: NCP/YY/MM/XXXX
            $parts = explode('/', $lastNCP->ncp_number);
            if (count($parts) >= 4) {
                $lastSequence = (int)end($parts);
                // Jika sequence terakhir kurang dari startSequence, gunakan startSequence
                $sequence = max($lastSequence + 1, $startSequence);
            } else {
                $sequence = $startSequence;
            }
        } else {
            $sequence = $startSequence;
        }
        
        // Check if sequence already exists (prevent duplicates)
        $exists = true;
        $attempts = 0;
        $maxAttempts = 10000; // Prevent infinite loop
        
        while ($exists && $attempts < $maxAttempts) {
            $ncpNumber = "NCP/{$year}/{$romanMonth}/" . str_pad($sequence, 3, '0', STR_PAD_LEFT);
            $exists = NCP::where('ncp_number', $ncpNumber)
                ->withTrashed()
                ->exists();
            
            if ($exists) {
                $sequence++;
            }
            $attempts++;
        }
        
        return "NCP/{$year}/{$romanMonth}/" . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function getTabCountsProperty()
    {
        $canViewAll = $this->canViewAll();
        $userDepartment = $this->getUserDepartment();
        $hasValidRecord = $this->hasValidEmployeeRecord();
        
        // If user doesn't have valid record, return all zeros
        if (!$hasValidRecord) {
            return [
                'all' => 0, 'open' => 0, 'in_progress' => 0, 
                'closed' => 0, 'rejected' => 0, 'deleted' => 0
            ];
        }
        
        // Base query untuk active records (tidak deleted)
        $baseQuery = NCP::query()->whereNull('deleted_at');
        // Query untuk deleted records
        $deletedQuery = NCP::onlyTrashed();
        
        // Filter berdasarkan department jika user tidak punya akses all
        if (!$canViewAll && $userDepartment) {
            $baseQuery->whereHas('employee', function ($empQuery) use ($userDepartment) {
                $empQuery->where('department', $userDepartment);
            });
            $deletedQuery->whereHas('employee', function ($empQuery) use ($userDepartment) {
                $empQuery->where('department', $userDepartment);
            });
        }
        
        return [
            'all' => (clone $baseQuery)->count(),
            'open' => (clone $baseQuery)->where('status', 'open')->count(),
            'in_progress' => (clone $baseQuery)->where('status', 'in_progress')->count(),
            'closed' => (clone $baseQuery)->where('status', 'closed')->count(),
            'rejected' => (clone $baseQuery)->where('status', 'rejected')->count(),
            'deleted' => (clone $deletedQuery)->count(),
        ];
    }

    public function save()
    {
        // Check if user has valid employee record
        $currentUserEmployee = $this->getCurrentUserEmployee();
        
        if (!$currentUserEmployee) {
            $this->dispatch('notify', message: 'You do not have a valid employee record!', type: 'error');
            return;
        }

        // Validasi employee_id harus diisi DAN valid
        if (empty($this->employee_id)) {
            $this->addError('employee_id', 'Please select an employee first!');
            $this->dispatch('notify', message: 'Please select an employee first!', type: 'error');
            return;
        }

        // Cek apakah employee_id yang dipilih valid
        $selectedEmployee = Employee::where('id', $this->employee_id)
            ->whereIn('status', [1, 2, 3])
            ->first();
            
        if (!$selectedEmployee) {
            $this->addError('employee_id', 'Selected employee is not active!');
            $this->dispatch('notify', message: 'Selected employee is not active!', type: 'error');
            $this->employee_id = null;
            $this->nik = null;
            $this->name = null;
            $this->department = null;
            return;
        }
        
        // Set employee data
        $this->nik = $selectedEmployee->nik;
        $this->name = $selectedEmployee->name;
        $this->department = $selectedEmployee->department;

        // Permission check
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

        // Validasi lainnya
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
            'failure_rate' => $this->failure_rate ?: null,
            'do_no' => $this->do_no,
            'packing_list_no' => $this->packing_list_no,
            'disposition' => $dispositionString,
            'defect_details' => !empty($this->defect_details) ? $this->defect_details : null,
        ];

        if ($this->ncp_id) {
            // EDIT MODE
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

            // Handle file upload
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
            // CREATE MODE
            $data['status'] = 'open';
            $data['ncp_number'] = $this->generateNCPNumber();
            $data['created_by'] = auth()->id();
            
            $ncp = NCP::create($data);

            // Handle file upload for new NCP
            if ($this->newFile) {
                $fileName = time() . '_' . $this->newFile->getClientOriginalName();
                $filePath = $this->newFile->storeAs('ncp-files', $fileName, 'public');
                $ncp->file = $filePath;
                $ncp->save();
            }

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

        // Check if user has valid employee record
        $currentUserEmployee = $this->getCurrentUserEmployee();
        
        if (!$currentUserEmployee) {
            $this->dispatch('notify', message: 'You do not have a valid employee record!', type: 'error');
            return;
        }

        $ncp = NCP::with('employee', 'approver')->find($id);

        if (!$ncp) {
            $this->dispatch('notify', message: 'NCP not found!', type: 'error');
            return;
        }

        // Validate that NCP belongs to same department (kecuali memiliki akses all)
        $canViewAll = $this->canViewAll();
        
        if (!$canViewAll && $ncp->employee && $ncp->employee->department !== $currentUserEmployee->department) {
            $this->dispatch('notify', message: 'You can only edit NCPs from your department!', type: 'error');
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

        $canViewAll = $this->canViewAll();
        $userDepartment = $this->getUserDepartment();
        $hasValidRecord = $this->hasValidEmployeeRecord();
        
        $query = NCP::with(['employee' => function($query) {
                $query->select('id', 'nik', 'name', 'department');
            }, 'creator' => function($query) {
                $query->select('id', 'name');
            }, 'approver' => function($query) {
                $query->select('id', 'name');
            }, 'deleter' => function($query) {
                $query->select('id', 'name');
            }]);
        
        // If user doesn't have valid employee record, show empty
        if (!$hasValidRecord) {
            $query->whereRaw('1 = 0');
        } 
        // Apply department filter for non-admin users
        elseif (!$canViewAll && $userDepartment) {
            $query->whereHas('employee', function ($empQuery) use ($userDepartment) {
                $empQuery->where('department', $userDepartment);
            });
        }
        // Jika memiliki akses all, tidak ada filter department
        
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
        
        // Apply search filter - UPDATED untuk mencari berdasarkan NIK dan Name
        if ($this->search) {
            $query->where(function($q) {
                $q->where('ncp_number', 'like', '%' . $this->search . '%')
                    ->orWhere('section', 'like', '%' . $this->search . '%')
                    ->orWhere('remarks', 'like', '%' . $this->search . '%')
                    ->orWhere('part_number', 'like', '%' . $this->search . '%')
                    ->orWhere('part_description', 'like', '%' . $this->search . '%')
                    // Tambahkan pencarian berdasarkan NIK dan Name melalui relasi employee
                    ->orWhereHas('employee', function($empQuery) {
                        $empQuery->where('nik', 'like', '%' . $this->search . '%')
                            ->orWhere('name', 'like', '%' . $this->search . '%');
                    });
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
            'hasValidRecord' => $hasValidRecord,
            'userDepartment' => $userDepartment,
        ]);
    }
}