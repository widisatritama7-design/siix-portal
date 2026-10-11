<?php
if (!function_exists('_0c57adc8a1cf8ff5dfea71e0750441cc')):
function _0c57adc8a1cf8ff5dfea71e0750441cc($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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

<?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php', $__blaze->compiledPath.'/6ba02b760522d3c69435c68da2316bf2.php'); ?>
<?php if (isset($__slots6ba02b760522d3c69435c68da2316bf2)) { $__slotsStack6ba02b760522d3c69435c68da2316bf2[] = $__slots6ba02b760522d3c69435c68da2316bf2; } ?>
<?php if (isset($__attrs6ba02b760522d3c69435c68da2316bf2)) { $__attrsStack6ba02b760522d3c69435c68da2316bf2[] = $__attrs6ba02b760522d3c69435c68da2316bf2; } ?>
<?php $__attrs6ba02b760522d3c69435c68da2316bf2 = ['attributes' => $attributes]; ?>
<?php $__slots6ba02b760522d3c69435c68da2316bf2 = []; ?>
<?php $__blaze->pushData($__attrs6ba02b760522d3c69435c68da2316bf2); ?>
<?php ob_start(); ?>
    <ui-checkbox-group <?php echo e($attributes->class($classes)); ?> data-flux-checkbox-group>
        <?php echo e($slot); ?>

    </ui-checkbox-group>
<?php $__slots6ba02b760522d3c69435c68da2316bf2['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots6ba02b760522d3c69435c68da2316bf2); ?>
<?php _6ba02b760522d3c69435c68da2316bf2($__blaze, $__attrs6ba02b760522d3c69435c68da2316bf2, $__slots6ba02b760522d3c69435c68da2316bf2, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack6ba02b760522d3c69435c68da2316bf2)) { $__slots6ba02b760522d3c69435c68da2316bf2 = array_pop($__slotsStack6ba02b760522d3c69435c68da2316bf2); } ?>
<?php if (! empty($__attrsStack6ba02b760522d3c69435c68da2316bf2)) { $__attrs6ba02b760522d3c69435c68da2316bf2 = array_pop($__attrsStack6ba02b760522d3c69435c68da2316bf2); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\stubs\resources\views\flux\checkbox\group\variants\default.blade.php ENDPATH**/ ?>