<?php
if (!function_exists('__2755e01b4291c6521a307d04443ffbfa')):
function __2755e01b4291c6521a307d04443ffbfa($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    'class' => '-me-1',
    'square' => true,
    'size' => null,
]);
?>

<?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php', $__blaze->compiledPath.'/a35b24e3885f01762aff8c840e2c3d4c.php'); ?>
<?php if (isset($__slotsa35b24e3885f01762aff8c840e2c3d4c)) { $__slotsStacka35b24e3885f01762aff8c840e2c3d4c[] = $__slotsa35b24e3885f01762aff8c840e2c3d4c; } ?>
<?php if (isset($__attrsa35b24e3885f01762aff8c840e2c3d4c)) { $__attrsStacka35b24e3885f01762aff8c840e2c3d4c[] = $__attrsa35b24e3885f01762aff8c840e2c3d4c; } ?>
<?php $__attrsa35b24e3885f01762aff8c840e2c3d4c = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm']; ?>
<?php $__slotsa35b24e3885f01762aff8c840e2c3d4c = []; ?>
<?php $__blaze->pushData($__attrsa35b24e3885f01762aff8c840e2c3d4c); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/chevron-down.blade.php', $__blaze->compiledPath.'/01d61a301bb37650cf0db70914fa1dc6.php'); ?>
<?php $__blaze->pushData(['variant' => 'micro']); ?>
<?php __01d61a301bb37650cf0db70914fa1dc6($__blaze, ['variant' => 'micro'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slotsa35b24e3885f01762aff8c840e2c3d4c['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsa35b24e3885f01762aff8c840e2c3d4c); ?>
<?php __a35b24e3885f01762aff8c840e2c3d4c($__blaze, $__attrsa35b24e3885f01762aff8c840e2c3d4c, $__slotsa35b24e3885f01762aff8c840e2c3d4c, ['attributes', 'size'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacka35b24e3885f01762aff8c840e2c3d4c)) { $__slotsa35b24e3885f01762aff8c840e2c3d4c = array_pop($__slotsStacka35b24e3885f01762aff8c840e2c3d4c); } ?>
<?php if (! empty($__attrsStacka35b24e3885f01762aff8c840e2c3d4c)) { $__attrsa35b24e3885f01762aff8c840e2c3d4c = array_pop($__attrsStacka35b24e3885f01762aff8c840e2c3d4c); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/input/expandable.blade.php ENDPATH**/ ?>