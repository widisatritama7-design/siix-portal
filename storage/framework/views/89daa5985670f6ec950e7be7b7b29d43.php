<?php
if (!function_exists('_89daa5985670f6ec950e7be7b7b29d43')):
function _89daa5985670f6ec950e7be7b7b29d43($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/with-container.blade.php', $__blaze->compiledPath.'/a7bf96a6d77f4c2500c88b234d67c423.php'); ?>
<?php if (isset($__slotsa7bf96a6d77f4c2500c88b234d67c423)) { $__slotsStacka7bf96a6d77f4c2500c88b234d67c423[] = $__slotsa7bf96a6d77f4c2500c88b234d67c423; } ?>
<?php if (isset($__attrsa7bf96a6d77f4c2500c88b234d67c423)) { $__attrsStacka7bf96a6d77f4c2500c88b234d67c423[] = $__attrsa7bf96a6d77f4c2500c88b234d67c423; } ?>
<?php $__attrsa7bf96a6d77f4c2500c88b234d67c423 = ['attributes' => $attributes->except('class')->class('p-6 lg:p-8')]; ?>
<?php $__slotsa7bf96a6d77f4c2500c88b234d67c423 = []; ?>
<?php $__blaze->pushData($__attrsa7bf96a6d77f4c2500c88b234d67c423); ?>
<?php ob_start(); ?>
        <?php echo e($slot); ?>

    <?php $__slotsa7bf96a6d77f4c2500c88b234d67c423['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsa7bf96a6d77f4c2500c88b234d67c423); ?>
<?php _a7bf96a6d77f4c2500c88b234d67c423($__blaze, $__attrsa7bf96a6d77f4c2500c88b234d67c423, $__slotsa7bf96a6d77f4c2500c88b234d67c423, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacka7bf96a6d77f4c2500c88b234d67c423)) { $__slotsa7bf96a6d77f4c2500c88b234d67c423 = array_pop($__slotsStacka7bf96a6d77f4c2500c88b234d67c423); } ?>
<?php if (! empty($__attrsStacka7bf96a6d77f4c2500c88b234d67c423)) { $__attrsa7bf96a6d77f4c2500c88b234d67c423 = array_pop($__attrsStacka7bf96a6d77f4c2500c88b234d67c423); } ?>
<?php $__blaze->popData(); ?>
</div>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\stubs\resources\views\flux\footer.blade.php ENDPATH**/ ?>