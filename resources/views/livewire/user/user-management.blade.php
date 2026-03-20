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
            User
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                User Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage your system users and their roles
            </p>
        </div>
        
        <div class="flex gap-2">
            <flux:button 
                href="{{ route('role.management') }}" 
                variant="ghost" 
                icon="shield-check"
                wire:navigate>
                Manage Roles
            </flux:button>
            
            <!-- Tombol Add User -->
            <flux:button 
                variant="primary" 
                icon="plus" 
                class="bg-blue-600 hover:bg-blue-700"
                wire:click="resetForm"
                x-on:click="$dispatch('open-modal', 'user-form-modal')"
            >
                Add New User
            </flux:button>
        </div>
    </div>

    <!-- Search -->
    <div class="flex justify-end">
        <div class="w-full sm:w-64">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search users..."
                icon="magnifying-glass"
                clearable
            />
        </div>
    </div>

    <!-- Users Table -->
    <flux:card class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Roles</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Joined</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($users as $index => $user)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="user-{{ $user->id }}">
                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $users->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-medium shadow-lg">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <span class="text-sm font-semibold text-zinc-800 dark:text-white block">
                                        {{ $user->name }}
                                    </span>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                        ID: #{{ $user->id }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <flux:icon name="envelope" class="w-4 h-4 text-zinc-400" />
                                <span class="text-sm text-zinc-600 dark:text-zinc-300">
                                    {{ $user->email }}
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-1">
                                @forelse($user->roles as $role)
                                    <flux:badge size="sm" color="{{ $role->name == 'super-admin' ? 'purple' : ($role->name == 'admin' ? 'blue' : 'gray') }}">
                                        {{ $role->name }}
                                    </flux:badge>
                                @empty
                                    <span class="text-sm text-zinc-400">No roles</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <flux:icon name="calendar" class="w-4 h-4 text-zinc-400" />
                                <span class="text-sm text-zinc-600 dark:text-zinc-300">
                                    {{ $user->created_at->format('M d, Y') }}
                                </span>
                            </div>
                        </td>
                        <!-- Actions Column -->
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <!-- Edit Button -->
                                @can('edit users')
                                <flux:button 
                                    wire:click="edit({{ $user->id }})" 
                                    x-on:click="$dispatch('open-modal', 'user-form-modal')"
                                    size="sm"
                                    icon="pencil-square"
                                    class="!p-2 text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-950/50"
                                    title="Edit user"
                                />
                                @endcan

                                <!-- Delete Button -->
                                @can('delete users')
                                    @if(!$user->hasRole('super-admin')) <!-- Ini tetap perlu karena proteksi data, bukan akses -->
                                        <flux:button 
                                            wire:click="confirmDelete({{ $user->id }})" 
                                            x-on:click="$dispatch('open-modal', 'delete-user-modal')"
                                            size="sm"
                                            icon="trash"
                                            class="!p-2 text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/50"
                                            title="Delete user"
                                        />
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <flux:icon name="users" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        No users found
                                    </h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                        {{ $search ? 'Try adjusting your search query' : 'Get started by creating a new user' }}
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
                                        x-on:click="$dispatch('open-modal', 'user-form-modal')"
                                    >
                                        Add Your First User
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
        @if($users->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $users->links() }}
        </div>
        @endif
    </flux:card>

    <!-- MODAL FORM USER -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'user-form-modal') open = true"
         @close-modal.window="if ($event.detail === 'user-form-modal') open = false"
         x-cloak>
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
        
        <!-- Modal -->
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                    <form wire:submit="save">
                        <!-- Name -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Full Name</label>
                            <input type="text" 
                                   wire:model="name"
                                   class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Email Address</label>
                            <input type="email" 
                                   wire:model="email"
                                   class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">
                                {{ $user_id ? 'New Password (optional)' : 'Password' }}
                            </label>
                            <input type="password" 
                                   wire:model="password"
                                   class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Confirm Password</label>
                            <input type="password" 
                                   wire:model="password_confirmation"
                                   class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                        </div>

                        <!-- Roles -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2">Assign Roles</label>
                            <div class="space-y-2 max-h-48 overflow-y-auto border rounded-lg p-3">
                                @foreach($roles as $role)
                                    <label class="flex items-center gap-2">
                                        <input type="checkbox" 
                                               wire:model="selectedRoles" 
                                               value="{{ $role->name }}"
                                               class="rounded">
                                        <span>{{ $role->name }}</span>
                                        @if($role->name === 'super-admin')
                                            <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded">Full Access</span>
                                        @endif
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
                                {{ $user_id ? 'Update' : 'Create' }}
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
         @open-modal.window="if ($event.detail === 'delete-user-modal') open = true"
         @close-modal.window="if ($event.detail === 'delete-user-modal') open = false"
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
                
                <h3 class="text-lg font-bold mb-2">Delete User</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Are you sure you want to delete user "{{ $userToDelete?->name }}"? This action cannot be undone.
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