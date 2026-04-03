{{-- resources/views/livewire/esd/garment/garment-show.blade.php --}}
<section class="w-full">
    @include('partials.esd-heading')

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge - Garment Detail') }}
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
                    <flux:breadcrumbs.item href="{{ route('esd.garments') }}" wire:navigate separator="slash">
                        Garment
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        View
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="w-full sm:w-auto">
                        <h1 class="text-2xl sm:text-3xl font-bold text-zinc-800 dark:text-white">
                            View Garment
                        </h1>
                        <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            View detailed information about garment
                        </p>
                    </div>
                    <div class="w-full sm:w-auto flex-shrink-0">
                        <flux:button 
                            href="{{ route('esd.garments') }}"
                            wire:navigate
                            icon="arrow-left"
                            variant="primary"
                            color="blue"
                            class="w-full sm:w-auto justify-center"
                        >
                            Back to List
                        </flux:button>
                    </div>
                </div>
            </div>
        </x-slot>
        
        <div class="-mt-2">
            <!-- Garment Information Card -->
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden mb-6">
                <!-- Header with Solid Color -->
                <div class="bg-purple-600 dark:bg-purple-500 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="font-semibold text-base text-white">Garment Information</h3>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                        <!-- NIK -->
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">NIK</label>
                            <p class="mt-1 text-base font-semibold text-zinc-800 dark:text-white">
                                {{ $garment->nik }}
                            </p>
                        </div>

                        <!-- Name -->
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Name</label>
                            <p class="mt-1 text-base text-zinc-800 dark:text-white">
                                {{ $garment->name }}
                            </p>
                        </div>

                        <!-- Department -->
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Department</label>
                            <p class="mt-1 text-base text-zinc-800 dark:text-white">
                                {{ $garment->department ?? '-' }}
                            </p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Status</label>
                            <div class="mt-1 flex justify-center">
                                @php
                                    $statusLabel = match($garment->status) {
                                        1 => 'Permanent',
                                        2 => 'Contract',
                                        3 => 'Magang',
                                        default => 'Unknown',
                                    };
                                    $statusColor = match($garment->status) {
                                        1 => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                        2 => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        3 => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </flux:card>

            <!-- Standard ESD Garment Card -->
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden mb-6">
                <!-- Header with Solid Color -->
                <div class="bg-purple-600 dark:bg-purple-500 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <flux:icon name="bolt" class="w-5 h-5 text-white" />
                        <h3 class="font-semibold text-base text-white">Standard ESD Of Garment</h3>
                    </div>
                </div>
                
                <div class="p-6" x-data="{ open: false }">
                    <!-- Toggle Button -->
                    <button 
                        @click="open = !open"
                        class="w-full flex items-center justify-between p-3 bg-gray-50 dark:bg-zinc-800/50 rounded-lg hover:bg-gray-100 dark:hover:bg-zinc-800 transition-all duration-200 group"
                    >
                        <div class="flex items-center gap-2">
                            <flux:icon name="beaker" class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">View Standard Details</span>
                        </div>
                        <div class="text-zinc-500 transition-transform duration-200" :class="{'rotate-180': open}">
                            <flux:icon name="chevron-down" class="w-5 h-5" />
                        </div>
                    </button>
                    
                    <!-- Collapsible Content -->
                    <div x-show="open" x-collapse x-cloak class="mt-4">
                        <div class="border-t border-zinc-200 dark:border-zinc-700 pt-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Standard Value -->
                                <div class="bg-purple-50 dark:bg-purple-950/30 rounded-lg p-4 text-center">
                                    <div class="flex items-center justify-center gap-2 mb-3">
                                        <flux:icon name="beaker" class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                                        <span class="text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase tracking-wider">Static Control Garment | Resistance Point to Point</span>
                                    </div>
                                    <p class="text-xl font-bold text-purple-700 dark:text-purple-400">
                                        ≥ 1.00E+4 Ohm - < 1.00E+11 Ohm
                                    </p>
                                    <p class="text-xs text-purple-600 dark:text-purple-400 mt-1 font-medium">
                                        Shirt (D1) • Pants (D2) • Cap (D3) • Hijab (D4)
                                    </p>
                                </div>
                                
                                <!-- Frequency -->
                                <div class="bg-purple-50 dark:bg-purple-950/30 rounded-lg p-4 text-center">
                                    <div class="flex items-center justify-center gap-2 mb-3">
                                        <flux:icon name="calendar" class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                                        <span class="text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase tracking-wider">Frequency</span>
                                    </div>
                                    <p class="text-3xl font-bold text-purple-700 dark:text-purple-400">
                                        Yearly
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Document Reference -->
                            <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-3">
                                    <div class="flex items-center gap-2">
                                        <flux:icon name="document-text" class="w-4 h-4 text-zinc-500" />
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">Document Reference</span>
                                    </div>
                                    <code class="text-sm font-mono font-bold text-zinc-800 dark:text-white bg-white dark:bg-zinc-900 px-3 py-1 rounded">
                                        QR-ADM-22-K026
                                    </code>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </flux:card>

            <!-- Measurements Section -->
            <div class="mt-6">
                <div class="mb-4">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
                        <h2 class="text-xl font-bold text-zinc-800 dark:text-white order-1 sm:order-1">
                            Measurement History
                        </h2>
                        <div class="order-2 sm:order-2">
                            @can('create garment details')
                            <flux:button 
                                variant="primary" 
                                icon="plus" 
                                class="bg-blue-600 hover:bg-blue-700 w-full sm:w-auto justify-center"
                                wire:click="resetForm"
                                x-on:click="$dispatch('open-modal', 'detail-form-modal')"
                            >
                                Add New Measurement
                            </flux:button>
                            @endcan
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-700 p-4 mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
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

                    @if($filterDateFrom || $filterDateUntil || $filterNextDateFrom || $filterNextDateUntil || $search)
                    <div class="mt-3 text-right">
                        <button wire:click="resetFilters" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                            Clear All Filters
                        </button>
                    </div>
                    @endif
                </div>

                <!-- Measurements Table -->
                <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 w-full">
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Shirt (D1)</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-20">Judgement</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Pants (D2)</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-20">Judgement</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Cap (D3)</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-20">Judgement</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Hijab (D4)</th>
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
                                    <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 font-mono">
                                        {{ $detail->d1_scientific ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($detail->judgement_d1)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $detail->judgement_d1 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                {{ $detail->judgement_d1 }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 font-mono">
                                        {{ $detail->d2_scientific ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($detail->judgement_d2)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $detail->judgement_d2 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                {{ $detail->judgement_d2 }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 font-mono">
                                        {{ $detail->d3_scientific ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($detail->judgement_d3)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $detail->judgement_d3 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                {{ $detail->judgement_d3 }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 font-mono">
                                        {{ $detail->d4_scientific ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($detail->judgement_d4)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $detail->judgement_d4 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                {{ $detail->judgement_d4 }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">-</span>
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
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                            @can('edit garment details')
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

                                            @can('delete garment details')
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
                                                <flux:icon name="square-3-stack-3d" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                    No measurement records found
                                                </h3>
                                                <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                                    {{ $search || $filterDateFrom || $filterDateUntil || $filterNextDateFrom || $filterNextDateUntil ? 'Try adjusting your filters' : 'Get started by adding a new measurement' }}
                                                </p>
                                            </div>
                                            @if($search || $filterDateFrom || $filterDateUntil || $filterNextDateFrom || $filterNextDateUntil)
                                                <flux:button wire:click="resetFilters" size="sm">
                                                    Clear Filters
                                                </flux:button>
                                            @else
                                                @can('create garment details')
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
            </div>

            <!-- MODAL FORM MEASUREMENT DETAIL -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-modal.window="if ($event.detail === 'detail-form-modal') open = true"
                 @close-modal.window="if ($event.detail === 'detail-form-modal') open = false"
                 x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                            <form wire:submit="save">
                                <!-- Hidden Input for nik -->
                                <input type="hidden" wire:model="nik" value="{{ $garment->id }}">
                                <input type="hidden" wire:model="name" value="{{ $garment->name }}">

                                <!-- D1 - Shirt Measurement -->
                                <div class="mb-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                    <div class="text-sm font-semibold text-yellow-800 dark:text-yellow-400 mb-2">
                                        Shirt Point to Point
                                    </div>
                                    <div class="text-xs text-yellow-600 dark:text-yellow-500 mb-3">
                                        Standard: ≥ 1.00E+4 Ohm - < 1.00E+11 Ohm
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium mb-1">D1 Measurement (Ohm)</label>
                                            <input type="number" step="0.01" wire:model="d1" wire:keyup="resetJudgements"
                                                   class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700"
                                                   placeholder="Enter value in Ohm">
                                            @error('d1') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">D1 Scientific</label>
                                            <input type="text" wire:model="d1_scientific" readonly 
                                                   class="w-full px-3 py-2 border rounded-lg bg-gray-100 dark:bg-zinc-800 dark:border-zinc-700 font-mono"
                                                   placeholder="-">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">Judgement D1</label>
                                            <div class="mt-1">
                                                @if($judgement_d1)
                                                    <span class="inline-flex px-3 py-2 rounded-full text-sm font-medium {{ $judgement_d1 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                        {{ $judgement_d1 }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-3 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">-</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- D2 - Pants Measurement -->
                                <div class="mb-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                    <div class="text-sm font-semibold text-yellow-800 dark:text-yellow-400 mb-2">
                                        Pants Point to Point
                                    </div>
                                    <div class="text-xs text-yellow-600 dark:text-yellow-500 mb-3">
                                        Standard: ≥ 1.00E+4 Ohm - < 1.00E+11 Ohm
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium mb-1">D2 Measurement (Ohm)</label>
                                            <input type="number" step="0.01" wire:model="d2" wire:keyup="resetJudgements"
                                                   class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700"
                                                   placeholder="Enter value in Ohm">
                                            @error('d2') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">D2 Scientific</label>
                                            <input type="text" wire:model="d2_scientific" readonly 
                                                   class="w-full px-3 py-2 border rounded-lg bg-gray-100 dark:bg-zinc-800 dark:border-zinc-700 font-mono"
                                                   placeholder="-">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">Judgement D2</label>
                                            <div class="mt-1">
                                                @if($judgement_d2)
                                                    <span class="inline-flex px-3 py-2 rounded-full text-sm font-medium {{ $judgement_d2 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                        {{ $judgement_d2 }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-3 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">-</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- D3 - Cap Measurement -->
                                <div class="mb-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                    <div class="text-sm font-semibold text-yellow-800 dark:text-yellow-400 mb-2">
                                        Cap Point to Point
                                    </div>
                                    <div class="text-xs text-yellow-600 dark:text-yellow-500 mb-3">
                                        Standard: ≥ 1.00E+4 Ohm - < 1.00E+11 Ohm
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium mb-1">D3 Measurement (Ohm)</label>
                                            <input type="number" step="0.01" wire:model="d3" wire:keyup="resetJudgements"
                                                   class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700"
                                                   placeholder="Enter value in Ohm">
                                            @error('d3') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">D3 Scientific</label>
                                            <input type="text" wire:model="d3_scientific" readonly 
                                                   class="w-full px-3 py-2 border rounded-lg bg-gray-100 dark:bg-zinc-800 dark:border-zinc-700 font-mono"
                                                   placeholder="-">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">Judgement D3</label>
                                            <div class="mt-1">
                                                @if($judgement_d3)
                                                    <span class="inline-flex px-3 py-2 rounded-full text-sm font-medium {{ $judgement_d3 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                        {{ $judgement_d3 }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-3 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">-</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- D4 - Hijab Measurement -->
                                <div class="mb-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                    <div class="text-sm font-semibold text-yellow-800 dark:text-yellow-400 mb-2">
                                        Hijab Point to Point
                                    </div>
                                    <div class="text-xs text-yellow-600 dark:text-yellow-500 mb-3">
                                        Standard: ≥ 1.00E+4 Ohm - < 1.00E+11 Ohm
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium mb-1">D4 Measurement (Ohm)</label>
                                            <input type="number" step="0.01" wire:model="d4" wire:keyup="resetJudgements"
                                                   class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700"
                                                   placeholder="Enter value in Ohm">
                                            @error('d4') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">D4 Scientific</label>
                                            <input type="text" wire:model="d4_scientific" readonly 
                                                   class="w-full px-3 py-2 border rounded-lg bg-gray-100 dark:bg-zinc-800 dark:border-zinc-700 font-mono"
                                                   placeholder="-">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">Judgement D4</label>
                                            <div class="mt-1">
                                                @if($judgement_d4)
                                                    <span class="inline-flex px-3 py-2 rounded-full text-sm font-medium {{ $judgement_d4 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                        {{ $judgement_d4 }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-3 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">-</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Remarks -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Remarks</label>
                                    <textarea wire:model="remarks" rows="3" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700" placeholder="Optional remarks..."></textarea>
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
                            Are you sure you want to delete measurement for "{{ $detailToDelete?->garment?->nik ?? 'this employee' }}"? This action cannot be undone.
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
                [x-collapse] { overflow: hidden; }
            </style>
        </div>
    </x-esd.layout>
</section>