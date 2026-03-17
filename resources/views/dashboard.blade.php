<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-6">

        <!-- Heading, Welcome Back, dan Jam Realtime -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-2">
            <div>
                <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">Dashboard</h1>
                <p class="text-zinc-600 dark:text-zinc-400 mt-1">
                    Welcome back, <span class="font-semibold text-blue-600 dark:text-blue-400">{{ auth()->user()->name }}</span>!
                </p>
            </div>
            
            <!-- Jam dan Tanggal Realtime - English -->
            <div x-data="{ 
                datetime: new Date(),
                init() {
                    setInterval(() => {
                        this.datetime = new Date();
                    }, 1000);
                }
            }" class="flex items-center gap-3 px-4 py-2 bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm">
                <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                    <flux:icon name="clock" class="w-5 h-5" />
                    <span x-text="datetime.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true })" class="font-mono font-medium"></span>
                </div>
                <div class="w-px h-5 bg-zinc-200 dark:bg-zinc-700"></div>
                <div class="flex items-center gap-2 text-zinc-600 dark:text-zinc-400">
                    <flux:icon name="calendar" class="w-5 h-5" />
                    <span x-text="datetime.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' })" class="text-sm"></span>
                </div>
            </div>
        </div>

        <!-- Grid Cards -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        
        <!-- Bottom Card -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts::app>