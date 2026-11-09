<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__326315e7ff18e45c18b2b0510d2da720')):
function __326315e7ff18e45c18b2b0510d2da720($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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
    ->add($resize ? match ($resize) {
        'none' => 'resize-none',
        'both' => 'resize',
        'horizontal' => 'resize-x',
        'vertical' => 'resize-y',
        default => 'resize-y',
    } : 'resize-none')
    ->add($rows === 'auto' ? 'field-sizing-content' : '')
    ->add('text-base sm:text-sm text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500')
    ->add('border-zinc-200 border-b-zinc-300/80 dark:border-white/10')
    ->add('data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500')
    ;
?>

<?php if (!function_exists('__cff1c71bac828e48284939dd973e7838')) { require $__blaze->compile('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/with-field.blade.php'); } ?>
<?php if (isset($__slotscff1c71bac828e48284939dd973e7838)) { $__slotsStackcff1c71bac828e48284939dd973e7838[] = $__slotscff1c71bac828e48284939dd973e7838; } ?>
<?php if (isset($__datacff1c71bac828e48284939dd973e7838)) { $__dataStackcff1c71bac828e48284939dd973e7838[] = $__datacff1c71bac828e48284939dd973e7838; } ?>
<?php $__datacff1c71bac828e48284939dd973e7838 = ['attributes' => $attributes]; ?>
<?php $__slotscff1c71bac828e48284939dd973e7838 = []; ?>
<?php $__blaze->pushData($__datacff1c71bac828e48284939dd973e7838); ?>
<?php ob_start(); ?>
    <textarea
        <?php echo e($attributes->class($classes)); ?>

        rows="<?php echo e($rows); ?>"
        <?php if(isset($name)): ?> name="<?php echo e($name); ?>" <?php endif; ?>
        [STARTCOMPILEDUNBLAZE:3RXPrNpdD6]<?php \Livewire\Blaze\Unblaze::storeScope("3RXPrNpdD6", scope: ['name' => $name ?? null, 'invalid' => $invalid ?? false]) ?><?php \Livewire\Blaze\Unblaze::storeReplacement("3RXPrNpdD6", "CiAgICAgICAgPD9waHAgaWYgKCRzY29wZVsnaW52YWxpZCddIHx8ICgkc2NvcGVbJ25hbWUnXSAmJiAkZXJyb3JzLT5oYXMoJHNjb3BlWyduYW1lJ10pKSk6ID8+CiAgICAgICAgYXJpYS1pbnZhbGlkPSJ0cnVlIiBkYXRhLWludmFsaWQKICAgICAgICA8P3BocCBlbmRpZjsgPz4KICAgICAgICA=") ?>[ENDCOMPILEDUNBLAZE:3RXPrNpdD6]
        data-flux-control
        data-flux-textarea
    ><?php echo e($slot); ?></textarea>
<?php $__slotscff1c71bac828e48284939dd973e7838['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotscff1c71bac828e48284939dd973e7838); ?>
<?php __cff1c71bac828e48284939dd973e7838($__blaze, $__datacff1c71bac828e48284939dd973e7838, $__blaze->mergeAttributes(['attributes' => $__datacff1c71bac828e48284939dd973e7838['attributes']]), $__slotscff1c71bac828e48284939dd973e7838, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackcff1c71bac828e48284939dd973e7838)) { $__slotscff1c71bac828e48284939dd973e7838 = array_pop($__slotsStackcff1c71bac828e48284939dd973e7838); } ?>
<?php if (! empty($__dataStackcff1c71bac828e48284939dd973e7838)) { $__datacff1c71bac828e48284939dd973e7838 = array_pop($__dataStackcff1c71bac828e48284939dd973e7838); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/textarea.blade.php ENDPATH**/ ?>