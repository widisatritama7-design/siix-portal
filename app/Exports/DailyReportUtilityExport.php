<?php

namespace App\Exports;

use App\Models\UTY\DailyReportUtility;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DailyReportUtilityExport
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 2. Ambil Data Berdasarkan Filter
        $query = DailyReportUtility::with('creator')->orderBy('id', 'desc');

        if (!empty($this->filters['shift'])) {
            $query->where('shift', $this->filters['shift']);
        }
        if (!empty($this->filters['category'])) {
            $query->where('report_category', $this->filters['category']);
        }
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }
        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        $data = $query->get();

        // 1. Cari MAX foto untuk menentukan jumlah kolom dinamis
        $maxBefore = 1;
        $maxAfter = 1;
        foreach ($data as $item) {
            $bCount = is_array($item->photo_before) ? count($item->photo_before) : 0;
            $aCount = is_array($item->photo_after) ? count($item->photo_after) : 0;
            if ($bCount > $maxBefore) $maxBefore = $bCount;
            if ($aCount > $maxAfter) $maxAfter = $aCount;
        }

        // 3. Set Header Dinamis
        $headers = [
            'ID', 'Date', 'PIC', 'Shift', 'Category', 'Problem', 'Action', 'Status'
        ];
        
        // Tambahkan header Before
        for ($i = 1; $i <= $maxBefore; $i++) {
            $headers[] = 'Photo Before ' . ($maxBefore > 1 ? $i : '');
        }
        // Tambahkan header After
        for ($i = 1; $i <= $maxAfter; $i++) {
            $headers[] = 'Photo After ' . ($maxAfter > 1 ? $i : '');
        }

        // Tulis Header ke Excel
        $colIndex = 1;
        foreach ($headers as $headerText) {
            $colLetter = Coordinate::stringFromColumnIndex($colIndex);
            $sheet->setCellValue($colLetter . '1', trim($headerText));
            $colIndex++;
        }

        $lastColLetter = Coordinate::stringFromColumnIndex($colIndex - 1);

        // Style Header
        $sheet->getStyle('A1:' . $lastColLetter . '1')->getFont()->setBold(true);
        $sheet->getStyle('A1:' . $lastColLetter . '1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF3B82F6'); // Biru
        $sheet->getStyle('A1:' . $lastColLetter . '1')->getFont()->getColor()->setARGB('FFFFFFFF'); // Putih
        $sheet->getStyle('A1:' . $lastColLetter . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:' . $lastColLetter . '1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $row = 2;

        // 4. Looping Data ke Excel
        foreach ($data as $item) {
            // Bersihkan HTML
            $cleanProblem = trim(strip_tags(str_replace(['<br>', '</p>', '</li>'], "\n", $item->problem_desc ?? '')));
            $cleanAction  = trim(strip_tags(str_replace(['<br>', '</p>', '</li>'], "\n", $item->action_desc ?? '')));

            // Tulis Data Teks (Kolom A - H)
            $sheet->setCellValue('A' . $row, $item->id);
            $sheet->setCellValue('B' . $row, $item->created_at->format('d/m/Y H:i'));
            $sheet->setCellValue('C' . $row, $item->creator ? $item->creator->name : '-'); // Kolom PIC
            $sheet->setCellValue('D' . $row, 'Shift ' . $item->shift);
            $sheet->setCellValue('E' . $row, $item->report_category);
            $sheet->setCellValue('F' . $row, $cleanProblem);
            $sheet->setCellValue('G' . $row, $cleanAction);
            $sheet->setCellValue('H' . $row, $item->status);

            // Set tinggi baris agar gambar muat
            $sheet->getRowDimension($row)->setRowHeight(80);
            $sheet->getStyle('A'.$row.':' . $lastColLetter . $row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            // Wrap text
            $sheet->getStyle('F' . $row)->getAlignment()->setWrapText(true);
            $sheet->getStyle('G' . $row)->getAlignment()->setWrapText(true);

            // --- INSERT GAMBAR BEFORE ---
            // Karena kolom teks ada 8 (A-H), maka gambar mulai dari kolom ke-9 (I)
            $beforePhotos = is_array($item->photo_before) ? $item->photo_before : [];
            $currentCol = 9; 
            for ($i = 0; $i < $maxBefore; $i++) {
                $colLetter = Coordinate::stringFromColumnIndex($currentCol);
                if (isset($beforePhotos[$i])) {
                    $imgPath = storage_path('app/public/' . $beforePhotos[$i]);
                    if (file_exists($imgPath)) {
                        $drawing = new Drawing();
                        $drawing->setName('Before');
                        $drawing->setDescription('Photo Before');
                        $drawing->setPath($imgPath);
                        $drawing->setHeight(100); 
                        $drawing->setCoordinates($colLetter . $row);
                        $drawing->setOffsetX(10);
                        $drawing->setOffsetY(10);
                        $drawing->setWorksheet($sheet);
                    }
                }
                $currentCol++;
            }

            // --- INSERT GAMBAR AFTER ---
            $afterPhotos = is_array($item->photo_after) ? $item->photo_after : [];
            for ($i = 0; $i < $maxAfter; $i++) {
                $colLetter = Coordinate::stringFromColumnIndex($currentCol);
                if (isset($afterPhotos[$i])) {
                    $imgPath = storage_path('app/public/' . $afterPhotos[$i]);
                    if (file_exists($imgPath)) {
                        $drawing = new Drawing();
                        $drawing->setName('After');
                        $drawing->setDescription('Photo After');
                        $drawing->setPath($imgPath);
                        $drawing->setHeight(100);
                        $drawing->setCoordinates($colLetter . $row);
                        $drawing->setOffsetX(10);
                        $drawing->setOffsetY(10);
                        $drawing->setWorksheet($sheet);
                    }
                }
                $currentCol++;
            }

            $row++;
        }

        // 5. Auto Size Kolom
        for ($i = 1; $i <= count($headers); $i++) {
            $colLetter = Coordinate::stringFromColumnIndex($i);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }
        
        // Batasi lebar kolom teks Problem & Action
        $sheet->getColumnDimension('F')->setWidth(35);
        $sheet->getColumnDimension('G')->setWidth(35);

        // Lebar kolom gambar dinamis
        for ($i = 9; $i <= count($headers); $i++) {
            $colLetter = Coordinate::stringFromColumnIndex($i);
            $sheet->getColumnDimension($colLetter)->setWidth(20);
        }

        // Border untuk semua cell
        $lastRow = $row - 1;
        if ($lastRow >= 2) {
            $sheet->getStyle('A1:' . $lastColLetter . $lastRow)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FFDDDDDD'],
                    ],
                ],
            ]);
        }

        // 6. Proses Download
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Daily_Report_Utility_' . date('Ymd_His') . '.xlsx';

        $response = new StreamedResponse(function () use ($writer, $spreadsheet) {
            $writer->save('php://output');
            
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}