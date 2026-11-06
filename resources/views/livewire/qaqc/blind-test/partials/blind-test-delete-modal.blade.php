{{-- ==================== MODAL DELETE ==================== --}}
<div x-data="{ open: false }"
    x-on:open-modal-delete.window="open = true"
    x-on:close-modal-delete.window="open = false"
    x-show="open" x-cloak @keydown.escape.window="open = false">

    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40" @click="open = false"></div>

    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-red-500 to-rose-600 px-6 py-5 flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-white/20 border border-white/30 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Hapus Blind Test</h3>
                    <p class="text-xs text-red-100">Tindakan ini memerlukan verifikasi Google Authenticator</p>
                </div>
            </div>

            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">

                {{-- Info test yang akan dihapus --}}
                @if($blindTestToDelete)
                <div class="p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                    <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold mb-1">Test yang akan dihapus</div>
                    <div class="text-sm font-bold text-zinc-800 dark:text-white">
                        #{{ $blindTestToDelete->id }} — {{ $blindTestToDelete->employee->name ?? '-' }}
                    </div>
                    <div class="text-xs text-zinc-500 mt-0.5">
                        {{ $blindTestToDelete->employee->nik ?? '-' }} · {{ $blindTestToDelete->section }}
                    </div>
                </div>
                @endif

                {{-- Reason Code --}}
                <div>
                    <flux:label required>Alasan Hapus</flux:label>
                    <flux:select wire:model="deleteReasonCode" placeholder="-- Pilih Alasan --">
                        @foreach(\App\Models\QAQC\BlindTest\BlindTest::DELETE_REASONS as $code => $label)
                            <flux:select.option value="{{ $code }}">{{ $label }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    @error('deleteReasonCode')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Keterangan tambahan (opsional) --}}
                <div>
                    <flux:label>Keterangan Tambahan <span class="text-zinc-400 font-normal">(opsional)</span></flux:label>
                    <flux:textarea wire:model="deleteReason" rows="2" maxlength="500"
                        placeholder="Detail tambahan..." />
                    @error('deleteReason')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Google Authenticator OTP --}}
                <div class="p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                    
                    @if($this->is2faEnabled)
                        {{-- JIKA SUDAH AKTIF: Tampilkan Input OTP 6 Digit (Gaya Flux) --}}
                        <div class="text-center mb-4">
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-zinc-500">
                                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                                </svg>
                                Kode Google Authenticator <span class="text-red-500">*</span>
                            </span>
                        </div>

                        {{-- Komponen Flux OTP (Sama persis dengan halaman Two Factor) --}}
                        <div class="flex justify-center my-4">
                            <flux:otp
                                wire:model="deleteOtp"
                                length="6"
                                name="deleteOtp"
                                label="OTP Code"
                                label:sr-only
                                class="mx-auto"
                            />
                        </div>

                        @error('deleteOtp')
                            <flux:text color="red" class="mt-2 text-center text-sm">
                                {{ $message }}
                            </flux:text>
                        @enderror
                        
                        <p class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-3 text-center">
                            Masukkan 6 digit kode dari aplikasi Google Authenticator.
                        </p>

                    @else
                        {{-- JIKA BELUM AKTIF: Tampilkan Peringatan & Tombol Aktifkan --}}
                        <div class="text-center py-2">
                            <div class="w-10 h-10 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center mx-auto mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-zinc-500 dark:text-zinc-400">
                                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h4 class="text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Google Authenticator Belum Aktif</h4>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-4 px-2">
                                Anda harus mengaktifkan Google Authenticator terlebih dahulu sebelum dapat menghapus data ini.
                            </p>
                            
                            {{-- Tombol menuju halaman Security/Profile --}}
                            <a href="{{ route('security.edit') }}" wire:navigate 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-800 hover:bg-zinc-900 dark:bg-zinc-200 dark:hover:bg-white dark:text-zinc-900 text-white rounded-lg text-sm font-medium transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd" />
                                </svg>
                                Aktifkan Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-3">
                <button type="button" wire:click="cancelDelete"
                    class="px-4 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg
                        text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800
                        text-sm font-medium transition-colors">
                    Cancel
                </button>
                <button type="button" wire:click="delete" wire:loading.attr="disabled" wire:target="delete"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-red-600 hover:bg-red-700
                        disabled:opacity-50 disabled:cursor-not-allowed
                        text-white rounded-lg text-sm font-medium shadow-lg shadow-red-500/30 transition-colors">
                    <svg wire:loading wire:target="delete" class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="delete">Hapus Test</span>
                    <span wire:loading wire:target="delete">Memproses...</span>
                </button>
            </div>
        </div>
    </div>
</div>