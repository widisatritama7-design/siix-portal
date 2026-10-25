{{-- resources/views/livewire/esd/garment/garment-management.blade.php --}}
<section class="w-full">
    

    <flux:heading class="sr-only">
        {{ __('Garment Management') }}
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
                        Garment
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                    Garment
                </h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    Manage employee garment records
                </p>
            </div>
        </x-slot>
        
        <div class="-mt-2">

            {{-- ===================== FILTER SECTION ===================== --}}
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-lg border border-zinc-200 dark:border-zinc-800 p-5 mb-6">

                {{-- Main Filter Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
                    <flux:select wire:model.live="departmentFilter">
                        <flux:select.option value="">All Departments</flux:select.option>
                        @foreach($departments as $dept)
                            <flux:select.option value="{{ $dept }}">{{ $dept }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:select wire:model.live="statusFilter">
                        <flux:select.option value="">All Status</flux:select.option>
                        @foreach($statusOptions as $key => $value)
                            <flux:select.option value="{{ $key }}">{{ $value }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:select wire:model.live="measurementFilter">
                        @foreach($measurementOptions as $key => $value)
                            <flux:select.option value="{{ $key }}">{{ $value }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:select wire:model.live="scheduleFilter">
                        @foreach($scheduleOptions as $key => $value)
                            <flux:select.option value="{{ $key }}">{{ $value }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>

                {{-- Search & Action --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <flux:input
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search by NIK, name, department..."
                            icon="magnifying-glass"
                            clearable
                            class="w-full"
                        />
                    </div>
                    <div class="w-full sm:w-auto">
                        <flux:button
                            href="{{ route('esd.garment-details') }}"
                            wire:navigate
                            icon="arrow-right"
                            variant="primary"
                            color="green"
                            class="w-full sm:w-auto justify-center whitespace-nowrap"
                        >
                            View All History
                        </flux:button>
                    </div>
                </div>

                {{-- Custom Date Range --}}
                @if($scheduleFilter === 'custom_range')
                <div class="mt-4 flex flex-col sm:flex-row gap-3 p-4 bg-purple-50 dark:bg-purple-900/20 rounded-xl border border-purple-200 dark:border-purple-800">
                    <div class="flex items-center gap-2 min-w-fit">
                        <flux:icon.calendar class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                        <span class="text-sm font-semibold text-purple-800 dark:text-purple-300">Date Range</span>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 flex-1">
                        <div class="flex-1">
                            <flux:input type="date" wire:model.live="dateFrom" placeholder="From" class="w-full" />
                        </div>
                        <div class="flex-1">
                            <flux:input type="date" wire:model.live="dateTo" placeholder="To" class="w-full" />
                        </div>
                        <div class="w-full sm:w-auto">
                            <flux:button wire:click="applyDateRange" icon="check" variant="primary" color="purple" class="w-full sm:w-auto justify-center">
                                Apply
                            </flux:button>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Active Filters (hanya muncul kalau ada filter yang aktif) --}}
                @if($search || $departmentFilter || $statusFilter || $measurementFilter || $scheduleFilter !== 'all' && $scheduleFilter !== 'custom_range' || ($scheduleFilter === 'custom_range' && $dateFrom && $dateTo))
                <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700 flex items-center gap-2 flex-wrap">
                    <span class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Active:</span>

                    @if($search)
                        <flux:badge color="blue" size="sm" variant="subtle" class="gap-1">
                            <flux:icon.magnifying-glass class="w-3 h-3" />
                            {{ $search }}
                        </flux:badge>
                    @endif

                    @if($departmentFilter)
                        <flux:badge color="blue" size="sm" variant="subtle">{{ $departmentFilter }}</flux:badge>
                    @endif

                    @if($statusFilter)
                        <flux:badge color="blue" size="sm" variant="subtle">{{ $statusOptions[$statusFilter] ?? $statusFilter }}</flux:badge>
                    @endif

                    @if($measurementFilter)
                        <flux:badge color="blue" size="sm" variant="subtle">
                            {{ $measurementOptions[$measurementFilter] ?? $measurementFilter }}
                        </flux:badge>
                    @endif

                    @if($scheduleFilter === 'this_week')
                        <flux:badge color="green" size="sm" variant="subtle">
                            This Week ({{ \Carbon\Carbon::parse($dateFrom)->format('M d') }} - {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }})
                        </flux:badge>
                    @elseif($scheduleFilter === 'custom_range' && $dateFrom && $dateTo)
                        <flux:badge color="green" size="sm" variant="subtle">
                            {{ \Carbon\Carbon::parse($dateFrom)->format('M d') }} - {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}
                        </flux:badge>
                    @endif

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
                            <tr class="bg-gradient-to-r from-purple-600 via-purple-600 to-fuchsia-600">
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider w-16">#</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[100px]">NIK</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[160px]">Name</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[130px]">Department</th>
                                <th class="px-4 py-4 text-center text-[11px] font-bold text-white uppercase tracking-wider w-28">Status</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[110px]">Contract Date</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[110px]">In Date</th>
                                <th class="px-4 py-4 text-left text-[11px] font-bold text-white uppercase tracking-wider min-w-[110px]">Last Group</th>
                                <th class="px-4 py-4 text-center text-[11px] font-bold text-white uppercase tracking-wider min-w-[130px]">Measurements</th>
                                <th class="px-4 py-4 text-right text-[11px] font-bold text-white uppercase tracking-wider w-24">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800 bg-white dark:bg-zinc-900">
                            @forelse($garments as $index => $garment)
                            @php
                                $garmentDetailsCount = $garment->garmentDetails()->count();
                                $statusLabel = match($garment->status) {
                                    1 => 'Permanent',
                                    2 => 'Contract',
                                    3 => 'Magang',
                                    default => 'Unknown',
                                };
                                $statusConfig = match($garment->status) {
                                    1 => ['bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 ring-1 ring-blue-300 dark:ring-blue-700', 'bg-blue-500'],
                                    2 => ['bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 ring-1 ring-yellow-300 dark:ring-yellow-700', 'bg-yellow-500'],
                                    3 => ['bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400 ring-1 ring-purple-300 dark:ring-purple-700', 'bg-purple-500'],
                                    default => ['bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300 ring-1 ring-zinc-300 dark:ring-zinc-600', 'bg-zinc-500'],
                                };
                            @endphp
                            <tr class="group hover:bg-purple-50/50 dark:hover:bg-purple-900/10 transition-colors duration-150" wire:key="garment-{{ $garment->id }}">

                                {{-- Index --}}
                                <td class="px-4 py-3">
                                    <span class="text-xs font-bold text-zinc-400 dark:text-zinc-500">
                                        {{ str_pad($garments->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>

                                {{-- NIK --}}
                                <td class="px-4 py-3">
                                    <span class="font-mono text-xs font-semibold text-zinc-700 dark:text-zinc-300 px-2 py-1 rounded bg-zinc-100 dark:bg-zinc-800">
                                        {{ $garment->nik }}
                                    </span>
                                </td>

                                {{-- Name --}}
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-purple-500 to-fuchsia-600 flex items-center justify-center text-white text-xs font-bold shadow-md shadow-purple-500/30 flex-shrink-0 group-hover:scale-105 transition-transform">
                                            {{ strtoupper(substr($garment->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <span class="text-sm font-semibold text-zinc-800 dark:text-white block truncate max-w-[200px]" title="{{ $garment->name }}">
                                                {{ $garment->name }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Department --}}
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 truncate max-w-[150px]" title="{{ $garment->department ?? '-' }}">
                                        {{ $garment->department ?? '-' }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusConfig[0] }} whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig[1] }}"></span>
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                {{-- Contract Date --}}
                                <td class="px-4 py-3 text-xs text-zinc-700 dark:text-zinc-300">
                                    {{ $garment->contract_date ?? '-' }}
                                </td>

                                {{-- In Date --}}
                                <td class="px-4 py-3 text-xs text-zinc-700 dark:text-zinc-300">
                                    {{ $garment->in_date ?? '-' }}
                                </td>

                                {{-- Last Group --}}
                                <td class="px-4 py-3 text-xs text-zinc-700 dark:text-zinc-300">
                                    {{ $garment->last_group ?? '-' }}
                                </td>

                                {{-- Measurements --}}
                                <td class="px-4 py-3 text-center">
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800">
                                        <flux:icon name="document-chart-bar" class="w-3.5 h-3.5 text-purple-600 dark:text-purple-400" />
                                        <span class="text-xs font-bold text-purple-700 dark:text-purple-300">
                                            {{ $garmentDetailsCount }}
                                        </span>
                                        <span class="text-[10px] text-purple-600 dark:text-purple-400">
                                            {{ $garmentDetailsCount === 1 ? 'rec' : 'recs' }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="px-4 py-3 text-right">
                                    <div class="relative group/tooltip inline-block">
                                        <flux:button
                                            href="{{ route('esd.garments.show', $garment->id) }}"
                                            wire:navigate
                                            size="sm"
                                            icon="eye"
                                            variant="primary"
                                            color="purple"
                                            class="!p-2 flex-shrink-0"
                                        />
                                        <div class="absolute bottom-full right-0 mb-2 px-3 py-1.5 rounded-lg bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-medium whitespace-nowrap opacity-0 group-hover/tooltip:opacity-100 pointer-events-none transition-opacity duration-150 shadow-lg z-50">
                                            View details
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="px-4 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <flux:icon name="users" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No garment records found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                                {{ $search || $departmentFilter || $statusFilter ? 'Try adjusting your filters' : 'No garment data available' }}
                                            </p>
                                        </div>
                                        @if($search || $departmentFilter || $statusFilter)
                                            <flux:button wire:click="resetFilters" size="sm">
                                                Clear Filters
                                            </flux:button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- ===================== CUSTOM PAGINATION ===================== --}}
                @if($garments->hasPages())
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-800/30">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">

                        {{-- Info --}}
                        <div class="text-xs text-zinc-500 dark:text-zinc-400 order-2 sm:order-1">
                            Showing
                            <span class="font-bold text-zinc-700 dark:text-zinc-200">{{ $garments->firstItem() ?? 0 }}</span>
                            to
                            <span class="font-bold text-zinc-700 dark:text-zinc-200">{{ $garments->lastItem() ?? 0 }}</span>
                            of
                            <span class="font-bold text-zinc-700 dark:text-zinc-200">{{ $garments->total() }}</span>
                            records
                        </div>

                        {{-- Pagination Controls --}}
                        <div class="flex items-center gap-1 order-1 sm:order-2">

                            {{-- Previous --}}
                            @if($garments->onFirstPage())
                                <button disabled
                                        class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium rounded-lg text-zinc-400 dark:text-zinc-600 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 cursor-not-allowed">
                                    <flux:icon name="chevron-left" class="w-4 h-4" />
                                    Prev
                                </button>
                            @else
                                <button wire:click="previousPage"
                                        wire:loading.attr="disabled"
                                        class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium rounded-lg text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 hover:bg-purple-50 dark:hover:bg-purple-900/20 hover:border-purple-400 hover:text-purple-700 dark:hover:text-purple-300 transition-colors">
                                    <flux:icon name="chevron-left" class="w-4 h-4" />
                                    Prev
                                </button>
                            @endif

                            {{-- Page Numbers --}}
                            @php
                                $currentPage = $garments->currentPage();
                                $lastPage = $garments->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            @endphp

                            @if($start > 1)
                                <button wire:click="gotoPage(1)"
                                        class="w-9 h-9 text-xs font-semibold rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 hover:border-purple-400 hover:text-purple-700 dark:hover:text-purple-300 transition-colors">
                                    1
                                </button>
                                @if($start > 2)
                                    <span class="px-1 text-zinc-400 dark:text-zinc-600 text-xs">…</span>
                                @endif
                            @endif

                            @for($page = $start; $page <= $end; $page++)
                                @if($page == $currentPage)
                                    <button class="w-9 h-9 text-xs font-bold rounded-lg bg-gradient-to-br from-purple-600 to-fuchsia-600 text-white shadow-md shadow-purple-600/30">
                                        {{ $page }}
                                    </button>
                                @else
                                    <button wire:click="gotoPage({{ $page }})"
                                            class="w-9 h-9 text-xs font-semibold rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 hover:border-purple-400 hover:text-purple-700 dark:hover:text-purple-300 transition-colors">
                                        {{ $page }}
                                    </button>
                                @endif
                            @endfor

                            @if($end < $lastPage)
                                @if($end < $lastPage - 1)
                                    <span class="px-1 text-zinc-400 dark:text-zinc-600 text-xs">…</span>
                                @endif
                                <button wire:click="gotoPage({{ $lastPage }})"
                                        class="w-9 h-9 text-xs font-semibold rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 hover:border-purple-400 hover:text-purple-700 dark:hover:text-purple-300 transition-colors">
                                    {{ $lastPage }}
                                </button>
                            @endif

                            {{-- Next --}}
                            @if($garments->hasMorePages())
                                <button wire:click="nextPage"
                                        wire:loading.attr="disabled"
                                        class="inline-flex items-center gap-1 px-3 py-2 text-xs font-medium rounded-lg text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 hover:bg-purple-50 dark:hover:bg-purple-900/20 hover:border-purple-400 hover:text-purple-700 dark:hover:text-purple-300 transition-colors">
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

        </div>
    </x-esd.layout>
</section>