<?php
if (!function_exists('_cb8a57a3c873d97b481cdaf828b812c9')):
function _cb8a57a3c873d97b481cdaf828b812c9($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
            <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/e91be1baae40126c70a36be3d3a51d83.php'); ?>
<?php if (isset($__slotse91be1baae40126c70a36be3d3a51d83)) { $__slotsStacke91be1baae40126c70a36be3d3a51d83[] = $__slotse91be1baae40126c70a36be3d3a51d83; } ?>
<?php if (isset($__attrse91be1baae40126c70a36be3d3a51d83)) { $__attrsStacke91be1baae40126c70a36be3d3a51d83[] = $__attrse91be1baae40126c70a36be3d3a51d83; } ?>
<?php $__attrse91be1baae40126c70a36be3d3a51d83 = ['kbd' => $kbd]; ?>
<?php $__slotse91be1baae40126c70a36be3d3a51d83 = []; ?>
<?php $__blaze->pushData($__attrse91be1baae40126c70a36be3d3a51d83); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slotse91be1baae40126c70a36be3d3a51d83['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotse91be1baae40126c70a36be3d3a51d83); ?>
<?php _e91be1baae40126c70a36be3d3a51d83($__blaze, $__attrse91be1baae40126c70a36be3d3a51d83, $__slotse91be1baae40126c70a36be3d3a51d83, ['kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacke91be1baae40126c70a36be3d3a51d83)) { $__slotse91be1baae40126c70a36be3d3a51d83 = array_pop($__slotsStacke91be1baae40126c70a36be3d3a51d83); } ?>
<?php if (! empty($__attrsStacke91be1baae40126c70a36be3d3a51d83)) { $__attrse91be1baae40126c70a36be3d3a51d83 = array_pop($__attrsStacke91be1baae40126c70a36be3d3a51d83); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-dropdown>
<?php else: ?>
    <ui-tooltip position="<?php echo e($position); ?> <?php echo e($align); ?>" <?php echo e($attributes); ?> data-flux-tooltip <?php if($interactive): ?> interactive <?php endif; ?>>
        <?php echo e($slot); ?>


        <?php if ($content !== null): ?>
            <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/e91be1baae40126c70a36be3d3a51d83.php'); ?>
<?php if (isset($__slotse91be1baae40126c70a36be3d3a51d83)) { $__slotsStacke91be1baae40126c70a36be3d3a51d83[] = $__slotse91be1baae40126c70a36be3d3a51d83; } ?>
<?php if (isset($__attrse91be1baae40126c70a36be3d3a51d83)) { $__attrsStacke91be1baae40126c70a36be3d3a51d83[] = $__attrse91be1baae40126c70a36be3d3a51d83; } ?>
<?php $__attrse91be1baae40126c70a36be3d3a51d83 = ['kbd' => $kbd]; ?>
<?php $__slotse91be1baae40126c70a36be3d3a51d83 = []; ?>
<?php $__blaze->pushData($__attrse91be1baae40126c70a36be3d3a51d83); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slotse91be1baae40126c70a36be3d3a51d83['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotse91be1baae40126c70a36be3d3a51d83); ?>
<?php _e91be1baae40126c70a36be3d3a51d83($__blaze, $__attrse91be1baae40126c70a36be3d3a51d83, $__slotse91be1baae40126c70a36be3d3a51d83, ['kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacke91be1baae40126c70a36be3d3a51d83)) { $__slotse91be1baae40126c70a36be3d3a51d83 = array_pop($__slotsStacke91be1baae40126c70a36be3d3a51d83); } ?>
<?php if (! empty($__attrsStacke91be1baae40126c70a36be3d3a51d83)) { $__attrse91be1baae40126c70a36be3d3a51d83 = array_pop($__attrsStacke91be1baae40126c70a36be3d3a51d83); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-tooltip>
<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/index.blade.php ENDPATH**/ ?>