<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    <style>
        [x-cloak] { display: none !important; }
        
        /* Sidebar scrollbar hidden */
        .sidebar-scroll {
            overflow-y: auto !important;
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }
        .sidebar-scroll::-webkit-scrollbar {
            display: none !important;
        }
        
        /* Active menu styling */
        .menu-active {
            background-color: #e4e4e7;
            color: #18181b;
            border-right: 2px solid #000000;
        }
        .dark .menu-active {
            background-color: #3f3f46;
            color: #f4f4f5;
            border-right: 2px solid #ffffff;
        }
        
        /* Transition */
        .sidebar-transition {
            transition: width 0.3s ease-in-out;
        }
        
        /* Mobile sidebar */
        @media (max-width: 768px) {
            .sidebar-mobile {
                position: fixed;
                z-index: 40;
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            
            .sidebar-mobile.open {
                transform: translateX(0);
            }
            
            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 35;
                display: none;
            }
            
            .overlay.open {
                display: block;
            }
        }
        
        /* Group item styling */
        .group-items {
            margin-left: 2.5rem;
        }
        
        /* Animation for collapse */
        .x-collapse {
            transition: all 0.2s ease-out;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-zinc-900">

    <div x-data="sidebarPersistence()" x-init="init()" x-cloak class="flex min-h-screen">
        
        <!-- Overlay for mobile -->
        <div class="overlay" :class="{'open': sidebarOpen && isMobile}" @click="closeMobileSidebar"></div>
        
        <!-- SIDEBAR -->
        <aside x-ref="sidebar"
            @mouseenter="handleMouseEnter"
            @mouseleave="handleMouseLeave"
            class="bg-white dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700 shadow-lg h-screen overflow-hidden sidebar-transition"
            :class="{
                'fixed top-0 left-0 z-50': isMobile,
                'sticky top-0': !isMobile,
                'w-64': (!isMobile && ((sidebarOpen && !isMobile) || (isHovering && !sidebarPinned && !isMobile))) || (isMobile && sidebarOpen),
                'w-20': (!isMobile && (!sidebarOpen && !isMobile) && (!isHovering || sidebarPinned)),
                'hidden': isMobile && !sidebarOpen,
                'translate-x-0': isMobile && sidebarOpen,
                '-translate-x-full': isMobile && !sidebarOpen
            }"
            :style="(isHovering && !sidebarPinned && !isMobile) ? 'transition: width 0.2s ease-in-out;' : 'transition: width 0.3s ease-in-out;'">
            
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center px-4" 
                :class="{
                    'justify-between': isMobile && sidebarOpen,
                    'justify-center': (!isMobile && (sidebarOpen || (isHovering && !sidebarPinned))) || (isMobile && !sidebarOpen)
                }">
                <!-- Logo - Hanya tampil saat sidebar terbuka atau saat hover pada mode collapsed -->
                <div x-show="sidebarOpen || !isMobile || (isHovering && !sidebarPinned && !sidebarOpen)" 
                    x-cloak
                    class="flex justify-center w-full"
                    :class="{'hidden': !sidebarOpen && !isHovering && !sidebarPinned}">
                    <img src="{{ asset('images/siix-portal.png') }}" alt="SIIX Portal" class="h-13 w-auto object-contain" />
                </div>
                
                <!-- Close button for mobile -->
                <button x-show="isMobile && sidebarOpen" 
                        @click="closeMobileSidebar"
                        class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                    <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Sidebar Navigation -->
            <nav class="p-3 h-[calc(100%-4rem)] overflow-y-auto sidebar-scroll">
                
                <!-- Group: HOME -->
                <div class="mb-2">
                    <div class="relative w-full">
                        <button @click="toggleGroup('home')" 
                            class="w-full flex items-center px-3 py-2.5 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                            :class="{
                                'justify-center': (!sidebarOpen && !isMobile) && (!isHovering || sidebarPinned),
                                'justify-between': (sidebarOpen || isMobile) || (isHovering && !sidebarPinned)
                            }">
                            <div class="flex items-center gap-3" 
                                :class="{'justify-center': (!sidebarOpen && !isMobile) && (!isHovering || sidebarPinned)}">
                                <!-- Home Icon Solid -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                                    <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                                </svg>
                                <span x-show="(sidebarOpen || isMobile) || (isHovering && !sidebarPinned)" 
                                    class="text-sm font-medium text-zinc-700 dark:text-zinc-300 whitespace-nowrap">Home</span>
                            </div>
                            <!-- Chevron Icon -->
                            <svg x-show="(sidebarOpen || isMobile) || (isHovering && !sidebarPinned)" 
                                class="w-4 h-4 transition-transform duration-200 text-zinc-500 flex-shrink-0 ml-auto"
                                :class="{'rotate-180': groups.home.open}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Group Items -->
                    <div x-show="((sidebarOpen || isMobile) || (isHovering && !sidebarPinned)) && groups.home.open" 
                        x-collapse 
                        class="mt-1 space-y-1 ml-10">
                        <a href="{{ route('dashboard') }}" wire:navigate
                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('dashboard') ? 'menu-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0Z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3Z" clip-rule="evenodd" />
                            </svg>
                            <span class="truncate">Main Dashboard</span>
                        </a>
                        @can('view dcc-dashboard')
                        <a href="{{ route('dcc-dashboard') }}" wire:navigate
                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('dcc-dashboard') ? 'menu-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0Z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3Z" clip-rule="evenodd" />
                            </svg>
                            <span class="truncate">DCC Dashboard</span>
                        </a>
                        @endcan
                        @can('view hr-dashboard')
                        <a href="{{ route('hr-dashboard') }}" wire:navigate
                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('hr-dashboard') ? 'menu-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0Z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3Z" clip-rule="evenodd" />
                            </svg>
                            <span class="truncate">HR Dashboard</span>
                        </a>
                        @endcan
                        @can('view ticket-dashboard')
                        <a href="{{ route('ticket-dashboard') }}" wire:navigate
                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('ticket-dashboard') ? 'menu-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0Z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3Z" clip-rule="evenodd" />
                            </svg>
                            <span class="truncate">Ticket Dashboard</span>
                        </a>
                        @endcan
                        @can('view inbox')
                        <a href="{{ route('inbox') }}" wire:navigate
                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('inbox') ? 'menu-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                                <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                            </svg>
                            <span class="truncate">Inbox</span>
                            @php $inboxCount = App\Helpers\InboxHelper::getTotalInboxCount(); @endphp
                            @if($inboxCount > 0)
                            <span class="ml-auto bg-blue-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ $inboxCount }}</span>
                            @endif
                        </a>
                        @endcan
                    </div>
                </div>
                
                <!-- Group: MAINTENANCE -->
                @canany(['view maintenance'])
                <div class="mb-2">
                    <div class="relative w-full">
                        <button @click="toggleGroup('maintenance')" 
                                class="w-full flex items-center px-3 py-2.5 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                                :class="{
                                    'justify-center': (!sidebarOpen && !isMobile) && (!isHovering || sidebarPinned),
                                    'justify-between': (sidebarOpen || isMobile) || (isHovering && !sidebarPinned)
                                }">
                            <div class="flex items-center gap-3" 
                                :class="{'justify-center': (!sidebarOpen && !isMobile) && (!isHovering || sidebarPinned)}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clip-rule="evenodd" />
                                    <path d="m10.076 8.64-2.201-2.2V4.874a.75.75 0 0 0-.364-.643l-3.75-2.25a.75.75 0 0 0-.916.113l-.75.75a.75.75 0 0 0-.113.916l2.25 3.75a.75.75 0 0 0 .643.364h1.564l2.062 2.062 1.575-1.297Z" />
                                    <path fill-rule="evenodd" d="m12.556 17.329 4.183 4.182a3.375 3.375 0 0 0 4.773-4.773l-3.306-3.305a6.803 6.803 0 0 1-1.53.043c-.394-.034-.682-.006-.867.042a.589.589 0 0 0-.167.063l-3.086 3.748Zm3.414-1.36a.75.75 0 0 1 1.06 0l1.875 1.876a.75.75 0 1 1-1.06 1.06L15.97 17.03a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                                <span x-show="(sidebarOpen || isMobile) || (isHovering && !sidebarPinned)" 
                                    class="text-sm font-medium text-zinc-700 dark:text-zinc-300 whitespace-nowrap">Maintenance</span>
                            </div>
                            <svg x-show="(sidebarOpen || isMobile) || (isHovering && !sidebarPinned)" 
                                 class="w-4 h-4 transition-transform duration-200 text-zinc-500 flex-shrink-0 ml-auto"
                                 :class="{'rotate-180': groups.maintenance.open}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div x-show="((sidebarOpen || isMobile) || (isHovering && !sidebarPinned)) && groups.maintenance.open" 
                         x-collapse 
                         class="mt-1 space-y-1 ml-10">
                        @can('view equipment grounds')
                        <a href="{{ route('esd.equipment-grounds') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('esd.equipment-grounds') ? 'menu-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262l-10.5 11.25a.75.75 0 0 1-1.272-.71l1.992-7.302H3.75a.75.75 0 0 1-.548-1.262l10.5-11.25a.75.75 0 0 1 .913-.143Z" clip-rule="evenodd" />
                            </svg>
                            <span class="truncate">ESD Monitoring</span>
                        </a>
                        @endcan
                    </div>
                </div>
                @endcanany
                
                <!-- Group: DCC -->
                @canany(['view departments', 'view submissions'])
                <div class="mb-2">
                    <div class="relative w-full">
                        <button @click="toggleGroup('dcc')" 
                                class="w-full flex items-center px-3 py-2.5 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                                :class="{
                                    'justify-center': (!sidebarOpen && !isMobile) && (!isHovering || sidebarPinned),
                                    'justify-between': (sidebarOpen || isMobile) || (isHovering && !sidebarPinned)
                                }">
                            <div class="flex items-center gap-3" 
                                :class="{'justify-center': (!sidebarOpen && !isMobile) && (!isHovering || sidebarPinned)}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd" />
                                </svg>
                                <span x-show="(sidebarOpen || isMobile) || (isHovering && !sidebarPinned)" 
                                    class="text-sm font-medium text-zinc-700 dark:text-zinc-300 whitespace-nowrap">DCC</span>
                            </div>
                            <svg x-show="(sidebarOpen || isMobile) || (isHovering && !sidebarPinned)" 
                                 class="w-4 h-4 transition-transform duration-200 text-zinc-500 flex-shrink-0 ml-auto"
                                 :class="{'rotate-180': groups.dcc.open}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div x-show="((sidebarOpen || isMobile) || (isHovering && !sidebarPinned)) && groups.dcc.open" 
                         x-collapse 
                         class="mt-1 space-y-1 ml-10">
                        @can('view departments')
                        <a href="{{ route('dcc.departments') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('dcc.departments') ? 'menu-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path d="M19.006 3.705a.75.75 0 1 0-.512-1.41L6 6.838V3a.75.75 0 0 0-.75-.75h-1.5A.75.75 0 0 0 3 3v4.93l-1.006.365a.75.75 0 0 0 .512 1.41l16.5-6Z" />
                                <path fill-rule="evenodd" d="M3.019 11.114 18 5.667v3.421l4.006 1.457a.75.75 0 1 1-.512 1.41l-.494-.18v8.475h.75a.75.75 0 0 1 0 1.5H2.25a.75.75 0 0 1 0-1.5H3v-9.129l.019-.007ZM18 20.25v-9.566l1.5.546v9.02H18Zm-9-6a.75.75 0 0 0-.75.75v4.5c0 .414.336.75.75.75h3a.75.75 0 0 0 .75-.75V15a.75.75 0 0 0-.75-.75H9Z" clip-rule="evenodd" />
                            </svg>
                            <span class="truncate">Departments</span>
                        </a>
                        @endcan
                        @can('view submissions')
                        <a href="{{ route('dcc.submissions') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('dcc.submissions') ? 'menu-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M9.75 6.75h-3a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3h7.5a3 3 0 0 0 3-3v-7.5a3 3 0 0 0-3-3h-3V1.5a.75.75 0 0 0-1.5 0v5.25Zm0 0h1.5v5.69l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72V6.75Z" clip-rule="evenodd" />
                                <path d="M7.151 21.75a2.999 2.999 0 0 0 2.599 1.5h7.5a3 3 0 0 0 3-3v-7.5c0-1.11-.603-2.08-1.5-2.599v7.099a4.5 4.5 0 0 1-4.5 4.5H7.151Z" />
                            </svg>
                            <span class="truncate">Submissions</span>
                        </a>
                        @endcan
                    </div>
                </div>
                @endcanany
                
                <!-- Group: HR -->
                @canany(['view employee', 'view comelate employee', 'view violation employee', 'view employee call'])
                <div class="mb-2">
                    <div class="relative w-full">
                        <button @click="toggleGroup('hr')" 
                                class="w-full flex items-center px-3 py-2.5 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                                :class="{
                                    'justify-center': (!sidebarOpen && !isMobile) && (!isHovering || sidebarPinned),
                                    'justify-between': (sidebarOpen || isMobile) || (isHovering && !sidebarPinned)
                                }">
                            <div class="flex items-center gap-3" 
                                :class="{'justify-center': (!sidebarOpen && !isMobile) && (!isHovering || sidebarPinned)}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z" clip-rule="evenodd" />
                                    <path d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                                </svg>
                                <span x-show="(sidebarOpen || isMobile) || (isHovering && !sidebarPinned)" 
                                    class="text-sm font-medium text-zinc-700 dark:text-zinc-300 whitespace-nowrap">HR</span>
                            </div>
                            <svg x-show="(sidebarOpen || isMobile) || (isHovering && !sidebarPinned)" 
                                class="w-4 h-4 transition-transform duration-200 text-zinc-500 flex-shrink-0 ml-auto"
                                :class="{'rotate-180': groups.hr.open}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div x-show="((sidebarOpen || isMobile) || (isHovering && !sidebarPinned)) && groups.hr.open" 
                        x-collapse 
                        class="mt-1 space-y-1 ml-10">
                        @can('view employee')
                        <a href="{{ route('hr.employee') }}" wire:navigate
                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('hr.employee') ? 'menu-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                            </svg>
                            <span class="truncate">Master Employee</span>
                        </a>
                        @endcan
                        @can('view comelate employee')
                        <a href="{{ route('hr.comelate.index') }}" wire:navigate
                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('hr.comelate.index') ? 'menu-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm4.28 10.28a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 1 0-1.06 1.06l1.72 1.72H8.25a.75.75 0 0 0 0 1.5h5.69l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3Z" clip-rule="evenodd" />
                            </svg>
                            <span class="truncate">Comelate Employee</span>
                        </a>
                        @endcan
                        @can('view violation employee')
                        <a href="{{ route('hr.violation.index') }}" wire:navigate
                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('hr.violation.index') ? 'menu-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                            </svg>
                            <span class="truncate">Violation Employee</span>
                        </a>
                        @endcan
                        @can('view employee call')
                        <a href="{{ route('hr.employee-call.index') }}" wire:navigate
                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('hr.employee-call.index') ? 'menu-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M15 3.75a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0V5.56l-4.72 4.72a.75.75 0 1 1-1.06-1.06l4.72-4.72h-2.69a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                            </svg>
                            <span class="truncate">Employee Call</span>
                        </a>
                        @endcan
                        
                        <!-- Sub Group: Report -->
                        @canany(['view comelate report', 'view violation report'])
                        <div class="relative w-full mt-2">
                            <button @click="toggleGroup('hrReport')" 
                                    class="w-full flex items-center px-3 py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                                    :class="{
                                        'justify-center': (!sidebarOpen && !isMobile) && (!isHovering || sidebarPinned),
                                        'justify-between': (sidebarOpen || isMobile) || (isHovering && !sidebarPinned)
                                    }">
                                <div class="flex items-center gap-2" 
                                    :class="{'justify-center': (!sidebarOpen && !isMobile) && (!isHovering || sidebarPinned)}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z" clip-rule="evenodd" />
                                    </svg>
                                    <span x-show="(sidebarOpen || isMobile) || (isHovering && !sidebarPinned)" 
                                        class="text-sm font-medium text-zinc-700 dark:text-zinc-300 whitespace-nowrap">Report</span>
                                </div>
                                <svg x-show="(sidebarOpen || isMobile) || (isHovering && !sidebarPinned)" 
                                    class="w-4 h-4 transition-transform duration-200 text-zinc-500 flex-shrink-0 ml-auto"
                                    :class="{'rotate-180': groups.hrReport.open}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <div x-show="((sidebarOpen || isMobile) || (isHovering && !sidebarPinned)) && groups.hrReport.open" 
                            x-collapse 
                            class="mt-1 space-y-1 ml-8">
                            @can('view comelate report')
                            <a href="{{ route('hr.comelate.report') }}" wire:navigate
                            class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('hr.comelate.report') ? 'menu-active' : '' }}">
                                <span class="truncate">Comelate Report</span>
                            </a>
                            @endcan
                            @can('view violation report')
                            <a href="{{ route('hr.violation.report') }}" wire:navigate
                            class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('hr.violation.report') ? 'menu-active' : '' }}">
                                <span class="truncate">Violation Report</span>
                            </a>
                            @endcan
                        </div>
                        @endcanany
                    </div>
                </div>
                @endcanany
                
                <!-- Group: TICKETING SUPPORT -->
                @canany(['view categories', 'view tickets'])
                <div class="mb-2">
                    <div class="relative w-full">
                        <button @click="toggleGroup('ticketing')" 
                                class="w-full flex items-center px-3 py-2.5 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                                :class="{
                                    'justify-center': (!sidebarOpen && !isMobile) && (!isHovering || sidebarPinned),
                                    'justify-between': (sidebarOpen || isMobile) || (isHovering && !sidebarPinned)
                                }">
                            <div class="flex items-center gap-3" 
                                :class="{'justify-center': (!sidebarOpen && !isMobile) && (!isHovering || sidebarPinned)}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M19.5 9.75a.75.75 0 0 1-.75.75h-4.5a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 1 1.5 0v2.69l4.72-4.72a.75.75 0 1 1 1.06 1.06L16.06 9h2.69a.75.75 0 0 1 .75.75Z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                                </svg>
                                <span x-show="(sidebarOpen || isMobile) || (isHovering && !sidebarPinned)" 
                                    class="text-sm font-medium text-zinc-700 dark:text-zinc-300 whitespace-nowrap">Ticketing Support</span>
                            </div>
                            <svg x-show="(sidebarOpen || isMobile) || (isHovering && !sidebarPinned)" 
                                 class="w-4 h-4 transition-transform duration-200 text-zinc-500 flex-shrink-0 ml-auto"
                                 :class="{'rotate-180': groups.ticketing.open}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div x-show="((sidebarOpen || isMobile) || (isHovering && !sidebarPinned)) && groups.ticketing.open" 
                         x-collapse 
                         class="mt-1 space-y-1 ml-10">
                        @can('view categories')
                        <a href="{{ route('ticket.categories') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('ticket.categories') ? 'menu-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path d="M7.5 3.375c0-1.036.84-1.875 1.875-1.875h.375a3.75 3.75 0 0 1 3.75 3.75v1.875C13.5 8.161 14.34 9 15.375 9h1.875A3.75 3.75 0 0 1 21 12.75v3.375C21 17.16 20.16 18 19.125 18h-9.75A1.875 1.875 0 0 1 7.5 16.125V3.375Z" />
                                <path d="M15 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 17.25 7.5h-1.875A.375.375 0 0 1 15 7.125V5.25ZM4.875 6H6v10.125A3.375 3.375 0 0 0 9.375 19.5H16.5v1.125c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V7.875C3 6.839 3.84 6 4.875 6Z" />
                            </svg>
                            <span class="truncate">Category</span>
                        </a>
                        @endcan
                        @can('view tickets')
                        <a href="{{ route('ticket.list') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('ticket.list') ? 'menu-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M1.5 6.375c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v3.026a.75.75 0 0 1-.375.65 2.249 2.249 0 0 0 0 3.898.75.75 0 0 1 .375.65v3.026c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 17.625v-3.026a.75.75 0 0 1 .374-.65 2.249 2.249 0 0 0 0-3.898.75.75 0 0 1-.374-.65V6.375Zm15-1.125a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-1.5 0V6a.75.75 0 0 1 .75-.75Zm.75 4.5a.75.75 0 0 0-1.5 0v.75a.75.75 0 0 0 1.5 0v-.75Zm-.75 3a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-1.5 0v-.75a.75.75 0 0 1 .75-.75Zm.75 4.5a.75.75 0 0 0-1.5 0V18a.75.75 0 0 0 1.5 0v-.75ZM6 12a.75.75 0 0 1 .75-.75H12a.75.75 0 0 1 0 1.5H6.75A.75.75 0 0 1 6 12Zm.75 2.25a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" clip-rule="evenodd" />
                            </svg>
                            <span class="truncate">Ticket</span>
                        </a>
                        @endcan
                    </div>
                </div>
                @endcanany
                
                <!-- Group: SETTINGS -->
                @canany(['view users', 'view notification', 'view roles', 'view permissions'])
                <div class="mb-2">
                    <div class="relative w-full">
                        <button @click="toggleGroup('settings')" 
                                class="w-full flex items-center px-3 py-2.5 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                                :class="{
                                    'justify-center': (!sidebarOpen && !isMobile) && (!isHovering || sidebarPinned),
                                    'justify-between': (sidebarOpen || isMobile) || (isHovering && !sidebarPinned)
                                }">
                            <div class="flex items-center gap-3" 
                                :class="{'justify-center': (!sidebarOpen && !isMobile) && (!isHovering || sidebarPinned)}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 0 1-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 0 1 6.126 3.537ZM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 0 1 0 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 0 1 6.75 12a5.23 5.23 0 0 1 1.37-3.536ZM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 0 1 .65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 0 1-6.126 3.539Z" />
                                    <path fill-rule="evenodd" d="M21 12.75a.75.75 0 1 0 0-1.5h-.783a8.22 8.22 0 0 0-.237-1.357l.734-.267a.75.75 0 1 0-.513-1.41l-.735.268a8.24 8.24 0 0 0-.689-1.192l.6-.503a.75.75 0 1 0-.964-1.149l-.6.504a8.3 8.3 0 0 0-1.054-.885l.391-.678a.75.75 0 1 0-1.299-.75l-.39.676a8.188 8.188 0 0 0-1.295-.47l.136-.77a.75.75 0 0 0-1.477-.26l-.136.77a8.36 8.36 0 0 0-1.377 0l-.136-.77a.75.75 0 1 0-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 0 0-1.3.75l.392.678a8.29 8.29 0 0 0-1.054.885l-.6-.504a.75.75 0 1 0-.965 1.149l.6.503a8.243 8.243 0 0 0-.689 1.192L3.8 8.216a.75.75 0 1 0-.513 1.41l.735.267a8.222 8.222 0 0 0-.238 1.356h-.783a.75.75 0 0 0 0 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 0 0 .513 1.41l.735-.268c.197.417.428.816.69 1.191l-.6.504a.75.75 0 0 0 .963 1.15l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 0 0 1.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.77a.75.75 0 0 0 1.477.261l.137-.772a8.332 8.332 0 0 0 1.376 0l.136.772a.75.75 0 1 0 1.477-.26l-.136-.771a8.19 8.19 0 0 0 1.294-.47l.391.677a.75.75 0 0 0 1.3-.75l-.393-.679a8.29 8.29 0 0 0 1.054-.885l.601.504a.75.75 0 0 0 .964-1.15l-.6-.503c.261-.375.492-.774.69-1.191l.735.267a.75.75 0 1 0 .512-1.41l-.734-.267c.115-.439.195-.892.237-1.356h.784Zm-2.657-3.06a6.744 6.744 0 0 0-1.19-2.053 6.784 6.784 0 0 0-1.82-1.51A6.705 6.705 0 0 0 12 5.25a6.8 6.8 0 0 0-1.225.11 6.7 6.7 0 0 0-2.15.793 6.784 6.784 0 0 0-2.952 3.489.76.76 0 0 1-.036.098A6.74 6.74 0 0 0 5.251 12a6.74 6.74 0 0 0 3.366 5.842l.009.005a6.704 6.704 0 0 0 2.18.798l.022.003a6.792 6.792 0 0 0 2.368-.004 6.704 6.704 0 0 0 2.205-.811 6.785 6.785 0 0 0 1.762-1.484l.009-.01.009-.01a6.743 6.743 0 0 0 1.18-2.066c.253-.707.39-1.469.39-2.263a6.74 6.74 0 0 0-.408-2.309Z" clip-rule="evenodd" />
                                </svg>
                                <span x-show="(sidebarOpen || isMobile) || (isHovering && !sidebarPinned)" 
                                    class="text-sm font-medium text-zinc-700 dark:text-zinc-300 whitespace-nowrap">Settings</span>
                            </div>
                            <svg x-show="(sidebarOpen || isMobile) || (isHovering && !sidebarPinned)" 
                                class="w-4 h-4 transition-transform duration-200 text-zinc-500 flex-shrink-0 ml-auto"
                                :class="{'rotate-180': groups.settings.open}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div x-show="((sidebarOpen || isMobile) || (isHovering && !sidebarPinned)) && groups.settings.open" 
                        x-collapse 
                        class="mt-1 space-y-1 ml-10">
                        
                        @can('view users')
                        <a href="{{ route('users') }}" wire:navigate
                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('users') ? 'menu-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                            </svg>
                            <span class="truncate">Users</span>
                        </a>
                        @endcan
                        
                        @can('view notification')
                        <a href="{{ route('notifications.manager') }}" wire:navigate
                        class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('notifications.manager') ? 'menu-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path d="M5.85 3.5a.75.75 0 0 0-1.117-1 9.719 9.719 0 0 0-2.348 4.876.75.75 0 0 0 1.479.248A8.219 8.219 0 0 1 5.85 3.5ZM19.267 2.5a.75.75 0 1 0-1.118 1 8.22 8.22 0 0 1 1.987 4.124.75.75 0 0 0 1.48-.248A9.72 9.72 0 0 0 19.266 2.5Z" />
                                <path fill-rule="evenodd" d="M12 2.25A6.75 6.75 0 0 0 5.25 9v.75a8.217 8.217 0 0 1-2.119 5.52.75.75 0 0 0 .298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 1 0 7.48 0 24.583 24.583 0 0 0 4.83-1.244.75.75 0 0 0 .298-1.205 8.217 8.217 0 0 1-2.118-5.52V9A6.75 6.75 0 0 0 12 2.25ZM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 0 0 4.496 0l.002.1a2.25 2.25 0 1 1-4.5 0Z" clip-rule="evenodd" />
                            </svg>
                            <span class="truncate">Notification</span>
                        </a>
                        @endcan
                        
                        <!-- Sub Group: AUTH -->
                        @canany(['view roles', 'view permissions'])
                        <div class="relative w-full mt-2">
                            <button @click="toggleGroup('auth')" 
                                    class="w-full flex items-center px-3 py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                                    :class="{
                                        'justify-center': (!sidebarOpen && !isMobile) && (!isHovering || sidebarPinned),
                                        'justify-between': (sidebarOpen || isMobile) || (isHovering && !sidebarPinned)
                                    }">
                                <div class="flex items-center gap-2" 
                                    :class="{'justify-center': (!sidebarOpen && !isMobile) && (!isHovering || sidebarPinned)}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                                    </svg>
                                    <span x-show="(sidebarOpen || isMobile) || (isHovering && !sidebarPinned)" 
                                        class="text-sm font-medium text-zinc-700 dark:text-zinc-300 whitespace-nowrap">Auth</span>
                                </div>
                                <svg x-show="(sidebarOpen || isMobile) || (isHovering && !sidebarPinned)" 
                                    class="w-4 h-4 transition-transform duration-200 text-zinc-500 flex-shrink-0 ml-auto"
                                    :class="{'rotate-180': groups.auth.open}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <div x-show="((sidebarOpen || isMobile) || (isHovering && !sidebarPinned)) && groups.auth.open" 
                            x-collapse 
                            class="mt-1 space-y-1 ml-8">
                            @can('view roles')
                            <a href="{{ route('role.management') }}" wire:navigate
                            class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('role.management') ? 'menu-active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 0 0-1.032 0 11.209 11.209 0 0 1-7.877 3.08.75.75 0 0 0-.722.515A12.74 12.74 0 0 0 2.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 0 0 .374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 0 0-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08Zm3.094 8.016a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                </svg>
                                <span class="truncate">Roles</span>
                            </a>
                            @endcan
                            @can('view permissions')
                            <a href="{{ route('permission.management') }}" wire:navigate
                            class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 transition-colors {{ request()->routeIs('permission.management') ? 'menu-active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path d="M18.75 12.75h1.5a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM12 6a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 6ZM12 18a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 18ZM3.75 6.75h1.5a.75.75 0 1 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM5.25 18.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 0 1.5ZM3 12a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 3 12ZM9 3.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM12.75 12a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0ZM9 15.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                                </svg>
                                <span class="truncate">Permissions</span>
                            </a>
                            @endcan
                        </div>
                        @endcanany
                    </div>
                </div>
                @endcanany
                
            </nav>
        </aside>
        
        <!-- MAIN CONTENT -->
        <main class="flex-1 min-w-0 bg-gray-100 dark:bg-black">
            <flux:header class="sticky top-0 z-10 block! bg-white dark:bg-black border-b border-zinc-200 dark:border-zinc-800 p-0! m-0! w-full shadow-sm">
                <flux:navbar class="flex items-center justify-between px-3 lg:px-4 mx-0!">
                    <div class="flex items-center gap-3">
                        <button @click="toggleSidebar" 
                                class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                            <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        <livewire:header-badge />
                    </div>
                    
                    <div class="flex items-center gap-1 sm:gap-2">
                        <a href="{{ route('profile.edit') }}" 
                            class="flex items-center gap-2 rounded-lg !p-2 lg:!p-2.5 
                                text-zinc-700 dark:text-zinc-300 
                                hover:text-zinc-900 dark:hover:text-zinc-100 
                                hover:bg-zinc-100 dark:hover:bg-zinc-800 
                                focus:bg-zinc-100 dark:focus:bg-zinc-800
                                focus:outline-none focus:ring-2 focus:ring-zinc-400/30
                                transition-all duration-200">
                            <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="hidden lg:inline text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                {{ auth()->user()->name }}
                            </span>
                        </a>

                        <flux:separator vertical class="my-2" />
                        
                        <button 
                            x-data
                            @click="$flux.dark = ! $flux.dark"
                            class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                            :aria-label="$flux.dark ? 'Switch to light mode' : 'Switch to dark mode'">
                            <svg x-show="!$flux.dark" class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <svg x-show="$flux.dark" class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                        </button>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <flux:button type="submit" variant="danger" icon="arrow-right" size="sm">
                                <span class="hidden lg:inline">{{ __('Logout') }}</span>
                            </flux:button>
                        </form>
                    </div>
                </flux:navbar>
            </flux:header>
            
            <div class="p-1 lg:p-2">
                {{ $slot }}
            </div>
        </main>
    </div>

    @fluxScripts

    <script>
        function sidebarPersistence() {
            return {
                sidebarOpen: true,
                sidebarPinned: true,
                isMobile: window.innerWidth < 768,
                isHovering: false,
                groups: {
                    home: { open: true },
                    maintenance: { open: true },
                    dcc: { open: true },
                    hr: { open: true },
                    hrReport: { open: false },
                    ticketing: { open: true },
                    settings: { open: true },
                    auth: { open: true }
                },
                
                init() {
                    // Check if mobile
                    window.addEventListener('resize', () => {
                        this.isMobile = window.innerWidth < 768;
                        if (this.isMobile) {
                            this.sidebarOpen = false;
                            this.sidebarPinned = false;
                        } else {
                            // Load pinned state from localStorage
                            const savedPinned = localStorage.getItem('sidebar_pinned');
                            if (savedPinned !== null) {
                                this.sidebarPinned = JSON.parse(savedPinned);
                                this.sidebarOpen = this.sidebarPinned;
                            }
                        }
                    });
                    
                    // Load sidebar open state
                    const savedSidebarOpen = localStorage.getItem('sidebar_open');
                    if (savedSidebarOpen !== null && !this.isMobile) {
                        this.sidebarOpen = JSON.parse(savedSidebarOpen);
                        this.sidebarPinned = this.sidebarOpen;
                    } else if (this.isMobile) {
                        this.sidebarOpen = false;
                        this.sidebarPinned = false;
                    }
                    
                    // Load all group states
                    const groupNames = ['home', 'maintenance', 'dcc', 'hr', 'hrReport', 'ticketing', 'settings', 'auth'];
                    groupNames.forEach(groupName => {
                        const saved = localStorage.getItem(`sidebar_group_${groupName}`);
                        if (saved !== null) {
                            this.groups[groupName].open = JSON.parse(saved);
                        }
                    });
                    
                    // Watch sidebar changes
                    this.$watch('sidebarOpen', value => {
                        if (!this.isMobile && !this.isHovering) {
                            this.sidebarPinned = value;
                            localStorage.setItem('sidebar_open', JSON.stringify(value));
                            localStorage.setItem('sidebar_pinned', JSON.stringify(value));
                        }
                    });
                },
                
                toggleSidebar() {
                    if (this.isMobile) {
                        this.sidebarOpen = !this.sidebarOpen;
                    } else {
                        this.sidebarPinned = !this.sidebarPinned;
                        this.sidebarOpen = this.sidebarPinned;
                        this.isHovering = false;
                        localStorage.setItem('sidebar_pinned', JSON.stringify(this.sidebarPinned));
                    }
                },
                
                handleMouseEnter() {
                    if (!this.isMobile && !this.sidebarPinned) {
                        this.isHovering = true;
                        this.sidebarOpen = true;
                    }
                },
                
                handleMouseLeave() {
                    if (!this.isMobile && !this.sidebarPinned) {
                        this.isHovering = false;
                        this.sidebarOpen = false;
                    }
                },
                
                closeMobileSidebar() {
                    if (this.isMobile) {
                        this.sidebarOpen = false;
                    }
                },
                
                toggleGroup(groupName) {
                    this.groups[groupName].open = !this.groups[groupName].open;
                    localStorage.setItem(`sidebar_group_${groupName}`, JSON.stringify(this.groups[groupName].open));
                }
            }
        }
    </script>

</body>
</html>