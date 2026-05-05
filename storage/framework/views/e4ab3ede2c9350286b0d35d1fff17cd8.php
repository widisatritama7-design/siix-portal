<?php # [BlazeFolded]:{flux::heading}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/heading.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::input}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::icon}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::card}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::modal}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/modal/index.blade.php}:{1774988736} ?>
<section class="w-full" x-data="{ 
    showUpdateModal: false,
    isSaving: false,
    status: <?php if ((object) ('status') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('status'->value()); ?>')<?php echo e('status'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('status'); ?>')<?php endif; ?>,
    line_name: <?php if ((object) ('line_name') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('line_name'->value()); ?>')<?php echo e('line_name'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('line_name'); ?>')<?php endif; ?>,
    nik: <?php if ((object) ('nik') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('nik'->value()); ?>')<?php echo e('nik'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('nik'); ?>')<?php endif; ?>,
    input_count_stencil: <?php if ((object) ('input_count_stencil') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('input_count_stencil'->value()); ?>')<?php echo e('input_count_stencil'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('input_count_stencil'); ?>')<?php endif; ?>,
    register_no: <?php if ((object) ('register_no') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('register_no'->value()); ?>')<?php echo e('register_no'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('register_no'); ?>')<?php endif; ?>,
    employees: <?php echo e(json_encode($employees->toArray())); ?>,
    lineOptions: <?php echo e(json_encode($lineOptions->toArray())); ?>,
    searchEmployee: '',
    searchLine: '',
    showEmployeeDropdown: false,
    showLineDropdown: false
}">

    <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-sm [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2 sr-only" data-flux-heading><?php ob_start(); ?>
        <?php echo e(__('MTC - Stencil Management')); ?>

    <?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>

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
                        MTC
                    <?php echo trim(ob_get_clean()); ?>

                    </div>
    
            <svg class="shrink-0 [:where(&amp;)]:size-5 mx-1 text-zinc-300 dark:text-white/80 group-last/breadcrumb:hidden rtl:-scale-x-100" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M12.528 3.047a.75.75 0 0 1 .449.961L8.433 16.504a.75.75 0 1 1-1.41-.512l4.544-12.496a.75.75 0 0 1 .961-.449Z" clip-rule="evenodd"/>
</svg>

            </div>
<?php echo ltrim(ob_get_clean()); ?>
                    <?php ob_start(); ?><div class="flex items-center text-sm font-medium group/breadcrumb font-semibold text-blue-600 dark:text-blue-400" data-flux-breadcrumbs-item>
            <div class="text-gray-500 dark:text-white/80">
                            <?php ob_start(); ?>
                        Stencil Management
                    <?php echo trim(ob_get_clean()); ?>

                    </div>
    
            <svg class="shrink-0 [:where(&amp;)]:size-5 mx-1 text-zinc-300 dark:text-white/80 group-last/breadcrumb:hidden rtl:-scale-x-100" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M12.528 3.047a.75.75 0 0 1 .449.961L8.433 16.504a.75.75 0 1 1-1.41-.512l4.544-12.496a.75.75 0 0 1 .961-.449Z" clip-rule="evenodd"/>
</svg>

            </div>
<?php echo ltrim(ob_get_clean()); ?>
                <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
            </div>
         <?php $__env->endSlot(); ?>
        
         <?php $__env->slot('subheading', null, []); ?> 
            <div class="w-full">
                <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                    Stencil Management
                </h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    Manage stencil inventory and status
                </p>
            </div>
         <?php $__env->endSlot(); ?>
        
        <div class="-mt-2">
            <!-- Search Filter Section -->
            <div class="mb-4">
                <div class="flex justify-between items-center gap-4">
                    <div class="flex-1">
                        <?php ob_start(); ?><div class="w-full relative block group/input w-full" data-flux-input>
                            <div class="pointer-events-none absolute top-0 bottom-0 border-s border-transparent flex items-center justify-center text-xs text-zinc-400/75 dark:text-white/60 ps-3 start-0">
                    <svg class="shrink-0 [:where(&amp;)]:size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd"/>
</svg>

                        </div>
            
            <input
                type="text"
                
                class="w-full border rounded-lg block disabled:shadow-none dark:shadow-none appearance-none text-base sm:text-sm py-2 h-10 leading-[1.375rem] ps-10 pe-10 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500 shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5 data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500 disabled:data-invalid:border-red-500 dark:disabled:data-invalid:border-red-500" wire:model.live.debounce.300ms="search" placeholder="Search by Register No, Customer, Rack..."
                 name="search"                                                 <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => 'search',
  'invalid' => false,
); ?>
                <?php if ($scope['invalid'] || ($scope['name'] && $errors->has($scope['name']))): ?>
                aria-invalid="true" data-invalid
                <?php endif; ?>
                <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
                data-flux-control
                data-flux-group-target
                 wire:loading.class="pe-16"                  wire:target="search"             >

                            <div class="absolute top-0 bottom-0 flex items-center gap-x-1.5 pe-2 border-e border-transparent end-0 text-xs text-zinc-400">
                    
                                            <svg class="shrink-0 [:where(&amp;)]:size-5 animate-spin" wire:loading="" wire:target="search" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                            
                                            <button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-8 text-sm rounded-md w-8 inline-flex -ms-1.5 -me-1.5 bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white      -me-1 [[data-flux-input]:has(input:placeholder-shown)_&amp;]:hidden [[data-flux-input]:has(input[disabled])_&amp;]:hidden" data-flux-button="data-flux-button" x-data="fluxInputClearable" x-on:click="clear()" tabindex="-1" aria-label="Clear input" data-flux-clear-button="data-flux-clear-button">
        <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/>
