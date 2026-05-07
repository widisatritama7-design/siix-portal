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
        <flux:breadcrumbs.item href="{{ route('prod.rack-lose') }}" wire:navigate separator="slash">
            Master Rack Lose
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Add Column
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">Tambah Column ke Sheet</h1>
            <p class="text-sm text-zinc-500">Tambahkan column baru pada sheet yang sudah ada</p>
        </div>
        <a href="{{ route('prod.rack-lose') }}" wire:navigate 
           class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md p-6 border-t-4 border-purple-500">
        <div class="flex items-center gap-3 mb-6">
            <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-zinc-800 dark:text-white">Form Tambah Column</h2>
        </div>
        
        <div class="space-y-4">
            <div>
                <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1 block">
                    Pilih Rack <span class="text-red-500">*</span>
                </label>
                <select wire:model.live="selectedRack" 
                        class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-purple-500">
                    <option value="">-- Pilih Rack --</option>
                    @foreach($availableRacks as $rack)
                        <option value="{{ $rack['no_rack'] }}">{{ $rack['no_rack'] }}</option>
                    @endforeach
                </select>
                @error('selectedRack') 
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            @if($selectedRack)
            <div>
                <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1 block">
                    Pilih Sheet <span class="text-red-500">*</span>
                </label>
                <select wire:model.live="selectedSheet" 
                        class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-purple-500">
                    <option value="">-- Pilih Sheet --</option>
                    @foreach($availableSheets as $sheet)
                        <option value="{{ $sheet['sheet_rack'] }}">{{ $sheet['sheet_rack'] }}</option>
                    @endforeach
                </select>
                @error('selectedSheet') 
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            @endif
            
            @if($selectedSheet)
            <div>
                <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1 block">
                    Nama Column Baru <span class="text-red-500">*</span>
                </label>
                <input type="text" wire:model="newColumnName" 
                    placeholder="Contoh: COLUMN 5, COLUMN A, dll"
                    class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-purple-500"
                    wire:keydown.enter="addColumn">
                @error('newColumnName') 
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            @endif
            
            <button wire:click="addColumn" 
                    wire:loading.attr="disabled"
                    wire:target="addColumn"
                    class="w-full mt-4 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 disabled:opacity-50 disabled:cursor-not-allowed transition flex items-center justify-center gap-2">
                <svg wire:loading.remove wire:target="addColumn" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <svg wire:loading wire:target="addColumn" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="addColumn">Tambah Column</span>
                <span wire:loading wire:target="addColumn">Memproses...</span>
            </button>
        </div>
    </div>
    
    <!-- Alert Success -->
    @if($showSuccessAlert)
    <div class="fixed bottom-4 right-4 z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition.duration.300ms>
        <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ $successMessage }}
        </div>
    </div>
    @endif
    
    <!-- Alert Error -->
    @if($showErrorAlert)
    <div class="fixed bottom-4 right-4 z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition.duration.300ms>
        <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            {{ $errorMessage }}
        </div>
    </div>
    @endif
</div>