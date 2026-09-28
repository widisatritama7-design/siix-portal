<section class="w-full" 
         x-data="{ 
             currentStep: 0, 
             steps: [
                { number: 1, name: 'GENERAL', complete: false, hasError: false },
                { number: 2, name: 'LOADER', complete: false, hasError: false },
                { number: 3, name: 'PCB CLEANER', complete: false, hasError: false },
                { number: 4, name: 'PRINTING', complete: false, hasError: false },
                { number: 5, name: 'SPI', complete: false, hasError: false },
                { number: 6, name: 'CHIP MOUNTER 1', complete: false, hasError: false },
                { number: 7, name: 'CHIP MOUNTER 2', complete: false, hasError: false },
                { number: 8, name: 'REFLOW', complete: false, hasError: false },
                { number: 9, name: 'AOI', complete: false, hasError: false },
                { number: 10, name: 'UNLOADER', complete: false, hasError: false },
                { number: 11, name: 'AOI TABLE', complete: false, hasError: false },
                { number: 12, name: 'REFLOW 2', complete: false, hasError: false },
                { number: 13, name: 'CHIP MOUNTER 3', complete: false, hasError: false },
                { number: 14, name: 'CHIP MOUNTER 4', complete: false, hasError: false },
                { number: 15, name: 'SPI 2', complete: false, hasError: false },
                { number: 16, name: 'PRINTER', complete: false, hasError: false },
                { number: 17, name: 'PCB CLEANER 2', complete: false, hasError: false },
                { number: 18, name: 'IONIZER', complete: false, hasError: false },
                { number: 19, name: 'TIME & STATUS', complete: false, hasError: false }
             ]
         }">

    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/heading.blade.php', $__blaze->compiledPath.'/c4bf0adaf25764df57f7bf033913f226.php'); ?>
<?php if (isset($__slotsc4bf0adaf25764df57f7bf033913f226)) { $__slotsStackc4bf0adaf25764df57f7bf033913f226[] = $__slotsc4bf0adaf25764df57f7bf033913f226; } ?>
<?php if (isset($__attrsc4bf0adaf25764df57f7bf033913f226)) { $__attrsStackc4bf0adaf25764df57f7bf033913f226[] = $__attrsc4bf0adaf25764df57f7bf033913f226; } ?>
<?php $__attrsc4bf0adaf25764df57f7bf033913f226 = ['class' => 'sr-only']; ?>
<?php $__slotsc4bf0adaf25764df57f7bf033913f226 = []; ?>
<?php $__blaze->pushData($__attrsc4bf0adaf25764df57f7bf033913f226); ?>
<?php ob_start(); ?>
        <?php echo e(__('MTC - Edit Daily Panasonic Inspection')); ?>

    <?php $__slotsc4bf0adaf25764df57f7bf033913f226['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsc4bf0adaf25764df57f7bf033913f226); ?>
<?php _c4bf0adaf25764df57f7bf033913f226($__blaze, $__attrsc4bf0adaf25764df57f7bf033913f226, $__slotsc4bf0adaf25764df57f7bf033913f226, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackc4bf0adaf25764df57f7bf033913f226)) { $__slotsc4bf0adaf25764df57f7bf033913f226 = array_pop($__slotsStackc4bf0adaf25764df57f7bf033913f226); } ?>
<?php if (! empty($__attrsStackc4bf0adaf25764df57f7bf033913f226)) { $__attrsc4bf0adaf25764df57f7bf033913f226 = array_pop($__attrsStackc4bf0adaf25764df57f7bf033913f226); } ?>
<?php $__blaze->popData(); ?>

    <?php if (isset($component)) { $__componentOriginal2991782b15caf2333143ee45e5bacc85 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2991782b15caf2333143ee45e5bacc85 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.mtc.layout','data' => ['class' => '!max-w-full !px-0 !mx-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mtc.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => '!max-w-full !px-0 !mx-0']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

         <?php $__env->slot('heading', null, []); ?> 
            <div class="w-full">
                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/index.blade.php', $__blaze->compiledPath.'/1e35f51f541becda0d52ebb99ca1a4c0.php'); ?>
<?php if (isset($__slots1e35f51f541becda0d52ebb99ca1a4c0)) { $__slotsStack1e35f51f541becda0d52ebb99ca1a4c0[] = $__slots1e35f51f541becda0d52ebb99ca1a4c0; } ?>
<?php if (isset($__attrs1e35f51f541becda0d52ebb99ca1a4c0)) { $__attrsStack1e35f51f541becda0d52ebb99ca1a4c0[] = $__attrs1e35f51f541becda0d52ebb99ca1a4c0; } ?>
<?php $__attrs1e35f51f541becda0d52ebb99ca1a4c0 = ['class' => 'mb-1']; ?>
<?php $__slots1e35f51f541becda0d52ebb99ca1a4c0 = []; ?>
<?php $__blaze->pushData($__attrs1e35f51f541becda0d52ebb99ca1a4c0); ?>
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
                    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php', $__blaze->compiledPath.'/028777b3eb06dbd0c29b11890d068895.php'); ?>
<?php if (isset($__slots028777b3eb06dbd0c29b11890d068895)) { $__slotsStack028777b3eb06dbd0c29b11890d068895[] = $__slots028777b3eb06dbd0c29b11890d068895; } ?>
<?php if (isset($__attrs028777b3eb06dbd0c29b11890d068895)) { $__attrsStack028777b3eb06dbd0c29b11890d068895[] = $__attrs028777b3eb06dbd0c29b11890d068895; } ?>
<?php $__attrs028777b3eb06dbd0c29b11890d068895 = ['separator' => 'slash','class' => 'font-semibold text-blue-600 dark:text-blue-400']; ?>
<?php $__slots028777b3eb06dbd0c29b11890d068895 = []; ?>
<?php $__blaze->pushData($__attrs028777b3eb06dbd0c29b11890d068895); ?>
<?php ob_start(); ?>
                        Maintenance
                    <?php $__slots028777b3eb06dbd0c29b11890d068895['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots028777b3eb06dbd0c29b11890d068895); ?>
<?php _028777b3eb06dbd0c29b11890d068895($__blaze, $__attrs028777b3eb06dbd0c29b11890d068895, $__slots028777b3eb06dbd0c29b11890d068895, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack028777b3eb06dbd0c29b11890d068895)) { $__slots028777b3eb06dbd0c29b11890d068895 = array_pop($__slotsStack028777b3eb06dbd0c29b11890d068895); } ?>
<?php if (! empty($__attrsStack028777b3eb06dbd0c29b11890d068895)) { $__attrs028777b3eb06dbd0c29b11890d068895 = array_pop($__attrsStack028777b3eb06dbd0c29b11890d068895); } ?>
<?php $__blaze->popData(); ?>
                    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php', $__blaze->compiledPath.'/028777b3eb06dbd0c29b11890d068895.php'); ?>
