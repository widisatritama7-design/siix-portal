<?php

namespace App\Livewire\QAQC\ScanXray;

use App\Models\MTC\Master\MasterLine;
use App\Models\QAQC\BlindTest\Customer;
use App\Models\QAQC\BlindTest\Model as BlindTestModel;
use App\Models\QAQC\ScanXray\ScanXray;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ScanXrayIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $filterCustomerId = null;
    public $filterModelId = null;
    public $filterDateFrom = null;
    public $filterDateUntil = null;
    public $filterYear = null;
    public $filterMonth = null;
    public $filterMasterLineId = null;

    public $scanToDelete = null;

    public bool $isStacked = true;

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedFilterCustomerId(): void
    {
        $this->filterModelId = null;
        $this->resetPage();
    }
    public function updatedFilterModelId(): void { $this->resetPage(); }
    public function updatedFilterDateFrom(): void { $this->resetPage(); }
    public function updatedFilterDateUntil(): void { $this->resetPage(); }
    public function updatedFilterYear(): void { $this->resetPage(); }
    public function updatedFilterMonth(): void { $this->resetPage(); }
    public function updatedFilterMasterLineId(): void { $this->resetPage(); }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->filterCustomerId = null;
        $this->filterModelId = null;
        $this->filterDateFrom = null;
        $this->filterDateUntil = null;
        $this->filterYear = null;
        $this->filterMonth = null;
        $this->filterMasterLineId = null;
        $this->resetPage();
    }

    public function hasActiveFilter(): bool
    {
        return $this->search
            || $this->filterCustomerId
            || $this->filterModelId
            || $this->filterDateFrom
            || $this->filterDateUntil
            || $this->filterYear
            || $this->filterMonth
            || $this->filterMasterLineId;
    }

    public function toggleStack(): void
    {
        $this->isStacked = !$this->isStacked;
        session(['scan_xray_stacked' => $this->isStacked]);
    }

    public function mount(): void
    {
        $this->isStacked = session('scan_xray_stacked', true);
    }

    // ============ SUMMARY ============
    public function buildSummary(ScanXray $scan): array
    {
        // 4 grup utama (dengan judgement)
        $mainGroups = [
            'first'  => $scan->first_piece_items  ?? [],
            'middle' => $scan->middle_piece_items ?? [],
            'last'   => $scan->last_piece_items   ?? [],
        ];

        $summary = [];
        $totalOk = 0;
        $totalNg = 0;

        foreach ($mainGroups as $key => $item) {
            $ok    = (int) ($item['ok_qty'] ?? 0);
            $ng    = (int) ($item['ng_qty'] ?? 0);
            $total = $ok + $ng;
            $rr    = $total > 0 ? round(($ng / $total) * 100, 2) : 0;

            $summary[$key] = [
                'ok_qty'         => $ok,
                'ng_qty'         => $ng,
                'reject_rate'    => $rr,
                'status_running' => $item['status_running'] ?? null,
            ];

            $totalOk += $ok;
            $totalNg += $ng;
        }

        // 3 grup second piece (hanya QTY + Status)
        $secondGroups = [
            'second_first'  => [$scan->second_first_items  ?? [], 'first'],
            'second_middle' => [$scan->second_middle_items ?? [], 'middle'],
            'second_last'   => [$scan->second_last_items   ?? [], 'last'],
        ];

        foreach ($secondGroups as $key => [$item, $parent]) {
            $qty = $this->countSecondQty($item, $scan->pcb_type);

            $summary[$key] = [
                'qty'            => $qty,
                'status_running' => $item['status_running'] ?? null,
            ];

            // QTY second dihitung masuk ke total OK
            $totalOk += $qty;
        }

        $grand = $totalOk + $totalNg;
        $summary['total'] = [
            'ok_qty'      => $totalOk,
            'ng_qty'      => $totalNg,
            'reject_rate' => $grand > 0 ? round(($totalNg / $grand) * 100, 2) : 0,
        ];

        return $summary;
    }

    /**
     * Hitung QTY Second Piece = jumlah row di side aktif yang minimal punya 1 PCB terisi.
     */
    protected function countSecondQty(?array $item, ?string $pcbType): int
    {
        if (empty($item) || !$pcbType) return 0;

        $side = match ($pcbType) {
            'SINGLE' => 'side_single',
            'LH'     => 'side_lh',
            'RH'     => 'side_rh',
            default  => null,
        };
        if (!$side) return 0;

        $sideData = $item[$side] ?? [];
        $pcbCols  = ['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'];

        $maxRows = 0;
        foreach ($pcbCols as $col) {
            $maxRows = max($maxRows, count($sideData[$col] ?? []));
        }

        $qty = 0;
        for ($i = 0; $i < $maxRows; $i++) {
            foreach ($pcbCols as $col) {
                if (!empty($sideData[$col][$i] ?? null)) {
                    $qty++;
                    break;
                }
            }
        }

        return $qty;
    }

    // ============ EXPORT EXCEL ============
    public function exportExcel()
    {
        if (!auth()->user()->can('view scan xray')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $query = ScanXray::with(['customer', 'model', 'masterLine.location', 'creator']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('customer', fn ($qq) => $qq->where('customer_name', 'like', '%' . $this->search . '%'))
                ->orWhereHas('model', fn ($qq) => $qq->where('model_name', 'like', '%' . $this->search . '%'))
                ->orWhere('shift', 'like', '%' . $this->search . '%')
                ->orWhere('group', 'like', '%' . $this->search . '%')
                ->orWhere('pcb_type', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterCustomerId)    $query->where('customer_id', $this->filterCustomerId);
        if ($this->filterModelId)       $query->where('model_id', $this->filterModelId);
        if ($this->filterDateFrom)      $query->whereDate('created_at', '>=', $this->filterDateFrom);
        if ($this->filterDateUntil)     $query->whereDate('created_at', '<=', $this->filterDateUntil);
        if ($this->filterYear)          $query->whereYear('created_at', $this->filterYear);
        if ($this->filterMonth)         $query->whereMonth('created_at', $this->filterMonth);
        if ($this->filterMasterLineId)  $query->where('master_line_id', $this->filterMasterLineId);

        $scans = $query->orderByDesc('id')->get();

        if ($scans->isEmpty()) {
            $this->dispatch('notify', message: 'Tidak ada data untuk di-export.', type: 'warning');
            return;
        }

        // ============ STYLE ============
        $headerStyle = [
            'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF4472C4']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
        ];
        $groupFirstStyle = [
            'font'      => ['bold' => true, 'color' => ['argb' => 'FF1E40AF'], 'size' => 10],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFDBEAFE']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ];
        $groupSecondStyle = [
            'font'      => ['bold' => true, 'color' => ['argb' => 'FF0891B2'], 'size' => 10],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFCFFAFE']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ];
        $groupMiddleStyle = [
            'font'      => ['bold' => true, 'color' => ['argb' => 'FF3730A3'], 'size' => 10],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE0E7FF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ];
        $groupLastStyle = [
            'font'      => ['bold' => true, 'color' => ['argb' => 'FF6B21A8'], 'size' => 10],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF3E8FF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ];
        $groupTotalStyle = [
            'font'      => ['bold' => true, 'color' => ['argb' => 'FF047857'], 'size' => 10],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD1FAE5']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ];
        $groupPicStyle = [
            'font'      => ['bold' => true, 'color' => ['argb' => 'FF3F3F46'], 'size' => 10],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF4F4F5']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ];
        $totalStyle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFF2CC']],
        ];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Scan X-Ray');

        // ============ TITLE ============
        // Layout kolom (28 kolom, A..AB):
        // A-H    : # Customer Model PCB Shift Group Line LotQty       (8)
        // I-L    : First         OK, NG, RR, Status                  (4)
        // M-N    : Second First  QTY, Status                          (2)
        // O-R    : Middle        OK, NG, RR, Status                  (4)
        // S-T    : Second Middle QTY, Status                          (2)
        // U-X    : Last          OK, NG, RR, Status                  (4)
        // Y-Z    : Second Last   QTY, Status                          (2)
        // AA-AC  : Total         OK, NG, RR                           (3)
        // AD-AF  : PIC           Date, Time, PIC                      (3)
        $lastCol = 'AF';

        $sheet->setCellValue('A1', 'SCAN X-RAY REPORT');
        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14)->getColor()->setARGB('FF1E3A8A');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'PT. SIIX EMS INDONESIA — QA/QC Department');
        $sheet->mergeCells("A2:{$lastCol}2");
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(10)->getColor()->setARGB('FF666666');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $filterText = [];
        if ($this->search)              $filterText[] = 'Search: ' . $this->search;
        if ($this->filterCustomerId)    $filterText[] = 'Customer: ' . (Customer::find($this->filterCustomerId)?->customer_name ?? '-');
        if ($this->filterModelId)       $filterText[] = 'Model: ' . (BlindTestModel::find($this->filterModelId)?->model_name ?? '-');
        if ($this->filterMasterLineId) {
            $line = MasterLine::with('location')->find($this->filterMasterLineId);
            if ($line) $filterText[] = 'Line: ' . ($line->location->location_name ?? '-') . ' L' . $line->line_number;
        }
        if ($this->filterDateFrom)      $filterText[] = 'From: ' . $this->filterDateFrom;
        if ($this->filterDateUntil)     $filterText[] = 'Until: ' . $this->filterDateUntil;
        if ($this->filterYear)          $filterText[] = 'Year: ' . $this->filterYear;
        if ($this->filterMonth)         $filterText[] = 'Month: ' . $this->filterMonth;

        $sheet->setCellValue('A3', $filterText ? 'Filter: ' . implode(' | ', $filterText) : 'Filter: None');
        $sheet->mergeCells("A3:{$lastCol}3");
        $sheet->getStyle('A3')->getFont()->setItalic(true)->setSize(9)->getColor()->setARGB('FF2563EB');
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A4', 'Generated: ' . now()->format('d M Y, H:i') . ' | By: ' . (auth()->user()?->name ?? '-'));
        $sheet->mergeCells("A4:{$lastCol}4");
        $sheet->getStyle('A4')->getFont()->setSize(9)->getColor()->setARGB('FF666666');
        $sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // ============ HEADER ============
        $headerRow1 = 6;
        $headerRow2 = 7;

        // Fixed
        $sheet->setCellValue('A' . $headerRow1, '#');           $sheet->mergeCells("A{$headerRow1}:A{$headerRow2}");
        $sheet->setCellValue('B' . $headerRow1, 'Customer');    $sheet->mergeCells("B{$headerRow1}:B{$headerRow2}");
        $sheet->setCellValue('C' . $headerRow1, 'Model');       $sheet->mergeCells("C{$headerRow1}:C{$headerRow2}");
        $sheet->setCellValue('D' . $headerRow1, 'PCB Type');    $sheet->mergeCells("D{$headerRow1}:D{$headerRow2}");
        $sheet->setCellValue('E' . $headerRow1, 'Shift');       $sheet->mergeCells("E{$headerRow1}:E{$headerRow2}");
        $sheet->setCellValue('F' . $headerRow1, 'Group');       $sheet->mergeCells("F{$headerRow1}:F{$headerRow2}");
        $sheet->setCellValue('G' . $headerRow1, 'Line');        $sheet->mergeCells("G{$headerRow1}:G{$headerRow2}");
        $sheet->setCellValue('H' . $headerRow1, 'Lot Qty');     $sheet->mergeCells("H{$headerRow1}:H{$headerRow2}");

        // First  I..L
        $sheet->setCellValue('I' . $headerRow1, 'First Piece Items');
        $sheet->mergeCells("I{$headerRow1}:L{$headerRow1}");
        $sheet->setCellValue('I' . $headerRow2, 'OK');
        $sheet->setCellValue('J' . $headerRow2, 'NG');
        $sheet->setCellValue('K' . $headerRow2, 'Reject Rate %');
        $sheet->setCellValue('L' . $headerRow2, 'Status');

        // Second First  M..N
        $sheet->setCellValue('M' . $headerRow1, 'Second First Piece');
        $sheet->mergeCells("M{$headerRow1}:N{$headerRow1}");
        $sheet->setCellValue('M' . $headerRow2, 'QTY');
        $sheet->setCellValue('N' . $headerRow2, 'Status');

        // Middle  O..R
        $sheet->setCellValue('O' . $headerRow1, 'Middle Piece Items');
        $sheet->mergeCells("O{$headerRow1}:R{$headerRow1}");
        $sheet->setCellValue('O' . $headerRow2, 'OK');
        $sheet->setCellValue('P' . $headerRow2, 'NG');
        $sheet->setCellValue('Q' . $headerRow2, 'Reject Rate %');
        $sheet->setCellValue('R' . $headerRow2, 'Status');

        // Second Middle  S..T
        $sheet->setCellValue('S' . $headerRow1, 'Second Middle Piece');
        $sheet->mergeCells("S{$headerRow1}:T{$headerRow1}");
        $sheet->setCellValue('S' . $headerRow2, 'QTY');
        $sheet->setCellValue('T' . $headerRow2, 'Status');

        // Last  U..X
        $sheet->setCellValue('U' . $headerRow1, 'Last Piece Items');
        $sheet->mergeCells("U{$headerRow1}:X{$headerRow1}");
        $sheet->setCellValue('U' . $headerRow2, 'OK');
        $sheet->setCellValue('V' . $headerRow2, 'NG');
        $sheet->setCellValue('W' . $headerRow2, 'Reject Rate %');
        $sheet->setCellValue('X' . $headerRow2, 'Status');

        // Second Last  Y..Z
        $sheet->setCellValue('Y' . $headerRow1, 'Second Last Piece');
        $sheet->mergeCells("Y{$headerRow1}:Z{$headerRow1}");
        $sheet->setCellValue('Y' . $headerRow2, 'QTY');
        $sheet->setCellValue('Z' . $headerRow2, 'Status');

        // Total  AA..AC
        $sheet->setCellValue('AA' . $headerRow1, 'Total');
        $sheet->mergeCells("AA{$headerRow1}:AC{$headerRow1}");
        $sheet->setCellValue('AA' . $headerRow2, 'OK');
        $sheet->setCellValue('AB' . $headerRow2, 'NG');
        $sheet->setCellValue('AC' . $headerRow2, 'Reject Rate %');

        // PIC  AD..AF
        $sheet->setCellValue('AD' . $headerRow1, 'PIC Info');
        $sheet->mergeCells("AD{$headerRow1}:AF{$headerRow1}");
        $sheet->setCellValue('AD' . $headerRow2, 'Date');
        $sheet->setCellValue('AE' . $headerRow2, 'Time');
        $sheet->setCellValue('AF' . $headerRow2, 'PIC');

        // Style header
        $sheet->getStyle("A{$headerRow1}:{$lastCol}{$headerRow2}")->applyFromArray($headerStyle);
        $sheet->getStyle("I{$headerRow1}:L{$headerRow1}")->applyFromArray($groupFirstStyle);
        $sheet->getStyle("M{$headerRow1}:N{$headerRow1}")->applyFromArray($groupSecondStyle);
        $sheet->getStyle("O{$headerRow1}:R{$headerRow1}")->applyFromArray($groupMiddleStyle);
        $sheet->getStyle("S{$headerRow1}:T{$headerRow1}")->applyFromArray($groupSecondStyle);
        $sheet->getStyle("U{$headerRow1}:X{$headerRow1}")->applyFromArray($groupLastStyle);
        $sheet->getStyle("Y{$headerRow1}:Z{$headerRow1}")->applyFromArray($groupSecondStyle);
        $sheet->getStyle("AA{$headerRow1}:AC{$headerRow1}")->applyFromArray($groupTotalStyle);
        $sheet->getStyle("AD{$headerRow1}:AF{$headerRow1}")->applyFromArray($groupPicStyle);

        $sheet->getStyle("I{$headerRow2}:L{$headerRow2}")->applyFromArray($groupFirstStyle);
        $sheet->getStyle("M{$headerRow2}:N{$headerRow2}")->applyFromArray($groupSecondStyle);
        $sheet->getStyle("O{$headerRow2}:R{$headerRow2}")->applyFromArray($groupMiddleStyle);
        $sheet->getStyle("S{$headerRow2}:T{$headerRow2}")->applyFromArray($groupSecondStyle);
        $sheet->getStyle("U{$headerRow2}:X{$headerRow2}")->applyFromArray($groupLastStyle);
        $sheet->getStyle("Y{$headerRow2}:Z{$headerRow2}")->applyFromArray($groupSecondStyle);
        $sheet->getStyle("AA{$headerRow2}:AC{$headerRow2}")->applyFromArray($groupTotalStyle);
        $sheet->getStyle("AD{$headerRow2}:AF{$headerRow2}")->applyFromArray($groupPicStyle);

        // ============ DATA ============
        $row = $headerRow2 + 1;
        $no  = 1;

        $sumFirstOk = 0;   $sumFirstNg = 0;
        $sumSecondFirstQty = 0;
        $sumMidOk   = 0;   $sumMidNg = 0;
        $sumSecondMiddleQty = 0;
        $sumLastOk  = 0;   $sumLastNg = 0;
        $sumSecondLastQty = 0;

        foreach ($scans as $scan) {
            $s = $this->buildSummary($scan);

            // First
            $fOk = $s['first']['ok_qty'];
            $fNg = $s['first']['ng_qty'];

            // Second first
            $sfQty = $s['second_first']['qty'];

            // Middle
            $mOk = $s['middle']['ok_qty'];
            $mNg = $s['middle']['ng_qty'];

            // Second middle
            $smQty = $s['second_middle']['qty'];

            // Last
            $lOk = $s['last']['ok_qty'];
            $lNg = $s['last']['ng_qty'];

            // Second last
            $slQty = $s['second_last']['qty'];

            $sumFirstOk        += $fOk;  $sumFirstNg        += $fNg;
            $sumSecondFirstQty += $sfQty;
            $sumMidOk          += $mOk;  $sumMidNg          += $mNg;
            $sumSecondMiddleQty += $smQty;
            $sumLastOk         += $lOk;  $sumLastNg         += $lNg;
            $sumSecondLastQty  += $slQty;

            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $scan->customer->customer_name ?? '-');
            $sheet->setCellValue('C' . $row, $scan->model->model_name ?? '-');
            $sheet->setCellValue('D' . $row, $scan->pcb_type ?? '-');
            $sheet->setCellValue('E' . $row, $scan->shift ?? '-');
            $sheet->setCellValue('F' . $row, $scan->group ?? '-');
            $sheet->setCellValue('G' . $row, ($scan->masterLine->location->location_name ?? '-') . ' - L' . ($scan->masterLine->line_number ?? '-'));
            $sheet->setCellValue('H' . $row, $scan->lot_qty ?? 0);

            // First
            $sheet->setCellValue('I' . $row, $fOk);
            $sheet->setCellValue('J' . $row, $fNg);
            $sheet->setCellValue('K' . $row, $s['first']['reject_rate'] . '%');
            $sheet->setCellValue('L' . $row, $scan->first_piece_items['status_running'] ?? '-');

            // Second first
            $sheet->setCellValue('M' . $row, $sfQty);
            $sheet->setCellValue('N' . $row, $scan->second_first_items['status_running'] ?? '-');

            // Middle
            $sheet->setCellValue('O' . $row, $mOk);
            $sheet->setCellValue('P' . $row, $mNg);
            $sheet->setCellValue('Q' . $row, $s['middle']['reject_rate'] . '%');
            $sheet->setCellValue('R' . $row, $scan->middle_piece_items['status_running'] ?? '-');

            // Second middle
            $sheet->setCellValue('S' . $row, $smQty);
            $sheet->setCellValue('T' . $row, $scan->second_middle_items['status_running'] ?? '-');

            // Last
            $sheet->setCellValue('U' . $row, $lOk);
            $sheet->setCellValue('V' . $row, $lNg);
            $sheet->setCellValue('W' . $row, $s['last']['reject_rate'] . '%');
            $sheet->setCellValue('X' . $row, $scan->last_piece_items['status_running'] ?? '-');

            // Second last
            $sheet->setCellValue('Y' . $row, $slQty);
            $sheet->setCellValue('Z' . $row, $scan->second_last_items['status_running'] ?? '-');

            // Total
            $sheet->setCellValue('AA' . $row, $s['total']['ok_qty']);
            $sheet->setCellValue('AB' . $row, $s['total']['ng_qty']);
            $sheet->setCellValue('AC' . $row, $s['total']['reject_rate'] . '%');

            // PIC
            $sheet->setCellValue('AD' . $row, $scan->created_at?->format('d/m/Y') ?? '-');
            $sheet->setCellValue('AE' . $row, $scan->created_at?->format('H:i') ?? '-');
            $sheet->setCellValue('AF' . $row, $scan->creator->name ?? $scan->creator->username ?? '-');

            // Warna RR cell
            foreach (['K' => $s['first']['reject_rate'], 'Q' => $s['middle']['reject_rate'], 'W' => $s['last']['reject_rate'], 'AC' => $s['total']['reject_rate']] as $col => $rr) {
                $fillColor = $rr >= 5 ? 'FFEF4444' : ($rr > 0 ? 'FFF59E0B' : 'FF10B981');
                $sheet->getStyle($col . $row)->getFill()
                    ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($fillColor);
                $sheet->getStyle($col . $row)->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
                $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }

            // Warna OK (hijau) — termasuk QTY second (dianggap OK)
            foreach (['I' => $fOk, 'M' => $sfQty, 'O' => $mOk, 'S' => $smQty, 'U' => $lOk, 'Y' => $slQty, 'AA' => $s['total']['ok_qty']] as $col => $v) {
                $sheet->getStyle($col . $row)->getFont()->setBold(true)->getColor()->setARGB('FF047857');
                $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
            // Warna NG (merah)
            foreach (['J' => $fNg, 'P' => $mNg, 'V' => $lNg, 'AB' => $s['total']['ng_qty']] as $col => $v) {
                $sheet->getStyle($col . $row)->getFont()->setBold(true)->getColor()->setARGB('FFDC2626');
                $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }

            // Alignment center untuk kolom pendek
            foreach (['A','D','E','F','H','L','N','R','T','X','Z','AD','AE'] as $col) {
                $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }

            $row++;
        }

        // ============ FOOTER TOTAL ============
        $grandOk = $sumFirstOk + $sumSecondFirstQty + $sumMidOk + $sumSecondMiddleQty + $sumLastOk + $sumSecondLastQty;
        $grandNg = $sumFirstNg + $sumMidNg + $sumLastNg;
        $grandRR = ($grandOk + $grandNg) > 0 ? round(($grandNg / ($grandOk + $grandNg)) * 100, 2) : 0;

        $sheet->setCellValue('H' . $row, 'TOTAL');
        $sheet->setCellValue('I' . $row, $sumFirstOk);
        $sheet->setCellValue('J' . $row, $sumFirstNg);
        $sheet->setCellValue('M' . $row, $sumSecondFirstQty);
        $sheet->setCellValue('O' . $row, $sumMidOk);
        $sheet->setCellValue('P' . $row, $sumMidNg);
        $sheet->setCellValue('S' . $row, $sumSecondMiddleQty);
        $sheet->setCellValue('U' . $row, $sumLastOk);
        $sheet->setCellValue('V' . $row, $sumLastNg);
        $sheet->setCellValue('Y' . $row, $sumSecondLastQty);
        $sheet->setCellValue('AA' . $row, $grandOk);
        $sheet->setCellValue('AB' . $row, $grandNg);
        $sheet->setCellValue('AC' . $row, $grandRR . '%');

        $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray($totalStyle);
        $sheet->getStyle("A{$row}:{$lastCol}{$row}")->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle("I{$row}:J{$row}")->getFont()->getColor()->setARGB('FF047857');
        $sheet->getStyle("M{$row}")->getFont()->getColor()->setARGB('FF0891B2');
        $sheet->getStyle("O{$row}:P{$row}")->getFont()->getColor()->setARGB('FF3730A3');
        $sheet->getStyle("S{$row}")->getFont()->getColor()->setARGB('FF0891B2');
        $sheet->getStyle("U{$row}:V{$row}")->getFont()->getColor()->setARGB('FF6B21A8');
        $sheet->getStyle("Y{$row}")->getFont()->getColor()->setARGB('FF0891B2');
        $sheet->getStyle("AA{$row}")->getFont()->getColor()->setARGB('FF047857');
        $sheet->getStyle("AB{$row}")->getFont()->getColor()->setARGB('FFDC2626');
        $sheet->getStyle("AC{$row}")->getFont()->getColor()->setARGB('FFB45309');

        $sheet->getStyle("AC{$row}")->getFill()
            ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFEF3C7');

        // ============ BORDER ============
        $sheet->getStyle("A{$headerRow1}:{$lastCol}{$row}")->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // ============ COLUMN WIDTH ============
        $widths = [
            'A' => 5, 'B' => 20, 'C' => 18, 'D' => 10, 'E' => 6, 'F' => 6, 'G' => 22, 'H' => 8,
            'I' => 6, 'J' => 6, 'K' => 8, 'L' => 10,          // First
            'M' => 8, 'N' => 10,                               // Second First
            'O' => 6, 'P' => 6, 'Q' => 8, 'R' => 10,          // Middle
            'S' => 8, 'T' => 10,                               // Second Middle
            'U' => 6, 'V' => 6, 'W' => 8, 'X' => 10,          // Last
            'Y' => 8, 'Z' => 10,                               // Second Last
            'AA' => 6, 'AB' => 6, 'AC' => 8,                  // Total
            'AD' => 11, 'AE' => 7, 'AF' => 15,                // PIC
        ];
        foreach ($widths as $col => $w) {
            $sheet->getColumnDimension($col)->setWidth($w);
        }

        $sheet->freezePane('B8');

        // ============ DOWNLOAD ============
        $fileName = 'scan-xray-' . now()->format('Ymd-His') . '.xlsx';
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

    // ============ DELETE ============
    public function confirmDelete($id): void
    {
        if (!auth()->user()->can('delete scan xray')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $scan = ScanXray::find($id);
        if (!$scan) {
            $this->dispatch('notify', message: 'Data not found!', type: 'error');
            return;
        }

        if ($scan->isLocked()) {
            $this->dispatch('notify', message: 'Data sudah lebih dari 24 jam, tidak bisa dihapus!', type: 'error');
            return;
        }

        $this->scanToDelete = $scan;
        $this->dispatch('open-modal-delete');
    }

    public function delete(): void
    {
        if (!auth()->user()->can('delete scan xray')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        if ($this->scanToDelete) {
            $scan = ScanXray::find($this->scanToDelete->id);

            if ($scan && $scan->isLocked()) {
                $this->dispatch('notify', message: 'Data sudah lebih dari 24 jam, tidak bisa dihapus!', type: 'error');
                $this->scanToDelete = null;
                $this->dispatch('close-modal-delete');
                return;
            }

            $scan?->delete();
            $this->dispatch('notify', message: 'Scan X-Ray deleted successfully!');
        }

        $this->scanToDelete = null;
        $this->dispatch('close-modal-delete');
    }

    public function cancelDelete(): void
    {
        $this->scanToDelete = null;
        $this->dispatch('close-modal-delete');
    }

    // ============ RENDER ============
    public function render()
    {
        if (!auth()->user()->can('view scan xray')) {
            abort(403, 'Unauthorized access.');
        }

        $query = ScanXray::with(['customer', 'model', 'masterLine.location', 'creator']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('customer', fn ($qq) => $qq->where('customer_name', 'like', '%' . $this->search . '%'))
                  ->orWhereHas('model', fn ($qq) => $qq->where('model_name', 'like', '%' . $this->search . '%'))
                  ->orWhere('shift', 'like', '%' . $this->search . '%')
                  ->orWhere('group', 'like', '%' . $this->search . '%')
                  ->orWhere('pcb_type', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterCustomerId)    $query->where('customer_id', $this->filterCustomerId);
        if ($this->filterModelId)       $query->where('model_id', $this->filterModelId);
        if ($this->filterDateFrom)      $query->whereDate('created_at', '>=', $this->filterDateFrom);
        if ($this->filterDateUntil)     $query->whereDate('created_at', '<=', $this->filterDateUntil);
        if ($this->filterYear)          $query->whereYear('created_at', $this->filterYear);
        if ($this->filterMonth)         $query->whereMonth('created_at', $this->filterMonth);
        if ($this->filterMasterLineId)  $query->where('master_line_id', $this->filterMasterLineId);

        $customers = Customer::orderBy('customer_name')->get();
        $models = $this->filterCustomerId
            ? BlindTestModel::where('customer_id', $this->filterCustomerId)->orderBy('model_name')->get()
            : collect();
        $masterLines = MasterLine::with('location')
            ->join('tb_mtc_master_locations as loc', 'loc.id', '=', 'tb_mtc_master_lines.location_id')
            ->orderBy('loc.location_name', 'asc')
            ->orderBy('tb_mtc_master_lines.line_number', 'asc')
            ->select('tb_mtc_master_lines.*')
            ->get();

        $currentYear = (int) now()->format('Y');
        $years = range($currentYear, $currentYear - 4);

        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
        ];

        return view('livewire.qaqc.scan-xray.scan-xray-index', [
            'scans'       => $query->orderByDesc('id')->paginate(10),
            'customers'   => $customers,
            'models'      => $models,
            'masterLines' => $masterLines,
            'years'       => $years,
            'months'      => $months,
        ]);
    }
}