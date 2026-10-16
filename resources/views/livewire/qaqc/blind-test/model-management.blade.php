<div class="p-1 space-y-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            QA/QC
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Master Model
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Master Model
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage model master data
            </p>
        </div>

        @can('create model')
            <div class="flex flex-wrap gap-2">
                <flux:button
                    variant="primary"
                    icon="arrow-up-tray"
                    class="bg-emerald-600 hover:bg-emerald-700"
                    wire:click="resetImport"
                    x-on:click="$dispatch('open-modal-import')"
                >
                    Import CSV
                </flux:button>

                <flux:button
                    variant="primary"
                    icon="plus"
                    class="bg-blue-600 hover:bg-blue-700"
                    wire:click="resetForm"
                    x-on:click="$dispatch('open-modal-model')"
                >
                    Add New Model
                </flux:button>
            </div>
        @endcan
    </div>

    <!-- Search -->
    <div class="flex justify-end">
        <div class="w-full sm:w-80">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search model or customer..."
                icon="magnifying-glass"
                clearable
            />
        </div>
    </div>

    <!-- ==================== TABLE ==================== -->
    <flux:card class="p-0 shadow-lg flex flex-col overflow-hidden">

        {{-- ===== HEADER ===== --}}
        <div class="relative px-6 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-white/10"></div>
            <div class="absolute -right-2 -bottom-8 w-16 h-16 rounded-full bg-white/10"></div>

            <div class="relative flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                            <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                            <path fill-rule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-[10px] text-white/70 uppercase tracking-wider font-semibold">Management</div>
                        <div class="text-base font-bold text-white leading-tight">Model List</div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    @if($search)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                            </svg>
                            {{ $search }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                            All Models
                        </span>
                    @endif

                    <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                            <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clip-rule="evenodd" />
                        </svg>
                        {{ $models->total() }} total
                    </span>
                </div>
            </div>
        </div>

        {{-- ===== BODY ===== --}}
        <div class="p-6 flex flex-col flex-1">
            <div class="overflow-x-auto flex-1">
                <table class="w-full" style="min-width: 1150px; white-space: nowrap;">
                    <thead>
                        <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 50px;">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 180px;">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 260px;">Model Name</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 140px;">PCB Type</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 220px;">Digunakan Di</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 130px;">Created By</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 140px;">Date Create</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 140px;">Date Update</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($models as $index => $model)
                        @php
                            $usage       = $usageMap[$model->id] ?? null;
                            $usedInBlind = $usage['blind_test'] ?? false;
                            $usedInXray  = $usage['scan_xray']  ?? false;
                            $usedInQ     = $usage['question']   ?? false;
                            $isUsed      = $usedInBlind || $usedInXray || $usedInQ;
                        @endphp
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="model-{{ $model->id }}">
                            <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 text-center">
                                {{ $models->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3 text-left">
                                <span class="text-sm font-semibold text-zinc-800 dark:text-white">
                                    {{ $model->customer->customer_name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-left">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-sm font-semibold {{ $isUsed ? 'text-zinc-500 dark:text-zinc-400' : 'text-zinc-800 dark:text-white' }}">
                                        {{ $model->model_name }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-1 flex-wrap">
                                    @forelse(($model->pcb_type ?? []) as $pcb)
                                        <flux:badge size="sm" color="blue">{{ $pcb }}</flux:badge>
                                    @empty
                                        <span class="text-sm text-zinc-400">-</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($usedInBlind || $usedInXray || $usedInQ)
                                    <div class="flex items-center justify-center gap-1 flex-wrap">
                                        @if($usedInBlind)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300"
                                                  title="Dipakai di Blind Test">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Blind Test
                                            </span>
                                        @endif
                                        @if($usedInXray)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300"
                                                  title="Dipakai di Scan X-Ray">
                                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                                Scan X-Ray
                                            </span>
                                        @endif
                                        @if($usedInQ)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-sky-100 text-sky-700 dark:bg-sky-900 dark:text-sky-300"
                                                  title="Dipakai di Master Question">
                                                <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                                                Question
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-zinc-400"></span>
                                        Belum dipakai
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400 text-center">
                                {{ $model->creator->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400 text-center">
                                {{ $model->created_at ? $model->created_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400 text-center">
                                {{ $model->updated_at ? $model->updated_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-1" style="flex-wrap: nowrap;">
                                    @can('view model')
                                    <flux:tooltip content="View" position="top">
                                        <flux:button
                                            wire:click="view({{ $model->id }})"
                                            size="sm"
                                            icon="eye"
                                            variant="primary"
                                            color="blue"
                                            class="!p-2 flex-shrink-0"
                                        />
                                    </flux:tooltip>
                                    @endcan

                                    @can('edit model')
                                        @if(!$isUsed)
                                        <flux:tooltip content="Edit" position="top">
                                            <flux:button
                                                wire:click="edit({{ $model->id }})"
                                                size="sm"
                                                icon="pencil-square"
                                                variant="primary"
                                                color="yellow"
                                                class="!p-2 flex-shrink-0"
                                            />
                                        </flux:tooltip>
                                        @endif
                                    @endcan

                                    @can('delete model')
                                        @if(!$isUsed)
                                        <flux:tooltip content="Delete" position="top">
                                            <flux:button
                                                wire:click="confirmDelete({{ $model->id }})"
                                                size="sm"
                                                icon="trash"
                                                variant="primary"
                                                color="red"
                                                class="!p-2 flex-shrink-0"
                                            />
                                        </flux:tooltip>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center">
                                <div class="flex flex-col items-center justify-center gap-2 py-6">
                                    <div class="w-16 h-16 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                        <flux:icon name="cube" class="w-8 h-8 text-zinc-400 dark:text-zinc-500" />
                                    </div>
                                    <div>
                                        <h3 class="text-base font-medium text-zinc-900 dark:text-white mb-0.5">
                                            No model records found
                                        </h3>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                            {{ $search ? 'Try adjusting your search query' : 'Get started by creating a new model' }}
                                        </p>
                                    </div>
                                    @if($search)
                                        <flux:button wire:click="$set('search', '')" size="sm" class="mt-1">
                                            Clear Search
                                        </flux:button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($models->hasPages())
            <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $models->links() }}
            </div>
            @endif
        </div>
    </flux:card>

    <!-- ==================== MODAL FORM ==================== -->
    <div x-data="{ open: false }"
        x-on:open-modal-model.window="open = true"
        x-on:close-modal-model.window="open = false"
        x-show="open"
        x-cloak
        @keydown.escape.window="open = false">

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                    <form wire:submit="save" id="model-form">
                        <div class="mb-4">
                            <flux:label required>Customer</flux:label>
                            <flux:select wire:model="customer_id" placeholder="Select customer...">
                                @foreach($customers as $customer)
                                    <flux:select.option value="{{ $customer->id }}">{{ $customer->customer_name }}</flux:select.option>
                                @endforeach
                            </flux:select>
                            @error('customer_id')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <flux:label required>Model Name</flux:label>
                            <flux:input
                                wire:model="model_name"
                                type="text"
                                placeholder="Enter model name"
                                class="uppercase"
                            />
                            @error('model_name')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- ===== PCB TYPE ===== --}}
                        <div class="mb-4">
                            <flux:label required>PCB Type</flux:label>

                            @php
                                $isSingle = in_array('SINGLE', $pcb_type ?? [], true);
                                $isLhOrRh = count(array_intersect(['LH','RH'], $pcb_type ?? [])) > 0;
                            @endphp

                            <div class="flex flex-wrap gap-4 mt-2">
                                @foreach($pcbTypeOpts as $value => $label)
                                    @php
                                        $disabled = ($value === 'SINGLE' && $isLhOrRh)
                                                 || ($value !== 'SINGLE' && $isSingle);
                                    @endphp
                                    <label class="inline-flex items-center gap-2 select-none {{ $disabled ? 'opacity-40 cursor-not-allowed' : 'cursor-pointer' }}">
                                        <input
                                            type="checkbox"
                                            wire:model.live="pcb_type"
                                            value="{{ $value }}"
                                            @disabled($disabled)
                                            class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-800 disabled:cursor-not-allowed"
                                        >
                                        <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>

                            @error('pcb_type')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                            @error('pcb_type.*')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror

                            <p class="text-[11px] text-zinc-400 mt-2">
                                Pilih <strong>SINGLE</strong> saja, atau kombinasi <strong>LH</strong> / <strong>RH</strong>.
                            </p>
                        </div>
                    </form>
                </div>

                <div class="p-6 pt-0 flex justify-end gap-2">
                    <button type="button"
                            @click="open = false"
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        form="model-form"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                        wire:loading.attr="disabled"
                        wire:target="save">
                        <span wire:loading.remove wire:target="save">{{ $model_id ? 'Update' : 'Create' }}</span>
                        <span wire:loading wire:target="save">Processing...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL VIEW ==================== -->
    <div x-data="{ open: false }"
        x-on:open-modal-view.window="open = true"
        x-on:close-modal-view.window="open = false"
        x-show="open"
        x-cloak
        @keydown.escape.window="open = false">

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-lg">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Model Detail</h2>

                    @if($viewData)
                    @php
                        $u = $usageMap[$viewData->id] ?? ['blind_test' => false, 'scan_xray' => false, 'question' => false];
                    @endphp
                    <div class="space-y-3">
                        <div>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Customer</span>
                            <p class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->customer->customer_name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Model Name</span>
                            <p class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->model_name }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">PCB Type</span>
                            <div class="flex items-center gap-1 flex-wrap mt-1">
                                @forelse(($viewData->pcb_type ?? []) as $pcb)
                                    <flux:badge size="sm" color="blue">{{ $pcb }}</flux:badge>
                                @empty
                                    <span class="text-sm text-zinc-800 dark:text-white">-</span>
                                @endforelse
                            </div>
                        </div>

                        {{-- ===== DIGUNAKAN DI ===== --}}
                        <div>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Digunakan Di</span>
                            <div class="flex items-center gap-1 flex-wrap mt-1">
                                @if($u['blind_test'])
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Blind Test
                                    </span>
                                @endif
                                @if($u['scan_xray'])
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                        Scan X-Ray
                                    </span>
                                @endif
                                @if($u['question'])
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-sky-100 text-sky-700 dark:bg-sky-900 dark:text-sky-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                                        Master Question
                                    </span>
                                @endif
                                @if(!$u['blind_test'] && !$u['scan_xray'] && !$u['question'])
                                    <span class="text-sm text-zinc-400">Belum dipakai</span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Created By</span>
                            <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->creator->name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Created At</span>
                            <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->created_at ? $viewData->created_at->format('d/m/Y H:i') : '-' }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Updated By</span>
                            <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->updater->name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Updated At</span>
                            <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->updated_at ? $viewData->updated_at->format('d/m/Y H:i') : '-' }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="p-6 pt-0 flex justify-end">
                    <button type="button"
                            @click="open = false"
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL DELETE ==================== -->
    <div x-data="{ open: false }"
        x-show="open"
        x-on:open-modal-delete.window="open = true"
        x-on:close-modal-delete.window="open = false"
        x-cloak
        @keydown.escape.window="open = false">

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>

                <h3 class="text-lg font-bold mb-2 text-center">Delete Model</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4 text-center">
                    Are you sure you want to delete model <span class="font-semibold">{{ $modelToDelete?->model_name }}</span>?
                </p>

                <div class="flex justify-center gap-3 mt-4">
                    <button @click="open = false"
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="delete"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL IMPORT ==================== -->
    <div x-data="{ open: false }"
        x-on:open-modal-import.window="open = true"
        x-on:close-modal-import.window="open = false"
        x-show="open"
        x-cloak
        @keydown.escape.window="open = false">

        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-5xl max-h-[94vh] flex flex-col overflow-hidden">

                {{-- ===== HEADER --}}
                <div class="relative px-6 py-5 bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 overflow-hidden flex-shrink-0">
                    <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/10"></div>
                    <div class="absolute -right-2 -bottom-10 w-20 h-20 rounded-full bg-white/10"></div>
                    <div class="absolute left-1/3 -top-6 w-16 h-16 rounded-full bg-white/5"></div>

                    <div class="relative flex items-start justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                                    <path fill-rule="evenodd" d="M11.47 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06l-3.22-3.22V16.5a.75.75 0 0 1-1.5 0V4.81L8.03 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5ZM3 15.75a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-[10px] text-white/70 uppercase tracking-wider font-semibold">Bulk Upload</div>
                                <h2 class="text-lg font-bold text-white leading-tight">Import Model from CSV</h2>
                                <p class="text-xs text-white/80 mt-0.5">
                                    Upload → Preview → Confirm. Baris duplikat / error otomatis di-skip.
                                </p>
                            </div>
                        </div>

                        <button @click="open = false"
                                class="text-white/80 hover:text-white transition-colors flex-shrink-0 w-8 h-8 rounded-lg hover:bg-white/10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Steps Indicator --}}
                    <div class="relative mt-4 flex items-center gap-2">
                        @php
                            $stepUpload  = in_array($importStep, ['upload', 'preview', 'done']);
                            $stepPreview = in_array($importStep, ['preview', 'done']);
                            $stepDone    = $importStep === 'done';
                        @endphp

                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center text-[11px] font-bold
                                        {{ $stepUpload ? 'bg-white text-emerald-700' : 'bg-white/20 text-white/70' }}">
                                @if($stepPreview)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    1
                                @endif
                            </div>
                            <span class="text-xs font-semibold {{ $stepUpload ? 'text-white' : 'text-white/60' }}">Upload</span>
                        </div>

                        <div class="flex-1 h-px bg-white/30 mx-1"></div>

                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center text-[11px] font-bold
                                        {{ $stepPreview ? 'bg-white text-emerald-700' : 'bg-white/20 text-white/70' }}">
                                @if($stepDone)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    2
                                @endif
                            </div>
                            <span class="text-xs font-semibold {{ $stepPreview ? 'text-white' : 'text-white/60' }}">Preview</span>
                        </div>

                        <div class="flex-1 h-px bg-white/30 mx-1"></div>

                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center text-[11px] font-bold
                                        {{ $stepDone ? 'bg-white text-emerald-700' : 'bg-white/20 text-white/70' }}">
                                3
                            </div>
                            <span class="text-xs font-semibold {{ $stepDone ? 'text-white' : 'text-white/60' }}">Done</span>
                        </div>
                    </div>
                </div>

                {{-- ===== BODY ===== --}}
                <div class="flex-1 min-h-0 overflow-y-auto overscroll-contain p-6 space-y-4 bg-zinc-50/50 dark:bg-zinc-900/50 import-scroll">

                    {{-- ===== STEP 1: UPLOAD ===== --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Info Format --}}
                        <div class="rounded-xl border border-blue-200 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 dark:border-blue-800 p-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 0 1-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 0 1-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 0 1-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584ZM12 18a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="text-sm flex-1">
                                    <p class="font-bold text-blue-900 dark:text-blue-100 mb-2">Format Kolom CSV</p>
                                    <div class="space-y-1.5">
                                        <div class="flex items-start gap-2">
                                            <code class="text-[11px] font-mono bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-1.5 py-0.5 rounded">customer_name</code>
                                            <span class="text-xs text-blue-800 dark:text-blue-200">harus sama dengan nama customer yang ada</span>
                                        </div>
                                        <div class="flex items-start gap-2">
                                            <code class="text-[11px] font-mono bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-1.5 py-0.5 rounded">model_name</code>
                                            <span class="text-xs text-blue-800 dark:text-blue-200">unik per customer</span>
                                        </div>
                                        <div class="flex items-start gap-2">
                                            <code class="text-[11px] font-mono bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-1.5 py-0.5 rounded">pcb_type</code>
                                            <span class="text-xs text-blue-800 dark:text-blue-200">
                                                <strong>SINGLE</strong> / <strong>LH</strong> / <strong>RH</strong> / <strong>LH;RH</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Upload + Template --}}
                        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-4 space-y-3">
                            <div>
                                <label class="text-xs font-semibold text-zinc-700 dark:text-zinc-300 uppercase tracking-wider">
                                    File CSV <span class="text-red-500">*</span>
                                </label>

                                <label class="mt-2 flex items-center gap-3 w-full px-4 py-3 border-2 border-dashed rounded-xl cursor-pointer
                                            border-zinc-300 dark:border-zinc-600
                                            hover:border-emerald-500 hover:bg-emerald-50/40 dark:hover:bg-emerald-950/20
                                            transition-colors
                                            {{ $importStep === 'done' ? 'opacity-50 cursor-not-allowed' : '' }}">
                                    <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600 dark:text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-zinc-800 dark:text-zinc-200 truncate">
                                            @if($importFile)
                                                {{ $importFile->getClientOriginalName() }}
                                            @else
                                                Pilih file CSV...
                                            @endif
                                        </p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                            Format .csv atau .txt — maks 2MB
                                        </p>
                                    </div>
                                    <input
                                        type="file"
                                        wire:model="importFile"
                                        accept=".csv,text/csv"
                                        @disabled($importStep === 'done')
                                        class="hidden"
                                    >
                                </label>

                                @error('importFile')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror

                                <div wire:loading wire:target="importFile" class="flex items-center gap-2 text-xs text-emerald-600 mt-2 font-semibold">
                                    <svg class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Membaca file...
                                </div>
                            </div>

                            <button
                                type="button"
                                wire:click="downloadTemplate"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 border border-emerald-300 dark:border-emerald-700 rounded-xl
                                    bg-emerald-50 dark:bg-emerald-950/30 hover:bg-emerald-100 dark:hover:bg-emerald-900/40
                                    transition-colors text-sm font-semibold text-emerald-700 dark:text-emerald-300"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download Template CSV
                            </button>
                        </div>
                    </div>

                    {{-- ===== STEP 2: PREVIEW ===== --}}
                    @if(!empty($importPreview))
                        <div class="space-y-4">

                            {{-- Success banner --}}
                            @if($importStep === 'done')
                                <div class="rounded-xl border border-emerald-300 dark:border-emerald-700 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-950/40 dark:to-teal-950/40 p-4 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-emerald-900 dark:text-emerald-100">
                                            Import Berhasil!
                                        </p>
                                        <p class="text-xs text-emerald-800 dark:text-emerald-200 mt-0.5">
                                            {{ $importSummary['success'] ?? 0 }} model berhasil ditambahkan
                                            @if(($importSummary['failed'] ?? 0) > 0)
                                                , {{ $importSummary['failed'] }} gagal / duplikat di-skip
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endif

                            {{-- Summary Cards --}}
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-3">
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="w-6 h-6 rounded-md bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <span class="text-[10px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Total</span>
                                    </div>
                                    <div class="text-2xl font-bold text-zinc-800 dark:text-white leading-none">{{ $importSummary['total'] }}</div>
                                    <div class="text-[10px] text-zinc-400 mt-1">baris CSV</div>
                                </div>

                                <div class="rounded-xl border border-green-200 dark:border-green-800 bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-950/30 dark:to-emerald-950/30 p-3">
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="w-6 h-6 rounded-md bg-green-100 dark:bg-green-900 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <span class="text-[10px] font-semibold text-green-700 dark:text-green-400 uppercase tracking-wider">Valid</span>
                                    </div>
                                    <div class="text-2xl font-bold text-green-700 dark:text-green-300 leading-none">{{ $importSummary['valid'] }}</div>
                                    <div class="text-[10px] text-green-600/70 dark:text-green-400/70 mt-1">siap di-import</div>
                                </div>

                                <div class="rounded-xl border border-amber-200 dark:border-amber-800 bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-950/30 dark:to-orange-950/30 p-3">
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="w-6 h-6 rounded-md bg-amber-100 dark:bg-amber-900 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-amber-600 dark:text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <span class="text-[10px] font-semibold text-amber-700 dark:text-amber-400 uppercase tracking-wider">Duplikat</span>
                                    </div>
                                    <div class="text-2xl font-bold text-amber-700 dark:text-amber-300 leading-none">{{ $importSummary['duplicate'] }}</div>
                                    <div class="text-[10px] text-amber-600/70 dark:text-amber-400/70 mt-1">di-skip</div>
                                </div>

                                <div class="rounded-xl border border-red-200 dark:border-red-800 bg-gradient-to-br from-red-50 to-rose-50 dark:from-red-950/30 dark:to-rose-950/30 p-3">
                                    <div class="flex items-center gap-2 mb-1">
                                        <div class="w-6 h-6 rounded-md bg-red-100 dark:bg-red-900 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-red-600 dark:text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </div>
                                        <span class="text-[10px] font-semibold text-red-700 dark:text-red-400 uppercase tracking-wider">Error</span>
                                    </div>
                                    <div class="text-2xl font-bold text-red-700 dark:text-red-300 leading-none">{{ $importSummary['invalid'] - $importSummary['duplicate'] }}</div>
                                    <div class="text-[10px] text-red-600/70 dark:text-red-400/70 mt-1">tidak valid</div>
                                </div>
                            </div>

                            {{-- Detail Table --}}
                            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden bg-white dark:bg-zinc-900">
                                <div class="px-4 py-3 bg-zinc-50 dark:bg-zinc-800/60 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                        </svg>
                                        <span class="text-sm font-bold text-zinc-700 dark:text-zinc-200">Detail Preview</span>
                                    </div>
                                    <span class="text-[11px] text-zinc-500 dark:text-zinc-400">
                                        {{ count($importPreview) }} baris
                                    </span>
                                </div>

                                <div class="max-h-80 overflow-y-auto import-scroll">
                                    <table class="w-full text-xs">
                                        <thead class="bg-zinc-50 dark:bg-zinc-800 sticky top-0 z-10 shadow-sm">
                                            <tr>
                                                <th class="px-3 py-2.5 text-left font-semibold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider text-[10px] w-12">#</th>
                                                <th class="px-3 py-2.5 text-left font-semibold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider text-[10px]">Customer</th>
                                                <th class="px-3 py-2.5 text-left font-semibold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider text-[10px]">Model</th>
                                                <th class="px-3 py-2.5 text-left font-semibold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider text-[10px]">PCB Type</th>
                                                <th class="px-3 py-2.5 text-center font-semibold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider text-[10px] w-28">Status</th>
                                                <th class="px-3 py-2.5 text-left font-semibold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider text-[10px]">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                            @foreach($importPreview as $row)
                                                @php
                                                    $rowBg = match($row['status']) {
                                                        'valid'     => 'bg-green-50/30 dark:bg-green-950/10',
                                                        'duplicate' => 'bg-amber-50/30 dark:bg-amber-950/10',
                                                        'imported'  => 'bg-emerald-50/50 dark:bg-emerald-950/20',
                                                        default     => 'bg-red-50/30 dark:bg-red-950/10',
                                                    };
                                                    $pcbArr = $row['pcb_array'] ?? [];
                                                @endphp
                                                <tr class="{{ $rowBg }} hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors">
                                                    <td class="px-3 py-2 text-zinc-500 dark:text-zinc-400 font-mono text-[11px]">
                                                        {{ $row['row'] }}
                                                    </td>
                                                    <td class="px-3 py-2 text-zinc-800 dark:text-zinc-200 font-semibold">
                                                        {{ $row['customer'] ?: '-' }}
                                                    </td>
                                                    <td class="px-3 py-2 text-zinc-800 dark:text-zinc-200 font-semibold">
                                                        {{ $row['model'] ?: '-' }}
                                                    </td>
                                                    <td class="px-3 py-2">
                                                        <div class="flex items-center gap-1 flex-wrap">
                                                            @forelse($pcbArr as $pcb)
                                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold
                                                                            bg-blue-100 text-blue-700
                                                                            dark:bg-blue-900 dark:text-blue-300">
                                                                    {{ $pcb }}
                                                                </span>
                                                            @empty
                                                                <span class="text-zinc-400">-</span>
                                                            @endforelse
                                                        </div>
                                                    </td>
                                                    <td class="px-3 py-2 text-center">
                                                        @if($row['status'] === 'valid')
                                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold
                                                                        bg-green-100 text-green-700
                                                                        dark:bg-green-900 dark:text-green-300">
                                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                                VALID
                                                            </span>
                                                        @elseif($row['status'] === 'imported')
                                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold
                                                                        bg-emerald-100 text-emerald-700
                                                                        dark:bg-emerald-900 dark:text-emerald-300">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                                </svg>
                                                                IMPORTED
                                                            </span>
                                                        @elseif($row['status'] === 'duplicate')
                                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold
                                                                        bg-amber-100 text-amber-700
                                                                        dark:bg-amber-900 dark:text-amber-300">
                                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                                DUPLICATE
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold
                                                                        bg-red-100 text-red-700
                                                                        dark:bg-red-900 dark:text-red-300">
                                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                                ERROR
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="px-3 py-2 text-zinc-600 dark:text-zinc-400">
                                                        @if(!empty($row['errors']))
                                                            <div class="flex items-start gap-1.5">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 mt-0.5 flex-shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                                </svg>
                                                                <span>{{ implode(' ', $row['errors']) }}</span>
                                                            </div>
                                                        @else
                                                            <span class="text-green-600 dark:text-green-400 font-semibold flex items-center gap-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                                </svg>
                                                                Siap di-import
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Legend --}}
                            <div class="flex flex-wrap items-center gap-4 px-1 text-[11px] text-zinc-500 dark:text-zinc-400">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    <span><strong class="text-green-700 dark:text-green-400">VALID</strong> — akan di-import</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    <span><strong class="text-amber-700 dark:text-amber-400">DUPLICATE</strong> — sudah ada, di-skip</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    <span><strong class="text-red-700 dark:text-red-400">ERROR</strong> — data tidak valid</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- ===== FOOTER ===== --}}
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 flex items-center justify-between gap-3 flex-shrink-0">

                    <div>
                        @if(!empty($importPreview) && $importStep !== 'done')
                            <button type="button"
                                    wire:click="resetImport"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-zinc-600 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Reset
                            </button>
                        @endif
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button"
                                @click="open = false"
                                class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                            {{ $importStep === 'done' ? 'Close' : 'Cancel' }}
                        </button>

                        @if($importStep === 'preview' && $importSummary['valid'] > 0)
                            <button type="button"
                                    wire:click="confirmImport"
                                    class="inline-flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700
                                        text-white rounded-lg transition-all shadow-sm hover:shadow-md
                                        disabled:opacity-50 disabled:cursor-not-allowed text-sm font-bold"
                                    wire:loading.attr="disabled"
                                    wire:target="confirmImport">
                                <svg wire:loading.remove wire:target="confirmImport" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <svg wire:loading wire:target="confirmImport" class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span wire:loading.remove wire:target="confirmImport">
                                    Import {{ $importSummary['valid'] }} Model
                                </span>
                                <span wire:loading wire:target="confirmImport">Importing...</span>
                            </button>
                        @endif

                        @if($importStep === 'done')
                            <button type="button"
                                    @click="open = false; $wire.resetImport()"
                                    class="inline-flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700
                                        text-white rounded-lg transition-all shadow-sm hover:shadow-md text-sm font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                Selesai
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    <div x-data="{ show: false, message: '', type: 'success' }"
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
         x-show="show"
         x-transition
         class="fixed bottom-4 right-4 z-50"
         :class="{
             'bg-green-500': type === 'success',
             'bg-red-500': type === 'error',
             'bg-yellow-500': type === 'warning'
         }"
         style="display: none;">
        <div class="text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
            <span x-text="message"></span>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }

        .import-scroll {
            scrollbar-width: thin;
            scrollbar-color: rgb(161 161 170 / 0.5) transparent;
        }

        .import-scroll::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .import-scroll::-webkit-scrollbar-track {
            background: transparent;
            border-radius: 9999px;
        }

        .import-scroll::-webkit-scrollbar-thumb {
            background-color: rgb(161 161 170 / 0.5);
            border-radius: 9999px;
            border: 2px solid transparent;
            background-clip: content-box;
        }

        .import-scroll::-webkit-scrollbar-thumb:hover {
            background-color: rgb(113 113 122 / 0.7);
            background-clip: content-box;
        }

        .dark .import-scroll {
            scrollbar-color: rgb(113 113 122 / 0.6) transparent;
        }

        .dark .import-scroll::-webkit-scrollbar-thumb {
            background-color: rgb(113 113 122 / 0.6);
            background-clip: content-box;
        }

        .dark .import-scroll::-webkit-scrollbar-thumb:hover {
            background-color: rgb(161 161 170 / 0.8);
            background-clip: content-box;
        }
    </style>
</div>