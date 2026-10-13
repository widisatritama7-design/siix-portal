<div class="p-1 space-y-2">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">QA/QC</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('qaqc.scan-xray.index') }}" wire:navigate separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">Scan X-Ray</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">Create</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex items-center gap-3 mt-2">
        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">Create Scan X-Ray</h1>
        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 text-xs font-bold">
            Phase 1: First Piece
        </span>
    </div>

    {{-- INFO BANNER --}}
    <div class="rounded-xl border border-blue-300 dark:border-blue-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/40 dark:to-indigo-950/40 p-4 flex items-start gap-3">
        <div class="w-9 h-9 rounded-full bg-blue-500 flex items-center justify-center flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-sm font-bold text-blue-900 dark:text-blue-100">Isi First Piece Items terlebih dahulu</p>
            <p class="text-xs text-blue-800 dark:text-blue-200 mt-0.5">
                Setelah save, Anda bisa lanjut isi Middle Piece Items via tombol Edit di halaman Index.
            </p>
        </div>
    </div>

    <form wire:submit="save" class="space-y-6">
        @include('livewire.qaqc.scan-xray.partials.header-form')

        {{-- FIRST PIECE (AKTIF) --}}
        @include('livewire.qaqc.scan-xray.partials.piece-items-form', [
            'key' => 'first_piece_items', 'label' => 'First Piece Items',
            'items' => $first_piece_items, 'readonly' => false,
            'activeSide' => $activeSide,
            'minRows' => \App\Models\QAQC\ScanXray\ScanXray::standardRows('first_piece_items'),
        ])

        {{-- MIDDLE (LOCKED) --}}
        @include('livewire.qaqc.scan-xray.partials.phase-locked', [
            'label' => 'Middle Piece Items',
            'note'  => 'Bisa diisi setelah First Piece disimpan.',
        ])

        {{-- LAST (LOCKED) --}}
        @include('livewire.qaqc.scan-xray.partials.phase-locked', [
            'label' => 'Last Piece Items',
            'note'  => 'Bisa diisi setelah Middle Piece disimpan.',
        ])

        <div class="flex justify-start gap-2">
            <flux:button href="{{ route('qaqc.scan-xray.index') }}" wire:navigate variant="filled">Cancel</flux:button>
            <flux:button type="submit" variant="primary" class="bg-blue-600 hover:bg-blue-700"
                wire:loading.attr="disabled" wire:target="save">
                <span wire:loading.remove wire:target="save">Save First Piece</span>
                <span wire:loading wire:target="save">Saving...</span>
            </flux:button>
        </div>
    </form>

    @include('livewire.qaqc.scan-xray.partials.notify')
    @include('livewire.qaqc.scan-xray.partials.error-modal')
    
</div>