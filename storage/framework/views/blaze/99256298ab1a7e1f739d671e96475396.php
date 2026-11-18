<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__bd7b9b525ee6f95180f47d7ffad5be47')):
function __bd7b9b525ee6f95180f47d7ffad5be47($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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
$__awareDefaults = [ 'variant', 'indicator' ];
$variant = $__blaze->getConsumableData('variant');
$indicator = $__blaze->getConsumableData('indicator');
unset($__awareDefaults);
?>

<?php
$__defaults = [
    'variant' => 'default',
];
$variant ??= $attributes['variant'] ?? $__defaults['variant']; unset($attributes['variant']);
unset($__defaults);
?>

<?php
// This prevents variants picked up by `@aware()` from other wrapping components like flux::modal from being used here...
$variant = $variant !== 'default' && Flux::componentExists('select.variants.' . $variant)
    ? 'custom'
    : 'default';
?>

<?php $__resolved = $__blaze->resolve('flux::' . 'select.option.variants.' . $variant); ?>
<?php $__delegatedData = $__delegateData ?? $__env->getCurrentComponentData(); ?>
<?php $__blaze->pushData($__delegatedData); ?>
<?php if ($__resolved !== false): ?>
<?php if (isset($__slotsebc292d5aa182ed9e88acc56fcd01d76)) { $__slotsStackebc292d5aa182ed9e88acc56fcd01d76[] = $__slotsebc292d5aa182ed9e88acc56fcd01d76; } ?>
<?php $__slotsebc292d5aa182ed9e88acc56fcd01d76 = []; ?>
<?php ob_start(); ?><?php echo e($slot); ?><?php $__slotsebc292d5aa182ed9e88acc56fcd01d76['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__slotsebc292d5aa182ed9e88acc56fcd01d76 = array_merge($__blaze->mergedComponentSlots(), $__slotsebc292d5aa182ed9e88acc56fcd01d76); ?>
<?php ('__' . $__resolved)($__blaze, $__delegatedData, $attributes->getAttributes(), $__slotsebc292d5aa182ed9e88acc56fcd01d76, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackebc292d5aa182ed9e88acc56fcd01d76)) { $__slotsebc292d5aa182ed9e88acc56fcd01d76 = array_pop($__slotsStackebc292d5aa182ed9e88acc56fcd01d76); } ?>
<?php else: ?>
<?php if (! Flux::componentExists(('select.option.variants.' . $variant))) throw new \Exception('Flux component [' . ('select.option.variants.' . $variant) . '] does not exist.'); ?>
<?php if (isset($component)) { $__componentOriginal7b652cb3474c4d116ae68e3f703c1d27 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b652cb3474c4d116ae68e3f703c1d27 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => (app()->version() >= 12 ? hash('xxh128', 'flux') : md5('flux')) . '::' . ('select.option.variants.' . $variant), 'data' => array_merge($__delegatedData, $__blaze->mergedComponentSlots())] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::' . ('select.option.variants.' . $variant)); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes($attributes->getAttributes()); ?>
<?php echo e($slot); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7b652cb3474c4d116ae68e3f703c1d27)): ?>
<?php $attributes = $__attributesOriginal7b652cb3474c4d116ae68e3f703c1d27; ?>
<?php unset($__attributesOriginal7b652cb3474c4d116ae68e3f703c1d27); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7b652cb3474c4d116ae68e3f703c1d27)): ?>
<?php $component = $__componentOriginal7b652cb3474c4d116ae68e3f703c1d27; ?>
<?php unset($__componentOriginal7b652cb3474c4d116ae68e3f703c1d27); ?>
<?php endif; ?>
<?php endif; ?>
<?php $__blaze->popData(); ?>
<?php unset($__resolved, $__delegatedData) ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/select/option/index.blade.php ENDPATH**/ ?>