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
                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/label.blade.php', $__blaze->compiledPath.'/6e3df0cbb45590d4e257d5a3f5651198.php'); ?>
<?php if (isset($__slots6e3df0cbb45590d4e257d5a3f5651198)) { $__slotsStack6e3df0cbb45590d4e257d5a3f5651198[] = $__slots6e3df0cbb45590d4e257d5a3f5651198; } ?>
<?php if (isset($__attrs6e3df0cbb45590d4e257d5a3f5651198)) { $__attrsStack6e3df0cbb45590d4e257d5a3f5651198[] = $__attrs6e3df0cbb45590d4e257d5a3f5651198; } ?>
<?php $__attrs6e3df0cbb45590d4e257d5a3f5651198 = []; ?>
<?php $__slots6e3df0cbb45590d4e257d5a3f5651198 = []; ?>
<?php $__blaze->pushData($__attrs6e3df0cbb45590d4e257d5a3f5651198); ?>
<?php ob_start(); ?><?php echo e(__('NIK')); ?><?php $__slots6e3df0cbb45590d4e257d5a3f5651198['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots6e3df0cbb45590d4e257d5a3f5651198); ?>
<?php _6e3df0cbb45590d4e257d5a3f5651198($__blaze, $__attrs6e3df0cbb45590d4e257d5a3f5651198, $__slots6e3df0cbb45590d4e257d5a3f5651198, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack6e3df0cbb45590d4e257d5a3f5651198)) { $__slots6e3df0cbb45590d4e257d5a3f5651198 = array_pop($__slotsStack6e3df0cbb45590d4e257d5a3f5651198); } ?>
<?php if (! empty($__attrsStack6e3df0cbb45590d4e257d5a3f5651198)) { $__attrs6e3df0cbb45590d4e257d5a3f5651198 = array_pop($__attrsStack6e3df0cbb45590d4e257d5a3f5651198); } ?>
<?php $__blaze->popData(); ?>
                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/5ae551d98c08f0bc67bd05455e08306c.php'); ?>
