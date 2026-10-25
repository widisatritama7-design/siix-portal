{{-- resources/views/livewire/esd/glove/glove-management.blade.php --}}
<section class="w-full">
    

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge - Glove') }}
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
                        Glove
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                    Glove
                </h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    Manage ESD Gloves
                </p>
            </div>
        </x-slot>
                
        <div class="-mt-2">

            {{-- ===================== FILTER SECTION ===================== --}}
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-lg border border-zinc-200 dark:border-zinc-800 p-5 mb-6">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="w-full sm:flex-1">
                        <flux:input
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search by SAP code or description..."
                            icon="magnifying-glass"
                            clearable
                        />
                    </div>

                    <div class="flex gap-2">
                        <div class="w-full sm:w-auto">
                            <flux:button
                                href="{{ route('esd.glove-details')}}"
                                wire:navigate
                                icon="arrow-right"
                                variant="primary"
                                color="green"
                                class="w-full sm:w-auto justify-center whitespace-nowrap"
                            >
                                View All History
                            </flux:button>
                        </div>
                        <div class="w-full sm:w-auto">
                            @can('create glove')
                            <flux:button
                                variant="primary"
                                icon="plus"
                                class="bg-blue-600 hover:bg-blue-700 whitespace-nowrap w-full sm:w-auto justify-center text-white"
                                wire:click="resetForm"
                                x-on:click="$dispatch('open-modal', 'glove-form-modal')"
                            >
                                Add New
                            </flux:button>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===================== TABLE SECTION ===================== --}}
            <flux:card class="p-0 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 w-full overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-gradient-to-r from-blue-600 via-blue-600 to-indigo-600">
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider w-16">#</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[180px]">SAP Code</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[250px]">Description</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[140px]">Delivery</th>
                                <th class="px-4 py-4 text-center text-[11px] font-bold text-white uppercase tracking-wider w-32">Status</th>
                                <th class="px-4 py-4 text-center text-[11px] font-bold text-white uppercase tracking-wider min-w-[130px]">Measurements</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[140px]">Created By</th>
                                <th class="px-4 py-4 text-right text-[11px] font-bold text-white uppercase tracking-wider w-28">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800 bg-white dark:bg-zinc-900">
                            @forelse($gloves as $index => $glove)
                            <tr class="group hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-colors duration-150" wire:key="glove-{{ $glove->id }}">

                                {{-- Index --}}
                                <td class="px-4 py-3">
                                    <span class="text-xs font-bold text-zinc-400 dark:text-zinc-500">
                                        {{ str_pad($gloves->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>

                                {{-- SAP Code --}}
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-md shadow-blue-500/30 flex-shrink-0 group-hover:scale-105 transition-transform">
                                            {{ strtoupper(substr($glove->sap_code, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <span class="text-sm font-semibold text-zinc-800 dark:text-white block truncate max-w-[200px]" title="{{ $glove->sap_code }}">
                                                {{ $glove->sap_code }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Description --}}
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300 block truncate max-w-[250px]" title="{{ $glove->description }}">
                                        {{ $glove->description }}
                                    </span>
                                </td>

                                {{-- Delivery --}}
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 truncate max-w-[130px]" title="{{ $glove->delivery }}">
                                        {{ $glove->delivery ?? '-' }}
                                    </span>
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
                                        $status = $statusConfig[$glove->status] ?? ['color' => 'bg-zinc-100 text-zinc-800', 'dot' => 'bg-zinc-500'];
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $status['color'] }} whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $status['dot'] }}"></span>
                                        {{ $glove->status }}
                                    </span>
                                </td>

                                {{-- Measurements --}}
                                <td class="px-4 py-3 text-center">
                                    <div class="inline-flex items-center gap-1.5">
                                        <flux:icon name="document-chart-bar" class="w-4 h-4 text-blue-500" />
                                        <span class="text-sm font-bold text-zinc-800 dark:text-white">
                                            {{ $glove->gloveDetails()->count() }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Created By --}}
                                <td class="px-4 py-3">
                                    <div class="text-sm min-w-0">
                                        <div class="font-medium text-zinc-800 dark:text-zinc-200 truncate max-w-[150px]" title="{{ $glove->creator->name ?? 'N/A' }}">
                                            {{ $glove->creator->name ?? 'N/A' }}
                                        </div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                            {{ $glove->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                        @can('view glove')
                                        <flux:button
                                            href="{{ route('esd.gloves.show', $glove->id) }}"
                                            wire:navigate
                                            size="sm"
                                            icon="eye"
                                            variant="primary"
                                            color="blue"
                                            class="!p-2 flex-shrink-0"
                                            title="View glove details"
                                        />
                                        @endcan
                                        @can('edit glove')
                                        <flux:button
                                            wire:click="edit({{ $glove->id }})"
                                            x-on:click="$dispatch('open-modal', 'glove-form-modal')"
                                            size="sm"
                                            icon="pencil-square"
                                            variant="primary"
                                            color="yellow"
                                            class="!p-2 flex-shrink-0"
                                            title="Edit glove"
                                        />
                                        @endcan
                                        @can('delete glove')
                                        <flux:button
                                            wire:click="confirmDelete({{ $glove->id }})"
                                            x-on:click="$dispatch('open-modal', 'delete-glove-modal')"
                                            size="sm"
                                            icon="trash"
                                            variant="primary"
                                            color="red"
                                            class="!p-2 flex-shrink-0"
                                            title="Delete glove"
                                        />
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-4 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <flux:icon name="square-3-stack-3d" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No glove records found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                                {{ $search ? 'Try adjusting your search query' : 'Get started by creating a new glove record' }}
                                            </p>
                                        </div>
                                        @if($search)
                                            <flux:button wire:click="$set('search', '')" size="sm">
                                                Clear Search
                                            </flux:button>
                                        @else
                                            @can('create glove')
                                            <flux:button
                                                variant="primary"
                                                size="sm"
                                                wire:click="resetForm"
                                                x-on:click="$dispatch('open-modal', 'glove-form-modal')"
                                            >
                                                Add Your First Glove
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
                @if($gloves->hasPages())
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-800/30">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-xs text-zinc-500 dark:text-zinc-400 order-2 sm:order-1">
                            Showing
                            <span class="font-bold text-zinc-700 dark:text-zinc-200">{{ $gloves->firstItem() ?? 0 }}</span>
                            to
                            <span class="font-bold text-zinc-700 dark:text-zinc-200">{{ $gloves->lastItem() ?? 0 }}</span>
                            of
                            <span class="font-bold text-zinc-700 dark:text-zinc-200">{{ $gloves->total() }}</span>
                            records
                        </div>

                        <div class="flex items-center gap-1 order-1 sm:order-2">
                            @if($gloves->onFirstPage())
                                <button disabled class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium rounded-lg text-zinc-400 dark:text-zinc-600 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 cursor-not-allowed">
                                    <flux:icon name="chevron-left" class="w-4 h-4" /> Prev
                                </button>
                            @else
                                <button wire:click="previousPage" wire:loading.attr="disabled" class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium rounded-lg text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                                    <flux:icon name="chevron-left" class="w-4 h-4" /> Prev
                                </button>
                            @endif

                            @php
                                $currentPage = $gloves->currentPage();
                                $lastPage = $gloves->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            @endphp

                            @if($start > 1)
                                <button wire:click="gotoPage(1)" class="w-9 h-9 text-xs font-semibold rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">1</button>
                                @if($start > 2) <span class="px-1 text-zinc-400 dark:text-zinc-600 text-xs">…</span> @endif
                            @endif

                            @for($page = $start; $page <= $end; $page++)
                                @if($page == $currentPage)
                                    <button class="w-9 h-9 text-xs font-bold rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 text-white shadow-md shadow-blue-600/30">{{ $page }}</button>
                                @else
                                    <button wire:click="gotoPage({{ $page }})" class="w-9 h-9 text-xs font-semibold rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">{{ $page }}</button>
                                @endif
                            @endfor

                            @if($end < $lastPage)
                                @if($end < $lastPage - 1) <span class="px-1 text-zinc-400 dark:text-zinc-600 text-xs">…</span> @endif
                                <button wire:click="gotoPage({{ $lastPage }})" class="w-9 h-9 text-xs font-semibold rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">{{ $lastPage }}</button>
                            @endif

                            @if($gloves->hasMorePages())
                                <button wire:click="nextPage" wire:loading.attr="disabled" class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium rounded-lg text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
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

            <!-- MODAL FORM GLOVE -->
            <div x-data="{ open: false }"
                x-show="open"
                @open-modal.window="if ($event.detail === 'glove-form-modal') open = true"
                @close-modal.window="if ($event.detail === 'glove-form-modal') open = false"
                x-cloak>

                <div class="fixed inset-0 bg-zinc-900/60 backdrop-blur-sm z-40" x-transition.opacity @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[92vh] flex flex-col overflow-hidden border border-zinc-200 dark:border-zinc-800"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100">

                        {{-- HEADER --}}
                        <div class="sticky top-0 z-10 bg-gradient-to-r from-blue-600 via-blue-600 to-indigo-600 px-6 py-4 flex items-center justify-between shadow-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center ring-2 ring-white/30">
                                    <flux:icon name="{{ $glove_id ? 'pencil-square' : 'plus-circle' }}" class="w-5 h-5 text-white" />
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-white leading-tight">
                                        {{ $glove_id ? 'Edit Glove' : 'New Glove' }}
                                    </h2>
                                    <p class="text-xs text-blue-100 mt-0.5">
                                        {{ $glove_id ? 'Update existing glove data' : 'Add a new glove material' }}
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
                            <form wire:submit="save" id="glove-form" class="p-6 space-y-6">

                                {{-- SECTION 1: IDENTIFICATION --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                                            <flux:icon name="identification" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">Identification</h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Unique identifier and description</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">SAP Code <span class="text-red-500">*</span></label>
                                            <input type="text" wire:model="sap_code" placeholder="e.g. SAP-12345" class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 transition-shadow">
                                            @error('sap_code') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Description <span class="text-red-500">*</span></label>
                                            <textarea wire:model="description" rows="3" placeholder="e.g. ESD GLOVE SIZE L" class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 transition-shadow"></textarea>
                                            @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Delivery</label>
                                            <input type="text" wire:model="delivery" placeholder="e.g. PT. ABC" class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 transition-shadow">
                                            @error('delivery') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- SECTION 2: STATUS --}}
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
                                <button type="submit" form="glove-form" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl transition-all text-sm font-semibold shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50">
                                    <flux:icon name="{{ $glove_id ? 'check' : 'plus' }}" class="w-4 h-4" />
                                    {{ $glove_id ? 'Update Glove' : 'Create Glove' }}
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- MODAL DELETE -->
            <div x-data="{ open: false }"
                x-show="open"
                @open-modal.window="if ($event.detail === 'delete-glove-modal') open = true"
                @close-modal.window="if ($event.detail === 'delete-glove-modal') open = false"
                x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>

                        <h3 class="text-lg font-bold mb-2">Delete Glove</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Are you sure you want to delete glove "{{ $gloveToDelete?->sap_code }}"? This action cannot be undone.
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