<div class="p-1 space-y-3"
     @if($isStarted && !$isFinished) wire:poll.3s="syncTimer" @endif
     x-data="cameraProctoring()"
     x-init="initProctoring()">

    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('qaqc.blind-test') }}" wire:navigate separator="slash" class="font-semibold text-blue-600">QA/QC</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Blind Test Execution</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- ==================== MODAL BROWSER & CAMERA CHECK ==================== -->
    @if($showBrowserCheckModal)
    <div class="fixed top-0 left-0 w-screen h-screen z-[9999] flex items-center justify-center bg-black/80 backdrop-blur-md p-4">
        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden flex flex-col max-h-[90vh]">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-5 text-white flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center border-2 border-white/40">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold">Pemeriksaan Browser & Kamera</h2>
                        <p class="text-xs text-blue-100">Wajib lulus sebelum memulai test</p>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-5 space-y-3 overflow-y-auto flex-1 min-h-0">

                {{-- Checklist --}}
                <template x-for="(item, idx) in checks" :key="idx">
                    <div class="flex items-center gap-3 p-3 rounded-lg border flex-shrink-0"
                        :class="item.ok ? 'border-green-200 bg-green-50 dark:bg-green-950/20' : 'border-red-200 bg-red-50 dark:bg-red-950/20'">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                            :class="item.ok ? 'bg-green-500' : 'bg-red-500'">
                            <svg x-show="item.ok" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-white">
                                <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                            </svg>
                            <svg x-show="!item.ok" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-white">
                                <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white" x-text="item.label"></div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400 truncate" x-text="item.value"></div>
                        </div>
                    </div>
                </template>

                {{-- Video Preview --}}
                <div x-show="cameraOk" x-cloak class="rounded-lg overflow-hidden border-2 border-green-300 bg-black flex-shrink-0">
                    <video x-ref="preview" autoplay muted playsinline class="w-full h-32 sm:h-40 object-cover"></video>
                </div>

                {{-- Alert --}}
                <div x-show="!allOk" class="p-3 rounded-lg bg-amber-50 dark:bg-amber-950/20 border border-amber-300 dark:border-amber-700 text-xs text-amber-800 dark:text-amber-300 flex-shrink-0">
                    <strong>Perhatian:</strong> Kamu wajib mengizinkan akses kamera depan.
                    Jika ditolak, klik <em>Allow Camera</em> lagi dan pilih <strong>Allow</strong> di popup browser.
                </div>

                {{-- Spacer --}}
                <div class="h-2"></div>
            </div>

            {{-- Footer --}}
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-2 flex-shrink-0 bg-white dark:bg-zinc-900">
                <button type="button" @click="requestCamera()"
                    class="px-4 py-2 rounded-lg bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 text-sm font-medium">
                    Cek Ulang / Allow Camera
                </button>
                <button type="button" @click="confirmAndClose()"
                    :disabled="!allOk"
                    :class="allOk ? 'bg-blue-600 hover:bg-blue-700' : 'bg-zinc-300 dark:bg-zinc-700 cursor-not-allowed'"
                    class="px-5 py-2 rounded-lg text-white text-sm font-semibold">
                    Saya Setuju & Lanjut
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- ==================== FLOATING CAMERA + SCREEN PREVIEW ==================== -->
    @if($isStarted && !$isFinished)
    <div class="fixed top-4 left-4 z-40 space-y-2">

        {{-- Kamera --}}
        <div x-show="recordingActive" x-cloak>
            <div class="bg-black/90 backdrop-blur-md rounded-xl shadow-2xl border-2 border-red-500 overflow-hidden"
                 style="width: 220px;">
                <div class="px-3 py-1.5 bg-gradient-to-r from-red-600 to-rose-600 flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-white animate-pulse"></div>
                    <span class="text-[10px] font-bold text-white uppercase tracking-wider">CAM REC</span>
                    <span class="ml-auto text-[10px] text-white font-mono" x-text="recordingDuration"></span>
                </div>
                <video x-ref="camPreview" autoplay muted playsinline class="w-full h-32 object-cover bg-black"></video>
                <div class="px-2 py-1 bg-black/70 text-center">
                    <span class="text-[9px] text-white/70">Kamera Proctoring Aktif</span>
                </div>
            </div>
        </div>

        {{-- Screen --}}
        <div x-show="screenRecordingActive" x-cloak>
            <div class="bg-black/90 backdrop-blur-md rounded-xl shadow-2xl border-2 border-emerald-500 overflow-hidden"
                 style="width: 220px;">
                <div class="px-3 py-1.5 bg-gradient-to-r from-emerald-600 to-teal-600 flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-white animate-pulse"></div>
                    <span class="text-[10px] font-bold text-white uppercase tracking-wider">SCREEN REC</span>
                    <span class="ml-auto text-[10px] text-white font-mono" x-text="screenDuration"></span>
                </div>
                <video x-ref="screenPreview" autoplay muted playsinline
                       class="w-full h-32 object-cover bg-black"></video>
                <div class="px-2 py-1 bg-black/70 text-center">
                    <span class="text-[9px] text-white/70">Preview Layar</span>
                </div>
            </div>
        </div>

        {{-- ✅ Tombol Resume Screen (muncul kalau habis refresh / screen berhenti) --}}
        <div x-show="screenNeedsResume && !screenRecordingActive" x-cloak>
            <button type="button" @click="resumeScreenRecording()"
                class="w-full flex items-center gap-2 px-3 py-2.5 rounded-xl
                       bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700
                       text-white text-xs font-bold shadow-2xl border-2 border-amber-300
                       animate-pulse transition-all"
                style="width: 220px;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 flex-shrink-0">
                    <path fill-rule="evenodd" d="M2.25 5.25a3 3 0 0 1 3-3h13.5a3 3 0 0 1 3 3V15a3 3 0 0 1-3 3h-3v.257c0 .597.237 1.17.659 1.591l.621.622a.75.75 0 0 1-.53 1.28h-9a.75.75 0 0 1-.53-1.28l.621-.622a2.25 2.25 0 0 0 .659-1.59V18h-3a3 3 0 0 1-3-3V5.25Zm1.5 0v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5Z" clip-rule="evenodd" />
                </svg>
                <span class="flex-1 text-left leading-tight">
                    Klik untuk Resume<br>
                    <span class="text-[10px] font-normal opacity-90">Rekaman layar berhenti</span>
                </span>
            </button>
        </div>

    </div>
    @endif

    <!-- ==================== HEADER ==================== -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 shadow-xl">
        <div class="relative p-6 sm:p-7 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-white">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white">Blind Test Execution</h1>
                    <p class="text-sm text-blue-100 mt-1 flex items-center gap-2 flex-wrap">
                        <span class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                            </svg>
                            {{ $blindTest->employee->name ?? '-' }} ({{ $blindTest->employee->nik ?? '-' }})
                        </span>
                        <span class="text-blue-200">•</span>
                        <span>Shift: {{ $blindTest->shift ?? '-' }}</span>
                        <span class="text-blue-200">•</span>
                        <span>Group: {{ $blindTest->group ?? '-' }}</span>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                @if($isStarted && !$isFinished)
                <div class="bg-white/15 backdrop-blur-sm border border-white/30 text-white px-5 py-3 rounded-2xl shadow-lg">
                    @if($remainingSeconds !== null)
                        @php $sec = (int) floor(abs($remainingSeconds)); @endphp
                        <div class="flex items-center gap-2"
                            x-data="{ left: {{ $sec }} }"
                            x-init="setInterval(() => { if (left > 0) left--; }, 1000)">
                            <span class="text-xs opacity-80 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                                </svg>
                                Sisa Waktu :
                            </span>
                            <span class="text-2xl font-bold font-mono"
                                x-text="String(Math.floor(left/60)).padStart(2,'0') + ':' + String(left%60).padStart(2,'0')">
                                {{ sprintf('%02d:%02d', intdiv($sec, 60), $sec % 60) }}
                            </span>
                        </div>
                    @else
                        <div class="flex items-center gap-2"
                            x-data="{ sec: 0, start: {{ $startedAt }} }"
                            x-init="setInterval(() => { sec = Math.floor(Date.now()/1000) - start; }, 1000)">
                            <span class="text-xs opacity-80 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                                </svg>
                                Elapsed Time :
                            </span>
                            <span class="text-2xl font-bold font-mono"
                                x-text="String(Math.floor(sec/60)).padStart(2,'0') + ':' + String(sec%60).padStart(2,'0')">
                                00:00
                            </span>
                        </div>
                    @endif
                </div>
                @endif

                <a href="{{ route('qaqc.blind-test') }}" wire:navigate>
                    <button type="button"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl
                            bg-white/20 hover:bg-white/30 backdrop-blur-sm
                            border border-white/30 text-white font-medium text-sm
                            transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-4.28 9.22a.75.75 0 0 0 0 1.06l3 3a.75.75 0 1 0 1.06-1.06l-1.72-1.72h5.69a.75.75 0 0 0 0-1.5h-5.69l1.72-1.72a.75.75 0 0 0-1.06-1.06l-3 3Z" clip-rule="evenodd" />
                        </svg>
                        Back
                    </button>
                </a>
            </div>
        </div>
    </div>

    <!-- ==================== EXPIRED BANNER ==================== -->
    @if($isExpired && !$isFinished)
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-red-500 to-rose-600 shadow-xl">
        <div class="p-5 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border-2 border-white/40">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-white">
                    <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <div class="text-lg font-bold text-white">Waktu Test Sudah Habis</div>
                <div class="text-sm text-red-100">
                    Waktu pengerjaan ({{ $blindTest->duration_minutes }} menit) sudah habis.
                    Jawaban Anda <strong>otomatis disimpan</strong> dan test sudah ditutup.
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- ==================== INFO CARD + RESULT ==================== -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-3">

        <div class="lg:col-span-4">
            <flux:card class="p-6 shadow-lg h-full">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

                    {{-- Customer --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-emerald-600 dark:text-emerald-400">
                                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">Customer</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white">{{ $blindTest->customer->customer_name ?? '-' }}</div>
                        </div>
                    </div>

                    {{-- Model --}}
                    @php
                        // Kumpulkan model dari snapshot (support multi-model di nested items)
                        $infoModels = collect($blindTest->question_snapshot ?? [])
                            ->flatMap(function ($q) {
                                $items = $q['items'] ?? [];

                                // Format baru: nested group per model
                                if (!empty($items) && isset($items[0]['model_id'])) {
                                    return collect($items)->map(function ($g) {
                                        $m = !empty($g['model_id'])
                                            ? \App\Models\QAQC\BlindTest\Model::find($g['model_id'])
                                            : null;
                                        return $m ? ['id' => $m->id, 'name' => $m->model_name] : null;
                                    })->filter();
                                }

                                // Format lama: flat, model dari kolom model_id
                                if (!empty($q['model_id'])) {
                                    $m = \App\Models\QAQC\BlindTest\Model::find($q['model_id']);
                                    return $m ? [['id' => $m->id, 'name' => $m->model_name]] : [];
                                }

                                return [];
                            })
                            ->unique('id')
                            ->values();

                        // Fallback kalau snapshot kosong
                        if ($infoModels->isEmpty() && $blindTest->model_id) {
                            $m = \App\Models\QAQC\BlindTest\Model::find($blindTest->model_id);
                            if ($m) $infoModels = collect([['id' => $m->id, 'name' => $m->model_name]]);
                        }
                    @endphp

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-amber-600 dark:text-amber-400">
                                <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                                <path fill-rule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                Model
                                @if($infoModels->count() > 1)
                                    <span class="text-[10px] text-purple-600 dark:text-purple-400 font-semibold">
                                        ({{ $infoModels->count() }})
                                    </span>
                                @endif
                            </div>

                            @if($infoModels->count() === 0)
                                <div class="text-sm font-semibold text-zinc-800 dark:text-white">-</div>
                            @elseif($infoModels->count() === 1)
                                <div class="text-sm font-semibold text-zinc-800 dark:text-white">
                                    {{ $infoModels->first()['name'] }}
                                </div>
                            @else
                                <div class="flex flex-wrap gap-1 mt-0.5">
                                    @foreach($infoModels as $m)
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300">
                                            {{ $m['name'] }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Section --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-cyan-600 dark:text-cyan-400">
                                <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">Section</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white">{{ $blindTest->section ?? '-' }}</div>
                        </div>
                    </div>

                    {{-- Durasi Max --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-orange-600 dark:text-orange-400">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">Durasi Maks</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white">
                                {{ $blindTest->duration_minutes ? $blindTest->duration_minutes . ' menit' : 'Tanpa batas' }}
                            </div>
                        </div>
                    </div>

                    {{-- Time Finish --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-indigo-600 dark:text-indigo-400">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm.75 4.5a.75.75 0 0 0-1.5 0v5.25c0 .199.079.39.22.53l3 3a.75.75 0 1 0 1.06-1.06l-2.78-2.78V6.75Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">Time Finish</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white">
                                {{ $blindTest->finished_at ? $blindTest->finished_at->format('H:i') : '-' }}
                            </div>
                        </div>
                    </div>

                    {{-- Waktu Pengerjaan --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-teal-600 dark:text-teal-400">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">Waktu Pengerjaan</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white">
                                {{ $blindTest->duration_formatted }}
                            </div>
                        </div>
                    </div>

                    {{-- Total Soal --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-rose-600 dark:text-rose-400">
                                <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875Zm5.845 17.03a.75.75 0 0 0 1.06 0l3-3a.75.75 0 1 0-1.06-1.06l-1.72 1.72V12a.75.75 0 0 0-1.5 0v4.19l-1.72-1.72a.75.75 0 0 0-1.06 1.06l3 3Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">Total Soal</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white">{{ $blindTest->total_items }}</div>
                        </div>
                    </div>

                    {{-- Soal Dijawab --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-sky-100 dark:bg-sky-900/30 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-sky-600 dark:text-sky-400">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">Soal Dijawab</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white">
                                {{ $blindTest->total_correct }} / {{ $blindTest->total_items }}
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center
                            @if($blindTest->status === 'pending') bg-yellow-100 dark:bg-yellow-900/30
                            @elseif($blindTest->status === 'in_progress') bg-blue-100 dark:bg-blue-900/30
                            @else bg-green-100 dark:bg-green-900/30 @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5
                                @if($blindTest->status === 'pending') text-yellow-600 dark:text-yellow-400
                                @elseif($blindTest->status === 'in_progress') text-blue-600 dark:text-blue-400
                                @else text-green-600 dark:text-green-400 @endif">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">Status</div>
                            @php $sc = ['pending' => 'yellow', 'in_progress' => 'blue', 'completed' => 'green']; @endphp
                            <flux:badge size="sm" color="{{ $sc[$blindTest->status] ?? 'gray' }}">
                                {{ ucfirst(str_replace('_', ' ', $blindTest->status)) }}
                            </flux:badge>
                        </div>
                    </div>
                </div>
            </flux:card>
        </div>

        <!-- Result 20% -->
        <div class="lg:col-span-1">
            <div class="rounded-2xl shadow-xl p-5 h-full flex flex-col justify-center items-center text-center
                @if($isFinished)
                    @if($isPendingReview)
                        bg-gradient-to-br from-amber-500 to-orange-600
                    @elseif($overallResult === 'PASS')
                        bg-gradient-to-br from-green-500 to-emerald-600
                    @elseif($overallResult === 'FAIL')
                        bg-gradient-to-br from-red-500 to-rose-600
                    @else
                        bg-gradient-to-br from-zinc-400 to-zinc-500
                    @endif
                @else
                    bg-gradient-to-br from-zinc-400 to-zinc-500
                @endif">

                @if($isFinished)
                    @if($isPendingReview)
                        <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border-2 border-white/40 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-white">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="text-[10px] text-white/80 uppercase tracking-wider font-semibold">Result</div>
                        <div class="text-lg font-bold text-white leading-tight">Menunggu Review</div>
                        <div class="text-xs text-white/90 mt-1">QC</div>
                    @elseif($overallResult)
                        <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border-2 border-white/40 mb-2">
                            @if($overallResult === 'PASS')
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-white">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-white">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                        <div class="text-[10px] text-white/80 uppercase tracking-wider font-semibold">Result</div>
                        <div class="text-3xl font-bold text-white">{{ $overallResult }}</div>
                    @else
                        <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border-2 border-white/40 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-white">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="text-[10px] text-white/80 uppercase tracking-wider font-semibold">Result</div>
                        <div class="text-xl font-bold text-white">Pending</div>
                    @endif
                @else
                    <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border-2 border-white/40 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-white">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="text-[10px] text-white/80 uppercase tracking-wider font-semibold">Result</div>
                    <div class="text-xl font-bold text-white">Pending</div>
                @endif
            </div>
        </div>
    </div>

    <!-- ==================== BELUM MULAI ==================== -->
    @if(!$isStarted && !$isFinished)
    <flux:card class="p-12 text-center shadow-lg">
        @if($isExpired)
            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-red-500 to-rose-600 flex items-center justify-center shadow-xl shadow-red-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 text-white">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold mb-2 text-red-600 dark:text-red-400">Waktu Habis</h2>
            <p class="text-sm text-zinc-500 mb-8 max-w-md mx-auto">
                Test ini hanya bisa dilakukan sebelum jam
                <strong>{{ $blindTest->time_test ? $blindTest->time_test->format('H:i') : '-' }}</strong>.
                Silakan hubungi QC untuk reset jadwal.
            </p>
            <a href="{{ route('qaqc.blind-test') }}" wire:navigate>
                <flux:button variant="primary" icon="arrow-left" class="!px-6">
                    Back to Management
                </flux:button>
            </a>
        @else
            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-xl shadow-blue-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12 text-white">
                    <path fill-rule="evenodd" d="M4.5 5.653c0-1.427 1.529-2.33 2.779-1.643l11.54 6.347c1.295.712 1.295 2.573 0 3.286L7.28 19.99c-1.25.687-2.779-.217-2.779-1.643V5.653Z" clip-rule="evenodd" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold mb-2 text-zinc-800 dark:text-white">Ready to Start?</h2>
            <p class="text-sm text-zinc-500 mb-2 max-w-md mx-auto">
                Klik tombol di bawah untuk memulai test.
            </p>
            @if($blindTest->time_test)
            <p class="text-xs text-red-500 dark:text-red-400 font-medium mb-2 max-w-md mx-auto">
                Deadline mulai: <strong>{{ $blindTest->time_test->format('H:i') }}</strong>
            </p>
            @endif
            @if($blindTest->duration_minutes)
            <p class="text-xs text-orange-500 dark:text-orange-400 font-medium mb-6 max-w-md mx-auto">
                Durasi pengerjaan: <strong>{{ $blindTest->duration_minutes }} menit</strong>
            </p>
            @endif

            {{-- TOMBOL START --}}
            @if(!$browserCheckPassed)
                <div class="mb-4 p-3 rounded-lg bg-amber-50 dark:bg-amber-950/20 border border-amber-300 dark:border-amber-700 text-xs text-amber-800 dark:text-amber-300 max-w-md mx-auto">
                    Kamu harus lulus <strong>Pemeriksaan Browser & Kamera</strong> terlebih dahulu.
                </div>
                <flux:button wire:click="$set('showBrowserCheckModal', true)" variant="primary" icon="shield-check" class="bg-amber-600 hover:bg-amber-700 !text-base !px-8 !py-3">
                    Buka Pemeriksaan Browser
                </flux:button>
            @elseif(!$cameraStreamActive)
                <div class="mb-4 p-3 rounded-lg bg-red-50 dark:bg-red-950/20 border border-red-300 dark:border-red-700 text-xs text-red-800 dark:text-red-300 max-w-md mx-auto">
                    <strong>Kamera tidak aktif!</strong> Izinkan akses kamera terlebih dahulu untuk memulai test.
                </div>
                <flux:button wire:click="$set('showBrowserCheckModal', true); $set('browserCheckPassed', false)" variant="primary" icon="camera" class="bg-red-600 hover:bg-red-700 !text-base !px-8 !py-3">
                    Aktifkan Kamera
                </flux:button>
            @else
                <flux:button wire:click="startTest" variant="primary" icon="play" class="bg-blue-600 hover:bg-blue-700 !text-base !px-8 !py-3">
                    Start Test Now
                </flux:button>
            @endif
        @endif
    </flux:card>
    @endif

    <!-- ==================== SEDANG TEST ==================== -->
    @if($isStarted && !$isFinished)
    <flux:card class="p-6 shadow-lg">

        @if($remainingSeconds !== null && $remainingSeconds <= 300 && $remainingSeconds > 0)
        <div class="mb-4 rounded-xl bg-yellow-50 dark:bg-yellow-950/20 border-2 border-yellow-300 dark:border-yellow-700 p-4 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-yellow-600 dark:text-yellow-400 flex-shrink-0">
                <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
            </svg>
            <div>
                <div class="text-sm font-bold text-yellow-800 dark:text-yellow-300">Waktu Hampir Habis!</div>
                <div class="text-xs text-yellow-700 dark:text-yellow-400">
                    Sisa waktu kurang dari 5 menit. Segera submit jawaban Anda.
                </div>
            </div>
        </div>
        @endif

        {{-- Header — TANPA tombol Tambah Baris --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6 pb-4 border-b border-zinc-200 dark:border-zinc-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-blue-600 dark:text-blue-400">
                        <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-zinc-800 dark:text-white">Jawaban Anda</h2>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Isi defect item + component location. Urutan bebas.</p>
                </div>
            </div>
        </div>

        <div class="mb-4 p-3 rounded-lg bg-blue-50 dark:bg-blue-950/20 border border-blue-200 dark:border-blue-800 flex items-start gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
            </svg>
            <p class="text-xs text-blue-800 dark:text-blue-300">
                <strong>Tips:</strong> Isi daftar defect item + component location yang Anda temukan.
                <strong>Urutan tidak penting</strong> — yang penting isinya sesuai dengan kunci.
            </p>
        </div>

        <div class="space-y-3">
            @foreach($userAnswers as $i => $row)
            <div class="flex gap-3 items-start p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700" wire:key="row-{{ $i }}">
                <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                    <span class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ $i + 1 }}</span>
                </div>
                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-3">
                    <flux:select wire:model="userAnswers.{{ $i }}.deffect_item_id" placeholder="Pilih defect item...">
                        @foreach($deffects as $d)
                            <flux:select.option value="{{ $d->id }}">{{ $d->deffect_item_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input wire:model="userAnswers.{{ $i }}.component_location"
                        placeholder="Component location (e.g. CN4)" class="uppercase" />
                </div>
                @if(count($userAnswers) > 1)
                <flux:button wire:click="removeRow({{ $i }})" size="sm" icon="trash"
                    variant="primary" color="red" class="!p-2 flex-shrink-0" />
                @endif
            </div>
            @endforeach
        </div>

        {{-- ✅ Footer: Tambah Baris (kiri) + Submit Test (kanan) --}}
        <div class="mt-6 flex justify-between items-center pt-4 border-t border-zinc-200 dark:border-zinc-700">
            <flux:button wire:click="addRow" size="sm" icon="plus" variant="primary" class="bg-blue-600 hover:bg-blue-700">
                Tambah Baris
            </flux:button>
            <flux:button wire:click="submit" variant="primary" icon="check-circle" class="bg-blue-600 hover:bg-blue-700 !px-6">
                Submit Test
            </flux:button>
        </div>
    </flux:card>
    @endif

    <!-- ==================== HASIL ==================== -->
    @if($isFinished)
        @php
            $showFullResult  = $blindTest->shouldShowFullResult();
            $isSecondAttempt = $blindTest->attempt > 1;
            $hasPending      = $blindTest->hasPendingReview();

            $currentVisible = $blindTest->filterVisibleAnswers($evaluationResult ?? []);
            $firstVisible   = $blindTest->filterVisibleAnswers($firstAttemptAnswers ?? []);

            $recordings = collect($blindTest->recordings ?? [])->map(function ($rec, $key) {
                return [
                    'label'       => $rec['label'] ?? $key,
                    'finished_at' => $rec['finished_at'] ?? null,
                    'camera_url'  => !empty($rec['camera_path'])
                                        ? Storage::disk('public')->url($rec['camera_path'])
                                        : ($rec['camera_url'] ?? null),
                    'screen_url'  => !empty($rec['screen_path'])
                                        ? Storage::disk('public')->url($rec['screen_path'])
                                        : ($rec['screen_url'] ?? null),
                    'camera_size' => $rec['camera_size'] ?? '-',
                    'screen_size' => $rec['screen_size'] ?? '-',
                ];
            })->toArray();

            $hasAnyRec = $blindTest->hasAnyRecording();
        @endphp

        @if($hasAnyRec)
        <div class="mb-3 p-4 rounded-2xl bg-gradient-to-r from-zinc-900 to-zinc-800 shadow-lg"
             x-data="{
                showCameraModal: false,
                showScreenModal: false,
                activeAttempt: 'attempt_current',
                recordings: @js($recordings),
             }">

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-red-500/20 flex items-center justify-center border border-red-500/40">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-red-400">
                            <path d="M4.5 4.5a3 3 0 0 0-3 3v9a3 3 0 0 0 3 3h8.25a3 3 0 0 0 3-3v-9a3 3 0 0 0-3-3H4.5ZM19.94 18.75l-2.69-2.69V7.94l2.69-2.69c.944-.945 2.56-.276 2.56 1.06v11.38c0 1.336-1.616 2.005-2.56 1.06Z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-white">Rekaman Proctoring</div>
                        <div class="text-xs text-zinc-400">
                            Lihat rekaman kamera & layar per percobaan
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-wrap">
                    <button type="button" @click="showCameraModal = true; activeAttempt = 'attempt_current'"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-all shadow-lg shadow-blue-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path d="M12 9a3.75 3.75 0 1 0 0 7.5A3.75 3.75 0 0 0 12 9Z" />
                            <path fill-rule="evenodd" d="M9.344 3.071a49.52 49.52 0 0 1 5.312 0c.967.052 1.83.585 2.332 1.39l.821 1.317c.24.383.645.643 1.11.71.386.054.77.113 1.152.177 1.432.239 2.429 1.493 2.429 2.909V18a3 3 0 0 1-3 3h-15a3 3 0 0 1-3-3V9.574c0-1.416.997-2.67 2.429-2.909.382-.064.766-.123 1.151-.178a1.56 1.56 0 0 0 1.11-.71l.822-1.315a2.942 2.942 0 0 1 2.332-1.39ZM6.75 12.75a5.25 5.25 0 1 1 10.5 0 5.25 5.25 0 0 1-10.5 0Zm12-1.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                        </svg>
                        Lihat Rekaman Kamera
                    </button>
                </div>
            </div>

            {{-- MODAL KAMERA --}}
            <div x-show="showCameraModal" x-cloak
                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
                <div class="bg-zinc-900 rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden border border-zinc-700">
                    <div class="p-4 bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center border border-white/30">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                                    <path d="M12 9a3.75 3.75 0 1 0 0 7.5A3.75 3.75 0 0 0 12 9Z" />
                                    <path fill-rule="evenodd" d="M9.344 3.071a49.52 49.52 0 0 1 5.312 0c.967.052 1.83.585 2.332 1.39l.821 1.317c.24.383.645.643 1.11.71.386.054.77.113 1.152.177 1.432.239 2.429 1.493 2.429 2.909V18a3 3 0 0 1-3 3h-15a3 3 0 0 1-3-3V9.574c0-1.416.997-2.67 2.429-2.909.382-.064.766-.123 1.151-.178a1.56 1.56 0 0 0 1.11-.71l.822-1.315a2.942 2.942 0 0 1 2.332-1.39ZM6.75 12.75a5.25 5.25 0 1 1 10.5 0 5.25 5.25 0 0 1-10.5 0Zm12-1.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-white">Rekaman Kamera</div>
                                <div class="text-[10px] text-blue-100">Proctoring video</div>
                            </div>
                        </div>
                        <button type="button" @click="showCameraModal = false"
                            class="text-white/80 hover:text-white p-1.5 rounded-lg hover:bg-white/10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex border-b border-zinc-700 bg-zinc-800/50">
                        <template x-for="(rec, key) in recordings" :key="key">
                            <button type="button"
                                x-show="rec.camera_url"
                                @click="activeAttempt = key"
                                :class="activeAttempt === key
                                    ? 'border-b-2 border-blue-500 text-blue-400 bg-zinc-900'
                                    : 'text-zinc-400 hover:text-zinc-200'"
                                class="px-4 py-2.5 text-xs font-semibold flex items-center gap-2 transition-all">
                                <span x-text="rec.label"></span>
                                <span class="text-[10px] opacity-70"
                                      x-text="rec.finished_at ? new Date(rec.finished_at).toLocaleString('id-ID', {day:'2-digit', month:'short', hour:'2-digit', minute:'2-digit'}) : ''"></span>
                            </button>
                        </template>
                    </div>

                    <div class="p-4 bg-black">
                        <template x-for="(rec, key) in recordings" :key="'cam-'+key">
                            <video x-show="activeAttempt === key && rec.camera_url"
                                :src="rec.camera_url"
                                controls autoplay
                                class="w-full max-h-[60vh] rounded-lg"
                                style="display:none;"></video>
                        </template>
                        <div x-show="!recordings[activeAttempt]?.camera_url"
                             class="text-center py-12 text-zinc-500 text-sm italic">
                            Rekaman kamera untuk percobaan ini tidak tersedia.
                        </div>
                    </div>

                    <div class="p-3 bg-zinc-800/50 border-t border-zinc-700 flex justify-between items-center">
                        <div class="text-[10px] text-zinc-400">
                            Ukuran: <span x-text="recordings[activeAttempt]?.camera_size ?? '-'" class="font-semibold text-zinc-200"></span>
                        </div>
                        <button type="button" @click="showCameraModal = false"
                            class="px-4 py-1.5 rounded-lg bg-zinc-700 hover:bg-zinc-600 text-white text-xs font-semibold">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>

            {{-- MODAL SCREEN --}}
            <div x-show="showScreenModal" x-cloak
                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
                <div class="bg-zinc-900 rounded-2xl shadow-2xl max-w-4xl w-full overflow-hidden border border-zinc-700">
                    <div class="p-4 bg-gradient-to-r from-emerald-600 to-teal-600 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center border border-white/30">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                                    <path fill-rule="evenodd" d="M2.25 5.25a3 3 0 0 1 3-3h13.5a3 3 0 0 1 3 3V15a3 3 0 0 1-3 3h-3v.257c0 .597.237 1.17.659 1.591l.621.622a.75.75 0 0 1-.53 1.28h-9a.75.75 0 0 1-.53-1.28l.621-.622a2.25 2.25 0 0 0 .659-1.59V18h-3a3 3 0 0 1-3-3V5.25Zm1.5 0v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-white">Rekaman Layar</div>
                                <div class="text-[10px] text-emerald-100">Screen proctoring</div>
                            </div>
                        </div>
                        <button type="button" @click="showScreenModal = false"
                            class="text-white/80 hover:text-white p-1.5 rounded-lg hover:bg-white/10">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex border-b border-zinc-700 bg-zinc-800/50">
                        <template x-for="(rec, key) in recordings" :key="'tab-'+key">
                            <button type="button"
                                x-show="rec.screen_url"
                                @click="activeAttempt = key"
                                :class="activeAttempt === key
                                    ? 'border-b-2 border-emerald-500 text-emerald-400 bg-zinc-900'
                                    : 'text-zinc-400 hover:text-zinc-200'"
                                class="px-4 py-2.5 text-xs font-semibold flex items-center gap-2 transition-all">
                                <span x-text="rec.label"></span>
                                <span class="text-[10px] opacity-70"
                                      x-text="rec.finished_at ? new Date(rec.finished_at).toLocaleString('id-ID', {day:'2-digit', month:'short', hour:'2-digit', minute:'2-digit'}) : ''"></span>
                            </button>
                        </template>
                    </div>

                    <div class="p-4 bg-black">
                        <template x-for="(rec, key) in recordings" :key="'scr-'+key">
                            <video x-show="activeAttempt === key && rec.screen_url"
                                :src="rec.screen_url"
                                controls autoplay
                                class="w-full max-h-[65vh] rounded-lg"
                                style="display:none;"></video>
                        </template>
                        <div x-show="!recordings[activeAttempt]?.screen_url"
                             class="text-center py-12 text-zinc-500 text-sm italic">
                            Rekaman layar untuk percobaan ini tidak tersedia.
                        </div>
                    </div>

                    <div class="p-3 bg-zinc-800/50 border-t border-zinc-700 flex justify-between items-center">
                        <div class="text-[10px] text-zinc-400">
                            Ukuran: <span x-text="recordings[activeAttempt]?.screen_size ?? '-'" class="font-semibold text-zinc-200"></span>
                        </div>
                        <button type="button" @click="showScreenModal = false"
                            class="px-4 py-1.5 rounded-lg bg-zinc-700 hover:bg-zinc-600 text-white text-xs font-semibold">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(!$showFullResult)
        <flux:card class="p-6 shadow-lg">
            @if($hasPending)
                <div class="mb-5 relative overflow-hidden rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 shadow-lg">
                    <div class="p-5 flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border-2 border-white/40 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-white">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-white">Menunggu Verifikasi QC</div>
                            <div class="text-sm text-amber-50">
                                Jawaban Anda sudah tersimpan. Tim QC akan melakukan <strong>verifikasi lokasi</strong>
                                secara manual. Hasil akhir (PASS/FAIL) akan ditampilkan setelah proses review selesai.
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($blindTest->overall_result === 'FAIL' && $blindTest->canRetry())
                <div class="mb-5 relative overflow-hidden rounded-2xl bg-gradient-to-r from-red-500 via-rose-600 to-pink-600 shadow-xl">
                    <div class="p-6 flex items-center gap-5">
                        <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border-2 border-white/40 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-9 h-9 text-white">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-2xl font-bold text-white">FAIL — Percobaan ke-{{ $blindTest->attempt }}</div>
                            <div class="text-sm text-red-50 mt-1">
                                Anda masih memiliki <strong>{{ $blindTest->max_attempt - $blindTest->attempt }} kesempatan lagi</strong>.
                                Kunci jawaban <strong>tidak ditampilkan</strong> sampai percobaan terakhir.
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="space-y-4">
                <div class="rounded-xl border-2 border-red-200 dark:border-red-800 overflow-hidden shadow-sm">
                    <div class="px-4 py-3 bg-gradient-to-r from-red-500 to-rose-500 text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <div class="text-xs font-semibold">Attempt {{ $blindTest->attempt }}</div>
                            <div class="text-[10px] text-white/80">
                                Result: {{ $blindTest->overall_result ?? '-' }} —
                                {{ count($currentVisible) }} jawaban salah
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto bg-white dark:bg-zinc-900">
                        <table class="w-full" style="min-width: 500px;">
                            <thead class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                                <tr>
                                    <th class="px-3 py-2.5 text-left text-[10px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase w-12">#</th>
                                    <th class="px-3 py-2.5 text-left text-[10px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase">Defect Item</th>
                                    <th class="px-3 py-2.5 text-left text-[10px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase">Location</th>
                                    <th class="px-3 py-2.5 text-center text-[10px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase">Hasil</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                @forelse($currentVisible as $i => $row)
                                    @php
                                        $deffect   = $row['deffect_item_id'] ? \App\Models\QAQC\BlindTest\Deffect::find($row['deffect_item_id']) : null;
                                        $locStatus = $row['location_status'] ?? null;
                                    @endphp
                                    <tr class="@if($locStatus === 'pending') bg-amber-50/40 dark:bg-amber-950/10 @else bg-red-50/40 dark:bg-red-950/10 @endif">
                                        <td class="px-3 py-2 text-[11px]">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full font-semibold text-[10px]
                                                @if($locStatus === 'pending') bg-amber-100 text-amber-700 @else bg-red-100 text-red-700 @endif">
                                                {{ $i + 1 }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 text-[11px] font-semibold text-zinc-800 dark:text-white">
                                            {{ $deffect->deffect_item_name ?? '-' }}
                                        </td>
                                        <td class="px-3 py-2 text-[11px]">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-mono font-semibold">
                                                {{ $row['component_location'] ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            @if($locStatus === 'pending')
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 text-[10px] font-semibold border border-amber-300 dark:border-amber-700">
                                                    <flux:icon name="clock" variant="mini" class="w-3 h-3" />
                                                    Menunggu Review
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-[10px] font-semibold border border-red-300 dark:border-red-700">
                                                    <flux:icon name="x-circle" variant="mini" class="w-3 h-3" />
                                                    Tidak Cocok
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-3 py-8 text-center text-[11px] text-zinc-400 italic">
                                            Tidak ada jawaban salah pada attempt ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="flex justify-center gap-3 pt-5">
                <a href="{{ route('qaqc.blind-test') }}" wire:navigate>
                    <button type="button"
                        class="px-5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 text-sm font-medium">
                        Back to Management
                    </button>
                </a>
                @if($blindTest->overall_result === 'FAIL' && $blindTest->canRetry())
                    <button type="button" wire:click="retryTest"
                        @if($isUploadingRecording) disabled @endif
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg text-white text-sm font-semibold shadow-lg transition-all
                            @if($isUploadingRecording)
                                bg-zinc-400 cursor-not-allowed
                            @else
                                bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-blue-500/30
                            @endif">
                        @if($isUploadingRecording)
                            <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Mengunggah rekaman...
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
                            </svg>
                            Kerjakan Ulang Test
                        @endif
                    </button>
                @endif
            </div>
        </flux:card>

        @else
        {{-- CASE B: FULL RESULT --}}
        <flux:card class="p-6 shadow-lg">

            @if(!empty($firstAttemptAnswers))
            <div class="mb-4 rounded-xl bg-gradient-to-r from-purple-500 to-indigo-600 shadow-lg p-4">
                <div class="flex items-center gap-3 flex-wrap">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center border-2 border-white/40 flex-shrink-0">
                        <flux:icon name="arrows-right-left" class="w-5 h-5 text-white" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-bold text-white">Perbandingan Hasil Percobaan</div>
                        <div class="text-xs text-purple-100 mt-0.5">
                            Attempt 1 ({{ $firstAttemptAt?->format('d M Y H:i') ?? '-' }})
                            vs
                            Attempt {{ $blindTest->attempt }} ({{ $blindTest->finished_at?->format('d M Y H:i') ?? '-' }})
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <div class="px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-bold whitespace-nowrap">
                            Attempt 1: {{ $firstAttemptResult ?? '-' }}
                        </div>
                        <div class="px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-bold whitespace-nowrap">
                            Attempt {{ $blindTest->attempt }}: {{ $blindTest->overall_result ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="overflow-x-auto -mx-1 px-1 pb-2">
                <div class="grid grid-cols-3 gap-4" style="min-width: 1280px;">

                    {{-- KUNCI JAWABAN --}}
                    <div class="rounded-xl border-2 border-blue-200 dark:border-blue-800 overflow-hidden shadow-sm flex flex-col">
                        <div class="px-4 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white flex items-center gap-2 flex-shrink-0 whitespace-nowrap">
                            <flux:icon name="lock-closed" class="w-4 h-4" />
                            <div>
                                <div class="text-xs font-semibold">Kunci Jawaban</div>
                                <div class="text-[10px] text-blue-100">{{ count($blindTest->blind_test_items ?? []) }} soal</div>
                            </div>
                        </div>
                        <div class="overflow-x-auto bg-white dark:bg-zinc-900 flex-1">
                            <table class="w-full" style="min-width: 380px;">
                                <thead class="bg-blue-50 dark:bg-blue-900/20 border-b border-blue-200 dark:border-blue-800">
                                    <tr>
                                        <th class="px-3 py-2.5 text-left text-[10px] font-semibold text-blue-700 dark:text-blue-300 uppercase w-12">#</th>
                                        <th class="px-3 py-2.5 text-left text-[10px] font-semibold text-blue-700 dark:text-blue-300 uppercase" style="min-width: 180px;">Defect Item</th>
                                        <th class="px-3 py-2.5 text-left text-[10px] font-semibold text-blue-700 dark:text-blue-300 uppercase" style="min-width: 120px;">Location</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                    @foreach($blindTest->blind_test_items ?? [] as $i => $item)
                                    @php
                                        $deffect = \App\Models\QAQC\BlindTest\Deffect::find($item['deffect_item_id'] ?? null);
                                    @endphp
                                    <tr class="hover:bg-blue-50/50 dark:hover:bg-blue-950/10 whitespace-nowrap">
                                        <td class="px-3 py-2 text-[11px]">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-semibold text-[10px]">
                                                {{ $i + 1 }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 text-[11px] font-semibold text-zinc-800 dark:text-white whitespace-nowrap">
                                            {{ $deffect->deffect_item_name ?? '-' }}
                                        </td>
                                        <td class="px-3 py-2 text-[11px] whitespace-nowrap">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-mono font-semibold whitespace-nowrap">
                                                {{ $item['component_location'] ?? '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- ATTEMPT 1 --}}
                    <div class="rounded-xl border-2 {{ ($firstAttemptResult ?? '') === 'PASS' ? 'border-green-200 dark:border-green-800' : 'border-red-200 dark:border-red-800' }} overflow-hidden shadow-sm flex flex-col">
                        <div class="px-4 py-3 bg-gradient-to-r {{ ($firstAttemptResult ?? '') === 'PASS' ? 'from-green-500 to-emerald-500' : 'from-red-500 to-rose-500' }} text-white flex items-center gap-2 flex-shrink-0 whitespace-nowrap">
                            <flux:icon name="document-text" class="w-4 h-4" />
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-semibold">Attempt 1</div>
                                <div class="text-[10px] text-white/80">Result: {{ $firstAttemptResult ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="overflow-x-auto bg-white dark:bg-zinc-900 flex-1">
                            <table class="w-full" style="min-width: 440px;">
                                <thead class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                                    <tr>
                                        <th class="px-3 py-2.5 text-left text-[10px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase w-12">#</th>
                                        <th class="px-3 py-2.5 text-left text-[10px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase" style="min-width: 180px;">Defect Item</th>
                                        <th class="px-3 py-2.5 text-left text-[10px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase" style="min-width: 120px;">Location</th>
                                        <th class="px-3 py-2.5 text-center text-[10px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase" style="min-width: 130px;">Hasil</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                    @forelse($firstAttemptAnswers as $i => $row)
                                    @php
                                        $deffect     = $row['deffect_item_id'] ? \App\Models\QAQC\BlindTest\Deffect::find($row['deffect_item_id']) : null;
                                        $userAnswer  = $row['user_answer'] ?? '';
                                        $isCorrect   = $row['is_correct'] ?? false;
                                        $isMissing   = $userAnswer === 'MISSING';
                                    @endphp
                                    <tr class="whitespace-nowrap @if($isCorrect) bg-green-50/40 dark:bg-green-950/10 @elseif($isMissing) bg-yellow-50/40 dark:bg-yellow-950/10 @else bg-red-50/40 dark:bg-red-950/10 @endif">
                                        <td class="px-3 py-2 text-[11px]">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full font-semibold text-[10px]
                                                @if($isCorrect) bg-green-100 text-green-700
                                                @elseif($isMissing) bg-yellow-100 text-yellow-700
                                                @else bg-red-100 text-red-700 @endif">
                                                {{ $i + 1 }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 text-[11px] font-semibold text-zinc-800 dark:text-white whitespace-nowrap">
                                            {{ $deffect->deffect_item_name ?? '-' }}
                                        </td>
                                        <td class="px-3 py-2 text-[11px] whitespace-nowrap">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-mono font-semibold whitespace-nowrap">
                                                {{ $row['component_location'] ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 text-center whitespace-nowrap">
                                            @if($isCorrect)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-[10px] font-semibold border border-green-300 dark:border-green-700 whitespace-nowrap">
                                                    <flux:icon name="check-circle" variant="mini" class="w-3 h-3" />
                                                    Cocok
                                                </span>
                                            @elseif($isMissing)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 text-[10px] font-semibold border border-yellow-300 dark:border-yellow-700 whitespace-nowrap">
                                                    <flux:icon name="exclamation-triangle" variant="mini" class="w-3 h-3" />
                                                    Tidak Dijawab
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-[10px] font-semibold border border-red-300 dark:border-red-700 whitespace-nowrap">
                                                    <flux:icon name="x-circle" variant="mini" class="w-3 h-3" />
                                                    Tidak Cocok
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-3 py-8 text-center text-[11px] text-zinc-400 italic whitespace-nowrap">
                                            Tidak ada data attempt 1
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- ATTEMPT CURRENT --}}
                    <div class="rounded-xl border-2 {{ ($blindTest->overall_result ?? '') === 'PASS' ? 'border-green-200 dark:border-green-800' : 'border-red-200 dark:border-red-800' }} overflow-hidden shadow-sm flex flex-col">
                        <div class="px-4 py-3 bg-gradient-to-r {{ ($blindTest->overall_result ?? '') === 'PASS' ? 'from-green-500 to-emerald-500' : 'from-red-500 to-rose-500' }} text-white flex items-center gap-2 flex-shrink-0 whitespace-nowrap">
                            <flux:icon name="document-text" class="w-4 h-4" />
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-semibold">Attempt {{ $blindTest->attempt }}</div>
                                <div class="text-[10px] text-white/80">Result: {{ $blindTest->overall_result ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="overflow-x-auto bg-white dark:bg-zinc-900 flex-1">
                            <table class="w-full" style="min-width: 440px;">
                                <thead class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                                    <tr>
                                        <th class="px-3 py-2.5 text-left text-[10px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase w-12">#</th>
                                        <th class="px-3 py-2.5 text-left text-[10px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase" style="min-width: 180px;">Defect Item</th>
                                        <th class="px-3 py-2.5 text-left text-[10px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase" style="min-width: 120px;">Location</th>
                                        <th class="px-3 py-2.5 text-center text-[10px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase" style="min-width: 130px;">Hasil</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                    @forelse($evaluationResult ?? [] as $i => $row)
                                    @php
                                        $deffect     = $row['deffect_item_id'] ? \App\Models\QAQC\BlindTest\Deffect::find($row['deffect_item_id']) : null;
                                        $userAnswer  = $row['user_answer'] ?? '';
                                        $isCorrect   = $row['is_correct'] ?? false;
                                        $isMissing   = $userAnswer === 'MISSING';
                                    @endphp
                                    <tr class="whitespace-nowrap @if($isCorrect) bg-green-50/40 dark:bg-green-950/10 @elseif($isMissing) bg-yellow-50/40 dark:bg-yellow-950/10 @else bg-red-50/40 dark:bg-red-950/10 @endif">
                                        <td class="px-3 py-2 text-[11px]">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full font-semibold text-[10px]
                                                @if($isCorrect) bg-green-100 text-green-700
                                                @elseif($isMissing) bg-yellow-100 text-yellow-700
                                                @else bg-red-100 text-red-700 @endif">
                                                {{ $i + 1 }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 text-[11px] font-semibold text-zinc-800 dark:text-white whitespace-nowrap">
                                            {{ $deffect->deffect_item_name ?? '-' }}
                                        </td>
                                        <td class="px-3 py-2 text-[11px] whitespace-nowrap">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-mono font-semibold whitespace-nowrap">
                                                {{ $row['component_location'] ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 text-center whitespace-nowrap">
                                            @if($isCorrect)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-[10px] font-semibold border border-green-300 dark:border-green-700 whitespace-nowrap">
                                                    <flux:icon name="check-circle" variant="mini" class="w-3 h-3" />
                                                    Cocok
                                                </span>
                                            @elseif($isMissing)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 text-[10px] font-semibold border border-yellow-300 dark:border-yellow-700 whitespace-nowrap">
                                                    <flux:icon name="exclamation-triangle" variant="mini" class="w-3 h-3" />
                                                    Tidak Dijawab
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-[10px] font-semibold border border-red-300 dark:border-red-700 whitespace-nowrap">
                                                    <flux:icon name="x-circle" variant="mini" class="w-3 h-3" />
                                                    Tidak Cocok
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </flux:card>
        @endif
    @endif

    <!-- Notifikasi -->
    <div x-data="{ show: false, message: '', type: 'success' }"
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
         x-show="show" x-transition
         class="fixed bottom-4 right-4 z-50"
         :class="{ 'bg-green-500': type === 'success', 'bg-red-500': type === 'error', 'bg-yellow-500': type === 'warning' }"
         style="display: none;">
        <div class="text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
            </svg>
            <span x-text="message"></span>
        </div>
    </div>

    <style>[x-cloak] { display: none !important; }</style>

    {{-- ==================== SCRIPT CAMERA PROCTORING ==================== --}}
    <script>
    function cameraProctoring() {
        return {
            checks: [],
            cameraOk: false,
            allOk: false,

            previewStream: null,
            recordStream: null,
            mediaRecorder: null,
            chunks: [],
            recordingActive: false,
            recordingDuration: '00:00',
            recordingSeconds: 0,
            timerInterval: null,
            mimeType: '',
            hasAttachedExisting: false,

            screenStream: null,
            screenRecorder: null,
            screenChunks: [],
            screenRecordingActive: false,
            screenDuration: '00:00',
            screenSeconds: 0,
            screenTimerInterval: null,
            screenMimeType: '',
            screenSupported: true,
            screenNeedsResume: false,

            initProctoring() {
                @if($showBrowserCheckModal)
                    this.runBrowserChecks();
                @endif

                @if($isStarted && !$isFinished)
                    this.$nextTick(() => {
                        this.attachExistingStream();

                        setTimeout(() => {
                            if (!this.screenRecorder && this.screenSupported) {
                                this.screenNeedsResume = true;
                            }
                        }, 1500);
                    });
                @endif

                window.addEventListener('camera-start-recording', () => {
                    this.startRecording();
                    this.startScreenRecording();
                });

                window.addEventListener('camera-stop-recording', () => {
                    this.stopRecording();
                    this.stopScreenRecording();
                });

                window.addEventListener('camera-lost', () => {
                    @this.cameraLost();
                });

                window.addEventListener('beforeunload', () => {
                    try { this.mediaRecorder && this.mediaRecorder.state !== 'inactive' && this.mediaRecorder.stop(); } catch (e) {}
                    try { this.screenRecorder && this.screenRecorder.state !== 'inactive' && this.screenRecorder.stop(); } catch (e) {}
                });
            },

            async runBrowserChecks() {
                this.checks = [];

                const ua = navigator.userAgent;
                const isMobile = /Android|iPhone|iPad|iPod/i.test(ua);

                this.checks.push({ label: 'Browser', value: ua.substring(0, 60) + '...', ok: true });

                const secure = window.isSecureContext || location.hostname === 'localhost';
                this.checks.push({
                    label: 'Koneksi Aman (HTTPS)',
                    value: secure ? 'Aman' : 'Tidak aman — kamera diblokir browser',
                    ok: secure
                });

                const camSupport = !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
                this.checks.push({
                    label: 'Dukungan Kamera',
                    value: camSupport ? 'Didukung' : 'Browser tidak mendukung',
                    ok: camSupport
                });

                this.checks.push({
                    label: 'Tipe Perangkat',
                    value: isMobile ? 'Mobile / Tablet' : 'Desktop / Laptop',
                    ok: true
                });

                const recSupport = typeof MediaRecorder !== 'undefined';
                this.checks.push({
                    label: 'Perekam Video',
                    value: recSupport ? 'Tersedia' : 'Tidak tersedia',
                    ok: recSupport
                });

                const screenSupport = !!(navigator.mediaDevices && navigator.mediaDevices.getDisplayMedia);
                this.screenSupported = screenSupport;
                this.checks.push({
                    label: 'Perekam Layar',
                    value: screenSupport ? 'Didukung' : 'Tidak didukung (kamera saja)',
                    ok: true
                });

                if (camSupport && secure && recSupport) {
                    await this.requestCamera();
                }
                this.updateAllOk();
            },

            async requestCamera() {
                try {
                    if (this.previewStream) {
                        this.previewStream.getTracks().forEach(t => t.stop());
                        this.previewStream = null;
                    }

                    this.previewStream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'user', width: { ideal: 320 }, height: { ideal: 240 } },
                        audio: false
                    });

                    this.cameraOk = true;

                    this.$nextTick(() => {
                        if (this.$refs.preview) {
                            this.$refs.preview.srcObject = this.previewStream;
                        }
                    });

                    @this.confirmCameraReady();

                    this.updateAllOk();
                } catch (err) {
                    this.cameraOk = false;
                    this.updateAllOk();
                    alert('Kamera tidak bisa diakses: ' + err.message +
                          '\n\nSilakan izinkan kamera di pengaturan browser.');
                }
            },

            updateAllOk() {
                this.allOk = this.checks.every(c => c.ok) && this.cameraOk;
            },

            confirmAndClose() {
                if (!this.allOk) return;

                const info = {
                    userAgent: navigator.userAgent,
                    platform:  navigator.platform,
                    screen:    screen.width + 'x' + screen.height,
                    language:  navigator.language,
                    screenRecordingSupported: this.screenSupported,
                    timestamp: new Date().toISOString(),
                };

                @this.confirmCameraReady();
                @this.confirmBrowserCheck(info);
            },

            async attachExistingStream() {
                if (this.hasAttachedExisting) return;
                this.hasAttachedExisting = true;

                try {
                    if (!this.recordStream) {
                        if (this.previewStream && this.previewStream.active) {
                            this.recordStream = this.previewStream;
                            this.previewStream = null;
                        } else {
                            this.recordStream = await navigator.mediaDevices.getUserMedia({
                                video: {
                                    facingMode: 'user',
                                    width:     { ideal: 320, max: 480 },
                                    height:    { ideal: 240, max: 360 },
                                    frameRate: { ideal: 10,  max: 15 }   // ⬅️ tambah ini
                                },
                                audio: false
                            });
                        }

                        this.$nextTick(() => {
                            if (this.$refs.camPreview) {
                                this.$refs.camPreview.srcObject = this.recordStream;
                            }
                        });
                    }

                    this.startRecording();
                    @this.confirmCameraReady();
                } catch (e) {
                    console.warn('Tidak bisa akses kamera untuk preview:', e);
                }
            },

            async startRecording() {
                if (this.mediaRecorder) return;

                try {
                    if (!this.recordStream) {
                        if (this.previewStream && this.previewStream.active) {
                            this.recordStream = this.previewStream;
                            this.previewStream = null;
                        } else {
                            this.recordStream = await navigator.mediaDevices.getUserMedia({
                                video: {
                                    facingMode: 'user',
                                    width:     { ideal: 320, max: 480 },
                                    height:    { ideal: 240, max: 360 },
                                    frameRate: { ideal: 10,  max: 15 }   // ⬅️ tambah ini
                                },
                                audio: false
                            });
                        }

                        this.$nextTick(() => {
                            if (this.$refs.camPreview) {
                                this.$refs.camPreview.srcObject = this.recordStream;
                            }
                        });
                    }

                    const candidates = [
                        'video/webm;codecs=vp9,opus',
                        'video/webm;codecs=vp8,opus',
                        'video/webm',
                    ];
                    this.mimeType = '';
                    for (const m of candidates) {
                        if (MediaRecorder.isTypeSupported(m)) { this.mimeType = m; break; }
                    }

                    this.mediaRecorder = new MediaRecorder(this.recordStream, {
                        mimeType: this.mimeType || undefined,
                        videoBitsPerSecond: 120000,   // ⬅️ 250k → 120k
                        audioBitsPerSecond: 0,
                    });

                    this.chunks = [];

                    this.mediaRecorder.ondataavailable = (e) => {
                        if (e.data && e.data.size > 0) this.chunks.push(e.data);
                    };

                    this.mediaRecorder.onstop = () => {
                        const blob = new Blob(this.chunks, { type: this.mimeType || 'video/webm' });
                        this.chunks = [];
                        this.uploadCameraBlob(blob);
                    };

                    this.mediaRecorder.start(10000);   // ⬅️ 5s → 10s

                    this.recordingActive = true;
                    this.recordingSeconds = 0;
                    this.recordingDuration = '00:00';

                    if (this.timerInterval) clearInterval(this.timerInterval);
                    this.timerInterval = setInterval(() => {
                        this.recordingSeconds++;
                        const m = String(Math.floor(this.recordingSeconds / 60)).padStart(2, '0');
                        const s = String(this.recordingSeconds % 60).padStart(2, '0');
                        this.recordingDuration = `${m}:${s}`;
                    }, 1000);

                    @this.markCameraStarted();
                    @this.confirmCameraReady();

                    const camTrack = this.recordStream.getVideoTracks()[0];
                    if (camTrack) {
                        camTrack.addEventListener('ended', () => {
                            this.cameraOk = false;
                            this.recordingActive = false;
                            window.dispatchEvent(new Event('camera-lost'));
                        });
                    }

                } catch (e) {
                    console.error('Gagal mulai rekam kamera:', e);
                    alert('Gagal memulai rekaman kamera: ' + e.message);
                }
            },

            stopRecording() {
                if (this.mediaRecorder && this.mediaRecorder.state !== 'inactive') {
                    this.mediaRecorder.stop();
                }
                if (this.timerInterval) {
                    clearInterval(this.timerInterval);
                    this.timerInterval = null;
                }
                this.recordingActive = false;
            },

            uploadCameraBlob(blob) {
                if (!blob || blob.size === 0) {
                    console.warn('Camera blob kosong, skip upload.');
                    this.cleanupCameraStream();
                    return;
                }

                const file = new File(
                    [blob],
                    `blind-test-cam-${Date.now()}.webm`,
                    { type: blob.type || 'video/webm' }
                );

                @this.setUploadingRecording(true);

                @this.upload('cameraRecordingTemp', file,
                    () => {
                        @this.uploadCameraRecording();
                        this.cleanupCameraStream();
                        @this.setUploadingRecording(false);
                    },
                    (err) => {
                        console.error('Upload kamera gagal:', err);
                        @this.dispatch('notify', { message: 'Gagal upload rekaman kamera.', type: 'error' });
                        this.cleanupCameraStream();
                        @this.setUploadingRecording(false);
                    },
                    (event) => {}
                );
            },

            cleanupCameraStream() {
                if (this.recordStream) {
                    this.recordStream.getTracks().forEach(t => t.stop());
                    this.recordStream = null;
                }
                if (this.previewStream) {
                    this.previewStream.getTracks().forEach(t => t.stop());
                    this.previewStream = null;
                }
                this.mediaRecorder = null;
            },

            async startScreenRecording() {
                if (this.screenRecorder) return;

                if (!navigator.mediaDevices || !navigator.mediaDevices.getDisplayMedia) {
                    this.screenSupported = false;
                    console.warn('Screen recording tidak didukung browser ini.');
                    @this.dispatch('notify', {
                        message: 'Browser ini tidak mendukung perekaman layar. Hanya kamera yang direkam.',
                        type: 'warning'
                    });
                    return;
                }

                try {
                    this.screenStream = await navigator.mediaDevices.getDisplayMedia({
                        video: {
                            frameRate: { ideal: 10, max: 15 },
                            width:    { ideal: 1280, max: 1920 },
                            height:   { ideal: 720,  max: 1080 },
                            displaySurface: 'monitor',
                        },
                        audio: false,
                        preferCurrentTab: false,
                        selfBrowserSurface: 'exclude',
                        systemAudio: 'include',
                        surfaceSwitching: 'exclude',
                    });

                    const videoTrackCheck = this.screenStream.getVideoTracks()[0];
                    const settings = videoTrackCheck.getSettings ? videoTrackCheck.getSettings() : {};
                    const surface  = settings.displaySurface;

                    if (surface && surface !== 'monitor') {
                        @this.dispatch('notify', {
                            message: 'Anda memilih "' + surface + '". Disarankan pilih "Entire Screen".',
                            type: 'warning'
                        });
                    }

                    this.$nextTick(() => {
                        if (this.$refs.screenPreview) {
                            this.$refs.screenPreview.srcObject = this.screenStream;
                        }
                    });

                    const candidates = [
                        'video/webm;codecs=vp9',
                        'video/webm;codecs=vp8',
                        'video/webm',
                    ];
                    this.screenMimeType = '';
                    for (const m of candidates) {
                        if (MediaRecorder.isTypeSupported(m)) { this.screenMimeType = m; break; }
                    }

                    this.screenRecorder = new MediaRecorder(this.screenStream, {
                        mimeType: this.screenMimeType || undefined,
                        videoBitsPerSecond: 500000,
                    });

                    this.screenChunks = [];

                    this.screenRecorder.ondataavailable = (e) => {
                        if (e.data && e.data.size > 0) this.screenChunks.push(e.data);
                    };

                    this.screenRecorder.onstop = () => {
                        const blob = new Blob(this.screenChunks, {
                            type: this.screenMimeType || 'video/webm'
                        });
                        this.screenChunks = [];
                        this.uploadScreenBlob(blob);
                    };

                    const videoTrack = this.screenStream.getVideoTracks()[0];
                    if (videoTrack) {
                        videoTrack.addEventListener('ended', () => {
                            console.warn('User menghentikan share screen.');
                            this.stopScreenRecording();
                            this.screenNeedsResume = true;
                            @this.screenLost();
                            @this.dispatch('notify', {
                                message: 'Anda menghentikan share screen. Klik "Resume" untuk lanjut merekam layar.',
                                type: 'warning'
                            });
                        });
                    }

                    this.screenRecorder.start(5000);

                    this.screenRecordingActive = true;
                    this.screenNeedsResume = false;
                    this.screenSeconds = 0;
                    this.screenDuration = '00:00';

                    if (this.screenTimerInterval) clearInterval(this.screenTimerInterval);
                    this.screenTimerInterval = setInterval(() => {
                        this.screenSeconds++;
                        const m = String(Math.floor(this.screenSeconds / 60)).padStart(2, '0');
                        const s = String(this.screenSeconds % 60).padStart(2, '0');
                        this.screenDuration = `${m}:${s}`;
                    }, 1000);

                    @this.markScreenStarted();

                } catch (err) {
                    this.screenSupported = false;
                    this.screenNeedsResume = false;
                    console.warn('Screen recording dibatalkan:', err);

                    @this.dispatch('notify', {
                        message: 'Perekaman layar dibatalkan. Test tetap berjalan dengan kamera saja.',
                        type: 'warning'
                    });
                }
            },

            async resumeScreenRecording() {
                this.screenNeedsResume = false;
                @this.logScreenResume();
                await this.startScreenRecording();
            },

            stopScreenRecording() {
                if (this.screenRecorder && this.screenRecorder.state !== 'inactive') {
                    this.screenRecorder.stop();
                }
                if (this.screenTimerInterval) {
                    clearInterval(this.screenTimerInterval);
                    this.screenTimerInterval = null;
                }
                this.screenRecordingActive = false;
            },

            uploadScreenBlob(blob) {
                if (!blob || blob.size === 0) {
                    console.warn('Screen blob kosong, skip upload.');
                    this.cleanupScreenStream();
                    return;
                }

                const file = new File(
                    [blob],
                    `blind-test-screen-${Date.now()}.webm`,
                    { type: blob.type || 'video/webm' }
                );

                @this.setUploadingRecording(true);

                @this.upload('screenRecordingTemp', file,
                    () => {
                        @this.uploadScreenRecording();
                        this.cleanupScreenStream();
                        @this.setUploadingRecording(false);
                    },
                    (err) => {
                        console.error('Upload screen gagal:', err);
                        @this.dispatch('notify', { message: 'Gagal upload rekaman layar.', type: 'error' });
                        this.cleanupScreenStream();
                        @this.setUploadingRecording(false);
                    },
                    (event) => {}
                );
            },

            cleanupScreenStream() {
                if (this.screenStream) {
                    this.screenStream.getTracks().forEach(t => t.stop());
                    this.screenStream = null;
                }
                if (this.$refs.screenPreview) {
                    this.$refs.screenPreview.srcObject = null;
                }
                this.screenRecorder = null;
            },
        };
    }
    </script>
</div>