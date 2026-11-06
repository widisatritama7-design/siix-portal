<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__fa4a3f0e56f7226e816564f8b7e0a0bf')):
function __fa4a3f0e56f7226e816564f8b7e0a0bf($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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

<?php if (!function_exists('__cc94b751a6dbee3c6cddb4c1c630c48a')) { require $__blaze->compile('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-field.blade.php'); } ?>
<?php if (isset($__slotscc94b751a6dbee3c6cddb4c1c630c48a)) { $__slotsStackcc94b751a6dbee3c6cddb4c1c630c48a[] = $__slotscc94b751a6dbee3c6cddb4c1c630c48a; } ?>
<?php if (isset($__datacc94b751a6dbee3c6cddb4c1c630c48a)) { $__dataStackcc94b751a6dbee3c6cddb4c1c630c48a[] = $__datacc94b751a6dbee3c6cddb4c1c630c48a; } ?>
<?php $__datacc94b751a6dbee3c6cddb4c1c630c48a = ['attributes' => $attributes]; ?>
<?php $__slotscc94b751a6dbee3c6cddb4c1c630c48a = []; ?>
<?php $__blaze->pushData($__datacc94b751a6dbee3c6cddb4c1c630c48a); ?>
<?php ob_start(); ?>
    <textarea
        <?php echo e($attributes->class($classes)); ?>

        rows="<?php echo e($rows); ?>"
        <?php if(isset($name)): ?> name="<?php echo e($name); ?>" <?php endif; ?>
        [STARTCOMPILEDUNBLAZE:oubtNAATxS]<?php \Livewire\Blaze\Unblaze::storeScope("oubtNAATxS", scope: ['name' => $name ?? null, 'invalid' => $invalid ?? false]) ?><?php \Livewire\Blaze\Unblaze::storeReplacement("oubtNAATxS", "CiAgICAgICAgPD9waHAgaWYgKCRzY29wZVsnaW52YWxpZCddIHx8ICgkc2NvcGVbJ25hbWUnXSAmJiAkZXJyb3JzLT5oYXMoJHNjb3BlWyduYW1lJ10pKSk6ID8+CiAgICAgICAgYXJpYS1pbnZhbGlkPSJ0cnVlIiBkYXRhLWludmFsaWQKICAgICAgICA8P3BocCBlbmRpZjsgPz4KICAgICAgICA=") ?>[ENDCOMPILEDUNBLAZE:oubtNAATxS]
        data-flux-control
        data-flux-textarea
    ><?php echo e($slot); ?></textarea>
<?php $__slotscc94b751a6dbee3c6cddb4c1c630c48a['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotscc94b751a6dbee3c6cddb4c1c630c48a); ?>
<?php __cc94b751a6dbee3c6cddb4c1c630c48a($__blaze, $__datacc94b751a6dbee3c6cddb4c1c630c48a, $__blaze->mergeAttributes(['attributes' => $__datacc94b751a6dbee3c6cddb4c1c630c48a['attributes']]), $__slotscc94b751a6dbee3c6cddb4c1c630c48a, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackcc94b751a6dbee3c6cddb4c1c630c48a)) { $__slotscc94b751a6dbee3c6cddb4c1c630c48a = array_pop($__slotsStackcc94b751a6dbee3c6cddb4c1c630c48a); } ?>
<?php if (! empty($__dataStackcc94b751a6dbee3c6cddb4c1c630c48a)) { $__datacc94b751a6dbee3c6cddb4c1c630c48a = array_pop($__dataStackcc94b751a6dbee3c6cddb4c1c630c48a); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/textarea.blade.php ENDPATH**/ ?>