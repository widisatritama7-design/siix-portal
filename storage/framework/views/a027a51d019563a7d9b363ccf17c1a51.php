<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('_cb33394864c61349537b2784022d8c15')):
function _cb33394864c61349537b2784022d8c15($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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

<?php if (!function_exists('_bd9167e739c6ba3d4eaf6d3a945d4b4c')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php'); } ?>
<?php if (isset($__slotsbd9167e739c6ba3d4eaf6d3a945d4b4c)) { $__slotsStackbd9167e739c6ba3d4eaf6d3a945d4b4c[] = $__slotsbd9167e739c6ba3d4eaf6d3a945d4b4c; } ?>
<?php if (isset($__databd9167e739c6ba3d4eaf6d3a945d4b4c)) { $__dataStackbd9167e739c6ba3d4eaf6d3a945d4b4c[] = $__databd9167e739c6ba3d4eaf6d3a945d4b4c; } ?>
<?php $__databd9167e739c6ba3d4eaf6d3a945d4b4c = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputViewable','xOn:click' => 'toggle()','xBind:dataViewableOpen' => 'open','ariaLabel' => e(__('Toggle password visibility'))]; ?>
<?php $__slotsbd9167e739c6ba3d4eaf6d3a945d4b4c = []; ?>
<?php $__blaze->pushData($__databd9167e739c6ba3d4eaf6d3a945d4b4c); ?>
<?php ob_start(); ?>
    <?php if (!function_exists('_73754157292cb0577192e30f7ea70aad')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/eye-slash.blade.php'); } ?>
<?php $__componentData = ['variant' => $iconVariant,'class' => 'hidden [[data-viewable-open]>&]:block']; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _73754157292cb0577192e30f7ea70aad($__blaze, $__componentData, ['variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['variant']), 'class' => 'hidden [[data-viewable-open]>&]:block'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
    <?php if (!function_exists('_422d72d798efb81892db049b87ea7b10')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/eye.blade.php'); } ?>
<?php $__componentData = ['variant' => $iconVariant,'class' => 'block [[data-viewable-open]>&]:hidden']; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _422d72d798efb81892db049b87ea7b10($__blaze, $__componentData, ['variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['variant']), 'class' => 'block [[data-viewable-open]>&]:hidden'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slotsbd9167e739c6ba3d4eaf6d3a945d4b4c['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsbd9167e739c6ba3d4eaf6d3a945d4b4c); ?>
<?php _bd9167e739c6ba3d4eaf6d3a945d4b4c($__blaze, $__databd9167e739c6ba3d4eaf6d3a945d4b4c, $__blaze->mergeAttributes(['attributes' => $__databd9167e739c6ba3d4eaf6d3a945d4b4c['attributes'], 'size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__databd9167e739c6ba3d4eaf6d3a945d4b4c['size']), 'x-data' => 'fluxInputViewable', 'x-on:click' => 'toggle()', 'x-bind:data-viewable-open' => 'open', 'aria-label' => $__databd9167e739c6ba3d4eaf6d3a945d4b4c['ariaLabel']]), $__slotsbd9167e739c6ba3d4eaf6d3a945d4b4c, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackbd9167e739c6ba3d4eaf6d3a945d4b4c)) { $__slotsbd9167e739c6ba3d4eaf6d3a945d4b4c = array_pop($__slotsStackbd9167e739c6ba3d4eaf6d3a945d4b4c); } ?>
<?php if (! empty($__dataStackbd9167e739c6ba3d4eaf6d3a945d4b4c)) { $__databd9167e739c6ba3d4eaf6d3a945d4b4c = array_pop($__dataStackbd9167e739c6ba3d4eaf6d3a945d4b4c); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/input/viewable.blade.php ENDPATH**/ ?>