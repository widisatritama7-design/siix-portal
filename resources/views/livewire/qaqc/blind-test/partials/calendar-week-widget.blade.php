{{-- ==================== WEEK CALENDAR WIDGET ==================== --}}
@php
    $ws = \Carbon\Carbon::parse($weekStart);
    $we = \Carbon\Carbon::parse($weekEnd);
    $totalWeek = array_sum(array_column($weekDays, 'count'));
@endphp

<div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-lg overflow-hidden">

    {{-- ========== HEADER ========== --}}
    <div class="relative px-6 py-5 bg-gradient-to-r from-violet-600 via-purple-600 to-fuchsia-600 overflow-hidden">
        <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/10"></div>
        <div class="absolute -right-2 -bottom-10 w-20 h-20 rounded-full bg-white/10"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center shadow-lg shadow-purple-900/30">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                        <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <div class="text-[10px] text-white/70 uppercase tracking-widest font-bold">Week View</div>
                    <div class="text-lg font-bold text-white leading-tight">
                        {{ $ws->translatedFormat('d M') }} — {{ $we->translatedFormat('d M Y') }}
                    </div>
                    <div class="text-[11px] text-white/70 mt-0.5">
                        {{ $totalWeek }} test dalam minggu ini
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button wire:click="prevWeek"
                    class="w-9 h-9 rounded-xl bg-white/20 hover:bg-white/30 border border-white/30 text-white flex items-center justify-center transition-all active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M7.72 12.53a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 1 1 1.06 1.06L9.31 12l6.97 6.97a.75.75 0 1 1-1.06 1.06l-7.5-7.5Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <button wire:click="goToThisWeek"
                    class="h-9 px-4 rounded-xl bg-white text-purple-700 hover:bg-purple-50 text-xs font-bold flex items-center gap-1.5 shadow-lg shadow-purple-900/30 transition-all active:scale-95">
                    Today
                </button>
                <button wire:click="nextWeek"
                    class="w-9 h-9 rounded-xl bg-white/20 hover:bg-white/30 border border-white/30 text-white flex items-center justify-center transition-all active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- ========== BODY: 7 KARTU HARI ========== --}}
    <div class="p-4 sm:p-5">
        <div class="grid grid-cols-7 gap-2 sm:gap-3">
            @foreach($weekDays as $day)
            @php
                $count      = $day['count'];
                $hasCount   = $count > 0;
                $isToday    = $day['is_today'];
                $isSelected = $day['is_selected'];

                if ($count >= 5)      $badge = 'bg-rose-500 text-white';
                elseif ($count >= 3)  $badge = 'bg-amber-500 text-white';
                elseif ($count >= 1)  $badge = 'bg-blue-500 text-white';
                else                  $badge = '';
            @endphp

            <button
                wire:click="selectWeekDate('{{ $day['date'] }}')"
                wire:key="week-day-{{ $day['date'] }}"
                class="group relative flex flex-col items-center justify-center rounded-2xl border py-3 px-1 transition-all duration-200
                {{ $isSelected
                    ? 'border-purple-300 dark:border-purple-700 bg-gradient-to-br from-purple-50 to-fuchsia-50 dark:from-purple-950/40 dark:to-fuchsia-950/40 shadow-md shadow-purple-500/10'
                    : 'border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 hover:border-zinc-300 dark:hover:border-zinc-700' }}">

                {{-- Count badge (kanan atas) --}}
                @if($hasCount)
                    <span class="absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] px-1 rounded-full
                        flex items-center justify-center
                        text-[9px] font-black tabular-nums ring-2 ring-white dark:ring-zinc-900 shadow-sm
                        {{ $isSelected ? 'bg-purple-600 text-white' : $badge }}">
                        {{ $count }}
                    </span>
                @endif

                {{-- Day name --}}
                <span class="text-[10px] uppercase font-bold tracking-widest leading-none mb-1.5
                    {{ $isSelected ? 'text-purple-700 dark:text-purple-300'
                        : ($isToday ? 'text-amber-600 dark:text-amber-400'
                        : 'text-zinc-400 dark:text-zinc-500') }}">
                    {{ $day['day'] }}
                </span>

                {{-- Date number --}}
                <span class="text-2xl sm:text-3xl font-black leading-none tabular-nums
                    {{ $isSelected ? 'text-purple-700 dark:text-purple-300'
                        : ($isToday ? 'text-amber-600 dark:text-amber-400'
                        : 'text-zinc-800 dark:text-zinc-200') }}">
                    {{ $day['day_num'] }}
                </span>
            </button>
            @endforeach
        </div>

        {{-- ========== FOOTER INFO ========== --}}
        <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-800 flex flex-wrap items-center justify-between gap-3">
            @if($selectedDate)
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-purple-50 dark:bg-purple-950/30 border border-purple-200 dark:border-purple-800">
                    <span class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></span>
                    <span class="text-xs font-bold text-purple-700 dark:text-purple-300">
                        {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d M Y') }}
                    </span>
                </div>
                <button wire:click="clearDate"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-50 hover:bg-red-100 dark:bg-red-950/30 dark:hover:bg-red-900/40 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 text-xs font-bold transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                    Clear Filter
                </button>
            @else
                <div class="inline-flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-zinc-400">
                        <path fill-rule="evenodd" d="M11.54 22.351.07.04.028.016a.76.76 0 0 0 .723.091A6.004 6.004 0 0 0 16 12c0-3.314-2.686-6-6-6a5.973 5.973 0 0 0-4.907 2.57.75.75 0 0 0 .58 1.18c.87.144 1.716.398 2.516.744a11.97 11.97 0 0 1 4.617 4.617c.346.8.6 1.646.744 2.516a.75.75 0 0 0 1.18.58A5.973 5.973 0 0 0 18 12c0-3.314-2.686-6-6-6Z" clip-rule="evenodd" />
                    </svg>
                    Klik tanggal untuk memfilter data
                </div>
                <div class="inline-flex items-center gap-2 text-xs font-bold text-zinc-600 dark:text-zinc-300">
                    <span class="w-1.5 h-1.5 rounded-full bg-zinc-400"></span>
                    Total minggu ini: <span class="text-purple-600 dark:text-purple-400">{{ $totalWeek }}</span> test
                </div>
            @endif
        </div>
    </div>
</div>