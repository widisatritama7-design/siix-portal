<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__7db09146fd639cf0c68466c211f427b9')):
function __7db09146fd639cf0c68466c211f427b9($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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
    'sticky' => null,
    'container' => null,
];
$sticky ??= $attributes['sticky'] ?? $__defaults['sticky']; unset($attributes['sticky']);
$container ??= $attributes['container'] ?? $__defaults['container']; unset($attributes['container']);
unset($__defaults);
?>

<?php
$classes = Flux::classes('[grid-area:header]')
    ->add('z-10 min-h-14')
    ->add($container ? '' : 'flex items-center px-6 lg:px-8')
    ;

if ($sticky) {
    $attributes = $attributes->merge([
        'x-data' => '',
        'x-bind:style' => '{ position: \'sticky\', top: $el.offsetTop + \'px\', \'max-height\': \'calc(100vh - \' + $el.offsetTop + \'px)\' }',
    ]);
}
?>

<header <?php echo e($attributes->class($classes)); ?> data-flux-header>
    <?php if ($container) : ?>
        <div class="mx-auto w-full h-full [:where(&)]:max-w-7xl px-6 lg:px-8 flex items-center">
            <?php echo e($slot); ?>

        </div>
    <?php else: ?>
        <?php echo e($slot); ?>

    <?php endif; ?>
</header>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/header.blade.php ENDPATH**/ ?>