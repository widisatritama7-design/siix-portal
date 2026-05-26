<?php

namespace App\Http\Controllers\PROD\Absence;

use App\Http\Controllers\Controller;
use App\Models\PROD\Absence\AbsenceReport;
use App\Models\HR\Employee;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsenceReportPrintController extends Controller
{
    public function print($id)
    {
        $report = AbsenceReport::findOrFail($id);
        
        // Mapping jenis ketidakhadiran
        $jenisMap = [
            'SD' => 'SD - Sakit Dengan Surat Dokter',
            'IJ' => 'IJ - Izin Pribadi',
            'A' => 'A - Tidak Hadir Tanpa Keterangan',
            'CT' => 'CT - Cuti Tahunan',
            'CK' => 'CK - Cuti Keguguran',
            'CM' => 'CM - Cuti Melahirkan',
        ];
        
        // Prepare rows dan collect unique departments
        $rows = [];
        $departmentCollection = collect();
        
        foreach ($report->items as $index => $item) {
            $employee = Employee::find($item['employee_id']);
            $department = trim($employee->department ?? '-');
            
            // Add to collection for unique check (case-insensitive)
            if ($department != '-') {
                $departmentCollection->push($department);
            }
            
            $rows[] = [
                'no' => $index + 1,
                'nik' => $employee->nik ?? '-',
                'nama' => $employee->name ?? '-',
                'department' => $department,
                'group' => $item['group'] ?? '-',
                'line' => $item['line'] ?? '-',
                'jenis' => $item['jenis_ketidakhadiran'],
                'jenis_display' => $jenisMap[$item['jenis_ketidakhadiran']] ?? $item['jenis_ketidakhadiran'],
                'keterangan' => $item['keterangan'] ?? '-',
            ];
        }
        
        // Get unique departments (case-insensitive) using Laravel Collection
        $uniqueDepartments = $departmentCollection
            ->unique(function ($item) {
                return strtolower(trim($item));
            })
            ->values()
            ->toArray();
        
        $departmentString = implode(' / ', $uniqueDepartments);
        
        if (empty($departmentString)) {
            $departmentString = '-';
        }
        
        // Format datetime function
        $formatDateTime = function($datetime) {
            if (!$datetime) {
                return '-';
            }
            return \Carbon\Carbon::parse($datetime)->format('d M Y H:i');
        };
        
        // Get signatories and their datetime
        $createdBy = $report->created_by ?? '-';
        $createdAt = $formatDateTime($report->created_at);
        
        $checkedBy = $report->check_by ?? '-';
        $checkedAt = $formatDateTime($report->check_at);
        
        $approvedBy = $report->approved_by ?? '-';
        $approvedAt = $formatDateTime($report->approved_at);
        
        $receivedBy = $report->accepted_by ?? '-';
        $receivedAt = $formatDateTime($report->accepted_at);
        
        $data = [
            'report' => $report,
            'rows' => $rows,
            'date' => now()->format('d F Y'),
            'departmentString' => $departmentString,
            'createdBy' => $createdBy,
            'createdAt' => $createdAt,
            'checkedBy' => $checkedBy,
            'checkedAt' => $checkedAt,
            'approvedBy' => $approvedBy,
            'approvedAt' => $approvedAt,
            'receivedBy' => $receivedBy,
            'receivedAt' => $receivedAt,
            'jenisMap' => $jenisMap,
        ];
        
        $pdf = Pdf::loadView('livewire.prod.absence.absence-report', $data);
        $pdf->setPaper('A4', 'landscape');
        
        $filename = 'absence-report-' . $report->id . '.pdf';
        
        return $pdf->stream($filename);
    }
}