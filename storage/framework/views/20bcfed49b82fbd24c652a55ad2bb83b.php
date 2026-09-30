<?php if (isset($component)) { $__componentOriginalcf9cb6834aeebee6f8c4b3864fd97a81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf9cb6834aeebee6f8c4b3864fd97a81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::auth.card','data' => ['title' => $title ?? null]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::auth.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title ?? null)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <?php echo e($slot); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcf9cb6834aeebee6f8c4b3864fd97a81)): ?>
<?php $attributes = $__attributesOriginalcf9cb6834aeebee6f8c4b3864fd97a81; ?>
<?php unset($__attributesOriginalcf9cb6834aeebee6f8c4b3864fd97a81); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcf9cb6834aeebee6f8c4b3864fd97a81)): ?>
<?php $component = $__componentOriginalcf9cb6834aeebee6f8c4b3864fd97a81; ?>
<?php unset($__componentOriginalcf9cb6834aeebee6f8c4b3864fd97a81); ?>
<?php endif; ?>
<?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/layouts/auth.blade.php ENDPATH**/ ?>