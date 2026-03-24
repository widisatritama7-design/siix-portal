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
            Employee Call
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Employee Call Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage employee call records
            </p>
        </div>
        <div class="flex gap-2">
            @can('create employee call')
            <flux:button wire:click="openCreateModal" variant="primary" icon="plus">
                Add Call Record
            </flux:button>
            @endcan
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
                <span x-show="{{ $search || $categoryFilter || $dateFrom || $dateUntil }}" 
                    class="ml-1 px-1.5 py-0.5 text-xs bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-300">
                    Active
                </span>
            </button>
            
            @if($search || $categoryFilter || $dateFrom || $dateUntil)
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
                        placeholder="Search by NIK, name, category..."
                        class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white"
                    >
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Category</label>
                    <select wire:model.live="categoryFilter" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        <option value="">All Categories</option>
                        <option value="Violation">Violation</option>
                        <option value="Comelate">Comelate</option>
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
            </div>
        </div>
    </div>

    <!-- Calls Table -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-16">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NIK</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Date Call</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Created By</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($calls as $index => $call)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="call-{{ $call->id }}">
                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                            {{ $calls->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="font-mono text-sm text-zinc-700 dark:text-zinc-300">
                                {{ $call->employee->nik ?? $call->nik }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="text-sm font-semibold text-zinc-800 dark:text-white">
                                {{ $call->employee->name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($call->category == 'Violation')
                                <span class="inline-block px-3 py-1 text-sm font-medium text-white bg-red-600 rounded-full cursor-default">Violation</span>
                            @elseif($call->category == 'Comelate')
                                <span class="inline-block px-3 py-1 text-sm font-medium text-black bg-yellow-400 rounded-full cursor-default">Comelate</span>
                            @else
                                <span class="inline-block px-3 py-1 text-sm font-medium text-gray-800 bg-gray-200 rounded-full cursor-default">{{ $call->category }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($call->date_call)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                            {{ $call->creator->name ?? '-' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-1">
                                @can('edit employee call')
                                <flux:button 
                                    wire:click="openEditModal({{ $call->id }})" 
                                    size="sm" 
                                    variant="outline"
                                    icon="pencil-square"
                                    class="!p-1.5"
                                    title="Edit record"
                                />
                                @endcan
                                @can('delete employee call')
                                <flux:button 
                                    wire:click="openDeleteModal({{ $call->id }})" 
                                    size="sm" 
                                    variant="outline"
                                    icon="trash"
                                    class="!p-1.5"
                                    title="Delete record"
                                />
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <flux:icon name="phone" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        No call records found
                                    </h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                        {{ $search ? 'Try adjusting your search query' : 'No employee call data available' }}
                                    </p>
                                </div>
                                @if($search)
                                    <flux:button wire:click="$set('search', '')" size="sm">
                                        Clear Search
                                    </flux:button>
                                @else
                                    <flux:button wire:click="openCreateModal" variant="primary" size="sm">
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
        @if($calls->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $calls->links() }}
        </div>
        @endif
    </flux:card>

    <!-- Create Modal -->
    <flux:modal wire:model="showCreateModal" class="w-full max-w-2xl">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-zinc-800 dark:text-white">
                    Employee Call Registration
                </h2>
            </div>

            <div class="text-sm text-blue-600 dark:text-blue-400 font-bold mb-4">
                Form pencatatan panggilan karyawan
            </div>

            <form wire:submit.prevent="save">
                <div class="space-y-4">
                    <!-- Date Call -->
                    <div>
                        <flux:label required>Date Call</flux:label>
                        <flux:input 
                            type="date" 
                            wire:model.live="date_call" 
                            class="w-full"
                            icon="calendar"
                        />
                        @error('date_call') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-zinc-500 mt-1">Pilih tanggal pelaksanaan panggilan</p>
                    </div>

                    <!-- Select Employee with Search -->
                    <div x-data="{ show: false, search: '' }" class="relative">
                        <flux:label required>Employee</flux:label>
                        
                        <input 
                            type="text"
                            x-model="search"
                            @focus="show = true"
                            @keyup="show = true"
                            placeholder="Search by NIK or name..."
                            class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white"
                        >
                        
                        <div x-show="show" 
                            x-transition
                            @click.away="show = false"
                            class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded-lg shadow-lg max-h-60 overflow-y-auto"
                            style="display: none;">
                            
                            @foreach($employees as $id => $label)
                                <div 
                                    x-show="search === '' || '{{ $label }}'.toLowerCase().includes(search.toLowerCase()) || '{{ $id }}'.includes(search)"
                                    @click="$wire.set('nik', '{{ $id }}'); show = false; search = '{{ $label }}'"
                                    class="px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700 cursor-pointer"
                                >
                                    <span class="text-sm">{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>
                        
                        <input type="hidden" wire:model="nik">
                        
                        @if(!$date_call)
                            <p class="text-xs text-yellow-600 mt-1">Silahkan pilih tanggal terlebih dahulu</p>
                        @endif
                        @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-zinc-500 mt-1">Pilih karyawan yang akan dipanggil</p>
                    </div>

                    <!-- Category -->
                    <div>
                        <flux:label required>Category</flux:label>
                        <flux:select wire:model.live="category" class="w-full" icon="flag">
                            <flux:select.option value="">Pilih kategori panggilan</flux:select.option>
                            @foreach($this->categoryOptions as $key => $value)
                                <flux:select.option value="{{ $key }}">{{ $value }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-zinc-500 mt-1">Pilih jenis panggilan yang akan dilakukan</p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <flux:button wire:click="$set('showCreateModal', false)" variant="outline">
                        Cancel
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Save Record
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Edit Modal -->
    <flux:modal wire:model="showEditModal" class="w-full max-w-2xl">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-zinc-800 dark:text-white">
                    Edit Employee Call Record
                </h2>
            </div>

            <form wire:submit.prevent="update">
                <div class="space-y-4">
                    <!-- Date Call -->
                    <div>
                        <flux:label required>Date Call</flux:label>
                        <flux:input type="date" wire:model="date_call" class="w-full" icon="calendar" />
                        @error('date_call') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Employee Info (disabled on edit) -->
                    <div>
                        <flux:label required>Employee</flux:label>
                        <flux:input value="{{ $employeeNik }} - {{ $employeeName }}" disabled class="w-full bg-zinc-50 dark:bg-zinc-800/50" icon="user" />
                        <input type="hidden" wire:model="nik">
                    </div>

                    <!-- Category -->
                    <div>
                        <flux:label required>Category</flux:label>
                        <flux:select wire:model="category" class="w-full" icon="flag">
                            <flux:select.option value="">Pilih kategori panggilan</flux:select.option>
                            @foreach($this->categoryOptions as $key => $value)
                                <flux:select.option value="{{ $key }}">{{ $value }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <flux:button wire:click="$set('showEditModal', false)" variant="outline">
                        Cancel
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Update Record
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Delete Confirmation Modal -->
    <flux:modal wire:model="showDeleteModal" class="w-full max-w-md">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-zinc-800 dark:text-white">
                    Delete Record
                </h2>
                <flux:button 
                    wire:click="$set('showDeleteModal', false)" 
                    icon="x-mark" 
                    variant="ghost" 
                    size="sm"
                    class="!p-1"
                />
            </div>

            <div class="text-center">
                <div class="mx-auto w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-2">
                    Delete Call Record
                </h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                    Are you sure you want to delete this record for <span class="font-semibold">{{ $deleteName }}</span>? This action cannot be undone.
                </p>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                <flux:button wire:click="$set('showDeleteModal', false)" variant="outline">
                    Cancel
                </flux:button>
                <flux:button wire:click="delete" variant="danger">
                    Delete
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>