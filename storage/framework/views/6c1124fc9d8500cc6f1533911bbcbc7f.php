<?php # [BlazeFolded]:{flux::label}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/label.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::button}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1776934808} ?>

<div x-data="{ open: false }"
    x-on:open-modal-blind-test.window="open = true"
    x-on:close-modal-blind-test.window="open = false"
    x-show="open" x-cloak @keydown.escape.window="open = false">

    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40" @click="open = false"></div>

    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden">

            <!-- Modal Header -->
            <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-6 py-5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white"><?php echo e($modalTitle); ?></h2>
                        <p class="text-xs text-blue-100">Pilih employee & buat test (durasi otomatis 5 menit)</p>
                    </div>
                </div>
                <button type="button" @click="open = false"
                    class="w-9 h-9 rounded-lg bg-white/20 hover:bg-white/30 backdrop-blur-sm border border-white/30 text-white flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="flex-1 overflow-y-auto p-6 bg-zinc-50 dark:bg-zinc-950/30">
                <form wire:submit="save" id="blind-test-form" class="space-y-4">

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedQuestion): ?>
                    <?php
                        $secColors = [
                            'QC'  => 'from-blue-500 to-indigo-600',
                            'SMT' => 'from-green-500 to-emerald-600',
                            'BE'  => 'from-yellow-500 to-orange-600',
                            'MI'  => 'from-purple-500 to-pink-600',
                        ];
                        $gradient = $secColors[$selectedQuestion->section] ?? $secColors['QC'];
                    ?>
                    <div class="bg-gradient-to-r <?php echo e($gradient); ?> rounded-xl p-4 shadow-lg">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                                    <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="text-[10px] text-white/80 uppercase font-bold tracking-wider">Soal Terpilih</div>
                                <div class="text-sm font-bold text-white">#<?php echo e($selectedQuestion->id); ?> — Section <?php echo e($selectedQuestion->section); ?></div>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full bg-white/20 backdrop-blur-sm text-white font-bold">
                                <?php echo e($selectedQuestion->totalDefects()); ?> defect
                            </span>
                        </div>
                        <?php
                            $sqModelNames = $selectedQuestion->models->pluck('model_name')->filter()->values();
                            if ($sqModelNames->isEmpty() && $selectedQuestion->model) {
                                $sqModelNames = collect([$selectedQuestion->model->model_name]);
                            }
                        ?>
                        <div class="text-xs text-white/90 mt-2 flex flex-wrap items-center gap-x-2 gap-y-1">
                            <span><strong>Customer:</strong> <?php echo e($selectedQuestion->customer->customer_name ?? '-'); ?></span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sqModelNames->isNotEmpty()): ?>
                                <span class="text-white/60">·</span>
                                <span class="inline-flex items-center gap-1 flex-wrap">
                                    <strong>Model:</strong>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sqModelNames->count() === 1): ?>
                                        <span><?php echo e($sqModelNames->first()); ?></span>
                                    <?php else: ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $sqModelNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-white/20 backdrop-blur-sm text-white border border-white/30">
                                                <?php echo e($mName); ?>

                                            </span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                        <div class="px-5 py-3.5 border-b border-zinc-200 dark:border-zinc-800 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center">
                                <span class="text-xs font-bold text-white">1</span>
                            </div>
                            <h3 class="text-sm font-bold text-zinc-800 dark:text-white">Section</h3>
                            <span class="ml-auto text-[10px] px-2 py-0.5 rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 font-bold uppercase">Auto-set</span>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                                <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center">
                                    <span class="text-xs font-bold text-white"><?php echo e($section); ?></span>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-zinc-800 dark:text-white"><?php echo e($section); ?></div>
                                    <div class="text-[11px] text-zinc-500 dark:text-zinc-400">Section sudah otomatis dari soal yang dipilih</div>
                                </div>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['section'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs block mt-2"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden"
                        x-data="{
                            pickedId: null,
                            pickedNik: '',
                            pickedName: '',
                            pickedDept: '',
                            search: '',
                            employees: [],
                            loading: false,
                            timeout: null,
                            resetPick() {
                                this.pickedId = null;
                                this.pickedNik = '';
                                this.pickedName = '';
                                this.pickedDept = '';
                                $wire.set('tempShift', '');
                                $wire.set('tempGroup', '');
                            },
                            load() {
                                if (this.search.length < 2) { this.employees = []; return; }
                                clearTimeout(this.timeout);
                                this.timeout = setTimeout(() => {
                                    this.loading = true;
                                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('searchEmployees', this.search).then(r => {
                                        this.employees = r; this.loading = false;
                                    }).catch(() => this.loading = false);
                                }, 300);
                            },
                            pick(emp) {
                                this.pickedId = emp.id;
                                this.pickedNik = emp.nik;
                                this.pickedName = emp.name;
                                this.pickedDept = emp.department;
                                this.employees = [];
                                this.search = '';
                            },
                            async addNow() {
                                if (!this.pickedId) return;
                                await $wire.addEmployee(this.pickedId);
                                this.resetPick();
                                if (this.search.length >= 2) {
                                    this.load();
                                }
                            }
                        }"
                        x-on:employee-added.window="resetPick()">

                        <div class="px-5 py-3.5 border-b border-zinc-200 dark:border-zinc-800 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center shadow-sm shadow-blue-500/30">
                                    <span class="text-xs font-bold text-white">2</span>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-zinc-800 dark:text-white">Pilih Employee</h3>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($section): ?>
                                        <?php
                                            $allowedDepts = match($section) {
                                                'QC'  => 'IQC, QA/QC',
                                                'SMT' => 'PROD.1',
                                                'MI'  => 'PROD.1',
                                                'BE'  => 'PROD.2',
                                                default => '-',
                                            };
                                        ?>
                                        <p class="text-[10px] text-blue-600 dark:text-blue-400">
                                            Department: <strong><?php echo e($allowedDepts); ?></strong>
                                        </p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-semibold">
                                Total: <?php echo e(count($selectedEmployees)); ?>

                            </span>
                        </div>
                        <div class="p-5 space-y-4">

                            
                            <div>
                                <?php ob_start(); ?><ui-label class="inline-flex items-center text-sm font-medium  [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white [&amp;:has([data-flux-label-trailing])]:flex" required="required" data-flux-label>
    <?php ob_start(); ?>1. Cari & Pilih Employee<?php echo trim(ob_get_clean()); ?>


    
    
    </ui-label>
