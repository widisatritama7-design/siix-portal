{{-- resources/views/livewire/prod/wip/history-wip-transaction.blade.php --}}
<div class="p-1 space-y-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            PROD
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            WIP
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Report
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <style>
        .summary-card-ok {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            border-radius: 20px;
            padding: 1.25rem;
        }
        .summary-card-ng {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            border-radius: 20px;
            padding: 1.25rem;
        }
        .summary-card-acm {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border-radius: 20px;
            padding: 1.25rem;
        }
        .summary-card-balance {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
            border-radius: 20px;
            padding: 1.25rem;
        }
        .table-container {
            overflow-x: auto;
            border-radius: 12px;
        }
        .data-table {
            min-width: 1400px;
        }
        .badge-finished {
            background: #059669;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-progress {
            background: #f97316;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>

    <!-- Loading Overlay -->
    @if($isLoading)
        <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl p-6">
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                    <p class="mt-4 text-gray-700 dark:text-gray-300">Sedang memuat data...</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">
                History Transaksi WIP
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">
                Report semua transaksi WIP berdasarkan model dan PrdOrd
            </p>
        </div>
        <div class="flex gap-2">
            @if($showResults && count($data) > 0)
                <button wire:click="exportToXlsx" 
                        wire:loading.attr="disabled"
                        class="flex items-center gap-1.5 px-3 py-1.5 text-xs bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    {{ $isExporting ? 'Memproses...' : 'Export Excel' }}
                </button>
                
                <flux:button wire:click="resetFilter" icon="arrow-path" variant="outline" size="sm">
                    Reset Filter
                </flux:button>
            @endif
        </div>
    </div>

    <!-- Filter Card -->
    <flux:card class="p-0 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-white/20 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-white">Filter Data Transaksi</h2>
                    <p class="text-xs text-blue-100">Pilih kriteria untuk menampilkan data</p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- ================= MODEL ================= -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                            Pilih Model <span class="text-red-500">*</span>
                        </label>

                        @if(count($selectedModels) > 0)
                            <div class="flex gap-2">
                                <button wire:click="selectAllModels" class="text-xs text-blue-600 hover:text-blue-700 transition">Pilih Semua</button>
                                <button wire:click="deselectAllModels" class="text-xs text-red-600 hover:text-red-700 transition">Clear Semua</button>
                            </div>
                        @else
                            <button wire:click="selectAllModels" class="text-xs text-blue-600 hover:text-blue-700 transition">Pilih Semua</button>
                        @endif
                    </div>

                    <div 
                        x-data="{
                            open: false, 
                            top: 0, 
                            left: 0, 
                            width: 0,
                            toggle() {
                                this.open = !this.open
                                if(this.open) {
                                    const rect = this.$refs.btn.getBoundingClientRect()
                                    this.top = rect.bottom + window.scrollY
                                    this.left = rect.left + window.scrollX
                                    this.width = rect.width
                                }
                            }
                        }"
                        class="relative"
                    >
                        <!-- BUTTON -->
                        <button type="button"
                            x-ref="btn"
                            @click="toggle"
                            class="w-full px-4 py-2 text-left border rounded-lg bg-white dark:bg-zinc-800 dark:border-zinc-700 flex items-center justify-between hover:border-blue-400 transition">
                            <span>
                                @if(count($selectedModels) > 0)
                                    <span class="font-medium text-blue-600">{{ count($selectedModels) }}</span> 
                                    <span class="text-zinc-600 dark:text-zinc-400">model terpilih</span>
                                @else
                                    <span class="text-zinc-400">Pilih model...</span>
                                @endif
                            </span>
                            <!-- Icon Arrow Down -->
                            <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- DROPDOWN -->
                        <div x-show="open"
                            @click.away="open = false"
                            x-cloak
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="fixed z-[9999] bg-white dark:bg-zinc-800 border dark:border-zinc-700 rounded-lg shadow-2xl overflow-hidden"
                            :style="`top:${top}px; left:${left}px; width:${width}px;`">

                            <!-- SEARCH -->
                            <div class="p-2 border-b dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800">
                                <input type="text"
                                    wire:model.live.debounce.300ms="searchModel"
                                    placeholder="Cari model..."
                                    class="w-full px-3 py-1.5 text-sm border rounded-lg dark:bg-zinc-700 dark:border-zinc-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- LIST -->
                            <div class="max-h-60 overflow-y-auto">
                                @forelse($filteredModels as $model)
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-100 dark:hover:bg-zinc-700 cursor-pointer transition-colors">
                                        <input type="checkbox"
                                            wire:change="toggleModel('{{ $model['id'] }}')"
                                            @checked(in_array($model['id'], $selectedModels))
                                            class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $model['name'] }}</span>
                                    </label>
                                @empty
                                    <div class="p-4 text-center text-sm text-gray-500">Tidak ada model ditemukan</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= PRDORD ================= -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                            Pilih PrdOrd <span class="text-red-500">*</span>
                        </label>

                        @if(!empty($selectedModels) && count($selectedPrdOrds) > 0)
                            <div class="flex gap-2">
                                <button wire:click="selectAllPrdOrds" class="text-xs text-blue-600 hover:text-blue-700 transition">Pilih Semua</button>
                                <button wire:click="deselectAllPrdOrds" class="text-xs text-red-600 hover:text-red-700 transition">Clear Semua</button>
                            </div>
                        @elseif(!empty($selectedModels))
                            <button wire:click="selectAllPrdOrds" class="text-xs text-blue-600 hover:text-blue-700 transition">Pilih Semua</button>
                        @endif
                    </div>

                    @if(empty($selectedModels))
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-3 text-center text-sm text-blue-700 dark:text-blue-400 rounded-lg border border-blue-200 dark:border-blue-800">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pilih model terlebih dahulu
                        </div>

                    @elseif(empty($availablePrdOrds))
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 p-3 text-center text-sm text-yellow-700 dark:text-yellow-400 rounded-lg border border-yellow-200 dark:border-yellow-800">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Tidak ada PrdOrd tersedia
                        </div>

                    @else
                        <div 
                            x-data="{
                                open: false, 
                                top: 0, 
                                left: 0, 
                                width: 0,
                                toggle() {
                                    this.open = !this.open
                                    if(this.open) {
                                        const rect = this.$refs.btn.getBoundingClientRect()
                                        this.top = rect.bottom + window.scrollY
                                        this.left = rect.left + window.scrollX
                                        this.width = rect.width
                                    }
                                }
                            }"
                        >
                            <!-- BUTTON -->
                            <button type="button"
                                x-ref="btn"
                                @click="toggle"
                                class="w-full px-4 py-2 text-left border rounded-lg bg-white dark:bg-zinc-800 dark:border-zinc-700 flex items-center justify-between hover:border-blue-400 transition">
                                <span>
                                    @if(count($selectedPrdOrds) > 0)
                                        <span class="font-medium text-blue-600">{{ count($selectedPrdOrds) }}</span>
                                        <span class="text-zinc-600 dark:text-zinc-400">PrdOrd terpilih</span>
                                    @else
                                        <span class="text-zinc-400">Pilih PrdOrd...</span>
                                    @endif
                                </span>
                                <!-- Icon Arrow Down -->
                                <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- DROPDOWN -->
                            <div x-show="open"
                                @click.away="open = false"
                                x-cloak
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-95"
                                class="fixed z-[9999] bg-white dark:bg-zinc-800 border dark:border-zinc-700 rounded-lg shadow-2xl overflow-hidden"
                                :style="`top:${top}px; left:${left}px; width:${width}px;`">

                                <!-- SEARCH -->
                                <div class="p-2 border-b dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800">
                                    <input type="text"
                                        wire:model.live.debounce.300ms="searchPrdOrd"
                                        placeholder="Cari PrdOrd..."
                                        class="w-full px-3 py-1.5 text-sm border rounded-lg dark:bg-zinc-700 dark:border-zinc-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <!-- LIST -->
                                <div class="max-h-60 overflow-y-auto">
                                    @forelse($filteredPrdOrds as $prdOrd)
                                        <label class="flex items-center px-3 py-2 hover:bg-gray-100 dark:hover:bg-zinc-700 cursor-pointer transition-colors">
                                            <input type="checkbox"
                                                wire:click="togglePrdOrd('{{ $prdOrd['name'] }}')"
                                                @checked(in_array($prdOrd['name'], $selectedPrdOrds))
                                                class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                                            <span class="text-sm font-mono text-gray-700 dark:text-gray-300">{{ $prdOrd['name'] }}</span>
                                        </label>
                                    @empty
                                        <div class="p-4 text-center text-sm text-gray-500">Tidak ada PrdOrd ditemukan</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button wire:click="filter" 
                        wire:loading.attr="disabled"
                        @if(empty($selectedModels) || empty($selectedPrdOrds)) disabled @endif
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Tampilkan Data
                </button>

                @if($showResults)
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                        {{ count($data) }} data ditemukan
                    </span>
                @endif
            </div>
        </div>
    </flux:card>
    
    <!-- Results Section -->
    @if($showResults)
        <div class="space-y-4">
            <!-- Data Table -->
            <flux:card class="p-0 overflow-hidden">
                <div class="px-6 py-3 bg-gradient-to-r from-zinc-50 to-white dark:from-zinc-800/50 dark:to-zinc-900 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Detail Transaksi</h3>
                        <span class="px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-full text-xs font-medium">
                            {{ count($data) }} baris
                        </span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-xs text-zinc-400 dark:text-zinc-500">
                            {{ now()->format('d/m/Y H:i:s') }}
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600" style="overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch;">
                    <table class="min-w-[1600px] w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/80 border-b border-zinc-200 dark:border-zinc-700">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider w-12">No Box</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">Model</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">Part Number</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider min-w-[130px]">PrdOrd</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider w-20">QTY OK</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider w-20">QTY NG</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider w-16">ACM</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider w-20">Balance</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider w-28">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider min-w-[200px]">No HU</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Remarks</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider w-36">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">PIC</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($data as $index => $item)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors duration-150">
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap text-center">
                                    {{ $data->count() - $loop->index }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $item->masterWip->model ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $item->masterWip->part_number ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <code class="text-xs font-mono bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded-md text-zinc-700 dark:text-zinc-300">
                                        {{ $item->masterWip->dj ?? '-' }}
                                    </code>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        {{ number_format($item->qty) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        {{ number_format($item->ng_count) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="font-semibold text-zinc-800 dark:text-zinc-200">{{ number_format($item->acm) }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $item->balance > 0 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' }}">
                                        {{ number_format($item->balance) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @if($item->status === 'Finished')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Finished
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                            <svg class="w-3 h-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            In Progress
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="font-mono text-xs text-zinc-600 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded">
                                        {{ $item->no_hu ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ $item->remarks ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ $item->created_at?->format('d/m/Y H:i:s') ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center shadow-sm">
                                            <span class="text-xs font-bold text-white">
                                                {{ substr($item->creator?->name ?? 'U', 0, 1) }}
                                            </span>
                                        </div>
                                        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $item->creator?->name ?? '-' }}</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </flux:card>
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <div class="mx-auto w-20 h-20 bg-blue-50 dark:bg-blue-900/20 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-2">Belum Ada Data</h3>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Pilih model dan PrdOrd, lalu klik "Tampilkan Data"</p>
        </div>
    @endif

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
        <div class="text-white px-6 py-3 rounded-lg shadow-lg">
            <span x-text="message"></span>
        </div>
    </div>
</div>