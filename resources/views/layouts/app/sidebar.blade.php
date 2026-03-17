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
        class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-300 dark:border-zinc-600 shadow-[10px_0_15px_-5px_rgba(0,0,0,0.1)] dark:shadow-[10px_0_15px_-5px_rgba(0,0,0,0.3)]"
    >

        <flux:sidebar.header>
            <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />

            <!-- tombol collapse mobile -->
            <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.item 
                icon="home" 
                href="{{ route('dashboard') }}" 
                wire:navigate
                :current="request()->routeIs('dashboard')"
                class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-zinc-400"
            >
                Dashboard
            </flux:sidebar.item>

            <flux:sidebar.item 
                icon="users" 
                href="{{ route('users') }}"
                wire:navigate
                :current="request()->routeIs('users')"
                class="data-[current]:bg-zinc-200 data-[current]:text-zinc-700 dark:data-[current]:bg-zinc-700 dark:data-[current]:text-zinc-200 data-[current]:border-r-2 data-[current]:border-zinc-400"
            >
                Users
            </flux:sidebar.item>
            
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