<?php
if (!function_exists('_10bbd320351457e174f8f0281ea1a5a4')):
function _10bbd320351457e174f8f0281ea1a5a4($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
$classes = Flux::classes()
    ->add('*:data-flux-field:mb-3')
    ->add('[&>[data-flux-field]:has(>[data-flux-description])]:mb-4')
    ->add('[&>[data-flux-field]:last-child]:mb-0!')
    ;

// Support adding the .self modifier to the wire:model directive...
if (($wireModel = $attributes->wire('model')) && $wireModel->directive && ! $wireModel->hasModifier('self')) {
    unset($attributes[$wireModel->directive]);

    $wireModel->directive .= '.self';

    $attributes = $attributes->merge([$wireModel->directive => $wireModel->value]);
}
?>

<?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php', $__blaze->compiledPath.'/3ea4ef29ff9bf752f3c8d65709c692b6.php'); ?>
<?php if (isset($__slots3ea4ef29ff9bf752f3c8d65709c692b6)) { $__slotsStack3ea4ef29ff9bf752f3c8d65709c692b6[] = $__slots3ea4ef29ff9bf752f3c8d65709c692b6; } ?>
<?php if (isset($__attrs3ea4ef29ff9bf752f3c8d65709c692b6)) { $__attrsStack3ea4ef29ff9bf752f3c8d65709c692b6[] = $__attrs3ea4ef29ff9bf752f3c8d65709c692b6; } ?>
<?php $__attrs3ea4ef29ff9bf752f3c8d65709c692b6 = ['attributes' => $attributes]; ?>
<?php $__slots3ea4ef29ff9bf752f3c8d65709c692b6 = []; ?>
<?php $__blaze->pushData($__attrs3ea4ef29ff9bf752f3c8d65709c692b6); ?>
<?php ob_start(); ?>
    <ui-checkbox-group <?php echo e($attributes->class($classes)); ?> data-flux-checkbox-group>
        <?php echo e($slot); ?>

    </ui-checkbox-group>
<?php $__slots3ea4ef29ff9bf752f3c8d65709c692b6['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3ea4ef29ff9bf752f3c8d65709c692b6); ?>
<?php _3ea4ef29ff9bf752f3c8d65709c692b6($__blaze, $__attrs3ea4ef29ff9bf752f3c8d65709c692b6, $__slots3ea4ef29ff9bf752f3c8d65709c692b6, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3ea4ef29ff9bf752f3c8d65709c692b6)) { $__slots3ea4ef29ff9bf752f3c8d65709c692b6 = array_pop($__slotsStack3ea4ef29ff9bf752f3c8d65709c692b6); } ?>
<?php if (! empty($__attrsStack3ea4ef29ff9bf752f3c8d65709c692b6)) { $__attrs3ea4ef29ff9bf752f3c8d65709c692b6 = array_pop($__attrsStack3ea4ef29ff9bf752f3c8d65709c692b6); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH D:\laragon\www\siix-portal-new\vendor\livewire\flux\stubs\resources\views\flux\checkbox\group\variants\default.blade.php ENDPATH**/ ?>