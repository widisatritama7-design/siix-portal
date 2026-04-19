<div class="p-1 space-y-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            PROD
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            MS
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('prod.ms.master-sample') }}" wire:navigate separator="slash">
            Master Sample
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('prod.ms.master-sample.show', ['id' => $masterSample->id, 'tab' => 'details']) }}" wire:navigate separator="slash">
            {{ $masterSample->model_name }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            {{ $isEdit ? 'Edit Expired History' : 'Add Expired History' }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                {{ $isEdit ? 'Edit Expired History' : 'Add Expired History' }}
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                {{ $masterSample->model_name }} | Customer: {{ $masterSample->customer }} | Name/MC: {{ $masterSample->name_or_mc }}
            </p>
        </div>
    </div>

    <!-- Form Card -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
        <form wire:submit="save" class="space-y-6">
            <!-- Updated Date -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Updated Date <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       wire:model.live="updatedDate"
                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-700">
                @error('updatedDate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <!-- Expired Date (Disabled - Auto Calculated) -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Expired Date <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       wire:model="expiredDate" 
                       disabled
                       class="w-full px-3 py-2 border rounded-lg bg-gray-100 dark:bg-zinc-700 dark:border-zinc-600 text-zinc-500 dark:text-zinc-400 cursor-not-allowed">
                @error('expiredDate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <!-- Alarm Date (Disabled - Auto Calculated) -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Alarm Date <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       wire:model="alarmDate" 
                       disabled
                       class="w-full px-3 py-2 border rounded-lg bg-gray-100 dark:bg-zinc-700 dark:border-zinc-600 text-zinc-500 dark:text-zinc-400 cursor-not-allowed">
                @error('alarmDate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <!-- Checked By -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Checked By
                </label>
                <select wire:model="checkedBy" 
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="">Select Checker</option>
                    @foreach($checkerOptions as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('checkedBy') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <!-- Knowledge By -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Knowledge By
                </label>
                <select wire:model="knowledgeBy" 
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="">Select Knowledge</option>
                    @foreach($knowledgeOptions as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('knowledgeBy') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <!-- Approved By -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Approved By
                </label>
                <select wire:model="approvedBy" 
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="">Select Approver</option>
                    @foreach($approverOptions as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('approvedBy') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                <a href="{{ route('prod.ms.master-sample.show', ['id' => $masterSample->id, 'tab' => 'details']) }}" 
                   class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md">
                    <svg class="inline w-4 h-4 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ $isEdit ? 'Update Expired History' : 'Save Expired History' }}
                </button>
            </div>
        </form>
    </flux:card>
</div>