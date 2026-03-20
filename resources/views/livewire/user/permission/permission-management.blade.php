<div class="p-2 space-y-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Settings
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Permission
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Permission Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage system permissions
            </p>
        </div>
        
        <!-- Tombol Add Permission -->
        <flux:button 
            variant="primary" 
            icon="plus" 
            class="bg-blue-600 hover:bg-blue-700"
            wire:click="resetForm"
            x-on:click="$dispatch('open-modal', 'permission-form-modal')"
        >
            Add New Permission
        </flux:button>
    </div>

    <!-- Info Card -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <p class="text-sm text-blue-800">
            Format permission: <span class="font-mono bg-white px-2 py-1 rounded">action</span> + <span class="font-mono bg-white px-2 py-1 rounded">resource</span> 
            (contoh: "view users", "create roles", "delete permissions")
        </p>
    </div>

    <!-- Search -->
    <div class="flex justify-end">
        <div class="w-full sm:w-64">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search permissions..."
                icon="magnifying-glass"
                clearable
            />
        </div>
    </div>

    <!-- Permissions Table -->
    <flux:card class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Permission</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Assigned to Roles</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($permissions as $index => $permission)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="permission-{{ $permission->id }}">
                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $permissions->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-zinc-800 dark:text-white">
                                    {{ $permission->name }}
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-1">
                                @forelse($permission->roles->take(2) as $role)
                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">
                                        {{ $role->name }}
                                    </span>
                                @empty
                                    <span class="text-sm text-zinc-400">Not assigned</span>
                                @endforelse
                                @if($permission->roles->count() > 2)
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                        +{{ $permission->roles->count() - 2 }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        <!-- Actions Column -->
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <!-- Edit Button -->
                                @can('edit permissions')
                                <flux:button 
                                    wire:click="edit({{ $permission->id }})" 
                                    x-on:click="$dispatch('open-modal', 'permission-form-modal')"
                                    size="sm"
                                    icon="pencil-square"
                                    class="!p-2 text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-950/50"
                                    title="Edit permission"
                                />
                                @endcan

                                <!-- Delete Button -->
                                @can('delete permissions')
                                    @if($permission->roles->count() == 0)
                                        <flux:button 
                                            wire:click="confirmDelete({{ $permission->id }})" 
                                            x-on:click="$dispatch('open-modal', 'delete-permission-modal')"
                                            size="sm"
                                            icon="trash"
                                            class="!p-2 text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/50"
                                            title="Delete permission"
                                        />
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <flux:icon name="key" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        No permissions found
                                    </h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                        {{ $search ? 'Try adjusting your search query' : 'Get started by creating a new permission' }}
                                    </p>
                                </div>
                                @if($search)
                                    <flux:button wire:click="$set('search', '')" size="sm">
                                        Clear Search
                                    </flux:button>
                                @else
                                    <flux:button 
                                        variant="primary" 
                                        size="sm"
                                        wire:click="resetForm"
                                        x-on:click="$dispatch('open-modal', 'permission-form-modal')"
                                    >
                                        Add Your First Permission
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
        @if($permissions->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $permissions->links() }}
        </div>
        @endif
    </flux:card>

    <!-- MODAL FORM PERMISSION -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'permission-form-modal') open = true"
         @close-modal.window="if ($event.detail === 'permission-form-modal') open = false"
         x-cloak>
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
        
        <!-- Modal -->
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                    <form wire:submit="save">
                        <!-- Permission Name -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Permission Name</label>
                            <input type="text" 
                                   wire:model="name"
                                   placeholder="e.g., view users"
                                   class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Assign to Roles -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2">Assign to Roles (Optional)</label>
                            <div class="space-y-2 max-h-48 overflow-y-auto border rounded-lg p-3">
                                @foreach($roles as $role)
                                    <label class="flex items-center gap-2">
                                        <input type="checkbox" 
                                               wire:model="selectedRoles" 
                                               value="{{ $role->name }}"
                                               class="rounded">
                                        <span>{{ $role->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-2">
                            <button type="button" 
                                    @click="open = false"
                                    class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                {{ $permission_id ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE PERMISSION -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'delete-permission-modal') open = true"
         @close-modal.window="if ($event.detail === 'delete-permission-modal') open = false"
         x-cloak>
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
        
        <!-- Modal -->
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                
                <h3 class="text-lg font-bold mb-2">Delete Permission</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Are you sure you want to delete permission "{{ $permissionToDelete?->name }}"? This action cannot be undone.
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
    <div x-data="{ show: false, message: '' }" 
         x-on:notify.window="show = true; message = $event.detail.message; setTimeout(() => show = false, 3000)"
         x-show="show"
         x-transition
         class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        <span x-text="message"></span>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>