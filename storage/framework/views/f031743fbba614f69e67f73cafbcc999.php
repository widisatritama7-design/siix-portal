<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>ESD Locker - Information</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-7xl mx-auto p-4 space-y-4">

        <!-- HEADER -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg p-5 text-white">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <div>
                    <h1 class="text-3xl font-bold">
                        ESD Locker System
                    </h1>
                    <p class="text-sm text-blue-100">Simpan dengan aman, ambil dengan mudah</p>
                </div>
            </div>
        </div>

        <!-- Main Content: 3 Columns -->
        <div class="flex flex-col lg:flex-row gap-4">

            <!-- LEFT COLUMN: 40% - Grid Locker -->
            <div class="w-full lg:w-[40%]">
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-4">
                    <div class="grid grid-cols-2 gap-2.5">
                        <!-- Kolom Kiri: 01-08 -->
                        <div class="space-y-2.5">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['ESD001','ESD002','ESD003','ESD004','ESD005','ESD006','ESD007','ESD008']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <?php
                                $locker = $lockers->where('code', $code)->first();
                                
                                $statusColors = [
                                    'available' => ['bg' => 'bg-green-500', 'shadow' => 'shadow-green-500/30'],
                                    'open' => ['bg' => 'bg-yellow-500', 'shadow' => 'shadow-yellow-500/30'],
                                    'in_progress' => ['bg' => 'bg-blue-500', 'shadow' => 'shadow-blue-500/30'],
                                    'ng' => ['bg' => 'bg-red-500', 'shadow' => 'shadow-red-500/30'],
                                    'finished' => ['bg' => 'bg-gray-500', 'shadow' => 'shadow-gray-500/30'],
                                ];
                                
                                $status = $locker ? $locker->status : 'available';
                                $color = $statusColors[$status] ?? $statusColors['available'];
                                $number = str_replace('ESD', '', $code);
                                
                                $lockerBgColors = [
                                    '01' => 'bg-gray-50',
                                    '02' => 'bg-gray-100',
                                    '03' => 'bg-gray-50',
                                    '04' => 'bg-gray-100',
                                    '05' => 'bg-gray-50',
                                    '06' => 'bg-gray-100',
                                    '07' => 'bg-gray-50',
                                    '08' => 'bg-gray-100',
                                    '09' => 'bg-gray-50',
                                    '10' => 'bg-gray-100',
                                    '11' => 'bg-gray-50',
                                    '12' => 'bg-gray-100',
                                    '13' => 'bg-gray-50',
                                    '14' => 'bg-gray-100',
                                    '15' => 'bg-gray-50',
                                    '16' => 'bg-gray-100',
                                ];
                                
                                $bgColor = $lockerBgColors[$number] ?? 'bg-gray-50';
                            ?>
                            <div class="<?php echo e($bgColor); ?> border border-gray-300 rounded-lg p-3 hover:shadow-md transition-all duration-200 cursor-default relative">
                                <div class="absolute inset-0.5 rounded-lg border border-gray-200 pointer-events-none"></div>
                                
                                <div class="flex items-center justify-between relative z-10">
                                    <span class="text-base font-bold text-gray-600"><?php echo e($number); ?></span>
                                    <div class="flex items-center gap-2">
                                        <div class="w-0.5 h-5 bg-gray-300 rounded-full"></div>
                                        <div class="w-3.5 h-3.5 rounded-full <?php echo e($color['bg']); ?> shadow <?php echo e($color['shadow']); ?>"></div>
                                    </div>
                                </div>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                        
                        <!-- Kolom Kanan: 09-16 -->
                        <div class="space-y-2.5">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['ESD009','ESD010','ESD011','ESD012','ESD013','ESD014','ESD015','ESD016']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <?php
                                $locker = $lockers->where('code', $code)->first();
                                
                                $statusColors = [
                                    'available' => ['bg' => 'bg-green-500', 'shadow' => 'shadow-green-500/30'],
                                    'open' => ['bg' => 'bg-yellow-500', 'shadow' => 'shadow-yellow-500/30'],
                                    'in_progress' => ['bg' => 'bg-blue-500', 'shadow' => 'shadow-blue-500/30'],
                                    'ng' => ['bg' => 'bg-red-500', 'shadow' => 'shadow-red-500/30'],
                                    'finished' => ['bg' => 'bg-gray-500', 'shadow' => 'shadow-gray-500/30'],
                                ];
                                
                                $status = $locker ? $locker->status : 'available';
                                $color = $statusColors[$status] ?? $statusColors['available'];
                                $number = str_replace('ESD', '', $code);
                                
                                $lockerBgColors = [
                                    '01' => 'bg-gray-50',
                                    '02' => 'bg-gray-100',
                                    '03' => 'bg-gray-50',
                                    '04' => 'bg-gray-100',
                                    '05' => 'bg-gray-50',
                                    '06' => 'bg-gray-100',
                                    '07' => 'bg-gray-50',
                                    '08' => 'bg-gray-100',
                                    '09' => 'bg-gray-50',
                                    '10' => 'bg-gray-100',
                                    '11' => 'bg-gray-50',
                                    '12' => 'bg-gray-100',
                                    '13' => 'bg-gray-50',
                                    '14' => 'bg-gray-100',
                                    '15' => 'bg-gray-50',
                                    '16' => 'bg-gray-100',
                                ];
                                
                                $bgColor = $lockerBgColors[$number] ?? 'bg-gray-50';
                            ?>
                            <div class="<?php echo e($bgColor); ?> border border-gray-300 rounded-lg p-3 hover:shadow-md transition-all duration-200 cursor-default relative">
                                <div class="absolute inset-0.5 rounded-lg border border-gray-200 pointer-events-none"></div>
                                
                                <div class="flex items-center justify-between relative z-10">
                                    <span class="text-base font-bold text-gray-600"><?php echo e($number); ?></span>
                                    <div class="flex items-center gap-2">
                                        <div class="w-0.5 h-5 bg-gray-300 rounded-full"></div>
                                        <div class="w-3.5 h-3.5 rounded-full <?php echo e($color['bg']); ?> shadow <?php echo e($color['shadow']); ?>"></div>
                                    </div>
                                </div>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MIDDLE COLUMN: 20% - Tombol Store & Take -->
            <div class="w-full lg:w-[20%]">
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-4 sticky top-4 space-y-3">

                    <!-- Button Store -->
                    <button onclick="openStoreModal()" 
                            class="w-full bg-green-600 hover:bg-green-700 text-white rounded-lg py-4 shadow-md transition-all duration-300 hover:scale-[1.02] hover:shadow-xl flex flex-col items-center justify-center group">
                        <svg class="w-10 h-10 mb-1 group-hover:translate-y-1 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 15V3"/>
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <path d="m7 10 5 5 5-5"/>
                        </svg>
                        <span class="text-lg font-bold">STORE</span>
                        <span class="text-xs opacity-75">Menyimpan Seragam</span>
                    </button>

                    <!-- Button Take -->
                    <button onclick="openTakeModal()" 
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white rounded-lg py-4 shadow-md transition-all duration-300 hover:scale-[1.02] hover:shadow-xl flex flex-col items-center justify-center group">
                        <svg class="w-10 h-10 mb-1 group-hover:-translate-y-1 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 3v12"/>
                            <path d="m17 8-5-5-5 5"/>
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        </svg>
                        <span class="text-lg font-bold">TAKE</span>
                        <span class="text-xs opacity-75">Mengambil Seragam</span>
                    </button>

                    <hr class="border-gray-200">

                    <!-- 4 Features -->
                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-green-50 rounded-lg p-2 text-center border border-green-100">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <h4 class="text-xs font-bold text-gray-700">AMAN</h4>
                            <p class="text-[8px] text-gray-500 leading-tight">Sistem terkendali</p>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-2 text-center border border-blue-100">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mx-auto">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h4 class="text-xs font-bold text-gray-700">MUDAH</h4>
                            <p class="text-[8px] text-gray-500 leading-tight">Proses cepat</p>
                        </div>
                        <div class="bg-yellow-50 rounded-lg p-2 text-center border border-yellow-100">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mx-auto">
                                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-xs font-bold text-gray-700">EFISIEN</h4>
                            <p class="text-[8px] text-gray-500 leading-tight">Hemat waktu</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-2 text-center border border-purple-100">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mx-auto">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h4 class="text-xs font-bold text-gray-700">TERTIB</h4>
                            <p class="text-[8px] text-gray-500 leading-tight">Rapih & aman</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: 40% - Petunjuk & Perhatian -->
            <div class="w-full lg:w-[40%]">
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-4 sticky top-4 space-y-3">

                    <!-- Petunjuk Penggunaan -->
                    <div>
                        <h4 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2 border-b border-gray-200 pb-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            PETUNJUK PENGGUNAAN
                        </h4>
                        <ol class="text-sm text-gray-600 space-y-2 list-decimal list-inside">
                            <li>Pilih aksi <span class="font-bold text-green-600">STORE</span> untuk menyimpan barang atau <span class="font-bold text-purple-600">TAKE</span> untuk mengambil barang.</li>
                            <li>Scan Barcode NIK Anda untuk verifikasi.</li>
                            <li>Masukkan Nomor WhatsApp untuk menerima pemberitahuan.</li>
                            <li>Ikuti instruksi pada layar.</li>
                            <li>Locker akan terbuka otomatis jika berhasil.</li>
                            <li>Setelah selesai, pastikan locker tertutup dengan rapat.</li>
                        </ol>
                    </div>

                    <hr class="border-gray-200">

                    <!-- Perhatian -->
                    <div>
                        <h4 class="text-sm font-bold text-yellow-700 mb-3 flex items-center gap-2 border-b border-gray-200 pb-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            PERHATIAN
                        </h4>
                        <ul class="text-sm text-yellow-700 space-y-1.5 list-disc list-inside">
                            <li>Simpan barang sesuai ketentuan.</li>
                            <li>Jangan menyimpan barang berbahaya.</li>
                            <li>Sistem ini diawasi CCTV 24 jam.</li>
                            <li>Hubungi ESD Team jika ada kendala.</li>
                        </ul>
                    </div>

                    <hr class="border-gray-200">

                    <!-- Footer -->
                    <div class="text-center text-[10px] text-gray-400 pt-2">
                        <p>ESD Locker System © 2025 | All Rights Reserved</p>
                        <p>Powered by ESD Management System</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL STORE -->
    <div id="storeModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300" onclick="closeModal('storeModal')"></div>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] relative z-10 border border-gray-200 flex flex-col transform transition-all duration-300 scale-95 opacity-0" id="storeModalContent">
            <!-- Header -->
            <div class="flex-shrink-0 px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-green-100 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center shadow-lg shadow-green-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Store Uniform</h2>
                    </div>
                    <button onclick="closeModal('storeModal')" class="text-gray-400 hover:text-gray-600 transition-colors hover:rotate-90 duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-6">
                <!-- Step 1: Input Data -->
                <div id="storeStep1" class="animate-fade-in">
                    <div class="flex flex-col lg:flex-row gap-6">
                        <!-- KIRI: Form -->
                        <div class="flex-1 space-y-4">
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Masukkan NIK dan Nomor WhatsApp</p>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">NIK</label>
                                <input type="text" id="storeNik" 
                                    onfocus="activeStoreInput = 'nik'"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-center text-xl font-mono tracking-wider transition"
                                    placeholder="Scan atau Masukkan NIK">
                                <div id="storeNikError" class="text-red-500 text-xs mt-1 hidden"></div>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-gray-500 bg-gray-100 px-3 rounded-lg border-2 border-gray-300 flex items-center justify-center h-[50px] min-w-[50px]">
                                        +62
                                    </span>
                                    <input type="tel" id="storePhone"
                                        onfocus="activeStoreInput = 'wa'"
                                        class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-base transition h-[50px]"
                                        placeholder="81234567890">
                                </div>
                                <div id="storePhoneError" class="text-red-500 text-xs mt-1 hidden"></div>
                                <p class="text-[10px] text-gray-400 mt-1">
                                    Masukkan nomor WhatsApp aktif untuk menerima notifikasi
                                </p>
                            </div>

                            <button onclick="checkStoreNik()" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-md hover:shadow-lg">
                                Submit
                            </button>
                        </div>

                        <!-- KANAN: Numpad -->
                        <div class="flex-1">
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="grid grid-cols-3 gap-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['1','2','3','4','5','6','7','8','9','clear','0','backspace']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <button type="button"
                                                onclick="storeKeyPress('<?php echo e($key); ?>')"
                                                class="numpad-btn <?php echo e($key === 'clear' ? 'bg-red-500 hover:bg-red-600 text-white' : ($key === 'backspace' ? 'bg-yellow-500 hover:bg-yellow-600 text-white' : 'bg-white hover:bg-gray-100 text-gray-800 border border-gray-300')); ?> py-3 rounded-lg font-bold text-xl transition active:scale-95 shadow-sm hover:shadow-md flex items-center justify-center h-[52px]">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($key === 'clear'): ?>
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            <?php elseif($key === 'backspace'): ?>
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z"></path>
                                                </svg>
                                            <?php else: ?>
                                                <?php echo e($key); ?>

                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </button>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Confirm Data -->
                <div id="storeStep2" class="hidden animate-fade-in">
                    <div class="flex flex-col lg:flex-row gap-6">
                        <div class="flex-1">
                            <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-xl p-5">
                                <h3 class="font-semibold text-green-800 mb-3 flex items-center gap-2 text-sm">
                                    <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center shadow-lg shadow-green-500/30">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    Konfirmasi Data Karyawan
                                </h3>
                                <div id="storeEmployeeData" class="space-y-2 text-sm text-gray-700">
                                    <!-- Akan diisi oleh JavaScript -->
                                </div>
                            </div>
                        </div>

                        <div class="flex-1 flex flex-col justify-center gap-3">
                            <button onclick="submitStore()" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Konfirmasi Store
                            </button>
                            <button onclick="storeStepBack()" 
                                    class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Success -->
                <div id="storeStep3" class="hidden animate-fade-in">
                    <div class="flex flex-col items-center justify-center py-4">
                        <div class="w-20 h-20 bg-gradient-to-r from-green-400 to-green-500 rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg shadow-green-500/30 animate-bounce-slow">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-xl font-bold text-green-600 mb-1">Locker Berhasil Dibuka!</h3>
                        <p class="text-base text-gray-700 mb-3">
                            Locker <span id="storeLockerCode" class="font-bold text-blue-600"></span> sekarang terbuka
                        </p>
                        
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-3 mb-3 w-full max-w-sm">
                            <div class="flex items-center justify-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-yellow-600 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Pintu akan menutup otomatis dalam <strong id="storeCountdown" class="text-red-600">15</strong> detik</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 text-center">Notifikasi telah dikirim ke WhatsApp Anda</p>
                            
                            <!-- Progress Bar -->
                            <div class="mt-2 w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                <div id="storeProgressBar" class="bg-gradient-to-r from-green-500 to-blue-500 h-2 rounded-full transition-all duration-1000" style="width: 100%"></div>
                            </div>
                        </div>

                        <button onclick="closeModal('storeModal')" 
                                class="mt-1 inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 font-medium shadow-md hover:shadow-lg flex items-center justify-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Tutup Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL PERINGATAN NIK TIDAK TERDAFTAR -->
    <!-- ============================================================ -->
    <div id="nikErrorModal" class="fixed inset-0 z-[70] flex items-center justify-center p-4 hidden">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300" onclick="closeModal('nikErrorModal')"></div>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] relative z-10 border border-gray-200 flex flex-col transform transition-all duration-300 scale-95 opacity-0" id="nikErrorModalContent">
            <!-- Header -->
            <div class="flex-shrink-0 px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-red-50 to-red-100 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-red-500 flex items-center justify-center shadow-lg shadow-red-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">NIK Tidak Ditemukan</h2>
                    </div>
                    <button onclick="closeModal('nikErrorModal')" class="text-gray-400 hover:text-gray-600 transition-colors hover:rotate-90 duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-6">
                <div class="space-y-4">
                    <!-- Informasi -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">NIK Tidak Terdaftar</h3>
                        <p class="text-sm text-gray-500 mt-2">
                            NIK yang Anda masukkan <strong class="text-red-600" id="nikErrorNumber">220956528</strong> tidak terdaftar.
                        </p>
                    </div>

                    <!-- Saran -->
                    <div class="bg-gray-50 rounded-xl border border-gray-200 p-4">
                        <p class="text-sm font-medium text-gray-700 mb-2">Yang dapat Anda lakukan:</p>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-start gap-3">
                                <span class="text-blue-600 font-bold mt-0.5">1.</span>
                                <span>Periksa kembali NIK Anda, pastikan tidak ada kesalahan penulisan</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-blue-600 font-bold mt-0.5">2.</span>
                                <span>Pastikan NIK Anda sudah terdaftar di database HRD</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-blue-600 font-bold mt-0.5">3.</span>
                                <span>Hubungi <strong class="text-blue-600">ESD Team</strong> untuk bantuan lebih lanjut</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Kontak ESD Team -->
                    <div class="bg-blue-50 rounded-xl border border-blue-200 p-3 text-center">
                        <p class="text-xs text-gray-600">
                            Hubungi ESD Team: 
                            <a class="text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors">
                                +62 878-8399-4150
                            </a>
                        </p>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex gap-3 mt-2">
                        <button onclick="closeModal('nikErrorModal')" 
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            Perbaiki NIK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL PERINGATAN WHATSAPP -->
    <!-- ============================================================ -->
    <div id="waWarningModal" class="fixed inset-0 z-[70] flex items-center justify-center p-4 hidden">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300" onclick="closeModal('waWarningModal')"></div>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] relative z-10 border border-gray-200 flex flex-col transform transition-all duration-300 scale-95 opacity-0" id="waWarningModalContent">
            <!-- Header -->
            <div class="flex-shrink-0 px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-red-50 to-red-100 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-red-500 flex items-center justify-center shadow-lg shadow-red-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Format Nomor WhatsApp Salah</h2>
                    </div>
                    <button onclick="closeModal('waWarningModal')" class="text-gray-400 hover:text-gray-600 transition-colors hover:rotate-90 duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-6">
                <div class="space-y-4">
                    <!-- Informasi -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Nomor WhatsApp Tidak Boleh Diawali 0</h3>
                        <p class="text-sm text-gray-500 mt-2">
                            Untuk nomor WhatsApp Indonesia, masukkan nomor setelah kode negara <strong class="text-red-600">+62</strong>
                        </p>
                    </div>

                    <!-- Contoh -->
                    <div class="bg-gray-50 rounded-xl border border-gray-200 p-4">
                        <p class="text-sm font-medium text-gray-700 mb-2">Contoh penulisan yang benar:</p>
                        <div class="space-y-2">
                            <div class="flex items-center gap-3 text-sm">
                                <span class="text-green-600 font-bold">✓</span>
                                <span><span class="font-medium text-gray-700">+62</span> <span class="text-blue-600 font-bold">81234567890</span></span>
                                <span class="text-xs text-gray-400">(tanpa 0 di depan)</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm border-t border-gray-200 pt-2">
                                <span class="text-red-600 font-bold">✗</span>
                                <span><span class="font-medium text-gray-700">+62</span> <span class="text-red-600 font-bold">081234567890</span></span>
                                <span class="text-xs text-red-500">(ada 0 di depan, TIDAK BOLEH)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <button onclick="closeModal('waWarningModal')" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Saya Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL KONFIRMASI WHATSAPP -->
    <!-- ============================================================ -->
    <div id="confirmModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4 hidden">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300" onclick="closeModal('confirmModal')"></div>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] relative z-10 border border-gray-200 flex flex-col transform transition-all duration-300 scale-95 opacity-0" id="confirmModalContent">
            <!-- Header -->
            <div class="flex-shrink-0 px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-blue-100 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center shadow-lg shadow-blue-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Konfirmasi WhatsApp</h2>
                    </div>
                    <button onclick="closeModal('confirmModal')" class="text-gray-400 hover:text-gray-600 transition-colors hover:rotate-90 duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-6">
                <div class="space-y-4">
                    <!-- Informasi -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Periksa Nomor WhatsApp Anda</h3>
                        <p class="text-sm text-gray-500 mt-1">Pastikan nomor di bawah ini sudah benar, karena semua informasi terkait dengan proses akan di kirim melalui WhatsApp</p>
                    </div>

                    <!-- Nomor WhatsApp -->
                    <div class="bg-gray-50 rounded-xl border border-gray-200 p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Nomor WhatsApp</span>
                            <span id="confirmPhoneNumber" class="text-lg font-bold text-blue-600">+62 81234567890</span>
                        </div>
                        <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-200">
                            <span class="text-sm font-medium text-gray-600">NIK</span>
                            <span id="confirmNikNumber" class="text-sm font-bold text-gray-700">220956528</span>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex gap-3 mt-4">
                        <button onclick="confirmWhatsApp()" 
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Benar, Lanjutkan
                        </button>
                        <button onclick="closeModal('confirmModal')" 
                                class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            Salah, Perbaiki
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL TAKE -->
    <!-- ============================================================ -->
    <div id="takeModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300" onclick="closeModal('takeModal')"></div>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] relative z-10 border border-gray-200 flex flex-col transform transition-all duration-300 scale-95 opacity-0" id="takeModalContent">
            <!-- Header -->
            <div class="flex-shrink-0 px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-purple-100 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-500 flex items-center justify-center shadow-lg shadow-purple-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Take Uniform</h2>
                    </div>
                    <button onclick="closeModal('takeModal')" class="text-gray-400 hover:text-gray-600 transition-colors hover:rotate-90 duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-6">
                <!-- Step 1: Input Access Code -->
                <div id="takeStep1" class="animate-fade-in">
                    <div class="flex flex-col lg:flex-row gap-6">
                        <!-- KIRI: Form -->
                        <div class="flex-1 space-y-4">
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Masukkan kode akses yang dikirim via WhatsApp</p>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Kode Akses</label>
                                <input type="text" id="takeAccessCode"
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-center text-2xl font-mono uppercase transition"
                                       placeholder="Contoh: ABCD1234EF">
                                <div id="takeCodeError" class="text-red-500 text-xs mt-1 hidden"></div>
                            </div>

                            <button onclick="checkTakeCode()" 
                                    class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-md hover:shadow-lg">
                                Cek Kode
                            </button>
                        </div>

                        <!-- KANAN: Numpad dengan Huruf -->
                        <div class="flex-1">
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                
                                <!-- Huruf A-Z -->
                                <div class="grid grid-cols-6 gap-1.5 mb-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <button type="button"
                                                onclick="takeKeyPress('<?php echo e($letter); ?>')"
                                                class="bg-white hover:bg-purple-100 text-gray-700 border border-gray-300 py-1.5 rounded-lg font-bold text-sm transition active:scale-95 shadow-sm hover:shadow-md">
                                            <?php echo e($letter); ?>

                                        </button>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>
                                
                                <!-- Angka 0-9 -->
                                <div class="grid grid-cols-5 gap-1.5 mb-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['1','2','3','4','5','6','7','8','9','0']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <button type="button"
                                                onclick="takeKeyPress('<?php echo e($num); ?>')"
                                                class="bg-white hover:bg-purple-100 text-gray-700 border border-gray-300 py-2 rounded-lg font-bold text-lg transition active:scale-95 shadow-sm hover:shadow-md">
                                            <?php echo e($num); ?>

                                        </button>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>
                                
                                <!-- Clear & Backspace -->
                                <div class="grid grid-cols-2 gap-1.5">
                                    <button onclick="takeKeyPress('clear')" 
                                            class="bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-bold text-sm transition active:scale-95 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Clear
                                    </button>
                                    <button onclick="takeKeyPress('backspace')" 
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg font-bold text-sm transition active:scale-95 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z"></path>
                                        </svg>
                                        Backspace
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Transaction Details -->
                <div id="takeStep2" class="hidden animate-fade-in">
                    <div class="space-y-6">
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-5">
                            <h3 class="font-semibold text-purple-800 mb-3 flex items-center gap-2 text-sm">
                                <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center shadow-lg shadow-purple-500/30">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                Detail Transaksi
                            </h3>
                            <div id="takeTransactionData" class="space-y-2 text-sm text-gray-700">
                                <!-- Akan diisi oleh JavaScript -->
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button onclick="submitTake()" 
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                                Buka Locker
                            </button>
                            <button onclick="takeStepBack()" 
                                    class="px-6 bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Success -->
                <div id="takeStep3" class="hidden animate-fade-in">
                    <div class="flex flex-col items-center justify-center py-4">
                        <div class="w-20 h-20 bg-gradient-to-r from-green-400 to-green-500 rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg shadow-green-500/30 animate-bounce-slow">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-xl font-bold text-green-600 mb-1">Locker Berhasil Dibuka!</h3>
                        <p class="text-base text-gray-700 mb-3">
                            Locker <span id="takeLockerCode" class="font-bold text-blue-600"></span> sekarang terbuka
                        </p>
                        
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-3 mb-3 w-full max-w-sm">
                            <div class="flex items-center justify-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-yellow-600 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Pintu akan menutup otomatis dalam <strong id="takeCountdown" class="text-red-600">15</strong> detik</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 text-center">Silakan ambil seragam Anda</p>
                            
                            <!-- Progress Bar -->
                            <div class="mt-2 w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                <div id="takeProgressBar" class="bg-gradient-to-r from-green-500 to-blue-500 h-2 rounded-full transition-all duration-1000" style="width: 100%"></div>
                            </div>
                        </div>

                        <button onclick="closeModal('takeModal')" 
                                class="mt-1 inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 font-medium shadow-md hover:shadow-lg flex items-center justify-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Tutup Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL PERINGATAN KODE AKSES SALAH -->
    <!-- ============================================================ -->
    <div id="takeErrorModal" class="fixed inset-0 z-[70] flex items-center justify-center p-4 hidden">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300" onclick="closeModal('takeErrorModal')"></div>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] relative z-10 border border-gray-200 flex flex-col transform transition-all duration-300 scale-95 opacity-0" id="takeErrorModalContent">
            <!-- Header -->
            <div class="flex-shrink-0 px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-red-50 to-red-100 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-red-500 flex items-center justify-center shadow-lg shadow-red-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Kode Akses Tidak Valid</h2>
                    </div>
                    <button onclick="closeModal('takeErrorModal')" class="text-gray-400 hover:text-gray-600 transition-colors hover:rotate-90 duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-6">
                <div class="space-y-4">
                    <!-- Informasi -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Kode Akses Tidak Ditemukan</h3>
                        <p class="text-sm text-gray-500 mt-2">
                            Kode akses <strong class="text-red-600" id="takeErrorCode">ABCD1234EF</strong> yang Anda masukkan tidak valid.
                        </p>
                    </div>

                    <!-- Saran -->
                    <div class="bg-gray-50 rounded-xl border border-gray-200 p-4">
                        <p class="text-sm font-medium text-gray-700 mb-2">Yang dapat Anda lakukan:</p>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-start gap-3">
                                <span class="text-blue-600 font-bold mt-0.5">1.</span>
                                <span>Periksa kembali kode akses yang Anda masukkan</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-blue-600 font-bold mt-0.5">2.</span>
                                <span>Cek WhatsApp Anda untuk kode akses terbaru</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-blue-600 font-bold mt-0.5">3.</span>
                                <span>Hubungi <strong class="text-blue-600">ESD Team</strong> untuk bantuan lebih lanjut</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Kontak ESD Team -->
                    <div class="bg-blue-50 rounded-xl border border-blue-200 p-3 text-center">
                        <p class="text-xs text-gray-600">
                            Hubungi ESD Team: 
                            <a class="text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors">
                                +62 878-8399-4150
                            </a>
                        </p>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex gap-3 mt-2">
                        <button onclick="closeModal('takeErrorModal')" 
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            Perbaiki Kode
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    <div id="notification" class="fixed bottom-4 right-4 z-50 hidden">
        <div class="text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
            <span id="notificationMessage"></span>
        </div>
    </div>

    <style>
        #takeErrorModal .modal-show {
            animation: modalIn 0.3s ease-out forwards;
        }

        #takeErrorModal .modal-hide {
            animation: modalOut 0.3s ease-in forwards;
        }
        #nikErrorModal .modal-show {
            animation: modalIn 0.3s ease-out forwards;
        }

        #nikErrorModal .modal-hide {
            animation: modalOut 0.3s ease-in forwards;
        }
        #waWarningModal .modal-show {
            animation: modalIn 0.3s ease-out forwards;
        }

        #waWarningModal .modal-hide {
            animation: modalOut 0.3s ease-in forwards;
        }
        .numpad-btn {
            user-select: none;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
            cursor: pointer;
        }
        
        .numpad-btn:active {
            transform: scale(0.92);
        }

        /* Modal Animations */
        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @keyframes modalOut {
            from {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
            to {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }
        }

        .modal-show {
            animation: modalIn 0.3s ease-out forwards;
        }

        .modal-hide {
            animation: modalOut 0.3s ease-in forwards;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.4s ease-out;
        }

        /* Animations */
        @keyframes pulse-slow {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .animate-pulse-slow {
            animation: pulse-slow 2.5s ease-in-out infinite;
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

        /* Scrollbar styling */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Loading spinner */
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #fff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Disabled button */
        .btn-loading {
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>

    <script>
        // ============ VARIABEL ============
        let activeStoreInput = 'nik';
        let pendingStoreData = null;
        let takeCountdownInterval = null;
        let storeCountdownInterval = null;

        // ============ MODAL ANIMATION ============
        function openModal(modalId, contentId) {
            const modal = document.getElementById(modalId);
            const content = document.getElementById(contentId);
            
            if (!modal || !content) return;
            
            modal.classList.remove('hidden');
            content.classList.remove('modal-hide');
            content.classList.add('modal-show');
            
            // Prevent body scroll
            document.body.style.overflow = 'hidden';
            
            // Auto focus ke input pertama setelah modal terbuka
            setTimeout(() => {
                const firstInput = modal.querySelector('input');
                if (firstInput) {
                    firstInput.focus();
                }
            }, 350);
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            
            // Reset countdown jika modal take atau store yang ditutup
            if (modalId === 'takeModal' && takeCountdownInterval) {
                clearInterval(takeCountdownInterval);
                takeCountdownInterval = null;
            }
            if (modalId === 'storeModal' && storeCountdownInterval) {
                clearInterval(storeCountdownInterval);
                storeCountdownInterval = null;
            }
            
            const content = modal.querySelector('.transform');
            if (!content) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                return;
            }
            
            content.classList.remove('modal-show');
            content.classList.add('modal-hide');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        // ============ STORE COUNTDOWN ============
        function startStoreCountdown() {
            let countdown = 15;
            const countdownElement = document.getElementById('storeCountdown');
            const progressBar = document.getElementById('storeProgressBar');
            
            if (storeCountdownInterval) {
                clearInterval(storeCountdownInterval);
                storeCountdownInterval = null;
            }
            
            storeCountdownInterval = setInterval(() => {
                countdown--;
                
                if (countdownElement) {
                    countdownElement.textContent = countdown;
                }
                
                if (progressBar) {
                    const percentage = (countdown / 15) * 100;
                    progressBar.style.width = percentage + '%';
                    
                    if (countdown <= 5) {
                        progressBar.className = 'h-2 rounded-full transition-all duration-1000 bg-gradient-to-r from-red-500 to-orange-500';
                    } else if (countdown <= 10) {
                        progressBar.className = 'h-2 rounded-full transition-all duration-1000 bg-gradient-to-r from-yellow-500 to-orange-500';
                    }
                }
                
                if (countdown <= 0) {
                    clearInterval(storeCountdownInterval);
                    storeCountdownInterval = null;
                    closeModal('storeModal');
                }
            }, 1000);
        }

        // ============ TAKE COUNTDOWN ============
        function startTakeCountdown() {
            let countdown = 15;
            const countdownElement = document.getElementById('takeCountdown');
            const progressBar = document.getElementById('takeProgressBar');
            
            if (takeCountdownInterval) {
                clearInterval(takeCountdownInterval);
                takeCountdownInterval = null;
            }
            
            takeCountdownInterval = setInterval(() => {
                countdown--;
                
                if (countdownElement) {
                    countdownElement.textContent = countdown;
                }
                
                if (progressBar) {
                    const percentage = (countdown / 15) * 100;
                    progressBar.style.width = percentage + '%';
                    
                    if (countdown <= 5) {
                        progressBar.className = 'h-2 rounded-full transition-all duration-1000 bg-gradient-to-r from-red-500 to-orange-500';
                    } else if (countdown <= 10) {
                        progressBar.className = 'h-2 rounded-full transition-all duration-1000 bg-gradient-to-r from-yellow-500 to-orange-500';
                    }
                }
                
                if (countdown <= 0) {
                    clearInterval(takeCountdownInterval);
                    takeCountdownInterval = null;
                    closeModal('takeModal');
                }
            }, 1000);
        }

        // ============ WHATSAPP WARNING ============
        function showWaWarning() {
            openModal('waWarningModal', 'waWarningModalContent');
        }

        // ============ STORE FUNCTIONS ============
        function openStoreModal() {
            openModal('storeModal', 'storeModalContent');
            document.getElementById('storeStep1').classList.remove('hidden');
            document.getElementById('storeStep2').classList.add('hidden');
            document.getElementById('storeStep3').classList.add('hidden');
            document.getElementById('storeNik').value = '';
            document.getElementById('storePhone').value = '';
            document.getElementById('storeNikError').classList.add('hidden');
            document.getElementById('storePhoneError').classList.add('hidden');
            activeStoreInput = 'nik';
            pendingStoreData = null;
            
            // Reset countdown
            if (storeCountdownInterval) {
                clearInterval(storeCountdownInterval);
                storeCountdownInterval = null;
            }
        }

        function storeKeyPress(key) {
            const nikInput = document.getElementById('storeNik');
            const phoneInput = document.getElementById('storePhone');
            
            let targetInput = null;
            
            if (document.activeElement === nikInput) {
                targetInput = nikInput;
                activeStoreInput = 'nik';
            } else if (document.activeElement === phoneInput) {
                targetInput = phoneInput;
                activeStoreInput = 'wa';
            } else {
                if (activeStoreInput === 'nik') {
                    targetInput = nikInput;
                    nikInput.focus();
                } else {
                    targetInput = phoneInput;
                    phoneInput.focus();
                }
            }

            if (key === 'clear') {
                targetInput.value = '';
            } else if (key === 'backspace') {
                targetInput.value = targetInput.value.slice(0, -1);
            } else {
                // VALIDASI: Jika input adalah WhatsApp dan key adalah '0' dan value kosong, tolak
                if (targetInput === phoneInput && key === '0' && phoneInput.value === '') {
                    showWaWarning();
                    return;
                }
                targetInput.value = targetInput.value + key;
            }
            
            targetInput.dispatchEvent(new Event('input'));
            targetInput.focus();
        }

        function checkStoreNik() {
            const nik = document.getElementById('storeNik').value.trim();
            const phone = document.getElementById('storePhone').value.trim();
            
            document.getElementById('storeNikError').classList.add('hidden');
            document.getElementById('storePhoneError').classList.add('hidden');

            if (!nik) {
                document.getElementById('storeNikError').textContent = 'NIK harus diisi';
                document.getElementById('storeNikError').classList.remove('hidden');
                document.getElementById('storeNik').focus();
                return;
            }

            // VALIDASI: Cek apakah nomor WhatsApp dimulai dengan 0
            if (phone.startsWith('0')) {
                document.getElementById('storePhoneError').textContent = 'Nomor WhatsApp tidak boleh diawali 0. Contoh: 81234567890';
                document.getElementById('storePhoneError').classList.remove('hidden');
                document.getElementById('storePhone').focus();
                showWaWarning();
                return;
            }

            if (!phone || phone.length < 10) {
                document.getElementById('storePhoneError').textContent = 'Nomor WhatsApp minimal 10 digit';
                document.getElementById('storePhoneError').classList.remove('hidden');
                document.getElementById('storePhone').focus();
                return;
            }

            const btn = document.querySelector('#storeStep1 .bg-green-600');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="spinner"></span> Memeriksa...';
            btn.disabled = true;
            btn.classList.add('btn-loading');

            const url = '<?php echo e(url("esd/locker/store/check")); ?>';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ nik: nik, phone: phone })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw { status: response.status, data: errorData };
                    });
                }
                return response.json();
            })
            .then(data => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.classList.remove('btn-loading');
                
                if (data.success) {
                    // NIK BENAR - Simpan data dan tampilkan modal konfirmasi WhatsApp
                    pendingStoreData = {
                        nik: nik,
                        phone: phone,
                        employee: data.employee
                    };
                    
                    document.getElementById('confirmPhoneNumber').textContent = '+62 ' + phone;
                    document.getElementById('confirmNikNumber').textContent = nik;
                    openModal('confirmModal', 'confirmModalContent');
                    
                } else {
                    // NIK SALAH / TIDAK TERDAFTAR - Tampilkan modal NIK error
                    document.getElementById('nikErrorNumber').textContent = nik;
                    openModal('nikErrorModal', 'nikErrorModalContent');
                }
            })
            .catch(error => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.classList.remove('btn-loading');
                
                // Jika error dari server (422, dll) karena NIK tidak ditemukan
                if (error.status === 422) {
                    const errorMessage = error.data?.errors?.nik?.[0] || error.data?.message || 'NIK tidak ditemukan';
                    document.getElementById('nikErrorNumber').textContent = nik;
                    openModal('nikErrorModal', 'nikErrorModalContent');
                } else {
                    showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
                }
                console.error('Error:', error);
            });
        }

        function confirmWhatsApp() {
            closeModal('confirmModal');
            
            if (!pendingStoreData) {
                showNotification('Data tidak ditemukan. Silakan coba lagi.', 'error');
                return;
            }
            
            const employeeData = document.getElementById('storeEmployeeData');
            employeeData.innerHTML = `
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="font-medium">NIK</span>
                    <span>${pendingStoreData.employee.nik}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="font-medium">Nama</span>
                    <span>${pendingStoreData.employee.name}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="font-medium">Departemen</span>
                    <span>${pendingStoreData.employee.department}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="font-medium">WhatsApp</span>
                    <span class="text-blue-600 font-bold">+${pendingStoreData.phone}</span>
                </div>
            `;
            
            document.getElementById('storeStep1').classList.add('hidden');
            document.getElementById('storeStep2').classList.remove('hidden');
        }

        function submitStore() {
            if (!pendingStoreData) {
                showNotification('Data tidak ditemukan. Silakan coba lagi.', 'error');
                return;
            }

            const nik = pendingStoreData.nik;
            const phone = pendingStoreData.phone;

            const btn = document.querySelector('#storeStep2 .bg-blue-600');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="spinner"></span> Memproses...';
            btn.disabled = true;
            btn.classList.add('btn-loading');

            fetch('<?php echo e(route("esd.locker.store")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ nik: nik, phone: phone })
            })
            .then(response => response.json())
            .then(data => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.classList.remove('btn-loading');
                
                if (data.success) {
                    document.getElementById('storeLockerCode').textContent = data.locker_code;
                    document.getElementById('storeStep2').classList.add('hidden');
                    document.getElementById('storeStep3').classList.remove('hidden');
                    showNotification(data.message, 'success');
                    pendingStoreData = null;
                    
                    // Start countdown 15 detik untuk store
                    startStoreCountdown();
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.classList.remove('btn-loading');
                showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
                console.error('Error:', error);
            });
        }

        function storeStepBack() {
            document.getElementById('storeStep2').classList.add('hidden');
            document.getElementById('storeStep1').classList.remove('hidden');
            pendingStoreData = null;
        }

        // ============ TAKE FUNCTIONS ============
        function openTakeModal() {
            openModal('takeModal', 'takeModalContent');
            document.getElementById('takeStep1').classList.remove('hidden');
            document.getElementById('takeStep2').classList.add('hidden');
            document.getElementById('takeStep3').classList.add('hidden');
            document.getElementById('takeAccessCode').value = '';
            document.getElementById('takeCodeError').classList.add('hidden');
            
            if (takeCountdownInterval) {
                clearInterval(takeCountdownInterval);
                takeCountdownInterval = null;
            }
        }

        function takeKeyPress(key) {
            const input = document.getElementById('takeAccessCode');
            input.focus();

            if (key === 'clear') {
                input.value = '';
            } else if (key === 'backspace') {
                input.value = input.value.slice(0, -1);
            } else {
                input.value = input.value + key;
            }
        }

        function checkTakeCode() {
            const accessCode = document.getElementById('takeAccessCode').value.trim().toUpperCase();
            
            document.getElementById('takeCodeError').classList.add('hidden');

            if (!accessCode) {
                document.getElementById('takeCodeError').textContent = 'Kode akses harus diisi';
                document.getElementById('takeCodeError').classList.remove('hidden');
                document.getElementById('takeAccessCode').focus();
                return;
            }

            const btn = document.querySelector('#takeStep1 .bg-purple-600');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="spinner"></span> Memeriksa...';
            btn.disabled = true;
            btn.classList.add('btn-loading');

            const url = '<?php echo e(url("esd/locker/take/check")); ?>';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ access_code: accessCode })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw { status: response.status, data: errorData };
                    });
                }
                return response.json();
            })
            .then(data => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.classList.remove('btn-loading');
                
                if (data.success) {
                    const transactionData = document.getElementById('takeTransactionData');
                    transactionData.innerHTML = `
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="font-medium">NIK</span>
                            <span>${data.transaction.nik}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="font-medium">Nama</span>
                            <span>${data.transaction.name}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="font-medium">Departemen</span>
                            <span>${data.transaction.department}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="font-medium">Locker</span>
                            <span class="font-mono font-bold text-blue-600">${data.transaction.locker_code}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="font-medium">Status Locker</span>
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                ${data.transaction.locker_status.replace('_', ' ')}
                            </span>
                        </div>
                    `;
                    
                    document.getElementById('takeStep1').classList.add('hidden');
                    document.getElementById('takeStep2').classList.remove('hidden');
                } else {
                    // KODE AKSES SALAH - Tampilkan modal error
                    document.getElementById('takeErrorCode').textContent = accessCode;
                    openModal('takeErrorModal', 'takeErrorModalContent');
                }
            })
            .catch(error => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.classList.remove('btn-loading');
                
                // Jika error dari server (422, dll)
                if (error.status === 422) {
                    const errorMessage = error.data?.errors?.access_code?.[0] || error.data?.message || 'Kode akses tidak valid';
                    document.getElementById('takeErrorCode').textContent = accessCode;
                    openModal('takeErrorModal', 'takeErrorModalContent');
                } else {
                    showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
                }
                console.error('Error:', error);
            });
        }

        function submitTake() {
            const accessCode = document.getElementById('takeAccessCode').value.trim().toUpperCase();

            const btn = document.querySelector('#takeStep2 .bg-green-600');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="spinner"></span> Memproses...';
            btn.disabled = true;
            btn.classList.add('btn-loading');

            fetch('<?php echo e(route("esd.locker.take")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ access_code: accessCode })
            })
            .then(response => response.json())
            .then(data => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.classList.remove('btn-loading');
                
                if (data.success) {
                    document.getElementById('takeLockerCode').textContent = data.locker_code;
                    document.getElementById('takeStep2').classList.add('hidden');
                    document.getElementById('takeStep3').classList.remove('hidden');
                    showNotification(data.message, 'success');
                    
                    // Start countdown 15 detik untuk take
                    startTakeCountdown();
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.classList.remove('btn-loading');
                showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
                console.error('Error:', error);
            });
        }

        function takeStepBack() {
            document.getElementById('takeStep2').classList.add('hidden');
            document.getElementById('takeStep1').classList.remove('hidden');
        }

        // ============ UTILITY FUNCTIONS ============
        function showNotification(message, type = 'success') {
            const notification = document.getElementById('notification');
            if (!notification) return;
            
            const notificationMessage = document.getElementById('notificationMessage');
            const div = notification.querySelector('div');
            
            notificationMessage.textContent = message;
            notification.className = 'fixed bottom-4 right-4 z-50';
            
            if (type === 'success') {
                div.className = 'text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 bg-green-500';
            } else if (type === 'error') {
                div.className = 'text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 bg-red-500';
            } else {
                div.className = 'text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 bg-yellow-500';
            }
            
            notification.classList.remove('hidden');
            
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 3000);
        }

        // ============ KEYBOARD SHORTCUTS ============
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.querySelectorAll('.fixed.inset-0.z-50, .fixed.inset-0.z-60, .fixed.inset-0.z-70').forEach(modal => {
                    if (!modal.classList.contains('hidden') && modal.id !== 'notification') {
                        const modalId = modal.id;
                        closeModal(modalId);
                    }
                });
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                const storeModal = document.getElementById('storeModal');
                const takeModal = document.getElementById('takeModal');
                const confirmModal = document.getElementById('confirmModal');
                const waWarningModal = document.getElementById('waWarningModal');
                const nikErrorModal = document.getElementById('nikErrorModal');
                const takeErrorModal = document.getElementById('takeErrorModal');
                
                // Jika modal Take error terbuka, tutup
                if (takeErrorModal && !takeErrorModal.classList.contains('hidden')) {
                    closeModal('takeErrorModal');
                    return;
                }
                
                // Jika modal NIK error terbuka, tutup
                if (nikErrorModal && !nikErrorModal.classList.contains('hidden')) {
                    closeModal('nikErrorModal');
                    return;
                }
                
                if (waWarningModal && !waWarningModal.classList.contains('hidden')) {
                    closeModal('waWarningModal');
                    return;
                }
                
                if (confirmModal && !confirmModal.classList.contains('hidden')) {
                    confirmWhatsApp();
                    return;
                }
                
                if (storeModal && !storeModal.classList.contains('hidden')) {
                    if (!document.getElementById('storeStep1').classList.contains('hidden')) {
                        checkStoreNik();
                    } else if (!document.getElementById('storeStep2').classList.contains('hidden')) {
                        submitStore();
                    }
                } else if (takeModal && !takeModal.classList.contains('hidden')) {
                    if (!document.getElementById('takeStep1').classList.contains('hidden')) {
                        checkTakeCode();
                    } else if (!document.getElementById('takeStep2').classList.contains('hidden')) {
                        submitTake();
                    }
                }
            }
        });

        // ============ EVENT LISTENER UNTUK FOCUS INPUT ============
        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('storeNik');
            const phoneInput = document.getElementById('storePhone');
            
            if (nikInput) {
                nikInput.addEventListener('focus', function() {
                    activeStoreInput = 'nik';
                });
            }
            
            if (phoneInput) {
                phoneInput.addEventListener('focus', function() {
                    activeStoreInput = 'wa';
                });
            }
        });
    </script>
</body>
</html><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/resources/views/esd/locker/info.blade.php ENDPATH**/ ?>