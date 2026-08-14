<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs}:{/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/index.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::card}:{/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php}:{1776985208} ?>
<div class="p-1 space-y-2">
    <?php $__env->startSection('title', 'Cek Status - ESD System'); ?>
    
    <!-- Breadcrumbs -->
    <?php ob_start(); ?><div class="flex" data-flux-breadcrumbs>
    <?php ob_start(); ?>
        <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php', $__blaze->compiledPath.'/028777b3eb06dbd0c29b11890d068895.php'); ?>
<?php if (isset($__slots028777b3eb06dbd0c29b11890d068895)) { $__slotsStack028777b3eb06dbd0c29b11890d068895[] = $__slots028777b3eb06dbd0c29b11890d068895; } ?>
<?php if (isset($__attrs028777b3eb06dbd0c29b11890d068895)) { $__attrsStack028777b3eb06dbd0c29b11890d068895[] = $__attrs028777b3eb06dbd0c29b11890d068895; } ?>
<?php $__attrs028777b3eb06dbd0c29b11890d068895 = ['href' => e(route('dashboard')),'wire:navigate' => true,'separator' => 'slash']; ?>
<?php $__slots028777b3eb06dbd0c29b11890d068895 = []; ?>
<?php $__blaze->pushData($__attrs028777b3eb06dbd0c29b11890d068895); ?>
<?php ob_start(); ?>
            Dashboard
        <?php $__slots028777b3eb06dbd0c29b11890d068895['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots028777b3eb06dbd0c29b11890d068895); ?>
<?php _028777b3eb06dbd0c29b11890d068895($__blaze, $__attrs028777b3eb06dbd0c29b11890d068895, $__slots028777b3eb06dbd0c29b11890d068895, ['wire:navigate'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack028777b3eb06dbd0c29b11890d068895)) { $__slots028777b3eb06dbd0c29b11890d068895 = array_pop($__slotsStack028777b3eb06dbd0c29b11890d068895); } ?>
<?php if (! empty($__attrsStack028777b3eb06dbd0c29b11890d068895)) { $__attrs028777b3eb06dbd0c29b11890d068895 = array_pop($__attrsStack028777b3eb06dbd0c29b11890d068895); } ?>
<?php $__blaze->popData(); ?>
        <?php ob_start(); ?><div class="flex items-center text-sm font-medium group/breadcrumb font-semibold text-blue-600 dark:text-blue-400" data-flux-breadcrumbs-item>
            <div class="text-gray-500 dark:text-white/80">
                            <?php ob_start(); ?>
            ESD
        <?php echo trim(ob_get_clean()); ?>

                    </div>
    
    <!--[if BLOCK]><![endif]-->        <svg class="shrink-0 [:where(&amp;)]:size-5 mx-1 text-zinc-300 dark:text-white/80 group-last/breadcrumb:hidden rtl:-scale-x-100" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M12.528 3.047a.75.75 0 0 1 .449.961L8.433 16.504a.75.75 0 1 1-1.41-.512l4.544-12.496a.75.75 0 0 1 .961-.449Z" clip-rule="evenodd"/>
</svg>

            <!--[if ENDBLOCK]><![endif]--></div>
<?php echo ltrim(ob_get_clean()); ?>
        <?php ob_start(); ?><div class="flex items-center text-sm font-medium group/breadcrumb font-semibold text-blue-600 dark:text-blue-400" data-flux-breadcrumbs-item>
            <div class="text-gray-500 dark:text-white/80">
                            <?php ob_start(); ?>
            Cek Status
        <?php echo trim(ob_get_clean()); ?>

                    </div>
    
    <!--[if BLOCK]><![endif]-->        <svg class="shrink-0 [:where(&amp;)]:size-5 mx-1 text-zinc-300 dark:text-white/80 group-last/breadcrumb:hidden rtl:-scale-x-100" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M12.528 3.047a.75.75 0 0 1 .449.961L8.433 16.504a.75.75 0 1 1-1.41-.512l4.544-12.496a.75.75 0 0 1 .961-.449Z" clip-rule="evenodd"/>
</svg>

            <!--[if ENDBLOCK]><![endif]--></div>
<?php echo ltrim(ob_get_clean()); ?>
    <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                📊 Cek Status Transaksi
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Lihat riwayat transaksi seragam Anda
            </p>
        </div>
    </div>

    <!-- Content -->
    <?php ob_start(); ?><div class="[:where(&amp;)]:bg-white dark:[:where(&amp;)]:bg-white/10 border border-zinc-200 dark:border-white/10 [:where(&amp;)]:p-6 [:where(&amp;)]:rounded-xl p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300" data-flux-card>
    <?php ob_start(); ?>
        <!-- Form Cek NIK -->
        <div class="space-y-4 mb-6">
            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">NIK</label>
                    <input type="text" 
                           wire:model="nik" 
                           wire:keydown.enter="checkStatus"
                           class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:text-white"
                           placeholder="Masukkan NIK Anda">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                        <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> 
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="flex items-end">
                    <button wire:click="checkStatus" 
                            wire:loading.attr="disabled"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                        <span wire:loading.remove>Cek Status</span>
                        <span wire:loading>⏳</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Hasil -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($employee): ?>
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-blue-800 dark:text-blue-300">Data Karyawan</h3>
                <div class="grid grid-cols-2 gap-2 mt-2 text-zinc-700 dark:text-zinc-300">
                    <p><span class="font-medium">NIK:</span> <?php echo e($employee->nik); ?></p>
                    <p><span class="font-medium">Nama:</span> <?php echo e($employee->name); ?></p>
                    <p><span class="font-medium">Departemen:</span> <?php echo e($employee->department); ?></p>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Daftar Transaksi -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($transactions) > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Loker</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Jenis</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Kode Akses</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                                    <?php echo e($transaction->created_at->format('d/m/Y H:i')); ?>

                                </td>
                                <td class="px-4 py-3 text-sm font-mono font-bold">
                                    <?php echo e($transaction->locker->code); ?>

                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($transaction->type == 'store'): ?>
                                        <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded text-xs">Menyimpan</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded text-xs">Mengambil</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="px-4 py-3">
                                    <?php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300',
                                            'on_progress' => 'bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300',
                                            'completed' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300',
                                            'waiting_pickup' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300'
                                        ];
                                    ?>
                                    <span class="px-2 py-1 rounded text-xs <?php echo e($statusColors[$transaction->status] ?? 'bg-gray-100 text-gray-800'); ?>">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $transaction->status))); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm font-mono">
                                    <?php echo e($transaction->access_code); ?>

                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif($employee): ?>
            <div class="text-center py-8 text-zinc-500 dark:text-zinc-400">
                <p>Tidak ada transaksi untuk karyawan ini</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
</div><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/resources/views/livewire/esd/locker/user-status.blade.php ENDPATH**/ ?>