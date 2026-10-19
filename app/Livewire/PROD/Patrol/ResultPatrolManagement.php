<?php

namespace App\Livewire\PROD\Patrol;

use App\Models\HR\Employee;
use App\Models\PROD\Patrol\ResultPatrol;
use App\Models\PROD\Patrol\CategoryPatrol;
use Barryvdh\DomPDF\Facade\Pdf;
use Ijpatricio\Mingle\Concerns\InteractsWithMingles;
use Ijpatricio\Mingle\Contracts\HasMingles;
use Livewire\Attributes\Title;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

#[Title('Result Patrol')]
class ResultPatrolManagement extends Component implements HasMingles
{
    use InteractsWithMingles;

    public int $perPage = 10;
    public int $page = 1;
    
    // State Filter
    public string $search = '';
    public string $filterDateFrom = '';
    public string $filterDateUntil = '';
    public string $filterShift = '';
    public string $filterGroup = '';
    public string $filterLine = '';
    public string $filterStatus = '';
    public string $filterCategory = '';

    // Cek akses saat inisialisasi halaman
    public function mount()
    {
        if (!auth()->user()->can('view result patrol')) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function component(): string
    {
        return 'resources/js/mingle/Prod/Patrol/ResultPatrol/index.js';
    }

    public function mingleData(): array
    {
        $query = $this->buildQuery();

        $paginator = $query->paginate($this->perPage, ['*'], 'page', $this->page);

        return [
            'rows' => collect($paginator->items())->map(fn($r) => [
                'id'                    => $r->id,
                'shift'                 => $r->shift,
                'group'                 => $r->group,
                'status'                => $r->status,
                'master_line'           => $r->masterLine ? [
                    'id'          => $r->masterLine->id,
                    'line_number' => $r->masterLine->line_number,
                    'location'    => $r->masterLine->location?->location_name
                ] : null,
                'standard_patrol_items' => $r->standard_patrol_items ?? [],
                'finding_patrol_items'  => $r->finding_patrol_items ?? [],
                'created_by'            => $r->creator?->name ?? '-',
                'created_at'            => optional($r->created_at)->format('d/m/Y H:i'),
            ])->toArray(),

            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'from'         => $paginator->firstItem(),
                'to'           => $paginator->lastItem(),
            ],

            'employees' => Employee::orderBy('name')->get(['ID', 'nik', 'name'])->toArray(),
            
            'categories' => CategoryPatrol::orderBy('category_name')->get(['id', 'category_name'])->toArray(),

            // Kirim Permission ke React
            'permissions' => [
                'canCreate' => auth()->user()->can('create result patrol'),
                'canEdit'   => auth()->user()->can('edit result patrol'),
                'canDelete' => auth()->user()->can('delete result patrol'),
            ],
        ];
    }

    public function gotoPage(int $page): array
    {
        $this->page = max(1, $page);
        return $this->mingleData();
    }

    public function setFilter(array $filters): array
    {
        $this->search          = $filters['search'] ?? '';
        $this->filterDateFrom  = $filters['date_from'] ?? '';
        $this->filterDateUntil = $filters['date_until'] ?? '';
        $this->filterShift     = $filters['shift'] ?? '';
        $this->filterGroup     = $filters['group'] ?? '';
        $this->filterLine      = $filters['line'] ?? '';
        $this->filterCategory  = $filters['category'] ?? '';
        $this->filterStatus    = $filters['status'] ?? '';
        
        $this->page = 1; 
        
        return $this->mingleData();
    }

