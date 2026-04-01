<div 
    x-data="{
        sidebarOpen: JSON.parse(localStorage.getItem('sidebarOpen') ?? 'true'),
        mobileMenuOpen: false,
        yearlyOpen: true,
        monthlyOpen: true,
        threeMonthOpen: true,
        weeklyOpen: true,
        dailyOpen: true,
        newAdmissionOpen: true,
        init() {
            this.$nextTick(() => {
                this.sidebarOpen = JSON.parse(localStorage.getItem('sidebarOpen') ?? 'true');
                // Load saved states for groups
                let savedYearlyState = localStorage.getItem('yearlyOpen');
                if (savedYearlyState !== null) this.yearlyOpen = JSON.parse(savedYearlyState);
                let savedMonthlyState = localStorage.getItem('monthlyOpen');
                if (savedMonthlyState !== null) this.monthlyOpen = JSON.parse(savedMonthlyState);
                let savedThreeMonthState = localStorage.getItem('threeMonthOpen');
                if (savedThreeMonthState !== null) this.threeMonthOpen = JSON.parse(savedThreeMonthState);
                let savedWeeklyState = localStorage.getItem('weeklyOpen');
                if (savedWeeklyState !== null) this.weeklyOpen = JSON.parse(savedWeeklyState);
                let savedDailyState = localStorage.getItem('dailyOpen');
                if (savedDailyState !== null) this.dailyOpen = JSON.parse(savedDailyState);
                let savedNewAdmissionState = localStorage.getItem('newAdmissionOpen');
                if (savedNewAdmissionState !== null) this.newAdmissionOpen = JSON.parse(savedNewAdmissionState);
            });
        }
    }" 
    x-effect="localStorage.setItem('sidebarOpen', sidebarOpen); localStorage.setItem('yearlyOpen', yearlyOpen); localStorage.setItem('monthlyOpen', monthlyOpen); localStorage.setItem('threeMonthOpen', threeMonthOpen); localStorage.setItem('weeklyOpen', weeklyOpen); localStorage.setItem('dailyOpen', dailyOpen); localStorage.setItem('newAdmissionOpen', newAdmissionOpen)"
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
                <!-- Yearly Group -->
                <div class="mb-1">
                    <button 
                        @click="yearlyOpen = !yearlyOpen"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                    >
                        <div class="flex items-center gap-2">
                            <span>Yearly</span>
                        </div>
                        <svg 
                            :class="{'rotate-180': yearlyOpen}"
                            class="w-4 h-4 transition-transform duration-200"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="yearlyOpen" x-collapse class="mt-1 space-y-1">
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

                        <flux:navlist.item 
                            :href="route('esd.packagings')" 
                            wire:navigate
                            :active="request()->routeIs('esd.packagings')"
                            title="Packaging"
                            class="w-full"
                            @click="mobileMenuOpen = false"
                        >
                            <x-slot name="icon">
                                <x-heroicon-s-cube class="w-4 h-4" />
                            </x-slot>
                            <span class="truncate">Packaging</span>
                        </flux:navlist.item>

                        <flux:navlist.item 
                            :href="route('esd.solderings')" 
                            wire:navigate
                            :active="request()->routeIs('esd.solderings')"
                            title="Soldering"
                            class="w-full"
                            @click="mobileMenuOpen = false"
                        >
                            <x-slot name="icon">
                                <x-heroicon-s-pencil class="w-4 h-4" />
                            </x-slot>
                            <span class="truncate">Soldering</span>
                        </flux:navlist.item>

                        <flux:navlist.item 
                            :href="route('esd.worksurfaces')" 
                            wire:navigate
                            :active="request()->routeIs('esd.worksurfaces')"
                            title="Worksurface"
                            class="w-full"
                            @click="mobileMenuOpen = false"
                        >
                            <x-slot name="icon">
                                <x-heroicon-s-wallet class="w-4 h-4" />
                            </x-slot>
                            <span class="truncate">Worksurface</span>
                        </flux:navlist.item>
                    </div>
                </div>

                <!-- Monthly Group -->
                <div class="mb-1">
                    <button 
                        @click="monthlyOpen = !monthlyOpen"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                    >
                        <div class="flex items-center gap-2">
                            <span>Monthly</span>
                        </div>
                        <svg 
                            :class="{'rotate-180': monthlyOpen}"
                            class="w-4 h-4 transition-transform duration-200"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="monthlyOpen" x-collapse class="mt-1 space-y-1">
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

                        <flux:navlist.item 
                            :href="route('esd.wrist-straps')" 
                            wire:navigate
                            :active="request()->routeIs('esd.wrist-straps')"
                            title="Wrist Strap"
                            class="w-full"
                            @click="mobileMenuOpen = false"
                        >
                            <x-slot name="icon">
                                <x-heroicon-s-arrow-trending-down class="w-4 h-4" />
                            </x-slot>
                            <span class="truncate">Wrist Strap</span>
                        </flux:navlist.item>
                    </div>
                </div>

                <!-- 3 Month Group -->
                <div class="mb-1">
                    <button 
                        @click="threeMonthOpen = !threeMonthOpen"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                    >
                        <div class="flex items-center gap-2">
                            <span>3 Month</span>
                        </div>
                        <svg 
                            :class="{'rotate-180': threeMonthOpen}"
                            class="w-4 h-4 transition-transform duration-200"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="threeMonthOpen" x-collapse class="mt-1 space-y-1">
                        <flux:navlist.item 
                            :href="route('esd.magazines')" 
                            wire:navigate
                            :active="request()->routeIs('esd.magazines')"
                            title="Magazine"
                            class="w-full"
                            @click="mobileMenuOpen = false"
                        >
                            <x-slot name="icon">
                                <x-heroicon-s-inbox-arrow-down class="w-4 h-4" />
                            </x-slot>
                            <span class="truncate">Magazine</span>
                        </flux:navlist.item>
                    </div>
                </div>

                <!-- Weekly Group (Empty) -->
                <div class="mb-1">
                    <button 
                        @click="weeklyOpen = !weeklyOpen"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                    >
                        <div class="flex items-center gap-2">
                            <span>Weekly</span>
                        </div>
                        <svg 
                            :class="{'rotate-180': weeklyOpen}"
                            class="w-4 h-4 transition-transform duration-200"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="weeklyOpen" x-collapse class="mt-1 space-y-1">
                        <!-- Empty - No items -->
                        <div class="px-3 py-2 text-sm text-zinc-500 dark:text-zinc-400 italic">
                            No items
                        </div>
                    </div>
                </div>

                <!-- Daily Group -->
                <div class="mb-1">
                    <button 
                        @click="dailyOpen = !dailyOpen"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                    >
                        <div class="flex items-center gap-2">
                            <span>Daily</span>
                        </div>
                        <svg 
                            :class="{'rotate-180': dailyOpen}"
                            class="w-4 h-4 transition-transform duration-200"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="dailyOpen" x-collapse class="mt-1 space-y-1">
                        <flux:navlist.item 
                            :href="route('esd.insulatif-checks')" 
                            wire:navigate
                            :active="request()->routeIs('esd.insulatif-checks')"
                            title="Insulatif Check"
                            class="w-full"
                            @click="mobileMenuOpen = false"
                        >
                            <x-slot name="icon">
                                <x-heroicon-s-archive-box-x-mark class="w-4 h-4" />
                            </x-slot>
                            <span class="truncate">Insulatif Check</span>
                        </flux:navlist.item>
                    </div>
                </div>

                <!-- New Admission Group -->
                <div class="mb-1">
                    <button 
                        @click="newAdmissionOpen = !newAdmissionOpen"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                    >
                        <div class="flex items-center gap-2">
                            <span>New Admission</span>
                        </div>
                        <svg 
                            :class="{'rotate-180': newAdmissionOpen}"
                            class="w-4 h-4 transition-transform duration-200"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="newAdmissionOpen" x-collapse class="mt-1 space-y-1">
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
                    <!-- Yearly Group -->
                    <div class="mb-1">
                        <button 
                            x-show="sidebarOpen"
                            @click="yearlyOpen = !yearlyOpen"
                            class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                        >
                            <div class="flex items-center gap-2">
                                <span>Yearly</span>
                            </div>
                            <svg 
                                :class="{'rotate-180': yearlyOpen}"
                                class="w-4 h-4 transition-transform duration-200"
                                fill="none" 
                                stroke="currentColor" 
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Icon items when sidebar closed -->
                        <div x-show="!sidebarOpen" class="flex flex-col items-center space-y-1">
                            <a 
                                href="{{ route('esd.floorings') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto text-zinc-600 dark:text-zinc-400"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200': '{{ request()->routeIs('esd.floorings') }}' === '1'
                                }"
                                title="Flooring"
                            >
                                <x-heroicon-s-square-3-stack-3d class="w-4 h-4" />
                            </a>

                            <a 
                                href="{{ route('esd.garments') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto text-zinc-600 dark:text-zinc-400"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200': '{{ request()->routeIs('esd.garments') }}' === '1'
                                }"
                                title="Garment"
                            >
                                <x-heroicon-s-users class="w-4 h-4" />
                            </a>

                            <a 
                                href="{{ route('esd.ground-monitor-boxs') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto text-zinc-600 dark:text-zinc-400"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200': '{{ request()->routeIs('esd.ground-monitor-boxs') }}' === '1'
                                }"
                                title="Ground Monitor Box"
                            >
                                <x-heroicon-s-inbox-stack class="w-4 h-4" />
                            </a>

                            <a 
                                href="{{ route('esd.jigs') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto text-zinc-600 dark:text-zinc-400"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200': '{{ request()->routeIs('esd.jigs') }}' === '1'
                                }"
                                title="Jig"
                            >
                                <x-heroicon-s-puzzle-piece class="w-4 h-4" />
                            </a>

                            <a 
                                href="{{ route('esd.packagings') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto text-zinc-600 dark:text-zinc-400"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200': '{{ request()->routeIs('esd.packagings') }}' === '1'
                                }"
                                title="Packaging"
                            >
                                <x-heroicon-s-cube class="w-4 h-4" />
                            </a>

                            <a 
                                href="{{ route('esd.solderings') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto text-zinc-600 dark:text-zinc-400"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200': '{{ request()->routeIs('esd.solderings') }}' === '1'
                                }"
                                title="Soldering"
                            >
                                <x-heroicon-s-pencil class="w-4 h-4" />
                            </a>

                            <a 
                                href="{{ route('esd.worksurfaces') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto text-zinc-600 dark:text-zinc-400"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200': '{{ request()->routeIs('esd.worksurfaces') }}' === '1'
                                }"
                                title="Worksurface"
                            >
                                <x-heroicon-s-wallet class="w-4 h-4" />
                            </a>
                        </div>
                        
                        <!-- Expanded items when sidebar open -->
                        <div x-show="sidebarOpen && yearlyOpen" x-collapse class="mt-1 space-y-1">
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

                            <flux:navlist.item 
                                :href="route('esd.packagings')" 
                                wire:navigate
                                :active="request()->routeIs('esd.packagings')"
                                class="w-full"
                            >
                                <x-slot name="icon">
                                    <x-heroicon-s-cube class="w-4 h-4" />
                                </x-slot>
                                <span class="truncate">Packaging</span>
                            </flux:navlist.item>

                            <flux:navlist.item 
                                :href="route('esd.solderings')" 
                                wire:navigate
                                :active="request()->routeIs('esd.solderings')"
                                class="w-full"
                            >
                                <x-slot name="icon">
                                    <x-heroicon-s-pencil class="w-4 h-4" />
                                </x-slot>
                                <span class="truncate">Soldering</span>
                            </flux:navlist.item>

                            <flux:navlist.item 
                                :href="route('esd.worksurfaces')" 
                                wire:navigate
                                :active="request()->routeIs('esd.worksurfaces')"
                                class="w-full"
                            >
                                <x-slot name="icon">
                                    <x-heroicon-s-wallet class="w-4 h-4" />
                                </x-slot>
                                <span class="truncate">Worksurface</span>
                            </flux:navlist.item>
                        </div>
                    </div>

                    <!-- Monthly Group -->
                    <div class="mb-1">
                        <button 
                            x-show="sidebarOpen"
                            @click="monthlyOpen = !monthlyOpen"
                            class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                        >
                            <div class="flex items-center gap-2">
                                <span>Monthly</span>
                            </div>
                            <svg 
                                :class="{'rotate-180': monthlyOpen}"
                                class="w-4 h-4 transition-transform duration-200"
                                fill="none" 
                                stroke="currentColor" 
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Icon items when sidebar closed -->
                        <div x-show="!sidebarOpen" class="flex flex-col items-center space-y-1">
                            <a 
                                href="{{ route('esd.equipment-grounds') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto text-zinc-600 dark:text-zinc-400"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200': '{{ request()->routeIs('esd.equipment-grounds') }}' === '1'
                                }"
                                title="Equipment Ground"
                            >
                                <x-heroicon-s-server-stack class="w-4 h-4" />
                            </a>

                            <a 
                                href="{{ route('esd.ionizers') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto text-zinc-600 dark:text-zinc-400"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200': '{{ request()->routeIs('esd.ionizers') }}' === '1'
                                }"
                                title="Ionizer"
                            >
                                <x-heroicon-s-arrow-path-rounded-square class="w-4 h-4" />
                            </a>

                            <a 
                                href="{{ route('esd.wrist-straps') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto text-zinc-600 dark:text-zinc-400"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200': '{{ request()->routeIs('esd.wrist-straps') }}' === '1'
                                }"
                                title="Wrist Strap"
                            >
                                <x-heroicon-s-arrow-trending-down class="w-4 h-4" />
                            </a>
                        </div>
                        
                        <!-- Expanded items when sidebar open -->
                        <div x-show="sidebarOpen && monthlyOpen" x-collapse class="mt-1 space-y-1">
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

                            <flux:navlist.item 
                                :href="route('esd.wrist-straps')" 
                                wire:navigate
                                :active="request()->routeIs('esd.wrist-straps')"
                                class="w-full"
                            >
                                <x-slot name="icon">
                                    <x-heroicon-s-arrow-trending-down class="w-4 h-4" />
                                </x-slot>
                                <span class="truncate">Wrist Strap</span>
                            </flux:navlist.item>
                        </div>
                    </div>

                    <!-- 3 Month Group -->
                    <div class="mb-1">
                        <button 
                            x-show="sidebarOpen"
                            @click="threeMonthOpen = !threeMonthOpen"
                            class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                        >
                            <div class="flex items-center gap-2">
                                <span>3 Month</span>
                            </div>
                            <svg 
                                :class="{'rotate-180': threeMonthOpen}"
                                class="w-4 h-4 transition-transform duration-200"
                                fill="none" 
                                stroke="currentColor" 
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Icon items when sidebar closed -->
                        <div x-show="!sidebarOpen" class="flex flex-col items-center space-y-1">
                            <a 
                                href="{{ route('esd.magazines') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto text-zinc-600 dark:text-zinc-400"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200': '{{ request()->routeIs('esd.magazines') }}' === '1'
                                }"
                                title="Magazine"
                            >
                                <x-heroicon-s-inbox-arrow-down class="w-4 h-4" />
                            </a>
                        </div>
                        
                        <!-- Expanded items when sidebar open -->
                        <div x-show="sidebarOpen && threeMonthOpen" x-collapse class="mt-1 space-y-1">
                            <flux:navlist.item 
                                :href="route('esd.magazines')" 
                                wire:navigate
                                :active="request()->routeIs('esd.magazines')"
                                class="w-full"
                            >
                                <x-slot name="icon">
                                    <x-heroicon-s-inbox-arrow-down class="w-4 h-4" />
                                </x-slot>
                                <span class="truncate">Magazine</span>
                            </flux:navlist.item>
                        </div>
                    </div>

                    <!-- Weekly Group (Empty) -->
                    <div class="mb-1">
                        <button 
                            x-show="sidebarOpen"
                            @click="weeklyOpen = !weeklyOpen"
                            class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                        >
                            <div class="flex items-center gap-2">
                                <span>Weekly</span>
                            </div>
                            <svg 
                                :class="{'rotate-180': weeklyOpen}"
                                class="w-4 h-4 transition-transform duration-200"
                                fill="none" 
                                stroke="currentColor" 
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Icon items when sidebar closed -->
                        <div x-show="!sidebarOpen" class="flex flex-col items-center space-y-1">
                            <!-- No items -->
                        </div>
                        
                        <!-- Expanded items when sidebar open -->
                        <div x-show="sidebarOpen && weeklyOpen" x-collapse class="mt-1 space-y-1">
                            <div class="px-3 py-2 text-sm text-zinc-500 dark:text-zinc-400 italic">
                                No items
                            </div>
                        </div>
                    </div>

                    <!-- Daily Group -->
                    <div class="mb-1">
                        <button 
                            x-show="sidebarOpen"
                            @click="dailyOpen = !dailyOpen"
                            class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                        >
                            <div class="flex items-center gap-2">
                                <span>Daily</span>
                            </div>
                            <svg 
                                :class="{'rotate-180': dailyOpen}"
                                class="w-4 h-4 transition-transform duration-200"
                                fill="none" 
                                stroke="currentColor" 
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Icon items when sidebar closed -->
                        <div x-show="!sidebarOpen" class="flex flex-col items-center space-y-1">
                            <a 
                                href="{{ route('esd.insulatif-checks') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto text-zinc-600 dark:text-zinc-400"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200': '{{ request()->routeIs('esd.insulatif-checks') }}' === '1'
                                }"
                                title="Insulatif Check"
                            >
                                <x-heroicon-s-archive-box-x-mark class="w-4 h-4" />
                            </a>
                        </div>
                        
                        <!-- Expanded items when sidebar open -->
                        <div x-show="sidebarOpen && dailyOpen" x-collapse class="mt-1 space-y-1">
                            <flux:navlist.item 
                                :href="route('esd.insulatif-checks')" 
                                wire:navigate
                                :active="request()->routeIs('esd.insulatif-checks')"
                                class="w-full"
                            >
                                <x-slot name="icon">
                                    <x-heroicon-s-archive-box-x-mark class="w-4 h-4" />
                                </x-slot>
                                <span class="truncate">Insulatif Check</span>
                            </flux:navlist.item>
                        </div>
                    </div>

                    <!-- New Admission Group -->
                    <div class="mb-1">
                        <button 
                            x-show="sidebarOpen"
                            @click="newAdmissionOpen = !newAdmissionOpen"
                            class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                        >
                            <div class="flex items-center gap-2">
                                <span>New Admission</span>
                            </div>
                            <svg 
                                :class="{'rotate-180': newAdmissionOpen}"
                                class="w-4 h-4 transition-transform duration-200"
                                fill="none" 
                                stroke="currentColor" 
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Icon items when sidebar closed -->
                        <div x-show="!sidebarOpen" class="flex flex-col items-center space-y-1">
                            <a 
                                href="{{ route('esd.gloves') }}"
                                wire:navigate
                                class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors mx-auto text-zinc-600 dark:text-zinc-400"
                                :class="{
                                    'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200': '{{ request()->routeIs('esd.gloves') }}' === '1'
                                }"
                                title="Glove"
                            >
                                <x-heroicon-s-hand-raised class="w-4 h-4" />
                            </a>
                        </div>
                        
                        <!-- Expanded items when sidebar open -->
                        <div x-show="sidebarOpen && newAdmissionOpen" x-collapse class="mt-1 space-y-1">
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