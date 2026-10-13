<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'key'   => 'first_piece_items',
    'label' => 'First Piece Items',
    'items' => [],
    'readonly' => false,
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
    'key'   => 'first_piece_items',
    'label' => 'First Piece Items',
    'items' => [],
    'readonly' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $fieldLabels = [
        'time_scan'      => 'Time Scan',
        'ok_qty'         => 'OK Qty',
        'ng_qty'         => 'NG Qty',
        'reject_rate'    => 'Reject Rate',
        'status_running' => 'Status Running',
        'filling_ratio'  => 'Filling Ratio',
        'pictures'       => 'Pictures',
        'qty_hold'       => 'Qty Hold',
        'ncp_id'         => 'NCP',
        'remarks'        => 'Remarks',
    ];

    $pcbLabels = [
        'pcb_a'       => 'PCB A',
        'pcb_b'       => 'PCB B',
        'pcb_c'       => 'PCB C',
        'pcb_circuit' => 'PCB Circuit',
    ];

    $pcbCols = array_keys($pcbLabels);

    $sideMeta = [
        'side_lh' => [
            'label' => 'Side LH',
            'icon'  => 'arrow-left',
            'class' => 'from-blue-500 to-blue-600',
            'badge' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
        ],
        'side_rh' => [
            'label' => 'Side RH',
            'icon'  => 'arrow-right',
            'class' => 'from-emerald-500 to-emerald-600',
            'badge' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
        ],
    ];

    $ngQty = (int) ($items['ng_qty'] ?? 0);
    $showNgFields = $ngQty > 0;
    $okQty = (int) ($items['ok_qty'] ?? 0);
    $totalQty = $okQty + $ngQty;
    $statusRunning = $items['status_running'] ?? null;
?>


