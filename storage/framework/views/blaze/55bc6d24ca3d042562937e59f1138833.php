<?php
if (!function_exists('__55bc6d24ca3d042562937e59f1138833')):
function __55bc6d24ca3d042562937e59f1138833($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/with-inline-field.blade.php', $__blaze->compiledPath.'/0e29395866459b864145a6bb0d80bcd4.php'); ?>
<?php if (isset($__slots0e29395866459b864145a6bb0d80bcd4)) { $__slotsStack0e29395866459b864145a6bb0d80bcd4[] = $__slots0e29395866459b864145a6bb0d80bcd4; } ?>
<?php if (isset($__attrs0e29395866459b864145a6bb0d80bcd4)) { $__attrsStack0e29395866459b864145a6bb0d80bcd4[] = $__attrs0e29395866459b864145a6bb0d80bcd4; } ?>
<?php $__attrs0e29395866459b864145a6bb0d80bcd4 = ['attributes' => $attributes]; ?>
<?php $__slots0e29395866459b864145a6bb0d80bcd4 = []; ?>
<?php $__blaze->pushData($__attrs0e29395866459b864145a6bb0d80bcd4); ?>
<?php ob_start(); ?>
        <ui-switch <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> <?php if($checked): ?> checked data-checked <?php endif; ?> data-flux-control data-flux-switch>
            <span class="<?php echo e(\Illuminate\Support\Arr::toCssClasses($indicatorClasses)); ?>"></span>
        </ui-switch>
    <?php $__slots0e29395866459b864145a6bb0d80bcd4['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots0e29395866459b864145a6bb0d80bcd4); ?>
<?php __0e29395866459b864145a6bb0d80bcd4($__blaze, $__attrs0e29395866459b864145a6bb0d80bcd4, $__slots0e29395866459b864145a6bb0d80bcd4, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack0e29395866459b864145a6bb0d80bcd4)) { $__slots0e29395866459b864145a6bb0d80bcd4 = array_pop($__slotsStack0e29395866459b864145a6bb0d80bcd4); } ?>
<?php if (! empty($__attrsStack0e29395866459b864145a6bb0d80bcd4)) { $__attrs0e29395866459b864145a6bb0d80bcd4 = array_pop($__attrsStack0e29395866459b864145a6bb0d80bcd4); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/with-reversed-inline-field.blade.php', $__blaze->compiledPath.'/2f373cedb40ad5bd20a4104dfda2199e.php'); ?>
<?php if (isset($__slots2f373cedb40ad5bd20a4104dfda2199e)) { $__slotsStack2f373cedb40ad5bd20a4104dfda2199e[] = $__slots2f373cedb40ad5bd20a4104dfda2199e; } ?>
<?php if (isset($__attrs2f373cedb40ad5bd20a4104dfda2199e)) { $__attrsStack2f373cedb40ad5bd20a4104dfda2199e[] = $__attrs2f373cedb40ad5bd20a4104dfda2199e; } ?>
<?php $__attrs2f373cedb40ad5bd20a4104dfda2199e = ['attributes' => $attributes]; ?>
<?php $__slots2f373cedb40ad5bd20a4104dfda2199e = []; ?>
<?php $__blaze->pushData($__attrs2f373cedb40ad5bd20a4104dfda2199e); ?>
<?php ob_start(); ?>
        <ui-switch <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> <?php if($checked): ?> checked data-checked <?php endif; ?> data-flux-control data-flux-switch>
            <span class="<?php echo e(\Illuminate\Support\Arr::toCssClasses($indicatorClasses)); ?>"></span>
        </ui-switch>
    <?php $__slots2f373cedb40ad5bd20a4104dfda2199e['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots2f373cedb40ad5bd20a4104dfda2199e); ?>
<?php __2f373cedb40ad5bd20a4104dfda2199e($__blaze, $__attrs2f373cedb40ad5bd20a4104dfda2199e, $__slots2f373cedb40ad5bd20a4104dfda2199e, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack2f373cedb40ad5bd20a4104dfda2199e)) { $__slots2f373cedb40ad5bd20a4104dfda2199e = array_pop($__slotsStack2f373cedb40ad5bd20a4104dfda2199e); } ?>
<?php if (! empty($__attrsStack2f373cedb40ad5bd20a4104dfda2199e)) { $__attrs2f373cedb40ad5bd20a4104dfda2199e = array_pop($__attrsStack2f373cedb40ad5bd20a4104dfda2199e); } ?>
<?php $__blaze->popData(); ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/switch.blade.php ENDPATH**/ ?>