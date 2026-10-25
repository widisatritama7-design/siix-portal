<section class="w-full">

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge - Worksurface Measurement') }}
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
                        Worksurface Measurement
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>

        <x-slot name="subheading">
            <div class="w-full">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                            Worksurface Measurement
                        </h1>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            Manage measurement records for ESD worksurface equipment
                        </p>
                    </div>
                    <flux:button
                        href="{{ route('esd.worksurfaces') }}"
                        wire:navigate
                        icon="arrow-left"
                        variant="primary"
                        color="green"
                    >
                        Back to Worksurface
                    </flux:button>
                </div>
            </div>
        </x-slot>

        <div class="-mt-2">
            <!-- Header with Filters -->
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
                            <span x-show="filterWorksurface || filterArea || filterLocation || filterItem || filterJudgementA1 || filterJudgementA2 || filterJudgementA3 || filterDateFrom || filterDateUntil || filterNextDateFrom || filterNextDateUntil || search"
                                class="ml-1 px-1.5 py-0.5 text-xs bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                Active
                            </span>
                        </button>
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
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by register, area, location, item..." class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <!-- Date From -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date From</label>
                            <input type="date" wire:model.live="filterDateFrom" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <!-- Date Until -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date Until</label>
                            <input type="date" wire:model.live="filterDateUntil" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <!-- Next Date From -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Next Date From</label>
                            <input type="date" wire:model.live="filterNextDateFrom" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <!-- Next Date Until -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Next Date Until</label>
                            <input type="date" wire:model.live="filterNextDateUntil" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                    </div>
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

                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-4">
                        <!-- Filter Register No -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Register No</label>
                            <input type="text"
                                wire:model.live="printRegisterFilter"
                                placeholder="Search by register..."
                                class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
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
                    @if($printRegisterFilter || $printAreaFilter || $printLocationFilter || $printItemFilter || $printDateFrom || $printDateUntil)
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

            <div class="mb-4 text-right">
                @if($filterWorksurface || $filterArea || $filterLocation || $filterItem || $filterJudgementA1 || $filterJudgementA2 || $filterJudgementA3 || $filterDateFrom || $filterDateUntil || $filterNextDateFrom || $filterNextDateUntil || $search)
                    <button wire:click="resetFilters" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                        Clear All Filters
                    </button>
                @endif
            </div>

            <!-- Measurements Table -->
            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-16">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Register No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Area</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Location</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Item</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">A1 Result</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-20">A1 Judgement</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">A2 Result</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-20">A2 Judgement</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">A3 Result</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-20">A3 Judgement</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">A4.1</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">A4.2</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">A4.3</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">A4.4</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">A4.5</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Remarks</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Next Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">Checked By</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($details as $index => $detail)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="detail-{{ $detail->id }}">
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $details->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center text-white font-medium shadow-lg flex-shrink-0 text-xs">
                                            {{ strtoupper(substr($detail->worksurface->register_no ?? '', 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-semibold text-zinc-800 dark:text-white truncate max-w-[180px]" title="{{ $detail->worksurface->register_no ?? '' }}">
                                            {{ $detail->worksurface->register_no ?? 'N/A' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $detail->worksurface->area ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $detail->worksurface->location ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300 uppercase">
                                        {{ $detail->item }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 font-mono">
                                    {{ $detail->a1_scientific }}
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $judgementA1Color = $detail->judgement_a1 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $judgementA1Color }}">
                                        {{ $detail->judgement_a1 }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $detail->a2 }}
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $judgementA2Color = $detail->judgement_a2 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $judgementA2Color }}">
                                        {{ $detail->judgement_a2 }}
                                    </span>
                                </td>
                                {{-- A3 Result --}}
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 font-mono">
                                    {{ $detail->a3 ?? '-' }}
                                </td>
                                {{-- A3 Judgement --}}
                                <td class="px-4 py-3">
                                    @if($detail->judgement_a3)
                                        @php
                                            $judgementA3Color = $detail->judgement_a3 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $judgementA3Color }}">
                                            {{ $detail->judgement_a3 }}
                                        </span>
                                    @else
                                        <span class="text-zinc-400">-</span>
                                    @endif
                                </td>
                                {{-- A4.1 --}}
                                <td class="px-4 py-3 text-center">
                                    @if($detail->a4_1 !== null)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $detail->a4_1 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                            {{ $detail->a4_1 ? 'Yes' : 'No' }}
                                        </span>
                                    @else
                                        <span class="text-zinc-400">-</span>
                                    @endif
                                </td>
                                {{-- A4.2 --}}
                                <td class="px-4 py-3 text-center">
                                    @if($detail->a4_2 !== null)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $detail->a4_2 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                            {{ $detail->a4_2 ? 'Yes' : 'No' }}
                                        </span>
                                    @else
                                        <span class="text-zinc-400">-</span>
                                    @endif
                                </td>
                                {{-- A4.3 --}}
                                <td class="px-4 py-3 text-center">
                                    @if($detail->a4_3 !== null)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $detail->a4_3 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                            {{ $detail->a4_3 ? 'Yes' : 'No' }}
                                        </span>
                                    @else
                                        <span class="text-zinc-400">-</span>
                                    @endif
                                </td>
                                {{-- A4.4 --}}
                                <td class="px-4 py-3 text-center">
                                    @if($detail->a4_4 !== null)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $detail->a4_4 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                            {{ $detail->a4_4 ? 'Yes' : 'No' }}
                                        </span>
                                    @else
                                        <span class="text-zinc-400">-</span>
                                    @endif
                                </td>
                                {{-- A4.5 --}}
                                <td class="px-4 py-3 text-center">
                                    @if($detail->a4_5 !== null)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $detail->a4_5 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                            {{ $detail->a4_5 ? 'Yes' : 'No' }}
                                        </span>
                                    @else
                                        <span class="text-zinc-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 truncate max-w-[150px]" title="{{ $detail->remarks }}">
                                    {{ $detail->remarks ?? '-' }}
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
                            </tr>
                            @empty
                            <tr>
                                <td colspan="21" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <flux:icon name="square-3-stack-3d" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No measurement records found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                                {{ $search || $filterWorksurface ? 'Try adjusting your filters' : 'Get started by adding a new measurement' }}
                                            </p>
                                        </div>
                                        @if($search || $filterWorksurface)
                                            <flux:button wire:click="resetFilters" size="sm">
                                                Clear Filters
                                            </flux:button>
                                        @else
                                            @can('create worksurface details')
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

                {{-- Backdrop --}}
                <div class="fixed inset-0 bg-zinc-900/60 backdrop-blur-sm z-40"
                    x-transition.opacity
                    @click="open = false"></div>

                {{-- Modal Panel --}}
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[92vh] flex flex-col overflow-hidden border border-zinc-200 dark:border-zinc-800"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95">

                        {{-- =================== HEADER STICKY =================== --}}
                        <div class="sticky top-0 z-10 bg-gradient-to-r from-blue-600 via-blue-600 to-indigo-600 px-6 py-4 flex items-center justify-between shadow-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center ring-2 ring-white/30">
                                    <flux:icon name="{{ $detail_id ? 'pencil-square' : 'plus-circle' }}" class="w-5 h-5 text-white" />
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-white leading-tight">
                                        {{ $detail_id ? 'Edit Measurement' : 'New Measurement' }}
                                    </h2>
                                    <p class="text-xs text-blue-100 mt-0.5">
                                        {{ $detail_id ? 'Update existing worksurface measurement record' : 'Add a new worksurface measurement record' }}
                                    </p>
                                </div>
                            </div>
                            <button type="button"
                                    @click="open = false"
                                    class="w-9 h-9 rounded-lg bg-white/10 hover:bg-white/25 flex items-center justify-center text-white transition-colors">
                                <flux:icon name="x-mark" class="w-5 h-5" />
                            </button>
                        </div>

                        {{-- =================== SCROLLABLE BODY =================== --}}
                        <div class="flex-1 overflow-y-auto">
                            <form wire:submit="save" id="detail-form" class="p-6 space-y-6">

                                {{-- ================================================= --}}
                                {{-- SECTION 1: EQUIPMENT INFORMATION                    --}}
                                {{-- ================================================= --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                                            <flux:icon name="cpu-chip" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                                Equipment Information
                                            </h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Select the worksurface equipment being measured</p>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <!-- Worksurface Equipment - Searchable Dropdown -->
                                        <div x-data="{ open: false }"
                                            @click.outside="open = false; $wire.set('showWorksurfaceDropdown', false)">
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">
                                                Worksurface Equipment <span class="text-red-500">*</span>
                                            </label>

                                            {{-- Trigger Button --}}
                                            <div class="relative">
                                                <button type="button"
                                                        @click="open = !open; $wire.set('showWorksurfaceDropdown', open)"
                                                        class="w-full px-3 py-2.5 text-sm text-left border rounded-xl transition-shadow flex items-center justify-between gap-2
                                                            {{ $worksurface_id ? 'border-blue-400 dark:border-blue-600 bg-blue-50/50 dark:bg-blue-900/10' : 'border-zinc-300 dark:border-zinc-600' }}
                                                            dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                                    @if($worksurface_id)
                                                        @php
                                                            $selected = $worksurfaces->firstWhere('id', $worksurface_id);
                                                        @endphp
                                                        <div class="flex items-center gap-2 min-w-0 flex-1">
                                                            <div class="w-6 h-6 rounded-md bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center text-white text-[10px] font-bold flex-shrink-0">
                                                                {{ strtoupper(substr($selected->register_no ?? '?', 0, 1)) }}
                                                            </div>
                                                            <div class="min-w-0">
                                                                <div class="font-semibold text-zinc-800 dark:text-white truncate text-sm">
                                                                    {{ $selected->register_no ?? 'N/A' }}
                                                                </div>
                                                                <div class="text-[11px] text-zinc-500 dark:text-zinc-400 truncate">
                                                                    {{ $selected->area ?? '' }} — {{ $selected->location ?? '' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-zinc-400 dark:text-zinc-500 truncate">— Select Worksurface Equipment —</span>
                                                    @endif

                                                    <div class="flex items-center gap-1 flex-shrink-0">
                                                        @if($worksurface_id)
                                                            <span class="w-6 h-6 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 flex items-center justify-center transition-colors"
                                                                wire:click.stop="clearWorksurface"
                                                                title="Clear">
                                                                <flux:icon name="x-mark" class="w-3.5 h-3.5 text-zinc-500" />
                                                            </span>
                                                        @endif
                                                        <flux:icon name="chevron-down"
                                                                class="w-4 h-4 text-zinc-500 transition-transform duration-150"
                                                                ::class="open ? 'rotate-180' : ''" />
                                                    </div>
                                                </button>

                                                {{-- Dropdown Panel --}}
                                                <div x-show="open"
                                                    x-transition:enter="transition ease-out duration-150"
                                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                                    x-transition:enter-end="opacity-100 translate-y-0"
                                                    x-transition:leave="transition ease-in duration-100"
                                                    x-transition:leave-start="opacity-100 translate-y-0"
                                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                                    x-cloak
                                                    class="absolute z-30 left-0 right-0 mt-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl shadow-2xl overflow-hidden">

                                                    {{-- Search Input --}}
                                                    <div class="p-2 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50">
                                                        <div class="relative">
                                                            <flux:icon name="magnifying-glass"
                                                                    class="w-4 h-4 text-zinc-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                                                            <input type="text"
                                                                wire:model.live.debounce.200ms="worksurfaceSearch"
                                                                placeholder="Search by register, area, location, category..."
                                                                class="w-full pl-9 pr-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                                x-ref="searchInput"
                                                                @keydown.escape="open = false"
                                                                autofocus />
                                                        </div>
                                                    </div>

                                                    {{-- Result List --}}
                                                    <div class="max-h-64 overflow-y-auto py-1">
                                                        @forelse($this->filteredWorksurfaces as $worksurface)
                                                            <button type="button"
                                                                    wire:click="selectWorksurface({{ $worksurface->id }})"
                                                                    @click="open = false"
                                                                    class="w-full px-3 py-2 text-left flex items-center gap-3 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors
                                                                        {{ $worksurface_id == $worksurface->id ? 'bg-blue-50 dark:bg-blue-900/30 ring-inset ring-1 ring-blue-300 dark:ring-blue-700' : '' }}">
                                                                <div class="w-8 h-8 rounded-md bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                                                    {{ strtoupper(substr($worksurface->register_no ?? '?', 0, 1)) }}
                                                                </div>
                                                                <div class="min-w-0 flex-1">
                                                                    <div class="text-sm font-semibold text-zinc-800 dark:text-white truncate">
                                                                        {{ $worksurface->register_no }}
                                                                    </div>
                                                                    <div class="text-xs text-zinc-500 dark:text-zinc-400 truncate">
                                                                        {{ $worksurface->area ?? '-' }}
                                                                        <span class="mx-1">·</span>
                                                                        {{ $worksurface->location ?? '-' }}
                                                                        @if($worksurface->category)
                                                                            <span class="mx-1">·</span>
                                                                            <span class="uppercase">{{ $worksurface->category }}</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                @if($worksurface_id == $worksurface->id)
                                                                    <flux:icon name="check" class="w-4 h-4 text-blue-600 dark:text-blue-400 flex-shrink-0" />
                                                                @endif
                                                            </button>
                                                        @empty
                                                            <div class="px-3 py-8 text-center">
                                                                <flux:icon name="magnifying-glass-x" class="w-8 h-8 text-zinc-300 dark:text-zinc-600 mx-auto mb-2" />
                                                                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                                                    No worksurface found{{ $worksurfaceSearch ? ' for "'.$worksurfaceSearch.'"' : '' }}
                                                                </p>
                                                            </div>
                                                        @endforelse
                                                    </div>

                                                    {{-- Footer Info --}}
                                                    @if($this->filteredWorksurfaces->count() > 0)
                                                        <div class="px-3 py-1.5 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50 text-[11px] text-zinc-500 dark:text-zinc-400">
                                                            Showing {{ $this->filteredWorksurfaces->count() }} of {{ $worksurfaces->count() }} worksurfaces
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            @error('worksurface_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Equipment Info (Readonly) -->
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                            <div>
                                                <label class="block text-[11px] font-semibold mb-1 text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Area</label>
                                                <input type="text" wire:model="area" readonly
                                                    class="w-full px-3 py-2 text-sm border border-zinc-200 dark:border-zinc-700 rounded-lg bg-zinc-100 dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300">
                                            </div>
                                            <div>
                                                <label class="block text-[11px] font-semibold mb-1 text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Location</label>
                                                <input type="text" wire:model="location" readonly
                                                    class="w-full px-3 py-2 text-sm border border-zinc-200 dark:border-zinc-700 rounded-lg bg-zinc-100 dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300">
                                            </div>
                                            <div>
                                                <label class="block text-[11px] font-semibold mb-1 text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Layer Count</label>
                                                <input type="text" wire:model="layer_count" readonly
                                                    class="w-full px-3 py-2 text-sm border border-zinc-200 dark:border-zinc-700 rounded-lg bg-zinc-100 dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300">
                                            </div>
                                            <div>
                                                <label class="block text-[11px] font-semibold mb-1 text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Category</label>
                                                <input type="text" wire:model="category" readonly
                                                    class="w-full px-3 py-2 text-sm border border-zinc-200 dark:border-zinc-700 rounded-lg bg-zinc-100 dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 uppercase">
                                            </div>
                                        </div>

                                        <!-- Item -->
                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">
                                                Item <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" wire:model="item"
                                                oninput="this.value = this.value.toUpperCase()"
                                                placeholder="e.g. WORK SURFACE MAT"
                                                class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 uppercase focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow">
                                            @error('item') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- ================================================= --}}
                                {{-- SECTION 2: RESISTANCE MEASUREMENT (A1, A2, A3)      --}}
                                {{-- ================================================= --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-yellow-100 dark:bg-yellow-900/40 flex items-center justify-center">
                                            <flux:icon name="bolt" class="w-4 h-4 text-yellow-600 dark:text-yellow-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                                Resistance Measurement
                                            </h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">A1, A2, A3 measurement values with automatic judgement</p>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        {{-- A1 --}}
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-yellow-200 dark:border-yellow-800/60 p-4 shadow-sm">
                                            <div class="flex items-start justify-between gap-4 mb-3">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-lg bg-yellow-100 dark:bg-yellow-900/40 flex items-center justify-center flex-shrink-0">
                                                        <span class="text-xs font-bold text-yellow-700 dark:text-yellow-400">A1</span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">Surface Resistance</div>
                                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                                            Standard: &lt; 1.00E+9 Ω
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide
                                                    {{ $judgement_a1 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300 ring-1 ring-green-300 dark:ring-green-700' : ($judgement_a1 == 'NG' ? 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 ring-1 ring-red-300 dark:ring-red-700' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 ring-1 ring-zinc-300 dark:ring-zinc-700') }}">
                                                    @if($judgement_a1 == 'OK')
                                                        <flux:icon name="check-circle" class="w-3 h-3" />
                                                    @elseif($judgement_a1 == 'NG')
                                                        <flux:icon name="x-circle" class="w-3 h-3" />
                                                    @else
                                                        <flux:icon name="clock" class="w-3 h-3" />
                                                    @endif
                                                    {{ $judgement_a1 ?: 'AUTO' }}
                                                </span>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-[11px] font-semibold mb-1 text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Measurement (Ω)</label>
                                                    <input type="number" step="0.01" wire:model="a1" wire:keyup="resetJudgements"
                                                        placeholder="Enter A1 value"
                                                        class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono">
                                                    @error('a1') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label class="block text-[11px] font-semibold mb-1 text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Scientific Notation</label>
                                                    <input type="text" wire:model="a1_scientific" readonly
                                                        class="w-full px-3 py-2 text-sm border border-zinc-200 dark:border-zinc-700 rounded-lg bg-zinc-100 dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 font-mono">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- A2 --}}
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-yellow-200 dark:border-yellow-800/60 p-4 shadow-sm">
                                            <div class="flex items-start justify-between gap-4 mb-3">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-lg bg-yellow-100 dark:bg-yellow-900/40 flex items-center justify-center flex-shrink-0">
                                                        <span class="text-xs font-bold text-yellow-700 dark:text-yellow-400">A2</span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">Surface to Ground</div>
                                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Standard: &lt; 100</div>
                                                    </div>
                                                </div>
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide
                                                    {{ $judgement_a2 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300 ring-1 ring-green-300 dark:ring-green-700' : ($judgement_a2 == 'NG' ? 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 ring-1 ring-red-300 dark:ring-red-700' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 ring-1 ring-zinc-300 dark:ring-zinc-700') }}">
                                                    @if($judgement_a2 == 'OK')
                                                        <flux:icon name="check-circle" class="w-3 h-3" />
                                                    @elseif($judgement_a2 == 'NG')
                                                        <flux:icon name="x-circle" class="w-3 h-3" />
                                                    @else
                                                        <flux:icon name="clock" class="w-3 h-3" />
                                                    @endif
                                                    {{ $judgement_a2 ?: 'AUTO' }}
                                                </span>
                                            </div>
                                            <label class="block text-[11px] font-semibold mb-1 text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Measurement</label>
                                            <input type="number" step="0.01" wire:model="a2" wire:keyup="resetJudgements"
                                                placeholder="Enter A2 value"
                                                class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono">
                                            @error('a2') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- A3 --}}
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-yellow-200 dark:border-yellow-800/60 p-4 shadow-sm">
                                            <div class="flex items-start justify-between gap-4 mb-3">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-lg bg-yellow-100 dark:bg-yellow-900/40 flex items-center justify-center flex-shrink-0">
                                                        <span class="text-xs font-bold text-yellow-700 dark:text-yellow-400">A3</span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">
                                                            Clear Acrylic Static Field Voltage
                                                        </div>
                                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                                            (if any) · Standard: &lt; 100 V
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide
                                                    {{ $judgement_a3 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300 ring-1 ring-green-300 dark:ring-green-700' : ($judgement_a3 == 'NG' ? 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 ring-1 ring-red-300 dark:ring-red-700' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 ring-1 ring-zinc-300 dark:ring-zinc-700') }}">
                                                    @if($judgement_a3 == 'OK')
                                                        <flux:icon name="check-circle" class="w-3 h-3" />
                                                    @elseif($judgement_a3 == 'NG')
                                                        <flux:icon name="x-circle" class="w-3 h-3" />
                                                    @else
                                                        <flux:icon name="clock" class="w-3 h-3" />
                                                    @endif
                                                    {{ $judgement_a3 ?: 'AUTO' }}
                                                </span>
                                            </div>
                                            <label class="block text-[11px] font-semibold mb-1 text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Measurement (V)</label>
                                            <input type="number" step="0.01" wire:model="a3" wire:keyup="resetJudgements"
                                                placeholder="Enter A3 value"
                                                class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono">
                                            @error('a3') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- ================================================= --}}
                                {{-- SECTION 3: VISUAL INSPECTION CHECKLIST (A4.1-A4.5)  --}}
                                {{-- ================================================= --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                                            <flux:icon name="clipboard-document-check" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                                A4 — Visual Inspection Checklist
                                            </h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                Tick <span class="font-semibold text-green-600">YES</span> if condition is met, <span class="font-semibold text-red-600">NO</span> if not
                                            </p>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        @php
                                            $a4Items = [
                                                ['field' => 'a4_1', 'code' => 'A-4.1', 'text' => 'Kondisi permukaan Mat tidak rusak, robek atau terkelupas'],
                                                ['field' => 'a4_2', 'code' => 'A-4.2', 'text' => 'Tidak terdapat material non-ESD yang menutupi permukaan Mat'],
                                                ['field' => 'a4_3', 'code' => 'A-4.3', 'text' => 'Grounding cable terpasang dan tidak putus/terlepas'],
                                                ['field' => 'a4_4', 'code' => 'A-4.4', 'text' => 'Tidak terdapat kerusakan fisik pada frame atau struktur equipment'],
                                                ['field' => 'a4_5', 'code' => 'A-4.5', 'text' => 'Rantai Pada Trolley 3 Pcs dan tidak kendor dan terpasang'],
                                            ];
                                        @endphp

                                        @foreach($a4Items as $item)
                                            @php
                                                $field = $item['field'];
                                                $value = $this->$field;
                                                $isYes = ($value === 1 || $value === true || $value === '1');
                                                $isNo  = ($value === 0 || $value === false || $value === '0');
                                            @endphp
                                            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-3
                                                        flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3
                                                        hover:border-blue-300 dark:hover:border-blue-700 transition-colors
                                                        {{ $isYes ? 'ring-1 ring-green-200 dark:ring-green-900' : ($isNo ? 'ring-1 ring-red-200 dark:ring-red-900' : '') }}">
                                                <div class="flex items-start gap-3 flex-1 min-w-0">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide bg-blue-600 text-white flex-shrink-0 mt-0.5">
                                                        {{ $item['code'] }}
                                                    </span>
                                                    <p class="text-sm text-zinc-700 dark:text-zinc-300 leading-snug">{{ $item['text'] }}</p>
                                                </div>

                                                <div class="flex items-center gap-2 flex-shrink-0 self-end sm:self-auto">
                                                    {{-- YES Button --}}
                                                    <button type="button"
                                                            wire:click="$set('{{ $field }}', {{ $isYes ? 'null' : '1' }})"
                                                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide transition-all duration-150
                                                                {{ $isYes
                                                                    ? 'bg-green-600 text-white shadow-md shadow-green-600/30 ring-2 ring-green-300 dark:ring-green-700 scale-105'
                                                                    : 'bg-white dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 border border-zinc-300 dark:border-zinc-600 hover:bg-green-50 dark:hover:bg-green-900/20 hover:border-green-400 hover:text-green-700 dark:hover:text-green-400' }}">
                                                        <flux:icon name="check-circle" class="w-4 h-4" />
                                                        <span>YES</span>
                                                    </button>

                                                    {{-- NO Button --}}
                                                    <button type="button"
                                                            wire:click="$set('{{ $field }}', {{ $isNo ? 'null' : '0' }})"
                                                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide transition-all duration-150
                                                                {{ $isNo
                                                                    ? 'bg-red-600 text-white shadow-md shadow-red-600/30 ring-2 ring-red-300 dark:ring-red-700 scale-105'
                                                                    : 'bg-white dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 border border-zinc-300 dark:border-zinc-600 hover:bg-red-50 dark:hover:bg-red-900/20 hover:border-red-400 hover:text-red-700 dark:hover:text-red-400' }}">
                                                        <flux:icon name="x-circle" class="w-4 h-4" />
                                                        <span>NO</span>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- ================================================= --}}
                                {{-- SECTION 4: ADDITIONAL NOTES                         --}}
                                {{-- ================================================= --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center">
                                            <flux:icon name="document-text" class="w-4 h-4 text-zinc-600 dark:text-zinc-300" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                                Additional Notes
                                            </h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Remarks and next measurement schedule</p>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <!-- Remarks -->
                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Remarks</label>
                                            <textarea wire:model="remarks" rows="3"
                                                    placeholder="Additional observations, notes, or follow-up actions..."
                                                    class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none transition-shadow"></textarea>
                                            @error('remarks') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Next Date -->
                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Next Measurement Date</label>
                                            <input type="date" wire:model="next_date"
                                                class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow">
                                            @error('next_date') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>

                        {{-- =================== FOOTER STICKY =================== --}}
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
                                <button type="submit"
                                        form="detail-form"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl transition-all text-sm font-semibold shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50">
                                    <flux:icon name="{{ $detail_id ? 'check' : 'plus' }}" class="w-4 h-4" />
                                    {{ $detail_id ? 'Update Measurement' : 'Create Measurement' }}
                                </button>
                            </div>
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
                            Are you sure you want to delete measurement for "{{ $detailToDelete?->worksurface?->register_no ?? 'this worksurface' }}"? This action cannot be undone.
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