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
            Add Sheet
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">Tambah Sheet ke Rack</h1>
            <p class="text-sm text-zinc-500">Tambahkan sheet baru pada rack yang sudah ada</p>
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
    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md p-6 border-t-4 border-green-500">
        <div class="flex items-center gap-3 mb-6">
            <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-zinc-800 dark:text-white">Form Tambah Sheet</h2>
        </div>
        
        <div class="space-y-4">
            <div>
                <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1 block">
                    Pilih Rack <span class="text-red-500">*</span>
                </label>
                <select wire:model="selectedRack" 
                        class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-green-500">
                    <option value="">-- Pilih Rack --</option>
                    @foreach($availableRacks as $rack)
                        <option value="{{ $rack->no_rack }}">{{ $rack->no_rack }}</option>
                    @endforeach
                </select>
                @error('selectedRack') 
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1 block">
                    Nama Sheet Baru <span class="text-red-500">*</span>
                </label>
                <input type="text" wire:model="newSheetName" 
                    placeholder="Contoh: SHEET 6, SHEET A, dll"
                    class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-green-500">
                @error('newSheetName') 
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <button wire:click="addSheet" 
                    @if(!$selectedRack || !$newSheetName) disabled @endif
                    class="w-full mt-4 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Sheet
            </button>
        </div>
    </div>
    
    <!-- Info Card -->
    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <p class="text-sm text-blue-700 dark:text-blue-300 font-medium">Informasi</p>
                <p class="text-xs text-blue-600 dark:text-blue-400">
                    Sheet baru akan otomatis memiliki jumlah column yang sama dengan sheet yang sudah ada di rack tersebut.
                    Jika rack masih kosong, akan dibuat dengan 4 column secara default.
                </p>
            </div>
        </div>
    </div>
    
    <!-- Alert Success -->
    @if($showSuccessAlert)
    <div class="fixed bottom-4 right-4 z-50 animate-fade-in">
        <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ $successMessage }}
        </div>
    </div>
    <script>setTimeout(() => { @this.set('showSuccessAlert', false); }, 3000);</script>
    @endif
    
    <!-- Alert Error -->
    @if($showErrorAlert)
    <div class="fixed bottom-4 right-4 z-50 animate-fade-in">
        <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            {{ $errorMessage }}
        </div>
    </div>
    <script>setTimeout(() => { @this.set('showErrorAlert', false); }, 3000);</script>
    @endif
</div>

<style>
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>