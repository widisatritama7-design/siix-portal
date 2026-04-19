<?php
if (!function_exists('__f2f6a304c2bfa4cf9ca6fd65e1a07f8f')):
function __f2f6a304c2bfa4cf9ca6fd65e1a07f8f($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
$__defaults = [
    'variant' => 'default',
];
$variant ??= $attributes['variant'] ?? $__defaults['variant']; unset($attributes['variant']);
unset($__defaults);
?>

<?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php', $__blaze->compiledPath.'/3ea4ef29ff9bf752f3c8d65709c692b6.php'); ?>
<?php if (isset($__slots3ea4ef29ff9bf752f3c8d65709c692b6)) { $__slotsStack3ea4ef29ff9bf752f3c8d65709c692b6[] = $__slots3ea4ef29ff9bf752f3c8d65709c692b6; } ?>
<?php if (isset($__attrs3ea4ef29ff9bf752f3c8d65709c692b6)) { $__attrsStack3ea4ef29ff9bf752f3c8d65709c692b6[] = $__attrs3ea4ef29ff9bf752f3c8d65709c692b6; } ?>
<?php $__attrs3ea4ef29ff9bf752f3c8d65709c692b6 = ['attributes' => $attributes]; ?>
<?php $__slots3ea4ef29ff9bf752f3c8d65709c692b6 = []; ?>
<?php $__blaze->pushData($__attrs3ea4ef29ff9bf752f3c8d65709c692b6); ?>
<?php ob_start(); ?>
    <?php $__resolved = $__blaze->resolve('flux::' . 'select.variants.' . $variant); ?>
<?php $__blaze->pushData($attributes->all()); ?>
<?php if ($__resolved !== false): ?>
<?php if (isset($__slots69582dab5bc3a9ae88ecab505c992993)) { $__slotsStack69582dab5bc3a9ae88ecab505c992993[] = $__slots69582dab5bc3a9ae88ecab505c992993; } ?>
<?php $__slots69582dab5bc3a9ae88ecab505c992993 = []; ?>
<?php ob_start(); ?><?php echo e($slot); ?><?php $__slots69582dab5bc3a9ae88ecab505c992993['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__slots69582dab5bc3a9ae88ecab505c992993 = array_merge($__blaze->mergedComponentSlots(), $__slots69582dab5bc3a9ae88ecab505c992993); ?>
<?php ('__' . $__resolved)($__blaze, $attributes->all(), $__slots69582dab5bc3a9ae88ecab505c992993, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack69582dab5bc3a9ae88ecab505c992993)) { $__slots69582dab5bc3a9ae88ecab505c992993 = array_pop($__slotsStack69582dab5bc3a9ae88ecab505c992993); } ?>
<?php else: ?>
<?php if (!Flux::componentExists($name = 'select.variants.' . $variant)) throw new \Exception("Flux component [{$name}] does not exist."); ?><?php if (isset($component)) { $__componentOriginal08070e8b41d4df2d7ae8c552da62ae57 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal08070e8b41d4df2d7ae8c552da62ae57 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve([
    'view' => (app()->version() >= 12 ? hash('xxh128', 'flux') : md5('flux')) . '::' . 'select.variants.' . $variant,
    'data' => $__env->getCurrentComponentData(),
] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::' . 'select.variants.' . $variant); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes($attributes->getAttributes()); ?><?php echo e($slot); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal08070e8b41d4df2d7ae8c552da62ae57)): ?>
<?php $attributes = $__attributesOriginal08070e8b41d4df2d7ae8c552da62ae57; ?>
<?php unset($__attributesOriginal08070e8b41d4df2d7ae8c552da62ae57); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal08070e8b41d4df2d7ae8c552da62ae57)): ?>
<?php $component = $__componentOriginal08070e8b41d4df2d7ae8c552da62ae57; ?>
<?php unset($__componentOriginal08070e8b41d4df2d7ae8c552da62ae57); ?>
<?php endif; ?>
<?php endif; ?>
<?php $__blaze->popData(); ?>
<?php unset($__resolved) ?>
<?php $__slots3ea4ef29ff9bf752f3c8d65709c692b6['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots3ea4ef29ff9bf752f3c8d65709c692b6); ?>
<?php __3ea4ef29ff9bf752f3c8d65709c692b6($__blaze, $__attrs3ea4ef29ff9bf752f3c8d65709c692b6, $__slots3ea4ef29ff9bf752f3c8d65709c692b6, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3ea4ef29ff9bf752f3c8d65709c692b6)) { $__slots3ea4ef29ff9bf752f3c8d65709c692b6 = array_pop($__slotsStack3ea4ef29ff9bf752f3c8d65709c692b6); } ?>
<?php if (! empty($__attrsStack3ea4ef29ff9bf752f3c8d65709c692b6)) { $__attrs3ea4ef29ff9bf752f3c8d65709c692b6 = array_pop($__attrsStack3ea4ef29ff9bf752f3c8d65709c692b6); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/select/index.blade.php ENDPATH**/ ?>