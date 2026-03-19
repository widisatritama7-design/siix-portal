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

    <!-- Toggle Button -->
    <button 
        @click="sidebarOpen = !sidebarOpen"
        class="hidden md:flex flex-shrink-0 mt-1 mr-6 items-center justify-center w-10 h-10 bg-zinc-100 dark:bg-zinc-800 rounded-lg"
        type="button"
    >
        <x-heroicon-o-chevron-left 
            x-show="sidebarOpen"
            class="w-5 h-5"
            x-cloak
        />

        <x-heroicon-o-chevron-right 
            x-show="!sidebarOpen"
            class="w-5 h-5"
            x-cloak
        />
    </button>

    <!-- Sidebar -->
    <div 
        :class="sidebarOpen ? 'md:w-[220px]' : 'md:w-[61px]'"
        class="w-full md:flex-shrink-0 transition-none md:transition-all md:duration-300"
    >

        <div 
            :class="sidebarOpen ? 'p-3' : 'p-2 flex flex-col items-center'"
            class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl shadow-sm w-full"
        >

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

                <!-- Appearance -->
                <flux:navlist.item 
                    :href="route('appearance.edit')" 
                    wire:navigate
                    :active="request()->routeIs('appearance.edit')"
                    title="Appearance"
                    class="w-full"
                >
                    <x-slot name="icon">
                        <x-heroicon-o-swatch class="w-5 h-5" />
                    </x-slot>

                    <span x-show="sidebarOpen" class="truncate">
                        Appearance
                    </span>
                </flux:navlist.item>

            </flux:navlist>

        </div>

    </div>

    <!-- Gap kanan yang mengikuti gap kiri -->
    <div class="hidden md:block flex-shrink-0 w-6"></div>

    <flux:separator class="md:hidden my-4" />

    <!-- Main Content -->
    <div class="flex-1 min-w-0 self-stretch max-md:pt-6">

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