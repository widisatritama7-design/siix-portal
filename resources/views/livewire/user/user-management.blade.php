<div class="p-6 space-y-6">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            User
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header dengan Title dan Tombol Add -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                User Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage your system users and their permissions
            </p>
        </div>
        
        <!-- Tombol Add User dengan Modal Trigger -->
        <flux:modal.trigger name="user-form-modal">
            <flux:button variant="primary" icon="plus" class="bg-blue-600 hover:bg-blue-700">
                Add New User
            </flux:button>
        </flux:modal.trigger>
    </div>

    <!-- Users Table Card -->
    <flux:card class="overflow-hidden">
        <!-- Header dengan Search dan Total Badge -->
        <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-center gap-3">
                    <flux:badge color="blue" size="sm" icon="users" class="gap-1">
                        Total Users: {{ $users ? count($users) : 0 }}
                    </flux:badge>
                    
                    @if($search)
                        <flux:badge color="gray" size="sm" icon="magnifying-glass">
                            Searching: "{{ $search }}"
                        </flux:badge>
                    @endif
                </div>

                <div class="w-full sm:w-64">
                    <flux:input
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search users..."
                        icon="magnifying-glass"
                        clearable
                    />
                </div>
            </div>
        </div>

        <!-- Tabel Users -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Joined</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($users ?? [] as $index => $user)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="user-{{ $user->id }}">
                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $index + 1 }}
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
                            <div class="flex items-center gap-2">
                                <flux:icon name="calendar" class="w-4 h-4 text-zinc-400" />
                                <span class="text-sm text-zinc-600 dark:text-zinc-300">
                                    {{ $user->created_at->format('M d, Y') }}
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <!-- Edit Button dengan Modal Trigger -->
                                <flux:modal.trigger name="user-form-modal">
                                    <flux:button 
                                        wire:click="edit({{ $user->id }})" 
                                        size="sm"
                                        icon="pencil-square"
                                        class="!p-2 text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-950/50"
                                        title="Edit user"
                                    />
                                </flux:modal.trigger>

                                <!-- Delete Button dengan Modal Trigger -->
                                <flux:modal.trigger name="delete-user-modal">
                                    <flux:button 
                                        wire:click="confirmDelete({{ $user->id }})" 
                                        size="sm"
                                        icon="trash"
                                        class="!p-2 text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/50"
                                        title="Delete user"
                                    />
                                </flux:modal.trigger>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center">
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
                                    <flux:modal.trigger name="user-form-modal">
                                        <flux:button variant="primary" size="sm">
                                            Add Your First User
                                        </flux:button>
                                    </flux:modal.trigger>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </flux:card>

    <!-- Modal Form untuk Add/Edit User dengan Background Blur -->
    <flux:modal name="user-form-modal" class="md:w-96 backdrop-blur-xl" wire:ignore.self>
        <div class="space-y-6 bg-white/90 dark:bg-zinc-900/90 rounded-xl p-6">
            <div>
                <flux:heading size="lg">{{ $modalTitle }}</flux:heading>
                <flux:text class="mt-2">
                    @if($user_id)
                        Update the user details below.
                    @else
                        Fill in the details to create a new user.
                    @endif
                </flux:text>
            </div>

            <form wire:submit="save" class="space-y-4">
                <!-- Name Field -->
                <div>
                    <flux:field>
                        <flux:label>Full Name</flux:label>
                        <flux:input 
                            wire:model="name" 
                            placeholder="Enter full name"
                            :invalid="$errors->has('name')"
                        />
                        @error('name')
                            <flux:error>{{ $message }}</flux:error>
                        @enderror
                    </flux:field>
                </div>

                <!-- Email Field -->
                <div>
                    <flux:field>
                        <flux:label>Email Address</flux:label>
                        <flux:input 
                            wire:model="email" 
                            type="email" 
                            placeholder="Enter email address"
                            :invalid="$errors->has('email')"
                        />
                        @error('email')
                            <flux:error>{{ $message }}</flux:error>
                        @enderror
                    </flux:field>
                </div>

                <!-- Password Field -->
                <div>
                    <flux:field>
                        <flux:label>
                            {{ $user_id ? 'New Password (optional)' : 'Password' }}
                        </flux:label>
                        <flux:input 
                            wire:model="password" 
                            type="password" 
                            placeholder="{{ $user_id ? 'Enter new password' : 'Enter password' }}"
                            :invalid="$errors->has('password')"
                        />
                        @error('password')
                            <flux:error>{{ $message }}</flux:error>
                        @enderror
                    </flux:field>
                </div>

                <!-- Password Confirmation Field -->
                <div>
                    <flux:field>
                        <flux:label>Confirm Password</flux:label>
                        <flux:input 
                            wire:model="password_confirmation" 
                            type="password" 
                            placeholder="Confirm password"
                            :invalid="$errors->has('password')"
                        />
                    </flux:field>
                </div>

                <div class="flex pt-4">
                    <flux:spacer />
                    
                    <div class="flex gap-2">
                        <flux:modal.close>
                            <flux:button type="button" variant="ghost">Cancel</flux:button>
                        </flux:modal.close>
                        
                        <flux:button type="submit" variant="primary" class="bg-blue-600 hover:bg-blue-700">
                            {{ $user_id ? 'Update User' : 'Create User' }}
                        </flux:button>
                    </div>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Modal Konfirmasi Delete dengan Background Blur -->
    <flux:modal name="delete-user-modal" class="md:w-96 backdrop-blur-xl" wire:ignore.self>
        <div class="space-y-6 text-center bg-white/90 dark:bg-zinc-900/90 rounded-xl p-6">
            <div class="flex justify-center">
                <div class="w-20 h-20 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <flux:icon name="exclamation-triangle" class="w-10 h-10 text-red-600 dark:text-red-400" />
                </div>
            </div>
            
            <div>
                <flux:heading size="lg" class="text-red-600 dark:text-red-400">Delete User</flux:heading>
                <flux:text class="mt-2">
                    Are you sure you want to delete this user? This action cannot be undone.
                </flux:text>
            </div>

            <div class="flex justify-center gap-3 pt-4">
                <flux:modal.close>
                    <flux:button variant="ghost" class="px-6">Cancel</flux:button>
                </flux:modal.close>
                
                <flux:button wire:click="delete" variant="danger" class="px-6">
                    Yes, Delete User
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <!-- Notifikasi dengan Alert Custom -->
    <div x-data="{ show: false, message: '' }" 
         x-on:notify.window="show = true; message = $event.detail.message; setTimeout(() => show = false, 3000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed bottom-4 right-4 z-50">
        <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
            <flux:icon name="check-circle" class="w-5 h-5" />
            <span x-text="message"></span>
        </div>
    </div>

    <!-- Script tambahan untuk menutup modal form setelah submit -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('notify', () => {
                // Close the form modal if it's open
                const formModal = document.querySelector('[name="user-form-modal"]');
                if (formModal && formModal.open) {
                    formModal.open = false;
                }
                
                // Close the delete modal if it's open
                const deleteModal = document.querySelector('[name="delete-user-modal"]');
                if (deleteModal && deleteModal.open) {
                    deleteModal.open = false;
                }
            });
        });
    </script>
</div>