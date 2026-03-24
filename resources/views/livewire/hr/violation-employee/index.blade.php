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
            Violation Employee
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Violation Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage all employee violation records
            </p>
        </div>
        <div class="flex gap-2">
            <flux:button wire:click="create" variant="primary" icon="plus">
                Add Violation
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
                <span x-show="{{ $search || $categoryFilter || $shiftFilter || $dateFrom || $dateUntil || $yearFilter || $monthFilter || count($selectedSubCategories) > 0 }}" 
                    class="ml-1 px-1.5 py-0.5 text-xs bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-300">
                    Active
                </span>
            </button>
            
            @if($search || $categoryFilter || $shiftFilter || $dateFrom || $dateUntil || $yearFilter || $monthFilter || count($selectedSubCategories) > 0)
            <flux:button wire:click="clearFilters" variant="ghost" size="sm">
                Clear All Filters
            </flux:button>
            @endif
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

                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Category</label>
                    <select wire:model.live="categoryFilter" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        <option value="">All Categories</option>
                        <option value="Kendaraan">Kendaraan</option>
                        <option value="Uniform">Uniform</option>
                        <option value="Membawa Barang Pribadi">Membawa Barang Pribadi</option>
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

                <!-- Sub Category Filter (only shown when Kendaraan is selected) -->
                @if($categoryFilter === 'Kendaraan')
                <div class="md:col-span-2 lg:col-span-4">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Sub Category (Kendaraan)</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 border border-zinc-200 dark:border-zinc-700 rounded-lg p-3">
                        @foreach($subCategoryOptions as $key => $value)
                            <label class="flex items-center gap-2">
                                <input 
                                    type="checkbox" 
                                    wire:model.live="selectedSubCategories" 
                                    value="{{ $key }}" 
                                    class="rounded border-zinc-300 dark:border-zinc-600"
                                >
                                <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $value }}</span>
                            </label>
                        @endforeach
                    </div>
                    @if(count($selectedSubCategories) > 0)
                        <div class="mt-2 text-xs text-blue-600 dark:text-blue-400">
                            Selected: {{ count($selectedSubCategories) }} sub category(ies)
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <flux:modal name="filter-modal" class="w-full max-w-2xl">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-zinc-800 dark:text-white">
                    Advanced Filters
                </h2>
                <flux:button 
                    @click="$dispatch('close-filter-modal')" 
                    icon="x-mark" 
                    variant="ghost" 
                    size="sm"
                    class="!p-1"
                />
            </div>

            <div class="space-y-6">
                <!-- Category Filter -->
                <div>
                    <flux:label>Category</flux:label>
                    <flux:select wire:model.live="categoryFilter" class="w-full">
                        <flux:select.option value="">All Categories</flux:select.option>
                        <flux:select.option value="Kendaraan">Kendaraan</flux:select.option>
                        <flux:select.option value="Uniform">Uniform</flux:select.option>
                        <flux:select.option value="Membawa Barang Pribadi">Membawa Barang Pribadi</flux:select.option>
                    </flux:select>
                </div>

                <!-- Sub Category Filter (only shown when Kendaraan is selected) -->
                @if($categoryFilter === 'Kendaraan')
                <div>
                    <flux:label>Sub Category (Kendaraan)</flux:label>
                    <div class="space-y-2 border border-zinc-200 dark:border-zinc-700 rounded-lg p-3 max-h-60 overflow-y-auto">
                        @foreach($subCategoryOptions as $key => $value)
                            <label class="flex items-center gap-2">
                                <input 
                                    type="checkbox" 
                                    wire:model.live="selectedSubCategories" 
                                    value="{{ $key }}" 
                                    class="rounded border-zinc-300 dark:border-zinc-600"
                                >
                                <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $value }}</span>
                            </label>
                        @endforeach
                    </div>
                    @if(count($selectedSubCategories) > 0)
                        <div class="mt-2 text-xs text-blue-600 dark:text-blue-400">
                            Selected: {{ count($selectedSubCategories) }} sub category(ies)
                        </div>
                    @endif
                </div>
                @endif

                <!-- Shift Filter -->
                <div>
                    <flux:label>Shift</flux:label>
                    <flux:select wire:model.live="shiftFilter" class="w-full">
                        <flux:select.option value="">All Shifts</flux:select.option>
                        <flux:select.option value="NS">Non Shift</flux:select.option>
                        <flux:select.option value="1">Shift 1</flux:select.option>
                        <flux:select.option value="2">Shift 2</flux:select.option>
                        <flux:select.option value="3">Shift 3</flux:select.option>
                    </flux:select>
                </div>

                <!-- Date Range Filters -->
                <div>
                    <flux:label>Date Range</flux:label>
                    <div class="grid grid-cols-2 gap-3">
                        <flux:input
                            wire:model.live="dateFrom"
                            type="date"
                            placeholder="Date From"
                        />
                        <flux:input
                            wire:model.live="dateUntil"
                            type="date"
                            placeholder="Date Until"
                        />
                    </div>
                </div>

                <!-- Year & Month Filters -->
                <div>
                    <flux:label>Year & Month</flux:label>
                    <div class="grid grid-cols-2 gap-3">
                        <flux:select wire:model.live="yearFilter">
                            <flux:select.option value="">All Years</flux:select.option>
                            @foreach($this->years as $year)
                                <flux:select.option value="{{ $year }}">{{ $year }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:select wire:model.live="monthFilter">
                            <flux:select.option value="">All Months</flux:select.option>
                            @foreach($this->months as $key => $month)
                                <flux:select.option value="{{ $key }}">{{ $month }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>

                <!-- Per Page -->
                <div>
                    <flux:label>Records per page</flux:label>
                    <flux:select wire:model.live="perPage" class="w-full">
                        <flux:select.option value="10">10 per page</flux:select.option>
                        <flux:select.option value="25">25 per page</flux:select.option>
                        <flux:select.option value="50">50 per page</flux:select.option>
                        <flux:select.option value="100">100 per page</flux:select.option>
                    </flux:select>
                </div>
            </div>

            <!-- Filter Actions -->
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                <flux:button wire:click="clearFilters" variant="outline" size="sm">
                    Clear All Filters
                </flux:button>
                <flux:button 
                    @click="$dispatch('close-filter-modal')" 
                    variant="primary" 
                    size="sm"
                >
                    Apply Filters
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <!-- Violations Table -->
    <flux:card class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-16">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NIK</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Department</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Shift</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Sub Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Plate</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Security</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($violations as $index => $violation)
                    @php
                        $subCats = $violation->sub_category ?? [];
                        $subCount = count($subCats);
                        $subColor = $this->getSubCategoryColor($subCount);
                        $subCategoryJson = json_encode($subCats);
                        $canEdit = \Carbon\Carbon::parse($violation->created_at)->diffInHours(now()) <= 24;
                    @endphp
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="violation-{{ $violation->id }}">
                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                            {{ $violations->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="font-mono text-sm text-zinc-700 dark:text-zinc-300">
                                {{ $violation->employee->nik ?? $violation->nik }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="text-sm font-semibold text-zinc-800 dark:text-white">
                                {{ $violation->employee->name ?? $violation->name }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <flux:badge size="sm" color="gray" variant="subtle">
                                {{ $violation->dept }}
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <flux:badge size="sm" color="blue" variant="subtle">
                                {{ $this->formatShift($violation->shift) }}
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <flux:badge size="sm" color="purple" variant="subtle">
                                {{ $violation->category }}
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <button 
                                wire:click="viewSubCategories('{{ addslashes($subCategoryJson) }}')"
                                class="inline-flex items-center gap-2 hover:opacity-80 transition-opacity"
                            >
                                <span class="inline-block px-3 py-1 text-sm font-medium text-white bg-blue-600 rounded-full cursor-pointer hover:bg-blue-700 transition">
                                    Klik Detail
                                </span>
                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold text-white bg-{{ $subColor }}-600 rounded-full min-w-[1.5rem] h-5">
                                    {{ $subCount }}
                                </span>
                            </button>
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                            {{ $violation->plat_motor ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                            {{ strtoupper($violation->security_name ?? '-') }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($violation->date)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-1">
                                <flux:button 
                                    wire:click="view({{ $violation->id }})" 
                                    size="sm" 
                                    variant="outline"
                                    icon="eye"
                                    class="!p-1.5"
                                    title="View details"
                                />
                                @if($canEdit)
                                <flux:button 
                                    wire:click="edit({{ $violation->id }})" 
                                    size="sm" 
                                    variant="outline"
                                    icon="pencil-square"
                                    class="!p-1.5"
                                    title="Edit record"
                                />
                                @endif
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
                                        No violations found
                                    </h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                        {{ $search ? 'Try adjusting your search query' : 'No violation data available' }}
                                    </p>
                                </div>
                                @if($search)
                                    <flux:button wire:click="$set('search', '')" size="sm">
                                        Clear Search
                                    </flux:button>
                                @else
                                    <flux:button wire:click="create" variant="primary" size="sm">
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
        @if($violations->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $violations->links() }}
        </div>
        @endif
    </flux:card>

    <!-- View Violation Modal -->
    <flux:modal wire:model="showViewModal" class="w-full max-w-4xl">
        <div class="flex flex-col max-h-[85vh]">
            <!-- Modal Header -->
            <div class="flex justify-between items-center px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-xl font-bold text-zinc-800 dark:text-white">
                    Violation Details
                </h2>
            </div>

            @if($selectedViolation)
            <!-- Modal Content - Scrollable -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                <!-- Personal & Violation Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="space-y-3">
                        <h3 class="text-md font-semibold text-zinc-800 dark:text-white border-l-3 border-blue-500 pl-3">
                            Personal Information
                        </h3>
                        <div class="space-y-2 bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">NIK</span>
                                <span class="font-mono text-sm text-zinc-800 dark:text-white">{{ $selectedViolation->employee->nik ?? $selectedViolation->nik }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">Name</span>
                                <span class="text-sm font-semibold text-zinc-800 dark:text-white">{{ $selectedViolation->employee->name ?? $selectedViolation->name }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">Department</span>
                                <span class="text-sm text-zinc-800 dark:text-white">{{ $selectedViolation->dept }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Violation Information -->
                    <div class="space-y-3">
                        <h3 class="text-md font-semibold text-zinc-800 dark:text-white border-l-3 border-red-500 pl-3">
                            Violation Information
                        </h3>
                        <div class="space-y-2 bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">Shift</span>
                                <flux:badge size="sm" color="blue">{{ $this->formatShift($selectedViolation->shift) }}</flux:badge>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">Category</span>
                                <flux:badge size="sm" color="purple">{{ $selectedViolation->category }}</flux:badge>
                            </div>
                            @if($selectedViolation->plat_motor)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">Plate Number</span>
                                <span class="font-mono text-sm text-zinc-800 dark:text-white">{{ $selectedViolation->plat_motor }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">Security</span>
                                <span class="text-sm text-zinc-800 dark:text-white">{{ strtoupper($selectedViolation->security_name) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">Date</span>
                                <span class="text-sm text-zinc-800 dark:text-white">{{ \Carbon\Carbon::parse($selectedViolation->date)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sub Categories -->
                @php $subCats = $selectedViolation->sub_category ?? []; @endphp
                @if(!empty($subCats))
                <div class="space-y-3">
                    <h3 class="text-md font-semibold text-zinc-800 dark:text-white border-l-3 border-green-500 pl-3">
                        Sub Categories
                    </h3>
                    <div class="flex flex-wrap gap-2 bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-4">
                        @foreach($subCats as $subCat)
                            <flux:badge size="sm" color="gray">{{ $subCat }}</flux:badge>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Reason & Remarks -->
                <div class="space-y-3">
                    <h3 class="text-md font-semibold text-zinc-800 dark:text-white border-l-3 border-yellow-500 pl-3">
                        Details
                    </h3>
                    <div class="space-y-3 bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-4">
                        <div>
                            <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Reason</div>
                            <div class="text-sm text-zinc-800 dark:text-white bg-white dark:bg-zinc-700/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-600">
                                {{ $selectedViolation->alasan }}
                            </div>
                        </div>
                        @if($selectedViolation->remarks)
                        <div>
                            <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Remarks</div>
                            <div class="text-sm text-zinc-800 dark:text-white bg-white dark:bg-zinc-700/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-600">
                                {{ $selectedViolation->remarks }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Photo Evidence -->
                @if($selectedViolation->photo)
                <div class="space-y-3">
                    <h3 class="text-md font-semibold text-zinc-800 dark:text-white border-l-3 border-indigo-500 pl-3">
                        Photo Evidence
                    </h3>
                    <div class="flex justify-center bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-4">
                        <img 
                            src="{{ asset('storage/' . $selectedViolation->photo) }}" 
                            class="max-w-full max-h-64 rounded-lg shadow-sm object-contain"
                            alt="Violation photo"
                        />
                    </div>
                </div>
                @endif

                <!-- Meta Information -->
                <div class="text-xs text-zinc-400 dark:text-zinc-500 pt-2 border-t border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center gap-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Created: {{ \Carbon\Carbon::parse($selectedViolation->created_at)->format('d M Y H:i') }} by {{ $selectedViolation->creator->name ?? '-' }}
                    </div>
                    @if($selectedViolation->updated_at && $selectedViolation->updated_at != $selectedViolation->created_at)
                    <div class="flex items-center gap-2 mt-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Updated: {{ \Carbon\Carbon::parse($selectedViolation->updated_at)->format('d M Y H:i') }} by {{ $selectedViolation->updater->name ?? '-' }}
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </flux:modal>

    <!-- Sub Category Modal -->
    <flux:modal wire:model="showSubCategoryModal" class="w-full max-w-lg">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-zinc-800 dark:text-white">
                    Sub Category Details
                </h2>
            </div>

            <div class="space-y-3">
                @if(!empty($selectedSubCategoriesModal))
                    @foreach($selectedSubCategoriesModal as $subCat)
                        <div class="p-3 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg">
                            {{ $subCat }}
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-zinc-500 dark:text-zinc-400">
                        No sub categories available
                    </div>
                @endif
            </div>
        </div>
    </flux:modal>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>