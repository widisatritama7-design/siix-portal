<?php
if (!function_exists('__fac5f31e0d344cf0c75d0ed78270eee2')):
function __fac5f31e0d344cf0c75d0ed78270eee2($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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

<?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-field.blade.php', $__blaze->compiledPath.'/5f1fd5be44768539d084481ede0d744f.php'); ?>
<?php if (isset($__slots5f1fd5be44768539d084481ede0d744f)) { $__slotsStack5f1fd5be44768539d084481ede0d744f[] = $__slots5f1fd5be44768539d084481ede0d744f; } ?>
<?php if (isset($__attrs5f1fd5be44768539d084481ede0d744f)) { $__attrsStack5f1fd5be44768539d084481ede0d744f[] = $__attrs5f1fd5be44768539d084481ede0d744f; } ?>
<?php $__attrs5f1fd5be44768539d084481ede0d744f = ['attributes' => $attributes]; ?>
<?php $__slots5f1fd5be44768539d084481ede0d744f = []; ?>
<?php $__blaze->pushData($__attrs5f1fd5be44768539d084481ede0d744f); ?>
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
                <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/otp/input.blade.php', $__blaze->compiledPath.'/75022e6793246d7c0857d122fef03258.php'); ?>
<?php $__blaze->pushData([]); ?>
<?php __75022e6793246d7c0857d122fef03258($__blaze, [], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
            <?php endfor; ?>
        <?php else: ?>
            <?php echo e($slot); ?>

        <?php endif; ?>
    </ui-otp>
<?php $__slots5f1fd5be44768539d084481ede0d744f['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots5f1fd5be44768539d084481ede0d744f); ?>
<?php __5f1fd5be44768539d084481ede0d744f($__blaze, $__attrs5f1fd5be44768539d084481ede0d744f, $__slots5f1fd5be44768539d084481ede0d744f, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack5f1fd5be44768539d084481ede0d744f)) { $__slots5f1fd5be44768539d084481ede0d744f = array_pop($__slotsStack5f1fd5be44768539d084481ede0d744f); } ?>
<?php if (! empty($__attrsStack5f1fd5be44768539d084481ede0d744f)) { $__attrs5f1fd5be44768539d084481ede0d744f = array_pop($__attrsStack5f1fd5be44768539d084481ede0d744f); } ?>
<?php $__blaze->popData(); ?><?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/otp/index.blade.php ENDPATH**/ ?>