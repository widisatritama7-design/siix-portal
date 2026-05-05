<?php # [BlazeFolded]:{flux::checkbox.indicator}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/checkbox/indicator.blade.php}:{1774988736} ?>
<?php
if (!function_exists('_e4242727cb91e57bcff7759f5ce0590d')):
function _e4242727cb91e57bcff7759f5ce0590d($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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

<?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-inline-field.blade.php', $__blaze->compiledPath.'/ab524181009a9790fad3d790077f9632.php'); ?>
<?php if (isset($__slotsab524181009a9790fad3d790077f9632)) { $__slotsStackab524181009a9790fad3d790077f9632[] = $__slotsab524181009a9790fad3d790077f9632; } ?>
<?php if (isset($__attrsab524181009a9790fad3d790077f9632)) { $__attrsStackab524181009a9790fad3d790077f9632[] = $__attrsab524181009a9790fad3d790077f9632; } ?>
<?php $__attrsab524181009a9790fad3d790077f9632 = ['attributes' => $attributes]; ?>
<?php $__slotsab524181009a9790fad3d790077f9632 = []; ?>
<?php $__blaze->pushData($__attrsab524181009a9790fad3d790077f9632); ?>
<?php ob_start(); ?>
    <ui-checkbox <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> data-flux-control data-flux-checkbox>
        <?php ob_start(); ?><div class="shrink-0 size-[1.125rem] rounded-[.3rem] flex justify-center items-center text-sm text-zinc-700 dark:text-zinc-800 shadow-xs [ui-checkbox[disabled]_&amp;]:opacity-75 [ui-checkbox[data-checked][disabled]_&amp;]:opacity-50 [ui-checkbox[disabled]_&amp;]:shadow-none [ui-checkbox[data-checked]_&amp;]:shadow-none [ui-checkbox[data-indeterminate]_&amp;]:shadow-none [ui-checkbox[data-checked]:not([data-indeterminate])_&amp;&gt;svg:first-child]:block [ui-checkbox[data-indeterminate]_&amp;&gt;svg:last-child]:block border border-zinc-300 dark:border-white/10 [ui-checkbox[disabled]_&amp;]:border-zinc-200 dark:[ui-checkbox[disabled]_&amp;]:border-white/5 [ui-checkbox[data-checked]_&amp;]:border-transparent [ui-checkbox[data-indeterminate]_&amp;]:border-transparent [ui-checkbox[disabled][data-checked]_&amp;]:border-transparent [ui-checkbox[disabled][data-indeterminate]_&amp;]:border-transparent [print-color-adjust:exact] bg-white dark:bg-white/10 [ui-checkbox[data-checked]_&amp;]:bg-[var(--color-accent)] hover:[ui-checkbox[data-checked]_&amp;]:bg-(--color-accent) focus:[ui-checkbox[data-checked]_&amp;]:bg-(--color-accent) [ui-checkbox[data-indeterminate]_&amp;]:bg-[var(--color-accent)] hover:[ui-checkbox[data-indeterminate]_&amp;]:bg-(--color-accent) focus:[ui-checkbox[data-indeterminate]_&amp;]:bg-(--color-accent)" data-flux-checkbox-indicator>
    <svg class="shrink-0 [:where(&amp;)]:size-4 hidden text-[var(--color-accent-foreground)]" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/>
</svg>

            <svg class="shrink-0 [:where(&amp;)]:size-4 hidden text-[var(--color-accent-foreground)]" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path d="M3.75 7.25a.75.75 0 0 0 0 1.5h8.5a.75.75 0 0 0 0-1.5h-8.5Z"/>
</svg>

        </div>
<?php echo ltrim(ob_get_clean()); ?>
    </ui-checkbox>
<?php $__slotsab524181009a9790fad3d790077f9632['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsab524181009a9790fad3d790077f9632); ?>
<?php _ab524181009a9790fad3d790077f9632($__blaze, $__attrsab524181009a9790fad3d790077f9632, $__slotsab524181009a9790fad3d790077f9632, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackab524181009a9790fad3d790077f9632)) { $__slotsab524181009a9790fad3d790077f9632 = array_pop($__slotsStackab524181009a9790fad3d790077f9632); } ?>
<?php if (! empty($__attrsStackab524181009a9790fad3d790077f9632)) { $__attrsab524181009a9790fad3d790077f9632 = array_pop($__attrsStackab524181009a9790fad3d790077f9632); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/stubs/resources/views/flux/checkbox/variants/default.blade.php ENDPATH**/ ?>