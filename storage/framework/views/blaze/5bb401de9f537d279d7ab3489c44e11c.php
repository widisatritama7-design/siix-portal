<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__c0243feb7921a3875404d64ed3830908')):
function __c0243feb7921a3875404d64ed3830908($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = new \Livewire\Blaze\Runtime\BlazeAttributeBag($__attributes);
unset($__data, $__attributes);
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
    ->add('data-loading:opacity-50 data-loading:pointer-events-none dark:data-loading:border-white/10')
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

<?php if ($align === 'left' || $align === 'start'): ?>
    <?php if (!function_exists('__b2e51013a74a49e3672c3b7b18101ad1')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-inline-field.blade.php'); } ?>
<?php if (isset($__slotsb2e51013a74a49e3672c3b7b18101ad1)) { $__slotsStackb2e51013a74a49e3672c3b7b18101ad1[] = $__slotsb2e51013a74a49e3672c3b7b18101ad1; } ?>
<?php if (isset($__datab2e51013a74a49e3672c3b7b18101ad1)) { $__dataStackb2e51013a74a49e3672c3b7b18101ad1[] = $__datab2e51013a74a49e3672c3b7b18101ad1; } ?>
<?php $__datab2e51013a74a49e3672c3b7b18101ad1 = ['attributes' => $attributes]; ?>
<?php $__slotsb2e51013a74a49e3672c3b7b18101ad1 = []; ?>
<?php $__blaze->pushData($__datab2e51013a74a49e3672c3b7b18101ad1); ?>
<?php ob_start(); ?>
        <ui-switch <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> <?php if($checked): ?> checked data-checked <?php endif; ?> data-flux-control data-flux-switch>
            <span class="<?php echo e(\Illuminate\Support\Arr::toCssClasses($indicatorClasses)); ?>"></span>
        </ui-switch>
    <?php $__slotsb2e51013a74a49e3672c3b7b18101ad1['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsb2e51013a74a49e3672c3b7b18101ad1); ?>
<?php __b2e51013a74a49e3672c3b7b18101ad1($__blaze, $__datab2e51013a74a49e3672c3b7b18101ad1, $__blaze->mergeAttributes(['attributes' => $__datab2e51013a74a49e3672c3b7b18101ad1['attributes']]), $__slotsb2e51013a74a49e3672c3b7b18101ad1, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackb2e51013a74a49e3672c3b7b18101ad1)) { $__slotsb2e51013a74a49e3672c3b7b18101ad1 = array_pop($__slotsStackb2e51013a74a49e3672c3b7b18101ad1); } ?>
<?php if (! empty($__dataStackb2e51013a74a49e3672c3b7b18101ad1)) { $__datab2e51013a74a49e3672c3b7b18101ad1 = array_pop($__dataStackb2e51013a74a49e3672c3b7b18101ad1); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php if (!function_exists('__8eea5eda712a9830ac094d57c5529b6c')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-reversed-inline-field.blade.php'); } ?>
<?php if (isset($__slots8eea5eda712a9830ac094d57c5529b6c)) { $__slotsStack8eea5eda712a9830ac094d57c5529b6c[] = $__slots8eea5eda712a9830ac094d57c5529b6c; } ?>
<?php if (isset($__data8eea5eda712a9830ac094d57c5529b6c)) { $__dataStack8eea5eda712a9830ac094d57c5529b6c[] = $__data8eea5eda712a9830ac094d57c5529b6c; } ?>
<?php $__data8eea5eda712a9830ac094d57c5529b6c = ['attributes' => $attributes]; ?>
<?php $__slots8eea5eda712a9830ac094d57c5529b6c = []; ?>
<?php $__blaze->pushData($__data8eea5eda712a9830ac094d57c5529b6c); ?>
<?php ob_start(); ?>
        <ui-switch <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> <?php if($checked): ?> checked data-checked <?php endif; ?> data-flux-control data-flux-switch>
            <span class="<?php echo e(\Illuminate\Support\Arr::toCssClasses($indicatorClasses)); ?>"></span>
        </ui-switch>
    <?php $__slots8eea5eda712a9830ac094d57c5529b6c['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots8eea5eda712a9830ac094d57c5529b6c); ?>
<?php __8eea5eda712a9830ac094d57c5529b6c($__blaze, $__data8eea5eda712a9830ac094d57c5529b6c, $__blaze->mergeAttributes(['attributes' => $__data8eea5eda712a9830ac094d57c5529b6c['attributes']]), $__slots8eea5eda712a9830ac094d57c5529b6c, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack8eea5eda712a9830ac094d57c5529b6c)) { $__slots8eea5eda712a9830ac094d57c5529b6c = array_pop($__slotsStack8eea5eda712a9830ac094d57c5529b6c); } ?>
<?php if (! empty($__dataStack8eea5eda712a9830ac094d57c5529b6c)) { $__data8eea5eda712a9830ac094d57c5529b6c = array_pop($__dataStack8eea5eda712a9830ac094d57c5529b6c); } ?>
<?php $__blaze->popData(); ?>
<?php endif; ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/switch.blade.php ENDPATH**/ ?>