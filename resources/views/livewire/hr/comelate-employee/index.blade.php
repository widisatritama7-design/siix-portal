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
            @can('create comelate employee')
            <flux:button 
                variant="primary" 
                icon="plus" 
                href="{{ route('hr.comelate.create') }}"
                wire:navigate
            >
                Add New Record
            </flux:button>
            @endcan
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
            
            <div class="flex gap-2">
                @if($search || $departmentFilter || $shiftFilter || $dateFrom || $dateUntil || $yearFilter || $monthFilter)
                <flux:button wire:click="clearFilters" variant="ghost" size="sm">
                    Clear All Filters
                </flux:button>
                @endif
            </div>
        </div>
        
        <!-- Advanced Filters Card (Collapsible) -->
        <div x-show="showFilters" 
            x-transition.duration.300ms
            x-cloak
            class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6 mb-4">
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

    <!-- Comelate Table -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
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
                    @forelse($comelateEmployees as $item)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="comelate-{{ $item->id }}">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="font-mono text-sm text-zinc-700 dark:text-zinc-300">
                                {{ $item->employee->nik ?? $item->nik }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="text-sm font-semibold text-zinc-800 dark:text-white">
                                {{ $item->employee->Display_Name ?? $item->name }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <flux:badge size="sm" color="gray" variant="subtle">
                                {{ $item->employee->Departement ?? $item->department }}
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
                        <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap max-w-xs truncate" title="{{ $item->alasan_terlambat }}">
                            {{ Str::limit($item->alasan_terlambat, 30) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                            {{ $item->nama_security }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1">
                                @can('edit comelate employee')
                                    @php
                                        $canEdit = \Carbon\Carbon::parse($item->created_at)->diffInHours(now()) <= 24;
                                    @endphp
                                    @if($canEdit)
                                    <flux:button 
                                        wire:click="checkEdit({{ $item->id }})" 
                                        size="sm" 
                                        variant="outline"
                                        icon="pencil-square"
                                        class="!p-1.5"
                                        title="Edit record"
                                    />
                                    @endif
                                @endcan
                                @can('delete comelate employee')
                                <flux:button 
                                    wire:click="confirmDelete({{ $item->id }})" 
                                    size="sm" 
                                    variant="outline"
                                    icon="trash"
                                    class="!p-1.5 text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/50"
                                    title="Delete record"
                                />
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="px-4 py-12 text-center">
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
    <flux:modal wire:model="showViewModal" class="w-full max-w-4xl">
        <div class="flex flex-col max-h-[85vh]">
            <div class="flex justify-between items-center px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-xl font-bold text-zinc-800 dark:text-white">
                    Comelate Employee Details
                </h2>
                <flux:button 
                    icon="x-mark" 
                    size="sm" 
                    variant="ghost"
                    wire:click="$set('showViewModal', false)"
                    class="!p-1"
                />
            </div>

            @if($selectedComelate)
            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <h3 class="text-md font-semibold text-zinc-800 dark:text-white border-l-3 border-blue-500 pl-3">
                            Personal Information
                        </h3>
                        <div class="space-y-2 bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">NIK</span>
                                <span class="font-mono text-sm text-zinc-800 dark:text-white">{{ $selectedComelate->employee->nik ?? $selectedComelate->nik }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">Name</span>
                                <span class="text-sm font-semibold text-zinc-800 dark:text-white">{{ $selectedComelate->employee->name ?? $selectedComelate->name }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">Department</span>
                                <span class="text-sm text-zinc-800 dark:text-white">{{ $selectedComelate->employee->department ?? $selectedComelate->department }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-md font-semibold text-zinc-800 dark:text-white border-l-3 border-yellow-500 pl-3">
                            Attendance Information
                        </h3>
                        <div class="space-y-2 bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">Shift</span>
                                <flux:badge size="sm" color="blue">{{ $this->formatShift($selectedComelate->shift) }}</flux:badge>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">Jam Masuk</span>
                                <span class="text-sm text-zinc-800 dark:text-white">{{ $selectedComelate->jam_masuk ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">Jam Datang</span>
                                <span class="text-sm text-zinc-800 dark:text-white">{{ $selectedComelate->jam ? \Carbon\Carbon::parse($selectedComelate->jam)->format('H:i') : '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">Terlambat</span>
                                <flux:badge size="sm" color="yellow">{{ $this->formatCountJam($selectedComelate->count_jam) }}</flux:badge>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">Tanggal</span>
                                <span class="text-sm text-zinc-800 dark:text-white">{{ \Carbon\Carbon::parse($selectedComelate->tanggal)->format('d F Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <h3 class="text-md font-semibold text-zinc-800 dark:text-white border-l-3 border-green-500 pl-3">
                        Details
                    </h3>
                    <div class="space-y-3 bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-4">
                        <div>
                            <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Alasan Terlambat</div>
                            <div class="text-sm text-zinc-800 dark:text-white bg-white dark:bg-zinc-700/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-600">
                                {{ $selectedComelate->alasan_terlambat }}
                            </div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Nama Security</div>
                            <div class="text-sm text-zinc-800 dark:text-white bg-white dark:bg-zinc-700/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-600">
                                {{ $selectedComelate->nama_security }}
                            </div>
                        </div>
                        @if($selectedComelate->remarks)
                        <div>
                            <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Remarks</div>
                            <div class="text-sm text-zinc-800 dark:text-white bg-white dark:bg-zinc-700/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-600">
                                {{ $selectedComelate->remarks }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="text-xs text-zinc-400 dark:text-zinc-500 pt-2 border-t border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center gap-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Created: {{ $selectedComelate->created_at ? \Carbon\Carbon::parse($selectedComelate->created_at)->format('d M Y H:i') : '-' }} by {{ $selectedComelate->creator->name ?? '-' }}
                    </div>
                    @if($selectedComelate->updated_at && $selectedComelate->updated_at != $selectedComelate->created_at)
                    <div class="flex items-center gap-2 mt-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Updated: {{ $selectedComelate->updated_at ? \Carbon\Carbon::parse($selectedComelate->updated_at)->format('d M Y H:i') : '-' }} by {{ $selectedComelate->updater->name ?? '-' }}
                    </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-end gap-2 px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
                @php
                    $canEditModal = \Carbon\Carbon::parse($selectedComelate->created_at)->diffInHours(now()) <= 24;
                @endphp
                @if($canEditModal)
                <flux:button 
                    variant="primary"
                    href="{{ route('hr.comelate.edit', $selectedComelate->id) }}"
                    wire:navigate
                >
                    Edit Record
                </flux:button>
                @endif
                <flux:button 
                    variant="ghost" 
                    wire:click="$set('showViewModal', false)"
                >
                    Close
                </flux:button>
            </div>
            @endif
        </div>
    </flux:modal>

    <!-- Delete Modal with Reason -->
    <flux:modal wire:model="showDeleteModal" class="w-full max-w-md">
        <div class="p-4 sm:p-5">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-white flex items-center gap-2">
                    <flux:icon name="exclamation-triangle" class="w-5 h-5 text-red-500" />
                    Delete Record
                </h2>
            </div>

            <div class="mb-4">
                <flux:label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                    Reason to Delete <span class="text-red-500">*</span>
                </flux:label>
                <textarea 
                    wire:model="reason_to_delete"
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
                    wire:click="$set('showDeleteModal', false)"
                >
                    Cancel
                </flux:button>
                <flux:button 
                    variant="danger" 
                    wire:click="delete"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove>Yes, Delete</span>
                    <span wire:loading>Deleting...</span>
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('download-csv', (data) => {
                const blob = new Blob([data.content], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                const url = URL.createObjectURL(blob);
                
                link.setAttribute('href', url);
                link.setAttribute('download', data.fileName);
                link.style.display = 'none';
                
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                URL.revokeObjectURL(url);
            });
        });
    </script>
</div>