<?php echo ltrim(ob_get_clean()); ?>
                                <div class="relative">
                                    <input type="text" x-model="search" @input="load()"
                                        placeholder="Cari NIK / nama (min 2 huruf)..."
                                        class="w-full pl-10 pr-3 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:text-white text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400">
                                        <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                                    </svg>
                                </div>

                                <div x-show="loading" class="mt-2 p-3 text-center text-sm bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                                    <svg class="animate-spin h-4 w-4 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>

                                <div x-show="!loading && employees.length > 0" class="mt-2 border border-zinc-200 dark:border-zinc-700 rounded-lg max-h-60 overflow-y-auto">
                                    <table class="w-full text-sm">
                                        <thead class="bg-zinc-50 dark:bg-zinc-800 sticky top-0">
                                            <tr>
                                                <th class="px-3 py-2 text-center text-xs font-semibold text-zinc-600">NIK</th>
                                                <th class="px-3 py-2 text-left text-xs font-semibold text-zinc-600">NAME</th>
                                                <th class="px-3 py-2 text-center text-xs font-semibold text-zinc-600">DEPT</th>
                                                <th class="px-3 py-2 text-center text-xs font-semibold text-zinc-600 w-20"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                            <template x-for="emp in employees" :key="emp.id">
                                                <tr :class="emp.already_selected
                                                        ? 'bg-zinc-100 dark:bg-zinc-800/50 opacity-60 cursor-not-allowed'
                                                        : 'hover:bg-blue-50 dark:hover:bg-blue-950/10'">
                                                    <td class="px-3 py-2 text-center font-mono text-xs" x-text="emp.nik"></td>
                                                    <td class="px-3 py-2 text-sm font-medium">
                                                        <span x-text="emp.name"></span>
                                                        <template x-if="emp.already_selected">
                                                            <span class="ml-2 inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 text-[10px] font-semibold">
                                                                Sudah ditambahkan
                                                            </span>
                                                        </template>
                                                    </td>
                                                    <td class="px-3 py-2 text-center text-xs" x-text="emp.department"></td>
                                                    <td class="px-3 py-2 text-center">
                                                        <template x-if="!emp.already_selected">
                                                            <button type="button" @click="pick(emp)"
                                                                class="px-2.5 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium">
                                                                Pilih
                                                            </button>
                                                        </template>
                                                        <template x-if="emp.already_selected">
                                                            <span class="px-2.5 py-1 text-xs bg-zinc-200 dark:bg-zinc-700 text-zinc-500 rounded-md font-medium inline-block">
                                                                Sudah Ada
                                                            </span>
                                                        </template>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            
                            <div x-show="pickedId" x-cloak class="p-4 rounded-xl bg-blue-50 dark:bg-blue-950/20 border-2 border-blue-200 dark:border-blue-800">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm font-bold"
                                            x-text="pickedName.charAt(0).toUpperCase()"></div>
                                        <div>
                                            <div class="text-[10px] text-blue-700 dark:text-blue-400 font-semibold uppercase tracking-wider">Employee Terpilih</div>
                                            <div class="text-sm font-bold text-blue-800 dark:text-blue-300" x-text="pickedNik + ' - ' + pickedName"></div>
                                            <div class="text-xs text-blue-600 dark:text-blue-400" x-text="pickedDept"></div>
                                        </div>
                                    </div>
                                    <button type="button" @click="resetPick()"
                                        class="w-8 h-8 rounded-lg bg-red-100 hover:bg-red-200 text-red-600 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                            <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="grid grid-cols-2 gap-3 mb-3">
                                    <div>
                                        <label class="block text-[11px] font-semibold text-blue-700 dark:text-blue-300 uppercase mb-1">
                                            Shift <span class="text-red-500">*</span>
                                        </label>
                                        <select wire:model="tempShift"
                                            class="w-full border border-blue-300 dark:border-blue-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                                            <option value="">-- Pilih Shift --</option>
                                            <option value="NS">NS</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-blue-700 dark:text-blue-300 uppercase mb-1">
                                            Group <span class="text-red-500">*</span>
                                        </label>
                                        <select wire:model="tempGroup"
                                            class="w-full border border-blue-300 dark:border-blue-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                                            <option value="">-- Pilih Group --</option>
                                            <option value="NS">NS</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                        </select>
                                    </div>
                                </div>

                                <button type="button" @click="addNow()"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed text-white rounded-lg text-sm font-semibold shadow-lg shadow-blue-500/30"
                                    x-bind:disabled="!$wire.tempShift || !$wire.tempGroup">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                        <path d="M12 5.25a.75.75 0 0 1 .75.75v5.25H18a.75.75 0 0 1 0 1.5h-5.25V18a.75.75 0 0 1-1.5 0v-5.25H6a.75.75 0 0 1 0-1.5h5.25V6a.75.75 0 0 1 .75-.75Z" />
                                    </svg>
                                    Tambahkan Employee Ini
                                </button>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['selectedEmployees'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            
                            <div>
                                <div class="text-[11px] font-semibold text-zinc-500 uppercase mb-2">Daftar Employee (<?php echo e(count($selectedEmployees)); ?>)</div>
                                <div class="border rounded-lg overflow-hidden dark:border-zinc-700">
                                    <table class="w-full text-sm">
                                        <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                                            <tr>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 uppercase w-10">#</th>
                                                <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 uppercase">NIK</th>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 uppercase">Name</th>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 uppercase">Department</th>
                                                <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 uppercase">Shift</th>
                                                <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 uppercase">Group</th>
                                                <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 uppercase w-20">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $selectedEmployees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'emp-'.e($i).''; ?>wire:key="emp-<?php echo e($i); ?>">
                                                <td class="px-3 py-2 text-zinc-500"><?php echo e($i + 1); ?></td>
                                                <td class="px-3 py-2 text-center font-mono text-xs"><?php echo e($emp['nik']); ?></td>
                                                <td class="px-3 py-2 font-medium text-zinc-800 dark:text-white"><?php echo e($emp['name']); ?></td>
                                                <td class="px-3 py-2 text-xs"><?php echo e($emp['department']); ?></td>
                                                <td class="px-3 py-2 text-center">
                                                    <span class="inline-flex px-2 py-0.5 rounded text-xs font-semibold bg-blue-100 text-blue-700">
                                                        <?php echo e($emp['shift'] ?: '-'); ?>

                                                    </span>
                                                </td>
                                                <td class="px-3 py-2 text-center">
                                                    <span class="inline-flex px-2 py-0.5 rounded text-xs font-semibold bg-blue-100 text-blue-700">
                                                        <?php echo e($emp['group'] ?: '-'); ?>

                                                    </span>
                                                </td>
                                                <td class="px-3 py-2 text-center">
                                                    <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-8 text-sm rounded-md w-8 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] *:transition-opacity [&amp;[data-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-flux-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-loading]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[data-flux-loading]&gt;[data-flux-loading-indicator]]:opacity-100 data-loading:pointer-events-none data-flux-loading:pointer-events-none [--color-accent:var(--color-red-500)] [--color-accent-content:var(--color-red-600)] [--color-accent-foreground:var(--color-white)] dark:[--color-accent:var(--color-red-500)] dark:[--color-accent-content:var(--color-red-400)] dark:[--color-accent-foreground:var(--color-white)] !p-2" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" wire:target="removeEmployee(<?php echo e($i); ?>)" wire:loading.attr="data-flux-loading" wire:click="removeEmployee(<?php echo e($i); ?>)">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-5 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
                    <svg class="shrink-0 [:where(&amp;)]:size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd"/>
