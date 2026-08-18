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

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">Tambah Sheet ke Rack</h1>
            <p class="text-sm text-zinc-500">Tambahkan sheet baru pada rack yang sudah ada</p>
        </div>
        <a href="{{ route('prod.rack-lose') }}" wire:navigate 
           class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 flex items-center gap-2 transition whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Global Validation Errors -->
    @if ($errors->any())
    <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-lg p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Ada kesalahan pada form:</h3>
                <ul class="mt-1 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

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
            <!-- Rack Selection -->
            <div>
                <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1 block">
                    Pilih Rack <span class="text-red-500">*</span>
                </label>
                <select wire:model.live="selectedRack" 
                        class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-green-500 transition @error('selectedRack') border-red-500 @enderror"
                        {{ $availableRacks->isEmpty() ? 'disabled' : '' }}>
                    <option value="">-- Pilih Rack --</option>
                    @foreach($availableRacks as $rack)
                        <option value="{{ $rack->no_rack }}">{{ $rack->no_rack }}</option>
                    @endforeach
                </select>
                @error('selectedRack') 
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Sheet Name -->
            <div>
                <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1 block">
                    Nama Sheet Baru <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       wire:model.live="newSheetName" 
                       wire:keydown.enter="addSheet"
                       placeholder="Contoh: SHEET 6, SHEET A, SHEET B, dll"
                       class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-green-500 transition @error('newSheetName') border-red-500 @enderror"
                       {{ $availableRacks->isEmpty() ? 'disabled' : '' }}>
                @error('newSheetName') 
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">
                    Nama sheet akan otomatis diubah menjadi huruf kapital (uppercase)
                </p>
            </div>
            
            <!-- Submit Button -->
            <button wire:click="addSheet" 
                    wire:loading.attr="disabled"
                    wire:target="addSheet"
                    class="w-full mt-4 px-4 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition flex items-center justify-center gap-2 font-medium">
                
                <span wire:loading.remove wire:target="addSheet">
                    Tambah Sheet
                </span>
                
                <span wire:loading wire:target="addSheet">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses...
                </span>
            </button>
            </div>
        </div>
    </div>
    
    <!-- Alert Success -->
    @if($showSuccessAlert)
    <div wire:key="success-alert-{{ time() }}" 
         class="fixed bottom-4 right-4 z-50 animate-fade-in">
        <div class="bg-green-500 text-white px-6 py-3.5 rounded-lg shadow-lg flex items-center gap-3 max-w-sm">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="flex-1 text-sm font-medium">{{ $successMessage }}</span>
            <button wire:click="$set('showSuccessAlert', false)" 
                    class="hover:opacity-75 transition flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    @endif
    
    <!-- Alert Error -->
    @if($showErrorAlert)
    <div wire:key="error-alert-{{ time() }}" 
         class="fixed bottom-4 right-4 z-50 animate-fade-in">
        <div class="bg-red-500 text-white px-6 py-3.5 rounded-lg shadow-lg flex items-center gap-3 max-w-sm">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="flex-1 text-sm font-medium">{{ $errorMessage }}</span>
            <button wire:click="$set('showErrorAlert', false)" 
                    class="hover:opacity-75 transition flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    @endif
</div>

<style>
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }
    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: translateY(20px) scale(0.95);
        }
        to { 
            opacity: 1; 
            transform: translateY(0) scale(1);
        }
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>