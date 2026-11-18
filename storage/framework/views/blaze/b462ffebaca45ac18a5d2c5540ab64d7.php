<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__caa10bc52c9eb85f4482845064487b60')):
function __caa10bc52c9eb85f4482845064487b60($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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
    'icon' => null,
    'name' => null,
];
$icon ??= $attributes['icon'] ?? $__defaults['icon']; unset($attributes['icon']);
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
unset($__defaults);
?>

<?php
$icon = $name ?? $icon;
?>

<?php $__resolved = $__blaze->resolve('flux::' . 'icon.' . $icon); ?>
<?php $__delegatedData = $__delegateData ?? $__env->getCurrentComponentData(); ?>
<?php $__blaze->pushData($__delegatedData); ?>
<?php if ($__resolved !== false): ?>
<?php if (isset($__slotsf8b5bcac94115f315ed8aeeaaae9bb9e)) { $__slotsStackf8b5bcac94115f315ed8aeeaaae9bb9e[] = $__slotsf8b5bcac94115f315ed8aeeaaae9bb9e; } ?>
<?php $__slotsf8b5bcac94115f315ed8aeeaaae9bb9e = []; ?>
<?php ob_start(); ?><?php echo e($slot); ?><?php $__slotsf8b5bcac94115f315ed8aeeaaae9bb9e['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__slotsf8b5bcac94115f315ed8aeeaaae9bb9e = array_merge($__blaze->mergedComponentSlots(), $__slotsf8b5bcac94115f315ed8aeeaaae9bb9e); ?>
<?php ('__' . $__resolved)($__blaze, $__delegatedData, $attributes->getAttributes(), $__slotsf8b5bcac94115f315ed8aeeaaae9bb9e, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackf8b5bcac94115f315ed8aeeaaae9bb9e)) { $__slotsf8b5bcac94115f315ed8aeeaaae9bb9e = array_pop($__slotsStackf8b5bcac94115f315ed8aeeaaae9bb9e); } ?>
<?php else: ?>
<?php if (! Flux::componentExists(('icon.' . $icon))) throw new \Exception('Flux component [' . ('icon.' . $icon) . '] does not exist.'); ?>
<?php if (isset($component)) { $__componentOriginal4a2e3c465a7b684563d9033459cc86c8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4a2e3c465a7b684563d9033459cc86c8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => (app()->version() >= 12 ? hash('xxh128', 'flux') : md5('flux')) . '::' . ('icon.' . $icon), 'data' => array_merge($__delegatedData, $__blaze->mergedComponentSlots())] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::' . ('icon.' . $icon)); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes($attributes->getAttributes()); ?>
<?php echo e($slot); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4a2e3c465a7b684563d9033459cc86c8)): ?>
<?php $attributes = $__attributesOriginal4a2e3c465a7b684563d9033459cc86c8; ?>
<?php unset($__attributesOriginal4a2e3c465a7b684563d9033459cc86c8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4a2e3c465a7b684563d9033459cc86c8)): ?>
<?php $component = $__componentOriginal4a2e3c465a7b684563d9033459cc86c8; ?>
<?php unset($__componentOriginal4a2e3c465a7b684563d9033459cc86c8); ?>
<?php endif; ?>
<?php endif; ?>
<?php $__blaze->popData(); ?>
<?php unset($__resolved, $__delegatedData) ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php ENDPATH**/ ?>