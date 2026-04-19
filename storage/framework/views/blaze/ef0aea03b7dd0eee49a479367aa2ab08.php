<?php
if (!function_exists('__ef0aea03b7dd0eee49a479367aa2ab08')):
function __ef0aea03b7dd0eee49a479367aa2ab08($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;
$__slots['slot'] ??= new \Illuminate\View\ComponentSlot('');
if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php
extract(Flux::forwardedattributes($attributes, [
    'name',
    'description',
    'label',
]));
?>

<?php
$__defaults = [
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'description' => null,
    'label' => null,
];
$name ??= $attributes['name'] ?? $__defaults['name']; unset($attributes['name']);
$description ??= $attributes['description'] ?? $__defaults['description']; unset($attributes['description']);
$label ??= $attributes['label'] ?? $__defaults['label']; unset($attributes['label']);
unset($__defaults);
?>

<?php if ($label || $description): ?>
    <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/field.blade.php', $__blaze->compiledPath.'/171996f0ab1383f16ab66b099e061473.php'); ?>
<?php if (isset($__slots171996f0ab1383f16ab66b099e061473)) { $__slotsStack171996f0ab1383f16ab66b099e061473[] = $__slots171996f0ab1383f16ab66b099e061473; } ?>
<?php if (isset($__attrs171996f0ab1383f16ab66b099e061473)) { $__attrsStack171996f0ab1383f16ab66b099e061473[] = $__attrs171996f0ab1383f16ab66b099e061473; } ?>
<?php $__attrs171996f0ab1383f16ab66b099e061473 = ['variant' => 'inline']; ?>
<?php $__slots171996f0ab1383f16ab66b099e061473 = []; ?>
<?php $__blaze->pushData($__attrs171996f0ab1383f16ab66b099e061473); ?>
<?php ob_start(); ?>
        <?php if ($label): ?>
            <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/label.blade.php', $__blaze->compiledPath.'/ff185ae2283cecffc22027393371936c.php'); ?>
<?php if (isset($__slotsff185ae2283cecffc22027393371936c)) { $__slotsStackff185ae2283cecffc22027393371936c[] = $__slotsff185ae2283cecffc22027393371936c; } ?>
<?php if (isset($__attrsff185ae2283cecffc22027393371936c)) { $__attrsStackff185ae2283cecffc22027393371936c[] = $__attrsff185ae2283cecffc22027393371936c; } ?>
<?php $__attrsff185ae2283cecffc22027393371936c = []; ?>
<?php $__slotsff185ae2283cecffc22027393371936c = []; ?>
<?php $__blaze->pushData($__attrsff185ae2283cecffc22027393371936c); ?>
<?php ob_start(); ?><?php echo e($label); ?><?php $__slotsff185ae2283cecffc22027393371936c['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsff185ae2283cecffc22027393371936c); ?>
<?php __ff185ae2283cecffc22027393371936c($__blaze, $__attrsff185ae2283cecffc22027393371936c, $__slotsff185ae2283cecffc22027393371936c, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackff185ae2283cecffc22027393371936c)) { $__slotsff185ae2283cecffc22027393371936c = array_pop($__slotsStackff185ae2283cecffc22027393371936c); } ?>
<?php if (! empty($__attrsStackff185ae2283cecffc22027393371936c)) { $__attrsff185ae2283cecffc22027393371936c = array_pop($__attrsStackff185ae2283cecffc22027393371936c); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php if ($description): ?>
            <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/description.blade.php', $__blaze->compiledPath.'/3d2e35307e15b7d2452958c02650eb26.php'); ?>
<?php if (isset($__slots3d2e35307e15b7d2452958c02650eb26)) { $__slotsStack3d2e35307e15b7d2452958c02650eb26[] = $__slots3d2e35307e15b7d2452958c02650eb26; } ?>
<?php if (isset($__attrs3d2e35307e15b7d2452958c02650eb26)) { $__attrsStack3d2e35307e15b7d2452958c02650eb26[] = $__attrs3d2e35307e15b7d2452958c02650eb26; } ?>
<?php $__attrs3d2e35307e15b7d2452958c02650eb26 = []; ?>
<?php $__slots3d2e35307e15b7d2452958c02650eb26 = []; ?>
<?php $__blaze->pushData($__attrs3d2e35307e15b7d2452958c02650eb26); ?>
<?php ob_start(); ?><?php echo e($description); ?><?php $__slots3d2e35307e15b7d2452958c02650eb26['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots3d2e35307e15b7d2452958c02650eb26); ?>
<?php __3d2e35307e15b7d2452958c02650eb26($__blaze, $__attrs3d2e35307e15b7d2452958c02650eb26, $__slots3d2e35307e15b7d2452958c02650eb26, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3d2e35307e15b7d2452958c02650eb26)) { $__slots3d2e35307e15b7d2452958c02650eb26 = array_pop($__slotsStack3d2e35307e15b7d2452958c02650eb26); } ?>
<?php if (! empty($__attrsStack3d2e35307e15b7d2452958c02650eb26)) { $__attrs3d2e35307e15b7d2452958c02650eb26 = array_pop($__attrsStack3d2e35307e15b7d2452958c02650eb26); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?>

        <?php echo e($slot); ?>


        <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/5a47bc60272d6b2c88a3d2ecff0b1cbb.php'); ?>
<?php $__blaze->pushData(['name' => $name]); ?>
<?php __5a47bc60272d6b2c88a3d2ecff0b1cbb($__blaze, ['name' => $name], [], ['name'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
    <?php $__slots171996f0ab1383f16ab66b099e061473['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slots171996f0ab1383f16ab66b099e061473); ?>
<?php __171996f0ab1383f16ab66b099e061473($__blaze, $__attrs171996f0ab1383f16ab66b099e061473, $__slots171996f0ab1383f16ab66b099e061473, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack171996f0ab1383f16ab66b099e061473)) { $__slots171996f0ab1383f16ab66b099e061473 = array_pop($__slotsStack171996f0ab1383f16ab66b099e061473); } ?>
<?php if (! empty($__attrsStack171996f0ab1383f16ab66b099e061473)) { $__attrs171996f0ab1383f16ab66b099e061473 = array_pop($__attrsStack171996f0ab1383f16ab66b099e061473); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?>

<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/with-reversed-inline-field.blade.php ENDPATH**/ ?>