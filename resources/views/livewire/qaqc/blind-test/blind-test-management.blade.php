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

    <!-- Filter Card -->
    <flux:card class="p-4 shadow-sm">
        <div class="space-y-3">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <flux:input wire:model.live.debounce.300ms="search"
                        placeholder="Search NIK, Name, Customer, Model..." icon="magnifying-glass" clearable />
                </div>
                @if($search || $filterDepartment || $filterShift || $filterGroup || $filterSection || $filterCustomer || $filterModel || $filterResult)
                    <flux:button wire:click="resetFilters" variant="danger" color="red" icon="arrow-path"
                        class="whitespace-nowrap bg-red-600 hover:bg-red-700 text-white">
                        Reset Filter
                    </flux:button>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-7 gap-3">
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

                {{-- Section --}}
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
                        @foreach($filterModels as $m)
                            <option value="{{ $m->id }}">{{ $m->model_name }}</option>
                        @endforeach
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

    <!-- Table -->
    <flux:card class="p-6 h-full shadow-lg flex flex-col">
        <div class="overflow-x-auto flex-1">
            <table class="w-full" style="min-width: 1500px; white-space: nowrap;">
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
                                {{-- Customer --}}
                                <span class="font-medium text-zinc-800 dark:text-zinc-200">
                                    {{ $bt->customer->customer_name ?? '-' }}
                                </span>

                                {{-- Models (bisa multiple) --}}
                                @php
                                    $modelIds = collect($bt->question_snapshot ?? [])
                                        ->pluck('model_id')
                                        ->filter()
                                        ->unique()
                                        ->values();

                                    if ($modelIds->isEmpty() && $bt->model_id) {
                                        $modelIds = collect([$bt->model_id]);
                                    }

                                    $models = $modelIds->isNotEmpty()
                                        ? \App\Models\QAQC\BlindTest\Model::whereIn('id', $modelIds)->get()
                                        : collect();
                                @endphp

                                @if($models->count() > 0)
                                    <div class="flex flex-wrap items-center justify-center gap-1">
                                        @foreach($models as $m)
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded
                                                text-[10px] font-semibold
                                                {{ $models->count() > 1
                                                    ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300'
                                                    : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300' }}">
                                                {{ $m->model_name }}
                                            </span>
                                        @endforeach
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
                                {{-- Menunggu review QC --}}
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
                                {{-- Final result --}}
                                <flux:badge size="sm" color="{{ $bt->overall_result === 'PASS' ? 'green' : 'red' }}">
                                    {{ $bt->overall_result }}
                                </flux:badge>
                                <div class="text-xs text-zinc-500 mt-1">{{ $bt->total_correct }}/{{ $bt->total_items }}</div>

                                {{-- Info attempt (opsional) --}}
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

                        {{-- ============ ACTIONS / REASON ============ --}}
                        <td class="px-4 py-3 text-center">
                            @if($isTrashed)
                                {{-- Trashed: tampilkan Reason merah, tanpa tombol action --}}
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
                                            <flux:tooltip content="View Result" position="top">
                                                <a href="{{ route('qaqc.blind-test.execute', $bt->id) }}">
                                                    <flux:button size="sm" icon="eye" variant="primary" color="black" class="!p-2" />
                                                </a>
                                            </flux:tooltip>
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

                                    @can('edit blind test')
                                        @if($bt->status === 'pending')
                                            <flux:tooltip content="Edit" position="top">
                                                <flux:button size="sm" icon="pencil-square" variant="primary" color="amber" class="!p-2"
                                                    wire:click="edit({{ $bt->id }})" />
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
                        <td colspan="11" class="px-4 py-8 text-center">
                            <div class="flex flex-col items-center gap-2 py-6">
                                <flux:icon name="clipboard-document-check" class="w-10 h-10 text-zinc-400" />
                                <h3 class="text-base font-medium text-zinc-900 dark:text-white">No blind test records found</h3>
                                <p class="text-sm text-zinc-500">
                                    @if($search || $filterDepartment || $filterShift || $filterGroup || $filterSection || $filterCustomer || $filterModel || $filterResult)
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
                            <p class="text-xs text-blue-100">Setup soal dan employee untuk blind test</p>
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

                        {{-- ================= STEP 1: SECTION ================= --}}
                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                            <div class="px-5 py-3.5 border-b border-zinc-200 dark:border-zinc-800 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center shadow-sm shadow-blue-500/30">
                                    <span class="text-xs font-bold text-white">1</span>
                                </div>
                                <h3 class="text-sm font-bold text-zinc-800 dark:text-white">Pilih Section</h3>
                            </div>
                            <div class="p-5">
                                <flux:label required>Section</flux:label>
                                <flux:select wire:model.live="section" placeholder="Select section...">
                                    @foreach($sections as $sec)
                                        <flux:select.option value="{{ $sec }}">{{ $sec }}</flux:select.option>
                                    @endforeach
                                </flux:select>
                                @error('section') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- ================= STEP 2: EMPLOYEE ================= --}}
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
                                }
                            }"
                            x-on:employee-added.window="resetPick()">

                            <div class="px-5 py-3.5 border-b border-zinc-200 dark:border-zinc-800 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center shadow-sm shadow-blue-500/30">
                                        <span class="text-xs font-bold text-white">2</span>
                                    </div>
                                    <h3 class="text-sm font-bold text-zinc-800 dark:text-white">Pilih Employee</h3>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-semibold">
                                    Total: {{ count($selectedEmployees) }}
                                </span>
                            </div>
                            <div class="p-5 space-y-4">

                                {{-- STEP 2A: SEARCH & PICK EMPLOYEE --}}
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

                                    <!-- Loading -->
                                    <div x-show="loading" class="mt-2 p-3 text-center text-sm bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                                        <svg class="animate-spin h-4 w-4 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>

                                    <!-- Search Result -->
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
                                                    <tr class="hover:bg-blue-50 dark:hover:bg-blue-950/10">
                                                        <td class="px-3 py-2 text-center font-mono text-xs" x-text="emp.nik"></td>
                                                        <td class="px-3 py-2 text-sm font-medium" x-text="emp.name"></td>
                                                        <td class="px-3 py-2 text-center text-xs" x-text="emp.department"></td>
                                                        <td class="px-3 py-2 text-center">
                                                            <button type="button" @click="pick(emp)"
                                                                class="px-2.5 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium">
                                                                Pilih
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- STEP 2B: PREVIEW EMPLOYEE TERPILIH + SHIFT/GROUP --}}
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
                                            @error('tempShift') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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

                                    {{-- Info wajib --}}
                                    <p class="text-[11px] text-blue-600 dark:text-blue-400 italic mb-2">
                                        <strong>Shift</strong> dan <strong>Group</strong> wajib dipilih sebelum tambah employee.
                                    </p>

                                    {{-- Tombol Add: disabled kalau salah satu kosong --}}
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

                                {{-- STEP 2C: SELECTED EMPLOYEE LIST --}}
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
                                                        Belum ada employee dipilih. Cari employee di atas lalu klik Pilih.
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ================= STEP 3: PILIH SOAL ================= --}}
                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                            <div class="px-5 py-3.5 border-b border-zinc-200 dark:border-zinc-800 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center shadow-sm shadow-blue-500/30">
                                    <span class="text-xs font-bold text-white">3</span>
                                </div>
                                <h3 class="text-sm font-bold text-zinc-800 dark:text-white">Pilih Soal dari Bank Soal</h3>

                                {{-- Total Defect Badge --}}
                                <div class="ml-auto flex items-center gap-2">
                                    <span class="text-[11px] text-zinc-500 dark:text-zinc-400">Total Defect:</span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold
                                        {{ $totalSelectedItems === 5
                                            ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 border border-green-300 dark:border-green-700'
                                            : ($totalSelectedItems > 5
                                                ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 border border-red-300 dark:border-red-700'
                                                : 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 border border-amber-300 dark:border-amber-700') }}">
                                        {{ $totalSelectedItems }} / 5
                                    </span>
                                </div>
                            </div>

                            <div class="p-5">

                                {{-- Customer & Model --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <flux:label required>Customer</flux:label>
                                        <flux:select wire:model.live="customer_id" placeholder="Select customer..."
                                            :disabled="!$section">
                                            @foreach($customers as $customer)
                                                <flux:select.option value="{{ $customer->id }}">{{ $customer->customer_name }}</flux:select.option>
                                            @endforeach
                                        </flux:select>
                                        @error('customer_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <flux:label>Model (opsional)</flux:label>
                                        <flux:select wire:model.live="model_id" placeholder="Semua Model..."
                                            :disabled="!$customer_id">
                                            <flux:select.option value="">-- Semua Model --</flux:select.option>
                                            @foreach($formModels as $model)
                                                <flux:select.option value="{{ $model->id }}">{{ $model->model_name }}</flux:select.option>
                                            @endforeach
                                        </flux:select>
                                    </div>
                                </div>

                                {{-- Bank Soal Table --}}
                                @if(!$section || !$customer_id)
                                    <div class="p-4 bg-blue-50 dark:bg-blue-950/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                        <div class="flex items-start gap-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5">
                                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                            </svg>
                                            <p class="text-sm text-blue-800 dark:text-blue-300">
                                                Pilih <strong>Customer</strong> terlebih dahulu untuk menampilkan daftar soal. Model bersifat opsional.
                                            </p>
                                        </div>
                                    </div>
                                @elseif($questions->isEmpty())
                                    <div class="p-4 bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-800 rounded-lg">
                                        <div class="flex items-start gap-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5">
                                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                            </svg>
                                            <p class="text-sm text-red-800 dark:text-red-300">
                                                Tidak ada soal untuk kombinasi Section/Customer ini. Silakan buat soal di <strong>Master Question</strong> dulu.
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    @php
                                        $qPerPage = $this->questionPerPage;

                                        $qFiltered = $questions;
                                        if ($this->searchQuestion) {
                                            $needle = strtolower($this->searchQuestion);
                                            $qFiltered = $questions->filter(function ($q) use ($needle) {
                                                return str_contains((string) $q->id, $needle)
                                                    || str_contains(strtolower($q->question_text ?? ''), $needle);
                                            })->values();
                                        }
                                        $qTotal = $qFiltered->count();
                                        $qLastPage = max(1, (int) ceil($qTotal / $qPerPage));
                                        $qCurrentPage = min($this->questionPage, $qLastPage);
                                        $qOffset = ($qCurrentPage - 1) * $qPerPage;
                                        $qPageItems = $qFiltered->slice($qOffset, $qPerPage)->values();
                                    @endphp

                                    {{-- Search --}}
                                    <div class="mb-3 flex items-center gap-2">
                                        <div class="flex-1">
                                            <flux:input
                                                wire:model.live.debounce.300ms="searchQuestion"
                                                placeholder="Cari soal (ID atau deskripsi)..."
                                                icon="magnifying-glass"
                                                clearable
                                                size="sm"
                                            />
                                        </div>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                            {{ $qTotal }} soal
                                        </span>
                                    </div>

                                    @error('question_ids') <span class="text-red-500 text-xs block mb-2">{{ $message }}</span> @enderror

                                    {{-- Info Total --}}
                                    <div class="mb-3 p-3 rounded-lg border-2
                                        {{ $totalSelectedItems === 5
                                            ? 'bg-green-50 border-green-300 dark:bg-green-950/20 dark:border-green-800'
                                            : ($totalSelectedItems > 5
                                                ? 'bg-red-50 border-red-300 dark:bg-red-950/20 dark:border-red-800'
                                                : 'bg-amber-50 border-amber-300 dark:bg-amber-950/20 dark:border-amber-800') }}">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                @if($totalSelectedItems === 5)
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-green-600">
                                                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-sm font-bold text-green-700 dark:text-green-300">
                                                        Total Defect: 5 — Siap disimpan!
                                                    </span>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-amber-600">
                                                        <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-sm font-bold text-amber-700 dark:text-amber-300">
                                                        Total Defect: {{ $totalSelectedItems }} / 5 — Pilih soal lain biar pas 5
                                                    </span>
                                                @endif
                                            </div>
                                            <span class="text-xs text-zinc-600 dark:text-zinc-400">
                                                {{ count($question_ids) }} soal dipilih
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Table --}}
                                    <div class="border rounded-lg overflow-hidden dark:border-zinc-700">
                                        <table class="w-full text-sm">
                                            <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                                                <tr>
                                                    <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 uppercase w-12">Pilih</th>
                                                    <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 uppercase w-16">ID</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 uppercase">Deskripsi</th>
                                                    <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 uppercase w-40">Model</th>
                                                    <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 uppercase w-24">Items</th>
                                                    <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 uppercase w-40">Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                                @forelse($qPageItems as $q)
                                                @php
                                                    $itemCount = count($q->items ?? []);
                                                    $isSelected = in_array($q->id, $question_ids);
                                                    $currentTotal = $totalSelectedItems;
                                                    $wouldBeTotal = $isSelected ? $currentTotal : $currentTotal + $itemCount;
                                                    $canSelect = $isSelected || $wouldBeTotal <= 5;

                                                    $qModel = \App\Models\QAQC\BlindTest\Model::find($q->model_id);
                                                @endphp
                                                <tr wire:key="q-{{ $q->id }}"
                                                    class="transition-colors
                                                        {{ !$canSelect
                                                            ? 'bg-red-50 dark:bg-red-950/20 opacity-60 cursor-not-allowed'
                                                            : ($isSelected
                                                                ? 'bg-blue-50 dark:bg-blue-950/30 cursor-pointer'
                                                                : 'hover:bg-zinc-50 dark:hover:bg-zinc-800/50 cursor-pointer') }}"
                                                    @if($canSelect) wire:click="toggleQuestion({{ $q->id }})" @endif>

                                                    {{-- Checkbox --}}
                                                    <td class="px-3 py-2 text-center">
                                                        <div class="flex items-center justify-center">
                                                            <div class="w-5 h-5 rounded border-2 flex items-center justify-center
                                                                {{ $isSelected
                                                                    ? 'border-blue-600 bg-blue-600'
                                                                    : ($canSelect ? 'border-zinc-300 dark:border-zinc-600' : 'border-red-300 dark:border-red-700 bg-red-100 dark:bg-red-900/30') }}">
                                                                @if($isSelected)
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3 text-white">
                                                                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                                                                    </svg>
                                                                @elseif(!$canSelect)
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3 text-red-500">
                                                                        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                                                    </svg>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="px-3 py-2 text-center font-mono text-xs font-semibold text-zinc-700 dark:text-zinc-300">
                                                        #{{ $q->id }}
                                                    </td>

                                                    <td class="px-3 py-2 text-zinc-800 dark:text-zinc-200">
                                                        {{ $q->question_text ?: 'Tanpa deskripsi' }}
                                                    </td>

                                                    {{-- Model --}}
                                                    <td class="px-3 py-2 text-center">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300">
                                                            {{ $qModel->model_name ?? 'Model #' . $q->model_id }}
                                                        </span>
                                                    </td>

                                                    <td class="px-3 py-2 text-center">
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold
                                                            {{ $isSelected
                                                                ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300'
                                                                : ($canSelect ? 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300' : 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300') }}">
                                                            {{ $itemCount }} item
                                                        </span>
                                                    </td>

                                                    <td class="px-3 py-2 text-center text-xs text-zinc-600 dark:text-zinc-400 whitespace-nowrap">
                                                        {{ $q->created_at ? $q->created_at->format('d/m/Y H:i') : '-' }}
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6" class="px-3 py-6 text-center text-xs text-zinc-400 italic">
                                                        Tidak ada soal yang cocok dengan pencarian.
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- Pagination --}}
                                    @if($qLastPage > 1)
                                    <div class="mt-3 flex items-center justify-between">
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                            Menampilkan {{ $qOffset + 1 }}–{{ min($qOffset + $qPerPage, $qTotal) }} dari {{ $qTotal }}
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <button type="button"
                                                wire:click="setQuestionPage({{ max(1, $qCurrentPage - 1) }})"
                                                @if($qCurrentPage <= 1) disabled @endif
                                                class="px-2 py-1 rounded border border-zinc-300 dark:border-zinc-700 text-xs font-medium
                                                    disabled:opacity-40 disabled:cursor-not-allowed
                                                    hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                                Prev
                                            </button>

                                            @for($p = 1; $p <= $qLastPage; $p++)
                                                <button type="button"
                                                    wire:click="setQuestionPage({{ $p }})"
                                                    class="px-2.5 py-1 rounded border text-xs font-semibold
                                                        {{ $p === $qCurrentPage
                                                            ? 'bg-blue-600 border-blue-600 text-white'
                                                            : 'border-zinc-300 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800' }}">
                                                    {{ $p }}
                                                </button>
                                            @endfor

                                            <button type="button"
                                                wire:click="setQuestionPage({{ min($qLastPage, $qCurrentPage + 1) }})"
                                                @if($qCurrentPage >= $qLastPage) disabled @endif
                                                class="px-2 py-1 rounded border border-zinc-300 dark:border-zinc-700 text-xs font-medium
                                                    disabled:opacity-40 disabled:cursor-not-allowed
                                                    hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                                Next
                                            </button>
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Preview Soal Terpilih --}}
                                    @if($selectedQuestions->count() > 0)
                                    <div class="mt-4 space-y-3">
                                        <div class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase">
                                            Soal Terpilih ({{ $selectedQuestions->count() }}) — Total {{ $totalSelectedItems }} Item
                                        </div>

                                        @foreach($selectedQuestions as $sq)
                                        <div class="border-2 border-blue-200 dark:border-blue-800 rounded-lg overflow-hidden">
                                            <div class="px-3 py-2 bg-blue-50 dark:bg-blue-900/20 border-b border-blue-200 dark:border-blue-800 flex items-center justify-between">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs font-semibold text-blue-700 dark:text-blue-300">
                                                        Soal #{{ $sq->id }} ({{ count($sq->items ?? []) }} item)
                                                    </span>
                                                    @php $sqModel = \App\Models\QAQC\BlindTest\Model::find($sq->model_id); @endphp
                                                    <span class="text-[10px] px-2 py-0.5 rounded bg-purple-100 text-purple-700 font-semibold">
                                                        {{ $sqModel->model_name ?? '-' }}
                                                    </span>
                                                    <button type="button"
                                                        wire:click="toggleQuestion({{ $sq->id }})"
                                                        class="text-[10px] px-2 py-0.5 rounded bg-red-100 text-red-700 hover:bg-red-200 font-semibold">
                                                        ✕ Hapus
                                                    </button>
                                                </div>
                                                <span class="text-[10px] text-blue-600 dark:text-blue-400 truncate max-w-md">
                                                    {{ $sq->question_text }}
                                                </span>
                                            </div>
                                            <table class="w-full text-sm bg-white dark:bg-zinc-900">
                                                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                                                    <tr>
                                                        <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 uppercase w-10">#</th>
                                                        <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 uppercase">Defect Item</th>
                                                        <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 uppercase">Location</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                                    @foreach($sq->items ?? [] as $i => $it)
                                                    <tr>
                                                        <td class="px-3 py-2 text-zinc-500">{{ $i + 1 }}</td>
                                                        <td class="px-3 py-2 font-medium">{{ $it['deffect_name'] ?? '-' }}</td>
                                                        <td class="px-3 py-2">
                                                            <span class="inline-flex items-center px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-xs font-semibold">
                                                                {{ $it['location'] ?? '-' }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        {{-- ================= STEP 4: DURASI ================= --}}
                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                            <div class="px-5 py-3.5 border-b border-zinc-200 dark:border-zinc-800 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center shadow-sm shadow-blue-500/30">
                                    <span class="text-xs font-bold text-white">4</span>
                                </div>
                                <h3 class="text-sm font-bold text-zinc-800 dark:text-white">Durasi Pengerjaan</h3>
                            </div>
                            <div class="p-5">
                                <flux:label required>Duration (Menit)</flux:label>
                                <flux:input wire:model.live="duration_minutes" type="number" min="1" max="600"
                                    placeholder="e.g. 30" class="w-full" />
                                @error('duration_minutes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                <p class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-1">
                                    Batas lama pengerjaan setelah <strong>Start</strong>. Waktu dihitung per employee.
                                    Kalau habis, jawaban akan <strong>auto-save</strong> dan test otomatis close.
                                </p>
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
                        wire:loading.attr="disabled" wire:target="save"
                        @if($totalSelectedItems !== 5) disabled @endif>
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
                        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                            <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Model</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->model->model_name ?? '-' }}</div>
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

    <style>[x-cloak] { display: none !important; }</style>
</div>