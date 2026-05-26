<?php
if (!function_exists('_22ab68ab038821c9363be66143029001')):
function _22ab68ab038821c9363be66143029001($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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

<?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-field.blade.php', $__blaze->compiledPath.'/5f1fd5be44768539d084481ede0d744f.php'); ?>
<?php if (isset($__slots5f1fd5be44768539d084481ede0d744f)) { $__slotsStack5f1fd5be44768539d084481ede0d744f[] = $__slots5f1fd5be44768539d084481ede0d744f; } ?>
<?php if (isset($__attrs5f1fd5be44768539d084481ede0d744f)) { $__attrsStack5f1fd5be44768539d084481ede0d744f[] = $__attrs5f1fd5be44768539d084481ede0d744f; } ?>
<?php $__attrs5f1fd5be44768539d084481ede0d744f = ['attributes' => $attributes]; ?>
<?php $__slots5f1fd5be44768539d084481ede0d744f = []; ?>
<?php $__blaze->pushData($__attrs5f1fd5be44768539d084481ede0d744f); ?>
<?php ob_start(); ?>
    <ui-checkbox-group <?php echo e($attributes->class($classes)); ?> data-flux-checkbox-group>
        <?php echo e($slot); ?>

    </ui-checkbox-group>
<?php $__slots5f1fd5be44768539d084481ede0d744f['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots5f1fd5be44768539d084481ede0d744f); ?>
<?php _5f1fd5be44768539d084481ede0d744f($__blaze, $__attrs5f1fd5be44768539d084481ede0d744f, $__slots5f1fd5be44768539d084481ede0d744f, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack5f1fd5be44768539d084481ede0d744f)) { $__slots5f1fd5be44768539d084481ede0d744f = array_pop($__slotsStack5f1fd5be44768539d084481ede0d744f); } ?>
<?php if (! empty($__attrsStack5f1fd5be44768539d084481ede0d744f)) { $__attrs5f1fd5be44768539d084481ede0d744f = array_pop($__attrsStack5f1fd5be44768539d084481ede0d744f); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/stubs/resources/views/flux/checkbox/group/variants/default.blade.php ENDPATH**/ ?>