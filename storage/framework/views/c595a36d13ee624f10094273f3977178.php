<?php # [BlazeFolded]:{flux::icon.x-mark}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/x-mark.blade.php}:{1774988736} ?>
<?php
if (!function_exists('_c595a36d13ee624f10094273f3977178')):
function _c595a36d13ee624f10094273f3977178($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
$__env = $__blaze->env;

if (($__data['attributes'] ?? null) instanceof \Illuminate\View\ComponentAttributeBag) { $__data = $__data + $__data['attributes']->all(); unset($__data['attributes']); }
extract($__slots, EXTR_SKIP); unset($__slots);
extract($__data, EXTR_SKIP);
$attributes = \Livewire\Blaze\Runtime\BlazeAttributeBag::make($__data, $__bound, $__keys);
unset($__data, $__bound, $__keys);
ob_start();
?>


<?php
$attributes = $attributes->merge([
    'variant' => 'subtle',
    'class' => '-me-1 [[data-flux-input]:has(input:placeholder-shown)_&]:hidden [[data-flux-input]:has(input[disabled])_&]:hidden',
    'square' => true,
    'size' => null,
]);
?>

<?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php', $__blaze->compiledPath.'/fad05d57e1e0bf8b6251725acbf0d97e.php'); ?>
<?php if (isset($__slotsfad05d57e1e0bf8b6251725acbf0d97e)) { $__slotsStackfad05d57e1e0bf8b6251725acbf0d97e[] = $__slotsfad05d57e1e0bf8b6251725acbf0d97e; } ?>
<?php if (isset($__attrsfad05d57e1e0bf8b6251725acbf0d97e)) { $__attrsStackfad05d57e1e0bf8b6251725acbf0d97e[] = $__attrsfad05d57e1e0bf8b6251725acbf0d97e; } ?>
<?php $__attrsfad05d57e1e0bf8b6251725acbf0d97e = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputClearable','xOn:click' => 'clear()','tabindex' => '-1','ariaLabel' => 'Clear input','dataFluxClearButton' => true]; ?>
<?php $__slotsfad05d57e1e0bf8b6251725acbf0d97e = []; ?>
<?php $__blaze->pushData($__attrsfad05d57e1e0bf8b6251725acbf0d97e); ?>
<?php ob_start(); ?>
    <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
<?php $__slotsfad05d57e1e0bf8b6251725acbf0d97e['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsfad05d57e1e0bf8b6251725acbf0d97e); ?>
<?php _fad05d57e1e0bf8b6251725acbf0d97e($__blaze, $__attrsfad05d57e1e0bf8b6251725acbf0d97e, $__slotsfad05d57e1e0bf8b6251725acbf0d97e, ['attributes', 'size', 'dataFluxClearButton'], ['xData' => 'x-data', 'xOn:click' => 'x-on:click', 'ariaLabel' => 'aria-label', 'dataFluxClearButton' => 'data-flux-clear-button'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackfad05d57e1e0bf8b6251725acbf0d97e)) { $__slotsfad05d57e1e0bf8b6251725acbf0d97e = array_pop($__slotsStackfad05d57e1e0bf8b6251725acbf0d97e); } ?>
<?php if (! empty($__attrsStackfad05d57e1e0bf8b6251725acbf0d97e)) { $__attrsfad05d57e1e0bf8b6251725acbf0d97e = array_pop($__attrsStackfad05d57e1e0bf8b6251725acbf0d97e); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/stubs/resources/views/flux/input/clearable.blade.php ENDPATH**/ ?>