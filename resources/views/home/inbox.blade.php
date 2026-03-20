@props(['heading' => 'Inbox', 'subheading' => 'Check and manage your messages', 'waitingReceiveCount' => 0, 'waitingDistributeCount' => 0])

<x-layouts::app :title="__($heading)">
    
    <div class="flex h-full w-full flex-1 flex-col gap-1 sm:gap-2 rounded-xl p-1 sm:p-2">
        
        <!-- Tabs untuk navigasi internal inbox -->
        <div class="border-b border-zinc-200 dark:border-zinc-700">
            <!-- Desktop View (text + icon) -->
            <nav class="flex space-x-6">
                <a 
                    href="{{ route('inbox') }}" 
                    wire:navigate
                    class="hidden sm:flex pb-3 px-1 text-sm font-medium transition-colors duration-200 items-center gap-2 {{ request()->routeIs('inbox') ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-400' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300' }}"
                >
                    <flux:icon name="inbox" class="w-4 h-4" />
                    <span>All Messages</span>
                </a>
                
                <!-- Mobile View (icon only) - tampil di mobile, tersembunyi di desktop -->
                <a 
                    href="{{ route('inbox') }}" 
                    wire:navigate
                    class="sm:hidden pb-3 px-3 text-sm font-medium transition-colors duration-200 relative {{ request()->routeIs('inbox') ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-400' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300' }}"
                    title="All Messages"
                >
                    <flux:icon name="inbox" class="w-5 h-5" />
                </a>

                <a 
                    href="{{ route('inbox.dcc.waiting-receive') }}" 
                    wire:navigate
                    class="hidden sm:flex pb-3 px-1 text-sm font-medium transition-colors duration-200 items-center gap-2 {{ request()->routeIs('inbox.dcc.waiting-receive') ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-400' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300' }}"
                >
                    <flux:icon name="inbox-arrow-down" class="w-4 h-4" />
                    <span>Waiting Receive</span>
                    @if($waitingReceiveCount > 0)
                        <flux:badge size="sm" color="yellow">{{ $waitingReceiveCount }}</flux:badge>
                    @endif
                </a>
                
                <!-- Mobile View (icon only) -->
                <a 
                    href="{{ route('inbox.dcc.waiting-receive') }}" 
                    wire:navigate
                    class="sm:hidden pb-3 px-3 text-sm font-medium transition-colors duration-200 relative {{ request()->routeIs('inbox.dcc.waiting-receive') ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-400' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300' }}"
                    title="Waiting Receive"
                >
                    <flux:icon name="inbox-arrow-down" class="w-5 h-5" />
                    @if($waitingReceiveCount > 0)
                        <flux:badge size="sm" color="yellow" class="absolute -top-1 -right-1">{{ $waitingReceiveCount }}</flux:badge>
                    @endif
                </a>

                <a 
                    href="{{ route('inbox.dcc.waiting-distribute') }}" 
                    wire:navigate
                    class="hidden sm:flex pb-3 px-1 text-sm font-medium transition-colors duration-200 items-center gap-2 {{ request()->routeIs('inbox.dcc.waiting-distribute') ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-400' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300' }}"
                >
                    <flux:icon name="arrow-up-tray" class="w-4 h-4" />
                    <span>Waiting Distribute</span>
                    @if($waitingDistributeCount > 0)
                        <flux:badge size="sm" color="blue">{{ $waitingDistributeCount }}</flux:badge>
                    @endif
                </a>
                
                <!-- Mobile View (icon only) -->
                <a 
                    href="{{ route('inbox.dcc.waiting-distribute') }}" 
                    wire:navigate
                    class="sm:hidden pb-3 px-3 text-sm font-medium transition-colors duration-200 relative {{ request()->routeIs('inbox.dcc.waiting-distribute') ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-400' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300' }}"
                    title="Waiting Distribute"
                >
                    <flux:icon name="arrow-up-tray" class="w-5 h-5" />
                    @if($waitingDistributeCount > 0)
                        <flux:badge size="sm" color="blue" class="absolute -top-1 -right-1">{{ $waitingDistributeCount }}</flux:badge>
                    @endif
                </a>
            </nav>
        </div>

        <!-- Header dengan Heading dan Subheading -->
        <div class="mb-2">
            <flux:heading size="xl" level="1">
                {{ $heading }}
            </flux:heading>

            <flux:subheading class="mt-2">
                {{ $subheading }}
            </flux:subheading>
        </div>

        <!-- Content Area dengan Slot -->
        <div class="w-full">
            {{ $slot }}
        </div>

    </div>

</x-layouts::app>