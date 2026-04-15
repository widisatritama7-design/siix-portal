<x-layouts::auth :title="__('Log in')">
    <div class="flex flex-col gap-6">
        <x-auth-header 
            :title="__('Log in to your account')" 
            :description="__('Enter your NIK and password below to log in')" 
        />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <!-- Global Error Alert -->
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

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- NIK - Menggunakan number dengan styling -->
            <div>
                <flux:label>{{ __('NIK') }}</flux:label>
                <flux:input
                    name="nik"
                    type="number"
                    :value="old('nik')"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Enter your NIK"
                    class="[appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                />
                @error('nik')
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </div>

            <!-- Password -->
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

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('Remember me')" :checked="old('remember')" />

            <div class="flex flex-col gap-4">
                <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                    {{ __('Log in') }}
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts::auth>