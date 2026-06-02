<div class="p-1 space-y-2">
    @section('title', 'Attendance Report Details')
    
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">HR</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Attendance</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('prod.absence.report.index') }}" wire:navigate separator="slash">Report</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Details</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">Attendance Report Details</h1>
            <div class="flex items-center gap-2 mt-1">
                <span class="text-sm text-zinc-500">{{ $report->report_number }}</span>
                @php
                    $statusConfig = [
                        'draft' => ['color' => 'gray', 'bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => ''],
                        'checked' => ['color' => 'blue', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => ''],
                        'approved' => ['color' => 'yellow', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'icon' => ''],
                        'accepted' => ['color' => 'green', 'bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => ''],
                    ];
                @endphp
                <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full {{ $statusConfig[$report->status]['bg'] }} {{ $statusConfig[$report->status]['text'] }}">
                    <span>{{ ucfirst($report->status) }}</span>
                </span>
            </div>
        </div>
        <div class="flex gap-2">
            @if($report->status === 'draft')
            <a href="{{ route('prod.absence.report.edit', $report->id) }}" wire:navigate 
                class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                Edit Report
            </a>
            @endif
            <a href="{{ route('prod.absence.report.index') }}" wire:navigate 
                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info Card -->
        <flux:card class="p-6 lg:col-span-2 shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-zinc-200 dark:border-zinc-700">
                
                <!-- Kiri -->
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                        {{ strtoupper(substr($report->report_number, 0, 1)) }}
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold text-zinc-800 dark:text-white">
                            Report Information
                        </h2>
                    </div>
                </div>

                <!-- Kanan -->
                <div class="text-right">
                    <p class="font-medium text-zinc-800 dark:text-white">
                        Prepared By : {{ $report->created_by }}
                    </p>

                    <p class="text-xs text-zinc-400">
                        {{ $report->created_at ? $report->created_at->format('d M Y H:i') : '-' }}
                    </p>
                </div>

            </div>
            
            <!-- Items Table -->
            <div class="mt-4">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-md font-semibold text-zinc-800 dark:text-white">Employee List</h3>
                    <span class="text-xs text-zinc-500 bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded-full">
                        Total: {{ count($itemsDetail) }} employee(s)
                    </span>
                </div>
                <div class="overflow-x-auto overflow-y-auto max-h-[400px] rounded-lg border border-zinc-200 dark:border-zinc-700">
                    <table class="min-w-max w-full text-sm whitespace-nowrap">
                        <thead class="bg-zinc-50 dark:bg-zinc-800">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">NIK</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">NAME</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">DEPT</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">GROUP</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">LINE</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">JENIS KETIDAKHADIRAN</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">KETERANGAN</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($itemsDetail as $item)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                
                                <td class="px-4 py-3 font-mono text-xs">
                                    {{ $item['employee_nik'] }}
                                </td>

                                <td class="px-4 py-3 font-mono text-xs">
                                    {{ $item['employee_name'] }}
                                </td>

                                <td class="px-4 py-3 font-mono text-xs">
                                    {{ $item['employee_department'] }}
                                </td>

                                <td class="px-4 py-3 font-mono text-xs">
                                    {{ $item['group'] }}
                                </td>

                                <td class="px-4 py-3 font-mono text-xs">
                                    {{ $item['line'] }}
                                </td>

                                <td class="px-4 py-3 font-mono text-xs">
                                    @php
                                        // Mapping jenis ketidakhadiran ke tampilan dan warna
                                        $jenisMapping = [
                                            'SD' => ['display' => 'SD : Sakit Dengan Surat Dokter', 'color' => 'bg-red-100 text-red-700'],
                                            'IJ' => ['display' => 'IJ : Izin Pribadi', 'color' => 'bg-blue-100 text-blue-700'],
                                            'A' => ['display' => 'A : Tidak Hadir Tanpa Keterangan', 'color' => 'bg-gray-100 text-gray-700'],
                                            'CT' => ['display' => 'CT : Cuti Tahunan', 'color' => 'bg-green-100 text-green-700'],
                                            'CK' => ['display' => 'CK : Cuti Keguguran', 'color' => 'bg-pink-100 text-pink-700'],
                                            'CM' => ['display' => 'CM : Cuti Melahirkan', 'color' => 'bg-purple-100 text-purple-700'],
                                        ];

                                        $jenis = $item['jenis_ketidakhadiran'];
                                        $display = $jenisMapping[$jenis]['display'] ?? $jenis;
                                        $colorClass = $jenisMapping[$jenis]['color'] ?? 'bg-gray-100 text-gray-700';
                                    @endphp

                                    <span class="inline-flex px-2 py-1 font-mono text-xs rounded-full {{ $colorClass }}">
                                        {{ $display }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 font-mono text-xs text-zinc-500">
                                    {{ $item['keterangan'] ?? '-' }}
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </flux:card>

        <!-- Approval Flow Card -->
        <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-zinc-200 dark:border-zinc-700">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                    ✓
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-zinc-800 dark:text-white">Approval Flow</h2>
                    <p class="text-xs text-zinc-500">Track approval progress</p>
                </div>
            </div>

            <div class="space-y-4">
                <!-- Step 1: Check -->
                <div class="flex items-center gap-4 p-4 rounded-xl {{ $report->check_by ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800' : 'bg-gray-50 dark:bg-gray-800/30' }} transition-all">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm {{ $report->check_by ? 'bg-green-500' : 'bg-gray-400' }} shadow-md">
                        1
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <p class="font-semibold text-zinc-800 dark:text-white">Check</p>
                            @if($report->check_by)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-green-500">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                        @if($report->check_by)
                            <p class="text-sm text-green-600 dark:text-green-400">By : {{ $report->check_by }}</p>
                            <p class="text-xs text-zinc-500">{{ $report->check_at ? $report->check_at->format('d M Y H:i') : '-' }}</p>
                        @else
                            <p class="text-sm text-gray-500">Waiting for check</p>
                        @endif
                    </div>
                    @can('check absence report')
                        @if($report->status === 'draft' && !$report->check_by)
                        <button wire:click="check" wire:loading.attr="disabled" 
                            class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                            <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <svg wire:loading class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove>Check</span>
                            <span wire:loading>Processing...</span>
                        </button>
                        @endif
                    @endcan
                </div>

                <!-- Step 2: Approve -->
                <div class="flex items-center gap-4 p-4 rounded-xl {{ $report->approved_by ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800' : ($report->check_by ? 'bg-yellow-50 dark:bg-yellow-900/20' : 'bg-gray-50 dark:bg-gray-800/30') }} transition-all">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm {{ $report->approved_by ? 'bg-green-500' : ($report->check_by ? 'bg-yellow-500' : 'bg-gray-400') }} shadow-md">
                        2
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <p class="font-semibold text-zinc-800 dark:text-white">Approve</p>
                            @if($report->approved_by)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-green-500">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                        @if($report->approved_by)
                            <p class="text-sm text-green-600 dark:text-green-400">By : {{ $report->approved_by }}</p>
                            <p class="text-xs text-zinc-500">{{ $report->approved_at ? $report->approved_at->format('d M Y H:i') : '-' }}</p>
                        @elseif($report->check_by)
                            <p class="text-sm text-yellow-600 dark:text-yellow-400">Ready to approve</p>
                        @else
                            <p class="text-sm text-gray-500">Waiting for check first</p>
                        @endif
                    </div>
                    @can('approve absence report')
                        @if($report->status === 'checked' && !$report->approved_by)
                        <button wire:click="approve" wire:loading.attr="disabled"
                            class="px-4 py-2 bg-yellow-600 text-white text-sm rounded-lg hover:bg-yellow-700 transition-colors flex items-center gap-2">
                            <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            <svg wire:loading class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove>Approve</span>
                            <span wire:loading>Sending Email...</span>
                        </button>
                        @endif
                    @endcan
                </div>

                <!-- Step 3: Accept -->
                <div class="flex items-center gap-4 p-4 rounded-xl {{ $report->accepted_by ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800' : ($report->approved_by ? 'bg-blue-50 dark:bg-blue-900/20' : 'bg-gray-50 dark:bg-gray-800/30') }} transition-all">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm {{ $report->accepted_by ? 'bg-green-500' : ($report->approved_by ? 'bg-blue-500' : 'bg-gray-400') }} shadow-md">
                        3
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <p class="font-semibold text-zinc-800 dark:text-white">Accept</p>
                            @if($report->accepted_by)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-green-500">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                        @if($report->accepted_by)
                            <p class="text-sm text-green-600 dark:text-green-400">By : {{ $report->accepted_by }}</p>
                            <p class="text-xs text-zinc-500">{{ $report->accepted_at ? $report->accepted_at->format('d M Y H:i') : '-' }}</p>
                        @elseif($report->approved_by)
                            <p class="text-sm text-blue-600 dark:text-blue-400">Ready to accept</p>
                        @else
                            <p class="text-sm text-gray-500">Waiting for approve first</p>
                        @endif
                    </div>
                    @can('accept absence report')
                        @if($report->status === 'approved' && !$report->accepted_by)
                        <button wire:click="accept" wire:loading.attr="disabled"
                            class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                            <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <svg wire:loading class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove>Accept</span>
                            <span wire:loading>Processing...</span>
                        </button>
                        @endif
                    @endcan
                </div>
            </div>
        </flux:card>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>