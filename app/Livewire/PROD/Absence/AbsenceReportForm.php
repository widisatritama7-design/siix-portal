<?php

namespace App\Livewire\PROD\Absence;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PROD\Absence\AbsenceReport;
use App\Models\HR\Employee;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class AbsenceReportForm extends Component
{
    use WithPagination;

    public $reportId;
    public $rows = [];
    public $perPage = 10;
    
    // Current row for adding new item
    public $current_employee_id = null;
    public $current_group = '';
    public $current_line = '';
    public $current_jenis_ketidakhadiran = '';
    public $current_keterangan = '';
    
    // For dropdown
    public $employeeSearch = '';

    protected $rules = [
        'rows' => 'required|array|min:1',
        'rows.*.employee_id' => 'required|exists:tb_hr_employee,id',
        'rows.*.group' => 'required|string|max:100',
        'rows.*.line' => 'required|string|max:100',
        'rows.*.jenis_ketidakhadiran' => 'required|string',
        'rows.*.keterangan' => 'nullable|string',
    ];

    protected $messages = [
        'rows.required' => 'At least one row is required.',
        'rows.*.employee_id.required' => 'Employee is required.',
        'rows.*.group.required' => 'Group is required.',
        'rows.*.line.required' => 'Line is required.',
        'rows.*.jenis_ketidakhadiran.required' => 'Absence type is required.',
    ];

    // Get all employees for dropdown
    public function getEmployeesProperty()
    {
        return Employee::query()
            ->select('id', 'nik', 'name', 'department')
            ->whereIn('status', [1, 2, 3])
            ->orderBy('name')
            ->get()
            ->mapWithKeys(fn ($employee) => [
                $employee->id => $employee->nik . ' - ' . $employee->name . ' (' . $employee->department . ')'
            ]);
    }

    public function getJenisKetidakhadiranOptions()
    {
        return [
            'SD' => 'SD - Sakit Dengan Surat Dokter',
            'IJ' => 'IJ - Izin Pribadi',
            'A' => 'A - Tidak Hadir Tanpa Keterangan',
            'CT' => 'CT - Cuti Tahunan',
            'CK' => 'CK - Cuti Keguguran',
            'CM' => 'CM - Cuti Melahirkan',
        ];
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->reportId = $id;
            $report = AbsenceReport::find($id);
            
            if ($report) {
                foreach ($report->items as $item) {
                    $employee = Employee::find($item['employee_id']);
                    $this->rows[] = [
                        'employee_id' => $item['employee_id'],
                        'employee_nik' => $employee->nik ?? '-',
                        'employee_name' => $employee->name ?? '-',
                        'employee_department' => $employee->department ?? '-',
                        'group' => $item['group'],
                        'line' => $item['line'],
                        'jenis_ketidakhadiran' => $item['jenis_ketidakhadiran'],
                        'keterangan' => $item['keterangan'] ?? '',
                    ];
                }
            }
        }
    }

    public function addRow()
    {
        $this->validate([
            'current_employee_id' => 'required|exists:tb_hr_employee,id',
            'current_group' => 'required|string|max:100',
            'current_line' => 'required|string|max:100',
            'current_jenis_ketidakhadiran' => 'required|string',
        ]);

        $employee = Employee::find($this->current_employee_id);

        $this->rows[] = [
            'employee_id' => $this->current_employee_id,
            'employee_nik' => $employee->nik ?? '-',
            'employee_name' => $employee->name ?? '-',
            'employee_department' => $employee->department ?? '-',
            'group' => $this->current_group,
            'line' => $this->current_line,
            'jenis_ketidakhadiran' => $this->current_jenis_ketidakhadiran,
            'keterangan' => $this->current_keterangan,
        ];

        // Reset form
        $this->current_employee_id = null;
        $this->current_group = '';
        $this->current_line = '';
        $this->current_jenis_ketidakhadiran = '';
        $this->current_keterangan = '';
        $this->employeeSearch = '';

        session()->flash('success', 'Row added successfully!');
    }

    public function removeRow($index)
    {
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $this->perPage;
        $realIndex = $offset + $index;
        
        unset($this->rows[$realIndex]);
        $this->rows = array_values($this->rows);
        
        session()->flash('success', 'Row removed successfully!');
    }

    public function sendEmailReport($report, $items)
    {
        $jenisMap = [
            'SD' => 'SD - Sakit Dengan Surat Dokter',
            'IJ' => 'IJ - Izin Pribadi',
            'A' => 'A - Tidak Hadir Tanpa Keterangan',
            'CT' => 'CT - Cuti Tahunan',
            'CK' => 'CK - Cuti Keguguran',
            'CM' => 'CM - Cuti Melahirkan',
        ];

        // Get unique departments
        $departments = collect($items)->pluck('employee_department')->unique()->implode(', ');
        
        // Prepare rows for email
        $emailRows = [];
        $no = 1;
        foreach ($items as $item) {
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
            'date' => now()->format('d/m/Y'),
            'departmentString' => $departments ?: 'All Departments',
            'rows' => $emailRows,
            'createdBy' => Auth::user()->name,
            'createdAt' => now()->format('d/m/Y H:i:s'),
            'reportUrl' => route('prod.absence.report.show', $report->id),
        ];

        // Send email
        Mail::send('emails.prod.absence-report', $emailData, function ($message) {
            $message->to('sek.esd@siix-global.com')
                    ->subject('Laporan Ketidakhadiran Karyawan - ' . now()->format('d/m/Y H:i'));
        });
    }

    public function save()
    {
        $this->validate();

        $itemsForDb = [];
        foreach ($this->rows as $row) {
            $itemsForDb[] = [
                'employee_id' => $row['employee_id'],
                'group' => $row['group'],
                'line' => $row['line'],
                'jenis_ketidakhadiran' => $row['jenis_ketidakhadiran'],
                'keterangan' => $row['keterangan'] ?? '',
            ];
        }

        if ($this->reportId) {
            $report = AbsenceReport::find($this->reportId);
            if ($report->status === 'draft') {
                $report->update(['items' => $itemsForDb]);
                session()->flash('success', 'Report updated successfully!');
            } else {
                session()->flash('error', 'Cannot edit report that is already processed!');
                return;
            }
        } else {
            $report = AbsenceReport::create(['items' => $itemsForDb]);
            
            // Send email after successful creation
            $this->sendEmailReport($report, $this->rows);
            
            session()->flash('success', 'Report created successfully! Email has been sent to sek.esd@siix-global.com');
        }

        return redirect()->route('prod.absence.report.index');
    }

    public function render()
    {
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $this->perPage;
        $paginatedRows = array_slice($this->rows, $offset, $this->perPage);
        
        $totalRows = count($this->rows);
        $lastPage = ceil($totalRows / $this->perPage);
        
        return view('livewire.prod.absence.absence-report-form', [
            'paginatedRows' => $paginatedRows,
            'totalRows' => $totalRows,
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
            'perPage' => $this->perPage,
            'jenisOptions' => $this->getJenisKetidakhadiranOptions(),
        ]);
    }
}