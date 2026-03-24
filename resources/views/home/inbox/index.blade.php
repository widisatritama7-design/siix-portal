<x-home.inbox
    :waitingReceiveCount="$waitingReceiveCount ?? 0"
    :waitingDistributeCount="$waitingDistributeCount ?? 0"
>

    <div class="space-y-6">
        <!-- Waiting Receive Section -->
        @can('view inbox dcc')
        <div class="space-y-2">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                        Waiting Receive
                    </h3>
                    @if(($waitingReceiveCount ?? 0) > 0)
                        <flux:badge color="amber" size="sm">
                            {{ $waitingReceiveCount }}
                        </flux:badge>
                    @endif
                </div>
                <flux:button 
                    href="/dcc/submissions?status=Waiting+Received" 
                    variant="subtle" 
                    icon="arrow-right"
                    size="sm"
                >
                    View All
                </flux:button>
            </div>

            <!-- Waiting Receive Table -->
            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">From</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Subject</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Due Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">PIC</th>
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
                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                        {{ ($waitingReceiveSubmissions->firstItem() ?? 0) + $index }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white font-medium shadow-lg flex-shrink-0">
                                                {{ strtoupper(substr($submission->department->dept_name ?? $submission->dept, 0, 1)) }}
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-zinc-800 dark:text-white block whitespace-nowrap">
                                                    {{ $submission->department->dept_name ?? $submission->dept }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div>
                                            <span class="text-sm font-medium text-zinc-800 dark:text-white block whitespace-nowrap">
                                                {{ $submission->description }}
                                            </span>
                                            @if($submission->revision)
                                                <span class="text-xs text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                                    Revision: {{ $submission->revision }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if($submission->due_date)
                                            <div class="flex flex-col gap-1">
                                                <span class="text-sm whitespace-nowrap">{{ $submission->due_date->format('Y-m-d') }}</span>
                                                <flux:badge color="{{ $badgeColor }}" size="sm">
                                                    {{ $dueDateLabel['label'] }}
                                                </flux:badge>
                                            </div>
                                        @else
                                            <span class="text-sm text-zinc-400 whitespace-nowrap">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <flux:badge color="{{ $submission->statusColor }}" size="sm">
                                            {{ $submission->status }}
                                        </flux:badge>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm">
                                            <div class="whitespace-nowrap">{{ $submission->pic ?? 'N/A' }}</div>
                                            <div class="text-xs text-zinc-500 whitespace-nowrap">{{ $submission->created_at->format('d M Y') }}</div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-12 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                                <flux:icon name="inbox" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                    No messages waiting to be received
                                                </h3>
                                                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                                    All messages have been processed
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(isset($waitingReceiveSubmissions) && $waitingReceiveSubmissions->hasPages())
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                        {{ $waitingReceiveSubmissions->links() }}
                    </div>
                @elseif(isset($waitingReceiveSubmissions) && $waitingReceiveSubmissions->total() > 0)
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">
                                Showing {{ $waitingReceiveSubmissions->firstItem() ?? 0 }}-{{ $waitingReceiveSubmissions->lastItem() ?? 0 }} of {{ $waitingReceiveSubmissions->total() }} items
                            </span>
                        </div>
                    </div>
                @endif
            </flux:card>
        </div>
        @endcan

        @can('view inbox dcc')
        <!-- Waiting Distribute Section -->
        <div class="space-y-2">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                        Waiting Distribute
                    </h3>
                    @if(($waitingDistributeCount ?? 0) > 0)
                        <flux:badge color="blue" size="sm">
                            {{ $waitingDistributeCount }}
                        </flux:badge>
                    @endif
                </div>
                <flux:button 
                    href="/dcc/submissions?distributed=Waiting+Distribute" 
                    variant="subtle" 
                    icon="arrow-right"
                    size="sm"
                >
                    View All
                </flux:button>
            </div>

            <!-- Waiting Distribute Table -->
            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">To</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Subject</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Due Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">PIC</th>
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
                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                        {{ ($waitingDistributeSubmissions->firstItem() ?? 0) + $index }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-medium shadow-lg flex-shrink-0">
                                                {{ strtoupper(substr($submission->department->dept_name ?? $submission->dept, 0, 1)) }}
                                            </div>
                                            <div>
                                                <span class="text-sm font-semibold text-zinc-800 dark:text-white block whitespace-nowrap">
                                                    {{ $submission->department->dept_name ?? $submission->dept }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div>
                                            <span class="text-sm font-medium text-zinc-800 dark:text-white block whitespace-nowrap">
                                                {{ $submission->description }}
                                            </span>
                                            @if($submission->revision)
                                                <span class="text-xs text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                                    Revision: {{ $submission->revision }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if($submission->due_date)
                                            <div class="flex flex-col gap-1">
                                                <span class="text-sm whitespace-nowrap">{{ $submission->due_date->format('Y-m-d') }}</span>
                                                <flux:badge color="{{ $badgeColor }}" size="sm">
                                                    {{ $dueDateLabel['label'] }}
                                                </flux:badge>
                                            </div>
                                        @else
                                            <span class="text-sm text-zinc-400 whitespace-nowrap">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <flux:badge color="{{ $submission->statusColor }}" size="sm">
                                            {{ $submission->status }}
                                        </flux:badge>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm">
                                            <div class="whitespace-nowrap">{{ $submission->pic ?? 'N/A' }}</div>
                                            <div class="text-xs text-zinc-500 whitespace-nowrap">{{ $submission->created_at->format('d M Y') }}</div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-12 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                                <flux:icon name="inbox" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                    No messages waiting to be distributed
                                                </h3>
                                                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                                    All messages have been distributed
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(isset($waitingDistributeSubmissions) && $waitingDistributeSubmissions->hasPages())
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                        {{ $waitingDistributeSubmissions->links() }}
                    </div>
                @elseif(isset($waitingDistributeSubmissions) && $waitingDistributeSubmissions->total() > 0)
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">
                                Showing {{ $waitingDistributeSubmissions->firstItem() ?? 0 }}-{{ $waitingDistributeSubmissions->lastItem() ?? 0 }} of {{ $waitingDistributeSubmissions->total() }} items
                            </span>
                        </div>
                    </div>
                @endif
            </flux:card>
        </div>
        @endcan
    </div>
</x-home.inbox>

<script>
function openDistributeModal(submissionId) {
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