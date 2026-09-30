<?php
if (!function_exists('_45fa38eb209539e920cc7a41bee21c5b')):
function _45fa38eb209539e920cc7a41bee21c5b($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;
$errors = $__blaze->errors;
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php
$__defaults = [
    'icon' => 'exclamation-triangle',
    'bag' => 'default',
    'message' => null,
    'deep' => true,
    'nested' => true,
    'name' => null,
];
$icon ??= $attributes['icon'] ?? $__defaults['icon']; unset($attributes['icon']);
$bag ??= $attributes['bag'] ?? $__defaults['bag']; unset($attributes['bag']);
$message ??= $attributes['message'] ?? $__defaults['message']; unset($attributes['message']);
$deep ??= $attributes['deep'] ?? $__defaults['deep']; unset($attributes['deep']);
$nested ??= $attributes['nested'] ?? $__defaults['nested']; unset($attributes['nested']);
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
unset($__defaults);
?>

<?php
$errorBag = $errors->getBag($bag);
$message ??= $name ? $errorBag->first($name) : null;

// Backwards compatibility...
if ($nested === false) {
    $deep = false;
}

if ($name && (is_null($message) || $message === '') && filter_var($deep, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== false) {
    $message = $errorBag->first($name . '.*');
}

$classes = Flux::classes('mt-3 text-sm font-medium text-red-500 dark:text-red-400')
    ->add($message ? '' : 'hidden');
?>

<div role="alert" aria-live="polite" aria-atomic="true" <?php echo e($attributes->class($classes)); ?> data-flux-error>
    <?php if ($message) : ?>
        <?php if ($icon) : ?>
            <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['name' => $icon, 'variant' => 'mini', 'class' => 'inline']); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/ebfb27feae87a3d873cb5ef75a09aacc.php'); ?>
<?php $__blaze->pushData(['name' => $icon,'variant' => 'mini','class' => 'inline']); ?>
<?php _ebfb27feae87a3d873cb5ef75a09aacc($__blaze, ['name' => $icon,'variant' => 'mini','class' => 'inline'], [], ['name'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
        <?php endif; ?>

        <?php echo e($message); ?>

    <?php endif; ?>
</div>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/error.blade.php ENDPATH**/ ?>