@props([
    'key'        => 'first_piece_items',
    'label'      => 'First Piece Items',
    'items'      => [],
    'readonly'   => false,
    'ngEditable' => false,
    'activeSide' => null,
    'minRows'    => 3,
])

@php
    $fieldLabels = [
        'time_scan'      => 'Time Scan',
        'ok_qty'         => 'OK Qty',
        'ng_qty'         => 'NG Qty',
        'reject_rate'    => 'Reject Rate',
        'status_running' => 'Status Running',
        'filling_ratio'  => 'Filling Ratio',
        'pictures'       => 'Pictures',
        'qty_hold'       => 'Qty Hold',
        'ncp_id'         => 'NCP',
        'remarks'        => 'Remarks',
    ];

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

    $ngQty         = (int) ($items['ng_qty'] ?? 0);
    $showNgFields  = $ngQty > 0;
    $ngDetailReadonly = $readonly && !$ngEditable;
    $okQty         = (int) ($items['ok_qty'] ?? 0);
    $totalQty      = $okQty + $ngQty;
    $statusRunning = $items['status_running'] ?? null;

    $side = $activeSide;
    $meta = $side ? ($sideMeta[$side] ?? null) : null;

    $rowErrors = [];
    if (!$readonly && $side) {
        try { $rowErrors = $this->getGroupRowErrors($key); }
        catch (\Throwable $e) { $rowErrors = []; }
    }

    $emptyRowsCount = 0;
    $unjudgedCount  = 0;
    if (!$readonly && $side) {
        $sideData = $items[$side] ?? [];
        $maxRows = 0;
        foreach ($pcbCols as $c) {
            $maxRows = max($maxRows, count($sideData[$c] ?? []));
        }
        for ($i = 0; $i < $maxRows; $i++) {
            $hasAnyInRow = false;
            foreach ($pcbCols as $c) {
                $val = $sideData[$c][$i] ?? null;
                if (!empty($val)) $hasAnyInRow = true;
            }
            if (!$hasAnyInRow) $emptyRowsCount++;
        }
    }
@endphp

