<?php

namespace App\Livewire\HR\Violation;

use App\Models\HR\ViolationEmployee;
use App\Models\HR\Employee;
use App\Models\HR\EmployeeCall;
use App\Models\HR\Hod;
use App\Mail\HR\ViolationCreated;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ViolationEmployeeCreate extends Component
{
    use WithFileUploads;
    
    public $nik = '';
    public $name = '';
    public $dept = '';
    public $shift = '';
    public $category = '';
    public $sub_category = [];
    public $plat_motor = '';
    public $security_name = '';
    public $alasan = '';
    public $remarks = '';
    public $date = '';
    public $photo = null;
    
    public $status_display = '';
    public $employee_call_count = 0;
    public $sub_category_counts = [];
    public $total_monthly_violations = 0;
    public $last_violation_date = '-';
    
    protected $rules = [
        'nik' => 'required',
        'shift' => 'required',
        'category' => 'required',
        'security_name' => 'required',
        'alasan' => 'required',
        'date' => 'required|date',
        'photo' => 'nullable|image|max:5120',
    ];
    
    public function updatedNik($value)
    {
        $employee = Employee::find($value);
        
        if ($employee) {
            $this->name = $employee->name;
            $this->dept = $employee->department;
            $this->status_display = match($employee->status) {
                1 => 'Permanent',
                2 => 'Contract',
                3 => 'Magang',
                default => 'Unknown',
            };
            
            // Hitung total Employee Call
            $count = EmployeeCall::where('nik', $employee->id)
                ->where('category', 'Violation')
                ->count();
            $this->employee_call_count = $count;
            
            // Hitung violation counts per sub_category dalam 1 bulan terakhir
            $oneMonthAgo = Carbon::now()->subMonth();
            
            $recentViolations = ViolationEmployee::where('nik', $employee->id)
                ->where('created_at', '>=', $oneMonthAgo)
                ->get();
            
            $subCategoryCounts = [];
            $subCategoryLastDates = [];
            
            foreach ($recentViolations as $violation) {
                if ($violation->sub_category) {
                    $subCategories = is_array($violation->sub_category) 
                        ? $violation->sub_category 
                        : (json_decode($violation->sub_category, true) ?? []);
                    
                    foreach ($subCategories as $subCat) {
                        if (!isset($subCategoryCounts[$subCat])) {
                            $subCategoryCounts[$subCat] = 0;
                            $subCategoryLastDates[$subCat] = $violation->created_at;
                        } else {
                            if ($violation->created_at > $subCategoryLastDates[$subCat]) {
                                $subCategoryLastDates[$subCat] = $violation->created_at;
                            }
                        }
                        $subCategoryCounts[$subCat]++;
                    }
                }
            }
            
            $this->sub_category_counts = $subCategoryCounts;
            $this->total_monthly_violations = array_sum($subCategoryCounts);
            
            // Ambil violation terakhir
            $lastViolation = ViolationEmployee::where('nik', $employee->id)
                ->orderBy('created_at', 'desc')
                ->first();
            if ($lastViolation) {
                $this->last_violation_date = Carbon::parse($lastViolation->created_at)->format('d/m/Y H:i');
            } else {
                $this->last_violation_date = '-';
            }
        } else {
            $this->reset(['name', 'dept', 'status_display', 'employee_call_count', 'sub_category_counts', 'total_monthly_violations', 'last_violation_date']);
        }
    }
    
    public function updatedCategory($value)
    {
        if ($value !== 'Kendaraan') {
            $this->sub_category = [];
            $this->plat_motor = '';
        }
    }
    
    public function getSubCategoryOptionsProperty()
    {
        if ($this->category === 'Kendaraan') {
            return [
                'Tidak Ada Stiker (SIM & STNK Lengkap)' => 'Tidak Ada Stiker (SIM & STNK Lengkap)',
                'Tidak membawa STNK/Tidak ada STNK' => 'Tidak membawa STNK/Tidak ada STNK',
                'STNK Expired' => 'STNK Expired',
                'Tidak membawa SIM/Tidak ada SIM' => 'Tidak membawa SIM/Tidak ada SIM',
                'SIM Expired' => 'SIM Expired',
                'Plat Kendaraan Mati' => 'Plat Kendaraan Mati',
                'Kendaraan tidak sesuai standar (cth. Tidak ada spion,tidak ada plat No dll)' => 'Kendaraan tidak sesuai standar (cth. Tidak ada spion,tidak ada plat No dll)',
            ];
        }
        return [];
    }
    
    public function save()
    {
        $this->validate();
        
        $photoPath = null;
        if ($this->photo) {
            $photoPath = $this->photo->store('violations', 'public');
        }
        
        $violation = ViolationEmployee::create([
            'nik' => $this->nik,
            'name' => $this->name,
            'dept' => $this->dept,
            'shift' => $this->shift,
            'category' => $this->category,
            'sub_category' => $this->sub_category,
            'plat_motor' => $this->plat_motor,
            'security_name' => $this->security_name,
            'alasan' => $this->alasan,
            'remarks' => $this->remarks,
            'date' => $this->date,
            'photo' => $photoPath,
        ]);
        
        // Load employee relation
        $violation->load('employee');
        
        // Send email notifications
        $this->sendEmailNotifications($violation);
        
        session()->flash('message', 'Violation record created successfully.');
        return redirect()->route('hr.violation.index');
    }
    
    protected function sendEmailNotifications($violation)
    {
        try {
            Log::info('=== SENDING VIOLATION EMAIL ===');
            Log::info('Department: ' . $violation->dept);
            Log::info('Employee NIK: ' . ($violation->employee?->nik ?? 'Not found'));
            Log::info('Employee Name: ' . ($violation->employee?->name ?? 'Not found'));
            
            // Mencari data HOD berdasarkan department
            $hod = Hod::where('department_name', $violation->dept)->first();
            
            Log::info('HOD found: ' . ($hod ? 'Yes' : 'No'));
            
            if ($hod) {
                Log::info('HOD Name: ' . $hod->hod_name);
                Log::info('HOD Email: ' . $hod->hod_email);
            }
            
            $hodEmail = $hod?->hod_email;
            $hodName = $hod?->hod_name ?? 'HOD';
            
            // Kirim email ke HOD jika ditemukan
            if ($hodEmail) {
                Log::info('Sending email to: ' . $hodEmail);
                
                Mail::to($hodEmail)->send(new ViolationCreated($violation, $hodName));
                
                Log::info('Email sent successfully to: ' . $hodEmail);
            } else {
                Log::warning('No HOD email found for department: ' . $violation->dept);
            }
            
        } catch (\Exception $e) {
            Log::error('Failed to send violation email: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
    
    public function cancel()
    {
        return redirect()->route('hr.violation.index');
    }
    
    public function render()
    {
        $employees = Employee::select('id', 'name', 'nik')
            ->whereIn('status', [1, 2, 3])
            ->orderBy('name')
            ->get()
            ->mapWithKeys(fn ($employee) => [
                $employee->id => $employee->nik . ' - ' . $employee->name,
            ]);
        
        $shifts = [
            'NS' => 'Non Shift',
            '1' => 'Shift 1',
            '2' => 'Shift 2',
            '3' => 'Shift 3',
        ];
        
        $categories = [
            'Kendaraan' => 'Kendaraan',
            'Uniform' => 'Uniform',
            'Membawa Barang Pribadi' => 'Membawa Barang Pribadi',
        ];
        
        return view('livewire.hr.violation-employee.create', [
            'employees' => $employees,
            'shifts' => $shifts,
            'categories' => $categories,
        ]);
    }
}