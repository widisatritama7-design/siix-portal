<?php if (isset($component)) { $__componentOriginal23399719f391f3076fe3bf0929a84741 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23399719f391f3076fe3bf0929a84741 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::app.sidebar','data' => ['title' => $title ?? null]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::app.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title ?? null)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/main.blade.php', $__blaze->compiledPath.'/fcc30cee376c1329306a9b1f984e3bb2.php'); ?>
<?php if (isset($__slotsfcc30cee376c1329306a9b1f984e3bb2)) { $__slotsStackfcc30cee376c1329306a9b1f984e3bb2[] = $__slotsfcc30cee376c1329306a9b1f984e3bb2; } ?>
<?php if (isset($__attrsfcc30cee376c1329306a9b1f984e3bb2)) { $__attrsStackfcc30cee376c1329306a9b1f984e3bb2[] = $__attrsfcc30cee376c1329306a9b1f984e3bb2; } ?>
<?php $__attrsfcc30cee376c1329306a9b1f984e3bb2 = []; ?>
<?php $__slotsfcc30cee376c1329306a9b1f984e3bb2 = []; ?>
<?php $__blaze->pushData($__attrsfcc30cee376c1329306a9b1f984e3bb2); ?>
<?php ob_start(); ?>
        <?php echo e($slot); ?>

    <?php $__slotsfcc30cee376c1329306a9b1f984e3bb2['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsfcc30cee376c1329306a9b1f984e3bb2); ?>
<?php _fcc30cee376c1329306a9b1f984e3bb2($__blaze, $__attrsfcc30cee376c1329306a9b1f984e3bb2, $__slotsfcc30cee376c1329306a9b1f984e3bb2, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackfcc30cee376c1329306a9b1f984e3bb2)) { $__slotsfcc30cee376c1329306a9b1f984e3bb2 = array_pop($__slotsStackfcc30cee376c1329306a9b1f984e3bb2); } ?>
<?php if (! empty($__attrsStackfcc30cee376c1329306a9b1f984e3bb2)) { $__attrsfcc30cee376c1329306a9b1f984e3bb2 = array_pop($__attrsStackfcc30cee376c1329306a9b1f984e3bb2); } ?>
<?php $__blaze->popData(); ?>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23399719f391f3076fe3bf0929a84741)): ?>
<?php $attributes = $__attributesOriginal23399719f391f3076fe3bf0929a84741; ?>
<?php unset($__attributesOriginal23399719f391f3076fe3bf0929a84741); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23399719f391f3076fe3bf0929a84741)): ?>
<?php $component = $__componentOriginal23399719f391f3076fe3bf0929a84741; ?>
<?php unset($__componentOriginal23399719f391f3076fe3bf0929a84741); ?>
<?php endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/resources/views/layouts/app.blade.php ENDPATH**/ ?>