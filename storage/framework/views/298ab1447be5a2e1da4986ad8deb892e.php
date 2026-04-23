<?php # [BlazeFolded]:{flux::heading}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/heading.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::modal}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/modal/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::modal}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/modal/index.blade.php}:{1774988736} ?>
<section class="w-full">
    <?php echo $__env->make('partials.esd-heading', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-sm [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2 sr-only" data-flux-heading><?php ob_start(); ?>
        <?php echo e(__('Electrostatic Discharge - Event Calendar')); ?>

    <?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>

    <?php if (isset($component)) { $__componentOriginalf744da513101cd09f149c6df9c59a801 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf744da513101cd09f149c6df9c59a801 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.esd.layout','data' => ['class' => '!max-w-full !px-0 !mx-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('esd.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => '!max-w-full !px-0 !mx-0']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

         <?php $__env->slot('heading', null, []); ?> 
            <div class="w-full">
                <?php ob_start(); ?><div class="flex mb-1" data-flux-breadcrumbs>
    <?php ob_start(); ?>
                    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php', $__blaze->compiledPath.'/b843a539037c1542dedc5bd82236e28a.php'); ?>
<?php if (isset($__slotsb843a539037c1542dedc5bd82236e28a)) { $__slotsStackb843a539037c1542dedc5bd82236e28a[] = $__slotsb843a539037c1542dedc5bd82236e28a; } ?>
<?php if (isset($__attrsb843a539037c1542dedc5bd82236e28a)) { $__attrsStackb843a539037c1542dedc5bd82236e28a[] = $__attrsb843a539037c1542dedc5bd82236e28a; } ?>
<?php $__attrsb843a539037c1542dedc5bd82236e28a = ['href' => e(route('dashboard')),'wire:navigate' => true,'separator' => 'slash']; ?>
<?php $__slotsb843a539037c1542dedc5bd82236e28a = []; ?>
<?php $__blaze->pushData($__attrsb843a539037c1542dedc5bd82236e28a); ?>
<?php ob_start(); ?>
                        Dashboard
                    <?php $__slotsb843a539037c1542dedc5bd82236e28a['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsb843a539037c1542dedc5bd82236e28a); ?>
<?php _b843a539037c1542dedc5bd82236e28a($__blaze, $__attrsb843a539037c1542dedc5bd82236e28a, $__slotsb843a539037c1542dedc5bd82236e28a, ['wire:navigate'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackb843a539037c1542dedc5bd82236e28a)) { $__slotsb843a539037c1542dedc5bd82236e28a = array_pop($__slotsStackb843a539037c1542dedc5bd82236e28a); } ?>
<?php if (! empty($__attrsStackb843a539037c1542dedc5bd82236e28a)) { $__attrsb843a539037c1542dedc5bd82236e28a = array_pop($__attrsStackb843a539037c1542dedc5bd82236e28a); } ?>
<?php $__blaze->popData(); ?>
                    <?php ob_start(); ?><div class="flex items-center text-sm font-medium group/breadcrumb font-semibold text-blue-600 dark:text-blue-400" data-flux-breadcrumbs-item>
            <div class="text-gray-500 dark:text-white/80">
                            <?php ob_start(); ?>
                        Maintenance
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
                        Event
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
            </div>
         <?php $__env->endSlot(); ?>
        
         <?php $__env->slot('subheading', null, []); ?> 
            <div class="w-full">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-zinc-800 dark:text-white">
                            Event Calendar
                        </h1>
                        <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            Manage ESD events and activities
                        </p>
                    </div>
                </div>
            </div>
         <?php $__env->endSlot(); ?>
        
        <div class="-mt-2">
            <div class="flex flex-col lg:flex-row gap-4 sm:gap-6 w-full">
                <!-- Calendar Container -->
                <div class="lg:w-2/5 w-full bg-white dark:bg-zinc-800 rounded-2xl shadow-lg border border-zinc-200 dark:border-zinc-700 p-3 sm:p-4 md:p-5 transition-all duration-300">
                    <!-- Calendar Navigation -->
                    <div class="flex items-center justify-between mb-4 sm:mb-6">
                        <button wire:click="goToPrevMonth" 
                                class="p-1.5 sm:p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-300 shadow-sm hover:scale-105 active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-4.28 9.22a.75.75 0 0 0 0 1.06l3 3a.75.75 0 1 0 1.06-1.06l-1.72-1.72h5.69a.75.75 0 0 0 0-1.5h-5.69l1.72-1.72a.75.75 0 0 0-1.06-1.06l-3 3Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <span class="font-semibold text-gray-800 dark:text-white text-base sm:text-lg transition-opacity duration-300" 
                            x-data="{ month: '<?php echo e($currentMonthName); ?>' }" 
                            x-text="month"><?php echo e($currentMonthName); ?></span>
                        
                        <button wire:click="goToNextMonth" 
                                class="p-1.5 sm:p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-300 shadow-sm hover:scale-105 active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm4.28 10.28a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 1 0-1.06 1.06l1.72 1.72H8.25a.75.75 0 0 0 0 1.5h5.69l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <!-- Calendar Grid - Responsive with dynamic height -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-separate border-spacing-0.5 sm:border-spacing-1">
                            <thead>
                                <tr>
                                    <th class="text-gray-500 dark:text-gray-400 font-medium text-[10px] sm:text-xs pb-1 sm:pb-2 text-center">Sun</th>
                                    <th class="text-gray-500 dark:text-gray-400 font-medium text-[10px] sm:text-xs pb-1 sm:pb-2 text-center">Mon</th>
                                    <th class="text-gray-500 dark:text-gray-400 font-medium text-[10px] sm:text-xs pb-1 sm:pb-2 text-center">Tue</th>
                                    <th class="text-gray-500 dark:text-gray-400 font-medium text-[10px] sm:text-xs pb-1 sm:pb-2 text-center">Wed</th>
                                    <th class="text-gray-500 dark:text-gray-400 font-medium text-[10px] sm:text-xs pb-1 sm:pb-2 text-center">Thu</th>
                                    <th class="text-gray-500 dark:text-gray-400 font-medium text-[10px] sm:text-xs pb-1 sm:pb-2 text-center">Fri</th>
                                    <th class="text-gray-500 dark:text-gray-400 font-medium text-[10px] sm:text-xs pb-1 sm:pb-2 text-center">Sat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $calendarWeeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $week; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <?php
                                        // Tentukan weekend: Sabtu dan Minggu
                                        $isWeekend = \Carbon\Carbon::parse($day['date'])->isWeekend();
                                    ?>
                                    <td class="p-0.5 sm:p-1 text-center relative">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($day['isCurrentMonth']): ?>
                                            <button wire:click="selectDate('<?php echo e($day['date']); ?>')"
                                                class="w-full aspect-square rounded-lg transition-all duration-300 hover:scale-95 active:scale-90 flex flex-col items-center justify-center text-[11px] sm:text-sm
                                                <?php echo e($day['isSelected'] ? 'bg-blue-600 text-white font-bold shadow-md transform scale-95' : 
                                                ($isWeekend ? 'bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-800/50' : 
                                                'bg-blue-50 dark:bg-blue-950/30 text-gray-800 dark:text-white hover:bg-blue-100 dark:hover:bg-blue-900/50')); ?>">
                                                
                                                <span class="text-[11px] sm:text-sm"><?php echo e($day['day']); ?></span>
                                            </button>
                                            
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($day['eventCount'] > 0): ?>
                                                <span class="absolute -top-1 -right-1 text-white text-[10px] sm:text-xs rounded-full w-4 h-4 sm:w-5 sm:h-5 flex items-center justify-center font-bold shadow-md transition-all duration-200
                                                    <?php echo e($day['badgeColor'] == 'green' ? 'bg-green-600' : 
                                                    ($day['badgeColor'] == 'red' ? 'bg-red-600' : 'bg-yellow-600')); ?>">
                                                    <?php echo e($day['eventCount']); ?>

                                                </span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php else: ?>
                                            <div class="w-full aspect-square"></div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Event Panel -->
                <div class="lg:w-3/5 w-full bg-white dark:bg-zinc-800 rounded-2xl shadow-lg border border-zinc-200 dark:border-zinc-700 p-3 sm:p-4 md:p-5 h-fit transition-all duration-300">
                    <!-- Header -->
                    <div class="flex items-center justify-between pb-3 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-sm sm:text-base font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                            Event Calendar
                        </h2>
                        <button wire:click="loadEvents" 
                                class="flex items-center gap-1 sm:gap-1.5 px-2 sm:px-3 py-1 sm:py-1.5 bg-gray-50 dark:bg-zinc-700 hover:bg-gray-100 dark:hover:bg-zinc-600 text-gray-600 dark:text-gray-300 rounded-lg transition-all duration-200 text-[11px] sm:text-xs font-medium border border-zinc-200 dark:border-zinc-600 hover:scale-105 active:scale-95">
                            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span class="hidden xs:inline">Refresh</span>
                        </button>
                    </div>

                    <!-- Legend Badges -->
                    <div class="flex flex-wrap gap-2 sm:gap-4 py-2 sm:py-3">
                        <div class="flex items-center gap-1 sm:gap-1.5">
                            <span class="w-2 h-2 sm:w-2.5 sm:h-2.5 bg-red-500 rounded-full"></span>
                            <span class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400">Open</span>
                        </div>
                        <div class="flex items-center gap-1 sm:gap-1.5">
                            <span class="w-2 h-2 sm:w-2.5 sm:h-2.5 bg-yellow-500 rounded-full"></span>
                            <span class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400">On Progress</span>
                        </div>
                        <div class="flex items-center gap-1 sm:gap-1.5">
                            <span class="w-2 h-2 sm:w-2.5 sm:h-2.5 bg-green-500 rounded-full"></span>
                            <span class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400">Closed</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-2 mt-1 mb-3">
                        <h3 class="text-xs sm:text-sm font-semibold text-gray-800 dark:text-white flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Events on <span class="text-blue-600 font-medium text-[11px] sm:text-xs"><?php echo e($selectedDateFormatted); ?></span>
                        </h3>
                        <button wire:click="openCreateModal" 
                                class="flex items-center gap-1 sm:gap-1.5 px-2 sm:px-3 py-1 sm:py-1.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition-all duration-300 text-[11px] sm:text-xs font-medium shadow-sm hover:scale-105 active:scale-95 whitespace-nowrap">
                            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            New Event
                        </button>
                    </div>

                    <!-- Event List -->
                    <div class="event-list-container">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($selectedDateEvents) > 0): ?>
                            <ul class="space-y-1.5 sm:space-y-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $selectedDateEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <?php
                                    $colorClass = match($event['color']) {
                                        'red' => 'bg-red-100 border-l-4 border-red-600 hover:bg-red-200 text-red-900 dark:bg-red-900/30 dark:border-red-500 dark:text-red-300 dark:hover:bg-red-900/50',
                                        'yellow' => 'bg-yellow-100 border-l-4 border-yellow-600 hover:bg-yellow-200 text-yellow-900 dark:bg-yellow-900/30 dark:border-yellow-500 dark:text-yellow-300 dark:hover:bg-yellow-900/50',
                                        'green' => 'bg-green-100 border-l-4 border-green-600 hover:bg-green-200 text-green-900 dark:bg-green-900/30 dark:border-green-500 dark:text-green-300 dark:hover:bg-green-900/50',
                                        default => 'bg-gray-100 border-l-4 border-gray-600 hover:bg-gray-200 text-gray-900 dark:bg-gray-900/30 dark:border-gray-500 dark:text-gray-300 dark:hover:bg-gray-900/50',
                                    };
                                    
                                    // Decode file jika berupa string JSON
                                    $fileArray = [];
                                    if(isset($event['file'])) {
                                        if(is_string($event['file'])) {
                                            // Hapus backslash dari string JSON terlebih dahulu
                                            $cleanedString = stripslashes($event['file']);
                                            $fileArray = json_decode($cleanedString, true);
                                            if(json_last_error() !== JSON_ERROR_NONE) {
                                                $fileArray = is_array($event['file']) ? $event['file'] : [];
                                            }
                                        } elseif(is_array($event['file'])) {
                                            $fileArray = $event['file'];
                                        }
                                    }
                                    
                                    // Bersihkan setiap path file dari backslash
                                    $fileArray = array_map(function($file) {
                                        return stripslashes($file);
                                    }, $fileArray);
                                    
                                    // Filter hanya file gambar
                                    $imageFiles = array_filter($fileArray, function($file) {
                                        return preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
                                    });
                                    
                                    // Fungsi untuk mendapatkan URL file (handle kedua format)
                                    $getFileUrl = function($file) {
                                        // Bersihkan dari backslash terlebih dahulu
                                        $file = stripslashes($file);
                                        
                                        // Jika sudah mengandung 'events/' (tanpa backslash)
                                        if (str_contains($file, 'events/')) {
                                            return Storage::url($file);
                                        }
                                        // Jika hanya nama file, tambahkan folder 'events/'
                                        return Storage::url('events/' . $file);
                                    };
                                    
                                    // Ambil 2 gambar pertama untuk ditampilkan
                                    $displayImages = array_slice($imageFiles, 0, 2);
                                    $totalImages = count($imageFiles);
                                    $remainingImages = $totalImages - 2;
                                ?>
                                <li class="p-2 sm:p-3 rounded-lg cursor-pointer <?php echo e($colorClass); ?>" 
                                    wire:click="openEditModal(<?php echo e($event['id']); ?>)">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-xs sm:text-sm font-medium truncate"><?php echo e($event['title']); ?></h4>
                                            <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                <?php echo e($event['start_time']); ?> - <?php echo e($event['end_time']); ?>

                                            </p>
                                        </div>
                                        <div class="flex items-center gap-1 sm:gap-2 flex-shrink-0">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalImages > 0): ?>
                                                <div class="flex -space-x-2 sm:-space-x-3">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $displayImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imageFile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                        <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full border-2 border-white dark:border-zinc-800 overflow-hidden bg-gray-200 dark:bg-zinc-700 shadow-sm">
                                                            <img src="<?php echo e($getFileUrl($imageFile)); ?>" 
                                                                class="w-full h-full object-cover" 
                                                                alt="photo"
                                                                onerror="this.src='<?php echo e(asset('storage/default-image.png')); ?>'; this.onerror=null;">
                                                        </div>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($remainingImages > 0): ?>
                                                        <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-blue-500 text-white text-[9px] sm:text-xs flex items-center justify-center font-medium border-2 border-white dark:border-zinc-800 shadow-sm">
                                                            +<?php echo e($remainingImages); ?>

                                                        </div>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </li>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </ul>
                        <?php else: ?>
                            <div class="p-4 sm:p-6 text-center text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-zinc-800/50 rounded-lg border border-dashed border-gray-200 dark:border-zinc-700">
                                <svg class="w-8 h-8 sm:w-10 sm:h-10 mx-auto text-gray-300 dark:text-gray-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-[11px] sm:text-xs">No events scheduled for this day</p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- MODAL FORM EVENT - Wizard Style -->
            <?php ob_start(); ?><ui-modal wire:model.self="showModal" data-flux-modal>
    
    <dialog
        wire:ignore.self 
        class="p-6 [:where(&amp;)]:max-w-xl [:where(&amp;)]:min-w-xs shadow-lg rounded-xl bg-white dark:bg-zinc-800 ring ring-black/5 dark:ring-zinc-700 shadow-lg rounded-xl w-full max-w-3xl mx-4 sm:mx-auto"
                                <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => NULL,
); ?>
        x-data="fluxModal(<?php echo \Illuminate\Support\Js::from($scope['name'])->toHtml() ?>, <?php echo \Illuminate\Support\Js::from(isset($__livewire) ? $__livewire->getId() : null)->toHtml() ?>)"
        <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
        x-on:modal-show.document="handleShow($event)"
        x-on:modal-close.document="handleClose($event)"
    >
                    <?php ob_start(); ?>
                <div class="p-4 sm:p-6">
                    <!-- Wizard Header -->
                    <div class="mb-6">
                        <h2 class="text-lg sm:text-xl font-bold mb-4"><?php echo e($modalTitle); ?></h2>
                        
                        <!-- Progress Steps -->
                        <div class="flex items-center justify-between gap-2">
                            <button type="button" 
                                    wire:click="setWizardStep(1)" 
                                    class="flex-1 text-center transition-all duration-300 <?php echo e($wizardStep >= 1 ? 'cursor-pointer' : 'cursor-not-allowed opacity-50'); ?>">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300 
                                        <?php echo e($wizardStep > 1 ? 'bg-green-500 text-white' : ($wizardStep >= 1 ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-zinc-700 text-gray-500')); ?>">
                                        <?php echo e($wizardStep > 1 ? '✓' : '1'); ?>

                                    </div>
                                    <span class="text-xs sm:text-sm font-medium hidden sm:inline <?php echo e($wizardStep >= 1 ? 'text-gray-900 dark:text-white' : 'text-gray-400'); ?>">Basic Info</span>
                                </div>
                            </button>
                            <div class="flex-1 h-0.5 bg-gray-200 dark:bg-zinc-700 rounded">
                                <div class="h-0.5 bg-blue-600 rounded transition-all duration-500" style="width: <?php echo e($wizardStep >= 2 ? '100%' : '0%'); ?>"></div>
                            </div>
                            <button type="button" 
                                    wire:click="setWizardStep(2)" 
                                    class="flex-1 text-center transition-all duration-300 <?php echo e($wizardStep >= 2 ? 'cursor-pointer' : 'cursor-not-allowed opacity-50'); ?>">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300 
                                        <?php echo e($wizardStep > 2 ? 'bg-green-500 text-white' : ($wizardStep >= 2 ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-zinc-700 text-gray-500')); ?>">
                                        <?php echo e($wizardStep > 2 ? '✓' : '2'); ?>

                                    </div>
                                    <span class="text-xs sm:text-sm font-medium hidden sm:inline <?php echo e($wizardStep >= 2 ? 'text-gray-900 dark:text-white' : 'text-gray-400'); ?>">Attachments</span>
                                </div>
                            </button>
                            <div class="flex-1 h-0.5 bg-gray-200 dark:bg-zinc-700 rounded">
                                <div class="h-0.5 bg-blue-600 rounded transition-all duration-500" style="width: <?php echo e($wizardStep >= 3 ? '100%' : '0%'); ?>"></div>
                            </div>
                            <button type="button" 
                                    wire:click="setWizardStep(3)" 
                                    class="flex-1 text-center transition-all duration-300 <?php echo e($wizardStep >= 3 ? 'cursor-pointer' : 'cursor-not-allowed opacity-50'); ?>">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300 
                                        <?php echo e($wizardStep >= 3 ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-zinc-700 text-gray-500'); ?>">
                                        3
                                    </div>
                                    <span class="text-xs sm:text-sm font-medium hidden sm:inline <?php echo e($wizardStep >= 3 ? 'text-gray-900 dark:text-white' : 'text-gray-400'); ?>">Review</span>
                                </div>
                            </button>
                        </div>
                    </div>

                    <form wire:submit="save">
                        <!-- STEP 1: Basic Info -->
                        <div x-show="$wire.wizardStep === 1" x-cloak>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                                <!-- Title -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs sm:text-sm font-medium mb-1">Title <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="title" class="w-full px-3 py-2 text-sm border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <!-- Description -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs sm:text-sm font-medium mb-1">Description</label>
                                    <textarea wire:model="description" rows="3" class="w-full px-3 py-2 text-sm border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 transition-all duration-200"></textarea>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <!-- Start Date & Time -->
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium mb-1">Start Date <span class="text-red-500">*</span></label>
                                    <input type="date" wire:model="start_date" class="w-full px-3 py-2 text-sm border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div>
                                    <label class="block text-xs sm:text-sm font-medium mb-1">Start Time <span class="text-red-500">*</span></label>
                                    <input type="time" wire:model="start_time" class="w-full px-3 py-2 text-sm border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <!-- End Date & Time -->
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium mb-1">End Date <span class="text-red-500">*</span></label>
                                    <input type="date" wire:model="end_date" class="w-full px-3 py-2 text-sm border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div>
                                    <label class="block text-xs sm:text-sm font-medium mb-1">End Time <span class="text-red-500">*</span></label>
                                    <input type="time" wire:model="end_time" class="w-full px-3 py-2 text-sm border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <!-- Status -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs sm:text-sm font-medium mb-2">Status <span class="text-red-500">*</span></label>
                                    <div class="flex flex-wrap gap-3 sm:gap-4">
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="radio" wire:model="color" value="red" class="w-4 h-4 text-red-600 focus:ring-red-500">
                                            <span class="w-5 h-5 rounded-full bg-red-500"></span>
                                            <span class="text-xs sm:text-sm font-medium text-red-700 dark:text-red-400">Open</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="radio" wire:model="color" value="yellow" class="w-4 h-4 text-yellow-600 focus:ring-yellow-500">
                                            <span class="w-5 h-5 rounded-full bg-yellow-500"></span>
                                            <span class="text-xs sm:text-sm font-medium text-yellow-700 dark:text-yellow-400">On Progress</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="radio" wire:model="color" value="green" class="w-4 h-4 text-green-600 focus:ring-green-500">
                                            <span class="w-5 h-5 rounded-full bg-green-500"></span>
                                            <span class="text-xs sm:text-sm font-medium text-green-700 dark:text-green-400">Closed</span>
                                        </label>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 2: Attachments -->
                        <div x-show="$wire.wizardStep === 2" x-cloak>
                            <div class="space-y-4">
                                <!-- Existing Files with Image Preview -->
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($existing_file && count($existing_file) > 0): ?>
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium mb-2">Current Attachments (<?php echo e(count($existing_file)); ?>)</label>
                                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $existing_file; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <?php
                                            $isImage = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
                                            $fileUrl = Storage::url($file);
                                        ?>
                                        <div class="relative group">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isImage): ?>
                                                <a href="<?php echo e($fileUrl); ?>" 
                                                target="_blank" 
                                                rel="noopener noreferrer"
                                                class="block aspect-square rounded-lg overflow-hidden bg-gray-100 dark:bg-zinc-800 border-2 border-gray-200 dark:border-zinc-700 hover:border-blue-500 transition-all duration-200">
                                                    <img src="<?php echo e($fileUrl); ?>" 
                                                        class="w-full h-full object-cover"
                                                        alt="attachment">
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo e($fileUrl); ?>" 
                                                target="_blank" 
                                                rel="noopener noreferrer"
                                                class="block aspect-square rounded-lg bg-gray-100 dark:bg-zinc-800 border-2 border-gray-200 dark:border-zinc-700 flex flex-col items-center justify-center hover:border-blue-500 transition-all duration-200">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    <span class="text-[10px] text-gray-500 mt-1 truncate px-1"><?php echo e(basename($file)); ?></span>
                                                </a>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <button type="button" 
                                                    wire:click="removeFile(<?php echo e($index); ?>)" 
                                                    class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs font-bold opacity-0 group-hover:opacity-100 transition-all duration-200 hover:bg-red-600">
                                                ×
                                            </button>
                                        </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <!-- Upload New Files -->
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium mb-2">Upload New Files</label>
                                    <div class="border-2 border-dashed border-gray-300 dark:border-zinc-700 rounded-lg p-4 text-center hover:border-blue-500 transition-all duration-200"
                                        x-data="{ isDragging: false }"
                                        @dragover.prevent="isDragging = true"
                                        @dragleave.prevent="isDragging = false"
                                        @drop.prevent="isDragging = false; $refs.fileInput.files = $event.dataTransfer.files; $wire.uploadFiles($refs.fileInput.files)">
                                        <input type="file" 
                                            wire:model="new_files" 
                                            multiple 
                                            x-ref="fileInput"
                                            class="hidden"
                                            accept="image/*,.pdf,.doc,.docx,.xlsx">
                                        <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Drag & drop files here or</p>
                                        <button type="button" 
                                                onclick="document.querySelector('[x-ref=\'fileInput\']').click()"
                                                class="mt-2 text-blue-600 hover:text-blue-700 text-sm font-medium">
                                            Browse Files
                                        </button>
                                        <p class="text-xs text-gray-500 mt-2">Supported: JPG, PNG, GIF, PDF, DOC, DOCX, XLSX (Max 10MB)</p>
                                    </div>
                                    
                                    <!-- Preview Uploaded Files -->
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($new_files && count($new_files) > 0): ?>
                                    <div class="mt-3">
                                        <label class="block text-xs sm:text-sm font-medium mb-2">New Files (<?php echo e(count($new_files)); ?>)</label>
                                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $new_files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <?php
                                                $isImage = str_contains($file->getMimeType(), 'image');
                                                $previewUrl = $isImage ? $file->temporaryUrl() : null;
                                            ?>
                                            <div class="relative group">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isImage): ?>
                                                    <div class="aspect-square rounded-lg overflow-hidden bg-gray-100 dark:bg-zinc-800 border-2 border-gray-200 dark:border-zinc-700">
                                                        <img src="<?php echo e($previewUrl); ?>" 
                                                            class="w-full h-full object-cover cursor-pointer"
                                                            alt="preview"
                                                            onclick="window.open('<?php echo e($previewUrl); ?>', '_blank')">
                                                    </div>
                                                <?php else: ?>
                                                    <div class="aspect-square rounded-lg bg-gray-100 dark:bg-zinc-800 border-2 border-gray-200 dark:border-zinc-700 flex flex-col items-center justify-center">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                        <span class="text-[10px] text-gray-500 mt-1 truncate px-1"><?php echo e($file->getClientOriginalName()); ?></span>
                                                    </div>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['new_files.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs block mt-2"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 3: Review -->
                        <div x-show="$wire.wizardStep === 3" x-cloak>
                            <div class="space-y-4">
                                <!-- Summary Card -->
                                <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-lg p-4">
                                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Event Summary</h3>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex flex-wrap gap-2">
                                            <span class="font-medium text-gray-600 dark:text-gray-400 w-24">Title:</span>
                                            <span class="text-gray-900 dark:text-white"><?php echo e($title ?: '-'); ?></span>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="font-medium text-gray-600 dark:text-gray-400 w-24">Description:</span>
                                            <span class="text-gray-900 dark:text-white"><?php echo e($description ?: '-'); ?></span>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="font-medium text-gray-600 dark:text-gray-400 w-24">Start:</span>
                                            <span class="text-gray-900 dark:text-white"><?php echo e($start_date); ?> <?php echo e($start_time); ?></span>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="font-medium text-gray-600 dark:text-gray-400 w-24">End:</span>
                                            <span class="text-gray-900 dark:text-white"><?php echo e($end_date); ?> <?php echo e($end_time); ?></span>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="font-medium text-gray-600 dark:text-gray-400 w-24">Status:</span>
                                            <div class="flex items-center gap-2">
                                                <span class="w-3 h-3 rounded-full 
                                                    <?php echo e($color == 'red' ? 'bg-red-500' : ($color == 'yellow' ? 'bg-yellow-500' : 'bg-green-500')); ?>"></span>
                                                <span class="text-gray-900 dark:text-white">
                                                    <?php echo e($color == 'red' ? 'Open' : ($color == 'yellow' ? 'On Progress' : 'Closed')); ?>

                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="font-medium text-gray-600 dark:text-gray-400 w-24">Attachments:</span>
                                            <span class="text-gray-900 dark:text-white"><?php echo e(count($existing_file) + count($new_files)); ?> file(s)</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Validation Check -->
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3">
                                    <p class="text-red-600 dark:text-red-400 text-sm font-medium mb-2">Please fix the following:</p>
                                    <ul class="list-disc list-inside text-xs text-red-500 space-y-1">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <li><?php echo e($error); ?></li>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </ul>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        <!-- Navigation Buttons - Save button appears on ALL steps -->
                        <div class="flex justify-between gap-2 mt-6">
                            <div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($wizardStep > 1): ?>
                                <button type="button" 
                                        wire:click="previousStep" 
                                        class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-all duration-200 text-sm">
                                    ← Back
                                </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="flex gap-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($wizardStep < 3): ?>
                                <button type="button" 
                                        wire:click="nextStep" 
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 text-sm">
                                    Next →
                                </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <button type="submit" 
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 text-sm">
                                    <?php echo e($event_id ? 'Update' : 'Save'); ?>

                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php echo trim(ob_get_clean()); ?>


                            <div class="absolute top-0 end-0 mt-4 me-4">
                    <ui-close data-flux-modal-close >
    <button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-8 text-sm rounded-md w-8 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-800 dark:text-white      text-zinc-400! hover:text-zinc-800! dark:text-zinc-500! dark:hover:text-white!" data-flux-button="data-flux-button" aria-label="Close modal">
        <svg class="shrink-0 [:where(&amp;)]:size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z"/>
</svg>
    </button>
</ui-close>
                </div>
                        </dialog>
</ui-modal>
<?php echo ltrim(ob_get_clean()); ?>

            <!-- CSS untuk x-cloak -->
            <style>
                [x-cloak] { display: none !important; }
            </style>

            <!-- MODAL DELETE - Responsive -->
            <?php ob_start(); ?><ui-modal wire:model.self="showDeleteModal" data-flux-modal>
    
    <dialog
        wire:ignore.self 
        class="p-6 [:where(&amp;)]:max-w-xl [:where(&amp;)]:min-w-xs shadow-lg rounded-xl bg-white dark:bg-zinc-800 ring ring-black/5 dark:ring-zinc-700 shadow-lg rounded-xl w-full max-w-md mx-4 sm:mx-auto"
                                <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => NULL,
); ?>
        x-data="fluxModal(<?php echo \Illuminate\Support\Js::from($scope['name'])->toHtml() ?>, <?php echo \Illuminate\Support\Js::from(isset($__livewire) ? $__livewire->getId() : null)->toHtml() ?>)"
        <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
        x-on:modal-show.document="handleShow($event)"
        x-on:modal-close.document="handleClose($event)"
    >
                    <?php ob_start(); ?>
                <div class="p-4 sm:p-6 text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center animate-pulse">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold mb-2">Delete Event</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                        Are you sure you want to delete event "<span class="font-semibold"><?php echo e($eventToDelete?->title); ?></span>"? This action cannot be undone.
                    </p>
                    <div class="flex justify-center gap-3">
                        <button wire:click="$set('showDeleteModal', false)" class="px-3 sm:px-4 py-1.5 sm:py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-all duration-200 text-sm">
                            Cancel
                        </button>
                        <button wire:click="delete" class="px-3 sm:px-4 py-1.5 sm:py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200 text-sm hover:scale-105 active:scale-95">
                            Yes, Delete
                        </button>
                    </div>
                </div>
            <?php echo trim(ob_get_clean()); ?>


                            <div class="absolute top-0 end-0 mt-4 me-4">
                    <ui-close data-flux-modal-close >
    <button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-8 text-sm rounded-md w-8 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-800 dark:text-white      text-zinc-400! hover:text-zinc-800! dark:text-zinc-500! dark:hover:text-white!" data-flux-button="data-flux-button" aria-label="Close modal">
        <svg class="shrink-0 [:where(&amp;)]:size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z"/>
</svg>
    </button>
</ui-close>
                </div>
                        </dialog>
</ui-modal>
<?php echo ltrim(ob_get_clean()); ?>

            <!-- Notifikasi - Responsive -->
            <div x-data="{ show: false, message: '', type: 'success' }" 
                 x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
                 x-show="show"
                 x-transition.duration.300ms
                 class="fixed bottom-3 right-3 sm:bottom-4 sm:right-4 z-50"
                 :class="{
                     'bg-green-500': type === 'success',
                     'bg-red-500': type === 'error',
                     'bg-yellow-500': type === 'warning'
                 }"
                 style="display: none;">
                <div class="text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg shadow-lg text-xs sm:text-sm">
                    <span x-text="message"></span>
                </div>
            </div>

            <style>
                [x-cloak] { display: none !important; }
                @media (max-width: 480px) {
                    .xs\:inline { display: inline; }
                }
            </style>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf744da513101cd09f149c6df9c59a801)): ?>
<?php $attributes = $__attributesOriginalf744da513101cd09f149c6df9c59a801; ?>
<?php unset($__attributesOriginalf744da513101cd09f149c6df9c59a801); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf744da513101cd09f149c6df9c59a801)): ?>
<?php $component = $__componentOriginalf744da513101cd09f149c6df9c59a801; ?>
<?php unset($__componentOriginalf744da513101cd09f149c6df9c59a801); ?>
<?php endif; ?>
</section><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/livewire/esd/activity/event-calendar.blade.php ENDPATH**/ ?>