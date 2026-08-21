<?php
if (!function_exists('__a6f34dfa561f7b96adc6243f0b3ecdc2')):
function __a6f34dfa561f7b96adc6243f0b3ecdc2($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/field.blade.php', $__blaze->compiledPath.'/ae68517bb65bf5b76c1945a6652ef67d.php'); ?>
<?php if (isset($__slotsae68517bb65bf5b76c1945a6652ef67d)) { $__slotsStackae68517bb65bf5b76c1945a6652ef67d[] = $__slotsae68517bb65bf5b76c1945a6652ef67d; } ?>
<?php if (isset($__attrsae68517bb65bf5b76c1945a6652ef67d)) { $__attrsStackae68517bb65bf5b76c1945a6652ef67d[] = $__attrsae68517bb65bf5b76c1945a6652ef67d; } ?>
<?php $__attrsae68517bb65bf5b76c1945a6652ef67d = ['attributes' => $fieldAttributes]; ?>
<?php $__slotsae68517bb65bf5b76c1945a6652ef67d = []; ?>
<?php $__blaze->pushData($__attrsae68517bb65bf5b76c1945a6652ef67d); ?>
<?php ob_start(); ?>
        <?php if (isset($label)): ?>
            <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/label.blade.php', $__blaze->compiledPath.'/6e3df0cbb45590d4e257d5a3f5651198.php'); ?>
<?php if (isset($__slots6e3df0cbb45590d4e257d5a3f5651198)) { $__slotsStack6e3df0cbb45590d4e257d5a3f5651198[] = $__slots6e3df0cbb45590d4e257d5a3f5651198; } ?>
<?php if (isset($__attrs6e3df0cbb45590d4e257d5a3f5651198)) { $__attrsStack6e3df0cbb45590d4e257d5a3f5651198[] = $__attrs6e3df0cbb45590d4e257d5a3f5651198; } ?>
<?php $__attrs6e3df0cbb45590d4e257d5a3f5651198 = ['attributes' => $labelAttributes]; ?>
<?php $__slots6e3df0cbb45590d4e257d5a3f5651198 = []; ?>
<?php $__blaze->pushData($__attrs6e3df0cbb45590d4e257d5a3f5651198); ?>
<?php ob_start(); ?><?php echo e($label); ?><?php $__slots6e3df0cbb45590d4e257d5a3f5651198['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots6e3df0cbb45590d4e257d5a3f5651198); ?>
<?php __6e3df0cbb45590d4e257d5a3f5651198($__blaze, $__attrs6e3df0cbb45590d4e257d5a3f5651198, $__slots6e3df0cbb45590d4e257d5a3f5651198, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack6e3df0cbb45590d4e257d5a3f5651198)) { $__slots6e3df0cbb45590d4e257d5a3f5651198 = array_pop($__slotsStack6e3df0cbb45590d4e257d5a3f5651198); } ?>
<?php if (! empty($__attrsStack6e3df0cbb45590d4e257d5a3f5651198)) { $__attrs6e3df0cbb45590d4e257d5a3f5651198 = array_pop($__attrsStack6e3df0cbb45590d4e257d5a3f5651198); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php if (isset($description)): ?>
            <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/description.blade.php', $__blaze->compiledPath.'/29c3d8109a289c19704a8e2262d784ec.php'); ?>
<?php if (isset($__slots29c3d8109a289c19704a8e2262d784ec)) { $__slotsStack29c3d8109a289c19704a8e2262d784ec[] = $__slots29c3d8109a289c19704a8e2262d784ec; } ?>
<?php if (isset($__attrs29c3d8109a289c19704a8e2262d784ec)) { $__attrsStack29c3d8109a289c19704a8e2262d784ec[] = $__attrs29c3d8109a289c19704a8e2262d784ec; } ?>
<?php $__attrs29c3d8109a289c19704a8e2262d784ec = ['attributes' => $descriptionAttributes]; ?>
<?php $__slots29c3d8109a289c19704a8e2262d784ec = []; ?>
<?php $__blaze->pushData($__attrs29c3d8109a289c19704a8e2262d784ec); ?>
<?php ob_start(); ?><?php echo e($description); ?><?php $__slots29c3d8109a289c19704a8e2262d784ec['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots29c3d8109a289c19704a8e2262d784ec); ?>
<?php __29c3d8109a289c19704a8e2262d784ec($__blaze, $__attrs29c3d8109a289c19704a8e2262d784ec, $__slots29c3d8109a289c19704a8e2262d784ec, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack29c3d8109a289c19704a8e2262d784ec)) { $__slots29c3d8109a289c19704a8e2262d784ec = array_pop($__slotsStack29c3d8109a289c19704a8e2262d784ec); } ?>
<?php if (! empty($__attrsStack29c3d8109a289c19704a8e2262d784ec)) { $__attrs29c3d8109a289c19704a8e2262d784ec = array_pop($__attrsStack29c3d8109a289c19704a8e2262d784ec); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php echo e($slot); ?>


        
        [STARTCOMPILEDUNBLAZE:Vwo5oTc0LP]<?php \Livewire\Blaze\Unblaze::storeScope("Vwo5oTc0LP", scope: ['attributes' => $errorAttributes->getAttributes()]) ?>[ENDCOMPILEDUNBLAZE:Vwo5oTc0LP]

        <?php if (isset($descriptionTrailing)): ?>
            <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/description.blade.php', $__blaze->compiledPath.'/29c3d8109a289c19704a8e2262d784ec.php'); ?>
<?php if (isset($__slots29c3d8109a289c19704a8e2262d784ec)) { $__slotsStack29c3d8109a289c19704a8e2262d784ec[] = $__slots29c3d8109a289c19704a8e2262d784ec; } ?>
<?php if (isset($__attrs29c3d8109a289c19704a8e2262d784ec)) { $__attrsStack29c3d8109a289c19704a8e2262d784ec[] = $__attrs29c3d8109a289c19704a8e2262d784ec; } ?>
<?php $__attrs29c3d8109a289c19704a8e2262d784ec = ['attributes' => $descriptionAttributes]; ?>
<?php $__slots29c3d8109a289c19704a8e2262d784ec = []; ?>
<?php $__blaze->pushData($__attrs29c3d8109a289c19704a8e2262d784ec); ?>
<?php ob_start(); ?><?php echo e($descriptionTrailing); ?><?php $__slots29c3d8109a289c19704a8e2262d784ec['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots29c3d8109a289c19704a8e2262d784ec); ?>
<?php __29c3d8109a289c19704a8e2262d784ec($__blaze, $__attrs29c3d8109a289c19704a8e2262d784ec, $__slots29c3d8109a289c19704a8e2262d784ec, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack29c3d8109a289c19704a8e2262d784ec)) { $__slots29c3d8109a289c19704a8e2262d784ec = array_pop($__slotsStack29c3d8109a289c19704a8e2262d784ec); } ?>
<?php if (! empty($__attrsStack29c3d8109a289c19704a8e2262d784ec)) { $__attrs29c3d8109a289c19704a8e2262d784ec = array_pop($__attrsStack29c3d8109a289c19704a8e2262d784ec); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    <?php $__slotsae68517bb65bf5b76c1945a6652ef67d['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsae68517bb65bf5b76c1945a6652ef67d); ?>
<?php __ae68517bb65bf5b76c1945a6652ef67d($__blaze, $__attrsae68517bb65bf5b76c1945a6652ef67d, $__slotsae68517bb65bf5b76c1945a6652ef67d, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackae68517bb65bf5b76c1945a6652ef67d)) { $__slotsae68517bb65bf5b76c1945a6652ef67d = array_pop($__slotsStackae68517bb65bf5b76c1945a6652ef67d); } ?>
<?php if (! empty($__attrsStackae68517bb65bf5b76c1945a6652ef67d)) { $__attrsae68517bb65bf5b76c1945a6652ef67d = array_pop($__attrsStackae68517bb65bf5b76c1945a6652ef67d); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-field.blade.php ENDPATH**/ ?>