<?php

namespace App\Livewire\QAQC\ScanXray;

use App\Livewire\QAQC\ScanXray\Concerns\HandlesScanXrayForm;
use App\Models\QAQC\ScanXray\ScanXray;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Scan X-Ray Edit')]
class ScanXrayEdit extends Component
{
    use HandlesScanXrayForm;
    use WithFileUploads;

    public $scan_id;

    public array $approvedGroups = [];

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

        // ✅ Cek approval edit aktif
        $hasApproval = $scan->hasActiveEditApproval();

        // Kalau tidak ada approval DAN completed DAN tidak ada NG belum lengkap → 403
        if (!$hasApproval && $scan->phase === 'completed' && !$scan->hasIncompleteNgDetail()) {
            abort(403, 'Data sudah selesai (all phases completed). Ajukan request edit untuk membuka akses.');
        }

        // ✅ Simpan group yang di-approve
        $this->approvedGroups = $hasApproval
            ? ($scan->activeEditRequest?->requested_groups ?? [])
            : [];

        $this->scan_id        = $scan->id;
        $this->currentScanId  = $scan->id;
        $this->customer_id    = $scan->customer_id;
        $this->model_id       = $scan->model_id;
        $this->pcb_type       = $scan->pcb_type ?? '';
        $this->phase          = $scan->phase ?? 'first';
        $this->shift          = $scan->shift;
        $this->group          = $scan->group;
        $this->master_line_id = $scan->master_line_id;
        $this->lot_qty        = $scan->lot_qty;
        $this->pic_xray       = $scan->pic_xray;
        $this->status_running = $scan->status_running ?? '';   // ✅ TAMBAH

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

        // ============ TAMBAHKAN INI ============
        $this->syncOpenGroupsWithPhase();
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

        // ✅ Cek approval edit aktif
        $hasApproval = $scan->hasActiveEditApproval();

        if (!$hasApproval && $scan->phase === 'completed' && !$scan->hasIncompleteNgDetail()) {
            $this->dispatch('notify', message: 'Data sudah selesai, tidak bisa diedit!', type: 'error');
            return;
        }

        $this->validationErrors = [];

        $this->validateGroupRows();
        if ($this->getErrorBag()->isNotEmpty()) {
            $this->validationErrors = $this->getErrorBag()->all();
        }

        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $msg) {
                    $this->validationErrors[] = $msg;
                }
            }
        }

        if (!empty($this->validationErrors)) {
            $this->validationErrors = array_values(array_unique($this->validationErrors));
            $this->dispatch('open-modal-error');
            return;
        }

        $existing = [
            'first_piece_items'  => $scan->first_piece_items['pictures']  ?? [],
            'middle_piece_items' => $scan->middle_piece_items['pictures'] ?? [],
            'last_piece_items'   => $scan->last_piece_items['pictures']   ?? [],
        ];

        $payload = $this->buildPayload($existing);

        // ✅ Kalau phase sebelumnya completed (mode lengkapi NG), jangan ubah phase
        if ($scan->phase === 'completed') {
            $payload['phase'] = 'completed';
        }

        // ⚠️ HAPUS blok if ($currentOrder > 1) { ... } dkk — itu yang menimpa payload dengan data lama

        $scan->update($payload);

        $msg = match ($scan->phase) {
            'first'         => 'First Piece saved.',
            'second_first'  => 'Second Piece (First) saved. Lanjut isi Middle Piece.',
            'middle'        => 'Middle Piece saved.',
            'second_middle' => 'Second Piece (Middle) saved. Lanjut isi Last Piece.',
            'last'          => 'Last Piece saved.',
            'second_last'   => 'Second Piece (Last) saved. Data scan x-ray sudah selesai.',
            'completed'     => $hasApproval
                ? 'Perubahan tersimpan (via approval edit).'
                : 'NG Detail berhasil dilengkapi.',
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