<?php # [BlazeVersion]:{v3} ?>
<?php # [BlazeFolded]:{flux::label}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/label.blade.php}:{1792593958} ?>
<?php # [BlazeFolded]:{flux::select.option}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/select/option/index.blade.php}:{1792593958} ?>
<?php # [BlazeFolded]:{flux::select}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/select/index.blade.php}:{1792593958} ?>
<?php # [BlazeFolded]:{flux::label}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/label.blade.php}:{1792593958} ?>
<?php # [BlazeFolded]:{flux::textarea}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/textarea.blade.php}:{1792593958} ?>
<?php # [BlazeFolded]:{flux::otp}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/otp/index.blade.php}:{1792593958} ?>

<div x-data="{ open: false }"
    x-on:open-modal-delete.window="open = true"
    x-on:close-modal-delete.window="open = false"
    x-show="open" x-cloak @keydown.escape.window="open = false">

    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40" @click="open = false"></div>

    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">

            
            <div class="bg-gradient-to-r from-red-500 to-rose-600 px-6 py-5 flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-white/20 border border-white/30 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Delete Blind Test</h3>
                    <p class="text-xs text-red-100">This action requires Google Authenticator verification</p>
                </div>
            </div>

            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($blindTestToDelete): ?>
                <div class="p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                    <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold mb-1">Test to be deleted</div>
                    <div class="text-sm font-bold text-zinc-800 dark:text-white">
                        #<?php echo e($blindTestToDelete->id); ?> — <?php echo e($blindTestToDelete->employee->name ?? '-'); ?>

                    </div>
                    <div class="text-xs text-zinc-500 mt-0.5">
                        <?php echo e($blindTestToDelete->employee->nik ?? '-'); ?> · <?php echo e($blindTestToDelete->section); ?>

                    </div>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div>
                    <?php ob_start(); ?><ui-label class="inline-flex items-center text-sm font-medium  [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white [&amp;:has([data-flux-label-trailing])]:flex" required="required" data-flux-label>
    <?php ob_start(); ?>Deletion Reason<?php echo trim(ob_get_clean()); ?>


    
    
    </ui-label>
<?php echo ltrim(ob_get_clean()); ?>
                    <?php ob_start(); ?><?php $__blaze->pushData(['wire:model' => 'deleteReasonCode', 'placeholder' => '-- Select Reason --']); $__env->pushConsumableComponentData(['wire:model' => 'deleteReasonCode', 'placeholder' => '-- Select Reason --']); ?><select
    class="appearance-none [:where(&amp;)]:w-full ps-3 pe-10 block h-10 py-2 text-base sm:text-sm leading-[1.375rem] rounded-lg shadow-xs border bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 dark:text-zinc-300 disabled:text-zinc-500 dark:disabled:text-zinc-400 has-[option.placeholder:checked]:text-zinc-400 dark:has-[option.placeholder:checked]:text-zinc-400 dark:[&amp;_option]:bg-zinc-700 dark:[&amp;_option]:text-white disabled:shadow-none border border-zinc-200 border-b-zinc-300/80 dark:border-white/10" wire:model="deleteReasonCode"
         name="deleteReasonCode"         data-flux-control
    data-flux-select-native
    data-flux-group-target
>
            <option value="" disabled selected class="placeholder">-- Select Reason --</option>
    
    <?php ob_start(); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Models\QAQC\BlindTest\BlindTest::DELETE_REASONS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <?php ob_start(); ?><option
    
     value="<?php echo e($code); ?>"      <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = ''.e($code).''; ?>wire:key="<?php echo e($code); ?>" ><?php ob_start(); ?><?php echo e($label); ?><?php echo trim(ob_get_clean()); ?></option><?php echo ltrim(ob_get_clean()); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php echo trim(ob_get_clean()); ?>

</select>
<?php $__blaze->popData(); $__env->popConsumableComponentData(); ?><?php echo ltrim(ob_get_clean()); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['deleteReasonCode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div>
                    <?php ob_start(); ?><ui-label class="inline-flex items-center text-sm font-medium  [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white [&amp;:has([data-flux-label-trailing])]:flex" data-flux-label>
    <?php ob_start(); ?>Additional Notes <span class="text-zinc-400 font-normal"> (optional)</span><?php echo trim(ob_get_clean()); ?>


    
    
    </ui-label>
<?php echo ltrim(ob_get_clean()); ?>
                    <?php ob_start(); ?><textarea
        class="block p-3 w-full shadow-xs disabled:shadow-none border rounded-lg bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] resize-y  text-base sm:text-sm text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500 border-zinc-200 border-b-zinc-300/80 dark:border-white/10 data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500" wire:model="deleteReason" maxlength="500" placeholder="Additional details..."
        rows="2"
         name="deleteReason"         <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => 'deleteReason',
  'invalid' => false,
); ?>
        <?php if ($scope['invalid'] || ($scope['name'] && $errors->has($scope['name']))): ?>
        aria-invalid="true" data-invalid
        <?php endif; ?>
        <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
        data-flux-control
        data-flux-textarea
    ></textarea>
