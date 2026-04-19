<?php
if (!function_exists('_3ea4ef29ff9bf752f3c8d65709c692b6')):
function _3ea4ef29ff9bf752f3c8d65709c692b6($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/field.blade.php', $__blaze->compiledPath.'/171996f0ab1383f16ab66b099e061473.php'); ?>
<?php if (isset($__slots171996f0ab1383f16ab66b099e061473)) { $__slotsStack171996f0ab1383f16ab66b099e061473[] = $__slots171996f0ab1383f16ab66b099e061473; } ?>
<?php if (isset($__attrs171996f0ab1383f16ab66b099e061473)) { $__attrsStack171996f0ab1383f16ab66b099e061473[] = $__attrs171996f0ab1383f16ab66b099e061473; } ?>
<?php $__attrs171996f0ab1383f16ab66b099e061473 = ['attributes' => $fieldAttributes]; ?>
<?php $__slots171996f0ab1383f16ab66b099e061473 = []; ?>
<?php $__blaze->pushData($__attrs171996f0ab1383f16ab66b099e061473); ?>
<?php ob_start(); ?>
        <?php if (isset($label)): ?>
            <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/label.blade.php', $__blaze->compiledPath.'/ff185ae2283cecffc22027393371936c.php'); ?>
<?php if (isset($__slotsff185ae2283cecffc22027393371936c)) { $__slotsStackff185ae2283cecffc22027393371936c[] = $__slotsff185ae2283cecffc22027393371936c; } ?>
<?php if (isset($__attrsff185ae2283cecffc22027393371936c)) { $__attrsStackff185ae2283cecffc22027393371936c[] = $__attrsff185ae2283cecffc22027393371936c; } ?>
<?php $__attrsff185ae2283cecffc22027393371936c = ['attributes' => $labelAttributes]; ?>
<?php $__slotsff185ae2283cecffc22027393371936c = []; ?>
<?php $__blaze->pushData($__attrsff185ae2283cecffc22027393371936c); ?>
<?php ob_start(); ?><?php echo e($label); ?><?php $__slotsff185ae2283cecffc22027393371936c['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsff185ae2283cecffc22027393371936c); ?>
<?php _ff185ae2283cecffc22027393371936c($__blaze, $__attrsff185ae2283cecffc22027393371936c, $__slotsff185ae2283cecffc22027393371936c, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackff185ae2283cecffc22027393371936c)) { $__slotsff185ae2283cecffc22027393371936c = array_pop($__slotsStackff185ae2283cecffc22027393371936c); } ?>
<?php if (! empty($__attrsStackff185ae2283cecffc22027393371936c)) { $__attrsff185ae2283cecffc22027393371936c = array_pop($__attrsStackff185ae2283cecffc22027393371936c); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php if (isset($description)): ?>
            <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/description.blade.php', $__blaze->compiledPath.'/3d2e35307e15b7d2452958c02650eb26.php'); ?>
<?php if (isset($__slots3d2e35307e15b7d2452958c02650eb26)) { $__slotsStack3d2e35307e15b7d2452958c02650eb26[] = $__slots3d2e35307e15b7d2452958c02650eb26; } ?>
<?php if (isset($__attrs3d2e35307e15b7d2452958c02650eb26)) { $__attrsStack3d2e35307e15b7d2452958c02650eb26[] = $__attrs3d2e35307e15b7d2452958c02650eb26; } ?>
<?php $__attrs3d2e35307e15b7d2452958c02650eb26 = ['attributes' => $descriptionAttributes]; ?>
<?php $__slots3d2e35307e15b7d2452958c02650eb26 = []; ?>
<?php $__blaze->pushData($__attrs3d2e35307e15b7d2452958c02650eb26); ?>
<?php ob_start(); ?><?php echo e($description); ?><?php $__slots3d2e35307e15b7d2452958c02650eb26['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d2e35307e15b7d2452958c02650eb26); ?>
<?php _3d2e35307e15b7d2452958c02650eb26($__blaze, $__attrs3d2e35307e15b7d2452958c02650eb26, $__slots3d2e35307e15b7d2452958c02650eb26, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d2e35307e15b7d2452958c02650eb26)) { $__slots3d2e35307e15b7d2452958c02650eb26 = array_pop($__slotsStack3d2e35307e15b7d2452958c02650eb26); } ?>
<?php if (! empty($__attrsStack3d2e35307e15b7d2452958c02650eb26)) { $__attrs3d2e35307e15b7d2452958c02650eb26 = array_pop($__attrsStack3d2e35307e15b7d2452958c02650eb26); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php echo e($slot); ?>


        
        <?php $__getScope = fn($scope = []) => $scope; ?><?php if (isset($scope)) $__scope = $scope; ?><?php $scope = $__getScope(scope: ['attributes' => $errorAttributes->getAttributes()]); ?>
        <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/5a47bc60272d6b2c88a3d2ecff0b1cbb.php'); ?>
<?php $__blaze->pushData(['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])]); ?>
<?php _5a47bc60272d6b2c88a3d2ecff0b1cbb($__blaze, ['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])], [], ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
        <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>

        <?php if (isset($descriptionTrailing)): ?>
            <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/description.blade.php', $__blaze->compiledPath.'/3d2e35307e15b7d2452958c02650eb26.php'); ?>
<?php if (isset($__slots3d2e35307e15b7d2452958c02650eb26)) { $__slotsStack3d2e35307e15b7d2452958c02650eb26[] = $__slots3d2e35307e15b7d2452958c02650eb26; } ?>
<?php if (isset($__attrs3d2e35307e15b7d2452958c02650eb26)) { $__attrsStack3d2e35307e15b7d2452958c02650eb26[] = $__attrs3d2e35307e15b7d2452958c02650eb26; } ?>
<?php $__attrs3d2e35307e15b7d2452958c02650eb26 = ['attributes' => $descriptionAttributes]; ?>
<?php $__slots3d2e35307e15b7d2452958c02650eb26 = []; ?>
<?php $__blaze->pushData($__attrs3d2e35307e15b7d2452958c02650eb26); ?>
<?php ob_start(); ?><?php echo e($descriptionTrailing); ?><?php $__slots3d2e35307e15b7d2452958c02650eb26['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3d2e35307e15b7d2452958c02650eb26); ?>
<?php _3d2e35307e15b7d2452958c02650eb26($__blaze, $__attrs3d2e35307e15b7d2452958c02650eb26, $__slots3d2e35307e15b7d2452958c02650eb26, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d2e35307e15b7d2452958c02650eb26)) { $__slots3d2e35307e15b7d2452958c02650eb26 = array_pop($__slotsStack3d2e35307e15b7d2452958c02650eb26); } ?>
<?php if (! empty($__attrsStack3d2e35307e15b7d2452958c02650eb26)) { $__attrs3d2e35307e15b7d2452958c02650eb26 = array_pop($__attrsStack3d2e35307e15b7d2452958c02650eb26); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    <?php $__slots171996f0ab1383f16ab66b099e061473['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots171996f0ab1383f16ab66b099e061473); ?>
<?php _171996f0ab1383f16ab66b099e061473($__blaze, $__attrs171996f0ab1383f16ab66b099e061473, $__slots171996f0ab1383f16ab66b099e061473, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack171996f0ab1383f16ab66b099e061473)) { $__slots171996f0ab1383f16ab66b099e061473 = array_pop($__slotsStack171996f0ab1383f16ab66b099e061473); } ?>
<?php if (! empty($__attrsStack171996f0ab1383f16ab66b099e061473)) { $__attrs171996f0ab1383f16ab66b099e061473 = array_pop($__attrsStack171996f0ab1383f16ab66b099e061473); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php ENDPATH**/ ?>