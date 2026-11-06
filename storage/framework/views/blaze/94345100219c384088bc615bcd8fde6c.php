<?php # [BlazeVersion]:{v3} ?>
<?php
if (!function_exists('__7cb9d23fb9903ab4e2c8837c93699fca')):
function __7cb9d23fb9903ab4e2c8837c93699fca($__blaze, $__data = [], $__attributes = [], $__slots = [], $__this = null) {
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

<?php if (!function_exists('__b119ceb1b9a3e04beca2cedd1073790a')) { require $__blaze->compile('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/with-field.blade.php'); } ?>
<?php if (isset($__slotsb119ceb1b9a3e04beca2cedd1073790a)) { $__slotsStackb119ceb1b9a3e04beca2cedd1073790a[] = $__slotsb119ceb1b9a3e04beca2cedd1073790a; } ?>
<?php if (isset($__datab119ceb1b9a3e04beca2cedd1073790a)) { $__dataStackb119ceb1b9a3e04beca2cedd1073790a[] = $__datab119ceb1b9a3e04beca2cedd1073790a; } ?>
<?php $__datab119ceb1b9a3e04beca2cedd1073790a = ['attributes' => $attributes]; ?>
<?php $__slotsb119ceb1b9a3e04beca2cedd1073790a = []; ?>
<?php $__blaze->pushData($__datab119ceb1b9a3e04beca2cedd1073790a); ?>
<?php ob_start(); ?>
    <textarea
        <?php echo e($attributes->class($classes)); ?>

        rows="<?php echo e($rows); ?>"
        <?php if(isset($name)): ?> name="<?php echo e($name); ?>" <?php endif; ?>
        [STARTCOMPILEDUNBLAZE:JxPcMDaSuv]<?php \Livewire\Blaze\Unblaze::storeScope("JxPcMDaSuv", scope: ['name' => $name ?? null, 'invalid' => $invalid ?? false]) ?><?php \Livewire\Blaze\Unblaze::storeReplacement("JxPcMDaSuv", "CiAgICAgICAgPD9waHAgaWYgKCRzY29wZVsnaW52YWxpZCddIHx8ICgkc2NvcGVbJ25hbWUnXSAmJiAkZXJyb3JzLT5oYXMoJHNjb3BlWyduYW1lJ10pKSk6ID8+CiAgICAgICAgYXJpYS1pbnZhbGlkPSJ0cnVlIiBkYXRhLWludmFsaWQKICAgICAgICA8P3BocCBlbmRpZjsgPz4KICAgICAgICA=") ?>[ENDCOMPILEDUNBLAZE:JxPcMDaSuv]
        data-flux-control
        data-flux-textarea
    ><?php echo e($slot); ?></textarea>
<?php $__slotsb119ceb1b9a3e04beca2cedd1073790a['slot'] = new \Illuminate\View\ComponentSlot($__blaze->processPassthroughContent('trim', trim(ob_get_clean())), []); ?>
<?php $__blaze->pushSlots($__slotsb119ceb1b9a3e04beca2cedd1073790a); ?>
<?php __b119ceb1b9a3e04beca2cedd1073790a($__blaze, $__datab119ceb1b9a3e04beca2cedd1073790a, $__blaze->mergeAttributes(['attributes' => $__datab119ceb1b9a3e04beca2cedd1073790a['attributes']]), $__slotsb119ceb1b9a3e04beca2cedd1073790a, $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackb119ceb1b9a3e04beca2cedd1073790a)) { $__slotsb119ceb1b9a3e04beca2cedd1073790a = array_pop($__slotsStackb119ceb1b9a3e04beca2cedd1073790a); } ?>
<?php if (! empty($__dataStackb119ceb1b9a3e04beca2cedd1073790a)) { $__datab119ceb1b9a3e04beca2cedd1073790a = array_pop($__dataStackb119ceb1b9a3e04beca2cedd1073790a); } ?>
<?php $__blaze->popData(); ?>
<?php
echo $__blaze->processPassthroughContent('ltrim', ltrim(ob_get_clean()));
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/textarea.blade.php ENDPATH**/ ?>