</svg>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
                                                </td>
                                            </tr>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                            <tr>
                                                <td colspan="7" class="px-3 py-6 text-center text-xs text-zinc-400 italic">
                                                    Belum ada employee dipilih.
                                                </td>
                                            </tr>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                        <div class="px-5 py-3.5 border-b border-zinc-200 dark:border-zinc-800 bg-gradient-to-r from-cyan-50 to-blue-50 dark:from-cyan-950/30 dark:to-blue-950/30 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-cyan-600 flex items-center justify-center shadow-sm shadow-cyan-500/30">
                                <span class="text-xs font-bold text-white">3</span>
                            </div>
                            <h3 class="text-sm font-bold text-zinc-800 dark:text-white">Durasi Pengerjaan</h3>
                            <span class="ml-auto text-[10px] px-2 py-0.5 rounded-full bg-cyan-100 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-400 font-bold uppercase">Fixed</span>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-4 p-4 rounded-xl bg-cyan-50 dark:bg-cyan-950/20 border-2 border-cyan-200 dark:border-cyan-800">
                                <div>
                                    <div class="text-sm font-bold text-cyan-800 dark:text-cyan-300">5 Menit</div>
                                    <div class="text-xs text-cyan-600 dark:text-cyan-400">
                                        Durasi otomatis 5 menit. Test akan close sendiri saat waktu habis.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 flex justify-end gap-3">
                <button type="button" @click="open = false"
                    class="px-5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 text-sm font-medium">
                    Cancel
                </button>
                <button type="submit" form="blind-test-form"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm font-medium shadow-lg shadow-blue-500/30"
                    wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">
                        <?php echo e($blind_test_id ? 'Update' : 'Create ' . count($selectedEmployees) . ' Test'); ?>

                    </span>
                    <span wire:loading wire:target="save">Processing...</span>
                </button>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\siix-portal\resources\views/livewire/qaqc/blind-test/partials/blind-test-form-modal.blade.php ENDPATH**/ ?>