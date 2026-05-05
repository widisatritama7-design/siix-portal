<?php # [BlazeFolded]:{flux::badge}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/badge/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::icon}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::card}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::badge}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/badge/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::icon}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::card}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::badge}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/badge/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::icon}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::card}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::badge}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/badge/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::icon}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::card}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php}:{1774988736} ?>
<?php if (isset($component)) { $__componentOriginal4847b66943f6ddd1eb8418f83be8fb5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4847b66943f6ddd1eb8418f83be8fb5d = $attributes; } ?>
<?php $component = App\View\Components\Home\Inbox::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.inbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Home\Inbox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['waitingReceiveCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($waitingReceiveCount ?? 0),'waitingDistributeCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($waitingDistributeCount ?? 0),'waitingApproveCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($waitingApproveCount ?? 0),'waitingCheckCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($waitingCheckCount ?? 0)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <div class="space-y-8">
        <!-- DCC: Waiting Receive Section -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view inbox dcc')): ?>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-white">
                        Waiting Receive
                    </h2>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($waitingReceiveCount ?? 0) > 0): ?>
                        <?php ob_start(); ?><div data-flux-badge="data-flux-badge" class="inline-flex items-center font-medium whitespace-nowrap  [print-color-adjust:exact] text-sm py-1.5 **:data-flux-badge-icon:me-2 rounded-md px-2 text-amber-700 [&amp;_button]:text-amber-700! dark:text-amber-200 dark:[&amp;_button]:text-amber-200! bg-amber-400/25 dark:bg-amber-400/40 [&amp;:is(button)]:hover:bg-amber-400/40 dark:[button]:hover:bg-amber-400/50">
        <?php ob_start(); ?>
                            <?php echo e($waitingReceiveCount); ?>

                        <?php echo trim(ob_get_clean()); ?>

    </div>
<?php echo ltrim(ob_get_clean()); ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php ob_start(); ?><a href="/dcc/submissions?status=Waiting+Received" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white">
        <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M2 8a.75.75 0 0 1 .75-.75h8.69L8.22 4.03a.75.75 0 0 1 1.06-1.06l4.5 4.5a.75.75 0 0 1 0 1.06l-4.5 4.5a.75.75 0 0 1-1.06-1.06l3.22-3.22H2.75A.75.75 0 0 1 2 8Z" clip-rule="evenodd"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?>
                    View All
                <?php echo trim(ob_get_clean()); ?></span>
    </a>
