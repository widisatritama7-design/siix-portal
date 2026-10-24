<div>
    <div x-data="{ open: @entangle('open') }" x-show="open" x-cloak @keydown.escape.window="$wire.close()">

        {{-- BACKDROP --}}
        <div class="fixed inset-0 bg-black/50 z-40" @click="$wire.close()"></div>

        {{-- PANEL --}}
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-lg
                        flex flex-col overflow-hidden">

                {{-- HEADER --}}
                <div class="relative px-6 py-4 bg-gradient-to-r from-amber-500 via-orange-500 to-red-500">
                    <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-white/10"></div>
                    <div class="absolute -right-2 -bottom-6 w-16 h-16 rounded-full bg-white/10"></div>
                    <div class="relative flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-[10px] text-white/80 uppercase tracking-wider font-semibold">Permintaan Edit</div>
                                <div class="text-lg font-bold text-white leading-tight">Request Edit Scan X-Ray</div>
                            </div>
                        </div>
                        <button type="button" wire:click="close"
                            class="w-8 h-8 rounded-lg bg-white/20 hover:bg-white/30 text-white flex items-center justify-center font-bold">
                            ✕
                        </button>
                    </div>
                </div>

                {{-- BODY --}}
                <div class="flex-1 overflow-y-auto px-6 py-5 space-y-5">

                    {{-- INFO --}}
                    <div class="rounded-xl border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-900/20 p-3 flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5">
                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        <div class="text-xs text-amber-800 dark:text-amber-200">
                            Request ini akan dikirim ke approver. Setelah di-approve, Anda bisa edit group yang dipilih dalam batas waktu tertentu.
                        </div>
                    </div>

                    {{-- PILIH GROUP --}}
                    <div>
                        <label class="text-[10px] uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 mb-2 block">
                            Pilih Group yang Mau Diedit <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            {{-- ✅ Panggil static langsung, hindari issue nested component --}}
                            @foreach(\App\Models\QAQC\ScanXray\ScanXrayEditRequest::GROUPS as $groupKey => $groupLabel)
                                @php $checked = in_array($groupKey, $selectedGroups, true); @endphp
                                <label class="flex items-center gap-2 px-3 py-2.5 rounded-lg border-2 cursor-pointer transition-all
                                    {{ $checked
                                        ? 'border-amber-400 bg-amber-50 dark:bg-amber-900/20 shadow-sm'
                                        : 'border-zinc-200 dark:border-zinc-700 hover:border-amber-300 dark:hover:border-amber-700' }}">
                                    <input type="checkbox"
                                        value="{{ $groupKey }}"
                                        wire:model.live="selectedGroups"
                                        class="rounded border-zinc-300 text-amber-600 focus:ring-amber-500" />
                                    <span class="text-xs font-semibold {{ $checked ? 'text-amber-800 dark:text-amber-200' : 'text-zinc-700 dark:text-zinc-300' }}">
                                        {{ $groupLabel }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('selectedGroups') <span class="text-red-500 text-xs block mt-1.5">{{ $message }}</span> @enderror
                        @error('selectedGroups.*') <span class="text-red-500 text-xs block mt-1.5">{{ $message }}</span> @enderror
                    </div>

                    {{-- ALASAN --}}
                    <div>
                        <label class="text-[10px] uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 mb-2 block">
                            Alasan (opsional)
                        </label>
                        <flux:textarea wire:model="reason" rows="3" placeholder="Kenapa perlu edit..." />
                        @error('reason') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-2">
                    <flux:button type="button" wire:click="close" variant="filled">
                        Batal
                    </flux:button>
                    <flux:button type="button" wire:click="submit" variant="primary" icon="paper-airplane"
                        class="bg-amber-600 hover:bg-amber-700"
                        wire:loading.attr="disabled" wire:target="submit">
                        <span wire:loading.remove wire:target="submit">Kirim Request</span>
                        <span wire:loading wire:target="submit">Mengirim...</span>
                    </flux:button>
                </div>
            </div>
        </div>
    </div>
</div>