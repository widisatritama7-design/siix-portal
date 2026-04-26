<?php

namespace App\Livewire\QAQC;

use App\Models\QAQC\NCP;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class NCPReport extends Component
{
    public $dateFrom = '';
    public $dateUntil = '';
    public $yearFilter = '';
    public $monthFilter = '';
    public $statusFilter = '';
    public $sectionFilter = '';
    public $supplierFilter = '';
    public $customerFilter = '';
    
    public $previewData = [];
    public $totalRecords = 0;
    public $hasFiltered = false;
    
    // For detail modal
    public $showDetailModal = false;
    public $selectedDetail = [];
    
    protected $rules = [
        'dateFrom' => 'nullable|date',
        'dateUntil' => 'nullable|date|after_or_equal:dateFrom',
        'yearFilter' => 'nullable|string',
        'monthFilter' => 'nullable|string',
        'statusFilter' => 'nullable|string',
        'sectionFilter' => 'nullable|string',
        'supplierFilter' => 'nullable|string',
        'customerFilter' => 'nullable|string',
    ];
    
    public function getSectionsProperty()
    {
        return NCP::select('section')
            ->distinct()
            ->whereNotNull('section')
            ->orderBy('section')
            ->pluck('section');
    }
    
    public function getSuppliersProperty()
    {
        return NCP::select('supplier')
            ->distinct()
            ->whereNotNull('supplier')
            ->orderBy('supplier')
            ->pluck('supplier');
    }
    
    public function getCustomersProperty()
    {
        return NCP::select('customer')
            ->distinct()
            ->whereNotNull('customer')
            ->orderBy('customer')
            ->pluck('customer');
    }
    
    public function getYearsProperty()
    {
        return NCP::query()
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
    
    public function getStatusesProperty()
    {
        return NCP::getStatuses();
    }
    
    public function applyFilter()
    {
        $this->validate();
        $this->hasFiltered = true;
        $this->loadPreview();
        $this->dispatch('notify', message: 'Data found: ' . $this->totalRecords . ' records', type: 'success');
    }
    
    public function loadPreview()
    {
        $query = $this->getFilteredQuery();
        $this->totalRecords = $query->count();
        $this->previewData = $query->limit(20)->get();
    }
    
    protected function getFilteredQuery()
    {
        return NCP::query()
            ->with(['employee', 'creator', 'approver'])
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('created_at', '>=', $this->dateFrom);
            })
            ->when($this->dateUntil, function ($query) {
                $query->whereDate('created_at', '<=', $this->dateUntil);
            })
            ->when($this->yearFilter, function ($query) {
                $query->whereYear('created_at', $this->yearFilter);
            })
            ->when($this->monthFilter, function ($query) {
                $query->whereMonth('created_at', $this->monthFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->sectionFilter, function ($query) {
                $query->where('section', $this->sectionFilter);
            })
            ->when($this->supplierFilter, function ($query) {
                $query->where('supplier', $this->supplierFilter);
            })
            ->when($this->customerFilter, function ($query) {
                $query->where('customer', $this->customerFilter);
            })
            ->orderBy('created_at', 'desc');
    }
    
    /**
     * Parse defect details - return array of defects
     * Jika object, convert ke array; jika array of objects, return as is
     */
    protected function parseDefectDetails($defectDetails): array
    {
        if (empty($defectDetails)) {
            return [];
        }
        
        // Jika sudah array
        if (is_array($defectDetails)) {
            // Cek apakah array of objects atau single object
            if (isset($defectDetails[0]) && is_array($defectDetails[0])) {
                return $defectDetails;
            }
            // Jika single object/array
            if (!isset($defectDetails[0])) {
                return [$defectDetails];
            }
            return $defectDetails;
        }
        
        // Jika string JSON
        if (is_string($defectDetails)) {
            $decoded = json_decode($defectDetails, true);
            if (is_array($decoded)) {
                // Cek apakah array of objects
                if (isset($decoded[0]) && is_array($decoded[0])) {
                    return $decoded;
                }
                // Jika single object
                if (!isset($decoded[0]) && !empty($decoded)) {
                    return [$decoded];
                }
                return $decoded;
            }
        }
        
        return [];
    }
    
    /**
     * Parse disposition - pecah berdasarkan koma
     * Contoh: "Use as it: testt, Scrap: testt, Rework: Testttt" 
     * menjadi ["Use as it: testt", "Scrap: testt", "Rework: Testttt"]
     */
    protected function parseDisposition($disposition): array
    {
        if (empty($disposition)) {
            return [];
        }
        
        if (is_string($disposition)) {
            // Pecah berdasarkan koma
            $items = explode(',', $disposition);
            $result = [];
            foreach ($items as $item) {
                $trimmed = trim($item);
                if (!empty($trimmed)) {
                    $result[] = $trimmed;
                }
            }
            return $result;
        }
        
        return [$disposition];
    }
    
    /**
     * Generate rows dari kombinasi defect_details dan disposition
     * Jika ada 3 defect dan 3 disposition -> 9 baris
     */
    protected function generateRows($record): array
    {
        $defects = $this->parseDefectDetails($record->defect_details);
        $dispositions = $this->parseDisposition($record->disposition);
        
        // Jika tidak ada defect dan tidak ada disposition, return 1 baris kosong
        if (empty($defects) && empty($dispositions)) {
            return [[
                'defect_detail' => null,
                'disposition_item' => null
            ]];
        }
        
        $rows = [];
        $maxCount = max(count($defects), count($dispositions));
        
        for ($i = 0; $i < $maxCount; $i++) {
            $rows[] = [
                'defect_detail' => $defects[$i] ?? null,
                'disposition_item' => $dispositions[$i] ?? null
            ];
        }
        
        return $rows;
    }
    
    protected function safeToString($value, $default = '-'): string
    {
        if (is_null($value)) {
            return $default;
        }
        
        if (is_array($value) || is_object($value)) {
            return json_encode($value);
        }
        
        return (string) $value;
    }
    
    protected function formatDefectDetail($defect): string
    {
        if (is_null($defect)) {
            return '-';
        }
        
        if (is_array($defect)) {
            $parts = [];
            foreach ($defect as $key => $value) {
                $parts[] = ucfirst(str_replace('_', ' ', $key)) . ': ' . $value;
            }
            return implode(' | ', $parts);
        }
        
        return (string) $defect;
    }
    
    public function viewDetail($ncpId)
    {
        $this->selectedDetail = NCP::with(['employee', 'creator', 'approver'])->find($ncpId);
        $this->showDetailModal = true;
    }
    
    public function export()
    {
        $this->validate();
        
        if (!$this->hasFiltered) {
            $this->dispatch('notify', message: 'Please apply filter first.', type: 'warning');
            return;
        }
        
        $records = $this->getFilteredQuery()->get();
        
        if ($records->isEmpty()) {
            $this->dispatch('notify', message: 'No data available to export.', type: 'warning');
            return;
        }
        
        // Buat semua rows dari semua record
        $allRows = [];
        $globalIndex = 0;
        
        foreach ($records as $record) {
            $rows = $this->generateRows($record);
            
            foreach ($rows as $rowData) {
                $globalIndex++;
                
                // Format dates
                $createdAt = '-';
                if ($record->created_at) {
                    try {
                        $createdAt = Carbon::parse($record->created_at)->format('d/m/Y H:i');
                    } catch (\Exception $e) {
                        $createdAt = '-';
                    }
                }
                
                $updatedAt = '-';
                if ($record->updated_at) {
                    try {
                        $updatedAt = Carbon::parse($record->updated_at)->format('d/m/Y H:i');
                    } catch (\Exception $e) {
                        $updatedAt = '-';
                    }
                }
                
                // Format failure rate
                $failureRate = '-';
                if (!is_null($record->failure_rate)) {
                    $failureRate = number_format((float) $record->failure_rate, 2) . '%';
                }
                
                $allRows[] = [
                    'no' => $globalIndex,
                    'ncp_number' => $this->safeToString($record->ncp_number, '-'),
                    'status' => $record->getStatusText(),
                    'employee_nik' => $record->employee->nik ?? '-',
                    'employee_name' => $record->employee->name ?? '-',
                    'employee_dept' => $record->employee->department ?? '-',
                    'section' => $this->safeToString($record->section, '-'),
                    'part_number' => $this->safeToString($record->part_number, '-'),
                    'part_description' => $this->safeToString($record->part_description, '-'),
                    'supplier' => $this->safeToString($record->supplier, '-'),
                    'customer' => $this->safeToString($record->customer, '-'),
                    'model_affected' => $this->safeToString($record->model_affected, '-'),
                    'lot_no' => $this->safeToString($record->lot_no, '-'),
                    'lot_qty' => $this->safeToString($record->lot_qty, '-'),
                    'rejected_qty' => $this->safeToString($record->rejected_qty, '-'),
                    'failure_rate' => $failureRate,
                    'do_no' => $this->safeToString($record->do_no, '-'),
                    'packing_list_no' => $this->safeToString($record->packing_list_no, '-'),
                    'disposition_item' => $rowData['disposition_item'] ?? '-',
                    'defect_detail' => $this->formatDefectDetail($rowData['defect_detail']),
                    'remarks' => $this->safeToString($record->remarks, '-'),
                    'created_by' => $record->creator->name ?? '-',
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                ];
            }
        }
        
        // Create new Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Headers
        $headers = [
            'A' => 'No',
            'B' => 'NCP Number',
            'C' => 'Status',
            'D' => 'NIK',
            'E' => 'Name',
            'F' => 'Dept',
            'G' => 'Section',
            'H' => 'Part Number',
            'I' => 'Part Description',
            'J' => 'Supplier',
            'K' => 'Customer',
            'L' => 'Model Affected',
            'M' => 'Lot No',
            'N' => 'Lot Qty',
            'O' => 'Rejected Qty',
            'P' => 'Failure Rate (%)',
            'Q' => 'DO No',
            'R' => 'Packing List No',
            'S' => 'Disposition',
            'T' => 'Defect Detail',
            'U' => 'Remarks',
            'V' => 'Created By',
            'W' => 'Date Create',
            'X' => 'Date Update',
        ];
        
        // Set headers dengan styling
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
        
        // Fill data
        $row = 2;
        foreach ($allRows as $data) {
            $sheet->setCellValue('A' . $row, $data['no']);              // No
            $sheet->setCellValue('B' . $row, $data['ncp_number']);      // NCP Number
            $sheet->setCellValue('C' . $row, $data['status']);          // Status
            $sheet->setCellValue('D' . $row, $data['employee_nik']);    // NIK
            $sheet->setCellValue('E' . $row, $data['employee_name']);   // Name
            $sheet->setCellValue('F' . $row, $data['employee_dept']);   // Dept
            $sheet->setCellValue('G' . $row, $data['section']);         // Section
            $sheet->setCellValue('H' . $row, $data['part_number']);     // Part Number
            $sheet->setCellValue('I' . $row, $data['part_description']); // Part Description
            $sheet->setCellValue('J' . $row, $data['supplier']);        // Supplier
            $sheet->setCellValue('K' . $row, $data['customer']);        // Customer
            $sheet->setCellValue('L' . $row, $data['model_affected']);  // Model Affected
            $sheet->setCellValue('M' . $row, $data['lot_no']);          // Lot No
            $sheet->setCellValue('N' . $row, $data['lot_qty']);         // Lot Qty
            $sheet->setCellValue('O' . $row, $data['rejected_qty']);    // Rejected Qty
            $sheet->setCellValue('P' . $row, $data['failure_rate']);    // Failure Rate (%)
            $sheet->setCellValue('Q' . $row, $data['do_no']);           // DO No
            $sheet->setCellValue('R' . $row, $data['packing_list_no']); // Packing List No
            $sheet->setCellValue('S' . $row, $data['disposition_item']); // Disposition
            $sheet->setCellValue('T' . $row, $data['defect_detail']);   // Defect Detail
            $sheet->setCellValue('U' . $row, $data['remarks']);         // Remarks
            $sheet->setCellValue('V' . $row, $data['created_by']);      // Created By
            $sheet->setCellValue('W' . $row, $data['created_at']);      // Date Create
            $sheet->setCellValue('X' . $row, $data['updated_at']);      // Date Update
            
            $row++;
        }
        
        // Auto size columns
        foreach (array_keys($headers) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Apply borders
        $lastRow = $row - 1;
        $sheet->getStyle('A1:X' . $lastRow)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
        
        // Freeze header row
        $sheet->freezePane('A2');
        
        // Wrap text for long content
        $sheet->getStyle('S:S')->getAlignment()->setWrapText(true);
        $sheet->getStyle('R:R')->getAlignment()->setWrapText(true);
        
        // Create writer and output
        $fileName = 'laporan_ncp_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        $writer = new Xlsx($spreadsheet);
        
        $response = Response::stream(
            function() use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                'Cache-Control' => 'max-age=0',
            ]
        );
        
        return $response;
    }
    
    public function resetFilters()
    {
        $this->reset([
            'dateFrom', 
            'dateUntil', 
            'yearFilter', 
            'monthFilter', 
            'statusFilter',
            'sectionFilter',
            'supplierFilter',
            'customerFilter'
        ]);
        $this->hasFiltered = false;
        $this->previewData = [];
        $this->totalRecords = 0;
        $this->dispatch('notify', message: 'Filters reset', type: 'info');
    }
    
    public function render()
    {
        return view('livewire.qaqc.ncp-report', [
            'sections' => $this->sections,
            'suppliers' => $this->suppliers,
            'customers' => $this->customers,
            'years' => $this->years,
            'months' => $this->months,
            'statuses' => $this->statuses,
        ])->layout('layouts.app');
    }
}