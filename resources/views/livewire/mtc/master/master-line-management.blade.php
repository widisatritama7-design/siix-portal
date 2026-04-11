<section class="w-full">
    @include('partials.mtc-heading')

    <flux:heading class="sr-only">
        {{ __('MTC - Master Line Management') }}
    </flux:heading>

    <x-mtc.layout 
        class="!max-w-full !px-0 !mx-0"
    >
        <x-slot name="heading">
            <div class="w-full">
                <!-- Breadcrumbs -->
                <flux:breadcrumbs class="mb-1">
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
                        Dashboard
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        Maintenance
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        Master Line
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                    Master Line
                </h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    Manage Line master data for MTC
                </p>
            </div>
        </x-slot>
        
        <div class="-mt-2">
            <!-- Header Filters -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 mt-2 mb-6">
                <!-- Search -->
                <div class="w-full">
                    <flux:input
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search by line number or trouble..."
                        icon="magnifying-glass"
                        clearable
                    />
                </div>

                <!-- Filter Location -->
                <div class="w-full">
                    <select 
                        wire:model.live="selectedLocation"
                        class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="">All Locations</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">
                                {{ $location->location_name }} ({{ $location->area->area_name ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Machine Type -->
                <div class="w-full">
                    <select 
                        wire:model.live="selectedMachineType"
                        class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="">All Machine Types</option>
                        <option value="fuji">Fuji</option>
                        <option value="panasonic">Panasonic</option>
                        <option value="both">Both</option>
                    </select>
                </div>

                <!-- Filter Status -->
                <div class="w-full">
                    <select 
                        wire:model.live="selectedStatus"
                        class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="">All Status</option>
                        <option value="Running">Running</option>
                        <option value="Maintenance">Maintenance</option>
                        <option value="No Schedule">No Schedule</option>
                        <option value="Trouble">Trouble</option>
                    </select>
                </div>

                <!-- Add New Button -->
                <div class="w-full">
                    @can('create master line')
                    <flux:button 
                        variant="primary" 
                        icon="plus" 
                        class="bg-blue-600 hover:bg-blue-700 whitespace-nowrap w-full justify-center"
                        wire:click="resetForm"
                        x-on:click="$dispatch('open-modal', 'line-form-modal')"
                    >
                        Add New Line
                    </flux:button>
                    @endcan
                </div>
            </div>

            <!-- Lines Table -->
            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Line Number</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[200px]">Location / Area</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Machine Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">PIC</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">Total Machines</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($lines as $index => $line)
                                <td class="px-4 py-3">
                                    <div class="min-w-0">
                                        <span class="text-sm font-semibold text-zinc-800 dark:text-white block truncate max-w-[300px]" title="{{ $line->line_number }}">
                                                {{ $line->line_number }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div>
                                        <div class="text-sm font-medium text-zinc-800 dark:text-white">
                                            {{ $line->location->location_name ?? 'N/A' }}
                                        </div>
                                        <div class="text-xs text-zinc-500">
                                            {{ $line->location->area->area_name ?? 'N/A' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $machineTypeColors = [
                                            'fuji' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                            'panasonic' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $machineTypeColors[$line->machine_type] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($line->machine_type) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusColors = [
                                            'Running' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                            'Maintenance' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                            'No Schedule' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                            'Trouble' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$line->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $line->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm">
                                        <div class="font-medium text-zinc-800 dark:text-white">
                                            {{ $line->employee->name ?? 'Not Assigned' }}
                                        </div>
                                        <div class="text-xs text-zinc-500">
                                            NIK: {{ $line->nik ?? '-' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <flux:icon name="computer-desktop" class="w-4 h-4 text-purple-500" />
                                        <span class="text-sm font-semibold text-zinc-800 dark:text-white">
                                            {{ $line->machines()->count() }}
                                        </span>
                                        <span class="text-xs text-zinc-500">Machines</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                        @can('view master line')
                                        <flux:button 
                                            wire:click="edit({{ $line->id }})" 
                                            x-on:click="$dispatch('open-modal', 'line-form-modal')"
                                            size="sm"
                                            icon="eye"
                                            variant="primary"
                                            color="blue"
                                            class="!p-2 flex-shrink-0"
                                            title="View line"
                                        />
                                        @endcan

                                        @can('edit master line')
                                        <flux:button 
                                            wire:click="edit({{ $line->id }})" 
                                            x-on:click="$dispatch('open-modal', 'line-form-modal')"
                                            size="sm"
                                            icon="pencil-square"
                                            variant="primary"
                                            color="yellow"
                                            class="!p-2 flex-shrink-0"
                                            title="Edit line"
                                        />
                                        @endcan

                                        @can('delete master line')
                                            <flux:button 
                                                wire:click="confirmDelete({{ $line->id }})" 
                                                x-on:click="$dispatch('open-modal', 'delete-line-modal')"
                                                size="sm"
                                                icon="trash"
                                                variant="primary"
                                                color="red"
                                                class="!p-2 flex-shrink-0"
                                                title="Delete line"
                                            />
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <flux:icon name="queue-list" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No line records found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                                {{ $search || $selectedLocation || $selectedMachineType || $selectedStatus ? 'Try adjusting your search or filter' : 'Get started by creating a new line record' }}
                                            </p>
                                        </div>
                                        @if($search || $selectedLocation || $selectedMachineType || $selectedStatus)
                                            <div class="flex gap-2 flex-wrap justify-center">
                                                @if($search)
                                                    <flux:button wire:click="$set('search', '')" size="sm">
                                                        Clear Search
                                                    </flux:button>
                                                @endif
                                                @if($selectedLocation)
                                                    <flux:button wire:click="$set('selectedLocation', '')" size="sm">
                                                        Clear Location
                                                    </flux:button>
                                                @endif
                                                @if($selectedMachineType)
                                                    <flux:button wire:click="$set('selectedMachineType', '')" size="sm">
                                                        Clear Machine Type
                                                    </flux:button>
                                                @endif
                                                @if($selectedStatus)
                                                    <flux:button wire:click="$set('selectedStatus', '')" size="sm">
                                                        Clear Status
                                                    </flux:button>
                                                @endif
                                            </div>
                                        @else
                                            @can('create master line')
                                            <flux:button 
                                                variant="primary" 
                                                size="sm"
                                                wire:click="resetForm"
                                                x-on:click="$dispatch('open-modal', 'line-form-modal')"
                                            >
                                                Add Your First Line
                                            </flux:button>
                                            @endcan
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($lines->hasPages())
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $lines->links() }}
                </div>
                @endif
            </flux:card>

            <!-- MODAL FORM LINE -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-modal.window="if ($event.detail === 'line-form-modal') open = true"
                 @close-modal.window="if ($event.detail === 'line-form-modal') open = false"
                 x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                            <form wire:submit="save">
                                <!-- Location -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Location <span class="text-red-500">*</span></label>
                                    <select wire:model="location_id"
                                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">Select Location</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}">
                                                {{ $location->location_name }} ({{ $location->area->area_name ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('location_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Line Number -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Line Number <span class="text-red-500">*</span></label>
                                    <input type="text" 
                                           wire:model="line_number"
                                           class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Enter line number">
                                    @error('line_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Machine Type -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Machine Type <span class="text-red-500">*</span></label>
                                    <select wire:model="machine_type"
                                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="fuji">Fuji</option>
                                        <option value="panasonic">Panasonic</option>
                                        <option value="both">Both</option>
                                    </select>
                                    @error('machine_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Status -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Status <span class="text-red-500">*</span></label>
                                    <select wire:model="status"
                                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Maintenance">Maintenance</option>
                                        <option value="Breakdown">Breakdown</option>
                                    </select>
                                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- PIC (Employee) -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">PIC (Person In Charge)</label>
                                    <select wire:model="nik"
                                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->ID }}">
                                                {{ $employee->NAMA }} ({{ $employee->ID }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nik') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Trouble Description -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Trouble Description</label>
                                    <textarea 
                                        wire:model="trouble_desc"
                                        rows="3"
                                        class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Enter trouble description if any"></textarea>
                                    @error('trouble_desc') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Buttons -->
                                <div class="flex justify-end gap-2 mt-6">
                                    <button type="button" 
                                            @click="open = false"
                                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                                        Cancel
                                    </button>
                                    <button type="submit" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        {{ $line_id ? 'Update' : 'Create' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL DELETE -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-modal.window="if ($event.detail === 'delete-line-modal') open = true"
                 @close-modal.window="if ($event.detail === 'delete-line-modal') open = false"
                 x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>

                        <h3 class="text-lg font-bold mb-2">Delete Line</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-2">
                            Are you sure you want to delete line <strong>"{{ $lineToDelete?->line_number }}"</strong>?
                        </p>
                        @if($lineToDelete && $lineToDelete->machines_count > 0)
                            <p class="text-yellow-600 dark:text-yellow-400 text-sm mb-4">
                                ⚠️ Warning: This line has {{ $lineToDelete->machines_count }} machine(s) associated with it.
                            </p>
                        @else
                            <p class="text-gray-600 dark:text-gray-400 mb-6">
                                This action cannot be undone.
                            </p>
                        @endif

                        <div class="flex justify-center gap-3">
                            <button @click="open = false" 
                                    class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800">
                                Cancel
                            </button>
                            <button wire:click="delete" 
                                    @click="open = false"
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                Yes, Delete
                            </button>
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
        </div>
    </x-mtc.layout>
</section>