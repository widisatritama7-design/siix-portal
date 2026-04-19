<?php
if (!function_exists('_76c9f686b7b07c6801ac92a928a010a6')):
function _76c9f686b7b07c6801ac92a928a010a6($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
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
<?php $iconTrailing ??= $attributes->pluck('icon:trailing'); ?>
<?php $iconVariant ??= $attributes->pluck('icon:variant'); ?>

<?php
$__defaults = [
    'tooltipPosition' => 'right',
    'tooltipKbd' => null,
    'tooltip' => null,
    'iconVariant' => 'outline',
    'iconTrailing' => null,
    'badgeColor' => null,
    'iconDot' => null,
    'accent' => true,
    'badge' => null,
    'icon' => null,
];
$tooltipPosition ??= $attributes['tooltip-position'] ?? $attributes['tooltipPosition'] ?? $__defaults['tooltipPosition']; unset($attributes['tooltipPosition'], $attributes['tooltip-position']);
$tooltipKbd ??= $attributes['tooltip-kbd'] ?? $attributes['tooltipKbd'] ?? $__defaults['tooltipKbd']; unset($attributes['tooltipKbd'], $attributes['tooltip-kbd']);
$tooltip ??= $attributes['tooltip'] ?? $__defaults['tooltip']; unset($attributes['tooltip']);
$iconVariant ??= $attributes['icon-variant'] ?? $attributes['iconVariant'] ?? $__defaults['iconVariant']; unset($attributes['iconVariant'], $attributes['icon-variant']);
$iconTrailing ??= $attributes['icon-trailing'] ?? $attributes['iconTrailing'] ?? $__defaults['iconTrailing']; unset($attributes['iconTrailing'], $attributes['icon-trailing']);
$badgeColor ??= $attributes['badge-color'] ?? $attributes['badgeColor'] ?? $__defaults['badgeColor']; unset($attributes['badgeColor'], $attributes['badge-color']);
$iconDot ??= $attributes['icon-dot'] ?? $attributes['iconDot'] ?? $__defaults['iconDot']; unset($attributes['iconDot'], $attributes['icon-dot']);
$accent ??= $attributes['accent'] ?? $__defaults['accent']; unset($attributes['accent']);
$badge ??= $attributes['badge'] ?? $__defaults['badge']; unset($attributes['badge']);
$icon ??= $attributes['icon'] ?? $__defaults['icon']; unset($attributes['icon']);
unset($__defaults);
?>

<?php
$tooltip ??= $slot->isNotEmpty() ? (string) $slot : null;

// Size-up icons in square/icon-only buttons...
$iconClasses = Flux::classes('size-4')
    ->add('in-data-flux-sidebar-group-dropdown:text-zinc-400! dark:in-data-flux-sidebar-group-dropdown:text-white/80!')
    ->add('[[data-flux-sidebar-item]:hover_&]:text-current!');

$classes = Flux::classes()
    ->add('h-8 in-data-flux-sidebar-on-mobile:h-10 relative flex items-center gap-3 rounded-lg')
    ->add('in-data-flux-sidebar-collapsed-desktop:w-10 in-data-flux-sidebar-collapsed-desktop:justify-center')
    ->add('py-0 text-start w-full px-3 has-data-flux-navlist-badge:not-in-data-flux-sidebar-collapsed-desktop:pe-1.5 my-px')
    ->add('text-zinc-500 dark:text-white/80')
    ->add(match ($accent) {
        true => [
            'data-current:text-(--color-accent-content) hover:data-current:text-(--color-accent-content)',
            'data-current:bg-white dark:data-current:bg-white/[7%] data-current:border data-current:border-zinc-200 dark:data-current:border-transparent',
            'hover:text-zinc-800 dark:hover:text-white dark:hover:bg-white/[7%] hover:bg-zinc-800/5 ',
            'border border-transparent',
        ],
        false => [
            'data-current:text-zinc-800 dark:data-current:text-zinc-100 data-current:border-zinc-200',
            'data-current:bg-white dark:data-current:bg-white/10 data-current:border data-current:border-zinc-200 dark:data-current:border-white/10 data-current:shadow-xs',
            'hover:text-zinc-800 dark:hover:text-white',
        ],
    })
    // Override the default styles to match dropdowns for when the item is inside a collapsed group dropdown...
    ->add('in-data-flux-sidebar-group-dropdown:w-auto! in-data-flux-sidebar-group-dropdown:px-2!')
    ->add('in-data-flux-sidebar-group-dropdown:text-zinc-800! in-data-flux-sidebar-group-dropdown:bg-white! in-data-flux-sidebar-group-dropdown:hover:bg-zinc-50!')
    ->add('dark:in-data-flux-sidebar-group-dropdown:text-white! dark:in-data-flux-sidebar-group-dropdown:bg-transparent! dark:in-data-flux-sidebar-group-dropdown:hover:bg-zinc-600!')
    ;
?>

<?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/index.blade.php', $__blaze->compiledPath.'/d2ff6bde64aba3d6d9e0ef81fb505b85.php'); ?>
<?php if (isset($__slotsd2ff6bde64aba3d6d9e0ef81fb505b85)) { $__slotsStackd2ff6bde64aba3d6d9e0ef81fb505b85[] = $__slotsd2ff6bde64aba3d6d9e0ef81fb505b85; } ?>
<?php if (isset($__attrsd2ff6bde64aba3d6d9e0ef81fb505b85)) { $__attrsStackd2ff6bde64aba3d6d9e0ef81fb505b85[] = $__attrsd2ff6bde64aba3d6d9e0ef81fb505b85; } ?>
<?php $__attrsd2ff6bde64aba3d6d9e0ef81fb505b85 = ['position' => $tooltipPosition]; ?>
<?php $__slotsd2ff6bde64aba3d6d9e0ef81fb505b85 = []; ?>
<?php $__blaze->pushData($__attrsd2ff6bde64aba3d6d9e0ef81fb505b85); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/button-or-link.blade.php', $__blaze->compiledPath.'/2c2b7e920e012481c5a60e1d2561fcb9.php'); ?>
<?php if (isset($__slots2c2b7e920e012481c5a60e1d2561fcb9)) { $__slotsStack2c2b7e920e012481c5a60e1d2561fcb9[] = $__slots2c2b7e920e012481c5a60e1d2561fcb9; } ?>
<?php if (isset($__attrs2c2b7e920e012481c5a60e1d2561fcb9)) { $__attrsStack2c2b7e920e012481c5a60e1d2561fcb9[] = $__attrs2c2b7e920e012481c5a60e1d2561fcb9; } ?>
<?php $__attrs2c2b7e920e012481c5a60e1d2561fcb9 = ['attributes' => $attributes->class($classes),'dataFluxSidebarItem' => true]; ?>
<?php $__slots2c2b7e920e012481c5a60e1d2561fcb9 = []; ?>
<?php $__blaze->pushData($__attrs2c2b7e920e012481c5a60e1d2561fcb9); ?>
<?php ob_start(); ?>
        <?php if ($icon): ?>
            <div class="relative">
                <?php if (is_string($icon) && $icon !== ''): ?>
                    <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['icon' => $icon, 'variant' => $iconVariant, 'class' => $iconClasses]); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/0f2a77fb6d4d542c1b97a0147f9e29a8.php'); ?>
