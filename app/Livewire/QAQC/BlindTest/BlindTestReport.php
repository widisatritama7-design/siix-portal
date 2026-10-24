<?php

namespace App\Livewire\QAQC\BlindTest;

use App\Models\QAQC\BlindTest\BlindTest;
use App\Models\QAQC\BlindTest\Deffect;
use Illuminate\Support\Facades\Response;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

#[Title('Blind Test Report')]
class BlindTestReport extends Component
{
    use WithPagination;

    // ==================== FILTERS ====================
    public $yearFilter = '';
    public $monthFilter = '';
    public $sectionFilter = '';

    // ==================== STATE ====================
    public $hasFiltered = false;
    public $totalRecords = 0;

    // Employee aggregates
    public $totalFail = 0;
    public $totalPass = 0;
    public $totalSoal = 0;
    public $averagePercentage = 0;
    public $overallPercentage = 0;
    public $percentageDistribution = [];

    // Defect aggregates
    public $totalDefectRecords = 0;

    protected $rules = [
        'yearFilter'    => 'nullable|string',
        'monthFilter'   => 'nullable|string',
        'sectionFilter' => 'nullable|string',
    ];

    public function updatedYearFilter()    { $this->resetPage(); }
    public function updatedMonthFilter()   { $this->resetPage(); }
    public function updatedSectionFilter() { $this->resetPage(); }

    // ==================== DROPDOWN DATA ====================
    public function getYearsProperty()
    {
        return BlindTest::query()
            ->selectRaw('YEAR(created_at) as year')
            ->whereNotNull('created_at')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year', 'year');
    }

    public function getMonthsProperty()
    {
        return [
            '01' => 'January',  '02' => 'February', '03' => 'March',
            '04' => 'April',    '05' => 'May',      '06' => 'June',
            '07' => 'July',     '08' => 'August',   '09' => 'September',
            '10' => 'October',  '11' => 'November', '12' => 'December',
        ];
    }

    public function getSectionsProperty()
    {
        return BlindTest::query()
            ->where('status', 'completed')
            ->whereNotNull('section')
            ->where('section', '!=', '')
            ->distinct()
            ->orderBy('section')
            ->pluck('section')
            ->map(fn ($s) => trim($s))
            ->filter()
            ->unique()
            ->values();
    }

    // ==================== BASE QUERY ====================
    protected function getFilteredQuery()
    {
        return BlindTest::query()
            ->with(['employee'])
            ->where('status', 'completed')
            ->when($this->yearFilter,    fn ($q) => $q->whereYear('created_at', $this->yearFilter))
            ->when($this->monthFilter,   fn ($q) => $q->whereMonth('created_at', $this->monthFilter))
            ->when($this->sectionFilter, fn ($q) => $q->where('section', $this->sectionFilter));
    }

    // ==================== HELPER: hitung pass & fail per test ====================
    private function countPassFail($answers)
    {
        if (!is_array($answers)) return [0, 0];

        $pass = 0;
        $total = count($answers);

        foreach ($answers as $a) {
            $userAnswer = $a['user_answer'] ?? '';
            $locStatus  = $a['location_status'] ?? null;

            if ($userAnswer === 'MISSING') continue;
            if ($locStatus === 'pending')  continue;

            if (!empty($a['is_correct'])) $pass++;
        }

        return [$pass, $total];
    }

