<?php

namespace App\Livewire\QAQC\ScanXray;

use App\Livewire\QAQC\ScanXray\Concerns\HandlesScanXrayForm;
use App\Models\QAQC\ScanXray\ScanXray;
use Livewire\Component;
use Livewire\WithFileUploads;

class ScanXrayCreate extends Component
{
    use HandlesScanXrayForm;
    use WithFileUploads;

    public function mount(): void
    {
        if (!auth()->user()->can('create scan xray')) {
            abort(403, 'Unauthorized access.');
        }
        $this->initDetailStructures();
    }

    protected function rules(): array
    {
        return $this->formRules();
    }

    protected function messages(): array
    {
        return $this->formMessages();
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($v) {
            foreach (['first_piece_items', 'middle_piece_items', 'last_piece_items'] as $grp) {
                $item = $this->{$grp} ?? [];

                // Cek apakah grup ada isi (minimal ok_qty/ng_qty/pcb value)
                $hasContent = $this->groupHasContent($item);

                // Validasi status_running wajib kalau grup ada isi
                if ($hasContent && empty($item['status_running'])) {
                    $v->errors()->add("$grp.status_running", 'Status Running wajib diisi.');
                }

                // Validasi NG-related (existing)
                $ngQty = (int) ($item['ng_qty'] ?? 0);
                if ($ngQty > 0) {
                    $required = ['filling_ratio', 'qty_hold', 'ncp_id', 'remarks'];
                    foreach ($required as $field) {
                        if (empty($item[$field]) && $item[$field] !== 0) {
                            $v->errors()->add("$grp.$field", "Field ini wajib diisi karena NG Qty > 0.");
                        }
                    }
                    if (empty($item['pictures'])) {
                        $v->errors()->add("$grp.pictures", "Pictures wajib diupload karena NG Qty > 0.");
                    }
                    $ok = (int) ($item['status_after_check']['ok'] ?? 0);
                    $ng = (int) ($item['status_after_check']['ng'] ?? 0);
                    $hold = (int) ($item['qty_hold'] ?? 0);
                    if (($ok + $ng) !== $hold) {
                        $v->errors()->add("$grp.qty_hold", "OK + NG harus sama dengan Qty Hold.");
                    }
                }
            }
        });
    }

    public function save()
    {
        if (!auth()->user()->can('create scan xray')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $this->validate();

        ScanXray::create($this->buildPayload());

        $this->dispatch('notify', message: 'Scan X-Ray created successfully!');

        return redirect()->route('qaqc.scan-xray.index');
    }

    public function render()
    {
        return view('livewire.qaqc.scan-xray.scan-xray-create', $this->getDropdownData())
            ->layout('layouts.app');
    }
}