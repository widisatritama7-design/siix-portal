<?php # [BlazeFolded]:{flux::icon.x-mark}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/x-mark.blade.php}:{1774988736} ?>
<?php
if (!function_exists('_fc39e4ea1c16959f587f41e5e04caadf')):
function _fc39e4ea1c16959f587f41e5e04caadf($__blaze, $__data = [], $__slots = [], $__bound = [], $__keys = [], $__this = null) {
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

<?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php', $__blaze->compiledPath.'/a35b24e3885f01762aff8c840e2c3d4c.php'); ?>
<?php if (isset($__slotsa35b24e3885f01762aff8c840e2c3d4c)) { $__slotsStacka35b24e3885f01762aff8c840e2c3d4c[] = $__slotsa35b24e3885f01762aff8c840e2c3d4c; } ?>
<?php if (isset($__attrsa35b24e3885f01762aff8c840e2c3d4c)) { $__attrsStacka35b24e3885f01762aff8c840e2c3d4c[] = $__attrsa35b24e3885f01762aff8c840e2c3d4c; } ?>
<?php $__attrsa35b24e3885f01762aff8c840e2c3d4c = ['attributes' => $attributes,'size' => $size === 'sm' || $size === 'xs' ? 'xs' : 'sm','xData' => 'fluxInputClearable','xOn:click' => 'clear()','tabindex' => '-1','ariaLabel' => 'Clear input','dataFluxClearButton' => true]; ?>
<?php $__slotsa35b24e3885f01762aff8c840e2c3d4c = []; ?>
<?php $__blaze->pushData($__attrsa35b24e3885f01762aff8c840e2c3d4c); ?>
<?php ob_start(); ?>
    <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
<?php $__slotsa35b24e3885f01762aff8c840e2c3d4c['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsa35b24e3885f01762aff8c840e2c3d4c); ?>
<?php _a35b24e3885f01762aff8c840e2c3d4c($__blaze, $__attrsa35b24e3885f01762aff8c840e2c3d4c, $__slotsa35b24e3885f01762aff8c840e2c3d4c, ['attributes', 'size', 'dataFluxClearButton'], ['xData' => 'x-data', 'xOn:click' => 'x-on:click', 'ariaLabel' => 'aria-label', 'dataFluxClearButton' => 'data-flux-clear-button'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStacka35b24e3885f01762aff8c840e2c3d4c)) { $__slotsa35b24e3885f01762aff8c840e2c3d4c = array_pop($__slotsStacka35b24e3885f01762aff8c840e2c3d4c); } ?>
<?php if (! empty($__attrsStacka35b24e3885f01762aff8c840e2c3d4c)) { $__attrsa35b24e3885f01762aff8c840e2c3d4c = array_pop($__attrsStacka35b24e3885f01762aff8c840e2c3d4c); } ?>
<?php $__blaze->popData(); ?>
<?php
echo ltrim(ob_get_clean());
} endif; ?><?php /**PATH D:\laragon\www\siix-portal-new\vendor\livewire\flux\stubs\resources\views\flux\input\clearable.blade.php ENDPATH**/ ?>