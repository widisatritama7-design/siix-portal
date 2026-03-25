<div class="p-1 space-y-2">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            HR
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('hr.comelate.index') }}" wire:navigate separator="slash">
            Comelate Employee
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Comelate Report
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Comelate Report
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Filter and export employee lateness data
            </p>
        </div>
    </div>

    <!-- Filter Card -->
    <flux:card class="p-6 shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Date From -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                    Date From
                </label>
                <input 
                    type="date" 
                    wire:model="dateFrom"
                    class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white"
                >
            </div>
            
            <!-- Date Until -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                    Date Until
                </label>
                <input 
                    type="date" 
                    wire:model="dateUntil"
                    class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white"
                >
            </div>
            
            <!-- Year -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                    Year
                </label>
                <select wire:model="yearFilter" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                    <option value="">All Years</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Month -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                    Month
                </label>
                <select wire:model="monthFilter" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                    <option value="">All Months</option>
                    @foreach($months as $key => $month)
                        <option value="{{ $key }}">{{ $month }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Department -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                    Department
                </label>
                <select wire:model="departmentFilter" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}">{{ $dept }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="flex justify-end gap-2 mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
            @if($hasFiltered)
            <flux:button 
                wire:click="resetFilters" 
                variant="primary" 
                icon="arrow-path"
                class="!bg-red-600 hover:!bg-red-700 !text-white"
            >
                Reset Filters
            </flux:button>
            @endif
            <flux:button 
                wire:click="applyFilter" 
                variant="primary"
                icon="magnifying-glass"
                class="!bg-blue-600 hover:!bg-blue-700"
            >
                Apply Filter
            </flux:button>
            <flux:button 
                wire:click="export" 
                variant="primary"
                icon="arrow-down-tray"
                class="!bg-emerald-600 hover:!bg-emerald-700"
            >
                Export Data
            </flux:button>
        </div>
    </flux:card>
    
    <!-- Preview Table - Only show after filter applied -->
    @if($hasFiltered)
        <flux:card class="p-6 shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-white">
                    Filter Results
                </h2>
                <flux:badge color="blue" size="sm">
                    Total: {{ number_format($totalRecords) }} records
                </flux:badge>
            </div>
            
            @if($previewData->isEmpty())
                <div class="text-center py-12 text-zinc-500 dark:text-zinc-400">
                    <flux:icon name="document-text" class="w-12 h-12 mx-auto mb-3 opacity-50" />
                    <p>No data matching the filter criteria</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">NIK</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">Department</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">Shift</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">Schedule In</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">Actual In</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">Late (Minutes)</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">Reason</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">Security</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">Date</th>
                               </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($previewData as $item)
                            @php
                                $statusCode = $item->employee->status ?? $item->status;
                                $statusText = match((int)$statusCode) {
                                    1 => 'Permanent',
                                    2 => 'Contract',
                                    3 => 'Magang',
                                    default => 'Unknown',
                                };
                                $statusColor = match((int)$statusCode) {
                                    1 => 'green',
                                    2 => 'yellow',
                                    3 => 'purple',
                                    default => 'gray',
                                };
                            @endphp
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-4 py-3 text-sm font-mono">
                                    {{ $item->employee->nik ?? $item->nik }}
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold">
                                    {{ $item->employee->name ?? $item->name }}
                                </td>
                                <td class="px-4 py-3">
                                    <flux:badge size="sm" color="gray" variant="subtle">
                                        {{ $item->employee->department ?? $item->department }}
                                    </flux:badge>
                                </td>
                                <td class="px-4 py-3">
                                    <flux:badge size="sm" :color="$statusColor">
                                        {{ $statusText }}
                                    </flux:badge>
                                </td>
                                <td class="px-4 py-3">
                                    <flux:badge size="sm" color="blue" variant="subtle">
                                        {{ match($item->shift) {
                                            'NS' => 'Non Shift',
                                            '1' => 'Shift 1',
                                            '2' => 'Shift 2',
                                            '3' => 'Shift 3',
                                            default => $item->shift ?? '-',
                                        } }}
                                    </flux:badge>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $item->jam_masuk ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $item->jam ? \Carbon\Carbon::parse($item->jam)->format('H:i') : '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <flux:badge size="sm" :color="$item->count_jam > 0 ? 'yellow' : 'green'">
                                        @php
                                            $minutes = $item->count_jam;
                                            if(!$minutes || $minutes == 0) echo '-';
                                            elseif($minutes >= 60) echo floor($minutes / 60) . 'h ' . ($minutes % 60) . 'm';
                                            else echo $minutes . 'm';
                                        @endphp
                                    </flux:badge>
                                </td>
                                <td class="px-4 py-3 text-sm max-w-xs truncate" title="{{ $item->alasan_terlambat }}">
                                    {{ Str::limit($item->alasan_terlambat, 30) }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $item->nama_security }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                </td>
                             </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </flux:card>
    @else
        <!-- Empty State - No data shown until filter applied -->
        <flux:card class="p-12 shadow-lg text-center">
            <flux:icon name="funnel" class="w-16 h-16 mx-auto mb-4 text-zinc-400 dark:text-zinc-500 opacity-50" />
            <h3 class="text-lg font-medium text-zinc-800 dark:text-white mb-2">
                No Filter Applied
            </h3>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Select filters above and click "Apply Filter" to view results
            </p>
        </flux:card>
    @endif
</div>