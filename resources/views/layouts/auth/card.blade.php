<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/siix-portal.png') }}">
</head>

<body class="min-h-screen bg-neutral-100 antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
    <div class="flex min-h-svh bg-white dark:bg-stone-950">
        
        <!-- Left side - 60% with image and top left logo -->
        <div class="hidden lg:block w-full lg:w-[60%] relative overflow-hidden bg-white dark:bg-stone-950">
            <!-- Logo at top left -->
            <div class="absolute top-7 left-7 z-10">
                <a href="{{ route('home') }}" class="block transition-transform hover:scale-105 duration-200" wire:navigate>
                    <img 
                        src="{{ asset('images/siix-portal.png') }}" 
                        alt="SIIX Portal"
                        class="h-18 w-auto"
                    >
                </a>
            </div>
            
            <!-- Centered image -->
            <div class="flex items-center justify-center h-full">
                <img 
                    src="{{ asset('images/login-left.png') }}" 
                    alt="Login illustration"
                    class="w-full h-full object-contain scale-80"
                    style="transform: scale(0.9);"
                >
            </div>
        </div>

        <!-- Right side - 40% with card and form -->
        <div class="w-full lg:w-[40%] flex items-center justify-center p-6 md:p-10 bg-white dark:bg-stone-950">
            <div class="w-full max-w-sm">
                <!-- Card with form content -->
                <div class="rounded-2xl border bg-white dark:bg-stone-800 dark:border-stone-700 text-stone-800 dark:text-stone-200 shadow-[0_20px_50px_rgba(0,0,0,0.2)] hover:shadow-[0_25px_60px_rgba(0,0,0,0.25)] transition-shadow duration-300">
                    <div class="px-6 py-6">
                        <!-- Login Icon -->
                        <div class="flex justify-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 rounded-xl flex items-center justify-center shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Form content from slot -->
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    @fluxScripts
</body>
</html>