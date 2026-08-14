<div class="p-1 space-y-2">
    @section('title', 'Teknisi Management - ESD System')
    
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            ESD
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Teknisi Management
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                🔧 Teknisi Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage and monitor uniform transactions
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('esd.teknisi.take') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                🔍 Ambil Seragam
            </a>
            <a href="{{ route('esd.teknisi.return') }}" 
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                📥 Kembalikan Seragam
            </a>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
        <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg shadow p-4 border border-yellow-200 dark:border-yellow-800">
            <p class="text-sm text-yellow-600 dark:text-yellow-400">Pending</p>
            <p class="text-2xl font-bold text-yellow-700 dark:text-yellow-300">{{ $statusCounts['pending'] }}</p>
        </div>
        <div class="bg-orange-50 dark:bg-orange-900/20 rounded-lg shadow p-4 border border-orange-200 dark:border-orange-800">
            <p class="text-sm text-orange-600 dark:text-orange-400">On Progress</p>
            <p class="text-2xl font-bold text-orange-700 dark:text-orange-300">{{ $statusCounts['on_progress'] }}</p>
        </div>
        <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg shadow p-4 border border-purple-200 dark:border-purple-800">
            <p class="text-sm text-purple-600 dark:text-purple-400">Waiting Pickup</p>
            <p class="text-2xl font-bold text-purple-700 dark:text-purple-300">{{ $statusCounts['waiting_pickup'] }}</p>
        </div>
        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg shadow p-4 border border-green-200 dark:border-green-800">
            <p class="text-sm text-green-600 dark:text-green-400">Completed</p>
            <p class="text-2xl font-bold text-green-700 dark:text-green-300">{{ $statusCounts['completed'] }}</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="flex flex-col sm:flex-row gap-4 mt-4">
        <div class="flex-1">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Cari NIK atau Nama..."
                icon="magnifying-glass"
                clearable
            />
        </div>
        <div>
            <select wire:model.live="statusFilter" 
                    class="w-full sm:w-auto px-4 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-900 text-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="on_progress">On Progress</option>
                <option value="waiting_pickup">Waiting Pickup</option>
                <option value="completed">Completed</option>
            </select>
        </div>
    </div>

    <!-- Transactions Table -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NIK</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Departemen</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Loker</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Jenis</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($transactions as $index => $transaction)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $transactions->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $transaction->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-3 text-sm font-medium">
                            {{ $transaction->employee->nik ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $transaction->employee->name ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $transaction->employee->department ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm font-mono font-bold">
                            {{ $transaction->locker->code }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @if($transaction->type == 'store')
                                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded text-xs">Menyimpan</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded text-xs">Mengambil</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300',
                                    'on_progress' => 'bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300',
                                    'completed' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300',
                                    'waiting_pickup' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300'
                                ];
                            @endphp
                            <span class="px-2 py-1 rounded text-xs {{ $statusColors[$transaction->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst(str_replace('_', ' ', $transaction->status)) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <flux:button 
                                wire:click="viewDetail({{ $transaction->id }})" 
                                x-on:click="$dispatch('open-modal', 'transaction-detail-modal')"
                                size="sm"
                                icon="eye"
                                variant="primary"
                                color="blue"
                                class="!p-2"
                                title="View detail"
                            />
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <flux:icon name="document-text" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        No transactions found
                                    </h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $search ? 'Try adjusting your search query' : 'No transactions available' }}
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $transactions->links() }}
        </div>
        @endif
    </flux:card>

    <!-- MODAL DETAIL TRANSACTION -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'transaction-detail-modal') open = true"
         @close-modal.window="if ($event.detail === 'transaction-detail-modal') open = false"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-2xl max-h-[80vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Detail Transaksi</h2>
                        <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    @if($selectedTransaction)
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm text-zinc-500">Kode Akses</label>
                                    <p class="font-mono font-bold">{{ $selectedTransaction->access_code }}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-zinc-500">Status</label>
                                    <p>
                                        @php
                                            $statusColors = [
                                                'pending' => 'text-yellow-600',
                                                'on_progress' => 'text-orange-600',
                                                'completed' => 'text-green-600',
                                                'waiting_pickup' => 'text-purple-600'
                                            ];
                                        @endphp
                                        <span class="font-semibold {{ $statusColors[$selectedTransaction->status] ?? '' }}">
                                            {{ ucfirst(str_replace('_', ' ', $selectedTransaction->status)) }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm text-zinc-500">Jenis</label>
                                    <p class="font-semibold">{{ ucfirst($selectedTransaction->type) }}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-zinc-500">Loker</label>
                                    <p class="font-mono font-bold">{{ $selectedTransaction->locker->code }}</p>
                                </div>
                            </div>

                            <div class="border-t pt-4">
                                <h3 class="font-semibold text-lg mb-2">Data Karyawan</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm text-zinc-500">NIK</label>
                                        <p>{{ $selectedTransaction->employee->nik ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm text-zinc-500">Nama</label>
                                        <p>{{ $selectedTransaction->employee->name ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm text-zinc-500">Departemen</label>
                                        <p>{{ $selectedTransaction->employee->department ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm text-zinc-500">No. WhatsApp</label>
                                        <p>{{ $selectedTransaction->employee->phone ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t pt-4">
                                <h3 class="font-semibold text-lg mb-2">Timeline</h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-zinc-500">Dibuat</span>
                                        <span>{{ $selectedTransaction->created_at->format('d/m/Y H:i:s') }}</span>
                                    </div>
                                    @if($selectedTransaction->stored_at)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-zinc-500">Disimpan</span>
                                        <span>{{ $selectedTransaction->stored_at->format('d/m/Y H:i:s') }}</span>
                                    </div>
                                    @endif
                                    @if($selectedTransaction->taken_at)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-zinc-500">Diambil</span>
                                        <span>{{ $selectedTransaction->taken_at->format('d/m/Y H:i:s') }}</span>
                                    </div>
                                    @endif
                                    @if($selectedTransaction->expires_at)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-zinc-500">Berlaku sampai</span>
                                        <span>{{ $selectedTransaction->expires_at->format('d/m/Y H:i:s') }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mt-6 flex justify-end">
                        <button @click="open = false" 
                                class="px-4 py-2 bg-gray-200 dark:bg-zinc-800 rounded-lg hover:bg-gray-300 dark:hover:bg-zinc-700 transition-colors">
                            Close
                        </button>
                    </div>
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