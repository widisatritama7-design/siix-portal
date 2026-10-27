<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/siix-portal.png') }}">
</head>

<body class="h-screen overflow-hidden bg-neutral-100 antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
    <div class="relative flex h-full bg-white dark:bg-stone-950">

        <!-- Background image - full area, di belakang card, center -->
        <div class="absolute inset-0 flex items-center justify-center overflow-hidden pointer-events-none">
            <img
                src="{{ asset('images/bg.png') }}"
                alt="Login illustration"
                class="w-full h-full object-contain"
                style="transform: scale(1.1);"
            >
        </div>

        <!-- Card di tengah (di atas gambar background) -->
        <div class="relative z-10 w-full flex items-center justify-center p-4 md:p-6">
            <div class="w-full max-w-sm flex flex-col items-center justify-center">
                <!-- Logo SIIX di luar card (di atas card) -->
                <div class="flex justify-center mb-6">
                    <a href="{{ route('home') }}" class="block transition-transform hover:scale-105 duration-200" wire:navigate>
                        <img
                            src="{{ asset('images/logo-siix.png') }}"
                            alt="SIIX Portal"
                            class="h-16 w-auto"
                        >
                    </a>
                </div>

                <!-- Card with form content -->
                <div class="w-full rounded-2xl border bg-white dark:bg-stone-800 dark:border-stone-700 text-stone-800 dark:text-stone-200 shadow-[0_20px_50px_rgba(0,0,0,0.2)] hover:shadow-[0_25px_60px_rgba(0,0,0,0.25)] transition-shadow duration-300">
                    <div class="px-6 py-6">
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