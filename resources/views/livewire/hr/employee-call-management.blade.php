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
            <!-- Download Template -->
            <div class="relative" x-data="{ open: false }">
                <flux:button @click="open = !open" variant="outline" icon="document-arrow-down">
                    Download Template
                </flux:button>
                <div x-show="open" @click.away="open = false" 
                    x-transition
                    class="absolute right-0 mt-2 w-48 bg-white dark:bg-zinc-800 rounded-lg shadow-lg border border-zinc-200 dark:border-zinc-700 z-10">
                    <a href="{{ route('employee-call.download-template-csv') }}" 
                        class="block px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-t-lg">
                        <flux:icon.document class="inline w-4 h-4 mr-2" />
                        CSV
                    </a>
                </div>
            </div>
            
            <flux:button wire:click="openImportModal" variant="outline" icon="arrow-up-tray">
                Import Excel
            </flux:button>
            <flux:button wire:click="openCreateModal" variant="primary" icon="plus">
                Add Call Record
            </flux:button>
            @endcan
        </div>
    </div>

    <!-- Filters Section -->
    <div x-data="{ showFilters: false }">
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
        
        <div x-show="showFilters" 
            x-transition.duration.300ms
            x-cloak
            class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6 mb-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Search</label>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search by NIK, name, category..."
                        class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Category</label>
                    <select wire:model.live="categoryFilter" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        <option value="">All Categories</option>
                        <option value="Violation">Violation</option>
                        <option value="Comelate">Comelate</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date From</label>
                    <input type="date" wire:model.live="dateFrom" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                </div>

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
                    <div>
                        <flux:label required>Date Call</flux:label>
                        <flux:input type="date" wire:model.live="date_call" class="w-full" icon="calendar"/>
                        @error('date_call') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ show: false, search: '' }" class="relative">
                        <flux:label required>Employee</flux:label>
                        
                        <input type="text"
                            x-model="search"
                            @focus="show = true"
                            @keyup="show = true"
                            placeholder="Search by NIK or name..."
                            class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white"
                        >
                        
                        <div x-show="show" x-transition @click.away="show = false"
                            class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded-lg shadow-lg max-h-60 overflow-y-auto"
                            style="display: none;">
                            @foreach($employees as $id => $label)
                                <div x-show="search === '' || '{{ $label }}'.toLowerCase().includes(search.toLowerCase())"
                                    @click="$wire.set('nik', '{{ $id }}'); show = false; search = '{{ $label }}'"
                                    class="px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700 cursor-pointer">
                                    <span class="text-sm">{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>
                        
                        <input type="hidden" wire:model="nik">
                        @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <flux:label required>Category</flux:label>
                        <flux:select wire:model.live="category" class="w-full" icon="flag">
                            <flux:select.option value="">Pilih kategori panggilan</flux:select.option>
                            @foreach($this->categoryOptions as $key => $value)
                                <flux:select.option value="{{ $key }}">{{ $value }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

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
                    <div>
                        <flux:label required>Date Call</flux:label>
                        <flux:input type="date" wire:model="date_call" class="w-full" icon="calendar" />
                        @error('date_call') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <flux:label required>Employee</flux:label>
                        <flux:input value="{{ $employeeNik }} - {{ $employeeName }}" disabled class="w-full bg-zinc-50 dark:bg-zinc-800/50" icon="user" />
                        <input type="hidden" wire:model="nik">
                    </div>

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

    <!-- Delete Modal -->
    <flux:modal wire:model="showDeleteModal" class="w-full max-w-md">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-zinc-800 dark:text-white">
                    Delete Record
                </h2>
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

    <!-- IMPORT MODAL - Version yang sudah diperbaiki -->
    <flux:modal wire:model="showImportModal" class="w-full max-w-3xl">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-zinc-800 dark:text-white">
                    Import Data
                </h2>
            </div>

            @if($importStep == 'upload')
            <!-- Upload Step -->
            <div class="space-y-6">

                <div class="border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-lg p-8 text-center">
                    <input type="file" wire:model="importFile" id="importFile" class="hidden" accept=".xlsx,.xls,.csv">
                    <label for="importFile" class="cursor-pointer">
                        <div class="flex flex-col items-center gap-3">
                            <svg class="w-12 h-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    Click to upload or drag and drop
                                </p>
                                <p class="text-xs text-zinc-500 mt-1">
                                    CSV files only (Max 10MB)
                                </p>
                            </div>
                        </div>
                    </label>
                </div>

                @if($importFileName)
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm text-green-700 dark:text-green-300">File uploaded: {{ $importFileName }}</span>
                        @if($importing)
                            <div class="ml-auto">
                                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-green-600"></div>
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                @if(!empty($importErrors) && !$importing)
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <h3 class="font-semibold text-red-800 dark:text-red-300 mb-2">❌ Errors Found:</h3>
                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        @foreach($importErrors as $error)
                            <div class="text-sm text-red-700 dark:text-red-300 border-b border-red-100 dark:border-red-800 pb-2">
                                <span class="font-mono">Row {{ is_array($error) ? ($error['row'] ?? '-') : '-' }}</span> 
                                - NIK: {{ is_array($error) ? ($error['nik'] ?? '-') : '-' }}
                                <ul class="list-disc list-inside ml-4 mt-1">
                                    @if(is_array($error) && isset($error['errors']))
                                        @foreach($error['errors'] as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            @elseif($importStep == 'preview')
            <!-- Preview Step -->
            <div class="space-y-6">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">
                            Valid records: <strong class="text-green-600">{{ count($importValidData) }}</strong>
                            @if(count($importErrors) > 0)
                                | Invalid records: <strong class="text-red-600">{{ count($importErrors) }}</strong>
                            @endif
                        </span>
                    </div>
                    <div class="flex gap-2">
                        <flux:button wire:click="resetImport" variant="outline" size="sm">
                            Upload New File
                        </flux:button>
                    </div>
                </div>

                @if(count($importValidData) > 0)
                <div class="overflow-x-auto border rounded-lg">
                    <table class="w-full text-sm">
                        <thead class="bg-zinc-50 dark:bg-zinc-800">
                            <tr>
                                <th class="px-4 py-2 text-left">#</th>
                                <th class="px-4 py-2 text-left">NIK</th>
                                <th class="px-4 py-2 text-left">Name</th>
                                <th class="px-4 py-2 text-left">Department</th>
                                <th class="px-4 py-2 text-left">Category</th>
                                <th class="px-4 py-2 text-left">Date Call</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($importValidData as $index => $data)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 font-mono">{{ $data['nik'] ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $data['name'] ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $data['department'] ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    @if(isset($data['category']) && $data['category'] == 'Violation')
                                        <span class="px-2 py-1 text-xs text-white bg-red-600 rounded">Violation</span>
                                    @elseif(isset($data['category']) && $data['category'] == 'Comelate')
                                        <span class="px-2 py-1 text-xs text-black bg-yellow-400 rounded">Comelate</span>
                                    @else
                                        <span class="px-2 py-1 text-xs text-gray-600 bg-gray-200 rounded">{{ $data['category'] ?? '-' }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    @if(isset($data['date_call']))
                                        {{ \Carbon\Carbon::parse($data['date_call'])->format('d M Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span class="text-sm text-yellow-700 dark:text-yellow-300">
                            Please review the data above. Once confirmed, the data will be saved to the database.
                        </span>
                    </div>
                </div>
                @endif

                @if(count($importErrors) > 0)
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <h3 class="font-semibold text-red-800 dark:text-red-300 mb-2">Invalid rows (will be skipped):</h3>
                    <div class="space-y-2 max-h-40 overflow-y-auto">
                        @foreach($importErrors as $error)
                            <div class="text-sm text-red-700 dark:text-red-300">
                                <span class="font-mono">Row {{ is_array($error) ? ($error['row'] ?? '-') : '-' }}</span> 
                                - {{ is_array($error) && isset($error['errors']) ? implode(', ', $error['errors']) : '-' }}
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                @if(count($importValidData) > 0)
                <flux:button wire:click="confirmImport" variant="primary">
                    Confirm Import ({{ count($importValidData) }} records)
                </flux:button>
                @endif
            </div>
            @endif
        </div>
    </flux:modal>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>