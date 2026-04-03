<section class="w-full">
    @include('partials.esd-heading')

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge - Ionizer Detail') }}
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
                    <flux:breadcrumbs.item href="{{ route('esd.ionizers') }}" wire:navigate separator="slash">
                        Ionizer
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
                            View Ionizer
                        </h1>
                        <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            View detailed information about ionizer
                        </p>
                    </div>
                    <div class="w-full sm:w-auto flex-shrink-0">
                        <flux:button 
                            href="{{ route('esd.ionizers') }}"
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
            <!-- Ionizer Information Card -->
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden mb-6">
                <div class="bg-orange-600 dark:bg-orange-500 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="font-semibold text-base text-white">Ionizer Information</h3>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 text-center">
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Register No</label>
                            <p class="mt-1 text-base font-semibold text-zinc-800 dark:text-white">
                                {{ $ionizer->register_no }}
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Area</label>
                            <p class="mt-1 text-base text-zinc-800 dark:text-white">
                                {{ $ionizer->area }}
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Location</label>
                            <p class="mt-1 text-base text-zinc-800 dark:text-white">
                                {{ $ionizer->location }}
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Gap</label>
                            <p class="mt-1 text-base text-zinc-800 dark:text-white">
                                {{ $ionizer->gap ?? '-' }}
                            </p>
                        </div>
                        <div class="sm:col-span-2 lg:col-span-1">
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
                                    $statusColor = $statusConfig[$ionizer->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                                    {{ $ionizer->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </flux:card>

            <!-- Standard ESD Ionizer Card -->
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden mb-6">
                <div class="bg-orange-600 dark:bg-orange-500 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <h3 class="font-semibold text-base text-white">Standard ESD Of Ionizer</h3>
                    </div>
                </div>
                
                <div class="p-6" x-data="{ open: false }">
                    <button 
                        @click="open = !open"
                        class="w-full flex items-center justify-between p-3 bg-gray-50 dark:bg-zinc-800/50 rounded-lg hover:bg-gray-100 dark:hover:bg-zinc-800 transition-colors mb-4"
                    >
                        <div class="flex items-center gap-2">
                            <flux:icon name="beaker" class="w-5 h-5 text-orange-600 dark:text-orange-400" />
                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">View Standard Details</span>
                        </div>
                        <flux:icon x-show="!open" name="chevron-down" class="w-5 h-5 text-zinc-500" />
                        <flux:icon x-show="open" name="chevron-up" class="w-5 h-5 text-zinc-500" />
                    </button>
                    
                    <div x-show="open" x-collapse x-cloak>
                        <div class="pt-2 space-y-6">
                            <!-- PM Section -->
                            <div>
                                <h4 class="text-lg font-semibold text-purple-700 dark:text-purple-400 mb-3 flex items-center gap-2">
                                    <flux:icon name="wrench" class="w-5 h-5" />
                                    Preventive Maintenance (PM)
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="bg-purple-50 dark:bg-purple-950/30 rounded-lg p-4 border border-purple-200 dark:border-purple-800">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-purple-600 text-white text-xs font-bold">1</span>
                                            <label class="text-sm font-semibold text-purple-800 dark:text-purple-400">PM 1</label>
                                        </div>
                                        <p class="text-xs text-zinc-600 dark:text-zinc-400">
                                            Check H.V light flashing condition. If the indicator is flashing, record as NG and perform inspection immediately.
                                        </p>
                                        <div class="mt-2">
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">FLASH = NG</span>
                                            <span class="inline-flex ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">NO = OK</span>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-purple-50 dark:bg-purple-950/30 rounded-lg p-4 border border-purple-200 dark:border-purple-800">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-purple-600 text-white text-xs font-bold">2</span>
                                            <label class="text-sm font-semibold text-purple-800 dark:text-purple-400">PM 2</label>
                                        </div>
                                        <p class="text-xs text-zinc-600 dark:text-zinc-400">
                                            Check and clean the discharge electrode needle.
                                        </p>
                                        <div class="mt-2">
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">OK</span>
                                            <span class="inline-flex ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">NG</span>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-purple-50 dark:bg-purple-950/30 rounded-lg p-4 border border-purple-200 dark:border-purple-800">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-purple-600 text-white text-xs font-bold">3</span>
                                            <label class="text-sm font-semibold text-purple-800 dark:text-purple-400">PM 3</label>
                                        </div>
                                        <p class="text-xs text-zinc-600 dark:text-zinc-400">
                                            Clean up filter and fan. Perform verification after PM (Preventive Maintenance).
                                        </p>
                                        <div class="mt-2">
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">YES</span>
                                            <span class="inline-flex ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">NO</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- C1 & C2 & C3 Section -->
                            <div class="pt-4">
                                <h4 class="text-lg font-semibold text-blue-700 dark:text-blue-400 mb-3 flex items-center gap-2">
                                    <flux:icon name="beaker" class="w-5 h-5" />
                                    Measurements Standards
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="bg-blue-50 dark:bg-blue-950/30 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-600 text-white text-xs font-bold">C1</span>
                                            <label class="text-sm font-semibold text-blue-800 dark:text-blue-400">Charge Decay Time (+)</label>
                                        </div>
                                        <p class="text-xs text-zinc-600 dark:text-zinc-400">
                                            Measure Charge Decay Time (+), from 1,000V to 100V
                                        </p>
                                        <div class="mt-2 text-center">
                                            <p class="text-xl font-bold text-blue-700 dark:text-blue-400">&lt; 8.0 seconds</p>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-blue-50 dark:bg-blue-950/30 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-600 text-white text-xs font-bold">C2</span>
                                            <label class="text-sm font-semibold text-blue-800 dark:text-blue-400">Charge Decay Time (-)</label>
                                        </div>
                                        <p class="text-xs text-zinc-600 dark:text-zinc-400">
                                            Measure Charge Decay Time (-), from 1,000V to 100V
                                        </p>
                                        <div class="mt-2 text-center">
                                            <p class="text-xl font-bold text-blue-700 dark:text-blue-400">&lt; 8.0 seconds</p>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-green-50 dark:bg-green-950/30 rounded-lg p-4 border border-green-200 dark:border-green-800">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-600 text-white text-xs font-bold">C3</span>
                                            <label class="text-sm font-semibold text-green-800 dark:text-green-400">Offset Voltage</label>
                                        </div>
                                        <p class="text-xs text-zinc-600 dark:text-zinc-400">
                                            Measure Offset Voltage, voltage swing within ±35V in 30 seconds.
                                        </p>
                                        <div class="mt-2 text-center">
                                            <p class="text-xl font-bold text-green-700 dark:text-green-400">&lt; ± 35 Volts</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                                <div class="text-center">
                                    <div class="flex items-center justify-center gap-2 mb-1">
                                        <flux:icon name="calendar" class="w-3 h-3 text-purple-600 dark:text-purple-400" />
                                        <label class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Frequency</label>
                                    </div>
                                    <div class="bg-purple-50 dark:bg-purple-950/30 rounded-lg py-1.5 px-3 h-full flex items-center justify-center">
                                        <p class="text-lg font-bold text-purple-700 dark:text-purple-400">Monthly</p>
                                    </div>
                                </div>
                                
                                <div class="text-center">
                                    <div class="flex items-center justify-center gap-2 mb-1">
                                        <flux:icon name="document-text" class="w-3 h-3 text-zinc-500" />
                                        <label class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Document Reference</label>
                                    </div>
                                    <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-lg py-1.5 px-3 h-full flex items-center justify-center">
                                        <code class="text-sm font-mono font-bold text-zinc-800 dark:text-white bg-white dark:bg-zinc-900 px-3 py-1 rounded">QR-ADM-22-K017</code>
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
                        <h2 class="text-xl font-bold text-zinc-800 dark:text-white order-1 sm:order-1">Measurement History</h2>
                        <div class="order-2 sm:order-2">
                            @can('create ionizer details')
                            <flux:button 
                                variant="primary" 
                                icon="plus" 
                                class="bg-blue-600 hover:bg-blue-700 w-full sm:w-auto justify-center"
                                wire:click="resetForm"
                                @click="$dispatch('open-detail-modal')"
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
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date From</label>
                            <input type="date" wire:model.live="filterDateFrom" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date Until</label>
                            <input type="date" wire:model.live="filterDateUntil" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Next Date From</label>
                            <input type="date" wire:model.live="filterNextDateFrom" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Next Date Until</label>
                            <input type="date" wire:model.live="filterNextDateUntil" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>
                    </div>
                    @if($filterDateFrom || $filterDateUntil || $filterNextDateFrom || $filterNextDateUntil || $search)
                    <div class="mt-3 text-right">
                        <button wire:click="resetFilters" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">Clear All Filters</button>
                    </div>
                    @endif
                </div>

                <!-- Measurements Table -->
                <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 w-full">
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-16">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">PM 1</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">PM 2</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">PM 3</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">C1 Before</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[80px]">Judge</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">C2 Before</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[80px]">Judge</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">C3 Before</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[80px]">Judge</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">C1</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[80px]">Judge</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">C2</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[80px]">Judge</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">C3</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[80px]">Judge</th>
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
                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">{{ $details->firstItem() + $index }}</td>
                                    <td class="px-4 py-3">
                                        @php $pm1Color = $detail->pm_1 == 'NO' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'; @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $pm1Color }}">{{ $detail->pm_1 }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @php $pm2Color = $detail->pm_2 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'; @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $pm2Color }}">{{ $detail->pm_2 }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @php $pm3Color = $detail->pm_3 == 'YES' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'; @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $pm3Color }}">{{ $detail->pm_3 }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 font-mono">{{ $detail->c1_before }}</td>
                                    <td class="px-4 py-3">
                                        @php $judgeColor = $detail->judgement_c1_before == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'; @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $judgeColor }}">{{ $detail->judgement_c1_before }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 font-mono">{{ $detail->c2_before }}</td>
                                    <td class="px-4 py-3">
                                        @php $judgeColor = $detail->judgement_c2_before == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'; @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $judgeColor }}">{{ $detail->judgement_c2_before }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 font-mono">{{ $detail->c3_before }}</td>
                                    <td class="px-4 py-3">
                                        @php $judgeColor = $detail->judgement_c3_before == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'; @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $judgeColor }}">{{ $detail->judgement_c3_before }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 font-mono">{{ $detail->c1 }}</td>
                                    <td class="px-4 py-3">
                                        @php $judgeColor = $detail->judgement_c1 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'; @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $judgeColor }}">{{ $detail->judgement_c1 }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 font-mono">{{ $detail->c2 }}</td>
                                    <td class="px-4 py-3">
                                        @php $judgeColor = $detail->judgement_c2 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'; @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $judgeColor }}">{{ $detail->judgement_c2 }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 font-mono">{{ $detail->c3 }}</td>
                                    <td class="px-4 py-3">
                                        @php $judgeColor = $detail->judgement_c3 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'; @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $judgeColor }}">{{ $detail->judgement_c3 }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 truncate max-w-[150px]" title="{{ $detail->remarks }}">{{ $detail->remarks ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">{{ $detail->created_at ? $detail->created_at->format('d M Y') : '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">{{ $detail->next_date ? \Carbon\Carbon::parse($detail->next_date)->format('d M Y') : '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">{{ $detail->creator->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                            @can('edit ionizer details')
                                            <flux:button 
                                                wire:click="edit({{ $detail->id }})" 
                                                @click="$dispatch('open-detail-modal')"
                                                size="sm"
                                                icon="pencil-square"
                                                variant="primary"
                                                color="yellow"
                                                class="!p-2 flex-shrink-0"
                                                title="Edit measurement"
                                            />
                                            @endcan
                                            @can('delete ionizer details')
                                            <flux:button 
                                                wire:click="confirmDelete({{ $detail->id }})" 
                                                @click="$dispatch('open-delete-modal')"
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
                                    <td colspan="21" class="px-4 py-12 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                                <flux:icon name="square-3-stack-3d" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">No measurement records found</h3>
                                                <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">{{ $search || $filterDateFrom || $filterDateUntil || $filterNextDateFrom || $filterNextDateUntil ? 'Try adjusting your filters' : 'Get started by adding a new measurement' }}</p>
                                            </div>
                                            @if($search || $filterDateFrom || $filterDateUntil || $filterNextDateFrom || $filterNextDateUntil)
                                                <flux:button wire:click="resetFilters" size="sm">Clear Filters</flux:button>
                                            @else
                                                @can('create ionizer details')
                                                <flux:button variant="primary" size="sm" wire:click="resetForm" @click="$dispatch('open-detail-modal')">Add Your First Measurement</flux:button>
                                                @endcan
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($details->hasPages())
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">{{ $details->links() }}</div>
                    @endif
                </flux:card>
            </div>

            <!-- MODAL FORM MEASUREMENT DETAIL -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-detail-modal.window="open = true"
                 @close-modal.window="if ($event.detail === 'detail-form-modal') open = false"
                 @keydown.escape.window="open = false"
                 x-cloak>
                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>
                            <form wire:submit.prevent="save">
                                <input type="hidden" wire:model="ionizer_id" value="{{ $ionizer->id }}">
                                <!-- PM Section -->
                                <div class="mb-6 p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-800">
                                    <h3 class="text-md font-semibold text-purple-800 dark:text-purple-400 mb-3">Preventive Maintenance (PM)</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium mb-1">PM 1 <span class="text-red-500">*</span></label>
                                            <div class="flex gap-4 mt-2">
                                                <label class="inline-flex items-center"><input type="radio" wire:model="pm_1" value="FLASH" class="form-radio text-red-600"><span class="ml-2">FLASH</span></label>
                                                <label class="inline-flex items-center"><input type="radio" wire:model="pm_1" value="NO" class="form-radio text-green-600"><span class="ml-2">NO</span></label>
                                            </div>
                                            @error('pm_1') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">PM 2 <span class="text-red-500">*</span></label>
                                            <div class="flex gap-4 mt-2">
                                                <label class="inline-flex items-center"><input type="radio" wire:model="pm_2" value="OK" class="form-radio text-green-600"><span class="ml-2">OK</span></label>
                                                <label class="inline-flex items-center"><input type="radio" wire:model="pm_2" value="NO" class="form-radio text-red-600"><span class="ml-2">NO</span></label>
                                            </div>
                                            @error('pm_2') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">PM 3 <span class="text-red-500">*</span></label>
                                            <div class="flex gap-4 mt-2">
                                                <label class="inline-flex items-center"><input type="radio" wire:model="pm_3" value="YES" class="form-radio text-green-600"><span class="ml-2">YES</span></label>
                                                <label class="inline-flex items-center"><input type="radio" wire:model="pm_3" value="NO" class="form-radio text-red-600"><span class="ml-2">NO</span></label>
                                            </div>
                                            @error('pm_3') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- Before Maintenance -->
                                <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                    <h3 class="text-md font-semibold text-blue-800 dark:text-blue-400 mb-3">Before Maintenance Measurements</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium mb-1">C1 Before <span class="text-red-500">*</span></label>
                                            <div class="text-xs text-blue-600 mb-1">Standard: &lt; 8.0 (Max 7.9 = OK)</div>
                                            <input type="number" step="0.01" wire:model="c1_before" wire:blur="resetJudgements" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                            @error('c1_before') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            <div class="mt-1"><span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $judgement_c1_before == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">Judgement: {{ $judgement_c1_before ?: 'Auto' }}</span></div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">C2 Before <span class="text-red-500">*</span></label>
                                            <div class="text-xs text-blue-600 mb-1">Standard: &lt; 8.0 (Max 7.9 = OK)</div>
                                            <input type="number" step="0.01" wire:model="c2_before" wire:blur="resetJudgements" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                            @error('c2_before') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            <div class="mt-1"><span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $judgement_c2_before == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">Judgement: {{ $judgement_c2_before ?: 'Auto' }}</span></div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">C3 Before <span class="text-red-500">*</span></label>
                                            <div class="text-xs text-green-600 mb-1">Standard: ± 35 (-34.9 to 34.9 = OK)</div>
                                            <input type="number" step="0.01" wire:model="c3_before" wire:blur="resetJudgements" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                            @error('c3_before') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            <div class="mt-1"><span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $judgement_c3_before == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">Judgement: {{ $judgement_c3_before ?: 'Auto' }}</span></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- After Maintenance -->
                                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                    <h3 class="text-md font-semibold text-green-800 dark:text-green-400 mb-3">After Maintenance Measurements</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium mb-1">C1 <span class="text-red-500">*</span></label>
                                            <div class="text-xs text-blue-600 mb-1">Standard: &lt; 8.0 (Max 7.9 = OK)</div>
                                            <input type="number" step="0.01" wire:model="c1" wire:blur="resetJudgements" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                            @error('c1') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            <div class="mt-1"><span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $judgement_c1 == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">Judgement: {{ $judgement_c1 ?: 'Auto' }}</span></div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">C2 <span class="text-red-500">*</span></label>
                                            <div class="text-xs text-blue-600 mb-1">Standard: &lt; 8.0 (Max 7.9 = OK)</div>
                                            <input type="number" step="0.01" wire:model="c2" wire:blur="resetJudgements" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                            @error('c2') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            <div class="mt-1"><span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $judgement_c2 == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">Judgement: {{ $judgement_c2 ?: 'Auto' }}</span></div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-1">C3 <span class="text-red-500">*</span></label>
                                            <div class="text-xs text-green-600 mb-1">Standard: ± 35 (-34.9 to 34.9 = OK)</div>
                                            <input type="number" step="0.01" wire:model="c3" wire:blur="resetJudgements" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                            @error('c3') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            <div class="mt-1"><span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $judgement_c3 == 'OK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">Judgement: {{ $judgement_c3 ?: 'Auto' }}</span></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Remarks & Next Date -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Remarks</label>
                                    <textarea wire:model="remarks" rows="3" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700"></textarea>
                                    @error('remarks') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Next Date</label>
                                    <input type="date" wire:model="next_date" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                    @error('next_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex justify-end gap-2 mt-6">
                                    <button type="button" @click="open = false" class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">Cancel</button>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">{{ $detail_id ? 'Update' : 'Create' }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL DELETE -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-delete-modal.window="open = true"
                 @close-modal.window="open = false"
                 @keydown.escape.window="open = false"
                 x-cloak>
                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold mb-2">Delete Measurement Record</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">Are you sure you want to delete measurement for "{{ $detailToDelete?->ionizer?->register_no ?? 'this ionizer' }}"? This action cannot be undone.</p>
                        <div class="flex justify-center gap-3">
                            <button @click="open = false" class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800">Cancel</button>
                            <button wire:click="delete" @click="open = false" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Yes, Delete</button>
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