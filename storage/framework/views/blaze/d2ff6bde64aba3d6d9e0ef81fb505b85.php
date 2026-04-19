<?php
if (!function_exists('__d2ff6bde64aba3d6d9e0ef81fb505b85')):
function __d2ff6bde64aba3d6d9e0ef81fb505b85($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    'interactive' => null,
    'position' => 'top',
    'align' => 'center',
    'content' => null,
    'kbd' => null,
    'toggleable' => null,
];
$interactive ??= $attributes['interactive'] ?? $__defaults['interactive']; unset($attributes['interactive']);
$position ??= $attributes['position'] ?? $__defaults['position']; unset($attributes['position']);
$align ??= $attributes['align'] ?? $__defaults['align']; unset($attributes['align']);
$content ??= $attributes['content'] ?? $__defaults['content']; unset($attributes['content']);
$kbd ??= $attributes['kbd'] ?? $__defaults['kbd']; unset($attributes['kbd']);
$toggleable ??= $attributes['toggleable'] ?? $__defaults['toggleable']; unset($attributes['toggleable']);
unset($__defaults);
?>

<?php
// Support adding the .self modifier to the wire:model directive...
if (($wireModel = $attributes->wire('model')) && $wireModel->directive && ! $wireModel->hasModifier('self')) {
    unset($attributes[$wireModel->directive]);

    $wireModel->directive .= '.self';

    $attributes = $attributes->merge([$wireModel->directive => $wireModel->value]);
}
?>

<?php if ($toggleable): ?>
    <ui-dropdown position="<?php echo e($position); ?> <?php echo e($align); ?>" <?php echo e($attributes); ?> data-flux-tooltip>
        <?php echo e($slot); ?>


        <?php if ($content !== null): ?>
            <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/f11f89c11aa17d087f3db4d72d78680a.php'); ?>
<?php if (isset($__slotsf11f89c11aa17d087f3db4d72d78680a)) { $__slotsStackf11f89c11aa17d087f3db4d72d78680a[] = $__slotsf11f89c11aa17d087f3db4d72d78680a; } ?>
<?php if (isset($__attrsf11f89c11aa17d087f3db4d72d78680a)) { $__attrsStackf11f89c11aa17d087f3db4d72d78680a[] = $__attrsf11f89c11aa17d087f3db4d72d78680a; } ?>
<?php $__attrsf11f89c11aa17d087f3db4d72d78680a = ['kbd' => $kbd]; ?>
<?php $__slotsf11f89c11aa17d087f3db4d72d78680a = []; ?>
<?php $__blaze->pushData($__attrsf11f89c11aa17d087f3db4d72d78680a); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slotsf11f89c11aa17d087f3db4d72d78680a['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsf11f89c11aa17d087f3db4d72d78680a); ?>
<?php __f11f89c11aa17d087f3db4d72d78680a($__blaze, $__attrsf11f89c11aa17d087f3db4d72d78680a, $__slotsf11f89c11aa17d087f3db4d72d78680a, ['kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackf11f89c11aa17d087f3db4d72d78680a)) { $__slotsf11f89c11aa17d087f3db4d72d78680a = array_pop($__slotsStackf11f89c11aa17d087f3db4d72d78680a); } ?>
<?php if (! empty($__attrsStackf11f89c11aa17d087f3db4d72d78680a)) { $__attrsf11f89c11aa17d087f3db4d72d78680a = array_pop($__attrsStackf11f89c11aa17d087f3db4d72d78680a); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-dropdown>
<?php else: ?>
    <ui-tooltip position="<?php echo e($position); ?> <?php echo e($align); ?>" <?php echo e($attributes); ?> data-flux-tooltip <?php if($interactive): ?> interactive <?php endif; ?>>
        <?php echo e($slot); ?>


        <?php if ($content !== null): ?>
            <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/f11f89c11aa17d087f3db4d72d78680a.php'); ?>
<?php if (isset($__slotsf11f89c11aa17d087f3db4d72d78680a)) { $__slotsStackf11f89c11aa17d087f3db4d72d78680a[] = $__slotsf11f89c11aa17d087f3db4d72d78680a; } ?>
<?php if (isset($__attrsf11f89c11aa17d087f3db4d72d78680a)) { $__attrsStackf11f89c11aa17d087f3db4d72d78680a[] = $__attrsf11f89c11aa17d087f3db4d72d78680a; } ?>
<?php $__attrsf11f89c11aa17d087f3db4d72d78680a = ['kbd' => $kbd]; ?>
<?php $__slotsf11f89c11aa17d087f3db4d72d78680a = []; ?>
<?php $__blaze->pushData($__attrsf11f89c11aa17d087f3db4d72d78680a); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slotsf11f89c11aa17d087f3db4d72d78680a['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsf11f89c11aa17d087f3db4d72d78680a); ?>
<?php __f11f89c11aa17d087f3db4d72d78680a($__blaze, $__attrsf11f89c11aa17d087f3db4d72d78680a, $__slotsf11f89c11aa17d087f3db4d72d78680a, ['kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackf11f89c11aa17d087f3db4d72d78680a)) { $__slotsf11f89c11aa17d087f3db4d72d78680a = array_pop($__slotsStackf11f89c11aa17d087f3db4d72d78680a); } ?>
<?php if (! empty($__attrsStackf11f89c11aa17d087f3db4d72d78680a)) { $__attrsf11f89c11aa17d087f3db4d72d78680a = array_pop($__attrsStackf11f89c11aa17d087f3db4d72d78680a); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-tooltip>
<?php endif; ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/index.blade.php ENDPATH**/ ?>