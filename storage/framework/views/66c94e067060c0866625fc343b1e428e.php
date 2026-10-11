<?php
if (!function_exists('_66c94e067060c0866625fc343b1e428e')):
function _66c94e067060c0866625fc343b1e428e($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/checkbox/index.blade.php', $__blaze->compiledPath.'/e56743141ed36359c4ca0004f7bc0542.php'); ?>
<?php $__blaze->pushData(['all' => true,'attributes' => $attributes]); ?>
<?php _e56743141ed36359c4ca0004f7bc0542($__blaze, ['all' => true,'attributes' => $attributes], [], ['all', 'attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\stubs\resources\views\flux\checkbox\all.blade.php ENDPATH**/ ?>