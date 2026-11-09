<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__d05d796b6e43dc42e9136863d783da80')):
function __d05d796b6e43dc42e9136863d783da80($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = new \Livewire\Blaze\Runtime\BlazeAttributeBag($__attributes);
unset($__data, $__attributes);
ob_start();
?>


<?php
$__defaults = [
    'value' => null,
];
$value ??= $attributes['value'] ?? $__defaults['value']; unset($attributes['value']);
unset($__defaults);
?>

<option
    <?php echo e($attributes); ?>

    <?php if(isset($value)): ?> value="<?php echo e($value); ?>" <?php endif; ?>
    <?php if(isset($value)): ?> wire:key="<?php echo e($value); ?>" <?php endif; ?>
><?php echo e($slot); ?></option><?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/select/option/variants/default.blade.php ENDPATH**/ ?>