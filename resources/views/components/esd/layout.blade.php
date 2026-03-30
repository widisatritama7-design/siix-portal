<div 
    x-data="{
        sidebarOpen: JSON.parse(localStorage.getItem('sidebarOpen') ?? 'true'),
        mobileMenuOpen: false,
        masterMeasurementOpen: true,
        init() {
            // Set initial state tanpa animasi
            this.$nextTick(() => {
                this.sidebarOpen = JSON.parse(localStorage.getItem('sidebarOpen') ?? 'true');
                // Load saved state for group
                let savedGroupState = localStorage.getItem('masterMeasurementOpen');
                if (savedGroupState !== null) {
                    this.masterMeasurementOpen = JSON.parse(savedGroupState);
                }
            });
        }
    }" 
    x-effect="localStorage.setItem('sidebarOpen', sidebarOpen); localStorage.setItem('masterMeasurementOpen', masterMeasurementOpen)"
    class="flex max-md:flex-col"
    x-cloak
>

    <!-- Mobile Menu Button -->
    <div class="md:hidden flex justify-between items-center mb-4 p-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl">
        <button 
            @click="mobileMenuOpen = !mobileMenuOpen"
            class="flex items-center justify-center gap-2 px-3 py-2 bg-zinc-100 dark:bg-zinc-800 rounded-lg w-full"
            type="button"
        >
            <x-heroicon-o-bars-3 class="w-4 h-4" />
            <span class="text-sm font-medium">Menu</span>
        </button>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div 
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2"
        class="md:hidden mb-4"
        x-cloak
    >
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl shadow-lg p-3">
            <flux:navlist aria-label="Settings" class="w-full">
                <!-- Master Group -->
                <div class="mb-1">
                    <button 
                        @click="masterMeasurementOpen = !masterMeasurementOpen"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                    >
                        <div class="flex items-center gap-2">
                            <span>Master</span>
                        </div>
                        <svg 
                            :class="{'rotate-180': masterMeasurementOpen}"
                            class="w-4 h-4 transition-transform duration-200"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="masterMeasurementOpen" x-collapse class="mt-1 space-y-1">
                        <!-- Equipment Ground -->
                        <flux:navlist.item 
                            :href="route('esd.equipment-grounds')" 
                            wire:navigate
                            :active="request()->routeIs('esd.equipment-grounds')"
                            title="Equipment Ground"
                            class="w-full"
                            @click="mobileMenuOpen = false"
                        >
                            <x-slot name="icon">
                                <x-heroicon-s-server-stack class="w-4 h-4" />
                            </x-slot>
                            <span class="truncate">Equipment Ground</span>
                        </flux:navlist.item>

                        <!-- Flooring -->
                        <flux:navlist.item 
                            :href="route('esd.floorings')" 
                            wire:navigate
                            :active="request()->routeIs('esd.floorings')"
                            title="Flooring"
                            class="w-full"
                            @click="mobileMenuOpen = false"
                        >
                            <x-slot name="icon">
                                <x-heroicon-s-square-3-stack-3d class="w-4 h-4" />
                            </x-slot>
                            <span class="truncate">Flooring</span>
                        </flux:navlist.item>

                        <!-- Garment -->
                        <flux:navlist.item 
                            :href="route('esd.garments')" 
                            wire:navigate
                            :active="request()->routeIs('esd.garments')"
                            title="Garment"
                            class="w-full"
                            @click="mobileMenuOpen = false"
                        >
                            <x-slot name="icon">
                                <x-heroicon-s-users class="w-4 h-4" />
                            </x-slot>
                            <span class="truncate">Garment</span>
                        </flux:navlist.item>

                         <!-- Glove -->
                        <flux:navlist.item 
                            :href="route('esd.gloves')" 
                            wire:navigate
                            :active="request()->routeIs('esd.gloves')"
                            title="Glove"
                            class="w-full"
                            @click="mobileMenuOpen = false"
                        >
                            <x-slot name="icon">
                                <x-heroicon-s-hand-raised class="w-4 h-4" />
                            </x-slot>
                            <span class="truncate">Glove</span>
                        </flux:navlist.item>

                        <!-- Grounding Box -->
                        <flux:navlist.item 
                            :href="route('esd.ground-monitor-boxs')" 
                            wire:navigate
                            :active="request()->routeIs('esd.ground-monitor-boxs')"
                            title="Ground Monitor Box"
                            class="w-full"
                            @click="mobileMenuOpen = false"
                        >
                            <x-slot name="icon">
                                <x-heroicon-s-inbox-stack class="w-4 h-4" />
                            </x-slot>
                            <span class="truncate">Ground Monitor Box</span>
                        </flux:navlist.item>

                        <!-- Ionizer -->
                        <flux:navlist.item 
                            :href="route('esd.ionizers')" 
                            wire:navigate
                            :active="request()->routeIs('esd.ionizers')"
                            title="Ionizer"
                            class="w-full"
                            @click="mobileMenuOpen = false"
                        >
                            <x-slot name="icon">
                                <x-heroicon-s-arrow-path-rounded-square class="w-4 h-4" />
                            </x-slot>
                            <span class="truncate">Ionizer</span>
                        </flux:navlist.item>

                        <!-- Jig -->
                        <flux:navlist.item 
                            :href="route('esd.jigs')" 
                            wire:navigate
                            :active="request()->routeIs('esd.jigs')"
                            title="Jig"
                            class="w-full"
                            @click="mobileMenuOpen = false"
                        >
                            <x-slot name="icon">
                                <x-heroicon-s-puzzle-piece class="w-4 h-4" />
                            </x-slot>
                            <span class="truncate">Jig</span>
                        </flux:navlist.item>
                    </div>
                </div>
            </flux:navlist>
        </div>
    </div>

    <!-- Desktop Layout: Sidebar -->
    <div class="hidden md:flex">
        <!-- Sidebar -->
        <div 
            :class="sidebarOpen ? 'md:w-[220px]' : 'md:w-[61px]'"
            class="w-full md:flex-shrink-0 transition-none md:transition-all md:duration-300"
        >
            <div 
                :class="sidebarOpen ? 'p-3' : 'p-2'"
                class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl shadow-sm w-full"
            >
                <!-- Toggle Button inside sidebar - Full width with icon only -->
                <div class="mb-3">
                    <button 
                        @click="sidebarOpen = !sidebarOpen"
                        class="w-full flex items-center justify-center py-2 bg-zinc-100 dark:bg-zinc-800 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors"
                        type="button"
                    >
                        <x-heroicon-s-arrow-left-circle 
                            x-show="sidebarOpen"
                            class="w-6 h-6"
                            x-cloak
                        />
                        <x-heroicon-s-arrow-right-circle
                            x-show="!sidebarOpen"
                            class="w-6 h-6"
                            x-cloak
                        />
                    </button>
                </div>

                <flux:navlist aria-label="Settings" class="w-full">
                    <!-- Master Group -->
                    <div class="mb-1">
                        <!-- Title when sidebar open -->
                        <button 
                            x-show="sidebarOpen"
                            @click="masterMeasurementOpen = !masterMeasurementOpen"
                            class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                        >
                            <div class="flex items-center gap-2">
                                <span>Master</span>
                            </div>
                            <svg 
                                :class="{'rotate-180': masterMeasurementOpen}"
                                class="w-4 h-4 transition-transform duration-200"
                                fill="none" 
                                stroke="currentColor" 
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Icon items when sidebar closed - Using plain links for full control -->
                        <div x-show="!sidebarOpen" class="flex flex-col items-center space-y-1">
                            <!-- Equipment Ground Icon -->
                            <a 
                                href="{{ route('esd.equipment-grounds') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800': '{{ request()->routeIs('esd.equipment-grounds') }}' === '1'
                                }"
                                title="Equipment Ground"
                            >
                                <x-heroicon-s-server-stack class="w-4 h-4" />
                            </a>

                            <!-- Flooring Icon -->
                            <a 
                                href="{{ route('esd.floorings') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800': '{{ request()->routeIs('esd.floorings') }}' === '1'
                                }"
                                title="Flooring"
                            >
                                <x-heroicon-s-square-3-stack-3d class="w-4 h-4" />
                            </a>

                            <!-- Garment Icon -->
                            <a 
                                href="{{ route('esd.garments') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800': '{{ request()->routeIs('esd.garments') }}' === '1'
                                }"
                                title="Garment"
                            >
                                <x-heroicon-s-users class="w-4 h-4" />
                            </a>

                            <!-- Glove Icon -->
                            <a 
                                href="{{ route('esd.gloves') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800': '{{ request()->routeIs('esd.gloves') }}' === '1'
                                }"
                                title="Glove"
                            >
                                <x-heroicon-s-hand-raised class="w-4 h-4" />
                            </a>

                            <!-- GB Icon -->
                            <a 
                                href="{{ route('esd.ground-monitor-boxs') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800': '{{ request()->routeIs('esd.ground-monitor-boxs') }}' === '1'
                                }"
                                title="Ground Monitor Box"
                            >
                                <x-heroicon-s-inbox-stack class="w-4 h-4" />
                            </a>

                            <!-- Ionizer Icon -->
                            <a 
                                href="{{ route('esd.ionizers') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800': '{{ request()->routeIs('esd.ionizers') }}' === '1'
                                }"
                                title="Ionizer"
                            >
                                <x-heroicon-s-arrow-path-rounded-square class="w-4 h-4" />
                            </a>

                            <!-- Jig -->
                            <a 
                                href="{{ route('esd.jigs') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800': '{{ request()->routeIs('esd.jigs') }}' === '1'
                                }"
                                title="Jig"
                            >
                                <x-heroicon-s-puzzle-piece class="w-4 h-4" />
                            </a>
                        </div>
                        
                        <!-- Expanded items when sidebar open -->
                        <div x-show="sidebarOpen && masterMeasurementOpen" x-collapse class="mt-1 space-y-4">
                            <!-- Equipment Ground -->
                            <flux:navlist.item 
                                :href="route('esd.equipment-grounds')" 
                                wire:navigate
                                :active="request()->routeIs('esd.equipment-grounds')"
                                class="w-full"
                            >
                                <x-slot name="icon">
                                    <x-heroicon-s-server-stack class="w-4 h-4" />
                                </x-slot>
                                <span class="truncate">Equipment Ground</span>
                            </flux:navlist.item>

                            <!-- Flooring -->
                            <flux:navlist.item 
                                :href="route('esd.floorings')" 
                                wire:navigate
                                :active="request()->routeIs('esd.floorings')"
                                class="w-full"
                            >
                                <x-slot name="icon">
                                    <x-heroicon-s-square-3-stack-3d class="w-4 h-4" />
                                </x-slot>
                                <span class="truncate">Flooring</span>
                            </flux:navlist.item>

                            <!-- Garment -->
                            <flux:navlist.item 
                                :href="route('esd.garments')" 
                                wire:navigate
                                :active="request()->routeIs('esd.garments')"
                                class="w-full"
                            >
                                <x-slot name="icon">
                                    <x-heroicon-s-users class="w-4 h-4" />
                                </x-slot>
                                <span class="truncate">Garment</span>
                            </flux:navlist.item>

                            <!-- Glove -->
                            <flux:navlist.item 
                                :href="route('esd.gloves')" 
                                wire:navigate
                                :active="request()->routeIs('esd.gloves')"
                                class="w-full"
                            >
                                <x-slot name="icon">
                                    <x-heroicon-s-hand-raised class="w-4 h-4" />
                                </x-slot>
                                <span class="truncate">Glove</span>
                            </flux:navlist.item>

                            <!-- Ground Monitor Box -->
                            <flux:navlist.item 
                                :href="route('esd.ground-monitor-boxs')" 
                                wire:navigate
                                :active="request()->routeIs('esd.ground-monitor-boxs')"
                                class="w-full"
                            >
                                <x-slot name="icon">
                                    <x-heroicon-s-inbox-stack class="w-4 h-4" />
                                </x-slot>
                                <span class="truncate">Ground Monitor Box</span>
                            </flux:navlist.item>

                            <!-- Ionizer -->
                            <flux:navlist.item 
                                :href="route('esd.ionizers')" 
                                wire:navigate
                                :active="request()->routeIs('esd.ionizers')"
                                class="w-full"
                            >
                                <x-slot name="icon">
                                    <x-heroicon-s-arrow-path-rounded-square class="w-4 h-4" />
                                </x-slot>
                                <span class="truncate">Ionizer</span>
                            </flux:navlist.item>

                            <!-- Jig -->
                            <flux:navlist.item 
                                :href="route('esd.jigs')" 
                                wire:navigate
                                :active="request()->routeIs('esd.jigs')"
                                class="w-full"
                            >
                                <x-slot name="icon">
                                    <x-heroicon-s-puzzle-piece class="w-4 h-4" />
                                </x-slot>
                                <span class="truncate">Jig</span>
                            </flux:navlist.item>
                        </div>
                    </div>
                </flux:navlist>
            </div>
        </div>

        <!-- Gap kanan -->
        <div class="hidden md:block flex-shrink-0 w-6"></div>
    </div>

    <flux:separator class="md:hidden my-4" />

    <!-- Main Content -->
    <div class="flex-1 min-w-0 self-stretch max-md:pt-0">
        <flux:heading class="hidden md:block">
            {{ $heading ?? '' }}
        </flux:heading>

        <flux:subheading class="hidden md:block">
            {{ $subheading ?? '' }}
        </flux:subheading>

        <div class="mt-5 w-full">
            {{ $slot }}
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        [x-collapse] { overflow: hidden; }
    </style>
</div>