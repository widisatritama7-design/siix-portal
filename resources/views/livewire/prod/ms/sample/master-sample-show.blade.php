<div class="p-1 space-y-2">
    
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">PROD</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">MS</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('prod.ms.master-sample') }}" wire:navigate separator="slash">Master Sample</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">View</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">{{ $masterSample->model_name }}</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Customer: {{ $masterSample->customer }}</p>
        </div>
        <div class="flex gap-2">
            <flux:button icon="arrow-left" href="{{ route('prod.ms.master-sample') }}" wire:navigate variant="primary" size="sm">Back</flux:button>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <flux:card class="p-0 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-700 dark:to-blue-800 px-4 py-3">
                <h3 class="flex items-center justify-center gap-2 font-semibold text-center text-white">
                    <flux:icon.clipboard-document-list class="w-5 h-5" />
                    General Information
                </h3>
            </div>
            <div class="p-4">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-500 dark:text-zinc-400 font-medium">Model Name:</span>
                        <span class="text-zinc-800 dark:text-zinc-200 font-semibold">{{ $masterSample->model_name }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-500 dark:text-zinc-400 font-medium">Customer:</span>
                        <span class="text-zinc-800 dark:text-zinc-200">{{ $masterSample->customer }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-500 dark:text-zinc-400 font-medium">Name/MC:</span>
                        <span class="text-zinc-800 dark:text-zinc-200">{{ $masterSample->name_or_mc }}</span>
                    </div>
                </div>
            </div>
        </flux:card>

        <flux:card class="p-0 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 dark:from-purple-700 dark:to-purple-800 px-4 py-3">
                <h3 class="flex items-center justify-center gap-2 font-semibold text-center text-white">
                    <flux:icon.server-stack class="w-5 h-5" />
                    Rack Information
                </h3>
            </div>
            <div class="p-4">
                <div class="space-y-2 text-sm">
                    @if($masterSample->rack)
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-500 dark:text-zinc-400 font-medium">Rack Type:</span>
                        <span class="text-zinc-800 dark:text-zinc-200">{{ $masterSample->rack->type_rack }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-500 dark:text-zinc-400 font-medium">Rack Column:</span>
                        <span class="text-zinc-800 dark:text-zinc-200">{{ $masterSample->rack->column_rack }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-500 dark:text-zinc-400 font-medium">Rack Sheet:</span>
                        <span class="text-zinc-800 dark:text-zinc-200">{{ $masterSample->rack->sheet_rack }}</span>
                    </div>
                    @else
                    <div class="text-center text-zinc-500 dark:text-zinc-400 py-4">No rack assigned</div>
                    @endif
                    @if($masterSample->rack_backup)
                    <div class="flex justify-between items-center pt-2 border-t border-zinc-200 dark:border-zinc-700">
                        <span class="text-zinc-500 dark:text-zinc-400 font-medium">Rack Backup:</span>
                        <span class="text-amber-600 dark:text-amber-400 font-semibold">{{ $masterSample->rack_backup }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </flux:card>

        <flux:card class="p-0 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 dark:from-emerald-700 dark:to-emerald-800 px-4 py-3">
                <h3 class="flex items-center justify-center gap-2 font-semibold text-center text-white">
                    <flux:icon.beaker class="w-5 h-5" />
                    Samples
                </h3>
            </div>
            <div class="p-4">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-500 dark:text-zinc-400 font-medium">Sample OK:</span>
                        <div class="flex items-center gap-1">
                            <span class="text-green-600 dark:text-green-400 font-semibold">{{ $masterSample->sample_ok ?? '-' }}</span>
                            @if($masterSample->sample_ok_backup)
                            <flux:badge size="sm" color="green" class="text-xs">Backup</flux:badge>
                            @endif
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-500 dark:text-zinc-400 font-medium">Sample NG:</span>
                        <div class="flex items-center gap-1">
                            <span class="text-red-600 dark:text-red-400 font-semibold">{{ $masterSample->sample_ng ?? '-' }}</span>
                            @if($masterSample->sample_blank)
                            <flux:badge size="sm" color="red" class="text-xs">Blank</flux:badge>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </flux:card>
    </div>

    <!-- Tabs -->
    <div class="mt-6 border-b border-zinc-200 dark:border-zinc-700">
        <div class="flex justify-center gap-6">
            <a href="{{ route('prod.ms.master-sample.show', ['id' => $masterSample->id, 'tab' => 'history']) }}" 
            wire:navigate 
            class="group flex items-center gap-2 pb-3 px-1 text-sm font-medium relative transition-colors {{ $activeRelationTab === 'history' ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Loan History 
                <span class="ml-1 px-1.5 py-0.5 text-xs rounded-full bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-400 font-medium">
                    {{ $histories->total() }}
                </span>
            </a>
            <a href="{{ route('prod.ms.master-sample.show', ['id' => $masterSample->id, 'tab' => 'details']) }}" 
            wire:navigate 
            class="group flex items-center gap-2 pb-3 px-1 text-sm font-medium relative transition-colors {{ $activeRelationTab === 'details' ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
                Expired History 
                <span class="ml-1 px-1.5 py-0.5 text-xs rounded-full bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-400 font-medium">
                    {{ $details->total() }}
                </span>
            </a>
        </div>
    </div>

    <!-- Tab: Loan History -->
    @if($activeRelationTab === 'history')
    <div>
        <div class="flex justify-end mb-3">
            @if($canAddLoan)
            <a href="{{ route('prod.ms.master-sample.loan.create', $masterSample->id) }}" class="px-3 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition">+ New Loan Application</a>
            @endif
        </div>
        <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="overflow-x-auto">
                <table class="min-w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Type</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Out Date</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">In Date</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NIK</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Location/Line</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Remarks</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($histories as $history)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    @foreach($this->safeDecodeType($history->type) as $t)
                                    <span class="px-2 py-0.5 text-xs rounded-full {{ 
                                        $t === 'sample_ok' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 
                                        ($t === 'sample_ok_backup' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400' : 
                                        ($t === 'sample_ng' ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' : 
                                        'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400')) 
                                    }}">
                                        {{ strtoupper(str_replace('sample_', '', str_replace('_backup', ' BACKUP', $t))) }}
                                    </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300 text-center whitespace-nowrap">{{ $history->out_date ? \Carbon\Carbon::parse($history->out_date)->format('d M Y H:i') : '-' }}</td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300 text-center whitespace-nowrap">{{ $history->in_date ? \Carbon\Carbon::parse($history->in_date)->format('d M Y H:i') : '-' }}</td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300 text-center">{{ $history->employee->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                <flux:badge size="sm" color="{{ 
                                    $history->status === 'in_use' ? 'green' : 
                                    ($history->status === 'stand_by' ? 'blue' : 
                                    ($history->status === 'loaning' ? 'yellow' : 
                                    ($history->status === 'ecr' ? 'blue' : 'gray'))) 
                                }}">
                                    {{ 
                                        $history->status === 'in_use' ? 'In Use' : 
                                        ($history->status === 'stand_by' ? 'Stand By' : 
                                        ($history->status === 'loaning' ? 'Loaning' : 
                                        ($history->status === 'ecr' ? 'ECR' : 
                                        ucfirst($history->status ?? '-')))) 
                                    }}
                                </flux:badge>
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300 text-center">
                                {{ $history->masterLine?->location?->location_name ?? '-' }} 
                                @if($history->masterLine?->line_number) 
                                    <span class="text-zinc-400">|</span> Line {{ $history->masterLine->line_number }} 
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300 text-center">{{ $history->remarks ?? '-' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                <!-- View Ac    tivity Button -->
                                    <flux:tooltip content="View Activity Log" position="bottom">
                                        <button wire:click="viewActivity({{ $history->id }}, 'history')"
                                                class="inline-flex items-center justify-center p-2 text-purple-600 hover:bg-purple-100 dark:hover:bg-purple-900/30 rounded-lg transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </button>
                                    </flux:tooltip>
                                    <!-- Update In Date Button -->
                                    @php
                                        $showUpdateInDateButton = false;
                                        if (is_null($history->in_date)) {
                                            if ($history->status === 'ecr') {
                                                $showUpdateInDateButton = $this->isDetailsUpdated($history);
                                            } else {
                                                $showUpdateInDateButton = true;
                                            }
                                        }
                                    @endphp
                                    @if($showUpdateInDateButton)
                                    <flux:tooltip content="Update In Date" position="bottom">
                                        <button wire:click="openUpdateInDateModal({{ $history->id }})"
                                                x-on:click="$dispatch('open-update-in-date-modal')"
                                                class="inline-flex items-center justify-center p-2 text-green-600 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 16.5v.008M12 16.5v.008M15 16.5v.008" />
                                            </svg>
                                        </button>
                                    </flux:tooltip>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                        <flux:icon name="document" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                            No loan history records found
                                        </h3>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                            No loan transactions have been recorded for this sample
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($histories->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $histories->links() }}
            </div>
            @endif
        </flux:card>
    </div>
    @endif

    <!-- Tab: Expired History -->
    @if($activeRelationTab === 'details')
    <div>
        <div class="flex justify-end mb-3">
            @if($canAddExpired)
            <a href="{{ route('prod.ms.master-sample.expired.create', $masterSample->id) }}" class="px-3 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition">+ Add Expired History</a>
            @endif
        </div>
        <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="overflow-x-auto">
                <table class="min-w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Updated Date</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Expired Date</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Alarm Date</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Days Left</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Checked By</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Knowledge By</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Approved By</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($details as $detail)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300 text-center whitespace-nowrap">{{ $detail->updated_date ? \Carbon\Carbon::parse($detail->updated_date)->format('d M Y') : '-' }}</td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300 text-center whitespace-nowrap">{{ $detail->expired_date ? \Carbon\Carbon::parse($detail->expired_date)->format('d M Y') : '-' }}</td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300 text-center whitespace-nowrap">{{ $detail->date_alarm ? \Carbon\Carbon::parse($detail->date_alarm)->format('d M Y') : '-' }}</td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300 text-center">{{ $detail->days_left ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                <flux:badge size="sm" color="{{ (!$detail->expired_date || \Carbon\Carbon::parse($detail->expired_date)->isFuture()) ? 'green' : 'red' }}">
                                    {{ (!$detail->expired_date || \Carbon\Carbon::parse($detail->expired_date)->isFuture()) ? 'Active' : 'Expired' }}
                                </flux:badge>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="text-sm text-zinc-600 dark:text-zinc-300">{{ $detail->checkedBy->name ?? '-' }}</div>
                                <div class="text-xs text-zinc-400 dark:text-zinc-500">{{ $detail->check_date ? \Carbon\Carbon::parse($detail->check_date)->format('d M Y H:i') : 'Waiting' }}</div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="text-sm text-zinc-600 dark:text-zinc-300">{{ $detail->knowladgeBy->name ?? '-' }}</div>
                                <div class="text-xs text-zinc-400 dark:text-zinc-500">{{ $detail->knowladge_date ? \Carbon\Carbon::parse($detail->knowladge_date)->format('d M Y H:i') : 'Waiting' }}</div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="text-sm text-zinc-600 dark:text-zinc-300">{{ $detail->approvedBy->name ?? '-' }}</div>
                                <div class="text-xs text-zinc-400 dark:text-zinc-500">{{ $detail->approve_date ? \Carbon\Carbon::parse($detail->approve_date)->format('d M Y H:i') : 'Waiting' }}</div>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <!-- View Activity Button -->
                                    <flux:tooltip content="View Activity Log" position="bottom">
                                        <button wire:click="viewActivity({{ $detail->id }}, 'detail')"
                                                class="inline-flex items-center justify-center p-2 text-purple-600 hover:bg-purple-100 dark:hover:bg-purple-900/30 rounded-lg transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </button>
                                    </flux:tooltip>
                                    @php
                                        $lastHistory = $masterSample->historydDetails()
                                            ->latest('out_date')
                                            ->first();

                                        $isVisible = false;

                                        if ($lastHistory && $lastHistory->status === 'ecr') {
                                            $isVisible = true;
                                        } elseif ($detail->date_alarm) {
                                            $isVisible = \Carbon\Carbon::today()->greaterThanOrEqualTo(
                                                \Carbon\Carbon::parse($detail->date_alarm)->startOfDay()
                                            );
                                        }
                                    @endphp

                                    @if($isVisible)
                                        <flux:tooltip content="Edit" position="bottom">
                                            <a href="{{ route('prod.ms.master-sample.expired.edit', ['sampleId' => $masterSample->id, 'id' => $detail->id]) }}" 
                                            class="inline-flex items-center justify-center p-2 text-yellow-600 hover:bg-yellow-100 dark:hover:bg-yellow-900/30 rounded-lg transition-colors">

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>

                                            </a>
                                        </flux:tooltip>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                        <flux:icon name="document" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                            No expired history records found
                                        </h3>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                            No expiration records have been logged for this sample
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($details->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $details->links() }}
            </div>
            @endif
        </flux:card>
    </div>
    @endif

    <!-- Update In Date Modal -->
    <div x-data="{ open: false, search: '', show: false }" 
        x-show="open" 
        @open-update-in-date-modal.window="open = true; search = ''; show = false"
        @close-modal.window="if ($event.detail === 'update-in-date-modal') open = false"
        x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold">Update In Date</h3>
                        <button @click="open = false" class="text-zinc-500 hover:text-zinc-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- NIK with Search -->
                    <div class="relative mb-4">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Confirm NIK <span class="text-red-500">*</span>
                        </label>
                        
                        <!-- Input Search -->
                        <input 
                            type="text"
                            x-model="search"
                            @input="show = search.trim().length >= 1"
                            placeholder="Search by NIK or name..."
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-700"
                        >

                        <!-- Dropdown Results -->
                        <div 
                            x-show="show"
                            x-transition
                            @click.outside="show = false"
                            class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-800 
                                border border-zinc-300 dark:border-zinc-600 rounded-lg shadow-lg 
                                max-h-60 overflow-y-auto"
                            style="display: none;"
                        >
                            @foreach($employees as $employee)
                                <div 
                                    x-show="'{{ strtolower($employee->name) }}'.includes(search.toLowerCase()) 
                                            || '{{ strtolower($employee->nik) }}'.includes(search.toLowerCase())"
                                    
                                    @click="
                                        $wire.set('selectedNik', '{{ $employee->id }}'); 
                                        search = '{{ addslashes($employee->nik . ' - ' . $employee->name) }}'; 
                                        show = false;
                                    "
                                    class="px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700 cursor-pointer border-b border-zinc-100 dark:border-zinc-700 last:border-0"
                                >
                                    <div class="text-sm font-medium text-zinc-800 dark:text-zinc-200">
                                        {{ $employee->nik }} - {{ $employee->name }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @error('selectedNik') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <div class="flex justify-end gap-2 mt-6">
                        <button type="button" 
                                @click="open = false"
                                wire:click="cancelUpdateInDate"
                                class="px-4 py-2 border rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                            Cancel
                        </button>
                        <button type="button" 
                                wire:click="confirmUpdateInDate"
                                @click="open = false"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            Update In Date
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Activity Log Modal at the end of the file, before the notification div -->
    <!-- MODAL ACTIVITY LOG -->
    <flux:modal wire:model="showActivityModal" class="w-full max-w-5xl">
        <div class="flex flex-col" style="height: auto; max-height: 85vh; overflow: hidden;">
            <div class="flex justify-between items-center px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex-shrink-0">
                <div>
                    <h2 class="text-xl font-bold text-zinc-800 dark:text-white">Activity Log</h2>
                    @if($selectedRecordForActivity)
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        Record Type: <span class="font-semibold">{{ ucfirst(str_replace('-', ' ', $selectedRecordType)) }}</span>
                        @if($selectedRecordType === 'history')
                            | ID: <span class="font-semibold">#{{ $selectedRecordForActivity->id }}</span>
                        @else
                            | ID: <span class="font-semibold">#{{ $selectedRecordForActivity->id }}</span>
                        @endif
                    </p>
                    @endif
                </div>
            </div>

            @if($selectedRecordForActivity)
            @php
                $activitiesData = $activities;
                $totalRecords = $activitiesData->total();
                $lastPage = $activitiesData->lastPage();
                $allUsers = \App\Models\User::all()->keyBy('id');
                $allEmployees = \App\Models\HR\Employee::all()->keyBy('id');
            @endphp
            
            <div class="flex-1 overflow-y-auto p-6">
                @if($totalRecords > 0)
                    <div class="space-y-4">
                        <div class="flex gap-2 mb-2">
                            <span class="px-2 py-1 rounded-full text-white font-bold bg-red-600 text-xs">Old Value</span>
                            <span class="px-2 py-1 rounded-full text-white font-bold bg-green-600 text-xs">New Value</span>
                        </div>

                        <div class="space-y-2">
                            @foreach($activitiesData as $index => $activity)
                                @php
                                    $attributeChanges = is_string($activity->attribute_changes) ? json_decode($activity->attribute_changes, true) : ($activity->attribute_changes ?? []);
                                    $old = $attributeChanges['old'] ?? [];
                                    $new = $attributeChanges['attributes'] ?? [];
                                    
                                    if (empty($old) && empty($new)) {
                                        $props = is_string($activity->properties) ? json_decode($activity->properties, true) : ($activity->properties ?? []);
                                        $old = $props['old'] ?? [];
                                        $new = $props['attributes'] ?? [];
                                    }
                                    
                                    $changes = [];
                                    if ($activity->event == 'created') {
                                        foreach ($new as $key => $val) {
                                            if (!in_array($key, ['created_by', 'updated_by', 'id', 'created_at', 'updated_at'])) {
                                                $changes[$key] = ['old' => null, 'new' => $val];
                                            }
                                        }
                                    } elseif ($activity->event == 'updated') {
                                        foreach ($new as $key => $val) {
                                            $oldVal = $old[$key] ?? null;
                                            if ($oldVal !== $val && !in_array($key, ['created_by', 'updated_by', 'id', 'created_at', 'updated_at'])) {
                                                $changes[$key] = ['old' => $oldVal, 'new' => $val];
                                            }
                                        }
                                    } elseif ($activity->event == 'deleted') {
                                        foreach ($old as $key => $val) {
                                            if (!in_array($key, ['created_by', 'updated_by', 'id', 'created_at', 'updated_at'])) {
                                                $changes[$key] = ['old' => $val, 'new' => null];
                                            }
                                        }
                                    }
                                    
                                    $isFirst = $loop->first;
                                @endphp
                                
                                @if(!empty($changes))
                                <div x-data="{ open: {{ $isFirst ? 'true' : 'false' }} }" class="border rounded-lg shadow-sm bg-white dark:bg-zinc-900">
                                    <button type="button" @click="open = !open" class="w-full flex justify-between items-center px-4 py-3 text-left font-medium bg-gray-100 hover:bg-gray-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 rounded-t-lg">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            @if($activity->event == 'created')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                    CREATED
                                                </span>
                                            @elseif($activity->event == 'updated')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    UPDATED
                                                </span>
                                            @elseif($activity->event == 'deleted')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    DELETED
                                                </span>
                                            @endif
                                            <strong class="text-sm text-zinc-800 dark:text-zinc-200">{{ $activity->causer?->name ?? 'System' }}</strong>
                                            <span class="text-xs text-zinc-500">{{ $activity->created_at ? $activity->created_at->format('d M Y H:i:s') : '-' }}</span>
                                        </div>
                                        <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transform transition-transform text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div x-show="open" x-transition class="p-4 space-y-2">
                                        @foreach ($changes as $field => $change)
                                            @php
                                                $oldValue = $change['old'];
                                                $newValue = $change['new'];
                                                $fieldName = ucfirst(str_replace('_', ' ', $field));
                                                
                                                // Handle field nik - ambil nama employee
                                                if ($field === 'nik') {
                                                    if (!empty($oldValue)) {
                                                        $employee = $allEmployees[$oldValue] ?? null;
                                                        $oldValue = $employee ? $employee->name . ' (' . $employee->nik . ')' : $oldValue;
                                                    }
                                                    if (!empty($newValue)) {
                                                        $employee = $allEmployees[$newValue] ?? null;
                                                        $newValue = $employee ? $employee->name . ' (' . $employee->nik . ')' : $newValue;
                                                    }
                                                }
                                                
                                                // Handle field checked_by, approved_by, knowladge_by
                                                if (in_array($field, ['checked_by', 'approved_by', 'knowladge_by', 'created_by', 'updated_by']) && is_numeric($oldValue)) {
                                                    $oldValue = $allUsers[$oldValue]?->name ?? $oldValue;
                                                }
                                                if (in_array($field, ['checked_by', 'approved_by', 'knowladge_by', 'created_by', 'updated_by']) && is_numeric($newValue)) {
                                                    $newValue = $allUsers[$newValue]?->name ?? $newValue;
                                                }
                                                
                                                // Handle type field (array)
                                                if ($field === 'type' && is_array($oldValue)) {
                                                    $oldValue = implode(', ', $oldValue);
                                                }
                                                if ($field === 'type' && is_array($newValue)) {
                                                    $newValue = implode(', ', $newValue);
                                                }
                                                
                                                $displayOld = $oldValue ?? '-';
                                                $displayNew = $newValue ?? '-';
                                            @endphp

                                            <div class="text-sm flex items-center gap-2 flex-wrap">
                                                <span class="font-semibold min-w-[120px]">{{ $fieldName }}:</span>
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    @if($activity->event == 'created')
                                                        <span class="px-2 py-0.5 rounded-full text-white font-bold bg-green-600 text-xs">{{ $displayNew }}</span>
                                                    @elseif($activity->event == 'deleted')
                                                        <span class="px-2 py-0.5 rounded-full text-white font-bold bg-red-600 text-xs">{{ $displayOld }}</span>
                                                    @else
                                                        <span class="px-2 py-0.5 rounded-full text-white font-bold bg-red-600 line-through text-xs">{{ $displayOld }}</span>
                                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                        </svg>
                                                        <span class="px-2 py-0.5 rounded-full text-white font-bold bg-green-600 text-xs">{{ $displayNew }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        
                        @if($lastPage > 1)
                        <div class="flex justify-between items-center mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                Showing {{ $activitiesData->firstItem() }} to {{ $activitiesData->lastItem() }} of {{ $totalRecords }} records
                            </div>
                            <div class="flex gap-2">
                                <flux:button wire:click="setActivityPage({{ $activityPage - 1 }})" size="sm" variant="outline" :disabled="$activityPage <= 1" class="!px-3">Previous</flux:button>
                                @for($i = 1; $i <= $lastPage; $i++)
                                    @if($i == $activityPage)
                                        <flux:button size="sm" variant="primary" class="!px-3">{{ $i }}</flux:button>
                                    @elseif($i == 1 || $i == $lastPage || ($i >= $activityPage - 1 && $i <= $activityPage + 1))
                                        <flux:button wire:click="setActivityPage({{ $i }})" size="sm" variant="outline" class="!px-3">{{ $i }}</flux:button>
                                    @elseif($i == $activityPage - 2 || $i == $activityPage + 2)
                                        <span class="px-2 py-1 text-sm text-zinc-500 dark:text-zinc-400">...</span>
                                    @endif
                                @endfor
                                <flux:button wire:click="setActivityPage({{ $activityPage + 1 }})" size="sm" variant="outline" :disabled="$activityPage >= $lastPage" class="!px-3">Next</flux:button>
                            </div>
                        </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="mt-4 text-sm text-zinc-500 dark:text-zinc-400">No activity logs found for this record</p>
                    </div>
                @endif
            </div>
            @endif
        </div>
    </flux:modal>

    <!-- Notifikasi -->
    <div x-data="{ show: false, message: '', type: 'success' }" 
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
         x-show="show" x-transition class="fixed bottom-4 right-4 z-50"
         :class="{'bg-green-500': type === 'success', 'bg-red-500': type === 'error'}"
         style="display: none;">
        <div class="text-white px-6 py-3 rounded-lg shadow-lg" x-text="message"></div>
    </div>

    <style>[x-cloak] { display: none !important; }</style>
</div>