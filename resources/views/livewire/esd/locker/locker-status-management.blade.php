<section class="w-full">
    @include('partials.esd-heading')

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge - Locker Status Management') }}
    </flux:heading>

    <x-esd.layout class="!max-w-full !px-0 !mx-0">
        <x-slot name="heading">
            <div class="w-full">
                <flux:breadcrumbs class="mb-1">
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
                        Dashboard
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        Maintenance
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        ESD
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        Locker
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                            Locker Management
                        </h1>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            Manage ESD locker status and assignments
                        </p>
                    </div>
                </div>
            </div>
        </x-slot>
        
        <div class="-mt-2">
            <!-- Header with buttons aligned -->
            <div x-data="{ showFilters: false }">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-1 mb-4">
                    <div class="flex-1">
                        <button 
                            @click="showFilters = !showFilters"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-zinc-700 bg-white border border-zinc-300 rounded-lg hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-600 dark:hover:bg-zinc-700 transition-colors"
                        >
                            <svg x-show="!showFilters" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <svg x-show="showFilters" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                            <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'"></span>
                        </button>
                    </div>
                    
                    @can('create locker')
                    <flux:button 
                        variant="primary" 
                        icon="plus" 
                        class="bg-blue-600 hover:bg-blue-700 whitespace-nowrap"
                        wire:click="resetForm"
                        x-on:click="$dispatch('open-modal', 'locker-form-modal')"
                    >
                        Add New Locker
                    </flux:button>
                    @endcan
                </div>

                <!-- Filters Section -->
                <div x-show="showFilters" 
                    x-transition.duration.300ms
                    x-cloak
                    class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-700 mb-4">
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Search -->
                            <div class="lg:col-span-2">
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Search</label>
                                <div class="relative">
                                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <input type="text" 
                                           wire:model.live.debounce.300ms="search" 
                                           placeholder="Search by Locker Number, NIK, Name, Dept..." 
                                           class="w-full pl-10 pr-4 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                                </div>
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Status</label>
                                <select wire:model.live="filterStatus" 
                                        class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                                    <option value="">All Status</option>
                                    <option value="Filled">Filled</option>
                                    <option value="On Process Measure">On Process Measure</option>
                                    <option value="Finish">Finish</option>
                                    <option value="Available">Available</option>
                                </select>
                            </div>

                            <!-- Department Filter -->
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Department</label>
                                <input type="text" 
                                       wire:model.live.debounce.300ms="filterDept" 
                                       placeholder="Filter by department..."
                                       class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                            </div>
                        </div>

                        <!-- Date Filters Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date From</label>
                                <input type="date" wire:model.live="filterDateFrom" 
                                       class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date Until</label>
                                <input type="date" wire:model.live="filterDateUntil" 
                                       class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                            </div>
                        </div>
                        
                        <!-- Clear Filters Button -->
                        @if($filterStatus || $filterDept || $filterDateFrom || $filterDateUntil || $search)
                        <div class="mt-4 text-right">
                            <button wire:click="resetFilters" 
                                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Clear All Filters
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Lockers Table - 2 Separate Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Card -->
                <flux:card class="p-0 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                    <div class="bg-blue-600 dark:bg-blue-500 px-4 py-3">
                        <h3 class="font-semibold text-white text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.948 1.316H8a4 4 0 00-4 4v8a2 2 0 002 2h12a2 2 0 002-2v-8a4 4 0 00-4-4h-2.382a1 1 0 01-.948-1.316L15.77 3.684A1 1 0 0116.718 3H20a2 2 0 012 2v14a2 2 0 01-2 2H4a2 2 0 01-2-2V5z"></path>
                            </svg>
                            Left Side - Lockers 1-10
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Locker</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NIK</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Dept</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Updated</th>
                                    <th class="px-3 py-2 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                @forelse($leftLockers as $index => $locker)
                                @php
                                    $statusColor = match($locker->status) {
                                        'Filled' => 'success',
                                        'On Process Measure' => 'warning',
                                        'Finish' => 'info',
                                        'Available' => 'danger',
                                        default => 'gray',
                                    };
                                @endphp
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="locker-left-{{ $locker->id }}">
                                    <td class="px-3 py-2">
                                        <span class="text-sm font-semibold text-zinc-800 dark:text-white font-mono">
                                            {{ $locker->locker_number }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $locker->nik ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2 text-sm text-zinc-700 dark:text-zinc-300">
                                        <div class="max-w-[150px] truncate" title="{{ $locker->name }}">
                                            {{ $locker->name ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $locker->dept ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2" wire:key="status-left-{{ $locker->id }}">
                                        @if($editingId === $locker->id)
                                            <select 
                                                wire:model.live="editingStatus"
                                                wire:keydown.enter="updateStatus({{ $locker->id }})"
                                                wire:blur="updateStatus({{ $locker->id }})"
                                                class="w-full px-2 py-1 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700"
                                                autofocus>
                                                <option value="Filled">Filled</option>
                                                <option value="On Process Measure">On Process Measure</option>
                                                <option value="Finish">Finish</option>
                                                <option value="Available">Available</option>
                                            </select>
                                        @else
                                            <div class="flex items-center gap-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800 dark:bg-{{ $statusColor }}-900/30 dark:text-{{ $statusColor }}-400">
                                                    {{ $locker->status }}
                                                </span>
                                                <button 
                                                    wire:click="startEditingStatus({{ $locker->id }}, '{{ $locker->status }}')"
                                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400"
                                                    title="Update status">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $locker->updated_at ? $locker->updated_at->format('d/m/y H:i') : '-' }}
                                    </td>
                                    <td class="px-3 py-2 text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <flux:button 
                                                wire:click="viewActivity({{ $locker->id }})" 
                                                x-on:click="$dispatch('open-modal', 'activity-modal')"
                                                size="xs"
                                                icon="document-text"
                                                variant="primary"
                                                color="purple"
                                                class="!p-1.5"
                                                title="View activity log"
                                            />
                                            @can('delete locker')
                                            <flux:button 
                                                wire:click="confirmDelete({{ $locker->id }})" 
                                                x-on:click="$dispatch('open-modal', 'delete-locker-modal')"
                                                size="xs"
                                                icon="trash"
                                                variant="primary"
                                                color="red"
                                                class="!p-1.5"
                                                title="Delete locker"
                                            />
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-3 py-8 text-center text-zinc-500">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.948 1.316H8a4 4 0 00-4 4v8a2 2 0 002 2h12a2 2 0 002-2v-8a4 4 0 00-4-4h-2.382a1 1 0 01-.948-1.316L15.77 3.684A1 1 0 0116.718 3H20a2 2 0 012 2v14a2 2 0 01-2 2H4a2 2 0 01-2-2V5z"></path>
                                            </svg>
                                            <p class="text-sm">No lockers found</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </flux:card>

                <!-- Right Card -->
                <flux:card class="p-0 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                    <div class="bg-green-600 dark:bg-green-500 px-4 py-3">
                        <h3 class="font-semibold text-white text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.948 1.316H8a4 4 0 00-4 4v8a2 2 0 002 2h12a2 2 0 002-2v-8a4 4 0 00-4-4h-2.382a1 1 0 01-.948-1.316L15.77 3.684A1 1 0 0116.718 3H20a2 2 0 012 2v14a2 2 0 01-2 2H4a2 2 0 01-2-2V5z"></path>
                            </svg>
                            Right Side - Lockers 11-20
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Locker</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NIK</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Dept</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Updated</th>
                                    <th class="px-3 py-2 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                @forelse($rightLockers as $index => $locker)
                                @php
                                    $statusColor = match($locker->status) {
                                        'Filled' => 'success',
                                        'On Process Measure' => 'warning',
                                        'Finish' => 'info',
                                        'Available' => 'danger',
                                        default => 'gray',
                                    };
                                @endphp
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="locker-right-{{ $locker->id }}">
                                    <td class="px-3 py-2">
                                        <span class="text-sm font-semibold text-zinc-800 dark:text-white font-mono">
                                            {{ $locker->locker_number }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $locker->nik ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2 text-sm text-zinc-700 dark:text-zinc-300">
                                        <div class="max-w-[150px] truncate" title="{{ $locker->name }}">
                                            {{ $locker->name ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $locker->dept ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2" wire:key="status-right-{{ $locker->id }}">
                                        @if($editingId === $locker->id)
                                            <select 
                                                wire:model.live="editingStatus"
                                                wire:keydown.enter="updateStatus({{ $locker->id }})"
                                                wire:blur="updateStatus({{ $locker->id }})"
                                                class="w-full px-2 py-1 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700"
                                                autofocus>
                                                <option value="Filled">Filled</option>
                                                <option value="On Process Measure">On Process Measure</option>
                                                <option value="Finish">Finish</option>
                                                <option value="Available">Available</option>
                                            </select>
                                        @else
                                            <div class="flex items-center gap-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800 dark:bg-{{ $statusColor }}-900/30 dark:text-{{ $statusColor }}-400">
                                                    {{ $locker->status }}
                                                </span>
                                                <button 
                                                    wire:click="startEditingStatus({{ $locker->id }}, '{{ $locker->status }}')"
                                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400"
                                                    title="Update status">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $locker->updated_at ? $locker->updated_at->format('d/m/y H:i') : '-' }}
                                    </td>
                                    <td class="px-3 py-2 text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <flux:button 
                                                wire:click="viewActivity({{ $locker->id }})" 
                                                x-on:click="$dispatch('open-modal', 'activity-modal')"
                                                size="xs"
                                                icon="document-text"
                                                variant="primary"
                                                color="purple"
                                                class="!p-1.5"
                                                title="View activity log"
                                            />
                                            @can('delete locker')
                                            <flux:button 
                                                wire:click="confirmDelete({{ $locker->id }})" 
                                                x-on:click="$dispatch('open-modal', 'delete-locker-modal')"
                                                size="xs"
                                                icon="trash"
                                                variant="primary"
                                                color="red"
                                                class="!p-1.5"
                                                title="Delete locker"
                                            />
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-3 py-8 text-center text-zinc-500">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.948 1.316H8a4 4 0 00-4 4v8a2 2 0 002 2h12a2 2 0 002-2v-8a4 4 0 00-4-4h-2.382a1 1 0 01-.948-1.316L15.77 3.684A1 1 0 0116.718 3H20a2 2 0 012 2v14a2 2 0 01-2 2H4a2 2 0 01-2-2V5z"></path>
                                            </svg>
                                            <p class="text-sm">No lockers found</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </flux:card>
            </div>

            <!-- Info Total Data -->
            <div class="mt-4 flex justify-between items-center text-sm text-zinc-500 dark:text-zinc-400">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Showing {{ $allLockers->count() }} lockers
                    </span>
                    @if($allLockers->count() >= 20)
                        <span class="inline-flex items-center gap-1 text-yellow-600 dark:text-yellow-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            Max 20 records displayed. Use filters to narrow down.
                        </span>
                    @endif
                </div>
                <div class="text-xs">
                    Last updated: {{ now()->format('d M Y H:i:s') }}
                </div>
            </div>

            <!-- MODAL FORM LOCKER -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-modal.window="if ($event.detail === 'locker-form-modal') open = true"
                 @close-modal.window="if ($event.detail === 'locker-form-modal') open = false"
                 x-cloak>
                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>
                            <form wire:submit="save">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Locker Number -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium mb-1">Locker Number <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model="locker_number" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500" placeholder="e.g., LK-001">
                                        @error('locker_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- NIK -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1">NIK</label>
                                        <input type="text" wire:model="nik" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500" placeholder="Employee NIK">
                                        @error('nik') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Name -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Name</label>
                                        <input type="text" wire:model="name" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500" placeholder="Employee name">
                                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Department -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Department</label>
                                        <input type="text" wire:model="dept" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500" placeholder="Department">
                                        @error('dept') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Status <span class="text-red-500">*</span></label>
                                        <select wire:model="status" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                                            <option value="Available">Available</option>
                                            <option value="Filled">Filled</option>
                                            <option value="On Process Measure">On Process Measure</option>
                                            <option value="Finish">Finish</option>
                                        </select>
                                        @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="flex justify-end gap-2 mt-6">
                                    <button type="button" @click="open = false" class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        {{ $locker_id ? 'Update' : 'Create' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL ACTIVITY LOG -->
            <flux:modal wire:model="showActivityModal" class="w-full max-w-5xl">
                <div class="flex flex-col" style="height: auto; max-height: 85vh; overflow: hidden;">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex-shrink-0">
                        <div>
                            <h2 class="text-xl font-bold text-zinc-800 dark:text-white">
                                Activity Log
                            </h2>
                            @if($selectedLockerForActivity)
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                Locker: <span class="font-semibold">{{ $selectedLockerForActivity->locker_number }}</span>
                            </p>
                            @endif
                        </div>
                    </div>

                    @if($selectedLockerForActivity)
                    @php
                        // Query menggunakan attribute_changes
                        $activitiesData = \Spatie\Activitylog\Models\Activity::where(function($query) {
                                $query->where('subject_type', 'App\Models\ESD\Locker\LockerStatus')
                                    ->orWhere('subject_type', 'App\Models\LockerStatus');
                            })
                            ->where('subject_id', $selectedLockerForActivity->id)
                            ->orderBy('created_at', 'desc')
                            ->paginate($perPageActivities, ['*'], 'page', $activityPage);
                        $totalRecords = $activitiesData->total();
                        $lastPage = $activitiesData->lastPage();
                        
                        // Load users untuk relasi
                        $allUsers = \App\Models\User::all()->keyBy('id');
                    @endphp
                    
                    <div class="flex-1 overflow-y-auto p-6">
                        @if($totalRecords > 0)
                            <div class="space-y-4">
                                <!-- Legend Badges -->
                                <div class="flex gap-2 mb-2">
                                    <span class="px-2 py-1 rounded-full text-white font-bold bg-red-600 text-xs">Old Value</span>
                                    <span class="px-2 py-1 rounded-full text-white font-bold bg-green-600 text-xs">New Value</span>
                                </div>

                                <div class="space-y-2">
                                    @foreach($activitiesData as $index => $activity)
                                        @php
                                            // Mengambil data dari attribute_changes (bukan properties)
                                            $attributeChanges = is_string($activity->attribute_changes) 
                                                ? json_decode($activity->attribute_changes, true) 
                                                : ($activity->attribute_changes ?? []);
                                            
                                            // Untuk created/updated/deleted, data ada di attribute_changes
                                            $old = $attributeChanges['old'] ?? [];
                                            $new = $attributeChanges['attributes'] ?? [];
                                            
                                            // Jika attribute_changes kosong, coba ambil dari properties (backup)
                                            if (empty($old) && empty($new)) {
                                                $props = is_string($activity->properties) 
                                                    ? json_decode($activity->properties, true) 
                                                    : ($activity->properties ?? []);
                                                $old = $props['old'] ?? [];
                                                $new = $props['attributes'] ?? [];
                                            }
                                            
                                            $changes = [];
                                            if ($activity->event == 'created') {
                                                foreach ($new as $key => $val) {
                                                    if (!in_array($key, ['created_by', 'updated_by', 'id', 'created_at', 'updated_at'])) {
                                                        $changes[$key] = ['old' => null, 'new' => $val];
                                                    }
                                                }
                                            } elseif ($activity->event == 'updated') {
                                                foreach ($new as $key => $val) {
                                                    $oldVal = $old[$key] ?? null;
                                                    if ($oldVal !== $val && !in_array($key, ['created_by', 'updated_by', 'id', 'created_at', 'updated_at'])) {
                                                        $changes[$key] = ['old' => $oldVal, 'new' => $val];
                                                    }
                                                }
                                            } elseif ($activity->event == 'deleted') {
                                                foreach ($old as $key => $val) {
                                                    if (!in_array($key, ['created_by', 'updated_by', 'id', 'created_at', 'updated_at'])) {
                                                        $changes[$key] = ['old' => $val, 'new' => null];
                                                    }
                                                }
                                            }
                                            
                                            $isFirst = $loop->first;
                                        @endphp
                                        
                                        @if(!empty($changes))
                                        <div x-data="{ open: {{ $isFirst ? 'true' : 'false' }} }" class="border rounded-lg shadow-sm bg-white dark:bg-zinc-900">
                                            <button type="button"
                                                    @click="open = !open"
                                                    class="w-full flex justify-between items-center px-4 py-3 text-left font-medium bg-gray-100 hover:bg-gray-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 rounded-t-lg">
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    @if($activity->event == 'created')
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                            </svg>
                                                            CREATED
                                                        </span>
                                                    @elseif($activity->event == 'updated')
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                            </svg>
                                                            UPDATED
                                                        </span>
                                                    @elseif($activity->event == 'deleted')
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                            DELETED
                                                        </span>
                                                    @endif
                                                    <strong class="text-sm text-zinc-800 dark:text-zinc-200">{{ $activity->causer?->name ?? 'System' }}</strong>
                                                    <span class="text-xs text-zinc-500">{{ $activity->created_at ? $activity->created_at->format('d M Y H:i:s') : '-' }}</span>
                                                </div>
                                                <svg :class="{ 'rotate-180': open }"
                                                    class="w-4 h-4 transform transition-transform text-zinc-500"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>

                                            <div x-show="open" x-transition class="p-4 space-y-2">
                                                @foreach ($changes as $field => $change)
                                                    @php
                                                        $oldValue = $change['old'];
                                                        $newValue = $change['new'];
                                                        $fieldName = ucfirst(str_replace('_', ' ', $field));
                                                        
                                                        // Format untuk user relation
                                                        if (in_array($field, ['created_by', 'updated_by']) && is_numeric($oldValue)) {
                                                            $oldValue = $allUsers[$oldValue]?->name ?? $oldValue;
                                                        }
                                                        if (in_array($field, ['created_by', 'updated_by']) && is_numeric($newValue)) {
                                                            $newValue = $allUsers[$newValue]?->name ?? $newValue;
                                                        }
                                                        
                                                        $displayOld = $oldValue ?? '-';
                                                        $displayNew = $newValue ?? '-';
                                                    @endphp

                                                    <div class="text-sm flex items-center gap-2 flex-wrap">
                                                        <span class="font-semibold min-w-[100px]">{{ $fieldName }}:</span>
                                                        <div class="flex items-center gap-2 flex-wrap">
                                                            @if($activity->event == 'created')
                                                                <span class="px-2 py-0.5 rounded-full text-white font-bold bg-green-600 text-xs">
                                                                    {{ $displayNew }}
                                                                </span>
                                                            @elseif($activity->event == 'deleted')
                                                                <span class="px-2 py-0.5 rounded-full text-white font-bold bg-red-600 text-xs">
                                                                    {{ $displayOld }}
                                                                </span>
                                                            @else
                                                                <span class="px-2 py-0.5 rounded-full text-white font-bold bg-red-600 line-through text-xs">
                                                                    {{ $displayOld }}
                                                                </span>
                                                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                                </svg>
                                                                <span class="px-2 py-0.5 rounded-full text-white font-bold bg-green-600 text-xs">
                                                                    {{ $displayNew }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                                
                                @if($lastPage > 1)
                                <div class="flex justify-between items-center mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                        Showing {{ $activitiesData->firstItem() }} to {{ $activitiesData->lastItem() }} of {{ $totalRecords }} records
                                    </div>
                                    <div class="flex gap-2">
                                        <flux:button wire:click="setActivityPage({{ $activityPage - 1 }})" size="sm" variant="outline" :disabled="$activityPage <= 1" class="!px-3">Previous</flux:button>
                                        @for($i = 1; $i <= $lastPage; $i++)
                                            @if($i == $activityPage)
                                                <flux:button size="sm" variant="primary" class="!px-3">{{ $i }}</flux:button>
                                            @elseif($i == 1 || $i == $lastPage || ($i >= $activityPage - 1 && $i <= $activityPage + 1))
                                                <flux:button wire:click="setActivityPage({{ $i }})" size="sm" variant="outline" class="!px-3">{{ $i }}</flux:button>
                                            @elseif($i == $activityPage - 2 || $i == $activityPage + 2)
                                                <span class="px-2 py-1 text-sm text-zinc-500 dark:text-zinc-400">...</span>
                                            @endif
                                        @endfor
                                        <flux:button wire:click="setActivityPage({{ $activityPage + 1 }})" size="sm" variant="outline" :disabled="$activityPage >= $lastPage" class="!px-3">Next</flux:button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="mt-4 text-sm text-zinc-500 dark:text-zinc-400">No activity logs found for this locker</p>
                            </div>
                        @endif
                    </div>
                    @endif
                </div>
            </flux:modal>

            <!-- MODAL DELETE -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-modal.window="if ($event.detail === 'delete-locker-modal') open = true"
                 @close-modal.window="if ($event.detail === 'delete-locker-modal') open = false"
                 x-cloak>
                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold mb-2">Delete Locker</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Are you sure you want to delete locker "{{ $detailToDelete?->locker_number ?? 'this locker' }}"? This action cannot be undone.
                        </p>
                        <div class="flex justify-center gap-3">
                            <button @click="open = false" class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800">Cancel</button>
                            <button wire:click="delete" @click="open = false" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Yes, Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifikasi -->
            <div x-data="{ show: false, message: '', type: 'success' }" 
                 x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 5000)"
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
    </x-esd.layout>
</section>