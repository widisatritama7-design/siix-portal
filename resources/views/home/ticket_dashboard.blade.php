<?php
// Di bagian atas blade, sebelum stats cards
$user = auth()->user();
$hasViewOneUser = $user->can('view tickets one user');

// Base query untuk tickets dengan filter
$ticketQuery = \App\Models\Ticket\Ticket::query();

if ($hasViewOneUser) {
    $ticketQuery->where('created_by', $user->id);
}

// Stats Cards by Status
$totalTickets = (clone $ticketQuery)->count();
$openTickets = (clone $ticketQuery)->where('status', 'Open')->count();
$inProgressTickets = (clone $ticketQuery)->where('status', 'In Progress')->count();
$pendingTickets = (clone $ticketQuery)->where('status', 'Pending')->count();
$closedTickets = (clone $ticketQuery)->where('status', 'Closed')->count();

// Monthly Chart - Status Summary by Month with Priority Breakdown
// Get available years from tickets (with filter)
$availableYears = (clone $ticketQuery)
    ->selectRaw('YEAR(created_at) as year')
    ->distinct()
    ->orderBy('year', 'desc')
    ->pluck('year')
    ->toArray();

// If no tickets exist, use current year
if (empty($availableYears)) {
    $availableYears = [now()->year];
}

// Get selected year from request or default to current year
$selectedYear = request()->get('year', now()->year);

// Ensure selected year is in available years
if (!in_array($selectedYear, $availableYears)) {
    $selectedYear = $availableYears[0] ?? now()->year;
}

$months = [];
$priorityData = [
    'Low' => [],
    'Medium' => [],
    'Urgent' => [],
    'Critical' => []
];

$priorityColors = [
    'Low' => 'bg-green-500',
    'Medium' => 'bg-yellow-500',
    'Urgent' => 'bg-orange-500',
    'Critical' => 'bg-red-500'
];

$priorityLabels = [
    'Low' => 'L',
    'Medium' => 'M',
    'Urgent' => 'U',
    'Critical' => 'C'
];

// Get data for each month of selected year (with filter)
for ($month = 1; $month <= 12; $month++) {
    $monthName = Carbon\Carbon::create($selectedYear, $month, 1)->format('M');
    $months[] = $monthName;
    
    // Get priority breakdown for this month with filter
    foreach ($priorityData as $priority => &$data) {
        $countQuery = (clone $ticketQuery)
            ->whereYear('created_at', $selectedYear)
            ->whereMonth('created_at', $month)
            ->where('priority', $priority);
        
        $count = $countQuery->count();
        $data[] = $count;
    }
}

// Find maximum total per month for scaling
$monthlyTotals = [];
foreach ($months as $index => $month) {
    $total = 0;
    foreach ($priorityData as $priority => $data) {
        $total += $data[$index] ?? 0;
    }
    $monthlyTotals[] = $total;
}
$maxTotal = !empty($monthlyTotals) ? max($monthlyTotals) : 1;
$totalYearlyTickets = array_sum($monthlyTotals);

// Latest 5 Tickets Section (with filter)
$latestTickets = (clone $ticketQuery)
    ->with(['category', 'creator'])
    ->latest()
    ->limit(5)
    ->get();
?>