<?php echo ltrim(ob_get_clean()); ?>
            </div>

            <?php ob_start(); ?><div class="[:where(&amp;)]:bg-white dark:[:where(&amp;)]:bg-white/10 border border-zinc-200 dark:border-white/10 [:where(&amp;)]:p-6 [:where(&amp;)]:rounded-xl p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300" data-flux-card>
    <?php ob_start(); ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">From</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Subject</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Due Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">PIC</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = ($waitingReceiveSubmissions ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <?php
                                    $dueDateLabel = $submission->dueDateLabel;
                                    $badgeColor = match($dueDateLabel['color']) {
                                        'danger' => 'red',
                                        'success' => 'green',
                                        'gray' => 'zinc',
                                        default => 'zinc'
                                    };
                                ?>
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                                        <?php echo e($index + 1); ?>

                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white font-medium text-sm">
                                                <?php echo e(strtoupper(substr($submission->department->dept_name ?? $submission->dept, 0, 1))); ?>

                                            </div>
                                            <span class="text-sm font-medium text-zinc-900 dark:text-white">
                                                <?php echo e($submission->department->dept_name ?? $submission->dept); ?>

                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                                <?php echo e($submission->description); ?>

                                            </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($submission->revision): ?>
                                                <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                                    Revision: <?php echo e($submission->revision); ?>

                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($submission->due_date): ?>
                                            <div class="space-y-1">
                                                <div class="text-sm"><?php echo e($submission->due_date->format('Y-m-d')); ?></div>
                                                <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/badge/index.blade.php', $__blaze->compiledPath.'/6b0011e2f83d04930b97e5f6feda22dd.php'); ?>
<?php if (isset($__slots6b0011e2f83d04930b97e5f6feda22dd)) { $__slotsStack6b0011e2f83d04930b97e5f6feda22dd[] = $__slots6b0011e2f83d04930b97e5f6feda22dd; } ?>
<?php if (isset($__attrs6b0011e2f83d04930b97e5f6feda22dd)) { $__attrsStack6b0011e2f83d04930b97e5f6feda22dd[] = $__attrs6b0011e2f83d04930b97e5f6feda22dd; } ?>
<?php $__attrs6b0011e2f83d04930b97e5f6feda22dd = ['color' => e($badgeColor),'size' => 'sm']; ?>
<?php $__slots6b0011e2f83d04930b97e5f6feda22dd = []; ?>
<?php $__blaze->pushData($__attrs6b0011e2f83d04930b97e5f6feda22dd); ?>
<?php ob_start(); ?>
                                                    <?php echo e($dueDateLabel['label']); ?>

                                                <?php $__slots6b0011e2f83d04930b97e5f6feda22dd['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots6b0011e2f83d04930b97e5f6feda22dd); ?>
<?php _6b0011e2f83d04930b97e5f6feda22dd($__blaze, $__attrs6b0011e2f83d04930b97e5f6feda22dd, $__slots6b0011e2f83d04930b97e5f6feda22dd, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack6b0011e2f83d04930b97e5f6feda22dd)) { $__slots6b0011e2f83d04930b97e5f6feda22dd = array_pop($__slotsStack6b0011e2f83d04930b97e5f6feda22dd); } ?>
<?php if (! empty($__attrsStack6b0011e2f83d04930b97e5f6feda22dd)) { $__attrs6b0011e2f83d04930b97e5f6feda22dd = array_pop($__attrsStack6b0011e2f83d04930b97e5f6feda22dd); } ?>
<?php $__blaze->popData(); ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-sm text-zinc-400">-</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/badge/index.blade.php', $__blaze->compiledPath.'/6b0011e2f83d04930b97e5f6feda22dd.php'); ?>
<?php if (isset($__slots6b0011e2f83d04930b97e5f6feda22dd)) { $__slotsStack6b0011e2f83d04930b97e5f6feda22dd[] = $__slots6b0011e2f83d04930b97e5f6feda22dd; } ?>
<?php if (isset($__attrs6b0011e2f83d04930b97e5f6feda22dd)) { $__attrsStack6b0011e2f83d04930b97e5f6feda22dd[] = $__attrs6b0011e2f83d04930b97e5f6feda22dd; } ?>
<?php $__attrs6b0011e2f83d04930b97e5f6feda22dd = ['color' => e($submission->statusColor),'size' => 'sm']; ?>
<?php $__slots6b0011e2f83d04930b97e5f6feda22dd = []; ?>
<?php $__blaze->pushData($__attrs6b0011e2f83d04930b97e5f6feda22dd); ?>
<?php ob_start(); ?>
                                            <?php echo e($submission->status); ?>

                                        <?php $__slots6b0011e2f83d04930b97e5f6feda22dd['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots6b0011e2f83d04930b97e5f6feda22dd); ?>
<?php _6b0011e2f83d04930b97e5f6feda22dd($__blaze, $__attrs6b0011e2f83d04930b97e5f6feda22dd, $__slots6b0011e2f83d04930b97e5f6feda22dd, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack6b0011e2f83d04930b97e5f6feda22dd)) { $__slots6b0011e2f83d04930b97e5f6feda22dd = array_pop($__slotsStack6b0011e2f83d04930b97e5f6feda22dd); } ?>
<?php if (! empty($__attrsStack6b0011e2f83d04930b97e5f6feda22dd)) { $__attrs6b0011e2f83d04930b97e5f6feda22dd = array_pop($__attrsStack6b0011e2f83d04930b97e5f6feda22dd); } ?>
<?php $__blaze->popData(); ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm">
                                            <div><?php echo e($submission->pic ?? 'N/A'); ?></div>
                                            <div class="text-xs text-zinc-500"><?php echo e($submission->created_at->format('d M Y')); ?></div>
                                        </div>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="6" class="px-4 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 w-12 h-12 text-zinc-400" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                                            <div class="text-sm text-zinc-500">No messages waiting to be received</div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
        </div>
        <?php endif; ?>

        <!-- DCC: Waiting Distribute Section -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view inbox dcc')): ?>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-white">
                        Waiting Distribute
                    </h2>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($waitingDistributeCount ?? 0) > 0): ?>
                        <?php ob_start(); ?><div data-flux-badge="data-flux-badge" class="inline-flex items-center font-medium whitespace-nowrap  [print-color-adjust:exact] text-sm py-1.5 **:data-flux-badge-icon:me-2 rounded-md px-2 text-blue-800 [&amp;_button]:text-blue-800! dark:text-blue-200 dark:[&amp;_button]:text-blue-200! bg-blue-400/20 dark:bg-blue-400/40 [&amp;:is(button)]:hover:bg-blue-400/30 dark:[button]:hover:bg-blue-400/50">
        <?php ob_start(); ?>
                            <?php echo e($waitingDistributeCount); ?>

                        <?php echo trim(ob_get_clean()); ?>

    </div>
