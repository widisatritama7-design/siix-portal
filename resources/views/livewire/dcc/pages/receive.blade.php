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
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">Receive / Reject Submission</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Process the submission</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700">
        <form wire:submit="processReceive" class="p-6">
            <!-- Submission Info -->
            <div class="mb-6 p-4 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                <h3 class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3">Submission Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs text-zinc-500 dark:text-zinc-400">Description</label>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $receivingSubmission->description }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-zinc-500 dark:text-zinc-400">Department</label>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $receivingSubmission->department->dept_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-zinc-500 dark:text-zinc-400">Category</label>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $receivingSubmission->category_document }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-zinc-500 dark:text-zinc-400">PIC</label>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $receivingSubmission->pic }}</p>
                    </div>
                </div>
            </div>

            <!-- Status Selection -->
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3">
                        Select Action <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-4">
                        <!-- Received Button -->
                        <button 
                            type="button"
                            wire:click="$set('receiveStatus', 'Received')"
                            class="flex-1 relative flex items-center justify-center gap-3 px-6 py-4 rounded-xl border-2 transition-all duration-200
                                {{ $receiveStatus === 'Received' 
                                    ? 'border-green-500 bg-green-50 dark:bg-green-900/20' 
                                    : 'border-zinc-200 dark:border-zinc-700 hover:border-green-300 dark:hover:border-green-700 hover:bg-green-50/50 dark:hover:bg-green-900/10' 
                                }}"
                        >
                            <div class="flex items-center gap-3">
                                <!-- Icon -->
                                <div class="p-2 rounded-full 
                                    {{ $receiveStatus === 'Received' 
                                        ? 'bg-green-500 text-white' 
                                        : 'bg-zinc-100 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400' 
                                    }}">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-lg font-semibold 
                                        {{ $receiveStatus === 'Received' ? 'text-green-600 dark:text-green-400' : 'text-zinc-700 dark:text-zinc-300' }}">
                                        Received
                                    </p>
                                    <p class="text-sm 
                                        {{ $receiveStatus === 'Received' ? 'text-green-500 dark:text-green-500' : 'text-zinc-500 dark:text-zinc-400' }}">
                                        Accept this submission
                                    </p>
                                </div>
                            </div>

                            <!-- Selected Check Icon -->
                            @if($receiveStatus === 'Received')
                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                        </button>

                        <!-- Rejected Button -->
                        <button 
                            type="button"
                            wire:click="$set('receiveStatus', 'Rejected')"
                            class="flex-1 relative flex items-center justify-center gap-3 px-6 py-4 rounded-xl border-2 transition-all duration-200
                                {{ $receiveStatus === 'Rejected' 
                                    ? 'border-red-500 bg-red-50 dark:bg-red-900/20' 
                                    : 'border-zinc-200 dark:border-zinc-700 hover:border-red-300 dark:hover:border-red-700 hover:bg-red-50/50 dark:hover:bg-red-900/10' 
                                }}"
                        >
                            <div class="flex items-center gap-3">
                                <!-- Icon -->
                                <div class="p-2 rounded-full 
                                    {{ $receiveStatus === 'Rejected' 
                                        ? 'bg-red-500 text-white' 
                                        : 'bg-zinc-100 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400' 
                                    }}">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-lg font-semibold 
                                        {{ $receiveStatus === 'Rejected' ? 'text-red-600 dark:text-red-400' : 'text-zinc-700 dark:text-zinc-300' }}">
                                        Rejected
                                    </p>
                                    <p class="text-sm 
                                        {{ $receiveStatus === 'Rejected' ? 'text-red-500 dark:text-red-500' : 'text-zinc-500 dark:text-zinc-400' }}">
                                        Reject this submission
                                    </p>
                                </div>
                            </div>

                            <!-- Selected Check Icon -->
                            @if($receiveStatus === 'Rejected')
                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                        </button>
                    </div>
                    @error('receiveStatus') 
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reason for Rejection -->
                @if($receiveStatus === 'Rejected')
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Reason for Rejection <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        wire:model="receiveReason" 
                        rows="4" 
                        class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white"
                        placeholder="Please provide a reason for rejection..."
                    ></textarea>
                    @error('receiveReason') 
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                @endif
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                <button 
                    type="button"
                    wire:click="backToIndex"
                    class="px-4 py-2 text-sm font-medium text-zinc-700 bg-white border border-zinc-300 rounded-lg hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-400 dark:border-zinc-600 dark:hover:bg-zinc-700"
                >
                    Cancel
                </button>
                <button 
                    type="submit"
                    @class([
                        'px-6 py-2 text-sm font-medium text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-zinc-900 transition-colors duration-200',
                        'bg-green-600 hover:bg-green-700 focus:ring-green-500' => $receiveStatus === 'Received',
                        'bg-red-600 hover:bg-red-700 focus:ring-red-500' => $receiveStatus === 'Rejected',
                        'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 opacity-50 cursor-not-allowed' => !$receiveStatus,
                    ])
                    @if(!$receiveStatus) disabled @endif
                >
                    @if($receiveStatus === 'Received')
                        Accept Submission
                    @elseif($receiveStatus === 'Rejected')
                        Reject Submission
                    @else
                        Process Submission
                    @endif
                </button>
            </div>
        </form>
    </div>
</div>