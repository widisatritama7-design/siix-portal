<div class="p-1 space-y-2">
    @section('title', 'ESD Locker - Information')

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-1 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                ESD Locker System
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Simpan dengan aman, ambil dengan mudah</p>
        </div>
    </div>

    <!-- Main Content: 3 Columns -->
    <div class="flex flex-col lg:flex-row gap-4 mt-4">
        <!-- LEFT COLUMN: 40% - Grid Locker 8 baris x 2 kolom -->
        <div class="w-full lg:w-[40%]">
            <div class="grid grid-cols-2 gap-2">
                <!-- Kolom Kiri: 01-08 ke bawah -->
                <div class="space-y-2">
                    @foreach(['ESD001','ESD002','ESD003','ESD004','ESD005','ESD006','ESD007','ESD008'] as $code)
                    @php
                        $locker = $lockers->where('code', $code)->first();
                        
                        // Mapping status ke warna sesuai permintaan
                        $statusColors = [
                            'available' => ['bg' => 'bg-green-500', 'shadow' => 'shadow-green-500/30', 'label' => 'Tersedia'],
                            'open' => ['bg' => 'bg-yellow-500', 'shadow' => 'shadow-yellow-500/30', 'label' => 'Terbuka'],
                            'in_progress' => ['bg' => 'bg-blue-500', 'shadow' => 'shadow-blue-500/30', 'label' => 'Diproses'],
                            'ng' => ['bg' => 'bg-red-500', 'shadow' => 'shadow-red-500/30', 'label' => 'Rusak'],
                            'finished' => ['bg' => 'bg-gray-500', 'shadow' => 'shadow-gray-500/30', 'label' => 'Selesai'],
                        ];
                        
                        $status = $locker ? $locker->status : 'available';
                        $color = $statusColors[$status] ?? $statusColors['available'];
                        
                        // Ambil nomor urut untuk ditampilkan (01-16)
                        $number = str_replace('ESD', '', $code);
                    @endphp
                    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-3 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-xl font-bold text-zinc-700 dark:text-zinc-300">{{ $number }}</span>
                            </div>
                            <!-- Bulat indikator diperbesar menjadi w-5 h-5 -->
                            <div class="w-5 h-5 rounded-full {{ $color['bg'] }} shadow-lg {{ $color['shadow'] }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Kolom Kanan: 09-16 ke bawah -->
                <div class="space-y-2">
                    @foreach(['ESD009','ESD010','ESD011','ESD012','ESD013','ESD014','ESD015','ESD016'] as $code)
                    @php
                        $locker = $lockers->where('code', $code)->first();
                        
                        $statusColors = [
                            'available' => ['bg' => 'bg-green-500', 'shadow' => 'shadow-green-500/30', 'label' => 'Tersedia'],
                            'open' => ['bg' => 'bg-yellow-500', 'shadow' => 'shadow-yellow-500/30', 'label' => 'Terbuka'],
                            'in_progress' => ['bg' => 'bg-blue-500', 'shadow' => 'shadow-blue-500/30', 'label' => 'Diproses'],
                            'ng' => ['bg' => 'bg-red-500', 'shadow' => 'shadow-red-500/30', 'label' => 'Rusak'],
                            'finished' => ['bg' => 'bg-gray-500', 'shadow' => 'shadow-gray-500/30', 'label' => 'Selesai'],
                        ];
                        
                        $status = $locker ? $locker->status : 'available';
                        $color = $statusColors[$status] ?? $statusColors['available'];
                        
                        $number = str_replace('ESD', '', $code);
                    @endphp
                    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-3 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-xl font-bold text-zinc-700 dark:text-zinc-300">{{ $number }}</span>
                            </div>
                            <!-- Bulat indikator diperbesar menjadi w-5 h-5 -->
                            <div class="w-5 h-5 rounded-full {{ $color['bg'] }} shadow-lg {{ $color['shadow'] }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- MIDDLE COLUMN: 20% - Tombol Store & Take -->
        <div class="w-full lg:w-[20%]">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-800 p-4 sticky top-4 space-y-3">

                <!-- Button Store -->
                <button wire:click="openModal('store')" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white rounded-lg p-4 shadow-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-xl flex flex-col items-center justify-center group">
                    <svg class="w-8 h-8 mb-1 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-lg font-bold">STORE</span>
                    <span class="text-xs opacity-75">Menyimpan</span>
                </button>

                <!-- Button Take -->
                <button wire:click="openModal('take')" 
                        class="w-full bg-purple-500 hover:bg-purple-600 text-white rounded-lg p-4 shadow-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-xl flex flex-col items-center justify-center group">
                    <svg class="w-8 h-8 mb-1 group-hover:translate-y-[-4px] transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                    <span class="text-lg font-bold">TAKE</span>
                    <span class="text-xs opacity-75">Mengambil</span>
                </button>

                <hr class="border-zinc-200 dark:border-zinc-700">

                <!-- ESD LOCKER Title -->
                <div class="text-center">
                    <p class="text-[10px] text-zinc-500 dark:text-zinc-400">Safety • Security • Control</p>
                </div>

                <!-- 4 Features -->
                <div class="grid grid-cols-2 gap-1.5">
                    <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-1.5 text-center">
                        <div class="w-6 h-6 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-3.5 h-3.5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h4 class="text-[10px] font-bold text-zinc-800 dark:text-white">AMAN</h4>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-1.5 text-center">
                        <div class="w-6 h-6 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h4 class="text-[10px] font-bold text-zinc-800 dark:text-white">MUDAH</h4>
                    </div>
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-1.5 text-center">
                        <div class="w-6 h-6 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-3.5 h-3.5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h4 class="text-[10px] font-bold text-zinc-800 dark:text-white">EFISIEN</h4>
                    </div>
                    <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-1.5 text-center">
                        <div class="w-6 h-6 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-3.5 h-3.5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h4 class="text-[10px] font-bold text-zinc-800 dark:text-white">TERTIB</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: 40% - Petunjuk Penggunaan & Perhatian -->
        <div class="w-full lg:w-[40%]">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-800 p-4 sticky top-4 space-y-3">

                <!-- Petunjuk Penggunaan -->
                <div>
                    <h4 class="text-sm font-bold text-zinc-800 dark:text-white mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        PETUNJUK PENGGUNAAN
                    </h4>
                    <ol class="text-sm text-zinc-600 dark:text-zinc-400 space-y-1.5 list-decimal list-inside">
                        <li>Pilih aksi <span class="font-bold text-green-600 dark:text-green-400">STORE</span> untuk menyimpan barang atau <span class="font-bold text-purple-600 dark:text-purple-400">TAKE</span> untuk mengambil barang.</li>
                        <li>Scan Barcode NIK Anda untuk verifikasi.</li>
                        <li>Masukkan Nomor WhatsApp untuk menerima pemberitahuan.</li>
                        <li>Ikuti instruksi pada layar.</li>
                        <li>Locker akan terbuka otomatis jika berhasil.</li>
                        <li>Setelah selesai, pastikan locker tertutup dengan rapat.</li>
                    </ol>
                </div>

                <hr class="border-zinc-200 dark:border-zinc-700">

                <!-- Perhatian -->
                <div>
                    <h4 class="text-sm font-bold text-yellow-700 dark:text-yellow-400 mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        PERHATIAN
                    </h4>
                    <ul class="text-sm text-yellow-700 dark:text-yellow-400 space-y-1 list-disc list-inside">
                        <li>Simpan barang sesuai ketentuan.</li>
                        <li>Jangan menyimpan barang berbahaya.</li>
                        <li>Sistem ini diawasi CCTV 24 jam.</li>
                        <li>Hubungi ESD Team jika ada kendala (+62-87883994150)</li>
                    </ul>
                </div>

                <hr class="border-zinc-200 dark:border-zinc-700">
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL STORE -->
    <!-- ============================================================ -->
    <div x-data="{ 
        open: @entangle('modalStore'),
        storeNik: @entangle('store_nik').live || '',
        storePhone: @entangle('store_phone').live || '',
        activeInput: 'nik',
        countdown: 10,
        countdownInterval: null,
        isSuccess: false
    }" 
        x-show="open" 
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        @auto-close-store.window="
            isSuccess = true;
            countdown = 10;
            if (countdownInterval) clearInterval(countdownInterval);
            countdownInterval = setInterval(() => {
                countdown--;
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                    open = false;
                    $wire.resetStore();
                }
            }, 1000);
        ">
        
        <div class="fixed inset-0 bg-black/60" @click="
            if (countdownInterval) clearInterval(countdownInterval);
            open = false; 
            $wire.resetStore()
        "></div>
        
        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[85vh] relative z-10 border border-zinc-200 dark:border-zinc-700 flex flex-col">
            <!-- Header -->
            <div class="flex-shrink-0 p-4 pb-3 border-b border-zinc-200 dark:border-zinc-700">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-zinc-800 dark:text-white">Store Uniform</h2>
                    </div>
                    <button @click="
                        if (countdownInterval) clearInterval(countdownInterval);
                        open = false; 
                        $wire.resetStore()
                    " class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-4">
                @if($store_step == 1)
                    <div class="flex flex-col lg:flex-row gap-4 h-full">
                        <!-- KIRI: Form -->
                        <div class="flex-1 space-y-3">
                            <div class="text-center">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Enter your NIK and WhatsApp number</p>
                            </div>

                            <!-- NIK -->
                            <div>
                                <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1">NIK</label>
                                <input type="text" 
                                    x-model="storeNik"
                                    @focus="activeInput = 'nik'"
                                    @input="$wire.set('store_nik', storeNik || '')"
                                    class="w-full px-3 py-2 border-2 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-zinc-800 dark:text-white text-center text-xl font-mono tracking-wider transition"
                                    :class="activeInput === 'nik' ? 'border-green-500 ring-2 ring-green-200 dark:ring-green-900' : 'border-zinc-300 dark:border-zinc-700'"
                                    placeholder="Scan Or Enter your NIK">
                                @error('store_nik') 
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- WhatsApp -->
                            <div>
                                <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1">WhatsApp Number</label>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-3 rounded-lg border-2 border-zinc-300 dark:border-zinc-700 flex items-center justify-center h-[44px] min-w-[44px]">
                                        +62
                                    </span>
                                    <input type="tel" 
                                        x-model="storePhone"
                                        @focus="activeInput = 'wa'"
                                        @input="
                                            if (storePhone && storePhone.startsWith('0')) {
                                                storePhone = storePhone.replace(/^0+/, '');
                                            }
                                            $wire.set('store_phone', storePhone || '');
                                        "
                                        class="flex-1 px-3 py-2 border-2 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-zinc-800 dark:text-white text-base transition h-[44px]"
                                        :class="activeInput === 'wa' ? 'border-green-500 ring-2 ring-green-200 dark:ring-green-900' : 'border-zinc-300 dark:border-zinc-700'"
                                        placeholder="81234567890">
                                </div>
                                @error('store_phone') 
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                                @enderror
                                <p class="text-[10px] text-zinc-400 dark:text-zinc-500 mt-1">
                                    Masukkan nomor WhatsApp aktif untuk menerima kode akses
                                </p>
                            </div>

                            <!-- Switch Input -->
                            <div class="flex gap-2 text-xs">
                                <button type="button"
                                        @click="activeInput = 'nik'; document.querySelector('input[placeholder=\'Scan Or Enter your NIK\']').focus()"
                                        class="flex-1 py-1 rounded-lg transition"
                                        :class="activeInput === 'nik' ? 'bg-green-500 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400'">
                                    NIK
                                </button>
                                <button type="button"
                                        @click="activeInput = 'wa'; document.querySelector('input[placeholder=\'81234567890\']').focus()"
                                        class="flex-1 py-1 rounded-lg transition"
                                        :class="activeInput === 'wa' ? 'bg-green-500 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400'">
                                    WhatsApp
                                </button>
                            </div>

                            <div class="text-center text-[10px] text-zinc-400 dark:text-zinc-500">
                                <span x-show="activeInput === 'nik'">Sedang mengisi <strong class="text-green-600 dark:text-green-400">NIK</strong></span>
                                <span x-show="activeInput === 'wa'">Sedang mengisi <strong class="text-green-600 dark:text-green-400">WhatsApp</strong></span>
                                <span class="mx-1">|</span>
                                <span>Klik field atau tombol di atas untuk switch</span>
                            </div>
                        </div>

                        <!-- KANAN: Numpad -->
                        <div class="flex-1 space-y-3">
                            <div class="grid grid-cols-3 gap-1.5 w-full">
                                @foreach(['1','2','3','4','5','6','7','8','9','clear','0','backspace'] as $key)
                                    <button type="button"
                                            @click="
                                                if ('{{ $key }}' === 'clear') {
                                                    if (activeInput === 'nik') {
                                                        storeNik = '';
                                                    } else {
                                                        storePhone = '';
                                                    }
                                                } else if ('{{ $key }}' === 'backspace') {
                                                    if (activeInput === 'nik') {
                                                        storeNik = storeNik ? storeNik.slice(0, -1) : '';
                                                    } else {
                                                        storePhone = storePhone ? storePhone.slice(0, -1) : '';
                                                    }
                                                } else {
                                                    if (activeInput === 'nik') {
                                                        storeNik = (storeNik || '') + '{{ $key }}';
                                                    } else {
                                                        let newPhone = (storePhone || '') + '{{ $key }}';
                                                        if (!newPhone.startsWith('0')) {
                                                            storePhone = newPhone;
                                                        }
                                                    }
                                                }
                                                $wire.set('store_nik', storeNik || '');
                                                $wire.set('store_phone', storePhone || '');
                                            "
                                            class="numpad-btn {{ $key === 'clear' ? 'bg-red-500 hover:bg-red-600 text-white' : ($key === 'backspace' ? 'bg-yellow-500 hover:bg-yellow-600 text-white' : 'bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-white') }} py-1.5 rounded-lg font-black text-2xl transition active:scale-95 h-[48px] shadow-sm hover:shadow-md flex items-center justify-center">
                                        @if($key === 'clear')
                                            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        @elseif($key === 'backspace')
                                            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z"></path>
                                            </svg>
                                        @else
                                            {{ $key }}
                                        @endif
                                    </button>
                                @endforeach
                            </div>

                            <button wire:click="checkStoreNik" 
                                    wire:loading.attr="disabled"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-green-600/20 hover:scale-[1.02] active:scale-95 text-sm">
                                <span wire:loading.remove>Check NIK</span>
                                <span wire:loading>Checking...</span>
                            </button>
                        </div>
                    </div>

                @elseif($store_step == 2)
                    <div class="flex flex-col lg:flex-row gap-4 h-full">
                        <div class="flex-1 space-y-4">
                            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4 animate-fade-in">
                                <h3 class="font-semibold text-green-800 dark:text-green-300 mb-2 flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Confirm Employee Data
                                </h3>
                                <div class="space-y-1 text-sm text-zinc-700 dark:text-zinc-300">
                                    <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                        <span class="font-medium">NIK</span>
                                        <span>{{ $store_employee->nik }}</span>
                                    </div>
                                    <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                        <span class="font-medium">Name</span>
                                        <span>{{ $store_employee->name }}</span>
                                    </div>
                                    <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                        <span class="font-medium">Department</span>
                                        <span>{{ $store_employee->department }}</span>
                                    </div>
                                    <div class="flex justify-between py-1">
                                        <span class="font-medium">WhatsApp</span>
                                        <span>+{{ $store_phone }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex-1 flex flex-col justify-center gap-3">
                            <button wire:click="storeUniform" 
                                    wire:loading.attr="disabled"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-blue-600/20 hover:scale-[1.02] active:scale-95 text-sm">
                                <span wire:loading.remove>Confirm Store</span>
                                <span wire:loading>Processing...</span>
                            </button>
                            <button wire:click="resetStore" 
                                    class="w-full bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 py-2.5 px-4 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600 transition duration-200 text-sm">
                                Cancel
                            </button>
                        </div>
                    </div>

                @else
                    <div class="flex flex-col items-center justify-center py-2 animate-fade-in">
                        <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg shadow-green-500/20 animate-bounce-slow">
                            <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-xl font-bold text-green-600 dark:text-green-400 mb-1">Locker Opened!</h3>
                        <p class="text-base text-zinc-700 dark:text-zinc-300 mb-3">
                            Locker <span class="font-bold text-blue-600 dark:text-blue-400">{{ $locker_code }}</span> is now open
                        </p>
                        
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-3 mb-3 w-full max-w-md">
                            <div class="flex items-center justify-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">
                                <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Door will close automatically in <strong class="text-red-600 dark:text-red-400">15 seconds</strong></span>
                            </div>
                            <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-1 text-center">Notifikasi telah dikirim ke WhatsApp Anda</p>
                        </div>
                
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-3 mb-3 border border-blue-200 dark:border-blue-800 w-full max-w-md">
                            <div class="flex items-center justify-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Seragam berhasil disimpan di locker <strong class="text-blue-600 dark:text-blue-400">{{ $locker_code }}</strong></span>
                            </div>
                            <p class="text-[10px] text-zinc-500 dark:text-zinc-400 mt-1 text-center">
                                Anda akan mendapat notifikasi WhatsApp setelah seragam selesai diperiksa
                            </p>
                        </div>

                        <div x-show="isSuccess" class="mt-2 w-full max-w-md">
                            <div class="flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400 mb-1">
                                <span>Menutup otomatis...</span>
                                <span x-text="countdown + 's'" class="font-bold text-blue-600 dark:text-blue-400"></span>
                            </div>
                            <div class="w-full h-1.5 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-600 dark:bg-blue-400 rounded-full transition-all duration-1000 ease-linear"
                                    :style="'width: ' + (countdown / 10 * 100) + '%'">
                                </div>
                            </div>
                        </div>
                
                        <button wire:click="resetStore" 
                                @click="if (countdownInterval) clearInterval(countdownInterval)"
                                class="mt-3 inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 font-medium shadow-lg shadow-blue-600/20 hover:scale-[1.05] active:scale-95 text-sm">
                            Close
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL TAKE -->
    <!-- ============================================================ -->
    <div x-data="{ 
        open: @entangle('modalTake'),
        takeCode: @entangle('take_access_code').live || '',
        countdown: 10,
        countdownInterval: null,
        isSuccess: false
    }" 
        x-show="open" 
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        @auto-close-take.window="
            isSuccess = true;
            countdown = 10;
            if (countdownInterval) clearInterval(countdownInterval);
            countdownInterval = setInterval(() => {
                countdown--;
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                    open = false;
                    $wire.resetTake();
                }
            }, 1000);
        ">
        
        <div class="fixed inset-0 bg-black/60" @click="
            if (countdownInterval) clearInterval(countdownInterval);
            open = false; 
            $wire.resetTake()
        "></div>
        
        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto relative z-10 border border-zinc-200 dark:border-zinc-700">
            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">Take Uniform</h2>
                    </div>
                    <button @click="
                        if (countdownInterval) clearInterval(countdownInterval);
                        open = false; 
                        $wire.resetTake()
                    " class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                @if($take_step == 1)
                    <div class="space-y-4">
                        <div class="text-center">
                            <p class="text-gray-600 dark:text-gray-400">Enter the access code sent via WhatsApp</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Access Code</label>
                            <input type="text" 
                                x-model="takeCode"
                                @input="$wire.set('take_access_code', takeCode || '')"
                                class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-center text-2xl font-mono uppercase dark:bg-zinc-800 dark:text-white transition"
                                placeholder="e.g. ABCD1234EF">
                            @error('take_access_code') 
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>
                        
                        <div class="grid grid-cols-9 gap-1.5 max-w-full">
                            @foreach(['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'] as $key)
                                <button type="button"
                                        @click="
                                            takeCode = (takeCode || '') + '{{ $key }}';
                                            $wire.set('take_access_code', takeCode || '');
                                        "
                                        class="numpad-btn bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-800 dark:text-white py-2 rounded-lg font-bold text-sm transition active:scale-90">
                                    {{ $key }}
                                </button>
                            @endforeach
                        </div>

                        <div class="grid grid-cols-10 gap-1.5 max-w-full">
                            @foreach(['0','1','2','3','4','5','6','7','8','9'] as $key)
                                <button type="button"
                                        @click="
                                            takeCode = (takeCode || '') + '{{ $key }}';
                                            $wire.set('take_access_code', takeCode || '');
                                        "
                                        class="numpad-btn bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-white py-2 rounded-lg font-bold text-sm transition active:scale-90">
                                    {{ $key }}
                                </button>
                            @endforeach
                        </div>

                        <div class="grid grid-cols-2 gap-1.5 max-w-full">
                            <button type="button"
                                    @click="
                                        takeCode = '';
                                        $wire.set('take_access_code', '');
                                    "
                                    class="numpad-btn bg-red-500 hover:bg-red-600 text-white py-2.5 rounded-lg font-bold text-base transition active:scale-90 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Clear
                            </button>
                            <button type="button"
                                    @click="
                                        takeCode = takeCode ? takeCode.slice(0, -1) : '';
                                        $wire.set('take_access_code', takeCode || '');
                                    "
                                    class="numpad-btn bg-yellow-500 hover:bg-yellow-600 text-white py-2.5 rounded-lg font-bold text-base transition active:scale-90 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z"></path>
                                </svg>
                                Backspace
                            </button>
                        </div>

                        <button wire:click="checkTakeCode" 
                                wire:loading.attr="disabled"
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-purple-600/20 hover:scale-[1.02] active:scale-95">
                            <span wire:loading.remove>Check Code</span>
                            <span wire:loading>Checking...</span>
                        </button>
                    </div>

                @elseif($take_step == 2)
                    <div class="space-y-6">
                        <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-xl p-5 animate-fade-in">
                            <h3 class="font-semibold text-purple-800 dark:text-purple-300 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Transaction Details
                            </h3>
                            <div class="space-y-2 text-zinc-700 dark:text-zinc-300">
                                <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                    <span class="font-medium">NIK</span>
                                    <span>{{ $take_transaction->employee->nik }}</span>
                                </div>
                                <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                    <span class="font-medium">Name</span>
                                    <span>{{ $take_transaction->employee->name }}</span>
                                </div>
                                <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                    <span class="font-medium">Department</span>
                                    <span>{{ $take_transaction->employee->department }}</span>
                                </div>
                                <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                    <span class="font-medium">Locker</span>
                                    <span class="font-mono font-bold text-blue-600 dark:text-blue-400">{{ $take_transaction->locker->code }}</span>
                                </div>
                                <div class="flex justify-between py-1">
                                    <span class="font-medium">Locker Status</span>
                                    @php
                                        $lockerStatusColors = [
                                            'available' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300',
                                            'open' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300',
                                            'in_progress' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300',
                                            'ng' => 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300',
                                            'finished' => 'bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-300'
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $lockerStatusColors[$take_transaction->locker->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst(str_replace('_', ' ', $take_transaction->locker->status)) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button wire:click="openTakeLocker" 
                                    wire:loading.attr="disabled"
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-green-600/20 hover:scale-[1.02] active:scale-95">
                                <span wire:loading.remove>Open Locker</span>
                                <span wire:loading>Processing...</span>
                            </button>
                            <button wire:click="resetTake" 
                                    class="px-6 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 py-3 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600 transition duration-200">
                                Cancel
                            </button>
                        </div>
                    </div>

                @else
                    <div class="text-center py-4 animate-fade-in">
                        <div class="w-24 h-24 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-green-500/20 animate-bounce-slow">
                            <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-green-600 dark:text-green-400 mb-2">Locker Opened!</h3>
                        <p class="text-lg text-zinc-700 dark:text-zinc-300 mb-4">
                            Locker <span class="font-bold text-blue-600 dark:text-blue-400">{{ $take_transaction->locker->code }}</span> is now open
                        </p>
                        
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-6">
                            <div class="flex items-center justify-center gap-3 text-sm text-zinc-600 dark:text-zinc-400">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Door will close automatically in <strong class="text-red-600 dark:text-red-400">15 seconds</strong></span>
                            </div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2 text-center">Please take your uniform</p>
                        </div>

                        <div x-show="isSuccess" class="mt-4">
                            <div class="flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400 mb-1">
                                <span>Menutup otomatis...</span>
                                <span x-text="countdown + 's'" class="font-bold text-purple-600 dark:text-purple-400"></span>
                            </div>
                            <div class="w-full h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
                                <div class="h-full bg-purple-600 dark:bg-purple-400 rounded-full transition-all duration-1000 ease-linear"
                                    :style="'width: ' + (countdown / 10 * 100) + '%'">
                                </div>
                            </div>
                        </div>

                        <button wire:click="resetTake" 
                                @click="if (countdownInterval) clearInterval(countdownInterval)"
                                class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg transition duration-200 font-medium shadow-lg shadow-blue-600/20 hover:scale-[1.05] active:scale-95">
                            Close
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    <div x-data="{ show: false, message: '', type: 'success' }" 
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
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
        
        .numpad-btn {
            min-height: 40px;
            user-select: none;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
            cursor: pointer;
            border: 1px solid rgba(0,0,0,0.05);
            font-size: 13px;
            font-weight: 600;
        }
        
        .numpad-btn:active {
            transform: scale(0.92);
        }
        
        .numpad-btn svg {
            pointer-events: none;
        }
        
        .dark .numpad-btn {
            border-color: rgba(255,255,255,0.05);
        }

        /* Animations */
        @keyframes pulse-slow {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes pulse-arrow {
            0%, 100% { opacity: 0.5; transform: translateX(0); }
            50% { opacity: 1; transform: translateX(4px); }
        }
        
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-pulse-slow {
            animation: pulse-slow 2.5s ease-in-out infinite;
        }
        
        .animate-pulse-arrow {
            animation: pulse-arrow 1.5s ease-in-out infinite;
        }
        
        .animate-bounce-slow {
            animation: bounce-slow 2s ease-in-out infinite;
        }
        
        .animate-spin-slow {
            animation: spin-slow 4s linear infinite;
        }
        
        .animate-fade-in {
            animation: fade-in 0.4s ease-out;
        }

        @media (max-width: 640px) {
            .numpad-btn {
                font-size: 11px;
                min-height: 34px;
                padding: 4px 2px;
            }
        }
    </style>
</div>