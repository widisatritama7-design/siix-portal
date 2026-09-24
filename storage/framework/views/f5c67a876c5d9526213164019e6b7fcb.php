<?php
if (!function_exists('_f5c67a876c5d9526213164019e6b7fcb')):
function _f5c67a876c5d9526213164019e6b7fcb($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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

<?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php', $__blaze->compiledPath.'/487eed12f4c62537fd888f693822b25a.php'); ?>
<?php if (isset($__slots487eed12f4c62537fd888f693822b25a)) { $__slotsStack487eed12f4c62537fd888f693822b25a[] = $__slots487eed12f4c62537fd888f693822b25a; } ?>
<?php if (isset($__attrs487eed12f4c62537fd888f693822b25a)) { $__attrsStack487eed12f4c62537fd888f693822b25a[] = $__attrs487eed12f4c62537fd888f693822b25a; } ?>
<?php $__attrs487eed12f4c62537fd888f693822b25a = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputViewable','xOn:click' => 'toggle()','xBind:dataViewableOpen' => 'open','ariaLabel' => e(__('Toggle password visibility'))]; ?>
<?php $__slots487eed12f4c62537fd888f693822b25a = []; ?>
<?php $__blaze->pushData($__attrs487eed12f4c62537fd888f693822b25a); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/eye-slash.blade.php', $__blaze->compiledPath.'/d7520a20e6e01517360ac2a2ab2ad623.php'); ?>
<?php $__blaze->pushData(['variant' => $iconVariant,'class' => 'hidden [[data-viewable-open]>&]:block']); ?>
<?php _d7520a20e6e01517360ac2a2ab2ad623($__blaze, ['variant' => $iconVariant,'class' => 'hidden [[data-viewable-open]>&]:block'], [], ['variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/eye.blade.php', $__blaze->compiledPath.'/aa306159d8a6fe39bf5d63ebf11e126b.php'); ?>
<?php $__blaze->pushData(['variant' => $iconVariant,'class' => 'block [[data-viewable-open]>&]:hidden']); ?>
<?php _aa306159d8a6fe39bf5d63ebf11e126b($__blaze, ['variant' => $iconVariant,'class' => 'block [[data-viewable-open]>&]:hidden'], [], ['variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slots487eed12f4c62537fd888f693822b25a['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots487eed12f4c62537fd888f693822b25a); ?>
<?php _487eed12f4c62537fd888f693822b25a($__blaze, $__attrs487eed12f4c62537fd888f693822b25a, $__slots487eed12f4c62537fd888f693822b25a, ['attributes', 'size'], ['xData' => 'x-data', 'xOn:click' => 'x-on:click', 'xBind:dataViewableOpen' => 'x-bind:data-viewable-open', 'ariaLabel' => 'aria-label'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack487eed12f4c62537fd888f693822b25a)) { $__slots487eed12f4c62537fd888f693822b25a = array_pop($__slotsStack487eed12f4c62537fd888f693822b25a); } ?>
<?php if (! empty($__attrsStack487eed12f4c62537fd888f693822b25a)) { $__attrs487eed12f4c62537fd888f693822b25a = array_pop($__attrsStack487eed12f4c62537fd888f693822b25a); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/viewable.blade.php ENDPATH**/ ?>