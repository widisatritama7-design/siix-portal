<?php # [BlazeFolded]:{flux::label}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/label.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::label}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/label.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1774988736} ?>
<?php if (isset($component)) { $__componentOriginal08b8a564843783787e0bee3357e24f38 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal08b8a564843783787e0bee3357e24f38 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::auth','data' => ['title' => __('Log in')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::auth'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Log in'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <div class="flex flex-col gap-6">
        <?php if (isset($component)) { $__componentOriginale5d2f2831f58fdbe96ad6d7cbd41a7dd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale5d2f2831f58fdbe96ad6d7cbd41a7dd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-header','data' => ['title' => __('Log in to your account'),'description' => __('Enter your NIK and password below to log in')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Log in to your account')),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Enter your NIK and password below to log in'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale5d2f2831f58fdbe96ad6d7cbd41a7dd)): ?>
<?php $attributes = $__attributesOriginale5d2f2831f58fdbe96ad6d7cbd41a7dd; ?>
<?php unset($__attributesOriginale5d2f2831f58fdbe96ad6d7cbd41a7dd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale5d2f2831f58fdbe96ad6d7cbd41a7dd)): ?>
<?php $component = $__componentOriginale5d2f2831f58fdbe96ad6d7cbd41a7dd; ?>
<?php unset($__componentOriginale5d2f2831f58fdbe96ad6d7cbd41a7dd); ?>
<?php endif; ?>

        <!-- Session Status -->
        <?php if (isset($component)) { $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-session-status','data' => ['class' => 'text-center','status' => session('status')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-session-status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-center','status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('status'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5)): ?>
<?php $attributes = $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5; ?>
<?php unset($__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5)): ?>
<?php $component = $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5; ?>
<?php unset($__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5); ?>
<?php endif; ?>

        <!-- Global Error Alert -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
            <div class="p-3 rounded-lg bg-red-100 text-red-700 text-sm text-center">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
            <div class="p-3 rounded-lg bg-red-100 text-red-700 text-sm text-center">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <form method="POST" action="<?php echo e(route('login.store')); ?>" class="flex flex-col gap-6">
            <?php echo csrf_field(); ?>

            <!-- NIK - Menggunakan number dengan styling -->
            <div>
                <?php ob_start(); ?><ui-label class="inline-flex items-center text-sm font-medium  [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white [&amp;:has([data-flux-label-trailing])]:flex" data-flux-label>
    <?php ob_start(); ?><?php echo e(__('NIK')); ?><?php echo trim(ob_get_clean()); ?>


    
    
    </ui-label>
<?php echo ltrim(ob_get_clean()); ?>
                <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/f9ce25dced5c86c906351e8ca96b9cbb.php'); ?>
