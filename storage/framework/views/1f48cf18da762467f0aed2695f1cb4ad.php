<?php # [BlazeFolded]:{flux::heading}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/breadcrumbs/index.blade.php}:{1774988736} ?>
<div>
    <section class="w-full">
        <?php echo $__env->make('partials.esd-heading', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-sm [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2 sr-only" data-flux-heading><?php ob_start(); ?>
            <?php echo e(__('Electrostatic Discharge - QR Code Printer')); ?>

        <?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>

        <?php if (isset($component)) { $__componentOriginalf744da513101cd09f149c6df9c59a801 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf744da513101cd09f149c6df9c59a801 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.esd.layout','data' => ['class' => '!max-w-full !px-0 !mx-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('esd.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => '!max-w-full !px-0 !mx-0']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

             <?php $__env->slot('heading', null, []); ?> 
                <div class="w-full">
                    <?php ob_start(); ?><div class="flex mb-1" data-flux-breadcrumbs>
    <?php ob_start(); ?>
                        <?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/breadcrumbs/item.blade.php', $__blaze->compiledPath.'/ff33ec4157565e312cea64d93aa61979.php'); ?>
<?php if (isset($__slotsff33ec4157565e312cea64d93aa61979)) { $__slotsStackff33ec4157565e312cea64d93aa61979[] = $__slotsff33ec4157565e312cea64d93aa61979; } ?>
<?php if (isset($__attrsff33ec4157565e312cea64d93aa61979)) { $__attrsStackff33ec4157565e312cea64d93aa61979[] = $__attrsff33ec4157565e312cea64d93aa61979; } ?>
<?php $__attrsff33ec4157565e312cea64d93aa61979 = ['href' => e(route('dashboard')),'wire:navigate' => true,'separator' => 'slash']; ?>
<?php $__slotsff33ec4157565e312cea64d93aa61979 = []; ?>
<?php $__blaze->pushData($__attrsff33ec4157565e312cea64d93aa61979); ?>
<?php ob_start(); ?>
                            Dashboard
                        <?php $__slotsff33ec4157565e312cea64d93aa61979['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsff33ec4157565e312cea64d93aa61979); ?>
<?php _ff33ec4157565e312cea64d93aa61979($__blaze, $__attrsff33ec4157565e312cea64d93aa61979, $__slotsff33ec4157565e312cea64d93aa61979, ['wire:navigate'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackff33ec4157565e312cea64d93aa61979)) { $__slotsff33ec4157565e312cea64d93aa61979 = array_pop($__slotsStackff33ec4157565e312cea64d93aa61979); } ?>
<?php if (! empty($__attrsStackff33ec4157565e312cea64d93aa61979)) { $__attrsff33ec4157565e312cea64d93aa61979 = array_pop($__attrsStackff33ec4157565e312cea64d93aa61979); } ?>
<?php $__blaze->popData(); ?>
                        <?php ob_start(); ?><div class="flex items-center text-sm font-medium group/breadcrumb font-semibold text-blue-600 dark:text-blue-400" data-flux-breadcrumbs-item>
            <div class="text-gray-500 dark:text-white/80">
                            <?php ob_start(); ?>
                            Maintenance
                        <?php echo trim(ob_get_clean()); ?>

                    </div>
    
            <svg class="shrink-0 [:where(&amp;)]:size-5 mx-1 text-zinc-300 dark:text-white/80 group-last/breadcrumb:hidden rtl:-scale-x-100" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M12.528 3.047a.75.75 0 0 1 .449.961L8.433 16.504a.75.75 0 1 1-1.41-.512l4.544-12.496a.75.75 0 0 1 .961-.449Z" clip-rule="evenodd"/>
</svg>

            </div>
<?php echo ltrim(ob_get_clean()); ?>
                        <?php ob_start(); ?><div class="flex items-center text-sm font-medium group/breadcrumb font-semibold text-blue-600 dark:text-blue-400" data-flux-breadcrumbs-item>
            <div class="text-gray-500 dark:text-white/80">
                            <?php ob_start(); ?>
                            ESD
                        <?php echo trim(ob_get_clean()); ?>

                    </div>
    
            <svg class="shrink-0 [:where(&amp;)]:size-5 mx-1 text-zinc-300 dark:text-white/80 group-last/breadcrumb:hidden rtl:-scale-x-100" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M12.528 3.047a.75.75 0 0 1 .449.961L8.433 16.504a.75.75 0 1 1-1.41-.512l4.544-12.496a.75.75 0 0 1 .961-.449Z" clip-rule="evenodd"/>
</svg>

            </div>
<?php echo ltrim(ob_get_clean()); ?>
                        <?php ob_start(); ?><div class="flex items-center text-sm font-medium group/breadcrumb font-semibold text-blue-600 dark:text-blue-400" data-flux-breadcrumbs-item>
            <div class="text-gray-500 dark:text-white/80">
                            <?php ob_start(); ?>
                            QR Code Printer
                        <?php echo trim(ob_get_clean()); ?>

                    </div>
    
            <svg class="shrink-0 [:where(&amp;)]:size-5 mx-1 text-zinc-300 dark:text-white/80 group-last/breadcrumb:hidden rtl:-scale-x-100" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M12.528 3.047a.75.75 0 0 1 .449.961L8.433 16.504a.75.75 0 1 1-1.41-.512l4.544-12.496a.75.75 0 0 1 .961-.449Z" clip-rule="evenodd"/>
</svg>

            </div>
<?php echo ltrim(ob_get_clean()); ?>
                    <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
                </div>
             <?php $__env->endSlot(); ?>
            
             <?php $__env->slot('subheading', null, []); ?> 
                <div class="w-full">
                    <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                        QR Code Printer
                    </h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        Print QR Codes for Multiple ESD Equipment Models
                    </p>
                </div>
             <?php $__env->endSlot(); ?>
            
            <div class="-mt-2">
                <!-- Notifikasi -->
                <div x-data="{ show: false, message: '', type: 'success' }" 
                     x-on:item-added.window="show = true; message = '✓ Item added successfully'; type = 'success'; setTimeout(() => show = false, 3000)"
                     x-on:item-removed.window="show = true; message = '✓ Item removed'; type = 'success'; setTimeout(() => show = false, 3000)"
                     x-on:items-cleared.window="show = true; message = '✓ All items cleared'; type = 'warning'; setTimeout(() => show = false, 3000)"
                     x-show="show"
                     x-transition.duration.300ms
                     class="fixed top-20 right-4 z-50 px-4 py-3 rounded-lg shadow-lg"
                     :class="{
                         'bg-green-500': type === 'success',
                         'bg-yellow-500': type === 'warning',
                         'bg-red-500': type === 'error'
                     }"
                     style="display: none;">
                    <div class="flex items-center gap-2 text-white">
                        <span x-text="message"></span>
                    </div>
                </div>

                <!-- QR Printer Section -->
                <div class="mb-6">
                    <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700 shadow-sm">
                        <h3 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                            Generate QR Codes
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                    Select Model <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select wire:model.live="selectedModel" 
                                            class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white appearance-none"
                                            style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2216%22%20height%3D%2216%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%23666%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E'); 
                                                background-repeat: no-repeat; 
                                                background-position: right 1rem center; 
                                                background-size: 1rem;">
                                        <option value="">-- Choose Model --</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $modelLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Search Input -->
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Search Register No</label>
                                <input type="text" 
                                       wire:model.live.debounce.500ms="searchTerm" 
                                       placeholder="Type register number to search..." 
                                       class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white"
                                       <?php echo e(empty($selectedModel) ? 'disabled' : ''); ?>>
                            </div>
                        </div>
                        
                        <!-- Search Results -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($selectedModel) && !empty($searchTerm)): ?>
                            <div class="mt-4 border rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700/30">
                                <h4 class="font-semibold mb-2 text-zinc-700 dark:text-zinc-300">Search Results:</h4>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($searchResults->count() > 0): ?>
                                    <div class="space-y-2 max-h-64 overflow-y-auto">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $searchResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <div class="flex justify-between items-center p-2 hover:bg-white dark:hover:bg-zinc-700 rounded transition-colors">
                                                <div>
                                                    <span class="text-gray-800 dark:text-white font-medium"><?php echo e($result['register_no']); ?></span>
                                                </div>
                                                <button wire:click="addItem(<?php echo e($result['id']); ?>, '<?php echo e($result['register_no']); ?>')"
                                                        class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition-colors text-sm">
                                                    Add
                                                </button>
                                            </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text-gray-500 dark:text-gray-400 text-center py-4">
                                        No results found for "<?php echo e($searchTerm); ?>"
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                
                <!-- Selected Items -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($selectedItems) > 0): ?>
                    <div class="mb-6">
                        <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700 shadow-sm">
                            <div class="flex justify-between items-center mb-4 flex-wrap gap-3">
                                <h3 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Selected Items (<?php echo e(count($selectedItems)); ?>)
                                </h3>
                                <div class="flex gap-2">
                                    <button wire:click="clearAll" 
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Clear All
                                    </button>
                                </div>
                            </div>
                            
                            <div class="border rounded-lg p-3 max-h-48 overflow-y-auto bg-zinc-50 dark:bg-zinc-700/30">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $selectedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="flex justify-between items-center p-2 border-b last:border-b-0 dark:border-zinc-600">
                                        <div>
                                            <span class="font-medium text-gray-800 dark:text-white"><?php echo e($item['register_no']); ?></span>
                                            <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">(<?php echo e($modelLabels[$item['model']]); ?>)</span>
                                        </div>
                                        <button wire:click="removeItem(<?php echo e($index); ?>)" 
                                                class="text-red-500 hover:text-red-700 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Preview Area QR Code - Format Sesuai Gambar -->
                    <div class="mb-6" id="print-area">
                        <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700 shadow-sm">
                            <div class="flex justify-between items-center mb-4 flex-wrap gap-3">
                                <h3 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Preview - QR Codes
                                </h3>
                                <button wire:click="exportPDF" 
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Download PDF
                                </button>
                            </div>
                            
                            <!-- QR Code Cards - Format: TEXT | LOGO | QR -->
                            <div id="qr-codes-container" class="flex flex-wrap gap-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $selectedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <?php
                                        // Tentukan ukuran berdasarkan model (tinggi semua 45px)
                                        $isGroundMonitor = ($item['model'] == 'ground_monitor_box');
                                        
                                        if ($isGroundMonitor) {
                                            $cardWidth = 'w-[178px]';
                                            $logoWidth = 'w-[48px]';
                                            $qrWidth = 'w-[40px]';
                                            $textWidth = 'w-[99px]';
                                            $fontSize = 'text-[8px]';
                                            $qrImageSize = 'w-8 h-7';
                                            $textPadding = 'px-1';
                                        } else {
                                            $cardWidth = 'w-[240px]';
                                            $logoWidth = 'w-[55px]';
                                            $qrWidth = 'w-[55px]';
                                            $textWidth = 'flex-1';
                                            $fontSize = 'text-[12px]';
                                            $qrImageSize = 'w-8 h-7';
                                            $textPadding = 'px-2';
                                        }
                                    ?>
                                    
                                    <div class="qr-card border border-black bg-white">
                                        <div class="flex items-center h-[45px] <?php echo e($cardWidth); ?>">
                                            
                                            <!-- LEFT: TEXT -->
                                            <div class="<?php echo e($textWidth); ?> flex items-center justify-start <?php echo e($textPadding); ?> overflow-hidden">
                                                <div class="<?php echo e($fontSize); ?> font-semibold text-black uppercase tracking-wide leading-tight text-left truncate w-full">
                                                    <?php echo e($item['register_no']); ?>

                                                </div>
                                            </div>
                                            
                                            <!-- MIDDLE: LOGO -->
                                            <div class="bg-yellow-400 flex items-center justify-center <?php echo e($logoWidth); ?> h-full overflow-hidden p-0 flex-shrink-0">
                                                <img src="<?php echo e(asset('images/esd-safe.png')); ?>" 
                                                    alt="ESD Logo" 
                                                    class="w-full h-full object-contain block">
                                            </div>
                                            
                                            <!-- RIGHT: QR -->
                                            <div class="flex items-center justify-center <?php echo e($qrWidth); ?> h-full flex-shrink-0">
                                                <img src="https://quickchart.io/qr?text=<?php echo e(urlencode($item['register_no'])); ?>&size=120&margin=0" 
                                                    class="<?php echo e($qrImageSize); ?>"
                                                    alt="QR Code">
                                            </div>

                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <!-- Empty State -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($selectedItems) == 0): ?>
                    <div class="bg-white dark:bg-zinc-800 rounded-xl p-12 border border-zinc-200 dark:border-zinc-700 shadow-sm text-center">
                        <div class="w-24 h-24 mx-auto mb-4 bg-zinc-100 dark:bg-zinc-700 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-zinc-800 dark:text-white mb-2">No QR Codes Selected</h3>
                        <p class="text-zinc-500 dark:text-zinc-400">
                            Select a model, search for register numbers, and add them to generate QR codes.
                        </p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf744da513101cd09f149c6df9c59a801)): ?>
<?php $attributes = $__attributesOriginalf744da513101cd09f149c6df9c59a801; ?>
<?php unset($__attributesOriginalf744da513101cd09f149c6df9c59a801); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf744da513101cd09f149c6df9c59a801)): ?>
<?php $component = $__componentOriginalf744da513101cd09f149c6df9c59a801; ?>
<?php unset($__componentOriginalf744da513101cd09f149c6df9c59a801); ?>
<?php endif; ?>
    </section>
</div>

<?php $__env->startPush('styles'); ?>
<style>
[x-cloak] { display: none !important; }

/* QR Card Styles */
.qr-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.qr-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

/* Scrollbar Styling */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Print Styles */
@media print {
    .qr-card {
        break-inside: avoid;
        page-break-inside: avoid;
        border: 1px solid black !important;
    }
    
    .qr-card .bg-yellow-400 {
        background-color: #facc15 !important;
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }
    
    button, .bg-blue-50, .border-blue-200 {
        display: none !important;
    }
}
</style>
<?php $__env->stopPush(); ?><?php /**PATH D:\laragon\www\siix-portal-new\resources\views\livewire\esd\print\multi-model-qr-printer.blade.php ENDPATH**/ ?>