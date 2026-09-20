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
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Setup soal blind test untuk employee</p>
        </div>

        @can('create blind test')
            <flux:button variant="primary" icon="plus" class="bg-blue-600 hover:bg-blue-700"
                wire:click="resetForm" x-on:click="$dispatch('open-modal-blind-test')">
                Add New Blind Test
            </flux:button>
        @endcan
    </div>

    <flux:card class="p-4 shadow-sm">
        <div class="space-y-3">

            {{-- Row 1: Search + Reset --}}
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <flux:input wire:model.live.debounce.300ms="search"
                        placeholder="Search NIK, Name, Customer, Model..." icon="magnifying-glass" clearable />
                </div>
                @if($search || $filterDepartment || $filterShift || $filterGroup || $filterCustomer || $filterModel || $filterResult)
                    <flux:button wire:click="resetFilters" variant="danger" color="red" icon="arrow-path"
                        class="whitespace-nowrap bg-red-600 hover:bg-red-700 text-white">
                        Reset Filter
                    </flux:button>
                @endif
            </div>

            {{-- Row 2: Filters (NATIVE SELECT) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-3">

                {{-- Department --}}
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

                {{-- Shift --}}
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

                {{-- Group --}}
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

                {{-- Customer --}}
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

                {{-- Model --}}
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 uppercase mb-1">
                        Model @if(!$filterCustomer) <span class="text-amber-500 normal-case">(pilih customer)</span> @endif
                    </label>
                    <select wire:model.live="filterModel"
                        class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500 disabled:opacity-50"
                        @if(!$filterCustomer) disabled @endif>
                        <option value="">All Model</option>
                        @if($filterCustomer)
                            @foreach($allModels as $m)
                                @if($m->customer_id == $filterCustomer)
                                    <option value="{{ $m->id }}">{{ $m->model_name }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>

                {{-- Result --}}
                <div>
                    <label class="block text-[11px] font-semibold text-zinc-500 uppercase mb-1">Result</label>
                    <select wire:model.live="filterResult"
                        class="w-full border border-zinc-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">All Result</option>
                        <option value="PASS">PASS</option>
                        <option value="FAIL">FAIL</option>
                    </select>
                </div>
            </div>
        </div>
    </flux:card>

    <!-- ==================== TABS ==================== -->
    <div class="border-b border-zinc-200 dark:border-zinc-700 pb-4">
        <div class="overflow-x-auto scrollbar-hide">
            <div class="flex justify-center min-w-full w-max">
                <div class="flex flex-nowrap gap-2 px-1">

                    {{-- All --}}
                    <button wire:click="setTab('all')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap rounded-lg {{ $activeTab === 'all' ? 'bg-blue-600 text-white shadow-md hover:bg-blue-700' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        All
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'all' ? 'bg-white/20 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400' }}">
                            {{ $tabCounts['all'] ?? 0 }}
                        </span>
                    </button>

                    {{-- Open --}}
                    <button wire:click="setTab('open')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap rounded-lg {{ $activeTab === 'open' ? 'bg-yellow-500 text-white shadow-md hover:bg-yellow-600' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Open
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'open' ? 'bg-white/20 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400' }}">
                            {{ $tabCounts['open'] ?? 0 }}
                        </span>
                    </button>

                    {{-- In Progress --}}
                    <button wire:click="setTab('in_progress')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap rounded-lg {{ $activeTab === 'in_progress' ? 'bg-blue-600 text-white shadow-md hover:bg-blue-700' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        In Progress
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'in_progress' ? 'bg-white/20 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400' }}">
                            {{ $tabCounts['in_progress'] ?? 0 }}
                        </span>
                    </button>

                    {{-- Closed --}}
                    <button wire:click="setTab('closed')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap rounded-lg {{ $activeTab === 'closed' ? 'bg-green-600 text-white shadow-md hover:bg-green-700' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Closed
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'closed' ? 'bg-white/20 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400' }}">
                            {{ $tabCounts['closed'] ?? 0 }}
                        </span>
                    </button>

                    {{-- Deleted --}}
                    <button wire:click="setTab('deleted')"
                        class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap rounded-lg {{ $activeTab === 'deleted' ? 'bg-zinc-600 text-white shadow-md hover:bg-zinc-700' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}">
                        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Deleted
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'deleted' ? 'bg-white/20 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400' }}">
                            {{ $tabCounts['deleted'] ?? 0 }}
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== TABLE ==================== -->
    <flux:card class="p-6 h-full shadow-lg flex flex-col">
        <div class="overflow-x-auto flex-1">
            <table class="w-full" style="min-width: 1450px; white-space: nowrap;">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase">#</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase">NIK</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase">Department</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase">Shift | Group</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase">Customer | Model</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase">Deadline</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase">Result</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($blindTests as $index => $bt)
                    @php
                        $isExpired = $bt->isExpired();
                        $isTrashed = $bt->trashed();
                    @endphp
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 {{ $isTrashed ? 'opacity-60' : '' }}" wire:key="bt-{{ $bt->id }}">
                        <td class="px-4 py-3 text-sm text-center">{{ $blindTests->firstItem() + $index }}</td>
                        <td class="px-4 py-3 text-sm text-center font-semibold">{{ $bt->employee->nik ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm">{{ $bt->employee->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm">{{ $bt->employee->department ?? '-' }}</td>

                        {{-- Kolom Shift | Group --}}
                        <td class="px-4 py-3 text-center">
                            <div class="inline-flex items-center gap-1.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold">
                                    {{ $bt->shift ?? '-' }}
                                </span>
                                <span class="text-zinc-400 text-xs">|</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-xs font-semibold">
                                    {{ $bt->group ?? '-' }}
                                </span>
                            </div>
                        </td>

                        {{-- Kolom Customer | Model --}}
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">
                                    {{ $bt->customer->customer_name ?? '-' }}
                                </span>
                                <span class="text-zinc-400">|</span>
                                <span class="text-zinc-600 dark:text-zinc-400">
                                    {{ $bt->model->model_name ?? '-' }}
                                </span>
                            </div>
                        </td>

                        {{-- Kolom Deadline --}}
                        <td class="px-4 py-3 text-center">
                            @if($bt->time_test)
                                @if($bt->status === 'completed')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 text-xs font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $bt->time_test->format('H:i') }}
                                    </span>
                                @elseif($isExpired)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-xs font-bold border border-red-300 dark:border-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $bt->time_test->format('H:i') }}
                                    </span>
                                    <div class="text-[10px] text-red-600 dark:text-red-400 font-bold mt-0.5 uppercase">Expired</div>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-cyan-100 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-300 text-xs font-semibold border border-cyan-300 dark:border-cyan-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $bt->time_test->format('H:i') }}
                                    </span>
                                @endif
                            @else
                                <span class="text-xs text-zinc-400">-</span>
                            @endif

                            @if($bt->duration_minutes)
                                <div class="text-[10px] text-zinc-500 mt-0.5">{{ $bt->duration_minutes }} minutes</div>
                            @endif
                        </td>

                        {{-- Kolom Status --}}
                        <td class="px-4 py-3 text-center">
                            @if($isTrashed)
                                <flux:badge size="sm" color="zinc">
                                    Deleted
                                </flux:badge>
                            @else
                                @php
                                    $sc = ['pending' => 'yellow', 'in_progress' => 'blue', 'completed' => 'green'];
                                @endphp
                                <flux:badge size="sm" color="{{ $sc[$bt->status] ?? 'gray' }}">
                                    {{ ucfirst(str_replace('_', ' ', $bt->status)) }}
                                </flux:badge>
                            @endif
                        </td>

                        {{-- Kolom Result --}}
                        <td class="px-4 py-3 text-center">
                            @if($bt->overall_result)
                                <flux:badge size="sm" color="{{ $bt->overall_result === 'PASS' ? 'green' : 'red' }}">
                                    {{ $bt->overall_result }}
                                </flux:badge>
                                <div class="text-xs text-zinc-500 mt-1">{{ $bt->total_correct }}/{{ $bt->total_items }}</div>
                            @else
                                <span class="text-xs text-zinc-400">-</span>
                            @endif
                        </td>

                        {{-- Kolom Actions --}}
                        <td class="px-4 py-3 text-center">
                            @if($isTrashed)
                                {{-- Deleted: tampilkan alasan + tombol View --}}
                                <div class="flex flex-col items-center gap-1">
                                    <flux:tooltip content="View Detail" position="top">
                                        <flux:button
                                            size="sm"
                                            icon="eye"
                                            variant="primary"
                                            color="zinc"
                                            class="!p-2"
                                            wire:click="view({{ $bt->id }})"
                                        />
                                    </flux:tooltip>
                                    @if($bt->deleted_reason)
                                        <div class="text-[10px] text-zinc-500 dark:text-zinc-400 italic max-w-[180px] truncate"
                                            title="{{ $bt->deleted_reason }}">
                                            Reason : {{ $bt->deleted_reason }}
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="flex items-center justify-center gap-1 flex-wrap">

                                    @can('execute blind test')
                                        @if($bt->status === 'completed')
                                            {{-- View Result --}}
                                            <flux:tooltip content="View Result" position="top">
                                                <a href="{{ route('qaqc.blind-test.execute', $bt->id) }}">
                                                    <flux:button size="sm" icon="eye" variant="primary" color="black" class="!p-2" />
                                                </a>
                                            </flux:tooltip>
                                        @elseif(!$isExpired)
                                            {{-- Start Test --}}
                                            <flux:tooltip content="Start Test" position="top">
                                                <a href="{{ route('qaqc.blind-test.execute', $bt->id) }}">
                                                    <flux:button size="sm" icon="play" variant="primary" color="green" class="!p-2" />
                                                </a>
                                            </flux:tooltip>
                                        @else
                                            {{-- Expired: lock icon --}}
                                            <flux:tooltip content="Expired - Tidak bisa start" position="top">
                                                <div class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 border border-red-300 dark:border-red-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                        <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </flux:tooltip>
                                        @endif
                                    @endcan

                                    {{-- Approve QC --}}
                                    @can('check blind test qc')
                                        @if(!$bt->check_by_qc)
                                            <flux:tooltip content="Approve as Check By QC" position="top">
                                                <flux:button
                                                    size="sm"
                                                    icon="check-circle"
                                                    variant="primary"
                                                    color="blue"
                                                    class="!p-2"
                                                    wire:click="openApprovalModal({{ $bt->id }}, 'qc')"
                                                />
                                            </flux:tooltip>
                                        @endif
                                    @endcan

                                    {{-- Approve Production --}}
                                    @can('check blind test prod')
                                        @if(!$bt->check_by_prod)
                                            <flux:tooltip content="Approve as Check By Production" position="top">
                                                <flux:button
                                                    size="sm"
                                                    icon="check-circle"
                                                    variant="primary"
                                                    color="blue"
                                                    class="!p-2"
                                                    wire:click="openApprovalModal({{ $bt->id }}, 'prod')"
                                                />
                                            </flux:tooltip>
                                        @endif
                                    @endcan

                                    {{-- Acknowledge SPV --}}
                                    @can('acknowledge blind test spv')
                                        @if(!$bt->acknowledge_by_spv)
                                            <flux:tooltip content="Acknowledge as SPV" position="top">
                                                <flux:button
                                                    size="sm"
                                                    icon="check-circle"
                                                    variant="primary"
                                                    color="blue"
                                                    class="!p-2"
                                                    wire:click="openApprovalModal({{ $bt->id }}, 'spv')"
                                                />
                                            </flux:tooltip>
                                        @endif
                                    @endcan

                                    {{-- Acknowledge QC SPV --}}
                                    @can('acknowledge blind test qc spv')
                                        @if(!$bt->acknowledge_qc_spv)
                                            <flux:tooltip content="Acknowledge as QC SPV" position="top">
                                                <flux:button
                                                    size="sm"
                                                    icon="check-circle"
                                                    variant="primary"
                                                    color="blue"
                                                    class="!p-2"
                                                    wire:click="openApprovalModal({{ $bt->id }}, 'qc_spv')"
                                                />
                                            </flux:tooltip>
                                        @endif
                                    @endcan

                                    {{-- Edit — hanya kalau pending --}}
                                    @can('edit blind test')
                                        @if($bt->status === 'pending')
                                            <flux:tooltip content="Edit" position="top">
                                                <flux:button
                                                    size="sm"
                                                    icon="pencil-square"
                                                    variant="primary"
                                                    color="amber"
                                                    class="!p-2"
                                                    wire:click="edit({{ $bt->id }})"
                                                />
                                            </flux:tooltip>
                                        @endif
                                    @endcan

                                    {{-- Delete — hanya kalau pending --}}
                                    @can('delete blind test')
                                        @if($bt->status === 'pending')
                                            <flux:tooltip content="Delete" position="top">
                                                <flux:button
                                                    size="sm"
                                                    icon="trash"
                                                    variant="danger"
                                                    color="red"
                                                    class="!p-2"
                                                    wire:click="confirmDelete({{ $bt->id }})"
                                                />
                                            </flux:tooltip>
                                        @endif
                                    @endcan

                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-4 py-8 text-center">
                            <div class="flex flex-col items-center gap-2 py-6">
                                <flux:icon name="clipboard-document-check" class="w-10 h-10 text-zinc-400" />
                                <h3 class="text-base font-medium text-zinc-900 dark:text-white">No blind test records found</h3>
                                <p class="text-sm text-zinc-500">
                                    @if($search || $filterDepartment || $filterShift || $filterGroup || $filterCustomer || $filterModel || $filterResult)
                                        Try adjusting your search or filters
                                    @else
                                        Get started by creating a new blind test
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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

                <div class="relative overflow-hidden bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-5 flex items-center gap-3">
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
                            class="px-4 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 text-sm font-medium transition-colors">
                            Cancel
                        </button>
                        <button wire:click="approve"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors shadow-lg shadow-green-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                            </svg>
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
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden">

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
                            <p class="text-xs text-blue-100">Setup soal dan kunci jawaban blind test</p>
                        </div>
                    </div>
                    <button type="button" @click="open = false"
                        class="w-9 h-9 rounded-lg bg-white/20 hover:bg-white/30 backdrop-blur-sm border border-white/30 text-white flex items-center justify-center transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="flex-1 overflow-y-auto p-6 bg-zinc-50 dark:bg-zinc-950/30">
                    <form wire:submit="save" id="blind-test-form" class="space-y-4">

                        <!-- Card 1: Employee -->
                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                            <div class="px-5 py-3.5 border-b border-zinc-200 dark:border-zinc-800 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/20 dark:to-indigo-950/20 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-500 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-white">
                                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-zinc-800 dark:text-white">Employee Information</h3>
                            </div>
                            <div class="p-5">
                                @if($employee_id)
                                    <div class="mb-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-950/20 dark:to-emerald-950/20 border border-green-200 dark:border-green-800 rounded-xl flex justify-between items-center">
                                        <div class="flex items-center gap-3">
                                            <div class="w-11 h-11 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white text-sm font-bold">
                                                {{ strtoupper(substr($employee_name ?? 'N', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="text-[10px] text-green-700 dark:text-green-400 font-semibold uppercase tracking-wider">Selected Employee</div>
                                                <div class="text-sm font-semibold text-green-800 dark:text-green-300">
                                                    {{ $employee_nik }} - {{ $employee_name }}
                                                </div>
                                                <div class="text-xs text-green-600 dark:text-green-400">{{ $employee_department }}</div>
                                            </div>
                                        </div>
                                        <button type="button" wire:click="clearEmployee"
                                            class="w-9 h-9 rounded-lg bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400 flex items-center justify-center transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                                <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                @else
                                    <div x-data="{
                                        search: '', employees: [], loading: false, timeout: null,
                                        load() {
                                            if (this.search.length < 2) { this.employees = []; return; }
                                            clearTimeout(this.timeout);
                                            this.timeout = setTimeout(() => {
                                                this.loading = true;
                                                @this.call('searchEmployees', this.search).then(result => {
                                                    this.employees = result; this.loading = false;
                                                }).catch(() => { this.loading = false; });
                                            }, 300);
                                        },
                                        select(emp) { $wire.selectEmployee(emp.id); this.employees = []; this.search = ''; }
                                    }">
                                        <flux:label required>Search Employee</flux:label>
                                        <div class="relative">
                                            <input type="text" x-model="search" @input="load()"
                                                placeholder="Search by NIK or name (min 2 characters)..."
                                                class="w-full pl-10 pr-3 py-2.5 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:text-white text-sm">
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
                                                        <th class="px-3 py-2 text-center text-xs font-semibold text-zinc-600 dark:text-zinc-400">NIK</th>
                                                        <th class="px-3 py-2 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400">NAME</th>
                                                        <th class="px-3 py-2 text-center text-xs font-semibold text-zinc-600 dark:text-zinc-400">DEPT</th>
                                                        <th class="px-3 py-2 text-center text-xs font-semibold text-zinc-600 dark:text-zinc-400 w-20"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                                    <template x-for="emp in employees" :key="emp.id">
                                                        <tr class="hover:bg-blue-50 dark:hover:bg-blue-950/10">
                                                            <td class="px-3 py-2 text-center font-mono text-xs" x-text="emp.nik"></td>
                                                            <td class="px-3 py-2 text-sm font-medium" x-text="emp.name"></td>
                                                            <td class="px-3 py-2 text-center text-xs" x-text="emp.department"></td>
                                                            <td class="px-3 py-2 text-center">
                                                                <button type="button" @click="select(emp)"
                                                                    class="px-2.5 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition-colors">
                                                                    Select
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                                @error('employee_id') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror

                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <flux:label required>Shift</flux:label>
                                        <flux:select wire:model="shift" placeholder="Select shift...">
                                            <flux:select.option value="NS">NS</flux:select.option>
                                            <flux:select.option value="1">1</flux:select.option>
                                            <flux:select.option value="2">2</flux:select.option>
                                            <flux:select.option value="3">3</flux:select.option>
                                        </flux:select>
                                        @error('shift') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <flux:label required>Group</flux:label>
                                        <flux:select wire:model="group" placeholder="Select group...">
                                            <flux:select.option value="NS">NS</flux:select.option>
                                            <flux:select.option value="A">A</flux:select.option>
                                            <flux:select.option value="B">B</flux:select.option>
                                            <flux:select.option value="C">C</flux:select.option>
                                        </flux:select>
                                        @error('group') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Customer & Model -->
                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                            <div class="px-5 py-3.5 border-b border-zinc-200 dark:border-zinc-800 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-950/20 dark:to-teal-950/20 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-white">
                                        <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                                        <path fill-rule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-zinc-800 dark:text-white">Customer & Model</h3>
                            </div>
                            <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <flux:label required>Customer</flux:label>
                                    <flux:select wire:model.live="customer_id" placeholder="Select customer...">
                                        @foreach($customers as $customer)
                                            <flux:select.option value="{{ $customer->id }}">{{ $customer->customer_name }}</flux:select.option>
                                        @endforeach
                                    </flux:select>
                                    @error('customer_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <flux:label required>Model</flux:label>
                                    <flux:select wire:model="model_id" placeholder="Select model...">
                                        @foreach($allModels as $model)
                                            @if($model->customer_id == $customer_id)
                                                <flux:select.option value="{{ $model->id }}">{{ $model->model_name }}</flux:select.option>
                                            @endif
                                        @endforeach
                                    </flux:select>
                                    @error('model_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: Blind Test Items -->
                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                            <div class="px-5 py-3.5 border-b border-zinc-200 dark:border-zinc-800 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-950/20 dark:to-orange-950/20 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-amber-500 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-white">
                                            <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-zinc-800 dark:text-white">Test Items (Kunci Jawaban)</h3>
                                </div>
                                <button type="button" wire:click="addItem"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                        <path d="M12 5.25a.75.75 0 0 1 .75.75v5.25H18a.75.75 0 0 1 0 1.5h-5.25V18a.75.75 0 0 1-1.5 0v-5.25H6a.75.75 0 0 1 0-1.5h5.25V6a.75.75 0 0 1 .75-.75Z" />
                                    </svg>
                                    Add Item
                                </button>
                            </div>
                            <div class="p-5">
                                <div class="overflow-x-auto">
                                    <table class="w-full border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                                        <thead class="bg-zinc-50 dark:bg-zinc-800">
                                            <tr>
                                                <th class="px-3 py-2.5 text-center text-[11px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase w-12">#</th>
                                                <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase">Defect Item</th>
                                                <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase">Component Location</th>
                                                <th class="px-3 py-2.5 text-center text-[11px] font-semibold text-zinc-600 dark:text-zinc-400 uppercase w-16">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                            @foreach($blind_test_items as $index => $item)
                                            <tr wire:key="item-{{ $index }}" class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                                <td class="px-3 py-2.5 text-center">
                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-[10px] font-bold">
                                                        {{ $index + 1 }}
                                                    </span>
                                                </td>
                                                <td class="px-3 py-2.5">
                                                    <flux:select wire:model="blind_test_items.{{ $index }}.deffect_item_id" placeholder="Select deffect...">
                                                        @foreach($deffects as $deffect)
                                                            <flux:select.option value="{{ $deffect->id }}">{{ $deffect->deffect_item_name }}</flux:select.option>
                                                        @endforeach
                                                    </flux:select>
                                                    @error("blind_test_items.{$index}.deffect_item_id") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </td>
                                                <td class="px-3 py-2.5">
                                                    <flux:input wire:model="blind_test_items.{{ $index }}.component_location"
                                                        type="text" placeholder="e.g. CN4" class="uppercase" />
                                                    @error("blind_test_items.{$index}.component_location") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </td>
                                                <td class="px-3 py-2.5 text-center">
                                                    @if(count($blind_test_items) > 1)
                                                    <button type="button" wire:click="removeItem({{ $index }})"
                                                        class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-red-100 hover:bg-red-600 text-red-600 hover:text-white dark:bg-red-900/30 dark:text-red-400 transition-all">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3 flex items-start gap-2 p-3 bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5">
                                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-xs text-amber-800 dark:text-amber-300">
                                        <strong>Info:</strong> Kunci jawaban = pasangan Deffect Item + Component Location. Urutan bebas.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Card 4: Time & Duration -->
                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                            <div class="px-5 py-3.5 border-b border-zinc-200 dark:border-zinc-800 bg-gradient-to-r from-rose-50 to-pink-50 dark:from-rose-950/20 dark:to-pink-950/20 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-rose-500 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-white">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-zinc-800 dark:text-white">Time & Duration</h3>
                            </div>
                            <div class="p-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <!-- Time Test (Deadline) -->
                                    <div>
                                        <flux:label required>Time Test (Deadline Mulai)</flux:label>
                                        <flux:input wire:model="time_test" type="time" class="w-full" />
                                        @error('time_test') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        <p class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-1">
                                            Batas jam kapan test <strong>harus sudah dimulai</strong>.
                                        </p>
                                    </div>

                                    <!-- Duration Minutes -->
                                    <div>
                                        <flux:label>Duration (Menit)</flux:label>
                                        <flux:input wire:model="duration_minutes" type="number" min="1" max="600"
                                            placeholder="e.g. 30" class="w-full" />
                                        @error('duration_minutes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        <p class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-1">
                                            Batas lama pengerjaan setelah <strong>Start</strong>. Kosongkan = tanpa batas durasi.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 flex justify-end gap-3">
                    <button type="button" @click="open = false"
                        class="px-5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 text-sm font-medium transition-colors">
                        Cancel
                    </button>
                    <button type="submit" form="blind-test-form"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm font-medium transition-colors shadow-lg shadow-blue-500/30"
                        wire:loading.attr="disabled" wire:target="save"
                        @if(!$employee_id) disabled @endif>
                        <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                            </svg>
                            {{ $blind_test_id ? 'Update' : 'Create' }}
                        </span>
                        <span wire:loading wire:target="save" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
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

                <!-- Modal Header -->
                <div class="relative overflow-hidden bg-gradient-to-r from-cyan-600 via-blue-600 to-indigo-600 px-6 py-5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                                <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd" />
                                <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Blind Test Detail</h2>
                            <p class="text-xs text-blue-100">Informasi lengkap blind test</p>
                        </div>
                    </div>
                    <button type="button" @click="open = false"
                        class="w-9 h-9 rounded-lg bg-white/20 hover:bg-white/30 backdrop-blur-sm border border-white/30 text-white flex items-center justify-center transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="flex-1 overflow-y-auto p-6 bg-zinc-50 dark:bg-zinc-950/30">
                    @if($viewData)

                    <!-- Employee Banner -->
                    <div class="relative overflow-hidden bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-5 mb-4 shadow-lg">
                        <div class="relative flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border-2 border-white/40">
                                    <span class="text-xl font-bold text-white">{{ strtoupper(substr($viewData->employee->name ?? 'N', 0, 1)) }}</span>
                                </div>
                                <div>
                                    <div class="text-[10px] text-blue-100 uppercase tracking-wider font-semibold">Employee</div>
                                    <div class="text-lg font-bold text-white">{{ $viewData->employee->name ?? '-' }}</div>
                                    <div class="text-xs text-blue-100 mt-0.5">{{ $viewData->employee->nik ?? '-' }} • {{ $viewData->shift ?? '-' }} • {{ $viewData->group ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                @php $sc = ['pending' => 'yellow', 'in_progress' => 'blue', 'completed' => 'green']; @endphp
                                <div class="text-[10px] text-blue-100 uppercase tracking-wider font-semibold mb-1">Status</div>
                                <flux:badge size="md" color="{{ $viewData->trashed() ? 'zinc' : ($sc[$viewData->status] ?? 'gray') }}">
                                    {{ $viewData->trashed() ? 'Deleted' : ucfirst(str_replace('_', ' ', $viewData->status)) }}
                                </flux:badge>
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

                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                            <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Customer</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->customer->customer_name ?? '-' }}</div>
                        </div>
                        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                            <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Model</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->model->model_name ?? '-' }}</div>
                        </div>
                        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                            <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Time Test</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->time_test ? $viewData->time_test->format('H:i') : '-' }}</div>
                        </div>
                        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                            <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Duration</div>
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
                            <div class="w-8 h-8 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold">Tabel Kunci Jawaban</h3>
                                <p class="text-[11px] text-blue-100">{{ count($viewData->blind_test_items ?? []) }} soal</p>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-blue-50 dark:bg-blue-900/20 border-b border-blue-200 dark:border-blue-800">
                                    <tr>
                                        <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-blue-700 dark:text-blue-300 uppercase w-10">#</th>
                                        <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-blue-700 dark:text-blue-300 uppercase">Deffect Item</th>
                                        <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-blue-700 dark:text-blue-300 uppercase">Location</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                    @foreach($viewData->blind_test_items ?? [] as $i => $item)
                                    @php $deffect = \App\Models\QAQC\BlindTest\Deffect::find($item['deffect_item_id'] ?? null); @endphp
                                    <tr class="hover:bg-blue-50/50 dark:hover:bg-blue-950/10">
                                        <td class="px-3 py-2.5 text-xs">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-semibold text-[10px]">
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
                            <div class="w-8 h-8 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold">Tabel Jawaban User & Hasil</h3>
                                <p class="text-[11px] text-green-100">{{ count($viewData->user_answers) }} baris</p>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-green-50 dark:bg-green-900/20 border-b border-green-200 dark:border-green-800">
                                    <tr>
                                        <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-green-700 dark:text-green-300 uppercase w-10">#</th>
                                        <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-green-700 dark:text-green-300 uppercase">Deffect Item</th>
                                        <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-green-700 dark:text-green-300 uppercase">Location</th>
                                        <th class="px-3 py-2.5 text-center text-[11px] font-semibold text-green-700 dark:text-green-300 uppercase w-32">Hasil</th>
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
                                    <tr class="@if($isCorrect) hover:bg-green-50/50 dark:hover:bg-green-950/10 @elseif($isMissing) bg-yellow-50/50 dark:bg-yellow-950/10 @elseif($isExtra) bg-purple-50/50 dark:bg-purple-950/10 @else bg-red-50/50 dark:bg-red-950/10 @endif">
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
                        <h3 class="text-sm font-bold text-zinc-800 dark:text-white mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-rose-500">
                                <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                            </svg>
                            Signatures
                        </h3>
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

                <!-- Modal Footer -->
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 flex justify-end gap-3">
                    <button type="button" @click="open = false"
                        class="px-5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 text-sm font-medium transition-colors">
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
                    <div class="w-11 h-11 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
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
                            class="px-4 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 text-sm font-medium transition-colors">
                            Cancel
                        </button>
                        <button wire:click="delete"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-colors shadow-lg shadow-red-500/30">
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

    <style>[x-cloak] { display: none !important; }</style>
</div>