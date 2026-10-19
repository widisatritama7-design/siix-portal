@props([
    'key'        => 'second_first_items',
    'label'      => 'Second Piece',
    'items'      => [],
    'readonly'   => false,
    'activeSide' => null,
    'minRows'    => 3,
])

@php
    $pcbLabels = [
        'pcb_a'       => 'PCB A',
        'pcb_b'       => 'PCB B',
        'pcb_c'       => 'PCB C',
        'pcb_circuit' => 'PCB Circuit',
    ];

    $pcbCols = array_keys($pcbLabels);

    $sideMeta = [
        'side_single' => ['label' => 'Side SINGLE', 'class' => 'from-violet-500 to-purple-600'],
        'side_lh'     => ['label' => 'Side LH',     'class' => 'from-blue-500 to-blue-600'],
        'side_rh'     => ['label' => 'Side RH',     'class' => 'from-emerald-500 to-emerald-600'],
    ];

    $statusRunning = $items['status_running'] ?? null;
    $side = $activeSide;
    $meta = $side ? ($sideMeta[$side] ?? null) : null;

    $rowErrors = [];
    if (!$readonly && $side) {
        try { $rowErrors = $this->getGroupRowErrors($key); }
        catch (\Throwable $e) { $rowErrors = []; }
    }

    $emptyRowsCount = 0;
    if (!$readonly && $side) {
        $sideData = $items[$side] ?? [];
        $maxRows = 0;
        foreach ($pcbCols as $c) {
            $maxRows = max($maxRows, count($sideData[$c] ?? []));
        }
        for ($i = 0; $i < $maxRows; $i++) {
            $hasAnyInRow = false;
            foreach ($pcbCols as $c) {
                if (!empty($sideData[$c][$i] ?? null)) $hasAnyInRow = true;
            }
            if (!$hasAnyInRow) $emptyRowsCount++;
        }
    }

    // ============ COLLAPSE STATE ============
    $isOpen      = $openGroups[$key] ?? false;
    $canOpen     = $this->canOpenGroup($key);
    $isCompleted = $this->isGroupCompleted($key);
    $isLocked    = $this->isGroupLocked($key);
@endphp

