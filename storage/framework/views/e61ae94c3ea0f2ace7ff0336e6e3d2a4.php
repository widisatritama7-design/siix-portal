<?php
if (!function_exists('_e61ae94c3ea0f2ace7ff0336e6e3d2a4')):
function _e61ae94c3ea0f2ace7ff0336e6e3d2a4($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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

<?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php', $__blaze->compiledPath.'/6ba02b760522d3c69435c68da2316bf2.php'); ?>
<?php if (isset($__slots6ba02b760522d3c69435c68da2316bf2)) { $__slotsStack6ba02b760522d3c69435c68da2316bf2[] = $__slots6ba02b760522d3c69435c68da2316bf2; } ?>
<?php if (isset($__attrs6ba02b760522d3c69435c68da2316bf2)) { $__attrsStack6ba02b760522d3c69435c68da2316bf2[] = $__attrs6ba02b760522d3c69435c68da2316bf2; } ?>
<?php $__attrs6ba02b760522d3c69435c68da2316bf2 = ['attributes' => $attributes]; ?>
<?php $__slots6ba02b760522d3c69435c68da2316bf2 = []; ?>
<?php $__blaze->pushData($__attrs6ba02b760522d3c69435c68da2316bf2); ?>
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
<?php $__slots6ba02b760522d3c69435c68da2316bf2['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots6ba02b760522d3c69435c68da2316bf2); ?>
<?php _6ba02b760522d3c69435c68da2316bf2($__blaze, $__attrs6ba02b760522d3c69435c68da2316bf2, $__slots6ba02b760522d3c69435c68da2316bf2, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack6ba02b760522d3c69435c68da2316bf2)) { $__slots6ba02b760522d3c69435c68da2316bf2 = array_pop($__slotsStack6ba02b760522d3c69435c68da2316bf2); } ?>
<?php if (! empty($__attrsStack6ba02b760522d3c69435c68da2316bf2)) { $__attrs6ba02b760522d3c69435c68da2316bf2 = array_pop($__attrsStack6ba02b760522d3c69435c68da2316bf2); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/textarea.blade.php ENDPATH**/ ?>