<div class="p-1 space-y-2">
    @section('title', 'Attendance Summary')
    
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">HR</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Attendance</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Summary</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header dengan Reset Button -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">Attendance Summary</h1>
            <p class="text-sm text-zinc-500">Monitor attendance data and statistics</p>
        </div>
        <button wire:click="resetFilters" 
                class="px-4 py-2 text-sm font-medium text-white bg-zinc-600 hover:bg-zinc-700 rounded-lg transition-colors">
            Reset Filters
        </button>
    </div>

    <!-- Access Error Message -->
    @if($accessError)
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
        <p class="font-medium">⚠️ {{ $accessError }}</p>
    </div>
    @endif

    <!-- One User Access Info -->
    @if($isOneUserAccess && $userDepartment)
    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg">
        <p class="font-medium">🔒 You are viewing data for department: <strong>{{ $userDepartment }}</strong></p>
    </div>
    @endif

    <!-- Filters -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Start Date</label>
            <input type="date" wire:model.live="startDate" 
                   class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">End Date</label>
            <input type="date" wire:model.live="endDate" 
                   class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Department</label>
            <select wire:model.live="selectedDepartment" 
                    class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500"
                    {{ $isOneUserAccess ? 'disabled' : '' }}>
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept }}">{{ $dept }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Karyawan</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($summaryData['total_employees']) }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-blue-100 text-xs mt-2">Periode berjalan</p>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Rata-rata Kehadiran</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($summaryData['avg_percentage'], 1) }}%</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-green-100 text-xs mt-2">Dari total hari kerja</p>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Total Ketidakhadiran</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($summaryData['total_absence']) }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-red-100 text-xs mt-2">Selama periode</p>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Detail Absensi</p>
                    <div class="grid grid-cols-3 gap-2 mt-1 text-sm">
                        <div><span class="font-bold">CT:</span> {{ number_format($summaryData['total_CT']) }}</div>
                        <div><span class="font-bold">SD:</span> {{ number_format($summaryData['total_SD']) }}</div>
                        <div><span class="font-bold">IJ:</span> {{ number_format($summaryData['total_IJ']) }}</div>
                        <div><span class="font-bold">A:</span> {{ number_format($summaryData['total_A']) }}</div>
                        <div><span class="font-bold">CK:</span> {{ number_format($summaryData['total_CK']) }}</div>
                        <div><span class="font-bold">CM:</span> {{ number_format($summaryData['total_CM']) }}</div>
                    </div>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart 1: Persentase per Hari - Simple Bar Chart with Vertical Scroll -->
    <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="text-xl font-semibold text-zinc-800 dark:text-white">📊 Persentase Kehadiran per Hari</h2>
                <p class="text-sm text-zinc-500 mt-1">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-1"><div class="w-3 h-3 bg-green-500 rounded"></div><span class="text-xs">Kehadiran</span></div>
            </div>
        </div>
        
        @if(count($percentageData) > 0 && collect($percentageData)->avg('percentage') > 0)
            @php $totalDays = count($percentageData); @endphp
            <!-- Vertical scroll wrapper if more than 10 days -->
            <div @if($totalDays > 10) class="overflow-y-auto max-h-96" @endif>
                <div class="space-y-3">
                    @foreach($percentageData as $data)
                        @php $barWidth = $data['percentage']; @endphp
                        <div class="flex items-center gap-3">
                            <div class="w-24 sm:w-32 flex-shrink-0">
                                <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">{{ $data['display_date'] }}</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex h-6 rounded-md overflow-hidden shadow-sm bg-zinc-100 dark:bg-zinc-800">
                                    <div class="bg-gradient-to-r from-green-500 to-green-600 flex items-center justify-end px-2 text-[10px] text-white font-medium transition-all duration-300 hover:opacity-90" 
                                        style="width: {{ $barWidth }}%">
                                        @if($barWidth > 15)
                                            <span>{{ number_format($barWidth, 1) }}%</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="w-16 flex-shrink-0 text-right">
                                <span class="text-xs font-semibold text-green-600 dark:text-green-400">{{ number_format($barWidth, 1) }}%</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if($totalDays > 10)
                <div class="text-center text-xs text-zinc-400 mt-3 pt-2 border-t">
                    Scroll untuk melihat semua data ({{ $totalDays }} hari)
                </div>
            @endif
        @else
            <div class="text-center py-10 text-zinc-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p>Tidak ada data kehadiran untuk periode dan department yang dipilih</p>
            </div>
        @endif
    </flux:card>

    <!-- Chart 2: Shift Stacked Bar Chart - Simple Vertical Bars -->
    <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow">
        <div class="flex justify-between items-center mb-4 flex-wrap gap-3">
            <div>
                <h2 class="text-xl font-semibold text-zinc-800 dark:text-white">📊 Distribusi Ketidakhadiran per Shift</h2>
                <p class="text-sm text-zinc-500 mt-1">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
            </div>
            <div class="text-sm bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-lg">
                <span class="text-zinc-600 dark:text-zinc-400">Total Ketidakhadiran: <strong>{{ number_format($shiftStackedData['total_absence'] ?? 0) }}</strong></span>
            </div>
        </div>
        
        @if(($shiftStackedData['total_absence'] ?? 0) > 0)
            <div class="overflow-x-auto">
                <div class="flex gap-2 min-w-max" style="min-height: 400px;">
                    @foreach($shiftStackedData['shifts'] as $shift)
                        @php
                            $shiftData = $shiftStackedData['absenceData'][$shift] ?? null;
                            $totalShift = $shiftData['total'] ?? 0;
                            $barHeight = $totalShift > 0 ? ($totalShift / $shiftStackedData['max_absence']) * 300 : 0;
                        @endphp
                        <div class="w-24 flex flex-col items-center">
                            <div class="flex flex-col items-center justify-end h-80 gap-0.5">
                                @if($totalShift > 0)
                                    <!-- Stacked bars from bottom to top -->
                                    @foreach(['CT', 'SD', 'IJ', 'A', 'CK', 'CM'] as $type)
                                        @php
                                            $count = $shiftData[$type] ?? 0;
                                            $typeHeight = $count > 0 ? ($count / $shiftStackedData['max_absence']) * 300 : 0;
                                            $color = $shiftStackedData['absenceColors'][$type] ?? '#9ca3af';
                                        @endphp
                                        @if($count > 0)
                                            <div class="w-14 rounded-t transition-all duration-300 hover:opacity-80 relative group"
                                                style="height: {{ $typeHeight }}px; background-color: {{ $color }};">
                                                <div class="absolute -top-5 left-1/2 transform -translate-x-1/2 text-[10px] font-semibold whitespace-nowrap"
                                                    style="color: {{ $color }};">
                                                    {{ $type }}: {{ $count }}
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            <div class="text-center mt-2">
                                <span class="text-xs font-medium block">{{ $shift }}</span>
                                <span class="text-[10px] text-zinc-500">{{ number_format($totalShift) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Legend -->
            <div class="flex flex-wrap justify-center gap-4 mt-6 pt-4 border-t">
                @foreach($shiftStackedData['absenceColors'] as $type => $color)
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded" style="background-color: {{ $color }};"></div>
                        <span class="text-xs text-zinc-600 dark:text-zinc-400">{{ $type }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10 text-zinc-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p>Tidak ada data ketidakhadiran untuk periode dan department yang dipilih</p>
            </div>
        @endif
    </flux:card>

    <!-- Daily Accumulation Table with Stacked Total Column & Vertical Scroll -->
    <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow overflow-hidden">
        <div class="p-4 border-b bg-gradient-to-r from-zinc-50 to-zinc-100 dark:from-zinc-800/50 dark:to-zinc-800/30">
            <h2 class="text-xl font-semibold text-zinc-800 dark:text-white">📋 Akumulasi Ketidakhadiran per Hari</h2>
            <p class="text-sm text-zinc-500 mt-1">Detail ketidakhadiran berdasarkan tanggal</p>
        </div>
        
        @php $totalRows = count($dailyData); @endphp
        
        <!-- Wrapper with conditional vertical scroll -->
        <div @if($totalRows > 10) class="overflow-y-auto max-h-96" @endif>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-zinc-100 dark:bg-zinc-800/50 sticky top-0">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">Tanggal</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 bg-yellow-50 dark:bg-yellow-900/20">CT</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 bg-orange-50 dark:bg-orange-900/20">SD</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 bg-red-50 dark:bg-red-900/20">IJ</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 bg-purple-50 dark:bg-purple-900/20">A</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 bg-blue-50 dark:bg-blue-900/20">CK</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 bg-green-50 dark:bg-green-900/20">CM</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 bg-gray-100 dark:bg-gray-800">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($dailyData as $row)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-4 py-2 font-medium">{{ $row['display_date'] }}</td>
                            <td class="px-4 py-2 text-center bg-yellow-50/50 dark:bg-yellow-900/10">{{ number_format($row['CT']) }}</td>
                            <td class="px-4 py-2 text-center bg-orange-50/50 dark:bg-orange-900/10">{{ number_format($row['SD']) }}</td>
                            <td class="px-4 py-2 text-center bg-red-50/50 dark:bg-red-900/10">{{ number_format($row['IJ']) }}</td>
                            <td class="px-4 py-2 text-center bg-purple-50/50 dark:bg-purple-900/10">{{ number_format($row['A']) }}</td>
                            <td class="px-4 py-2 text-center bg-blue-50/50 dark:bg-blue-900/10">{{ number_format($row['CK']) }}</td>
                            <td class="px-4 py-2 text-center bg-green-50/50 dark:bg-green-900/10">{{ number_format($row['CM']) }}</td>
                            <td class="px-4 py-2 text-center bg-gray-50 dark:bg-gray-800/50">
                                <div class="flex flex-col items-center gap-1">
                                    <!-- Angka Total -->
                                    <span class="text-sm font-semibold">{{ number_format($row['total']) }}</span>
                                    
                                    <!-- Stacked Bar untuk proporsi -->
                                    @php
                                        $total = $row['total'];
                                        $percentages = [
                                            'CT' => $total > 0 ? ($row['CT'] / $total) * 100 : 0,
                                            'SD' => $total > 0 ? ($row['SD'] / $total) * 100 : 0,
                                            'IJ' => $total > 0 ? ($row['IJ'] / $total) * 100 : 0,
                                            'A' => $total > 0 ? ($row['A'] / $total) * 100 : 0,
                                            'CK' => $total > 0 ? ($row['CK'] / $total) * 100 : 0,
                                            'CM' => $total > 0 ? ($row['CM'] / $total) * 100 : 0,
                                        ];
                                    @endphp
                                    @if($total > 0)
                                    <div class="w-full max-w-[150px] h-2 rounded-full overflow-hidden shadow-inner">
                                        <div class="flex h-full">
                                            <div class="h-full bg-yellow-500 transition-all hover:opacity-80" style="width: {{ $percentages['CT'] }}%" title="CT: {{ $row['CT'] }}"></div>
                                            <div class="h-full bg-orange-500 transition-all hover:opacity-80" style="width: {{ $percentages['SD'] }}%" title="SD: {{ $row['SD'] }}"></div>
                                            <div class="h-full bg-red-500 transition-all hover:opacity-80" style="width: {{ $percentages['IJ'] }}%" title="IJ: {{ $row['IJ'] }}"></div>
                                            <div class="h-full bg-purple-500 transition-all hover:opacity-80" style="width: {{ $percentages['A'] }}%" title="A: {{ $row['A'] }}"></div>
                                            <div class="h-full bg-blue-500 transition-all hover:opacity-80" style="width: {{ $percentages['CK'] }}%" title="CK: {{ $row['CK'] }}"></div>
                                            <div class="h-full bg-green-500 transition-all hover:opacity-80" style="width: {{ $percentages['CM'] }}%" title="CM: {{ $row['CM'] }}"></div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-zinc-500">No data available for the selected period</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-zinc-100 dark:bg-zinc-800/50 font-semibold sticky bottom-0">
                        <tr>
                            <td class="px-4 py-2">Total</td>
                            <td class="px-4 py-2 text-center bg-yellow-100 dark:bg-yellow-900/30">{{ number_format(collect($dailyData)->sum('CT')) }}</td>
                            <td class="px-4 py-2 text-center bg-orange-100 dark:bg-orange-900/30">{{ number_format(collect($dailyData)->sum('SD')) }}</td>
                            <td class="px-4 py-2 text-center bg-red-100 dark:bg-red-900/30">{{ number_format(collect($dailyData)->sum('IJ')) }}</td>
                            <td class="px-4 py-2 text-center bg-purple-100 dark:bg-purple-900/30">{{ number_format(collect($dailyData)->sum('A')) }}</td>
                            <td class="px-4 py-2 text-center bg-blue-100 dark:bg-blue-900/30">{{ number_format(collect($dailyData)->sum('CK')) }}</td>
                            <td class="px-4 py-2 text-center bg-green-100 dark:bg-green-900/30">{{ number_format(collect($dailyData)->sum('CM')) }}</td>
                            <td class="px-4 py-2 text-center font-bold bg-gray-200 dark:bg-gray-700">
                                <div class="flex flex-col items-center gap-1">
                                    <span>{{ number_format(collect($dailyData)->sum('total')) }}</span>
                                    @php
                                        $totalAll = collect($dailyData)->sum('total');
                                        $sumCT = collect($dailyData)->sum('CT');
                                        $sumSD = collect($dailyData)->sum('SD');
                                        $sumIJ = collect($dailyData)->sum('IJ');
                                        $sumA = collect($dailyData)->sum('A');
                                        $sumCK = collect($dailyData)->sum('CK');
                                        $sumCM = collect($dailyData)->sum('CM');
                                        $percentAll = [
                                            'CT' => $totalAll > 0 ? ($sumCT / $totalAll) * 100 : 0,
                                            'SD' => $totalAll > 0 ? ($sumSD / $totalAll) * 100 : 0,
                                            'IJ' => $totalAll > 0 ? ($sumIJ / $totalAll) * 100 : 0,
                                            'A' => $totalAll > 0 ? ($sumA / $totalAll) * 100 : 0,
                                            'CK' => $totalAll > 0 ? ($sumCK / $totalAll) * 100 : 0,
                                            'CM' => $totalAll > 0 ? ($sumCM / $totalAll) * 100 : 0,
                                        ];
                                    @endphp
                                    @if($totalAll > 0)
                                    <div class="w-full max-w-[150px] h-2 rounded-full overflow-hidden shadow-inner">
                                        <div class="flex h-full">
                                            <div class="h-full bg-yellow-500" style="width: {{ $percentAll['CT'] }}%" title="CT: {{ $sumCT }}"></div>
                                            <div class="h-full bg-orange-500" style="width: {{ $percentAll['SD'] }}%" title="SD: {{ $sumSD }}"></div>
                                            <div class="h-full bg-red-500" style="width: {{ $percentAll['IJ'] }}%" title="IJ: {{ $sumIJ }}"></div>
                                            <div class="h-full bg-purple-500" style="width: {{ $percentAll['A'] }}%" title="A: {{ $sumA }}"></div>
                                            <div class="h-full bg-blue-500" style="width: {{ $percentAll['CK'] }}%" title="CK: {{ $sumCK }}"></div>
                                            <div class="h-full bg-green-500" style="width: {{ $percentAll['CM'] }}%" title="CM: {{ $sumCM }}"></div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        @if($totalRows > 10)
            <div class="text-center text-xs text-zinc-400 py-2 border-t">
                Scroll vertikal untuk melihat semua data ({{ $totalRows }} hari)
            </div>
        @endif
    </flux:card>

    <!-- Notification -->
    <div x-data="{ show: false, message: '', type: 'success' }" 
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
         x-show="show" x-transition class="fixed bottom-4 right-4 z-50"
         :class="{'bg-green-500': type === 'success', 'bg-red-500': type === 'error', 'bg-blue-500': type === 'info'}" 
         style="display: none;">
        <div class="text-white px-6 py-3 rounded-lg shadow-lg" x-text="message"></div>
    </div>
</div>