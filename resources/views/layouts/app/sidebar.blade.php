<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    @fluxAppearance
    <style>
        /* Target semua kemungkinan elemen sidebar yang bisa memiliki scrollbar */
        flux-sidebar,
        [data-flux-sidebar],
        .flux-sidebar,
        .sidebar,
        [role="navigation"]:has(flux-sidebar),
        .overflow-y-auto,
        .overflow-auto {
            overflow-y: auto !important;
            scrollbar-width: none !important; /* Firefox */
            -ms-overflow-style: none !important; /* IE/Edge */
        }
        
        /* Chrome, Safari, Opera */
        flux-sidebar::-webkit-scrollbar,
        [data-flux-sidebar]::-webkit-scrollbar,
        .flux-sidebar::-webkit-scrollbar,
        .sidebar::-webkit-scrollbar,
        [role="navigation"]:has(flux-sidebar)::-webkit-scrollbar,
        .overflow-y-auto::-webkit-scrollbar,
        .overflow-auto::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
            background: transparent !important;
        }
        
        /* Target semua anak elemen yang mungkin memiliki scroll */
        flux-sidebar *,
        [data-flux-sidebar] *,
        .flux-sidebar *,
        .sidebar * {
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }
        
        flux-sidebar *::-webkit-scrollbar,
        [data-flux-sidebar] *::-webkit-scrollbar,
        .flux-sidebar *::-webkit-scrollbar,
        .sidebar *::-webkit-scrollbar {
            display: none !important;
        }
        
        /* Target khusus untuk sidebar container */
        .min-h-screen > flux-sidebar,
        body > flux-sidebar {
            overflow-y: auto !important;
            scrollbar-width: none !important;
        }
        
        /* Jika ada class yang ditambahkan oleh Flux */
        [class*="sidebar"] {
            scrollbar-width: none !important;
        }
        
        [class*="sidebar"]::-webkit-scrollbar {
            display: none !important;
        }
        
        /* Smooth scrolling untuk pengalaman yang lebih baik */
        flux-sidebar,
        [data-flux-sidebar],
        .flux-sidebar {
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }
    </style>
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

    <flux:sidebar 
        sticky 
        collapsible 
        class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-300 dark:border-zinc-600 lg:shadow-[10px_0_15px_-5px_rgba(0,0,0,0.1)] lg:dark:shadow-[10px_0_15px_-5px_rgba(0,0,0,0.3)]"
        style="overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none;"
    >

            <flux:sidebar.header>
                <flux:sidebar.brand href="/" class="flex justify-center items-center w-full">
                    <x-slot name="logo" class="size-6 rounded-full bg-cyan-500 text-white text-xs font-bold flex items-center justify-center hidden flux-sidebar-collapsed:flex">
                        SP
                    </x-slot>
                    <x-slot name="name" class="w-full flex justify-center">
                        <img src="{{ asset('images/siix-portal.png') }}" alt="SIIX Portal" class="h-12 w-auto object-contain block group-data-collapsed:hidden" />
                    </x-slot>
                </flux:sidebar.brand>
            </flux:sidebar.header>

            <flux:sidebar.nav style="overflow-y: visible;">

                <!-- GROUP: MAIN (EXPANDABLE) - SEMUA USER BISA LIHAT DASHBOARD -->
                <flux:sidebar.group icon="bars-arrow-down" icon-variant="solid" expandable heading="Home" class="grid">
                    <flux:sidebar.item 
                        icon="home"
                        icon-variant="solid"
                        href="{{ route('dashboard') }}" 
                        wire:navigate
                        :current="request()->routeIs('dashboard')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Main Dashboard
                    </flux:sidebar.item>
                    @can('view dcc-dashboard')
                    <flux:sidebar.item 
                        icon="chart-bar"
                        icon-variant="solid"
                        href="{{ route('dcc-dashboard') }}" 
                        wire:navigate
                        :current="request()->routeIs('dcc-dashboard')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        DCC Dashboard
                    </flux:sidebar.item>
                    @endcan
                    @can('view hr-dashboard')
                    <flux:sidebar.item 
                        icon="chart-bar"
                        icon-variant="solid"
                        href="{{ route('hr-dashboard') }}" 
                        wire:navigate
                        :current="request()->routeIs('hr-dashboard')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        HR Dashboard
                    </flux:sidebar.item>
                    @endcan
                    @can('view inbox')
                    <flux:sidebar.item 
                        icon="inbox"
                        icon-variant="solid"
                        href="{{ route('inbox') }}" 
                        wire:navigate
                        :current="request()->routeIs('inbox')"
                        :badge="App\Helpers\InboxHelper::getTotalInboxCount() > 0 ? App\Helpers\InboxHelper::getTotalInboxCount() : null"
                        badge-color="blue"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Inbox
                    </flux:sidebar.item>
                    @endcan
                </flux:sidebar.group>

                <flux:sidebar.group icon="phone-arrow-down-left" icon-variant="solid" expandable heading="Ticketing Support" class="grid">
                    
                    <flux:sidebar.item 
                        icon="tag" 
                        icon-variant="solid"
                        href="{{ route('ticket.categories') }}" 
                        wire:navigate
                        :current="request()->routeIs('ticket.categories')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Category
                    </flux:sidebar.item>

                    <flux:sidebar.item 
                        icon="ticket" 
                        icon-variant="solid"
                        href="{{ route('ticket.list') }}" 
                        wire:navigate
                        :current="request()->routeIs('ticket.list')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Ticket
                    </flux:sidebar.item>

                </flux:sidebar.group>

                <!-- GROUP: DCC (EXPANDABLE) -->
                @canany(['view departments', 'view submissions'])
                <flux:sidebar.group icon="folder" icon-variant="solid" expandable heading="DCC" class="grid">
                    
                    @can('view departments')
                    <flux:sidebar.item 
                        icon="building-office" 
                        icon-variant="solid"
                        href="{{ route('dcc.departments') }}"
                        wire:navigate
                        :current="request()->routeIs('dcc.departments')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Departments
                    </flux:sidebar.item>
                    @endcan

                    @can('view submissions')
                    <flux:sidebar.item 
                        icon="document-text" 
                        icon-variant="solid"
                        href="{{ route('dcc.submissions') }}"
                        wire:navigate
                        :current="request()->routeIs('dcc.submissions')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Submissions
                    </flux:sidebar.item>
                    @endcan

                </flux:sidebar.group>
                @endcanany

                @canany(['view employee', 'view comelate employee', 'view violation employee', 'view employee call'])
                <!-- GROUP: HR (EXPANDABLE) -->
                <flux:sidebar.group icon="user-group" icon-variant="solid" expandable heading="HR" class="grid">

                    @can('view employee')
                    <flux:sidebar.item 
                        icon="users" 
                        icon-variant="solid"
                        href="{{ route('hr.employee') }}" 
                        wire:navigate
                        :current="request()->routeIs('hr.employee')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Master Employee
                    </flux:sidebar.item>
                    @endcan

                    @can('view comelate employee')
                    <flux:sidebar.item 
                        icon="arrow-left-end-on-rectangle" 
                        icon-variant="solid"
                        href="{{ route('hr.comelate.index') }}" 
                        wire:navigate
                        :current="request()->routeIs('hr.comelate.index')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Comelate Employee
                    </flux:sidebar.item>
                    @endcan

                    @can('view violation employee')
                    <flux:sidebar.item 
                        icon="exclamation-triangle" 
                        icon-variant="solid"
                        href="{{ route('hr.violation.index') }}" 
                        wire:navigate
                        :current="request()->routeIs('hr.violation.index')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Violation Employee
                    </flux:sidebar.item>
                    @endcan

                    @can('view employee call')
                    <flux:sidebar.item 
                        icon="phone-arrow-up-right" 
                        icon-variant="solid"
                        href="{{ route('hr.employee-call.index') }}" 
                        wire:navigate
                        :current="request()->routeIs('hr.employee-call.index')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Employee Call
                    </flux:sidebar.item>
                    @endcan

                    <flux:sidebar.group icon="printer" icon-variant="solid" expandable heading="Reporting" class="grid">

                        @can('view comelate employee')
                        <flux:sidebar.item 
                            icon="arrow-turn-down-right" 
                            icon-variant="solid"
                            href="{{ route('hr.comelate.report') }}"
                            wire:navigate
                            :current="request()->routeIs('hr.comelate.report')"
                            class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                        >
                            Comelate Report
                        </flux:sidebar.item>
                        @endcan

                        @can('view violation employee')
                        <flux:sidebar.item 
                            icon="arrow-turn-down-right" 
                            icon-variant="solid"
                            href="{{ route('hr.violation.report') }}"
                            wire:navigate
                            :current="request()->routeIs('hr.violation.report')"
                            class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                        >
                            Violation Report
                        </flux:sidebar.item>
                        @endcan

                    </flux:sidebar.group>

                </flux:sidebar.group>
                @endcanany

                @canany(['view users', 'view roles', 'view permissions'])
                <flux:sidebar.group icon="cog-8-tooth" icon-variant="solid" expandable heading="Settings" class="grid">

                    {{-- Users --}}
                    @can('view users')
                    <flux:sidebar.item 
                        icon="users" 
                        icon-variant="solid"
                        href="{{ route('users') }}"
                        wire:navigate
                        :current="request()->routeIs('users')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Users
                    </flux:sidebar.item>
                    @endcan

                    @can('view notification')
                    <flux:sidebar.item 
                        icon="bell-alert" 
                        icon-variant="solid"
                        href="{{ route('notifications.manager') }}"
                        wire:navigate
                        :current="request()->routeIs('notifications.manager')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Notification
                    </flux:sidebar.item>
                    @endcan


                    {{-- Authorization --}}
                    @canany(['view roles', 'view permissions'])
                    <flux:sidebar.group icon="shield-check" icon-variant="solid" expandable heading="Authorization" class="grid">

                        @can('view roles')
                        <flux:sidebar.item 
                            icon="arrow-turn-down-right" 
                            icon-variant="solid"
                            href="{{ route('role.management') }}"
                            wire:navigate
                            :current="request()->routeIs('role.management')"
                            class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                        >
                            Roles
                        </flux:sidebar.item>
                        @endcan

                        @can('view permissions')
                        <flux:sidebar.item 
                            icon="arrow-turn-down-right" 
                            icon-variant="solid"
                            href="{{ route('permission.management') }}"
                            wire:navigate
                            :current="request()->routeIs('permission.management')"
                            class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                        >
                            Permissions
                        </flux:sidebar.item>
                        @endcan

                    </flux:sidebar.group>
                    @endcanany

                </flux:sidebar.group>
                @endcanany

            </flux:sidebar.nav>

            <flux:sidebar.spacer />

    </flux:sidebar>

    <flux:header class="sticky top-0 z-10 block! bg-white lg:bg-zinc-100 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-600 p-0! m-0! w-full shadow-sm">
        <flux:navbar class="flex items-center justify-between px-4 lg:px-6 mx-0!">
            <div class="flex items-center gap-3">
                <!-- Sidebar Toggle - Left Side -->
                <flux:sidebar.toggle icon="bars-3" inset="left" />
                
                <!-- Livewire Header Badge Component -->
                <livewire:header-badge />
            </div>
            
            <div class="flex items-center gap-1 sm:gap-2">
                <!-- User Button - Direct to profile -->
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
                    :aria-label="$flux.dark ? 'Switch to light mode' : 'Switch to dark mode'"
                >
                    <svg 
                        x-show="!$flux.dark" 
                        class="w-5 h-5"
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    
                    <svg 
                        x-show="$flux.dark" 
                        class="w-5 h-5"
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>
                
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <flux:button 
                        type="submit" 
                        variant="danger" 
                        icon="arrow-right"
                        size="sm"
                    >
                        <span class="hidden lg:inline">{{ __('Logout') }}</span>
                    </flux:button>
                </form>
            </div>
        </flux:navbar>
    </flux:header>

    {{ $slot }}

    @fluxScripts

    <script>
        // JavaScript fallback untuk memastikan scrollbar benar-benar tersembunyi
        document.addEventListener('DOMContentLoaded', function() {
            const sidebars = document.querySelectorAll('flux-sidebar, [data-flux-sidebar], .flux-sidebar');
            sidebars.forEach(sidebar => {
                if (sidebar) {
                    sidebar.style.overflowY = 'auto';
                    sidebar.style.scrollbarWidth = 'none';
                    sidebar.style.msOverflowStyle = 'none';
                }
            });
        });
    </script>

</body>
</html>