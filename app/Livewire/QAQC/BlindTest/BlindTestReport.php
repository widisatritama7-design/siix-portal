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

    // ==================== STATE ====================
    public $hasFiltered = false;
    public $totalRecords = 0;

    // Aggregates untuk preview & export
    public $totalFail = 0;
    public $totalPass = 0;
    public $totalSoal = 0;

    protected $rules = [
        'dateFrom'         => 'nullable|date',
        'dateUntil'        => 'nullable|date|after_or_equal:dateFrom',
        'yearFilter'       => 'nullable|string',
        'monthFilter'      => 'nullable|string',
        'departmentFilter' => 'nullable|string',
    ];

    // Reset page saat filter diubah
    public function updatedDateFrom()         { $this->resetPage(); }
    public function updatedDateUntil()        { $this->resetPage(); }
    public function updatedYearFilter()       { $this->resetPage(); }
    public function updatedMonthFilter()      { $this->resetPage(); }
    public function updatedDepartmentFilter() { $this->resetPage(); }

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

    // ==================== BASE QUERY ====================
    /**
     * Base query: BlindTest yang sudah completed, dengan relasi employee.
     */
    protected function getFilteredQuery()
    {
        return BlindTest::query()
            ->with(['employee'])
            ->where('status', 'completed')
            ->when($this->dateFrom, fn ($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateUntil, fn ($q) => $q->whereDate('created_at', '<=', $this->dateUntil))
            ->when($this->yearFilter, fn ($q) => $q->whereYear('created_at', $this->yearFilter))
            ->when($this->monthFilter, fn ($q) => $q->whereMonth('created_at', $this->monthFilter))
            ->when($this->departmentFilter, function ($q) {
                $q->whereHas('employee', fn ($eq) => $eq->where('department', $this->departmentFilter));
            });
    }

    /**
     * Aggregate per-employee:
     * - nik
     * - name
     * - department
     * - fail_count  (jumlah test dengan overall_result = FAIL)
     * - pass_count  (jumlah test dengan overall_result = PASS)
     * - total_soal  (jumlah baris kunci jawaban dari semua test)
     */
    protected function getAggregatedData()
    {
        $records = $this->getFilteredQuery()
            ->orderByDesc('created_at')
            ->get();

        $grouped = $records->groupBy('employee_id')->map(function ($items) {
            $first = $items->first();
            $failCount = $items->where('overall_result', 'FAIL')->count();
            $passCount = $items->where('overall_result', 'PASS')->count();
            $totalSoal = $items->sum(fn ($r) => count($r->blind_test_items ?? []));

            return [
                'employee_id' => $first->employee_id,
                'nik'         => $first->employee->nik ?? '-',
                'name'        => $first->employee->name ?? '-',
                'department'  => $first->employee->department ?? '-',
                'fail_count'  => $failCount,
                'pass_count'  => $passCount,
                'total_soal'  => $totalSoal,
            ];
        })->sortBy('name')->values();

        return $grouped;
    }

    // ==================== ACTIONS ====================
    public function applyFilter()
    {
        $this->validate();
        $this->hasFiltered = true;
        $this->resetPage();

        $data = $this->getAggregatedData();
        $this->totalRecords = $data->count();
        $this->totalFail = $data->sum('fail_count');
        $this->totalPass = $data->sum('pass_count');
        $this->totalSoal = $data->sum('total_soal');

        $this->dispatch('notify',
            message: 'Data found: ' . $this->totalRecords . ' employees',
            type: 'success'
        );
    }

    public function resetFilters()
    {
        $this->reset([
            'dateFrom', 'dateUntil', 'yearFilter', 'monthFilter', 'departmentFilter',
        ]);
        $this->hasFiltered = false;
        $this->totalRecords = 0;
        $this->totalFail = 0;
        $this->totalPass = 0;
        $this->totalSoal = 0;
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

        // Header
        $headers = [
            'A' => 'No',
            'B' => 'NIK',
            'C' => 'Name',
            'D' => 'Department',
            'E' => 'Fail Count',
            'F' => 'Pass Count',
            'G' => 'Total Soal',
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
            $sheet->setCellValue('E' . $row, $item['fail_count']);
            $sheet->setCellValue('F' . $row, $item['pass_count']);
            $sheet->setCellValue('G' . $row, $item['total_soal']);
            $row++;
        }

        // ==================== TOTALS ====================
        $totalFail = $data->sum('fail_count');
        $totalPass = $data->sum('pass_count');
        $totalSoal = $data->sum('total_soal');

        $sheet->setCellValue('A' . $row, '');        // kolom No kosong
        $sheet->setCellValue('B' . $row, '');        // NIK
        $sheet->setCellValue('C' . $row, '');        // Name
        $sheet->setCellValue('D' . $row, 'TOTAL');   // Department → label TOTAL
        $sheet->setCellValue('E' . $row, $totalFail);
        $sheet->setCellValue('F' . $row, $totalPass);
        $sheet->setCellValue('G' . $row, $totalSoal);

        // Style baris TOTAL
        $sheet->getStyle('A' . $row . ':G' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row . ':G' . $row)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFF2CC'); // kuning muda
        $sheet->getStyle('D' . $row . ':G' . $row)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Border seluruh tabel
        $lastRow = $row;
        $sheet->getStyle('A1:G' . $lastRow)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Auto size
        foreach (array_keys($headers) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Freeze header
        $sheet->freezePane('A2');

        // Output
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
        // Ambil data aggregated, paginate manual
        $allData = collect();
        $paginated = collect();

        if ($this->hasFiltered) {
            $allData = $this->getAggregatedData();
            $this->totalRecords = $allData->count();

            // Refresh totals setiap render (kalau-kalau ada perubahan)
            $this->totalFail = $allData->sum('fail_count');
            $this->totalPass = $allData->sum('pass_count');
            $this->totalSoal = $allData->sum('total_soal');

            // Paginate manual
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
            'previewData'   => $paginated,
            'years'         => $this->years,
            'months'        => $this->months,
            'departments'   => $this->departments,
        ])->layout('layouts.app');
    }
}