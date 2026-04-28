<?php
if (!function_exists('__8836b0a78dcf7209d2efc885986e03bc')):
function __8836b0a78dcf7209d2efc885986e03bc($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
<?php $__attrsfad05d57e1e0bf8b6251725acbf0d97e = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputViewable','xOn:click' => 'toggle()','xBind:dataViewableOpen' => 'open','ariaLabel' => e(__('Toggle password visibility'))]; ?>
<?php $__slotsfad05d57e1e0bf8b6251725acbf0d97e = []; ?>
<?php $__blaze->pushData($__attrsfad05d57e1e0bf8b6251725acbf0d97e); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/eye-slash.blade.php', $__blaze->compiledPath.'/6eb5c352a3139fe93e430343cb7c7475.php'); ?>
<?php $__blaze->pushData(['variant' => 'micro','class' => 'hidden [[data-viewable-open]>&]:block']); ?>
<?php __6eb5c352a3139fe93e430343cb7c7475($__blaze, ['variant' => 'micro','class' => 'hidden [[data-viewable-open]>&]:block'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/eye.blade.php', $__blaze->compiledPath.'/13cc876a022045b078d1f368572d4211.php'); ?>
<?php $__blaze->pushData(['variant' => 'micro','class' => 'block [[data-viewable-open]>&]:hidden']); ?>
<?php __13cc876a022045b078d1f368572d4211($__blaze, ['variant' => 'micro','class' => 'block [[data-viewable-open]>&]:hidden'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php $__slotsfad05d57e1e0bf8b6251725acbf0d97e['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsfad05d57e1e0bf8b6251725acbf0d97e); ?>
<?php __fad05d57e1e0bf8b6251725acbf0d97e($__blaze, $__attrsfad05d57e1e0bf8b6251725acbf0d97e, $__slotsfad05d57e1e0bf8b6251725acbf0d97e, ['attributes', 'size'], ['xData' => 'x-data', 'xOn:click' => 'x-on:click', 'xBind:dataViewableOpen' => 'x-bind:data-viewable-open', 'ariaLabel' => 'aria-label'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackfad05d57e1e0bf8b6251725acbf0d97e)) { $__slotsfad05d57e1e0bf8b6251725acbf0d97e = array_pop($__slotsStackfad05d57e1e0bf8b6251725acbf0d97e); } ?>
<?php if (! empty($__attrsStackfad05d57e1e0bf8b6251725acbf0d97e)) { $__attrsfad05d57e1e0bf8b6251725acbf0d97e = array_pop($__attrsStackfad05d57e1e0bf8b6251725acbf0d97e); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/viewable.blade.php ENDPATH**/ ?>