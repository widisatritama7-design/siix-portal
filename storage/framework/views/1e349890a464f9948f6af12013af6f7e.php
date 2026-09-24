<?php
if (!function_exists('_1e349890a464f9948f6af12013af6f7e')):
function _1e349890a464f9948f6af12013af6f7e($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
            <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/4f1bc3520d308fb4cf3904c7ea7a68ad.php'); ?>
<?php if (isset($__slots4f1bc3520d308fb4cf3904c7ea7a68ad)) { $__slotsStack4f1bc3520d308fb4cf3904c7ea7a68ad[] = $__slots4f1bc3520d308fb4cf3904c7ea7a68ad; } ?>
<?php if (isset($__attrs4f1bc3520d308fb4cf3904c7ea7a68ad)) { $__attrsStack4f1bc3520d308fb4cf3904c7ea7a68ad[] = $__attrs4f1bc3520d308fb4cf3904c7ea7a68ad; } ?>
<?php $__attrs4f1bc3520d308fb4cf3904c7ea7a68ad = ['kbd' => $kbd]; ?>
<?php $__slots4f1bc3520d308fb4cf3904c7ea7a68ad = []; ?>
<?php $__blaze->pushData($__attrs4f1bc3520d308fb4cf3904c7ea7a68ad); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slots4f1bc3520d308fb4cf3904c7ea7a68ad['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots4f1bc3520d308fb4cf3904c7ea7a68ad); ?>
<?php _4f1bc3520d308fb4cf3904c7ea7a68ad($__blaze, $__attrs4f1bc3520d308fb4cf3904c7ea7a68ad, $__slots4f1bc3520d308fb4cf3904c7ea7a68ad, ['kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack4f1bc3520d308fb4cf3904c7ea7a68ad)) { $__slots4f1bc3520d308fb4cf3904c7ea7a68ad = array_pop($__slotsStack4f1bc3520d308fb4cf3904c7ea7a68ad); } ?>
<?php if (! empty($__attrsStack4f1bc3520d308fb4cf3904c7ea7a68ad)) { $__attrs4f1bc3520d308fb4cf3904c7ea7a68ad = array_pop($__attrsStack4f1bc3520d308fb4cf3904c7ea7a68ad); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-dropdown>
<?php else: ?>
    <ui-tooltip position="<?php echo e($position); ?> <?php echo e($align); ?>" <?php echo e($attributes); ?> data-flux-tooltip <?php if($interactive): ?> interactive <?php endif; ?>>
        <?php echo e($slot); ?>


        <?php if ($content !== null): ?>
            <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/4f1bc3520d308fb4cf3904c7ea7a68ad.php'); ?>
<?php if (isset($__slots4f1bc3520d308fb4cf3904c7ea7a68ad)) { $__slotsStack4f1bc3520d308fb4cf3904c7ea7a68ad[] = $__slots4f1bc3520d308fb4cf3904c7ea7a68ad; } ?>
<?php if (isset($__attrs4f1bc3520d308fb4cf3904c7ea7a68ad)) { $__attrsStack4f1bc3520d308fb4cf3904c7ea7a68ad[] = $__attrs4f1bc3520d308fb4cf3904c7ea7a68ad; } ?>
<?php $__attrs4f1bc3520d308fb4cf3904c7ea7a68ad = ['kbd' => $kbd]; ?>
<?php $__slots4f1bc3520d308fb4cf3904c7ea7a68ad = []; ?>
<?php $__blaze->pushData($__attrs4f1bc3520d308fb4cf3904c7ea7a68ad); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slots4f1bc3520d308fb4cf3904c7ea7a68ad['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots4f1bc3520d308fb4cf3904c7ea7a68ad); ?>
<?php _4f1bc3520d308fb4cf3904c7ea7a68ad($__blaze, $__attrs4f1bc3520d308fb4cf3904c7ea7a68ad, $__slots4f1bc3520d308fb4cf3904c7ea7a68ad, ['kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack4f1bc3520d308fb4cf3904c7ea7a68ad)) { $__slots4f1bc3520d308fb4cf3904c7ea7a68ad = array_pop($__slotsStack4f1bc3520d308fb4cf3904c7ea7a68ad); } ?>
<?php if (! empty($__attrsStack4f1bc3520d308fb4cf3904c7ea7a68ad)) { $__attrs4f1bc3520d308fb4cf3904c7ea7a68ad = array_pop($__attrsStack4f1bc3520d308fb4cf3904c7ea7a68ad); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-tooltip>
<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/index.blade.php ENDPATH**/ ?>