<?php echo ltrim(ob_get_clean()); ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php ob_start(); ?><a href="/dcc/submissions?distributed=Waiting+Distribute" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white">
        <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M2 8a.75.75 0 0 1 .75-.75h8.69L8.22 4.03a.75.75 0 0 1 1.06-1.06l4.5 4.5a.75.75 0 0 1 0 1.06l-4.5 4.5a.75.75 0 0 1-1.06-1.06l3.22-3.22H2.75A.75.75 0 0 1 2 8Z" clip-rule="evenodd"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?>
                    View All
                <?php echo trim(ob_get_clean()); ?></span>
    </a>
<?php echo ltrim(ob_get_clean()); ?>
            </div>

            <?php ob_start(); ?><div class="[:where(&amp;)]:bg-white dark:[:where(&amp;)]:bg-white/10 border border-zinc-200 dark:border-white/10 [:where(&amp;)]:p-6 [:where(&amp;)]:rounded-xl p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300" data-flux-card>
    <?php ob_start(); ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">To</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Subject</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Due Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">PIC</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = ($waitingDistributeSubmissions ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <?php
                                    $dueDateLabel = $submission->dueDateLabel;
                                    $badgeColor = match($dueDateLabel['color']) {
                                        'danger' => 'red',
                                        'success' => 'green',
                                        'gray' => 'zinc',
                                        default => 'zinc'
                                    };
                                ?>
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                                        <?php echo e($index + 1); ?>

                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-medium text-sm">
                                                <?php echo e(strtoupper(substr($submission->department->dept_name ?? $submission->dept, 0, 1))); ?>

                                            </div>
                                            <span class="text-sm font-medium text-zinc-900 dark:text-white">
                                                <?php echo e($submission->department->dept_name ?? $submission->dept); ?>

                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                                <?php echo e($submission->description); ?>

                                            </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($submission->revision): ?>
                                                <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                                    Revision: <?php echo e($submission->revision); ?>

                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($submission->due_date): ?>
                                            <div class="space-y-1">
                                                <div class="text-sm"><?php echo e($submission->due_date->format('Y-m-d')); ?></div>
                                                <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/badge/index.blade.php', $__blaze->compiledPath.'/6b0011e2f83d04930b97e5f6feda22dd.php'); ?>
<?php if (isset($__slots6b0011e2f83d04930b97e5f6feda22dd)) { $__slotsStack6b0011e2f83d04930b97e5f6feda22dd[] = $__slots6b0011e2f83d04930b97e5f6feda22dd; } ?>
<?php if (isset($__attrs6b0011e2f83d04930b97e5f6feda22dd)) { $__attrsStack6b0011e2f83d04930b97e5f6feda22dd[] = $__attrs6b0011e2f83d04930b97e5f6feda22dd; } ?>
<?php $__attrs6b0011e2f83d04930b97e5f6feda22dd = ['color' => e($badgeColor),'size' => 'sm']; ?>
<?php $__slots6b0011e2f83d04930b97e5f6feda22dd = []; ?>
<?php $__blaze->pushData($__attrs6b0011e2f83d04930b97e5f6feda22dd); ?>
<?php ob_start(); ?>
                                                    <?php echo e($dueDateLabel['label']); ?>

                                                <?php $__slots6b0011e2f83d04930b97e5f6feda22dd['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots6b0011e2f83d04930b97e5f6feda22dd); ?>
<?php _6b0011e2f83d04930b97e5f6feda22dd($__blaze, $__attrs6b0011e2f83d04930b97e5f6feda22dd, $__slots6b0011e2f83d04930b97e5f6feda22dd, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack6b0011e2f83d04930b97e5f6feda22dd)) { $__slots6b0011e2f83d04930b97e5f6feda22dd = array_pop($__slotsStack6b0011e2f83d04930b97e5f6feda22dd); } ?>
<?php if (! empty($__attrsStack6b0011e2f83d04930b97e5f6feda22dd)) { $__attrs6b0011e2f83d04930b97e5f6feda22dd = array_pop($__attrsStack6b0011e2f83d04930b97e5f6feda22dd); } ?>
<?php $__blaze->popData(); ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-sm text-zinc-400">-</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/badge/index.blade.php', $__blaze->compiledPath.'/6b0011e2f83d04930b97e5f6feda22dd.php'); ?>
<?php if (isset($__slots6b0011e2f83d04930b97e5f6feda22dd)) { $__slotsStack6b0011e2f83d04930b97e5f6feda22dd[] = $__slots6b0011e2f83d04930b97e5f6feda22dd; } ?>
<?php if (isset($__attrs6b0011e2f83d04930b97e5f6feda22dd)) { $__attrsStack6b0011e2f83d04930b97e5f6feda22dd[] = $__attrs6b0011e2f83d04930b97e5f6feda22dd; } ?>
<?php $__attrs6b0011e2f83d04930b97e5f6feda22dd = ['color' => e($submission->statusColor),'size' => 'sm']; ?>
<?php $__slots6b0011e2f83d04930b97e5f6feda22dd = []; ?>
<?php $__blaze->pushData($__attrs6b0011e2f83d04930b97e5f6feda22dd); ?>
<?php ob_start(); ?>
                                            <?php echo e($submission->status); ?>

                                        <?php $__slots6b0011e2f83d04930b97e5f6feda22dd['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots6b0011e2f83d04930b97e5f6feda22dd); ?>
<?php _6b0011e2f83d04930b97e5f6feda22dd($__blaze, $__attrs6b0011e2f83d04930b97e5f6feda22dd, $__slots6b0011e2f83d04930b97e5f6feda22dd, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack6b0011e2f83d04930b97e5f6feda22dd)) { $__slots6b0011e2f83d04930b97e5f6feda22dd = array_pop($__slotsStack6b0011e2f83d04930b97e5f6feda22dd); } ?>
<?php if (! empty($__attrsStack6b0011e2f83d04930b97e5f6feda22dd)) { $__attrs6b0011e2f83d04930b97e5f6feda22dd = array_pop($__attrsStack6b0011e2f83d04930b97e5f6feda22dd); } ?>
<?php $__blaze->popData(); ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm">
                                            <div><?php echo e($submission->pic ?? 'N/A'); ?></div>
                                            <div class="text-xs text-zinc-500"><?php echo e($submission->created_at->format('d M Y')); ?></div>
                                        </div>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="7" class="px-4 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 w-12 h-12 text-zinc-400" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                                            <div class="text-sm text-zinc-500">No messages waiting to be distributed</div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
        </div>
        <?php endif; ?>

        <!-- Ticket: Waiting Approve Section -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve tickets')): ?>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-white">
                        Waiting Approve
                    </h2>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($waitingApproveCount ?? 0) > 0): ?>
                        <?php ob_start(); ?><div data-flux-badge="data-flux-badge" class="inline-flex items-center font-medium whitespace-nowrap  [print-color-adjust:exact] text-sm py-1.5 **:data-flux-badge-icon:me-2 rounded-md px-2 text-purple-700 [&amp;_button]:text-purple-700! dark:text-purple-200 dark:[&amp;_button]:text-purple-200! bg-purple-400/20 dark:bg-purple-400/40 [&amp;:is(button)]:hover:bg-purple-400/30 dark:[button]:hover:bg-purple-400/50">
        <?php ob_start(); ?>
                            <?php echo e($waitingApproveCount); ?>

                        <?php echo trim(ob_get_clean()); ?>

    </div>
