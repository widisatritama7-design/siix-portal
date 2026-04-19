<?php
if (!function_exists('__00352201adca44611d7f1e9d054457dd')):
function __00352201adca44611d7f1e9d054457dd($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
<?php $__attrsa35b24e3885f01762aff8c840e2c3d4c = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputCopyable','xOn:click' => 'copy()','xBind:dataCopyableCopied' => 'copied','ariaLabel' => e(__('Copy to clipboard'))]; ?>
<?php $__slotsa35b24e3885f01762aff8c840e2c3d4c = []; ?>
<?php $__blaze->pushData($__attrsa35b24e3885f01762aff8c840e2c3d4c); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/clipboard-document-check.blade.php', $__blaze->compiledPath.'/a98e7ff307548a7e98493a9b0a0e7a89.php'); ?>
<?php $__blaze->pushData(['variant' => 'mini','class' => 'hidden [[data-copyable-copied]>&]:block']); ?>
<?php __a98e7ff307548a7e98493a9b0a0e7a89($__blaze, ['variant' => 'mini','class' => 'hidden [[data-copyable-copied]>&]:block'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
    <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/clipboard-document.blade.php', $__blaze->compiledPath.'/1688998726a38753a975ca2b2f22c904.php'); ?>
<?php $__blaze->pushData(['variant' => 'mini','class' => 'block [[data-copyable-copied]>&]:hidden']); ?>
<?php __1688998726a38753a975ca2b2f22c904($__blaze, ['variant' => 'mini','class' => 'block [[data-copyable-copied]>&]:hidden'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slotsa35b24e3885f01762aff8c840e2c3d4c['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsa35b24e3885f01762aff8c840e2c3d4c); ?>
<?php __a35b24e3885f01762aff8c840e2c3d4c($__blaze, $__attrsa35b24e3885f01762aff8c840e2c3d4c, $__slotsa35b24e3885f01762aff8c840e2c3d4c, ['attributes', 'size'], ['xData' => 'x-data', 'xOn:click' => 'x-on:click', 'xBind:dataCopyableCopied' => 'x-bind:data-copyable-copied', 'ariaLabel' => 'aria-label'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacka35b24e3885f01762aff8c840e2c3d4c)) { $__slotsa35b24e3885f01762aff8c840e2c3d4c = array_pop($__slotsStacka35b24e3885f01762aff8c840e2c3d4c); } ?>
<?php if (! empty($__attrsStacka35b24e3885f01762aff8c840e2c3d4c)) { $__attrsa35b24e3885f01762aff8c840e2c3d4c = array_pop($__attrsStacka35b24e3885f01762aff8c840e2c3d4c); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/input/copyable.blade.php ENDPATH**/ ?>