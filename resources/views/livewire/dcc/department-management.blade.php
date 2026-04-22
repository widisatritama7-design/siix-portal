<div class="p-1 space-y-2">
    @section('title', 'Department Management - DCC Control Panel')
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            DCC
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Department
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Department Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage departments for DCC submissions
            </p>
        </div>

        <!-- Tombol Add Department -->
        @can('create departments')
        <flux:button 
            variant="primary" 
            icon="plus" 
            class="bg-blue-600 hover:bg-blue-700"
            wire:click="resetForm"
            x-on:click="$dispatch('open-modal', 'department-form-modal')"
        >
            Add New Department
        </flux:button>
        @endcan
    </div>

    <!-- Search -->
    <div class="flex justify-end">
        <div class="w-full sm:w-64">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search departments..."
                icon="magnifying-glass"
                clearable
            />
        </div>
    </div>

    <!-- Departments Table -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Department</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Emails</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Submissions</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Created By</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($departments as $index => $department)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="department-{{ $department->id }}">
                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $departments->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white font-medium shadow-lg">
                                    {{ strtoupper(substr($department->dept_name, 0, 1)) }}
                                </div>
                                <div>
                                    <span class="text-sm font-semibold text-zinc-800 dark:text-white block">
                                        {{ $department->dept_name }}
                                    </span>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                        ID: #{{ $department->id }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-1 max-w-xs">
                                @php
                                    $emailList = [];
                                    $rawEmails = $department->emails ?? '';
                                    
                                    if (!empty($rawEmails)) {
                                        // Jika berupa string JSON
                                        if (is_string($rawEmails)) {
                                            $trimmed = trim($rawEmails);
                                            // Cek apakah string dimulai dengan [ atau { (JSON)
                                            if (str_starts_with($trimmed, '[') || str_starts_with($trimmed, '{')) {
                                                try {
                                                    $decoded = json_decode($rawEmails, true);
                                                    if (is_array($decoded)) {
                                                        $emailList = $decoded;
                                                    } else {
                                                        $emailList = array_map('trim', explode(',', $rawEmails));
                                                    }
                                                } catch (\Exception $e) {
                                                    // Jika gagal decode JSON, treat as regular string
                                                    $emailList = array_map('trim', explode(',', $rawEmails));
                                                }
                                            } else {
                                                // Regular string with commas
                                                $emailList = array_map('trim', explode(',', $rawEmails));
                                            }
                                        } elseif (is_array($rawEmails)) {
                                            // Jika sudah array
                                            $emailList = $rawEmails;
                                        } elseif (is_object($rawEmails) && method_exists($rawEmails, 'toArray')) {
                                            // Jika collection atau object lain
                                            $emailList = $rawEmails->toArray();
                                        }
                                    }
                                    
                                    // Bersihkan array: hapus nilai kosong dan reset index
                                    $emailList = array_values(array_filter($emailList, function($item) {
                                        return !empty($item) && is_string($item);
                                    }));
                                    
                                    // Jika masih ada string yang merupakan representasi array, parse lagi
                                    $tempList = [];
                                    foreach ($emailList as $item) {
                                        $trimmedItem = trim($item);
                                        if (str_starts_with($trimmedItem, '[') || str_starts_with($trimmedItem, '{')) {
                                            try {
                                                $decoded = json_decode($item, true);
                                                if (is_array($decoded)) {
                                                    foreach ($decoded as $subItem) {
                                                        if (!empty($subItem) && is_string($subItem)) {
                                                            $tempList[] = trim($subItem, '[]"\' ');
                                                        }
                                                    }
                                                } else {
                                                    $tempList[] = trim($item, '[]"\' ');
                                                }
                                            } catch (\Exception $e) {
                                                $tempList[] = trim($item, '[]"\' ');
                                            }
                                        } else {
                                            $tempList[] = trim($item, '[]"\' ');
                                        }
                                    }
                                    
                                    $emailList = array_values(array_filter($tempList));
                                    
                                    // Filter email valid
                                    $validEmails = array_filter($emailList, function($email) {
                                        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
                                    });
                                    
                                    // Jika tidak ada email valid, gunakan semua yang ada
                                    $displayEmails = !empty($validEmails) ? $validEmails : $emailList;
                                @endphp

                                @if(!empty($displayEmails))
                                    @foreach($displayEmails as $email)
                                        @if(!empty($email))
                                            <flux:badge size="sm" color="blue" class="text-xs">
                                                {{ $email }}
                                            </flux:badge>
                                        @endif
                                    @endforeach
                                @else
                                    <span class="text-sm text-zinc-400">No emails</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <flux:badge size="sm" color="purple">
                                {{ $department->submissions()->count() }} submissions
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm">
                                <div>{{ $department->creator->name ?? 'N/A' }}</div>
                                <div class="text-xs text-zinc-500">{{ $department->created_at->format('d M Y') }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                @can('edit departments')
                                <flux:button 
                                    wire:click="edit({{ $department->id }})" 
                                    x-on:click="$dispatch('open-modal', 'department-form-modal')"
                                    size="sm"
                                    icon="pencil-square"
                                    variant="primary"
                                    color="yellow"
                                    class="!p-2"
                                    title="Edit department"
                                />
                                @endcan

                                @can('delete departments')
                                    <flux:button 
                                        wire:click="confirmDelete({{ $department->id }})" 
                                        x-on:click="$dispatch('open-modal', 'delete-department-modal')"
                                        size="sm"
                                        icon="trash"
                                        variant="primary"
                                        color="red"
                                        class="!p-2"
                                        title="Delete department"
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
                                    <flux:icon name="building-office" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        No departments found
                                    </h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                        {{ $search ? 'Try adjusting your search query' : 'Get started by creating a new department' }}
                                    </p>
                                </div>
                                @if($search)
                                    <flux:button wire:click="$set('search', '')" size="sm">
                                        Clear Search
                                    </flux:button>
                                @else
                                    @can('create departments')
                                    <flux:button 
                                        variant="primary" 
                                        size="sm"
                                        wire:click="resetForm"
                                        x-on:click="$dispatch('open-modal', 'department-form-modal')"
                                    >
                                        Add Your First Department
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
        @if($departments->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $departments->links() }}
        </div>
        @endif
    </flux:card>

    <!-- MODAL FORM DEPARTMENT -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'department-form-modal') open = true"
         @close-modal.window="if ($event.detail === 'department-form-modal') open = false"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                    <form wire:submit="save">
                        <!-- Department Name -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Department Name</label>
                            <input type="text" 
                                   wire:model="dept_name"
                                   class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            @error('dept_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Emails -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Email Addresses</label>

                            <!-- List of added emails -->
                            @if(count($emails) > 0)
                                <div class="mb-2 flex flex-wrap gap-1">
                                    @foreach($emails as $index => $email)
                                        @if(!empty($email))
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs rounded-full">
                                                {{ $email }}
                                                <button type="button" 
                                                        wire:click="removeEmail({{ $index }})" 
                                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 ml-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            <!-- Add email input -->
                            <div class="flex gap-2">
                                <input type="email" 
                                       wire:model="email_input"
                                       wire:keydown.enter.prevent="addEmail"
                                       placeholder="Enter email address"
                                       class="flex-1 px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <button type="button" 
                                        wire:click="addEmail"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Add
                                </button>
                            </div>
                            <p class="text-xs text-zinc-500 mt-1">Press Enter or click Add to add multiple emails</p>
                            
                            @error('email_input') 
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                            @enderror
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
                                {{ $department_id ? 'Update' : 'Create' }}
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
         @open-modal.window="if ($event.detail === 'delete-department-modal') open = true"
         @close-modal.window="if ($event.detail === 'delete-department-modal') open = false"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>

                <h3 class="text-lg font-bold mb-2">Delete Department</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Are you sure you want to delete department "{{ $departmentToDelete?->dept_name }}"? This action cannot be undone.
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