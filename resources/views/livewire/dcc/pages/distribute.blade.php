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
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">Mark as Distributed</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Confirm distribution of this submission
            </p>
        </div>
    </div>

    @if($distributingSubmission)

    <!-- Confirmation Card -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700">
        <form wire:submit="processDistribute" class="p-6">

            <!-- Submission Info -->
            <div class="mb-6 p-4 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                <h3 class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3">
                    Submission Information
                </h3>

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="text-xs text-zinc-500 dark:text-zinc-400">
                            Description
                        </label>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">
                            {{ $distributingSubmission->description }}
                        </p>
                    </div>

                    <div>
                        <label class="text-xs text-zinc-500 dark:text-zinc-400">
                            Department
                        </label>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">
                            {{ optional($distributingSubmission->department)->dept_name ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <label class="text-xs text-zinc-500 dark:text-zinc-400">
                            Category
                        </label>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">
                            {{ $distributingSubmission->category_document }}
                        </p>
                    </div>

                    <div>
                        <label class="text-xs text-zinc-500 dark:text-zinc-400">
                            Current Status
                        </label>

                        <p class="text-sm font-medium text-zinc-900 dark:text-white">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $distributingSubmission->status }}
                            </span>
                        </p>
                    </div>

                </div>
            </div>


            <!-- Warning Message -->
            <div class="mb-6 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">

                <div class="flex">

                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd">
                            </path>
                        </svg>
                    </div>

                    <div class="ml-3">

                        <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-300">
                            Confirmation Required
                        </h3>

                        <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-400">
                            <p>
                                Are you sure you want to mark this submission as
                                <span class="font-semibold">Distributed</span>?
                            </p>

                            <p class="mt-1">
                                This action cannot be undone.
                            </p>
                        </div>

                    </div>

                </div>

            </div>


            <!-- Emails -->
            @php
                $emails = is_string($distributingSubmission->emails)
                    ? json_decode($distributingSubmission->emails, true)
                    : $distributingSubmission->emails;
            @endphp

            @if(is_array($emails) && count($emails) > 0)

            <div class="mb-6">

                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    The following emails will be notified:
                </label>

                <div class="space-y-1">

                    @foreach($emails as $email)

                    <div class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">

                        <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>

                        {{ $email }}

                    </div>

                    @endforeach

                </div>

            </div>

            @endif


            <!-- Actions -->
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
                    class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-900"
                >
                    Yes, Mark as Distributed
                </button>

            </div>

        </form>
    </div>

    @else

    <div class="bg-white dark:bg-zinc-800 p-10 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 text-center">
        <p class="text-zinc-500 dark:text-zinc-400">
            Submission not found.
        </p>
    </div>

    @endif
</div>