<div 
    x-data="{
        sidebarOpen: true,
        sidebarPinned: true,
        isHovering: false,
        hoverTimeout: null,
        mobileMenuOpen: false,
        yearlyOpen: true,
        monthlyOpen: true,
        threeMonthOpen: true,
        weeklyOpen: true,
        dailyOpen: true,
        newAdmissionOpen: true,
        stockOpen: true,
        managementOpen: true,

        init() {
            // Load all saved states from localStorage
            const savedSidebarOpen = localStorage.getItem('sidebarOpen');
            if (savedSidebarOpen !== null) {
                this.sidebarOpen = JSON.parse(savedSidebarOpen);
                this.sidebarPinned = this.sidebarOpen;
            }
            
            const savedYearlyState = localStorage.getItem('yearlyOpen');
            if (savedYearlyState !== null) {
                this.yearlyOpen = JSON.parse(savedYearlyState);
            }
            
            const savedMonthlyState = localStorage.getItem('monthlyOpen');
            if (savedMonthlyState !== null) {
                this.monthlyOpen = JSON.parse(savedMonthlyState);
            }
            
            const savedThreeMonthState = localStorage.getItem('threeMonthOpen');
            if (savedThreeMonthState !== null) {
                this.threeMonthOpen = JSON.parse(savedThreeMonthState);
            }
            
            const savedWeeklyState = localStorage.getItem('weeklyOpen');
            if (savedWeeklyState !== null) {
                this.weeklyOpen = JSON.parse(savedWeeklyState);
            }
            
            const savedDailyState = localStorage.getItem('dailyOpen');
            if (savedDailyState !== null) {
                this.dailyOpen = JSON.parse(savedDailyState);
            }
            
            const savedNewAdmissionState = localStorage.getItem('newAdmissionOpen');
            if (savedNewAdmissionState !== null) {
                this.newAdmissionOpen = JSON.parse(savedNewAdmissionState);
            }

            const savedStockState = localStorage.getItem('stockOpen');
            if (savedStockState !== null) {
                this.stockOpen = JSON.parse(savedStockState);
            }

            const savedmanagementState = localStorage.getItem('managementOpen');
            if (savedmanagementState !== null) {
                this.managementOpen = JSON.parse(savedmanagementState);
            }

        },
        saveToLocalStorage() {
            localStorage.setItem('sidebarOpen', JSON.stringify(this.sidebarPinned ? this.sidebarOpen : false));
            localStorage.setItem('yearlyOpen', JSON.stringify(this.yearlyOpen));
            localStorage.setItem('monthlyOpen', JSON.stringify(this.monthlyOpen));
            localStorage.setItem('threeMonthOpen', JSON.stringify(this.threeMonthOpen));
            localStorage.setItem('weeklyOpen', JSON.stringify(this.weeklyOpen));
            localStorage.setItem('dailyOpen', JSON.stringify(this.dailyOpen));
            localStorage.setItem('newAdmissionOpen', JSON.stringify(this.newAdmissionOpen));
            localStorage.setItem('stockOpen', JSON.stringify(this.stockOpen));
            localStorage.setItem('managementOpen', JSON.stringify(this.managementOpen));
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

                <!-- Management Group Mobile -->
                <div class="mb-1 relative">
                    <button 
                        @click="managementOpen = !managementOpen"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                    >
                        <div class="flex items-center gap-2">
                            <!-- Icon Weekly (Document stack - same as expanded mode) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path d="M18.75 12.75h1.5a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM12 6a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 6ZM12 18a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 18ZM3.75 6.75h1.5a.75.75 0 1 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM5.25 18.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 0 1.5ZM3 12a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 3 12ZM9 3.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM12.75 12a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0ZM9 15.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                            </svg>
                            <span>ESD Management</span>
                        </div>
                        <svg 
                            :class="{'rotate-180': managementOpen}"
                            class="w-4 h-4 transition-transform duration-200"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="managementOpen" x-collapse class="mt-1 relative">
                        <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                        <div class="space-y-1 ml-[30px]">
                            <a href="{{ route('esd.events') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.events') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.events') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Event Management</span>
                            </a>
                        </div>
                    </div>
                    
                    <div x-show="managementOpen" x-collapse class="mt-1 relative">
                        <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                        <div class="space-y-1 ml-[30px]">
                            <a href="{{ route('esd.lockers') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.lockers') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.lockers') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Locker Management</span>
                            </a>
                        </div>
                    </div>

                    <div x-show="managementOpen" x-collapse class="mt-1 relative">
                        <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                        <div class="space-y-1 ml-[30px]">
                            <a href="{{ route('esd.product-qualifications') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.product-qualifications') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.product-qualifications') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Product Qualification</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Stock Group Mobile -->
                <div class="mb-1 relative">
                    <button 
                        @click="stockOpen = !stockOpen"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                    >
                        <div class="flex items-center gap-2">
                            <!-- Icon Weekly (Document stack - same as expanded mode) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 0 1-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004ZM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 0 1-.921.42Z" />
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v.816a3.836 3.836 0 0 0-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 0 1-.921-.421l-.879-.66a.75.75 0 0 0-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 0 0 1.5 0v-.81a4.124 4.124 0 0 0 1.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 0 0-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 0 0 .933-1.175l-.415-.33a3.836 3.836 0 0 0-1.719-.755V6Z" clip-rule="evenodd" />
                            </svg>
                            <span>Stock Management</span>
                        </div>
                        <svg 
                            :class="{'rotate-180': stockOpen}"
                            class="w-4 h-4 transition-transform duration-200"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="stockOpen" x-collapse class="mt-1 relative">
                        <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                        <div class="space-y-1 ml-[30px]">
                            <a href="{{ route('esd.materials') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.materials') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.materials') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Material</span>
                            </a>
                        </div>
                    </div>

                    <div x-show="stockOpen" x-collapse class="mt-1 relative">
                        <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                        <div class="space-y-1 ml-[30px]">
                            <a href="{{ route('esd.transactions') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.transactions') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.transactions') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Transaction</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Yearly Group Mobile -->
                <div class="mb-1 relative">
                    <button 
                        @click="yearlyOpen = !yearlyOpen"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                    >
                        <div class="flex items-center gap-2">
                            <!-- Icon Yearly (Calendar - same as expanded mode) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
                            </svg>
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
                    
                    <div x-show="yearlyOpen" x-collapse class="mt-1 relative">
                        <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                        <div class="space-y-1 ml-[30px]">
                            <a href="{{ route('esd.floorings') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.floorings') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.floorings') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Flooring</span>
                            </a>

                            <a href="{{ route('esd.garments') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.garments') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.garments') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Garment</span>
                            </a>

                            <a href="{{ route('esd.ground-monitor-boxs') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.ground-monitor-boxs') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.ground-monitor-boxs') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Ground Monitor Box</span>
                            </a>

                            <a href="{{ route('esd.jigs') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.jigs') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.jigs') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Jig</span>
                            </a>

                            <a href="{{ route('esd.packagings') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.packagings') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.packagings') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Packaging</span>
                            </a>

                            <a href="{{ route('esd.solderings') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.solderings') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.solderings') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Soldering</span>
                            </a>

                            <a href="{{ route('esd.worksurfaces') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.worksurfaces') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.worksurfaces') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Worksurface</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Monthly Group Mobile -->
                <div class="mb-1 relative">
                    <button 
                        @click="monthlyOpen = !monthlyOpen"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                    >
                        <div class="flex items-center gap-2">
                            <!-- Icon Monthly (Calendar with dates - same as expanded mode) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm-3 9.75v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5h-16.5Z" clip-rule="evenodd" />
                            </svg>
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
                    
                    <div x-show="monthlyOpen" x-collapse class="mt-1 relative">
                        <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                        <div class="space-y-1 ml-[30px]">
                            <a href="{{ route('esd.equipment-grounds') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.equipment-grounds') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.equipment-grounds') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Equipment Ground</span>
                            </a>

                            <a href="{{ route('esd.ionizers') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.ionizers') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.ionizers') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Ionizer</span>
                            </a>

                            <a href="{{ route('esd.wrist-straps') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.wrist-straps') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.wrist-straps') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Wrist Strap</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 3 Month Group Mobile -->
                <div class="mb-1 relative">
                    <button 
                        @click="threeMonthOpen = !threeMonthOpen"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                    >
                        <div class="flex items-center gap-2">
                            <!-- Icon 3 Month (Clock with plus - same as expanded mode) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path d="M12 11.993a.75.75 0 0 0-.75.75v.006c0 .414.336.75.75.75h.006a.75.75 0 0 0 .75-.75v-.006a.75.75 0 0 0-.75-.75H12ZM12 16.494a.75.75 0 0 0-.75.75v.005c0 .414.335.75.75.75h.005a.75.75 0 0 0 .75-.75v-.005a.75.75 0 0 0-.75-.75H12ZM8.999 17.244a.75.75 0 0 1 .75-.75h.006a.75.75 0 0 1 .75.75v.006a.75.75 0 0 1-.75.75h-.006a.75.75 0 0 1-.75-.75v-.006ZM7.499 16.494a.75.75 0 0 0-.75.75v.005c0 .414.336.75.75.75h.005a.75.75 0 0 0 .75-.75v-.005a.75.75 0 0 0-.75-.75H7.5ZM13.499 14.997a.75.75 0 0 1 .75-.75h.006a.75.75 0 0 1 .75.75v.005a.75.75 0 0 1-.75.75h-.006a.75.75 0 0 1-.75-.75v-.005ZM14.25 16.494a.75.75 0 0 0-.75.75v.006c0 .414.335.75.75.75h.005a.75.75 0 0 0 .75-.75v-.006a.75.75 0 0 0-.75-.75h-.005ZM15.75 14.995a.75.75 0 0 1 .75-.75h.005a.75.75 0 0 1 .75.75v.006a.75.75 0 0 1-.75.75H16.5a.75.75 0 0 1-.75-.75v-.006ZM13.498 12.743a.75.75 0 0 1 .75-.75h2.25a.75.75 0 1 1 0 1.5h-2.25a.75.75 0 0 1-.75-.75ZM6.748 14.993a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Z" />
                                <path fill-rule="evenodd" d="M18 2.993a.75.75 0 0 0-1.5 0v1.5h-9V2.994a.75.75 0 1 0-1.5 0v1.497h-.752a3 3 0 0 0-3 3v11.252a3 3 0 0 0 3 3h13.5a3 3 0 0 0 3-3V7.492a3 3 0 0 0-3-3H18V2.993ZM3.748 18.743v-7.5a1.5 1.5 0 0 1 1.5-1.5h13.5a1.5 1.5 0 0 1 1.5 1.5v7.5a1.5 1.5 0 0 1-1.5 1.5h-13.5a1.5 1.5 0 0 1-1.5-1.5Z" clip-rule="evenodd" />
                            </svg>
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
                    
                    <div x-show="threeMonthOpen" x-collapse class="mt-1 relative">
                        <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                        <div class="space-y-1 ml-[30px]">
                            <a href="{{ route('esd.magazines') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.magazines') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.magazines') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Magazine</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Weekly Group Mobile -->
                <div class="mb-1 relative">
                    <button 
                        @click="weeklyOpen = !weeklyOpen"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                    >
                        <div class="flex items-center gap-2">
                            <!-- Icon Weekly (Document stack - same as expanded mode) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path fill-rule="evenodd" d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 18.375V5.625ZM21 9.375A.375.375 0 0 0 20.625 9h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5ZM10.875 18.75a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5ZM3.375 15h7.5a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375Zm0-3.75h7.5a.375.375 0 0 0 .375-.375v-1.5A.375.375 0 0 0 10.875 9h-7.5A.375.375 0 0 0 3 9.375v1.5c0 .207.168.375.375.375Z" clip-rule="evenodd" />
                            </svg>
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
                    
                    <div x-show="weeklyOpen" x-collapse class="mt-1 relative">
                        <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                        <div class="space-y-1 ml-[30px]">
                            <a href="{{ route('esd.showers') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.showers') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.showers') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Shower</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Daily Group Mobile -->
                <div class="mb-1 relative">
                    <button 
                        @click="dailyOpen = !dailyOpen"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                    >
                        <div class="flex items-center gap-2">
                            <!-- Icon Daily (Refresh/Update - same as expanded mode) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
                            </svg>
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
                    
                    <div x-show="dailyOpen" x-collapse class="mt-1 relative">
                        <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                        <div class="space-y-1 ml-[30px]">
                            <a href="{{ route('esd.insulatif-checks') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.insulatif-checks') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.insulatif-checks') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Insulatif Check</span>
                            </a>
                        </div>
                    </div>

                    <div x-show="dailyOpen" x-collapse class="mt-1 relative">
                        <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                        <div class="space-y-1 ml-[30px]">
                            <a href="{{ route('esd.patrols') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.patrols') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.patrols') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Patrol</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- New Admission Group Mobile -->
                <div class="mb-1 relative">
                    <button 
                        @click="newAdmissionOpen = !newAdmissionOpen"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                    >
                        <div class="flex items-center gap-2">
                            <!-- Icon New Admission (Download/Import - same as expanded mode) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path fill-rule="evenodd" d="M9.75 6.75h-3a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3h7.5a3 3 0 0 0 3-3v-7.5a3 3 0 0 0-3-3h-3V1.5a.75.75 0 0 0-1.5 0v5.25Zm0 0h1.5v5.69l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72V6.75Z" clip-rule="evenodd" />
                                <path d="M7.151 21.75a2.999 2.999 0 0 0 2.599 1.5h7.5a3 3 0 0 0 3-3v-7.5c0-1.11-.603-2.08-1.5-2.599v7.099a4.5 4.5 0 0 1-4.5 4.5H7.151Z" />
                            </svg>
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
                    
                    <div x-show="newAdmissionOpen" x-collapse class="mt-1 relative">
                        <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                        <div class="space-y-1 ml-[30px]">
                            <a href="{{ route('esd.gloves') }}" wire:navigate
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.gloves') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
                                @click="mobileMenuOpen = false">
                                <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.gloves') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                <span class="truncate">Glove</span>
                            </a>
                        </div>
                    </div>
                </div>

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

                    <!-- Management Group Desktop -->
                    <div class="relative">
                        <button 
                            x-show="!sidebarOpen"
                            @click="managementOpen = !managementOpen"
                            class="flex items-center justify-center w-full py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-zinc-600 dark:text-zinc-400"
                            title="Weekly"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path d="M18.75 12.75h1.5a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM12 6a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 6ZM12 18a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 18ZM3.75 6.75h1.5a.75.75 0 1 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM5.25 18.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 0 1.5ZM3 12a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 3 12ZM9 3.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM12.75 12a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0ZM9 15.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                            </svg>
                        </button>

                        <div x-show="sidebarOpen">
                            <button 
                                @click="managementOpen = !managementOpen"
                                class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                            >
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                        <path d="M18.75 12.75h1.5a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM12 6a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 6ZM12 18a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 18ZM3.75 6.75h1.5a.75.75 0 1 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM5.25 18.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 0 1.5ZM3 12a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 3 12ZM9 3.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM12.75 12a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0ZM9 15.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                                    </svg>
                                    <span>ESD Management</span>
                                </div>
                                <svg 
                                    :class="{'rotate-180': managementOpen}"
                                    class="w-4 h-4 transition-transform duration-200"
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="managementOpen" x-collapse class="mt-1 relative">
                                <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                                <div class="space-y-1 ml-[30px]">
                                    <a href="{{ route('esd.events') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.events') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.events') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Event Management</span>
                                    </a>
                                </div>
                            </div>
                            
                            <div x-show="managementOpen" x-collapse class="mt-1 relative">
                                <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                                <div class="space-y-1 ml-[30px]">
                                    <a href="{{ route('esd.lockers') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.lockers') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.lockers') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Locker Management</span>
                                    </a>
                                </div>
                            </div>

                            <div x-show="managementOpen" x-collapse class="mt-1 relative">
                                <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                                <div class="space-y-1 ml-[30px]">
                                    <a href="{{ route('esd.product-qualifications') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.product-qualifications') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.product-qualifications') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Product Qualification</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Group Desktop -->
                    <div class="relative">
                        <button 
                            x-show="!sidebarOpen"
                            @click="stockOpen = !stockOpen"
                            class="flex items-center justify-center w-full py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-zinc-600 dark:text-zinc-400"
                            title="Weekly"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 0 1-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004ZM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 0 1-.921.42Z" />
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v.816a3.836 3.836 0 0 0-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 0 1-.921-.421l-.879-.66a.75.75 0 0 0-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 0 0 1.5 0v-.81a4.124 4.124 0 0 0 1.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 0 0-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 0 0 .933-1.175l-.415-.33a3.836 3.836 0 0 0-1.719-.755V6Z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="sidebarOpen">
                            <button 
                                @click="stockOpen = !stockOpen"
                                class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                            >
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                        <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 0 1-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004ZM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 0 1-.921.42Z" />
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v.816a3.836 3.836 0 0 0-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 0 1-.921-.421l-.879-.66a.75.75 0 0 0-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 0 0 1.5 0v-.81a4.124 4.124 0 0 0 1.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 0 0-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 0 0 .933-1.175l-.415-.33a3.836 3.836 0 0 0-1.719-.755V6Z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Stock Management</span>
                                </div>
                                <svg 
                                    :class="{'rotate-180': stockOpen}"
                                    class="w-4 h-4 transition-transform duration-200"
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <div x-show="stockOpen" x-collapse class="mt-1 relative">
                                <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                                <div class="space-y-1 ml-[30px]">
                                    <a href="{{ route('esd.materials') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.materials') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.materials') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Material</span>
                                    </a>
                                </div>
                            </div>

                            <div x-show="stockOpen" x-collapse class="mt-1 relative">
                                <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                                <div class="space-y-1 ml-[30px]">
                                    <a href="{{ route('esd.transactions') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.transactions') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.transactions') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Transaction</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Yearly Group Desktop -->
                    <div class="relative">
                        <!-- Button untuk collapsed mode (hanya icon) -->
                        <button 
                            x-show="!sidebarOpen"
                            @click="yearlyOpen = !yearlyOpen"
                            class="flex items-center justify-center w-full py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-zinc-600 dark:text-zinc-400"
                            title="Yearly"
                        >
                            <!-- Icon Yearly (Calendar - same as expanded mode) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Expanded mode -->
                        <div x-show="sidebarOpen">
                            <button 
                                @click="yearlyOpen = !yearlyOpen"
                                class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                            >
                                <div class="flex items-center gap-2">
                                    <!-- Icon Yearly (Calendar - same as collapsed mode) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                        <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
                                    </svg>
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
                            
                            <div x-show="yearlyOpen" x-collapse class="mt-1 relative">
                                <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                                <div class="space-y-1 ml-[30px]">
                                    <a href="{{ route('esd.floorings') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.floorings') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.floorings') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Flooring</span>
                                    </a>

                                    <a href="{{ route('esd.garments') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.garments') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.garments') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Garment</span>
                                    </a>

                                    <a href="{{ route('esd.ground-monitor-boxs') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.ground-monitor-boxs') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.ground-monitor-boxs') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Ground Monitor Box</span>
                                    </a>

                                    <a href="{{ route('esd.jigs') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.jigs') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.jigs') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Jig</span>
                                    </a>

                                    <a href="{{ route('esd.packagings') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.packagings') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.packagings') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Packaging</span>
                                    </a>

                                    <a href="{{ route('esd.solderings') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.solderings') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.solderings') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Soldering</span>
                                    </a>

                                    <a href="{{ route('esd.worksurfaces') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.worksurfaces') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.worksurfaces') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Worksurface</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Group Desktop -->
                    <div class="relative">
                        <button 
                            x-show="!sidebarOpen"
                            @click="monthlyOpen = !monthlyOpen"
                            class="flex items-center justify-center w-full py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-zinc-600 dark:text-zinc-400"
                            title="Monthly"
                        >
                            <!-- Icon Monthly (Calendar with dates - same as expanded mode) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm-3 9.75v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5h-16.5Z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="sidebarOpen">
                            <button 
                                @click="monthlyOpen = !monthlyOpen"
                                class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                            >
                                <div class="flex items-center gap-2">
                                    <!-- Icon Monthly (Calendar with dates - same as collapsed mode) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                        <path d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                                        <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm-3 9.75v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5h-16.5Z" clip-rule="evenodd" />
                                    </svg>
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
                            
                            <div x-show="monthlyOpen" x-collapse class="mt-1 relative">
                                <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                                <div class="space-y-1 ml-[30px]">
                                    <a href="{{ route('esd.equipment-grounds') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.equipment-grounds') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.equipment-grounds') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Equipment Ground</span>
                                    </a>

                                    <a href="{{ route('esd.ionizers') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.ionizers') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.ionizers') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Ionizer</span>
                                    </a>

                                    <a href="{{ route('esd.wrist-straps') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.wrist-straps') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.wrist-straps') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Wrist Strap</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3 Month Group Desktop -->
                    <div class="relative">
                        <button 
                            x-show="!sidebarOpen"
                            @click="threeMonthOpen = !threeMonthOpen"
                            class="flex items-center justify-center w-full py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-zinc-600 dark:text-zinc-400"
                            title="3 Month"
                        >
                            <!-- Icon 3 Month (Clock with plus - same as expanded mode) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path d="M12 11.993a.75.75 0 0 0-.75.75v.006c0 .414.336.75.75.75h.006a.75.75 0 0 0 .75-.75v-.006a.75.75 0 0 0-.75-.75H12ZM12 16.494a.75.75 0 0 0-.75.75v.005c0 .414.335.75.75.75h.005a.75.75 0 0 0 .75-.75v-.005a.75.75 0 0 0-.75-.75H12ZM8.999 17.244a.75.75 0 0 1 .75-.75h.006a.75.75 0 0 1 .75.75v.006a.75.75 0 0 1-.75.75h-.006a.75.75 0 0 1-.75-.75v-.006ZM7.499 16.494a.75.75 0 0 0-.75.75v.005c0 .414.336.75.75.75h.005a.75.75 0 0 0 .75-.75v-.005a.75.75 0 0 0-.75-.75H7.5ZM13.499 14.997a.75.75 0 0 1 .75-.75h.006a.75.75 0 0 1 .75.75v.005a.75.75 0 0 1-.75.75h-.006a.75.75 0 0 1-.75-.75v-.005ZM14.25 16.494a.75.75 0 0 0-.75.75v.006c0 .414.335.75.75.75h.005a.75.75 0 0 0 .75-.75v-.006a.75.75 0 0 0-.75-.75h-.005ZM15.75 14.995a.75.75 0 0 1 .75-.75h.005a.75.75 0 0 1 .75.75v.006a.75.75 0 0 1-.75.75H16.5a.75.75 0 0 1-.75-.75v-.006ZM13.498 12.743a.75.75 0 0 1 .75-.75h2.25a.75.75 0 1 1 0 1.5h-2.25a.75.75 0 0 1-.75-.75ZM6.748 14.993a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Z" />
                                <path fill-rule="evenodd" d="M18 2.993a.75.75 0 0 0-1.5 0v1.5h-9V2.994a.75.75 0 1 0-1.5 0v1.497h-.752a3 3 0 0 0-3 3v11.252a3 3 0 0 0 3 3h13.5a3 3 0 0 0 3-3V7.492a3 3 0 0 0-3-3H18V2.993ZM3.748 18.743v-7.5a1.5 1.5 0 0 1 1.5-1.5h13.5a1.5 1.5 0 0 1 1.5 1.5v7.5a1.5 1.5 0 0 1-1.5 1.5h-13.5a1.5 1.5 0 0 1-1.5-1.5Z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="sidebarOpen">
                            <button 
                                @click="threeMonthOpen = !threeMonthOpen"
                                class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                            >
                                <div class="flex items-center gap-2">
                                    <!-- Icon 3 Month (Clock with plus - same as collapsed mode) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                        <path d="M12 11.993a.75.75 0 0 0-.75.75v.006c0 .414.336.75.75.75h.006a.75.75 0 0 0 .75-.75v-.006a.75.75 0 0 0-.75-.75H12ZM12 16.494a.75.75 0 0 0-.75.75v.005c0 .414.335.75.75.75h.005a.75.75 0 0 0 .75-.75v-.005a.75.75 0 0 0-.75-.75H12ZM8.999 17.244a.75.75 0 0 1 .75-.75h.006a.75.75 0 0 1 .75.75v.006a.75.75 0 0 1-.75.75h-.006a.75.75 0 0 1-.75-.75v-.006ZM7.499 16.494a.75.75 0 0 0-.75.75v.005c0 .414.336.75.75.75h.005a.75.75 0 0 0 .75-.75v-.005a.75.75 0 0 0-.75-.75H7.5ZM13.499 14.997a.75.75 0 0 1 .75-.75h.006a.75.75 0 0 1 .75.75v.005a.75.75 0 0 1-.75.75h-.006a.75.75 0 0 1-.75-.75v-.005ZM14.25 16.494a.75.75 0 0 0-.75.75v.006c0 .414.335.75.75.75h.005a.75.75 0 0 0 .75-.75v-.006a.75.75 0 0 0-.75-.75h-.005ZM15.75 14.995a.75.75 0 0 1 .75-.75h.005a.75.75 0 0 1 .75.75v.006a.75.75 0 0 1-.75.75H16.5a.75.75 0 0 1-.75-.75v-.006ZM13.498 12.743a.75.75 0 0 1 .75-.75h2.25a.75.75 0 1 1 0 1.5h-2.25a.75.75 0 0 1-.75-.75ZM6.748 14.993a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Z" />
                                        <path fill-rule="evenodd" d="M18 2.993a.75.75 0 0 0-1.5 0v1.5h-9V2.994a.75.75 0 1 0-1.5 0v1.497h-.752a3 3 0 0 0-3 3v11.252a3 3 0 0 0 3 3h13.5a3 3 0 0 0 3-3V7.492a3 3 0 0 0-3-3H18V2.993ZM3.748 18.743v-7.5a1.5 1.5 0 0 1 1.5-1.5h13.5a1.5 1.5 0 0 1 1.5 1.5v7.5a1.5 1.5 0 0 1-1.5 1.5h-13.5a1.5 1.5 0 0 1-1.5-1.5Z" clip-rule="evenodd" />
                                    </svg>
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
                            
                            <div x-show="threeMonthOpen" x-collapse class="mt-1 relative">
                                <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                                <div class="space-y-1 ml-[30px]">
                                    <a href="{{ route('esd.magazines') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.magazines') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.magazines') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Magazine</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Weekly Group Desktop -->
                    <div class="relative">
                        <button 
                            x-show="!sidebarOpen"
                            @click="weeklyOpen = !weeklyOpen"
                            class="flex items-center justify-center w-full py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-zinc-600 dark:text-zinc-400"
                            title="Weekly"
                        >
                            <!-- Icon Weekly (Document stack - same as expanded mode) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path fill-rule="evenodd" d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 18.375V5.625ZM21 9.375A.375.375 0 0 0 20.625 9h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5ZM10.875 18.75a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5ZM3.375 15h7.5a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375Zm0-3.75h7.5a.375.375 0 0 0 .375-.375v-1.5A.375.375 0 0 0 10.875 9h-7.5A.375.375 0 0 0 3 9.375v1.5c0 .207.168.375.375.375Z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="sidebarOpen">
                            <button 
                                @click="weeklyOpen = !weeklyOpen"
                                class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                            >
                                <div class="flex items-center gap-2">
                                    <!-- Icon Weekly (Document stack - same as collapsed mode) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                        <path fill-rule="evenodd" d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 18.375V5.625ZM21 9.375A.375.375 0 0 0 20.625 9h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5ZM10.875 18.75a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5ZM3.375 15h7.5a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375Zm0-3.75h7.5a.375.375 0 0 0 .375-.375v-1.5A.375.375 0 0 0 10.875 9h-7.5A.375.375 0 0 0 3 9.375v1.5c0 .207.168.375.375.375Z" clip-rule="evenodd" />
                                    </svg>
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
                            
                            <div x-show="weeklyOpen" x-collapse class="mt-1 relative">
                                <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                                <div class="space-y-1 ml-[30px]">
                                    <a href="{{ route('esd.showers') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.showers') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.showers') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Shower</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daily Group Desktop -->
                    <div class="relative">
                        <button 
                            x-show="!sidebarOpen"
                            @click="dailyOpen = !dailyOpen"
                            class="flex items-center justify-center w-full py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-zinc-600 dark:text-zinc-400"
                            title="Daily"
                        >
                            <!-- Icon Daily (Refresh/Update - same as expanded mode) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="sidebarOpen">
                            <button 
                                @click="dailyOpen = !dailyOpen"
                                class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                            >
                                <div class="flex items-center gap-2">
                                    <!-- Icon Daily (Refresh/Update - same as collapsed mode) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                        <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
                                    </svg>
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
                            
                            <div x-show="dailyOpen" x-collapse class="mt-1 relative">
                                <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                                <div class="space-y-1 ml-[30px]">
                                    <a href="{{ route('esd.insulatif-checks') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.insulatif-checks') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.insulatif-checks') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Insulatif Check</span>
                                    </a>
                                </div>
                            </div>

                            <div x-show="dailyOpen" x-collapse class="mt-1 relative">
                                <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                                <div class="space-y-1 ml-[30px]">
                                    <a href="{{ route('esd.patrols') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.patrols') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.patrols') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Patrol</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- New Admission Group Desktop -->
                    <div class="relative">
                        <button 
                            x-show="!sidebarOpen"
                            @click="newAdmissionOpen = !newAdmissionOpen"
                            class="flex items-center justify-center w-full py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-zinc-600 dark:text-zinc-400"
                            title="New Admission"
                        >
                            <!-- Icon New Admission (Download/Import - same as expanded mode) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path fill-rule="evenodd" d="M9.75 6.75h-3a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3h7.5a3 3 0 0 0 3-3v-7.5a3 3 0 0 0-3-3h-3V1.5a.75.75 0 0 0-1.5 0v5.25Zm0 0h1.5v5.69l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72V6.75Z" clip-rule="evenodd" />
                                <path d="M7.151 21.75a2.999 2.999 0 0 0 2.599 1.5h7.5a3 3 0 0 0 3-3v-7.5c0-1.11-.603-2.08-1.5-2.599v7.099a4.5 4.5 0 0 1-4.5 4.5H7.151Z" />
                            </svg>
                        </button>

                        <div x-show="sidebarOpen">
                            <button 
                                @click="newAdmissionOpen = !newAdmissionOpen"
                                class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors"
                            >
                                <div class="flex items-center gap-2">
                                    <!-- Icon New Admission (Download/Import - same as collapsed mode) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                        <path fill-rule="evenodd" d="M9.75 6.75h-3a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3h7.5a3 3 0 0 0 3-3v-7.5a3 3 0 0 0-3-3h-3V1.5a.75.75 0 0 0-1.5 0v5.25Zm0 0h1.5v5.69l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72V6.75Z" clip-rule="evenodd" />
                                        <path d="M7.151 21.75a2.999 2.999 0 0 0 2.599 1.5h7.5a3 3 0 0 0 3-3v-7.5c0-1.11-.603-2.08-1.5-2.599v7.099a4.5 4.5 0 0 1-4.5 4.5H7.151Z" />
                                    </svg>
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
                            
                            <div x-show="newAdmissionOpen" x-collapse class="mt-1 relative">
                                <div class="absolute top-0 bottom-0 w-px bg-zinc-200 dark:bg-zinc-700 left-5"></div>
                                <div class="space-y-1 ml-[30px]">
                                    <a href="{{ route('esd.gloves') }}" wire:navigate
                                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-colors {{ request()->routeIs('esd.gloves') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-200' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ request()->routeIs('esd.gloves') ? 'bg-blue-500' : 'bg-zinc-400 dark:bg-zinc-500' }}"></span>
                                        <span class="truncate">Glove</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

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