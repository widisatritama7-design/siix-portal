<x-layouts::app :title="__('Inbox')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 sm:gap-6 rounded-xl p-4 sm:p-6">

        <!-- Heading, Welcome Back, dan Jam Realtime -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-2">
            <div class="w-full lg:w-auto">
                <h1 class="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white">Inbox</h1>
                <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-400 mt-1">
                    Check And Manage Your Message
                </p>
            </div>
        </div>
    </div>
</x-layouts::app>