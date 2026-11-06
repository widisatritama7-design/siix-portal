<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('_0d51994c632bcd3300b3f841d7d19758')):
function _0d51994c632bcd3300b3f841d7d19758($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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

<?php if (!function_exists('_19e9f12f8a300195bcfcda1eb1bbca00')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php'); } ?>
<?php if (isset($__slots19e9f12f8a300195bcfcda1eb1bbca00)) { $__slotsStack19e9f12f8a300195bcfcda1eb1bbca00[] = $__slots19e9f12f8a300195bcfcda1eb1bbca00; } ?>
<?php if (isset($__data19e9f12f8a300195bcfcda1eb1bbca00)) { $__dataStack19e9f12f8a300195bcfcda1eb1bbca00[] = $__data19e9f12f8a300195bcfcda1eb1bbca00; } ?>
<?php $__data19e9f12f8a300195bcfcda1eb1bbca00 = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputViewable','xOn:click' => 'toggle()','xBind:dataViewableOpen' => 'open','ariaLabel' => e(__('Toggle password visibility'))]; ?>
<?php $__slots19e9f12f8a300195bcfcda1eb1bbca00 = []; ?>
<?php $__blaze->pushData($__data19e9f12f8a300195bcfcda1eb1bbca00); ?>
<?php ob_start(); ?>
    <?php if (!function_exists('_99a403e1f875d0e999918355b05ae9ed')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/eye-slash.blade.php'); } ?>
<?php $__componentData = ['variant' => $iconVariant,'class' => 'hidden [[data-viewable-open]>&]:block']; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _99a403e1f875d0e999918355b05ae9ed($__blaze, $__componentData, ['variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['variant']), 'class' => 'hidden [[data-viewable-open]>&]:block'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
    <?php if (!function_exists('_67cee2bdd47a2f070b7e1af9846f847e')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/eye.blade.php'); } ?>
<?php $__componentData = ['variant' => $iconVariant,'class' => 'block [[data-viewable-open]>&]:hidden']; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _67cee2bdd47a2f070b7e1af9846f847e($__blaze, $__componentData, ['variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['variant']), 'class' => 'block [[data-viewable-open]>&]:hidden'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slots19e9f12f8a300195bcfcda1eb1bbca00['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots19e9f12f8a300195bcfcda1eb1bbca00); ?>
<?php _19e9f12f8a300195bcfcda1eb1bbca00($__blaze, $__data19e9f12f8a300195bcfcda1eb1bbca00, $__blaze->mergeAttributes(['attributes' => $__data19e9f12f8a300195bcfcda1eb1bbca00['attributes'], 'size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__data19e9f12f8a300195bcfcda1eb1bbca00['size']), 'x-data' => 'fluxInputViewable', 'x-on:click' => 'toggle()', 'x-bind:data-viewable-open' => 'open', 'aria-label' => $__data19e9f12f8a300195bcfcda1eb1bbca00['ariaLabel']]), $__slots19e9f12f8a300195bcfcda1eb1bbca00, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack19e9f12f8a300195bcfcda1eb1bbca00)) { $__slots19e9f12f8a300195bcfcda1eb1bbca00 = array_pop($__slotsStack19e9f12f8a300195bcfcda1eb1bbca00); } ?>
<?php if (! empty($__dataStack19e9f12f8a300195bcfcda1eb1bbca00)) { $__data19e9f12f8a300195bcfcda1eb1bbca00 = array_pop($__dataStack19e9f12f8a300195bcfcda1eb1bbca00); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/viewable.blade.php ENDPATH**/ ?>