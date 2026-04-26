{{-- resources/views/livewire/esd/garment/garment-management.blade.php --}}
<section class="w-full">
    @include('partials.esd-heading')

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
            <!-- Filters -->
            <div class="space-y-4 mb-6">
                <!-- Main Filter Bar -->
                <div class="flex flex-col lg:flex-row gap-4">
                    <!-- Filter Dropdowns -->
                    <div class="flex flex-wrap gap-2 flex-1">
                        <flux:select wire:model.live="departmentFilter" class="w-40">
                            <flux:select.option value="">All Departments</flux:select.option>
                            @foreach($departments as $dept)
                                <flux:select.option value="{{ $dept }}">{{ $dept }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        
                        <flux:select wire:model.live="statusFilter" class="w-40">
                            <flux:select.option value="">All Status</flux:select.option>
                            @foreach($statusOptions as $key => $value)
                                <flux:select.option value="{{ $key }}">{{ $value }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        
                        <flux:select wire:model.live="scheduleFilter" class="w-48">
                            @foreach($scheduleOptions as $key => $value)
                                <flux:select.option value="{{ $key }}">{{ $value }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>
                    
                    <!-- Search & Action Buttons -->
                    <div class="flex gap-2">
                        <flux:input
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search..."
                            icon="magnifying-glass"
                            clearable
                            class="w-64"
                        />
                        <flux:button 
                            href="{{ route('esd.garment-details') }}"
                            wire:navigate
                            icon="arrow-right"
                            variant="primary"
                            color="green"
                            class="whitespace-nowrap"
                        >
                            View All History
                        </flux:button>
                    </div>
                </div>
                
                <!-- Date Range Picker - Hanya muncul ketika custom_range dipilih -->
                @if($scheduleFilter === 'custom_range')
                <div class="flex flex-col sm:flex-row gap-3 p-3 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center gap-2 min-w-fit">
                        <flux:icon.calendar class="w-4 h-4 text-zinc-500" />
                        <span class="text-sm font-medium">Date Range</span>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-3 flex-1">
                        <div class="flex-1">
                            <flux:input 
                                type="date"
                                wire:model.live="dateFrom"
                                placeholder="From"
                                class="w-full"
                            />
                        </div>
                        <div class="flex-1">
                            <flux:input 
                                type="date"
                                wire:model.live="dateTo"
                                placeholder="To"
                                class="w-full"
                            />
                        </div>
                        <flux:button 
                            wire:click="applyDateRange"
                            icon="check"
                            variant="primary"
                            color="blue"
                            size="sm"
                            class="self-end"
                        >
                            Apply
                        </flux:button>
                    </div>
                </div>
                @endif
                
                <!-- Active Filters -->
                @if($search || $departmentFilter || $statusFilter || ($scheduleFilter !== 'all' && $scheduleFilter !== 'custom_range') || ($scheduleFilter === 'custom_range' && $dateFrom && $dateTo))
                <div class="flex items-center gap-2 flex-wrap pt-1">
                    <span class="text-xs text-zinc-500">Filters:</span>
                    
                    @if($search)
                        <flux:badge color="blue" size="sm" variant="subtle" class="gap-1">
                            <flux:icon.magnifying-glass class="w-3 h-3" />
                            {{ $search }}
                        </flux:badge>
                    @endif
                    
                    @if($departmentFilter)
                        <flux:badge color="blue" size="sm" variant="subtle">
                            {{ $departmentFilter }}
                        </flux:badge>
                    @endif
                    
                    @if($statusFilter)
                        <flux:badge color="blue" size="sm" variant="subtle">
                            {{ $statusOptions[$statusFilter] ?? $statusFilter }}
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
                    
                    <flux:button 
                        wire:click="resetFilters" 
                        size="xs" 
                        variant="subtle" 
                        color="red"
                        icon="x-mark"
                    >
                        Clear
                    </flux:button>
                </div>
                @endif
            </div>

            <!-- Garment Table -->
            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-16">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NIK</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Department</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Contract Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">In Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Last Group</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-center">Total Measurement</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-20">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($garments as $index => $garment)
                            @php
                                $garmentDetailsCount = $garment->garmentDetails()->count();
                                // Status mapping untuk 1,2,3
                                $statusLabel = match($garment->status) {
                                    1 => 'Permanent',
                                    2 => 'Contract',
                                    3 => 'Magang',
                                    default => 'Unknown',
                                };
                                $statusColor = match($garment->status) {
                                    1 => 'blue',
                                    2 => 'yellow',
                                    3 => 'purple',
                                    default => 'gray',
                                };
                            @endphp
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="garment-{{ $garment->id }}">
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                    {{ $garments->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="font-mono text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $garment->nik }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm font-semibold text-zinc-800 dark:text-white block">
                                            {{ $garment->name }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <flux:badge size="sm" color="gray" variant="subtle">
                                        {{ $garment->department ?? '-' }}
                                    </flux:badge>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <flux:badge size="sm" :color="$statusColor">
                                        {{ $statusLabel }}
                                    </flux:badge>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                                    {{ $garment->contract_date ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                                    {{ $garment->in_date ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                                    {{ $garment->last_group ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <flux:icon name="document-chart-bar" class="w-4 h-4 text-blue-500" />
                                        <span class="text-sm font-semibold text-zinc-800 dark:text-white">
                                            {{ $garmentDetailsCount }}
                                        </span>
                                        <span class="text-xs text-zinc-500">Records</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <flux:button 
                                        href="{{ route('esd.garments.show', $garment->id) }}"
                                        wire:navigate
                                        size="sm"
                                        icon="eye"
                                        variant="primary"
                                        color="blue"
                                        class="!p-2 flex-shrink-0"
                                        title="View flooring details"
                                    />
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="px-4 py-12 text-center">
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

                <!-- Pagination -->
                @if($garments->hasPages())
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $garments->links() }}
                </div>
                @endif
            </flux:card>
        </div>
    </x-esd.layout>
</section>