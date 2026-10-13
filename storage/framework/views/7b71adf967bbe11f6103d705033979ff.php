<?php
if (!function_exists('_7b71adf967bbe11f6103d705033979ff')):
function _7b71adf967bbe11f6103d705033979ff($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-container.blade.php', $__blaze->compiledPath.'/af333723a9a33532eb819bd480955bd5.php'); ?>
<?php if (isset($__slotsaf333723a9a33532eb819bd480955bd5)) { $__slotsStackaf333723a9a33532eb819bd480955bd5[] = $__slotsaf333723a9a33532eb819bd480955bd5; } ?>
<?php if (isset($__attrsaf333723a9a33532eb819bd480955bd5)) { $__attrsStackaf333723a9a33532eb819bd480955bd5[] = $__attrsaf333723a9a33532eb819bd480955bd5; } ?>
<?php $__attrsaf333723a9a33532eb819bd480955bd5 = ['attributes' => $attributes->except('class')->class('p-6 lg:p-8')]; ?>
<?php $__slotsaf333723a9a33532eb819bd480955bd5 = []; ?>
<?php $__blaze->pushData($__attrsaf333723a9a33532eb819bd480955bd5); ?>
<?php ob_start(); ?>
        <?php echo e($slot); ?>

    <?php $__slotsaf333723a9a33532eb819bd480955bd5['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsaf333723a9a33532eb819bd480955bd5); ?>
<?php _af333723a9a33532eb819bd480955bd5($__blaze, $__attrsaf333723a9a33532eb819bd480955bd5, $__slotsaf333723a9a33532eb819bd480955bd5, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackaf333723a9a33532eb819bd480955bd5)) { $__slotsaf333723a9a33532eb819bd480955bd5 = array_pop($__slotsStackaf333723a9a33532eb819bd480955bd5); } ?>
<?php if (! empty($__attrsStackaf333723a9a33532eb819bd480955bd5)) { $__attrsaf333723a9a33532eb819bd480955bd5 = array_pop($__attrsStackaf333723a9a33532eb819bd480955bd5); } ?>
<?php $__blaze->popData(); ?>
</div>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/stubs/resources/views/flux/footer.blade.php ENDPATH**/ ?>