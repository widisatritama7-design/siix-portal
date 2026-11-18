<div class="p-1 space-y-2">
    @section('title', 'Event Management - ESD Control Panel')

    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">Maintenance</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">ESD</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">Event</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2 mb-4">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">Event Management</h1>
            <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage ESD events and activities
            </p>
        </div>
        <div class="flex items-center gap-2">
            <button wire:click="exportPdf"
                    wire:loading.attr="disabled"
                    wire:target="exportPdf"
                    class="flex items-center gap-1.5 px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all duration-300 text-xs sm:text-sm font-medium shadow-sm hover:scale-105 active:scale-95 disabled:opacity-60 disabled:cursor-wait disabled:hover:scale-100">
                
                {{-- Icon normal (saat tidak loading) --}}
                <svg wire:loading.remove wire:target="exportPdf"
                    class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                
                {{-- Icon loading (saat exportPdf berjalan) --}}
                <svg wire:loading wire:target="exportPdf"
                    class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                </svg>
                
                {{-- Text --}}
                <span wire:loading.remove wire:target="exportPdf">Export PDF</span>
                <span wire:loading wire:target="exportPdf">Exporting...</span>
            </button>
            <button wire:click="openCreateModal"
                    class="flex items-center gap-1.5 px-3 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition-all duration-300 text-xs sm:text-sm font-medium shadow-sm hover:scale-105 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Event
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-800 p-4 sm:p-5 mb-4">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-white">
                        <path fill-rule="evenodd" d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.541-1.836Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-zinc-800 dark:text-white leading-tight">Filters</h3>
                    <p class="text-[11px] text-zinc-500 dark:text-zinc-400">Refine your event search</p>
                </div>
            </div>

            <button wire:click="resetFilters"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 hover:text-red-600 dark:hover:text-red-400 rounded-lg transition-all active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                    <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
                </svg>
                Reset
            </button>
        </div>

        {{-- Inputs --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">

            {{-- Search --}}
            <div class="lg:col-span-2">
                <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Search</label>
                <div class="relative">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-zinc-400">
                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search title or description..."
                        class="w-full pl-9 pr-3 py-2.5 text-sm rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-800 dark:text-white placeholder:text-zinc-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
            </div>

            {{-- Type --}}
            <div>
                <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Type</label>
                <div class="relative">
                    <select wire:model.live="filterType"
                            class="w-full px-3 py-2.5 pr-9 text-sm rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-800 dark:text-white appearance-none cursor-pointer focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">All Types</option>
                        @foreach($types as $t)
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endforeach
                    </select>
                    <svg class="w-4 h-4 text-zinc-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">Status</label>
                <div class="relative">
                    <select wire:model.live="filterStatus"
                            class="w-full px-3 py-2.5 pr-9 text-sm rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-800 dark:text-white appearance-none cursor-pointer focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">All Status</option>
                        <option value="red">Open</option>
                        <option value="yellow">On Progress</option>
                        <option value="green">Closed</option>
                    </select>
                    <svg class="w-4 h-4 text-zinc-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>

            {{-- From --}}
            <div>
                <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">From</label>
                <div class="relative">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-zinc-400">
                            <path d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" />
                        </svg>
                    </div>
                    <input type="date"
                        wire:model.live="filterDateFrom"
                        class="w-full pl-9 pr-3 py-2.5 text-sm rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
            </div>

            {{-- To --}}
            <div>
                <label class="block text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-1.5">To</label>
                <div class="relative">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-zinc-400">
                            <path d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" />
                        </svg>
                    </div>
                    <input type="date"
                        wire:model.live="filterDateTo"
                        class="w-full pl-9 pr-3 py-2.5 text-sm rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
            </div>
        </div>

        {{-- Active Filter Chips --}}
        @if($search || $filterType || $filterStatus || $filterDateFrom || $filterDateTo)
        <div class="flex flex-wrap items-center gap-1.5 mt-4 pt-3 border-t border-zinc-100 dark:border-zinc-800">
            <span class="text-[11px] font-semibold text-zinc-400 dark:text-zinc-500 uppercase tracking-wider mr-1">Active:</span>

            @if($search)
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-[11px] font-medium">
                    Search: "{{ $search }}"
                    <button wire:click="$set('search', '')" class="hover:text-blue-900 dark:hover:text-blue-100">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </span>
            @endif

            @if($filterType)
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 text-[11px] font-medium">
                    Type: {{ $filterType }}
                    <button wire:click="$set('filterType', '')" class="hover:text-purple-900 dark:hover:text-purple-100">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </span>
            @endif

            @if($filterStatus)
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md
                    {{ $filterStatus === 'red' ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300' :
                    ($filterStatus === 'yellow' ? 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-300' :
                    'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-300') }}
                    text-[11px] font-medium">
                    Status: {{ ['red'=>'Open','yellow'=>'On Progress','green'=>'Closed'][$filterStatus] ?? $filterStatus }}
                    <button wire:click="$set('filterStatus', '')" class="hover:opacity-70">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </span>
            @endif

            @if($filterDateFrom)
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 text-[11px] font-medium">
                    From: {{ $filterDateFrom }}
                    <button wire:click="$set('filterDateFrom', '')" class="hover:text-indigo-900 dark:hover:text-indigo-100">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </span>
            @endif

            @if($filterDateTo)
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 text-[11px] font-medium">
                    To: {{ $filterDateTo }}
                    <button wire:click="$set('filterDateTo', '')" class="hover:text-indigo-900 dark:hover:text-indigo-100">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </span>
            @endif
        </div>
        @endif
    </div>

    <!-- ==================== TABLE ==================== -->
    <flux:card class="p-0 shadow-lg flex flex-col overflow-hidden">

        {{-- ===== HEADER ===== --}}
        <div class="relative px-6 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 overflow-hidden">
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
                        <div class="text-[10px] text-white/70 uppercase tracking-wider font-semibold">Activity</div>
                        <div class="text-base font-bold text-white leading-tight">Event List</div>
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-wrap">
                    @if($search)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                            </svg>
                            {{ $search }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                            All Events
                        </span>
                    @endif

                    @if($filterType)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                <path fill-rule="evenodd" d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.541-1.836Z" clip-rule="evenodd" />
                            </svg>
                            {{ $filterType }}
                        </span>
                    @endif

                    <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                            <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clip-rule="evenodd" />
                        </svg>
                        {{ $events->total() }} total
                    </span>
                </div>
            </div>
        </div>

        {{-- ===== BODY ===== --}}
        <div class="p-6 flex flex-col flex-1">
            <div class="overflow-x-auto flex-1">
                <table class="w-full" style="min-width: 1000px; white-space: nowrap;">
                    <thead>
                        <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 50px;">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 250px;">Title</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 150px;">Type</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 130px;">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 130px;">Start</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 130px;">End</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 100px;">Files</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 160px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($events as $index => $event)
                        @php
                            $statusLabel = match($event->color) {
                                'red'    => 'Open',
                                'yellow' => 'On Progress',
                                'green'  => 'Closed',
                                default  => 'Open',
                            };
                            $statusColor = match($event->color) {
                                'red'    => 'red',
                                'yellow' => 'yellow',
                                'green'  => 'green',
                                default  => 'zinc',
                            };
                            $typeColor = match($event->type) {
                                'Abnormality'       => 'rose',
                                'Project'           => 'blue',
                                'Daily Measurement' => 'purple',
                                'Repair'            => 'amber',
                                default             => 'zinc',
                            };
                            $fileCount = is_array($event->file) ? count($event->file) : 0;
                        @endphp
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="event-{{ $event->id }}">
                            <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 text-center">
                                {{ $events->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3 text-left">
                                <div class="text-sm font-semibold text-zinc-800 dark:text-white truncate max-w-md">
                                    {{ $event->title }}
                                </div>
                                @if($event->description)
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400 truncate max-w-md mt-0.5">
                                        {{ \Illuminate\Support\Str::limit($event->description, 60) }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <flux:badge size="sm" color="{{ $typeColor }}" variant="pill">
                                    {{ $event->type ?? '-' }}
                                </flux:badge>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <flux:badge size="sm" color="{{ $statusColor }}" variant="pill">
                                    {{ $statusLabel }}
                                </flux:badge>
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400 text-center">
                                @if($event->start_at)
                                    <div class="font-medium">{{ $event->start_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-zinc-400">{{ $event->start_at->format('H:i') }}</div>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400 text-center">
                                @if($event->end_at)
                                    <div class="font-medium">{{ $event->end_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-zinc-400">{{ $event->end_at->format('H:i') }}</div>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($fileCount > 0)
                                    <flux:tooltip content="Preview attachments" position="top">
                                        <flux:button
                                            wire:click="openPreviewModal({{ $event->id }}, 0)"
                                            size="sm"
                                            icon="paper-clip"
                                            variant="primary"
                                            color="blue"
                                            class="!p-2 flex-shrink-0"
                                        >
                                            {{ $fileCount }}
                                        </flux:button>
                                    </flux:tooltip>
                                @else
                                    <span class="text-xs text-zinc-400 dark:text-zinc-500">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-1" style="flex-wrap: nowrap;">
                                    <flux:tooltip content="Edit" position="top">
                                        <flux:button
                                            wire:click="openEditModal({{ $event->id }})"
                                            size="sm"
                                            icon="pencil-square"
                                            variant="primary"
                                            color="yellow"
                                            class="!p-2 flex-shrink-0"
                                        />
                                    </flux:tooltip>

                                    <flux:tooltip content="Delete" position="top">
                                        <flux:button
                                            wire:click="confirmDelete({{ $event->id }})"
                                            size="sm"
                                            icon="trash"
                                            variant="primary"
                                            color="red"
                                            class="!p-2 flex-shrink-0"
                                        />
                                    </flux:tooltip>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center">
                                <div class="flex flex-col items-center justify-center gap-2 py-6">
                                    <div class="w-16 h-16 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                        <flux:icon name="calendar-days" class="w-8 h-8 text-zinc-400 dark:text-zinc-500" />
                                    </div>
                                    <div>
                                        <h3 class="text-base font-medium text-zinc-900 dark:text-white mb-0.5">
                                            No events found
                                        </h3>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                            {{ ($search || $filterType || $filterStatus || $filterDateFrom || $filterDateTo) ? 'Try adjusting your filters' : 'Get started by creating a new event' }}
                                        </p>
                                    </div>
                                    @if($search || $filterType || $filterStatus || $filterDateFrom || $filterDateTo)
                                        <flux:button wire:click="resetFilters" size="sm" class="mt-1">
                                            Clear Filters
                                        </flux:button>
                                    @else
                                        <flux:button wire:click="openCreateModal" size="sm" class="mt-1">
                                            New Event
                                        </flux:button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Per Page + Custom Pagination --}}
            `@if($events->total() > 0)
            <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700 flex flex-col sm:flex-row justify-between items-center gap-3">

                {{-- Left: per page + info --}}
                <div class="flex items-center gap-2 text-xs text-zinc-600 dark:text-zinc-400">
                    <span>Show</span>
                    <select wire:model.live="perPage"
                            class="px-2 py-1.5 text-xs border border-zinc-200 dark:border-zinc-700 rounded-md bg-white dark:bg-zinc-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span>entries</span>
                    <span class="text-zinc-400 dark:text-zinc-500 hidden sm:inline">
                        · Showing
                        <span class="font-semibold text-zinc-600 dark:text-zinc-300">{{ $events->firstItem() }}</span>–<span class="font-semibold text-zinc-600 dark:text-zinc-300">{{ $events->lastItem() }}</span>
                        of
                        <span class="font-semibold text-zinc-600 dark:text-zinc-300">{{ $events->total() }}</span>
                    </span>
                </div>

                {{-- Right: custom pagination --}}
                <div class="flex items-center gap-2">
                    {{-- Mobile: page info --}}
                    <span class="sm:hidden text-xs text-zinc-500 dark:text-zinc-400 font-medium">
                        {{ $events->currentPage() }} / {{ $events->lastPage() }}
                    </span>

                    @if ($events->hasPages())
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center gap-1">

                            {{-- Previous --}}
                            @if ($events->onFirstPage())
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-300 dark:text-zinc-600 cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </span>
                            @else
                                <button type="button"
                                        wire:click="previousPage('{{ $events->getPageName() }}')"
                                        wire:loading.attr="disabled"
                                        wire:target="previousPage,nextPage,gotoPage"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 dark:hover:bg-blue-900/30 dark:hover:border-blue-700 dark:hover:text-blue-400 transition-all duration-150 disabled:opacity-50 disabled:cursor-wait">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                            @endif

                            {{-- Page Numbers (skip Previous & Next dari linkCollection) --}}
                            @foreach ($events->linkCollection() as $link)
                                @continue(in_array($link['label'], ['&laquo; Previous', 'Next &raquo;'], true))

                                @if (is_null($link['url']))
                                    {{-- Ellipsis --}}
                                    <span class="inline-flex items-center justify-center w-8 h-8 text-xs text-zinc-400 dark:text-zinc-500 select-none">
                                        {{ $link['label'] }}
                                    </span>
                                @elseif ($link['active'])
                                    {{-- Active page --}}
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 text-white text-xs font-semibold shadow-md shadow-blue-500/30">
                                        {{ $link['label'] }}
                                    </span>
                                @else
                                    {{-- Linkable page --}}
                                    <button type="button"
                                            wire:key="page-{{ $link['label'] }}"
                                            wire:click="gotoPage({{ (int) $link['label'] }}, '{{ $events->getPageName() }}')"
                                            wire:loading.attr="disabled"
                                            wire:target="previousPage,nextPage,gotoPage"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 dark:hover:bg-blue-900/30 dark:hover:border-blue-700 dark:hover:text-blue-400 transition-all duration-150 text-xs font-medium disabled:opacity-50 disabled:cursor-wait">
                                        {{ $link['label'] }}
                                    </button>
                                @endif
                            @endforeach

                            {{-- Next --}}
                            @if ($events->hasMorePages())
                                <button type="button"
                                        wire:click="nextPage('{{ $events->getPageName() }}')"
                                        wire:loading.attr="disabled"
                                        wire:target="previousPage,nextPage,gotoPage"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 dark:hover:bg-blue-900/30 dark:hover:border-blue-700 dark:hover:text-blue-400 transition-all duration-150 disabled:opacity-50 disabled:cursor-wait">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            @else
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-300 dark:text-zinc-600 cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            @endif

                        </nav>
                    @endif
                </div>
            </div>
            @endif`
        </div>
    </flux:card>

    <!-- ============================ -->
    <!-- MODAL FORM EVENT (Wizard)     -->
    <!-- ============================ -->
    <div x-data="{ open: false }"
         x-show="open"
         @open-event-form-modal.window="open = true"
         @close-event-form-modal.window="open = false"
         x-cloak>

        <div class="fixed inset-0 bg-zinc-900/60 backdrop-blur-sm z-40" x-transition.opacity @click="open = false; $wire.closeFormModal()"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[92vh] flex flex-col overflow-hidden border border-zinc-200 dark:border-zinc-800"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">

                {{-- HEADER --}}
                <div class="sticky top-0 z-10 bg-gradient-to-r from-blue-600 via-blue-600 to-indigo-600 px-6 py-4 flex items-center justify-between shadow-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center ring-2 ring-white/30">
                            <flux:icon name="{{ $event_id ? 'pencil-square' : 'calendar-days' }}" class="w-5 h-5 text-white" />
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white leading-tight">{{ $modalTitle }}</h2>
                            <p class="text-xs text-blue-100 mt-0.5">
                                Step {{ $wizardStep }} of 3 —
                                {{ $wizardStep == 1 ? 'Basic Info' : ($wizardStep == 2 ? 'Attachments' : 'Review') }}
                            </p>
                        </div>
                    </div>
                    <button type="button" wire:click="closeFormModal"
                            class="w-9 h-9 rounded-lg bg-white/10 hover:bg-white/25 flex items-center justify-center text-white transition-colors">
                        <flux:icon name="x-mark" class="w-5 h-5" />
                    </button>
                </div>

                {{-- STEPS --}}
                <div class="bg-zinc-50 dark:bg-zinc-800/60 border-b border-zinc-200 dark:border-zinc-700 px-6 py-3">
                    <div class="flex items-center justify-between gap-2">
                        @foreach([1 => 'Basic Info', 2 => 'Attachments', 3 => 'Review'] as $step => $label)
                            <button type="button"
                                    wire:click="setWizardStep({{ $step }})"
                                    class="flex-1 text-center transition-all duration-300 {{ $wizardStep >= $step ? 'cursor-pointer' : 'cursor-not-allowed opacity-50' }}">
                                <div class="flex flex-col sm:flex-row items-center justify-center gap-1.5 sm:gap-2">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300 shadow-sm
                                        {{ $wizardStep > $step ? 'bg-green-500 text-white' : ($wizardStep === $step ? 'bg-blue-600 text-white ring-4 ring-blue-200 dark:ring-blue-900/50' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400') }}">
                                        @if($wizardStep > $step)
                                            <flux:icon name="check" class="w-4 h-4" />
                                        @else
                                            {{ $step }}
                                        @endif
                                    </div>
                                    <span class="text-[10px] sm:text-xs font-semibold {{ $wizardStep >= $step ? 'text-zinc-900 dark:text-white' : 'text-zinc-400' }}">
                                        {{ $label }}
                                    </span>
                                </div>
                            </button>
                            @if($step < 3)
                                <div class="flex-1 h-0.5 bg-zinc-200 dark:bg-zinc-700 rounded">
                                    <div class="h-0.5 bg-blue-600 rounded transition-all duration-500"
                                         style="width: {{ $wizardStep > $step ? '100%' : '0%' }}"></div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- BODY --}}
                <div class="flex-1 overflow-y-auto">
                    <form wire:submit="save" id="event-form" class="p-6 space-y-6">

                        {{-- STEP 1 --}}
                        <div x-show="$wire.wizardStep === 1" x-transition.opacity>
                            {{-- Event Info --}}
                            <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5 mb-5">
                                <div class="flex items-center gap-2.5 mb-4">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                                        <flux:icon name="information-circle" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">Event Information</h3>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Title, type, and description</p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Title <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model="title" placeholder="e.g. Monthly ESD Audit"
                                               class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 transition-shadow">
                                        @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Type <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select wire:model="type"
                                                    class="w-full px-3 py-2.5 pr-10 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl bg-white text-zinc-800 appearance-none cursor-pointer focus:ring-2 focus:ring-blue-500 transition-shadow dark:bg-zinc-800 dark:text-white [&>option]:bg-white [&>option]:text-zinc-800 dark:[&>option]:bg-zinc-800 dark:[&>option]:text-white">
                                                @foreach($types as $t)
                                                    <option value="{{ $t }}">{{ $t }}</option>
                                                @endforeach
                                            </select>
                                            <flux:icon name="chevron-down" class="w-4 h-4 text-zinc-500 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                                        </div>
                                        @error('type') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Description</label>
                                        <textarea wire:model="description" rows="3" placeholder="Optional details..."
                                                  class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 transition-shadow"></textarea>
                                        @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Schedule --}}
                            <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5 mb-5">
                                <div class="flex items-center gap-2.5 mb-4">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                                        <flux:icon name="clock" class="w-4 h-4 text-indigo-600 dark:text-indigo-400" />
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">Schedule</h3>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Start and end date/time</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Start Date <span class="text-red-500">*</span></label>
                                        <input type="date" wire:model="start_date"
                                               class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 transition-shadow">
                                        @error('start_date') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">Start Time <span class="text-red-500">*</span></label>
                                        <input type="time" wire:model="start_time"
                                               class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 transition-shadow">
                                        @error('start_time') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">End Date <span class="text-red-500">*</span></label>
                                        <input type="date" wire:model="end_date"
                                               class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 transition-shadow">
                                        @error('end_date') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">End Time <span class="text-red-500">*</span></label>
                                        <input type="time" wire:model="end_time"
                                               class="w-full px-3 py-2.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-xl dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 transition-shadow">
                                        @error('end_time') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                <div class="flex items-center gap-2.5 mb-4">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center">
                                        <flux:icon name="signal" class="w-4 h-4 text-emerald-600 dark:text-emerald-400" />
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">Status</h3>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Current event status</p>
                                    </div>
                                </div>

                                @php
                                    $statuses = [
                                        'red'    => ['label' => 'Open',        'icon' => 'exclamation-circle', 'border' => 'border-red-500',    'bg' => 'bg-red-50 dark:bg-red-900/20',       'ring' => 'ring-red-300 dark:ring-red-700',       'iconOn' => 'text-red-600 dark:text-red-400',       'textOn' => 'text-red-700 dark:text-red-300',       'dot' => 'bg-red-500'],
                                        'yellow' => ['label' => 'On Progress', 'icon' => 'arrow-path',         'border' => 'border-yellow-500', 'bg' => 'bg-yellow-50 dark:bg-yellow-900/20', 'ring' => 'ring-yellow-300 dark:ring-yellow-700', 'iconOn' => 'text-yellow-600 dark:text-yellow-400', 'textOn' => 'text-yellow-700 dark:text-yellow-300', 'dot' => 'bg-yellow-500'],
                                        'green'  => ['label' => 'Closed',      'icon' => 'check-circle',       'border' => 'border-green-500',  'bg' => 'bg-green-50 dark:bg-green-900/20',   'ring' => 'ring-green-300 dark:ring-green-700',   'iconOn' => 'text-green-600 dark:text-green-400',   'textOn' => 'text-green-700 dark:text-green-300',   'dot' => 'bg-green-500'],
                                    ];
                                @endphp

                                <div class="grid grid-cols-3 gap-2" x-data="{ selected: @entangle('color') }">
                                    @foreach($statuses as $value => $style)
                                        <button type="button"
                                                @click="selected = @js($value)"
                                                :class="selected === @js($value)
                                                    ? '{{ $style['border'] }} {{ $style['bg'] }} ring-2 {{ $style['ring'] }} shadow-md'
                                                    : 'border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 hover:border-zinc-300 dark:hover:border-zinc-600'"
                                                class="relative p-3 rounded-xl border-2 transition-all duration-150 flex flex-col items-center justify-center gap-2 text-center">
                                            <flux:icon name="{{ $style['icon'] }}"
                                                       ::class="selected === @js($value) ? 'w-5 h-5 {{ $style['iconOn'] }}' : 'w-5 h-5 text-zinc-500 dark:text-zinc-400'" />
                                            <span ::class="selected === @js($value) ? 'text-[11px] font-bold uppercase tracking-wide {{ $style['textOn'] }}' : 'text-[11px] font-bold uppercase tracking-wide text-zinc-600 dark:text-zinc-400'">
                                                {{ $style['label'] }}
                                            </span>
                                            <span x-show="selected === @js($value)" class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full {{ $style['dot'] }}"></span>
                                        </button>
                                    @endforeach
                                </div>
                                @error('color') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- STEP 2 --}}
                        <div x-show="$wire.wizardStep === 2" x-transition.opacity>
                            @if($existing_file && count($existing_file) > 0)
                            <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5 mb-5">
                                <div class="flex items-center gap-2.5 mb-4">
                                    <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center">
                                        <flux:icon name="paper-clip" class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">Current Attachments ({{ count($existing_file) }})</h3>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Click × to remove</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2">
                                    @foreach($existing_file as $index => $file)
                                    @php
                                        $isImage = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
                                        $fileUrl = Storage::url($file);
                                    @endphp
                                    <div class="relative group">
                                        @if($isImage)
                                            <a href="{{ $fileUrl }}" target="_blank" rel="noopener noreferrer"
                                               class="block aspect-square rounded-xl overflow-hidden bg-zinc-100 dark:bg-zinc-800 border-2 border-zinc-200 dark:border-zinc-700 hover:border-blue-500 transition-all">
                                                <img src="{{ $fileUrl }}" class="w-full h-full object-cover" alt="attachment">
                                            </a>
                                        @else
                                            <a href="{{ $fileUrl }}" target="_blank" rel="noopener noreferrer"
                                               class="aspect-square rounded-xl bg-zinc-100 dark:bg-zinc-800 border-2 border-zinc-200 dark:border-zinc-700 flex flex-col items-center justify-center hover:border-blue-500 transition-all">
                                                <flux:icon name="document" class="w-8 h-8 text-zinc-400" />
                                                <span class="text-[10px] text-zinc-500 mt-1 truncate px-1 w-full text-center">{{ basename($file) }}</span>
                                            </a>
                                        @endif
                                        <button type="button" wire:click="removeFile({{ $index }})"
                                                class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs font-bold shadow-lg ring-2 ring-white dark:ring-zinc-900 hover:bg-red-600 hover:scale-110 active:scale-95 transition-all">
                                            ×
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-5">
                                <div class="flex items-center gap-2.5 mb-4">
                                    <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center">
                                        <flux:icon name="cloud-arrow-up" class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">Upload New Files</h3>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">JPG, PNG, PDF, DOC, XLSX — max 10MB</p>
                                    </div>
                                </div>

                                <div class="border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-xl p-6 text-center hover:border-blue-500 transition-all bg-white dark:bg-zinc-900">
                                    <input type="file" wire:model="new_files" multiple class="hidden" accept="image/*,.pdf,.doc,.docx,.xlsx" id="eventFileInput">
                                    <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                                        <flux:icon name="arrow-up-tray" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                                    </div>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-3">Drag & drop or click to browse</p>
                                    <label for="eventFileInput"
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold cursor-pointer transition-all shadow-sm">
                                        <flux:icon name="folder-open" class="w-4 h-4" /> Browse Files
                                    </label>
                                </div>

                                <div wire:loading wire:target="new_files" class="mt-2 text-xs text-blue-600 font-medium">Uploading...</div>

                                @if($new_files && count($new_files) > 0)
                                <div class="mt-4">
                                    <label class="block text-xs font-semibold mb-2 text-zinc-700 dark:text-zinc-300">New Files ({{ count($new_files) }})</label>
                                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2">
                                        @foreach($new_files as $file)
                                        @php
                                            $isImage = str_contains($file->getMimeType(), 'image');
                                            $previewUrl = $isImage ? $file->temporaryUrl() : null;
                                        @endphp
                                        <div class="aspect-square rounded-xl overflow-hidden bg-zinc-100 dark:bg-zinc-800 border-2 border-zinc-200 dark:border-zinc-700 flex flex-col items-center justify-center">
                                            @if($isImage)
                                                <img src="{{ $previewUrl }}" class="w-full h-full object-cover cursor-pointer" alt="preview" onclick="window.open('{{ $previewUrl }}', '_blank')">
                                            @else
                                                <flux:icon name="document" class="w-8 h-8 text-zinc-400" />
                                                <span class="text-[10px] text-zinc-500 mt-1 truncate px-1 w-full text-center">{{ $file->getClientOriginalName() }}</span>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @error('new_files.*') <span class="text-red-500 text-xs block mt-2">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- STEP 3 --}}
                        <div x-show="$wire.wizardStep === 3" x-transition.opacity>
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-5 border border-blue-200 dark:border-blue-900/40">
                                <div class="flex items-center gap-2.5 mb-4">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                                        <flux:icon name="check-badge" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-100 uppercase tracking-wide">Event Summary</h3>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Review before saving</p>
                                    </div>
                                </div>
                                <div class="space-y-3 text-sm">
                                    <div class="flex flex-wrap gap-2">
                                        <span class="font-semibold text-zinc-500 dark:text-zinc-400 w-24 text-xs uppercase">Title</span>
                                        <span class="text-zinc-900 dark:text-white">{{ $title ?: '-' }}</span>
                                    </div>
                                    <div class="flex flex-wrap gap-2 items-center">
                                        <span class="font-semibold text-zinc-500 dark:text-zinc-400 w-24 text-xs uppercase">Type</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold
                                            {{ $type == 'Abnormality' ? 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300' :
                                            ($type == 'Project' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' :
                                            ($type == 'Daily Measurement' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300' :
                                            'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300')) }}">
                                            {{ $type }}
                                        </span>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <span class="font-semibold text-zinc-500 dark:text-zinc-400 w-24 text-xs uppercase">Description</span>
                                        <span class="text-zinc-900 dark:text-white">{{ $description ?: '-' }}</span>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <span class="font-semibold text-zinc-500 dark:text-zinc-400 w-24 text-xs uppercase">Start</span>
                                        <span class="text-zinc-900 dark:text-white">{{ $start_date }} {{ $start_time }}</span>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <span class="font-semibold text-zinc-500 dark:text-zinc-400 w-24 text-xs uppercase">End</span>
                                        <span class="text-zinc-900 dark:text-white">{{ $end_date }} {{ $end_time }}</span>
                                    </div>
                                    <div class="flex flex-wrap gap-2 items-center">
                                        <span class="font-semibold text-zinc-500 dark:text-zinc-400 w-24 text-xs uppercase">Status</span>
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-xs font-bold
                                            {{ $color == 'red' ? 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300' :
                                            ($color == 'yellow' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300' :
                                            'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300') }}">
                                            <span class="w-2 h-2 rounded-full {{ $color == 'red' ? 'bg-red-500' : ($color == 'yellow' ? 'bg-yellow-500' : 'bg-green-500') }}"></span>
                                            {{ $color == 'red' ? 'Open' : ($color == 'yellow' ? 'On Progress' : 'Closed') }}
                                        </span>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <span class="font-semibold text-zinc-500 dark:text-zinc-400 w-24 text-xs uppercase">Attachments</span>
                                        <span class="text-zinc-900 dark:text-white">{{ count($existing_file) + count($new_files) }} file(s)</span>
                                    </div>
                                </div>
                            </div>

                            @if($errors->any())
                            <div class="mt-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                                <p class="text-red-600 dark:text-red-400 text-sm font-bold mb-2 flex items-center gap-1.5">
                                    <flux:icon name="exclamation-triangle" class="w-4 h-4" /> Please fix the following:
                                </p>
                                <ul class="list-disc list-inside text-xs text-red-500 space-y-1">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>

                    </form>
                </div>

                {{-- FOOTER --}}
                <div class="sticky bottom-0 bg-white dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-700 px-6 py-4 flex items-center justify-between shadow-[0_-4px_12px_rgba(0,0,0,0.05)]">
                    <div>
                        @if($wizardStep > 1)
                        <button type="button" wire:click="previousStep"
                                class="inline-flex items-center gap-2 px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors text-sm font-medium text-zinc-700 dark:text-zinc-300">
                            <flux:icon name="arrow-left" class="w-4 h-4" /> Back
                        </button>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 ml-auto">
                        <button type="button" wire:click="closeFormModal"
                                class="inline-flex items-center gap-2 px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors text-sm font-medium text-zinc-700 dark:text-zinc-300">
                            <flux:icon name="x-mark" class="w-4 h-4" /> Cancel
                        </button>
                        @if($wizardStep < 3)
                        <button type="button" wire:click="nextStep"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-zinc-800 hover:bg-zinc-900 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-white rounded-xl transition-all text-sm font-semibold shadow-lg">
                            Next <flux:icon name="arrow-right" class="w-4 h-4" />
                        </button>
                        @endif
                        <button type="submit" form="event-form" wire:loading.attr="disabled"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl transition-all text-sm font-semibold shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50 disabled:opacity-50">
                            <flux:icon name="{{ $event_id ? 'check' : 'plus' }}" class="w-4 h-4" />
                            <span wire:loading.remove wire:target="save">{{ $event_id ? 'Update Event' : 'Create Event' }}</span>
                            <span wire:loading wire:target="save">Saving...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================ -->
    <!-- MODAL DELETE EVENT            -->
    <!-- ============================ -->
    <div x-data="{ open: false }"
         x-show="open"
         @open-event-delete-modal.window="open = true"
         @close-event-delete-modal.window="open = false"
         x-cloak>

        <div class="fixed inset-0 bg-zinc-900/60 backdrop-blur-sm z-40" x-transition.opacity @click="open = false; $wire.closeDeleteModal()"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-zinc-200 dark:border-zinc-800"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">

                <div class="bg-gradient-to-r from-red-600 via-rose-600 to-pink-600 px-6 py-4 flex items-center gap-3 shadow-lg">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center ring-2 ring-white/30">
                        <flux:icon name="exclamation-triangle" class="w-5 h-5 text-white" />
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white leading-tight">Delete Event</h2>
                        <p class="text-xs text-red-100 mt-0.5">This action cannot be undone</p>
                    </div>
                </div>

                <div class="px-6 py-6 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                        <flux:icon name="trash" class="w-8 h-8 text-red-600 dark:text-red-400" />
                    </div>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        Are you sure you want to delete event<br>
                        <span class="font-bold text-zinc-900 dark:text-white">"{{ $eventToDelete?->title }}"</span>?
                    </p>
                </div>

                <div class="bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 px-6 py-4 flex items-center justify-end gap-2">
                    <button type="button" wire:click="closeDeleteModal"
                            class="inline-flex items-center gap-2 px-5 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        <flux:icon name="x-mark" class="w-4 h-4" /> Cancel
                    </button>
                    <button type="button" wire:click="delete" wire:loading.attr="disabled"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white rounded-xl transition-all text-sm font-semibold shadow-lg shadow-red-600/30 hover:shadow-red-600/50 disabled:opacity-50">
                        <flux:icon name="trash" class="w-4 h-4" />
                        <span wire:loading.remove wire:target="delete">Yes, Delete</span>
                        <span wire:loading wire:target="delete">Deleting...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================ -->
    <!-- MODAL PREVIEW ATTACHMENT      -->
    <!-- ============================ -->
    <div x-data="{ open: false }"
         x-show="open"
         @open-event-preview-modal.window="open = true"
         @close-event-preview-modal.window="open = false"
         x-cloak>

        <div class="fixed inset-0 bg-zinc-900/70 backdrop-blur-sm z-40" x-transition.opacity @click="open = false; $wire.closePreviewModal()"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[92vh] flex flex-col overflow-hidden border border-zinc-200 dark:border-zinc-800"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">

                <div class="sticky top-0 z-10 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 px-6 py-4 flex items-center justify-between shadow-lg">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center ring-2 ring-white/30 flex-shrink-0">
                            <flux:icon name="photo" class="w-5 h-5 text-white" />
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-lg font-bold text-white leading-tight truncate">{{ $previewEventTitle }}</h2>
                            <p class="text-xs text-indigo-100 mt-0.5 truncate">
                                {{ $this->previewFileName }}
                                @if(count($previewFiles) > 1)
                                    <span class="ml-1 px-1.5 py-0.5 rounded bg-white/20 font-bold">{{ $previewActiveIndex + 1 }}/{{ count($previewFiles) }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <button type="button" wire:click="closePreviewModal"
                            class="w-9 h-9 rounded-lg bg-white/10 hover:bg-white/25 flex items-center justify-center text-white transition-colors flex-shrink-0">
                        <flux:icon name="x-mark" class="w-5 h-5" />
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-6">
                    <div class="relative flex items-center justify-center bg-gradient-to-br from-zinc-100 to-zinc-50 dark:from-zinc-800 dark:to-zinc-900 rounded-2xl min-h-[300px] max-h-[65vh] overflow-hidden border border-zinc-200 dark:border-zinc-700">
                        @if(count($previewFiles) > 1)
                            <button wire:click="setPreviewIndex({{ max($previewActiveIndex - 1, 0) }})"
                                    @disabled($previewActiveIndex === 0)
                                    class="absolute left-3 top-1/2 -translate-y-1/2 z-10 w-11 h-11 rounded-full bg-white/95 dark:bg-zinc-800/95 text-zinc-700 dark:text-zinc-200 shadow-xl hover:bg-white hover:scale-110 transition-all disabled:opacity-30 disabled:hover:scale-100 flex items-center justify-center">
                                <flux:icon name="chevron-left" class="w-5 h-5" />
                            </button>
                            <button wire:click="setPreviewIndex({{ min($previewActiveIndex + 1, count($previewFiles) - 1) }})"
                                    @disabled($previewActiveIndex === count($previewFiles) - 1)
                                    class="absolute right-3 top-1/2 -translate-y-1/2 z-10 w-11 h-11 rounded-full bg-white/95 dark:bg-zinc-800/95 text-zinc-700 dark:text-zinc-200 shadow-xl hover:bg-white hover:scale-110 transition-all disabled:opacity-30 disabled:hover:scale-100 flex items-center justify-center">
                                <flux:icon name="chevron-right" class="w-5 h-5" />
                            </button>
                        @endif

                        @if($this->previewIsImage)
                            <img src="{{ $this->previewFileUrl }}" alt="preview"
                                 class="max-h-[63vh] max-w-full object-contain rounded-xl shadow-lg"
                                 onerror="this.src='{{ asset('storage/default-image.png') }}'; this.onerror=null;">
                        @elseif(preg_match('/\.pdf$/i', $this->previewFileName))
                            <iframe src="{{ $this->previewFileUrl }}" class="w-full h-[60vh] rounded-xl" frameborder="0"></iframe>
                        @else
                            <div class="flex flex-col items-center justify-center p-10 text-center">
                                <div class="w-20 h-20 rounded-2xl bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center mb-4">
                                    <flux:icon name="document" class="w-10 h-10 text-zinc-500" />
                                </div>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4 font-medium">Preview not available for this file type</p>
                                <a href="{{ $this->previewFileUrl }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-all shadow-lg">
                                    <flux:icon name="arrow-down-tray" class="w-4 h-4" /> Download / Open
                                </a>
                            </div>
                        @endif
                    </div>

                    @if(count($previewFiles) > 1)
                    <div class="mt-4 flex gap-2 overflow-x-auto pb-1">
                        @foreach($previewFiles as $i => $file)
                            @php
                                $thumbIsImage = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
                                $thumbUrl = Storage::url($file);
                            @endphp
                            <button wire:click="setPreviewIndex({{ $i }})"
                                    class="flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden border-2 transition-all
                                        {{ $previewActiveIndex === $i ? 'border-indigo-600 ring-2 ring-indigo-300 scale-105 shadow-lg' : 'border-zinc-200 dark:border-zinc-700 opacity-60 hover:opacity-100 hover:border-indigo-400' }}">
                                @if($thumbIsImage)
                                    <img src="{{ $thumbUrl }}" class="w-full h-full object-cover" alt="thumb">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-zinc-100 dark:bg-zinc-800">
                                        <flux:icon name="document" class="w-5 h-5 text-zinc-400" />
                                    </div>
                                @endif
                            </button>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="sticky bottom-0 bg-white dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-700 px-6 py-4 flex items-center justify-end gap-2 shadow-[0_-4px_12px_rgba(0,0,0,0.05)]">
                    <a href="{{ $this->previewFileUrl }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 px-4 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        <flux:icon name="arrow-top-right-on-square" class="w-4 h-4" /> Open in new tab
                    </a>
                    <button type="button" wire:click="closePreviewModal"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl transition-all text-sm font-semibold shadow-lg shadow-indigo-600/30">
                        <flux:icon name="x-mark" class="w-4 h-4" /> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    <div x-data="{ show: false, message: '', type: 'success' }"
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
         x-show="show"
         x-transition.duration.300ms
         class="fixed bottom-3 right-3 sm:bottom-4 sm:right-4 z-50"
         :class="{
             'bg-green-500': type === 'success',
             'bg-red-500': type === 'error',
             'bg-yellow-500': type === 'warning'
         }"
         style="display: none;">
        <div class="text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg shadow-lg text-xs sm:text-sm">
            <span x-text="message"></span>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>