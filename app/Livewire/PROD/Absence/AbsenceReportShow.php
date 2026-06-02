<?php

namespace App\Livewire\PROD\Absence;

use Livewire\Component;
use App\Models\PROD\Absence\AbsenceReport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AbsenceReportShow extends Component
{
    public $report;
    public $reportId;

    public function mount($id)
    {
        $this->reportId = $id;
        $this->report = AbsenceReport::with(['creator', 'checker', 'approver', 'accepter'])->find($id);
        
        if (!$this->report) {
            session()->flash('error', 'Report not found!');
            return redirect()->route('prod.absence.report.index');
        }
    }

    public function check()
    {
        if ($this->report->status !== 'draft') {
            session()->flash('error', 'Report already processed!');
            return;
        }
        
        $this->report->check();
        session()->flash('success', 'Report checked successfully!');
        $this->report = AbsenceReport::with(['creator', 'checker', 'approver', 'accepter'])->find($this->reportId);
    }

    public function approve()
    {
        if ($this->report->status !== 'checked') {
            session()->flash('error', 'Report must be checked first!');
            return;
        }
        
        // Approve report
        $this->report->approve();
        
        // Kirim email setelah approve
        $this->sendEmailReport();
        
        // Refresh report data
        $this->report = AbsenceReport::with(['creator', 'checker', 'approver', 'accepter'])->find($this->reportId);
        
        session()->flash('success', 'Report approved successfully! Email has been sent to sek.esd@siix-global.com');
    }

    public function accept()
    {
        if ($this->report->status !== 'approved') {
            session()->flash('error', 'Report must be approved first!');
            return;
        }
        
        $this->report->accept();
        session()->flash('success', 'Report accepted successfully!');
        $this->report = AbsenceReport::with(['creator', 'checker', 'approver', 'accepter'])->find($this->reportId);
    }
    
    private function sendEmailReport()
    {
        try {
            $itemsDetail = $this->report->items_detail;
            
            $jenisMap = [
                'SD' => 'SD - Sakit Dengan Surat Dokter',
                'IJ' => 'IJ - Izin Pribadi',
                'A' => 'A - Tidak Hadir Tanpa Keterangan',
                'CT' => 'CT - Cuti Tahunan',
                'CK' => 'CK - Cuti Keguguran',
                'CM' => 'CM - Cuti Melahirkan',
            ];

            // Get unique departments
            $departments = collect($itemsDetail)->pluck('employee_department')->unique()->implode(', ');
            
            // Prepare rows for email
            $emailRows = [];
            $no = 1;
            foreach ($itemsDetail as $item) {
                $emailRows[] = [
                    'no' => $no++,
                    'nik' => $item['employee_nik'],
                    'nama' => $item['employee_name'],
                    'department' => $item['employee_department'],
                    'group' => $item['group'],
                    'line' => $item['line'],
                    'jenis_display' => $jenisMap[$item['jenis_ketidakhadiran']] ?? $item['jenis_ketidakhadiran'],
                    'keterangan' => $item['keterangan'] ?? '-',
                ];
            }

            $emailData = [
                'date' => now()->format('d/m/Y H:i:s'),
                'departmentString' => $departments ?: 'All Departments',
                'createdBy' => $this->report->created_by,
                'createdAt' => $this->report->created_at ? $this->report->created_at->format('d/m/Y H:i:s') : now()->format('d/m/Y H:i:s'),
                'rows' => $emailRows,
                'reportUrl' => route('prod.absence.report.show', $this->report->id),
                'reportNumber' => $this->report->report_number,
            ];

            // Send email
            Mail::send('emails.prod.absence-report', $emailData, function ($message) {
                $message->to('sek.esd@siix-global.com')
                        ->subject('Laporan Ketidakhadiran Karyawan - ' . $this->report->report_number);
            });
            
            Log::info('Email sent successfully for report: ' . $this->report->report_number);
            
        } catch (\Exception $e) {
            Log::error('Failed to send email: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.prod.absence.absence-report-show', [
            'itemsDetail' => $this->report->items_detail,
        ]);
    }
}