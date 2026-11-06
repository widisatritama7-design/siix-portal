<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__1e458aebbd4033357c172a25595afd62')):
function __1e458aebbd4033357c172a25595afd62($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = new \Livewire\Blaze\Runtime\BlazeAttributeBag($__attributes);
unset($__data, $__attributes);
ob_start();
?>


<?php $iconVariant ??= $attributes->pluck('icon:variant'); ?>

<?php
$__defaults = [
    'separator' => null,
    'iconVariant' => 'mini',
    'icon' => null,
    'href' => null,
];
$separator ??= $attributes['separator'] ?? $__defaults['separator']; unset($attributes['separator']);
$iconVariant ??= $attributes['icon-variant'] ?? $attributes['iconVariant'] ?? $__defaults['iconVariant']; unset($attributes['iconVariant'], $attributes['icon-variant']);
$icon ??= $attributes['icon'] ?? $__defaults['icon']; unset($attributes['icon']);
$href ??= $attributes['href'] ?? $__defaults['href']; unset($attributes['href']);
unset($__defaults);
?>

<?php
$classes = Flux::classes()
    ->add('flex items-center')
    ->add('text-sm font-medium')
    ->add('group/breadcrumb')
    ;

$linkClasses = Flux::classes()
    ->add('text-zinc-800 dark:text-white')
    ->add('hover:underline decoration-zinc-800/20 underline-offset-4');

$staticTextClasses = Flux::classes()
    ->add('text-gray-500 dark:text-white/80')
    ;

$separatorClasses = Flux::classes()
    ->add('mx-1 text-zinc-300 dark:text-white/80')
    ->add('group-last/breadcrumb:hidden')
    ;

$iconClasses = Flux::classes()
    // When using the outline icon variant, we need to size it down to match the default icon sizes...
    ->add($iconVariant === 'outline' ? 'size-5' : '')
    ;

[ $styleAttributes, $attributes ] = Flux::splitAttributes($attributes);
?>

<div <?php echo e($styleAttributes->class($classes)); ?> data-flux-breadcrumbs-item>
    <?php if ($href): ?>
        <a <?php echo e($attributes->class($linkClasses)); ?> href="<?php echo e($href); ?>">
            <?php if ($icon): ?>
                <?php if (!function_exists('__adf4f9f4d4b9749b7256198b8759ef9f')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php'); } ?>
<?php $__componentData = ['icon' => $icon,'variant' => $iconVariant,'class' => e($iconClasses)]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php __adf4f9f4d4b9749b7256198b8759ef9f($__blaze, $__componentData, ['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['icon']), 'variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['variant']), 'class' => $__componentData['class']], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
            <?php else: ?>
                <?php echo e($slot); ?>

            <?php endif; ?>
        </a>
    <?php else: ?>
        <div <?php echo e($attributes->class($staticTextClasses)); ?>>
            <?php if ($icon): ?>
                <?php if (!function_exists('__adf4f9f4d4b9749b7256198b8759ef9f')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php'); } ?>
<?php $__componentData = ['icon' => $icon,'variant' => $iconVariant,'class' => e($iconClasses)]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php __adf4f9f4d4b9749b7256198b8759ef9f($__blaze, $__componentData, ['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['icon']), 'variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['variant']), 'class' => $__componentData['class']], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
            <?php else: ?>
                <?php echo e($slot); ?>

            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($separator == null): ?>
        <?php if (!function_exists('__adf4f9f4d4b9749b7256198b8759ef9f')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php'); } ?>
<?php $__componentData = ['icon' => 'chevron-right','variant' => 'mini','class' => e($separatorClasses->add('rtl:hidden'))]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php __adf4f9f4d4b9749b7256198b8759ef9f($__blaze, $__componentData, ['icon' => 'chevron-right', 'variant' => 'mini', 'class' => $__componentData['class']], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
        <?php if (!function_exists('__adf4f9f4d4b9749b7256198b8759ef9f')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php'); } ?>
<?php $__componentData = ['icon' => 'chevron-left','variant' => 'mini','class' => e($separatorClasses->add('hidden rtl:inline'))]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php __adf4f9f4d4b9749b7256198b8759ef9f($__blaze, $__componentData, ['icon' => 'chevron-left', 'variant' => 'mini', 'class' => $__componentData['class']], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
    <?php elseif (! is_string($separator)): ?>
        <?php echo e($separator); ?>

    <?php elseif ($separator === 'slash'): ?>
        <?php if (!function_exists('__adf4f9f4d4b9749b7256198b8759ef9f')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php'); } ?>
<?php $__componentData = ['icon' => 'slash','variant' => 'mini','class' => e($separatorClasses->add('rtl:-scale-x-100'))]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php __adf4f9f4d4b9749b7256198b8759ef9f($__blaze, $__componentData, ['icon' => 'slash', 'variant' => 'mini', 'class' => $__componentData['class']], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
    <?php else: ?>
        <?php if (!function_exists('__adf4f9f4d4b9749b7256198b8759ef9f')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php'); } ?>
<?php $__componentData = ['icon' => $separator,'variant' => 'mini','class' => e($separatorClasses)]; ?>
<?php $__blaze->pushData($__componentData); ?>
<?php __adf4f9f4d4b9749b7256198b8759ef9f($__blaze, $__componentData, ['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($__componentData['icon']), 'variant' => 'mini', 'class' => $__componentData['class']], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
    <?php endif; ?>
</div>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php ENDPATH**/ ?>