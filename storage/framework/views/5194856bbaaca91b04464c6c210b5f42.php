<?php
if (!function_exists('_5194856bbaaca91b04464c6c210b5f42')):
function _5194856bbaaca91b04464c6c210b5f42($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php
$__defaults = [
    'name' => null,
];
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
    ->add('flex size-[1.125rem] rounded-[.3rem] mt-px outline-offset-2')
    ;
?>

<?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-inline-field.blade.php', $__blaze->compiledPath.'/34ececb6e6dbe18957461df13093226e.php'); ?>
<?php if (isset($__slots34ececb6e6dbe18957461df13093226e)) { $__slotsStack34ececb6e6dbe18957461df13093226e[] = $__slots34ececb6e6dbe18957461df13093226e; } ?>
<?php if (isset($__attrs34ececb6e6dbe18957461df13093226e)) { $__attrsStack34ececb6e6dbe18957461df13093226e[] = $__attrs34ececb6e6dbe18957461df13093226e; } ?>
<?php $__attrs34ececb6e6dbe18957461df13093226e = ['attributes' => $attributes]; ?>
<?php $__slots34ececb6e6dbe18957461df13093226e = []; ?>
<?php $__blaze->pushData($__attrs34ececb6e6dbe18957461df13093226e); ?>
<?php ob_start(); ?>
    <ui-checkbox <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> data-flux-control data-flux-checkbox>
        <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::checkbox.indicator", []); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/checkbox/indicator.blade.php', $__blaze->compiledPath.'/8a9a7d9b1273a75ad8081bcdab6d2c92.php'); ?>
<?php $__blaze->pushData([]); ?>
<?php _8a9a7d9b1273a75ad8081bcdab6d2c92($__blaze, [], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
    </ui-checkbox>
<?php $__slots34ececb6e6dbe18957461df13093226e['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots34ececb6e6dbe18957461df13093226e); ?>
<?php _34ececb6e6dbe18957461df13093226e($__blaze, $__attrs34ececb6e6dbe18957461df13093226e, $__slots34ececb6e6dbe18957461df13093226e, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack34ececb6e6dbe18957461df13093226e)) { $__slots34ececb6e6dbe18957461df13093226e = array_pop($__slotsStack34ececb6e6dbe18957461df13093226e); } ?>
<?php if (! empty($__attrsStack34ececb6e6dbe18957461df13093226e)) { $__attrs34ececb6e6dbe18957461df13093226e = array_pop($__attrsStack34ececb6e6dbe18957461df13093226e); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/checkbox/variants/default.blade.php ENDPATH**/ ?>