<div class="p-1 space-y-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Ticketing Support
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Category
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Ticket Category Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage ticket categories for your ticketing system
            </p>
        </div>

        <!-- Add Category Button -->
        @can('create categories')
        <flux:button 
            variant="primary" 
            icon="plus" 
            class="bg-blue-600 hover:bg-blue-700"
            wire:click="resetForm"
            x-on:click="$dispatch('open-modal', 'category-form-modal')"
        >
            Add Category
        </flux:button>
        @endcan
    </div>

    <!-- Search -->
    <div class="flex justify-end">
        <div class="w-full sm:w-64">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search categories..."
                icon="magnifying-glass"
                clearable
            />
        </div>
    </div>

    <!-- Categories Table -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Description</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Total Tickets</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($categories as $index => $category)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="category-{{ $category->id }}">
                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $categories->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div>
                                    <span class="text-sm font-semibold text-zinc-800 dark:text-white block">
                                        {{ $category->name }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-zinc-600 dark:text-zinc-400 max-w-xs">
                                {{ $category->description ?: '-' }}
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <flux:badge size="sm" color="{{ $category->tickets_count > 0 ? 'purple' : 'gray' }}">
                                {{ $category->tickets_count }} ticket(s)
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                @can('edit categories')
                                <flux:button 
                                    wire:click="edit({{ $category->id }})" 
                                    x-on:click="$dispatch('open-modal', 'category-form-modal')"
                                    size="sm"
                                    icon="pencil-square"
                                    variant="primary"
                                    color="yellow"
                                    class="!p-2"
                                    title="Edit category"
                                />
                                @endcan

                                @can('delete categories')
                                    <flux:button 
                                        wire:click="confirmDelete({{ $category->id }})" 
                                        x-on:click="$dispatch('open-modal', 'delete-category-modal')"
                                        size="sm"
                                        icon="trash"
                                        variant="primary"
                                        color="red"
                                        class="!p-2"
                                        title="Delete category"
                                    />
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <flux:icon name="tag" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        No categories found
                                    </h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                        {{ $search ? 'Try adjusting your search query' : 'Get started by creating a new category' }}
                                    </p>
                                </div>
                                @if($search)
                                    <flux:button wire:click="$set('search', '')" size="sm">
                                        Clear Search
                                    </flux:button>
                                @else
                                    @can('create categories')
                                    <flux:button 
                                        variant="primary" 
                                        size="sm"
                                        wire:click="resetForm"
                                        x-on:click="$dispatch('open-modal', 'category-form-modal')"
                                    >
                                        Add Your First Category
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
        @if($categories->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $categories->links() }}
        </div>
        @endif
    </flux:card>

    <!-- MODAL FORM CATEGORY -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'category-form-modal') open = true"
         @close-modal.window="if ($event.detail === 'category-form-modal') open = false"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                    <form wire:submit="save">
                        <!-- Category Name -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="name"
                                   class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Enter category name">
                            @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">
                                Description
                            </label>
                            <textarea 
                                wire:model="description"
                                rows="3"
                                class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter category description (optional)"></textarea>
                            @error('description') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            <p class="text-xs text-zinc-500 mt-1">Brief description of this category</p>
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
                                {{ $category_id ? 'Update' : 'Save' }}
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
         @open-modal.window="if ($event.detail === 'delete-category-modal') open = true"
         @close-modal.window="if ($event.detail === 'delete-category-modal') open = false"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>

                <h3 class="text-lg font-bold mb-2">Delete Category</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Are you sure you want to delete category <strong>"{{ $categoryToDelete?->name }}"</strong>?
                    <br>
                    <span class="text-sm text-red-500">This action cannot be undone.</span>
                </p>

                <div class="flex justify-center gap-3">
                    <button @click="open = false" 
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="delete" 
                            @click="open = false"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification -->
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