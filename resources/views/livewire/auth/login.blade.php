
<x-layouts::auth :title="__('Log in')">
    <div class="flex flex-col gap-6">
        <x-auth-header
            :title="__('Log in to your account')"
            :description="__('Enter your NIK and password below to log in')"
        />

        <x-auth-session-status class="text-center" :status="session('status')" />

        @if (session('error'))
            <div class="p-3 rounded-lg bg-red-100 text-red-700 text-sm text-center">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-3 rounded-lg bg-red-100 text-red-700 text-sm text-center">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Login menggunakan NIK dan password --}}
        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <div>
                <flux:label>{{ __('NIK') }}</flux:label>
                <flux:input
                    name="nik"
                    type="text"
                    inputmode="numeric"
                    :value="old('nik')"
                    required
                    autofocus
                    autocomplete="username webauthn"
                    placeholder="Enter your NIK"
                    class="[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                />
                @error('nik')
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </div>

            <div class="relative">
                <flux:label>{{ __('Password') }}</flux:label>
                <flux:input
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="{{ __('Password') }}"
                    viewable
                />
                @error('password')
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </div>

            <flux:checkbox
                name="remember"
                :label="__('Remember me')"
                :checked="old('remember')"
            />

            <flux:button
                variant="primary"
                type="submit"
                class="w-full"
                data-test="login-button"
            >
                {{ __('Log in') }}
            </flux:button>
        </form>

        {{-- Pemisah --}}
        <div class="relative flex items-center">
            <div class="flex-grow border-t border-zinc-200 dark:border-zinc-700"></div>
            <span class="px-3 text-xs text-zinc-500">OR</span>
            <div class="flex-grow border-t border-zinc-200 dark:border-zinc-700"></div>
        </div>

        {{-- Login menggunakan passkey --}}
        <div class="flex flex-col gap-3">
            <flux:button
                id="passkey-login-button"
                type="button"
                variant="outline"
                class="w-full"
                icon="finger-print"
            >
                Login with Passkey
            </flux:button>

            <div
                id="passkey-login-error"
                class="hidden p-3 rounded-lg bg-red-100 text-red-700 text-sm text-center"
                role="alert"
                aria-live="polite"
            ></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const button = document.getElementById('passkey-login-button');
            const errorBox = document.getElementById('passkey-login-error');

            if (!button || !errorBox) return;

            const showError = (message) => {
                errorBox.textContent = message;
                errorBox.classList.remove('hidden');
            };

            const rememberMe = () =>
                document.querySelector('input[name="remember"]')?.checked ?? false;

            if (!window.Passkeys) {
                button.disabled = true;
                showError('Passkey belum siap. Muat ulang halaman atau periksa build Vite.');
                return;
            }

            button.addEventListener('click', async () => {
                errorBox.classList.add('hidden');
                button.disabled = true;
                button.textContent = 'Menunggu autentikasi...';

                try {
                    const response = await window.Passkeys.verify({
                        remember: rememberMe(),
                    });

                    if (response?.redirect) {
                        window.location.assign(response.redirect);
                    } else {
                        window.location.reload();
                    }
                } catch (error) {
                    console.error('Passkey login error:', error);

                    showError(
                        error?.message ||
                        'Login passkey gagal atau dibatalkan. Silakan coba lagi.'
                    );

                    button.disabled = false;
                    button.textContent = 'Login dengan Passkey';
                }
            });

            // Mencoba menampilkan passkey tersimpan melalui autofill browser.
            if (typeof window.Passkeys.autofill === 'function') {
                window.Passkeys.autofill({
                    remember: rememberMe(),
                }).catch((error) => {
                    console.debug('Passkey autofill tidak aktif:', error);
                });
            }
        });
    </script>
</x-layouts::auth>
