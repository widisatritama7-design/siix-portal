<?php
if (!function_exists('_1be249241d64c401ab559a09bc4e4792')):
function _1be249241d64c401ab559a09bc4e4792($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php $iconTrailing ??= $attributes->pluck('icon:trailing'); ?>
<?php $iconVariant ??= $attributes->pluck('icon:variant'); ?>

<?php
$__awareDefaults = [ 'variant' ];
$variant = $__blaze->getConsumableData('variant'); unset($attributes['variant']);
unset($__awareDefaults);
?>

<?php
$__defaults = [
    'iconVariant' => 'outline',
    'iconTrailing' => null,
    'badgeColor' => null,
    'variant' => null,
    'iconDot' => null,
    'accent' => true,
    'square' => null,
    'badge' => null,
    'icon' => null,
];
$iconVariant ??= $attributes['icon-variant'] ?? $attributes['iconVariant'] ?? $__defaults['iconVariant']; unset($attributes['iconVariant'], $attributes['icon-variant']);
$iconTrailing ??= $attributes['icon-trailing'] ?? $attributes['iconTrailing'] ?? $__defaults['iconTrailing']; unset($attributes['iconTrailing'], $attributes['icon-trailing']);
$badgeColor ??= $attributes['badge-color'] ?? $attributes['badgeColor'] ?? $__defaults['badgeColor']; unset($attributes['badgeColor'], $attributes['badge-color']);
$variant ??= $attributes['variant'] ?? $__defaults['variant']; unset($attributes['variant']);
$iconDot ??= $attributes['icon-dot'] ?? $attributes['iconDot'] ?? $__defaults['iconDot']; unset($attributes['iconDot'], $attributes['icon-dot']);
$accent ??= $attributes['accent'] ?? $__defaults['accent']; unset($attributes['accent']);
$square ??= $attributes['square'] ?? $__defaults['square']; unset($attributes['square']);
$badge ??= $attributes['badge'] ?? $__defaults['badge']; unset($attributes['badge']);
$icon ??= $attributes['icon'] ?? $__defaults['icon']; unset($attributes['icon']);
unset($__defaults);
?>

<?php
// Button should be a square if it has no text contents...
$square ??= $slot->isEmpty();

// Size-up icons in square/icon-only buttons...
$iconClasses = Flux::classes($square ? 'size-6' : 'size-5');

$classes = Flux::classes()
    ->add('px-3 h-8 flex items-center rounded-lg')
    ->add('relative') // This is here for the "active" bar at the bottom to be positioned correctly...
    ->add($square ? '' : 'px-2.5!')
    ->add('text-zinc-500 dark:text-white/80 ')
    // Styles for when this link is the "current" one...
    ->add('data-current:after:absolute data-current:after:-bottom-3 data-current:after:inset-x-0 data-current:after:h-[2px]')
    ->add([
        '[--hover-fill:color-mix(in_oklab,_var(--color-accent-content),_transparent_90%)]',

    ])
    ->add(match ($accent) {
        true => [
            'hover:text-zinc-800 dark:hover:text-white',
            'data-current:text-(--color-accent-content) hover:data-current:text-(--color-accent-content) hover:bg-zinc-800/5 dark:hover:bg-white/10 hover:data-current:bg-(--hover-fill)',
            'data-current:after:bg-(--color-accent-content)',
        ],
        false => [
            'hover:text-zinc-800 dark:hover:text-white',
            'data-current:text-zinc-800 dark:data-current:text-zinc-100 hover:bg-zinc-100 dark:hover:bg-white/10',
            'data-current:after:bg-zinc-800 dark:data-current:after:bg-white',
        ],
    })
    ;
?>

<?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button-or-link.blade.php', $__blaze->compiledPath.'/e15fae2b87389bf39175b14bf00b9cfd.php'); ?>
<?php if (isset($__slotse15fae2b87389bf39175b14bf00b9cfd)) { $__slotsStacke15fae2b87389bf39175b14bf00b9cfd[] = $__slotse15fae2b87389bf39175b14bf00b9cfd; } ?>
<?php if (isset($__attrse15fae2b87389bf39175b14bf00b9cfd)) { $__attrsStacke15fae2b87389bf39175b14bf00b9cfd[] = $__attrse15fae2b87389bf39175b14bf00b9cfd; } ?>
<?php $__attrse15fae2b87389bf39175b14bf00b9cfd = ['attributes' => $attributes->class($classes),'dataFluxNavbarItems' => true]; ?>
<?php $__slotse15fae2b87389bf39175b14bf00b9cfd = []; ?>
<?php $__blaze->pushData($__attrse15fae2b87389bf39175b14bf00b9cfd); ?>
<?php ob_start(); ?>
    <?php if ($icon): ?>
        <div class="relative">
            <?php if (is_string($icon) && $icon !== ''): ?>
                <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['icon' => $icon, 'variant' => $iconVariant, 'class' => $iconClasses]); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/ebfb27feae87a3d873cb5ef75a09aacc.php'); ?>
