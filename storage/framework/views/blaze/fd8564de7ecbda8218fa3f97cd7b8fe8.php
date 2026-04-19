<?php
if (!function_exists('__fd8564de7ecbda8218fa3f97cd7b8fe8')):
function __fd8564de7ecbda8218fa3f97cd7b8fe8($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
<?php $__attrsa35b24e3885f01762aff8c840e2c3d4c = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputViewable','xOn:click' => 'toggle()','xBind:dataViewableOpen' => 'open','ariaLabel' => e(__('Toggle password visibility'))]; ?>
<?php $__slotsa35b24e3885f01762aff8c840e2c3d4c = []; ?>
<?php $__blaze->pushData($__attrsa35b24e3885f01762aff8c840e2c3d4c); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/eye-slash.blade.php', $__blaze->compiledPath.'/8a95195255d02582de6ee73c53e895f0.php'); ?>
<?php $__blaze->pushData(['variant' => 'micro','class' => 'hidden [[data-viewable-open]>&]:block']); ?>
<?php __8a95195255d02582de6ee73c53e895f0($__blaze, ['variant' => 'micro','class' => 'hidden [[data-viewable-open]>&]:block'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
    <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/eye.blade.php', $__blaze->compiledPath.'/8be27f698d6839cd4ce27ef72acae41d.php'); ?>
<?php $__blaze->pushData(['variant' => 'micro','class' => 'block [[data-viewable-open]>&]:hidden']); ?>
<?php __8be27f698d6839cd4ce27ef72acae41d($__blaze, ['variant' => 'micro','class' => 'block [[data-viewable-open]>&]:hidden'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slotsa35b24e3885f01762aff8c840e2c3d4c['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsa35b24e3885f01762aff8c840e2c3d4c); ?>
<?php __a35b24e3885f01762aff8c840e2c3d4c($__blaze, $__attrsa35b24e3885f01762aff8c840e2c3d4c, $__slotsa35b24e3885f01762aff8c840e2c3d4c, ['attributes', 'size'], ['xData' => 'x-data', 'xOn:click' => 'x-on:click', 'xBind:dataViewableOpen' => 'x-bind:data-viewable-open', 'ariaLabel' => 'aria-label'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacka35b24e3885f01762aff8c840e2c3d4c)) { $__slotsa35b24e3885f01762aff8c840e2c3d4c = array_pop($__slotsStacka35b24e3885f01762aff8c840e2c3d4c); } ?>
<?php if (! empty($__attrsStacka35b24e3885f01762aff8c840e2c3d4c)) { $__attrsa35b24e3885f01762aff8c840e2c3d4c = array_pop($__attrsStacka35b24e3885f01762aff8c840e2c3d4c); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/input/viewable.blade.php ENDPATH**/ ?>