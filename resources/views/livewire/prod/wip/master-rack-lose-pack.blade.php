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
            Master Rack Lose
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <style>
        .stat-card {
            transition: all 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .rack-slot {
            transition: all 0.2s ease;
        }
        .rack-slot:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
    </style>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Master Rack Loose Pack
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage rack slots for loose pack storage
            </p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-blue-600 rounded-xl shadow-md p-4 stat-card">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-white/20 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-white/80">Total Slot</p>
                    <p class="text-xl font-bold text-white">{{ $totalStats['total'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-green-600 rounded-xl shadow-md p-4 stat-card">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-white/20 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-white/80">Tersedia</p>
                    <p class="text-xl font-bold text-white">{{ $totalStats['available'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-red-600 rounded-xl shadow-md p-4 stat-card">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-white/20 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-white/80">Digunakan</p>
                    <p class="text-xl font-bold text-white">{{ $totalStats['used'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-orange-600 rounded-xl shadow-md p-4 stat-card">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-white/20 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-white/80">Total WIP</p>
                    <p class="text-xl font-bold text-white">{{ $totalStats['totalWip'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Rack Management Section -->
    <flux:card class="p-0 overflow-hidden" x-data="{ open: false }">
        <!-- Header -->
        <div class="px-6 py-4 bg-blue-600 flex items-center justify-between cursor-pointer" 
            @click="open = !open">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-white/20 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-white">Rack Management</h2>
                    <p class="text-xs text-blue-100">Klik Untuk Atur Rack lose anda</p>
                </div>
            </div>
            <div class="text-white transition-transform duration-300" :class="{ 'rotate-180': !open }">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
        
        <!-- Content -->
        <div x-show="open" x-collapse.duration.300ms class="p-6">
            <!-- 3 Kolom Grid: Add Rack | Add Sheet & Column | Delete -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
                
                <!-- KOLOM KIRI: Add Rack Form -->
                <div class="space-y-3 p-4 border rounded-lg bg-blue-50 dark:bg-blue-900/20">
                    <h4 class="text-sm font-semibold text-blue-700 dark:text-blue-300">➕ Tambah Rack Baru</h4>
                    <input type="text" wire:model="newRackNo" placeholder="Nomor Rack"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                    <div class="grid grid-cols-2 gap-2">
                        <input type="number" wire:model="newRackSheetCount" min="1" max="20" 
                            placeholder="Jumlah Sheet"
                            class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                        <input type="number" wire:model="newRackColumnCount" min="1" max="4" 
                            placeholder="Column/Sheet"
                            class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                    </div>
                    <button wire:click="addRack" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Tambah Rack
                    </button>
                </div>

                <!-- KOLOM TENGAH: Add Sheet (atas) & Add Column (bawah) -->
                <div class="space-y-3">
                    <!-- Tombol ke halaman Add Sheet -->
                    <a href="{{ route('prod.wip.add-sheet') }}" wire:navigate
                    class="p-4 border rounded-lg bg-green-50 dark:bg-green-900/20 hover:shadow-md transition flex flex-col items-center justify-center text-center">
                        <div class="p-2 bg-green-100 dark:bg-green-800/30 rounded-lg mb-2">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h4 class="text-sm font-semibold text-green-700 dark:text-green-300">Tambah Sheet</h4>
                    </a>

                    <!-- Tombol ke halaman Add Column -->
                    <a href="{{ route('prod.wip.add-column') }}" wire:navigate
                    class="p-4 border rounded-lg bg-purple-50 dark:bg-purple-900/20 hover:shadow-md transition flex flex-col items-center justify-center text-center">
                        <div class="p-2 bg-purple-100 dark:bg-purple-800/30 rounded-lg mb-2">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </div>
                        <h4 class="text-sm font-semibold text-purple-700 dark:text-purple-300">Tambah Column</h4>
                    </a>
                </div>

                <!-- KOLOM KANAN: Hapus Slot Section -->
                <div class="p-4 border rounded-lg bg-red-50 dark:bg-red-900/20">
                    <h4 class="text-sm font-semibold text-red-700 dark:text-red-300 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus Slot / Column
                    </h4>
                    
                    <div class="space-y-3">
                        <!-- Pilih Rack -->
                        <div>
                            <label class="text-xs font-medium mb-1 block">Pilih Rack</label>
                            <select wire:model.live="selectedRackNo" class="w-full px-4 py-2 border rounded-lg">
                                <option value="">Pilih Rack</option>
                                @foreach($availableRacksForDelete as $rack)
                                    <option value="{{ $rack->no_rack }}">
                                        {{ $rack->no_rack }} ({{ $rack->available_slots }} slot tersedia)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pilih Sheet (muncul jika rack dipilih) -->
                        @if(!empty($selectedRackNo))
                        <div>
                            <label class="text-xs font-medium mb-1 block">Pilih Sheet</label>
                            <select wire:model.live="selectedSheetForDelete" class="w-full px-4 py-2 border rounded-lg">
                                <option value="">Pilih Sheet</option>
                                @php
                                    $availableSheets = $availableSlotsForDelete->groupBy('sheet_rack');
                                @endphp
                                @foreach($availableSheets as $sheetName => $slots)
                                    <option value="{{ $sheetName }}">
                                        {{ $sheetName }} ({{ $slots->count() }} column)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <!-- Pilih Column (muncul jika sheet dipilih) -->
                        @if(!empty($selectedRackNo) && !empty($selectedSheetForDelete))
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="text-xs font-medium">Pilih Column</label>
                                <div class="flex gap-2">
                                    <button type="button" wire:click="selectAllColumnsInSheet" class="text-xs text-blue-600 hover:underline">Pilih Semua</button>
                                    <button type="button" wire:click="clearSelectedColumns" class="text-xs text-red-600 hover:underline">Reset</button>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2 p-2 border rounded-lg max-h-32 overflow-y-auto bg-white dark:bg-zinc-800">
                                @php
                                    $filteredSlots = $availableSlotsForDelete->filter(function($slot) {
                                        return $slot->sheet_rack === $this->selectedSheetForDelete;
                                    });
                                @endphp
                                @foreach($filteredSlots as $slot)
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" wire:model.live="selectedColumnsForDelete" value="{{ $slot->id }}">
                                    <span class="text-sm">{{ $slot->column_rack }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Tombol Hapus -->
                        <button wire:click="deleteColumns" wire:confirm="Yakin ingin menghapus {{ count($selectedColumnsForDelete) }} column?"
                                class="w-full mt-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Hapus {{ count($selectedColumnsForDelete) }} Column
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            @if($showSuccessAlert)
            <div class="mt-4 p-3 bg-green-100 border border-green-200 rounded-lg">
                <p class="text-sm text-green-700">{{ $successMessage }}</p>
            </div>
            @endif
            
            @if($showErrorAlert)
            <div class="mt-4 p-3 bg-red-100 border border-red-200 rounded-lg">
                <p class="text-sm text-red-700">{{ $errorMessage }}</p>
            </div>
            @endif

            <!-- Filter -->
            <div class="mt-6 pt-4 border-t">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari No Rack, Sheet, atau Column..."
                            class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div class="flex gap-2">
                        <select wire:model.live="status" class="flex-1 px-4 py-2 border rounded-lg">
                            <option value="">Semua Status</option>
                            <option value="available">Tersedia</option>
                            <option value="used">Digunakan</option>
                        </select>
                        @if($search || $status)
                            <button wire:click="resetFilters" class="px-4 py-2 bg-red-600 text-white rounded-lg">Reset</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </flux:card>

        <!-- Rack Container -->
        <div class="space-y-4">
            @forelse($racks->groupBy('no_rack') as $rackName => $rackGroup)
            <div class="bg-white dark:bg-zinc-900 rounded-xl border shadow-sm overflow-hidden">
                <div class="px-6 py-3 bg-zinc-100 dark:bg-zinc-800 border-b text-center">
                    <h3 class="text-base font-semibold">{{ $rackName }}</h3>
                    <span class="text-xs text-zinc-500">{{ $rackGroup->count() }} slot</span>
                </div>
                
                <div class="p-4">
                    @php
                        $groupedBySheet = $rackGroup->groupBy('sheet_rack');
                    @endphp
                    
                    <div class="space-y-4">
                        @foreach($groupedBySheet as $sheetName => $columns)
                        <div class="border rounded-lg p-3">
                            <div class="text-sm font-medium mb-2 pb-1 border-b">{{ $sheetName }}</div>
                            
                            <div class="flex flex-row gap-2">
                                @foreach($columns as $rack)
                                <div class="flex-1 min-w-0">
                                    <button wire:click="showDetail({{ $rack->id }})" 
                                            class="w-full rack-slot p-2 rounded-lg border-2 transition-all
                                                @if($rack->isUsed())
                                                    bg-green-600 border-green-700 text-white hover:bg-green-700
                                                @else
                                                    bg-red-600 border-red-700 text-white hover:bg-red-700
                                                @endif"
                                            style="min-height: 80px;">
                                        <div class="text-center">
                                            <div class="text-xs font-semibold">{{ $rack->column_rack }}</div>
                                            @if($rack->isUsed() && $rack->detailWip)
                                                <div class="text-xs mt-1 truncate">{{ $rack->detailWip->masterWip->model ?? '-' }}</div>
                                                <div class="text-[10px]">{{ number_format($rack->detailWip->qty) }} pcs</div>
                                            @else
                                                <div class="text-xs mt-2">Available</div>
                                            @endif
                                        </div>
                                    </button>
                                </div>
                                @endforeach
                                
                                @for($i = $columns->count(); $i < 4; $i++)
                                <div class="flex-1 min-w-0 opacity-40">
                                    <div class="w-full p-2 rounded-lg border-2 border-dashed border-zinc-300 bg-zinc-50"
                                        style="min-height: 80px;">
                                        <div class="text-center text-xs text-zinc-400">Empty</div>
                                    </div>
                                </div>
                                @endfor
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12 bg-white dark:bg-zinc-900 rounded-xl border">
                <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium">Tidak ada rack ditemukan</h3>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($racks->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $racks->links() }}
        </div>
        @endif

        <!-- Modal Detail -->
        @if($showDetailModal && $selectedRack)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ open: true }" x-show="open" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black/50" @click="$wire.closeModal()"></div>
                
                <div class="relative bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-lg">
                    <div class="px-6 py-4 bg-gradient-to-r from-orange-600 to-orange-700 rounded-t-xl flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-white/20 rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Detail Slot</h3>
                                <p class="text-xs text-orange-100">{{ $selectedRack->display_name ?? $selectedRack->no_rack . ' - ' . $selectedRack->sheet_rack . ' - ' . $selectedRack->column_rack }}</p>
                            </div>
                        </div>
                        <button wire:click="closeModal" class="text-white/80 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="p-6">
                        @if($selectedRack->detailWip)
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="p-3 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Model</p>
                                        <p class="font-medium text-zinc-900 dark:text-white">
                                            {{ $selectedRack->detailWip->masterWip->model ?? '-' }}
                                        </p>
                                    </div>
                                    <div class="p-3 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Part Number</p>
                                        <p class="font-medium text-zinc-900 dark:text-white">
                                            {{ $selectedRack->detailWip->masterWip->part_number ?? '-' }}
                                        </p>
                                    </div>
                                    <div class="p-3 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">QTY</p>
                                        <p class="font-medium text-zinc-900 dark:text-white">
                                            {{ number_format($selectedRack->detailWip->qty) }}
                                        </p>
                                    </div>
                                    <div class="p-3 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Scan By</p>
                                        <p class="font-medium text-zinc-900 dark:text-white">
                                            {{ $selectedRack->detailWip->creator->name ?? '-' }}
                                        </p>
                                        <p class="text-xs text-zinc-400 mt-1">
                                            {{ $selectedRack->detailWip->created_at ? $selectedRack->detailWip->created_at->format('d/m/Y H:i:s') : '-' }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex justify-center gap-3 pt-2">
                                    <button wire:click="releaseRack({{ $selectedRack->id }})"
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center gap-2 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7L5 7M6 7v12a2 2 0 002 2h8a2 2 0 002-2V7M10 11v6M14 11v6M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2" />
                                        </svg>
                                        Release from Rack
                                    </button>

                                    @if($selectedRack->detailWip && $selectedRack->detailWip->masterWip)
                                        <a href="{{ route('prod.wip.show', $selectedRack->detailWip->masterWip->id) }}"
                                            wire:navigate
                                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 flex items-center gap-2 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            View Detail
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-center py-6">
                                <svg class="w-16 h-16 mx-auto text-zinc-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                <p class="text-zinc-500 dark:text-zinc-400">Tidak ada data WIP pada slot ini</p>
                                <p class="text-xs text-zinc-400 mt-1">Slot ini masih tersedia</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
</div>