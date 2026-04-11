<section class="w-full">
    @include('partials.mtc-heading')

    <flux:heading class="sr-only">
        {{ __('MTC - Master Area Management') }}
    </flux:heading>

    <x-mtc.layout 
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
                        Master Area
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                    Master Area
                </h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    Manage Area master data for MTC
                </p>
            </div>
        </x-slot>
        
        <div class="-mt-2">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row gap-3 mt-2 mb-6">
                <!-- Search 70% -->
                <div class="w-full sm:w-[70%]">
                    <flux:input
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search by area name..."
                        icon="magnifying-glass"
                        clearable
                    />
                </div>

                <!-- Add New 30% -->
                <div class="w-full sm:w-[30%]">
                    @can('create master area')
                    <flux:button 
                        variant="primary" 
                        icon="plus" 
                        class="bg-blue-600 hover:bg-blue-700 whitespace-nowrap w-full justify-center"
                        wire:click="resetForm"
                        x-on:click="$dispatch('open-modal', 'area-form-modal')"
                    >
                        Add New Area
                    </flux:button>
                    @endcan
                </div>
            </div>

            <!-- Areas Table -->
            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-16">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[200px]">Area Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">Total Locations</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Created By</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Last Updated By</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Created At</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($areas as $index => $area)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="area-{{ $area->id }}">
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $areas->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white font-medium shadow-lg flex-shrink-0">
                                            {{ strtoupper(substr($area->area_name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <span class="text-sm font-semibold text-zinc-800 dark:text-white block truncate max-w-[300px]" title="{{ $area->area_name }}">
                                                {{ $area->area_name }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <flux:icon name="map-pin" class="w-4 h-4 text-green-500" />
                                        <span class="text-sm font-semibold text-zinc-800 dark:text-white">
                                            {{ $area->locations()->count() }}
                                        </span>
                                        <span class="text-xs text-zinc-500">Locations</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm min-w-0">
                                        <div class="truncate max-w-[150px]" title="{{ $area->creator->name ?? 'N/A' }}">
                                            {{ $area->creator->name ?? 'N/A' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm min-w-0">
                                        <div class="truncate max-w-[150px]" title="{{ $area->updater->name ?? 'N/A' }}">
                                            {{ $area->updater->name ?? 'N/A' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $area->created_at->format('d M Y H:i') }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1 whitespace-nowrap">

                                        @can('edit master area')
                                        <flux:button 
                                            wire:click="edit({{ $area->id }})" 
                                            x-on:click="$dispatch('open-modal', 'area-form-modal')"
                                            size="sm"
                                            icon="pencil-square"
                                            variant="primary"
                                            color="yellow"
                                            class="!p-2 flex-shrink-0"
                                            title="Edit area"
                                        />
                                        @endcan

                                        @can('delete master area')
                                            <flux:button 
                                                wire:click="confirmDelete({{ $area->id }})" 
                                                x-on:click="$dispatch('open-modal', 'delete-area-modal')"
                                                size="sm"
                                                icon="trash"
                                                variant="primary"
                                                color="red"
                                                class="!p-2 flex-shrink-0"
                                                title="Delete area"
                                            />
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <flux:icon name="square-3-stack-3d" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No area records found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                                {{ $search ? 'Try adjusting your search query' : 'Get started by creating a new area record' }}
                                            </p>
                                        </div>
                                        @if($search)
                                            <flux:button wire:click="$set('search', '')" size="sm">
                                                Clear Search
                                            </flux:button>
                                        @else
                                            @can('create master area')
                                            <flux:button 
                                                variant="primary" 
                                                size="sm"
                                                wire:click="resetForm"
                                                x-on:click="$dispatch('open-modal', 'area-form-modal')"
                                            >
                                                Add Your First Area
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
                @if($areas->hasPages())
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $areas->links() }}
                </div>
                @endif
            </flux:card>

            <!-- MODAL FORM AREA -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-modal.window="if ($event.detail === 'area-form-modal') open = true"
                 @close-modal.window="if ($event.detail === 'area-form-modal') open = false"
                 x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                            <form wire:submit="save">
                                <!-- Area Name -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Area Name <span class="text-red-500">*</span></label>
                                    <input type="text" 
                                        wire:model="area_name"
                                        class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Enter area name">
                                    @error('area_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
                                        {{ $area_id ? 'Update' : 'Create' }}
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
                 @open-modal.window="if ($event.detail === 'delete-area-modal') open = true"
                 @close-modal.window="if ($event.detail === 'delete-area-modal') open = false"
                 x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>

                        <h3 class="text-lg font-bold mb-2">Delete Area</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-2">
                            Are you sure you want to delete area <strong>"{{ $areaToDelete?->area_name }}"</strong>?
                        </p>
                        @if($areaToDelete && $areaToDelete->locations()->count() > 0)
                            <p class="text-yellow-600 dark:text-yellow-400 text-sm mb-4">
                                ⚠️ Warning: This area has {{ $areaToDelete->locations()->count() }} location(s) associated with it.
                            </p>
                        @else
                            <p class="text-gray-600 dark:text-gray-400 mb-6">
                                This action cannot be undone.
                            </p>
                        @endif

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
    </x-mtc.layout>
</section>