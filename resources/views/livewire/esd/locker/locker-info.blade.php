<div class="p-1 space-y-2">
    @section('title', 'ESD Locker - Information')

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-1 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                ESD Locker System
            </h1>
        </div>
    </div>

    <!-- Main Content: 2 Columns -->
    <div class="flex flex-col lg:flex-row gap-4 mt-4">
        <!-- LEFT COLUMN: 70% - Flow Steps -->
        <div class="w-full lg:w-[70%]">
            
            <!-- CARD STORE -->
            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-4 mb-4 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-sm font-bold text-green-700 dark:text-green-400">STORE</span>
                    <span class="text-xs text-green-600 dark:text-green-500">- Menyimpan Seragam</span>
                </div>
                
                <div class="flex items-center justify-between gap-2 px-1">
                    <!-- Step 1: Pilih Store -->
                    <div class="flex flex-col items-center flex-1 group">
                        <div class="w-14 h-14 rounded-full bg-green-500 text-white flex items-center justify-center shadow-lg shadow-green-500/30 transition-all duration-300 hover:scale-110 hover:shadow-xl animate-pulse-slow">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-green-700 dark:text-green-300 mt-2 text-center leading-tight">Pilih Store</span>
                    </div>

                    <!-- Arrow 1 -->
                    <svg class="w-6 h-6 text-green-300 dark:text-green-700 flex-shrink-0 animate-pulse-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm4.28 10.28a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 1 0-1.06 1.06l1.72 1.72H8.25a.75.75 0 0 0 0 1.5h5.69l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3Z" clip-rule="evenodd" />
                    </svg>

                    <!-- Step 2: Input NIK & WA -->
                    <div class="flex flex-col items-center flex-1 group">
                        <div class="w-14 h-14 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-lg shadow-blue-500/30 transition-all duration-300 hover:scale-110 hover:shadow-xl animate-pulse-slow" style="animation-delay: 0.5s">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-blue-700 dark:text-blue-300 mt-2 text-center leading-tight">Input NIK & WA</span>
                    </div>

                    <!-- Arrow 2 -->
                    <svg class="w-6 h-6 text-blue-300 dark:text-blue-700 flex-shrink-0 animate-pulse-arrow" style="animation-delay: 0.5s" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm4.28 10.28a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 1 0-1.06 1.06l1.72 1.72H8.25a.75.75 0 0 0 0 1.5h5.69l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3Z" clip-rule="evenodd" />
                    </svg>

                    <!-- Step 3: Konfirmasi -->
                    <div class="flex flex-col items-center flex-1 group">
                        <div class="w-14 h-14 rounded-full bg-yellow-500 text-white flex items-center justify-center shadow-lg shadow-yellow-500/30 transition-all duration-300 hover:scale-110 hover:shadow-xl animate-pulse-slow" style="animation-delay: 1s">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M4.5 3.75a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-15Zm4.125 3a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Zm-3.873 8.703a4.126 4.126 0 0 1 7.746 0 .75.75 0 0 1-.351.92 7.47 7.47 0 0 1-3.522.877 7.47 7.47 0 0 1-3.522-.877.75.75 0 0 1-.351-.92ZM15 8.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15ZM14.25 12a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-yellow-700 dark:text-yellow-300 mt-2 text-center leading-tight">Konfirmasi Data</span>
                    </div>

                    <!-- Arrow 3 -->
                    <svg class="w-6 h-6 text-yellow-300 dark:text-yellow-700 flex-shrink-0 animate-pulse-arrow" style="animation-delay: 1s" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm4.28 10.28a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 1 0-1.06 1.06l1.72 1.72H8.25a.75.75 0 0 0 0 1.5h5.69l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3Z" clip-rule="evenodd" />
                    </svg>

                    <!-- Step 4: Loker Dibuka -->
                    <div class="flex flex-col items-center flex-1 group">
                        <div class="w-14 h-14 rounded-full bg-indigo-500 text-white flex items-center justify-center shadow-lg shadow-indigo-500/30 transition-all duration-300 hover:scale-110 hover:shadow-xl animate-pulse-slow" style="animation-delay: 1.5s">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path d="M18 1.5c2.9 0 5.25 2.35 5.25 5.25v3.75a.75.75 0 0 1-1.5 0V6.75a3.75 3.75 0 1 0-7.5 0v3a3 3 0 0 1 3 3v6.75a3 3 0 0 1-3 3H3.75a3 3 0 0 1-3-3v-6.75a3 3 0 0 1 3-3h9v-3c0-2.9 2.35-5.25 5.25-5.25Z" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-indigo-700 dark:text-indigo-300 mt-2 text-center leading-tight">Loker Dibuka</span>
                    </div>

                    <!-- Arrow 4 -->
                    <svg class="w-6 h-6 text-indigo-300 dark:text-indigo-700 flex-shrink-0 animate-pulse-arrow" style="animation-delay: 1.5s" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm4.28 10.28a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 1 0-1.06 1.06l1.72 1.72H8.25a.75.75 0 0 0 0 1.5h5.69l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3Z" clip-rule="evenodd" />
                    </svg>

                    <!-- Step 5: Selesai -->
                    <div class="flex flex-col items-center flex-1 group">
                        <div class="w-14 h-14 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/30 transition-all duration-300 hover:scale-110 hover:shadow-xl animate-pulse-slow" style="animation-delay: 2s">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path d="M12 1.5a.75.75 0 0 1 .75.75V7.5h-1.5V2.25A.75.75 0 0 1 12 1.5ZM11.25 7.5v5.69l-1.72-1.72a.75.75 0 0 0-1.06 1.06l3 3a.75.75 0 0 0 1.06 0l3-3a.75.75 0 1 0-1.06-1.06l-1.72 1.72V7.5h3.75a3 3 0 0 1 3 3v9a3 3 0 0 1-3 3h-9a3 3 0 0 1-3-3v-9a3 3 0 0 1 3-3h3.75Z" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-emerald-700 dark:text-emerald-300 mt-2 text-center leading-tight">Simpan</span>
                    </div>
                </div>
            </div>

            <!-- CARD TAKE -->
            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-4 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-sm font-bold text-purple-700 dark:text-purple-400">TAKE</span>
                    <span class="text-xs text-purple-600 dark:text-purple-500">- Mengambil Seragam</span>
                </div>
                
                <div class="flex items-center justify-between gap-2 px-1">
                    <!-- Step 1: Pilih Take -->
                    <div class="flex flex-col items-center flex-1 group">
                        <div class="w-14 h-14 rounded-full bg-purple-500 text-white flex items-center justify-center shadow-lg shadow-purple-500/30 transition-all duration-300 hover:scale-110 hover:shadow-xl animate-pulse-slow" style="animation-delay: 0.3s">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-purple-700 dark:text-purple-300 mt-2 text-center leading-tight">Pilih Take</span>
                    </div>

                    <!-- Arrow 1 -->
                    <svg class="w-6 h-6 text-purple-300 dark:text-purple-700 flex-shrink-0 animate-pulse-arrow" style="animation-delay: 0.8s" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm4.28 10.28a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 1 0-1.06 1.06l1.72 1.72H8.25a.75.75 0 0 0 0 1.5h5.69l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3Z" clip-rule="evenodd" />
                    </svg>

                    <!-- Step 2: Input Access Code -->
                    <div class="flex flex-col items-center flex-1 group">
                        <div class="w-14 h-14 rounded-full bg-pink-500 text-white flex items-center justify-center shadow-lg shadow-pink-500/30 transition-all duration-300 hover:scale-110 hover:shadow-xl animate-pulse-slow" style="animation-delay: 1s">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M15.75 1.5a6.75 6.75 0 0 0-6.651 7.906c.067.39-.032.717-.221.906l-6.5 6.499a3 3 0 0 0-.878 2.121v2.818c0 .414.336.75.75.75H6a.75.75 0 0 0 .75-.75v-1.5h1.5A.75.75 0 0 0 9 19.5V18h1.5a.75.75 0 0 0 .53-.22l2.658-2.658c.19-.189.517-.288.906-.22A6.75 6.75 0 1 0 15.75 1.5Zm0 3a.75.75 0 0 0 0 1.5A2.25 2.25 0 0 1 18 8.25a.75.75 0 0 0 1.5 0 3.75 3.75 0 0 0-3.75-3.75Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-pink-700 dark:text-pink-300 mt-2 text-center leading-tight">Input Access Code</span>
                    </div>

                    <!-- Arrow 2 -->
                    <svg class="w-6 h-6 text-pink-300 dark:text-pink-700 flex-shrink-0 animate-pulse-arrow" style="animation-delay: 1.3s" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm4.28 10.28a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 1 0-1.06 1.06l1.72 1.72H8.25a.75.75 0 0 0 0 1.5h5.69l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3Z" clip-rule="evenodd" />
                    </svg>

                    <!-- Step 3: Detail Transaksi -->
                    <div class="flex flex-col items-center flex-1 group">
                        <div class="w-14 h-14 rounded-full bg-orange-500 text-white flex items-center justify-center shadow-lg shadow-orange-500/30 transition-all duration-300 hover:scale-110 hover:shadow-xl animate-pulse-slow" style="animation-delay: 1.6s">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M12 5.25c1.213 0 2.415.046 3.605.135a3.256 3.256 0 0 1 3.01 3.01c.044.583.077 1.17.1 1.759L17.03 8.47a.75.75 0 1 0-1.06 1.06l3 3a.75.75 0 0 0 1.06 0l3-3a.75.75 0 0 0-1.06-1.06l-1.752 1.751c-.023-.65-.06-1.296-.108-1.939a4.756 4.756 0 0 0-4.392-4.392 49.422 49.422 0 0 0-7.436 0A4.756 4.756 0 0 0 3.89 8.282c-.017.224-.033.447-.046.672a.75.75 0 1 0 1.497.092c.013-.217.028-.434.044-.651a3.256 3.256 0 0 1 3.01-3.01c1.19-.09 2.392-.135 3.605-.135Zm-6.97 6.22a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.752-1.751c.023.65.06 1.296.108 1.939a4.756 4.756 0 0 0 4.392 4.392 49.413 49.413 0 0 0 7.436 0 4.756 4.756 0 0 0 4.392-4.392c.017-.223.032-.447.046-.672a.75.75 0 0 0-1.497-.092c-.013.217-.028.434-.044.651a3.256 3.256 0 0 1-3.01 3.01 47.953 47.953 0 0 1-7.21 0 3.256 3.256 0 0 1-3.01-3.01 47.759 47.759 0 0 1-.1-1.759L6.97 15.53a.75.75 0 0 0 1.06-1.06l-3-3Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-orange-700 dark:text-orange-300 mt-2 text-center leading-tight">Detail Transaksi</span>
                    </div>

                    <!-- Arrow 3 -->
                    <svg class="w-6 h-6 text-orange-300 dark:text-orange-700 flex-shrink-0 animate-pulse-arrow" style="animation-delay: 1.9s" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm4.28 10.28a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 1 0-1.06 1.06l1.72 1.72H8.25a.75.75 0 0 0 0 1.5h5.69l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3Z" clip-rule="evenodd" />
                    </svg>

                    <!-- Step 4: Buka Loker -->
                    <div class="flex flex-col items-center flex-1 group">
                        <div class="w-14 h-14 rounded-full bg-rose-500 text-white flex items-center justify-center shadow-lg shadow-rose-500/30 transition-all duration-300 hover:scale-110 hover:shadow-xl animate-pulse-slow" style="animation-delay: 2.2s">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path d="M18 1.5c2.9 0 5.25 2.35 5.25 5.25v3.75a.75.75 0 0 1-1.5 0V6.75a3.75 3.75 0 1 0-7.5 0v3a3 3 0 0 1 3 3v6.75a3 3 0 0 1-3 3H3.75a3 3 0 0 1-3-3v-6.75a3 3 0 0 1 3-3h9v-3c0-2.9 2.35-5.25 5.25-5.25Z" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-rose-700 dark:text-rose-300 mt-2 text-center leading-tight">Loker Dibuka</span>
                    </div>

                    <!-- Arrow 4 -->
                    <svg class="w-6 h-6 text-rose-300 dark:text-rose-700 flex-shrink-0 animate-pulse-arrow" style="animation-delay: 2.5s" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm4.28 10.28a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 1 0-1.06 1.06l1.72 1.72H8.25a.75.75 0 0 0 0 1.5h5.69l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3Z" clip-rule="evenodd" />
                    </svg>

                    <!-- Step 5: Ambil -->
                    <div class="flex flex-col items-center flex-1 group">
                        <div class="w-14 h-14 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/30 transition-all duration-300 hover:scale-110 hover:shadow-xl animate-pulse-slow" style="animation-delay: 2.8s">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path d="M11.47 1.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1-1.06 1.06l-1.72-1.72V7.5h-1.5V4.06L9.53 5.78a.75.75 0 0 1-1.06-1.06l3-3ZM11.25 7.5V15a.75.75 0 0 0 1.5 0V7.5h3.75a3 3 0 0 1 3 3v9a3 3 0 0 1-3 3h-9a3 3 0 0 1-3-3v-9a3 3 0 0 1 3-3h3.75Z" />
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-emerald-700 dark:text-emerald-300 mt-2 text-center leading-tight">Ambil</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: 30% - Tombol Store & Take -->
        <div class="w-full lg:w-[30%]">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-800 p-4 sticky top-4">
                

                <!-- Button Store -->
                <button wire:click="openModal('store')" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white rounded-lg p-5 shadow-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-xl flex flex-col items-center justify-center mb-3 group">
                    <svg class="w-10 h-10 mb-1.5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-xl font-bold">Store</span>
                    <span class="text-xs opacity-75">Menyimpan seragam</span>
                </button>

                <!-- Button Take -->
                <button wire:click="openModal('take')" 
                        class="w-full bg-purple-500 hover:bg-purple-600 text-white rounded-lg p-5 shadow-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-xl flex flex-col items-center justify-center group">
                    <svg class="w-10 h-10 mb-1.5 group-hover:translate-y-[-4px] transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                    <span class="text-xl font-bold">Take</span>
                    <span class="text-xs opacity-75">Mengambil seragam</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL STORE -->
    <!-- ============================================================ -->
    <div x-data="{ 
        open: @entangle('modalStore'),
        storeNik: @entangle('store_nik').live || '',
        storePhone: @entangle('store_phone').live || '',
        activeInput: 'nik',
        countdown: 10,
        countdownInterval: null,
        isSuccess: false
    }" 
        x-show="open" 
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        @auto-close-store.window="
            isSuccess = true;
            countdown = 10;
            if (countdownInterval) clearInterval(countdownInterval);
            countdownInterval = setInterval(() => {
                countdown--;
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                    open = false;
                    $wire.resetStore();
                }
            }, 1000);
        ">
        
        <div class="fixed inset-0 bg-black/60" @click="
            if (countdownInterval) clearInterval(countdownInterval);
            open = false; 
            $wire.resetStore()
        "></div>
        
        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[85vh] relative z-10 border border-zinc-200 dark:border-zinc-700 flex flex-col">
            <!-- Header - Fixed -->
            <div class="flex-shrink-0 p-4 pb-3 border-b border-zinc-200 dark:border-zinc-700">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-zinc-800 dark:text-white">Store Uniform</h2>
                    </div>
                    <button @click="
                        if (countdownInterval) clearInterval(countdownInterval);
                        open = false; 
                        $wire.resetStore()
                    " class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content - Scrollable dengan 2 kolom -->
            <div class="flex-1 overflow-y-auto p-4">
                @if($store_step == 1)
                    <div class="flex flex-col lg:flex-row gap-4 h-full">
                        <!-- KIRI: Form -->
                        <div class="flex-1 space-y-3">
                            <div class="text-center">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Enter your NIK and WhatsApp number</p>
                            </div>

                            <!-- NIK -->
                            <div>
                                <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1">NIK</label>
                                <input type="text" 
                                    x-model="storeNik"
                                    @focus="activeInput = 'nik'"
                                    @input="$wire.set('store_nik', storeNik || '')"
                                    class="w-full px-3 py-2 border-2 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-zinc-800 dark:text-white text-center text-xl font-mono tracking-wider transition"
                                    :class="activeInput === 'nik' ? 'border-green-500 ring-2 ring-green-200 dark:ring-green-900' : 'border-zinc-300 dark:border-zinc-700'"
                                    placeholder="Scan Or Enter your NIK">
                                @error('store_nik') 
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- WhatsApp Number -->
                            <div>
                                <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1">WhatsApp Number</label>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-3 rounded-lg border-2 border-zinc-300 dark:border-zinc-700 flex items-center justify-center h-[44px] min-w-[44px]">
                                        +62
                                    </span>
                                    <input type="tel" 
                                        x-model="storePhone"
                                        @focus="activeInput = 'wa'"
                                        @input="
                                            if (storePhone && storePhone.startsWith('0')) {
                                                storePhone = storePhone.replace(/^0+/, '');
                                            }
                                            $wire.set('store_phone', storePhone || '');
                                        "
                                        class="flex-1 px-3 py-2 border-2 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-zinc-800 dark:text-white text-base transition h-[44px]"
                                        :class="activeInput === 'wa' ? 'border-green-500 ring-2 ring-green-200 dark:ring-green-900' : 'border-zinc-300 dark:border-zinc-700'"
                                        placeholder="81234567890">
                                </div>
                                @error('store_phone') 
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                                @enderror
                                <p class="text-[10px] text-zinc-400 dark:text-zinc-500 mt-1">
                                    Masukkan nomor WhatsApp aktif untuk menerima kode akses
                                </p>
                            </div>

                            <!-- Tombol Switch Input -->
                            <div class="flex gap-2 text-xs">
                                <button type="button"
                                        @click="activeInput = 'nik'; document.querySelector('input[placeholder=\'Scan Or Enter your NIK\']').focus()"
                                        class="flex-1 py-1 rounded-lg transition"
                                        :class="activeInput === 'nik' ? 'bg-green-500 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400'">
                                    NIK
                                </button>
                                <button type="button"
                                        @click="activeInput = 'wa'; document.querySelector('input[placeholder=\'81234567890\']').focus()"
                                        class="flex-1 py-1 rounded-lg transition"
                                        :class="activeInput === 'wa' ? 'bg-green-500 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400'">
                                    WhatsApp
                                </button>
                            </div>

                            <!-- Informasi Input Aktif -->
                            <div class="text-center text-[10px] text-zinc-400 dark:text-zinc-500">
                                <span x-show="activeInput === 'nik'">Sedang mengisi <strong class="text-green-600 dark:text-green-400">NIK</strong></span>
                                <span x-show="activeInput === 'wa'">Sedang mengisi <strong class="text-green-600 dark:text-green-400">WhatsApp</strong></span>
                                <span class="mx-1">|</span>
                                <span>Klik field atau tombol di atas untuk switch</span>
                            </div>
                        </div>

                        <!-- KANAN: Numpad + Action -->
                        <div class="flex-1 space-y-3">
                            <!-- Numpad -->
                            <div class="grid grid-cols-3 gap-1.5 w-full">
                                @foreach(['1','2','3','4','5','6','7','8','9','clear','0','backspace'] as $key)
                                    <button type="button"
                                            @click="
                                                if ('{{ $key }}' === 'clear') {
                                                    if (activeInput === 'nik') {
                                                        storeNik = '';
                                                    } else {
                                                        storePhone = '';
                                                    }
                                                } else if ('{{ $key }}' === 'backspace') {
                                                    if (activeInput === 'nik') {
                                                        storeNik = storeNik ? storeNik.slice(0, -1) : '';
                                                    } else {
                                                        storePhone = storePhone ? storePhone.slice(0, -1) : '';
                                                    }
                                                } else {
                                                    if (activeInput === 'nik') {
                                                        storeNik = (storeNik || '') + '{{ $key }}';
                                                    } else {
                                                        let newPhone = (storePhone || '') + '{{ $key }}';
                                                        if (!newPhone.startsWith('0')) {
                                                            storePhone = newPhone;
                                                        }
                                                    }
                                                }
                                                $wire.set('store_nik', storeNik || '');
                                                $wire.set('store_phone', storePhone || '');
                                            "
                                            class="numpad-btn {{ $key === 'clear' ? 'bg-red-500 hover:bg-red-600 text-white' : ($key === 'backspace' ? 'bg-yellow-500 hover:bg-yellow-600 text-white' : 'bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-white') }} py-1.5 rounded-lg font-black text-2xl transition active:scale-95 h-[48px] shadow-sm hover:shadow-md flex items-center justify-center">
                                        @if($key === 'clear')
                                            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        @elseif($key === 'backspace')
                                            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z"></path>
                                            </svg>
                                        @else
                                            {{ $key }}
                                        @endif
                                    </button>
                                @endforeach
                            </div>

                            <!-- Button Check NIK -->
                            <button wire:click="checkStoreNik" 
                                    wire:loading.attr="disabled"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-green-600/20 hover:scale-[1.02] active:scale-95 text-sm">
                                <span wire:loading.remove>Check NIK</span>
                                <span wire:loading>Checking...</span>
                            </button>
                        </div>
                    </div>

                <!-- Step 2: Confirm Employee Data -->
                @elseif($store_step == 2)
                    <div class="flex flex-col lg:flex-row gap-4 h-full">
                        <div class="flex-1 space-y-4">
                            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4 animate-fade-in">
                                <h3 class="font-semibold text-green-800 dark:text-green-300 mb-2 flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Confirm Employee Data
                                </h3>
                                <div class="space-y-1 text-sm text-zinc-700 dark:text-zinc-300">
                                    <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                        <span class="font-medium">NIK</span>
                                        <span>{{ $store_employee->nik }}</span>
                                    </div>
                                    <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                        <span class="font-medium">Name</span>
                                        <span>{{ $store_employee->name }}</span>
                                    </div>
                                    <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                        <span class="font-medium">Department</span>
                                        <span>{{ $store_employee->department }}</span>
                                    </div>
                                    <div class="flex justify-between py-1">
                                        <span class="font-medium">WhatsApp</span>
                                        <span>+{{ $store_phone }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex-1 flex flex-col justify-center gap-3">
                            <button wire:click="storeUniform" 
                                    wire:loading.attr="disabled"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-blue-600/20 hover:scale-[1.02] active:scale-95 text-sm">
                                <span wire:loading.remove>Confirm Store</span>
                                <span wire:loading>Processing...</span>
                            </button>
                            <button wire:click="resetStore" 
                                    class="w-full bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 py-2.5 px-4 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600 transition duration-200 text-sm">
                                Cancel
                            </button>
                        </div>
                    </div>

                <!-- Step 3: Success -->
                @else
                    <div class="flex flex-col items-center justify-center py-2 animate-fade-in">
                        <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg shadow-green-500/20 animate-bounce-slow">
                            <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-xl font-bold text-green-600 dark:text-green-400 mb-1">Locker Opened!</h3>
                        <p class="text-base text-zinc-700 dark:text-zinc-300 mb-3">
                            Locker <span class="font-bold text-blue-600 dark:text-blue-400">{{ $locker_code }}</span> is now open
                        </p>
                        
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-3 mb-3 w-full max-w-md">
                            <div class="flex items-center justify-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">
                                <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Door will close automatically in <strong class="text-red-600 dark:text-red-400">15 seconds</strong></span>
                            </div>
                            <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-1 text-center">Notifikasi telah dikirim ke WhatsApp Anda</p>
                        </div>
                
                        <!-- Informasi Store -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-3 mb-3 border border-blue-200 dark:border-blue-800 w-full max-w-md">
                            <div class="flex items-center justify-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Seragam berhasil disimpan di locker <strong class="text-blue-600 dark:text-blue-400">{{ $locker_code }}</strong></span>
                            </div>
                            <p class="text-[10px] text-zinc-500 dark:text-zinc-400 mt-1 text-center">
                                Anda akan mendapat notifikasi WhatsApp setelah seragam selesai diperiksa
                            </p>
                        </div>

                        <!-- Progress Bar & Countdown -->
                        <div x-show="isSuccess" class="mt-2 w-full max-w-md">
                            <div class="flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400 mb-1">
                                <span>Menutup otomatis...</span>
                                <span x-text="countdown + 's'" class="font-bold text-blue-600 dark:text-blue-400"></span>
                            </div>
                            <div class="w-full h-1.5 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-600 dark:bg-blue-400 rounded-full transition-all duration-1000 ease-linear"
                                    :style="'width: ' + (countdown / 10 * 100) + '%'">
                                </div>
                            </div>
                        </div>
                
                        <button wire:click="resetStore" 
                                @click="if (countdownInterval) clearInterval(countdownInterval)"
                                class="mt-3 inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 font-medium shadow-lg shadow-blue-600/20 hover:scale-[1.05] active:scale-95 text-sm">
                            Close
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL TAKE -->
    <!-- ============================================================ -->
    <div x-data="{ 
        open: @entangle('modalTake'),
        takeCode: @entangle('take_access_code').live || '',
        countdown: 10,
        countdownInterval: null,
        isSuccess: false
    }" 
        x-show="open" 
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        @auto-close-take.window="
            isSuccess = true;
            countdown = 10;
            if (countdownInterval) clearInterval(countdownInterval);
            countdownInterval = setInterval(() => {
                countdown--;
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                    open = false;
                    $wire.resetTake();
                }
            }, 1000);
        ">
        
        <div class="fixed inset-0 bg-black/60" @click="
            if (countdownInterval) clearInterval(countdownInterval);
            open = false; 
            $wire.resetTake()
        "></div>
        
        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto relative z-10 border border-zinc-200 dark:border-zinc-700">
            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">Take Uniform</h2>
                    </div>
                    <button @click="
                        if (countdownInterval) clearInterval(countdownInterval);
                        open = false; 
                        $wire.resetTake()
                    " class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Step 1: Input Access Code -->
                @if($take_step == 1)
                    <div class="space-y-4">
                        <div class="text-center">
                            <p class="text-gray-600 dark:text-gray-400">Enter the access code sent via WhatsApp</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Access Code</label>
                            <input type="text" 
                                x-model="takeCode"
                                @input="$wire.set('take_access_code', takeCode || '')"
                                class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-center text-2xl font-mono uppercase dark:bg-zinc-800 dark:text-white transition"
                                placeholder="e.g. ABCD1234EF">
                            @error('take_access_code') 
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>
                        
                        <!-- Row 1: A-Z -->
                        <div class="grid grid-cols-9 gap-1.5 max-w-full">
                            @foreach(['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'] as $key)
                                <button type="button"
                                        @click="
                                            takeCode = (takeCode || '') + '{{ $key }}';
                                            $wire.set('take_access_code', takeCode || '');
                                        "
                                        class="numpad-btn bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-800 dark:text-white py-2 rounded-lg font-bold text-sm transition active:scale-90">
                                    {{ $key }}
                                </button>
                            @endforeach
                        </div>

                        <!-- Row 2: 0-9 -->
                        <div class="grid grid-cols-10 gap-1.5 max-w-full">
                            @foreach(['0','1','2','3','4','5','6','7','8','9'] as $key)
                                <button type="button"
                                        @click="
                                            takeCode = (takeCode || '') + '{{ $key }}';
                                            $wire.set('take_access_code', takeCode || '');
                                        "
                                        class="numpad-btn bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-white py-2 rounded-lg font-bold text-sm transition active:scale-90">
                                    {{ $key }}
                                </button>
                            @endforeach
                        </div>

                        <!-- Row 3: Clear & Backspace -->
                        <div class="grid grid-cols-2 gap-1.5 max-w-full">
                            <button type="button"
                                    @click="
                                        takeCode = '';
                                        $wire.set('take_access_code', '');
                                    "
                                    class="numpad-btn bg-red-500 hover:bg-red-600 text-white py-2.5 rounded-lg font-bold text-base transition active:scale-90 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Clear
                            </button>
                            <button type="button"
                                    @click="
                                        takeCode = takeCode ? takeCode.slice(0, -1) : '';
                                        $wire.set('take_access_code', takeCode || '');
                                    "
                                    class="numpad-btn bg-yellow-500 hover:bg-yellow-600 text-white py-2.5 rounded-lg font-bold text-base transition active:scale-90 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z"></path>
                                </svg>
                                Backspace
                            </button>
                        </div>

                        <button wire:click="checkTakeCode" 
                                wire:loading.attr="disabled"
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-purple-600/20 hover:scale-[1.02] active:scale-95">
                            <span wire:loading.remove>Check Code</span>
                            <span wire:loading>Checking...</span>
                        </button>
                    </div>

                <!-- Step 2: Transaction Info -->
                @elseif($take_step == 2)
                    <div class="space-y-6">
                        <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-xl p-5 animate-fade-in">
                            <h3 class="font-semibold text-purple-800 dark:text-purple-300 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Transaction Details
                            </h3>
                            <div class="space-y-2 text-zinc-700 dark:text-zinc-300">
                                <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                    <span class="font-medium">NIK</span>
                                    <span>{{ $take_transaction->employee->nik }}</span>
                                </div>
                                <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                    <span class="font-medium">Name</span>
                                    <span>{{ $take_transaction->employee->name }}</span>
                                </div>
                                <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                    <span class="font-medium">Department</span>
                                    <span>{{ $take_transaction->employee->department }}</span>
                                </div>
                                <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                    <span class="font-medium">Locker</span>
                                    <span class="font-mono font-bold text-blue-600 dark:text-blue-400">{{ $take_transaction->locker->code }}</span>
                                </div>
                                <div class="flex justify-between py-1">
                                    <span class="font-medium">Locker Status</span>
                                    @php
                                        $lockerStatusColors = [
                                            'available' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300',
                                            'open' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300',
                                            'in_progress' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300',
                                            'ng' => 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300',
                                            'finished' => 'bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-300'
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $lockerStatusColors[$take_transaction->locker->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst(str_replace('_', ' ', $take_transaction->locker->status)) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button wire:click="openTakeLocker" 
                                    wire:loading.attr="disabled"
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-green-600/20 hover:scale-[1.02] active:scale-95">
                                <span wire:loading.remove>Open Locker</span>
                                <span wire:loading>Processing...</span>
                            </button>
                            <button wire:click="resetTake" 
                                    class="px-6 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 py-3 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600 transition duration-200">
                                Cancel
                            </button>
                        </div>
                    </div>

                <!-- Step 3: Success -->
                @else
                    <div class="text-center py-4 animate-fade-in">
                        <div class="w-24 h-24 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-green-500/20 animate-bounce-slow">
                            <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-green-600 dark:text-green-400 mb-2">Locker Opened!</h3>
                        <p class="text-lg text-zinc-700 dark:text-zinc-300 mb-4">
                            Locker <span class="font-bold text-blue-600 dark:text-blue-400">{{ $take_transaction->locker->code }}</span> is now open
                        </p>
                        
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-6">
                            <div class="flex items-center justify-center gap-3 text-sm text-zinc-600 dark:text-zinc-400">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Door will close automatically in <strong class="text-red-600 dark:text-red-400">15 seconds</strong></span>
                            </div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2 text-center">Please take your uniform</p>
                        </div>

                        <!-- Progress Bar & Countdown -->
                        <div x-show="isSuccess" class="mt-4">
                            <div class="flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400 mb-1">
                                <span>Menutup otomatis...</span>
                                <span x-text="countdown + 's'" class="font-bold text-purple-600 dark:text-purple-400"></span>
                            </div>
                            <div class="w-full h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
                                <div class="h-full bg-purple-600 dark:bg-purple-400 rounded-full transition-all duration-1000 ease-linear"
                                    :style="'width: ' + (countdown / 10 * 100) + '%'">
                                </div>
                            </div>
                        </div>

                        <button wire:click="resetTake" 
                                @click="if (countdownInterval) clearInterval(countdownInterval)"
                                class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg transition duration-200 font-medium shadow-lg shadow-blue-600/20 hover:scale-[1.05] active:scale-95">
                            Close
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    <div x-data="{ show: false, message: '', type: 'success' }" 
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="fixed bottom-4 right-4 z-50"
         :class="{
             'bg-green-500': type === 'success',
             'bg-red-500': type === 'error',
             'bg-yellow-500': type === 'warning'
         }"
         style="display: none;">
        <div class="text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
            <span x-text="message"></span>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        
        .numpad-btn {
            min-height: 40px;
            user-select: none;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
            cursor: pointer;
            border: 1px solid rgba(0,0,0,0.05);
            font-size: 13px;
            font-weight: 600;
        }
        
        .numpad-btn:active {
            transform: scale(0.92);
        }
        
        .numpad-btn svg {
            pointer-events: none;
        }
        
        .dark .numpad-btn {
            border-color: rgba(255,255,255,0.05);
        }

        /* Animations */
        @keyframes pulse-slow {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes pulse-arrow {
            0%, 100% { opacity: 0.5; transform: translateX(0); }
            50% { opacity: 1; transform: translateX(4px); }
        }
        
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-pulse-slow {
            animation: pulse-slow 2.5s ease-in-out infinite;
        }
        
        .animate-pulse-arrow {
            animation: pulse-arrow 1.5s ease-in-out infinite;
        }
        
        .animate-bounce-slow {
            animation: bounce-slow 2s ease-in-out infinite;
        }
        
        .animate-spin-slow {
            animation: spin-slow 4s linear infinite;
        }
        
        .animate-fade-in {
            animation: fade-in 0.4s ease-out;
        }

        @media (max-width: 640px) {
            .numpad-btn {
                font-size: 11px;
                min-height: 34px;
                padding: 4px 2px;
            }
            
            .w-12 {
                width: 2.5rem;
                height: 2.5rem;
            }
        }
    </style>
</div>