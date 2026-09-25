<section class="w-full">

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
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none bg-[url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"gray\" class=\"w-4 h-4\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"m19.5 8.25-7.5 7.5-7.5-7.5\" /></svg>')] bg-[length:1.25rem] bg-[position:left_0.75rem_center] bg-no-repeat pl-8"
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
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none bg-[url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"gray\" class=\"w-4 h-4\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"m19.5 8.25-7.5 7.5-7.5-7.5\" /></svg>')] bg-[length:1.25rem] bg-[position:left_0.75rem_center] bg-no-repeat pl-8"
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
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none bg-[url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"gray\" class=\"w-4 h-4\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"m19.5 8.25-7.5 7.5-7.5-7.5\" /></svg>')] bg-[length:1.25rem] bg-[position:left_0.75rem_center] bg-no-repeat pl-8"
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
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Line #</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[200px]">Location / Area</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Daily Type</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Status</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Daily Check</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Approval</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[80px]">Group</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Last Check</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-32">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($lines as $index => $line)
                            @php
                                // Get latest daily inspection based on machine type
                                $latestDaily = null;
                                $dailyCheckStatus = 'No Check';
                                $dailyCheckApproval = 'No Check';
                                $dailyCheckGroup = '-';
                                $dailyCheckLastUpdate = '-';
                                
                                if ($line->machine_type === 'fuji') {
                                    $latestDaily = $line->dailyFujis()->latest()->first();
                                    if ($latestDaily) {
                                        $dailyCheckStatus = $latestDaily->status ?? 'No Check';
                                        $dailyCheckApproval = $latestDaily->approval ?? 'No Check';
                                        $dailyCheckGroup = $latestDaily->group ?? '-';
                                        $dailyCheckLastUpdate = $latestDaily->updated_at ? $latestDaily->updated_at->format('d M Y H:i') : '-';
                                    }
                                } elseif ($line->machine_type === 'panasonic') {
                                    $latestDaily = $line->dailyPanasonics()->latest()->first();
                                    if ($latestDaily) {
                                        $dailyCheckStatus = $latestDaily->status ?? 'No Check';
                                        $dailyCheckApproval = $latestDaily->approval ?? 'No Check';
                                        $dailyCheckGroup = $latestDaily->group ?? '-';
                                        $dailyCheckLastUpdate = $latestDaily->updated_at ? $latestDaily->updated_at->format('d M Y H:i') : '-';
                                    }
                                } elseif ($line->machine_type === 'both') {
                                    // For both, get the latest from either fuji or panasonic
                                    $latestFuji = $line->dailyFujis()->latest()->first();
                                    $latestPanasonic = $line->dailyPanasonics()->latest()->first();
                                    
                                    if ($latestFuji && $latestPanasonic) {
                                        $latestDaily = $latestFuji->updated_at > $latestPanasonic->updated_at ? $latestFuji : $latestPanasonic;
                                    } elseif ($latestFuji) {
                                        $latestDaily = $latestFuji;
                                    } elseif ($latestPanasonic) {
                                        $latestDaily = $latestPanasonic;
                                    }
                                    
                                    if ($latestDaily) {
                                        $dailyCheckStatus = $latestDaily->status ?? 'No Check';
                                        $dailyCheckApproval = $latestDaily->approval ?? 'No Check';
                                        $dailyCheckGroup = $latestDaily->group ?? '-';
                                        $dailyCheckLastUpdate = $latestDaily->updated_at ? $latestDaily->updated_at->format('d M Y H:i') : '-';
                                    }
                                }
                                
                                // Status color classes
                                $statusColors = [
                                    'Running' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                    'Maintenance' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                    'No Schedule' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                    'Trouble' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                ];
                                
                                $machineTypeColors = [
                                    'fuji' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                    'panasonic' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                    'both' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                ];
                                
                                $dailyCheckColors = [
                                    'Checked' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                    'On Progress' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                    'Delay' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                    'Holiday' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
                                    'No Check' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
                                ];
                                
                                $approvalColors = [
                                    'Approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                    'Rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                    'Pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                    'No Check' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
                                ];
                            @endphp
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-4 py-3 text-center">
                                    <div class="min-w-0">
                                        <span class="text-sm font-semibold text-zinc-800 dark:text-white block truncate max-w-[300px]" title="{{ $line->line_number }}">
                                            {{ $line->line_number }}
                                        </span>
                                    </div>
                                </td>
                                
                                <td class="px-4 py-3 text-center">
                                    <div>
                                        <div class="text-sm font-medium text-zinc-800 dark:text-white">
                                            {{ $line->location->location_name ?? 'N/A' }}
                                        </div>
                                        <div class="text-xs text-zinc-500">
                                            {{ $line->location->area->area_name ?? 'N/A' }}
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $machineTypeColors[$line->machine_type] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($line->machine_type) }}
                                    </span>
                                </td>
                                
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$line->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $line->status }}
                                    </span>
                                </td>
                                
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $dailyCheckColors[$dailyCheckStatus] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $dailyCheckStatus }}
                                    </span>
                                </td>
                                
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $approvalColors[$dailyCheckApproval] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $dailyCheckApproval }}
                                    </span>
                                </td>
                                
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 font-semibold text-sm">
                                        {{ $dailyCheckGroup }}
                                    </span>
                                </td>
                                
                                <td class="px-4 py-3 text-center">
                                    <div class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $dailyCheckLastUpdate }}
                                    </div>
                                </td>
                                
                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center gap-1 whitespace-nowrap">
                                        @can('view master line')
                                        <flux:tooltip content="View line details" position="top">
                                            <flux:button 
                                                href="{{ route('mtc.master-lines.show', $line->id) }}"
                                                wire:navigate
                                                size="sm"
                                                icon="eye"
                                                variant="primary"
                                                color="blue"
                                                class="!p-2 flex-shrink-0"
                                            />
                                        </flux:tooltip>
                                        @endcan

                                        @can('edit master line')
                                        <flux:tooltip content="Edit line" position="top">
                                            <flux:button 
                                                wire:click="edit({{ $line->id }})" 
                                                x-on:click="$dispatch('open-modal', 'line-form-modal')"
                                                size="sm"
                                                icon="pencil-square"
                                                variant="primary"
                                                color="amber"
                                                class="!p-2 flex-shrink-0"
                                            />
                                        </flux:tooltip>
                                        @endcan

                                        <!-- Quick Status Update Button -->
                                        <flux:tooltip content="Quick status update" position="top">
                                            <flux:button 
                                                wire:click="quickStatusUpdate({{ $line->id }})"
                                                size="sm"
                                                icon="arrow-path"
                                                variant="primary"
                                                color="green"
                                                class="!p-2 flex-shrink-0"
                                            />
                                        </flux:tooltip>

                                        <!-- Change Machine Type Button -->
                                        <flux:tooltip content="Change machine type" position="top">
                                            <flux:button 
                                                wire:click="changeMachineType({{ $line->id }})"
                                                size="sm"
                                                icon="arrows-right-left"
                                                variant="primary"
                                                color="cyan"
                                                class="!p-2 flex-shrink-0"
                                            />
                                        </flux:tooltip>

                                        <!-- Configure Standard Button - ONLY FOR FUJI -->
                                        @can('edit master line')
                                            @if($line->machine_type === 'fuji')
                                            <flux:tooltip content="Configure Fuji standard check" position="top">
                                                <flux:button 
                                                    wire:click="configureStandard({{ $line->id }})"
                                                    size="sm"
                                                    icon="cog-6-tooth"
                                                    variant="primary"
                                                    color="purple"
                                                    class="!p-2 flex-shrink-0"
                                                />
                                            </flux:tooltip>
                                            @endif
                                        @endcan

                                        <!-- Configure Standard Button - FOR PANASONIC -->
                                        @can('edit master line')
                                            @if($line->machine_type === 'panasonic')
                                            <flux:tooltip content="Configure Panasonic standard check" position="top">
                                                <flux:button 
                                                    wire:click="configurePanasonicStandard({{ $line->id }})"
                                                    size="sm"
                                                    icon="cog-6-tooth"
                                                    variant="primary"
                                                    color="blue"
                                                    class="!p-2 flex-shrink-0"
                                                />
                                            </flux:tooltip>
                                            @endif
                                        @endcan

                                        <!-- History Button -->
                                        <flux:tooltip content="View configuration history" position="top">
                                            <flux:button 
                                                wire:click="viewStandardHistory({{ $line->id }}, '{{ $line->machine_type }}')"
                                                size="sm"
                                                icon="clock"
                                                variant="primary"
                                                color="indigo"
                                                class="!p-2 flex-shrink-0"
                                            />
                                        </flux:tooltip>

                                        @can('delete master line')
                                        <flux:tooltip content="Delete line" position="top">
                                            <flux:button 
                                                wire:click="confirmDelete({{ $line->id }})" 
                                                x-on:click="$dispatch('open-modal', 'delete-line-modal')"
                                                size="sm"
                                                icon="trash"
                                                variant="primary"
                                                color="red"
                                                class="!p-2 flex-shrink-0"
                                            />
                                        </flux:tooltip>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="px-4 py-12 text-center">
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

            <!-- Change Machine Type Modal (Alpine.js version) -->
            <div x-data="{ open: false }" 
                x-show="open" 
                @open-change-machine-modal.window="open = true; $wire.set('modalTitle', 'Change Machine Type')"
                @close-change-machine-modal.window="open = false"
                x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                        <div class="p-6">
                            <div class="flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700 pb-3 mb-4">
                                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                                    Change Machine Type
                                </h3>
                                <button @click="open = false" class="text-zinc-500 hover:text-zinc-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="space-y-4">
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                    Changing machine type will affect available daily inspection forms.
                                </p>
                                
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                        Machine Type <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        wire:model="machine_type"
                                        class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500"
                                    >
                                        <option value="fuji">Fuji</option>
                                        <option value="panasonic">Panasonic</option>
                                    </select>
                                    @error('machine_type') 
                                        <span class="text-xs text-red-600 mt-1">{{ $message }}</span> 
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="flex justify-end gap-2 pt-4 mt-4 border-t border-zinc-200 dark:border-zinc-700">
                                <button @click="open = false" 
                                        class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                                    Cancel
                                </button>
                                <button wire:click="saveMachineType" 
                                        @click="open = false"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Update Machine Type
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Status Update Modal (Alpine.js version) -->
            <div x-data="{ open: false }" 
                x-show="open" 
                @open-quick-status-modal.window="open = true; $wire.set('modalTitle', 'Quick Status Update')"
                @close-quick-status-modal.window="open = false"
                x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                        <div class="p-6">
                            <div class="flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700 pb-3 mb-4">
                                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                                    Quick Status Update
                                </h3>
                                <button @click="open = false" class="text-zinc-500 hover:text-zinc-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        wire:model.live="status"
                                        class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm focus:ring-2 focus:ring-green-500"
                                    >
                                        <option value="Running">Running</option>
                                        <option value="Maintenance">Maintenance</option>
                                        <option value="No Schedule">No Schedule</option>
                                        <option value="Trouble">Trouble</option>
                                    </select>
                                    @error('status') 
                                        <span class="text-xs text-red-600 mt-1">{{ $message }}</span> 
                                    @enderror
                                </div>
                                
                                <div x-show="$wire.get('status') === 'Trouble'" x-cloak>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                        Trouble Description
                                    </label>
                                    <textarea 
                                        wire:model="trouble_desc"
                                        rows="3"
                                        class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm focus:ring-2 focus:ring-red-500"
                                        placeholder="Brief description of the issue..."
                                    ></textarea>
                                    @error('trouble_desc') 
                                        <span class="text-xs text-red-600 mt-1">{{ $message }}</span> 
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="flex justify-end gap-2 pt-4 mt-4 border-t border-zinc-200 dark:border-zinc-700">
                                <button @click="open = false" 
                                        class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                                    Cancel
                                </button>
                                <button wire:click="saveQuickStatus" 
                                        @click="open = false"
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    Update Status
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STANDARD CONFIGURATION MODAL - FUJI (REDESIGNED TO MATCH PANASONIC) -->
            <div x-data="{ 
                    open: false, 
                    activeStep: 0,
                    steps: [
                        { id: 0, name: 'GENERAL' },
                        { id: 1, name: 'LOADER' },
                        { id: 2, name: 'PCB CLEANER' },
                        { id: 3, name: 'PRINTING' },
                        { id: 4, name: 'SPI' },
                        { id: 5, name: 'CHIP MOUNTER 1' },
                        { id: 6, name: 'CHIP MOUNTER 2' },
                        { id: 7, name: 'REFLOW' },
                        { id: 8, name: 'AOI' },
                        { id: 9, name: 'UNLOADER' },
                        { id: 10, name: 'AOI TABLE' },
                        { id: 11, name: 'REFLOW 2' },
                        { id: 12, name: 'CHIP MOUNTER 3' },
                        { id: 13, name: 'CHIP MOUNTER 4' },
                        { id: 14, name: 'SPI 2' },
                        { id: 15, name: 'PRINTER' },
                        { id: 16, name: 'PCB CLEANER 2' },
                        { id: 17, name: 'IONIZER' }
                    ]
                }" 
                x-show="open" 
                @open-standard-modal.window="open = true; activeStep = 0"
                @close-standard-modal.window="open = false"
                x-cloak>

                <!-- Overlay -->
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40" @click="open = false"></div>

                <!-- Modal -->
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-5xl max-h-[95vh] overflow-hidden border border-zinc-200 dark:border-zinc-700">
                        
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-5">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-white">
                                            Configure Standard Check
                                        </h3>
                                        <p class="text-sm text-purple-100">
                                            {{ $selectedLineForStandard?->line_number }} - Select required fields for Daily Fuji
                                        </p>
                                    </div>
                                </div>
                                <button @click="open = false" class="text-white/80 hover:text-white transition-colors p-2 hover:bg-white/10 rounded-xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700 flex flex-wrap items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Quick Actions:</span>
                                <button type="button" 
                                        wire:click="setAllRequired(true)"
                                        class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-200 shadow-sm hover:shadow">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    All Required
                                </button>
                                <button type="button" 
                                        wire:click="setAllRequired(false)"
                                        class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-zinc-500 hover:bg-zinc-600 text-white rounded-lg transition-all duration-200 shadow-sm hover:shadow">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                    All Optional
                                </button>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span><span class="font-medium text-zinc-700 dark:text-zinc-300">{{ count(array_filter($standardConfig)) }}</span> fields required</span>
                            </div>
                        </div>

                        <!-- Content Area -->
                        <div class="flex h-[calc(90vh-280px)]">
                            <!-- Sidebar Steps -->
                            <div class="w-48 bg-zinc-50 dark:bg-zinc-800/30 border-r border-zinc-200 dark:border-zinc-700 overflow-y-auto flex-shrink-0 p-2 scrollbar-hide hover:scrollbar-show">
                                <template x-for="(step, index) in steps" :key="index">
                                    <button 
                                        type="button"
                                        @click="activeStep = index"
                                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 mb-1"
                                        :class="{
                                            'bg-purple-600 text-white shadow-lg shadow-purple-600/20': activeStep === index,
                                            'hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-600 dark:text-zinc-400': activeStep !== index
                                        }"
                                    >
                                        <span class="w-6 h-6 flex items-center justify-center rounded-lg text-xs font-bold"
                                            :class="{
                                                'bg-white/20 text-white': activeStep === index,
                                                'bg-zinc-200 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400': activeStep !== index
                                            }"
                                            x-text="step.id + 1">
                                        </span>
                                        <span x-text="step.name" class="truncate"></span>
                                    </button>
                                </template>
                            </div>

                            <!-- Fields Content -->
                            <div class="flex-1 overflow-y-auto p-6 bg-white dark:bg-zinc-900">
                                <form wire:submit="saveStandardConfig" id="standardForm">
                                    
                                    <!-- STEP 1: GENERAL -->
                                    <div x-show="activeStep === 0" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center text-sm font-bold">1</span>
                                                GENERAL
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">General inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['body_cover_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.body_cover_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Body Cover</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Make sure all machine cover clean</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['body_cover_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['body_cover_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['lamp_alarm_change_model_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.lamp_alarm_change_model_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Lamp Alarm & Change Model</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Make sure lamp Alarm & Change Model clean</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['lamp_alarm_change_model_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['lamp_alarm_change_model_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 2: LOADER -->
                                    <div x-show="activeStep === 1" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center text-sm font-bold">2</span>
                                                LOADER
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Loader inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['cylinder_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.cylinder_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cylinder (1)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Operation And center - Smooth and center</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['cylinder_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['cylinder_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['rail_and_magazine_pcb_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.rail_and_magazine_pcb_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Rail & Magazine PCB (1.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Cleaning Dust and dirty - No Dust and clean</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['rail_and_magazine_pcb_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['rail_and_magazine_pcb_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['cover_magazine_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.cover_magazine_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cover Magazine (1.b)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Cleaning Dust and dirty - No Dust and clean</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['cover_magazine_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['cover_magazine_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 3: PCB CLEANER -->
                                    <div x-show="activeStep === 2" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center text-sm font-bold">3</span>
                                                PCB CLEANER
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">PCB Cleaner inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['brush_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.brush_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Brush (2)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Cleaning touch PCB - Rotation</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['brush_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['brush_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['air_presure_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.air_presure_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure (2.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">0.45 - 0.54 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['air_presure_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['air_presure_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['vacume_presure_unitech_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.vacume_presure_unitech_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vacume Pressure Unitech (2.b)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">0.45 - 0.54 Mpa (Unitech)</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['vacume_presure_unitech_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['vacume_presure_unitech_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['vacume_presure_nix_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.vacume_presure_nix_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vacume Pressure Nix (2.c)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">0.60 - 0.70 Mpa (N.I.X)</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['vacume_presure_nix_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['vacume_presure_nix_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['vacume_brush_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.vacume_brush_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vacume Brush (3)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Operation - Rotation</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['vacume_brush_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['vacume_brush_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['cleaning_roller_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.cleaning_roller_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cleaning Roller (4)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Smooth rotation & Clean</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['cleaning_roller_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['cleaning_roller_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['ionizer_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.ionizer_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Ionizer (5)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">5 Times to push cleaner</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['ionizer_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['ionizer_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>

                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['ionizer_air_presure_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.ionizer_air_presure_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure Ionizer (5.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check With Pressure Meter - 0.05-0.10 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['ionizer_air_presure_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['ionizer_air_presure_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['conveyor_speed_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.conveyor_speed_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Conveyor Setting (6)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Analog panel - ≤ 40</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['conveyor_speed_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['conveyor_speed_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 4: PRINTING -->
                                    <div x-show="activeStep === 3" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center text-sm font-bold">4</span>
                                                PRINTING
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Printing inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['ipa_solvent_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.ipa_solvent_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">IPA Solvent (7)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Tank Minimal half</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['ipa_solvent_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['ipa_solvent_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['temperature_control_1_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.temperature_control_1_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Temperature Control (8)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Result-01 - 23-27℃</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['temperature_control_1_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['temperature_control_1_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['humidity_control_1_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.humidity_control_1_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Humidity Control (8.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Result-01 - 35-70%</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['humidity_control_1_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['humidity_control_1_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['clamp_presure_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.clamp_presure_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Clamp Pressure (9)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">0.20 - 0.4 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['clamp_presure_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['clamp_presure_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['squeege_upper_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.squeege_upper_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Squeege Upper (10)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">0.12 ± 0.01 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['squeege_upper_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['squeege_upper_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['cleaning_solvent_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.cleaning_solvent_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cleaning Solvent (11)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">0.20 ± 0.01 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['cleaning_solvent_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['cleaning_solvent_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['air_presure_meter_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.air_presure_meter_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure Meter (12)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">0.50 - 0.55 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['air_presure_meter_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['air_presure_meter_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 5: SPI -->
                                    <div x-show="activeStep === 4" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center text-sm font-bold">5</span>
                                                SPI
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">SPI inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['air_presure_meter_parmi_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.air_presure_meter_parmi_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure Meter Parmi (12.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">0.40 - 0.50 Mpa (PARMI)</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['air_presure_meter_parmi_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['air_presure_meter_parmi_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['capability_index_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.capability_index_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Capability Index (12.b)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">CpK for Masspro > 1.33</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['capability_index_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['capability_index_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 6: CHIP MOUNTER 1 -->
                                    <div x-show="activeStep === 5" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center text-sm font-bold">6</span>
                                                CHIP MOUNTER 1
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Chip Mounter 1 inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['air_presure_supply_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.air_presure_supply_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure Supply (13)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">0.49 - 0.54 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['air_presure_supply_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['air_presure_supply_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['vaccuum_pump_1_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.vaccuum_pump_1_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Pump (13.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">-87 to -100 Kpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['vaccuum_pump_1_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['vaccuum_pump_1_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['box_1_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.box_1_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Box (13.b)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">No components</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['box_1_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['box_1_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['vaccuum_parameter_1_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.vaccuum_parameter_1_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Parameter (13.c)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">No Yellow initial</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['vaccuum_parameter_1_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['vaccuum_parameter_1_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['expire_date_1_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.expire_date_1_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Expire Date (14)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">No Expired</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['expire_date_1_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['expire_date_1_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 7: CHIP MOUNTER 2 -->
                                    <div x-show="activeStep === 6" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center text-sm font-bold">7</span>
                                                CHIP MOUNTER 2
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Chip Mounter 2 inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['air_presure_supply_2_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.air_presure_supply_2_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure Supply (15)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">0.49 - 0.54 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['air_presure_supply_2_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['air_presure_supply_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['vaccuum_pump_2_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.vaccuum_pump_2_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Pump (15.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">-87 to -100 Kpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['vaccuum_pump_2_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['vaccuum_pump_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['box_2_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.box_2_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Box (15.b)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">No components</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['box_2_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['box_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['vaccuum_parameter_2_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.vaccuum_parameter_2_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Parameter (15.c)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">No Yellow initial</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['vaccuum_parameter_2_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['vaccuum_parameter_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['expire_date_2_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.expire_date_2_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Expire Date (16)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">No Expired</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['expire_date_2_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['expire_date_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 8: REFLOW -->
                                    <div x-show="activeStep === 7" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center text-sm font-bold">8</span>
                                                REFLOW
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Reflow inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['abandonment_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.abandonment_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Abandonment (17)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">No Damage</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['abandonment_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['abandonment_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['fire_posibilty_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.fire_posibilty_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Fire Possibility (17.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">No Paper, No plastic</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['fire_posibilty_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['fire_posibilty_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['flashlight_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.flashlight_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Flashlight (17.b)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">On/Off Check - Standard: On</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['flashlight_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['flashlight_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['rail_and_transfer_unit_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.rail_and_transfer_unit_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Rail & Transfer Unit (18)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">No jammed</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['rail_and_transfer_unit_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['rail_and_transfer_unit_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['n2_presure_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.n2_presure_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">N2 Pressure (19)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">0.4 - 0.5 MPa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['n2_presure_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['n2_presure_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['oxygent_density_sek_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.oxygent_density_sek_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Oxygen Density SEK (20)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">1200 - 1800 ppm</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['oxygent_density_sek_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['oxygent_density_sek_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['oxygent_density_special_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.oxygent_density_special_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Oxygen Density Special (20)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">500 - 1000 ppm</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['oxygent_density_special_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['oxygent_density_special_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['fire_posibilty_2_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.fire_posibilty_2_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Fire Possibility (20.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">No Paper, No plastic</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['fire_posibilty_2_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['fire_posibilty_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 9: AOI -->
                                    <div x-show="activeStep === 8" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center text-sm font-bold">9</span>
                                                AOI
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">AOI inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['air_presure_2_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.air_presure_2_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure (20.b)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">0.40 - 0.50 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['air_presure_2_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['air_presure_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 10: UNLOADER -->
                                    <div x-show="activeStep === 9" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center text-sm font-bold">10</span>
                                                UNLOADER
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Unloader inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['cylinder_2_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.cylinder_2_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cylinder (21)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Smooth and center</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['cylinder_2_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['cylinder_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['rail_and_magazine_pcb_2_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.rail_and_magazine_pcb_2_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Rail & Magazine PCB (21.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">No Dust and clean</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['rail_and_magazine_pcb_2_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['rail_and_magazine_pcb_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['cover_magazine_2_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.cover_magazine_2_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cover Magazine (21.b)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">No Dust and clean</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['cover_magazine_2_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['cover_magazine_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 11: AOI TABLE -->
                                    <div x-show="activeStep === 10" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center text-sm font-bold">11</span>
                                                AOI TABLE
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">AOI Table inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['angle_and_filter_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.angle_and_filter_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Angle & Filter (22)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">No dirt / no dust</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['angle_and_filter_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['angle_and_filter_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['lamp_indicator_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.lamp_indicator_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Lamp Indicator (22.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">LED Lamp (Green) - Function</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['lamp_indicator_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['lamp_indicator_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 12: REFLOW 2 -->
                                    <div x-show="activeStep === 11" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center text-sm font-bold">12</span>
                                                REFLOW 2
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Reflow 2 inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['temperature_chiller_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.temperature_chiller_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Temperature Chiller (23)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">17 - 23℃</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['temperature_chiller_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['temperature_chiller_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['temperature_control_3_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.temperature_control_3_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Temperature Control (24)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">300℃ ±10℃</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['temperature_control_3_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['temperature_control_3_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>

                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['n2_air_presure_valve_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.n2_air_presure_valve_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">N2 & Air Pressure (24.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Opening Valve - Position handle parallel</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['n2_air_presure_valve_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['n2_air_presure_valve_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 13: CHIP MOUNTER 3 -->
                                    <div x-show="activeStep === 12" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center text-sm font-bold">13</span>
                                                CHIP MOUNTER 3
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Chip Mounter 3 inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['fan_unit_1_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.fan_unit_1_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Fan Unit 1 (25)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Make sure all Fan clean</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['fan_unit_1_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['fan_unit_1_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 14: CHIP MOUNTER 4 -->
                                    <div x-show="activeStep === 13" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center text-sm font-bold">14</span>
                                                CHIP MOUNTER 4
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Chip Mounter 4 inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['fan_unit_2_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.fan_unit_2_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Fan Unit 2 (26)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Make sure all Fan clean</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['fan_unit_2_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['fan_unit_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 15: SPI 2 -->
                                    <div x-show="activeStep === 14" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center text-sm font-bold">15</span>
                                                SPI 2
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">SPI 2 inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['air_presure_3_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.air_presure_3_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure (27)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">0.40 - 0.50 Mpa (Kohyoung)</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['air_presure_3_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['air_presure_3_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 16: PRINTER -->
                                    <div x-show="activeStep === 15" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center text-sm font-bold">16</span>
                                                PRINTER
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Printer inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['temperature_control_4_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.temperature_control_4_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Temperature Control (28)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">23 - 27℃</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['temperature_control_4_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['temperature_control_4_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['water_reservoirs_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.water_reservoirs_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Water Reservoirs (28.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Function, No Damage</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['water_reservoirs_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['water_reservoirs_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 17: PCB CLEANER 2 -->
                                    <div x-show="activeStep === 16" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center text-sm font-bold">17</span>
                                                PCB CLEANER 2
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">PCB Cleaner 2 inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['filter_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.filter_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Filter (29)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Clean</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['filter_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['filter_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 18: IONIZER -->
                                    <div x-show="activeStep === 17" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center text-sm font-bold">18</span>
                                                IONIZER
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Ionizer inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-purple-300 dark:hover:border-purple-700 {{ $standardConfig['angle_and_filter_2_required'] ?? false ? 'border-purple-500 bg-purple-50 dark:bg-purple-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="standardConfig.angle_and_filter_2_required" class="w-4 h-4 text-purple-600 rounded border-zinc-300 focus:ring-purple-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Angle & Filter (30)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">No dirt / no dust</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $standardConfig['angle_and_filter_2_required'] ?? false ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $standardConfig['angle_and_filter_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Navigation Buttons -->
                                    <div class="flex justify-between mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                                        <button type="button" 
                                                @click="activeStep > 0 ? activeStep-- : null"
                                                class="px-4 py-2 text-sm font-medium rounded-xl border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors"
                                                :class="{'opacity-50 cursor-not-allowed': activeStep === 0}">
                                            ← Previous
                                        </button>
                                        <button type="button" 
                                                @click="activeStep < steps.length - 1 ? activeStep++ : null"
                                                class="px-4 py-2 text-sm font-medium rounded-xl bg-purple-600 hover:bg-purple-700 text-white transition-colors shadow-lg shadow-purple-600/20"
                                                :class="{'opacity-50 cursor-not-allowed': activeStep === steps.length - 1}">
                                            Next →
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-3">
                            <button type="button" 
                                    @click="open = false"
                                    class="px-4 py-2 text-sm font-medium rounded-xl border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    form="standardForm"
                                    class="flex items-center gap-2 px-6 py-2 text-sm font-medium rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white transition-all duration-200 shadow-lg shadow-purple-600/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                </svg>
                                Save Configuration
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANASONIC STANDARD CONFIGURATION MODAL -->
            <div x-data="{ 
                open: false, 
                activeStep: 0,
                steps: [
                    { id: 0, name: 'GENERAL' },
                    { id: 1, name: 'LOADER' },
                    { id: 2, name: 'PCB CLEANER' },
                    { id: 3, name: 'PRINTING' },
                    { id: 4, name: 'SPI' },
                    { id: 5, name: 'CHIP MOUNTER 1' },
                    { id: 6, name: 'CHIP MOUNTER 2' },
                    { id: 7, name: 'REFLOW' },
                    { id: 8, name: 'AOI' },
                    { id: 9, name: 'UNLOADER' },
                    { id: 10, name: 'AOI TABLE' },
                    { id: 11, name: 'REFLOW 2' },
                    { id: 12, name: 'CHIP MOUNTER 3' },
                    { id: 13, name: 'CHIP MOUNTER 4' },
                    { id: 14, name: 'SPI 2' },
                    { id: 15, name: 'PRINTER' },
                    { id: 16, name: 'PCB CLEANER 2' },
                    { id: 17, name: 'IONIZER' }
                ]
            }" 
                x-show="open" 
                @open-panasonic-standard-modal.window="open = true; activeStep = 0"
                @close-panasonic-standard-modal.window="open = false"
                x-cloak>

                <!-- Overlay -->
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40" @click="open = false"></div>

                <!-- Modal -->
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-5xl max-h-[95vh] overflow-hidden border border-zinc-200 dark:border-zinc-700">
                        
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-5">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-white">
                                            Configure Panasonic Standard Check
                                        </h3>
                                        <p class="text-sm text-blue-100">
                                            {{ $selectedLineForPanasonicStandard?->line_number }} - Select required fields for Daily Panasonic
                                        </p>
                                    </div>
                                </div>
                                <button @click="open = false" class="text-white/80 hover:text-white transition-colors p-2 hover:bg-white/10 rounded-xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="px-6 py-3 bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700 flex flex-wrap items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Quick Actions:</span>
                                <button type="button" 
                                        wire:click="setAllPanasonicRequired(true)"
                                        class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-200 shadow-sm hover:shadow">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    All Required
                                </button>
                                <button type="button" 
                                        wire:click="setAllPanasonicRequired(false)"
                                        class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-zinc-500 hover:bg-zinc-600 text-white rounded-lg transition-all duration-200 shadow-sm hover:shadow">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                    All Optional
                                </button>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span><span class="font-medium text-zinc-700 dark:text-zinc-300">{{ count(array_filter($panasonicStandardConfig)) }}</span> fields required</span>
                            </div>
                        </div>

                        <!-- Content Area -->
                        <div class="flex h-[calc(90vh-280px)]">
                            <!-- Sidebar Steps -->
                            <div class="w-48 bg-zinc-50 dark:bg-zinc-800/30 border-r border-zinc-200 dark:border-zinc-700 overflow-y-auto flex-shrink-0 p-2 scrollbar-hide hover:scrollbar-show">
                                <template x-for="(step, index) in steps" :key="index">
                                    <button 
                                        type="button"
                                        @click="activeStep = index"
                                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 mb-1"
                                        :class="{
                                            'bg-blue-600 text-white shadow-lg shadow-blue-600/20': activeStep === index,
                                            'hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-600 dark:text-zinc-400': activeStep !== index
                                        }"
                                    >
                                        <span class="w-6 h-6 flex items-center justify-center rounded-lg text-xs font-bold"
                                            :class="{
                                                'bg-white/20 text-white': activeStep === index,
                                                'bg-zinc-200 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400': activeStep !== index
                                            }"
                                            x-text="step.id + 1">
                                        </span>
                                        <span x-text="step.name" class="truncate"></span>
                                    </button>
                                </template>
                            </div>

                            <!-- Fields Content -->
                            <div class="flex-1 overflow-y-auto p-6 bg-white dark:bg-zinc-900">
                                <form wire:submit="savePanasonicStandardConfig" id="panasonicStandardForm">
                                    
                                    <!-- STEP 1: GENERAL -->
                                    <div x-show="activeStep === 0" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">1</span>
                                                GENERAL
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">General inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['body_cover_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.body_cover_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Body Cover</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Make sure all machine cover clean</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['body_cover_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['body_cover_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['lamp_alarm_change_model_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.lamp_alarm_change_model_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Lamp Alarm & Change Model</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Make sure lamp Alarm & Change Model Lamp clean</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['lamp_alarm_change_model_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['lamp_alarm_change_model_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 2: LOADER -->
                                    <div x-show="activeStep === 1" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">2</span>
                                                LOADER
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Loader inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['cylinder_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.cylinder_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cylinder (1)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Operation And center - Smooth and center</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['cylinder_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['cylinder_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['rail_and_magazine_pcb_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.rail_and_magazine_pcb_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Rail & Magazine PCB (1.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Cleaning Dust and dirty - No Dust and clean</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['rail_and_magazine_pcb_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['rail_and_magazine_pcb_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['cover_magazine_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.cover_magazine_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cover Magazine (1.b)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Cleaning Dust and dirty - No Dust and clean</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['cover_magazine_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['cover_magazine_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 3: PCB CLEANER -->
                                    <div x-show="activeStep === 2" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">3</span>
                                                PCB CLEANER
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">PCB Cleaner inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['brush_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.brush_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Brush (2)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Cleaning touch PCB - Rotation</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['brush_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['brush_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['air_presure_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.air_presure_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure (2.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Pressure Meter - 0.45-0.54 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['air_presure_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['air_presure_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['vacume_presure_unitech_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.vacume_presure_unitech_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vacume Pressure Unitech (2.b)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Pressure Meter - 0.45-0.54 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['vacume_presure_unitech_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['vacume_presure_unitech_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['vacume_presure_nix_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.vacume_presure_nix_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vacume Pressure Nix (2.c)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Pressure Meter - 0.60-0.70 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['vacume_presure_nix_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['vacume_presure_nix_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['vacume_brush_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.vacume_brush_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vacume Brush (3)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Operation - Rotation</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['vacume_brush_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['vacume_brush_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['cleaning_roller_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.cleaning_roller_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cleaning Roller (4)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Rotation and Cleaning - Smooth rotation & Clean</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['cleaning_roller_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['cleaning_roller_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['ionizer_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.ionizer_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Ionizer (5)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Cleaning - 5 Times to push cleaner</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['ionizer_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['ionizer_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>

                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['ionizer_air_presure_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.ionizer_air_presure_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure Ionizer (5.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check With Pressure Meter - 0.05-0.10 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['ionizer_air_presure_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['ionizer_air_presure_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['conveyor_speed_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.conveyor_speed_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Conveyor Setting (6)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Analog panel - ≤ 40</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['conveyor_speed_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['conveyor_speed_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 4: PRINTING -->
                                    <div x-show="activeStep === 3" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">4</span>
                                                PRINTING
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Printing inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['ipa_solvent_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.ipa_solvent_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">IPA Solvent (7)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Make sure solvent (IPA) minimal on mid level (half)</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['ipa_solvent_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['ipa_solvent_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['temperature_control_1_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.temperature_control_1_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Temperature Control (8)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Result-01 - 23-27℃</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['temperature_control_1_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['temperature_control_1_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['humidity_control_1_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.humidity_control_1_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Humidity Control (8.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Result-01 - 35% - 70%</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['humidity_control_1_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['humidity_control_1_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['clamp_presure_sp_60_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.clamp_presure_sp_60_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Clamp Pressure SP-60 (9)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Pressure Meter - 0.20-0.4 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['clamp_presure_sp_60_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['clamp_presure_sp_60_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['clamp_presure_spg_2_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.clamp_presure_spg_2_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Clamp Pressure SPG-2 (9)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Pressure Meter - 0.20-0.4 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['clamp_presure_spg_2_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['clamp_presure_spg_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['squeege_sp_60_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.squeege_sp_60_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Squeege SP-60 (10)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Pressure Meter - 0.19-0.21 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['squeege_sp_60_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['squeege_sp_60_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['squeege_spg_2_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.squeege_spg_2_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Squeege SPG-2 (10)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Pressure Meter - 0.11-0.13 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['squeege_spg_2_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['squeege_spg_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['cleaning_solvent_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.cleaning_solvent_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cleaning Solvent (11)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Pressure Meter - 0.19-0.21 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['cleaning_solvent_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['cleaning_solvent_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['air_presure_meter_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.air_presure_meter_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure Meter (12)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Pressure Meter - 0.50-0.55 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['air_presure_meter_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['air_presure_meter_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 5: SPI -->
                                    <div x-show="activeStep === 4" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">5</span>
                                                SPI
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">SPI inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['air_presure_meter_parmi_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.air_presure_meter_parmi_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure Meter Parmi (12.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Pressure Meter - 0.40-0.50 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['air_presure_meter_parmi_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['air_presure_meter_parmi_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['capability_index_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.capability_index_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Capability Index (12.b)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check SPI Measurement result - CpK > 1.33</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['capability_index_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['capability_index_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 6: CHIP MOUNTER 1 -->
                                    <div x-show="activeStep === 5" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">6</span>
                                                CHIP MOUNTER 1
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Chip Mounter 1 inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['air_presure_supply_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.air_presure_supply_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure Supply (13)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Pressure Meter - 0.49-0.54 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['air_presure_supply_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['air_presure_supply_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['vaccuum_pump_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.vaccuum_pump_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Pump (13.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Pressure Meter - -87 to -100 Kpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['vaccuum_pump_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['vaccuum_pump_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['box_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.box_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Box (13.b)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Chip collection - No components</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['box_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['box_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['vaccuum_parameter_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.vaccuum_parameter_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Parameter (13.c)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with machine parameter - No Yellow initial</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['vaccuum_parameter_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['vaccuum_parameter_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['expire_date_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.expire_date_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Expire Date (14)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Make sure due date on label - No Expired</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['expire_date_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['expire_date_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 7: CHIP MOUNTER 2 -->
                                    <div x-show="activeStep === 6" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">7</span>
                                                CHIP MOUNTER 2
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Chip Mounter 2 inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['air_presure_supply_2_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.air_presure_supply_2_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure Supply (15)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Pressure Meter - 0.49-0.54 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['air_presure_supply_2_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['air_presure_supply_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['vaccuum_pump_2_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.vaccuum_pump_2_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Pump (15.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Pressure Meter - -87 to -100 Kpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['vaccuum_pump_2_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['vaccuum_pump_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['box_2_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.box_2_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Box (15.b)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Chip collection - No components</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['box_2_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['box_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['vaccuum_parameter_2_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.vaccuum_parameter_2_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Parameter (15.c)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with machine parameter - No Yellow initial</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['vaccuum_parameter_2_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['vaccuum_parameter_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['expire_date_2_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.expire_date_2_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Expire Date (16)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Make sure due date on label - No Expired</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['expire_date_2_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['expire_date_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 8: REFLOW -->
                                    <div x-show="activeStep === 7" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">8</span>
                                                REFLOW
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Reflow inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['abandonment_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.abandonment_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Abandonment (17)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Damage - No Damage</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['abandonment_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['abandonment_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['fire_posibilty_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.fire_posibilty_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Fire Possibility (17.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">PCB input area - No Paper, No plastic</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['fire_posibilty_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['fire_posibilty_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['flashlight_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.flashlight_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Flashlight (17.b)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">On/Off Check - Standard: On</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['flashlight_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['flashlight_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['rail_and_transfer_unit_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.rail_and_transfer_unit_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Rail & Transfer Unit (18)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Make sure smooth condition - No jammed</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['rail_and_transfer_unit_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['rail_and_transfer_unit_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['n2_presure_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.n2_presure_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">N2 Pressure (19)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check N2 Pressure - 0.4-0.5 MPa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['n2_presure_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['n2_presure_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['oxygent_density_sek_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.oxygent_density_sek_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Oxygen Density SEK (20)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Oxygen meter - 1200-1800 ppm</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['oxygent_density_sek_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['oxygent_density_sek_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['oxygent_density_special_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.oxygent_density_special_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Oxygen Density Special (20)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Oxygen meter - 500-1000 ppm</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['oxygent_density_special_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['oxygent_density_special_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['fire_posibilty_2_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.fire_posibilty_2_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Fire Possibility (20.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">PCB Output area - No Paper, No plastic</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['fire_posibilty_2_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['fire_posibilty_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 9: AOI -->
                                    <div x-show="activeStep === 8" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">9</span>
                                                AOI
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">AOI inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['air_presure_2_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.air_presure_2_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure (20.b)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Pressure Meter - 0.40-0.50 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['air_presure_2_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['air_presure_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 10: UNLOADER -->
                                    <div x-show="activeStep === 9" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">10</span>
                                                UNLOADER
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Unloader inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['cylinder_2_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.cylinder_2_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cylinder (21)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Operation And center - Smooth and center</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['cylinder_2_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['cylinder_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['rail_and_magazine_pcb_2_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.rail_and_magazine_pcb_2_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Rail & Magazine PCB (21.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Cleaning Dust and dirty - No Dust and clean</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['rail_and_magazine_pcb_2_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['rail_and_magazine_pcb_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['cover_magazine_2_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.cover_magazine_2_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cover Magazine (21.b)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Cleaning Dust and dirty - No Dust and clean</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['cover_magazine_2_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['cover_magazine_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 11: AOI TABLE -->
                                    <div x-show="activeStep === 10" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">11</span>
                                                AOI TABLE
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">AOI Table inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['angle_and_filter_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.angle_and_filter_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Angle & Filter (22)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Cleaning - No dirt / no dust</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['angle_and_filter_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['angle_and_filter_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['lamp_indicator_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.lamp_indicator_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Lamp Indicator (22.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">LED Lamp (Green) - Function</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['lamp_indicator_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['lamp_indicator_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 12: REFLOW 2 -->
                                    <div x-show="activeStep === 11" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">12</span>
                                                REFLOW 2
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Reflow 2 inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['temperature_chiller_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.temperature_chiller_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Temperature Chiller (23)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Write down the value - 17-23℃</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['temperature_chiller_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['temperature_chiller_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['temperature_control_3_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.temperature_control_3_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Temperature Control (24)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check Value inspect - 300℃ ±10℃</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['temperature_control_3_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['temperature_control_3_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>

                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['n2_air_presure_valve_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.n2_air_presure_valve_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">N2 & Air Pressure (24.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Opening Valve - Position handle parallel</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['n2_air_presure_valve_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['n2_air_presure_valve_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 13: CHIP MOUNTER 3 -->
                                    <div x-show="activeStep === 12" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">13</span>
                                                CHIP MOUNTER 3
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Chip Mounter 3 inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['box_3_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.box_3_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Box (25)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Chip collection - No components</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['box_3_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['box_3_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['vaccuum_pump_3_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.vaccuum_pump_3_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Pump (25.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Pressure Meter - -87 to -100 Kpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['vaccuum_pump_3_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['vaccuum_pump_3_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 14: CHIP MOUNTER 4 -->
                                    <div x-show="activeStep === 13" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">14</span>
                                                CHIP MOUNTER 4
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Chip Mounter 4 inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['box_4_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.box_4_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Box (26)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Chip collection - No components</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['box_4_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['box_4_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['vaccuum_pump_4_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.vaccuum_pump_4_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Pump (26.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Pressure Meter - -87 to -100 Kpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['vaccuum_pump_4_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['vaccuum_pump_4_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 15: SPI 2 -->
                                    <div x-show="activeStep === 14" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">15</span>
                                                SPI 2
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">SPI 2 inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['air_presure_3_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.air_presure_3_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure (27)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Check with Pressure Meter - 0.40-0.50 Mpa</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['air_presure_3_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['air_presure_3_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 16: PRINTER -->
                                    <div x-show="activeStep === 15" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">16</span>
                                                PRINTER
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Printer inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['temperature_control_4_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.temperature_control_4_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Temperature Control (28)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Air cond Setting Temperature - 23-27℃</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['temperature_control_4_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['temperature_control_4_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                            
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['water_reservoirs_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.water_reservoirs_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Water Reservoirs (28.a)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Damage, Function - Function, No Damage</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['water_reservoirs_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['water_reservoirs_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 17: PCB CLEANER 2 -->
                                    <div x-show="activeStep === 16" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">17</span>
                                                PCB CLEANER 2
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">PCB Cleaner 2 inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['filter_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.filter_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Filter (29)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Cleaning - Clean</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['filter_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['filter_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- STEP 18: IONIZER -->
                                    <div x-show="activeStep === 17" x-cloak>
                                        <div class="mb-4">
                                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                                                <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-sm font-bold">18</span>
                                                IONIZER
                                            </h4>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Ionizer inspection parameters</p>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all duration-200 cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 {{ $panasonicStandardConfig['angle_and_filter_2_required'] ?? false ? 'border-blue-500 bg-blue-50 dark:bg-blue-950/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                                <input type="checkbox" wire:model="panasonicStandardConfig.angle_and_filter_2_required" class="w-4 h-4 text-blue-600 rounded border-zinc-300 focus:ring-blue-500">
                                                <div class="flex-1">
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Angle & Filter (30)</span>
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Cleaning - No dirt / no dust</p>
                                                </div>
                                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $panasonicStandardConfig['angle_and_filter_2_required'] ?? false ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500' }}">
                                                    {{ $panasonicStandardConfig['angle_and_filter_2_required'] ?? false ? 'Required' : 'Optional' }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Navigation Buttons -->
                                    <div class="flex justify-between mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                                        <button type="button" 
                                                @click="activeStep > 0 ? activeStep-- : null"
                                                class="px-4 py-2 text-sm font-medium rounded-xl border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors"
                                                :class="{'opacity-50 cursor-not-allowed': activeStep === 0}">
                                            ← Previous
                                        </button>
                                        <button type="button" 
                                                @click="activeStep < steps.length - 1 ? activeStep++ : null"
                                                class="px-4 py-2 text-sm font-medium rounded-xl bg-blue-600 hover:bg-blue-700 text-white transition-colors shadow-lg shadow-blue-600/20"
                                                :class="{'opacity-50 cursor-not-allowed': activeStep === steps.length - 1}">
                                            Next →
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-3">
                            <button type="button" 
                                    @click="open = false"
                                    class="px-4 py-2 text-sm font-medium rounded-xl border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    form="panasonicStandardForm"
                                    class="flex items-center gap-2 px-6 py-2 text-sm font-medium rounded-xl bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white transition-all duration-200 shadow-lg shadow-blue-600/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                </svg>
                                Save Configuration
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STANDARD CONFIGURATION HISTORY MODAL -->
            <div x-data="{ open: false }" 
                x-show="open" 
                @open-history-modal.window="open = true"
                @close-history-modal.window="open = false"
                x-cloak>

                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden border border-zinc-200 dark:border-zinc-700">
                        
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-white">
                                            Configuration History
                                        </h3>
                                        <p class="text-sm text-indigo-100">
                                            {{ $historyLineNumber }} - {{ ucfirst($historyType) }} Standard Check
                                        </p>
                                    </div>
                                </div>
                                <button @click="open = false" class="text-white/80 hover:text-white transition-colors p-2 hover:bg-white/10 rounded-xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="overflow-y-auto p-6 max-h-[calc(90vh-150px)]">
                            @if(count($historyData) > 0)
                                <div class="space-y-6">
                                    @foreach($historyData as $history)
                                        <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-4 hover:shadow-lg transition-shadow">
                                            <!-- Header History -->
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-full flex items-center justify-center 
                                                        {{ $history['action'] === 'create' ? 'bg-green-100 dark:bg-green-900/30 text-green-600' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-600' }}">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $history['action'] === 'create' ? 'M12 4v16m8-8H4' : 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z' }}"/>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="flex items-center gap-2 flex-wrap">
                                                            <span class="font-semibold text-zinc-900 dark:text-white">
                                                                {{ $history['user_name'] }}
                                                            </span>
                                                            <span class="text-xs px-2 py-0.5 rounded-full 
                                                                {{ $history['action'] === 'create' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' }}">
                                                                {{ ucfirst($history['action']) }}
                                                            </span>
                                                        </div>
                                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                                            {{ \Carbon\Carbon::parse($history['created_at'])->format('d/m/Y H:i:s') }}
                                                            @if($history['ip_address'])
                                                                · IP: {{ $history['ip_address'] }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="text-xs text-zinc-400">
                                                    #{{ $history['id'] }}
                                                </span>
                                            </div>

                                            @if(!empty($history['changes_by_step']))
                                                <div class="space-y-4">
                                                    @foreach($history['changes_by_step'] as $stepNumber => $stepData)
                                                        @if(is_array($stepData) && isset($stepData['step_name']))
                                                            <div>
                                                                <!-- Step Header -->
                                                                <div class="flex items-center gap-2 mb-2">
                                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 text-xs font-bold">
                                                                        {{ $stepData['step_number'] }}
                                                                    </span>
                                                                    <span class="text-sm font-semibold text-purple-700 dark:text-purple-400">
                                                                        {{ $stepData['step_name'] }}
                                                                    </span>
                                                                    <span class="text-xs text-zinc-400">
                                                                        ({{ count($stepData['fields']) }} field{{ count($stepData['fields']) > 1 ? 's' : '' }})
                                                                    </span>
                                                                </div>
                                                                
                                                                <!-- Fields in this step -->
                                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 ml-4">
                                                                    @foreach($stepData['fields'] as $field => $change)
                                                                        <div class="flex items-center justify-between p-2 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg text-sm">
                                                                            <span class="text-zinc-600 dark:text-zinc-400 font-medium text-xs truncate mr-2">
                                                                                {{ ucwords(str_replace('_', ' ', $field)) }}
                                                                            </span>
                                                                            <div class="flex items-center gap-1 flex-shrink-0">
                                                                                <span class="text-red-600 dark:text-red-400 line-through text-xs">
                                                                                    {{ $change['old'] }}
                                                                                </span>
                                                                                <svg class="w-3 h-3 text-zinc-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                                                                </svg>
                                                                                <span class="text-green-600 dark:text-green-400 font-semibold text-xs">
                                                                                    {{ $change['new'] }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @else
                                                            <!-- Other / Unmapped fields -->
                                                            <div>
                                                                <div class="flex items-center gap-2 mb-2">
                                                                    <span class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">
                                                                        OTHER
                                                                    </span>
                                                                </div>
                                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 ml-4">
                                                                    @foreach($history['changes'] as $field => $change)
                                                                        <div class="flex items-center justify-between p-2 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg text-sm">
                                                                            <span class="text-zinc-600 dark:text-zinc-400 font-medium text-xs truncate mr-2">
                                                                                {{ ucwords(str_replace('_', ' ', $field)) }}
                                                                            </span>
                                                                            <div class="flex items-center gap-1 flex-shrink-0">
                                                                                <span class="text-red-600 dark:text-red-400 line-through text-xs">
                                                                                    {{ $change['old'] }}
                                                                                </span>
                                                                                <svg class="w-3 h-3 text-zinc-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                                                                </svg>
                                                                                <span class="text-green-600 dark:text-green-400 font-semibold text-xs">
                                                                                    {{ $change['new'] }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @elseif(!empty($history['changes']))
                                                <!-- Fallback: display all changes without step grouping -->
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                                    @foreach($history['changes'] as $field => $change)
                                                        <div class="flex items-center justify-between p-2 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg text-sm">
                                                            <span class="text-zinc-600 dark:text-zinc-400 font-medium text-xs truncate mr-2">
                                                                {{ ucwords(str_replace('_', ' ', $field)) }}
                                                            </span>
                                                            <div class="flex items-center gap-1 flex-shrink-0">
                                                                <span class="text-red-600 dark:text-red-400 line-through text-xs">
                                                                    {{ $change['old'] }}
                                                                </span>
                                                                <svg class="w-3 h-3 text-zinc-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                                                </svg>
                                                                <span class="text-green-600 dark:text-green-400 font-semibold text-xs">
                                                                    {{ $change['new'] }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-sm text-zinc-500 dark:text-zinc-400 italic">
                                                    No changes recorded for this action.
                                                </p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="w-20 h-20 mx-auto rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        No History Found
                                    </h4>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                        No configuration history available for this line yet.
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Footer -->
                        <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-700 flex justify-end">
                            <button type="button" 
                                    @click="open = false"
                                    class="px-4 py-2 text-sm font-medium rounded-xl bg-zinc-200 hover:bg-zinc-300 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-zinc-700 dark:text-zinc-300 transition-colors">
                                Close
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
                
                /* Hide scrollbar by default, show on hover */
                .scrollbar-hide::-webkit-scrollbar {
                    width: 0px;
                    background: transparent;
                }
                .scrollbar-hide {
                    -ms-overflow-style: none;
                    scrollbar-width: none;
                }
                .scrollbar-hide:hover::-webkit-scrollbar {
                    width: 6px;
                    background: transparent;
                }
                .scrollbar-hide:hover::-webkit-scrollbar-track {
                    background: transparent;
                }
                .scrollbar-hide:hover::-webkit-scrollbar-thumb {
                    background: #cbd5e1;
                    border-radius: 3px;
                }
                .scrollbar-hide:hover::-webkit-scrollbar-thumb:hover {
                    background: #94a3b8;
                }
                .scrollbar-hide:hover {
                    -ms-overflow-style: auto;
                    scrollbar-width: thin;
                }
            </style>
        </div>
    </x-mtc.layout>
</section>