<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__72cd75c1c9acbfc98f91065a6a3ecef1')):
function __72cd75c1c9acbfc98f91065a6a3ecef1($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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

<?php if (!function_exists('__b119ceb1b9a3e04beca2cedd1073790a')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-field.blade.php'); } ?>
<?php if (isset($__slotsb119ceb1b9a3e04beca2cedd1073790a)) { $__slotsStackb119ceb1b9a3e04beca2cedd1073790a[] = $__slotsb119ceb1b9a3e04beca2cedd1073790a; } ?>
<?php if (isset($__datab119ceb1b9a3e04beca2cedd1073790a)) { $__dataStackb119ceb1b9a3e04beca2cedd1073790a[] = $__datab119ceb1b9a3e04beca2cedd1073790a; } ?>
<?php $__datab119ceb1b9a3e04beca2cedd1073790a = ['attributes' => $attributes]; ?>
<?php $__slotsb119ceb1b9a3e04beca2cedd1073790a = []; ?>
<?php $__blaze->pushData($__datab119ceb1b9a3e04beca2cedd1073790a); ?>
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
                <?php if (!function_exists('__4b716f82afa57dc15bbf5f22def221f2')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/otp/input.blade.php'); } ?>
<?php $__componentData = []; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php __4b716f82afa57dc15bbf5f22def221f2($__blaze, $__componentData, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
            <?php endfor; ?>
        <?php else: ?>
            <?php echo e($slot); ?>

        <?php endif; ?>
    </ui-otp>
<?php $__slotsb119ceb1b9a3e04beca2cedd1073790a['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsb119ceb1b9a3e04beca2cedd1073790a); ?>
<?php __b119ceb1b9a3e04beca2cedd1073790a($__blaze, $__datab119ceb1b9a3e04beca2cedd1073790a, $__blaze->mergeAttributes(['attributes' => $__datab119ceb1b9a3e04beca2cedd1073790a['attributes']]), $__slotsb119ceb1b9a3e04beca2cedd1073790a, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackb119ceb1b9a3e04beca2cedd1073790a)) { $__slotsb119ceb1b9a3e04beca2cedd1073790a = array_pop($__slotsStackb119ceb1b9a3e04beca2cedd1073790a); } ?>
<?php if (! empty($__dataStackb119ceb1b9a3e04beca2cedd1073790a)) { $__datab119ceb1b9a3e04beca2cedd1073790a = array_pop($__dataStackb119ceb1b9a3e04beca2cedd1073790a); } ?>
<?php $__blaze->popData(); ?><?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/otp/index.blade.php ENDPATH**/ ?>