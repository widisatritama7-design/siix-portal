<x-layouts::app :title="__('Main Dashboard')">
    
    <div class="flex h-full w-full flex-1 flex-col gap-1 sm:gap-2 rounded-xl p-1 sm:p-2">

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
            $todayStart = $now->copy()->startOfDay();
            $todayEnd = $now->copy()->endOfDay();
            
            // ==================== SESSION ANALYTICS ====================
            // Get active session (user yang belum logout)
            $activeSession = DB::table('session_analytics')
                ->where('user_id', $userId)
                ->whereNull('logout_at')
                ->orderBy('login_at', 'desc')
                ->first();
            
            // Get today's sessions
            $todaySessions = DB::table('session_analytics')
                ->where('user_id', $userId)
                ->whereDate('login_at', $today)
                ->count();
            
            // Get last login time
            $lastLogin = DB::table('session_analytics')
                ->where('user_id', $userId)
                ->orderBy('login_at', 'desc')
                ->first();
            
            // Calculate average session duration for this user
            $avgSessionDuration = DB::table('session_analytics')
                ->where('user_id', $userId)
                ->whereNotNull('duration_seconds')
                ->avg('duration_seconds');
            
            $avgSessionMinutes = $avgSessionDuration ? round($avgSessionDuration / 60) : 0;
            
            // ==================== USER ACTIVITIES ====================
            // Get today's activities
            $todayActivities = DB::table('user_activities')
                ->where('user_id', $userId)
                ->whereDate('created_at', $today)
                ->count();
            
            // Get activities by type today
            $activitiesByType = DB::table('user_activities')
                ->where('user_id', $userId)
                ->whereDate('created_at', $today)
                ->select('action', DB::raw('COUNT(*) as count'))
                ->groupBy('action')
                ->get()
                ->keyBy('action');
            
            // Get hourly activity data
            $hourlyActivity = DB::table('user_activities')
                ->where('user_id', $userId)
                ->whereDate('created_at', $today)
                ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as count'))
                ->groupBy('hour')
                ->orderBy('hour')
                ->get()
                ->keyBy('hour');
            
            // ==================== PAGE VIEWS ====================
            // Get today's page views
            $todayPageViews = DB::table('page_views')
                ->where('user_id', $userId)
                ->whereDate('created_at', $today)
                ->count();
            
            // Get unique pages visited today
            $uniquePagesToday = DB::table('page_views')
                ->where('user_id', $userId)
                ->whereDate('created_at', $today)
                ->distinct('page')
                ->count('page');
            
            // Get most visited pages
            $topPages = DB::table('page_views')
                ->where('user_id', $userId)
                ->whereDate('created_at', $today)
                ->select('page', DB::raw('COUNT(*) as views'))
                ->groupBy('page')
                ->orderBy('views', 'desc')
                ->limit(5)
                ->get();
            
            // ==================== COMBINED STATS ====================
            // Check if user is active now (activity in last 5 minutes)
            $activeNow = DB::table('user_activities')
                ->where('user_id', $userId)
                ->where('created_at', '>=', $now->copy()->subMinutes(5))
                ->exists() || ($activeSession && $activeSession->login_at >= $now->copy()->subMinutes(5));
            
            // Generate data untuk chart (24 jam)
            $hours = [];
            $activityData = [];
            
            for ($hour = 0; $hour <= 23; $hour++) {
                $hours[] = $hour . ':00';
                $activityData[] = isset($hourlyActivity[$hour]) ? $hourlyActivity[$hour]->count : 0;
            }
            
            $maxActivity = !empty($activityData) ? max($activityData) : 1;
            
            // ==================== RECENT ACTIVITIES (Combined) ====================
            // Get recent user activities
            $recentActivities = DB::table('user_activities')
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function($item) {
                    return (object)[
                        'type' => 'activity',
                        'action' => $item->action,
                        'description' => $item->description,
                        'created_at' => $item->created_at,
                        'icon' => $item->action == 'login' ? 'arrow-right-end-on-rectangle' : 
                                ($item->action == 'logout' ? 'arrow-left-start-on-rectangle' : 
                                ($item->action == 'create' ? 'plus' : 
                                ($item->action == 'update' ? 'pencil-square' : 
                                ($item->action == 'download' ? 'arrow-down-tray' : 'eye')))),
                        'color' => $item->action == 'login' ? 'text-green-500 bg-green-100' : 
                                  ($item->action == 'logout' ? 'text-orange-500 bg-orange-100' : 
                                  ($item->action == 'create' ? 'text-blue-500 bg-blue-100' : 
                                  ($item->action == 'update' ? 'text-purple-500 bg-purple-100' : 
                                  ($item->action == 'download' ? 'text-amber-500 bg-amber-100' : 
                                  'text-zinc-500 bg-zinc-100'))))
                    ];
                });
            
            // Get recent page views
            $recentPageViews = DB::table('page_views')
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function($item) {
                    return (object)[
                        'type' => 'page_view',
                        'action' => 'view',
                        'description' => 'Visited ' . $item->page,
                        'page' => $item->page,
                        'page' => $item->page,
                        'created_at' => $item->created_at,
                        'icon' => 'eye',
                        'color' => 'text-blue-500 bg-blue-100'
                    ];
                });
            
            // Combine and sort by created_at
            $allRecent = collect($recentActivities)
                ->concat($recentPageViews)
                ->sortByDesc('created_at')
                ->take(20)
                ->values();
            
            // Session statistics for distribution
            $totalActivities = DB::table('user_activities')
                ->where('user_id', $userId)
                ->count() ?: 1;
            
            $lt5min = DB::table('user_activities')
                ->where('user_id', $userId)
                ->where('created_at', '>=', $now->copy()->subMinutes(5))
                ->count();
            $lt5minPercent = round(($lt5min / $totalActivities) * 100);
            
            $lt15min = DB::table('user_activities')
                ->where('user_id', $userId)
                ->whereBetween('created_at', [$now->copy()->subMinutes(15), $now->copy()->subMinutes(5)])
                ->count();
            $lt15minPercent = round(($lt15min / $totalActivities) * 100);
            
            $lt30min = DB::table('user_activities')
                ->where('user_id', $userId)
                ->whereBetween('created_at', [$now->copy()->subMinutes(30), $now->copy()->subMinutes(15)])
                ->count();
            $lt30minPercent = round(($lt30min / $totalActivities) * 100);
            
            $gt30min = DB::table('user_activities')
                ->where('user_id', $userId)
                ->where('created_at', '<', $now->copy()->subMinutes(30))
                ->count();
            $gt30minPercent = round(($gt30min / $totalActivities) * 100);
        @endphp

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-2">
            <!-- Your Status Card -->
            <flux:card class="p-6 bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 border-emerald-200 dark:border-emerald-800 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-emerald-700 dark:text-emerald-300">Your Status</flux:heading>
                        <flux:heading size="xl" class="mt-1 text-emerald-800 dark:text-emerald-200">
                            @if($activeNow)
                                <span class="flex items-center gap-2">
                                    Active Now
                                    <span class="relative flex h-3 w-3">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                    </span>
                                </span>
                            @else
                                Inactive
                            @endif
                        </flux:heading>
                        <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1">
                            @if($lastLogin)
                                Last login: {{ \Carbon\Carbon::parse($lastLogin->login_at)->setTimezone('Asia/Jakarta')->diffForHumans() }}
                            @endif
                        </p>
                    </div>
                    <div class="p-3 bg-emerald-200 dark:bg-emerald-800 rounded-lg">
                        <flux:icon name="user" class="w-5 h-5 text-emerald-700 dark:text-emerald-200" />
                    </div>
                </div>
            </flux:card>

            <!-- Today's Activities Card -->
            <flux:card class="p-6 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 border-blue-200 dark:border-blue-800 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-blue-700 dark:text-blue-300">Session's Activities</flux:heading>
                        <flux:heading size="xl" class="mt-1 text-blue-800 dark:text-blue-200">{{ $todayActivities }}</flux:heading>
                        <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                            {{ $todayPageViews }} page views, {{ $todaySessions }} sessions
                        </p>
                    </div>
                    <div class="p-3 bg-blue-200 dark:bg-blue-800 rounded-lg">
                        <flux:icon name="arrow-trending-up" class="w-5 h-5 text-blue-700 dark:text-blue-200" />
                    </div>
                </div>
            </flux:card>

            <!-- Pages Visited Card -->
            <flux:card class="p-6 bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 border-amber-200 dark:border-amber-800 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-amber-700 dark:text-amber-300">Pages Visited</flux:heading>
                        <flux:heading size="xl" class="mt-1 text-amber-800 dark:text-amber-200">{{ $uniquePagesToday }}</flux:heading>
                        <p class="text-xs text-amber-600 dark:text-amber-400 mt-1">Unique pages today</p>
                    </div>
                    <div class="p-3 bg-amber-200 dark:bg-amber-800 rounded-lg">
                        <flux:icon name="document-text" class="w-5 h-5 text-amber-700 dark:text-amber-200" />
                    </div>
                </div>
            </flux:card>
        </div>

        <!-- Activity Chart -->
        <div class="mt-4">
            <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <flux:heading size="lg">Your Activity Today</flux:heading>
                        <flux:subheading>Hourly activities - {{ $now->format('l, d F Y') }}</flux:subheading>
                    </div>
                    <flux:badge color="blue" size="sm">Real Data</flux:badge>
                </div>
                
                <!-- Bar Chart -->
                <div class="h-64 relative">
                    <div class="absolute inset-0 flex items-end justify-around px-4">
                        @foreach($activityData as $index => $count)
                            @php
                                $height = $maxActivity > 0 ? ($count / $maxActivity) * 100 : 0;
                                $barHeight = max($height, 5);
                            @endphp
                            <div class="flex flex-col items-center w-1/24 relative group px-1">
                                <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-xs font-medium text-blue-600 dark:text-blue-400 opacity-0 group-hover:opacity-100 transition-opacity">
                                    {{ $count }} activities
                                </div>
                                
                                <div class="w-full bg-gradient-to-t from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 rounded-t-lg transition-all duration-300 group-hover:from-blue-600 group-hover:to-blue-700 cursor-pointer"
                                    style="height: {{ $barHeight }}px; {{ $count == 0 ? 'opacity: 0.3;' : '' }}">
                                </div>
                                
                                <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-zinc-800 dark:bg-zinc-700 text-white text-xs rounded-lg px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-20 pointer-events-none shadow-lg">
                                    <div class="font-semibold">{{ $hours[$index] }}</div>
                                    <div class="{{ $count > 0 ? 'text-blue-300' : 'text-zinc-400' }}">
                                        {{ $count }} {{ $count == 1 ? 'activity' : 'activities' }}
                                    </div>
                                </div>
                                
                                @if($index % 3 == 0)
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400 absolute -bottom-6">
                                        {{ $hours[$index] }}
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Legend -->
                <div class="flex items-center justify-between mt-12 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-blue-500 dark:bg-blue-600 rounded"></div>
                            <span class="text-xs text-zinc-600 dark:text-zinc-400">Your Activities per Hour</span>
                        </div>
                        <div class="flex items-center gap-2">
                            @foreach($activitiesByType->take(3) as $action => $data)
                                <span class="text-xs px-2 py-1 bg-zinc-100 dark:bg-zinc-800 rounded-full">
                                    {{ $action }}: {{ $data->count }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-xs text-zinc-500">
                        Total: {{ array_sum($activityData) }} activities
                    </div>
                </div>
            </flux:card>
        </div>

        <!-- Recent Activity and Session Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-4">
            <!-- Recent Activity Timeline -->
            <div class="w-full">
                <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 h-full">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <flux:heading size="lg">Your Recent Activity</flux:heading>
                            <flux:subheading>Your latest 5 activities</flux:subheading>
                        </div>
                        <flux:badge color="blue" size="sm">Real-time</flux:badge>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($allRecent->take(5) as $activity)
                            <div class="flex items-start gap-3 group hover:bg-zinc-50 dark:hover:bg-zinc-800/50 p-2 rounded-lg transition-colors">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full {{ $activity->color }} dark:{{ str_replace('bg-', 'dark:bg-', $activity->color) }}/30 flex items-center justify-center">
                                        <flux:icon name="{{ $activity->icon }}" class="w-4 h-4" />
                                    </div>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-zinc-900 dark:text-white">
                                            @if($activity->type == 'activity')
                                                {{ ucfirst($activity->action) }}
                                                @if($activity->description)
                                                    <span class="text-xs text-zinc-500">- {{ $activity->description }}</span>
                                                @endif
                                            @else
                                                Viewed {{ $activity->page }}
                                            @endif
                                        </p>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ \Carbon\Carbon::parse($activity->created_at)->setTimezone('Asia/Jakarta')->diffForHumans() }}
                                        </span>
                                    </div>
                                    @if($activity->type == 'page_view' && $activity->page)
                                        <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-0.5 truncate">
                                            {{ $activity->page }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <flux:icon name="clock" class="w-12 h-12 text-zinc-400 mx-auto mb-2" />
                                <p class="text-zinc-500 dark:text-zinc-400">No activities yet</p>
                            </div>
                        @endforelse
                        
                        @if($allRecent->count() > 5)
                            <div class="text-center pt-2">
                                <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                    + {{ $allRecent->count() - 5 }} more activities
                                </span>
                            </div>
                        @endif
                    </div>
                </flux:card>
            </div>

            <!-- Session Statistics -->
            <div class="w-full">
                <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 h-full">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <flux:heading size="lg">Session Statistics</flux:heading>
                            <flux:subheading>Your activity patterns</flux:subheading>
                        </div>
                        <flux:badge color="purple" size="sm">Analytics</flux:badge>
                    </div>
                    
                    <!-- Activity distribution -->
                    <div class="space-y-4">
                        <div>
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="text-zinc-600 dark:text-zinc-400">Last 5 minutes</span>
                                <span class="font-medium text-zinc-800 dark:text-white">{{ $lt5min }} activities ({{ $lt5minPercent }}%)</span>
                            </div>
                            <div class="w-full h-2 bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $lt5minPercent }}%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="text-zinc-600 dark:text-zinc-400">5 - 15 minutes ago</span>
                                <span class="font-medium text-zinc-800 dark:text-white">{{ $lt15min }} activities ({{ $lt15minPercent }}%)</span>
                            </div>
                            <div class="w-full h-2 bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-500 rounded-full" style="width: {{ $lt15minPercent }}%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="text-zinc-600 dark:text-zinc-400">15 - 30 minutes ago</span>
                                <span class="font-medium text-zinc-800 dark:text-white">{{ $lt30min }} activities ({{ $lt30minPercent }}%)</span>
                            </div>
                            <div class="w-full h-2 bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                                <div class="h-full bg-purple-500 rounded-full" style="width: {{ $lt30minPercent }}%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="text-zinc-600 dark:text-zinc-400">> 30 minutes ago</span>
                                <span class="font-medium text-zinc-800 dark:text-white">{{ $gt30min }} activities ({{ $gt30minPercent }}%)</span>
                            </div>
                            <div class="w-full h-2 bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                                <div class="h-full bg-amber-500 rounded-full" style="width: {{ $gt30minPercent }}%"></div>
                            </div>
                        </div>

                        <!-- Top Pages -->
                        @if($topPages->count() > 0)
                            <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                                <h4 class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3">Most Visited Pages Today</h4>
                                <div class="space-y-2">
                                    @foreach($topPages as $page)
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-zinc-600 dark:text-zinc-400 truncate max-w-[200px]">{{ $page->page }}</span>
                                            <span class="font-medium text-zinc-800 dark:text-white">{{ $page->views }} views</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </flux:card>
            </div>
        </div>
    </div>

    <style>
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        .max-h-96 {
            max-height: 24rem;
            overflow-y: auto;
        }
    </style>
</x-layouts::app>