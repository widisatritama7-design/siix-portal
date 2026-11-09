<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__df21857acf993815fa9e3e776579df40')):
function __df21857acf993815fa9e3e776579df40($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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

<?php if (!function_exists('__cff1c71bac828e48284939dd973e7838')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php'); } ?>
<?php if (isset($__slotscff1c71bac828e48284939dd973e7838)) { $__slotsStackcff1c71bac828e48284939dd973e7838[] = $__slotscff1c71bac828e48284939dd973e7838; } ?>
<?php if (isset($__datacff1c71bac828e48284939dd973e7838)) { $__dataStackcff1c71bac828e48284939dd973e7838[] = $__datacff1c71bac828e48284939dd973e7838; } ?>
<?php $__datacff1c71bac828e48284939dd973e7838 = ['attributes' => $attributes]; ?>
<?php $__slotscff1c71bac828e48284939dd973e7838 = []; ?>
<?php $__blaze->pushData($__datacff1c71bac828e48284939dd973e7838); ?>
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
                <?php if (!function_exists('__724e4f4159c624ba41e7b6bef0736582')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/otp/input.blade.php'); } ?>
<?php $__componentData = []; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php __724e4f4159c624ba41e7b6bef0736582($__blaze, $__componentData, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
            <?php endfor; ?>
        <?php else: ?>
            <?php echo e($slot); ?>

        <?php endif; ?>
    </ui-otp>
<?php $__slotscff1c71bac828e48284939dd973e7838['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotscff1c71bac828e48284939dd973e7838); ?>
<?php __cff1c71bac828e48284939dd973e7838($__blaze, $__datacff1c71bac828e48284939dd973e7838, $__blaze->mergeAttributes(['attributes' => $__datacff1c71bac828e48284939dd973e7838['attributes']]), $__slotscff1c71bac828e48284939dd973e7838, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackcff1c71bac828e48284939dd973e7838)) { $__slotscff1c71bac828e48284939dd973e7838 = array_pop($__slotsStackcff1c71bac828e48284939dd973e7838); } ?>
<?php if (! empty($__dataStackcff1c71bac828e48284939dd973e7838)) { $__datacff1c71bac828e48284939dd973e7838 = array_pop($__dataStackcff1c71bac828e48284939dd973e7838); } ?>
<?php $__blaze->popData(); ?><?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/otp/index.blade.php ENDPATH**/ ?>