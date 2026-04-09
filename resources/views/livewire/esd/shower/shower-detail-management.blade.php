{{-- resources/views/livewire/esd/shower/shower-detail-management.blade.php --}}
<section class="w-full">
    @include('partials.esd-heading')

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge - Shower Measurement') }}
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
                        Shower Measurement
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                            Shower Measurement
                        </h1>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            Manage measurement records for ESD shower
                        </p>
                    </div>
                    <flux:button 
                        href="{{ route('esd.showers') }}"
                        wire:navigate
                        icon="arrow-left"
                        variant="primary"
                        color="green"
                    >
                        Back to Shower
                    </flux:button>
                </div>
            </div>
        </x-slot>
        
        <div class="-mt-2">
            <!-- Header with buttons aligned -->
            <div x-data="{ showFilters: false }">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-1 mb-4">
                    <!-- Filter Toggle Button -->
                    <div class="flex-1">
                        <button 
                            @click="showFilters = !showFilters"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-zinc-700 bg-white border border-zinc-300 rounded-lg hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-600 dark:hover:bg-zinc-700 transition-colors"
                        >
                            <svg x-show="!showFilters" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <svg x-show="showFilters" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                            <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'"></span>
                            <span x-show="filterShower || filterCheckBody || filterJudgement || filterDateFrom || filterDateUntil || filterNextDateFrom || filterNextDateUntil || search" 
                                class="ml-1 px-1.5 py-0.5 text-xs bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                Active
                            </span>
                        </button>
                    </div>
                    
                    <!-- Create Button and Clear Filters -->
                    <div class="flex gap-2">
                        @can('create shower details')
                        <flux:button 
                            variant="primary" 
                            icon="plus" 
                            class="bg-blue-600 hover:bg-blue-700 whitespace-nowrap"
                            wire:click="resetForm"
                            x-on:click="$dispatch('open-modal', 'detail-form-modal')"
                        >
                            Add New Measurement
                        </flux:button>
                        @endcan
                    </div>
                </div>

                <!-- Filters Section with Collapsible -->
                <div x-show="showFilters" 
                    x-transition.duration.300ms
                    x-cloak
                    class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-700 p-6 mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Search</label>
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by register, area, location, remarks..." class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <!-- Date From -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date From</label>
                            <input type="date" wire:model.live="filterDateFrom" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <!-- Date Until -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date Until</label>
                            <input type="date" wire:model.live="filterDateUntil" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <!-- Next Date From -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Next Date From</label>
                            <input type="date" wire:model.live="filterNextDateFrom" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <!-- Next Date Until -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Next Date Until</label>
                            <input type="date" wire:model.live="filterNextDateUntil" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>
                    </div>
                    @if($filterShower || $filterCheckBody || $filterJudgement || $filterDateFrom || $filterDateUntil || $filterNextDateFrom || $filterNextDateUntil || $search)
                    <div class="mt-3 text-right">
                        <button wire:click="resetFilters" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">Clear All Filters</button>
                    </div>
                    @endif
                </div>
            </div>

            <!-- PRINT SECTION -->
            <div class="mb-4">
                <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700 shadow-sm">
                    <h3 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Report
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <!-- Filter Register No -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Register No</label>
                            <input type="text" 
                                wire:model.live="printRegisterFilter" 
                                placeholder="Search by register number..."
                                class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>
                        
                        <!-- Filter Check Body -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Check Body</label>
                            <select wire:model.live="printCheckBodyFilter" 
                                class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                                <option value="">All</option>
                                <option value="1">Yes (Checked)</option>
                                <option value="0">No (Not Checked)</option>
                            </select>
                        </div>
                        
                        <!-- Filter Judgement -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Judgement</label>
                            <select wire:model.live="printJudgementFilter" 
                                class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                                <option value="">All</option>
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                            </select>
                        </div>
                        
                        <!-- Date From -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date From</label>
                            <input type="date" 
                                wire:model.live="printDateFrom" 
                                class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>
                        
                        <!-- Date Until -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date Until</label>
                            <input type="date" 
                                wire:model.live="printDateUntil" 
                                class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>
                    </div>
                    
                    <!-- Print Buttons - Hanya muncul jika ada filter yang diisi -->
                    @if($printRegisterFilter || $printCheckBodyFilter !== '' || $printJudgementFilter || $printDateFrom || $printDateUntil)
                    <div class="flex gap-2 mt-4">
                        <button wire:click="printPDF" 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                            </svg>
                            Download PDF
                        </button>
                        
                        <button wire:click="resetPrintFilters" 
                                class="inline-flex items-center gap-2 px-4 py-2 border border-zinc-300 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Reset Filters
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            <!-- END PRINT SECTION -->

            <style>
                [x-cloak] { display: none !important; }
            </style>

            <!-- Measurements Table -->
            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-16">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Register No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">Area</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">Location</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Check Body</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Velocity</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-28">Judgement</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[200px]">Remarks</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Next Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">Checked By</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Actions</th>

                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($details as $index => $detail)
                            @php
                                $isOutOfSpec = ($detail->velocity < 80 || $detail->velocity > 100);
                                $rowClass = $isOutOfSpec ? 'bg-red-50 dark:bg-red-950/20' : '';
                                $velocityColor = $isOutOfSpec ? 'text-red-600 dark:text-red-400 font-bold' : 'text-green-600 dark:text-green-400';
                            @endphp
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors {{ $rowClass }}" wire:key="detail-{{ $detail->id }}">
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $details->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-medium shadow-lg flex-shrink-0 text-xs">
                                            {{ strtoupper(substr($detail->shower->register_no ?? '', 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-semibold text-zinc-800 dark:text-white truncate max-w-[180px]" title="{{ $detail->shower->register_no ?? '' }}">
                                            {{ $detail->shower->register_no ?? 'N/A' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $detail->shower->area ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $detail->shower->location ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3">
                                    @if($detail->check_body)
                                        <span class="inline-flex items-center gap-1 text-green-600 dark:text-green-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-sm">Yes</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-red-600 dark:text-red-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-sm">No</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-mono {{ $velocityColor }}">
                                            {{ $detail->velocity }} <span class="text-xs">m/s</span>
                                        </span>
                                        @if($isOutOfSpec)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                Out of Spec
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $judgementClass = 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400';
                                        if ($detail->judgement == 'OK') {
                                            $judgementClass = 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
                                        } elseif (str_contains($detail->judgement, 'NG')) {
                                            $judgementClass = 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                        }
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $judgementClass }}">
                                        {{ $detail->judgement }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    <div class="max-w-[250px] truncate" title="{{ $detail->remarks ?? '-' }}">
                                        @if($detail->remarks)
                                            @if(str_contains($detail->remarks, '⚠️'))
                                                <span class="text-yellow-600 dark:text-yellow-400">⚠️</span>
                                            @elseif(str_contains($detail->remarks, '✓'))
                                                <span class="text-green-600 dark:text-green-400">✓</span>
                                            @endif
                                            {{ $detail->remarks }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $detail->created_at ? $detail->created_at->format('d M Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $detail->next_date ? \Carbon\Carbon::parse($detail->next_date)->format('d M Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $detail->creator->name ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                        @can('edit shower details')
                                        <flux:button 
                                            wire:click="edit({{ $detail->id }})" 
                                            x-on:click="$dispatch('open-modal', 'detail-form-modal')"
                                            size="sm"
                                            icon="pencil-square"
                                            variant="primary"
                                            color="yellow"
                                            class="!p-2 flex-shrink-0"
                                            title="Edit measurement"
                                        />
                                        @endcan

                                        @can('delete shower details')
                                            <flux:button 
                                                wire:click="confirmDelete({{ $detail->id }})" 
                                                x-on:click="$dispatch('open-modal', 'delete-detail-modal')"
                                                size="sm"
                                                icon="trash"
                                                variant="primary"
                                                color="red"
                                                class="!p-2 flex-shrink-0"
                                                title="Delete measurement"
                                            />
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="12" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <flux:icon name="square-3-stack-3d" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No measurement records found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                                {{ $search || $filterShower || $filterCheckBody || $filterJudgement ? 'Try adjusting your filters' : 'Get started by adding a new measurement' }}
                                            </p>
                                        </div>
                                        @if($search || $filterShower || $filterCheckBody || $filterJudgement)
                                            <flux:button wire:click="resetFilters" size="sm">
                                                Clear Filters
                                            </flux:button>
                                        @else
                                            @can('create shower details')
                                            <flux:button 
                                                variant="primary" 
                                                size="sm"
                                                wire:click="resetForm"
                                                x-on:click="$dispatch('open-modal', 'detail-form-modal')"
                                            >
                                                Add Your First Measurement
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

                <!-- Pagination -->
                @if($details->hasPages())
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $details->links() }}
                </div>
                @endif
            </flux:card>

            <!-- MODAL FORM MEASUREMENT DETAIL -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-modal.window="if ($event.detail === 'detail-form-modal') open = true"
                 @close-modal.window="if ($event.detail === 'detail-form-modal') open = false"
                 x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                            <form wire:submit="save">
                                <!-- Register No -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Register No <span class="text-red-500">*</span></label>
                                    <select wire:model="shower_id"
                                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                                        <option value="">Select Register No</option>
                                        @foreach($showers as $shower)
                                            <option value="{{ $shower->id }}">{{ $shower->register_no }} - {{ $shower->area }} - {{ $shower->location }}</option>
                                        @endforeach
                                    </select>
                                    @error('shower_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Area & Location (Readonly) -->
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Area</label>
                                        <input type="text" wire:model="area" readonly class="w-full px-3 py-2 border rounded-lg bg-gray-100 dark:bg-zinc-800 dark:border-zinc-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Location</label>
                                        <input type="text" wire:model="location" readonly class="w-full px-3 py-2 border rounded-lg bg-gray-100 dark:bg-zinc-800 dark:border-zinc-700">
                                    </div>
                                </div>

                                <!-- Check Body Toggle -->
                                <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                    <label class="block text-sm font-medium mb-3">Check Body Status</label>
                                    <div class="flex items-center gap-4">
                                        <button type="button" 
                                            wire:click="$set('check_body', true)"
                                            class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all {{ $check_body ? 'bg-green-600 text-white shadow-md' : 'bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400' }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Yes (Check)
                                        </button>
                                        <button type="button"
                                            wire:click="$set('check_body', false)"
                                            class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all {{ !$check_body ? 'bg-red-600 text-white shadow-md' : 'bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400' }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            No (Skip)
                                        </button>
                                    </div>
                                    @error('check_body') <span class="text-red-500 text-sm block mt-2">{{ $message }}</span> @enderror
                                </div>

                                <!-- Velocity Measurement -->
                                <div class="mb-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                    <div class="text-sm font-semibold text-yellow-800 dark:text-yellow-400 mb-2">Standard: 80 - 100 m/s</div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Velocity (m/s) <span class="text-red-500">*</span></label>
                                        <input type="number" step="0.01" wire:model="velocity" wire:keyup="resetJudgement"
                                               class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                                        @error('velocity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        @if($velocity && (floatval($velocity) < 80 || floatval($velocity) > 100))
                                            <div class="mt-2 text-xs text-yellow-600 dark:text-yellow-400 flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                                <span>Warning: Value is outside the standard range (80-100 m/s)</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Judgement -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Judgement</label>
                                    <div class="flex gap-2">
                                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $judgement == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' }}">
                                            OK
                                        </span>
                                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ str_contains($judgement, 'NG') ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' }}">
                                            {{ $judgement ?: 'NG' }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                        * Auto-calculated based on velocity (80-100 = OK, below 80 = NG Below Standard, above 100 = NG Above Standard)
                                    </p>
                                </div>

                                <!-- Remarks -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Remarks</label>
                                    <textarea wire:model="remarks" 
                                              rows="3"
                                              placeholder="Enter any additional notes or comments..."
                                              class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 resize-y"></textarea>
                                    @error('remarks') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                        * Optional: Add notes about the measurement, corrective actions, or special conditions
                                    </p>
                                </div>

                                <!-- Next Date -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Next Date</label>
                                    <input type="date" wire:model="next_date" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                    @error('next_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Buttons -->
                                <div class="flex justify-end gap-2 mt-6">
                                    <button type="button" 
                                            @click="open = false"
                                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                                        Cancel
                                    </button>
                                    <button type="submit" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        {{ $detail_id ? 'Update' : 'Create' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL DELETE -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-modal.window="if ($event.detail === 'delete-detail-modal') open = true"
                 @close-modal.window="if ($event.detail === 'delete-detail-modal') open = false"
                 x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>

                        <h3 class="text-lg font-bold mb-2">Delete Measurement Record</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Are you sure you want to delete measurement for "{{ $detailToDelete?->shower?->register_no ?? 'this shower' }}"? This action cannot be undone.
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
                 x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 5000)"
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