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
    <div x-data="{ showFilters: true }" class="mt-4 mb-6">
        <!-- Filters Section with Collapsible -->
        <div x-show="showFilters" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 transform -translate-y-4 scale-95"
            x-cloak
            class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="grid grid-cols-1 md:grid-cols-7 gap-4">
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

            <!-- Clear Filters Button - Only show when any filter is active -->
            @if($search || $filterDept || $filterCategory || $filterYear || $filterMonth || $filterDateFrom || $filterDateUntil)
            <div class="flex justify-end mt-4">
                <button wire:click="clearFilters" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-red-600 rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 dark:bg-red-500 dark:hover:bg-red-600 dark:border-red-500 transition-all duration-200 ease-in-out transform hover:scale-105 active:scale-95">
                    Clear All Filters
                </button>
            </div>
            @endif
        </div>
    </div>
    @endif

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Tabs Navigation -->
    <div class="mt-6 border-b border-zinc-200 dark:border-zinc-700">
        <!-- Scrollable Tabs Container - Hidden scrollbar -->
        <div class="relative">
            <div class="overflow-x-auto scrollbar-hide">
                <div class="flex flex-nowrap gap-1 min-w-max justify-center">
                    <!-- All Tab -->
                    <button 
                        wire:click="setTab('all')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'all' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                    >
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        All
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'all' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $tabCounts['all'] ?? 0 }}
                        </span>
                        @if($activeTab === 'all')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600 dark:bg-blue-400 rounded-t-full"></div>
                        @endif
                    </button>

                    <!-- Waiting Received Tab -->
                    <button 
                        wire:click="setTab('waiting_received')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'waiting_received' ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                    >
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Waiting Received
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'waiting_received' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $tabCounts['waiting_received'] ?? 0 }}
                        </span>
                        @if($activeTab === 'waiting_received')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-yellow-600 dark:bg-yellow-400 rounded-t-full"></div>
                        @endif
                    </button>

                    <!-- Received Tab -->
                    <button 
                        wire:click="setTab('received')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'received' ? 'text-green-600 dark:text-green-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                    >
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Received
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'received' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $tabCounts['received'] ?? 0 }}
                        </span>
                        @if($activeTab === 'received')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-green-600 dark:bg-green-400 rounded-t-full"></div>
                        @endif
                    </button>

                    <!-- Rejected Tab -->
                    <button 
                        wire:click="setTab('rejected')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'rejected' ? 'text-red-600 dark:text-red-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                    >
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Rejected
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'rejected' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $tabCounts['rejected'] ?? 0 }}
                        </span>
                        @if($activeTab === 'rejected')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-red-600 dark:bg-red-400 rounded-t-full"></div>
                        @endif
                    </button>

                    <!-- Due This Week Tab -->
                    <button 
                        wire:click="setTab('due_this_week')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'due_this_week' ? 'text-orange-600 dark:text-orange-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                    >
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Due This Week
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'due_this_week' ? 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $tabCounts['due_this_week'] ?? 0 }}
                        </span>
                        @if($activeTab === 'due_this_week')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-orange-600 dark:bg-orange-400 rounded-t-full"></div>
                        @endif
                    </button>

                    <!-- Waiting Distribute Tab -->
                    <button 
                        wire:click="setTab('waiting_distribute')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'waiting_distribute' ? 'text-purple-600 dark:text-purple-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                    >
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Waiting Distribute
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'waiting_distribute' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $tabCounts['waiting_distribute'] ?? 0 }}
                        </span>
                        @if($activeTab === 'waiting_distribute')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-purple-600 dark:bg-purple-400 rounded-t-full"></div>
                        @endif
                    </button>

                    <!-- Distributed Tab -->
                    <button 
                        wire:click="setTab('distributed')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'distributed' ? 'text-teal-600 dark:text-teal-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                    >
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Distributed
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'distributed' ? 'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $tabCounts['distributed'] ?? 0 }}
                        </span>
                        @if($activeTab === 'distributed')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-teal-600 dark:bg-teal-400 rounded-t-full"></div>
                        @endif
                    </button>
                </div>
            </div>
        </div>
    </div>

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
    <flux:card class="mt-6 p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-center sticky left-0 bg-zinc-50 dark:bg-zinc-700/50 z-10 whitespace-nowrap">
                            <input type="checkbox" wire:model.live="selectAll" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700">
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Category</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Description</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Department</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Due Date</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Received Info</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Distributed Info</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">PIC</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap md:sticky md:right-0 bg-zinc-50 dark:bg-zinc-800/50 md:z-20">Actions</th>
                    <tr>
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
                        <td class="px-4 py-3 text-center sticky left-0 bg-inherit z-10 whitespace-nowrap">
                            <input type="checkbox" 
                                wire:model.live="selectedSubmissions" 
                                value="{{ $submission->id }}"
                                class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700">
                        </td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                {{ $submission->category_document }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <div class="text-sm">
                                <div class="font-medium text-zinc-900 dark:text-white">{{ $submission->description }}</div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">Rev : {{ $submission->revision }}</div>
                                @if($submission->remarks)
                                <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">{{ Str::limit($submission->remarks, 50) }}</div>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-zinc-700 dark:text-zinc-300 whitespace-nowrap">
                            {{ $submission->department->dept_name ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
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
                        <td class="px-4 py-3 text-center whitespace-nowrap">
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
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <div class="text-sm">
                                @if($submission->received_by || $submission->received_at)
                                    <div class="text-zinc-700 dark:text-zinc-300">
                                        {{ $submission->received_by ?? '-' }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                        {{ $submission->received_at ? \Carbon\Carbon::parse($submission->received_at)->format('d M Y H:i') : '-' }}
                                    </div>
                                @else
                                    <span class="text-zinc-400 dark:text-zinc-500">-</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <div class="text-sm">
                                @if($submission->distributed_by || $submission->distributed_at)
                                    <div class="text-zinc-700 dark:text-zinc-300">
                                        {{ $submission->distributed_by ?? '-' }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                        {{ $submission->distributed_at ? \Carbon\Carbon::parse($submission->distributed_at)->format('d M Y H:i') : '-' }}
                                    </div>
                                @else
                                    <span class="text-zinc-400 dark:text-zinc-500">-</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-zinc-700 dark:text-zinc-300 whitespace-nowrap">
                            {{ $submission->pic ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3 text-center md:sticky md:right-0 bg-white dark:bg-zinc-900 md:z-10 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1">
                                <!-- View Button -->
                                <flux:tooltip content="View Details" position="bottom">
                                    <flux:button 
                                        wire:click="goToShow({{ $submission->id }})"
                                        size="sm"
                                        icon="eye"
                                        variant="primary"
                                        color="blue"
                                        class="!p-2"
                                        title="View details"
                                    />
                                </flux:tooltip>

                                <!-- Receive Button -->
                                @can('receive submissions')
                                    @if($submission->canReceive())
                                    <flux:tooltip content="Receive/Reject" position="bottom">
                                        <flux:button 
                                            wire:click="goToReceive({{ $submission->id }})"
                                            size="sm"
                                            icon="check-circle"
                                            variant="primary"
                                            color="yellow"
                                            class="!p-2"
                                            title="Receive or reject submission"
                                        />
                                    </flux:tooltip>
                                    @endif
                                @endcan

                                <!-- Mark Distributed Button -->
                                @if($submission->canMarkDistributed())
                                <flux:tooltip content="Mark as Distributed" position="bottom">
                                    <flux:button 
                                        wire:click="goToDistribute({{ $submission->id }})"
                                        size="sm"
                                        icon="check-circle"
                                        variant="primary"
                                        color="purple"
                                        class="!p-2"
                                        title="Mark as distributed"
                                    />
                                </flux:tooltip>
                                @endif

                                <!-- Edit Button -->
                                @can('edit submissions')
                                    @if($submission->canEdit() && $submission->created_at->diffInHours(now()) <= 24)
                                    <flux:tooltip content="Edit" position="bottom">
                                        <flux:button 
                                            wire:click="goToEdit({{ $submission->id }})"
                                            size="sm"
                                            icon="pencil-square"
                                            variant="primary"
                                            color="blue"
                                            class="!p-2"
                                            title="Edit submission"
                                        />
                                    </flux:tooltip>
                                    @endif
                                @endcan

                                <!-- Delete Button -->
                                @can('delete submissions')
                                    @if($submission->canDelete() && $submission->created_at->diffInHours(now()) <= 24)
                                    <flux:tooltip content="Delete" position="bottom">
                                        <flux:button 
                                            wire:click="goToDelete({{ $submission->id }})"
                                            size="sm"
                                            icon="trash"
                                            variant="primary"
                                            color="red"
                                            class="!p-2"
                                            title="Delete submission"
                                        />
                                    </flux:tooltip>
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-4 py-12 text-center">
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
<style>
    .overflow-x-auto {
        position: relative;
        z-index: 1;
    }
    
    thead tr th.sticky,
    tbody tr td.sticky {
        position: sticky;
        z-index: 10;
    }
    
    thead tr th.sticky {
        z-index: 20;
    }
    /* Hide scrollbar for Chrome, Safari and Opera */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
        
    /* Hide scrollbar for IE, Edge and Firefox */
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>