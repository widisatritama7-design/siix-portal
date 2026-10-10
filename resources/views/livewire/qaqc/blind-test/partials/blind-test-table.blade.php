<flux:card class="p-0 shadow-lg flex flex-col overflow-hidden">

    {{-- ===== HEADER ===== --}}
    <div class="relative px-6 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 overflow-hidden">
        <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-white/10"></div>
        <div class="absolute -right-2 -bottom-8 w-16 h-16 rounded-full bg-white/10"></div>

        <div class="relative flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                        <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <div class="text-[10px] text-white/70 uppercase tracking-wider font-semibold">Management</div>
                    <div class="text-base font-bold text-white leading-tight">Blind Test List</div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                @if($selectedDate)
                    @php $selDate = \Carbon\Carbon::parse($selectedDate); @endphp
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                            <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
                        </svg>
                        {{ $selDate->translatedFormat('d M Y') }}
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                        All Dates
                    </span>
                @endif

                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                        <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clip-rule="evenodd" />
                    </svg>
                    {{ $blindTests->total() }} total
                </span>
            </div>
        </div>
    </div>

    {{-- ===== BODY ===== --}}
    <div class="p-6 flex flex-col flex-1">
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
            <div x-show="showScroll" x-transition.opacity.duration.300ms
                class="pointer-events-none absolute left-0 top-0 bottom-0 w-8 z-10 bg-gradient-to-r from-white dark:from-zinc-900 to-transparent"></div>
            <div x-show="showScroll" x-transition.opacity.duration.300ms
                class="pointer-events-none absolute right-0 top-0 bottom-0 w-8 z-10 bg-gradient-to-l from-white dark:from-zinc-900 to-transparent"></div>

            <div class="overflow-x-auto flex-1 transition-all duration-300 custom-scroll-x"
                :class="showScroll ? 'scrollbar-visible' : 'scrollbar-hidden'">

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
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase sticky right-0 bg-zinc-50 dark:bg-zinc-800 z-20 shadow-[-4px_0_6px_-4px_rgba(0,0,0,0.1)]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($blindTests as $index => $bt)
                        @php $isTrashed = $bt->trashed(); @endphp
                        <tr class="group hover:bg-zinc-50 dark:hover:bg-zinc-800/50 {{ $isTrashed ? 'opacity-60' : '' }}" wire:key="bt-{{ $bt->id }}">
                            <td class="px-4 py-3 text-sm text-center">{{ $blindTests->firstItem() + $index }}</td>
                            <td class="px-4 py-3 text-sm text-center font-semibold">{{ $bt->employee->nik ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $bt->employee->name ?? '-' }}</td>
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
                                        $snapshotModels = collect($bt->question_snapshot ?? [])
                                            ->flatMap(function ($q) {
                                                $items = $q['items'] ?? [];
                                                if (!empty($items) && isset($items[0]['model_id'])) {
                                                    return collect($items)->map(fn ($g) => [
                                                        'model_id'   => $g['model_id'] ?? null,
                                                        'model_name' => $g['model_name'] ?? null,
                                                    ])->filter(fn ($m) => $m['model_id']);
                                                }
                                                if (!empty($q['model_id'])) {
                                                    $m = \App\Models\QAQC\BlindTest\Model::find($q['model_id']);
                                                    return $m ? [['model_id' => $m->id, 'model_name' => $m->model_name]] : [];
                                                }
                                                return [];
                                            })
                                            ->unique('model_id')
                                            ->values();

                                        if ($snapshotModels->isEmpty() && $bt->model_id) {
                                            $m = \App\Models\QAQC\BlindTest\Model::find($bt->model_id);
                                            if ($m) $snapshotModels = collect([['model_id' => $m->id, 'model_name' => $m->model_name]]);
                                        }
                                    @endphp

                                    @if($snapshotModels->count() > 0)
                                        <div class="flex flex-wrap items-center justify-center gap-1">
                                            @foreach($snapshotModels as $sm)
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold
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
                                        <div class="text-[10px] text-orange-500 font-semibold mt-0.5 uppercase">Auto Saved</div>
                                    @endif
                                @endif
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if($bt->status === 'completed' && !$bt->is_reviewed)
                                    <div class="inline-flex flex-col items-center gap-1">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 text-xs font-bold border border-amber-300 dark:border-amber-700">
                                            Pending Review
                                        </span>
                                        <div class="text-[10px] text-amber-600 font-semibold">Menunggu QC</div>
                                    </div>
                                @elseif($bt->overall_result)
                                    <flux:badge size="sm" color="{{ $bt->overall_result === 'PASS' ? 'green' : 'red' }}">
                                        {{ $bt->overall_result }}
                                    </flux:badge>
                                    <div class="text-xs text-zinc-500 mt-1">{{ $bt->total_correct }}/{{ $bt->total_items }}</div>

                                    @if($bt->max_attempt > 1)
                                        <div class="text-[10px] font-semibold mt-0.5
                                            {{ $bt->attempt > 1 ? 'text-purple-600' : 'text-zinc-500' }}">
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
                                        {{ $bt->creator->name ?? '-' }}
                                    </div>
                                    <div class="text-[10px] text-zinc-500 whitespace-nowrap">
                                        {{ $bt->created_at ? $bt->created_at->format('d/m/Y H:i') : '-' }}
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3 text-center sticky right-0 bg-white dark:bg-zinc-900 z-10 shadow-[-4px_0_6px_-4px_rgba(0,0,0,0.1)] group-hover:bg-zinc-50 dark:group-hover:bg-zinc-800/50">
                                @if($isTrashed)
                                    <div class="flex flex-col items-center gap-1.5 max-w-[220px] mx-auto">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-[10px] font-bold uppercase tracking-wider">
                                            Deleted
                                        </span>
                                        @if($bt->deleted_reason)
                                            <div class="text-xs text-red-600 font-semibold italic text-center leading-tight break-words"
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
        <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $blindTests->links() }}
        </div>
        @endif
    </div>
</flux:card>