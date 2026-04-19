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
            <h1 class="text-2xl font-bold text-red-600 dark:text-red-400">Delete Submission</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">This action cannot be undone</p>
        </div>
    </div>

    <!-- Delete Confirmation Card -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700">
        <form wire:submit="processDelete" class="p-6">
            <!-- Submission Info -->
            <div class="mb-6 p-4 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                <h3 class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3">Submission to Delete</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs text-zinc-500 dark:text-zinc-400">Description</label>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white"><?php echo e($submissionToDelete->description); ?></p>
                    </div>
                    <div>
                        <label class="text-xs text-zinc-500 dark:text-zinc-400">Department</label>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white"><?php echo e($submissionToDelete->department->dept_name ?? 'N/A'); ?></p>
                    </div>
                    <div>
                        <label class="text-xs text-zinc-500 dark:text-zinc-400">Category</label>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white"><?php echo e($submissionToDelete->category_document); ?></p>
                    </div>
                    <div>
                        <label class="text-xs text-zinc-500 dark:text-zinc-400">Created At</label>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white"><?php echo e($submissionToDelete->created_at->format('d M Y H:i')); ?></p>
                    </div>
                </div>
            </div>

            <!-- Warning Message -->
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-300">Warning</h3>
                        <div class="mt-2 text-sm text-red-700 dark:text-red-400">
                            <p>You are about to delete this submission. This action cannot be undone.</p>
                            <p class="mt-1">Please provide a reason for deletion.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reason for Deletion -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                    Reason for Deletion <span class="text-red-500">*</span>
                </label>
                <textarea 
                    wire:model="reason_to_delete" 
                    rows="4" 
                    class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white"
                    placeholder="Please explain why you are deleting this submission..."
                ></textarea>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['reason_to_delete'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-900"
                >
                    Yes, Delete Submission
                </button>
            </div>
        </form>
    </div>
</div><?php /**PATH D:\laragon\www\siix-portal-new\resources\views\livewire\dcc\pages\delete.blade.php ENDPATH**/ ?>