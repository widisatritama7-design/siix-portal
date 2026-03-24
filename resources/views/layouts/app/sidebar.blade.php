<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    @fluxAppearance
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

    <flux:sidebar 
        sticky 
        collapsible 
        class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-300 dark:border-zinc-600 lg:shadow-[10px_0_15px_-5px_rgba(0,0,0,0.1)] lg:dark:shadow-[10px_0_15px_-5px_rgba(0,0,0,0.3)]"
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

            <flux:sidebar.nav>

                <!-- GROUP: MAIN (EXPANDABLE) - SEMUA USER BISA LIHAT DASHBOARD -->
                <flux:sidebar.group icon="bars-arrow-down" expandable heading="Home" class="grid">
                    <flux:sidebar.item 
                        icon="home"
                        href="{{ route('dashboard') }}" 
                        wire:navigate
                        :current="request()->routeIs('dashboard')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Main Dashboard
                    </flux:sidebar.item>
                    @can('view dcc-dashboard')
                    <flux:sidebar.item 
                        icon="home"
                        href="{{ route('dcc-dashboard') }}" 
                        wire:navigate
                        :current="request()->routeIs('dcc-dashboard')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        DCC Dashboard
                    </flux:sidebar.item>
                    @endcan
                    @can('view inbox')
                    <flux:sidebar.item 
                        icon="inbox"
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

                <!-- GROUP: DCC (EXPANDABLE) -->
                @canany(['view departments', 'view submissions'])
                <flux:sidebar.group icon="folder" expandable heading="DCC" class="grid">
                    
                    @can('view departments')
                    <flux:sidebar.item 
                        icon="building-office" 
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
                <flux:sidebar.group icon="user-group" expandable heading="HR" class="grid">

                    @can('view employee')
                    <flux:sidebar.item 
                        icon="users" 
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
                        href="{{ route('hr.employee-call.index') }}" 
                        wire:navigate
                        :current="request()->routeIs('hr.employee-call.index')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Employee Call
                    </flux:sidebar.item>
                    @endcan

                </flux:sidebar.group>
                @endcanany

                @canany(['view users', 'view roles', 'view permissions'])
                <flux:sidebar.group icon="cog-6-tooth" expandable heading="Settings" class="grid">

                    {{-- Users --}}
                    @can('view users')
                    <flux:sidebar.item 
                        icon="users" 
                        href="{{ route('users') }}"
                        wire:navigate
                        :current="request()->routeIs('users')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Users
                    </flux:sidebar.item>
                    @endcan


                    {{-- Authorization --}}
                    @canany(['view roles', 'view permissions'])
                    <flux:sidebar.group icon="shield-check" expandable heading="Authorization" class="grid">

                        @can('view roles')
                        <flux:sidebar.item 
                            icon="shield-check" 
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
                            icon="key" 
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
            <div class="flex items-center gap-2">
                <!-- Sidebar Toggle - Left Side -->
                <flux:sidebar.toggle icon="bars-3" inset="left" />
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
                
                <!-- Logout Button - Icon with text on desktop -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                        class="inline-flex items-center gap-2 rounded-lg px-2 py-1.5 lg:px-3 lg:py-2
                            text-white 
                            dark:text-white 
                            transition-all duration-200
                            bg-red-400 hover:bg-red-700 
                            dark:bg-red-600 dark:hover:bg-red-700
                            focus:bg-red-700 dark:focus:bg-red-700
                            focus:outline-none focus:ring-2 focus:ring-red-400/30">
                        <flux:icon.arrow-right class="w-5 h-5" />
                        <span class="hidden lg:inline text-sm font-medium">{{ __('Logout') }}</span>
                    </button>
                </form>
            </div>
        </flux:navbar>
    </flux:header>

    {{ $slot }}

    @fluxScripts

</body>
</html>