<div class="relative rounded-2xl overflow-hidden shadow-lg ring-1 ring-blue-200/50 dark:ring-blue-800/50 bg-white dark:bg-zinc-900">

    {{-- HEADER --}}
    <div class="relative px-6 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 overflow-hidden">
        <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/10"></div>
        <div class="absolute -right-4 -bottom-10 w-20 h-20 rounded-full bg-white/10"></div>

        @if(!$readonly && $emptyRowsCount > 0)
            <div class="relative mb-3 px-3 py-2 rounded-lg bg-red-500/95 backdrop-blur border border-red-300 shadow-lg flex items-start gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-white flex-shrink-0 mt-0.5">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>
                <div class="flex-1">
                    <div class="text-xs font-bold text-white">
                        Belum ada isi: {{ $emptyRowsCount }} row
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
                        <path fill-rule="evenodd" d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 18.375V5.625Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <div class="text-[10px] text-white/70 uppercase tracking-wider font-semibold">Inspection Group</div>
                    <div class="text-base font-bold text-white leading-tight">{{ $label }}</div>
                </div>
            </div>

            @if($totalQty > 0 || $statusRunning)
                <div class="flex items-center gap-2">
                    @if($statusRunning)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                            {{ $statusRunning }}
                        </span>
                    @endif
                    @if($totalQty > 0)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                            OK: {{ $okQty }}
                        </span>
                        @if($ngQty > 0)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                                NG: {{ $ngQty }}
                            </span>
                        @endif
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- BODY --}}
    <div class="p-5 space-y-5 bg-gradient-to-b from-white to-zinc-50/50 dark:from-zinc-900 dark:to-zinc-900/50">

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

                {{-- HEADER SIDE --}}
                <div class="px-4 py-2.5 bg-gradient-to-r {{ $meta['class'] }} flex items-center justify-between">
                    <span class="text-sm font-bold text-white tracking-wide">{{ $meta['label'] }}</span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-white/20 backdrop-blur-sm border border-white/30 text-white text-[10px] font-semibold">
                        {{ $filledCount }} / {{ $rows * count($pcbCols) }} filled
                    </span>
                </div>

                {{-- TABLE --}}
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
                                            {{ $rowHasContent ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : 'bg-zinc-100 text-zinc-400 dark:bg-zinc-800 dark:text-zinc-500' }}
                                            text-[10px] font-bold">
                                            {{ $i + 1 }}
                                        </span>
                                    </td>

                                    @foreach($pcbCols as $col)
                                        @php
                                            $cellValue = $items[$side][$col][$i] ?? '';
                                            $cellJudge = $this->judgements[$key][$side][$col][$i] ?? null;
                                            $hasValue  = !empty($cellValue);
                                            $isNg      = $cellJudge === 'ng';
                                            $hasError  = isset($errors) && $errors->has("{$key}_{$col}_value_{$i}");
                                        @endphp
                                        <td class="px-1 py-1">
                                            @if($readonly)
                                                <div class="flex items-center gap-1">
                                                    <span class="flex-1 px-2 py-1.5 block text-xs font-mono text-zinc-800 dark:text-zinc-200 rounded text-center
                                                        {{ $hasValue ? 'bg-zinc-50 dark:bg-zinc-800/50' : '' }}">
                                                        {{ $cellValue ?: '-' }}
                                                    </span>
                                                    @if($hasValue)
                                                        @if($isNg)
                                                            <span class="flex-shrink-0 inline-flex items-center justify-center w-5 h-5 rounded-full bg-red-500 text-white" title="NG">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                                                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                                                </svg>
                                                            </span>
                                                        @else
                                                            <span class="flex-shrink-0 inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500 text-white" title="OK">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                                                </svg>
                                                            </span>
                                                        @endif
                                                    @endif
                                                </div>
                                            @else
                                                <div class="flex items-center gap-1">
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
                                                            @if($i < $rows - 1)
                                                                const next = document.querySelector(
                                                                    `input[data-group='{{ $key }}'][data-side='{{ $side }}'][data-row='{{ $i + 1 }}'][data-col='{{ $col }}']`
                                                                );
                                                                if (next) next.focus();
                                                            @endif
                                                        "
                                                        class="flex-1 min-w-0 border
                                                            {{ $hasError
                                                                ? 'border-red-400 dark:border-red-600 bg-red-50 dark:bg-red-900/20'
                                                                : 'border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/50' }}
                                                            px-2 py-1.5 text-xs rounded-md text-center
                                                            hover:border-blue-300 dark:hover:border-blue-700
                                                            focus:border-blue-400 focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-900/40
                                                            transition-all placeholder:text-zinc-300 dark:placeholder:text-zinc-500"
                                                        placeholder="—" />

                                                    {{-- NG toggle button (icon bulat) --}}
                                                    <button
                                                        type="button"
                                                        wire:click="toggleNg('{{ $key }}', '{{ $side }}', '{{ $col }}', {{ $i }})"
                                                        @if(!$hasValue) disabled @endif
                                                        title="{{ $isNg ? 'Batalkan NG' : 'Tandai NG' }}"
                                                        class="flex-shrink-0 inline-flex items-center justify-center w-6 h-6 rounded-full transition-all
                                                            {{ $isNg
                                                                ? 'bg-red-500 text-white shadow-md hover:bg-red-600'
                                                                : ($hasValue
                                                                    ? 'bg-white dark:bg-zinc-800 text-zinc-400 border-2 border-zinc-300 dark:border-zinc-600 hover:border-red-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20'
                                                                    : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-300 dark:text-zinc-600 border-2 border-zinc-200 dark:border-zinc-700 cursor-not-allowed') }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                                            <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>

                {{-- ERROR ROW --}}
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

            @php
                $gridClass = $readonly ? 'grid-cols-2 md:grid-cols-5' : 'grid-cols-2 md:grid-cols-4';
            @endphp

            <div class="grid {{ $gridClass }} gap-3">

                @if($readonly)
                    <div class="rounded-lg bg-zinc-50 dark:bg-zinc-800/50 p-3 border border-zinc-100 dark:border-zinc-800 text-center">
                        <div class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1">Time Scan</div>
                        <div class="text-sm font-mono font-bold text-zinc-800 dark:text-zinc-200">{{ $items['time_scan'] ?? '-' }}</div>
                    </div>
                @endif

                {{-- OK QTY --}}
                <div class="rounded-lg bg-gradient-to-br from-emerald-50 to-emerald-100/50 dark:from-emerald-900/20 dark:to-emerald-900/10 p-3 border border-emerald-200 dark:border-emerald-800 text-center">
                    <div class="text-[10px] text-emerald-700 dark:text-emerald-400 uppercase tracking-wider font-semibold mb-1">OK Qty</div>
                    <div class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">{{ $okQty }}</div>
                    @if(!$readonly)
                        <div class="text-[9px] text-zinc-400 mt-0.5">auto dari NG ceklis</div>
                    @endif
                </div>

                {{-- NG QTY --}}
                <div class="rounded-lg bg-gradient-to-br from-red-50 to-red-100/50 dark:from-red-900/20 dark:to-red-900/10 p-3 border border-red-200 dark:border-red-800 text-center">
                    <div class="text-[10px] text-red-700 dark:text-red-400 uppercase tracking-wider font-semibold mb-1">NG Qty</div>
                    <div class="text-2xl font-bold text-red-700 dark:text-red-300">{{ $ngQty }}</div>
                    @if(!$readonly)
                        <div class="text-[9px] text-zinc-400 mt-0.5">auto dari NG ceklis</div>
                    @endif
                </div>

                {{-- REJECT RATE --}}
                <div class="rounded-lg bg-gradient-to-br from-zinc-50 to-zinc-100/50 dark:from-zinc-800/50 dark:to-zinc-800/20 p-3 border border-zinc-200 dark:border-zinc-700 text-center">
                    <div class="text-[10px] text-zinc-600 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1">Reject Rate</div>
                    @php $rr = (float) ($items['reject_rate'] ?? 0); @endphp
                    <div class="text-lg font-bold font-mono {{ $rr >= 5 ? 'text-red-600' : ($rr > 0 ? 'text-amber-600' : 'text-emerald-600') }}">
                        {{ $rr }}%
                    </div>
                </div>

                {{-- STATUS RUNNING --}}
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

        {{-- NG DETAIL --}}
        @if($showNgFields)
            @php
                $ngFieldFilled = 0;
                if (!empty($items['filling_ratio'])) $ngFieldFilled++;
                if (!empty($items['qty_hold'])) $ngFieldFilled++;
                if (!empty($items['status_after_check']['ok'])) $ngFieldFilled++;
                if (!empty($items['status_after_check']['ng'])) $ngFieldFilled++;
                if (!empty($items['ncp_id'])) $ngFieldFilled++;
                if (!empty($items['remarks'])) $ngFieldFilled++;
            @endphp

            <div x-data="{ open: false }"
                class="relative rounded-2xl overflow-hidden shadow-lg ring-1 ring-red-200/50 dark:ring-red-800/50 bg-white dark:bg-zinc-900">

                <button type="button"
                    x-on:click="open = !open"
                    class="w-full relative px-6 py-4 bg-gradient-to-r from-red-500 via-rose-500 to-pink-500 cursor-pointer">
                    <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/10"></div>
                    <div class="relative flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="text-left">
                                <div class="text-[10px] text-white/70 uppercase tracking-wider font-semibold">Required Fields</div>
                                <div class="text-base font-bold text-white leading-tight">NG Detail</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                                NG Qty: {{ $ngQty }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                                {{ $ngFieldFilled }}/6 filled
                            </span>

                            {{-- ⬇️ ICON CHEVRON --}}
                            <div class="w-8 h-8 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center transition-transform duration-300"
                                :class="open ? 'rotate-180' : ''">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-white">
                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </button>

                <div x-show="open" x-collapse class="p-5 bg-white dark:bg-zinc-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                        {{-- FILLING RATIO --}}
                        <div class="rounded-xl border border-orange-200 dark:border-orange-800 bg-gradient-to-br from-orange-50 to-orange-100/50 dark:from-orange-900/20 dark:to-orange-900/10 overflow-hidden shadow-sm">
                            <div class="px-3 py-2 bg-gradient-to-r from-orange-500 to-amber-500 text-center">
                                <span class="text-xs font-bold text-white uppercase tracking-wide">Filling Ratio</span>
                            </div>
                            <div class="p-4 text-center">
                                @if($ngDetailReadonly)
                                    <div class="text-2xl font-bold text-orange-700 dark:text-orange-300">
                                        {{ isset($items['filling_ratio']) && $items['filling_ratio'] !== null ? $items['filling_ratio'] . '%' : '-' }}
                                    </div>
                                @else
                                    <div class="relative">
                                        <flux:input type="number" step="0.01" min="0" max="100"
                                            wire:model="{{ $key }}.filling_ratio"
                                            placeholder="0 - 100" class="pr-9 !text-center !text-lg !font-bold" />
                                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-zinc-400 font-bold">%</span>
                                    </div>
                                    @error("$key.filling_ratio") <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                @endif
                            </div>
                        </div>

                        {{-- QTY HOLD --}}
                        <div class="rounded-xl border border-amber-200 dark:border-amber-800 bg-gradient-to-br from-amber-50 to-amber-100/50 dark:from-amber-900/20 dark:to-amber-900/10 overflow-hidden shadow-sm">
                            <div class="px-3 py-2 bg-gradient-to-r from-amber-500 to-yellow-500 text-center">
                                <span class="text-xs font-bold text-white uppercase tracking-wide">Qty Hold</span>
                            </div>
                            <div class="p-4 text-center">
                                @if($ngDetailReadonly)
                                    <div class="text-2xl font-bold font-mono text-amber-700 dark:text-amber-300">{{ $items['qty_hold'] ?? 0 }}</div>
                                @else
                                    <flux:input type="number" min="0"
                                        wire:model.live.debounce.300ms="{{ $key }}.qty_hold"
                                        class="!text-center !text-lg !font-bold" />
                                @endif
                            </div>
                        </div>

                        {{-- STATUS OK --}}
                        <div class="rounded-xl border border-emerald-200 dark:border-emerald-800 bg-gradient-to-br from-emerald-50 to-emerald-100/50 dark:from-emerald-900/20 dark:to-emerald-900/10 overflow-hidden shadow-sm">
                            <div class="px-3 py-2 bg-gradient-to-r from-emerald-500 to-green-500 text-center">
                                <span class="text-xs font-bold text-white uppercase tracking-wide">Status OK</span>
                            </div>
                            <div class="p-4 text-center">
                                @if($ngDetailReadonly)
                                    <div class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">{{ $items['status_after_check']['ok'] ?? 0 }}</div>
                                @else
                                    <flux:input type="number" min="0"
                                        wire:model.live.debounce.300ms="{{ $key }}.status_after_check.ok"
                                        class="!border-emerald-300 focus:!border-emerald-500 !text-center !text-lg !font-bold" />
                                @endif
                            </div>
                        </div>

                        {{-- STATUS NG --}}
                        <div class="rounded-xl border border-red-200 dark:border-red-800 bg-gradient-to-br from-red-50 to-red-100/50 dark:from-red-900/20 dark:to-red-900/10 overflow-hidden shadow-sm">
                            <div class="px-3 py-2 bg-gradient-to-r from-red-500 to-rose-500 text-center">
                                <span class="text-xs font-bold text-white uppercase tracking-wide">Status NG</span>
                            </div>
                            <div class="p-4 text-center">
                                @if($ngDetailReadonly)
                                    <div class="text-2xl font-bold text-red-700 dark:text-red-300">{{ $items['status_after_check']['ng'] ?? 0 }}</div>
                                @else
                                    <flux:input type="number" min="0"
                                        wire:model.live.debounce.300ms="{{ $key }}.status_after_check.ng"
                                        class="!border-red-300 focus:!border-red-500 !text-center !text-lg !font-bold" />
                                @endif
                            </div>
                        </div>

                        {{-- NCP --}}
                        <div class="md:col-span-2 lg:col-span-4 rounded-xl border border-indigo-200 dark:border-indigo-800 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/10 overflow-hidden shadow-sm">
                            <div class="px-4 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-between">
                                <span class="text-xs font-bold text-white uppercase tracking-wide">NCP</span>
                                @if(!empty($items['ncp_id']))
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-white/20 text-white text-[10px] font-semibold">Selected</span>
                                @endif
                            </div>
                            <div class="p-4">
                                @php
                                    $ncpId = $items['ncp_id'] ?? null;
                                    $ncpLabel = '-';
                                    if ($ncpId) {
                                        $ncpModel = \App\Models\QAQC\NCP::find($ncpId);
                                        $ncpLabel = $ncpModel ? $ncpModel->ncp_number : "ID: $ncpId";
                                    }
                                    $isPanelOpen = $openNcpPanels[$key] ?? false;
                                @endphp

                                @if($ngDetailReadonly)
                                    @if($ncpId)
                                        <div class="text-sm font-bold text-zinc-800 dark:text-white">{{ $ncpLabel }}</div>
                                    @else
                                        <div class="text-sm text-zinc-500 italic text-center py-2">Belum dipilih</div>
                                    @endif
                                @else
                                    <div class="flex gap-2">
                                        <div class="flex-1 text-sm px-3 py-2 rounded-lg border
                                            {{ $ncpId ? 'border-indigo-300 bg-white dark:bg-zinc-800' : 'border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900' }}
                                            text-zinc-700 dark:text-zinc-300 truncate flex items-center gap-2">
                                            @if($ncpId)
                                                <span class="truncate font-medium">{{ $ncpLabel }}</span>
                                            @else
                                                <span class="text-zinc-400 italic">Belum dipilih</span>
                                            @endif
                                        </div>
                                        <button type="button"
                                            wire:click="toggleNcpPanel('{{ $key }}')"
                                            class="px-3 py-2 text-xs rounded-lg transition whitespace-nowrap inline-flex items-center gap-1 font-semibold
                                                {{ $isPanelOpen
                                                    ? 'bg-zinc-600 hover:bg-zinc-700 text-white'
                                                    : 'bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white shadow-sm hover:shadow-md' }}">
                                            {{ $isPanelOpen ? 'Tutup' : 'Pilih NCP' }}
                                        </button>
                                        @if($ncpId)
                                            <button type="button"
                                                wire:click="clearNcp('{{ $key }}')"
                                                class="px-3 py-2 text-xs bg-red-500 text-white rounded-lg hover:bg-red-600 transition whitespace-nowrap font-semibold">
                                                Hapus
                                            </button>
                                        @endif
                                    </div>
                                    @error("$key.ncp_id") <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror

                                    @if($isPanelOpen)
                                        @php $ncpList = $this->getNcpListFor($key); @endphp
                                        <div class="mt-3 rounded-xl overflow-hidden border border-indigo-300 dark:border-indigo-700 bg-white dark:bg-zinc-900 shadow-lg">
                                            <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/30 dark:to-purple-900/30 border-b border-indigo-200 dark:border-indigo-800">
                                                <flux:input
                                                    wire:model.live.debounce.300ms="ncpSearches.{{ $key }}"
                                                    placeholder="Cari NCP..."
                                                    icon="magnifying-glass"
                                                    clearable />
                                            </div>
                                            <div class="overflow-x-auto">
                                                <table class="w-full text-xs">
                                                    <thead>
                                                        <tr class="bg-zinc-100 dark:bg-zinc-800/80 border-b border-zinc-200 dark:border-zinc-700">
                                                            <th class="px-3 py-2.5 text-left font-semibold text-zinc-600 dark:text-zinc-300 uppercase text-[10px]">NCP Number</th>
                                                            <th class="px-3 py-2.5 text-center font-semibold text-zinc-600 dark:text-zinc-300 uppercase text-[10px] w-20">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                                        @forelse($ncpList as $ncp)
                                                            <tr class="hover:bg-indigo-50 dark:hover:bg-indigo-900/20 cursor-pointer" wire:click="selectNcp('{{ $key }}', {{ $ncp->id }})">
                                                                <td class="px-3 py-2 font-mono font-semibold">{{ $ncp->ncp_number }}</td>
                                                                <td class="px-3 py-2 text-center">
                                                                    <button type="button" wire:click.stop="selectNcp('{{ $key }}', {{ $ncp->id }})"
                                                                        class="px-3 py-1 text-[10px] bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold">
                                                                        Pilih
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr><td colspan="2" class="px-3 py-6 text-center text-zinc-500">No NCP found</td></tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                            @if($ncpList->hasPages())
                                                <div class="px-3 py-2 border-t border-zinc-200 flex justify-between items-center bg-zinc-50 dark:bg-zinc-800/50">
                                                    <span class="text-[10px] text-zinc-500 font-semibold">
                                                        {{ $ncpList->firstItem() ?? 0 }} - {{ $ncpList->lastItem() ?? 0 }} of {{ $ncpList->total() }}
                                                    </span>
                                                    <div class="flex gap-1">
                                                        @if(!$ncpList->onFirstPage())
                                                            <button type="button" wire:click="setNcpPage('{{ $key }}', {{ $ncpList->currentPage() - 1 }})"
                                                                class="px-2 py-1 text-[10px] rounded bg-white dark:bg-zinc-800 border font-semibold">Prev</button>
                                                        @endif
                                                        <span class="px-2 py-1 text-[10px] font-semibold">{{ $ncpList->currentPage() }} / {{ $ncpList->lastPage() }}</span>
                                                        @if($ncpList->hasMorePages())
                                                            <button type="button" wire:click="setNcpPage('{{ $key }}', {{ $ncpList->currentPage() + 1 }})"
                                                                class="px-2 py-1 text-[10px] rounded bg-white dark:bg-zinc-800 border font-semibold">Next</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        {{-- PICTURES --}}
                        <div class="md:col-span-2 lg:col-span-2 rounded-xl border border-sky-200 dark:border-sky-800 bg-gradient-to-br from-sky-50 to-cyan-50 dark:from-sky-900/20 dark:to-cyan-900/10 overflow-hidden shadow-sm">
                            <div class="px-4 py-2.5 bg-gradient-to-r from-sky-500 to-cyan-500 flex items-center justify-between">
                                <span class="text-xs font-bold text-white uppercase tracking-wide">Pictures</span>
                                @php $pics = is_array($items['pictures'] ?? null) ? $items['pictures'] : []; @endphp
                                @if(count($pics) > 0)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-white/20 text-white text-[10px] font-semibold">
                                        {{ count($pics) }} file
                                    </span>
                                @endif
                            </div>
                            <div class="p-4">
                                @if($ngDetailReadonly)
                                    @if(count($pics) > 0)
                                        <div class="grid grid-cols-2 gap-4">
                                            @foreach($pics as $pic)
                                                <a href="{{ Storage::disk('public')->url($pic) }}" target="_blank"
                                                    class="group block aspect-square rounded-xl border-2 border-zinc-200 dark:border-zinc-700 overflow-hidden hover:border-sky-400 transition-all">
                                                    <img src="{{ Storage::disk('public')->url($pic) }}" class="w-full h-full object-cover" />
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-sm text-zinc-500 italic text-center py-2">Belum ada gambar</div>
                                    @endif
                                @else
                                    <div class="space-y-3">
                                        @if(isset($items['pictures']) && is_array($items['pictures']) && count($items['pictures']) > 0)
                                            <div class="flex flex-wrap gap-3 justify-center">
                                                @foreach($items['pictures'] as $idx => $pic)
                                                    @php
                                                        $previewUrl = $pic instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile
                                                            ? $pic->temporaryUrl()
                                                            : Storage::disk('public')->url($pic);
                                                    @endphp
                                                    <div class="relative group">
                                                        <div class="w-24 h-24 rounded-lg border-2 border-zinc-200 dark:border-zinc-700 overflow-hidden">
                                                            <img src="{{ $previewUrl }}" class="w-full h-full object-cover" />
                                                        </div>
                                                        <button type="button"
                                                            wire:click="removePicture('{{ $key }}', {{ $idx }})"
                                                            class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-red-500 text-white text-xs flex items-center justify-center shadow-lg hover:bg-red-600">✕</button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        <label class="relative flex flex-col items-center justify-center w-full h-32
                                            border-2 border-dashed border-zinc-300 dark:border-zinc-700 rounded-xl
                                            cursor-pointer bg-white dark:bg-zinc-800/30
                                            hover:border-sky-400 hover:bg-sky-50 dark:hover:bg-sky-900/10 transition-all group">
                                            <input type="file"
                                                wire:model="{{ $key }}.pictures_new"
                                                multiple accept="image/*"
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-zinc-400 group-hover:text-sky-500 transition-colors mb-2">
                                                <path fill-rule="evenodd" d="M11.47 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06l-3.22-3.22V16.5a.75.75 0 0 1-1.5 0V4.81L8.03 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5ZM3 15.75a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-xs font-semibold text-zinc-600 group-hover:text-sky-600">Klik atau drag gambar ke sini</span>
                                            <span class="text-[10px] text-zinc-400 mt-0.5">PNG, JPG, JPEG (max 5MB)</span>
                                        </label>
                                        @error("$key.pictures") <span class="text-red-500 text-xs block text-center">{{ $message }}</span> @enderror
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- REMARKS --}}
                        <div class="md:col-span-2 lg:col-span-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-gradient-to-br from-zinc-50 to-slate-50 dark:from-zinc-900/50 dark:to-slate-900/30 overflow-hidden shadow-sm">
                            <div class="px-4 py-2.5 bg-gradient-to-r from-zinc-600 to-slate-600 flex items-center justify-between">
                                <span class="text-xs font-bold text-white uppercase tracking-wide">Remarks</span>
                            </div>
                            <div class="p-4">
                                @if($ngDetailReadonly)
                                    <div class="text-sm text-zinc-800 dark:text-zinc-200 whitespace-pre-line">
                                        {{ $items['remarks'] ?? '-' }}
                                    </div>
                                @else
                                    <flux:textarea wire:model="{{ $key }}.remarks" rows="3" placeholder="Tulis keterangan..." />
                                    @error("$key.remarks") <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endif

    </div>
</div>