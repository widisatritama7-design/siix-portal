{{-- resources/views/livewire/esd/gb/ground-monitor-box-management.blade.php --}}
<section class="w-full">
    @include('partials.esd-heading')

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge - Ground Monitor Box') }}
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
                        Ground Monitor Box
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                    Ground Monitor Box
                </h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    Manage Ground Monitor Box for ESD Check
                </p>
            </div>
        </x-slot>
        
        <div class="-mt-2">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row gap-3 mt-2 mb-6">
                <!-- Search 60% -->
                <div class="w-full sm:w-[60%]">
                    <flux:input
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search by register number, area, or location..."
                        icon="magnifying-glass"
                        clearable
                    />
                </div>

                <!-- View All History 20% -->
                <div class="w-full sm:w-[20%]">
                    <flux:button 
                        href="{{ route('esd.ground-monitor-box-details')}}"
                        wire:navigate
                        icon="arrow-right"
                        variant="primary"
                        color="green"
                        class="w-full justify-center"
                    >
                        View All History
                    </flux:button>
                </div>

                <!-- Add New 20% -->
                <div class="w-full sm:w-[20%]">
                    @can('create ground monitor box')
                    <flux:button 
                        variant="primary" 
                        icon="plus" 
                        class="bg-blue-600 hover:bg-blue-700 whitespace-nowrap w-full justify-center"
                        wire:click="resetForm"
                        x-on:click="$dispatch('open-modal', 'ground-monitor-box-form-modal')"
                    >
                        Add New
                    </flux:button>
                    @endcan
                </div>
            </div>

            <!-- Ground Monitor Boxes Table -->
            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-16">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Register No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Area</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Location</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Total Measurements</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Created By</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($groundMonitorBoxes as $index => $groundMonitorBox)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="ground-monitor-box-{{ $groundMonitorBox->id }}">
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $groundMonitorBoxes->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white font-medium shadow-lg flex-shrink-0">
                                            {{ strtoupper(substr($groundMonitorBox->register_no, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <span class="text-sm font-semibold text-zinc-800 dark:text-white block truncate max-w-[200px]" title="{{ $groundMonitorBox->register_no }}">
                                                {{ $groundMonitorBox->register_no }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300 block truncate max-w-[150px]" title="{{ $groundMonitorBox->area }}">
                                        {{ $groundMonitorBox->area }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300 block truncate max-w-[150px]" title="{{ $groundMonitorBox->location }}">
                                        {{ $groundMonitorBox->location }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusConfig = [
                                            'In Use' => [
                                                'label' => 'In Use',
                                                'color' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                            ],
                                            'Not In Use' => [
                                                'label' => 'Not In Use',
                                                'color' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
                                            ],
                                            'Under Repair' => [
                                                'label' => 'Under Repair',
                                                'color' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                            ],
                                            'Damage' => [
                                                'label' => 'Damage',
                                                'color' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                            ],
                                            'Disposed' => [
                                                'label' => 'Disposed',
                                                'color' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                            ],
                                        ];
                                        $status = $statusConfig[$groundMonitorBox->status] ?? [
                                            'label' => ucfirst(str_replace('_', ' ', $groundMonitorBox->status)),
                                            'color' => 'bg-gray-100 text-gray-800',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status['color'] }} whitespace-nowrap">
                                        {{ $status['label'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <flux:icon name="document-chart-bar" class="w-4 h-4 text-blue-500" />
                                        <span class="text-sm font-semibold text-zinc-800 dark:text-white">
                                            {{ $groundMonitorBox->groundMonitorBoxDetails()->count() }}
                                        </span>
                                        <span class="text-xs text-zinc-500">Records</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm min-w-0">
                                        <div class="truncate max-w-[150px]" title="{{ $groundMonitorBox->creator->name ?? 'N/A' }}">
                                            {{ $groundMonitorBox->creator->name ?? 'N/A' }}
                                        </div>
                                        <div class="text-xs text-zinc-500 whitespace-nowrap">
                                            {{ $groundMonitorBox->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                        @can('view ground monitor box')
                                        <flux:button 
                                            href="{{ route('esd.ground-monitor-boxs.show', $groundMonitorBox->id) }}"
                                            wire:navigate
                                            size="sm"
                                            icon="eye"
                                            variant="primary"
                                            color="blue"
                                            class="!p-2 flex-shrink-0"
                                            title="View ground monitor box details"
                                        />
                                        @endcan
                                        @can('edit ground monitor box')
                                        <flux:button 
                                            wire:click="edit({{ $groundMonitorBox->id }})" 
                                            x-on:click="$dispatch('open-modal', 'ground-monitor-box-form-modal')"
                                            size="sm"
                                            icon="pencil-square"
                                            variant="primary"
                                            color="yellow"
                                            class="!p-2 flex-shrink-0"
                                            title="Edit ground monitor box"
                                        />
                                        @endcan

                                        @can('delete ground monitor box')
                                            <flux:button 
                                                wire:click="confirmDelete({{ $groundMonitorBox->id }})" 
                                                x-on:click="$dispatch('open-modal', 'delete-ground-monitor-box-modal')"
                                                size="sm"
                                                icon="trash"
                                                variant="primary"
                                                color="red"
                                                class="!p-2 flex-shrink-0"
                                                title="Delete ground monitor box"
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
                                                No ground monitor box records found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                                {{ $search ? 'Try adjusting your search query' : 'Get started by creating a new ground monitor box record' }}
                                            </p>
                                        </div>
                                        @if($search)
                                            <flux:button wire:click="$set('search', '')" size="sm">
                                                Clear Search
                                            </flux:button>
                                        @else
                                            @can('create ground monitor box')
                                            <flux:button 
                                                variant="primary" 
                                                size="sm"
                                                wire:click="resetForm"
                                                x-on:click="$dispatch('open-modal', 'ground-monitor-box-form-modal')"
                                            >
                                                Add Your First Ground Monitor Box
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
                @if($groundMonitorBoxes->hasPages())
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $groundMonitorBoxes->links() }}
                </div>
                @endif
            </flux:card>

            <!-- MODAL FORM GROUND MONITOR BOX -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-modal.window="if ($event.detail === 'ground-monitor-box-form-modal') open = true"
                 @close-modal.window="if ($event.detail === 'ground-monitor-box-form-modal') open = false"
                 x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                            <form wire:submit="save">
                                <!-- Register No -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Register Number <span class="text-red-500">*</span></label>
                                    <input type="text" 
                                           wire:model="register_no"
                                           class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    @error('register_no') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Area -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Area <span class="text-red-500">*</span></label>
                                    <input type="text" 
                                           wire:model="area"
                                           class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    @error('area') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Location -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Location <span class="text-red-500">*</span></label>
                                    <input type="text" 
                                           wire:model="location"
                                           class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Status -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Status <span class="text-red-500">*</span></label>
                                    <select wire:model="status"
                                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="In Use">In Use</option>
                                        <option value="Not In Use">Not In Use</option>
                                        <option value="Under Repair">Under Repair</option>
                                        <option value="Damage">Damage</option>
                                        <option value="Disposed">Disposed</option>
                                    </select>
                                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
                                        {{ $ground_monitor_box_id ? 'Update' : 'Create' }}
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
                 @open-modal.window="if ($event.detail === 'delete-ground-monitor-box-modal') open = true"
                 @close-modal.window="if ($event.detail === 'delete-ground-monitor-box-modal') open = false"
                 x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>

                        <h3 class="text-lg font-bold mb-2">Delete Ground Monitor Box</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Are you sure you want to delete ground monitor box "{{ $groundMonitorBoxToDelete?->register_no }}"? This action cannot be undone.
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