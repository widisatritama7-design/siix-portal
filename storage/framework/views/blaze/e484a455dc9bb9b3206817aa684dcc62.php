<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__4321e179d68669076ae438cbfc240025')):
function __4321e179d68669076ae438cbfc240025($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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
    'paginate' => null,
    'bleed' => false,
];
$paginate ??= $attributes['paginate'] ?? $__defaults['paginate']; unset($attributes['paginate']);
$bleed ??= $attributes['bleed'] ?? $__defaults['bleed']; unset($attributes['bleed']);
unset($__defaults);
?>

<?php
$classes = Flux::classes()
    ->add('[:where(&)]:min-w-full table-fixed border-separate border-spacing-0 isolate')
    ->add('text-zinc-800')
    // We want whitespace-nowrap for the table, but not for modals and dropdowns...
    ->add('whitespace-nowrap [&_dialog]:whitespace-normal [&_[popover]]:whitespace-normal')
    ->add($bleed ? [
        '[&_[data-flux-column]:first-child]:ps-[var(--flux-bleed,1.5rem)]',
        '[&_[data-flux-cell]:first-child]:ps-[var(--flux-bleed,1.5rem)]',
        '[&_[data-flux-column]:last-child]:pe-[var(--flux-bleed,1.5rem)]',
        '[&_[data-flux-cell]:last-child]:pe-[var(--flux-bleed,1.5rem)]',
    ] : '')
    ;

$containerClasses = Flux::classes()
    ->add('flex flex-col')
    ->add($bleed ? '-mx-[var(--flux-bleed,1.5rem)]' : '')
    ->add($attributes->pluck('container:class'))
    ;
?>

<div class="<?php echo e($containerClasses); ?>" <?php if($bleed): ?> data-flux-table-bleed <?php endif; ?>>
    <?php echo e($header ?? ''); ?>


    <ui-table-scroll-area class="overflow-auto">
        <table <?php echo e($attributes->class($classes)); ?> data-flux-table>
            <?php echo e($slot); ?>

        </table>
    </ui-table-scroll-area>

    <?php echo e($footer ?? ''); ?>


    <?php if ($paginate): ?>
        <?php $paginationAttributes = Flux::attributesAfter('pagination:', $attributes, [
            'paginator' => $paginate,
            'class' => Flux::classes()
                ->add('shrink-0')
                ->add($bleed ? 'px-[var(--flux-bleed,1.5rem)]' : ''),
        ]); ?>
        <?php if (!function_exists('__899e734661a266dc10b92ff4e27b27ac')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/pagination.blade.php'); } ?>
<?php $__componentData = ['attributes' => $paginationAttributes]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php __899e734661a266dc10b92ff4e27b27ac($__blaze, $__componentData, $__blaze->mergeAttributes(['attributes' => $__componentData['attributes']]), [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
    <?php endif; ?>
</div>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/table/index.blade.php ENDPATH**/ ?>