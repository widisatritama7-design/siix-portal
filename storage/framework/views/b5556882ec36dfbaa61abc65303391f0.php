<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('_e0202878130fba047e1e5aa9e31f48f8')):
function _e0202878130fba047e1e5aa9e31f48f8($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = new \Livewire\Blaze\Runtime\BlazeAttributeBag($__attributes);
unset($__data, $__attributes);
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
    <?php if (!function_exists('_b78bba45b37958662e2e8e6c1905059e')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/index.blade.php'); } ?>
<?php if (isset($__slotsb78bba45b37958662e2e8e6c1905059e)) { $__slotsStackb78bba45b37958662e2e8e6c1905059e[] = $__slotsb78bba45b37958662e2e8e6c1905059e; } ?>
<?php if (isset($__datab78bba45b37958662e2e8e6c1905059e)) { $__dataStackb78bba45b37958662e2e8e6c1905059e[] = $__datab78bba45b37958662e2e8e6c1905059e; } ?>
<?php $__datab78bba45b37958662e2e8e6c1905059e = ['class' => 'inline-flex','content' => $tooltip,'position' => $tooltipPosition,'kbd' => $tooltipKbd]; ?>
<?php $__slotsb78bba45b37958662e2e8e6c1905059e = []; ?>
<?php $__blaze->pushData($__datab78bba45b37958662e2e8e6c1905059e); ?>
<?php ob_start(); ?>
        <?php echo e($slot); ?>

    <?php $__slotsb78bba45b37958662e2e8e6c1905059e['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsb78bba45b37958662e2e8e6c1905059e); ?>
<?php _b78bba45b37958662e2e8e6c1905059e($__blaze, $__datab78bba45b37958662e2e8e6c1905059e, ['class' => 'inline-flex', 'content' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__datab78bba45b37958662e2e8e6c1905059e['content']), 'position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__datab78bba45b37958662e2e8e6c1905059e['position']), 'kbd' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__datab78bba45b37958662e2e8e6c1905059e['kbd'])], $__slotsb78bba45b37958662e2e8e6c1905059e, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackb78bba45b37958662e2e8e6c1905059e)) { $__slotsb78bba45b37958662e2e8e6c1905059e = array_pop($__slotsStackb78bba45b37958662e2e8e6c1905059e); } ?>
<?php if (! empty($__dataStackb78bba45b37958662e2e8e6c1905059e)) { $__datab78bba45b37958662e2e8e6c1905059e = array_pop($__dataStackb78bba45b37958662e2e8e6c1905059e); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/with-tooltip.blade.php ENDPATH**/ ?>