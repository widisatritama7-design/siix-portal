<div class="p-1 space-y-2">
    <?php $__env->startSection('title', 'ESD Locker - Information'); ?>
    
    <!-- Breadcrumbs -->
    <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
        <a href="<?php echo e(route('dashboard')); ?>" class="hover:text-blue-600 dark:hover:text-blue-400">Dashboard</a>
        <span>/</span>
        <span class="text-gray-700 dark:text-gray-300">ESD</span>
        <span>/</span>
        <span class="text-blue-600 dark:text-blue-400 font-semibold">Locker Info</span>
    </nav>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                ESD Locker System
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Lihat status loker dan pilih layanan
            </p>
        </div>
    </div>

    <!-- Main Content: 2 Columns -->
    <div class="flex flex-col lg:flex-row gap-4 mt-4">
        <!-- LEFT COLUMN: 70% - Daftar Locker -->
        <div class="w-full lg:w-[70%]">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-800 p-4">

                <!-- Legend Status - CENTER -->
                <div class="mb-4 pb-4 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex flex-wrap items-center justify-center gap-4 text-xs">
                        <div class="flex items-center gap-1.5">
                            <span class="inline-block w-3 h-3 rounded-full bg-green-500"></span>
                            <span class="text-zinc-600 dark:text-zinc-400">Available</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="inline-block w-3 h-3 rounded-full bg-yellow-500"></span>
                            <span class="text-zinc-600 dark:text-zinc-400">Open</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="inline-block w-3 h-3 rounded-full bg-blue-500"></span>
                            <span class="text-zinc-600 dark:text-zinc-400">In Progress</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="inline-block w-3 h-3 rounded-full bg-red-500"></span>
                            <span class="text-zinc-600 dark:text-zinc-400">NG</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="inline-block w-3 h-3 rounded-full bg-gray-500"></span>
                            <span class="text-zinc-600 dark:text-zinc-400">Finished</span>
                        </div>
                    </div>
                </div>

                <!-- Locker Grid -->
                <div class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 lg:grid-cols-7 gap-2 max-h-[450px] overflow-y-auto pr-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $lockers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $locker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $statusColors = [
                            'available' => 'bg-green-500 hover:bg-green-600',
                            'open' => 'bg-yellow-500 hover:bg-yellow-600',
                            'in_progress' => 'bg-blue-500 hover:bg-blue-600',
                            'ng' => 'bg-red-500 hover:bg-red-600',
                            'finished' => 'bg-gray-500 hover:bg-gray-600'
                        ];
                        $statusLabels = [
                            'available' => 'Available',
                            'open' => 'Open',
                            'in_progress' => 'In Progress',
                            'ng' => 'NG',
                            'finished' => 'Finished'
                        ];
                    ?>
                    <div class="rounded-lg <?php echo e($statusColors[$locker->status] ?? 'bg-gray-500'); ?> text-white p-3 text-center font-bold shadow hover:shadow-lg transition-all duration-200 cursor-default">
                        <div class="text-sm">
                            <?php echo e($locker->code); ?>

                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="col-span-full text-center py-8 text-zinc-500 dark:text-zinc-400">
                        No lockers available
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: 30% - Tombol Store & Take -->
        <div class="w-full lg:w-[30%]">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-800 p-4">
                
                <div class="space-y-4">
                    <!-- Button Store -->
                    <button wire:click="openModal('store')" 
                            class="w-full bg-green-500 hover:bg-green-600 text-white rounded-lg p-6 shadow-lg transition duration-200 flex flex-col items-center justify-center">
                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-xl font-bold">Store</span>
                        <span class="text-sm opacity-75">Menyimpan seragam</span>
                    </button>

                    <!-- Button Take -->
                    <button wire:click="openModal('take')" 
                            class="w-full bg-purple-500 hover:bg-purple-600 text-white rounded-lg p-6 shadow-lg transition duration-200 flex flex-col items-center justify-center">
                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                        <span class="text-xl font-bold">Take (Pick Up)</span>
                        <span class="text-sm opacity-75">Mengambil seragam</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL STORE -->
    <!-- ============================================================ -->
    <div x-data="{ 
        open: <?php if ((object) ('modalStore') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('modalStore'->value()); ?>')<?php echo e('modalStore'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('modalStore'); ?>')<?php endif; ?>,
        storeNik: <?php if ((object) ('store_nik') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('store_nik'->value()); ?>')<?php echo e('store_nik'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('store_nik'); ?>')<?php endif; ?>.live || ''
    }" 
        x-show="open" 
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">
        
        <div class="fixed inset-0 bg-black/60" @click="open = false"></div>
        
        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto relative z-10 border border-zinc-200 dark:border-zinc-700">
            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">Store Uniform</h2>
                    </div>
                    <button @click="open = false; $wire.resetStore()" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Step 1: Input NIK -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($store_step == 1): ?>
                    <div class="space-y-6">
                        <div class="text-center">
                            <p class="text-gray-600 dark:text-gray-400">Enter your NIK to start storing your uniform</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">NIK</label>
                            <input type="text" 
                                x-model="storeNik"
                                @input="$wire.set('store_nik', storeNik || '')"
                                class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-zinc-800 dark:text-white text-center text-2xl font-mono tracking-wider transition"
                                placeholder="Enter your NIK">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['store_nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <span class="text-red-500 text-sm mt-1 block"><?php echo e($message); ?></span> 
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <!-- Numpad -->
                        <div class="text-center">
                            <p class="text-xs text-zinc-400 dark:text-zinc-500 mb-2">Or use numpad below</p>
                        </div>
                        <div class="grid grid-cols-3 gap-2 max-w-xs mx-auto">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['1','2','3','4','5','6','7','8','9','clear','0','backspace']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <button type="button"
                                        @click="
                                            if ('<?php echo e($key); ?>' === 'clear') {
                                                storeNik = '';
                                            } else if ('<?php echo e($key); ?>' === 'backspace') {
                                                storeNik = storeNik ? storeNik.slice(0, -1) : '';
                                            } else {
                                                storeNik = (storeNik || '') + '<?php echo e($key); ?>';
                                            }
                                            $wire.set('store_nik', storeNik || '');
                                        "
                                        class="numpad-btn <?php echo e($key === 'clear' ? 'bg-red-500 hover:bg-red-600 text-white' : ($key === 'backspace' ? 'bg-yellow-500 hover:bg-yellow-600 text-white' : 'bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-white')); ?> py-3 rounded-lg font-bold text-xl transition">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($key === 'clear'): ?>
                                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    <?php elseif($key === 'backspace'): ?>
                                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z"></path>
                                        </svg>
                                    <?php else: ?>
                                        <?php echo e($key); ?>

                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </button>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>

                        <button wire:click="checkStoreNik" 
                                wire:loading.attr="disabled"
                                class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-green-600/20">
                            <span wire:loading.remove>Check NIK</span>
                            <span wire:loading>Checking...</span>
                        </button>
                    </div>

                <!-- Step 2: Confirm Employee Data -->
                <?php elseif($store_step == 2): ?>
                    <div class="space-y-6">
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-5">
                            <h3 class="font-semibold text-green-800 dark:text-green-300 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Confirm Employee Data
                            </h3>
                            <div class="space-y-2 text-zinc-700 dark:text-zinc-300">
                                <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                    <span class="font-medium">NIK</span>
                                    <span><?php echo e($store_employee->nik); ?></span>
                                </div>
                                <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                    <span class="font-medium">Name</span>
                                    <span><?php echo e($store_employee->name); ?></span>
                                </div>
                                <div class="flex justify-between py-1">
                                    <span class="font-medium">Department</span>
                                    <span><?php echo e($store_employee->department); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button wire:click="storeUniform" 
                                    wire:loading.attr="disabled"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-blue-600/20">
                                <span wire:loading.remove>Confirm Store</span>
                                <span wire:loading>Processing...</span>
                            </button>
                            <button wire:click="resetStore" 
                                    class="px-6 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 py-3 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600 transition duration-200">
                                Cancel
                            </button>
                        </div>
                    </div>

                <!-- Step 3: Success -->
                <?php else: ?>
                    <div class="text-center py-4">
                        <div class="w-24 h-24 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-green-500/20">
                            <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-green-600 dark:text-green-400 mb-2">Locker Opened!</h3>
                        <p class="text-lg text-zinc-700 dark:text-zinc-300 mb-4">
                            Locker <span class="font-bold text-blue-600 dark:text-blue-400"><?php echo e($locker_code); ?></span> is now open
                        </p>
                        
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-4">
                            <div class="flex items-center justify-center gap-3 text-sm text-zinc-600 dark:text-zinc-400">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Door will close automatically in <strong class="text-red-600 dark:text-red-400">15 seconds</strong></span>
                            </div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2 text-center">Access code has been sent to your WhatsApp</p>
                        </div>

                        <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-xl p-5 mb-6 border border-zinc-200 dark:border-zinc-700">
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Your Access Code</p>
                            <p class="text-3xl font-mono font-bold text-zinc-800 dark:text-white tracking-wider"><?php echo e($access_code); ?></p>
                            <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">Valid for 24 hours</p>
                        </div>

                        <button wire:click="resetStore" 
                                class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg transition duration-200 font-medium shadow-lg shadow-blue-600/20">
                            Close
                        </button>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL TAKE -->
    <!-- ============================================================ -->
    <div x-data="{ 
        open: <?php if ((object) ('modalTake') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('modalTake'->value()); ?>')<?php echo e('modalTake'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('modalTake'); ?>')<?php endif; ?>,
        takeCode: <?php if ((object) ('take_access_code') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('take_access_code'->value()); ?>')<?php echo e('take_access_code'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('take_access_code'); ?>')<?php endif; ?>.live || ''
    }" 
        x-show="open" 
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100">
        
        <div class="fixed inset-0 bg-black/60" @click="open = false"></div>
        
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
                    <button @click="open = false; $wire.resetTake()" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Step 1: Input Access Code -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($take_step == 1): ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['take_access_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <span class="text-red-500 text-sm mt-1 block"><?php echo e($message); ?></span> 
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <!-- Numpad - 3 Baris -->
                        <div class="text-center">
                            <p class="text-xs text-zinc-400 dark:text-zinc-500 mb-2">Or use numpad below</p>
                        </div>
                        
                        <!-- Row 1: A-Z -->
                        <div class="grid grid-cols-9 gap-1.5 max-w-full">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <button type="button"
                                        @click="
                                            takeCode = (takeCode || '') + '<?php echo e($key); ?>';
                                            $wire.set('take_access_code', takeCode || '');
                                        "
                                        class="numpad-btn bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-800 dark:text-white py-2 rounded-lg font-bold text-sm transition">
                                    <?php echo e($key); ?>

                                </button>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>

                        <!-- Row 2: 0-9 -->
                        <div class="grid grid-cols-10 gap-1.5 max-w-full">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['0','1','2','3','4','5','6','7','8','9']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <button type="button"
                                        @click="
                                            takeCode = (takeCode || '') + '<?php echo e($key); ?>';
                                            $wire.set('take_access_code', takeCode || '');
                                        "
                                        class="numpad-btn bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-white py-2 rounded-lg font-bold text-sm transition">
                                    <?php echo e($key); ?>

                                </button>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>

                        <!-- Row 3: Clear & Backspace -->
                        <div class="grid grid-cols-2 gap-1.5 max-w-full">
                            <button type="button"
                                    @click="
                                        takeCode = '';
                                        $wire.set('take_access_code', '');
                                    "
                                    class="numpad-btn bg-red-500 hover:bg-red-600 text-white py-2.5 rounded-lg font-bold text-base transition flex items-center justify-center gap-2">
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
                                    class="numpad-btn bg-yellow-500 hover:bg-yellow-600 text-white py-2.5 rounded-lg font-bold text-base transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z"></path>
                                </svg>
                                Backspace
                            </button>
                        </div>

                        <button wire:click="checkTakeCode" 
                                wire:loading.attr="disabled"
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-purple-600/20">
                            <span wire:loading.remove>Check Code</span>
                            <span wire:loading>Checking...</span>
                        </button>
                    </div>

                <!-- Step 2: Transaction Info -->
                <?php elseif($take_step == 2): ?>
                    <div class="space-y-6">
                        <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-xl p-5">
                            <h3 class="font-semibold text-purple-800 dark:text-purple-300 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Transaction Details
                            </h3>
                            <div class="space-y-2 text-zinc-700 dark:text-zinc-300">
                                <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                    <span class="font-medium">NIK</span>
                                    <span><?php echo e($take_transaction->employee->nik); ?></span>
                                </div>
                                <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                    <span class="font-medium">Name</span>
                                    <span><?php echo e($take_transaction->employee->name); ?></span>
                                </div>
                                <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                    <span class="font-medium">Department</span>
                                    <span><?php echo e($take_transaction->employee->department); ?></span>
                                </div>
                                <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                    <span class="font-medium">Locker</span>
                                    <span class="font-mono font-bold text-blue-600 dark:text-blue-400"><?php echo e($take_transaction->locker->code); ?></span>
                                </div>
                                <div class="flex justify-between py-1">
                                    <span class="font-medium">Locker Status</span>
                                    <?php
                                        $lockerStatusColors = [
                                            'available' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300',
                                            'open' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300',
                                            'in_progress' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300',
                                            'ng' => 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300',
                                            'finished' => 'bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-300'
                                        ];
                                    ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium <?php echo e($lockerStatusColors[$take_transaction->locker->status] ?? 'bg-gray-100 text-gray-800'); ?>">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $take_transaction->locker->status))); ?>

                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button wire:click="openTakeLocker" 
                                    wire:loading.attr="disabled"
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-green-600/20">
                                <span wire:loading.remove>Open Locker</span>
                                <span wire:loading>Processing...</span>
                            </button>
                            <button wire:click="resetTake" 
                                    class="px-6 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 py-3 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600 transition duration-200">
                                Cancel
                            </button>
                        </div>
                    </div>

                <!-- Step 3: Success -->
                <?php else: ?>
                    <div class="text-center py-4">
                        <div class="w-24 h-24 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-green-500/20">
                            <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-green-600 dark:text-green-400 mb-2">Locker Opened!</h3>
                        <p class="text-lg text-zinc-700 dark:text-zinc-300 mb-4">
                            Locker <span class="font-bold text-blue-600 dark:text-blue-400"><?php echo e($take_transaction->locker->code); ?></span> is now open
                        </p>
                        
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-6">
                            <div class="flex items-center justify-center gap-3 text-sm text-zinc-600 dark:text-zinc-400">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Door will close automatically in <strong class="text-red-600 dark:text-red-400">15 seconds</strong></span>
                            </div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2 text-center">Please take your uniform</p>
                        </div>

                        <button wire:click="resetTake" 
                                class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg transition duration-200 font-medium shadow-lg shadow-blue-600/20">
                            Close
                        </button>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
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
        
        /* Dark mode override */
        .dark .numpad-btn {
            border-color: rgba(255,255,255,0.05);
        }

        /* Responsive untuk layar kecil */
        @media (max-width: 640px) {
            .numpad-btn {
                font-size: 11px;
                min-height: 34px;
                padding: 4px 2px;
            }
        }
    </style>
</div><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/resources/views/livewire/esd/locker/locker-info.blade.php ENDPATH**/ ?>