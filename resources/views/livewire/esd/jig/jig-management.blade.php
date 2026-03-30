{{-- resources/views/livewire/esd/jig/jig-management.blade.php --}}
<section class="w-full">
    @include('partials.esd-heading')

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge - Jig') }}
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
                        Jig
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                    Jig
                </h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    Manage ESD Jigs
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
                        placeholder="Search by register number, model, customer, or description..."
                        icon="magnifying-glass"
                        clearable
                    />
                </div>

                <!-- View All History 20% -->
                <div class="w-full sm:w-[20%]">
                    <flux:button 
                        href="#"
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
                    @can('create jig')
                    <flux:button 
                        variant="primary" 
                        icon="plus" 
                        class="bg-blue-600 hover:bg-blue-700 whitespace-nowrap w-full justify-center"
                        wire:click="resetForm"
                        x-on:click="$dispatch('open-modal', 'jig-form-modal')"
                    >
                        Add New
                    </flux:button>
                    @endcan
                </div>
            </div>

            <!-- Jigs Table -->
            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-16">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[120px]">Register No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Model</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Customer</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Tooling Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Jig Qty</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[100px]">Total Measurements</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider min-w-[150px]">Created By</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($jigs as $index => $jig)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="jig-{{ $jig->id }}">
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $jigs->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center text-white font-medium shadow-lg flex-shrink-0">
                                            {{ strtoupper(substr($jig->register_no, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <span class="text-sm font-semibold text-zinc-800 dark:text-white block truncate max-w-[200px]" title="{{ $jig->register_no }}">
                                                {{ $jig->register_no }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300 block truncate max-w-[200px]" title="{{ $jig->model }}">
                                        {{ $jig->model ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300 block truncate max-w-[200px]" title="{{ $jig->customer }}">
                                        {{ $jig->customer ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $jig->tooling_type ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $jig->category ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $jig->jig_qty ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusConfig = [
                                            'Active' => [
                                                'label' => 'Active',
                                                'color' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                            ],
                                            'Inactive' => [
                                                'label' => 'Inactive',
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
                                        $status = $statusConfig[$jig->status] ?? [
                                            'label' => ucfirst(str_replace('_', ' ', $jig->status)),
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
                                            {{ $jig->jigDetails()->count() }}
                                        </span>
                                        <span class="text-xs text-zinc-500">Records</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm min-w-0">
                                        <div class="truncate max-w-[150px]" title="{{ $jig->creator->name ?? 'N/A' }}">
                                            {{ $jig->creator->name ?? 'N/A' }}
                                        </div>
                                        <div class="text-xs text-zinc-500 whitespace-nowrap">
                                            {{ $jig->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                        @can('view jig')
                                        <flux:button 
                                            href="#"
                                            wire:navigate
                                            size="sm"
                                            icon="eye"
                                            variant="primary"
                                            color="blue"
                                            class="!p-2 flex-shrink-0"
                                            title="View jig details"
                                        />
                                        @endcan
                                        @can('edit jig')
                                        <flux:button 
                                            wire:click="edit({{ $jig->id }})" 
                                            x-on:click="$dispatch('open-modal', 'jig-form-modal')"
                                            size="sm"
                                            icon="pencil-square"
                                            variant="primary"
                                            color="yellow"
                                            class="!p-2 flex-shrink-0"
                                            title="Edit jig"
                                        />
                                        @endcan

                                        @can('delete jig')
                                            <flux:button 
                                                wire:click="confirmDelete({{ $jig->id }})" 
                                                x-on:click="$dispatch('open-modal', 'delete-jig-modal')"
                                                size="sm"
                                                icon="trash"
                                                variant="primary"
                                                color="red"
                                                class="!p-2 flex-shrink-0"
                                                title="Delete jig"
                                            />
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <flux:icon name="square-3-stack-3d" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No jig records found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                                {{ $search ? 'Try adjusting your search query' : 'Get started by creating a new jig record' }}
                                            </p>
                                        </div>
                                        @if($search)
                                            <flux:button wire:click="$set('search', '')" size="sm">
                                                Clear Search
                                            </flux:button>
                                        @else
                                            @can('create jig')
                                            <flux:button 
                                                variant="primary" 
                                                size="sm"
                                                wire:click="resetForm"
                                                x-on:click="$dispatch('open-modal', 'jig-form-modal')"
                                            >
                                                Add Your First Jig
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
                @if($jigs->hasPages())
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $jigs->links() }}
                </div>
                @endif
            </flux:card>

            <!-- MODAL FORM JIG -->
            <div x-data="{ open: false }" 
                 x-show="open" 
                 @open-modal.window="if ($event.detail === 'jig-form-modal') open = true"
                 @close-modal.window="if ($event.detail === 'jig-form-modal') open = false"
                 x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                            <form wire:submit="save" enctype="multipart/form-data">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Register No -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Register No <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model="register_no" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('register_no') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Received Date -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Received Date</label>
                                        <input type="date" wire:model="received_date" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('received_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Registration Date -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Registration Date</label>
                                        <input type="date" wire:model="registration_date" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('registration_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- SEK/Cust ID -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">SEK/Cust ID</label>
                                        <input type="text" wire:model="sek_cust_id" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('sek_cust_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Fabricator -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Fabricator</label>
                                        <input type="text" wire:model="fabricator" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('fabricator') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Model -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Model</label>
                                        <input type="text" wire:model="model" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('model') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-4 md:col-span-2">
                                        <label class="block text-sm font-medium mb-1">Description</label>
                                        <textarea wire:model="description" rows="2" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700"></textarea>
                                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Application -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Application</label>
                                        <input type="text" wire:model="application" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('application') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Pin Qty -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Pin Quantity</label>
                                        <input type="number" wire:model="pin_qty" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('pin_qty') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Jig Qty -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Jig Quantity</label>
                                        <input type="number" wire:model="jig_qty" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('jig_qty') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Customer -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Customer</label>
                                        <input type="text" wire:model="customer" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('customer') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Tooling Type -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Tooling Type</label>
                                        <input type="text" wire:model="tooling_type" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('tooling_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Category -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Category</label>
                                        <input type="text" wire:model="category" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Location -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Location</label>
                                        <input type="text" wire:model="location" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Bit Size -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Bit Size</label>
                                        <input type="text" wire:model="bit_size" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('bit_size') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Rack -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Rack</label>
                                        <input type="text" wire:model="rack" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('rack') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Rack Number -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Rack Number</label>
                                        <input type="text" wire:model="rack_number" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('rack_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Line Name -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Line Name</label>
                                        <input type="text" wire:model="line_name" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('line_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Count Stencil -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Count Stencil</label>
                                        <input type="text" wire:model="count_stencil" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('count_stencil') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Amount Solder -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Amount Solder</label>
                                        <input type="text" wire:model="amount_solder" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('amount_solder') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- NIK -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">NIK</label>
                                        <input type="text" wire:model="nik" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('nik') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Design By -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Design By</label>
                                        <input type="text" wire:model="design_by" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('design_by') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Qualified Date -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Qualified Date</label>
                                        <input type="date" wire:model="qualified_date" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('qualified_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Results -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Results</label>
                                        <input type="text" wire:model="results" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @error('results') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-1">Status <span class="text-red-500">*</span></label>
                                        <select wire:model="status" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                            <option value="Under Repair">Under Repair</option>
                                            <option value="Damage">Damage</option>
                                            <option value="Disposed">Disposed</option>
                                        </select>
                                        @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Photo -->
                                    <div class="mb-4 md:col-span-2">
                                        <label class="block text-sm font-medium mb-1">Photo</label>
                                        <input type="file" wire:model="photo" accept="image/*" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                        @if($existingPhoto && is_array($existingPhoto))
                                            <div class="mt-2">
                                                <img src="{{ Storage::url($existingPhoto[0]) }}" class="h-20 w-20 object-cover rounded-lg">
                                            </div>
                                        @endif
                                        @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Remarks -->
                                    <div class="mb-4 md:col-span-2">
                                        <label class="block text-sm font-medium mb-1">Remarks</label>
                                        <textarea wire:model="remarks" rows="3" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700"></textarea>
                                        @error('remarks') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="flex justify-end gap-2 mt-6">
                                    <button type="button" @click="open = false" class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                        {{ $jig_id ? 'Update' : 'Create' }}
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
                 @open-modal.window="if ($event.detail === 'delete-jig-modal') open = true"
                 @close-modal.window="if ($event.detail === 'delete-jig-modal') open = false"
                 x-cloak>

                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>

                        <h3 class="text-lg font-bold mb-2">Delete Jig</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Are you sure you want to delete jig "{{ $jigToDelete?->register_no }}"? This action cannot be undone.
                        </p>

                        <div class="flex justify-center gap-3">
                            <button @click="open = false" class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800">
                                Cancel
                            </button>
                            <button wire:click="delete" @click="open = false" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
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