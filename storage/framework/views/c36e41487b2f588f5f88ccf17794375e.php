<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'description',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title',
    'description',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="flex w-full flex-col text-center">
    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/heading.blade.php', $__blaze->compiledPath.'/c4bf0adaf25764df57f7bf033913f226.php'); ?>
<?php if (isset($__slotsc4bf0adaf25764df57f7bf033913f226)) { $__slotsStackc4bf0adaf25764df57f7bf033913f226[] = $__slotsc4bf0adaf25764df57f7bf033913f226; } ?>
<?php if (isset($__attrsc4bf0adaf25764df57f7bf033913f226)) { $__attrsStackc4bf0adaf25764df57f7bf033913f226[] = $__attrsc4bf0adaf25764df57f7bf033913f226; } ?>
<?php $__attrsc4bf0adaf25764df57f7bf033913f226 = ['size' => 'xl']; ?>
<?php $__slotsc4bf0adaf25764df57f7bf033913f226 = []; ?>
<?php $__blaze->pushData($__attrsc4bf0adaf25764df57f7bf033913f226); ?>
<?php ob_start(); ?><?php echo e($title); ?><?php $__slotsc4bf0adaf25764df57f7bf033913f226['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsc4bf0adaf25764df57f7bf033913f226); ?>
<?php _c4bf0adaf25764df57f7bf033913f226($__blaze, $__attrsc4bf0adaf25764df57f7bf033913f226, $__slotsc4bf0adaf25764df57f7bf033913f226, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackc4bf0adaf25764df57f7bf033913f226)) { $__slotsc4bf0adaf25764df57f7bf033913f226 = array_pop($__slotsStackc4bf0adaf25764df57f7bf033913f226); } ?>
<?php if (! empty($__attrsStackc4bf0adaf25764df57f7bf033913f226)) { $__attrsc4bf0adaf25764df57f7bf033913f226 = array_pop($__attrsStackc4bf0adaf25764df57f7bf033913f226); } ?>
<?php $__blaze->popData(); ?>
    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/subheading.blade.php', $__blaze->compiledPath.'/d8f11a131ebd49fe18101bb6baab6731.php'); ?>
<?php if (isset($__slotsd8f11a131ebd49fe18101bb6baab6731)) { $__slotsStackd8f11a131ebd49fe18101bb6baab6731[] = $__slotsd8f11a131ebd49fe18101bb6baab6731; } ?>
<?php if (isset($__attrsd8f11a131ebd49fe18101bb6baab6731)) { $__attrsStackd8f11a131ebd49fe18101bb6baab6731[] = $__attrsd8f11a131ebd49fe18101bb6baab6731; } ?>
<?php $__attrsd8f11a131ebd49fe18101bb6baab6731 = []; ?>
<?php $__slotsd8f11a131ebd49fe18101bb6baab6731 = []; ?>
<?php $__blaze->pushData($__attrsd8f11a131ebd49fe18101bb6baab6731); ?>
<?php ob_start(); ?><?php echo e($description); ?><?php $__slotsd8f11a131ebd49fe18101bb6baab6731['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsd8f11a131ebd49fe18101bb6baab6731); ?>
<?php _d8f11a131ebd49fe18101bb6baab6731($__blaze, $__attrsd8f11a131ebd49fe18101bb6baab6731, $__slotsd8f11a131ebd49fe18101bb6baab6731, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackd8f11a131ebd49fe18101bb6baab6731)) { $__slotsd8f11a131ebd49fe18101bb6baab6731 = array_pop($__slotsStackd8f11a131ebd49fe18101bb6baab6731); } ?>
<?php if (! empty($__attrsStackd8f11a131ebd49fe18101bb6baab6731)) { $__attrsd8f11a131ebd49fe18101bb6baab6731 = array_pop($__attrsStackd8f11a131ebd49fe18101bb6baab6731); } ?>
<?php $__blaze->popData(); ?>
</div>
<?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/resources/views/components/auth-header.blade.php ENDPATH**/ ?>