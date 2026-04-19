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
            
            <!-- Out Date -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Out Date <span class="text-red-500">*</span>
                </label>
                <input type="datetime-local" 
                       wire:model="loanOutDate" 
                       readonly
                       class="w-full px-3 py-2 border rounded-lg bg-gray-100 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400 cursor-not-allowed pointer-events-none">
                @error('loanOutDate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <!-- NIK with Search -->
            <div x-data="{ show: false, search: '{{ $selectedNikName }}' }" class="relative">
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    NIK <span class="text-red-500">*</span>
                </label>
                
                <!-- Input Search -->
                <input 
                    type="text"
                    x-model="search"
                    @input="show = search.trim().length >= 1"
                    placeholder="Search by NIK or name..."
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-700"
                >

                <!-- Dropdown Results -->
                <div 
                    x-show="show"
                    x-transition
                    @click.outside="show = false"
                    class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-800 
                        border border-zinc-300 dark:border-zinc-600 rounded-lg shadow-lg 
                        max-h-60 overflow-y-auto"
                    style="display: none;"
                >
                    @foreach($nikOptions as $id => $name)
                        <div 
                            x-show="'{{ strtolower($name) }}'.includes(search.toLowerCase()) 
                                    || '{{ $id }}'.includes(search)"
                            
                            @click="
                                $wire.set('loanNik', '{{ $id }}'); 
                                search = '{{ addslashes($name) }}'; 
                                $wire.set('selectedNikName', '{{ addslashes($name) }}');
                                show = false;
                            "
                            class="px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700 cursor-pointer border-b border-zinc-100 dark:border-zinc-700 last:border-0"
                        >
                            <div class="text-sm font-medium text-zinc-800 dark:text-zinc-200">{{ $name }}</div>
                        </div>
                    @endforeach
                </div>

                @error('loanNik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select wire:model.live="loanStatus" 
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="in_use">In Use</option>
                    <option value="loaning">Loaning</option>
                    <option value="ecr">ECR</option>
                </select>
                @error('loanStatus') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <!-- Line (only for In Use) -->
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
            
            <!-- Remarks (only for Loaning and ECR) -->
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
    
    <!-- Notifikasi -->
    @if(session('success'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 3000)"
         class="fixed bottom-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 3000)"
         class="fixed bottom-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('error') }}
    </div>
    @endif
</div>