<?php $__env->startSection('title', 'Leader Panel - NG Box Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">🔒 NG Box Management</h2>
    </div>
    <p class="text-gray-600 mt-2">Manage locked PCBs and unlock system</p>
</div>

<!-- Tab Navigation -->
<div class="mb-6 border-b border-gray-200">
    <nav class="flex space-x-8" aria-label="Tabs">
        <button onclick="switchTab('all')" 
                id="tab-all"
                class="py-2 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600">
            All PCBs
        </button>
        <button onclick="switchTab('ng')" 
                id="tab-ng"
                class="py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
            NG Boxes (<?php echo e($ngBoxes->total()); ?>)
        </button>
        <button onclick="switchTab('progress')" 
                id="tab-progress"
                class="py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
            In Progress (<?php echo e($inProgressPcbs->total()); ?>)
        </button>
        <button onclick="switchTab('completed')" 
                id="tab-completed"
                class="py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
            Completed (<?php echo e($completedPcbs->total()); ?>)
        </button>
    </nav>
</div>

<!-- Tabel All PCBs -->
<div id="tab-all-content" class="tab-content">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-sm font-semibold text-gray-700">📋 All PCBs</h3>
            <span class="text-xs text-gray-500">Showing <?php echo e($allPcbs->firstItem() ?? 0); ?> - <?php echo e($allPcbs->lastItem() ?? 0); ?> of <?php echo e($allPcbs->total() ?? 0); ?></span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Process</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Scan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $allPcbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pcb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($loop->iteration + (($allPcbs->currentPage() - 1) * $allPcbs->perPage())); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-medium text-gray-900"><?php echo e($pcb->serial_number); ?></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php
                                $statusColors = [
                                    'pending' => 'bg-gray-100 text-gray-800',
                                    'in_progress' => 'bg-yellow-100 text-yellow-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'blocked' => 'bg-red-100 text-red-800',
                                    'ng' => 'bg-red-100 text-red-800'
                                ];
                            ?>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($statusColors[$pcb->status] ?? 'bg-gray-100 text-gray-800'); ?>">
                                <?php echo e(ucfirst(str_replace('_', ' ', $pcb->status))); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pcb->current_process): ?>
                                <?php echo e(strtoupper(str_replace('_', ' ', $pcb->current_process))); ?>

                            <?php else: ?>
                                <span class="text-gray-400">-</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <div class="flex space-x-1">
                                    <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs <?php echo e($pcb->fct_completed ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400'); ?>">
                                        F
                                    </span>
                                    <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs <?php echo e($pcb->led_test_completed ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400'); ?>">
                                        L
                                    </span>
                                    <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs <?php echo e($pcb->visual_inspection_completed ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400'); ?>">
                                        V
                                    </span>
                                </div>
                                <span class="text-xs text-gray-500">
                                    <?php echo e(($pcb->fct_completed ? 1 : 0) + ($pcb->led_test_completed ? 1 : 0) + ($pcb->visual_inspection_completed ? 1 : 0)); ?>/3
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($pcb->updated_at ? $pcb->updated_at->diffForHumans() : '-'); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pcb->status === 'blocked' || $pcb->status === 'ng'): ?>
                                <?php
                                    $ngBox = $pcb->ngBoxes()->where('is_locked', true)->first();
                                ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ngBox): ?>
                                <a href="<?php echo e(route('pcb-scan.leader.unlock.form', $ngBox->id)); ?>" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition duration-200">
                                    Unlock
                                </a>
                                <?php else: ?>
                                <span class="text-gray-400 text-xs">Locked</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php else: ?>
                                <span class="text-gray-400 text-xs">-</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                            <div class="text-4xl mb-2">📦</div>
                            <p>No PCBs found</p>
                        </td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($allPcbs->links()); ?>

        </div>
    </div>
</div>

<!-- Tabel NG Boxes (HANYA PCB yang BLOCKED) -->
<div id="tab-ng-content" class="tab-content hidden">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-sm font-semibold text-gray-700">🔴 NG Boxes (Blocked PCBs)</h3>
            <span class="text-xs text-gray-500">Showing <?php echo e($ngBoxes->firstItem() ?? 0); ?> - <?php echo e($ngBoxes->lastItem() ?? 0); ?> of <?php echo e($ngBoxes->total() ?? 0); ?></span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Blocked Process</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Locked Since</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unlock Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $ngBoxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $box): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($loop->iteration + (($ngBoxes->currentPage() - 1) * $ngBoxes->perPage())); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-medium text-gray-900"><?php echo e($box->serial_number); ?></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                <?php echo e(strtoupper(str_replace('_', ' ', $box->blocked_at_process))); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <div class="flex space-x-1">
                                    <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs <?php echo e($box->pcb && $box->pcb->fct_completed ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400'); ?>">
                                        F
                                    </span>
                                    <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs <?php echo e($box->pcb && $box->pcb->led_test_completed ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400'); ?>">
                                        L
                                    </span>
                                    <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs <?php echo e($box->pcb && $box->pcb->visual_inspection_completed ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400'); ?>">
                                        V
                                    </span>
                                </div>
                                <span class="text-xs text-gray-500">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($box->pcb): ?>
                                        <?php echo e(($box->pcb->fct_completed ? 1 : 0) + ($box->pcb->led_test_completed ? 1 : 0) + ($box->pcb->visual_inspection_completed ? 1 : 0)); ?>/3
                                    <?php else: ?>
                                        0/3
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($box->created_at->format('d M Y H:i:s')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($box->created_at->diffForHumans()); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-blue-600">
                            <?php echo e($box->unlock_code); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="<?php echo e(route('pcb-scan.leader.unlock.form', $box->id)); ?>" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition duration-200">
                                Unlock
                            </a>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                            <div class="text-4xl mb-2">🔓</div>
                            <p>No locked boxes</p>
                        </td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($ngBoxes->links()); ?>

        </div>
    </div>
</div>

<!-- Tabel In Progress (HANYA yang BLUM LENGKAP / status in_progress) -->
<div id="tab-progress-content" class="tab-content hidden">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-sm font-semibold text-gray-700">⏳ In Progress (Not Complete)</h3>
            <span class="text-xs text-gray-500">Showing <?php echo e($inProgressPcbs->firstItem() ?? 0); ?> - <?php echo e($inProgressPcbs->lastItem() ?? 0); ?> of <?php echo e($inProgressPcbs->total() ?? 0); ?></span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Step</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Activity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Next Step</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $inProgressPcbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pcb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($loop->iteration + (($inProgressPcbs->currentPage() - 1) * $inProgressPcbs->perPage())); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-medium text-gray-900"><?php echo e($pcb->serial_number); ?></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                <?php echo e($pcb->current_process ? strtoupper(str_replace('_', ' ', $pcb->current_process)) : 'Pending'); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <div class="flex space-x-1">
                                    <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs <?php echo e($pcb->fct_completed ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400'); ?>">
                                        F
                                    </span>
                                    <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs <?php echo e($pcb->led_test_completed ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400'); ?>">
                                        L
                                    </span>
                                    <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs <?php echo e($pcb->visual_inspection_completed ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400'); ?>">
                                        V
                                    </span>
                                </div>
                                <span class="text-xs text-gray-500">
                                    <?php echo e(($pcb->fct_completed ? 1 : 0) + ($pcb->led_test_completed ? 1 : 0) + ($pcb->visual_inspection_completed ? 1 : 0)); ?>/3
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($pcb->updated_at ? $pcb->updated_at->diffForHumans() : '-'); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php
                                $nextStep = '';
                                if (!$pcb->fct_completed) $nextStep = 'FCT';
                                elseif (!$pcb->led_test_completed) $nextStep = 'LED Test';
                                elseif (!$pcb->visual_inspection_completed) $nextStep = 'Visual';
                                else $nextStep = 'Completed';
                            ?>
                            <span class="text-xs font-medium <?php echo e($nextStep == 'Completed' ? 'text-green-600' : 'text-blue-600'); ?>">
                                <?php echo e($nextStep); ?>

                            </span>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <div class="text-4xl mb-2">✅</div>
                            <p>No PCBs in progress</p>
                        </td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($inProgressPcbs->links()); ?>

        </div>
    </div>
</div>

<!-- Tabel Completed -->
<div id="tab-completed-content" class="tab-content hidden">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-sm font-semibold text-gray-700">✅ Completed PCBs</h3>
            <span class="text-xs text-gray-500">Showing <?php echo e($completedPcbs->firstItem() ?? 0); ?> - <?php echo e($completedPcbs->lastItem() ?? 0); ?> of <?php echo e($completedPcbs->total() ?? 0); ?></span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completed At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Taken</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">All Steps</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $completedPcbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pcb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($loop->iteration + (($completedPcbs->currentPage() - 1) * $completedPcbs->perPage())); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-medium text-gray-900"><?php echo e($pcb->serial_number); ?></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($pcb->updated_at ? $pcb->updated_at->format('d M Y H:i:s') : '-'); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pcb->created_at && $pcb->updated_at): ?>
                                <?php echo e($pcb->created_at->diff($pcb->updated_at)->format('%h hours, %i minutes')); ?>

                            <?php else: ?>
                                -
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-1">
                                <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs bg-green-500 text-white">F</span>
                                <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs bg-green-500 text-white">L</span>
                                <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs bg-green-500 text-white">V</span>
                            </div>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            <div class="text-4xl mb-2">📭</div>
                            <p>No completed PCBs today</p>
                        </td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($completedPcbs->links()); ?>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function switchTab(tabName) {
    // Hide all tab content
    document.querySelectorAll('.tab-content').forEach(el => {
        el.classList.add('hidden');
    });
    
    // Show selected tab content
    const targetTab = document.getElementById('tab-' + tabName + '-content');
    if (targetTab) {
        targetTab.classList.remove('hidden');
    }
    
    // Update tab styles
    document.querySelectorAll('nav button').forEach(btn => {
        btn.classList.remove('border-blue-500', 'text-blue-600');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    
    const activeTab = document.getElementById('tab-' + tabName);
    if (activeTab) {
        activeTab.classList.remove('border-transparent', 'text-gray-500');
        activeTab.classList.add('border-blue-500', 'text-blue-600');
    }
}

// Set default tab to 'ng' jika ada NG Boxes, otherwise 'all'
document.addEventListener('DOMContentLoaded', function() {
    <?php if($ngBoxes->isNotEmpty()): ?>
        switchTab('ng');
    <?php else: ?>
        switchTab('all');
    <?php endif; ?>
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pcb', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\siix-portal\resources\views\livewire\prod\fct\leader\index.blade.php ENDPATH**/ ?>