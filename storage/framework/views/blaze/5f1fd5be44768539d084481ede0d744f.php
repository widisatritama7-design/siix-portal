<?php
if (!function_exists('__5f1fd5be44768539d084481ede0d744f')):
function __5f1fd5be44768539d084481ede0d744f($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/field.blade.php', $__blaze->compiledPath.'/791aabb0f0d190e7ee4ce1fa39082fe5.php'); ?>
<?php if (isset($__slots791aabb0f0d190e7ee4ce1fa39082fe5)) { $__slotsStack791aabb0f0d190e7ee4ce1fa39082fe5[] = $__slots791aabb0f0d190e7ee4ce1fa39082fe5; } ?>
<?php if (isset($__attrs791aabb0f0d190e7ee4ce1fa39082fe5)) { $__attrsStack791aabb0f0d190e7ee4ce1fa39082fe5[] = $__attrs791aabb0f0d190e7ee4ce1fa39082fe5; } ?>
<?php $__attrs791aabb0f0d190e7ee4ce1fa39082fe5 = ['attributes' => $fieldAttributes]; ?>
<?php $__slots791aabb0f0d190e7ee4ce1fa39082fe5 = []; ?>
<?php $__blaze->pushData($__attrs791aabb0f0d190e7ee4ce1fa39082fe5); ?>
<?php ob_start(); ?>
        <?php if (isset($label)): ?>
            <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/label.blade.php', $__blaze->compiledPath.'/3818f0862bc40240229d7dea81438887.php'); ?>
<?php if (isset($__slots3818f0862bc40240229d7dea81438887)) { $__slotsStack3818f0862bc40240229d7dea81438887[] = $__slots3818f0862bc40240229d7dea81438887; } ?>
<?php if (isset($__attrs3818f0862bc40240229d7dea81438887)) { $__attrsStack3818f0862bc40240229d7dea81438887[] = $__attrs3818f0862bc40240229d7dea81438887; } ?>
<?php $__attrs3818f0862bc40240229d7dea81438887 = ['attributes' => $labelAttributes]; ?>
<?php $__slots3818f0862bc40240229d7dea81438887 = []; ?>
<?php $__blaze->pushData($__attrs3818f0862bc40240229d7dea81438887); ?>
<?php ob_start(); ?><?php echo e($label); ?><?php $__slots3818f0862bc40240229d7dea81438887['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots3818f0862bc40240229d7dea81438887); ?>
<?php __3818f0862bc40240229d7dea81438887($__blaze, $__attrs3818f0862bc40240229d7dea81438887, $__slots3818f0862bc40240229d7dea81438887, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3818f0862bc40240229d7dea81438887)) { $__slots3818f0862bc40240229d7dea81438887 = array_pop($__slotsStack3818f0862bc40240229d7dea81438887); } ?>
<?php if (! empty($__attrsStack3818f0862bc40240229d7dea81438887)) { $__attrs3818f0862bc40240229d7dea81438887 = array_pop($__attrsStack3818f0862bc40240229d7dea81438887); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php if (isset($description)): ?>
            <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/description.blade.php', $__blaze->compiledPath.'/e1c60be0900d9405556cf5c62c3c5825.php'); ?>
<?php if (isset($__slotse1c60be0900d9405556cf5c62c3c5825)) { $__slotsStacke1c60be0900d9405556cf5c62c3c5825[] = $__slotse1c60be0900d9405556cf5c62c3c5825; } ?>
<?php if (isset($__attrse1c60be0900d9405556cf5c62c3c5825)) { $__attrsStacke1c60be0900d9405556cf5c62c3c5825[] = $__attrse1c60be0900d9405556cf5c62c3c5825; } ?>
<?php $__attrse1c60be0900d9405556cf5c62c3c5825 = ['attributes' => $descriptionAttributes]; ?>
<?php $__slotse1c60be0900d9405556cf5c62c3c5825 = []; ?>
<?php $__blaze->pushData($__attrse1c60be0900d9405556cf5c62c3c5825); ?>
<?php ob_start(); ?><?php echo e($description); ?><?php $__slotse1c60be0900d9405556cf5c62c3c5825['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotse1c60be0900d9405556cf5c62c3c5825); ?>
<?php __e1c60be0900d9405556cf5c62c3c5825($__blaze, $__attrse1c60be0900d9405556cf5c62c3c5825, $__slotse1c60be0900d9405556cf5c62c3c5825, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacke1c60be0900d9405556cf5c62c3c5825)) { $__slotse1c60be0900d9405556cf5c62c3c5825 = array_pop($__slotsStacke1c60be0900d9405556cf5c62c3c5825); } ?>
<?php if (! empty($__attrsStacke1c60be0900d9405556cf5c62c3c5825)) { $__attrse1c60be0900d9405556cf5c62c3c5825 = array_pop($__attrsStacke1c60be0900d9405556cf5c62c3c5825); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php echo e($slot); ?>


        
        [STARTCOMPILEDUNBLAZE:esGpNJ3chT]<?php \Livewire\Blaze\Unblaze::storeScope("esGpNJ3chT", scope: ['attributes' => $errorAttributes->getAttributes()]) ?>[ENDCOMPILEDUNBLAZE:esGpNJ3chT]

        <?php if (isset($descriptionTrailing)): ?>
            <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/description.blade.php', $__blaze->compiledPath.'/e1c60be0900d9405556cf5c62c3c5825.php'); ?>
<?php if (isset($__slotse1c60be0900d9405556cf5c62c3c5825)) { $__slotsStacke1c60be0900d9405556cf5c62c3c5825[] = $__slotse1c60be0900d9405556cf5c62c3c5825; } ?>
<?php if (isset($__attrse1c60be0900d9405556cf5c62c3c5825)) { $__attrsStacke1c60be0900d9405556cf5c62c3c5825[] = $__attrse1c60be0900d9405556cf5c62c3c5825; } ?>
<?php $__attrse1c60be0900d9405556cf5c62c3c5825 = ['attributes' => $descriptionAttributes]; ?>
<?php $__slotse1c60be0900d9405556cf5c62c3c5825 = []; ?>
<?php $__blaze->pushData($__attrse1c60be0900d9405556cf5c62c3c5825); ?>
<?php ob_start(); ?><?php echo e($descriptionTrailing); ?><?php $__slotse1c60be0900d9405556cf5c62c3c5825['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotse1c60be0900d9405556cf5c62c3c5825); ?>
<?php __e1c60be0900d9405556cf5c62c3c5825($__blaze, $__attrse1c60be0900d9405556cf5c62c3c5825, $__slotse1c60be0900d9405556cf5c62c3c5825, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacke1c60be0900d9405556cf5c62c3c5825)) { $__slotse1c60be0900d9405556cf5c62c3c5825 = array_pop($__slotsStacke1c60be0900d9405556cf5c62c3c5825); } ?>
<?php if (! empty($__attrsStacke1c60be0900d9405556cf5c62c3c5825)) { $__attrse1c60be0900d9405556cf5c62c3c5825 = array_pop($__attrsStacke1c60be0900d9405556cf5c62c3c5825); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    <?php $__slots791aabb0f0d190e7ee4ce1fa39082fe5['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots791aabb0f0d190e7ee4ce1fa39082fe5); ?>
<?php __791aabb0f0d190e7ee4ce1fa39082fe5($__blaze, $__attrs791aabb0f0d190e7ee4ce1fa39082fe5, $__slots791aabb0f0d190e7ee4ce1fa39082fe5, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack791aabb0f0d190e7ee4ce1fa39082fe5)) { $__slots791aabb0f0d190e7ee4ce1fa39082fe5 = array_pop($__slotsStack791aabb0f0d190e7ee4ce1fa39082fe5); } ?>
<?php if (! empty($__attrsStack791aabb0f0d190e7ee4ce1fa39082fe5)) { $__attrs791aabb0f0d190e7ee4ce1fa39082fe5 = array_pop($__attrsStack791aabb0f0d190e7ee4ce1fa39082fe5); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-field.blade.php ENDPATH**/ ?>