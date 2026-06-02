<div class="p-1 space-y-2">
    @section('title', 'Uniform Request')
    
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">HR</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Uniform</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Request Uniform</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">Request Uniform</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Manage uniform requests</p>
        </div>

        @can('create uniform request')
            <flux:button variant="primary" icon="plus" href="{{ route('prod.uniform.request.create') }}" wire:navigate>
                New Request
            </flux:button>
        @endcan
    </div>

    <!-- Filters -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-3">
        <div class="lg:col-span-2">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search by request #..."
                icon="magnifying-glass"
                clearable
            />
        </div>

        <div>
            <select wire:model.live="misscStatusFilter" 
                class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-zinc-700 dark:text-zinc-300">
                <option value="">All MISSC Status</option>
                <option value="Waiting">Waiting</option>
                <option value="On Process">On Process</option>
                <option value="Accepted">Accepted</option>
            </select>
        </div>

        <div>
            <select wire:model.live="adminFeedbackFilter" 
                class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-zinc-700 dark:text-zinc-300">
                <option value="">All Admin Feedback</option>
                <option value="Open">Open</option>
                <option value="On Process">On Process</option>
                <option value="Checked">Checked</option>
            </select>
        </div>

        <div>
            <select wire:model.live="costingFeedbackFilter" 
                class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-zinc-700 dark:text-zinc-300">
                <option value="">All Costing Feedback</option>
                <option value="Open">Open</option>
                <option value="On Process">On Process</option>
                <option value="Checked">Checked</option>
            </select>
        </div>

        <div>
            <input type="date" 
                wire:model.live="dateFrom"
                class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-zinc-700 dark:text-zinc-300">
        </div>

        <div>
            <input type="date" 
                wire:model.live="dateTo"
                class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-zinc-700 dark:text-zinc-300">
        </div>
    </div>

    @if($adminFeedbackFilter || $costingFeedbackFilter || $misscStatusFilter || $dateFrom || $dateTo || $search)
    <div class="flex justify-end">
        <button wire:click="resetFilters" 
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Reset Filters
        </button>
    </div>
    @endif

    <!-- Uniform Request Table -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="overflow-x-auto">
            <table class="w-full" style="min-width: max-content;">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">REQUEST NUMBER #</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">TOTAL EMPLOYEE</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">ADMIN FEEDBACK</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">COSTING FEEDBACK</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">MISSC STATUS</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">PREPARED BY</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">DATE</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($requests as $index => $request)
                    @php
                        $adminStatus = $this->getAdminFeedbackStatus($request);
                        $costingStatus = $this->getCostingFeedbackStatus($request);
                        $canEdit = ($adminStatus['status'] == 'Open' && $costingStatus['status'] == 'Open');
                        
                        $statusColors = [
                            'Waiting' => 'gray',
                            'On Process' => 'yellow',
                            'Accepted' => 'green',
                        ];
                        
                        $statusIcons = [
                            'Waiting' => 'M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z',
                            'On Process' => 'M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z',
                            'Accepted' => 'M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z',
                        ];
                        
                        $status = $request->missc_status ?? 'Waiting';
                        $statusColor = $statusColors[$status] ?? 'gray';
                        $statusIcon = $statusIcons[$status] ?? $statusIcons['Waiting'];
                    @endphp
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <span class="text-sm font-semibold">{{ $request->request_number }}</span>
                        </td>
                        
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium bg-blue-100 text-blue-700 rounded-full dark:bg-blue-900/30 dark:text-blue-300 whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                    <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                                </svg>
                                <span>{{ count($request->items) }} employee(s)</span>
                            </span>
                        </td>
                        
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            @if($adminStatus['status'] == 'Checked')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium text-green-700 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                    </svg>
                                    Checked
                                </span>
                            @elseif($adminStatus['status'] == 'On Process')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-900/30 dark:text-yellow-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
                                    </svg>
                                    On Process
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium text-gray-700 bg-gray-100 rounded-full dark:bg-gray-900/30 dark:text-gray-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                    </svg>
                                    Open
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            @if($costingStatus['status'] == 'Checked')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium text-green-700 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                    </svg>
                                    Checked
                                </span>
                            @elseif($costingStatus['status'] == 'On Process')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-900/30 dark:text-yellow-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
                                    </svg>
                                    On Process
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium text-gray-700 bg-gray-100 rounded-full dark:bg-gray-900/30 dark:text-gray-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                    </svg>
                                    Open
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <div class="flex flex-col items-center gap-1">
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium rounded-full bg-{{ $statusColor }}-100 text-{{ $statusColor }}-700 dark:bg-{{ $statusColor }}-900/30 dark:text-{{ $statusColor }}-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="{{ $statusIcon }}" clip-rule="evenodd" />
                                    </svg>
                                    {{ $status }}
                                </span>
                                
                                @if($status == 'Accepted' && $request->missc_accept_at)
                                    <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                        {{ $request->missc_accept_at->format('d M Y H:i') }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <span class="text-sm font-semibold">{{ $request->created_by }}</span>
                        </td>
                        
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <span class="text-sm font-semibold">{{ $request->created_at ? $request->created_at->format('d M Y H:i') : '-' }}</span>
                        </td>
                        
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <!-- View Button -->
                                <flux:tooltip content="View Details" position="bottom">
                                    <flux:button 
                                        href="{{ route('prod.uniform.request.show', $request->id) }}"
                                        wire:navigate
                                        size="xs"
                                        icon="eye"
                                        variant="primary"
                                        color="blue"
                                        class="!p-1.5"
                                    />
                                </flux:tooltip>

                                @can('update uniform request missc status')
                                    @if($request->missc_status != 'Accepted' && $adminStatus['status'] == 'Checked' && $costingStatus['status'] == 'Checked')
                                        <flux:tooltip content="Update MISSC Status" position="bottom">
                                            <flux:button 
                                                wire:click="openMisscModal({{ $request->id }})"
                                                size="xs"
                                                icon="pencil"
                                                variant="primary"
                                                color="green"
                                                class="!p-1.5"
                                            />
                                        </flux:tooltip>
                                    @elseif($request->missc_status != 'Accepted')
                                        <flux:tooltip content="Cannot update MISSC Status - Admin and Costing feedback must be checked first" position="bottom">
                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-600 cursor-not-allowed">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </span>
                                        </flux:tooltip>
                                    @endif
                                @endcan
                                
                                @can('edit uniform request')
                                    @if($canEdit && $request->missc_status == 'Waiting')
                                        <flux:tooltip content="Edit Request" position="bottom">
                                            <flux:button 
                                                href="{{ route('prod.uniform.request.edit', $request->id) }}"
                                                wire:navigate
                                                size="xs"
                                                icon="pencil-square"
                                                variant="primary"
                                                color="yellow"
                                                class="!p-1.5"
                                            />
                                        </flux:tooltip>
                                    @elseif($canEdit && $request->missc_status != 'Waiting')
                                        <flux:tooltip content="Cannot edit - MISSC status is {{ $request->missc_status }}" position="bottom">
                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-600 cursor-not-allowed">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </span>
                                        </flux:tooltip>
                                    @else
                                        <flux:tooltip content="Cannot edit - feedback already exists" position="bottom">
                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-600 cursor-not-allowed">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </span>
                                        </flux:tooltip>
                                    @endif
                                @endcan
                                
                                @can('delete uniform request')
                                    <flux:tooltip content="Delete Request" position="bottom">
                                        <flux:button 
                                            wire:click="delete({{ $request->id }})"
                                            wire:confirm="Are you sure you want to delete this request?"
                                            size="xs"
                                            icon="trash"
                                            variant="primary"
                                            color="red"
                                            class="!p-1.5"
                                        />
                                    </flux:tooltip>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-12 h-12 text-zinc-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div>
                                    <h3 class="text-lg font-medium mb-1">No requests found</h3>
                                    <p class="text-sm text-zinc-500">{{ $search ? 'Try adjusting your search query' : 'Get started by creating a new request' }}</p>
                                </div>
                                @if($search)
                                    <flux:button wire:click="$set('search', '')" size="sm">
                                        Clear Search
                                    </flux:button>
                                @else
                                    @can('create uniform request')
                                    <flux:button 
                                        variant="primary" 
                                        size="sm"
                                        href="{{ route('prod.uniform.request.create') }}"
                                        wire:navigate
                                    >
                                        Add Your First Request
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
        @if($requests->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $requests->links() }}
        </div>
        @endif
    </flux:card>

    <!-- MODAL MISSC STATUS UPDATE -->
    <div x-data="{ 
        open: @entangle('showMisscModal'), 
        closeModal() { this.open = false; $wire.closeMisscModal(); }
    }" 
    x-show="open" 
    x-cloak>
        <div class="fixed inset-0 bg-black/50 z-40" @click="closeModal()"></div>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Update MISSC Status</h2>
                        <button @click="closeModal()" class="text-zinc-500 hover:text-zinc-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Request Number</label>
                        <div class="px-3 py-2 bg-zinc-100 dark:bg-zinc-800 rounded-lg text-sm">
                            {{ $selectedRequestNumber }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Current Status</label>
                        <div class="px-3 py-2 bg-zinc-100 dark:bg-zinc-800 rounded-lg">
                            @if($currentMisscStatus == 'Waiting')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium text-gray-700 bg-gray-200 rounded-full dark:bg-gray-600 dark:text-gray-200">
                                    Waiting
                                </span>
                            @elseif($currentMisscStatus == 'On Process')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-900/30 dark:text-yellow-300">
                                    On Process
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium text-green-700 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-300">
                                    Accepted
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">New Status <span class="text-red-500">*</span></label>
                        <select wire:model="selectedStatus" 
                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500">
                            <option value="">Select new status...</option>
                            <option value="On Process">On Process</option>
                            <option value="Accepted">Accepted</option>
                        </select>
                    </div>

                    @if($selectedStatus == 'Accepted')
                        <div class="mb-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                ⚠️ Warning: Once accepted, this status cannot be changed and the request will be finalized.
                            </p>
                        </div>
                    @endif
                    
                    <div class="flex justify-end gap-2">
                        <button @click="closeModal()" 
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                            Cancel
                        </button>
                        <button wire:click="confirmUpdateMisscStatus" 
                            @click="closeModal()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                            :disabled="!$wire.selectedStatus">
                            Update Status
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-data="{ show: false, message: '', type: 'success' }" 
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
         x-show="show" x-transition class="fixed bottom-4 right-4 z-50"
         :class="{'bg-green-500': type === 'success', 'bg-red-500': type === 'error'}" style="display: none;">
        <div class="text-white px-6 py-3 rounded-lg shadow-lg" x-text="message"></div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>