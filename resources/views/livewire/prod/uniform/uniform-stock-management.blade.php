<div class="p-1 space-y-2">
    @section('title', 'Stock Management - Uniform')
    
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">
            HR
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">
            Uniform
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('prod.uniform.master') }}" wire:navigate separator="slash">
            Master Uniform
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">
            Stock Management
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Stock Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Add stock or perform stock opname
            </p>
        </div>
        <div>
            <a href="{{ route('prod.uniform.master') }}" wire:navigate
                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Master Uniform
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Panel -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Header Card -->
            <flux:card class="p-6 shadow-lg">
                <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                    </svg>
                    Transaction Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Transaction Date <span class="text-red-500">*</span></label>
                        <input type="date" 
                            wire:model="transactionDate" 
                            disabled
                            class="w-full px-3 py-2 border rounded-lg bg-gray-100 dark:bg-zinc-700 dark:border-zinc-600 cursor-not-allowed text-gray-500 dark:text-gray-400">
                        @error('transactionDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Transaction Type <span class="text-red-500">*</span></label>
                        <div class="flex gap-2">
                            <button type="button" 
                                wire:click="$set('transactionType', 'in')"
                                class="flex-1 px-4 py-2 rounded-lg transition-all inline-flex items-center justify-center gap-2 {{ $transactionType === 'in' ? 'bg-green-600 text-white shadow-md' : 'bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400' }}">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                </svg>
                                <span>Stock In</span>
                            </button>
                            <button type="button" 
                                wire:click="$set('transactionType', 'opname')"
                                class="flex-1 px-4 py-2 rounded-lg transition-all inline-flex items-center justify-center gap-2 {{ $transactionType === 'opname' ? 'bg-purple-600 text-white shadow-md' : 'bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400' }}">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                                </svg>
                                <span>Opname</span>
                            </button>
                        </div>
                    </div>
                </div>
            </flux:card>

            <!-- Add Item Card -->
            <flux:card class="p-6 shadow-lg">
                <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z" clip-rule="evenodd" />
                    </svg>
                    Add Item
                </h3>
                
                <div class="space-y-4">
                    <!-- Search Uniform -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Search Uniform <span class="text-red-500">*</span></label>
                        <input type="text" 
                            wire:model.live.debounce.300ms="searchUniform" 
                            placeholder="Type item code, description, or size..."
                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                        
                        @if($searchUniform && strlen($searchUniform) >= 2 && count($uniforms) > 0)
                            <div class="mt-2 border rounded-lg overflow-hidden">
                                <div class="max-h-60 overflow-y-auto">
                                    <table class="w-full text-sm">
                                        <thead class="bg-zinc-100 dark:bg-zinc-800 sticky top-0 z-10">
                                            <tr>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Item Code</th>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Description</th>
                                                <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Size</th>
                                                <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Status</th>
                                                <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Stock</th>
                                                <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                            @foreach($uniforms as $uniform)
                                                <tr wire:click="selectUniform({{ $uniform->id }})" 
                                                    class="hover:bg-blue-50 dark:hover:bg-blue-900/20 cursor-pointer transition-colors">
                                                    <td class="px-3 py-2 font-mono text-sm">{{ $uniform->item_code }}</td>
                                                    <td class="px-3 py-2 text-sm">{{ $uniform->description }}</td>
                                                    <td class="px-3 py-2 text-center">
                                                        <flux:badge size="xs" color="purple">{{ $uniform->size }}</flux:badge>
                                                    </td>
                                                    <td class="px-3 py-2 text-center">
                                                        @if($uniform->status == 'Manual')
                                                            <flux:badge size="xs" color="blue">Manual</flux:badge>
                                                        @elseif($uniform->status == 'System')
                                                            <flux:badge size="xs" color="green">System (Misc)</flux:badge>
                                                        @elseif($uniform->status == 'Not Use')
                                                            <flux:badge size="xs" color="gray">Not Use</flux:badge>
                                                        @else
                                                            <flux:badge size="xs" color="yellow">{{ $uniform->status }}</flux:badge>
                                                        @endif
                                                    </td>
                                                    <td class="px-3 py-2 text-center">
                                                        <span class="text-sm font-semibold {{ $uniform->qty <= 5 ? 'text-red-600' : 'text-green-600' }}">
                                                            {{ number_format($uniform->qty) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-3 py-2 text-center text-sm">
                                                        Rp {{ number_format($uniform->price, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if(count($uniforms) > 5)
                                    <div class="bg-zinc-50 dark:bg-zinc-800/50 px-3 py-1.5 text-center text-xs text-zinc-500 border-t border-zinc-200 dark:border-zinc-700">
                                        Showing {{ count($uniforms) }} results
                                    </div>
                                @endif
                            </div>
                        @elseif($searchUniform && strlen($searchUniform) >= 2 && count($uniforms) == 0)
                            <div class="mt-2 border rounded-lg p-4 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                No uniforms found matching your search
                            </div>
                        @endif
                        @error('currentUniformId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Selected Uniform Info -->
                    @if($currentUniform)
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-xs text-blue-600 dark:text-blue-400">Selected Uniform</p>
                                    <p class="font-semibold">{{ $currentUniform->item_code }} - {{ $currentUniform->description }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Size: {{ $currentUniform->size }}</p>
                                        <span class="text-zinc-300 dark:text-zinc-600">|</span>
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Price: Rp {{ number_format($currentUniform->price, 0, ',', '.') }}</p>
                                        <span class="text-zinc-300 dark:text-zinc-600">|</span>
                                        <div>
                                            @if($currentUniform->status == 'Manual')
                                                <flux:badge size="xs" color="blue">Manual</flux:badge>
                                            @elseif($currentUniform->status == 'System')
                                                <flux:badge size="xs" color="green">System (Misc)</flux:badge>
                                            @elseif($currentUniform->status == 'Not Use')
                                                <flux:badge size="xs" color="gray">Not Use</flux:badge>
                                            @else
                                                <flux:badge size="xs" color="yellow">{{ $currentUniform->status }}</flux:badge>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-zinc-500">Current Stock</p>
                                    <p class="text-xl font-bold {{ $currentUniform->qty <= 5 ? 'text-red-600' : 'text-green-600' }}">
                                        {{ number_format($currentUniform->qty) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Quantity -->
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            @if($transactionType === 'in')
                                Quantity to Add <span class="text-red-500">*</span>
                            @else
                                Actual Stock Count <span class="text-red-500">*</span>
                            @endif
                        </label>
                        @if($transactionType === 'in')
                            <input type="number" wire:model="currentQty" min="1" 
                                class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                            @error('currentQty') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        @else
                            <div>
                                <input type="number" wire:model="currentOpnameQty" min="0" 
                                    class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-zinc-500 mt-1">Enter the actual physical stock count</p>
                                @error('currentOpnameQty') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @endif
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Description / Notes</label>
                        <input type="text" 
                            wire:model="currentDescription" 
                            placeholder="Additional information..."
                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <!-- Add Button -->
                    <button type="button" 
                            wire:click="addItem"
                            class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                        </svg>
                        Add Item
                    </button>
                </div>
            </flux:card>
        </div>
        
        <!-- Right Panel: Cart / Summary -->
        <div class="lg:col-span-1">
            <flux:card class="p-6 shadow-lg sticky top-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                        </svg>
                        Transaction Cart
                    </h3>
                    <span class="text-sm bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 px-2 py-1 rounded-full">
                        {{ $totalItems }} item(s)
                    </span>
                </div>
                
                @if(empty($items))
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <p class="mt-4 text-gray-500 dark:text-gray-400">No items added yet</p>
                        <p class="text-sm text-gray-400">Search and add items from the left panel</p>
                    </div>
                @else
                    <div class="space-y-3 max-h-[400px] overflow-y-auto mb-4">
                        @foreach($items as $index => $item)
                            <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-lg p-3 relative group">
                                <button wire:click="removeItem({{ $index }})" 
                                        class="absolute top-2 right-2 text-red-500 hover:text-red-700 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                                
                                <div class="pr-6">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <span class="font-mono text-xs text-gray-500">{{ $item['uniform']->item_code }}</span>
                                            <p class="text-sm font-medium">{{ $item['uniform']->description }}</p>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span class="text-xs text-gray-500">Size: {{ $item['uniform']->size }}</span>
                                                <span class="text-xs text-gray-300">|</span>
                                                <div>
                                                    @if($item['uniform']->status == 'Manual')
                                                        <flux:badge size="xs" color="blue">Manual</flux:badge>
                                                    @elseif($item['uniform']->status == 'System')
                                                        <flux:badge size="xs" color="green">System</flux:badge>
                                                    @elseif($item['uniform']->status == 'Not Use')
                                                        <flux:badge size="xs" color="gray">Not Use</flux:badge>
                                                    @else
                                                        <flux:badge size="xs" color="yellow">{{ $item['uniform']->status }}</flux:badge>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <span class="px-2 py-1 rounded-full text-xs font-bold {{ $transactionType === 'in' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800' }}">
                                            {{ strtoupper($transactionType === 'in' ? 'IN' : 'OPNAME') }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span>Qty: <strong>{{ number_format($item['qty']) }}</strong></span>
                                        <span class="text-gray-500">{{ $transactionType === 'in' ? 'Add' : 'Set to' }} {{ number_format($item['qty']) }}</span>
                                    </div>
                                    @if($transactionType === 'opname')
                                        <div class="text-xs text-gray-500 mt-1">
                                            Old Stock: {{ number_format($item['old_qty']) }} → New Stock: {{ number_format($item['qty']) }}
                                            @php
                                                $diff = $item['qty'] - $item['old_qty'];
                                            @endphp
                                            @if($diff > 0)
                                                <span class="text-green-600">(+{{ $diff }})</span>
                                            @elseif($diff < 0)
                                                <span class="text-red-600">({{ $diff }})</span>
                                            @else
                                                <span class="text-gray-400">(no change)</span>
                                            @endif
                                        </div>
                                    @endif
                                    @if($item['description'])
                                        <p class="text-xs text-gray-500 mt-1 truncate">{{ $item['description'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="border-t pt-4 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Total Items:</span>
                            <span class="font-semibold">{{ $totalItems }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Total Quantity:</span>
                            <span class="font-semibold">{{ number_format($totalQuantity) }}</span>
                        </div>
                        
                        <div class="flex gap-2 pt-2">
                            <button wire:click="resetTransaction" 
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                                Clear All
                            </button>
                            <button wire:click="saveTransaction" 
                                    class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                                Save Transaction
                            </button>
                        </div>
                    </div>
                @endif
            </flux:card>
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
        .max-h-60 { max-height: 240px; }
        .max-h-\[400px\] { max-height: 400px; }
        .sticky { position: sticky; }
        .min-w-0 { min-width: 0; }
        .flex-shrink-0 { flex-shrink: 0; }
        .truncate { 
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .flex-wrap { flex-wrap: wrap; }
    </style>
</div>