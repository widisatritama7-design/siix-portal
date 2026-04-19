<?php
if (!function_exists('__7dac9d0fd85de402b7ff147a69f6cd9d')):
function __7dac9d0fd85de402b7ff147a69f6cd9d($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php
$attributes = $attributes->merge([
    'variant' => 'subtle',
    'class' => '-me-1 [[data-flux-input]:has(input:placeholder-shown)_&]:hidden [[data-flux-input]:has(input[disabled])_&]:hidden',
    'square' => true,
    'size' => null,
]);
?>

<?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php', $__blaze->compiledPath.'/a35b24e3885f01762aff8c840e2c3d4c.php'); ?>
<?php if (isset($__slotsa35b24e3885f01762aff8c840e2c3d4c)) { $__slotsStacka35b24e3885f01762aff8c840e2c3d4c[] = $__slotsa35b24e3885f01762aff8c840e2c3d4c; } ?>
<?php if (isset($__attrsa35b24e3885f01762aff8c840e2c3d4c)) { $__attrsStacka35b24e3885f01762aff8c840e2c3d4c[] = $__attrsa35b24e3885f01762aff8c840e2c3d4c; } ?>
<?php $__attrsa35b24e3885f01762aff8c840e2c3d4c = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputClearable','xOn:click' => 'clear()','tabindex' => '-1','ariaLabel' => 'Clear input','dataFluxClearButton' => true]; ?>
<?php $__slotsa35b24e3885f01762aff8c840e2c3d4c = []; ?>
<?php $__blaze->pushData($__attrsa35b24e3885f01762aff8c840e2c3d4c); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/x-mark.blade.php', $__blaze->compiledPath.'/a3c3d9373eaa3ce234b2fd39ad271543.php'); ?>
<?php $__blaze->pushData(['variant' => 'micro']); ?>
<?php __a3c3d9373eaa3ce234b2fd39ad271543($__blaze, ['variant' => 'micro'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slotsa35b24e3885f01762aff8c840e2c3d4c['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsa35b24e3885f01762aff8c840e2c3d4c); ?>
<?php __a35b24e3885f01762aff8c840e2c3d4c($__blaze, $__attrsa35b24e3885f01762aff8c840e2c3d4c, $__slotsa35b24e3885f01762aff8c840e2c3d4c, ['attributes', 'size', 'dataFluxClearButton'], ['xData' => 'x-data', 'xOn:click' => 'x-on:click', 'ariaLabel' => 'aria-label', 'dataFluxClearButton' => 'data-flux-clear-button'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacka35b24e3885f01762aff8c840e2c3d4c)) { $__slotsa35b24e3885f01762aff8c840e2c3d4c = array_pop($__slotsStacka35b24e3885f01762aff8c840e2c3d4c); } ?>
<?php if (! empty($__attrsStacka35b24e3885f01762aff8c840e2c3d4c)) { $__attrsa35b24e3885f01762aff8c840e2c3d4c = array_pop($__attrsStacka35b24e3885f01762aff8c840e2c3d4c); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/input/clearable.blade.php ENDPATH**/ ?>