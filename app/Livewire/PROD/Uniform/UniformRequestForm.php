<?php

namespace App\Livewire\PROD\Uniform;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PROD\Uniform\UniformRequest;
use App\Models\PROD\Uniform\MasterUniform;
use App\Models\PROD\Uniform\UniformStockTransaction;
use App\Models\PROD\Uniform\UniformRequestLock;
use App\Models\HR\Employee;
use App\Mail\PROD\UniformRequestCreatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithFileUploads;

class UniformRequestForm extends Component
{
    use WithPagination, WithFileUploads;

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
    
    // Lock properties
    public $lockAcquired = false;
    public $lockOwner = null;
    public $lockCheckInterval = 30; // detik

    public $manualTanggalPemberkasan = '';
    public $manualDoj = '';
    public $manualReasonType = 'new_employee'; // Default untuk manual
    public $manualDepartmentOptions = [];
    public $manualDepartmentSearch = '';
    public $manualDepartmentSelected = '';
    public $manualDepartmentDropdownOpen = false;
    public $canManual = false;

    public $lockExpiresAt = null;

    protected $listeners = [
        'refreshUniformPage' => '$refresh',
        'checkLockStatus' => 'checkLockStatus'
    ];

    public $current_reason_type = 'pergantian';
    public $current_reason_file = null;

    protected $rules = [
        'rows' => 'required|array|min:1',
        'rows.*.employee_id' => 'nullable|exists:tb_hr_employee,id',
        'rows.*.master_uniform_id' => 'required|exists:tb_prod_master_uniform,id',
        'rows.*.qty' => 'required|integer|min:1',
        'rows.*.reason' => 'nullable|string',
        'rows.*.reason_type' => 'required|in:ng_esd,pergantian,new_employee',
        'rows.*.reason_file' => 'nullable|string',
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

    // ==================== LOCK FUNCTIONS ====================

    public function acquireLock()
    {
        if ($this->requestId) {
            return $this->acquireEditLock();
        } else {
            return $this->acquireCreateLock();
        }
    }

    private function acquireEditLock()
    {
        // Hapus lock yang expired
        UniformRequestLock::where('expires_at', '<', now())->delete();

        $existingLock = UniformRequestLock::where('request_id', $this->requestId)
            ->where('expires_at', '>', now())
            ->first();

        $sessionId = Session::getId();
        $userId = auth()->user()->id;
        $userName = auth()->user()->name;

        if ($existingLock) {
            if ($existingLock->session_id === $sessionId) {
                $this->lockAcquired = true;
                $this->lockOwner = $existingLock->user_name;
                $this->lockExpiresAt = $existingLock->expires_at; // SET DARI DATABASE
                return true;
            }

            $this->lockAcquired = false;
            $this->lockOwner = $existingLock->user_name;
            $this->lockExpiresAt = $existingLock->expires_at; // SET DARI DATABASE
            
            $this->dispatch('lockTaken', [
                'owner' => $existingLock->user_name,
                'expires_at' => $existingLock->expires_at->format('H:i:s')
            ]);
            
            return false;
        }

        // Tidak ada lock, buat lock baru
        $expiresAt = now()->addMinutes(10);
        
        UniformRequestLock::create([
            'request_id' => $this->requestId,
            'user_id' => $userId,
            'user_name' => $userName,
            'locked_at' => now(),
            'expires_at' => $expiresAt,
            'session_id' => $sessionId,
        ]);

        $this->lockAcquired = true;
        $this->lockOwner = $userName;
        $this->lockExpiresAt = $expiresAt; // SET DARI YANG BARU DIBUAT
        return true;
    }

    private function acquireCreateLock()
    {
        // Hapus lock yang expired
        UniformRequestLock::where('expires_at', '<', now())->delete();

        $existingLock = UniformRequestLock::whereNull('request_id')
            ->where('expires_at', '>', now())
            ->first();

        $sessionId = Session::getId();
        $userId = auth()->user()->id;
        $userName = auth()->user()->name;

        if ($existingLock) {
            if ($existingLock->session_id === $sessionId) {
                $this->lockAcquired = true;
                $this->lockOwner = $existingLock->user_name;
                $this->lockExpiresAt = $existingLock->expires_at; // SET DARI DATABASE
                return true;
            }

            $this->lockAcquired = false;
            $this->lockOwner = $existingLock->user_name;
            $this->lockExpiresAt = $existingLock->expires_at; // SET DARI DATABASE
            
            $this->dispatch('lockTaken', [
                'owner' => $existingLock->user_name,
                'expires_at' => $existingLock->expires_at->format('H:i:s')
            ]);
            
            return false;
        }

        // Tidak ada lock, buat lock baru
        $expiresAt = now()->addMinutes(10);
        
        UniformRequestLock::create([
            'request_id' => null,
            'user_id' => $userId,
            'user_name' => $userName,
            'locked_at' => now(),
            'expires_at' => $expiresAt,
            'session_id' => $sessionId,
        ]);

        $this->lockAcquired = true;
        $this->lockOwner = $userName;
        $this->lockExpiresAt = $expiresAt; // SET DARI YANG BARU DIBUAT
        return true;
    }

    public function releaseLock()
    {
        $sessionId = Session::getId();
        
        UniformRequestLock::where('session_id', $sessionId)
            ->where(function($query) {
                if ($this->requestId) {
                    $query->where('request_id', $this->requestId);
                } else {
                    $query->whereNull('request_id');
                }
            })
            ->delete();
        
        $this->lockAcquired = false;
        $this->lockOwner = null;
    }

    public function checkLockStatus()
    {
        // Hapus lock yang expired
        UniformRequestLock::where('expires_at', '<', now())->delete();

        $sessionId = Session::getId();

        if ($this->requestId) {
            $lock = UniformRequestLock::where('request_id', $this->requestId)
                ->where('expires_at', '>', now())
                ->first();
        } else {
            $lock = UniformRequestLock::whereNull('request_id')
                ->where('expires_at', '>', now())
                ->first();
        }

        if ($lock) {
            // SELALU set lockExpiresAt dari database
            $this->lockExpiresAt = $lock->expires_at;
            
            if ($lock->session_id === $sessionId) {
                $this->lockAcquired = true;
                $this->lockOwner = $lock->user_name;
                return true;
            } else {
                $this->lockAcquired = false;
                $this->lockOwner = $lock->user_name;
                return false;
            }
        } else {
            // Jika tidak ada lock sama sekali, coba ambil
            if ($this->lockAcquired) {
                // Jika sebelumnya acquired tapi sekarang tidak ada lock, berarti expired
                $this->lockAcquired = false;
                $this->lockOwner = null;
                $this->lockExpiresAt = null;
            }
            return false;
        }
    }

    // ==================== END LOCK FUNCTIONS ====================

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

    public function getAvailableUniformsProperty()
    {
        $existingUniformIds = collect($this->current_uniforms)->pluck('master_uniform_id')->toArray();
        
        $cartQtyMap = [];
        foreach ($this->current_uniforms as $item) {
            $cartQtyMap[$item['master_uniform_id']] = ($cartQtyMap[$item['master_uniform_id']] ?? 0) + $item['qty'];
        }
        
        $requestQtyMap = [];
        foreach ($this->rows as $row) {
            $requestQtyMap[$row['master_uniform_id']] = ($requestQtyMap[$row['master_uniform_id']] ?? 0) + $row['qty'];
        }
        
        $query = MasterUniform::query()
            ->where('qty', '>=', 0)
            ->orderBy('item_code');
        
        if ($this->uniformSearch) {
            $query->where(function($q) {
                $q->where('item_code', 'like', '%' . $this->uniformSearch . '%')
                    ->orWhere('description', 'like', '%' . $this->uniformSearch . '%')
                    ->orWhere('size', 'like', '%' . $this->uniformSearch . '%');
            });
        }
        
        if (!empty($existingUniformIds)) {
            $query->whereNotIn('id', $existingUniformIds);
        }
        
        // Gunakan paginate dengan page name 'uniformPage'
        $uniforms = $query->paginate($this->uniformPerPage, ['*'], 'uniformPage', $this->uniformPage);
        
        // Proses setiap uniform untuk menambahkan available_qty
        foreach ($uniforms as $uniform) {
            $reservedQty = ($cartQtyMap[$uniform->id] ?? 0) + ($requestQtyMap[$uniform->id] ?? 0);
            $availableQty = $uniform->qty - $reservedQty;
            
            $uniform->available_qty = max($availableQty, 0);
            $uniform->reserved_qty = $reservedQty;
            $uniform->has_stock = $uniform->qty > 0;
        }
        
        return $uniforms;
    }

    // Tambahkan method untuk pagination
    public function previousPage()
    {
        if ($this->uniformPage > 1) {
            $this->uniformPage--;
        }
    }

    public function nextPage()
    {
        $this->uniformPage++;
    }

    public function gotoPage($page)
    {
        $this->uniformPage = (int) $page;
        // Refresh data
        $this->dispatch('refreshUniformPage');
    }

    public function mount($id = null)
    {
        $this->current_request_date = date('Y-m-d');
        $this->current_uniforms = [];
        $this->current_master_uniform_id = null;
        
        // Set canManual
        $this->canManual = auth()->user()->can('feedback uniform request admin');
        
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
                // ==================== LOAD DATA ====================
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
                        'status' => $uniform->status ?? 'Manual',
                        'qty' => $item['qty'],
                        'reason' => $item['reason'],
                        'reason_type' => $item['reason_type'] ?? 'others',
                        'reason_file' => $item['reason_file'] ?? null,
                        'reason_file_name' => $item['reason_file_name'] ?? null,
                        'group' => $item['group'],
                        'request_date' => $item['request_date'],
                        'remarks' => $item['remarks'],
                        'admin_feedback' => $item['admin_feedback'] ?? null,
                        'admin_feedback_datetime' => $item['admin_feedback_datetime'] ?? null,
                        'manual_nik' => $item['manual_nik'] ?? null,
                        'manual_name' => $item['manual_name'] ?? null,
                        'manual_department' => $item['manual_department'] ?? null,
                        'manual_tanggal_pemberkasan' => $item['manual_tanggal_pemberkasan'] ?? null,
                        'manual_doj' => $item['manual_doj'] ?? null,
                        'is_manual' => $item['is_manual'] ?? false,
                    ];
                }
                
