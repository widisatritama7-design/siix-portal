<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs}:{/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/index.blade.php}:{1776985208} ?>
<div class="p-1 space-y-2">
    <?php $__env->startSection('title', 'Locker Management - ESD System'); ?>
    
    <!-- Breadcrumbs -->
    <?php ob_start(); ?><div class="flex" data-flux-breadcrumbs>
    <?php ob_start(); ?>
        <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php', $__blaze->compiledPath.'/028777b3eb06dbd0c29b11890d068895.php'); ?>
<?php if (isset($__slots028777b3eb06dbd0c29b11890d068895)) { $__slotsStack028777b3eb06dbd0c29b11890d068895[] = $__slots028777b3eb06dbd0c29b11890d068895; } ?>
<?php if (isset($__attrs028777b3eb06dbd0c29b11890d068895)) { $__attrsStack028777b3eb06dbd0c29b11890d068895[] = $__attrs028777b3eb06dbd0c29b11890d068895; } ?>
<?php $__attrs028777b3eb06dbd0c29b11890d068895 = ['href' => e(route('dashboard')),'wire:navigate' => true,'separator' => 'slash']; ?>
<?php $__slots028777b3eb06dbd0c29b11890d068895 = []; ?>
<?php $__blaze->pushData($__attrs028777b3eb06dbd0c29b11890d068895); ?>
<?php ob_start(); ?>
            Dashboard
        <?php $__slots028777b3eb06dbd0c29b11890d068895['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots028777b3eb06dbd0c29b11890d068895); ?>
<?php _028777b3eb06dbd0c29b11890d068895($__blaze, $__attrs028777b3eb06dbd0c29b11890d068895, $__slots028777b3eb06dbd0c29b11890d068895, ['wire:navigate'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack028777b3eb06dbd0c29b11890d068895)) { $__slots028777b3eb06dbd0c29b11890d068895 = array_pop($__slotsStack028777b3eb06dbd0c29b11890d068895); } ?>
<?php if (! empty($__attrsStack028777b3eb06dbd0c29b11890d068895)) { $__attrs028777b3eb06dbd0c29b11890d068895 = array_pop($__attrsStack028777b3eb06dbd0c29b11890d068895); } ?>
<?php $__blaze->popData(); ?>
        <?php ob_start(); ?><div class="flex items-center text-sm font-medium group/breadcrumb font-semibold text-blue-600 dark:text-blue-400" data-flux-breadcrumbs-item>
            <div class="text-gray-500 dark:text-white/80">
                            <?php ob_start(); ?>
            ESD
        <?php echo trim(ob_get_clean()); ?>

                    </div>
    
    <!--[if BLOCK]><![endif]-->        <svg class="shrink-0 [:where(&amp;)]:size-5 mx-1 text-zinc-300 dark:text-white/80 group-last/breadcrumb:hidden rtl:-scale-x-100" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M12.528 3.047a.75.75 0 0 1 .449.961L8.433 16.504a.75.75 0 1 1-1.41-.512l4.544-12.496a.75.75 0 0 1 .961-.449Z" clip-rule="evenodd"/>
</svg>

            <!--[if ENDBLOCK]><![endif]--></div>
<?php echo ltrim(ob_get_clean()); ?>
        <?php ob_start(); ?><div class="flex items-center text-sm font-medium group/breadcrumb font-semibold text-blue-600 dark:text-blue-400" data-flux-breadcrumbs-item>
            <div class="text-gray-500 dark:text-white/80">
                            <?php ob_start(); ?>
            Lockers
        <?php echo trim(ob_get_clean()); ?>

                    </div>
    
    <!--[if BLOCK]><![endif]-->        <svg class="shrink-0 [:where(&amp;)]:size-5 mx-1 text-zinc-300 dark:text-white/80 group-last/breadcrumb:hidden rtl:-scale-x-100" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M12.528 3.047a.75.75 0 0 1 .449.961L8.433 16.504a.75.75 0 1 1-1.41-.512l4.544-12.496a.75.75 0 0 1 .961-.449Z" clip-rule="evenodd"/>
</svg>

            <!--[if ENDBLOCK]><![endif]--></div>
<?php echo ltrim(ob_get_clean()); ?>
    <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Locker Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage ESD lockers and monitor status
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

                <!-- Locker Grid - Tanpa scroll -->
                <div class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 lg:grid-cols-7 gap-2">
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
                    <div wire:click="viewDetail(<?php echo e($locker->id); ?>)"
                        x-on:click="$dispatch('open-modal', 'locker-detail-modal')"
                        class="rounded-lg <?php echo e($statusColors[$locker->status] ?? 'bg-gray-500'); ?> text-white p-3 text-center font-bold shadow hover:shadow-lg transition-all duration-200 cursor-pointer group relative hover:scale-105">
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

        <!-- RIGHT COLUMN: 30% - Actions -->
        <div class="w-full lg:w-[30%]">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-800 p-4">
                <h2 class="text-sm font-bold text-zinc-800 dark:text-white mb-3 uppercase tracking-wider">Quick Actions</h2>
                
                <div class="space-y-2">

                    <!-- Button Teknisi Take -->
                    <button wire:click="resetTeknisiTakeForm"
                            x-on:click="$dispatch('open-modal', 'teknisi-take-modal')"
                            class="w-full bg-purple-500 hover:bg-purple-600 text-white rounded-lg p-3 shadow transition duration-200 flex items-center gap-3 justify-start">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm10.72 4.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H9a.75.75 0 0 1 0-1.5h10.94l-1.72-1.72a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                        <div class="flex flex-col items-start">
                            <span class="text-sm font-semibold">Teknisi Take</span>
                            <span class="text-[10px] opacity-75">Ambil seragam untuk dicek</span>
                        </div>
                    </button>

                    <!-- Button Teknisi Return -->
                    <button wire:click="resetReturnForm"
                            x-on:click="$dispatch('open-modal', 'teknisi-return-modal')"
                            class="w-full bg-green-500 hover:bg-green-600 text-white rounded-lg p-3 shadow transition duration-200 flex items-center gap-3 justify-start">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm5.03 4.72a.75.75 0 0 1 0 1.06l-1.72 1.72h10.94a.75.75 0 0 1 0 1.5H10.81l1.72 1.72a.75.75 0 1 1-1.06 1.06l-3-3a.75.75 0 0 1 0-1.06l3-3a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                        </svg>
                        <div class="flex flex-col items-start">
                            <span class="text-sm font-semibold">Teknisi Return</span>
                            <span class="text-[10px] opacity-75">Kembalikan seragam</span>
                        </div>
                    </button>

                    <!-- Button NG (Reject) -->
                    <button wire:click="resetNgForm"
                            x-on:click="$dispatch('open-modal', 'ng-action-modal')"
                            class="w-full bg-red-500 hover:bg-red-600 text-white rounded-lg p-3 shadow transition duration-200 flex items-center gap-3 justify-start">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                        </svg>
                        <div class="flex flex-col items-start">
                            <span class="text-sm font-semibold">Mark as NG</span>
                            <span class="text-[10px] opacity-75">Reject locker (Not Good)</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL FORM LOCKER -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'locker-form-modal') open = true"
         @close-modal.window="if ($event.detail === 'locker-form-modal') open = false"
         x-cloak>

        <div class="fixed inset-0 bg-black/60 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-md border border-zinc-200 dark:border-zinc-700">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-zinc-800 dark:text-white"><?php echo e($modalTitle); ?></h2>
                        <button @click="open = false" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit="save">
                        <!-- Locker Code -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Locker Code</label>
                            <input type="text" 
                                   wire:model="code"
                                   class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:text-white"
                                   placeholder="e.g. LKR001">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Status</label>
                            <select wire:model="status"
                                    class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:text-white">
                                <option value="">Select Status</option>
                                <option value="available">Available</option>
                                <option value="open">Open</option>
                                <option value="in_progress">In Progress</option>
                                <option value="ng">NG</option>
                                <option value="finished">Finished</option>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-2 mt-6">
                            <button type="button" 
                                    @click="open = false"
                                    class="px-4 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <?php echo e($locker_id ? 'Update' : 'Create'); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL LOCKER -->    
    <div x-data="{ open: false }" 
        x-show="open" 
        @open-modal.window="if ($event.detail === 'locker-detail-modal') open = true"
        @close-modal.window="if ($event.detail === 'locker-detail-modal') open = false"
        x-cloak>

        <div class="fixed inset-0 bg-black/60 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[85vh] overflow-y-auto border border-zinc-200 dark:border-zinc-700">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-lg">
                                <?php echo e($selectedLocker ? substr($selectedLocker->code, -3) : '--'); ?>

                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-zinc-800 dark:text-white">Locker Detail</h2>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">ID: #<?php echo e($selectedLocker->id ?? '-'); ?></p>
                            </div>
                        </div>
                        <button @click="open = false" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedLocker): ?>
                        <div class="space-y-6">
                            <!-- Locker Info Card -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-5 border border-blue-200 dark:border-blue-800">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <!-- Code -->
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-blue-500/10 dark:bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Code</p>
                                            <p class="text-base font-bold text-zinc-800 dark:text-white"><?php echo e($selectedLocker->code); ?></p>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-green-500/10 dark:bg-green-500/20 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Status</p>
                                            <?php
                                                $statusColors = [
                                                    'available' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300',
                                                    'open' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300',
                                                    'in_progress' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
                                                    'ng' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
                                                    'finished' => 'bg-gray-100 dark:bg-gray-900/30 text-gray-700 dark:text-gray-300'
                                                ];
                                            ?>
                                            <span class="px-3 py-0.5 rounded-full text-xs font-semibold <?php echo e($statusColors[$selectedLocker->status] ?? 'bg-gray-100 text-gray-700'); ?>">
                                                <?php echo e(ucfirst(str_replace('_', ' ', $selectedLocker->status))); ?>

                                            </span>
                                        </div>
                                    </div>

                                    <!-- Employee -->
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-purple-500/10 dark:bg-purple-500/20 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Employee</p>
                                            <p class="text-sm font-semibold text-zinc-800 dark:text-white truncate">
                                                <?php echo e($selectedLocker->employee->name ?? '-'); ?>

                                            </p>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedLocker->employee): ?>
                                                <p class="text-xs text-zinc-500 dark:text-zinc-400">NIK: <?php echo e($selectedLocker->employee->nik); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Locked Until -->
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-orange-500/10 dark:bg-orange-500/20 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Locked Until</p>
                                            <p class="text-sm font-semibold text-zinc-800 dark:text-white">
                                                <?php echo e($selectedLocker->locked_until ? $selectedLocker->locked_until->format('d/m/Y H:i') : '-'); ?>

                                            </p>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedLocker->locked_until): ?>
                                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                    <?php echo e($selectedLocker->locked_until->diffForHumans()); ?>

                                                </p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Transactions -->
                            <div>
                                <div class="flex justify-between items-center mb-3">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <h3 class="font-semibold text-lg text-zinc-800 dark:text-white">Recent Transactions</h3>
                                    </div>
                                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-3 py-1 rounded-full whitespace-nowrap">
                                        Total: <?php echo e($transactions->total()); ?>

                                    </span>
                                </div>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transactions->count() > 0): ?>
                                    <div class="overflow-x-auto border border-zinc-200 dark:border-zinc-700 rounded-xl">
                                        <table class="w-full text-sm whitespace-nowrap">
                                            <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                                                <tr>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">#</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">NIK</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Name</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Department</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Type</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                                        <?php echo e($transactions->firstItem() + $index); ?>

                                                    </td>
                                                    <td class="px-4 py-3 text-sm font-mono text-zinc-600 dark:text-zinc-300 whitespace-nowrap">
                                                        <?php echo e($transaction->employee->nik ?? '-'); ?>

                                                    </td>
                                                    <td class="px-4 py-3 font-medium text-zinc-800 dark:text-white whitespace-nowrap">
                                                        <?php echo e($transaction->employee->name ?? '-'); ?>

                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                                        <?php echo e($transaction->employee->department ?? '-'); ?>

                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <span class="px-2 py-1 rounded-full text-xs font-medium whitespace-nowrap
                                                            <?php echo e($transaction->type == 'store' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300'); ?>">
                                                            <?php echo e(ucfirst($transaction->type)); ?>

                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <?php
                                                            $transStatusColors = [
                                                                'pending' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
                                                                'on_progress' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300',
                                                                'waiting_pickup' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300',
                                                                'completed' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300'
                                                            ];
                                                        ?>
                                                        <span class="px-2 py-1 rounded-full text-xs font-medium whitespace-nowrap <?php echo e($transStatusColors[$transaction->status] ?? 'bg-gray-100 text-gray-700'); ?>">
                                                            <?php echo e(ucfirst(str_replace('_', ' ', $transaction->status))); ?>

                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                                        <?php echo e($transaction->created_at->format('d/m/Y H:i')); ?>

                                                    </td>
                                                </tr>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <!-- Pagination for Transactions -->
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transactions->hasPages()): ?>
                                    <div class="mt-4">
                                        <?php echo e($transactions->links()); ?>

                                    </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php else: ?>
                                    <div class="text-center py-8 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700">
                                        <svg class="w-12 h-12 text-zinc-400 dark:text-zinc-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">No transactions found</p>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <!-- Footer -->
                    <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-3">
                        <!-- Tombol Print Thermal -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedLocker && $selectedLocker->transactions->count() > 0): ?>
                            <?php
                                $latestTransaction = $selectedLocker->transactions->first();
                            ?>
                            <a href="<?php echo e(route('esd.print-label-thermal', ['id' => $latestTransaction->id])); ?>" 
                            target="_blank"
                            class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-medium flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                </svg>
                                Print Thermal
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        
                        <button @click="open = false" 
                                class="px-6 py-2.5 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600 transition-colors font-medium">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL NG ACTION (Dengan Input Access Code) -->
    <!-- ============================================================ -->
    <div x-data="{ open: false }" 
        x-show="open" 
        @open-modal.window="if ($event.detail === 'ng-action-modal') open = true"
        @close-modal.window="if ($event.detail === 'ng-action-modal') open = false"
        x-cloak>

        <div class="fixed inset-0 bg-black/60 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto border border-zinc-200 dark:border-zinc-700">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">Mark as NG</h2>
                        </div>
                        <button @click="open = false" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Step 1: Input Access Code -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ngStep == 1): ?>
                        <div class="space-y-6">
                            <div class="text-center">
                                <p class="text-gray-600 dark:text-gray-400">Enter the access code to mark locker as NG</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Access Code</label>
                                <input type="text" 
                                    wire:model="ngAccessCode"
                                    wire:keydown.enter="ngCheckCode"
                                    class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-center text-2xl font-mono uppercase dark:bg-zinc-800 dark:text-white transition"
                                    placeholder="e.g. ABCD1234EF">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['ngAccessCode'];
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

                            <button wire:click="ngCheckCode" 
                                    wire:loading.attr="disabled"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-red-600/20">
                                <span wire:loading.remove>Check Code</span>
                                <span wire:loading>Checking...</span>
                            </button>
                        </div>

                    <!-- Step 2: Konfirmasi NG -->
                    <?php elseif($ngStep == 2): ?>
                        <div class="space-y-6">
                            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-semibold text-red-800 dark:text-red-300">Warning: This action cannot be undone!</p>
                                        <p class="text-sm text-red-700 dark:text-red-400 mt-1">
                                            You are about to mark locker <strong><?php echo e($ngLockerData?->code ?? '-'); ?></strong> as NG (Not Good).
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                                <h4 class="text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">Locker Information</h4>
                                <div class="space-y-1 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-zinc-500 dark:text-zinc-400">Code</span>
                                        <span class="font-medium text-zinc-800 dark:text-white"><?php echo e($ngLockerData?->code ?? '-'); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-zinc-500 dark:text-zinc-400">Current Status</span>
                                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $ngLockerData?->status ?? '-'))); ?>

                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-zinc-500 dark:text-zinc-400">Employee</span>
                                        <span class="font-medium text-zinc-800 dark:text-white"><?php echo e($ngLockerData?->employee?->name ?? '-'); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-zinc-500 dark:text-zinc-400">New Status</span>
                                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300">
                                            NG
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Reason (Optional)</label>
                                <textarea wire:model="ngReason" 
                                        rows="3"
                                        class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-zinc-800 dark:text-white resize-none"
                                        placeholder="Enter reason for marking as NG..."></textarea>
                            </div>

                            <div class="flex gap-3">
                                <button wire:click="ngConfirm" 
                                        wire:loading.attr="disabled"
                                        class="flex-1 bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-red-600/20">
                                    <span wire:loading.remove>Yes, Mark as NG</span>
                                    <span wire:loading>Processing...</span>
                                </button>
                                <button @click="open = false; $wire.resetNgForm()" 
                                        class="px-6 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 py-3 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600 transition duration-200">
                                    Cancel
                                </button>
                            </div>
                        </div>

                    <!-- Step 3: Sukses -->
                    <?php elseif($ngStep == 3): ?>
                        <div class="text-center">
                            <div class="w-24 h-24 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-red-500/20">
                                <svg class="w-12 h-12 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            
                            <h3 class="text-2xl font-bold text-red-600 dark:text-red-400 mb-2">Marked as NG!</h3>
                            <p class="text-lg text-zinc-700 dark:text-zinc-300 mb-4">
                                Locker <span class="font-bold text-red-600 dark:text-red-400"><?php echo e($ngLockerData?->code ?? '-'); ?></span> has been marked as NG
                            </p>
                            
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-6">
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">✅ Locker status has been updated to <strong class="text-red-600 dark:text-red-400">NG</strong></p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ngReason): ?>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2">Reason: <?php echo e($ngReason); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <button wire:click="resetNgForm" 
                                    @click="open = false"
                                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg transition duration-200 font-medium shadow-lg shadow-blue-600/20">
                                Close
                            </button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL TEKNISI TAKE (Ambil Seragam untuk Dicek) -->
    <!-- ============================================================ -->
    <div x-data="{ open: false }" 
        x-show="open" 
        @open-modal.window="if ($event.detail === 'teknisi-take-modal') open = true"
        @close-modal.window="if ($event.detail === 'teknisi-take-modal') open = false"
        x-cloak>

        <div class="fixed inset-0 bg-black/60 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto border border-zinc-200 dark:border-zinc-700">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">Teknisi - Ambil Seragam</h2>
                        </div>
                        <button @click="open = false; $wire.resetTeknisiTakeForm()" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Step 1: Input Access Code -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($teknisiTakeStep == 1): ?>
                        <div class="space-y-6">
                            <div class="text-center">
                                <p class="text-gray-600 dark:text-gray-400">Scan or enter the access code from the label</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Access Code</label>
                                <input type="text" 
                                    wire:model="teknisiTakeAccessCode"
                                    wire:keydown.enter="teknisiTakeCheckCode"
                                    class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center text-2xl font-mono uppercase dark:bg-zinc-800 dark:text-white transition"
                                    placeholder="e.g. ABCD1234EF">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['teknisiTakeAccessCode'];
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

                            <button wire:click="teknisiTakeCheckCode" 
                                    wire:loading.attr="disabled"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-blue-600/20">
                                <span wire:loading.remove>Check Code</span>
                                <span wire:loading>Checking...</span>
                            </button>
                        </div>

                    <!-- Step 2: Print Label -->
                    <?php elseif($teknisiTakeStep == 2): ?>
                        <div class="space-y-6">
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-5">
                                <h3 class="font-semibold text-blue-800 dark:text-blue-300 mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Transaction Details
                                </h3>
                                <div class="space-y-2 text-zinc-700 dark:text-zinc-300">
                                    <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                        <span class="font-medium">NIK</span>
                                        <span><?php echo e($teknisiTakeTransaction->employee->nik ?? '-'); ?></span>
                                    </div>
                                    <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                        <span class="font-medium">Name</span>
                                        <span><?php echo e($teknisiTakeTransaction->employee->name ?? '-'); ?></span>
                                    </div>
                                    <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                        <span class="font-medium">Department</span>
                                        <span><?php echo e($teknisiTakeTransaction->employee->department ?? '-'); ?></span>
                                    </div>
                                    <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                        <span class="font-medium">Locker</span>
                                        <span class="font-mono font-bold text-blue-600 dark:text-blue-400"><?php echo e($teknisiTakeTransaction->locker->code ?? '-'); ?></span>
                                    </div>
                                    <div class="flex justify-between py-1">
                                        <span class="font-medium">Status</span>
                                        <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 rounded text-sm">
                                            Pending (Menunggu Pengecekan)
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4 text-center border border-zinc-200 dark:border-zinc-700">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Access Code for Print</p>
                                <div class="text-2xl font-mono font-bold bg-white dark:bg-zinc-900 p-3 rounded-lg border border-gray-300 dark:border-gray-600">
                                    <?php echo e($teknisiTakeTransaction->access_code ?? '-'); ?>

                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Scan this code to open the locker</p>
                            </div>

                            <div class="flex gap-3">
                                <button wire:click="teknisiTakePrintLabel" 
                                        wire:loading.attr="disabled"
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-green-600/20">
                                    <span wire:loading.remove>🖨️ Print Label & Open Locker</span>
                                    <span wire:loading>⏳ Processing...</span>
                                </button>
                                <button wire:click="resetTeknisiTakeForm" 
                                        class="px-6 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 py-3 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600 transition duration-200">
                                    Cancel
                                </button>
                            </div>
                        </div>

                    <!-- Step 3: Buka Loker -->
                    <?php elseif($teknisiTakeStep == 3): ?>
                        <div class="text-center space-y-6">
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4">
                                <p class="text-yellow-700 dark:text-yellow-300">📋 Label printed. Click below to open the locker.</p>
                            </div>

                            <div class="bg-zinc-50 dark:bg-zinc-800 rounded-xl p-8 border border-zinc-200 dark:border-zinc-700">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-blue-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Locker will open when you click the button below</p>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <button wire:click="teknisiTakeScanAndOpen" 
                                        wire:loading.attr="disabled"
                                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-blue-600/20">
                                    <span wire:loading.remove>🔓 Open Locker</span>
                                    <span wire:loading>⏳ Processing...</span>
                                </button>
                                <button wire:click="resetTeknisiTakeForm" 
                                        class="px-6 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 py-3 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600 transition duration-200">
                                    Cancel
                                </button>
                            </div>
                        </div>

                    <!-- Step 4: Sukses -->
                    <?php elseif($teknisiTakeStep == 4): ?>
                        <div class="text-center">
                            <div class="w-24 h-24 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-green-500/20">
                                <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            
                            <h3 class="text-2xl font-bold text-green-600 dark:text-green-400 mb-2">Locker Opened!</h3>
                            <p class="text-lg text-zinc-700 dark:text-zinc-300 mb-4">
                                Locker <span class="font-bold text-blue-600 dark:text-blue-400"><?php echo e($teknisiTakeTransaction->locker->code ?? '-'); ?></span> is now open
                            </p>
                            
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-6">
                                <div class="flex items-center justify-center gap-3 text-sm text-zinc-600 dark:text-zinc-400">
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Door will close automatically in <strong class="text-red-600 dark:text-red-400">15 seconds</strong></span>
                                </div>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2 text-center">Take the uniform for checking</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2 text-center">📱 Notification sent to user's WhatsApp</p>
                            </div>

                            <button wire:click="resetTeknisiTakeForm" 
                                    @click="open = false"
                                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg transition duration-200 font-medium shadow-lg shadow-blue-600/20">
                                Close
                            </button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL TEKNISI RETURN (Kembalikan Seragam) -->
    <!-- ============================================================ -->
    <div x-data="{ open: false }" 
        x-show="open" 
        @open-modal.window="if ($event.detail === 'teknisi-return-modal') open = true"
        @close-modal.window="if ($event.detail === 'teknisi-return-modal') open = false"
        x-cloak>

        <div class="fixed inset-0 bg-black/60 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto border border-zinc-200 dark:border-zinc-700">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">Teknisi - Kembalikan Seragam</h2>
                        </div>
                        <button @click="open = false; $wire.resetReturnForm()" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Step 1: Input Kode Akses -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($returnStep == 1): ?>
                        <div class="space-y-6">
                            <div class="text-center">
                                <p class="text-gray-600 dark:text-gray-400">Scan or enter the access code from the printed label</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Access Code</label>
                                <input type="text" 
                                    wire:model="returnAccessCode"
                                    wire:keydown.enter="returnCheckCode"
                                    class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-center text-2xl font-mono uppercase dark:bg-zinc-800 dark:text-white transition"
                                    placeholder="e.g. ABCD1234EF">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['returnAccessCode'];
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

                            <button wire:click="returnCheckCode" 
                                    wire:loading.attr="disabled"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-green-600/20">
                                <span wire:loading.remove>Check Code</span>
                                <span wire:loading>Checking...</span>
                            </button>
                        </div>

                    <!-- Step 2: Konfirmasi -->
                    <?php elseif($returnStep == 2): ?>
                        <div class="space-y-6">
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-5">
                                <h3 class="font-semibold text-blue-800 dark:text-blue-300 mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Transaction Details
                                </h3>
                                <div class="space-y-2 text-zinc-700 dark:text-zinc-300">
                                    <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                        <span class="font-medium">NIK</span>
                                        <span><?php echo e($returnTransaction->employee->nik ?? '-'); ?></span>
                                    </div>
                                    <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                        <span class="font-medium">Name</span>
                                        <span><?php echo e($returnTransaction->employee->name ?? '-'); ?></span>
                                    </div>
                                    <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                        <span class="font-medium">Department</span>
                                        <span><?php echo e($returnTransaction->employee->department ?? '-'); ?></span>
                                    </div>
                                    <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                        <span class="font-medium">Locker</span>
                                        <span class="font-mono font-bold text-blue-600 dark:text-blue-400"><?php echo e($returnTransaction->locker->code ?? '-'); ?></span>
                                    </div>
                                    <div class="flex justify-between py-1">
                                        <span class="font-medium">Status</span>
                                        <span class="px-2 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300 rounded text-sm">
                                            On Progress
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
                                <p class="text-sm text-green-700 dark:text-green-300">✅ Uniform has been checked. Click below to return it.</p>
                            </div>

                            <div class="flex gap-3">
                                <button wire:click="returnUniform" 
                                        wire:loading.attr="disabled"
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-green-600/20">
                                    <span wire:loading.remove>📥 Return Uniform</span>
                                    <span wire:loading>⏳ Processing...</span>
                                </button>
                                <button wire:click="resetReturnForm" 
                                        class="px-6 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 py-3 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600 transition duration-200">
                                    Cancel
                                </button>
                            </div>
                        </div>

                    <!-- Step 3: Sukses -->
                    <?php elseif($returnStep == 3): ?>
                        <div class="text-center">
                            <div class="w-24 h-24 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-green-500/20">
                                <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            
                            <h3 class="text-2xl font-bold text-green-600 dark:text-green-400 mb-2">Locker Opened!</h3>
                            <p class="text-lg text-zinc-700 dark:text-zinc-300 mb-4">
                                Locker <span class="font-bold text-blue-600 dark:text-blue-400"><?php echo e($returnTransaction->locker->code ?? '-'); ?></span> is now open
                            </p>
                            
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-6">
                                <div class="flex items-center justify-center gap-3 text-sm text-zinc-600 dark:text-zinc-400">
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Door will close automatically in <strong class="text-red-600 dark:text-red-400">15 seconds</strong></span>
                                </div>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2 text-center">Please store the checked uniform</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2 text-center">📱 Notification sent to user's WhatsApp</p>
                            </div>

                            <button wire:click="resetReturnForm" 
                                    @click="open = false"
                                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg transition duration-200 font-medium shadow-lg shadow-blue-600/20">
                                Close
                            </button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'delete-locker-modal') open = true"
         @close-modal.window="if ($event.detail === 'delete-locker-modal') open = false"
         x-cloak>

        <div class="fixed inset-0 bg-black/60 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-md p-6 text-center border border-zinc-200 dark:border-zinc-700">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>

                <h3 class="text-lg font-bold text-zinc-800 dark:text-white mb-2">Delete Locker</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Are you sure you want to delete locker "<?php echo e($lockerToDelete?->code); ?>"? This action cannot be undone.
                </p>

                <div class="flex justify-center gap-3">
                    <button @click="open = false" 
                            class="px-4 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="delete" 
                            @click="open = false"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Yes, Delete
                    </button>
                </div>
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
        
        /* Scrollbar styling */
        .overflow-y-auto::-webkit-scrollbar {
            width: 4px;
        }
        .overflow-y-auto::-webkit-scrollbar-track {
            background: transparent;
        }
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 2px;
        }
        .dark .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #475569;
        }
    </style>
</div><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/resources/views/livewire/esd/locker/locker-management.blade.php ENDPATH**/ ?>