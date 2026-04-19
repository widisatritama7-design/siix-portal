<?php # [BlazeFolded]:{flux::navlist}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/navlist/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::separator}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/separator.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::heading}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::subheading}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/subheading.blade.php}:{1774988736} ?>
<div 
    x-data="{
        sidebarOpen: JSON.parse(localStorage.getItem('sidebarOpen') ?? 'true'),
        init() {
            // Set initial state tanpa animasi
            this.$nextTick(() => {
                this.sidebarOpen = JSON.parse(localStorage.getItem('sidebarOpen') ?? 'true');
            });
        }
    }" 
    x-effect="localStorage.setItem('sidebarOpen', sidebarOpen)"
    class="flex max-md:flex-col"
    x-cloak
>

    <!-- Toggle Button -->
    <button 
        @click="sidebarOpen = !sidebarOpen"
        class="hidden md:flex flex-shrink-0 mt-1 mr-6 items-center justify-center w-10 h-10 bg-zinc-100 dark:bg-zinc-800 rounded-lg"
        type="button"
    >
        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-arrow-left-circle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-show' => 'sidebarOpen','class' => 'w-5 h-5','x-cloak' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-arrow-right-circle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-show' => '!sidebarOpen','class' => 'w-5 h-5','x-cloak' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
    </button>

    <!-- Sidebar -->
    <div 
        :class="sidebarOpen ? 'md:w-[220px]' : 'md:w-[61px]'"
        class="w-full md:flex-shrink-0 transition-none md:transition-all md:duration-300"
    >

        <div 
            :class="sidebarOpen ? 'p-3' : 'p-2 flex flex-col items-center'"
            class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl shadow-sm w-full"
        >

            <?php ob_start(); ?><?php $__blaze->pushData(['ariaLabel' => 'Settings', 'class' => 'w-full']); $__env->pushConsumableComponentData(['ariaLabel' => 'Settings', 'class' => 'w-full']); ?><nav class="flex flex-col overflow-visible min-h-auto w-full" aria-label="Settings" data-flux-navlist>
    <?php ob_start(); ?>

                <!-- Profile -->
                <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/navlist/item.blade.php', $__blaze->compiledPath.'/dd52e733f967a8ea45137d9e8a5a4d10.php'); ?>