<?php $__blaze->pushData(['name' => 'nik','type' => 'number','value' => old('nik'),'required' => true,'autofocus' => true,'autocomplete' => 'username','placeholder' => 'Enter your NIK','class' => '[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none']); ?>
<?php _f9ce25dced5c86c906351e8ca96b9cbb($__blaze, ['name' => 'nik','type' => 'number','value' => old('nik'),'required' => true,'autofocus' => true,'autocomplete' => 'username','placeholder' => 'Enter your NIK','class' => '[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none'], [], ['value', 'required', 'autofocus'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/45fa38eb209539e920cc7a41bee21c5b.php'); ?>
<?php if (isset($__slots45fa38eb209539e920cc7a41bee21c5b)) { $__slotsStack45fa38eb209539e920cc7a41bee21c5b[] = $__slots45fa38eb209539e920cc7a41bee21c5b; } ?>
<?php if (isset($__attrs45fa38eb209539e920cc7a41bee21c5b)) { $__attrsStack45fa38eb209539e920cc7a41bee21c5b[] = $__attrs45fa38eb209539e920cc7a41bee21c5b; } ?>
<?php $__attrs45fa38eb209539e920cc7a41bee21c5b = []; ?>
<?php $__slots45fa38eb209539e920cc7a41bee21c5b = []; ?>
<?php $__blaze->pushData($__attrs45fa38eb209539e920cc7a41bee21c5b); ?>
<?php ob_start(); ?><?php echo e($message); ?><?php $__slots45fa38eb209539e920cc7a41bee21c5b['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots45fa38eb209539e920cc7a41bee21c5b); ?>
<?php _45fa38eb209539e920cc7a41bee21c5b($__blaze, $__attrs45fa38eb209539e920cc7a41bee21c5b, $__slots45fa38eb209539e920cc7a41bee21c5b, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack45fa38eb209539e920cc7a41bee21c5b)) { $__slots45fa38eb209539e920cc7a41bee21c5b = array_pop($__slotsStack45fa38eb209539e920cc7a41bee21c5b); } ?>
<?php if (! empty($__attrsStack45fa38eb209539e920cc7a41bee21c5b)) { $__attrs45fa38eb209539e920cc7a41bee21c5b = array_pop($__attrsStack45fa38eb209539e920cc7a41bee21c5b); } ?>
<?php $__blaze->popData(); ?>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Password -->
            <div class="relative">
                <?php ob_start(); ?><ui-label class="inline-flex items-center text-sm font-medium  [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white [&amp;:has([data-flux-label-trailing])]:flex" data-flux-label>
    <?php ob_start(); ?><?php echo e(__('Password')); ?><?php echo trim(ob_get_clean()); ?>


    
    
    </ui-label>
<?php echo ltrim(ob_get_clean()); ?>
                <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/f9ce25dced5c86c906351e8ca96b9cbb.php'); ?>
<?php $__blaze->pushData(['name' => 'password','type' => 'password','required' => true,'autocomplete' => 'current-password','placeholder' => e(__('Password')),'viewable' => true]); ?>
<?php _f9ce25dced5c86c906351e8ca96b9cbb($__blaze, ['name' => 'password','type' => 'password','required' => true,'autocomplete' => 'current-password','placeholder' => e(__('Password')),'viewable' => true], [], ['required', 'viewable'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/45fa38eb209539e920cc7a41bee21c5b.php'); ?>
<?php if (isset($__slots45fa38eb209539e920cc7a41bee21c5b)) { $__slotsStack45fa38eb209539e920cc7a41bee21c5b[] = $__slots45fa38eb209539e920cc7a41bee21c5b; } ?>
<?php if (isset($__attrs45fa38eb209539e920cc7a41bee21c5b)) { $__attrsStack45fa38eb209539e920cc7a41bee21c5b[] = $__attrs45fa38eb209539e920cc7a41bee21c5b; } ?>
<?php $__attrs45fa38eb209539e920cc7a41bee21c5b = []; ?>
<?php $__slots45fa38eb209539e920cc7a41bee21c5b = []; ?>
<?php $__blaze->pushData($__attrs45fa38eb209539e920cc7a41bee21c5b); ?>
<?php ob_start(); ?><?php echo e($message); ?><?php $__slots45fa38eb209539e920cc7a41bee21c5b['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots45fa38eb209539e920cc7a41bee21c5b); ?>
<?php _45fa38eb209539e920cc7a41bee21c5b($__blaze, $__attrs45fa38eb209539e920cc7a41bee21c5b, $__slots45fa38eb209539e920cc7a41bee21c5b, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack45fa38eb209539e920cc7a41bee21c5b)) { $__slots45fa38eb209539e920cc7a41bee21c5b = array_pop($__slotsStack45fa38eb209539e920cc7a41bee21c5b); } ?>
<?php if (! empty($__attrsStack45fa38eb209539e920cc7a41bee21c5b)) { $__attrs45fa38eb209539e920cc7a41bee21c5b = array_pop($__attrsStack45fa38eb209539e920cc7a41bee21c5b); } ?>
<?php $__blaze->popData(); ?>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Remember Me -->
            <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/checkbox/index.blade.php', $__blaze->compiledPath.'/6d17f94b371e434eaa788136b24e167e.php'); ?>
<?php $__blaze->pushData(['name' => 'remember','label' => __('Remember me'),'checked' => old('remember')]); ?>
<?php _6d17f94b371e434eaa788136b24e167e($__blaze, ['name' => 'remember','label' => __('Remember me'),'checked' => old('remember')], [], ['label', 'checked'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>

            <div class="flex flex-col gap-4">
                <?php ob_start(); ?><button type="submit" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] *:transition-opacity [&amp;[disabled]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[disabled]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[disabled]]:pointer-events-none  w-full" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" data-test="login-button">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>
                    <?php echo e(__('Log in')); ?>

                <?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
            </div>
        </form>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal08b8a564843783787e0bee3357e24f38)): ?>
<?php $attributes = $__attributesOriginal08b8a564843783787e0bee3357e24f38; ?>
<?php unset($__attributesOriginal08b8a564843783787e0bee3357e24f38); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal08b8a564843783787e0bee3357e24f38)): ?>
<?php $component = $__componentOriginal08b8a564843783787e0bee3357e24f38; ?>
<?php unset($__componentOriginal08b8a564843783787e0bee3357e24f38); ?>
<?php endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/livewire/auth/login.blade.php ENDPATH**/ ?>