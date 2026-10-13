{{-- ==================== MODAL ERROR LIST ==================== --}}
<div x-data="{ open: false }"
    x-on:open-modal-error.window="open = true"
    x-show="open"
    x-cloak
    @keydown.escape.window="open = false"
    class="fixed inset-0 z-[70] flex items-center justify-center p-4">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
         @click="open = false"></div>

    {{-- Modal --}}
    <div class="relative bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[85vh] flex flex-col overflow-hidden">

        {{-- HEADER --}}
        <div class="relative px-6 py-4 bg-gradient-to-r from-red-500 via-rose-500 to-pink-500 overflow-hidden flex-shrink-0">
            <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/10"></div>
            <div class="absolute -right-4 -bottom-10 w-20 h-20 rounded-full bg-white/10"></div>

            <div class="relative flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                            <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-[10px] text-white/70 uppercase tracking-wider font-semibold">Validation</div>
                        <div class="text-base font-bold text-white leading-tight">Data Belum Lengkap</div>
                    </div>
                </div>

                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                    {{ count($validationErrors) }} error
                </span>
            </div>
        </div>

        {{-- BODY --}}
        <div class="p-5 overflow-y-auto flex-1">
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-3">
                Silakan lengkapi data berikut sebelum menyimpan:
            </p>

            <ul class="space-y-2">
                @foreach($validationErrors as $index => $err)
                    <li class="flex items-start gap-2 px-3 py-2 rounded-lg bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-900">
                        <span class="flex-shrink-0 inline-flex items-center justify-center w-5 h-5 rounded-full bg-red-500 text-white text-[10px] font-bold mt-0.5">
                            {{ $index + 1 }}
                        </span>
                        <span class="text-xs text-red-800 dark:text-red-300 leading-relaxed">{{ $err }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- FOOTER --}}
        <div class="px-5 py-4 border-t border-zinc-200 dark:border-zinc-700 flex justify-end flex-shrink-0">
            <button type="button"
                @click="open = false"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                Tutup
            </button>
        </div>
    </div>
</div>