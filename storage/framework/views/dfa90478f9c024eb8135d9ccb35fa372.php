<?php
if (!function_exists('_dfa90478f9c024eb8135d9ccb35fa372')):
function _dfa90478f9c024eb8135d9ccb35fa372($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-container.blade.php', $__blaze->compiledPath.'/c12189e487a310788b1c42827ad0c306.php'); ?>
<?php if (isset($__slotsc12189e487a310788b1c42827ad0c306)) { $__slotsStackc12189e487a310788b1c42827ad0c306[] = $__slotsc12189e487a310788b1c42827ad0c306; } ?>
<?php if (isset($__attrsc12189e487a310788b1c42827ad0c306)) { $__attrsStackc12189e487a310788b1c42827ad0c306[] = $__attrsc12189e487a310788b1c42827ad0c306; } ?>
<?php $__attrsc12189e487a310788b1c42827ad0c306 = ['attributes' => $attributes->except('class')->class('p-6 lg:p-8')]; ?>
<?php $__slotsc12189e487a310788b1c42827ad0c306 = []; ?>
<?php $__blaze->pushData($__attrsc12189e487a310788b1c42827ad0c306); ?>
<?php ob_start(); ?>
        <?php echo e($slot); ?>

    <?php $__slotsc12189e487a310788b1c42827ad0c306['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsc12189e487a310788b1c42827ad0c306); ?>
<?php _c12189e487a310788b1c42827ad0c306($__blaze, $__attrsc12189e487a310788b1c42827ad0c306, $__slotsc12189e487a310788b1c42827ad0c306, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackc12189e487a310788b1c42827ad0c306)) { $__slotsc12189e487a310788b1c42827ad0c306 = array_pop($__slotsStackc12189e487a310788b1c42827ad0c306); } ?>
<?php if (! empty($__attrsStackc12189e487a310788b1c42827ad0c306)) { $__attrsc12189e487a310788b1c42827ad0c306 = array_pop($__attrsStackc12189e487a310788b1c42827ad0c306); } ?>
<?php $__blaze->popData(); ?>
</div>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/stubs/resources/views/flux/footer.blade.php ENDPATH**/ ?>