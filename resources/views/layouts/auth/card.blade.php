<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/siix-portal.png') }}">
</head>

<body class="h-screen overflow-hidden bg-neutral-100 antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
    <div class="flex h-full bg-white dark:bg-stone-950">
        
        <!-- Left side - 60% with image -->
        <div class="hidden lg:block w-full lg:w-[60%] relative overflow-hidden bg-white dark:bg-stone-950">
            <!-- Centered image shifted slightly to the right -->
            <div class="flex items-center justify-center h-full">
                <img 
                    src="{{ asset('images/logo-left.png') }}" 
                    alt="Login illustration"
                    class="w-full h-full object-contain"
                    style="transform: scale(0.7) translateX(5%);"
                >
            </div>
        </div>

        <!-- Right side - 40% with card -->
        <div class="w-full lg:w-[40%] flex items-center justify-center p-4 md:p-6 bg-white dark:bg-stone-950">
            <div class="w-full max-w-sm">
                <!-- Card with form content -->
                <div class="rounded-2xl border bg-white dark:bg-stone-800 dark:border-stone-700 text-stone-800 dark:text-stone-200 shadow-[0_20px_50px_rgba(0,0,0,0.2)] hover:shadow-[0_25px_60px_rgba(0,0,0,0.25)] transition-shadow duration-300">
                    <div class="px-6 py-6">
                        <!-- Logo SIIX di dalam card, menggantikan icon -->
                        <div class="flex justify-center mb-6">
                            <a href="{{ route('home') }}" class="block transition-transform hover:scale-105 duration-200" wire:navigate>
                                <img 
                                    src="{{ asset('images/logo-siix.png') }}" 
                                    alt="SIIX Portal"
                                    class="h-16 w-auto"
                                >
                            </a>
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