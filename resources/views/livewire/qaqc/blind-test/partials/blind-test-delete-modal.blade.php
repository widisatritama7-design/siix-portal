{{-- ==================== MODAL DELETE ==================== --}}
<div x-data="{ open: false }"
    x-on:open-modal-delete.window="open = true"
    x-on:close-modal-delete.window="open = false"
    x-show="open" x-cloak @keydown.escape.window="open = false">

    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40" @click="open = false"></div>

    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="bg-gradient-to-r from-red-500 to-rose-600 px-6 py-5 flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-white/20 border border-white/30 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                        <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Delete Blind Test</h3>
                    <p class="text-xs text-red-100">Tindakan ini tidak bisa dibatalkan</p>
                </div>
            </div>

            <div class="p-6">
                <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4">
                    Yakin hapus blind test untuk <span class="font-bold text-zinc-800 dark:text-white">{{ $blindTestToDelete?->employee->name ?? '' }}</span>?
                </p>
                <div class="mb-4">
                    <flux:label required>Reason for Deletion</flux:label>
                    <flux:textarea wire:model="deleteReason" rows="3" placeholder="Alasan hapus..." />
                    @error('deleteReason') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end gap-3">
                    <button @click="open = false"
                        class="px-4 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 text-sm font-medium">
                        Cancel
                    </button>
                    <button wire:click="delete"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium shadow-lg shadow-red-500/30">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>