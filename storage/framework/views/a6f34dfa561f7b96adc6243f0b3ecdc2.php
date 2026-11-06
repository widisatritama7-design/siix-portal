<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('_cc94b751a6dbee3c6cddb4c1c630c48a')):
function _cc94b751a6dbee3c6cddb4c1c630c48a($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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
    <?php if (!function_exists('_904f1b44c1d20c7cb0a6083c44f5fb0c')) { require $__blaze->compile('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/field.blade.php'); } ?>
<?php if (isset($__slots904f1b44c1d20c7cb0a6083c44f5fb0c)) { $__slotsStack904f1b44c1d20c7cb0a6083c44f5fb0c[] = $__slots904f1b44c1d20c7cb0a6083c44f5fb0c; } ?>
<?php if (isset($__data904f1b44c1d20c7cb0a6083c44f5fb0c)) { $__dataStack904f1b44c1d20c7cb0a6083c44f5fb0c[] = $__data904f1b44c1d20c7cb0a6083c44f5fb0c; } ?>
<?php $__data904f1b44c1d20c7cb0a6083c44f5fb0c = ['attributes' => $fieldAttributes]; ?>
<?php $__slots904f1b44c1d20c7cb0a6083c44f5fb0c = []; ?>
<?php $__blaze->pushData($__data904f1b44c1d20c7cb0a6083c44f5fb0c); ?>
<?php ob_start(); ?>
        <?php if (isset($label)): ?>
            <?php if (!function_exists('_ba3c6336d2bded6d6fc324311decc418')) { require $__blaze->compile('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/label.blade.php'); } ?>
<?php if (isset($__slotsba3c6336d2bded6d6fc324311decc418)) { $__slotsStackba3c6336d2bded6d6fc324311decc418[] = $__slotsba3c6336d2bded6d6fc324311decc418; } ?>
<?php if (isset($__databa3c6336d2bded6d6fc324311decc418)) { $__dataStackba3c6336d2bded6d6fc324311decc418[] = $__databa3c6336d2bded6d6fc324311decc418; } ?>
<?php $__databa3c6336d2bded6d6fc324311decc418 = ['attributes' => $labelAttributes]; ?>
<?php $__slotsba3c6336d2bded6d6fc324311decc418 = []; ?>
<?php $__blaze->pushData($__databa3c6336d2bded6d6fc324311decc418); ?>
<?php ob_start(); ?><?php echo e($label); ?><?php $__slotsba3c6336d2bded6d6fc324311decc418['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsba3c6336d2bded6d6fc324311decc418); ?>
<?php _ba3c6336d2bded6d6fc324311decc418($__blaze, $__databa3c6336d2bded6d6fc324311decc418, $__blaze->mergeAttributes(['attributes' => $__databa3c6336d2bded6d6fc324311decc418['attributes']]), $__slotsba3c6336d2bded6d6fc324311decc418, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackba3c6336d2bded6d6fc324311decc418)) { $__slotsba3c6336d2bded6d6fc324311decc418 = array_pop($__slotsStackba3c6336d2bded6d6fc324311decc418); } ?>
<?php if (! empty($__dataStackba3c6336d2bded6d6fc324311decc418)) { $__databa3c6336d2bded6d6fc324311decc418 = array_pop($__dataStackba3c6336d2bded6d6fc324311decc418); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php if (isset($description)): ?>
            <?php if (!function_exists('_cdcb47fe6585a9d7a6f206c21e05c9b6')) { require $__blaze->compile('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/description.blade.php'); } ?>
<?php if (isset($__slotscdcb47fe6585a9d7a6f206c21e05c9b6)) { $__slotsStackcdcb47fe6585a9d7a6f206c21e05c9b6[] = $__slotscdcb47fe6585a9d7a6f206c21e05c9b6; } ?>
<?php if (isset($__datacdcb47fe6585a9d7a6f206c21e05c9b6)) { $__dataStackcdcb47fe6585a9d7a6f206c21e05c9b6[] = $__datacdcb47fe6585a9d7a6f206c21e05c9b6; } ?>
<?php $__datacdcb47fe6585a9d7a6f206c21e05c9b6 = ['attributes' => $descriptionAttributes]; ?>
<?php $__slotscdcb47fe6585a9d7a6f206c21e05c9b6 = []; ?>
<?php $__blaze->pushData($__datacdcb47fe6585a9d7a6f206c21e05c9b6); ?>
<?php ob_start(); ?><?php echo e($description); ?><?php $__slotscdcb47fe6585a9d7a6f206c21e05c9b6['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotscdcb47fe6585a9d7a6f206c21e05c9b6); ?>
<?php _cdcb47fe6585a9d7a6f206c21e05c9b6($__blaze, $__datacdcb47fe6585a9d7a6f206c21e05c9b6, $__blaze->mergeAttributes(['attributes' => $__datacdcb47fe6585a9d7a6f206c21e05c9b6['attributes']]), $__slotscdcb47fe6585a9d7a6f206c21e05c9b6, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackcdcb47fe6585a9d7a6f206c21e05c9b6)) { $__slotscdcb47fe6585a9d7a6f206c21e05c9b6 = array_pop($__slotsStackcdcb47fe6585a9d7a6f206c21e05c9b6); } ?>
<?php if (! empty($__dataStackcdcb47fe6585a9d7a6f206c21e05c9b6)) { $__datacdcb47fe6585a9d7a6f206c21e05c9b6 = array_pop($__dataStackcdcb47fe6585a9d7a6f206c21e05c9b6); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php echo e($slot); ?>


        
        <?php $__getScope = fn($scope = []) => $scope; ?><?php if (isset($scope)) $__scope = $scope; ?><?php $scope = $__getScope(scope: ['attributes' => $errorAttributes->getAttributes()]); ?>
        <?php if (!function_exists('_f1c155d04814627ff31679dbe511a628')) { require $__blaze->compile('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/error.blade.php'); } ?>
<?php $__componentData = ['attributes' => new \Illuminate\View\ComponentAttributeBag($scope['attributes'])]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _f1c155d04814627ff31679dbe511a628($__blaze, $__componentData, $__blaze->mergeAttributes(['attributes' => $__componentData['attributes']]), [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
        <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>

        <?php if (isset($descriptionTrailing)): ?>
            <?php if (!function_exists('_cdcb47fe6585a9d7a6f206c21e05c9b6')) { require $__blaze->compile('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/description.blade.php'); } ?>
<?php if (isset($__slotscdcb47fe6585a9d7a6f206c21e05c9b6)) { $__slotsStackcdcb47fe6585a9d7a6f206c21e05c9b6[] = $__slotscdcb47fe6585a9d7a6f206c21e05c9b6; } ?>
<?php if (isset($__datacdcb47fe6585a9d7a6f206c21e05c9b6)) { $__dataStackcdcb47fe6585a9d7a6f206c21e05c9b6[] = $__datacdcb47fe6585a9d7a6f206c21e05c9b6; } ?>
<?php $__datacdcb47fe6585a9d7a6f206c21e05c9b6 = ['attributes' => $descriptionAttributes]; ?>
<?php $__slotscdcb47fe6585a9d7a6f206c21e05c9b6 = []; ?>
<?php $__blaze->pushData($__datacdcb47fe6585a9d7a6f206c21e05c9b6); ?>
<?php ob_start(); ?><?php echo e($descriptionTrailing); ?><?php $__slotscdcb47fe6585a9d7a6f206c21e05c9b6['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotscdcb47fe6585a9d7a6f206c21e05c9b6); ?>
<?php _cdcb47fe6585a9d7a6f206c21e05c9b6($__blaze, $__datacdcb47fe6585a9d7a6f206c21e05c9b6, $__blaze->mergeAttributes(['attributes' => $__datacdcb47fe6585a9d7a6f206c21e05c9b6['attributes']]), $__slotscdcb47fe6585a9d7a6f206c21e05c9b6, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackcdcb47fe6585a9d7a6f206c21e05c9b6)) { $__slotscdcb47fe6585a9d7a6f206c21e05c9b6 = array_pop($__slotsStackcdcb47fe6585a9d7a6f206c21e05c9b6); } ?>
<?php if (! empty($__dataStackcdcb47fe6585a9d7a6f206c21e05c9b6)) { $__datacdcb47fe6585a9d7a6f206c21e05c9b6 = array_pop($__dataStackcdcb47fe6585a9d7a6f206c21e05c9b6); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    <?php $__slots904f1b44c1d20c7cb0a6083c44f5fb0c['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots904f1b44c1d20c7cb0a6083c44f5fb0c); ?>
<?php _904f1b44c1d20c7cb0a6083c44f5fb0c($__blaze, $__data904f1b44c1d20c7cb0a6083c44f5fb0c, $__blaze->mergeAttributes(['attributes' => $__data904f1b44c1d20c7cb0a6083c44f5fb0c['attributes']]), $__slots904f1b44c1d20c7cb0a6083c44f5fb0c, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack904f1b44c1d20c7cb0a6083c44f5fb0c)) { $__slots904f1b44c1d20c7cb0a6083c44f5fb0c = array_pop($__slotsStack904f1b44c1d20c7cb0a6083c44f5fb0c); } ?>
<?php if (! empty($__dataStack904f1b44c1d20c7cb0a6083c44f5fb0c)) { $__data904f1b44c1d20c7cb0a6083c44f5fb0c = array_pop($__dataStack904f1b44c1d20c7cb0a6083c44f5fb0c); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-field.blade.php ENDPATH**/ ?>