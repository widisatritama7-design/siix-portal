<?php
if (!function_exists('__b260bd87dc852a09ebe6f4d9aee73bd1')):
function __b260bd87dc852a09ebe6f4d9aee73bd1($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
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
<?php $__attrsfad05d57e1e0bf8b6251725acbf0d97e = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm']; ?>
<?php $__slotsfad05d57e1e0bf8b6251725acbf0d97e = []; ?>
<?php $__blaze->pushData($__attrsfad05d57e1e0bf8b6251725acbf0d97e); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/chevron-down.blade.php', $__blaze->compiledPath.'/37550f238c62e0c2950363a608947fe4.php'); ?>
<?php $__blaze->pushData(['variant' => 'micro']); ?>
<?php __37550f238c62e0c2950363a608947fe4($__blaze, ['variant' => 'micro'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slotsfad05d57e1e0bf8b6251725acbf0d97e['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsfad05d57e1e0bf8b6251725acbf0d97e); ?>
<?php __fad05d57e1e0bf8b6251725acbf0d97e($__blaze, $__attrsfad05d57e1e0bf8b6251725acbf0d97e, $__slotsfad05d57e1e0bf8b6251725acbf0d97e, ['attributes', 'size'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackfad05d57e1e0bf8b6251725acbf0d97e)) { $__slotsfad05d57e1e0bf8b6251725acbf0d97e = array_pop($__slotsStackfad05d57e1e0bf8b6251725acbf0d97e); } ?>
<?php if (! empty($__attrsStackfad05d57e1e0bf8b6251725acbf0d97e)) { $__attrsfad05d57e1e0bf8b6251725acbf0d97e = array_pop($__attrsStackfad05d57e1e0bf8b6251725acbf0d97e); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/expandable.blade.php ENDPATH**/ ?>