<div class="relative rounded-2xl overflow-hidden shadow-lg ring-1 ring-emerald-200/50 dark:ring-emerald-800/50 bg-white dark:bg-zinc-900">

    {{-- HEADER (clickable) --}}
    <button
        type="button"
        wire:click="toggleGroup('{{ $key }}')"
        @if(!$canOpen) disabled @endif
        class="w-full relative px-6 py-4 bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 overflow-hidden text-left transition
            {{ $canOpen ? 'cursor-pointer hover:brightness-110' : 'cursor-not-allowed opacity-75' }}">

        <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/10"></div>
        <div class="absolute -right-4 -bottom-10 w-20 h-20 rounded-full bg-white/10"></div>

        @if(!$readonly && $emptyRowsCount > 0 && $isOpen)
            <div class="relative mb-3 px-3 py-2 rounded-lg bg-red-500/95 backdrop-blur border border-red-300 shadow-lg flex items-start gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-white flex-shrink-0 mt-0.5">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>
                <div class="flex-1">
                    <div class="text-xs font-bold text-white">
                        Belum diisi: {{ $emptyRowsCount }} row
                    </div>
                    <div class="text-[10px] text-white/90 mt-0.5">
                        Setiap row minimal 1 PCB wajib diisi.
                    </div>
                </div>
            </div>
        @endif

        <div class="relative flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                        <path fill-rule="evenodd" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <div class="text-[10px] text-white/70 uppercase tracking-wider font-semibold flex items-center gap-2">
                        Verification
                        @if($isCompleted)
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-emerald-500/40 border border-emerald-300/60 text-[9px] font-bold">
                                ✓ COMPLETED
                            </span>
                        @endif
                        @if($isLocked)
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-zinc-800/50 border border-zinc-300/40 text-[9px] font-bold">
                                🔒 LOCKED
                            </span>
                        @endif
                    </div>
                    <div class="text-base font-bold text-white leading-tight">{{ $label }}</div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                @if($statusRunning && !$isOpen)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                        {{ $statusRunning }}
                    </span>
                @endif

                <div class="w-8 h-8 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center transition-transform duration-300
                    {{ $isOpen ? 'rotate-180' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-white">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
    </button>

    {{-- BODY (collapsible) --}}
    <div x-show="$wire.openGroups['{{ $key }}']" x-collapse
        class="p-5 space-y-5 bg-gradient-to-b from-white to-zinc-50/50 dark:from-zinc-900 dark:to-zinc-900/50">

        @if(!$side || !$meta)
            <div class="rounded-xl border-2 border-dashed border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6 text-center">
                <p class="text-sm font-semibold text-zinc-600 dark:text-zinc-400">Pilih PCB Type dulu untuk menampilkan form scan.</p>
            </div>
        @else
            @php
                $counts = collect($pcbCols)->map(fn($c) => count($items[$side][$c] ?? []))->max() ?? $minRows;
                $rows   = max($minRows, $counts);
                $filledCount = 0;
                foreach ($pcbCols as $c) {
                    foreach (($items[$side][$c] ?? []) as $v) {
                        if (!empty($v)) $filledCount++;
                    }
                }
            @endphp

            <div class="rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 shadow-sm bg-white dark:bg-zinc-900">

                <div class="px-4 py-2.5 bg-gradient-to-r {{ $meta['class'] }} flex items-center justify-between">
                    <span class="text-sm font-bold text-white tracking-wide">{{ $meta['label'] }} — Verification</span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-white/20 backdrop-blur-sm border border-white/30 text-white text-[10px] font-semibold">
                        {{ $filledCount }} / {{ $rows * count($pcbCols) }} filled
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-xs">
                        <thead>
                            <tr class="bg-zinc-100 dark:bg-zinc-800/80 border-b-2 border-zinc-200 dark:border-zinc-700">
                                <th class="px-2 py-2.5 text-center font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-[10px] w-10">#</th>
                                @foreach($pcbLabels as $col => $colLabel)
                                    <th class="px-3 py-2.5 text-center font-semibold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider text-[10px]">
                                        {{ $colLabel }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 0; $i < $rows; $i++)
                                @php
                                    $rowHasContent = false;
                                    foreach ($pcbCols as $c) {
                                        if (!empty($items[$side][$c][$i] ?? null)) { $rowHasContent = true; break; }
                                    }
                                @endphp
                                <tr class="border-b border-zinc-100 dark:border-zinc-800 transition-colors
                                    {{ $rowHasContent ? 'bg-white dark:bg-zinc-900' : 'bg-zinc-50/50 dark:bg-zinc-800/20' }}
                                    hover:bg-blue-50/60 dark:hover:bg-blue-900/10">

                                    <td class="px-2 py-1 text-center align-middle">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-md
                                            {{ $rowHasContent ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-zinc-100 text-zinc-400 dark:bg-zinc-800 dark:text-zinc-500' }}
                                            text-[10px] font-bold">
                                            {{ $i + 1 }}
                                        </span>
                                    </td>

                                    @foreach($pcbCols as $col)
                                        @php
                                            $cellValue = $items[$side][$col][$i] ?? '';
                                            $hasValue  = !empty($cellValue);
                                        @endphp
                                        <td class="px-1 py-1">
                                            @if($readonly)
                                                <span class="px-2 py-1.5 block text-xs font-mono text-zinc-800 dark:text-zinc-200 rounded text-center
                                                    {{ $hasValue ? 'bg-zinc-50 dark:bg-zinc-800/50' : '' }}">
                                                    {{ $cellValue ?: '-' }}
                                                </span>
                                            @else
                                                <input
                                                    type="text"
                                                    data-pcb-input
                                                    data-group="{{ $key }}"
                                                    data-side="{{ $side }}"
                                                    data-row="{{ $i }}"
                                                    data-col="{{ $col }}"
                                                    wire:model.live.debounce.500ms="{{ $key }}.{{ $side }}.{{ $col }}.{{ $i }}"
                                                    x-on:keydown.enter.prevent="
                                                        $el.blur();
                                                        const cols = ['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'];
                                                        const curIdx = cols.indexOf('{{ $col }}');
                                                        const group = '{{ $key }}';
                                                        const side = '{{ $side }}';
                                                        let nextRow = {{ $i }};
                                                        let nextCol = curIdx + 1;
                                                        if (nextCol >= cols.length) { nextCol = 0; nextRow = {{ $i }} + 1; }
                                                        if (nextRow < {{ $rows }}) {
                                                            const next = document.querySelector(
                                                                `input[data-group='${group}'][data-side='${side}'][data-row='${nextRow}'][data-col='${cols[nextCol]}']`
                                                            );
                                                            if (next) next.focus();
                                                        }
                                                    "
                                                    class="w-full border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/50
                                                        px-2 py-1.5 text-xs rounded-md text-center
                                                        hover:border-blue-300 dark:hover:border-blue-700
                                                        focus:border-blue-400 focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-900/40
                                                        transition-all placeholder:text-zinc-300 dark:placeholder:text-zinc-500"
                                                    placeholder="—" />
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>

                @if(!$readonly && !empty($rowErrors))
                    <div class="p-3 bg-red-50 dark:bg-red-950/30 border-t-2 border-red-300 dark:border-red-700">
                        <div class="flex items-start gap-2 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs font-bold text-red-700 dark:text-red-300 uppercase tracking-wide">
                                Perhatian — Data Belum Lengkap
                            </span>
                        </div>
                        <ul class="space-y-1 pl-6">
                            @foreach($rowErrors as $err)
                                <li class="flex items-start gap-1.5 text-xs text-red-700 dark:text-red-300">
                                    <span class="text-red-500 font-bold">•</span>
                                    <span>{{ $err }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif

        {{-- RINGKASAN --}}
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-3 shadow-sm">
            <div class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-2 text-center">Ringkasan</div>

            <div class="grid {{ $readonly ? 'grid-cols-2 md:grid-cols-2' : 'grid-cols-2' }} gap-3">

                @if($readonly)
                    <div class="rounded-lg bg-zinc-50 dark:bg-zinc-800/50 p-3 border border-zinc-100 dark:border-zinc-800 text-center">
                        <div class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1">Time Scan</div>
                        <div class="text-sm font-mono font-bold text-zinc-800 dark:text-zinc-200">{{ $items['time_scan'] ?? '-' }}</div>
                    </div>
                @endif

                <div class="rounded-lg bg-gradient-to-br from-cyan-50 to-cyan-100/50 dark:from-cyan-900/20 dark:to-cyan-900/10 p-3 border border-cyan-200 dark:border-cyan-800 text-center">
                    <div class="text-[10px] text-cyan-700 dark:text-cyan-400 uppercase tracking-wider font-semibold mb-1">
                        Status Running <span class="text-red-500">*</span>
                    </div>
                    @if($readonly)
                        <div class="text-sm font-bold text-zinc-700 dark:text-zinc-300">{{ $statusRunning ?: '-' }}</div>
                    @else
                        <flux:input type="text"
                            wire:model="{{ $key }}.status_running"
                            placeholder="Machine / Others"
                            class="!text-center !font-semibold !border-cyan-300 focus:!border-cyan-500" />
                        @error("$key.status_running")
                            <span class="text-red-500 text-xs block mt-1 text-center">{{ $message }}</span>
                        @enderror
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>