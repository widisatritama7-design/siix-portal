<section class="w-full">
    
    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge - Scissors Measurement') }}
    </flux:heading>

    <x-esd.layout 
        class="!max-w-full !px-0 !mx-0"
    >
        <x-slot name="heading">
            <div class="w-full">
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
                        Scissors Measurement
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                            Scissors Measurement
                        </h1>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            Manage measurement records for ESD scissors
                        </p>
                    </div>
                    <flux:button 
                        href="{{ route('esd.scissors') }}"
                        wire:navigate
                        icon="arrow-left"
                        variant="primary"
                        color="green"
                    >
                        Back to Scissors
                    </flux:button>
                </div>
            </div>
        </x-slot>
        
        <div class="-mt-2">
            <!-- Header with buttons aligned -->
            <div x-data="{ showFilters: false }">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-1 mb-4">
                    <div class="flex-1">
                        <button 
                            @click="showFilters = !showFilters"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-zinc-700 bg-white border border-zinc-300 rounded-lg hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-600 dark:hover:bg-zinc-700 transition-colors"
                        >
                            {{-- Ikon Plus (saat filter tertutup) --}}
                            <svg x-show="!showFilters" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            {{-- Ikon Minus (saat filter terbuka) --}}
                            <svg x-show="showFilters" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                            <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'"></span>
                            <span x-show="filterScissors || filterJudgementS1 || filterJudgementS2 || filterDateFrom || filterDateUntil || filterNextDateFrom || filterNextDateUntil || search" 
                                class="ml-1 px-1.5 py-0.5 text-xs bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                Active
                            </span>
                        </button>
                    </div>
                    
                    <div class="flex gap-2">
                        @if($filterScissors || $filterJudgementS1 || $filterJudgementS2 || $filterDateFrom || $filterDateUntil || $filterNextDateFrom || $filterNextDateUntil || $search)
                        <button wire:click="resetFilters" class="text-sm text-cyan-600 hover:text-cyan-800 dark:text-cyan-400">
                            Clear All Filters
                        </button>
                        @endif
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
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by register number..." class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-cyan-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <!-- Date From -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date From</label>
                            <input type="date" wire:model.live="filterDateFrom" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-cyan-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <!-- Date Until -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date Until</label>
                            <input type="date" wire:model.live="filterDateUntil" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-cyan-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <!-- Next Date From -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Next Date From</label>
                            <input type="date" wire:model.live="filterNextDateFrom" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-cyan-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <!-- Next Date Until -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Next Date Until</label>
                            <input type="date" wire:model.live="filterNextDateUntil" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-cyan-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>
                    </div>
                </div>
            </div>

            <!-- PRINT SECTION -->
            <div class="mb-4">
                <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700 shadow-sm">
                    <h3 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100 mb-3 flex items-center gap-2">
                        <flux:icon name="printer" class="w-5 h-5" />
                        Print Report
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Register No</label>
                            <input type="text" 
                                wire:model.live="printRegisterNo" 
                                placeholder="Search by register number..."
                                class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-cyan-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date From</label>
                            <input type="date" 
                                wire:model.live="printDateFrom" 
                                class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-cyan-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date Until</label>
                            <input type="date" 
                                wire:model.live="printDateUntil" 
                                class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-cyan-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>
                    </div>
                    
                    @if($printRegisterNo || $printDateFrom || $printDateUntil)
                    <div class="flex gap-2 mt-4">
                        <button wire:click="printPDF" 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <flux:icon name="arrow-down-tray" class="w-4 h-4" />
                            Download PDF
                        </button>
                        
                        <button wire:click="resetPrintFilters" 
                                class="inline-flex items-center gap-2 px-4 py-2 border border-zinc-300 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                            <flux:icon name="arrow-path" class="w-4 h-4" />
                            Reset Filters
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            <style>
                [x-cloak] { display: none !important; }
            </style>

            <!-- Measurements Table -->
            <flux:card class="p-0 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 w-full overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-gradient-to-r from-cyan-600 via-cyan-600 to-teal-600">
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider w-16">#</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[150px]">Register No</th>
                                <th class="px-4 py-4 text-center text-[11px] font-bold text-white uppercase tracking-wider min-w-[120px]">S-1 Result</th>
                                <th class="px-4 py-4 text-center text-[11px] font-bold text-white uppercase tracking-wider w-24">S-1 Judg</th>
                                <th class="px-4 py-4 text-center text-[11px] font-bold text-white uppercase tracking-wider min-w-[100px]">S-2 Result</th>
                                <th class="px-4 py-4 text-center text-[11px] font-bold text-white uppercase tracking-wider w-24">S-2 Judg</th>
                                <th class="px-4 py-4 text-center text-[11px] font-bold text-white uppercase tracking-wider">S-3.1</th>
                                <th class="px-4 py-4 text-center text-[11px] font-bold text-white uppercase tracking-wider">S-3.2</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[150px]">Remarks</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[100px]">Date</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[100px]">Next Date</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[140px]">Checked By</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800 bg-white dark:bg-zinc-900">
                            @forelse($details as $index => $detail)
                            <tr class="group hover:bg-cyan-50/50 dark:hover:bg-cyan-900/10 transition-colors duration-150" wire:key="detail-{{ $detail->id }}">
                                <td class="px-4 py-3">
                                    <span class="text-xs font-bold text-zinc-400 dark:text-zinc-500">
                                        {{ str_pad($details->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-500 to-teal-600 flex items-center justify-center text-white font-bold shadow-md shadow-cyan-500/30 flex-shrink-0 group-hover:scale-105 transition-transform">
                                            {{ strtoupper(substr($detail->scissors->register_no ?? '', 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-semibold text-zinc-800 dark:text-white truncate max-w-[180px]" title="{{ $detail->scissors->register_no ?? '' }}">
                                            {{ $detail->scissors->register_no ?? 'N/A' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center text-sm text-zinc-700 dark:text-zinc-300 font-mono">
                                    {{ $detail->s_1_scientific ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($detail->judgement_s_1)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold whitespace-nowrap {{ $detail->judgement_s_1 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 ring-1 ring-green-300 dark:ring-green-700' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 ring-1 ring-red-300 dark:ring-red-700' }}">
                                            {{ $detail->judgement_s_1 }}
                                        </span>
                                    @else
                                        <span class="text-zinc-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center text-sm text-zinc-700 dark:text-zinc-300 font-mono">
                                    {{ $detail->s_2 !== null ? number_format((float)$detail->s_2, 2) : '-' }} V
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($detail->judgement_s_2)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold whitespace-nowrap {{ $detail->judgement_s_2 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 ring-1 ring-green-300 dark:ring-green-700' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 ring-1 ring-red-300 dark:ring-red-700' }}">
                                            {{ $detail->judgement_s_2 }}
                                        </span>
                                    @else
                                        <span class="text-zinc-400">-</span>
                                    @endif
                                </td>
                                {{-- S-3.1 --}}
                                <td class="px-4 py-3 text-center">
                                    @if($detail->s_3_1 !== null)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $detail->s_3_1 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 ring-1 ring-green-300 dark:ring-green-700' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 ring-1 ring-red-300 dark:ring-red-700' }}">
                                            {{ $detail->s_3_1 ? 'Yes' : 'No' }}
                                        </span>
                                    @else
                                        <span class="text-zinc-400">-</span>
                                    @endif
                                </td>

                                {{-- S-3.2 --}}
                                <td class="px-4 py-3 text-center">
                                    @if($detail->s_3_2 !== null)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $detail->s_3_2 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 ring-1 ring-green-300 dark:ring-green-700' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 ring-1 ring-red-300 dark:ring-red-700' }}">
                                            {{ $detail->s_3_2 ? 'Yes' : 'No' }}
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
                                <td colspan="11" class="px-4 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <flux:icon name="square-3-stack-3d" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No measurement records found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                                {{ $search || $filterScissors ? 'Try adjusting your filters' : 'Get started by adding a new measurement' }}
                                            </p>
                                        </div>
                                        @if($search || $filterScissors)
                                            <flux:button wire:click="resetFilters" size="sm">
                                                Clear Filters
                                            </flux:button>
                                        @else
                                            @can('create scissors details')
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

                <!-- Custom Pagination -->
                @if($details->hasPages())
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-800/30">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-xs text-zinc-500 dark:text-zinc-400 order-2 sm:order-1">
                            Showing
                            <span class="font-bold text-zinc-700 dark:text-zinc-200">{{ $details->firstItem() ?? 0 }}</span>
                            to
                            <span class="font-bold text-zinc-700 dark:text-zinc-200">{{ $details->lastItem() ?? 0 }}</span>
                            of
                            <span class="font-bold text-zinc-700 dark:text-zinc-200">{{ $details->total() }}</span>
                            records
                        </div>
                        <div class="flex items-center gap-1 order-1 sm:order-2">
                            @if($details->onFirstPage())
                                <button disabled class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium rounded-lg text-zinc-400 dark:text-zinc-600 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 cursor-not-allowed">
                                    <flux:icon name="chevron-left" class="w-4 h-4" /> Prev
                                </button>
                            @else
                                <button wire:click="previousPage" wire:loading.attr="disabled" class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium rounded-lg text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 hover:border-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 transition-colors">
                                    <flux:icon name="chevron-left" class="w-4 h-4" /> Prev
                                </button>
                            @endif

                            @php
                                $currentPage = $details->currentPage();
                                $lastPage = $details->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            @endphp

                            @if($start > 1)
                                <button wire:click="gotoPage(1)" class="w-9 h-9 text-xs font-semibold rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 hover:border-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 transition-colors">1</button>
                                @if($start > 2) <span class="px-1 text-zinc-400 dark:text-zinc-600 text-xs">…</span> @endif
                            @endif

                            @for($page = $start; $page <= $end; $page++)
                                @if($page == $currentPage)
                                    <button class="w-9 h-9 text-xs font-bold rounded-lg bg-gradient-to-br from-cyan-600 to-teal-600 text-white shadow-md shadow-cyan-600/30">{{ $page }}</button>
                                @else
                                    <button wire:click="gotoPage({{ $page }})" class="w-9 h-9 text-xs font-semibold rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 hover:border-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 transition-colors">{{ $page }}</button>
                                @endif
                            @endfor

                            @if($end < $lastPage)
                                @if($end < $lastPage - 1) <span class="px-1 text-zinc-400 dark:text-zinc-600 text-xs">…</span> @endif
                                <button wire:click="gotoPage({{ $lastPage }})" class="w-9 h-9 text-xs font-semibold rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 hover:border-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 transition-colors">{{ $lastPage }}</button>
                            @endif

                            @if($details->hasMorePages())
                                <button wire:click="nextPage" wire:loading.attr="disabled" class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium rounded-lg text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 hover:border-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 transition-colors">
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

            <!-- MODAL FORM MEASUREMENT DETAIL -->
            <div x-data="{ open: false }"
                x-show="open"
                @open-modal.window="if ($event.detail === 'detail-form-modal') open = true"
                @close-modal.window="if ($event.detail === 'detail-form-modal') open = false"
                @keydown.escape.window="open = false"
                x-cloak>

                <div class="fixed inset-0 bg-zinc-900/60 backdrop-blur-sm z-40" x-transition.opacity @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[92vh] flex flex-col overflow-hidden border border-zinc-200 dark:border-zinc-800"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100">

                        {{-- HEADER --}}
                        <div class="sticky top-0 z-10 bg-gradient-to-r from-cyan-600 via-cyan-600 to-teal-600 px-6 py-4 flex items-center justify-between shadow-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center ring-2 ring-white/30">
                                    <flux:icon name="{{ $detail_id ? 'pencil-square' : 'plus-circle' }}" class="w-5 h-5 text-white" />
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-white leading-tight">
                                        {{ $detail_id ? 'Edit Measurement' : 'New Measurement' }}
                                    </h2>
                                    <p class="text-xs text-cyan-100 mt-0.5">
                                        {{ $register_no ?: 'Scissors Measurement' }}
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
                            <form wire:submit="save" id="scissors-detail-form" class="p-6 space-y-6">
                                <input type="hidden" wire:model="scissors_id">

                                {{-- SECTION 1: IDENTIFICATION (HANYA SAAT ADD NEW) --}}
                                @if(!$detail_id)
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-cyan-100 dark:bg-cyan-900/40 flex items-center justify-center">
                                            <flux:icon name="identification" class="w-4 h-4 text-cyan-600 dark:text-cyan-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">Identification</h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Select equipment</p>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Register No <span class="text-red-500">*</span></label>
                                        <select wire:model="scissors_id"
                                                class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                                            <option value="">Select Register No</option>
                                            @foreach($scissors as $scissor)
                                                <option value="{{ $scissor->id }}">{{ $scissor->register_no }} - {{ $scissor->area }} - {{ $scissor->location }}</option>
                                            @endforeach
                                        </select>
                                        @error('scissors_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                @endif

                                {{-- SECTION 2: MEASUREMENTS (S-1 & S-2) --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-yellow-100 dark:bg-yellow-900/40 flex items-center justify-center">
                                            <flux:icon name="beaker" class="w-4 h-4 text-yellow-600 dark:text-yellow-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">Measurement Results</h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">S-1 (Resistance) & S-2 (Voltage)</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        {{-- S-1 --}}
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-cyan-200 dark:border-cyan-800/60 p-4">
                                            <div class="flex items-start justify-between gap-2 mb-3">
                                                <div>
                                                    <div class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">S-1 — Point To Point</div>
                                                    <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">≥ 1.00E+4 to &lt; 1.00E+11 Ω</div>
                                                </div>
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide
                                                    {{ $judgement_s_1 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300 ring-1 ring-green-300 dark:ring-green-700' : ($judgement_s_1 == 'NG' ? 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 ring-1 ring-red-300 dark:ring-red-700' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 ring-1 ring-zinc-300 dark:ring-zinc-700') }}">
                                                    @if($judgement_s_1 == 'OK')
                                                        <flux:icon name="check-circle" class="w-3 h-3" />
                                                    @elseif($judgement_s_1 == 'NG')
                                                        <flux:icon name="x-circle" class="w-3 h-3" />
                                                    @else
                                                        <flux:icon name="clock" class="w-3 h-3" />
                                                    @endif
                                                    {{ $judgement_s_1 ?: 'AUTO' }}
                                                </span>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    <label class="block text-[10px] font-semibold mb-1 text-zinc-500 dark:text-zinc-400 uppercase">Measurement</label>
                                                    <input type="number" step="0.01" wire:model="s_1" wire:keyup="resetJudgements"
                                                           placeholder="Enter value"
                                                           class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-cyan-500 font-mono">
                                                    @error('s_1') <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-semibold mb-1 text-zinc-500 dark:text-zinc-400 uppercase">Scientific</label>
                                                    <input type="text" wire:model="s_1_scientific" readonly
                                                           placeholder="-"
                                                           class="w-full px-3 py-2 text-sm border border-zinc-200 dark:border-zinc-700 rounded-lg bg-zinc-100 dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 font-mono">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- S-2 --}}
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-blue-200 dark:border-blue-800/60 p-4">
                                            <div class="flex items-start justify-between gap-2 mb-3">
                                                <div>
                                                    <div class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">S-2 — Static Voltage</div>
                                                    <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Standard: &lt; 100 V</div>
                                                </div>
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide
                                                    {{ $judgement_s_2 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300 ring-1 ring-green-300 dark:ring-green-700' : ($judgement_s_2 == 'NG' ? 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 ring-1 ring-red-300 dark:ring-red-700' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 ring-1 ring-zinc-300 dark:ring-zinc-700') }}">
                                                    @if($judgement_s_2 == 'OK')
                                                        <flux:icon name="check-circle" class="w-3 h-3" />
                                                    @elseif($judgement_s_2 == 'NG')
                                                        <flux:icon name="x-circle" class="w-3 h-3" />
                                                    @else
                                                        <flux:icon name="clock" class="w-3 h-3" />
                                                    @endif
                                                    {{ $judgement_s_2 ?: 'AUTO' }}
                                                </span>
                                            </div>
                                            <label class="block text-[10px] font-semibold mb-1 text-zinc-500 dark:text-zinc-400 uppercase">Measurement (V)</label>
                                            <input type="number" step="0.01" wire:model="s_2" wire:keyup="resetJudgements"
                                                   placeholder="Enter value"
                                                   class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-cyan-500 font-mono">
                                            @error('s_2') <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- SECTION 3: NOTES --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center">
                                            <flux:icon name="document-text" class="w-4 h-4 text-zinc-600 dark:text-zinc-300" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                                Additional Notes
                                            </h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                Remarks and next measurement schedule
                                            </p>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Remarks</label>
                                            <textarea wire:model="remarks" rows="3"
                                                      placeholder="Additional observations, notes, or follow-up actions..."
                                                      class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-cyan-500 resize-none"></textarea>
                                            @error('remarks') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Next Measurement Date</label>
                                            <input type="date" wire:model="next_date"
                                                   class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-cyan-500">
                                            @error('next_date') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
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
                                <button type="submit" form="scissors-detail-form" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white rounded-xl transition-all text-sm font-semibold shadow-lg shadow-cyan-600/30 hover:shadow-cyan-600/50">
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
                            <flux:icon name="exclamation-triangle" class="w-8 h-8 text-red-600" />
                        </div>

                        <h3 class="text-lg font-bold mb-2">Delete Measurement Record</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Are you sure you want to delete measurement for "{{ $detailToDelete?->scissors?->register_no ?? 'this scissors' }}"? This action cannot be undone.
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