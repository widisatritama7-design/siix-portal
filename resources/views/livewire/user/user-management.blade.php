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
            @can('view roles')
            <flux:button 
                href="{{ route('role.management') }}" 
                variant="ghost" 
                icon="shield-check"
                wire:navigate>
                Manage Roles
            </flux:button>
            @endcan
            
            <!-- Tombol Add User -->
            @can('create users')
            <flux:button 
                variant="primary" 
                icon="plus" 
                class="bg-blue-600 hover:bg-blue-700"
                wire:click="resetForm"
            >
                Add New User
            </flux:button>
            @endcan
        </div>
    </div>

    <!-- Search -->
    <div class="flex justify-end">
        <div class="w-full sm:w-64">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search users by name, NIK, or email..."
                icon="magnifying-glass"
                clearable
            />
        </div>
    </div>

    <!-- Bulk Actions Bar -->
    @if(count($selectedUsers) > 0)
    <div class="bg-blue-50 dark:bg-blue-950/30 rounded-lg p-4 flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            <flux:icon name="check-circle" class="w-5 h-5 text-blue-600" />
            <span class="text-sm font-medium text-blue-800 dark:text-blue-300">
                {{ count($selectedUsers) }} user(s) selected
            </span>
        </div>
        <div class="flex flex-wrap gap-2">
            @can('edit users')
            <flux:button 
                variant="primary" 
                size="sm"
                icon="tag"
                wire:click="openBulkModal"
                class="bg-blue-600 hover:bg-blue-700">
                Bulk Assign Role
            </flux:button>
            @endcan
            <flux:button 
                variant="ghost" 
                size="sm"
                icon="x-mark"
                wire:click="resetBulkSelection">
                Clear Selection
            </flux:button>
        </div>
    </div>
    @endif

    <!-- Users Table -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
        <!-- Table Container with Horizontal Scroll -->
        <div class="overflow-x-auto">
            <div class="min-w-[1200px]">
                <table class="w-full">
                    <thead>
                        <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider sticky left-0 bg-zinc-50 dark:bg-zinc-800/50 z-10" style="width: 40px;">
                                <input type="checkbox" 
                                    wire:model.live="selectAll"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="width: 60px;">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 150px;">NIK</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 200px;">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 200px;">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 250px;">Roles</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 120px;">Joined</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider sticky right-0 bg-zinc-50 dark:bg-zinc-800/50 z-10" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($users as $index => $user)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors group" wire:key="user-{{ $user->id }}">
                            <td class="px-4 py-3 sticky left-0 bg-white dark:bg-zinc-900 group-hover:bg-zinc-50 dark:group-hover:bg-zinc-800/50 z-10">
                                <input type="checkbox" 
                                    wire:model.live="selectedUsers" 
                                    value="{{ $user->id }}"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                {{ $users->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <flux:icon name="identification" class="w-4 h-4 text-zinc-400 flex-shrink-0" />
                                    <span class="text-sm font-mono text-zinc-600 dark:text-zinc-300">
                                        {{ $user->nik }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-medium shadow-lg flex-shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="text-sm font-semibold text-zinc-800 dark:text-white block whitespace-nowrap">
                                            {{ $user->name }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($user->email)
                                    <div class="flex items-center gap-2">
                                        <flux:icon name="envelope" class="w-4 h-4 text-zinc-400 flex-shrink-0" />
                                        <span class="text-sm text-zinc-600 dark:text-zinc-300 break-all">
                                            {{ $user->email }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-sm text-zinc-400 italic whitespace-nowrap">No email</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1 min-w-[200px]">
                                    @forelse($user->roles as $role)
                                        <flux:badge size="sm" color="{{ $role->name == 'super-admin' ? 'purple' : ($role->name == 'admin' ? 'blue' : 'gray') }}" class="whitespace-nowrap">
                                            {{ $role->name }}
                                        </flux:badge>
                                    @empty
                                        <span class="text-sm text-zinc-400 whitespace-nowrap">No roles</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <flux:icon name="calendar" class="w-4 h-4 text-zinc-400 flex-shrink-0" />
                                    <span class="text-sm text-zinc-600 dark:text-zinc-300 whitespace-nowrap">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </span>
                                </div>
                            </td>
                            <!-- Actions Column - Sticky -->
                            <td class="px-4 py-3 text-right sticky right-0 bg-white dark:bg-zinc-900 group-hover:bg-zinc-50 dark:group-hover:bg-zinc-800/50 z-10">
                                <div class="flex items-center justify-end gap-1">
                                    <!-- Edit Button -->
                                    @can('edit users')
                                    <flux:button 
                                        wire:click="edit({{ $user->id }})" 
                                        size="sm"
                                        icon="pencil-square"
                                        class="!p-2 text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-950/50 flex-shrink-0"
                                        title="Edit user"
                                    />
                                    @endcan

                                    <!-- Delete Button -->
                                    @can('delete users')
                                        @if(!$user->hasRole('super-admin'))
                                            <flux:button 
                                                wire:click="confirmDelete({{ $user->id }})" 
                                                size="sm"
                                                icon="trash"
                                                class="!p-2 text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/50 flex-shrink-0"
                                                title="Delete user"
                                            />
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center">
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
                                        @can('create users')
                                        <flux:button 
                                            variant="primary" 
                                            size="sm"
                                            wire:click="resetForm"
                                            x-on:click="$dispatch('open-modal', 'user-form-modal')"
                                        >
                                            Add Your First User
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
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 mt-4">
            {{ $users->links() }}
        </div>
        @endif
    </flux:card>

    <!-- MODAL FORM USER -->
    <div x-data="{ open: false }" 
        x-show="open" 
        @open-modal.window="if ($event.detail.modal === 'user-form-modal') open = true"
        @close-modal.window="if ($event.detail.modal === 'user-form-modal') open = false"
        x-cloak>
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
        
        <!-- Modal -->
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-lg max-h-[90vh] flex flex-col">
                <!-- Header - Fixed -->
                <div class="p-6 pb-0">
                    <h2 class="text-xl font-bold">{{ $modalTitle }}</h2>
                </div>

                <!-- Form Container - Scrollable -->
                <div class="overflow-y-auto p-6 pt-4">
                    <form wire:submit.prevent="save" id="user-form">
                        <!-- NIK - Required -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">
                                NIK <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                wire:model="nik"
                                class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter NIK (numbers only)">
                            @error('nik') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Name - Required -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                wire:model="name"
                                class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter full name">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email - Optional -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">
                                Email Address <span class="text-gray-400 text-xs">(optional)</span>
                            </label>
                            <input type="email" 
                                wire:model="email"
                                class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="user@example.com">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">
                                {{ $user_id ? 'New Password (optional)' : 'Password' }}
                                @if(!$user_id)<span class="text-red-500">*</span>@endif
                            </label>
                            <input type="password" 
                                wire:model="password"
                                class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="{{ $user_id ? 'Leave blank to keep current password' : 'Enter password' }}">
                            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Confirm Password</label>
                            <input type="password" 
                                wire:model="password_confirmation"
                                class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Confirm password">
                        </div>

                        <!-- Roles -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Assign Roles</label>
                            <div class="space-y-2 max-h-48 overflow-y-auto border rounded-lg p-3 dark:border-zinc-700">
                                @foreach($roles as $role)
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" 
                                            wire:model="selectedRoles" 
                                            value="{{ $role->name }}"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm">{{ $role->name }}</span>
                                        @if($role->name === 'super-admin')
                                            <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded">Full Access</span>
                                        @endif
                                    </label>
                                @endforeach
                            </div>
                            @error('selectedRoles') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </form>
                </div>

                <!-- Buttons - Fixed -->
                <div class="p-6 pt-0 flex justify-end gap-2 border-t dark:border-zinc-700 mt-2">
                    <button type="button" 
                            @click="open = false"
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 dark:border-zinc-700 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            form="user-form"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        {{ $user_id ? 'Update' : 'Create' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail.modal === 'delete-user-modal') open = true"
        @close-modal.window="if ($event.detail.modal === 'delete-user-modal') open = false"
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
                    Are you sure you want to delete user <strong class="font-semibold">{{ $userToDelete?->name }}</strong>? This action cannot be undone.
                </p>

                <div class="flex justify-center gap-3">
                    <button type="button"
                            @click="open = false" 
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 dark:border-zinc-700 transition-colors">
                        Cancel
                    </button>
                    <button type="button"
                            wire:click="delete" 
                            @click="open = false"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL BULK ACTION -->
    <div x-data="{ open: false, activeTab: 'assign' }" 
        x-show="open" 
        @open-modal.window="if ($event.detail.modal === 'bulk-action-modal') { open = true; activeTab = $wire.bulkActionType; }"
        @close-modal.window="if ($event.detail.modal === 'bulk-action-modal') open = false"
        x-cloak>
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
        
        <!-- Modal -->
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col">
                <!-- Header -->
                <div class="p-6 pb-0">
                    <h2 class="text-xl font-bold">Bulk Role Management</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Manage roles for {{ count($selectedUsers) }} selected user(s)
                    </p>
                </div>

                <!-- Tab Navigation -->
                <div class="px-6 pt-4 border-b dark:border-zinc-700">
                    <div class="flex gap-4">
                        <button type="button"
                                @click="activeTab = 'assign'; $wire.bulkActionType = 'assign'"
                                :class="{'text-blue-600 border-b-2 border-blue-600': activeTab === 'assign', 'text-gray-500 hover:text-gray-700': activeTab !== 'assign'}"
                                class="px-4 py-2 font-medium transition-colors">
                            Assign Roles
                        </button>
                        <button type="button"
                                @click="activeTab = 'remove'; $wire.bulkActionType = 'remove'"
                                :class="{'text-blue-600 border-b-2 border-blue-600': activeTab === 'remove', 'text-gray-500 hover:text-gray-700': activeTab !== 'remove'}"
                                class="px-4 py-2 font-medium transition-colors">
                            Remove Roles
                        </button>
                    </div>
                </div>

                <!-- Content -->
                <div class="overflow-y-auto p-6">
                    <!-- Selected Users List -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">
                            Selected Users ({{ count($selectedUsers) }})
                        </label>
                        <div class="max-h-32 overflow-y-auto border rounded-lg p-3 bg-gray-50 dark:bg-zinc-800 dark:border-zinc-700">
                            @php
                                $selectedUserNames = App\Models\User::whereIn('id', $selectedUsers)->pluck('name', 'id')->toArray();
                            @endphp
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($selectedUserNames as $id => $name)
                                    <div class="text-sm py-1 flex items-center gap-2">
                                        <flux:icon name="user" class="w-4 h-4 text-gray-400" />
                                        <span>{{ $name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Roles Selection -->
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            <span x-show="activeTab === 'assign'">Select Roles to Assign</span>
                            <span x-show="activeTab === 'remove'">Select Roles to Remove</span>
                        </label>
                        <div class="space-y-3 max-h-64 overflow-y-auto border rounded-lg p-4 dark:border-zinc-700">
                            @foreach($roles as $role)
                                <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 dark:hover:bg-zinc-800 p-2 rounded transition-colors">
                                    <input type="checkbox" 
                                        wire:model="bulkSelectedRoles" 
                                        value="{{ $role->name }}"
                                        class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-medium">{{ $role->name }}</span>
                                            @if($role->name === 'super-admin')
                                                <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded">Full Access</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            @if($role->name === 'super-admin')
                                                Complete system access with all permissions
                                            @elseif($role->name === 'admin')
                                                Administrative access with most permissions
                                            @else
                                                Standard user access with basic permissions
                                            @endif
                                        </p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('bulkSelectedRoles') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Warning Message -->
                    <div x-show="activeTab === 'assign'" class="mt-4 p-3 bg-blue-50 dark:bg-blue-950/30 rounded-lg">
                        <div class="flex items-start gap-2">
                            <flux:icon name="information-circle" class="w-5 h-5 text-blue-600 mt-0.5" />
                            <div class="text-sm text-blue-800 dark:text-blue-300">
                                <strong>Note:</strong> Assigning roles will add these roles to the selected users without removing their existing roles.
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTab === 'remove'" class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-950/30 rounded-lg">
                        <div class="flex items-start gap-2">
                            <flux:icon name="exclamation-triangle" class="w-5 h-5 text-yellow-600 mt-0.5" />
                            <div class="text-sm text-yellow-800 dark:text-yellow-300">
                                <strong>Warning:</strong> Removing roles will take away permissions from the selected users. This action cannot be undone.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="p-6 pt-0 flex justify-end gap-2 border-t dark:border-zinc-700 mt-2">
                    <button type="button"
                            @click="open = false"
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 dark:border-zinc-700 transition-colors">
                        Cancel
                    </button>
                    <button type="button"
                            x-show="activeTab === 'assign'"
                            wire:click="assignBulkRoles"
                            @click="open = false"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        Assign Selected Roles
                    </button>
                    <button type="button"
                            x-show="activeTab === 'remove'"
                            wire:click="removeBulkRoles"
                            @click="open = false"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Remove Selected Roles
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    <div x-data="{ show: false, message: '', type: 'success' }" 
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
         x-show="show"
         x-transition.duration.300ms
         :class="{
             'bg-green-500': type === 'success',
             'bg-red-500': type === 'error',
             'bg-yellow-500': type === 'warning'
         }"
         class="fixed bottom-4 right-4 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        <span x-text="message"></span>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>