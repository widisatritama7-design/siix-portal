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
        $firstFilled        = $this->groupHasContent($this->scan->first_piece_items  ?? []);
        $middleFilled       = $this->groupHasContent($this->scan->middle_piece_items ?? []);
        $lastFilled         = $this->groupHasContent($this->scan->last_piece_items   ?? []);
        $secondFirstFilled  = $this->groupHasContent($this->scan->second_first_items  ?? []);
        $secondMiddleFilled = $this->groupHasContent($this->scan->second_middle_items ?? []);
        $secondLastFilled   = $this->groupHasContent($this->scan->second_last_items   ?? []);

        return view('livewire.qaqc.scan-xray.scan-xray-view', [
            'firstFilled'        => $firstFilled,
            'middleFilled'       => $middleFilled,
            'lastFilled'         => $lastFilled,
            'secondFirstFilled'  => $secondFirstFilled,
            'secondMiddleFilled' => $secondMiddleFilled,
            'secondLastFilled'   => $secondLastFilled,
            'activeSide'         => $this->scan->active_side,
        ])->layout('layouts.app');
    }

    /**
     * Cek apakah grup punya isi.
     */
    protected function groupHasContent(array $item): bool
    {
        if (empty($item)) return false;

        if (!empty($item['time_scan'])) return true;

        foreach (['side_single', 'side_lh', 'side_rh'] as $side) {
            foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                $vals = $item[$side][$col] ?? [];
                if (is_array($vals)) {
                    foreach ($vals as $v) if (!empty($v)) return true;
                } elseif (!empty($vals)) {
                    return true;
                }
            }
        }

        foreach (['filling_ratio', 'qty_hold', 'ncp_id', 'remarks', 'status_running'] as $field) {
            if (!empty($item[$field])) return true;
        }
        if (!empty($item['pictures']) && is_array($item['pictures'])) return true;
        if (!empty($item['status_after_check']['ok']) || !empty($item['status_after_check']['ng'])) return true;

        return false;
    }
}