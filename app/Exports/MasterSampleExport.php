<?php

namespace App\Exports;

use App\Models\PROD\MS\MasterSample;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MasterSampleExport
{
    protected $year;
    protected $month;
    protected $activeTab;
    protected $search;
    protected $filterCustomer;
    protected $filterNameOrMc;

    public function __construct(
        $year = null,
        $month = null,
        $activeTab = 'all',
        $search = '',
        $filterCustomer = '',
        $filterNameOrMc = ''
    ) {
        $this->year           = $year;
        $this->month          = $month;
        $this->activeTab      = $activeTab;
        $this->search         = $search;
        $this->filterCustomer = $filterCustomer;
        $this->filterNameOrMc = $filterNameOrMc;
    }

    // =====================================================
    // QUERY BUILDER
    // =====================================================
    protected function buildQuery()
    {
        $query = MasterSample::with([
            'details.checkedBy',
            'details.knowladgeBy',
            'details.approvedBy',
            'rack',
            'historydDetails' => fn ($q) => $q->orderByDesc('out_date'),
            'historydDetails.masterLine',
            'historydDetails.masterLine.location',
        ]);

        // ============================================================
        // RANGE BULAN EXPORT
        // PENTING: kalau bulan export = bulan sekarang, pakai logika
        // PERSIS SAMA dengan tab (now()->startOfMonth/endOfMonth).
        // ============================================================
        $now = now();
        $exportYear  = (int) ($this->year  ?: $now->year);
        $exportMonth = (int) ($this->month ?: $now->month);

        $isCurrentMonth = ($exportYear === (int) $now->year)
                       && ($exportMonth === (int) $now->month);

        if ($isCurrentMonth) {
            $monthStart = $now->copy()->startOfMonth()->startOfDay();
            $monthEnd   = $now->copy()->endOfMonth()->endOfDay();
        } else {
            $monthStart = Carbon::create($exportYear, $exportMonth, 1)->startOfMonth()->startOfDay();
            $monthEnd   = Carbon::create($exportYear, $exportMonth, 1)->endOfMonth()->endOfDay();
        }

        // ============================================================
        // FILTER UTAMA: expired_date di bulan/tahun terpilih
        // + status ACTIVE (sama seperti tab "Expire This Month")
        // ============================================================
        $query->where('status', 'ACTIVE')
              ->whereHas('details', function ($q) use ($monthStart, $monthEnd) {
                  $q->whereBetween('expired_date', [$monthStart, $monthEnd]);
              });

        // ============================================================
        // TAB FILTER
        // Untuk tab yang sudah filter expired_date sendiri
        // (expire_this_month, expired, active), SKIP karena sudah
        // difilter di atas. Tab lain (eol, under_pe, all) tetap jalan.
        // ============================================================
        $nowStartOfDay = now()->startOfDay();

        switch ($this->activeTab) {
            case 'eol':
                $query->where('status', 'EOL');
                break;
            case 'under_pe':
                $query->where('status', 'UNDER PE');
                break;
            // 'active', 'expired', 'expire_this_month', 'all' → SKIP
            // karena sudah difilter expired_date di bulan export
        }

        // ============================================================
        // SEARCH & FILTER
        // ============================================================
        $query->when($this->search, function ($q) {
            $q->where(function ($q) {
                $q->where('model_name', 'like', '%' . $this->search . '%')
                  ->orWhere('customer', 'like', '%' . $this->search . '%')
                  ->orWhere('name_or_mc', 'like', '%' . $this->search . '%')
                  ->orWhere('sample_ok', 'like', '%' . $this->search . '%')
                  ->orWhere('sample_ng', 'like', '%' . $this->search . '%');
            });
        })
        ->when($this->filterCustomer, fn ($q) => $q->where('customer', $this->filterCustomer))
        ->when($this->filterNameOrMc, fn ($q) => $q->where('name_or_mc', $this->filterNameOrMc));

        return $query->orderBy('id', 'asc');
    }

    /**
     * Hitung jumlah data (untuk preview & validasi)
     */
    public function count(): int
    {
        return $this->buildQuery()->count();
    }

    // =====================================================
    // HEADINGS
    // =====================================================
    protected function headings(): array
    {
        return [
            'No', 'Model Name', 'Customer', 'Name / MC',
            'Sample OK', 'Sample OK Backup', 'Sample NG', 'Sample Blank',
            'Rack Type', 'Rack Column', 'Rack Sheet', 'Rack Backup',
            'Status', 'Remarks',
            'Updated Date', 'Expired Date', 'Alarm Date',
            'Latest Expired Date', 'Expiration Status', 'Days Remaining',
            'Checked By', 'Knowledge By', 'Approved By',
            'Loan Status', 'Last Location', 'Last Line', 'Last Use Remarks',
            'Created At', 'Updated At',
        ];
    }

    // =====================================================
    // MAP ROW
    // =====================================================
    protected function mapRow($no, $sample): array
    {
        $latestDetail  = $sample->details->sortByDesc('expired_date')->first();
        $latestHistory = $sample->historydDetails->first();

        $latestExpiredDate = '-';
        $latestStatus      = 'Expire Not Set';
        $daysRemaining     = '-';

        if ($latestDetail && $latestDetail->expired_date) {
            $expired           = Carbon::parse($latestDetail->expired_date);
            $latestExpiredDate = $expired->format('Y-m-d');
            $latestStatus      = $expired->isFuture() ? 'Active' : 'Expired';

            $diff = Carbon::today()->diffInDays($expired->copy()->startOfDay(), false);
            if ($diff > 0) {
                $daysRemaining = "$diff days";
            } elseif ($diff === 0) {
                $daysRemaining = 'Today';
            } else {
                $daysRemaining = 'Overdue ' . abs($diff) . ' days';
            }
        } else {
            if ($sample->status === 'EOL') {
                $latestExpiredDate = 'EOL';
                $latestStatus      = 'EOL';
                $daysRemaining     = 'EOL';
            } elseif ($sample->status === 'NOT USE') {
                $latestExpiredDate = 'Not Use';
                $latestStatus      = 'Not Use';
                $daysRemaining     = 'Not Use';
            }
        }

        $loanStatusRaw = (string) ($latestHistory?->status ?? '-');
        $loanStatus    = match ($loanStatusRaw) {
            'in_use'   => 'In Use',
            'loaning'  => 'Loaning',
            'ecr'      => 'ECR',
            'stand_by' => 'Stand By',
            '-'        => 'No History',
            default    => ucfirst($loanStatusRaw),
        };

        return [
            $no,
            $sample->model_name ?? '-',
            $sample->customer ?? '-',
            $sample->name_or_mc ?? '-',
            $sample->sample_ok ?? '-',
            $sample->sample_ok_backup ? 'YES' : 'NO',
            $sample->sample_ng ?? '-',
            $sample->sample_blank ? 'YES' : 'NO',
            $sample->rack->type_rack ?? '-',
            $sample->rack->column_rack ?? '-',
            $sample->rack->sheet_rack ?? '-',
            $sample->rack_backup ?? '-',
            $sample->status ?? 'ACTIVE',
            $sample->remarks ?? '-',
            $latestDetail?->updated_date ? Carbon::parse($latestDetail->updated_date)->format('Y-m-d') : '-',
            $latestDetail?->expired_date ? Carbon::parse($latestDetail->expired_date)->format('Y-m-d') : '-',
            $latestDetail?->date_alarm ? Carbon::parse($latestDetail->date_alarm)->format('Y-m-d') : '-',
            $latestExpiredDate,
            $latestStatus,
            $daysRemaining,
            $latestDetail?->checkedBy?->name ?? '-',
            $latestDetail?->knowladgeBy?->name ?? '-',
            $latestDetail?->approvedBy?->name ?? '-',
            $loanStatus,
            $latestHistory?->masterLine?->location?->location_name ?? '-',
            $latestHistory?->masterLine?->line_number ?? '-',
            $latestHistory?->remarks ?? '-',
            $sample->created_at ? $sample->created_at->format('Y-m-d H:i:s') : '-',
            $sample->updated_at ? $sample->updated_at->format('Y-m-d H:i:s') : '-',
        ];
    }

    // =====================================================
    // BUILD
    // =====================================================
    public function build(): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Master Sample');

        $headings   = $this->headings();
        $lastColumn = $this->getColumnLetter(count($headings));
        $startRow   = 5;

        // Title
        $sheet->mergeCells("A1:{$lastColumn}1");
        $sheet->setCellValue('A1', 'MASTER SAMPLE REPORT');
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 16, 'color' => ['argb' => 'FFFFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1E3A8A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Periode
        $period = '-';
        if ($this->month && $this->year) {
            $period = Carbon::createFromDate($this->year, $this->month, 1)->format('F Y');
        } elseif ($this->year) {
            $period = 'Year ' . $this->year;
        } elseif ($this->month) {
            $period = 'Month ' . Carbon::create()->month($this->month)->format('F');
        }

        $sheet->mergeCells("A2:{$lastColumn}2");
        $sheet->setCellValue('A2', 'Period: ' . $period
            . '   |   Tab: ' . strtoupper($this->activeTab)
            . '   |   Generated: ' . now()->format('d M Y H:i'));
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['italic' => true, 'size' => 10],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Header
        $col = 'A';
        foreach ($headings as $heading) {
            $sheet->setCellValue($col . $startRow, $heading);
            $col++;
        }

        $sheet->getStyle("A{$startRow}:{$lastColumn}{$startRow}")->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 10],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1E40AF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']]],
        ]);
        $sheet->getRowDimension($startRow)->setRowHeight(30);

        // Data
        $samples = $this->buildQuery()->get();
        $row     = $startRow + 1;
        $no      = 1;

        foreach ($samples as $sample) {
            $data = $this->mapRow($no, $sample);
            $col  = 'A';
            foreach ($data as $value) {
                $sheet->setCellValueExplicit($col . $row, (string) $value, DataType::TYPE_STRING);
                $col++;
            }
            $no++;
            $row++;
        }

        $lastDataRow = $row - 1;

        $sheet->mergeCells("A3:{$lastColumn}3");
        $sheet->setCellValue('A3', 'Total Records: ' . ($lastDataRow - $startRow));
        $sheet->getStyle('A3')->applyFromArray([
            'font'      => ['size' => 10, 'bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);

        if ($lastDataRow >= $startRow + 1) {
            $sheet->getStyle("A" . ($startRow + 1) . ":{$lastColumn}{$lastDataRow}")->applyFromArray([
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFCBD5E1']]],
                'alignment' => ['vertical' => Alignment::VERTICAL_TOP],
                'font'      => ['size' => 10],
            ]);

            for ($r = $startRow + 1; $r <= $lastDataRow; $r++) {
                if (($r - $startRow) % 2 === 0) {
                    $sheet->getStyle("A{$r}:{$lastColumn}{$r}")->getFill()
                        ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF8FAFC');
                }
            }
        }

        $widths = [
            'A' => 6, 'B' => 25, 'C' => 15, 'D' => 15, 'E' => 15,
            'F' => 12, 'G' => 15, 'H' => 12, 'I' => 15, 'J' => 10,
            'K' => 10, 'L' => 18, 'M' => 12, 'N' => 25, 'O' => 14,
            'P' => 14, 'Q' => 14, 'R' => 18, 'S' => 15, 'T' => 15,
            'U' => 18, 'V' => 18, 'W' => 18, 'X' => 14, 'Y' => 20,
            'Z' => 12, 'AA' => 25, 'AB' => 20, 'AC' => 20,
        ];
        foreach ($widths as $letter => $width) {
            $sheet->getColumnDimension($letter)->setWidth($width);
        }

        $sheet->freezePane('A' . ($startRow + 1));
        $sheet->setAutoFilter("A{$startRow}:{$lastColumn}{$startRow}");

        return $spreadsheet;
    }

    // =====================================================
    // DOWNLOAD
    // =====================================================
    public function download(string $filename): StreamedResponse
    {
        $spreadsheet = $this->build();

        $response = new StreamedResponse(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            $spreadsheet->disconnectWorksheets();
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        $response->headers->set('Cache-Control', 'max-age=0');
        $response->headers->set('Pragma', 'public');

        return $response;
    }

    protected function getColumnLetter(int $number): string
    {
        $letter = '';
        while ($number > 0) {
            $mod    = ($number - 1) % 26;
            $letter = chr(65 + $mod) . $letter;
            $number = intdiv($number - 1, 26);
        }
        return $letter;
    }
}