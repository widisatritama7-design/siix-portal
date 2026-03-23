<x-layouts::app :title="__($heading)">
    
    <div class="flex h-full w-full flex-1 flex-col gap-1 sm:gap-2 rounded-xl p-1 sm:p-2">
        
        <div class="w-full lg:w-auto">
            <h1 class="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white">Inbox</h1>
            <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-400 mt-1 mb-4">
                Check and manage your messages
            </p>
        </div>

        <!-- Content Area dengan Slot -->
        <div class="w-full">
            {{ $slot }}
        </div>

    </div>

</x-layouts::app>