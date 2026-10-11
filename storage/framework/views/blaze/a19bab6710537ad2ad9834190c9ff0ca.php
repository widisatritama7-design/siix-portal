<?php
if (!function_exists('__a19bab6710537ad2ad9834190c9ff0ca')):
function __a19bab6710537ad2ad9834190c9ff0ca($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<div class="-mx-[.3125rem] my-[.3125rem] h-px" <?php echo e($attributes); ?> data-flux-menu-separator>
    <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/separator.blade.php', $__blaze->compiledPath.'/b06424d2074ad812a2eb52bb425176dc.php'); ?>
<?php $__blaze->pushData(['class' => 'dark:bg-zinc-600!']); ?>
<?php __b06424d2074ad812a2eb52bb425176dc($__blaze, ['class' => 'dark:bg-zinc-600!'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
</div>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/menu/separator.blade.php ENDPATH**/ ?>