</svg>
    </button>
                    
                    
                    
                    
                    
                                    </div>
                    </div>
<?php echo ltrim(ob_get_clean()); ?>
                    </div>
                    
                    <div class="flex gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search || $selectedStatus || $selectedCustomer): ?>
                        <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-8 text-sm rounded-md px-3 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-800 dark:text-white    *:transition-opacity [&amp;[data-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-flux-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-loading]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[data-flux-loading]&gt;[data-flux-loading-indicator]]:opacity-100 data-loading:pointer-events-none data-flux-loading:pointer-events-none" data-flux-button="data-flux-button" wire:target="resetFilters" wire:loading.attr="data-flux-loading" wire:click="resetFilters">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>
                            Clear All Filters
                        <?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

        <!-- Tabs Navigation -->
        <div class="mt-6 mb-6 border-b border-zinc-200 dark:border-zinc-700">
            <!-- Scrollable Tabs Container - Hidden scrollbar -->
            <div class="relative">
                <div class="overflow-x-auto scrollbar-hide">
                    <div class="flex flex-nowrap gap-1 min-w-max">
                        <button wire:click="setTab('in_use_with_line')" class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap <?php echo e($activeTab === 'in_use_with_line' ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200'); ?>">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M9.315 7.584C12.195 3.883 16.695 1.5 21.75 1.5a.75.75 0 0 1 .75.75c0 5.056-2.383 9.555-6.084 12.436A6.75 6.75 0 0 1 9.75 22.5a.75.75 0 0 1-.75-.75v-4.131A15.838 15.838 0 0 1 6.382 15H2.25a.75.75 0 0 1-.75-.75 6.75 6.75 0 0 1 7.815-6.666ZM15 6.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" clip-rule="evenodd" />
                                <path d="M5.26 17.242a.75.75 0 1 0-.897-1.203 5.243 5.243 0 0 0-2.05 5.022.75.75 0 0 0 .625.627 5.243 5.243 0 0 0 5.022-2.051.75.75 0 1 0-1.202-.897 3.744 3.744 0 0 1-3.008 1.51c0-1.23.592-2.323 1.51-3.008Z" />
                            </svg>
                            Use In Line
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full <?php echo e($activeTab === 'in_use_with_line' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400'); ?>">
                                <?php echo e($tabCounts['in_use_with_line'] ?? 0); ?>

                            </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'in_use_with_line'): ?> <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-emerald-600 dark:bg-emerald-400 rounded-t-full"></div> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </button>

                        <button wire:click="setTab('in_use')" class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap <?php echo e($activeTab === 'in_use' ? 'text-green-600 dark:text-green-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200'); ?>">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            In Use
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full <?php echo e($activeTab === 'in_use' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400'); ?>">
                                <?php echo e($tabCounts['in_use'] ?? 0); ?>

                            </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'in_use'): ?> <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-green-600 dark:bg-green-400 rounded-t-full"></div> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </button>

                        <button wire:click="setTab('prepared')" class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap <?php echo e($activeTab === 'prepared' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200'); ?>">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Prepared
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full <?php echo e($activeTab === 'prepared' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400'); ?>">
                                <?php echo e($tabCounts['prepared'] ?? 0); ?>

                            </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'prepared'): ?> <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600 dark:bg-blue-400 rounded-t-full"></div> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </button>

                        <button wire:click="setTab('cleaning')" class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap <?php echo e($activeTab === 'cleaning' ? 'text-red-600 dark:text-red-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200'); ?>">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 8H9L8 4z"></path>
                            </svg>
                            Cleaning
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full <?php echo e($activeTab === 'cleaning' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400'); ?>">
                                <?php echo e($tabCounts['cleaning'] ?? 0); ?>

                            </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'cleaning'): ?> <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-red-600 dark:bg-red-400 rounded-t-full"></div> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </button>

                        <button wire:click="setTab('stand_by')" class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap <?php echo e($activeTab === 'stand_by' ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200'); ?>">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Stand By
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full <?php echo e($activeTab === 'stand_by' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400'); ?>">
                                <?php echo e($tabCounts['stand_by'] ?? 0); ?>

                            </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'stand_by'): ?> <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-yellow-600 dark:bg-yellow-400 rounded-t-full"></div> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </button>

                        <button wire:click="setTab('disposed')" class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap <?php echo e($activeTab === 'disposed' ? 'text-gray-600 dark:text-gray-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200'); ?>">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Disposed
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full <?php echo e($activeTab === 'disposed' ? 'bg-gray-200 text-gray-800 dark:bg-gray-800 dark:text-gray-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400'); ?>">
                                <?php echo e($tabCounts['disposed'] ?? 0); ?>

                            </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'disposed'): ?> <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gray-600 dark:bg-gray-400 rounded-t-full"></div> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </button>

                        <button wire:click="setTab('all')" class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap <?php echo e($activeTab === 'all' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200'); ?>">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            All
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full <?php echo e($activeTab === 'all' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400'); ?>">
                                <?php echo e($tabCounts['all'] ?? 0); ?>

                            </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'all'): ?> <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600 dark:bg-blue-400 rounded-t-full"></div> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add this CSS to your stylesheet or in a <style> tag -->
        <style>
            /* Hide scrollbar for Chrome, Safari and Opera */
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
            
            /* Hide scrollbar for IE, Edge and Firefox */
            .scrollbar-hide {
                -ms-overflow-style: none;  /* IE and Edge */
                scrollbar-width: none;  /* Firefox */
            }
        </style>

            <!-- Stencil Table -->
            <?php ob_start(); ?><div class="[:where(&amp;)]:bg-white dark:[:where(&amp;)]:bg-white/10 border border-zinc-200 dark:border-white/10 [:where(&amp;)]:p-6 [:where(&amp;)]:rounded-xl p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 w-full" data-flux-card>
    <?php ob_start(); ?>
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Register No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Customer</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Rack Number</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Line Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Count</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Last Update</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Last Update By</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $stencils; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stencil): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-4 py-3">
                                    <span class="text-sm font-semibold text-zinc-800 dark:text-white">
                                        <?php echo e($stencil->register_no); ?>

                                    </span>
                                
    
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        <?php echo e($stencil->customer ?? '-'); ?>

                                    </span>
                                
    
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        <?php echo e($stencil->rack_number ?? '-'); ?>

                                    </span>
                                
    
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($this->getStatusColorClass($stencil->status)); ?>">
                                        <?php echo e($stencil->status); ?>

                                    </span>
                                
    
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        <?php echo e($stencil->line_name ?? '-'); ?>

                                    </span>
                                
    
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        <?php echo e($stencil->count_stencil ?? '-'); ?>

                                    </span>
                                
    
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        <?php echo e($stencil->updated_at ? $stencil->updated_at->format('d/m/Y H:i') : '-'); ?>

                                    </span>
                                
    
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        <?php echo e($stencil->employee->name ?? '-'); ?>

                                    </span>
                                
    
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                        <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-8 text-sm rounded-md w-8 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] *:transition-opacity [&amp;[data-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-flux-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-loading]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[data-flux-loading]&gt;[data-flux-loading-indicator]]:opacity-100 data-loading:pointer-events-none data-flux-loading:pointer-events-none [--color-accent:var(--color-purple-500)] [--color-accent-content:var(--color-purple-600)] [--color-accent-foreground:var(--color-white)] dark:[--color-accent:var(--color-purple-500)] dark:[--color-accent-content:var(--color-purple-300)] dark:[--color-accent-foreground:var(--color-white)] !p-2 flex-shrink-0" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" wire:target="viewActivity(<?php echo e($stencil->id); ?>)" wire:loading.attr="data-flux-loading" wire:click="viewActivity(<?php echo e($stencil->id); ?>)" title="View activity log">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-5 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
                    <svg class="shrink-0 [:where(&amp;)]:size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 0 0 3 3.5v13A1.5 1.5 0 0 0 4.5 18h11a1.5 1.5 0 0 0 1.5-1.5V7.621a1.5 1.5 0 0 0-.44-1.06l-4.12-4.122A1.5 1.5 0 0 0 11.378 2H4.5Zm2.25 8.5a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Zm0 3a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Z" clip-rule="evenodd"/>
</svg>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit stencil')): ?>
                                        <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-8 text-sm rounded-md w-8 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] *:transition-opacity [&amp;[data-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-flux-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-loading]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[data-flux-loading]&gt;[data-flux-loading-indicator]]:opacity-100 data-loading:pointer-events-none data-flux-loading:pointer-events-none [--color-accent:var(--color-yellow-400)] [--color-accent-content:var(--color-yellow-600)] [--color-accent-foreground:var(--color-yellow-950)] dark:[--color-accent:var(--color-yellow-400)] dark:[--color-accent-content:var(--color-yellow-400)] dark:[--color-accent-foreground:var(--color-yellow-950)] !p-2 flex-shrink-0" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" wire:target="updateStatus(<?php echo e($stencil->id); ?>)" wire:loading.attr="data-flux-loading" wire:click="updateStatus(<?php echo e($stencil->id); ?>)" @click="showUpdateModal = true" title="Update status">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-5 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
                    <svg class="shrink-0 [:where(&amp;)]:size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z"/>
  <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z"/>
