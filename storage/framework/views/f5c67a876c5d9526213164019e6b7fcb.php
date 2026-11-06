<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('_3d1a663e897f09e20c19ca18b3ad5b94')):
function _3d1a663e897f09e20c19ca18b3ad5b94($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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

<?php if (!function_exists('_cadbb0464d5033c735e0731e7a0bc02c')) { require $__blaze->compile('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php'); } ?>
<?php if (isset($__slotscadbb0464d5033c735e0731e7a0bc02c)) { $__slotsStackcadbb0464d5033c735e0731e7a0bc02c[] = $__slotscadbb0464d5033c735e0731e7a0bc02c; } ?>
<?php if (isset($__datacadbb0464d5033c735e0731e7a0bc02c)) { $__dataStackcadbb0464d5033c735e0731e7a0bc02c[] = $__datacadbb0464d5033c735e0731e7a0bc02c; } ?>
<?php $__datacadbb0464d5033c735e0731e7a0bc02c = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputViewable','xOn:click' => 'toggle()','xBind:dataViewableOpen' => 'open','ariaLabel' => e(__('Toggle password visibility'))]; ?>
<?php $__slotscadbb0464d5033c735e0731e7a0bc02c = []; ?>
<?php $__blaze->pushData($__datacadbb0464d5033c735e0731e7a0bc02c); ?>
<?php ob_start(); ?>
    <?php if (!function_exists('_6f9e270e186cdf4bedbb2ee44d4140ff')) { require $__blaze->compile('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/eye-slash.blade.php'); } ?>
<?php $__componentData = ['variant' => $iconVariant,'class' => 'hidden [[data-viewable-open]>&]:block']; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _6f9e270e186cdf4bedbb2ee44d4140ff($__blaze, $__componentData, ['variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['variant']), 'class' => 'hidden [[data-viewable-open]>&]:block'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
    <?php if (!function_exists('_773760809baa3b6878122f5f0414239e')) { require $__blaze->compile('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/eye.blade.php'); } ?>
<?php $__componentData = ['variant' => $iconVariant,'class' => 'block [[data-viewable-open]>&]:hidden']; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _773760809baa3b6878122f5f0414239e($__blaze, $__componentData, ['variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['variant']), 'class' => 'block [[data-viewable-open]>&]:hidden'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slotscadbb0464d5033c735e0731e7a0bc02c['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotscadbb0464d5033c735e0731e7a0bc02c); ?>
<?php _cadbb0464d5033c735e0731e7a0bc02c($__blaze, $__datacadbb0464d5033c735e0731e7a0bc02c, $__blaze->mergeAttributes(['attributes' => $__datacadbb0464d5033c735e0731e7a0bc02c['attributes'], 'size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__datacadbb0464d5033c735e0731e7a0bc02c['size']), 'x-data' => 'fluxInputViewable', 'x-on:click' => 'toggle()', 'x-bind:data-viewable-open' => 'open', 'aria-label' => $__datacadbb0464d5033c735e0731e7a0bc02c['ariaLabel']]), $__slotscadbb0464d5033c735e0731e7a0bc02c, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackcadbb0464d5033c735e0731e7a0bc02c)) { $__slotscadbb0464d5033c735e0731e7a0bc02c = array_pop($__slotsStackcadbb0464d5033c735e0731e7a0bc02c); } ?>
<?php if (! empty($__dataStackcadbb0464d5033c735e0731e7a0bc02c)) { $__datacadbb0464d5033c735e0731e7a0bc02c = array_pop($__dataStackcadbb0464d5033c735e0731e7a0bc02c); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/viewable.blade.php ENDPATH**/ ?>