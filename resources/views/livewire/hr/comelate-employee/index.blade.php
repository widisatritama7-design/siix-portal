<div class="p-1 space-y-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            HR
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Comelate Employee
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Comelate Employee Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage employee lateness records
            </p>
        </div>

        <div class="flex gap-2">
            <flux:button 
                variant="primary" 
                icon="plus" 
                href="{{ route('hr.comelate.create') }}"
                wire:navigate
            >
                Add New Record
            </flux:button>
        </div>
    </div>

    <!-- Filters Section with Collapsible -->
    <div x-data="{ showFilters: false }">
        <!-- Filter Toggle Button -->
        <div class="flex justify-between items-center mb-4">
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
                <span x-show="{{ $search || $departmentFilter || $shiftFilter || $dateFrom || $dateUntil || $yearFilter || $monthFilter }}" 
                    class="ml-1 px-1.5 py-0.5 text-xs bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-300">
                    Active
                </span>
            </button>
            
            @if($search || $departmentFilter || $shiftFilter || $dateFrom || $dateUntil || $yearFilter || $monthFilter)
            <flux:button wire:click="clearFilters" variant="ghost" size="sm">
                Clear All Filters
            </flux:button>
            @endif
        </div>
        
        <!-- Advanced Filters Card (Collapsible) -->
        <div x-show="showFilters" 
            x-transition.duration.300ms
            x-cloak
            class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Search</label>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search by NIK, name, department..."
                        class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white"
                    >
                </div>

                <!-- Department Filter -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Department</label>
                    <select wire:model.live="departmentFilter" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        <option value="">All Departments</option>
                        @foreach($this->departments as $dept)
                            <option value="{{ $dept }}">{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Shift Filter -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Shift</label>
                    <select wire:model.live="shiftFilter" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        <option value="">All Shifts</option>
                        @foreach($this->shifts as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Per Page -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Per Page</label>
                    <select wire:model.live="perPage" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date From</label>
                    <input type="date" wire:model.live="dateFrom" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                </div>

                <!-- Date Until -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date Until</label>
                    <input type="date" wire:model.live="dateUntil" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                </div>

                <!-- Year Filter -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Year</label>
                    <select wire:model.live="yearFilter" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        <option value="">All Years</option>
                        @foreach($this->years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Month Filter -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Month</label>
                    <select wire:model.live="monthFilter" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        <option value="">All Months</option>
                        @foreach($this->months as $key => $month)
                            <option value="{{ $key }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <flux:card class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NIK</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Department</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Shift</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Jam Masuk</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Jam Datang</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Terlambat</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Alasan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Security</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($comelateEmployees as $index => $item)
                    @php
                        $canEdit = \Carbon\Carbon::parse($item->created_at)->diffInHours(now()) <= 24;
                    @endphp
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="comelate-{{ $item->id }}">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="font-mono text-sm text-zinc-700 dark:text-zinc-300">
                                {{ $item->employee->nik ?? $item->nik }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="text-sm font-semibold text-zinc-800 dark:text-white">
                                {{ $item->employee->name ?? $item->name }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <flux:badge size="sm" color="gray" variant="subtle">
                                {{ $item->department }}
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <flux:badge size="sm" color="blue" variant="subtle">
                                {{ $this->formatShift($item->shift) }}
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                            {{ $item->jam_masuk ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                            {{ $item->jam ? \Carbon\Carbon::parse($item->jam)->format('H:i') : '-' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $delayText = $this->formatCountJam($item->count_jam);
                                $delayColor = $item->count_jam > 0 ? 'yellow' : 'green';
                            @endphp
                            <flux:badge size="sm" :color="$delayColor">
                                {{ $delayText }}
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                            {{ $item->alasan_terlambat }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                            {{ $item->nama_security }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1">
                                @if($canEdit)
                                <flux:button 
                                    wire:click="checkEdit({{ $item->id }})"
                                    size="sm"
                                    icon="pencil-square"
                                    class="!p-2 text-yellow-600 hover:bg-yellow-50 dark:text-yellow-400 dark:hover:bg-yellow-950/50"
                                    title="Edit record"
                                />
                                @endif
                                <flux:button 
                                    wire:click="confirmDelete({{ $item->id }})"
                                    size="sm"
                                    icon="trash"
                                    class="!p-2 text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/50"
                                    title="Delete record"
                                />
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <flux:icon name="document-text" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        No records found
                                    </h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                        {{ $search ? 'Try adjusting your search query' : 'No comelate employee data available' }}
                                    </p>
                                </div>
                                @if($search)
                                    <flux:button wire:click="$set('search', '')" size="sm">
                                        Clear Search
                                    </flux:button>
                                @else
                                    <flux:button 
                                        variant="primary" 
                                        size="sm"
                                        href="{{ route('hr.comelate.create') }}"
                                        wire:navigate
                                    >
                                        Add Your First Record
                                    </flux:button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($comelateEmployees->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $comelateEmployees->links() }}
        </div>
        @endif
    </flux:card>

    <!-- View Modal -->
    @if($showViewModal && $selectedComelate)
    <div x-data="{ open: true }" 
         x-show="open" 
         @click.away="open = false; $wire.set('showViewModal', false)"
         x-cloak>
        
        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false; $wire.set('showViewModal', false)"></div>
        
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4 flex justify-between items-center">
                    <h2 class="text-xl font-bold">Comelate Employee Details</h2>
                    <flux:button 
                        icon="x-mark" 
                        size="sm" 
                        variant="ghost"
                        @click="open = false; $wire.set('showViewModal', false)"
                        class="!p-1"
                    />
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <flux:label class="text-xs text-zinc-500">NIK</flux:label>
                            <p class="text-sm font-medium">{{ $selectedComelate->employee->nik ?? $selectedComelate->nik }}</p>
                        </div>
                        <div>
                            <flux:label class="text-xs text-zinc-500">Name</flux:label>
                            <p class="text-sm font-medium">{{ $selectedComelate->employee->name ?? $selectedComelate->name }}</p>
                        </div>
                        <div>
                            <flux:label class="text-xs text-zinc-500">Department</flux:label>
                            <p class="text-sm font-medium">{{ $selectedComelate->department }}</p>
                        </div>
                        <div>
                            <flux:label class="text-xs text-zinc-500">Shift</flux:label>
                            <p class="text-sm font-medium">{{ $this->formatShift($selectedComelate->shift) }}</p>
                        </div>
                        <div>
                            <flux:label class="text-xs text-zinc-500">Jam Masuk</flux:label>
                            <p class="text-sm font-medium">{{ $selectedComelate->jam_masuk ?? '-' }}</p>
                        </div>
                        <div>
                            <flux:label class="text-xs text-zinc-500">Jam Datang</flux:label>
                            <p class="text-sm font-medium">{{ $selectedComelate->jam ? \Carbon\Carbon::parse($selectedComelate->jam)->format('H:i') : '-' }}</p>
                        </div>
                        <div>
                            <flux:label class="text-xs text-zinc-500">Terlambat</flux:label>
                            <p class="text-sm font-medium">{{ $this->formatCountJam($selectedComelate->count_jam) }}</p>
                        </div>
                        <div>
                            <flux:label class="text-xs text-zinc-500">Tanggal</flux:label>
                            <p class="text-sm font-medium">{{ \Carbon\Carbon::parse($selectedComelate->tanggal)->format('d F Y') }}</p>
                        </div>
                        <div>
                            <flux:label class="text-xs text-zinc-500">Alasan Terlambat</flux:label>
                            <p class="text-sm font-medium">{{ $selectedComelate->alasan_terlambat }}</p>
                        </div>
                        <div>
                            <flux:label class="text-xs text-zinc-500">Nama Security</flux:label>
                            <p class="text-sm font-medium">{{ $selectedComelate->nama_security }}</p>
                        </div>
                        <div class="col-span-2">
                            <flux:label class="text-xs text-zinc-500">Remarks</flux:label>
                            <p class="text-sm font-medium">{{ $selectedComelate->remarks ?? '-' }}</p>
                        </div>
                        <div>
                            <flux:label class="text-xs text-zinc-500">Created By</flux:label>
                            <p class="text-sm font-medium">{{ $selectedComelate->creator->name ?? '-' }}</p>
                        </div>
                        <div>
                            <flux:label class="text-xs text-zinc-500">Created At</flux:label>
                            <p class="text-sm font-medium">{{ $selectedComelate->created_at ? $selectedComelate->created_at->format('d F Y H:i') : '-' }}</p>
                        </div>
                        @if($selectedComelate->updated_by)
                        <div>
                            <flux:label class="text-xs text-zinc-500">Updated By</flux:label>
                            <p class="text-sm font-medium">{{ $selectedComelate->updater->name ?? '-' }}</p>
                        </div>
                        <div>
                            <flux:label class="text-xs text-zinc-500">Updated At</flux:label>
                            <p class="text-sm font-medium">{{ $selectedComelate->updated_at ? $selectedComelate->updated_at->format('d F Y H:i') : '-' }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="sticky bottom-0 bg-white dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-700 px-6 py-4 flex justify-end gap-2">
                    @php
                        $canEditModal = \Carbon\Carbon::parse($selectedComelate->created_at)->diffInHours(now()) <= 24;
                    @endphp
                    @if($canEditModal)
                    <flux:button 
                        variant="primary"
                        href="{{ route('hr.comelate.edit', $selectedComelate->id) }}"
                        wire:navigate
                        @click="open = false; $wire.set('showViewModal', false)"
                    >
                        Edit Record
                    </flux:button>
                    @endif
                    <flux:button 
                        variant="ghost"
                        @click="open = false; $wire.set('showViewModal', false)"
                    >
                        Close
                    </flux:button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Modal with Reason -->
    <div x-data="{ showDeleteModal: false, deleteId: null }" 
        x-show="showDeleteModal" 
        @open-delete-modal.window="showDeleteModal = true; deleteId = $event.detail.id; $wire.set('deleteId', $event.detail.id)"
        @close-delete-modal.window="showDeleteModal = false"
        x-cloak>
        
        <div class="fixed inset-0 bg-black/50 z-40" @click="showDeleteModal = false"></div>
        
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                            <flux:icon name="exclamation-triangle" class="w-6 h-6 text-red-600 dark:text-red-400" />
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Delete Record</h3>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Please provide a reason for deletion</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <flux:label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Reason to Delete <span class="text-red-500">*</span>
                        </flux:label>
                        <textarea 
                            wire:model="reason_to_delete"
                            wire:keydown.enter.prevent=""
                            rows="3"
                            class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white @error('reason_to_delete') border-red-500 @enderror"
                            placeholder="Enter reason for deleting this record..."
                        ></textarea>
                        @error('reason_to_delete') 
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <flux:button 
                            variant="ghost" 
                            @click="showDeleteModal = false; $wire.set('reason_to_delete', '')"
                        >
                            Cancel
                        </flux:button>
                        <flux:button 
                            variant="danger" 
                            wire:click="delete"
                            class="bg-red-600 hover:bg-red-700"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove>Yes, Delete</span>
                            <span wire:loading>Deleting...</span>
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>