<div class="relative rounded-2xl overflow-hidden shadow-lg ring-1 ring-blue-200/50 dark:ring-blue-800/50 bg-white dark:bg-zinc-900">

    
    <div class="relative px-6 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 overflow-hidden">
        <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/10"></div>
        <div class="absolute -right-4 -bottom-10 w-20 h-20 rounded-full bg-white/10"></div>

        <div class="relative flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                        <path fill-rule="evenodd" d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 18.375V5.625ZM21 9.375A.375.375 0 0 0 20.625 9h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5ZM10.875 18.75a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5ZM3.375 15h7.5a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375Zm0-3.75h7.5a.375.375 0 0 0 .375-.375v-1.5A.375.375 0 0 0 10.875 9h-7.5A.375.375 0 0 0 3 9.375v1.5c0 .207.168.375.375.375Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <div class="text-[10px] text-white/70 uppercase tracking-wider font-semibold">Inspection Group</div>
                    <div class="text-base font-bold text-white leading-tight"><?php echo e($label); ?></div>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalQty > 0 || $statusRunning): ?>
                <div class="flex items-center gap-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($statusRunning): ?>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full <?php echo e(strtolower($statusRunning) === 'running' ? 'bg-emerald-300 animate-pulse' : 'bg-zinc-300'); ?>"></span>
                            <?php echo e($statusRunning); ?>

                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalQty > 0): ?>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-300"></span>
                            OK: <?php echo e($okQty); ?>

                        </span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ngQty > 0): ?>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-300 animate-pulse"></span>
                                NG: <?php echo e($ngQty); ?>

                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    
    <div class="p-5 space-y-5 bg-gradient-to-b from-white to-zinc-50/50 dark:from-zinc-900 dark:to-zinc-900/50">

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $sideMeta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $side => $meta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <?php
                $counts = collect($pcbCols)
                    ->map(fn($c) => count($items[$side][$c] ?? []))
                    ->max() ?? 0;
                $rows = max(1, $counts);
                $filledCount = 0;
                foreach ($pcbCols as $c) {
                    foreach (($items[$side][$c] ?? []) as $v) {
                        if (!empty($v)) $filledCount++;
                    }
                }
            ?>

            <div class="rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 shadow-sm bg-white dark:bg-zinc-900">

                
                <div class="px-4 py-2.5 bg-gradient-to-r <?php echo e($meta['class']); ?> flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-white">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($side === 'side_lh'): ?>
                                <path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd" />
                            <?php else: ?>
                                <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </svg>
                        <span class="text-sm font-bold text-white tracking-wide"><?php echo e($meta['label']); ?></span>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-white/20 backdrop-blur-sm border border-white/30 text-white text-[10px] font-semibold">
                        <?php echo e($filledCount); ?> / <?php echo e($rows * count($pcbCols)); ?> filled
                    </span>
                </div>

                
                <div class="overflow-x-auto">
                    <table class="w-full text-xs">
                        <thead>
                            <tr class="bg-zinc-100 dark:bg-zinc-800/80 border-b-2 border-zinc-200 dark:border-zinc-700">
                                <th class="px-2 py-2.5 text-center font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-[10px] w-10">#</th>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $pcbLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col => $colLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <th class="px-3 py-2.5 text-center font-semibold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider text-[10px]">
                                        <?php echo e($colLabel); ?>

                                    </th>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$readonly): ?>
                                    <th class="px-2 py-2.5 text-center font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-[10px] w-12">Act</th>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 0; $i < $rows; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <?php
                                    $rowHasContent = false;
                                    foreach ($pcbCols as $c) {
                                        if (!empty($items[$side][$c][$i] ?? null)) {
                                            $rowHasContent = true;
                                            break;
                                        }
                                    }
                                ?>
                                <tr class="border-b border-zinc-100 dark:border-zinc-800 transition-colors
                                    <?php echo e($rowHasContent ? 'bg-white dark:bg-zinc-900' : 'bg-zinc-50/50 dark:bg-zinc-800/20'); ?>

                                    hover:bg-blue-50/60 dark:hover:bg-blue-900/10">

                                    <td class="px-2 py-1 text-center">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-md
                                            <?php echo e($rowHasContent ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : 'bg-zinc-100 text-zinc-400 dark:bg-zinc-800 dark:text-zinc-500'); ?>

                                            text-[10px] font-bold">
                                            <?php echo e($i + 1); ?>

                                        </span>
                                    </td>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $pcbCols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colIdx => $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <?php $isLastCol = ($colIdx === count($pcbCols) - 1); ?>
                                        <td class="px-1 py-1">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($readonly): ?>
                                                <span class="px-2 py-1.5 block text-xs font-mono text-zinc-800 dark:text-zinc-200 rounded text-center
                                                    <?php echo e(!empty($items[$side][$col][$i] ?? null) ? 'bg-zinc-50 dark:bg-zinc-800/50' : ''); ?>">
                                                    <?php echo e($items[$side][$col][$i] ?? '-'); ?>

                                                </span>
                                            <?php else: ?>
                                                <input
                                                    type="text"
                                                    data-pcb-input
                                                    data-group="<?php echo e($key); ?>"
                                                    data-side="<?php echo e($side); ?>"
                                                    data-row="<?php echo e($i); ?>"
                                                    data-col="<?php echo e($col); ?>"
                                                    wire:model="<?php echo e($key); ?>.<?php echo e($side); ?>.<?php echo e($col); ?>.<?php echo e($i); ?>"
                                                    x-on:keydown.enter.prevent="
                                                        $el.blur();
                                                        
                                                        <?php if($i < $rows - 1): ?>
                                                            
                                                            const next = document.querySelector(
                                                                `input[data-group='<?php echo e($key); ?>'][data-side='<?php echo e($side); ?>'][data-row='<?php echo e($i + 1); ?>'][data-col='<?php echo e($col); ?>']`
                                                            );
                                                            if (next) next.focus();
                                                        <?php else: ?>
                                                            
                                                            $wire.addRow('<?php echo e($key); ?>', '<?php echo e($side); ?>').then(() => {
                                                                setTimeout(() => {
                                                                    const next = document.querySelector(
                                                                        `input[data-group='<?php echo e($key); ?>'][data-side='<?php echo e($side); ?>'][data-row='<?php echo e($i + 1); ?>'][data-col='<?php echo e($col); ?>']`
                                                                    );
                                                                    if (next) next.focus();
                                                                }, 100);
                                                            });
                                                        <?php endif; ?>
                                                    "
                                                    x-on:keydown.tab="
                                                        if (<?php echo e($isLastCol ? 'true' : 'false'); ?>) {
                                                            $event.preventDefault();
                                                            $el.blur();
                                                            $wire.addRow('<?php echo e($key); ?>', '<?php echo e($side); ?>').then(() => {
                                                                setTimeout(() => {
                                                                    const next = document.querySelector(
                                                                        `input[data-group='<?php echo e($key); ?>'][data-side='<?php echo e($side); ?>'][data-row='<?php echo e($i + 1); ?>'][data-col='<?php echo e($pcbCols[0]); ?>']`
                                                                    );
                                                                    if (next) next.focus();
                                                                }, 80);
                                                            });
                                                        }
                                                    "
                                                    class="w-full border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/50
                                                        px-2 py-1.5 text-xs rounded-md text-center
                                                        hover:border-blue-300 dark:hover:border-blue-700
                                                        focus:border-blue-400 focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-900/40
                                                        focus:bg-white dark:focus:bg-zinc-800
                                                        transition-all placeholder:text-zinc-300 dark:placeholder:text-zinc-500"
                                                    placeholder="—" />
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$readonly): ?>
                                        <td class="px-1 py-1 text-center">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rows > 1): ?>
                                                <button type="button"
                                                    wire:click="removeRow('<?php echo e($key); ?>', '<?php echo e($side); ?>', <?php echo e($i); ?>)"
                                                    class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-red-500
                                                        hover:bg-red-50 hover:text-red-700 dark:hover:bg-red-900/30
                                                        transition-all group"
                                                    title="Hapus baris">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5 group-hover:scale-110 transition-transform">
                                                        <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482 41.03 41.03 0 0 0-2.365-.298V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$readonly): ?>
                    <div class="p-2 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                        <button type="button"
                            wire:click="addRow('<?php echo e($key); ?>', '<?php echo e($side); ?>')"
                            class="w-full inline-flex items-center justify-center gap-1.5 text-xs px-3 py-2
                                bg-gradient-to-r <?php echo e($meta['class']); ?> text-white rounded-lg
                                hover:shadow-md hover:scale-[1.01] active:scale-[0.99]
                                transition-all font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                            </svg>
                            Tambah Baris
                        </button>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

        
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-3 shadow-sm">
            <div class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-2 px-1 text-center">
                Ringkasan
            </div>

            <?php
                // 4 kolom kalau create/edit (OK, NG, Reject, Status Running)
                // 5 kolom kalau view (Time Scan, OK, NG, Reject, Status Running)
                $basicCardCount = $readonly ? 5 : 4;
                $gridClass = match($basicCardCount) {
                    5 => 'grid-cols-2 md:grid-cols-5',
                    4 => 'grid-cols-2 md:grid-cols-4',
                    default => 'grid-cols-2 md:grid-cols-3',
                };
            ?>

            <div class="grid <?php echo e($gridClass); ?> gap-3">

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($readonly): ?>
                    
                    <div class="rounded-lg bg-zinc-50 dark:bg-zinc-800/50 p-3 border border-zinc-100 dark:border-zinc-800 text-center">
                        <div class="flex items-center justify-center gap-1.5 text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd" />
                            </svg>
                            <?php echo e($fieldLabels['time_scan']); ?>

                        </div>
                        <div class="text-sm font-mono font-bold text-zinc-800 dark:text-zinc-200 text-center">
                            <?php echo e($items['time_scan'] ?? '-'); ?>

                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div class="rounded-lg bg-gradient-to-br from-emerald-50 to-emerald-100/50 dark:from-emerald-900/20 dark:to-emerald-900/10 p-3 border border-emerald-200 dark:border-emerald-800 text-center">
                    <div class="flex items-center justify-center gap-1.5 text-[10px] text-emerald-700 dark:text-emerald-400 uppercase tracking-wider font-semibold mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                        </svg>
                        <?php echo e($fieldLabels['ok_qty']); ?>

                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($readonly): ?>
                        <div class="text-2xl font-bold text-emerald-700 dark:text-emerald-300 text-center"><?php echo e($okQty); ?></div>
                    <?php else: ?>
                        <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/f9ce25dced5c86c906351e8ca96b9cbb.php'); ?>
