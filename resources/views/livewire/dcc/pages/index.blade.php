<div>
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Submission Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage DCC submissions and documents
            </p>
        </div>
        
        <!-- Tombol Add Submission -->
        @can('create submissions')
        <button 
            wire:click="goToCreate"
            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200"
        >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Submission
        </button>
        @endcan
    </div>

    <!-- Filter Toggle Button -->
    <div class="flex justify-end mt-6">
        <button 
            wire:click="$toggle('showFilters')" 
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-zinc-700 bg-white border border-zinc-300 rounded-lg hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-400 dark:border-zinc-600 dark:hover:bg-zinc-700"
        >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
            </svg>
            {{ $showFilters ? 'Hide Filters' : 'Show Filters' }}
        </button>
    </div>

    <!-- Advanced Filters -->
    @if($showFilters)
    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6 mt-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Search</label>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search..."
                    class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white"
                >
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Status</label>
                <select wire:model.live="filterStatus" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    <option value="">All Status</option>
                    <option value="Waiting Received">Waiting Received</option>
                    <option value="Received">Received</option>
                    <option value="Completed">Completed</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </div>

            <!-- Status Distribute Filter -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Status Distribute</label>
                <select wire:model.live="filterDistributed" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    <option value="">All Status</option>
                    <option value="Distributed">Distributed</option>
                    <option value="Waiting Distribute">Waiting Distribute</option>
                </select>
            </div>

            <!-- Department Filter -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Department</label>
                <select wire:model.live="filterDept" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    <option value="">All Departments</option>
                    @foreach($allDepartments as $dept)
                        <option value="{{ $dept->dept_name }}">{{ $dept->dept_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Category</label>
                <select wire:model.live="filterCategory" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Year Filter -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Year</label>
                <select wire:model.live="filterYear" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    <option value="">All Years</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Month Filter -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Month</label>
                <select wire:model.live="filterMonth" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    <option value="">All Months</option>
                    @foreach($months as $num => $name)
                        <option value="{{ $num }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date From -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date From</label>
                <input type="date" wire:model.live="filterDateFrom" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
            </div>

            <!-- Date Until -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date Until</label>
                <input type="date" wire:model.live="filterDateUntil" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
            </div>
        </div>

        <!-- Clear Filters Button -->
        <div class="flex justify-end mt-4">
            <button wire:click="clearFilters" class="px-4 py-2 text-sm font-medium text-zinc-700 bg-white border border-zinc-300 rounded-lg hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-400 dark:border-zinc-600 dark:hover:bg-zinc-700">
                Clear All Filters
            </button>
        </div>
    </div>
    @endif

    <!-- Bulk Actions -->
    @if(count($selectedSubmissions) > 0)
    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg flex items-center justify-between mt-6">
        <span class="text-sm font-medium text-blue-700 dark:text-blue-300">
            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ count($selectedSubmissions) }} submissions selected
        </span>
        <div class="flex gap-2">
            @can('receive submissions')
            <button wire:click="bulkReceive" class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Mark as Received
            </button>
            @endcan

            <button wire:click="bulkMarkDistributed" class="inline-flex items-center px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Mark as Distributed
            </button>

            <button wire:click="$set('selectedSubmissions', [])" class="inline-flex items-center px-3 py-1.5 bg-zinc-200 hover:bg-zinc-300 text-zinc-700 text-sm font-medium rounded-lg transition-colors duration-200 dark:bg-zinc-700 dark:hover:bg-zinc-600 dark:text-zinc-300">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Clear Selection
            </button>
        </div>
    </div>
    @endif

    <!-- Submissions Table -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-left sticky left-0 bg-zinc-50 dark:bg-zinc-700/50 z-10 whitespace-nowrap">
                            <input type="checkbox" wire:model.live="selectAll" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Description</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Department</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Due Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Received By</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Received At</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Distributed By</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Distributed At</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">PIC</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Created By</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($submissions as $submission)
                    @php
                        $dueDateLabel = $submission->dueDateLabel;
                        $rowClass = '';
                        if ($submission->due_date && $submission->due_date->isPast() && $submission->status === 'Waiting Received') {
                            $rowClass = 'bg-red-50 dark:bg-red-900/20';
                        } elseif ($submission->due_date && $submission->due_date->isToday() && $submission->status === 'Waiting Received') {
                            $rowClass = 'bg-yellow-50 dark:bg-yellow-900/20';
                        }
                    @endphp
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors {{ $rowClass }}"
                        wire:key="submission-{{ $submission->id }}">
                        <td class="px-4 py-3 sticky left-0 bg-inherit z-10 whitespace-nowrap">
                            <input type="checkbox" 
                                wire:model.live="selectedSubmissions" 
                                value="{{ $submission->id }}"
                                class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700">
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                {{ $submission->category_document }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-sm">
                                <div class="font-medium text-zinc-900 dark:text-white whitespace-nowrap">{{ $submission->description }}</div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">Rev: {{ $submission->revision }}</div>
                                @if($submission->remarks)
                                <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 whitespace-nowrap">{{ Str::limit($submission->remarks, 50) }}</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 whitespace-nowrap">
                            {{ $submission->department->dept_name ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="space-y-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($submission->status === 'Waiting Received') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                    @elseif($submission->status === 'Received') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                    @elseif($submission->status === 'Completed') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                    @elseif($submission->status === 'Rejected') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300
                                    @endif">
                                    {{ $submission->status }}
                                </span>
                                @if($submission->status_distribute === 'Distributed')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                    Distributed
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-sm">
                                <div class="text-zinc-700 dark:text-zinc-300">{{ $submission->due_date?->format('d M Y') ?? '-' }}</div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium mt-1
                                    @if($dueDateLabel['color'] === 'red') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                    @elseif($dueDateLabel['color'] === 'yellow') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                    @elseif($dueDateLabel['color'] === 'green') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300
                                    @endif">
                                    {{ $dueDateLabel['label'] }}
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 whitespace-nowrap">
                            {{ $submission->received_by ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 whitespace-nowrap">
                            @if($submission->received_at)
                                {{ \Carbon\Carbon::parse($submission->received_at)->format('d M Y H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 whitespace-nowrap">
                            {{ $submission->distributed_by ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 whitespace-nowrap">
                            @if($submission->distributed_at)
                                {{ \Carbon\Carbon::parse($submission->distributed_at)->format('d M Y H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 whitespace-nowrap">
                            {{ $submission->pic ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-sm">
                                <div class="text-zinc-700 dark:text-zinc-300">{{ $submission->creator->name ?? 'N/A' }}</div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $submission->created_at->format('d M Y H:i') }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1">
                                <!-- View Button -->
                                <button 
                                    wire:click="goToShow({{ $submission->id }})"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors dark:text-blue-400 dark:hover:bg-blue-950/50"
                                    title="View details"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>

                                <!-- Receive Button -->
                                @can('receive submissions')
                                    @if($submission->canReceive())
                                    <button 
                                        wire:click="goToReceive({{ $submission->id }})"
                                        class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors dark:text-yellow-400 dark:hover:bg-yellow-950/50"
                                        title="Receive/Reject"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                    @endif
                                @endcan

                                <!-- Mark Distributed Button -->
                                @if($submission->canMarkDistributed())
                                <button 
                                    wire:click="goToDistribute({{ $submission->id }})"
                                    class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors dark:text-purple-400 dark:hover:bg-purple-950/50"
                                    title="Mark as Distributed"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                                @endif

                                <!-- Edit Button -->
                                @can('edit submissions')
                                    @if($submission->canEdit() && $submission->created_at->diffInHours(now()) <= 24)
                                    <button 
                                        wire:click="goToEdit({{ $submission->id }})"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors dark:text-blue-400 dark:hover:bg-blue-950/50"
                                        title="Edit submission"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    @endif
                                @endcan

                                <!-- Delete Button -->
                                @can('delete submissions')
                                    @if($submission->canDelete() && $submission->created_at->diffInHours(now()) <= 24)
                                    <button 
                                        wire:click="goToDelete({{ $submission->id }})"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors dark:text-red-400 dark:hover:bg-red-950/50"
                                        title="Delete submission"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="13" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-24 h-24 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        No submissions found
                                    </h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                        {{ $search ? 'Try adjusting your search query' : 'Get started by creating a new submission' }}
                                    </p>
                                </div>
                                @if($search || $filterStatus || $filterDept || $filterCategory)
                                    <button wire:click="clearFilters" class="px-4 py-2 text-sm font-medium text-zinc-700 bg-white border border-zinc-300 rounded-lg hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-400 dark:border-zinc-600 dark:hover:bg-zinc-700">
                                        Clear Filters
                                    </button>
                                @else
                                    @can('create submissions')
                                    <button 
                                        wire:click="goToCreate"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200"
                                    >
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Add Your First Submission
                                    </button>
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
        @if($submissions->hasPages())
        <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700">
            {{ $submissions->links() }}
        </div>
        @endif
    </flux:card>
</div>