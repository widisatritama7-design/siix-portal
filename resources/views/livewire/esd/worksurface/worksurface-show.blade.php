<section class="w-full">
    

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge - Worksurface Detail') }}
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
                    <flux:breadcrumbs.item href="{{ route('esd.worksurfaces') }}" wire:navigate separator="slash">
                        Worksurface
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
                            View Worksurface
                        </h1>
                        <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            View detailed information about ESD worksurface equipment
                        </p>
                    </div>
                    <div class="w-full sm:w-auto flex-shrink-0">
                        <flux:button 
                            href="{{ route('esd.worksurfaces') }}"
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
            <!-- Worksurface Information Card -->
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden mb-6">
                <!-- Header with Solid Color -->
                <div class="bg-teal-600 dark:bg-teal-500 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                        </svg>
                        <h3 class="font-semibold text-base text-white">Worksurface Information</h3>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6 text-center">
                        <!-- Register No -->
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Register No</label>
                            <p class="mt-1 text-base font-semibold text-zinc-800 dark:text-white">
                                {{ $worksurface->register_no }}
                            </p>
                        </div>

                        <!-- Area -->
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Area</label>
                            <p class="mt-1 text-base text-zinc-800 dark:text-white">
                                {{ $worksurface->area }}
                            </p>
                        </div>

                        <!-- Location -->
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Location</label>
                            <p class="mt-1 text-base text-zinc-800 dark:text-white">
                                {{ $worksurface->location }}
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
                                    $statusColor = $statusConfig[$worksurface->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                                    {{ $worksurface->status }}
                                </span>
                            </div>
                        </div>

                        <!-- Layer Count -->
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Layer Count</label>
                            <p class="mt-1 text-base text-zinc-800 dark:text-white">
                                {{ $worksurface->layer_count ?? '-' }}
                            </p>
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Category</label>
                            <p class="mt-1 text-base text-zinc-800 dark:text-white uppercase">
                                {{ $worksurface->category ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </flux:card>

            <!-- Standard ESD Worksurface Card -->
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden mb-6">
                <!-- Header with Solid Color -->
                <div class="bg-teal-600 dark:bg-teal-500 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <h3 class="font-semibold text-base text-white">Standard ESD Of Worksurface</h3>
                    </div>
                </div>
                
                <div class="p-6" x-data="{ open: false }">
                    <!-- Toggle Button inside content -->
                    <button 
                        @click="open = !open"
                        class="w-full flex items-center justify-between p-3 bg-gray-50 dark:bg-zinc-800/50 rounded-lg hover:bg-gray-100 dark:hover:bg-zinc-800 transition-colors mb-4"
                    >
                        <div class="flex items-center gap-2">
                            <flux:icon name="beaker" class="w-5 h-5 text-teal-600 dark:text-teal-400" />
                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">View Standard Details</span>
                        </div>
                        <flux:icon x-show="!open" name="chevron-down" class="w-5 h-5 text-zinc-500" />
                        <flux:icon x-show="open" name="chevron-up" class="w-5 h-5 text-zinc-500" />
                    </button>
                    
                    <div x-show="open" x-collapse x-cloak>
                        <div class="pt-2">
                            {{-- STANDARD VALUES: A1, A2, A3 --}}
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
                                <!-- Standard Value A1 -->
                                <div class="text-center">
                                    <div class="flex items-center justify-center gap-2 mb-2">
                                        <flux:icon name="beaker" class="w-4 h-4 text-teal-600 dark:text-teal-400" />
                                        <label class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">
                                            (A1) Mat Surface Point To Ground
                                        </label>
                                    </div>
                                    <div class="bg-teal-50 dark:bg-teal-950/30 rounded-lg p-3">
                                        <p class="text-2xl font-bold text-teal-700 dark:text-teal-400">
                                            &lt; 1.00E+9 Ohm
                                        </p>
                                    </div>
                                </div>

                                <!-- Standard Value A2 -->
                                <div class="text-center">
                                    <div class="flex items-center justify-center gap-2 mb-2">
                                        <flux:icon name="bolt" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                        <label class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">
                                            (A2) Mat Surface Static Field Voltage
                                        </label>
                                    </div>
                                    <div class="bg-blue-50 dark:bg-blue-950/30 rounded-lg p-3">
                                        <p class="text-2xl font-bold text-blue-700 dark:text-blue-400">
                                            &lt; 100 Volt
                                        </p>
                                    </div>
                                </div>

                                <!-- Standard Value A3 -->
                                <div class="text-center">
                                    <div class="flex items-center justify-center gap-2 mb-2">
                                        <flux:icon name="sparkles" class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                                        <label class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">
                                            (A3) Clear Acrylic Static Field Voltage ( If Any )
                                        </label>
                                    </div>
                                    <div class="bg-purple-50 dark:bg-purple-950/30 rounded-lg p-3">
                                        <p class="text-2xl font-bold text-purple-700 dark:text-purple-400">
                                            &lt; 100 Volt
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- ✅ STANDARD VALUES: A4 VISUAL INSPECTION CHECKLIST --}}
                            <div class="mb-6">
                                <div class="flex items-center justify-center gap-2 mb-3">
                                    <flux:icon name="clipboard-document-check" class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                                    <label class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">
                                        (A4) Visual Inspection Checklist
                                    </label>
                                </div>

                                @php
                                    $a4Standards = [
                                        ['code' => 'A-4.1', 'text' => 'Kondisi permukaan Mat tidak rusak, robek atau terkelupas'],
                                        ['code' => 'A-4.2', 'text' => 'Tidak terdapat material non-ESD yang menutupi permukaan Mat'],
                                        ['code' => 'A-4.3', 'text' => 'Grounding cable terpasang dan tidak putus/terlepas'],
                                        ['code' => 'A-4.4', 'text' => 'Tidak terdapat kerusakan fisik pada frame atau struktur equipment'],
                                        ['code' => 'A-4.5', 'text' => 'Rantai Pada Trolley 3 Pcs dan tidak kendor dan terpasang'],
                                    ];
                                @endphp

                                <div class="bg-amber-50 dark:bg-amber-950/30 rounded-lg p-4 border border-amber-200 dark:border-amber-900/50">
                                    <div class="space-y-2">
                                        @foreach($a4Standards as $std)
                                            <div class="flex items-start gap-3 bg-white dark:bg-zinc-900/40 rounded-md p-2.5">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide bg-amber-600 text-white flex-shrink-0 mt-0.5">
                                                    {{ $std['code'] }}
                                                </span>
                                                <p class="text-sm text-zinc-700 dark:text-zinc-300 leading-snug">
                                                    {{ $std['text'] }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-3 pt-3 border-t border-amber-200 dark:border-amber-900/50 text-center">
                                        <p class="text-xs font-medium text-amber-800 dark:text-amber-300">
                                            Expected Result: <span class="font-bold uppercase">All YES</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Frequency -->
                            <div class="text-center mb-6">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <flux:icon name="calendar" class="w-4 h-4 text-green-600 dark:text-green-400" />
                                    <label class="text-sm font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">
                                        Frequency
                                    </label>
                                </div>
                                <div class="bg-green-50 dark:bg-green-950/30 rounded-lg p-3 inline-block px-8">
                                    <p class="text-2xl font-bold text-green-700 dark:text-green-400">
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
                                        QR-ADM-22-K014
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
                            @can('create worksurface details')
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
                                    <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Actions</th>
                                  </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                @forelse($details as $index => $detail)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="detail-{{ $detail->id }}">
                                    <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 uppercase">
                                        {{ $detail->item }}
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
                                                $judgementA3Color = $detail->judgement_a3 == 'OK'
                                                    ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
                                                    : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
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
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                            @can('edit worksurface details')
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

                                            @can('delete worksurface details')
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
                                    <td colspan="10" class="px-4 py-12 text-center">
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
            </div>

            <!-- MODAL FORM MEASUREMENT DETAIL -->
            <div x-data="{ open: false }"
                x-show="open"
                @open-modal.window="if ($event.detail === 'detail-form-modal') open = true"
                @close-modal.window="if ($event.detail === 'detail-form-modal') open = false"
                x-cloak>

                <div class="fixed inset-0 bg-zinc-900/60 backdrop-blur-sm z-40" x-transition.opacity @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[92vh] flex flex-col overflow-hidden border border-zinc-200 dark:border-zinc-800"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100">

                        {{-- HEADER --}}
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
                                        {{ $detail_id ? 'Update existing measurement record' : 'Add a new measurement record' }}
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
                            <form wire:submit="save" id="detail-form" class="p-6 space-y-6">
                                <input type="hidden" wire:model="worksurface_id">

                                {{-- SECTION 1: MEASUREMENT ITEM --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                                            <flux:icon name="cpu-chip" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">Measurement Item</h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                Worksurface: <span class="font-semibold text-zinc-700 dark:text-zinc-300">{{ $worksurface->register_no }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Item - Searchable Dropdown + Manual Input -->
                                    <div x-data="{ open: false }"
                                        @click.outside="open = false; $wire.set('showItemDropdown', false)">
                                        <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">
                                            Item <span class="text-red-500">*</span>
                                        </label>

                                        <div class="relative">
                                            {{-- Trigger / Input --}}
                                            <div class="relative">
                                                <input type="text"
                                                    wire:model.live.debounce.150ms="itemSearch"
                                                    x-ref="itemInput"
                                                    @focus="open = true; $wire.set('showItemDropdown', true)"
                                                    @click="open = true; $wire.set('showItemDropdown', true)"
                                                    @keydown.enter.prevent="
                                                            @if(count($this->filteredItemOptions) > 0)
                                                                $wire.selectItem($wire.filteredItemOptions[0])
                                                            @else
                                                                $wire.selectItem($wire.itemSearch)
                                                            @endif
                                                            open = false;
                                                    "
                                                    oninput="this.value = this.value.toUpperCase()"
                                                    placeholder="Select from list or type manually..."
                                                    class="w-full pl-10 pr-20 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 uppercase focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow" />

                                                {{-- Left icon --}}
                                                <div class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                                    <flux:icon name="tag" class="w-4 h-4 text-zinc-400" />
                                                </div>

                                                {{-- Right actions --}}
                                                <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1">
                                                    @if($itemSearch)
                                                        <button type="button"
                                                                wire:click="clearItem"
                                                                class="w-6 h-6 rounded-md hover:bg-zinc-200 dark:hover:bg-zinc-700 flex items-center justify-center transition-colors"
                                                                title="Clear">
                                                            <flux:icon name="x-mark" class="w-3.5 h-3.5 text-zinc-500" />
                                                        </button>
                                                    @endif
                                                    <flux:icon name="chevron-down"
                                                            class="w-4 h-4 text-zinc-500 cursor-pointer"
                                                            ::class="open ? 'rotate-180' : ''"
                                                            @click="open = !open; $wire.set('showItemDropdown', open); $refs.itemInput.focus()" />
                                                </div>
                                            </div>

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

                                                {{-- Grouped presets --}}
                                                @php
                                                    $grouped = [
                                                        'TABLE' => [],
                                                        'RACK' => [],
                                                        'TROLLEY' => [],
                                                    ];
                                                    foreach ($this->filteredItemOptions as $opt) {
                                                        foreach ($grouped as $group => $list) {
                                                            if (str_starts_with($opt, $group)) {
                                                                $grouped[$group][] = $opt;
                                                                break;
                                                            }
                                                        }
                                                    }
                                                    $hasPreset = count($this->filteredItemOptions) > 0;
                                                    $isCustom  = $itemSearch && !in_array(strtoupper($itemSearch), $this->itemOptions, true);
                                                @endphp

                                                <div class="max-h-64 overflow-y-auto py-1">
                                                    @if($hasPreset)
                                                        @foreach($grouped as $groupName => $groupItems)
                                                            @if(count($groupItems) > 0)
                                                                <div class="px-3 pt-2 pb-1 text-[10px] font-bold uppercase tracking-wider text-zinc-400 dark:text-zinc-500 flex items-center gap-1.5">
                                                                    <flux:icon name="folder" class="w-3 h-3" />
                                                                    {{ $groupName }}
                                                                </div>
                                                                @foreach($groupItems as $opt)
                                                                    <button type="button"
                                                                            wire:click="selectItem('{{ $opt }}')"
                                                                            @click="open = false"
                                                                            class="w-full px-3 py-2 text-left flex items-center justify-between gap-2 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors group
                                                                                {{ strtoupper($itemSearch) === $opt ? 'bg-blue-50 dark:bg-blue-900/30' : '' }}">
                                                                        <div class="flex items-center gap-2.5 min-w-0">
                                                                            <div class="w-7 h-7 rounded-md bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white flex-shrink-0">
                                                                                <flux:icon name="tag" class="w-3.5 h-3.5" />
                                                                            </div>
                                                                            <span class="text-sm font-medium text-zinc-800 dark:text-zinc-200 truncate">
                                                                                {{ $opt }}
                                                                            </span>
                                                                        </div>
                                                                        @if(strtoupper($itemSearch) === $opt)
                                                                            <flux:icon name="check" class="w-4 h-4 text-blue-600 dark:text-blue-400 flex-shrink-0" />
                                                                        @endif
                                                                    </button>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    {{-- Custom value option (when typing something not in list) --}}
                                                    @if($isCustom)
                                                        <div class="border-t border-zinc-200 dark:border-zinc-700 mt-1 pt-1">
                                                            <div class="px-3 pt-1 pb-1 text-[10px] font-bold uppercase tracking-wider text-amber-500 dark:text-amber-400 flex items-center gap-1.5">
                                                                <flux:icon name="pencil-square" class="w-3 h-3" />
                                                                Custom Value
                                                            </div>
                                                            <button type="button"
                                                                    wire:click="selectItem('{{ $itemSearch }}')"
                                                                    @click="open = false"
                                                                    class="w-full px-3 py-2 text-left flex items-center gap-2.5 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors">
                                                                <div class="w-7 h-7 rounded-md bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white flex-shrink-0">
                                                                    <flux:icon name="sparkles" class="w-3.5 h-3.5" />
                                                                </div>
                                                                <div class="min-w-0 flex-1">
                                                                    <div class="text-sm font-semibold text-zinc-800 dark:text-zinc-200 truncate uppercase">
                                                                        {{ strtoupper($itemSearch) }}
                                                                    </div>
                                                                    <div class="text-[11px] text-zinc-500 dark:text-zinc-400">
                                                                        Use as custom item
                                                                    </div>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    @endif

                                                    {{-- Empty state --}}
                                                    @if(!$hasPreset && !$isCustom)
                                                        <div class="px-3 py-8 text-center">
                                                            <flux:icon name="magnifying-glass-x" class="w-8 h-8 text-zinc-300 dark:text-zinc-600 mx-auto mb-2" />
                                                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                                                No matching preset
                                                            </p>
                                                            <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">
                                                                Start typing to create a custom item
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- Footer info --}}
                                                <div class="px-3 py-1.5 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50 text-[11px] text-zinc-500 dark:text-zinc-400 flex items-center justify-between">
                                                    <span>{{ count($this->filteredItemOptions) }} preset{{ count($this->filteredItemOptions) === 1 ? '' : 's' }}</span>
                                                    <span class="flex items-center gap-1">
                                                        <kbd class="px-1.5 py-0.5 bg-white dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-600 rounded text-[10px] font-mono">↵</kbd>
                                                        to select
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        @error('item') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                {{-- SECTION 2: RESISTANCE (A1, A2, A3) --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-yellow-100 dark:bg-yellow-900/40 flex items-center justify-center">
                                            <flux:icon name="bolt" class="w-4 h-4 text-yellow-600 dark:text-yellow-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">Resistance Measurement</h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">A1, A2, A3 measurement values with automatic judgement</p>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        {{-- A1 --}}
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-yellow-200 dark:border-yellow-800/60 p-4">
                                            <div class="flex items-start justify-between gap-4 mb-3">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-lg bg-yellow-100 dark:bg-yellow-900/40 flex items-center justify-center flex-shrink-0">
                                                        <span class="text-xs font-bold text-yellow-700 dark:text-yellow-400">A1</span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">Surface Resistance</div>
                                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Standard: &lt; 1.00E+9 Ω</div>
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
                                                        class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 font-mono">
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
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-yellow-200 dark:border-yellow-800/60 p-4">
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
                                                class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 font-mono">
                                            @error('a2') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- A3 --}}
                                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-yellow-200 dark:border-yellow-800/60 p-4">
                                            <div class="flex items-start justify-between gap-4 mb-3">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 rounded-lg bg-yellow-100 dark:bg-yellow-900/40 flex items-center justify-center flex-shrink-0">
                                                        <span class="text-xs font-bold text-yellow-700 dark:text-yellow-400">A3</span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">Clear Acrylic Static Field Voltage</div>
                                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">(if any) · Standard: &lt; 100 V</div>
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
                                                class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 font-mono">
                                            @error('a3') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- SECTION 3: A4 VISUAL INSPECTION --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                                            <flux:icon name="clipboard-document-check" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">A4 — Visual Inspection Checklist</h3>
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
                                                        {{ $isYes ? 'ring-1 ring-green-200 dark:ring-green-900' : ($isNo ? 'ring-1 ring-red-200 dark:ring-red-900' : '') }}">
                                                <div class="flex items-start gap-3 flex-1 min-w-0">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide bg-blue-600 text-white flex-shrink-0 mt-0.5">
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

                                {{-- SECTION 4: NOTES --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center">
                                            <flux:icon name="document-text" class="w-4 h-4 text-zinc-600 dark:text-zinc-300" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">Additional Notes</h3>
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

                        {{-- FOOTER --}}
                        <div class="sticky bottom-0 bg-white dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-700 px-6 py-4 flex items-center justify-between shadow-[0_-4px_12px_rgba(0,0,0,0.05)]">
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 hidden sm:block">
                                <span class="text-red-500">*</span> Required fields
                            </p>
                            <div class="flex items-center gap-2 ml-auto">
                                <button type="button" @click="open = false"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    <flux:icon name="x-mark" class="w-4 h-4" />
                                    Cancel
                                </button>
                                <button type="submit" form="detail-form"
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
                [x-collapse] { overflow: hidden; }
            </style>
        </div>
    </x-esd.layout>
</section>