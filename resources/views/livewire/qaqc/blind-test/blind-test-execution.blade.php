<div class="p-1 space-y-3" @if($isStarted && !$isFinished) wire:poll.5s="syncTimer" @endif>
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
                        {{-- Hitung mundur: MENIT:DETIK --}}
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
                        {{-- Hitung maju: MENIT:DETIK --}}
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
                    @if($blindTest->duration_minutes && $blindTest->started_at)
                        Waktu pengerjaan ({{ $blindTest->duration_minutes }} menit) sudah habis.
                    @else
                        Batas waktu pengerjaan: <strong>{{ $blindTest->time_test ? $blindTest->time_test->format('H:i') : '-' }}</strong>.
                    @endif
                    Test tidak bisa dimulai atau disubmit melewati batas waktu.
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

                    {{-- Model --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-amber-600 dark:text-amber-400">
                                <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                                <path fill-rule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">Model</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white">{{ $blindTest->model->model_name ?? '-' }}</div>
                        </div>
                    </div>

                    {{-- Time Test --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-cyan-600 dark:text-cyan-400">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">Time Test (Deadline)</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white">{{ $blindTest->time_test ? $blindTest->time_test->format('H:i') : '-' }}</div>
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
                    @if($overallResult === 'PASS') bg-gradient-to-br from-green-500 to-emerald-600
                    @else bg-gradient-to-br from-red-500 to-rose-600 @endif
                @else
                    bg-gradient-to-br from-zinc-400 to-zinc-500
                @endif">

                @if($isFinished)
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
            </div>
        </div>
    </div>

    <!-- ==================== BELUM MULAI ==================== -->
    @if(!$isStarted && !$isFinished)
    <flux:card class="p-12 text-center shadow-lg">
        @if($isExpired)
            {{-- Expired state --}}
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
            {{-- Normal state --}}
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
                ⏰ Deadline mulai: <strong>{{ $blindTest->time_test->format('H:i') }}</strong>
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

        {{-- Warning kalau sisa waktu < 5 menit --}}
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
    <flux:card class="p-6 shadow-lg">

        <!-- ============ TABEL SIDE BY SIDE ============ -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            <!-- TABEL 1: KUNCI -->
            <div class="rounded-xl border-2 border-blue-200 dark:border-blue-800 overflow-hidden shadow-sm">
                <div class="px-5 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold">Tabel Kunci Jawaban</h3>
                        <p class="text-[11px] text-blue-100">Setup QC — {{ count($blindTest->blind_test_items ?? []) }} soal</p>
                    </div>
                </div>
                <div class="overflow-x-auto bg-white dark:bg-zinc-900">
                    <table class="w-full">
                        <thead class="bg-blue-50 dark:bg-blue-900/20 border-b border-blue-200 dark:border-blue-800">
                            <tr>
                                <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-blue-700 dark:text-blue-300 uppercase tracking-wider w-10">#</th>
                                <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-blue-700 dark:text-blue-300 uppercase tracking-wider">Deffect Item</th>
                                <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-blue-700 dark:text-blue-300 uppercase tracking-wider">Location</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($blindTest->blind_test_items ?? [] as $i => $item)
                            @php
                                $deffect = \App\Models\QAQC\BlindTest\Deffect::find($item['deffect_item_id'] ?? null);
                            @endphp
                            <tr class="hover:bg-blue-50/50 dark:hover:bg-blue-950/10 transition-colors">
                                <td class="px-3 py-2.5 text-xs">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-semibold text-[10px]">
                                        {{ $i + 1 }}
                                    </span>
                                </td>
                                <td class="px-3 py-2.5 text-xs font-semibold text-zinc-800 dark:text-white">
                                    {{ $deffect->deffect_item_name ?? '-' }}
                                </td>
                                <td class="px-3 py-2.5 text-xs">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-mono text-[10px] font-semibold">
                                        {{ $item['component_location'] ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TABEL 2: JAWABAN USER -->
            <div class="rounded-xl border-2 border-green-200 dark:border-green-800 overflow-hidden shadow-sm">
                <div class="px-5 py-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold">Tabel Jawaban User</h3>
                        <p class="text-[11px] text-green-100">{{ count($evaluationResult ?? []) }} baris</p>
                    </div>
                </div>
                <div class="overflow-x-auto bg-white dark:bg-zinc-900">
                    <table class="w-full">
                        <thead class="bg-green-50 dark:bg-green-900/20 border-b border-green-200 dark:border-green-800">
                            <tr>
                                <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-green-700 dark:text-green-300 uppercase tracking-wider w-10">#</th>
                                <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-green-700 dark:text-green-300 uppercase tracking-wider">Deffect Item</th>
                                <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-green-700 dark:text-green-300 uppercase tracking-wider">Location</th>
                                <th class="px-3 py-2.5 text-center text-[11px] font-semibold text-green-700 dark:text-green-300 uppercase tracking-wider w-32">Hasil</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($evaluationResult ?? [] as $i => $row)
                            @php
                                $deffect = $row['deffect_item_id']
                                    ? \App\Models\QAQC\BlindTest\Deffect::find($row['deffect_item_id'])
                                    : null;
                                $userAnswer = $row['user_answer'] ?? '';
                                $isCorrect = $row['is_correct'] ?? false;
                                $isMissing = $userAnswer === 'MISSING';
                                $isExtra = $userAnswer === 'EXTRA';

                                $rowClass = '';
                                if ($isCorrect) {
                                    $rowClass = 'hover:bg-green-50/50 dark:hover:bg-green-950/10';
                                } elseif ($isMissing) {
                                    $rowClass = 'bg-yellow-50/50 dark:bg-yellow-950/10';
                                } elseif ($isExtra) {
                                    $rowClass = 'bg-purple-50/50 dark:bg-purple-950/10';
                                } else {
                                    $rowClass = 'bg-red-50/50 dark:bg-red-950/10';
                                }
                            @endphp
                            <tr class="{{ $rowClass }} transition-colors">
                                <td class="px-3 py-2.5 text-xs">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full font-semibold text-[10px]
                                        @if($isCorrect) bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300
                                        @elseif($isMissing) bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300
                                        @elseif($isExtra) bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300
                                        @else bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 @endif">
                                        {{ $i + 1 }}
                                    </span>
                                </td>
                                <td class="px-3 py-2.5 text-xs">
                                    <div class="font-semibold text-zinc-800 dark:text-white">
                                        {{ $deffect->deffect_item_name ?? '-' }}
                                    </div>
                                    @if($isMissing)
                                        <div class="text-[10px] text-orange-600 dark:text-orange-400 italic mt-0.5">Dari kunci</div>
                                    @endif
                                    @if($isExtra)
                                        <div class="text-[10px] text-purple-600 dark:text-purple-400 italic mt-0.5">Extra</div>
                                    @endif
                                </td>
                                <td class="px-3 py-2.5 text-xs">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-mono text-[10px] font-semibold">
                                        {{ $row['component_location'] ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-3 py-2.5 text-center">
                                    @if($isCorrect)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-[10px] font-semibold border border-green-300 dark:border-green-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                            </svg>
                                            Cocok
                                        </span>
                                    @elseif($isMissing)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 text-[10px] font-semibold border border-yellow-300 dark:border-yellow-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                                <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                            </svg>
                                            Tidak Dijawab
                                        </span>
                                    @elseif($isExtra)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-[10px] font-semibold border border-purple-300 dark:border-purple-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                            </svg>
                                            Extra
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-[10px] font-semibold border border-red-300 dark:border-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                            </svg>
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

        <!-- Legend -->
        <div class="mt-4 px-4 py-3 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 flex flex-wrap gap-4 text-xs justify-end">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-purple-500 shadow-sm"></span>
                <span class="text-zinc-600 dark:text-zinc-400 font-medium">Extra (tidak ada di kunci)</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-yellow-500 shadow-sm"></span>
                <span class="text-zinc-600 dark:text-zinc-400 font-medium">Ada di kunci tapi tidak dijawab</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-red-500 shadow-sm"></span>
                <span class="text-zinc-600 dark:text-zinc-400 font-medium">Tidak cocok</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-green-500 shadow-sm"></span>
                <span class="text-zinc-600 dark:text-zinc-400 font-medium">Cocok dengan kunci</span>
            </div>
        </div>
    </flux:card>
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