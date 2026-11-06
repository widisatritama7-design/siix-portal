<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__5747411e84d8336c182a67a41526d1fa')):
function __5747411e84d8336c182a67a41526d1fa($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
$__env = $__blaze->env;
$__livewire = $__env->shared('__livewire');
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
    'dismissible' => null,
    'escapable' => null,
    'position' => null,
    'closable' => null,
    'trigger' => null,
    'variant' => null,
    'scroll' => null,
    'flyout' => null,
    'name' => null,
];
$dismissible ??= $attributes['dismissible'] ?? $__defaults['dismissible']; unset($attributes['dismissible']);
$escapable ??= $attributes['escapable'] ?? $__defaults['escapable']; unset($attributes['escapable']);
$position ??= $attributes['position'] ?? $__defaults['position']; unset($attributes['position']);
$closable ??= $attributes['closable'] ?? $__defaults['closable']; unset($attributes['closable']);
$trigger ??= $attributes['trigger'] ?? $__defaults['trigger']; unset($attributes['trigger']);
$variant ??= $attributes['variant'] ?? $__defaults['variant']; unset($attributes['variant']);
$scroll ??= $attributes['scroll'] ?? $__defaults['scroll']; unset($attributes['scroll']);
$flyout ??= $attributes['flyout'] ?? $__defaults['flyout']; unset($attributes['flyout']);
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
unset($__defaults);
?>

<?php
// Blaze doesn't support View::share, this supplements it...
$__livewire = $__env->shared('__livewire');

if ($variant === 'flyout') {
    $flyout = true;
    $variant = null;
}

$closable ??= $variant === 'bare' ? false : true;
$overflow = $scroll === 'body' && ! $flyout;

if ($flyout) {
    $classes = Flux::classes()
        ->add(match ($variant) {
            default => match($position) {
                // For bottom flyout we intentionally use 100% instead of 100vw because Firefox includes scrollbar gutter in vw...
                'bottom' => 'fixed m-0 p-8 min-w-[100%] overflow-y-auto mt-auto [--flux-flyout-translate:translateY(50px)] border-t',
                'left' => 'fixed m-0 p-8 max-h-dvh min-h-dvh md:[:where(&)]:min-w-[25rem] overflow-y-auto mr-auto [--flux-flyout-translate:translateX(-50px)] border-e rtl:mr-0 rtl:ml-auto rtl:[--flux-flyout-translate:translateX(50px)]',
                default => 'fixed m-0 p-8 max-h-dvh min-h-dvh md:[:where(&)]:min-w-[25rem] overflow-y-auto ml-auto [--flux-flyout-translate:translateX(50px)] border-s rtl:ml-0 rtl:mr-auto rtl:[--flux-flyout-translate:translateX(-50px)]',
            },
            'floating' => match($position) {
                // For bottom flyout we intentionally use 100% instead of 100vw because Firefox includes scrollbar gutter in vw...
                'bottom' => 'fixed m-2 p-8 min-w-[calc(100%-1rem)] overflow-y-auto mt-auto [--flux-flyout-translate:translateY(50px)]',
                'left' => 'fixed m-2 p-8 max-h-[calc(100dvh-1rem)] min-h-[calc(100dvh-1rem)] md:[:where(&)]:min-w-[25rem] overflow-y-auto mr-auto [--flux-flyout-translate:translateX(-50px)] rtl:mr-0 rtl:ml-auto rtl:[--flux-flyout-translate:translateX(50px)]',
                default => 'fixed m-2 p-8 max-h-[calc(100dvh-1rem)] min-h-[calc(100dvh-1rem)] md:[:where(&)]:min-w-[25rem] overflow-y-auto ml-auto [--flux-flyout-translate:translateX(50px)] rtl:ml-0 rtl:mr-auto rtl:[--flux-flyout-translate:translateX(-50px)]',
            },
            'bare' => '',
        })
        ->add(match ($variant) {
            default => 'bg-white dark:bg-zinc-800 border-transparent dark:border-zinc-700',
            'floating' => 'bg-white dark:bg-zinc-800 ring ring-black/5 dark:ring-zinc-700 shadow-lg rounded-xl',
            'bare' => 'bg-transparent',
        });
} elseif ($overflow) {
    $classes = Flux::classes();

    $contentClasses = Flux::classes()
        ->add('relative')
        ->add(match ($variant) {
            default => 'p-6 [:where(&)]:max-w-xl [:where(&)]:min-w-xs shadow-lg rounded-xl',
            'bare' => '',
        })
        ->add(match ($variant) {
            default => 'bg-white dark:bg-zinc-800 ring ring-black/5 dark:ring-zinc-700 shadow-lg rounded-xl',
            'bare' => 'bg-transparent',
        });
} else {
    $classes = Flux::classes()
        ->add(match ($variant) {
            default => 'p-6 [:where(&)]:max-w-xl [:where(&)]:min-w-xs shadow-lg rounded-xl',
            'bare' => '',
        })
        ->add(match ($variant) {
            default => 'bg-white dark:bg-zinc-800 ring ring-black/5 dark:ring-zinc-700 shadow-lg rounded-xl',
            'bare' => 'bg-transparent',
        });
}

