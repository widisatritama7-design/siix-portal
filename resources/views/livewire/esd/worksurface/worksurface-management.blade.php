<section class="w-full">
    

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge - Worksurface') }}
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
                        Worksurface
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                    Worksurface
                </h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    Manage ESD Worksurface Equipment
                </p>
            </div>
        </x-slot>
        
        <div class="-mt-2">
            <!-- Header with Search and Filters -->
            <div class="flex flex-col sm:flex-row gap-3 mt-2 mb-6">
                <!-- Search Bar - Left Side -->
                <div class="w-full sm:w-auto">
                    <flux:input
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search by register number, area, location, or category..."
                        icon="magnifying-glass"
                        clearable
                    />
                </div>

                <!-- Area Filter -->
                <div class="w-full sm:w-auto">
                    <select wire:model.live="filterArea"
                            class="w-full px-4 py-2 border border-zinc-300 rounded-lg
                                bg-white text-zinc-800
                                focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                dark:bg-zinc-800 dark:border-zinc-700 dark:text-white
                                [&>option]:bg-white [&>option]:text-zinc-800
                                dark:[&>option]:bg-zinc-800 dark:[&>option]:text-white">
                        <option value="">All Areas</option>
                        @foreach($areas as $area)
                            <option value="{{ $area }}">{{ $area }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Location Filter -->
                <div class="w-full sm:w-auto">
                    <select wire:model.live="filterLocation"
                            class="w-full px-4 py-2 border border-zinc-300 rounded-lg
                                bg-white text-zinc-800
                                focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                dark:bg-zinc-800 dark:border-zinc-700 dark:text-white
                                [&>option]:bg-white [&>option]:text-zinc-800
                                dark:[&>option]:bg-zinc-800 dark:[&>option]:text-white">
                        <option value="">All Locations</option>
                        @foreach($locations as $location)
                            <option value="{{ $location }}">{{ $location }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Category Filter -->
                <div class="w-full sm:w-auto">
                    <select wire:model.live="filterCategory"
                            class="w-full px-4 py-2 border border-zinc-300 rounded-lg
                                bg-white text-zinc-800
                                focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                dark:bg-zinc-800 dark:border-zinc-700 dark:text-white
                                [&>option]:bg-white [&>option]:text-zinc-800
                                dark:[&>option]:bg-zinc-800 dark:[&>option]:text-white">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- View All History Button -->
                <div class="w-full sm:w-auto">
                    <flux:button
                        href="{{ route('esd.worksurface-details')}}"
                        wire:navigate
                        icon="arrow-right"
                        variant="primary"
                        color="green"
                        class="w-full justify-center"
                    >
                        View All History
                    </flux:button>
                </div>

                <!-- Add New Button -->
                <div class="w-full sm:w-auto">
                    @can('create worksurface')
                    <flux:button
                        variant="primary"
                        icon="plus"
                        class="bg-blue-600 hover:bg-blue-700 whitespace-nowrap w-full justify-center"
                        wire:click="resetForm"
                        x-on:click="$dispatch('open-modal', 'worksurface-form-modal')"
                    >
                        Add New
                    </flux:button>
                    @endcan
                </div>
            </div>

            <!-- Clear Filters -->
            <div class="mb-4 text-right">
                @if($filterArea || $filterLocation || $filterCategory || $search)
                <button wire:click="resetFilters" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                    Clear All Filters
                </button>
                @endif
            </div>

            <!-- Worksurfaces Table -->
            <flux:card class="p-0 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 w-full overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-gradient-to-r from-blue-600 via-blue-600 to-indigo-600">
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider w-16">#</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[180px]">Register No</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[130px]">Area</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[130px]">Location</th>
                                <th class="px-4 py-4 text-center text-[11px] font-bold text-white uppercase tracking-wider min-w-[80px]">Layer</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[120px]">Category</th>
                                <th class="px-4 py-4 text-center text-[11px] font-bold text-white uppercase tracking-wider w-28">Status</th>
                                <th class="px-4 py-4 text-center text-[11px] font-bold text-white uppercase tracking-wider min-w-[110px]">Measurements</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[140px]">Created By</th>
                                <th class="px-4 py-4 text-center text-[11px] font-bold text-white uppercase tracking-wider w-28">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800 bg-white dark:bg-zinc-900">
                            @forelse($worksurfaces as $index => $worksurface)
                            <tr class="group hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-colors duration-150" wire:key="worksurface-{{ $worksurface->id }}">
                                {{-- Index --}}
                                <td class="px-4 py-3">
                                    <span class="text-xs font-bold text-zinc-400 dark:text-zinc-500">
                                        {{ str_pad($worksurfaces->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>

                                {{-- Register No --}}
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center text-white font-bold shadow-md shadow-teal-500/30 flex-shrink-0 group-hover:scale-105 transition-transform">
                                            {{ strtoupper(substr($worksurface->register_no, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <span class="text-sm font-semibold text-zinc-800 dark:text-white block truncate max-w-[200px]" title="{{ $worksurface->register_no }}">
                                                {{ $worksurface->register_no }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Area --}}
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 truncate max-w-[130px]" title="{{ $worksurface->area }}">
                                        {{ $worksurface->area }}
                                    </span>
                                </td>

                                {{-- Location --}}
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300 block truncate max-w-[150px]" title="{{ $worksurface->location }}">
                                        {{ $worksurface->location }}
                                    </span>
                                </td>

                                {{-- Layer Count --}}
                                <td class="px-4 py-3 text-center">
                                    @if($worksurface->layer_count)
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300 text-sm font-bold">
                                            {{ $worksurface->layer_count }}
                                        </span>
                                    @else
                                        <span class="text-zinc-400">-</span>
                                    @endif
                                </td>

                                {{-- Category --}}
                                <td class="px-4 py-3">
                                    @if($worksurface->category)
                                        <span class="text-xs font-semibold text-purple-700 dark:text-purple-400 uppercase tracking-wide">
                                            {{ $worksurface->category }}
                                        </span>
                                    @else
                                        <span class="text-zinc-400">-</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="px-4 py-3 text-center">
                                    @php
                                        $statusConfig = [
                                            'In Use' => [
                                                'label' => 'In Use',
                                                'color' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 ring-1 ring-green-300 dark:ring-green-700',
                                                'dot'   => 'bg-green-500',
                                            ],
                                            'Not In Use' => [
                                                'label' => 'Not In Use',
                                                'color' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 ring-1 ring-zinc-300 dark:ring-zinc-600',
                                                'dot'   => 'bg-zinc-500',
                                            ],
                                            'Under Repair' => [
                                                'label' => 'Under Repair',
                                                'color' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 ring-1 ring-yellow-300 dark:ring-yellow-700',
                                                'dot'   => 'bg-yellow-500',
                                            ],
                                            'Damage' => [
                                                'label' => 'Damage',
                                                'color' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 ring-1 ring-red-300 dark:ring-red-700',
                                                'dot'   => 'bg-red-500',
                                            ],
                                            'Disposed' => [
                                                'label' => 'Disposed',
                                                'color' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400 ring-1 ring-purple-300 dark:ring-purple-700',
                                                'dot'   => 'bg-purple-500',
                                            ],
                                        ];
                                        $status = $statusConfig[$worksurface->status] ?? [
                                            'label' => ucfirst(str_replace('_', ' ', $worksurface->status)),
                                            'color' => 'bg-zinc-100 text-zinc-800',
                                            'dot'   => 'bg-zinc-500',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $status['color'] }} whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $status['dot'] }}"></span>
                                        {{ $status['label'] }}
                                    </span>
                                </td>

                                {{-- Total Measurements --}}
                                <td class="px-4 py-3 text-center">
                                    <div class="inline-flex items-center gap-1.5">
                                        <flux:icon name="document-chart-bar" class="w-4 h-4 text-blue-500" />
                                        <span class="text-sm font-bold text-zinc-800 dark:text-white">
                                            {{ $worksurface->worksurfaceDetails()->count() }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Created By --}}
                                <td class="px-4 py-3">
                                    <div class="text-sm min-w-0">
                                        <div class="font-medium text-zinc-800 dark:text-zinc-200 truncate max-w-[150px]" title="{{ $worksurface->creator->name ?? 'N/A' }}">
                                            {{ $worksurface->creator->name ?? 'N/A' }}
                                        </div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                            {{ $worksurface->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                        @can('view worksurface')
                                        <flux:button
                                            href="{{ route('esd.worksurfaces.show', $worksurface->id) }}"
                                            wire:navigate
                                            size="sm"
                                            icon="eye"
                                            variant="primary"
                                            color="blue"
                                            class="!p-2 flex-shrink-0"
                                            title="View worksurface details"
                                        />
                                        @endcan
                                        @can('edit worksurface')
                                        <flux:button
                                            wire:click="edit({{ $worksurface->id }})"
                                            x-on:click="$dispatch('open-modal', 'worksurface-form-modal')"
                                            size="sm"
                                            icon="pencil-square"
                                            variant="primary"
                                            color="yellow"
                                            class="!p-2 flex-shrink-0"
                                            title="Edit worksurface"
                                        />
                                        @endcan
                                        @can('delete worksurface')
                                        <flux:button
                                            wire:click="confirmDelete({{ $worksurface->id }})"
                                            x-on:click="$dispatch('open-modal', 'delete-worksurface-modal')"
                                            size="sm"
                                            icon="trash"
                                            variant="primary"
                                            color="red"
                                            class="!p-2 flex-shrink-0"
                                            title="Delete worksurface"
                                        />
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="px-4 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <flux:icon name="square-3-stack-3d" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No worksurface records found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                                {{ $search || $filterArea || $filterLocation || $filterCategory ? 'Try adjusting your filters' : 'Get started by creating a new worksurface record' }}
                                            </p>
                                        </div>
                                        @if($search || $filterArea || $filterLocation || $filterCategory)
                                            <flux:button wire:click="resetFilters" size="sm">
                                                Clear Filters
                                            </flux:button>
                                        @else
                                            @can('create worksurface')
                                            <flux:button
                                                variant="primary"
                                                size="sm"
                                                wire:click="resetForm"
                                                x-on:click="$dispatch('open-modal', 'worksurface-form-modal')"
                                            >
                                                Add Your First Worksurface
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
                @if($worksurfaces->hasPages())
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-800/30">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">

                        {{-- Info --}}
                        <div class="text-xs text-zinc-500 dark:text-zinc-400 order-2 sm:order-1">
                            Showing
                            <span class="font-bold text-zinc-700 dark:text-zinc-200">{{ $worksurfaces->firstItem() ?? 0 }}</span>
                            to
                            <span class="font-bold text-zinc-700 dark:text-zinc-200">{{ $worksurfaces->lastItem() ?? 0 }}</span>
                            of
                            <span class="font-bold text-zinc-700 dark:text-zinc-200">{{ $worksurfaces->total() }}</span>
                            records
                        </div>

                        {{-- Pagination Controls --}}
                        <div class="flex items-center gap-1 order-1 sm:order-2">

                            {{-- Previous --}}
                            @if($worksurfaces->onFirstPage())
                                <button disabled
                                        class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium rounded-lg text-zinc-400 dark:text-zinc-600 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 cursor-not-allowed">
                                    <flux:icon name="chevron-left" class="w-4 h-4" />
                                    Prev
                                </button>
                            @else
                                <button wire:click="previousPage"
                                        wire:loading.attr="disabled"
                                        class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium rounded-lg text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                                    <flux:icon name="chevron-left" class="w-4 h-4" />
                                    Prev
                                </button>
                            @endif

                            {{-- Page Numbers --}}
                            @php
                                $currentPage = $worksurfaces->currentPage();
                                $lastPage = $worksurfaces->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            @endphp

                            {{-- First page + ellipsis --}}
                            @if($start > 1)
                                <button wire:click="gotoPage(1)"
                                        class="w-9 h-9 text-xs font-semibold rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                                    1
                                </button>
                                @if($start > 2)
                                    <span class="px-1 text-zinc-400 dark:text-zinc-600 text-xs">…</span>
                                @endif
                            @endif

                            {{-- Range pages --}}
                            @for($page = $start; $page <= $end; $page++)
                                @if($page == $currentPage)
                                    <button
                                            class="w-9 h-9 text-xs font-bold rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-600/30">
                                        {{ $page }}
                                    </button>
                                @else
                                    <button wire:click="gotoPage({{ $page }})"
                                            class="w-9 h-9 text-xs font-semibold rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                                        {{ $page }}
                                    </button>
                                @endif
                            @endfor

                            {{-- Ellipsis + last page --}}
                            @if($end < $lastPage)
                                @if($end < $lastPage - 1)
                                    <span class="px-1 text-zinc-400 dark:text-zinc-600 text-xs">…</span>
                                @endif
                                <button wire:click="gotoPage({{ $lastPage }})"
                                        class="w-9 h-9 text-xs font-semibold rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                                    {{ $lastPage }}
                                </button>
                            @endif

                            {{-- Next --}}
                            @if($worksurfaces->hasMorePages())
                                <button wire:click="nextPage"
                                        wire:loading.attr="disabled"
                                        class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium rounded-lg text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                                    Next
                                    <flux:icon name="chevron-right" class="w-4 h-4" />
                                </button>
                            @else
                                <button disabled
                                        class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium rounded-lg text-zinc-400 dark:text-zinc-600 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 cursor-not-allowed">
                                    Next
                                    <flux:icon name="chevron-right" class="w-4 h-4" />
                                </button>
                            @endif

                        </div>
                    </div>
                </div>
                @endif
            </flux:card>

            <!-- MODAL FORM WORKSURFACE -->
            <div x-data="{ open: false }"
                x-show="open"
                @open-modal.window="if ($event.detail === 'worksurface-form-modal') open = true"
                @close-modal.window="if ($event.detail === 'worksurface-form-modal') open = false"
                x-cloak>

                {{-- Backdrop --}}
                <div class="fixed inset-0 bg-zinc-900/60 backdrop-blur-sm z-40"
                    x-transition.opacity
                    @click="open = false"></div>

                {{-- Modal Panel --}}
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[92vh] flex flex-col overflow-hidden border border-zinc-200 dark:border-zinc-800"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100">

                        {{-- =================== HEADER =================== --}}
                        <div class="sticky top-0 z-10 bg-gradient-to-r from-blue-600 via-blue-600 to-indigo-600 px-6 py-4 flex items-center justify-between shadow-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center ring-2 ring-white/30">
                                    <flux:icon name="{{ $worksurface_id ? 'pencil-square' : 'plus-circle' }}" class="w-5 h-5 text-white" />
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-white leading-tight">
                                        {{ $worksurface_id ? 'Edit Worksurface' : 'New Worksurface' }}
                                    </h2>
                                    <p class="text-xs text-blue-100 mt-0.5">
                                        {{ $worksurface_id ? 'Update existing worksurface equipment' : 'Add a new worksurface equipment' }}
                                    </p>
                                </div>
                            </div>
                            <button type="button"
                                    @click="open = false"
                                    class="w-9 h-9 rounded-lg bg-white/10 hover:bg-white/25 flex items-center justify-center text-white transition-colors">
                                <flux:icon name="x-mark" class="w-5 h-5" />
                            </button>
                        </div>

                        {{-- =================== BODY =================== --}}
                        <div class="flex-1 overflow-y-auto">
                            <form wire:submit="save" id="worksurface-form" class="p-6 space-y-6">

                                {{-- SECTION 1: IDENTIFICATION --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                                            <flux:icon name="identification" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                                Identification
                                            </h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                Unique identifier and location
                                            </p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- Register No -->
                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">
                                                Register No <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" wire:model="register_no"
                                                placeholder="e.g. WS-REG-001"
                                                class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow">
                                            @error('register_no') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Area -->
                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">
                                                Area <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <select wire:model="area"
                                                        class="w-full px-3 py-2.5 pr-10 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl
                                                            bg-white text-zinc-800 appearance-none cursor-pointer
                                                            focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow
                                                            dark:bg-zinc-800 dark:text-white
                                                            [&>option]:bg-white [&>option]:text-zinc-800
                                                            dark:[&>option]:bg-zinc-800 dark:[&>option]:text-white">
                                                    <option value="">— Select Area —</option>
                                                    <option value="PRODUCTION 01">PRODUCTION 01</option>
                                                    <option value="PRODUCTION 02">PRODUCTION 02</option>
                                                    <option value="WH MATERIAL">WH MATERIAL</option>
                                                    <option value="WH FINISH GOOD">WH FINISH GOOD</option>
                                                </select>
                                                <flux:icon name="chevron-down"
                                                        class="w-4 h-4 text-zinc-500 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                                            </div>
                                            @error('area') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Location -->
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">
                                                Location <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" wire:model="location"
                                                placeholder="e.g. LINE 01 — STATION 05"
                                                class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow">
                                            @error('location') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- SECTION 2: SPECIFICATION --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center">
                                            <flux:icon name="cog-6-tooth" class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                                Specification
                                            </h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                Physical characteristics and category
                                            </p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- Layer Count -->
                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">
                                                Layer Count
                                            </label>
                                            <input type="number" wire:model="layer_count" min="1" max="10"
                                                placeholder="1 - 10"
                                                class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow">
                                            @error('layer_count') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Category -->
                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">
                                                Category
                                            </label>
                                            <div class="relative">
                                                <select wire:model="category"
                                                        class="w-full px-3 py-2.5 pr-10 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl
                                                            bg-white text-zinc-800 appearance-none cursor-pointer
                                                            focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                                            dark:bg-zinc-800 dark:text-white
                                                            [&>option]:bg-white [&>option]:text-zinc-800
                                                            dark:[&>option]:bg-zinc-800 dark:[&>option]:text-white">
                                                    <option value="">— Select Category —</option>
                                                    <option value="WORKSURFACE TABLE">WORKSURFACE TABLE</option>
                                                    <option value="SHELVING RACK">SHELVING RACK</option>
                                                    <option value="MOBILE TROLLEY">MOBILE TROLLEY</option>
                                                </select>
                                                <flux:icon name="chevron-down"
                                                        class="w-4 h-4 text-zinc-500 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                                            </div>
                                            @error('category') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- SECTION 3: STATUS --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/40 flex items-center justify-center">
                                            <flux:icon name="signal" class="w-4 h-4 text-green-600 dark:text-green-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                                Status
                                            </h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                Current operating condition
                                            </p>
                                        </div>
                                    </div>

                                    @php
                                        $statuses = [
                                            'In Use'       => ['icon' => 'check-circle',         'color' => 'green'],
                                            'Not In Use'   => ['icon' => 'pause-circle',         'color' => 'zinc'],
                                            'Under Repair' => ['icon' => 'wrench-screwdriver',   'color' => 'yellow'],
                                            'Damage'       => ['icon' => 'exclamation-triangle', 'color' => 'red'],
                                            'Disposed'     => ['icon' => 'archive-box-x-mark',   'color' => 'purple'],
                                        ];
                                    @endphp

                                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2"
                                        x-data="{ selected: @entangle('status') }">

                                        @php
                                            $statuses = [
                                                'In Use' => [
                                                    'icon'     => 'check-circle',
                                                    'border'   => 'border-green-500',
                                                    'bg'       => 'bg-green-50 dark:bg-green-900/20',
                                                    'ring'     => 'ring-green-300 dark:ring-green-700',
                                                    'iconOn'   => 'text-green-600 dark:text-green-400',
                                                    'textOn'   => 'text-green-700 dark:text-green-300',
                                                    'dot'      => 'bg-green-500',
                                                ],
                                                'Not In Use' => [
                                                    'icon'     => 'pause-circle',
                                                    'border'   => 'border-zinc-500',
                                                    'bg'       => 'bg-zinc-50 dark:bg-zinc-700/30',
                                                    'ring'     => 'ring-zinc-300 dark:ring-zinc-600',
                                                    'iconOn'   => 'text-zinc-600 dark:text-zinc-300',
                                                    'textOn'   => 'text-zinc-700 dark:text-zinc-200',
                                                    'dot'      => 'bg-zinc-500',
                                                ],
                                                'Under Repair' => [
                                                    'icon'     => 'wrench-screwdriver',
                                                    'border'   => 'border-yellow-500',
                                                    'bg'       => 'bg-yellow-50 dark:bg-yellow-900/20',
                                                    'ring'     => 'ring-yellow-300 dark:ring-yellow-700',
                                                    'iconOn'   => 'text-yellow-600 dark:text-yellow-400',
                                                    'textOn'   => 'text-yellow-700 dark:text-yellow-300',
                                                    'dot'      => 'bg-yellow-500',
                                                ],
                                                'Damage' => [
                                                    'icon'     => 'exclamation-triangle',
                                                    'border'   => 'border-red-500',
                                                    'bg'       => 'bg-red-50 dark:bg-red-900/20',
                                                    'ring'     => 'ring-red-300 dark:ring-red-700',
                                                    'iconOn'   => 'text-red-600 dark:text-red-400',
                                                    'textOn'   => 'text-red-700 dark:text-red-300',
                                                    'dot'      => 'bg-red-500',
                                                ],
                                                'Disposed' => [
                                                    'icon'     => 'archive-box-x-mark',
                                                    'border'   => 'border-purple-500',
                                                    'bg'       => 'bg-purple-50 dark:bg-purple-900/20',
                                                    'ring'     => 'ring-purple-300 dark:ring-purple-700',
                                                    'iconOn'   => 'text-purple-600 dark:text-purple-400',
                                                    'textOn'   => 'text-purple-700 dark:text-purple-300',
                                                    'dot'      => 'bg-purple-500',
                                                ],
                                            ];
                                        @endphp

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

                                                {{-- Indicator dot saat selected --}}
                                                <span x-show="selected === @js($statusName)"
                                                    class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full {{ $style['dot'] }}"></span>
                                            </button>
                                        @endforeach
                                    </div>
                                    @error('status') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                            </form>
                        </div>

                        {{-- =================== FOOTER =================== --}}
                        <div class="sticky bottom-0 bg-white dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-700 px-6 py-4 flex items-center justify-between shadow-[0_-4px_12px_rgba(0,0,0,0.05)]">
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 hidden sm:block">
                                <span class="text-red-500">*</span> Required fields
                            </p>
                            <div class="flex items-center gap-2 ml-auto">
                                <button type="button"
                                        @click="open = false"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    <flux:icon name="x-mark" class="w-4 h-4" />
                                    Cancel
                                </button>
                                <button type="submit" form="worksurface-form"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl transition-all text-sm font-semibold shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50">
                                    <flux:icon name="{{ $worksurface_id ? 'check' : 'plus' }}" class="w-4 h-4" />
                                    {{ $worksurface_id ? 'Update Worksurface' : 'Create Worksurface' }}
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- MODAL DELETE -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-modal.window="if ($event.detail === 'delete-worksurface-modal') open = true"
                 @close-modal.window="if ($event.detail === 'delete-worksurface-modal') open = false"
                 x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>

                        <h3 class="text-lg font-bold mb-2">Delete Worksurface</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Are you sure you want to delete worksurface "{{ $worksurfaceToDelete?->register_no }}"? This action cannot be undone.
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