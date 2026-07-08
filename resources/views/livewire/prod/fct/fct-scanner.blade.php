<div class="p-1 space-y-2">
    @section('title', 'FCT Process Scan')

    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('pcb-scan.dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            PROD
        </flux:breadcrumbs.item>
         <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            FCT
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            FCT Scan
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-md shadow-blue-500/20">
                    <!-- Microchip SVG -->
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                    </svg>
                </div>
                <span>Functional Test (FCT)</span>
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1 ml-1">
                Scan PCB barcode to start FCT process
            </p>
        </div>
        <div class="flex items-center gap-3">
            <flux:badge color="{{ $isSystemLocked ? 'red' : 'green' }}" size="sm" class="px-3 py-1.5">
                <span class="flex items-center gap-2">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $isSystemLocked ? 'bg-red-400' : 'bg-green-400' }} opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 {{ $isSystemLocked ? 'bg-red-500' : 'bg-green-500' }}"></span>
                    </span>
                    {{ $isSystemLocked ? 'Locked' : 'Online' }}
                </span>
            </flux:badge>
        </div>
    </div>

    <!-- System Locked Warning -->
    @if($isSystemLocked)
    <div class="relative overflow-hidden bg-gradient-to-r from-red-50 to-red-100/50 dark:from-red-900/30 dark:to-red-800/20 border-l-4 border-red-500 dark:border-red-400 rounded-xl p-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3 text-red-700 dark:text-red-300">
                <div class="w-8 h-8 bg-red-100 dark:bg-red-900/40 rounded-full flex items-center justify-center">
                    <!-- Lock SVG -->
                    <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div>
                    <span class="font-semibold">System Locked</span>
                </div>
            </div>
            <flux:button 
                href="{{ route('pcb-scan.leader.index') }}" 
                wire:navigate 
                size="sm" 
                variant="danger" 
                class="shadow-sm"
                id="resolveBtn"
            >
                <!-- Arrow Right SVG -->
                <svg class="inline-block w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
                Resolve Now
            </flux:button>
        </div>
    </div>
    @endif

    <!-- Main Content - Two Columns -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left Column: Scanner -->
        <div>
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-all duration-300 border-0 overflow-hidden h-full">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-blue-50/50 to-indigo-50/50 dark:from-blue-900/10 dark:to-indigo-900/10 px-6 py-4 border-b border-zinc-200/60 dark:border-zinc-700/60">
                    <div class="flex items-center gap-3">
                        <span class="font-semibold text-zinc-700 dark:text-zinc-300">FCT Scanner</span>
                        @if(!$isSystemLocked)
                        <span class="ml-auto text-xs text-green-500 flex items-center gap-1.5 bg-green-50 dark:bg-green-900/20 px-2.5 py-1 rounded-full">
                            <span class="relative flex h-1.5 w-1.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-green-500"></span>
                            </span>
                            Ready
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <!-- Scan Input -->
                    <div class="mb-6 max-w-2xl mx-auto">
                        <!-- Scan Input Container -->
                        <div class="relative group" onclick="focusScanInput()">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-indigo-500/10 dark:from-blue-500/5 dark:to-indigo-500/5 rounded-xl opacity-0 group-focus-within:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                            <div class="relative flex items-center border-2 border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden transition-all duration-300 group-focus-within:border-blue-500 dark:group-focus-within:border-blue-400 group-focus-within:shadow-lg group-focus-within:shadow-blue-500/10 cursor-text bg-white dark:bg-zinc-900">
                                <!-- Left Icon -->
                                <div class="flex items-center justify-center w-14 h-14 flex-shrink-0 bg-zinc-50 dark:bg-zinc-800/50 border-r border-zinc-200 dark:border-zinc-700">
                                    <!-- QR Code SVG -->
                                    <svg class="w-6 h-6 text-zinc-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                    </svg>
                                </div>
                                
                                <!-- Input Field -->
                                <div class="flex-1 min-w-0">
                                    <input 
                                        id="scanInput"
                                        type="text"
                                        wire:model="serialNumber"
                                        wire:keydown.enter="processScan"
                                        placeholder="Scan or type barcode here..."
                                        autofocus
                                        autocomplete="off"
                                        {{ $isSystemLocked ? 'disabled' : '' }}
                                        class="w-full h-14 px-4 text-lg bg-transparent border-0 outline-none focus:ring-0 focus:outline-none text-zinc-800 dark:text-zinc-200 placeholder:text-zinc-400 dark:placeholder:text-zinc-500 text-center"
                                    />
                                </div>
                                
                                <!-- Right Icon -->
                                <div class="flex items-center justify-center w-14 h-14 flex-shrink-0 bg-zinc-50 dark:bg-zinc-800/50 border-l border-zinc-200 dark:border-zinc-700">
                                    <!-- Arrow Right SVG -->
                                    <svg class="w-4 h-4 text-zinc-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-center gap-4 mt-3">
                            <span class="text-xs text-zinc-400 flex items-center gap-1.5">
                                <!-- Info SVG -->
                                <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Scan barcode or press Enter to validate
                            </span>
                            @if(!$isSystemLocked)
                            <span class="text-xs text-blue-400 flex items-center gap-1.5">
                                <!-- Bolt SVG -->
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Always ready
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-2 gap-3 mt-6 pt-6 border-t border-zinc-200/60 dark:border-zinc-700/60">
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-3 text-center">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Today's Scans</span>
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ count($recentScans) }}</div>
                        </div>
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-3 text-center">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Status</span>
                            <div class="text-sm font-semibold mt-1 {{ $isSystemLocked ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                <!-- Lock/Unlock SVG -->
                                @if($isSystemLocked)
                                <svg class="inline-block w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                @else
                                <svg class="inline-block w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                </svg>
                                @endif
                                {{ $isSystemLocked ? 'Locked' : 'Active' }}
                            </div>
                        </div>
                    </div>
                </div>
            </flux:card>
        </div>

        <!-- Right Column: Results & History -->
        <div>
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-all duration-300 border-0 overflow-hidden h-full">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-emerald-50/50 to-teal-50/50 dark:from-emerald-900/10 dark:to-teal-900/10 px-6 py-4 border-b border-zinc-200/60 dark:border-zinc-700/60">
                    <div class="flex items-center gap-3">
                        <span class="font-semibold text-zinc-700 dark:text-zinc-300">Scan Results</span>
                        <span class="text-[10px] font-mono bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 px-2 py-0.5 rounded-full ml-auto flex items-center gap-1 whitespace-nowrap">
                            <!-- Clock SVG -->
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $refreshTime }}
                        </span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <!-- Result Display -->
                    @if($result)
                    <div class="mb-4 animate-slideDown">
                        <div class="{{ 
                            $resultType === 'success' ? 'bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-l-4 border-green-500 dark:border-green-400' : 
                            ($resultType === 'error' ? 'bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border-l-4 border-red-500 dark:border-red-400' : 
                            ($resultType === 'warning' ? 'bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20 border-l-4 border-yellow-500 dark:border-yellow-400' : 
                            'bg-gradient-to-r from-blue-50 to-sky-50 dark:from-blue-900/20 dark:to-sky-900/20 border-l-4 border-blue-500 dark:border-blue-400')) 
                        }} px-4 py-4 rounded-r-lg flex items-center justify-between shadow-sm" role="alert">
                            <div class="flex items-center gap-3 min-w-0 flex-1">
                                @if($resultType === 'success')
                                <!-- Check Circle SVG -->
                                <svg class="w-10 h-10 text-green-500 dark:text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                @elseif($resultType === 'error')
                                <!-- X Circle SVG -->
                                <svg class="w-10 h-10 text-red-500 dark:text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                @elseif($resultType === 'warning')
                                <!-- Warning SVG -->
                                <svg class="w-10 h-10 text-yellow-500 dark:text-yellow-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                @else
                                <!-- Info SVG -->
                                <svg class="w-10 h-10 text-blue-500 dark:text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                @endif
                                <span class="text-sm font-medium text-zinc-600 dark:text-zinc-300">{{ $resultMessage }}</span>
                            </div>
                            <button wire:click="clearResult" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors p-1.5 hover:bg-white/50 dark:hover:bg-black/20 rounded-lg flex-shrink-0 ml-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endif

                    <!-- Recent Scans -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <h3 class="text-sm font-semibold text-zinc-700 dark:text-zinc-300 whitespace-nowrap">
                                    Recently Completed
                                </h3>
                                <span class="text-[10px] font-mono bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 px-2 py-0.5 rounded-full">
                                    {{ count($recentScans) }}
                                </span>
                            </div>
                        </div>
                        <div class="bg-zinc-50/80 dark:bg-zinc-800/30 rounded-xl overflow-hidden border border-zinc-200/60 dark:border-zinc-700/60 max-h-[300px] overflow-y-auto custom-scrollbar">
                            @if(count($recentScans) > 0)
                                <div class="divide-y divide-zinc-200/60 dark:divide-zinc-700/60">
                                    @foreach($recentScans as $index => $scan)
                                    <div class="flex justify-between items-center px-4 py-3 hover:bg-white/50 dark:hover:bg-zinc-800/50 transition-colors {{ $loop->first ? 'bg-white/30 dark:bg-zinc-800/30' : '' }}">
                                        <div class="flex items-center gap-3 min-w-0 flex-1">
                                            @if($loop->first)
                                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-pulse flex-shrink-0"></span>
                                            @endif
                                            <span class="font-mono text-sm font-medium text-zinc-800 dark:text-zinc-200 truncate">{{ $scan['serial_number'] }}</span>
                                            <span class="text-[10px] font-semibold text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/30 px-2 py-0.5 rounded-full flex-shrink-0">
                                                ✓ Done
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-3 flex-shrink-0 ml-2">
                                            <span class="text-xs text-zinc-400 font-mono whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($scan['created_at'])->setTimezone('Asia/Jakarta')->format('H:i:s') }}
                                            </span>
                                            <span class="text-[10px] text-zinc-400 hidden sm:inline-flex items-center gap-1 whitespace-nowrap">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($scan['created_at'])->setTimezone('Asia/Jakarta')->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="w-12 h-12 bg-zinc-200/50 dark:bg-zinc-700/30 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                    </div>
                                    <p class="text-zinc-400 text-sm font-medium">No completions today</p>
                                    <p class="text-zinc-400 text-xs mt-1">Start scanning to see results here</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </flux:card>
        </div>
    </div>

    <!-- Audio -->
    <audio id="beep-sound" src="https://www.soundjay.com/misc/sounds/bell-ringing-05.mp3" preload="auto"></audio>
    <audio id="error-sound" src="https://www.soundjay.com/misc/sounds/buzzer-1.mp3" preload="auto"></audio>

    @push('scripts')
    <script>
        // Global function untuk focus input
        function focusScanInput() {
            const input = document.getElementById('scanInput');
            if (input && !input.disabled) {
                input.focus();
                // Optional: select all text if any
                // input.select();
            }
            return input;
        }

        document.addEventListener('livewire:initialized', function () {
            // Initial focus with delay
            setTimeout(focusScanInput, 300);

            // Focus after any Livewire update
            document.addEventListener('livewire:update', function () {
                setTimeout(focusScanInput, 150);
            });

            // Focus after navigation
            document.addEventListener('livewire:navigated', function () {
                setTimeout(focusScanInput, 200);
            });

            // Focus after refreshScanner event
            @this.on('refreshScanner', function () {
                setTimeout(focusScanInput, 100);
            });

            // Focus after beep sound (success)
            @this.on('beep-sound', function () {
                document.getElementById('beep-sound')?.play();
                setTimeout(focusScanInput, 200);
            });

            // Focus after error sound
            @this.on('error-sound', function () {
                document.getElementById('error-sound')?.play();
                setTimeout(focusScanInput, 200);
            });

            // Focus after redirect
            @this.on('redirect-to-leader', function () {
                setTimeout(function() {
                    window.location.href = '{{ route("pcb-scan.leader.index") }}';
                }, 2000);
            });

            // Keyboard shortcut: Ctrl+Shift+F to focus
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.shiftKey && e.key === 'F') {
                    e.preventDefault();
                    focusScanInput();
                }
            });

            // Click anywhere on the scanner card to focus
            document.querySelector('.cursor-text')?.addEventListener('click', function(e) {
                // Don't steal focus if clicking on the input itself
                if (e.target.tagName !== 'INPUT') {
                    focusScanInput();
                }
            });

            setInterval(function() {
                @this.checkSystemLock();
                @this.loadRecentScans();
            }, 5000);
        });

        // DOM ready fallback
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(focusScanInput, 400);
        });

        // Observer untuk mendeteksi perubahan disabled state
        if (window.MutationObserver) {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'disabled') {
                        const input = document.getElementById('scanInput');
                        if (input && !input.disabled) {
                            setTimeout(focusScanInput, 100);
                        }
                    }
                });
            });

            // Mulai observer setelah DOM ready
            document.addEventListener('DOMContentLoaded', function() {
                const input = document.getElementById('scanInput');
                if (input) {
                    observer.observe(input, { attributes: true });
                }
            });
        }
    </script>
    @endpush
</div>

<style>
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-slideDown {
        animation: slideDown 0.3s ease-out;
    }
    
    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 9999px;
    }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #334155;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #475569;
    }

    /* Cursor pointer for scan area */
    .cursor-text {
        cursor: text;
    }
</style>