<?php $__blaze->pushData(['type' => 'number','wire:model.live.debounce.300ms' => e($key).'.ok_qty','min' => '0','class' => '!border-emerald-300 focus:!border-emerald-500 !bg-white dark:!bg-zinc-900 !font-bold !text-lg !text-center']); ?>
<?php _f9ce25dced5c86c906351e8ca96b9cbb($__blaze, ['type' => 'number','wire:model.live.debounce.300ms' => e($key).'.ok_qty','min' => '0','class' => '!border-emerald-300 focus:!border-emerald-500 !bg-white dark:!bg-zinc-900 !font-bold !text-lg !text-center'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="rounded-lg bg-gradient-to-br from-red-50 to-red-100/50 dark:from-red-900/20 dark:to-red-900/10 p-3 border border-red-200 dark:border-red-800 text-center">
                    <div class="flex items-center justify-center gap-1.5 text-[10px] text-red-700 dark:text-red-400 uppercase tracking-wider font-semibold mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        <?php echo e($fieldLabels['ng_qty']); ?>

                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($readonly): ?>
                        <div class="text-2xl font-bold text-red-700 dark:text-red-300 text-center"><?php echo e($ngQty); ?></div>
                    <?php else: ?>
                        <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/f9ce25dced5c86c906351e8ca96b9cbb.php'); ?>
<?php $__blaze->pushData(['type' => 'number','wire:model.live.debounce.300ms' => e($key).'.ng_qty','min' => '0','class' => '!border-red-300 focus:!border-red-500 !bg-white dark:!bg-zinc-900 !font-bold !text-lg !text-center']); ?>
<?php _f9ce25dced5c86c906351e8ca96b9cbb($__blaze, ['type' => 'number','wire:model.live.debounce.300ms' => e($key).'.ng_qty','min' => '0','class' => '!border-red-300 focus:!border-red-500 !bg-white dark:!bg-zinc-900 !font-bold !text-lg !text-center'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="rounded-lg bg-gradient-to-br from-zinc-50 to-zinc-100/50 dark:from-zinc-800/50 dark:to-zinc-800/20 p-3 border border-zinc-200 dark:border-zinc-700 text-center">
                    <div class="flex items-center justify-center gap-1.5 text-[10px] text-zinc-600 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path fill-rule="evenodd" d="M1 2.75A.75.75 0 0 1 1.75 2h16.5a.75.75 0 0 1 0 1.5H1.75A.75.75 0 0 1 1 2.75Zm0 5A.75.75 0 0 1 1.75 7h16.5a.75.75 0 0 1 0 1.5H1.75A.75.75 0 0 1 1 7.75Zm0 5A.75.75 0 0 1 1.75 12h16.5a.75.75 0 0 1 0 1.5H1.75A.75.75 0 0 1 1 12.75Z" clip-rule="evenodd" />
                        </svg>
                        <?php echo e($fieldLabels['reject_rate']); ?>

                    </div>
                    <?php $rr = (float) ($items['reject_rate'] ?? 0); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($readonly): ?>
                        <div class="flex items-center justify-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-lg font-bold
                                <?php echo e($rr >= 5 ? 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300' : ($rr > 0 ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300')); ?>">
                                <?php echo e($rr); ?>%
                            </span>
                        </div>
                    <?php else: ?>
                        <div class="text-lg font-bold font-mono text-center <?php echo e($rr >= 5 ? 'text-red-600' : ($rr > 0 ? 'text-amber-600' : 'text-emerald-600')); ?>">
                            <?php echo e($rr); ?>%
                            <span class="text-[10px] text-zinc-400 font-normal">auto</span>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="rounded-lg bg-gradient-to-br from-cyan-50 to-cyan-100/50 dark:from-cyan-900/20 dark:to-cyan-900/10 p-3 border border-cyan-200 dark:border-cyan-800 text-center">
                    <div class="flex items-center justify-center gap-1.5 text-[10px] text-cyan-700 dark:text-cyan-400 uppercase tracking-wider font-semibold mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path fill-rule="evenodd" d="M2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm6.39-2.908a.75.75 0 0 1 .766.027l3.5 2.25a.75.75 0 0 1 0 1.262l-3.5 2.25A.75.75 0 0 1 8 12.25v-4.5a.75.75 0 0 1 .39-.658Z" clip-rule="evenodd" />
                        </svg>
                        <?php echo e($fieldLabels['status_running']); ?> <span class="text-red-500">*</span>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($readonly): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($statusRunning): ?>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold
                                <?php echo e(strtolower($statusRunning) === 'running' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300'); ?>">
                                <?php echo e($statusRunning); ?>

                            </span>
                        <?php else: ?>
                            <div class="text-sm text-zinc-500 text-center">-</div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php else: ?>
                        <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/f9ce25dced5c86c906351e8ca96b9cbb.php'); ?>
<?php $__blaze->pushData(['type' => 'text','wire:model' => e($key).'.status_running','placeholder' => 'Machine / Others','class' => '!text-center !font-semibold !border-cyan-300 focus:!border-cyan-500']); ?>
<?php _f9ce25dced5c86c906351e8ca96b9cbb($__blaze, ['type' => 'text','wire:model' => e($key).'.status_running','placeholder' => 'Machine / Others','class' => '!text-center !font-semibold !border-cyan-300 focus:!border-cyan-500'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ["$key.status_running"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red-500 text-xs block mt-1 text-center"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showNgFields): ?>
            <?php
                $ngFieldFilled = 0;
                $ngFieldTotal = 6;
                if (!empty($items['filling_ratio'])) $ngFieldFilled++;
                if (!empty($items['qty_hold'])) $ngFieldFilled++;
                if (!empty($items['status_after_check']['ok'])) $ngFieldFilled++;
                if (!empty($items['status_after_check']['ng'])) $ngFieldFilled++;
                if (!empty($items['ncp_id'])) $ngFieldFilled++;
                if (!empty($items['remarks'])) $ngFieldFilled++;
            ?>

            <div x-data="{ open: false }"
                class="relative rounded-2xl overflow-hidden shadow-lg ring-1 ring-red-200/50 dark:ring-red-800/50 bg-white dark:bg-zinc-900">

                
                <button type="button"
                    x-on:click="open = !open"
                    class="w-full relative px-6 py-4 bg-gradient-to-r from-red-500 via-rose-500 to-pink-500 overflow-hidden cursor-pointer hover:from-red-600 hover:via-rose-600 hover:to-pink-600 transition-all">
                    <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/10"></div>
                    <div class="absolute -right-4 -bottom-10 w-20 h-20 rounded-full bg-white/10"></div>

                    <div class="relative flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="text-left">
                                <div class="text-[10px] text-white/70 uppercase tracking-wider font-semibold">Required Fields</div>
                                <div class="text-base font-bold text-white leading-tight">NG Detail</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                NG Qty: <?php echo e($ngQty); ?>

                            </span>

                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                                <?php echo e($ngFieldFilled); ?>/<?php echo e($ngFieldTotal); ?> filled
                            </span>

                            <div class="w-8 h-8 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center transition-transform duration-300"
                                :class="open ? 'rotate-180' : ''">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-white">
                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </button>

                
                <div x-show="open" x-collapse x-cloak class="p-5 bg-gradient-to-b from-white to-zinc-50/50 dark:from-zinc-900 dark:to-zinc-900/50">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                        
                        <div class="rounded-xl border border-orange-200 dark:border-orange-800 bg-gradient-to-br from-orange-50 to-orange-100/50 dark:from-orange-900/20 dark:to-orange-900/10 overflow-hidden shadow-sm">
                            <div class="px-3 py-2 bg-gradient-to-r from-orange-500 to-amber-500 flex items-center justify-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5 text-white">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-xs font-bold text-white uppercase tracking-wide">
                                    <?php echo e($fieldLabels['filling_ratio']); ?>

                                </span>
                            </div>
                            <div class="p-4 text-center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($readonly): ?>
                                    <div class="text-2xl font-bold text-orange-700 dark:text-orange-300">
                                        <?php echo e(isset($items['filling_ratio']) && $items['filling_ratio'] !== null ? $items['filling_ratio'] . '%' : '-'); ?>

                                    </div>
                                <?php else: ?>
                                    <div class="relative">
                                        <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/f9ce25dced5c86c906351e8ca96b9cbb.php'); ?>
<?php $__blaze->pushData(['type' => 'number','step' => '0.01','min' => '0','max' => '100','wire:model' => e($key).'.filling_ratio','placeholder' => '0 - 100','class' => 'pr-9 !text-center !text-lg !font-bold']); ?>
<?php _f9ce25dced5c86c906351e8ca96b9cbb($__blaze, ['type' => 'number','step' => '0.01','min' => '0','max' => '100','wire:model' => e($key).'.filling_ratio','placeholder' => '0 - 100','class' => 'pr-9 !text-center !text-lg !font-bold'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-zinc-400 font-bold">%</span>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ["$key.filling_ratio"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs block mt-1 text-center"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="rounded-xl border border-amber-200 dark:border-amber-800 bg-gradient-to-br from-amber-50 to-amber-100/50 dark:from-amber-900/20 dark:to-amber-900/10 overflow-hidden shadow-sm">
                            <div class="px-3 py-2 bg-gradient-to-r from-amber-500 to-yellow-500 flex items-center justify-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5 text-white">
                                    <path fill-rule="evenodd" d="M10 2a.75.75 0 0 1 .75.75v.258a33.186 33.186 0 0 1 6.668.83.75.75 0 0 1-.336 1.461 31.28 31.28 0 0 0-1.103-.232l1.702 7.545a.75.75 0 0 1-.387.832A4.981 4.981 0 0 1 15 14c-.825 0-1.606-.2-2.294-.556a.75.75 0 0 1-.387-.832l1.77-7.849a31.743 31.743 0 0 0-3.339-.254v11.505a20.01 20.01 0 0 1 3.78.501.75.75 0 1 1-.339 1.462A18.558 18.558 0 0 0 10 17.5c-1.442 0-2.845.165-4.191.477a.75.75 0 0 1-.338-1.462 20.01 20.01 0 0 1 3.779-.501V4.509c-1.129.026-2.243.112-3.34.254l1.771 7.85a.75.75 0 0 1-.387.83A4.98 4.98 0 0 1 5 14a4.98 4.98 0 0 1-2.294-.556.75.75 0 0 1-.387-.832L4.02 5.067c-.37.07-.738.148-1.103.232a.75.75 0 0 1-.336-1.462 33.186 33.186 0 0 1 6.668-.83V2.75A.75.75 0 0 1 10 2Z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-xs font-bold text-white uppercase tracking-wide">
                                    <?php echo e($fieldLabels['qty_hold']); ?>

                                </span>
                            </div>
                            <div class="p-4 text-center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($readonly): ?>
                                    <div class="text-2xl font-bold font-mono text-amber-700 dark:text-amber-300">
                                        <?php echo e($items['qty_hold'] ?? 0); ?>

                                    </div>
                                <?php else: ?>
                                    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/f9ce25dced5c86c906351e8ca96b9cbb.php'); ?>
<?php $__blaze->pushData(['type' => 'number','min' => '0','wire:model.live.debounce.300ms' => e($key).'.qty_hold','class' => '!text-center !text-lg !font-bold']); ?>
<?php _f9ce25dced5c86c906351e8ca96b9cbb($__blaze, ['type' => 'number','min' => '0','wire:model.live.debounce.300ms' => e($key).'.qty_hold','class' => '!text-center !text-lg !font-bold'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="rounded-xl border border-emerald-200 dark:border-emerald-800 bg-gradient-to-br from-emerald-50 to-emerald-100/50 dark:from-emerald-900/20 dark:to-emerald-900/10 overflow-hidden shadow-sm">
                            <div class="px-3 py-2 bg-gradient-to-r from-emerald-500 to-green-500 flex items-center justify-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5 text-white">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-xs font-bold text-white uppercase tracking-wide">
                                    Status OK
                                </span>
                            </div>
                            <div class="p-4 text-center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($readonly): ?>
                                    <div class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">
                                        <?php echo e($items['status_after_check']['ok'] ?? 0); ?>

                                    </div>
                                <?php else: ?>
                                    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/f9ce25dced5c86c906351e8ca96b9cbb.php'); ?>
<?php $__blaze->pushData(['type' => 'number','min' => '0','wire:model.live.debounce.300ms' => e($key).'.status_after_check.ok','class' => '!border-emerald-300 focus:!border-emerald-500 !text-center !text-lg !font-bold']); ?>
<?php _f9ce25dced5c86c906351e8ca96b9cbb($__blaze, ['type' => 'number','min' => '0','wire:model.live.debounce.300ms' => e($key).'.status_after_check.ok','class' => '!border-emerald-300 focus:!border-emerald-500 !text-center !text-lg !font-bold'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="rounded-xl border border-red-200 dark:border-red-800 bg-gradient-to-br from-red-50 to-red-100/50 dark:from-red-900/20 dark:to-red-900/10 overflow-hidden shadow-sm">
                            <div class="px-3 py-2 bg-gradient-to-r from-red-500 to-rose-500 flex items-center justify-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5 text-white">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-xs font-bold text-white uppercase tracking-wide">
                                    Status NG
                                </span>
                            </div>
                            <div class="p-4 text-center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($readonly): ?>
                                    <div class="text-2xl font-bold text-red-700 dark:text-red-300">
                                        <?php echo e($items['status_after_check']['ng'] ?? 0); ?>

                                    </div>
                                <?php else: ?>
                                    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/f9ce25dced5c86c906351e8ca96b9cbb.php'); ?>
<?php $__blaze->pushData(['type' => 'number','min' => '0','wire:model.live.debounce.300ms' => e($key).'.status_after_check.ng','class' => '!border-red-300 focus:!border-red-500 !text-center !text-lg !font-bold']); ?>
<?php _f9ce25dced5c86c906351e8ca96b9cbb($__blaze, ['type' => 'number','min' => '0','wire:model.live.debounce.300ms' => e($key).'.status_after_check.ng','class' => '!border-red-300 focus:!border-red-500 !text-center !text-lg !font-bold'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="md:col-span-2 lg:col-span-4 rounded-xl border border-indigo-200 dark:border-indigo-800 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/10 overflow-hidden shadow-sm">
                            <div class="px-4 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-white">
                                        <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 0 0 3 3.5v13A1.5 1.5 0 0 0 4.5 18h11a1.5 1.5 0 0 0 1.5-1.5V7.621a1.5 1.5 0 0 0-.44-1.06l-4.12-4.122A1.5 1.5 0 0 0 11.378 2H4.5Zm2.25 8.5a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Zm0 3a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs font-bold text-white uppercase tracking-wide">
                                        <?php echo e($fieldLabels['ncp_id']); ?>

                                    </span>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($items['ncp_id'])): ?>
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-white/20 text-white text-[10px] font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                        </svg>
                                        Selected
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="p-4">
                                <?php
                                    $ncpId = $items['ncp_id'] ?? null;
                                    $ncpLabel = '-';
                                    if ($ncpId) {
                                        $ncpModel = \App\Models\QAQC\NCP::find($ncpId);
                                        $ncpLabel = $ncpModel ? ($ncpModel->ncp_number . ' — ' . ($ncpModel->part_number ?? '')) : "ID: $ncpId";
                                    }
                                    $isPanelOpen = $openNcpPanels[$key] ?? false;
                                ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($readonly): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ncpId): ?>
                                        <div class="flex items-center gap-3 p-3 rounded-lg bg-white dark:bg-zinc-900 border border-indigo-200 dark:border-indigo-800">
                                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-white">
                                                    <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 0 0 3 3.5v13A1.5 1.5 0 0 0 4.5 18h11a1.5 1.5 0 0 0 1.5-1.5V7.621a1.5 1.5 0 0 0-.44-1.06l-4.12-4.122A1.5 1.5 0 0 0 11.378 2H4.5Z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-bold text-zinc-800 dark:text-white truncate"><?php echo e($ncpLabel); ?></div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-sm text-zinc-500 italic text-center py-2">Belum dipilih</div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php else: ?>
                                    <div class="flex gap-2">
                                        <div class="flex-1 text-sm px-3 py-2 rounded-lg border
                                            <?php echo e($ncpId ? 'border-indigo-300 bg-white dark:bg-zinc-800' : 'border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900'); ?>

                                            text-zinc-700 dark:text-zinc-300 truncate flex items-center gap-2">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ncpId): ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400 flex-shrink-0">
                                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="truncate font-medium"><?php echo e($ncpLabel); ?></span>
                                            <?php else: ?>
                                                <span class="text-zinc-400 italic">Belum dipilih</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <button type="button"
                                            wire:click="toggleNcpPanel('<?php echo e($key); ?>')"
                                            class="px-3 py-2 text-xs rounded-lg transition whitespace-nowrap inline-flex items-center gap-1 font-semibold
                                                <?php echo e($isPanelOpen
                                                    ? 'bg-zinc-600 hover:bg-zinc-700 text-white'
                                                    : 'bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white shadow-sm hover:shadow-md'); ?>">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPanelOpen): ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                                </svg>
                                                Tutup
                                            <?php else: ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                                    <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                                </svg>
                                                Pilih NCP
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </button>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ncpId): ?>
                                            <button type="button"
                                                wire:click="clearNcp('<?php echo e($key); ?>')"
                                                class="px-3 py-2 text-xs bg-red-500 text-white rounded-lg hover:bg-red-600 transition whitespace-nowrap font-semibold">
                                                Hapus
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ["$key.ncp_id"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs block mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPanelOpen): ?>
                                        <?php $ncpList = $this->getNcpListFor($key); ?>

                                        <div class="mt-3 rounded-xl overflow-hidden border border-indigo-300 dark:border-indigo-700 bg-white dark:bg-zinc-900 shadow-lg">
                                            <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/30 dark:to-purple-900/30 border-b border-indigo-200 dark:border-indigo-800">
                                                <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/f9ce25dced5c86c906351e8ca96b9cbb.php'); ?>
<?php $__blaze->pushData(['wire:model.live.debounce.300ms' => 'ncpSearches.'.e($key),'placeholder' => 'Cari NCP number / part number / customer / model...','icon' => 'magnifying-glass','clearable' => true]); ?>
<?php _f9ce25dced5c86c906351e8ca96b9cbb($__blaze, ['wire:model.live.debounce.300ms' => 'ncpSearches.'.e($key),'placeholder' => 'Cari NCP number / part number / customer / model...','icon' => 'magnifying-glass','clearable' => true], [], ['clearable'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                                            </div>

                                            <div class="overflow-x-auto">
                                                <table class="w-full text-xs">
                                                    <thead>
                                                        <tr class="bg-zinc-100 dark:bg-zinc-800/80 border-b border-zinc-200 dark:border-zinc-700">
                                                            <th class="px-3 py-2.5 text-left font-semibold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider text-[10px]">NCP Number</th>
                                                            <th class="px-3 py-2.5 text-left font-semibold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider text-[10px]">Part Number</th>
                                                            <th class="px-3 py-2.5 text-left font-semibold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider text-[10px]">Customer</th>
                                                            <th class="px-3 py-2.5 text-left font-semibold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider text-[10px]">Model</th>
                                                            <th class="px-3 py-2.5 text-center font-semibold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider text-[10px]">Status</th>
                                                            <th class="px-3 py-2.5 text-center font-semibold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider text-[10px] w-20">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $ncpList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ncp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                            <tr class="hover:bg-indigo-50 dark:hover:bg-indigo-900/20 cursor-pointer transition-colors"
                                                                wire:click="selectNcp('<?php echo e($key); ?>', <?php echo e($ncp->id); ?>)">
                                                                <td class="px-3 py-2 font-mono font-semibold text-zinc-800 dark:text-zinc-200"><?php echo e($ncp->ncp_number); ?></td>
                                                                <td class="px-3 py-2 text-zinc-600 dark:text-zinc-400"><?php echo e($ncp->part_number ?? '-'); ?></td>
                                                                <td class="px-3 py-2 text-zinc-600 dark:text-zinc-400"><?php echo e($ncp->customer ?? '-'); ?></td>
                                                                <td class="px-3 py-2 text-zinc-600 dark:text-zinc-400"><?php echo e($ncp->model_affected ?? '-'); ?></td>
                                                                <td class="px-3 py-2 text-center">
                                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold
                                                                        <?php echo e($ncp->getStatusBadgeColor() === 'green' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : ''); ?>

                                                                        <?php echo e($ncp->getStatusBadgeColor() === 'yellow' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' : ''); ?>

                                                                        <?php echo e($ncp->getStatusBadgeColor() === 'blue' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : ''); ?>

                                                                        <?php echo e($ncp->getStatusBadgeColor() === 'red' ? 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300' : ''); ?>

                                                                        <?php echo e($ncp->getStatusBadgeColor() === 'gray' ? 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300' : ''); ?>">
                                                                        <?php echo e($ncp->getStatusText()); ?>

                                                                    </span>
                                                                </td>
                                                                <td class="px-3 py-2 text-center">
                                                                    <button type="button"
                                                                        wire:click.stop="selectNcp('<?php echo e($key); ?>', <?php echo e($ncp->id); ?>)"
                                                                        class="px-3 py-1 text-[10px] bg-blue-600 text-white rounded-md hover:bg-blue-700 transition font-semibold">
                                                                        Pilih
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                            <tr>
                                                                <td colspan="6" class="px-3 py-8 text-center text-zinc-500">
                                                                    <div class="flex flex-col items-center gap-2">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-zinc-300 dark:text-zinc-600">
                                                                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                                                                        </svg>
                                                                        <span class="text-sm">No NCP found</span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ncpList->hasPages()): ?>
                                                <div class="px-3 py-2.5 border-t border-zinc-200 dark:border-zinc-700 flex items-center justify-between bg-zinc-50 dark:bg-zinc-800/50">
                                                    <div class="text-[10px] text-zinc-500 font-semibold">
                                                        <?php echo e($ncpList->firstItem() ?? 0); ?> - <?php echo e($ncpList->lastItem() ?? 0); ?> of <?php echo e($ncpList->total()); ?>

                                                    </div>
                                                    <div class="flex gap-1">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ncpList->onFirstPage()): ?>
                                                            <span class="px-2.5 py-1 text-[10px] rounded-md bg-zinc-200 dark:bg-zinc-700 text-zinc-400 cursor-not-allowed font-semibold">Prev</span>
                                                        <?php else: ?>
                                                            <button type="button"
                                                                wire:click="setNcpPage('<?php echo e($key); ?>', <?php echo e($ncpList->currentPage() - 1); ?>)"
                                                                class="px-2.5 py-1 text-[10px] rounded-md bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-700 font-semibold">
                                                                Prev
                                                            </button>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                                        <span class="px-2.5 py-1 text-[10px] text-zinc-600 dark:text-zinc-400 font-semibold">
                                                            <?php echo e($ncpList->currentPage()); ?> / <?php echo e($ncpList->lastPage()); ?>

                                                        </span>

                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ncpList->hasMorePages()): ?>
                                                            <button type="button"
                                                                wire:click="setNcpPage('<?php echo e($key); ?>', <?php echo e($ncpList->currentPage() + 1); ?>)"
                                                                class="px-2.5 py-1 text-[10px] rounded-md bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-700 font-semibold">
                                                                Next
                                                            </button>
                                                        <?php else: ?>
                                                            <span class="px-2.5 py-1 text-[10px] rounded-md bg-zinc-200 dark:bg-zinc-700 text-zinc-400 cursor-not-allowed font-semibold">Next</span>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="md:col-span-2 lg:col-span-2 rounded-xl border border-sky-200 dark:border-sky-800 bg-gradient-to-br from-sky-50 to-cyan-50 dark:from-sky-900/20 dark:to-cyan-900/10 overflow-hidden shadow-sm">
                            <div class="px-4 py-2.5 bg-gradient-to-r from-sky-500 to-cyan-500 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-white">
                                        <path fill-rule="evenodd" d="M1 5.25A2.25 2.25 0 0 1 3.25 3h13.5A2.25 2.25 0 0 1 19 5.25v9.5A2.25 2.25 0 0 1 16.75 17H3.25A2.25 2.25 0 0 1 1 14.75v-9.5Zm1.5 5.81v3.69c0 .414.336.75.75.75h13.5a.75.75 0 0 0 .75-.75v-2.69l-2.22-2.219a.75.75 0 0 0-1.06 0l-1.91 1.909.47.47a.75.75 0 1 1-1.06 1.06L6.53 8.091a.75.75 0 0 0-1.06 0l-2.97 2.97ZM12 7a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs font-bold text-white uppercase tracking-wide">
                                        <?php echo e($fieldLabels['pictures']); ?>

                                    </span>
                                </div>
                                <?php $pics = is_array($items['pictures'] ?? null) ? $items['pictures'] : []; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($pics) > 0): ?>
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-white/20 text-white text-[10px] font-semibold">
                                        <?php echo e(count($pics)); ?> file
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="p-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($readonly): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($pics) > 0): ?>
                                        <?php $modalId = 'pic-modal-' . $key; ?>
                                        <button type="button"
                                            x-on:click="$dispatch('open-<?php echo e($modalId); ?>')"
                                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 text-sm font-semibold text-white
                                                bg-gradient-to-r from-sky-500 to-cyan-600 hover:from-sky-600 hover:to-cyan-700
                                                rounded-lg shadow-sm hover:shadow-md transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                                <path fill-rule="evenodd" d="M1 5.25A2.25 2.25 0 0 1 3.25 3h13.5A2.25 2.25 0 0 1 19 5.25v9.5A2.25 2.25 0 0 1 16.75 17H3.25A2.25 2.25 0 0 1 1 14.75v-9.5Zm1.5 5.81v3.69c0 .414.336.75.75.75h13.5a.75.75 0 0 0 .75-.75v-2.69l-2.22-2.219a.75.75 0 0 0-1.06 0l-1.91 1.909.47.47a.75.75 0 1 1-1.06 1.06L6.53 8.091a.75.75 0 0 0-1.06 0l-2.97 2.97ZM12 7a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z" clip-rule="evenodd" />
                                            </svg>
                                            Lihat Gambar (<?php echo e(count($pics)); ?>)
                                        </button>

                                        
                                        <div x-data="{ open: false }"
                                            x-on:open-<?php echo e($modalId); ?>.window="open = true"
                                            x-on:keydown.escape.window="open = false"
                                            x-show="open"
                                            x-cloak
                                            class="fixed inset-0 z-[60] flex items-center justify-center p-4">

                                            <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" @click="open = false"></div>

                                            <div class="relative bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[85vh] flex flex-col overflow-hidden">
                                                <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-sky-500 to-cyan-600">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-9 h-9 rounded-lg bg-white/20 border border-white/30 flex items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-white">
                                                                <path fill-rule="evenodd" d="M1 5.25A2.25 2.25 0 0 1 3.25 3h13.5A2.25 2.25 0 0 1 19 5.25v9.5A2.25 2.25 0 0 1 16.75 17H3.25A2.25 2.25 0 0 1 1 14.75v-9.5Zm1.5 5.81v3.69c0 .414.336.75.75.75h13.5a.75.75 0 0 0 .75-.75v-2.69l-2.22-2.219a.75.75 0 0 0-1.06 0l-1.91 1.909.47.47a.75.75 0 1 1-1.06 1.06L6.53 8.091a.75.75 0 0 0-1.06 0l-2.97 2.97ZM12 7a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <div class="text-[10px] text-white/70 uppercase tracking-wider font-semibold">Inspection</div>
                                                            <div class="text-sm font-bold text-white leading-tight">Pictures (<?php echo e(count($pics)); ?>)</div>
                                                        </div>
                                                    </div>
                                                    <button type="button" @click="open = false"
                                                        class="w-8 h-8 rounded-lg bg-white/20 hover:bg-white/30 border border-white/30 flex items-center justify-center text-white transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                                            <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                                        </svg>
                                                    </button>
                                                </div>

                                                <div class="flex-1 overflow-y-auto p-6 bg-zinc-50 dark:bg-zinc-900/50">
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $pics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $pic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                            <a href="<?php echo e(Storage::disk('public')->url($pic)); ?>" target="_blank"
                                                                class="group relative block aspect-square rounded-xl border-2 border-zinc-200 dark:border-zinc-700 overflow-hidden hover:border-sky-400 hover:shadow-xl transition-all bg-white dark:bg-zinc-800">
                                                                <img src="<?php echo e(Storage::disk('public')->url($pic)); ?>"
                                                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors flex items-center justify-center">
                                                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity text-white flex flex-col items-center gap-1">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-7 h-7">
                                                                            <path d="M12.232 4.232a2.5 2.5 0 0 1 3.536 3.536l-1.225 1.224a.75.75 0 0 0 1.061 1.06l1.224-1.224a4 4 0 0 0-5.656-5.656l-3 3a4 4 0 0 0 .225 5.865.75.75 0 0 0 .977-1.138 2.5 2.5 0 0 1-.142-3.667l3-3Z" />
                                                                            <path d="M11.603 7.963a.75.75 0 0 0-.977 1.138 2.5 2.5 0 0 1 .142 3.667l-3 3a2.5 2.5 0 0 1-3.536-3.536l1.225-1.224a.75.75 0 0 0-1.061-1.06l-1.224 1.224a4 4 0 1 0 5.656 5.656l3-3a4 4 0 0 0-.225-5.865Z" />
                                                                        </svg>
                                                                        <span class="text-xs font-semibold">Buka</span>
                                                                    </div>
                                                                </div>
                                                                <div class="absolute top-2 left-2 w-7 h-7 rounded-lg bg-black/60 backdrop-blur-sm border border-white/30 flex items-center justify-center text-white text-xs font-bold">
                                                                    <?php echo e($idx + 1); ?>

                                                                </div>
                                                            </a>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-sm text-zinc-500 italic text-center py-2">Belum ada gambar</div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php else: ?>
                                    
                                    <div class="space-y-3">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($items['pictures']) && is_array($items['pictures']) && count($items['pictures']) > 0): ?>
                                            <div class="flex flex-wrap gap-3 justify-center">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items['pictures']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $pic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                    <?php
                                                        $previewUrl = $pic instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile
                                                            ? $pic->temporaryUrl()
                                                            : Storage::disk('public')->url($pic);
                                                    ?>
                                                    <div class="relative group">
                                                        <div class="w-24 h-24 rounded-lg border-2 border-zinc-200 dark:border-zinc-700 overflow-hidden group-hover:border-sky-400 transition-colors">
                                                            <img src="<?php echo e($previewUrl); ?>" class="w-full h-full object-cover" />
                                                        </div>
                                                        <button type="button"
                                                            wire:click="removePicture('<?php echo e($key); ?>', <?php echo e($idx); ?>)"
                                                            class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-red-500 text-white text-xs flex items-center justify-center shadow-lg hover:bg-red-600 hover:scale-110 transition-all"
                                                            title="Hapus gambar">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                                                <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        <label class="relative flex flex-col items-center justify-center w-full h-32
                                            border-2 border-dashed border-zinc-300 dark:border-zinc-700 rounded-xl
                                            cursor-pointer bg-white dark:bg-zinc-800/30
                                            hover:border-sky-400 hover:bg-sky-50 dark:hover:bg-sky-900/10
                                            transition-all group">
                                            <input type="file"
                                                wire:model="<?php echo e($key); ?>.pictures_new"
                                                multiple
                                                accept="image/*"
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />

                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-zinc-400 group-hover:text-sky-500 transition-colors mb-2">
                                                <path fill-rule="evenodd" d="M11.47 2.47a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 0 1-1.06 1.06l-3.22-3.22V16.5a.75.75 0 0 1-1.5 0V4.81L8.03 8.03a.75.75 0 0 1-1.06-1.06l4.5-4.5ZM3 15.75a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 group-hover:text-sky-600">
                                                Klik atau drag gambar ke sini
                                            </span>
                                            <span class="text-[10px] text-zinc-400 mt-0.5">
                                                PNG, JPG, JPEG (max 5MB)
                                            </span>
                                        </label>

                                        <div wire:loading wire:target="<?php echo e($key); ?>.pictures_new" class="flex items-center justify-center gap-2 text-xs text-sky-600 font-semibold">
                                            <svg class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Uploading...
                                        </div>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ["$key.pictures"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs block text-center"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ["$key.pictures.*"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs block text-center"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="md:col-span-2 lg:col-span-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-gradient-to-br from-zinc-50 to-slate-50 dark:from-zinc-900/50 dark:to-slate-900/30 overflow-hidden shadow-sm">
                            <div class="px-4 py-2.5 bg-gradient-to-r from-zinc-600 to-slate-600 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-white">
                                        <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 0 0 3 3.5v13A1.5 1.5 0 0 0 4.5 18h11a1.5 1.5 0 0 0 1.5-1.5V7.621a1.5 1.5 0 0 0-.44-1.06l-4.12-4.122A1.5 1.5 0 0 0 11.378 2H4.5Zm2.25 8.5a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Zm0 3a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs font-bold text-white uppercase tracking-wide">
                                        <?php echo e($fieldLabels['remarks']); ?>

                                    </span>
                                </div>
                            </div>
                            <div class="p-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($readonly): ?>
                                    <div class="text-sm text-zinc-800 dark:text-zinc-200 whitespace-pre-line">
                                        <?php echo e($items['remarks'] ?? '-'); ?>

                                    </div>
                                <?php else: ?>
                                    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/textarea.blade.php', $__blaze->compiledPath.'/94345100219c384088bc615bcd8fde6c.php'); ?>
<?php $__blaze->pushData(['wire:model' => e($key).'.remarks','rows' => '3','placeholder' => 'Tulis keterangan detail tentang NG...']); ?>
<?php _94345100219c384088bc615bcd8fde6c($__blaze, ['wire:model' => e($key).'.remarks','rows' => '3','placeholder' => 'Tulis keterangan detail tentang NG...'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ["$key.remarks"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs block mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>
</div><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/livewire/qaqc/scan-xray/partials/piece-items-form.blade.php ENDPATH**/ ?>