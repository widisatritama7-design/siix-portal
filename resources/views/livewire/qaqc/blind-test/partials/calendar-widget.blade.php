@php
    use Carbon\Carbon;

    $month       = $calMonth ?? now();
    $firstDay    = $month->copy()->startOfMonth();
    $lastDay     = $month->copy()->endOfMonth();
    $startWeekday = $firstDay->dayOfWeekIso; // 1=Mon, 7=Sun
    $daysInMonth = $lastDay->day;
    $today       = now()->format('Y-m-d');

    // Grid 7 kolom: isi hari kosong di depan
    $leadingBlanks = $startWeekday - 1;

    $dailyCounts = $dailyCounts ?? [];

    // Total test bulan ini
    $monthTotal = array_sum($dailyCounts);

    // Max count untuk intensity
    $maxCount = !empty($dailyCounts) ? max($dailyCounts) : 0;
@endphp

<div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-lg overflow-hidden flex flex-col">

    {{-- ===== HEADER ===== --}}
    <div class="relative px-5 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 overflow-hidden">
        <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-white/10"></div>
        <div class="absolute -right-2 -bottom-8 w-16 h-16 rounded-full bg-white/10"></div>

        <div class="relative flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                        <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <div class="text-[10px] text-white/70 uppercase tracking-wider font-semibold">Calendar</div>
                    <div class="text-base font-bold text-white leading-tight">Test by Date</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold text-white leading-none">{{ $monthTotal }}</div>
                <div class="text-[9px] text-white/70 uppercase tracking-wider font-semibold">test</div>
            </div>
        </div>
    </div>

    {{-- ===== MONTH NAV ===== --}}
    <div class="px-4 py-3 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between bg-zinc-50 dark:bg-zinc-800/30">
        <button type="button"
            wire:click="prevMonth"
            class="w-8 h-8 rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-800 flex items-center justify-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-zinc-600 dark:text-zinc-400">
                <path fill-rule="evenodd" d="M7.72 12.53a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 1 1 1.06 1.06L9.31 12l6.97 6.97a.75.75 0 1 1-1.06 1.06l-7.5-7.5Z" clip-rule="evenodd" />
            </svg>
        </button>

        <div class="text-sm font-bold text-zinc-800 dark:text-white">
            {{ $month->translatedFormat('F Y') }}
        </div>

        <button type="button"
            wire:click="nextMonth"
            class="w-8 h-8 rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-800 flex items-center justify-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-zinc-600 dark:text-zinc-400">
                <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    {{-- ===== DAY LABELS ===== --}}
    <div class="px-4 pt-3 pb-1 grid grid-cols-7 gap-1">
        @foreach(['S','S','R','K','J','S','M'] as $d)
            <div class="text-center text-[10px] font-bold text-zinc-400 dark:text-zinc-500 uppercase">
                {{ $d }}
            </div>
        @endforeach
    </div>

    {{-- ===== CALENDAR GRID ===== --}}
    <div class="px-4 pb-3 flex-1">
        <div class="grid grid-cols-7 gap-1">

            {{-- Leading blanks --}}
            @for($i = 0; $i < $leadingBlanks; $i++)
                <div></div>
            @endfor

            {{-- Days --}}
            @for($day = 1; $day <= $daysInMonth; $day++)
                @php
                    $dateStr    = $month->copy()->day($day)->format('Y-m-d');
                    $count      = $dailyCounts[$dateStr] ?? 0;
                    $isToday    = $dateStr === $today;
                    $isSelected = $selectedDate === $dateStr;

                    // Badge color berdasarkan count
                    $badgeClass = '';
                    if ($count >= 5)      $badgeClass = 'bg-purple-600 text-white ring-white/40';
                    elseif ($count >= 3)  $badgeClass = 'bg-blue-600 text-white ring-white/40';
                    elseif ($count >= 2)  $badgeClass = 'bg-blue-500 text-white ring-white/40';
                    else                  $badgeClass = 'bg-blue-500 text-white ring-white/40';

                    // Background cell
                    if ($isSelected) {
                        $cellClass = 'bg-blue-600 text-white shadow-lg shadow-blue-500/30';
                    } elseif ($isToday) {
                        $cellClass = 'bg-amber-50 dark:bg-amber-950/30 text-amber-800 dark:text-amber-300 hover:bg-amber-100 dark:hover:bg-amber-900/40 ring-1 ring-amber-300 dark:ring-amber-700';
                    } elseif ($count > 0) {
                        $cellClass = 'bg-zinc-50 dark:bg-zinc-800/60 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800';
                    } else {
                        $cellClass = 'bg-zinc-50 dark:bg-zinc-800/40 text-zinc-400 dark:text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800';
                    }
                @endphp

                <button type="button"
                    wire:click="selectDate('{{ $dateStr }}')"
                    class="aspect-square rounded-lg flex items-center justify-center text-xs font-semibold transition-all relative
                        {{ $cellClass }}">

                    <span>{{ $day }}</span>

                    {{-- Badge Counter (kanan atas) --}}
                    @if($count > 0)
                        <span class="absolute -top-1 -right-1 min-w-[16px] h-4 px-1 rounded-full
                            flex items-center justify-center
                            text-[9px] font-bold leading-none
                            ring-2
                            {{ $badgeClass }}">
                            {{ $count }}
                        </span>
                    @endif
                </button>
            @endfor
        </div>
    </div>

    {{-- ===== FOOTER ===== --}}
    <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/30 flex items-center gap-2">
        <button type="button"
            wire:click="goToToday"
            class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg
                bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                <path d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm7.5-.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 7.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm2.25 3.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 9.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12 18a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
            </svg>
            Today
        </button>

        @if($selectedDate)
            <button type="button"
                wire:click="clearDate"
                class="inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg
                    bg-red-50 hover:bg-red-100 dark:bg-red-950/30 dark:hover:bg-red-900/40
                    border border-red-200 dark:border-red-800
                    text-red-600 dark:text-red-400 text-xs font-semibold transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
                Clear
            </button>
        @endif
    </div>
</div>