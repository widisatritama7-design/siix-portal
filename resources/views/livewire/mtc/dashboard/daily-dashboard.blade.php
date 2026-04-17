<section class="w-full">
    @include('partials.mtc-heading')

    <flux:heading class="sr-only">
        {{ __('MTC - Daily Dashboard') }}
    </flux:heading>

    <x-mtc.layout class="!max-w-full !px-0 !mx-0">
        <x-slot name="heading">
            <div class="w-full">
                <flux:breadcrumbs class="mb-1">
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
                        Dashboard
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        Maintenance
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        Daily Monitoring
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-zinc-800 dark:text-white">
                            Daily Monitoring
                        </h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-sm text-zinc-500 whitespace-nowrap">
                            Total Lines: <span class="font-bold text-lg text-blue-600">{{ count($masterLines) }}</span>
                        </div>
                        <button wire:click="$refresh" 
                                wire:loading.attr="disabled"
                                class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 text-sm font-medium text-zinc-700 bg-white border border-zinc-300 rounded-lg hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-600 dark:hover:bg-zinc-700 transition-colors whitespace-nowrap">
                            <svg wire:loading.remove wire:target="$refresh" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <svg wire:loading wire:target="$refresh" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="hidden sm:inline">Refresh</span>
                        </button>
                    </div>
                </div>
            </div>
        </x-slot>

        <div class="-mt-2" wire:poll.10s>
            <!-- Stats Cards - Responsive Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 mb-6">
                <!-- Checked Card -->
                <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-3 sm:p-4 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/80 text-xs sm:text-sm">Checked</p>
                            <p class="text-white text-2xl sm:text-3xl font-bold">{{ $stats['checked'] }}</p>
                        </div>
                        <div class="bg-white/20 p-2 sm:p-3 rounded-lg">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- On Progress Card -->
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl p-3 sm:p-4 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/80 text-xs sm:text-sm">On Progress</p>
                            <p class="text-white text-2xl sm:text-3xl font-bold">{{ $stats['on_progress'] }}</p>
                        </div>
                        <div class="bg-white/20 p-2 sm:p-3 rounded-lg">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Delay Card -->
                <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-xl p-3 sm:p-4 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/80 text-xs sm:text-sm">Delay</p>
                            <p class="text-white text-2xl sm:text-3xl font-bold">{{ $stats['delay'] }}</p>
                        </div>
                        <div class="bg-white/20 p-2 sm:p-3 rounded-lg">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Approved Card -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-3 sm:p-4 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/80 text-xs sm:text-sm">Approved</p>
                            <p class="text-white text-2xl sm:text-3xl font-bold">{{ $stats['approved'] }}</p>
                        </div>
                        <div class="bg-white/20 p-2 sm:p-3 rounded-lg">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pending Card -->
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-3 sm:p-4 shadow-lg col-span-2 sm:col-span-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/80 text-xs sm:text-sm">Pending</p>
                            <p class="text-white text-2xl sm:text-3xl font-bold">{{ $stats['pending'] }}</p>
                        </div>
                        <div class="bg-white/20 p-2 sm:p-3 rounded-lg">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Line Cards - Dengan Horizontal Scroll untuk Mobile -->
            @if(count($masterLines) > 0)
                @php
                    $chunks = $masterLines->chunk(ceil($masterLines->count() / 2));
                @endphp

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($chunks as $chunkIndex => $chunk)
                    <div class="space-y-3">
                        <!-- Header Kolom -->
                        <div class="bg-zinc-100 dark:bg-zinc-800 rounded-lg p-3 border border-zinc-200 dark:border-zinc-700">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-zinc-700 dark:text-zinc-300 text-sm sm:text-base">
                                    @if($chunkIndex == 0)
                                        SMT 1 - 9
                                    @else
                                        SMT 10 - 17
                                    @endif
                                </span>
                                <span class="text-xs text-zinc-500 bg-white dark:bg-zinc-900 px-2 py-1 rounded-full">
                                    {{ $chunk->count() }} Lines
                                </span>
                            </div>
                        </div>

                        <!-- Table dengan Horizontal Scroll -->
                        <div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-700">
                            <div class="min-w-[800px]">
                                <!-- Header -->
                                <div class="grid grid-cols-12 gap-2 px-3 py-3 bg-zinc-50 dark:bg-zinc-800/50 text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider border-b border-zinc-200 dark:border-zinc-700">
                                    <div class="col-span-2">Line</div>
                                    <div class="col-span-2 text-center">Status</div>
                                    <div class="col-span-2 text-center">Daily Check</div>
                                    <div class="col-span-2 text-center">Approval</div>
                                    <div class="col-span-2 text-center">Check By</div>
                                    <div class="col-span-2 text-center">Approve By</div>
                                </div>

                                <!-- Rows -->
                                @foreach($chunk as $line)
                                <div class="grid grid-cols-12 gap-2 items-center px-3 py-3 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors cursor-pointer border-b border-zinc-100 dark:border-zinc-700 last:border-b-0"
                                     onclick="openLineModal({{ $line->id }})">
                                    
                                    <!-- Line Number -->
                                    <div class="col-span-2 flex items-center gap-1 sm:gap-2">
                                        <div class="w-8 h-6 bg-blue-500 rounded-lg flex items-center justify-center text-white font-bold text-xs shadow-md">
                                            SMT
                                        </div>
                                        <span class="font-semibold text-zinc-900 dark:text-white text-xs sm:text-sm whitespace-nowrap">Line {{ $line->line_number }}</span>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-span-2 flex justify-center">
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium whitespace-nowrap {{ $this->getStatusColor($line->status) }}">
                                            {{ $line->status }}
                                        </span>
                                    </div>

                                    <!-- Daily Check -->
                                    <div class="col-span-2 flex justify-center">
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium whitespace-nowrap {{ $this->getDailyCheckColor($line->daily_check_status) }}">
                                            @if($line->daily_check_status === 'On Progress')
                                                <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            @endif
                                            {{ $line->daily_check_status }}
                                        </span>
                                    </div>

                                    <!-- Approval -->
                                    <div class="col-span-2 flex justify-center">
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium whitespace-nowrap {{ $this->getApprovalColor($line->daily_check_approval) }}">
                                            {{ $line->daily_check_approval }}
                                        </span>
                                    </div>

                                    <!-- Check By -->
                                    <div class="col-span-2 text-center">
                                        <span class="text-xs font-medium text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-700 px-2 py-1 rounded-full whitespace-nowrap">
                                            {{ $line->daily_check_by }}
                                        </span>
                                    </div>

                                    <!-- Approve By -->
                                    <div class="col-span-2 text-center">
                                        <span class="text-xs font-medium text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-700 px-2 py-1 rounded-full whitespace-nowrap">
                                            {{ $line->daily_approved_by }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Footer - Responsive -->
                <div class="mt-6 px-3 sm:px-4 py-3 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 flex flex-col sm:flex-row justify-between items-center gap-3">
                    <div class="flex flex-wrap items-center gap-4 justify-center sm:justify-start">
                        <span>Showing <strong>{{ count($masterLines) }}</strong> lines</span>
                        <span class="hidden sm:inline w-px h-4 bg-zinc-300 dark:bg-zinc-600"></span>
                        <span>Last updated: {{ now()->format('d M Y H:i:s') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span>Live updates every 10 seconds</span>
                    </div>
                </div>
            @else
                <div class="text-center py-12 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                    <svg class="w-16 h-16 mx-auto text-zinc-400 dark:text-zinc-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-zinc-500 dark:text-zinc-400 font-medium">No production lines with daily checks found.</p>
                    <p class="text-zinc-400 dark:text-zinc-500 text-sm mt-1">Data will appear once daily checks are created.</p>
                </div>
            @endif
        </div>
    </x-mtc.layout>

    <!-- Modal Detail Line -->
    <div x-data="{ show: false, line: null }" 
         x-show="show" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="fixed inset-0 bg-black/50" @click="show = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md mx-4" @click.stop>
                <div class="flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700 px-4 sm:px-6 py-4">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Line Details</h3>
                    <button @click="show = false" class="text-zinc-500 hover:text-zinc-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-4 sm:p-6" id="modalContent">
                    <!-- Content diisi JavaScript -->
                </div>
                <div class="flex justify-end border-t border-zinc-200 dark:border-zinc-700 px-4 sm:px-6 py-4">
                    <button @click="show = false" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 3s linear infinite;
        }
        
        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        .dark .overflow-x-auto::-webkit-scrollbar-track {
            background: #3f3f46;
        }
        .dark .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #52525b;
        }
        .dark .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #71717a;
        }
    </style>

    @push('scripts')
    <script>
        let masterLinesData = @json($masterLines);
        
        function openLineModal(lineId) {
            const line = masterLinesData.find(l => l.id === lineId);
            
            if (!line) return;
            
            const html = `
                <div class="space-y-4">
                    <div class="bg-zinc-50 dark:bg-zinc-800 rounded-lg p-4">
                        <h4 class="text-lg font-bold text-zinc-900 dark:text-white">Line ${line.line_number}</h4>
                        <p class="text-sm text-zinc-500">${line.location?.location_name || 'No Location'}</p>
                        <div class="flex flex-wrap gap-2 mt-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium ${line.status === 'Running' ? 'bg-green-100 text-green-800' : (line.status === 'Maintenance' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')}">${line.status}</span>
                            <span class="px-2 py-1 rounded-full text-xs font-medium ${line.daily_check_status === 'Checked' ? 'bg-green-100 text-green-800' : (line.daily_check_status === 'On Progress' ? 'bg-yellow-100 text-yellow-800' : (line.daily_check_status === 'Delay' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))}">${line.daily_check_status}</span>
                            <span class="px-2 py-1 rounded-full text-xs font-medium ${line.daily_check_approval === 'Approved' ? 'bg-green-100 text-green-800' : (line.daily_check_approval === 'Pending' ? 'bg-yellow-100 text-yellow-800' : (line.daily_check_approval === 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))}">${line.daily_check_approval}</span>
                        </div>
                    </div>
                    
                    <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg divide-y divide-zinc-200 dark:divide-zinc-700">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 gap-2">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Checked By</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-white">${line.daily_check_by || '-'}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 gap-2">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Approved By</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-white">${line.daily_approved_by || '-'}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 gap-2">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Group</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-white">${line.daily_check_group || '-'}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 gap-2">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Last Check</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-white">${line.last_check_time ? new Date(line.last_check_time).toLocaleString('id-ID') : '-'}</span>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('modalContent').innerHTML = html;
            
            // Buka modal
            const modal = document.querySelector('[x-data="{ show: false, line: null }"]');
            if (modal && modal.__x) {
                modal.__x.$data.show = true;
            }
        }
    </script>
    @endpush
</section>