<section class="w-full">
    <x-mtc.layout class="!max-w-full !px-0 !mx-0">
        <x-slot name="heading">
            <div class="w-full">
                <flux:breadcrumbs class="mb-1">
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
                        Dashboard
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        MTC
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        Stencil Management
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                            Stencil Management
                        </h1>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            Manage stencil inventory and status
                        </p>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <!-- Search Bar -->
                        <div class="w-64">
                            <flux:input
                                wire:model.live.debounce.300ms="search"
                                placeholder="Search by Register No..."
                                icon="magnifying-glass"
                                clearable
                            />
                        </div>
                        
                        @can('create stencil')
                        <flux:button 
                            wire:navigate
                            href="{{ route('mtc.stencil.create') }}"
                            variant="primary"
                            class="bg-blue-600 hover:bg-blue-700 whitespace-nowrap"
                        >
                            <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add New Stencil
                        </flux:button>
                        @endcan
                    </div>
                </div>
            </div>
        </x-slot>

        <div class="-mt-2">

            <!-- Tabs Navigation - Di atas table dan center -->
            <div class="mt-2 mb-6 border-b border-zinc-200 dark:border-zinc-700">
                <div class="flex justify-center">
                    <div class="flex flex-wrap gap-1">
                        <!-- Use In Line -->
                        <button wire:click="setTab('in_use_with_line')" class="px-4 py-2 text-sm font-medium transition-all duration-200 {{ $activeTab === 'in_use_with_line' ? 'border-b-2 border-emerald-500 text-emerald-600 dark:text-emerald-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Use In Line
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'in_use_with_line' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                                {{ $tabCounts['in_use_with_line'] ?? 0 }}
                            </span>
                        </button>

                        <!-- Prepared -->
                        <button wire:click="setTab('prepared')" class="px-4 py-2 text-sm font-medium transition-all duration-200 {{ $activeTab === 'prepared' ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Prepared
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'prepared' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                                {{ $tabCounts['prepared'] ?? 0 }}
                            </span>
                        </button>

                        <!-- Cleaning -->
                        <button wire:click="setTab('cleaning')" class="px-4 py-2 text-sm font-medium transition-all duration-200 {{ $activeTab === 'cleaning' ? 'border-b-2 border-yellow-500 text-yellow-600 dark:text-yellow-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 8H9L8 4z"></path>
                            </svg>
                            Cleaning
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'cleaning' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                                {{ $tabCounts['cleaning'] ?? 0 }}
                            </span>
                        </button>

                        <!-- Stand By -->
                        <button wire:click="setTab('stand_by')" class="px-4 py-2 text-sm font-medium transition-all duration-200 {{ $activeTab === 'stand_by' ? 'border-b-2 border-purple-500 text-purple-600 dark:text-purple-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Stand By
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'stand_by' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                                {{ $tabCounts['stand_by'] ?? 0 }}
                            </span>
                        </button>

                        <!-- Disposed -->
                        <button wire:click="setTab('disposed')" class="px-4 py-2 text-sm font-medium transition-all duration-200 {{ $activeTab === 'disposed' ? 'border-b-2 border-gray-500 text-gray-600 dark:text-gray-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Disposed
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'disposed' ? 'bg-gray-200 text-gray-800 dark:bg-gray-800 dark:text-gray-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                                {{ $tabCounts['disposed'] ?? 0 }}
                            </span>
                        </button>

                        <!-- In Use -->
                        <button wire:click="setTab('in_use')" class="px-4 py-2 text-sm font-medium transition-all duration-200 {{ $activeTab === 'in_use' ? 'border-b-2 border-green-500 text-green-600 dark:text-green-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            In Use
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'in_use' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                                {{ $tabCounts['in_use'] ?? 0 }}
                            </span>
                        </button>

                        <!-- All -->
                        <button wire:click="setTab('all')" class="px-4 py-2 text-sm font-medium transition-all duration-200 {{ $activeTab === 'all' ? 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            All
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'all' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                                {{ $tabCounts['all'] ?? 0 }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stencil Table -->
            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Register No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Customer</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Rack Number</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Line Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Count</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Last Update</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($stencils as $stencil)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <span class="text-sm font-semibold text-zinc-800 dark:text-white block">
                                                {{ $stencil->register_no }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $stencil->customer ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $stencil->rack_number ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusColorClass($stencil->status) }}">
                                        {{ $stencil->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $stencil->line_name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $stencil->count_stencil ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm">
                                        <div>{{ $stencil->employee->name ?? '-' }}</div>
                                        <div class="text-xs text-zinc-500">{{ $stencil->updated_at ? $stencil->updated_at->format('d M Y H:i') : '-' }}</div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        @can('view stencil')
                                        <flux:tooltip content="View Activity Log" position="bottom">
                                            <flux:button 
                                                wire:click="viewActivity({{ $stencil->id }})"
                                                size="sm"
                                                icon="document-text"
                                                variant="primary"
                                                class="!p-2 !bg-purple-600 hover:!bg-purple-700"
                                            />
                                        </flux:tooltip>
                                        @endcan
                                        
                                        @can('edit stencil')
                                        <flux:tooltip content="Edit Stencil" position="bottom">
                                            <flux:button 
                                                wire:navigate
                                                href="{{ route('mtc.stencil.edit', $stencil->id) }}"
                                                size="sm"
                                                icon="pencil-square"
                                                variant="primary"
                                                class="!p-2 !bg-blue-600 hover:!bg-blue-700"
                                            />
                                        </flux:tooltip>
                                        
                                        <flux:tooltip content="Update Status" position="bottom">
                                            <flux:button 
                                                wire:navigate
                                                href="{{ route('mtc.stencil.update-status', $stencil->id) }}"
                                                size="sm"
                                                icon="arrow-path"
                                                variant="primary"
                                                class="!p-2 !bg-yellow-600 hover:!bg-yellow-700"
                                            />
                                        </flux:tooltip>
                                        @endcan
                                        
                                        @can('delete stencil')
                                        <flux:tooltip content="Delete Stencil" position="bottom">
                                            <flux:button 
                                                wire:click="confirmDelete({{ $stencil->id }})"
                                                x-on:click="$dispatch('open-modal', 'delete-stencil-modal')"
                                                size="sm"
                                                icon="trash"
                                                variant="danger"
                                                class="!p-2"
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
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <flux:icon name="document-magnifying-glass" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No stencil records found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                                {{ $search ? 'Try adjusting your search query' : 'Get started by creating a new stencil' }}
                                            </p>
                                        </div>
                                        @if($search)
                                            <flux:button wire:click="$set('search', '')" size="sm">
                                                Clear Search
                                            </flux:button>
                                        @else
                                            @can('create stencil')
                                            <flux:button 
                                                variant="primary" 
                                                size="sm"
                                                wire:navigate
                                                href="{{ route('mtc.stencil.create') }}"
                                            >
                                                Add Your First Stencil
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

                @if($stencils->hasPages())
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $stencils->links() }}
                </div>
                @endif
            </flux:card>
        </div>
    </x-mtc.layout>

    <!-- MODAL ACTIVITY LOG -->
    <flux:modal wire:model="showActivityModal" class="w-full max-w-5xl">
        <div class="flex flex-col" style="height: auto; max-height: 85vh; overflow: hidden;">
            <!-- Modal Header -->
            <div class="flex justify-between items-center px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex-shrink-0">
                <div>
                    <h2 class="text-xl font-bold text-zinc-800 dark:text-white">
                        Activity Log
                    </h2>
                    @if($selectedStencilForActivity)
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        Stencil: <span class="font-semibold">{{ $selectedStencilForActivity->register_no }}</span>
                        @if($selectedStencilForActivity->customer) | Customer: <span class="font-semibold">{{ $selectedStencilForActivity->customer }}</span> @endif
                    </p>
                    @endif
                </div>
            </div>

            @if($selectedStencilForActivity)
            @php
                // PERBAIKAN: Cek apakah $activities ada dan merupakan object
                $activitiesData = isset($activities) && $activities instanceof \Illuminate\Pagination\LengthAwarePaginator 
                    ? $activities 
                    : collect();
                $totalRecords = $activitiesData->total() ?? 0;
                $lastPage = $activitiesData->lastPage() ?? 1;
                
                // Load users untuk relasi created_by/updated_by
                $allUsers = \App\Models\User::all()->keyBy('id');
                $allEmployees = \App\Models\HR\Employee::all()->keyBy('id');
            @endphp
            
            <div class="flex-1 overflow-y-auto p-6">
                @if($totalRecords > 0)
                    <div class="space-y-4">
                        <!-- Legend Badges -->
                        <div class="flex gap-2 mb-2">
                            <span class="px-2 py-1 rounded-full text-white font-bold bg-red-600 text-xs">Old Value</span>
                            <span class="px-2 py-1 rounded-full text-white font-bold bg-green-600 text-xs">New Value</span>
                        </div>

                        <div class="space-y-2">
                            @foreach($activitiesData as $index => $activity)
                                @php
                                    // PERBAIKAN: Cek apakah attribute_changes ada dan valid
                                    $attributeChanges = [];
                                    if (isset($activity->attribute_changes)) {
                                        $attributeChanges = is_string($activity->attribute_changes) 
                                            ? json_decode($activity->attribute_changes, true) 
                                            : ($activity->attribute_changes ?? []);
                                    }
                                    
                                    $old = $attributeChanges['old'] ?? [];
                                    $new = $attributeChanges['attributes'] ?? [];
                                    
                                    // PERBAIKAN: Cek properti sebagai fallback
                                    if (empty($old) && empty($new) && isset($activity->properties)) {
                                        $props = is_string($activity->properties) 
                                            ? json_decode($activity->properties, true) 
                                            : ($activity->properties ?? []);
                                        $old = $props['old'] ?? [];
                                        $new = $props['attributes'] ?? [];
                                    }
                                    
                                    $changes = [];
                                    if ($activity->event == 'created') {
                                        foreach ($new as $key => $val) {
                                            if (!in_array($key, ['created_by', 'updated_by', 'id', 'created_at', 'updated_at'])) {
                                                // PERBAIKAN: Pastikan $val bukan array
                                                $changes[$key] = ['old' => null, 'new' => is_array($val) ? json_encode($val) : $val];
                                            }
                                        }
                                    } elseif ($activity->event == 'updated') {
                                        foreach ($new as $key => $val) {
                                            $oldVal = $old[$key] ?? null;
                                            // PERBAIKAN: Pastikan nilai bukan array
                                            if ($oldVal !== $val && !in_array($key, ['created_by', 'updated_by', 'id', 'created_at', 'updated_at'])) {
                                                $changes[$key] = [
                                                    'old' => is_array($oldVal) ? json_encode($oldVal) : $oldVal,
                                                    'new' => is_array($val) ? json_encode($val) : $val
                                                ];
                                            }
                                        }
                                    } elseif ($activity->event == 'deleted') {
                                        foreach ($old as $key => $val) {
                                            if (!in_array($key, ['created_by', 'updated_by', 'id', 'created_at', 'updated_at'])) {
                                                $changes[$key] = ['old' => is_array($val) ? json_encode($val) : $val, 'new' => null];
                                            }
                                        }
                                    }
                                    
                                    $isFirst = $loop->first;
                                @endphp
                                
                                @if(!empty($changes))
                                <div x-data="{ open: {{ $isFirst ? 'true' : 'false' }} }" class="border rounded-lg shadow-sm bg-white dark:bg-zinc-900">
                                    <button type="button"
                                            @click="open = !open"
                                            class="w-full flex justify-between items-center px-4 py-3 text-left font-medium bg-gray-100 hover:bg-gray-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 rounded-t-lg">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            @if($activity->event == 'created')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    CREATED
                                                </span>
                                            @elseif($activity->event == 'updated')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    UPDATED
                                                </span>
                                            @elseif($activity->event == 'deleted')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    DELETED
                                                </span>
                                            @endif
                                            <strong class="text-sm text-zinc-800 dark:text-zinc-200">{{ $activity->causer?->name ?? 'System' }}</strong>
                                            <span class="text-xs text-zinc-500">{{ $activity->created_at ? $activity->created_at->format('d M Y H:i:s') : '-' }}</span>
                                        </div>
                                        <svg :class="{ 'rotate-180': open }"
                                            class="w-4 h-4 transform transition-transform text-zinc-500"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div x-show="open" x-transition class="p-4 space-y-2">
                                        @foreach ($changes as $field => $change)
                                            @php
                                                $oldValue = $change['old'];
                                                $newValue = $change['new'];
                                                $fieldName = ucfirst(str_replace('_', ' ', $field));
                                                
                                                // Format untuk field nik (employee)
                                                if ($field === 'nik') {
                                                    if (!empty($oldValue)) {
                                                        $employee = $allEmployees[$oldValue] ?? null;
                                                        $oldValue = $employee ? $employee->name . ' (' . $employee->nik . ')' : $oldValue;
                                                    }
                                                    if (!empty($newValue)) {
                                                        $employee = $allEmployees[$newValue] ?? null;
                                                        $newValue = $employee ? $employee->name . ' (' . $employee->nik . ')' : $newValue;
                                                    }
                                                }
                                                
                                                // Format untuk user relation
                                                if (in_array($field, ['created_by', 'updated_by'])) {
                                                    if (is_numeric($oldValue)) {
                                                        $oldValue = $allUsers[$oldValue]?->name ?? $oldValue;
                                                    }
                                                    if (is_numeric($newValue)) {
                                                        $newValue = $allUsers[$newValue]?->name ?? $newValue;
                                                    }
                                                }
                                                
                                                // PERBAIKAN: Pastikan nilai bisa dicetak (bukan array)
                                                if (is_array($oldValue)) {
                                                    $oldValue = json_encode($oldValue);
                                                }
                                                if (is_array($newValue)) {
                                                    $newValue = json_encode($newValue);
                                                }
                                                
                                                $displayOld = !empty($oldValue) && $oldValue !== null ? $oldValue : '-';
                                                $displayNew = !empty($newValue) && $newValue !== null ? $newValue : '-';
                                            @endphp

                                            <div class="text-sm flex items-center gap-2 flex-wrap">
                                                <span class="font-semibold min-w-[100px]">{{ $fieldName }}:</span>
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    @if($activity->event == 'created')
                                                        <span class="px-2 py-0.5 rounded-full text-white font-bold bg-green-600 text-xs">
                                                            {{ $displayNew }}
                                                        </span>
                                                    @elseif($activity->event == 'deleted')
                                                        <span class="px-2 py-0.5 rounded-full text-white font-bold bg-red-600 text-xs">
                                                            {{ $displayOld }}
                                                        </span>
                                                    @else
                                                        <span class="px-2 py-0.5 rounded-full text-white font-bold bg-red-600 line-through text-xs">
                                                            {{ $displayOld }}
                                                        </span>
                                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                        </svg>
                                                        <span class="px-2 py-0.5 rounded-full text-white font-bold bg-green-600 text-xs">
                                                            {{ $displayNew }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        @if($lastPage > 1)
                        <div class="flex justify-between items-center mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                Showing {{ $activitiesData->firstItem() }} to {{ $activitiesData->lastItem() }} of {{ $totalRecords }} records
                            </div>
                            <div class="flex gap-2">
                                <flux:button wire:click="setActivityPage({{ $activityPage - 1 }})" size="sm" variant="outline" :disabled="$activityPage <= 1" class="!px-3">Previous</flux:button>
                                @for($i = 1; $i <= $lastPage; $i++)
                                    @if($i == $activityPage)
                                        <flux:button size="sm" variant="primary" class="!px-3">{{ $i }}</flux:button>
                                    @elseif($i == 1 || $i == $lastPage || ($i >= $activityPage - 1 && $i <= $activityPage + 1))
                                        <flux:button wire:click="setActivityPage({{ $i }})" size="sm" variant="outline" class="!px-3">{{ $i }}</flux:button>
                                    @elseif($i == $activityPage - 2 || $i == $activityPage + 2)
                                        <span class="px-2 py-1 text-sm text-zinc-500 dark:text-zinc-400">...</span>
                                    @endif
                                @endfor
                                <flux:button wire:click="setActivityPage({{ $activityPage + 1 }})" size="sm" variant="outline" :disabled="$activityPage >= $lastPage" class="!px-3">Next</flux:button>
                            </div>
                        </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="mt-4 text-sm text-zinc-500 dark:text-zinc-400">No activity logs found for this stencil</p>
                    </div>
                @endif
            </div>
            @endif
        </div>
    </flux:modal>

    <!-- MODAL DELETE STENCIL -->
    <div x-data="{ open: false, stencilId: null }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'delete-stencil-modal') { open = true; stencilId = $event.detail.id }"
         @close-modal.window="if ($event.detail === 'delete-stencil-modal') open = false"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold mb-2">Delete Stencil</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Are you sure you want to delete this stencil? This action cannot be undone.
                </p>
                <div class="flex justify-center gap-3">
                    <button @click="open = false" class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800">
                        Cancel
                    </button>
                    <button wire:click="deleteStencil" @click="open = false" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
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
</section>