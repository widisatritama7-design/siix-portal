<x-layouts::app :title="__('HR Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-0 sm:gap-4 rounded-xl p-1 sm:p-2 pt-0 sm:pt-0">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white">HR Dashboard</h1>
                    <flux:badge color="blue" size="sm">Human Resource</flux:badge>
                </div>
                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                    Manage and monitor employee performance, attendance, and welfare
                </p>
            </div>
        </div>

        @php
            // Employee Statistics
            $totalEmployees = \App\Models\HR\Employee::count();
            $activeEmployees = \App\Models\HR\Employee::where('status', 'active')->count();
            $onLeaveEmployees = \App\Models\HR\Employee::where('status', 'on_leave')->count();
            $inactiveEmployees = \App\Models\HR\Employee::where('status', 'inactive')->count();
            
            // Comelate (Late attendance)
            $totalComelate = \App\Models\HR\ComelateEmployee::count();
            $todayComelate = \App\Models\HR\ComelateEmployee::whereDate('tanggal', now()->toDateString())->count();
            $thisMonthComelate = \App\Models\HR\ComelateEmployee::whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count();
            $pendingComelate = \App\Models\HR\ComelateEmployee::where('status', 'pending')->count();
            
            // Violations
            $totalViolations = \App\Models\HR\ViolationEmployee::count();
            $todayViolations = \App\Models\HR\ViolationEmployee::whereDate('date', now()->toDateString())->count();
            $thisMonthViolations = \App\Models\HR\ViolationEmployee::whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->count();
            
            // Employee Calls
            $totalCalls = \App\Models\HR\EmployeeCall::count();
            $todayCalls = \App\Models\HR\EmployeeCall::whereDate('date_call', now()->toDateString())->count();
            $thisMonthCalls = \App\Models\HR\EmployeeCall::whereMonth('date_call', now()->month)
                ->whereYear('date_call', now()->year)
                ->count();
            
            // Get selected filters
            $selectedMonth = request()->get('month', now()->format('Y-m'));
            $selectedDate = \Carbon\Carbon::createFromFormat('Y-m', $selectedMonth);
            $selectedYear = request()->get('year', now()->year);
            
            // Weekly Chart Data
            $startOfMonth = $selectedDate->copy()->startOfMonth();
            $endOfMonth = $selectedDate->copy()->endOfMonth();
            
            $weeks = [];
            $weeklyComelate = $weeklyViolations = $weeklyCalls = [];
            $weekStart = $startOfMonth->copy()->startOfWeek();
            if ($weekStart < $startOfMonth) $weekStart = $startOfMonth->copy();
            
            while ($weekStart <= $endOfMonth && count($weeks) < 5) {
                $weekEnd = min($weekStart->copy()->addDays(6), $endOfMonth);
                
                $weekLabel = $weekStart->format('M d') . ' - ' . ($weekStart->format('M') != $weekEnd->format('M') ? $weekEnd->format('M d') : $weekEnd->format('d'));
                
                $weeks[] = $weekLabel;
                $weeklyComelate[] = \App\Models\HR\ComelateEmployee::whereBetween('tanggal', [$weekStart->startOfDay(), $weekEnd->endOfDay()])->count();
                $weeklyViolations[] = \App\Models\HR\ViolationEmployee::whereBetween('date', [$weekStart->startOfDay(), $weekEnd->endOfDay()])->count();
                $weeklyCalls[] = \App\Models\HR\EmployeeCall::whereBetween('date_call', [$weekStart->startOfDay(), $weekEnd->endOfDay()])->count();
                
                $weekStart = $weekStart->copy()->addDays(7);
            }
            
            // Monthly Chart Data (Last 3 Months)
            $months = collect(range(2, 0))->map(fn($i) => now()->subMonths($i)->format('M Y'));
            $monthlyComelate = collect(range(2, 0))->map(fn($i) => \App\Models\HR\ComelateEmployee::whereMonth('tanggal', now()->subMonths($i)->month)->whereYear('tanggal', now()->subMonths($i)->year)->count());
            $monthlyViolations = collect(range(2, 0))->map(fn($i) => \App\Models\HR\ViolationEmployee::whereMonth('date', now()->subMonths($i)->month)->whereYear('date', now()->subMonths($i)->year)->count());
            $monthlyCalls = collect(range(2, 0))->map(fn($i) => \App\Models\HR\EmployeeCall::whereMonth('date_call', now()->subMonths($i)->month)->whereYear('date_call', now()->subMonths($i)->year)->count());
            
            // Yearly Chart Data
            $availableYears = \App\Models\HR\ComelateEmployee::selectRaw('YEAR(tanggal) as year')->union(\App\Models\HR\ViolationEmployee::selectRaw('YEAR(date) as year'))->union(\App\Models\HR\EmployeeCall::selectRaw('YEAR(date_call) as year'))->distinct()->orderBy('year', 'desc')->pluck('year');
            if ($availableYears->isEmpty()) $availableYears = collect([now()->year]);
            if (!$availableYears->contains($selectedYear)) $selectedYear = $availableYears->first();
            
            $yearlyMonths = collect(range(0, 11))->map(fn($i) => \Carbon\Carbon::createFromDate($selectedYear, 1, 1)->addMonths($i)->format('M'));
            $yearlyComelate = collect(range(0, 11))->map(fn($i) => \App\Models\HR\ComelateEmployee::whereMonth('tanggal', $i+1)->whereYear('tanggal', $selectedYear)->count());
            $yearlyViolations = collect(range(0, 11))->map(fn($i) => \App\Models\HR\ViolationEmployee::whereMonth('date', $i+1)->whereYear('date', $selectedYear)->count());
            $yearlyCalls = collect(range(0, 11))->map(fn($i) => \App\Models\HR\EmployeeCall::whereMonth('date_call', $i+1)->whereYear('date_call', $selectedYear)->count());
            
            $maxYearly = max(array_merge($yearlyComelate->toArray(), $yearlyViolations->toArray(), $yearlyCalls->toArray())) ?: 1;
            
            // Department Statistics
            $departmentComelate = \App\Models\HR\ComelateEmployee::select('department', \DB::raw('count(*) as total'))->whereNotNull('department')->groupBy('department')->orderBy('total', 'desc')->limit(10)->get();
            $departmentViolations = \App\Models\HR\ViolationEmployee::select('dept', \DB::raw('count(*) as total'))->whereNotNull('dept')->groupBy('dept')->orderBy('total', 'desc')->limit(10)->get();
            $departmentCalls = \App\Models\HR\EmployeeCall::select('tb_hr_employee_calls.nik', 'tb_hr_employee.department', \DB::raw('count(*) as total'))
                ->join('tb_hr_employee', 'tb_hr_employee_calls.nik', '=', 'tb_hr_employee.id')
                ->whereNotNull('tb_hr_employee.department')
                ->groupBy('tb_hr_employee_calls.nik', 'tb_hr_employee.department')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get();
            $deptCallsGrouped = $departmentCalls->groupBy('department')->map(fn($item) => $item->sum('total'))->sortDesc();
            
            // Top Departments
            $topComelateDept = $departmentComelate->first();
            $topViolationDept = $departmentViolations->first();
            $topCallDept = $deptCallsGrouped->first();
            $topCallDeptName = $deptCallsGrouped->keys()->first();
            
            // All Departments Combined
            $allDepartments = [];
            foreach($departmentComelate as $dept) $allDepartments[$dept->department] = ['comelate' => $dept->total, 'violations' => 0, 'calls' => 0];
            foreach($departmentViolations as $dept) isset($allDepartments[$dept->dept]) ? $allDepartments[$dept->dept]['violations'] = $dept->total : $allDepartments[$dept->dept] = ['comelate' => 0, 'violations' => $dept->total, 'calls' => 0];
            foreach($deptCallsGrouped as $dept => $total) isset($allDepartments[$dept]) ? $allDepartments[$dept]['calls'] = $total : $allDepartments[$dept] = ['comelate' => 0, 'violations' => 0, 'calls' => $total];

            // Sort departments by name ascending (A-Z)
            ksort($allDepartments);
            
            // Top Employees
            $topComelateEmployees = \App\Models\HR\ComelateEmployee::select('tb_hr_comelate_employees.nik as employee_id', 'tb_hr_employee.nik', 'tb_hr_employee.name', 'tb_hr_employee.department', \DB::raw('count(*) as total'), \DB::raw('MAX(tb_hr_comelate_employees.tanggal) as latest_date'))
                ->join('tb_hr_employee', 'tb_hr_comelate_employees.nik', '=', 'tb_hr_employee.id')
                ->groupBy('tb_hr_comelate_employees.nik', 'tb_hr_employee.nik', 'tb_hr_employee.name', 'tb_hr_employee.department')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get();
                
            $topViolationEmployees = \App\Models\HR\ViolationEmployee::select('tb_hr_violation_employees.nik as employee_id', 'tb_hr_employee.nik', 'tb_hr_employee.name', 'tb_hr_employee.department', \DB::raw('count(*) as total'), \DB::raw('MAX(tb_hr_violation_employees.date) as latest_date'))
                ->join('tb_hr_employee', 'tb_hr_violation_employees.nik', '=', 'tb_hr_employee.id')
                ->groupBy('tb_hr_violation_employees.nik', 'tb_hr_employee.nik', 'tb_hr_employee.name', 'tb_hr_employee.department')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get();
                
            $topCallEmployees = \App\Models\HR\EmployeeCall::select('tb_hr_employee_calls.nik as employee_id', 'tb_hr_employee.nik', 'tb_hr_employee.name', 'tb_hr_employee.department', \DB::raw('count(*) as total'), \DB::raw('MAX(tb_hr_employee_calls.date_call) as latest_date'))
                ->join('tb_hr_employee', 'tb_hr_employee_calls.nik', '=', 'tb_hr_employee.id')
                ->groupBy('tb_hr_employee_calls.nik', 'tb_hr_employee.nik', 'tb_hr_employee.name', 'tb_hr_employee.department')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get();
            
            $maxWeekly = max(array_merge($weeklyComelate, $weeklyViolations, $weeklyCalls)) ?: 1;
            $maxMonthly = max(array_merge($monthlyComelate->toArray(), $monthlyViolations->toArray(), $monthlyCalls->toArray())) ?: 1;
            $availableMonths = collect(range(11, 0))->map(fn($i) => ['value' => now()->subMonths($i)->format('Y-m'), 'label' => now()->subMonths($i)->format('F Y')]);
        @endphp

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            <flux:card class="p-4 sm:p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-950/30 dark:to-blue-900/20 border-blue-200 dark:border-blue-800">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-blue-700 dark:text-blue-300">Total Employees</flux:heading>
                        <flux:heading size="xl" class="mt-1 text-blue-800 dark:text-blue-200">{{ $totalEmployees }}</flux:heading>
                    </div>
                    <div class="p-2 sm:p-3 bg-blue-200 dark:bg-blue-800 rounded-lg">
                        <flux:icon name="users" class="w-5 h-5 text-blue-700 dark:text-blue-300" />
                    </div>
                </div>
            </flux:card>
            
            <flux:card class="p-4 sm:p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-950/30 dark:to-yellow-900/20 border-yellow-200 dark:border-yellow-800">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-yellow-700 dark:text-yellow-300">Comelate</flux:heading>
                        <flux:heading size="xl" class="mt-1 text-yellow-800 dark:text-yellow-200">{{ $totalComelate }}</flux:heading>
                    </div>
                    <div class="p-2 sm:p-3 bg-yellow-200 dark:bg-yellow-800 rounded-lg">
                        <flux:icon name="clock" class="w-5 h-5 text-yellow-700 dark:text-yellow-300" />
                    </div>
                </div>
            </flux:card>
            
            <flux:card class="p-4 sm:p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 bg-gradient-to-br from-red-50 to-red-100 dark:from-red-950/30 dark:to-red-900/20 border-red-200 dark:border-red-800">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-red-700 dark:text-red-300">Violations</flux:heading>
                        <flux:heading size="xl" class="mt-1 text-red-800 dark:text-red-200">{{ $totalViolations }}</flux:heading>
                    </div>
                    <div class="p-2 sm:p-3 bg-red-200 dark:bg-red-800 rounded-lg">
                        <flux:icon name="exclamation-triangle" class="w-5 h-5 text-red-700 dark:text-red-300" />
                    </div>
                </div>
            </flux:card>
            
            <flux:card class="p-4 sm:p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-950/30 dark:to-green-900/20 border-green-200 dark:border-green-800">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-green-700 dark:text-green-300">Employee Calls</flux:heading>
                        <flux:heading size="xl" class="mt-1 text-green-800 dark:text-green-200">{{ $totalCalls }}</flux:heading>
                    </div>
                    <div class="p-2 sm:p-3 bg-green-200 dark:bg-green-800 rounded-lg">
                        <flux:icon name="phone" class="w-5 h-5 text-green-700 dark:text-green-300" />
                    </div>
                </div>
            </flux:card>
        </div>

        <!-- Weekly & Monthly Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
            <!-- Weekly Chart -->
            <div class="lg:col-span-8">
                <flux:card class="p-4 sm:p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                        <div><flux:heading size="lg">Weekly Overview</flux:heading><flux:subheading>{{ $selectedDate->format('F Y') }}</flux:subheading></div>
                        <form method="GET" class="flex items-center gap-2">
                            <select name="month" onchange="this.form.submit()" class="text-sm rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                                @foreach($availableMonths as $month)<option value="{{ $month['value'] }}" {{ $selectedMonth == $month['value'] ? 'selected' : '' }}>{{ $month['label'] }}</option>@endforeach
                            </select>
                            @if(request()->has('month') && request()->get('month') != now()->format('Y-m'))<a href="{{ url()->current() }}" class="text-xs text-blue-600">Reset</a>@endif
                        </form>
                    </div>
                    @if(count($weeks) > 0)
                        <div class="space-y-4">
                            <div class="relative">
                                <div class="flex items-end justify-around">
                                    @foreach($weeks as $index => $week)
                                        @php
                                            $cHeight = ($maxWeekly > 0) ? ($weeklyComelate[$index] / $maxWeekly) * 180 : 0;
                                            $vHeight = ($maxWeekly > 0) ? ($weeklyViolations[$index] / $maxWeekly) * 180 : 0;
                                            $caHeight = ($maxWeekly > 0) ? ($weeklyCalls[$index] / $maxWeekly) * 180 : 0;
                                        @endphp
                                        <div class="flex flex-col items-center w-1/{{ count($weeks) }} px-1">
                                            <div class="flex gap-1 items-end h-48 relative">
                                                <!-- Comelate Bar with Label -->
                                                <div class="relative group">
                                                    <div class="w-5 sm:w-6 bg-gradient-to-t from-yellow-500 to-yellow-600 rounded-t transition-all duration-300 hover:opacity-80 hover:scale-105" 
                                                        style="height: {{ $cHeight }}px;">
                                                    </div>
                                                    @if($weeklyComelate[$index] > 0)
                                                        <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-xs font-semibold text-yellow-600 dark:text-yellow-400 whitespace-nowrap">
                                                            {{ $weeklyComelate[$index] }}
                                                        </div>
                                                    @endif
                                                    <span class="text-[10px] text-zinc-500 mt-1 block text-center">C</span>
                                                </div>
                                                <!-- Violation Bar with Label -->
                                                <div class="relative group">
                                                    <div class="w-5 sm:w-6 bg-gradient-to-t from-red-500 to-red-600 rounded-t transition-all duration-300 hover:opacity-80 hover:scale-105" 
                                                        style="height: {{ $vHeight }}px;">
                                                    </div>
                                                    @if($weeklyViolations[$index] > 0)
                                                        <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-xs font-semibold text-red-600 dark:text-red-400 whitespace-nowrap">
                                                            {{ $weeklyViolations[$index] }}
                                                        </div>
                                                    @endif
                                                    <span class="text-[10px] text-zinc-500 mt-1 block text-center">V</span>
                                                </div>
                                                <!-- Calls Bar with Label -->
                                                <div class="relative group">
                                                    <div class="w-5 sm:w-6 bg-gradient-to-t from-green-500 to-green-600 rounded-t transition-all duration-300 hover:opacity-80 hover:scale-105" 
                                                        style="height: {{ $caHeight }}px;">
                                                    </div>
                                                    @if($weeklyCalls[$index] > 0)
                                                        <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-xs font-semibold text-green-600 dark:text-green-400 whitespace-nowrap">
                                                            {{ $weeklyCalls[$index] }}
                                                        </div>
                                                    @endif
                                                    <span class="text-[10px] text-zinc-500 mt-1 block text-center">EC</span>
                                                </div>
                                            </div>
                                            <span class="text-[10px] sm:text-xs text-center mt-2 font-medium">{{ $week }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex flex-wrap justify-center gap-6 pt-4 border-t">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-yellow-500 rounded"></div>
                                    <span class="text-xs text-zinc-600">Comelate</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-red-500 rounded"></div>
                                    <span class="text-xs text-zinc-600">Violations</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-green-500 rounded"></div>
                                    <span class="text-xs text-zinc-600">Employee Calls</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="h-64 flex items-center justify-center">
                            <p class="text-zinc-500">No data available</p>
                        </div>
                    @endif
                </flux:card>
            </div>
            
            <!-- Monthly Chart -->
            <div class="lg:col-span-4">
                <flux:card class="p-4 sm:p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <flux:heading size="lg">Monthly Trend</flux:heading>
                        <div class="flex gap-1">
                            <flux:badge color="yellow">C</flux:badge>
                            <flux:badge color="red">V</flux:badge>
                            <flux:badge color="green">EC</flux:badge>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @foreach($months as $index => $month)
                            @php
                                $cCount = $monthlyComelate[$index]; 
                                $vCount = $monthlyViolations[$index]; 
                                $caCount = $monthlyCalls[$index];
                                $cWidth = ($maxMonthly > 0) ? ($cCount / $maxMonthly) * 100 : 0;
                                $vWidth = ($maxMonthly > 0) ? ($vCount / $maxMonthly) * 100 : 0;
                                $caWidth = ($maxMonthly > 0) ? ($caCount / $maxMonthly) * 100 : 0;
                            @endphp
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $month }}</span>
                                    <div class="flex gap-2">
                                        <span class="text-yellow-600 dark:text-yellow-400 font-semibold">{{ $cCount }}</span>
                                        <span class="text-red-600 dark:text-red-400 font-semibold">{{ $vCount }}</span>
                                        <span class="text-green-600 dark:text-green-400 font-semibold">{{ $caCount }}</span>
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <div class="h-5 bg-zinc-100 dark:bg-zinc-800 rounded-lg overflow-hidden">
                                        <div class="h-full bg-yellow-500 dark:bg-yellow-600 rounded-l-lg transition-all duration-500" style="width: {{ $cWidth }}%"></div>
                                    </div>
                                    <div class="h-5 bg-zinc-100 dark:bg-zinc-800 rounded-lg overflow-hidden">
                                        <div class="h-full bg-red-500 dark:bg-red-600 rounded-l-lg transition-all duration-500" style="width: {{ $vWidth }}%"></div>
                                    </div>
                                    <div class="h-5 bg-zinc-100 dark:bg-zinc-800 rounded-lg overflow-hidden">
                                        <div class="h-full bg-green-500 dark:bg-green-600 rounded-l-lg transition-all duration-500" style="width: {{ $caWidth }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </flux:card>
            </div>
        </div>

        <!-- Top Departments & Yearly Chart -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
            <!-- Top Departments -->
            <div class="lg:col-span-4">
                <flux:card class="p-4 sm:p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center gap-2 mb-4">
                        <flux:icon name="building-office" class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                        <flux:heading size="lg">Top Departments</flux:heading>
                    </div>
                    <flux:subheading class="mb-4">Highest incidents by category</flux:subheading>
                    <div class="space-y-3">
                        @if($topComelateDept)
                            <div class="bg-yellow-50 dark:bg-yellow-950/30 rounded-lg p-3 border border-yellow-200 dark:border-yellow-800 hover:shadow-md transition-shadow duration-200">
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Most Comelate</span>
                                    <flux:badge color="yellow">{{ $topComelateDept->total }}</flux:badge>
                                </div>
                                <div class="font-bold text-yellow-700 dark:text-yellow-400">{{ $topComelateDept->department }}</div>
                            </div>
                        @endif
                        @if($topViolationDept)
                            <div class="bg-red-50 dark:bg-red-950/30 rounded-lg p-3 border border-red-200 dark:border-red-800 hover:shadow-md transition-shadow duration-200">
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Most Violations</span>
                                    <flux:badge color="red">{{ $topViolationDept->total }}</flux:badge>
                                </div>
                                <div class="font-bold text-red-700 dark:text-red-400">{{ $topViolationDept->dept }}</div>
                            </div>
                        @endif
                        @if($topCallDept && $topCallDeptName)
                            <div class="bg-green-50 dark:bg-green-950/30 rounded-lg p-3 border border-green-200 dark:border-green-800 hover:shadow-md transition-shadow duration-200">
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Most Calls</span>
                                    <flux:badge color="green">{{ $topCallDept }}</flux:badge>
                                </div>
                                <div class="font-bold text-green-700 dark:text-green-400">{{ $topCallDeptName }}</div>
                            </div>
                        @endif
                    </div>
                </flux:card>
            </div>
            
            <!-- Yearly Chart -->
            <div class="lg:col-span-8">
                <flux:card class="p-4 sm:p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                        <div><flux:heading size="lg">Yearly Overview</flux:heading><flux:subheading>{{ $selectedYear }} - Monthly breakdown</flux:subheading></div>
                        <div class="flex items-center gap-2">
                            <div class="flex gap-1"><flux:badge color="yellow">C</flux:badge><flux:badge color="red">V</flux:badge><flux:badge color="green">EC</flux:badge></div>
                            <form method="GET" class="flex items-center gap-2">
                                <select name="year" onchange="this.form.submit()" class="text-sm rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                                    @foreach($availableYears as $year)
                                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                                @if(request()->has('month') || request()->has('year'))
                                    <a href="{{ url()->current() }}" class="text-xs text-blue-600 hover:underline">Reset</a>
                                @endif
                            </form>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <div class="flex gap-1 min-w-max" style="min-height: 230px;">
                            @foreach($yearlyMonths as $index => $month)
                                @php
                                    $cCount = $yearlyComelate[$index]; 
                                    $vCount = $yearlyViolations[$index]; 
                                    $caCount = $yearlyCalls[$index];
                                    $cHeight = ($maxYearly > 0) ? ($cCount / $maxYearly) * 130 : 0;
                                    $vHeight = ($maxYearly > 0) ? ($vCount / $maxYearly) * 130 : 0;
                                    $caHeight = ($maxYearly > 0) ? ($caCount / $maxYearly) * 130 : 0;
                                @endphp
                                <div class="w-12 flex flex-col items-center">
                                    <div class="flex flex-col items-center justify-end h-40 gap-1">
                                        <!-- Calls Bar -->
                                        @if($caCount > 0)
                                            <div class="w-5 bg-gradient-to-t from-green-500 to-green-600 rounded-t transition-all duration-300 hover:opacity-80" 
                                                style="height: {{ $caHeight }}px;">
                                            </div>
                                        @endif
                                        <!-- Violation Bar -->
                                        @if($vCount > 0)
                                            <div class="w-5 bg-gradient-to-t from-red-500 to-red-600 rounded-t transition-all duration-300 hover:opacity-80" 
                                                style="height: {{ $vHeight }}px;">
                                            </div>
                                        @endif
                                        <!-- Comelate Bar -->
                                        @if($cCount > 0)
                                            <div class="w-5 bg-gradient-to-t from-yellow-500 to-yellow-600 rounded-t transition-all duration-300 hover:opacity-80" 
                                                style="height: {{ $cHeight }}px;">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-center mt-1">
                                        <span class="text-xs font-medium block">{{ $month }}</span>
                                        <div class="flex flex-col items-center gap-0.5 mt-0.5">
                                            @if($cCount > 0)
                                                <span class="text-[10px] font-semibold text-yellow-600">{{ $cCount }}</span>
                                            @endif
                                            @if($vCount > 0)
                                                <span class="text-[10px] font-semibold text-red-600">{{ $vCount }}</span>
                                            @endif
                                            @if($caCount > 0)
                                                <span class="text-[10px] font-semibold text-green-600">{{ $caCount }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4 mt-3 pt-3 border-t">
                        <div class="flex items-center gap-2"><div class="w-3 h-3 bg-yellow-500 rounded"></div><span class="text-xs">Comelate</span></div>
                        <div class="flex items-center gap-2"><div class="w-3 h-3 bg-red-500 rounded"></div><span class="text-xs">Violations</span></div>
                        <div class="flex items-center gap-2"><div class="w-3 h-3 bg-green-500 rounded"></div><span class="text-xs">Employee Calls</span></div>
                    </div>
                </flux:card>
            </div>
        </div>

        <!-- All Departments -->
        <flux:card class="p-4 sm:p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex flex-wrap justify-between items-center gap-3 mb-4">
                <div class="flex items-center gap-2">
                    <flux:icon name="chart-pie" class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                    <flux:heading size="lg">All Departments</flux:heading>
                </div>
                <div class="flex gap-3 text-xs">
                    <div class="flex items-center gap-1"><div class="w-3 h-3 bg-yellow-500 rounded"></div><span class="dark:text-zinc-300">Comelate</span></div>
                    <div class="flex items-center gap-1"><div class="w-3 h-3 bg-red-500 rounded"></div><span class="dark:text-zinc-300">Violations</span></div>
                    <div class="flex items-center gap-1"><div class="w-3 h-3 bg-green-500 rounded"></div><span class="dark:text-zinc-300">Calls</span></div>
                </div>
            </div>
            
            <div class="space-y-3">
                @forelse($allDepartments as $deptName => $data)
                    @php 
                        $total = $data['comelate'] + $data['violations'] + $data['calls']; 
                        if($total == 0) continue;
                        
                        $comelatePercent = ($data['comelate'] / $total) * 100;
                        $violationPercent = ($data['violations'] / $total) * 100;
                        $callsPercent = ($data['calls'] / $total) * 100;
                    @endphp
                    <div class="flex items-center gap-3">
                        <!-- Department Name on Left - Wider to prevent truncation -->
                        <div class="w-48 sm:w-64 flex-shrink-0">
                            <div class="font-medium text-sm text-zinc-800 dark:text-zinc-200 break-words">
                                {{ $deptName }}
                            </div>
                            <div class="text-xs text-zinc-500">{{ $total }} total</div>
                        </div>
                        
                        <!-- Legend in Middle - Fixed width to keep bar alignment -->
                        <div class="w-24 flex-shrink-0">
                            <div class="flex gap-1 whitespace-nowrap">
                                @if($data['comelate'] > 0)
                                    <flux:badge color="yellow" size="sm" class="!px-2 !py-0.5">
                                        {{ $data['comelate'] }}
                                    </flux:badge>
                                @endif
                                @if($data['violations'] > 0)
                                    <flux:badge color="red" size="sm" class="!px-2 !py-0.5">
                                        {{ $data['violations'] }}
                                    </flux:badge>
                                @endif
                                @if($data['calls'] > 0)
                                    <flux:badge color="green" size="sm" class="!px-2 !py-0.5">
                                        {{ $data['calls'] }}
                                    </flux:badge>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Bar Chart on Right - Full width to the edge -->
                        <div class="flex-1">
                            <div class="flex h-6 rounded-md overflow-hidden shadow-sm">
                                @if($data['comelate'] > 0)
                                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 flex items-center justify-center text-[10px] text-white font-medium transition-all duration-300 hover:opacity-90" 
                                        style="width: {{ $comelatePercent }}%"
                                        title="Comelate: {{ $data['comelate'] }}">
                                        @if($comelatePercent > 15)
                                            <span class="truncate">{{ $data['comelate'] }}</span>
                                        @endif
                                    </div>
                                @endif
                                @if($data['violations'] > 0)
                                    <div class="bg-gradient-to-r from-red-500 to-red-600 flex items-center justify-center text-[10px] text-white font-medium transition-all duration-300 hover:opacity-90" 
                                        style="width: {{ $violationPercent }}%"
                                        title="Violations: {{ $data['violations'] }}">
                                        @if($violationPercent > 15)
                                            <span class="truncate">{{ $data['violations'] }}</span>
                                        @endif
                                    </div>
                                @endif
                                @if($data['calls'] > 0)
                                    <div class="bg-gradient-to-r from-green-500 to-green-600 flex items-center justify-center text-[10px] text-white font-medium transition-all duration-300 hover:opacity-90" 
                                        style="width: {{ $callsPercent }}%"
                                        title="Calls: {{ $data['calls'] }}">
                                        @if($callsPercent > 15)
                                            <span class="truncate">{{ $data['calls'] }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-zinc-500 dark:text-zinc-400">No department data available</div>
                @endforelse
            </div>
        </flux:card>

        <!-- Top Employees Tables -->
        <div class="space-y-4">
            <!-- Top Comelate -->
            <flux:card class="overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-4 border-b bg-yellow-50 dark:bg-yellow-950/30 border-yellow-200 dark:border-yellow-800">
                    <div class="flex items-center gap-2">
                        <flux:icon name="trophy" class="w-5 h-5 text-yellow-600 dark:text-yellow-400" />
                        <flux:heading size="lg">Top Comelate Employees</flux:heading>
                    </div>
                    <flux:subheading>Most frequent late arrivals</flux:subheading>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NIK</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Department</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Count</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Latest Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($topComelateEmployees as $index => $emp)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                    <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">{{ $index+1 }}</td>
                                    <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $emp->nik }}</td>
                                    <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $emp->name }}</td>
                                    <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $emp->department }}</td>
                                    <td class="px-4 py-3 text-center"><flux:badge color="yellow">{{ $emp->total }}</flux:badge></td>
                                    <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $emp->latest_date ? \Carbon\Carbon::parse($emp->latest_date)->format('d M Y') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </flux:card>
            
            <!-- Top Violation -->
            <flux:card class="overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-4 border-b bg-red-50 dark:bg-red-950/30 border-red-200 dark:border-red-800">
                    <div class="flex items-center gap-2">
                        <flux:icon name="exclamation-triangle" class="w-5 h-5 text-red-600 dark:text-red-400" />
                        <flux:heading size="lg">Top Violation Employees</flux:heading>
                    </div>
                    <flux:subheading>Most frequent violations</flux:subheading>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NIK</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Department</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Count</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Latest Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($topViolationEmployees as $index => $emp)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                    <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">{{ $index+1 }}</td>
                                    <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $emp->nik }}</td>
                                    <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $emp->name }}</td>
                                    <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $emp->department }}</td>
                                    <td class="px-4 py-3 text-center"><flux:badge color="red">{{ $emp->total }}</flux:badge></td>
                                    <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $emp->latest_date ? \Carbon\Carbon::parse($emp->latest_date)->format('d M Y') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </flux:card>
            
            <!-- Top Calls -->
            <flux:card class="overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-4 border-b bg-green-50 dark:bg-green-950/30 border-green-200 dark:border-green-800">
                    <div class="flex items-center gap-2">
                        <flux:icon name="phone" class="w-5 h-5 text-green-600 dark:text-green-400" />
                        <flux:heading size="lg">Top Call Employees</flux:heading>
                    </div>
                    <flux:subheading>Most frequent callers</flux:subheading>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NIK</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Department</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Count</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Latest Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($topCallEmployees as $index => $call)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                    <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">{{ $index+1 }}</td>
                                    <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $call->nik }}</td>
                                    <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $call->name }}</td>
                                    <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $call->department }}</td>
                                    <td class="px-4 py-3 text-center"><flux:badge color="green">{{ $call->total }}</flux:badge></td>
                                    <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $call->latest_date ? \Carbon\Carbon::parse($call->latest_date)->format('d M Y') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </flux:card>
        </div>
    </div>
</x-layouts::app>