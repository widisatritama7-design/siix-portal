<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__b78bba45b37958662e2e8e6c1905059e')):
function __b78bba45b37958662e2e8e6c1905059e($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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
            <?php if (!function_exists('__338f74e49470c6944d237f91cb086588')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/content.blade.php'); } ?>
<?php if (isset($__slots338f74e49470c6944d237f91cb086588)) { $__slotsStack338f74e49470c6944d237f91cb086588[] = $__slots338f74e49470c6944d237f91cb086588; } ?>
<?php if (isset($__data338f74e49470c6944d237f91cb086588)) { $__dataStack338f74e49470c6944d237f91cb086588[] = $__data338f74e49470c6944d237f91cb086588; } ?>
<?php $__data338f74e49470c6944d237f91cb086588 = ['kbd' => $kbd]; ?>
<?php $__slots338f74e49470c6944d237f91cb086588 = []; ?>
<?php $__blaze->pushData($__data338f74e49470c6944d237f91cb086588); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slots338f74e49470c6944d237f91cb086588['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots338f74e49470c6944d237f91cb086588); ?>
<?php __338f74e49470c6944d237f91cb086588($__blaze, $__data338f74e49470c6944d237f91cb086588, ['kbd' => \Livewire\Blaze\Runtime\BlazeRuntime::sanitizeFoldedAttribute($__data338f74e49470c6944d237f91cb086588['kbd'])], $__slots338f74e49470c6944d237f91cb086588, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack338f74e49470c6944d237f91cb086588)) { $__slots338f74e49470c6944d237f91cb086588 = array_pop($__slotsStack338f74e49470c6944d237f91cb086588); } ?>
<?php if (! empty($__dataStack338f74e49470c6944d237f91cb086588)) { $__data338f74e49470c6944d237f91cb086588 = array_pop($__dataStack338f74e49470c6944d237f91cb086588); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-dropdown>
<?php else: ?>
    <ui-tooltip position="<?php echo e($position); ?> <?php echo e($align); ?>" <?php echo e($attributes); ?> data-flux-tooltip <?php if($interactive): ?> interactive <?php endif; ?>>
        <?php echo e($slot); ?>


        <?php if ($content !== null): ?>
            <?php if (!function_exists('__338f74e49470c6944d237f91cb086588')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/content.blade.php'); } ?>
<?php if (isset($__slots338f74e49470c6944d237f91cb086588)) { $__slotsStack338f74e49470c6944d237f91cb086588[] = $__slots338f74e49470c6944d237f91cb086588; } ?>
<?php if (isset($__data338f74e49470c6944d237f91cb086588)) { $__dataStack338f74e49470c6944d237f91cb086588[] = $__data338f74e49470c6944d237f91cb086588; } ?>
<?php $__data338f74e49470c6944d237f91cb086588 = ['kbd' => $kbd]; ?>
<?php $__slots338f74e49470c6944d237f91cb086588 = []; ?>
<?php $__blaze->pushData($__data338f74e49470c6944d237f91cb086588); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slots338f74e49470c6944d237f91cb086588['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots338f74e49470c6944d237f91cb086588); ?>
<?php __338f74e49470c6944d237f91cb086588($__blaze, $__data338f74e49470c6944d237f91cb086588, ['kbd' => \Livewire\Blaze\Runtime\BlazeRuntime::sanitizeFoldedAttribute($__data338f74e49470c6944d237f91cb086588['kbd'])], $__slots338f74e49470c6944d237f91cb086588, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack338f74e49470c6944d237f91cb086588)) { $__slots338f74e49470c6944d237f91cb086588 = array_pop($__slotsStack338f74e49470c6944d237f91cb086588); } ?>
<?php if (! empty($__dataStack338f74e49470c6944d237f91cb086588)) { $__data338f74e49470c6944d237f91cb086588 = array_pop($__dataStack338f74e49470c6944d237f91cb086588); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-tooltip>
<?php endif; ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/index.blade.php ENDPATH**/ ?>