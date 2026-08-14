<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESD Locker System - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Alert animations */
        [role="alert"] {
            animation: slideInDown 0.3s ease-out;
        }
        
        @keyframes slideInDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        /* Pulse animation */
        .animate-pulse-warning {
            animation: pulseWarning 2s infinite;
        }
        
        @keyframes pulseWarning {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .scan-input:focus {
            outline: none;
            ring: 2px solid #3b82f6;
        }

        /* Locker grid hover effect */
        .locker-grid-item {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .locker-grid-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Status badges */
        .status-badge {
            transition: all 0.3s;
        }

        /* Navbar active style */
        .nav-link-active {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 0.375rem;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo/Brand -->
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold tracking-tight">
                        <a href="{{ route('esd.user.store') }}" class="hover:opacity-90">
                            <span class="bg-white text-blue-600 px-2 py-1 rounded-lg">ESD</span> Locker
                        </a>
                    </h1>
                    
                    <!-- Navigation Links untuk User -->
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('esd.user.store') }}" 
                           class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition duration-150
                                  {{ request()->routeIs('esd.user.store') ? 'bg-blue-700' : '' }}">
                            📥 Menyimpan
                        </a>
                        <a href="{{ route('esd.user.take') }}" 
                           class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition duration-150
                                  {{ request()->routeIs('esd.user.take') ? 'bg-blue-700' : '' }}">
                            📤 Mengambil
                        </a>
                        <a href="{{ route('esd.user.status') }}" 
                           class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition duration-150
                                  {{ request()->routeIs('esd.user.status') ? 'bg-blue-700' : '' }}">
                            📊 Status
                        </a>
                    </div>
                </div>

                <!-- Right Menu -->
                <div class="flex items-center space-x-4">
                    <!-- System Status -->
                    <div class="flex items-center bg-blue-700 px-3 py-1 rounded-full">
                        <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                        <span class="text-sm font-semibold">Online</span>
                    </div>

                    <!-- Dropdown Menu -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" 
                                class="flex items-center space-x-2 bg-blue-700 hover:bg-blue-800 px-3 py-2 rounded-md transition">
                            <span class="text-sm font-medium">Menu</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-1">
                                <!-- User Menu -->
                                <a href="{{ route('esd.user.store') }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                    📥 Menyimpan Seragam
                                </a>
                                <a href="{{ route('esd.user.take') }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                    📤 Mengambil Seragam
                                </a>
                                <a href="{{ route('esd.user.status') }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                    📊 Cek Status
                                </a>
                                
                                @auth
                                    @php
                                        $user = auth()->user();
                                    @endphp
                                    
                                    @if($user && method_exists($user, 'hasRole'))
                                        @if($user->hasRole('teknisi') || $user->hasRole('admin'))
                                            <hr class="my-1">
                                        @endif
                                        
                                        @if($user->hasRole('teknisi'))
                                            <a href="{{ route('esd.teknisi.management') }}" 
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                                🔧 Teknisi Management
                                            </a>
                                            <a href="{{ route('esd.teknisi.take') }}" 
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                                🔍 Ambil Seragam
                                            </a>
                                            <a href="{{ route('esd.teknisi.return') }}" 
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                                📥 Kembalikan Seragam
                                            </a>
                                        @endif
                                        
                                        @if($user->hasRole('admin'))
                                            <a href="{{ route('esd.admin.monitoring') }}" 
                                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                                📊 Admin Monitoring
                                            </a>
                                        @endif
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg shadow" role="alert">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-lg shadow" role="alert">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 rounded-lg shadow" role="alert">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('info') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded-lg shadow" role="alert">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('warning') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="container mx-auto px-4 py-4 text-center text-gray-500 text-sm">
        <p>ESD Locker System v1.0 &copy; {{ date('Y') }}</p>
    </footer>

    <!-- Alpine.js untuk Dropdown -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    
    <!-- Global Scripts -->
    <script>
        // Auto-hide flash messages after 5 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $('[role="alert"]').fadeOut('slow');
            }, 5000);
        });

        // Global AJAX setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Livewire event listeners
        window.addEventListener('open-locker', function(event) {
            const lockerCode = event.detail.code;
            console.log('Opening locker:', lockerCode);
            
            // Kirim request ke API untuk buka loker
            $.ajax({
                url: '/api/esd/open-locker',
                method: 'POST',
                data: { locker_code: lockerCode },
                success: function(response) {
                    console.log('Locker opened successfully');
                },
                error: function(xhr) {
                    console.error('Failed to open locker:', xhr.responseText);
                }
            });
        });

        // Auto close after 15 seconds
        window.addEventListener('locker-opened', function(event) {
            const lockerCode = event.detail.code;
            setTimeout(function() {
                $.ajax({
                    url: '/api/esd/close-locker',
                    method: 'POST',
                    data: { locker_code: lockerCode },
                    success: function(response) {
                        console.log('Locker closed automatically');
                    },
                    error: function(xhr) {
                        console.error('Failed to close locker:', xhr.responseText);
                    }
                });
            }, 15000);
        });

        // Refresh status periodically
        setInterval(function() {
            // Optional: Refresh locker status every 30 seconds
        }, 30000);
    </script>

    @yield('scripts')
</body>
</html>