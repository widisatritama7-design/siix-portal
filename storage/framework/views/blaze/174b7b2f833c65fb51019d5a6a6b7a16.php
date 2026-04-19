<?php
if (!function_exists('__174b7b2f833c65fb51019d5a6a6b7a16')):
function __174b7b2f833c65fb51019d5a6a6b7a16($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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

<?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php', $__blaze->compiledPath.'/3ea4ef29ff9bf752f3c8d65709c692b6.php'); ?>
<?php if (isset($__slots3ea4ef29ff9bf752f3c8d65709c692b6)) { $__slotsStack3ea4ef29ff9bf752f3c8d65709c692b6[] = $__slots3ea4ef29ff9bf752f3c8d65709c692b6; } ?>
<?php if (isset($__attrs3ea4ef29ff9bf752f3c8d65709c692b6)) { $__attrsStack3ea4ef29ff9bf752f3c8d65709c692b6[] = $__attrs3ea4ef29ff9bf752f3c8d65709c692b6; } ?>
<?php $__attrs3ea4ef29ff9bf752f3c8d65709c692b6 = ['attributes' => $attributes]; ?>
<?php $__slots3ea4ef29ff9bf752f3c8d65709c692b6 = []; ?>
<?php $__blaze->pushData($__attrs3ea4ef29ff9bf752f3c8d65709c692b6); ?>
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
                <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/otp/input.blade.php', $__blaze->compiledPath.'/6a78b7b6a55faa8a71cd222d3dfec3a7.php'); ?>
<?php $__blaze->pushData([]); ?>
<?php __6a78b7b6a55faa8a71cd222d3dfec3a7($__blaze, [], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
            <?php endfor; ?>
        <?php else: ?>
            <?php echo e($slot); ?>

        <?php endif; ?>
    </ui-otp>
<?php $__slots3ea4ef29ff9bf752f3c8d65709c692b6['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots3ea4ef29ff9bf752f3c8d65709c692b6); ?>
<?php __3ea4ef29ff9bf752f3c8d65709c692b6($__blaze, $__attrs3ea4ef29ff9bf752f3c8d65709c692b6, $__slots3ea4ef29ff9bf752f3c8d65709c692b6, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3ea4ef29ff9bf752f3c8d65709c692b6)) { $__slots3ea4ef29ff9bf752f3c8d65709c692b6 = array_pop($__slotsStack3ea4ef29ff9bf752f3c8d65709c692b6); } ?>
<?php if (! empty($__attrsStack3ea4ef29ff9bf752f3c8d65709c692b6)) { $__attrs3ea4ef29ff9bf752f3c8d65709c692b6 = array_pop($__attrsStack3ea4ef29ff9bf752f3c8d65709c692b6); } ?>
<?php $__blaze->popData(); ?><?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/otp/index.blade.php ENDPATH**/ ?>