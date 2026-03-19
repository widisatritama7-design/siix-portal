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
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">Edit Submission</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Update the submission information below</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700">
        <form wire:submit="save" class="p-6">
            <div class="space-y-6">
                <!-- Category Document -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Category Document <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="category_document" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        <option value="">Select Category</option>
                        @foreach($categoryOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category_document') 
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                        wire:model="description" 
                        class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white uppercase"
                        placeholder="Enter description">
                    @error('description') 
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Revision -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Revision <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="revision" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        @error('revision') 
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- PIC -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            PIC <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            wire:model="pic" 
                            class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white uppercase"
                            placeholder="Enter PIC name">
                        @error('pic') 
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Department -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Department <span class="text-red-500">*</span>
                        </label>
                        <select wire:model.live="dept" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                            <option value="">Select Department</option>
                            @foreach($allDepartments as $dept)
                                <option value="{{ $dept->dept_name }}">{{ $dept->dept_name }}</option>
                            @endforeach
                        </select>
                        @error('dept') 
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Due Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" wire:model="due_date" min="{{ now()->format('Y-m-d') }}" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        @error('due_date') 
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Emails Section -->
                @if($dept)
                <div class="border-t border-zinc-200 dark:border-zinc-700 pt-6" wire:key="email-section">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3">
                        Emails Tujuan <span class="text-red-500">*</span>
                        @if(count($emails) > 0)
                            <span class="ml-2 text-xs text-green-600 dark:text-green-400">({{ count($emails) }} selected)</span>
                        @endif
                    </label>

                    <!-- Selected emails badges -->
                    @if(count($emails) > 0)
                        <div class="mb-3 flex flex-wrap gap-2 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            @foreach($emails as $email)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-600 text-white text-sm rounded-full">
                                    {{ $email }}
                                    <button type="button" wire:click="toggleEmail('{{ $email }}')" class="hover:text-red-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </span>
                            @endforeach
                        </div>
                    @endif

                    @php
                        $selectedDept = $allDepartments->where('dept_name', $dept)->first();
                        $availableEmails = [];
                        
                        if ($selectedDept && $selectedDept->emails) {
                            if (is_string($selectedDept->emails)) {
                                $availableEmails = array_map('trim', explode(',', $selectedDept->emails));
                            } elseif (is_array($selectedDept->emails)) {
                                $availableEmails = $selectedDept->emails;
                            }
                        }
                    @endphp

                    <!-- Quick actions -->
                    @if(count($availableEmails) > 0)
                        <div class="flex gap-2 mb-3">
                            <button type="button" 
                                    wire:click="selectAllEmails"
                                    class="px-3 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 dark:bg-blue-900/50 dark:text-blue-300 dark:hover:bg-blue-800">
                                Select All
                            </button>
                            <button type="button" 
                                    wire:click="clearAllEmails"
                                    class="px-3 py-1 text-xs font-medium text-zinc-700 bg-zinc-100 rounded-lg hover:bg-zinc-200 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-600">
                                Clear All
                            </button>
                        </div>
                    @endif

                    <!-- Available emails list -->
                    @if(count($availableEmails) > 0)
                        <div class="mt-2 space-y-1 max-h-60 overflow-y-auto">
                            @foreach($availableEmails as $email)
                                <label class="flex items-center space-x-2 p-2 hover:bg-zinc-50 dark:hover:bg-zinc-700/50 rounded-lg cursor-pointer">
                                    <input type="checkbox" 
                                           value="{{ $email }}"
                                           {{ in_array($email, $emails) ? 'checked' : '' }}
                                           wire:click="toggleEmail('{{ $email }}')"
                                           class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $email }}</span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">No emails available for this department</p>
                    @endif

                    @error('emails') 
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                @endif

                <!-- Documentation File -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Documentation File
                    </label>
                    @if($existing_documentation)
                        <div class="mb-2 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-between">
                            <span class="text-sm text-blue-700 dark:text-blue-300">
                                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                {{ basename($existing_documentation) }}
                            </span>
                            <button type="button" wire:click="$set('existing_documentation', null)" class="text-red-600 hover:text-red-700 dark:text-red-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    @endif
                    <input type="file" wire:model="documentation_file" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    @error('documentation_file') 
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">Leave empty to keep current file</p>
                </div>

                <!-- Remarks -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Remarks
                    </label>
                    <textarea wire:model="remarks" rows="4" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white" placeholder="Enter any additional remarks..."></textarea>
                </div>
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
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-900"
                >
                    Update Submission
                </button>
            </div>
        </form>
    </div>
</div>