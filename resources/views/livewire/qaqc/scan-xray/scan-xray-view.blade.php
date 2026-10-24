<div class="p-1 space-y-2">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">QA/QC</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('qaqc.scan-xray.index') }}" wire:navigate separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">Scan X-Ray</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">Detail</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    @php
        $isLocked    = $scan->created_at && $scan->created_at->diffInHours(now()) >= 24;
        $isCompleted = $scan->phase === 'completed';

        $phaseLabels = [
            'first'         => ['label' => 'Phase 1: First Piece',           'color' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300'],
            'second_first'  => ['label' => 'Phase 2: Second Piece (First)',  'color' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'],
            'middle'        => ['label' => 'Phase 3: Middle Piece',          'color' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300'],
            'second_middle' => ['label' => 'Phase 4: Second Piece (Middle)', 'color' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'],
            'last'          => ['label' => 'Phase 5: Last Piece',            'color' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300'],
            'second_last'   => ['label' => 'Phase 6: Second Piece (Last)',   'color' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'],
            'completed'     => ['label' => 'Completed',                      'color' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'],
        ];
        $currentPhase = $phaseLabels[$scan->phase ?? 'first'] ?? $phaseLabels['first'];

        $hasAnyGroup = $firstFilled || $middleFilled || $lastFilled
            || $secondFirstFilled || $secondMiddleFilled || $secondLastFilled;
    @endphp

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">Scan X-Ray Detail</h1>
                <span class="inline-flex items-center px-3 py-1 rounded-lg {{ $currentPhase['color'] }} text-xs font-bold">
                    {{ $currentPhase['label'] }}
                </span>
            </div>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Detail informasi hasil inspeksi Scan X-Ray
            </p>
        </div>
        <div class="flex gap-2">
            @can('edit scan xray')
                @if(!$isLocked && !$isCompleted)
                    <flux:button href="{{ route('qaqc.scan-xray.edit', $scan->id) }}" wire:navigate
                        variant="primary" icon="pencil-square"
                        class="!bg-gradient-to-r !from-amber-400 !to-orange-400 !text-white !border-0 !shadow-md">
                        Edit
                    </flux:button>
                @elseif($isCompleted)
                    <flux:tooltip content="Data sudah selesai" position="top">
                        <flux:button variant="filled" icon="check-badge" disabled
                            class="!bg-emerald-100 dark:!bg-emerald-900/40 !text-emerald-700 dark:!text-emerald-300">
                            Completed
                        </flux:button>
                    </flux:tooltip>
                @else
                    <flux:tooltip content="Data sudah lebih dari 24 jam" position="top">
                        <flux:button variant="filled" icon="lock-closed" disabled
                            class="!bg-zinc-200 dark:!bg-zinc-800 !text-zinc-400">Locked</flux:button>
                    </flux:tooltip>
                @endif
            @endcan

            <flux:button href="{{ route('qaqc.scan-xray.index') }}" wire:navigate
                icon="arrow-left"
                class="!bg-gradient-to-r !from-sky-400 !to-blue-400 !text-white !border-0 !shadow-md">
                Back
            </flux:button>
        </div>
    </div>

    {{-- LOCK WARNING --}}
    @if($isLocked && !$isCompleted)
        <div class="rounded-xl border border-amber-300 dark:border-amber-700 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-950/40 dark:to-orange-950/40 p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold text-amber-900 dark:text-amber-100">Data Terkunci</p>
                <p class="text-xs text-amber-800 dark:text-amber-200 mt-0.5">
                    Data ini sudah lebih dari 24 jam, tidak dapat diedit atau dihapus.
                </p>
            </div>
        </div>
    @endif

    {{-- HEADER INFORMATION CARD --}}
    <div class="relative rounded-2xl overflow-hidden shadow-lg ring-1 ring-blue-200/50 dark:ring-blue-800/50 bg-white dark:bg-zinc-900">
        <div class="relative px-6 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 overflow-hidden">
            <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/10"></div>
            <div class="absolute -right-4 -bottom-10 w-20 h-20 rounded-full bg-white/10"></div>

            <div class="relative flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-[10px] text-white/70 uppercase tracking-wider font-semibold">Header</div>
                        <div class="text-base font-bold text-white leading-tight">Header Information</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 border border-white/30 text-white text-xs font-semibold">
                        #{{ $scan->id }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-5 bg-gradient-to-b from-white to-zinc-50/50 dark:from-zinc-900 dark:to-zinc-900/50">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3">

                <div class="rounded-lg bg-gradient-to-br from-blue-50 to-blue-100/50 dark:from-blue-900/20 dark:to-blue-900/10 p-3 border border-blue-200 dark:border-blue-800">
                    <div class="text-[10px] text-blue-700 dark:text-blue-400 uppercase tracking-wider font-semibold mb-1">Customer</div>
                    <div class="text-sm font-bold text-zinc-800 dark:text-white truncate">{{ $scan->customer->customer_name ?? '-' }}</div>
                </div>

                <div class="rounded-lg bg-gradient-to-br from-indigo-50 to-indigo-100/50 dark:from-indigo-900/20 dark:to-indigo-900/10 p-3 border border-indigo-200 dark:border-indigo-800">
                    <div class="text-[10px] text-indigo-700 dark:text-indigo-400 uppercase tracking-wider font-semibold mb-1">Model</div>
                    <div class="text-sm font-bold text-zinc-800 dark:text-white truncate">{{ $scan->model->model_name ?? '-' }}</div>
                </div>

                <div class="rounded-lg bg-gradient-to-br from-violet-50 to-purple-100/50 dark:from-violet-900/20 dark:to-purple-900/10 p-3 border border-violet-200 dark:border-violet-800">
                    <div class="text-[10px] text-violet-700 dark:text-violet-400 uppercase tracking-wider font-semibold mb-1">PCB Type</div>
                    <div class="text-sm font-bold">
                        @if($scan->pcb_type === 'SINGLE')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-violet-100 text-violet-700 dark:bg-violet-900/40 dark:text-violet-300">SINGLE</span>
                        @elseif($scan->pcb_type === 'LH')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">LH</span>
                        @elseif($scan->pcb_type === 'RH')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">RH</span>
                        @else
                            <span class="text-zinc-400 italic">-</span>
                        @endif
                    </div>
                </div>

                <div class="rounded-lg bg-gradient-to-br from-fuchsia-50 to-pink-100/50 dark:from-fuchsia-900/20 dark:to-pink-900/10 p-3 border border-fuchsia-200 dark:border-fuchsia-800">
                    <div class="text-[10px] text-fuchsia-700 dark:text-fuchsia-400 uppercase tracking-wider font-semibold mb-1">Phase</div>
                    <div class="text-sm font-bold">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold {{ $currentPhase['color'] }}">
                            {{ strtoupper($scan->phase ?? 'first') }}
                        </span>
                    </div>
                </div>

                {{-- ✅ SHIFT & GROUP — GABUNG 1 CARD --}}
                <div class="rounded-lg bg-gradient-to-br from-cyan-50 via-purple-50 to-purple-100/50 dark:from-cyan-900/20 dark:via-purple-900/20 dark:to-purple-900/10 p-3 border border-cyan-200 dark:border-cyan-800">
                    <div class="text-[10px] text-cyan-700 dark:text-cyan-400 uppercase tracking-wider font-semibold mb-1">Shift / Group</div>
                    <div class="flex items-center gap-1.5 flex-wrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-cyan-100 text-cyan-700 dark:bg-cyan-900/40 dark:text-cyan-300">
                            {{ $scan->shift }}
                        </span>
                        <span class="text-zinc-400 font-bold text-xs">/</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300">
                            {{ $scan->group }}
                        </span>
                    </div>
                </div>

                <div class="rounded-lg bg-gradient-to-br from-emerald-50 to-emerald-100/50 dark:from-emerald-900/20 dark:to-emerald-900/10 p-3 border border-emerald-200 dark:border-emerald-800">
                    <div class="text-[10px] text-emerald-700 dark:text-emerald-400 uppercase tracking-wider font-semibold mb-1">Line</div>
                    <div class="text-sm font-bold text-zinc-800 dark:text-white truncate">
                        {{ $scan->masterLine->location->location_name ?? '-' }} — L{{ $scan->masterLine->line_number ?? '-' }}
                    </div>
                </div>

                <div class="rounded-lg bg-gradient-to-br from-amber-50 to-amber-100/50 dark:from-amber-900/20 dark:to-amber-900/10 p-3 border border-amber-200 dark:border-amber-800">
                    <div class="text-[10px] text-amber-700 dark:text-amber-400 uppercase tracking-wider font-semibold mb-1">Lot Qty</div>
                    <div class="text-sm font-bold font-mono text-zinc-800 dark:text-white">{{ number_format($scan->lot_qty) }}</div>
                </div>

                <div class="rounded-lg bg-gradient-to-br from-zinc-50 to-zinc-100/50 dark:from-zinc-800/50 dark:to-zinc-800/20 p-3 border border-zinc-200 dark:border-zinc-700">
                    <div class="text-[10px] text-zinc-600 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1">PIC X-RAY</div>
                    <div class="text-sm font-semibold text-zinc-800 dark:text-white truncate">{{ $scan->creator->name ?? '-' }}</div>
                </div>

                <div class="rounded-lg bg-gradient-to-br from-zinc-50 to-zinc-100/50 dark:from-zinc-800/50 dark:to-zinc-800/20 p-3 border border-zinc-200 dark:border-zinc-700">
                    <div class="text-[10px] text-zinc-600 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1">DATE</div>
                    <div class="text-sm font-semibold text-zinc-800 dark:text-white">{{ $scan->created_at?->format('d M Y, H:i') }}</div>
                </div>
                {{-- ✅ STATUS RUNNING --}}
                <div class="rounded-lg bg-gradient-to-br from-teal-50 to-cyan-100/50 dark:from-teal-900/20 dark:to-cyan-900/10 p-3 border border-teal-200 dark:border-teal-800">
                    <div class="text-[10px] text-teal-700 dark:text-teal-400 uppercase tracking-wider font-semibold mb-1">Status Running</div>
                    <div class="text-sm font-bold">
                        @if($scan->status_running)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-xs font-semibold
                                {{ strtolower($scan->status_running) === 'running'
                                    ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'
                                    : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ strtolower($scan->status_running) === 'running' ? 'bg-emerald-500 animate-pulse' : 'bg-zinc-400' }}"></span>
                                {{ $scan->status_running }}
                            </span>
                        @else
                            <span class="text-zinc-400 italic">-</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== PIECE ITEMS ==================== --}}
    @if($hasAnyGroup)
        @if($firstFilled)
            @include('livewire.qaqc.scan-xray.partials.piece-items-form', [
                'key' => 'first_piece_items', 'label' => 'First Piece Items',
                'items' => $scan->first_piece_items ?? [], 'readonly' => true,
                'activeSide' => $scan->active_side,
                'minRows' => 3,
            ])
        @endif

        @if($secondFirstFilled)
            @include('livewire.qaqc.scan-xray.partials.second-piece-form', [
                'key' => 'second_first_items', 'label' => 'Second Piece — First (Verification)',
                'items' => $scan->second_first_items ?? [], 'readonly' => true,
                'activeSide' => $scan->active_side,
                'minRows' => 3,
            ])
        @endif

        @if($middleFilled)
            @include('livewire.qaqc.scan-xray.partials.piece-items-form', [
                'key' => 'middle_piece_items', 'label' => 'Middle Piece Items',
                'items' => $scan->middle_piece_items ?? [], 'readonly' => true,
                'activeSide' => $scan->active_side,
                'minRows' => 4,
            ])
        @endif

        @if($secondMiddleFilled)
            @include('livewire.qaqc.scan-xray.partials.second-piece-form', [
                'key' => 'second_middle_items', 'label' => 'Second Piece — Middle (Verification)',
                'items' => $scan->second_middle_items ?? [], 'readonly' => true,
                'activeSide' => $scan->active_side,
                'minRows' => 4,
            ])
        @endif

        @if($lastFilled)
            @include('livewire.qaqc.scan-xray.partials.piece-items-form', [
                'key' => 'last_piece_items', 'label' => 'Last Piece Items',
                'items' => $scan->last_piece_items ?? [], 'readonly' => true,
                'activeSide' => $scan->active_side,
                'minRows' => 3,
            ])
        @endif

        @if($secondLastFilled)
            @include('livewire.qaqc.scan-xray.partials.second-piece-form', [
                'key' => 'second_last_items', 'label' => 'Second Piece — Last (Verification)',
                'items' => $scan->second_last_items ?? [], 'readonly' => true,
                'activeSide' => $scan->active_side,
                'minRows' => 3,
            ])
        @endif
    @else
        <div class="rounded-2xl border-2 border-dashed border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-12">
            <div class="flex flex-col items-center gap-3 text-center">
                <div class="w-16 h-16 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-zinc-400">
                        <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-800 dark:text-white mb-1">Belum Ada Data Inspeksi</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Belum ada piece items yang diisi untuk scan x-ray ini.</p>
                </div>
            </div>
        </div>
    @endif
</div>