    // ==================== AGGREGATE PER EMPLOYEE ====================
    protected function getAggregatedEmployeeData()
    {
        $records = $this->getFilteredQuery()
            ->orderByDesc('created_at')
            ->get();

        return $records->groupBy('employee_id')->map(function ($items) {
            $passCount  = 0;
            $failCount  = 0;
            $totalKunci = 0;
            $latestAttempt = 1;

            foreach ($items as $r) {
                $kunciCount = count($r->blind_test_items ?? []);
                $totalKunci += $kunciCount;

                [$passInTest, ] = $this->countPassFail($r->user_answers ?? []);
                $passCount += $passInTest;
                $failCount += max(0, $kunciCount - $passInTest);

                if (($r->attempt ?? 1) > $latestAttempt) {
                    $latestAttempt = $r->attempt;
                }
            }

            $totalSoal  = $totalKunci;
            $percentage = $totalSoal > 0 ? (int) round(($passCount / $totalSoal) * 100) : 0;
            $rounded    = max(0, min(100, (int) (round($percentage / 20) * 20)));

            $sections = $items->pluck('section')
                ->filter()
                ->map(fn ($s) => trim($s))
                ->unique()
                ->values();

            $first = $items->first();

            return [
                'employee_id'        => $first->employee_id,
                'nik'                => $first->employee->nik ?? '-',
                'name'               => $first->employee->name ?? '-',
                'department'         => $first->employee->department ?? '-',
                'section'            => $sections->implode(', ') ?: '-',
                'attempt'            => $latestAttempt,
                'max_attempt'        => $first->max_attempt ?? 2,
                'fail_count'         => $failCount,
                'pass_count'         => $passCount,
                'total_soal'         => $totalSoal,
                'percentage'         => $percentage,
                'rounded_percentage' => $rounded,
            ];
        })->sortBy('name')->values();
    }

    // ==================== AGGREGATE PER DEFECT ====================
    /**
     * Hitung PASS langsung dari user_answers (bukan lookup ke blind_test_items).
     *
     * Definisi:
     * - Total Employee per defect = jumlah orang unik yang memiliki jawaban untuk defect itu
     * - PASS = jumlah orang yang is_correct = true (dan tidak MISSING/pending)
     * - FAIL = Total Employee - PASS
     */
    protected function getAggregatedDefectData()
    {
        $records = $this->getFilteredQuery()->get();

        // deffect_item_id => ['employees' => [empId => 'pass'|'fail'], ]
        $bucket = [];

        foreach ($records as $bt) {
            $employeeId  = $bt->employee_id;
            $userAnswers = collect($bt->user_answers ?? []);

            foreach ($userAnswers as $ua) {
                $deffectId  = (int) ($ua['deffect_item_id'] ?? 0);
                if ($deffectId <= 0) continue;

                $userAnswer = $ua['user_answer'] ?? '';
                $locStatus  = $ua['location_status'] ?? null;

                // Skip yang tidak dijawab / pending
                if ($userAnswer === 'MISSING') continue;
                if ($locStatus === 'pending')  continue;

                $status = !empty($ua['is_correct']) ? 'pass' : 'fail';

                if (!isset($bucket[$deffectId])) {
                    $bucket[$deffectId] = ['employees' => []];
                }

                // Kalau orang ini sudah pernah tercatat untuk defect ini,
                // prioritaskan PASS (kalau ada yang pass)
                if (!isset($bucket[$deffectId]['employees'][$employeeId])) {
                    $bucket[$deffectId]['employees'][$employeeId] = $status;
                } else {
                    if ($status === 'pass') {
                        $bucket[$deffectId]['employees'][$employeeId] = 'pass';
                    }
                }
            }
        }

        $deffectIds = array_keys($bucket);
        $deffects   = Deffect::whereIn('id', $deffectIds)->get()->keyBy('id');

        return collect($bucket)->map(function ($v, $deffectId) use ($deffects) {
            $totalEmployee = count($v['employees']);
            $pass          = collect($v['employees'])->filter(fn ($s) => $s === 'pass')->count();
            $fail          = $totalEmployee - $pass;

            return [
                'deffect_id'     => $deffectId,
                'deffect_name'   => $deffects[$deffectId]->deffect_item_name
                                        ?? '(Deleted Deffect #'.$deffectId.')',
                'total_employee' => $totalEmployee,
                'pass'           => $pass,
                'fail'           => $fail,
                'total'          => $totalEmployee,
            ];
        })->sortByDesc('total_employee')->values();
    }

