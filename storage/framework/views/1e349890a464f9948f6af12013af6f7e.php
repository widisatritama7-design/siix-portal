<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('_edbc28068c97e5617f606f8737fd7ebb')):
function _edbc28068c97e5617f606f8737fd7ebb($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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
            <?php if (!function_exists('_26bc56991df2aec52b881beb62d7f974')) { require $__blaze->compile('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/content.blade.php'); } ?>
<?php if (isset($__slots26bc56991df2aec52b881beb62d7f974)) { $__slotsStack26bc56991df2aec52b881beb62d7f974[] = $__slots26bc56991df2aec52b881beb62d7f974; } ?>
<?php if (isset($__data26bc56991df2aec52b881beb62d7f974)) { $__dataStack26bc56991df2aec52b881beb62d7f974[] = $__data26bc56991df2aec52b881beb62d7f974; } ?>
<?php $__data26bc56991df2aec52b881beb62d7f974 = ['kbd' => $kbd]; ?>
<?php $__slots26bc56991df2aec52b881beb62d7f974 = []; ?>
<?php $__blaze->pushData($__data26bc56991df2aec52b881beb62d7f974); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slots26bc56991df2aec52b881beb62d7f974['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots26bc56991df2aec52b881beb62d7f974); ?>
<?php _26bc56991df2aec52b881beb62d7f974($__blaze, $__data26bc56991df2aec52b881beb62d7f974, ['kbd' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__data26bc56991df2aec52b881beb62d7f974['kbd'])], $__slots26bc56991df2aec52b881beb62d7f974, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack26bc56991df2aec52b881beb62d7f974)) { $__slots26bc56991df2aec52b881beb62d7f974 = array_pop($__slotsStack26bc56991df2aec52b881beb62d7f974); } ?>
<?php if (! empty($__dataStack26bc56991df2aec52b881beb62d7f974)) { $__data26bc56991df2aec52b881beb62d7f974 = array_pop($__dataStack26bc56991df2aec52b881beb62d7f974); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-dropdown>
<?php else: ?>
    <ui-tooltip position="<?php echo e($position); ?> <?php echo e($align); ?>" <?php echo e($attributes); ?> data-flux-tooltip <?php if($interactive): ?> interactive <?php endif; ?>>
        <?php echo e($slot); ?>


        <?php if ($content !== null): ?>
            <?php if (!function_exists('_26bc56991df2aec52b881beb62d7f974')) { require $__blaze->compile('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/content.blade.php'); } ?>
<?php if (isset($__slots26bc56991df2aec52b881beb62d7f974)) { $__slotsStack26bc56991df2aec52b881beb62d7f974[] = $__slots26bc56991df2aec52b881beb62d7f974; } ?>
<?php if (isset($__data26bc56991df2aec52b881beb62d7f974)) { $__dataStack26bc56991df2aec52b881beb62d7f974[] = $__data26bc56991df2aec52b881beb62d7f974; } ?>
<?php $__data26bc56991df2aec52b881beb62d7f974 = ['kbd' => $kbd]; ?>
<?php $__slots26bc56991df2aec52b881beb62d7f974 = []; ?>
<?php $__blaze->pushData($__data26bc56991df2aec52b881beb62d7f974); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slots26bc56991df2aec52b881beb62d7f974['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots26bc56991df2aec52b881beb62d7f974); ?>
<?php _26bc56991df2aec52b881beb62d7f974($__blaze, $__data26bc56991df2aec52b881beb62d7f974, ['kbd' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__data26bc56991df2aec52b881beb62d7f974['kbd'])], $__slots26bc56991df2aec52b881beb62d7f974, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack26bc56991df2aec52b881beb62d7f974)) { $__slots26bc56991df2aec52b881beb62d7f974 = array_pop($__slotsStack26bc56991df2aec52b881beb62d7f974); } ?>
<?php if (! empty($__dataStack26bc56991df2aec52b881beb62d7f974)) { $__data26bc56991df2aec52b881beb62d7f974 = array_pop($__dataStack26bc56991df2aec52b881beb62d7f974); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-tooltip>
<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/index.blade.php ENDPATH**/ ?>