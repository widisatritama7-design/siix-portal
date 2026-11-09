<div class="relative mb-6 w-full">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <!-- Kiri: Heading + Subheading -->
        <div class="min-w-0">
            <flux:heading size="xl" level="1">{{ __('Settings') }}</flux:heading>
            <flux:subheading size="lg">{{ __('Manage your profile and account settings') }}</flux:subheading>
        </div>

        <!-- Kanan: Tab Menu -->
        <nav 
            class="flex flex-col gap-2 md:flex-row md:items-center flex-shrink-0"
            aria-label="Settings"
        >
            <!-- Profile -->
            <a 
                href="{{ route('profile.edit') }}" 
                wire:navigate
                @class([
                    'flex items-center gap-2 px-3 py-2 md:py-1.5 rounded-lg text-sm font-medium transition-all border whitespace-nowrap',
                    'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 border-zinc-900 dark:border-zinc-100 shadow-sm' => request()->routeIs('profile.edit'),
                    'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-zinc-100' => !request()->routeIs('profile.edit'),
                ])
            >
                <x-heroicon-o-user class="w-4 h-4" />
                <span>Profile</span>
            </a>

            <!-- Security -->
            <a 
                href="{{ route('security.edit') }}" 
                wire:navigate
                @class([
                    'flex items-center gap-2 px-3 py-2 md:py-1.5 rounded-lg text-sm font-medium transition-all border whitespace-nowrap',
                    'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 border-zinc-900 dark:border-zinc-100 shadow-sm' => request()->routeIs('security.edit'),
                    'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-zinc-100' => !request()->routeIs('security.edit'),
                ])
            >
                <x-heroicon-o-lock-closed class="w-4 h-4" />
                <span>Security</span>
            </a>

            <!-- Passkey -->
            <a 
                href="{{ route('settings.passkeys') }}" 
                wire:navigate
                @class([
                    'flex items-center gap-2 px-3 py-2 md:py-1.5 rounded-lg text-sm font-medium transition-all border whitespace-nowrap',
                    'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 border-zinc-900 dark:border-zinc-100 shadow-sm' => request()->routeIs('settings.passkeys'),
                    'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-zinc-100' => !request()->routeIs('settings.passkeys'),
                ])
            >
                <x-heroicon-o-finger-print class="w-4 h-4" />
                <span>Passkey</span>
            </a>
        </nav>
    </div>

    <flux:separator variant="subtle" class="mt-6" />
</div>