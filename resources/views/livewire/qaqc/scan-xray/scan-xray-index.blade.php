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
                    wire:click="openPicXrayPicker">
                    Add New Scan
                </flux:button>
            @endcan
        </div>
    </div>

    {{-- FILTER BAR --}}
    <div x-data="{ open: true }"
        class="rounded-xl border border-orange-300 dark:border-orange-700 bg-white dark:bg-zinc-900 shadow-sm overflow-hidden">

        <button type="button"
            x-on:click="open = !open"
            class="w-full px-4 py-3 flex items-center justify-between cursor-pointer bg-gradient-to-r from-orange-400 to-orange-600 hover:from-orange-500 hover:to-orange-700 dark:from-orange-500 dark:to-orange-700 dark:hover:from-orange-600 dark:hover:to-orange-800 transition-all">
            <div class="flex items-center gap-2">
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
                <div>
                    <label class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1 block">Search</label>
                    <flux:input wire:model.live.debounce.300ms="search"
                        placeholder="Search customer / model / shift / group / PCB type..."
                        icon="magnifying-glass" clearable />
                </div>

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

    {{-- TABLE --}}
    <flux:card class="p-0 shadow-lg flex flex-col overflow-hidden">
        <div class="relative px-6 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div class="text-base font-bold text-white">Scan X-Ray List</div>

                <div class="flex items-center gap-2">
                    <flux:tooltip content="{{ $isStacked ? 'Unstack kolom (scroll bebas)' : 'Stack kolom (sticky)' }}" position="top">
                        <button type="button"
                            wire:click="toggleStack"
                            wire:loading.attr="disabled"
                            wire:target="toggleStack"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer
                                {{ $isStacked
                                    ? 'bg-white/20 border border-white/30 text-white hover:bg-white/30'
                                    : 'bg-white text-blue-700 hover:bg-blue-50 border border-white/40' }}">

                            @if($isStacked)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M15 3.75a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0V5.56l-3.97 3.97a.75.75 0 1 1-1.06-1.06l3.97-3.97h-2.69a.75.75 0 0 1-.75-.75Zm-12 0A.75.75 0 0 1 3.75 3h4.5a.75.75 0 0 1 0 1.5H5.56l3.97 3.97a.75.75 0 0 1-1.06 1.06L4.5 5.56v2.69a.75.75 0 0 1-1.5 0v-4.5Zm11.47 11.78a.75.75 0 1 1 1.06-1.06l3.97 3.97v-2.69a.75.75 0 0 1 1.5 0v4.5a.75.75 0 0 1-.75.75h-4.5a.75.75 0 0 1 0-1.5h2.69l-3.97-3.97Zm-4.94-1.06a.75.75 0 0 1 0 1.06L5.56 19.5h2.69a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 1 1.5 0v2.69l3.97-3.97a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                                </svg>
                                <span>Unstack</span>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M3.22 3.22a.75.75 0 0 1 1.06 0l3.97 3.97V4.5a.75.75 0 0 1 1.5 0V9a.75.75 0 0 1-.75.75H4.5a.75.75 0 0 1 0-1.5h2.69L3.22 4.28a.75.75 0 0 1 0-1.06Zm17.56 0a.75.75 0 0 1 0 1.06l-3.97 3.97h2.69a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75V4.5a.75.75 0 0 1 1.5 0v2.69l3.97-3.97a.75.75 0 0 1 1.06 0ZM3.75 15a.75.75 0 0 1 .75-.75H9a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-2.69l-3.97 3.97a.75.75 0 0 1-1.06-1.06l3.97-3.97H4.5a.75.75 0 0 1-.75-.75Zm10.5 0a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-2.69l3.97 3.97a.75.75 0 1 1-1.06 1.06l-3.97-3.97v2.69a.75.75 0 0 1-1.5 0V15Z" clip-rule="evenodd" />
                                </svg>
                                <span>Stack</span>
                            @endif
                        </button>
                    </flux:tooltip>

                    <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-white/20 border border-white/30 text-white text-xs font-semibold">
                        {{ $scans->total() }} total
                    </span>
                </div>
            </div>
        </div>

        <div class="p-6">
            @if($scans->count() > 0)
                <div class="overflow-x-auto {{ $isStacked ? '' : 'unstacked-mode' }}">
                    <table class="w-full" style="min-width: 2400px; white-space: nowrap; border-collapse: separate; border-spacing: 0;">
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

                                {{-- FIRST (3 kolom) --}}
                                <th colspan="3" class="px-3 py-2 text-center text-xs font-bold text-blue-700 dark:text-blue-300 uppercase bg-blue-50 dark:bg-blue-900/30">
                                    First Piece Items
                                </th>
                                {{-- SECOND FIRST (1 kolom) --}}
                                <th colspan="1" class="px-3 py-2 text-center text-xs font-bold text-cyan-700 dark:text-cyan-300 uppercase bg-cyan-50 dark:bg-cyan-900/30">
                                    Second First
                                </th>
                                {{-- MIDDLE (3 kolom) --}}
                                <th colspan="3" class="px-3 py-2 text-center text-xs font-bold text-indigo-700 dark:text-indigo-300 uppercase bg-indigo-50 dark:bg-indigo-900/30">
                                    Middle Piece Items
                                </th>
                                {{-- SECOND MIDDLE (1 kolom) --}}
                                <th colspan="1" class="px-3 py-2 text-center text-xs font-bold text-cyan-700 dark:text-cyan-300 uppercase bg-cyan-50 dark:bg-cyan-900/30">
                                    Second Middle
                                </th>
                                {{-- LAST (3 kolom) --}}
                                <th colspan="3" class="px-3 py-2 text-center text-xs font-bold text-purple-700 dark:text-purple-300 uppercase bg-purple-50 dark:bg-purple-900/30">
                                    Last Piece Items
                                </th>
                                {{-- SECOND LAST (1 kolom) --}}
                                <th colspan="1" class="px-3 py-2 text-center text-xs font-bold text-cyan-700 dark:text-cyan-300 uppercase bg-cyan-50 dark:bg-cyan-900/30">
                                    Second Last
                                </th>
                                {{-- ✅ STATUS RUNNING GLOBAL (1 kolom) --}}
                                <th colspan="1" class="px-3 py-2 text-center text-xs font-bold text-zinc-700 dark:text-zinc-300 uppercase bg-zinc-100 dark:bg-zinc-800/60">
                                    Status Running
                                </th>
                                {{-- TOTAL (3 kolom) --}}
                                <th colspan="3" class="px-3 py-2 text-center text-xs font-bold text-emerald-700 dark:text-emerald-300 uppercase bg-emerald-50 dark:bg-emerald-900/30">
                                    Total
                                </th>
                                {{-- PIC (3 kolom) --}}
                                <th colspan="3" class="px-3 py-2 text-center text-xs font-bold text-zinc-700 dark:text-zinc-300 uppercase bg-zinc-100 dark:bg-zinc-800/60">
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
                                {{-- SECOND FIRST --}}
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-cyan-700 uppercase bg-cyan-50/50 dark:bg-cyan-900/10">QTY</th>
                                {{-- MIDDLE --}}
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-emerald-600 uppercase bg-emerald-50/50 dark:bg-emerald-900/10">OK</th>
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-red-600 uppercase bg-red-50/50 dark:bg-red-900/10">NG</th>
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-amber-600 uppercase bg-amber-50/50 dark:bg-amber-900/10">Reject Rate %</th>
                                {{-- SECOND MIDDLE --}}
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-cyan-700 uppercase bg-cyan-50/50 dark:bg-cyan-900/10">QTY</th>
                                {{-- LAST --}}
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-emerald-600 uppercase bg-emerald-50/50 dark:bg-emerald-900/10">OK</th>
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-red-600 uppercase bg-red-50/50 dark:bg-red-900/10">NG</th>
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-amber-600 uppercase bg-amber-50/50 dark:bg-amber-900/10">Reject Rate %</th>
                                {{-- SECOND LAST --}}
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-cyan-700 uppercase bg-cyan-50/50 dark:bg-cyan-900/10">QTY</th>
                                {{-- ✅ STATUS RUNNING GLOBAL --}}
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-zinc-600 uppercase bg-zinc-100/50 dark:bg-zinc-800/30">Status</th>
                                {{-- TOTAL --}}
                                <th class="px-3 py-2 text-center text-[10px] font-bold text-emerald-700 uppercase bg-emerald-100/50 dark:bg-emerald-900/20">OK</th>
                                <th class="px-3 py-2 text-center text-[10px] font-bold text-red-700 uppercase bg-red-100/50 dark:bg-red-900/20">NG</th>
                                <th class="px-3 py-2 text-center text-[10px] font-bold text-amber-700 uppercase bg-amber-100/50 dark:bg-amber-900/20">Reject Rate %</th>
                                {{-- PIC --}}
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-zinc-600 uppercase bg-zinc-100/50 dark:bg-zinc-800/30">DATE</th>
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-zinc-600 uppercase bg-zinc-100/50 dark:bg-zinc-800/30">PIC</th>
                                <th class="px-3 py-2 text-center text-[10px] font-semibold text-blue-600 dark:text-blue-400 uppercase bg-blue-100/50 dark:bg-blue-900/20">PIC X-RAY</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($scans as $index => $scan)
                                @php
                                    $summary          = $this->buildSummary($scan);
                                    $isLocked         = $scan->created_at && $scan->created_at->diffInHours(now()) >= 24;
                                    $isCompleted      = $scan->phase === 'completed';
                                    $needsNgDetail    = $scan->hasIncompleteNgDetail();
                                    $incompleteCount  = $scan->countIncompleteNgDetail();
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

                                    {{-- PCB TYPE --}}
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

                                    {{-- FIRST --}}
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

                                    {{-- SECOND FIRST --}}
                                    <td class="px-3 py-3 text-center bg-cyan-50/20 dark:bg-cyan-900/5">
                                        <span class="inline-flex items-center justify-center min-w-[36px] px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300 font-bold text-xs">
                                            {{ $summary['second_first']['qty'] }}
                                        </span>
                                    </td>

                                    {{-- MIDDLE --}}
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

                                    {{-- SECOND MIDDLE --}}
                                    <td class="px-3 py-3 text-center bg-cyan-50/20 dark:bg-cyan-900/5">
                                        <span class="inline-flex items-center justify-center min-w-[36px] px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300 font-bold text-xs">
                                            {{ $summary['second_middle']['qty'] }}
                                        </span>
                                    </td>

                                    {{-- LAST --}}
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

                                    {{-- SECOND LAST --}}
                                    <td class="px-3 py-3 text-center bg-cyan-50/20 dark:bg-cyan-900/5">
                                        <span class="inline-flex items-center justify-center min-w-[36px] px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300 font-bold text-xs">
                                            {{ $summary['second_last']['qty'] }}
                                        </span>
                                    </td>

                                    {{-- ✅ STATUS RUNNING GLOBAL (1 kolom saja) --}}
                                    <td class="px-3 py-3 text-center bg-zinc-50/50 dark:bg-zinc-800/20">
                                        @if($scan->status_running)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold
                                                {{ strtolower($scan->status_running) === 'running' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ strtolower($scan->status_running) === 'running' ? 'bg-emerald-500 animate-pulse' : 'bg-zinc-400' }}"></span>
                                                {{ $scan->status_running }}
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
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="inline-flex items-center justify-center min-w-[44px] px-2.5 py-1 rounded-md bg-red-500 text-white font-bold text-sm shadow-sm shadow-red-500/30">
                                                {{ $summary['total']['ng_qty'] }}
                                            </span>
                                            @if($needsNgDetail)
                                                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[9px] font-bold
                                                    bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300
                                                    ring-1 ring-amber-300 dark:ring-amber-700 animate-pulse"
                                                    title="NG Detail belum lengkap — klik Edit untuk melengkapi">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3 flex-shrink-0">
                                                        <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                                    </svg>
                                                    Belum lengkap
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-center bg-amber-50/50 dark:bg-amber-900/10">
                                        @php $rr = $summary['total']['reject_rate']; @endphp
                                        <span class="inline-flex items-center justify-center min-w-[52px] px-2.5 py-1 rounded-md font-bold text-sm shadow-sm
                                            {{ $rr >= 5 ? 'bg-red-500 text-white shadow-red-500/30' : ($rr > 0 ? 'bg-amber-500 text-white shadow-amber-500/30' : 'bg-emerald-500 text-white shadow-emerald-500/30') }}">
                                            {{ $rr }}%
                                        </span>
                                    </td>

                                    {{-- PIC --}}
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
                                    {{-- PIC X-RAY --}}
                                    <td class="px-3 py-3 text-center bg-blue-50/30 dark:bg-blue-900/10">
                                        @php
                                            $picXrayName = null;
                                            if ($scan->pic_xray) {
                                                if (is_numeric($scan->pic_xray)) {
                                                    $emp = \App\Models\HR\Employee::find($scan->pic_xray);
                                                    $picXrayName = $emp?->name;
                                                } else {
                                                    $picXrayName = $scan->pic_xray;
                                                }
                                            }
                                        @endphp

                                        @if($picXrayName)
                                            <div class="flex flex-col items-center gap-0.5">
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 text-[10px] font-semibold">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                                        <path d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z" />
                                                    </svg>
                                                    {{ $picXrayName }}
                                                </span>
                                            </div>
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
                                                @php
                                                    $activeReq   = $scan->activeEditRequest;
                                                    $hasApproval = $activeReq && $activeReq->isApproved();
                                                    $hasPending  = $activeReq && $activeReq->isPending();
                                                    $canEditNormal   = !$isLocked && (!$isCompleted || $needsNgDetail);
                                                    $canEditApproved = !$isLocked && $hasApproval;
                                                @endphp

                                                @if($canEditNormal)
                                                    <div class="relative inline-flex">
                                                        <flux:tooltip content="{{ $needsNgDetail ? 'Lengkapi NG Detail (' . $incompleteCount . ' group belum lengkap)' : 'Edit' }}" position="top">
                                                            <flux:button href="{{ route('qaqc.scan-xray.edit', $scan->id) }}" wire:navigate
                                                                size="sm" icon="pencil-square" variant="primary" color="yellow" class="!p-2" />
                                                        </flux:tooltip>

                                                        @if($needsNgDetail)
                                                            <span class="absolute -top-1 -right-1 flex items-center justify-center
                                                                w-4 h-4 rounded-full bg-amber-500 text-white
                                                                ring-2 ring-white dark:ring-zinc-900 shadow-md
                                                                pointer-events-none z-10">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-2.5 h-2.5">
                                                                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                                                </svg>
                                                            </span>
                                                        @endif
                                                    </div>

                                                @elseif($canEditApproved)
                                                    <div class="relative inline-flex">
                                                        <flux:tooltip content="Edit (Approved until {{ $activeReq->expires_at?->format('d/m H:i') ?? 'no expiry' }})" position="top">
                                                            <flux:button href="{{ route('qaqc.scan-xray.edit', $scan->id) }}" wire:navigate
                                                                size="sm" icon="pencil-square" variant="primary" color="emerald" class="!p-2" />
                                                        </flux:tooltip>
                                                        <span class="absolute -top-1 -right-1 flex items-center justify-center
                                                            w-4 h-4 rounded-full bg-emerald-500 text-white
                                                            ring-2 ring-white dark:ring-zinc-900 shadow-md
                                                            pointer-events-none z-10">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-2.5 h-2.5">
                                                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                                            </svg>
                                                        </span>
                                                    </div>

                                                @elseif($hasPending)
                                                    <flux:tooltip content="Menunggu approval edit" position="top">
                                                        <flux:button size="sm" icon="clock" variant="filled" color="amber" class="!p-2" disabled />
                                                    </flux:tooltip>

                                                @elseif($isLocked)
                                                    <flux:tooltip content="Tidak bisa edit (>24 jam)" position="top">
                                                        <flux:button size="sm" icon="lock-closed" variant="filled" color="zinc" class="!p-2" disabled />
                                                    </flux:tooltip>

                                                @elseif($isCompleted && !$hasApproval && !$hasPending)
                                                    {{-- ✅ Tombol Request Edit: Alpine murni --}}
                                                    <flux:tooltip content="Ajukan Request Edit" position="top">
                                                        <flux:button wire:click="$set('editRequestScanId', {{ $scan->id }})"
                                                            x-on:click="$dispatch('open-modal', 'edit-request-modal')"
                                                            size="sm" icon="lock-open" variant="primary" color="amber" class="!p-2" />
                                                    </flux:tooltip>
                                                @endif
                                            @endcan

                                            @can('delete scan xray')
                                                @if(!$isLocked && !$isCompleted)
                                                    <flux:tooltip content="Delete" position="top">
                                                        <flux:button wire:click="confirmDelete({{ $scan->id }})"
                                                            size="sm" icon="trash" variant="primary" color="red" class="!p-2" />
                                                    </flux:tooltip>
                                                @elseif($isCompleted)
                                                    <flux:tooltip content="Data sudah selesai (completed)" position="top">
                                                        <flux:button size="sm" icon="check-badge" variant="filled" color="emerald" class="!p-2" disabled />
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

                @if($scans->hasPages())
                    <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">

                        {{-- Info range data --}}
                        <div class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 text-center lg:text-left whitespace-nowrap">
                            Showing
                            <strong class="text-zinc-700 dark:text-zinc-200">{{ $scans->firstItem() ?? 0 }}</strong>
                            -
                            <strong class="text-zinc-700 dark:text-zinc-200">{{ $scans->lastItem() ?? 0 }}</strong>
                            of
                            <strong class="text-zinc-700 dark:text-zinc-200">{{ $scans->total() }}</strong>
                            data
                        </div>

                        {{-- Tombol navigasi --}}
                        <div class="flex items-center justify-center lg:justify-end gap-1 flex-wrap">

                            {{-- First --}}
                            <button type="button" wire:click="gotoPage(1)" @disabled($scans->onFirstPage())
                                class="inline-flex items-center justify-center w-8 h-8 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600
                                    hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300
                                    disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
                                title="First page">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M18.72 4.72a.75.75 0 0 1 0 1.06L12.56 12l6.16 6.22a.75.75 0 1 1-1.06 1.06l-6.25-6.25a1.5 1.5 0 0 1 0-2.06l6.25-6.25a.75.75 0 0 1 1.06 0Zm-6.44 0a.75.75 0 0 1 0 1.06L6.12 12l6.16 6.22a.75.75 0 1 1-1.06 1.06l-6.25-6.25a1.5 1.5 0 0 1 0-2.06l6.25-6.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            {{-- Prev --}}
                            <button type="button" wire:click="previousPage" @disabled($scans->onFirstPage())
                                class="inline-flex items-center justify-center gap-1 px-3 h-8 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600
                                    hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300
                                    disabled:opacity-40 disabled:cursor-not-allowed transition-colors whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                    <path fill-rule="evenodd" d="M15.53 4.72a.75.75 0 0 1 0 1.06L9.31 12l6.22 6.22a.75.75 0 1 1-1.06 1.06l-6.25-6.25a1.5 1.5 0 0 1 0-2.06l6.25-6.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                                </svg>
                                <span class="hidden sm:inline">Prev</span>
                            </button>

                            {{-- Page numbers --}}
                            @php
                                $current = $scans->currentPage();
                                $last    = $scans->lastPage();
                                $pages   = [];

                                $showMax = 7;
                                $start = max(2, $current - 2);
                                $end   = min($last - 1, $current + 2);

                                if ($current <= 4) {
                                    $start = 2;
                                    $end   = min($last - 1, $showMax - 1);
                                } elseif ($current >= $last - 3) {
                                    $start = max(2, $last - ($showMax - 2));
                                    $end   = $last - 1;
                                }
                            @endphp

                            {{-- Halaman pertama --}}
                            <button type="button" wire:click="gotoPage(1)"
                                class="min-w-[34px] h-8 px-2 text-sm rounded-lg border font-bold transition-colors
                                    {{ $current === 1
                                        ? 'bg-blue-600 border-blue-600 text-white shadow-sm'
                                        : 'border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300' }}">
                                1
                            </button>

                            {{-- Ellipsis kiri --}}
                            @if($start > 2)
                                <span class="px-1 text-zinc-400 dark:text-zinc-500 select-none">…</span>
                            @endif

                            {{-- Halaman tengah --}}
                            @for($i = $start; $i <= $end; $i++)
                                <button type="button" wire:click="gotoPage({{ $i }})"
                                    class="min-w-[34px] h-8 px-2 text-sm rounded-lg border font-bold transition-colors
                                        {{ $current === $i
                                            ? 'bg-blue-600 border-blue-600 text-white shadow-sm'
                                            : 'border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300' }}">
                                    {{ $i }}
                                </button>
                            @endfor

                            {{-- Ellipsis kanan --}}
                            @if($end < $last - 1)
                                <span class="px-1 text-zinc-400 dark:text-zinc-500 select-none">…</span>
                            @endif

                            {{-- Halaman terakhir --}}
                            @if($last > 1)
                                <button type="button" wire:click="gotoPage({{ $last }})"
                                    class="min-w-[34px] h-8 px-2 text-sm rounded-lg border font-bold transition-colors
                                        {{ $current === $last
                                            ? 'bg-blue-600 border-blue-600 text-white shadow-sm'
                                            : 'border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300' }}">
                                    {{ $last }}
                                </button>
                            @endif

                            {{-- Next --}}
                            <button type="button" wire:click="nextPage" @disabled(!$scans->hasMorePages())
                                class="inline-flex items-center justify-center gap-1 px-3 h-8 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600
                                    hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300
                                    disabled:opacity-40 disabled:cursor-not-allowed transition-colors whitespace-nowrap">
                                <span class="hidden sm:inline">Next</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                    <path fill-rule="evenodd" d="M8.47 4.72a.75.75 0 0 1 1.06 0l6.25 6.25a1.5 1.5 0 0 1 0 2.06l-6.25 6.25a.75.75 0 1 1-1.06-1.06L14.69 12 8.47 5.78a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            {{-- Last --}}
                            <button type="button" wire:click="gotoPage({{ $scans->lastPage() }})" @disabled(!$scans->hasMorePages())
                                class="inline-flex items-center justify-center w-8 h-8 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600
                                    hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300
                                    disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
                                title="Last page">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M5.28 4.72a.75.75 0 0 0 0 1.06L11.44 12l-6.16 6.22a.75.75 0 1 0 1.06 1.06l6.25-6.25a1.5 1.5 0 0 0 0-2.06L6.34 4.72a.75.75 0 0 0-1.06 0Zm6.44 0a.75.75 0 0 0 0 1.06L17.88 12l-6.16 6.22a.75.75 0 1 0 1.06 1.06l6.25-6.25a1.5 1.5 0 0 0 0-2.06L12.78 4.72a.75.75 0 0 0-1.06 0Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
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
                                <flux:button wire:click="openPicXrayPicker"
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

    {{-- PIC X-RAY MODAL (sebelum create) --}}
    @can('create scan xray')
    <div x-data="{ open: @entangle('openPicXrayModal') }"
        x-show="open"
        x-cloak
        @keydown.escape.window="$wire.closePicXrayPicker()">

        {{-- BACKDROP --}}
        <div class="fixed inset-0 bg-black/50 z-40" @click="$wire.closePicXrayPicker()"></div>

        {{-- PANEL --}}
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-lg
                        flex flex-col overflow-hidden"
                style="max-height: calc(100vh - 2rem);">

                {{-- HEADER (fixed) --}}
                <div class="flex-shrink-0 px-6 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 relative">
                    <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-white/10"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <div class="text-[10px] text-white/80 uppercase tracking-wider font-semibold">Sebelum Create</div>
                            <div class="text-lg font-bold text-white">Pilih PIC X-Ray</div>
                        </div>
                        <button type="button" wire:click="closePicXrayPicker"
                            class="w-8 h-8 rounded-lg bg-white/20 hover:bg-white/30 text-white flex items-center justify-center font-bold">
                            ✕
                        </button>
                    </div>
                </div>

                {{-- BODY (scrollable) --}}
                <div class="flex-1 min-h-0 overflow-y-auto px-6 py-4 space-y-4">

                    {{-- SEARCH --}}
                    <div>
                        <label class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1 block">
                            Cari Nama PIC
                        </label>
                        <flux:input
                            wire:model.live.debounce.300ms="picXraySearch"
                            placeholder="Ketik nama PIC X-Ray..."
                            icon="magnifying-glass"
                            clearable />
                    </div>

                    {{-- LIST --}}
                    @php $picList = $this->getPicXrayList(); @endphp

                    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                        <table class="w-full text-sm">
                            <thead class="bg-zinc-100 dark:bg-zinc-800">
                                <tr>
                                    <th class="px-4 py-2 text-left text-[10px] uppercase font-semibold text-zinc-500 w-28">NIK</th>
                                    <th class="px-4 py-2 text-left text-[10px] uppercase font-semibold text-zinc-500">Nama</th>
                                    <th class="px-4 py-2 text-center text-[10px] uppercase font-semibold text-zinc-500 w-24">Pilih</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                @forelse($picList as $emp)
                                    @php $isSelected = $selectedPicXray === $emp->id; @endphp
                                    <tr wire:key="pic-xray-{{ $emp->id }}"
                                        class="cursor-pointer transition
                                            {{ $isSelected
                                                ? 'bg-blue-50 dark:bg-blue-900/20'
                                                : 'hover:bg-zinc-50 dark:hover:bg-zinc-800/50' }}"
                                        wire:click="selectPicXray({{ $emp->id }})">
                                        <td class="px-4 py-2.5 font-mono text-xs font-semibold text-zinc-600 dark:text-zinc-400">
                                            {{ $emp->nik ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2.5 font-semibold text-zinc-800 dark:text-zinc-100">
                                            {{ $emp->name }}
                                        </td>
                                        <td class="px-4 py-2.5 text-center">
                                            @if($isSelected)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-blue-600 text-white text-[10px] font-bold">
                                                    ✓ Dipilih
                                                </span>
                                            @else
                                                <button type="button"
                                                    wire:click.stop="selectPicXray({{ $emp->id }})"
                                                    class="px-3 py-1 text-[10px] bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded-md hover:border-blue-400 hover:text-blue-600 font-semibold">
                                                    Pilih
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-8 text-center text-zinc-500 text-xs">
                                            Tidak ada PIC QA/QC ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- PAGINATION --}}
                        @if($picList->hasPages())
                            <div class="px-4 py-2 border-t border-zinc-200 dark:border-zinc-700 flex justify-between items-center bg-zinc-50 dark:bg-zinc-800/50">
                                <span class="text-[10px] text-zinc-500 font-semibold">
                                    {{ $picList->firstItem() ?? 0 }} - {{ $picList->lastItem() ?? 0 }} of {{ $picList->total() }}
                                </span>
                                <div class="flex gap-1">
                                    @if(!$picList->onFirstPage())
                                        <button type="button" wire:click="setPicXrayPage({{ $picList->currentPage() - 1 }})"
                                            class="px-2 py-1 text-[10px] rounded bg-white dark:bg-zinc-800 border font-semibold">Prev</button>
                                    @endif
                                    <span class="px-2 py-1 text-[10px] font-semibold">
                                        {{ $picList->currentPage() }} / {{ $picList->lastPage() }}
                                    </span>
                                    @if($picList->hasMorePages())
                                        <button type="button" wire:click="setPicXrayPage({{ $picList->currentPage() + 1 }})"
                                            class="px-2 py-1 text-[10px] rounded bg-white dark:bg-zinc-800 border font-semibold">Next</button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="text-sm font-bold {{ $selectedPicXray ? 'text-blue-700 dark:text-blue-300' : 'text-zinc-400 italic' }}">
                        @if($selectedPicXray)
                            @php $sel = \App\Models\HR\Employee::find($selectedPicXray); @endphp
                            {{ $sel->name ?? 'ID: ' . $selectedPicXray }}
                            @if($sel?->nik)
                                <span class="text-[10px] font-mono text-zinc-500 dark:text-zinc-400 ml-1">({{ $sel->nik }})</span>
                            @endif
                        @else
                            Belum memilih PIC
                        @endif
                    </div>
                </div>

                {{-- FOOTER (fixed) --}}
                <div class="flex-shrink-0 px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-2">
                    <flux:button type="button" wire:click="closePicXrayPicker" variant="filled">
                        Batal
                    </flux:button>
                    <flux:button type="button"
                        wire:click="proceedToCreate"
                        variant="primary"
                        icon="arrow-right"
                        class="bg-blue-600 hover:bg-blue-700"
                        :disabled="!$selectedPicXray">
                        Lanjut ke Form
                    </flux:button>
                </div>
            </div>
        </div>
    </div>
    @endcan

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

    <style>
        [x-cloak]{display:none !important;}

        .unstacked-mode th.sticky,
        .unstacked-mode td.sticky {
            position: static !important;
            left: auto !important;
            right: auto !important;
            box-shadow: none !important;
            z-index: auto !important;
        }

        .unstacked-mode thead th[style*="box-shadow"],
        .unstacked-mode tbody td[style*="box-shadow"] {
            box-shadow: none !important;
        }
    </style>

    {{-- MODAL REQUEST EDIT — Alpine murni, tidak bergantung pada Livewire --}}
    @can('edit scan xray')
    <div x-data="{ open: false }"
        x-show="open"
        @open-modal.window="if ($event.detail === 'edit-request-modal' || $event.detail?.[0] === 'edit-request-modal') open = true"
        @edit-request-submitted.window="open = false"
        x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-lg">

                {{-- HEADER --}}
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                    <h2 class="text-lg font-bold">Request Edit Scan X-Ray</h2>
                    <button type="button" @click="open = false; $wire.resetEditRequest()" class="text-zinc-400 hover:text-zinc-600 text-xl">✕</button>
                </div>

                {{-- BODY --}}
                <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">

                    <div class="rounded-lg border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-900/20 p-3 text-xs text-amber-800 dark:text-amber-200">
                        Pilih group yang mau diedit. Setelah di-approve, Anda bisa edit dalam 24 jam.
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Pilih Group <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach(\App\Models\QAQC\ScanXray\ScanXrayEditRequest::GROUPS as $groupKey => $groupLabel)
                                <label class="flex items-center gap-2 px-3 py-2 rounded-lg border cursor-pointer
                                    {{ in_array($groupKey, $editRequestGroups) ? 'border-amber-400 bg-amber-50 dark:bg-amber-900/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                    <input type="checkbox"
                                        value="{{ $groupKey }}"
                                        wire:model.live="editRequestGroups"
                                        class="rounded border-zinc-300 text-amber-600 focus:ring-amber-500" />
                                    <span class="text-xs font-semibold">{{ $groupLabel }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('editRequestGroups') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        @error('editRequestGroups.*') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Alasan <span class="text-red-500">*</span>
                        </label>
                        <flux:textarea wire:model="editRequestReason" rows="3"
                            placeholder="Kenapa perlu edit... (wajib diisi)" />
                        @error('editRequestReason')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-2">
                    <button type="button" @click="open = false; $wire.resetEditRequest()"
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800">
                        Cancel
                    </button>
                    <button type="button" wire:click="submitEditRequest"
                            x-bind:disabled="!$wire.editRequestReason || $wire.editRequestReason.length < 5 || $wire.editRequestGroups.length === 0"
                            x-bind:class="{ 'opacity-50 cursor-not-allowed': !$wire.editRequestReason || $wire.editRequestReason.length < 5 || $wire.editRequestGroups.length === 0 }"
                            class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700"
                            wire:loading.attr="disabled" wire:target="submitEditRequest">
                        <span wire:loading.remove wire:target="submitEditRequest">Kirim Request</span>
                        <span wire:loading wire:target="submitEditRequest">Mengirim...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endcan
</div>