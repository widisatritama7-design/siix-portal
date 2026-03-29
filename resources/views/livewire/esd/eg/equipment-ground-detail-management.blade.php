<section class="w-full">
    @include('partials.esd-heading')

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge') }}
    </flux:heading>

    <x-esd.layout 
        class="!max-w-full !px-0 !mx-0"
    >
        <x-slot name="heading">
            <div class="w-full">
                <!-- Breadcrumbs above the heading -->
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
                        Equipment Ground Measurement
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        <x-slot name="subheading">
            <div class="w-full">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                            Equipment Ground Measurement
                        </h1>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            Manage measurement records for ESD equipment ground
                        </p>
                    </div>
                    <flux:button 
                        href="{{ route('esd.equipment-grounds') }}"
                        wire:navigate
                        icon="arrow-left"
                        variant="primary"
                        color="green"
                    >
                        Back to Equipment Ground
                    </flux:button>
                </div>
            </div>
        </x-slot>
        <div class="p-1 space-y-2 w-full">
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
                            <span x-show="filterMachine || filterArea || filterLocation || filterJudgementOhm || filterJudgementVolts || filterDateFrom || filterDateUntil || filterNextDateFrom || filterNextDateUntil || search" 
                                class="ml-1 px-1.5 py-0.5 text-xs bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                Active
                            </span>
                        </button>
                    </div>
                    
                    <!-- Create Button and Clear Filters -->
                    <div class="flex gap-2">
                        @if($filterMachine || $filterArea || $filterLocation || $filterJudgementOhm || $filterJudgementVolts || $filterDateFrom || $filterDateUntil || $filterNextDateFrom || $filterNextDateUntil || $search)
                        <button wire:click="resetFilters" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                            Clear All Filters
                        </button>
                        @endif
                        
                        @can('create equipment ground details')
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
                    class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6 mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Machine Name Filter -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Machine Name</label>
                            <select wire:model.live="filterMachine" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                                <option value="">All Machines</option>
                                @foreach($machines as $machine)
                                    <option value="{{ $machine->id }}">{{ $machine->machine_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Area Filter -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Area</label>
                            <input type="text" wire:model.live.debounce="filterArea" placeholder="Search area..." class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <!-- Location Filter -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Location</label>
                            <input type="text" wire:model.live.debounce="filterLocation" placeholder="Search location..." class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

                        <!-- Judgement Ohm Filter -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Judgement Ohm</label>
                            <select wire:model.live="filterJudgementOhm" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                                <option value="">All</option>
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                            </select>
                        </div>

                        <!-- Judgement Volts Filter -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Judgement Volts</label>
                            <select wire:model.live="filterJudgementVolts" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                                <option value="">All</option>
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                            </select>
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

                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Search</label>
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by machine, area, location..." class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>
                    </div>
                </div>
            </div>

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
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[200px]">Machine Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">Area</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">Location</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Ohm Result</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-20">Judgement</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Volts Result</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-20">Judgement</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Remarks</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Next Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">Checked By</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Actions</th>
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
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-medium shadow-lg flex-shrink-0 text-xs">
                                            {{ strtoupper(substr($detail->equipmentGround->machine_name ?? '', 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-semibold text-zinc-800 dark:text-white truncate max-w-[180px]" title="{{ $detail->equipmentGround->machine_name ?? '' }}">
                                            {{ $detail->equipmentGround->machine_name ?? 'N/A' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $detail->equipmentGround->area ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $detail->equipmentGround->location ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $detail->measure_results_ohm }} Ω
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $ohmColor = $detail->judgement_ohm == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $ohmColor }}">
                                        {{ $detail->judgement_ohm }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $detail->measure_results_volts }} V
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $voltsColor = $detail->judgement_volts == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $voltsColor }}">
                                        {{ $detail->judgement_volts }}
                                    </span>
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
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                        @can('edit equipment ground details')
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

                                        @can('delete equipment ground details')
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
                                <td colspan="13" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <flux:icon name="clipboard-document-list" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No measurement records found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                                {{ $search || $filterMachine || $filterArea || $filterLocation ? 'Try adjusting your filters' : 'Get started by adding a new measurement' }}
                                            </p>
                                        </div>
                                        @if($search || $filterMachine || $filterArea || $filterLocation)
                                            <flux:button wire:click="resetFilters" size="sm">
                                                Clear Filters
                                            </flux:button>
                                        @else
                                            @can('create equipment ground details')
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
                                <!-- Machine Name -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Machine Name <span class="text-red-500">*</span></label>
                                    <select wire:model="equipment_ground_id"
                                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                                        <option value="">Select Machine</option>
                                        @foreach($machines as $machine)
                                            <option value="{{ $machine->id }}">{{ $machine->machine_name }} - {{ $machine->area }} - {{ $machine->location }}</option>
                                        @endforeach
                                    </select>
                                    @error('equipment_ground_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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

                                <!-- Ohm Measurement -->
                                <div class="mb-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                    <div class="text-sm font-semibold text-yellow-800 dark:text-yellow-400 mb-2">Standard: &lt; 1.0 Ohm</div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium mb-1">Measure Results Ohm <span class="text-red-500">*</span></label>
                                            <input type="number" step="0.01" wire:model="measure_results_ohm" wire:keyup="resetJudgement"
                                                   class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                            @error('measure_results_ohm') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">Judgement Ohm</label>
                                            <div class="flex gap-2 mt-2">
                                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $judgement_ohm == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $judgement_ohm ?: 'Auto' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Volts Measurement -->
                                <div class="mb-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                    <div class="text-sm font-semibold text-yellow-800 dark:text-yellow-400 mb-2">Standard: &lt; 2.0 Volts</div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium mb-1">Measure Results Volts <span class="text-red-500">*</span></label>
                                            <input type="number" step="0.01" wire:model="measure_results_volts" wire:keyup="resetJudgement"
                                                   class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                            @error('measure_results_volts') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">Judgement Volts</label>
                                            <div class="flex gap-2 mt-2">
                                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $judgement_volts == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $judgement_volts ?: 'Auto' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Remarks -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Remarks</label>
                                    <textarea wire:model="remarks" rows="3" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700"></textarea>
                                    @error('remarks') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
                            Are you sure you want to delete measurement for "{{ $detailToDelete?->equipmentGround?->machine_name ?? 'this machine' }}"? This action cannot be undone.
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