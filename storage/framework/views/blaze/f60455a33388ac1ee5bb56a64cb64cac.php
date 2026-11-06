<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__6782c340c78d02017412bc86eed4c9a5')):
function __6782c340c78d02017412bc86eed4c9a5($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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
$__defaults = [
    'variant' => null,
];
$variant ??= $attributes['variant'] ?? $__defaults['variant']; unset($attributes['variant']);
unset($__defaults);
?>

<?php
$classes = Flux::classes()
    ->add('flex flex-col')
    ->add('overflow-visible min-h-auto')
    ;
?>

<nav <?php echo e($attributes->class($classes)); ?> data-flux-navlist>
    <?php echo e($slot); ?>

</nav>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/navlist/index.blade.php ENDPATH**/ ?>