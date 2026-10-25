<section class="w-full">
    

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge - Jig Detail') }}
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
                    <flux:breadcrumbs.item href="{{ route('esd.jigs') }}" wire:navigate separator="slash">
                        Jig
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
                            View Jig
                        </h1>
                        <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            View detailed information about jig
                        </p>
                    </div>
                    <div class="w-full sm:w-auto flex-shrink-0">
                        <flux:button 
                            href="{{ route('esd.jigs') }}"
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
            <!-- Jig Information Card -->
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden mb-6">
                <!-- Header with Solid Color -->
                <div class="bg-purple-600 dark:bg-purple-500 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="font-semibold text-base text-white">Jig Information</h3>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                        <!-- Register No -->
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Register No</label>
                            <p class="mt-1 text-base font-semibold text-zinc-800 dark:text-white">
                                {{ $jig->register_no }}
                            </p>
                        </div>

                        <!-- Location -->
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Location</label>
                            <p class="mt-1 text-base text-zinc-800 dark:text-white">
                                {{ $jig->location }}
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
                                    $statusColor = $statusConfig[$jig->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                                    {{ $jig->status }}
                                </span>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Description</label>
                            <p class="mt-1 text-base text-zinc-800 dark:text-white">
                                {{ $jig->description ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </flux:card>

            <!-- Standard ESD Jig Card -->
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden mb-6">
                <!-- Header with Solid Color -->
                <div class="bg-purple-600 dark:bg-purple-500 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <flux:icon name="bolt" class="w-5 h-5 text-white" />
                        <h3 class="font-semibold text-base text-white">Standard ESD Of Jig</h3>
                    </div>
                </div>

                <div class="p-6" x-data="{ open: false }">
                    <!-- Toggle Button -->
                    <button
                        @click="open = !open"
                        class="w-full flex items-center justify-between p-3 bg-gray-50 dark:bg-zinc-800/50 rounded-lg hover:bg-gray-100 dark:hover:bg-zinc-800 transition-colors mb-4"
                    >
                        <div class="flex items-center gap-2">
                            <flux:icon name="beaker" class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">View Standard Details</span>
                        </div>
                        <flux:icon x-show="!open" name="chevron-down" class="w-5 h-5 text-zinc-500" />
                        <flux:icon x-show="open" name="chevron-up" class="w-5 h-5 text-zinc-500" />
                    </button>

                    <!-- Collapsible Content -->
                    <div x-show="open" x-collapse x-cloak>
                        <div class="border-t border-zinc-200 dark:border-zinc-700 pt-4">

                            {{-- SECTION 1: STANDARD VALUES (GRID 3 KOLOM SEJAJAR) --}}
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6 items-stretch">
                                <!-- J1 Standard -->
                                <div class="flex flex-col">
                                    <div class="flex items-center justify-center gap-2 mb-2">
                                        <flux:icon name="beaker" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                        <label class="text-[11px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">
                                            (J1) Resistance
                                        </label>
                                    </div>
                                    <div class="bg-blue-50 dark:bg-blue-950/30 rounded-lg p-3 flex-1 flex flex-col items-center justify-center">
                                        <p class="text-xl font-bold text-blue-700 dark:text-blue-400 whitespace-nowrap">
                                            &lt; 1.0 Ω
                                        </p>
                                        <p class="text-[10px] text-zinc-500 mt-1">(fixed aluminum jig)</p>
                                    </div>
                                </div>

                                <!-- J2 Standard -->
                                <div class="flex flex-col">
                                    <div class="flex items-center justify-center gap-2 mb-2">
                                        <flux:icon name="bolt" class="w-4 h-4 text-green-600 dark:text-green-400" />
                                        <label class="text-[11px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">
                                            (J2) Static Voltage
                                        </label>
                                    </div>
                                    <div class="bg-green-50 dark:bg-green-950/30 rounded-lg p-3 flex-1 flex flex-col items-center justify-center">
                                        <p class="text-xl font-bold text-green-700 dark:text-green-400 whitespace-nowrap">
                                            &lt; 100 V
                                        </p>
                                        <p class="text-[10px] text-zinc-500 mt-1">Surface static field</p>
                                    </div>
                                </div>

                                <!-- J3 Visual -->
                                <div class="flex flex-col">
                                    <div class="flex items-center justify-center gap-2 mb-2">
                                        <flux:icon name="clipboard-document-check" class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                                        <label class="text-[11px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">
                                            Visual Check
                                        </label>
                                    </div>
                                    <div class="bg-amber-50 dark:bg-amber-950/30 rounded-lg p-3 flex-1 flex flex-col items-center justify-center">
                                        <p class="text-xl font-bold text-amber-700 dark:text-amber-400">All YES</p>
                                        <p class="text-[10px] text-zinc-500 mt-1">(J-3.1)</p>
                                    </div>
                                </div>
                            </div>

                            {{-- SECTION 2: DETAIL CHECKLIST J-3 --}}
                            <div class="bg-amber-50 dark:bg-amber-950/30 rounded-lg p-4 border border-amber-200 dark:border-amber-900/50 mb-6">
                                <h4 class="text-xs font-bold uppercase tracking-wide text-amber-800 dark:text-amber-300 mb-3 flex items-center gap-2">
                                    <flux:icon name="clipboard-document-check" class="w-4 h-4" />
                                    (J-3) Visual Inspection Checklist
                                </h4>
                                <div class="space-y-2">
                                    <div class="flex items-start gap-3 bg-white dark:bg-zinc-900/40 rounded-md p-2.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide bg-amber-600 text-white flex-shrink-0 mt-0.5">
                                            J-3.1
                                        </span>
                                        <p class="text-sm text-zinc-700 dark:text-zinc-300 leading-snug">
                                            Permukaan jig tidak rusak
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-3 pt-3 border-t border-amber-200 dark:border-amber-900/50 text-center">
                                    <p class="text-xs font-medium text-amber-800 dark:text-amber-300">
                                        Expected Result: <span class="font-bold uppercase">All YES</span>
                                    </p>
                                </div>
                            </div>

                            {{-- SECTION 3: FREQUENCY & DOCUMENT REFERENCE (2 KOLOM) --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-stretch">
                                <!-- Frequency -->
                                <div class="flex flex-col">
                                    <div class="flex items-center justify-center gap-2 mb-2">
                                        <flux:icon name="calendar" class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                                        <label class="text-[11px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">
                                            Frequency
                                        </label>
                                    </div>
                                    <div class="bg-purple-50 dark:bg-purple-950/30 rounded-lg p-4 flex-1 flex items-center justify-center">
                                        <p class="text-lg font-bold text-purple-700 dark:text-purple-400">
                                            Monthly
                                        </p>
                                    </div>
                                </div>

                                <!-- Document Reference -->
                                <div class="flex flex-col">
                                    <div class="flex items-center justify-center gap-2 mb-2">
                                        <flux:icon name="document-text" class="w-4 h-4 text-zinc-500" />
                                        <label class="text-[11px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">
                                            Document Reference
                                        </label>
                                    </div>
                                    <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-4 flex-1 flex items-center justify-center">
                                        <code class="text-sm font-mono font-bold text-zinc-800 dark:text-white bg-white dark:bg-zinc-900 px-3 py-1.5 rounded border border-zinc-200 dark:border-zinc-700">
                                            QR-ADM-24-K041
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
                            @can('create jig details')
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
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">J1 Result</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-20">J1 Judgement</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">J2 Result</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-20">J2 Judgement</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">J-3.1</th>  
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
                                        {{ $detail->j1 ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $j1Color = $detail->judgement_j1 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $j1Color }}">
                                            {{ $detail->judgement_j1 ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 font-mono">
                                        {{ number_format($detail->j2, 2) ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $j2Color = $detail->judgement_j2 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $j2Color }}">
                                            {{ $detail->judgement_j2 ?? '-' }}
                                        </span>
                                    </td>
                                    {{-- J-3.1 --}}
                                    <td class="px-4 py-3 text-center">
                                        @if($detail->j_3_1 !== null)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $detail->j_3_1 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                {{ $detail->j_3_1 ? 'Yes' : 'No' }}
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
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                            @can('edit jig details')
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

                                            @can('delete jig details')
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
                                    <td colspan="9" class="px-4 py-12 text-center">
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
                                                @can('create jig details')
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
                @keydown.escape.window="open = false"
                x-cloak>

                {{-- Backdrop --}}
                <div class="fixed inset-0 bg-zinc-900/60 backdrop-blur-sm z-40"
                    x-transition.opacity
                    @click="open = false"></div>

                {{-- Modal Panel --}}
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[92vh] flex flex-col overflow-hidden border border-zinc-200 dark:border-zinc-800"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100">

                        {{-- =================== HEADER =================== --}}
                        <div class="sticky top-0 z-10 bg-gradient-to-r from-purple-600 via-purple-600 to-fuchsia-600 px-6 py-4 flex items-center justify-between shadow-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center ring-2 ring-white/30">
                                    <flux:icon name="{{ $detail_id ? 'pencil-square' : 'plus-circle' }}" class="w-5 h-5 text-white" />
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-white leading-tight">
                                        {{ $detail_id ? 'Edit Measurement' : 'New Measurement' }}
                                    </h2>
                                    <p class="text-xs text-purple-100 mt-0.5">
                                        {{ $jig->register_no }} — {{ $jig->location }}
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
                            <form wire:submit="save" id="jig-detail-form" class="p-6 space-y-6">
                                <input type="hidden" wire:model="jigs_id">

                                {{-- SECTION 1: MEASUREMENTS (J1 & J2) --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                                            <flux:icon name="beaker" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                                Measurement Results
                                            </h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                J1 (Resistance) & J2 (Voltage) readings
                                            </p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        {{-- J1 Measurement --}}
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-blue-200 dark:border-blue-800/60 p-4">
                                            <div class="flex items-start justify-between gap-2 mb-3">
                                                <div>
                                                    <div class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">J1 — Resistance</div>
                                                    <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Standard: &lt; 1.0 Ω</div>
                                                </div>
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide
                                                    {{ $judgement_j1 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300 ring-1 ring-green-300 dark:ring-green-700' : ($judgement_j1 == 'NG' ? 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 ring-1 ring-red-300 dark:ring-red-700' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 ring-1 ring-zinc-300 dark:ring-zinc-700') }}">
                                                    @if($judgement_j1 == 'OK')
                                                        <flux:icon name="check-circle" class="w-3 h-3" />
                                                    @elseif($judgement_j1 == 'NG')
                                                        <flux:icon name="x-circle" class="w-3 h-3" />
                                                    @else
                                                        <flux:icon name="clock" class="w-3 h-3" />
                                                    @endif
                                                    {{ $judgement_j1 ?: 'AUTO' }}
                                                </span>
                                            </div>
                                            <label class="block text-[11px] font-semibold mb-1 text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Measurement (Ω)</label>
                                            <input type="number" step="0.01" wire:model="j1" wire:keyup="resetJudgementJ1"
                                                placeholder="Enter J1 value"
                                                class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 font-mono">
                                            @error('j1') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- J2 Measurement --}}
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-green-200 dark:border-green-800/60 p-4">
                                            <div class="flex items-start justify-between gap-2 mb-3">
                                                <div>
                                                    <div class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">J2 — Static Voltage</div>
                                                    <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Standard: &lt; 100 V</div>
                                                </div>
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide
                                                    {{ $judgement_j2 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300 ring-1 ring-green-300 dark:ring-green-700' : ($judgement_j2 == 'NG' ? 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 ring-1 ring-red-300 dark:ring-red-700' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 ring-1 ring-zinc-300 dark:ring-zinc-700') }}">
                                                    @if($judgement_j2 == 'OK')
                                                        <flux:icon name="check-circle" class="w-3 h-3" />
                                                    @elseif($judgement_j2 == 'NG')
                                                        <flux:icon name="x-circle" class="w-3 h-3" />
                                                    @else
                                                        <flux:icon name="clock" class="w-3 h-3" />
                                                    @endif
                                                    {{ $judgement_j2 ?: 'AUTO' }}
                                                </span>
                                            </div>
                                            <label class="block text-[11px] font-semibold mb-1 text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Measurement (V)</label>
                                            <input type="number" step="0.01" wire:model="j2" wire:keyup="resetJudgementJ2"
                                                placeholder="Enter J2 value"
                                                class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 font-mono">
                                            @error('j2') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- SECTION 2: VISUAL INSPECTION (J-3) --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center">
                                            <flux:icon name="clipboard-document-check" class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                                (J-3) Visual Inspection Checklist
                                            </h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                Tick <span class="font-semibold text-green-600">YES</span> if condition is met, <span class="font-semibold text-red-600">NO</span> if not
                                            </p>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        @php
                                            $j3Items = [
                                                ['field' => 'j_3_1', 'code' => 'J-3.1', 'text' => 'Permukaan jig tidak rusak'],
                                            ];
                                        @endphp

                                        @foreach($j3Items as $item)
                                            @php
                                                $field = $item['field'];
                                                $value = $this->$field;
                                                $isYes = ($value === 1 || $value === true || $value === '1');
                                                $isNo  = ($value === 0 || $value === false || $value === '0');
                                            @endphp
                                            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-3
                                                        flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3
                                                        {{ $isYes ? 'ring-1 ring-green-200 dark:ring-green-900' : ($isNo ? 'ring-1 ring-red-200 dark:ring-red-900' : '') }}">
                                                <div class="flex items-start gap-3 flex-1 min-w-0">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide bg-amber-600 text-white flex-shrink-0 mt-0.5">
                                                        {{ $item['code'] }}
                                                    </span>
                                                    <p class="text-sm text-zinc-700 dark:text-zinc-300 leading-snug">{{ $item['text'] }}</p>
                                                </div>

                                                <div class="flex items-center gap-2 flex-shrink-0 self-end sm:self-auto">
                                                    <button type="button"
                                                            wire:click="$set('{{ $field }}', {{ $isYes ? 'null' : '1' }})"
                                                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide transition-all duration-150
                                                                {{ $isYes
                                                                    ? 'bg-green-600 text-white shadow-md shadow-green-600/30 ring-2 ring-green-300 dark:ring-green-700 scale-105'
                                                                    : 'bg-white dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 border border-zinc-300 dark:border-zinc-600 hover:bg-green-50 dark:hover:bg-green-900/20 hover:border-green-400 hover:text-green-700 dark:hover:text-green-400' }}">
                                                        <flux:icon name="check-circle" class="w-4 h-4" />
                                                        <span>YES</span>
                                                    </button>

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
                                                    class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                                            @error('remarks') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Next Measurement Date</label>
                                            <input type="date" wire:model="next_date"
                                                class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500">
                                            @error('next_date') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
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
                                <button type="submit" form="jig-detail-form"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-purple-600 to-fuchsia-600 hover:from-purple-700 hover:to-fuchsia-700 text-white rounded-xl transition-all text-sm font-semibold shadow-lg shadow-purple-600/30 hover:shadow-purple-600/50">
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
                            Are you sure you want to delete measurement for "{{ $detailToDelete?->jig?->register_no ?? 'this jig' }}"? This action cannot be undone.
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