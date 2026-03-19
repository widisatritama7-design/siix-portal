<x-layouts::app :title="__('Dashboard')">
    
    <div class="flex h-full w-full flex-1 flex-col gap-4 sm:gap-6 rounded-xl p-4 sm:p-6">

        <!-- Heading, Welcome Back, dan Jam Realtime -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-2">
            <div class="w-full lg:w-auto">
                <h1 class="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white">Dashboard</h1>
                <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-400 mt-1">
                    Welcome back, <span class="font-semibold text-blue-600 dark:text-blue-400 break-all sm:break-normal">{{ auth()->user()->name }}</span>!
                </p>
            </div>
            
            <!-- Jam dan Tanggal Realtime - Responsive -->
            <div x-data="{ 
                datetime: new Date(),
                init() {
                    setInterval(() => {
                        this.datetime = new Date();
                    }, 1000);
                }
            }" class="w-full lg:w-auto flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 px-3 sm:px-4 py-2 sm:py-2 bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm">
                
                <!-- Waktu -->
                <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 w-full sm:w-auto justify-between sm:justify-start">
                    <div class="flex items-center gap-2">
                        <flux:icon name="clock" class="w-4 h-4 sm:w-5 sm:h-5" />
                        <span x-text="datetime.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true })" class="font-mono font-medium text-sm sm:text-base"></span>
                    </div>
                    <!-- Separator untuk mobile -->
                    <span class="text-xs text-zinc-400 sm:hidden">|</span>
                </div>
                
                <!-- Separator untuk desktop -->
                <div class="hidden sm:block w-px h-5 bg-zinc-200 dark:bg-zinc-700"></div>
                
                <!-- Tanggal -->
                <div class="flex items-center gap-2 text-zinc-600 dark:text-zinc-400 w-full sm:w-auto">
                    <div class="flex items-center gap-2">
                        <flux:icon name="calendar" class="w-4 h-4 sm:w-5 sm:h-5" />
                        <span x-text="datetime.toLocaleDateString('en-US', { 
                            weekday: window.innerWidth < 640 ? 'short' : 'long', 
                            month: 'short', 
                            day: 'numeric', 
                            year: window.innerWidth < 640 ? '2-digit' : 'numeric' 
                        })" class="text-xs sm:text-sm"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan CSS untuk touch devices -->
    <style>
        @media (hover: none) and (pointer: coarse) {
            .hover\:scale-\[1\.02\]:hover {
                transform: none;
            }
        }
    </style>
</x-layouts::app>