    public function exportPdf()
    {
        $rows = $this->buildQuery()->get();

        $categories = CategoryPatrol::pluck('category_name', 'id')->toArray();
        $employees  = Employee::pluck('name', 'nik')->toArray();

        $pdf = Pdf::loadView('livewire.prod.patrol.result-patrol-pdf', compact('rows', 'categories', 'employees'))
            ->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'result-patrol-' . now()->format('YmdHis') . '.pdf');
    }

    public function exportExcel()
    {
        if (!auth()->user()->can('view result patrol')) {
            return ['success' => false, 'message' => 'You do not have permission!'];
        }

        $rows = $this->buildQuery()->get();

        if ($rows->isEmpty()) {
            return ['success' => false, 'message' => 'No data to export.'];
        }

        $categories = CategoryPatrol::pluck('category_name', 'id')->toArray();
        $employees  = Employee::pluck('name', 'nik')->toArray();

        $tempFiles = [];

        $headerStyle = [
            'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 11],
            'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF4472C4']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, 'wrapText' => true],
        ];
        
        $totalStyle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFF2CC']],
        ];

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Result Patrol');

        $lastCol = 'M'; 
        
        $sheet->setCellValue('A1', 'RESULT PATROL REPORT');
        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14)->getColor()->setARGB('FF1E3A8A');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'PT. SIIX EMS INDONESIA — Production Department');
        $sheet->mergeCells("A2:{$lastCol}2");
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(10)->getColor()->setARGB('FF666666');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $filterText = [];
        if ($this->search)              $filterText[] = 'Search: ' . $this->search;
        if ($this->filterShift)         $filterText[] = 'Shift: ' . $this->filterShift;
        if ($this->filterGroup)         $filterText[] = 'Group: ' . $this->filterGroup;
        if ($this->filterLine)          $filterText[] = 'Line: ' . $this->filterLine;
        if ($this->filterCategory)      $filterText[] = 'Category: ' . ($categories[$this->filterCategory] ?? '-');
        if ($this->filterStatus)        $filterText[] = 'Status: ' . $this->filterStatus;
        if ($this->filterDateFrom)      $filterText[] = 'From: ' . $this->filterDateFrom;
        if ($this->filterDateUntil)     $filterText[] = 'Until: ' . $this->filterDateUntil;

        $sheet->setCellValue('A3', $filterText ? 'Filter: ' . implode(' | ', $filterText) : 'Filter: None');
        $sheet->mergeCells("A3:{$lastCol}3");
        $sheet->getStyle('A3')->getFont()->setItalic(true)->setSize(9)->getColor()->setARGB('FF2563EB');
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A4', 'Generated: ' . now()->format('d M Y, H:i') . ' | By: ' . (auth()->user()?->name ?? '-'));
        $sheet->mergeCells("A4:{$lastCol}4");
        $sheet->getStyle('A4')->getFont()->setSize(9)->getColor()->setARGB('FF666666');
        $sheet->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $headerRow = 6;
        $sheet->setCellValue('A' . $headerRow, 'No');
        $sheet->setCellValue('B' . $headerRow, 'Shift');
        $sheet->setCellValue('C' . $headerRow, 'Group');
        $sheet->setCellValue('D' . $headerRow, 'Line');
        $sheet->setCellValue('E' . $headerRow, 'Category');
        $sheet->setCellValue('F' . $headerRow, 'Finding Result');
        $sheet->setCellValue('G' . $headerRow, 'Feedback To');
        $sheet->setCellValue('H' . $headerRow, 'Reason');
        $sheet->setCellValue('I' . $headerRow, 'Action Taken');
        $sheet->setCellValue('J' . $headerRow, 'Status');
        $sheet->setCellValue('K' . $headerRow, 'Date');
        $sheet->setCellValue('L' . $headerRow, 'Evidence');
        $sheet->setCellValue('M' . $headerRow, 'Evidence Action');

        $sheet->getStyle("A{$headerRow}:{$lastCol}{$headerRow}")->applyFromArray($headerStyle);

        $row = $headerRow + 1;
        $no = 1;

        foreach ($rows as $r) {
            $hasFindings = count($r->finding_patrol_items ?? []) > 0;
            $findings = $hasFindings ? $r->finding_patrol_items : [null];
            $rowCount = count($findings);

            foreach ($findings as $index => $f) {
                $sheet->getRowDimension($row)->setRowHeight(180);   // ✅ GANTI (biar muat 2 baris foto)

                if ($index === 0) {
                    $sheet->setCellValue('A' . $row, $no++);
                    $sheet->setCellValue('B' . $row, $r->shift);
                    $sheet->setCellValue('C' . $row, $r->group);
                    $sheet->setCellValue('D' . $row, ($r->masterLine?->line_number ?? '-') . ' (' . ($r->masterLine?->location?->location_name ?? '-') . ')');
                    $sheet->setCellValue('J' . $row, $r->status);
                    $sheet->setCellValue('K' . $row, $r->created_at?->format('d/m/Y H:i') ?? '-');
                }

                if ($f) {
                    $catName = $categories[$f['category_id']] ?? '-';
                    $empName = $employees[$f['feedback_to']] ?? $f['feedback_to'] ?? '-';

                    $sheet->setCellValue('E' . $row, $catName);
                    $sheet->setCellValue('F' . $row, $f['finding_result'] ?? '-');
                    $sheet->setCellValue('G' . $row, $empName);
                    $sheet->setCellValue('H' . $row, $f['reason'] ?? '-');
                    $sheet->setCellValue('I' . $row, $f['action'] ?? '-');

                    // ✅ GANTI — handle array multiple photos
                    if (!empty($f['evidence'])) {
                        $photos = is_array($f['evidence']) ? $f['evidence'] : [$f['evidence']];
                        $this->addMultipleImagesToSheet($sheet, $photos, $row, 'L', $tempFiles);
                    }

                    if (!empty($f['evidence_action'])) {
                        $photos = is_array($f['evidence_action']) ? $f['evidence_action'] : [$f['evidence_action']];
                        $this->addMultipleImagesToSheet($sheet, $photos, $row, 'M', $tempFiles);
                    }

                } else {
                    $sheet->setCellValue('E' . $row, '-');
                    $sheet->setCellValue('F' . $row, 'Safe');
                    $sheet->setCellValue('G' . $row, '-');
                    $sheet->setCellValue('H' . $row, '-');
                    $sheet->setCellValue('I' . $row, '-');
                }
                
                $status = $r->status ?? 'Open';
                $statusColor = match($status) {
                    'Open' => 'FF3B82F6',
                    'On Progress' => 'FFF59E0B',
                    'Pending' => 'FF8B5CF6',
                    'Closed' => 'FF6B7280',
                    default => 'FF000000',
                };
                $sheet->getStyle('J' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color($statusColor));

                $sheet->getStyle("A{$row}:{$lastCol}{$row}")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle("A{$row}:{$lastCol}{$row}")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                if ($rowCount > 1 && $index === 0) {
                    $endRow = $row + $rowCount - 1;
                    $sheet->mergeCells("A{$row}:A{$endRow}");
                    $sheet->mergeCells("B{$row}:B{$endRow}");
                    $sheet->mergeCells("C{$row}:C{$endRow}");
                    $sheet->mergeCells("D{$row}:D{$endRow}");
                    $sheet->mergeCells("J{$row}:J{$endRow}");
                    $sheet->mergeCells("K{$row}:K{$endRow}");
                }

                $row++;
            }
        }

        $sheet->setCellValue('A' . $row, 'TOTAL');
        $sheet->mergeCells("A{$row}:D{$row}");
        $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray($totalStyle);
        $sheet->getStyle("A{$row}:{$lastCol}{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $widths = [
            'A' => 5, 'B' => 8, 'C' => 8, 'D' => 25, 'E' => 15, 'F' => 25, 'G' => 20, 'H' => 25, 'I' => 25, 'J' => 15, 'K' => 18,
            'L' => 25, 'M' => 25
        ];
        foreach ($widths as $col => $w) {
            $sheet->getColumnDimension($col)->setWidth($w);
        }

        $sheet->freezePane('E7');

        $fileName = 'result-patrol-' . now()->format('Ymd-His') . '.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $tempExcel = tempnam(sys_get_temp_dir(), 'excel_');
        $writer->save($tempExcel);
        $fileContent = base64_encode(file_get_contents($tempExcel));
        
        unlink($tempExcel);
        foreach ($tempFiles as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }

        return [
            'success' => true,
            'file' => $fileContent,
            'filename' => $fileName
        ];
    }

    private function base64ToTempImage($base64String)
    {
        try {
            $parts = explode(',', $base64String);
            if (count($parts) < 2) return null;

            $imageData = base64_decode($parts[1]);
            $tempFile = tempnam(sys_get_temp_dir(), 'img_') . '.jpg';
            file_put_contents($tempFile, $imageData);

            return $tempFile;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function addImageToSheet($sheet, $imagePath, $row, $colLetter)
    {
        try {
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('Evidence');
            $drawing->setDescription('Evidence');
            $drawing->setPath($imagePath);
            
            $drawing->setHeight(80); 
            
            $drawing->setCoordinates($colLetter . $row);
            
            $drawing->setOffsetX(15); 
            $drawing->setOffsetY(10);
            
            $drawing->setWorksheet($sheet);
        } catch (\Exception $e) {
            // Abaikan error gambar
        }
    }

    // ✅ BARU — render array foto jadi grid 2x2 dalam 1 cell Excel
    private function addMultipleImagesToSheet($sheet, array $photos, $row, $colLetter, array &$tempFiles)
    {
        if (empty($photos)) return;
        
        try {
            $imageCount = count($photos);
            
            // Max 4 foto: grid 2x2 jika > 1, single full jika 1
            $cellHeight = $imageCount === 1 ? 160 : 80;
            
            foreach ($photos as $i => $base64) {
                $tempPath = $this->base64ToTempImage($base64);
                if (!$tempPath) continue;
                $tempFiles[] = $tempPath;
                
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('Evidence_' . ($i + 1));
                $drawing->setDescription('Evidence');
                $drawing->setPath($tempPath);
                $drawing->setHeight($cellHeight);
                
                // Grid offset (2 per baris)
                $colOffset = $i % 2;
                $rowOffset = intdiv($i, 2);
                
                $drawing->setCoordinates($colLetter . $row);
                $drawing->setOffsetX(15 + $colOffset * ($cellHeight + 5));
                $drawing->setOffsetY(10 + $rowOffset * ($cellHeight + 5));
                
                $drawing->setWorksheet($sheet);
            }
        } catch (\Exception $e) {
            // Abaikan error gambar
        }
    }

    public function deleteRow(int $id): array
    {
        // Cek Permission
        if (!auth()->user()->can('delete result patrol')) {
            return ['success' => false, 'message' => 'You do not have permission to delete!'];
        }

        $row = ResultPatrol::find($id);
        if (!$row) return ['success' => false, 'message' => 'Data tidak ditemukan'];
        
        $row->delete();
        return ['success' => true, 'message' => 'Data berhasil dihapus', 'data' => $this->mingleData()];
    }

    public function updateStatus(int $id, string $status): array
    {
        // Cek Permission
        if (!auth()->user()->can('edit result patrol')) {
            return ['success' => false, 'message' => 'You do not have permission to edit!'];
        }

        $row = ResultPatrol::find($id);
        if (!$row) return ['success' => false, 'message' => 'Data not found'];

        if (!in_array($status, ['Open', 'On Progress', 'Pending', 'Closed'])) {
            return ['success' => false, 'message' => 'Invalid status'];
        }

        $row->update([
            'status' => $status,
            'updated_by' => auth()->id()
        ]);

        return [
            'success' => true,
            'message' => 'Status updated successfully',
            'data' => $this->mingleData()
        ];
    }

    private function buildQuery()
    {
        $query = ResultPatrol::query()
            ->with(['masterLine.location', 'creator'])
            ->orderBy('id', 'desc');

        if ($this->search !== '') {
            $s = $this->search;
            $query->where(function($q) use ($s) {
                $q->where('shift', 'like', "%{$s}%")
                  ->orWhere('group', 'like', "%{$s}%")
                  ->orWhereHas('masterLine', function($ml) use ($s) {
                      $ml->where('line_number', 'like', "%{$s}%")
                         ->orWhereHas('location', function($loc) use ($s) {
                             $loc->where('location_name', 'like', "%{$s}%");
                         });
                  });
            });
        }

        if ($this->filterStatus !== '') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterDateFrom) {
            $query->whereDate('created_at', '>=', $this->filterDateFrom);
        }
        if ($this->filterDateUntil) {
            $query->whereDate('created_at', '<=', $this->filterDateUntil);
        }

        if ($this->filterShift) $query->where('shift', $this->filterShift);
        if ($this->filterGroup) $query->where('group', $this->filterGroup);

        if ($this->filterLine) {
            $query->whereHas('masterLine', function($ml) {
                $ml->where('line_number', $this->filterLine);
            });
        }

        if ($this->filterCategory !== '') {
            $query->whereJsonContains('finding_patrol_items', [['category_id' => $this->filterCategory]]);
        }

        return $query;
    }
}