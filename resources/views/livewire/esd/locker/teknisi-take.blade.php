<div class="p-1 space-y-2">
    @section('title', 'Teknisi Ambil Seragam - ESD System')
    
    <!-- Breadcrumbs -->
    <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Dashboard</a>
        <span>/</span>
        <span class="text-gray-700 dark:text-gray-300">ESD</span>
        <span>/</span>
        <span class="text-blue-600 dark:text-blue-400 font-semibold">Teknisi Ambil Seragam</span>
    </nav>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                🔍 Teknisi - Ambil Seragam untuk Dicek
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Ambil seragam yang baru disimpan user untuk dilakukan pengecekan
            </p>
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
        @if($step == 1)
            <!-- Step 1: Input NIK -->
            <div class="space-y-6">
                <div class="text-center mb-6">
                    <p class="text-gray-600 dark:text-gray-400">Masukkan NIK karyawan untuk mengambil seragam yang perlu dicek</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">NIK Karyawan</label>
                    <input type="text" 
                           wire:model="nik" 
                           wire:keydown.enter="searchEmployee"
                           class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:text-white"
                           placeholder="Masukkan NIK">
                    @error('nik') 
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                <button wire:click="searchEmployee" 
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                    Cari Karyawan
                </button>
            </div>
        @elseif($step == 2)
            <!-- Step 2: Print Label -->
            <div class="space-y-6">
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <h3 class="font-semibold text-blue-800 dark:text-blue-300 mb-2">Data Karyawan</h3>
                    <div class="space-y-2 text-zinc-700 dark:text-zinc-300">
                        <p><span class="font-medium">NIK:</span> {{ $employee->nik }}</p>
                        <p><span class="font-medium">Nama:</span> {{ $employee->name }}</p>
                        <p><span class="font-medium">Departemen:</span> {{ $employee->department }}</p>
                        <p><span class="font-medium">Loker:</span> <span class="font-mono font-bold">{{ $transaction->locker->code }}</span></p>
                        <p><span class="font-medium">Kode Akses:</span> <span class="font-mono">{{ $transaction->access_code }}</span></p>
                        <p><span class="font-medium">Status:</span> 
                            <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 rounded text-sm">
                                Pending (Menunggu Pengecekan)
                            </span>
                        </p>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Kode Akses untuk Print</p>
                    <div class="text-2xl font-mono font-bold bg-white dark:bg-zinc-900 p-3 rounded-lg border border-gray-300 dark:border-gray-600">
                        {{ $transaction->access_code }}
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Scan kode akses ini untuk membuka loker</p>
                </div>

                <div class="flex gap-3">
                    <button wire:click="printLabel" 
                            wire:loading.attr="disabled"
                            class="flex-1 bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition duration-200 font-medium">
                        <span wire:loading.remove>🖨️ Print Label & Buka Loker</span>
                        <span wire:loading>⏳ Memproses...</span>
                    </button>
                    <button wire:click="resetForm" 
                            class="px-6 bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 py-3 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-700 transition duration-200">
                        Batal
                    </button>
                </div>
            </div>
        @elseif($step == 3)
            <!-- Step 3: Buka Loker -->
            <div class="text-center space-y-6">
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                    <p class="text-yellow-700 dark:text-yellow-300">📋 Label sudah dicetak. Klik tombol di bawah untuk membuka loker.</p>
                </div>

                <div class="bg-zinc-50 dark:bg-zinc-800 rounded-lg p-8">
                    <div class="text-center">
                        <svg class="w-16 h-16 text-blue-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Loker akan terbuka setelah Anda klik tombol di bawah</p>
                    </div>
                </div>

                <button wire:click="scanAndOpen" 
                        wire:loading.attr="disabled"
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                    <span wire:loading.remove>🔓 Buka Loker</span>
                    <span wire:loading>⏳ Memproses...</span>
                </button>
            </div>
        @else
            <!-- Step 4: Sukses -->
            <div class="text-center">
                <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                
                <h3 class="text-2xl font-bold text-green-700 dark:text-green-400 mb-2">Loker Berhasil Dibuka!</h3>
                <p class="text-lg text-zinc-700 dark:text-zinc-300 mb-4">
                    Loker <span class="font-bold text-blue-600 dark:text-blue-400">{{ $transaction->locker->code }}</span> telah terbuka
                </p>
                
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-6">
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">⚠️ Pintu akan tertutup otomatis dalam <span class="font-bold text-red-600 dark:text-red-400">15 detik</span></p>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2">Ambil seragam untuk dilakukan pengecekan</p>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2">📱 Notifikasi telah dikirim ke WhatsApp user</p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('esd.teknisi.management') }}" 
                       class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                        Kembali ke Management
                    </a>
                    <a href="{{ route('esd.teknisi.return') }}" 
                       class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition duration-200">
                        Kembalikan Seragam
                    </a>
                </div>
            </div>
        @endif
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