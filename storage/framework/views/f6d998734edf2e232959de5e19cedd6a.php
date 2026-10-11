<?php # [BlazeFolded]:{flux::input}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/input/index.blade.php}:{1776934808} ?>
<?php
    $ncpList = $this->getNcpList();
?>

<div x-data="{ open: false }"
    x-on:open-modal-ncp.window="open = true"
    x-on:close-modal-ncp.window="open = false"
    x-show="open" x-cloak
    @keydown.escape.window="open = false">

    <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-4xl max-h-[85vh] flex flex-col">

            
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-zinc-800 dark:text-white">Select NCP</h2>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Pilih NCP untuk grup ini</p>
                </div>
                <button type="button" @click="open = false"
                    class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                    </svg>
                </button>
            </div>

            
            <div class="px-6 py-3 border-b border-zinc-200 dark:border-zinc-700">
                <?php ob_start(); ?><div class="w-full relative block group/input" data-flux-input>
                            <div class="pointer-events-none absolute top-0 bottom-0 border-s border-transparent flex items-center justify-center text-xs text-zinc-400/75 dark:text-white/60 ps-3 start-0">
                    <svg class="shrink-0 [:where(&amp;)]:size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd"/>
</svg>

                        </div>
            
            <input
                type="text"
                
                class="w-full border rounded-lg block disabled:shadow-none dark:shadow-none appearance-none text-base sm:text-sm py-2 h-10 leading-[1.375rem] ps-10 pe-10 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500 shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5 data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500 disabled:data-invalid:border-red-500 dark:disabled:data-invalid:border-red-500" wire:model.live.debounce.300ms="ncpSearch" placeholder="Cari NCP number / part number / customer / model..."
                 name="ncpSearch"                                                 <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => 'ncpSearch',
  'invalid' => false,
); ?>
                <?php if ($scope['invalid'] || ($scope['name'] && $errors->has($scope['name']))): ?>
                aria-invalid="true" data-invalid
                <?php endif; ?>
                <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
                data-flux-control
                data-flux-group-target
                 wire:loading.class="pe-16"                  wire:target="ncpSearch"             >

                            <div class="absolute top-0 bottom-0 flex items-center gap-x-1.5 pe-2 border-e border-transparent end-0 text-xs text-zinc-400">
                    
                                            <svg class="shrink-0 [:where(&amp;)]:size-5 animate-spin" wire:loading="" wire:target="ncpSearch" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                            
                                            <button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-8 text-sm rounded-md w-8 inline-flex -ms-1.5 -me-1.5 bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white      -me-1 [[data-flux-input]:has(input:placeholder-shown)_&amp;]:hidden [[data-flux-input]:has(input[disabled])_&amp;]:hidden" data-flux-button="data-flux-button" x-data="fluxInputClearable" x-on:click="clear()" tabindex="-1" aria-label="Clear input" data-flux-clear-button="data-flux-clear-button">
        <svg class="shrink-0 [:where(&amp;)]:size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z"/>
</svg>
    </button>
                    
                    
                    
                    
                    
                                    </div>
                    </div>
<?php echo ltrim(ob_get_clean()); ?>
            </div>

            
            <div class="flex-1 overflow-auto">
                <table class="w-full text-sm">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50 sticky top-0">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-zinc-500 uppercase">NCP Number</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-zinc-500 uppercase">Part Number</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-zinc-500 uppercase">Customer</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-zinc-500 uppercase">Model</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-zinc-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-zinc-500 uppercase w-24">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_3 = true; $__currentLoopData = $ncpList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ncp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30">
                                <td class="px-4 py-2 font-mono text-xs text-zinc-800 dark:text-zinc-200"><?php echo e($ncp->ncp_number); ?></td>
                                <td class="px-4 py-2 text-xs text-zinc-600 dark:text-zinc-400"><?php echo e($ncp->part_number ?? '-'); ?></td>
                                <td class="px-4 py-2 text-xs text-zinc-600 dark:text-zinc-400"><?php echo e($ncp->customer ?? '-'); ?></td>
                                <td class="px-4 py-2 text-xs text-zinc-600 dark:text-zinc-400"><?php echo e($ncp->model_affected ?? '-'); ?></td>
                                <td class="px-4 py-2 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold
                                        <?php echo e($ncp->getStatusBadgeColor() === 'green' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : ''); ?>

                                        <?php echo e($ncp->getStatusBadgeColor() === 'yellow' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' : ''); ?>

                                        <?php echo e($ncp->getStatusBadgeColor() === 'blue' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : ''); ?>

                                        <?php echo e($ncp->getStatusBadgeColor() === 'red' ? 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300' : ''); ?>

                                        <?php echo e($ncp->getStatusBadgeColor() === 'gray' ? 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300' : ''); ?>">
                                        <?php echo e($ncp->getStatusText()); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <button type="button"
                                        wire:click="selectNcp(<?php echo e($ncp->id); ?>)"
                                        class="px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-zinc-500 text-sm">
                                    No NCP found
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <div class="px-6 py-3 border-t border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                <div class="text-xs text-zinc-500">
                    Showing <?php echo e($ncpList->firstItem() ?? 0); ?> - <?php echo e($ncpList->lastItem() ?? 0); ?>

                    of <?php echo e($ncpList->total()); ?>

                </div>
                <div class="flex items-center gap-2">
                    <?php echo e($ncpList->links()); ?>

                </div>
            </div>

            
            <div class="px-6 py-3 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-2">
                <button type="button" wire:click="clearNcp"
                    class="px-4 py-2 text-sm border border-zinc-300 dark:border-zinc-700 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800">
                    Clear NCP
                </button>
                <button type="button" @click="open = false"
                    class="px-4 py-2 text-sm bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-700">
                    Close
                </button>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\siix-portal\resources\views\livewire\qaqc\scan-xray\partials\ncp-picker-modal.blade.php ENDPATH**/ ?>