<?php
if (!function_exists('_cb4989024ab55d4aeddc082f445f7934')):
function _cb4989024ab55d4aeddc082f445f7934($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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

<?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-field.blade.php', $__blaze->compiledPath.'/a6f34dfa561f7b96adc6243f0b3ecdc2.php'); ?>
<?php if (isset($__slotsa6f34dfa561f7b96adc6243f0b3ecdc2)) { $__slotsStacka6f34dfa561f7b96adc6243f0b3ecdc2[] = $__slotsa6f34dfa561f7b96adc6243f0b3ecdc2; } ?>
<?php if (isset($__attrsa6f34dfa561f7b96adc6243f0b3ecdc2)) { $__attrsStacka6f34dfa561f7b96adc6243f0b3ecdc2[] = $__attrsa6f34dfa561f7b96adc6243f0b3ecdc2; } ?>
<?php $__attrsa6f34dfa561f7b96adc6243f0b3ecdc2 = ['attributes' => $attributes]; ?>
<?php $__slotsa6f34dfa561f7b96adc6243f0b3ecdc2 = []; ?>
<?php $__blaze->pushData($__attrsa6f34dfa561f7b96adc6243f0b3ecdc2); ?>
<?php ob_start(); ?>
    <ui-checkbox-group <?php echo e($attributes->class($classes)); ?> data-flux-checkbox-group>
        <?php echo e($slot); ?>

    </ui-checkbox-group>
<?php $__slotsa6f34dfa561f7b96adc6243f0b3ecdc2['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsa6f34dfa561f7b96adc6243f0b3ecdc2); ?>
<?php _a6f34dfa561f7b96adc6243f0b3ecdc2($__blaze, $__attrsa6f34dfa561f7b96adc6243f0b3ecdc2, $__slotsa6f34dfa561f7b96adc6243f0b3ecdc2, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacka6f34dfa561f7b96adc6243f0b3ecdc2)) { $__slotsa6f34dfa561f7b96adc6243f0b3ecdc2 = array_pop($__slotsStacka6f34dfa561f7b96adc6243f0b3ecdc2); } ?>
<?php if (! empty($__attrsStacka6f34dfa561f7b96adc6243f0b3ecdc2)) { $__attrsa6f34dfa561f7b96adc6243f0b3ecdc2 = array_pop($__attrsStacka6f34dfa561f7b96adc6243f0b3ecdc2); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/stubs/resources/views/flux/checkbox/group/variants/default.blade.php ENDPATH**/ ?>