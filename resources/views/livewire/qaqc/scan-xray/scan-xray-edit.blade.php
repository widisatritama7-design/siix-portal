<div class="p-1 space-y-2">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">QA/QC</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('qaqc.scan-xray.index') }}" wire:navigate separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">Scan X-Ray</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">Edit</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    @php
        $phaseLabels = [
            'middle'        => ['label' => 'Phase 2: Middle Piece',           'color' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300'],
            'second_first'  => ['label' => 'Phase 2: Second Piece (First)',   'color' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'],
            'last'          => ['label' => 'Phase 3: Last Piece',             'color' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300'],
            'second_middle' => ['label' => 'Phase 3: Second Piece (Middle)',  'color' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'],
            'second_last'   => ['label' => 'Phase 4: Second Piece (Last)',    'color' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'],
        ];
        $currentPhase = $phaseLabels[$phase] ?? ['label' => 'Edit', 'color' => 'bg-zinc-100 text-zinc-700'];

        // NG Detail bisa diedit kalau phase = second_*
        $ngEditableFirst  = ($phase === 'second_first');
        $ngEditableMiddle = ($phase === 'second_middle');
        $ngEditableLast   = ($phase === 'second_last');
    @endphp

    <div class="flex items-center gap-3 mt-2">
        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">Edit Scan X-Ray</h1>
        <span class="inline-flex items-center px-3 py-1 rounded-lg {{ $currentPhase['color'] }} text-xs font-bold">
            {{ $currentPhase['label'] }}
        </span>
    </div>

    {{-- INFO BANNER — STICKY (iOS Glass Effect) --}}
    <div class="sticky top-25 z-30 relative rounded-xl overflow-hidden border border-white/40 dark:border-white/10 shadow-lg shadow-black/5">
        {{-- Layer 1: Gradient transparan (untuk warna) --}}
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-100/70 via-purple-100/60 to-indigo-100/70 dark:from-indigo-900/40 dark:via-purple-900/30 dark:to-indigo-900/40"></div>

        {{-- Layer 2: Blur + frosted glass --}}
        <div class="absolute inset-0 backdrop-blur-2xl backdrop-saturate-150 bg-white/40 dark:bg-zinc-900/30"></div>

        {{-- Layer 3: Konten --}}
        <div class="relative p-4 flex items-start gap-3">
            <div class="w-9 h-9 rounded-full bg-indigo-500 flex items-center justify-center flex-shrink-0 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                @if($phase === 'middle')
                    <p class="text-sm font-bold text-indigo-900 dark:text-indigo-100">Isi Middle Piece Items sekarang</p>
                    <p class="text-xs text-indigo-800 dark:text-indigo-200 mt-0.5">
                        Setelah save, Anda bisa lanjut isi Last Piece Items via Edit kembali.
                    </p>
                @elseif($phase === 'second_first')
                    <p class="text-sm font-bold text-emerald-900 dark:text-emerald-100">Second Piece (First) — Verifikasi ulang</p>
                    <p class="text-xs text-emerald-800 dark:text-emerald-200 mt-0.5">
                        Isi NG Detail First Piece terlebih dahulu (wajib), lalu isi Second Piece. Setelah save, lanjut ke Middle Piece.
                    </p>
                @elseif($phase === 'last')
                    <p class="text-sm font-bold text-indigo-900 dark:text-indigo-100">Isi Last Piece Items — phase terakhir</p>
                    <p class="text-xs text-indigo-800 dark:text-indigo-200 mt-0.5">
                        Setelah save, data akan ditandai Completed (kalau tidak ada NG) atau lanjut Second Piece.
                    </p>
                @elseif($phase === 'second_middle')
                    <p class="text-sm font-bold text-emerald-900 dark:text-emerald-100">Second Piece (Middle) — Verifikasi ulang</p>
                    <p class="text-xs text-emerald-800 dark:text-emerald-200 mt-0.5">
                        Isi NG Detail Middle Piece terlebih dahulu (wajib), lalu isi Second Piece. Setelah save, lanjut ke Last Piece.
                    </p>
                @elseif($phase === 'second_last')
                    <p class="text-sm font-bold text-emerald-900 dark:text-emerald-100">Second Piece (Last) — Verifikasi ulang</p>
                    <p class="text-xs text-emerald-800 dark:text-emerald-200 mt-0.5">
                        Isi NG Detail Last Piece terlebih dahulu (wajib), lalu isi Second Piece. Setelah save, selesai (Completed).
                    </p>
                @else
                    <p class="text-sm font-bold text-indigo-900 dark:text-indigo-100">Lanjutkan phase selanjutnya</p>
                    <p class="text-xs text-indigo-800 dark:text-indigo-200 mt-0.5">
                        Isi grup yang aktif dan klik Save untuk melanjutkan.
                    </p>
                @endif
            </div>
        </div>
    </div>

    <form wire:submit="update" class="space-y-6">
        @include('livewire.qaqc.scan-xray.partials.header-form')

        {{-- ==================== FIRST PIECE ==================== --}}
        @if($this->isGroupCompleted('first_piece_items'))
            @include('livewire.qaqc.scan-xray.partials.piece-items-form', [
                'key' => 'first_piece_items', 'label' => 'First Piece Items (Completed)',
                'items' => $first_piece_items, 'readonly' => true,
                'ngEditable' => $ngEditableFirst,
                'activeSide' => $activeSide,
                'minRows' => \App\Models\QAQC\ScanXray\ScanXray::standardRows('first_piece_items'),
            ])
        @elseif($this->canEditGroup('first_piece_items'))
            @include('livewire.qaqc.scan-xray.partials.piece-items-form', [
                'key' => 'first_piece_items', 'label' => 'First Piece Items',
                'items' => $first_piece_items, 'readonly' => false,
                'ngEditable' => true,
                'activeSide' => $activeSide,
                'minRows' => \App\Models\QAQC\ScanXray\ScanXray::standardRows('first_piece_items'),
            ])
        @endif

        {{-- ==================== SECOND FIRST ==================== --}}
        @php
            // Cek apakah Second First sudah pernah diisi
            $secondFirstFilled = false;
            if (!empty($second_first_items)) {
                $sfSide = $activeSide;
                if ($sfSide && isset($second_first_items[$sfSide])) {
                    foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $sfCol) {
                        foreach (($second_first_items[$sfSide][$sfCol] ?? []) as $sfVal) {
                            if (!empty($sfVal)) { $secondFirstFilled = true; break 2; }
                        }
                    }
                }
            }
        @endphp

        @if($phase === 'second_first' && ($first_piece_items['ng_qty'] ?? 0) > 0)
            {{-- Mode aktif --}}
            @include('livewire.qaqc.scan-xray.partials.second-piece-form', [
                'key' => 'second_first_items', 'label' => 'Second Piece — First',
                'items' => $second_first_items, 'readonly' => false,
                'activeSide' => $activeSide,
                'minRows' => \App\Models\QAQC\ScanXray\ScanXray::standardRows('second_first_items'),
            ])
        @elseif($secondFirstFilled)
            {{-- History readonly --}}
            @include('livewire.qaqc.scan-xray.partials.second-piece-form', [
                'key' => 'second_first_items', 'label' => 'Second Piece — First (Completed)',
                'items' => $second_first_items, 'readonly' => true,
                'activeSide' => $activeSide,
                'minRows' => \App\Models\QAQC\ScanXray\ScanXray::standardRows('second_first_items'),
            ])
        @endif

        {{-- ==================== MIDDLE PIECE ==================== --}}
        @if($this->isGroupCompleted('middle_piece_items'))
            @include('livewire.qaqc.scan-xray.partials.piece-items-form', [
                'key' => 'middle_piece_items', 'label' => 'Middle Piece Items (Completed)',
                'items' => $middle_piece_items, 'readonly' => true,
                'ngEditable' => $ngEditableMiddle,
                'activeSide' => $activeSide,
                'minRows' => \App\Models\QAQC\ScanXray\ScanXray::standardRows('middle_piece_items'),
            ])
        @elseif($this->canEditGroup('middle_piece_items'))
            @include('livewire.qaqc.scan-xray.partials.piece-items-form', [
                'key' => 'middle_piece_items', 'label' => 'Middle Piece Items',
                'items' => $middle_piece_items, 'readonly' => false,
                'ngEditable' => true,
                'activeSide' => $activeSide,
                'minRows' => \App\Models\QAQC\ScanXray\ScanXray::standardRows('middle_piece_items'),
            ])
        @elseif($this->isGroupLocked('middle_piece_items'))
            @include('livewire.qaqc.scan-xray.partials.phase-locked', [
                'label' => 'Middle Piece Items',
                'note'  => 'Bisa diisi setelah First Piece / Second Piece (First) disimpan.',
            ])
        @endif

        {{-- ==================== SECOND MIDDLE ==================== --}}
        @php
            $secondMiddleFilled = false;
            if (!empty($second_middle_items)) {
                $smSide = $activeSide;
                if ($smSide && isset($second_middle_items[$smSide])) {
                    foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $smCol) {
                        foreach (($second_middle_items[$smSide][$smCol] ?? []) as $smVal) {
                            if (!empty($smVal)) { $secondMiddleFilled = true; break 2; }
                        }
                    }
                }
            }
        @endphp

        @if($phase === 'second_middle' && ($middle_piece_items['ng_qty'] ?? 0) > 0)
            @include('livewire.qaqc.scan-xray.partials.second-piece-form', [
                'key' => 'second_middle_items', 'label' => 'Second Piece — Middle',
                'items' => $second_middle_items, 'readonly' => false,
                'activeSide' => $activeSide,
                'minRows' => \App\Models\QAQC\ScanXray\ScanXray::standardRows('second_middle_items'),
            ])
        @elseif($secondMiddleFilled)
            @include('livewire.qaqc.scan-xray.partials.second-piece-form', [
                'key' => 'second_middle_items', 'label' => 'Second Piece — Middle (Completed)',
                'items' => $second_middle_items, 'readonly' => true,
                'activeSide' => $activeSide,
                'minRows' => \App\Models\QAQC\ScanXray\ScanXray::standardRows('second_middle_items'),
            ])
        @endif

        {{-- ==================== LAST PIECE ==================== --}}
        @if($this->isGroupCompleted('last_piece_items'))
            @include('livewire.qaqc.scan-xray.partials.piece-items-form', [
                'key' => 'last_piece_items', 'label' => 'Last Piece Items (Completed)',
                'items' => $last_piece_items, 'readonly' => true,
                'ngEditable' => $ngEditableLast,
                'activeSide' => $activeSide,
                'minRows' => \App\Models\QAQC\ScanXray\ScanXray::standardRows('last_piece_items'),
            ])
        @elseif($this->canEditGroup('last_piece_items'))
            @include('livewire.qaqc.scan-xray.partials.piece-items-form', [
                'key' => 'last_piece_items', 'label' => 'Last Piece Items',
                'items' => $last_piece_items, 'readonly' => false,
                'ngEditable' => true,
                'activeSide' => $activeSide,
                'minRows' => \App\Models\QAQC\ScanXray\ScanXray::standardRows('last_piece_items'),
            ])
        @elseif($this->isGroupLocked('last_piece_items'))
            @include('livewire.qaqc.scan-xray.partials.phase-locked', [
                'label' => 'Last Piece Items',
                'note'  => 'Bisa diisi setelah Middle Piece / Second Piece (Middle) disimpan.',
            ])
        @endif

        {{-- ==================== SECOND LAST ==================== --}}
        @php
            $secondLastFilled = false;
            if (!empty($second_last_items)) {
                $slSide = $activeSide;
                if ($slSide && isset($second_last_items[$slSide])) {
                    foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $slCol) {
                        foreach (($second_last_items[$slSide][$slCol] ?? []) as $slVal) {
                            if (!empty($slVal)) { $secondLastFilled = true; break 2; }
                        }
                    }
                }
            }
        @endphp

        @if($phase === 'second_last' && ($last_piece_items['ng_qty'] ?? 0) > 0)
            @include('livewire.qaqc.scan-xray.partials.second-piece-form', [
                'key' => 'second_last_items', 'label' => 'Second Piece — Last',
                'items' => $second_last_items, 'readonly' => false,
                'activeSide' => $activeSide,
                'minRows' => \App\Models\QAQC\ScanXray\ScanXray::standardRows('second_last_items'),
            ])
        @elseif($secondLastFilled)
            @include('livewire.qaqc.scan-xray.partials.second-piece-form', [
                'key' => 'second_last_items', 'label' => 'Second Piece — Last (Completed)',
                'items' => $second_last_items, 'readonly' => true,
                'activeSide' => $activeSide,
                'minRows' => \App\Models\QAQC\ScanXray\ScanXray::standardRows('second_last_items'),
            ])
        @endif

        <div class="flex justify-start gap-2">
            <flux:button href="{{ route('qaqc.scan-xray.index') }}" wire:navigate variant="filled">Cancel</flux:button>
            <flux:button type="submit" variant="primary" class="bg-blue-600 hover:bg-blue-700"
                wire:loading.attr="disabled" wire:target="update">
                <span wire:loading.remove wire:target="update">Save</span>
                <span wire:loading wire:target="update">Updating...</span>
            </flux:button>
        </div>
    </form>

    @include('livewire.qaqc.scan-xray.partials.notify')
    @include('livewire.qaqc.scan-xray.partials.error-modal')

</div>