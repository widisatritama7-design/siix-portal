<?php
if (!function_exists('_179bc737bd354db035e2b8ba3470dc3a')):
function _179bc737bd354db035e2b8ba3470dc3a($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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

<?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/index.blade.php', $__blaze->compiledPath.'/cb8a57a3c873d97b481cdaf828b812c9.php'); ?>
<?php if (isset($__slotscb8a57a3c873d97b481cdaf828b812c9)) { $__slotsStackcb8a57a3c873d97b481cdaf828b812c9[] = $__slotscb8a57a3c873d97b481cdaf828b812c9; } ?>
<?php if (isset($__attrscb8a57a3c873d97b481cdaf828b812c9)) { $__attrsStackcb8a57a3c873d97b481cdaf828b812c9[] = $__attrscb8a57a3c873d97b481cdaf828b812c9; } ?>
<?php $__attrscb8a57a3c873d97b481cdaf828b812c9 = ['position' => $tooltipPosition]; ?>
<?php $__slotscb8a57a3c873d97b481cdaf828b812c9 = []; ?>
<?php $__blaze->pushData($__attrscb8a57a3c873d97b481cdaf828b812c9); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/button-or-link.blade.php', $__blaze->compiledPath.'/02759a854a41f982080d17f93bae4f3a.php'); ?>
<?php if (isset($__slots02759a854a41f982080d17f93bae4f3a)) { $__slotsStack02759a854a41f982080d17f93bae4f3a[] = $__slots02759a854a41f982080d17f93bae4f3a; } ?>
<?php if (isset($__attrs02759a854a41f982080d17f93bae4f3a)) { $__attrsStack02759a854a41f982080d17f93bae4f3a[] = $__attrs02759a854a41f982080d17f93bae4f3a; } ?>
<?php $__attrs02759a854a41f982080d17f93bae4f3a = ['attributes' => $attributes->class($classes),'dataFluxSidebarItem' => true]; ?>
<?php $__slots02759a854a41f982080d17f93bae4f3a = []; ?>
<?php $__blaze->pushData($__attrs02759a854a41f982080d17f93bae4f3a); ?>
<?php ob_start(); ?>
        <?php if ($icon): ?>
            <div class="relative">
                <?php if (is_string($icon) && $icon !== ''): ?>
                    <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['icon' => $icon, 'variant' => $iconVariant, 'class' => $iconClasses]); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/eef604805fab17af9c5c417f42e7112f.php'); ?>
