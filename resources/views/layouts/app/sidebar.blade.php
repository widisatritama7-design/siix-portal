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
            <x-app-logo :sidebar="true" />
            <flux:sidebar.collapse />
        </flux:sidebar.header>

        <flux:sidebar.nav>

            <!-- GROUP: MAIN (EXPANDABLE) - SEMUA USER BISA LIHAT DASHBOARD -->
            <flux:sidebar.group icon="bars-arrow-down" expandable heading="Home" class="grid">
                <flux:sidebar.item 
                    icon="home"
                    href="{{ route('dashboard') }}" 
                    wire:navigate
                    :current="request()->routeIs('dashboard')"
                    class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-zinc-400"
                >
                    Main Dashboard
                </flux:sidebar.item>
                @can('view dcc-dashboard')
                <flux:sidebar.item 
                    icon="home"
                    href="{{ route('dcc-dashboard') }}" 
                    wire:navigate
                    :current="request()->routeIs('dcc-dashboard')"
                    class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-zinc-400"
                >
                    DCC Dashboard
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
                    class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-zinc-400"
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
                    class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-zinc-400"
                >
                    Submissions
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
                    class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-zinc-400"
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
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-zinc-400"
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
                        class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-zinc-400"
                    >
                        Permissions
                    </flux:sidebar.item>
                    @endcan

                </flux:sidebar.group>
                @endcanany

            </flux:sidebar.group>
            @endcanany
            
        </flux:sidebar.nav>

        <flux:spacer />

        <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />

    </flux:sidebar>

    <!-- Mobile Header -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle icon="bars-2" inset="left" />
        <flux:spacer />
    </flux:header>

    {{ $slot }}

    @fluxScripts

</body>
</html>
