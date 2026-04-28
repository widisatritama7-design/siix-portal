<div class="p-1 space-y-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            PROD
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            MS
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Master Sample
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header section - UBAH menjadi: -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Master Sample Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage master samples for MS Monitoring
            </p>
        </div>

        <div class="flex gap-2">
            @if(count($selectedSamples) > 0)
            <flux:button 
                variant="primary" 
                icon="printer" 
                color="green"
                wire:click="bulkPrintLabel"
                class="bg-green-600 hover:bg-green-700"
            >
                Print Label ({{ count($selectedSamples) }})
            </flux:button>
            @endif

            @can('create master sample')
            <flux:button 
                variant="primary" 
                icon="plus" 
                class="bg-blue-600 hover:bg-blue-700"
                wire:click="resetForm"
                x-on:click="$dispatch('open-modal', 'master-sample-form-modal')"
            >
                Add New Master Sample
            </flux:button>
            @endcan
        </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-col sm:flex-row gap-3 justify-between mb-4">
        <div class="flex flex-wrap gap-2">
            <div class="w-48">
                <select wire:model.live="filterCustomer" 
                        class="w-full px-3 py-2 pr-6 border rounded-lg bg-white dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none cursor-pointer"
                        style="background-position: right 0.5rem center; background-size: 1rem; background-repeat: no-repeat; background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 9l-7 7-7-7\'%3E%3C/path%3E%3C/svg%3E');">
                    <option value="">All Customers</option>
                    @if(is_array($customerFilterOptions) || is_object($customerFilterOptions))
                        @foreach($customerFilterOptions as $key => $value)
                            <option value="{{ is_string($value) ? $value : $key }}">{{ is_string($value) ? $value : $key }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="w-48">
                <select wire:model.live="filterNameOrMc" 
                        class="w-full px-3 py-2 pr-6 border rounded-lg bg-white dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none cursor-pointer"
                        style="background-position: right 0.5rem center; background-size: 1rem; background-repeat: no-repeat; background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 9l-7 7-7-7\'%3E%3C/path%3E%3C/svg%3E');">
                    <option value="">All Name/MC</option>
                    @if(is_array($nameFilterOptions) || is_object($nameFilterOptions))
                        @foreach($nameFilterOptions as $key => $value)
                            <option value="{{ is_string($value) ? $value : $key }}">{{ is_string($value) ? $value : $key }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="w-full sm:w-64">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search samples..."
                icon="magnifying-glass"
                clearable
            />
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="mt-6 border-b border-zinc-200 dark:border-zinc-700">
        <div class="relative">
            <div class="overflow-x-auto scrollbar-hide">
                <div class="flex flex-nowrap gap-1 justify-center">
                    
                    <!-- Active Tab -->
                    <button 
                        wire:click="setTab('active')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'active' ? 'text-green-600 dark:text-green-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                    >
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Active
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $tabCounts['active'] ?? 0 }}
                        </span>
                        @if($activeTab === 'active')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-green-600 dark:bg-green-400 rounded-t-full"></div>
                        @endif
                    </button>

                    <!-- Expired Tab -->
                    <button 
                        wire:click="setTab('expired')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'expired' ? 'text-red-600 dark:text-red-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                    >
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Expired
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'expired' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $tabCounts['expired'] ?? 0 }}
                        </span>
                        @if($activeTab === 'expired')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-red-600 dark:bg-red-400 rounded-t-full"></div>
                        @endif
                    </button>

                    <!-- EOL Tab -->
                    <button 
                        wire:click="setTab('eol')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'eol' ? 'text-gray-600 dark:text-gray-400' : 'text-gray-500 hover:text-gray-700 dark:text-gray-500 dark:hover:text-gray-300' }}"
                    >
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                        </svg>
                        EOL
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'eol' ? 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $tabCounts['eol'] ?? 0 }}
                        </span>
                        @if($activeTab === 'eol')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gray-500 dark:bg-gray-400 rounded-t-full"></div>
                        @endif
                    </button>

                    <!-- Under PE Tab -->
                    <button 
                        wire:click="setTab('under_pe')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'under_pe' ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                    >
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Under PE
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'under_pe' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $tabCounts['under_pe'] ?? 0 }}
                        </span>
                        @if($activeTab === 'under_pe')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-yellow-600 dark:bg-yellow-400 rounded-t-full"></div>
                        @endif
                    </button>

                    <!-- Expire This Month Tab -->
                    <button 
                        wire:click="setTab('expire_this_month')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'expire_this_month' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                    >
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Expire This Month
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'expire_this_month' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $tabCounts['expire_this_month'] ?? 0 }}
                        </span>
                        @if($activeTab === 'expire_this_month')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600 dark:bg-blue-400 rounded-t-full"></div>
                        @endif
                    </button>

                    <!-- All Tab -->
                    <button 
                        wire:click="setTab('all')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'all' ? 'text-purple-600 dark:text-purple-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                    >
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        All
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'all' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $tabCounts['all'] ?? 0 }}
                        </span>
                        @if($activeTab === 'all')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-purple-600 dark:bg-purple-400 rounded-t-full"></div>
                        @endif
                    </button>

                </div>
            </div>
        </div>
    </div>

    <!-- Master Samples Table -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
        <!-- Master Samples Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                            <input type="checkbox" 
                                wire:model.live="selectAll" 
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Model Name</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Sample OK</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Sample NG</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name/MC</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Rack</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Expired Date</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Last Use</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Days Left</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($masterSamples as $index => $sample)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="sample-{{ $sample->id }}">
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" 
                                wire:model.live="selectedSamples" 
                                value="{{ $sample->id }}"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $masterSamples->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div>
                                    <span class="text-sm font-semibold text-zinc-800 dark:text-white block">
                                        {{ $sample->model_name ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <flux:badge size="sm" color="purple">
                                {{ $sample->customer ?? '-' }}
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <div class="flex flex-wrap items-center justify-center gap-2">
                                <span class="text-sm font-mono text-green-600 dark:text-green-400">
                                    {{ $sample->sample_ok ?? '-' }}
                                </span>
                                @if($sample->sample_ok_backup)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-green-500" title="Backup Available">
                                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <div class="flex flex-wrap items-center justify-center gap-2">
                                <span class="text-sm font-mono text-red-600 dark:text-red-400">
                                    {{ $sample->sample_ng ?? '-' }}
                                </span>
                                @if($sample->sample_blank)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-red-500" title="Sample Blank">
                                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <span class="text-sm">{{ $sample->name_or_mc ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($sample->rack)
                                <div class="text-xs">
                                    <div>{{ $sample->rack->type_rack ?? '-' }}</div>
                                    <div class="text-zinc-500">Col: {{ $sample->rack->column_rack ?? '-' }} | Sheet: {{ $sample->rack->sheet_rack ?? '-' }}</div>
                                </div>
                            @else
                                <span class="text-zinc-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <span class="text-sm {{ ($sample->latest_status ?? '') === 'Expired' ? 'text-red-600' : (($sample->latest_status ?? '') === 'Active' ? 'text-green-600' : 'text-yellow-600') }}">
                                {{ $sample->latest_expired_date ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex gap-4">
                                <div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Use Status</div>
                                    <flux:badge 
                                        size="sm" 
                                        color="{{ ($sample->status ?? 'ACTIVE') === 'ACTIVE' ? 'green' : (($sample->status ?? '') === 'NOT USE' ? 'yellow' : 'gray') }}"
                                    >
                                        {{ ($sample->status ?? 'ACTIVE') === 'ACTIVE' ? 'Active' : ($sample->status ?? '-') }}
                                    </flux:badge>
                                </div>
                                <div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Exp Status</div>
                                    <flux:badge 
                                        size="sm" 
                                        color="{{ ($sample->latest_status ?? '') === 'Active' ? 'green' : (($sample->latest_status ?? '') === 'Expired' ? 'red' : 'gray') }}"
                                    >
                                        {{ $sample->latest_status ?? '-' }}
                                    </flux:badge>
                                </div>
                                <div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">Loan Status</div>
                                    <flux:badge size="sm" color="{{ $sample->loan_status === 'In Use' ? 'green' : ($sample->loan_status === 'Loaning' ? 'yellow' : (in_array($sample->loan_status, ['ECR', 'Stand By']) ? 'blue' : 'gray')) }}">
                                        {{ $sample->loan_status }}
                                    </flux:badge>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            @php
                                $latestHistory = $sample->historydDetails()->orderByDesc('out_date')->first();
                                $location = optional($latestHistory?->masterLine?->location)->location_name ?? '-';
                                $line = optional($latestHistory?->masterLine)->line_number ?? '-';
                                $remarks = $latestHistory?->remarks ?? '-';
                            @endphp
                            <div>
                                <div class="text-sm">
                                    {{ $location }} @if($location !== '-' && $line !== '-') | @endif {{ $line }}
                                    @if($remarks !== '-')
                                        <div class="text-xs text-zinc-500 mt-1">{{ $remarks }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm {{ str_contains($sample->days_remaining ?? '', 'Overdue') ? 'text-red-600 font-semibold' : (str_contains($sample->days_remaining ?? '', 'Today') ? 'text-yellow-600' : 'text-zinc-600') }}">
                                {{ $sample->days_remaining ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <flux:tooltip content="View" position="bottom">
                                    <flux:button 
                                        wire:click="goToShow({{ $sample->id }})"
                                        size="sm"
                                        icon="eye"
                                        variant="primary"
                                        color="blue"
                                        class="!p-2"
                                        title="View sample"
                                    />
                                </flux:tooltip>
                                <!-- Update Status Button -->
                                @can('edit master sample')
                                <flux:tooltip content="Update Status" position="bottom">
                                    <flux:button 
                                        wire:click="openUpdateStatusModal({{ $sample->id }})" 
                                        x-on:click="$dispatch('open-modal', 'update-status-modal')"
                                        size="sm"
                                        icon="arrow-path"
                                        variant="primary"
                                        color="green"
                                        class="!p-2"
                                        title="Update Status"
                                    />
                                </flux:tooltip>
                                @endcan
                                @can('edit master sample')
                                <flux:tooltip content="Edit" position="bottom">
                                    <flux:button 
                                        wire:click="edit({{ $sample->id }})" 
                                        x-on:click="$dispatch('open-modal', 'master-sample-form-modal')"
                                        size="sm"
                                        icon="pencil-square"
                                        variant="primary"
                                        color="yellow"
                                        class="!p-2"
                                        title="Edit sample"
                                    />
                                </flux:tooltip>
                                @endcan

                                @can('delete master sample')
                                <flux:tooltip content="Delete" position="bottom">
                                    <flux:button 
                                        wire:click="confirmDelete({{ $sample->id }})" 
                                        x-on:click="$dispatch('open-modal', 'delete-master-sample-modal')"
                                        size="sm"
                                        icon="trash"
                                        variant="primary"
                                        color="red"
                                        class="!p-2"
                                        title="Delete sample"
                                    />
                                </flux:tooltip>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="13" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <flux:icon name="document" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        No master samples found
                                    </h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                        {{ $search || $filterCustomer || $filterNameOrMc ? 'Try adjusting your search/filter query' : 'Get started by creating a new master sample' }}
                                    </p>
                                </div>
                                @if($search || $filterCustomer || $filterNameOrMc)
                                    <flux:button wire:click="$set('search', ''); $set('filterCustomer', ''); $set('filterNameOrMc', '')" size="sm">
                                        Clear All Filters
                                    </flux:button>
                                @else
                                    @can('create master sample')
                                    <flux:button 
                                        variant="primary" 
                                        size="sm"
                                        wire:click="resetForm"
                                        x-on:click="$dispatch('open-modal', 'master-sample-form-modal')"
                                    >
                                        Add Your First Master Sample
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
        @if($masterSamples->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $masterSamples->links() }}
        </div>
        @endif
    </flux:card>

    <!-- MODAL FORM MASTER SAMPLE - FULL WIZARD -->
    <div x-data="{ 
        open: false, 
        activeTab: 1,
        get totalTabs() {
            return $wire.master_sample_id ? 2 : 3;
        },
        nextTab() { 
            if (this.activeTab < this.totalTabs) this.activeTab++; 
        },
        prevTab() { 
            if (this.activeTab > 1) this.activeTab--; 
        }
    }" 
    x-show="open" 
    @open-modal.window="if ($event.detail === 'master-sample-form-modal') { open = true; activeTab = 1; }"
    @close-modal.window="if ($event.detail === 'master-sample-form-modal') open = false"
    x-cloak>

        <!-- Overlay -->
        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <!-- Modal Container -->
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-5xl">
                
                <!-- Header -->
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex justify-between items-center">
                    <h2 class="text-xl font-bold">{{ $modalTitle ?? 'Master Sample Form' }}</h2>
                    <button @click="open = false" class="text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Wizard Steps -->
                <div class="px-6 pt-6">
                    <div class="flex items-center justify-center">
                        <!-- Step 1 -->
                        <div class="flex items-center">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-semibold text-sm transition-all duration-200"
                                    :class="activeTab >= 1 ? 'bg-blue-600 text-white shadow-lg' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500'">
                                    1
                                </div>
                                <span class="ml-2 text-sm font-medium transition-colors duration-200"
                                    :class="activeTab >= 1 ? 'text-blue-600 dark:text-blue-400' : 'text-zinc-500'">
                                    General & Rack
                                </span>
                            </div>
                            
                            <!-- Line between Step 1 and Step 2 -->
                            <div class="w-16 h-px mx-4 transition-all duration-200"
                                :class="activeTab > 1 ? 'bg-blue-600' : 'bg-zinc-200 dark:bg-zinc-700'"></div>
                        </div>

                        <!-- Step 2 -->
                        <div class="flex items-center">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-semibold text-sm transition-all duration-200"
                                    :class="activeTab >= 2 ? 'bg-blue-600 text-white shadow-lg' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500'">
                                    2
                                </div>
                                <span class="ml-2 text-sm font-medium transition-colors duration-200"
                                    :class="activeTab >= 2 ? 'text-blue-600 dark:text-blue-400' : 'text-zinc-500'">
                                    Samples & QR
                                </span>
                            </div>
                            
                            <!-- Line to Step 3 (only visible in CREATE mode) -->
                            <div class="w-16 h-px mx-4 transition-all duration-200"
                                x-show="!$wire.master_sample_id"
                                :class="activeTab > 2 ? 'bg-blue-600' : 'bg-zinc-200 dark:bg-zinc-700'"></div>
                        </div>

                        <!-- Step 3 (only visible in CREATE mode) -->
                        <div class="flex items-center" x-show="!$wire.master_sample_id">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-semibold text-sm transition-all duration-200"
                                    :class="activeTab >= 3 ? 'bg-blue-600 text-white shadow-lg' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500'">
                                    3
                                </div>
                                <span class="ml-2 text-sm font-medium transition-colors duration-200"
                                    :class="activeTab >= 3 ? 'text-blue-600 dark:text-blue-400' : 'text-zinc-500'">
                                    Expired History
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Content with Scroll -->
                <div class="p-6 max-h-[calc(90vh-220px)] overflow-y-auto">
                    <form wire:submit="save" id="master-sample-form">
                        
                        <!-- ==================== TAB 1: GENERAL & RACK ==================== -->
                        <div x-show="activeTab === 1" x-cloak>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                <!-- LEFT COLUMN - General Information -->
                                <div class="space-y-4">
                                    <h3 class="text-md font-semibold text-zinc-700 dark:text-zinc-300 border-b pb-2 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        General Information
                                    </h3>
                                    
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Model Name <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model="model_name" placeholder="Enter model name..."
                                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('model_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium mb-1">Customer Code <span class="text-red-500">*</span></label>
                                        <select wire:model="customer" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700">
                                            <option value="">Select Customer</option>
                                            @if(is_array($customerOptions) || is_object($customerOptions))
                                                @foreach($customerOptions as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('customer') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium mb-1">Name / MC <span class="text-red-500">*</span></label>
                                        <select wire:model="name_or_mc" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700">
                                            <option value="">Select Name/MC</option>
                                            @if(is_array($nameOrMcOptions) || is_object($nameOrMcOptions))
                                                @foreach($nameOrMcOptions as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('name_or_mc') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- RIGHT COLUMN - Rack Information -->
                                <div class="space-y-4">
                                    <h3 class="text-md font-semibold text-zinc-700 dark:text-zinc-300 border-b pb-2 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                        </svg>
                                        Rack Information
                                    </h3>

                                    @if($currentRackInfo)
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Current Rack</label>
                                        <div class="px-3 py-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-sm border border-blue-200 dark:border-blue-800">
                                            {{ $currentRackInfo }}
                                        </div>
                                    </div>
                                    @endif

                                    <div>
                                        <label class="block text-sm font-medium mb-1">Available Rack</label>
                                        <select wire:model="rack_id" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700">
                                            <option value="">Select Rack</option>
                                            @if(is_array($availableRacks) || is_object($availableRacks))
                                                @foreach($availableRacks as $id => $label)
                                                    <option value="{{ $id }}">{{ $label }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('rack_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium mb-1">Rack Backup</label>
                                        <input type="text" wire:model="rack_backup" placeholder="Enter backup rack location..."
                                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('rack_backup') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium mb-1">Status</label>
                                        <select wire:model="status" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700">
                                            <option value="ACTIVE">🟢 ACTIVE</option>
                                            <option value="NOT USE">🟡 NOT USE</option>
                                            <option value="EOL">⚫ EOL</option>
                                            <option value="UNDER PE">🔵 UNDER PE</option>
                                        </select>
                                        @error('status') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ==================== TAB 2: SAMPLES & QR ==================== -->
                        <div x-show="activeTab === 2" x-cloak>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                <!-- LEFT COLUMN - Sample OK -->
                                <div class="space-y-4">
                                    <h3 class="text-md font-semibold text-zinc-700 dark:text-zinc-300 border-b pb-2 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Sample Information
                                    </h3>

                                    <!-- Hapus atau komentari blok Last Sample Reference -->
                                    {{--
                                    @if($customer && $name_or_mc)
                                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                                        <label class="block text-sm font-medium mb-2">📋 Last Sample Reference</label>
                                        <div class="flex gap-4 text-sm">
                                            <div>
                                                <span class="text-zinc-500">Sample OK:</span>
                                                <span class="ml-1 px-2 py-0.5 text-xs font-medium rounded bg-green-100 text-green-700">-</span>
                                            </div>
                                            <div>
                                                <span class="text-zinc-500">Sample NG:</span>
                                                <span class="ml-1 px-2 py-0.5 text-xs font-medium rounded bg-red-100 text-red-700">-</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    --}}

                                    <div>
                                        <label class="block text-sm font-medium mb-1">Sample OK</label>
                                        <input type="text" wire:model="sample_ok" placeholder="Enter sample OK number manually..."
                                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('sample_ok') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="flex items-center gap-3 p-3 bg-green-50 dark:bg-green-900/10 rounded-lg">
                                        <input type="checkbox" wire:model="sample_ok_backup" class="w-4 h-4 rounded text-green-600 focus:ring-green-500">
                                        <label class="text-sm font-medium">Sample OK Backup</label>
                                    </div>
                                </div>

                                <!-- RIGHT COLUMN - Sample NG & Remarks -->
                                <div class="space-y-4">
                                    <h3 class="text-md font-semibold text-zinc-700 dark:text-zinc-300 border-b pb-2 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        NG & Remarks
                                    </h3>

                                    <div>
                                        <label class="block text-sm font-medium mb-1">Sample NG</label>
                                        <input type="text" wire:model="sample_ng" placeholder="Enter sample NG number manually..."
                                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('sample_ng') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="flex items-center gap-3 p-3 bg-red-50 dark:bg-red-900/10 rounded-lg">
                                        <input type="checkbox" wire:model="sample_blank" class="w-4 h-4 rounded text-red-600 focus:ring-red-500">
                                        <label class="text-sm font-medium">Sample Blank</label>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium mb-1">Remarks</label>
                                        <textarea wire:model="remarks" rows="4" placeholder="Additional remarks..."
                                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700"></textarea>
                                        @error('remarks') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ==================== TAB 3: EXPIRED HISTORY (ONLY IN CREATE MODE) ==================== -->
                        <div x-show="activeTab === 3 && !$wire.master_sample_id" x-cloak>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center border-b pb-2 mb-4">
                                    <h3 class="text-md font-semibold text-zinc-700 dark:text-zinc-300 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Expired History Records
                                    </h3>
                                    <button type="button" wire:click="addDetailRow"
                                        class="px-3 py-1.5 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Add Row
                                    </button>
                                </div>
                                
                                @if(is_array($details) && count($details) > 0)
                                    @foreach($details as $index => $detail)
                                    <div class="border rounded-lg p-4 mb-4 relative bg-zinc-50 dark:bg-zinc-800/30">
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Updated Date</label>
                                                <input type="date" wire:model="details.{{ $index }}.updated_date"
                                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700">
                                                @error("details.{$index}.updated_date") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium mb-1">Expired Date</label>
                                                <input type="date" wire:model="details.{{ $index }}.expired_date"
                                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700">
                                                @error("details.{$index}.expired_date") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium mb-1">Alarm Date</label>
                                                <input type="date" wire:model="details.{{ $index }}.date_alarm"
                                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700">
                                                @error("details.{$index}.date_alarm") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
                                            <div>
                                                <label class="block text-sm font-medium mb-1">Checked By</label>
                                                <select wire:model="details.{{ $index }}.checked_by"
                                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700">
                                                    <option value="">Select Checker</option>
                                                    @if(is_array($checkedByOptions) || is_object($checkedByOptions))
                                                        @foreach($checkedByOptions as $id => $name)
                                                            <option value="{{ $id }}">{{ $name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium mb-1">Knowledge By</label>
                                                <select wire:model="details.{{ $index }}.knowladge_by"
                                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700">
                                                    <option value="">Select Knowledge</option>
                                                    @if(is_array($knowledgeByOptions) || is_object($knowledgeByOptions))
                                                        @foreach($knowledgeByOptions as $id => $name)
                                                            <option value="{{ $id }}">{{ $name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium mb-1">Approved By</label>
                                                <select wire:model="details.{{ $index }}.approved_by"
                                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700">
                                                    <option value="">Select Approver</option>
                                                    @if(is_array($approvedByOptions) || is_object($approvedByOptions))
                                                        @foreach($approvedByOptions as $id => $name)
                                                            <option value="{{ $id }}">{{ $name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        @if(count($details) > 1)
                                        <button type="button" wire:click="removeDetailRow({{ $index }})"
                                            class="absolute top-2 right-2 text-red-500 hover:text-red-700 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                        @endif
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer with Navigation Buttons -->
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700 flex justify-between">
                    <button type="button" 
                        x-show="activeTab > 1"
                        @click="prevTab"
                        class="px-4 py-2 border rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Previous
                    </button>
                    
                    <!-- Spacer when no previous button -->
                    <div x-show="activeTab === 1" class="px-4 py-2"></div>
                    
                    <div class="flex gap-2">
                        <button type="button" 
                            @click="open = false"
                            class="px-4 py-2 border rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                            Cancel
                        </button>
                        
                        <!-- Next Button -->
                        <button type="button" 
                            x-show="activeTab < totalTabs"
                            @click="nextTab"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                            Next
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                        
                        <!-- Submit Button (Last Step) -->
                        <button type="submit" 
                            x-show="activeTab === totalTabs"
                            form="master-sample-form"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ $master_sample_id ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL UPDATE STATUS -->
    <div x-data="{ open: false }" 
        x-show="open" 
        @open-modal.window="if ($event.detail === 'update-status-modal') open = true"
        @close-modal.window="if ($event.detail === 'update-status-modal') open = false"
        x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold">Update Sample Status</h3>
                        <button @click="open = false" class="text-zinc-500 hover:text-zinc-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Sample: <span class="font-semibold">{{ $updatingStatusSample?->model_name ?? '-' }}</span></label>
                        <label class="block text-sm font-medium mb-1">Status</label>
                        <select wire:model="selectedStatus" 
                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500 dark:bg-zinc-800 dark:border-zinc-700">
                            <option value="ACTIVE">🟢 ACTIVE</option>
                            <option value="NOT USE">🟡 NOT USE</option>
                            <option value="EOL">⚫ EOL</option>
                            <option value="UNDER PE">🔵 UNDER PE</option>
                        </select>
                    </div>
                    
                    <div class="flex justify-end gap-2 mt-6">
                        <button type="button" 
                                @click="open = false"
                                wire:click="cancelUpdateStatus"
                                class="px-4 py-2 border rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                            Cancel
                        </button>
                        <button type="button" 
                                wire:click="confirmUpdateStatus"
                                @click="open = false"
                                class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                            Update Status
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'delete-master-sample-modal') open = true"
         @close-modal.window="if ($event.detail === 'delete-master-sample-modal') open = false"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>

                <h3 class="text-lg font-bold mb-2">Delete Master Sample</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Are you sure you want to delete master sample "{{ $sampleToDelete?->model_name ?? '' }}"? This action cannot be undone.
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