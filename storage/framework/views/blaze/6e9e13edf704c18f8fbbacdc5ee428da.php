<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__e1ca13bd295f76bd85bd2bbefebd54b3')):
function __e1ca13bd295f76bd85bd2bbefebd54b3($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = new \Livewire\Blaze\Runtime\BlazeAttributeBag($__attributes);
unset($__data, $__attributes);
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

<?php if (!function_exists('__cc94b751a6dbee3c6cddb4c1c630c48a')) { require $__blaze->compile('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-field.blade.php'); } ?>
<?php if (isset($__slotscc94b751a6dbee3c6cddb4c1c630c48a)) { $__slotsStackcc94b751a6dbee3c6cddb4c1c630c48a[] = $__slotscc94b751a6dbee3c6cddb4c1c630c48a; } ?>
<?php if (isset($__datacc94b751a6dbee3c6cddb4c1c630c48a)) { $__dataStackcc94b751a6dbee3c6cddb4c1c630c48a[] = $__datacc94b751a6dbee3c6cddb4c1c630c48a; } ?>
<?php $__datacc94b751a6dbee3c6cddb4c1c630c48a = ['attributes' => $attributes]; ?>
<?php $__slotscc94b751a6dbee3c6cddb4c1c630c48a = []; ?>
<?php $__blaze->pushData($__datacc94b751a6dbee3c6cddb4c1c630c48a); ?>
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
                <?php if (!function_exists('__38797780289789664a34aa11c62114e7')) { require $__blaze->compile('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/otp/input.blade.php'); } ?>
<?php $__componentData = []; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php __38797780289789664a34aa11c62114e7($__blaze, $__componentData, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
            <?php endfor; ?>
        <?php else: ?>
            <?php echo e($slot); ?>

        <?php endif; ?>
    </ui-otp>
<?php $__slotscc94b751a6dbee3c6cddb4c1c630c48a['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotscc94b751a6dbee3c6cddb4c1c630c48a); ?>
<?php __cc94b751a6dbee3c6cddb4c1c630c48a($__blaze, $__datacc94b751a6dbee3c6cddb4c1c630c48a, $__blaze->mergeAttributes(['attributes' => $__datacc94b751a6dbee3c6cddb4c1c630c48a['attributes']]), $__slotscc94b751a6dbee3c6cddb4c1c630c48a, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackcc94b751a6dbee3c6cddb4c1c630c48a)) { $__slotscc94b751a6dbee3c6cddb4c1c630c48a = array_pop($__slotsStackcc94b751a6dbee3c6cddb4c1c630c48a); } ?>
<?php if (! empty($__dataStackcc94b751a6dbee3c6cddb4c1c630c48a)) { $__datacc94b751a6dbee3c6cddb4c1c630c48a = array_pop($__dataStackcc94b751a6dbee3c6cddb4c1c630c48a); } ?>
<?php $__blaze->popData(); ?><?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/otp/index.blade.php ENDPATH**/ ?>