<?php
if (!function_exists('__7065c86f3f51cbbcd790ac279168812b')):
function __7065c86f3f51cbbcd790ac279168812b($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
            <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/146a0be8f265a27931447ec0f9d7e3ed.php'); ?>
<?php if (isset($__slots146a0be8f265a27931447ec0f9d7e3ed)) { $__slotsStack146a0be8f265a27931447ec0f9d7e3ed[] = $__slots146a0be8f265a27931447ec0f9d7e3ed; } ?>
<?php if (isset($__attrs146a0be8f265a27931447ec0f9d7e3ed)) { $__attrsStack146a0be8f265a27931447ec0f9d7e3ed[] = $__attrs146a0be8f265a27931447ec0f9d7e3ed; } ?>
<?php $__attrs146a0be8f265a27931447ec0f9d7e3ed = ['kbd' => $kbd]; ?>
<?php $__slots146a0be8f265a27931447ec0f9d7e3ed = []; ?>
<?php $__blaze->pushData($__attrs146a0be8f265a27931447ec0f9d7e3ed); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slots146a0be8f265a27931447ec0f9d7e3ed['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots146a0be8f265a27931447ec0f9d7e3ed); ?>
<?php __146a0be8f265a27931447ec0f9d7e3ed($__blaze, $__attrs146a0be8f265a27931447ec0f9d7e3ed, $__slots146a0be8f265a27931447ec0f9d7e3ed, ['kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack146a0be8f265a27931447ec0f9d7e3ed)) { $__slots146a0be8f265a27931447ec0f9d7e3ed = array_pop($__slotsStack146a0be8f265a27931447ec0f9d7e3ed); } ?>
<?php if (! empty($__attrsStack146a0be8f265a27931447ec0f9d7e3ed)) { $__attrs146a0be8f265a27931447ec0f9d7e3ed = array_pop($__attrsStack146a0be8f265a27931447ec0f9d7e3ed); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-dropdown>
<?php else: ?>
    <ui-tooltip position="<?php echo e($position); ?> <?php echo e($align); ?>" <?php echo e($attributes); ?> data-flux-tooltip <?php if($interactive): ?> interactive <?php endif; ?>>
        <?php echo e($slot); ?>


        <?php if ($content !== null): ?>
            <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/146a0be8f265a27931447ec0f9d7e3ed.php'); ?>
<?php if (isset($__slots146a0be8f265a27931447ec0f9d7e3ed)) { $__slotsStack146a0be8f265a27931447ec0f9d7e3ed[] = $__slots146a0be8f265a27931447ec0f9d7e3ed; } ?>
<?php if (isset($__attrs146a0be8f265a27931447ec0f9d7e3ed)) { $__attrsStack146a0be8f265a27931447ec0f9d7e3ed[] = $__attrs146a0be8f265a27931447ec0f9d7e3ed; } ?>
<?php $__attrs146a0be8f265a27931447ec0f9d7e3ed = ['kbd' => $kbd]; ?>
<?php $__slots146a0be8f265a27931447ec0f9d7e3ed = []; ?>
<?php $__blaze->pushData($__attrs146a0be8f265a27931447ec0f9d7e3ed); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slots146a0be8f265a27931447ec0f9d7e3ed['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots146a0be8f265a27931447ec0f9d7e3ed); ?>
<?php __146a0be8f265a27931447ec0f9d7e3ed($__blaze, $__attrs146a0be8f265a27931447ec0f9d7e3ed, $__slots146a0be8f265a27931447ec0f9d7e3ed, ['kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack146a0be8f265a27931447ec0f9d7e3ed)) { $__slots146a0be8f265a27931447ec0f9d7e3ed = array_pop($__slotsStack146a0be8f265a27931447ec0f9d7e3ed); } ?>
<?php if (! empty($__attrsStack146a0be8f265a27931447ec0f9d7e3ed)) { $__attrs146a0be8f265a27931447ec0f9d7e3ed = array_pop($__attrsStack146a0be8f265a27931447ec0f9d7e3ed); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-tooltip>
<?php endif; ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH D:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/index.blade.php ENDPATH**/ ?>