    // ==================== DISTRIBUTION ====================
    protected function getPercentageDistribution($data)
    {
        $buckets = [0, 20, 40, 60, 80, 100];
        $distribution = array_fill_keys($buckets, 0);

        foreach ($data as $item) {
            $rounded = $item['rounded_percentage'];
            if (isset($distribution[$rounded])) $distribution[$rounded]++;
        }

        return $distribution;
    }

    protected function recalculate($employeeData, $defectData)
    {
        // Employee
        $this->totalRecords           = $employeeData->count();
        $this->totalFail              = $employeeData->sum('fail_count');
        $this->totalPass              = $employeeData->sum('pass_count');
        $this->totalSoal              = $employeeData->sum('total_soal');
        $this->percentageDistribution = $this->getPercentageDistribution($employeeData);

        $this->averagePercentage = $employeeData->count() > 0
            ? round($employeeData->avg('percentage'), 1) : 0;

        $this->overallPercentage = $this->totalSoal > 0
            ? round(($this->totalPass / $this->totalSoal) * 100, 1) : 0;

        // Defect
        $this->totalDefectRecords = $defectData->count();
    }

    // ==================== ACTIONS ====================
    public function applyFilter()
    {
        $this->validate();
        $this->hasFiltered = true;
        $this->resetPage();

        $employeeData = $this->getAggregatedEmployeeData();
        $defectData   = $this->getAggregatedDefectData();
        $this->recalculate($employeeData, $defectData);

        $this->dispatch('notify',
            message: 'Data found: ' . $this->totalRecords . ' employees, ' . $this->totalDefectRecords . ' defect items',
            type: 'success'
        );
    }

    public function resetFilters()
    {
        $this->reset(['yearFilter', 'monthFilter', 'sectionFilter']);
        $this->hasFiltered = false;
        $this->totalRecords = 0;
        $this->totalFail = 0;
        $this->totalPass = 0;
        $this->totalSoal = 0;
        $this->averagePercentage = 0;
        $this->overallPercentage = 0;
        $this->percentageDistribution = [];
        $this->totalDefectRecords = 0;
        $this->resetPage();

        $this->dispatch('notify', message: 'Filters reset', type: 'info');
    }

    // ==================== EXPORT ====================
    public function export()
    {
        $this->validate();

        if (!$this->hasFiltered) {
            $this->dispatch('notify', message: 'Please apply filter first.', type: 'warning');
            return;
        }

        $employeeData = $this->getAggregatedEmployeeData();
        $defectData   = $this->getAggregatedDefectData();

        if ($employeeData->isEmpty() && $defectData->isEmpty()) {
            $this->dispatch('notify', message: 'No data available to export.', type: 'warning');
            return;
        }

        $spreadsheet = new Spreadsheet();

        // ============ SHEET 1: BY EMPLOYEE ============
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('By Employee');

        $headers = [
            'A' => 'No', 'B' => 'NIK', 'C' => 'Name', 'D' => 'Department',
            'E' => 'Section', 'F' => 'Percobaan', 'G' => 'Fail Count',
            'H' => 'Pass Count', 'I' => 'Total Soal', 'J' => 'Percentage',
        ];

        $row = 1;
        foreach ($headers as $col => $header) {
            $sheet->setCellValue($col . $row, $header);
            $sheet->getStyle($col . $row)->getFont()->setBold(true);
            $sheet->getStyle($col . $row)->getFill()
                ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF4472C4');
            $sheet->getStyle($col . $row)->getFont()->getColor()->setARGB('FFFFFFFF');
            $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        $row = 2; $no = 1;
        foreach ($employeeData as $item) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $item['nik']);
            $sheet->setCellValue('C' . $row, $item['name']);
            $sheet->setCellValue('D' . $row, $item['department']);
            $sheet->setCellValue('E' . $row, $item['section']);
            $sheet->setCellValue('F' . $row, ($item['attempt'] ?? 1) . ' / ' . ($item['max_attempt'] ?? 2));
            $sheet->setCellValue('G' . $row, $item['fail_count']);
            $sheet->setCellValue('H' . $row, $item['pass_count']);
            $sheet->setCellValue('I' . $row, $item['total_soal']);
            $sheet->setCellValue('J' . $row, $item['percentage'] . '%');
            $row++;
        }

