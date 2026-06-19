<?php
if (!function_exists('_7e2aab74b42ed28e2f314e2c8a7de3c3')):
function _7e2aab74b42ed28e2f314e2c8a7de3c3($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/index.blade.php', $__blaze->compiledPath.'/1e349890a464f9948f6af12013af6f7e.php'); ?>
<?php if (isset($__slots1e349890a464f9948f6af12013af6f7e)) { $__slotsStack1e349890a464f9948f6af12013af6f7e[] = $__slots1e349890a464f9948f6af12013af6f7e; } ?>
<?php if (isset($__attrs1e349890a464f9948f6af12013af6f7e)) { $__attrsStack1e349890a464f9948f6af12013af6f7e[] = $__attrs1e349890a464f9948f6af12013af6f7e; } ?>
<?php $__attrs1e349890a464f9948f6af12013af6f7e = ['content' => $tooltip,'position' => $tooltipPosition,'kbd' => $tooltipKbd]; ?>
<?php $__slots1e349890a464f9948f6af12013af6f7e = []; ?>
<?php $__blaze->pushData($__attrs1e349890a464f9948f6af12013af6f7e); ?>
<?php ob_start(); ?>
        <?php echo e($slot); ?>

    <?php $__slots1e349890a464f9948f6af12013af6f7e['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots1e349890a464f9948f6af12013af6f7e); ?>
<?php _1e349890a464f9948f6af12013af6f7e($__blaze, $__attrs1e349890a464f9948f6af12013af6f7e, $__slots1e349890a464f9948f6af12013af6f7e, ['content', 'position', 'kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack1e349890a464f9948f6af12013af6f7e)) { $__slots1e349890a464f9948f6af12013af6f7e = array_pop($__slotsStack1e349890a464f9948f6af12013af6f7e); } ?>
<?php if (! empty($__attrsStack1e349890a464f9948f6af12013af6f7e)) { $__attrs1e349890a464f9948f6af12013af6f7e = array_pop($__attrsStack1e349890a464f9948f6af12013af6f7e); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-tooltip.blade.php ENDPATH**/ ?>