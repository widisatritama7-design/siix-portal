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
            Master Customer
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Master Customer
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage customer master data
            </p>
        </div>

        @can('create customer')
            <flux:button 
                variant="primary" 
                icon="plus" 
                class="bg-blue-600 hover:bg-blue-700"
                wire:click="resetForm"
                x-on:click="$dispatch('open-modal-customer')"
            >
                Add New Customer
            </flux:button>
        @endcan
    </div>

    <!-- Search -->
    <div class="flex justify-end">
        <div class="w-full sm:w-80">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search customer name..."
                icon="magnifying-glass"
                clearable
            />
        </div>
    </div>

    <!-- ==================== TABLE ==================== -->
    <flux:card class="p-0 shadow-lg flex flex-col overflow-hidden">

        {{-- ===== HEADER ===== --}}
        <div class="relative px-6 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-white/10"></div>
            <div class="absolute -right-2 -bottom-8 w-16 h-16 rounded-full bg-white/10"></div>

            <div class="relative flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-[10px] text-white/70 uppercase tracking-wider font-semibold">Management</div>
                        <div class="text-base font-bold text-white leading-tight">Customer List</div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    @if($search)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                            </svg>
                            {{ $search }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                            All Customers
                        </span>
                    @endif

                    <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                            <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clip-rule="evenodd" />
                        </svg>
                        {{ $customers->total() }} total
                    </span>
                </div>
            </div>
        </div>

        {{-- ===== BODY ===== --}}
        <div class="p-6 flex flex-col flex-1">
            <div class="overflow-x-auto flex-1">
                <table class="w-full" style="min-width: 800px; white-space: nowrap;">
                    <thead>
                        <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 50px;">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 250px;">Customer Name</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 150px;">Created By</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 150px;">Date Create</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 150px;">Date Update</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($customers as $index => $customer)
                        @php $isUsed = in_array((int) $customer->id, $usedIds, true); @endphp
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="customer-{{ $customer->id }}">
                            <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 text-center">
                                {{ $customers->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3 text-left">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-semibold {{ $isUsed ? 'text-zinc-500 dark:text-zinc-400' : 'text-zinc-800 dark:text-white' }}">
                                        {{ $customer->customer_name }}
                                    </span>
                                    @if($isUsed)
                                        <flux:badge size="sm" color="amber" title="Sudah dipakai di Model / Question / Blind Test">
                                            Used
                                        </flux:badge>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400 text-center">
                                {{ $customer->creator->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400 text-center">
                                {{ $customer->created_at ? $customer->created_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400 text-center">
                                {{ $customer->updated_at ? $customer->updated_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-1" style="flex-wrap: nowrap;">
                                    @can('view customer')
                                    <flux:tooltip content="View" position="top">
                                        <flux:button 
                                            wire:click="view({{ $customer->id }})" 
                                            size="sm"
                                            icon="eye"
                                            variant="primary"
                                            color="blue"
                                            class="!p-2 flex-shrink-0"
                                        />
                                    </flux:tooltip>
                                    @endcan

                                    @can('edit customer')
                                        @if(!$isUsed)
                                        <flux:tooltip content="Edit" position="top">
                                            <flux:button 
                                                wire:click="edit({{ $customer->id }})" 
                                                size="sm"
                                                icon="pencil-square"
                                                variant="primary"
                                                color="yellow"
                                                class="!p-2 flex-shrink-0"
                                            />
                                        </flux:tooltip>
                                        @endif
                                    @endcan

                                    @can('delete customer')
                                        @if(!$isUsed)
                                        <flux:tooltip content="Delete" position="top">
                                            <flux:button 
                                                wire:click="confirmDelete({{ $customer->id }})" 
                                                size="sm"
                                                icon="trash"
                                                variant="primary"
                                                color="red"
                                                class="!p-2 flex-shrink-0"
                                            />
                                        </flux:tooltip>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center">
                                <div class="flex flex-col items-center justify-center gap-2 py-6">
                                    <div class="w-16 h-16 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                        <flux:icon name="user-group" class="w-8 h-8 text-zinc-400 dark:text-zinc-500" />
                                    </div>
                                    <div>
                                        <h3 class="text-base font-medium text-zinc-900 dark:text-white mb-0.5">
                                            No customer records found
                                        </h3>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                            {{ $search ? 'Try adjusting your search query' : 'Get started by creating a new customer' }}
                                        </p>
                                    </div>
                                    @if($search)
                                        <flux:button wire:click="$set('search', '')" size="sm" class="mt-1">
                                            Clear Search
                                        </flux:button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($customers->hasPages())
            <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $customers->links() }}
            </div>
            @endif
        </div>
    </flux:card>

    <!-- ==================== MODAL FORM ==================== -->
    <div x-data="{ open: false }" 
        x-on:open-modal-customer.window="open = true"
        x-on:close-modal-customer.window="open = false"
        x-show="open"
        x-cloak
        @keydown.escape.window="open = false">

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                    <form wire:submit="save" id="customer-form">
                        <div class="mb-4">
                            <flux:label required>Customer Name</flux:label>
                            <flux:input 
                                wire:model="customer_name" 
                                type="text" 
                                placeholder="Enter customer name"
                                class="uppercase"
                            />
                            @error('customer_name') 
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>
                    </form>
                </div>

                <div class="p-6 pt-0 flex justify-end gap-2">
                    <button type="button" 
                            @click="open = false"
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                        form="customer-form"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                        wire:loading.attr="disabled"
                        wire:target="save">
                        <span wire:loading.remove wire:target="save">{{ $customer_id ? 'Update' : 'Create' }}</span>
                        <span wire:loading wire:target="save">Processing...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL VIEW ==================== -->
    <div x-data="{ open: false }" 
        x-on:open-modal-view.window="open = true"
        x-on:close-modal-view.window="open = false"
        x-show="open"
        x-cloak
        @keydown.escape.window="open = false">

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-lg">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Customer Detail</h2>

                    @if($viewData)
                    <div class="space-y-3">
                        <div>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Customer Name</span>
                            <p class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->customer_name }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Created By</span>
                            <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->creator->name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Created At</span>
                            <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->created_at ? $viewData->created_at->format('d/m/Y H:i') : '-' }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Updated By</span>
                            <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->updater->name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Updated At</span>
                            <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $viewData->updated_at ? $viewData->updated_at->format('d/m/Y H:i') : '-' }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="p-6 pt-0 flex justify-end">
                    <button type="button" 
                            @click="open = false"
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL DELETE ==================== -->
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

                <h3 class="text-lg font-bold mb-2 text-center">Delete Customer</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4 text-center">
                    Are you sure you want to delete customer <span class="font-semibold">{{ $customerToDelete?->customer_name }}</span>?
                </p>

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
        [x-cloak] { display: none !important; }
    </style>
</div>