</svg>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
                                        <?php endif; ?>
                                    </div>
                                
    
                             </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                             <tr>
                                <td colspan="9" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 w-10 h-10 text-zinc-400 dark:text-zinc-500" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No stencil records found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                                <?php echo e($search || $selectedStatus || $selectedCustomer ? 'Try adjusting your search or filter' : 'No data available'); ?>

                                            </p>
                                        </div>
                                    </div>
                                
 
                             </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($stencils->hasPages()): ?>
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                    <?php echo e($stencils->links()); ?>

                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
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

    <!-- Update Status Modal -->
    <div x-show="showUpdateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showUpdateModal = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-2xl" @click.stop>
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-800 dark:to-blue-900 rounded-t-2xl px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-white/20 rounded-xl">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Update Status & NIK</h3>
                                <p class="text-xs text-blue-100 mt-0.5">Update stencil information</p>
                            </div>
                        </div>
                        <button @click="showUpdateModal = false" class="text-white/80 hover:text-white transition-colors duration-200 p-1 rounded-lg hover:bg-white/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    <div class="space-y-5">
                        <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-xl p-4 border border-gray-200 dark:border-zinc-700">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Register Number</label>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                                <input type="text" x-model="register_no" readonly class="flex-1 rounded-lg border-gray-200 dark:border-zinc-600 bg-white dark:bg-zinc-800 px-3 py-2 text-sm font-mono font-semibold cursor-not-allowed">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Status <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <label class="relative flex cursor-pointer">
                                    <input type="radio" x-model="status" value="In Use" @change="$wire.set('status', status)" class="peer sr-only">
                                    <div class="w-full p-3 rounded-lg border-2 transition-all duration-200 peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20 border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-md">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">In Use</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative flex cursor-pointer">
                                    <input type="radio" x-model="status" value="Prepared" @change="$wire.set('status', status)" class="peer sr-only">
                                    <div class="w-full p-3 rounded-lg border-2 transition-all duration-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-md">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                            <span class="text-sm font-medium">Prepared</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative flex cursor-pointer">
                                    <input type="radio" x-model="status" value="Cleaning" @change="$wire.set('status', status)" class="peer sr-only">
                                    <div class="w-full p-3 rounded-lg border-2 transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/20 border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-md">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 8H9L8 4z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">Cleaning</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative flex cursor-pointer">
                                    <input type="radio" x-model="status" value="Stand By" @change="$wire.set('status', status)" class="peer sr-only">
                                    <div class="w-full p-3 rounded-lg border-2 transition-all duration-200 peer-checked:border-yellow-500 peer-checked:bg-yellow-50 dark:peer-checked:bg-yellow-900/20 border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-md">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">Stand By</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative flex cursor-pointer">
                                    <input type="radio" x-model="status" value="Disposed" @change="$wire.set('status', status)" class="peer sr-only">
                                    <div class="w-full p-3 rounded-lg border-2 transition-all duration-200 peer-checked:border-gray-500 peer-checked:bg-gray-50 dark:peer-checked:bg-gray-900/20 border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-md">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">Disposed</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div x-show="['In Use', 'Prepared'].includes(status)" x-cloak>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Line Name <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                    </div>
                                    <input type="text" x-model="searchLine" @input="showLineDropdown = searchLine.trim().length > 0" @focus="showLineDropdown = true" :placeholder="line_name ? line_name : 'Select or search line...'" class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div x-show="showLineDropdown" @click.outside="showLineDropdown = false" class="absolute z-50 w-full mt-2 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-lg max-h-60 overflow-y-auto" style="display: none;">
                                    <template x-for="(label, value) in lineOptions" :key="value">
                                        <div x-show="label.toLowerCase().includes(searchLine.toLowerCase()) || value.toLowerCase().includes(searchLine.toLowerCase())" @click="line_name = value; searchLine = label; showLineDropdown = false; $wire.set('line_name', value);" class="px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 cursor-pointer transition-colors">
                                            <span class="text-sm" x-text="label"></span>
                                        </div>
                                    </template>
                                    <div x-show="Object.keys(lineOptions).filter(key => lineOptions[key].toLowerCase().includes(searchLine.toLowerCase()) || key.toLowerCase().includes(searchLine.toLowerCase())).length === 0" class="px-4 py-3 text-sm text-gray-500 text-center">No lines found</div>
                                </div>
                                <input type="hidden" x-model="line_name" @change="$wire.set('line_name', line_name)">
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['line_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div x-show="status === 'Cleaning'" x-cloak>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Count Last Use Stencil <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                </div>
                                <input type="number" x-model="input_count_stencil" @input="$wire.set('input_count_stencil', input_count_stencil)" placeholder="Enter count number" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-600 dark:text-white" min="1">
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['input_count_stencil'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">NIK / Employee <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" x-model="searchEmployee" @input="showEmployeeDropdown = searchEmployee.trim().length > 0" @focus="showEmployeeDropdown = true" placeholder="Search by NIK or name..." class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div x-show="showEmployeeDropdown" @click.outside="showEmployeeDropdown = false" class="absolute z-50 w-full mt-2 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-lg max-h-60 overflow-y-auto" style="display: none;">
                                    <template x-for="(label, value) in employees" :key="value">
                                        <div x-show="label.toLowerCase().includes(searchEmployee.toLowerCase()) || value.includes(searchEmployee)" @click="nik = value; searchEmployee = label; showEmployeeDropdown = false; $wire.set('nik', value);" class="px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 cursor-pointer transition-colors">
                                            <span class="text-sm" x-text="label"></span>
                                        </div>
                                    </template>
                                </div>
                                <input type="hidden" x-model="nik" @change="$wire.set('nik', nik)">
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-600 mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-b-2xl px-6 py-4 flex justify-end gap-3">
                    <button @click="showUpdateModal = false" class="px-5 py-2.5 border border-gray-300 dark:border-zinc-600 rounded-xl hover:bg-gray-100 dark:hover:bg-zinc-700 transition-all duration-200 font-medium text-sm">Cancel</button>
                    <button wire:click="saveStatusUpdate" wire:loading.attr="disabled" :disabled="isSaving" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 font-medium text-sm shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="saveStatusUpdate">
                            <svg class="inline w-4 h-4 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Changes
                        </span>
                        <span wire:loading wire:target="saveStatusUpdate">
                            <svg class="inline w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Saving...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ACTIVITY LOG -->
    <?php ob_start(); ?><ui-modal wire:model.self="showActivityModal" data-flux-modal>
    
    <dialog
        wire:ignore.self 
        class="p-6 [:where(&amp;)]:max-w-xl [:where(&amp;)]:min-w-xs shadow-lg rounded-xl bg-white dark:bg-zinc-800 ring ring-black/5 dark:ring-zinc-700 shadow-lg rounded-xl w-full max-w-5xl"
                                <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => NULL,
); ?>
        x-data="fluxModal(<?php echo \Illuminate\Support\Js::from($scope['name'])->toHtml() ?>, <?php echo \Illuminate\Support\Js::from(isset($__livewire) ? $__livewire->getId() : null)->toHtml() ?>)"
        <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
        x-on:modal-show.document="handleShow($event)"
        x-on:modal-close.document="handleClose($event)"
    >
                    <?php ob_start(); ?>
        <div class="flex flex-col" style="height: auto; max-height: 85vh; overflow: hidden;">
            <div class="flex justify-between items-center px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex-shrink-0">
                <div>
                    <h2 class="text-xl font-bold text-zinc-800 dark:text-white">Activity Log</h2>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedStencilForActivity): ?>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        Stencil: <span class="font-semibold"><?php echo e($selectedStencilForActivity->register_no); ?></span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedStencilForActivity->customer): ?> | Customer: <span class="font-semibold"><?php echo e($selectedStencilForActivity->customer); ?></span> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedStencilForActivity): ?>
            <?php
                $activitiesData = $activities;
                $totalRecords = $activitiesData->total();
                $lastPage = $activitiesData->lastPage();
                $allUsers = \App\Models\User::all()->keyBy('id');
                $allEmployees = \App\Models\HR\Employee::all()->keyBy('id');
            ?>
            
            <div class="flex-1 overflow-y-auto p-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalRecords > 0): ?>
                    <div class="space-y-4">
                        <div class="flex gap-2 mb-2">
                            <span class="px-2 py-1 rounded-full text-white font-bold bg-red-600 text-xs">Old Value</span>
                            <span class="px-2 py-1 rounded-full text-white font-bold bg-green-600 text-xs">New Value</span>
                        </div>

                        <div class="space-y-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $activitiesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <?php
                                    $attributeChanges = is_string($activity->attribute_changes) ? json_decode($activity->attribute_changes, true) : ($activity->attribute_changes ?? []);
                                    $old = $attributeChanges['old'] ?? [];
                                    $new = $attributeChanges['attributes'] ?? [];
                                    
                                    if (empty($old) && empty($new)) {
                                        $props = is_string($activity->properties) ? json_decode($activity->properties, true) : ($activity->properties ?? []);
                                        $old = $props['old'] ?? [];
                                        $new = $props['attributes'] ?? [];
                                    }
                                    
                                    $changes = [];
                                    if ($activity->event == 'created') {
                                        foreach ($new as $key => $val) {
                                            if (!in_array($key, ['created_by', 'updated_by', 'id', 'created_at', 'updated_at'])) {
                                                $changes[$key] = ['old' => null, 'new' => $val];
                                            }
                                        }
                                    } elseif ($activity->event == 'updated') {
                                        foreach ($new as $key => $val) {
                                            $oldVal = $old[$key] ?? null;
                                            if ($oldVal !== $val && !in_array($key, ['created_by', 'updated_by', 'id', 'created_at', 'updated_at'])) {
                                                $changes[$key] = ['old' => $oldVal, 'new' => $val];
                                            }
                                        }
                                    } elseif ($activity->event == 'deleted') {
                                        foreach ($old as $key => $val) {
                                            if (!in_array($key, ['created_by', 'updated_by', 'id', 'created_at', 'updated_at'])) {
                                                $changes[$key] = ['old' => $val, 'new' => null];
                                            }
                                        }
                                    }
                                    
                                    $isFirst = $loop->first;
                                ?>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($changes)): ?>
                                <div x-data="{ open: <?php echo e($isFirst ? 'true' : 'false'); ?> }" class="border rounded-lg shadow-sm bg-white dark:bg-zinc-900">
                                    <button type="button" @click="open = !open" class="w-full flex justify-between items-center px-4 py-3 text-left font-medium bg-gray-100 hover:bg-gray-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 rounded-t-lg">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activity->event == 'created'): ?>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                    CREATED
                                                </span>
                                            <?php elseif($activity->event == 'updated'): ?>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    UPDATED
                                                </span>
                                            <?php elseif($activity->event == 'deleted'): ?>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    DELETED
                                                </span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <strong class="text-sm text-zinc-800 dark:text-zinc-200"><?php echo e($activity->causer?->name ?? 'System'); ?></strong>
                                            <span class="text-xs text-zinc-500"><?php echo e($activity->created_at ? $activity->created_at->format('d M Y H:i:s') : '-'); ?></span>
                                        </div>
                                        <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transform transition-transform text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div x-show="open" x-transition class="p-4 space-y-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $changes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $change): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <?php
                                                $oldValue = $change['old'];
                                                $newValue = $change['new'];
                                                $fieldName = ucfirst(str_replace('_', ' ', $field));
                                                
                                                // Handle field nik - ambil nama employee berdasarkan kolom ID
                                                if ($field === 'nik') {
                                                    if (!empty($oldValue)) {
                                                        $employee = $allEmployees[$oldValue] ?? null;
                                                        $oldValue = $employee ? $employee->name . ' (' . $employee->nik . ')' : $oldValue;
                                                    }
                                                    if (!empty($newValue)) {
                                                        $employee = $allEmployees[$newValue] ?? null;
                                                        $newValue = $employee ? $employee->name . ' (' . $employee->nik . ')' : $newValue;
                                                    }
                                                }
                                                
                                                // Handle field created_by, updated_by
                                                if (in_array($field, ['created_by', 'updated_by']) && is_numeric($oldValue)) {
                                                    $oldValue = $allUsers[$oldValue]?->name ?? $oldValue;
                                                }
                                                if (in_array($field, ['created_by', 'updated_by']) && is_numeric($newValue)) {
                                                    $newValue = $allUsers[$newValue]?->name ?? $newValue;
                                                }
                                                
                                                $displayOld = $oldValue ?? '-';
                                                $displayNew = $newValue ?? '-';
                                            ?>

                                            <div class="text-sm flex items-center gap-2 flex-wrap">
                                                <span class="font-semibold min-w-[100px]"><?php echo e($fieldName); ?>:</span>
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activity->event == 'created'): ?>
                                                        <span class="px-2 py-0.5 rounded-full text-white font-bold bg-green-600 text-xs"><?php echo e($displayNew); ?></span>
                                                    <?php elseif($activity->event == 'deleted'): ?>
                                                        <span class="px-2 py-0.5 rounded-full text-white font-bold bg-red-600 text-xs"><?php echo e($displayOld); ?></span>
                                                    <?php else: ?>
                                                        <span class="px-2 py-0.5 rounded-full text-white font-bold bg-red-600 line-through text-xs"><?php echo e($displayOld); ?></span>
                                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                        </svg>
                                                        <span class="px-2 py-0.5 rounded-full text-white font-bold bg-green-600 text-xs"><?php echo e($displayNew); ?></span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lastPage > 1): ?>
                        <div class="flex justify-between items-center mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                Showing <?php echo e($activitiesData->firstItem()); ?> to <?php echo e($activitiesData->lastItem()); ?> of <?php echo e($totalRecords); ?> records
                            </div>
                            <div class="flex gap-2">
                                <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-8 text-sm rounded-md px-3 inline-flex  bg-white hover:bg-zinc-50 dark:bg-zinc-700 dark:hover:bg-zinc-600/75 text-zinc-800 dark:text-white border border-zinc-200 hover:border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600 dark:hover:border-zinc-600 shadow-xs [[data-flux-button-group]_&amp;]:border-s-0 [:is([data-flux-button-group]&gt;&amp;:first-child,_[data-flux-button-group]_:first-child&gt;&amp;)]:border-s-[1px] *:transition-opacity [&amp;[data-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-flux-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-loading]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[data-flux-loading]&gt;[data-flux-loading-indicator]]:opacity-100 data-loading:pointer-events-none data-flux-loading:pointer-events-none  !px-3" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" wire:target="setActivityPage(<?php echo e($activityPage - 1); ?>)" wire:loading.attr="data-flux-loading" wire:click="setActivityPage(<?php echo e($activityPage - 1); ?>)" <?php if (($__blazeAttr = $activityPage <= 1) !== false && !is_null($__blazeAttr)): ?>disabled="<?php echo e($__blazeAttr === true ? 'disabled' : $__blazeAttr); ?>"<?php endif; unset($__blazeAttr); ?>>
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>Previous<?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= $lastPage; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($i == $activityPage): ?>
                                        <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-8 text-sm rounded-md px-3 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)]   !px-3" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target">
        <?php ob_start(); ?><?php echo e($i); ?><?php echo trim(ob_get_clean()); ?>

    </button>
