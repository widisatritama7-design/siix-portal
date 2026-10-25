<section class="w-full">
    

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge - Packaging') }}
    </flux:heading>

    <x-esd.layout 
        class="!max-w-full !px-0 !mx-0"
    >
        <x-slot name="heading">
            <div class="w-full">
                <!-- Breadcrumbs -->
                <flux:breadcrumbs class="mb-1">
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
                        Dashboard
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        Maintenance
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        ESD
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        Packaging
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                    Packaging
                </h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    Manage ESD Packaging Materials
                </p>
            </div>
        </x-slot>
        
        <div class="-mt-2">

            {{-- ===================== FILTER SECTION ===================== --}}
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-lg border border-zinc-200 dark:border-zinc-800 p-5 mb-6">

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    {{-- Search --}}
                    <div class="sm:col-span-2 lg:col-span-2">
                        <flux:input
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search by category, project, model, material, oracle, or SAP code..."
                            icon="magnifying-glass"
                            clearable
                        />
                    </div>

                    {{-- Category Filter --}}
                    <flux:select wire:model.live="filterCategory">
                        <flux:select.option value="">All Categories</flux:select.option>
                        @foreach($categories as $cat)
                            <flux:select.option value="{{ $cat }}">{{ $cat }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    {{-- Buttons --}}
                    <div class="flex gap-2">
                        <div class="w-1/2">
                            <flux:button
                                href="{{ route('esd.packaging-details')}}"
                                wire:navigate
                                icon="arrow-right"
                                variant="primary"
                                color="green"
                                class="w-full justify-center"
                            >
                                View All History
                            </flux:button>
                        </div>
                        <div class="w-1/2">
                            @can('create packaging')
                            <flux:button
                                variant="primary"
                                icon="plus"
                                class="bg-indigo-600 hover:bg-indigo-700 whitespace-nowrap w-full justify-center text-white"
                                wire:click="resetForm"
                                x-on:click="$dispatch('open-modal', 'packaging-form-modal')"
                            >
                                Add New
                            </flux:button>
                            @endcan
                        </div>
                    </div>
                </div>

                {{-- Clear Filters --}}
                @if($filterCategory || $search)
                <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700 flex items-center gap-2 flex-wrap">
                    <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Active:</span>
                    @if($search) <flux:badge color="blue" size="sm" variant="subtle">{{ $search }}</flux:badge> @endif
                    @if($filterCategory) <flux:badge color="blue" size="sm" variant="subtle">{{ $filterCategory }}</flux:badge> @endif

                    <flux:button wire:click="resetFilters" size="xs" variant="subtle" color="red" icon="x-mark">
                        Clear All
                    </flux:button>
                </div>
                @endif
            </div>

            {{-- ===================== TABLE SECTION ===================== --}}
            <flux:card class="p-0 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 w-full overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-gradient-to-r from-indigo-600 via-indigo-600 to-blue-600">
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider w-16">#</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[140px]">Category</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[120px]">Project</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[120px]">Model</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[100px]">Oracle</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[100px]">SAP Code</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[150px]">Material</th>
                                <th class="px-4 py-4 text-center text-[11px] font-bold text-white uppercase tracking-wider min-w-[80px]">Size</th>
                                <th class="px-4 py-4 text-center text-[11px] font-bold text-white uppercase tracking-wider w-32">Status</th>
                                <th class="px-4 py-4 text-center text-[11px] font-bold text-white uppercase tracking-wider min-w-[130px]">Measurements</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[140px]">Created By</th>
                                <th class="px-4 py-4 text-right text-[11px] font-bold text-white uppercase tracking-wider w-28">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800 bg-white dark:bg-zinc-900">
                            @forelse($packagings as $index => $packaging)
                            <tr class="group hover:bg-indigo-50/50 dark:hover:bg-indigo-900/10 transition-colors duration-150" wire:key="packaging-{{ $packaging->id }}">

                                {{-- Index --}}
                                <td class="px-4 py-3">
                                    <span class="text-xs font-bold text-zinc-400 dark:text-zinc-500">
                                        {{ str_pad($packagings->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>

                                {{-- Category --}}
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white font-bold shadow-md shadow-indigo-500/30 flex-shrink-0 group-hover:scale-105 transition-transform">
                                            {{ strtoupper(substr($packaging->category, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <span class="text-sm font-semibold text-zinc-800 dark:text-white block truncate max-w-[200px]" title="{{ $packaging->category }}">
                                                {{ $packaging->category }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Project --}}
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300 block truncate max-w-[150px]" title="{{ $packaging->project }}">
                                        {{ $packaging->project ?? '-' }}
                                    </span>
                                </td>

                                {{-- Model --}}
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300 block truncate max-w-[150px]" title="{{ $packaging->model }}">
                                        {{ $packaging->model ?? '-' }}
                                    </span>
                                </td>

                                {{-- Oracle --}}
                                <td class="px-4 py-3">
                                    <span class="text-xs font-mono font-semibold text-zinc-700 dark:text-zinc-300">
                                        {{ $packaging->oracle ?? '-' }}
                                    </span>
                                </td>

                                {{-- SAP Code --}}
                                <td class="px-4 py-3">
                                    <span class="text-xs font-mono font-semibold text-zinc-700 dark:text-zinc-300">
                                        {{ $packaging->sap_code ?? '-' }}
                                    </span>
                                </td>

                                {{-- Material --}}
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300 font-medium">
                                        {{ $packaging->material }}
                                    </span>
                                    @if($packaging->material_desc)
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400 truncate max-w-[150px]" title="{{ $packaging->material_desc }}">
                                        {{ $packaging->material_desc }}
                                    </div>
                                    @endif
                                </td>

                                {{-- Size --}}
                                <td class="px-4 py-3 text-center">
                                    @if($packaging->size)
                                        <span class="inline-flex items-center justify-center px-2 py-1 rounded-lg bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 text-xs font-bold">
                                            {{ $packaging->size }}
                                        </span>
                                    @else
                                        <span class="text-zinc-400">-</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="px-4 py-3 text-center">
                                    @php
                                        $statusConfig = [
                                            'In Use' => ['color' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 ring-1 ring-green-300 dark:ring-green-700', 'dot' => 'bg-green-500'],
                                            'Not In Use' => ['color' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 ring-1 ring-zinc-300 dark:ring-zinc-600', 'dot' => 'bg-zinc-500'],
                                            'Under Repair' => ['color' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 ring-1 ring-yellow-300 dark:ring-yellow-700', 'dot' => 'bg-yellow-500'],
                                            'Damage' => ['color' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 ring-1 ring-red-300 dark:ring-red-700', 'dot' => 'bg-red-500'],
                                            'Disposed' => ['color' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400 ring-1 ring-purple-300 dark:ring-purple-700', 'dot' => 'bg-purple-500'],
                                        ];
                                        $status = $statusConfig[$packaging->status] ?? ['color' => 'bg-zinc-100 text-zinc-800', 'dot' => 'bg-zinc-500'];
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $status['color'] }} whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $status['dot'] }}"></span>
                                        {{ $packaging->status }}
                                    </span>
                                </td>

                                {{-- Measurements --}}
                                <td class="px-4 py-3 text-center">
                                    <div class="inline-flex items-center gap-1.5">
                                        <flux:icon name="document-chart-bar" class="w-4 h-4 text-indigo-500" />
                                        <span class="text-sm font-bold text-zinc-800 dark:text-white">
                                            {{ $packaging->packagingDetails()->count() }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Created By --}}
                                <td class="px-4 py-3">
                                    <div class="text-sm min-w-0">
                                        <div class="font-medium text-zinc-800 dark:text-zinc-200 truncate max-w-[150px]" title="{{ $packaging->creator->name ?? 'N/A' }}">
                                            {{ $packaging->creator->name ?? 'N/A' }}
                                        </div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                            {{ $packaging->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                        @can('view packaging')
                                        <flux:button
                                            href="{{ route('esd.packagings.show', $packaging->id) }}"
                                            wire:navigate
                                            size="sm"
                                            icon="eye"
                                            variant="primary"
                                            color="blue"
                                            class="!p-2 flex-shrink-0"
                                            title="View packaging details"
                                        />
                                        @endcan
                                        @can('edit packaging')
                                        <flux:button
                                            wire:click="edit({{ $packaging->id }})"
                                            x-on:click="$dispatch('open-modal', 'packaging-form-modal')"
                                            size="sm"
                                            icon="pencil-square"
                                            variant="primary"
                                            color="yellow"
                                            class="!p-2 flex-shrink-0"
                                            title="Edit packaging"
                                        />
                                        @endcan
                                        @can('delete packaging')
                                        <flux:button
                                            wire:click="confirmDelete({{ $packaging->id }})"
                                            x-on:click="$dispatch('open-modal', 'delete-packaging-modal')"
                                            size="sm"
                                            icon="trash"
                                            variant="primary"
                                            color="red"
                                            class="!p-2 flex-shrink-0"
                                            title="Delete packaging"
                                        />
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="12" class="px-4 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <flux:icon name="square-3-stack-3d" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No packaging records found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                                {{ $search || $filterCategory ? 'Try adjusting your filters' : 'Get started by creating a new packaging record' }}
                                            </p>
                                        </div>
                                        @if($search || $filterCategory)
                                            <flux:button wire:click="resetFilters" size="sm">
                                                Clear Filters
                                            </flux:button>
                                        @else
                                            @can('create packaging')
                                            <flux:button
                                                variant="primary"
                                                size="sm"
                                                wire:click="resetForm"
                                                x-on:click="$dispatch('open-modal', 'packaging-form-modal')"
                                            >
                                                Add Your First Packaging
                                            </flux:button>
                                            @endcan
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- ===================== CUSTOM PAGINATION ===================== --}}
                @if($packagings->hasPages())
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-800/30">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-xs text-zinc-500 dark:text-zinc-400 order-2 sm:order-1">
                            Showing
                            <span class="font-bold text-zinc-700 dark:text-zinc-200">{{ $packagings->firstItem() ?? 0 }}</span>
                            to
                            <span class="font-bold text-zinc-700 dark:text-zinc-200">{{ $packagings->lastItem() ?? 0 }}</span>
                            of
                            <span class="font-bold text-zinc-700 dark:text-zinc-200">{{ $packagings->total() }}</span>
                            records
                        </div>

                        <div class="flex items-center gap-1 order-1 sm:order-2">
                            @if($packagings->onFirstPage())
                                <button disabled class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium rounded-lg text-zinc-400 dark:text-zinc-600 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 cursor-not-allowed">
                                    <flux:icon name="chevron-left" class="w-4 h-4" /> Prev
                                </button>
                            @else
                                <button wire:click="previousPage" wire:loading.attr="disabled" class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium rounded-lg text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:border-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                                    <flux:icon name="chevron-left" class="w-4 h-4" /> Prev
                                </button>
                            @endif

                            @php
                                $currentPage = $packagings->currentPage();
                                $lastPage = $packagings->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            @endphp

                            @if($start > 1)
                                <button wire:click="gotoPage(1)" class="w-9 h-9 text-xs font-semibold rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:border-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">1</button>
                                @if($start > 2) <span class="px-1 text-zinc-400 dark:text-zinc-600 text-xs">…</span> @endif
                            @endif

                            @for($page = $start; $page <= $end; $page++)
                                @if($page == $currentPage)
                                    <button class="w-9 h-9 text-xs font-bold rounded-lg bg-gradient-to-br from-indigo-600 to-blue-600 text-white shadow-md shadow-indigo-600/30">{{ $page }}</button>
                                @else
                                    <button wire:click="gotoPage({{ $page }})" class="w-9 h-9 text-xs font-semibold rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:border-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">{{ $page }}</button>
                                @endif
                            @endfor

                            @if($end < $lastPage)
                                @if($end < $lastPage - 1) <span class="px-1 text-zinc-400 dark:text-zinc-600 text-xs">…</span> @endif
                                <button wire:click="gotoPage({{ $lastPage }})" class="w-9 h-9 text-xs font-semibold rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:border-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">{{ $lastPage }}</button>
                            @endif

                            @if($packagings->hasMorePages())
                                <button wire:click="nextPage" wire:loading.attr="disabled" class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium rounded-lg text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:border-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                                    Next <flux:icon name="chevron-right" class="w-4 h-4" />
                                </button>
                            @else
                                <button disabled class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium rounded-lg text-zinc-400 dark:text-zinc-600 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 cursor-not-allowed">
                                    Next <flux:icon name="chevron-right" class="w-4 h-4" />
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </flux:card>

            <!-- MODAL FORM PACKAGING -->
            <div x-data="{ open: false }"
                x-show="open"
                @open-modal.window="if ($event.detail === 'packaging-form-modal') open = true"
                @close-modal.window="if ($event.detail === 'packaging-form-modal') open = false"
                x-cloak>

                <div class="fixed inset-0 bg-zinc-900/60 backdrop-blur-sm z-40" x-transition.opacity @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[92vh] flex flex-col overflow-hidden border border-zinc-200 dark:border-zinc-800"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100">

                        {{-- HEADER --}}
                        <div class="sticky top-0 z-10 bg-gradient-to-r from-indigo-600 via-indigo-600 to-blue-600 px-6 py-4 flex items-center justify-between shadow-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center ring-2 ring-white/30">
                                    <flux:icon name="{{ $packaging_id ? 'pencil-square' : 'plus-circle' }}" class="w-5 h-5 text-white" />
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-white leading-tight">
                                        {{ $packaging_id ? 'Edit Packaging' : 'New Packaging' }}
                                    </h2>
                                    <p class="text-xs text-indigo-100 mt-0.5">
                                        {{ $packaging_id ? 'Update existing packaging material' : 'Add a new packaging material' }}
                                    </p>
                                </div>
                            </div>
                            <button type="button" @click="open = false"
                                    class="w-9 h-9 rounded-lg bg-white/10 hover:bg-white/25 flex items-center justify-center text-white transition-colors">
                                <flux:icon name="x-mark" class="w-5 h-5" />
                            </button>
                        </div>

                        {{-- BODY --}}
                        <div class="flex-1 overflow-y-auto">
                            <form wire:submit="save" id="packaging-form" class="p-6 space-y-6">

                                {{-- SECTION 1: IDENTIFICATION --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                                            <flux:icon name="identification" class="w-4 h-4 text-indigo-600 dark:text-indigo-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">Identification</h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Unique identifier and location</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Category <span class="text-red-500">*</span></label>
                                            <input type="text" wire:model="category" placeholder="e.g. ESD BAG" class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-indigo-500 transition-shadow">
                                            @error('category') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Project</label>
                                            <input type="text" wire:model="project" placeholder="e.g. PROJECT X" class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-indigo-500 transition-shadow">
                                            @error('project') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Model</label>
                                            <input type="text" wire:model="model" placeholder="e.g. MODEL-A" class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-indigo-500 transition-shadow">
                                            @error('model') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Oracle</label>
                                            <input type="text" wire:model="oracle" placeholder="e.g. ORA-001" class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-indigo-500 transition-shadow">
                                            @error('oracle') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">SAP Code</label>
                                            <input type="text" wire:model="sap_code" placeholder="e.g. SAP-123" class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-indigo-500 transition-shadow">
                                            @error('sap_code') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- SECTION 2: SPECIFICATION --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center">
                                            <flux:icon name="cog-6-tooth" class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">Specification</h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Physical characteristics</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Material <span class="text-red-500">*</span></label>
                                            <input type="text" wire:model="material" placeholder="e.g. ESD BAG" class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-indigo-500 transition-shadow">
                                            @error('material') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Material Description</label>
                                            <textarea wire:model="material_desc" rows="2" placeholder="Additional details about the material..." class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-indigo-500 transition-shadow"></textarea>
                                            @error('material_desc') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Size</label>
                                            <input type="text" wire:model="size" placeholder="e.g. 10x15 cm" class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-indigo-500 transition-shadow">
                                            @error('size') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Supplier</label>
                                            <input type="text" wire:model="supplier" placeholder="e.g. SUPPLIER A" class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-indigo-500 transition-shadow">
                                            @error('supplier') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- SECTION 3: STATUS --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center">
                                            <flux:icon name="signal" class="w-4 h-4 text-emerald-600 dark:text-emerald-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">Status</h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Current operating condition</p>
                                        </div>
                                    </div>

                                    @php
                                        $statuses = [
                                            'In Use' => ['icon' => 'check-circle', 'border' => 'border-green-500', 'bg' => 'bg-green-50 dark:bg-green-900/20', 'ring' => 'ring-green-300 dark:ring-green-700', 'iconOn' => 'text-green-600 dark:text-green-400', 'textOn' => 'text-green-700 dark:text-green-300', 'dot' => 'bg-green-500'],
                                            'Not In Use' => ['icon' => 'pause-circle', 'border' => 'border-zinc-500', 'bg' => 'bg-zinc-50 dark:bg-zinc-700/30', 'ring' => 'ring-zinc-300 dark:ring-zinc-600', 'iconOn' => 'text-zinc-600 dark:text-zinc-300', 'textOn' => 'text-zinc-700 dark:text-zinc-200', 'dot' => 'bg-zinc-500'],
                                            'Under Repair' => ['icon' => 'wrench-screwdriver', 'border' => 'border-yellow-500', 'bg' => 'bg-yellow-50 dark:bg-yellow-900/20', 'ring' => 'ring-yellow-300 dark:ring-yellow-700', 'iconOn' => 'text-yellow-600 dark:text-yellow-400', 'textOn' => 'text-yellow-700 dark:text-yellow-300', 'dot' => 'bg-yellow-500'],
                                            'Damage' => ['icon' => 'exclamation-triangle', 'border' => 'border-red-500', 'bg' => 'bg-red-50 dark:bg-red-900/20', 'ring' => 'ring-red-300 dark:ring-red-700', 'iconOn' => 'text-red-600 dark:text-red-400', 'textOn' => 'text-red-700 dark:text-red-300', 'dot' => 'bg-red-500'],
                                            'Disposed' => ['icon' => 'archive-box-x-mark', 'border' => 'border-purple-500', 'bg' => 'bg-purple-50 dark:bg-purple-900/20', 'ring' => 'ring-purple-300 dark:ring-purple-700', 'iconOn' => 'text-purple-600 dark:text-purple-400', 'textOn' => 'text-purple-700 dark:text-purple-300', 'dot' => 'bg-purple-500'],
                                        ];
                                    @endphp

                                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2" x-data="{ selected: @entangle('status') }">
                                        @foreach($statuses as $statusName => $style)
                                            <button type="button"
                                                    @click="selected = @js($statusName)"
                                                    :class="selected === @js($statusName)
                                                        ? '{{ $style['border'] }} {{ $style['bg'] }} ring-2 {{ $style['ring'] }} shadow-md'
                                                        : 'border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 hover:border-zinc-300 dark:hover:border-zinc-600'"
                                                    class="relative p-3 rounded-xl border-2 transition-all duration-150 flex flex-col items-center justify-center gap-2 text-center">
                                                <flux:icon name="{{ $style['icon'] }}"
                                                        ::class="selected === @js($statusName)
                                                            ? 'w-5 h-5 {{ $style['iconOn'] }}'
                                                            : 'w-5 h-5 text-zinc-500 dark:text-zinc-400'" />
                                                <span ::class="selected === @js($statusName)
                                                        ? 'text-[11px] font-bold uppercase tracking-wide {{ $style['textOn'] }}'
                                                        : 'text-[11px] font-bold uppercase tracking-wide text-zinc-600 dark:text-zinc-400'">
                                                    {{ $statusName }}
                                                </span>
                                                <span x-show="selected === @js($statusName)" class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full {{ $style['dot'] }}"></span>
                                            </button>
                                        @endforeach
                                    </div>
                                    @error('status') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                            </form>
                        </div>

                        {{-- FOOTER --}}
                        <div class="sticky bottom-0 bg-white dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-700 px-6 py-4 flex items-center justify-between shadow-[0_-4px_12px_rgba(0,0,0,0.05)]">
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 hidden sm:block">
                                <span class="text-red-500">*</span> Required fields
                            </p>
                            <div class="flex items-center gap-2 ml-auto">
                                <button type="button" @click="open = false" class="inline-flex items-center gap-2 px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    <flux:icon name="x-mark" class="w-4 h-4" /> Cancel
                                </button>
                                <button type="submit" form="packaging-form" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white rounded-xl transition-all text-sm font-semibold shadow-lg shadow-indigo-600/30 hover:shadow-indigo-600/50">
                                    <flux:icon name="{{ $packaging_id ? 'check' : 'plus' }}" class="w-4 h-4" />
                                    {{ $packaging_id ? 'Update Packaging' : 'Create Packaging' }}
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- MODAL DELETE -->
            <div x-data="{ open: false }"
                x-show="open"
                @open-modal.window="if ($event.detail === 'delete-packaging-modal') open = true"
                @close-modal.window="if ($event.detail === 'delete-packaging-modal') open = false"
                x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>

                        <h3 class="text-lg font-bold mb-2">Delete Packaging</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Are you sure you want to delete packaging "{{ $packagingToDelete?->material }}"? This action cannot be undone.
                        </p>

                        <div class="flex justify-center gap-3">
                            <button @click="open = false"
                                    class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800">
                                Cancel
                            </button>
                            <button wire:click="delete"
                                    @click="open = false"
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                Yes, Delete
                            </button>
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
            </style>
        </div>
    </x-esd.layout>
</section>