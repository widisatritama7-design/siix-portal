<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('_cff1c71bac828e48284939dd973e7838')):
function _cff1c71bac828e48284939dd973e7838($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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

<?php if (isset($label) || isset($description) || isset($descriptionTrailing)): ?>
    <?php

        $fieldAttributes = Flux::attributesAfter('field:', $attributes, []);
        $labelAttributes = Flux::attributesAfter('label:', $attributes, ['badge' => $badge]);
        $descriptionAttributes = Flux::attributesAfter('description:', $attributes, []);
        $errorAttributes = Flux::attributesAfter('error:', $attributes, ['name' => $name]);
    ?>
    <?php if (!function_exists('_d8a851730c1134dee4e38de33e14845b')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/field.blade.php'); } ?>
<?php if (isset($__slotsd8a851730c1134dee4e38de33e14845b)) { $__slotsStackd8a851730c1134dee4e38de33e14845b[] = $__slotsd8a851730c1134dee4e38de33e14845b; } ?>
<?php if (isset($__datad8a851730c1134dee4e38de33e14845b)) { $__dataStackd8a851730c1134dee4e38de33e14845b[] = $__datad8a851730c1134dee4e38de33e14845b; } ?>
<?php $__datad8a851730c1134dee4e38de33e14845b = ['attributes' => $fieldAttributes]; ?>
<?php $__slotsd8a851730c1134dee4e38de33e14845b = []; ?>
<?php $__blaze->pushData($__datad8a851730c1134dee4e38de33e14845b); ?>
<?php ob_start(); ?>
        <?php if (isset($label)): ?>
            <?php if (!function_exists('_254466cfa98db1c248eb2e7999112b28')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/label.blade.php'); } ?>
<?php if (isset($__slots254466cfa98db1c248eb2e7999112b28)) { $__slotsStack254466cfa98db1c248eb2e7999112b28[] = $__slots254466cfa98db1c248eb2e7999112b28; } ?>
<?php if (isset($__data254466cfa98db1c248eb2e7999112b28)) { $__dataStack254466cfa98db1c248eb2e7999112b28[] = $__data254466cfa98db1c248eb2e7999112b28; } ?>
<?php $__data254466cfa98db1c248eb2e7999112b28 = ['attributes' => $labelAttributes]; ?>
<?php $__slots254466cfa98db1c248eb2e7999112b28 = []; ?>
<?php $__blaze->pushData($__data254466cfa98db1c248eb2e7999112b28); ?>
<?php ob_start(); ?><?php echo e($label); ?><?php $__slots254466cfa98db1c248eb2e7999112b28['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots254466cfa98db1c248eb2e7999112b28); ?>
<?php _254466cfa98db1c248eb2e7999112b28($__blaze, $__data254466cfa98db1c248eb2e7999112b28, $__blaze->mergeAttributes(['attributes' => $__data254466cfa98db1c248eb2e7999112b28['attributes']]), $__slots254466cfa98db1c248eb2e7999112b28, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack254466cfa98db1c248eb2e7999112b28)) { $__slots254466cfa98db1c248eb2e7999112b28 = array_pop($__slotsStack254466cfa98db1c248eb2e7999112b28); } ?>
<?php if (! empty($__dataStack254466cfa98db1c248eb2e7999112b28)) { $__data254466cfa98db1c248eb2e7999112b28 = array_pop($__dataStack254466cfa98db1c248eb2e7999112b28); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php if (isset($description)): ?>
            <?php if (!function_exists('_a88455538fd6a39a73b5b72022993413')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/description.blade.php'); } ?>
<?php if (isset($__slotsa88455538fd6a39a73b5b72022993413)) { $__slotsStacka88455538fd6a39a73b5b72022993413[] = $__slotsa88455538fd6a39a73b5b72022993413; } ?>
<?php if (isset($__dataa88455538fd6a39a73b5b72022993413)) { $__dataStacka88455538fd6a39a73b5b72022993413[] = $__dataa88455538fd6a39a73b5b72022993413; } ?>
<?php $__dataa88455538fd6a39a73b5b72022993413 = ['attributes' => $descriptionAttributes]; ?>
<?php $__slotsa88455538fd6a39a73b5b72022993413 = []; ?>
<?php $__blaze->pushData($__dataa88455538fd6a39a73b5b72022993413); ?>
<?php ob_start(); ?><?php echo e($description); ?><?php $__slotsa88455538fd6a39a73b5b72022993413['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsa88455538fd6a39a73b5b72022993413); ?>
<?php _a88455538fd6a39a73b5b72022993413($__blaze, $__dataa88455538fd6a39a73b5b72022993413, $__blaze->mergeAttributes(['attributes' => $__dataa88455538fd6a39a73b5b72022993413['attributes']]), $__slotsa88455538fd6a39a73b5b72022993413, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacka88455538fd6a39a73b5b72022993413)) { $__slotsa88455538fd6a39a73b5b72022993413 = array_pop($__slotsStacka88455538fd6a39a73b5b72022993413); } ?>
<?php if (! empty($__dataStacka88455538fd6a39a73b5b72022993413)) { $__dataa88455538fd6a39a73b5b72022993413 = array_pop($__dataStacka88455538fd6a39a73b5b72022993413); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php echo e($slot); ?>


        
        <?php $__getScope = fn($scope = []) => $scope; ?><?php if (isset($scope)) $__scope = $scope; ?><?php $scope = $__getScope(scope: ['attributes' => $errorAttributes->getAttributes()]); ?>
        <?php if (!function_exists('_17e5beb5303e2b5c75b3843aac74986d')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php'); } ?>
<?php $__componentData = ['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _17e5beb5303e2b5c75b3843aac74986d($__blaze, $__componentData, $__blaze->mergeAttributes(['attributes' => $__componentData['attributes']]), [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
        <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>

        <?php if (isset($descriptionTrailing)): ?>
            <?php if (!function_exists('_a88455538fd6a39a73b5b72022993413')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/description.blade.php'); } ?>
<?php if (isset($__slotsa88455538fd6a39a73b5b72022993413)) { $__slotsStacka88455538fd6a39a73b5b72022993413[] = $__slotsa88455538fd6a39a73b5b72022993413; } ?>
<?php if (isset($__dataa88455538fd6a39a73b5b72022993413)) { $__dataStacka88455538fd6a39a73b5b72022993413[] = $__dataa88455538fd6a39a73b5b72022993413; } ?>
<?php $__dataa88455538fd6a39a73b5b72022993413 = ['attributes' => $descriptionAttributes]; ?>
<?php $__slotsa88455538fd6a39a73b5b72022993413 = []; ?>
<?php $__blaze->pushData($__dataa88455538fd6a39a73b5b72022993413); ?>
<?php ob_start(); ?><?php echo e($descriptionTrailing); ?><?php $__slotsa88455538fd6a39a73b5b72022993413['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsa88455538fd6a39a73b5b72022993413); ?>
<?php _a88455538fd6a39a73b5b72022993413($__blaze, $__dataa88455538fd6a39a73b5b72022993413, $__blaze->mergeAttributes(['attributes' => $__dataa88455538fd6a39a73b5b72022993413['attributes']]), $__slotsa88455538fd6a39a73b5b72022993413, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacka88455538fd6a39a73b5b72022993413)) { $__slotsa88455538fd6a39a73b5b72022993413 = array_pop($__slotsStacka88455538fd6a39a73b5b72022993413); } ?>
<?php if (! empty($__dataStacka88455538fd6a39a73b5b72022993413)) { $__dataa88455538fd6a39a73b5b72022993413 = array_pop($__dataStacka88455538fd6a39a73b5b72022993413); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    <?php $__slotsd8a851730c1134dee4e38de33e14845b['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsd8a851730c1134dee4e38de33e14845b); ?>
<?php _d8a851730c1134dee4e38de33e14845b($__blaze, $__datad8a851730c1134dee4e38de33e14845b, $__blaze->mergeAttributes(['attributes' => $__datad8a851730c1134dee4e38de33e14845b['attributes']]), $__slotsd8a851730c1134dee4e38de33e14845b, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackd8a851730c1134dee4e38de33e14845b)) { $__slotsd8a851730c1134dee4e38de33e14845b = array_pop($__slotsStackd8a851730c1134dee4e38de33e14845b); } ?>
<?php if (! empty($__dataStackd8a851730c1134dee4e38de33e14845b)) { $__datad8a851730c1134dee4e38de33e14845b = array_pop($__dataStackd8a851730c1134dee4e38de33e14845b); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php ENDPATH**/ ?>