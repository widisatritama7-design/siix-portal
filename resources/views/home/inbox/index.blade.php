<x-home.inbox
    :waitingReceiveCount="$waitingReceiveCount ?? 0"
    :waitingDistributeCount="$waitingDistributeCount ?? 0"
    :waitingApproveCount="$waitingApproveCount ?? 0"
    :waitingCheckCount="$waitingCheckCount ?? 0"
>
    <div class="space-y-8">
        <!-- DCC: Waiting Receive Section -->
        @can('view inbox dcc')
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-white">
                        Waiting Receive
                    </h2>
                    @if(($waitingReceiveCount ?? 0) > 0)
                        <flux:badge color="amber" size="lg">
                            {{ $waitingReceiveCount }}
                        </flux:badge>
                    @endif
                </div>
                <flux:button 
                    href="/dcc/submissions?status=Waiting+Received" 
                    variant="subtle" 
                    icon="arrow-right"
                >
                    View All
                </flux:button>
            </div>

            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">From</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Subject</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Due Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">PIC</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse(($waitingReceiveSubmissions ?? collect()) as $index => $submission)
                                @php
                                    $dueDateLabel = $submission->dueDateLabel;
                                    $badgeColor = match($dueDateLabel['color']) {
                                        'danger' => 'red',
                                        'success' => 'green',
                                        'gray' => 'zinc',
                                        default => 'zinc'
                                    };
                                @endphp
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white font-medium text-sm">
                                                {{ strtoupper(substr($submission->department->dept_name ?? $submission->dept, 0, 1)) }}
                                            </div>
                                            <span class="text-sm font-medium text-zinc-900 dark:text-white">
                                                {{ $submission->department->dept_name ?? $submission->dept }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                                {{ $submission->description }}
                                            </div>
                                            @if($submission->revision)
                                                <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                                    Revision: {{ $submission->revision }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($submission->due_date)
                                            <div class="space-y-1">
                                                <div class="text-sm">{{ $submission->due_date->format('Y-m-d') }}</div>
                                                <flux:badge color="{{ $badgeColor }}" size="sm">
                                                    {{ $dueDateLabel['label'] }}
                                                </flux:badge>
                                            </div>
                                        @else
                                            <span class="text-sm text-zinc-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <flux:badge color="{{ $submission->statusColor }}" size="sm">
                                            {{ $submission->status }}
                                        </flux:badge>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm">
                                            <div>{{ $submission->pic ?? 'N/A' }}</div>
                                            <div class="text-xs text-zinc-500">{{ $submission->created_at->format('d M Y') }}</div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <flux:icon name="inbox" class="w-12 h-12 text-zinc-400" />
                                            <div class="text-sm text-zinc-500">No messages waiting to be received</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </flux:card>
        </div>
        @endcan

        <!-- DCC: Waiting Distribute Section -->
        @can('view inbox dcc')
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-white">
                        Waiting Distribute
                    </h2>
                    @if(($waitingDistributeCount ?? 0) > 0)
                        <flux:badge color="blue" size="lg">
                            {{ $waitingDistributeCount }}
                        </flux:badge>
                    @endif
                </div>
                <flux:button 
                    href="/dcc/submissions?distributed=Waiting+Distribute" 
                    variant="subtle" 
                    icon="arrow-right"
                >
                    View All
                </flux:button>
            </div>

            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">To</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Subject</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Due Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">PIC</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse(($waitingDistributeSubmissions ?? collect()) as $index => $submission)
                                @php
                                    $dueDateLabel = $submission->dueDateLabel;
                                    $badgeColor = match($dueDateLabel['color']) {
                                        'danger' => 'red',
                                        'success' => 'green',
                                        'gray' => 'zinc',
                                        default => 'zinc'
                                    };
                                @endphp
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-medium text-sm">
                                                {{ strtoupper(substr($submission->department->dept_name ?? $submission->dept, 0, 1)) }}
                                            </div>
                                            <span class="text-sm font-medium text-zinc-900 dark:text-white">
                                                {{ $submission->department->dept_name ?? $submission->dept }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                                {{ $submission->description }}
                                            </div>
                                            @if($submission->revision)
                                                <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                                    Revision: {{ $submission->revision }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($submission->due_date)
                                            <div class="space-y-1">
                                                <div class="text-sm">{{ $submission->due_date->format('Y-m-d') }}</div>
                                                <flux:badge color="{{ $badgeColor }}" size="sm">
                                                    {{ $dueDateLabel['label'] }}
                                                </flux:badge>
                                            </div>
                                        @else
                                            <span class="text-sm text-zinc-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <flux:badge color="{{ $submission->statusColor }}" size="sm">
                                            {{ $submission->status }}
                                        </flux:badge>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm">
                                            <div>{{ $submission->pic ?? 'N/A' }}</div>
                                            <div class="text-xs text-zinc-500">{{ $submission->created_at->format('d M Y') }}</div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <flux:icon name="inbox" class="w-12 h-12 text-zinc-400" />
                                            <div class="text-sm text-zinc-500">No messages waiting to be distributed</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </flux:card>
        </div>
        @endcan

        <!-- Ticket: Waiting Approve Section -->
        @can('approve tickets')
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-white">
                        Waiting Approve
                    </h2>
                    @if(($waitingApproveCount ?? 0) > 0)
                        <flux:badge color="purple" size="lg">
                            {{ $waitingApproveCount }}
                        </flux:badge>
                    @endif
                </div>
                <flux:button 
                    href="/ticket/list?pic_approval=Waiting+Approval" 
                    variant="subtle" 
                    icon="arrow-right"
                >
                    View All
                </flux:button>
            </div>

            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-max">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Ticket #</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Title</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Priority</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Requester</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Created</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse(($waitingApproveTickets ?? collect()) as $index => $ticket)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm font-mono font-semibold text-blue-600 dark:text-blue-400">
                                        {{ $ticket->ticket_number }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @php
                                        $title = $ticket->title;
                                        $isLongText = strlen($title) > 25;
                                    @endphp
                                    
                                    @if($isLongText)
                                        <div class="relative group inline-block">
                                            <div class="text-sm text-zinc-800 dark:text-white cursor-help border-b border-dashed border-zinc-400 dark:border-zinc-500">
                                                {{ Str::limit($title, 25) }}
                                            </div>
                                            <div class="absolute z-50 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-200 bottom-full left-0 mb-2 pointer-events-none">
                                                <div class="bg-gray-900 dark:bg-gray-800 text-white rounded-lg shadow-lg px-3 py-2 text-sm whitespace-normal max-w-xs">
                                                    <div class="font-semibold text-xs text-gray-300 mb-1">Title</div>
                                                    {{ $title }}
                                                </div>
                                                <div class="absolute -bottom-1 left-4 w-2 h-2 bg-gray-900 dark:bg-gray-800 transform rotate-45"></div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-sm text-zinc-800 dark:text-white">
                                            {{ $title }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'Open' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                            'In Progress' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                            'Pending' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                            'Closed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                        ];
                                        $statusColor = $statusColors[$ticket->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                        {{ $ticket->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @php
                                        $priorityColors = [
                                            'Low' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300',
                                            'Medium' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                            'Urgent' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                            'Critical' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                        ];
                                        $priorityColor = $priorityColors[$ticket->priority] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $priorityColor }}">
                                        {{ $ticket->priority }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @php
                                        $categoryName = $ticket->category->name ?? '-';
                                        $isLongText = strlen($categoryName) > 25;
                                    @endphp
                                    
                                    @if($isLongText && $categoryName !== '-')
                                        <div class="relative group inline-block">
                                            <div class="text-sm text-zinc-600 dark:text-zinc-400 cursor-help border-b border-dashed border-zinc-400 dark:border-zinc-500">
                                                {{ Str::limit($categoryName, 25) }}
                                            </div>
                                            <div class="absolute z-50 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-200 bottom-full left-0 mb-2 pointer-events-none">
                                                <div class="bg-gray-900 dark:bg-gray-800 text-white rounded-lg shadow-lg px-3 py-2 text-sm whitespace-normal max-w-xs">
                                                    <div class="font-semibold text-xs text-gray-300 mb-1">Category</div>
                                                    {{ $categoryName }}
                                                </div>
                                                <div class="absolute -bottom-1 left-4 w-2 h-2 bg-gray-900 dark:bg-gray-800 transform rotate-45"></div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-sm text-zinc-600 dark:text-zinc-400">
                                            {{ $categoryName }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm">
                                        <div class="text-zinc-800 dark:text-white">{{ $ticket->creator->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-zinc-500">{{ $ticket->email_user }}</div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm">
                                        <div class="text-zinc-600 dark:text-zinc-400">{{ $ticket->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-zinc-500">{{ $ticket->created_at->format('H:i') }}</div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <flux:icon name="ticket" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No tickets waiting for approval
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                                All tickets have been processed
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </flux:card>
        </div>
        @endcan

        <!-- Ticket: Waiting Check Section -->
        @can('check tickets')
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-white">
                        Waiting Check
                    </h2>
                    @if(($waitingCheckCount ?? 0) > 0)
                        <flux:badge color="green" size="lg">
                            {{ $waitingCheckCount }}
                        </flux:badge>
                    @endif
                </div>
                <flux:button 
                    href="/ticket/list?user_approval=Waiting+Approval" 
                    variant="subtle" 
                    icon="arrow-right"
                >
                    View All
                </flux:button>
            </div>

            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-max">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Ticket #</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Title</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Priority</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Requester</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Created</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse(($waitingCheckTickets ?? collect()) as $index => $ticket)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm font-mono font-semibold text-blue-600 dark:text-blue-400">
                                        {{ $ticket->ticket_number }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @php
                                        $title = $ticket->title;
                                        $isLongText = strlen($title) > 25;
                                    @endphp
                                    
                                    @if($isLongText)
                                        <div class="relative group inline-block">
                                            <div class="text-sm text-zinc-800 dark:text-white cursor-help border-b border-dashed border-zinc-400 dark:border-zinc-500">
                                                {{ Str::limit($title, 25) }}
                                            </div>
                                            <div class="absolute z-50 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-200 bottom-full left-0 mb-2 pointer-events-none">
                                                <div class="bg-gray-900 dark:bg-gray-800 text-white rounded-lg shadow-lg px-3 py-2 text-sm whitespace-normal max-w-xs">
                                                    <div class="font-semibold text-xs text-gray-300 mb-1">Title</div>
                                                    {{ $title }}
                                                </div>
                                                <div class="absolute -bottom-1 left-4 w-2 h-2 bg-gray-900 dark:bg-gray-800 transform rotate-45"></div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-sm text-zinc-800 dark:text-white">
                                            {{ $title }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'Open' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                            'In Progress' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                            'Pending' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                            'Closed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                        ];
                                        $statusColor = $statusColors[$ticket->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                        {{ $ticket->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @php
                                        $priorityColors = [
                                            'Low' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300',
                                            'Medium' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                            'Urgent' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                            'Critical' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                        ];
                                        $priorityColor = $priorityColors[$ticket->priority] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $priorityColor }}">
                                        {{ $ticket->priority }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @php
                                        $categoryName = $ticket->category->name ?? '-';
                                        $isLongText = strlen($categoryName) > 25;
                                    @endphp
                                    
                                    @if($isLongText && $categoryName !== '-')
                                        <div class="relative group inline-block">
                                            <div class="text-sm text-zinc-600 dark:text-zinc-400 cursor-help border-b border-dashed border-zinc-400 dark:border-zinc-500">
                                                {{ Str::limit($categoryName, 25) }}
                                            </div>
                                            <div class="absolute z-50 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-200 bottom-full left-0 mb-2 pointer-events-none">
                                                <div class="bg-gray-900 dark:bg-gray-800 text-white rounded-lg shadow-lg px-3 py-2 text-sm whitespace-normal max-w-xs">
                                                    <div class="font-semibold text-xs text-gray-300 mb-1">Category</div>
                                                    {{ $categoryName }}
                                                </div>
                                                <div class="absolute -bottom-1 left-4 w-2 h-2 bg-gray-900 dark:bg-gray-800 transform rotate-45"></div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-sm text-zinc-600 dark:text-zinc-400">
                                            {{ $categoryName }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm">
                                        <div class="text-zinc-800 dark:text-white">{{ $ticket->creator->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-zinc-500">{{ $ticket->email_user }}</div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm">
                                        <div class="text-zinc-600 dark:text-zinc-400">{{ $ticket->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-zinc-500">{{ $ticket->created_at->format('H:i') }}</div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <flux:icon name="check-circle" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No tickets waiting for checking
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                                All tickets have been checked
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </flux:card>
        </div>
        @endcan
    </div>

    <script>
    function distributeSubmission(submissionId) {
        if (confirm('Are you sure you want to mark this submission as distributed?')) {
            fetch(`/inbox/distribute/${submissionId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    location.reload();
                } else {
                    alert('Error distributing submission');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while distributing the submission');
            });
        }
    }
    </script>
</x-home.inbox>