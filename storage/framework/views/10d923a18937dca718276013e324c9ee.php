<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'key'        => 'second_first_items',
    'label'      => 'Second Piece',
    'items'      => [],
    'readonly'   => false,
    'activeSide' => null,
    'minRows'    => 3,
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
    'key'        => 'second_first_items',
    'label'      => 'Second Piece',
    'items'      => [],
    'readonly'   => false,
    'activeSide' => null,
    'minRows'    => 3,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $pcbLabels = [
        'pcb_a'       => 'PCB A',
        'pcb_b'       => 'PCB B',
        'pcb_c'       => 'PCB C',
        'pcb_circuit' => 'PCB Circuit',
    ];

    $pcbCols = array_keys($pcbLabels);

    $sideMeta = [
        'side_single' => ['label' => 'Side SINGLE', 'class' => 'from-violet-500 to-purple-600'],
        'side_lh'     => ['label' => 'Side LH',     'class' => 'from-blue-500 to-blue-600'],
        'side_rh'     => ['label' => 'Side RH',     'class' => 'from-emerald-500 to-emerald-600'],
    ];

    $statusRunning = $items['status_running'] ?? null;
    $side = $activeSide;
    $meta = $side ? ($sideMeta[$side] ?? null) : null;

    $rowErrors = [];
    if (!$readonly && $side) {
        try { $rowErrors = $this->getGroupRowErrors($key); }
        catch (\Throwable $e) { $rowErrors = []; }
    }

    $emptyRowsCount = 0;
    if (!$readonly && $side) {
        $sideData = $items[$side] ?? [];
        $maxRows = 0;
        foreach ($pcbCols as $c) {
            $maxRows = max($maxRows, count($sideData[$c] ?? []));
        }
        for ($i = 0; $i < $maxRows; $i++) {
            $hasAnyInRow = false;
            foreach ($pcbCols as $c) {
                if (!empty($sideData[$c][$i] ?? null)) $hasAnyInRow = true;
            }
            if (!$hasAnyInRow) $emptyRowsCount++;
        }
    }

    // ============ COLLAPSE STATE ============
    $isOpen      = $openGroups[$key] ?? false;
    $canOpen     = $this->canOpenGroup($key);
    $isCompleted = $this->isGroupCompleted($key);
    $isLocked    = $this->isGroupLocked($key);
?>

