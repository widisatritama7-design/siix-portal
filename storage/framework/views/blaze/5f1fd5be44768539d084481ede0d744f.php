<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__b119ceb1b9a3e04beca2cedd1073790a')):
function __b119ceb1b9a3e04beca2cedd1073790a($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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
    <?php if (!function_exists('__f6b5bd8232297581696809b9c29b3dd4')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/field.blade.php'); } ?>
<?php if (isset($__slotsf6b5bd8232297581696809b9c29b3dd4)) { $__slotsStackf6b5bd8232297581696809b9c29b3dd4[] = $__slotsf6b5bd8232297581696809b9c29b3dd4; } ?>
<?php if (isset($__dataf6b5bd8232297581696809b9c29b3dd4)) { $__dataStackf6b5bd8232297581696809b9c29b3dd4[] = $__dataf6b5bd8232297581696809b9c29b3dd4; } ?>
<?php $__dataf6b5bd8232297581696809b9c29b3dd4 = ['attributes' => $fieldAttributes]; ?>
<?php $__slotsf6b5bd8232297581696809b9c29b3dd4 = []; ?>
<?php $__blaze->pushData($__dataf6b5bd8232297581696809b9c29b3dd4); ?>
<?php ob_start(); ?>
        <?php if (isset($label)): ?>
            <?php if (!function_exists('__48ea9f6f8223a6a3ce1ae5ee0da15111')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/label.blade.php'); } ?>
<?php if (isset($__slots48ea9f6f8223a6a3ce1ae5ee0da15111)) { $__slotsStack48ea9f6f8223a6a3ce1ae5ee0da15111[] = $__slots48ea9f6f8223a6a3ce1ae5ee0da15111; } ?>
<?php if (isset($__data48ea9f6f8223a6a3ce1ae5ee0da15111)) { $__dataStack48ea9f6f8223a6a3ce1ae5ee0da15111[] = $__data48ea9f6f8223a6a3ce1ae5ee0da15111; } ?>
<?php $__data48ea9f6f8223a6a3ce1ae5ee0da15111 = ['attributes' => $labelAttributes]; ?>
<?php $__slots48ea9f6f8223a6a3ce1ae5ee0da15111 = []; ?>
<?php $__blaze->pushData($__data48ea9f6f8223a6a3ce1ae5ee0da15111); ?>
<?php ob_start(); ?><?php echo e($label); ?><?php $__slots48ea9f6f8223a6a3ce1ae5ee0da15111['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots48ea9f6f8223a6a3ce1ae5ee0da15111); ?>
<?php __48ea9f6f8223a6a3ce1ae5ee0da15111($__blaze, $__data48ea9f6f8223a6a3ce1ae5ee0da15111, $__blaze->mergeAttributes(['attributes' => $__data48ea9f6f8223a6a3ce1ae5ee0da15111['attributes']]), $__slots48ea9f6f8223a6a3ce1ae5ee0da15111, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack48ea9f6f8223a6a3ce1ae5ee0da15111)) { $__slots48ea9f6f8223a6a3ce1ae5ee0da15111 = array_pop($__slotsStack48ea9f6f8223a6a3ce1ae5ee0da15111); } ?>
<?php if (! empty($__dataStack48ea9f6f8223a6a3ce1ae5ee0da15111)) { $__data48ea9f6f8223a6a3ce1ae5ee0da15111 = array_pop($__dataStack48ea9f6f8223a6a3ce1ae5ee0da15111); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php if (isset($description)): ?>
            <?php if (!function_exists('__302308ae9f8c61f39bfff88534b4b83c')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/description.blade.php'); } ?>
<?php if (isset($__slots302308ae9f8c61f39bfff88534b4b83c)) { $__slotsStack302308ae9f8c61f39bfff88534b4b83c[] = $__slots302308ae9f8c61f39bfff88534b4b83c; } ?>
<?php if (isset($__data302308ae9f8c61f39bfff88534b4b83c)) { $__dataStack302308ae9f8c61f39bfff88534b4b83c[] = $__data302308ae9f8c61f39bfff88534b4b83c; } ?>
<?php $__data302308ae9f8c61f39bfff88534b4b83c = ['attributes' => $descriptionAttributes]; ?>
<?php $__slots302308ae9f8c61f39bfff88534b4b83c = []; ?>
<?php $__blaze->pushData($__data302308ae9f8c61f39bfff88534b4b83c); ?>
<?php ob_start(); ?><?php echo e($description); ?><?php $__slots302308ae9f8c61f39bfff88534b4b83c['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots302308ae9f8c61f39bfff88534b4b83c); ?>
<?php __302308ae9f8c61f39bfff88534b4b83c($__blaze, $__data302308ae9f8c61f39bfff88534b4b83c, $__blaze->mergeAttributes(['attributes' => $__data302308ae9f8c61f39bfff88534b4b83c['attributes']]), $__slots302308ae9f8c61f39bfff88534b4b83c, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack302308ae9f8c61f39bfff88534b4b83c)) { $__slots302308ae9f8c61f39bfff88534b4b83c = array_pop($__slotsStack302308ae9f8c61f39bfff88534b4b83c); } ?>
<?php if (! empty($__dataStack302308ae9f8c61f39bfff88534b4b83c)) { $__data302308ae9f8c61f39bfff88534b4b83c = array_pop($__dataStack302308ae9f8c61f39bfff88534b4b83c); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php echo e($slot); ?>


        
        [STARTCOMPILEDUNBLAZE:17EFfXwLMJ]<?php \Livewire\Blaze\Unblaze::storeScope("17EFfXwLMJ", scope: ['attributes' => $errorAttributes->getAttributes()]) ?><?php \Livewire\Blaze\Unblaze::storeReplacement("17EFfXwLMJ", "CiAgICAgICAgPGZsdXg6ZXJyb3IgOmF0dHJpYnV0ZXM9Im5ldyBcSWxsdW1pbmF0ZVxWaWV3XENvbXBvbmVudEF0dHJpYnV0ZUJhZygkc2NvcGVbJ2F0dHJpYnV0ZXMnXSkiIC8+CiAgICAgICAg") ?>[ENDCOMPILEDUNBLAZE:17EFfXwLMJ]

        <?php if (isset($descriptionTrailing)): ?>
            <?php if (!function_exists('__302308ae9f8c61f39bfff88534b4b83c')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/description.blade.php'); } ?>
<?php if (isset($__slots302308ae9f8c61f39bfff88534b4b83c)) { $__slotsStack302308ae9f8c61f39bfff88534b4b83c[] = $__slots302308ae9f8c61f39bfff88534b4b83c; } ?>
<?php if (isset($__data302308ae9f8c61f39bfff88534b4b83c)) { $__dataStack302308ae9f8c61f39bfff88534b4b83c[] = $__data302308ae9f8c61f39bfff88534b4b83c; } ?>
<?php $__data302308ae9f8c61f39bfff88534b4b83c = ['attributes' => $descriptionAttributes]; ?>
<?php $__slots302308ae9f8c61f39bfff88534b4b83c = []; ?>
<?php $__blaze->pushData($__data302308ae9f8c61f39bfff88534b4b83c); ?>
<?php ob_start(); ?><?php echo e($descriptionTrailing); ?><?php $__slots302308ae9f8c61f39bfff88534b4b83c['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots302308ae9f8c61f39bfff88534b4b83c); ?>
<?php __302308ae9f8c61f39bfff88534b4b83c($__blaze, $__data302308ae9f8c61f39bfff88534b4b83c, $__blaze->mergeAttributes(['attributes' => $__data302308ae9f8c61f39bfff88534b4b83c['attributes']]), $__slots302308ae9f8c61f39bfff88534b4b83c, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack302308ae9f8c61f39bfff88534b4b83c)) { $__slots302308ae9f8c61f39bfff88534b4b83c = array_pop($__slotsStack302308ae9f8c61f39bfff88534b4b83c); } ?>
<?php if (! empty($__dataStack302308ae9f8c61f39bfff88534b4b83c)) { $__data302308ae9f8c61f39bfff88534b4b83c = array_pop($__dataStack302308ae9f8c61f39bfff88534b4b83c); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    <?php $__slotsf6b5bd8232297581696809b9c29b3dd4['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsf6b5bd8232297581696809b9c29b3dd4); ?>
<?php __f6b5bd8232297581696809b9c29b3dd4($__blaze, $__dataf6b5bd8232297581696809b9c29b3dd4, $__blaze->mergeAttributes(['attributes' => $__dataf6b5bd8232297581696809b9c29b3dd4['attributes']]), $__slotsf6b5bd8232297581696809b9c29b3dd4, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackf6b5bd8232297581696809b9c29b3dd4)) { $__slotsf6b5bd8232297581696809b9c29b3dd4 = array_pop($__slotsStackf6b5bd8232297581696809b9c29b3dd4); } ?>
<?php if (! empty($__dataStackf6b5bd8232297581696809b9c29b3dd4)) { $__dataf6b5bd8232297581696809b9c29b3dd4 = array_pop($__dataStackf6b5bd8232297581696809b9c29b3dd4); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-field.blade.php ENDPATH**/ ?>