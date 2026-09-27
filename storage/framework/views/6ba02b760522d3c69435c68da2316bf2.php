<?php
if (!function_exists('_6ba02b760522d3c69435c68da2316bf2')):
function _6ba02b760522d3c69435c68da2316bf2($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
extract(Flux::forwardedAttributes($attributes, [
    'name',
    'descriptionTrailing',
    'description',
    'label',
    'badge',
]));
?>

<?php $descriptionTrailing = $descriptionTrailing ??= $attributes->pluck('description:trailing'); ?>

<?php
$__defaults = [
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'descriptionTrailing' => null,
    'description' => null,
    'label' => null,
    'badge' => null,
];
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
$descriptionTrailing ??= $attributes['description-trailing'] ?? $attributes['descriptionTrailing'] ?? $__defaults['descriptionTrailing']; unset($attributes['descriptionTrailing'], $attributes['description-trailing']);
$description ??= $attributes['description'] ?? $__defaults['description']; unset($attributes['description']);
$label ??= $attributes['label'] ?? $__defaults['label']; unset($attributes['label']);
$badge ??= $attributes['badge'] ?? $__defaults['badge']; unset($attributes['badge']);
unset($__defaults);
?>

<?php if (isset($label) || isset($description)): ?>
    <?php

        $fieldAttributes = Flux::attributesAfter('field:', $attributes, []);
        $labelAttributes = Flux::attributesAfter('label:', $attributes, ['badge' => $badge]);
        $descriptionAttributes = Flux::attributesAfter('description:', $attributes, []);
        $errorAttributes = Flux::attributesAfter('error:', $attributes, ['name' => $name]);
    ?>
    <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/field.blade.php', $__blaze->compiledPath.'/1fafaa8edf101abdd2a5e52942034771.php'); ?>
<?php if (isset($__slots1fafaa8edf101abdd2a5e52942034771)) { $__slotsStack1fafaa8edf101abdd2a5e52942034771[] = $__slots1fafaa8edf101abdd2a5e52942034771; } ?>
<?php if (isset($__attrs1fafaa8edf101abdd2a5e52942034771)) { $__attrsStack1fafaa8edf101abdd2a5e52942034771[] = $__attrs1fafaa8edf101abdd2a5e52942034771; } ?>
<?php $__attrs1fafaa8edf101abdd2a5e52942034771 = ['attributes' => $fieldAttributes]; ?>
<?php $__slots1fafaa8edf101abdd2a5e52942034771 = []; ?>
<?php $__blaze->pushData($__attrs1fafaa8edf101abdd2a5e52942034771); ?>
<?php ob_start(); ?>
        <?php if (isset($label)): ?>
            <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/label.blade.php', $__blaze->compiledPath.'/884949a411afc2357a56e4de56dc81a6.php'); ?>
<?php if (isset($__slots884949a411afc2357a56e4de56dc81a6)) { $__slotsStack884949a411afc2357a56e4de56dc81a6[] = $__slots884949a411afc2357a56e4de56dc81a6; } ?>
<?php if (isset($__attrs884949a411afc2357a56e4de56dc81a6)) { $__attrsStack884949a411afc2357a56e4de56dc81a6[] = $__attrs884949a411afc2357a56e4de56dc81a6; } ?>
<?php $__attrs884949a411afc2357a56e4de56dc81a6 = ['attributes' => $labelAttributes]; ?>
<?php $__slots884949a411afc2357a56e4de56dc81a6 = []; ?>
<?php $__blaze->pushData($__attrs884949a411afc2357a56e4de56dc81a6); ?>
<?php ob_start(); ?><?php echo e($label); ?><?php $__slots884949a411afc2357a56e4de56dc81a6['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots884949a411afc2357a56e4de56dc81a6); ?>
<?php _884949a411afc2357a56e4de56dc81a6($__blaze, $__attrs884949a411afc2357a56e4de56dc81a6, $__slots884949a411afc2357a56e4de56dc81a6, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack884949a411afc2357a56e4de56dc81a6)) { $__slots884949a411afc2357a56e4de56dc81a6 = array_pop($__slotsStack884949a411afc2357a56e4de56dc81a6); } ?>
<?php if (! empty($__attrsStack884949a411afc2357a56e4de56dc81a6)) { $__attrs884949a411afc2357a56e4de56dc81a6 = array_pop($__attrsStack884949a411afc2357a56e4de56dc81a6); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php if (isset($description)): ?>
            <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/description.blade.php', $__blaze->compiledPath.'/c3c3096a2b937d1813f219be5973e030.php'); ?>
<?php if (isset($__slotsc3c3096a2b937d1813f219be5973e030)) { $__slotsStackc3c3096a2b937d1813f219be5973e030[] = $__slotsc3c3096a2b937d1813f219be5973e030; } ?>
<?php if (isset($__attrsc3c3096a2b937d1813f219be5973e030)) { $__attrsStackc3c3096a2b937d1813f219be5973e030[] = $__attrsc3c3096a2b937d1813f219be5973e030; } ?>
<?php $__attrsc3c3096a2b937d1813f219be5973e030 = ['attributes' => $descriptionAttributes]; ?>
<?php $__slotsc3c3096a2b937d1813f219be5973e030 = []; ?>
<?php $__blaze->pushData($__attrsc3c3096a2b937d1813f219be5973e030); ?>
<?php ob_start(); ?><?php echo e($description); ?><?php $__slotsc3c3096a2b937d1813f219be5973e030['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsc3c3096a2b937d1813f219be5973e030); ?>
<?php _c3c3096a2b937d1813f219be5973e030($__blaze, $__attrsc3c3096a2b937d1813f219be5973e030, $__slotsc3c3096a2b937d1813f219be5973e030, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackc3c3096a2b937d1813f219be5973e030)) { $__slotsc3c3096a2b937d1813f219be5973e030 = array_pop($__slotsStackc3c3096a2b937d1813f219be5973e030); } ?>
<?php if (! empty($__attrsStackc3c3096a2b937d1813f219be5973e030)) { $__attrsc3c3096a2b937d1813f219be5973e030 = array_pop($__attrsStackc3c3096a2b937d1813f219be5973e030); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php echo e($slot); ?>


        
        <?php $__getScope = fn($scope = []) => $scope; ?><?php if (isset($scope)) $__scope = $scope; ?><?php $scope = $__getScope(scope: ['attributes' => $errorAttributes->getAttributes()]); ?>
        <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/8489350c4983a4957ce53f20e6e2bab4.php'); ?>
<?php $__blaze->pushData(['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])]); ?>
<?php _8489350c4983a4957ce53f20e6e2bab4($__blaze, ['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])], [], ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
        <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>

        <?php if (isset($descriptionTrailing)): ?>
            <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/description.blade.php', $__blaze->compiledPath.'/c3c3096a2b937d1813f219be5973e030.php'); ?>
<?php if (isset($__slotsc3c3096a2b937d1813f219be5973e030)) { $__slotsStackc3c3096a2b937d1813f219be5973e030[] = $__slotsc3c3096a2b937d1813f219be5973e030; } ?>
<?php if (isset($__attrsc3c3096a2b937d1813f219be5973e030)) { $__attrsStackc3c3096a2b937d1813f219be5973e030[] = $__attrsc3c3096a2b937d1813f219be5973e030; } ?>
<?php $__attrsc3c3096a2b937d1813f219be5973e030 = ['attributes' => $descriptionAttributes]; ?>
<?php $__slotsc3c3096a2b937d1813f219be5973e030 = []; ?>
<?php $__blaze->pushData($__attrsc3c3096a2b937d1813f219be5973e030); ?>
<?php ob_start(); ?><?php echo e($descriptionTrailing); ?><?php $__slotsc3c3096a2b937d1813f219be5973e030['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsc3c3096a2b937d1813f219be5973e030); ?>
<?php _c3c3096a2b937d1813f219be5973e030($__blaze, $__attrsc3c3096a2b937d1813f219be5973e030, $__slotsc3c3096a2b937d1813f219be5973e030, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackc3c3096a2b937d1813f219be5973e030)) { $__slotsc3c3096a2b937d1813f219be5973e030 = array_pop($__slotsStackc3c3096a2b937d1813f219be5973e030); } ?>
<?php if (! empty($__attrsStackc3c3096a2b937d1813f219be5973e030)) { $__attrsc3c3096a2b937d1813f219be5973e030 = array_pop($__attrsStackc3c3096a2b937d1813f219be5973e030); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    <?php $__slots1fafaa8edf101abdd2a5e52942034771['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots1fafaa8edf101abdd2a5e52942034771); ?>
<?php _1fafaa8edf101abdd2a5e52942034771($__blaze, $__attrs1fafaa8edf101abdd2a5e52942034771, $__slots1fafaa8edf101abdd2a5e52942034771, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack1fafaa8edf101abdd2a5e52942034771)) { $__slots1fafaa8edf101abdd2a5e52942034771 = array_pop($__slotsStack1fafaa8edf101abdd2a5e52942034771); } ?>
<?php if (! empty($__attrsStack1fafaa8edf101abdd2a5e52942034771)) { $__attrs1fafaa8edf101abdd2a5e52942034771 = array_pop($__attrsStack1fafaa8edf101abdd2a5e52942034771); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php ENDPATH**/ ?>