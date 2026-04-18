<div class="p-1 space-y-2">
    
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">PROD</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">MS</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('prod.ms.master-sample') }}" wire:navigate separator="slash">Master Sample</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">{{ $masterSample->model_name }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">{{ $masterSample->model_name }}</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">ID: #{{ $masterSample->id }} | Customer: {{ $masterSample->customer }}</p>
        </div>
        <div class="flex gap-2">
            <flux:button icon="arrow-left" href="{{ route('prod.ms.master-sample') }}" wire:navigate variant="primary" size="sm">Back</flux:button>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <flux:card class="p-4">
            <h3 class="font-semibold border-b pb-2 mb-3">📋 General Information</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-zinc-500">Model Name:</span><span>{{ $masterSample->model_name }}</span></div>
                <div class="flex justify-between"><span class="text-zinc-500">Customer:</span><span>{{ $masterSample->customer }}</span></div>
                <div class="flex justify-between"><span class="text-zinc-500">Name/MC:</span><span>{{ $masterSample->name_or_mc }}</span></div>
                <div class="flex justify-between"><span class="text-zinc-500">Status:</span><flux:badge size="sm" color="{{ $masterSample->status === 'ACTIVE' ? 'green' : 'gray' }}">{{ $masterSample->status ?? 'ACTIVE' }}</flux:badge></div>
                @if($masterSample->remarks)<div class="flex justify-between"><span class="text-zinc-500">Remarks:</span><span>{{ $masterSample->remarks }}</span></div>@endif
            </div>
        </flux:card>

        <flux:card class="p-4">
            <h3 class="font-semibold border-b pb-2 mb-3">🗄️ Rack Information</h3>
            <div class="space-y-2 text-sm">
                @if($masterSample->rack)
                <div class="flex justify-between"><span class="text-zinc-500">Rack Type:</span><span>{{ $masterSample->rack->type_rack }}</span></div>
                <div class="flex justify-between"><span class="text-zinc-500">Rack Column:</span><span>{{ $masterSample->rack->column_rack }}</span></div>
                <div class="flex justify-between"><span class="text-zinc-500">Rack Sheet:</span><span>{{ $masterSample->rack->sheet_rack }}</span></div>
                @else<div class="text-center text-zinc-500">No rack assigned</div>@endif
                @if($masterSample->rack_backup)<div class="flex justify-between"><span class="text-zinc-500">Rack Backup:</span><span>{{ $masterSample->rack_backup }}</span></div>@endif
            </div>
        </flux:card>

        <flux:card class="p-4">
            <h3 class="font-semibold border-b pb-2 mb-3">🔬 Samples</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-zinc-500">Sample OK:</span><span class="text-green-600">{{ $masterSample->sample_ok ?? '-' }}</span>@if($masterSample->sample_ok_backup)<span class="text-green-500 text-xs ml-2">(Backup)</span>@endif</div>
                <div class="flex justify-between"><span class="text-zinc-500">Sample NG:</span><span class="text-red-600">{{ $masterSample->sample_ng ?? '-' }}</span>@if($masterSample->sample_blank)<span class="text-red-500 text-xs ml-2">(Blank)</span>@endif</div>
            </div>
        </flux:card>
    </div>

    <!-- Tabs -->
    <div class="mt-6 border-b border-zinc-200 dark:border-zinc-700">
        <div class="flex justify-center gap-6">
            <a href="{{ route('prod.ms.master-sample.show', ['id' => $masterSample->id, 'tab' => 'history']) }}" wire:navigate class="pb-3 px-1 text-sm font-medium relative {{ $activeRelationTab === 'history' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-zinc-500' }}">
                Loan History <span class="ml-1 px-1.5 py-0.5 text-xs rounded-full bg-zinc-100">{{ $histories->total() }}</span>
            </a>
            <a href="{{ route('prod.ms.master-sample.show', ['id' => $masterSample->id, 'tab' => 'details']) }}" wire:navigate class="pb-3 px-1 text-sm font-medium relative {{ $activeRelationTab === 'details' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-zinc-500' }}">
                Expired History <span class="ml-1 px-1.5 py-0.5 text-xs rounded-full bg-zinc-100">{{ $details->total() }}</span>
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
                            <th class="px-4 py-3 text-center text-xs font-medium">Type</th>
                            <th class="px-4 py-3 text-center text-xs font-medium">Qty</th>
                            <th class="px-4 py-3 text-center text-xs font-medium">Out Date</th>
                            <th class="px-4 py-3 text-center text-xs font-medium">In Date</th>
                            <th class="px-4 py-3 text-center text-xs font-medium">NIK</th>
                            <th class="px-4 py-3 text-center text-xs font-medium">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-medium">Location/Line</th>
                            <th class="px-4 py-3 text-center text-xs font-medium">Remarks</th>
                            <th class="px-4 py-3 text-right text-xs font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($histories as $history)
                        <tr class="hover:bg-zinc-50">
                            <td class="px-4 py-3 text-center">
                                <div class="flex flex-wrap items-center justify-center gap-1">
                                    @foreach($this->safeDecodeType($history->type) as $t)
                                    <span class="px-2 py-0.5 text-xs rounded-full {{ $t === 'sample_ok' ? 'bg-green-100' : ($t === 'sample_ng' ? 'bg-red-100' : 'bg-blue-100') }}">
                                        {{ strtoupper(str_replace('sample_', '', $t)) }}
                                    </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-3">{{ $history->qty }}</td>
                            <td class="px-4 py-3">{{ $history->out_date ? \Carbon\Carbon::parse($history->out_date)->format('d M Y H:i') : '-' }}</td>
                            <td class="px-4 py-3">{{ $history->in_date ? \Carbon\Carbon::parse($history->in_date)->format('d M Y H:i') : '-' }}</td>
                            <td class="px-4 py-3">{{ $history->employee->name ?? '-' }}</td>
                            <td class="px-4 py-3"><flux:badge size="sm" color="{{ $history->status === 'in_use' ? 'green' : 'yellow' }}">{{ $history->status }}</flux:badge></td>
                            <td class="px-4 py-3">{{ $history->masterLine?->location?->location_name ?? '-' }} @if($history->masterLine?->line_number) - Line {{ $history->masterLine->line_number }} @endif</td>
                            <td class="px-4 py-3">{{ $history->remarks ?? '-' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-1">
                                    <a href="{{ route('prod.ms.master-sample.loan.edit', ['sampleId' => $masterSample->id, 'id' => $history->id]) }}" class="p-1 text-yellow-600 hover:bg-yellow-100 rounded">✏️</a>
                                    <button wire:click="deleteLoan({{ $history->id }})" wire:confirm="Are you sure?" class="p-1 text-red-600 hover:bg-red-100 rounded">🗑️</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center py-8">No loan history records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($histories->hasPages())
            <div class="p-4 border-t">{{ $histories->links() }}</div>
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
                            <th class="px-4 py-3 text-center text-xs font-medium">Updated Date</th>
                            <th class="px-4 py-3 text-center text-xs font-medium">Expired Date</th>
                            <th class="px-4 py-3 text-center text-xs font-medium">Alarm Date</th>
                            <th class="px-4 py-3 text-center text-xs font-medium">Days Left</th>
                            <th class="px-4 py-3 text-center text-xs font-medium">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-medium">Checked By</th>
                            <th class="px-4 py-3 text-center text-xs font-medium">Knowledge By</th>
                            <th class="px-4 py-3 text-center text-xs font-medium">Approved By</th>
                            <th class="px-4 py-3 text-right text-xs font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($details as $detail)
                        <tr class="hover:bg-zinc-50">
                            <td class="px-4 py-3">{{ $detail->updated_date ? \Carbon\Carbon::parse($detail->updated_date)->format('d M Y') : '-' }}</td>
                            <td class="px-4 py-3">{{ $detail->expired_date ? \Carbon\Carbon::parse($detail->expired_date)->format('d M Y') : '-' }}</td>
                            <td class="px-4 py-3">{{ $detail->date_alarm ? \Carbon\Carbon::parse($detail->date_alarm)->format('d M Y') : '-' }}</td>
                            <td class="px-4 py-3">{{ $detail->days_left ?? '-' }}</td>
                            <td class="px-4 py-3"><flux:badge size="sm" color="{{ (!$detail->expired_date || \Carbon\Carbon::parse($detail->expired_date)->isFuture()) ? 'green' : 'red' }}">{{ (!$detail->expired_date || \Carbon\Carbon::parse($detail->expired_date)->isFuture()) ? 'Active' : 'Expired' }}</flux:badge></td>
                            <td class="px-4 py-3"><div>{{ $detail->checkedBy->name ?? '-' }}</div><div class="text-xs">{{ $detail->check_date ? \Carbon\Carbon::parse($detail->check_date)->format('d M Y H:i') : 'Waiting' }}</div></td>
                            <td class="px-4 py-3"><div>{{ $detail->knowladgeBy->name ?? '-' }}</div><div class="text-xs">{{ $detail->knowladge_date ? \Carbon\Carbon::parse($detail->knowladge_date)->format('d M Y H:i') : 'Waiting' }}</div></td>
                            <td class="px-4 py-3"><div>{{ $detail->approvedBy->name ?? '-' }}</div><div class="text-xs">{{ $detail->approve_date ? \Carbon\Carbon::parse($detail->approve_date)->format('d M Y H:i') : 'Waiting' }}</div></td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex justify-end gap-1">
                                    <a href="{{ route('prod.ms.master-sample.expired.edit', ['sampleId' => $masterSample->id, 'id' => $detail->id]) }}" class="p-1 text-yellow-600 hover:bg-yellow-100 rounded">✏️</a>
                                    <button wire:click="deleteExpired({{ $detail->id }})" wire:confirm="Are you sure?" class="p-1 text-red-600 hover:bg-red-100 rounded">🗑️</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center py-8">No expired history records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($details->hasPages())
            <div class="p-4 border-t">{{ $details->links() }}</div>
            @endif
        </flux:card>
    </div>
    @endif

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