<?php if (isset($__slots028777b3eb06dbd0c29b11890d068895)) { $__slotsStack028777b3eb06dbd0c29b11890d068895[] = $__slots028777b3eb06dbd0c29b11890d068895; } ?>
<?php if (isset($__attrs028777b3eb06dbd0c29b11890d068895)) { $__attrsStack028777b3eb06dbd0c29b11890d068895[] = $__attrs028777b3eb06dbd0c29b11890d068895; } ?>
<?php $__attrs028777b3eb06dbd0c29b11890d068895 = ['href' => e(route('mtc.master-lines')),'wire:navigate' => true,'separator' => 'slash']; ?>
<?php $__slots028777b3eb06dbd0c29b11890d068895 = []; ?>
<?php $__blaze->pushData($__attrs028777b3eb06dbd0c29b11890d068895); ?>
<?php ob_start(); ?>
                        Master Line
                    <?php $__slots028777b3eb06dbd0c29b11890d068895['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots028777b3eb06dbd0c29b11890d068895); ?>
<?php _028777b3eb06dbd0c29b11890d068895($__blaze, $__attrs028777b3eb06dbd0c29b11890d068895, $__slots028777b3eb06dbd0c29b11890d068895, ['wire:navigate'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack028777b3eb06dbd0c29b11890d068895)) { $__slots028777b3eb06dbd0c29b11890d068895 = array_pop($__slotsStack028777b3eb06dbd0c29b11890d068895); } ?>
<?php if (! empty($__attrsStack028777b3eb06dbd0c29b11890d068895)) { $__attrs028777b3eb06dbd0c29b11890d068895 = array_pop($__attrsStack028777b3eb06dbd0c29b11890d068895); } ?>
<?php $__blaze->popData(); ?>
                    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php', $__blaze->compiledPath.'/028777b3eb06dbd0c29b11890d068895.php'); ?>
<?php if (isset($__slots028777b3eb06dbd0c29b11890d068895)) { $__slotsStack028777b3eb06dbd0c29b11890d068895[] = $__slots028777b3eb06dbd0c29b11890d068895; } ?>
<?php if (isset($__attrs028777b3eb06dbd0c29b11890d068895)) { $__attrsStack028777b3eb06dbd0c29b11890d068895[] = $__attrs028777b3eb06dbd0c29b11890d068895; } ?>
<?php $__attrs028777b3eb06dbd0c29b11890d068895 = ['href' => e(route('mtc.master-lines.show', $masterLineId)),'wire:navigate' => true,'separator' => 'slash']; ?>
<?php $__slots028777b3eb06dbd0c29b11890d068895 = []; ?>
<?php $__blaze->pushData($__attrs028777b3eb06dbd0c29b11890d068895); ?>
<?php ob_start(); ?>
                        Line <?php echo e($masterLine->line_number); ?>

                    <?php $__slots028777b3eb06dbd0c29b11890d068895['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots028777b3eb06dbd0c29b11890d068895); ?>
<?php _028777b3eb06dbd0c29b11890d068895($__blaze, $__attrs028777b3eb06dbd0c29b11890d068895, $__slots028777b3eb06dbd0c29b11890d068895, ['wire:navigate'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack028777b3eb06dbd0c29b11890d068895)) { $__slots028777b3eb06dbd0c29b11890d068895 = array_pop($__slotsStack028777b3eb06dbd0c29b11890d068895); } ?>
<?php if (! empty($__attrsStack028777b3eb06dbd0c29b11890d068895)) { $__attrs028777b3eb06dbd0c29b11890d068895 = array_pop($__attrsStack028777b3eb06dbd0c29b11890d068895); } ?>
<?php $__blaze->popData(); ?>
                    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php', $__blaze->compiledPath.'/028777b3eb06dbd0c29b11890d068895.php'); ?>
<?php if (isset($__slots028777b3eb06dbd0c29b11890d068895)) { $__slotsStack028777b3eb06dbd0c29b11890d068895[] = $__slots028777b3eb06dbd0c29b11890d068895; } ?>
<?php if (isset($__attrs028777b3eb06dbd0c29b11890d068895)) { $__attrsStack028777b3eb06dbd0c29b11890d068895[] = $__attrs028777b3eb06dbd0c29b11890d068895; } ?>
<?php $__attrs028777b3eb06dbd0c29b11890d068895 = ['separator' => 'slash','class' => 'font-semibold text-blue-600 dark:text-blue-400']; ?>
<?php $__slots028777b3eb06dbd0c29b11890d068895 = []; ?>
<?php $__blaze->pushData($__attrs028777b3eb06dbd0c29b11890d068895); ?>
<?php ob_start(); ?>
                        Create Daily Panasonic
                    <?php $__slots028777b3eb06dbd0c29b11890d068895['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots028777b3eb06dbd0c29b11890d068895); ?>
<?php _028777b3eb06dbd0c29b11890d068895($__blaze, $__attrs028777b3eb06dbd0c29b11890d068895, $__slots028777b3eb06dbd0c29b11890d068895, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack028777b3eb06dbd0c29b11890d068895)) { $__slots028777b3eb06dbd0c29b11890d068895 = array_pop($__slotsStack028777b3eb06dbd0c29b11890d068895); } ?>
<?php if (! empty($__attrsStack028777b3eb06dbd0c29b11890d068895)) { $__attrs028777b3eb06dbd0c29b11890d068895 = array_pop($__attrsStack028777b3eb06dbd0c29b11890d068895); } ?>
<?php $__blaze->popData(); ?>
                <?php $__slots1e35f51f541becda0d52ebb99ca1a4c0['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots1e35f51f541becda0d52ebb99ca1a4c0); ?>
<?php _1e35f51f541becda0d52ebb99ca1a4c0($__blaze, $__attrs1e35f51f541becda0d52ebb99ca1a4c0, $__slots1e35f51f541becda0d52ebb99ca1a4c0, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack1e35f51f541becda0d52ebb99ca1a4c0)) { $__slots1e35f51f541becda0d52ebb99ca1a4c0 = array_pop($__slotsStack1e35f51f541becda0d52ebb99ca1a4c0); } ?>
<?php if (! empty($__attrsStack1e35f51f541becda0d52ebb99ca1a4c0)) { $__attrs1e35f51f541becda0d52ebb99ca1a4c0 = array_pop($__attrsStack1e35f51f541becda0d52ebb99ca1a4c0); } ?>
<?php $__blaze->popData(); ?>
            </div>
         <?php $__env->endSlot(); ?>
        
         <?php $__env->slot('subheading', null, []); ?> 
            <div class="w-full">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="w-full sm:w-auto">
                        <h1 class="text-2xl sm:text-3xl font-bold text-zinc-800 dark:text-white">
                            Edit Daily Panasonic Inspection
                        </h1>
                        <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            Update new inspection record for line <?php echo e($masterLine->line_number); ?>

                            <span class="inline-flex items-center ml-2 px-2 py-0.5 rounded-full text-xs font-medium
                                <?php if($masterLine->status === 'Running'): ?> bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                <?php elseif($masterLine->status === 'Maintenance'): ?> bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                <?php elseif($masterLine->status === 'No Schedule'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                <?php else: ?> bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 <?php endif; ?>">
                                <?php echo e($masterLine->status); ?>

                            </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($masterLine->status === 'No Schedule'): ?>
                                <span class="ml-2 text-xs text-blue-600 dark:text-blue-400">(N/A allowed)</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer): ?>
                                <span class="inline-flex items-center ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    Customer: <?php echo e($customer); ?>

                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                    </div>
                    <div class="w-full sm:w-auto flex-shrink-0">
                        <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php', $__blaze->compiledPath.'/487eed12f4c62537fd888f693822b25a.php'); ?>
<?php if (isset($__slots487eed12f4c62537fd888f693822b25a)) { $__slotsStack487eed12f4c62537fd888f693822b25a[] = $__slots487eed12f4c62537fd888f693822b25a; } ?>
<?php if (isset($__attrs487eed12f4c62537fd888f693822b25a)) { $__attrsStack487eed12f4c62537fd888f693822b25a[] = $__attrs487eed12f4c62537fd888f693822b25a; } ?>
<?php $__attrs487eed12f4c62537fd888f693822b25a = ['href' => e(route('mtc.master-lines.show', $masterLineId)),'wire:navigate' => true,'icon' => 'arrow-left','variant' => 'primary','color' => 'blue','class' => 'w-full sm:w-auto justify-center']; ?>
<?php $__slots487eed12f4c62537fd888f693822b25a = []; ?>
<?php $__blaze->pushData($__attrs487eed12f4c62537fd888f693822b25a); ?>
<?php ob_start(); ?>
                            Back to Line Detail
                        <?php $__slots487eed12f4c62537fd888f693822b25a['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots487eed12f4c62537fd888f693822b25a); ?>
<?php _487eed12f4c62537fd888f693822b25a($__blaze, $__attrs487eed12f4c62537fd888f693822b25a, $__slots487eed12f4c62537fd888f693822b25a, ['wire:navigate'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack487eed12f4c62537fd888f693822b25a)) { $__slots487eed12f4c62537fd888f693822b25a = array_pop($__slotsStack487eed12f4c62537fd888f693822b25a); } ?>
<?php if (! empty($__attrsStack487eed12f4c62537fd888f693822b25a)) { $__attrs487eed12f4c62537fd888f693822b25a = array_pop($__attrsStack487eed12f4c62537fd888f693822b25a); } ?>
<?php $__blaze->popData(); ?>
                    </div>
                </div>
            </div>
         <?php $__env->endSlot(); ?>
        
        <div class="-mt-2">
            <form wire:submit="save">
                <!-- Status Judgement Card -->
                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden mb-6']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                    <div class="<?php echo e($overallStatus === 'success' ? 'bg-green-600' : 'bg-red-600'); ?> dark:<?php echo e($overallStatus === 'success' ? 'bg-green-500' : 'bg-red-500'); ?> px-6 py-4">
                        <div class="flex items-center gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($overallStatus === 'success'): ?>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/check-circle.blade.php', $__blaze->compiledPath.'/2dca92a692a5fd5a005881121e5e1a7a.php'); ?>
<?php $__blaze->pushData(['class' => 'w-5 h-5 text-white']); ?>
<?php _2dca92a692a5fd5a005881121e5e1a7a($__blaze, ['class' => 'w-5 h-5 text-white'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                            <?php else: ?>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/x-circle.blade.php', $__blaze->compiledPath.'/18c0cd280826d8c0a7b7fdb693882854.php'); ?>
<?php $__blaze->pushData(['class' => 'w-5 h-5 text-white']); ?>
<?php _18c0cd280826d8c0a7b7fdb693882854($__blaze, ['class' => 'w-5 h-5 text-white'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <h3 class="font-semibold text-base text-white">
                                <?php echo e($overallStatus === 'success' ? 'All Parameters Valid' : 'Incomplete / Invalid Parameters'); ?>

                            </h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-sm <?php echo e($overallStatus === 'success' ? 'text-green-700 dark:text-green-400' : 'text-red-700 dark:text-red-400'); ?>">
                            <?php echo e($overallStatusText); ?>

                        </p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($overallStatus === 'success'): ?>
                            <p class="text-xs text-green-600 dark:text-green-500 mt-2">
                                Status akan otomatis berubah menjadi "Checked" ketika semua parameter terisi dengan benar.
                            </p>
                        <?php else: ?>
                            <p class="text-xs text-red-600 dark:text-red-500 mt-2">
                                Lengkapi semua field yang diperlukan untuk menyelesaikan inspection.
                            </p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>

                <!-- MAIN LAYOUT: 2 KOLOM -->
                <div class="flex flex-col lg:flex-row gap-6">
                    
                    <!-- LEFT: NAVIGATION STEPS -->
                    <div class="lg:w-72 flex-shrink-0">
                        <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                            <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-4 py-3">
                                <h4 class="text-sm font-semibold text-white flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                    </svg>
                                    Steps Navigation
                                </h4>
                            </div>
                            <div class="p-3 max-h-[600px] overflow-y-auto scrollbar-hide hover:scrollbar-show">
                                <template x-for="(step, index) in steps" :key="index">
                                    <button 
                                        type="button"
                                        @click="currentStep = index"
                                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 mb-1"
                                        :class="{
                                            'bg-blue-600 text-white shadow-lg shadow-blue-600/20': currentStep === index,
                                            'hover:bg-zinc-100 dark:hover:bg-zinc-700': currentStep !== index
                                        }"
                                    >
                                        <!-- Step Number dengan Status -->
                                        <span class="relative flex h-8 w-8 items-center justify-center rounded-full text-xs font-bold flex-shrink-0"
                                            :class="{
                                                'bg-white/20 text-white': currentStep === index,
                                                'bg-green-500 text-white': step.complete && currentStep !== index,
                                                'bg-red-500 text-white': step.hasError && currentStep !== index,
                                                'bg-zinc-200 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400': !step.complete && !step.hasError && currentStep !== index
                                            }">
                                            <template x-if="step.complete && currentStep !== index">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </template>
                                            <template x-if="step.hasError && currentStep !== index">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </template>
                                            <template x-if="(!step.complete && !step.hasError) || currentStep === index">
                                                <span x-text="step.number"></span>
                                            </template>
                                        </span>
                                        
                                        <div class="flex-1 text-left">
                                            <span class="block text-xs font-medium truncate"
                                                :class="{
                                                    'text-white': currentStep === index,
                                                    'text-zinc-600 dark:text-zinc-300': currentStep !== index
                                                }"
                                                x-text="step.name">
                                            </span>
                                            <span class="text-[10px] font-medium"
                                                :class="{
                                                    'text-white/70': currentStep === index,
                                                    'text-green-600 dark:text-green-400': step.complete && currentStep !== index,
                                                    'text-red-600 dark:text-red-400': step.hasError && currentStep !== index,
                                                    'text-zinc-400 dark:text-zinc-500': !step.complete && !step.hasError && currentStep !== index
                                                }">
                                                <template x-if="step.complete && currentStep !== index">✅ Complete</template>
                                                <template x-if="step.hasError && currentStep !== index">❌ Error</template>
                                                <template x-if="!step.complete && !step.hasError && currentStep !== index">⏳ Pending</template>
                                                <template x-if="currentStep === index">▶ Active</template>
                                            </span>
                                        </div>
                                        
                                        <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200"
                                            :class="{
                                                'text-white rotate-90': currentStep === index,
                                                'text-zinc-300 dark:text-zinc-600': currentStep !== index
                                            }"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </template>
                            </div>
                        <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                    </div>
                    
                    <!-- RIGHT: FORM CONTENT -->
                    <div class="flex-1 min-w-0">
                        <div class="space-y-6">
                            
                            <!-- STEP 1: GENERAL -->
                            <div x-show="currentStep === 0" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">1</span>
                                            <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">GENERAL</h3>
                                        </div>
                                    </div>
                                    <div class="p-6 space-y-4">
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Body Cover
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('body_cover')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Make sure all machine cover clean | Standard : No Dust and clean</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="body_cover" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('body_cover') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('body_cover') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="body_cover" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('body_cover') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('body_cover') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Lamp Alarm & Change Model
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('lamp_alarm_change_model')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Make sure lamp Alarm & Change Model Lamp clean | Standard : No Dust and clean</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="lamp_alarm_change_model" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('lamp_alarm_change_model') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('lamp_alarm_change_model') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="lamp_alarm_change_model" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('lamp_alarm_change_model') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('lamp_alarm_change_model') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-end">
                                        <button type="button" @click="currentStep = 1" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                                            Next Step →
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <!-- STEP 2: LOADER -->
                            <div x-show="currentStep === 1" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">2</span>
                                            <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">LOADER</h3>
                                        </div>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Cylinder (1)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('cylinder')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Operation And center | Standard : Smooth and center</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="cylinder" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('cylinder') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('cylinder') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="cylinder" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('cylinder') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('cylinder') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Rail & Magazine PCB (1.a)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('rail_and_magazine_pcb')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Cleaning Dust and dirty | Standard : No Dust and clean</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="rail_and_magazine_pcb" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('rail_and_magazine_pcb') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('rail_and_magazine_pcb') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="rail_and_magazine_pcb" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('rail_and_magazine_pcb') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('rail_and_magazine_pcb') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Cover Magazine (1.b)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('cover_magazine')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Cleaning Dust and dirty | Standard : No Dust and clean</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="cover_magazine" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('cover_magazine') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('cover_magazine') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="cover_magazine" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('cover_magazine') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('cover_magazine') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                                        <button type="button" @click="currentStep = 0" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                            ← Previous
                                        </button>
                                        <button type="button" @click="currentStep = 2" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                                            Next Step →
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <!-- STEP 3: PCB CLEANER -->
                            <div x-show="currentStep === 2" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">3</span>
                                            <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">PCB CLEANER</h3>
                                        </div>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Brush (2)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('brush')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Cleaning touch PCB | Standard : Rotation</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="brush" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('brush') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('brush') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="brush" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('brush') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('brush') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Air Pressure (2.a)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('air_presure')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.45 - 0.54 Mpa</p>
                                            <input type="text" 
                                                   wire:model.live="air_presure" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('air_presure', $air_presure)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('air_presure') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('air_presure', $air_presure); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $air_presure !== null && $air_presure !== '' && !$this->isFieldDisabled('air_presure')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Vacume Pressure Unitech (2.b)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('vacume_presure_unitech')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.45 - 0.54 Mpa (Unitech only)</p>
                                            <input type="text" 
                                                   wire:model.live="vacume_presure_unitech" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('vacume_presure_unitech', $vacume_presure_unitech)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('vacume_presure_unitech') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('vacume_presure_unitech', $vacume_presure_unitech); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $vacume_presure_unitech !== null && $vacume_presure_unitech !== '' && !$this->isFieldDisabled('vacume_presure_unitech')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Vacume Pressure Nix (2.c)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('vacume_presure_nix')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.60 - 0.70 Mpa (N.I.X only)</p>
                                            <input type="text" 
                                                   wire:model.live="vacume_presure_nix" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('vacume_presure_nix', $vacume_presure_nix)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('vacume_presure_nix') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('vacume_presure_nix', $vacume_presure_nix); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $vacume_presure_nix !== null && $vacume_presure_nix !== '' && !$this->isFieldDisabled('vacume_presure_nix')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Vacume Brush (3)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('vacume_brush')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Operation | Standard : Rotation</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="vacume_brush" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('vacume_brush') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('vacume_brush') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="vacume_brush" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('vacume_brush') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('vacume_brush') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Cleaning Roller (4)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('cleaning_roller')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Rotation and Cleaning | Standard : Smooth rotation & Clean</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="cleaning_roller" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('cleaning_roller') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('cleaning_roller') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="cleaning_roller" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('cleaning_roller') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('cleaning_roller') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Ionizer (5)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('ionizer')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Cleaning | Standard : 5 Times to push cleaner</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="ionizer" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('ionizer') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('ionizer') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="ionizer" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('ionizer') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('ionizer') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Air Pressure Ionizer (5.a)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('ionizer_air_presure')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">
                                                Details On Check : Check With Pressure Meter | Standard : 0.05 Mpa - 0.10 Mpa
                                            </p>
                                            <input type="text" 
                                                wire:model.live="ionizer_air_presure" 
                                                placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('ionizer_air_presure', $ionizer_air_presure)); ?>" 
                                                <?php echo e($this->isFieldDisabled('ionizer_air_presure') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('ionizer_air_presure', $ionizer_air_presure); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $ionizer_air_presure !== null && $ionizer_air_presure !== '' && !$this->isFieldDisabled('ionizer_air_presure')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Conveyor Setting (6)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('conveyor_speed')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Analog panel (write value) | Standard : ≤ 40</p>
                                            <input type="text" 
                                                   wire:model.live="conveyor_speed" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('conveyor_speed', $conveyor_speed)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('conveyor_speed') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('conveyor_speed', $conveyor_speed); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $conveyor_speed !== null && $conveyor_speed !== '' && !$this->isFieldDisabled('conveyor_speed')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                                        <button type="button" @click="currentStep = 1" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                            ← Previous
                                        </button>
                                        <button type="button" @click="currentStep = 3" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                                            Next Step →
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <!-- STEP 4: PRINTING -->
                            <div x-show="currentStep === 3" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">4</span>
                                            <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">PRINTING</h3>
                                        </div>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                IPA Solvent (7)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('ipa_solvent')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Make sure solvent (IPA) minimal on mid level (half) | Standard : Tank Minimal half</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="ipa_solvent" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('ipa_solvent') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('ipa_solvent') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="ipa_solvent" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('ipa_solvent') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('ipa_solvent') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Temperature Control (8)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('temperature_control_1')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Result-01 | Standard : 23-27℃</p>
                                            <input type="text" 
                                                   wire:model.live="temperature_control_1" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('temperature_control_1', $temperature_control_1)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('temperature_control_1') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('temperature_control_1', $temperature_control_1); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $temperature_control_1 !== null && $temperature_control_1 !== '' && !$this->isFieldDisabled('temperature_control_1')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Humidity Control (8.a)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('humidity_control_1')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Result-01 | Standard : 35 % - 70 %</p>
                                            <input type="text" 
                                                   wire:model.live="humidity_control_1" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('humidity_control_1', $humidity_control_1)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('humidity_control_1') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('humidity_control_1', $humidity_control_1); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $humidity_control_1 !== null && $humidity_control_1 !== '' && !$this->isFieldDisabled('humidity_control_1')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Clamp Pressure SP-60 (9)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('clamp_presure_sp_60')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.20 ~ 0.4 Mpa</p>
                                            <input type="text" 
                                                   wire:model.live="clamp_presure_sp_60" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('clamp_presure_sp_60', $clamp_presure_sp_60)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('clamp_presure_sp_60') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('clamp_presure_sp_60', $clamp_presure_sp_60); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $clamp_presure_sp_60 !== null && $clamp_presure_sp_60 !== '' && !$this->isFieldDisabled('clamp_presure_sp_60')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Clamp Pressure SPG-2 (9)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('clamp_presure_spg_2')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.20 ~ 0.4 Mpa</p>
                                            <input type="text" 
                                                   wire:model.live="clamp_presure_spg_2" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('clamp_presure_spg_2', $clamp_presure_spg_2)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('clamp_presure_spg_2') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('clamp_presure_spg_2', $clamp_presure_spg_2); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $clamp_presure_spg_2 !== null && $clamp_presure_spg_2 !== '' && !$this->isFieldDisabled('clamp_presure_spg_2')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Squeege SP-60 (10)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('squeege_sp_60')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.19 ~ 0.21 Mpa</p>
                                            <input type="text" 
                                                   wire:model.live="squeege_sp_60" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('squeege_sp_60', $squeege_sp_60)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('squeege_sp_60') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('squeege_sp_60', $squeege_sp_60); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $squeege_sp_60 !== null && $squeege_sp_60 !== '' && !$this->isFieldDisabled('squeege_sp_60')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Squeege SPG-2 (10)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('squeege_spg_2')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.11 ~ 0.13 Mpa</p>
                                            <input type="text" 
                                                   wire:model.live="squeege_spg_2" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('squeege_spg_2', $squeege_spg_2)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('squeege_spg_2') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('squeege_spg_2', $squeege_spg_2); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $squeege_spg_2 !== null && $squeege_spg_2 !== '' && !$this->isFieldDisabled('squeege_spg_2')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Cleaning Solvent (11)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('cleaning_solvent')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.19 ~ 0.21 Mpa</p>
                                            <input type="text" 
                                                   wire:model.live="cleaning_solvent" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('cleaning_solvent', $cleaning_solvent)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('cleaning_solvent') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('cleaning_solvent', $cleaning_solvent); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $cleaning_solvent !== null && $cleaning_solvent !== '' && !$this->isFieldDisabled('cleaning_solvent')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Air Pressure Meter (12)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('air_presure_meter')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.50~ 0.55 Mpa</p>
                                            <input type="text" 
                                                   wire:model.live="air_presure_meter" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('air_presure_meter', $air_presure_meter)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('air_presure_meter') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('air_presure_meter', $air_presure_meter); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $air_presure_meter !== null && $air_presure_meter !== '' && !$this->isFieldDisabled('air_presure_meter')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                                        <button type="button" @click="currentStep = 2" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                            ← Previous
                                        </button>
                                        <button type="button" @click="currentStep = 4" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                                            Next Step →
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <!-- STEP 5: SPI -->
                            <div x-show="currentStep === 4" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">5</span>
                                            <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">SPI</h3>
                                        </div>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Air Pressure Meter Parmi (12.a)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('air_presure_meter_parmi')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.40 - 0.50 Mpa (PARMI)</p>
                                            <input type="text" 
                                                   wire:model.live="air_presure_meter_parmi" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('air_presure_meter_parmi', $air_presure_meter_parmi)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('air_presure_meter_parmi') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('air_presure_meter_parmi', $air_presure_meter_parmi); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $air_presure_meter_parmi !== null && $air_presure_meter_parmi !== '' && !$this->isFieldDisabled('air_presure_meter_parmi')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Capability Index (12.b)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('capability_index')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check SPI Measurement result with Master Jig (Solder Paste height) (write CpK value) | Standard : CpK for Masspro > 1.33</p>
                                            <input type="text" 
                                                   wire:model.live="capability_index" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('capability_index', $capability_index)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('capability_index') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('capability_index', $capability_index); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $capability_index !== null && $capability_index !== '' && !$this->isFieldDisabled('capability_index')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                                        <button type="button" @click="currentStep = 3" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                            ← Previous
                                        </button>
                                        <button type="button" @click="currentStep = 5" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                                            Next Step →
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <!-- STEP 6: CHIP MOUNTER 1 -->
                            <div x-show="currentStep === 5" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">6</span>
                                            <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">CHIP MOUNTER 1</h3>
                                        </div>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Air Pressure Supply (13)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('air_presure_supply')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.49 ~ 0.54 Mpa</p>
                                            <input type="text" 
                                                   wire:model.live="air_presure_supply" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('air_presure_supply', $air_presure_supply)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('air_presure_supply') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('air_presure_supply', $air_presure_supply); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $air_presure_supply !== null && $air_presure_supply !== '' && !$this->isFieldDisabled('air_presure_supply')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Vaccuum Pump (13.a)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('vaccuum_pump')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : -87 ~ -100 Kpa</p>
                                            <input type="text" 
                                                   wire:model.live="vaccuum_pump" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('vaccuum_pump', $vaccuum_pump)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('vaccuum_pump') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('vaccuum_pump', $vaccuum_pump); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $vaccuum_pump !== null && $vaccuum_pump !== '' && !$this->isFieldDisabled('vaccuum_pump')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Box (13.b)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('box')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Chip collection | Standard : No components</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="box" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('box') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('box') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="box" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('box') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('box') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Vaccuum Parameter (13.c)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('vaccuum_parameter')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with machine parameter result | Standard : No Yellow initial (display)</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="vaccuum_parameter" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('vaccuum_parameter') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('vaccuum_parameter') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="vaccuum_parameter" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('vaccuum_parameter') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('vaccuum_parameter') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Expire Date (14)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('expire_date')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Make sure due date on the label | Standard : No Expired</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="expire_date" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('expire_date') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('expire_date') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="expire_date" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('expire_date') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('expire_date') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                                        <button type="button" @click="currentStep = 4" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                            ← Previous
                                        </button>
                                        <button type="button" @click="currentStep = 6" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                                            Next Step →
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <!-- STEP 7: CHIP MOUNTER 2 -->
                            <div x-show="currentStep === 6" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">7</span>
                                            <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">CHIP MOUNTER 2</h3>
                                        </div>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Air Pressure Supply (15)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('air_presure_supply_2')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.49 ~ 0.54 Mpa</p>
                                            <input type="text" 
                                                   wire:model.live="air_presure_supply_2" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('air_presure_supply_2', $air_presure_supply_2)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('air_presure_supply_2') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('air_presure_supply_2', $air_presure_supply_2); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $air_presure_supply_2 !== null && $air_presure_supply_2 !== '' && !$this->isFieldDisabled('air_presure_supply_2')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Vaccuum Pump (15.a)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('vaccuum_pump_2')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : -87 ~ -100 Kpa</p>
                                            <input type="text" 
                                                   wire:model.live="vaccuum_pump_2" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('vaccuum_pump_2', $vaccuum_pump_2)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('vaccuum_pump_2') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('vaccuum_pump_2', $vaccuum_pump_2); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $vaccuum_pump_2 !== null && $vaccuum_pump_2 !== '' && !$this->isFieldDisabled('vaccuum_pump_2')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Box (15.b)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('box_2')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Chip collection | Standard : No components</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="box_2" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('box_2') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('box_2') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="box_2" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('box_2') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('box_2') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Vaccuum Parameter (15.c)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('vaccuum_parameter_2')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with machine parameter result | Standard : No Yellow initial (display)</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="vaccuum_parameter_2" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('vaccuum_parameter_2') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('vaccuum_parameter_2') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="vaccuum_parameter_2" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('vaccuum_parameter_2') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('vaccuum_parameter_2') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Expire Date (16)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('expire_date_2')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Make sure due date on the label | Standard : No Expired</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="expire_date_2" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('expire_date_2') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('expire_date_2') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="expire_date_2" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('expire_date_2') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('expire_date_2') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                                        <button type="button" @click="currentStep = 5" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                            ← Previous
                                        </button>
                                        <button type="button" @click="currentStep = 7" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                                            Next Step →
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <!-- STEP 8: REFLOW -->
                            <div x-show="currentStep === 7" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">8</span>
                                            <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">REFLOW</h3>
                                        </div>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Abandonment (17)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('abandonment')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Damage | Standard : No Damage</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="abandonment" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('abandonment') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('abandonment') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="abandonment" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('abandonment') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('abandonment') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Fire Possibility (17.a)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('fire_posibilty')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : PCB input area No paper,plastic | Standard : No Paper, No plastic</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="fire_posibilty" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('fire_posibilty') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('fire_posibilty') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="fire_posibilty" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('fire_posibilty') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('fire_posibilty') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Flashlight (17.b)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('flashlight')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : On/Off Check | Standard : On</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="flashlight" value="on" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('flashlight') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('flashlight') ? 'text-gray-400' : ''); ?>">On ✓</span>
                                                </label>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="flashlight" value="off" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('flashlight') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('flashlight') ? 'text-gray-400' : ''); ?>">Off ✗</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="flashlight" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('flashlight') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('flashlight') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Rail & Transfer Unit (18)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('rail_and_transfer_unit')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : make sure it is smooth condition | Standard : No jammed</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="rail_and_transfer_unit" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('rail_and_transfer_unit') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('rail_and_transfer_unit') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="rail_and_transfer_unit" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('rail_and_transfer_unit') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('rail_and_transfer_unit') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                N2 Pressure (19)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('n2_presure')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check N2 Pressure | Standard : 0.4MPa ~ 0.5MPa</p>
                                            <input type="text" 
                                                   wire:model.live="n2_presure" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('n2_presure', $n2_presure)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('n2_presure') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('n2_presure', $n2_presure); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $n2_presure !== null && $n2_presure !== '' && !$this->isFieldDisabled('n2_presure')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Oxygen Density SEK (20)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('oxygent_density_sek')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled - Customer: <?php echo e($customer ?? '-'); ?>)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Oxygen meter (SEK Standard) | Standard : 1200~1800 ppm</p>
                                            <input type="text" 
                                                   wire:model.live="oxygent_density_sek" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('oxygent_density_sek', $oxygent_density_sek)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('oxygent_density_sek') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('oxygent_density_sek', $oxygent_density_sek); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $oxygent_density_sek !== null && $oxygent_density_sek !== '' && !$this->isFieldDisabled('oxygent_density_sek')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Oxygen Density Special (20)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('oxygent_density_special')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled - Customer: <?php echo e($customer ?? '-'); ?>)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Oxygen meter (Special Requirement) | Standard : 500~1000 ppm</p>
                                            <input type="text" 
                                                   wire:model.live="oxygent_density_special" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('oxygent_density_special', $oxygent_density_special)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('oxygent_density_special') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('oxygent_density_special', $oxygent_density_special); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $oxygent_density_special !== null && $oxygent_density_special !== '' && !$this->isFieldDisabled('oxygent_density_special')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Fire Possibility (20.a)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('fire_posibilty_2')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : PCB Output area No paper,plastic | Standard : No Paper, No plastic</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="fire_posibilty_2" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('fire_posibilty_2') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('fire_posibilty_2') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="fire_posibilty_2" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('fire_posibilty_2') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('fire_posibilty_2') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                                        <button type="button" @click="currentStep = 6" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                            ← Previous
                                        </button>
                                        <button type="button" @click="currentStep = 8" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                                            Next Step →
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <!-- STEP 9: AOI -->
                            <div x-show="currentStep === 8" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">9</span>
                                            <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">AOI</h3>
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Air Pressure (20.b)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('air_presure_2')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.40 - 0.50 Mpa</p>
                                            <input type="text" 
                                                   wire:model.live="air_presure_2" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('air_presure_2', $air_presure_2)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('air_presure_2') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('air_presure_2', $air_presure_2); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $air_presure_2 !== null && $air_presure_2 !== '' && !$this->isFieldDisabled('air_presure_2')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                                        <button type="button" @click="currentStep = 7" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                            ← Previous
                                        </button>
                                        <button type="button" @click="currentStep = 9" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                                            Next Step →
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <!-- STEP 10: UNLOADER -->
                            <div x-show="currentStep === 9" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">10</span>
                                            <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">UNLOADER</h3>
                                        </div>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Cylinder (21)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('cylinder_2')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Operation And center | Standard : Smooth and center</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="cylinder_2" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('cylinder_2') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('cylinder_2') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="cylinder_2" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('cylinder_2') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('cylinder_2') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Rail & Magazine PCB (21.a)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('rail_and_magazine_pcb_2')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Cleaning Dust and dirty | Standard : No Dust and clean</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="rail_and_magazine_pcb_2" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('rail_and_magazine_pcb_2') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('rail_and_magazine_pcb_2') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="rail_and_magazine_pcb_2" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('rail_and_magazine_pcb_2') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('rail_and_magazine_pcb_2') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Cover Magazine (21.b)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('cover_magazine_2')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Cleaning Dust and dirty | Standard : No Dust and clean</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="cover_magazine_2" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('cover_magazine_2') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('cover_magazine_2') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="cover_magazine_2" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('cover_magazine_2') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('cover_magazine_2') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                                        <button type="button" @click="currentStep = 8" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                            ← Previous
                                        </button>
                                        <button type="button" @click="currentStep = 10" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                                            Next Step →
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <!-- STEP 11: AOI TABLE -->
                            <div x-show="currentStep === 10" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">11</span>
                                            <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">AOI TABLE</h3>
                                        </div>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Angle & Filter (22)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('angle_and_filter')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Cleaning | Standard : No dirt / no dust</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="angle_and_filter" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('angle_and_filter') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('angle_and_filter') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="angle_and_filter" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('angle_and_filter') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('angle_and_filter') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Lamp Indicator (22.a)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('lamp_indicator')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : LED Lamp (Green) | Standard : Function</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="lamp_indicator" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('lamp_indicator') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('lamp_indicator') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="lamp_indicator" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('lamp_indicator') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('lamp_indicator') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                                        <button type="button" @click="currentStep = 9" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                            ← Previous
                                        </button>
                                        <button type="button" @click="currentStep = 11" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                                            Next Step →
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <!-- STEP 12: REFLOW 2 -->
                            <div x-show="currentStep === 11" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">12</span>
                                            <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">REFLOW 2</h3>
                                        </div>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Temperature Chiller (23)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('temperature_chiller')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Write down the value | Standard : 17-23℃</p>
                                            <input type="text" 
                                                   wire:model.live="temperature_chiller" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('temperature_chiller', $temperature_chiller)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('temperature_chiller') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('temperature_chiller', $temperature_chiller); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $temperature_chiller !== null && $temperature_chiller !== '' && !$this->isFieldDisabled('temperature_chiller')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Temperature Control (24)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('temperature_control_3')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check Value inspect | Standard : 300℃ ±10℃</p>
                                            <input type="text" 
                                                   wire:model.live="temperature_control_3" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('temperature_control_3', $temperature_control_3)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('temperature_control_3') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('temperature_control_3', $temperature_control_3); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $temperature_control_3 !== null && $temperature_control_3 !== '' && !$this->isFieldDisabled('temperature_control_3')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>

                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                N2 & Air Pressure (24.a)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('n2_air_presure_valve')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Opening Valve N2 & Air Pressure | Standard : Position handle parallel di direction of pipe for open position</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="n2_air_presure_valve" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('n2_air_presure_valve') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('n2_air_presure_valve') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="n2_air_presure_valve" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('n2_air_presure_valve') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('n2_air_presure_valve') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                                        <button type="button" @click="currentStep = 10" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                            ← Previous
                                        </button>
                                        <button type="button" @click="currentStep = 12" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                                            Next Step →
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <!-- STEP 13: CHIP MOUNTER 3 -->
                            <div x-show="currentStep === 12" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">13</span>
                                            <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">CHIP MOUNTER 3</h3>
                                        </div>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Box (25)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('box_3')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Chip collection | Standard : No components</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="box_3" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('box_3') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('box_3') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="box_3" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('box_3') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('box_3') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Vaccuum Pump (25.a)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('vaccuum_pump_3')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : -87 ~ -100 Kpa</p>
                                            <input type="text" 
                                                   wire:model.live="vaccuum_pump_3" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('vaccuum_pump_3', $vaccuum_pump_3)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('vaccuum_pump_3') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('vaccuum_pump_3', $vaccuum_pump_3); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $vaccuum_pump_3 !== null && $vaccuum_pump_3 !== '' && !$this->isFieldDisabled('vaccuum_pump_3')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                                        <button type="button" @click="currentStep = 11" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                            ← Previous
                                        </button>
                                        <button type="button" @click="currentStep = 13" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                                            Next Step →
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <!-- STEP 14: CHIP MOUNTER 4 -->
                            <div x-show="currentStep === 13" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">14</span>
                                            <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">CHIP MOUNTER 4</h3>
                                        </div>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Box (26)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('box_4')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Chip collection | Standard : No components</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="box_4" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('box_4') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('box_4') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="box_4" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('box_4') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('box_4') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Vaccuum Pump (26.a)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('vaccuum_pump_4')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : -87 ~ -100 Kpa</p>
                                            <input type="text" 
                                                   wire:model.live="vaccuum_pump_4" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('vaccuum_pump_4', $vaccuum_pump_4)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('vaccuum_pump_4') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('vaccuum_pump_4', $vaccuum_pump_4); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $vaccuum_pump_4 !== null && $vaccuum_pump_4 !== '' && !$this->isFieldDisabled('vaccuum_pump_4')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                                        <button type="button" @click="currentStep = 12" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                            ← Previous
                                        </button>
                                        <button type="button" @click="currentStep = 14" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                                            Next Step →
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <!-- STEP 15: SPI 2 -->
                            <div x-show="currentStep === 14" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">15</span>
                                            <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">SPI 2</h3>
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Air Pressure (27)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('air_presure_3')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.40 - 0.50 Mpa (Kohyoung)</p>
                                            <input type="text" 
                                                   wire:model.live="air_presure_3" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('air_presure_3', $air_presure_3)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('air_presure_3') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('air_presure_3', $air_presure_3); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $air_presure_3 !== null && $air_presure_3 !== '' && !$this->isFieldDisabled('air_presure_3')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                                        <button type="button" @click="currentStep = 13" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                            ← Previous
                                        </button>
                                        <button type="button" @click="currentStep = 15" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                                            Next Step →
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <!-- STEP 16: PRINTER -->
                            <div x-show="currentStep === 15" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">16</span>
                                            <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">PRINTER</h3>
                                        </div>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Temperature Control (28)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('temperature_control_4')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Air cond Setting Temperature | Standard : 23-27℃</p>
                                            <input type="text" 
                                                   wire:model.live="temperature_control_4" 
                                                   placeholder="<?php echo e($this->isNAAllowed() ? 'Enter value or - for NA' : 'Enter value'); ?>" 
                                                   class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 <?php echo e($this->getFieldColorClass('temperature_control_4', $temperature_control_4)); ?>" 
                                                   <?php echo e($this->isFieldDisabled('temperature_control_4') ? 'disabled' : ''); ?>>
                                            <?php $validation = $this->validateNumericField('temperature_control_4', $temperature_control_4); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$validation['valid'] && $temperature_control_4 !== null && $temperature_control_4 !== '' && !$this->isFieldDisabled('temperature_control_4')): ?>
                                                <p class="text-xs text-red-600 mt-1"><?php echo e($validation['message']); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Water Reservoirs (28.a)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('water_reservoirs')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Damage, Function | Standard : Function, No Damage</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="water_reservoirs" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('water_reservoirs') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('water_reservoirs') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="water_reservoirs" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('water_reservoirs') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('water_reservoirs') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                                        <button type="button" @click="currentStep = 14" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                            ← Previous
                                        </button>
                                        <button type="button" @click="currentStep = 16" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                                            Next Step →
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <!-- STEP 17: PCB CLEANER 2 -->
                            <div x-show="currentStep === 16" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">17</span>
                                            <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">PCB CLEANER 2</h3>
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Filter (29)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('filter')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Cleaning | Standard : Clean</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="filter" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('filter') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('filter') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="filter" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('filter') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('filter') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                                        <button type="button" @click="currentStep = 15" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                            ← Previous
                                        </button>
                                        <button type="button" @click="currentStep = 17" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                                            Next Step →
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <!-- STEP 18: IONIZER -->
                            <div x-show="currentStep === 17" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">18</span>
                                            <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">IONIZER</h3>
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        <div>
                                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                Angle & Filter (30)
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isFieldRequired('angle_and_filter_2')): ?>
                                                    <span class="text-red-500">*</span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 text-xs font-normal">(Disabled)</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </label>
                                            <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Cleaning | Standard : No dirt / no dust</p>
                                            <div class="flex gap-6">
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="angle_and_filter_2" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('angle_and_filter_2') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('angle_and_filter_2') ? 'text-gray-400' : ''); ?>">Checked ✓</span>
                                                </label>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isNAAllowed()): ?>
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="radio" wire:model.live="angle_and_filter_2" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" <?php echo e($this->isFieldDisabled('angle_and_filter_2') ? 'disabled' : ''); ?>>
                                                    <span class="text-sm <?php echo e($this->isFieldDisabled('angle_and_filter_2') ? 'text-gray-400' : ''); ?>">N/A</span>
                                                </label>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                                        <button type="button" @click="currentStep = 16" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                            ← Previous
                                        </button>
                                        <button type="button" @click="currentStep = 18" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                                            Next Step →
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <!-- STEP 19: TIME & STATUS -->
                            <div x-show="currentStep === 18" x-cloak>
                                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php', $__blaze->compiledPath.'/3d4fe4e3a30081183402a5280be0d46f.php'); ?>