<?php $__blaze->pushData(['name' => 'nik','type' => 'number','value' => old('nik'),'required' => true,'autofocus' => true,'autocomplete' => 'username','placeholder' => 'Enter your NIK','class' => '[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none']); ?>
<?php _5ae551d98c08f0bc67bd05455e08306c($__blaze, ['name' => 'nik','type' => 'number','value' => old('nik'),'required' => true,'autofocus' => true,'autocomplete' => 'username','placeholder' => 'Enter your NIK','class' => '[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none'], [], ['value', 'required', 'autofocus'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/3559abad7aa305aa719d924dc49d3610.php'); ?>
<?php if (isset($__slots3559abad7aa305aa719d924dc49d3610)) { $__slotsStack3559abad7aa305aa719d924dc49d3610[] = $__slots3559abad7aa305aa719d924dc49d3610; } ?>
<?php if (isset($__attrs3559abad7aa305aa719d924dc49d3610)) { $__attrsStack3559abad7aa305aa719d924dc49d3610[] = $__attrs3559abad7aa305aa719d924dc49d3610; } ?>
<?php $__attrs3559abad7aa305aa719d924dc49d3610 = []; ?>
<?php $__slots3559abad7aa305aa719d924dc49d3610 = []; ?>
<?php $__blaze->pushData($__attrs3559abad7aa305aa719d924dc49d3610); ?>
<?php ob_start(); ?><?php echo e($message); ?><?php $__slots3559abad7aa305aa719d924dc49d3610['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3559abad7aa305aa719d924dc49d3610); ?>
<?php _3559abad7aa305aa719d924dc49d3610($__blaze, $__attrs3559abad7aa305aa719d924dc49d3610, $__slots3559abad7aa305aa719d924dc49d3610, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3559abad7aa305aa719d924dc49d3610)) { $__slots3559abad7aa305aa719d924dc49d3610 = array_pop($__slotsStack3559abad7aa305aa719d924dc49d3610); } ?>
<?php if (! empty($__attrsStack3559abad7aa305aa719d924dc49d3610)) { $__attrs3559abad7aa305aa719d924dc49d3610 = array_pop($__attrsStack3559abad7aa305aa719d924dc49d3610); } ?>
<?php $__blaze->popData(); ?>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Password -->
            <div class="relative">
                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/label.blade.php', $__blaze->compiledPath.'/6e3df0cbb45590d4e257d5a3f5651198.php'); ?>
<?php if (isset($__slots6e3df0cbb45590d4e257d5a3f5651198)) { $__slotsStack6e3df0cbb45590d4e257d5a3f5651198[] = $__slots6e3df0cbb45590d4e257d5a3f5651198; } ?>
<?php if (isset($__attrs6e3df0cbb45590d4e257d5a3f5651198)) { $__attrsStack6e3df0cbb45590d4e257d5a3f5651198[] = $__attrs6e3df0cbb45590d4e257d5a3f5651198; } ?>
<?php $__attrs6e3df0cbb45590d4e257d5a3f5651198 = []; ?>
<?php $__slots6e3df0cbb45590d4e257d5a3f5651198 = []; ?>
<?php $__blaze->pushData($__attrs6e3df0cbb45590d4e257d5a3f5651198); ?>
<?php ob_start(); ?><?php echo e(__('Password')); ?><?php $__slots6e3df0cbb45590d4e257d5a3f5651198['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots6e3df0cbb45590d4e257d5a3f5651198); ?>
<?php _6e3df0cbb45590d4e257d5a3f5651198($__blaze, $__attrs6e3df0cbb45590d4e257d5a3f5651198, $__slots6e3df0cbb45590d4e257d5a3f5651198, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack6e3df0cbb45590d4e257d5a3f5651198)) { $__slots6e3df0cbb45590d4e257d5a3f5651198 = array_pop($__slotsStack6e3df0cbb45590d4e257d5a3f5651198); } ?>
<?php if (! empty($__attrsStack6e3df0cbb45590d4e257d5a3f5651198)) { $__attrs6e3df0cbb45590d4e257d5a3f5651198 = array_pop($__attrsStack6e3df0cbb45590d4e257d5a3f5651198); } ?>
<?php $__blaze->popData(); ?>
                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/5ae551d98c08f0bc67bd05455e08306c.php'); ?>
<?php $__blaze->pushData(['name' => 'password','type' => 'password','required' => true,'autocomplete' => 'current-password','placeholder' => e(__('Password')),'viewable' => true]); ?>
<?php _5ae551d98c08f0bc67bd05455e08306c($__blaze, ['name' => 'password','type' => 'password','required' => true,'autocomplete' => 'current-password','placeholder' => e(__('Password')),'viewable' => true], [], ['required', 'viewable'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/error.blade.php', $__blaze->compiledPath.'/3559abad7aa305aa719d924dc49d3610.php'); ?>
<?php if (isset($__slots3559abad7aa305aa719d924dc49d3610)) { $__slotsStack3559abad7aa305aa719d924dc49d3610[] = $__slots3559abad7aa305aa719d924dc49d3610; } ?>
<?php if (isset($__attrs3559abad7aa305aa719d924dc49d3610)) { $__attrsStack3559abad7aa305aa719d924dc49d3610[] = $__attrs3559abad7aa305aa719d924dc49d3610; } ?>
<?php $__attrs3559abad7aa305aa719d924dc49d3610 = []; ?>
<?php $__slots3559abad7aa305aa719d924dc49d3610 = []; ?>
<?php $__blaze->pushData($__attrs3559abad7aa305aa719d924dc49d3610); ?>
<?php ob_start(); ?><?php echo e($message); ?><?php $__slots3559abad7aa305aa719d924dc49d3610['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3559abad7aa305aa719d924dc49d3610); ?>
<?php _3559abad7aa305aa719d924dc49d3610($__blaze, $__attrs3559abad7aa305aa719d924dc49d3610, $__slots3559abad7aa305aa719d924dc49d3610, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3559abad7aa305aa719d924dc49d3610)) { $__slots3559abad7aa305aa719d924dc49d3610 = array_pop($__slotsStack3559abad7aa305aa719d924dc49d3610); } ?>
<?php if (! empty($__attrsStack3559abad7aa305aa719d924dc49d3610)) { $__attrs3559abad7aa305aa719d924dc49d3610 = array_pop($__attrsStack3559abad7aa305aa719d924dc49d3610); } ?>
<?php $__blaze->popData(); ?>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Remember Me -->
            <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/checkbox/index.blade.php', $__blaze->compiledPath.'/31a9ed35077ed656460ba3cb3d350b2b.php'); ?>
<?php $__blaze->pushData(['name' => 'remember','label' => __('Remember me'),'checked' => old('remember')]); ?>
<?php _31a9ed35077ed656460ba3cb3d350b2b($__blaze, ['name' => 'remember','label' => __('Remember me'),'checked' => old('remember')], [], ['label', 'checked'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>

            <div class="flex flex-col gap-4">
                <?php $__blaze->ensureRequired('/www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php', $__blaze->compiledPath.'/487eed12f4c62537fd888f693822b25a.php'); ?>
<?php if (isset($__slots487eed12f4c62537fd888f693822b25a)) { $__slotsStack487eed12f4c62537fd888f693822b25a[] = $__slots487eed12f4c62537fd888f693822b25a; } ?>
<?php if (isset($__attrs487eed12f4c62537fd888f693822b25a)) { $__attrsStack487eed12f4c62537fd888f693822b25a[] = $__attrs487eed12f4c62537fd888f693822b25a; } ?>
<?php $__attrs487eed12f4c62537fd888f693822b25a = ['variant' => 'primary','type' => 'submit','class' => 'w-full','dataTest' => 'login-button']; ?>
<?php $__slots487eed12f4c62537fd888f693822b25a = []; ?>
<?php $__blaze->pushData($__attrs487eed12f4c62537fd888f693822b25a); ?>
<?php ob_start(); ?>
                    <?php echo e(__('Log in')); ?>

                <?php $__slots487eed12f4c62537fd888f693822b25a['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots487eed12f4c62537fd888f693822b25a); ?>
<?php _487eed12f4c62537fd888f693822b25a($__blaze, $__attrs487eed12f4c62537fd888f693822b25a, $__slots487eed12f4c62537fd888f693822b25a, [], ['dataTest' => 'data-test'], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack487eed12f4c62537fd888f693822b25a)) { $__slots487eed12f4c62537fd888f693822b25a = array_pop($__slotsStack487eed12f4c62537fd888f693822b25a); } ?>
<?php if (! empty($__attrsStack487eed12f4c62537fd888f693822b25a)) { $__attrs487eed12f4c62537fd888f693822b25a = array_pop($__attrsStack487eed12f4c62537fd888f693822b25a); } ?>
<?php $__blaze->popData(); ?>
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
<?php endif; ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/resources/views/livewire/auth/login.blade.php ENDPATH**/ ?>