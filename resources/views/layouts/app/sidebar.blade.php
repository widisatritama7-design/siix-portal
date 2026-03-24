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

    <flux:sidebar.header class="relative flex justify-center items-center py-0">
        <img src="{{ asset('images/siix-portal.png') }}" alt="SIIX Portal" class="h-12 w-auto object-contain" />
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
                    <flux:sidebar.item 
                        icon="inbox"
                        href="{{ route('inbox') }}" 
                        wire:navigate
                        :current="request()->routeIs('inbox')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Inbox
                    </flux:sidebar.item>
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

                <!-- GROUP: HR (EXPANDABLE) -->
                <flux:sidebar.group icon="user-group" expandable heading="Human Resource" class="grid">
                    
                    <flux:sidebar.item 
                        icon="users" 
                        href="{{ route('hr.employee') }}" 
                        wire:navigate
                        :current="request()->routeIs('hr.employee')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Master Employee
                    </flux:sidebar.item>

                    <flux:sidebar.item 
                        icon="arrow-left-end-on-rectangle" 
                        href="{{ route('hr.comelate.index') }}" 
                        wire:navigate
                        :current="request()->routeIs('hr.comelate.index')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Comelate Employee
                    </flux:sidebar.item>

                    <flux:sidebar.item 
                        icon="exclamation-triangle" 
                        href="{{ route('hr.violation.index') }}" 
                        wire:navigate
                        :current="request()->routeIs('hr.violation.index')"
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Violation Employee
                    </flux:sidebar.item>

                    <flux:sidebar.item 
                        icon="phone-arrow-up-right" 
                        href="#"
                        wire:navigate
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-black dark:data-[current]:border-white"
                    >
                        Employee Call
                    </flux:sidebar.item>

                </flux:sidebar.group>

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
                
                <!-- Appearance Dropdown - Icon only (no text) -->
                <flux:dropdown x-data>
                    <flux:button variant="ghost" 
                        class="cursor-pointer !p-2 lg:!p-2.5 rounded-lg 
                            hover:bg-zinc-200 dark:hover:bg-zinc-700 
                            focus:bg-zinc-200 dark:focus:bg-zinc-700
                            transition-all duration-200">
                        <div class="flex items-center">
                            <!-- Dynamic icon based on current theme -->
                            <template x-if="$flux.appearance === 'light'">
                                <flux:icon.sun class="w-5 h-5 text-zinc-700 dark:text-zinc-200" />
                            </template>
                            <template x-if="$flux.appearance === 'dark'">
                                <flux:icon.moon class="w-5 h-5 text-zinc-700 dark:text-zinc-200" />
                            </template>
                            <template x-if="$flux.appearance === 'system'">
                                <flux:icon.computer-desktop class="w-5 h-5 text-zinc-700 dark:text-zinc-200" />
                            </template>
                        </div>
                    </flux:button>
                    
                    <flux:menu>
                        <flux:menu.item x-on:click="$flux.appearance = 'light'" icon="sun">
                            {{ __('Light') }}
                        </flux:menu.item>
                        <flux:menu.item x-on:click="$flux.appearance = 'dark'" icon="moon">
                            {{ __('Dark') }}
                        </flux:menu.item>
                        <flux:menu.item x-on:click="$flux.appearance = 'system'" icon="computer-desktop">
                            {{ __('System') }}
                        </flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
                
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
