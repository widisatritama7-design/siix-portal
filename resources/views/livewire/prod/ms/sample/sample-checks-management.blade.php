<div class="p-1 space-y-2" wire:poll.2s="$refresh">
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
            Task Management
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Sample Tack Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage sample task for checks, knowledge, and approvals
            </p>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="mt-6 mb-4 border-b border-zinc-200 dark:border-zinc-700">
        <div class="flex gap-1 overflow-x-auto scrollbar-hide">
            @if($canViewChecks)
            <button wire:click="setTab('checks')" 
                    class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'checks' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                My Waiting Checks
                <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'checks' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                    {{ $tabCounts['checks'] ?? 0 }}
                </span>
                @if($activeTab === 'checks') <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600 dark:bg-blue-400 rounded-t-full"></div> @endif
            </button>
            @endif

            @if($canViewKnowledge)
            <button wire:click="setTab('knowledge')" 
                    class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'knowledge' ? 'text-green-600 dark:text-green-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                My Waiting Knowledge
                <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'knowledge' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                    {{ $tabCounts['knowledge'] ?? 0 }}
                </span>
                @if($activeTab === 'knowledge') <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-green-600 dark:bg-green-400 rounded-t-full"></div> @endif
            </button>
            @endif

            @if($canViewApprovals)
            <button wire:click="setTab('approvals')" 
                    class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'approvals' ? 'text-purple-600 dark:text-purple-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                My Waiting Approvals
                <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'approvals' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                    {{ $tabCounts['approvals'] ?? 0 }}
                </span>
                @if($activeTab === 'approvals') <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-purple-600 dark:bg-purple-400 rounded-t-full"></div> @endif
            </button>
            @endif
        </div>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <!-- ==================== TAB: CHECKS ==================== -->
    @if($activeTab === 'checks' && $canViewChecks)
    <div>
        <!-- Search and Bulk Action -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
            <div class="flex gap-2">
                @if(count($selectedChecks) > 0)
                <flux:button wire:click="markAsChecked" 
                             variant="primary" 
                             color="green"
                             class="bg-green-600 hover:bg-green-700">
                    Mark Checked ({{ count($selectedChecks) }})
                </flux:button>
                <flux:button wire:click="resetBulkSelections" variant="outline" size="sm">
                    Clear Selection
                </flux:button>
                @endif
            </div>
            <div class="w-full sm:w-64">
                <flux:input wire:model.live.debounce.300ms="searchChecks"
                            placeholder="Search sample..."
                            icon="magnifying-glass"
                            clearable />
            </div>
        </div>

        <!-- Checks Table -->
        <flux:card class="p-0 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
            <div class="overflow-x-auto" style="overflow-y: visible;">
                <table class="w-full min-w-[1000px]">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                        <tr>
                            <th class="px-4 py-3 text-center w-12">
                                <input type="checkbox" wire:model="selectAllChecks" class="rounded border-gray-300">
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Sample</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Updated Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Expired Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Alarm Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Prepared By</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($checks as $check)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-4 py-3 text-center">
                                <input type="checkbox" value="{{ $check->id }}" wire:model="selectedChecks" class="rounded border-gray-300">
                            </td>
                            <td class="px-4 py-3">
                                <div class="relative group">
                                    <span class="text-sm font-medium text-zinc-800 dark:text-white block truncate max-w-[200px]"
                                          title="{{ $check->masterSample->model_name ?? 'N/A' }}">
                                        {{ $check->masterSample->model_name ?? 'N/A' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $check->updated_date ? \Carbon\Carbon::parse($check->updated_date)->format('d M Y') : '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $check->expired_date ? \Carbon\Carbon::parse($check->expired_date)->format('d M Y') : '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $check->date_alarm ? \Carbon\Carbon::parse($check->date_alarm)->format('d M Y') : '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $check->updater->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                    <svg class="w-3 h-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    Pending
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('prod.ms.master-sample.show', $check->master_sample_id) }}?activeRelationManager=1" 
                                   target="_blank"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    Go to Sample
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">No pending checks</h3>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">All caught up! No samples waiting for your check.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($checks->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $checks->links() }}
            </div>
            @endif
        </flux:card>
    </div>
    @endif

    <!-- ==================== TAB: KNOWLEDGE ==================== -->
    @if($activeTab === 'knowledge' && $canViewKnowledge)
    <div>
        <!-- Search and Bulk Action -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
            <div class="flex gap-2">
                @if(count($selectedKnowledge) > 0)
                <flux:button wire:click="markAsKnowledge" 
                             variant="primary" 
                             color="green"
                             class="bg-green-600 hover:bg-green-700">
                    Mark Knowledge ({{ count($selectedKnowledge) }})
                </flux:button>
                <flux:button wire:click="resetBulkSelections" variant="outline" size="sm">
                    Clear Selection
                </flux:button>
                @endif
            </div>
            <div class="w-full sm:w-64">
                <flux:input wire:model.live.debounce.300ms="searchKnowledge"
                            placeholder="Search sample..."
                            icon="magnifying-glass"
                            clearable />
            </div>
        </div>

        <!-- Knowledge Table -->
        <flux:card class="p-0 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
            <div class="overflow-x-auto" style="overflow-y: visible;">
                <table class="w-full min-w-[1100px]">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                        <tr>
                            <th class="px-4 py-3 text-center w-12">
                                <input type="checkbox" wire:model="selectAllKnowledge" class="rounded border-gray-300">
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Sample</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Updated Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Expired Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Alarm Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Prepared By</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Check By</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($knowledge as $item)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-4 py-3 text-center">
                                <input type="checkbox" value="{{ $item->id }}" wire:model="selectedKnowledge" class="rounded border-gray-300">
                            </td>
                            <td class="px-4 py-3">
                                <div class="relative group">
                                    <span class="text-sm font-medium text-zinc-800 dark:text-white block truncate max-w-[200px]"
                                          title="{{ $item->masterSample->model_name ?? 'N/A' }}">
                                        {{ $item->masterSample->model_name ?? 'N/A' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $item->updated_date ? \Carbon\Carbon::parse($item->updated_date)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $item->expired_date ? \Carbon\Carbon::parse($item->expired_date)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $item->date_alarm ? \Carbon\Carbon::parse($item->date_alarm)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $item->updater->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $item->checkedBy->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                    <svg class="w-3 h-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    Pending
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('prod.ms.master-sample.show', $item->master_sample_id) }}?activeRelationManager=1" 
                                   target="_blank"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    Go to Sample
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">No pending knowledge</h3>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">All caught up! No samples waiting for your knowledge.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($knowledge->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $knowledge->links() }}
            </div>
            @endif
        </flux:card>
    </div>
    @endif

    <!-- ==================== TAB: APPROVALS ==================== -->
    @if($activeTab === 'approvals' && $canViewApprovals)
    <div>
        <!-- Search and Bulk Action -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
            <div class="flex gap-2">
                @if(count($selectedApprovals) > 0)
                <flux:button wire:click="markAsApproved" 
                             variant="primary" 
                             color="green"
                             class="bg-green-600 hover:bg-green-700">
                    Mark Approved ({{ count($selectedApprovals) }})
                </flux:button>
                <flux:button wire:click="resetBulkSelections" variant="outline" size="sm">
                    Clear Selection
                </flux:button>
                @endif
            </div>
            <div class="w-full sm:w-64">
                <flux:input wire:model.live.debounce.300ms="searchApprovals"
                            placeholder="Search sample..."
                            icon="magnifying-glass"
                            clearable />
            </div>
        </div>

        <!-- Approvals Table -->
        <flux:card class="p-0 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
            <div class="overflow-x-auto" style="overflow-y: visible;">
                <table class="w-full min-w-[1200px]">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                        <tr>
                            <th class="px-4 py-3 text-center w-12">
                                <input type="checkbox" wire:model="selectAllApprovals" class="rounded border-gray-300">
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Sample</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Updated Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Expired Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Alarm Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Prepared By</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Check By</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($approvals as $item)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-4 py-3 text-center">
                                <input type="checkbox" value="{{ $item->id }}" wire:model="selectedApprovals" class="rounded border-gray-300">
                            </td>
                            <td class="px-4 py-3">
                                <div class="relative group">
                                    <span class="text-sm font-medium text-zinc-800 dark:text-white block truncate max-w-[200px]"
                                          title="{{ $item->masterSample->model_name ?? 'N/A' }}">
                                        {{ $item->masterSample->model_name ?? 'N/A' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $item->updated_date ? \Carbon\Carbon::parse($item->updated_date)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $item->expired_date ? \Carbon\Carbon::parse($item->expired_date)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $item->date_alarm ? \Carbon\Carbon::parse($item->date_alarm)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $item->updater->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $item->checkedBy->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                    <svg class="w-3 h-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    Pending
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('prod.ms.master-sample.show', $item->master_sample_id) }}?activeRelationManager=1" 
                                   target="_blank"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    Go to Sample
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">No pending approvals</h3>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">All caught up! No samples waiting for your approval.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($approvals->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $approvals->links() }}
            </div>
            @endif
        </flux:card>
    </div>
    @endif

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