<?php # [BlazeFolded]:{flux::badge}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/badge/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::card}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/card/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::toast}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/toast/index.blade.php}:{1774988736} ?>
<div class="space-y-0 p-2" wire:poll.5s="loadDashboardData">
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Header dengan Welcome Back -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-2">
            <div class="w-full lg:w-auto">
                <div class="flex items-center gap-3">
                    <h1 class="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white">MS Dashboard</h1>
                    <?php ob_start(); ?><div data-flux-badge="data-flux-badge" class="inline-flex items-center font-medium whitespace-nowrap  [print-color-adjust:exact] text-xs py-1 **:data-flux-badge-icon:me-1 rounded-md px-2 text-blue-800 [&amp;_button]:text-blue-800! dark:text-blue-200 dark:[&amp;_button]:text-blue-200! bg-blue-400/20 dark:bg-blue-400/40 [&amp;:is(button)]:hover:bg-blue-400/30 dark:[button]:hover:bg-blue-400/50">
        <?php ob_start(); ?>Master Sample Control<?php echo trim(ob_get_clean()); ?>

    </div>
<?php echo ltrim(ob_get_clean()); ?>
                </div>
                <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-400 mt-1">
                    Manage and monitoring your master sample
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-xs font-medium text-zinc-700 dark:text-zinc-300">Show:</span>
            <select 
                wire:model.live="selectedArea"
                class="border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-1.5 text-sm bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            >
                <option value="all">All Productions</option>
                <option value="2">Production 01</option>
                <option value="3">Production 02</option>
            </select>
        </div>
    </div>

    <!-- Status Legend -->
    <div class="flex flex-wrap items-center justify-center gap-3 p-2 bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 my-4">
        <div class="flex items-center gap-3 flex-wrap">
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-green-500"></span>
                <span class="text-xs text-zinc-600 dark:text-zinc-400">OK</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                <span class="text-xs text-zinc-600 dark:text-zinc-400">OK Backup</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                <span class="text-xs text-zinc-600 dark:text-zinc-400">NG</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-gray-400"></span>
                <span class="text-xs text-zinc-600 dark:text-zinc-400">Blank</span>
            </div>
        </div>

        <div class="w-px h-4 bg-zinc-300 dark:bg-zinc-600"></div>

        <div class="flex items-center gap-3">
            <div class="flex items-center gap-1.5">
                <div class="relative w-5 h-5 rounded-full bg-sky-500 flex items-center justify-center">
                    <span class="text-[7px] font-bold text-white">L</span>
                </div>
                <span class="text-xs text-zinc-600 dark:text-zinc-400">In Use</span>
            </div>
            <div class="flex items-center gap-1.5">
                <div class="relative w-5 h-5 rounded-full bg-rose-500 flex items-center justify-center">
                    <span class="text-[7px] font-bold text-white">L</span>
                </div>
                <span class="text-xs text-zinc-600 dark:text-zinc-400">Not Use</span>
            </div>
        </div>
    </div>

    <!-- Dashboard Content - Grouped by AREA -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $filteredAreas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <div class="space-y-3">
            <!-- Area Header -->
            <div class="flex items-center justify-center">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold text-sm px-6 py-2 rounded-lg shadow-md">
                    <?php echo e(strtoupper($area['area_name'])); ?>

                </div>
            </div>

            <!-- Locations Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $area['locations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm p-3 hover:shadow-md transition-all duration-200">
                        <!-- Location Name -->
                        <div class="bg-yellow-100 dark:bg-yellow-900/30 text-center font-semibold text-xs py-1.5 rounded mb-3 text-zinc-800 dark:text-zinc-200">
                            <?php echo e($location['location_name']); ?>

                        </div>

                        <!-- Lines Grid -->
                        <div class="grid grid-cols-3 gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $location['lines']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <?php
                                    $hasSample = $line['has_sample'];
                                    $circleClass = $hasSample 
                                        ? 'bg-blue-600 border-blue-600 text-white' 
                                        : 'bg-rose-600 border-rose-600 text-white';
                                    $types = $line['types'] ?? [];
                                    $areaId = str_contains($area['area_name'], '01') ? 2 : 3;
                                ?>
                                
                                <div 
                                    wire:click="openLineDetail(<?php echo e($line['line_id']); ?>, <?php echo e($areaId); ?>)"
                                    class="relative flex flex-col items-center cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition p-1.5 rounded-lg group"
                                >
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($types) > 0): ?>
                                        <div class="absolute -top-1.5 left-0 right-0 flex justify-center gap-0.5 z-10">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <div class="w-2 h-2 rounded-full <?php echo e($this->getSampleBadgeClass($type)); ?> border border-white shadow-sm" title="<?php echo e($this->getSampleTitle($type)); ?>"></div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <div class="relative w-8 h-8 rounded-full border-2 <?php echo e($circleClass); ?> flex items-center justify-center text-xs font-bold select-none transition-all duration-200 group-hover:scale-105 <?php echo e(count($types) > 0 ? 'mt-1' : ''); ?>">
                                        <?php echo e($line['line_number']); ?>

                                    </div>

                                    <div class="mt-1 text-[9px] font-semibold text-zinc-500 dark:text-zinc-400">
                                        LINE
                                    </div>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$loop->last): ?>
            <div class="border-t border-dashed border-zinc-300 dark:border-zinc-700 my-4"></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        <?php ob_start(); ?><div class="[:where(&amp;)]:bg-white dark:[:where(&amp;)]:bg-white/10 border border-zinc-200 dark:border-white/10 [:where(&amp;)]:p-6 [:where(&amp;)]:rounded-xl p-8 text-center" data-flux-card>
    <?php ob_start(); ?>
            <div class="flex flex-col items-center gap-2">
                <div class="w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                    <svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-md font-semibold text-zinc-800 dark:text-white mb-0.5">
                        No Data Available
                    </h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                        No samples are currently in use
                    </p>
                </div>
            </div>
        <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- MODAL LINE DETAIL -->
    <div x-data="{ open: false }" 
        x-show="open" 
        @open-line-modal.window="open = true"
        @close-line-modal.window="open = false"
        x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-lg max-h-[85vh] overflow-y-auto">
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lineDetail): ?>
                    <div class="space-y-3">
                        <div class="sticky top-0 bg-white dark:bg-zinc-900 px-5 py-3 border-b border-zinc-200 dark:border-zinc-700 flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-md font-bold"><?php echo e($lineDetail['area_name']); ?> - Line Info</h3>
                                    <p class="text-xs text-zinc-500">Line <?php echo e($lineDetail['line_number']); ?> - <?php echo e($lineDetail['location_name']); ?></p>
                                </div>
                            </div>
                            <button @click="open = false; $wire.closeLineModal()" class="text-zinc-500 hover:text-zinc-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="p-5 space-y-4">
                            <!-- Sample Types Badges -->
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($lineDetail['sample_types']) > 0): ?>
                                <div class="flex items-center justify-center gap-2 flex-wrap">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $lineDetail['sample_types']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <div class="flex flex-col items-center">
                                            <div class="w-4 h-4 rounded-full <?php echo e($this->getSampleBadgeClass($type)); ?> mb-0.5"></div>
                                            <span class="text-[10px] text-zinc-600 dark:text-zinc-400"><?php echo e($this->getSampleTitle($type)); ?></span>
                                        </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <!-- Info Model -->
                            <div class="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-md border border-zinc-200 dark:border-zinc-700 space-y-1.5">
                                <div class="flex justify-between text-xs">
                                    <span class="font-semibold text-zinc-600 dark:text-zinc-400">Model:</span>
                                    <span class="text-zinc-800 dark:text-zinc-200 font-mono"><?php echo e($lineDetail['model_name']); ?></span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="font-semibold text-zinc-600 dark:text-zinc-400">Expire Date:</span>
                                    <span class="text-zinc-800 dark:text-zinc-200"><?php echo e($lineDetail['expired_date']); ?></span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="font-semibold text-zinc-600 dark:text-zinc-400">Line Number:</span>
                                    <span class="text-zinc-800 dark:text-zinc-200 font-semibold"><?php echo e($lineDetail['line_number']); ?></span>
                                </div>
                            </div>

                            <!-- Loaners Table (semua yang sedang in use) -->
                            <div class="border border-zinc-200 dark:border-zinc-700 rounded-md overflow-hidden">
                                <div class="bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-semibold text-xs px-3 py-1.5 border-b border-zinc-200 dark:border-zinc-700">
                                    Current Loaners (<?php echo e($lineDetail['total_loaners']); ?>)
                                </div>
                                <div class="max-h-64 overflow-y-auto">
                                    <table class="w-full text-xs">
                                        <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-600 dark:text-zinc-400 sticky top-0">
                                            <tr>
                                                <th class="py-1.5 px-2 border-b text-left">NIK</th>
                                                <th class="py-1.5 px-2 border-b text-left">Employee Name</th>
                                                <th class="py-1.5 px-2 border-b text-left">Loan Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $lineDetail['loaners']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loaner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <tr>
                                                    <td class="py-1.5 px-2 border-b"><?php echo e($loaner['nik']); ?></td>
                                                    <td class="py-1.5 px-2 border-b"><?php echo e($loaner['employee_name']); ?></td>
                                                    <td class="py-1.5 px-2 border-b"><?php echo e($loaner['loan_date']); ?></td>
                                                </tr>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                <tr>
                                                    <td colspan="3" class="text-center py-2 text-zinc-400">No data available</td>
                                                </tr>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-end gap-2 pt-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lineDetail['master_sample_id']): ?>
                                    <a href="<?php echo e(route('prod.ms.master-sample.show', $lineDetail['master_sample_id'])); ?>" 
                                    target="_blank"
                                    class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700 transition-colors">
                                        View Master Sample
                                    </a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loading): ?>
                    <div class="p-8 text-center">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                        <p class="mt-2 text-xs text-zinc-500">Loading...</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    <?php ob_start(); ?><ui-toast x-data x-on:toast-show.document="! $el.closest('ui-toast-group') && $el.showToast($event.detail)" popover="manual" position="bottom end" wire:ignore>
    <template>
        <div class="max-w-sm in-[ui-toast-group]:max-w-auto in-[ui-toast-group]:w-xs sm:in-[ui-toast-group]:w-sm" data-variant="" data-flux-toast-dialog>
            <div class="p-2 flex rounded-xl shadow-lg bg-white border border-zinc-200 border-b-zinc-300/80 dark:bg-zinc-700 dark:border-zinc-600">
                <div class="flex-1 flex items-start gap-4 overflow-hidden">
                    <div class="flex-1 py-1.5 ps-2.5 flex gap-2">
                        
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=success]_&]:block shrink-0 mt-0.5 size-4 text-lime-600 dark:text-lime-400">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z" clip-rule="evenodd" />
                        </svg>

                        
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=warning]_&]:block shrink-0 mt-0.5 size-4 text-amber-500 dark:text-amber-400">
                            <path fill-rule="evenodd" d="M6.701 2.25c.577-1 2.02-1 2.598 0l5.196 9a1.5 1.5 0 0 1-1.299 2.25H2.804a1.5 1.5 0 0 1-1.3-2.25l5.197-9ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 1 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>

                        
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=danger]_&]:block shrink-0 mt-0.5 size-4 text-rose-500 dark:text-rose-400">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>

                        <div>
                            
                            <div class="font-medium text-sm text-zinc-800 dark:text-white [&:not(:empty)+div]:font-normal [&:not(:empty)+div]:text-zinc-500 [&:not(:empty)+div]:dark:text-zinc-300 [&:not(:empty)]:pb-2"><slot name="heading"></slot></div>

                            
                            <div class="font-medium text-sm text-zinc-800 dark:text-white"><slot name="text"></slot></div>
                        </div>
                    </div>

                    
                    <ui-close class="flex items-center">
                        <button type="button" class="inline-flex items-center font-medium justify-center gap-2 truncate disabled:opacity-50 dark:disabled:opacity-75 disabled:cursor-default h-8 text-sm rounded-md w-8 bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-400 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white" as="button">
                            <div>
                                <svg class="[:where(&)]:size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z"></path>
                                </svg>
                            </div>
                        </button>
                    </ui-close>
                </div>
            </div>
        </div>
    </template>
</ui-toast>
<?php echo ltrim(ob_get_clean()); ?>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div><?php /**PATH D:\laragon\www\siix-portal-new\resources\views/livewire/prod/ms/sample/master-sample-dashboard.blade.php ENDPATH**/ ?>