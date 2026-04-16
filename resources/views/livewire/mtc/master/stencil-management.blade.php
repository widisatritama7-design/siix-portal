<section class="w-full" x-data="{ 
    showUpdateModal: false,
    isSaving: false,
    status: @entangle('status'),
    line_name: @entangle('line_name'),
    nik: @entangle('nik'),
    input_count_stencil: @entangle('input_count_stencil'),
    register_no: @entangle('register_no'),
    employees: {{ json_encode($employees->toArray()) }},
    lineOptions: {{ json_encode($lineOptions->toArray()) }},
    searchEmployee: '',
    searchLine: '',
    showEmployeeDropdown: false,
    showLineDropdown: false
}">
    
    @include('partials.mtc-heading')

    <flux:heading class="sr-only">
        {{ __('MTC - Stencil Management') }}
    </flux:heading>

    <x-mtc.layout class="!max-w-full !px-0 !mx-0">
        <x-slot name="heading">
            <div class="w-full">
                <flux:breadcrumbs class="mb-1">
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
                        Dashboard
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        MTC
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        Stencil Management
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                    Stencil Management
                </h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    Manage stencil inventory and status
                </p>
            </div>
        </x-slot>
        
        <div class="-mt-2">
            <!-- Header Filters -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mt-2 mb-6">
                <div class="w-full">
                    <flux:input
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search by Register No, Customer, Rack..."
                        icon="magnifying-glass"
                        clearable
                    />
                </div>

                <div class="w-full">
                    <select 
                        wire:model.live="selectedStatus"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="">All Status</option>
                        <option value="In Use">In Use</option>
                        <option value="Prepared">Prepared</option>
                        <option value="Cleaning">Cleaning</option>
                        <option value="Stand By">Stand By</option>
                        <option value="Disposed">Disposed</option>
                    </select>
                </div>

                <div class="w-full">
                    <select 
                        wire:model.live="selectedCustomer"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="">All Customers</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer }}">{{ $customer }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full">
                    <flux:button 
                        wire:click="resetFilters" 
                        icon="arrow-path" 
                        variant="subtle"
                        class="w-full justify-center"
                    >
                        Reset Filters
                    </flux:button>
                </div>
            </div>

            <!-- Stencil Table -->
            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Register No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Customer</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Rack Number</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Line Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Count</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Last Update</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Last Update By</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($stencils as $stencil)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-4 py-3">
                                    <span class="text-sm font-semibold text-zinc-800 dark:text-white">
                                        {{ $stencil->register_no }}
                                    </span>
                                 </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $stencil->customer ?? '-' }}
                                    </span>
                                 </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $stencil->rack_number ?? '-' }}
                                    </span>
                                 </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusColorClass($stencil->status) }}">
                                        {{ $stencil->status }}
                                    </span>
                                 </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $stencil->line_name ?? '-' }}
                                    </span>
                                 </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $stencil->count_stencil ?? '-' }}
                                    </span>
                                 </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $stencil->updated_at ? $stencil->updated_at->format('d/m/Y H:i') : '-' }}
                                    </span>
                                 </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $stencil->updater->name ?? $stencil->employee->name ?? '-' }}
                                    </span>
                                 </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                        @can('edit stencil')
                                        <flux:button 
                                            wire:click="updateStatus({{ $stencil->id }})"
                                            @click="showUpdateModal = true"
                                            size="sm"
                                            icon="pencil-square"
                                            variant="primary"
                                            color="yellow"
                                            class="!p-2 flex-shrink-0"
                                            title="Update status"
                                        />
                                        @endcan
                                    </div>
                                 </td>
                             </tr>
                            @empty
                             <tr>
                                <td colspan="9" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <flux:icon name="document-magnifying-glass" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No stencil records found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                                {{ $search || $selectedStatus || $selectedCustomer ? 'Try adjusting your search or filter' : 'No data available' }}
                                            </p>
                                        </div>
                                    </div>
                                 </td>
                             </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($stencils->hasPages())
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $stencils->links() }}
                </div>
                @endif
            </flux:card>
        </div>
    </x-mtc.layout>

    <!-- Update Status Modal with Alpine.js -->
    <div x-show="showUpdateModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;"
         x-transition.opacity.duration.200ms>
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 transition-opacity" @click="showUpdateModal = false"></div>

        <!-- Modal Panel -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-lg transform transition-all"
                 @click.stop>
                
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700 pb-3 mb-4">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                            Update Status & NIK
                        </h3>
                        <button @click="showUpdateModal = false" class="text-zinc-500 hover:text-zinc-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Form -->
                    <div class="space-y-4">
                        <!-- Register No -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Register No
                            </label>
                            <input type="text" 
                                x-model="register_no"
                                readonly
                                class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-gray-100 dark:bg-zinc-800 px-3 py-2 text-sm cursor-not-allowed">
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select 
                                x-model="status"
                                @change="$wire.set('status', status)"
                                class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="In Use">In Use</option>
                                <option value="Prepared">Prepared</option>
                                <option value="Cleaning">Cleaning</option>
                                <option value="Stand By">Stand By</option>
                                <option value="Disposed">Disposed</option>
                            </select>
                            @error('status') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Line Name - Searchable Dropdown (visible for In Use/Prepared) -->
                        <div x-show="['In Use', 'Prepared'].includes(status)" x-cloak>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Line Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="text"
                                    x-model="searchLine"
                                    @input="showLineDropdown = searchLine.trim().length > 0"
                                    @focus="showLineDropdown = true"
                                    :placeholder="line_name ? line_name : 'Search line...'"
                                    class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white"
                                >
                                <div x-show="showLineDropdown"
                                     x-transition
                                     @click.outside="showLineDropdown = false"
                                     class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded-lg shadow-lg max-h-60 overflow-y-auto"
                                     style="display: none;">
                                    <template x-for="(label, value) in lineOptions" :key="value">
                                        <div x-show="label.toLowerCase().includes(searchLine.toLowerCase()) || value.toLowerCase().includes(searchLine.toLowerCase())"
                                             @click="
                                                line_name = value;
                                                searchLine = label;
                                                showLineDropdown = false;
                                                $wire.set('line_name', value);
                                             "
                                             class="px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700 cursor-pointer">
                                            <span class="text-sm" x-text="label"></span>
                                        </div>
                                    </template>
                                    <div x-show="Object.keys(lineOptions).filter(key => 
                                        lineOptions[key].toLowerCase().includes(searchLine.toLowerCase()) || 
                                        key.toLowerCase().includes(searchLine.toLowerCase())
                                    ).length === 0"
                                         class="px-3 py-2 text-sm text-zinc-500 text-center">
                                        No lines found
                                    </div>
                                </div>
                                <input type="hidden" x-model="line_name" @change="$wire.set('line_name', line_name)">
                            </div>
                            @error('line_name') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Count Stencil (visible for Cleaning) -->
                        <div x-show="status === 'Cleaning'" x-cloak>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Count Last Use Stencil <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                x-model="input_count_stencil"
                                @input="$wire.set('input_count_stencil', input_count_stencil)"
                                placeholder="Enter count"
                                class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500"
                                min="1">
                            @error('input_count_stencil') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- NIK - Searchable Dropdown -->
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                NIK <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="text"
                                    x-model="searchEmployee"
                                    @input="showEmployeeDropdown = searchEmployee.trim().length > 0"
                                    @focus="showEmployeeDropdown = true"
                                    placeholder="Search by NIK or name..."
                                    class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white"
                                >
                                <div x-show="showEmployeeDropdown"
                                     x-transition
                                     @click.outside="showEmployeeDropdown = false"
                                     class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded-lg shadow-lg max-h-60 overflow-y-auto"
                                     style="display: none;">
                                    <template x-for="(label, value) in employees" :key="value">
                                        <div x-show="label.toLowerCase().includes(searchEmployee.toLowerCase()) || value.includes(searchEmployee)"
                                             @click="
                                                nik = value;
                                                searchEmployee = label;
                                                showEmployeeDropdown = false;
                                                $wire.set('nik', value);
                                             "
                                             class="px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700 cursor-pointer">
                                            <span class="text-sm" x-text="label"></span>
                                        </div>
                                    </template>
                                </div>
                                <input type="hidden" x-model="nik" @change="$wire.set('nik', nik)">
                            </div>
                            @error('nik') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end gap-2 pt-4 mt-4 border-t border-zinc-200 dark:border-zinc-700">
                        <button @click="showUpdateModal = false" 
                                class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                            Cancel
                        </button>
                        <button wire:click="saveStatusUpdate" 
                                wire:loading.attr="disabled"
                                :disabled="isSaving"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="saveStatusUpdate">Save Changes</span>
                            <span wire:loading wire:target="saveStatusUpdate">
                                <svg class="inline w-4 h-4 mr-1 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Saving...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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