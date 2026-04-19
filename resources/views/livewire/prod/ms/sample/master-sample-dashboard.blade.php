<div class="space-y-0 p-2" wire:poll.5s="loadDashboardData">
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Header dengan Welcome Back -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-2">
            <div class="w-full lg:w-auto">
                <div class="flex items-center gap-3">
                    <h1 class="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white">MS Dashboard</h1>
                    <flux:badge color="blue" size="sm">Master Sample Control</flux:badge>
                </div>
                <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-400 mt-1">
                    Manage and monitoring your master sample
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-xs font-medium text-zinc-700 dark:text-zinc-300">Show:</span>
            <select 
                wire:model.live="selectedArea"
                class="border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-1.5 text-sm bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            >
                <option value="all">All Productions</option>
                <option value="2">Production 01</option>
                <option value="3">Production 02</option>
            </select>
        </div>
    </div>

    <!-- Status Legend -->
    <div class="flex flex-wrap items-center justify-center gap-3 p-2 bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 my-4">
        <div class="flex items-center gap-3 flex-wrap">
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-green-500"></span>
                <span class="text-xs text-zinc-600 dark:text-zinc-400">OK</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                <span class="text-xs text-zinc-600 dark:text-zinc-400">OK Backup</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                <span class="text-xs text-zinc-600 dark:text-zinc-400">NG</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-gray-400"></span>
                <span class="text-xs text-zinc-600 dark:text-zinc-400">Blank</span>
            </div>
        </div>

        <div class="w-px h-4 bg-zinc-300 dark:bg-zinc-600"></div>

        <div class="flex items-center gap-3">
            <div class="flex items-center gap-1.5">
                <div class="relative w-5 h-5 rounded-full bg-sky-500 flex items-center justify-center">
                    <span class="text-[7px] font-bold text-white">L</span>
                </div>
                <span class="text-xs text-zinc-600 dark:text-zinc-400">In Use</span>
            </div>
            <div class="flex items-center gap-1.5">
                <div class="relative w-5 h-5 rounded-full bg-rose-500 flex items-center justify-center">
                    <span class="text-[7px] font-bold text-white">L</span>
                </div>
                <span class="text-xs text-zinc-600 dark:text-zinc-400">Not Use</span>
            </div>
        </div>
    </div>

    <!-- Dashboard Content - Grouped by AREA -->
    @forelse($filteredAreas as $area)
        <div class="space-y-3">
            <!-- Area Header -->
            <div class="flex items-center justify-center">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold text-sm px-6 py-2 rounded-lg shadow-md">
                    {{ strtoupper($area['area_name']) }}
                </div>
            </div>

            <!-- Locations Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
                @foreach($area['locations'] as $location)
                    <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm p-3 hover:shadow-md transition-all duration-200">
                        <!-- Location Name -->
                        <div class="bg-yellow-100 dark:bg-yellow-900/30 text-center font-semibold text-xs py-1.5 rounded mb-3 text-zinc-800 dark:text-zinc-200">
                            {{ $location['location_name'] }}
                        </div>

                        <!-- Lines Grid -->
                        <div class="grid grid-cols-3 gap-2">
                            @foreach($location['lines'] as $line)
                                @php
                                    $hasSample = $line['has_sample'];
                                    $circleClass = $hasSample 
                                        ? 'bg-blue-600 border-blue-600 text-white' 
                                        : 'bg-rose-600 border-rose-600 text-white';
                                    $types = $line['types'] ?? [];
                                    $areaId = str_contains($area['area_name'], '01') ? 2 : 3;
                                @endphp
                                
                                <div 
                                    wire:click="openLineDetail({{ $line['line_id'] }}, {{ $areaId }})"
                                    class="relative flex flex-col items-center cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition p-1.5 rounded-lg group"
                                >
                                    @if(count($types) > 0)
                                        <div class="absolute -top-1.5 left-0 right-0 flex justify-center gap-0.5 z-10">
                                            @foreach($types as $type)
                                                <div class="w-2 h-2 rounded-full {{ $this->getSampleBadgeClass($type) }} border border-white shadow-sm" title="{{ $this->getSampleTitle($type) }}"></div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="relative w-8 h-8 rounded-full border-2 {{ $circleClass }} flex items-center justify-center text-xs font-bold select-none transition-all duration-200 group-hover:scale-105 {{ count($types) > 0 ? 'mt-1' : '' }}">
                                        {{ $line['line_number'] }}
                                    </div>

                                    <div class="mt-1 text-[9px] font-semibold text-zinc-500 dark:text-zinc-400">
                                        LINE
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if(!$loop->last)
            <div class="border-t border-dashed border-zinc-300 dark:border-zinc-700 my-4"></div>
        @endif
    @empty
        <flux:card class="p-8 text-center">
            <div class="flex flex-col items-center gap-2">
                <div class="w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                    <svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-md font-semibold text-zinc-800 dark:text-white mb-0.5">
                        No Data Available
                    </h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                        No samples are currently in use
                    </p>
                </div>
            </div>
        </flux:card>
    @endforelse

    <!-- MODAL LINE DETAIL -->
    <div x-data="{ open: false }" 
        x-show="open" 
        @open-line-modal.window="open = true"
        @close-line-modal.window="open = false"
        x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-lg max-h-[85vh] overflow-y-auto">
                
                @if($lineDetail)
                    <div class="space-y-3">
                        <div class="sticky top-0 bg-white dark:bg-zinc-900 px-5 py-3 border-b border-zinc-200 dark:border-zinc-700 flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-md font-bold">{{ $lineDetail['area_name'] }} - Line Info</h3>
                                    <p class="text-xs text-zinc-500">Line {{ $lineDetail['line_number'] }} - {{ $lineDetail['location_name'] }}</p>
                                </div>
                            </div>
                            <button @click="open = false; $wire.closeLineModal()" class="text-zinc-500 hover:text-zinc-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="p-5 space-y-4">
                            <!-- Sample Types Badges -->
                            @if(count($lineDetail['sample_types']) > 0)
                                <div class="flex items-center justify-center gap-2 flex-wrap">
                                    @foreach($lineDetail['sample_types'] as $type)
                                        <div class="flex flex-col items-center">
                                            <div class="w-4 h-4 rounded-full {{ $this->getSampleBadgeClass($type) }} mb-0.5"></div>
                                            <span class="text-[10px] text-zinc-600 dark:text-zinc-400">{{ $this->getSampleTitle($type) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Info Model -->
                            <div class="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-md border border-zinc-200 dark:border-zinc-700 space-y-1.5">
                                <div class="flex justify-between text-xs">
                                    <span class="font-semibold text-zinc-600 dark:text-zinc-400">Model:</span>
                                    <span class="text-zinc-800 dark:text-zinc-200 font-mono">{{ $lineDetail['model_name'] }}</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="font-semibold text-zinc-600 dark:text-zinc-400">Expire Date:</span>
                                    <span class="text-zinc-800 dark:text-zinc-200">{{ $lineDetail['expired_date'] }}</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="font-semibold text-zinc-600 dark:text-zinc-400">Line Number:</span>
                                    <span class="text-zinc-800 dark:text-zinc-200 font-semibold">{{ $lineDetail['line_number'] }}</span>
                                </div>
                            </div>

                            <!-- Loaners Table (semua yang sedang in use) -->
                            <div class="border border-zinc-200 dark:border-zinc-700 rounded-md overflow-hidden">
                                <div class="bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-semibold text-xs px-3 py-1.5 border-b border-zinc-200 dark:border-zinc-700">
                                    Current Loaners ({{ $lineDetail['total_loaners'] }})
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    <table class="w-full text-xs">
                                        <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-600 dark:text-zinc-400 sticky top-0">
                                            <tr>
                                                <th class="py-1.5 px-2 border-b text-left">NIK</th>
                                                <th class="py-1.5 px-2 border-b text-left">Employee Name</th>
                                                <th class="py-1.5 px-2 border-b text-left">Loan Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($lineDetail['loaners'] as $loaner)
                                                <tr>
                                                    <td class="py-1.5 px-2 border-b">{{ $loaner['nik'] }}</td>
                                                    <td class="py-1.5 px-2 border-b">{{ $loaner['employee_name'] }}</td>
                                                    <td class="py-1.5 px-2 border-b">{{ $loaner['loan_date'] }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center py-2 text-zinc-400">No data available</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-end gap-2 pt-2">
                                @if($lineDetail['master_sample_id'])
                                    <a href="{{ route('prod.ms.master-sample.show', $lineDetail['master_sample_id']) }}" 
                                    target="_blank"
                                    class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700 transition-colors">
                                        View Master Sample
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                @if($loading)
                    <div class="p-8 text-center">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                        <p class="mt-2 text-xs text-zinc-500">Loading...</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <flux:toast />

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>