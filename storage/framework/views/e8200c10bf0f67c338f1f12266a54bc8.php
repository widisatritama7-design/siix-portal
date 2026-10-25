<?php # [BlazeFolded]:{flux::heading}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::icon}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::heading}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::text}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/text.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::card}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/card/index.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::heading}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::text}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/text.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::button}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::text}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/text.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::card}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/card/index.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::heading}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::text}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/text.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::icon}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::heading}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::text}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/text.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::text}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/text.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::button}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::icon}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::heading}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::text}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/text.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::card}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/card/index.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::heading}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::text}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/text.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::spacer}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/spacer.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::button}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::button}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/button/index.blade.php}:{1776934808} ?>
<?php # [BlazeFolded]:{flux::modal}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/modal/index.blade.php}:{1776934808} ?>
<section class="w-full">
    <?php echo $__env->make('partials.settings-heading', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-sm [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2 sr-only" data-flux-heading><?php ob_start(); ?>
        <?php echo e(__('Passkey settings')); ?>

    <?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>

    <?php if (isset($component)) { $__componentOriginal951a5936e8413b65cd052beecc1fba57 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal951a5936e8413b65cd052beecc1fba57 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.settings.layout','data' => ['heading' => __('Passkey'),'subheading' => __('Manage passkeys for passwordless login')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('settings.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Passkey')),'subheading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Manage passkeys for passwordless login'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <div class="space-y-6">

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status')): ?>
                <div class="p-3 rounded-lg bg-green-100 text-green-700 text-sm text-center dark:bg-green-900/30 dark:text-green-400">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php ob_start(); ?><div class="[:where(&amp;)]:bg-white dark:[:where(&amp;)]:bg-white/10 border border-zinc-200 dark:border-white/10 [:where(&amp;)]:p-6 [:where(&amp;)]:rounded-xl space-y-3" data-flux-card>
    <?php ob_start(); ?>
                <div class="flex items-start gap-3">
                    <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 mt-1 size-6 text-green-600" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>

                    <div class="space-y-1">
                        <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-base [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>
                            <?php echo e(__('Secure Login')); ?>

                        <?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>

                        <?php ob_start(); ?><p class="[:where(&amp;)]:font-normal [:where(&amp;)]:text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70" data-flux-text ><?php ob_start(); ?>
                            <?php echo e(__('Gunakan passkey untuk login tanpa perlu memasukkan NIK dan password. Autentikasi dapat menggunakan sidik jari, pengenalan wajah, atau PIN perangkat.')); ?>

                        <?php echo trim(ob_get_clean()); ?></p><?php echo ltrim(ob_get_clean()); ?>
                    </div>
                </div>
            <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>

            
            <?php ob_start(); ?><div class="[:where(&amp;)]:bg-white dark:[:where(&amp;)]:bg-white/10 border border-zinc-200 dark:border-white/10 [:where(&amp;)]:p-6 [:where(&amp;)]:rounded-xl space-y-5" data-flux-card>
    <?php ob_start(); ?>
                <div>
                    <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-base [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>
                        <?php echo e(__('Register New Passkey')); ?>

                    <?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>

                    <?php ob_start(); ?><p class="[:where(&amp;)]:font-normal [:where(&amp;)]:text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70 mt-1" data-flux-text ><?php ob_start(); ?>
                        <?php echo e(__('Daftarkan perangkat baru untuk akun Anda.')); ?>

                    <?php echo trim(ob_get_clean()); ?></p><?php echo ltrim(ob_get_clean()); ?>
                </div>

                <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/input/index.blade.php', $__blaze->compiledPath.'/dd12a05aa7b5fa29d2711a1835ffe960.php'); ?>
<?php $__blaze->pushData(['id' => 'passkey-name','label' => __('Passkey Name'),'placeholder' => 'Contoh: Laptop Kantor','value' => 'Perangkat Saya']); ?>
<?php _dd12a05aa7b5fa29d2711a1835ffe960($__blaze, ['id' => 'passkey-name','label' => __('Passkey Name'),'placeholder' => 'Contoh: Laptop Kantor','value' => 'Perangkat Saya'], [], ['label'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?>

                <div
                    x-data="{
                        busy: false,
                        message: '',
                        isError: false,
                        async register() {
                            if (!window.registerPasskey) {
                                this.message = 'Passkey module belum siap. Coba refresh halaman.';
                                this.isError = true;
                                return;
                            }
                            this.busy = true;
                            this.message = '';
                            try {
                                const name = document.getElementById('passkey-name').value.trim() || 'Perangkat Saya';
                                await window.registerPasskey(name);
                                this.message = 'Passkey berhasil didaftarkan.';
                                this.isError = false;
                                setTimeout(() => window.location.reload(), 800);
                            } catch (e) {
                                console.error(e);
                                this.message = e?.message || 'Pendaftaran passkey gagal atau dibatalkan.';
                                this.isError = true;
                            } finally {
                                this.busy = false;
                            }
                        }
                    }"
                >
                    <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-3 pe-4 inline-flex  bg-[var(--color-accent)] hover:bg-[color-mix(in_oklab,_var(--color-accent),_transparent_10%)] text-[var(--color-accent-foreground)] border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] [[data-flux-button-group]_&amp;]:border-e-0 [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-[1px] dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 dark:[:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-s-[1px] [:is([data-flux-button-group]&gt;&amp;:not(:first-child),_[data-flux-button-group]_:not(:first-child)&gt;&amp;)]:border-s-[color-mix(in_srgb,var(--color-accent-foreground),transparent_85%)]" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" x-on:click="register()" x-bind:disabled="busy">
        <svg class="shrink-0 [:where(&amp;)]:size-4" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path fill-rule="evenodd" d="M8 3c-.988 0-1.908.286-2.682.78a.75.75 0 0 1-.806-1.266A6.5 6.5 0 0 1 14.5 8c0 1.665-.333 3.254-.936 4.704a.75.75 0 0 1-1.385-.577C12.708 10.857 13 9.464 13 8a5 5 0 0 0-5-5ZM3.55 4.282a.75.75 0 0 1 .23 1.036A4.973 4.973 0 0 0 3 8a.75.75 0 0 1-1.5 0c0-1.282.372-2.48 1.014-3.488a.75.75 0 0 1 1.036-.23ZM8 5.875A2.125 2.125 0 0 0 5.875 8a3.625 3.625 0 0 1-3.625 3.625H2.213a.75.75 0 1 1 .008-1.5h.03A2.125 2.125 0 0 0 4.376 8a3.625 3.625 0 1 1 7.25 0c0 .078-.001.156-.003.233a.75.75 0 1 1-1.5-.036c.002-.066.003-.131.003-.197A2.125 2.125 0 0 0 8 5.875ZM7.995 7.25a.75.75 0 0 1 .75.75 6.502 6.502 0 0 1-4.343 6.133.75.75 0 1 1-.498-1.415A5.002 5.002 0 0 0 7.245 8a.75.75 0 0 1 .75-.75Zm2.651 2.87a.75.75 0 0 1 .463.955 9.39 9.39 0 0 1-3.008 4.25.75.75 0 0 1-.936-1.171 7.892 7.892 0 0 0 2.527-3.57.75.75 0 0 1 .954-.463Z" clip-rule="evenodd"/>
</svg>

                
                    
            
            <span><?php ob_start(); ?>
                        <?php echo e(__('Register Passkey')); ?>

                    <?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>

                    <?php ob_start(); ?><p class="[:where(&amp;)]:font-normal [:where(&amp;)]:text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70" x-show="message" x-text="message" x-bind:class="isError ? 'text-red-600 mt-3' : 'text-green-600 mt-3'" data-flux-text ></p><?php echo ltrim(ob_get_clean()); ?>
                </div>
            <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>

            
            <?php ob_start(); ?><div class="[:where(&amp;)]:bg-white dark:[:where(&amp;)]:bg-white/10 border border-zinc-200 dark:border-white/10 [:where(&amp;)]:p-6 [:where(&amp;)]:rounded-xl space-y-5" data-flux-card>
    <?php ob_start(); ?>
                <div>
                    <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-base [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>
                        <?php echo e(__('Registered Passkeys')); ?>

                    <?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>

                    <?php ob_start(); ?><p class="[:where(&amp;)]:font-normal [:where(&amp;)]:text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70 mt-1" data-flux-text ><?php ob_start(); ?>
                        <?php echo e(__('Daftar passkey yang terhubung dengan akun Anda.')); ?>

                    <?php echo trim(ob_get_clean()); ?></p><?php echo ltrim(ob_get_clean()); ?>
                </div>

                <?php
                    $passkeys = auth()->user()->passkeys()->latest()->get();
                ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $passkeys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $passkey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div
                        <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'passkey-'.e($passkey->id).''; ?>wire:key="passkey-<?php echo e($passkey->id); ?>"
                        class="flex flex-col gap-4 border-t border-zinc-200 pt-4 first:border-t-0 first:pt-0 sm:flex-row sm:items-center sm:justify-between dark:border-zinc-700"
                    >
                        <div class="flex items-start gap-3">
                            <div class="rounded-lg bg-zinc-100 p-3 dark:bg-zinc-800">
                                <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0 1 19.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 0 0 4.5 10.5a7.464 7.464 0 0 1-1.15 3.993m1.989 3.559A11.209 11.209 0 0 0 8.25 10.5a3.75 3.75 0 1 1 7.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 0 1-3.6 9.75m6.633-4.596a18.666 18.666 0 0 1-2.485 5.33"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                            </div>

                            <div class="space-y-1">
                                <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-sm [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>
                                    <?php echo e($passkey->name ?: 'Passkey'); ?>

                                <?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>

                                <?php ob_start(); ?><p class="[:where(&amp;)]:font-normal [:where(&amp;)]:text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70 text-xs" data-flux-text ><?php ob_start(); ?>
                                    <?php echo e(__('Registered')); ?>:
                                    <?php echo e($passkey->created_at?->format('d M Y H:i') ?? '-'); ?>

                                <?php echo trim(ob_get_clean()); ?></p><?php echo ltrim(ob_get_clean()); ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($passkey->last_used_at): ?>
                                    <?php ob_start(); ?><p class="[:where(&amp;)]:font-normal [:where(&amp;)]:text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70 text-xs" data-flux-text ><?php ob_start(); ?>
                                        <?php echo e(__('Last used')); ?>:
                                        <?php echo e($passkey->last_used_at->format('d M Y H:i')); ?>

                                    <?php echo trim(ob_get_clean()); ?></p><?php echo ltrim(ob_get_clean()); ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        
                        <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-8 text-sm rounded-md px-3 inline-flex  bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500 text-white  shadow-[inset_0px_1px_var(--color-red-500),inset_0px_2px_--theme(--color-white/.15)] dark:shadow-none [[data-flux-button-group]_&amp;]:border-e [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 [[data-flux-button-group]_&amp;]:border-red-600 dark:[[data-flux-button-group]_&amp;]:border-red-900/25 *:transition-opacity [&amp;[data-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-flux-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-loading]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[data-flux-loading]&gt;[data-flux-loading-indicator]]:opacity-100 data-loading:pointer-events-none data-flux-loading:pointer-events-none" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" wire:target="confirmDelete(<?php echo e($passkey->id); ?>)" wire:loading.attr="data-flux-loading" wire:click="confirmDelete(<?php echo e($passkey->id); ?>)">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>
                            <?php echo e(__('Delete')); ?>

                        <?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="rounded-lg border border-dashed border-zinc-300 p-6 text-center dark:border-zinc-700">
                        <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 mx-auto size-10 text-zinc-400" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0 1 19.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 0 0 4.5 10.5a7.464 7.464 0 0 1-1.15 3.993m1.989 3.559A11.209 11.209 0 0 0 8.25 10.5a3.75 3.75 0 1 1 7.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 0 1-3.6 9.75m6.633-4.596a18.666 18.666 0 0 1-2.485 5.33"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>

                        <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-sm [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2 mt-3" data-flux-heading><?php ob_start(); ?>
                            <?php echo e(__('No passkeys registered')); ?>

                        <?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>

                        <?php ob_start(); ?><p class="[:where(&amp;)]:font-normal [:where(&amp;)]:text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70 mt-1" data-flux-text ><?php ob_start(); ?>
                            <?php echo e(__('Daftarkan passkey pertama Anda melalui tombol di atas.')); ?>

                        <?php echo trim(ob_get_clean()); ?></p><?php echo ltrim(ob_get_clean()); ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>

        </div>
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

    
    <?php ob_start(); ?><ui-modal wire:model.self="showDeleteModal" data-flux-modal>
    
    <dialog
        wire:ignore.self 
        class="p-6 [:where(&amp;)]:max-w-xl [:where(&amp;)]:min-w-xs shadow-lg rounded-xl bg-white dark:bg-zinc-800 ring ring-black/5 dark:ring-zinc-700 shadow-lg rounded-xl max-w-md"
                                <?php if (isset($scope)) $__scope = $scope; ?><?php $scope = array (
  'name' => NULL,
); ?>
        x-data="fluxModal(<?php echo \Illuminate\Support\Js::from($scope['name'])->toHtml() ?>, <?php echo \Illuminate\Support\Js::from(isset($__livewire) ? $__livewire->getId() : null)->toHtml() ?>)"
        <?php if (isset($__scope)) { $scope = $__scope; unset($__scope); } ?>
        x-on:modal-show.document="handleShow($event)"
        x-on:modal-close.document="handleClose($event)"
    >
                    <?php ob_start(); ?>
        <div class="space-y-6">
            <div>
                <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-base [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>
                    <?php echo e(__('Delete Passkey')); ?>

                <?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>
                <?php ob_start(); ?><p class="[:where(&amp;)]:font-normal [:where(&amp;)]:text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70 mt-2" data-flux-text ><?php ob_start(); ?>
                    <?php echo e(__('Apakah Anda yakin ingin menghapus passkey ini? Anda tidak akan bisa menggunakan passkey ini untuk login lagi.')); ?>

                <?php echo trim(ob_get_clean()); ?></p><?php echo ltrim(ob_get_clean()); ?>
            </div>

            <div class="flex gap-2">
                <?php ob_start(); ?><div class="flex-1" data-flux-spacer></div>
<?php echo ltrim(ob_get_clean()); ?>

                <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-800 dark:text-white    *:transition-opacity [&amp;[data-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-flux-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-loading]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[data-flux-loading]&gt;[data-flux-loading-indicator]]:opacity-100 data-loading:pointer-events-none data-flux-loading:pointer-events-none" data-flux-button="data-flux-button" wire:target="$set('showDeleteModal', false)" wire:loading.attr="data-flux-loading" wire:click="$set('showDeleteModal', false)">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>
                    <?php echo e(__('Cancel')); ?>

                <?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>

                <?php ob_start(); ?><button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-10 text-sm rounded-lg ps-4 pe-4 inline-flex  bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500 text-white  shadow-[inset_0px_1px_var(--color-red-500),inset_0px_2px_--theme(--color-white/.15)] dark:shadow-none [[data-flux-button-group]_&amp;]:border-e [:is([data-flux-button-group]&gt;&amp;:last-child,_[data-flux-button-group]_:last-child&gt;&amp;)]:border-e-0 [[data-flux-button-group]_&amp;]:border-red-600 dark:[[data-flux-button-group]_&amp;]:border-red-900/25 *:transition-opacity [&amp;[data-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-flux-loading]&gt;:not([data-flux-loading-indicator])]:opacity-0 [&amp;[data-loading]&gt;[data-flux-loading-indicator]]:opacity-100 [&amp;[data-flux-loading]&gt;[data-flux-loading-indicator]]:opacity-100 data-loading:pointer-events-none data-flux-loading:pointer-events-none" data-flux-button="data-flux-button" data-flux-group-target="data-flux-group-target" wire:target="deletePasskey" wire:loading.attr="data-flux-loading" wire:click="deletePasskey">
        <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <svg class="shrink-0 [:where(&amp;)]:size-4 animate-spin" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true" data-slot="icon">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
                    </div>
        
        
                    
            
            <span><?php ob_start(); ?>
                    <?php echo e(__('Delete Passkey')); ?>

                <?php echo trim(ob_get_clean()); ?></span>
    </button>
<?php echo ltrim(ob_get_clean()); ?>
            </div>
        </div>
    <?php echo trim(ob_get_clean()); ?>


                            <div class="absolute top-0 end-0 mt-4 me-4">
                    <ui-close data-flux-modal-close >
    <button type="button" class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none justify-center h-8 text-sm rounded-md w-8 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-800 dark:text-white      text-zinc-400! hover:text-zinc-800! dark:text-zinc-500! dark:hover:text-white!" data-flux-button="data-flux-button" aria-label="Close modal">
        <svg class="shrink-0 [:where(&amp;)]:size-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
  <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z"/>
</svg>
    </button>
</ui-close>
                </div>
                        </dialog>
</ui-modal>
<?php echo ltrim(ob_get_clean()); ?>
</section><?php /**PATH C:\laragon\www\siix-portal\resources\views/livewire/settings/passkeys.blade.php ENDPATH**/ ?>