                // ==================== AUTO SET MODE BERDASARKAN DATA ====================
                // Cek apakah ada data manual di rows
                $hasManual = false;
                $hasNormal = false;
                
                foreach ($this->rows as $row) {
                    if (isset($row['is_manual']) && $row['is_manual']) {
                        $hasManual = true;
                    } else {
                        $hasNormal = true;
                    }
                }
                
                // Jika ada data manual dan admin, set mode ke manual
                if ($hasManual && $this->canManual) {
                    $this->isManualInput = true;
                    $this->current_reason_type = 'new_employee';
                    $this->manualNik = '-';
                    $this->manualTanggalPemberkasan = date('Y-m-d');
                    $this->manualDoj = date('Y-m-d');
                    
                    // Refresh department options
                    $excludedDepartments = [
                        'Executive Officer',
                        'OS',
                        'President Director',
                        'TRAINING'
                    ];

                    $this->manualDepartmentOptions = Employee::whereIn('status', [1, 2, 3])
                        ->whereNotNull('department')
                        ->whereNotIn('department', $excludedDepartments)
                        ->distinct()
                        ->pluck('department')
                        ->sort()
                        ->values()
                        ->toArray();
                } 
                // Jika ada data normal dan tidak ada manual
                elseif ($hasNormal && !$hasManual) {
                    $this->isManualInput = false;
                    $this->current_reason_type = 'pergantian';
                    $this->manualNik = '';
                    $this->manualName = '';
                    $this->manualDepartment = '';
                    $this->manualTanggalPemberkasan = '';
                    $this->manualDoj = '';
                }
                // Jika ada keduanya (seharusnya tidak terjadi)
                elseif ($hasManual && $hasNormal) {
                    // Prioritaskan manual jika admin
                    if ($this->canManual) {
                        $this->isManualInput = true;
                        $this->current_reason_type = 'new_employee';
                    } else {
                        $this->isManualInput = false;
                        $this->current_reason_type = 'pergantian';
                    }
                }
                // ==================== END AUTO SET MODE ====================
            }
        }

        // ==================== LOCK CHECK ====================
        $sessionId = Session::getId();
        
        // Hapus lock yang expired
        UniformRequestLock::where('expires_at', '<', now())->delete();
        
        // ==================== CEK LOCK UNTUK CREATE MODE ====================
        // Jika ini adalah create mode (id = null), cek apakah ada lock dari user lain
        if (!$id) {
            $otherLock = UniformRequestLock::whereNull('request_id')
                ->where('session_id', '!=', $sessionId)
                ->where('expires_at', '>', now())
                ->first();
            
            if ($otherLock) {
                session()->flash('error', '⚠️ Form create sedang digunakan oleh: ' . $otherLock->user_name . '. Silakan tunggu hingga selesai.');
                return redirect()->route('prod.uniform.request.index');
            }
        }
        // ==================== END CEK LOCK UNTUK CREATE MODE ====================
        
        // Cek lock untuk session ini (edit atau create)
        if ($id) {
            // Edit mode
            $lock = UniformRequestLock::where('request_id', $id)
                ->where('session_id', $sessionId)
                ->where('expires_at', '>', now())
                ->first();
        } else {
            // Create mode
            $lock = UniformRequestLock::whereNull('request_id')
                ->where('session_id', $sessionId)
                ->where('expires_at', '>', now())
                ->first();
        }
        
        if ($lock) {
            // Lock milik sendiri, lanjutkan
            $this->lockAcquired = true;
            $this->lockOwner = $lock->user_name;
            $this->lockExpiresAt = $lock->expires_at;
        } else {
            // Cek apakah ada lock dari user lain (untuk edit mode)
            if ($id) {
                $otherLock = UniformRequestLock::where('request_id', $id)
                    ->where('session_id', '!=', $sessionId)
                    ->where('expires_at', '>', now())
                    ->first();
            } else {
                $otherLock = UniformRequestLock::whereNull('request_id')
                    ->where('session_id', '!=', $sessionId)
                    ->where('expires_at', '>', now())
                    ->first();
            }
            
            if ($otherLock) {
                // Lock dimiliki user lain
                $this->lockAcquired = false;
                $this->lockOwner = $otherLock->user_name;
                $this->lockExpiresAt = $otherLock->expires_at;
                
                session()->flash('error', '⚠️ Form ini sedang digunakan oleh: ' . $otherLock->user_name . '. Silakan tunggu hingga selesai.');
                return redirect()->route('prod.uniform.request.index');
            }
            
            // Tidak ada lock sama sekali, buat lock baru
            $userId = auth()->user()->id;
            $userName = auth()->user()->name;
            $expiresAt = now()->addMinutes(10);
            
            UniformRequestLock::create([
                'request_id' => $id, // null untuk create, id untuk edit
                'user_id' => $userId,
                'user_name' => $userName,
                'locked_at' => now(),
                'expires_at' => $expiresAt,
                'session_id' => $sessionId,
            ]);
            
            $this->lockAcquired = true;
            $this->lockOwner = $userName;
            $this->lockExpiresAt = $expiresAt;
        }
        // ==================== END LOCK CHECK ====================

        $this->dispatch('startLockCheck', [
            'interval' => $this->lockCheckInterval
        ]);

        $this->refreshDepartmentOptions();
    }

    public function refreshDepartmentOptions()
    {
        // Daftar department yang akan disembunyikan
        $excludedDepartments = [
            'Executive Officer',
            'OS',
            'President Director',
            'TRAINING'
        ];

        $this->manualDepartmentOptions = Employee::whereIn('status', [1, 2, 3])
            ->whereNotNull('department')
            ->whereNotIn('department', $excludedDepartments) // Tambahkan filter ini
            ->distinct()
            ->pluck('department')
            ->sort()
            ->values()
            ->toArray();
    }

    public function selectManualDepartment($department)
    {
        $this->manualDepartment = $department;
        $this->manualDepartmentSelected = $department;
        $this->manualDepartmentSearch = $department;
        $this->manualDepartmentDropdownOpen = false;
    }

    public function toggleManualInput()
    {
        // Cek apakah sudah ada data di rows
        if (count($this->rows) > 0) {
            $existingType = $this->getExistingInputType();
            
            if ($existingType === 'manual' && !$this->isManualInput) {
                // Sudah ada data manual, force ke mode manual
                $this->isManualInput = true;
                $this->current_employee_id = null;
                $this->employeeSearch = '';
                $this->manualNik = '-';
                $this->manualTanggalPemberkasan = date('Y-m-d');
                $this->manualDoj = date('Y-m-d');
                $this->current_reason_type = 'new_employee';
                
                // Refresh department options
                $excludedDepartments = [
                    'Executive Officer',
                    'OS',
                    'President Director',
                    'TRAINING'
                ];

                $this->manualDepartmentOptions = Employee::whereIn('status', [1, 2, 3])
                    ->whereNotNull('department')
                    ->whereNotIn('department', $excludedDepartments)
                    ->distinct()
                    ->pluck('department')
                    ->sort()
                    ->values()
                    ->toArray();
                
                session()->flash('info', 'Mode otomatis berubah ke New Employee karena sudah ada data New Employee.');
                return;
            }
            
            if ($existingType === 'normal' && $this->isManualInput) {
                // Sudah ada data normal, force ke mode normal
                $this->isManualInput = false;
                $this->manualNik = '';
                $this->manualName = '';
                $this->manualDepartment = '';
                $this->manualDepartmentSearch = '';
                $this->manualDepartmentSelected = '';
                $this->manualTanggalPemberkasan = '';
                $this->manualDoj = '';
                $this->current_reason_type = 'pergantian';
                $this->manualDepartmentDropdownOpen = false;
                
                session()->flash('info', 'Mode otomatis berubah ke Normal karena sudah ada data normal (Pergantian/NG ESD).');
                return;
            }
            
            if ($existingType === 'manual' && $this->isManualInput) {
                // Sudah di mode manual, tidak perlu melakukan apa-apa
                return;
            }
            
            if ($existingType === 'normal' && !$this->isManualInput) {
                // Sudah di mode normal, tidak perlu melakukan apa-apa
                return;
            }
        }
        
        // Jika tidak ada data, lanjutkan toggle seperti biasa
        $this->isManualInput = !$this->isManualInput;
        if ($this->isManualInput) {
            $this->current_employee_id = null;
            $this->employeeSearch = '';
            $this->manualNik = '-';
            $this->manualTanggalPemberkasan = date('Y-m-d');
            $this->manualDoj = date('Y-m-d');
            $this->current_reason_type = 'new_employee';
            
            $excludedDepartments = [
                'Executive Officer',
                'OS',
                'President Director',
                'TRAINING'
            ];

            $this->manualDepartmentOptions = Employee::whereIn('status', [1, 2, 3])
                ->whereNotNull('department')
                ->whereNotIn('department', $excludedDepartments)
                ->distinct()
                ->pluck('department')
                ->sort()
                ->values()
                ->toArray();
        } else {
            $this->manualNik = '';
            $this->manualName = '';
            $this->manualDepartment = '';
            $this->manualDepartmentSearch = '';
            $this->manualDepartmentSelected = '';
            $this->manualTanggalPemberkasan = '';
            $this->manualDoj = '';
            $this->current_reason_type = 'pergantian';
            $this->manualDepartmentDropdownOpen = false;
        }
    }

    /**
     * Cek apakah sudah ada data manual di rows
     */
    public function hasManualRows()
    {
        foreach ($this->rows as $row) {
            if (isset($row['is_manual']) && $row['is_manual']) {
                return true;
            }
        }
        return false;
    }

    /**
     * Cek apakah sudah ada data normal di rows
     */
    public function hasNormalRows()
    {
        foreach ($this->rows as $row) {
            if (!isset($row['is_manual']) || !$row['is_manual']) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get jenis input yang sudah ada di rows
     * @return string|null 'manual' atau 'normal' atau null
     */
    public function getExistingInputType()
    {
        $hasManual = $this->hasManualRows();
        $hasNormal = $this->hasNormalRows();
        
        if ($hasManual && $hasNormal) {
            return 'mixed'; // Mixed - tidak boleh terjadi
        } elseif ($hasManual) {
            return 'manual';
        } elseif ($hasNormal) {
            return 'normal';
        }
        return null; // Belum ada data
    }

    public function getFilteredDepartmentOptionsProperty()
    {
        // Daftar department yang akan disembunyikan
        $excludedDepartments = [
            'Executive Officer',
            'OS',
            'President Director',
            'TRAINING'
        ];

        // Filter options yang sudah di-exclude
        $filteredOptions = array_filter($this->manualDepartmentOptions, function($dept) use ($excludedDepartments) {
            return !in_array($dept, $excludedDepartments);
        });

        if (empty($this->manualDepartmentSearch)) {
            return array_values($filteredOptions);
        }
        
        $search = strtolower($this->manualDepartmentSearch);
        $searchFiltered = array_filter($filteredOptions, function($dept) use ($search) {
            return str_contains(strtolower($dept), $search);
        });
        
        return array_values($searchFiltered);
    }

    public function validateReason($row)
    {
        if ($row['reason_type'] === 'ng_esd' && empty($row['reason_file'])) {
            $this->addError('rows.*.reason_file', 'PDF file is required for NG ESD reason.');
            return false;
        }
        if ($row['reason_type'] === 'others' && empty($row['reason'])) {
            $this->addError('rows.*.reason', 'Reason text is required for Others.');
            return false;
        }
        return true;
    }

    public function addUniformToCurrent()
    {
        // Validasi dasar
        $this->validate([
            'current_master_uniform_id' => 'required|exists:tb_prod_master_uniform,id',
            'current_qty' => 'required|integer|min:1',
            'current_remarks' => 'nullable|string',
        ]);

        // ==================== CEK MODE MANUAL ====================
        // Cek dari isManualInput
        $isManualMode = $this->isManualInput;
        
        // Cek dari rows (data yang sudah tersimpan)
        if (!$isManualMode) {
            $isManualMode = $this->hasManualRows();
        }
        
        // Cek dari current_uniforms (cart) - apakah ada item new_employee
        if (!$isManualMode) {
            foreach ($this->current_uniforms as $item) {
                if (isset($item['reason_type']) && $item['reason_type'] === 'new_employee') {
                    $isManualMode = true;
                    break;
                }
            }
        }
        // ==================== END CEK MODE MANUAL ====================

        // Validasi berdasarkan mode
        if ($isManualMode && $this->canManual) {
            // Mode manual: reason_type otomatis new_employee
            $this->current_reason_type = 'new_employee';
        } else {
            // Mode normal: validasi reason_type
            $this->validate([
                'current_reason_type' => 'required|in:pergantian,ng_esd',
            ]);
            
            if ($this->current_reason_type === 'pergantian') {
                $this->validate([
                    'current_reason' => 'required|string|min:3',
                ], [
                    'current_reason.required' => 'Alasan pergantian wajib diisi.',
                    'current_reason.min' => 'Alasan pergantian minimal 3 karakter.',
                ]);
            } else {
                $this->validate([
                    'current_reason_file' => 'required|file|mimes:pdf|max:5120',
                ], [
                    'current_reason_file.required' => 'File PDF wajib diupload untuk alasan NG ESD.',
                    'current_reason_file.mimes' => 'File harus berformat PDF.',
                    'current_reason_file.max' => 'Ukuran file maksimal 5MB.',
                ]);
            }
        }

        $uniform = MasterUniform::find($this->current_master_uniform_id);
        if (!$uniform) {
            session()->flash('error', 'Uniform tidak ditemukan!');
            return;
        }

        if ($uniform->qty < $this->current_qty) {
            session()->flash('error', 'Stok tidak mencukupi! Tersedia: ' . $uniform->qty . ', Diminta: ' . $this->current_qty);
            return;
        }

        $exists = collect($this->current_uniforms)->contains('master_uniform_id', $this->current_master_uniform_id);
        if ($exists) {
            session()->flash('error', 'Uniform ini sudah ditambahkan untuk karyawan ini!');
            return;
        }

        // Simpan file jika NG ESD
        $filePath = null;
        $fileName = null;
        if ($this->current_reason_type === 'ng_esd' && $this->current_reason_file) {
            try {
                $filePath = $this->current_reason_file->store('uniform-reason-files', 'public');
                $fileName = $this->current_reason_file->getClientOriginalName();
            } catch (\Exception $e) {
                session()->flash('error', 'Gagal upload file: ' . $e->getMessage());
                return;
            }
        }

        $this->current_uniforms[] = [
            'master_uniform_id' => $this->current_master_uniform_id,
            'item_code' => $uniform->item_code ?? '-',
            'description' => $uniform->description ?? '-',
            'size' => $uniform->size ?? '-',
            'status' => $uniform->status ?? 'Manual',
            'qty' => $this->current_qty,
            'reason' => $this->current_reason_type === 'pergantian' ? $this->current_reason : null,
            'reason_type' => $this->current_reason_type,
            'reason_file' => $filePath,
            'reason_file_name' => $fileName,
            'remarks' => $this->current_remarks,
            'stock_available' => $uniform->qty,
        ];

        $this->current_master_uniform_id = null;
        $this->current_qty = 1;
        $this->current_reason = '';
        if (!$this->isManualInput) {
            $this->current_reason_type = 'pergantian';
        }
        $this->current_reason_file = null;
        $this->current_remarks = '';
        $this->uniformSearch = '';

        session()->flash('success', 'Uniform "' . $uniform->item_code . '" berhasil ditambahkan!');
    }

    public function updatedCurrentUniforms()
    {
        $this->dispatch('debugUniformCount', ['count' => count($this->current_uniforms)]);
    }

    public function removeUniformFromCurrent($index)
    {
        unset($this->current_uniforms[$index]);
        $this->current_uniforms = array_values($this->current_uniforms);
        $this->uniformPage = 1;
    }

    public function addRow()
    {
        $isAdmin = auth()->user()->can('feedback uniform request admin');

        // ==================== CEK MODE MANUAL ====================
        $isManualMode = $this->isManualInput || $this->hasManualRows();
        
        // Cek dari current_uniforms (cart)
        if (!$isManualMode) {
            foreach ($this->current_uniforms as $item) {
                if (isset($item['reason_type']) && $item['reason_type'] === 'new_employee') {
                    $isManualMode = true;
                    break;
                }
            }
        }
        // ==================== END CEK MODE MANUAL ====================

        // ==================== VALIDASI KONSISTENSI INPUT ====================
        // Hanya validasi jika ada data di rows DAN mode tidak sesuai
        if (count($this->rows) > 0) {
            $existingType = $this->getExistingInputType();
            
            // Jika ada data manual di rows, tapi user mencoba menambah dengan mode normal
            if ($existingType === 'manual' && !$isManualMode) {
                session()->flash('error', '⚠️ Tidak dapat menambahkan data normal (Pergantian/NG ESD) karena sudah ada data New Employee. Silakan hapus data New Employee terlebih dahulu atau gunakan mode New Employee.');
                return;
            }
            
            // Jika ada data normal di rows, tapi user mencoba menambah dengan mode manual
            if ($existingType === 'normal' && $isManualMode) {
                session()->flash('error', '⚠️ Tidak dapat menambahkan New Employee karena sudah ada data normal (Pergantian/NG ESD). Silakan hapus data normal terlebih dahulu atau gunakan mode normal.');
                return;
            }
        }
        // ==================== END VALIDASI ====================

        // Jika mode manual aktif, set $this->isManualInput = true untuk validasi
        if ($isManualMode && $isAdmin) {
            $this->isManualInput = true;
        }

        if ($isManualMode && $isAdmin) {
            $this->validate([
                'manualName' => 'required|string|max:100',
                'manualDepartment' => 'required|string|max:100',
                'manualTanggalPemberkasan' => 'required|date',
                'manualDoj' => 'required|date',
                'current_uniforms' => 'required|array|min:1',
                'current_group' => 'required|string|max:100',
                'current_request_date' => 'required|date',
            ], [
                'manualName.required' => 'Nama wajib diisi untuk input manual.',
                'manualDepartment.required' => 'Department wajib diisi untuk input manual.',
                'manualTanggalPemberkasan.required' => 'Tanggal Pemberkasan wajib diisi.',
                'manualDoj.required' => 'DOJ / Tanggal Join wajib diisi.',
                'current_uniforms.min' => 'Silakan tambahkan minimal 1 uniform ke keranjang.',
                'current_group.required' => 'Group wajib dipilih.',
            ]);
        } else {
            $this->validate([
                'current_employee_id' => 'required|exists:tb_hr_employee,id',
                'current_uniforms' => 'required|array|min:1',
                'current_group' => 'required|string|max:100',
                'current_request_date' => 'required|date',
            ], [
                'current_employee_id.required' => 'Silakan pilih karyawan terlebih dahulu.',
                'current_uniforms.min' => 'Silakan tambahkan minimal 1 uniform ke keranjang.',
                'current_group.required' => 'Group wajib dipilih.',
            ]);
        }

        // Validasi untuk current_uniforms
        foreach ($this->current_uniforms as $index => $uniformItem) {
            if ($isManualMode && $isAdmin) {
                continue;
            }
            
            if ($uniformItem['reason_type'] === 'ng_esd') {
                if (empty($uniformItem['reason_file'])) {
                    session()->flash('error', 'File PDF wajib diupload untuk alasan NG ESD pada item: ' . $uniformItem['item_code']);
                    return;
                }
            } elseif ($uniformItem['reason_type'] === 'pergantian') {
                if (empty($uniformItem['reason'])) {
                    session()->flash('error', 'Alasan pergantian wajib diisi untuk item: ' . $uniformItem['item_code']);
                    return;
                }
            }
        }

        $employee = null;
        $isManual = false;
        $employeeData = [];

        if ($isManualMode && $isAdmin) {
            $isManual = true;
            $employeeData = [
                'nik' => trim($this->manualNik) ?: '-',
                'name' => trim($this->manualName),
                'department' => trim($this->manualDepartment),
                'tanggal_pemberkasan' => $this->manualTanggalPemberkasan,
                'doj' => $this->manualDoj,
            ];
        } else {
            $employee = Employee::find($this->current_employee_id);

            if (!$employee) {
                session()->flash('error', 'Karyawan tidak ditemukan!');
                return;
            }

            if (!in_array($employee->status, [1, 2, 3])) {
                session()->flash('error', 'Karyawan ' . $employee->nik . ' - ' . $employee->name . ' tidak aktif!');
                return;
            }

            $isOneUser = auth()->user()->can('view uniform request one user');
            $isFullAccess = auth()->user()->can('view uniform request');

            if ($isOneUser && !$isFullAccess && $this->userDepartment) {
                if ($employee->department !== $this->userDepartment) {
                    session()->flash('error', 'Anda hanya dapat memilih karyawan dari department anda: ' . $this->userDepartment);
                    return;
                }
            }
        }

        $addedCount = 0;
        foreach ($this->current_uniforms as $uniformItem) {
            if ($isManual) {
                $rowData = [
                    'master_uniform_id' => $uniformItem['master_uniform_id'],
                    'item_code' => $uniformItem['item_code'],
                    'description' => $uniformItem['description'],
                    'size' => $uniformItem['size'],
                    'status' => $uniformItem['status'] ?? 'Manual',
                    'qty' => $uniformItem['qty'],
                    'reason' => null,
                    'reason_type' => 'new_employee',
                    'reason_file' => null,
                    'reason_file_name' => null,
                    'group' => $this->current_group,
                    'request_date' => $this->current_request_date,
                    'remarks' => $uniformItem['remarks'] ?? null,
                    'admin_feedback' => null,
                    'admin_feedback_datetime' => null,
                ];
            } else {
                $rowData = [
                    'master_uniform_id' => $uniformItem['master_uniform_id'],
                    'item_code' => $uniformItem['item_code'],
                    'description' => $uniformItem['description'],
                    'size' => $uniformItem['size'],
                    'status' => $uniformItem['status'] ?? 'Manual',
                    'qty' => $uniformItem['qty'],
                    'reason' => $uniformItem['reason_type'] === 'ng_esd' 
                        ? null 
                        : ($uniformItem['reason'] ?? 'Pergantian'),
                    'reason_type' => $uniformItem['reason_type'],
                    'reason_file' => $uniformItem['reason_file'] ?? null,
                    'reason_file_name' => $uniformItem['reason_file_name'] ?? null,
                    'group' => $this->current_group,
                    'request_date' => $this->current_request_date,
                    'remarks' => $uniformItem['remarks'] ?? null,
                    'admin_feedback' => null,
                    'admin_feedback_datetime' => null,
                ];
            }

            if ($isManual) {
                $rowData['employee_id'] = null;
                $rowData['employee_nik'] = $employeeData['nik'];
                $rowData['employee_name'] = $employeeData['name'];
                $rowData['employee_department'] = $employeeData['department'];
                $rowData['manual_nik'] = $employeeData['nik'];
                $rowData['manual_name'] = $employeeData['name'];
                $rowData['manual_department'] = $employeeData['department'];
                $rowData['manual_tanggal_pemberkasan'] = $employeeData['tanggal_pemberkasan'];
                $rowData['manual_doj'] = $employeeData['doj'];
                $rowData['is_manual'] = true;
            } else {
                $rowData['employee_id'] = $employee->id;
                $rowData['employee_nik'] = $employee->nik ?? '-';
                $rowData['employee_name'] = $employee->name ?? '-';
                $rowData['employee_department'] = $employee->department ?? '-';
                $rowData['manual_nik'] = null;
                $rowData['manual_name'] = null;
                $rowData['manual_department'] = null;
                $rowData['manual_tanggal_pemberkasan'] = null;
                $rowData['manual_doj'] = null;
                $rowData['is_manual'] = false;
            }

            $this->rows[] = $rowData;
            $addedCount++;
        }
        
        $this->current_employee_id = null;
        $this->current_master_uniform_id = null;
        $this->current_qty = 1;
        $this->current_uniforms = [];
        $this->current_reason = '';
        $this->current_reason_type = 'pergantian';
        $this->current_reason_file = null;
        $this->current_group = '';
        $this->current_request_date = date('Y-m-d');
        $this->current_remarks = '';
        $this->employeeSearch = '';
        $this->uniformSearch = '';
        
        // HANYA RESET JIKA TIDAK ADA DATA DI ROWS
        if (count($this->rows) == 0) {
            $this->isManualInput = false;
            $this->manualNik = '-';
            $this->manualName = '';
            $this->manualDepartment = '';
            $this->manualTanggalPemberkasan = '';
            $this->manualDoj = '';
        }

        $this->resetPage();

        $employeeName = $isManual ? $employeeData['name'] : $employee->name;
        session()->flash('success', $addedCount . ' uniform(s) berhasil ditambahkan untuk karyawan: ' . $employeeName . '!');
    }

    // public function updatedCurrentReasonFile()
    // {
    //     \Log::info('=== FILE UPLOAD DETECTED ===');
    //     if ($this->current_reason_file) {
    //         \Log::info('File name: ' . $this->current_reason_file->getClientOriginalName());
    //         \Log::info('File size: ' . $this->current_reason_file->getSize());
    //         \Log::info('File mime: ' . $this->current_reason_file->getMimeType());
    //         \Log::info('File is valid: ' . ($this->current_reason_file->isValid() ? 'YES' : 'NO'));
    //     } else {
    //         \Log::info('File is NULL - upload failed?');
    //     }
    // }

    public function removeRow($index)
    {
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $this->perPage;
        $realIndex = $offset + $index;
        
        $row = $this->rows[$realIndex] ?? null;
        
        if ($row && $this->requestId) {
            $uniform = MasterUniform::find($row['master_uniform_id']);
            if ($uniform) {
                $oldQty = $uniform->qty;
                $newQty = $oldQty + $row['qty'];
                
                $uniform->qty = $newQty;
                $uniform->save();
                
                UniformStockTransaction::create([
                    'master_uniform_id' => $uniform->id,
                    'transaction_type' => 'IN',
                    'qty_change' => $row['qty'],
                    'qty_before' => $oldQty,
                    'qty_after' => $newQty,
                    'reference_id' => 'rollback_' . $this->requestId,
                    'reference_type' => 'uniform_request_rollback',
                    'description' => 'Rollback delete item: ' . $row['item_code'] . ' - Request: ' . $this->requestId,
                    'performed_by' => auth()->user()->name,
                    'performed_at' => now(),
                ]);
            }
        }
        
        unset($this->rows[$realIndex]);
        $this->rows = array_values($this->rows);

        $this->resetPage();
        
        session()->flash('success', 'Row removed and stock returned successfully!');
    }

    public function getLockExpiresAtTimestamp()
    {
        // Jika sudah ada, gunakan yang sudah ada
        if ($this->lockExpiresAt) {
            return $this->lockExpiresAt->timestamp;
        }
        
        // Jika lockAcquired true tapi lockExpiresAt null, cari dari database
        if ($this->lockAcquired) {
            $sessionId = Session::getId();
            
            if ($this->requestId) {
                $lock = UniformRequestLock::where('request_id', $this->requestId)
                    ->where('session_id', $sessionId)
                    ->where('expires_at', '>', now())
                    ->first();
            } else {
                $lock = UniformRequestLock::whereNull('request_id')
                    ->where('session_id', $sessionId)
                    ->where('expires_at', '>', now())
                    ->first();
            }
            
            if ($lock) {
                $this->lockExpiresAt = $lock->expires_at;
                return $lock->expires_at->timestamp;
            }
        }
        
        // Fallback: 5 menit dari sekarang
        return now()->addMinutes(10)->timestamp;
    }

    public function save()
    {
        $this->isSaving = true;

        try {
            $this->validate();

            $errors = [];
            foreach ($this->rows as $index => $row) {
                if ($row['reason_type'] === 'ng_esd') {
                    if (empty($row['reason_file'])) {
                        $errors[] = 'File PDF wajib diupload untuk alasan NG ESD pada baris ' . ($index + 1) . ' (Item: ' . $row['item_code'] . ')';
                    }
                } elseif ($row['reason_type'] === 'pergantian') {
                    if (empty($row['reason'])) {
                        $errors[] = 'Alasan pergantian wajib diisi pada baris ' . ($index + 1) . ' (Item: ' . $row['item_code'] . ')';
                    }
                }
                // Untuk new_employee, tidak perlu validasi tambahan
            }

            if (!empty($errors)) {
                session()->flash('error', implode('<br>', $errors));
                $this->isSaving = false;
                return;
            }

            $isOneUser = auth()->user()->can('view uniform request one user');
            $isFullAccess = auth()->user()->can('view uniform request');

            foreach ($this->rows as $row) {
                if (isset($row['is_manual']) && $row['is_manual']) {
                    continue;
                }

                $employee = Employee::find($row['employee_id']);

                if (!$employee) {
                    session()->flash('error', 'Karyawan tidak ditemukan! (ID: ' . $row['employee_id'] . ')');
                    $this->isSaving = false;
                    return;
                }

                if (!in_array($employee->status, [1, 2, 3])) {
                    session()->flash('error', 'Karyawan ' . $employee->nik . ' - ' . $employee->name . ' tidak aktif!');
                    $this->isSaving = false;
                    return;
                }

                if ($isOneUser && !$isFullAccess && $this->userDepartment) {
                    if ($employee->department !== $this->userDepartment) {
                        session()->flash('error', 'Anda hanya dapat membuat request untuk karyawan dari department anda: ' . $this->userDepartment);
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
                    'reason_type' => $row['reason_type'] ?? 'pergantian',
                    'reason_file' => $row['reason_file'] ?? null,
                    'reason_file_name' => $row['reason_file_name'] ?? null,
                    'group' => $row['group'],
                    'request_date' => $row['request_date'],
                    'remarks' => $row['remarks'] ?? null,
                    'admin_feedback' => $row['admin_feedback'] ?? null,
                    'admin_feedback_datetime' => $row['admin_feedback_datetime'] ?? null,
                ];

                if (isset($row['is_manual']) && $row['is_manual']) {
                    $itemData['manual_nik'] = $row['manual_nik'] ?? null;
                    $itemData['manual_name'] = $row['manual_name'] ?? null;
                    $itemData['manual_department'] = $row['manual_department'] ?? null;
                    $itemData['manual_tanggal_pemberkasan'] = $row['manual_tanggal_pemberkasan'] ?? null;
                    $itemData['manual_doj'] = $row['manual_doj'] ?? null;
                    $itemData['is_manual'] = true;
                    $itemData['employee_nik'] = $row['employee_nik'] ?? null;
                    $itemData['employee_name'] = $row['employee_name'] ?? null;
                    $itemData['employee_department'] = $row['employee_department'] ?? null;
                } else {
                    $itemData['manual_nik'] = null;
                    $itemData['manual_name'] = null;
                    $itemData['manual_department'] = null;
                    $itemData['manual_tanggal_pemberkasan'] = null;
                    $itemData['manual_doj'] = null;
                    $itemData['is_manual'] = false;
                    $itemData['employee_nik'] = $row['employee_nik'] ?? null;
                    $itemData['employee_name'] = $row['employee_name'] ?? null;
                    $itemData['employee_department'] = $row['employee_department'] ?? null;
                }

                $itemsForDb[] = $itemData;
            }

            $isUpdate = false;
            $request = null;

            if ($this->requestId) {
                $request = UniformRequest::find($this->requestId);

                if (!$request) {
                    session()->flash('error', 'Request tidak ditemukan!');
                    $this->isSaving = false;
                    return;
                }

                $oldItems = $request->items ?? [];

                $qtyDiff = [];
                foreach ($oldItems as $oldItem) {
                    $key = $oldItem['master_uniform_id'];
                    $qtyDiff[$key] = ($qtyDiff[$key] ?? 0) - $oldItem['qty'];
                }
                foreach ($itemsForDb as $newItem) {
                    $key = $newItem['master_uniform_id'];
                    $qtyDiff[$key] = ($qtyDiff[$key] ?? 0) + $newItem['qty'];
                }

                $stockErrors = [];
                foreach ($qtyDiff as $uniformId => $diff) {
                    if ($diff <= 0) continue;

                    $uniform = MasterUniform::find($uniformId);
                    if (!$uniform) {
                        $stockErrors[] = "Uniform tidak ditemukan! (ID: " . $uniformId . ")";
                        continue;
                    }

                    if ($uniform->qty < $diff) {
                        $stockErrors[] = "Stok tidak mencukupi untuk {$uniform->item_code} - {$uniform->description} ({$uniform->size}). Tersedia: {$uniform->qty}, Dibutuhkan tambahan: {$diff}";
                    }
                }

                if (!empty($stockErrors)) {
                    session()->flash('error', implode('<br>', $stockErrors));
                    $this->isSaving = false;
                    return;
                }

                foreach ($qtyDiff as $uniformId => $diff) {
                    if ($diff == 0) continue;

                    $uniform = MasterUniform::find($uniformId);
                    if ($uniform) {
                        $oldQty = $uniform->qty;
                        $newQty = $oldQty - $diff;

                        $uniform->qty = $newQty;
                        $uniform->save();

                        UniformStockTransaction::create([
                            'master_uniform_id' => $uniform->id,
                            'transaction_type' => $diff > 0 ? 'OUT' : 'IN',
                            'qty_change' => -$diff,
                            'qty_before' => $oldQty,
                            'qty_after' => $newQty,
                            'reference_id' => $request->request_number,
                            'reference_type' => 'uniform_request_edit',
                            'description' => 'Edit request: ' . $request->request_number . ' - ' . ($diff > 0 ? 'Tambah ' . $diff . ' item' : 'Kurangi ' . abs($diff) . ' item'),
                            'performed_by' => auth()->user()->name,
                            'performed_at' => now(),
                        ]);
                    }
                }

                $request->update(['items' => $itemsForDb]);
                session()->flash('success', 'Request berhasil diupdate! Stok telah disesuaikan.');
                $isUpdate = true;

            } else {
                $stockErrors = [];
                $stockData = [];

                foreach ($this->rows as $row) {
                    $uniform = MasterUniform::find($row['master_uniform_id']);
                    if (!$uniform) {
                        $stockErrors[] = "Uniform tidak ditemukan! (ID: " . $row['master_uniform_id'] . ")";
                        continue;
                    }

                    if ($uniform->qty < $row['qty']) {
                        $stockErrors[] = "Stok tidak mencukupi untuk {$uniform->item_code} - {$uniform->description} ({$uniform->size}). Tersedia: {$uniform->qty}, Diminta: {$row['qty']}";
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

                $request = UniformRequest::create(['items' => $itemsForDb]);

                foreach ($stockData as $data) {
                    $uniform = $data['uniform'];
                    $oldQty = $uniform->qty;
                    $newQty = $oldQty - $data['qty_requested'];

                    $uniform->qty = $newQty;
                    $uniform->save();

                    $employeeInfo = $data['employee_nik'] . ' - ' . $data['employee_name'] . ' (' . $data['employee_department'] . ')';

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

                session()->flash('success', 'Request berhasil dibuat! Stok telah diupdate.');
            }

            try {
                Mail::to('sek.esd@siix-global.com')
                    ->send(new UniformRequestCreatedMail($request, $isUpdate));
            } catch (\Exception $e) {
                \Log::error('Gagal mengirim email notifikasi uniform request: ' . $e->getMessage());
            }

            $this->releaseLock();
            $this->isSaving = false;

            return redirect()->route('prod.uniform.request.index');

        } catch (\Exception $e) {
            $this->isSaving = false;
            \Log::error('Error saving uniform request: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
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

    // Tambahkan method ini di UniformRequestForm.php

    public function endSession()
    {
        $sessionId = Session::getId();
        
        // Hapus lock dari database berdasarkan session_id
        if ($this->requestId) {
            // Untuk edit mode
            $lock = UniformRequestLock::where('request_id', $this->requestId)
                ->where('session_id', $sessionId)
                ->first();
        } else {
            // Untuk create mode
            $lock = UniformRequestLock::whereNull('request_id')
                ->where('session_id', $sessionId)
                ->first();
        }
        
        if ($lock) {
            // Hapus lock dari database
            $lock->delete();
            
            // Reset properties
            $this->lockAcquired = false;
            $this->lockOwner = null;
            $this->lockExpiresAt = null;
            
            // Log activity
            \Log::info('Session ended manually by user', [
                'user' => auth()->user()->name,
                'session_id' => $sessionId,
                'request_id' => $this->requestId ?? 'create'
            ]);
            
            // Redirect ke index dengan pesan sukses
            return redirect()->route('prod.uniform.request.index')
                ->with('success', 'Session ended successfully. Form has been released.');
        }
        
        // Jika lock tidak ditemukan, tetap redirect
        return redirect()->route('prod.uniform.request.index')
            ->with('info', 'Session already ended.');
    }

    public function render()
    {
        // ==================== CHECK LOCK STATUS ====================
        $sessionId = Session::getId();
        
        // Cari lock di database berdasarkan session_id
        if ($this->requestId) {
            $lock = UniformRequestLock::where('request_id', $this->requestId)
                ->where('session_id', $sessionId)
                ->where('expires_at', '>', now())
                ->first();
        } else {
            $lock = UniformRequestLock::whereNull('request_id')
                ->where('session_id', $sessionId)
                ->where('expires_at', '>', now())
                ->first();
        }
        
        if ($lock) {
            // Lock masih valid untuk session ini
            $this->lockAcquired = true;
            $this->lockOwner = $lock->user_name;
            $this->lockExpiresAt = $lock->expires_at;
        } else {
            // Tidak ada lock untuk session ini
            // Cek apakah ada lock dari user lain
            if ($this->requestId) {
                $otherLock = UniformRequestLock::where('request_id', $this->requestId)
                    ->where('session_id', '!=', $sessionId)
                    ->where('expires_at', '>', now())
                    ->first();
            } else {
                $otherLock = UniformRequestLock::whereNull('request_id')
                    ->where('session_id', '!=', $sessionId)
                    ->where('expires_at', '>', now())
                    ->first();
            }
            
            if ($otherLock) {
                // Lock dimiliki user lain
                $this->lockAcquired = false;
                $this->lockOwner = $otherLock->user_name;
                $this->lockExpiresAt = $otherLock->expires_at;
                
                session()->flash('error', '⚠️ Form ini sedang digunakan oleh: ' . $this->lockOwner . '. Silakan tunggu hingga selesai.');
                return redirect()->route('prod.uniform.request.index');
            }
            
            // Tidak ada lock sama sekali, buat lock baru
            if (!$this->acquireLock()) {
                session()->flash('error', '⚠️ Form ini sedang digunakan oleh: ' . $this->lockOwner . '. Silakan tunggu hingga selesai.');
                return redirect()->route('prod.uniform.request.index');
            }
        }

        // Pastikan lockExpiresAt selalu ada jika lockAcquired true
        if ($this->lockAcquired && !$this->lockExpiresAt) {
            if ($this->requestId) {
                $lock = UniformRequestLock::where('request_id', $this->requestId)
                    ->where('session_id', $sessionId)
                    ->where('expires_at', '>', now())
                    ->first();
            } else {
                $lock = UniformRequestLock::whereNull('request_id')
                    ->where('session_id', $sessionId)
                    ->where('expires_at', '>', now())
                    ->first();
            }
            if ($lock) {
                $this->lockExpiresAt = $lock->expires_at;
            }
        }

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
        
        $availableUniforms = $this->available_uniforms;
        
        return view('livewire.prod.uniform.uniform-request-form', [
            'paginatedRows' => $paginator,
            'availableUniforms' => $availableUniforms,
        ]);
    }
}