<?php if (isset($__slots3d4fe4e3a30081183402a5280be0d46f)) { $__slotsStack3d4fe4e3a30081183402a5280be0d46f[] = $__slots3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php if (isset($__attrs3d4fe4e3a30081183402a5280be0d46f)) { $__attrsStack3d4fe4e3a30081183402a5280be0d46f[] = $__attrs3d4fe4e3a30081183402a5280be0d46f; } ?>
<?php $__attrs3d4fe4e3a30081183402a5280be0d46f = ['class' => 'p-0 shadow-lg overflow-hidden']; ?>
<?php $__slots3d4fe4e3a30081183402a5280be0d46f = []; ?>
<?php $__blaze->pushData($__attrs3d4fe4e3a30081183402a5280be0d46f); ?>
<?php ob_start(); ?>
                                    <div class="bg-green-600 dark:bg-green-500 px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['name' => 'clock', 'class' => 'w-5 h-5 text-white']); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/b462ffebaca45ac18a5d2c5540ab64d7.php'); ?>
<?php $__blaze->pushData(['name' => 'clock','class' => 'w-5 h-5 text-white']); ?>
<?php _b462ffebaca45ac18a5d2c5540ab64d7($__blaze, ['name' => 'clock','class' => 'w-5 h-5 text-white'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
                                            <h3 class="font-semibold text-base text-white">TIME & STATUS</h3>
                                        </div>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <div class="flex items-center justify-between mb-1">
                                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                        Stop Time
                                                        <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                                                    </label>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($stop_time): ?>
                                                    <button type="button" 
                                                            wire:click="$set('stop_time', null)" 
                                                            class="px-3 py-1 text-xs font-medium bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all duration-200 shadow-sm hover:shadow">
                                                        <svg class="w-3 h-3 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                        Clear
                                                    </button>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                                <input type="time" 
                                                       wire:model="stop_time" 
                                                       class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm focus:ring-2 focus:ring-green-500">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['stop_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                                    <span class="text-xs text-red-600 mt-1"><?php echo e($message); ?></span> 
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            
                                            <div>
                                                <div class="flex items-center justify-between mb-1">
                                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                        Run Time
                                                        <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                                                    </label>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($run_time): ?>
                                                    <button type="button" 
                                                            wire:click="$set('run_time', null)" 
                                                            class="px-3 py-1 text-xs font-medium bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all duration-200 shadow-sm hover:shadow">
                                                        <svg class="w-3 h-3 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                        Clear
                                                    </button>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                                <input type="time" 
                                                       wire:model.live="run_time" 
                                                       class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm focus:ring-2 focus:ring-green-500">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['run_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                                    <span class="text-xs text-red-600 mt-1"><?php echo e($message); ?></span> 
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            
                                            <div>
                                                <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                                    Group <span class="text-red-500">*</span>
                                                </label>
                                                <select wire:model.live="group" 
                                                        class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm focus:ring-2 focus:ring-green-500">
                                                    <option value="">Select Group</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                </select>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                                    <span class="text-xs text-red-600 mt-1"><?php echo e($message); ?></span> 
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="mt-4 p-4 rounded-lg <?php echo e($overallStatus === 'success' ? 'bg-green-50 dark:bg-green-950/30 border border-green-200' : 'bg-yellow-50 dark:bg-yellow-950/30 border border-yellow-200'); ?>">
                                            <div class="flex items-center gap-2">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($overallStatus === 'success'): ?>
                                                    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/check-circle.blade.php', $__blaze->compiledPath.'/2dca92a692a5fd5a005881121e5e1a7a.php'); ?>
<?php $__blaze->pushData(['class' => 'w-5 h-5 text-green-600']); ?>
<?php _2dca92a692a5fd5a005881121e5e1a7a($__blaze, ['class' => 'w-5 h-5 text-green-600'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                                                    <span class="text-sm font-medium text-green-700 dark:text-green-400">Status akan disimpan sebagai: Checked</span>
                                                <?php else: ?>
                                                    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/clock.blade.php', $__blaze->compiledPath.'/1a3ac556f6f475e8697257658fa13f6e.php'); ?>
<?php $__blaze->pushData(['class' => 'w-5 h-5 text-yellow-600']); ?>
<?php _1a3ac556f6f475e8697257658fa13f6e($__blaze, ['class' => 'w-5 h-5 text-yellow-600'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                                                    <span class="text-sm font-medium text-yellow-700 dark:text-yellow-400">Status akan disimpan sebagai: On Progress</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            <p class="text-xs <?php echo e($overallStatus === 'success' ? 'text-green-600' : 'text-yellow-600'); ?> mt-1">
                                                <?php echo e($overallStatusText); ?>

                                            </p>
                                        </div>
                                        
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 bg-zinc-50 dark:bg-zinc-800/30 p-3 rounded-lg">
                                            <p>💡 <span class="font-medium">Catatan:</span> Stop Time dan Run Time bersifat opsional (tidak wajib diisi). Klik tombol <span class="inline-flex items-center px-2 py-0.5 bg-red-500 text-white rounded text-[10px] font-medium">Clear</span> untuk menghapus nilai.</p>
                                        </div>
                                    </div>
                                    <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                                        <button type="button" @click="currentStep = 17" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                            ← Previous
                                        </button>
                                        <button type="submit" class="px-6 py-2 text-sm font-medium rounded-lg bg-green-600 hover:bg-green-700 text-white transition-colors shadow-lg shadow-green-600/20">
                                            Update Inspection
                                        </button>
                                    </div>
                                <?php $__slots3d4fe4e3a30081183402a5280be0d46f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d4fe4e3a30081183402a5280be0d46f); ?>
<?php _3d4fe4e3a30081183402a5280be0d46f($__blaze, $__attrs3d4fe4e3a30081183402a5280be0d46f, $__slots3d4fe4e3a30081183402a5280be0d46f, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d4fe4e3a30081183402a5280be0d46f)) { $__slots3d4fe4e3a30081183402a5280be0d46f = array_pop($__slotsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php if (! empty($__attrsStack3d4fe4e3a30081183402a5280be0d46f)) { $__attrs3d4fe4e3a30081183402a5280be0d46f = array_pop($__attrsStack3d4fe4e3a30081183402a5280be0d46f); } ?>
<?php $__blaze->popData(); ?>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
                <!-- END: 2 KOLOM -->
                
            </form>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2991782b15caf2333143ee45e5bacc85)): ?>
<?php $attributes = $__attributesOriginal2991782b15caf2333143ee45e5bacc85; ?>
<?php unset($__attributesOriginal2991782b15caf2333143ee45e5bacc85); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2991782b15caf2333143ee45e5bacc85)): ?>
<?php $component = $__componentOriginal2991782b15caf2333143ee45e5bacc85; ?>
<?php unset($__componentOriginal2991782b15caf2333143ee45e5bacc85); ?>
<?php endif; ?>
</section>

<script>
    document.addEventListener('livewire:initialized', () => {
        // Update step status when Livewire updates
        Livewire.on('step-update', () => {
            // Logic update step status
        });
    });
</script>

<style>
    [x-cloak] { display: none !important; }
    input.border-red-500, select.border-red-500 { border-color: #ef4444 !important; }
    input.border-green-500, select.border-green-500 { border-color: #22c55e !important; }
    input:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    input:disabled + span {
        opacity: 0.6;
    }

    /* Hide scrollbar by default, show on hover */
    .scrollbar-hide::-webkit-scrollbar {
        width: 0px;
        background: transparent;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .scrollbar-hide:hover::-webkit-scrollbar {
        width: 6px;
        background: transparent;
    }
    .scrollbar-hide:hover::-webkit-scrollbar-track {
        background: transparent;
    }
    .scrollbar-hide:hover::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    .scrollbar-hide:hover::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    .scrollbar-hide:hover {
        -ms-overflow-style: auto;
        scrollbar-width: thin;
    }
</style><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/resources/views/livewire/mtc/daily/panasonic/daily-panasonic-edit.blade.php ENDPATH**/ ?>