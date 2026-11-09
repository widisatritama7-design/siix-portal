<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('_1564bd2075cf26e52cf8b91fc9f12347')):
function _1564bd2075cf26e52cf8b91fc9f12347($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = new \Livewire\Blaze\Runtime\BlazeAttributeBag($__attributes);
unset($__data, $__attributes);
ob_start();
?>


<?php
extract(Flux::forwardedAttributes($attributes, [
    'type',
    'href',
    'as',
]));
?>

<?php
$__defaults = [
    'type' => 'button',
    'href' => null,
    'as' => null,
];
$type ??= $attributes['type'] ?? $__defaults['type']; unset($attributes['type']);
$href ??= $attributes['href'] ?? $__defaults['href']; unset($attributes['href']);
$as ??= $attributes['as'] ?? $__defaults['as']; unset($attributes['as']);
unset($__defaults);
?>

<?php if ($as === 'div' && ! $href): ?>
    <div <?php echo e($attributes); ?>>
        <?php echo e($slot); ?>

    </div>
<?php elseif ($as === 'a' || $href): ?>
    
    <a href="<?php echo e($href); ?>" <?php echo e($attributes); ?>>
        <?php echo e($slot); ?>

    </a>
<?php else: ?>
    <button <?php echo e($attributes->merge(['type' => $type])); ?>>
        <?php echo e($slot); ?>

    </button>
<?php endif; ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/button-or-link-pure.blade.php ENDPATH**/ ?>