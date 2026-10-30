<?php # [BlazeFolded]:{flux::heading}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/heading.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::heading}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/heading.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::subheading}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/subheading.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::text}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/text.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::text}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/text.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::card}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::icon.qr-code}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/qr-code.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::heading}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/heading.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::text}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/text.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::icon.loading}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/loading.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::button}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/button/index.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::icon.loading}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/loading.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::icon.document-duplicate}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/document-duplicate.blade.php}:{1776985208} ?>
<?php # [BlazeFolded]:{flux::icon.check}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/check.blade.php}:{1776985208} ?>
<section class="w-full">
    <?php echo $__env->make('partials.settings-heading', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-sm [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2 sr-only" data-flux-heading><?php ob_start(); ?><?php echo e(__('Security settings')); ?><?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>

    <?php if (isset($component)) { $__componentOriginal951a5936e8413b65cd052beecc1fba57 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal951a5936e8413b65cd052beecc1fba57 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.settings.layout','data' => ['heading' => __('Update password'),'subheading' => __('Ensure your account is using a long, random password to stay secure')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('settings.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Update password')),'subheading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Ensure your account is using a long, random password to stay secure'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <?php ob_start(); ?><div class="[:where(&amp;)]:bg-white dark:[:where(&amp;)]:bg-white/10 border border-zinc-200 dark:border-white/10 [:where(&amp;)]:p-6 [:where(&amp;)]:rounded-xl !p-0 space-y-0 overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300" data-flux-card>
    <?php ob_start(); ?>
            <!-- Password Form -->
            <form method="POST" wire:submit="updatePassword" class="p-6 space-y-6">
                <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/f9ce25dced5c86c906351e8ca96b9cbb.php'); ?>
<?php $__blaze->pushData(['wire:model' => 'current_password','label' => __('Current password'),'type' => 'password','required' => true,'autocomplete' => 'current-password','viewable' => true]); ?>
<?php _f9ce25dced5c86c906351e8ca96b9cbb($__blaze, ['wire:model' => 'current_password','label' => __('Current password'),'type' => 'password','required' => true,'autocomplete' => 'current-password','viewable' => true], [], ['label', 'required', 'viewable'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/f9ce25dced5c86c906351e8ca96b9cbb.php'); ?>
<?php $__blaze->pushData(['wire:model' => 'password','label' => __('New password'),'type' => 'password','required' => true,'autocomplete' => 'new-password','viewable' => true]); ?>
<?php _f9ce25dced5c86c906351e8ca96b9cbb($__blaze, ['wire:model' => 'password','label' => __('New password'),'type' => 'password','required' => true,'autocomplete' => 'new-password','viewable' => true], [], ['label', 'required', 'viewable'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/f9ce25dced5c86c906351e8ca96b9cbb.php'); ?>
<?php $__blaze->pushData(['wire:model' => 'password_confirmation','label' => __('Confirm password'),'type' => 'password','required' => true,'autocomplete' => 'new-password','viewable' => true]); ?>
<?php _f9ce25dced5c86c906351e8ca96b9cbb($__blaze, ['wire:model' => 'password_confirmation','label' => __('Confirm password'),'type' => 'password','required' => true,'autocomplete' => 'new-password','viewable' => true], [], ['label', 'required', 'viewable'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>

                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-end">
                        <?php ob_start(); ?><button type="submit" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] *:transition-opacity [&amp;[disabled]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[disabled]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[disabled]]:pointer-events-none  w-full" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" data-test="update-password-button">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?><?php echo e(__('Save')); ?><?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
                    </div>

                    <?php if (isset($component)) { $__componentOriginala665a74688c74e9ee80d4fedd2b98434 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala665a74688c74e9ee80d4fedd2b98434 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.action-message','data' => ['class' => 'me-3','on' => 'password-updated']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('action-message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'me-3','on' => 'password-updated']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                        <?php echo e(__('Saved.')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala665a74688c74e9ee80d4fedd2b98434)): ?>
<?php $attributes = $__attributesOriginala665a74688c74e9ee80d4fedd2b98434; ?>
<?php unset($__attributesOriginala665a74688c74e9ee80d4fedd2b98434); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala665a74688c74e9ee80d4fedd2b98434)): ?>
<?php $component = $__componentOriginala665a74688c74e9ee80d4fedd2b98434; ?>
<?php unset($__componentOriginala665a74688c74e9ee80d4fedd2b98434); ?>
<?php endif; ?>
                </div>
            </form>

            <!-- Two-Factor Authentication Section -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canManageTwoFactor): ?>
                <div class="border-t border-zinc-200 dark:border-zinc-700 p-6 bg-zinc-50 dark:bg-zinc-800/50">
                    <section class="space-y-6">
                        <div class="space-y-1">
                            <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-sm [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?><?php echo e(__('Two-factor authentication')); ?><?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>
                            <?php ob_start(); ?><div class="text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70" data-flux-subheading>
    <?php ob_start(); ?><?php echo e(__('Manage your two-factor authentication settings')); ?><?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
                        </div>

                        <div class="flex flex-col w-full mx-auto space-y-6 text-sm" wire:cloak>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($twoFactorEnabled): ?>
                                <div class="space-y-4">
                                    <?php ob_start(); ?><p class="[:where(&amp;)]:font-normal [:where(&amp;)]:text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70" data-flux-text ><?php ob_start(); ?>
                                        <?php echo e(__('You will be prompted for a secure, random pin during login, which you can retrieve from the TOTP-supported application on your phone.')); ?>

                                    <?php echo trim(ob_get_clean()); ?></p><?php echo ltrim(ob_get_clean()); ?>

                                    <div class="flex justify-start">
                                        <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500 text-white  shadow-[inset_0px_1px_var(--color-red-500),inset_0px_2px_--theme(--color-white/.15)] dark:shadow-none [[data-flux-button-group]_&amp;]:border-e [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 [[data-flux-button-group]_&amp;]:border-red-600 dark:[[data-flux-button-group]_&amp;]:border-red-900/25 *:transition-opacity [&amp;[data-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-flux-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-loading]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[data-flux-loading]&gt;[data-flux-loading-indicator]]:opacity-100 data-loading:pointer-events-none data-flux-loading:pointer-events-none" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" wire:target="disable" wire:loading.attr="data-flux-loading" wire:click="disable">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>
                                            <?php echo e(__('Disable 2FA')); ?>

                                        <?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
                                    </div>

                                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('settings.two-factor.recovery-codes', ['requiresConfirmation' => $requiresConfirmation]);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3259306314-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
                                </div>
                            <?php else: ?>
                                <div class="space-y-4">
                                    <?php ob_start(); ?><p class="[:where(&amp;)]:font-normal [:where(&amp;)]:text-sm [:where(&amp;)]:text-zinc-400 [:where(&amp;)]:dark:text-white/50" data-flux-text ><?php ob_start(); ?>
                                        <?php echo e(__('When you enable two-factor authentication, you will be prompted for a secure pin during login. This pin can be retrieved from a TOTP-supported application on your phone.')); ?>

                                    <?php echo trim(ob_get_clean()); ?></p><?php echo ltrim(ob_get_clean()); ?>

                                    <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] *:transition-opacity [&amp;[data-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-flux-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-loading]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[data-flux-loading]&gt;[data-flux-loading-indicator]]:opacity-100 data-loading:pointer-events-none data-flux-loading:pointer-events-none" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" wire:target="enable" wire:loading.attr="data-flux-loading" wire:click="enable">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>
                                        <?php echo e(__('Enable 2FA')); ?>

                                    <?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </section>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>

        <!-- Modal (tetap di luar card) -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canManageTwoFactor): ?>
            <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/modal/index.blade.php', $__blaze->compiledPath.'/7a1a584bff1c48ca2ab445608144ce83.php'); ?>
<?php if (isset($__slots7a1a584bff1c48ca2ab445608144ce83)) { $__slotsStack7a1a584bff1c48ca2ab445608144ce83[] = $__slots7a1a584bff1c48ca2ab445608144ce83; } ?>
<?php if (isset($__attrs7a1a584bff1c48ca2ab445608144ce83)) { $__attrsStack7a1a584bff1c48ca2ab445608144ce83[] = $__attrs7a1a584bff1c48ca2ab445608144ce83; } ?>
<?php $__attrs7a1a584bff1c48ca2ab445608144ce83 = ['name' => 'two-factor-setup-modal','class' => 'max-w-md md:min-w-md','@close' => 'closeModal','wire:model' => 'showModal']; ?>
<?php $__slots7a1a584bff1c48ca2ab445608144ce83 = []; ?>
<?php $__blaze->pushData($__attrs7a1a584bff1c48ca2ab445608144ce83); ?>
<?php ob_start(); ?>
                <div class="space-y-6">
                    <div class="flex flex-col items-center space-y-4">
                        <div class="p-0.5 w-auto rounded-full border border-stone-100 dark:border-stone-600 bg-white dark:bg-stone-800 shadow-sm">
                            <div class="p-2.5 rounded-full border border-stone-200 dark:border-stone-600 overflow-hidden bg-stone-100 dark:bg-stone-200 relative">
                                <div class="flex items-stretch absolute inset-0 w-full h-full divide-x [&>div]:flex-1 divide-stone-200 dark:divide-stone-300 justify-around opacity-50">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <div></div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>

                                <div class="flex flex-col items-stretch absolute w-full h-full divide-y [&>div]:flex-1 inset-0 divide-stone-200 dark:divide-stone-300 justify-around opacity-50">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <div></div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>

                                <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 relative z-20 dark:text-accent-foreground" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z"/>
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                            </div>
                        </div>

                        <div class="space-y-2 text-center">
                            <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-base [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?><?php echo e($this->modalConfig['title']); ?><?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>
                            <?php ob_start(); ?><p class="[:where(&amp;)]:font-normal [:where(&amp;)]:text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70" data-flux-text ><?php ob_start(); ?><?php echo e($this->modalConfig['description']); ?><?php echo trim(ob_get_clean()); ?></p><?php echo ltrim(ob_get_clean()); ?>
                        </div>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showVerificationStep): ?>
                        <div class="space-y-6">
                            <div class="flex flex-col items-center space-y-3 justify-center">
                                <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/otp/index.blade.php', $__blaze->compiledPath.'/fac5f31e0d344cf0c75d0ed78270eee2.php'); ?>
<?php $__blaze->pushData(['name' => 'code','wire:model' => 'code','length' => '6','label' => 'OTP Code','label:srOnly' => true,'class' => 'mx-auto']); ?>
<?php _fac5f31e0d344cf0c75d0ed78270eee2($__blaze, ['name' => 'code','wire:model' => 'code','length' => '6','label' => 'OTP Code','label:srOnly' => true,'class' => 'mx-auto'], [], ['label:srOnly'], ['label:srOnly' => 'label:sr-only'], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                            </div>

                            <div class="flex items-center space-x-3">
                                <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-white hover:bg-zinc-50 dark:bg-zinc-700 dark:hover:bg-zinc-600/75 text-zinc-800 dark:text-white border border-zinc-200 hover:border-zinc-200 border-b-zinc-300/80 dark:border-zinc-600 dark:hover:border-zinc-600 shadow-xs [[data-flux-button-group]_&amp;]:border-s-0 [:is([data-flux-button-group]&gt;&amp;:first-child,_[data-flux-button-group]_:first-child&gt;&amp;)]:border-s-[1px] *:transition-opacity [&amp;[data-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-flux-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-loading]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[data-flux-loading]&gt;[data-flux-loading-indicator]]:opacity-100 data-loading:pointer-events-none data-flux-loading:pointer-events-none  flex-1" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" wire:target="resetVerification" wire:loading.attr="data-flux-loading" wire:click="resetVerification">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>
                                    <?php echo e(__('Back')); ?>

                                <?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>

                                <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] *:transition-opacity [&amp;[data-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-flux-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-loading]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[data-flux-loading]&gt;[data-flux-loading-indicator]]:opacity-100 data-loading:pointer-events-none data-flux-loading:pointer-events-none  flex-1" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" wire:target="confirmTwoFactor" wire:loading.attr="data-flux-loading" wire:click="confirmTwoFactor" x-bind:disabled="$wire.code.length < 6">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>
                                    <?php echo e(__('Confirm')); ?>

                                <?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['setupData'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <?php $__blaze->ensureRequired('/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/callout/index.blade.php', $__blaze->compiledPath.'/d599ae08ded28e08a91114dc787298bd.php'); ?>
<?php $__blaze->pushData(['variant' => 'danger','icon' => 'x-circle','heading' => e($message)]); ?>
<?php _d599ae08ded28e08a91114dc787298bd($__blaze, ['variant' => 'danger','icon' => 'x-circle','heading' => e($message)], [], [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <div class="flex justify-center">
                            <div class="relative w-64 overflow-hidden border rounded-lg border-stone-200 dark:border-stone-700 aspect-square">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($qrCodeSvg)): ?>
                                    <div class="absolute inset-0 flex items-center justify-center bg-white dark:bg-stone-700 animate-pulse">
                                        <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
        <?php echo ltrim(ob_get_clean()); ?>
                                    </div>
                                <?php else: ?>
                                <div x-data class="flex items-center justify-center h-full p-4">
                                    <div
                                        class="bg-white p-3 rounded"
                                        :style="($flux.appearance === 'dark' || ($flux.appearance === 'system' && $flux.dark)) ? 'filter: invert(1) brightness(1.5)' : ''"
                                    >
                                            <?php echo $qrCodeSvg; ?>

                                        </div>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        <div>
                            <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)] *:transition-opacity [&amp;[data-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-flux-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-loading]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[data-flux-loading]&gt;[data-flux-loading-indicator]]:opacity-100 data-loading:pointer-events-none data-flux-loading:pointer-events-none  w-full" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" wire:target="showVerificationIfNecessary" wire:loading.attr="data-flux-loading" <?php if (($__blazeAttr = $errors->has('setupData')) !== false && !is_null($__blazeAttr)): ?>disabled="<?php echo e($__blazeAttr === true ? 'disabled' : $__blazeAttr); ?>"<?php endif; unset($__blazeAttr); ?> wire:click="showVerificationIfNecessary">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>
                                <?php echo e($this->modalConfig['buttonText']); ?>

                            <?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
                        </div>

                        <div class="space-y-4">
                            <div class="relative flex items-center justify-center w-full">
                                <div class="absolute inset-0 w-full h-px top-1/2 bg-stone-200 dark:bg-stone-600"></div>
                                <span class="relative px-2 text-sm bg-white dark:bg-stone-800 text-stone-600 dark:text-stone-400">
                                    <?php echo e(__('or, enter the code manually')); ?>

                                </span>
                            </div>

                            <div
                                class="flex items-center space-x-2"
                                x-data="{
                                    copied: false,
                                    async copy() {
                                        try {
                                            await navigator.clipboard.writeText('<?php echo e($manualSetupKey); ?>');
                                            this.copied = true;
                                            setTimeout(() => this.copied = false, 1500);
                                        } catch (e) {
                                            console.warn('Could not copy to clipboard');
                                        }
                                    }
                                }"
                            >
                                <div class="flex items-stretch w-full border rounded-xl dark:border-stone-700">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($manualSetupKey)): ?>
                                        <div class="flex items-center justify-center w-full p-3 bg-stone-100 dark:bg-stone-700">
                                            <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-5 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
        <?php echo ltrim(ob_get_clean()); ?>
                                        </div>
                                    <?php else: ?>
                                        <input
                                            type="text"
                                            readonly
                                            value="<?php echo e($manualSetupKey); ?>"
                                            class="w-full p-3 bg-transparent outline-none text-stone-900 dark:text-stone-100"
                                        />

                                        <button
                                            @click="copy()"
                                            class="px-3 transition-colors border-l cursor-pointer border-stone-200 dark:border-stone-600"
                                        >
                                            <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6" x-show="!copied" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                                            <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 text-green-500" x-show="copied" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php $__slots7a1a584bff1c48ca2ab445608144ce83['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots7a1a584bff1c48ca2ab445608144ce83); ?>
<?php _7a1a584bff1c48ca2ab445608144ce83($__blaze, $__attrs7a1a584bff1c48ca2ab445608144ce83, $__slots7a1a584bff1c48ca2ab445608144ce83, [], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack7a1a584bff1c48ca2ab445608144ce83)) { $__slots7a1a584bff1c48ca2ab445608144ce83 = array_pop($__slotsStack7a1a584bff1c48ca2ab445608144ce83); } ?>
<?php if (! empty($__attrsStack7a1a584bff1c48ca2ab445608144ce83)) { $__attrs7a1a584bff1c48ca2ab445608144ce83 = array_pop($__attrsStack7a1a584bff1c48ca2ab445608144ce83); } ?>
<?php $__blaze->popData(); ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal951a5936e8413b65cd052beecc1fba57)): ?>
<?php $attributes = $__attributesOriginal951a5936e8413b65cd052beecc1fba57; ?>
<?php unset($__attributesOriginal951a5936e8413b65cd052beecc1fba57); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal951a5936e8413b65cd052beecc1fba57)): ?>
<?php $component = $__componentOriginal951a5936e8413b65cd052beecc1fba57; ?>
<?php unset($__componentOriginal951a5936e8413b65cd052beecc1fba57); ?>
<?php endif; ?>
</section><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/livewire/settings/security.blade.php ENDPATH**/ ?>