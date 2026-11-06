<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__ecc47c434ae58cb0aa9d6dd71897ac40')):
function __ecc47c434ae58cb0aa9d6dd71897ac40($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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
    'class' => '-me-1 [[data-flux-input]:has(input:placeholder-shown)_&]:hidden [[data-flux-input]:has(input[disabled])_&]:hidden',
    'square' => true,
    'size' => null,
]);
?>

<?php if (!function_exists('__19e9f12f8a300195bcfcda1eb1bbca00')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php'); } ?>
<?php if (isset($__slots19e9f12f8a300195bcfcda1eb1bbca00)) { $__slotsStack19e9f12f8a300195bcfcda1eb1bbca00[] = $__slots19e9f12f8a300195bcfcda1eb1bbca00; } ?>
<?php if (isset($__data19e9f12f8a300195bcfcda1eb1bbca00)) { $__dataStack19e9f12f8a300195bcfcda1eb1bbca00[] = $__data19e9f12f8a300195bcfcda1eb1bbca00; } ?>
<?php $__data19e9f12f8a300195bcfcda1eb1bbca00 = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputClearable','xOn:click' => 'clear()','tabindex' => '-1','ariaLabel' => e(__('Clear input')),'dataFluxClearButton' => true]; ?>
<?php $__slots19e9f12f8a300195bcfcda1eb1bbca00 = []; ?>
<?php $__blaze->pushData($__data19e9f12f8a300195bcfcda1eb1bbca00); ?>
<?php ob_start(); ?>
    <?php if (!function_exists('__32faceab033f640da906bff24d008dfe')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/x-mark.blade.php'); } ?>
<?php $__componentData = ['variant' => $iconVariant]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php __32faceab033f640da906bff24d008dfe($__blaze, $__componentData, ['variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['variant'])], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slots19e9f12f8a300195bcfcda1eb1bbca00['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots19e9f12f8a300195bcfcda1eb1bbca00); ?>
<?php __19e9f12f8a300195bcfcda1eb1bbca00($__blaze, $__data19e9f12f8a300195bcfcda1eb1bbca00, $__blaze->mergeAttributes(['attributes' => $__data19e9f12f8a300195bcfcda1eb1bbca00['attributes'], 'size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__data19e9f12f8a300195bcfcda1eb1bbca00['size']), 'x-data' => 'fluxInputClearable', 'x-on:click' => 'clear()', 'tabindex' => '-1', 'aria-label' => $__data19e9f12f8a300195bcfcda1eb1bbca00['ariaLabel'], 'data-flux-clear-button' => true]), $__slots19e9f12f8a300195bcfcda1eb1bbca00, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack19e9f12f8a300195bcfcda1eb1bbca00)) { $__slots19e9f12f8a300195bcfcda1eb1bbca00 = array_pop($__slotsStack19e9f12f8a300195bcfcda1eb1bbca00); } ?>
<?php if (! empty($__dataStack19e9f12f8a300195bcfcda1eb1bbca00)) { $__data19e9f12f8a300195bcfcda1eb1bbca00 = array_pop($__dataStack19e9f12f8a300195bcfcda1eb1bbca00); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/clearable.blade.php ENDPATH**/ ?>