<?php echo ltrim(ob_get_clean()); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['deleteReason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->is2faEnabled): ?>
                        
                        <div class="flex flex-col items-center justify-center text-center w-full">
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="w-4 h-4 shrink-0" aria-hidden="true">
                                    <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
                                    <path fill="#FF3D00" d="M6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691z"/>
                                    <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0 1 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/>
                                    <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002 6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
                                </svg>
                                Google Authenticator Code <span class="text-red-500">*</span>
                            </span>

                            
                            <div class="flex justify-center w-full my-4">
                                <?php ob_start(); ?><ui-otp
        class="flex items-center gap-2 isolate w-fit [&amp;_[data-flux-input-group]]:w-auto mx-auto" wire:model="deleteOtp" name="deleteOtp" label:sr-only="label:sr-only"
        data-flux-otp
        data-flux-control
        role="group"
        data-flux-input-aria-label="Character {current} of {total}"
    >
                                    <div class="w-full relative block group/input w-8! grow-0 has-focus-within:z-10" data-flux-input>
            
            <input
                type="text"
                
                class="w-full border block disabled:shadow-none dark:shadow-none appearance-none text-base sm:text-sm rounded-lg py-2 h-10 leading-[1.375rem] ps-3 pe-3 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500 shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5 data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500 disabled:data-invalid:border-red-500 dark:disabled:data-invalid:border-red-500 px-0! py-3 text-center disabled:opacity-75 disabled:shadow-xs! dark:disabled:shadow-none!" inputmode="numeric" data-flux-otp-input=""
                                                                <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => NULL,
  'invalid' => false,
); ?>
                <?php if ($scope['invalid'] || ($scope['name'] && $errors->has($scope['name']))): ?>
                aria-invalid="true" data-invalid
                <?php endif; ?>
                <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
                data-flux-control
                data-flux-group-target
                                            >

                    </div>
                            <div class="w-full relative block group/input w-8! grow-0 has-focus-within:z-10" data-flux-input>
            
            <input
                type="text"
                
                class="w-full border block disabled:shadow-none dark:shadow-none appearance-none text-base sm:text-sm rounded-lg py-2 h-10 leading-[1.375rem] ps-3 pe-3 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500 shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5 data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500 disabled:data-invalid:border-red-500 dark:disabled:data-invalid:border-red-500 px-0! py-3 text-center disabled:opacity-75 disabled:shadow-xs! dark:disabled:shadow-none!" inputmode="numeric" data-flux-otp-input=""
                                                                <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => NULL,
  'invalid' => false,
); ?>
                <?php if ($scope['invalid'] || ($scope['name'] && $errors->has($scope['name']))): ?>
                aria-invalid="true" data-invalid
                <?php endif; ?>
                <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
                data-flux-control
                data-flux-group-target
                                            >

                    </div>
                            <div class="w-full relative block group/input w-8! grow-0 has-focus-within:z-10" data-flux-input>
            
            <input
                type="text"
                
                class="w-full border block disabled:shadow-none dark:shadow-none appearance-none text-base sm:text-sm rounded-lg py-2 h-10 leading-[1.375rem] ps-3 pe-3 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500 shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5 data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500 disabled:data-invalid:border-red-500 dark:disabled:data-invalid:border-red-500 px-0! py-3 text-center disabled:opacity-75 disabled:shadow-xs! dark:disabled:shadow-none!" inputmode="numeric" data-flux-otp-input=""
                                                                <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => NULL,
  'invalid' => false,
); ?>
                <?php if ($scope['invalid'] || ($scope['name'] && $errors->has($scope['name']))): ?>
                aria-invalid="true" data-invalid
                <?php endif; ?>
                <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
                data-flux-control
                data-flux-group-target
                                            >

                    </div>
                            <div class="w-full relative block group/input w-8! grow-0 has-focus-within:z-10" data-flux-input>
            
            <input
                type="text"
                
                class="w-full border block disabled:shadow-none dark:shadow-none appearance-none text-base sm:text-sm rounded-lg py-2 h-10 leading-[1.375rem] ps-3 pe-3 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500 shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5 data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500 disabled:data-invalid:border-red-500 dark:disabled:data-invalid:border-red-500 px-0! py-3 text-center disabled:opacity-75 disabled:shadow-xs! dark:disabled:shadow-none!" inputmode="numeric" data-flux-otp-input=""
                                                                <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => NULL,
  'invalid' => false,
); ?>
                <?php if ($scope['invalid'] || ($scope['name'] && $errors->has($scope['name']))): ?>
                aria-invalid="true" data-invalid
                <?php endif; ?>
                <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
                data-flux-control
                data-flux-group-target
                                            >

                    </div>
                            <div class="w-full relative block group/input w-8! grow-0 has-focus-within:z-10" data-flux-input>
            
            <input
                type="text"
                
                class="w-full border block disabled:shadow-none dark:shadow-none appearance-none text-base sm:text-sm rounded-lg py-2 h-10 leading-[1.375rem] ps-3 pe-3 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500 shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5 data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500 disabled:data-invalid:border-red-500 dark:disabled:data-invalid:border-red-500 px-0! py-3 text-center disabled:opacity-75 disabled:shadow-xs! dark:disabled:shadow-none!" inputmode="numeric" data-flux-otp-input=""
                                                                <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => NULL,
  'invalid' => false,
); ?>
                <?php if ($scope['invalid'] || ($scope['name'] && $errors->has($scope['name']))): ?>
                aria-invalid="true" data-invalid
                <?php endif; ?>
                <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
                data-flux-control
                data-flux-group-target
                                            >

                    </div>
                            <div class="w-full relative block group/input w-8! grow-0 has-focus-within:z-10" data-flux-input>
            
            <input
                type="text"
                
                class="w-full border block disabled:shadow-none dark:shadow-none appearance-none text-base sm:text-sm rounded-lg py-2 h-10 leading-[1.375rem] ps-3 pe-3 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500 shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5 data-invalid:shadow-none data-invalid:border-red-500 dark:data-invalid:border-red-500 disabled:data-invalid:border-red-500 dark:disabled:data-invalid:border-red-500 px-0! py-3 text-center disabled:opacity-75 disabled:shadow-xs! dark:disabled:shadow-none!" inputmode="numeric" data-flux-otp-input=""
                                                                <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => NULL,
  'invalid' => false,
); ?>
                <?php if ($scope['invalid'] || ($scope['name'] && $errors->has($scope['name']))): ?>
                aria-invalid="true" data-invalid
                <?php endif; ?>
                <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
                data-flux-control
                data-flux-group-target
                                            >

                    </div>
                        </ui-otp>
