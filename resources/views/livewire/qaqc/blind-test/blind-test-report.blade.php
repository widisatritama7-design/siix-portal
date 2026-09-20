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
            Blind Test Report
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Blind Test Report
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Filter and export Blind Test result by employee
            </p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-800 p-4 sm:p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

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

            <!-- Year -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Year</label>
                <select wire:model="yearFilter"
                        class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                    <option value="">All Years</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Month -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Month</label>
                <select wire:model="monthFilter"
                        class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                    <option value="">All Months</option>
                    @foreach($months as $key => $month)
                        <option value="{{ $key }}">{{ $month }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Department -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Department</label>
                <select wire:model="departmentFilter"
                        class="w-full px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}">{{ $dept }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex flex-wrap justify-end gap-2 mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
            @if($hasFiltered)
            <button wire:click="resetFilters"
                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Reset Filters
            </button>
            @endif

            <button wire:click="applyFilter"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Apply Filter
            </button>

            @if($hasFiltered)
            <button wire:click="export"
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
        <flux:card class="p-6 h-full shadow-lg flex flex-col">
            <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
                <h2 class="text-lg font-semibold text-zinc-800 dark:text-white">Filter Results</h2>
                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-xs font-medium">
                    Total: {{ number_format($totalRecords) }} employees
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
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NIK</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Department</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Fail Count</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Pass Count</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Total Soal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($previewData as $index => $item)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-4 py-3 text-sm text-center text-zinc-500 dark:text-zinc-400">
                                    {{ $previewData->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold text-zinc-800 dark:text-white">
                                    {{ $item['nik'] }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $item['name'] }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $item['department'] }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($item['fail_count'] > 0)
                                        <flux:badge size="sm" color="red">{{ $item['fail_count'] }}</flux:badge>
                                    @else
                                        <span class="text-sm text-zinc-400">0</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($item['pass_count'] > 0)
                                        <flux:badge size="sm" color="green">{{ $item['pass_count'] }}</flux:badge>
                                    @else
                                        <span class="text-sm text-zinc-400">0</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center text-sm font-semibold text-zinc-800 dark:text-white">
                                    {{ $item['total_soal'] }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-amber-50 dark:bg-amber-950/20 border-t-2 border-amber-300 dark:border-amber-700">
                                <td colspan="4" class="px-4 py-3 text-right text-sm font-bold text-zinc-800 dark:text-white">
                                    TOTAL
                                </td>
                                <td class="px-4 py-3 text-center text-sm font-bold text-red-700 dark:text-red-400">
                                    {{ number_format($totalFail) }}
                                </td>
                                <td class="px-4 py-3 text-center text-sm font-bold text-green-700 dark:text-green-400">
                                    {{ number_format($totalPass) }}
                                </td>
                                <td class="px-4 py-3 text-center text-sm font-bold text-zinc-800 dark:text-white">
                                    {{ number_format($totalSoal) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($previewData->hasPages())
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 mt-auto">
                    {{ $previewData->links() }}
                </div>
                @endif
            @endif
        </flux:card>
    @else
        <div class="flex flex-col items-center justify-center gap-3 min-h-[400px] bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-800 p-12">
            <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                <flux:icon name="no-symbol" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
            </div>
            <div class="text-center">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">No Filter Applied</h3>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Select filters above and click "Apply Filter" to view results</p>
            </div>
        </div>
    @endif

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>