        // Footer TOTAL di sheet By Employee
        $totalFail = $employeeData->sum('fail_count');
        $totalPass = $employeeData->sum('pass_count');
        $totalSoal = $employeeData->sum('total_soal');
        $overall   = $totalSoal > 0 ? round(($totalPass / $totalSoal) * 100, 1) : 0;

        $sheet->setCellValue('E' . $row, 'TOTAL');
        $sheet->setCellValue('G' . $row, $totalFail);
        $sheet->setCellValue('H' . $row, $totalPass);
        $sheet->setCellValue('I' . $row, $totalSoal);
        $sheet->setCellValue('J' . $row, $overall . '%');

        $sheet->getStyle('A' . $row . ':J' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row . ':J' . $row)->getFill()
            ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFF2CC');

        $sheet->getStyle('A1:J' . $row)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        foreach (array_keys($headers) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet->freezePane('A2');

        // ============ SHEET 2: BY DEFECT ============
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('By Defect');

        $dHeaders = [
            'A' => 'No',
            'B' => 'Defect Name',
            'C' => 'Total Employee',
            'D' => 'FAIL',
            'E' => 'PASS',
        ];

        $row = 1;
        foreach ($dHeaders as $col => $header) {
            $sheet2->setCellValue($col . $row, $header);
            $sheet2->getStyle($col . $row)->getFont()->setBold(true);
            $sheet2->getStyle($col . $row)->getFill()
                ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF4472C4');
            $sheet2->getStyle($col . $row)->getFont()->getColor()->setARGB('FFFFFFFF');
            $sheet2->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        $row = 2; $no = 1;
        foreach ($defectData as $item) {
            $sheet2->setCellValue('A' . $row, $no++);
            $sheet2->setCellValue('B' . $row, $item['deffect_name']);
            $sheet2->setCellValue('C' . $row, $item['total_employee']);
            $sheet2->setCellValue('D' . $row, $item['fail']);
            $sheet2->setCellValue('E' . $row, $item['pass']);
            $row++;
        }

        // ⚠️ TIDAK ADA footer TOTAL di sheet By Defect (sesuai permintaan)
        // Border hanya sampai baris data terakhir
        $lastRow2 = $row - 1;
        $sheet2->getStyle('A1:E' . $lastRow2)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        foreach (array_keys($dHeaders) as $col) {
            $sheet2->getColumnDimension($col)->setAutoSize(true);
        }
        $sheet2->freezePane('A2');

        $spreadsheet->setActiveSheetIndex(0);

        $fileName = 'laporan_blind_test_' . date('Y-m-d_H-i-s') . '.xlsx';
        $writer   = new Xlsx($spreadsheet);

        return Response::stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                'Cache-Control'       => 'max-age=0',
            ]
        );
    }

    // ==================== RENDER ====================
    public function render()
    {
        $employeePaginated = collect();
        $defectPaginated   = collect();

        if ($this->hasFiltered) {
            $employeeData = $this->getAggregatedEmployeeData();
            $defectData   = $this->getAggregatedDefectData();
            $this->recalculate($employeeData, $defectData);

            $perPage = 10;
            $page    = $this->getPage();

            $employeePaginated = new \Illuminate\Pagination\LengthAwarePaginator(
                $employeeData->forPage($page, $perPage)->values(),
                $employeeData->count(), $perPage, $page,
                ['path' => request()->url(), 'query' => request()->query(), 'pageName' => 'page']
            );

            $defectPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
                $defectData->forPage($page, $perPage)->values(),
                $defectData->count(), $perPage, $page,
                ['path' => request()->url(), 'query' => request()->query(), 'pageName' => 'page']
            );
        }

        return view('livewire.qaqc.blind-test.blind-test-report', [
            'previewData'       => $employeePaginated,
            'defectPreviewData' => $defectPaginated,
            'years'             => $this->years,
            'months'            => $this->months,
            'sections'          => $this->sections,
        ])->layout('layouts.app');
    }
}