<x-layouts::app :title="__('Ticket Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-0 sm:gap-1 rounded-xl p-1 sm:p-2 pt-0 sm:pt-0">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-2">
            <div class="w-full lg:w-auto">
                <div class="flex items-center gap-3">
                    <h1 class="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white">Ticket Dashboard</h1>
                    <flux:badge color="blue" size="sm">Ticketing Support</flux:badge>
                    @if($hasViewOneUser)
                        <flux:badge color="purple" size="sm">My Tickets Only</flux:badge>
                    @endif
                </div>
                <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-400 mt-1">
                    Manage and monitor your tickets
                </p>
            </div>
        </div>

        <!-- Stats Cards by Status -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mt-2">
            <!-- Total Card -->
            <flux:card class="p-6 bg-gray-50 dark:bg-gray-900/20 border-gray-200 dark:border-gray-800 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-gray-700 dark:text-gray-300">Total Tickets</flux:heading>
                        <flux:heading size="xl" class="mt-1 text-gray-800 dark:text-gray-200">{{ $totalTickets }}</flux:heading>
                    </div>
                    <div class="p-3 bg-gray-200 dark:bg-gray-800 rounded-lg">
                        <flux:icon name="ticket" class="w-5 h-5 text-gray-700 dark:text-gray-200" />
                    </div>
                </div>
            </flux:card>

            <!-- Open Card - Red -->
            <flux:card class="p-6 bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-red-700 dark:text-red-300">Open</flux:heading>
                        <flux:heading size="xl" class="mt-1 text-red-800 dark:text-red-200">{{ $openTickets }}</flux:heading>
                    </div>
                    <div class="p-3 bg-red-200 dark:bg-red-800 rounded-lg">
                        <flux:icon name="folder-open" class="w-5 h-5 text-red-700 dark:text-red-200" />
                    </div>
                </div>
            </flux:card>

            <!-- In Progress Card -->
            <flux:card class="p-6 bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-yellow-700 dark:text-yellow-300">In Progress</flux:heading>
                        <flux:heading size="xl" class="mt-1 text-yellow-800 dark:text-yellow-200">{{ $inProgressTickets }}</flux:heading>
                    </div>
                    <div class="p-3 bg-yellow-200 dark:bg-yellow-800 rounded-lg">
                        <flux:icon name="arrow-path" class="w-5 h-5 text-yellow-700 dark:text-yellow-200" />
                    </div>
                </div>
            </flux:card>

            <!-- Pending Card - Blue -->
            <flux:card class="p-6 bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-blue-700 dark:text-blue-300">Pending</flux:heading>
                        <flux:heading size="xl" class="mt-1 text-blue-800 dark:text-blue-200">{{ $pendingTickets }}</flux:heading>
                    </div>
                    <div class="p-3 bg-blue-200 dark:bg-blue-800 rounded-lg">
                        <flux:icon name="clock" class="w-5 h-5 text-blue-700 dark:text-blue-200" />
                    </div>
                </div>
            </flux:card>

            <!-- Closed Card - Green -->
            <flux:card class="p-6 bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="sm" class="text-green-700 dark:text-green-300">Closed</flux:heading>
                        <flux:heading size="xl" class="mt-1 text-green-800 dark:text-green-200">{{ $closedTickets }}</flux:heading>
                    </div>
                    <div class="p-3 bg-green-200 dark:bg-green-800 rounded-lg">
                        <flux:icon name="check-circle" class="w-5 h-5 text-green-700 dark:text-green-200" />
                    </div>
                </div>
            </flux:card>
        </div>

        <!-- Monthly Chart - Status Summary by Month with Priority Breakdown -->
        <div class="mt-4">
            <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <flux:heading size="lg">Monthly Ticket Summary</flux:heading>
                        @if($hasViewOneUser)
                            <p class="text-xs text-purple-600 dark:text-purple-400 mt-1">Showing only tickets created by you</p>
                        @endif
                    </div>
                    <div class="relative">
                        <select 
                            id="yearFilter" 
                            class="appearance-none block w-32 px-3 py-2 pr-8 text-sm font-medium border border-zinc-300 dark:border-zinc-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors duration-200"
                            onchange="window.location.href=this.value"
                        >
                            @foreach($availableYears as $year)
                                <option value="{{ request()->fullUrlWithQuery(['year' => $year]) }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                        
                        <!-- Custom dropdown icon -->
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Stacked Bar Chart with Rounded Bars and Gaps -->
                <div class="overflow-x-auto">
                    <div class="min-w-[900px]">
                        <div class="h-60 relative">
                            <div class="absolute inset-0 flex items-end justify-around">
                                @foreach($months as $index => $month)
                                    @php
                                        $lowCount = $priorityData['Low'][$index] ?? 0;
                                        $mediumCount = $priorityData['Medium'][$index] ?? 0;
                                        $urgentCount = $priorityData['Urgent'][$index] ?? 0;
                                        $criticalCount = $priorityData['Critical'][$index] ?? 0;
                                        $totalMonth = $lowCount + $mediumCount + $urgentCount + $criticalCount;
                                        
                                        $totalHeight = ($maxTotal > 0) ? ($totalMonth / $maxTotal) * 160 : 0;
                                        $barHeight = max($totalHeight, 4);
                                        
                                        // Calculate heights for each priority segment with gaps
                                        $gap = 2; // 2px gap between segments
                                        $lowHeight = $totalMonth > 0 ? ($lowCount / $totalMonth) * ($barHeight - (3 * $gap)) : 0;
                                        $mediumHeight = $totalMonth > 0 ? ($mediumCount / $totalMonth) * ($barHeight - (3 * $gap)) : 0;
                                        $urgentHeight = $totalMonth > 0 ? ($urgentCount / $totalMonth) * ($barHeight - (3 * $gap)) : 0;
                                        $criticalHeight = $totalMonth > 0 ? ($criticalCount / $totalMonth) * ($barHeight - (3 * $gap)) : 0;
                                        
                                        // Calculate cumulative positions
                                        $lowPosition = 0;
                                        $mediumPosition = $lowHeight + $gap;
                                        $urgentPosition = $lowHeight + $mediumHeight + ($gap * 2);
                                        $criticalPosition = $lowHeight + $mediumHeight + $urgentHeight + ($gap * 3);
                                        
                                        // Adjust to reduce top gap - add a small offset if needed
                                        // This ensures the top bar doesn't have extra space above it
                                        $topOffset = 0; // Set to negative value like -2 to move bars upward
                                    @endphp
                                    
                                    <div class="flex flex-col items-center group" style="width: 80px;">
                                        <!-- Stacked Bar Container with Rounded Bars -->
                                        <div class="relative mb-1" style="height: {{ $barHeight }}px; width: 36px;">
                                            <!-- Critical (top) - Rounded Top -->
                                            @if($criticalHeight > 0)
                                                <div class="absolute w-full {{ $priorityColors['Critical'] }} transition-all duration-300 shadow-sm"
                                                    style="height: {{ $criticalHeight }}px; bottom: {{ $criticalPosition + $topOffset }}px; border-radius: 8px 8px 4px 4px;">
                                                </div>
                                            @endif
                                            
                                            <!-- Urgent -->
                                            @if($urgentHeight > 0)
                                                <div class="absolute w-full {{ $priorityColors['Urgent'] }} transition-all duration-300 shadow-sm"
                                                    style="height: {{ $urgentHeight }}px; bottom: {{ $urgentPosition + $topOffset }}px; border-radius: 4px;">
                                                </div>
                                            @endif
                                            
                                            <!-- Medium -->
                                            @if($mediumHeight > 0)
                                                <div class="absolute w-full {{ $priorityColors['Medium'] }} transition-all duration-300 shadow-sm"
                                                    style="height: {{ $mediumHeight }}px; bottom: {{ $mediumPosition + $topOffset }}px; border-radius: 4px;">
                                                </div>
                                            @endif
                                            
                                            <!-- Low (bottom) - Rounded Bottom -->
                                            @if($lowHeight > 0)
                                                <div class="absolute w-full {{ $priorityColors['Low'] }} transition-all duration-300 shadow-sm"
                                                    style="height: {{ $lowHeight }}px; bottom: {{ $lowPosition + $topOffset }}px; border-radius: 4px 4px 8px 8px;">
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Month Label -->
                                        <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300 mb-1">
                                            {{ $month }}
                                        </span>
                                        
                                        <!-- Priority Labels with Counts - Horizontal Layout -->
                                        <div class="flex items-center gap-1 text-[10px]">
                                            @if($lowCount > 0)
                                                <div class="flex items-center gap-1">
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-white font-medium text-[10px] bg-green-600 dark:bg-green-500">{{ $lowCount }}</span>
                                                </div>
                                            @endif
                                            @if($mediumCount > 0)
                                                <div class="flex items-center gap-1">
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-white font-medium text-[10px] bg-yellow-500 dark:bg-yellow-500">{{ $mediumCount }}</span>
                                                </div>
                                            @endif
                                            @if($urgentCount > 0)
                                                <div class="flex items-center gap-1">
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-white font-medium text-[10px] bg-orange-500 dark:bg-orange-500">{{ $urgentCount }}</span>
                                                </div>
                                            @endif
                                            @if($criticalCount > 0)
                                                <div class="flex items-center gap-1">
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-white font-medium text-[10px] bg-red-600 dark:bg-red-500">{{ $criticalCount }}</span>
                                                </div>
                                            @endif
                                            @if($totalMonth == 0)
                                                <span class="text-zinc-400">-</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Legend -->
                <div class="flex flex-wrap items-center justify-center gap-6 mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-green-500 rounded"></div>
                        <span class="text-xs text-zinc-600 dark:text-zinc-400">Low Priority</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-yellow-500 rounded"></div>
                        <span class="text-xs text-zinc-600 dark:text-zinc-400">Medium Priority</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-orange-500 rounded"></div>
                        <span class="text-xs text-zinc-600 dark:text-zinc-400">Urgent Priority</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 bg-red-500 rounded"></div>
                        <span class="text-xs text-zinc-600 dark:text-zinc-400">Critical Priority</span>
                    </div>
                </div>
            </flux:card>
        </div>

        <!-- Latest 5 Tickets Section -->
        <div class="mt-4">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <flux:heading size="lg">Latest Tickets</flux:heading>
                    <flux:badge color="blue" size="sm">Latest 5</flux:badge>
                    @if($hasViewOneUser)
                        <flux:badge color="purple" size="sm">My Tickets Only</flux:badge>
                    @endif
                </div>
            </div>

            <flux:card class="overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Ticket #</flux:table.column>
                        <flux:table.column>Title</flux:table.column>
                        <flux:table.column>Category</flux:table.column>
                        <flux:table.column>Priority</flux:table.column>
                        <flux:table.column>Status</flux:table.column>
                        <flux:table.column>Date</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @forelse($latestTickets as $ticket)
                            <flux:table.row>
                                <flux:table.cell>
                                    <span class="font-mono text-sm font-medium text-blue-600 dark:text-blue-400">
                                        {{ $ticket->ticket_number }}
                                    </span>
                                </flux:table.cell>
                                <flux:table.cell>
                                    <div>
                                        <div class="font-medium line-clamp-1">{{ $ticket->title }}</div>
                                        <div class="text-xs text-zinc-500 line-clamp-1">{{ Str::limit($ticket->description, 50) }}</div>
                                    </div>
                                </flux:table.cell>
                                <flux:table.cell>
                                    <span class="text-sm">{{ $ticket->category->name ?? 'N/A' }}</span>
                                </flux:table.cell>
                                <flux:table.cell>
                                    <flux:badge 
                                        color="{{ $ticket->priority === 'Critical' ? 'red' : ($ticket->priority === 'Urgent' ? 'orange' : ($ticket->priority === 'Medium' ? 'yellow' : 'green')) }}"
                                        size="sm"
                                    >
                                        {{ $ticket->priority }}
                                    </flux:badge>
                                </flux:table.cell>
                                <flux:table.cell>
                                    <flux:badge 
                                        color="{{ $ticket->status === 'Open' ? 'emerald' : ($ticket->status === 'In Progress' ? 'yellow' : ($ticket->status === 'Pending' ? 'orange' : 'gray')) }}"
                                        size="sm"
                                    >
                                        {{ $ticket->status }}
                                    </flux:badge>
                                </flux:table.cell>
                                <flux:table.cell>
                                    <span class="text-sm">{{ $ticket->created_at->format('d M Y') }}</span>
                                    <span class="text-xs text-zinc-500 block">{{ $ticket->created_at->diffForHumans() }}</span>
                                </flux:table.cell>
                            </flux:table.row>
                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="7" class="text-center py-12">
                                    <div class="flex flex-col items-center gap-3">
                                        <flux:icon name="ticket" class="w-12 h-12 text-zinc-400" />
                                        <flux:heading size="lg" class="text-zinc-400">No tickets yet</flux:heading>
                                        <flux:subheading>
                                            @if($hasViewOneUser)
                                                You haven't created any tickets yet.
                                            @else
                                                Get started by creating a new ticket
                                            @endif
                                        </flux:subheading>
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