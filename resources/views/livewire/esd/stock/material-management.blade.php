<section class="w-full">
    @include('partials.esd-heading')

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge - Stock Material Management') }}
    </flux:heading>

    <x-esd.layout 
        class="!max-w-full !px-0 !mx-0"
    >
        <x-slot name="heading">
            <div class="w-full">
                <flux:breadcrumbs class="mb-1">
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
                        Dashboard
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        Maintenance
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        ESD
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        Material
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                            Material Management
                        </h1>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            Manage material materials, spare parts, and consumables
                        </p>
                    </div>
                </div>
            </div>
        </x-slot>
        
        <div class="-mt-2">
            <!-- Header with buttons aligned -->
            <div x-data="{ showFilters: false }">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-1 mb-4">
                    <div class="flex-1">
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
                        </button>
                    </div>
                    
                    @can('create material')
                    <flux:button 
                        variant="primary" 
                        icon="plus" 
                        class="bg-blue-600 hover:bg-blue-700 whitespace-nowrap"
                        wire:click="resetForm"
                        x-on:click="$dispatch('open-modal', 'material-form-modal')"
                    >
                        Add New Material
                    </flux:button>
                    @endcan
                </div>

                <!-- Filters Section -->
                <div x-show="showFilters" 
                    x-transition.duration.300ms
                    x-cloak
                    class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-700 mb-4">
                    
                    <!-- Filter Header -->
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Filters</h3>
                        </div>
                    </div>
                    
                    <!-- Filter Body -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            <!-- Search -->
                            <div class="lg:col-span-2">
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Search</label>
                                <div class="relative">
                                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <input type="text" 
                                        wire:model.live.debounce.300ms="search" 
                                        placeholder="Search by SAP Code, Description, Type..." 
                                        class="w-full pl-10 pr-4 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                                </div>
                            </div>

                            <!-- Type -->
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Type</label>
                                <select wire:model.live="filterType" 
                                        class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                                    <option value="">All Types</option>
                                    <option value="Spare Part">Spare Part</option>
                                    <option value="Indirect Material">Indirect Material</option>
                                    <option value="Office Supply">Office Supply</option>
                                </select>
                            </div>

                            <!-- Consumable -->
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Consumable</label>
                                <select wire:model.live="filterConsumable" 
                                        class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                                    <option value="">All</option>
                                    <option value="Weekly">Weekly</option>
                                    <option value="Monthly">Monthly</option>
                                    <option value="By PR">By PR</option>
                                </select>
                            </div>

                            <!-- PIC -->
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">PIC</label>
                                <select wire:model.live="filterPic" 
                                        class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                                    <option value="">All PIC</option>
                                    <option value="ESD">ESD</option>
                                    <option value="Utility">Utility</option>
                                </select>
                            </div>
                        </div>

                        <!-- Low Stock Toggle & Clear Button Row -->
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                            <!-- Low Stock Toggle -->
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Show Low Stock Only</span>
                                <flux:switch wire:model.live="filterLowStock" />
                                @if($filterLowStock)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        Active
                                    </span>
                                @endif
                            </div>

                            <!-- Clear Filters Button -->
                            @if($filterType || $filterConsumable || $filterPic || $filterLowStock || $search)
                            <button wire:click="resetFilters" 
                                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Clear All Filters
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Materials Table -->
            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-16">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">SAP Code</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[200px]">Description</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Consumable</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">PIC</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Qty First</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-20">In</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-20">Out</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Last Stock</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Min Stock</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Unit</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Information</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">Assign Request</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Qty Request</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Remarks</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-32">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($materials as $index => $material)
                            @php
                                $isLowStock = $material->last_stock <= $material->minimum_stock;
                                $stockColor = $isLowStock ? 'text-red-600 dark:text-red-400 font-bold' : 'text-green-600 dark:text-green-400';
                                
                                $typeColor = match($material->type) {
                                    'Spare Part' => 'info',
                                    'Indirect Material' => 'warning',
                                    'Office Supply' => 'success',
                                    default => 'gray',
                                };
                                
                                $consumableColor = match($material->consumable) {
                                    'Weekly' => 'info',
                                    'Monthly' => 'warning',
                                    'By PR' => 'success',
                                    default => 'gray',
                                };
                            @endphp
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors {{ $isLowStock ? 'bg-red-50 dark:bg-red-950/20' : '' }}" wire:key="material-{{ $material->id }}">
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $materials->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-medium shadow-lg flex-shrink-0 text-xs">
                                            {{ strtoupper(substr($material->sap_code ?? '', 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-semibold text-zinc-800 dark:text-white font-mono">
                                            {{ $material->sap_code }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    <div class="max-w-[250px] truncate" title="{{ $material->description }}">
                                        {{ $material->description }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $typeColor }}-100 text-{{ $typeColor }}-800 dark:bg-{{ $typeColor }}-900/30 dark:text-{{ $typeColor }}-400">
                                        {{ $material->type }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $consumableColor }}-100 text-{{ $consumableColor }}-800 dark:bg-{{ $consumableColor }}-900/30 dark:text-{{ $consumableColor }}-400">
                                        {{ $material->consumable }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-1">
                                        @if($material->pic)
                                            @foreach($material->pic as $pic)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300">
                                                    {{ $pic }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-sm text-zinc-500">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ number_format($material->qty_first) }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                        +{{ number_format($material->in) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        -{{ number_format($material->out) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm font-mono {{ $stockColor }}">
                                        {{ number_format($material->last_stock) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ number_format($material->minimum_stock) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $material->unit }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    <div class="max-w-[200px] truncate" title="{{ $material->information }}">
                                        {{ $material->information }}
                                    </div>
                                </td>
                                <!-- Assign Request Column (Inline Select) -->
                                <td class="px-4 py-3" wire:key="assign-{{ $material->id }}">
                                    @if($editingId === $material->id && $editingField === 'assign_request')
                                        <select 
                                            wire:model.live="editingValue"
                                            wire:keydown.enter="updateAssignRequest({{ $material->id }}, editingValue)"
                                            wire:blur="updateAssignRequest({{ $material->id }}, editingValue)"
                                            class="w-full px-2 py-1 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700"
                                            autofocus>
                                            <option value="Request">Request</option>
                                            <option value="Not Request">Not Request</option>
                                        </select>
                                    @else
                                        <div 
                                            class="cursor-pointer inline-flex items-center px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-zinc-800 transition-colors"
                                            wire:click="startEditing({{ $material->id }}, 'assign_request', '{{ $material->assign_request }}')"
                                            title="Click to edit">
                                            @if($material->assign_request == 'Request')
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    Request
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Not Request
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </td>

                                <!-- Qty Request Column (Inline Input) -->
                                <td class="px-4 py-3" wire:key="qty-{{ $material->id }}">
                                    @if($editingId === $material->id && $editingField === 'qty_request')
                                        <input 
                                            type="number" 
                                            wire:model.live="editingValue"
                                            wire:keydown.enter="updateQtyRequest({{ $material->id }}, editingValue)"
                                            wire:blur="updateQtyRequest({{ $material->id }}, editingValue)"
                                            class="w-24 px-2 py-1 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700"
                                            autofocus>
                                    @else
                                        <div 
                                            class="cursor-pointer px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-zinc-800 transition-colors inline-block"
                                            wire:click="startEditing({{ $material->id }}, 'qty_request', '{{ $material->qty_request }}')"
                                            title="Click to edit">
                                            @if($material->qty_request)
                                                <span class="text-sm font-mono text-blue-600 dark:text-blue-400">
                                                    {{ number_format($material->qty_request) }}
                                                </span>
                                            @else
                                                <span class="text-sm text-gray-400 dark:text-gray-500 italic">-</span>
                                            @endif
                                        </div>
                                    @endif
                                </td>

                                <!-- Remarks Column (Inline Input) -->
                                <td class="px-4 py-3" wire:key="remarks-{{ $material->id }}">
                                    @if($editingId === $material->id && $editingField === 'remarks')
                                        <input 
                                            type="text" 
                                            wire:model.live="editingValue"
                                            wire:keydown.enter="updateRemarks({{ $material->id }}, editingValue)"
                                            wire:blur="updateRemarks({{ $material->id }}, editingValue)"
                                            class="w-full max-w-[250px] px-2 py-1 text-sm border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700"
                                            placeholder="Enter remarks..."
                                            autofocus>
                                    @else
                                        <div 
                                            class="cursor-pointer px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-zinc-800 transition-colors"
                                            wire:click="startEditing({{ $material->id }}, 'remarks', '{{ addslashes($material->remarks) }}')"
                                            title="Click to edit">
                                            <div class="max-w-[200px] truncate text-sm text-zinc-700 dark:text-zinc-300">
                                                @if($material->remarks)
                                                    {{ $material->remarks }}
                                                @else
                                                    <span class="text-gray-400 dark:text-gray-500 italic">-</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                        <flux:button 
                                            wire:click="viewTransactions({{ $material->id }})" 
                                            x-on:click="$dispatch('open-modal', 'transaction-history-modal')"
                                            size="sm"
                                            icon="shopping-cart"
                                            variant="primary"
                                            color="green"
                                            class="!p-2 flex-shrink-0"
                                            title="View transaction history"
                                        />
                                        
                                        @can('edit material')
                                        <flux:button 
                                            wire:click="edit({{ $material->id }})" 
                                            x-on:click="$dispatch('open-modal', 'material-form-modal')"
                                            size="sm"
                                            icon="pencil-square"
                                            variant="primary"
                                            color="yellow"
                                            class="!p-2 flex-shrink-0"
                                            title="Edit material"
                                        />
                                        @endcan

                                        @can('delete material')
                                        <flux:button 
                                            wire:click="confirmDelete({{ $material->id }})" 
                                            x-on:click="$dispatch('open-modal', 'delete-material-modal')"
                                            size="sm"
                                            icon="trash"
                                            variant="primary"
                                            color="red"
                                            class="!p-2 flex-shrink-0"
                                            title="Delete material"
                                        />
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="14" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <flux:icon name="cube" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No materials found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                                {{ $search || $filterType || $filterConsumable || $filterPic || $filterLowStock ? 'Try adjusting your filters' : 'Get started by adding a new material' }}
                                            </p>
                                        </div>
                                        @if($search || $filterType || $filterConsumable || $filterPic || $filterLowStock)
                                            <flux:button wire:click="resetFilters" size="sm">
                                                Clear Filters
                                            </flux:button>
                                        @else
                                            @can('create material')
                                            <flux:button 
                                                variant="primary" 
                                                size="sm"
                                                wire:click="resetForm"
                                                x-on:click="$dispatch('open-modal', 'material-form-modal')"
                                            >
                                                Add Your First Material
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

                @if($materials->hasPages())
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $materials->links() }}
                </div>
                @endif
            </flux:card>

            <!-- MODAL FORM MATERIAL -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-modal.window="if ($event.detail === 'material-form-modal') open = true"
                 @close-modal.window="if ($event.detail === 'material-form-modal') open = false"
                 x-cloak>
                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>
                            <form wire:submit="save">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- SAP Code -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1">SAP Code <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model="sap_code" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500" placeholder="e.g., MAT-001">
                                        @error('sap_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Unit -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Unit <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model="unit" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500" placeholder="e.g., PCS, ROLL, BOX">
                                        @error('unit') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium mb-1">Description <span class="text-red-500">*</span></label>
                                        <textarea wire:model="description" rows="2" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500" placeholder="Material description..."></textarea>
                                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Type -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Type <span class="text-red-500">*</span></label>
                                        <select wire:model="type" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                                            <option value="">Select Type</option>
                                            <option value="Spare Part">Spare Part</option>
                                            <option value="Indirect Material">Indirect Material</option>
                                            <option value="Office Supply">Office Supply</option>
                                        </select>
                                        @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Consumable -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Consumable <span class="text-red-500">*</span></label>
                                        <select wire:model="consumable" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                                            <option value="Weekly">Weekly</option>
                                            <option value="Monthly">Monthly</option>
                                            <option value="By PR">By PR</option>
                                        </select>
                                        @error('consumable') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Quantity First -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Quantity First <span class="text-red-500">*</span></label>
                                        <input type="number" wire:model.live="qty_first" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                                        @error('qty_first') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Minimum Stock -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Minimum Stock <span class="text-red-500">*</span></label>
                                        <input type="number" wire:model="minimum_stock" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                                        @error('minimum_stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Information -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium mb-1">Information <span class="text-red-500">*</span></label>
                                        <textarea wire:model="information" rows="2" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500" placeholder="Additional information..."></textarea>
                                        @error('information') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Assign Request -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Assign Request</label>
                                        <select wire:model="assign_request" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                                            <option value="Not Request">Not Request</option>
                                            <option value="Request">Request</option>
                                        </select>
                                        @error('assign_request') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Qty Request -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Qty Request</label>
                                        <input type="number" wire:model="qty_request" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                                        @error('qty_request') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Remarks -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium mb-1">Remarks</label>
                                        <textarea wire:model="remarks" rows="2" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500" placeholder="Any remarks..."></textarea>
                                        @error('remarks') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- PIC (Multiple Select) -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium mb-1">PIC (Person In Charge)</label>
                                        <div class="flex gap-4">
                                            @foreach($picOptions as $value => $label)
                                            <label class="inline-flex items-center gap-2">
                                                <input type="checkbox" wire:model="pic" value="{{ $value }}" class="w-4 h-4 text-blue-600 border-zinc-300 rounded focus:ring-blue-500">
                                                <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                        @error('pic') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Hidden fields for in/out/last_stock -->
                                    <input type="hidden" wire:model="in">
                                    <input type="hidden" wire:model="out">
                                    <input type="hidden" wire:model="last_stock">
                                </div>

                                <div class="flex justify-end gap-2 mt-6">
                                    <button type="button" @click="open = false" class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        {{ $material_id ? 'Update' : 'Create' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL DETAIL MATERIAL -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-modal.window="if ($event.detail === 'detail-material-modal') open = true"
                 @close-modal.window="if ($event.detail === 'detail-material-modal') open = false"
                 x-cloak>
                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-4">Material Details</h2>
                            @if($selectedMaterial)
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div><label class="text-sm font-medium text-zinc-500">SAP Code:</label><p class="mt-1 font-mono">{{ $selectedMaterial->sap_code }}</p></div>
                                    <div><label class="text-sm font-medium text-zinc-500">Unit:</label><p class="mt-1">{{ $selectedMaterial->unit }}</p></div>
                                    <div class="col-span-2"><label class="text-sm font-medium text-zinc-500">Description:</label><p class="mt-1">{{ $selectedMaterial->description }}</p></div>
                                    <div><label class="text-sm font-medium text-zinc-500">Type:</label><p class="mt-1">{{ $selectedMaterial->type }}</p></div>
                                    <div><label class="text-sm font-medium text-zinc-500">Consumable:</label><p class="mt-1">{{ $selectedMaterial->consumable }}</p></div>
                                    <div><label class="text-sm font-medium text-zinc-500">Quantity First:</label><p class="mt-1">{{ number_format($selectedMaterial->qty_first) }}</p></div>
                                    <div><label class="text-sm font-medium text-zinc-500">In:</label><p class="mt-1 text-blue-600">+{{ number_format($selectedMaterial->in) }}</p></div>
                                    <div><label class="text-sm font-medium text-zinc-500">Out:</label><p class="mt-1 text-red-600">-{{ number_format($selectedMaterial->out) }}</p></div>
                                    <div><label class="text-sm font-medium text-zinc-500">Last Stock:</label><p class="mt-1 font-bold">{{ number_format($selectedMaterial->last_stock) }}</p></div>
                                    <div><label class="text-sm font-medium text-zinc-500">Minimum Stock:</label><p class="mt-1">{{ number_format($selectedMaterial->minimum_stock) }}</p></div>
                                    <div class="col-span-2"><label class="text-sm font-medium text-zinc-500">Information:</label><p class="mt-1">{{ $selectedMaterial->information }}</p></div>
                                    <div><label class="text-sm font-medium text-zinc-500">Assign Request:</label><p class="mt-1">{{ $selectedMaterial->assign_request ?? '-' }}</p></div>
                                    <div><label class="text-sm font-medium text-zinc-500">Qty Request:</label><p class="mt-1">{{ $selectedMaterial->qty_request ?? '-' }}</p></div>
                                    <div class="col-span-2"><label class="text-sm font-medium text-zinc-500">Remarks:</label><p class="mt-1">{{ $selectedMaterial->remarks ?? '-' }}</p></div>
                                    <div><label class="text-sm font-medium text-zinc-500">PIC:</label><p class="mt-1">{{ implode(', ', $selectedMaterial->pic ?? []) }}</p></div>
                                    <div><label class="text-sm font-medium text-zinc-500">Created By:</label><p class="mt-1">{{ $selectedMaterial->creator->name ?? 'N/A' }}</p></div>
                                    <div><label class="text-sm font-medium text-zinc-500">Created At:</label><p class="mt-1">{{ $selectedMaterial->created_at ? $selectedMaterial->created_at->format('d M Y H:i') : '-' }}</p></div>
                                </div>
                            </div>
                            @endif
                            <div class="flex justify-end mt-6">
                                <button @click="open = false" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL DELETE -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-modal.window="if ($event.detail === 'delete-material-modal') open = true"
                 @close-modal.window="if ($event.detail === 'delete-material-modal') open = false"
                 x-cloak>
                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold mb-2">Delete Material</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Are you sure you want to delete material "{{ $detailToDelete?->sap_code ?? 'this material' }}"? This action cannot be undone.
                        </p>
                        <div class="flex justify-center gap-3">
                            <button @click="open = false" class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800">Cancel</button>
                            <button wire:click="delete" @click="open = false" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Yes, Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL TRANSACTION HISTORY -->
            <flux:modal wire:model="showTransactionModal" class="w-full max-w-6xl">
                <div class="flex flex-col" style="height: auto; max-height: 85vh; overflow: hidden;">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex-shrink-0">
                        <div>
                            <h2 class="text-xl font-bold text-zinc-800 dark:text-white">
                                Transaction History
                            </h2>
                            @if($selectedMaterialForTransactions)
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                {{ $selectedMaterialForTransactions->sap_code }} - {{ $selectedMaterialForTransactions->description }}
                            </p>
                            @endif
                        </div>
                    </div>

                    @if($selectedMaterialForTransactions)
                    @php
                        $allTransactions = $selectedMaterialForTransactions->transactions->sortByDesc('created_at');
                        $totalRecords = $allTransactions->count();
                        $lastPage = ceil($totalRecords / $perPageTransactions);
                        $transactions = $allTransactions->slice(($transactionPage - 1) * $perPageTransactions, $perPageTransactions);
                    @endphp
                    
                    <!-- Content with scroll -->
                    <div class="flex-1 overflow-y-auto p-6">
                        @if($totalRecords > 0)
                        <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-16">#</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Date</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Type</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Quantity</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">PIC</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[250px]">Description</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">Created By</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                        @foreach($transactions as $index => $transaction)
                                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                            <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                                                {{ (($transactionPage - 1) * $perPageTransactions) + $index + 1 }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                                {{ $transaction->date ? \Carbon\Carbon::parse($transaction->date)->format('d M Y') : '-' }}
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($transaction->type === 'in')
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                        IN
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                        OUT
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="text-sm font-mono font-bold {{ $transaction->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $transaction->type === 'in' ? '+' : '-' }}{{ number_format($transaction->qty) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                                {{ $transaction->pic ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                                <div class="max-w-[300px]" title="{{ $transaction->keterangan ?? '-' }}">
                                                    {{ $transaction->keterangan ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                                {{ $transaction->creator->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                                {{ $transaction->created_at ? $transaction->created_at->format('d M Y H:i') : '-' }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($lastPage > 1)
                            <div class="flex justify-between items-center px-4 py-3 border-t border-zinc-200 dark:border-zinc-700">
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                    Showing {{ ($transactionPage - 1) * $perPageTransactions + 1 }} to {{ min($transactionPage * $perPageTransactions, $totalRecords) }} of {{ number_format($totalRecords) }} records
                                </div>
                                <div class="flex gap-2">
                                    <flux:button 
                                        wire:click="setTransactionPage({{ $transactionPage - 1 }})"
                                        size="sm"
                                        variant="outline"
                                        :disabled="$transactionPage <= 1"
                                        class="!px-3"
                                    >
                                        Previous
                                    </flux:button>
                                    
                                    @for($i = 1; $i <= $lastPage; $i++)
                                        @if($i == $transactionPage)
                                            <flux:button size="sm" variant="primary" class="!px-3">{{ $i }}</flux:button>
                                        @elseif($i == 1 || $i == $lastPage || ($i >= $transactionPage - 1 && $i <= $transactionPage + 1))
                                            <flux:button wire:click="setTransactionPage({{ $i }})" size="sm" variant="outline" class="!px-3">{{ $i }}</flux:button>
                                        @elseif($i == $transactionPage - 2 || $i == $transactionPage + 2)
                                            <span class="px-2 py-1 text-sm text-zinc-500 dark:text-zinc-400">...</span>
                                        @endif
                                    @endfor
                                    
                                    <flux:button 
                                        wire:click="setTransactionPage({{ $transactionPage + 1 }})"
                                        size="sm"
                                        variant="outline"
                                        :disabled="$transactionPage >= $lastPage"
                                        class="!px-3"
                                    >
                                        Next
                                    </flux:button>
                                </div>
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="text-center py-12 bg-zinc-50 dark:bg-zinc-800/30 rounded-lg">
                            <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p class="mt-4 text-sm text-zinc-500 dark:text-zinc-400">No transaction records found for this material</p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </flux:modal>

            <!-- Notifikasi -->
            <div x-data="{ show: false, message: '', type: 'success' }" 
                 x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 5000)"
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

                .cursor-pointer:hover {
                    background-color: rgba(59, 130, 246, 0.1);
                }
            </style>
        </div>
    </x-esd.layout>
</section>