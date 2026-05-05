<?php # [BlazeFolded]:{flux::sidebar.toggle}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/sidebar/toggle.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::navbar}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/navbar/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::spacer}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/spacer.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::navbar}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/navbar/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::header}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/header.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::sidebar.collapse}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/sidebar/collapse.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::sidebar.header}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/sidebar/header.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::sidebar.nav}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/sidebar/nav.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::spacer}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/spacer.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::sidebar.nav}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/sidebar/nav.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::sidebar}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/sidebar/index.blade.php}:{1774988736} ?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="dark">
    <head>
        <?php echo $__env->make('partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <?php ob_start(); ?><?php $__blaze->pushData(['container' => true, 'class' => 'border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900']); $__env->pushConsumableComponentData(['container' => true, 'class' => 'border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900']); ?><header class="[grid-area:header] z-10 min-h-14  border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900" data-flux-header>
            <div class="mx-auto w-full h-full [:where(&)]:max-w-7xl px-6 lg:px-8 flex items-center">
            <?php ob_start(); ?>
            <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg w-10 inline-flex -ms-2.5 bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white      shrink-0 lg:hidden mr-2" data-flux-button="data-flux-button" x-data="" x-on:click="$dispatch('flux-sidebar-toggle')" aria-label="Toggle sidebar" data-flux-sidebar-toggle="data-flux-sidebar-toggle">
        <svg class="shrink-0 [:where(&amp;)]:size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M2 6.75A.75.75 0 0 1 2.75 6h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 6.75Zm0 6.5a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd"/>
</svg>
    </button>
<?php echo ltrim(ob_get_clean()); ?>

            <?php if (isset($component)) { $__componentOriginal7b17d80ff7900603fe9e5f0b453cc7c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b17d80ff7900603fe9e5f0b453cc7c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-logo','data' => ['href' => ''.e(route('dashboard')).'','wire:navigate' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('dashboard')).'','wire:navigate' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7b17d80ff7900603fe9e5f0b453cc7c3)): ?>
<?php $attributes = $__attributesOriginal7b17d80ff7900603fe9e5f0b453cc7c3; ?>
<?php unset($__attributesOriginal7b17d80ff7900603fe9e5f0b453cc7c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7b17d80ff7900603fe9e5f0b453cc7c3)): ?>
<?php $component = $__componentOriginal7b17d80ff7900603fe9e5f0b453cc7c3; ?>
<?php unset($__componentOriginal7b17d80ff7900603fe9e5f0b453cc7c3); ?>
<?php endif; ?>

            <?php ob_start(); ?><?php $__blaze->pushData(['class' => '-mb-px max-lg:hidden']); $__env->pushConsumableComponentData(['class' => '-mb-px max-lg:hidden']); ?><nav class="flex items-center gap-1 py-3  -mb-px max-lg:hidden" data-flux-navbar>
    <?php ob_start(); ?>
                <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/navbar/item.blade.php', $__blaze->compiledPath.'/fd73a7f77e5a3bfdf8a3f62e646a8641.php'); ?>
<?php if (isset($__slotsfd73a7f77e5a3bfdf8a3f62e646a8641)) { $__slotsStackfd73a7f77e5a3bfdf8a3f62e646a8641[] = $__slotsfd73a7f77e5a3bfdf8a3f62e646a8641; } ?>
<?php if (isset($__attrsfd73a7f77e5a3bfdf8a3f62e646a8641)) { $__attrsStackfd73a7f77e5a3bfdf8a3f62e646a8641[] = $__attrsfd73a7f77e5a3bfdf8a3f62e646a8641; } ?>
<?php $__attrsfd73a7f77e5a3bfdf8a3f62e646a8641 = ['icon' => 'layout-grid','href' => route('dashboard'),'current' => request()->routeIs('dashboard'),'wire:navigate' => true]; ?>
<?php $__slotsfd73a7f77e5a3bfdf8a3f62e646a8641 = []; ?>
<?php $__blaze->pushData($__attrsfd73a7f77e5a3bfdf8a3f62e646a8641); ?>
<?php ob_start(); ?>
                    <?php echo e(__('Dashboard')); ?>

                <?php $__slotsfd73a7f77e5a3bfdf8a3f62e646a8641['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsfd73a7f77e5a3bfdf8a3f62e646a8641); ?>
<?php _fd73a7f77e5a3bfdf8a3f62e646a8641($__blaze, $__attrsfd73a7f77e5a3bfdf8a3f62e646a8641, $__slotsfd73a7f77e5a3bfdf8a3f62e646a8641, ['href', 'current', 'wire:navigate'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackfd73a7f77e5a3bfdf8a3f62e646a8641)) { $__slotsfd73a7f77e5a3bfdf8a3f62e646a8641 = array_pop($__slotsStackfd73a7f77e5a3bfdf8a3f62e646a8641); } ?>
<?php if (! empty($__attrsStackfd73a7f77e5a3bfdf8a3f62e646a8641)) { $__attrsfd73a7f77e5a3bfdf8a3f62e646a8641 = array_pop($__attrsStackfd73a7f77e5a3bfdf8a3f62e646a8641); } ?>
<?php $__blaze->popData(); ?>
            <?php echo trim(ob_get_clean()); ?>

</nav>
<?php $__blaze->popData(); $__env->popConsumableComponentData(); ?><?php echo ltrim(ob_get_clean()); ?>

            <?php ob_start(); ?><div class="flex-1" data-flux-spacer></div>
<?php echo ltrim(ob_get_clean()); ?>

            <?php ob_start(); ?><?php $__blaze->pushData(['class' => 'me-1.5 space-x-0.5 rtl:space-x-reverse py-0!']); $__env->pushConsumableComponentData(['class' => 'me-1.5 space-x-0.5 rtl:space-x-reverse py-0!']); ?><nav class="flex items-center gap-1 py-3  me-1.5 space-x-0.5 rtl:space-x-reverse py-0!" data-flux-navbar>
    <?php ob_start(); ?>
                <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/index.blade.php', $__blaze->compiledPath.'/808b9b4046ff2f9c00b5d65e5bd272e2.php'); ?>
<?php if (isset($__slots808b9b4046ff2f9c00b5d65e5bd272e2)) { $__slotsStack808b9b4046ff2f9c00b5d65e5bd272e2[] = $__slots808b9b4046ff2f9c00b5d65e5bd272e2; } ?>
<?php if (isset($__attrs808b9b4046ff2f9c00b5d65e5bd272e2)) { $__attrsStack808b9b4046ff2f9c00b5d65e5bd272e2[] = $__attrs808b9b4046ff2f9c00b5d65e5bd272e2; } ?>
<?php $__attrs808b9b4046ff2f9c00b5d65e5bd272e2 = ['content' => __('Search'),'position' => 'bottom']; ?>
<?php $__slots808b9b4046ff2f9c00b5d65e5bd272e2 = []; ?>
<?php $__blaze->pushData($__attrs808b9b4046ff2f9c00b5d65e5bd272e2); ?>
<?php ob_start(); ?>
                    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/navbar/item.blade.php', $__blaze->compiledPath.'/fd73a7f77e5a3bfdf8a3f62e646a8641.php'); ?>
<?php $__blaze->pushData(['class' => '!h-10 [&>div>svg]:size-5','icon' => 'magnifying-glass','href' => '#','label' => __('Search')]); ?>
<?php _fd73a7f77e5a3bfdf8a3f62e646a8641($__blaze, ['class' => '!h-10 [&>div>svg]:size-5','icon' => 'magnifying-glass','href' => '#','label' => __('Search')], [], ['label'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                <?php $__slots808b9b4046ff2f9c00b5d65e5bd272e2['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots808b9b4046ff2f9c00b5d65e5bd272e2); ?>
<?php _808b9b4046ff2f9c00b5d65e5bd272e2($__blaze, $__attrs808b9b4046ff2f9c00b5d65e5bd272e2, $__slots808b9b4046ff2f9c00b5d65e5bd272e2, ['content'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack808b9b4046ff2f9c00b5d65e5bd272e2)) { $__slots808b9b4046ff2f9c00b5d65e5bd272e2 = array_pop($__slotsStack808b9b4046ff2f9c00b5d65e5bd272e2); } ?>
<?php if (! empty($__attrsStack808b9b4046ff2f9c00b5d65e5bd272e2)) { $__attrs808b9b4046ff2f9c00b5d65e5bd272e2 = array_pop($__attrsStack808b9b4046ff2f9c00b5d65e5bd272e2); } ?>
<?php $__blaze->popData(); ?>
                <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/index.blade.php', $__blaze->compiledPath.'/808b9b4046ff2f9c00b5d65e5bd272e2.php'); ?>
<?php if (isset($__slots808b9b4046ff2f9c00b5d65e5bd272e2)) { $__slotsStack808b9b4046ff2f9c00b5d65e5bd272e2[] = $__slots808b9b4046ff2f9c00b5d65e5bd272e2; } ?>
<?php if (isset($__attrs808b9b4046ff2f9c00b5d65e5bd272e2)) { $__attrsStack808b9b4046ff2f9c00b5d65e5bd272e2[] = $__attrs808b9b4046ff2f9c00b5d65e5bd272e2; } ?>
<?php $__attrs808b9b4046ff2f9c00b5d65e5bd272e2 = ['content' => __('Repository'),'position' => 'bottom']; ?>
<?php $__slots808b9b4046ff2f9c00b5d65e5bd272e2 = []; ?>
<?php $__blaze->pushData($__attrs808b9b4046ff2f9c00b5d65e5bd272e2); ?>
<?php ob_start(); ?>
                    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/navbar/item.blade.php', $__blaze->compiledPath.'/fd73a7f77e5a3bfdf8a3f62e646a8641.php'); ?>
<?php $__blaze->pushData(['class' => 'h-10 max-lg:hidden [&>div>svg]:size-5','icon' => 'folder-git-2','href' => 'https://github.com/laravel/livewire-starter-kit','target' => '_blank','label' => __('Repository')]); ?>
<?php _fd73a7f77e5a3bfdf8a3f62e646a8641($__blaze, ['class' => 'h-10 max-lg:hidden [&>div>svg]:size-5','icon' => 'folder-git-2','href' => 'https://github.com/laravel/livewire-starter-kit','target' => '_blank','label' => __('Repository')], [], ['label'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                <?php $__slots808b9b4046ff2f9c00b5d65e5bd272e2['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots808b9b4046ff2f9c00b5d65e5bd272e2); ?>
<?php _808b9b4046ff2f9c00b5d65e5bd272e2($__blaze, $__attrs808b9b4046ff2f9c00b5d65e5bd272e2, $__slots808b9b4046ff2f9c00b5d65e5bd272e2, ['content'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack808b9b4046ff2f9c00b5d65e5bd272e2)) { $__slots808b9b4046ff2f9c00b5d65e5bd272e2 = array_pop($__slotsStack808b9b4046ff2f9c00b5d65e5bd272e2); } ?>
<?php if (! empty($__attrsStack808b9b4046ff2f9c00b5d65e5bd272e2)) { $__attrs808b9b4046ff2f9c00b5d65e5bd272e2 = array_pop($__attrsStack808b9b4046ff2f9c00b5d65e5bd272e2); } ?>
<?php $__blaze->popData(); ?>
                <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/index.blade.php', $__blaze->compiledPath.'/808b9b4046ff2f9c00b5d65e5bd272e2.php'); ?>
<?php if (isset($__slots808b9b4046ff2f9c00b5d65e5bd272e2)) { $__slotsStack808b9b4046ff2f9c00b5d65e5bd272e2[] = $__slots808b9b4046ff2f9c00b5d65e5bd272e2; } ?>
<?php if (isset($__attrs808b9b4046ff2f9c00b5d65e5bd272e2)) { $__attrsStack808b9b4046ff2f9c00b5d65e5bd272e2[] = $__attrs808b9b4046ff2f9c00b5d65e5bd272e2; } ?>
<?php $__attrs808b9b4046ff2f9c00b5d65e5bd272e2 = ['content' => __('Documentation'),'position' => 'bottom']; ?>
<?php $__slots808b9b4046ff2f9c00b5d65e5bd272e2 = []; ?>
<?php $__blaze->pushData($__attrs808b9b4046ff2f9c00b5d65e5bd272e2); ?>
<?php ob_start(); ?>
                    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/navbar/item.blade.php', $__blaze->compiledPath.'/fd73a7f77e5a3bfdf8a3f62e646a8641.php'); ?>
<?php $__blaze->pushData(['class' => 'h-10 max-lg:hidden [&>div>svg]:size-5','icon' => 'book-open-text','href' => 'https://laravel.com/docs/starter-kits#livewire','target' => '_blank','label' => __('Documentation')]); ?>
<?php _fd73a7f77e5a3bfdf8a3f62e646a8641($__blaze, ['class' => 'h-10 max-lg:hidden [&>div>svg]:size-5','icon' => 'book-open-text','href' => 'https://laravel.com/docs/starter-kits#livewire','target' => '_blank','label' => __('Documentation')], [], ['label'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                <?php $__slots808b9b4046ff2f9c00b5d65e5bd272e2['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots808b9b4046ff2f9c00b5d65e5bd272e2); ?>
<?php _808b9b4046ff2f9c00b5d65e5bd272e2($__blaze, $__attrs808b9b4046ff2f9c00b5d65e5bd272e2, $__slots808b9b4046ff2f9c00b5d65e5bd272e2, ['content'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack808b9b4046ff2f9c00b5d65e5bd272e2)) { $__slots808b9b4046ff2f9c00b5d65e5bd272e2 = array_pop($__slotsStack808b9b4046ff2f9c00b5d65e5bd272e2); } ?>
<?php if (! empty($__attrsStack808b9b4046ff2f9c00b5d65e5bd272e2)) { $__attrs808b9b4046ff2f9c00b5d65e5bd272e2 = array_pop($__attrsStack808b9b4046ff2f9c00b5d65e5bd272e2); } ?>
<?php $__blaze->popData(); ?>
            <?php echo trim(ob_get_clean()); ?>

</nav>
<?php $__blaze->popData(); $__env->popConsumableComponentData(); ?><?php echo ltrim(ob_get_clean()); ?>

            <?php if (isset($component)) { $__componentOriginalca54afb14f8d43d7f1acc5dbe6164a0a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalca54afb14f8d43d7f1acc5dbe6164a0a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.desktop-user-menu','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('desktop-user-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalca54afb14f8d43d7f1acc5dbe6164a0a)): ?>
<?php $attributes = $__attributesOriginalca54afb14f8d43d7f1acc5dbe6164a0a; ?>
<?php unset($__attributesOriginalca54afb14f8d43d7f1acc5dbe6164a0a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalca54afb14f8d43d7f1acc5dbe6164a0a)): ?>
<?php $component = $__componentOriginalca54afb14f8d43d7f1acc5dbe6164a0a; ?>
<?php unset($__componentOriginalca54afb14f8d43d7f1acc5dbe6164a0a); ?>
<?php endif; ?>
        <?php echo trim(ob_get_clean()); ?>

        </div>
    </header>
<?php $__blaze->popData(); $__env->popConsumableComponentData(); ?><?php echo ltrim(ob_get_clean()); ?>

        <!-- Mobile Menu -->
        <?php ob_start(); ?><ui-sidebar-toggle class="z-20 fixed inset-0 bg-black/10 hidden data-flux-sidebar-on-mobile:not-data-flux-sidebar-collapsed-mobile:block" data-flux-sidebar-backdrop></ui-sidebar-toggle>

<ui-sidebar
    class="[grid-area:sidebar] z-1 flex flex-col gap-4 [:where(&amp;)]:w-64 p-4 data-flux-sidebar-collapsed-desktop:w-14 data-flux-sidebar-collapsed-desktop:px-2 data-flux-sidebar-collapsed-desktop:cursor-e-resize rtl:data-flux-sidebar-collapsed-desktop:cursor-w-resize max-lg:data-flux-sidebar-cloak:hidden data-flux-sidebar-on-mobile:data-flux-sidebar-collapsed-mobile:-translate-x-full data-flux-sidebar-on-mobile:data-flux-sidebar-collapsed-mobile:rtl:translate-x-full z-20! data-flux-sidebar-on-mobile:start-0! data-flux-sidebar-on-mobile:fixed! data-flux-sidebar-on-mobile:top-0! data-flux-sidebar-on-mobile:min-h-dvh! data-flux-sidebar-on-mobile:max-h-dvh! max-h-dvh overflow-y-auto overscroll-contain lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900" x-init="$el.classList.add(&#039;transition-transform&#039;)"
     collapsible="mobile"          sticky     x-data
    data-flux-sidebar-cloak
    data-flux-sidebar
>
    <?php ob_start(); ?>
            <?php ob_start(); ?><div class="flex items-center justify-between gap-2 min-h-10" data-flux-sidebar-header>
    <?php ob_start(); ?>
                <?php if (isset($component)) { $__componentOriginal7b17d80ff7900603fe9e5f0b453cc7c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b17d80ff7900603fe9e5f0b453cc7c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-logo','data' => ['sidebar' => true,'href' => ''.e(route('dashboard')).'','wire:navigate' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['sidebar' => true,'href' => ''.e(route('dashboard')).'','wire:navigate' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7b17d80ff7900603fe9e5f0b453cc7c3)): ?>
<?php $attributes = $__attributesOriginal7b17d80ff7900603fe9e5f0b453cc7c3; ?>
<?php unset($__attributesOriginal7b17d80ff7900603fe9e5f0b453cc7c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7b17d80ff7900603fe9e5f0b453cc7c3)): ?>
<?php $component = $__componentOriginal7b17d80ff7900603fe9e5f0b453cc7c3; ?>
<?php unset($__componentOriginal7b17d80ff7900603fe9e5f0b453cc7c3); ?>
<?php endif; ?>
                <?php ob_start(); ?><ui-sidebar-toggle class="w-10 h-8 flex items-center justify-center in-data-flux-sidebar-collapsed-desktop:opacity-0 in-data-flux-sidebar-collapsed-desktop:absolute in-data-flux-sidebar-collapsed-desktop:in-data-flux-sidebar-active:opacity-100  in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" data-flux-sidebar-collapse>
    <ui-tooltip position="right center"  data-flux-tooltip >
        <button type="button" class="size-10 relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none text-sm rounded-lg inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white in-data-flux-sidebar-collapsed-desktop:cursor-e-resize rtl:in-data-flux-sidebar-collapsed-desktop:cursor-w-resize [&amp;[collapsible=&quot;mobile&quot;]]:in-data-flux-sidebar-on-desktop:hidden rtl:rotate-180">
            <svg class="text-zinc-500 dark:text-zinc-400" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.5 3.75V16.25M3.4375 16.25H16.5625C17.08 16.25 17.5 15.83 17.5 15.3125V4.6875C17.5 4.17 17.08 3.75 16.5625 3.75H3.4375C2.92 3.75 2.5 4.17 2.5 4.6875V15.3125C2.5 15.83 2.92 16.25 3.4375 16.25Z" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </button>

                    <div popover="manual" class="relative py-2 px-2.5 rounded-md text-xs text-white font-medium bg-zinc-800 dark:bg-zinc-700 dark:border dark:border-white/10 p-0 overflow-visible" data-flux-tooltip-content>
    Toggle sidebar

    </div>
            </ui-tooltip>
</ui-sidebar-toggle>
<?php echo ltrim(ob_get_clean()); ?>
            <?php echo trim(ob_get_clean()); ?>

</div><?php echo ltrim(ob_get_clean()); ?>

            <?php ob_start(); ?><nav class="flex flex-col overflow-visible min-h-auto" data-flux-sidebar-nav>
    <?php ob_start(); ?>
                <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/sidebar/group.blade.php', $__blaze->compiledPath.'/510bbc473b2d7458cf4b4a8374fdbbc3.php'); ?>
<?php if (isset($__slots510bbc473b2d7458cf4b4a8374fdbbc3)) { $__slotsStack510bbc473b2d7458cf4b4a8374fdbbc3[] = $__slots510bbc473b2d7458cf4b4a8374fdbbc3; } ?>
<?php if (isset($__attrs510bbc473b2d7458cf4b4a8374fdbbc3)) { $__attrsStack510bbc473b2d7458cf4b4a8374fdbbc3[] = $__attrs510bbc473b2d7458cf4b4a8374fdbbc3; } ?>
<?php $__attrs510bbc473b2d7458cf4b4a8374fdbbc3 = ['heading' => __('Platform')]; ?>
<?php $__slots510bbc473b2d7458cf4b4a8374fdbbc3 = []; ?>
<?php $__blaze->pushData($__attrs510bbc473b2d7458cf4b4a8374fdbbc3); ?>
<?php ob_start(); ?>
                    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/sidebar/item.blade.php', $__blaze->compiledPath.'/d9d464c0e09a566b5f12c2e44eb79bf2.php'); ?>
<?php if (isset($__slotsd9d464c0e09a566b5f12c2e44eb79bf2)) { $__slotsStackd9d464c0e09a566b5f12c2e44eb79bf2[] = $__slotsd9d464c0e09a566b5f12c2e44eb79bf2; } ?>
<?php if (isset($__attrsd9d464c0e09a566b5f12c2e44eb79bf2)) { $__attrsStackd9d464c0e09a566b5f12c2e44eb79bf2[] = $__attrsd9d464c0e09a566b5f12c2e44eb79bf2; } ?>
<?php $__attrsd9d464c0e09a566b5f12c2e44eb79bf2 = ['icon' => 'layout-grid','href' => route('dashboard'),'current' => request()->routeIs('dashboard'),'wire:navigate' => true]; ?>
<?php $__slotsd9d464c0e09a566b5f12c2e44eb79bf2 = []; ?>
<?php $__blaze->pushData($__attrsd9d464c0e09a566b5f12c2e44eb79bf2); ?>
<?php ob_start(); ?>
                        <?php echo e(__('Dashboard')); ?>

                    <?php $__slotsd9d464c0e09a566b5f12c2e44eb79bf2['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsd9d464c0e09a566b5f12c2e44eb79bf2); ?>
<?php _d9d464c0e09a566b5f12c2e44eb79bf2($__blaze, $__attrsd9d464c0e09a566b5f12c2e44eb79bf2, $__slotsd9d464c0e09a566b5f12c2e44eb79bf2, ['href', 'current', 'wire:navigate'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackd9d464c0e09a566b5f12c2e44eb79bf2)) { $__slotsd9d464c0e09a566b5f12c2e44eb79bf2 = array_pop($__slotsStackd9d464c0e09a566b5f12c2e44eb79bf2); } ?>
<?php if (! empty($__attrsStackd9d464c0e09a566b5f12c2e44eb79bf2)) { $__attrsd9d464c0e09a566b5f12c2e44eb79bf2 = array_pop($__attrsStackd9d464c0e09a566b5f12c2e44eb79bf2); } ?>
<?php $__blaze->popData(); ?>
                <?php $__slots510bbc473b2d7458cf4b4a8374fdbbc3['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots510bbc473b2d7458cf4b4a8374fdbbc3); ?>
<?php _510bbc473b2d7458cf4b4a8374fdbbc3($__blaze, $__attrs510bbc473b2d7458cf4b4a8374fdbbc3, $__slots510bbc473b2d7458cf4b4a8374fdbbc3, ['heading'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack510bbc473b2d7458cf4b4a8374fdbbc3)) { $__slots510bbc473b2d7458cf4b4a8374fdbbc3 = array_pop($__slotsStack510bbc473b2d7458cf4b4a8374fdbbc3); } ?>
<?php if (! empty($__attrsStack510bbc473b2d7458cf4b4a8374fdbbc3)) { $__attrs510bbc473b2d7458cf4b4a8374fdbbc3 = array_pop($__attrsStack510bbc473b2d7458cf4b4a8374fdbbc3); } ?>
<?php $__blaze->popData(); ?>
            <?php echo trim(ob_get_clean()); ?>

</nav>
<?php echo ltrim(ob_get_clean()); ?>

            <?php ob_start(); ?><div class="flex-1" data-flux-spacer></div>
<?php echo ltrim(ob_get_clean()); ?>

            <?php ob_start(); ?><nav class="flex flex-col overflow-visible min-h-auto" data-flux-sidebar-nav>
    <?php ob_start(); ?>
                <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/sidebar/item.blade.php', $__blaze->compiledPath.'/d9d464c0e09a566b5f12c2e44eb79bf2.php'); ?>
<?php if (isset($__slotsd9d464c0e09a566b5f12c2e44eb79bf2)) { $__slotsStackd9d464c0e09a566b5f12c2e44eb79bf2[] = $__slotsd9d464c0e09a566b5f12c2e44eb79bf2; } ?>
<?php if (isset($__attrsd9d464c0e09a566b5f12c2e44eb79bf2)) { $__attrsStackd9d464c0e09a566b5f12c2e44eb79bf2[] = $__attrsd9d464c0e09a566b5f12c2e44eb79bf2; } ?>
<?php $__attrsd9d464c0e09a566b5f12c2e44eb79bf2 = ['icon' => 'folder-git-2','href' => 'https://github.com/laravel/livewire-starter-kit','target' => '_blank']; ?>
<?php $__slotsd9d464c0e09a566b5f12c2e44eb79bf2 = []; ?>
<?php $__blaze->pushData($__attrsd9d464c0e09a566b5f12c2e44eb79bf2); ?>
<?php ob_start(); ?>
                    <?php echo e(__('Repository')); ?>

                <?php $__slotsd9d464c0e09a566b5f12c2e44eb79bf2['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsd9d464c0e09a566b5f12c2e44eb79bf2); ?>
<?php _d9d464c0e09a566b5f12c2e44eb79bf2($__blaze, $__attrsd9d464c0e09a566b5f12c2e44eb79bf2, $__slotsd9d464c0e09a566b5f12c2e44eb79bf2, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackd9d464c0e09a566b5f12c2e44eb79bf2)) { $__slotsd9d464c0e09a566b5f12c2e44eb79bf2 = array_pop($__slotsStackd9d464c0e09a566b5f12c2e44eb79bf2); } ?>
<?php if (! empty($__attrsStackd9d464c0e09a566b5f12c2e44eb79bf2)) { $__attrsd9d464c0e09a566b5f12c2e44eb79bf2 = array_pop($__attrsStackd9d464c0e09a566b5f12c2e44eb79bf2); } ?>
<?php $__blaze->popData(); ?>
                <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/sidebar/item.blade.php', $__blaze->compiledPath.'/d9d464c0e09a566b5f12c2e44eb79bf2.php'); ?>
<?php if (isset($__slotsd9d464c0e09a566b5f12c2e44eb79bf2)) { $__slotsStackd9d464c0e09a566b5f12c2e44eb79bf2[] = $__slotsd9d464c0e09a566b5f12c2e44eb79bf2; } ?>
<?php if (isset($__attrsd9d464c0e09a566b5f12c2e44eb79bf2)) { $__attrsStackd9d464c0e09a566b5f12c2e44eb79bf2[] = $__attrsd9d464c0e09a566b5f12c2e44eb79bf2; } ?>
<?php $__attrsd9d464c0e09a566b5f12c2e44eb79bf2 = ['icon' => 'book-open-text','href' => 'https://laravel.com/docs/starter-kits#livewire','target' => '_blank']; ?>
<?php $__slotsd9d464c0e09a566b5f12c2e44eb79bf2 = []; ?>
<?php $__blaze->pushData($__attrsd9d464c0e09a566b5f12c2e44eb79bf2); ?>
<?php ob_start(); ?>
                    <?php echo e(__('Documentation')); ?>

                <?php $__slotsd9d464c0e09a566b5f12c2e44eb79bf2['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsd9d464c0e09a566b5f12c2e44eb79bf2); ?>
<?php _d9d464c0e09a566b5f12c2e44eb79bf2($__blaze, $__attrsd9d464c0e09a566b5f12c2e44eb79bf2, $__slotsd9d464c0e09a566b5f12c2e44eb79bf2, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackd9d464c0e09a566b5f12c2e44eb79bf2)) { $__slotsd9d464c0e09a566b5f12c2e44eb79bf2 = array_pop($__slotsStackd9d464c0e09a566b5f12c2e44eb79bf2); } ?>
<?php if (! empty($__attrsStackd9d464c0e09a566b5f12c2e44eb79bf2)) { $__attrsd9d464c0e09a566b5f12c2e44eb79bf2 = array_pop($__attrsStackd9d464c0e09a566b5f12c2e44eb79bf2); } ?>
<?php $__blaze->popData(); ?>
            <?php echo trim(ob_get_clean()); ?>

</nav>
<?php echo ltrim(ob_get_clean()); ?>
        <?php echo trim(ob_get_clean()); ?>

</ui-sidebar>
<?php echo ltrim(ob_get_clean()); ?>

        <?php echo e($slot); ?>


        <?php app('livewire')->forceAssetInjection(); ?>
<?php echo app('flux')->scripts(); ?>

    </body>
</html>
<?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/layouts/app/header.blade.php ENDPATH**/ ?>