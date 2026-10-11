<?php
if (!function_exists('__6a25f7119c0ece9306adde0a9ba9b7f7')):
function __6a25f7119c0ece9306adde0a9ba9b7f7($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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
$__defaults = [
    'sticky' => false,
];
$sticky ??= $attributes['sticky'] ?? $__defaults['sticky']; unset($attributes['sticky']);
unset($__defaults);
?>

<?php
    $classes = Flux::classes()
        ->add($sticky ? 'sticky top-0 z-20' : '')
    ;
?>

<thead <?php echo e($attributes->class($classes)); ?> data-flux-columns>
    <tr <?php echo e(isset($tr) ? $tr->attributes : ''); ?>>
        <?php echo e($tr ?? $slot); ?>

    </tr>
</thead>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/table/columns.blade.php ENDPATH**/ ?>