<div class="p-1 space-y-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            QA/QC
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Blind Test Report
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Blind Test Report
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Filter and export Blind Test result by employee
            </p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-800 p-4 sm:p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date From</label>
                <input type="date" wire:model="dateFrom"
                       class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date Until</label>
                <input type="date" wire:model="dateUntil"
                       class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Year</label>
                <select wire:model="yearFilter"
                        class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                    <option value="">All Years</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Month</label>
                <select wire:model="monthFilter"
                        class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                    <option value="">All Months</option>
                    @foreach($months as $key => $month)
                        <option value="{{ $key }}">{{ $month }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Department</label>
                <select wire:model="departmentFilter"
                        class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}">{{ $dept }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Section</label>
                <select wire:model="sectionFilter"
                        class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                    <option value="">All Sections</option>
                    @foreach($sections as $section)
                        <option value="{{ $section }}">{{ $section }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex flex-wrap justify-end gap-2 mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
            @if($hasFiltered)
            <button wire:click="resetFilters"
                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Reset Filters
            </button>
            @endif

            <button wire:click="applyFilter"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Apply Filter
            </button>

            @if($hasFiltered)
            <button wire:click="export"
                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Export to Excel
            </button>
            @endif
        </div>
    </div>

    <!-- Preview Table -->
    @if($hasFiltered)
        <flux:card class="p-6 h-full shadow-lg flex flex-col">
            <div class="flex flex-wrap justify-between items-center mb-4 gap-3">
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-white">Filter Results</h2>

                <div class="flex flex-wrap items-center gap-2">
                    {{-- Total Employees --}}
                    <span class="px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-xs font-medium">
                        Total: {{ number_format($totalRecords) }} employees
                    </span>

                    {{-- Average Percentage --}}
                    @php
                        $avgColor = $averagePercentage >= 80 ? 'green' : ($averagePercentage >= 60 ? 'yellow' : ($averagePercentage >= 40 ? 'orange' : 'red'));
                    @endphp
                    <span class="px-3 py-1.5 bg-{{ $avgColor }}-100 dark:bg-{{ $avgColor }}-900/30 text-{{ $avgColor }}-700 dark:text-{{ $avgColor }}-300 rounded-full text-xs font-semibold flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Average: {{ $averagePercentage }}%
                    </span>

                    {{-- Overall Percentage --}}
                    @php
                        $ovrColor = $overallPercentage >= 80 ? 'green' : ($overallPercentage >= 60 ? 'yellow' : ($overallPercentage >= 40 ? 'orange' : 'red'));
                    @endphp
                    <span class="px-3 py-1.5 bg-{{ $ovrColor }}-100 dark:bg-{{ $ovrColor }}-900/30 text-{{ $ovrColor }}-700 dark:text-{{ $ovrColor }}-300 rounded-full text-xs font-semibold flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                        </svg>
                        Overall: {{ $overallPercentage }}%
                    </span>
                </div>
            </div>

            @if($previewData->isEmpty())
                <div class="flex flex-col items-center justify-center gap-3 min-h-[400px] text-center">
                    <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                        <flux:icon name="document-text" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                    </div>
                    <div class="text-center">
                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">No data found</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">No data matching the filter criteria</p>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto flex-1">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NIK</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Department</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Section</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Percobaan</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Fail</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Pass</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Total Soal</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Percentage</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($previewData as $index => $item)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-4 py-3 text-sm text-center text-zinc-500 dark:text-zinc-400">
                                    {{ $previewData->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold text-zinc-800 dark:text-white">
                                    {{ $item['nik'] }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $item['name'] }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $item['department'] }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if(!empty($item['section']) && $item['section'] !== '-')
                                        @foreach(explode(',', $item['section']) as $sec)
                                            <flux:badge size="sm" color="blue" class="mr-1">{{ trim($sec) }}</flux:badge>
                                        @endforeach
                                    @else
                                        <span class="text-sm text-zinc-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @php
                                        $attempt = $item['attempt'] ?? 1;
                                        $maxAttempt = $item['max_attempt'] ?? 2;
                                    @endphp
                                    <flux:badge size="sm" color="{{ $attempt > 1 ? 'purple' : 'zinc' }}">
                                        {{ $attempt }} / {{ $maxAttempt }}
                                    </flux:badge>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($item['fail_count'] > 0)
                                        <flux:badge size="sm" color="red">{{ $item['fail_count'] }}</flux:badge>
                                    @else
                                        <span class="text-sm text-zinc-400">0</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($item['pass_count'] > 0)
                                        <flux:badge size="sm" color="green">{{ $item['pass_count'] }}</flux:badge>
                                    @else
                                        <span class="text-sm text-zinc-400">0</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center text-sm font-semibold text-zinc-800 dark:text-white">
                                    {{ $item['total_soal'] }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @php
                                        $pct = $item['percentage'];
                                        $color = $pct >= 80 ? 'green' : ($pct >= 60 ? 'yellow' : ($pct >= 40 ? 'orange' : 'red'));
                                    @endphp
                                    <flux:badge size="sm" color="{{ $color }}">{{ $pct }}%</flux:badge>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-amber-50 dark:bg-amber-950/20 border-t-2 border-amber-300 dark:border-amber-700">
                                {{-- colspan 7: # + NIK + Name + Department + Section + Percobaan --}}
                                <td colspan="6" class="px-4 py-3 text-right text-sm font-bold text-zinc-800 dark:text-white">
                                    TOTAL
                                </td>
                                {{-- Fail --}}
                                <td class="px-4 py-3 text-center text-sm font-bold text-red-700 dark:text-red-400">
                                    {{ number_format($totalFail) }}
                                </td>
                                {{-- Pass --}}
                                <td class="px-4 py-3 text-center text-sm font-bold text-green-700 dark:text-green-400">
                                    {{ number_format($totalPass) }}
                                </td>
                                {{-- Total Soal --}}
                                <td class="px-4 py-3 text-center text-sm font-bold text-zinc-800 dark:text-white">
                                    {{ number_format($totalSoal) }}
                                </td>
                                {{-- Percentage --}}
                                <td class="px-4 py-3 text-center text-sm font-bold text-zinc-800 dark:text-white">
                                    {{ $overallPercentage }}%
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($previewData->hasPages())
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 mt-auto">
                    {{ $previewData->links() }}
                </div>
                @endif
            @endif
        </flux:card>

        <!-- Summary Distribution & Donut Chart -->
        @if(!$previewData->isEmpty())
        <div class="grid grid-cols-1 gap-4">
            <!-- Summary Table -->
            <flux:card class="p-6 shadow-lg">
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-white mb-4">
                    Percentage Distribution
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Percentage</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Count</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">% of Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @php
                                $colors = [
                                    0 => 'red',
                                    20 => 'orange',
                                    40 => 'yellow',
                                    60 => 'lime',
                                    80 => 'green',
                                    100 => 'emerald',
                                ];
                            @endphp
                            @foreach($percentageDistribution as $pct => $count)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-4 py-3">
                                    <flux:badge size="sm" color="{{ $colors[$pct] ?? 'zinc' }}">{{ $pct }}%</flux:badge>
                                </td>
                                <td class="px-4 py-3 text-center text-sm font-semibold text-zinc-800 dark:text-white">
                                    {{ $count }} orang
                                </td>
                                <td class="px-4 py-3 text-center text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $totalRecords > 0 ? round(($count / $totalRecords) * 100, 1) : 0 }}%
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-amber-50 dark:bg-amber-950/20 border-t-2 border-amber-300 dark:border-amber-700">
                                <td class="px-4 py-3 text-sm font-bold text-zinc-800 dark:text-white">TOTAL</td>
                                <td class="px-4 py-3 text-center text-sm font-bold text-zinc-800 dark:text-white">
                                    {{ $totalRecords }} orang
                                </td>
                                <td class="px-4 py-3 text-center text-sm font-bold text-zinc-800 dark:text-white">
                                    100%
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </flux:card>
        </div>

        <!-- Print PDF Button -->
        <div class="flex justify-end">
            <a href="{{ route('qaqc.blind-test.print', [
                    'dateFrom'         => $dateFrom,
                    'dateUntil'        => $dateUntil,
                    'yearFilter'       => $yearFilter,
                    'monthFilter'      => $monthFilter,
                    'departmentFilter' => $departmentFilter,
                    'sectionFilter'    => $sectionFilter,
                ]) }}"
                target="_blank"
                class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print PDF
            </a>
        </div>
        @endif
    @else
        <div class="flex flex-col items-center justify-center gap-3 min-h-[400px] bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-800 p-12">
            <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                <flux:icon name="no-symbol" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
            </div>
            <div class="text-center">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">No Filter Applied</h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Select filters above and click "Apply Filter" to view results</p>
            </div>
        </div>
    @endif

    <style>
        [x-cloak] { display: none !important; }
    </style>

    @assets
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.2/dist/apexcharts.min.js"></script>
    @endassets

    @script
    <script>
        let blindTestChartInstance = null;

        function renderBlindTestChart(distribution) {
            const el = document.getElementById('blindTestChart');
            if (!el) return;

            if (typeof ApexCharts === 'undefined') {
                console.error('ApexCharts not loaded');
                return;
            }

            if (blindTestChartInstance) {
                blindTestChartInstance.destroy();
                blindTestChartInstance = null;
            }

            const labels = Object.keys(distribution).map(k => k + '%');
            const series = Object.values(distribution).map(v => Number(v));
            const total = series.reduce((a, b) => a + b, 0);

            if (total === 0) {
                el.innerHTML = '<div style="text-align:center;padding:50px;color:#999;">No data</div>';
                return;
            }

            const colors = ['#ef4444', '#f97316', '#eab308', '#84cc16', '#22c55e', '#10b981'];

            const options = {
                chart: { type: 'donut', height: 380, fontFamily: 'inherit' },
                series: series,
                labels: labels,
                colors: colors,
                legend: { position: 'bottom', fontSize: '13px' },
                dataLabels: {
                    enabled: true,
                    formatter: (val) => val.toFixed(1) + '%',
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: () => total + ' orang',
                                }
                            }
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: (val) => {
                            const pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                            return val + ' orang (' + pct + '%)';
                        }
                    }
                }
            };

            blindTestChartInstance = new ApexCharts(el, options);
            blindTestChartInstance.render();
        }

        renderBlindTestChart(@js($percentageDistribution));

        Livewire.hook('morph.updated', () => {
            setTimeout(() => {
                renderBlindTestChart(@js($percentageDistribution));
            }, 150);
        });
    </script>
    @endscript
</div>