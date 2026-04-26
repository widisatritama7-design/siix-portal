<?php # [BlazeFolded]:{flux::heading}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/heading.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/index.blade.php}:{1774988736} ?>
<section class="w-full" x-data="stencilDashboard()" x-init="init()" x-on:livewire:navigated.window="handleNavigated">
    <?php echo $__env->make('partials.mtc-heading', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-sm [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2 sr-only" data-flux-heading><?php ob_start(); ?>
        <?php echo e(__('MTC - Stencil Dashboard')); ?>

    <?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>

    <?php if (isset($component)) { $__componentOriginal2991782b15caf2333143ee45e5bacc85 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2991782b15caf2333143ee45e5bacc85 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.mtc.layout','data' => ['class' => '!max-w-full !px-0 !mx-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mtc.layout'); ?>
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
                    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php', $__blaze->compiledPath.'/b843a539037c1542dedc5bd82236e28a.php'); ?>
<?php if (isset($__slotsb843a539037c1542dedc5bd82236e28a)) { $__slotsStackb843a539037c1542dedc5bd82236e28a[] = $__slotsb843a539037c1542dedc5bd82236e28a; } ?>
<?php if (isset($__attrsb843a539037c1542dedc5bd82236e28a)) { $__attrsStackb843a539037c1542dedc5bd82236e28a[] = $__attrsb843a539037c1542dedc5bd82236e28a; } ?>
<?php $__attrsb843a539037c1542dedc5bd82236e28a = ['href' => e(route('dashboard')),'wire:navigate' => true,'separator' => 'slash']; ?>
<?php $__slotsb843a539037c1542dedc5bd82236e28a = []; ?>
<?php $__blaze->pushData($__attrsb843a539037c1542dedc5bd82236e28a); ?>
<?php ob_start(); ?>
                        Dashboard
                    <?php $__slotsb843a539037c1542dedc5bd82236e28a['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsb843a539037c1542dedc5bd82236e28a); ?>
<?php _b843a539037c1542dedc5bd82236e28a($__blaze, $__attrsb843a539037c1542dedc5bd82236e28a, $__slotsb843a539037c1542dedc5bd82236e28a, ['wire:navigate'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackb843a539037c1542dedc5bd82236e28a)) { $__slotsb843a539037c1542dedc5bd82236e28a = array_pop($__slotsStackb843a539037c1542dedc5bd82236e28a); } ?>
<?php if (! empty($__attrsStackb843a539037c1542dedc5bd82236e28a)) { $__attrsb843a539037c1542dedc5bd82236e28a = array_pop($__attrsStackb843a539037c1542dedc5bd82236e28a); } ?>
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
                        Stencil Monitoring
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
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-zinc-800 dark:text-white">
                            Realtime Dashboard For Use Stencil
                        </h1>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="text-xs text-zinc-400" x-text="lastUpdatedText"></div>
                        <button x-on:click="manualRefresh()" 
                                class="inline-flex items-center gap-1 px-2 sm:px-3 py-1 text-xs font-medium text-zinc-700 bg-white border border-zinc-300 rounded-lg hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-600 dark:hover:bg-zinc-700 transition-colors whitespace-nowrap">
                            <svg class="w-3 h-3" :class="{'animate-spin': refreshing}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span class="hidden sm:inline">Refresh</span>
                        </button>
                    </div>
                </div>
            </div>
         <?php $__env->endSlot(); ?>

        <div class="-mt-2">
            <!-- Legend - Smaller -->
            <div class="flex flex-wrap gap-1.5 sm:gap-2 mb-3">
                <div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-zinc-600 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded-full">
                    <span class="w-2 h-2 rounded bg-red-500 animate-pulse"></span>
                    <span>No Stencil</span>
                </div>
                <div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-zinc-600 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded-full">
                    <span class="w-2 h-2 rounded bg-green-500"></span>
                    <span>In Use</span>
                </div>
                <div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-zinc-600 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded-full">
                    <span class="w-2 h-2 rounded bg-amber-500"></span>
                    <span>Rack</span>
                </div>
                <div class="flex items-center gap-1.5 text-[10px] sm:text-xs text-zinc-600 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded-full">
                    <span class="w-2 h-2 rounded bg-blue-500"></span>
                    <span>Prepared</span>
                </div>
            </div>

            <!-- Content 3 Columns - Smaller cards -->
            <div id="stencilCardsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 lg:gap-3" x-html="renderedCards"></div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2991782b15caf2333143ee45e5bacc85)): ?>
<?php $attributes = $__attributesOriginal2991782b15caf2333143ee45e5bacc85; ?>
<?php unset($__attributesOriginal2991782b15caf2333143ee45e5bacc85); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2991782b15caf2333143ee45e5bacc85)): ?>
<?php $component = $__componentOriginal2991782b15caf2333143ee45e5bacc85; ?>
<?php unset($__componentOriginal2991782b15caf2333143ee45e5bacc85); ?>
<?php endif; ?>

    <!-- Modal - Fixed positioning with proper centering -->
    <div x-show="isModalOpen" 
        x-transition.opacity
        class="modal-container"
        x-on:click.away="closeModal()"
        x-cloak>
        <div x-on:click.stop
            class="bg-white dark:bg-zinc-800 rounded-xl w-[90%] max-w-[1000px] max-h-[85vh] overflow-hidden shadow-2xl">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 text-white px-5 py-3 flex items-center justify-between">
                <h3 x-text="modalTitle" class="text-base font-semibold"></h3>
                <button x-on:click="closeModal()" class="text-white/80 hover:text-white text-2xl leading-none transition">&times;</button>
            </div>
            <div id="stencilModalBody" class="p-4 overflow-y-auto" style="max-height: calc(85vh - 3.5rem);" x-html="modalBody"></div>
        </div>
    </div>

    <style>
        .stencil-card {
            transition: all 0.2s ease;
        }
        .stencil-card:hover {
            border-color: #3b82f6 !important;
            transform: translateY(-1px);
        }
        .stencil-card .text-xs {
            font-size: 0.7rem !important;
        }
        .stencil-card .rounded-full {
            padding: 0.125rem 0.5rem !important;
        }
        
        /* Fix untuk modal centering */
        [x-cloak] { 
            display: none !important; 
        }
        
        /* Pastikan modal container selalu flex dan centered */
        .modal-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
    </style>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('stencilDashboard', () => ({
                // Data properties
                stencilData: {},
                totalActive: 0,
                lastUpdatedText: '',
                renderedCards: '',
                refreshing: false,
                isModalOpen: false,
                modalTitle: '',
                modalBody: '',
                refreshInterval: null,
                
                // Data dari server (Laravel)
                serverData: <?php echo json_encode($jigs, 15, 512) ?>,
                
                init() {
                    this.stencilData = JSON.parse(JSON.stringify(this.serverData));
                    this.renderDashboard();
                    this.updateLastUpdated();
                    this.startAutoRefresh();
                },
                
                handleNavigated() {
                    // Re-initialize when navigating back to this page (SPA)
                    if (this.refreshInterval) {
                        clearInterval(this.refreshInterval);
                    }
                    this.fetchLatestData();
                    this.startAutoRefresh();
                },
                
                startAutoRefresh() {
                    // Clear existing interval if any
                    if (this.refreshInterval) {
                        clearInterval(this.refreshInterval);
                    }
                    
                    // Set new interval for 5 seconds
                    this.refreshInterval = setInterval(() => {
                        if (!this.isModalOpen) {
                            this.fetchLatestData();
                        }
                    }, 5000);
                },
                
                async fetchLatestData() {
                    if (this.isModalOpen) return;
                    
                    try {
                        const response = await fetch('<?php echo e(url("/api/stencils/latest")); ?>');
                        if (!response.ok) throw new Error('Network response was not ok');
                        const data = await response.json();
                        this.stencilData = data;
                        this.renderDashboard();
                        this.updateLastUpdated();
                    } catch (error) {
                        console.error('Auto refresh error:', error);
                        if (!this.renderedCards) {
                            this.renderedCards = '<div class="text-center text-red-500 col-span-3">Error loading data. Please refresh the page.</div>';
                        }
                    }
                },
                
                async manualRefresh() {
                    if (!this.isModalOpen) {
                        this.refreshing = true;
                        try {
                            await this.fetchLatestData();
                        } finally {
                            this.refreshing = false;
                        }
                    }
                },
                
                updateLastUpdated() {
                    const now = new Date();
                    const formatted = now.toLocaleString('id-ID', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    });
                },
                
                renderDashboard() {
                    let totalActiveCount = 0;
                    let html = '';
                    
                    // 3 columns
                    const columns = [
                        { start: 1, end: 6 },
                        { start: 7, end: 12 },
                        { start: 13, end: 17 }
                    ];
                    
                    columns.forEach(column => {
                        html += `<div class="space-y-2">`;
                        
                        for (let i = column.start; i <= column.end; i++) {
                            const line = `SMT ${i}`;
                            const registers = this.stencilData[line] || [];
                            const activeRegisters = registers.filter(j => j.status !== 'Stand By');
                            const isEmpty = activeRegisters.length === 0;
                            
                            totalActiveCount += activeRegisters.length;
                            
                            html += `
                                <div class="stencil-card bg-white dark:bg-zinc-800 rounded-lg border ${isEmpty ? 'border-l-2 border-l-red-500' : 'border-zinc-200 dark:border-zinc-700'} p-2 cursor-pointer hover:shadow transition-all duration-200"
                                     x-on:click="openModal('${line}')">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <div class="flex items-center gap-1.5 flex-shrink-0">
                                            <span class="font-semibold text-[11px] bg-zinc-100 dark:bg-zinc-700 px-2 py-0.5 rounded-full">${this.escapeHtml(line)}</span>
                                            ${!isEmpty ? `<span class="text-[10px] font-semibold bg-blue-500 text-white px-1.5 py-0.5 rounded-full">${activeRegisters.length}</span>` : ''}
                                        </div>
                                        <div class="flex flex-wrap items-center gap-1 flex-1">
                            `;
                            
                            if (activeRegisters.length > 0) {
                                activeRegisters.forEach(jig => {
                                    const bgColor = jig.status === 'In Use' ? '#10b981' : '#3b82f6';
                                    html += `
                                        <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium text-white shadow-sm" style="background: ${bgColor};">
                                            <span>${this.escapeHtml(jig.register_no)}</span>
                                            ${jig.rack_number ? `<span class="bg-amber-500 px-1 py-0.5 rounded-full text-[9px] font-bold ml-0.5">${this.escapeHtml(jig.rack_number)}</span>` : ''}
                                        </div>
                                    `;
                                });
                            } else {
                                html += `<div class="text-red-500 text-[10px] bg-red-50 dark:bg-red-950/30 px-2 py-0.5 rounded-full">🔴 No Stencil</div>`;
                            }
                            
                            html += `
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                        
                        html += `</div>`;
                    });
                    
                    this.renderedCards = html;
                    this.totalActive = totalActiveCount;
                },
                
                escapeHtml(str) {
                    if (!str) return '';
                    return String(str).replace(/[&<>]/g, function(m) {
                        if (m === '&') return '&amp;';
                        if (m === '<') return '&lt;';
                        if (m === '>') return '&gt;';
                        return m;
                    });
                },
                
                openModal(line) {
                    this.isModalOpen = true;
                    
                    const data = this.stencilData[line] || [];
                    const activeData = data.filter(jig => jig.status !== 'Stand By');
                    
                    this.modalTitle = `Line ${line} - Stencil Details`;
                    
                    let html = `
                        <div class="overflow-x-auto">
                            <table style="width: 100%; border-collapse: collapse; font-size: 0.75rem;">
                                <thead>
                                    <tr style="background: #f9fafb;">
                                        <th style="padding: 0.5rem 0.75rem; text-align: left; font-size: 0.7rem; font-weight: 600; color: #6b7280;">Register No</th>
                                        <th style="padding: 0.5rem 0.75rem; text-align: left; font-size: 0.7rem; font-weight: 600; color: #6b7280;">Rack</th>
                                        <th style="padding: 0.5rem 0.75rem; text-align: left; font-size: 0.7rem; font-weight: 600; color: #6b7280;">Last Update</th>
                                        <th style="padding: 0.5rem 0.75rem; text-align: left; font-size: 0.7rem; font-weight: 600; color: #6b7280;">PIC</th>
                                        <th style="padding: 0.5rem 0.75rem; text-align: left; font-size: 0.7rem; font-weight: 600; color: #6b7280;">Status</th>
                                        <th style="padding: 0.5rem 0.75rem; text-align: left; font-size: 0.7rem; font-weight: 600; color: #6b7280;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    
                    if (activeData.length > 0) {
                        activeData.forEach(jig => {
                            const updatedAt = jig.updated_at ? new Date(jig.updated_at).toLocaleString('id-ID') : '-';
                            const employeeNik = jig.employee?.name || '-';
                            html += `
                                <tr style="border-bottom: 1px solid #e5e7eb;" data-id="${jig.id}">
                                    <td style="padding: 0.5rem 0.75rem; font-size: 0.75rem; font-weight: 600;">${this.escapeHtml(jig.register_no)}</td>
                                    <td style="padding: 0.5rem 0.75rem; font-size: 0.75rem;">${jig.rack_number || '-'}</td>
                                    <td style="padding: 0.5rem 0.75rem; font-size: 0.7rem;">${updatedAt}</td>
                                    <td style="padding: 0.5rem 0.75rem; font-size: 0.75rem;">${employeeNik}</td>
                                    <td style="padding: 0.5rem 0.75rem;">
                                        <select class="stencil-status-select" style="padding: 0.375rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.7rem;">
                                            <option value="Prepared" ${jig.status === 'Prepared' ? 'selected' : ''}>Prepared</option>
                                            <option value="In Use" ${jig.status === 'In Use' ? 'selected' : ''}>In Use</option>
                                            <option value="Stand By" ${jig.status === 'Stand By' ? 'selected' : ''}>Stand By</option>
                                        </select>
                                    </td>
                                    <td style="padding: 0.5rem 0.75rem;">
                                        <button x-on:click="showNikInput($el, ${jig.id})" style="padding: 0.375rem 0.75rem; background: #3b82f6; color: white; border: none; border-radius: 0.375rem; cursor: pointer; font-size: 0.7rem;">Update</button>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        html += `<tr><td colspan="6" style="text-align: center; padding: 1.5rem; font-size: 0.75rem;">No stencil data available</td></tr>`;
                    }
                    
                    html += `
                                </tbody>
                            </table>
                        </div>
                    `;
                    
                    this.modalBody = html;
                },
                
                closeModal() {
                    this.isModalOpen = false;
                    this.fetchLatestData(); // Refresh data after closing modal
                },
                
                showNikInput(button, id) {
                    const row = button.closest('tr');
                    if (row.querySelector('.nik-input')) return;
                    
                    const cell = button.parentElement;
                    cell.innerHTML = `
                        <div class="flex gap-1 items-center">
                            <input type="text" class="nik-input" placeholder="NIK" style="padding: 0.375rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.7rem; width: 80px;">
                            <button x-on:click="submitStatus(${id}, $el)" style="padding: 0.375rem 0.5rem; background: #10b981; color: white; border: none; border-radius: 0.375rem; cursor: pointer; font-size: 0.7rem;">✓</button>
                            <button x-on:click="cancelNikInput($el, ${id})" style="padding: 0.375rem 0.5rem; background: #6b7280; color: white; border: none; border-radius: 0.375rem; cursor: pointer; font-size: 0.7rem;">✗</button>
                        </div>
                    `;
                },
                
                cancelNikInput(button, id) {
                    const cell = button.closest('td');
                    cell.innerHTML = `<button x-on:click="showNikInput($el, ${id})" style="padding: 0.375rem 0.75rem; background: #3b82f6; color: white; border: none; border-radius: 0.375rem; cursor: pointer; font-size: 0.7rem;">Update</button>`;
                },
                
                async submitStatus(id, button) {
                    const row = button.closest('tr');
                    const status = row.querySelector('.stencil-status-select').value;
                    const nik = row.querySelector('.nik-input').value;
                    
                    if (!nik) {
                        alert('Please enter NIK');
                        return;
                    }
                    
                    button.disabled = true;
                    button.textContent = '...';
                    
                    try {
                        const response = await fetch('<?php echo e(url("/api/stencils/update-status")); ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ 
                                id: id,
                                status: status,
                                nik: nik,
                                reset_rack: status === 'Stand By'
                            })
                        });
                        
                        const result = await response.json();
                        
                        if (result.success) {
                            alert('✅ Status updated successfully!');
                            this.closeModal();
                        } else {
                            alert('❌ Update failed: ' + (result.message || 'Unknown error'));
                            button.disabled = false;
                            button.textContent = '✓';
                        }
                    } catch (error) {
                        console.error('Submit error:', error);
                        alert('Error: ' + error.message);
                        button.disabled = false;
                        button.textContent = '✓';
                    }
                }
            }));
        });
        
        // Clean up interval when page is hidden/closed
        window.addEventListener('beforeunload', function() {
            if (window.dispatchEvent) {
                // Cleanup will be handled by Alpine
            }
        });
    </script>
    <?php $__env->stopPush(); ?>
</section><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/livewire/mtc/dashboard/stencil-dashboard.blade.php ENDPATH**/ ?>