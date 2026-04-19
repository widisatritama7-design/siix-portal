<?php
if (!function_exists('_48cb30b4cf2fbc9e2b43af087903cdc6')):
function _48cb30b4cf2fbc9e2b43af087903cdc6($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/checkbox/index.blade.php', $__blaze->compiledPath.'/9c3f2487618f37b50f8bc73cf55c0e07.php'); ?>
<?php $__blaze->pushData(['all' => true,'attributes' => $attributes]); ?>
<?php _9c3f2487618f37b50f8bc73cf55c0e07($__blaze, ['all' => true,'attributes' => $attributes], [], ['all', 'attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH D:\laragon\www\siix-portal-new\vendor\livewire\flux\stubs\resources\views\flux\checkbox\all.blade.php ENDPATH**/ ?>