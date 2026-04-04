<section class="w-full">
    @include('partials.esd-heading')

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge - Product Qualification') }}
    </flux:heading>

    <x-esd.layout 
        class="!max-w-full !px-0 !mx-0"
    >
        <x-slot name="heading">
            <div class="w-full">
                <!-- Breadcrumbs -->
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
                        Product Qualification
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                    Product Qualification
                </h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    Manage Product Qualification for ESD Check
                </p>
            </div>
        </x-slot>
        
        <div class="-mt-2">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row gap-3 mt-2 mb-6">
                <!-- Search 80% -->
                <div class="w-full sm:w-[80%]">
                    <flux:input
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search by clause or control item..."
                        icon="magnifying-glass"
                        clearable
                    />
                </div>

                <!-- Add New 20% -->
                <div class="w-full sm:w-[20%]">
                    @can('create pq')
                    <flux:button 
                        variant="primary" 
                        icon="plus" 
                        class="bg-blue-600 hover:bg-blue-700 whitespace-nowrap w-full justify-center"
                        wire:click="resetForm"
                        x-on:click="$dispatch('open-modal', 'pq-form-modal')"
                    >
                        Add New
                    </flux:button>
                    @endcan
                </div>
            </div>

            <!-- Product Qualifications - Group Cards by Clause (2 Columns) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @forelse($groupedQualifications as $clause => $items)
                <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden flex flex-col h-full">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-purple-600 to-purple-500 dark:from-purple-700 dark:to-purple-600 px-4 py-3">
                        <div class="flex justify-between items-start gap-2">
                            <div class="flex items-center gap-2 flex-1 min-w-0">
                                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-base shadow-lg flex-shrink-0">
                                    {{ strtoupper(substr($clause, 0, 1)) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-bold text-white text-sm truncate" title="{{ $clause }}">{{ $clause }}</h3>
                                    <p class="text-purple-100 text-xs mt-0.5">
                                        {{ $items->count() }} Control Item(s)
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <span class="text-xs text-purple-100 hidden sm:inline">
                                    Created: {{ $items->first()->created_at->format('d/m/y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card Body - Dengan Scroll jika lebih dari 5 item -->
                    <div class="p-4 flex-1 {{ $items->count() > 3 ? 'max-h-[400px] overflow-y-auto' : '' }}">
                        <div class="space-y-2">
                            @foreach($items as $item)
                            <div class="bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-3 hover:bg-zinc-100 dark:hover:bg-zinc-800/50 transition-colors">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-purple-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                            <p class="text-xs text-zinc-700 dark:text-zinc-300 font-medium break-words" title="{{ $item->control_item }}">
                                                {{ Str::limit($item->control_item, 80) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1 flex-shrink-0">
                                        @can('view pq')
                                        <flux:button 
                                            href="{{ route('esd.product-qualifications.show', $item->id) }}"
                                            wire:navigate
                                            size="xs"
                                            icon="eye"
                                            variant="primary"
                                            color="blue"
                                            class="!p-1"
                                            title="View details"
                                        />
                                        @endcan
                                        @can('edit pq')
                                        <flux:button 
                                            wire:click="edit({{ $item->id }})" 
                                            x-on:click="$dispatch('open-modal', 'pq-form-modal')"
                                            size="xs"
                                            icon="pencil-square"
                                            variant="primary"
                                            color="yellow"
                                            class="!p-1"
                                            title="Edit"
                                        />
                                        @endcan
                                        @can('delete pq')
                                        <flux:button 
                                            wire:click="confirmDelete({{ $item->id }})" 
                                            x-on:click="$dispatch('open-modal', 'delete-pq-modal')"
                                            size="xs"
                                            icon="trash"
                                            variant="primary"
                                            color="red"
                                            class="!p-1"
                                            title="Delete"
                                        />
                                        @endcan
                                    </div>
                                </div>
                                <div class="mt-1.5 flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400 flex-wrap">
                                    <span class="flex items-center gap-0.5">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span class="text-xs">{{ $item->creator->name ?? 'N/A' }}</span>
                                    </span>
                                    <span class="flex items-center gap-0.5">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-xs">{{ $item->updated_at->format('d/m/y') }}</span>
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Card Footer -->
                    <div class="bg-zinc-50 dark:bg-zinc-800/30 px-4 py-2 border-t border-zinc-200 dark:border-zinc-700">
                        <div class="flex justify-between items-center text-xs text-zinc-500 dark:text-zinc-400">
                            <span class="flex items-center gap-0.5">
                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Last updated: {{ $items->first()->updated_at->format('d/m/y H:i') }}
                            </span>
                            @if($items->count() > 5)
                            <span class="flex items-center gap-0.5 text-purple-600 dark:text-purple-400">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1.5 3 3 3h10c1.5 0 3-1 3-3V7c0-2-1.5-3-3-3H7c-1.5 0-3 1-3 3z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8"></path>
                                </svg>
                                Scroll for more ({{ $items->count() }} items)
                            </span>
                            @endif
                        </div>
                    </div>
                </flux:card>
                @empty
                <!-- Empty State - Full Width -->
                <div class="col-span-1 lg:col-span-2 text-center py-12 bg-white dark:bg-zinc-800 rounded-xl shadow-lg">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                            <flux:icon name="document-text" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                No product qualifications found
                            </h3>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                {{ $search ? 'Try adjusting your search query' : 'Get started by creating a new product qualification' }}
                            </p>
                        </div>
                        @if($search)
                            <flux:button wire:click="$set('search', '')" size="sm">
                                Clear Search
                            </flux:button>
                        @else
                            @can('create pq')
                            <flux:button 
                                variant="primary" 
                                size="sm"
                                wire:click="resetForm"
                                x-on:click="$dispatch('open-modal', 'pq-form-modal')"
                            >
                                Add Your First Product Qualification
                            </flux:button>
                            @endcan
                        @endif
                    </div>
                </div>
                @endforelse
            </div>

            <!-- MODAL FORM PRODUCT QUALIFICATION -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-modal.window="if ($event.detail === 'pq-form-modal') open = true"
                 @close-modal.window="if ($event.detail === 'pq-form-modal') open = false"
                 x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                            <form wire:submit="save">
                                <!-- Clause -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Clause <span class="text-red-500">*</span></label>
                                    <input type="text" 
                                           wire:model="clause"
                                           placeholder="e.g., 8.3 ESD Protected Areas (EPAs)"
                                           class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    @error('clause') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Control Item -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Control Item <span class="text-red-500">*</span></label>
                                    <textarea 
                                           wire:model="control_item"
                                           rows="3"
                                           placeholder="Enter control item description..."
                                           class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                                    @error('control_item') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Buttons -->
                                <div class="flex justify-end gap-2 mt-6">
                                    <button type="button" 
                                            @click="open = false"
                                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                                        Cancel
                                    </button>
                                    <button type="submit" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        {{ $pq_id ? 'Update' : 'Create' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL DELETE -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-modal.window="if ($event.detail === 'delete-pq-modal') open = true"
                 @close-modal.window="if ($event.detail === 'delete-pq-modal') open = false"
                 x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>

                        <h3 class="text-lg font-bold mb-2">Delete Product Qualification</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Are you sure you want to delete product qualification "{{ $pqToDelete?->clause }} - {{ $pqToDelete?->control_item }}"? This action cannot be undone.
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
    </x-esd.layout>
</section>