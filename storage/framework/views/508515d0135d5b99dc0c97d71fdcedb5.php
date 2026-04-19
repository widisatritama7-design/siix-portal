<?php
if (!function_exists('_508515d0135d5b99dc0c97d71fdcedb5')):
function _508515d0135d5b99dc0c97d71fdcedb5($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/index.blade.php', $__blaze->compiledPath.'/d2ff6bde64aba3d6d9e0ef81fb505b85.php'); ?>
<?php if (isset($__slotsd2ff6bde64aba3d6d9e0ef81fb505b85)) { $__slotsStackd2ff6bde64aba3d6d9e0ef81fb505b85[] = $__slotsd2ff6bde64aba3d6d9e0ef81fb505b85; } ?>
<?php if (isset($__attrsd2ff6bde64aba3d6d9e0ef81fb505b85)) { $__attrsStackd2ff6bde64aba3d6d9e0ef81fb505b85[] = $__attrsd2ff6bde64aba3d6d9e0ef81fb505b85; } ?>
<?php $__attrsd2ff6bde64aba3d6d9e0ef81fb505b85 = ['content' => $tooltip,'position' => $tooltipPosition,'kbd' => $tooltipKbd]; ?>
<?php $__slotsd2ff6bde64aba3d6d9e0ef81fb505b85 = []; ?>
<?php $__blaze->pushData($__attrsd2ff6bde64aba3d6d9e0ef81fb505b85); ?>
<?php ob_start(); ?>
        <?php echo e($slot); ?>

    <?php $__slotsd2ff6bde64aba3d6d9e0ef81fb505b85['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsd2ff6bde64aba3d6d9e0ef81fb505b85); ?>
<?php _d2ff6bde64aba3d6d9e0ef81fb505b85($__blaze, $__attrsd2ff6bde64aba3d6d9e0ef81fb505b85, $__slotsd2ff6bde64aba3d6d9e0ef81fb505b85, ['content', 'position', 'kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackd2ff6bde64aba3d6d9e0ef81fb505b85)) { $__slotsd2ff6bde64aba3d6d9e0ef81fb505b85 = array_pop($__slotsStackd2ff6bde64aba3d6d9e0ef81fb505b85); } ?>
<?php if (! empty($__attrsStackd2ff6bde64aba3d6d9e0ef81fb505b85)) { $__attrsd2ff6bde64aba3d6d9e0ef81fb505b85 = array_pop($__attrsStackd2ff6bde64aba3d6d9e0ef81fb505b85); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH D:\laragon\www\siix-portal-new\vendor\livewire\flux\stubs\resources\views\flux\with-tooltip.blade.php ENDPATH**/ ?>