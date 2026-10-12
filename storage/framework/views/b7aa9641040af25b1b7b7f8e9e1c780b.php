<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'ESD Locker System'); ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>
    
    <style>
        /* Custom Styles */
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
            transition: all 0.15s ease;
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

        @media (max-width: 640px) {
            .numpad-btn {
                font-size: 11px;
                min-height: 34px;
                padding: 4px 2px;
            }
        }

        .locker-grid::-webkit-scrollbar {
            width: 6px;
        }
        .locker-grid::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .locker-grid::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        .dark .locker-grid::-webkit-scrollbar-track {
            background: #2a2a4a;
        }
        .dark .locker-grid::-webkit-scrollbar-thumb {
            background: #555;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .modal-animate {
            animation: fadeIn 0.2s ease-out;
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50 dark:bg-zinc-950 text-gray-900 dark:text-gray-100">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-zinc-900 border-b border-gray-200 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-locker text-blue-600 dark:text-blue-400 text-2xl mr-2"></i>
                        <span class="text-xl font-bold text-gray-800 dark:text-white">ESD System</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-zinc-800 transition">
                        <i id="theme-icon" class="fas fa-moon text-gray-600 dark:text-gray-300 text-lg"></i>
                    </button>
                    
                    <!-- User Menu -->
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo e(Auth::user()->name ?? 'Guest'); ?></span>
                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                            <?php echo e(substr(Auth::user()->name ?? 'G', 0, 1)); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <script>
        // Dark Mode Toggle
        function toggleDarkMode() {
            const html = document.documentElement;
            const icon = document.getElementById('theme-icon');
            
            html.classList.toggle('dark');
            
            if (html.classList.contains('dark')) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
                localStorage.setItem('theme', 'dark');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
                localStorage.setItem('theme', 'light');
            }
        }

        // Load saved theme
        document.addEventListener('DOMContentLoaded', function() {
            const theme = localStorage.getItem('theme');
            const icon = document.getElementById('theme-icon');
            
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }
        });

        // Toast notification helper
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            const toastIcon = document.getElementById('toast-icon');
            
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500',
                info: 'bg-blue-500'
            };
            
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };
            
            toast.className = 'fixed bottom-4 right-4 z-50 ' + colors[type] + ' text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 transition-all duration-300 transform translate-y-0 opacity-100';
            toastMessage.textContent = message;
            toastIcon.className = 'fas ' + icons[type] + ' text-xl';
            toast.classList.remove('hidden');
            
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => {
                    toast.classList.add('hidden');
                    toast.classList.remove('opacity-0', 'translate-y-4');
                }, 300);
            }, 3000);
        }
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/resources/views/layouts/esd.blade.php ENDPATH**/ ?>