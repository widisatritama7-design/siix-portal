<div 
    x-data="{
        sidebarOpen: JSON.parse(localStorage.getItem('sidebarOpen') ?? 'true'),
        init() {
            // Set initial state tanpa animasi
            this.$nextTick(() => {
                this.sidebarOpen = JSON.parse(localStorage.getItem('sidebarOpen') ?? 'true');
            });
        }
    }" 
    x-effect="localStorage.setItem('sidebarOpen', sidebarOpen)"
    class="flex max-md:flex-col"
    x-cloak
>
    <!-- Sidebar Container -->
    <div 
        :class="sidebarOpen ? 'md:w-[220px]' : 'md:w-[61px]'"
        class="w-full md:flex-shrink-0 transition-none md:transition-all md:duration-300"
    >
        <div 
            :class="sidebarOpen ? 'p-3' : 'p-2'"
            class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl shadow-sm w-full flex flex-col gap-2"
        >
            <!-- Toggle Button (Posisi di tengah) -->
            <button 
                @click="sidebarOpen = !sidebarOpen"
                class="hidden md:flex flex-shrink-0 items-center justify-center w-full py-1.5 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-500 transition-colors"
                type="button"
                title="Toggle Sidebar"
            >
                <x-heroicon-s-arrow-left-circle 
                    x-show="sidebarOpen"
                    class="w-5 h-5"
                    x-cloak
                />

                <x-heroicon-s-arrow-right-circle
                    x-show="!sidebarOpen"
                    class="w-5 h-5"
                    x-cloak
                />
            </button>

            <!-- Divider tipis (opsional, agar rapi) -->
            <div class="h-px bg-zinc-200 dark:bg-zinc-700 w-full hidden md:block"></div>

            <!-- Navigasi -->
            <flux:navlist aria-label="Settings" class="w-full">
                <!-- Profile -->
                <flux:navlist.item 
                    :href="route('profile.edit')" 
                    wire:navigate
                    :active="request()->routeIs('profile.edit')"
                    title="Profile"
                    class="w-full"
                >
                    <x-slot name="icon">
                        <x-heroicon-o-user class="w-5 h-5" />
                    </x-slot>
                    <span x-show="sidebarOpen" class="truncate">
                        Profile
                    </span>
                </flux:navlist.item>

                <!-- Security -->
                <flux:navlist.item 
                    :href="route('security.edit')" 
                    wire:navigate
                    :active="request()->routeIs('security.edit')"
                    title="Security"
                    class="w-full"
                >
                    <x-slot name="icon">
                        <x-heroicon-o-lock-closed class="w-5 h-5" />
                    </x-slot>
                    <span x-show="sidebarOpen" class="truncate">
                        Security
                    </span>
                </flux:navlist.item>

                <!-- Passkey -->
                <flux:navlist.item 
                    :href="route('settings.passkeys')" 
                    wire:navigate
                    :active="request()->routeIs('settings.passkeys')"
                    title="Passkey"
                    class="w-full"
                >
                    <x-slot name="icon">
                        <x-heroicon-o-finger-print class="w-5 h-5" />
                    </x-slot>
                    <span x-show="sidebarOpen" class="truncate">
                        Passkey
                    </span>
                </flux:navlist.item>
            </flux:navlist>
        </div>
    </div>

    <!-- Gap kanan yang mengikuti gap kiri -->
    <div class="hidden md:block flex-shrink-0 w-6"></div>

    <flux:separator class="md:hidden my-4" />

    <!-- Main Content -->
    <div class="flex-1 min-w-0 self-stretch max-md:pt-6 min-h-screen pb-12">
        <flux:heading>
            {{ $heading ?? '' }}
        </flux:heading>
        <flux:subheading>
            {{ $subheading ?? '' }}
        </flux:subheading>
        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>