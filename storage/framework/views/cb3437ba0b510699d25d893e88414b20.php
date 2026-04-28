<?php
if (!function_exists('_cb3437ba0b510699d25d893e88414b20')):
function _cb3437ba0b510699d25d893e88414b20($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php
$__defaults = [
    'name' => null,
    'align' => 'right',
    'checked' => null
];
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
$align ??= $attributes['align'] ?? $__defaults['align']; unset($attributes['align']);
$checked ??= $attributes['checked'] ?? $__defaults['checked']; unset($attributes['checked']);
unset($__defaults);
?>

<?php
// We only want to show the name attribute it has been set manually
// but not if it has been set from the `wire:model` attribute...
$showName = isset($name);
if (! isset($name)) {
    $name = $attributes->whereStartsWith('wire:model')->first();
}

$classes = Flux::classes()
    ->add('group h-5 w-8 min-w-8 relative inline-flex items-center outline-offset-2')
    ->add('rounded-full')
    ->add('transition')
    ->add('bg-zinc-800/15 [&[disabled]]:opacity-50 dark:bg-transparent dark:border dark:border-white/20 dark:[&[disabled]]:border-white/10')
    ->add('[print-color-adjust:exact]')
    ->add([
        'data-checked:bg-(--color-accent)',
        'data-checked:border-0',
    ])
    ;

$indicatorClasses = Flux::classes()
    ->add('size-3.5')
    ->add('rounded-full')
    ->add('transition translate-x-[0.1875rem] dark:translate-x-[0.125rem] rtl:-translate-x-[0.1875rem] dark:rtl:-translate-x-[0.125rem]')
    ->add('bg-white')
    ->add([
        'group-data-checked:translate-x-[0.9375rem] rtl:group-data-checked:-translate-x-[0.9375rem]',
        // We have to add the dark variant of the `translate-x-[0.9375rem]` to ensure that if `.dark` is added to an element mid way
        // down the DOM instead of on the root HTML element, that the above `dark:translate-x-[0.125rem]` doesn't over ride it...
        'dark:group-data-checked:translate-x-[0.9375rem] dark:rtl:group-data-checked:-translate-x-[0.9375rem]',
        'group-data-checked:bg-(--color-accent-foreground)',
    ]);
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($align === 'left' || $align === 'start'): ?>
    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-inline-field.blade.php', $__blaze->compiledPath.'/ab524181009a9790fad3d790077f9632.php'); ?>
<?php if (isset($__slotsab524181009a9790fad3d790077f9632)) { $__slotsStackab524181009a9790fad3d790077f9632[] = $__slotsab524181009a9790fad3d790077f9632; } ?>
<?php if (isset($__attrsab524181009a9790fad3d790077f9632)) { $__attrsStackab524181009a9790fad3d790077f9632[] = $__attrsab524181009a9790fad3d790077f9632; } ?>
<?php $__attrsab524181009a9790fad3d790077f9632 = ['attributes' => $attributes]; ?>
<?php $__slotsab524181009a9790fad3d790077f9632 = []; ?>
<?php $__blaze->pushData($__attrsab524181009a9790fad3d790077f9632); ?>
<?php ob_start(); ?>
        <ui-switch <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> <?php if($checked): ?> checked data-checked <?php endif; ?> data-flux-control data-flux-switch>
            <span class="<?php echo e(\Illuminate\Support\Arr::toCssClasses($indicatorClasses)); ?>"></span>
        </ui-switch>
    <?php $__slotsab524181009a9790fad3d790077f9632['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsab524181009a9790fad3d790077f9632); ?>
<?php _ab524181009a9790fad3d790077f9632($__blaze, $__attrsab524181009a9790fad3d790077f9632, $__slotsab524181009a9790fad3d790077f9632, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackab524181009a9790fad3d790077f9632)) { $__slotsab524181009a9790fad3d790077f9632 = array_pop($__slotsStackab524181009a9790fad3d790077f9632); } ?>
<?php if (! empty($__attrsStackab524181009a9790fad3d790077f9632)) { $__attrsab524181009a9790fad3d790077f9632 = array_pop($__attrsStackab524181009a9790fad3d790077f9632); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-reversed-inline-field.blade.php', $__blaze->compiledPath.'/0721f85c9f0c3b63aba268b611605ee4.php'); ?>
<?php if (isset($__slots0721f85c9f0c3b63aba268b611605ee4)) { $__slotsStack0721f85c9f0c3b63aba268b611605ee4[] = $__slots0721f85c9f0c3b63aba268b611605ee4; } ?>
<?php if (isset($__attrs0721f85c9f0c3b63aba268b611605ee4)) { $__attrsStack0721f85c9f0c3b63aba268b611605ee4[] = $__attrs0721f85c9f0c3b63aba268b611605ee4; } ?>
<?php $__attrs0721f85c9f0c3b63aba268b611605ee4 = ['attributes' => $attributes]; ?>
<?php $__slots0721f85c9f0c3b63aba268b611605ee4 = []; ?>
<?php $__blaze->pushData($__attrs0721f85c9f0c3b63aba268b611605ee4); ?>
<?php ob_start(); ?>
        <ui-switch <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> <?php if($checked): ?> checked data-checked <?php endif; ?> data-flux-control data-flux-switch>
            <span class="<?php echo e(\Illuminate\Support\Arr::toCssClasses($indicatorClasses)); ?>"></span>
        </ui-switch>
    <?php $__slots0721f85c9f0c3b63aba268b611605ee4['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots0721f85c9f0c3b63aba268b611605ee4); ?>
<?php _0721f85c9f0c3b63aba268b611605ee4($__blaze, $__attrs0721f85c9f0c3b63aba268b611605ee4, $__slots0721f85c9f0c3b63aba268b611605ee4, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack0721f85c9f0c3b63aba268b611605ee4)) { $__slots0721f85c9f0c3b63aba268b611605ee4 = array_pop($__slotsStack0721f85c9f0c3b63aba268b611605ee4); } ?>
<?php if (! empty($__attrsStack0721f85c9f0c3b63aba268b611605ee4)) { $__attrs0721f85c9f0c3b63aba268b611605ee4 = array_pop($__attrsStack0721f85c9f0c3b63aba268b611605ee4); } ?>
<?php $__blaze->popData(); ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/stubs/resources/views/flux/switch.blade.php ENDPATH**/ ?>