<?php echo ltrim(ob_get_clean()); ?>
                            </div>

                            <p class="text-[11px] text-zinc-500 dark:text-zinc-400 text-center">
                                Enter the 6-digit code from your Google Authenticator app.
                            </p>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['deleteOtp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="mt-3 flex items-center justify-center gap-1.5 text-red-500 text-sm text-center">
                                    <span><?php echo e($message); ?></span>
                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                    <?php else: ?>
                        
                        <div class="text-center py-2">
                            <div class="w-10 h-10 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center mx-auto mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-zinc-500 dark:text-zinc-400">
                                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h4 class="text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Google Authenticator Not Enabled</h4>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-4 px-2">
                                You must enable Google Authenticator before you can delete this data.
                            </p>

                            
                            <a href="<?php echo e(route('security.edit')); ?>" wire:navigate
                               class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-800 hover:bg-zinc-900 dark:bg-zinc-200 dark:hover:bg-white dark:text-zinc-900 text-white rounded-lg text-sm font-medium transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd" />
                                </svg>
                                Enable Now
                            </a>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            
            <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-3">
                <button type="button" wire:click="cancelDelete"
                    class="px-4 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg
                        text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800
                        text-sm font-medium transition-colors">
                    Cancel
                </button>
                <button type="button" wire:click="delete" wire:loading.attr="disabled" wire:target="delete"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-red-600 hover:bg-red-700
                        disabled:opacity-50 disabled:cursor-not-allowed
                        text-white rounded-lg text-sm font-medium shadow-lg shadow-red-500/30 transition-colors">
                    <svg wire:loading wire:target="delete" class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="delete">Delete Test</span>
                    <span wire:loading wire:target="delete">Processing...</span>
                </button>
            </div>
        </div>
    </div>
</div><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/livewire/qaqc/blind-test/partials/blind-test-delete-modal.blade.php ENDPATH**/ ?>