<div class="p-4 space-y-4">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">Manage Rack</h1>
            <p class="text-sm text-zinc-500">Tambah, edit, atau hapus rack, sheet, dan column</p>
        </div>
        <a href="<?php echo e(route('prod.rack-lose')); ?>" wire:navigate 
           class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
            ← Kembali ke Daftar Rack
        </a>
    </div>

    <!-- 3 Card Utama -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Card 1: Tambah Rack Baru -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md p-5 border-t-4 border-blue-500">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-white">Tambah Rack Baru</h2>
            </div>
            
            <div class="space-y-3">
                <input type="text" wire:model="newRackNo" placeholder="Nomor Rack (contoh: RACK-001)"
                    class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-xs text-zinc-600">Jumlah Sheet</label>
                        <input type="number" wire:model="newRackSheetCount" min="1" max="20" 
                            class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                    </div>
                    <div>
                        <label class="text-xs text-zinc-600">Column per Sheet</label>
                        <input type="number" wire:model="newRackColumnCount" min="1" max="4" 
                            class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                    </div>
                </div>
                
                <button wire:click="addRack" 
                    class="w-full mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    + Tambah Rack
                </button>
            </div>
        </div>
        
        <!-- Card 2: Tambah Sheet ke Rack -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md p-5 border-t-4 border-green-500">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-white">Tambah Sheet</h2>
            </div>
            
            <div class="space-y-3">
                <select wire:model="selectedRackForAddSheet" 
                        class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="">Pilih Rack</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $availableRacksForAddSheet; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rack): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($rack->no_rack); ?>"><?php echo e($rack->no_rack); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
                
                <input type="text" wire:model="newSheetName" placeholder="Nama Sheet Baru (contoh: SHEET 6)"
                    class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                
                <button wire:click="openAddSheetModal" 
                    <?php if(!$selectedRackForAddSheet || !$newSheetName): ?> disabled <?php endif; ?>
                    class="w-full mt-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 transition">
                    + Tambah Sheet
                </button>
            </div>
        </div>
        
        <!-- Card 3: Tambah Column ke Sheet -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md p-5 border-t-4 border-purple-500">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-white">Tambah Column</h2>
            </div>
            
            <div class="space-y-3">
                <select wire:model.live="selectedRackForAddColumn" 
                        class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="">Pilih Rack</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $availableRacksForAddColumn; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rack): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($rack->no_rack); ?>"><?php echo e($rack->no_rack); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedRackForAddColumn): ?>
                <select wire:model="selectedSheetForAddColumn" 
                        class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="">Pilih Sheet</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $availableSheetsForAddColumn; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sheet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($sheet->sheet_rack); ?>"><?php echo e($sheet->sheet_rack); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedSheetForAddColumn): ?>
                <input type="text" wire:model="newColumnName" placeholder="Nama Column Baru (contoh: COLUMN 5)"
                    class="w-full px-4 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <button wire:click="openAddColumnModal" 
                    <?php if(!$selectedSheetForAddColumn || !$newColumnName): ?> disabled <?php endif; ?>
                    class="w-full mt-3 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 disabled:opacity-50 transition">
                    + Tambah Column
                </button>
            </div>
        </div>
    </div>
    
    <!-- Card 4: Hapus Slot (Full Width) -->
    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md p-5 border-t-4 border-red-500">
        <div class="flex items-center gap-3 mb-4">
            <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-lg">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <h2 class="text-lg font-semibold text-zinc-800 dark:text-white">Hapus Column</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="text-sm font-medium mb-1 block">Pilih Rack</label>
                <select wire:model.live="selectedRackNo" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Pilih Rack</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $availableRacksForDelete; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rack): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($rack->no_rack); ?>">
                            <?php echo e($rack->no_rack); ?> (<?php echo e($rack->available_slots); ?> slot tersedia)
                        </option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedRackNo): ?>
            <div>
                <label class="text-sm font-medium mb-1 block">Pilih Sheet</label>
                <select wire:model.live="selectedSheetForDelete" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Pilih Sheet</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $availableSlotsForDelete->groupBy('sheet_rack'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sheetName => $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($sheetName); ?>">
                            <?php echo e($sheetName); ?> (<?php echo e($slots->count()); ?> column)
                        </option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedSheetForDelete): ?>
            <div>
                <label class="text-sm font-medium mb-1 block">Pilih Column</label>
                <div class="flex gap-2 mb-2">
                    <button type="button" wire:click="selectAllColumnsInSheet" class="text-xs text-blue-600">Pilih Semua</button>
                    <button type="button" wire:click="clearSelectedColumns" class="text-xs text-red-600">Reset</button>
                </div>
                <div class="grid grid-cols-2 gap-2 p-2 border rounded-lg max-h-32 overflow-y-auto">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $availableSlotsForDelete->where('sheet_rack', $selectedSheetForDelete); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" wire:model.live="selectedColumnsForDelete" value="<?php echo e($slot->id); ?>">
                        <span class="text-sm"><?php echo e($slot->column_rack); ?></span>
                    </label>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedSheetForDelete): ?>
        <button wire:click="deleteColumns" wire:confirm="Yakin ingin menghapus <?php echo e(count($selectedColumnsForDelete)); ?> column?"
                class="mt-4 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
            Hapus <?php echo e(count($selectedColumnsForDelete)); ?> Column
        </button>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    
    <!-- Alerts -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showSuccessAlert): ?>
    <div class="fixed bottom-4 right-4 z-50 animate-fade-in">
        <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <?php echo e($successMessage); ?>

        </div>
    </div>
    <script>setTimeout(() => { window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('showSuccessAlert', false); }, 3000);</script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showErrorAlert): ?>
    <div class="fixed bottom-4 right-4 z-50 animate-fade-in">
        <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <?php echo e($errorMessage); ?>

        </div>
    </div>
    <script>setTimeout(() => { window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('showErrorAlert', false); }, 3000);</script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<style>
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/resources/views/livewire/prod/wip/manage-rack.blade.php ENDPATH**/ ?>