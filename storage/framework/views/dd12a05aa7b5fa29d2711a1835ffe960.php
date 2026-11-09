<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('_05104fca0b474dd4d6f540cd22200fe5')):
function _05104fca0b474dd4d6f540cd22200fe5($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
$__env = $__blaze->env;
$errors = $__blaze->errors;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = new \Livewire\Blaze\Runtime\BlazeAttributeBag($__attributes);
unset($__data, $__attributes);
ob_start();
?>


<?php $iconTrailing ??= $attributes->pluck('icon:trailing'); ?>
<?php $iconLeading ??= $attributes->pluck('icon:leading'); ?>
<?php $iconVariant ??= $attributes->pluck('icon:variant'); ?>
<?php $maskDynamic ??= $attributes->pluck('mask:dynamic'); ?>

<?php
$__defaults = [
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'iconVariant' => 'mini',
    'variant' => 'outline',
    'iconTrailing' => null,
    'iconLeading' => null,
    'maskDynamic' => null,
    'expandable' => null,
    'clearable' => null,
    'copyable' => null,
    'viewable' => null,
    'invalid' => null,
    'loading' => null,
    'type' => 'text',
    'mask' => null,
    'size' => null,
    'icon' => null,
    'kbd' => null,
    'as' => null,
];
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
$iconVariant ??= $attributes['icon-variant'] ?? $attributes['iconVariant'] ?? $__defaults['iconVariant']; unset($attributes['iconVariant'], $attributes['icon-variant']);
$variant ??= $attributes['variant'] ?? $__defaults['variant']; unset($attributes['variant']);
$iconTrailing ??= $attributes['icon-trailing'] ?? $attributes['iconTrailing'] ?? $__defaults['iconTrailing']; unset($attributes['iconTrailing'], $attributes['icon-trailing']);
$iconLeading ??= $attributes['icon-leading'] ?? $attributes['iconLeading'] ?? $__defaults['iconLeading']; unset($attributes['iconLeading'], $attributes['icon-leading']);
$maskDynamic ??= $attributes['mask-dynamic'] ?? $attributes['maskDynamic'] ?? $__defaults['maskDynamic']; unset($attributes['maskDynamic'], $attributes['mask-dynamic']);
$expandable ??= $attributes['expandable'] ?? $__defaults['expandable']; unset($attributes['expandable']);
$clearable ??= $attributes['clearable'] ?? $__defaults['clearable']; unset($attributes['clearable']);
$copyable ??= $attributes['copyable'] ?? $__defaults['copyable']; unset($attributes['copyable']);
$viewable ??= $attributes['viewable'] ?? $__defaults['viewable']; unset($attributes['viewable']);
$invalid ??= $attributes['invalid'] ?? $__defaults['invalid']; unset($attributes['invalid']);
$loading ??= $attributes['loading'] ?? $__defaults['loading']; unset($attributes['loading']);
$type ??= $attributes['type'] ?? $__defaults['type']; unset($attributes['type']);
$mask ??= $attributes['mask'] ?? $__defaults['mask']; unset($attributes['mask']);
$size ??= $attributes['size'] ?? $__defaults['size']; unset($attributes['size']);
$icon ??= $attributes['icon'] ?? $__defaults['icon']; unset($attributes['icon']);
$kbd ??= $attributes['kbd'] ?? $__defaults['kbd']; unset($attributes['kbd']);
$as ??= $attributes['as'] ?? $__defaults['as']; unset($attributes['as']);
unset($__defaults);
?>

<?php

$inputAttributes = Flux::attributesAfter('input:', $attributes, []);

// There are a few loading scenarios that this covers:
// If `:loading="false"` then never show loading.
// If `:loading="true"` then always show loading.
// If `:loading="foo"` then show loading when `foo` request is happening.
// If `wire:model` then never show loading.
// If `wire:model.live` then show loading when the `wire:model` value request is happening.
$wireModel = $attributes->wire('model');
$wireTarget = null;

if ($loading !== false) {
    if ($loading === true) {
        $loading = true;
    } elseif ($wireModel?->directive) {
        $loading = $wireModel->hasModifier('live');
        $wireTarget = $loading ? $wireModel->value() : null;
    } else {
        $wireTarget = $loading;
        $loading = (bool) $loading;
    }
}

$iconLeading ??= $icon;

$hasLeadingIcon = (bool) ($iconLeading);
$countOfTrailingIcons = collect([
    (bool) $iconTrailing,
    (bool) $kbd,
    (bool) $clearable,
    (bool) $copyable,
    (bool) $viewable,
    (bool) $expandable,
])->filter()->count();

$iconClasses = Flux::classes()
    // When using the outline icon variant, we need to size it down to match the default icon sizes...
    ->add($iconVariant === 'outline' ? 'size-5' : '')
    ;

$inputLoadingClasses = Flux::classes()
    // When loading, we need to add some extra padding to the input to account for the loading icon...
    ->add(match ($countOfTrailingIcons) {
        0 => 'pe-10',
        1 => 'pe-16',
        2 => 'pe-23',
        3 => 'pe-30',
        4 => 'pe-37',
        5 => 'pe-44',
        6 => 'pe-51',
    })
    ;

$classes = Flux::classes()
    ->add('w-full border block disabled:shadow-none dark:shadow-none')
    ->add('appearance-none') // Without this, input[type="date"] on mobile doesn't respect w-full...
    ->add(match ($size) {
        default => 'text-base sm:text-sm rounded-lg py-2 h-10 leading-[1.375rem]', // This makes the height of the input 40px (same as buttons and such...)
        'sm' => 'text-sm rounded-md py-1.5 h-8 leading-[1.125rem]',
        'xs' => 'text-xs rounded-md py-1.5 h-6 leading-[1.125rem]',
    })
    ->add(match ($hasLeadingIcon) {
        true => 'ps-10',
        false => 'ps-3',
    })
    ->add(match ($countOfTrailingIcons) {
        // Make sure there's enough padding on the right side of the input to account for all the icons...
        0 => 'pe-3',
        1 => 'pe-10',
        2 => 'pe-16',
        3 => 'pe-23',
        4 => 'pe-30',
        5 => 'pe-37',
        6 => 'pe-44',
    })
    ->add(match ($variant) { // Background...
        'outline' => 'bg-white dark:bg-white/10 dark:disabled:bg-white/[7%]',
        'filled'  => 'bg-zinc-800/5 dark:bg-white/10 dark:disabled:bg-white/[7%]',
    })
    ->add(match ($variant) { // Text color
        'outline' => 'text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500',
        'filled'  => 'text-zinc-700 placeholder-zinc-500 disabled:placeholder-zinc-400 dark:text-zinc-200 dark:placeholder-white/60 dark:disabled:placeholder-white/40',
    })
    ->add(match ($variant) { // Border...
        'outline' => 'shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5',
        'filled'  => 'border-0',
    })
    ->add(match ($variant) { // Invalid...
        'outline' => 'data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500 disabled:data-invalid:border-red-500 dark:disabled:data-invalid:border-red-500',
        'filled' => 'data-invalid:border-red-500'
    })
    ->add($attributes->pluck('class:input'))
    ;
?>

<?php if ($type === 'file'): ?>
    <?php if (!function_exists('_cff1c71bac828e48284939dd973e7838')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php'); } ?>
<?php if (isset($__slotscff1c71bac828e48284939dd973e7838)) { $__slotsStackcff1c71bac828e48284939dd973e7838[] = $__slotscff1c71bac828e48284939dd973e7838; } ?>
<?php if (isset($__datacff1c71bac828e48284939dd973e7838)) { $__dataStackcff1c71bac828e48284939dd973e7838[] = $__datacff1c71bac828e48284939dd973e7838; } ?>
<?php $__datacff1c71bac828e48284939dd973e7838 = ['attributes' => $attributes,'name' => $name]; ?>
<?php $__slotscff1c71bac828e48284939dd973e7838 = []; ?>
<?php $__blaze->pushData($__datacff1c71bac828e48284939dd973e7838); ?>
<?php ob_start(); ?>
        <?php if (!function_exists('_1d1621b7ddadbcabfe9c7181b37c1cee')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/input/file.blade.php'); } ?>
<?php $__componentData = ['attributes' => $attributes,'name' => $name,'size' => $size]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _1d1621b7ddadbcabfe9c7181b37c1cee($__blaze, $__componentData, $__blaze->mergeAttributes(['attributes' => $__componentData['attributes'], 'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['name']), 'size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['size'])]), [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
    <?php $__slotscff1c71bac828e48284939dd973e7838['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotscff1c71bac828e48284939dd973e7838); ?>
<?php _cff1c71bac828e48284939dd973e7838($__blaze, $__datacff1c71bac828e48284939dd973e7838, $__blaze->mergeAttributes(['attributes' => $__datacff1c71bac828e48284939dd973e7838['attributes'], 'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__datacff1c71bac828e48284939dd973e7838['name'])]), $__slotscff1c71bac828e48284939dd973e7838, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackcff1c71bac828e48284939dd973e7838)) { $__slotscff1c71bac828e48284939dd973e7838 = array_pop($__slotsStackcff1c71bac828e48284939dd973e7838); } ?>
<?php if (! empty($__dataStackcff1c71bac828e48284939dd973e7838)) { $__datacff1c71bac828e48284939dd973e7838 = array_pop($__dataStackcff1c71bac828e48284939dd973e7838); } ?>
<?php $__blaze->popData(); ?>
<?php elseif ($as !== 'button'): ?>
    <?php if (!function_exists('_cff1c71bac828e48284939dd973e7838')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php'); } ?>
<?php if (isset($__slotscff1c71bac828e48284939dd973e7838)) { $__slotsStackcff1c71bac828e48284939dd973e7838[] = $__slotscff1c71bac828e48284939dd973e7838; } ?>
<?php if (isset($__datacff1c71bac828e48284939dd973e7838)) { $__dataStackcff1c71bac828e48284939dd973e7838[] = $__datacff1c71bac828e48284939dd973e7838; } ?>
<?php $__datacff1c71bac828e48284939dd973e7838 = ['attributes' => $attributes,'name' => $name]; ?>
<?php $__slotscff1c71bac828e48284939dd973e7838 = []; ?>
<?php $__blaze->pushData($__datacff1c71bac828e48284939dd973e7838); ?>
<?php ob_start(); ?>
        <div <?php echo e($attributes->only('class')->class('w-full relative block group/input')); ?> data-flux-input>
            <?php if (is_string($iconLeading) && $iconLeading !== ''): ?>
                <div class="pointer-events-none absolute top-0 bottom-0 border-s border-transparent flex items-center justify-center text-xs text-zinc-400/75 dark:text-white/60 ps-3 start-0">
                    <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['icon' => $iconLeading, 'variant' => $iconVariant, 'class' => $iconClasses]); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php if (!function_exists('_57a62cf6cbd1d815dfc05dc37d7a0061')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php'); } ?>
<?php $__componentData = ['icon' => $iconLeading,'variant' => $iconVariant,'class' => $iconClasses]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _57a62cf6cbd1d815dfc05dc37d7a0061($__blaze, $__componentData, ['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['icon']), 'variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['variant']), 'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['class'])], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
                </div>
            <?php elseif ($iconLeading): ?>
                <div <?php echo e($iconLeading->attributes->class('absolute top-0 bottom-0 border-s border-transparent flex items-center justify-center text-xs text-zinc-400/75 dark:text-white/60 ps-3 start-0')); ?>>
                    <?php echo e($iconLeading); ?>

                </div>
            <?php endif; ?>

            <input
                type="<?php echo e($type); ?>"
                
                <?php echo e($attributes->except('class')->class($type === 'file' ? '' : $classes)->merge($inputAttributes->getAttributes())); ?>

                <?php if (isset($name)): ?> name="<?php echo e($name); ?>" <?php endif; ?>
                <?php if ($maskDynamic): ?> x-mask:dynamic="<?php echo e($maskDynamic); ?>" <?php elseif($mask): ?> x-mask="<?php echo e($mask); ?>" <?php endif; ?>
                <?php if (is_numeric($size)): ?> size="<?php echo e($size); ?>" <?php endif; ?>
                <?php $__getScope = fn($scope = []) => $scope; ?><?php if (isset($scope)) $__scope = $scope; ?><?php $scope = $__getScope(scope: ['name' => $name ?? null, 'invalid' => $invalid ?? false]); ?>
                <?php if ($scope['invalid'] || ($scope['name'] && $errors->has($scope['name']))): ?>
                aria-invalid="true" data-invalid
                <?php endif; ?>
                <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
                data-flux-control
                data-flux-group-target
                <?php if($loading): ?> wire:loading.class="<?php echo e($inputLoadingClasses); ?>" <?php endif; ?>
                <?php if($loading && $wireTarget): ?> wire:target="<?php echo e($wireTarget); ?>" <?php endif; ?>
            >

            <?php if ($loading || $countOfTrailingIcons > 0): ?>
                <div class="absolute top-0 bottom-0 flex items-center gap-x-1.5 pe-2 border-e border-transparent end-0 text-xs text-zinc-400">
                    
                    <?php if ($loading): ?>
                        <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['name' => 'loading', 'variant' => $iconVariant, 'class' => $iconClasses, 'wire:loading' => true, 'wire:target' => $wireTarget]); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php if (!function_exists('_57a62cf6cbd1d815dfc05dc37d7a0061')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php'); } ?>
<?php $__componentData = ['name' => 'loading','variant' => $iconVariant,'class' => $iconClasses,'wire:loading' => true,'wire:target' => $wireTarget]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _57a62cf6cbd1d815dfc05dc37d7a0061($__blaze, $__componentData, ['name' => 'loading', 'variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['variant']), 'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['class']), 'wire:loading' => true, 'wire:target' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['wire:target'])], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
                    <?php endif; ?>

                    <?php if ($clearable): ?>
                        <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::input.clearable", ['inset' => 'left right', 'size' => $size, 'iconVariant' => $iconVariant]); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php if (!function_exists('_da31ed3f19826b59e747e581609b59c5')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/input/clearable.blade.php'); } ?>
<?php $__componentData = ['inset' => 'left right','size' => $size,'iconVariant' => $iconVariant]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _da31ed3f19826b59e747e581609b59c5($__blaze, $__componentData, ['inset' => 'left right', 'size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['size']), 'iconVariant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['iconVariant'])], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
                    <?php endif; ?>

                    <?php if ($kbd): ?>
                        <span class="pointer-events-none last:pe-2"><?php echo e($kbd); ?></span>
                    <?php endif; ?>

                    <?php if ($expandable): ?>
                        <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::input.expandable", ['inset' => 'left right', 'size' => $size, 'iconVariant' => $iconVariant]); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php if (!function_exists('_079f349c565f55bc07a05d5932b7342b')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/input/expandable.blade.php'); } ?>
<?php $__componentData = ['inset' => 'left right','size' => $size,'iconVariant' => $iconVariant]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _079f349c565f55bc07a05d5932b7342b($__blaze, $__componentData, ['inset' => 'left right', 'size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['size']), 'iconVariant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['iconVariant'])], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
                    <?php endif; ?>

                    <?php if ($copyable): ?>
                        <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::input.copyable", ['inset' => 'left right', 'size' => $size, 'iconVariant' => $iconVariant]); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php if (!function_exists('_79625be939362bf4b4fd0e59510c8eb2')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/input/copyable.blade.php'); } ?>
<?php $__componentData = ['inset' => 'left right','size' => $size,'iconVariant' => $iconVariant]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _79625be939362bf4b4fd0e59510c8eb2($__blaze, $__componentData, ['inset' => 'left right', 'size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['size']), 'iconVariant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['iconVariant'])], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
                    <?php endif; ?>

                    <?php if ($viewable): ?>
                        <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::input.viewable", ['inset' => 'left right', 'size' => $size, 'iconVariant' => $iconVariant]); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php if (!function_exists('_cb33394864c61349537b2784022d8c15')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/input/viewable.blade.php'); } ?>
<?php $__componentData = ['inset' => 'left right','size' => $size,'iconVariant' => $iconVariant]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _cb33394864c61349537b2784022d8c15($__blaze, $__componentData, ['inset' => 'left right', 'size' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['size']), 'iconVariant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['iconVariant'])], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
                    <?php endif; ?>

                    <?php if (is_string($iconTrailing) && $iconTrailing !== ''): ?>
                        <?php
                            $trailingIconClasses = clone $iconClasses;
                            $trailingIconClasses->add('text-zinc-400/75 dark:text-white/60 pointer-events-none');
                        ?>
                        <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['icon' => $iconTrailing, 'variant' => $iconVariant, 'class' => $trailingIconClasses]); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php if (!function_exists('_57a62cf6cbd1d815dfc05dc37d7a0061')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php'); } ?>
<?php $__componentData = ['icon' => $iconTrailing,'variant' => $iconVariant,'class' => $trailingIconClasses]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _57a62cf6cbd1d815dfc05dc37d7a0061($__blaze, $__componentData, ['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['icon']), 'variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['variant']), 'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['class'])], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
                    <?php elseif ($iconTrailing): ?>
                        <?php echo e($iconTrailing); ?>

                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php $__slotscff1c71bac828e48284939dd973e7838['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotscff1c71bac828e48284939dd973e7838); ?>
<?php _cff1c71bac828e48284939dd973e7838($__blaze, $__datacff1c71bac828e48284939dd973e7838, $__blaze->mergeAttributes(['attributes' => $__datacff1c71bac828e48284939dd973e7838['attributes'], 'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__datacff1c71bac828e48284939dd973e7838['name'])]), $__slotscff1c71bac828e48284939dd973e7838, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackcff1c71bac828e48284939dd973e7838)) { $__slotscff1c71bac828e48284939dd973e7838 = array_pop($__slotsStackcff1c71bac828e48284939dd973e7838); } ?>
<?php if (! empty($__dataStackcff1c71bac828e48284939dd973e7838)) { $__datacff1c71bac828e48284939dd973e7838 = array_pop($__dataStackcff1c71bac828e48284939dd973e7838); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <button <?php echo e($attributes->merge(['type' => 'button'])->class([$classes, 'w-full relative flex'])); ?>>
        <?php if (is_string($iconLeading) && $iconLeading !== ''): ?>
            <div class="absolute top-0 bottom-0 flex items-center justify-center text-xs text-zinc-400/75 ps-3 start-0">
                <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['icon' => $iconLeading, 'variant' => $iconVariant, 'class' => $iconClasses]); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php if (!function_exists('_57a62cf6cbd1d815dfc05dc37d7a0061')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php'); } ?>
<?php $__componentData = ['icon' => $iconLeading,'variant' => $iconVariant,'class' => $iconClasses]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _57a62cf6cbd1d815dfc05dc37d7a0061($__blaze, $__componentData, ['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['icon']), 'variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['variant']), 'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['class'])], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
            </div>
        <?php elseif ($iconLeading): ?>
            <div <?php echo e($iconLeading->attributes->class('absolute top-0 bottom-0 flex items-center justify-center text-xs text-zinc-400/75 ps-3 start-0')); ?>>
                <?php echo e($iconLeading); ?>

            </div>
        <?php endif; ?>

        <?php if ($attributes->has('placeholder')): ?>
            <div class="block self-center text-start flex-1 font-medium text-zinc-400 dark:text-white/40">
                <?php echo e($attributes->get('placeholder')); ?>

            </div>
        <?php else: ?>
            <div class="text-start self-center flex-1 font-medium text-zinc-800 dark:text-white">
                <?php echo e($slot); ?>

            </div>
        <?php endif; ?>

        <?php if ($kbd): ?>
            <div class="absolute top-0 bottom-0 flex items-center justify-center text-xs text-zinc-400/75 pe-4 end-0">
                <?php echo e($kbd); ?>

            </div>
        <?php endif; ?>

        <?php if (is_string($iconTrailing) && $iconTrailing !== ''): ?>
            <div class="absolute top-0 bottom-0 flex items-center justify-center text-xs text-zinc-400/75 pe-3 end-0">
                <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['icon' => $iconTrailing, 'variant' => $iconVariant, 'class' => $iconClasses]); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php if (!function_exists('_57a62cf6cbd1d815dfc05dc37d7a0061')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php'); } ?>
<?php $__componentData = ['icon' => $iconTrailing,'variant' => $iconVariant,'class' => $iconClasses]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php _57a62cf6cbd1d815dfc05dc37d7a0061($__blaze, $__componentData, ['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['icon']), 'variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['variant']), 'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['class'])], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
            </div>
        <?php elseif  ($iconTrailing): ?>
            <div <?php echo e($iconTrailing->attributes->class('absolute top-0 bottom-0 flex items-center justify-center text-xs text-zinc-400/75 pe-2 end-0')); ?>>
                <?php echo e($iconTrailing); ?>

            </div>
        <?php endif; ?>
    </button>
<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/input/index.blade.php ENDPATH**/ ?>