<?php $__blaze->pushData(['icon' => $icon,'variant' => $iconVariant,'class' => $iconClasses]); ?>
<?php _ebfb27feae87a3d873cb5ef75a09aacc($__blaze, ['icon' => $icon,'variant' => $iconVariant,'class' => $iconClasses], [], ['icon', 'variant'], [], $__this ?? (isset($this) ? $this : null)); ?>
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
        <div class="<?php echo e($icon ? 'ms-3' : ''); ?> flex-1 text-sm font-medium leading-none whitespace-nowrap [[data-nav-footer]_&]:hidden [[data-nav-sidebar]_[data-nav-footer]_&]:block" data-content><?php echo e($slot); ?></div>
    <?php endif; ?>

    <?php if (is_string($iconTrailing) && $iconTrailing !== ''): ?>
        <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['icon' => $iconTrailing, 'variant' => 'micro', 'class' => 'size-4 ms-1']); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/ebfb27feae87a3d873cb5ef75a09aacc.php'); ?>
<?php $__blaze->pushData(['icon' => $iconTrailing,'variant' => 'micro','class' => 'size-4 ms-1']); ?>
<?php _ebfb27feae87a3d873cb5ef75a09aacc($__blaze, ['icon' => $iconTrailing,'variant' => 'micro','class' => 'size-4 ms-1'], [], ['icon'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
    <?php elseif ($iconTrailing): ?>
        <?php echo e($iconTrailing); ?>

    <?php endif; ?>

    <?php if (isset($badge) && $badge !== ''): ?>
        <?php $badgeAttributes = Flux::attributesAfter('badge:', $attributes, ['color' => $badgeColor, 'class' => 'ms-2']); ?>
        <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/navbar/badge.blade.php', $__blaze->compiledPath.'/d1c5553f6890e0b8e3dc6857eaadbfb3.php'); ?>
<?php if (isset($__slotsd1c5553f6890e0b8e3dc6857eaadbfb3)) { $__slotsStackd1c5553f6890e0b8e3dc6857eaadbfb3[] = $__slotsd1c5553f6890e0b8e3dc6857eaadbfb3; } ?>
<?php if (isset($__attrsd1c5553f6890e0b8e3dc6857eaadbfb3)) { $__attrsStackd1c5553f6890e0b8e3dc6857eaadbfb3[] = $__attrsd1c5553f6890e0b8e3dc6857eaadbfb3; } ?>
<?php $__attrsd1c5553f6890e0b8e3dc6857eaadbfb3 = ['attributes' => $badgeAttributes]; ?>
<?php $__slotsd1c5553f6890e0b8e3dc6857eaadbfb3 = []; ?>
<?php $__blaze->pushData($__attrsd1c5553f6890e0b8e3dc6857eaadbfb3); ?>
<?php ob_start(); ?><?php echo e($badge); ?><?php $__slotsd1c5553f6890e0b8e3dc6857eaadbfb3['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsd1c5553f6890e0b8e3dc6857eaadbfb3); ?>
<?php _d1c5553f6890e0b8e3dc6857eaadbfb3($__blaze, $__attrsd1c5553f6890e0b8e3dc6857eaadbfb3, $__slotsd1c5553f6890e0b8e3dc6857eaadbfb3, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackd1c5553f6890e0b8e3dc6857eaadbfb3)) { $__slotsd1c5553f6890e0b8e3dc6857eaadbfb3 = array_pop($__slotsStackd1c5553f6890e0b8e3dc6857eaadbfb3); } ?>
<?php if (! empty($__attrsStackd1c5553f6890e0b8e3dc6857eaadbfb3)) { $__attrsd1c5553f6890e0b8e3dc6857eaadbfb3 = array_pop($__attrsStackd1c5553f6890e0b8e3dc6857eaadbfb3); } ?>
<?php $__blaze->popData(); ?>
    <?php endif; ?>
<?php $__slotse15fae2b87389bf39175b14bf00b9cfd['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotse15fae2b87389bf39175b14bf00b9cfd); ?>
<?php _e15fae2b87389bf39175b14bf00b9cfd($__blaze, $__attrse15fae2b87389bf39175b14bf00b9cfd, $__slotse15fae2b87389bf39175b14bf00b9cfd, ['attributes', 'dataFluxNavbarItems'], ['dataFluxNavbarItems' => 'data-flux-navbar-items'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacke15fae2b87389bf39175b14bf00b9cfd)) { $__slotse15fae2b87389bf39175b14bf00b9cfd = array_pop($__slotsStacke15fae2b87389bf39175b14bf00b9cfd); } ?>
<?php if (! empty($__attrsStacke15fae2b87389bf39175b14bf00b9cfd)) { $__attrse15fae2b87389bf39175b14bf00b9cfd = array_pop($__attrsStacke15fae2b87389bf39175b14bf00b9cfd); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/stubs/resources/views/flux/navbar/item.blade.php ENDPATH**/ ?>