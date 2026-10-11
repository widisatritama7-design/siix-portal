@php
    $ncpList = $this->getNcpList();
@endphp

<div x-data="{ open: false }"
    x-on:open-modal-ncp.window="open = true"
    x-on:close-modal-ncp.window="open = false"
    x-show="open" x-cloak
    @keydown.escape.window="open = false">

    <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-4xl max-h-[85vh] flex flex-col">

            {{-- HEADER --}}
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-zinc-800 dark:text-white">Select NCP</h2>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Pilih NCP untuk grup ini</p>
                </div>
                <button type="button" @click="open = false"
                    class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                    </svg>
                </button>
            </div>

            {{-- SEARCH --}}
            <div class="px-6 py-3 border-b border-zinc-200 dark:border-zinc-700">
                <flux:input wire:model.live.debounce.300ms="ncpSearch"
                    placeholder="Cari NCP number / part number / customer / model..."
                    icon="magnifying-glass" clearable />
            </div>

            {{-- TABLE --}}
            <div class="flex-1 overflow-auto">
                <table class="w-full text-sm">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50 sticky top-0">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-zinc-500 uppercase">NCP Number</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-zinc-500 uppercase">Part Number</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-zinc-500 uppercase">Customer</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-zinc-500 uppercase">Model</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-zinc-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-zinc-500 uppercase w-24">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($ncpList as $ncp)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/30">
                                <td class="px-4 py-2 font-mono text-xs text-zinc-800 dark:text-zinc-200">{{ $ncp->ncp_number }}</td>
                                <td class="px-4 py-2 text-xs text-zinc-600 dark:text-zinc-400">{{ $ncp->part_number ?? '-' }}</td>
                                <td class="px-4 py-2 text-xs text-zinc-600 dark:text-zinc-400">{{ $ncp->customer ?? '-' }}</td>
                                <td class="px-4 py-2 text-xs text-zinc-600 dark:text-zinc-400">{{ $ncp->model_affected ?? '-' }}</td>
                                <td class="px-4 py-2 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold
                                        {{ $ncp->getStatusBadgeColor() === 'green' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : '' }}
                                        {{ $ncp->getStatusBadgeColor() === 'yellow' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' : '' }}
                                        {{ $ncp->getStatusBadgeColor() === 'blue' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : '' }}
                                        {{ $ncp->getStatusBadgeColor() === 'red' ? 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300' : '' }}
                                        {{ $ncp->getStatusBadgeColor() === 'gray' ? 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300' : '' }}">
                                        {{ $ncp->getStatusText() }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <button type="button"
                                        wire:click="selectNcp({{ $ncp->id }})"
                                        class="px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-zinc-500 text-sm">
                                    No NCP found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="px-6 py-3 border-t border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                <div class="text-xs text-zinc-500">
                    Showing {{ $ncpList->firstItem() ?? 0 }} - {{ $ncpList->lastItem() ?? 0 }}
                    of {{ $ncpList->total() }}
                </div>
                <div class="flex items-center gap-2">
                    {{ $ncpList->links() }}
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="px-6 py-3 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-2">
                <button type="button" wire:click="clearNcp"
                    class="px-4 py-2 text-sm border border-zinc-300 dark:border-zinc-700 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800">
                    Clear NCP
                </button>
                <button type="button" @click="open = false"
                    class="px-4 py-2 text-sm bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-700">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>