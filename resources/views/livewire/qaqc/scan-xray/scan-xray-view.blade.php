<div class="p-1 space-y-2">
    {{-- BREADCRUMBS --}}
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">QA/QC</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('qaqc.scan-xray.index') }}" wire:navigate separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">Scan X-Ray</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">Detail</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    {{-- HEADER PAGE --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">Scan X-Ray Detail</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Detail informasi hasil inspeksi Scan X-Ray
            </p>
        </div>
        <div class="flex gap-2">
            @can('edit scan xray')
                <flux:button href="{{ route('qaqc.scan-xray.edit', $scan->id) }}" wire:navigate
                    variant="primary"
                    icon="pencil-square"
                    class="!bg-gradient-to-r !from-amber-400 !to-orange-400 hover:!from-amber-500 hover:!to-orange-500 !text-white !border-0 !shadow-md hover:!shadow-lg">
                    Edit
                </flux:button>
            @endcan
            <flux:button href="{{ route('qaqc.scan-xray.index') }}" wire:navigate
                icon="arrow-left"
                class="!bg-gradient-to-r !from-sky-400 !to-blue-400 hover:!from-sky-500 hover:!to-blue-500 !text-white !border-0 !shadow-md hover:!shadow-lg">
                Back
            </flux:button>
        </div>
    </div>

    {{-- ==================== HEADER INFORMATION CARD ==================== --}}
    <div class="relative rounded-2xl overflow-hidden shadow-lg ring-1 ring-blue-200/50 dark:ring-blue-800/50 bg-white dark:bg-zinc-900">

        {{-- HEADER GRADIENT --}}
        <div class="relative px-6 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 overflow-hidden">
            <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/10"></div>
            <div class="absolute -right-4 -bottom-10 w-20 h-20 rounded-full bg-white/10"></div>

            <div class="relative flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-[10px] text-white/70 uppercase tracking-wider font-semibold">Header</div>
                        <div class="text-base font-bold text-white leading-tight">Header Information</div>
                    </div>
                </div>

                {{-- STATUS BADGE --}}
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                        #{{ $scan->id }}
                    </span>
                </div>
            </div>
        </div>

        {{-- BODY --}}
        <div class="p-5 bg-gradient-to-b from-white to-zinc-50/50 dark:from-zinc-900 dark:to-zinc-900/50">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">

                {{-- CUSTOMER --}}
                <div class="rounded-lg bg-gradient-to-br from-blue-50 to-blue-100/50 dark:from-blue-900/20 dark:to-blue-900/10 p-3 border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center gap-1.5 text-[10px] text-blue-700 dark:text-blue-400 uppercase tracking-wider font-semibold mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z" />
                        </svg>
                        Customer
                    </div>
                    <div class="text-sm font-bold text-zinc-800 dark:text-white truncate">
                        {{ $scan->customer->customer_name ?? '-' }}
                    </div>
                </div>

                {{-- MODEL --}}
                <div class="rounded-lg bg-gradient-to-br from-indigo-50 to-indigo-100/50 dark:from-indigo-900/20 dark:to-indigo-900/10 p-3 border border-indigo-200 dark:border-indigo-800">
                    <div class="flex items-center gap-1.5 text-[10px] text-indigo-700 dark:text-indigo-400 uppercase tracking-wider font-semibold mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path fill-rule="evenodd" d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 18.375V5.625ZM21 9.375A.375.375 0 0 0 20.625 9h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5ZM10.875 18.75a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5Z" clip-rule="evenodd" />
                        </svg>
                        Model
                    </div>
                    <div class="text-sm font-bold text-zinc-800 dark:text-white truncate">
                        {{ $scan->model->model_name ?? '-' }}
                    </div>
                </div>

                {{-- SHIFT --}}
                <div class="rounded-lg bg-gradient-to-br from-cyan-50 to-cyan-100/50 dark:from-cyan-900/20 dark:to-cyan-900/10 p-3 border border-cyan-200 dark:border-cyan-800">
                    <div class="flex items-center gap-1.5 text-[10px] text-cyan-700 dark:text-cyan-400 uppercase tracking-wider font-semibold mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd" />
                        </svg>
                        Shift
                    </div>
                    <div class="text-sm font-bold">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-cyan-100 text-cyan-700 dark:bg-cyan-900/40 dark:text-cyan-300">
                            {{ $scan->shift }}
                        </span>
                    </div>
                </div>

                {{-- GROUP --}}
                <div class="rounded-lg bg-gradient-to-br from-purple-50 to-purple-100/50 dark:from-purple-900/20 dark:to-purple-900/10 p-3 border border-purple-200 dark:border-purple-800">
                    <div class="flex items-center gap-1.5 text-[10px] text-purple-700 dark:text-purple-400 uppercase tracking-wider font-semibold mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path d="M7 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM14.5 9a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5ZM1.615 16.428a1.224 1.224 0 0 1-.569-1.175 6.002 6.002 0 0 1 11.908 0c.058.467-.172.92-.57 1.174A9.953 9.953 0 0 1 7 18a9.953 9.953 0 0 1-5.385-1.572ZM14.5 16h-.106c.07-.297.088-.611.048-.933a7.47 7.47 0 0 0-1.588-3.755 4.502 4.502 0 0 1 5.874 2.636.818.818 0 0 1-.36.98A7.465 7.465 0 0 1 14.5 16Z" />
                        </svg>
                        Group
                    </div>
                    <div class="text-sm font-bold">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300">
                            {{ $scan->group }}
                        </span>
                    </div>
                </div>

                {{-- MASTER LINE --}}
                <div class="rounded-lg bg-gradient-to-br from-emerald-50 to-emerald-100/50 dark:from-emerald-900/20 dark:to-emerald-900/10 p-3 border border-emerald-200 dark:border-emerald-800 sm:col-span-2 md:col-span-1">
                    <div class="flex items-center gap-1.5 text-[10px] text-emerald-700 dark:text-emerald-400 uppercase tracking-wider font-semibold mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path fill-rule="evenodd" d="M1 2.75A.75.75 0 0 1 1.75 2h16.5a.75.75 0 0 1 0 1.5H1.75A.75.75 0 0 1 1 2.75Zm0 5A.75.75 0 0 1 1.75 7h16.5a.75.75 0 0 1 0 1.5H1.75A.75.75 0 0 1 1 7.75Zm0 5A.75.75 0 0 1 1.75 12h16.5a.75.75 0 0 1 0 1.5H1.75A.75.75 0 0 1 1 12.75Z" clip-rule="evenodd" />
                        </svg>
                        Master Line
                    </div>
                    <div class="text-sm font-bold text-zinc-800 dark:text-white truncate">
                        {{ $scan->masterLine->location->location_name ?? '-' }} — Line {{ $scan->masterLine->line_number ?? '-' }}
                    </div>
                </div>

                {{-- LOT QTY --}}
                <div class="rounded-lg bg-gradient-to-br from-amber-50 to-amber-100/50 dark:from-amber-900/20 dark:to-amber-900/10 p-3 border border-amber-200 dark:border-amber-800">
                    <div class="flex items-center gap-1.5 text-[10px] text-amber-700 dark:text-amber-400 uppercase tracking-wider font-semibold mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path d="M10.75 10.818v2.614A3.13 3.13 0 0 0 11.888 13c.482-.315.612-.648.612-.875 0-.227-.13-.56-.612-.875a3.13 3.13 0 0 0-1.138-.432ZM8.33 8.62c.053.055.115.11.184.164.208.16.46.284.736.363V6.603a2.45 2.45 0 0 0-.35.13c-.14.065-.27.143-.386.233-.377.292-.514.627-.514.909 0 .184.058.39.202.592.037.051.08.102.128.152Z" />
                            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0ZM7.184 11.953A2.997 2.997 0 0 0 8.5 14.5v.75a.75.75 0 0 0 1.5 0v-.75a4.5 4.5 0 0 0 3.67-2.123 2.75 2.75 0 0 0-1.045-4.04l-1.257-.629a.913.913 0 0 1-.435-.497.908.908 0 0 1 .053-.716c.173-.352.452-.636.788-.824a.75.75 0 1 0-.748-1.3c-.482.278-.89.66-1.17 1.135a2.408 2.408 0 0 0-.128 1.846c.143.4.44.736.825.928l1.257.629a1.25 1.25 0 0 1 .475 1.836 3 3 0 0 1-1.07.876V13a.75.75 0 0 0-1.5 0v-.75a2.997 2.997 0 0 1-1.316-.297.75.75 0 1 0-.6 1.375Z" clip-rule="evenodd" />
                        </svg>
                        Lot Qty
                    </div>
                    <div class="text-sm font-bold font-mono text-zinc-800 dark:text-white">
                        {{ number_format($scan->lot_qty) }}
                    </div>
                </div>

                {{-- CREATED BY --}}
                <div class="rounded-lg bg-gradient-to-br from-zinc-50 to-zinc-100/50 dark:from-zinc-800/50 dark:to-zinc-800/20 p-3 border border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center gap-1.5 text-[10px] text-zinc-600 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z" />
                        </svg>
                        PIC X-RAY
                    </div>
                    <div class="text-sm font-semibold text-zinc-800 dark:text-white truncate">
                        {{ $scan->creator->name ?? '-' }}
                    </div>
                </div>

                {{-- CREATED AT --}}
                <div class="rounded-lg bg-gradient-to-br from-zinc-50 to-zinc-100/50 dark:from-zinc-800/50 dark:to-zinc-800/20 p-3 border border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center gap-1.5 text-[10px] text-zinc-600 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z" clip-rule="evenodd" />
                        </svg>
                        DATE
                    </div>
                    <div class="text-sm font-semibold text-zinc-800 dark:text-white">
                        {{ $scan->created_at?->format('d M Y, H:i') }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    @php
        $isGroupFilled = function ($item) {
            if (!is_array($item) || empty($item)) return false;
            if (!empty($item['time_scan'])) return true;
            if (!empty($item['ok_qty']) || !empty($item['ng_qty'])) return true;
            foreach (['side_lh', 'side_rh'] as $side) {
                foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                    $vals = $item[$side][$col] ?? [];
                    if (is_array($vals)) {
                        foreach ($vals as $v) if (!empty($v)) return true;
                    } elseif (!empty($vals)) return true;
                }
            }
            foreach (['filling_ratio', 'qty_hold', 'ncp_id', 'remarks'] as $field) {
                if (!empty($item[$field])) return true;
            }
            if (!empty($item['pictures']) && is_array($item['pictures'])) return true;
            if (!empty($item['status_after_check']['ok']) || !empty($item['status_after_check']['ng'])) return true;
            return false;
        };

        $hasAnyGroup = $isGroupFilled($scan->first_piece_items)
            || $isGroupFilled($scan->middle_piece_items)
            || $isGroupFilled($scan->last_piece_items);
    @endphp

    @if($hasAnyGroup)
        @if($isGroupFilled($scan->first_piece_items))
            @include('livewire.qaqc.scan-xray.partials.piece-items-form', [
                'key' => 'first_piece_items', 'label' => 'First Piece Items',
                'items' => $scan->first_piece_items ?? [], 'readonly' => true,
            ])
        @endif

        @if($isGroupFilled($scan->middle_piece_items))
            @include('livewire.qaqc.scan-xray.partials.piece-items-form', [
                'key' => 'middle_piece_items', 'label' => 'Middle Piece Items',
                'items' => $scan->middle_piece_items ?? [], 'readonly' => true,
            ])
        @endif

        @if($isGroupFilled($scan->last_piece_items))
            @include('livewire.qaqc.scan-xray.partials.piece-items-form', [
                'key' => 'last_piece_items', 'label' => 'Last Piece Items',
                'items' => $scan->last_piece_items ?? [], 'readonly' => true,
            ])
        @endif
    @else
        {{-- EMPTY STATE KALAU SEMUA GRUP KOSONG --}}
        <div class="rounded-2xl border-2 border-dashed border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-12">
            <div class="flex flex-col items-center gap-3 text-center">
                <div class="w-16 h-16 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-zinc-400">
                        <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875Zm6.905 9.97a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72V18a.75.75 0 0 0 1.5 0v-4.19l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-800 dark:text-white mb-1">Belum Ada Data Inspeksi</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        Belum ada piece items yang diisi untuk scan x-ray ini.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>