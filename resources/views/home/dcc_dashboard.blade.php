<x-layouts::app :title="__('DCC Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-1 sm:gap-2 rounded-xl p-1 sm:p-2">
        <!-- Header dengan Welcome Back -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-2">
            <div class="w-full lg:w-auto">
                <div class="flex items-center gap-3">
                    <h1 class="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white">DCC Dashboard</h1>
                    <flux:badge color="blue" size="sm">Document Control</flux:badge>
                </div>
                <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-400 mt-1">
                    Manage and monitoring your document
                </p>
            </div>
        </div>

        <!-- Stats Cards dengan FluxUI -->
        @php
            $totalSubmissions = \App\Models\DCC\Submission::count();
            $waitingSubmissions = \App\Models\DCC\Submission::where('status', 'Waiting Received')->count();
            $completedSubmissions = \App\Models\DCC\Submission::where('status_distribute', 'Distributed')->count();
            $overdueSubmissions = \App\Models\DCC\Submission::where('due_date', '<', now())
                ->where('status', 'Waiting Received')
                ->count();
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-2">
            <!-- Total Card -->
            <flux:card class="p-6 bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-blue-700 dark:text-blue-300">Total Submissions</flux:heading>
                        <flux:heading size="xl" class="mt-1 text-blue-800 dark:text-blue-200">{{ $totalSubmissions }}</flux:heading>
                    </div>
                    <div class="p-3 bg-blue-200 dark:bg-blue-800 rounded-lg">
                        <flux:icon name="document-text" class="w-5 h-5 text-blue-700 dark:text-blue-200" />
                    </div>
                </div>
            </flux:card>

            <!-- Waiting Card -->
            <flux:card class="p-6 bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-yellow-700 dark:text-yellow-300">Waiting</flux:heading>
                        <flux:heading size="xl" class="mt-1 text-yellow-800 dark:text-yellow-200">{{ $waitingSubmissions }}</flux:heading>
                    </div>
                    <div class="p-3 bg-yellow-200 dark:bg-yellow-800 rounded-lg">
                        <flux:icon name="clock" class="w-5 h-5 text-yellow-700 dark:text-yellow-200" />
                    </div>
                </div>
            </flux:card>

            <!-- Completed Card -->
            <flux:card class="p-6 bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-green-700 dark:text-green-300">Completed</flux:heading>
                        <flux:heading size="xl" class="mt-1 text-green-800 dark:text-green-200">{{ $completedSubmissions }}</flux:heading>
                    </div>
                    <div class="p-3 bg-green-200 dark:bg-green-800 rounded-lg">
                        <flux:icon name="check-circle" class="w-5 h-5 text-green-700 dark:text-green-200" />
                    </div>
                </div>
            </flux:card>

            <!-- Overdue Card -->
            <flux:card class="p-6 bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-red-700 dark:text-red-300">Overdue</flux:heading>
                        <flux:heading size="xl" class="mt-1 text-red-800 dark:text-red-200">{{ $overdueSubmissions }}</flux:heading>
                    </div>
                    <div class="p-3 bg-red-200 dark:bg-red-800 rounded-lg">
                        <flux:icon name="exclamation-triangle" class="w-5 h-5 text-red-700 dark:text-red-200" />
                    </div>
                </div>
            </flux:card>
        </div>

        <!-- Charts Section: Bar Chart Weekly 70% (Left) and Year Chart Vertical 30% (Right) -->
        @php
            // Data untuk chart weekly in this month (BAR CHART)
            $now = now();
            $startOfMonth = $now->copy()->startOfMonth();
            $endOfMonth = $now->copy()->endOfMonth();
            
            // Get weeks in current month
            $weeks = [];
            $weekData = [];
            
            // Loop through each week of the month
            $weekStart = $startOfMonth->copy()->startOfWeek();
            
            // If week starts before month, use month start
            if ($weekStart < $startOfMonth) {
                $weekStart = $startOfMonth->copy();
            }
            
            while ($weekStart <= $endOfMonth) {
                // Calculate week end (7 days from week start or end of month)
                $weekEnd = $weekStart->copy()->addDays(6);
                
                // If week end goes beyond month end, use month end
                if ($weekEnd > $endOfMonth) {
                    $weekEnd = $endOfMonth->copy();
                }
                
                // Create week label
                if ($weekStart->format('M') != $weekEnd->format('M')) {
                    $weekLabel = $weekStart->format('M d') . ' - ' . $weekEnd->format('M d');
                } else {
                    $weekLabel = $weekStart->format('M d') . ' - ' . $weekEnd->format('d');
                }
                
                // Count submissions in this week
                $count = \App\Models\DCC\Submission::whereBetween('created_at', [
                    $weekStart->startOfDay(), 
                    $weekEnd->endOfDay()
                ])->count();
                
                $weeks[] = $weekLabel;
                $weekData[] = $count;
                
                // Move to next week
                $weekStart = $weekStart->copy()->addDays(7);
                
                // Safety break to prevent infinite loop (max 5 weeks in a month)
                if (count($weeks) >= 5) break;
            }

            // Data untuk chart tahunan (vertical bars)
            $years = collect(range(now()->year - 3, now()->year));
            $yearlyData = $years->map(function($year) {
                return \App\Models\DCC\Submission::whereYear('created_at', $year)->count();
            });
            
            $maxWeeklyData = !empty($weekData) ? max($weekData) : 1;
            $maxYearlyData = !empty($yearlyData) ? max($yearlyData->toArray()) : 1;
        @endphp

        <div class="flex flex-col lg:flex-row gap-4 mt-4">
            <!-- Bar Chart Weekly - 70% width -->
            <div class="w-full lg:w-[70%]">
                <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <flux:heading size="lg">Weekly Submissions</flux:heading>
                            <flux:subheading>{{ now()->format('F Y') }} - Weekly statistics</flux:subheading>
                        </div>
                    </div>
                    
                    <!-- Bar Chart Visualization - tanpa garis grid -->
                    <div class="h-52 relative">
                        <!-- Container bars dengan margin merata -->
                        <div class="absolute inset-0 flex items-end justify-around mx-4">
                            @foreach($weekData as $index => $count)
                                @php
                                    $height = ($maxWeeklyData > 0) ? ($count / $maxWeeklyData) * 100 : 0;
                                    $barHeight = max($height, 5); // Minimal 5% untuk visibility
                                @endphp
                                <div class="flex flex-col items-center w-1/{{ count($weekData) }} relative group px-2">
                                    <!-- Label count di atas bar - warna hitam -->
                                    <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-xs font-medium text-zinc-700 dark:text-zinc-300">
                                        {{ $count }}
                                    </div>
                                    
                                    <!-- Bar -->
                                    <div class="w-full bg-gradient-to-t from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 rounded-t-lg transition-all duration-300"
                                        style="height: {{ $barHeight }}px;">
                                    </div>
                                    
                                    <!-- Week label -->
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400 mt-2 text-center">
                                        {{ $weeks[$index] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Legend -->
                    <div class="flex items-center justify-start gap-4 mt-8 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-blue-500 dark:bg-blue-600 rounded"></div>
                            <span class="text-xs text-zinc-600 dark:text-zinc-400">Weekly Submission Count</span>
                        </div>
                    </div>
                </flux:card>
            </div>

            <!-- Year Chart Vertical Bar - 30% width -->
            <div class="w-full lg:w-[30%]">
                <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <flux:heading size="lg">Yearly</flux:heading>
                            <flux:subheading>Last 4 years</flux:subheading>
                        </div>
                    </div>
                    
                    <!-- Vertical Bar Chart - dengan count di samping tahun -->
                    <div class="h-64 flex flex-col justify-between gap-4">
                        @foreach($yearlyData as $index => $count)
                            @php
                                $barWidth = ($maxYearlyData > 0) ? ($count / $maxYearlyData) * 100 : 0;
                            @endphp
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $years[$index] }}</span>
                                        <span class="text-xs font-semibold text-blue-600 dark:text-blue-400 bg-purple-50 dark:bg-purple-900/30 px-2 py-0.5 rounded-full">
                                            {{ $count }}
                                        </span>
                                    </div>
                                </div>
                                <div class="relative w-full h-8 bg-zinc-100 dark:bg-zinc-800 rounded-lg overflow-hidden">
                                    <!-- Bar -->
                                    <div class="absolute left-0 top-0 h-full bg-gradient-to-r from-purple-500 to-purple-600 dark:from-purple-600 dark:to-purple-700 rounded-lg transition-all duration-500"
                                        style="width: {{ $barWidth }}%;">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Legend -->
                    <div class="flex items-center justify-start gap-4 mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-purple-500 dark:bg-purple-600 rounded"></div>
                            <span class="text-xs text-zinc-600 dark:text-zinc-400">Yearly Total</span>
                        </div>
                    </div>
                </flux:card>
            </div>
        </div>

        <!-- Recent Submissions Section (Full Width) -->
        <div class="mt-4">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <flux:heading size="lg">Recent Submissions</flux:heading>
                    <flux:badge color="blue" size="sm">Latest 5</flux:badge>
                </div>
                <flux:button href="{{ route('dcc.submissions') }}" variant="ghost" size="sm" icon="arrow-right" icon-trailing>
                    View All
                </flux:button>
            </div>

            @php
                $recentSubmissions = \App\Models\DCC\Submission::with('department')
                    ->latest()
                    ->limit(5)
                    ->get();
            @endphp

            <flux:card class="overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Description</flux:table.column>
                        <flux:table.column>Department</flux:table.column>
                        <flux:table.column>Status</flux:table.column>
                        <flux:table.column>Due Date</flux:table.column>
                        <flux:table.column>Created</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @forelse($recentSubmissions as $submission)
                            <flux:table.row>
                                <flux:table.cell>
                                    <div>
                                        <div class="font-medium">{{ $submission->description }}</div>
                                        <div class="text-xs text-zinc-500">Rev: {{ $submission->revision }}</div>
                                    </div>
                                </flux:table.cell>
                                <flux:table.cell>{{ $submission->department->dept_name ?? 'N/A' }}</flux:table.cell>
                                <flux:table.cell>
                                    <div class="flex gap-1">
                                        <flux:badge 
                                            color="{{ $submission->status === 'Waiting Received' ? 'yellow' : ($submission->status === 'Received' ? 'blue' : ($submission->status === 'Completed' ? 'green' : 'red')) }}"
                                            size="sm"
                                        >
                                            {{ $submission->status }}
                                        </flux:badge>
                                        @if($submission->status_distribute === 'Distributed')
                                            <flux:badge color="purple" size="sm">Distributed</flux:badge>
                                        @endif
                                    </div>
                                </flux:table.cell>
                                <flux:table.cell>
                                    @if($submission->due_date)
                                        <span class="{{ $submission->due_date->isPast() && $submission->status === 'Waiting Received' ? 'text-red-600 dark:text-red-400 font-medium' : '' }}">
                                            {{ $submission->due_date->format('d M Y') }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </flux:table.cell>
                                <flux:table.cell>
                                    <span class="text-sm">{{ $submission->created_at->format('d M Y') }}</span>
                                    <span class="text-xs text-zinc-500 block">{{ $submission->created_at->diffForHumans() }}</span>
                                </flux:table.cell>
                            </flux:table.row>
                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="6" class="text-center py-12">
                                    <div class="flex flex-col items-center gap-3">
                                        <flux:icon name="document-text" class="w-12 h-12 text-zinc-400" />
                                        <flux:heading size="lg" class="text-zinc-400">No submissions yet</flux:heading>
                                        <flux:subheading>Get started by creating a new submission</flux:subheading>
                                        @can('create submissions')
                                            <flux:button wire:click="goToCreate" size="sm" variant="primary" class="mt-2">
                                                Create Your First Submission
                                            </flux:button>
                                        @endcan
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </flux:card>
        </div>
    </div>
</x-layouts::app>