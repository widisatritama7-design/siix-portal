<section class="w-full">
    

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

                            {{-- C4 Visual Inspection --}}
                            <div class="pt-4">
                                <h4 class="text-lg font-semibold text-amber-700 dark:text-amber-400 mb-3 flex items-center gap-2">
                                    <flux:icon name="clipboard-document-check" class="w-5 h-5" />
                                    Visual Inspection Checklist
                                </h4>

                                <div class="bg-amber-50 dark:bg-amber-950/30 rounded-lg p-4 border border-amber-200 dark:border-amber-800">
                                    <div class="space-y-2">
                                        @php
                                            $c4Standards = [
                                                ['code' => 'C-4.1', 'text' => 'Unit ionizer dalam kondisi fisik baik dan tidak rusak'],
                                                ['code' => 'C-4.2', 'text' => 'Posisi ionizer sesuai dengan arah Panah yang ditentukan'],
                                                ['code' => 'C-4.3', 'text' => 'Emitter pin/nozzle tidak kotor atau tertutup debu dan tidak bengkok'],
                                                ['code' => 'C-4.4', 'text' => 'Kabel power/ground terpasang'],
                                                ['code' => 'C-4.5', 'text' => 'Indikator/status ionizer menunjukkan kondisi normal'],
                                            ];
                                        @endphp

                                        @foreach($c4Standards as $std)
                                            <div class="flex items-start gap-3 bg-white dark:bg-zinc-900/40 rounded-md p-2.5">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide bg-amber-600 text-white flex-shrink-0 mt-0.5">
                                                    {{ $std['code'] }}
                                                </span>
                                                <p class="text-sm text-zinc-700 dark:text-zinc-300 leading-snug">{{ $std['text'] }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-3 pt-3 border-t border-amber-200 dark:border-amber-800 text-center">
                                        <p class="text-xs font-medium text-amber-800 dark:text-amber-300">
                                            Expected Result: <span class="font-bold uppercase">All YES</span>
                                        </p>
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
                                    <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">C4.1</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">C4.2</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">C4.3</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">C4.4</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">C4.5</th>
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
                                    {{-- C4.1 --}}
                                    <td class="px-4 py-3 text-center">
                                        @if($detail->c4_1 !== null)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $detail->c4_1 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                {{ $detail->c4_1 ? 'Yes' : 'No' }}
                                            </span>
                                        @else
                                            <span class="text-zinc-400">-</span>
                                        @endif
                                    </td>

                                    {{-- C4.2 --}}
                                    <td class="px-4 py-3 text-center">
                                        @if($detail->c4_2 !== null)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $detail->c4_2 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                {{ $detail->c4_2 ? 'Yes' : 'No' }}
                                            </span>
                                        @else
                                            <span class="text-zinc-400">-</span>
                                        @endif
                                    </td>

                                    {{-- C4.3 --}}
                                    <td class="px-4 py-3 text-center">
                                        @if($detail->c4_3 !== null)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $detail->c4_3 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                {{ $detail->c4_3 ? 'Yes' : 'No' }}
                                            </span>
                                        @else
                                            <span class="text-zinc-400">-</span>
                                        @endif
                                    </td>

                                    {{-- C4.4 --}}
                                    <td class="px-4 py-3 text-center">
                                        @if($detail->c4_4 !== null)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $detail->c4_4 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                {{ $detail->c4_4 ? 'Yes' : 'No' }}
                                            </span>
                                        @else
                                            <span class="text-zinc-400">-</span>
                                        @endif
                                    </td>

                                    {{-- C4.5 --}}
                                    <td class="px-4 py-3 text-center">
                                        @if($detail->c4_5 !== null)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $detail->c4_5 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                {{ $detail->c4_5 ? 'Yes' : 'No' }}
                                            </span>
                                        @else
                                            <span class="text-zinc-400">-</span>
                                        @endif
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

                {{-- Backdrop --}}
                <div class="fixed inset-0 bg-zinc-900/60 backdrop-blur-sm z-40"
                    x-transition.opacity
                    @click="open = false"></div>

                {{-- Modal Panel --}}
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[92vh] flex flex-col overflow-hidden border border-zinc-200 dark:border-zinc-800"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100">

                        {{-- =================== HEADER =================== --}}
                        <div class="sticky top-0 z-10 bg-gradient-to-r from-orange-600 via-orange-600 to-amber-600 px-6 py-4 flex items-center justify-between shadow-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center ring-2 ring-white/30">
                                    <flux:icon name="{{ $detail_id ? 'pencil-square' : 'plus-circle' }}" class="w-5 h-5 text-white" />
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-white leading-tight">
                                        {{ $detail_id ? 'Edit Measurement' : 'New Measurement' }}
                                    </h2>
                                    <p class="text-xs text-orange-100 mt-0.5">
                                        {{ $detail_id ? 'Update existing ionizer measurement' : 'Add a new ionizer measurement' }}
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
                            <form wire:submit.prevent="save" id="detail-form" class="p-6 space-y-6">
                                <input type="hidden" wire:model="ionizer_id">

                                {{-- SECTION 1: PREVENTIVE MAINTENANCE --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center">
                                            <flux:icon name="wrench-screwdriver" class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                                Preventive Maintenance (PM)
                                            </h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                Physical inspection before measurement
                                            </p>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        {{-- PM 1 --}}
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-purple-200 dark:border-purple-800/60 p-4">
                                            <div class="flex items-start justify-between gap-4 mb-3">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center flex-shrink-0">
                                                        <span class="text-xs font-bold text-purple-700 dark:text-purple-400">1</span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">
                                                            H.V Light Flashing Condition
                                                        </div>
                                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                                            If indicator is flashing → NG
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <button type="button"
                                                        wire:click="$set('pm_1', 'FLASH')"
                                                        @class([
                                                            'inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wide transition-all duration-150',
                                                            'bg-red-600 text-white shadow-md shadow-red-600/30 ring-2 ring-red-300 dark:ring-red-700 scale-105' => $pm_1 === 'FLASH',
                                                            'bg-white dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 border border-zinc-300 dark:border-zinc-600 hover:bg-red-50 dark:hover:bg-red-900/20 hover:border-red-400 hover:text-red-700 dark:hover:text-red-400' => $pm_1 !== 'FLASH',
                                                        ])>
                                                    <flux:icon name="bolt" class="w-4 h-4" />
                                                    FLASH
                                                </button>
                                                <button type="button"
                                                        wire:click="$set('pm_1', 'NO')"
                                                        @class([
                                                            'inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wide transition-all duration-150',
                                                            'bg-green-600 text-white shadow-md shadow-green-600/30 ring-2 ring-green-300 dark:ring-green-700 scale-105' => $pm_1 === 'NO',
                                                            'bg-white dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 border border-zinc-300 dark:border-zinc-600 hover:bg-green-50 dark:hover:bg-green-900/20 hover:border-green-400 hover:text-green-700 dark:hover:text-green-400' => $pm_1 !== 'NO',
                                                        ])>
                                                    <flux:icon name="check-circle" class="w-4 h-4" />
                                                    NO
                                                </button>
                                            </div>
                                            @error('pm_1') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- PM 2 --}}
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-purple-200 dark:border-purple-800/60 p-4">
                                            <div class="flex items-start justify-between gap-4 mb-3">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center flex-shrink-0">
                                                        <span class="text-xs font-bold text-purple-700 dark:text-purple-400">2</span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">
                                                            Discharge Electrode Needle
                                                        </div>
                                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                                            Check and clean the needle
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <button type="button"
                                                        wire:click="$set('pm_2', 'OK')"
                                                        @class([
                                                            'inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wide transition-all duration-150',
                                                            'bg-green-600 text-white shadow-md shadow-green-600/30 ring-2 ring-green-300 dark:ring-green-700 scale-105' => $pm_2 === 'OK',
                                                            'bg-white dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 border border-zinc-300 dark:border-zinc-600 hover:bg-green-50 dark:hover:bg-green-900/20 hover:border-green-400 hover:text-green-700 dark:hover:text-green-400' => $pm_2 !== 'OK',
                                                        ])>
                                                    <flux:icon name="check-circle" class="w-4 h-4" />
                                                    OK
                                                </button>
                                                <button type="button"
                                                        wire:click="$set('pm_2', 'NO')"
                                                        @class([
                                                            'inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wide transition-all duration-150',
                                                            'bg-red-600 text-white shadow-md shadow-red-600/30 ring-2 ring-red-300 dark:ring-red-700 scale-105' => $pm_2 === 'NO',
                                                            'bg-white dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 border border-zinc-300 dark:border-zinc-600 hover:bg-red-50 dark:hover:bg-red-900/20 hover:border-red-400 hover:text-red-700 dark:hover:text-red-400' => $pm_2 !== 'NO',
                                                        ])>
                                                    <flux:icon name="x-circle" class="w-4 h-4" />
                                                    NO
                                                </button>
                                            </div>
                                            @error('pm_2') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- PM 3 --}}
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-purple-200 dark:border-purple-800/60 p-4">
                                            <div class="flex items-start justify-between gap-4 mb-3">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center flex-shrink-0">
                                                        <span class="text-xs font-bold text-purple-700 dark:text-purple-400">3</span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">
                                                            Filter & Fan Cleanup
                                                        </div>
                                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                                            Verification after preventive maintenance
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <button type="button"
                                                        wire:click="$set('pm_3', 'YES')"
                                                        @class([
                                                            'inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wide transition-all duration-150',
                                                            'bg-green-600 text-white shadow-md shadow-green-600/30 ring-2 ring-green-300 dark:ring-green-700 scale-105' => $pm_3 === 'YES',
                                                            'bg-white dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 border border-zinc-300 dark:border-zinc-600 hover:bg-green-50 dark:hover:bg-green-900/20 hover:border-green-400 hover:text-green-700 dark:hover:text-green-400' => $pm_3 !== 'YES',
                                                        ])>
                                                    <flux:icon name="check-circle" class="w-4 h-4" />
                                                    YES
                                                </button>
                                                <button type="button"
                                                        wire:click="$set('pm_3', 'NO')"
                                                        @class([
                                                            'inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wide transition-all duration-150',
                                                            'bg-red-600 text-white shadow-md shadow-red-600/30 ring-2 ring-red-300 dark:ring-red-700 scale-105' => $pm_3 === 'NO',
                                                            'bg-white dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 border border-zinc-300 dark:border-zinc-600 hover:bg-red-50 dark:hover:bg-red-900/20 hover:border-red-400 hover:text-red-700 dark:hover:text-red-400' => $pm_3 !== 'NO',
                                                        ])>
                                                    <flux:icon name="x-circle" class="w-4 h-4" />
                                                    NO
                                                </button>
                                            </div>
                                            @error('pm_3') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- SECTION 2: BEFORE MAINTENANCE --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                                            <flux:icon name="beaker" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                                Before Maintenance Measurements
                                            </h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                Initial measurements before servicing
                                            </p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        {{-- C1 Before --}}
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-blue-200 dark:border-blue-800/60 p-4">
                                            <div class="flex items-start justify-between gap-2 mb-2">
                                                <div>
                                                    <div class="text-xs font-bold text-blue-700 dark:text-blue-400 uppercase tracking-wide">C1 Before</div>
                                                    <div class="text-[10px] text-zinc-500 dark:text-zinc-400 mt-0.5">Decay Time (+)</div>
                                                </div>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                                    {{ $judgement_c1_before == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' : ($judgement_c1_before == 'NG' ? 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400') }}">
                                                    {{ $judgement_c1_before ?: 'AUTO' }}
                                                </span>
                                            </div>
                                            <div class="text-[10px] text-blue-600 dark:text-blue-400 mb-1">&lt; 8.0 s</div>
                                            <input type="number" step="0.01" wire:model="c1_before" wire:blur="resetJudgements"
                                                placeholder="0.00"
                                                class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 font-mono">
                                            @error('c1_before') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- C2 Before --}}
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-blue-200 dark:border-blue-800/60 p-4">
                                            <div class="flex items-start justify-between gap-2 mb-2">
                                                <div>
                                                    <div class="text-xs font-bold text-blue-700 dark:text-blue-400 uppercase tracking-wide">C2 Before</div>
                                                    <div class="text-[10px] text-zinc-500 dark:text-zinc-400 mt-0.5">Decay Time (-)</div>
                                                </div>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                                    {{ $judgement_c2_before == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' : ($judgement_c2_before == 'NG' ? 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400') }}">
                                                    {{ $judgement_c2_before ?: 'AUTO' }}
                                                </span>
                                            </div>
                                            <div class="text-[10px] text-blue-600 dark:text-blue-400 mb-1">&lt; 8.0 s</div>
                                            <input type="number" step="0.01" wire:model="c2_before" wire:blur="resetJudgements"
                                                placeholder="0.00"
                                                class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 font-mono">
                                            @error('c2_before') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- C3 Before --}}
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-blue-200 dark:border-blue-800/60 p-4">
                                            <div class="flex items-start justify-between gap-2 mb-2">
                                                <div>
                                                    <div class="text-xs font-bold text-blue-700 dark:text-blue-400 uppercase tracking-wide">C3 Before</div>
                                                    <div class="text-[10px] text-zinc-500 dark:text-zinc-400 mt-0.5">Offset Voltage</div>
                                                </div>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                                    {{ $judgement_c3_before == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' : ($judgement_c3_before == 'NG' ? 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400') }}">
                                                    {{ $judgement_c3_before ?: 'AUTO' }}
                                                </span>
                                            </div>
                                            <div class="text-[10px] text-green-600 dark:text-green-400 mb-1">± 35 V</div>
                                            <input type="number" step="0.01" wire:model="c3_before" wire:blur="resetJudgements"
                                                placeholder="0.00"
                                                class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 font-mono">
                                            @error('c3_before') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- SECTION 3: AFTER MAINTENANCE --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/40 flex items-center justify-center">
                                            <flux:icon name="sparkles" class="w-4 h-4 text-green-600 dark:text-green-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                                After Maintenance Measurements
                                            </h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                Final measurements after servicing
                                            </p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        {{-- C1 --}}
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-green-200 dark:border-green-800/60 p-4">
                                            <div class="flex items-start justify-between gap-2 mb-2">
                                                <div>
                                                    <div class="text-xs font-bold text-green-700 dark:text-green-400 uppercase tracking-wide">C1</div>
                                                    <div class="text-[10px] text-zinc-500 dark:text-zinc-400 mt-0.5">Decay Time (+)</div>
                                                </div>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                                    {{ $judgement_c1 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' : ($judgement_c1 == 'NG' ? 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400') }}">
                                                    {{ $judgement_c1 ?: 'AUTO' }}
                                                </span>
                                            </div>
                                            <div class="text-[10px] text-blue-600 dark:text-blue-400 mb-1">&lt; 8.0 s</div>
                                            <input type="number" step="0.01" wire:model="c1" wire:blur="resetJudgements"
                                                placeholder="0.00"
                                                class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 font-mono">
                                            @error('c1') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- C2 --}}
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-green-200 dark:border-green-800/60 p-4">
                                            <div class="flex items-start justify-between gap-2 mb-2">
                                                <div>
                                                    <div class="text-xs font-bold text-green-700 dark:text-green-400 uppercase tracking-wide">C2</div>
                                                    <div class="text-[10px] text-zinc-500 dark:text-zinc-400 mt-0.5">Decay Time (-)</div>
                                                </div>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                                    {{ $judgement_c2 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' : ($judgement_c2 == 'NG' ? 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400') }}">
                                                    {{ $judgement_c2 ?: 'AUTO' }}
                                                </span>
                                            </div>
                                            <div class="text-[10px] text-blue-600 dark:text-blue-400 mb-1">&lt; 8.0 s</div>
                                            <input type="number" step="0.01" wire:model="c2" wire:blur="resetJudgements"
                                                placeholder="0.00"
                                                class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 font-mono">
                                            @error('c2') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- C3 --}}
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-green-200 dark:border-green-800/60 p-4">
                                            <div class="flex items-start justify-between gap-2 mb-2">
                                                <div>
                                                    <div class="text-xs font-bold text-green-700 dark:text-green-400 uppercase tracking-wide">C3</div>
                                                    <div class="text-[10px] text-zinc-500 dark:text-zinc-400 mt-0.5">Offset Voltage</div>
                                                </div>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                                    {{ $judgement_c3 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' : ($judgement_c3 == 'NG' ? 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400') }}">
                                                    {{ $judgement_c3 ?: 'AUTO' }}
                                                </span>
                                            </div>
                                            <div class="text-[10px] text-green-600 dark:text-green-400 mb-1">± 35 V</div>
                                            <input type="number" step="0.01" wire:model="c3" wire:blur="resetJudgements"
                                                placeholder="0.00"
                                                class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 font-mono">
                                            @error('c3') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- SECTION 4: VISUAL INSPECTION C4 --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center">
                                            <flux:icon name="clipboard-document-check" class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                                C4 — Visual Inspection Checklist
                                            </h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                Tick <span class="font-semibold text-green-600">YES</span> if condition is met, <span class="font-semibold text-red-600">NO</span> if not
                                            </p>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        @php
                                            $c4Items = [
                                                ['field' => 'c4_1', 'code' => 'C-4.1', 'text' => 'Unit ionizer dalam kondisi fisik baik dan tidak rusak'],
                                                ['field' => 'c4_2', 'code' => 'C-4.2', 'text' => 'Posisi ionizer sesuai dengan arah Panah yang ditentukan'],
                                                ['field' => 'c4_3', 'code' => 'C-4.3', 'text' => 'Emitter pin/nozzle tidak kotor atau tertutup debu dan tidak bengkok'],
                                                ['field' => 'c4_4', 'code' => 'C-4.4', 'text' => 'Kabel power/ground terpasang'],
                                                ['field' => 'c4_5', 'code' => 'C-4.5', 'text' => 'Indikator/status ionizer menunjukkan kondisi normal'],
                                            ];
                                        @endphp

                                        @foreach($c4Items as $item)
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

                                {{-- SECTION 5: NOTES --}}
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
                                <button type="submit" form="detail-form"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white rounded-xl transition-all text-sm font-semibold shadow-lg shadow-orange-600/30 hover:shadow-orange-600/50">
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