<?php $__blaze->pushData(['icon' => $icon,'variant' => $iconVariant,'class' => $iconClasses]); ?>
<?php _0f2a77fb6d4d542c1b97a0147f9e29a8($__blaze, ['icon' => $icon,'variant' => $iconVariant,'class' => $iconClasses], [], ['icon', 'variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
                <?php else: ?>
                    <?php echo e($icon); ?>

                <?php endif; ?>

                <?php if ($iconDot): ?>
                    <div class="absolute top-[-2px] end-[-2px]">
                        <div class="size-[6px] rounded-full bg-zinc-500 dark:bg-zinc-400"></div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($slot->isNotEmpty()): ?>
            <div class="
                in-data-flux-sidebar-collapsed-desktop:not-in-data-flux-sidebar-group-dropdown:hidden
                flex-1 text-sm font-medium truncate [[data-nav-footer]_&]:hidden [[data-nav-sidebar]_[data-nav-footer]_&]:block" data-content><?php echo e($slot); ?></div>
        <?php endif; ?>

        <?php if (is_string($iconTrailing) && $iconTrailing !== ''): ?>
            <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['icon' => $iconTrailing, 'variant' => $iconVariant, 'class' => 'in-data-flux-sidebar-collapsed-desktop:not-in-data-flux-sidebar-group-dropdown:hidden size-4!']); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/0f2a77fb6d4d542c1b97a0147f9e29a8.php'); ?>
<?php $__blaze->pushData(['icon' => $iconTrailing,'variant' => $iconVariant,'class' => 'in-data-flux-sidebar-collapsed-desktop:not-in-data-flux-sidebar-group-dropdown:hidden size-4!']); ?>
<?php _0f2a77fb6d4d542c1b97a0147f9e29a8($__blaze, ['icon' => $iconTrailing,'variant' => $iconVariant,'class' => 'in-data-flux-sidebar-collapsed-desktop:not-in-data-flux-sidebar-group-dropdown:hidden size-4!'], [], ['icon', 'variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
        <?php elseif ($iconTrailing): ?>
            <?php echo e($iconTrailing); ?>

        <?php endif; ?>

        <?php if (isset($badge) && $badge !== ''): ?>
            <?php $badgeAttributes = Flux::attributesAfter('badge:', $attributes, ['color' => $badgeColor]); ?>
            <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/navlist/badge.blade.php', $__blaze->compiledPath.'/2e3507dc8992ac4bf0629f46bf727f4b.php'); ?>
<?php if (isset($__slots2e3507dc8992ac4bf0629f46bf727f4b)) { $__slotsStack2e3507dc8992ac4bf0629f46bf727f4b[] = $__slots2e3507dc8992ac4bf0629f46bf727f4b; } ?>
<?php if (isset($__attrs2e3507dc8992ac4bf0629f46bf727f4b)) { $__attrsStack2e3507dc8992ac4bf0629f46bf727f4b[] = $__attrs2e3507dc8992ac4bf0629f46bf727f4b; } ?>
<?php $__attrs2e3507dc8992ac4bf0629f46bf727f4b = ['attributes' => $badgeAttributes,'class' => 'in-data-flux-sidebar-collapsed-desktop:not-in-data-flux-sidebar-group-dropdown:hidden']; ?>
<?php $__slots2e3507dc8992ac4bf0629f46bf727f4b = []; ?>
<?php $__blaze->pushData($__attrs2e3507dc8992ac4bf0629f46bf727f4b); ?>
<?php ob_start(); ?><?php echo e($badge); ?><?php $__slots2e3507dc8992ac4bf0629f46bf727f4b['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots2e3507dc8992ac4bf0629f46bf727f4b); ?>
<?php _2e3507dc8992ac4bf0629f46bf727f4b($__blaze, $__attrs2e3507dc8992ac4bf0629f46bf727f4b, $__slots2e3507dc8992ac4bf0629f46bf727f4b, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack2e3507dc8992ac4bf0629f46bf727f4b)) { $__slots2e3507dc8992ac4bf0629f46bf727f4b = array_pop($__slotsStack2e3507dc8992ac4bf0629f46bf727f4b); } ?>
<?php if (! empty($__attrsStack2e3507dc8992ac4bf0629f46bf727f4b)) { $__attrs2e3507dc8992ac4bf0629f46bf727f4b = array_pop($__attrsStack2e3507dc8992ac4bf0629f46bf727f4b); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    <?php $__slots2c2b7e920e012481c5a60e1d2561fcb9['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots2c2b7e920e012481c5a60e1d2561fcb9); ?>
<?php _2c2b7e920e012481c5a60e1d2561fcb9($__blaze, $__attrs2c2b7e920e012481c5a60e1d2561fcb9, $__slots2c2b7e920e012481c5a60e1d2561fcb9, ['attributes', 'dataFluxSidebarItem'], ['dataFluxSidebarItem' => 'data-flux-sidebar-item'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack2c2b7e920e012481c5a60e1d2561fcb9)) { $__slots2c2b7e920e012481c5a60e1d2561fcb9 = array_pop($__slotsStack2c2b7e920e012481c5a60e1d2561fcb9); } ?>
<?php if (! empty($__attrsStack2c2b7e920e012481c5a60e1d2561fcb9)) { $__attrs2c2b7e920e012481c5a60e1d2561fcb9 = array_pop($__attrsStack2c2b7e920e012481c5a60e1d2561fcb9); } ?>
<?php $__blaze->popData(); ?>

    <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/f11f89c11aa17d087f3db4d72d78680a.php'); ?>
<?php if (isset($__slotsf11f89c11aa17d087f3db4d72d78680a)) { $__slotsStackf11f89c11aa17d087f3db4d72d78680a[] = $__slotsf11f89c11aa17d087f3db4d72d78680a; } ?>
<?php if (isset($__attrsf11f89c11aa17d087f3db4d72d78680a)) { $__attrsStackf11f89c11aa17d087f3db4d72d78680a[] = $__attrsf11f89c11aa17d087f3db4d72d78680a; } ?>
<?php $__attrsf11f89c11aa17d087f3db4d72d78680a = ['kbd' => $tooltipKbd,'class' => 'not-in-data-flux-sidebar-collapsed-desktop:hidden in-data-flux-sidebar-group-dropdown:hidden cursor-default']; ?>
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
<?php _d2ff6bde64aba3d6d9e0ef81fb505b85($__blaze, $__attrsd2ff6bde64aba3d6d9e0ef81fb505b85, $__slotsd2ff6bde64aba3d6d9e0ef81fb505b85, ['position'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackd2ff6bde64aba3d6d9e0ef81fb505b85)) { $__slotsd2ff6bde64aba3d6d9e0ef81fb505b85 = array_pop($__slotsStackd2ff6bde64aba3d6d9e0ef81fb505b85); } ?>
<?php if (! empty($__attrsStackd2ff6bde64aba3d6d9e0ef81fb505b85)) { $__attrsd2ff6bde64aba3d6d9e0ef81fb505b85 = array_pop($__attrsStackd2ff6bde64aba3d6d9e0ef81fb505b85); } ?>
<?php $__blaze->popData(); ?><?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH D:\laragon\www\siix-portal-new\vendor\livewire\flux\stubs\resources\views\flux\sidebar\item.blade.php ENDPATH**/ ?>