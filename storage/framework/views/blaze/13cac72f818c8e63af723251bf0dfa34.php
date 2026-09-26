<?php
if (!function_exists('__13cac72f818c8e63af723251bf0dfa34')):
function __13cac72f818c8e63af723251bf0dfa34($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php
extract(Flux::forwardedAttributes($attributes, [
    'tooltipPosition',
    'tooltipKbd',
    'tooltip',
]));
?>

<?php $tooltipPosition = $tooltipPosition ??= $attributes->pluck('tooltip:position'); ?>
<?php $tooltipKbd = $tooltipKbd ??= $attributes->pluck('tooltip:kbd'); ?>
<?php $tooltip = $tooltip ??= $attributes->pluck('tooltip'); ?>

<?php
$__defaults = [
    'tooltipPosition' => 'top',
    'tooltipKbd' => null,
    'tooltip' => null,
];
$tooltipPosition ??= $attributes['tooltip-position'] ?? $attributes['tooltipPosition'] ?? $__defaults['tooltipPosition']; unset($attributes['tooltipPosition'], $attributes['tooltip-position']);
$tooltipKbd ??= $attributes['tooltip-kbd'] ?? $attributes['tooltipKbd'] ?? $__defaults['tooltipKbd']; unset($attributes['tooltipKbd'], $attributes['tooltip-kbd']);
$tooltip ??= $attributes['tooltip'] ?? $__defaults['tooltip']; unset($attributes['tooltip']);
unset($__defaults);
?>

<?php if ($tooltip): ?>
    <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/index.blade.php', $__blaze->compiledPath.'/7065c86f3f51cbbcd790ac279168812b.php'); ?>
<?php if (isset($__slots7065c86f3f51cbbcd790ac279168812b)) { $__slotsStack7065c86f3f51cbbcd790ac279168812b[] = $__slots7065c86f3f51cbbcd790ac279168812b; } ?>
<?php if (isset($__attrs7065c86f3f51cbbcd790ac279168812b)) { $__attrsStack7065c86f3f51cbbcd790ac279168812b[] = $__attrs7065c86f3f51cbbcd790ac279168812b; } ?>
<?php $__attrs7065c86f3f51cbbcd790ac279168812b = ['content' => $tooltip,'position' => $tooltipPosition,'kbd' => $tooltipKbd]; ?>
<?php $__slots7065c86f3f51cbbcd790ac279168812b = []; ?>
<?php $__blaze->pushData($__attrs7065c86f3f51cbbcd790ac279168812b); ?>
<?php ob_start(); ?>
        <?php echo e($slot); ?>

    <?php $__slots7065c86f3f51cbbcd790ac279168812b['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots7065c86f3f51cbbcd790ac279168812b); ?>
<?php __7065c86f3f51cbbcd790ac279168812b($__blaze, $__attrs7065c86f3f51cbbcd790ac279168812b, $__slots7065c86f3f51cbbcd790ac279168812b, ['content', 'position', 'kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack7065c86f3f51cbbcd790ac279168812b)) { $__slots7065c86f3f51cbbcd790ac279168812b = array_pop($__slotsStack7065c86f3f51cbbcd790ac279168812b); } ?>
<?php if (! empty($__attrsStack7065c86f3f51cbbcd790ac279168812b)) { $__attrs7065c86f3f51cbbcd790ac279168812b = array_pop($__attrsStack7065c86f3f51cbbcd790ac279168812b); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH D:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/with-tooltip.blade.php ENDPATH**/ ?>