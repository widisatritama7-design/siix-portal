<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__8eea5eda712a9830ac094d57c5529b6c')):
function __8eea5eda712a9830ac094d57c5529b6c($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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
extract(Flux::forwardedattributes($attributes, [
    'name',
    'description',
    'label',
]));
?>

<?php
$__defaults = [
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'description' => null,
    'label' => null,
];
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
$description ??= $attributes['description'] ?? $__defaults['description']; unset($attributes['description']);
$label ??= $attributes['label'] ?? $__defaults['label']; unset($attributes['label']);
unset($__defaults);
?>

<?php if ($label || $description): ?>
    <?php if (!function_exists('__f6b5bd8232297581696809b9c29b3dd4')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/field.blade.php'); } ?>
<?php if (isset($__slotsf6b5bd8232297581696809b9c29b3dd4)) { $__slotsStackf6b5bd8232297581696809b9c29b3dd4[] = $__slotsf6b5bd8232297581696809b9c29b3dd4; } ?>
<?php if (isset($__dataf6b5bd8232297581696809b9c29b3dd4)) { $__dataStackf6b5bd8232297581696809b9c29b3dd4[] = $__dataf6b5bd8232297581696809b9c29b3dd4; } ?>
<?php $__dataf6b5bd8232297581696809b9c29b3dd4 = ['variant' => 'inline']; ?>
<?php $__slotsf6b5bd8232297581696809b9c29b3dd4 = []; ?>
<?php $__blaze->pushData($__dataf6b5bd8232297581696809b9c29b3dd4); ?>
<?php ob_start(); ?>
        <?php if ($label): ?>
            <?php if (!function_exists('__48ea9f6f8223a6a3ce1ae5ee0da15111')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/label.blade.php'); } ?>
<?php if (isset($__slots48ea9f6f8223a6a3ce1ae5ee0da15111)) { $__slotsStack48ea9f6f8223a6a3ce1ae5ee0da15111[] = $__slots48ea9f6f8223a6a3ce1ae5ee0da15111; } ?>
<?php if (isset($__data48ea9f6f8223a6a3ce1ae5ee0da15111)) { $__dataStack48ea9f6f8223a6a3ce1ae5ee0da15111[] = $__data48ea9f6f8223a6a3ce1ae5ee0da15111; } ?>
<?php $__data48ea9f6f8223a6a3ce1ae5ee0da15111 = []; ?>
<?php $__slots48ea9f6f8223a6a3ce1ae5ee0da15111 = []; ?>
<?php $__blaze->pushData($__data48ea9f6f8223a6a3ce1ae5ee0da15111); ?>
<?php ob_start(); ?><?php echo e($label); ?><?php $__slots48ea9f6f8223a6a3ce1ae5ee0da15111['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots48ea9f6f8223a6a3ce1ae5ee0da15111); ?>
<?php __48ea9f6f8223a6a3ce1ae5ee0da15111($__blaze, $__data48ea9f6f8223a6a3ce1ae5ee0da15111, [], $__slots48ea9f6f8223a6a3ce1ae5ee0da15111, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack48ea9f6f8223a6a3ce1ae5ee0da15111)) { $__slots48ea9f6f8223a6a3ce1ae5ee0da15111 = array_pop($__slotsStack48ea9f6f8223a6a3ce1ae5ee0da15111); } ?>
<?php if (! empty($__dataStack48ea9f6f8223a6a3ce1ae5ee0da15111)) { $__data48ea9f6f8223a6a3ce1ae5ee0da15111 = array_pop($__dataStack48ea9f6f8223a6a3ce1ae5ee0da15111); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php if ($description): ?>
            <?php if (!function_exists('__302308ae9f8c61f39bfff88534b4b83c')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/description.blade.php'); } ?>
<?php if (isset($__slots302308ae9f8c61f39bfff88534b4b83c)) { $__slotsStack302308ae9f8c61f39bfff88534b4b83c[] = $__slots302308ae9f8c61f39bfff88534b4b83c; } ?>
<?php if (isset($__data302308ae9f8c61f39bfff88534b4b83c)) { $__dataStack302308ae9f8c61f39bfff88534b4b83c[] = $__data302308ae9f8c61f39bfff88534b4b83c; } ?>
<?php $__data302308ae9f8c61f39bfff88534b4b83c = []; ?>
<?php $__slots302308ae9f8c61f39bfff88534b4b83c = []; ?>
<?php $__blaze->pushData($__data302308ae9f8c61f39bfff88534b4b83c); ?>
<?php ob_start(); ?><?php echo e($description); ?><?php $__slots302308ae9f8c61f39bfff88534b4b83c['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots302308ae9f8c61f39bfff88534b4b83c); ?>
<?php __302308ae9f8c61f39bfff88534b4b83c($__blaze, $__data302308ae9f8c61f39bfff88534b4b83c, [], $__slots302308ae9f8c61f39bfff88534b4b83c, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack302308ae9f8c61f39bfff88534b4b83c)) { $__slots302308ae9f8c61f39bfff88534b4b83c = array_pop($__slotsStack302308ae9f8c61f39bfff88534b4b83c); } ?>
<?php if (! empty($__dataStack302308ae9f8c61f39bfff88534b4b83c)) { $__data302308ae9f8c61f39bfff88534b4b83c = array_pop($__dataStack302308ae9f8c61f39bfff88534b4b83c); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php echo e($slot); ?>


        [STARTCOMPILEDUNBLAZE:4l8MpasbFp]<?php \Livewire\Blaze\Unblaze::storeScope("4l8MpasbFp", scope: ['name' => $name]) ?><?php \Livewire\Blaze\Unblaze::storeReplacement("4l8MpasbFp", "CiAgICAgICAgICAgIDxmbHV4OmVycm9yIDpuYW1lPSIkc2NvcGVbJ25hbWUnXSIgLz4KICAgICAgICA=") ?>[ENDCOMPILEDUNBLAZE:4l8MpasbFp]
    <?php $__slotsf6b5bd8232297581696809b9c29b3dd4['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsf6b5bd8232297581696809b9c29b3dd4); ?>
<?php __f6b5bd8232297581696809b9c29b3dd4($__blaze, $__dataf6b5bd8232297581696809b9c29b3dd4, ['variant' => 'inline'], $__slotsf6b5bd8232297581696809b9c29b3dd4, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackf6b5bd8232297581696809b9c29b3dd4)) { $__slotsf6b5bd8232297581696809b9c29b3dd4 = array_pop($__slotsStackf6b5bd8232297581696809b9c29b3dd4); } ?>
<?php if (! empty($__dataStackf6b5bd8232297581696809b9c29b3dd4)) { $__dataf6b5bd8232297581696809b9c29b3dd4 = array_pop($__dataStackf6b5bd8232297581696809b9c29b3dd4); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>

<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-reversed-inline-field.blade.php ENDPATH**/ ?>