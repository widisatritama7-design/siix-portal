{{-- resources/views/dashboard/kaizen_simple.blade.php --}}
@php
    use Carbon\Carbon;
    use App\Models\PROD\Kaizen\Kaizen;
@endphp

<x-layouts::app :title="__('Kaizen Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-0 sm:gap-4 rounded-xl p-1 sm:p-2 pt-0 sm:pt-0">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white">Kaizen Dashboard</h1>
                    <flux:badge color="purple" size="sm">Continuous Improvement</flux:badge>
                </div>
                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                    Monitor and track Kaizen initiatives, improvements, and achievements
                </p>
            </div>
        </div>

        @php
            // Get filter values - single filter untuk kedua chart
            $selectedYear = request()->get('year', Carbon::now()->year);
            $selectedMonth = request()->get('month', Carbon::now()->month);
            
            // Pastikan tipe data benar
            $selectedYear = (int) $selectedYear;
            
            // Stats Cards Data (semua data, tanpa filter)
            $pendingCount = Kaizen::where('status_kaizen', 'Pending')->count();
            $rejectedCount = Kaizen::where('status_kaizen', 'Rejected')->count();
            $approvedCount = Kaizen::where('status_kaizen', 'Approved')->count();
            
            // Query builder untuk chart dan rank
            $query = Kaizen::query();
            
            // Apply filter year
            $query->whereYear('created_at', $selectedYear);
            
            // Apply filter month hanya jika ada (bukan string kosong)
            if (!empty($selectedMonth) && $selectedMonth !== '') {
                $query->whereMonth('created_at', (int) $selectedMonth);
            }
            
            // Chart Data - By Process and Status
            $chartProcesses = (clone $query)
                ->select('process')
                ->distinct()
                ->whereNotNull('process')
                ->pluck('process')
                ->toArray();
            
            $totalCounts = (clone $query)
                ->selectRaw('process, count(*) as total')
                ->groupBy('process')
                ->pluck('total', 'process');
            
            $approvedCounts = (clone $query)
                ->where('status_kaizen', 'Approved')
                ->selectRaw('process, count(*) as approved_total')
                ->groupBy('process')
                ->pluck('approved_total', 'process');
            
            $chartTotalData = [];
            $chartApprovedData = [];
            
            foreach ($chartProcesses as $process) {
                $chartTotalData[] = $totalCounts[$process] ?? 0;
                $chartApprovedData[] = $approvedCounts[$process] ?? 0;
            }
            
            $maxChartValue = !empty($chartTotalData) ? max($chartTotalData) : 1;
            
            // Rank Data - Top processes by approved Kaizen
            $rankData = (clone $query)
                ->where('status_kaizen', 'Approved')
                ->selectRaw('process, COUNT(*) as total')
                ->groupBy('process')
                ->orderByDesc('total')
                ->get();
            
            $rankLabels = $rankData->pluck('process')->toArray();
            $rankSeries = $rankData->pluck('total')->toArray();
            
            if (empty($rankSeries)) {
                $rankLabels = ['No Data'];
                $rankSeries = [1];
            }
            
            // Available years for filters
            $availableYears = Kaizen::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year')
                ->toArray();
            
            if (empty($availableYears)) {
                $availableYears = [Carbon::now()->year];
            }
            
            // Calculate total for percentage
            $rankTotal = array_sum($rankSeries);
            
            // Helper function untuk format month name
            $getMonthName = function($month) {
                if (empty($month) || $month === '') {
                    return 'All Months';
                }
                return Carbon::create()->month((int) $month)->format('F');
            };
            
            $monthName = $getMonthName($selectedMonth);
        @endphp

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Pending Card -->
            <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-950/30 dark:to-blue-900/20 border-blue-200 dark:border-blue-800">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-blue-700 dark:text-blue-300">Pending</flux:heading>
                        <flux:heading size="xl" class="mt-2 text-blue-800 dark:text-blue-200">{{ $pendingCount }}</flux:heading>
                        <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">Kaizen entries that are pending</p>
                    </div>
                    <div class="p-3 bg-blue-200 dark:bg-blue-800 rounded-lg">
                        <flux:icon name="clock" class="w-6 h-6 text-blue-700 dark:text-blue-300" />
                    </div>
                </div>
            </flux:card>
            
            <!-- Rejected Card -->
            <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 bg-gradient-to-br from-red-50 to-red-100 dark:from-red-950/30 dark:to-red-900/20 border-red-200 dark:border-red-800">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-red-700 dark:text-red-300">Rejected</flux:heading>
                        <flux:heading size="xl" class="mt-2 text-red-800 dark:text-red-200">{{ $rejectedCount }}</flux:heading>
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1">Kaizen entries that are rejected</p>
                    </div>
                    <div class="p-3 bg-red-200 dark:bg-red-800 rounded-lg">
                        <flux:icon name="folder-open" class="w-6 h-6 text-red-700 dark:text-red-300" />
                    </div>
                </div>
            </flux:card>
            
            <!-- Approved Card -->
            <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-950/30 dark:to-green-900/20 border-green-200 dark:border-green-800">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-green-700 dark:text-green-300">Approved</flux:heading>
                        <flux:heading size="xl" class="mt-2 text-green-800 dark:text-green-200">{{ $approvedCount }}</flux:heading>
                        <p class="text-xs text-green-600 dark:text-green-400 mt-1">Kaizen entries that are approved</p>
                    </div>
                    <div class="p-3 bg-green-200 dark:bg-green-800 rounded-lg">
                        <flux:icon name="check-circle" class="w-6 h-6 text-green-700 dark:text-green-300" />
                    </div>
                </div>
            </flux:card>
        </div>

        <!-- Filter Section - Full Width Version -->
        <flux:card class="p-4 shadow-lg">
            <form method="GET" class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300 whitespace-nowrap">Year :</label>
                    <select name="year" class="text-sm rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 w-[110px]">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300 whitespace-nowrap">Month :</label>
                    <select name="month" class="text-sm rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 w-[140px]">
                        <option value="">All Months</option>
                        @foreach(range(1, 12) as $month)
                            <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>
                                {{ Carbon::create()->month($month)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex-1"></div>
                
                <div class="flex items-center gap-2">
                    <button type="submit" class="px-5 py-2 text-sm bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium min-w-[100px]">
                        Apply Filter
                    </button>
                    @if(request()->has('year') || request()->has('month'))
                        <a href="{{ url()->current() }}" class="px-4 py-2 text-sm bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600 transition-colors inline-block min-w-[80px] text-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </flux:card>

        <!-- Charts Section: 70% Left (Bar Chart) & 30% Right (Rank) -->
        <div class="flex flex-col lg:flex-row gap-4">
            <!-- Left Side: Kaizen Chart by Process and Status - 70% width -->
            <div class="lg:w-[70%]">
                <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 h-full">
                    <div class="mb-4">
                        <flux:heading size="lg">Kaizen Chart</flux:heading>
                        <flux:subheading>By Process and Status - {{ $monthName }} {{ $selectedYear }}</flux:subheading>
                    </div>
                    
                    @php
                        // Daftar semua proses yang ditentukan
                        $allProcesses = ['SMT', 'MI', 'ROUTER', 'LASER', 'PREPARATION', 'TECHNICIAN', 'MAINTENANCE', 'ESD', 'UTILITY', 'PE', 'QUALITY', 'MATERIAL'];
                        
                        // Buat array data untuk semua process (default 0)
                        $allTotalData = [];
                        $allApprovedData = [];
                        
                        foreach ($allProcesses as $process) {
                            $total = \App\Models\PROD\Kaizen\Kaizen::where('process', $process)
                                ->whereYear('created_at', $selectedYear)
                                ->when(!empty($selectedMonth) && $selectedMonth !== '', function($q) use ($selectedMonth) {
                                    return $q->whereMonth('created_at', (int) $selectedMonth);
                                })
                                ->count();
                            
                            $approved = \App\Models\PROD\Kaizen\Kaizen::where('process', $process)
                                ->where('status_kaizen', 'Approved')
                                ->whereYear('created_at', $selectedYear)
                                ->when(!empty($selectedMonth) && $selectedMonth !== '', function($q) use ($selectedMonth) {
                                    return $q->whereMonth('created_at', (int) $selectedMonth);
                                })
                                ->count();
                            
                            $allTotalData[] = $total;
                            $allApprovedData[] = $approved;
                        }
                        
                        $maxChartValue = !empty($allTotalData) ? max(max($allTotalData), max($allApprovedData), 1) : 1;
                        
                        // Bagi data menjadi 3 baris (masing-masing 4 process)
                        $chunks = array_chunk($allProcesses, 4);
                        $totalChunks = array_chunk($allTotalData, 4);
                        $approvedChunks = array_chunk($allApprovedData, 4);
                    @endphp
                    
                    <div class="space-y-6">
                        @foreach($chunks as $chunkIndex => $chunkProcesses)
                            <div>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    @foreach($chunkProcesses as $index => $process)
                                        @php
                                            $originalIndex = ($chunkIndex * 4) + $index;
                                            $totalCount = $totalChunks[$chunkIndex][$index] ?? 0;
                                            $approvedCount = $approvedChunks[$chunkIndex][$index] ?? 0;
                                            $totalPercent = ($maxChartValue > 0) ? ($totalCount / $maxChartValue) * 100 : 0;
                                            $approvedPercent = ($maxChartValue > 0) ? ($approvedCount / $maxChartValue) * 100 : 0;
                                        @endphp
                                        
                                        <div class="group p-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                            <!-- Process Label -->
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300 truncate" title="{{ $process }}">
                                                    {{ $process }}
                                                </span>
                                                <div class="flex gap-2">
                                                    <span class="text-[9px] font-medium text-green-600 dark:text-green-400">{{ $approvedCount }}</span>
                                                    <span class="text-[9px] font-medium text-blue-600 dark:text-blue-400">{{ $totalCount }}</span>
                                                </div>
                                            </div>
                                            
                                            <!-- Approved Bar (Green) -->
                                            <div class="mb-0.5">
                                                <div class="h-2 bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                                                    <div class="h-full bg-gradient-to-r from-green-500 to-green-400 rounded-full transition-all duration-500 ease-out group-hover:opacity-80" 
                                                        style="width: {{ $approvedPercent }}%;"></div>
                                                </div>
                                            </div>
                                            
                                            <!-- Total Bar (Blue) -->
                                            <div>
                                                <div class="h-2 bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                                                    <div class="h-full bg-gradient-to-r from-blue-500 to-blue-400 rounded-full transition-all duration-500 ease-out group-hover:opacity-80" 
                                                        style="width: {{ $totalPercent }}%;"></div>
                                                </div>
                                            </div>
                                            
                                            <!-- Mini indicator -->
                                            @if($approvedCount > 0)
                                                <div class="mt-1 text-[8px] text-green-600 dark:text-green-400 text-right">
                                                    ✓ {{ round(($approvedCount / max($totalCount, 1)) * 100) }}%
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Separator antar baris (kecuali baris terakhir) -->
                                @if(!$loop->last)
                                    <div class="border-t border-zinc-100 dark:border-zinc-800 my-3"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Legend -->
                    <div class="flex items-center justify-center gap-6 mt-6 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                        <div class="flex items-center gap-1.5">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="text-[10px] text-zinc-600 dark:text-zinc-400">Approved</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="text-[10px] text-zinc-600 dark:text-zinc-400">Total</span>
                        </div>
                    </div>
                </flux:card>
            </div>
            
            <!-- Right Side: Kaizen Rank by Process - 30% width -->
            <div class="lg:w-[30%]">
                <flux:card class="p-4 sm:p-5 shadow-lg hover:shadow-xl transition-shadow duration-300 h-full">
                    <div class="flex items-center gap-2 mb-3">
                        <flux:icon name="trophy" class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                        <flux:heading size="md">Kaizen Rank</flux:heading>
                    </div>
                    <flux:subheading class="mb-3 text-xs">Top Processes by Approved - {{ $monthName }} {{ $selectedYear }}</flux:subheading>
                    
                    @php
                        // Daftar semua proses
                        $allProcessesForRank = ['SMT', 'MI', 'ROUTER', 'LASER', 'PREPARATION', 'TECHNICIAN', 'MAINTENANCE', 'ESD', 'UTILITY', 'PE', 'QUALITY', 'MATERIAL'];
                        
                        $rankDataAll = [];
                        foreach ($allProcessesForRank as $process) {
                            $count = \App\Models\PROD\Kaizen\Kaizen::where('process', $process)
                                ->where('status_kaizen', 'Approved')
                                ->whereYear('created_at', $selectedYear)
                                ->when(!empty($selectedMonth) && $selectedMonth !== '', function($q) use ($selectedMonth) {
                                    return $q->whereMonth('created_at', (int) $selectedMonth);
                                })
                                ->count();
                            
                            if ($count > 0) {
                                $rankDataAll[] = (object) ['process' => $process, 'total' => $count];
                            }
                        }
                        
                        // Urutkan berdasarkan total tertinggi
                        usort($rankDataAll, function($a, $b) {
                            return $b->total <=> $a->total;
                        });
                        
                        // Ambil top 5 saja
                        $topRankData = array_slice($rankDataAll, 0, 5);
                        $hasRankData = !empty($topRankData);
                        
                        // Warna untuk setiap peringkat
                        $rankColors = [
                            1 => ['bg' => 'bg-yellow-50 dark:bg-yellow-950/30', 'border' => 'border-yellow-200 dark:border-yellow-800', 'badge' => 'yellow', 'text' => 'text-yellow-700 dark:text-yellow-400'],
                            2 => ['bg' => 'bg-gray-50 dark:bg-gray-950/30', 'border' => 'border-gray-200 dark:border-gray-800', 'badge' => 'gray', 'text' => 'text-gray-700 dark:text-gray-400'],
                            3 => ['bg' => 'bg-orange-50 dark:bg-orange-950/30', 'border' => 'border-orange-200 dark:border-orange-800', 'badge' => 'orange', 'text' => 'text-orange-700 dark:text-orange-400'],
                            4 => ['bg' => 'bg-blue-50 dark:bg-blue-950/30', 'border' => 'border-blue-200 dark:border-blue-800', 'badge' => 'blue', 'text' => 'text-blue-700 dark:text-blue-400'],
                            5 => ['bg' => 'bg-green-50 dark:bg-green-950/30', 'border' => 'border-green-200 dark:border-green-800', 'badge' => 'green', 'text' => 'text-green-700 dark:text-green-400'],
                        ];
                    @endphp
                    
                    <div class="space-y-2">
                        @if($hasRankData)
                            @foreach($topRankData as $index => $item)
                                @php
                                    $rank = $index + 1;
                                    $color = $rankColors[$rank] ?? $rankColors[5];
                                    $medalIcon = $rank == 1 ? '🏆' : ($rank == 2 ? '🥈' : ($rank == 3 ? '🥉' : '📌'));
                                @endphp
                                <div class="{{ $color['bg'] }} rounded-lg p-2 border {{ $color['border'] }} hover:shadow-md transition-shadow duration-200">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm">{{ $medalIcon }}</span>
                                            <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">
                                                #{{ $rank }}
                                            </span>
                                            <span class="text-xs font-medium {{ $color['text'] }} truncate max-w-[100px]" title="{{ $item->process }}">
                                                {{ $item->process }}
                                            </span>
                                        </div>
                                        <flux:badge color="{{ $color['badge'] }}" size="sm">{{ $item->total }}</flux:badge>
                                    </div>
                                </div>
                            @endforeach
                            
                            <!-- Total summary -->
                            <div class="bg-purple-50 dark:bg-purple-950/30 rounded-lg p-2 border border-purple-200 dark:border-purple-800 mt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Total Approved</span>
                                    <span class="font-bold text-purple-600 dark:text-purple-400 text-sm">{{ array_sum(array_column($rankDataAll, 'total')) }}</span>
                                </div>
                                <div class="text-[10px] text-zinc-500 dark:text-zinc-400">
                                    From {{ count($rankDataAll) }} active processes
                                </div>
                            </div>
                        @else
                            <div class="h-64 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-3xl mb-2">📊</div>
                                    <p class="text-zinc-500 text-xs">No approved Kaizen data<br>available for selected period</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </flux:card>
            </div>
        </div>
    </div>
</x-layouts::app>