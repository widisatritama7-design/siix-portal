<?php

namespace App\Livewire\QAQC\BlindTest;

use App\Models\HR\Employee;
use App\Models\QAQC\BlindTest\BlindTest;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BlindTestReport extends Component
{
    use WithPagination;

    // ==================== FILTERS ====================
    public $dateFrom = '';
    public $dateUntil = '';
    public $yearFilter = '';
    public $monthFilter = '';
    public $departmentFilter = '';
    public $sectionFilter = '';

    // ==================== STATE ====================
    public $hasFiltered = false;
    public $totalRecords = 0;

    // Aggregates
    public $totalFail = 0;
    public $totalPass = 0;
    public $totalSoal = 0;

    // Percentage metrics
    public $averagePercentage = 0;
    public $overallPercentage = 0;

    // Distribution
    public $percentageDistribution = [];

    protected $rules = [
        'dateFrom'         => 'nullable|date',
        'dateUntil'        => 'nullable|date|after_or_equal:dateFrom',
        'yearFilter'       => 'nullable|string',
        'monthFilter'      => 'nullable|string',
        'departmentFilter' => 'nullable|string',
        'sectionFilter'    => 'nullable|string',
    ];

    public function updatedDateFrom()         { $this->resetPage(); }
    public function updatedDateUntil()        { $this->resetPage(); }
    public function updatedYearFilter()       { $this->resetPage(); }
    public function updatedMonthFilter()      { $this->resetPage(); }
    public function updatedDepartmentFilter() { $this->resetPage(); }
    public function updatedSectionFilter()    { $this->resetPage(); }

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
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];
    }

    public function getDepartmentsProperty()
    {
        return Employee::query()
            ->whereIn('status', [1, 2, 3])
            ->whereNotNull('department')
            ->where('department', '!=', '')
            ->distinct()
            ->orderBy('department')
            ->pluck('department');
    }

    /**
     * Section diambil dari tabel blind_tests
     * Nilai umum: QC, SMT, BE, MI
     */
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
            ->when($this->dateFrom, fn ($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateUntil, fn ($q) => $q->whereDate('created_at', '<=', $this->dateUntil))
            ->when($this->yearFilter, fn ($q) => $q->whereYear('created_at', $this->yearFilter))
            ->when($this->monthFilter, fn ($q) => $q->whereMonth('created_at', $this->monthFilter))
            ->when($this->sectionFilter, fn ($q) => $q->where('section', $this->sectionFilter))
            ->when($this->departmentFilter, function ($q) {
                $q->whereHas('employee', fn ($eq) => $eq->where('department', $this->departmentFilter));
            });
    }

    /**
     * Aggregate per-employee.
     */
    protected function getAggregatedData()
    {
        $records = $this->getFilteredQuery()
            ->orderByDesc('created_at')
            ->get();

        $grouped = $records->groupBy('employee_id')->map(function ($items) {
            // Group per test unik (section + customer + model)
            $byTest = $items->groupBy(function ($r) {
                return ($r->section ?? '-') . '|' . ($r->customer_id ?? '-') . '|' . ($r->model_id ?? '-');
            });

            $passCount  = 0;
            $failCount  = 0;
            $totalKunci = 0;

            foreach ($byTest as $sameTest) {
                // Ambil attempt TERAKHIR per test
                $latest = $sameTest->sortByDesc('attempt')->first();
                if (!$latest) continue;

                // Total soal = jumlah kunci di test ini
                $kunciCount  = count($latest->blind_test_items ?? []);
                $totalKunci += $kunciCount;

                $answers = $latest->user_answers ?? [];
                if (!is_array($answers)) continue;

                // Pass = baris is_correct = true, skip MISSING & pending
                $passInTest = collect($answers)
                    ->filter(function ($a) {
                        $userAnswer = $a['user_answer'] ?? '';
                        $locStatus  = $a['location_status'] ?? null;

                        if ($userAnswer === 'MISSING') return false;
                        if ($locStatus === 'pending')  return false;

                        return !empty($a['is_correct']);
                    })
                    ->count();

                $passCount += $passInTest;

                // Fail = total kunci - pass
                $failInTest = max(0, $kunciCount - $passInTest);
                $failCount += $failInTest;
            }

            // Total soal = total kunci (bukan pass + fail)
            $totalSoal  = $totalKunci;
            $percentage = $totalSoal > 0 ? (int) round(($passCount / $totalSoal) * 100) : 0;
            $rounded    = max(0, min(100, (int) (round($percentage / 20) * 20)));

            $sections = $items->pluck('section')
                ->filter()
                ->map(fn ($s) => trim($s))
                ->unique()
                ->values();

            $latestAttempt = $byTest->map(fn ($group) => $group->max('attempt'))->max() ?? 1;
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

        return $grouped;
    }

    /**
     * Distribusi per bucket.
     */
    protected function getPercentageDistribution($data)
    {
        $buckets = [0, 20, 40, 60, 80, 100];
        $distribution = array_fill_keys($buckets, 0);

        foreach ($data as $item) {
            $rounded = $item['rounded_percentage'];
            if (isset($distribution[$rounded])) {
                $distribution[$rounded]++;
            }
        }

        return $distribution;
    }

    /**
     * Hitung semua aggregate sekaligus.
     */
    protected function recalculate($data)
    {
        $this->totalRecords           = $data->count();
        $this->totalFail              = $data->sum('fail_count');
        $this->totalPass              = $data->sum('pass_count');
        $this->totalSoal              = $data->sum('total_soal');
        $this->percentageDistribution = $this->getPercentageDistribution($data);

        $this->averagePercentage = $data->count() > 0
            ? round($data->avg('percentage'), 1)
            : 0;

        $this->overallPercentage = $this->totalSoal > 0
            ? round(($this->totalPass / $this->totalSoal) * 100, 1)
            : 0;
    }

    // ==================== ACTIONS ====================
    public function applyFilter()
    {
        $this->validate();
        $this->hasFiltered = true;
        $this->resetPage();

        $data = $this->getAggregatedData();
        $this->recalculate($data);

        $this->dispatch('notify',
            message: 'Data found: ' . $this->totalRecords . ' employees',
            type: 'success'
        );
    }

    public function resetFilters()
    {
        $this->reset([
            'dateFrom', 'dateUntil', 'yearFilter', 'monthFilter',
            'departmentFilter', 'sectionFilter',
        ]);
        $this->hasFiltered = false;
        $this->totalRecords = 0;
        $this->totalFail = 0;
        $this->totalPass = 0;
        $this->totalSoal = 0;
        $this->averagePercentage = 0;
        $this->overallPercentage = 0;
        $this->percentageDistribution = [];
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

        $data = $this->getAggregatedData();

        if ($data->isEmpty()) {
            $this->dispatch('notify', message: 'No data available to export.', type: 'warning');
            return;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header — kolom Section ditambahkan
        $headers = [
            'A' => 'No',
            'B' => 'NIK',
            'C' => 'Name',
            'D' => 'Department',
            'E' => 'Section',
            'F' => 'Percobaan',
            'G' => 'Fail Count',
            'H' => 'Pass Count',
            'I' => 'Total Soal',
            'J' => 'Percentage',
        ];

        $row = 1;
        foreach ($headers as $col => $header) {
            $sheet->setCellValue($col . $row, $header);
            $sheet->getStyle($col . $row)->getFont()->setBold(true);
            $sheet->getStyle($col . $row)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF4472C4');
            $sheet->getStyle($col . $row)->getFont()->getColor()->setARGB('FFFFFFFF');
            $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Data rows
        $row = 2;
        $no = 1;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $item['nik']);
            $sheet->setCellValue('C' . $row, $item['name']);
            $sheet->setCellValue('D' . $row, $item['department']);
            $sheet->setCellValue('E' . $row, $item['section']);
            $sheet->setCellValue('F' . $row, ($item['attempt'] ?? 1) . ' / ' . ($item['max_attempt'] ?? 2)); // ← TAMBAH
            $sheet->setCellValue('G' . $row, $item['fail_count']);
            $sheet->setCellValue('H' . $row, $item['pass_count']);
            $sheet->setCellValue('I' . $row, $item['total_soal']);
            $sheet->setCellValue('J' . $row, $item['percentage'] . '%');
            $row++;
        }

        // Totals
        $totalFail = $data->sum('fail_count');
        $totalPass = $data->sum('pass_count');
        $totalSoal = $data->sum('total_soal');
        $overall   = $totalSoal > 0 ? round(($totalPass / $totalSoal) * 100, 1) : 0;

        $sheet->setCellValue('E' . $row, 'TOTAL');
        $sheet->setCellValue('G' . $row, $totalFail);
        $sheet->setCellValue('H' . $row, $totalPass);
        $sheet->setCellValue('I' . $row, $totalSoal);
        $sheet->setCellValue('J' . $row, $overall . '%');

        $sheet->getStyle('A' . $row . ':J' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row . ':J' . $row)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFF2CC');
        $sheet->getStyle('E' . $row . ':J' . $row)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Summary
        $row += 2;
        $distribution = $this->getPercentageDistribution($data);
        $grandTotal = $data->count();

        $sheet->setCellValue('A' . $row, 'PERCENTAGE DISTRIBUTION');
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->mergeCells('A' . $row . ':I' . $row);
        $row++;

        $sheet->setCellValue('A' . $row, 'Percentage');
        $sheet->setCellValue('B' . $row, 'Count (Employees)');
        $sheet->setCellValue('C' . $row, 'Percentage of Total');
        $sheet->getStyle('A' . $row . ':C' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row . ':C' . $row)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFED7D31');
        $sheet->getStyle('A' . $row . ':C' . $row)->getFont()->getColor()->setARGB('FFFFFFFF');
        $row++;

        foreach ($distribution as $pct => $count) {
            $pctOfTotal = $grandTotal > 0 ? round(($count / $grandTotal) * 100, 1) : 0;
            $sheet->setCellValue('A' . $row, $pct . '%');
            $sheet->setCellValue('B' . $row, $count);
            $sheet->setCellValue('C' . $row, $pctOfTotal . '%');
            $row++;
        }

        $sheet->setCellValue('A' . $row, 'TOTAL');
        $sheet->setCellValue('B' . $row, $grandTotal);
        $sheet->setCellValue('C' . $row, '100%');
        $sheet->getStyle('A' . $row . ':C' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row . ':C' . $row)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFF2CC');

        // Border
        $lastDataRow = $row - count($distribution) - 4;
        $sheet->getStyle('A1:J' . $lastDataRow)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        foreach (array_keys($headers) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->freezePane('A2');

        $fileName = 'laporan_blind_test_' . date('Y-m-d_H-i-s') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

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
        $allData = collect();
        $paginated = collect();

        if ($this->hasFiltered) {
            $allData = $this->getAggregatedData();
            $this->recalculate($allData);

            $perPage = 10;
            $page = $this->getPage();
            $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
                $allData->forPage($page, $perPage)->values(),
                $allData->count(),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

        return view('livewire.qaqc.blind-test.blind-test-report', [
            'previewData' => $paginated,
            'years'       => $this->years,
            'months'      => $this->months,
            'departments' => $this->departments,
            'sections'    => $this->sections,
        ])->layout('layouts.app');
    }
}