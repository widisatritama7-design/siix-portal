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

        $this->phase = 'first';
        $this->initDetailStructures();

        // ⬇️ BARU: ambil PIC X-Ray dari session (dipilih via modal di index)
        $this->pic_xray = session()->pull('scan_xray_pic', '');
    }

    protected function rules(): array { return $this->formRules(); }
    protected function messages(): array { return $this->formMessages(); }

    public function withValidator($validator): void
    {
        // validation custom ditangani di validateGroupRows()
    }

    public function save()
    {
        if (!auth()->user()->can('create scan xray')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
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
        ScanXray::create($this->buildPayload([], true));

        $this->dispatch('notify', message: 'Scan X-Ray created successfully!');

        return redirect()->route('qaqc.scan-xray.index');
    }

    public function render()
    {
        return view('livewire.qaqc.scan-xray.scan-xray-create', array_merge(
            $this->getDropdownData(),
            [
                'pcbTypeOptions' => $this->getPcbTypeOptionsProperty(),
                'activeSide'     => $this->activeSide(),
            ]
        ))->layout('layouts.app');
    }
}