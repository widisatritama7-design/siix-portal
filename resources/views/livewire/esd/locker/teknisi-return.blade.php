<div class="p-1 space-y-2">
    @section('title', 'Teknisi Kembalikan Seragam - ESD System')
    
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            ESD
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Teknisi Kembalikan Seragam
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                📥 Teknisi - Kembalikan Seragam
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Kembalikan seragam yang sudah dicek ke loker
            </p>
        </div>
    </div>

    <!-- Content -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
        @if($step == 1)
            <!-- Step 1: Input Kode Akses -->
            <div class="space-y-6">
                <div class="text-center mb-6">
                    <p class="text-gray-600 dark:text-gray-400">Scan atau masukkan kode akses dari label yang sudah diprint</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Kode Akses</label>
                    <input type="text" 
                           wire:model="access_code" 
                           wire:keydown.enter="checkCode"
                           class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center text-2xl font-mono uppercase dark:bg-zinc-800 dark:text-white"
                           placeholder="Contoh: ABCD1234EF">
                    @error('access_code') 
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                <button wire:click="checkCode" 
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                    Cek Kode
                </button>
            </div>
        @elseif($step == 2)
            <!-- Step 2: Konfirmasi -->
            <div class="space-y-6">
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <h3 class="font-semibold text-blue-800 dark:text-blue-300 mb-2">Informasi Transaksi</h3>
                    <div class="space-y-2 text-zinc-700 dark:text-zinc-300">
                        <p><span class="font-medium">NIK:</span> {{ $transaction->employee->nik }}</p>
                        <p><span class="font-medium">Nama:</span> {{ $transaction->employee->name }}</p>
                        <p><span class="font-medium">Departemen:</span> {{ $transaction->employee->department }}</p>
                        <p><span class="font-medium">Loker:</span> <span class="font-mono font-bold">{{ $transaction->locker->code }}</span></p>
                        <p><span class="font-medium">Status:</span> 
                            <span class="px-2 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300 rounded text-sm">
                                On Progress
                            </span>
                        </p>
                    </div>
                </div>

                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <p class="text-sm text-green-700 dark:text-green-300">✅ Seragam sudah selesai dicek. Klik tombol di bawah untuk mengembalikan.</p>
                </div>

                <div class="flex gap-3">
                    <button wire:click="returnUniform" 
                            wire:loading.attr="disabled"
                            class="flex-1 bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition duration-200 font-medium">
                        <span wire:loading.remove>📥 Kembalikan Seragam</span>
                        <span wire:loading>⏳ Memproses...</span>
                    </button>
                    <button wire:click="resetForm" 
                            class="px-6 bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 py-3 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-700 transition duration-200">
                        Batal
                    </button>
                </div>
            </div>
        @else
            <!-- Step 3: Sukses -->
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
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2">Silakan simpan seragam yang sudah dicek</p>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2">📱 Notifikasi telah dikirim ke WhatsApp user</p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('esd.teknisi.management') }}" 
                       class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                        Kembali ke Management
                    </a>
                    <a href="{{ route('esd.teknisi.take') }}" 
                       class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition duration-200">
                        Ambil Seragam Lain
                    </a>
                </div>
            </div>
        @endif
    </flux:card>
</div>