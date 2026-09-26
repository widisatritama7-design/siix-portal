<?php
if (!function_exists('__e35cc8ffd708cdc2098b266851376881')):
function __e35cc8ffd708cdc2098b266851376881($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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

<?php $__blaze->ensureRequired('D:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php', $__blaze->compiledPath.'/69a81dacd8cfa97fe31e5aacbe052106.php'); ?>
<?php if (isset($__slots69a81dacd8cfa97fe31e5aacbe052106)) { $__slotsStack69a81dacd8cfa97fe31e5aacbe052106[] = $__slots69a81dacd8cfa97fe31e5aacbe052106; } ?>
<?php if (isset($__attrs69a81dacd8cfa97fe31e5aacbe052106)) { $__attrsStack69a81dacd8cfa97fe31e5aacbe052106[] = $__attrs69a81dacd8cfa97fe31e5aacbe052106; } ?>
<?php $__attrs69a81dacd8cfa97fe31e5aacbe052106 = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputClearable','xOn:click' => 'clear()','tabindex' => '-1','ariaLabel' => e(__('Clear input')),'dataFluxClearButton' => true]; ?>
<?php $__slots69a81dacd8cfa97fe31e5aacbe052106 = []; ?>
<?php $__blaze->pushData($__attrs69a81dacd8cfa97fe31e5aacbe052106); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/x-mark.blade.php', $__blaze->compiledPath.'/538207d94a2a0d938b501b023a5d0767.php'); ?>
<?php $__blaze->pushData(['variant' => $iconVariant]); ?>
<?php __538207d94a2a0d938b501b023a5d0767($__blaze, ['variant' => $iconVariant], [], ['variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slots69a81dacd8cfa97fe31e5aacbe052106['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots69a81dacd8cfa97fe31e5aacbe052106); ?>
<?php __69a81dacd8cfa97fe31e5aacbe052106($__blaze, $__attrs69a81dacd8cfa97fe31e5aacbe052106, $__slots69a81dacd8cfa97fe31e5aacbe052106, ['attributes', 'size', 'dataFluxClearButton'], ['xData' => 'x-data', 'xOn:click' => 'x-on:click', 'ariaLabel' => 'aria-label', 'dataFluxClearButton' => 'data-flux-clear-button'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack69a81dacd8cfa97fe31e5aacbe052106)) { $__slots69a81dacd8cfa97fe31e5aacbe052106 = array_pop($__slotsStack69a81dacd8cfa97fe31e5aacbe052106); } ?>
<?php if (! empty($__attrsStack69a81dacd8cfa97fe31e5aacbe052106)) { $__attrs69a81dacd8cfa97fe31e5aacbe052106 = array_pop($__attrsStack69a81dacd8cfa97fe31e5aacbe052106); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH D:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/input/clearable.blade.php ENDPATH**/ ?>