<?php
if (!function_exists('_6a6ca24f6c7d0d077653b4a0f542fc43')):
function _6a6ca24f6c7d0d077653b4a0f542fc43($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    'iconVariant' => 'mini',
    'size' => null,
];
$iconVariant ??= $attributes['icon-variant'] ?? $attributes['iconVariant'] ?? $__defaults['iconVariant']; unset($attributes['iconVariant'], $attributes['icon-variant']);
$size ??= $attributes['size'] ?? $__defaults['size']; unset($attributes['size']);
unset($__defaults);
?>

<?php
$attributes = $attributes->merge([
    'variant' => 'subtle',
    'class' => '-me-1',
    'square' => true,
    'size' => null,
]);
?>

<?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php', $__blaze->compiledPath.'/3640ea5238dbada28fee784f04405d7f.php'); ?>
<?php if (isset($__slots3640ea5238dbada28fee784f04405d7f)) { $__slotsStack3640ea5238dbada28fee784f04405d7f[] = $__slots3640ea5238dbada28fee784f04405d7f; } ?>
<?php if (isset($__attrs3640ea5238dbada28fee784f04405d7f)) { $__attrsStack3640ea5238dbada28fee784f04405d7f[] = $__attrs3640ea5238dbada28fee784f04405d7f; } ?>
<?php $__attrs3640ea5238dbada28fee784f04405d7f = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm']; ?>
<?php $__slots3640ea5238dbada28fee784f04405d7f = []; ?>
<?php $__blaze->pushData($__attrs3640ea5238dbada28fee784f04405d7f); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/chevron-down.blade.php', $__blaze->compiledPath.'/bf78aef17ecfcd3887d7024041c5d263.php'); ?>
<?php $__blaze->pushData(['variant' => $iconVariant]); ?>
<?php _bf78aef17ecfcd3887d7024041c5d263($__blaze, ['variant' => $iconVariant], [], ['variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slots3640ea5238dbada28fee784f04405d7f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3640ea5238dbada28fee784f04405d7f); ?>
<?php _3640ea5238dbada28fee784f04405d7f($__blaze, $__attrs3640ea5238dbada28fee784f04405d7f, $__slots3640ea5238dbada28fee784f04405d7f, ['attributes', 'size'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3640ea5238dbada28fee784f04405d7f)) { $__slots3640ea5238dbada28fee784f04405d7f = array_pop($__slotsStack3640ea5238dbada28fee784f04405d7f); } ?>
<?php if (! empty($__attrsStack3640ea5238dbada28fee784f04405d7f)) { $__attrs3640ea5238dbada28fee784f04405d7f = array_pop($__attrsStack3640ea5238dbada28fee784f04405d7f); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\stubs\resources\views\flux\input\expandable.blade.php ENDPATH**/ ?>