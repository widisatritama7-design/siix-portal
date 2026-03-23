{{-- home/inbox/dcc/waiting-receive.blade.php --}}
<x-home.inbox
    heading="Waiting Receive"
    :waitingReceiveCount="$waitingReceiveCount"
    :waitingDistributeCount="$waitingDistributeCount"
>
    <div class="p-2 space-y-2">
        <!-- Header dengan Action Button -->
        <div class="flex justify-between items-center mb-4">
            
            <!-- Action Button di Header -->
            <flux:button 
                href="/dcc/submissions?status=Waiting+Received" 
                variant="primary" 
                icon="arrow-right"
                class="bg-blue-600 hover:bg-blue-700 text-white"
            >
                Go to Submissions
            </flux:button>
        </div>
        <!-- Messages Table -->
        <flux:card class="overflow-hidden">
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
                        @forelse($submissions as $index => $submission)
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
                                    {{ $submissions->firstItem() + $index }}
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
                                <td colspan="6" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <flux:icon name="inbox" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No messages waiting to be received
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
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

            <!-- Pagination -->
            @if($submissions->hasPages())
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $submissions->links() }}
                </div>
            @else
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">
                            Showing {{ $submissions->firstItem() ?? 0 }}-{{ $submissions->lastItem() ?? 0 }} of {{ $submissions->total() }} items
                        </span>
                    </div>
                </div>
            @endif
        </flux:card>
    </div>
</x-home.inbox>