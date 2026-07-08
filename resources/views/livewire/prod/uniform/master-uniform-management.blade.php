<div class="p-1 space-y-2">
    @section('title', 'Master Uniform - Production Control Panel')
    
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            HR
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Uniform
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Master Uniform
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Master Uniform
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage uniform master data and stock
            </p>
        </div>

        <div class="flex gap-2">
            @can('create master uniform')
                <flux:button 
                    variant="primary" 
                    icon="plus" 
                    class="bg-blue-600 hover:bg-blue-700"
                    wire:click="resetForm"
                    x-on:click="$dispatch('open-modal', 'uniform-form-modal')"
                >
                    Add New Uniform
                </flux:button>
            @endcan
            
            @can('edit master uniform')
                <flux:button 
                    variant="primary" 
                    icon="shopping-bag" 
                    class="bg-teal-600 hover:bg-teal-700"
                    href="{{ route('prod.uniform.stock.manage') }}"
                    wire:navigate
                >
                    Stock Management
                </flux:button>
            @endcan
            @can('edit master uniform')
                <flux:button 
                    variant="primary" 
                    icon="shopping-bag" 
                    class="bg-yellow-600 hover:bg-yellow-700"
                    href="{{ route('prod.uniform.stock.transactions') }}"
                    wire:navigate
                >
                    All Transaction
                </flux:button>
            @endcan
        </div>
    </div>

    <!-- Search -->
    <div class="flex justify-end">
        <div class="w-full sm:w-64">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search by code, description, or size..."
                icon="magnifying-glass"
                clearable
            />
        </div>
    </div>

    <!-- Uniforms Table -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
        <!-- Per Page Selector & Total Info -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
            <div class="flex items-center gap-2">
                <span class="text-sm text-zinc-500 dark:text-zinc-400">Show</span>
                <select wire:model.live="perPage" 
                    class="px-2 py-1 text-sm border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="all">All</option>
                </select>
                <span class="text-sm text-zinc-500 dark:text-zinc-400">entries</span>
                <span class="text-sm text-zinc-500 dark:text-zinc-400 ml-2">
                    Total: <strong>{{ $uniforms->total() ?? count($uniforms) }}</strong> item(s)
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Item Code</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Description</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Size</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Price (IDR)</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Stock</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($uniforms as $index => $uniform)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="uniform-{{ $uniform->id }}">
                        <td class="px-4 py-3 text-center text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $uniforms->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <div>
                                    <span class="text-sm font-semibold text-zinc-800 dark:text-white block">
                                        {{ $uniform->item_code }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-left">
                            <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                {{ $uniform->description }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <flux:badge size="sm" color="purple">
                                {{ $uniform->size }}
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="text-sm font-semibold text-green-600 dark:text-green-400">
                                {{ $uniform->formatted_price }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <span class="text-sm font-semibold {{ $uniform->qty <= 5 ? 'text-red-600 dark:text-red-400' : 'text-blue-600 dark:text-blue-400' }}">
                                    {{ $uniform->qty }}
                                </span>
                                @if($uniform->qty <= 5 && $uniform->qty > 0)
                                    <flux:badge size="xs" color="red">Low Stock</flux:badge>
                                @elseif($uniform->qty == 0)
                                    <flux:badge size="xs" color="red">Out of Stock</flux:badge>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-1 flex-wrap">
                                <!-- History Button -->
                                <flux:tooltip content="View History" position="bottom">
                                    <flux:button 
                                        wire:click="openHistoryModal({{ $uniform->id }})"
                                        x-on:click="$dispatch('open-modal', 'history-modal')"
                                        size="sm"
                                        icon="clock"
                                        variant="primary"
                                        color="gray"
                                        class="!p-2"
                                        title="View History"
                                    />
                                </flux:tooltip>

                                <!-- Stock In Button -->
                                @can('edit master uniform')
                                    <flux:tooltip content="Add Stock" position="bottom">
                                        <flux:button 
                                            wire:click="openStockModal({{ $uniform->id }}, 'in')"
                                            x-on:click="$dispatch('open-modal', 'stock-modal')"
                                            size="sm"
                                            icon="plus-circle"
                                            variant="primary"
                                            color="green"
                                            class="!p-2"
                                            title="Add Stock"
                                        />
                                    </flux:tooltip>
                                @endcan
                                
                                <!-- Stock Opname Button -->
                                @can('edit master uniform')
                                    <flux:tooltip content="Stock Opname" position="bottom">
                                        <flux:button 
                                            wire:click="openStockModal({{ $uniform->id }}, 'opname')"
                                            x-on:click="$dispatch('open-modal', 'stock-modal')"
                                            size="sm"
                                            icon="pencil"
                                            variant="primary"
                                            color="teal"
                                            class="!p-2"
                                            title="Stock Opname"
                                        />
                                    </flux:tooltip>
                                @endcan
                                
                                <!-- Edit Button -->
                                @can('edit master uniform')
                                    <flux:tooltip content="Edit uniform" position="bottom">
                                        <flux:button 
                                            wire:click="edit({{ $uniform->id }})" 
                                            x-on:click="$dispatch('open-modal', 'uniform-form-modal')"
                                            size="sm"
                                            icon="pencil-square"
                                            variant="primary"
                                            color="yellow"
                                            class="!p-2"
                                            title="Edit uniform"
                                        />
                                    </flux:tooltip>
                                @endcan

                                <!-- Delete Button -->
                                @can('delete master uniform')
                                    <flux:tooltip content="Delete uniform" position="bottom">
                                        <flux:button 
                                            wire:click="confirmDelete({{ $uniform->id }})" 
                                            x-on:click="$dispatch('open-modal', 'delete-uniform-modal')"
                                            size="sm"
                                            icon="trash"
                                            variant="primary"
                                            color="red"
                                            class="!p-2"
                                            title="Delete uniform"
                                        />
                                    </flux:tooltip>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 3.75L3 6.75l1.5 3h3L9 6.75 7.5 3.75h-3zm12 0L15 6.75l1.5 3h3L21 6.75 19.5 3.75h-3zM3 6.75h18M6.75 6.75v10.5a1.5 1.5 0 001.5 1.5h7.5a1.5 1.5 0 001.5-1.5V6.75" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        No uniform data found
                                    </h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                        {{ $search ? 'Try adjusting your search query' : 'Get started by creating a new uniform' }}
                                    </p>
                                </div>
                                @if($search)
                                    <flux:button wire:click="$set('search', '')" size="sm">
                                        Clear Search
                                    </flux:button>
                                @else
                                    @can('create master uniform')
                                        <flux:button 
                                            variant="primary" 
                                            size="sm"
                                            wire:click="resetForm"
                                            x-on:click="$dispatch('open-modal', 'uniform-form-modal')"
                                        >
                                            Add Your First Uniform
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

        <!-- Pagination & Per Page Selector di Bawah -->
        @if($uniforms->hasPages() || $perPage === 'all')
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Show</span>
                    <select wire:model.live="perPage" 
                        class="px-2 py-1 text-sm border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="all">All</option>
                    </select>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">entries</span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400 ml-2">
                        Total: <strong>{{ $uniforms->total() ?? count($uniforms) }}</strong> item(s)
                    </span>
                </div>
                
                @if($perPage !== 'all')
                    <div>{{ $uniforms->links() }}</div>
                @else
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">
                        Showing all {{ count($uniforms) }} items
                    </span>
                @endif
            </div>
        </div>
        @endif
    </flux:card>

    <!-- MODAL FORM UNIFORM -->
    <div x-data="{ open: false }" 
        x-show="open" 
        @open-modal.window="if ($event.detail === 'uniform-form-modal') open = true"
        @close-modal.window="if ($event.detail === 'uniform-form-modal') open = false"
        x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                    <form wire:submit="save">
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Item Code <span class="text-red-500">*</span></label>
                            <input type="text" 
                                wire:model="item_code"
                                placeholder="e.g., UNF-001, SFT-001"
                                {{ $uniform_id ? 'disabled' : '' }}
                                class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $uniform_id ? 'bg-zinc-100 dark:bg-zinc-700 cursor-not-allowed opacity-75' : '' }}">
                            @error('item_code') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Description <span class="text-red-500">*</span></label>
                            <input type="text" 
                                wire:model="description"
                                placeholder="e.g., Kaos Polos, Jaket Proyek, Sepatu Safety"
                                {{ $uniform_id ? 'disabled' : '' }}
                                class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $uniform_id ? 'bg-zinc-100 dark:bg-zinc-700 cursor-not-allowed opacity-75' : '' }}">
                            @error('description') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Size <span class="text-red-500">*</span></label>
                            <select wire:model="size" 
                                {{ $uniform_id ? 'disabled' : '' }}
                                class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $uniform_id ? 'bg-zinc-100 dark:bg-zinc-700 cursor-not-allowed opacity-75' : '' }}">
                                <option value="">Select Size</option>
                                <option value="ALL SIZE">ALL SIZE</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                                <option value="XXXL">XXXL</option>
                                <option value="4XL">4XL</option>
                                <option value="37">37</option>
                                <option value="38">38</option>
                                <option value="39">39</option>
                                <option value="40">40</option>
                                <option value="41">41</option>
                                <option value="42">42</option>
                                <option value="43">43</option>
                                <option value="44">44</option>
                                <option value="45">45</option>
                                <option value="46">46</option>
                                <option value="47">47</option>
                                <option value="39/40">39/40</option>
                                <option value="44/45">44/45</option>
                            </select>
                            @error('size') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            
                            <div class="mt-2">
                                <input type="text" 
                                    wire:model="size"
                                    placeholder="Or enter custom size"
                                    {{ $uniform_id ? 'disabled' : '' }}
                                    class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm {{ $uniform_id ? 'bg-zinc-100 dark:bg-zinc-700 cursor-not-allowed opacity-75' : '' }}">
                                <p class="text-xs text-zinc-500 mt-1">You can select from dropdown or type custom size</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Price (IDR) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-zinc-500 dark:text-zinc-400 font-medium">Rp</span>
                                <input type="text" 
                                    wire:model="price"
                                    x-data
                                    x-init="
                                        $el.addEventListener('input', function(e) {
                                            let value = e.target.value.replace(/\D/g, '');
                                            if (value) {
                                                value = parseInt(value).toLocaleString('id-ID');
                                                e.target.value = value;
                                            }
                                        })
                                    "
                                    placeholder="0"
                                    class="w-full pl-10 pr-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    @input="
                                        let value = $event.target.value.replace(/\D/g, '');
                                        if (value) {
                                            value = parseInt(value).toLocaleString('id-ID');
                                            $event.target.value = value;
                                        }
                                        $wire.price = value;
                                    ">
                            </div>
                            <p class="text-xs text-zinc-500 mt-1">Format: Rp 1,000,000 (tanpa desimal)</p>
                            @error('price') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- HANYA TAMPIL SAAT CREATE (BUKAN EDIT) -->
                        @if(!$uniform_id)
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Initial Stock</label>
                            <input type="number" 
                                wire:model="qty"
                                min="0"
                                placeholder="0"
                                class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="text-xs text-zinc-500 mt-1">Initial quantity (default 0)</p>
                            @error('qty') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        @endif

                        <div class="flex justify-end gap-2 mt-6">
                            <button type="button" 
                                    @click="open = false"
                                    class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                {{ $uniform_id ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL STOCK -->
    <div x-data="{ open: false, action: @entangle('stockAction') }" 
        x-show="open" 
        @open-modal.window="if ($event.detail === 'stock-modal') open = true"
        @close-modal.window="if ($event.detail === 'stock-modal') open = false"
        x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">
                        <span x-show="action === 'in'">Add Stock</span>
                        <span x-show="action === 'opname'">Stock Opname</span>
                    </h2>
                    
                    <div class="mb-4">
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                            <strong>Item:</strong> {{ $stockUniform?->display_name }}
                        </p>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                            <strong>Current Stock:</strong> {{ $stockUniform?->qty ?? 0 }}
                        </p>
                    </div>

                    <form>
                        <div x-show="action === 'in'">
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1">Quantity to Add <span class="text-red-500">*</span></label>
                                <input type="number" 
                                    wire:model="stockQty"
                                    min="1"
                                    class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('stockQty') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1">Description (Optional)</label>
                                <input type="text" 
                                    wire:model="stockDescription"
                                    placeholder="e.g., New stock from supplier"
                                    class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <button type="button" 
                                wire:click="saveStockIn"
                                class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                Add Stock
                            </button>
                        </div>

                        <div x-show="action === 'opname'">
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1">Actual Stock <span class="text-red-500">*</span></label>
                                <input type="number" 
                                    wire:model="stockOpnameQty"
                                    min="0"
                                    class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('stockOpnameQty') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                <p class="text-xs text-zinc-500 mt-1">Enter the actual physical stock count</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1">Description (Optional)</label>
                                <input type="text" 
                                    wire:model="stockDescription"
                                    placeholder="e.g., Physical stock count"
                                    class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <button type="button" 
                                wire:click="saveStockOpname"
                                class="w-full px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors">
                                Update Stock
                            </button>
                        </div>

                        <div class="mt-3">
                            <button type="button" 
                                    @click="open = false"
                                    class="w-full px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL HISTORY -->
    <div x-data="{ open: false }" 
        x-show="open" 
        @open-modal.window="if ($event.detail === 'history-modal') open = true"
        @close-modal.window="if ($event.detail === 'history-modal') open = false"
        x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-5xl max-h-[90vh] flex flex-col">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700 flex-shrink-0">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold">Stock History</h2>
                        <button @click="open = false" class="text-zinc-500 hover:text-zinc-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        <strong>Item:</strong> {{ $historyUniform?->display_name }}
                    </p>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        <strong>Total Transactions:</strong> {{ count($historyTransactions) }}
                    </p>
                </div>
                
                <div class="p-6 flex-1 overflow-y-auto max-h-[60vh]">
                    @if(count($historyTransactions) > 0)
                        <div class="border rounded-lg overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-zinc-100 dark:bg-zinc-800 sticky top-0 z-10">
                                        <tr>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Date</th>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Type</th>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Change</th>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Before</th>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">After</th>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Description</th>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">By</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                        @foreach($historyTransactions as $transaction)
                                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                                <td class="px-3 py-2 text-center whitespace-nowrap text-xs">
                                                    {{ \Carbon\Carbon::parse($transaction['performed_at'])->format('d/m/Y H:i') }}
                                                </td>
                                                <td class="px-3 py-2 text-center">
                                                    @if($transaction['transaction_type'] == 'IN')
                                                        <flux:badge color="green" class="text-xs">IN</flux:badge>
                                                    @elseif($transaction['transaction_type'] == 'OUT')
                                                        <flux:badge color="red" class="text-xs">OUT</flux:badge>
                                                    @elseif($transaction['transaction_type'] == 'OPNAME')
                                                        <flux:badge color="yellow" class="text-xs">OPNAME</flux:badge>
                                                    @else
                                                        <flux:badge color="gray" class="text-xs">{{ $transaction['transaction_type'] }}</flux:badge>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-2 text-center text-xs">
                                                    <span class="font-semibold {{ $transaction['qty_change'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                        {{ $transaction['qty_change'] >= 0 ? '+' : '' }}{{ $transaction['qty_change'] }}
                                                    </span>
                                                </td>
                                                <td class="px-3 py-2 text-center text-xs font-mono">{{ $transaction['qty_before'] }}</td>
                                                <td class="px-3 py-2 text-center text-xs font-mono">{{ $transaction['qty_after'] }}</td>
                                                <td class="px-3 py-2 text-center text-xs max-w-xs">
                                                    <span class="block truncate" title="{{ $transaction['description'] ?? '-' }}">
                                                        {{ $transaction['description'] ?? '-' }}
                                                    </span>
                                                </td>
                                                <td class="px-3 py-2 text-center text-xs">{{ $transaction['performed_by'] ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(count($historyTransactions) > 5)
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 px-3 py-1.5 text-center text-xs text-zinc-500 border-t border-zinc-200 dark:border-zinc-700">
                                    Showing {{ count($historyTransactions) }} transactions
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-12 text-zinc-500">
                            <svg class="w-16 h-16 mx-auto text-zinc-300 dark:text-zinc-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p class="text-sm">No stock transaction history found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'delete-uniform-modal') open = true"
         @close-modal.window="if ($event.detail === 'delete-uniform-modal') open = false"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>

                <h3 class="text-lg font-bold mb-2">Delete Uniform</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Are you sure you want to delete uniform "{{ $uniformToDelete?->item_code }} - {{ $uniformToDelete?->description }}"? This action cannot be undone.
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