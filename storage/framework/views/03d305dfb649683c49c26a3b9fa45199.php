<?php # [BlazeFolded]:{flux::breadcrumbs.item}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::breadcrumbs}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/index.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::card}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php}:{1776985208} ?>
<section class="w-full">
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
                    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/breadcrumbs/item.blade.php', $__blaze->compiledPath.'/b843a539037c1542dedc5bd82236e28a.php'); ?>
<?php if (isset($__slotsb843a539037c1542dedc5bd82236e28a)) { $__slotsStackb843a539037c1542dedc5bd82236e28a[] = $__slotsb843a539037c1542dedc5bd82236e28a; } ?>
<?php if (isset($__attrsb843a539037c1542dedc5bd82236e28a)) { $__attrsStackb843a539037c1542dedc5bd82236e28a[] = $__attrsb843a539037c1542dedc5bd82236e28a; } ?>
<?php $__attrsb843a539037c1542dedc5bd82236e28a = ['href' => e(route('mtc.stencil.index')),'wire:navigate' => true,'separator' => 'slash']; ?>
<?php $__slotsb843a539037c1542dedc5bd82236e28a = []; ?>
<?php $__blaze->pushData($__attrsb843a539037c1542dedc5bd82236e28a); ?>
<?php ob_start(); ?>
                        Stencil Management
                    <?php $__slotsb843a539037c1542dedc5bd82236e28a['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slotsb843a539037c1542dedc5bd82236e28a); ?>
<?php _b843a539037c1542dedc5bd82236e28a($__blaze, $__attrsb843a539037c1542dedc5bd82236e28a, $__slotsb843a539037c1542dedc5bd82236e28a, ['wire:navigate'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackb843a539037c1542dedc5bd82236e28a)) { $__slotsb843a539037c1542dedc5bd82236e28a = array_pop($__slotsStackb843a539037c1542dedc5bd82236e28a); } ?>
<?php if (! empty($__attrsStackb843a539037c1542dedc5bd82236e28a)) { $__attrsb843a539037c1542dedc5bd82236e28a = array_pop($__attrsStackb843a539037c1542dedc5bd82236e28a); } ?>
<?php $__blaze->popData(); ?>
                    <?php ob_start(); ?><div class="flex items-center text-sm font-medium group/breadcrumb font-semibold text-blue-600 dark:text-blue-400" data-flux-breadcrumbs-item>
            <div class="text-gray-500 dark:text-white/80">
                            <?php ob_start(); ?>
                        <?php echo e($isEditMode ? 'Edit Stencil' : 'Create Stencil'); ?>

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
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                            <?php echo e($isEditMode ? 'Edit Stencil' : 'Create New Stencil'); ?>

                        </h1>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            <?php echo e($isEditMode ? 'Update stencil information' : 'Add new stencil to inventory'); ?>

                        </p>
                    </div>
                </div>
            </div>
         <?php $__env->endSlot(); ?>

        <div class="mt-4">
            <?php ob_start(); ?><div class="[:where(&amp;)]:bg-white dark:[:where(&amp;)]:bg-white/10 border border-zinc-200 dark:border-white/10 [:where(&amp;)]:p-6 [:where(&amp;)]:rounded-xl p-6" data-flux-card>
    <?php ob_start(); ?>
                <form wire:submit="saveStencil" class="space-y-6">
                    <!-- Basic Information Section -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-gray-200 dark:border-zinc-700">
                            Basic Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Register No <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="register_no" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['register_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Customer <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="customer" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['customer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Category <span class="text-red-500">*</span></label>
                                <select wire:model="category" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                    <option value="">Select Category</option>
                                    <option value="STENCIL">STENCIL</option>
                                    <option value="JIG">JIG</option>
                                    <option value="MACHINE">MACHINE</option>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Tooling Type <span class="text-red-500">*</span></label>
                                <select wire:model="tooling_type" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                    <option value="">Select Tooling Type</option>
                                    <option value="METAL MASK">METAL MASK</option>
                                    <option value="JIG ASSY">JIG ASSY</option>
                                    <option value="SOLDERING JIG">SOLDERING JIG</option>
                                    <option value="COATING JIG">COATING JIG</option>
                                    <option value="ROUTER JIG">ROUTER JIG</option>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['tooling_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Location <span class="text-red-500">*</span></label>
                                <select wire:model="location" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                    <option value="">Select Location</option>
                                    <option value="PROD.1">PROD.1</option>
                                    <option value="PROD.2">PROD.2</option>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Status <span class="text-red-500">*</span></label>
                                <select wire:model="status" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                    <option value="">Select Status</option>
                                    <option value="In Use">In Use</option>
                                    <option value="Prepared">Prepared</option>
                                    <option value="Cleaning">Cleaning</option>
                                    <option value="Stand By">Stand By</option>
                                    <option value="Not in Use">Not in Use</option>
                                    <option value="Damaged">Damaged</option>
                                    <option value="Under Repair">Under Repair</option>
                                    <option value="Disposed">Disposed</option>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Line Name</label>
                                <input type="text" wire:model="line_name" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Rack Number</label>
                                <input type="text" wire:model="rack_number" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Technical Details Section -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-gray-200 dark:border-zinc-700">
                            Technical Details
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Owned By (SEK Cust ID)</label>
                                <input type="text" wire:model="sek_cust_id" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Fabricator</label>
                                <input type="text" wire:model="fabricator" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Model</label>
                                <input type="text" wire:model="model" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Description</label>
                                <input type="text" wire:model="description" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Application</label>
                                <input type="text" wire:model="application" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Pin Quantity</label>
                                <input type="number" wire:model="pin_qty" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Jig Quantity</label>
                                <input type="number" wire:model="jig_qty" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Design By</label>
                                <input type="text" wire:model="design_by" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Results</label>
                                <input type="text" wire:model="results" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Amount Solder</label>
                                <input type="text" wire:model="amount_solder" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Rack</label>
                                <input type="text" wire:model="rack" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Bit Size</label>
                                <input type="text" wire:model="bit_size" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dates Section -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-gray-200 dark:border-zinc-700">
                            Dates
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Received Date</label>
                                <input type="date" wire:model="received_date" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Registration Date</label>
                                <input type="date" wire:model="registration_date" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Qualified Date</label>
                                <input type="datetime-local" wire:model="qualified_date" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Remarks -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Remarks</label>
                        <textarea wire:model="remarks" rows="3" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700"></textarea>
                    </div>

                    <!-- Photos -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Photos</label>
                        <input type="file" wire:model="photo" multiple accept="image/*" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                        <p class="text-xs text-gray-500 mt-1">Max file size: 2MB per file</p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['photo.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($existing_photos && count($existing_photos) > 0): ?>
                            <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $existing_photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $photoPath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="relative group">
                                        <img src="<?php echo e(Storage::url($photoPath)); ?>" class="w-full h-32 object-cover rounded-lg">
                                        <button type="button" wire:click="removePhoto(<?php echo e($index); ?>)" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-zinc-700">
                        <?php ob_start(); ?><a href="<?php echo e(route('mtc.stencil.index')); ?>" data-flux-button="data-flux-button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-800 dark:text-white" wire:navigate="">
        <?php ob_start(); ?>
                            Cancel
                        <?php echo trim(ob_get_clean()); ?>

    </a>
<?php echo ltrim(ob_get_clean()); ?>
                        <?php ob_start(); ?><button type="submit" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] *:transition-opacity [&amp;[disabled]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[disabled]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[disabled]]:pointer-events-none" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" wire:loading.attr="disabled">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>
                            <span wire:loading.remove wire:target="saveStencil">
                                <?php echo e($isEditMode ? 'Update Stencil' : 'Create Stencil'); ?>

                            </span>
                            <span wire:loading wire:target="saveStencil">
                                <svg class="inline w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Saving...
                            </span>
                        <?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
                    </div>
                </form>
            <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
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

    <!-- Notifikasi -->
    <div x-data="{ show: false, message: '', type: 'success' }" 
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
         x-show="show"
         x-transition
         class="fixed bottom-4 right-4 z-50"
         :class="{
             'bg-green-500': type === 'success',
             'bg-red-500': type === 'error',
             'bg-yellow-500': type === 'warning'
         }"
         style="display: none;">
        <div class="text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
            <span x-text="message"></span>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</section><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/livewire/mtc/master/stencil-management/edit.blade.php ENDPATH**/ ?>