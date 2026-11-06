<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__4a31c272ce32309bbdae7b7b51c0fca9')):
function __4a31c272ce32309bbdae7b7b51c0fca9($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = new \Livewire\Blaze\Runtime\BlazeAttributeBag($__attributes);
$__delegateData = $__data;
unset($__data, $__attributes);
ob_start();
?>


<?php
$__defaults = [
    'variant' => 'default',
];
$variant ??= $attributes['variant'] ?? $__defaults['variant']; unset($attributes['variant']);
unset($__defaults);
?>

<?php if (!function_exists('__cc94b751a6dbee3c6cddb4c1c630c48a')) { require $__blaze->compile('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-field.blade.php'); } ?>
<?php if (isset($__slotscc94b751a6dbee3c6cddb4c1c630c48a)) { $__slotsStackcc94b751a6dbee3c6cddb4c1c630c48a[] = $__slotscc94b751a6dbee3c6cddb4c1c630c48a; } ?>
<?php if (isset($__datacc94b751a6dbee3c6cddb4c1c630c48a)) { $__dataStackcc94b751a6dbee3c6cddb4c1c630c48a[] = $__datacc94b751a6dbee3c6cddb4c1c630c48a; } ?>
<?php $__datacc94b751a6dbee3c6cddb4c1c630c48a = ['attributes' => $attributes]; ?>
<?php $__slotscc94b751a6dbee3c6cddb4c1c630c48a = []; ?>
<?php $__blaze->pushData($__datacc94b751a6dbee3c6cddb4c1c630c48a); ?>
<?php ob_start(); ?>
    <?php $__resolved = $__blaze->resolve('flux::' . 'select.variants.' . $variant); ?>
<?php $__delegatedData = $__delegateData ?? $__env->getCurrentComponentData(); ?>
<?php $__blaze->pushData($__delegatedData); ?>
<?php if ($__resolved !== false): ?>
<?php if (isset($__slots36bf7ef62a00d88c61ddb9dfe7bccb3a)) { $__slotsStack36bf7ef62a00d88c61ddb9dfe7bccb3a[] = $__slots36bf7ef62a00d88c61ddb9dfe7bccb3a; } ?>
<?php $__slots36bf7ef62a00d88c61ddb9dfe7bccb3a = []; ?>
<?php ob_start(); ?><?php echo e($slot); ?><?php $__slots36bf7ef62a00d88c61ddb9dfe7bccb3a['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__slots36bf7ef62a00d88c61ddb9dfe7bccb3a = array_merge($__blaze->mergedComponentSlots(), $__slots36bf7ef62a00d88c61ddb9dfe7bccb3a); ?>
<?php ('__' . $__resolved)($__blaze, $__delegatedData, $attributes->getAttributes(), $__slots36bf7ef62a00d88c61ddb9dfe7bccb3a, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack36bf7ef62a00d88c61ddb9dfe7bccb3a)) { $__slots36bf7ef62a00d88c61ddb9dfe7bccb3a = array_pop($__slotsStack36bf7ef62a00d88c61ddb9dfe7bccb3a); } ?>
<?php else: ?>
<?php if (! Flux::componentExists(('select.variants.' . $variant))) throw new \Exception('Flux component [' . ('select.variants.' . $variant) . '] does not exist.'); ?>
<?php if (isset($component)) { $__componentOriginal3fe7d856302add181cc5f4e55d7285f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fe7d856302add181cc5f4e55d7285f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => (app()->version() >= 12 ? hash('xxh128', 'flux') : md5('flux')) . '::' . ('select.variants.' . $variant), 'data' => array_merge($__delegatedData, $__blaze->mergedComponentSlots())] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::' . ('select.variants.' . $variant)); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes($attributes->getAttributes()); ?>
<?php echo e($slot); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fe7d856302add181cc5f4e55d7285f6)): ?>
<?php $attributes = $__attributesOriginal3fe7d856302add181cc5f4e55d7285f6; ?>
<?php unset($__attributesOriginal3fe7d856302add181cc5f4e55d7285f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fe7d856302add181cc5f4e55d7285f6)): ?>
<?php $component = $__componentOriginal3fe7d856302add181cc5f4e55d7285f6; ?>
<?php unset($__componentOriginal3fe7d856302add181cc5f4e55d7285f6); ?>
<?php endif; ?>
<?php endif; ?>
<?php $__blaze->popData(); ?>
<?php unset($__resolved, $__delegatedData) ?>
<?php $__slotscc94b751a6dbee3c6cddb4c1c630c48a['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotscc94b751a6dbee3c6cddb4c1c630c48a); ?>
<?php __cc94b751a6dbee3c6cddb4c1c630c48a($__blaze, $__datacc94b751a6dbee3c6cddb4c1c630c48a, $__blaze->mergeAttributes(['attributes' => $__datacc94b751a6dbee3c6cddb4c1c630c48a['attributes']]), $__slotscc94b751a6dbee3c6cddb4c1c630c48a, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackcc94b751a6dbee3c6cddb4c1c630c48a)) { $__slotscc94b751a6dbee3c6cddb4c1c630c48a = array_pop($__slotsStackcc94b751a6dbee3c6cddb4c1c630c48a); } ?>
<?php if (! empty($__dataStackcc94b751a6dbee3c6cddb4c1c630c48a)) { $__datacc94b751a6dbee3c6cddb4c1c630c48a = array_pop($__dataStackcc94b751a6dbee3c6cddb4c1c630c48a); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/select/index.blade.php ENDPATH**/ ?>