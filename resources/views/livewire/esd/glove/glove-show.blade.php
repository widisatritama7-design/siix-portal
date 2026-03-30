{{-- resources/views/livewire/esd/glove/glove-show.blade.php --}}
<section class="w-full">
    @include('partials.esd-heading')

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge - Glove Detail') }}
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
                    <flux:breadcrumbs.item href="{{ route('esd.gloves') }}" wire:navigate separator="slash">
                        Glove
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
                            View Glove
                        </h1>
                        <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            View detailed information about glove
                        </p>
                    </div>
                    <div class="w-full sm:w-auto flex-shrink-0">
                        <flux:button 
                            href="{{ route('esd.gloves') }}"
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
            <!-- Glove Information Card -->
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden mb-6">
                <!-- Header with Solid Color -->
                <div class="bg-blue-600 dark:bg-blue-500 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="font-semibold text-base text-white">Glove Information</h3>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                        <!-- SAP Code -->
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">SAP Code</label>
                            <p class="mt-1 text-base font-semibold text-zinc-800 dark:text-white">
                                {{ $glove->sap_code }}
                            </p>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Description</label>
                            <p class="mt-1 text-base text-zinc-800 dark:text-white">
                                {{ $glove->description }}
                            </p>
                        </div>

                        <!-- Delivery -->
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Delivery</label>
                            <p class="mt-1 text-base text-zinc-800 dark:text-white">
                                {{ $glove->delivery ?? '-' }}
                            </p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Status</label>
                            <div class="mt-1 flex justify-center">
                                @php
                                    $statusConfig = [
                                        'In Use' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                        'Not In Use' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
                                        'Under Repair' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        'Damage' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                        'Disposed' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                    ];
                                    $statusColor = $statusConfig[$glove->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                                    {{ $glove->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </flux:card>

            <!-- Standard ESD Glove Card -->
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden mb-6">
                <!-- Header with Solid Color -->
                <div class="bg-blue-600 dark:bg-blue-500 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <h3 class="font-semibold text-base text-white">Standard ESD Of Glove</h3>
                    </div>
                </div>
                
                <div class="p-6" x-data="{ open: false }">
                    <!-- Toggle Button inside content -->
                    <button 
                        @click="open = !open"
                        class="w-full flex items-center justify-between p-3 bg-gray-50 dark:bg-zinc-800/50 rounded-lg hover:bg-gray-100 dark:hover:bg-zinc-800 transition-colors mb-4"
                    >
                        <div class="flex items-center gap-2">
                            <flux:icon name="beaker" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">View Standard Details</span>
                        </div>
                        <flux:icon x-show="!open" name="chevron-down" class="w-5 h-5 text-zinc-500" />
                        <flux:icon x-show="open" name="chevron-up" class="w-5 h-5 text-zinc-500" />
                    </button>
                    
                    <div x-show="open" x-collapse x-cloak>
                        <div class="pt-2">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                                <!-- Standard Value -->
                                <div class="text-center">
                                    <div class="flex items-center justify-center gap-2 mb-2">
                                        <flux:icon name="beaker" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                        <label class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">
                                            Standard Value C1
                                        </label>
                                    </div>
                                    <div class="bg-blue-50 dark:bg-blue-950/30 rounded-lg p-3">
                                        <p class="text-2xl font-bold text-blue-700 dark:text-blue-400">
                                            &lt; 3.5E+7 Ohm
                                        </p>
                                        <p class="text-xs text-zinc-600 dark:text-zinc-400">
                                            Glove Point to Ground Resistance Test
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Frequency -->
                                <div class="text-center">
                                    <div class="flex items-center justify-center gap-2 mb-2">
                                        <flux:icon name="calendar" class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                                        <label class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">
                                            Frequency
                                        </label>
                                    </div>
                                    <div class="bg-purple-50 dark:bg-purple-950/30 rounded-lg p-3">
                                        <p class="text-2xl font-bold text-purple-700 dark:text-purple-400">
                                            New Received, Sampling Per-Item 1 Pair
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                                <div class="flex items-center justify-center">
                                    <div class="bg-zinc-100 dark:bg-zinc-800 rounded-lg px-6 py-3">
                                        <code class="text-lg font-mono font-bold text-zinc-800 dark:text-white">
                                            QR-ADM-22-K028
                                        </code>
                                    </div>
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
                            @can('create glove details')
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
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">C1 Result</th>
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
                                        {{ $detail->c1_scientific }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $judgementColor = $detail->judgement == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $judgementColor }}">
                                            {{ $detail->judgement }}
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
                                            @can('edit glove details')
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

                                            @can('delete glove details')
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
                                    <td colspan="7" class="px-4 py-12 text-center">
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
                                                @can('create glove details')
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
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                            <form wire:submit="save">
                                <!-- Hidden Input for glove_id -->
                                <input type="hidden" wire:model="glove_id" value="{{ $glove->id }}">

                                <!-- C1 Measurement -->
                                <div class="mb-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                    <div class="text-sm font-semibold text-yellow-800 dark:text-yellow-400 mb-2">
                                        Standard: &lt; 3.5E+7 Ohm
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium mb-1">C1 Measurement <span class="text-red-500">*</span></label>
                                            <input type="number" step="0.01" wire:model="c1" wire:keyup="resetJudgement"
                                                class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                                            @error('c1') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">C1 Scientific</label>
                                            <div class="mt-2">
                                                <input type="text" wire:model="c1_scientific" readonly 
                                                    class="w-full px-3 py-2 border rounded-lg bg-gray-100 dark:bg-zinc-800 dark:border-zinc-700 font-mono">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Judgement -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Judgement</label>
                                    <div class="mt-1">
                                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $judgement == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $judgement ?: 'Auto' }}
                                        </span>
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
                            Are you sure you want to delete measurement for "{{ $detailToDelete?->glove?->sap_code ?? 'this glove' }}"? This action cannot be undone.
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