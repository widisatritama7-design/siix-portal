<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__dcaa7d49c97f4816e18375c175bec83a')):
function __dcaa7d49c97f4816e18375c175bec83a($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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
    <?php if (!function_exists('__5961450e49b0ec8ad12f26dc1b23916e')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/index.blade.php'); } ?>
<?php if (isset($__slots5961450e49b0ec8ad12f26dc1b23916e)) { $__slotsStack5961450e49b0ec8ad12f26dc1b23916e[] = $__slots5961450e49b0ec8ad12f26dc1b23916e; } ?>
<?php if (isset($__data5961450e49b0ec8ad12f26dc1b23916e)) { $__dataStack5961450e49b0ec8ad12f26dc1b23916e[] = $__data5961450e49b0ec8ad12f26dc1b23916e; } ?>
<?php $__data5961450e49b0ec8ad12f26dc1b23916e = ['class' => 'inline-flex','content' => $tooltip,'position' => $tooltipPosition,'kbd' => $tooltipKbd]; ?>
<?php $__slots5961450e49b0ec8ad12f26dc1b23916e = []; ?>
<?php $__blaze->pushData($__data5961450e49b0ec8ad12f26dc1b23916e); ?>
<?php ob_start(); ?>
        <?php echo e($slot); ?>

    <?php $__slots5961450e49b0ec8ad12f26dc1b23916e['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots5961450e49b0ec8ad12f26dc1b23916e); ?>
<?php __5961450e49b0ec8ad12f26dc1b23916e($__blaze, $__data5961450e49b0ec8ad12f26dc1b23916e, ['class' => 'inline-flex', 'content' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__data5961450e49b0ec8ad12f26dc1b23916e['content']), 'position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__data5961450e49b0ec8ad12f26dc1b23916e['position']), 'kbd' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__data5961450e49b0ec8ad12f26dc1b23916e['kbd'])], $__slots5961450e49b0ec8ad12f26dc1b23916e, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack5961450e49b0ec8ad12f26dc1b23916e)) { $__slots5961450e49b0ec8ad12f26dc1b23916e = array_pop($__slotsStack5961450e49b0ec8ad12f26dc1b23916e); } ?>
<?php if (! empty($__dataStack5961450e49b0ec8ad12f26dc1b23916e)) { $__data5961450e49b0ec8ad12f26dc1b23916e = array_pop($__dataStack5961450e49b0ec8ad12f26dc1b23916e); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-tooltip.blade.php ENDPATH**/ ?>