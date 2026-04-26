<div class="p-1 space-y-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            QA/QC
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            NCP Report
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                NCP Report
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Filter and export Non-Conformance Product data
            </p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-800 p-4 sm:p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
            <!-- Date From -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date From</label>
                <input type="date" 
                       wire:model="dateFrom" 
                       class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
            </div>
            
            <!-- Date Until -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date Until</label>
                <input type="date" 
                       wire:model="dateUntil" 
                       class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
            </div>
            
            <!-- Year Filter -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Year</label>
                <select wire:model="yearFilter" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                    <option value="">All Years</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Month Filter -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Month</label>
                <select wire:model="monthFilter" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                    <option value="">All Months</option>
                    @foreach($months as $key => $month)
                        <option value="{{ $key }}">{{ $month }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Status</label>
                <select wire:model="statusFilter" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                    <option value="">All Status</option>
                    @foreach($statuses as $key => $status)
                        <option value="{{ $key }}">{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Section Filter -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Section</label>
                <select wire:model="sectionFilter" class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                    <option value="">All Sections</option>
                    @foreach($sections as $section)
                        <option value="{{ $section }}">{{ $section }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <!-- Buttons -->
        <div class="flex flex-wrap justify-end gap-2 mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
            @if($hasFiltered)
            <button 
                wire:click="resetFilters" 
                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Reset Filters
            </button>
            @endif
            <button 
                wire:click="applyFilter" 
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Apply Filter
            </button>
            @if($hasFiltered)
            <button 
                wire:click="export" 
                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Export to Excel
            </button>
            @endif
        </div>
    </div>
    
    <!-- Preview Table -->
    @if($hasFiltered)
        <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col">
            <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-white">Filter Results</h2>
                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-xs font-medium">
                    Total: {{ number_format($totalRecords) }} records
                </span>
            </div>
            
            @if($previewData->isEmpty())
                <div class="flex flex-col items-center justify-center gap-3 min-h-[400px]">
                    <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                        <flux:icon name="document-text" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">No data found</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">No data matching the filter criteria</p>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto flex-1">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NCP Number</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Section</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Part Number</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Supplier</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Rejected Qty</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Failure Rate</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Defect Details</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Date Create</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($previewData as $index => $item)
                            @php
                                $defectDetails = is_array($item->defect_details) ? $item->defect_details : json_decode($item->defect_details, true) ?? [];
                                $defectCount = count($defectDetails);
                            @endphp
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm font-semibold text-zinc-800 dark:text-white block">
                                        {{ $item->ncp_number ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $item->section ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusColors = [
                                            'open' => 'yellow',
                                            'in_progress' => 'blue',
                                            'closed' => 'green',
                                            'rejected' => 'red',
                                        ];
                                        $statusTexts = [
                                            'open' => 'Open',
                                            'in_progress' => 'In Progress',
                                            'closed' => 'Closed',
                                            'rejected' => 'Rejected',
                                        ];
                                    @endphp
                                    <flux:badge size="sm" color="{{ $statusColors[$item->status] ?? 'gray' }}">
                                        {{ $statusTexts[$item->status] ?? ucfirst($item->status) }}
                                    </flux:badge>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $item->part_number ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $item->supplier ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ number_format($item->rejected_qty ?? 0) }}
                                </td>
                                <td class="px-4 py-3">
                                    @if($item->failure_rate)
                                        <span class="text-sm font-semibold {{ $item->failure_rate > 10 ? 'text-red-600' : ($item->failure_rate > 5 ? 'text-orange-600' : 'text-green-600') }}">
                                            {{ number_format($item->failure_rate, 2) }}%
                                        </span>
                                    @else
                                        <span class="text-sm text-zinc-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($defectCount > 0)
                                        <button 
                                            wire:click="viewDetail({{ $item->id }})"
                                            class="inline-flex items-center gap-1 px-2 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-lg text-xs hover:bg-purple-200 transition">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            {{ $defectCount }} detail(s)
                                        </button>
                                    @else
                                        <span class="text-xs text-zinc-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') : '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </flux:card>
    @else
        <div class="flex flex-col items-center justify-center gap-3 min-h-[400px] bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-800 p-12">
            <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                <flux:icon name="no-symbol" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
            </div>
            <div class="text-center"> <!-- Added text-center here -->
                <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">No Filter Applied</h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Select filters above and click "Apply Filter" to view results</p>
            </div>
        </div>
    @endif

    <!-- MODAL VIEW NCP - Menggunakan showDetailModal -->
    @if($showDetailModal && $selectedDetail)
    <div x-data="{ open: true }" 
        x-init="open = true"
        x-show="open"
        x-cloak
        @keydown.escape.window="open = false; @this.set('showDetailModal', false)">

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false; @this.set('showDetailModal', false)"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col">
                <!-- Header Modal -->
                <div class="p-6 pb-0 flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="text-xl font-bold text-zinc-800 dark:text-white">NCP Detail</h2>
                </div>
                
                <!-- Content -->
                <div class="flex-1 overflow-y-auto p-6">
                    <!-- Header Info (NCP Number & Status) -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/20 dark:to-indigo-950/20 rounded-lg border border-blue-200 dark:border-blue-800 p-4 mb-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-xs text-zinc-500 dark:text-zinc-400">NCP Number</span>
                                <p class="font-semibold text-lg text-zinc-800 dark:text-white">{{ $selectedDetail->ncp_number ?? '-' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-zinc-500 dark:text-zinc-400">Status</span>
                                <div class="mt-1">
                                    @php
                                        $statusColors = ['open' => 'yellow', 'in_progress' => 'blue', 'closed' => 'green', 'rejected' => 'red'];
                                        $statusTexts = ['open' => 'Open', 'in_progress' => 'In Progress', 'closed' => 'Closed', 'rejected' => 'Rejected'];
                                    @endphp
                                    <flux:badge size="md" color="{{ $statusColors[$selectedDetail->status] ?? 'gray' }}">
                                        {{ $statusTexts[$selectedDetail->status] ?? ucfirst($selectedDetail->status) }}
                                    </flux:badge>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 1: Product & Quality Information -->
                    <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 mb-4 shadow-sm overflow-hidden">
                        <div class="px-4 py-3 border-b" style="background-color: #cffafe;">
                            <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Product & Quality Information
                            </h3>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Part Number</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1 font-semibold">{{ $selectedDetail->part_number ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Part Description</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $selectedDetail->part_description ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Supplier</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $selectedDetail->supplier ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Customer</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $selectedDetail->customer ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Model Affected</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $selectedDetail->model_affected ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Section</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $selectedDetail->section ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Quantity Information -->
                    <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 mb-4 shadow-sm overflow-hidden">
                        <div class="px-4 py-3 border-b" style="background-color: #fed7aa;">
                            <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Quantity Information
                            </h3>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Lot No</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $selectedDetail->lot_no ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Lot Qty</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ number_format($selectedDetail->lot_qty ?? 0) }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Rejected Qty</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ number_format($selectedDetail->rejected_qty ?? 0) }}</p>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">Failure Rate</span>
                                        <p class="text-sm font-semibold {{ ($selectedDetail->failure_rate ?? 0) > 10 ? 'text-red-600' : (($selectedDetail->failure_rate ?? 0) > 5 ? 'text-orange-600' : 'text-green-600') }}">
                                            {{ number_format($selectedDetail->failure_rate ?? 0, 2) }}%
                                        </p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">DO No</span>
                                        <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $selectedDetail->do_no ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Defect Details -->
                    <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 mb-4 shadow-sm overflow-hidden">
                        <div class="px-4 py-3 border-b bg-red-50 dark:bg-red-950/20">
                            <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                Defect Details
                            </h3>
                        </div>
                        <div class="p-4">
                            @php
                                $defects = is_array($selectedDetail->defect_details) ? $selectedDetail->defect_details : json_decode($selectedDetail->defect_details, true) ?? [];
                            @endphp
                            @if(!empty($defects))
                                <div class="overflow-x-auto">
                                    <table class="w-full border border-zinc-200 dark:border-zinc-700 rounded-lg">
                                        <thead class="bg-zinc-50 dark:bg-zinc-800">
                                            <tr>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500">Serial Number</th>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500">Defect Description</th>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 w-20">Quantity</th>
                                                <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($defects as $defect)
                                            <tr class="border-t border-zinc-200 dark:border-zinc-700">
                                                <td class="px-3 py-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $defect['serial_number'] ?? '-' }}</td>
                                                <td class="px-3 py-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $defect['defect_description'] ?? '-' }}</td>
                                                <td class="px-3 py-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $defect['quantity'] ?? '-' }}</td>
                                                <td class="px-3 py-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $defect['defect_remarks'] ?? '-' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-sm text-zinc-500 text-center py-4">No defect details available</p>
                            @endif
                        </div>
                    </div>

                    <!-- Card 4: Document Information -->
                    <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 mb-4 shadow-sm overflow-hidden">
                        <div class="px-4 py-3 border-b" style="background-color: #a7f3d0;">
                            <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Document Information
                            </h3>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Packing List No/Invoice No</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $selectedDetail->packing_list_no ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Remarks</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $selectedDetail->remarks ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 5: Disposition -->
                    <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 mb-4 shadow-sm overflow-hidden">
                        <div class="px-4 py-3 border-b" style="background-color: #ddd6fe;">
                            <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Disposition
                            </h3>
                        </div>
                        <div class="p-4">
                            @php
                                $dispositionColors = [
                                    'Sorting' => 'cyan',
                                    'Rework' => 'orange',
                                    'Scrap' => 'red',
                                    'Use as it' => 'yellow',
                                    'RTV/S. (CAR/NO CAR)' => 'purple',
                                    'Others' => 'gray',
                                ];
                            @endphp
                            @if($selectedDetail->disposition)
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(', ', $selectedDetail->disposition) as $disp)
                                        @php
                                            $parts = explode(': ', $disp, 2);
                                            $type = trim($parts[0]);
                                            $detail = $parts[1] ?? null;
                                        @endphp
                                        <div class="inline-flex items-center gap-1">
                                            <flux:badge size="md" color="{{ $dispositionColors[$type] ?? 'gray' }}">
                                                {{ $type }}
                                            </flux:badge>
                                            @if($detail)
                                                <span class="text-xs text-zinc-500 dark:text-zinc-400 ml-1">: {{ $detail }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-zinc-500">-</p>
                            @endif
                        </div>
                    </div>

                    <!-- Card 6: Prepared By -->
                    <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 mb-4 shadow-sm overflow-hidden">
                        <div class="px-4 py-3 border-b" style="background-color: #fecaca;">
                            <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Prepared By
                            </h3>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">NIK</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $selectedDetail->employee->nik ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Name</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $selectedDetail->employee->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Department</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $selectedDetail->employee->department ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Section</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $selectedDetail->section ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 7: Creation Info -->
                    <div class="bg-white dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm overflow-hidden">
                        <div class="px-4 py-3 border-b" style="background-color: #fde68a;">
                            <h3 class="text-md font-semibold flex items-center gap-2 text-zinc-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Creation Information
                            </h3>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Created By</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $selectedDetail->creator->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Created At</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $selectedDetail->created_at ? \Carbon\Carbon::parse($selectedDetail->created_at)->format('d/m/Y H:i') : '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Approved By</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $selectedDetail->approver->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Updated At</span>
                                    <p class="text-sm text-zinc-800 dark:text-white mt-1">{{ $selectedDetail->updated_at ? \Carbon\Carbon::parse($selectedDetail->updated_at)->format('d/m/Y H:i') : '-' }}</p>
                                </div>
                            </div>
                            @if($selectedDetail->file)
                            <div class="mt-3 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                                <a href="{{ asset('storage/' . $selectedDetail->file) }}" target="_blank" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Download File
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Footer Buttons -->
                <div class="p-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <div class="flex justify-end gap-2">
                        <button type="button" 
                                @click="open = false; @this.set('showDetailModal', false)"
                                class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors text-zinc-700 dark:text-zinc-300">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>