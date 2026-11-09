<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('_b5452c7974dff5893c37ff2f3b26aa91')):
function _b5452c7974dff5893c37ff2f3b26aa91($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = new \Livewire\Blaze\Runtime\BlazeAttributeBag($__attributes);
unset($__data, $__attributes);
ob_start();
?>


<?php $iconTrailing ??= $attributes->pluck('icon:trailing'); ?>
<?php $iconVariant ??= $attributes->pluck('icon:variant'); ?>

<?php
$__awareDefaults = [ 'variant' ];
$variant = $__blaze->getConsumableData('variant');
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
    'badge' => null,
    'icon' => null,
];
$iconVariant ??= $attributes['icon-variant'] ?? $attributes['iconVariant'] ?? $__defaults['iconVariant']; unset($attributes['iconVariant'], $attributes['icon-variant']);
$iconTrailing ??= $attributes['icon-trailing'] ?? $attributes['iconTrailing'] ?? $__defaults['iconTrailing']; unset($attributes['iconTrailing'], $attributes['icon-trailing']);
$badgeColor ??= $attributes['badge-color'] ?? $attributes['badgeColor'] ?? $__defaults['badgeColor']; unset($attributes['badgeColor'], $attributes['badge-color']);
$variant ??= $attributes['variant'] ?? $__defaults['variant']; unset($attributes['variant']);
$iconDot ??= $attributes['icon-dot'] ?? $attributes['iconDot'] ?? $__defaults['iconDot']; unset($attributes['iconDot'], $attributes['icon-dot']);
$accent ??= $attributes['accent'] ?? $__defaults['accent']; unset($attributes['accent']);
$badge ??= $attributes['badge'] ?? $__defaults['badge']; unset($attributes['badge']);
$icon ??= $attributes['icon'] ?? $__defaults['icon']; unset($attributes['icon']);
unset($__defaults);
?>

<?php
// Button should be a square if it has no text contents...
$square ??= $slot->isEmpty();

// Size-up icons in square/icon-only buttons...
$iconClasses = Flux::classes($square ? 'size-5!' : 'size-4!');

$classes = Flux::classes()
    ->add('h-10 lg:h-8 relative flex items-center gap-3 rounded-lg')
    ->add($square ? 'px-2.5!' : '')
    ->add('py-0 text-start w-full px-3 my-px')
    ->add('text-zinc-500 dark:text-white/80')
    ->add(match ($variant) {
        'outline' => match ($accent) {
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
        },
        default => match ($accent) {
            true => [
                'data-current:text-(--color-accent-content) hover:data-current:text-(--color-accent-content)',
                'data-current:bg-zinc-800/[4%] dark:data-current:bg-white/[7%]',
                'hover:text-zinc-800 dark:hover:text-white hover:bg-zinc-800/[4%] dark:hover:bg-white/[7%]',
            ],
            false => [
                'data-current:text-zinc-800 dark:data-current:text-zinc-100',
                'data-current:bg-zinc-800/[4%] dark:data-current:bg-white/10',
                'hover:text-zinc-800 dark:hover:text-white hover:bg-zinc-800/[4%] dark:hover:bg-white/10',
            ],
        },
    })
    ;
?>

