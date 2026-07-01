<?php
if (!function_exists('__930070215dfb61a5e2a315e41f0aac85')):
function __930070215dfb61a5e2a315e41f0aac85($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php
$__defaults = [
    'name' => null,
    'align' => 'right',
    'checked' => null
];
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
$align ??= $attributes['align'] ?? $__defaults['align']; unset($attributes['align']);
$checked ??= $attributes['checked'] ?? $__defaults['checked']; unset($attributes['checked']);
unset($__defaults);
?>

<?php
// We only want to show the name attribute it has been set manually
// but not if it has been set from the `wire:model` attribute...
$showName = isset($name);
if (! isset($name)) {
    $name = $attributes->whereStartsWith('wire:model')->first();
}

$classes = Flux::classes()
    ->add('group h-5 w-8 min-w-8 relative inline-flex items-center outline-offset-2')
    ->add('rounded-full')
    ->add('transition')
    ->add('bg-zinc-800/15 [&[disabled]]:opacity-50 dark:bg-transparent dark:border dark:border-white/20 dark:[&[disabled]]:border-white/10')
    ->add('[print-color-adjust:exact]')
    ->add([
        'data-checked:bg-(--color-accent)',
        'data-checked:border-0',
    ])
    ;

$indicatorClasses = Flux::classes()
    ->add('size-3.5')
    ->add('rounded-full')
    ->add('transition translate-x-[0.1875rem] dark:translate-x-[0.125rem] rtl:-translate-x-[0.1875rem] dark:rtl:-translate-x-[0.125rem]')
    ->add('bg-white')
    ->add([
        'group-data-checked:translate-x-[0.9375rem] rtl:group-data-checked:-translate-x-[0.9375rem]',
        // We have to add the dark variant of the `translate-x-[0.9375rem]` to ensure that if `.dark` is added to an element mid way
        // down the DOM instead of on the root HTML element, that the above `dark:translate-x-[0.125rem]` doesn't over ride it...
        'dark:group-data-checked:translate-x-[0.9375rem] dark:rtl:group-data-checked:-translate-x-[0.9375rem]',
        'group-data-checked:bg-(--color-accent-foreground)',
    ]);
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($align === 'left' || $align === 'start'): ?>
    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-inline-field.blade.php', $__blaze->compiledPath.'/34ececb6e6dbe18957461df13093226e.php'); ?>
<?php if (isset($__slots34ececb6e6dbe18957461df13093226e)) { $__slotsStack34ececb6e6dbe18957461df13093226e[] = $__slots34ececb6e6dbe18957461df13093226e; } ?>
<?php if (isset($__attrs34ececb6e6dbe18957461df13093226e)) { $__attrsStack34ececb6e6dbe18957461df13093226e[] = $__attrs34ececb6e6dbe18957461df13093226e; } ?>
<?php $__attrs34ececb6e6dbe18957461df13093226e = ['attributes' => $attributes]; ?>
<?php $__slots34ececb6e6dbe18957461df13093226e = []; ?>
<?php $__blaze->pushData($__attrs34ececb6e6dbe18957461df13093226e); ?>
<?php ob_start(); ?>
        <ui-switch <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> <?php if($checked): ?> checked data-checked <?php endif; ?> data-flux-control data-flux-switch>
            <span class="<?php echo e(\Illuminate\Support\Arr::toCssClasses($indicatorClasses)); ?>"></span>
        </ui-switch>
    <?php $__slots34ececb6e6dbe18957461df13093226e['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots34ececb6e6dbe18957461df13093226e); ?>
<?php __34ececb6e6dbe18957461df13093226e($__blaze, $__attrs34ececb6e6dbe18957461df13093226e, $__slots34ececb6e6dbe18957461df13093226e, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack34ececb6e6dbe18957461df13093226e)) { $__slots34ececb6e6dbe18957461df13093226e = array_pop($__slotsStack34ececb6e6dbe18957461df13093226e); } ?>
<?php if (! empty($__attrsStack34ececb6e6dbe18957461df13093226e)) { $__attrs34ececb6e6dbe18957461df13093226e = array_pop($__attrsStack34ececb6e6dbe18957461df13093226e); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-reversed-inline-field.blade.php', $__blaze->compiledPath.'/3df17d48c36a3be301ff5f3d6fdcee06.php'); ?>
<?php if (isset($__slots3df17d48c36a3be301ff5f3d6fdcee06)) { $__slotsStack3df17d48c36a3be301ff5f3d6fdcee06[] = $__slots3df17d48c36a3be301ff5f3d6fdcee06; } ?>
<?php if (isset($__attrs3df17d48c36a3be301ff5f3d6fdcee06)) { $__attrsStack3df17d48c36a3be301ff5f3d6fdcee06[] = $__attrs3df17d48c36a3be301ff5f3d6fdcee06; } ?>
<?php $__attrs3df17d48c36a3be301ff5f3d6fdcee06 = ['attributes' => $attributes]; ?>
<?php $__slots3df17d48c36a3be301ff5f3d6fdcee06 = []; ?>
<?php $__blaze->pushData($__attrs3df17d48c36a3be301ff5f3d6fdcee06); ?>
<?php ob_start(); ?>
        <ui-switch <?php echo e($attributes->class($classes)); ?> <?php if($showName): ?> name="<?php echo e($name); ?>" <?php endif; ?> <?php if($checked): ?> checked data-checked <?php endif; ?> data-flux-control data-flux-switch>
            <span class="<?php echo e(\Illuminate\Support\Arr::toCssClasses($indicatorClasses)); ?>"></span>
        </ui-switch>
    <?php $__slots3df17d48c36a3be301ff5f3d6fdcee06['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots3df17d48c36a3be301ff5f3d6fdcee06); ?>
<?php __3df17d48c36a3be301ff5f3d6fdcee06($__blaze, $__attrs3df17d48c36a3be301ff5f3d6fdcee06, $__slots3df17d48c36a3be301ff5f3d6fdcee06, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3df17d48c36a3be301ff5f3d6fdcee06)) { $__slots3df17d48c36a3be301ff5f3d6fdcee06 = array_pop($__slotsStack3df17d48c36a3be301ff5f3d6fdcee06); } ?>
<?php if (! empty($__attrsStack3df17d48c36a3be301ff5f3d6fdcee06)) { $__attrs3df17d48c36a3be301ff5f3d6fdcee06 = array_pop($__attrsStack3df17d48c36a3be301ff5f3d6fdcee06); } ?>
<?php $__blaze->popData(); ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/switch.blade.php ENDPATH**/ ?>