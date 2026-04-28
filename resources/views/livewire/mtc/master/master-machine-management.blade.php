<section class="w-full">

    <flux:heading class="sr-only">
        {{ __('MTC - Master Machine Management') }}
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
                        Machine
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                    Master Machine
                </h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    Manage Machine master data for MTC
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
                        placeholder="Search by name, serial, maker, model..."
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

                <!-- Filter Line -->
                <div class="w-full">
                    <select 
                        wire:model.live="selectedLine"
                        class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="">All Lines</option>
                        @foreach($allLines as $line)
                            <option value="{{ $line->id }}">
                                {{ $line->line_number }} ({{ $line->location->location_name ?? 'N/A' }})
                            </option>
                        @endforeach
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
                        <option value="Offline">Offline</option>
                    </select>
                </div>

                <!-- Add New Button -->
                <div class="w-full">
                    @can('create master machine')
                    <flux:button 
                        variant="primary" 
                        icon="plus" 
                        class="bg-blue-600 hover:bg-blue-700 whitespace-nowrap w-full justify-center"
                        wire:click="resetForm"
                        x-on:click="$dispatch('open-modal', 'machine-form-modal')"
                    >
                        Add New Machine
                    </flux:button>
                    @endcan
                </div>
            </div>

            <!-- Machines Table -->
            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-16">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Machine Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Serial Number</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Location / Line</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Maker</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Model Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Created By</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($machines as $index => $machine)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="machine-{{ $machine->id }}">
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $machines->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center text-white font-medium shadow-lg flex-shrink-0">
                                            {{ strtoupper(substr($machine->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <span class="text-sm font-semibold text-zinc-800 dark:text-white block truncate max-w-[200px]" title="{{ $machine->name }}">
                                                {{ $machine->name }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm font-mono text-zinc-700 dark:text-zinc-300">
                                        {{ $machine->serial_no }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div>
                                        <div class="text-sm font-medium text-zinc-800 dark:text-white">
                                            {{ $machine->location->location_name ?? 'N/A' }}
                                        </div>
                                        <div class="text-xs text-zinc-500">
                                            Line: {{ $machine->line->line_number ?? '-' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $machine->maker }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $machine->model_type ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusColors = [
                                            'Running' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                            'Maintenance' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                            'Offline' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$machine->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $machine->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm">
                                        <div class="font-medium text-zinc-800 dark:text-white truncate max-w-[150px]" title="{{ $machine->creator->name ?? 'N/A' }}">
                                            {{ $machine->creator->name ?? 'N/A' }}
                                        </div>
                                        <div class="text-xs text-zinc-500">
                                            {{ $machine->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                        @can('view master machine')
                                        <flux:button 
                                            wire:click="edit({{ $machine->id }})" 
                                            x-on:click="$dispatch('open-modal', 'machine-form-modal')"
                                            size="sm"
                                            icon="eye"
                                            variant="primary"
                                            color="blue"
                                            class="!p-2 flex-shrink-0"
                                            title="View machine"
                                        />
                                        @endcan

                                        @can('edit master machine')
                                        <flux:button 
                                            wire:click="edit({{ $machine->id }})" 
                                            x-on:click="$dispatch('open-modal', 'machine-form-modal')"
                                            size="sm"
                                            icon="pencil-square"
                                            variant="primary"
                                            color="yellow"
                                            class="!p-2 flex-shrink-0"
                                            title="Edit machine"
                                        />
                                        @endcan

                                        @can('delete master machine')
                                            <flux:button 
                                                wire:click="confirmDelete({{ $machine->id }})" 
                                                x-on:click="$dispatch('open-modal', 'delete-machine-modal')"
                                                size="sm"
                                                icon="trash"
                                                variant="primary"
                                                color="red"
                                                class="!p-2 flex-shrink-0"
                                                title="Delete machine"
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
                                            <flux:icon name="computer-desktop" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No machine records found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                                {{ $search || $selectedLocation || $selectedLine || $selectedStatus ? 'Try adjusting your search or filter' : 'Get started by creating a new machine record' }}
                                            </p>
                                        </div>
                                        @if($search || $selectedLocation || $selectedLine || $selectedStatus)
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
                                                @if($selectedLine)
                                                    <flux:button wire:click="$set('selectedLine', '')" size="sm">
                                                        Clear Line
                                                    </flux:button>
                                                @endif
                                                @if($selectedStatus)
                                                    <flux:button wire:click="$set('selectedStatus', '')" size="sm">
                                                        Clear Status
                                                    </flux:button>
                                                @endif
                                            </div>
                                        @else
                                            @can('create master machine')
                                            <flux:button 
                                                variant="primary" 
                                                size="sm"
                                                wire:click="resetForm"
                                                x-on:click="$dispatch('open-modal', 'machine-form-modal')"
                                            >
                                                Add Your First Machine
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
                @if($machines->hasPages())
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $machines->links() }}
                </div>
                @endif
            </flux:card>

            <!-- MODAL FORM MACHINE -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-modal.window="if ($event.detail === 'machine-form-modal') open = true"
                 @close-modal.window="if ($event.detail === 'machine-form-modal') open = false"
                 x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-5xl max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                            <form wire:submit="save">
                                <!-- Grid Layout 12 columns -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    
                                    <!-- Left Column: Machine Details -->
                                    <div class="bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-4">
                                        <h3 class="text-lg font-semibold mb-4 text-zinc-800 dark:text-white">Machine Details</h3>
                                        
                                        <div class="space-y-4">
                                            <!-- Location -->
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Location <span class="text-red-500">*</span></label>
                                                <select wire:model.live="location_id"
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

                                            <!-- Line (Dynamic based on Location) -->
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Line</label>
                                                <select wire:model="line_id"
                                                        class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                    <option value="">Select Line</option>
                                                    @foreach($this->lines as $line)
                                                        <option value="{{ $line->id }}">
                                                            {{ $line->line_number }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('line_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <!-- Machine Name -->
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Machine Name <span class="text-red-500">*</span></label>
                                                <input type="text" 
                                                       wire:model="name"
                                                       class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                       placeholder="Enter machine name">
                                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <!-- Model Type -->
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Model Type</label>
                                                <input type="text" 
                                                       wire:model="model_type"
                                                       class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                       placeholder="Enter model type">
                                                @error('model_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column: Machine Information -->
                                    <div class="bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-4">
                                        <h3 class="text-lg font-semibold mb-4 text-zinc-800 dark:text-white">Machine Information</h3>
                                        
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <!-- MFG Date -->
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Manufacturing Date</label>
                                                <input type="date" 
                                                       wire:model="mfg_date"
                                                       class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                @error('mfg_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <!-- Maker -->
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Maker <span class="text-red-500">*</span></label>
                                                <input type="text" 
                                                       wire:model="maker"
                                                       class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                       placeholder="Enter maker name">
                                                @error('maker') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <!-- Serial Number -->
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Serial Number <span class="text-red-500">*</span></label>
                                                <input type="text" 
                                                       wire:model="serial_no"
                                                       class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                       placeholder="Enter serial number">
                                                @error('serial_no') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <!-- Power Voltage -->
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Power Voltage</label>
                                                <input type="text" 
                                                       wire:model="power_voltage"
                                                       class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                       placeholder="e.g., 220V, 380V">
                                                @error('power_voltage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <!-- Power Amper -->
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Power Amper</label>
                                                <input type="text" 
                                                       wire:model="power_amper"
                                                       class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                       placeholder="e.g., 10A, 20A">
                                                @error('power_amper') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <!-- Number of Phases -->
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Number of Phases</label>
                                                <select wire:model="no_of_phases"
                                                        class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                    <option value="">Select Phases</option>
                                                    <option value="1">1 Phase</option>
                                                    <option value="2">2 Phase</option>
                                                    <option value="3">3 Phase</option>
                                                </select>
                                                @error('no_of_phases') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <!-- Air Supply -->
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Air Supply</label>
                                                <input type="text" 
                                                       wire:model="air_supply"
                                                       class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                       placeholder="e.g., 6 bar, 8 bar">
                                                @error('air_supply') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <!-- N2 Supply -->
                                            <div>
                                                <label class="block text-sm font-medium mb-1">N2 Supply</label>
                                                <input type="text" 
                                                       wire:model="n2_supply"
                                                       class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                       placeholder="e.g., 5 bar, 7 bar">
                                                @error('n2_supply') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Section (Full Width) -->
                                <div class="mt-6 bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-4">
                                    <h3 class="text-lg font-semibold mb-4 text-zinc-800 dark:text-white">Machine Status</h3>
                                    
                                    <div class="flex flex-wrap gap-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="status" value="Running" class="w-4 h-4 text-green-600 focus:ring-green-500">
                                            <span class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">Running</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="status" value="Maintenance" class="w-4 h-4 text-yellow-600 focus:ring-yellow-500">
                                            <span class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">Maintenance</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="status" value="Offline" class="w-4 h-4 text-red-600 focus:ring-red-500">
                                            <span class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">Offline</span>
                                        </label>
                                    </div>
                                    @error('status') <span class="text-red-500 text-sm block mt-2">{{ $message }}</span> @enderror
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
                                        {{ $machine_id ? 'Update' : 'Create' }}
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
                 @open-modal.window="if ($event.detail === 'delete-machine-modal') open = true"
                 @close-modal.window="if ($event.detail === 'delete-machine-modal') open = false"
                 x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>

                        <h3 class="text-lg font-bold mb-2">Delete Machine</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Are you sure you want to delete machine <strong>"{{ $machineToDelete?->name }}"</strong>?<br>
                            This action cannot be undone.
                        </p>

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