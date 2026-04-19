<?php
if (!function_exists('_e95d7aceacb63a49597d446776ee95a6')):
function _e95d7aceacb63a49597d446776ee95a6($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
$classes = Flux::classes('[grid-area:footer]')
    ->add($attributes->has('container') ? '' : 'p-6 lg:p-8')
    ;
?>

<div <?php echo e($attributes->class($classes)); ?> data-flux-footer>
    <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/with-container.blade.php', $__blaze->compiledPath.'/2370edfe201e7a9d2846b008772e54dc.php'); ?>
<?php if (isset($__slots2370edfe201e7a9d2846b008772e54dc)) { $__slotsStack2370edfe201e7a9d2846b008772e54dc[] = $__slots2370edfe201e7a9d2846b008772e54dc; } ?>
<?php if (isset($__attrs2370edfe201e7a9d2846b008772e54dc)) { $__attrsStack2370edfe201e7a9d2846b008772e54dc[] = $__attrs2370edfe201e7a9d2846b008772e54dc; } ?>
<?php $__attrs2370edfe201e7a9d2846b008772e54dc = ['attributes' => $attributes->except('class')->class('p-6 lg:p-8')]; ?>
<?php $__slots2370edfe201e7a9d2846b008772e54dc = []; ?>
<?php $__blaze->pushData($__attrs2370edfe201e7a9d2846b008772e54dc); ?>
<?php ob_start(); ?>
        <?php echo e($slot); ?>

    <?php $__slots2370edfe201e7a9d2846b008772e54dc['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots2370edfe201e7a9d2846b008772e54dc); ?>
<?php _2370edfe201e7a9d2846b008772e54dc($__blaze, $__attrs2370edfe201e7a9d2846b008772e54dc, $__slots2370edfe201e7a9d2846b008772e54dc, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack2370edfe201e7a9d2846b008772e54dc)) { $__slots2370edfe201e7a9d2846b008772e54dc = array_pop($__slotsStack2370edfe201e7a9d2846b008772e54dc); } ?>
<?php if (! empty($__attrsStack2370edfe201e7a9d2846b008772e54dc)) { $__attrs2370edfe201e7a9d2846b008772e54dc = array_pop($__attrsStack2370edfe201e7a9d2846b008772e54dc); } ?>
<?php $__blaze->popData(); ?>
</div>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH D:\laragon\www\siix-portal-new\vendor\livewire\flux\stubs\resources\views\flux\footer.blade.php ENDPATH**/ ?>