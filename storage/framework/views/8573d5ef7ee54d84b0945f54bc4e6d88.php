<?php # [BlazeFolded]:{flux::heading}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/heading.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/index.blade.php}:{1774988736} ?>
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
                        Calendar
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
                        <h1 class="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white">
                            ESD Measurement Schedule
                        </h1>
                        <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">
                            Control And Monitor Your ESD Schedule
                        </p>
                    </div>
                    <!-- TOMBOL REFRESH ALL -->
                    <div>
                        <button wire:click="refreshAllCards"
                            wire:loading.attr="disabled"
                            wire:target="refreshAllCards"
                            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold py-2 px-4 rounded-full transition-all duration-200 hover:scale-105 shadow-md">
                            <!-- Icon normal (tidak loading) -->
                            <svg wire:loading.remove wire:target="refreshAllCards" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
                            </svg>
                            <!-- Icon loading (sama tapi diputer) -->
                            <svg wire:loading wire:target="refreshAllCards" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 animate-spin">
                                <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
                            </svg>
                            <span wire:loading.remove wire:target="refreshAllCards">Refresh All</span>
                            <span wire:loading wire:target="refreshAllCards">Refreshing...</span>
                        </button>
                    </div>
                </div>
            </div>
         <?php $__env->endSlot(); ?>
        
        <div class="-mt-2">
            <!-- Grid auto-fill dengan card ukuran sedang -->
            <div class="grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $sortedTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-md border border-zinc-200 dark:border-zinc-700 p-3.5 hover:shadow-lg transition-all duration-300">
                    
                    <!-- Navigation dengan Icon SVG -->
                    <div class="flex justify-between items-center mb-3">
                        <button wire:click="goToPrevMonth('<?php echo e($type); ?>')" 
                                class="bg-blue-600 hover:bg-blue-700 text-white p-1.5 rounded-full transition-all duration-200 hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-4.28 9.22a.75.75 0 0 0 0 1.06l3 3a.75.75 0 1 0 1.06-1.06l-1.72-1.72h5.69a.75.75 0 0 0 0-1.5h-5.69l1.72-1.72a.75.75 0 0 0-1.06-1.06l-3 3Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <span class="font-semibold text-gray-800 dark:text-white text-xs sm:text-sm text-center truncate mx-1">
                            <?php echo e($this->getMonthName($type)); ?>

                        </span>
                        <button wire:click="goToNextMonth('<?php echo e($type); ?>')" 
                                class="bg-blue-600 hover:bg-blue-700 text-white p-1.5 rounded-full transition-all duration-200 hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm4.28 10.28a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 1 0-1.06 1.06l1.72 1.72H8.25a.75.75 0 0 0 0 1.5h5.69l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <!-- Badges - rounded-full -->
                    <div class="mb-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($typeCodes[$type] ?? '-') !== '-'): ?>
                            <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white py-1.5 px-3 rounded-full text-[11px] sm:text-xs font-bold text-center truncate shadow-sm">
                                <?php echo e($typeCodes[$type]); ?>

                            </div>
                            <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white py-1 px-3 rounded-full text-[10px] sm:text-[11px] font-bold text-center mt-1.5 truncate shadow-sm">
                                <?php echo e($displayNames[$type]); ?>

                            </div>
                        <?php else: ?>
                            <div class="bg-gray-500 text-white py-1.5 px-3 rounded-full text-[11px] sm:text-xs font-bold text-center shadow-sm">
                                -
                            </div>
                            <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white py-1 px-3 rounded-full text-[10px] sm:text-[11px] font-bold text-center mt-1.5 truncate shadow-sm">
                                <?php echo e($displayNames[$type]); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Calendar Table -->
                    <div>
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="text-gray-500 dark:text-gray-400 text-[10px] sm:text-xs py-1 text-center font-medium">S</th>
                                    <th class="text-gray-500 dark:text-gray-400 text-[10px] sm:text-xs py-1 text-center font-medium">M</th>
                                    <th class="text-gray-500 dark:text-gray-400 text-[10px] sm:text-xs py-1 text-center font-medium">T</th>
                                    <th class="text-gray-500 dark:text-gray-400 text-[10px] sm:text-xs py-1 text-center font-medium">W</th>
                                    <th class="text-gray-500 dark:text-gray-400 text-[10px] sm:text-xs py-1 text-center font-medium">T</th>
                                    <th class="text-gray-500 dark:text-gray-400 text-[10px] sm:text-xs py-1 text-center font-medium">F</th>
                                    <th class="text-gray-500 dark:text-gray-400 text-[10px] sm:text-xs py-1 text-center font-medium">S</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->getCalendarWeeks($type); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $week; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($day): ?>
                                            <?php
                                                $eventCount = $this->getEventCount($type, $day['date']);
                                                $badgeColor = $this->getBadgeColor($type, $day['date']);
                                                $displayCount = $eventCount > 99 ? '99+' : $eventCount;
                                            ?>
                                            <td class="p-0.5 text-center align-middle">
                                                <button wire:click="selectDate('<?php echo e($type); ?>', '<?php echo e($day['date']); ?>')"
                                                        class="relative w-full py-1.5 rounded-xl transition-all duration-200 text-xs sm:text-sm font-semibold
                                                        <?php echo e($day['isSelected'] ? 'bg-blue-600 text-white shadow-md scale-95' : 'bg-gray-100 dark:bg-zinc-700 text-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-zinc-600 hover:scale-95'); ?>">
                                                    <?php echo e($day['day']); ?>

                                                    
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($eventCount > 0): ?>
                                                        <span class="absolute -top-1 -right-1 text-white text-[9px] sm:text-[10px] rounded-full min-w-[16px] h-4 flex items-center justify-center font-bold shadow-md
                                                            <?php echo e($badgeColor == 'green' ? 'bg-green-600' : ($badgeColor == 'yellow' ? 'bg-yellow-500' : 'bg-red-600')); ?>

                                                            px-0.5">
                                                            <?php echo e($displayCount); ?>

                                                        </span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </button>
                                            </button>
                                        </td>
                                        <?php else: ?>
                                            <td class="p-0.5">
                                                <div class="w-full py-1.5"></div>
                                            </td>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Event List - Scroll hanya di sini -->
                    <div class="mt-3">
                        <div class="max-h-[130px] overflow-y-auto space-y-1.5 pr-0.5">
                            <?php
                                $selectedDateForCard = $selectedDate[$type] ?? date('Y-m-d');
                                $dayEvents = $this->getEventsForDate($type, $selectedDateForCard);
                            ?>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($dayEvents) === 0): ?>
                                <div class="text-center text-gray-400 text-[10px] sm:text-xs py-2 bg-gray-50 dark:bg-zinc-800/50 rounded-xl">
                                    No events
                                </div>
                            <?php else: ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $dayEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <?php
                                        $detailUrl = $this->getDetailUrl($type, $event['detail_foreign_key']);
                                    ?>
                                    <a href="<?php echo e($detailUrl); ?>" 
                                       target="_blank"
                                       class="block transition-all duration-200 hover:translate-x-0.5">
                                       <div class="flex items-center justify-between p-1.5 rounded-xl text-[10px] sm:text-xs
                                            <?php echo e($event['hasActual'] ? 'bg-green-50 dark:bg-green-900/20 border-l-2 border-green-500' : 'bg-red-50 dark:bg-red-900/20 border-l-2 border-red-500'); ?>">
                                            
                                            <span class="flex-1 truncate mr-1 font-medium">
                                                <?php echo e($event['title']); ?>

                                            </span>

                                            <!-- ICON -->
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event['hasActual']): ?>
                                                <!-- CHECK (HIJAU) -->
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                    class="w-4 h-4 sm:w-5 sm:h-5 text-green-600 flex-shrink-0">
                                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                                </svg>
                                            <?php else: ?>
                                                <!-- CROSS (MERAH) -->
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                    class="w-4 h-4 sm:w-5 sm:h-5 text-red-600 flex-shrink-0">
                                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                                </svg>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </a>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
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
</section>

