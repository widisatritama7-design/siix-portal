<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PCB Scanning System - @yield('title', 'Dashboard')</title>
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
        
        /* Pulse animation untuk warning */
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
                        <a href="{{ route('pcb-scan.dashboard') }}" class="hover:opacity-90">
                            <span class="bg-white text-blue-600 px-2 py-1 rounded-lg">PCB</span> Scanner
                        </a>
                    </h1>
                    
                    <!-- Navigation Links -->
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('pcb-scan.dashboard') }}" 
                           class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition duration-150
                                  {{ request()->routeIs('pcb-scan.dashboard') ? 'bg-blue-700' : '' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('pcb-scan.fct') }}" 
                           class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition duration-150
                                  {{ request()->routeIs('pcb-scan.fct') ? 'bg-blue-700' : '' }}">
                            FCT
                        </a>
                        <a href="{{ route('pcb-scan.led-test') }}" 
                           class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition duration-150
                                  {{ request()->routeIs('pcb-scan.led-test') ? 'bg-blue-700' : '' }}">
                            LED Test
                        </a>
                        <a href="{{ route('pcb-scan.visual-inspection') }}" 
                           class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition duration-150
                                  {{ request()->routeIs('pcb-scan.visual-inspection') ? 'bg-blue-700' : '' }}">
                            Visual
                        </a>
                        <a href="{{ route('pcb-scan.leader.index') }}" 
                           class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition duration-150
                                  {{ request()->routeIs('pcb-scan.leader.*') ? 'bg-blue-700' : '' }}">
                            Leader Panel
                        </a>
                    </div>
                </div>

                <!-- Status Indicator -->
                <div class="flex items-center space-x-4">
                    @php
                        $hasLockedBox = \App\Models\PROD\FCT\NGBox::where('is_locked', true)->exists();
                    @endphp
                    
                    @if($hasLockedBox)
                        <div class="flex items-center bg-red-500 px-3 py-1 rounded-full animate-pulse">
                            <span class="w-2 h-2 bg-white rounded-full mr-2"></span>
                            <span class="text-sm font-semibold">SYSTEM LOCKED</span>
                        </div>
                    @else
                        <div class="flex items-center bg-green-500 px-3 py-1 rounded-full">
                            <span class="w-2 h-2 bg-white rounded-full mr-2"></span>
                            <span class="text-sm font-semibold">SYSTEM ONLINE</span>
                        </div>
                    @endif
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

        <!-- Warning Message for Locked System -->
        @php
            $lockedBoxes = \App\Models\PROD\FCT\NGBox::with('pcb')->where('is_locked', true)->get();
        @endphp

        <!-- Page Content -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="container mx-auto px-4 py-4 text-center text-gray-500 text-sm">
        <p>PCB Scanning System v1.0 &copy; {{ date('Y') }}</p>
    </footer>

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
    </script>

    @yield('scripts')
</body>
</html>