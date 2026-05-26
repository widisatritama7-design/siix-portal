<?php

namespace App\Livewire\PROD\Absence;

use Livewire\Component;
use App\Models\PROD\Absence\AbsenceReport;

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
        
        $this->report->approve();
        session()->flash('success', 'Report approved successfully!');
        $this->report = AbsenceReport::with(['creator', 'checker', 'approver', 'accepter'])->find($this->reportId);
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

    public function render()
    {
        return view('livewire.prod.absence.absence-report-show', [
            'itemsDetail' => $this->report->items_detail,
        ]);
    }
}