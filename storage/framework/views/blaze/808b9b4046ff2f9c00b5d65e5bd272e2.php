<?php
if (!function_exists('__808b9b4046ff2f9c00b5d65e5bd272e2')):
function __808b9b4046ff2f9c00b5d65e5bd272e2($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
            <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/e16894c1c9557e8a57590996b6e212be.php'); ?>
<?php if (isset($__slotse16894c1c9557e8a57590996b6e212be)) { $__slotsStacke16894c1c9557e8a57590996b6e212be[] = $__slotse16894c1c9557e8a57590996b6e212be; } ?>
<?php if (isset($__attrse16894c1c9557e8a57590996b6e212be)) { $__attrsStacke16894c1c9557e8a57590996b6e212be[] = $__attrse16894c1c9557e8a57590996b6e212be; } ?>
<?php $__attrse16894c1c9557e8a57590996b6e212be = ['kbd' => $kbd]; ?>
<?php $__slotse16894c1c9557e8a57590996b6e212be = []; ?>
<?php $__blaze->pushData($__attrse16894c1c9557e8a57590996b6e212be); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slotse16894c1c9557e8a57590996b6e212be['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotse16894c1c9557e8a57590996b6e212be); ?>
<?php __e16894c1c9557e8a57590996b6e212be($__blaze, $__attrse16894c1c9557e8a57590996b6e212be, $__slotse16894c1c9557e8a57590996b6e212be, ['kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacke16894c1c9557e8a57590996b6e212be)) { $__slotse16894c1c9557e8a57590996b6e212be = array_pop($__slotsStacke16894c1c9557e8a57590996b6e212be); } ?>
<?php if (! empty($__attrsStacke16894c1c9557e8a57590996b6e212be)) { $__attrse16894c1c9557e8a57590996b6e212be = array_pop($__attrsStacke16894c1c9557e8a57590996b6e212be); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-dropdown>
<?php else: ?>
    <ui-tooltip position="<?php echo e($position); ?> <?php echo e($align); ?>" <?php echo e($attributes); ?> data-flux-tooltip <?php if($interactive): ?> interactive <?php endif; ?>>
        <?php echo e($slot); ?>


        <?php if ($content !== null): ?>
            <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/e16894c1c9557e8a57590996b6e212be.php'); ?>
<?php if (isset($__slotse16894c1c9557e8a57590996b6e212be)) { $__slotsStacke16894c1c9557e8a57590996b6e212be[] = $__slotse16894c1c9557e8a57590996b6e212be; } ?>
<?php if (isset($__attrse16894c1c9557e8a57590996b6e212be)) { $__attrsStacke16894c1c9557e8a57590996b6e212be[] = $__attrse16894c1c9557e8a57590996b6e212be; } ?>
<?php $__attrse16894c1c9557e8a57590996b6e212be = ['kbd' => $kbd]; ?>
<?php $__slotse16894c1c9557e8a57590996b6e212be = []; ?>
<?php $__blaze->pushData($__attrse16894c1c9557e8a57590996b6e212be); ?>
<?php ob_start(); ?><?php echo e($content); ?><?php $__slotse16894c1c9557e8a57590996b6e212be['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotse16894c1c9557e8a57590996b6e212be); ?>
<?php __e16894c1c9557e8a57590996b6e212be($__blaze, $__attrse16894c1c9557e8a57590996b6e212be, $__slotse16894c1c9557e8a57590996b6e212be, ['kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacke16894c1c9557e8a57590996b6e212be)) { $__slotse16894c1c9557e8a57590996b6e212be = array_pop($__slotsStacke16894c1c9557e8a57590996b6e212be); } ?>
<?php if (! empty($__attrsStacke16894c1c9557e8a57590996b6e212be)) { $__attrse16894c1c9557e8a57590996b6e212be = array_pop($__attrsStacke16894c1c9557e8a57590996b6e212be); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    </ui-tooltip>
<?php endif; ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/index.blade.php ENDPATH**/ ?>