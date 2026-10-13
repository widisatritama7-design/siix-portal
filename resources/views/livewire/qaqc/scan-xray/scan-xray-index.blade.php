<div class="p-1 space-y-2">
    {{-- BREADCRUMBS --}}
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">QA/QC</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">Scan X-Ray</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">Scan X-Ray</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Manage Scan X-Ray data</p>
        </div>

    <div class="flex flex-wrap gap-2">
        @can('view scan xray')
            <flux:button wire:click="exportExcel"
                wire:loading.attr="disabled"
                wire:target="exportExcel"
                variant="primary"
                icon="arrow-down-tray"
                class="bg-emerald-600 hover:bg-emerald-700 disabled:opacity-60">
                <span wire:loading.remove wire:target="exportExcel">Export Excel</span>
                <span wire:loading wire:target="exportExcel">Exporting...</span>
            </flux:button>
        @endcan

        @can('create scan xray')
            <flux:button variant="primary" icon="plus" class="bg-blue-600 hover:bg-blue-700"
                href="{{ route('qaqc.scan-xray.create') }}" wire:navigate>
                Add New Scan
            </flux:button>
        @endcan
    </div>
    </div>

    {{-- ==================== FILTER BAR ==================== --}}
    <div x-data="{ open: true }"
        class="rounded-xl border border-orange-300 dark:border-orange-700 bg-white dark:bg-zinc-900 shadow-sm overflow-hidden">

        {{-- HEADER BUTTON — ORANGE FULL WIDTH --}}
        <button type="button"
            x-on:click="open = !open"
            class="w-full px-4 py-3 flex items-center justify-between cursor-pointer bg-gradient-to-r from-orange-400 to-orange-600 hover:from-orange-500 hover:to-orange-700 dark:from-orange-500 dark:to-orange-700 dark:hover:from-orange-600 dark:hover:to-orange-800 transition-all">
            <div class="flex items-center gap-2">
                {{-- ICON — background putih transparan biar kontras di atas orange --}}
                <div class="w-7 h-7 rounded-lg bg-white/20 backdrop-blur flex items-center justify-center ring-1 ring-white/30">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-white">
                        <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 0 1 .628.74v2.288a2.25 2.25 0 0 1-.659 1.59l-4.682 4.683a2.25 2.25 0 0 0-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 0 1 8 18.25v-5.757a2.25 2.25 0 0 0-.659-1.591L2.659 6.22A2.25 2.25 0 0 1 2 4.629V2.34a.75.75 0 0 1 .628-.74Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="text-left">
                    <div class="text-[10px] text-white/80 uppercase tracking-wider font-semibold">Filter</div>
                    <div class="text-sm font-bold text-white leading-tight">Search & Filter</div>
                </div>

                @if($this->hasActiveFilter())
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-white/20 text-white text-[10px] font-semibold ml-2 ring-1 ring-white/30">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                        Active
                    </span>
                @endif
            </div>

            <div class="flex items-center gap-2">
                @if($this->hasActiveFilter())
                    <span wire:click.stop="resetFilters"
                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white hover:bg-white/20 rounded-lg transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                            <path fill-rule="evenodd" d="M15.312 11.424a5.5 5.5 0 0 1-9.201 2.466l-.312-.311h2.433a.75.75 0 0 0 0-1.5H3.989a.75.75 0 0 0-.75.75v4.242a.75.75 0 0 0 1.5 0v-2.43l.31.31a7 7 0 0 0 11.712-3.138.75.75 0 0 0-1.449-.39Zm1.23-3.723a.75.75 0 0 0 .219-.53V2.929a.75.75 0 0 0-1.5 0V5.36l-.31-.31A7 7 0 0 0 3.239 8.188a.75.75 0 1 0 1.448.389A5.5 5.5 0 0 1 13.89 6.11l.311.31h-2.432a.75.75 0 0 0 0 1.5h4.243a.75.75 0 0 0 .53-.219Z" clip-rule="evenodd" />
                        </svg>
                        Reset
                    </span>
                @endif

                <div class="w-7 h-7 rounded-lg bg-white/20 backdrop-blur flex items-center justify-center transition-transform duration-300 ring-1 ring-white/30"
                    :class="open ? 'rotate-180' : ''">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-white">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </button>

        <div x-show="open" x-collapse x-cloak class="px-4 pb-4 pt-4">
            <div class="space-y-3">

                {{-- SEARCH --}}
                <div>
                    <label class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1 block">
                        Search
                    </label>
                    <flux:input wire:model.live.debounce.300ms="search"
                        placeholder="Search customer / model / shift / group / PCB type..."
                        icon="magnifying-glass" clearable />
                </div>

                {{-- CUSTOMER, MODEL, LINE --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    <div>
                        <label class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1 block">Customer</label>
                        <flux:select wire:model.live="filterCustomerId" placeholder="-- All Customer --">
                            <flux:select.option value="">-- All Customer --</flux:select.option>
                            @foreach($customers as $cust)
                                <flux:select.option value="{{ $cust->id }}">{{ $cust->customer_name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <label class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1 block">Model</label>
                        <flux:select wire:model.live="filterModelId" placeholder="-- All Model --" :disabled="!$filterCustomerId">
                            <flux:select.option value="">-- All Model --</flux:select.option>
                            @foreach($models as $mdl)
                                <flux:select.option value="{{ $mdl->id }}">{{ $mdl->model_name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <label class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1 block">Line</label>
                        <flux:select wire:model.live="filterMasterLineId" placeholder="-- All Line --">
                            <flux:select.option value="">-- All Line --</flux:select.option>
                            @foreach($masterLines as $line)
                                <flux:select.option value="{{ $line->id }}">
                                    {{ $line->location->location_name ?? '-' }} - Line {{ $line->line_number }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>

                {{-- YEAR, MONTH, DATE FROM, DATE UNTIL --}}
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div>
                        <label class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1 block">Year</label>
                        <flux:select wire:model.live="filterYear" placeholder="-- All Year --">
                            <flux:select.option value="">-- All Year --</flux:select.option>
                            @foreach($years as $yr)
                                <flux:select.option value="{{ $yr }}">{{ $yr }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <label class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1 block">Month</label>
                        <flux:select wire:model.live="filterMonth" placeholder="-- All Month --">
                            <flux:select.option value="">-- All Month --</flux:select.option>
                            @foreach($months as $num => $name)
                                <flux:select.option value="{{ $num }}">{{ $name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <label class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1 block">Date From</label>
                        <flux:input type="date" wire:model.live="filterDateFrom" />
                    </div>

                    <div>
                        <label class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1 block">Date Until</label>
                        <flux:input type="date" wire:model.live="filterDateUntil" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== TABLE ==================== --}}
    <flux:card class="p-0 shadow-lg flex flex-col overflow-hidden">
        <div class="relative px-6 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600">
            <div class="flex items-center justify-between">
                <div class="text-base font-bold text-white">Scan X-Ray List</div>
                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-white/20 border border-white/30 text-white text-xs font-semibold">
                    {{ $scans->total() }} total
                </span>
            </div>
        </div>

        <div class="p-6">
            @if($scans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full" style="min-width: 2100px; white-space: nowrap; border-collapse: separate; border-spacing: 0;">
                        <thead>
                            {{-- BARIS HEADER 1 --}}
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th rowspan="2" class="px-4 py-2 text-center text-xs font-medium text-zinc-500 uppercase sticky left-0 z-20 bg-zinc-50 dark:bg-zinc-800" style="min-width: 50px; width: 50px; box-shadow: inset -1px 0 0 0 rgb(228 228 231);">#</th>
                                <th rowspan="2" class="px-4 py-2 text-center text-xs font-medium text-zinc-500 uppercase sticky z-20 bg-zinc-50 dark:bg-zinc-800" style="left: 50px; min-width: 170px; box-shadow: inset -1px 0 0 0 rgb(228 228 231);">Customer</th>
                                <th rowspan="2" class="px-4 py-2 text-center text-xs font-medium text-zinc-500 uppercase sticky z-20 bg-zinc-50 dark:bg-zinc-800" style="left: 220px; min-width: 170px; box-shadow: inset -1px 0 0 0 rgb(228 228 231);">Model</th>
                                <th rowspan="2" class="px-3 py-2 text-center text-xs font-medium text-zinc-500 uppercase sticky z-20 bg-zinc-50 dark:bg-zinc-800" style="left: 390px; min-width: 100px; box-shadow: inset -2px 0 0 0 rgb(212 212 216);">PCB Type</th>

                                <th rowspan="2" class="px-3 py-2 text-center text-xs font-medium text-zinc-500 uppercase">Shift</th>
                                <th rowspan="2" class="px-3 py-2 text-center text-xs font-medium text-zinc-500 uppercase">Group</th>
                                <th rowspan="2" class="px-3 py-2 text-center text-xs font-medium text-zinc-500 uppercase">Line</th>
                                <th rowspan="2" class="px-3 py-2 text-center text-xs font-medium text-zinc-500 uppercase">Lot Qty</th>

                                {{-- FIRST --}}
                                <th colspan="4" class="px-3 py-2 text-center text-xs font-bold text-blue-700 dark:text-blue-300 uppercase bg-blue-50 dark:bg-blue-900/30">
                                    First Piece Items
                                </th>
                                {{-- MIDDLE --}}
                                <th colspan="4" class="px-3 py-2 text-center text-xs font-bold text-indigo-700 dark:text-indigo-300 uppercase bg-indigo-50 dark:bg-indigo-900/30">
                                    Middle Piece Items
                                </th>
                                {{-- LAST --}}
                                <th colspan="4" class="px-3 py-2 text-center text-xs font-bold text-purple-700 dark:text-purple-300 uppercase bg-purple-50 dark:bg-purple-900/30">
                                    Last Piece Items
                                </th>
                                {{-- TOTAL --}}
                                <th colspan="3" class="px-3 py-2 text-center text-xs font-bold text-emerald-700 dark:text-emerald-300 uppercase bg-emerald-50 dark:bg-emerald-900/30">
                                    Total
                                </th>
                                {{-- PIC INFO --}}
                                <th colspan="2" class="px-3 py-2 text-center text-xs font-bold text-zinc-700 dark:text-zinc-300 uppercase bg-zinc-100 dark:bg-zinc-800/60">
                                    PIC INFO
                                </th>

                                <th rowspan="2" class="px-4 py-2 text-center text-xs font-medium text-zinc-500 uppercase sticky right-0 z-20 bg-zinc-50 dark:bg-zinc-800" style="min-width: 150px; box-shadow: inset 2px 0 0 0 rgb(212 212 216);">Actions</th>
                            </tr>

                            {{-- BARIS HEADER 2 --}}
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                {{-- FIRST --}}
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-emerald-600 uppercase bg-emerald-50/50 dark:bg-emerald-900/10">OK</th>
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-red-600 uppercase bg-red-50/50 dark:bg-red-900/10">NG</th>
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-amber-600 uppercase bg-amber-50/50 dark:bg-amber-900/10">Reject Rate %</th>
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-cyan-600 uppercase bg-cyan-50/50 dark:bg-cyan-900/10">Status</th>
                                {{-- MIDDLE --}}
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-emerald-600 uppercase bg-emerald-50/50 dark:bg-emerald-900/10">OK</th>
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-red-600 uppercase bg-red-50/50 dark:bg-red-900/10">NG</th>
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-amber-600 uppercase bg-amber-50/50 dark:bg-amber-900/10">Reject Rate %</th>
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-cyan-600 uppercase bg-cyan-50/50 dark:bg-cyan-900/10">Status</th>
                                {{-- LAST --}}
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-emerald-600 uppercase bg-emerald-50/50 dark:bg-emerald-900/10">OK</th>
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-red-600 uppercase bg-red-50/50 dark:bg-red-900/10">NG</th>
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-amber-600 uppercase bg-amber-50/50 dark:bg-amber-900/10">Reject Rate %</th>
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-cyan-600 uppercase bg-cyan-50/50 dark:bg-cyan-900/10">Status</th>
                                {{-- TOTAL --}}
                                <th class="px-3 py-2 text-center text-[10px] font-bold text-emerald-700 uppercase bg-emerald-100/50 dark:bg-emerald-900/20">OK</th>
                                <th class="px-3 py-2 text-center text-[10px] font-bold text-red-700 uppercase bg-red-100/50 dark:bg-red-900/20">NG</th>
                                <th class="px-3 py-2 text-center text-[10px] font-bold text-amber-700 uppercase bg-amber-100/50 dark:bg-amber-900/20">Reject Rate %</th>
                                {{-- PIC INFO --}}
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-zinc-600 uppercase bg-zinc-100/50 dark:bg-zinc-800/30">DATE</th>
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-zinc-600 uppercase bg-zinc-100/50 dark:bg-zinc-800/30">PIC</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($scans as $index => $scan)
                                @php
                                    $summary  = $this->buildSummary($scan);
                                    $isLocked = $scan->created_at && $scan->created_at->diffInHours(now()) >= 24;
                                @endphp
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 group" wire:key="scan-{{ $scan->id }}">

                                    {{-- STICKY LEFT --}}
                                    <td class="px-4 py-3 text-sm text-zinc-500 text-center sticky left-0 z-10 bg-white dark:bg-zinc-900 group-hover:bg-zinc-50 dark:group-hover:bg-zinc-800/50" style="min-width: 50px; width: 50px; box-shadow: inset -1px 0 0 0 rgb(228 228 231);">
                                        {{ $scans->firstItem() + $index }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-zinc-800 dark:text-white text-center sticky z-10 bg-white dark:bg-zinc-900 group-hover:bg-zinc-50 dark:group-hover:bg-zinc-800/50" style="left: 50px; min-width: 170px; box-shadow: inset -1px 0 0 0 rgb(228 228 231);">
                                        {{ $scan->customer->customer_name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-zinc-800 dark:text-white text-center sticky z-10 bg-white dark:bg-zinc-900 group-hover:bg-zinc-50 dark:group-hover:bg-zinc-800/50" style="left: 220px; min-width: 170px; box-shadow: inset -1px 0 0 0 rgb(228 228 231);">
                                        {{ $scan->model->model_name ?? '-' }}
                                    </td>

                                    {{-- PCB TYPE (sticky kanan dari sisi kiri) --}}
                                    <td class="px-3 py-3 text-center sticky z-10 bg-white dark:bg-zinc-900 group-hover:bg-zinc-50 dark:group-hover:bg-zinc-800/50" style="left: 390px; min-width: 100px; box-shadow: inset -2px 0 0 0 rgb(212 212 216);">
                                        @if($scan->pcb_type === 'SINGLE')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-violet-100 text-violet-700 dark:bg-violet-900/40 dark:text-violet-300">SINGLE</span>
                                        @elseif($scan->pcb_type === 'LH')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">LH</span>
                                        @elseif($scan->pcb_type === 'RH')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">RH</span>
                                        @else
                                            <span class="text-zinc-400 italic text-[10px]">-</span>
                                        @endif
                                    </td>

                                    {{-- SHIFT --}}
                                    <td class="px-3 py-3 text-sm text-zinc-600 text-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                                            {{ $scan->shift }}
                                        </span>
                                    </td>
                                    {{-- GROUP --}}
                                    <td class="px-3 py-3 text-sm text-zinc-600 text-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300">
                                            {{ $scan->group }}
                                        </span>
                                    </td>
                                    {{-- LINE --}}
                                    <td class="px-3 py-3 text-sm text-zinc-600 text-center">
                                        {{ $scan->masterLine->location->location_name ?? '-' }} - L{{ $scan->masterLine->line_number ?? '-' }}
                                    </td>
                                    {{-- LOT QTY --}}
                                    <td class="px-3 py-3 text-sm text-zinc-600 text-center font-mono font-semibold">{{ $scan->lot_qty }}</td>

                                    {{-- FIRST PIECE --}}
                                    <td class="px-3 py-3 text-center bg-blue-50/20 dark:bg-blue-900/5">
                                        <span class="inline-flex items-center justify-center min-w-[36px] px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300 font-bold text-xs">
                                            {{ $summary['first']['ok_qty'] }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-center bg-blue-50/20 dark:bg-blue-900/5">
                                        <span class="inline-flex items-center justify-center min-w-[36px] px-2 py-0.5 rounded-md bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300 font-bold text-xs">
                                            {{ $summary['first']['ng_qty'] }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-center bg-blue-50/20 dark:bg-blue-900/5">
                                        @php $rr = $summary['first']['reject_rate']; @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md font-bold text-xs
                                            {{ $rr >= 5 ? 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300' : ($rr > 0 ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300') }}">
                                            {{ $rr }}%
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-center bg-blue-50/20 dark:bg-blue-900/5">
                                        @if($summary['first']['status_running'])
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold
                                                {{ strtolower($summary['first']['status_running']) === 'running' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ strtolower($summary['first']['status_running']) === 'running' ? 'bg-emerald-500 animate-pulse' : 'bg-zinc-400' }}"></span>
                                                {{ $summary['first']['status_running'] }}
                                            </span>
                                        @else
                                            <span class="text-zinc-400 italic text-[10px]">-</span>
                                        @endif
                                    </td>

                                    {{-- MIDDLE PIECE --}}
                                    <td class="px-3 py-3 text-center bg-indigo-50/20 dark:bg-indigo-900/5">
                                        <span class="inline-flex items-center justify-center min-w-[36px] px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300 font-bold text-xs">
                                            {{ $summary['middle']['ok_qty'] }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-center bg-indigo-50/20 dark:bg-indigo-900/5">
                                        <span class="inline-flex items-center justify-center min-w-[36px] px-2 py-0.5 rounded-md bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300 font-bold text-xs">
                                            {{ $summary['middle']['ng_qty'] }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-center bg-indigo-50/20 dark:bg-indigo-900/5">
                                        @php $rr = $summary['middle']['reject_rate']; @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md font-bold text-xs
                                            {{ $rr >= 5 ? 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300' : ($rr > 0 ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300') }}">
                                            {{ $rr }}%
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-center bg-indigo-50/20 dark:bg-indigo-900/5">
                                        @if($summary['middle']['status_running'])
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold
                                                {{ strtolower($summary['middle']['status_running']) === 'running' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ strtolower($summary['middle']['status_running']) === 'running' ? 'bg-emerald-500 animate-pulse' : 'bg-zinc-400' }}"></span>
                                                {{ $summary['middle']['status_running'] }}
                                            </span>
                                        @else
                                            <span class="text-zinc-400 italic text-[10px]">-</span>
                                        @endif
                                    </td>

                                    {{-- LAST PIECE --}}
                                    <td class="px-3 py-3 text-center bg-purple-50/20 dark:bg-purple-900/5">
                                        <span class="inline-flex items-center justify-center min-w-[36px] px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300 font-bold text-xs">
                                            {{ $summary['last']['ok_qty'] }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-center bg-purple-50/20 dark:bg-purple-900/5">
                                        <span class="inline-flex items-center justify-center min-w-[36px] px-2 py-0.5 rounded-md bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300 font-bold text-xs">
                                            {{ $summary['last']['ng_qty'] }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-center bg-purple-50/20 dark:bg-purple-900/5">
                                        @php $rr = $summary['last']['reject_rate']; @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md font-bold text-xs
                                            {{ $rr >= 5 ? 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300' : ($rr > 0 ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300') }}">
                                            {{ $rr }}%
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-center bg-purple-50/20 dark:bg-purple-900/5">
                                        @if($summary['last']['status_running'])
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold
                                                {{ strtolower($summary['last']['status_running']) === 'running' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ strtolower($summary['last']['status_running']) === 'running' ? 'bg-emerald-500 animate-pulse' : 'bg-zinc-400' }}"></span>
                                                {{ $summary['last']['status_running'] }}
                                            </span>
                                        @else
                                            <span class="text-zinc-400 italic text-[10px]">-</span>
                                        @endif
                                    </td>

                                    {{-- TOTAL --}}
                                    <td class="px-3 py-3 text-center bg-emerald-50/50 dark:bg-emerald-900/10">
                                        <span class="inline-flex items-center justify-center min-w-[44px] px-2.5 py-1 rounded-md bg-emerald-500 text-white font-bold text-sm shadow-sm shadow-emerald-500/30">
                                            {{ $summary['total']['ok_qty'] }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-center bg-red-50/50 dark:bg-red-900/10">
                                        <span class="inline-flex items-center justify-center min-w-[44px] px-2.5 py-1 rounded-md bg-red-500 text-white font-bold text-sm shadow-sm shadow-red-500/30">
                                            {{ $summary['total']['ng_qty'] }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-center bg-amber-50/50 dark:bg-amber-900/10">
                                        @php $rr = $summary['total']['reject_rate']; @endphp
                                        <span class="inline-flex items-center justify-center min-w-[52px] px-2.5 py-1 rounded-md font-bold text-sm shadow-sm
                                            {{ $rr >= 5 ? 'bg-red-500 text-white shadow-red-500/30' : ($rr > 0 ? 'bg-amber-500 text-white shadow-amber-500/30' : 'bg-emerald-500 text-white shadow-emerald-500/30') }}">
                                            {{ $rr }}%
                                        </span>
                                    </td>

                                    {{-- PIC INFO --}}
                                    <td class="px-3 py-3 text-center bg-zinc-50/50 dark:bg-zinc-800/20">
                                        <div class="flex flex-col items-center gap-0.5">
                                            <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">
                                                {{ $scan->created_at?->format('d M Y') ?? '-' }}
                                            </span>
                                            <span class="text-[10px] text-zinc-500 dark:text-zinc-400 font-mono">
                                                {{ $scan->created_at?->format('H:i') ?? '' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-center bg-zinc-50/50 dark:bg-zinc-800/20">
                                        @if($scan->creator)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 text-[10px] font-semibold">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                                    <path d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z" />
                                                </svg>
                                                {{ $scan->creator->name ?? $scan->creator->username ?? '-' }}
                                            </span>
                                        @else
                                            <span class="text-zinc-400 italic text-[10px]">-</span>
                                        @endif
                                    </td>

                                    {{-- STICKY RIGHT: ACTIONS --}}
                                    <td class="px-4 py-3 text-center sticky right-0 z-10 bg-white dark:bg-zinc-900 group-hover:bg-zinc-50 dark:group-hover:bg-zinc-800/50" style="min-width: 150px; box-shadow: inset 2px 0 0 0 rgb(212 212 216);">
                                        <div class="flex items-center justify-center gap-1">
                                            @can('view scan xray')
                                                <flux:tooltip content="View" position="top">
                                                    <flux:button href="{{ route('qaqc.scan-xray.view', $scan->id) }}" wire:navigate
                                                        size="sm" icon="eye" variant="primary" color="blue" class="!p-2" />
                                                </flux:tooltip>
                                            @endcan

                                            @can('edit scan xray')
                                                @if(!$isLocked)
                                                    <flux:tooltip content="Edit" position="top">
                                                        <flux:button href="{{ route('qaqc.scan-xray.edit', $scan->id) }}" wire:navigate
                                                            size="sm" icon="pencil-square" variant="primary" color="yellow" class="!p-2" />
                                                    </flux:tooltip>
                                                @else
                                                    <flux:tooltip content="Tidak bisa edit (>24 jam)" position="top">
                                                        <flux:button size="sm" icon="lock-closed" variant="filled" color="zinc" class="!p-2" disabled />
                                                    </flux:tooltip>
                                                @endif
                                            @endcan

                                            @can('delete scan xray')
                                                @if(!$isLocked)
                                                    <flux:tooltip content="Delete" position="top">
                                                        <flux:button wire:click="confirmDelete({{ $scan->id }})"
                                                            size="sm" icon="trash" variant="primary" color="red" class="!p-2" />
                                                    </flux:tooltip>
                                                @else
                                                    <flux:tooltip content="Tidak bisa hapus (>24 jam)" position="top">
                                                        <flux:button size="sm" icon="lock-closed" variant="filled" color="zinc" class="!p-2" disabled />
                                                    </flux:tooltip>
                                                @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if($scans->hasPages())
                    <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700 flex justify-center">
                        {{ $scans->links() }}
                    </div>
                @endif
            @else
                {{-- EMPTY STATE --}}
                <div class="py-12">
                    <div class="flex flex-col items-center gap-3 text-center">
                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                            @if($this->hasActiveFilter())
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-zinc-400 dark:text-zinc-500">
                                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-zinc-400 dark:text-zinc-500">
                                    <path fill-rule="evenodd" d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 18.375V5.625ZM21 9.375A.375.375 0 0 0 20.625 9h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5ZM10.875 18.75a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5Z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-zinc-900 dark:text-white mb-1">
                                {{ $this->hasActiveFilter() ? 'Tidak Ada Data Ditemukan' : 'Belum Ada Data Scan X-Ray' }}
                            </h3>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-md">
                                {{ $this->hasActiveFilter() ? 'Coba ubah atau reset filter untuk melihat data lainnya.' : 'Mulai dengan membuat data scan x-ray baru.' }}
                            </p>
                        </div>

                        @if($this->hasActiveFilter())
                            <button type="button" wire:click="resetFilters"
                                class="mt-2 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-white bg-gradient-to-r from-orange-400 to-orange-600 hover:from-orange-500 hover:to-orange-700 rounded-lg shadow-sm hover:shadow-md transition-all">
                                Reset Filter
                            </button>
                        @else
                            @can('create scan xray')
                                <flux:button href="{{ route('qaqc.scan-xray.create') }}" wire:navigate
                                    variant="primary" icon="plus" class="mt-2 bg-blue-600 hover:bg-blue-700">
                                    Add New Scan
                                </flux:button>
                            @endcan
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </flux:card>

    {{-- DELETE MODAL --}}
    <div x-data="{ open: false }"
        x-show="open"
        x-on:open-modal-delete.window="open = true"
        x-on:close-modal-delete.window="open = false"
        x-cloak @keydown.escape.window="open = false">
        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold mb-2 text-center">Delete Scan X-Ray</h3>
                <p class="text-center text-sm text-zinc-600 dark:text-zinc-400 mb-4">
                    Are you sure you want to delete this record?
                </p>
                <div class="flex justify-center gap-3">
                    <button @click="open = false" class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800">Cancel</button>
                    <button wire:click="delete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Yes, Delete</button>
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

    <style>[x-cloak]{display:none !important;}</style>
</div>