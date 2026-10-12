<?php
if (!function_exists('_09dd52e9de45ad128f8eb8f9b3f1fc85')):
function _09dd52e9de45ad128f8eb8f9b3f1fc85($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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

<?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/index.blade.php', $__blaze->compiledPath.'/1e349890a464f9948f6af12013af6f7e.php'); ?>
<?php if (isset($__slots1e349890a464f9948f6af12013af6f7e)) { $__slotsStack1e349890a464f9948f6af12013af6f7e[] = $__slots1e349890a464f9948f6af12013af6f7e; } ?>
<?php if (isset($__attrs1e349890a464f9948f6af12013af6f7e)) { $__attrsStack1e349890a464f9948f6af12013af6f7e[] = $__attrs1e349890a464f9948f6af12013af6f7e; } ?>
<?php $__attrs1e349890a464f9948f6af12013af6f7e = ['position' => $tooltipPosition]; ?>
<?php $__slots1e349890a464f9948f6af12013af6f7e = []; ?>
<?php $__blaze->pushData($__attrs1e349890a464f9948f6af12013af6f7e); ?>
<?php ob_start(); ?>
    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button-or-link.blade.php', $__blaze->compiledPath.'/fb0f0c9f2b14ec670f23402b8084123d.php'); ?>
<?php if (isset($__slotsfb0f0c9f2b14ec670f23402b8084123d)) { $__slotsStackfb0f0c9f2b14ec670f23402b8084123d[] = $__slotsfb0f0c9f2b14ec670f23402b8084123d; } ?>
<?php if (isset($__attrsfb0f0c9f2b14ec670f23402b8084123d)) { $__attrsStackfb0f0c9f2b14ec670f23402b8084123d[] = $__attrsfb0f0c9f2b14ec670f23402b8084123d; } ?>
<?php $__attrsfb0f0c9f2b14ec670f23402b8084123d = ['attributes' => $attributes->class($classes),'dataFluxSidebarItem' => true]; ?>
<?php $__slotsfb0f0c9f2b14ec670f23402b8084123d = []; ?>
<?php $__blaze->pushData($__attrsfb0f0c9f2b14ec670f23402b8084123d); ?>
<?php ob_start(); ?>
        <?php if ($icon): ?>
            <div class="relative">
                <?php if (is_string($icon) && $icon !== ''): ?>
                    <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['icon' => $icon, 'variant' => $iconVariant, 'class' => $iconClasses]); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/b462ffebaca45ac18a5d2c5540ab64d7.php'); ?>
