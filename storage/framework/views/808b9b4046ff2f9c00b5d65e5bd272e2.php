<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('_5961450e49b0ec8ad12f26dc1b23916e')):
function _5961450e49b0ec8ad12f26dc1b23916e($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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
            <?php if (!function_exists('_f08645fb94831a81ec4df5129a3f3d32')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/content.blade.php'); } ?>
<?php if (isset($__slotsf08645fb94831a81ec4df5129a3f3d32)) { $__slotsStackf08645fb94831a81ec4df5129a3f3d32[] = $__slotsf08645fb94831a81ec4df5129a3f3d32; } ?>
<?php if (isset($__dataf08645fb94831a81ec4df5129a3f3d32)) { $__dataStackf08645fb94831a81ec4df5129a3f3d32[] = $__dataf08645fb94831a81ec4df5129a3f3d32; } ?>
<?php $__dataf08645fb94831a81ec4df5129a3f3d32 = ['kbd' => $kbd]; ?>
<?php $__slotsf08645fb94831a81ec4df5129a3f3d32 = []; ?>
<?php $__blaze->pushData($__dataf08645fb94831a81ec4df5129a3f3d32); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slotsf08645fb94831a81ec4df5129a3f3d32['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsf08645fb94831a81ec4df5129a3f3d32); ?>
<?php _f08645fb94831a81ec4df5129a3f3d32($__blaze, $__dataf08645fb94831a81ec4df5129a3f3d32, ['kbd' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__dataf08645fb94831a81ec4df5129a3f3d32['kbd'])], $__slotsf08645fb94831a81ec4df5129a3f3d32, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackf08645fb94831a81ec4df5129a3f3d32)) { $__slotsf08645fb94831a81ec4df5129a3f3d32 = array_pop($__slotsStackf08645fb94831a81ec4df5129a3f3d32); } ?>
<?php if (! empty($__dataStackf08645fb94831a81ec4df5129a3f3d32)) { $__dataf08645fb94831a81ec4df5129a3f3d32 = array_pop($__dataStackf08645fb94831a81ec4df5129a3f3d32); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-dropdown>
<?php else: ?>
    <ui-tooltip position="<?php echo e($position); ?> <?php echo e($align); ?>" <?php echo e($attributes); ?> data-flux-tooltip <?php if($interactive): ?> interactive <?php endif; ?>>
        <?php echo e($slot); ?>


        <?php if ($content !== null): ?>
            <?php if (!function_exists('_f08645fb94831a81ec4df5129a3f3d32')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/content.blade.php'); } ?>
<?php if (isset($__slotsf08645fb94831a81ec4df5129a3f3d32)) { $__slotsStackf08645fb94831a81ec4df5129a3f3d32[] = $__slotsf08645fb94831a81ec4df5129a3f3d32; } ?>
<?php if (isset($__dataf08645fb94831a81ec4df5129a3f3d32)) { $__dataStackf08645fb94831a81ec4df5129a3f3d32[] = $__dataf08645fb94831a81ec4df5129a3f3d32; } ?>
<?php $__dataf08645fb94831a81ec4df5129a3f3d32 = ['kbd' => $kbd]; ?>
<?php $__slotsf08645fb94831a81ec4df5129a3f3d32 = []; ?>
<?php $__blaze->pushData($__dataf08645fb94831a81ec4df5129a3f3d32); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slotsf08645fb94831a81ec4df5129a3f3d32['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsf08645fb94831a81ec4df5129a3f3d32); ?>
<?php _f08645fb94831a81ec4df5129a3f3d32($__blaze, $__dataf08645fb94831a81ec4df5129a3f3d32, ['kbd' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__dataf08645fb94831a81ec4df5129a3f3d32['kbd'])], $__slotsf08645fb94831a81ec4df5129a3f3d32, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackf08645fb94831a81ec4df5129a3f3d32)) { $__slotsf08645fb94831a81ec4df5129a3f3d32 = array_pop($__slotsStackf08645fb94831a81ec4df5129a3f3d32); } ?>
<?php if (! empty($__dataStackf08645fb94831a81ec4df5129a3f3d32)) { $__dataf08645fb94831a81ec4df5129a3f3d32 = array_pop($__dataStackf08645fb94831a81ec4df5129a3f3d32); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-tooltip>
<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/index.blade.php ENDPATH**/ ?>