<?php # [BlazeFolded]:{flux::icon}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php}:{1774988736} ?>
<?php
if (!function_exists('_922d45cbd950a9185add88690a0a9e6f')):
function _922d45cbd950a9185add88690a0a9e6f($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php $tooltipPosition = $tooltipPosition ??= $attributes->pluck('tooltip:position'); ?>
<?php $tooltipKbd = $tooltipKbd ??= $attributes->pluck('tooltip:kbd'); ?>
<?php $tooltip = $tooltip ??= $attributes->pluck('tooltip'); ?>

<?php
$__defaults = [
    'tooltipPosition' => 'right',
    'placeholder' => __('Search...'),
    'tooltipKbd' => null,
    'tooltip' => null,
    'kbd' => null,
];
$tooltipPosition ??= $attributes['tooltip-position'] ?? $attributes['tooltipPosition'] ?? $__defaults['tooltipPosition']; unset($attributes['tooltipPosition'], $attributes['tooltip-position']);
$placeholder ??= $attributes['placeholder'] ?? $__defaults['placeholder']; unset($attributes['placeholder']);
$tooltipKbd ??= $attributes['tooltip-kbd'] ?? $attributes['tooltipKbd'] ?? $__defaults['tooltipKbd']; unset($attributes['tooltipKbd'], $attributes['tooltip-kbd']);
$tooltip ??= $attributes['tooltip'] ?? $__defaults['tooltip']; unset($attributes['tooltip']);
$kbd ??= $attributes['kbd'] ?? $__defaults['kbd']; unset($attributes['kbd']);
unset($__defaults);
?>

<?php
$tooltip = $tooltip ?? $placeholder;

$tooltipKbd ??= $kbd;

$tooltipClasses = Flux::classes()
    ->add('w-full')
    ->add('in-data-flux-sidebar-header:in-data-flux-sidebar-collapsed-desktop:in-data-flux-sidebar-active:hidden')
    ;

$classes = Flux::classes()
    ->add('h-10 py-2 px-3 w-full rounded-lg disabled:shadow-none dark:shadow-none appearance-none text-base sm:text-sm leading-[1.375rem] bg-zinc-800/5 dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 placeholder-zinc-500 disabled:placeholder-zinc-400 dark:text-zinc-200 dark:placeholder-white/60 dark:disabled:placeholder-white/40 border-0 relative flex items-center gap-3')
    ->add('in-data-flux-sidebar-on-mobile:h-10 in-data-flux-sidebar-collapsed-desktop:px-3')
    ->add('in-data-flux-sidebar-header:in-data-flux-sidebar-collapsed-desktop:in-data-flux-sidebar-active:hidden')
    ;
?>

<?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/index.blade.php', $__blaze->compiledPath.'/d2ff6bde64aba3d6d9e0ef81fb505b85.php'); ?>
<?php if (isset($__slotsd2ff6bde64aba3d6d9e0ef81fb505b85)) { $__slotsStackd2ff6bde64aba3d6d9e0ef81fb505b85[] = $__slotsd2ff6bde64aba3d6d9e0ef81fb505b85; } ?>
<?php if (isset($__attrsd2ff6bde64aba3d6d9e0ef81fb505b85)) { $__attrsStackd2ff6bde64aba3d6d9e0ef81fb505b85[] = $__attrsd2ff6bde64aba3d6d9e0ef81fb505b85; } ?>
<?php $__attrsd2ff6bde64aba3d6d9e0ef81fb505b85 = ['position' => $tooltipPosition,'class' => $tooltipClasses]; ?>
<?php $__slotsd2ff6bde64aba3d6d9e0ef81fb505b85 = []; ?>
<?php $__blaze->pushData($__attrsd2ff6bde64aba3d6d9e0ef81fb505b85); ?>
<?php ob_start(); ?>
    <button
        <?php echo e($attributes->class($classes)); ?>

        type="button"
        data-flux-sidebar-search
    >
        <div class="flex items-center justify-center text-xs text-zinc-400/75 start-0">
            <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
        </div>

        <div class="in-data-flux-sidebar-collapsed-desktop:hidden block self-center text-start flex-1 font-medium text-zinc-400 dark:text-white/40">
            <?php echo e($placeholder); ?>

        </div>

        <?php if ($kbd): ?>
            <div class="in-data-flux-sidebar-collapsed-desktop:hidden absolute top-0 bottom-0 flex items-center justify-center text-xs text-zinc-400/75 pe-4 end-0">
                <?php echo e($kbd); ?>

            </div>
        <?php endif; ?>
    </button>

    <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/f11f89c11aa17d087f3db4d72d78680a.php'); ?>
<?php if (isset($__slotsf11f89c11aa17d087f3db4d72d78680a)) { $__slotsStackf11f89c11aa17d087f3db4d72d78680a[] = $__slotsf11f89c11aa17d087f3db4d72d78680a; } ?>
<?php if (isset($__attrsf11f89c11aa17d087f3db4d72d78680a)) { $__attrsStackf11f89c11aa17d087f3db4d72d78680a[] = $__attrsf11f89c11aa17d087f3db4d72d78680a; } ?>
<?php $__attrsf11f89c11aa17d087f3db4d72d78680a = ['kbd' => $tooltipKbd,'class' => 'not-in-data-flux-sidebar-collapsed-desktop:hidden cursor-default']; ?>
<?php $__slotsf11f89c11aa17d087f3db4d72d78680a = []; ?>
<?php $__blaze->pushData($__attrsf11f89c11aa17d087f3db4d72d78680a); ?>
<?php ob_start(); ?>
        <?php echo e($tooltip); ?>

    <?php $__slotsf11f89c11aa17d087f3db4d72d78680a['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsf11f89c11aa17d087f3db4d72d78680a); ?>
<?php _f11f89c11aa17d087f3db4d72d78680a($__blaze, $__attrsf11f89c11aa17d087f3db4d72d78680a, $__slotsf11f89c11aa17d087f3db4d72d78680a, ['kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackf11f89c11aa17d087f3db4d72d78680a)) { $__slotsf11f89c11aa17d087f3db4d72d78680a = array_pop($__slotsStackf11f89c11aa17d087f3db4d72d78680a); } ?>
<?php if (! empty($__attrsStackf11f89c11aa17d087f3db4d72d78680a)) { $__attrsf11f89c11aa17d087f3db4d72d78680a = array_pop($__attrsStackf11f89c11aa17d087f3db4d72d78680a); } ?>
<?php $__blaze->popData(); ?>
<?php $__slotsd2ff6bde64aba3d6d9e0ef81fb505b85['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsd2ff6bde64aba3d6d9e0ef81fb505b85); ?>
<?php _d2ff6bde64aba3d6d9e0ef81fb505b85($__blaze, $__attrsd2ff6bde64aba3d6d9e0ef81fb505b85, $__slotsd2ff6bde64aba3d6d9e0ef81fb505b85, ['position', 'class'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackd2ff6bde64aba3d6d9e0ef81fb505b85)) { $__slotsd2ff6bde64aba3d6d9e0ef81fb505b85 = array_pop($__slotsStackd2ff6bde64aba3d6d9e0ef81fb505b85); } ?>
<?php if (! empty($__attrsStackd2ff6bde64aba3d6d9e0ef81fb505b85)) { $__attrsd2ff6bde64aba3d6d9e0ef81fb505b85 = array_pop($__attrsStackd2ff6bde64aba3d6d9e0ef81fb505b85); } ?>
<?php $__blaze->popData(); ?><?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH D:\laragon\www\siix-portal-new\vendor\livewire\flux\stubs\resources\views\flux\sidebar\search.blade.php ENDPATH**/ ?>