<div class="relative rounded-2xl overflow-hidden shadow-lg ring-1 ring-emerald-200/50 dark:ring-emerald-800/50 bg-white dark:bg-zinc-900">

    
    <button
        type="button"
        wire:click="toggleGroup('<?php echo e($key); ?>')"
        <?php if(!$canOpen): ?> disabled <?php endif; ?>
        class="w-full relative px-6 py-4 bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 overflow-hidden text-left transition
            <?php echo e($canOpen ? 'cursor-pointer hover:brightness-110' : 'cursor-not-allowed opacity-75'); ?>">

        <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/10"></div>
        <div class="absolute -right-4 -bottom-10 w-20 h-20 rounded-full bg-white/10"></div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$readonly && $emptyRowsCount > 0 && $isOpen): ?>
            <div class="relative mb-3 px-3 py-2 rounded-lg bg-red-500/95 backdrop-blur border border-red-300 shadow-lg flex items-start gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-white flex-shrink-0 mt-0.5">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>
                <div class="flex-1">
                    <div class="text-xs font-bold text-white">
                        Belum diisi: <?php echo e($emptyRowsCount); ?> row
                    </div>
                    <div class="text-[10px] text-white/90 mt-0.5">
                        Setiap row minimal 1 PCB wajib diisi.
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="relative flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                        <path fill-rule="evenodd" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <div class="text-[10px] text-white/70 uppercase tracking-wider font-semibold flex items-center gap-2">
                        Verification
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isCompleted): ?>
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-emerald-500/40 border border-emerald-300/60 text-[9px] font-bold">
                                ✓ COMPLETED
                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isLocked): ?>
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-zinc-800/50 border border-zinc-300/40 text-[9px] font-bold">
                                🔒 LOCKED
                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="text-base font-bold text-white leading-tight"><?php echo e($label); ?></div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($statusRunning && !$isOpen): ?>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                        <?php echo e($statusRunning); ?>

                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="w-8 h-8 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center transition-transform duration-300
                    <?php echo e($isOpen ? 'rotate-180' : ''); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-white">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
    </button>

    
    <div x-show="$wire.openGroups['<?php echo e($key); ?>']" x-collapse
        class="p-5 space-y-5 bg-gradient-to-b from-white to-zinc-50/50 dark:from-zinc-900 dark:to-zinc-900/50">

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$side || !$meta): ?>
            <div class="rounded-xl border-2 border-dashed border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6 text-center">
                <p class="text-sm font-semibold text-zinc-600 dark:text-zinc-400">Pilih PCB Type dulu untuk menampilkan form scan.</p>
            </div>
        <?php else: ?>
            <?php
                $counts = collect($pcbCols)->map(fn($c) => count($items[$side][$c] ?? []))->max() ?? $minRows;
                $rows   = max($minRows, $counts);
                $filledCount = 0;
                foreach ($pcbCols as $c) {
                    foreach (($items[$side][$c] ?? []) as $v) {
                        if (!empty($v)) $filledCount++;
                    }
                }
            ?>

            <div class="rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 shadow-sm bg-white dark:bg-zinc-900">

                <div class="px-4 py-2.5 bg-gradient-to-r <?php echo e($meta['class']); ?> flex items-center justify-between">
                    <span class="text-sm font-bold text-white tracking-wide"><?php echo e($meta['label']); ?> — Verification</span>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 0; $i < $rows; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <?php
                                    $rowHasContent = false;
                                    foreach ($pcbCols as $c) {
                                        if (!empty($items[$side][$c][$i] ?? null)) { $rowHasContent = true; break; }
                                    }
                                ?>
                                <tr class="border-b border-zinc-100 dark:border-zinc-800 transition-colors
                                    <?php echo e($rowHasContent ? 'bg-white dark:bg-zinc-900' : 'bg-zinc-50/50 dark:bg-zinc-800/20'); ?>

                                    hover:bg-blue-50/60 dark:hover:bg-blue-900/10">

                                    <td class="px-2 py-1 text-center align-middle">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-md
                                            <?php echo e($rowHasContent ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-zinc-100 text-zinc-400 dark:bg-zinc-800 dark:text-zinc-500'); ?>

                                            text-[10px] font-bold">
                                            <?php echo e($i + 1); ?>

                                        </span>
                                    </td>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $pcbCols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <?php
                                            $cellValue = $items[$side][$col][$i] ?? '';
                                            $hasValue  = !empty($cellValue);
                                        ?>
                                        <td class="px-1 py-1">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($readonly): ?>
                                                <span class="px-2 py-1.5 block text-xs font-mono text-zinc-800 dark:text-zinc-200 rounded text-center
                                                    <?php echo e($hasValue ? 'bg-zinc-50 dark:bg-zinc-800/50' : ''); ?>">
                                                    <?php echo e($cellValue ?: '-'); ?>

                                                </span>
                                            <?php else: ?>
                                                <input
                                                    type="text"
                                                    data-pcb-input
                                                    data-group="<?php echo e($key); ?>"
                                                    data-side="<?php echo e($side); ?>"
                                                    data-row="<?php echo e($i); ?>"
                                                    data-col="<?php echo e($col); ?>"
                                                    wire:model.live.debounce.500ms="<?php echo e($key); ?>.<?php echo e($side); ?>.<?php echo e($col); ?>.<?php echo e($i); ?>"
                                                    x-on:keydown.enter.prevent="
                                                        $el.blur();
                                                        const cols = ['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'];
                                                        const curIdx = cols.indexOf('<?php echo e($col); ?>');
                                                        const group = '<?php echo e($key); ?>';
                                                        const side = '<?php echo e($side); ?>';
                                                        let nextRow = <?php echo e($i); ?>;
                                                        let nextCol = curIdx + 1;
                                                        if (nextCol >= cols.length) { nextCol = 0; nextRow = <?php echo e($i); ?> + 1; }
                                                        if (nextRow < <?php echo e($rows); ?>) {
                                                            const next = document.querySelector(
                                                                `input[data-group='${group}'][data-side='${side}'][data-row='${nextRow}'][data-col='${cols[nextCol]}']`
                                                            );
                                                            if (next) next.focus();
                                                        }
                                                    "
                                                    class="w-full border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/50
                                                        px-2 py-1.5 text-xs rounded-md text-center
                                                        hover:border-blue-300 dark:hover:border-blue-700
                                                        focus:border-blue-400 focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-900/40
                                                        transition-all placeholder:text-zinc-300 dark:placeholder:text-zinc-500"
                                                    placeholder="—" />
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$readonly && !empty($rowErrors)): ?>
                    <div class="p-3 bg-red-50 dark:bg-red-950/30 border-t-2 border-red-300 dark:border-red-700">
                        <div class="flex items-start gap-2 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs font-bold text-red-700 dark:text-red-300 uppercase tracking-wide">
                                Perhatian — Data Belum Lengkap
                            </span>
                        </div>
                        <ul class="space-y-1 pl-6">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $rowErrors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <li class="flex items-start gap-1.5 text-xs text-red-700 dark:text-red-300">
                                    <span class="text-red-500 font-bold">•</span>
                                    <span><?php echo e($err); ?></span>
                                </li>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-3 shadow-sm">
            <div class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-2 text-center">Ringkasan</div>

            <div class="grid <?php echo e($readonly ? 'grid-cols-2 md:grid-cols-2' : 'grid-cols-2'); ?> gap-3">

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($readonly): ?>
                    <div class="rounded-lg bg-zinc-50 dark:bg-zinc-800/50 p-3 border border-zinc-100 dark:border-zinc-800 text-center">
                        <div class="text-[10px] text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mb-1">Time Scan</div>
                        <div class="text-sm font-mono font-bold text-zinc-800 dark:text-zinc-200"><?php echo e($items['time_scan'] ?? '-'); ?></div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="rounded-lg bg-gradient-to-br from-cyan-50 to-cyan-100/50 dark:from-cyan-900/20 dark:to-cyan-900/10 p-3 border border-cyan-200 dark:border-cyan-800 text-center">
                    <div class="text-[10px] text-cyan-700 dark:text-cyan-400 uppercase tracking-wider font-semibold mb-1">
                        Status Running <span class="text-red-500">*</span>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($readonly): ?>
                        <div class="text-sm font-bold text-zinc-700 dark:text-zinc-300"><?php echo e($statusRunning ?: '-'); ?></div>
                    <?php else: ?>
                        <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/5ae551d98c08f0bc67bd05455e08306c.php'); ?>
<?php $__blaze->pushData(['type' => 'text','wire:model' => e($key).'.status_running','placeholder' => 'Machine / Others','class' => '!text-center !font-semibold !border-cyan-300 focus:!border-cyan-500']); ?>
<?php _5ae551d98c08f0bc67bd05455e08306c($__blaze, ['type' => 'text','wire:model' => e($key).'.status_running','placeholder' => 'Machine / Others','class' => '!text-center !font-semibold !border-cyan-300 focus:!border-cyan-500'], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
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

    </div>
</div><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/resources/views/livewire/qaqc/scan-xray/partials/second-piece-form.blade.php ENDPATH**/ ?>