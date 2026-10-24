<?php

namespace App\Livewire\QAQC\ScanXray;

use App\Models\QAQC\ScanXray\ScanXray;
use App\Models\QAQC\ScanXray\ScanXrayEditRequest;
use Livewire\Component;

class ScanXrayEditRequestModal extends Component
{
    public bool $open = false;
    public ?int $scanId = null;
    public array $selectedGroups = [];
    public string $reason = '';

    // ✅ groups sebagai property public — bukan dari render()
    public array $groups = [];

    protected $listeners = ['open-edit-request' => 'open'];

    public function mount(): void
    {
        $this->groups = ScanXrayEditRequest::GROUPS;
    }

    protected function rules(): array
    {
        return [
            'selectedGroups'   => 'required|array|min:1',
            'selectedGroups.*' => 'in:' . implode(',', array_keys(ScanXrayEditRequest::GROUPS)),
            'reason'           => 'nullable|string|max:1000',
        ];
    }

    protected function messages(): array
    {
        return [
            'selectedGroups.required' => 'Pilih minimal 1 group yang mau diedit.',
            'selectedGroups.min'      => 'Pilih minimal 1 group yang mau diedit.',
            'selectedGroups.*.in'     => 'Group tidak valid.',
            'reason.max'              => 'Alasan maksimal 1000 karakter.',
        ];
    }

    public function open(int $scanId): void
    {
        $scan = ScanXray::find($scanId);
        if (!$scan) {
            $this->dispatch('notify', message: 'Scan tidak ditemukan.', type: 'error');
            return;
        }

        if ($scan->activeEditRequest && $scan->activeEditRequest->isActive()) {
            $this->dispatch('notify', message: 'Sudah ada request aktif untuk scan ini.', type: 'warning');
            return;
        }

        $this->scanId         = $scanId;
        $this->selectedGroups = [];
        $this->reason         = '';
        $this->open           = true;
        $this->resetValidation();
    }

    public function close(): void
    {
        $this->open = false;
        $this->reset(['scanId', 'selectedGroups', 'reason']);
        $this->resetValidation();
    }

    public function submit(): void
    {
        $this->validate();

        $scan = ScanXray::find($this->scanId);
        if (!$scan) {
            $this->dispatch('notify', message: 'Scan tidak ditemukan.', type: 'error');
            $this->close();
            return;
        }

        if ($scan->activeEditRequest && $scan->activeEditRequest->isActive()) {
            $this->dispatch('notify', message: 'Sudah ada request aktif.', type: 'warning');
            $this->close();
            return;
        }

        ScanXrayEditRequest::create([
            'scan_xray_id'     => $scan->id,
            'requested_groups' => $this->selectedGroups,
            'reason'           => $this->reason ?: null,
            'status'           => 'pending',
            'requested_by'     => auth()->id(),
        ]);

        $this->dispatch('notify', message: 'Request edit berhasil dikirim. Menunggu approval.', type: 'success');
        $this->dispatch('request-edit-created');
        $this->close();
    }

    public function render()
    {
        return view('livewire.qaqc.scan-xray.scan-xray-edit-request-modal');
    }
}