<?php # [BlazeFolded]:{flux::icon}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::icon}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::heading}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/heading.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::subheading}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/subheading.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::badge}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/badge/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::icon.eye}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/eye.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::icon.arrow-top-right-on-square}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/arrow-top-right-on-square.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::icon.chart-bar}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/chart-bar.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::card}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::icon}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::card}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::icon}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/icon/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::card}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::heading}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/heading.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::subheading}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/subheading.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::badge}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/badge/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::card}:{/www/wwwroot/test.siix-ems.co.id/siix-portal/vendor/livewire/flux/src/../stubs/resources/views/flux/card/index.blade.php}:{1774988736} ?>
<?php if (isset($component)) { $__componentOriginal81a506f898233b9e7d58286e6bea3c18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal81a506f898233b9e7d58286e6bea3c18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'f4ac99e09542ff494432bc959d4fee61::app','data' => ['title' => __('Main Dashboard')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts::app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Main Dashboard'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    
    <div class="flex h-full w-full flex-1 flex-col gap-0 sm:gap-1 rounded-xl p-1 sm:p-2 pt-0 sm:pt-0">

        <!-- Heading, Welcome Back, dan Jam Realtime -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-2">
            <div class="w-full lg:w-auto">
                <h1 class="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white">Main Dashboard</h1>
                <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-400 mt-1">
                    Welcome back, <span class="font-semibold text-blue-600 dark:text-blue-400 break-all sm:break-normal"><?php echo e(auth()->user()->name); ?></span>!
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
                        <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 w-4 h-4 sm:w-5 sm:h-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                        <span x-text="formatTime()" class="font-mono font-medium text-sm sm:text-base"></span>
                    </div>
                    <span class="text-xs text-zinc-400 sm:hidden">|</span>
                </div>
                
                <div class="hidden sm:block w-px h-5 bg-zinc-200 dark:bg-zinc-700"></div>
                
                <!-- Tanggal -->
                <div class="flex items-center gap-2 text-zinc-600 dark:text-zinc-400 w-full sm:w-auto">
                    <div class="flex items-center gap-2">
                        <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 w-4 h-4 sm:w-5 sm:h-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                        <span x-text="formatDate()" class="text-xs sm:text-sm"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards dengan Data Real dari Database -->
        <?php
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
            
            // Calculate session remaining time (1 hour limit)
            $sessionRemainingSeconds = 0;
            $sessionExpired = false;
            $sessionDurationMinutes = 0;
            if ($activeSession && $activeSession->login_at) {
                $loginTime = \Carbon\Carbon::parse($activeSession->login_at)->setTimezone('Asia/Jakarta');
                $sessionEndTime = $loginTime->copy()->addHours(1);
                $now = now()->setTimezone('Asia/Jakarta');
                
                $sessionDurationMinutes = $loginTime->diffInMinutes($now);
                
                if ($now->gte($sessionEndTime)) {
                    $sessionExpired = true;
                    $sessionRemainingSeconds = 0;
                } else {
                    $sessionRemainingSeconds = $now->diffInSeconds($sessionEndTime, false);
                }
            }
            
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
            
            // ==================== PAGE VIEWS DISTRIBUTION BY SESSION DURATION ====================
            // Get all sessions for today
            $allSessions = DB::table('session_analytics')
                ->where('user_id', $userId)
                ->whereDate('login_at', $today)
                ->get();
            
            // Initialize counters for page views in each session duration category
            $pageViewsDistribution = [
                '0_5' => 0,
                '5_10' => 0,
                '10_30' => 0,
                '30_60' => 0,
            ];
            
            // For each session, get its page views and categorize by when they occurred
            foreach ($allSessions as $session) {
                $loginTime = \Carbon\Carbon::parse($session->login_at)->setTimezone('Asia/Jakarta');
                $sessionEndTime = $loginTime->copy()->addHours(1);
                
                $sessionPageViews = DB::table('page_views')
                    ->where('user_id', $userId)
                    ->whereBetween('created_at', [$loginTime, $sessionEndTime])
                    ->whereNotIn('page', ['livewire', 'livewire/*', 'livewire/update'])
                    ->orderBy('created_at', 'asc')
                    ->get();
                
                foreach ($sessionPageViews as $pageView) {
                    $viewTime = \Carbon\Carbon::parse($pageView->created_at)->setTimezone('Asia/Jakarta');
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
            
            // Calculate total page views for distribution
            $totalPageViewsForDist = array_sum($pageViewsDistribution);
            if ($totalPageViewsForDist == 0) {
                $totalPageViewsForDist = 1;
            }
            
            // Calculate percentages
            $percent0_5 = round(($pageViewsDistribution['0_5'] / $totalPageViewsForDist) * 100);
            $percent5_10 = round(($pageViewsDistribution['5_10'] / $totalPageViewsForDist) * 100);
            $percent10_30 = round(($pageViewsDistribution['10_30'] / $totalPageViewsForDist) * 100);
            $percent30_60 = round(($pageViewsDistribution['30_60'] / $totalPageViewsForDist) * 100);
            
            // Adjust percentages to ensure total = 100%
            $totalPercent = $percent0_5 + $percent5_10 + $percent10_30 + $percent30_60;
            if ($totalPercent != 100 && $totalPercent > 0) {
                $diff = 100 - $totalPercent;
                $percentages = [
                    '0_5' => &$percent0_5,
                    '5_10' => &$percent5_10,
                    '10_30' => &$percent10_30,
                    '30_60' => &$percent30_60
                ];
                arsort($percentages);
                foreach ($percentages as $key => &$value) {
                    $value += $diff;
                    break;
                }
            }
            
            // Get current session's page view category for active session
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
            
            // ==================== PAGE VIEWS ====================
            // Get today's page views (filter out Livewire routes)
            $todayPageViews = DB::table('page_views')
                ->where('user_id', $userId)
                ->whereDate('created_at', $today)
                ->whereNotIn('page', ['livewire', 'livewire/*', 'livewire/update'])
                ->count();
            
            // Get most visited pages (filter out Livewire)
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
        ?>

        <!-- Dashboard Container -->
        <div id="dashboard-container" wire:ignore>
            
            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-4">
                
                <!-- LEFT COLUMN: Most Visited Pages Today -->
                <div class="lg:col-span-1 flex flex-col">
                    <?php ob_start(); ?><div class="[:where(&amp;)]:bg-white dark:[:where(&amp;)]:bg-white/10 border border-zinc-200 dark:border-white/10 [:where(&amp;)]:p-6 [:where(&amp;)]:rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 flex-1" data-flux-card>
    <?php ob_start(); ?>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-base [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>Most Visited Pages Today<?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>
                                <?php ob_start(); ?><div class="text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70" data-flux-subheading>
    <?php ob_start(); ?>Pages you've visited the most<?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
                            </div>
                            <?php ob_start(); ?><div data-flux-badge="data-flux-badge" class="inline-flex items-center font-medium whitespace-nowrap  [print-color-adjust:exact] text-xs py-1 **:data-flux-badge-icon:me-1 rounded-md px-2 text-blue-800 [&amp;_button]:text-blue-800! dark:text-blue-200 dark:[&amp;_button]:text-blue-200! bg-blue-400/20 dark:bg-blue-400/40 [&amp;:is(button)]:hover:bg-blue-400/30 dark:[button]:hover:bg-blue-400/50">
        <?php ob_start(); ?>Top 5<?php echo trim(ob_get_clean()); ?>

    </div>
<?php echo ltrim(ob_get_clean()); ?>
                        </div>
                        
                        <div id="top-pages-list" class="space-y-2">
                            <?php
                                // Filter pages yang mengandung 'api' (case insensitive) - HAPUS dari collection
                                $filteredTopPages = $topPages->reject(function($page) {
                                    return str_contains(strtolower($page->page), 'api');
                                })->values()->take(5);
                            ?>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $filteredTopPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <a href="<?php echo e(url($page->page)); ?>" target="_blank" rel="noopener noreferrer" class="block group">
                                    <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-all duration-200">
                                        
                                        <!-- TIMELINE -->
                                        <div class="relative flex flex-col items-center">
                                            <?php
                                                $rankColors = ['bg-amber-500', 'bg-gray-400', 'bg-orange-600', 'bg-blue-500', 'bg-green-500'];
                                                $rankColor = $rankColors[$index] ?? 'bg-purple-500';
                                            ?>

                                            <div class="w-8 h-8 rounded-full <?php echo e($rankColor); ?> flex items-center justify-center text-white font-bold text-sm z-10">
                                                <?php echo e($index + 1); ?>

                                            </div>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$loop->last): ?>
                                                <div class="absolute top-8 left-1/2 -translate-x-1/2 w-[2px] h-[calc(100%+8px)] bg-zinc-300 dark:bg-zinc-600"></div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <!-- Page Name -->
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-zinc-800 dark:text-zinc-200 truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                                <?php echo e($page->page); ?>

                                            </div>
                                        </div>
                                        
                                        <!-- View Count -->
                                        <div class="flex items-center gap-1">
                                            <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 w-3.5 h-3.5 text-zinc-400" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                                            <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                                                <?php echo e($page->views); ?>

                                            </span>
                                        </div>
                                        
                                        <!-- Arrow -->
                                        <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 w-4 h-4 text-zinc-400 opacity-0 group-hover:opacity-100 transition-opacity" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                                    </div>
                                </a>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <div class="text-center py-12">
                                    <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 w-12 h-12 text-zinc-400 mx-auto mb-3" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                                    <p class="text-zinc-500 dark:text-zinc-400">No pages visited yet</p>
                                    <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">Start exploring the dashboard</p>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
                </div>

                <!-- RIGHT COLUMN: Stats Overview + Page Views Distribution -->
                <div class="lg:col-span-2 flex flex-col gap-4">
                    
                    <!-- Stats Overview Grid (2 cards) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 flex-shrink-0">

                        <!-- Page Views Today -->
                        <?php ob_start(); ?><div class="[:where(&amp;)]:bg-white dark:[:where(&amp;)]:bg-white/10 border border-zinc-200 dark:border-white/10 [:where(&amp;)]:p-6 [:where(&amp;)]:rounded-xl p-4 shadow-lg hover:shadow-xl transition-all duration-300 bg-gradient-to-br from-purple-500 to-purple-600 dark:from-purple-700 dark:to-purple-800" data-flux-card>
    <?php ob_start(); ?>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-white/80 dark:text-white/70">Page Views Today</p>
                                    <p id="page-views-today" class="text-2xl font-bold text-white dark:text-white mt-1"><?php echo e(number_format($todayPageViews)); ?></p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-white/20 dark:bg-white/10 backdrop-blur-sm flex items-center justify-center">
                                    <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 w-5 h-5 text-white dark:text-white" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                                </div>
                            </div>
                        <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>

                        <!-- Total Sessions -->
                        <?php ob_start(); ?><div class="[:where(&amp;)]:bg-white dark:[:where(&amp;)]:bg-white/10 border border-zinc-200 dark:border-white/10 [:where(&amp;)]:p-6 [:where(&amp;)]:rounded-xl p-4 shadow-lg hover:shadow-xl transition-all duration-300 bg-gradient-to-br from-amber-500 to-amber-600 dark:from-amber-700 dark:to-amber-800" data-flux-card>
    <?php ob_start(); ?>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-white/80 dark:text-white/70">Total Sessions Today</p>
                                    <p id="total-sessions" class="text-2xl font-bold text-white dark:text-white mt-1"><?php echo e(number_format($todaySessions)); ?></p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-white/20 dark:bg-white/10 backdrop-blur-sm flex items-center justify-center">
                                    <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 w-5 h-5 text-white dark:text-white" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                                </div>
                            </div>
                        <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
                    </div>

                    <!-- Page Views Distribution by Session Duration -->
                    <?php ob_start(); ?><div class="[:where(&amp;)]:bg-white dark:[:where(&amp;)]:bg-white/10 border border-zinc-200 dark:border-white/10 [:where(&amp;)]:p-6 [:where(&amp;)]:rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 flex-1" data-flux-card>
    <?php ob_start(); ?>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-base [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?>Page Views In 1 Hour<?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>
                                <?php ob_start(); ?><div class="text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70" data-flux-subheading>
    <?php ob_start(); ?>When do you see the page during Login?<?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
                            </div>
                            <?php ob_start(); ?><div data-flux-badge="data-flux-badge" class="inline-flex items-center font-medium whitespace-nowrap  [print-color-adjust:exact] text-xs py-1 **:data-flux-badge-icon:me-1 rounded-md px-2 text-purple-700 [&amp;_button]:text-purple-700! dark:text-purple-200 dark:[&amp;_button]:text-purple-200! bg-purple-400/20 dark:bg-purple-400/40 [&amp;:is(button)]:hover:bg-purple-400/30 dark:[button]:hover:bg-purple-400/50">
        <?php ob_start(); ?>Last 60 Minutes<?php echo trim(ob_get_clean()); ?>

    </div>
<?php echo ltrim(ob_get_clean()); ?>
                        </div>
                        
                        <!-- 4 Speedometer Gauges -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            <!-- Gauge 1: 0-5 minutes -->
                            <div class="flex flex-col items-center">
                                <div class="relative w-32 h-20 mx-auto pageview-gauge-1" data-percentage="<?php echo e($percent0_5); ?>">
                                    <svg class="w-full h-full" viewBox="0 0 200 100">
                                        <path d="M 30 85 A 70 70 0 0 1 170 85" fill="none" stroke="#e5e7eb" stroke-width="10" stroke-linecap="round" class="dark:stroke-zinc-700" />
                                        <path class="pageview-arc-1" d="M 30 85 A 70 70 0 0 1 170 85" fill="none" stroke="#10b981" stroke-width="10" stroke-linecap="round" stroke-dasharray="0 220" />
                                        <line class="pageview-needle-1" x1="100" y1="85" x2="100" y2="35" stroke="#4b5563" stroke-width="2.5" stroke-linecap="round" transform="rotate(-90, 100, 85)" />
                                        <circle cx="100" cy="85" r="5" fill="#10b981" stroke="#fff" stroke-width="1.5" />
                                    </svg>
                                </div>
                                <div class="text-center mt-2">
                                    <span class="text-xl font-bold text-emerald-600 dark:text-emerald-400 pageview-percentage-1"><?php echo e($percent0_5); ?>%</span>
                                </div>
                                <div class="text-center mt-1">
                                    <div class="flex items-center gap-1 justify-center">
                                        <span class="w-2 h-2 bg-emerald-500 rounded-full <?php echo e($currentPageViewCategory == '0-5 minutes' ? 'animate-pulse' : ''); ?>"></span>
                                        <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">0-5 minutes</span>
                                    </div>
                                    <span id="views-0_5" class="text-xs text-zinc-500 dark:text-zinc-400"><?php echo e(number_format($pageViewsDistribution['0_5'])); ?> views</span>
                                </div>
                            </div>

                            <!-- Gauge 2: 5-10 minutes -->
                            <div class="flex flex-col items-center">
                                <div class="relative w-32 h-20 mx-auto pageview-gauge-2" data-percentage="<?php echo e($percent5_10); ?>">
                                    <svg class="w-full h-full" viewBox="0 0 200 100">
                                        <path d="M 30 85 A 70 70 0 0 1 170 85" fill="none" stroke="#e5e7eb" stroke-width="10" stroke-linecap="round" class="dark:stroke-zinc-700" />
                                        <path class="pageview-arc-2" d="M 30 85 A 70 70 0 0 1 170 85" fill="none" stroke="#8b5cf6" stroke-width="10" stroke-linecap="round" stroke-dasharray="0 220" />
                                        <line class="pageview-needle-2" x1="100" y1="85" x2="100" y2="35" stroke="#4b5563" stroke-width="2.5" stroke-linecap="round" transform="rotate(-90, 100, 85)" />
                                        <circle cx="100" cy="85" r="5" fill="#8b5cf6" stroke="#fff" stroke-width="1.5" />
                                    </svg>
                                </div>
                                <div class="text-center mt-2">
                                    <span class="text-xl font-bold text-purple-600 dark:text-purple-400 pageview-percentage-2"><?php echo e($percent5_10); ?>%</span>
                                </div>
                                <div class="text-center mt-1">
                                    <div class="flex items-center gap-1 justify-center">
                                        <span class="w-2 h-2 bg-purple-500 rounded-full <?php echo e($currentPageViewCategory == '5-10 minutes' ? 'animate-pulse' : ''); ?>"></span>
                                        <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">5-10 minutes</span>
                                    </div>
                                    <span id="views-5_10" class="text-xs text-zinc-500 dark:text-zinc-400"><?php echo e(number_format($pageViewsDistribution['5_10'])); ?> views</span>
                                </div>
                            </div>

                            <!-- Gauge 3: 10-30 minutes -->
                            <div class="flex flex-col items-center">
                                <div class="relative w-32 h-20 mx-auto pageview-gauge-3" data-percentage="<?php echo e($percent10_30); ?>">
                                    <svg class="w-full h-full" viewBox="0 0 200 100">
                                        <path d="M 30 85 A 70 70 0 0 1 170 85" fill="none" stroke="#e5e7eb" stroke-width="10" stroke-linecap="round" class="dark:stroke-zinc-700" />
                                        <path class="pageview-arc-3" d="M 30 85 A 70 70 0 0 1 170 85" fill="none" stroke="#3b82f6" stroke-width="10" stroke-linecap="round" stroke-dasharray="0 220" />
                                        <line class="pageview-needle-3" x1="100" y1="85" x2="100" y2="35" stroke="#4b5563" stroke-width="2.5" stroke-linecap="round" transform="rotate(-90, 100, 85)" />
                                        <circle cx="100" cy="85" r="5" fill="#3b82f6" stroke="#fff" stroke-width="1.5" />
                                    </svg>
                                </div>
                                <div class="text-center mt-2">
                                    <span class="text-xl font-bold text-blue-600 dark:text-blue-400 pageview-percentage-3"><?php echo e($percent10_30); ?>%</span>
                                </div>
                                <div class="text-center mt-1">
                                    <div class="flex items-center gap-1 justify-center">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full <?php echo e($currentPageViewCategory == '10-30 minutes' ? 'animate-pulse' : ''); ?>"></span>
                                        <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">10-30 minutes</span>
                                    </div>
                                    <span id="views-10_30" class="text-xs text-zinc-500 dark:text-zinc-400"><?php echo e(number_format($pageViewsDistribution['10_30'])); ?> views</span>
                                </div>
                            </div>

                            <!-- Gauge 4: 30-60 minutes -->
                            <div class="flex flex-col items-center">
                                <div class="relative w-32 h-20 mx-auto pageview-gauge-4" data-percentage="<?php echo e($percent30_60); ?>">
                                    <svg class="w-full h-full" viewBox="0 0 200 100">
                                        <path d="M 30 85 A 70 70 0 0 1 170 85" fill="none" stroke="#e5e7eb" stroke-width="10" stroke-linecap="round" class="dark:stroke-zinc-700" />
                                        <path class="pageview-arc-4" d="M 30 85 A 70 70 0 0 1 170 85" fill="none" stroke="#f59e0b" stroke-width="10" stroke-linecap="round" stroke-dasharray="0 220" />
                                        <line class="pageview-needle-4" x1="100" y1="85" x2="100" y2="35" stroke="#4b5563" stroke-width="2.5" stroke-linecap="round" transform="rotate(-90, 100, 85)" />
                                        <circle cx="100" cy="85" r="5" fill="#f59e0b" stroke="#fff" stroke-width="1.5" />
                                    </svg>
                                </div>
                                <div class="text-center mt-2">
                                    <span class="text-xl font-bold text-amber-600 dark:text-amber-400 pageview-percentage-4"><?php echo e($percent30_60); ?>%</span>
                                </div>
                                <div class="text-center mt-1">
                                    <div class="flex items-center gap-1 justify-center">
                                        <span class="w-2 h-2 bg-amber-500 rounded-full <?php echo e($currentPageViewCategory == '30-60 minutes' ? 'animate-pulse' : ''); ?>"></span>
                                        <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">30-60 minutes</span>
                                    </div>
                                    <span id="views-30_60" class="text-xs text-zinc-500 dark:text-zinc-400"><?php echo e(number_format($pageViewsDistribution['30_60'])); ?> views</span>
                                </div>
                            </div>
                        </div>
                    <?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>

                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
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
    <?php $__env->stopPush(); ?>

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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal81a506f898233b9e7d58286e6bea3c18)): ?>
<?php $attributes = $__attributesOriginal81a506f898233b9e7d58286e6bea3c18; ?>
<?php unset($__attributesOriginal81a506f898233b9e7d58286e6bea3c18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal81a506f898233b9e7d58286e6bea3c18)): ?>
<?php $component = $__componentOriginal81a506f898233b9e7d58286e6bea3c18; ?>
<?php unset($__componentOriginal81a506f898233b9e7d58286e6bea3c18); ?>
<?php endif; ?><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/home/dashboard.blade.php ENDPATH**/ ?>