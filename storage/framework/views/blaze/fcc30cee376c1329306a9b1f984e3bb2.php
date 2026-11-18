<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__c5cbe931d4e196a031f617b233242035')):
function __c5cbe931d4e196a031f617b233242035($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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
    'container' => null,
    'inset' => false,
];
$container ??= $attributes['container'] ?? $__defaults['container']; unset($attributes['container']);
$inset ??= $attributes['inset'] ?? $__defaults['inset']; unset($attributes['inset']);
unset($__defaults);
?>

<?php
$classes = Flux::classes('[grid-area:main]')
    ->add($inset ? 'p-6 lg:p-10' : 'p-6 lg:p-8')
    ->add($inset ? 'min-w-0 min-h-0 [:where(&)]:bg-white dark:[:where(&)]:bg-zinc-800 lg:m-2 lg:rounded-xl lg:border lg:[:where(&)]:border-zinc-200 lg:shadow-xs dark:lg:[:where(&)]:border-zinc-700' : '')
    ->add($inset ? 'lg:overflow-y-auto lg:overscroll-contain' : '')
    ->add('[[data-flux-container]_&]:px-0') // If there is a wrapping container, let IT handle the x padding...
    ->add($container && ! $inset ? 'mx-auto w-full [:where(&)]:max-w-7xl' : '')
    ;
?>

<div <?php echo e($attributes->class($classes)); ?> data-flux-main <?php if($inset): ?> data-flux-main-inset <?php endif; ?>>
    <?php if ($container && $inset): ?>
        <div class="mx-auto w-full [:where(&)]:max-w-7xl">
            <?php echo e($slot); ?>

        </div>
    <?php else: ?>
        <?php echo e($slot); ?>

    <?php endif; ?>
</div>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/main.blade.php ENDPATH**/ ?>