<?php $__blaze->pushData(['icon' => $icon,'variant' => $iconVariant,'class' => $iconClasses]); ?>
<?php _eef604805fab17af9c5c417f42e7112f($__blaze, ['icon' => $icon,'variant' => $iconVariant,'class' => $iconClasses], [], ['icon', 'variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
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
            <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['icon' => $iconTrailing, 'variant' => $iconVariant, 'class' => 'in-data-flux-sidebar-collapsed-desktop:not-in-data-flux-sidebar-group-dropdown:hidden size-4!']); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/eef604805fab17af9c5c417f42e7112f.php'); ?>
<?php $__blaze->pushData(['icon' => $iconTrailing,'variant' => $iconVariant,'class' => 'in-data-flux-sidebar-collapsed-desktop:not-in-data-flux-sidebar-group-dropdown:hidden size-4!']); ?>
<?php _eef604805fab17af9c5c417f42e7112f($__blaze, ['icon' => $iconTrailing,'variant' => $iconVariant,'class' => 'in-data-flux-sidebar-collapsed-desktop:not-in-data-flux-sidebar-group-dropdown:hidden size-4!'], [], ['icon', 'variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
        <?php elseif ($iconTrailing): ?>
            <?php echo e($iconTrailing); ?>

        <?php endif; ?>

        <?php if (isset($badge) && $badge !== ''): ?>
            <?php $badgeAttributes = Flux::attributesAfter('badge:', $attributes, ['color' => $badgeColor]); ?>
            <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/navlist/badge.blade.php', $__blaze->compiledPath.'/5e7ce10796d61da1e01c7c8e43fb734a.php'); ?>
<?php if (isset($__slots5e7ce10796d61da1e01c7c8e43fb734a)) { $__slotsStack5e7ce10796d61da1e01c7c8e43fb734a[] = $__slots5e7ce10796d61da1e01c7c8e43fb734a; } ?>
<?php if (isset($__attrs5e7ce10796d61da1e01c7c8e43fb734a)) { $__attrsStack5e7ce10796d61da1e01c7c8e43fb734a[] = $__attrs5e7ce10796d61da1e01c7c8e43fb734a; } ?>
<?php $__attrs5e7ce10796d61da1e01c7c8e43fb734a = ['attributes' => $badgeAttributes,'class' => 'in-data-flux-sidebar-collapsed-desktop:not-in-data-flux-sidebar-group-dropdown:hidden']; ?>
<?php $__slots5e7ce10796d61da1e01c7c8e43fb734a = []; ?>
<?php $__blaze->pushData($__attrs5e7ce10796d61da1e01c7c8e43fb734a); ?>
<?php ob_start(); ?><?php echo e($badge); ?><?php $__slots5e7ce10796d61da1e01c7c8e43fb734a['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots5e7ce10796d61da1e01c7c8e43fb734a); ?>
<?php _5e7ce10796d61da1e01c7c8e43fb734a($__blaze, $__attrs5e7ce10796d61da1e01c7c8e43fb734a, $__slots5e7ce10796d61da1e01c7c8e43fb734a, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack5e7ce10796d61da1e01c7c8e43fb734a)) { $__slots5e7ce10796d61da1e01c7c8e43fb734a = array_pop($__slotsStack5e7ce10796d61da1e01c7c8e43fb734a); } ?>
<?php if (! empty($__attrsStack5e7ce10796d61da1e01c7c8e43fb734a)) { $__attrs5e7ce10796d61da1e01c7c8e43fb734a = array_pop($__attrsStack5e7ce10796d61da1e01c7c8e43fb734a); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    <?php $__slots02759a854a41f982080d17f93bae4f3a['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots02759a854a41f982080d17f93bae4f3a); ?>
<?php _02759a854a41f982080d17f93bae4f3a($__blaze, $__attrs02759a854a41f982080d17f93bae4f3a, $__slots02759a854a41f982080d17f93bae4f3a, ['attributes', 'dataFluxSidebarItem'], ['dataFluxSidebarItem' => 'data-flux-sidebar-item'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack02759a854a41f982080d17f93bae4f3a)) { $__slots02759a854a41f982080d17f93bae4f3a = array_pop($__slotsStack02759a854a41f982080d17f93bae4f3a); } ?>
<?php if (! empty($__attrsStack02759a854a41f982080d17f93bae4f3a)) { $__attrs02759a854a41f982080d17f93bae4f3a = array_pop($__attrsStack02759a854a41f982080d17f93bae4f3a); } ?>
<?php $__blaze->popData(); ?>

    <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/e91be1baae40126c70a36be3d3a51d83.php'); ?>
<?php if (isset($__slotse91be1baae40126c70a36be3d3a51d83)) { $__slotsStacke91be1baae40126c70a36be3d3a51d83[] = $__slotse91be1baae40126c70a36be3d3a51d83; } ?>
<?php if (isset($__attrse91be1baae40126c70a36be3d3a51d83)) { $__attrsStacke91be1baae40126c70a36be3d3a51d83[] = $__attrse91be1baae40126c70a36be3d3a51d83; } ?>
<?php $__attrse91be1baae40126c70a36be3d3a51d83 = ['kbd' => $tooltipKbd,'class' => 'not-in-data-flux-sidebar-collapsed-desktop:hidden in-data-flux-sidebar-group-dropdown:hidden cursor-default']; ?>
<?php $__slotse91be1baae40126c70a36be3d3a51d83 = []; ?>
<?php $__blaze->pushData($__attrse91be1baae40126c70a36be3d3a51d83); ?>
<?php ob_start(); ?>
        <?php echo e($tooltip); ?>

    <?php $__slotse91be1baae40126c70a36be3d3a51d83['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotse91be1baae40126c70a36be3d3a51d83); ?>
<?php _e91be1baae40126c70a36be3d3a51d83($__blaze, $__attrse91be1baae40126c70a36be3d3a51d83, $__slotse91be1baae40126c70a36be3d3a51d83, ['kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacke91be1baae40126c70a36be3d3a51d83)) { $__slotse91be1baae40126c70a36be3d3a51d83 = array_pop($__slotsStacke91be1baae40126c70a36be3d3a51d83); } ?>
<?php if (! empty($__attrsStacke91be1baae40126c70a36be3d3a51d83)) { $__attrse91be1baae40126c70a36be3d3a51d83 = array_pop($__attrsStacke91be1baae40126c70a36be3d3a51d83); } ?>
<?php $__blaze->popData(); ?>
<?php $__slotscb8a57a3c873d97b481cdaf828b812c9['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotscb8a57a3c873d97b481cdaf828b812c9); ?>
<?php _cb8a57a3c873d97b481cdaf828b812c9($__blaze, $__attrscb8a57a3c873d97b481cdaf828b812c9, $__slotscb8a57a3c873d97b481cdaf828b812c9, ['position'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackcb8a57a3c873d97b481cdaf828b812c9)) { $__slotscb8a57a3c873d97b481cdaf828b812c9 = array_pop($__slotsStackcb8a57a3c873d97b481cdaf828b812c9); } ?>
<?php if (! empty($__attrsStackcb8a57a3c873d97b481cdaf828b812c9)) { $__attrscb8a57a3c873d97b481cdaf828b812c9 = array_pop($__attrsStackcb8a57a3c873d97b481cdaf828b812c9); } ?>
<?php $__blaze->popData(); ?><?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\stubs\resources\views\flux\sidebar\item.blade.php ENDPATH**/ ?>