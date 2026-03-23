<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/siix-portal.png') }}">
</head>

<body class="min-h-screen bg-neutral-100 antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
    <div class="bg-muted flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
        
        <div class="flex w-full max-w-md flex-col gap-6">

            <div class="flex flex-col gap-6">
                <div class="rounded-2xl border bg-white dark:bg-stone-950 dark:border-stone-800 text-stone-800 shadow-[0_20px_50px_rgba(0,0,0,0.2)] hover:shadow-[0_25px_60px_rgba(0,0,0,0.25)] transition-shadow duration-300">
                    <div class="px-10 py-8">
                        <!-- Logo inside card -->
                        <div class="flex justify-center mb-8">
                            <a href="{{ route('home') }}" class="flex flex-col items-center gap-3 font-medium transition-transform hover:scale-105 duration-200" wire:navigate>
                                <img 
                                    src="{{ asset('images/siix-portal.png') }}" 
                                    alt="SIIX Portal"
                                    class="h-20 w-auto"
                                >
                            </a>
                        </div>
                        
                        {{ $slot }}
                    </div>
                </div>
            </div>

        </div>

    </div>

    @fluxScripts
</body>
</html>