<div>
    <!-- Header dengan Back Button -->
    <div class="flex items-center gap-4 mb-6">
        <button 
            wire:click="backToIndex"
            class="p-2 hover:bg-zinc-100 rounded-lg transition-colors dark:hover:bg-zinc-700"
        >
            <svg class="w-6 h-6 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </button>
        <div>
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">Submission Details</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">View complete information about this submission</p>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
        <!-- Status Banner -->
        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Status:</span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($receivingSubmission->status === 'Waiting Received') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                    @elseif($receivingSubmission->status === 'Received') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                    @elseif($receivingSubmission->status === 'Completed') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                    @elseif($receivingSubmission->status === 'Rejected') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                    @endif">
                    {{ $receivingSubmission->status }}
                </span>
                @if($receivingSubmission->status_distribute === 'Distributed')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                    Distributed
                </span>
                @endif
            </div>
            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                Created: {{ $receivingSubmission->created_at->format('d M Y H:i') }}
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-x-10 gap-y-6">

                <!-- Row 1 -->
                <div>
                    <label class="text-xs font-medium text-zinc-500 uppercase">Category</label>
                    <p class="mt-1 text-sm text-zinc-900 dark:text-white">
                        {{ $receivingSubmission->category_document }}
                    </p>
                </div>

                <div>
                    <label class="text-xs font-medium text-zinc-500 uppercase">Due Date</label>
                    <p class="mt-1 text-sm text-zinc-900 dark:text-white">
                        {{ $receivingSubmission->due_date?->format('d F Y') ?? 'N/A' }}
                    </p>
                </div>

                <!-- IMAGE -->
                <div class="row-span-4">
                    <label class="text-xs font-medium text-zinc-500 uppercase">Documentation</label>

                    @if($receivingSubmission->documentation)
                        <img
                            src="{{ Storage::disk('public')->url($receivingSubmission->documentation) }}"
                            class="mt-2 w-full h-[300px] object-contain rounded-lg border border-zinc-200 dark:border-zinc-700"
                        >
                    @else
                        <p class="mt-2 text-sm text-zinc-500">No documentation</p>
                    @endif
                </div>

                <!-- Row 2 -->
                <div>
                    <label class="text-xs font-medium text-zinc-500 uppercase">Description</label>
                    <p class="mt-1 text-sm text-zinc-900 dark:text-white">
                        {{ $receivingSubmission->description }}
                    </p>
                </div>

                <div>
                    <label class="text-xs font-medium text-zinc-500 uppercase">Emails</label>

                    @php
                        $emails = is_string($receivingSubmission->emails)
                            ? json_decode($receivingSubmission->emails, true)
                            : $receivingSubmission->emails;
                    @endphp

                    @if(is_array($emails))
                        @foreach($emails as $email)
                            <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $email }}</p>
                        @endforeach
                    @endif
                </div>

                <!-- Row 3 -->
                <div>
                    <label class="text-xs font-medium text-zinc-500 uppercase">Revision</label>
                    <p class="mt-1 text-sm text-zinc-900 dark:text-white">
                        {{ $receivingSubmission->revision }}
                    </p>
                </div>

                <div>
                    <label class="text-xs font-medium text-zinc-500 uppercase">Remarks</label>
                    <p class="mt-1 text-sm text-zinc-900 dark:text-white">
                        {{ $receivingSubmission->remarks ?? 'No remarks' }}
                    </p>
                </div>

                <!-- Row 4 -->
                <div>
                    <label class="text-xs font-medium text-zinc-500 uppercase">Department</label>
                    <p class="mt-1 text-sm text-zinc-900 dark:text-white">
                        {{ $receivingSubmission->department->dept_name ?? 'N/A' }}
                    </p>
                </div>

                <div>
                    <label class="text-xs font-medium text-zinc-500 uppercase">Created By</label>
                    <p class="mt-1 text-sm text-zinc-900 dark:text-white">
                        {{ $receivingSubmission->creator->name ?? 'N/A' }}
                    </p>
                </div>

            </div>
        </div>

        <!-- Footer Actions -->
        <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-700/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-2">
            @can('receive submissions')
                @if($receivingSubmission->canReceive())
                <button 
                    wire:click="goToReceive({{ $receivingSubmission->id }})"
                    class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition-colors"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Receive / Reject
                </button>
                @endif
            @endcan

            @if($receivingSubmission->canMarkDistributed())
            <button 
                wire:click="goToDistribute({{ $receivingSubmission->id }})"
                class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Mark as Distributed
            </button>
            @endif
            <button 
                wire:click="backToIndex"
                class="px-4 py-2 text-sm font-medium text-zinc-700 bg-white border border-zinc-300 rounded-lg hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-400 dark:border-zinc-600 dark:hover:bg-zinc-700"
            >
                Back to List
            </button>
        </div>
    </div>
</div>