<?php if (isset($__slotsdd52e733f967a8ea45137d9e8a5a4d10)) { $__slotsStackdd52e733f967a8ea45137d9e8a5a4d10[] = $__slotsdd52e733f967a8ea45137d9e8a5a4d10; } ?>
<?php if (isset($__attrsdd52e733f967a8ea45137d9e8a5a4d10)) { $__attrsStackdd52e733f967a8ea45137d9e8a5a4d10[] = $__attrsdd52e733f967a8ea45137d9e8a5a4d10; } ?>
<?php $__attrsdd52e733f967a8ea45137d9e8a5a4d10 = ['href' => route('profile.edit'),'wire:navigate' => true,'active' => request()->routeIs('profile.edit'),'title' => 'Profile','class' => 'w-full']; ?>
<?php $__slotsdd52e733f967a8ea45137d9e8a5a4d10 = []; ?>
<?php $__blaze->pushData($__attrsdd52e733f967a8ea45137d9e8a5a4d10); ?>
<?php ob_start(); ?>
                     
                    <span x-show="sidebarOpen" class="truncate">
                        Profile
                    </span>
                <?php $__slotsdd52e733f967a8ea45137d9e8a5a4d10['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php ob_start(); ?>
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                    <?php $__slotsdd52e733f967a8ea45137d9e8a5a4d10['icon'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsdd52e733f967a8ea45137d9e8a5a4d10); ?>
<?php _dd52e733f967a8ea45137d9e8a5a4d10($__blaze, $__attrsdd52e733f967a8ea45137d9e8a5a4d10, $__slotsdd52e733f967a8ea45137d9e8a5a4d10, ['href', 'wire:navigate', 'active'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackdd52e733f967a8ea45137d9e8a5a4d10)) { $__slotsdd52e733f967a8ea45137d9e8a5a4d10 = array_pop($__slotsStackdd52e733f967a8ea45137d9e8a5a4d10); } ?>
<?php if (! empty($__attrsStackdd52e733f967a8ea45137d9e8a5a4d10)) { $__attrsdd52e733f967a8ea45137d9e8a5a4d10 = array_pop($__attrsStackdd52e733f967a8ea45137d9e8a5a4d10); } ?>
<?php $__blaze->popData(); ?>

                <!-- Security -->
                <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/navlist/item.blade.php', $__blaze->compiledPath.'/dd52e733f967a8ea45137d9e8a5a4d10.php'); ?>
<?php if (isset($__slotsdd52e733f967a8ea45137d9e8a5a4d10)) { $__slotsStackdd52e733f967a8ea45137d9e8a5a4d10[] = $__slotsdd52e733f967a8ea45137d9e8a5a4d10; } ?>
<?php if (isset($__attrsdd52e733f967a8ea45137d9e8a5a4d10)) { $__attrsStackdd52e733f967a8ea45137d9e8a5a4d10[] = $__attrsdd52e733f967a8ea45137d9e8a5a4d10; } ?>
<?php $__attrsdd52e733f967a8ea45137d9e8a5a4d10 = ['href' => route('security.edit'),'wire:navigate' => true,'active' => request()->routeIs('security.edit'),'title' => 'Security','class' => 'w-full']; ?>
<?php $__slotsdd52e733f967a8ea45137d9e8a5a4d10 = []; ?>
<?php $__blaze->pushData($__attrsdd52e733f967a8ea45137d9e8a5a4d10); ?>
<?php ob_start(); ?>
                     
                    <span x-show="sidebarOpen" class="truncate">
                        Security
                    </span>
                <?php $__slotsdd52e733f967a8ea45137d9e8a5a4d10['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php ob_start(); ?>
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-lock-closed'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                    <?php $__slotsdd52e733f967a8ea45137d9e8a5a4d10['icon'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsdd52e733f967a8ea45137d9e8a5a4d10); ?>
<?php _dd52e733f967a8ea45137d9e8a5a4d10($__blaze, $__attrsdd52e733f967a8ea45137d9e8a5a4d10, $__slotsdd52e733f967a8ea45137d9e8a5a4d10, ['href', 'wire:navigate', 'active'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackdd52e733f967a8ea45137d9e8a5a4d10)) { $__slotsdd52e733f967a8ea45137d9e8a5a4d10 = array_pop($__slotsStackdd52e733f967a8ea45137d9e8a5a4d10); } ?>
<?php if (! empty($__attrsStackdd52e733f967a8ea45137d9e8a5a4d10)) { $__attrsdd52e733f967a8ea45137d9e8a5a4d10 = array_pop($__attrsStackdd52e733f967a8ea45137d9e8a5a4d10); } ?>
<?php $__blaze->popData(); ?>

            <?php echo trim(ob_get_clean()); ?>

</nav>
<?php $__blaze->popData(); $__env->popConsumableComponentData(); ?><?php echo ltrim(ob_get_clean()); ?>

        </div>

    </div>

    <!-- Gap kanan yang mengikuti gap kiri -->
    <div class="hidden md:block flex-shrink-0 w-6"></div>

    <?php ob_start(); ?><div data-orientation="horizontal" role="none" class="border-0 [print-color-adjust:exact] bg-zinc-800/15 dark:bg-white/20 h-px w-full md:hidden my-4" data-flux-separator></div>
<?php echo ltrim(ob_get_clean()); ?>

    <!-- Main Content -->
    <div class="flex-1 min-w-0 self-stretch max-md:pt-6">

        <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-sm [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>
            <?php echo e($heading ?? ''); ?>

        <?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>

        <?php ob_start(); ?><div class="text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70" data-flux-subheading>
    <?php ob_start(); ?>
            <?php echo e($subheading ?? ''); ?>

        <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>

        <div class="mt-5 w-full max-w-lg">
            <?php echo e($slot); ?>

        </div>

    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>

</div><?php /**PATH D:\laragon\www\siix-portal-new\resources\views\components\settings\layout.blade.php ENDPATH**/ ?>