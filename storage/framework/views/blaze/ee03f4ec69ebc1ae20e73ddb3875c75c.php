<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__4cbc1f2bf395f3b40f04c9e6001f5d78')):
function __4cbc1f2bf395f3b40f04c9e6001f5d78($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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

<?php if (!function_exists('__cadbb0464d5033c735e0731e7a0bc02c')) { require $__blaze->compile('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php'); } ?>
<?php if (isset($__slotscadbb0464d5033c735e0731e7a0bc02c)) { $__slotsStackcadbb0464d5033c735e0731e7a0bc02c[] = $__slotscadbb0464d5033c735e0731e7a0bc02c; } ?>
<?php if (isset($__datacadbb0464d5033c735e0731e7a0bc02c)) { $__dataStackcadbb0464d5033c735e0731e7a0bc02c[] = $__datacadbb0464d5033c735e0731e7a0bc02c; } ?>
<?php $__datacadbb0464d5033c735e0731e7a0bc02c = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputClearable','xOn:click' => 'clear()','tabindex' => '-1','ariaLabel' => e(__('Clear input')),'dataFluxClearButton' => true]; ?>
<?php $__slotscadbb0464d5033c735e0731e7a0bc02c = []; ?>
<?php $__blaze->pushData($__datacadbb0464d5033c735e0731e7a0bc02c); ?>
<?php ob_start(); ?>
    <?php if (!function_exists('__4d4dd41dca7e6ab4571da55832a336c3')) { require $__blaze->compile('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/x-mark.blade.php'); } ?>
<?php $__componentData = ['variant' => $iconVariant]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php __4d4dd41dca7e6ab4571da55832a336c3($__blaze, $__componentData, ['variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['variant'])], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slotscadbb0464d5033c735e0731e7a0bc02c['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotscadbb0464d5033c735e0731e7a0bc02c); ?>
<?php __cadbb0464d5033c735e0731e7a0bc02c($__blaze, $__datacadbb0464d5033c735e0731e7a0bc02c, $__blaze->mergeAttributes(['attributes' => $__datacadbb0464d5033c735e0731e7a0bc02c['attributes'], 'size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__datacadbb0464d5033c735e0731e7a0bc02c['size']), 'x-data' => 'fluxInputClearable', 'x-on:click' => 'clear()', 'tabindex' => '-1', 'aria-label' => $__datacadbb0464d5033c735e0731e7a0bc02c['ariaLabel'], 'data-flux-clear-button' => true]), $__slotscadbb0464d5033c735e0731e7a0bc02c, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackcadbb0464d5033c735e0731e7a0bc02c)) { $__slotscadbb0464d5033c735e0731e7a0bc02c = array_pop($__slotsStackcadbb0464d5033c735e0731e7a0bc02c); } ?>
<?php if (! empty($__dataStackcadbb0464d5033c735e0731e7a0bc02c)) { $__datacadbb0464d5033c735e0731e7a0bc02c = array_pop($__dataStackcadbb0464d5033c735e0731e7a0bc02c); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/clearable.blade.php ENDPATH**/ ?>