<?php

namespace App\Livewire\QAQC\BlindTest;

use App\Models\QAQC\BlindTest\BlindTest;
use App\Models\QAQC\BlindTest\Deffect;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BlindTestDeffectReport extends Component
{
    use WithPagination;

    // ==================== FILTERS ====================
    public $yearFilter = '';
    public $monthFilter = '';
    public $sectionFilter = '';

    // ==================== STATE ====================
    public $hasFiltered = false;
    public $totalRecords = 0;

    // Summary
    public $totalFail = 0;
    public $totalPass = 0;
    public $totalAll = 0;

    protected $rules = [
        'yearFilter'    => 'nullable|string',
        'monthFilter'   => 'nullable|string',
        'sectionFilter' => 'nullable|string',
    ];

    // Reset page saat filter berubah
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

    public function getSectionsProperty()
    {
        return BlindTest::query()
            ->where('status', 'completed')
            ->whereNotNull('section')
            ->where('section', '!=', '')
            ->distinct()
            ->orderBy('section')
            ->pluck('section');
    }

    protected function getFilteredQuery()
    {
        return BlindTest::query()
            ->with(['employee'])
            ->where('status', 'completed')
            ->when($this->yearFilter, fn ($q) => $q->whereYear('created_at', $this->yearFilter))
            ->when($this->monthFilter, fn ($q) => $q->whereMonth('created_at', $this->monthFilter))
            ->when($this->sectionFilter, fn ($q) => $q->where('section', $this->sectionFilter));
    }

    /**
     * Aggregate per-deffect item berdasarkan JUMLAH ORANG yang menjawab.
     *
     * Logika:
     * - Setiap BlindTest (status completed) = 1 orang peserta.
     * - Setiap test punya blind_test_items (kunci soal) dan user_answers (jawaban orang tsb).
     * - Untuk setiap defect di KUNCI:
     *     TOTAL = jumlah orang yang mendapat defect tsb sebagai soal
     *     PASS  = jumlah orang yang menjawab benar defect tsb
     *     FAIL  = TOTAL - PASS
     */
    protected function getAggregatedData()
    {
        $records = $this->getFilteredQuery()->get();

        // deffect_item_id => ['total' => 0, 'pass' => 0]
        $bucket = [];

        foreach ($records as $bt) {
            $keys = collect($bt->blind_test_items ?? []);
            $userAnswers = collect($bt->user_answers ?? []);

            // Map user answers by "deffect_id|location" => is_correct
            $userMap = $userAnswers->mapWithKeys(function ($ua) {
                $key = (int) ($ua['deffect_item_id'] ?? 0) . '|' . strtoupper(trim((string) ($ua['component_location'] ?? '')));
                return [$key => (bool) ($ua['is_correct'] ?? false)];
            })->toArray();

            // Kumpulkan defect unik per orang (hindari double count)
            $seenInThisTest = [];

            foreach ($keys as $keyItem) {
                $deffectId = (int) ($keyItem['deffect_item_id'] ?? 0);
                $location  = strtoupper(trim((string) ($keyItem['component_location'] ?? '')));
                $lookupKey = $deffectId . '|' . $location;

                // Skip kalau defect ini sudah dihitung untuk orang ini
                if (isset($seenInThisTest[$lookupKey])) {
                    continue;
                }
                $seenInThisTest[$lookupKey] = true;

                if (!isset($bucket[$deffectId])) {
                    $bucket[$deffectId] = ['total' => 0, 'pass' => 0];
                }

                // TOTAL = +1 orang
                $bucket[$deffectId]['total']++;

                // PASS = +1 orang kalau jawabannya benar
                if (!empty($userMap[$lookupKey])) {
                    $bucket[$deffectId]['pass']++;
                }
            }
        }

        // Ambil nama defect
        $deffectIds = array_keys($bucket);
        $deffects = Deffect::whereIn('id', $deffectIds)->get()->keyBy('id');

        $result = collect($bucket)->map(function ($v, $deffectId) use ($deffects) {
            $total = $v['total'];   // jumlah orang
            $pass  = $v['pass'];    // jumlah orang jawab BENAR
            $fail  = $total - $pass; // jumlah orang jawab SALAH

            return [
                'deffect_id'   => $deffectId,
                'deffect_name' => $deffects[$deffectId]->deffect_item_name ?? '(Deleted Deffect #'.$deffectId.')',
                'fail'         => $fail,
                'pass'         => $pass,
                'total'        => $total,
            ];
        })->sortByDesc('total')->values();

        return $result;
    }

    // ==================== ACTIONS ====================
    public function applyFilter()
    {
        $this->validate();
        $this->hasFiltered = true;
        $this->resetPage();

        $data = $this->getAggregatedData();
        $this->totalRecords = $data->count();
        $this->totalFail = $data->sum('fail');
        $this->totalPass = $data->sum('pass');
        $this->totalAll  = $data->sum('total');

        $this->dispatch('notify',
            message: 'Data found: ' . $this->totalRecords . ' defect items',
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
        $this->totalAll = 0;
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
            'B' => 'Deffect Name',
            'C' => 'FAIL',
            'D' => 'PASS',
            'E' => 'TOTAL',
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

        // Data
        $row = 2;
        $no = 1;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $item['deffect_name']);
            $sheet->setCellValue('C' . $row, $item['fail']);
            $sheet->setCellValue('D' . $row, $item['pass']);
            $sheet->setCellValue('E' . $row, $item['total']);
            $row++;
        }

        // ==================== SUMMARY ====================
        $totalFail = $data->sum('fail');
        $totalPass = $data->sum('pass');
        $totalAll  = $data->sum('total');

        $sheet->setCellValue('A' . $row, '');
        $sheet->setCellValue('B' . $row, 'TOTAL');
        $sheet->setCellValue('C' . $row, $totalFail);
        $sheet->setCellValue('D' . $row, $totalPass);
        $sheet->setCellValue('E' . $row, $totalAll);

        // Style summary
        $sheet->getStyle('A' . $row . ':E' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row . ':E' . $row)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFF2CC');
        $sheet->getStyle('B' . $row . ':E' . $row)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Border seluruh tabel
        $sheet->getStyle('A1:E' . $row)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Auto size
        foreach (array_keys($headers) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->freezePane('A2');

        $fileName = 'laporan_blind_test_by_deffect_' . date('Y-m-d_H-i-s') . '.xlsx';

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
        $paginated = collect();

        if ($this->hasFiltered) {
            $allData = $this->getAggregatedData();
            $this->totalRecords = $allData->count();
            $this->totalFail = $allData->sum('fail');
            $this->totalPass = $allData->sum('pass');
            $this->totalAll  = $allData->sum('total');

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

        return view('livewire.qaqc.blind-test.blind-test-deffect-report', [
            'previewData' => $paginated,
            'years'       => $this->years,
            'months'      => $this->months,
            'sections'    => $this->sections,
        ])->layout('layouts.app');
    }
}