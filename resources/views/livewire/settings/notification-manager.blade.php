{{-- resources/views/livewire/notification-manager.blade.php --}}
<div class="p-1 space-y-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Settings
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Notifications
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Site Notifications
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage site-wide notifications that appear in the header
            </p>
        </div>
        
        <flux:button 
            wire:click="create" 
            variant="primary" 
            icon="plus"
        >
            Create Notification
        </flux:button>
    </div>

    <!-- Search and Filters -->
    <div class="flex justify-end mt-4">
        <div class="w-full sm:w-80">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search notifications by message..."
                icon="magnifying-glass"
                clearable
            />
        </div>
    </div>

    <!-- Notifications Table -->
    <flux:card class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Order</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Icon</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Color</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Message</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Button</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($notifications as $notification)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="notification-{{ $notification->id }}">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <flux:badge size="sm" color="gray">
                                {{ $notification->display_order }}
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <code class="text-xs bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded">
                                {{ $notification->icon ?? 'star' }}
                            </code>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full {{ $notification->getColorClasses() }}"></div>
                                <span class="text-xs capitalize">{{ $notification->color }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div>
                                <p class="text-sm text-zinc-800 dark:text-zinc-200">
                                    {{ $notification->message }}
                                </p>
                                @if($notification->button_url)
                                    <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">
                                        {{ \Str::limit($notification->button_url, 40) }}
                                    </p>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($notification->button_text)
                                <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded">
                                    {{ $notification->button_text }}
                                </span>
                            @else
                                <span class="text-xs text-zinc-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($notification->is_active)
                                <span class="text-xs px-2 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded">
                                    Active
                                </span>
                            @else
                                <span class="text-xs px-2 py-1 bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300 rounded">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2">
                                <flux:button 
                                    wire:click="edit({{ $notification->id }})" 
                                    size="sm"
                                    variant="ghost"
                                    icon="pencil-square"
                                    class="!p-1.5"
                                    title="Edit"
                                />
                                <flux:button 
                                    wire:click="toggleStatus({{ $notification->id }})" 
                                    size="sm"
                                    variant="ghost"
                                    icon="check-circle"
                                    class="!p-1.5"
                                    :title="$notification->is_active ? 'Deactivate' : 'Activate'"
                                />
                                <flux:button 
                                    wire:click="confirmDelete({{ $notification->id }})" 
                                    size="sm"
                                    variant="ghost"
                                    icon="trash"
                                    class="!p-1.5 text-red-600 hover:text-red-700"
                                    title="Delete"
                                />
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="text-center">
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        No notifications found
                                    </h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                        {{ $search ? 'Try adjusting your search query' : 'Get started by creating your first notification' }}
                                    </p>
                                </div>
                                @if($search)
                                    <flux:button wire:click="$set('search', '')" size="sm" variant="ghost">
                                        Clear Search
                                    </flux:button>
                                @else
                                    <flux:button 
                                        variant="primary" 
                                        size="sm"
                                        wire:click="create"
                                        icon="plus"
                                    >
                                        Create First Notification
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
        @if($notifications->hasPages())
        <div class="pt-4 mt-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $notifications->links() }}
        </div>
        @endif
    </flux:card>

    <!-- Modal Form Create/Edit -->
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-data="{ open: true }" x-show="open" x-cloak>
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col">
            <!-- Header - Fixed -->
            <div class="flex-shrink-0 p-6 pb-0">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-white">
                    {{ $isEditing ? 'Edit Notification' : 'Create New Notification' }}
                </h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ $isEditing ? 'Update the notification details below' : 'Fill in the details to create a new site notification' }}
                </p>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto px-6 py-4">
                <div class="space-y-4">
                    <!-- Icon Input -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Icon Name
                        </label>
                        <input 
                            type="text"
                            wire:model="icon" 
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="star, bell, information-circle, sparkles"
                        >
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                            Enter icon name from Heroicons (star, bell, chat-bubble-left-right, etc.)
                        </p>
                    </div>

                    <!-- Color Selection -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Badge Color
                        </label>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" 
                                wire:click="$set('color', 'yellow')"
                                class="w-8 h-8 rounded-full bg-yellow-100 border-2 {{ $color === 'yellow' ? 'border-yellow-500 ring-2 ring-yellow-500 ring-offset-2' : 'border-transparent' }} hover:scale-110 transition-transform"
                                title="Yellow">
                            </button>
                            <button type="button" 
                                wire:click="$set('color', 'blue')"
                                class="w-8 h-8 rounded-full bg-blue-100 border-2 {{ $color === 'blue' ? 'border-blue-500 ring-2 ring-blue-500 ring-offset-2' : 'border-transparent' }} hover:scale-110 transition-transform"
                                title="Blue">
                            </button>
                            <button type="button" 
                                wire:click="$set('color', 'green')"
                                class="w-8 h-8 rounded-full bg-green-100 border-2 {{ $color === 'green' ? 'border-green-500 ring-2 ring-green-500 ring-offset-2' : 'border-transparent' }} hover:scale-110 transition-transform"
                                title="Green">
                            </button>
                            <button type="button" 
                                wire:click="$set('color', 'red')"
                                class="w-8 h-8 rounded-full bg-red-100 border-2 {{ $color === 'red' ? 'border-red-500 ring-2 ring-red-500 ring-offset-2' : 'border-transparent' }} hover:scale-110 transition-transform"
                                title="Red">
                            </button>
                            <button type="button" 
                                wire:click="$set('color', 'purple')"
                                class="w-8 h-8 rounded-full bg-purple-100 border-2 {{ $color === 'purple' ? 'border-purple-500 ring-2 ring-purple-500 ring-offset-2' : 'border-transparent' }} hover:scale-110 transition-transform"
                                title="Purple">
                            </button>
                            <button type="button" 
                                wire:click="$set('color', 'pink')"
                                class="w-8 h-8 rounded-full bg-pink-100 border-2 {{ $color === 'pink' ? 'border-pink-500 ring-2 ring-pink-500 ring-offset-2' : 'border-transparent' }} hover:scale-110 transition-transform"
                                title="Pink">
                            </button>
                            <button type="button" 
                                wire:click="$set('color', 'indigo')"
                                class="w-8 h-8 rounded-full bg-indigo-100 border-2 {{ $color === 'indigo' ? 'border-indigo-500 ring-2 ring-indigo-500 ring-offset-2' : 'border-transparent' }} hover:scale-110 transition-transform"
                                title="Indigo">
                            </button>
                            <button type="button" 
                                wire:click="$set('color', 'gray')"
                                class="w-8 h-8 rounded-full bg-gray-100 border-2 {{ $color === 'gray' ? 'border-gray-500 ring-2 ring-gray-500 ring-offset-2' : 'border-transparent' }} hover:scale-110 transition-transform"
                                title="Gray">
                            </button>
                        </div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2">Choose badge color for the notification</p>
                        @error('color') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            wire:model="message" 
                            rows="3"
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter notification message..."
                            required
                        ></textarea>
                        @error('message') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Button Text & URL -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Button Text
                            </label>
                            <input 
                                type="text"
                                wire:model="button_text" 
                                class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="e.g., Learn More, Read More"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Button URL
                            </label>
                            <input 
                                type="text"
                                wire:model="button_url" 
                                class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="https://example.com or /dashboard"
                            >
                        </div>
                    </div>

                    <!-- Active & Display Order -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">
                        <label class="flex items-center gap-2">
                            <input 
                                type="checkbox"
                                wire:model="is_active" 
                                class="rounded border-zinc-300 dark:border-zinc-600 text-blue-600 focus:ring-blue-500"
                            >
                            <span class="text-sm text-zinc-700 dark:text-zinc-300">Active</span>
                        </label>
                        
                        <div class="w-32">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Display Order
                            </label>
                            <input 
                                type="number"
                                wire:model="display_order" 
                                min="0"
                                step="1"
                                class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">Lower numbers appear first</p>
                            @error('display_order') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Preview -->
                    <div class="pt-2">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Preview
                        </label>
                        <div class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ $color === 'yellow' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }} {{ $color === 'blue' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }} {{ $color === 'green' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }} {{ $color === 'red' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }} {{ $color === 'purple' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : '' }} {{ $color === 'pink' ? 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200' : '' }} {{ $color === 'indigo' ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200' : '' }} {{ $color === 'gray' ? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300' : '' }}">
                            @if($icon)
                                <flux:icon :name="$icon" class="w-4 h-4 mr-1.5" />
                            @else
                                <flux:icon.star class="w-4 h-4 mr-1.5" />
                            @endif
                            {{ $message ?: 'Your notification message will appear here' }}
                            @if($button_text && $button_url)
                                <a href="{{ $button_url }}" class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full hover:opacity-80 {{ $color === 'yellow' ? 'bg-yellow-200 text-yellow-800' : '' }} {{ $color === 'blue' ? 'bg-blue-200 text-blue-800' : '' }} {{ $color === 'green' ? 'bg-green-200 text-green-800' : '' }} {{ $color === 'red' ? 'bg-red-200 text-red-800' : '' }} {{ $color === 'purple' ? 'bg-purple-200 text-purple-800' : '' }} {{ $color === 'pink' ? 'bg-pink-200 text-pink-800' : '' }} {{ $color === 'indigo' ? 'bg-indigo-200 text-indigo-800' : '' }} {{ $color === 'gray' ? 'bg-gray-200 text-gray-800' : '' }}">
                                    {{ $button_text }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer - Fixed -->
            <div class="flex-shrink-0 p-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                <div class="flex gap-3 justify-end">
                    <button 
                        type="button"
                        wire:click="closeModal" 
                        class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-white"
                    >
                        Cancel
                    </button>
                    <button 
                        type="button"
                        wire:click="save" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors"
                    >
                        {{ $isEditing ? 'Update' : 'Create' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal Delete Confirmation -->
    @if($showDeleteModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-data="{ open: true }" x-show="open" x-cloak>
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-xl w-full max-w-md">
            <div class="p-6">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/20 mb-4">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">
                        Delete Notification
                    </h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        Are you sure you want to delete this notification?
                        <br>
                        This action cannot be undone.
                    </p>
                </div>

                <div class="flex gap-3 justify-center pt-6">
                    <button 
                        type="button"
                        wire:click="closeModal" 
                        class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-white"
                    >
                        Cancel
                    </button>
                    <button 
                        type="button"
                        wire:click="deleteConfirmed" 
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>