<?php
if (!function_exists('_aecbcbeeea135233e0fa43370ecf673a')):
function _aecbcbeeea135233e0fa43370ecf673a($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;
$errors = $__blaze->errors;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php
$__defaults = [
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'resize' => 'vertical',
    'invalid' => null,
    'rows' => 4,
];
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
$resize ??= $attributes['resize'] ?? $__defaults['resize']; unset($attributes['resize']);
$invalid ??= $attributes['invalid'] ?? $__defaults['invalid']; unset($attributes['invalid']);
$rows ??= $attributes['rows'] ?? $__defaults['rows']; unset($attributes['rows']);
unset($__defaults);
?>

<?php
$classes = Flux::classes()
    ->add('block p-3 w-full')
    ->add('shadow-xs disabled:shadow-none border rounded-lg')
    ->add('bg-white dark:bg-white/10 dark:disabled:bg-white/[7%]')
    ->add($resize ? 'resize-y' : 'resize-none')
    ->add('text-base sm:text-sm text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500')
    ->add('border-zinc-200 border-b-zinc-300/80 dark:border-white/10')
    ->add('data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500')
    ;

$resizeStyle = match ($resize) {
    'none' => 'resize: none',
    'both' => 'resize: both',
    'horizontal' => 'resize: horizontal',
    'vertical' => 'resize: vertical',
};
?>

<?php $__blaze->ensureRequired('D:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php', $__blaze->compiledPath.'/2ec4b91a52d2097625d50fdf8533857e.php'); ?>
<?php if (isset($__slots2ec4b91a52d2097625d50fdf8533857e)) { $__slotsStack2ec4b91a52d2097625d50fdf8533857e[] = $__slots2ec4b91a52d2097625d50fdf8533857e; } ?>
<?php if (isset($__attrs2ec4b91a52d2097625d50fdf8533857e)) { $__attrsStack2ec4b91a52d2097625d50fdf8533857e[] = $__attrs2ec4b91a52d2097625d50fdf8533857e; } ?>
<?php $__attrs2ec4b91a52d2097625d50fdf8533857e = ['attributes' => $attributes]; ?>
<?php $__slots2ec4b91a52d2097625d50fdf8533857e = []; ?>
<?php $__blaze->pushData($__attrs2ec4b91a52d2097625d50fdf8533857e); ?>
<?php ob_start(); ?>
    <textarea
        <?php echo e($attributes->class($classes)); ?>

        rows="<?php echo e($rows); ?>"
        style="<?php echo e($resizeStyle); ?>; <?php echo e($rows === 'auto' ? 'field-sizing: content' : ''); ?>"
        <?php if(isset($name)): ?> name="<?php echo e($name); ?>" <?php endif; ?>
        <?php $__getScope = fn($scope = []) => $scope; ?><?php if (isset($scope)) $__scope = $scope; ?><?php $scope = $__getScope(scope: ['name' => $name ?? null, 'invalid' => $invalid ?? false]); ?>
        <?php if ($scope['invalid'] || ($scope['name'] && $errors->has($scope['name']))): ?>
        aria-invalid="true" data-invalid
        <?php endif; ?>
        <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
        data-flux-control
        data-flux-textarea
    ><?php echo e($slot); ?></textarea>
<?php $__slots2ec4b91a52d2097625d50fdf8533857e['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots2ec4b91a52d2097625d50fdf8533857e); ?>
<?php _2ec4b91a52d2097625d50fdf8533857e($__blaze, $__attrs2ec4b91a52d2097625d50fdf8533857e, $__slots2ec4b91a52d2097625d50fdf8533857e, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack2ec4b91a52d2097625d50fdf8533857e)) { $__slots2ec4b91a52d2097625d50fdf8533857e = array_pop($__slotsStack2ec4b91a52d2097625d50fdf8533857e); } ?>
<?php if (! empty($__attrsStack2ec4b91a52d2097625d50fdf8533857e)) { $__attrs2ec4b91a52d2097625d50fdf8533857e = array_pop($__attrsStack2ec4b91a52d2097625d50fdf8533857e); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH D:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/textarea.blade.php ENDPATH**/ ?>