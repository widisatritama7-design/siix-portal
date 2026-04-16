<?php

namespace App\Livewire\MTC\Dashboard;

use App\Models\MTC\Master\MasterStencil;
use Livewire\Component;

class StencilDashboard extends Component
{
    public $pollingInterval = 5000; // 5 seconds

    public function getJigsProperty()
    {
        $allJigs = MasterStencil::with(['updater', 'employee'])
            ->where('category', 'STENCIL')
            ->get()
            ->groupBy('line_name');

        $jigs = collect();
        for ($i = 1; $i <= 17; $i++) {
            $line = "SMT $i";
            $jigs[$line] = $allJigs[$line] ?? collect();
        }

        return $jigs;
    }

    public function getEmployeesProperty()
    {
        return \App\Models\HR\Employee::select('ID', 'nik', 'name')->get();
    }

    public function render()
    {
        return view('livewire.mtc.dashboard.stencil-dashboard', [
            'jigs' => $this->jigs,
            'employees' => $this->employees,
        ]);
    }
}