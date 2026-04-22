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
            x-on:click="$dispatch('open-modal', 'ncp-form-modal')"
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">File</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Remarks</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Requester</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
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
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-medium shadow-lg">
                                    N
                                </div>
                                <div>
                                    <span class="text-sm font-semibold text-zinc-800 dark:text-white block">
                                        {{ $ncp->ncp_number }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm">
                                <div class="font-medium">{{ $ncp->employee->name ?? 'N/A' }}</div>
                                <div class="text-xs text-zinc-500">{{ $ncp->employee->nik ?? '-' }}</div>
                                <div class="text-xs text-zinc-400">{{ $ncp->employee->department ?? '-' }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                            {{ $ncp->section ?? '-' }}
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
                        <td class="px-4 py-3">
                            @if($ncp->file)
                                <a href="{{ Storage::url($ncp->file) }}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                </a>
                            @else
                                <span class="text-xs text-zinc-400">No file</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400 max-w-xs truncate" title="{{ $ncp->remarks }}">
                            {{ $ncp->remarks ?: '-' }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm">
                                <div>{{ $ncp->creator->name ?? 'N/A' }}</div>
                                <div class="text-xs text-zinc-500">{{ $ncp->created_at->format('d M Y') }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                @can('edit ncp')
                                    @if(!in_array($ncp->status, ['closed', 'rejected']))
                                    <flux:button 
                                        wire:click="edit({{ $ncp->id }})" 
                                        x-on:click="$dispatch('open-modal', 'ncp-form-modal')"
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
                                        x-on:click="$dispatch('open-modal', 'delete-ncp-modal')"
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center justify-center gap-3 min-h-[400px]">
                                <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <flux:icon name="document-text" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        No NCP records found
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
                                    @can('create ncp')
                                    <flux:button 
                                        variant="primary" 
                                        size="sm"
                                        wire:click="resetForm"
                                        x-on:click="$dispatch('open-modal', 'ncp-form-modal')"
                                    >
                                        Add Your First NCP
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
        @if($ncps->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 mt-auto">
            {{ $ncps->links() }}
        </div>
        @endif
    </flux:card>

    <!-- MODAL FORM NCP -->
    <div x-data="{ open: false }" 
        x-show="open" 
        @open-modal.window="if ($event.detail === 'ncp-form-modal') open = true"
        @close-modal.window="if ($event.detail === 'ncp-form-modal') open = false"
        x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-lg max-h-[90vh] flex flex-col">
                <!-- Header Modal (Fixed) -->
                <div class="p-6 pb-0">
                    <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>
                </div>
                
                <!-- Form Content dengan Scroll di dalam -->
                <div class="flex-1 overflow-y-auto p-6 pt-2">
                    <form wire:submit="save" id="ncp-form">
                        <!-- Employee Selection -->
                        <div class="mb-4">
                            <flux:label required>Employee</flux:label>
                            
                            @if(!$employee_id)
                                <!-- Mode Create: Lazy loading search -->
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
                                        class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-800 p-3 text-center text-sm text-zinc-500 rounded-lg shadow-lg">
                                        No employees found
                                    </div>
                                </div>
                            @else
                                <!-- Mode Edit: Employee disabled -->
                                <div class="p-2 bg-zinc-100 dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                    <div class="font-medium text-zinc-800 dark:text-white">{{ $name }}</div>
                                    <div class="text-xs text-zinc-500">{{ $department }}</div>
                                </div>
                                <input type="hidden" wire:model="employee_id">
                            @endif
                            
                            @error('employee_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Section -->
                        <div class="mb-4">
                            <flux:label>Section</flux:label>
                            @if($ncp_id)
                                <input 
                                    type="text" 
                                    wire:model="section" 
                                    disabled
                                    placeholder="Enter section name"
                                    class="w-full px-3 py-2 border border-zinc-300 rounded-lg bg-zinc-100 dark:bg-zinc-800 dark:border-zinc-700 cursor-not-allowed text-zinc-500 dark:text-zinc-400"
                                />
                            @else
                                <flux:input wire:model="section" type="text" placeholder="Enter section name" />
                            @endif
                            @error('section') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Remarks -->
                        <div class="mb-4">
                            <flux:label>Remarks</flux:label>
                            @if($ncp_id)
                                <flux:textarea 
                                    wire:model="remarks" 
                                    rows="3" 
                                    placeholder="Enter remarks (optional)..." 
                                    disabled 
                                    class="bg-zinc-100 dark:bg-zinc-800 cursor-not-allowed"
                                />
                            @else
                                <flux:textarea wire:model="remarks" rows="3" placeholder="Enter remarks (optional)..." />
                            @endif
                            @error('remarks') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Status (Only visible on edit) -->
                        @if($ncp_id)
                        <div class="mb-4">
                            <flux:label>Status</flux:label>
                            <flux:select wire:model="status">
                                @foreach($statuses as $key => $value)
                                    <flux:select.option value="{{ $key }}">{{ $value }}</flux:select.option>
                                @endforeach
                            </flux:select>
                        </div>
                        @endif

                        <!-- File Upload (Only on edit) -->
                        @if($ncp_id)
                        <div class="mb-4">
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
                                </div>
                            @endif
                            
                            @if(!$removeFile)
                                <input type="file" wire:model="newFile" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800">
                                @error('newFile') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            @endif
                        </div>
                        @endif
                    </form>
                </div>
                
                <!-- Footer Buttons (Fixed) -->
                <div class="p-6 pt-0 border-t border-zinc-200 dark:border-zinc-700 mt-2">
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

    <!-- MODAL DELETE -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'delete-ncp-modal') open = true"
         @close-modal.window="if ($event.detail === 'delete-ncp-modal') open = false"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>

                <h3 class="text-lg font-bold mb-2">Delete NCP Record</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Are you sure you want to delete NCP "{{ $ncpToDelete?->ncp_number }}"? This action cannot be undone.
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