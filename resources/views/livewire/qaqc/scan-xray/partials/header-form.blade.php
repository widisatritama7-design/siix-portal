<flux:card class="p-6">
    <h3 class="font-bold mb-4">Header Information</h3>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

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
            <flux:select wire:model.live="model_id" placeholder="-- Select Model --" :disabled="!$customer_id">
                <flux:select.option value="">-- Select Model --</flux:select.option>
                @foreach($models as $mdl)
                    <flux:select.option value="{{ $mdl->id }}">{{ $mdl->model_name }}</flux:select.option>
                @endforeach
            </flux:select>
            @error('model_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        {{-- PCB TYPE --}}
        <div>
            <flux:label required>PCB Type</flux:label>

            @if(empty($pcbTypeOptions))
                <div class="min-h-[42px] px-3 py-2 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50 flex items-center">
                    <span class="text-zinc-400 italic text-sm">Pilih Model dulu</span>
                </div>
            @elseif(count($pcbTypeOptions) === 1)
                @php $single = $pcbTypeOptions[0]; @endphp
                <div class="min-h-[42px] px-3 py-2 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50 flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold
                        {{ $single === 'SINGLE' ? 'bg-violet-100 text-violet-700 dark:bg-violet-900/40 dark:text-violet-300' : '' }}
                        {{ $single === 'LH' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : '' }}
                        {{ $single === 'RH' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : '' }}">
                        {{ $single }}
                    </span>
                    <span class="text-[10px] text-zinc-500 italic">(otomatis dari model)</span>
                </div>
            @else
                <flux:select wire:model.live="pcb_type" placeholder="-- Pilih PCB Type --">
                    <flux:select.option value="">-- Pilih PCB Type --</flux:select.option>
                    @foreach($pcbTypeOptions as $opt)
                        <flux:select.option value="{{ $opt }}">{{ $opt }}</flux:select.option>
                    @endforeach
                </flux:select>
            @endif

            @error('pcb_type') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
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

        {{-- LINE — 2 kolom --}}
        <div class="md:col-span-2">
            <flux:label required>Line</flux:label>
            @php
                $selectedLine = $master_line_id ? \App\Models\MTC\Master\MasterLine::with('location')->find($master_line_id) : null;
            @endphp
            <div class="flex gap-2">
                <div class="flex-1 text-sm px-3 py-2 rounded-lg border
                    {{ $master_line_id ? 'border-blue-300 bg-blue-50 dark:bg-blue-900/20 dark:border-blue-700' : 'border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900' }}
                    text-zinc-700 dark:text-zinc-300 flex items-center gap-2 min-h-[42px]">
                    @if($selectedLine)
                        <span class="font-medium truncate">{{ $selectedLine->location->location_name ?? '-' }} — L{{ $selectedLine->line_number }}</span>
                    @else
                        <span class="text-zinc-400 italic">Belum dipilih</span>
                    @endif
                </div>
                <button type="button" wire:click="toggleMasterLinePanel"
                    class="px-3 py-2 text-sm rounded-lg transition whitespace-nowrap inline-flex items-center gap-1.5 font-semibold
                        {{ $openMasterLinePanel ? 'bg-zinc-600 text-white' : 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white' }}">
                    {{ $openMasterLinePanel ? 'Tutup' : 'Pilih' }}
                </button>
                @if($master_line_id)
                    <button type="button" wire:click="clearMasterLine"
                        class="px-3 py-2 text-sm bg-red-500 text-white rounded-lg hover:bg-red-600 font-semibold">✕</button>
                @endif
            </div>
            @error('master_line_id') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
        </div>
    </div>

    {{-- INLINE PANEL MASTER LINE --}}
    @if($openMasterLinePanel)
        @php $masterLineList = $this->getMasterLineList(); @endphp
        <div class="mt-4 rounded-xl overflow-hidden border border-blue-300 dark:border-blue-700 bg-white dark:bg-zinc-900 shadow-lg">
            <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 border-b border-blue-200 dark:border-blue-800">
                <flux:input wire:model.live.debounce.300ms="masterLineSearch"
                    placeholder="Cari location / line number..." icon="magnifying-glass" clearable />
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="bg-zinc-100 dark:bg-zinc-800/80 border-b border-zinc-200 dark:border-zinc-700">
                            <th class="px-3 py-2.5 text-left font-semibold text-zinc-600 uppercase text-[10px]">Location</th>
                            <th class="px-3 py-2.5 text-left font-semibold text-zinc-600 uppercase text-[10px]">Line Number</th>
                            <th class="px-3 py-2.5 text-center font-semibold text-zinc-600 uppercase text-[10px] w-20">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @forelse($masterLineList as $line)
                            <tr class="hover:bg-blue-50 dark:hover:bg-blue-900/20 cursor-pointer" wire:click="selectMasterLine({{ $line->id }})">
                                <td class="px-3 py-2 font-semibold">{{ $line->location->location_name ?? '-' }}</td>
                                <td class="px-3 py-2 font-mono">Line {{ $line->line_number }}</td>
                                <td class="px-3 py-2 text-center">
                                    <button type="button" wire:click.stop="selectMasterLine({{ $line->id }})"
                                        class="px-3 py-1 text-[10px] bg-blue-600 text-white rounded-md font-semibold">Pilih</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-3 py-6 text-center text-zinc-500">No Master Line found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($masterLineList->hasPages())
                <div class="px-3 py-2.5 border-t border-zinc-200 flex justify-between items-center bg-zinc-50 dark:bg-zinc-800/50">
                    <span class="text-[10px] text-zinc-500 font-semibold">
                        {{ $masterLineList->firstItem() ?? 0 }} - {{ $masterLineList->lastItem() ?? 0 }} of {{ $masterLineList->total() }}
                    </span>
                    <div class="flex gap-1">
                        @if(!$masterLineList->onFirstPage())
                            <button type="button" wire:click="setMasterLinePage({{ $masterLineList->currentPage() - 1 }})"
                                class="px-2.5 py-1 text-[10px] rounded-md bg-white dark:bg-zinc-800 border font-semibold">Prev</button>
                        @endif
                        <span class="px-2.5 py-1 text-[10px] font-semibold">{{ $masterLineList->currentPage() }} / {{ $masterLineList->lastPage() }}</span>
                        @if($masterLineList->hasMorePages())
                            <button type="button" wire:click="setMasterLinePage({{ $masterLineList->currentPage() + 1 }})"
                                class="px-2.5 py-1 text-[10px] rounded-md bg-white dark:bg-zinc-800 border font-semibold">Next</button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    @endif
</flux:card>