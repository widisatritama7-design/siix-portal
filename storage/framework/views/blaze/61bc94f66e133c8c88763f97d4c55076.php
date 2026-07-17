<?php
if (!function_exists('__61bc94f66e133c8c88763f97d4c55076')):
function __61bc94f66e133c8c88763f97d4c55076($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/index.blade.php', $__blaze->compiledPath.'/808b9b4046ff2f9c00b5d65e5bd272e2.php'); ?>
<?php if (isset($__slots808b9b4046ff2f9c00b5d65e5bd272e2)) { $__slotsStack808b9b4046ff2f9c00b5d65e5bd272e2[] = $__slots808b9b4046ff2f9c00b5d65e5bd272e2; } ?>
<?php if (isset($__attrs808b9b4046ff2f9c00b5d65e5bd272e2)) { $__attrsStack808b9b4046ff2f9c00b5d65e5bd272e2[] = $__attrs808b9b4046ff2f9c00b5d65e5bd272e2; } ?>
<?php $__attrs808b9b4046ff2f9c00b5d65e5bd272e2 = ['content' => $tooltip,'position' => $tooltipPosition,'kbd' => $tooltipKbd]; ?>
<?php $__slots808b9b4046ff2f9c00b5d65e5bd272e2 = []; ?>
<?php $__blaze->pushData($__attrs808b9b4046ff2f9c00b5d65e5bd272e2); ?>
<?php ob_start(); ?>
        <?php echo e($slot); ?>

    <?php $__slots808b9b4046ff2f9c00b5d65e5bd272e2['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots808b9b4046ff2f9c00b5d65e5bd272e2); ?>
<?php __808b9b4046ff2f9c00b5d65e5bd272e2($__blaze, $__attrs808b9b4046ff2f9c00b5d65e5bd272e2, $__slots808b9b4046ff2f9c00b5d65e5bd272e2, ['content', 'position', 'kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack808b9b4046ff2f9c00b5d65e5bd272e2)) { $__slots808b9b4046ff2f9c00b5d65e5bd272e2 = array_pop($__slotsStack808b9b4046ff2f9c00b5d65e5bd272e2); } ?>
<?php if (! empty($__attrsStack808b9b4046ff2f9c00b5d65e5bd272e2)) { $__attrs808b9b4046ff2f9c00b5d65e5bd272e2 = array_pop($__attrsStack808b9b4046ff2f9c00b5d65e5bd272e2); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-tooltip.blade.php ENDPATH**/ ?>