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

        /* Tooltip styles */
        .tooltip {
            position: relative;
            display: inline-block;
        }
        
        .tooltip .tooltip-card {
            visibility: hidden;
            opacity: 0;
            position: fixed;
            z-index: 50;
            background-color: #1f2937;
            color: #f3f4f6;
            text-align: left;
            border-radius: 0.5rem;
            padding: 0.75rem;
            min-width: 200px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transition: opacity 0.2s, visibility 0.2s;
            pointer-events: none;
            white-space: nowrap;
        }
        
        .dark .tooltip .tooltip-card {
            background-color: #374151;
            color: #f3f4f6;
        }
        
        .tooltip:hover .tooltip-card {
            visibility: visible;
            opacity: 1;
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
    </style>
</head>

<body class="bg-gray-100 dark:bg-zinc-900">

    <div x-data="sidebarPersistence()" x-init="init()" x-cloak class="flex min-h-screen">
        
        <!-- Overlay for mobile -->
        <div class="overlay" :class="{'open': sidebarOpen && isMobile}"></div>
        
        <!-- SIDEBAR -->
        <aside class="bg-white dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700 shadow-lg h-screen sticky top-0 overflow-hidden sidebar-transition"
               :class="{
                   'w-64': sidebarOpen && !isMobile,
                   'w-20': !sidebarOpen && !isMobile,
                   'sidebar-mobile': isMobile,
                   'open': sidebarOpen && isMobile
               }"
               style="transition: width 0.3s ease-in-out;">
            
            <!-- Sidebar Header without bottom border -->
            <div class="h-16 flex items-center justify-center px-4">
                <div x-show="sidebarOpen" class="flex justify-center w-full">
                    <img src="{{ asset('images/siix-portal.png') }}" alt="SIIX Portal" class="h-10 w-auto object-contain" />
                </div>
                <!-- SP icon removed when collapsed -->
            </div>
            
            <!-- Sidebar Navigation -->
            <nav class="p-3 h-[calc(100%-4rem)] overflow-y-auto sidebar-scroll">
                
                <!-- Group: HOME -->
                <div class="mb-2">
                    <div class="relative tooltip" @mouseenter="updateTooltipPosition($event)" @mouseleave="hideTooltip">
                        <button @click="toggleGroup('home')" 
                                class="w-full flex items-center justify-center md:justify-between px-3 py-2.5 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                                :class="{'justify-center': !sidebarOpen && !isMobile, 'justify-between': sidebarOpen || isMobile}">
                            <div class="flex items-center gap-3" :class="{'justify-center': !sidebarOpen && !isMobile}">
                                <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span x-show="sidebarOpen || isMobile" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Home</span>
                            </div>
                            <svg x-show="sidebarOpen || isMobile" 
                                 class="w-4 h-4 transition-transform duration-200 text-zinc-500"
                                 :class="{'rotate-180': groups.home.open}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Tooltip card for collapsed mode -->
                        <div x-show="!sidebarOpen && !isMobile" 
                             class="tooltip-card"
                             :style="tooltipStyle">
                            <div class="font-semibold mb-2">Home</div>
                            <div class="space-y-1 text-sm">
                                <a href="{{ route('dashboard') }}" wire:navigate class="block hover:text-cyan-400">Main Dashboard</a>
                                @can('view dcc-dashboard')
                                <a href="{{ route('dcc-dashboard') }}" wire:navigate class="block hover:text-cyan-400">DCC Dashboard</a>
                                @endcan
                                @can('view hr-dashboard')
                                <a href="{{ route('hr-dashboard') }}" wire:navigate class="block hover:text-cyan-400">HR Dashboard</a>
                                @endcan
                                @can('view ticket-dashboard')
                                <a href="{{ route('ticket-dashboard') }}" wire:navigate class="block hover:text-cyan-400">Ticket Dashboard</a>
                                @endcan
                                @can('view inbox')
                                <a href="{{ route('inbox') }}" wire:navigate class="block hover:text-cyan-400">Inbox</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    
                    <div x-show="(sidebarOpen || isMobile) && groups.home.open" x-collapse class="mt-1 ml-10 space-y-1">
                        <a href="{{ route('dashboard') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 {{ request()->routeIs('dashboard') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span>Main Dashboard</span>
                        </a>
                        @can('view dcc-dashboard')
                        <a href="{{ route('dcc-dashboard') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 {{ request()->routeIs('dcc-dashboard') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span>DCC Dashboard</span>
                        </a>
                        @endcan
                        @can('view hr-dashboard')
                        <a href="{{ route('hr-dashboard') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 {{ request()->routeIs('hr-dashboard') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span>HR Dashboard</span>
                        </a>
                        @endcan
                        @can('view ticket-dashboard')
                        <a href="{{ route('ticket-dashboard') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 {{ request()->routeIs('ticket-dashboard') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"></path>
                            </svg>
                            <span>Ticket Dashboard</span>
                        </a>
                        @endcan
                        @can('view inbox')
                        <a href="{{ route('inbox') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 {{ request()->routeIs('inbox') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <span>Inbox</span>
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
                    <div class="relative tooltip" @mouseenter="updateTooltipPosition($event)" @mouseleave="hideTooltip">
                        <button @click="toggleGroup('maintenance')" 
                                class="w-full flex items-center justify-center md:justify-between px-3 py-2.5 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                                :class="{'justify-center': !sidebarOpen && !isMobile, 'justify-between': sidebarOpen || isMobile}">
                            <div class="flex items-center gap-3" :class="{'justify-center': !sidebarOpen && !isMobile}">
                                <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                </svg>
                                <span x-show="sidebarOpen || isMobile" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Maintenance</span>
                            </div>
                            <svg x-show="sidebarOpen || isMobile" 
                                 class="w-4 h-4 transition-transform duration-200 text-zinc-500"
                                 :class="{'rotate-180': groups.maintenance.open}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="!sidebarOpen && !isMobile" class="tooltip-card" :style="tooltipStyle">
                            <div class="font-semibold mb-2">Maintenance</div>
                            <div class="space-y-1 text-sm">
                                @can('view equipment grounds')
                                <a href="{{ route('esd.equipment-grounds') }}" wire:navigate class="block hover:text-cyan-400">ESD Monitoring</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    
                    <div x-show="(sidebarOpen || isMobile) && groups.maintenance.open" x-collapse class="mt-1 ml-10 space-y-1">
                        @can('view equipment grounds')
                        <a href="{{ route('esd.equipment-grounds') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 {{ request()->routeIs('esd.equipment-grounds') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span>ESD Monitoring</span>
                        </a>
                        @endcan
                    </div>
                </div>
                @endcanany
                
                <!-- Group: DCC -->
                @canany(['view departments', 'view submissions'])
                <div class="mb-2">
                    <div class="relative tooltip" @mouseenter="updateTooltipPosition($event)" @mouseleave="hideTooltip">
                        <button @click="toggleGroup('dcc')" 
                                class="w-full flex items-center justify-center md:justify-between px-3 py-2.5 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                                :class="{'justify-center': !sidebarOpen && !isMobile, 'justify-between': sidebarOpen || isMobile}">
                            <div class="flex items-center gap-3" :class="{'justify-center': !sidebarOpen && !isMobile}">
                                <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                </svg>
                                <span x-show="sidebarOpen || isMobile" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">DCC</span>
                            </div>
                            <svg x-show="sidebarOpen || isMobile" 
                                 class="w-4 h-4 transition-transform duration-200 text-zinc-500"
                                 :class="{'rotate-180': groups.dcc.open}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="!sidebarOpen && !isMobile" class="tooltip-card" :style="tooltipStyle">
                            <div class="font-semibold mb-2">DCC</div>
                            <div class="space-y-1 text-sm">
                                @can('view departments')
                                <a href="{{ route('dcc.departments') }}" wire:navigate class="block hover:text-cyan-400">Departments</a>
                                @endcan
                                @can('view submissions')
                                <a href="{{ route('dcc.submissions') }}" wire:navigate class="block hover:text-cyan-400">Submissions</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    
                    <div x-show="(sidebarOpen || isMobile) && groups.dcc.open" x-collapse class="mt-1 ml-10 space-y-1">
                        @can('view departments')
                        <a href="{{ route('dcc.departments') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 {{ request()->routeIs('dcc.departments') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span>Departments</span>
                        </a>
                        @endcan
                        @can('view submissions')
                        <a href="{{ route('dcc.submissions') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 {{ request()->routeIs('dcc.submissions') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Submissions</span>
                        </a>
                        @endcan
                    </div>
                </div>
                @endcanany
                
                <!-- Continue with HR, TICKETING, SETTINGS groups similarly -->
                <!-- Group: HR -->
                @canany(['view employee', 'view comelate employee', 'view violation employee', 'view employee call'])
                <div class="mb-2">
                    <div class="relative tooltip" @mouseenter="updateTooltipPosition($event)" @mouseleave="hideTooltip">
                        <button @click="toggleGroup('hr')" 
                                class="w-full flex items-center justify-center md:justify-between px-3 py-2.5 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                                :class="{'justify-center': !sidebarOpen && !isMobile, 'justify-between': sidebarOpen || isMobile}">
                            <div class="flex items-center gap-3" :class="{'justify-center': !sidebarOpen && !isMobile}">
                                <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span x-show="sidebarOpen || isMobile" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">HR</span>
                            </div>
                            <svg x-show="sidebarOpen || isMobile" 
                                 class="w-4 h-4 transition-transform duration-200 text-zinc-500"
                                 :class="{'rotate-180': groups.hr.open}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="!sidebarOpen && !isMobile" class="tooltip-card" :style="tooltipStyle">
                            <div class="font-semibold mb-2">HR</div>
                            <div class="space-y-1 text-sm">
                                @can('view employee')
                                <a href="{{ route('hr.employee') }}" wire:navigate class="block hover:text-cyan-400">Master Employee</a>
                                @endcan
                                @can('view comelate employee')
                                <a href="{{ route('hr.comelate.index') }}" wire:navigate class="block hover:text-cyan-400">Comelate Employee</a>
                                @endcan
                                @can('view violation employee')
                                <a href="{{ route('hr.violation.index') }}" wire:navigate class="block hover:text-cyan-400">Violation Employee</a>
                                @endcan
                                @can('view employee call')
                                <a href="{{ route('hr.employee-call.index') }}" wire:navigate class="block hover:text-cyan-400">Employee Call</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    
                    <div x-show="(sidebarOpen || isMobile) && groups.hr.open" x-collapse class="mt-1 ml-10 space-y-1">
                        <!-- HR menu items here (same as original) -->
                        @can('view employee')
                        <a href="{{ route('hr.employee') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 {{ request()->routeIs('hr.employee') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Master Employee</span>
                        </a>
                        @endcan
                        @can('view comelate employee')
                        <a href="{{ route('hr.comelate.index') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 {{ request()->routeIs('hr.comelate.index') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Comelate Employee</span>
                        </a>
                        @endcan
                        @can('view violation employee')
                        <a href="{{ route('hr.violation.index') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 {{ request()->routeIs('hr.violation.index') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span>Violation Employee</span>
                        </a>
                        @endcan
                        @can('view employee call')
                        <a href="{{ route('hr.employee-call.index') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 {{ request()->routeIs('hr.employee-call.index') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>Employee Call</span>
                        </a>
                        @endcan
                    </div>
                </div>
                @endcanany
                
                <!-- Group: TICKETING SUPPORT -->
                @canany(['view categories', 'view tickets'])
                <div class="mb-2">
                    <div class="relative tooltip" @mouseenter="updateTooltipPosition($event)" @mouseleave="hideTooltip">
                        <button @click="toggleGroup('ticketing')" 
                                class="w-full flex items-center justify-center md:justify-between px-3 py-2.5 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                                :class="{'justify-center': !sidebarOpen && !isMobile, 'justify-between': sidebarOpen || isMobile}">
                            <div class="flex items-center gap-3" :class="{'justify-center': !sidebarOpen && !isMobile}">
                                <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                                </svg>
                                <span x-show="sidebarOpen || isMobile" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Ticketing Support</span>
                            </div>
                            <svg x-show="sidebarOpen || isMobile" 
                                 class="w-4 h-4 transition-transform duration-200 text-zinc-500"
                                 :class="{'rotate-180': groups.ticketing.open}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="!sidebarOpen && !isMobile" class="tooltip-card" :style="tooltipStyle">
                            <div class="font-semibold mb-2">Ticketing Support</div>
                            <div class="space-y-1 text-sm">
                                @can('view categories')
                                <a href="{{ route('ticket.categories') }}" wire:navigate class="block hover:text-cyan-400">Category</a>
                                @endcan
                                @can('view tickets')
                                <a href="{{ route('ticket.list') }}" wire:navigate class="block hover:text-cyan-400">Ticket</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    
                    <div x-show="(sidebarOpen || isMobile) && groups.ticketing.open" x-collapse class="mt-1 ml-10 space-y-1">
                        @can('view categories')
                        <a href="{{ route('ticket.categories') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 {{ request()->routeIs('ticket.categories') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                            </svg>
                            <span>Category</span>
                        </a>
                        @endcan
                        @can('view tickets')
                        <a href="{{ route('ticket.list') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 {{ request()->routeIs('ticket.list') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"></path>
                            </svg>
                            <span>Ticket</span>
                        </a>
                        @endcan
                    </div>
                </div>
                @endcanany
                
                <!-- Group: SETTINGS -->
                @canany(['view users', 'view roles', 'view permissions'])
                <div class="mb-2">
                    <div class="relative tooltip" @mouseenter="updateTooltipPosition($event)" @mouseleave="hideTooltip">
                        <button @click="toggleGroup('settings')" 
                                class="w-full flex items-center justify-center md:justify-between px-3 py-2.5 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                                :class="{'justify-center': !sidebarOpen && !isMobile, 'justify-between': sidebarOpen || isMobile}">
                            <div class="flex items-center gap-3" :class="{'justify-center': !sidebarOpen && !isMobile}">
                                <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                </svg>
                                <span x-show="sidebarOpen || isMobile" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Settings</span>
                            </div>
                            <svg x-show="sidebarOpen || isMobile" 
                                 class="w-4 h-4 transition-transform duration-200 text-zinc-500"
                                 :class="{'rotate-180': groups.settings.open}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="!sidebarOpen && !isMobile" class="tooltip-card" :style="tooltipStyle">
                            <div class="font-semibold mb-2">Settings</div>
                            <div class="space-y-1 text-sm">
                                @can('view users')
                                <a href="{{ route('users') }}" wire:navigate class="block hover:text-cyan-400">Users</a>
                                @endcan
                                @can('view notification')
                                <a href="{{ route('notifications.manager') }}" wire:navigate class="block hover:text-cyan-400">Notification</a>
                                @endcan
                                @can('view roles')
                                <a href="{{ route('role.management') }}" wire:navigate class="block hover:text-cyan-400">Roles</a>
                                @endcan
                                @can('view permissions')
                                <a href="{{ route('permission.management') }}" wire:navigate class="block hover:text-cyan-400">Permissions</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    
                    <div x-show="(sidebarOpen || isMobile) && groups.settings.open" x-collapse class="mt-1 ml-10 space-y-1">
                        @can('view users')
                        <a href="{{ route('users') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 {{ request()->routeIs('users') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span>Users</span>
                        </a>
                        @endcan
                        @can('view notification')
                        <a href="{{ route('notifications.manager') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 {{ request()->routeIs('notifications.manager') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span>Notification</span>
                        </a>
                        @endcan
                        @can('view roles')
                        <a href="{{ route('role.management') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 {{ request()->routeIs('role.management') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <span>Roles</span>
                        </a>
                        @endcan
                        @can('view permissions')
                        <a href="{{ route('permission.management') }}" wire:navigate
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-400 {{ request()->routeIs('permission.management') ? 'menu-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <span>Permissions</span>
                        </a>
                        @endcan
                    </div>
                </div>
                @endcanany
                
            </nav>
        </aside>
        
        <!-- MAIN CONTENT -->
        <main class="flex-1 min-w-0 bg-gray-100 dark:bg-zinc-900">
            <flux:header class="sticky top-0 z-10 block! bg-white lg:bg-zinc-100 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-600 p-0! m-0! w-full shadow-sm">
                <flux:navbar class="flex items-center justify-between px-3 lg:px-4 mx-0!">
                    <div class="flex items-center gap-3">
                        <!-- Collapse button moved to header -->
                        <button @click="toggleSidebar" 
                                class="p-2 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        <livewire:header-badge />
                    </div>
                    
                    <div class="flex items-center gap-1 sm:gap-2">
                        <a href="{{ route('profile.edit') }}" 
                            class="flex items-center gap-2 rounded-lg !p-2 lg:!p-2.5 
                                text-zinc-700 dark:text-zinc-200 
                                hover:text-zinc-900 dark:hover:text-white 
                                hover:bg-zinc-200 dark:hover:bg-zinc-700 
                                focus:bg-zinc-200 dark:focus:bg-zinc-700
                                focus:outline-none focus:ring-2 focus:ring-zinc-400/30
                                transition-all duration-200">
                            <flux:icon.user class="w-5 h-5" />
                            <span class="hidden lg:inline text-sm font-medium">
                                {{ auth()->user()->name }}
                            </span>
                        </a>

                        <flux:separator vertical class="my-2" />
                        
                        <button 
                            x-data
                            @click="$flux.dark = ! $flux.dark"
                            class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                            :aria-label="$flux.dark ? 'Switch to light mode' : 'Switch to dark mode'">
                            <svg x-show="!$flux.dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <svg x-show="$flux.dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                isMobile: window.innerWidth < 768,
                tooltipStyle: { left: '0px', top: '0px' },
                groups: {
                    home: { open: true },
                    maintenance: { open: true },
                    dcc: { open: true },
                    hr: { open: true },
                    hrReporting: { open: true },
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
                        }
                    });
                    
                    // Load sidebar open state
                    const savedSidebarOpen = localStorage.getItem('sidebar_open');
                    if (savedSidebarOpen !== null && !this.isMobile) {
                        this.sidebarOpen = JSON.parse(savedSidebarOpen);
                    } else if (this.isMobile) {
                        this.sidebarOpen = false;
                    }
                    
                    // Load all group states
                    const groupNames = ['home', 'maintenance', 'dcc', 'hr', 'hrReporting', 'ticketing', 'settings', 'auth'];
                    groupNames.forEach(groupName => {
                        const saved = localStorage.getItem(`sidebar_group_${groupName}`);
                        if (saved !== null) {
                            this.groups[groupName].open = JSON.parse(saved);
                        }
                    });
                    
                    // Watch sidebar changes
                    this.$watch('sidebarOpen', value => {
                        if (!this.isMobile) {
                            localStorage.setItem('sidebar_open', JSON.stringify(value));
                        }
                    });
                },
                
                toggleSidebar() {
                    this.sidebarOpen = !this.sidebarOpen;
                },
                
                toggleGroup(groupName) {
                    this.groups[groupName].open = !this.groups[groupName].open;
                    localStorage.setItem(`sidebar_group_${groupName}`, JSON.stringify(this.groups[groupName].open));
                },
                
                updateTooltipPosition(event) {
                    const rect = event.currentTarget.getBoundingClientRect();
                    this.tooltipStyle = {
                        left: (rect.right + 10) + 'px',
                        top: (rect.top - 10) + 'px'
                    };
                },
                
                hideTooltip() {
                    this.tooltipStyle = { left: '0px', top: '0px' };
                }
            }
        }
    </script>

</body>
</html>