<?php
if (!function_exists('_aa2ea2f849def363467d516f8b517d06')):
function _aa2ea2f849def363467d516f8b517d06($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>



<?php
$__defaults = [
    'variant' => null,
    'size' => null,
    'name' => null,
];
$variant ??= $attributes['variant'] ?? $__defaults['variant']; unset($attributes['variant']);
$size ??= $attributes['size'] ?? $__defaults['size']; unset($attributes['size']);
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
unset($__defaults);
?>

<?php
// We only want to show the name attribute on the checkbox if it has been set
// manually, but not if it has been set from the wire:model attribute...
$showName = isset($name);

if (! isset($name)) {
    $name = $attributes->whereStartsWith('wire:model')->first();
}

$classes = Flux::classes()
    ->add('flex flex-wrap gap-3')
    ;
?>

<?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-field.blade.php', $__blaze->compiledPath.'/5f1fd5be44768539d084481ede0d744f.php'); ?>
<?php if (isset($__slots5f1fd5be44768539d084481ede0d744f)) { $__slotsStack5f1fd5be44768539d084481ede0d744f[] = $__slots5f1fd5be44768539d084481ede0d744f; } ?>
<?php if (isset($__attrs5f1fd5be44768539d084481ede0d744f)) { $__attrsStack5f1fd5be44768539d084481ede0d744f[] = $__attrs5f1fd5be44768539d084481ede0d744f; } ?>
<?php $__attrs5f1fd5be44768539d084481ede0d744f = ['attributes' => $attributes]; ?>
<?php $__slots5f1fd5be44768539d084481ede0d744f = []; ?>
<?php $__blaze->pushData($__attrs5f1fd5be44768539d084481ede0d744f); ?>
<?php ob_start(); ?>
    <ui-checkbox-group <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> data-flux-checkbox-group-pills>
        <?php echo e($slot); ?>

    </ui-checkbox-group>
<?php $__slots5f1fd5be44768539d084481ede0d744f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots5f1fd5be44768539d084481ede0d744f); ?>
<?php _5f1fd5be44768539d084481ede0d744f($__blaze, $__attrs5f1fd5be44768539d084481ede0d744f, $__slots5f1fd5be44768539d084481ede0d744f, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack5f1fd5be44768539d084481ede0d744f)) { $__slots5f1fd5be44768539d084481ede0d744f = array_pop($__slotsStack5f1fd5be44768539d084481ede0d744f); } ?>
<?php if (! empty($__attrsStack5f1fd5be44768539d084481ede0d744f)) { $__attrs5f1fd5be44768539d084481ede0d744f = array_pop($__attrsStack5f1fd5be44768539d084481ede0d744f); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/stubs/resources/views/flux/checkbox/group/variants/pills.blade.php ENDPATH**/ ?>