<?php echo ltrim(ob_get_clean()); ?>
                                    <?php elseif($i == 1 || $i == $lastPage || ($i >= $activityPage - 1 && $i <= $activityPage + 1)): ?>
                                        <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-8 text-sm rounded-md px-3 inline-flex  bg-white hover:bg-zinc-50 dark:bg-zinc-700 dark:hover:bg-zinc-600/75 text-zinc-800 dark:text-white border border-zinc-200 hover:border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600 dark:hover:border-zinc-600 shadow-xs [[data-flux-button-group]_&amp;]:border-s-0 [:is([data-flux-button-group]&gt;&amp;:first-child,_[data-flux-button-group]_:first-child&gt;&amp;)]:border-s-[1px] *:transition-opacity [&amp;[data-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-flux-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-loading]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[data-flux-loading]&gt;[data-flux-loading-indicator]]:opacity-100 data-loading:pointer-events-none data-flux-loading:pointer-events-none  !px-3" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" wire:target="setActivityPage(<?php echo e($i); ?>)" wire:loading.attr="data-flux-loading" wire:click="setActivityPage(<?php echo e($i); ?>)">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?><?php echo e($i); ?><?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
                                    <?php elseif($i == $activityPage - 2 || $i == $activityPage + 2): ?>
                                        <span class="px-2 py-1 text-sm text-zinc-500 dark:text-zinc-400">...</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-8 text-sm rounded-md px-3 inline-flex  bg-white hover:bg-zinc-50 dark:bg-zinc-700 dark:hover:bg-zinc-600/75 text-zinc-800 dark:text-white border border-zinc-200 hover:border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600 dark:hover:border-zinc-600 shadow-xs [[data-flux-button-group]_&amp;]:border-s-0 [:is([data-flux-button-group]&gt;&amp;:first-child,_[data-flux-button-group]_:first-child&gt;&amp;)]:border-s-[1px] *:transition-opacity [&amp;[data-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-flux-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-loading]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[data-flux-loading]&gt;[data-flux-loading-indicator]]:opacity-100 data-loading:pointer-events-none data-flux-loading:pointer-events-none  !px-3" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" wire:target="setActivityPage(<?php echo e($activityPage + 1); ?>)" wire:loading.attr="data-flux-loading" wire:click="setActivityPage(<?php echo e($activityPage + 1); ?>)" <?php if (($__blazeAttr = $activityPage >= $lastPage) !== false && !is_null($__blazeAttr)): ?>disabled="<?php echo e($__blazeAttr === true ? 'disabled' : $__blazeAttr); ?>"<?php endif; unset($__blazeAttr); ?>>
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>Next<?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
                            </div>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="mt-4 text-sm text-zinc-500 dark:text-zinc-400">No activity logs found for this stencil</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
</section><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/livewire/mtc/master/stencil-management.blade.php ENDPATH**/ ?>