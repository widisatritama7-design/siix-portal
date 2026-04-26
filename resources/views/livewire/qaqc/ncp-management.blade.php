<div class="p-1 space-y-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            QA/QC
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            NCP Management
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                NCP Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage Non-Conformance Process (NCP) records
            </p>
        </div>

        <!-- Tombol Add NCP -->
        @can('create ncp')
        <flux:button 
            variant="primary" 
            icon="plus" 
            class="bg-blue-600 hover:bg-blue-700"
            wire:click="resetForm"
            x-on:click="$dispatch('open-modal-ncp')"
        >
            Add New NCP
        </flux:button>
        @endcan
    </div>

    <!-- Search -->
    <div class="flex justify-end">
        <div class="w-full sm:w-64">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search NCP number or section..."
                icon="magnifying-glass"
                clearable
            />
        </div>
    </div>

    @can('view ncp all')
    <div class="mt-6 border-b border-zinc-200 dark:border-zinc-700">
        <div class="relative">
            <div class="overflow-x-auto scrollbar-hide">
                <div class="flex flex-nowrap gap-1 justify-center">
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

                    <!-- Open Tab -->
                    <button 
                        wire:click="setTab('open')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'open' ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                    >
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Open
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'open' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $tabCounts['open'] ?? 0 }}
                        </span>
                        @if($activeTab === 'open')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-yellow-600 dark:bg-yellow-400 rounded-t-full"></div>
                        @endif
                    </button>

                    <!-- In Progress Tab -->
                    <button 
                        wire:click="setTab('in_progress')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'in_progress' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                    >
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        In Progress
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'in_progress' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $tabCounts['in_progress'] ?? 0 }}
                        </span>
                        @if($activeTab === 'in_progress')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600 dark:bg-blue-400 rounded-t-full"></div>
                        @endif
                    </button>

                    <!-- Closed Tab -->
                    <button 
                        wire:click="setTab('closed')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'closed' ? 'text-green-600 dark:text-green-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                    >
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Closed
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'closed' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $tabCounts['closed'] ?? 0 }}
                        </span>
                        @if($activeTab === 'closed')
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

                    <!-- Deleted Tab -->
                    <button 
                        wire:click="setTab('deleted')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'deleted' ? 'text-gray-600 dark:text-gray-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                    >
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Deleted
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'deleted' ? 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                            {{ $tabCounts['deleted'] ?? 0 }}
                        </span>
                        @if($activeTab === 'deleted')
                            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gray-600 dark:bg-gray-400 rounded-t-full"></div>
                        @endif
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endcan

    <!-- NCP Table -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col">
        <div class="overflow-x-auto flex-1">
            <table class="w-full">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NCP Number</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Employee</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Section</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Remarks</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Created At</th>
                        @if($activeTab === 'deleted')
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Deleted By</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Deleted Reason</th>
                        @else
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($ncps as $index => $ncp)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="ncp-{{ $ncp->id }}">
                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $ncps->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div>
                                    <span class="text-sm font-semibold text-zinc-800 dark:text-white block">
                                        {{ $ncp->ncp_number }}
                                    </span>
                                    @if($activeTab === 'deleted' && $ncp->deleted_reason)
                                    <span class="text-xs text-red-500 dark:text-red-400">
                                        Deleted: {{ \Carbon\Carbon::parse($ncp->deleted_at)->format('d/m/Y H:i') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm">
                                <div class="font-medium text-zinc-800 dark:text-white">{{ $ncp->employee->name ?? 'N/A' }}</div>
                                <div class="text-xs text-zinc-500">{{ $ncp->employee->department ?? '-' }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                {{ $ncp->section ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $statusColors = [
                                    'open' => 'yellow',
                                    'in_progress' => 'blue',
                                    'closed' => 'green',
                                    'rejected' => 'red',
                                ];
                                $statusTexts = [
                                    'open' => 'Open',
                                    'in_progress' => 'In Progress',
                                    'closed' => 'Closed',
                                    'rejected' => 'Rejected',
                                ];
                            @endphp
                            <flux:badge size="sm" color="{{ $statusColors[$ncp->status] ?? 'gray' }}">
                                {{ $statusTexts[$ncp->status] ?? ucfirst($ncp->status) }}
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400 max-w-md truncate" title="{{ $ncp->remarks }}">
                            {{ $ncp->remarks ?: '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                            {{ $ncp->created_at ? \Carbon\Carbon::parse($ncp->created_at)->format('d/m/Y H:i') : '-' }}
                        </td>
                        
                        @if($activeTab === 'deleted')
                        <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                            {{ $ncp->deleter->name ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400 max-w-md">
                            <div class="truncate max-w-xs" title="{{ $ncp->deleted_reason }}">
                                {{ $ncp->deleted_reason ?: '-' }}
                            </div>
                        </td>
                        @else
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                @can('view ncp')
                                <flux:button 
                                    wire:click="view({{ $ncp->id }})" 
                                    size="sm"
                                    icon="eye"
                                    variant="primary"
                                    color="blue"
                                    class="!p-2"
                                    title="View NCP"
                                />
                                @endcan
                                @can('edit ncp')
                                    @if(!in_array($ncp->status, ['closed', 'rejected']))
                                    <flux:button 
                                        wire:click="edit({{ $ncp->id }})" 
                                        size="sm"
                                        icon="pencil-square"
                                        variant="primary"
                                        color="yellow"
                                        class="!p-2"
                                        title="Edit NCP"
                                    />
                                    @endif
                                @endcan

                                @can('delete ncp')
                                    @if(!in_array($ncp->status, ['closed', 'rejected']))
                                    <flux:button 
                                        wire:click="confirmDelete({{ $ncp->id }})" 
                                        size="sm"
                                        icon="trash"
                                        variant="primary"
                                        color="red"
                                        class="!p-2"
                                        title="Delete NCP"
                                    />
                                    @endif
                                @endcan
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $activeTab === 'deleted' ? '9' : '8' }}" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center justify-center gap-3 min-h-[400px]">
                                <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <flux:icon name="document-text" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        @if($activeTab === 'deleted')
                                            No deleted NCP records found
                                        @else
                                            No NCP records found
                                        @endif
                                    </h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                        {{ $search ? 'Try adjusting your search query' : 'Get started by creating a new NCP record' }}
                                    </p>
                                </div>
                                @if($search)
                                    <flux:button wire:click="$set('search', '')" size="sm">
                                        Clear Search
                                    </flux:button>
                                @else
                                    @if($activeTab !== 'deleted')
                                        @can('create ncp')
                                        <flux:button 
                                            variant="primary" 
                                            size="sm"
                                            wire:click="resetForm"
                                            x-on:click="$dispatch('open-modal-ncp')"
                                        >
                                            Add Your First NCP
                                        </flux:button>
                                        @endcan
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($ncps->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 mt-auto">
            {{ $ncps->links() }}
        </div>
        @endif
    </flux:card>

    <!-- MODAL FORM NCP -->
    <div x-data="{ 
        open: false,
        init() {
            this.$watch('open', value => {
                if (value) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });
        }
    }" 
        x-on:open-modal-ncp.window="open = true"
        x-on:close-modal-ncp.window="open = false"
        x-show="open"
        x-cloak
        @keydown.escape.window="open = false">

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-3xl max-h-[90vh] flex flex-col">
                <!-- Header Modal -->
                <div class="p-6 pb-0">
                    <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>
                </div>
                
                <!-- Form Content -->
                <div class="flex-1 overflow-y-auto p-3 pt-2">
                    <form wire:submit="save" id="ncp-form">
                        
                        <!-- SHOW ONLY ON EDIT MODE -->
                        @if($ncp_id)
                            <!-- Card 1: Product & Quality Information -->
                            <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 mb-4 shadow-sm overflow-hidden">
                                <div class="px-4 py-3 border-b" style="background-color: #cffafe;">
                                    <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800 dark:text-zinc-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        Product & Quality Information
                                    </h3>
                                </div>
                                <div class="p-4">
                                    <div class="mb-4">
                                        <div class="grid grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <flux:label>PART DESCRIPTION</flux:label>
                                                <flux:input wire:model="part_description" type="text" placeholder="Enter part description" />
                                            </div>
                                            <div>
                                                <flux:label>MODEL AFFECTED</flux:label>
                                                <flux:input wire:model="model_affected" type="text" placeholder="Enter model affected" />
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <flux:label>PART NUMBER</flux:label>
                                                <flux:input wire:model="part_number" type="text" placeholder="Enter part number" />
                                            </div>
                                            <div>
                                                <flux:label>LOT NO.</flux:label>
                                                <flux:input wire:model="lot_no" type="text" placeholder="Enter lot number" />
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <flux:label>SUPPLIER</flux:label>
                                                <flux:input wire:model="supplier" type="text" placeholder="Enter supplier name" />
                                            </div>
                                            <div>
                                                <flux:label>LOT QTY</flux:label>
                                                <flux:input wire:model.live="lot_qty" type="number" min="0" placeholder="Enter lot quantity" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <flux:label>CUSTOMER</flux:label>
                                                <flux:input wire:model="customer" type="text" placeholder="Enter customer name" />
                                            </div>
                                            <div>
                                                <div class="grid grid-cols-2 gap-2">
                                                    <div>
                                                        <flux:label>REJECTED QTY</flux:label>
                                                        <flux:input wire:model.live="rejected_qty" type="number" min="0" placeholder="Enter rejected quantity" />
                                                    </div>
                                                    <div>
                                                        <flux:label>FAILURE RATE</flux:label>
                                                        <div class="px-3 py-2 bg-zinc-100 dark:bg-zinc-800 rounded-lg text-center font-semibold">
                                                            {{ $failure_rate ? $failure_rate . '%' : '0%' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2: Defect Details -->
                            <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 mb-4 shadow-sm overflow-hidden">
                                <div class="px-4 py-3 border-b flex justify-between items-center" style="background-color: #fed7aa;">
                                    <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800 dark:text-zinc-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        Defect Details
                                    </h3>
                                    <button type="button" wire:click="addDefectDetail" class="text-blue-600 hover:text-blue-700 text-sm px-3 py-1 border border-blue-600 rounded-lg bg-white">
                                        + Add Defect
                                    </button>
                                </div>
                                <div class="p-4">
                                    <div class="overflow-x-auto">
                                        <table class="w-full border border-zinc-200 dark:border-zinc-700 rounded-lg">
                                            <thead class="bg-zinc-50 dark:bg-zinc-800">
                                                <tr>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500">S/N</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500">DEFECT DESCRIPTION</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 w-20">QTY</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500">REMARKS</th>
                                                    <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 w-10">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($defect_details as $index => $defect)
                                                <tr class="border-t border-zinc-200 dark:border-zinc-700">
                                                    <td class="px-3 py-2">
                                                        <flux:input wire:model="defect_details.{{ $index }}.serial_number" type="text" placeholder="S/N" size="sm" />
                                                    </td>
                                                    <td class="px-3 py-2">
                                                        <flux:input wire:model="defect_details.{{ $index }}.defect_description" type="text" placeholder="Defect description" size="sm" />
                                                    </td>
                                                    <td class="px-3 py-2">
                                                        <flux:input wire:model="defect_details.{{ $index }}.quantity" type="number" min="1" placeholder="Qty" size="sm" />
                                                    </td>
                                                    <td class="px-3 py-2">
                                                        <flux:input wire:model="defect_details.{{ $index }}.defect_remarks" type="text" placeholder="Remarks" size="sm" />
                                                    </td>
                                                    <td class="px-3 py-2 text-center">
                                                        <button type="button" wire:click="removeDefectDetail({{ $index }})" class="text-red-500 hover:text-red-700">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr class="border-t border-zinc-200 dark:border-zinc-700">
                                                    <td colspan="5" class="px-3 py-4 text-center text-zinc-500">
                                                        No defect details added. Click "Add Defect" to add.
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3: Document Information -->
                            <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 mb-4 shadow-sm overflow-hidden">
                                <div class="px-4 py-3 border-b" style="background-color: #a7f3d0;">
                                    <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800 dark:text-zinc-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Document Information
                                    </h3>
                                </div>
                                <div class="p-4">
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <flux:label>DO No.</flux:label>
                                            <flux:input wire:model="do_no" type="text" placeholder="Enter DO number" />
                                        </div>
                                        <div>
                                            <flux:label>Packing List No./Invoice No.</flux:label>
                                            <flux:input wire:model="packing_list_no" type="text" placeholder="Enter packing list or invoice number" />
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <flux:label>REMARKS</flux:label>
                                        <flux:textarea wire:model="remarks" rows="3" placeholder="Enter remarks..." />
                                    </div>
                                </div>
                            </div>

                            <!-- Card 4: DISPOSITION -->
                            <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 mb-4 shadow-sm overflow-hidden">
                                <div class="px-4 py-3 border-b" style="background-color: #ddd6fe;">
                                    <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800 dark:text-zinc-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        Disposition
                                    </h3>
                                </div>
                                <div class="p-4">
                                    @php
                                        $dispositionOptions = ['Sorting', 'Rework', 'Scrap', 'Use as it', 'RTV/S. (CAR/NO CAR)', 'Others'];
                                    @endphp
                                    
                                    <div class="space-y-3">
                                        @foreach($dispositionOptions as $option)
                                        <div class="border-b border-zinc-100 dark:border-zinc-700 pb-3 last:border-0">
                                            <label class="flex items-start gap-2 mb-2">
                                                <input type="checkbox" 
                                                    value="{{ $option }}"
                                                    wire:model="disposition"
                                                    class="mt-1 rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                                <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $option }}</span>
                                            </label>
                                            
                                            <!-- Textarea untuk setiap pilihan yang dicentang -->
                                            <div x-show="Array.from($wire.disposition || []).includes('{{ $option }}')" 
                                                x-cloak 
                                                class="ml-6 mt-2 transition-all duration-200">
                                                <flux:textarea 
                                                    wire:model="disposition_details.{{ $option }}" 
                                                    rows="2" 
                                                    placeholder="Additional details for '{{ $option }}' (optional)..."
                                                    class="text-sm"
                                                />
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    @error('disposition') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Card 5: Status & File Attachment -->
                            <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 mb-4 shadow-sm overflow-hidden">
                                <div class="px-4 py-3 border-b" style="background-color: #fde68a;">
                                    <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800 dark:text-zinc-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        Status & Attachment
                                    </h3>
                                </div>
                                <div class="p-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <flux:label>Status</flux:label>
                                            <flux:select wire:model="status">
                                                @foreach($statuses as $key => $value)
                                                    <flux:select.option value="{{ $key }}">{{ $value }}</flux:select.option>
                                                @endforeach
                                            </flux:select>
                                        </div>
                                        
                                        <div>
                                            <flux:label>File Attachment</flux:label>
                                            
                                            @if($existingFile && !$removeFile)
                                                <div class="mb-2 p-2 bg-zinc-100 dark:bg-zinc-800 rounded-lg flex items-center justify-between">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-5 h-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                        <a href="{{ Storage::url($existingFile) }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                                            Current File
                                                        </a>
                                                    </div>
                                                    <button type="button" wire:click="$set('removeFile', true)" class="text-red-500 hover:text-red-700 text-sm">
                                                        Remove
                                                    </button>
                                                </div>
                                            @endif
                                            
                                            @if(!$removeFile)
                                                <input type="file" wire:model="newFile" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800">
                                                @error('newFile') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- ALWAYS SHOW: Card 6: Prepared By, Section & Remarks -->
                        <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 mb-4 shadow-sm overflow-hidden">
                            <div class="px-4 py-3 border-b" style="background-color: #fecaca;">
                                <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800 dark:text-zinc-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Prepared By
                                </h3>
                            </div>
                            <div class="p-4">
                                @if($ncp_id && $employee_id)
                                    <div class="mb-4">
                                        <div class="overflow-x-auto">
                                            <table class="w-full border border-zinc-200 dark:border-zinc-700 rounded-lg">
                                                <thead class="bg-zinc-50 dark:bg-zinc-800">
                                                    <tr>
                                                        <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500">NIK</th>
                                                        <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500">NAME</th>
                                                        <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500">DEPARTMENT</th>
                                                        <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500">SECTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="border-t border-zinc-200 dark:border-zinc-700">
                                                        <td class="px-3 py-2 text-sm">{{ $nik ?? '-' }}</td>
                                                        <td class="px-3 py-2 text-sm">{{ $name }}</td>
                                                        <td class="px-3 py-2 text-sm">{{ $department }}</td>
                                                        <td class="px-3 py-2 text-sm">{{ $section }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <input type="hidden" wire:model="employee_id">
                                    </div>
                                @else
                                    <div class="mb-4">
                                        <flux:label required>NIK and Name</flux:label>
                                        
                                        <div x-data="{ 
                                            show: false, 
                                            search: '', 
                                            employees: [],
                                            loading: false,
                                            searchTimeout: null,
                                            loadEmployees() {
                                                if (this.search.length < 2) {
                                                    this.employees = [];
                                                    return;
                                                }
                                                
                                                clearTimeout(this.searchTimeout);
                                                this.searchTimeout = setTimeout(() => {
                                                    this.loading = true;
                                                    @this.call('searchEmployees', this.search).then(result => {
                                                        this.employees = result;
                                                        this.loading = false;
                                                    }).catch(() => {
                                                        this.loading = false;
                                                    });
                                                }, 300);
                                            }
                                        }" class="relative">
                                            <input 
                                                type="text"
                                                x-model="search"
                                                @input="loadEmployees(); show = search.length >= 2"
                                                @focus="show = search.length >= 2"
                                                placeholder="Search by NIK or name (min 2 characters)..."
                                                class="w-full px-3 py-2 border border-zinc-300 rounded-lg 
                                                    focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                                                    dark:bg-zinc-800 dark:border-zinc-600 dark:text-white"
                                            >
                                            <div x-show="loading" class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-800 p-2 text-center rounded-lg shadow-lg">
                                                <svg class="animate-spin h-5 w-5 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </div>
                                            <div 
                                                x-show="show && !loading && employees.length > 0"
                                                x-transition
                                                @click.outside="show = false"
                                                class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-800 
                                                    border border-zinc-300 dark:border-zinc-600 rounded-lg shadow-lg 
                                                    max-h-60 overflow-y-auto"
                                                style="display: none;"
                                            >
                                                <template x-for="emp in employees" :key="emp.id">
                                                    <div 
                                                        @click="
                                                            $wire.selectEmployee(emp.id); 
                                                            show = false;
                                                            search = emp.label;
                                                        "
                                                        class="px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700 cursor-pointer text-sm border-b border-zinc-100 dark:border-zinc-700 last:border-0"
                                                        x-text="emp.label"
                                                    >
                                                    </div>
                                                </template>
                                            </div>
                                            <div x-show="show && !loading && employees.length === 0 && search.length >= 2" 
                                                x-cloak
                                                class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-800 p-3 text-center text-sm text-zinc-500 rounded-lg shadow-lg">
                                                No employees found
                                            </div>
                                        </div>
                                        
                                        @error('employee_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div class="mb-4">
                                        <flux:label>Section</flux:label>
                                        <flux:input wire:model="section" type="text" placeholder="Enter section" />
                                    </div>
                                    
                                    <div class="mb-4">
                                        <flux:label>Remarks</flux:label>
                                        <flux:textarea wire:model="remarks" rows="3" placeholder="Enter remarks..." />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Footer Buttons -->
                <div class="p-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <div class="flex justify-end gap-2">
                        <button type="button" 
                                @click="open = false"
                                class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                form="ncp-form"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50"
                                wire:loading.attr="disabled"
                                wire:target="save">
                            <span wire:loading.remove wire:target="save">{{ $ncp_id ? 'Update' : 'Create' }}</span>
                            <span wire:loading wire:target="save" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL VIEW NCP -->
    <div x-data="{ open: false }" 
        x-on:open-modal-view.window="open = true"
        x-on:close-modal-view.window="open = false"
        x-show="open"
        x-cloak
        @keydown.escape.window="open = false">

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col">
                <!-- Header Modal -->
                <div class="p-6 pb-0 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-xl font-bold">NCP Detail</h2>
                </div>
                
                <!-- Content -->
                <div class="flex-1 overflow-y-auto p-6">
                    @if($viewData)
                        <!-- Header Info (NCP Number & Status) -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/20 dark:to-indigo-950/20 rounded-lg border border-blue-200 dark:border-blue-800 p-4 mb-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">NCP Number</span>
                                    <p class="font-semibold text-lg text-zinc-800 dark:text-white">{{ $viewData->ncp_number }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Status</span>
                                    <div class="mt-1">
                                        @php
                                            $statusColors = ['open' => 'yellow', 'in_progress' => 'blue', 'closed' => 'green', 'rejected' => 'red'];
                                            $statusTexts = ['open' => 'Open', 'in_progress' => 'In Progress', 'closed' => 'Closed', 'rejected' => 'Rejected'];
                                        @endphp
                                        <flux:badge size="md" color="{{ $statusColors[$viewData->status] ?? 'gray' }}">
                                            {{ $statusTexts[$viewData->status] ?? ucfirst($viewData->status) }}
                                        </flux:badge>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 1: Product & Quality Information -->
                        <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 mb-4 shadow-sm overflow-hidden">
                            <div class="px-4 py-3 border-b" style="background-color: #cffafe;">
                                <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    Product & Quality Information
                                </h3>
                            </div>
                            <div class="p-4">
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">PART DESCRIPTION</span>
                                        <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->part_description ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">MODEL AFFECTED</span>
                                        <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->model_affected ?? '-' }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">PART NUMBER</span>
                                        <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->part_number ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">LOT NO.</span>
                                        <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->lot_no ?? '-' }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">SUPPLIER</span>
                                        <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->supplier ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">LOT QTY</span>
                                        <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->lot_qty ?? '-' }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">CUSTOMER</span>
                                        <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->customer ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <div class="grid grid-cols-2 gap-2">
                                            <div>
                                                <span class="text-xs text-zinc-500 dark:text-zinc-400">REJECTED QTY</span>
                                                <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->rejected_qty ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <span class="text-xs text-zinc-500 dark:text-zinc-400">FAILURE RATE</span>
                                                <p class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->failure_rate ? $viewData->failure_rate . '%' : '0%' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Defect Details -->
                        <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 mb-4 shadow-sm overflow-hidden">
                            <div class="px-4 py-3 border-b" style="background-color: #fed7aa;">
                                <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    Defect Details
                                </h3>
                            </div>
                            <div class="p-4">
                                @if($viewData->defect_details && count($viewData->defect_details) > 0)
                                    <div class="overflow-x-auto">
                                        <table class="w-full border border-zinc-200 dark:border-zinc-700 rounded-lg">
                                            <thead class="bg-zinc-50 dark:bg-zinc-800">
                                                <tr>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500">S/N</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500">DEFECT DESCRIPTION</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 w-20">QTY</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500">REMARKS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($viewData->defect_details as $defect)
                                                <tr class="border-t border-zinc-200 dark:border-zinc-700">
                                                    <td class="px-3 py-2 text-sm">{{ $defect['serial_number'] ?? '-' }}</td>
                                                    <td class="px-3 py-2 text-sm">{{ $defect['defect_description'] ?? '-' }}</td>
                                                    <td class="px-3 py-2 text-sm">{{ $defect['quantity'] ?? '-' }}</td>
                                                    <td class="px-3 py-2 text-sm">{{ $defect['defect_remarks'] ?? '-' }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-sm text-zinc-500 text-center py-4">No defect details available</p>
                                @endif
                            </div>
                        </div>

                        <!-- Card 3: Document Information -->
                        <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 mb-4 shadow-sm overflow-hidden">
                            <div class="px-4 py-3 border-b" style="background-color: #a7f3d0;">
                                <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Document Information
                                </h3>
                            </div>
                            <div class="p-4">
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">DO No.</span>
                                        <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->do_no ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">Packing List No./Invoice No.</span>
                                        <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->packing_list_no ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">REMARKS</span>
                                        <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->remarks ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 4: Disposition dengan Badge -->
                        <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 mb-4 shadow-sm overflow-hidden">
                            <div class="px-4 py-3 border-b" style="background-color: #ddd6fe;">
                                <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    Disposition
                                </h3>
                            </div>
                            <div class="p-4">
                                @php
                                    $dispositionData = [];
                                    $dispositionColors = [
                                        'Sorting' => 'cyan',
                                        'Rework' => 'orange',
                                        'Scrap' => 'red',
                                        'Use as it' => 'yellow',
                                        'RTV/S. (CAR/NO CAR)' => 'purple',
                                        'Others' => 'gray',
                                    ];
                                    
                                    if ($viewData->disposition) {
                                        $parts = explode(', ', $viewData->disposition);
                                        foreach ($parts as $part) {
                                            if (str_contains($part, ': ')) {
                                                list($key, $value) = explode(': ', $part, 2);
                                                $dispositionData[] = ['type' => trim($key), 'detail' => trim($value)];
                                            } else {
                                                $dispositionData[] = ['type' => trim($part), 'detail' => null];
                                            }
                                        }
                                    }
                                @endphp
                                
                                @if(count($dispositionData) > 0)
                                    <div class="flex flex-wrap gap-3">
                                        @foreach($dispositionData as $item)
                                            <div class="inline-flex flex-col">
                                                <flux:badge size="md" color="{{ $dispositionColors[$item['type']] ?? 'gray' }}" class="mb-1">
                                                    {{ $item['type'] }}
                                                </flux:badge>
                                                @if($item['detail'])
                                                    <span class="text-xs text-zinc-600 dark:text-zinc-400 mt-1 ml-1">
                                                        {{ $item['detail'] }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-zinc-500">-</p>
                                @endif
                            </div>
                        </div>

                        <!-- Card 5: File Attachment -->
                        @if($viewData->file)
                        <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 mb-4 shadow-sm overflow-hidden">
                            <div class="px-4 py-3 border-b" style="background-color: #fde68a;">
                                <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    File Attachment
                                </h3>
                            </div>
                            <div class="p-4">
                                <a href="{{ Storage::url($viewData->file) }}" target="_blank" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Download File
                                </a>
                            </div>
                        </div>
                        @endif

                        <!-- Card 6: Prepared By -->
                        <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 mb-4 shadow-sm overflow-hidden">
                            <div class="px-4 py-3 border-b" style="background-color: #fecaca;">
                                <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Prepared By
                                </h3>
                            </div>
                            <div class="p-4">
                                <div class="overflow-x-auto">
                                    <table class="w-full border border-zinc-200 dark:border-zinc-700 rounded-lg">
                                        <thead class="bg-zinc-50 dark:bg-zinc-800">
                                            <tr>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500">NIK</th>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500">NAME</th>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500">DEPARTMENT</th>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500">SECTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="border-t border-zinc-200 dark:border-zinc-700">
                                                <td class="px-3 py-2 text-sm">{{ $viewData->employee->nik ?? '-' }}</td>
                                                <td class="px-3 py-2 text-sm">{{ $viewData->employee->name ?? '-' }}</td>
                                                <td class="px-3 py-2 text-sm">{{ $viewData->employee->department ?? '-' }}</td>
                                                <td class="px-3 py-2 text-sm">{{ $viewData->section ?? '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Card 7: Deletion Information (only for deleted records) -->
                        @if($viewData->deleted_at)
                        <div class="bg-red-50 dark:bg-red-950/20 rounded-lg border border-red-200 dark:border-red-800 mb-4 shadow-sm overflow-hidden">
                            <div class="px-4 py-3 border-b border-red-200 dark:border-red-800" style="background-color: #fee2e2;">
                                <h3 class="text-md font-semibold flex items-center gap-2 text-red-700 dark:text-red-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Deletion Information
                                </h3>
                            </div>
                            <div class="p-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">Deleted By</span>
                                        <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->deleter->name ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">Deleted At</span>
                                        <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->deleted_at ? $viewData->deleted_at->format('d/m/Y H:i') : '-' }}</p>
                                    </div>
                                    <div class="col-span-2">
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">Deletion Reason</span>
                                        <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->deleted_reason ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 mx-auto mb-4 bg-zinc-100 dark:bg-zinc-800 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-zinc-400 dark:text-zinc-500 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400">Loading NCP data...</p>
                        </div>
                    @endif
                </div>
                
                <!-- Footer Buttons -->
                <div class="p-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <div class="flex justify-end gap-2">
                        <button type="button" 
                                @click="open = false"
                                class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors text-zinc-700 dark:text-zinc-300">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE -->
    <div x-data="{ open: false }" 
        x-show="open" 
        x-on:open-modal-delete.window="open = true"
        x-on:close-modal-delete.window="open = false"
        x-cloak
        @keydown.escape.window="open = false">

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>

                <h3 class="text-lg font-bold mb-2 text-center">Delete NCP Record</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4 text-center">
                    Are you sure you want to delete NCP <span class="font-semibold">{{ $ncpToDelete?->ncp_number }}</span>?
                </p>
                
                <!-- Delete Reason -->
                <div class="mb-4">
                    <flux:label required>Reason for Deletion</flux:label>
                    <flux:textarea 
                        wire:model="deleteReason" 
                        rows="3" 
                        placeholder="Please provide a reason why this NCP is being deleted..."
                        class="w-full"
                    />
                    @error('deleteReason') 
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="flex justify-center gap-3 mt-4">
                    <button @click="open = false" 
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="delete" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
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
        [x-cloak] { 
            display: none !important; 
        }
        
        /* Prevent body scroll when modal is open */
        body.modal-open {
            overflow: hidden;
        }
        
        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        
        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</div>