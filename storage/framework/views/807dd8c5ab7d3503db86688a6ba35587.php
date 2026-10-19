<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label' => 'Phase',
    'note'  => '',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'label' => 'Phase',
    'note'  => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="relative rounded-2xl overflow-hidden shadow-lg ring-1 ring-zinc-200 dark:ring-zinc-700 bg-zinc-50 dark:bg-zinc-900/50 border-2 border-dashed border-zinc-300 dark:border-zinc-700">
    <div class="p-8 text-center">
        <div class="w-12 h-12 rounded-full bg-zinc-200 dark:bg-zinc-800 flex items-center justify-center mx-auto mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <h3 class="text-base font-bold text-zinc-700 dark:text-zinc-300 mb-1"><?php echo e($label); ?></h3>
        <p class="text-xs text-zinc-500 dark:text-zinc-400"><?php echo e($note); ?></p>
    </div>
</div><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/livewire/qaqc/scan-xray/partials/phase-locked.blade.php ENDPATH**/ ?>