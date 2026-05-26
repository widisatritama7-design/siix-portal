<?php
if (!function_exists('_87775e599258f1b45199278f831c6ce0')):
function _87775e599258f1b45199278f831c6ce0($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    'class' => '-me-1',
    'square' => true,
    'size' => null,
]);
?>

<?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php', $__blaze->compiledPath.'/fad05d57e1e0bf8b6251725acbf0d97e.php'); ?>
<?php if (isset($__slotsfad05d57e1e0bf8b6251725acbf0d97e)) { $__slotsStackfad05d57e1e0bf8b6251725acbf0d97e[] = $__slotsfad05d57e1e0bf8b6251725acbf0d97e; } ?>
<?php if (isset($__attrsfad05d57e1e0bf8b6251725acbf0d97e)) { $__attrsStackfad05d57e1e0bf8b6251725acbf0d97e[] = $__attrsfad05d57e1e0bf8b6251725acbf0d97e; } ?>
<?php $__attrsfad05d57e1e0bf8b6251725acbf0d97e = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputCopyable','xOn:click' => 'copy()','xBind:dataCopyableCopied' => 'copied','ariaLabel' => e(__('Copy to clipboard'))]; ?>
<?php $__slotsfad05d57e1e0bf8b6251725acbf0d97e = []; ?>
<?php $__blaze->pushData($__attrsfad05d57e1e0bf8b6251725acbf0d97e); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/clipboard-document-check.blade.php', $__blaze->compiledPath.'/c7435bb7bddc47f0daa4393fffa86e31.php'); ?>
<?php $__blaze->pushData(['variant' => $iconVariant,'class' => 'hidden [[data-copyable-copied]>&]:block']); ?>
<?php _c7435bb7bddc47f0daa4393fffa86e31($__blaze, ['variant' => $iconVariant,'class' => 'hidden [[data-copyable-copied]>&]:block'], [], ['variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/clipboard-document.blade.php', $__blaze->compiledPath.'/a5e11c37a91f2427c70b0ad2b4c61073.php'); ?>
<?php $__blaze->pushData(['variant' => $iconVariant,'class' => 'block [[data-copyable-copied]>&]:hidden']); ?>
<?php _a5e11c37a91f2427c70b0ad2b4c61073($__blaze, ['variant' => $iconVariant,'class' => 'block [[data-copyable-copied]>&]:hidden'], [], ['variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slotsfad05d57e1e0bf8b6251725acbf0d97e['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsfad05d57e1e0bf8b6251725acbf0d97e); ?>
<?php _fad05d57e1e0bf8b6251725acbf0d97e($__blaze, $__attrsfad05d57e1e0bf8b6251725acbf0d97e, $__slotsfad05d57e1e0bf8b6251725acbf0d97e, ['attributes', 'size'], ['xData' => 'x-data', 'xOn:click' => 'x-on:click', 'xBind:dataCopyableCopied' => 'x-bind:data-copyable-copied', 'ariaLabel' => 'aria-label'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackfad05d57e1e0bf8b6251725acbf0d97e)) { $__slotsfad05d57e1e0bf8b6251725acbf0d97e = array_pop($__slotsStackfad05d57e1e0bf8b6251725acbf0d97e); } ?>
<?php if (! empty($__attrsStackfad05d57e1e0bf8b6251725acbf0d97e)) { $__attrsfad05d57e1e0bf8b6251725acbf0d97e = array_pop($__attrsStackfad05d57e1e0bf8b6251725acbf0d97e); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/stubs/resources/views/flux/input/copyable.blade.php ENDPATH**/ ?>