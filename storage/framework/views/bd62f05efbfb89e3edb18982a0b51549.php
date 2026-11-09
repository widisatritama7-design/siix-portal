<?php # [BlazeVersion]:{v3} ?>
<?php # [BlazeFolded]:{flux::heading}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1792543558} ?>
<?php # [BlazeFolded]:{flux::subheading}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/subheading.blade.php}:{1792543558} ?>
<?php # [BlazeFolded]:{flux::separator}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/separator.blade.php}:{1792543558} ?>
<div class="relative mb-6 w-full">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <!-- Kiri: Heading + Subheading -->
        <div class="min-w-0">
            <?php ob_start(); ?><h1 class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-2xl [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?><?php echo e(__('Settings')); ?><?php echo trim(ob_get_clean()); ?></h1>

        <?php echo ltrim(ob_get_clean()); ?>
            <?php ob_start(); ?><div class="text-base [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70" data-flux-subheading>
    <?php ob_start(); ?><?php echo e(__('Manage your profile and account settings')); ?><?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
        </div>

        <!-- Kanan: Tab Menu -->
        <nav 
            class="flex flex-col gap-2 md:flex-row md:items-center flex-shrink-0"
            aria-label="Settings"
        >
            <!-- Profile -->
            <a 
                href="<?php echo e(route('profile.edit')); ?>" 
                wire:navigate
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'flex items-center gap-2 px-3 py-2 md:py-1.5 rounded-lg text-sm font-medium transition-all border whitespace-nowrap',
                    'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 border-zinc-900 dark:border-zinc-100 shadow-sm' => request()->routeIs('profile.edit'),
                    'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-zinc-100' => !request()->routeIs('profile.edit'),
                ]); ?>"
            >
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
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
                <span>Profile</span>
            </a>

            <!-- Security -->
            <a 
                href="<?php echo e(route('security.edit')); ?>" 
                wire:navigate
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'flex items-center gap-2 px-3 py-2 md:py-1.5 rounded-lg text-sm font-medium transition-all border whitespace-nowrap',
                    'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 border-zinc-900 dark:border-zinc-100 shadow-sm' => request()->routeIs('security.edit'),
                    'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-zinc-100' => !request()->routeIs('security.edit'),
                ]); ?>"
            >
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-lock-closed'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
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
                <span>Security</span>
            </a>

            <!-- Passkey -->
            <a 
                href="<?php echo e(route('settings.passkeys')); ?>" 
                wire:navigate
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'flex items-center gap-2 px-3 py-2 md:py-1.5 rounded-lg text-sm font-medium transition-all border whitespace-nowrap',
                    'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 border-zinc-900 dark:border-zinc-100 shadow-sm' => request()->routeIs('settings.passkeys'),
                    'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-zinc-100' => !request()->routeIs('settings.passkeys'),
                ]); ?>"
            >
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-finger-print'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
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
                <span>Passkey</span>
            </a>
        </nav>
    </div>

    <?php ob_start(); ?><div data-orientation="horizontal" role="none" class="border-0 [print-color-adjust:exact] bg-zinc-800/5 dark:bg-white/10 h-px w-full mt-6" data-flux-separator></div>
<?php echo ltrim(ob_get_clean()); ?>
</div><?php /**PATH C:\laragon\www\siix-portal\resources\views/partials/settings-heading.blade.php ENDPATH**/ ?>