<?php
if (!function_exists('_853011862fa20a1b96c3c93eae213030')):
function _853011862fa20a1b96c3c93eae213030($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    'variant' => null,
    'size' => null,
    'name' => null,
];
$variant ??= $attributes['variant'] ?? $__defaults['variant']; unset($attributes['variant']);
$size ??= $attributes['size'] ?? $__defaults['size']; unset($attributes['size']);
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
unset($__defaults);
?>

<?php
// We only want to show the name attribute on the checkbox if it has been set
// manually, but not if it has been set from the wire:model attribute...
$showName = isset($name);

if (! isset($name)) {
    $name = $attributes->whereStartsWith('wire:model')->first();
}

$classes = Flux::classes()
    ->add('flex flex-wrap gap-3')
    ;
?>

<?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php', $__blaze->compiledPath.'/3ea4ef29ff9bf752f3c8d65709c692b6.php'); ?>
<?php if (isset($__slots3ea4ef29ff9bf752f3c8d65709c692b6)) { $__slotsStack3ea4ef29ff9bf752f3c8d65709c692b6[] = $__slots3ea4ef29ff9bf752f3c8d65709c692b6; } ?>
<?php if (isset($__attrs3ea4ef29ff9bf752f3c8d65709c692b6)) { $__attrsStack3ea4ef29ff9bf752f3c8d65709c692b6[] = $__attrs3ea4ef29ff9bf752f3c8d65709c692b6; } ?>
<?php $__attrs3ea4ef29ff9bf752f3c8d65709c692b6 = ['attributes' => $attributes]; ?>
<?php $__slots3ea4ef29ff9bf752f3c8d65709c692b6 = []; ?>
<?php $__blaze->pushData($__attrs3ea4ef29ff9bf752f3c8d65709c692b6); ?>
<?php ob_start(); ?>
    <ui-checkbox-group <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> data-flux-checkbox-group-pills>
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
} endif; ?><?php /**PATH D:\laragon\www\siix-portal-new\vendor\livewire\flux\stubs\resources\views\flux\checkbox\group\variants\pills.blade.php ENDPATH**/ ?>