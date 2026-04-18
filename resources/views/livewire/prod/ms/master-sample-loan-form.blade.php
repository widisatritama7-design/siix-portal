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
        <flux:breadcrumbs.item href="{{ route('prod.ms.master-sample.show', ['id' => $masterSample->id, 'tab' => 'history']) }}" wire:navigate separator="slash">
            {{ $masterSample->model_name }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            {{ $isEdit ? 'Edit Loan' : 'New Loan' }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                {{ $isEdit ? 'Edit Loan Application' : 'New Loan Application' }}
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                {{ $masterSample->model_name }} | Customer: {{ $masterSample->customer }} | Name/MC: {{ $masterSample->name_or_mc }}
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('prod.ms.master-sample.show', ['id' => $masterSample->id, 'tab' => 'history']) }}" 
               class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                Cancel
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
        <form wire:submit="save" class="space-y-6">
            <!-- Sample Type -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Sample Type <span class="text-red-500">*</span>
                </label>
                <div class="flex flex-wrap gap-4">
                    @foreach($sampleTypeOptions as $value => $label)
                    <label class="flex items-center gap-2">
                        <input type="checkbox" 
                               wire:model="loanTypes" 
                               value="{{ $value }}" 
                               class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
                @error('loanTypes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <!-- Quantity -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Quantity <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       wire:model="loanQty" 
                       disabled 
                       class="w-full px-3 py-2 border rounded-lg bg-gray-100 dark:bg-zinc-700 dark:border-zinc-600 text-zinc-500">
            </div>
            
            <!-- Out Date -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Out Date <span class="text-red-500">*</span>
                </label>
                <input type="datetime-local" 
                       wire:model="loanOutDate" 
                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-700">
                @error('loanOutDate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <!-- NIK -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    NIK <span class="text-red-500">*</span>
                </label>
                <select wire:model="loanNik" 
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="">Select NIK</option>
                    @foreach($nikOptions as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('loanNik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select wire:model="loanStatus" 
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="in_use">In Use</option>
                    <option value="loaning">Loaning</option>
                    <option value="ecr">ECR</option>
                </select>
                @error('loanStatus') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <!-- Line (conditional) -->
            @if($loanStatus === 'in_use')
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Line <span class="text-red-500">*</span>
                </label>
                <select wire:model="loanMasterLineId" 
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="">Select Line</option>
                    @foreach($lineOptions as $id => $label)
                    <option value="{{ $id }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('loanMasterLineId') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            @endif
            
            <!-- Remarks (conditional) -->
            @if(in_array($loanStatus, ['loaning', 'ecr']))
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Remarks <span class="text-red-500">*</span>
                </label>
                <textarea wire:model="loanRemarks" 
                          rows="4" 
                          placeholder="Enter remarks..."
                          class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-700"></textarea>
                @error('loanRemarks') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            @endif
            
            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                <a href="{{ route('prod.ms.master-sample.show', ['id' => $masterSample->id, 'tab' => 'history']) }}" 
                   class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md">
                    <svg class="inline w-4 h-4 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ $isEdit ? 'Update Loan' : 'Save Loan' }}
                </button>
            </div>
        </form>
    </flux:card>
</div>