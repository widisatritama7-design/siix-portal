<x-layouts::app :title="__('Main Dashboard')">
    
    <div class="flex h-full w-full flex-1 flex-col gap-0 sm:gap-1 rounded-xl p-1 sm:p-2 pt-0 sm:pt-0">

        <!-- Heading, Welcome Back, dan Jam Realtime -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-2">
            <div class="w-full lg:w-auto">
                <h1 class="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white">Main Dashboard</h1>
                <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-400 mt-1">
                    Welcome back, <span class="font-semibold text-blue-600 dark:text-blue-400 break-all sm:break-normal">{{ auth()->user()->name }}</span>!
                </p>
            </div>
            
            <!-- Jam dan Tanggal Realtime dengan Timezone Asia/Jakarta -->
            <div x-data="{ 
                datetime: new Date(),
                init() {
                    setInterval(() => {
                        this.datetime = new Date();
                    }, 1000);
                },
                formatTime() {
                    return this.datetime.toLocaleTimeString('id-ID', { 
                        timeZone: 'Asia/Jakarta',
                        hour: '2-digit', 
                        minute: '2-digit', 
                        second: '2-digit',
                        hour12: false 
                    });
                },
                formatDate() {
                    return this.datetime.toLocaleDateString('id-ID', { 
                        timeZone: 'Asia/Jakarta',
                        weekday: 'long', 
                        year: 'numeric',
                        month: 'long', 
                        day: 'numeric'
                    });
                }
            }" class="w-full lg:w-auto flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 px-3 sm:px-4 py-2 sm:py-2 bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm">
                
                <!-- Waktu -->
                <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 w-full sm:w-auto justify-between sm:justify-start">
                    <div class="flex items-center gap-2">
                        <flux:icon name="clock" class="w-4 h-4 sm:w-5 sm:h-5" />
                        <span x-text="formatTime()" class="font-mono font-medium text-sm sm:text-base"></span>
                    </div>
                    <span class="text-xs text-zinc-400 sm:hidden">|</span>
                </div>
                
                <div class="hidden sm:block w-px h-5 bg-zinc-200 dark:bg-zinc-700"></div>
                
                <!-- Tanggal -->
                <div class="flex items-center gap-2 text-zinc-600 dark:text-zinc-400 w-full sm:w-auto">
                    <div class="flex items-center gap-2">
                        <flux:icon name="calendar" class="w-4 h-4 sm:w-5 sm:h-5" />
                        <span x-text="formatDate()" class="text-xs sm:text-sm"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards dengan Data Real dari Database -->
        @php
            $userId = auth()->id();
            $now = now()->setTimezone('Asia/Jakarta');
            $today = $now->format('Y-m-d');
            
            // Gunakan cache agar tidak query setiap load
            $dashboardData = Cache::remember("dashboard_{$userId}_{$today}", 300, function() use ($userId, $now, $today) {
                
                // ==================== SESSION ANALYTICS ====================
                $activeSession = DB::table('session_analytics')
                    ->where('user_id', $userId)
                    ->whereNull('logout_at')
                    ->orderBy('login_at', 'desc')
                    ->first();
                
                $sessionDurationMinutes = 0;
                if ($activeSession && $activeSession->login_at) {
                    $loginTime = \Carbon\Carbon::parse($activeSession->login_at)->setTimezone('Asia/Jakarta');
                    $sessionDurationMinutes = $loginTime->diffInMinutes($now);
                }
                
                // Get today's sessions (1 query)
                $todaySessions = DB::table('session_analytics')
                    ->where('user_id', $userId)
                    ->whereDate('login_at', $today)
                    ->count();
                
                // OPTIMASI: 1 query untuk semua session + page views
                $allData = DB::select("
                    SELECT 
                        sa.login_at,
                        pv.created_at as page_view_time,
                        pv.page
                    FROM session_analytics sa
                    LEFT JOIN page_views pv ON pv.user_id = sa.user_id 
                        AND pv.created_at BETWEEN sa.login_at AND DATE_ADD(sa.login_at, INTERVAL 1 HOUR)
                        AND pv.page NOT IN ('livewire', 'livewire/*', 'livewire/update')
                    WHERE sa.user_id = ?
                        AND DATE(sa.login_at) = ?
                ", [$userId, $today]);
                
                // Process data
                $pageViewsDistribution = ['0_5' => 0, '5_10' => 0, '10_30' => 0, '30_60' => 0];
                
                foreach ($allData as $item) {
                    if ($item->page_view_time) {
                        $loginTime = \Carbon\Carbon::parse($item->login_at);
                        $viewTime = \Carbon\Carbon::parse($item->page_view_time);
                        $minutesAfterLogin = $loginTime->diffInMinutes($viewTime);
                        
                        if ($minutesAfterLogin >= 0 && $minutesAfterLogin < 5) {
                            $pageViewsDistribution['0_5']++;
                        } elseif ($minutesAfterLogin >= 5 && $minutesAfterLogin < 10) {
                            $pageViewsDistribution['5_10']++;
                        } elseif ($minutesAfterLogin >= 10 && $minutesAfterLogin < 30) {
                            $pageViewsDistribution['10_30']++;
                        } elseif ($minutesAfterLogin >= 30 && $minutesAfterLogin <= 60) {
                            $pageViewsDistribution['30_60']++;
                        }
                    }
                }
                
                // Today's page views
                $todayPageViews = DB::table('page_views')
                    ->where('user_id', $userId)
                    ->whereDate('created_at', $today)
                    ->whereNotIn('page', ['livewire', 'livewire/*', 'livewire/update'])
                    ->count();
                
                // Top pages
                $topPages = DB::table('page_views')
                    ->where('user_id', $userId)
                    ->whereDate('created_at', $today)
                    ->whereNotIn('page', ['livewire', 'livewire/*', 'livewire/update', 'null'])
                    ->whereNotNull('page')
                    ->select('page', DB::raw('COUNT(*) as views'))
                    ->groupBy('page')
                    ->orderBy('views', 'desc')
                    ->limit(5)
                    ->get();
                
                // Calculate percentages
                $totalPageViewsForDist = array_sum($pageViewsDistribution);
                if ($totalPageViewsForDist == 0) $totalPageViewsForDist = 1;
                
                $percent0_5 = round(($pageViewsDistribution['0_5'] / $totalPageViewsForDist) * 100);
                $percent5_10 = round(($pageViewsDistribution['5_10'] / $totalPageViewsForDist) * 100);
                $percent10_30 = round(($pageViewsDistribution['10_30'] / $totalPageViewsForDist) * 100);
                $percent30_60 = round(($pageViewsDistribution['30_60'] / $totalPageViewsForDist) * 100);
                
                // Current session category
                $currentPageViewCategory = '';
                if ($activeSession) {
                    if ($sessionDurationMinutes >= 0 && $sessionDurationMinutes < 5) {
                        $currentPageViewCategory = '0-5 minutes';
                    } elseif ($sessionDurationMinutes >= 5 && $sessionDurationMinutes < 10) {
                        $currentPageViewCategory = '5-10 minutes';
                    } elseif ($sessionDurationMinutes >= 10 && $sessionDurationMinutes < 30) {
                        $currentPageViewCategory = '10-30 minutes';
                    } elseif ($sessionDurationMinutes >= 30 && $sessionDurationMinutes <= 60) {
                        $currentPageViewCategory = '30-60 minutes';
                    }
                }
                
                return [
                    'todayPageViews' => $todayPageViews,
                    'todaySessions' => $todaySessions,
                    'pageViewsDistribution' => $pageViewsDistribution,
                    'percent0_5' => $percent0_5,
                    'percent5_10' => $percent5_10,
                    'percent10_30' => $percent10_30,
                    'percent30_60' => $percent30_60,
                    'topPages' => $topPages,
                    'currentPageViewCategory' => $currentPageViewCategory,
                    'sessionDurationMinutes' => $sessionDurationMinutes,
                ];
            });
            
            // Extract dari cache
            $todayPageViews = $dashboardData['todayPageViews'];
            $todaySessions = $dashboardData['todaySessions'];
            $pageViewsDistribution = $dashboardData['pageViewsDistribution'];
            $percent0_5 = $dashboardData['percent0_5'];
            $percent5_10 = $dashboardData['percent5_10'];
            $percent10_30 = $dashboardData['percent10_30'];
            $percent30_60 = $dashboardData['percent30_60'];
            $topPages = $dashboardData['topPages'];
            $currentPageViewCategory = $dashboardData['currentPageViewCategory'];
            $sessionDurationMinutes = $dashboardData['sessionDurationMinutes'];
        @endphp

        <!-- Dashboard Container -->
        <div id="dashboard-container" wire:ignore>
            
            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-4">
                
                <!-- LEFT COLUMN: Most Visited Pages Today -->
                <div class="lg:col-span-1 flex flex-col">
                    <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 flex-1">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <flux:heading size="lg">Most Visited Pages Today</flux:heading>
                                <flux:subheading>Pages you've visited the most</flux:subheading>
                            </div>
                            <flux:badge color="blue" size="sm">Top 5</flux:badge>
                        </div>
                        
                        <div id="top-pages-list" class="space-y-2">
                            @php
                                // Filter pages yang mengandung 'api' (case insensitive) - HAPUS dari collection
                                $filteredTopPages = $topPages->reject(function($page) {
                                    return str_contains(strtolower($page->page), 'api');
                                })->values()->take(5);
                            @endphp
                            
                            @forelse($filteredTopPages as $index => $page)
                                <a href="{{ url($page->page) }}" target="_blank" rel="noopener noreferrer" class="block group">
                                    <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-all duration-200">
                                        
                                        <!-- TIMELINE -->
                                        <div class="relative flex flex-col items-center flex-shrink-0">
                                            @php
                                                $rankColors = ['bg-amber-500', 'bg-gray-400', 'bg-orange-600', 'bg-blue-500', 'bg-green-500'];
                                                $rankColor = $rankColors[$index] ?? 'bg-purple-500';
                                            @endphp

                                            <div class="w-8 h-8 rounded-full {{ $rankColor }} flex items-center justify-center text-white font-bold text-sm z-10">
                                                {{ $index + 1 }}
                                            </div>

                                            @if(!$loop->last)
                                                <div class="absolute top-8 left-1/2 -translate-x-1/2 w-[2px] h-[calc(100%+8px)] bg-zinc-300 dark:bg-zinc-600"></div>
                                            @endif
                                        </div>
                                        
                                        <!-- Page Name dengan ellipsis jika terlalu panjang -->
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm font-medium text-zinc-800 dark:text-zinc-200 truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" title="{{ $page->page }}">
                                                {{ $page->page }}
                                            </div>
                                        </div>
                                        
                                        <!-- View Count (flex-shrink-0 agar tidak mengecil) -->
                                        <div class="flex items-center gap-1 flex-shrink-0">
                                            <flux:icon.eye class="w-3.5 h-3.5 text-zinc-400 flex-shrink-0" />
                                            <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                                                {{ $page->views }}
                                            </span>
                                        </div>
                                        
                                        <!-- Arrow (flex-shrink-0 agar tidak mengecil) -->
                                        <flux:icon.arrow-top-right-on-square class="w-4 h-4 text-zinc-400 opacity-0 group-hover:opacity-100 transition-opacity flex-shrink-0" />
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-12">
                                    <flux:icon.chart-bar class="w-12 h-12 text-zinc-400 mx-auto mb-3" />
                                    <p class="text-zinc-500 dark:text-zinc-400">No pages visited yet</p>
                                    <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">Start exploring the dashboard</p>
                                </div>
                            @endforelse
                        </div>
                    </flux:card>
                </div>

                <!-- RIGHT COLUMN: Stats Overview + Page Views Distribution -->
                <div class="lg:col-span-2 flex flex-col gap-4">
                    
                    <!-- Stats Overview Grid (2 cards) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 flex-shrink-0">

                        <!-- Page Views Today -->
                        <flux:card class="p-4 shadow-lg hover:shadow-xl transition-all duration-300 bg-gradient-to-br from-purple-500 to-purple-600 dark:from-purple-700 dark:to-purple-800">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-white/80 dark:text-white/70">Page Views Today</p>
                                    <p id="page-views-today" class="text-2xl font-bold text-white dark:text-white mt-1">{{ number_format($todayPageViews) }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-white/20 dark:bg-white/10 backdrop-blur-sm flex items-center justify-center">
                                    <flux:icon name="document-text" class="w-5 h-5 text-white dark:text-white" />
                                </div>
                            </div>
                        </flux:card>

                        <!-- Total Sessions -->
                        <flux:card class="p-4 shadow-lg hover:shadow-xl transition-all duration-300 bg-gradient-to-br from-amber-500 to-amber-600 dark:from-amber-700 dark:to-amber-800">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-white/80 dark:text-white/70">Total Sessions Today</p>
                                    <p id="total-sessions" class="text-2xl font-bold text-white dark:text-white mt-1">{{ number_format($todaySessions) }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-white/20 dark:bg-white/10 backdrop-blur-sm flex items-center justify-center">
                                    <flux:icon name="arrow-path-rounded-square" class="w-5 h-5 text-white dark:text-white" />
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- Page Views Distribution by Session Duration -->
                    <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 flex-1">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <flux:heading size="lg">Page Views In 1 Hour</flux:heading>
                                <flux:subheading>When do you see the page during Login?</flux:subheading>
                            </div>
                            <flux:badge color="purple" size="sm">Last 60 Minutes</flux:badge>
                        </div>
                        
                        <!-- 4 Speedometer Gauges -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            <!-- Gauge 1: 0-5 minutes -->
                            <div class="flex flex-col items-center">
                                <div class="relative w-32 h-20 mx-auto pageview-gauge-1" data-percentage="{{ $percent0_5 }}">
                                    <svg class="w-full h-full" viewBox="0 0 200 100">
                                        <path d="M 30 85 A 70 70 0 0 1 170 85" fill="none" stroke="#e5e7eb" stroke-width="10" stroke-linecap="round" class="dark:stroke-zinc-700" />
                                        <path class="pageview-arc-1" d="M 30 85 A 70 70 0 0 1 170 85" fill="none" stroke="#10b981" stroke-width="10" stroke-linecap="round" stroke-dasharray="0 220" />
                                        <line class="pageview-needle-1" x1="100" y1="85" x2="100" y2="35" stroke="#4b5563" stroke-width="2.5" stroke-linecap="round" transform="rotate(-90, 100, 85)" />
                                        <circle cx="100" cy="85" r="5" fill="#10b981" stroke="#fff" stroke-width="1.5" />
                                    </svg>
                                </div>
                                <div class="text-center mt-2">
                                    <span class="text-xl font-bold text-emerald-600 dark:text-emerald-400 pageview-percentage-1">{{ $percent0_5 }}%</span>
                                </div>
                                <div class="text-center mt-1">
                                    <div class="flex items-center gap-1 justify-center">
                                        <span class="w-2 h-2 bg-emerald-500 rounded-full {{ $currentPageViewCategory == '0-5 minutes' ? 'animate-pulse' : '' }}"></span>
                                        <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">0-5 minutes</span>
                                    </div>
                                    <span id="views-0_5" class="text-xs text-zinc-500 dark:text-zinc-400">{{ number_format($pageViewsDistribution['0_5']) }} views</span>
                                </div>
                            </div>

                            <!-- Gauge 2: 5-10 minutes -->
                            <div class="flex flex-col items-center">
                                <div class="relative w-32 h-20 mx-auto pageview-gauge-2" data-percentage="{{ $percent5_10 }}">
                                    <svg class="w-full h-full" viewBox="0 0 200 100">
                                        <path d="M 30 85 A 70 70 0 0 1 170 85" fill="none" stroke="#e5e7eb" stroke-width="10" stroke-linecap="round" class="dark:stroke-zinc-700" />
                                        <path class="pageview-arc-2" d="M 30 85 A 70 70 0 0 1 170 85" fill="none" stroke="#8b5cf6" stroke-width="10" stroke-linecap="round" stroke-dasharray="0 220" />
                                        <line class="pageview-needle-2" x1="100" y1="85" x2="100" y2="35" stroke="#4b5563" stroke-width="2.5" stroke-linecap="round" transform="rotate(-90, 100, 85)" />
                                        <circle cx="100" cy="85" r="5" fill="#8b5cf6" stroke="#fff" stroke-width="1.5" />
                                    </svg>
                                </div>
                                <div class="text-center mt-2">
                                    <span class="text-xl font-bold text-purple-600 dark:text-purple-400 pageview-percentage-2">{{ $percent5_10 }}%</span>
                                </div>
                                <div class="text-center mt-1">
                                    <div class="flex items-center gap-1 justify-center">
                                        <span class="w-2 h-2 bg-purple-500 rounded-full {{ $currentPageViewCategory == '5-10 minutes' ? 'animate-pulse' : '' }}"></span>
                                        <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">5-10 minutes</span>
                                    </div>
                                    <span id="views-5_10" class="text-xs text-zinc-500 dark:text-zinc-400">{{ number_format($pageViewsDistribution['5_10']) }} views</span>
                                </div>
                            </div>

                            <!-- Gauge 3: 10-30 minutes -->
                            <div class="flex flex-col items-center">
                                <div class="relative w-32 h-20 mx-auto pageview-gauge-3" data-percentage="{{ $percent10_30 }}">
                                    <svg class="w-full h-full" viewBox="0 0 200 100">
                                        <path d="M 30 85 A 70 70 0 0 1 170 85" fill="none" stroke="#e5e7eb" stroke-width="10" stroke-linecap="round" class="dark:stroke-zinc-700" />
                                        <path class="pageview-arc-3" d="M 30 85 A 70 70 0 0 1 170 85" fill="none" stroke="#3b82f6" stroke-width="10" stroke-linecap="round" stroke-dasharray="0 220" />
                                        <line class="pageview-needle-3" x1="100" y1="85" x2="100" y2="35" stroke="#4b5563" stroke-width="2.5" stroke-linecap="round" transform="rotate(-90, 100, 85)" />
                                        <circle cx="100" cy="85" r="5" fill="#3b82f6" stroke="#fff" stroke-width="1.5" />
                                    </svg>
                                </div>
                                <div class="text-center mt-2">
                                    <span class="text-xl font-bold text-blue-600 dark:text-blue-400 pageview-percentage-3">{{ $percent10_30 }}%</span>
                                </div>
                                <div class="text-center mt-1">
                                    <div class="flex items-center gap-1 justify-center">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full {{ $currentPageViewCategory == '10-30 minutes' ? 'animate-pulse' : '' }}"></span>
                                        <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">10-30 minutes</span>
                                    </div>
                                    <span id="views-10_30" class="text-xs text-zinc-500 dark:text-zinc-400">{{ number_format($pageViewsDistribution['10_30']) }} views</span>
                                </div>
                            </div>

                            <!-- Gauge 4: 30-60 minutes -->
                            <div class="flex flex-col items-center">
                                <div class="relative w-32 h-20 mx-auto pageview-gauge-4" data-percentage="{{ $percent30_60 }}">
                                    <svg class="w-full h-full" viewBox="0 0 200 100">
                                        <path d="M 30 85 A 70 70 0 0 1 170 85" fill="none" stroke="#e5e7eb" stroke-width="10" stroke-linecap="round" class="dark:stroke-zinc-700" />
                                        <path class="pageview-arc-4" d="M 30 85 A 70 70 0 0 1 170 85" fill="none" stroke="#f59e0b" stroke-width="10" stroke-linecap="round" stroke-dasharray="0 220" />
                                        <line class="pageview-needle-4" x1="100" y1="85" x2="100" y2="35" stroke="#4b5563" stroke-width="2.5" stroke-linecap="round" transform="rotate(-90, 100, 85)" />
                                        <circle cx="100" cy="85" r="5" fill="#f59e0b" stroke="#fff" stroke-width="1.5" />
                                    </svg>
                                </div>
                                <div class="text-center mt-2">
                                    <span class="text-xl font-bold text-amber-600 dark:text-amber-400 pageview-percentage-4">{{ $percent30_60 }}%</span>
                                </div>
                                <div class="text-center mt-1">
                                    <div class="flex items-center gap-1 justify-center">
                                        <span class="w-2 h-2 bg-amber-500 rounded-full {{ $currentPageViewCategory == '30-60 minutes' ? 'animate-pulse' : '' }}"></span>
                                        <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">30-60 minutes</span>
                                    </div>
                                    <span id="views-30_60" class="text-xs text-zinc-500 dark:text-zinc-400">{{ number_format($pageViewsDistribution['30_60']) }} views</span>
                                </div>
                            </div>
                        </div>
                    </flux:card>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Function to update gauge with animation
        function animateGauge(gaugeNumber, percentage) {
            const targetPercentage = Math.min(percentage, 100);
            const radius = 70;
            const halfCircumference = Math.PI * radius;
            const arcLength = (targetPercentage / 100) * halfCircumference;
            const dasharray = `${arcLength} ${halfCircumference * 2}`;
            const targetAngle = -90 + (targetPercentage * 1.8);
            
            setTimeout(() => {
                const arcElement = document.querySelector(`.pageview-arc-${gaugeNumber}`);
                const needleElement = document.querySelector(`.pageview-needle-${gaugeNumber}`);
                const percentageElement = document.querySelector(`.pageview-percentage-${gaugeNumber}`);
                
                if (arcElement) {
                    arcElement.style.transition = 'stroke-dasharray 1.5s ease-out';
                    arcElement.setAttribute('stroke-dasharray', dasharray);
                }
                
                if (needleElement) {
                    needleElement.style.transition = 'transform 1.5s ease-out';
                    needleElement.setAttribute('transform', `rotate(${targetAngle}, 100, 85)`);
                }
                
                if (percentageElement) {
                    let current = 0;
                    const increment = percentage / 30;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= percentage) {
                            current = percentage;
                            clearInterval(timer);
                        }
                        percentageElement.textContent = Math.round(current) + '%';
                    }, 50);
                }
            }, 100);
        }
        
        // Function to initialize all gauges
        function initializeGauges() {
            for (let i = 1; i <= 4; i++) {
                const gauge = document.querySelector(`.pageview-gauge-${i}`);
                if (gauge) {
                    const percentage = parseFloat(gauge.dataset.percentage);
                    if (!isNaN(percentage)) {
                        animateGauge(i, percentage);
                    }
                }
            }
        }
        
        // For Livewire SPA mode - using Livewire hooks
        function initDashboard() {
            initializeGauges();
        }
        
        document.addEventListener('livewire:navigated', function() {
            // Reinitialize gauges when navigating to this page
            setTimeout(() => {
                initDashboard();
            }, 100);
        });
        
        // For normal page load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initDashboard);
        } else {
            initDashboard();
        }
    </script>
    @endpush

    <style>
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Dark mode scrollbar */
        .dark .custom-scrollbar::-webkit-scrollbar-track {
            background: #1f2937;
        }
        
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4b5563;
        }
        
        .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
        
        /* Transition effects */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }
    </style>
</x-layouts::app>