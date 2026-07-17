<div class="p-1 space-y-2">
    @section('title', 'Leader Panel - NG Box Management')

    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('pcb-scan.dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            PROD
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            FCT
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-red-600 dark:text-red-400">
            Leader Panel
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white flex items-center gap-3">
                Leader FCT Scan Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage locked PCBs and unlock system
            </p>
        </div>
    </div>

    <!-- Search -->
    <div class="flex justify-end">
        <div class="w-full sm:w-64">
            <flux:input
                x-data
                x-init="$el.value = ''"
                wire:model.live.debounce.300ms="search"
                placeholder="Search serial number..."
                icon="magnifying-glass"
                clearable
                autocomplete="off"
            />
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="mt-6 border-b border-zinc-200 dark:border-zinc-700">
        <div class="relative">
            <div class="overflow-x-auto scrollbar-hide">
                <div class="flex flex-nowrap gap-1 justify-center">
                    
                    <!-- NG Boxes Tab -->
                    <button wire:click="switchTab('ng')" 
                            class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'ng' ? 'text-red-600 dark:text-red-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        NG Boxes
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'ng' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $ngBoxes->total() }}
                        </span>
                        @if($activeTab === 'ng')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-red-600 dark:bg-red-400 rounded-t-full"></div>
                        @endif
                    </button>

                    <!-- All PCBs Tab -->
                    <button wire:click="switchTab('all')" 
                            class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'all' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        All PCBs
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'all' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $allPcbs->total() }}
                        </span>
                        @if($activeTab === 'all')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600 dark:bg-blue-400 rounded-t-full"></div>
                        @endif
                    </button>

                    <!-- In Progress Tab -->
                    <button wire:click="switchTab('progress')" 
                            class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'progress' ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        In Progress
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'progress' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $inProgressPcbs->total() }}
                        </span>
                        @if($activeTab === 'progress')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-yellow-600 dark:bg-yellow-400 rounded-t-full"></div>
                        @endif
                    </button>

                    <!-- Completed Tab -->
                    <button wire:click="switchTab('completed')" 
                            class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'completed' ? 'text-green-600 dark:text-green-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Completed
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'completed' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $completedPcbs->total() }}
                        </span>
                        @if($activeTab === 'completed')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-green-600 dark:bg-green-400 rounded-t-full"></div>
                        @endif
                    </button>

                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div>
        <!-- NG Boxes Table -->
        @if($activeTab === 'ng')
        <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="overflow-x-auto">
                <table class="min-w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Serial Number</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Blocked Process</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Progress</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Locked Since</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Duration</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Unlock Code</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($ngBoxes as $box)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="box-{{ $box->id }}">
                            <td class="px-4 py-3 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $loop->iteration + (($ngBoxes->currentPage() - 1) * $ngBoxes->perPage()) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-sm font-mono font-medium text-zinc-800 dark:text-zinc-200">{{ $box->serial_number }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <flux:badge color="red" size="sm">
                                    {{ strtoupper(str_replace('_', ' ', $box->blocked_at_process)) }}
                                </flux:badge>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="flex gap-1">
                                        <flux:badge color="{{ $box->pcb && $box->pcb->fct_completed ? 'green' : 'gray' }}" size="xs">F</flux:badge>
                                        <flux:badge color="{{ $box->pcb && $box->pcb->led_test_completed ? 'green' : 'gray' }}" size="xs">L</flux:badge>
                                        <flux:badge color="{{ $box->pcb && $box->pcb->visual_inspection_completed ? 'green' : 'gray' }}" size="xs">V</flux:badge>
                                    </div>
                                    <span class="text-xs text-zinc-500">
                                        @if($box->pcb)
                                            {{ ($box->pcb->fct_completed ? 1 : 0) + ($box->pcb->led_test_completed ? 1 : 0) + ($box->pcb->visual_inspection_completed ? 1 : 0) }}/3
                                        @else
                                            0/3
                                        @endif
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($box->is_locked)
                                <flux:badge color="red" size="sm">
                                    <svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Locked
                                </flux:badge>
                                @else
                                <flux:badge color="green" size="sm">
                                    <svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                    </svg>
                                    Unlocked
                                </flux:badge>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $box->created_at->format('d M Y H:i:s') }}
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $box->created_at->diffForHumans() }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($box->is_locked)
                                <button type="button"
                                        wire:click="showUnlockCode({{ $box->id }})"
                                        class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors group">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-blue-500 dark:text-blue-400 group-hover:text-blue-700 dark:group-hover:text-blue-300 transition-colors">
                                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                                    </svg>
                                    Show Code
                                </button>
                                @else
                                <span class="inline-flex items-center gap-1.5 text-sm font-mono font-bold text-green-600 dark:text-green-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $box->unlock_code }}
                                </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                @if($box->is_locked)
                                <flux:button wire:click="openUnlockModal({{ $box->id }})" size="sm" variant="primary" color="blue">
                                    Unlock
                                </flux:button>
                                @else
                                <span class="text-xs text-green-600 dark:text-green-400">
                                    <svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Done
                                </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">No NG Boxes found</h3>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $search ? 'Try adjusting your search query' : 'No NG records available' }}</p>
                                    </div>
                                    @if($search)
                                        <flux:button wire:click="$set('search', '')" size="sm">Clear Search</flux:button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($ngBoxes->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $ngBoxes->links() }}
            </div>
            @endif
        </flux:card>
        @endif

        <!-- All PCBs -->
        @if($activeTab === 'all')
        <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="overflow-x-auto">
                <table class="min-w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Serial Number</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Current Process</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Progress</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Last Scan</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($allPcbs as $pcb)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="pcb-{{ $pcb->id }}">
                            <td class="px-4 py-3 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $loop->iteration + (($allPcbs->currentPage() - 1) * $allPcbs->perPage()) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-sm font-mono font-medium text-zinc-800 dark:text-zinc-200">{{ $pcb->serial_number }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $statusColors = [
                                        'pending' => 'gray',
                                        'in_progress' => 'yellow',
                                        'completed' => 'green',
                                        'blocked' => 'red',
                                        'ng' => 'red'
                                    ];
                                @endphp
                                <flux:badge color="{{ $statusColors[$pcb->status] ?? 'gray' }}" size="sm">
                                    {{ ucfirst(str_replace('_', ' ', $pcb->status)) }}
                                </flux:badge>
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                @if($pcb->current_process)
                                    {{ strtoupper(str_replace('_', ' ', $pcb->current_process)) }}
                                @else
                                    <span class="text-zinc-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="flex gap-1">
                                        <flux:badge color="{{ $pcb->fct_completed ? 'green' : 'gray' }}" size="xs">F</flux:badge>
                                        <flux:badge color="{{ $pcb->led_test_completed ? 'green' : 'gray' }}" size="xs">L</flux:badge>
                                        <flux:badge color="{{ $pcb->visual_inspection_completed ? 'green' : 'gray' }}" size="xs">V</flux:badge>
                                    </div>
                                    <span class="text-xs text-zinc-500">
                                        {{ ($pcb->fct_completed ? 1 : 0) + ($pcb->led_test_completed ? 1 : 0) + ($pcb->visual_inspection_completed ? 1 : 0) }}/3
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $pcb->updated_at ? $pcb->updated_at->diffForHumans() : '-' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                @if($pcb->status === 'blocked' || $pcb->status === 'ng')
                                    @php
                                        $ngBox = $pcb->ngBoxes()->where('is_locked', true)->first();
                                    @endphp
                                    @if($ngBox)
                                    <flux:button wire:click="openUnlockModal({{ $ngBox->id }})" size="sm" variant="primary" color="blue">
                                        Unlock
                                    </flux:button>
                                    @else
                                    <span class="text-xs text-zinc-400">Locked</span>
                                    @endif
                                @else
                                    <span class="text-xs text-zinc-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">No PCBs found</h3>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $search ? 'Try adjusting your search query' : 'No data available' }}</p>
                                    </div>
                                    @if($search)
                                        <flux:button wire:click="$set('search', '')" size="sm">Clear Search</flux:button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($allPcbs->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $allPcbs->links() }}
            </div>
            @endif
        </flux:card>
        @endif

        <!-- In Progress -->
        @if($activeTab === 'progress')
        <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="overflow-x-auto">
                <table class="min-w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Serial Number</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Current Step</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Progress</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Last Activity</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Next Step</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($inProgressPcbs as $pcb)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="progress-{{ $pcb->id }}">
                            <td class="px-4 py-3 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $loop->iteration + (($inProgressPcbs->currentPage() - 1) * $inProgressPcbs->perPage()) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-sm font-mono font-medium text-zinc-800 dark:text-zinc-200">{{ $pcb->serial_number }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <flux:badge color="yellow" size="sm">
                                    {{ $pcb->current_process ? strtoupper(str_replace('_', ' ', $pcb->current_process)) : 'Pending' }}
                                </flux:badge>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="flex gap-1">
                                        <flux:badge color="{{ $pcb->fct_completed ? 'green' : 'gray' }}" size="xs">F</flux:badge>
                                        <flux:badge color="{{ $pcb->led_test_completed ? 'green' : 'gray' }}" size="xs">L</flux:badge>
                                        <flux:badge color="{{ $pcb->visual_inspection_completed ? 'green' : 'gray' }}" size="xs">V</flux:badge>
                                    </div>
                                    <span class="text-xs text-zinc-500">
                                        {{ ($pcb->fct_completed ? 1 : 0) + ($pcb->led_test_completed ? 1 : 0) + ($pcb->visual_inspection_completed ? 1 : 0) }}/3
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $pcb->updated_at ? $pcb->updated_at->diffForHumans() : '-' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $nextStep = '';
                                    if (!$pcb->fct_completed) $nextStep = 'FCT';
                                    elseif (!$pcb->led_test_completed) $nextStep = 'LED Test';
                                    elseif (!$pcb->visual_inspection_completed) $nextStep = 'Visual';
                                    else $nextStep = 'Completed';
                                @endphp
                                <flux:badge color="{{ $nextStep == 'Completed' ? 'green' : 'blue' }}" size="sm">
                                    {{ $nextStep }}
                                </flux:badge>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">No PCBs in progress</h3>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">All good!</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($inProgressPcbs->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $inProgressPcbs->links() }}
            </div>
            @endif
        </flux:card>
        @endif

        <!-- Completed -->
        @if($activeTab === 'completed')
        <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="overflow-x-auto">
                <table class="min-w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Serial Number</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Completed At</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Time Taken</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">All Steps</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($completedPcbs as $pcb)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="completed-{{ $pcb->id }}">
                            <td class="px-4 py-3 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $loop->iteration + (($completedPcbs->currentPage() - 1) * $completedPcbs->perPage()) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-sm font-mono font-medium text-zinc-800 dark:text-zinc-200">{{ $pcb->serial_number }}</span>
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $pcb->updated_at ? $pcb->updated_at->format('d M Y H:i:s') : '-' }}
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                @if($pcb->created_at && $pcb->updated_at)
                                    {{ $pcb->created_at->diff($pcb->updated_at)->format('%h hours, %i minutes') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-1">
                                    <flux:badge color="green" size="sm">F</flux:badge>
                                    <flux:badge color="green" size="sm">L</flux:badge>
                                    <flux:badge color="green" size="sm">V</flux:badge>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">No completed PCBs today</h3>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Come back later</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($completedPcbs->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $completedPcbs->links() }}
            </div>
            @endif
        </flux:card>
        @endif
    </div>

    <!-- Unlock Modal -->
    <div x-data="{ open: false }" 
        x-show="open" 
        @open-unlock-modal.window="open = true"
        @close-unlock-modal.window="open = false"
        x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <div class="text-center mb-4">
                        <div class="w-16 h-16 mx-auto mb-4 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-red-600 dark:text-red-400">
                                <path d="M18 1.5c2.9 0 5.25 2.35 5.25 5.25v3.75a.75.75 0 0 1-1.5 0V6.75a3.75 3.75 0 1 0-7.5 0v3a3 3 0 0 1 3 3v6.75a3 3 0 0 1-3 3H3.75a3 3 0 0 1-3-3v-6.75a3 3 0 0 1 3-3h9v-3c0-2.9 2.35-5.25 5.25-5.25Z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-zinc-800 dark:text-white">Unlock NG Box</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Enter unlock code to release locked PCB</p>
                    </div>

                    <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-4 mb-4">
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div>
                                <span class="text-zinc-500 dark:text-zinc-400">Serial Number</span>
                                <div class="font-mono font-bold text-zinc-800 dark:text-zinc-200">{{ $selectedBox->serial_number ?? '-' }}</div>
                            </div>
                            <div>
                                <span class="text-zinc-500 dark:text-zinc-400">Blocked Process</span>
                                <div class="font-bold text-zinc-800 dark:text-zinc-200 uppercase">{{ isset($selectedBox) ? str_replace('_', ' ', $selectedBox->blocked_at_process) : '-' }}</div>
                            </div>
                            <div>
                                <span class="text-zinc-500 dark:text-zinc-400">Locked Since</span>
                                <div class="text-zinc-800 dark:text-zinc-200">{{ isset($selectedBox) ? $selectedBox->created_at->format('d M Y H:i:s') : '-' }}</div>
                            </div>
                            <div>
                                <span class="text-zinc-500 dark:text-zinc-400">Duration</span>
                                <div class="text-zinc-800 dark:text-zinc-200">{{ isset($selectedBox) ? $selectedBox->created_at->diffForHumans() : '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2 text-center">
                            Enter Unlock Code <span class="text-red-500">*</span>
                        </label>
                        <div class="relative max-w-xs mx-auto">
                            <input 
                                type="text"
                                wire:model="unlockCode"
                                wire:keydown.enter="unlockBox"
                                placeholder="••••••"
                                maxlength="6"
                                autofocus
                                class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-2xl tracking-widest text-center font-mono"
                            />
                        </div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2 text-center">
                            Enter the 6-digit unlock code
                        </p>
                        @error('unlockCode') <span class="text-red-500 text-sm mt-1 block text-center">{{ $message }}</span> @enderror
                    </div>

                    @if($unlockMessage)
                    <div class="mb-4 p-3 rounded-lg {{ 
                        $unlockMessageType === 'success' ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400' : 
                        ($unlockMessageType === 'error' ? 'bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400' : 
                        'bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 text-yellow-700 dark:text-yellow-400') 
                    }}">
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($unlockMessageType === 'success')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @elseif($unlockMessageType === 'error')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                @endif
                            </svg>
                            <span>{{ $unlockMessage }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="flex gap-3">
                        <button type="button"
                                wire:click="unlockBox"
                                class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                            </svg>
                            UNLOCK BOX
                        </button>
                        <button type="button"
                                @click="open = false; $wire.closeUnlockModal()"
                                class="flex-1 px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors font-medium">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Code View Modal -->
    <div x-data="{ open: false }" 
        x-show="open" 
        @open-code-modal.window="open = true"
        @close-code-modal.window="open = false"
        x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false; $wire.closeCodeModal()"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <div class="text-center mb-4">
                        <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-zinc-800 dark:text-white">View Unlock Code</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Enter your password to view the unlock code</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2 text-center">
                           Login Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative max-w-xs mx-auto">
                            <input 
                                type="password"
                                wire:model="passwordInput"
                                wire:keydown.enter="verifyPassword"
                                placeholder="••••••••"
                                autofocus
                                class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center"
                            />
                        </div>
                        @error('passwordInput') <span class="text-red-500 text-sm mt-1 block text-center">{{ $message }}</span> @enderror
                        @if($passwordError)
                        <span class="text-red-500 text-sm mt-1 block text-center">{{ $passwordError }}</span>
                        @endif
                    </div>

                    @if($showCodeResult && $displayedCode)
                    <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-center animate-slideDown">
                        <p class="text-sm text-green-600 dark:text-green-400 mb-1">Unlock Code:</p>
                        <div class="relative inline-block group">
                            <p class="text-3xl font-mono font-bold text-green-700 dark:text-green-400 tracking-widest select-all">{{ $displayedCode }}</p>
                            <button onclick="copyToClipboard('{{ $displayedCode }}')" 
                                    class="absolute -top-2 -right-8 p-1.5 text-green-500 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                    title="Copy to clipboard">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M17.663 3.118c.225.015.45.032.673.05C19.876 3.298 21 4.604 21 6.109v9.642a3 3 0 0 1-3 3V16.5c0-5.922-4.576-10.775-10.384-11.217.324-1.132 1.3-2.01 2.548-2.114.224-.019.448-.036.673-.051A3 3 0 0 1 13.5 1.5H15a3 3 0 0 1 2.663 1.618ZM12 4.5A1.5 1.5 0 0 1 13.5 3H15a1.5 1.5 0 0 1 1.5 1.5H12Z" clip-rule="evenodd" />
                                        <path d="M3 8.625c0-1.036.84-1.875 1.875-1.875h.375A3.75 3.75 0 0 1 9 10.5v1.875c0 1.036.84 1.875 1.875 1.875h1.875A3.75 3.75 0 0 1 16.5 18v2.625c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625v-12Z" />
                                        <path d="M10.5 10.5a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963 5.23 5.23 0 0 0-3.434-1.279h-1.875a.375.375 0 0 1-.375-.375V10.5Z" />
                                    </svg>
                            </button>
                        </div>
                        <div class="flex items-center justify-center gap-3 mt-2">
                            <span id="copy-success" class="text-xs text-green-500 dark:text-green-400 opacity-0 transition-opacity duration-300">
                                Copied!
                            </span>
                        </div>
                    </div>
                    @endif

                    <div class="flex gap-3">
                        <button type="button"
                                wire:click="verifyPassword"
                                class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            VIEW CODE
                        </button>
                        <button type="button"
                                @click="open = false; $wire.closeCodeModal()"
                                class="flex-1 px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors font-medium">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('livewire:initialized', function () {
        // Reset search value saat mount
        @this.on('reset-search', function () {
            const searchInput = document.querySelector('input[wire\\:model*="search"]');
            if (searchInput) {
                searchInput.value = '';
            }
        });

        // Force reset search saat tab switch
        document.addEventListener('livewire:navigated', function () {
            const searchInput = document.querySelector('input[wire\\:model*="search"]');
            if (searchInput) {
                searchInput.value = '';
            }
        });

        @this.on('close-modal-delay', function () {
            setTimeout(function() {
                @this.closeUnlockModal();
            }, 1500);
        });

        @this.on('show-code', function (data) {
            console.log('Unlock code received:', data.code);
            const modalElement = document.querySelector('[x-data]');
            if (modalElement && modalElement.__x) {
                modalElement.__x.$data.unlockCode = data.code;
            }
        });
    });

    // Add the copy function globally
    function copyToClipboard(text) {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            // Use Clipboard API
            navigator.clipboard.writeText(text).then(() => {
                showCopySuccess();
            }).catch(err => {
                // Fallback to older method
                fallbackCopy(text);
            });
        } else {
            // Fallback for older browsers
            fallbackCopy(text);
        }
    }

    function fallbackCopy(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.opacity = '0';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
        textArea.select();
        
        try {
            const successful = document.execCommand('copy');
            if (successful) {
                showCopySuccess();
            } else {
                console.error('Copy failed');
            }
        } catch (err) {
            console.error('Copy failed:', err);
        } finally {
            document.body.removeChild(textArea);
        }
    }

    function showCopySuccess() {
        const successElement = document.getElementById('copy-success');
        if (successElement) {
            successElement.style.opacity = '1';
            setTimeout(() => {
                successElement.style.opacity = '0';
            }, 2000);
        }
    }
    </script>
    @endpush

    <style>
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
        }
        [x-cloak] { display: none !important; }
    </style>
</div>