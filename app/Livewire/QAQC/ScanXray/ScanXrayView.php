<?php

namespace App\Livewire\QAQC\ScanXray;

use App\Models\QAQC\ScanXray\ScanXray;
use Livewire\Component;

class ScanXrayView extends Component
{
    public $scan;

    public function mount($id): void
    {
        if (!auth()->user()->can('view scan xray')) {
            abort(403, 'Unauthorized access.');
        }

        $this->scan = ScanXray::with(['customer', 'model', 'masterLine.location', 'creator', 'updater'])
            ->find($id);

        if (!$this->scan) {
            abort(404, 'Scan X-Ray not found.');
        }
    }

    public function render()
    {
        return view('livewire.qaqc.scan-xray.scan-xray-view')
            ->layout('layouts.app');
    }
}