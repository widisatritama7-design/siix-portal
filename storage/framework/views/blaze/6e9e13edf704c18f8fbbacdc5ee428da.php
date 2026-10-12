<?php
if (!function_exists('__6e9e13edf704c18f8fbbacdc5ee428da')):
function __6e9e13edf704c18f8fbbacdc5ee428da($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
$__defaults = [
    'length' => null,
    'private' => false,
];
$length ??= $attributes['length'] ?? $__defaults['length']; unset($attributes['length']);
$private ??= $attributes['private'] ?? $__defaults['private']; unset($attributes['private']);
unset($__defaults);
?>

<?php
    $classes = Flux::classes()
        ->add('flex items-center gap-2 isolate w-fit')
        ->add('[&_[data-flux-input-group]]:w-auto')
?>

<?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-field.blade.php', $__blaze->compiledPath.'/a6f34dfa561f7b96adc6243f0b3ecdc2.php'); ?>
<?php if (isset($__slotsa6f34dfa561f7b96adc6243f0b3ecdc2)) { $__slotsStacka6f34dfa561f7b96adc6243f0b3ecdc2[] = $__slotsa6f34dfa561f7b96adc6243f0b3ecdc2; } ?>
<?php if (isset($__attrsa6f34dfa561f7b96adc6243f0b3ecdc2)) { $__attrsStacka6f34dfa561f7b96adc6243f0b3ecdc2[] = $__attrsa6f34dfa561f7b96adc6243f0b3ecdc2; } ?>
<?php $__attrsa6f34dfa561f7b96adc6243f0b3ecdc2 = ['attributes' => $attributes]; ?>
<?php $__slotsa6f34dfa561f7b96adc6243f0b3ecdc2 = []; ?>
<?php $__blaze->pushData($__attrsa6f34dfa561f7b96adc6243f0b3ecdc2); ?>
<?php ob_start(); ?>
    <ui-otp
        <?php echo e($attributes->class($classes)); ?>

        data-flux-otp
        data-flux-control
        role="group"
        data-flux-input-aria-label="<?php echo e(__('Character {current} of {total}')); ?>"
    >
        <?php if($slot->isEmpty() && $length): ?>
            <?php for($i = 0; $i < $length; $i++): ?>
                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/otp/input.blade.php', $__blaze->compiledPath.'/530ef34a1c4196459ac01d4743f756dd.php'); ?>
<?php $__blaze->pushData([]); ?>
<?php __530ef34a1c4196459ac01d4743f756dd($__blaze, [], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
            <?php endfor; ?>
        <?php else: ?>
            <?php echo e($slot); ?>

        <?php endif; ?>
    </ui-otp>
<?php $__slotsa6f34dfa561f7b96adc6243f0b3ecdc2['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsa6f34dfa561f7b96adc6243f0b3ecdc2); ?>
<?php __a6f34dfa561f7b96adc6243f0b3ecdc2($__blaze, $__attrsa6f34dfa561f7b96adc6243f0b3ecdc2, $__slotsa6f34dfa561f7b96adc6243f0b3ecdc2, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacka6f34dfa561f7b96adc6243f0b3ecdc2)) { $__slotsa6f34dfa561f7b96adc6243f0b3ecdc2 = array_pop($__slotsStacka6f34dfa561f7b96adc6243f0b3ecdc2); } ?>
<?php if (! empty($__attrsStacka6f34dfa561f7b96adc6243f0b3ecdc2)) { $__attrsa6f34dfa561f7b96adc6243f0b3ecdc2 = array_pop($__attrsStacka6f34dfa561f7b96adc6243f0b3ecdc2); } ?>
<?php $__blaze->popData(); ?><?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/otp/index.blade.php ENDPATH**/ ?>