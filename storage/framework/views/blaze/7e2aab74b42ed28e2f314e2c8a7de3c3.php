<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__428d2f32fca4cd25dd07501656d042cf')):
function __428d2f32fca4cd25dd07501656d042cf($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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
    <?php if (!function_exists('__edbc28068c97e5617f606f8737fd7ebb')) { require $__blaze->compile('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/index.blade.php'); } ?>
<?php if (isset($__slotsedbc28068c97e5617f606f8737fd7ebb)) { $__slotsStackedbc28068c97e5617f606f8737fd7ebb[] = $__slotsedbc28068c97e5617f606f8737fd7ebb; } ?>
<?php if (isset($__dataedbc28068c97e5617f606f8737fd7ebb)) { $__dataStackedbc28068c97e5617f606f8737fd7ebb[] = $__dataedbc28068c97e5617f606f8737fd7ebb; } ?>
<?php $__dataedbc28068c97e5617f606f8737fd7ebb = ['class' => 'inline-flex','content' => $tooltip,'position' => $tooltipPosition,'kbd' => $tooltipKbd]; ?>
<?php $__slotsedbc28068c97e5617f606f8737fd7ebb = []; ?>
<?php $__blaze->pushData($__dataedbc28068c97e5617f606f8737fd7ebb); ?>
<?php ob_start(); ?>
        <?php echo e($slot); ?>

    <?php $__slotsedbc28068c97e5617f606f8737fd7ebb['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsedbc28068c97e5617f606f8737fd7ebb); ?>
<?php __edbc28068c97e5617f606f8737fd7ebb($__blaze, $__dataedbc28068c97e5617f606f8737fd7ebb, ['class' => 'inline-flex', 'content' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__dataedbc28068c97e5617f606f8737fd7ebb['content']), 'position' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__dataedbc28068c97e5617f606f8737fd7ebb['position']), 'kbd' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__dataedbc28068c97e5617f606f8737fd7ebb['kbd'])], $__slotsedbc28068c97e5617f606f8737fd7ebb, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackedbc28068c97e5617f606f8737fd7ebb)) { $__slotsedbc28068c97e5617f606f8737fd7ebb = array_pop($__slotsStackedbc28068c97e5617f606f8737fd7ebb); } ?>
<?php if (! empty($__dataStackedbc28068c97e5617f606f8737fd7ebb)) { $__dataedbc28068c97e5617f606f8737fd7ebb = array_pop($__dataStackedbc28068c97e5617f606f8737fd7ebb); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-tooltip.blade.php ENDPATH**/ ?>