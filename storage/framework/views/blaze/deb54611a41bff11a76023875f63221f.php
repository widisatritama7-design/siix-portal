<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__da31ed3f19826b59e747e581609b59c5')):
function __da31ed3f19826b59e747e581609b59c5($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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

<?php if (!function_exists('__bd9167e739c6ba3d4eaf6d3a945d4b4c')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php'); } ?>
<?php if (isset($__slotsbd9167e739c6ba3d4eaf6d3a945d4b4c)) { $__slotsStackbd9167e739c6ba3d4eaf6d3a945d4b4c[] = $__slotsbd9167e739c6ba3d4eaf6d3a945d4b4c; } ?>
<?php if (isset($__databd9167e739c6ba3d4eaf6d3a945d4b4c)) { $__dataStackbd9167e739c6ba3d4eaf6d3a945d4b4c[] = $__databd9167e739c6ba3d4eaf6d3a945d4b4c; } ?>
<?php $__databd9167e739c6ba3d4eaf6d3a945d4b4c = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputClearable','xOn:click' => 'clear()','tabindex' => '-1','ariaLabel' => e(__('Clear input')),'dataFluxClearButton' => true]; ?>
<?php $__slotsbd9167e739c6ba3d4eaf6d3a945d4b4c = []; ?>
<?php $__blaze->pushData($__databd9167e739c6ba3d4eaf6d3a945d4b4c); ?>
<?php ob_start(); ?>
    <?php if (!function_exists('__f9914cf2575d9228d1e6079a6cd54804')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/x-mark.blade.php'); } ?>
<?php $__componentData = ['variant' => $iconVariant]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php __f9914cf2575d9228d1e6079a6cd54804($__blaze, $__componentData, ['variant' => \Livewire\Blaze\Runtime\BlazeRuntime::sanitizeFoldedAttribute($__componentData['variant'])], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slotsbd9167e739c6ba3d4eaf6d3a945d4b4c['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsbd9167e739c6ba3d4eaf6d3a945d4b4c); ?>
<?php __bd9167e739c6ba3d4eaf6d3a945d4b4c($__blaze, $__databd9167e739c6ba3d4eaf6d3a945d4b4c, $__blaze->mergeAttributes(['attributes' => $__databd9167e739c6ba3d4eaf6d3a945d4b4c['attributes'], 'size' => \Livewire\Blaze\Runtime\BlazeRuntime::sanitizeFoldedAttribute($__databd9167e739c6ba3d4eaf6d3a945d4b4c['size']), 'x-data' => 'fluxInputClearable', 'x-on:click' => 'clear()', 'tabindex' => '-1', 'aria-label' => $__databd9167e739c6ba3d4eaf6d3a945d4b4c['ariaLabel'], 'data-flux-clear-button' => true]), $__slotsbd9167e739c6ba3d4eaf6d3a945d4b4c, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackbd9167e739c6ba3d4eaf6d3a945d4b4c)) { $__slotsbd9167e739c6ba3d4eaf6d3a945d4b4c = array_pop($__slotsStackbd9167e739c6ba3d4eaf6d3a945d4b4c); } ?>
<?php if (! empty($__dataStackbd9167e739c6ba3d4eaf6d3a945d4b4c)) { $__databd9167e739c6ba3d4eaf6d3a945d4b4c = array_pop($__dataStackbd9167e739c6ba3d4eaf6d3a945d4b4c); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/input/clearable.blade.php ENDPATH**/ ?>