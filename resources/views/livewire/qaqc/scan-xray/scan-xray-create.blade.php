<div class="p-1 space-y-2">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">QA/QC</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('qaqc.scan-xray.index') }}" wire:navigate separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">Scan X-Ray</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">Create</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">Create Scan X-Ray</h1>

    <form wire:submit="save" class="space-y-6">
        <flux:card class="p-6">
            <h3 class="font-bold mb-4">Header Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- CUSTOMER --}}
                <div>
                    <flux:label required>Customer</flux:label>
                    <flux:select wire:model.live="customer_id" placeholder="-- Select Customer --">
                        <flux:select.option value="">-- Select Customer --</flux:select.option>
                        @foreach($customers as $cust)
                            <flux:select.option value="{{ $cust->id }}">{{ $cust->customer_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    @error('customer_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- MODEL --}}
                <div>
                    <flux:label required>Model</flux:label>
                    <flux:select wire:model="model_id" placeholder="-- Select Model --" :disabled="!$customer_id">
                        <flux:select.option value="">-- Select Model --</flux:select.option>
                        @foreach($models as $mdl)
                            <flux:select.option value="{{ $mdl->id }}">{{ $mdl->model_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    @error('model_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- SHIFT --}}
                <div>
                    <flux:label required>Shift</flux:label>
                    <flux:select wire:model="shift" placeholder="-- Select Shift --">
                        <flux:select.option value="">-- Select Shift --</flux:select.option>
                        @foreach($shiftOptions as $opt)
                            <flux:select.option value="{{ $opt }}">{{ $opt }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    @error('shift') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- GROUP --}}
                <div>
                    <flux:label required>Group</flux:label>
                    <flux:select wire:model="group" placeholder="-- Select Group --">
                        <flux:select.option value="">-- Select Group --</flux:select.option>
                        @foreach($groupOptions as $opt)
                            <flux:select.option value="{{ $opt }}">{{ $opt }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    @error('group') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- LOT QTY --}}
                <div>
                    <flux:label required>Lot Qty</flux:label>
                    <flux:input type="number" wire:model="lot_qty" min="0" />
                    @error('lot_qty') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- LINE (display + button, sejajar Group & Lot Qty) --}}
                <div>
                    <flux:label required>Line</flux:label>

                    @php
                        $selectedLine = $master_line_id ? \App\Models\MTC\Master\MasterLine::with('location')->find($master_line_id) : null;
                    @endphp

                    <div class="flex gap-2">
                        <div class="flex-1 text-sm px-3 py-2 rounded-lg border
                            {{ $master_line_id ? 'border-blue-300 bg-blue-50 dark:bg-blue-900/20 dark:border-blue-700' : 'border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900' }}
                            text-zinc-700 dark:text-zinc-300 flex items-center gap-2 min-h-[42px]">
                            @if($selectedLine)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 flex-shrink-0">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium truncate">
                                    {{ $selectedLine->location->location_name ?? '-' }} — L{{ $selectedLine->line_number }}
                                </span>
                            @else
                                <span class="text-zinc-400 italic">Belum dipilih</span>
                            @endif
                        </div>

                        <button type="button"
                            wire:click="toggleMasterLinePanel"
                            class="px-3 py-2 text-sm rounded-lg transition whitespace-nowrap inline-flex items-center gap-1.5 font-semibold
                                {{ $openMasterLinePanel
                                    ? 'bg-zinc-600 hover:bg-zinc-700 text-white'
                                    : 'bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white shadow-sm hover:shadow-md' }}">
                            @if($openMasterLinePanel)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                    <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                </svg>
                            @endif
                            {{ $openMasterLinePanel ? 'Tutup' : 'Pilih' }}
                        </button>

                        @if($master_line_id)
                            <button type="button"
                                wire:click="clearMasterLine"
                                class="px-3 py-2 text-sm bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482 41.03 41.03 0 0 0-2.365-.298V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @endif
                    </div>
                    @error('master_line_id') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                </div>

            </div>

            {{-- ==================== INLINE PANEL MASTER LINE (FULL WIDTH DI BAWAH) ==================== --}}
            @if($openMasterLinePanel)
                @php $masterLineList = $this->getMasterLineList(); @endphp

                <div class="mt-4 rounded-xl overflow-hidden border border-blue-300 dark:border-blue-700 bg-white dark:bg-zinc-900 shadow-lg">
                    {{-- SEARCH --}}
                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 border-b border-blue-200 dark:border-blue-800">
                        <flux:input
                            wire:model.live.debounce.300ms="masterLineSearch"
                            placeholder="Cari location / line number..."
                            icon="magnifying-glass"
                            clearable />
                    </div>

                    {{-- TABLE --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs">
                            <thead>
                                <tr class="bg-zinc-100 dark:bg-zinc-800/80 border-b border-zinc-200 dark:border-zinc-700">
                                    <th class="px-3 py-2.5 text-left font-semibold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider text-[10px]">Location</th>
                                    <th class="px-3 py-2.5 text-left font-semibold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider text-[10px]">Line Number</th>
                                    <th class="px-3 py-2.5 text-center font-semibold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider text-[10px] w-20">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                @forelse($masterLineList as $line)
                                    <tr class="hover:bg-blue-50 dark:hover:bg-blue-900/20 cursor-pointer transition-colors"
                                        wire:click="selectMasterLine({{ $line->id }})">
                                        <td class="px-3 py-2 font-semibold text-zinc-800 dark:text-zinc-200">
                                            {{ $line->location->location_name ?? '-' }}
                                        </td>
                                        <td class="px-3 py-2 text-zinc-700 dark:text-zinc-300 font-mono">
                                            Line {{ $line->line_number }}
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            <button type="button"
                                                wire:click.stop="selectMasterLine({{ $line->id }})"
                                                class="px-3 py-1 text-[10px] bg-blue-600 text-white rounded-md hover:bg-blue-700 transition font-semibold">
                                                Pilih
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-3 py-8 text-center text-zinc-500">
                                            <div class="flex flex-col items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-zinc-300 dark:text-zinc-600">
                                                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="text-sm">No Master Line found</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    @if($masterLineList->hasPages())
                        <div class="px-3 py-2.5 border-t border-zinc-200 dark:border-zinc-700 flex items-center justify-between bg-zinc-50 dark:bg-zinc-800/50">
                            <div class="text-[10px] text-zinc-500 font-semibold">
                                {{ $masterLineList->firstItem() ?? 0 }} - {{ $masterLineList->lastItem() ?? 0 }} of {{ $masterLineList->total() }}
                            </div>
                            <div class="flex gap-1">
                                @if($masterLineList->onFirstPage())
                                    <span class="px-2.5 py-1 text-[10px] rounded-md bg-zinc-200 dark:bg-zinc-700 text-zinc-400 cursor-not-allowed font-semibold">Prev</span>
                                @else
                                    <button type="button"
                                        wire:click="setMasterLinePage({{ $masterLineList->currentPage() - 1 }})"
                                        class="px-2.5 py-1 text-[10px] rounded-md bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-700 font-semibold">
                                        Prev
                                    </button>
                                @endif

                                <span class="px-2.5 py-1 text-[10px] text-zinc-600 dark:text-zinc-400 font-semibold">
                                    {{ $masterLineList->currentPage() }} / {{ $masterLineList->lastPage() }}
                                </span>

                                @if($masterLineList->hasMorePages())
                                    <button type="button"
                                        wire:click="setMasterLinePage({{ $masterLineList->currentPage() + 1 }})"
                                        class="px-2.5 py-1 text-[10px] rounded-md bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-700 font-semibold">
                                        Next
                                    </button>
                                @else
                                    <span class="px-2.5 py-1 text-[10px] rounded-md bg-zinc-200 dark:bg-zinc-700 text-zinc-400 cursor-not-allowed font-semibold">Next</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </flux:card>

        @include('livewire.qaqc.scan-xray.partials.piece-items-form', [
            'key' => 'first_piece_items', 'label' => 'First Piece Items',
            'items' => $first_piece_items, 'readonly' => false,
        ])

        @include('livewire.qaqc.scan-xray.partials.piece-items-form', [
            'key' => 'middle_piece_items', 'label' => 'Middle Piece Items',
            'items' => $middle_piece_items, 'readonly' => false,
        ])

        @include('livewire.qaqc.scan-xray.partials.piece-items-form', [
            'key' => 'last_piece_items', 'label' => 'Last Piece Items',
            'items' => $last_piece_items, 'readonly' => false,
        ])

        {{-- TOMBOL AKSI --}}
        <div class="flex justify-start gap-2">
            <flux:button href="{{ route('qaqc.scan-xray.index') }}" wire:navigate variant="filled">
                Cancel
            </flux:button>
            <flux:button type="submit" variant="primary" class="bg-blue-600 hover:bg-blue-700"
                wire:loading.attr="disabled" wire:target="save">
                <span wire:loading.remove wire:target="save">Save</span>
                <span wire:loading wire:target="save">Saving...</span>
            </flux:button>
        </div>
    </form>

    @include('livewire.qaqc.scan-xray.partials.notify')
</div>