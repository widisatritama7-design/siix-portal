<section class="w-full">
    @include('partials.esd-heading')

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge - ESD Patrol') }}
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
                        Patrol
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                    Patrol
                </h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    Manage ESD Patrol Inspection Records
                </p>
            </div>
        </x-slot>
        
        <div class="-mt-2">
            <!-- Header with Filters -->
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
                            <span x-show="filterDateFrom || filterDateUntil || filterNextDateFrom || filterNextDateUntil || search" 
                                class="ml-1 px-1.5 py-0.5 text-xs bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                Active
                            </span>
                        </button>
                    </div>
                    
                    <!-- Create Button -->
                    <div class="flex gap-2">
                        @can('create patrol')
                        <flux:button 
                            variant="primary" 
                            icon="plus" 
                            class="bg-blue-600 hover:bg-blue-700 whitespace-nowrap"
                            wire:click="resetForm"
                            x-on:click="$dispatch('open-modal', 'patrol-form-modal')"
                        >
                            Add New Patrol
                        </flux:button>
                        @endcan
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
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by area, location, or remarks..." class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>

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
                        <button wire:click="resetFilters" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">Clear All Filters</button>
                    </div>
                    @endif
                </div>
            </div>

            <!-- PRINT SECTION -->
            <div class="mb-4">
                <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700 shadow-sm">
                    <h3 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Report
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Filter Area -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Area</label>
                            <select wire:model.live="printAreaFilter" 
                                class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                                <option value="">All Areas</option>
                                <option value="WH Material">WH Material</option>
                                <option value="Production 01">Production 01</option>
                                <option value="Production 02">Production 02</option>
                                <option value="WH Finish Good">WH Finish Good</option>
                            </select>
                        </div>
                        
                        <!-- Date From -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date From</label>
                            <input type="date" 
                                wire:model.live="printDateFrom" 
                                class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>
                        
                        <!-- Date Until -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date Until</label>
                            <input type="date" 
                                wire:model.live="printDateUntil" 
                                class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        </div>
                    </div>
                    
                    <!-- Print Buttons - Hanya muncul jika ada filter yang diisi -->
                    @if($printAreaFilter || $printLocationFilter || $printJudgementFilter || $printDateFrom || $printDateUntil)
                    <div class="flex gap-2 mt-4">
                        <button wire:click="printPDF" 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                            </svg>
                            Download PDF
                        </button>
                        
                        <button wire:click="resetPrintFilters" 
                                class="inline-flex items-center gap-2 px-4 py-2 border border-zinc-300 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Reset Filters
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            <!-- END PRINT SECTION -->

            <style>
                [x-cloak] { display: none !important; }
            </style>

            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden mb-6">
                <!-- Header with Solid Color -->
                <div class="bg-orange-600 dark:bg-orange-500 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <h3 class="font-semibold text-base text-white">CHECK SHEET ESD PATROL</h3>
                    </div>
                </div>
                
                <div class="p-6" x-data="{ open: false }">
                    <!-- Toggle Button inside content -->
                    <button 
                        @click="open = !open"
                        class="w-full flex items-center justify-between p-3 bg-gray-50 dark:bg-zinc-800/50 rounded-lg hover:bg-gray-100 dark:hover:bg-zinc-800 transition-colors mb-4"
                    >
                        <div class="flex items-center gap-2">
                            <flux:icon name="clipboard-document-list" class="w-5 h-5 text-orange-600 dark:text-orange-400" />
                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">View Check Sheet Details</span>
                        </div>
                        <flux:icon x-show="!open" name="chevron-down" class="w-5 h-5 text-zinc-500" />
                        <flux:icon x-show="open" name="chevron-up" class="w-5 h-5 text-zinc-500" />
                    </button>
                    
                    <div x-show="open" x-collapse x-cloak>
                        <div class="pt-2 space-y-4">
                            <!-- V-1: Grounding System Check -->
                            <div class="bg-blue-50 dark:bg-blue-950/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center text-xs font-bold">
                                        V-1
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-blue-800 dark:text-blue-400 mb-1">Grounding System Check</h4>
                                        <p class="text-sm text-blue-700 dark:text-blue-300">
                                            Ensure there is no damage or disconnected cable connections
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- V-2: ESD Protection Equipment Verification -->
                            <div class="bg-purple-50 dark:bg-purple-950/20 rounded-lg p-4 border border-purple-200 dark:border-purple-800">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-8 h-8 bg-purple-600 text-white rounded-lg flex items-center justify-center text-xs font-bold">
                                        V-2
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-purple-800 dark:text-purple-400 mb-1">ESD Protection Equipment Verification</h4>
                                        <p class="text-sm text-purple-700 dark:text-purple-300">
                                            Ensure ionizers and continuous monitors are in good and effective condition
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- V-3: Humidity Check -->
                            <div class="bg-green-50 dark:bg-green-950/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-8 h-8 bg-green-600 text-white rounded-lg flex items-center justify-center text-xs font-bold">
                                        V-3
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-green-800 dark:text-green-400 mb-1">Humidity Check</h4>
                                        <p class="text-sm text-green-700 dark:text-green-300">
                                            Ensure the humidity level in the EPA area is within the standard range of <span class="font-bold">35% - 65%</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- V-4: ESD Measuring Instrument Testing -->
                            <div class="bg-yellow-50 dark:bg-yellow-950/20 rounded-lg p-4 border border-yellow-200 dark:border-yellow-800">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-8 h-8 bg-yellow-600 text-white rounded-lg flex items-center justify-center text-xs font-bold">
                                        V-4
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-yellow-800 dark:text-yellow-400 mb-1">ESD Measuring Instrument Testing</h4>
                                        <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                            Ensure the equipment functions properly and accurately according to <span class="font-mono font-bold">SW-ZZ-052</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Frequency and Document Reference -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 mt-2 border-t border-zinc-200 dark:border-zinc-700">
                                <!-- Frequency -->
                                <div class="bg-teal-50 dark:bg-teal-950/30 rounded-lg p-3 text-center">
                                    <div class="flex items-center justify-center gap-2 mb-2">
                                        <flux:icon name="clock" class="w-4 h-4 text-teal-600 dark:text-teal-400" />
                                        <label class="text-sm font-semibold text-teal-800 dark:text-teal-400 uppercase tracking-wider">
                                            Frequency
                                        </label>
                                    </div>
                                    <p class="text-lg font-bold text-teal-700 dark:text-teal-400">
                                        Daily 08:00 - 09:00
                                    </p>
                                </div>

                                <!-- Document Reference -->
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-3">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <div class="flex items-center gap-2">
                                            <flux:icon name="document-text" class="w-4 h-4 text-zinc-500" />
                                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Document Reference</span>
                                        </div>
                                        <code class="text-sm font-mono font-bold text-zinc-800 dark:text-white bg-white dark:bg-zinc-900 px-3 py-1 rounded">
                                            QR-ADM-24-K063
                                        </code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </flux:card>

            <!-- Patrol Records Table -->
            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-16">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Area</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Location</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">V1</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">V2</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">V3</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-28">Judgement V3</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">V4</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Remarks</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">Check By</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Next Date</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($patrols as $index => $patrol)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="patrol-{{ $patrol->id }}">
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $patrols->firstItem() + $index }}
                                  </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white font-medium shadow-lg flex-shrink-0">
                                            {{ strtoupper(substr($patrol->area, 0, 2)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <span class="text-sm font-semibold text-zinc-800 dark:text-white block truncate max-w-[200px]" title="{{ $patrol->area }}">
                                                {{ $patrol->area }}
                                            </span>
                                        </div>
                                    </div>
                                  </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $patrol->location }}
                                  </td>
                                <td class="px-4 py-3">
                                    @php
                                        $v1Color = $patrol->v_1 == 'Connected' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $v1Color }} whitespace-nowrap">
                                        {{ $patrol->v_1 }}
                                    </span>
                                  </td>
                                <td class="px-4 py-3">
                                    @php
                                        $v2Color = $patrol->v_2 == 'Good' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $v2Color }} whitespace-nowrap">
                                        {{ $patrol->v_2 }}
                                    </span>
                                  </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 font-mono">
                                    {{ $patrol->v_3 }}
                                  </td>
                                <td class="px-4 py-3">
                                    @php
                                        $judgementColor = $patrol->judgement_v3 == 'Good' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $judgementColor }} whitespace-nowrap">
                                        {{ $patrol->judgement_v3 }}
                                    </span>
                                  </td>
                                <td class="px-4 py-3">
                                    @php
                                        $v4Color = $patrol->v_4 == 'Good' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $v4Color }} whitespace-nowrap">
                                        {{ $patrol->v_4 }}
                                    </span>
                                  </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 truncate max-w-[150px]" title="{{ $patrol->remarks }}">
                                    {{ $patrol->remarks ?? '-' }}
                                  </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm min-w-0">
                                        <div class="truncate max-w-[150px]" title="{{ $patrol->creator->name ?? 'N/A' }}">
                                            {{ $patrol->creator->name ?? 'N/A' }}
                                        </div>
                                    </div>
                                  </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $patrol->created_at ? $patrol->created_at->format('d M Y') : '-' }}
                                  </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $patrol->next_date ? \Carbon\Carbon::parse($patrol->next_date)->format('d M Y') : '-' }}
                                  </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                        @can('edit patrol')
                                        <flux:button 
                                            wire:click="edit({{ $patrol->id }})" 
                                            x-on:click="$dispatch('open-modal', 'patrol-form-modal')"
                                            size="sm"
                                            icon="pencil-square"
                                            variant="primary"
                                            color="yellow"
                                            class="!p-2 flex-shrink-0"
                                            title="Edit record"
                                        />
                                        @endcan

                                        @can('delete patrol')
                                            <flux:button 
                                                wire:click="confirmDelete({{ $patrol->id }})" 
                                                x-on:click="$dispatch('open-modal', 'delete-patrol-modal')"
                                                size="sm"
                                                icon="trash"
                                                variant="primary"
                                                color="red"
                                                class="!p-2 flex-shrink-0"
                                                title="Delete record"
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
                                                No patrol records found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                                {{ $search || $filterDateFrom || $filterDateUntil || $filterNextDateFrom || $filterNextDateUntil ? 'Try adjusting your filters' : 'Get started by creating a new patrol record' }}
                                            </p>
                                        </div>
                                        @if($search || $filterDateFrom || $filterDateUntil || $filterNextDateFrom || $filterNextDateUntil)
                                            <flux:button wire:click="resetFilters" size="sm">
                                                Clear Filters
                                            </flux:button>
                                        @else
                                            @can('create patrol')
                                            <flux:button 
                                                variant="primary" 
                                                size="sm"
                                                wire:click="resetForm"
                                                x-on:click="$dispatch('open-modal', 'patrol-form-modal')"
                                            >
                                                Add Your First Record
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
                @if($patrols->hasPages())
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $patrols->links() }}
                </div>
                @endif
            </flux:card>

            <!-- MODAL FORM PATROL -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-modal.window="if ($event.detail === 'patrol-form-modal') open = true"
                 @close-modal.window="if ($event.detail === 'patrol-form-modal') open = false"
                 x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                            <form wire:submit="save">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Area -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Area <span class="text-red-500">*</span></label>
                                        <select wire:model.live="area" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                                            <option value="">Select Area</option>
                                            <option value="WH Material">WH Material</option>
                                            <option value="Production 01">Production 01</option>
                                            <option value="Production 02">Production 02</option>
                                            <option value="WH Finish Good">WH Finish Good</option>
                                        </select>
                                        @error('area') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Location -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Location <span class="text-red-500">*</span></label>
                                        <select wire:model="location" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500" {{ !$area ? 'disabled' : '' }}>
                                            <option value="">Select Location</option>
                                            @foreach($this->locationOptions as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- V1 -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">V1 <span class="text-red-500">*</span></label>
                                        <div class="flex gap-4 mt-2">
                                            <label class="inline-flex items-center">
                                                <input type="radio" wire:model="v_1" value="Connected" class="form-radio text-green-600">
                                                <span class="ml-2">Connected</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" wire:model="v_1" value="Not Connected" class="form-radio text-red-600">
                                                <span class="ml-2">Not Connected</span>
                                            </label>
                                        </div>
                                        @error('v_1') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- V2 -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">V2 <span class="text-red-500">*</span></label>
                                        <div class="flex gap-4 mt-2">
                                            <label class="inline-flex items-center">
                                                <input type="radio" wire:model="v_2" value="Good" class="form-radio text-green-600">
                                                <span class="ml-2">Good</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" wire:model="v_2" value="Not Good" class="form-radio text-red-600">
                                                <span class="ml-2">Not Good</span>
                                            </label>
                                        </div>
                                        @error('v_2') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- V3 -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">V3 (35-65) <span class="text-red-500">*</span></label>
                                        <input type="number" step="0.01" wire:model.live="v_3" placeholder="Enter value between 35-65" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                                        @error('v_3') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Judgement V3 (auto-generated) -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Judgement V3</label>
                                        <div class="mt-2">
                                            @if($judgement_v3)
                                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $judgement_v3 == 'Good' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $judgement_v3 }}
                                                </span>
                                            @else
                                                <span class="text-sm text-zinc-500">Auto-calculated from V3 value</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- V4 -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">V4 <span class="text-red-500">*</span></label>
                                        <div class="flex gap-4 mt-2">
                                            <label class="inline-flex items-center">
                                                <input type="radio" wire:model="v_4" value="Good" class="form-radio text-green-600">
                                                <span class="ml-2">Good</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" wire:model="v_4" value="Not Good" class="form-radio text-red-600">
                                                <span class="ml-2">Not Good</span>
                                            </label>
                                        </div>
                                        @error('v_4') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Next Date -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Next Date</label>
                                        <input type="date" wire:model="next_date" min="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                                        @error('next_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Remarks (full width) -->
                                    <div class="mb-4 md:col-span-2">
                                        <label class="block text-sm font-medium mb-1">Remarks</label>
                                        <textarea wire:model="remarks" rows="3" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700" placeholder="Optional remarks..."></textarea>
                                        @error('remarks') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
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
                                        {{ $patrol_id ? 'Update' : 'Create' }}
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
                 @open-modal.window="if ($event.detail === 'delete-patrol-modal') open = true"
                 @close-modal.window="if ($event.detail === 'delete-patrol-modal') open = false"
                 x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>

                        <h3 class="text-lg font-bold mb-2">Delete Patrol Record</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Are you sure you want to delete patrol record at location "{{ $patrolToDelete?->location }}"? This action cannot be undone.
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