<div class="p-1 space-y-2">
    @section('title', 'Stock Transactions - Uniform')
    
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
            Stock Transactions
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Stock Transactions
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                View all stock transaction history
            </p>
        </div>
        <div>
            <a href="{{ route('prod.uniform.stock.manage') }}" wire:navigate
                class="inline-flex items-center gap-2 px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Transaction
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-2">
        <div>
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search..."
                icon="magnifying-glass"
                clearable
            />
        </div>
        <div>
            <select wire:model.live="transactionType" 
                class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-zinc-700 dark:text-zinc-300">
                <option value="">All Types</option>
                <option value="IN">IN</option>
                <option value="OUT">OUT</option>
                <option value="OPNAME">OPNAME</option>
            </select>
        </div>
        <div>
            <select wire:model.live="uniformStatus" 
                class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-zinc-700 dark:text-zinc-300">
                <option value="">All Status</option>
                <option value="Manual">Manual</option>
                <option value="System">System (Misc)</option>
                <option value="Not Use">Not Use</option>
            </select>
        </div>
        <div>
            <input type="date" 
                wire:model.live="dateFrom"
                class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-zinc-700 dark:text-zinc-300">
        </div>
        <div>
            <input type="date" 
                wire:model.live="dateTo"
                class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-zinc-700 dark:text-zinc-300">
        </div>
    </div>

    @if($search || $transactionType || $uniformStatus || $dateFrom || $dateTo)
        <div class="flex justify-end">
            <button wire:click="resetFilters" 
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Reset Filters
            </button>
        </div>
    @endif

    <!-- Transactions Table -->
    <flux:card class="p-6 shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                Showing <strong>{{ $transactions->firstItem() ?? 0 }}</strong> - <strong>{{ $transactions->lastItem() ?? 0 }}</strong> of <strong>{{ $transactions->total() ?? 0 }}</strong> transactions
            </div>
            <div>
                <select wire:model.live="perPage" 
                    class="px-3 py-1 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-zinc-700 dark:text-zinc-300">
                    <option value="10">10 per page</option>
                    <option value="25">25 per page</option>
                    <option value="50">50 per page</option>
                    <option value="100">100 per page</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto" style="overflow-x: auto !important; white-space: nowrap !important;">
            <table class="w-full text-sm" style="min-width: 1500px;">
                <thead class="bg-zinc-100 dark:bg-zinc-800">
                    <tr>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">#</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Date & Time</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Item Code</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Description</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Size</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Type</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Change</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Before</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">After</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Description</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">By</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Reference</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($transactions as $index => $transaction)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-3 py-2 text-center text-xs text-zinc-500 whitespace-nowrap">
                                {{ $transactions->firstItem() + $index }}
                            </td>
                            <td class="px-3 py-2 text-center text-xs whitespace-nowrap">
                                {{ Carbon\Carbon::parse($transaction->performed_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-3 py-2 text-center text-xs font-mono whitespace-nowrap">
                                {{ $transaction->uniform->item_code ?? '-' }}
                            </td>
                            <td class="px-3 py-2 text-center text-xs whitespace-nowrap">
                                {{ $transaction->uniform->description ?? '-' }}
                            </td>
                            <td class="px-3 py-2 text-center whitespace-nowrap">
                                <flux:badge size="xs" color="purple" class="text-xs">{{ $transaction->uniform->size ?? '-' }}</flux:badge>
                            </td>
                            <td class="px-3 py-2 text-center whitespace-nowrap">
                                @if($transaction->uniform)
                                    @if($transaction->uniform->status == 'Manual')
                                        <flux:badge size="xs" color="blue">Manual</flux:badge>
                                    @elseif($transaction->uniform->status == 'System')
                                        <flux:badge size="xs" color="green">System</flux:badge>
                                    @elseif($transaction->uniform->status == 'Not Use')
                                        <flux:badge size="xs" color="gray">Not Use</flux:badge>
                                    @else
                                        <flux:badge size="xs" color="yellow">{{ $transaction->uniform->status }}</flux:badge>
                                    @endif
                                @else
                                    <span class="text-xs text-zinc-400">-</span>
                                @endif
                            </td>
                            <td class="px-3 py-2 text-center whitespace-nowrap">
                                @if($transaction->transaction_type == 'IN')
                                    <flux:badge color="green" class="text-xs">IN</flux:badge>
                                @elseif($transaction->transaction_type == 'OUT')
                                    <flux:badge color="red" class="text-xs">OUT</flux:badge>
                                @elseif($transaction->transaction_type == 'OPNAME')
                                    <flux:badge color="yellow" class="text-xs">OPNAME</flux:badge>
                                @else
                                    <flux:badge color="gray" class="text-xs">{{ $transaction->transaction_type }}</flux:badge>
                                @endif
                            </td>
                            <td class="px-3 py-2 text-center text-xs whitespace-nowrap">
                                <span class="font-semibold {{ $transaction->qty_change >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $transaction->qty_change >= 0 ? '+' : '' }}{{ $transaction->qty_change }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-center text-xs font-mono whitespace-nowrap">{{ $transaction->qty_before }}</td>
                            <td class="px-3 py-2 text-center text-xs font-mono whitespace-nowrap">{{ $transaction->qty_after }}</td>
                            <td class="px-3 py-2 text-center text-xs whitespace-nowrap max-w-[200px]">
                                <span class="block truncate" title="{{ $transaction->description ?? '-' }}">
                                    {{ $transaction->description ?? '-' }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-center text-xs whitespace-nowrap">{{ $transaction->performed_by ?? '-' }}</td>
                            <td class="px-3 py-2 text-center text-xs whitespace-nowrap">
                                <span class="font-mono" title="{{ $transaction->reference_id ?? '-' }}">
                                    {{ $transaction->reference_id ?? '-' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-16 h-16 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <div>
                                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                            No transactions found
                                        </h3>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                            {{ $search ? 'Try adjusting your search query' : 'Start by creating a new stock transaction' }}
                                        </p>
                                    </div>
                                    @if($search)
                                        <flux:button wire:click="$set('search', '')" size="sm" class="text-sm">
                                            Clear Search
                                        </flux:button>
                                    @else
                                        <flux:button 
                                            variant="primary" 
                                            size="sm"
                                            href="{{ route('prod.uniform.stock.manage') }}"
                                            wire:navigate
                                            class="text-sm"
                                        >
                                            Add New Transaction
                                        </flux:button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $transactions->links() }}
            </div>
        @endif
    </flux:card>

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
        .overflow-x-auto {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f1f1;
        }
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .dark .overflow-x-auto::-webkit-scrollbar-track {
            background: #1f1f1f;
        }
        .dark .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #3f3f46;
        }
        .dark .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #52525b;
        }
        .max-w-[200px] { max-width: 200px; }
        .truncate { 
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .whitespace-nowrap { white-space: nowrap !important; }
        .text-xs { font-size: 0.75rem !important; }
    </style>
</div>