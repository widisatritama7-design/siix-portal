<?php
if (!function_exists('_deb54611a41bff11a76023875f63221f')):
function _deb54611a41bff11a76023875f63221f($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    'class' => '-me-1 [[data-flux-input]:has(input:placeholder-shown)_&]:hidden [[data-flux-input]:has(input[disabled])_&]:hidden',
    'square' => true,
    'size' => null,
]);
?>

<?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php', $__blaze->compiledPath.'/3640ea5238dbada28fee784f04405d7f.php'); ?>
<?php if (isset($__slots3640ea5238dbada28fee784f04405d7f)) { $__slotsStack3640ea5238dbada28fee784f04405d7f[] = $__slots3640ea5238dbada28fee784f04405d7f; } ?>
<?php if (isset($__attrs3640ea5238dbada28fee784f04405d7f)) { $__attrsStack3640ea5238dbada28fee784f04405d7f[] = $__attrs3640ea5238dbada28fee784f04405d7f; } ?>
<?php $__attrs3640ea5238dbada28fee784f04405d7f = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputClearable','xOn:click' => 'clear()','tabindex' => '-1','ariaLabel' => e(__('Clear input')),'dataFluxClearButton' => true]; ?>
<?php $__slots3640ea5238dbada28fee784f04405d7f = []; ?>
<?php $__blaze->pushData($__attrs3640ea5238dbada28fee784f04405d7f); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/x-mark.blade.php', $__blaze->compiledPath.'/c64e23172884d02d9e8ce137d7384f8d.php'); ?>
<?php $__blaze->pushData(['variant' => $iconVariant]); ?>
<?php _c64e23172884d02d9e8ce137d7384f8d($__blaze, ['variant' => $iconVariant], [], ['variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slots3640ea5238dbada28fee784f04405d7f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3640ea5238dbada28fee784f04405d7f); ?>
<?php _3640ea5238dbada28fee784f04405d7f($__blaze, $__attrs3640ea5238dbada28fee784f04405d7f, $__slots3640ea5238dbada28fee784f04405d7f, ['attributes', 'size', 'dataFluxClearButton'], ['xData' => 'x-data', 'xOn:click' => 'x-on:click', 'ariaLabel' => 'aria-label', 'dataFluxClearButton' => 'data-flux-clear-button'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3640ea5238dbada28fee784f04405d7f)) { $__slots3640ea5238dbada28fee784f04405d7f = array_pop($__slotsStack3640ea5238dbada28fee784f04405d7f); } ?>
<?php if (! empty($__attrsStack3640ea5238dbada28fee784f04405d7f)) { $__attrs3640ea5238dbada28fee784f04405d7f = array_pop($__attrsStack3640ea5238dbada28fee784f04405d7f); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/input/clearable.blade.php ENDPATH**/ ?>