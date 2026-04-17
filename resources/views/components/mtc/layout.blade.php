<div 
    x-data="{
        sidebarOpen: true,
        sidebarPinned: true,
        isHovering: false,
        hoverTimeout: null,
        mobileMenuOpen: false,
        masterOpen: true,
        metalOpen: true,
        monitoringOpen: true,

        init() {
            // Load all saved states from localStorage
            const savedSidebarOpen = localStorage.getItem('sidebarOpen');
            if (savedSidebarOpen !== null) {
                this.sidebarOpen = JSON.parse(savedSidebarOpen);
                this.sidebarPinned = this.sidebarOpen;
            }
            
            const savedMastertate = localStorage.getItem('masterOpen');
            if (savedMastertate !== null) {
                this.masterOpen = JSON.parse(savedMastertate);
            }

            const savedMetaltate = localStorage.getItem('metalOpen');
            if (savedMetaltate !== null) {
                this.metalOpen = JSON.parse(savedMetaltate);
            }

            const savedMonitoringtate = localStorage.getItem('monitoringOpen');
            if (savedMonitoringtate !== null) {
                this.monitoringOpen = JSON.parse(savedMonitoringtate);
            }

        },
        saveToLocalStorage() {
            localStorage.setItem('sidebarOpen', JSON.stringify(this.sidebarPinned ? this.sidebarOpen : false));
            localStorage.setItem('masterOpen', JSON.stringify(this.masterOpen));
            localStorage.setItem('metalOpen', JSON.stringify(this.metalOpen));
            localStorage.setItem('monitoringOpen', JSON.stringify(this.monitoringOpen));
        },
        toggleSidebar() {
            this.sidebarPinned = !this.sidebarPinned;
            this.sidebarOpen = this.sidebarPinned;
            this.saveToLocalStorage();
        },
        handleMouseEnter() {
            if (this.hoverTimeout) clearTimeout(this.hoverTimeout);
            if (!this.sidebarPinned) {
                this.isHovering = true;
                this.sidebarOpen = true;
            }
        },
        handleMouseLeave() {
            if (this.hoverTimeout) clearTimeout(this.hoverTimeout);
            if (!this.sidebarPinned) {
                this.hoverTimeout = setTimeout(() => {
                    this.isHovering = false;
                    this.sidebarOpen = false;
                }, 300);
            }
        }
    }"
    x-init="init()"
    @keyup.window="saveToLocalStorage()"
    @click.window="saveToLocalStorage()"
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

                <!-- Monitoring Group Mobile -->
                <div class="mb-1 relative">
                    <button 
                        @click="monitoringOpen = !monitoringOpen"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                    >
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path fill-rule="evenodd" d="M2.25 2.25a.75.75 0 0 0 0 1.5H3v10.5a3 3 0 0 0 3 3h1.21l-1.172 3.513a.75.75 0 0 0 1.424.474l.329-.987h8.418l.33.987a.75.75 0 0 0 1.422-.474l-1.17-3.513H18a3 3 0 0 0 3-3V3.75h.75a.75.75 0 0 0 0-1.5H2.25Zm6.54 15h6.42l.5 1.5H8.29l.5-1.5Zm8.085-8.995a.75.75 0 1 0-.75-1.299 12.81 12.81 0 0 0-3.558 3.05L11.03 8.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l2.47-2.47 1.617 1.618a.75.75 0 0 0 1.146-.102 11.312 11.312 0 0 1 3.612-3.321Z" clip-rule="evenodd" />
                            </svg>
                            <span>Monitoring</span>
                        </div>
                        <svg 
                            :class="{'rotate-180': monitoringOpen}"
                            class="w-4 h-4 transition-transform duration-200"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="monitoringOpen" x-collapse class="mt-1 relative">
                        <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                        <div class="space-y-1 ml-[30px]">
                            <a href="{{ route('mtc.daily-dashboard') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('mtc.daily-dashboard') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('mtc.daily-dashboard') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Daily Check Monitoring</span>
                            </a>
                            <a href="{{ route('mtc.stencil-dashboard') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('mtc.stencil-dashboard') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('mtc.stencil-dashboard') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Stencil Monitoring</span>
                            </a>
                        </div>
                    </div>
                </div>

                @canany(['view master-maintenance'])
                <!-- Master Group Mobile -->
                <div class="mb-1 relative">
                    <button 
                        @click="masterOpen = !masterOpen"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                    >
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                            </svg>
                            <span>Master</span>
                        </div>
                        <svg 
                            :class="{'rotate-180': masterOpen}"
                            class="w-4 h-4 transition-transform duration-200"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="masterOpen" x-collapse class="mt-1 relative">
                        <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                        <div class="space-y-1 ml-[30px]">
                            @can('view master area')
                            <a href="{{ route('mtc.master-areas') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('mtc.master-areas') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('mtc.master-areas') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Master Area</span>
                            </a>
                            @endcan
                            @can('view master location')
                            <a href="{{ route('mtc.master-locations') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('mtc.master-locations') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('mtc.master-locations') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Master Location</span>
                            </a>
                            @endcan
                            @can('view master line')
                            <a href="{{ route('mtc.master-lines') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('mtc.master-lines') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('mtc.master-lines') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Master Line</span>
                            </a>
                            @endcan
                            @can('view master machine')
                            <a href="{{ route('mtc.master-machines') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('mtc.master-machines') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('mtc.master-machines') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Master Machine</span>
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
                @endcanany

                @canany(['view metal mask'])
                <!-- Master Group Mobile -->
                <div class="mb-1 relative">
                    <button 
                        @click="metalOpen = !metalOpen"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                    >
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path d="M16.5 7.5h-9v9h9v-9Z" />
                                <path fill-rule="evenodd" d="M8.25 2.25A.75.75 0 0 1 9 3v.75h2.25V3a.75.75 0 0 1 1.5 0v.75H15V3a.75.75 0 0 1 1.5 0v.75h.75a3 3 0 0 1 3 3v.75H21A.75.75 0 0 1 21 9h-.75v2.25H21a.75.75 0 0 1 0 1.5h-.75V15H21a.75.75 0 0 1 0 1.5h-.75v.75a3 3 0 0 1-3 3h-.75V21a.75.75 0 0 1-1.5 0v-.75h-2.25V21a.75.75 0 0 1-1.5 0v-.75H9V21a.75.75 0 0 1-1.5 0v-.75h-.75a3 3 0 0 1-3-3v-.75H3A.75.75 0 0 1 3 15h.75v-2.25H3a.75.75 0 0 1 0-1.5h.75V9H3a.75.75 0 0 1 0-1.5h.75v-.75a3 3 0 0 1 3-3h.75V3a.75.75 0 0 1 .75-.75ZM6 6.75A.75.75 0 0 1 6.75 6h10.5a.75.75 0 0 1 .75.75v10.5a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V6.75Z" clip-rule="evenodd" />
                            </svg>
                            <span>Metal Mask</span>
                        </div>
                        <svg 
                            :class="{'rotate-180': metalOpen}"
                            class="w-4 h-4 transition-transform duration-200"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="metalOpen" x-collapse class="mt-1 relative">
                        <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                        <div class="space-y-1 ml-[30px]">
                            <a href="{{ route('mtc.stencils') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('mtc.stencils') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('mtc.stencils') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Master Stencil</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endcanany
            </flux:navlist>
        </div>
    </div>

    <!-- Desktop Layout: Sidebar -->
    <div class="hidden md:flex">
        <!-- Sidebar -->
        <div 
            :class="sidebarOpen ? 'md:w-[260px]' : 'md:w-[61px]'"
            @mouseenter="handleMouseEnter()"
            @mouseleave="handleMouseLeave()"
            class="w-full md:flex-shrink-0 transition-all duration-300 ease-in-out"
        >
            <div 
                :class="sidebarOpen ? 'p-3' : 'p-2'"
                class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl shadow-sm w-full h-fit"
            >
                <!-- Toggle Button inside sidebar -->
                <div class="mb-3">
                    <button 
                        @click="toggleSidebar()"
                        class="w-full flex items-center justify-center py-2 bg-zinc-100 dark:bg-zinc-800 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors"
                        type="button"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <div class="space-y-2">

                    <!-- Master Group Desktop -->
                    <div class="relative">
                        <!-- Button untuk collapsed mode (hanya icon) -->
                        <button 
                            x-show="!sidebarOpen"
                            @click="monitoringOpen = !monitoringOpen"
                            class="flex items-center justify-center w-full py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-zinc-600 dark:text-zinc-400"
                            title="Yearly"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path fill-rule="evenodd" d="M2.25 2.25a.75.75 0 0 0 0 1.5H3v10.5a3 3 0 0 0 3 3h1.21l-1.172 3.513a.75.75 0 0 0 1.424.474l.329-.987h8.418l.33.987a.75.75 0 0 0 1.422-.474l-1.17-3.513H18a3 3 0 0 0 3-3V3.75h.75a.75.75 0 0 0 0-1.5H2.25Zm6.54 15h6.42l.5 1.5H8.29l.5-1.5Zm8.085-8.995a.75.75 0 1 0-.75-1.299 12.81 12.81 0 0 0-3.558 3.05L11.03 8.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l2.47-2.47 1.617 1.618a.75.75 0 0 0 1.146-.102 11.312 11.312 0 0 1 3.612-3.321Z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Expanded mode -->
                        <div x-show="sidebarOpen">
                            <button 
                                @click="monitoringOpen = !monitoringOpen"
                                class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                            >
                                <div class="flex items-center gap-2">
                                    <!-- Icon Yearly (Calendar - same as collapsed mode) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                        <path fill-rule="evenodd" d="M2.25 2.25a.75.75 0 0 0 0 1.5H3v10.5a3 3 0 0 0 3 3h1.21l-1.172 3.513a.75.75 0 0 0 1.424.474l.329-.987h8.418l.33.987a.75.75 0 0 0 1.422-.474l-1.17-3.513H18a3 3 0 0 0 3-3V3.75h.75a.75.75 0 0 0 0-1.5H2.25Zm6.54 15h6.42l.5 1.5H8.29l.5-1.5Zm8.085-8.995a.75.75 0 1 0-.75-1.299 12.81 12.81 0 0 0-3.558 3.05L11.03 8.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l2.47-2.47 1.617 1.618a.75.75 0 0 0 1.146-.102 11.312 11.312 0 0 1 3.612-3.321Z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Monitoring</span>
                                </div>
                                <svg 
                                    :class="{'rotate-180': monitoringOpen}"
                                    class="w-4 h-4 transition-transform duration-200"
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <div x-show="monitoringOpen" x-collapse class="mt-1 relative">
                                <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                                <div class="space-y-1 ml-[30px]">
                                    <a href="{{ route('mtc.daily-dashboard') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('mtc.daily-dashboard') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('mtc.daily-dashboard') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Daily Check Monitoring</span>
                                    </a>
                                    <a href="{{ route('mtc.stencil-dashboard') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('mtc.stencil-dashboard') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('mtc.stencil-dashboard') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Stencil Monitoring</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @canany(['view master-maintenance'])
                    <!-- Master Group Desktop -->
                    <div class="relative">
                        <!-- Button untuk collapsed mode (hanya icon) -->
                        <button 
                            x-show="!sidebarOpen"
                            @click="masterOpen = !masterOpen"
                            class="flex items-center justify-center w-full py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-zinc-600 dark:text-zinc-400"
                            title="Yearly"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                            </svg>
                        </button>

                        <!-- Expanded mode -->
                        <div x-show="sidebarOpen">
                            <button 
                                @click="masterOpen = !masterOpen"
                                class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                            >
                                <div class="flex items-center gap-2">
                                    <!-- Icon Yearly (Calendar - same as collapsed mode) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                        <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                                    </svg>
                                    <span>Master</span>
                                </div>
                                <svg 
                                    :class="{'rotate-180': masterOpen}"
                                    class="w-4 h-4 transition-transform duration-200"
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <div x-show="masterOpen" x-collapse class="mt-1 relative">
                                <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                                <div class="space-y-1 ml-[30px]">
                                    @can('view master area')
                                    <a href="{{ route('mtc.master-areas') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('mtc.master-areas') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('mtc.master-areas') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Master Area</span>
                                    </a>
                                    @endcan
                                    @can('view master location')
                                    <a href="{{ route('mtc.master-locations') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('mtc.master-locations') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('mtc.master-locations') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Master Location</span>
                                    </a>
                                    @endcan
                                    @can('view master line')
                                    <a href="{{ route('mtc.master-lines') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('mtc.master-lines') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('mtc.master-lines') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Master Line</span>
                                    </a>
                                    @endcan
                                    @can('view master machine')
                                    <a href="{{ route('mtc.master-machines') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('mtc.master-machines') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('mtc.master-machines') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Master Machine</span>
                                    </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcanany

                    @canany(['view metal mask'])
                    <!-- Master Group Desktop -->
                    <div class="relative">
                        <!-- Button untuk collapsed mode (hanya icon) -->
                        <button 
                            x-show="!sidebarOpen"
                            @click="metalOpen = !metalOpen"
                            class="flex items-center justify-center w-full py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-zinc-600 dark:text-zinc-400"
                            title="Yearly"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path d="M16.5 7.5h-9v9h9v-9Z" />
                                <path fill-rule="evenodd" d="M8.25 2.25A.75.75 0 0 1 9 3v.75h2.25V3a.75.75 0 0 1 1.5 0v.75H15V3a.75.75 0 0 1 1.5 0v.75h.75a3 3 0 0 1 3 3v.75H21A.75.75 0 0 1 21 9h-.75v2.25H21a.75.75 0 0 1 0 1.5h-.75V15H21a.75.75 0 0 1 0 1.5h-.75v.75a3 3 0 0 1-3 3h-.75V21a.75.75 0 0 1-1.5 0v-.75h-2.25V21a.75.75 0 0 1-1.5 0v-.75H9V21a.75.75 0 0 1-1.5 0v-.75h-.75a3 3 0 0 1-3-3v-.75H3A.75.75 0 0 1 3 15h.75v-2.25H3a.75.75 0 0 1 0-1.5h.75V9H3a.75.75 0 0 1 0-1.5h.75v-.75a3 3 0 0 1 3-3h.75V3a.75.75 0 0 1 .75-.75ZM6 6.75A.75.75 0 0 1 6.75 6h10.5a.75.75 0 0 1 .75.75v10.5a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V6.75Z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Expanded mode -->
                        <div x-show="sidebarOpen">
                            <button 
                                @click="metalOpen = !metalOpen"
                                class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                            >
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                        <path d="M16.5 7.5h-9v9h9v-9Z" />
                                        <path fill-rule="evenodd" d="M8.25 2.25A.75.75 0 0 1 9 3v.75h2.25V3a.75.75 0 0 1 1.5 0v.75H15V3a.75.75 0 0 1 1.5 0v.75h.75a3 3 0 0 1 3 3v.75H21A.75.75 0 0 1 21 9h-.75v2.25H21a.75.75 0 0 1 0 1.5h-.75V15H21a.75.75 0 0 1 0 1.5h-.75v.75a3 3 0 0 1-3 3h-.75V21a.75.75 0 0 1-1.5 0v-.75h-2.25V21a.75.75 0 0 1-1.5 0v-.75H9V21a.75.75 0 0 1-1.5 0v-.75h-.75a3 3 0 0 1-3-3v-.75H3A.75.75 0 0 1 3 15h.75v-2.25H3a.75.75 0 0 1 0-1.5h.75V9H3a.75.75 0 0 1 0-1.5h.75v-.75a3 3 0 0 1 3-3h.75V3a.75.75 0 0 1 .75-.75ZM6 6.75A.75.75 0 0 1 6.75 6h10.5a.75.75 0 0 1 .75.75v10.5a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V6.75Z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Metal Mask</span>
                                </div>
                                <svg 
                                    :class="{'rotate-180': metalOpen}"
                                    class="w-4 h-4 transition-transform duration-200"
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <div x-show="metalOpen" x-collapse class="mt-1 relative">
                                <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                                <div class="space-y-1 ml-[30px]">
                                    <a href="{{ route('mtc.stencils') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('mtc.stencils') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('mtc.stencils') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Master Stencil</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcanany
                </div>
            </div>
        </div>

        <!-- Gap kanan -->
        <div class="flex-shrink-0 w-8"></div>
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