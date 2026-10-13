<?php

namespace App\Livewire\QAQC\ScanXray;

use App\Livewire\QAQC\ScanXray\Concerns\HandlesScanXrayForm;
use App\Models\QAQC\ScanXray\ScanXray;
use Livewire\Component;
use Livewire\WithFileUploads;

class ScanXrayEdit extends Component
{
    use HandlesScanXrayForm;
    use WithFileUploads;

    public $scan_id;

    public function mount($id): void
    {
        if (!auth()->user()->can('edit scan xray')) {
            abort(403, 'Unauthorized access.');
        }

        $scan = ScanXray::find($id);
        if (!$scan) abort(404, 'Scan X-Ray not found.');

        if ($scan->isLocked()) {
            abort(403, 'Data sudah lebih dari 24 jam, tidak bisa diedit.');
        }

        if ($scan->phase === 'completed') {
            abort(403, 'Data sudah selesai (all phases completed).');
        }

        $this->scan_id        = $scan->id;
        $this->customer_id    = $scan->customer_id;
        $this->model_id       = $scan->model_id;
        $this->pcb_type       = $scan->pcb_type ?? '';
        $this->phase          = $scan->phase ?? 'first';
        $this->shift          = $scan->shift;
        $this->group          = $scan->group;
        $this->master_line_id = $scan->master_line_id;
        $this->lot_qty        = $scan->lot_qty;

        $this->first_piece_items  = $this->mergeStructure($scan->first_piece_items  ?? [], 'first_piece_items');
        $this->middle_piece_items = $this->mergeStructure($scan->middle_piece_items ?? [], 'middle_piece_items');
        $this->last_piece_items   = $this->mergeStructure($scan->last_piece_items   ?? [], 'last_piece_items');

        $this->second_first_items  = $this->mergeStructure($scan->second_first_items  ?? [], 'second_first_items');
        $this->second_middle_items = $this->mergeStructure($scan->second_middle_items ?? [], 'second_middle_items');
        $this->second_last_items   = $this->mergeStructure($scan->second_last_items   ?? [], 'second_last_items');

        // Load judgements dari DB
        $side = $this->activeSide();
        if ($side) {
            foreach (['first_piece_items', 'middle_piece_items', 'last_piece_items'] as $grp) {
                $saved = $scan->{$grp}['judgements'] ?? null;
                if (!is_array($saved)) continue;

                foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                    $judges = $saved[$col] ?? null;
                    if (!is_array($judges)) continue;

                    $rowCount = count($this->{$grp}[$side][$col] ?? []);
                    $judges   = array_values($judges);
                    while (count($judges) < $rowCount) $judges[] = null;

                    $this->judgements[$grp][$side][$col] = array_slice($judges, 0, $rowCount);
                }
            }
        }
    }

    protected function rules(): array { return $this->formRules(); }
    protected function messages(): array { return $this->formMessages(); }

    public function withValidator($validator): void
    {
        // validation custom ditangani di validateGroupRows()
    }

    public function update()
    {
        if (!auth()->user()->can('edit scan xray')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $scan = ScanXray::find($this->scan_id);
        if (!$scan) {
            $this->dispatch('notify', message: 'Data not found!', type: 'error');
            return;
        }

        if ($scan->isLocked()) {
            $this->dispatch('notify', message: 'Data sudah lebih dari 24 jam, tidak bisa diedit!', type: 'error');
            return;
        }

        // Reset dulu
        $this->validationErrors = [];

        // 1. Validasi custom
        $this->validateGroupRows();

        if ($this->getErrorBag()->isNotEmpty()) {
            $this->validationErrors = $this->getErrorBag()->all();
        }

        // 2. Validasi standard
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $msg) {
                    $this->validationErrors[] = $msg;
                }
            }
        }

        // 3. Kalau ada error → tampilkan modal, stop
        if (!empty($this->validationErrors)) {
            $this->validationErrors = array_values(array_unique($this->validationErrors));
            $this->dispatch('open-modal-error');
            return;
        }

        // 4. Save
        $existing = [
            'first_piece_items'  => $scan->first_piece_items['pictures']  ?? [],
            'middle_piece_items' => $scan->middle_piece_items['pictures'] ?? [],
            'last_piece_items'   => $scan->last_piece_items['pictures']   ?? [],
        ];

        $payload = $this->buildPayload($existing);

        $phaseOrder = [
            'first' => 1, 'second_first' => 2,
            'middle' => 3, 'second_middle' => 4,
            'last' => 5, 'second_last' => 6,
            'completed' => 7,
        ];
        $currentOrder = $phaseOrder[$scan->phase] ?? 0;

        if ($currentOrder > 1) {
            $payload['first_piece_items'] = $scan->first_piece_items;
        }
        if ($currentOrder > 3) {
            $payload['middle_piece_items'] = $scan->middle_piece_items;
        }
        if ($currentOrder > 5) {
            $payload['last_piece_items'] = $scan->last_piece_items;
        }

        $scan->update($payload);

        $msg = match ($scan->phase) {
            'first'         => 'First Piece saved.',
            'second_first'  => 'Second Piece (First) saved. Lanjut isi Middle Piece.',
            'middle'        => 'Middle Piece saved.',
            'second_middle' => 'Second Piece (Middle) saved. Lanjut isi Last Piece.',
            'last'          => 'Last Piece saved.',
            'second_last'   => 'Second Piece (Last) saved. Data scan x-ray sudah selesai.',
            default         => 'Scan X-Ray updated successfully!',
        };
        $this->dispatch('notify', message: $msg);

        return redirect()->route('qaqc.scan-xray.index');
    }

    public function render()
    {
        return view('livewire.qaqc.scan-xray.scan-xray-edit', array_merge(
            $this->getDropdownData(),
            [
                'pcbTypeOptions' => $this->getPcbTypeOptionsProperty(),
                'activeSide'     => $this->activeSide(),
            ]
        ))->layout('layouts.app');
    }
}