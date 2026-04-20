<?php # [BlazeFolded]:{flux::heading}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/heading.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/index.blade.php}:{1774988736} ?>
<section class="w-full">
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
    
    <!--[if BLOCK]><![endif]-->        <svg class="shrink-0 [:where(&amp;)]:size-5 mx-1 text-zinc-300 dark:text-white/80 group-last/breadcrumb:hidden rtl:-scale-x-100" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M12.528 3.047a.75.75 0 0 1 .449.961L8.433 16.504a.75.75 0 1 1-1.41-.512l4.544-12.496a.75.75 0 0 1 .961-.449Z" clip-rule="evenodd"/>
</svg>

            <!--[if ENDBLOCK]><![endif]--></div>
<?php echo ltrim(ob_get_clean()); ?>
                    <?php ob_start(); ?><div class="flex items-center text-sm font-medium group/breadcrumb font-semibold text-blue-600 dark:text-blue-400" data-flux-breadcrumbs-item>
            <div class="text-gray-500 dark:text-white/80">
                            <?php ob_start(); ?>
                        Stencil Monitoring
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
                        <div class="text-xs text-zinc-500 whitespace-nowrap">
                            Total Active: <span id="totalActive" class="font-bold text-sm text-blue-600">0</span>
                        </div>
                        <div class="text-xs text-zinc-400" id="lastUpdated"></div>
                        <button onclick="manualRefresh()" 
                                class="inline-flex items-center gap-1 px-2 sm:px-3 py-1 text-xs font-medium text-zinc-700 bg-white border border-zinc-300 rounded-lg hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-600 dark:hover:bg-zinc-700 transition-colors whitespace-nowrap">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div id="stencilCardsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 lg:gap-3"></div>
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

    <!-- Modal -->
    <div id="stencilModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px); align-items: center; justify-content: center; z-index: 9999;">
        <div style="background: white; border-radius: 0.75rem; width: 90%; max-width: 1000px; max-height: 85vh; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
            <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.75rem 1.25rem; display: flex; align-items: center; justify-content: space-between;">
                <h3 id="stencilModalTitle" style="font-size: 1rem; font-weight: 600; margin: 0;"></h3>
                <button onclick="closeStencilModal()" style="background: none; border: none; color: white; font-size: 1.5rem; cursor: pointer; padding: 0 0.5rem; line-height: 1; opacity: 0.8;">×</button>
            </div>
            <div id="stencilModalBody" style="padding: 1rem; overflow-y: auto; max-height: calc(85vh - 3.5rem);"></div>
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
    </style>

    <?php $__env->startPush('scripts'); ?>
    <script>
        let stencilData = {};
        let refreshInterval;
        let isModalOpen = false;

        // Data dari server (Laravel)
        const serverData = <?php echo json_encode($jigs, 15, 512) ?>;

        document.addEventListener('DOMContentLoaded', function() {
            stencilData = JSON.parse(JSON.stringify(serverData));
            renderDashboard();
            updateLastUpdated();
            startAutoRefresh();
        });

        function startAutoRefresh() {
            // Clear existing interval if any
            if (refreshInterval) {
                clearInterval(refreshInterval);
            }
            
            // Set new interval for 5 seconds
            refreshInterval = setInterval(function() {
                if (!isModalOpen) {
                    fetchLatestData();
                }
            }, 5000); // 5000ms = 5 seconds
        }

        async function fetchLatestData() {
            if (isModalOpen) return;
            
            try {
                const response = await fetch('<?php echo e(url("/api/stencils/latest")); ?>');
                if (!response.ok) throw new Error('Network response was not ok');
                const data = await response.json();
                stencilData = data;
                renderDashboard();
                updateLastUpdated();
            } catch (error) {
                console.error('Auto refresh error:', error);
                // Optional: Show error indicator in UI
                const container = document.getElementById('stencilCardsContainer');
                if (container && !container.innerHTML) {
                    container.innerHTML = '<div class="text-center text-red-500 col-span-3">Error loading data. Please refresh the page.</div>';
                }
            }
        }

        function manualRefresh() {
            if (!isModalOpen) {
                // Show loading state on button
                const refreshBtn = document.querySelector('button[onclick="manualRefresh()"]');
                if (refreshBtn) {
                    const originalHtml = refreshBtn.innerHTML;
                    refreshBtn.innerHTML = '<svg class="w-3 h-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>';
                    refreshBtn.disabled = true;
                    
                    fetchLatestData().finally(() => {
                        refreshBtn.innerHTML = originalHtml;
                        refreshBtn.disabled = false;
                    });
                } else {
                    fetchLatestData();
                }
            }
        }

        function updateLastUpdated() {
            const now = new Date();
            const formatted = now.toLocaleString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            const lastUpdatedEl = document.getElementById('lastUpdated');
            if (lastUpdatedEl) {
                lastUpdatedEl.textContent = `Last updated: ${formatted}`;
            }
        }

        function renderDashboard() {
            const container = document.getElementById('stencilCardsContainer');
            if (!container) return;

            let totalActive = 0;
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
                    const registers = stencilData[line] || [];
                    const activeRegisters = registers.filter(j => j.status !== 'Stand By');
                    const isEmpty = activeRegisters.length === 0;
                    
                    totalActive += activeRegisters.length;
                    
                    html += `
                        <div class="stencil-card bg-white dark:bg-zinc-800 rounded-lg border ${isEmpty ? 'border-l-2 border-l-red-500' : 'border-zinc-200 dark:border-zinc-700'} p-2 cursor-pointer hover:shadow transition-all duration-200"
                             onclick="openStencilModal('${line}')">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <div class="flex items-center gap-1.5 flex-shrink-0">
                                    <span class="font-semibold text-[11px] bg-zinc-100 dark:bg-zinc-700 px-2 py-0.5 rounded-full">${escapeHtml(line)}</span>
                                    ${!isEmpty ? `<span class="text-[10px] font-semibold bg-blue-500 text-white px-1.5 py-0.5 rounded-full">${activeRegisters.length}</span>` : ''}
                                </div>
                                <div class="flex flex-wrap items-center gap-1 flex-1">
                    `;
                    
                    if (activeRegisters.length > 0) {
                        activeRegisters.forEach(jig => {
                            const bgColor = jig.status === 'In Use' ? '#10b981' : '#3b82f6';
                            html += `
                                <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium text-white shadow-sm" style="background: ${bgColor};">
                                    <span>${escapeHtml(jig.register_no)}</span>
                                    ${jig.rack_number ? `<span class="bg-amber-500 px-1 py-0.5 rounded-full text-[9px] font-bold ml-0.5">${escapeHtml(jig.rack_number)}</span>` : ''}
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
            
            container.innerHTML = html;
            
            const totalActiveEl = document.getElementById('totalActive');
            if (totalActiveEl) {
                totalActiveEl.textContent = totalActive;
            }
        }

        function escapeHtml(str) {
            if (!str) return '';
            return String(str).replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        function openStencilModal(line) {
            isModalOpen = true;
            
            const data = stencilData[line] || [];
            const activeData = data.filter(jig => jig.status !== 'Stand By');
            
            document.getElementById('stencilModalTitle').textContent = `Line ${line} - Stencil Details`;
            
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
                            <td style="padding: 0.5rem 0.75rem; font-size: 0.75rem; font-weight: 600;">${escapeHtml(jig.register_no)}</td>
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
                                <button onclick="showNikInput(this, ${jig.id})" style="padding: 0.375rem 0.75rem; background: #3b82f6; color: white; border: none; border-radius: 0.375rem; cursor: pointer; font-size: 0.7rem;">Update</button>
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
            
            document.getElementById('stencilModalBody').innerHTML = html;
            document.getElementById('stencilModal').style.display = 'flex';
        }

        function closeStencilModal() {
            isModalOpen = false;
            document.getElementById('stencilModal').style.display = 'none';
            fetchLatestData(); // Refresh data after closing modal
        }

        function showNikInput(button, id) {
            const row = button.closest('tr');
            if (row.querySelector('.nik-input')) return;
            
            const cell = button.parentElement;
            cell.innerHTML = `
                <div class="flex gap-1 items-center">
                    <input type="text" class="nik-input" placeholder="NIK" style="padding: 0.375rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.7rem; width: 80px;">
                    <button onclick="submitStatus(${id}, this)" style="padding: 0.375rem 0.5rem; background: #10b981; color: white; border: none; border-radius: 0.375rem; cursor: pointer; font-size: 0.7rem;">✓</button>
                    <button onclick="cancelNikInput(this, ${id})" style="padding: 0.375rem 0.5rem; background: #6b7280; color: white; border: none; border-radius: 0.375rem; cursor: pointer; font-size: 0.7rem;">✗</button>
                </div>
            `;
        }

        function cancelNikInput(button, id) {
            const cell = button.closest('td');
            cell.innerHTML = `<button onclick="showNikInput(this, ${id})" style="padding: 0.375rem 0.75rem; background: #3b82f6; color: white; border: none; border-radius: 0.375rem; cursor: pointer; font-size: 0.7rem;">Update</button>`;
        }

        async function submitStatus(id, button) {
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
                    closeStencilModal();
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

        // Clean up interval when page is hidden/closed
        window.addEventListener('beforeunload', function() {
            if (refreshInterval) {
                clearInterval(refreshInterval);
            }
        });

        window.onclick = function(event) {
            const modal = document.getElementById('stencilModal');
            if (event.target === modal) {
                closeStencilModal();
            }
        }
    </script>
    <?php $__env->stopPush(); ?>
</section><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/livewire/mtc/dashboard/stencil-dashboard.blade.php ENDPATH**/ ?>