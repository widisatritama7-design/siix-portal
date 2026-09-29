<div class="p-1 space-y-3">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">QA/QC</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">Blind Test Management</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">Blind Test Management</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Pilih soal dari bank soal untuk membuat blind test
            </p>
        </div>
    </div>

    <!-- ==================== BANK SOAL HEADER + FILTER ==================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-1">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                    <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-zinc-800 dark:text-white leading-tight">Bank Soal</h2>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                    Pilih soal untuk memulai blind test
                </p>
            </div>
        </div>

        {{-- Month Picker --}}
        <div class="flex items-center gap-2">
            <div class="relative">
                <input type="month"
                    wire:model.live="bankMonth"
                    class="pl-10 pr-4 py-2 rounded-xl border border-zinc-300 dark:border-zinc-700
                        bg-white dark:bg-zinc-900 text-sm font-semibold text-zinc-700 dark:text-zinc-200
                        focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                        hover:border-zinc-400 dark:hover:border-zinc-600
                        transition-all cursor-pointer"
                    style="color-scheme: light dark;">

                {{-- Icon Calendar (overlay) --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-blue-500 pointer-events-none">
                    <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
                </svg>
            </div>

            {{-- Reset ke Bulan Ini --}}
            @if($bankMonth)
                <button type="button"
                    wire:click="$set('bankMonth', '')"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl
                        bg-red-50 hover:bg-red-100 dark:bg-red-950/30 dark:hover:bg-red-900/40
                        border border-red-200 dark:border-red-800
                        text-red-600 dark:text-red-400 text-xs font-semibold
                        transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                    </svg>
                    Reset
                </button>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl
                            bg-blue-50 dark:bg-blue-950/30
                            border border-blue-200 dark:border-blue-800
                            text-blue-600 dark:text-blue-400 text-xs font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                    Bulan Ini
                </span>
            @endif
        </div>
    </div>

    <!-- ==================== BANK SOAL PER SECTION ==================== -->
    <style>
        .bank-scroll::-webkit-scrollbar { width: 6px; }
        .bank-scroll::-webkit-scrollbar-track { background: transparent; }
        .bank-scroll::-webkit-scrollbar-thumb { background: rgba(161, 161, 170, 0.3); border-radius: 999px; }
        .bank-scroll::-webkit-scrollbar-thumb:hover { background: rgba(161, 161, 170, 0.5); }
        .dark .bank-scroll::-webkit-scrollbar-thumb { background: rgba(113, 113, 122, 0.4); }
        .dark .bank-scroll::-webkit-scrollbar-thumb:hover { background: rgba(113, 113, 122, 0.6); }
    </style>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        @foreach($sections as $sec)
        @php
            $secMeta = [
                'QC'  => ['grad' => 'from-blue-500 to-indigo-600',   'soft' => 'bg-blue-50 dark:bg-blue-950/20',      'accent' => 'text-blue-600 dark:text-blue-400',     'border' => 'border-blue-200 dark:border-blue-800',    'badge' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300'],
                'SMT' => ['grad' => 'from-green-500 to-emerald-600', 'soft' => 'bg-green-50 dark:bg-green-950/20',    'accent' => 'text-green-600 dark:text-green-400',   'border' => 'border-green-200 dark:border-green-800',  'badge' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300'],
                'BE'  => ['grad' => 'from-amber-500 to-orange-600',  'soft' => 'bg-amber-50 dark:bg-amber-950/20',    'accent' => 'text-amber-600 dark:text-amber-400',   'border' => 'border-amber-200 dark:border-amber-800',  'badge' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300'],
                'MI'  => ['grad' => 'from-purple-500 to-pink-600',   'soft' => 'bg-purple-50 dark:bg-purple-950/20',  'accent' => 'text-purple-600 dark:text-purple-400', 'border' => 'border-purple-200 dark:border-purple-800','badge' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300'],
            ];
            $style = $secMeta[$sec] ?? $secMeta['QC'];
            $list = $questionBank[$sec] ?? collect();
            $count = $list->count();
        @endphp

        <div class="group/card bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 overflow-hidden flex flex-col">

            {{-- ========== HEADER ========== --}}
            <div class="relative px-4 py-3.5 bg-gradient-to-r {{ $style['grad'] }} overflow-hidden">
                {{-- Dekorasi background --}}
                <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-white/10"></div>
                <div class="absolute -right-1 -bottom-6 w-14 h-14 rounded-full bg-white/10"></div>

                <div class="relative flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4.5 h-4.5 text-white">
                            <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[10px] text-white/70 uppercase tracking-wider font-semibold leading-none mb-0.5">
                            Section
                        </div>
                        <div class="text-base font-bold text-white leading-none">{{ $sec }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-white leading-none">{{ $count }}</div>
                        <div class="text-[9px] text-white/70 uppercase tracking-wider font-semibold">soal</div>
                    </div>
                </div>
            </div>

            {{-- ========== SUBHEADER ========== --}}
            <div class="px-4 py-2 bg-zinc-50 dark:bg-zinc-800/40 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                <div class="flex items-center gap-1.5 text-[10px] text-zinc-500 dark:text-zinc-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                        <path d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm7.5-.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 7.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm2.25 3.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 9.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12 18a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                        <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-semibold uppercase tracking-wide">{{ $bankDate->translatedFormat('F Y') }}</span>
                </div>
                @if($count > 0)
                    <div class="text-[9px] text-zinc-400 dark:text-zinc-500 font-medium">
                        Terbaru
                    </div>
                @endif
            </div>

            {{-- ========== LIST ========== --}}
            <div class="bank-scroll flex-1 overflow-y-auto p-2 space-y-1.5" style="max-height: 220px;">
                @forelse($list as $q)
                @php $itemCount = $q->totalDefects(); @endphp
                <button type="button"
                    wire:click="openCreateModal({{ $q->id }})"
                    wire:key="bank-q-{{ $q->id }}"
                    class="group/item w-full text-left p-3 rounded-xl border border-zinc-100 dark:border-zinc-800 bg-white dark:bg-zinc-900 hover:border-zinc-300 dark:hover:border-zinc-600 hover:shadow-md hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50 transition-all duration-200 relative">

                    {{-- Row 1: ID + Defect Count --}}
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="inline-flex items-center gap-1 text-[10px] font-mono font-bold text-zinc-400 dark:text-zinc-500">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clip-rule="evenodd" />
                            </svg>
                            #{{ $q->id }}
                        </span>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold {{ $style['badge'] }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-2.5 h-2.5">
                                <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clip-rule="evenodd" />
                            </svg>
                            {{ $itemCount }}
                        </span>
                    </div>

                    {{-- Row 2: Customer --}}
                    <div class="flex items-center gap-1.5 text-xs text-zinc-700 dark:text-zinc-300 mb-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5 text-emerald-500 flex-shrink-0">
                            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-semibold truncate">{{ $q->customer->customer_name ?? '-' }}</span>
                    </div>

                    {{-- Row 3: Models --}}
                    @php
                        $modelNames = $q->models->pluck('model_name')->filter()->values();
                        if ($modelNames->isEmpty() && $q->model) {
                            $modelNames = collect([$q->model->model_name]);
                        }
                    @endphp
                    @if($modelNames->isNotEmpty())
                        <div class="flex items-start gap-1.5 text-[11px]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5 text-purple-500 flex-shrink-0 mt-0.5">
                                <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                                <path fill-rule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex flex-wrap items-center gap-1 leading-tight">
                                @if($modelNames->count() === 1)
                                    <span class="text-zinc-600 dark:text-zinc-400 font-medium truncate">
                                        {{ $modelNames->first() }}
                                    </span>
                                @else
                                    @foreach($modelNames as $mName)
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-md text-[10px] font-semibold bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300">
                                            {{ $mName }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Hover CTA --}}
                    <div class="mt-2 flex items-center justify-between">
                        <span class="text-[10px] text-zinc-400 dark:text-zinc-500 font-medium">
                            {{ $q->created_at?->diffForHumans() ?? '-' }}
                        </span>
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold {{ $style['accent'] }} opacity-0 group-hover/item:opacity-100 group-hover/item:translate-x-0 translate-x-1 transition-all duration-200">
                            Create
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 1 1-1.06-1.06l6.22-6.22H3a.75.75 0 0 1 0-1.5h16.19l-6.22-6.22a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </div>
                </button>
                @empty
                <div class="px-4 py-10 text-center">
                    <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-zinc-300 dark:text-zinc-600">
                            <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-0.5">
                        Belum ada soal
                    </div>
                    <div class="text-[10px] text-zinc-400 dark:text-zinc-500">
                        Bulan {{ $bankDate->translatedFormat('F Y') }}
                    </div>
                </div>
                @endforelse
            </div>
        </div>
        @endforeach
    </div>

    <!-- Filter Card -->
    <flux:card class="p-4 shadow-sm"
        x-data="{
            filterOpen: localStorage.getItem('blindTest_filterOpen') !== 'false',
            toggleFilter() {
                this.filterOpen = !this.filterOpen;
                localStorage.setItem('blindTest_filterOpen', this.filterOpen ? 'true' : 'false');
            }
        }">

        <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
            <div class="flex-1 w-full">
                <flux:input wire:model.live.debounce.300ms="search"
                    placeholder="Search NIK, Name, Customer, Model..." icon="magnifying-glass" clearable />
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="button" @click="toggleFilter()"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg
                           bg-orange-500 hover:bg-orange-600 active:bg-orange-700
                           text-white text-sm font-medium whitespace-nowrap
                           shadow-md shadow-orange-500/30
                           border border-orange-600
                           transition-all duration-200 hover:scale-105 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-4 h-4 transition-transform duration-200"
                        :class="filterOpen ? 'rotate-180' : ''">
                        <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 0 1-1.06 0l-7.5-7.5a.75.75 0 0 1 1.06-1.06L12 14.69l6.97-6.97a.75.75 0 1 1 1.06 1.06l-7.5 7.5Z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="filterOpen ? 'Hide Filter' : 'Unhide Filter'"></span>

                    @php
                        $activeFilterCount = collect([
                            $filterDepartment, $filterShift, $filterGroup, $filterSection,
                            $filterCustomer, $filterModel, $filterResult,
                            $filterDateFrom, $filterDateTo,
                        ])->filter(fn ($v) => !empty($v))->count();
                    @endphp
                    @if($activeFilterCount > 0)
                        <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full
                                     bg-white text-orange-600 text-[10px] font-bold">
                            {{ $activeFilterCount }}
                        </span>
                    @endif
                </button>
                @if($search || $filterDepartment || $filterShift || $filterGroup || $filterSection || $filterCustomer || $filterModel || $filterResult || $filterDateFrom || $filterDateTo)
                    <flux:button wire:click="resetFilters" variant="danger" color="red" icon="arrow-path"
                        class="whitespace-nowrap bg-red-600 hover:bg-red-700 text-white">
                        Reset Filter
                    </flux:button>
                @endif
            </div>
        </div>

        <div x-show="filterOpen" x-collapse class="space-y-3 pt-3">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-3">
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 uppercase mb-1">Department</label>
                    <select wire:model.live="filterDepartment"
                        class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">All Department</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept }}">{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 uppercase mb-1">Shift</label>
                    <select wire:model.live="filterShift"
                        class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">All Shift</option>
                        @foreach($shifts as $s)
                            <option value="{{ $s }}">{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 uppercase mb-1">Group</label>
                    <select wire:model.live="filterGroup"
                        class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">All Group</option>
                        @foreach($groups as $g)
                            <option value="{{ $g }}">{{ $g }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 uppercase mb-1">Section</label>
                    <select wire:model.live="filterSection"
                        class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">All Section</option>
                        @foreach($sections as $sec)
                            <option value="{{ $sec }}">{{ $sec }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 uppercase mb-1">Customer</label>
                    <select wire:model.live="filterCustomer"
                        class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">All Customer</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->customer_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 uppercase mb-1">
                        Model @if(!$filterCustomer) <span class="text-amber-500 normal-case">(pilih customer)</span> @endif
                    </label>
                    <select wire:model.live="filterModel"
                        class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500 disabled:opacity-50"
                        @if(!$filterCustomer) disabled @endif>
                        <option value="">All Model</option>
                        @foreach($filterModels as $m)
                            <option value="{{ $m->id }}">{{ $m->model_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 uppercase mb-1">Result</label>
                    <select wire:model.live="filterResult"
                        class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">All Result</option>
                        <option value="PASS">PASS</option>
                        <option value="FAIL">FAIL</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 uppercase mb-1">From Date</label>
                    <input type="date" wire:model.live="filterDateFrom"
                        class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 uppercase mb-1">Until Date</label>
                    <input type="date" wire:model.live="filterDateTo"
                        class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>
    </flux:card>

    <!-- Tabs -->
    <div class="border-b border-zinc-200 dark:border-zinc-700 pb-4">
        <div class="overflow-x-auto scrollbar-hide">
            <div class="flex justify-center min-w-full w-max">
                <div class="flex flex-nowrap gap-2 px-1">
                    <button wire:click="setTab('all')"
                        class="px-5 py-2.5 text-sm font-medium rounded-lg whitespace-nowrap {{ $activeTab === 'all' ? 'bg-blue-600 text-white shadow-md' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
                        All <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'all' ? 'bg-white/20 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400' }}">{{ $tabCounts['all'] ?? 0 }}</span>
                    </button>
                    <button wire:click="setTab('open')"
                        class="px-5 py-2.5 text-sm font-medium rounded-lg whitespace-nowrap {{ $activeTab === 'open' ? 'bg-yellow-500 text-white shadow-md' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
                        Open <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'open' ? 'bg-white/20 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400' }}">{{ $tabCounts['open'] ?? 0 }}</span>
                    </button>
                    <button wire:click="setTab('in_progress')"
                        class="px-5 py-2.5 text-sm font-medium rounded-lg whitespace-nowrap {{ $activeTab === 'in_progress' ? 'bg-blue-600 text-white shadow-md' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
                        In Progress <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'in_progress' ? 'bg-white/20 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400' }}">{{ $tabCounts['in_progress'] ?? 0 }}</span>
                    </button>
                    <button wire:click="setTab('closed')"
                        class="px-5 py-2.5 text-sm font-medium rounded-lg whitespace-nowrap {{ $activeTab === 'closed' ? 'bg-green-600 text-white shadow-md' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
                        Closed <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'closed' ? 'bg-white/20 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400' }}">{{ $tabCounts['closed'] ?? 0 }}</span>
                    </button>
                    <button wire:click="setTab('rejected')"
                        class="px-5 py-2.5 text-sm font-medium rounded-lg whitespace-nowrap {{ $activeTab === 'rejected' ? 'bg-red-600 text-white shadow-md' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
                        Rejected <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'rejected' ? 'bg-white/20 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400' }}">{{ $tabCounts['rejected'] ?? 0 }}</span>
                    </button>
                    <button wire:click="setTab('deleted')"
                        class="px-5 py-2.5 text-sm font-medium rounded-lg whitespace-nowrap {{ $activeTab === 'deleted' ? 'bg-zinc-600 text-white shadow-md' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
                        Deleted <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'deleted' ? 'bg-white/20 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400' }}">{{ $tabCounts['deleted'] ?? 0 }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Blind Test -->
    <flux:card class="p-6 h-full shadow-lg flex flex-col">
        <div
            x-data="{
                showScroll: false,
                onEnter() { this.showScroll = true; },
                onLeave() { this.showScroll = false; }
            }"
            @mouseenter="onEnter()"
            @mouseleave="onLeave()"
            class="relative flex-1"
        >
            {{-- Gradient hint kiri --}}
            <div
                x-show="showScroll"
                x-transition.opacity.duration.300ms
                class="pointer-events-none absolute left-0 top-0 bottom-0 w-8 z-10
                    bg-gradient-to-r from-white dark:from-zinc-900 to-transparent"
            ></div>

            {{-- Gradient hint kanan --}}
            <div
                x-show="showScroll"
                x-transition.opacity.duration.300ms
                class="pointer-events-none absolute right-0 top-0 bottom-0 w-8 z-10
                    bg-gradient-to-l from-white dark:from-zinc-900 to-transparent"
            ></div>

            <div
                class="overflow-x-auto flex-1 transition-all duration-300 custom-scroll-x"
                :class="showScroll ? 'scrollbar-visible' : 'scrollbar-hidden'"
            >
                <table class="w-full" style="min-width: 1600px; white-space: nowrap;">
                    <thead>
                        <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase">#</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase">NIK</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase">Name</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase">Department</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase">Shift | Group</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase">Section</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase">Customer | Model</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase">Durasi</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase">Result</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase">Created</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($blindTests as $index => $bt)
                        @php $isTrashed = $bt->trashed(); @endphp
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 {{ $isTrashed ? 'opacity-60' : '' }}" wire:key="bt-{{ $bt->id }}">
                            <td class="px-4 py-3 text-sm text-center">{{ $blindTests->firstItem() + $index }}</td>
                            <td class="px-4 py-3 text-sm text-center font-semibold">{{ $bt->employee->nik ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm ">{{ $bt->employee->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-center font-semibold">{{ $bt->employee->department ?? '-' }}</td>

                            <td class="px-4 py-3 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold">
                                        {{ $bt->shift ?? '-' }}
                                    </span>
                                    <span class="text-zinc-400 text-xs">|</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold">
                                        {{ $bt->group ?? '-' }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if($bt->section)
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold
                                        @if($bt->section === 'QC') bg-blue-100 text-blue-700
                                        @elseif($bt->section === 'SMT') bg-green-100 text-green-700
                                        @elseif($bt->section === 'BE') bg-yellow-100 text-yellow-700
                                        @else bg-purple-100 text-purple-700 @endif">
                                        {{ $bt->section }}
                                    </span>
                                @else
                                    <span class="text-xs text-zinc-400">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-sm text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="font-medium text-zinc-800 dark:text-zinc-200">
                                        {{ $bt->customer->customer_name ?? '-' }}
                                    </span>
                                    @php
                                        // Kumpulkan model dari snapshot (support multi-model di nested items)
                                        $snapshotModels = collect($bt->question_snapshot ?? [])
                                            ->flatMap(function ($q) {
                                                $items = $q['items'] ?? [];
                                                // Format baru: nested group
                                                if (!empty($items) && isset($items[0]['model_id'])) {
                                                    return collect($items)->map(fn ($g) => [
                                                        'model_id'   => $g['model_id'] ?? null,
                                                        'model_name' => $g['model_name'] ?? null,
                                                    ])->filter(fn ($m) => $m['model_id']);
                                                }
                                                // Format lama
                                                if (!empty($q['model_id'])) {
                                                    $m = \App\Models\QAQC\BlindTest\Model::find($q['model_id']);
                                                    return $m ? [['model_id' => $m->id, 'model_name' => $m->model_name]] : [];
                                                }
                                                return [];
                                            })
                                            ->unique('model_id')
                                            ->values();

                                        // Fallback ke kolom model_id
                                        if ($snapshotModels->isEmpty() && $bt->model_id) {
                                            $m = \App\Models\QAQC\BlindTest\Model::find($bt->model_id);
                                            if ($m) $snapshotModels = collect([['model_id' => $m->id, 'model_name' => $m->model_name]]);
                                        }
                                    @endphp

                                    @if($snapshotModels->count() > 0)
                                        <div class="flex flex-wrap items-center justify-center gap-1">
                                            @foreach($snapshotModels as $sm)
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded
                                                    text-[10px] font-semibold
                                                    {{ $snapshotModels->count() > 1
                                                        ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300'
                                                        : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300' }}">
                                                    {{ $sm['model_name'] }}
                                                </span>
                                            @endforeach
                                            @if($snapshotModels->count() > 1)
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300">
                                                    {{ $snapshotModels->count() }} models
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-xs text-zinc-400">-</span>
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if($bt->duration_minutes)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-cyan-100 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-300 text-xs font-semibold">
                                        {{ $bt->duration_minutes }} menit
                                    </span>
                                @else
                                    <span class="text-xs text-zinc-400">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if($isTrashed)
                                    <flux:badge size="sm" color="zinc">Deleted</flux:badge>
                                @else
                                    @php $sc = ['pending' => 'yellow', 'in_progress' => 'blue', 'completed' => 'green']; @endphp
                                    <flux:badge size="sm" color="{{ $sc[$bt->status] ?? 'gray' }}">
                                        {{ ucfirst(str_replace('_', ' ', $bt->status)) }}
                                    </flux:badge>
                                    @if($bt->auto_saved)
                                        <div class="text-[10px] text-orange-500 dark:text-orange-400 font-semibold mt-0.5 uppercase">Auto Saved</div>
                                    @endif
                                @endif
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if($bt->status === 'completed' && !$bt->is_reviewed)
                                    <div class="inline-flex flex-col items-center gap-1">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 text-xs font-bold border border-amber-300 dark:border-amber-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd" />
                                            </svg>
                                            Pending Review
                                        </span>
                                        <div class="text-[10px] text-amber-600 dark:text-amber-400 font-semibold">
                                            Menunggu QC
                                        </div>
                                    </div>
                                @elseif($bt->overall_result)
                                    <flux:badge size="sm" color="{{ $bt->overall_result === 'PASS' ? 'green' : 'red' }}">
                                        {{ $bt->overall_result }}
                                    </flux:badge>
                                    <div class="text-xs text-zinc-500 mt-1">{{ $bt->total_correct }}/{{ $bt->total_items }}</div>

                                    @if($bt->max_attempt > 1)
                                        <div class="text-[10px] font-semibold mt-0.5
                                            {{ $bt->attempt > 1
                                                ? 'text-purple-600 dark:text-purple-400'
                                                : 'text-zinc-500 dark:text-zinc-400' }}">
                                            Attempt {{ $bt->attempt }}/{{ $bt->max_attempt }}
                                        </div>
                                    @endif
                                @else
                                    <span class="text-xs text-zinc-400">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-center">
                                <div class="flex flex-col items-center gap-0.5">
                                    <div class="inline-flex items-center gap-1 text-xs font-semibold text-zinc-700 dark:text-zinc-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5 text-zinc-400">
                                            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $bt->creator->name ?? '-' }}
                                    </div>
                                    <div class="text-[10px] text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                        {{ $bt->created_at ? $bt->created_at->format('d/m/Y H:i') : '-' }}
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if($isTrashed)
                                    <div class="flex flex-col items-center gap-1.5 max-w-[220px] mx-auto">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-[10px] font-bold uppercase tracking-wider">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                                <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                            </svg>
                                            Deleted
                                        </span>
                                        @if($bt->deleted_reason)
                                            <div class="text-xs text-red-600 dark:text-red-400 font-semibold italic text-center leading-tight break-words"
                                                title="{{ $bt->deleted_reason }}">
                                                {{ $bt->deleted_reason }}
                                            </div>
                                        @else
                                            <div class="text-[10px] text-zinc-400 italic">No reason provided</div>
                                        @endif
                                    </div>
                                @else
                                    <div class="flex items-center justify-center gap-1 flex-wrap">
                                        @can('review blind test location')
                                            @if($bt->status === 'completed' && !$bt->is_reviewed)
                                                <flux:tooltip content="Review Location" position="top">
                                                    <a href="{{ route('qaqc.blind-test.review', $bt->id) }}">
                                                        <flux:button size="sm" icon="clipboard-document-check" variant="primary" color="purple" class="!p-2" />
                                                    </a>
                                                </flux:tooltip>
                                            @endif
                                        @endcan
                                        @can('execute blind test')
                                            @if($bt->status === 'completed')
                                                {{-- View Result --}}
                                                <flux:tooltip content="View Result" position="top">
                                                    <a href="{{ route('qaqc.blind-test.execute', $bt->id) }}">
                                                        <flux:button size="sm" icon="eye" variant="primary" color="black" class="!p-2" />
                                                    </a>
                                                </flux:tooltip>

                                                {{-- ✅ Retry: muncul kalau FAIL & masih bisa retry --}}
                                                @if($bt->overall_result === 'FAIL' && $bt->canRetry())
                                                    <flux:tooltip content="Retry Test (Attempt {{ $bt->attempt + 1 }}/{{ $bt->max_attempt }})" position="top">
                                                        <a href="{{ route('qaqc.blind-test.execute', ['id' => $bt->id, 'retry' => 1]) }}">
                                                            <flux:button size="sm" icon="arrow-path" variant="primary" color="orange" class="!p-2" />
                                                        </a>
                                                    </flux:tooltip>
                                                @endif
                                            @else
                                                <flux:tooltip content="Start Test" position="top">
                                                    <a href="{{ route('qaqc.blind-test.execute', $bt->id) }}">
                                                        <flux:button size="sm" icon="play" variant="primary" color="green" class="!p-2" />
                                                    </a>
                                                </flux:tooltip>
                                            @endif
                                        @endcan

                                        @can('check blind test qc')
                                            @if(!$bt->check_by_qc)
                                                <flux:tooltip content="Approve as Check By QC" position="top">
                                                    <flux:button size="sm" icon="check-circle" variant="primary" color="blue" class="!p-2"
                                                        wire:click="openApprovalModal({{ $bt->id }}, 'qc')" />
                                                </flux:tooltip>
                                            @endif
                                        @endcan

                                        @can('check blind test prod')
                                            @if(!$bt->check_by_prod)
                                                <flux:tooltip content="Approve as Check By Production" position="top">
                                                    <flux:button size="sm" icon="check-circle" variant="primary" color="blue" class="!p-2"
                                                        wire:click="openApprovalModal({{ $bt->id }}, 'prod')" />
                                                </flux:tooltip>
                                            @endif
                                        @endcan

                                        @can('acknowledge blind test spv')
                                            @if(!$bt->acknowledge_by_spv)
                                                <flux:tooltip content="Acknowledge as SPV" position="top">
                                                    <flux:button size="sm" icon="check-circle" variant="primary" color="blue" class="!p-2"
                                                        wire:click="openApprovalModal({{ $bt->id }}, 'spv')" />
                                                </flux:tooltip>
                                            @endif
                                        @endcan

                                        @can('acknowledge blind test qc spv')
                                            @if(!$bt->acknowledge_qc_spv)
                                                <flux:tooltip content="Acknowledge as QC SPV" position="top">
                                                    <flux:button size="sm" icon="check-circle" variant="primary" color="blue" class="!p-2"
                                                        wire:click="openApprovalModal({{ $bt->id }}, 'qc_spv')" />
                                                </flux:tooltip>
                                            @endif
                                        @endcan

                                        @can('delete blind test')
                                            @if($bt->status === 'pending')
                                                <flux:tooltip content="Delete" position="top">
                                                    <flux:button size="sm" icon="trash" variant="danger" color="red" class="!p-2"
                                                        wire:click="confirmDelete({{ $bt->id }})" />
                                                </flux:tooltip>
                                            @endif
                                        @endcan
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="px-4 py-8 text-center">
                                <div class="flex flex-col items-center gap-2 py-6">
                                    <flux:icon name="clipboard-document-check" class="w-10 h-10 text-zinc-400" />
                                    <h3 class="text-base font-medium text-zinc-900 dark:text-white">No blind test records found</h3>
                                    <p class="text-sm text-zinc-500">
                                        @if($search || $filterDepartment || $filterShift || $filterGroup || $filterSection || $filterCustomer || $filterModel || $filterResult || $filterDateFrom || $filterDateTo)
                                            Try adjusting your search or filters
                                        @else
                                            Klik salah satu soal di bank soal di atas untuk memulai
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($blindTests->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 mt-auto">
            {{ $blindTests->links() }}
        </div>
        @endif
    </flux:card>

    <!-- ==================== MODAL APPROVAL ==================== -->
    <div x-data="{ open: false }"
        x-on:open-modal-approval.window="open = true"
        x-on:close-modal-approval.window="open = false"
        x-show="open" x-cloak @keydown.escape.window="open = false">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40" @click="open = false"></div>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-5 flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Confirm Approval</h3>
                        <p class="text-xs text-green-100">Konfirmasi persetujuan Anda</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="mb-4 p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                        <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold mb-1">You are approving as</div>
                        <div class="text-sm font-bold text-zinc-800 dark:text-white">
                            @if($approvalType === 'qc') Check By QC
                            @elseif($approvalType === 'prod') Check By Prod
                            @elseif($approvalType === 'spv') Acknowledge By SPV
                            @elseif($approvalType === 'qc_spv') Acknowledge QC SPV
                            @endif
                        </div>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button @click="open = false"
                            class="px-4 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 text-sm font-medium">
                            Cancel
                        </button>
                        <button wire:click="approve"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium shadow-lg shadow-green-500/30">
                            Confirm Approval
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL FORM (CREATE / EDIT) ==================== -->
    <div x-data="{ open: false }"
        x-on:open-modal-blind-test.window="open = true"
        x-on:close-modal-blind-test.window="open = false"
        x-show="open" x-cloak @keydown.escape.window="open = false">

        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden">

                <!-- Modal Header -->
                <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-6 py-5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">{{ $modalTitle }}</h2>
                            <p class="text-xs text-blue-100">Pilih employee & buat test (durasi otomatis 5 menit)</p>
                        </div>
                    </div>
                    <button type="button" @click="open = false"
                        class="w-9 h-9 rounded-lg bg-white/20 hover:bg-white/30 backdrop-blur-sm border border-white/30 text-white flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="flex-1 overflow-y-auto p-6 bg-zinc-50 dark:bg-zinc-950/30">
                    <form wire:submit="save" id="blind-test-form" class="space-y-4">

                        {{-- ========== INFO SOAL TERPILIH ========== --}}
                        @if($selectedQuestion)
                        @php
                            $secColors = [
                                'QC'  => 'from-blue-500 to-indigo-600',
                                'SMT' => 'from-green-500 to-emerald-600',
                                'BE'  => 'from-yellow-500 to-orange-600',
                                'MI'  => 'from-purple-500 to-pink-600',
                            ];
                            $gradient = $secColors[$selectedQuestion->section] ?? $secColors['QC'];
                        @endphp
                        <div class="bg-gradient-to-r {{ $gradient }} rounded-xl p-4 shadow-lg">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                                        <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-[10px] text-white/80 uppercase font-bold tracking-wider">Soal Terpilih</div>
                                    <div class="text-sm font-bold text-white">#{{ $selectedQuestion->id }} — Section {{ $selectedQuestion->section }}</div>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full bg-white/20 backdrop-blur-sm text-white font-bold">
                                    {{ $selectedQuestion->totalDefects() }} defect
                                </span>
                            </div>
                            @php
                                // Kumpulkan model dari relasi many-to-many, fallback ke model utama
                                $sqModelNames = $selectedQuestion->models->pluck('model_name')->filter()->values();

                                if ($sqModelNames->isEmpty() && $selectedQuestion->model) {
                                    $sqModelNames = collect([$selectedQuestion->model->model_name]);
                                }
                            @endphp

                            <div class="text-xs text-white/90 mt-2 flex flex-wrap items-center gap-x-2 gap-y-1">
                                <span>
                                    <strong>Customer:</strong> {{ $selectedQuestion->customer->customer_name ?? '-' }}
                                </span>

                                @if($sqModelNames->isNotEmpty())
                                    <span class="text-white/60">·</span>
                                    <span class="inline-flex items-center gap-1 flex-wrap">
                                        <strong>Model:</strong>
                                        @if($sqModelNames->count() === 1)
                                            <span>{{ $sqModelNames->first() }}</span>
                                        @else
                                            @foreach($sqModelNames as $mName)
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-white/20 backdrop-blur-sm text-white border border-white/30">
                                                    {{ $mName }}
                                                </span>
                                            @endforeach
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-400/30 text-amber-50 border border-amber-200/40">
                                                {{ $sqModelNames->count() }} models
                                            </span>
                                        @endif
                                    </span>
                                @endif
                            </div>
                            @if($selectedQuestion->question_text)
                                <div class="text-[11px] text-white/80 mt-1 italic">
                                    "{{ $selectedQuestion->question_text }}"
                                </div>
                            @endif
                        </div>
                        @endif

                        {{-- ========== STEP 1: SECTION (readonly) ========== --}}
                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                            <div class="px-5 py-3.5 border-b border-zinc-200 dark:border-zinc-800 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center">
                                    <span class="text-xs font-bold text-white">1</span>
                                </div>
                                <h3 class="text-sm font-bold text-zinc-800 dark:text-white">Section</h3>
                                <span class="ml-auto text-[10px] px-2 py-0.5 rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 font-bold uppercase">
                                    Auto-set
                                </span>
                            </div>
                            <div class="p-5">
                                <div class="flex items-center gap-3 p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                                    <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center">
                                        <span class="text-xs font-bold text-white">{{ $section }}</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-zinc-800 dark:text-white">{{ $section }}</div>
                                        <div class="text-[11px] text-zinc-500 dark:text-zinc-400">Section sudah otomatis dari soal yang dipilih</div>
                                    </div>
                                </div>
                                @error('section') <span class="text-red-500 text-xs block mt-2">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- ========== STEP 2: EMPLOYEE PICKER ========== --}}
                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden"
                            x-data="{
                                pickedId: null,
                                pickedNik: '',
                                pickedName: '',
                                pickedDept: '',
                                search: '',
                                employees: [],
                                loading: false,
                                timeout: null,
                                resetPick() {
                                    this.pickedId = null;
                                    this.pickedNik = '';
                                    this.pickedName = '';
                                    this.pickedDept = '';
                                    $wire.set('tempShift', '');
                                    $wire.set('tempGroup', '');
                                },
                                load() {
                                    if (this.search.length < 2) { this.employees = []; return; }
                                    clearTimeout(this.timeout);
                                    this.timeout = setTimeout(() => {
                                        this.loading = true;
                                        @this.call('searchEmployees', this.search).then(r => {
                                            this.employees = r; this.loading = false;
                                        }).catch(() => this.loading = false);
                                    }, 300);
                                },
                                pick(emp) {
                                    this.pickedId = emp.id;
                                    this.pickedNik = emp.nik;
                                    this.pickedName = emp.name;
                                    this.pickedDept = emp.department;
                                    this.employees = [];
                                    this.search = '';
                                },
                                async addNow() {
                                    if (!this.pickedId) return;
                                    await $wire.addEmployee(this.pickedId);
                                    this.resetPick();
                                    if (this.search.length >= 2) {
                                        this.load();
                                    }
                                }
                            }"
                            x-on:employee-added.window="resetPick()">

                            <div class="px-5 py-3.5 border-b border-zinc-200 dark:border-zinc-800 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center shadow-sm shadow-blue-500/30">
                                        <span class="text-xs font-bold text-white">2</span>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-zinc-800 dark:text-white">Pilih Employee</h3>
                                        @if($section)
                                            @php
                                                $allowedDepts = match($section) {
                                                    'QC'  => 'IQC, QA/QC',
                                                    'SMT' => 'PROD.1',
                                                    'MI'  => 'PROD.1',
                                                    'BE'  => 'PROD.2',
                                                    default => '-',
                                                };
                                            @endphp
                                            <p class="text-[10px] text-blue-600 dark:text-blue-400">
                                                Department: <strong>{{ $allowedDepts }}</strong>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-semibold">
                                    Total: {{ count($selectedEmployees) }}
                                </span>
                            </div>
                            <div class="p-5 space-y-4">

                                {{-- STEP 2A: SEARCH --}}
                                <div>
                                    <flux:label required>1. Cari & Pilih Employee</flux:label>
                                    <div class="relative">
                                        <input type="text" x-model="search" @input="load()"
                                            placeholder="Cari NIK / nama (min 2 huruf)..."
                                            class="w-full pl-10 pr-3 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:text-white text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400">
                                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                                        </svg>
                                    </div>

                                    <div x-show="loading" class="mt-2 p-3 text-center text-sm bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                                        <svg class="animate-spin h-4 w-4 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>

                                    <div x-show="!loading && employees.length > 0" class="mt-2 border border-zinc-200 dark:border-zinc-700 rounded-lg max-h-60 overflow-y-auto">
                                        <table class="w-full text-sm">
                                            <thead class="bg-zinc-50 dark:bg-zinc-800 sticky top-0">
                                                <tr>
                                                    <th class="px-3 py-2 text-center text-xs font-semibold text-zinc-600">NIK</th>
                                                    <th class="px-3 py-2 text-left text-xs font-semibold text-zinc-600">NAME</th>
                                                    <th class="px-3 py-2 text-center text-xs font-semibold text-zinc-600">DEPT</th>
                                                    <th class="px-3 py-2 text-center text-xs font-semibold text-zinc-600 w-20"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                                <template x-for="emp in employees" :key="emp.id">
                                                    <tr class="transition-colors"
                                                        :class="emp.already_selected
                                                            ? 'bg-zinc-100 dark:bg-zinc-800/50 opacity-60 cursor-not-allowed'
                                                            : 'hover:bg-blue-50 dark:hover:bg-blue-950/10'">
                                                        <td class="px-3 py-2 text-center font-mono text-xs" x-text="emp.nik"></td>
                                                        <td class="px-3 py-2 text-sm font-medium">
                                                            <span x-text="emp.name"></span>
                                                            <template x-if="emp.already_selected">
                                                                <span class="ml-2 inline-flex items-center gap-1 px-1.5 py-0.5 rounded
                                                                            bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300
                                                                            text-[10px] font-semibold">
                                                                    Sudah ditambahkan
                                                                </span>
                                                            </template>
                                                        </td>
                                                        <td class="px-3 py-2 text-center text-xs" x-text="emp.department"></td>
                                                        <td class="px-3 py-2 text-center">
                                                            <template x-if="!emp.already_selected">
                                                                <button type="button" @click="pick(emp)"
                                                                    class="px-2.5 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium">
                                                                    Pilih
                                                                </button>
                                                            </template>
                                                            <template x-if="emp.already_selected">
                                                                <span class="px-2.5 py-1 text-xs bg-zinc-200 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400
                                                                            rounded-md font-medium cursor-not-allowed inline-block">
                                                                    Sudah Ada
                                                                </span>
                                                            </template>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- STEP 2B: PREVIEW + SHIFT/GROUP --}}
                                <div x-show="pickedId" x-cloak class="p-4 rounded-xl bg-blue-50 dark:bg-blue-950/20 border-2 border-blue-200 dark:border-blue-800">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm font-bold"
                                                x-text="pickedName.charAt(0).toUpperCase()"></div>
                                            <div>
                                                <div class="text-[10px] text-blue-700 dark:text-blue-400 font-semibold uppercase tracking-wider">Employee Terpilih</div>
                                                <div class="text-sm font-bold text-blue-800 dark:text-blue-300" x-text="pickedNik + ' - ' + pickedName"></div>
                                                <div class="text-xs text-blue-600 dark:text-blue-400" x-text="pickedDept"></div>
                                            </div>
                                        </div>
                                        <button type="button" @click="resetPick()"
                                            class="w-8 h-8 rounded-lg bg-red-100 hover:bg-red-200 text-red-600 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3 mb-3">
                                        <div>
                                            <label class="block text-[11px] font-semibold text-blue-700 dark:text-blue-300 uppercase mb-1">
                                                Shift <span class="text-red-500">*</span>
                                            </label>
                                            <select wire:model="tempShift"
                                                class="w-full border border-blue-300 dark:border-blue-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                                                <option value="">-- Pilih Shift --</option>
                                                <option value="NS">NS</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-semibold text-blue-700 dark:text-blue-300 uppercase mb-1">
                                                Group <span class="text-red-500">*</span>
                                            </label>
                                            <select wire:model="tempGroup"
                                                class="w-full border border-blue-300 dark:border-blue-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                                                <option value="">-- Pilih Group --</option>
                                                <option value="NS">NS</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                            </select>
                                        </div>
                                    </div>

                                    <button type="button" @click="addNow()"
                                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed text-white rounded-lg text-sm font-semibold shadow-lg shadow-blue-500/30"
                                        x-bind:disabled="!$wire.tempShift || !$wire.tempGroup">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                            <path d="M12 5.25a.75.75 0 0 1 .75.75v5.25H18a.75.75 0 0 1 0 1.5h-5.25V18a.75.75 0 0 1-1.5 0v-5.25H6a.75.75 0 0 1 0-1.5h5.25V6a.75.75 0 0 1 .75-.75Z" />
                                        </svg>
                                        Tambahkan Employee Ini
                                    </button>
                                </div>

                                @error('selectedEmployees') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror

                                {{-- STEP 2C: SELECTED LIST --}}
                                <div>
                                    <div class="text-[11px] font-semibold text-zinc-500 uppercase mb-2">Daftar Employee ({{ count($selectedEmployees) }})</div>
                                    <div class="border rounded-lg overflow-hidden dark:border-zinc-700">
                                        <table class="w-full text-sm">
                                            <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                                                <tr>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 uppercase w-10">#</th>
                                                    <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 uppercase">NIK</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 uppercase">Name</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 uppercase">Department</th>
                                                    <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 uppercase">Shift</th>
                                                    <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 uppercase">Group</th>
                                                    <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 uppercase w-20">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                                @forelse($selectedEmployees as $i => $emp)
                                                <tr wire:key="emp-{{ $i }}">
                                                    <td class="px-3 py-2 text-zinc-500">{{ $i + 1 }}</td>
                                                    <td class="px-3 py-2 text-center font-mono text-xs">{{ $emp['nik'] }}</td>
                                                    <td class="px-3 py-2 font-medium text-zinc-800 dark:text-white">{{ $emp['name'] }}</td>
                                                    <td class="px-3 py-2 text-xs">{{ $emp['department'] }}</td>
                                                    <td class="px-3 py-2 text-center">
                                                        <span class="inline-flex px-2 py-0.5 rounded text-xs font-semibold bg-blue-100 text-blue-700">
                                                            {{ $emp['shift'] ?: '-' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-3 py-2 text-center">
                                                        <span class="inline-flex px-2 py-0.5 rounded text-xs font-semibold bg-blue-100 text-blue-700">
                                                            {{ $emp['group'] ?: '-' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-3 py-2 text-center">
                                                        <flux:button wire:click="removeEmployee({{ $i }})" size="sm" icon="trash"
                                                            variant="primary" color="red" class="!p-2" />
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="7" class="px-3 py-6 text-center text-xs text-zinc-400 italic">
                                                        Belum ada employee dipilih.
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ========== STEP 3: DURASI (FIXED 5 MENIT) ========== --}}
                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                            <div class="px-5 py-3.5 border-b border-zinc-200 dark:border-zinc-800 bg-gradient-to-r from-cyan-50 to-blue-50 dark:from-cyan-950/30 dark:to-blue-950/30 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-cyan-600 flex items-center justify-center shadow-sm shadow-cyan-500/30">
                                    <span class="text-xs font-bold text-white">3</span>
                                </div>
                                <h3 class="text-sm font-bold text-zinc-800 dark:text-white">Durasi Pengerjaan</h3>
                                <span class="ml-auto text-[10px] px-2 py-0.5 rounded-full bg-cyan-100 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-400 font-bold uppercase">
                                    Fixed
                                </span>
                            </div>
                            <div class="p-5">
                                <div class="flex items-center gap-4 p-4 rounded-xl bg-cyan-50 dark:bg-cyan-950/20 border-2 border-cyan-200 dark:border-cyan-800">
                                    <div>
                                        <div class="text-sm font-bold text-cyan-800 dark:text-cyan-300">5 Menit</div>
                                        <div class="text-xs text-cyan-600 dark:text-cyan-400">
                                            Durasi otomatis 5 menit. Test akan close sendiri saat waktu habis.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 flex justify-end gap-3">
                    <button type="button" @click="open = false"
                        class="px-5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 text-sm font-medium">
                        Cancel
                    </button>
                    <button type="submit" form="blind-test-form"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm font-medium shadow-lg shadow-blue-500/30"
                        wire:loading.attr="disabled" wire:target="save">
                        <span wire:loading.remove wire:target="save">
                            {{ $blind_test_id ? 'Update' : 'Create ' . count($selectedEmployees) . ' Test' }}
                        </span>
                        <span wire:loading wire:target="save">Processing...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL VIEW ==================== -->
    <div x-data="{ open: false }"
        x-on:open-modal-view.window="open = true"
        x-on:close-modal-view.window="open = false"
        x-show="open" x-cloak @keydown.escape.window="open = false">

        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden">

                <div class="relative overflow-hidden bg-gradient-to-r from-cyan-600 via-blue-600 to-indigo-600 px-6 py-5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                                <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Blind Test Detail</h2>
                            <p class="text-xs text-blue-100">Informasi lengkap blind test</p>
                        </div>
                    </div>
                    <button type="button" @click="open = false"
                        class="w-9 h-9 rounded-lg bg-white/20 hover:bg-white/30 border border-white/30 text-white flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-6 bg-zinc-50 dark:bg-zinc-950/30">
                    @if($viewData)
                    <div class="relative overflow-hidden bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-5 mb-4 shadow-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center border-2 border-white/40">
                                    <span class="text-xl font-bold text-white">{{ strtoupper(substr($viewData->employee->name ?? 'N', 0, 1)) }}</span>
                                </div>
                                <div>
                                    <div class="text-[10px] text-blue-100 uppercase tracking-wider font-semibold">Employee</div>
                                    <div class="text-lg font-bold text-white">{{ $viewData->employee->name ?? '-' }}</div>
                                    <div class="text-xs text-blue-100 mt-0.5">
                                        {{ $viewData->employee->nik ?? '-' }} • {{ $viewData->shift ?? '-' }} • {{ $viewData->group ?? '-' }} • {{ $viewData->section ?? '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                @php $sc = ['pending' => 'yellow', 'in_progress' => 'blue', 'completed' => 'green']; @endphp
                                <div class="text-[10px] text-blue-100 uppercase tracking-wider font-semibold mb-1">Status</div>
                                <flux:badge size="md" color="{{ $viewData->trashed() ? 'zinc' : ($sc[$viewData->status] ?? 'gray') }}">
                                    {{ $viewData->trashed() ? 'Deleted' : ucfirst(str_replace('_', ' ', $viewData->status)) }}
                                </flux:badge>
                                @if($viewData->auto_saved)
                                    <div class="text-[10px] text-orange-300 font-bold mt-1 uppercase">Auto Saved</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($viewData->trashed())
                    <div class="mb-4 p-4 rounded-xl bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-800">
                        <div class="text-[10px] text-red-700 dark:text-red-400 uppercase tracking-wider font-semibold">Deleted Reason</div>
                        <div class="text-sm text-red-800 dark:text-red-300 mt-1">{{ $viewData->deleted_reason ?: '-' }}</div>
                        <div class="text-xs text-red-600 dark:text-red-400 mt-1">
                            Deleted at: {{ $viewData->deleted_at ? $viewData->deleted_at->format('d M Y H:i') : '-' }}
                        </div>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                            <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Customer</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->customer->customer_name ?? '-' }}</div>
                        </div>
                        @php
                            $viewModelNames = collect($viewData->question_snapshot ?? [])
                                ->flatMap(function ($q) {
                                    $items = $q['items'] ?? [];
                                    // Format baru: nested group
                                    if (!empty($items) && isset($items[0]['model_id'])) {
                                        return collect($items)->pluck('model_name')->filter();
                                    }
                                    // Format lama
                                    if (!empty($q['model_id'])) {
                                        $m = \App\Models\QAQC\BlindTest\Model::find($q['model_id']);
                                        return $m ? [$m->model_name] : [];
                                    }
                                    return [];
                                })
                                ->unique()
                                ->values();

                            if ($viewModelNames->isEmpty() && $viewData->model) {
                                $viewModelNames = collect([$viewData->model->model_name]);
                            }
                        @endphp

                        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                            <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">
                                Model @if($viewModelNames->count() > 1) ({{ $viewModelNames->count() }}) @endif
                            </div>
                            <div class="mt-1 flex flex-wrap gap-1">
                                @forelse($viewModelNames as $mName)
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold
                                        {{ $viewModelNames->count() > 1
                                            ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300'
                                            : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300' }}">
                                        {{ $mName }}
                                    </span>
                                @empty
                                    <span class="text-xs text-zinc-400">-</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                            <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Section</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->section ?? '-' }}</div>
                        </div>
                        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                            <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Durasi</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">
                                {{ $viewData->duration_minutes ? $viewData->duration_minutes . ' menit' : '-' }}
                            </div>
                        </div>
                        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                            <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Time Finish</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->finished_at ? $viewData->finished_at->format('H:i') : '-' }}</div>
                        </div>
                        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                            <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Waktu Pengerjaan</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->duration_formatted }}</div>
                        </div>
                        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                            <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Total Soal</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->total_items }}</div>
                        </div>
                        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                            <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Soal Dijawab</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->total_correct }} / {{ $viewData->total_items }}</div>
                        </div>
                    </div>

                    <!-- Kunci -->
                    <div class="rounded-xl border-2 border-blue-200 dark:border-blue-800 overflow-hidden mb-4 bg-white dark:bg-zinc-900">
                        <div class="px-5 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white flex items-center gap-3">
                            <h3 class="text-sm font-semibold">Tabel Kunci Jawaban</h3>
                            <span class="text-[11px] text-blue-100">{{ count($viewData->blind_test_items ?? []) }} soal</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-blue-50 dark:bg-blue-900/20 border-b border-blue-200 dark:border-blue-800">
                                    <tr>
                                        <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-blue-700 uppercase w-10">#</th>
                                        <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-blue-700 uppercase">Defect Item</th>
                                        <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-blue-700 uppercase">Location</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                    @foreach($viewData->blind_test_items ?? [] as $i => $item)
                                    @php $deffect = \App\Models\QAQC\BlindTest\Deffect::find($item['deffect_item_id'] ?? null); @endphp
                                    <tr class="hover:bg-blue-50/50">
                                        <td class="px-3 py-2.5 text-xs">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-700 font-semibold text-[10px]">
                                                {{ $i + 1 }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2.5 text-xs font-semibold text-zinc-800 dark:text-white">{{ $deffect->deffect_item_name ?? '-' }}</td>
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

                    <!-- Jawaban User -->
                    @if($viewData->status === 'completed' && $viewData->user_answers)
                    <div class="rounded-xl border-2 border-green-200 dark:border-green-800 overflow-hidden mb-4 bg-white dark:bg-zinc-900">
                        <div class="px-5 py-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white flex items-center gap-3">
                            <h3 class="text-sm font-semibold">Tabel Jawaban User & Hasil</h3>
                            <span class="text-[11px] text-green-100">{{ count($viewData->user_answers) }} baris</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-green-50 dark:bg-green-900/20 border-b border-green-200">
                                    <tr>
                                        <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-green-700 uppercase w-10">#</th>
                                        <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-green-700 uppercase">Defect Item</th>
                                        <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-green-700 uppercase">Location</th>
                                        <th class="px-3 py-2.5 text-center text-[11px] font-semibold text-green-700 uppercase w-32">Hasil</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                    @foreach($viewData->user_answers as $i => $row)
                                    @php
                                        $deffect = $row['deffect_item_id'] ? \App\Models\QAQC\BlindTest\Deffect::find($row['deffect_item_id']) : null;
                                        $userAnswer = $row['user_answer'] ?? '';
                                        $isCorrect = $row['is_correct'] ?? false;
                                        $isMissing = $userAnswer === 'MISSING';
                                        $isExtra = $userAnswer === 'EXTRA';
                                    @endphp
                                    <tr class="@if($isCorrect) hover:bg-green-50/50 @elseif($isMissing) bg-yellow-50/50 @elseif($isExtra) bg-purple-50/50 @else bg-red-50/50 @endif">
                                        <td class="px-3 py-2.5 text-xs">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full font-semibold text-[10px]
                                                @if($isCorrect) bg-green-100 text-green-700
                                                @elseif($isMissing) bg-yellow-100 text-yellow-700
                                                @elseif($isExtra) bg-purple-100 text-purple-700
                                                @else bg-red-100 text-red-700 @endif">
                                                {{ $i + 1 }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2.5 text-xs">
                                            <div class="font-semibold text-zinc-800 dark:text-white">{{ $deffect->deffect_item_name ?? '-' }}</div>
                                            @if($isMissing) <div class="text-[10px] text-orange-600 italic">Dari kunci</div> @endif
                                            @if($isExtra) <div class="text-[10px] text-purple-600 italic">Extra</div> @endif
                                        </td>
                                        <td class="px-3 py-2.5 text-xs">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-mono text-[10px] font-semibold">
                                                {{ $row['component_location'] ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2.5 text-center">
                                            @if($isCorrect)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-[10px] font-semibold border border-green-300">✓ Cocok</span>
                                            @elseif($isMissing)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700 text-[10px] font-semibold border border-yellow-300">⚠ Tidak Dijawab</span>
                                            @elseif($isExtra)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-purple-100 text-purple-700 text-[10px] font-semibold border border-purple-300">+ Extra</span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-100 text-red-700 text-[10px] font-semibold border border-red-300">✗ Tidak Cocok</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Signature -->
                    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-5">
                        <h3 class="text-sm font-bold text-zinc-800 dark:text-white mb-4">Signatures</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <div class="p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                                <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Check By QC</div>
                                <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->checkerQc->name ?? '-' }}</div>
                            </div>
                            <div class="p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                                <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Check By Prod</div>
                                <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->checkerProd->name ?? '-' }}</div>
                            </div>
                            <div class="p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                                <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Ack. By SPV</div>
                                <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->acknowledgerSpv->name ?? '-' }}</div>
                            </div>
                            <div class="p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                                <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Ack. QC SPV</div>
                                <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->acknowledgerQcSpv->name ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 flex justify-end gap-3">
                    <button type="button" @click="open = false"
                        class="px-5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 text-sm font-medium">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL DELETE ==================== -->
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

    <style>
        [x-cloak] { display: none !important; }

        /* ===== Scrollbar horizontal auto-hide ===== */
        .custom-scroll-x {
            scroll-behavior: smooth;
        }

        .custom-scroll-x::-webkit-scrollbar {
            height: 10px;
            transition: opacity 0.3s ease;
        }

        .custom-scroll-x::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scroll-x::-webkit-scrollbar-thumb {
            border-radius: 999px;
            transition: background 0.3s ease;
        }

        /* Hidden state */
        .scrollbar-hidden::-webkit-scrollbar-thumb {
            background: transparent;
        }

        /* Visible state */
        .scrollbar-visible::-webkit-scrollbar-thumb {
            background: rgba(161, 161, 170, 0.5);
            border: 2px solid transparent;
            background-clip: padding-box;
        }

        .scrollbar-visible::-webkit-scrollbar-thumb:hover {
            background: rgba(113, 113, 122, 0.8);
            background-clip: padding-box;
        }

        .dark .scrollbar-visible::-webkit-scrollbar-thumb {
            background: rgba(113, 113, 122, 0.6);
            background-clip: padding-box;
        }

        .dark .scrollbar-visible::-webkit-scrollbar-thumb:hover {
            background: rgba(161, 161, 170, 0.8);
            background-clip: padding-box;
        }

        /* Firefox fallback */
        .scrollbar-hidden {
            scrollbar-width: none;
        }

        .scrollbar-visible {
            scrollbar-width: thin;
            scrollbar-color: rgba(161, 161, 170, 0.5) transparent;
        }
    </style>
</div>