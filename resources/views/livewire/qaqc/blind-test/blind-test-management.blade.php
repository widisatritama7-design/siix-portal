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
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Pilih soal dari bank soal untuk membuat blind test</p>
        </div>
    </div>

    {{-- Bank Soal Header + Month Picker --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-1">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                    <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-zinc-800 dark:text-white leading-tight">Bank Soal</h2>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">Pilih soal untuk memulai blind test</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <input type="month"
                wire:model.live="bankMonth"
                class="bank-month-input px-4 py-2 rounded-xl border border-zinc-300 dark:border-zinc-700
                    bg-white dark:bg-zinc-900 text-sm font-semibold text-zinc-700 dark:text-zinc-200
                    focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                    hover:border-zinc-400 dark:hover:border-zinc-600
                    transition-all cursor-pointer">

            @if($bankMonth)
                <button type="button" wire:click="$set('bankMonth', '')"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-red-50 hover:bg-red-100 dark:bg-red-950/30 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 text-xs font-semibold transition-all">
                    Reset
                </button>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-blue-50 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-800 text-blue-600 dark:text-blue-400 text-xs font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                    Bulan Ini
                </span>
            @endif
        </div>
    </div>

    <style>
        .bank-month-input::-webkit-calendar-picker-indicator { cursor: pointer; opacity: 0.65; filter: invert(0); }
        .bank-month-input::-webkit-calendar-picker-indicator:hover { opacity: 1; }
        .dark .bank-month-input::-webkit-calendar-picker-indicator { filter: invert(1); }
        .bank-month-input { color-scheme: light; }
        .dark .bank-month-input { color-scheme: dark; }
    </style>

    {{-- Kartu Bank Soal --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mt-4">
        @foreach($sections as $sec)
        @php
            $secMeta = [
                'QC'  => ['grad' => 'from-blue-500 to-indigo-600',   'badge' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',     'accent' => 'text-blue-600 dark:text-blue-400'],
                'SMT' => ['grad' => 'from-green-500 to-emerald-600', 'badge' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300', 'accent' => 'text-green-600 dark:text-green-400'],
                'BE'  => ['grad' => 'from-amber-500 to-orange-600',  'badge' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300', 'accent' => 'text-amber-600 dark:text-amber-400'],
                'MI'  => ['grad' => 'from-purple-500 to-pink-600',   'badge' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300', 'accent' => 'text-purple-600 dark:text-purple-400'],
            ];
            $style = $secMeta[$sec] ?? $secMeta['QC'];
            $list = $questionBank[$sec] ?? collect();
            $count = $list->count();
        @endphp

        <div class="group/card bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 overflow-hidden flex flex-col">
            <div class="relative px-4 py-3.5 bg-gradient-to-r {{ $style['grad'] }} overflow-hidden">
                <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-white/10"></div>
                <div class="relative flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-white">
                            <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[10px] text-white/70 uppercase tracking-wider font-semibold leading-none mb-0.5">Section</div>
                        <div class="text-base font-bold text-white leading-none">{{ $sec }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-white leading-none">{{ $count }}</div>
                        <div class="text-[9px] text-white/70 uppercase tracking-wider font-semibold">soal</div>
                    </div>
                </div>
            </div>

            <div class="px-4 py-2 bg-zinc-50 dark:bg-zinc-800/40 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                <div class="text-[10px] text-zinc-500 dark:text-zinc-400 font-semibold uppercase tracking-wide">
                    {{ $bankDate->translatedFormat('F Y') }}
                </div>
                @if($count > 0)
                    <div class="text-[9px] text-zinc-400 dark:text-zinc-500 font-medium">Terbaru</div>
                @endif
            </div>

            <div class="flex-1 overflow-y-auto p-2 space-y-1.5" style="max-height: 220px;">
                @forelse($list as $q)
                @php $itemCount = $q->totalDefects(); @endphp
                <button type="button"
                    wire:click="openCreateModal({{ $q->id }})"
                    wire:key="bank-q-{{ $q->id }}"
                    class="group/item w-full text-left p-3 rounded-xl border border-zinc-100 dark:border-zinc-800 bg-white dark:bg-zinc-900 hover:border-zinc-300 dark:hover:border-zinc-600 hover:shadow-md transition-all duration-200">

                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="text-[10px] font-mono font-bold text-zinc-400 dark:text-zinc-500">#{{ $q->id }}</span>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold {{ $style['badge'] }}">
                            {{ $itemCount }} defect
                        </span>
                    </div>

                    <div class="flex items-center gap-1.5 text-xs text-zinc-700 dark:text-zinc-300 mb-1.5">
                        <span class="text-emerald-500">●</span>
                        <span class="font-semibold truncate">{{ $q->customer->customer_name ?? '-' }}</span>
                    </div>

                    @php
                        $modelNames = $q->models->pluck('model_name')->filter()->values();
                        if ($modelNames->isEmpty() && $q->model) {
                            $modelNames = collect([$q->model->model_name]);
                        }
                    @endphp
                    @if($modelNames->isNotEmpty())
                        <div class="flex items-start gap-1.5 text-[11px]">
                            <span class="text-purple-500">■</span>
                            <div class="flex flex-wrap items-center gap-1 leading-tight">
                                @if($modelNames->count() === 1)
                                    <span class="text-zinc-600 dark:text-zinc-400 font-medium truncate">{{ $modelNames->first() }}</span>
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

                    <div class="mt-2 flex items-center justify-between">
                        <span class="text-[10px] text-zinc-400 dark:text-zinc-500 font-medium">
                            {{ $q->created_at?->diffForHumans() ?? '-' }}
                        </span>
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold {{ $style['accent'] }} opacity-0 group-hover/item:opacity-100 transition-all duration-200">
                            Create →
                        </span>
                    </div>
                </button>
                @empty
                <div class="px-4 py-10 text-center">
                    <div class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-0.5">Belum ada soal</div>
                    <div class="text-[10px] text-zinc-400 dark:text-zinc-500">Bulan {{ $bankDate->translatedFormat('F Y') }}</div>
                </div>
                @endforelse
            </div>
        </div>
        @endforeach
    </div>

    {{-- Filter Card --}}
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
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium whitespace-nowrap shadow-md shadow-orange-500/30 border border-orange-600 transition-all duration-200 hover:scale-105 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-4 h-4 transition-transform duration-200"
                        :class="filterOpen ? 'rotate-180' : ''">
                        <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 0 1-1.06 0l-7.5-7.5a.75.75 0 0 1 1.06-1.06L12 14.69l6.97-6.97a.75.75 0 1 1 1.06 1.06l-7.5 7.5Z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="filterOpen ? 'Hide Filter' : 'Unhide Filter'"></span>
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
                    <select wire:model.live="filterDepartment" class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">All Department</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept }}">{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 uppercase mb-1">Shift</label>
                    <select wire:model.live="filterShift" class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">All Shift</option>
                        @foreach($shifts as $s)
                            <option value="{{ $s }}">{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 uppercase mb-1">Group</label>
                    <select wire:model.live="filterGroup" class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">All Group</option>
                        @foreach($groups as $g)
                            <option value="{{ $g }}">{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 uppercase mb-1">Section</label>
                    <select wire:model.live="filterSection" class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">All Section</option>
                        @foreach($sections as $sec)
                            <option value="{{ $sec }}">{{ $sec }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 uppercase mb-1">Customer</label>
                    <select wire:model.live="filterCustomer" class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">All Customer</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->customer_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 uppercase mb-1">Model</label>
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
                    <select wire:model.live="filterResult" class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">All Result</option>
                        <option value="PASS">PASS</option>
                        <option value="FAIL">FAIL</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 uppercase mb-1">From Date</label>
                    <input type="date" wire:model.live="filterDateFrom" class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 uppercase mb-1">Until Date</label>
                    <input type="date" wire:model.live="filterDateTo" class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>
    </flux:card>

    {{-- Tabs --}}
    <div class="border-b border-zinc-200 dark:border-zinc-700 pb-4">
        <div class="overflow-x-auto scrollbar-hide">
            <div class="flex justify-center min-w-full w-max">
                <div class="flex flex-nowrap gap-2 px-1">
                    @php
                        $tabs = [
                            'all'         => ['label' => 'All',         'color' => 'bg-blue-600'],
                            'open'        => ['label' => 'Open',        'color' => 'bg-yellow-500'],
                            'in_progress' => ['label' => 'In Progress', 'color' => 'bg-blue-600'],
                            'closed'      => ['label' => 'Closed',      'color' => 'bg-green-600'],
                            'rejected'    => ['label' => 'Rejected',    'color' => 'bg-red-600'],
                            'deleted'     => ['label' => 'Deleted',     'color' => 'bg-zinc-600'],
                        ];
                    @endphp
                    @foreach($tabs as $key => $t)
                    <button wire:click="setTab('{{ $key }}')"
                        class="px-5 py-2.5 text-sm font-medium rounded-lg whitespace-nowrap
                            {{ $activeTab === $key
                                ? $t['color'] . ' text-white shadow-md'
                                : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
                        {{ $t['label'] }}
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full
                            {{ $activeTab === $key
                                ? 'bg-white/20 text-white'
                                : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400' }}">
                            {{ $tabCounts[$key] ?? 0 }}
                        </span>
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== VIEW MODE TOGGLE ==================== --}}
    <div class="flex justify-end mt-2">
        <div class="relative grid grid-cols-2 gap-0 rounded-2xl border border-zinc-200 dark:border-zinc-700
                    bg-zinc-50 dark:bg-zinc-900 p-1 shadow-sm">

            {{-- Sliding highlight indicator --}}
            <span class="absolute top-1 bottom-1 left-1 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600
                        shadow-lg shadow-blue-500/30 transition-transform duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)]
                        {{ $viewMode === 'full' ? 'translate-x-full' : 'translate-x-0' }}"
                style="width: calc(50% - 4px);"></span>

            {{-- Tombol Normal --}}
            <button wire:click="setViewMode('normal')"
                class="relative z-10 inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl
                    text-xs font-bold whitespace-nowrap transition-all duration-300
                    {{ $viewMode === 'normal'
                        ? 'text-white scale-105'
                        : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-4 h-4 transition-transform duration-300
                        {{ $viewMode === 'normal' ? 'scale-110' : 'scale-100' }}">
                    <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" />
                </svg>
                <span>Normal</span>
            </button>

            {{-- Tombol Full Width --}}
            <button wire:click="setViewMode('full')"
                class="relative z-10 inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl
                    text-xs font-bold whitespace-nowrap transition-all duration-300
                    {{ $viewMode === 'full'
                        ? 'text-white scale-105'
                        : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-4 h-4 transition-transform duration-300
                        {{ $viewMode === 'full' ? 'scale-110' : 'scale-100' }}">
                    <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm3-1.5A1.5 1.5 0 0 0 4.5 6v12A1.5 1.5 0 0 0 6 19.5h12a1.5 1.5 0 0 0 1.5-1.5V6A1.5 1.5 0 0 0 18 4.5H6Z" clip-rule="evenodd" />
                </svg>
                <span>Full Width</span>
            </button>
        </div>
    </div>

    @if($viewMode === 'full')
        {{-- MODE FULL: Week Calendar di atas + Table 100% --}}
        <div class="space-y-4 mt-2" wire:key="view-mode-full">
            {{-- Week Calendar dengan animasi slide down --}}
            <div class="week-calendar-enter">
                @include('livewire.qaqc.blind-test.partials.calendar-week-widget')
            </div>

            {{-- Table dengan animasi fade in --}}
            <div class="table-enter">
                @include('livewire.qaqc.blind-test.partials.blind-test-table', ['blindTests' => $blindTests])
            </div>
        </div>
    @else
        {{-- MODE NORMAL: Table 70% + Month Calendar 30% --}}
        <div class="grid grid-cols-1 lg:grid-cols-10 gap-4 items-start mt-2 view-mode-enter" wire:key="view-mode-normal">
            <div class="lg:col-span-7 table-enter">
                @include('livewire.qaqc.blind-test.partials.blind-test-table', ['blindTests' => $blindTests])
            </div>
            <div class="lg:col-span-3 view-mode-enter">
                @include('livewire.qaqc.blind-test.partials.calendar-widget')
            </div>
        </div>
    @endif

    {{-- ==================== MODALS ==================== --}}
    @include('livewire.qaqc.blind-test.partials.blind-test-form-modal')
    @include('livewire.qaqc.blind-test.partials.blind-test-view-modal')
    @include('livewire.qaqc.blind-test.partials.blind-test-delete-modal')

    {{-- Approval Modal --}}
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

    {{-- Notifikasi --}}
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
        .custom-scroll-x { scroll-behavior: smooth; }
        .custom-scroll-x::-webkit-scrollbar { height: 10px; }
        .custom-scroll-x::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll-x::-webkit-scrollbar-thumb { border-radius: 999px; }
        .scrollbar-hidden::-webkit-scrollbar-thumb { background: transparent; }
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
        .scrollbar-hidden { scrollbar-width: none; }
        .scrollbar-visible { scrollbar-width: thin; scrollbar-color: rgba(161, 161, 170, 0.5) transparent; }
        /* ==================== VIEW MODE TRANSITION ==================== */
        .view-mode-transition {
            transition: opacity 0.35s ease, transform 0.35s ease;
        }

        .view-mode-enter {
            animation: viewModeEnter 0.45s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .view-mode-leave {
            animation: viewModeLeave 0.25s ease-in both;
        }

        @keyframes viewModeEnter {
            0% {
                opacity: 0;
                transform: translateY(12px) scale(0.98);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes viewModeLeave {
            0% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
            100% {
                opacity: 0;
                transform: translateY(-8px) scale(0.98);
            }
        }

        /* Week calendar: slide down dari atas */
        .week-calendar-enter {
            animation: weekCalendarEnter 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes weekCalendarEnter {
            0% {
                opacity: 0;
                transform: translateY(-24px);
                max-height: 0;
            }
            100% {
                opacity: 1;
                transform: translateY(0);
                max-height: 500px;
            }
        }

        /* Table: fade in dari bawah */
        .table-enter {
            animation: tableEnter 0.4s cubic-bezier(0.16, 1, 0.3, 1) 0.1s both;
        }

        @keyframes tableEnter {
            0% {
                opacity: 0;
                transform: translateY(16px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</div>