<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__7aeee15e1e0237b2df40d32c45d459a3')):
function __7aeee15e1e0237b2df40d32c45d459a3($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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
    'scrollable' => false,
    'variant' => null,
];
$scrollable ??= $attributes['scrollable'] ?? $__defaults['scrollable']; unset($attributes['scrollable']);
$variant ??= $attributes['variant'] ?? $__defaults['variant']; unset($attributes['variant']);
unset($__defaults);
?>

<?php
$classes = Flux::classes()
    ->add('flex items-center gap-0.5 py-3')
    ->add($scrollable ? ['overflow-x-auto overflow-y-hidden'] : [])
    ;
?>

<nav <?php echo e($attributes->class($classes)); ?> data-flux-navbar>
    <?php echo e($slot); ?>

</nav>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/navbar/index.blade.php ENDPATH**/ ?>