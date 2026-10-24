<div class="p-1 space-y-4">
    {{-- BREADCRUMBS --}}
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">QA/QC</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('qaqc.scan-xray.index') }}" wire:navigate separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">Scan X-Ray</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-amber-600 dark:text-amber-400">Edit Approvals</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">Approval Edit Scan X-Ray</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Approve atau reject permintaan edit scan x-ray</p>
        </div>
        <flux:button href="{{ route('qaqc.scan-xray.index') }}" wire:navigate icon="arrow-left"
            class="!bg-gradient-to-r !from-sky-400 !to-blue-400 !text-white !border-0 !shadow-md">
            Back
        </flux:button>
    </div>

    {{-- FILTER BAR --}}
    <div class="rounded-xl border border-amber-300 dark:border-amber-700 bg-white dark:bg-zinc-900 p-4 shadow-sm">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            <div class="lg:col-span-2">
                <label class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1 block">Search</label>
                <flux:input wire:model.live.debounce.300ms="search"
                    placeholder="Cari customer / model / requester / scan ID..."
                    icon="magnifying-glass" clearable />
            </div>
            <div>
                <label class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1 block">Status</label>
                <flux:select wire:model.live="filterStatus" placeholder="-- All Status --">
                    <flux:select.option value="">-- All Status --</flux:select.option>
                    <flux:select.option value="pending">Pending</flux:select.option>
                    <flux:select.option value="approved">Approved</flux:select.option>
                    <flux:select.option value="rejected">Rejected</flux:select.option>
                    <flux:select.option value="revoked">Revoked</flux:select.option>
                </flux:select>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <flux:card class="p-0 shadow-lg overflow-hidden">
        <div class="relative px-6 py-4 bg-gradient-to-r from-amber-500 via-orange-500 to-red-500">
            <div class="flex items-center justify-between">
                <div class="text-base font-bold text-white">Edit Request List</div>
                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-white/20 border border-white/30 text-white text-xs font-semibold">
                    {{ $requests->total() }} total
                </span>
            </div>
        </div>

        <div class="p-6">
            @if($requests->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-xs">
                        <thead>
                            <tr class="bg-zinc-100 dark:bg-zinc-800/80 border-b-2 border-zinc-200 dark:border-zinc-700">
                                <th class="px-3 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300 uppercase text-[10px] w-12">#</th>
                                <th class="px-3 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300 uppercase text-[10px]">Scan</th>
                                <th class="px-3 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300 uppercase text-[10px]">Group Diminta</th>
                                <th class="px-3 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300 uppercase text-[10px]">Alasan</th>
                                <th class="px-3 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300 uppercase text-[10px]">Requester</th>
                                <th class="px-3 py-3 text-left font-semibold text-zinc-600 dark:text-zinc-300 uppercase text-[10px]">Status</th>
                                <th class="px-3 py-3 text-center font-semibold text-zinc-600 dark:text-zinc-300 uppercase text-[10px] w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($requests as $req)
                                @php
                                    $statusColors = [
                                        'pending'  => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300',
                                        'approved' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
                                        'rejected' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
                                        'revoked'  => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300',
                                    ];
                                    $isExpired = $req->isExpired();
                                @endphp
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50" wire:key="req-{{ $req->id }}">

                                    {{-- ID --}}
                                    <td class="px-3 py-3 text-zinc-500 font-mono">{{ $req->id }}</td>

                                    {{-- SCAN --}}
                                    <td class="px-3 py-3">
                                        <div class="font-semibold text-zinc-800 dark:text-white">Scan #{{ $req->scan_xray_id }}</div>
                                        <div class="text-[10px] text-zinc-500 dark:text-zinc-400">
                                            {{ $req->scanXray->customer->customer_name ?? '-' }} / {{ $req->scanXray->model->model_name ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- GROUP --}}
                                    <td class="px-3 py-3">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach(($req->requested_groups ?? []) as $g)
                                                <span class="inline-flex px-1.5 py-0.5 rounded bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 text-[10px] font-bold">
                                                    {{ $groups[$g] ?? $g }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>

                                    {{-- ALASAN --}}
                                    <td class="px-3 py-3 max-w-[200px]">
                                        <div class="text-zinc-600 dark:text-zinc-400 line-clamp-2 text-[11px]">
                                            {{ $req->reason ?: '-' }}
                                        </div>
                                    </td>

                                    {{-- REQUESTER --}}
                                    <td class="px-3 py-3">
                                        <div class="text-zinc-800 dark:text-zinc-200 font-semibold text-[11px]">{{ $req->requester->name ?? '-' }}</div>
                                        <div class="text-[9px] text-zinc-400 dark:text-zinc-500 font-mono">{{ $req->created_at?->format('d M Y, H:i') }}</div>
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="px-3 py-3">
                                        <div class="flex flex-col gap-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold w-fit
                                                {{ $statusColors[$req->status] ?? '' }}">
                                                {{ strtoupper($req->status) }}
                                            </span>
                                            @if($req->status === 'approved' && $req->expires_at)
                                                <span class="text-[9px] {{ $isExpired ? 'text-red-500' : 'text-emerald-600 dark:text-emerald-400' }} font-semibold">
                                                    {{ $isExpired ? '⏱ Expired' : '⏱ Exp: ' . $req->expires_at->format('d/m H:i') }}
                                                </span>
                                            @endif
                                            @if($req->status === 'rejected' && $req->reject_reason)
                                                <span class="text-[9px] text-red-500 truncate max-w-[120px]" title="{{ $req->reject_reason }}">
                                                    {{ $req->reject_reason }}
                                                </span>
                                            @endif
                                            @if($req->status === 'approved' && $req->approver)
                                                <span class="text-[9px] text-zinc-500 dark:text-zinc-400">
                                                    by {{ $req->approver->name }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="px-3 py-3 text-center">
                                        <div class="flex items-center justify-center gap-1 flex-wrap">
                                            @if($req->isPending())
                                                <flux:button wire:click="approve({{ $req->id }})"
                                                    size="sm" icon="check" variant="primary" color="emerald"
                                                    class="!p-1.5" wire:loading.attr="disabled" wire:target="approve({{ $req->id }})" />
                                                <flux:button wire:click="openReject({{ $req->id }})"
                                                    size="sm" icon="x-mark" variant="primary" color="red"
                                                    class="!p-1.5" />
                                            @elseif($req->status === 'approved' && !$isExpired)
                                                <flux:button wire:click="revoke({{ $req->id }})"
                                                    size="sm" icon="arrow-uturn-left" variant="primary" color="zinc"
                                                    class="!p-1.5" />
                                            @else
                                                <span class="text-[10px] text-zinc-400 italic">-</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($requests->hasPages())
                    <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700 flex justify-center">
                        {{ $requests->links() }}
                    </div>
                @endif
            @else
                <div class="py-12 text-center">
                    <div class="w-16 h-16 mx-auto rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-zinc-400">
                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-zinc-800 dark:text-white">Tidak Ada Request</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        {{ $filterStatus === 'pending' ? 'Belum ada request edit yang menunggu approval.' : 'Tidak ada request untuk filter ini.' }}
                    </p>
                </div>
            @endif
        </div>
    </flux:card>

    {{-- MODAL REJECT --}}
    <div x-data="{ open: @entangle('openRejectModal') }" x-show="open" x-cloak @keydown.escape.window="$wire.closeReject()">
        <div class="fixed inset-0 bg-black/50 z-40" @click="$wire.closeReject()"></div>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
                {{-- HEADER --}}
                <div class="px-6 py-4 bg-gradient-to-r from-red-500 via-rose-500 to-pink-500">
                    <div class="text-[10px] text-white/80 uppercase tracking-wider font-semibold">Konfirmasi</div>
                    <div class="text-lg font-bold text-white">Reject Request Edit</div>
                </div>

                {{-- BODY --}}
                <div class="p-6 space-y-3">
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        Yakin ingin reject request ini? User akan menerima notifikasi dan tidak bisa edit.
                    </p>
                    <div>
                        <label class="text-[10px] uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 mb-1 block">
                            Alasan Reject <span class="text-red-500">*</span>
                        </label>
                        <flux:textarea wire:model="rejectReason" rows="3" placeholder="Tulis alasan reject..." />
                        @error('rejectReason') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-2">
                    <flux:button wire:click="closeReject" variant="filled">Batal</flux:button>
                    <flux:button wire:click="confirmReject" variant="primary" class="bg-red-600 hover:bg-red-700"
                        wire:loading.attr="disabled" wire:target="confirmReject">
                        <span wire:loading.remove wire:target="confirmReject">Ya, Reject</span>
                        <span wire:loading wire:target="confirmReject">Memproses...</span>
                    </flux:button>
                </div>
            </div>
        </div>
    </div>

    {{-- NOTIF --}}
    <div x-data="{ show: false, message: '', type: 'success' }"
        x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
        x-show="show" x-transition
        class="fixed bottom-4 right-4 z-50"
        :class="{ 'bg-green-500': type === 'success', 'bg-red-500': type === 'error', 'bg-yellow-500': type === 'warning' }"
        style="display: none;">
        <div class="text-white px-6 py-3 rounded-lg shadow-lg"><span x-text="message"></span></div>
    </div>
</div>