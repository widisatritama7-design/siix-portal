<?php
if (!function_exists('_2ec4b91a52d2097625d50fdf8533857e')):
function _2ec4b91a52d2097625d50fdf8533857e($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/field.blade.php', $__blaze->compiledPath.'/c093426d3d64f836efe2aac101899db6.php'); ?>
<?php if (isset($__slotsc093426d3d64f836efe2aac101899db6)) { $__slotsStackc093426d3d64f836efe2aac101899db6[] = $__slotsc093426d3d64f836efe2aac101899db6; } ?>
<?php if (isset($__attrsc093426d3d64f836efe2aac101899db6)) { $__attrsStackc093426d3d64f836efe2aac101899db6[] = $__attrsc093426d3d64f836efe2aac101899db6; } ?>
<?php $__attrsc093426d3d64f836efe2aac101899db6 = ['attributes' => $fieldAttributes]; ?>
<?php $__slotsc093426d3d64f836efe2aac101899db6 = []; ?>
<?php $__blaze->pushData($__attrsc093426d3d64f836efe2aac101899db6); ?>
<?php ob_start(); ?>
        <?php if (isset($label)): ?>
            <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/label.blade.php', $__blaze->compiledPath.'/a8e578f2b3679dd4e1765673ff96f156.php'); ?>
<?php if (isset($__slotsa8e578f2b3679dd4e1765673ff96f156)) { $__slotsStacka8e578f2b3679dd4e1765673ff96f156[] = $__slotsa8e578f2b3679dd4e1765673ff96f156; } ?>
<?php if (isset($__attrsa8e578f2b3679dd4e1765673ff96f156)) { $__attrsStacka8e578f2b3679dd4e1765673ff96f156[] = $__attrsa8e578f2b3679dd4e1765673ff96f156; } ?>
<?php $__attrsa8e578f2b3679dd4e1765673ff96f156 = ['attributes' => $labelAttributes]; ?>
<?php $__slotsa8e578f2b3679dd4e1765673ff96f156 = []; ?>
<?php $__blaze->pushData($__attrsa8e578f2b3679dd4e1765673ff96f156); ?>
<?php ob_start(); ?><?php echo e($label); ?><?php $__slotsa8e578f2b3679dd4e1765673ff96f156['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsa8e578f2b3679dd4e1765673ff96f156); ?>
<?php _a8e578f2b3679dd4e1765673ff96f156($__blaze, $__attrsa8e578f2b3679dd4e1765673ff96f156, $__slotsa8e578f2b3679dd4e1765673ff96f156, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacka8e578f2b3679dd4e1765673ff96f156)) { $__slotsa8e578f2b3679dd4e1765673ff96f156 = array_pop($__slotsStacka8e578f2b3679dd4e1765673ff96f156); } ?>
<?php if (! empty($__attrsStacka8e578f2b3679dd4e1765673ff96f156)) { $__attrsa8e578f2b3679dd4e1765673ff96f156 = array_pop($__attrsStacka8e578f2b3679dd4e1765673ff96f156); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php if (isset($description)): ?>
            <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/description.blade.php', $__blaze->compiledPath.'/a0134a28e4c98b93887f246e675b9d51.php'); ?>
<?php if (isset($__slotsa0134a28e4c98b93887f246e675b9d51)) { $__slotsStacka0134a28e4c98b93887f246e675b9d51[] = $__slotsa0134a28e4c98b93887f246e675b9d51; } ?>
<?php if (isset($__attrsa0134a28e4c98b93887f246e675b9d51)) { $__attrsStacka0134a28e4c98b93887f246e675b9d51[] = $__attrsa0134a28e4c98b93887f246e675b9d51; } ?>
<?php $__attrsa0134a28e4c98b93887f246e675b9d51 = ['attributes' => $descriptionAttributes]; ?>
<?php $__slotsa0134a28e4c98b93887f246e675b9d51 = []; ?>
<?php $__blaze->pushData($__attrsa0134a28e4c98b93887f246e675b9d51); ?>
<?php ob_start(); ?><?php echo e($description); ?><?php $__slotsa0134a28e4c98b93887f246e675b9d51['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsa0134a28e4c98b93887f246e675b9d51); ?>
<?php _a0134a28e4c98b93887f246e675b9d51($__blaze, $__attrsa0134a28e4c98b93887f246e675b9d51, $__slotsa0134a28e4c98b93887f246e675b9d51, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacka0134a28e4c98b93887f246e675b9d51)) { $__slotsa0134a28e4c98b93887f246e675b9d51 = array_pop($__slotsStacka0134a28e4c98b93887f246e675b9d51); } ?>
<?php if (! empty($__attrsStacka0134a28e4c98b93887f246e675b9d51)) { $__attrsa0134a28e4c98b93887f246e675b9d51 = array_pop($__attrsStacka0134a28e4c98b93887f246e675b9d51); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php echo e($slot); ?>


        
        <?php $__getScope = fn($scope = []) => $scope; ?><?php if (isset($scope)) $__scope = $scope; ?><?php $scope = $__getScope(scope: ['attributes' => $errorAttributes->getAttributes()]); ?>
        <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/426418f99652b797e5ac732302061798.php'); ?>
<?php $__blaze->pushData(['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])]); ?>
<?php _426418f99652b797e5ac732302061798($__blaze, ['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])], [], ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
        <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>

        <?php if (isset($descriptionTrailing)): ?>
            <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/description.blade.php', $__blaze->compiledPath.'/a0134a28e4c98b93887f246e675b9d51.php'); ?>
<?php if (isset($__slotsa0134a28e4c98b93887f246e675b9d51)) { $__slotsStacka0134a28e4c98b93887f246e675b9d51[] = $__slotsa0134a28e4c98b93887f246e675b9d51; } ?>
<?php if (isset($__attrsa0134a28e4c98b93887f246e675b9d51)) { $__attrsStacka0134a28e4c98b93887f246e675b9d51[] = $__attrsa0134a28e4c98b93887f246e675b9d51; } ?>
<?php $__attrsa0134a28e4c98b93887f246e675b9d51 = ['attributes' => $descriptionAttributes]; ?>
<?php $__slotsa0134a28e4c98b93887f246e675b9d51 = []; ?>
<?php $__blaze->pushData($__attrsa0134a28e4c98b93887f246e675b9d51); ?>
<?php ob_start(); ?><?php echo e($descriptionTrailing); ?><?php $__slotsa0134a28e4c98b93887f246e675b9d51['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsa0134a28e4c98b93887f246e675b9d51); ?>
<?php _a0134a28e4c98b93887f246e675b9d51($__blaze, $__attrsa0134a28e4c98b93887f246e675b9d51, $__slotsa0134a28e4c98b93887f246e675b9d51, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacka0134a28e4c98b93887f246e675b9d51)) { $__slotsa0134a28e4c98b93887f246e675b9d51 = array_pop($__slotsStacka0134a28e4c98b93887f246e675b9d51); } ?>
<?php if (! empty($__attrsStacka0134a28e4c98b93887f246e675b9d51)) { $__attrsa0134a28e4c98b93887f246e675b9d51 = array_pop($__attrsStacka0134a28e4c98b93887f246e675b9d51); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    <?php $__slotsc093426d3d64f836efe2aac101899db6['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsc093426d3d64f836efe2aac101899db6); ?>
<?php _c093426d3d64f836efe2aac101899db6($__blaze, $__attrsc093426d3d64f836efe2aac101899db6, $__slotsc093426d3d64f836efe2aac101899db6, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackc093426d3d64f836efe2aac101899db6)) { $__slotsc093426d3d64f836efe2aac101899db6 = array_pop($__slotsStackc093426d3d64f836efe2aac101899db6); } ?>
<?php if (! empty($__attrsStackc093426d3d64f836efe2aac101899db6)) { $__attrsc093426d3d64f836efe2aac101899db6 = array_pop($__attrsStackc093426d3d64f836efe2aac101899db6); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH D:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php ENDPATH**/ ?>