<?php echo ltrim(ob_get_clean()); ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php ob_start(); ?><a href="/ticket/list?pic_approval=Waiting+Approval" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white">
        <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M2 8a.75.75 0 0 1 .75-.75h8.69L8.22 4.03a.75.75 0 0 1 1.06-1.06l4.5 4.5a.75.75 0 0 1 0 1.06l-4.5 4.5a.75.75 0 0 1-1.06-1.06l3.22-3.22H2.75A.75.75 0 0 1 2 8Z" clip-rule="evenodd"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?>
                    View All
                <?php echo trim(ob_get_clean()); ?></span>
    </a>
<?php echo ltrim(ob_get_clean()); ?>
            </div>

            <?php ob_start(); ?><div class="[:where(&amp;)]:bg-white dark:[:where(&amp;)]:bg-white/10 border border-zinc-200 dark:border-white/10 [:where(&amp;)]:p-6 [:where(&amp;)]:rounded-xl p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300" data-flux-card>
    <?php ob_start(); ?>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-max">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Ticket #</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Title</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Priority</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Requester</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Created</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = ($waitingApproveTickets ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                    <?php echo e($index + 1); ?>

                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm font-mono font-semibold text-blue-600 dark:text-blue-400">
                                        <?php echo e($ticket->ticket_number); ?>

                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <?php
                                        $title = $ticket->title;
                                        $isLongText = strlen($title) > 25;
                                    ?>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isLongText): ?>
                                        <div class="relative group inline-block">
                                            <div class="text-sm text-zinc-800 dark:text-white cursor-help border-b border-dashed border-zinc-400 dark:border-zinc-500">
                                                <?php echo e(Str::limit($title, 25)); ?>

                                            </div>
                                            <div class="absolute z-50 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-200 bottom-full left-0 mb-2 pointer-events-none">
                                                <div class="bg-gray-900 dark:bg-gray-800 text-white rounded-lg shadow-lg px-3 py-2 text-sm whitespace-normal max-w-xs">
                                                    <div class="font-semibold text-xs text-gray-300 mb-1">Title</div>
                                                    <?php echo e($title); ?>

                                                </div>
                                                <div class="absolute -bottom-1 left-4 w-2 h-2 bg-gray-900 dark:bg-gray-800 transform rotate-45"></div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-sm text-zinc-800 dark:text-white">
                                            <?php echo e($title); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <?php
                                        $statusColors = [
                                            'Open' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                            'In Progress' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                            'Pending' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                            'Closed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                        ];
                                        $statusColor = $statusColors[$ticket->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($statusColor); ?>">
                                        <?php echo e($ticket->status); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <?php
                                        $priorityColors = [
                                            'Low' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300',
                                            'Medium' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                            'Urgent' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                            'Critical' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                        ];
                                        $priorityColor = $priorityColors[$ticket->priority] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($priorityColor); ?>">
                                        <?php echo e($ticket->priority); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <?php
                                        $categoryName = $ticket->category->name ?? '-';
                                        $isLongText = strlen($categoryName) > 25;
                                    ?>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isLongText && $categoryName !== '-'): ?>
                                        <div class="relative group inline-block">
                                            <div class="text-sm text-zinc-600 dark:text-zinc-400 cursor-help border-b border-dashed border-zinc-400 dark:border-zinc-500">
                                                <?php echo e(Str::limit($categoryName, 25)); ?>

                                            </div>
                                            <div class="absolute z-50 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-200 bottom-full left-0 mb-2 pointer-events-none">
                                                <div class="bg-gray-900 dark:bg-gray-800 text-white rounded-lg shadow-lg px-3 py-2 text-sm whitespace-normal max-w-xs">
                                                    <div class="font-semibold text-xs text-gray-300 mb-1">Category</div>
                                                    <?php echo e($categoryName); ?>

                                                </div>
                                                <div class="absolute -bottom-1 left-4 w-2 h-2 bg-gray-900 dark:bg-gray-800 transform rotate-45"></div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-sm text-zinc-600 dark:text-zinc-400">
                                            <?php echo e($categoryName); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm">
                                        <div class="text-zinc-800 dark:text-white"><?php echo e($ticket->creator->name ?? 'N/A'); ?></div>
                                        <div class="text-xs text-zinc-500"><?php echo e($ticket->email_user); ?></div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm">
                                        <div class="text-zinc-600 dark:text-zinc-400"><?php echo e($ticket->created_at->format('d M Y')); ?></div>
                                        <div class="text-xs text-zinc-500"><?php echo e($ticket->created_at->format('H:i')); ?></div>
                                    </div>
                                </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="8" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 w-10 h-10 text-zinc-400 dark:text-zinc-500" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No tickets waiting for approval
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                                All tickets have been processed
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
        </div>
        <?php endif; ?>

        <!-- Ticket: Waiting Check Section -->
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('check tickets')): ?>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-white">
                        Waiting Check
                    </h2>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($waitingCheckCount ?? 0) > 0): ?>
                        <?php ob_start(); ?><div data-flux-badge="data-flux-badge" class="inline-flex items-center font-medium whitespace-nowrap  [print-color-adjust:exact] text-sm py-1.5 **:data-flux-badge-icon:me-2 rounded-md px-2 text-green-800 [&amp;_button]:text-green-800! dark:text-green-200 dark:[&amp;_button]:text-green-200! bg-green-400/20 dark:bg-green-400/40 [&amp;:is(button)]:hover:bg-green-400/30 dark:[button]:hover:bg-green-400/50">
        <?php ob_start(); ?>
                            <?php echo e($waitingCheckCount); ?>

                        <?php echo trim(ob_get_clean()); ?>

    </div>