// Support adding the .self modifier to the wire:model directive...
if (($wireModel = $attributes->wire('model')) && $wireModel->directive && ! $wireModel->hasModifier('self')) {
    unset($attributes[$wireModel->directive]);

    $wireModel->directive .= '.self';

    $attributes = $attributes->merge([$wireModel->directive => $wireModel->value]);
}

if ($attributes['@close'] ?? null) {
    $attributes['wire:close'] = $attributes['@close'];

    unset($attributes['@close']);
}

if ($attributes['@cancel'] ?? null) {
    $attributes['wire:cancel'] = $attributes['@cancel'];

    unset($attributes['@cancel']);
}

if ($dismissible === false) {
    $attributes = $attributes->merge(['disable-click-outside' => '']);
}

if ($escapable === false) {
    $attributes = $attributes->merge(['disable-escape' => '']);
}

[ $contentAttributes, $attributes ] = Flux::splitAttributes($attributes, ['autofocus', 'class', 'style']);
[ $dialogAttributes, $attributes ] = Flux::splitAttributes($attributes, ['wire:close', 'x-on:close', 'wire:cancel', 'x-on:cancel']);

if (! $overflow) {
    $dialogAttributes = $dialogAttributes->merge($contentAttributes->getAttributes());
}
?>

<ui-modal <?php echo e($attributes); ?> data-flux-modal>
    <?php if ($trigger): ?>
        <?php echo e($trigger); ?>

    <?php endif; ?>

    <dialog
        wire:ignore.self 
        <?php echo e($dialogAttributes->class($classes)); ?>

        <?php if ($name): ?> data-modal="<?php echo e($name); ?>" <?php endif; ?>
        <?php if ($flyout): ?> data-flux-flyout <?php endif; ?>
        <?php if ($overflow): ?> data-flux-modal-overflow <?php endif; ?>
        [STARTCOMPILEDUNBLAZE:R6eg0w1iSf]<?php \Livewire\Blaze\Unblaze::storeScope("R6eg0w1iSf", scope: ['name' => $name]) ?><?php \Livewire\Blaze\Unblaze::storeReplacement("R6eg0w1iSf", "CiAgICAgICAgeC1kYXRhPSJmbHV4TW9kYWwoQGpzKCRzY29wZVsnbmFtZSddKSwgQGpzKGlzc2V0KCRfX2xpdmV3aXJlKSA/ICRfX2xpdmV3aXJlLT5nZXRJZCgpIDogbnVsbCkpIgogICAgICAgIA==") ?>[ENDCOMPILEDUNBLAZE:R6eg0w1iSf]
        x-on:modal-show.document="handleShow($event)"
        x-on:modal-close.document="handleClose($event)"
    >
        <?php if ($overflow): ?>
            <div class="flex min-h-full items-center justify-center p-4 sm:p-6">
                <div <?php echo e($contentAttributes->class($contentClasses)); ?> data-flux-modal-content>
                    <?php echo e($slot); ?>


                    <?php if ($closable): ?>
                        <div class="absolute top-0 end-0 mt-4 me-4">
                            <?php if (!function_exists('__fbc04aaa7ba245ff8959c57403b02a7a')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/modal/close.blade.php'); } ?>
<?php if (isset($__slotsfbc04aaa7ba245ff8959c57403b02a7a)) { $__slotsStackfbc04aaa7ba245ff8959c57403b02a7a[] = $__slotsfbc04aaa7ba245ff8959c57403b02a7a; } ?>
<?php if (isset($__datafbc04aaa7ba245ff8959c57403b02a7a)) { $__dataStackfbc04aaa7ba245ff8959c57403b02a7a[] = $__datafbc04aaa7ba245ff8959c57403b02a7a; } ?>
<?php $__datafbc04aaa7ba245ff8959c57403b02a7a = []; ?>
<?php $__slotsfbc04aaa7ba245ff8959c57403b02a7a = []; ?>
<?php $__blaze->pushData($__datafbc04aaa7ba245ff8959c57403b02a7a); ?>
<?php ob_start(); ?>
                                <?php if (!function_exists('__19e9f12f8a300195bcfcda1eb1bbca00')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php'); } ?>
<?php if (isset($__slots19e9f12f8a300195bcfcda1eb1bbca00)) { $__slotsStack19e9f12f8a300195bcfcda1eb1bbca00[] = $__slots19e9f12f8a300195bcfcda1eb1bbca00; } ?>
<?php if (isset($__data19e9f12f8a300195bcfcda1eb1bbca00)) { $__dataStack19e9f12f8a300195bcfcda1eb1bbca00[] = $__data19e9f12f8a300195bcfcda1eb1bbca00; } ?>
<?php $__data19e9f12f8a300195bcfcda1eb1bbca00 = ['variant' => 'ghost','icon' => 'x-mark','size' => 'sm','ariaLabel' => e(__('Close modal')),'class' => 'text-zinc-400! hover:text-zinc-800! dark:text-zinc-500! dark:hover:text-white!']; ?>
<?php $__slots19e9f12f8a300195bcfcda1eb1bbca00 = []; ?>
<?php $__blaze->pushData($__data19e9f12f8a300195bcfcda1eb1bbca00); ?>
<?php ob_start(); ?><?php $__slots19e9f12f8a300195bcfcda1eb1bbca00['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots19e9f12f8a300195bcfcda1eb1bbca00); ?>
<?php __19e9f12f8a300195bcfcda1eb1bbca00($__blaze, $__data19e9f12f8a300195bcfcda1eb1bbca00, ['variant' => 'ghost', 'icon' => 'x-mark', 'size' => 'sm', 'aria-label' => $__data19e9f12f8a300195bcfcda1eb1bbca00['ariaLabel'], 'class' => 'text-zinc-400! hover:text-zinc-800! dark:text-zinc-500! dark:hover:text-white!'], $__slots19e9f12f8a300195bcfcda1eb1bbca00, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack19e9f12f8a300195bcfcda1eb1bbca00)) { $__slots19e9f12f8a300195bcfcda1eb1bbca00 = array_pop($__slotsStack19e9f12f8a300195bcfcda1eb1bbca00); } ?>
<?php if (! empty($__dataStack19e9f12f8a300195bcfcda1eb1bbca00)) { $__data19e9f12f8a300195bcfcda1eb1bbca00 = array_pop($__dataStack19e9f12f8a300195bcfcda1eb1bbca00); } ?>
<?php $__blaze->popData(); ?>
                            <?php $__slotsfbc04aaa7ba245ff8959c57403b02a7a['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsfbc04aaa7ba245ff8959c57403b02a7a); ?>
<?php __fbc04aaa7ba245ff8959c57403b02a7a($__blaze, $__datafbc04aaa7ba245ff8959c57403b02a7a, [], $__slotsfbc04aaa7ba245ff8959c57403b02a7a, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackfbc04aaa7ba245ff8959c57403b02a7a)) { $__slotsfbc04aaa7ba245ff8959c57403b02a7a = array_pop($__slotsStackfbc04aaa7ba245ff8959c57403b02a7a); } ?>
<?php if (! empty($__dataStackfbc04aaa7ba245ff8959c57403b02a7a)) { $__datafbc04aaa7ba245ff8959c57403b02a7a = array_pop($__dataStackfbc04aaa7ba245ff8959c57403b02a7a); } ?>
<?php $__blaze->popData(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <?php echo e($slot); ?>


            <?php if ($closable): ?>
                <div class="absolute top-0 end-0 mt-4 me-4">
                    <?php if (!function_exists('__fbc04aaa7ba245ff8959c57403b02a7a')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/modal/close.blade.php'); } ?>
<?php if (isset($__slotsfbc04aaa7ba245ff8959c57403b02a7a)) { $__slotsStackfbc04aaa7ba245ff8959c57403b02a7a[] = $__slotsfbc04aaa7ba245ff8959c57403b02a7a; } ?>
<?php if (isset($__datafbc04aaa7ba245ff8959c57403b02a7a)) { $__dataStackfbc04aaa7ba245ff8959c57403b02a7a[] = $__datafbc04aaa7ba245ff8959c57403b02a7a; } ?>
<?php $__datafbc04aaa7ba245ff8959c57403b02a7a = []; ?>
<?php $__slotsfbc04aaa7ba245ff8959c57403b02a7a = []; ?>
<?php $__blaze->pushData($__datafbc04aaa7ba245ff8959c57403b02a7a); ?>
<?php ob_start(); ?>
                        <?php if (!function_exists('__19e9f12f8a300195bcfcda1eb1bbca00')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php'); } ?>
<?php if (isset($__slots19e9f12f8a300195bcfcda1eb1bbca00)) { $__slotsStack19e9f12f8a300195bcfcda1eb1bbca00[] = $__slots19e9f12f8a300195bcfcda1eb1bbca00; } ?>
<?php if (isset($__data19e9f12f8a300195bcfcda1eb1bbca00)) { $__dataStack19e9f12f8a300195bcfcda1eb1bbca00[] = $__data19e9f12f8a300195bcfcda1eb1bbca00; } ?>
<?php $__data19e9f12f8a300195bcfcda1eb1bbca00 = ['variant' => 'ghost','icon' => 'x-mark','size' => 'sm','ariaLabel' => e(__('Close modal')),'class' => 'text-zinc-400! hover:text-zinc-800! dark:text-zinc-500! dark:hover:text-white!']; ?>
<?php $__slots19e9f12f8a300195bcfcda1eb1bbca00 = []; ?>
<?php $__blaze->pushData($__data19e9f12f8a300195bcfcda1eb1bbca00); ?>
<?php ob_start(); ?><?php $__slots19e9f12f8a300195bcfcda1eb1bbca00['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots19e9f12f8a300195bcfcda1eb1bbca00); ?>
<?php __19e9f12f8a300195bcfcda1eb1bbca00($__blaze, $__data19e9f12f8a300195bcfcda1eb1bbca00, ['variant' => 'ghost', 'icon' => 'x-mark', 'size' => 'sm', 'aria-label' => $__data19e9f12f8a300195bcfcda1eb1bbca00['ariaLabel'], 'class' => 'text-zinc-400! hover:text-zinc-800! dark:text-zinc-500! dark:hover:text-white!'], $__slots19e9f12f8a300195bcfcda1eb1bbca00, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack19e9f12f8a300195bcfcda1eb1bbca00)) { $__slots19e9f12f8a300195bcfcda1eb1bbca00 = array_pop($__slotsStack19e9f12f8a300195bcfcda1eb1bbca00); } ?>
<?php if (! empty($__dataStack19e9f12f8a300195bcfcda1eb1bbca00)) { $__data19e9f12f8a300195bcfcda1eb1bbca00 = array_pop($__dataStack19e9f12f8a300195bcfcda1eb1bbca00); } ?>
<?php $__blaze->popData(); ?>
                    <?php $__slotsfbc04aaa7ba245ff8959c57403b02a7a['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsfbc04aaa7ba245ff8959c57403b02a7a); ?>
<?php __fbc04aaa7ba245ff8959c57403b02a7a($__blaze, $__datafbc04aaa7ba245ff8959c57403b02a7a, [], $__slotsfbc04aaa7ba245ff8959c57403b02a7a, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackfbc04aaa7ba245ff8959c57403b02a7a)) { $__slotsfbc04aaa7ba245ff8959c57403b02a7a = array_pop($__slotsStackfbc04aaa7ba245ff8959c57403b02a7a); } ?>
<?php if (! empty($__dataStackfbc04aaa7ba245ff8959c57403b02a7a)) { $__datafbc04aaa7ba245ff8959c57403b02a7a = array_pop($__dataStackfbc04aaa7ba245ff8959c57403b02a7a); } ?>
<?php $__blaze->popData(); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </dialog>
</ui-modal>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/modal/index.blade.php ENDPATH**/ ?>