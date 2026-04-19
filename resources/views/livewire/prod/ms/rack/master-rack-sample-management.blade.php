<div class="space-y-1 p-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            PROD
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            MS
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Master Rack Sample
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Master Rack Sample
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage rack samples for MS Monitoring
            </p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('prod.ms.master-rack.create') }}">
                <flux:button variant="primary" icon="plus" class="bg-blue-600 hover:bg-blue-700">
                    Add New Rack
                </flux:button>
            </a>
        </div>
    </div>

    <!-- Tabs Navigation untuk Rack Type -->
    <div class="mt-6 border-b border-zinc-200 dark:border-zinc-700">
        <div class="relative">
            <div class="overflow-x-auto scrollbar-hide" style="scrollbar-width: none; -ms-overflow-style: none;">
                <div class="flex flex-nowrap gap-1 justify-start min-w-max">
                    
                    <!-- Loop Rack Types -->
                    @foreach($rackTypes as $rackType)
                        @php
                            $isActive = $activeRackType === $rackType->type_rack;
                        @endphp
                        
                        <button 
                            wire:click="$set('activeRackType', '{{ $rackType->type_rack }}')"
                            class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap 
                            {{ $isActive ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                        >
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            Rack {{ $rackType->type_rack }}
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full 
                                {{ $isActive ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                                {{ $rackType->total_columns }} cols
                            </span>
                            @if($isActive)
                                <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600 dark:bg-blue-400 rounded-t-full"></div>
                            @endif
                        </button>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    <!-- Status Legend -->
    <div class="flex flex-wrap gap-3 p-4 bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700">
        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Status:</span>
        
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-green-500"></span>
            <span class="text-xs text-zinc-600 dark:text-zinc-400">Available</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-red-500"></span>
            <span class="text-xs text-zinc-600 dark:text-zinc-400">Filled</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
            <span class="text-xs text-zinc-600 dark:text-zinc-400">In Use</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-gray-500"></span>
            <span class="text-xs text-zinc-600 dark:text-zinc-400">Expired</span>
        </div>
    </div>

    <!-- Rack Visualization Grid -->
    @if($activeRackType && $rackData->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach($rackData as $column => $sheets)
                @php
                    $totalSheets = $sheets->count();
                    $availableCount = $sheets->filter(fn($s) => $s->samples->isEmpty())->count();
                    $filledCount = $totalSheets - $availableCount;
                    $fillPercentage = $totalSheets > 0 ? ($filledCount / $totalSheets) * 100 : 0;
                @endphp
                
                <flux:card class="overflow-hidden p-0">
                    <div class="p-4 bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-zinc-800 dark:text-white">
                                    Column {{ $column }}
                                </h3>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $totalSheets }} sheets • {{ $availableCount }} available
                                </p>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="w-full h-1.5 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-500 rounded-full transition-all" style="width: {{ $fillPercentage }}%"></div>
                            </div>
                            <p class="text-xs text-right mt-1 text-zinc-500">{{ round($fillPercentage) }}% used</p>
                        </div>
                    </div>

                    <div class="p-3 max-h-[400px] overflow-y-auto space-y-2">
                        @foreach($sheets as $sheet)
                            @php
                                $availability = $this->getSheetAvailability($sheet);
                                $statusColors = [
                                    'available' => 'border-green-200 bg-green-50 dark:bg-green-900/20',
                                    'filled' => 'border-red-200 bg-red-50 dark:bg-red-900/20',
                                    'in_use' => 'border-yellow-200 bg-yellow-50 dark:bg-yellow-900/20',
                                    'expired' => 'border-gray-200 bg-gray-50 dark:bg-gray-900/20',
                                ];
                                $badgeColors = [
                                    'available' => 'success',
                                    'filled' => 'danger',
                                    'in_use' => 'warning',
                                    'expired' => 'secondary',
                                ];
                            @endphp
                            
                            <div 
                                wire:click="openSheetDetail({{ $sheet->id }}, '{{ $column }}')"
                                class="border rounded-lg p-3 cursor-pointer transition-all hover:shadow-md {{ $statusColors[$availability['status']] ?? 'border-zinc-200' }}"
                            >
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-white dark:bg-zinc-800 flex items-center justify-center font-bold text-zinc-700 dark:text-zinc-300 shadow-sm">
                                            {{ $sheet->sheet_rack }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-sm text-zinc-800 dark:text-white">
                                                Sheet {{ $sheet->sheet_rack }}
                                            </p>
                                            @if($availability['sample_count'] > 0)
                                                <p class="text-xs text-zinc-500">
                                                    {{ $availability['sample_count'] }} sample(s)
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <flux:badge size="sm" color="{{ $badgeColors[$availability['status']] ?? 'gray' }}">
                                        {{ $availability['label'] }}
                                    </flux:badge>
                                </div>

                                @if(($availability['sample_count'] ?? 0) > 0 && isset($availability['samples']))
                                    <div class="mt-2 pt-2 border-t border-zinc-200 dark:border-zinc-700">
                                        @foreach(array_slice($availability['samples'], 0, 2) as $sample)
                                            <div class="flex items-center justify-between text-xs py-1">
                                                <div class="flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full" 
                                                        style="background-color: {{ 
                                                            ($sample['status'] ?? 'filled') === 'in_use' ? '#eab308' : 
                                                            (($sample['status'] ?? 'filled') === 'expired' ? '#6b7280' : '#ef4444')
                                                        }};"></span>
                                                    <span class="text-zinc-600 dark:text-zinc-400">
                                                        {{ Str::limit($sample['model_name'] ?? 'Unknown', 20) }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if(count($availability['samples']) > 2)
                                            <p class="text-xs text-center text-zinc-400 mt-1">
                                                +{{ count($availability['samples']) - 2 }} more
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </flux:card>
            @endforeach
        </div>
    @elseif($activeRackType && $rackData->isEmpty())
        <flux:card class="p-12 text-center">
            <div class="flex flex-col items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                    <svg class="w-8 h-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-1">
                        No Racks Available
                    </h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        Belum ada data rack untuk tipe {{ $activeRackType }}
                    </p>
                </div>
            </div>
        </flux:card>
    @else
        <flux:card class="p-12 text-center">
            <div class="flex flex-col items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                    <svg class="w-8 h-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-1">
                        No Racks Available
                    </h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        Belum ada rack sample yang ditambahkan
                    </p>
                </div>
            </div>
        </flux:card>
    @endif

    <!-- MODAL SHEET DETAIL -->
    <div x-data="{ open: false }" 
        x-show="open" 
        @open-sheet-modal.window="open = true"
        x-cloak>

        <!-- Overlay -->
        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <!-- Modal Container -->
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                
                @if($selectedSheet)
                    <div class="space-y-6">
                        <!-- Header -->
                        <div class="sticky top-0 bg-white dark:bg-zinc-900 px-6 pt-6 pb-4 border-b border-zinc-200 dark:border-zinc-700">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                    </svg>
                                </div>
                                <span class="text-lg font-bold">Sheet Details</span>
                                <button @click="open = false" class="ml-auto text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="px-6 pb-6 space-y-6">
                            <!-- Header Info -->
                            <div class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-800/50 dark:to-gray-900/50 rounded-xl p-5 border border-gray-100 dark:border-gray-700">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                                Sheet {{ $selectedSheet['sheet']->sheet_rack }}
                                            </h3>
                                            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded-md text-xs font-medium text-gray-600 dark:text-gray-400">
                                                Col {{ $selectedSheet['column'] }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                            <span>Rack Type {{ $selectedSheet['sheet']->type_rack }}</span>
                                            <span class="w-1 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></span>
                                            <span>{{ $selectedSheet['availability']['sample_count'] ?? 0 }} Total Samples</span>
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium"
                                        style="background-color: {{ $selectedSheet['availability']['bg_color'] ?? '#f3f4f6' }}; color: {{ $selectedSheet['availability']['text_color'] ?? '#374151' }}">
                                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $selectedSheet['availability']['dot_color'] ?? '#9ca3af' }}"></span>
                                        {{ $selectedSheet['availability']['label'] ?? 'Unknown' }}
                                    </span>
                                </div>
                                
                                <!-- Quick Stats -->
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="bg-white dark:bg-gray-800 rounded-lg p-3 text-center border border-gray-100 dark:border-gray-700">
                                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $selectedSheet['availability']['sample_count'] ?? 0 }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total Samples</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-800 rounded-lg p-3 text-center border border-gray-100 dark:border-gray-700">
                                        <p class="text-2xl font-bold text-amber-600">
                                            {{ $selectedSheet['availability']['samples'] ? collect($selectedSheet['availability']['samples'])->where('status', 'in_use')->count() : 0 }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">In Use</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-800 rounded-lg p-3 text-center border border-gray-100 dark:border-gray-700">
                                        <p class="text-2xl font-bold text-gray-500">
                                            {{ $selectedSheet['availability']['samples'] ? collect($selectedSheet['availability']['samples'])->where('status', 'expired')->count() : 0 }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Expired</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Sample List -->
                            @if(($selectedSheet['availability']['sample_count'] ?? 0) > 0 && isset($selectedSheet['availability']['samples']))
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        Sample List ({{ count($selectedSheet['availability']['samples']) }})
                                    </h4>
                                    
                                    <div class="space-y-2 max-h-96 overflow-y-auto pr-2">
                                        @foreach($selectedSheet['availability']['samples'] as $sample)
                                            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 hover:shadow-md transition-all">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <div class="flex items-center gap-2 mb-2">
                                                            <span class="w-2 h-2 rounded-full" 
                                                                style="background-color: {{ 
                                                                    ($sample['status'] ?? 'filled') === 'in_use' ? '#f59e0b' : 
                                                                    (($sample['status'] ?? 'filled') === 'expired' ? '#6b7280' : '#ef4444')
                                                                }};"></span>
                                                            <span class="font-medium text-gray-900 dark:text-white">
                                                                {{ $sample['model_name'] ?? 'Unknown Sample' }}
                                                            </span>
                                                        </div>
                                                        
                                                        <div class="grid grid-cols-2 gap-2 text-xs">
                                                            <div class="flex items-center gap-1">
                                                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                                </svg>
                                                                <span class="text-gray-600 dark:text-gray-400">{{ $sample['customer'] ?? '-' }}</span>
                                                            </div>
                                                            <div class="flex items-center gap-1">
                                                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                                                </svg>
                                                                <span class="text-gray-600 dark:text-gray-400">{{ $sample['name_or_mc'] ?? '-' }}</span>
                                                            </div>
                                                            @if(isset($sample['expired_date']))
                                                                <div class="flex items-center gap-1">
                                                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                                    </svg>
                                                                    <span class="{{ $sample['status'] === 'expired' ? 'text-red-600 font-semibold' : 'text-gray-600 dark:text-gray-400' }}">
                                                                        Exp: {{ \Carbon\Carbon::parse($sample['expired_date'])->format('d M Y') }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    @if(isset($sample['id']))
                                                        <a href="{{ route('prod.ms.master-sample.show', $sample['id']) }}" 
                                                        target="_blank"
                                                        class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors"
                                                        title="View Sample">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-12 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                                    <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-400 font-medium">No samples in this sheet</p>
                                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">This sheet is available for new samples</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Notifikasi -->
    <flux:toast />
</div>