<?php $__env->startPush('styles'); ?>
<style>
    /* Fully responsive grid - auto adjust */
    .grid {
        display: grid !important;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)) !important;
        gap: 1rem !important;
    }
    
    /* Card styling */
    .rounded-2xl {
        border-radius: 0.5rem !important;
    }
    
    /* Hover effect card */
    .bg-white, .dark\:bg-zinc-800 {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .bg-white:hover, .dark\:bg-zinc-800:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
    }
    
    /* Button rounded full */
    button {
        border-radius: 9999px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Badge timbul */
    .absolute {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        z-index: 10;
    }
    
    /* Table spacing */
    table {
        border-collapse: separate;
        border-spacing: 3px;
        width: 100%;
    }
    
    /* Scroll hanya untuk event list */
    .overflow-y-auto {
        overflow-y: auto;
        scrollbar-width: thin;
    }
    
    .overflow-y-auto::-webkit-scrollbar {
        width: 4px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-track {
        background: #e2e8f0;
        border-radius: 10px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #94a3b8;
        border-radius: 10px;
    }
    
    .dark .overflow-y-auto::-webkit-scrollbar-track {
        background: #1e293b;
    }
    
    .dark .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #475569;
    }
    
    /* Truncate */
    .truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    /* Animasi spin */
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    /* Responsive */
    @media (max-width: 640px) {
        .grid {
            gap: 0.75rem !important;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)) !important;
        }
        table {
            border-spacing: 2px;
        }
    }
    
    /* Animasi klik */
    button:active {
        transform: scale(0.96);
    }
</style>
<?php $__env->stopPush(); ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/livewire/esd/activity/esd-calendar.blade.php ENDPATH**/ ?>