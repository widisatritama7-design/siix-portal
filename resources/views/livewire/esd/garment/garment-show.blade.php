{{-- resources/views/livewire/esd/garment/garment-show.blade.php --}}
<section class="w-full">
    

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
                                        4 => 'Finish Contract',
                                        5 => 'Resign',
                                        default => 'Unknown',
                                    };
                                    $statusColor = match($garment->status) {
                                        1 => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 ring-1 ring-blue-300 dark:ring-blue-700',
                                        2 => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 ring-1 ring-yellow-300 dark:ring-yellow-700',
                                        3 => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400 ring-1 ring-purple-300 dark:ring-purple-700',
                                        4 => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 ring-1 ring-red-300 dark:ring-red-700',
                                        5 => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 ring-1 ring-red-300 dark:ring-red-700',
                                        default => 'bg-gray-100 text-gray-800 ring-1 ring-gray-300',
                                    };
                                @endphp
                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold {{ $statusColor }}">
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

                            {{-- SECTION 1: RESISTANCE POINT TO POINT (D1-D5) --}}
                            <div class="mb-6">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-7 h-7 rounded-lg bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center">
                                        <flux:icon name="beaker" class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                            Point to Point Resistance
                                        </h4>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                            Standard: ≥ 1.00E+4 Ω and &lt; 1.00E+11 Ω
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2">
                                    {{-- D1 --}}
                                    <div class="bg-purple-50 dark:bg-purple-950/30 rounded-lg p-2.5 text-center border border-purple-100 dark:border-purple-900/50">
                                        <div class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-purple-600 text-white text-xs font-bold mb-1.5">
                                            D1
                                        </div>
                                        <p class="text-[11px] font-semibold text-purple-700 dark:text-purple-400 mb-1">Shirt</p>
                                        <p class="text-[10px] text-purple-600 dark:text-purple-400 font-mono leading-tight whitespace-nowrap">
                                            ≥ 1.00E+4 &lt; 1.00E+11
                                        </p>
                                    </div>

                                    {{-- D2 --}}
                                    <div class="bg-purple-50 dark:bg-purple-950/30 rounded-lg p-2.5 text-center border border-purple-100 dark:border-purple-900/50">
                                        <div class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-purple-600 text-white text-xs font-bold mb-1.5">
                                            D2
                                        </div>
                                        <p class="text-[11px] font-semibold text-purple-700 dark:text-purple-400 mb-1">Pants</p>
                                        <p class="text-[10px] text-purple-600 dark:text-purple-400 font-mono leading-tight whitespace-nowrap">
                                            ≥ 1.00E+4 &lt; 1.00E+11
                                        </p>
                                    </div>

                                    {{-- D3 --}}
                                    <div class="bg-purple-50 dark:bg-purple-950/30 rounded-lg p-2.5 text-center border border-purple-100 dark:border-purple-900/50">
                                        <div class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-purple-600 text-white text-xs font-bold mb-1.5">
                                            D3
                                        </div>
                                        <p class="text-[11px] font-semibold text-purple-700 dark:text-purple-400 mb-1">Cap</p>
                                        <p class="text-[10px] text-purple-600 dark:text-purple-400 font-mono leading-tight whitespace-nowrap">
                                            ≥ 1.00E+4 &lt; 1.00E+11
                                        </p>
                                    </div>

                                    {{-- D4 --}}
                                    <div class="bg-purple-50 dark:bg-purple-950/30 rounded-lg p-2.5 text-center border border-purple-100 dark:border-purple-900/50">
                                        <div class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-purple-600 text-white text-xs font-bold mb-1.5">
                                            D4
                                        </div>
                                        <p class="text-[11px] font-semibold text-purple-700 dark:text-purple-400 mb-1">Hijab</p>
                                        <p class="text-[10px] text-purple-600 dark:text-purple-400 font-mono leading-tight whitespace-nowrap">
                                            ≥ 1.00E+4 &lt; 1.00E+11
                                        </p>
                                    </div>

                                    {{-- D5 --}}
                                    <div class="bg-purple-50 dark:bg-purple-950/30 rounded-lg p-2.5 text-center border border-purple-100 dark:border-purple-900/50">
                                        <div class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-purple-600 text-white text-xs font-bold mb-1.5">
                                            D5
                                        </div>
                                        <p class="text-[11px] font-semibold text-purple-700 dark:text-purple-400 mb-1">Smock</p>
                                        <p class="text-[10px] text-purple-600 dark:text-purple-400 font-mono leading-tight whitespace-nowrap">
                                            ≥ 1.00E+4 &lt; 1.00E+11
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- SECTION 2: VISUAL INSPECTION (D6) --}}
                            <div class="mb-6">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-7 h-7 rounded-lg bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center">
                                        <flux:icon name="clipboard-document-check" class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                            Visual Inspection Checklist
                                        </h4>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                            Expected Result: All YES
                                        </p>
                                    </div>
                                </div>

                                <div class="bg-amber-50 dark:bg-amber-950/30 rounded-lg p-3 border border-amber-100 dark:border-amber-900/50">
                                    <div class="flex items-start gap-3 bg-white dark:bg-zinc-900/40 rounded-md p-2.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide bg-amber-600 text-white flex-shrink-0 mt-0.5">
                                            D-6.1
                                        </span>
                                        <p class="text-sm text-zinc-700 dark:text-zinc-300 leading-snug">
                                            Garment ESD tidak robek, berlubang, atau rusak
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- SECTION 3: FREQUENCY --}}
                            <div class="mb-6">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                                    {{-- Employee Frequency --}}
                                    <div class="bg-green-50 dark:bg-green-950/30 rounded-lg p-5 border border-green-100 dark:border-green-900/50 text-center">
                                        <div class="flex items-center justify-center gap-2 mb-2">
                                            <flux:icon name="calendar" class="w-5 h-5 text-green-600 dark:text-green-400" />
                                            <p class="text-xs font-semibold text-green-600 dark:text-green-400 uppercase tracking-wider">
                                                Frequency
                                            </p>
                                        </div>
                                        <p class="text-3xl font-bold text-green-700 dark:text-green-400">
                                            Yearly
                                        </p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                            Employee · Measurement interval
                                        </p>
                                    </div>

                                    {{-- Smock & Cap Customer Frequency --}}
                                    <div class="bg-green-50 dark:bg-green-950/30 rounded-lg p-5 border border-green-100 dark:border-green-900/50 text-center">
                                        <div class="flex items-center justify-center gap-2 mb-2">
                                            <flux:icon name="calendar" class="w-5 h-5 text-green-600 dark:text-green-400" />
                                            <p class="text-xs font-semibold text-green-600 dark:text-green-400 uppercase tracking-wider">
                                                Frequency
                                            </p>
                                        </div>
                                        <p class="text-3xl font-bold text-green-700 dark:text-green-400">
                                            Weekly
                                        </p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                            Smock &amp; Cap Customer · Measurement interval
                                        </p>
                                    </div>

                                </div>
                            </div>

                            {{-- Document Reference --}}
                            <div class="pt-4 border-t border-zinc-200 dark:border-zinc-700">
                                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-3">
                                    <div class="flex items-center gap-2">
                                        <flux:icon name="document-text" class="w-4 h-4 text-zinc-500" />
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">Document Reference</span>
                                    </div>
                                    <code class="text-sm font-mono font-bold text-zinc-800 dark:text-white bg-white dark:bg-zinc-900 px-3 py-1 rounded border border-zinc-200 dark:border-zinc-700">
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
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Smock (D5)</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-20">Judgement</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">D6.1</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Remarks</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Next Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">Checked By</th>
                                    {{--  <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Photos</th> --}}
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
                                    {{-- D5 Result --}}
                                    <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 font-mono">
                                        {{ $detail->d5_scientific ?? '-' }}
                                    </td>

                                    {{-- D5 Judgement --}}
                                    <td class="px-4 py-3">
                                        @if($detail->judgement_d5)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $detail->judgement_d5 == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                {{ $detail->judgement_d5 }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">-</span>
                                        @endif
                                    </td>

                                    {{-- D6.1 --}}
                                    <td class="px-4 py-3 text-center">
                                        @if($detail->d6_1 !== null)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $detail->d6_1 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                {{ $detail->d6_1 ? 'Yes' : 'No' }}
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
                                    {{-- <td class="px-4 py-3">
                                        @php
                                            $photos = is_string($detail->photo_verification) ? json_decode($detail->photo_verification, true) : $detail->photo_verification;
                                            $photos = is_array($photos) ? $photos : [];
                                        @endphp
                                        @if(count($photos) > 0)
                                            <button type="button"
                                                    x-on:click="$dispatch('open-photo-modal', { photos: {{ json_encode($photos) }} })"
                                                    class="group inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 border border-blue-200 dark:border-blue-800 transition-colors"
                                                    title="View {{ count($photos) }} photo(s)">
                                                <flux:icon name="photo" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                                <span class="text-xs font-semibold text-blue-700 dark:text-blue-300">
                                                    {{ count($photos) }} photo{{ count($photos) > 1 ? 's' : '' }}
                                                </span>
                                            </button>
                                        @else
                                            <span class="text-xs text-zinc-400">-</span>
                                        @endif
                                    </td> --}}
                                    <td class="px-4 py-3 text-right"
                                        x-data="{
                                            canModify: false,
                                            checkTime() {
                                                @if($detail->created_at)
                                                    const now = new Date();
                                                    const recordDate = new Date('{{ $detail->created_at->format('Y-m-d') }}T00:00:00');
                                                    const isSameDay = now.toDateString() === recordDate.toDateString();
                                                    const isBefore15 = now.getHours() < 15;
                                                    this.canModify = isSameDay && isBefore15;
                                                @else
                                                    this.canModify = false;
                                                @endif
                                            },
                                            init() {
                                                this.checkTime();
                                                setInterval(() => this.checkTime(), 60000);
                                            }
                                        }">
                                        <div class="flex items-center justify-end gap-1 whitespace-nowrap">

                                            @can('edit garment details')
                                            <div class="relative group">
                                                <button
                                                    type="button"
                                                    wire:click="edit({{ $detail->id }})"
                                                    x-on:click="canModify && $dispatch('open-modal', 'detail-form-modal')"
                                                    :disabled="!canModify"
                                                    :class="canModify
                                                        ? 'bg-yellow-500 hover:bg-yellow-600 text-white'
                                                        : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-400 dark:text-zinc-500 cursor-not-allowed opacity-50'"
                                                    class="inline-flex items-center justify-center p-2 rounded-lg transition-colors">
                                                    <flux:icon name="pencil-square" class="w-4 h-4" />
                                                </button>

                                                {{-- Custom Tooltip --}}
                                                <div class="absolute bottom-full right-0 mb-2 px-3 py-1.5 rounded-lg
                                                            bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900
                                                            text-xs font-medium whitespace-nowrap
                                                            opacity-0 group-hover:opacity-100 pointer-events-none
                                                            transition-opacity duration-150 shadow-lg z-50">
                                                    <template x-if="canModify">
                                                        <span>Edit measurement</span>
                                                    </template>
                                                    <template x-if="!canModify">
                                                        <span>Only same day before 15:00</span>
                                                    </template>
                                                    {{-- Arrow --}}
                                                    <div class="absolute top-full right-3 w-0 h-0
                                                                border-l-4 border-r-4 border-t-4
                                                                border-l-transparent border-r-transparent
                                                                border-t-zinc-900 dark:border-t-zinc-100"></div>
                                                </div>
                                            </div>
                                            @endcan

                                            @can('delete garment details')
                                            <div class="relative group">
                                                <button
                                                    type="button"
                                                    wire:click="confirmDelete({{ $detail->id }})"
                                                    x-on:click="canModify && $dispatch('open-modal', 'delete-detail-modal')"
                                                    :disabled="!canModify"
                                                    :class="canModify
                                                        ? 'bg-red-500 hover:bg-red-600 text-white'
                                                        : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-400 dark:text-zinc-500 cursor-not-allowed opacity-50'"
                                                    class="inline-flex items-center justify-center p-2 rounded-lg transition-colors">
                                                    <flux:icon name="trash" class="w-4 h-4" />
                                                </button>

                                                {{-- Custom Tooltip --}}
                                                <div class="absolute bottom-full right-0 mb-2 px-3 py-1.5 rounded-lg
                                                            bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900
                                                            text-xs font-medium whitespace-nowrap
                                                            opacity-0 group-hover:opacity-100 pointer-events-none
                                                            transition-opacity duration-150 shadow-lg z-50">
                                                    <template x-if="canModify">
                                                        <span>Delete measurement</span>
                                                    </template>
                                                    <template x-if="!canModify">
                                                        <span>Only same day before 15:00</span>
                                                    </template>
                                                    {{-- Arrow --}}
                                                    <div class="absolute top-full right-3 w-0 h-0
                                                                border-l-4 border-r-4 border-t-4
                                                                border-l-transparent border-r-transparent
                                                                border-t-zinc-900 dark:border-t-zinc-100"></div>
                                                </div>
                                            </div>
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

            {{-- MODAL FORM MEASUREMENT DETAIL --}}
            <div x-data="{
                    open: false,
                    showCamera: false,
                    capturedPhoto: null,
                    videoStream: null,
                    isSaving: false,

                    async startCamera() {
                        try {
                            const constraints = { video: { facingMode: 'environment' } };
                            this.videoStream = await navigator.mediaDevices.getUserMedia(constraints);
                            const videoElement = this.$refs.video;
                            videoElement.srcObject = this.videoStream;
                            this.showCamera = true;
                            this.capturedPhoto = null;
                        } catch (error) {
                            console.error('Error accessing camera:', error);
                            alert('Tidak dapat mengakses kamera. Pastikan Anda telah memberikan izin kamera.');
                        }
                    },

                    capturePhoto() {
                        const video = this.$refs.video;
                        const canvas = this.$refs.canvas;

                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;

                        const context = canvas.getContext('2d');
                        context.drawImage(video, 0, 0, canvas.width, canvas.height);

                        this.capturedPhoto = canvas.toDataURL('image/jpeg', 0.8);
                        this.stopCamera();
                    },

                    async savePhoto() {
                        if (this.capturedPhoto && !this.isSaving) {
                            this.isSaving = true;
                            try {
                                await @this.call('addCapturedPhoto', this.capturedPhoto);
                                this.capturedPhoto = null;
                                this.showCamera = false;
                            } catch (error) {
                                console.error('Error saving photo:', error);
                                alert('Failed to save photo: ' + error.message);
                            } finally {
                                this.isSaving = false;
                            }
                        }
                    },

                    retakePhoto() {
                        this.capturedPhoto = null;
                        this.startCamera();
                    },

                    stopCamera() {
                        if (this.videoStream) {
                            this.videoStream.getTracks().forEach(track => track.stop());
                            this.videoStream = null;
                        }
                        this.showCamera = false;
                    }
                }"
                x-show="open"
                @open-modal.window="if ($event.detail === 'detail-form-modal') { open = true; }"
                @close-modal.window="if ($event.detail === 'detail-form-modal') { open = false; stopCamera(); }"
                x-cloak>

                {{-- Backdrop --}}
                <div class="fixed inset-0 bg-zinc-900/60 backdrop-blur-sm z-40"
                    x-transition.opacity
                    @click="open = false; stopCamera();"></div>

                {{-- Modal Panel --}}
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[92vh] flex flex-col overflow-hidden border border-zinc-200 dark:border-zinc-800"
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
                                        {{ $garment->nik }} — {{ $garment->name }}
                                    </p>
                                </div>
                            </div>
                            <button type="button"
                                    @click="open = false; stopCamera()"
                                    class="w-9 h-9 rounded-lg bg-white/10 hover:bg-white/25 flex items-center justify-center text-white transition-colors">
                                <flux:icon name="x-mark" class="w-5 h-5" />
                            </button>
                        </div>

                        {{-- =================== BODY =================== --}}
                        <div class="flex-1 overflow-y-auto">
                            <form wire:submit="save" id="garment-detail-form" class="p-6 space-y-6">
                                <input type="hidden" wire:model="nik" value="{{ $garment->id }}">
                                <input type="hidden" wire:model="name" value="{{ $garment->name }}">

                                {{-- SECTION 1: MEASUREMENT (D1-D5) --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center">
                                            <flux:icon name="beaker" class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                                Point to Point Resistance
                                            </h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                Standard: ≥ 1.00E+4 Ω and &lt; 1.00E+11 Ω
                                            </p>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        @php
                                            $dItems = [
                                                ['field' => 'd1', 'sci' => 'd1_scientific', 'judge' => 'judgement_d1', 'code' => 'D1', 'label' => 'Shirt'],
                                                ['field' => 'd2', 'sci' => 'd2_scientific', 'judge' => 'judgement_d2', 'code' => 'D2', 'label' => 'Pants'],
                                                ['field' => 'd3', 'sci' => 'd3_scientific', 'judge' => 'judgement_d3', 'code' => 'D3', 'label' => 'Cap'],
                                                ['field' => 'd4', 'sci' => 'd4_scientific', 'judge' => 'judgement_d4', 'code' => 'D4', 'label' => 'Hijab'],
                                                ['field' => 'd5', 'sci' => 'd5_scientific', 'judge' => 'judgement_d5', 'code' => 'D5', 'label' => 'Smock'],
                                            ];
                                        @endphp

                                        @foreach($dItems as $item)
                                            @php
                                                $field = $item['field'];
                                                $sci = $item['sci'];
                                                $judge = $item['judge'];
                                                $judgeValue = $this->$judge;
                                            @endphp
                                            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-purple-200 dark:border-purple-800/60 p-4">
                                                <div class="flex items-start justify-between gap-2 mb-3">
                                                    <div class="flex items-start gap-3">
                                                        <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center flex-shrink-0">
                                                            <span class="text-xs font-bold text-purple-700 dark:text-purple-400">{{ $item['code'] }}</span>
                                                        </div>
                                                        <div>
                                                            <div class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">
                                                                {{ $item['label'] }} Point to Point
                                                            </div>
                                                            <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                                                Resistance measurement
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide
                                                        {{ $judgeValue == 'OK' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300 ring-1 ring-green-300 dark:ring-green-700' : ($judgeValue == 'NG' ? 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 ring-1 ring-red-300 dark:ring-red-700' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 ring-1 ring-zinc-300 dark:ring-zinc-700') }}">
                                                        @if($judgeValue == 'OK')
                                                            <flux:icon name="check-circle" class="w-3 h-3" />
                                                        @elseif($judgeValue == 'NG')
                                                            <flux:icon name="x-circle" class="w-3 h-3" />
                                                        @else
                                                            <flux:icon name="clock" class="w-3 h-3" />
                                                        @endif
                                                        {{ $judgeValue ?: 'AUTO' }}
                                                    </span>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-[11px] font-semibold mb-1 text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">
                                                            Measurement (Ω)
                                                        </label>
                                                        <input type="number" step="0.01" wire:model="{{ $field }}" wire:keyup="resetJudgements"
                                                            placeholder="Enter value in Ohm"
                                                            class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-purple-500 font-mono">
                                                        @error($field) <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                                    </div>
                                                    <div>
                                                        <label class="block text-[11px] font-semibold mb-1 text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">
                                                            Scientific
                                                        </label>
                                                        <input type="text" wire:model="{{ $sci }}" readonly
                                                            placeholder="-"
                                                            class="w-full px-3 py-2 text-sm border border-zinc-200 dark:border-zinc-700 rounded-lg bg-zinc-100 dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 font-mono">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- SECTION 2: VISUAL INSPECTION (D6.1) --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center">
                                            <flux:icon name="clipboard-document-check" class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                                D6 — Visual Inspection Checklist
                                            </h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                Tick <span class="font-semibold text-green-600">YES</span> if condition is met, <span class="font-semibold text-red-600">NO</span> if not
                                            </p>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        @php
                                            $d6Items = [
                                                ['field' => 'd6_1', 'code' => 'D-6.1', 'text' => 'Garment ESD tidak robek, berlubang, atau rusak'],
                                            ];
                                        @endphp

                                        @foreach($d6Items as $item)
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

                                {{-- SECTION 3: PHOTO VERIFICATION --}}
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                    <div class="flex items-center gap-2.5 mb-4">
                                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                                            <flux:icon name="camera" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">
                                                Photo Verification
                                            </h3>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                Take photos using device camera (max 5 photos)
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Existing Photos --}}
                                    @if(!empty($existingPhotos) && count($existingPhotos) > 0)
                                        <div class="mb-4">
                                            <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-2 uppercase tracking-wide">
                                                Existing Photos ({{ count($existingPhotos) }})
                                            </label>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                                @foreach($existingPhotos as $index => $photo)
                                                    <div class="relative border border-zinc-200 dark:border-zinc-700 rounded-xl p-2 bg-white dark:bg-zinc-900 group">
                                                        <div class="relative">
                                                            <a href="{{ Storage::url($photo) }}" target="_blank">
                                                                <img src="{{ Storage::url($photo) }}"
                                                                    alt="Verification Photo"
                                                                    class="w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-90 transition-opacity">
                                                            </a>
                                                            <button type="button"
                                                                    wire:click="removeExistingPhoto({{ $index }})"
                                                                    class="absolute top-1 right-1 w-7 h-7 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center shadow-lg transition-colors"
                                                                    title="Remove photo">
                                                                <flux:icon name="x-mark" class="w-4 h-4" />
                                                            </button>
                                                        </div>
                                                        <div class="mt-2 px-1">
                                                            <p class="text-xs text-zinc-500 dark:text-zinc-400 truncate" title="{{ basename($photo) }}">
                                                                {{ Str::limit(basename($photo), 20) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Camera Area --}}
                                    <div class="border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-xl p-4 bg-white dark:bg-zinc-900">
                                        {{-- Initial State --}}
                                        <div x-show="!showCamera && !capturedPhoto" class="text-center py-8">
                                            <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                                                <flux:icon name="camera" class="w-8 h-8 text-blue-600 dark:text-blue-400" />
                                            </div>
                                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4">Take a photo using your camera</p>
                                            <button type="button"
                                                    @click="startCamera()"
                                                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                                <flux:icon name="camera" class="w-4 h-4" />
                                                Open Camera
                                            </button>
                                        </div>

                                        {{-- Camera View --}}
                                        <div x-show="showCamera" x-cloak>
                                            <div class="relative">
                                                <video x-ref="video"
                                                    autoplay
                                                    playsinline
                                                    class="w-full rounded-lg bg-black"
                                                    style="max-height: 400px;"></video>

                                                <canvas x-ref="canvas" class="hidden"></canvas>

                                                <div class="flex gap-3 justify-center mt-4">
                                                    <button type="button"
                                                            @click="capturePhoto()"
                                                            class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                                                        <flux:icon name="camera" class="w-4 h-4" />
                                                        Take Photo
                                                    </button>
                                                    <button type="button"
                                                            @click="stopCamera()"
                                                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                                                        <flux:icon name="x-mark" class="w-4 h-4" />
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Captured Photo Preview --}}
                                        <div x-show="capturedPhoto" x-cloak>
                                            <div class="relative">
                                                <img :src="capturedPhoto"
                                                    alt="Captured photo"
                                                    class="w-full rounded-lg"
                                                    style="max-height: 400px; object-fit: contain;">

                                                <div class="flex gap-3 justify-center mt-4">
                                                    <button type="button"
                                                            @click="retakePhoto()"
                                                            class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors text-sm font-medium">
                                                        <flux:icon name="arrow-path" class="w-4 h-4" />
                                                        Retake
                                                    </button>
                                                    <button type="button"
                                                            @click="savePhoto()"
                                                            :disabled="isSaving"
                                                            class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium disabled:opacity-50">
                                                        <flux:icon name="check" class="w-4 h-4" />
                                                        <span x-text="isSaving ? 'Saving...' : 'Save Photo'"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- New Captured Photos --}}
                                    @if(!empty($capturedPhotos) && count($capturedPhotos) > 0)
                                        <div class="mt-4">
                                            <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-2 uppercase tracking-wide">
                                                New Photos ({{ count($capturedPhotos) }})
                                            </label>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                                @foreach($capturedPhotos as $index => $photo)
                                                    <div class="relative border border-zinc-200 dark:border-zinc-700 rounded-xl p-2 bg-white dark:bg-zinc-900">
                                                        <div class="relative">
                                                            <img src="{{ $photo['preview'] }}"
                                                                alt="Captured {{ $index + 1 }}"
                                                                class="w-full h-32 object-cover rounded-lg">
                                                            <button type="button"
                                                                    wire:click="removeCapturedPhoto({{ $index }})"
                                                                    class="absolute top-1 right-1 w-7 h-7 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center shadow-lg transition-colors"
                                                                    title="Remove photo">
                                                                <flux:icon name="x-mark" class="w-4 h-4" />
                                                            </button>
                                                        </div>
                                                        <div class="mt-2 px-1">
                                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                                Photo {{ $index + 1 }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @error('capturedPhotos')
                                        <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span>
                                    @enderror

                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-3 flex items-center gap-1.5">
                                        <flux:icon name="information-circle" class="w-3.5 h-3.5" />
                                        Take photos directly using your device camera. Maximum 5 photos.
                                    </p>
                                </div>

                                {{-- SECTION 4: NOTES --}}
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
                                                    class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-purple-500 resize-none"></textarea>
                                            @error('remarks') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Next Measurement Date</label>
                                            <input type="date" wire:model="next_date"
                                                class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-purple-500">
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
                                        @click="open = false; stopCamera()"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    <flux:icon name="x-mark" class="w-4 h-4" />
                                    Cancel
                                </button>
                                <button type="submit" form="garment-detail-form"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-purple-600 to-fuchsia-600 hover:from-purple-700 hover:to-fuchsia-700 text-white rounded-xl transition-all text-sm font-semibold shadow-lg shadow-purple-600/30 hover:shadow-purple-600/50">
                                    <flux:icon name="{{ $detail_id ? 'check' : 'plus' }}" class="w-4 h-4" />
                                    {{ $detail_id ? 'Update Measurement' : 'Create Measurement' }}
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- MODAL PHOTO PREVIEW -->
            <div x-data="{
                    open: false,
                    photos: [],
                    lightbox: false,
                    lightboxUrl: '',

                    openModal(photoArray) {
                        this.photos = photoArray || [];
                        this.open = true;
                    },

                    closeModal() {
                        this.open = false;
                        this.photos = [];
                        this.lightbox = false;
                        this.lightboxUrl = '';
                    },

                    openLightbox(url) {
                        this.lightboxUrl = url;
                        this.lightbox = true;
                    },

                    closeLightbox() {
                        this.lightbox = false;
                        this.lightboxUrl = '';
                    }
                }"
                x-on:open-photo-modal.window="openModal($event.detail.photos)"
                x-show="open"
                x-cloak>

                {{-- Backdrop --}}
                <div class="fixed inset-0 bg-zinc-900/70 backdrop-blur-sm z-40"
                    x-transition.opacity
                    @click="closeModal()"></div>

                {{-- Modal Panel --}}
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden border border-zinc-200 dark:border-zinc-800"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100">

                        {{-- HEADER --}}
                        <div class="bg-gradient-to-r from-blue-600 via-blue-600 to-indigo-600 px-6 py-4 flex items-center justify-between shadow-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center ring-2 ring-white/30">
                                    <flux:icon name="photo" class="w-5 h-5 text-white" />
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-white leading-tight">
                                        Verification Photos
                                    </h2>
                                    <p class="text-xs text-blue-100 mt-0.5">
                                        <span x-text="photos.length"></span> photo(s) — click to enlarge
                                    </p>
                                </div>
                            </div>
                            <button type="button"
                                    @click="closeModal()"
                                    class="w-9 h-9 rounded-lg bg-white/10 hover:bg-white/25 flex items-center justify-center text-white transition-colors">
                                <flux:icon name="x-mark" class="w-5 h-5" />
                            </button>
                        </div>

                        {{-- BODY: Photo Grid --}}
                        <div class="flex-1 overflow-y-auto p-6">
                            <template x-if="photos.length === 0">
                                <div class="flex flex-col items-center justify-center py-16 gap-3">
                                    <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                        <flux:icon name="photo" class="w-10 h-10 text-zinc-400" />
                                    </div>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">No photos available</p>
                                </div>
                            </template>

                            <template x-if="photos.length > 0">
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                    <template x-for="(photo, index) in photos" :key="index">
                                        <div class="group relative bg-zinc-50 dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden hover:border-blue-400 dark:hover:border-blue-600 transition-all cursor-pointer"
                                            @click="openLightbox('/storage/' + photo)">
                                            <div class="aspect-square overflow-hidden">
                                                <img :src="'/storage/' + photo"
                                                    :alt="'Photo ' + (index + 1)"
                                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                            </div>
                                            {{-- Overlay --}}
                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
                                                <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <div class="w-10 h-10 rounded-full bg-white/90 flex items-center justify-center shadow-lg">
                                                        <flux:icon name="magnifying-glass-plus" class="w-5 h-5 text-zinc-800" />
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Index badge --}}
                                            <div class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-black/60 backdrop-blur text-white text-[10px] font-bold">
                                                #<span x-text="index + 1"></span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>

                    </div>
                </div>

                {{-- ===== LIGHTBOX (Full-size preview) ===== --}}
                <div x-show="lightbox"
                    x-transition.opacity
                    x-cloak
                    class="fixed inset-0 z-[60] bg-black/95 flex items-center justify-center p-4"
                    @click="closeLightbox()">

                    {{-- Close button --}}
                    <button type="button"
                            @click="closeLightbox()"
                            class="absolute top-4 right-4 w-12 h-12 rounded-full bg-white/10 hover:bg-white/25 flex items-center justify-center text-white transition-colors z-10">
                        <flux:icon name="x-mark" class="w-6 h-6" />
                    </button>

                    {{-- Image --}}
                    <img :src="lightboxUrl"
                        alt="Full size"
                        class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl"
                        @click.stop>
                </div>
            </div>

            <!-- MODAL IMAGE VIEWER (untuk preview gambar besar) -->
            <div x-data="{ openImageViewer: false, imageUrl: '' }" 
                x-on:open-image-viewer.window="openImageViewer = true; imageUrl = $event.detail.image"
                x-cloak>
                
                <!-- Overlay -->
                <div x-show="openImageViewer" 
                    class="fixed inset-0 bg-black/90 z-50" 
                    @click="openImageViewer = false">
                </div>
                
                <!-- Modal Content -->
                <div x-show="openImageViewer" 
                    class="fixed inset-0 z-50 flex items-center justify-center p-4"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95">
                    
                    <div class="relative max-w-4xl max-h-[90vh]">
                        <!-- Close button -->
                        <button @click="openImageViewer = false" 
                                class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        
                        <!-- Image -->
                        <img :src="imageUrl" 
                            alt="Full size image" 
                            class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl">
                        
                        <!-- Tombol Close di bawah (opsional) -->
                        <button @click="openImageViewer = false" 
                                class="mt-4 px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-colors w-full">
                            Close
                        </button>
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