<section class="w-full" x-data="{
    status: @entangle('status'),
    line_name: @entangle('line_name'),
    nik: @entangle('nik'),
    input_count_stencil: @entangle('input_count_stencil'),
    register_no: @entangle('register_no'),
    searchEmployee: '',
    searchLine: '',
    showEmployeeDropdown: false,
    showLineDropdown: false,
    employees: @js($employees),
    lineOptions: @js($lineOptions),
    init() {
        this.$watch('searchEmployee', value => {
            this.showEmployeeDropdown = value.length > 0;
        });
        this.$watch('searchLine', value => {
            this.showLineDropdown = value.length > 0;
        });
    }
}">
    <x-mtc.layout class="!max-w-full !px-0 !mx-0">
        <x-slot name="heading">
            <div class="w-full">
                <flux:breadcrumbs class="mb-1">
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
                        Dashboard
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item href="{{ route('mtc.stencil.index') }}" wire:navigate separator="slash">
                        Stencil Management
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        Update Status
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                            Update Stencil Status
                        </h1>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            Update stencil status and information
                        </p>
                    </div>
                </div>
            </div>
        </x-slot>

        <div class="mt-4">
            <flux:card class="p-6">
                <form wire:submit="saveStatusUpdate" class="space-y-6">
                    <!-- Register Number (Readonly) -->
                    <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-xl p-4 border border-gray-200 dark:border-zinc-700">
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Register Number</label>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                            </svg>
                            <input type="text" wire:model="register_no" readonly class="flex-1 rounded-lg border-gray-200 dark:border-zinc-600 bg-white dark:bg-zinc-800 px-3 py-2 text-sm font-mono font-semibold cursor-not-allowed">
                        </div>
                    </div>

                    <!-- Status Selection -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Status <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                            <label class="relative flex cursor-pointer">
                                <input type="radio" x-model="status" value="In Use" class="peer sr-only">
                                <div class="w-full p-3 rounded-lg border-2 transition-all duration-200 peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20 border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-md">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">In Use</span>
                                    </div>
                                </div>
                            </label>
                            <label class="relative flex cursor-pointer">
                                <input type="radio" x-model="status" value="Prepared" class="peer sr-only">
                                <div class="w-full p-3 rounded-lg border-2 transition-all duration-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-md">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Prepared</span>
                                    </div>
                                </div>
                            </label>
                            <label class="relative flex cursor-pointer">
                                <input type="radio" x-model="status" value="Cleaning" class="peer sr-only">
                                <div class="w-full p-3 rounded-lg border-2 transition-all duration-200 peer-checked:border-yellow-500 peer-checked:bg-yellow-50 dark:peer-checked:bg-yellow-900/20 border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-md">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 8H9L8 4z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Cleaning</span>
                                    </div>
                                </div>
                            </label>
                            <label class="relative flex cursor-pointer">
                                <input type="radio" x-model="status" value="Stand By" class="peer sr-only">
                                <div class="w-full p-3 rounded-lg border-2 transition-all duration-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 dark:peer-checked:bg-purple-900/20 border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-md">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Stand By</span>
                                    </div>
                                </div>
                            </label>
                            <label class="relative flex cursor-pointer">
                                <input type="radio" x-model="status" value="Disposed" class="peer sr-only">
                                <div class="w-full p-3 rounded-lg border-2 transition-all duration-200 peer-checked:border-gray-500 peer-checked:bg-gray-50 dark:peer-checked:bg-gray-900/20 border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-md">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Disposed</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('status') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Line Name (untuk status In Use atau Prepared) -->
                    <div x-show="['In Use', 'Prepared'].includes(status)" x-cloak>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Line Name <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                    x-model="searchLine" 
                                    @input="showLineDropdown = searchLine.length > 0"
                                    @focus="showLineDropdown = searchLine.length > 0"
                                    @click="showLineDropdown = searchLine.length > 0"
                                    :value="lineOptions[line_name] || line_name || ''"
                                    placeholder="Type to search line (SMT 1 - SMT 17)..." 
                                    class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                    </svg>
                                </div>
                            </div>
                            <!-- Dropdown hanya muncul jika searchLine tidak kosong -->
                            <div x-show="showLineDropdown && searchLine.length > 0" 
                                 @click.away="showLineDropdown = false" 
                                 class="absolute z-50 w-full mt-2 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-lg max-h-60 overflow-y-auto"
                                 x-cloak>
                                <template x-for="(label, value) in lineOptions" :key="value">
                                    <div x-show="label.toLowerCase().includes(searchLine.toLowerCase()) || value.toLowerCase().includes(searchLine.toLowerCase())" 
                                        @click="line_name = value; searchLine = label; showLineDropdown = false;" 
                                        class="px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 cursor-pointer transition-colors">
                                        <span class="text-sm" x-text="label"></span>
                                    </div>
                                </template>
                                <div x-show="Object.keys(lineOptions).filter(key => lineOptions[key].toLowerCase().includes(searchLine.toLowerCase()) || key.toLowerCase().includes(searchLine.toLowerCase())).length === 0" 
                                    class="px-4 py-3 text-sm text-gray-500 text-center">
                                    No lines found
                                </div>
                            </div>
                        </div>
                        @error('line_name') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Count Stencil (untuk status Cleaning) -->
                    <div x-show="status === 'Cleaning'" x-cloak>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Count Last Use Stencil <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                            </div>
                            <input type="number" x-model="input_count_stencil" placeholder="Enter count number" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-600 dark:text-white" min="1">
                        </div>
                        @error('input_count_stencil') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Employee Selection -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">NIK / Employee <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                    x-model="searchEmployee" 
                                    @input="showEmployeeDropdown = searchEmployee.length > 0"
                                    @focus="showEmployeeDropdown = searchEmployee.length > 0"
                                    @click="showEmployeeDropdown = searchEmployee.length > 0"
                                    :value="employees[nik] || ''"
                                    placeholder="Type NIK or name to search..." 
                                    class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                    </svg>
                                </div>
                            </div>
                            <!-- Dropdown hanya muncul jika searchEmployee tidak kosong -->
                            <div x-show="showEmployeeDropdown && searchEmployee.length > 0" 
                                @click.away="showEmployeeDropdown = false" 
                                class="absolute z-50 w-full mt-2 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-lg max-h-60 overflow-y-auto"
                                x-cloak>
                                <template x-for="(label, value) in employees" :key="value">
                                    <!-- Search by NIK atau Name (label sudah berisi NIK - Name) -->
                                    <div x-show="label.toLowerCase().includes(searchEmployee.toLowerCase())" 
                                        @click="nik = value; searchEmployee = label; showEmployeeDropdown = false;" 
                                        class="px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 cursor-pointer transition-colors">
                                        <span class="text-sm" x-text="label"></span>
                                    </div>
                                </template>
                                <div x-show="Object.keys(employees).filter(key => employees[key].toLowerCase().includes(searchEmployee.toLowerCase())).length === 0" 
                                    class="px-4 py-3 text-sm text-gray-500 text-center">
                                    No employees found
                                </div>
                            </div>
                        </div>
                        @error('nik') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Hidden inputs untuk sync data -->
                    <input type="hidden" wire:model="status">
                    <input type="hidden" wire:model="line_name">
                    <input type="hidden" wire:model="nik">
                    <input type="hidden" wire:model="input_count_stencil">

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-zinc-700">
                        <flux:button wire:navigate href="{{ route('mtc.stencil.index') }}" variant="ghost">
                            Cancel
                        </flux:button>
                        <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="saveStatusUpdate">
                                <svg class="inline w-4 h-4 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Save Changes
                            </span>
                            <span wire:loading wire:target="saveStatusUpdate">
                                <svg class="inline w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Saving...
                            </span>
                        </flux:button>
                    </div>
                </form>
            </flux:card>
        </div>
    </x-mtc.layout>

    <!-- Notifikasi -->
    <div x-data="{ show: false, message: '', type: 'success' }" 
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
         x-show="show"
         x-transition
         class="fixed bottom-4 right-4 z-50"
         :class="{
             'bg-green-500': type === 'success',
             'bg-red-500': type === 'error',
             'bg-yellow-500': type === 'warning'
         }"
         style="display: none;">
        <div class="text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
            <span x-text="message"></span>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</section>