<?php echo ltrim(ob_get_clean()); ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php ob_start(); ?><a href="/ticket/list?user_approval=Waiting+Approval" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white">
        <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M2 8a.75.75 0 0 1 .75-.75h8.69L8.22 4.03a.75.75 0 0 1 1.06-1.06l4.5 4.5a.75.75 0 0 1 0 1.06l-4.5 4.5a.75.75 0 0 1-1.06-1.06l3.22-3.22H2.75A.75.75 0 0 1 2 8Z" clip-rule="evenodd"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?>
                    View All
                <?php echo trim(ob_get_clean()); ?></span>
    </a>
<?php echo ltrim(ob_get_clean()); ?>
            </div>

            <?php ob_start(); ?><div class="[:where(&amp;)]:bg-white dark:[:where(&amp;)]:bg-white/10 border border-zinc-200 dark:border-white/10 [:where(&amp;)]:p-6 [:where(&amp;)]:rounded-xl p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300" data-flux-card>
    <?php ob_start(); ?>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-max">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Ticket #</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Title</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Priority</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Requester</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Created</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = ($waitingCheckTickets ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                    <?php echo e($index + 1); ?>

                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm font-mono font-semibold text-blue-600 dark:text-blue-400">
                                        <?php echo e($ticket->ticket_number); ?>

                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <?php
                                        $title = $ticket->title;
                                        $isLongText = strlen($title) > 25;
                                    ?>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isLongText): ?>
                                        <div class="relative group inline-block">
                                            <div class="text-sm text-zinc-800 dark:text-white cursor-help border-b border-dashed border-zinc-400 dark:border-zinc-500">
                                                <?php echo e(Str::limit($title, 25)); ?>

                                            </div>
                                            <div class="absolute z-50 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-200 bottom-full left-0 mb-2 pointer-events-none">
                                                <div class="bg-gray-900 dark:bg-gray-800 text-white rounded-lg shadow-lg px-3 py-2 text-sm whitespace-normal max-w-xs">
                                                    <div class="font-semibold text-xs text-gray-300 mb-1">Title</div>
                                                    <?php echo e($title); ?>

                                                </div>
                                                <div class="absolute -bottom-1 left-4 w-2 h-2 bg-gray-900 dark:bg-gray-800 transform rotate-45"></div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-sm text-zinc-800 dark:text-white">
                                            <?php echo e($title); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <?php
                                        $statusColors = [
                                            'Open' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                            'In Progress' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                            'Pending' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                            'Closed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                        ];
                                        $statusColor = $statusColors[$ticket->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($statusColor); ?>">
                                        <?php echo e($ticket->status); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <?php
                                        $priorityColors = [
                                            'Low' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300',
                                            'Medium' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                            'Urgent' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                            'Critical' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                        ];
                                        $priorityColor = $priorityColors[$ticket->priority] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($priorityColor); ?>">
                                        <?php echo e($ticket->priority); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <?php
                                        $categoryName = $ticket->category->name ?? '-';
                                        $isLongText = strlen($categoryName) > 25;
                                    ?>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isLongText && $categoryName !== '-'): ?>
                                        <div class="relative group inline-block">
                                            <div class="text-sm text-zinc-600 dark:text-zinc-400 cursor-help border-b border-dashed border-zinc-400 dark:border-zinc-500">
                                                <?php echo e(Str::limit($categoryName, 25)); ?>

                                            </div>
                                            <div class="absolute z-50 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-200 bottom-full left-0 mb-2 pointer-events-none">
                                                <div class="bg-gray-900 dark:bg-gray-800 text-white rounded-lg shadow-lg px-3 py-2 text-sm whitespace-normal max-w-xs">
                                                    <div class="font-semibold text-xs text-gray-300 mb-1">Category</div>
                                                    <?php echo e($categoryName); ?>

                                                </div>
                                                <div class="absolute -bottom-1 left-4 w-2 h-2 bg-gray-900 dark:bg-gray-800 transform rotate-45"></div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-sm text-zinc-600 dark:text-zinc-400">
                                            <?php echo e($categoryName); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm">
                                        <div class="text-zinc-800 dark:text-white"><?php echo e($ticket->creator->name ?? 'N/A'); ?></div>
                                        <div class="text-xs text-zinc-500"><?php echo e($ticket->email_user); ?></div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm">
                                        <div class="text-zinc-600 dark:text-zinc-400"><?php echo e($ticket->created_at->format('d M Y')); ?></div>
                                        <div class="text-xs text-zinc-500"><?php echo e($ticket->created_at->format('H:i')); ?></div>
                                    </div>
                                </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="8" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 w-10 h-10 text-zinc-400 dark:text-zinc-500" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No tickets waiting for checking
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                                All tickets have been checked
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
        </div>
        <?php endif; ?>
    </div>

    <script>
    function distributeSubmission(submissionId) {
        if (confirm('Are you sure you want to mark this submission as distributed?')) {
            fetch(`/inbox/distribute/${submissionId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    location.reload();
                } else {
                    alert('Error distributing submission');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while distributing the submission');
            });
        }
    }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4847b66943f6ddd1eb8418f83be8fb5d)): ?>
<?php $attributes = $__attributesOriginal4847b66943f6ddd1eb8418f83be8fb5d; ?>
<?php unset($__attributesOriginal4847b66943f6ddd1eb8418f83be8fb5d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4847b66943f6ddd1eb8418f83be8fb5d)): ?>
<?php $component = $__componentOriginal4847b66943f6ddd1eb8418f83be8fb5d; ?>
<?php unset($__componentOriginal4847b66943f6ddd1eb8418f83be8fb5d); ?>
<?php endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/home/inbox/index.blade.php ENDPATH**/ ?>