<?php $__blaze->pushData(['icon' => $icon,'variant' => $iconVariant,'class' => $iconClasses]); ?>
<?php _b462ffebaca45ac18a5d2c5540ab64d7($__blaze, ['icon' => $icon,'variant' => $iconVariant,'class' => $iconClasses], [], ['icon', 'variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
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
            <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['icon' => $iconTrailing, 'variant' => $iconVariant, 'class' => 'in-data-flux-sidebar-collapsed-desktop:not-in-data-flux-sidebar-group-dropdown:hidden size-4!']); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/b462ffebaca45ac18a5d2c5540ab64d7.php'); ?>
<?php $__blaze->pushData(['icon' => $iconTrailing,'variant' => $iconVariant,'class' => 'in-data-flux-sidebar-collapsed-desktop:not-in-data-flux-sidebar-group-dropdown:hidden size-4!']); ?>
<?php _b462ffebaca45ac18a5d2c5540ab64d7($__blaze, ['icon' => $iconTrailing,'variant' => $iconVariant,'class' => 'in-data-flux-sidebar-collapsed-desktop:not-in-data-flux-sidebar-group-dropdown:hidden size-4!'], [], ['icon', 'variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
        <?php elseif ($iconTrailing): ?>
            <?php echo e($iconTrailing); ?>

        <?php endif; ?>

        <?php if (isset($badge) && $badge !== ''): ?>
            <?php $badgeAttributes = Flux::attributesAfter('badge:', $attributes, ['color' => $badgeColor]); ?>
            <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/navlist/badge.blade.php', $__blaze->compiledPath.'/76a923ee8788fc0a6efc14324732f793.php'); ?>
<?php if (isset($__slots76a923ee8788fc0a6efc14324732f793)) { $__slotsStack76a923ee8788fc0a6efc14324732f793[] = $__slots76a923ee8788fc0a6efc14324732f793; } ?>
<?php if (isset($__attrs76a923ee8788fc0a6efc14324732f793)) { $__attrsStack76a923ee8788fc0a6efc14324732f793[] = $__attrs76a923ee8788fc0a6efc14324732f793; } ?>
<?php $__attrs76a923ee8788fc0a6efc14324732f793 = ['attributes' => $badgeAttributes,'class' => 'in-data-flux-sidebar-collapsed-desktop:not-in-data-flux-sidebar-group-dropdown:hidden']; ?>
<?php $__slots76a923ee8788fc0a6efc14324732f793 = []; ?>
<?php $__blaze->pushData($__attrs76a923ee8788fc0a6efc14324732f793); ?>
<?php ob_start(); ?><?php echo e($badge); ?><?php $__slots76a923ee8788fc0a6efc14324732f793['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots76a923ee8788fc0a6efc14324732f793); ?>
<?php _76a923ee8788fc0a6efc14324732f793($__blaze, $__attrs76a923ee8788fc0a6efc14324732f793, $__slots76a923ee8788fc0a6efc14324732f793, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack76a923ee8788fc0a6efc14324732f793)) { $__slots76a923ee8788fc0a6efc14324732f793 = array_pop($__slotsStack76a923ee8788fc0a6efc14324732f793); } ?>
<?php if (! empty($__attrsStack76a923ee8788fc0a6efc14324732f793)) { $__attrs76a923ee8788fc0a6efc14324732f793 = array_pop($__attrsStack76a923ee8788fc0a6efc14324732f793); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>
    <?php $__slotsfb0f0c9f2b14ec670f23402b8084123d['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsfb0f0c9f2b14ec670f23402b8084123d); ?>
<?php _fb0f0c9f2b14ec670f23402b8084123d($__blaze, $__attrsfb0f0c9f2b14ec670f23402b8084123d, $__slotsfb0f0c9f2b14ec670f23402b8084123d, ['attributes', 'dataFluxSidebarItem'], ['dataFluxSidebarItem' => 'data-flux-sidebar-item'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackfb0f0c9f2b14ec670f23402b8084123d)) { $__slotsfb0f0c9f2b14ec670f23402b8084123d = array_pop($__slotsStackfb0f0c9f2b14ec670f23402b8084123d); } ?>
<?php if (! empty($__attrsStackfb0f0c9f2b14ec670f23402b8084123d)) { $__attrsfb0f0c9f2b14ec670f23402b8084123d = array_pop($__attrsStackfb0f0c9f2b14ec670f23402b8084123d); } ?>
<?php $__blaze->popData(); ?>

    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/tooltip/content.blade.php', $__blaze->compiledPath.'/4f1bc3520d308fb4cf3904c7ea7a68ad.php'); ?>
<?php if (isset($__slots4f1bc3520d308fb4cf3904c7ea7a68ad)) { $__slotsStack4f1bc3520d308fb4cf3904c7ea7a68ad[] = $__slots4f1bc3520d308fb4cf3904c7ea7a68ad; } ?>
<?php if (isset($__attrs4f1bc3520d308fb4cf3904c7ea7a68ad)) { $__attrsStack4f1bc3520d308fb4cf3904c7ea7a68ad[] = $__attrs4f1bc3520d308fb4cf3904c7ea7a68ad; } ?>
<?php $__attrs4f1bc3520d308fb4cf3904c7ea7a68ad = ['kbd' => $tooltipKbd,'class' => 'not-in-data-flux-sidebar-collapsed-desktop:hidden in-data-flux-sidebar-group-dropdown:hidden cursor-default']; ?>
<?php $__slots4f1bc3520d308fb4cf3904c7ea7a68ad = []; ?>
<?php $__blaze->pushData($__attrs4f1bc3520d308fb4cf3904c7ea7a68ad); ?>
<?php ob_start(); ?>
        <?php echo e($tooltip); ?>

    <?php $__slots4f1bc3520d308fb4cf3904c7ea7a68ad['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots4f1bc3520d308fb4cf3904c7ea7a68ad); ?>
<?php _4f1bc3520d308fb4cf3904c7ea7a68ad($__blaze, $__attrs4f1bc3520d308fb4cf3904c7ea7a68ad, $__slots4f1bc3520d308fb4cf3904c7ea7a68ad, ['kbd'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack4f1bc3520d308fb4cf3904c7ea7a68ad)) { $__slots4f1bc3520d308fb4cf3904c7ea7a68ad = array_pop($__slotsStack4f1bc3520d308fb4cf3904c7ea7a68ad); } ?>
<?php if (! empty($__attrsStack4f1bc3520d308fb4cf3904c7ea7a68ad)) { $__attrs4f1bc3520d308fb4cf3904c7ea7a68ad = array_pop($__attrsStack4f1bc3520d308fb4cf3904c7ea7a68ad); } ?>
<?php $__blaze->popData(); ?>
<?php $__slots1e349890a464f9948f6af12013af6f7e['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots1e349890a464f9948f6af12013af6f7e); ?>
<?php _1e349890a464f9948f6af12013af6f7e($__blaze, $__attrs1e349890a464f9948f6af12013af6f7e, $__slots1e349890a464f9948f6af12013af6f7e, ['position'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack1e349890a464f9948f6af12013af6f7e)) { $__slots1e349890a464f9948f6af12013af6f7e = array_pop($__slotsStack1e349890a464f9948f6af12013af6f7e); } ?>
<?php if (! empty($__attrsStack1e349890a464f9948f6af12013af6f7e)) { $__attrs1e349890a464f9948f6af12013af6f7e = array_pop($__attrsStack1e349890a464f9948f6af12013af6f7e); } ?>
<?php $__blaze->popData(); ?><?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/stubs/resources/views/flux/sidebar/item.blade.php ENDPATH**/ ?>