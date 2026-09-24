<div class="p-1 space-y-3" @if($isStarted && !$isFinished) wire:poll.3s="syncTimer" @endif>
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('qaqc.blind-test') }}" wire:navigate separator="slash" class="font-semibold text-blue-600">QA/QC</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Blind Test Execution</flux:breadcrumbs.item>
    </flux:breadcrumbs>

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
                {{-- Timer (kalau test berjalan) --}}
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

                {{-- Tombol Back to Management --}}
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

    <!-- ==================== INFO CARD (80%) + RESULT (20%) ==================== -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-3">

        <!-- Info Card 80% -->
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

                    {{-- Model (bisa multiple) --}}
                    @php
                        $modelIds = collect($blindTest->question_snapshot ?? [])
                            ->pluck('model_id')
                            ->filter()
                            ->unique()
                            ->values();

                        if ($modelIds->isEmpty() && $blindTest->model_id) {
                            $modelIds = collect([$blindTest->model_id]);
                        }

                        $infoModels = $modelIds->isNotEmpty()
                            ? \App\Models\QAQC\BlindTest\Model::whereIn('id', $modelIds)->get()
                            : collect();
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
                                    {{ $infoModels->first()->model_name }}
                                </div>
                            @else
                                <div class="flex flex-wrap gap-1 mt-0.5">
                                    @foreach($infoModels as $m)
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300">
                                            {{ $m->model_name }}
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
            <flux:button wire:click="startTest" variant="primary" icon="play" class="bg-blue-600 hover:bg-blue-700 !text-base !px-8 !py-3">
                Start Test Now
            </flux:button>
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
            <flux:button wire:click="addRow" size="sm" icon="plus" variant="primary" class="bg-blue-600 hover:bg-blue-700">
                Tambah Baris
            </flux:button>
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

        <div class="mt-6 flex justify-end pt-4 border-t border-zinc-200 dark:border-zinc-700">
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

            // Filter baris untuk mode "belum full" (tanpa kunci)
            $currentVisible = $blindTest->filterVisibleAnswers($evaluationResult ?? []);
            $firstVisible   = $blindTest->filterVisibleAnswers($firstAttemptAnswers ?? []);
        @endphp

        @if(!$showFullResult)
        {{-- ============================================================ --}}
        {{-- CASE A: BELUM FULL — attempt 1 atau ada pending review        --}}
        {{-- Tanpa kunci jawaban, tanpa baris MISSING                      --}}
        {{-- ============================================================ --}}
        <flux:card class="p-6 shadow-lg">

            {{-- Banner --}}
            @if($hasPending)
                {{-- Banner kuning: menunggu verifikasi QC --}}
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
                {{-- Banner merah: FAIL, masih bisa retry --}}
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

            {{-- Tabel Attempt(s) — tanpa kunci, tanpa MISSING --}}
            <div class="space-y-4">

                {{-- Kalau attempt 2 → tampilkan attempt 1 dulu --}}
                @if($isSecondAttempt)
                <div class="rounded-xl border-2 border-red-200 dark:border-red-800 overflow-hidden shadow-sm">
                    <div class="px-4 py-3 bg-gradient-to-r from-red-500 to-rose-500 text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clip-rule="evenodd" />
                            <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                        </svg>
                        <div>
                            <div class="text-xs font-semibold">Attempt 1</div>
                            <div class="text-[10px] text-white/80">
                                Result: {{ $blindTest->first_attempt_result ?? '-' }} —
                                {{ count($firstVisible) }} jawaban salah
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
                                @forelse($firstVisible as $i => $row)
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
                @endif

                {{-- Current attempt --}}
                <div class="rounded-xl border-2 border-red-200 dark:border-red-800 overflow-hidden shadow-sm">
                    <div class="px-4 py-3 bg-gradient-to-r from-red-500 to-rose-500 text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clip-rule="evenodd" />
                            <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
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

            {{-- Tombol --}}
            <div class="flex justify-center gap-3 pt-5">
                <a href="{{ route('qaqc.blind-test') }}" wire:navigate>
                    <button type="button"
                        class="px-5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 text-sm font-medium">
                        Back to Management
                    </button>
                </a>
                @if($blindTest->overall_result === 'FAIL' && $blindTest->canRetry())
                    <button type="button" wire:click="retryTest"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-semibold shadow-lg shadow-blue-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
                        </svg>
                        Kerjakan Ulang Test
                    </button>
                @endif
            </div>
        </flux:card>

        @else
        {{-- ============================================================ --}}
        {{-- CASE B: FULL RESULT — attempt terakhir & tidak ada pending    --}}
        {{-- Tampilkan kunci + Attempt 1 + Attempt 2 (lengkap + MISSING)   --}}
        {{-- ============================================================ --}}
        <flux:card class="p-6 shadow-lg">

            {{-- Banner attempt ke-2 --}}
            @if($isSecondAttempt)
            <div class="mb-5 relative overflow-hidden rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 shadow-lg">
                <div class="p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center border-2 border-white/40 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="text-sm font-bold text-white">Percobaan ke-{{ $blindTest->attempt }} (Terakhir)</div>
                        <div class="text-xs text-indigo-100 mt-0.5">
                            Semua hasil ditampilkan: kunci jawaban & jawaban Anda.
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Card: Info history --}}
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

            {{-- Horizontal scroll wrapper --}}
            <div class="overflow-x-auto -mx-1 px-1 pb-2">
                <div class="grid grid-cols-3 gap-4" style="min-width: 1280px;">

                    {{-- ============ KOLOM 1: KUNCI JAWABAN ============ --}}
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

                    {{-- ============ KOLOM 2: ATTEMPT 1 ============ --}}
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

                    {{-- ============ KOLOM 3: ATTEMPT CURRENT (2) ============ --}}
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
</div>