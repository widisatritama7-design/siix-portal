<x-layouts::app :title="__('ESD Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-0 sm:gap-4 rounded-xl p-1 sm:p-2 pt-0 sm:pt-0">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white">ESD Dashboard</h1>
                    <flux:badge color="yellow" size="sm">Electrostatic Discharge</flux:badge>
                </div>
                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                    Monitor and track measurement progress, targets, and achievements
                </p>
            </div>
        </div>

        <!-- ========== STATS CARDS (dihitung) ========== -->
        @php
            $now = Carbon\Carbon::now();
            $currentYear = $now->year;
            
            $actualCountStats = App\Models\ESD\Activity\ViewAllMeasurement::whereYear('created_at', $currentYear)->count();
            $targetCountStats = App\Models\ESD\Activity\ViewAllMeasurement::whereYear('next_date', $currentYear)->count();
            $actualProgressStats = $targetCountStats > 0 ? round(($actualCountStats / $targetCountStats) * 100, 2) : 0;
            $percentageStats = $actualProgressStats;
            
            // Trend
            $lastYearActual = App\Models\ESD\Activity\ViewAllMeasurement::whereYear('created_at', $currentYear - 1)->count();
            $trendStats = $lastYearActual > 0 ? round((($actualCountStats - $lastYearActual) / $lastYearActual) * 100, 2) : 0;
        @endphp

        <!-- ========== ROW: YEARLY CHART (70%) + STATS VERTICAL (30%) ========== -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
            
            <!-- YEARLY CHART - 70% -->
            @php
                $yearlySelectedYear = request()->get('yearly_year', $currentYear);
                
                $yearlyMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                $yearlyPercentages = [];
                
                for ($m = 1; $m <= 12; $m++) {
                    $monthlyActual = App\Models\ESD\Activity\ViewAllMeasurement::whereYear('created_at', $yearlySelectedYear)
                        ->whereMonth('created_at', $m)
                        ->distinct('id_table')
                        ->count('id_table');
                        
                    $monthlyTarget = App\Models\ESD\Activity\ViewAllMeasurement::whereYear('next_date', $yearlySelectedYear)
                        ->whereMonth('next_date', $m)
                        ->distinct('id_table')
                        ->count('id_table');
                        
                    if ($monthlyTarget > 0) {
                        $yearlyPercentages[] = round(($monthlyActual / $monthlyTarget) * 100);
                    } else {
                        $yearlyPercentages[] = 0;
                    }
                }
                
                $maxYearly = 100;
                $availableYears = App\Models\ESD\Activity\ViewAllMeasurement::selectRaw('YEAR(created_at) as year')
                    ->union(App\Models\ESD\Activity\ViewAllMeasurement::selectRaw('YEAR(next_date) as year'))
                    ->distinct()
                    ->orderBy('year', 'desc')
                    ->pluck('year');
                    
                if ($availableYears->isEmpty()) {
                    $availableYears = collect([$currentYear]);
                }
            @endphp

            <div class="lg:col-span-8">
                <flux:card class="p-4 sm:p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                        <div>
                            <flux:heading size="lg">Progress Percentage By Month</flux:heading>
                            <flux:subheading>Monthly achievement breakdown for {{ $yearlySelectedYear }}</flux:subheading>
                        </div>
                        <form method="GET" class="flex items-center gap-2">
                            <input type="hidden" name="weekly_year" value="{{ request()->get('weekly_year', $currentYear) }}">
                            <input type="hidden" name="weekly_month" value="{{ request()->get('weekly_month', $now->month) }}">
                            <input type="hidden" name="monthly_start_date" value="{{ request()->get('monthly_start_date', $now->copy()->startOfWeek(Carbon\Carbon::SUNDAY)->toDateString()) }}">
                            <input type="hidden" name="monthly_end_date" value="{{ request()->get('monthly_end_date', $now->copy()->endOfWeek(Carbon\Carbon::SATURDAY)->toDateString()) }}">
                            <select name="yearly_year" onchange="this.form.submit()" class="text-sm rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2">
                                @foreach($availableYears as $yearOption)
                                    <option value="{{ $yearOption }}" {{ $yearlySelectedYear == $yearOption ? 'selected' : '' }}>
                                        {{ $yearOption }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    
                    <div class="mt-2">
                        <div class="flex items-end justify-between h-65 w-full">
                            @foreach($yearlyMonths as $index => $month)
                                @php
                                    $percentage = $yearlyPercentages[$index];
                                    $barHeight = ($percentage / $maxYearly) * 120;
                                @endphp
                                <div class="flex flex-col items-center flex-1">
                                    <div class="relative flex flex-col items-center w-full">
                                        @if($percentage > 0)
                                            <span class="text-xs font-semibold text-purple-600 dark:text-purple-400 mb-1">
                                                {{ $percentage }}%
                                            </span>
                                        @endif
                                        <div class="bg-gradient-to-t from-purple-500 to-purple-600 rounded-full transition-all duration-300 hover:opacity-80 mx-auto" 
                                            style="height: {{ $barHeight }}px; width: 60%;">
                                        </div>
                                    </div>
                                    <span class="text-xs text-zinc-500 mt-2 font-medium">{{ $month }}</span>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="flex justify-center gap-4 pt-3 mt-3 border-t border-zinc-200 dark:border-zinc-700">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                                <span class="text-xs text-zinc-600 dark:text-zinc-400">Achievement Percentage</span>
                            </div>
                        </div>
                    </div>
                </flux:card>
            </div>

            <!-- STATS CARDS VERTICAL - 30% -->
            <div class="lg:col-span-4">
                <flux:card class="p-4 shadow-lg hover:shadow-xl transition-shadow duration-300 bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700 h-full">
                    <div class="flex flex-col gap-4">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-2 mb-1">
                                    <div class="p-1.5 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                        <flux:icon name="flag" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                    </div>
                                    <flux:heading size="sm" class="text-blue-600 dark:text-blue-400">Target</flux:heading>
                                </div>
                                <flux:heading size="xl" class="text-blue-700 dark:text-blue-300">{{ number_format($targetCountStats) }}</flux:heading>
                            </div>

                            <div class="text-center">
                                <div class="flex items-center justify-center gap-2 mb-1">
                                    <div class="p-1.5 bg-green-100 dark:bg-green-900 rounded-lg">
                                        <flux:icon name="check-circle" class="w-4 h-4 text-green-600 dark:text-green-400" />
                                    </div>
                                    <flux:heading size="sm" class="text-green-600 dark:text-green-400">Actual</flux:heading>
                                </div>
                                <flux:heading size="xl" class="text-green-700 dark:text-green-300">{{ number_format($actualCountStats) }}</flux:heading>
                            </div>
                        </div>

                        <div class="border-t border-zinc-200 dark:border-zinc-700"></div>

                        <!-- Achievement - Speedometer Gauge dengan Animasi -->
                        <div class="flex flex-col items-center">
                            <div class="flex items-center justify-center gap-2 mb-2">
                                <div class="p-1.5 bg-purple-100 dark:bg-purple-900 rounded-lg">
                                    <flux:icon name="chart-bar" class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                                </div>
                                <flux:heading size="sm" class="text-purple-600 dark:text-purple-400">Achievement</flux:heading>
                            </div>
                            
                            <div class="relative w-48 h-24 mx-auto achievement-gauge" data-percentage="{{ $percentageStats }}">
                                <svg class="w-full h-full" viewBox="0 0 200 100">
                                    <!-- Background arc -->
                                    <path d="M 20 90 A 80 80 0 0 1 180 90" fill="none" stroke="#e5e7eb" stroke-width="12" stroke-linecap="round" />
                                    <!-- Colored arc -->
                                    <path class="achievement-arc" d="M 20 90 A 80 80 0 0 1 180 90" fill="none" stroke="#8b5cf6" stroke-width="12" stroke-linecap="round" stroke-dasharray="0 251" />
                                    <!-- Jarum mulai dari -90° (paling kiri) SAMA SEPERTI WEEKLY -->
                                    <line class="achievement-needle" x1="100" y1="85" x2="100" y2="25" stroke="#4b5563" stroke-width="2.5" stroke-linecap="round" transform="rotate(-90, 100, 85)" />
                                    <circle cx="100" cy="85" r="5" fill="#8b5cf6" stroke="#fff" stroke-width="1.5" />
                                </svg>
                            </div>
                            
                            <div class="text-center mt-2">
                                <span class="text-2xl font-bold text-purple-700 dark:text-purple-300 achievement-percentage">0%</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t border-zinc-200 dark:border-zinc-700 mt-4"></div>
                    
                    <div class="mt-6 flex items-center justify-center">
                        <div class="flex flex-col items-center justify-center pr-4 gap-1">
                            <span class="text-sm font-semibold text-purple-600 dark:text-purple-400">{{ $now->format('M') }}</span>
                            <span class="text-2xl font-bold text-purple-700 dark:text-purple-300">{{ $now->format('d') }}</span>
                        </div>
                        <div class="w-px h-12 bg-purple-300 dark:bg-purple-700 mx-3"></div>
                        <div class="flex items-center pl-3">
                            <flux:badge color="purple" size="lg" class="text-xl px-5 py-3 font-bold">{{ $now->format('Y') }}</flux:badge>
                        </div>
                    </div>
                </flux:card>
            </div>
        </div>

        <!-- WEEKLY CHART - FULL WIDTH -->
        @php
            $weeklySelectedYear = request()->get('weekly_year', $currentYear);
            $weeklySelectedMonth = request()->get('weekly_month', $now->month);
            
            $weeklyStartOfMonth = Carbon\Carbon::create($weeklySelectedYear, $weeklySelectedMonth, 1)->startOfMonth();
            $weeklyEndOfMonth = Carbon\Carbon::create($weeklySelectedYear, $weeklySelectedMonth, 1)->endOfMonth();

            $weeklyWeeks = [];
            $weeklyCurrentWeekStart = $weeklyStartOfMonth->copy()->startOfWeek(Carbon\Carbon::SUNDAY);
            $weeklyWeekCounter = 1;

            while ($weeklyCurrentWeekStart <= $weeklyEndOfMonth) {
                $weekStart = $weeklyCurrentWeekStart->copy();
                $weekEnd = $weekStart->copy()->endOfWeek(Carbon\Carbon::SATURDAY);
                $weeklyWeeks[] = [
                    'label' => 'Week ' . $weeklyWeekCounter,
                    'full_label' => 'Week ' . $weeklyWeekCounter . ' (' . $weekStart->format('M d') . ' - ' . $weekEnd->format('M d') . ')',
                    'start' => $weekStart,
                    'end' => $weekEnd,
                ];
                $weeklyCurrentWeekStart->addWeek();
                $weeklyWeekCounter++;
            }

            $weeklyPercentagesData = [];
            foreach ($weeklyWeeks as $week) {
                $actual = App\Models\ESD\Activity\ViewAllMeasurement::select('measurement_type', DB::raw('COUNT(DISTINCT id_table) as total'))
                    ->whereBetween('created_at', [$week['start'], $week['end']])
                    ->groupBy('measurement_type')
                    ->pluck('total', 'measurement_type');

                $target = App\Models\ESD\Activity\ViewAllMeasurement::select('measurement_type', DB::raw('COUNT(DISTINCT id_table) as total'))
                    ->whereBetween('next_date', [$week['start'], $week['end']])
                    ->groupBy('measurement_type')
                    ->pluck('total', 'measurement_type');

                $allTypes = $actual->keys()->merge($target->keys())->unique();
                $percentages = [];

                foreach ($allTypes as $type) {
                    $a = $actual->get($type, 0);
                    $t = $target->get($type, 0);
                    if ($t > 0) $percentages[] = ($a / $t) * 100;
                }

                $weeklyPercentagesData[] = count($percentages) ? round(collect($percentages)->avg()) : 0;
            }
            
            $availableMonths = [
                1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
            ];
            
            $weeklyItemsPerRow = 5;
            $weeklyRows = array_chunk($weeklyWeeks, $weeklyItemsPerRow);
            $weeklyPercentagesChunked = array_chunk($weeklyPercentagesData, $weeklyItemsPerRow);
        @endphp

        <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 mt-0">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
                <div>
                    <flux:heading size="lg">Completion By Week</flux:heading>
                    <flux:subheading>{{ $availableMonths[$weeklySelectedMonth] }} {{ $weeklySelectedYear }}</flux:subheading>
                </div>
                <form method="GET" class="flex items-center gap-2">
                    <input type="hidden" name="yearly_year" value="{{ request()->get('yearly_year', $currentYear) }}">
                    <input type="hidden" name="monthly_start_date" value="{{ request()->get('monthly_start_date', $now->copy()->startOfWeek(Carbon\Carbon::SUNDAY)->toDateString()) }}">
                    <input type="hidden" name="monthly_end_date" value="{{ request()->get('monthly_end_date', $now->copy()->endOfWeek(Carbon\Carbon::SATURDAY)->toDateString()) }}">
                    <select name="weekly_month" onchange="this.form.submit()" class="text-sm rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2">
                        @foreach($availableMonths as $monthNum => $monthName)
                            <option value="{{ $monthNum }}" {{ $weeklySelectedMonth == $monthNum ? 'selected' : '' }}>{{ $monthName }}</option>
                        @endforeach
                    </select>
                    <select name="weekly_year" onchange="this.form.submit()" class="text-sm rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2">
                        @foreach($availableYears as $yearOption)
                            <option value="{{ $yearOption }}" {{ $weeklySelectedYear == $yearOption ? 'selected' : '' }}>{{ $yearOption }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            
            @if(count($weeklyWeeks) > 0)
                <div class="flex flex-col items-center">
                    @foreach($weeklyRows as $rowIndex => $rowWeeks)
                        <div class="flex w-full {{ !$loop->last ? 'mb-12 border-b border-zinc-100 dark:border-zinc-800 pb-10' : '' }}" style="justify-content: space-evenly;">
                            @foreach($rowWeeks as $weekIndex => $week)
                                @php
                                    $percentage = $weeklyPercentagesChunked[$rowIndex][$weekIndex] ?? 0;
                                    $percentageGauge = min($percentage, 100);
                                    $targetAngle = -90 + ($percentageGauge * 1.8);
                                @endphp
                                <div class="flex flex-col items-center gauge-container" style="flex: 1; max-width: 200px; min-width: 140px;" data-percentage="{{ $percentageGauge }}">
                                    <div class="relative w-40 h-28 mx-auto">
                                        <svg class="w-full h-full gauge-svg" viewBox="0 0 200 100">
                                            <path d="M 30 85 A 70 70 0 0 1 170 85" fill="none" stroke="#e5e7eb" stroke-width="10" stroke-linecap="round" />
                                            <path class="gauge-arc" d="M 30 85 A 70 70 0 0 1 170 85" fill="none" stroke="#f59e0b" stroke-width="10" stroke-linecap="round" stroke-dasharray="0 220" />
                                            <circle cx="100" cy="85" r="6" fill="#f59e0b" stroke="#fff" stroke-width="2" />
                                            <line class="gauge-needle" x1="100" y1="85" x2="100" y2="35" stroke="#4b5563" stroke-width="3" stroke-linecap="round" transform="rotate(-90, 100, 85)" />
                                        </svg>
                                    </div>
                                    <div class="text-center mt-3">
                                        <span class="text-2xl font-bold text-orange-600 dark:text-orange-400 gauge-percentage">0%</span>
                                    </div>
                                    <div class="text-center mt-1">
                                        <span class="text-sm font-semibold text-zinc-600 dark:text-zinc-400">{{ $week['label'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                            @for($i = count($rowWeeks); $i < $weeklyItemsPerRow; $i++)
                                <div style="flex: 1; max-width: 200px; min-width: 140px;"></div>
                            @endfor
                        </div>
                    @endforeach
                </div>
            @else
                <div class="h-48 flex items-center justify-center">
                    <p class="text-zinc-500">No data available</p>
                </div>
            @endif
        </flux:card>

        <!-- MONTHLY CHART - FULL WIDTH -->
        @php
            $monthlyStartDate = request()->get('monthly_start_date', $now->copy()->startOfWeek(Carbon\Carbon::SUNDAY)->toDateString());
            $monthlyEndDate = request()->get('monthly_end_date', $now->copy()->endOfWeek(Carbon\Carbon::SATURDAY)->toDateString());
            
            $startOfWeek = Carbon\Carbon::parse($monthlyStartDate)->startOfWeek(Carbon\Carbon::SUNDAY);
            $endOfWeek = Carbon\Carbon::parse($monthlyEndDate)->endOfWeek(Carbon\Carbon::SATURDAY);
            
            $typeLabels = [
                'equipment_ground' => 'Equipment Ground', 'ionizer' => 'Ionizer', 'flooring' => 'Flooring',
                'garment' => 'Garment', 'ground_monitor_box' => 'Ground Monitor Box', 'jig' => 'Jig',
                'magazine' => 'Magazine', 'packaging' => 'Packaging', 'soldering' => 'Soldering',
                'worksurface' => 'Worksurface', 'insulatif_checks' => 'Insulatif', 'patrols' => 'Patrol',
                'shower_details' => 'Shower', 'wrist_straps' => 'Wrist Strap', 'glove' => 'Glove',
            ];
            
            $allExistingTypes = App\Models\ESD\Activity\ViewAllMeasurement::select('measurement_type')
                ->distinct()
                ->pluck('measurement_type')
                ->toArray();
            
            $allTypesList = array_keys($typeLabels);
            $allTypes = array_unique(array_merge($allExistingTypes, $allTypesList));
            sort($allTypes);
            
            $createdCounts = App\Models\ESD\Activity\ViewAllMeasurement::select('measurement_type', DB::raw('COUNT(DISTINCT id_table) as total'))
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->groupBy('measurement_type')
                ->pluck('total', 'measurement_type');

            $nextCounts = App\Models\ESD\Activity\ViewAllMeasurement::select('measurement_type', DB::raw('COUNT(DISTINCT id_table) as total'))
                ->whereBetween('next_date', [$startOfWeek, $endOfWeek])
                ->groupBy('measurement_type')
                ->pluck('total', 'measurement_type');

            $chartData = [];
            $maxTarget = 0;

            foreach ($allTypes as $type) {
                $created = $createdCounts->get($type, 0);
                $next = $nextCounts->get($type, 0);
                $percentage = $next > 0 ? round(($created / $next) * 100, 2) : 0;
                
                $chartData[] = [
                    'type' => $typeLabels[$type] ?? $type,
                    'target' => $next,
                    'actual' => $created,
                    'percentage' => $percentage,
                ];
                
                $maxTarget = max($maxTarget, $next);
            }
            
            $maxTarget = $maxTarget > 0 ? $maxTarget : 1;
            
            $itemsPerColumn = 5;
            $totalItems = count($chartData);
            $columns = [];
            
            for ($i = 0; $i < $totalItems; $i += $itemsPerColumn) {
                $columns[] = array_slice($chartData, $i, $itemsPerColumn);
            }
            
            while (count($columns) < 3) {
                $columns[] = [];
            }
        @endphp

        <flux:card class="p-4 sm:p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                <div>
                    <flux:heading size="lg">Measurement Progress By Type</flux:heading>
                    <flux:subheading>{{ $startOfWeek->format('d M Y') }} - {{ $endOfWeek->format('d M Y') }}</flux:subheading>
                </div>
                <form method="GET" class="flex items-center gap-2">
                    <input type="hidden" name="yearly_year" value="{{ request()->get('yearly_year', $currentYear) }}">
                    <input type="hidden" name="weekly_year" value="{{ request()->get('weekly_year', $currentYear) }}">
                    <input type="hidden" name="weekly_month" value="{{ request()->get('weekly_month', $now->month) }}">
                    <input type="date" name="monthly_start_date" value="{{ $monthlyStartDate }}" class="text-sm rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-2 py-1">
                    <span class="text-zinc-500">to</span>
                    <input type="date" name="monthly_end_date" value="{{ $monthlyEndDate }}" class="text-sm rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-2 py-1">
                    <button type="submit" class="text-sm bg-purple-600 hover:bg-purple-700 text-white rounded-lg px-3 py-1 transition-colors">Filter</button>
                </form>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                @foreach($columns as $colIndex => $columnData)
                    <div class="space-y-4">
                        @foreach($columnData as $data)
                            @php
                                $progressPercent = $data['target'] > 0 ? ($data['actual'] / $data['target']) * 100 : 0;
                                $progressPercent = min($progressPercent, 100);
                            @endphp
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">{{ $data['type'] }}</span>
                                    <div class="flex gap-1">
                                        <flux:badge color="blue" size="xs" class="text-[10px] px-1.5 py-0.5">Target: {{ $data['target'] }}</flux:badge>
                                        <flux:badge color="green" size="xs" class="text-[10px] px-1.5 py-0.5">Actual: {{ $data['actual'] }}</flux:badge>
                                        <flux:badge color="yellow" size="xs" class="text-[10px] px-1.5 py-0.5 font-bold">{{ $data['percentage'] }}%</flux:badge>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-7 overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-green-500 to-green-600 rounded-full transition-all duration-500 flex items-center justify-end px-2 text-white text-xs font-medium"
                                            style="width: {{ $progressPercent }}%">
                                            @if($progressPercent > 15)
                                                {{ $data['actual'] }} / {{ $data['target'] }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        @for($i = count($columnData); $i < $itemsPerColumn; $i++)
                            <div class="opacity-0">
                                <div class="h-6 mb-1"></div>
                                <div class="h-7"></div>
                            </div>
                        @endfor
                    </div>
                @endforeach
            </div>
            
            <div class="flex justify-center gap-6 pt-4 mt-4 border-t border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center gap-2"><div class="w-3 h-3 bg-green-500 rounded-full"></div><span class="text-xs">Actual Progress</span></div>
                <div class="flex items-center gap-2"><div class="w-3 h-3 bg-zinc-400 rounded-full"></div><span class="text-xs">Remaining to Target</span></div>
            </div>
        </flux:card>
    </div>

    @push('scripts')
    <script>
        // Fungsi untuk animasi semua gauge
        function animateAllGauges() {
            // ========== ANIMASI WEEKLY GAUGES ==========
            const gaugeContainers = document.querySelectorAll('.gauge-container');
            
            gaugeContainers.forEach(container => {
                const targetPercentage = parseInt(container.dataset.percentage);
                const arcElement = container.querySelector('.gauge-arc');
                const needleElement = container.querySelector('.gauge-needle');
                const percentageElement = container.querySelector('.gauge-percentage');
                
                const radius = 70;
                const halfCircumference = Math.PI * radius;
                const arcLength = (targetPercentage / 100) * halfCircumference;
                const dasharray = `${arcLength} ${halfCircumference * 2}`;
                const targetAngle = -90 + (targetPercentage * 1.8);
                
                // Reset dulu ke posisi awal
                if (arcElement) {
                    arcElement.style.transition = 'none';
                    arcElement.setAttribute('stroke-dasharray', '0 220');
                }
                if (needleElement) {
                    needleElement.style.transition = 'none';
                    needleElement.setAttribute('transform', 'rotate(-90, 100, 85)');
                }
                if (percentageElement) {
                    percentageElement.textContent = '0%';
                }
                
                // Force reflow
                void container.offsetHeight;
                
                // Mulai animasi
                setTimeout(() => {
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
                        const increment = targetPercentage / 30;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= targetPercentage) {
                                current = targetPercentage;
                                clearInterval(timer);
                            }
                            percentageElement.textContent = Math.round(current) + '%';
                        }, 50);
                    }
                }, 100);
            });
            
            // ========== ANIMASI ACHIEVEMENT GAUGE ==========
            const achievementContainer = document.querySelector('.achievement-gauge');
            if (achievementContainer) {
                const targetPercentage = parseFloat(achievementContainer.dataset.percentage);
                const targetPercentageGauge = Math.min(targetPercentage, 100);
                
                const arcElement = document.querySelector('.achievement-arc');
                const needleElement = document.querySelector('.achievement-needle');
                const percentageElement = document.querySelector('.achievement-percentage');
                
                const radius = 80;
                const halfCircumference = Math.PI * radius;
                const arcLength = (targetPercentageGauge / 100) * halfCircumference;
                const dasharray = `${arcLength} ${halfCircumference * 2}`;
                const targetAngle = -90 + (targetPercentageGauge * 1.8);
                
                // Reset dulu ke posisi awal
                if (arcElement) {
                    arcElement.style.transition = 'none';
                    arcElement.setAttribute('stroke-dasharray', '0 251');
                }
                if (needleElement) {
                    needleElement.style.transition = 'none';
                    needleElement.setAttribute('transform', 'rotate(-90, 100, 85)');
                }
                if (percentageElement) {
                    percentageElement.textContent = '0%';
                }
                
                // Force reflow
                void achievementContainer.offsetHeight;
                
                // Mulai animasi
                setTimeout(() => {
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
                        const increment = targetPercentage / 30;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= targetPercentage) {
                                current = targetPercentage;
                                clearInterval(timer);
                            }
                            percentageElement.textContent = Math.round(current) + '%';
                        }, 50);
                    }
                }, 100);
            }
        }
        
        // Inisialisasi pertama kali
        function initDashboard() {
            // Delay sebentar untuk memastikan DOM benar-benar siap
            setTimeout(() => {
                animateAllGauges();
            }, 200);
        }
        
        // Untuk Livewire SPA mode - event navigasi
        document.addEventListener('livewire:navigated', function() {
            // Reset dan animasi ulang saat navigasi ke halaman ini
            setTimeout(() => {
                animateAllGauges();
            }, 200);
        });
        
        // Untuk normal page load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initDashboard);
        } else {
            initDashboard();
        }
    </script>
    @endpush
</x-layouts::app>