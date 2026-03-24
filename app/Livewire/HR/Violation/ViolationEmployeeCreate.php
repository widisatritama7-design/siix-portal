<?php

namespace App\Livewire\HR\Violation;

use App\Models\HR\ViolationEmployee;
use App\Models\HR\Employee;
use App\Models\HR\EmployeeCall;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;

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
                3 => 'Internship',
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
            
            foreach ($recentViolations as $violation) {
                if ($violation->sub_category) {
                    $subCategories = is_array($violation->sub_category) 
                        ? $violation->sub_category 
                        : (json_decode($violation->sub_category, true) ?? []);
                    
                    foreach ($subCategories as $subCat) {
                        if (!isset($subCategoryCounts[$subCat])) {
                            $subCategoryCounts[$subCat] = 0;
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
        
        ViolationEmployee::create([
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
        
        session()->flash('message', 'Violation record created successfully.');
        return redirect()->route('hr.violation.index');
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