<?php

namespace App\Livewire\QAQC\ScanXray;

use App\Models\QAQC\ScanXray\ScanXrayEditRequest;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Scan X-Ray Approval')]
class ScanXrayEditApprovals extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = 'pending';   // default: tampilkan yang pending

    // Modal reject
    public bool $openRejectModal = false;
    public ?int $rejectTargetId = null;
    public string $rejectReason = '';

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedFilterStatus(): void { $this->resetPage(); }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->filterStatus = 'pending';
        $this->resetPage();
    }

    // ============ APPROVE ============
    public function approve(int $id): void
    {
        if (!auth()->user()->can('approve edit scan xray')) {
            $this->dispatch('notify', message: 'Tidak punya akses approve.', type: 'error');
            return;
        }

        $req = ScanXrayEditRequest::find($id);
        if (!$req) {
            $this->dispatch('notify', message: 'Request tidak ditemukan.', type: 'error');
            return;
        }

        if (!$req->isPending()) {
            $this->dispatch('notify', message: 'Request sudah diproses.', type: 'warning');
            return;
        }

        $req->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'expires_at'  => now()->addHours(24),   // ✅ edit window 24 jam
        ]);

        $this->dispatch('notify', message: 'Request di-approve. User punya 24 jam untuk edit.', type: 'success');
    }

    // ============ REJECT ============
    public function openReject(int $id): void
    {
        if (!auth()->user()->can('approve edit scan xray')) {
            $this->dispatch('notify', message: 'Tidak punya akses approve.', type: 'error');
            return;
        }

        $req = ScanXrayEditRequest::find($id);
        if (!$req || !$req->isPending()) {
            $this->dispatch('notify', message: 'Request tidak valid.', type: 'error');
            return;
        }

        $this->rejectTargetId = $id;
        $this->rejectReason   = '';
        $this->openRejectModal = true;
    }

    public function closeReject(): void
    {
        $this->openRejectModal = false;
        $this->reset(['rejectTargetId', 'rejectReason']);
    }

    public function confirmReject(): void
    {
        abort_unless(
            auth()->check()
            && auth()->user()->can('approve edit scan xray'),
            403,
            'Unauthorized access.'
        );

        $this->validate([
            'rejectReason' => 'required|string|max:500',
        ], [
            'rejectReason.required' => 'Alasan reject wajib diisi.',
            'rejectReason.max' => 'Alasan maksimal 500 karakter.',
        ]);

        $req = ScanXrayEditRequest::find($this->rejectTargetId);

        if (!$req || !$req->isPending()) {
            $this->dispatch(
                'notify',
                message: 'Request tidak valid.',
                type: 'error'
            );

            $this->closeReject();
            return;
        }

        $req->update([
            'status'        => 'rejected',
            'approved_by'   => auth()->id(),
            'rejected_at'   => now(),
            'reject_reason' => $this->rejectReason,
        ]);

        $this->dispatch(
            'notify',
            message: 'Request di-reject.',
            type: 'success'
        );

        $this->closeReject();
    }

    // ============ REVOKE (cabut approval) ============
    public function revoke(int $id): void
    {
        if (!auth()->user()->can('approve edit scan xray')) {
            $this->dispatch('notify', message: 'Tidak punya akses.', type: 'error');
            return;
        }

        $req = ScanXrayEditRequest::find($id);
        if (!$req) {
            $this->dispatch('notify', message: 'Request tidak ditemukan.', type: 'error');
            return;
        }

        if ($req->status !== 'approved') {
            $this->dispatch('notify', message: 'Hanya approval aktif yang bisa dicabut.', type: 'warning');
            return;
        }

        $req->update(['status' => 'revoked']);
        $this->dispatch('notify', message: 'Approval dicabut. User harus request ulang.', type: 'success');
    }

    // ============ RENDER ============
    public function render()
    {
        abort_unless(auth()->check(), 403);

        abort_unless(
            auth()->user()->can('approve edit scan xray'),
            403,
            'Unauthorized access.'
        );

        $query = ScanXrayEditRequest::query()
            ->with(['requester', 'approver', 'scanXray.customer', 'scanXray.model'])
            ->orderByDesc('id');

        if (!empty($this->filterStatus)) {
            $query->where('status', $this->filterStatus);
        }

        if (!empty($this->search)) {
            $term = '%' . $this->search . '%';

            $query->where(function ($q) use ($term) {
                $q->whereHas('scanXray.customer', fn ($qq) =>
                    $qq->where('customer_name', 'like', $term)
                )
                ->orWhereHas('scanXray.model', fn ($qq) =>
                    $qq->where('model_name', 'like', $term)
                )
                ->orWhereHas('requester', fn ($qq) =>
                    $qq->where('name', 'like', $term)
                )
                ->orWhere('scan_xray_id', 'like', $term);
            });
        }

        return view(
            'livewire.qaqc.scan-xray.scan-xray-edit-approvals',
            [
                'requests' => $query->paginate(10),
                'groups' => ScanXrayEditRequest::GROUPS,
            ]
        )->layout('layouts.app');
    }
}