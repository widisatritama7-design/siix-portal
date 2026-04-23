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
            Role
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Role Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage roles and their permissions
            </p>
        </div>
        
        <!-- Tombol Add Role -->
        <flux:button 
            variant="primary" 
            icon="plus" 
            class="bg-blue-600 hover:bg-blue-700"
            wire:click="resetForm"
            x-on:click="$dispatch('open-modal', 'role-form-modal')"
        >
            Add New Role
        </flux:button>
    </div>

    <!-- Search -->
    <div class="flex justify-end">
        <div class="w-full sm:w-64">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search roles..."
                icon="magnifying-glass"
                clearable
            />
        </div>
    </div>

    <!-- Roles Table -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Role</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Permissions</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Users Count</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($roles as $index => $role)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="role-{{ $role->id }}">
                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $roles->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full 
                                    @if($role->name == 'super-admin') bg-gradient-to-br from-purple-500 to-pink-600
                                    @elseif($role->name == 'admin') bg-gradient-to-br from-blue-500 to-cyan-600
                                    @else bg-gradient-to-br from-gray-500 to-slate-600
                                    @endif flex items-center justify-center text-white font-medium shadow-lg">
                                    {{ strtoupper(substr($role->name, 0, 1)) }}
                                </div>
                                <div>
                                    <span class="text-sm font-semibold text-zinc-800 dark:text-white block">
                                        {{ $role->name }}
                                    </span>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                        ID: #{{ $role->id }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-1 max-w-xs">
                                @forelse($role->permissions->take(3) as $permission)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                        {{ $permission->name }}
                                    </span>
                                @empty
                                    <span class="text-sm text-zinc-400">No permissions</span>
                                @endforelse
                                @if($role->permissions->count() > 3)
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                        +{{ $role->permissions->count() - 3 }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                {{ $role->users()->count() }} users
                            </span>
                        </td>
                        <!-- Actions Column -->
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <!-- Edit Button -->
                                @can('edit roles')
                                <flux:button 
                                    wire:click="edit({{ $role->id }})" 
                                    x-on:click="$dispatch('open-modal', 'role-form-modal')"
                                    size="sm"
                                    icon="pencil-square"
                                    class="!p-2 text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-950/50"
                                    title="Edit role"
                                />
                                @endcan

                                <!-- Delete Button -->
                                @can('delete roles')
                                    @if($role->users()->count() == 0) <!-- Tetap cek apakah role dipakai user -->
                                        <flux:button 
                                            wire:click="confirmDelete({{ $role->id }})" 
                                            x-on:click="$dispatch('open-modal', 'delete-role-modal')"
                                            size="sm"
                                            icon="trash"
                                            class="!p-2 text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/50"
                                            title="Delete role"
                                        />
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <flux:icon name="shield-check" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        No roles found
                                    </h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                        {{ $search ? 'Try adjusting your search query' : 'Get started by creating a new role' }}
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
                                        x-on:click="$dispatch('open-modal', 'role-form-modal')"
                                    >
                                        Add Your First Role
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
        @if($roles->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $roles->links() }}
        </div>
        @endif
    </flux:card>

    <!-- MODAL FORM ROLE -->
    <div x-data="{ 
        open: false,
        searchPermission: ''
    }" 
        x-show="open" 
        @open-modal.window="if ($event.detail === 'role-form-modal') open = true; searchPermission = ''"
        @close-modal.window="if ($event.detail === 'role-form-modal') open = false"
        x-cloak>
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
        
        <!-- Modal -->
        <div class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 md:p-6">
            <!-- Modal Container -->
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-2xl mx-auto flex flex-col" 
                style="max-height: calc(100vh - 2rem);">
                
                <!-- Header -->
                <div class="flex-shrink-0 p-4 sm:p-6 border-b dark:border-zinc-700">
                    <h2 class="text-lg sm:text-xl font-bold">{{ $modalTitle }}</h2>
                </div>

                <!-- Form Body - scrollable dengan scrollbar hidden -->
                <div class="flex-1 overflow-y-auto p-4 sm:p-6" 
                    style="scrollbar-width: none; -ms-overflow-style: none;">
                    <style>
                        .flex-1::-webkit-scrollbar {
                            display: none;
                        }
                    </style>
                    
                    <form wire:submit="save" id="role-form" class="space-y-5">
                        <!-- Role Name -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">Role Name</label>
                            <input type="text" 
                                wire:model="name"
                                class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base">
                            @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Permissions Section -->
                        <div>
                            <div class="flex items-center justify-between mb-2 flex-wrap gap-2">
                                <label class="block text-sm font-medium">Permissions</label>
                                <span class="text-xs text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-zinc-800 px-2 py-0.5 rounded-full" 
                                    x-text="`${$wire.selectedPermissions?.length || 0} selected`"></span>
                            </div>
                            
                            <!-- Search Input -->
                            <div class="relative mb-3">
                                <input type="text" 
                                    x-model="searchPermission"
                                    placeholder="Search permissions..."
                                    class="w-full px-3 py-2 pl-9 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <button type="button" 
                                        x-show="searchPermission"
                                        @click="searchPermission = ''"
                                        class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Permissions List with Scroll (scrollbar hidden) -->
                            <div class="border rounded-lg overflow-y-auto" 
                                style="max-height: min(400px, calc(100vh - 350px)); scrollbar-width: none; -ms-overflow-style: none;">
                                <style>
                                    .border.rounded-lg.overflow-y-auto::-webkit-scrollbar {
                                        display: none;
                                    }
                                </style>
                                <div class="space-y-4 p-3 sm:p-4">
                                    @foreach($permissions as $group => $groupPermissions)
                                        @php
                                            $permissionNames = $groupPermissions->pluck('name')->toArray();
                                            $permissionNamesJson = json_encode($permissionNames);
                                        @endphp
                                        
                                        <!-- Group dengan filter pencarian -->
                                        <div x-show="`{{ $group }}`.toLowerCase().includes(searchPermission.toLowerCase()) || 
                                                    {{ json_encode($groupPermissions->pluck('name')->toArray()) }}.some(p => p.toLowerCase().includes(searchPermission.toLowerCase()))">
                                            <div class="flex items-center justify-between mb-2 flex-wrap gap-2">
                                                <h3 class="font-medium capitalize text-sm">{{ $group }} Management</h3>
                                                <button type="button" 
                                                        x-on:click="
                                                            let currentSelected = $wire.selectedPermissions || [];
                                                            let groupPerms = {{ $permissionNamesJson }};
                                                            let allSelected = groupPerms.every(p => currentSelected.includes(p));
                                                            
                                                            if (allSelected) {
                                                                $wire.selectedPermissions = currentSelected.filter(p => !groupPerms.includes(p));
                                                            } else {
                                                                let newPerms = [...currentSelected];
                                                                groupPerms.forEach(p => {
                                                                    if (!newPerms.includes(p)) newPerms.push(p);
                                                                });
                                                                $wire.selectedPermissions = newPerms;
                                                            }
                                                        "
                                                        class="text-xs px-2 py-1 rounded bg-gray-100 hover:bg-gray-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-blue-600 dark:text-blue-400 transition">
                                                    <span x-text="(() => {
                                                        let currentSelected = $wire.selectedPermissions || [];
                                                        let groupPerms = {{ $permissionNamesJson }};
                                                        return groupPerms.every(p => currentSelected.includes(p)) ? 'Uncheck All' : 'Check All';
                                                    })()"></span>
                                                </button>
                                            </div>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                @foreach($groupPermissions as $permission)
                                                    <label class="flex items-center gap-2 p-1.5 rounded hover:bg-gray-50 dark:hover:bg-zinc-800 cursor-pointer transition"
                                                        x-show="`{{ $permission->name }}`.toLowerCase().includes(searchPermission.toLowerCase()) || 
                                                                    `{{ $group }}`.toLowerCase().includes(searchPermission.toLowerCase())">
                                                        <input type="checkbox" 
                                                            wire:model.live="selectedPermissions" 
                                                            value="{{ $permission->name }}"
                                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-4 h-4">
                                                        <span class="text-xs sm:text-sm break-words">{{ $permission->name }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    <!-- Empty state -->
                                    <div x-show="searchPermission && ![...document.querySelectorAll('[x-show]')].some(el => el.style.display !== 'none')" 
                                        class="text-center py-8 text-gray-500 dark:text-gray-400">
                                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-sm">No permissions found for "<span x-text="searchPermission"></span>"</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="flex-shrink-0 p-4 sm:p-6 border-t dark:border-zinc-700 bg-white dark:bg-zinc-900 rounded-b-xl">
                    <div class="flex justify-end gap-2">
                        <button type="button" 
                                @click="open = false"
                                class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition text-sm sm:text-base">
                            Cancel
                        </button>
                        <button type="submit" 
                                form="role-form"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm sm:text-base">
                            {{ $role_id ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE ROLE -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'delete-role-modal') open = true"
         @close-modal.window="if ($event.detail === 'delete-role-modal') open = false"
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
                
                <h3 class="text-lg font-bold mb-2">Delete Role</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Are you sure you want to delete role "{{ $roleToDelete?->name }}"? This action cannot be undone.
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