<?php if (!function_exists('_066213161da87cc54926f2e443a2823d')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/button-or-link.blade.php'); } ?>
<?php if (isset($__slots066213161da87cc54926f2e443a2823d)) { $__slotsStack066213161da87cc54926f2e443a2823d[] = $__slots066213161da87cc54926f2e443a2823d; } ?>
<?php if (isset($__data066213161da87cc54926f2e443a2823d)) { $__dataStack066213161da87cc54926f2e443a2823d[] = $__data066213161da87cc54926f2e443a2823d; } ?>
<?php $__data066213161da87cc54926f2e443a2823d = ['attributes' => $attributes->class($classes),'dataFluxNavlistItem' => true]; ?>
<?php $__slots066213161da87cc54926f2e443a2823d = []; ?>
<?php $__blaze->pushData($__data066213161da87cc54926f2e443a2823d); ?>
<?php ob_start(); ?>
    <?php if ($icon): ?>
        <div class="relative">
            <?php if (is_string($icon) && $icon !== ''): ?>
                <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['icon' => $icon, 'variant' => $iconVariant, 'class' => $iconClasses]); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php if (!function_exists('_57a62cf6cbd1d815dfc05dc37d7a0061')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php'); } ?>
<?php $__componentData = ['icon' => $icon,'variant' => $iconVariant,'class' => $iconClasses]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _57a62cf6cbd1d815dfc05dc37d7a0061($__blaze, $__componentData, ['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['icon']), 'variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['variant']), 'class' => $__componentData['class']], [], $__this ?? (isset($this) ? $this : null)); ?>
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
        <div class="flex-1 text-sm font-medium leading-none whitespace-nowrap [[data-nav-footer]_&]:hidden [[data-nav-sidebar]_[data-nav-footer]_&]:block" data-content><?php echo e($slot); ?></div>
    <?php endif; ?>

    <?php if ($iconDot && ! $icon && $iconTrailing): ?>
        <div class="relative">
            <?php if (is_string($iconTrailing) && $iconTrailing !== ''): ?>
                <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['icon' => $iconTrailing, 'variant' => $iconVariant, 'class' => 'size-4!']); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php if (!function_exists('_57a62cf6cbd1d815dfc05dc37d7a0061')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php'); } ?>
<?php $__componentData = ['icon' => $iconTrailing,'variant' => $iconVariant,'class' => 'size-4!']; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _57a62cf6cbd1d815dfc05dc37d7a0061($__blaze, $__componentData, ['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['icon']), 'variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['variant']), 'class' => 'size-4!'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
            <?php else: ?>
                <?php echo e($iconTrailing); ?>

            <?php endif; ?>

            <div class="absolute top-[-2px] end-[-2px]">
                <div class="size-[6px] rounded-full bg-zinc-500 dark:bg-zinc-400"></div>
            </div>
        </div>
    <?php elseif (is_string($iconTrailing) && $iconTrailing !== ''): ?>
        <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['icon' => $iconTrailing, 'variant' => $iconVariant, 'class' => 'size-4!']); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php if (!function_exists('_57a62cf6cbd1d815dfc05dc37d7a0061')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php'); } ?>
<?php $__componentData = ['icon' => $iconTrailing,'variant' => $iconVariant,'class' => 'size-4!']; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _57a62cf6cbd1d815dfc05dc37d7a0061($__blaze, $__componentData, ['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['icon']), 'variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['variant']), 'class' => 'size-4!'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
    <?php elseif ($iconTrailing): ?>
        <?php echo e($iconTrailing); ?>

    <?php endif; ?>

    <?php if (isset($badge) && $badge !== ''): ?>
        <?php $badgeAttributes = Flux::attributesAfter('badge:', $attributes, ['color' => $badgeColor]); ?>
        <?php if (!function_exists('_685aa0a1f6b677cdca289851c6014607')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/navlist/badge.blade.php'); } ?>
<?php if (isset($__slots685aa0a1f6b677cdca289851c6014607)) { $__slotsStack685aa0a1f6b677cdca289851c6014607[] = $__slots685aa0a1f6b677cdca289851c6014607; } ?>
<?php if (isset($__data685aa0a1f6b677cdca289851c6014607)) { $__dataStack685aa0a1f6b677cdca289851c6014607[] = $__data685aa0a1f6b677cdca289851c6014607; } ?>
<?php $__data685aa0a1f6b677cdca289851c6014607 = ['attributes' => $badgeAttributes]; ?>
<?php $__slots685aa0a1f6b677cdca289851c6014607 = []; ?>
<?php $__blaze->pushData($__data685aa0a1f6b677cdca289851c6014607); ?>
<?php ob_start(); ?><?php echo e($badge); ?><?php $__slots685aa0a1f6b677cdca289851c6014607['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots685aa0a1f6b677cdca289851c6014607); ?>
<?php _685aa0a1f6b677cdca289851c6014607($__blaze, $__data685aa0a1f6b677cdca289851c6014607, $__blaze->mergeAttributes(['attributes' => $__data685aa0a1f6b677cdca289851c6014607['attributes']]), $__slots685aa0a1f6b677cdca289851c6014607, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack685aa0a1f6b677cdca289851c6014607)) { $__slots685aa0a1f6b677cdca289851c6014607 = array_pop($__slotsStack685aa0a1f6b677cdca289851c6014607); } ?>
<?php if (! empty($__dataStack685aa0a1f6b677cdca289851c6014607)) { $__data685aa0a1f6b677cdca289851c6014607 = array_pop($__dataStack685aa0a1f6b677cdca289851c6014607); } ?>
<?php $__blaze->popData(); ?>
    <?php endif; ?>
<?php $__slots066213161da87cc54926f2e443a2823d['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots066213161da87cc54926f2e443a2823d); ?>
<?php _066213161da87cc54926f2e443a2823d($__blaze, $__data066213161da87cc54926f2e443a2823d, $__blaze->mergeAttributes(['attributes' => $__data066213161da87cc54926f2e443a2823d['attributes'], 'data-flux-navlist-item' => true]), $__slots066213161da87cc54926f2e443a2823d, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack066213161da87cc54926f2e443a2823d)) { $__slots066213161da87cc54926f2e443a2823d = array_pop($__slotsStack066213161da87cc54926f2e443a2823d); } ?>
<?php if (! empty($__dataStack066213161da87cc54926f2e443a2823d)) { $__data066213161da87cc54926f2e443a2823d = array_pop($__dataStack066213161da87cc54926f2e443a2823d); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/navlist/item.blade.php ENDPATH**/ ?>