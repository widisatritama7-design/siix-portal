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

        <form id="login-form" method="POST" action="<?php echo e(route('login.store')); ?>" class="flex flex-col gap-6">
            <?php echo csrf_field(); ?>

            <div class="relative">
                <label for="nik"
                    class="absolute -top-2 left-3 px-1 bg-white dark:bg-zinc-900 text-xs font-medium text-zinc-600 dark:text-zinc-400 z-10">
                    <?php echo e(__('NIK')); ?>

                </label>
                <input
                    id="nik" name="nik" type="text" inputmode="numeric"
                    value="<?php echo e(old('nik')); ?>" required autofocus
                    autocomplete="username webauthn"
                    placeholder="Enter your NIK"
                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 px-3 pt-3 pb-2 text-sm text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                />
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="relative">
                <label for="password"
                    class="absolute -top-2 left-3 px-1 bg-white dark:bg-zinc-900 text-xs font-medium text-zinc-600 dark:text-zinc-400 z-10">
                    <?php echo e(__('Password')); ?>

                </label>
                <input
                    id="password" name="password" type="password" required
                    autocomplete="current-password"
                    placeholder="<?php echo e(__('Password')); ?>"
                    class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 px-3 pt-3 pb-2 pr-10 text-sm text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />
                <button type="button" id="toggle-password" aria-label="<?php echo e(__('Show password')); ?>" aria-pressed="false"
                    class="absolute inset-y-0 right-0 flex items-center px-3 text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <line id="password-slash" x1="4" y1="20" x2="20" y2="4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" class="hidden" />
                    </svg>
                </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <label class="inline-flex items-center gap-2 text-sm text-zinc-700 dark:text-zinc-300">
                <input type="checkbox" name="remember" value="1" <?php if(old('remember')): echo 'checked'; endif; ?>
                    class="rounded border-zinc-300 dark:border-zinc-700 text-blue-600 focus:ring-blue-500" />
                <span><?php echo e(__('Remember me')); ?></span>
            </label>

            <button type="submit" id="login-submit"
                class="w-full inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition disabled:opacity-60 disabled:cursor-not-allowed"
                data-test="login-button">
                <span id="login-submit-text"><?php echo e(__('Log in')); ?></span>
                <svg id="login-spinner" class="hidden ml-2 w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
            </button>
        </form>

        <div class="relative flex items-center">
            <div class="flex-grow border-t border-zinc-200 dark:border-zinc-700"></div>
            <span class="px-3 text-xs text-zinc-500">OR</span>
            <div class="flex-grow border-t border-zinc-200 dark:border-zinc-700"></div>
        </div>

        <div class="flex flex-col gap-3">
            <button id="passkey-login-button" type="button"
                class="w-full inline-flex items-center justify-center gap-2 rounded-lg border border-blue-600 bg-white dark:bg-zinc-900 px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-950/30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition disabled:opacity-50 disabled:cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0 1 19.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 0 0 4.5 10.5a7.464 7.464 0 0 1-1.15 3.993m1.989 3.559A11.209 11.209 0 0 0 8.25 10.5a3.75 3.75 0 1 1 7.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 0 1-3.6 9.75m6.633-4.596a18.666 18.666 0 0 1-2.485 5.33" />
                </svg>
                Login with Passkey
            </button>

            <div id="passkey-login-error" class="hidden p-3 rounded-lg bg-red-100 text-red-700 text-sm text-center" role="alert" aria-live="polite"></div>
        </div>
    </div>

    
    <div id="login-success-modal"
         class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4 opacity-0 transition-opacity duration-300">
        <div id="login-success-card"
             class="w-full max-w-sm rounded-2xl bg-white dark:bg-zinc-900 p-6 shadow-xl text-center
                    scale-90 opacity-0 translate-y-3 transition-all duration-300">
            
            
            <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/40 relative">
                <svg id="success-check" class="w-14 h-14 text-green-600 dark:text-green-400" viewBox="0 0 52 52" fill="none">
                    <circle id="success-circle" cx="26" cy="26" r="22"
                            stroke="currentColor" stroke-width="4"
                            stroke-dasharray="138" stroke-dashoffset="138"
                            transform="rotate(-90 26 26)" />
                    <path id="success-path" d="M15 27 L23 35 L38 18"
                          stroke="currentColor" stroke-width="5"
                          stroke-linecap="round" stroke-linejoin="round"
                          stroke-dasharray="35" stroke-dashoffset="35" />
                </svg>
            </div>

            <h3 class="mt-4 text-lg font-semibold text-zinc-900 dark:text-zinc-100"><?php echo e(__('Login Berhasil')); ?></h3>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400"><?php echo e(__('Selamat datang! Anda akan diarahkan ke dashboard.')); ?></p>

            <div class="mt-6 flex flex-col gap-2">
                <button type="button" id="go-dashboard"
                    class="w-full inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                    <?php echo e(__('Ke Dashboard')); ?>

                </button>
                <p class="text-xs text-zinc-500"><?php echo e(__('Dialihkan otomatis dalam')); ?> <span id="countdown">3</span>s</p>
            </div>
        </div>
    </div>

    <style>
        /* Sembunyikan ikon mata bawaan browser */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear { display: none; }
        input[type="password"]::-webkit-credentials-auto-fill-button,
        input[type="password"]::-webkit-contacts-auto-fill-button {
            visibility: hidden; display: none !important; pointer-events: none; position: absolute; right: 0;
        }

        /* ===== Animasi Checkmark ===== */
        @keyframes drawCircle { to { stroke-dashoffset: 0; } }
        @keyframes drawCheck  { to { stroke-dashoffset: 0; } }

        #login-success-modal.is-visible #success-circle {
            animation: drawCircle 0.6s ease-in-out forwards;
        }
        #login-success-modal.is-visible #success-path {
            animation: drawCheck 0.4s ease-in-out 0.55s forwards;
        }

        /* ===== Countdown ===== */
        #countdown {
            display: inline-block;
            min-width: 1ch;
            font-variant-numeric: tabular-nums;
            transform-origin: center;
            transition: transform 0.12s ease;
            will-change: transform;
        }
        #countdown.pop {
            transform: scale(1.08);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('login-form');
            const submitBtn = document.getElementById('login-submit');
            const submitText = document.getElementById('login-submit-text');
            const spinner = document.getElementById('login-spinner');

            const modal = document.getElementById('login-success-modal');
            const card = document.getElementById('login-success-card');
            const circle = document.getElementById('success-circle');
            const path = document.getElementById('success-path');
            const goDashboardBtn = document.getElementById('go-dashboard');
            const countdownEl = document.getElementById('countdown');

            const DASHBOARD_URL = '/main-dashboard';
            const COUNTDOWN_SECONDS = 3;
            let countdownRaf = null;
            let countdownStarted = false;

            // ---------- Toggle password ----------
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('toggle-password');
            const slash = document.getElementById('password-slash');

            if (togglePassword && passwordInput && slash) {
                togglePassword.addEventListener('click', () => {
                    const isHidden = passwordInput.type === 'password';
                    passwordInput.type = isHidden ? 'text' : 'password';
                    slash.classList.toggle('hidden', !isHidden);
                    togglePassword.setAttribute('aria-pressed', String(isHidden));
                });
            }

            // ---------- Countdown halus ----------
            const startCountdown = () => {
                if (countdownRaf) cancelAnimationFrame(countdownRaf);

                const totalMs = COUNTDOWN_SECONDS * 1000;
                const start = performance.now();
                let lastShown = null;

                countdownEl.textContent = COUNTDOWN_SECONDS;

                const frame = (now) => {
                    const elapsed = now - start;
                    const remainingMs = Math.max(0, totalMs - elapsed);
                    const shown = Math.ceil(remainingMs / 1000);

                    if (shown !== lastShown) {
                        lastShown = shown;
                        countdownEl.textContent = shown;

                        countdownEl.classList.remove('pop');
                        void countdownEl.offsetWidth;
                        countdownEl.classList.add('pop');
                    }

                    if (remainingMs <= 0) {
                        window.location.assign(DASHBOARD_URL);
                        return;
                    }

                    countdownRaf = requestAnimationFrame(frame);
                };

                countdownRaf = requestAnimationFrame(frame);
            };

            // ---------- Modal sukses + animasi checkmark ----------
            const showSuccessModal = () => {
                modal.classList.remove('is-visible');
                circle.style.animation = 'none';
                path.style.animation = 'none';
                circle.style.strokeDashoffset = '138';
                path.style.strokeDashoffset = '35';

                modal.classList.remove('hidden');
                modal.classList.add('flex');

                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        modal.classList.remove('opacity-0');
                        card.classList.remove('scale-90', 'opacity-0', 'translate-y-3');
                        card.classList.add('scale-100', 'opacity-100', 'translate-y-0');
                    });
                });

                // Trigger animasi centang setelah card muncul
                setTimeout(() => {
                    circle.style.animation = '';
                    path.style.animation = '';
                    void circle.getBoundingClientRect();
                    void path.getBoundingClientRect();
                    modal.classList.add('is-visible');
                }, 350);

                // Mulai countdown setelah centang selesai digambar
                setTimeout(() => {
                    if (!countdownStarted) {
                        countdownStarted = true;
                        startCountdown();
                    }
                }, 1400); 
            };

            goDashboardBtn?.addEventListener('click', () => {
                if (countdownRaf) cancelAnimationFrame(countdownRaf);
                window.location.assign(DASHBOARD_URL);
            });

            // ---------- Submit via fetch ----------
            form?.addEventListener('submit', async (e) => {
                e.preventDefault();

                submitBtn.disabled = true;
                spinner.classList.remove('hidden');
                submitText.textContent = 'Memproses...';

                try {
                    const formData = new FormData(form);
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        credentials: 'same-origin',
                        redirect: 'manual'
                    });

                    if (response.ok || response.type === 'opaqueredirect' || response.status === 302 || response.status === 0) {
                        showSuccessModal();
                        return;
                    }

                    window.location.reload();
                } catch (err) {
                    console.error(err);
                    form.submit();
                } finally {
                    submitBtn.disabled = false;
                    spinner.classList.add('hidden');
                    submitText.textContent = '<?php echo e(__('Log in')); ?>';
                }
            });

            // ---------- Passkey ----------
            const passkeyBtn = document.getElementById('passkey-login-button');
            const errorBox = document.getElementById('passkey-login-error');

            const showError = (msg) => {
                errorBox.textContent = msg;
                errorBox.classList.remove('hidden');
            };

            const rememberMe = () =>
                document.querySelector('input[name="remember"]')?.checked ?? false;

            if (!window.Passkeys) {
                passkeyBtn.disabled = true;
                showError('Passkey belum siap. Muat ulang halaman atau periksa build Vite.');
                return;
            }

            passkeyBtn.addEventListener('click', async () => {
                errorBox.classList.add('hidden');
                passkeyBtn.disabled = true;
                passkeyBtn.textContent = 'Menunggu autentikasi...';

                try {
                    await window.Passkeys.verify({ remember: rememberMe() });
                    showSuccessModal();
                } catch (error) {
                    console.error('Passkey login error:', error);
                    showError(error?.message || 'Login passkey gagal atau dibatalkan. Silakan coba lagi.');
                    passkeyBtn.disabled = false;
                    passkeyBtn.textContent = 'Login dengan Passkey';
                }
            });

            if (typeof window.Passkeys.autofill === 'function') {
                window.Passkeys.autofill({ remember: rememberMe() }).catch((err) => {
                    console.debug('Passkey autofill tidak aktif:', err);
                });
            }
        });
    </script>
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