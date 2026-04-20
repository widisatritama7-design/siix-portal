<?php

namespace App\Mail\HR;

use App\Models\HR\ViolationEmployee;
use App\Models\HR\EmployeeCall;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ViolationCreated extends Mailable
{
    use Queueable, SerializesModels;

    public ViolationEmployee $violation;
    public ?string $receiver_name;
    public array $stats;

    public function __construct(ViolationEmployee $violation, ?string $receiver_name = null)
    {
        // Load employee relation if not already loaded
        if (!$violation->relationLoaded('employee')) {
            $violation->load('employee');
        }
        
        $this->violation = $violation;
        $this->receiver_name = $receiver_name;
        $this->stats = $this->calculateStats();
    }

    protected function calculateStats(): array
    {
        $employee = $this->violation->employee;
        
        if (!$employee) {
            return [
                'employee_call_count' => 0,
                'sub_category_counts' => [],
                'total_monthly_violations' => 0,
                'last_violation_date' => '-',
                'reminders' => []
            ];
        }

        // Hitung total Employee Call
        $employeeCallCount = EmployeeCall::where('nik', $employee->id)
            ->where('category', 'Violation')
            ->count();

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
                    : json_decode($violation->sub_category, true) ?? [];
                
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
        
        $totalMonthly = array_sum($subCategoryCounts);
        
        // Ambil violation terakhir
        $lastViolation = ViolationEmployee::where('nik', $employee->id)
            ->orderBy('created_at', 'desc')
            ->first();
        $lastDate = $lastViolation ? Carbon::parse($lastViolation->created_at)->format('d/m/Y H:i') : '-';
        
        // Mapping untuk aturan reminder
        $reminderRules = [
            'Tidak Ada Stiker (SIM & STNK Lengkap)' => [
                'threshold' => 5,
                'warning_level' => 'red'
            ],
            'Tidak membawa STNK/Tidak ada STNK' => [
                'threshold' => 1,
                'warning_level' => 'yellow'
            ],
            'STNK Expired' => [
                'threshold' => 1,
                'warning_level' => 'yellow'
            ],
            'Tidak membawa SIM/Tidak ada SIM' => [
                'threshold' => 1,
                'warning_level' => 'yellow'
            ],
            'SIM Expired' => [
                'threshold' => 1,
                'warning_level' => 'yellow'
            ],
            'Plat Kendaraan Mati' => [
                'threshold' => 1,
                'warning_level' => 'yellow'
            ],
            'Kendaraan tidak sesuai standar (cth. Tidak ada spion,tidak ada plat No dll)' => [
                'threshold' => 1,
                'warning_level' => 'yellow'
            ],
        ];
        
        // Generate reminders
        $reminders = [];
        foreach ($subCategoryCounts as $subCat => $count) {
            $rule = $reminderRules[$subCat] ?? null;
            if ($rule && $count >= $rule['threshold']) {
                $reminders[] = [
                    'sub_category' => $subCat,
                    'count' => $count,
                    'last_date' => isset($subCategoryLastDates[$subCat]) 
                        ? Carbon::parse($subCategoryLastDates[$subCat])->format('d/m/Y H:i') 
                        : $lastDate,
                    'warning_level' => $rule['warning_level']
                ];
            }
        }

        return [
            'employee_call_count' => $employeeCallCount,
            'sub_category_counts' => $subCategoryCounts,
            'sub_category_last_dates' => $subCategoryLastDates,
            'total_monthly_violations' => $totalMonthly,
            'last_violation_date' => $lastDate,
            'reminders' => $reminders
        ];
    }

    public function build()
    {
        Log::info('Building violation email for: ' . ($this->violation->employee?->name ?? $this->violation->name));
        
        return $this
            ->subject('New Violation Report - ' . ($this->violation->employee?->name ?? $this->violation->name))
            ->view('emails.hr.violation')
            ->with([
                'violation' => $this->violation,
                'receiver_name' => $this->receiver_name,
                'is_named' => !empty($this->receiver_name) && $this->receiver_name !== 'HOD',
                'stats' => $this->stats
            ]);
    }
}