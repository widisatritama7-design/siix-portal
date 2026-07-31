<div class="p-1 space-y-2">
    @section('title', 'Uniform Request')
    
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">HR</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Uniform</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Request Uniform</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">Request Uniform</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Manage uniform requests</p>
        </div>

        <div class="flex items-center gap-2">
            <!-- Bulk Action Button -->
            @if(count($selectedRequests) > 0)
                <button wire:click="openBulkModal" 
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 dark:bg-purple-700 dark:hover:bg-purple-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    View All Items For Request ({{ count($selectedRequests) }})
                </button>
            @endif

            @can('create uniform request')
                @php
                    $sessionId = session()->getId();
                    
                    // Cek lock untuk create mode (request_id = null)
                    $createLock = \App\Models\PROD\Uniform\UniformRequestLock::whereNull('request_id')
                        ->where('expires_at', '>', now())
                        ->first();
                    
                    // Cek lock untuk edit mode (request_id != null) - ADA USER SEDANG EDIT
                    $editLock = \App\Models\PROD\Uniform\UniformRequestLock::whereNotNull('request_id')
                        ->where('expires_at', '>', now())
                        ->first();
                    
                    // Cek apakah user sendiri sedang edit
                    $isOwnEditLock = $editLock && $editLock->session_id === $sessionId;
                    
                    // Locked jika ada lock create (bukan milik sendiri) 
                    // ATAU ada lock edit dari user lain
                    // ATAU user sendiri sedang edit (harus end session dulu)
                    $isCreateLocked = $createLock && $createLock->session_id !== $sessionId;
                    $isEditLocked = $editLock && $editLock->session_id !== $sessionId;
                    
                    // Gabungkan: jika ada lock create ATAU ada lock edit (termasuk sendiri)
                    $isLocked = $isCreateLocked || $isEditLocked || $isOwnEditLock;
                    
                    // Lock milik sendiri (create)
                    $isOwnLock = $createLock && $createLock->session_id === $sessionId;
                    
                    // Ambil informasi lock (prioritaskan yang ada)
                    if ($isCreateLocked) {
                        $lockExpiresAt = $createLock->expires_at->timestamp;
                        $lockUserName = $createLock->user_name;
                        $lockMessage = 'Sedang ada yang membuat request';
                        $lockId = null; // Untuk end session
                    } elseif ($isEditLocked) {
                        $lockExpiresAt = $editLock->expires_at->timestamp;
                        $lockUserName = $editLock->user_name;
                        $lockMessage = 'Sedang ada yang mengedit request';
                        $lockId = $editLock->id;
                    } elseif ($isOwnEditLock) {
                        $lockExpiresAt = $editLock->expires_at->timestamp;
                        $lockUserName = $editLock->user_name;
                        $lockMessage = 'Anda sedang mengedit request. End session dulu untuk membuat request baru.';
                        $lockId = $editLock->id;
                    } else {
                        $lockExpiresAt = null;
                        $lockUserName = null;
                        $lockMessage = '';
                        $lockId = null;
                    }
                @endphp
                
                <div class="flex items-center gap-2">
                    @if($isLocked)
                        <!-- Locked - tampilkan user + countdown + tombol disabled + tombol End Session (jika milik sendiri) -->
                        <div x-data="{ 
                            expiresAt: {{ $lockExpiresAt }},
                            timeLeft: 0,
                            interval: null,
                            init() {
                                this.updateTimer();
                                this.interval = setInterval(() => this.updateTimer(), 1000);
                            },
                            updateTimer() {
                                const now = Math.floor(Date.now() / 1000);
                                const diff = this.expiresAt - now;
                                this.timeLeft = diff > 0 ? diff : 0;
                                if (this.timeLeft <= 0 && this.interval) {
                                    clearInterval(this.interval);
                                    this.interval = null;
                                    window.location.reload();
                                }
                            },
                            formatTime(seconds) {
                                const mins = Math.floor(seconds / 60);
                                const secs = seconds % 60;
                                return `${mins}:${secs.toString().padStart(2, '0')}`;
                            }
                        }" 
                        x-init="init()"
                        class="flex items-center gap-2">
                            <!-- User Info + Countdown -->
                            <div class="flex items-center gap-2 {{ $isOwnEditLock ? 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800' : 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800' }} border rounded-lg px-3 py-2 h-10">
                                <!-- User Avatar/Icon -->
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 {{ $isOwnEditLock ? 'text-yellow-500' : 'text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="text-xs {{ $isOwnEditLock ? 'text-yellow-700 dark:text-yellow-300' : 'text-red-700 dark:text-red-300' }} font-medium">
                                        {{ $isOwnEditLock ? 'You:' : 'Used By:' }}
                                    </span>
                                    <span class="text-xs font-bold {{ $isOwnEditLock ? 'text-yellow-800 dark:text-yellow-200' : 'text-red-800 dark:text-red-200' }}">{{ $lockUserName }}</span>
                                </div>
                                <div class="w-px h-6 {{ $isOwnEditLock ? 'bg-yellow-300 dark:bg-yellow-700' : 'bg-red-300 dark:bg-red-700' }}"></div>
                                <!-- Countdown -->
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 {{ $isOwnEditLock ? 'text-yellow-500' : 'text-red-500' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor"/>
                                        <polyline points="12 6 12 12 16 14" stroke="currentColor"/>
                                    </svg>
                                    <span x-text="formatTime(timeLeft)" class="font-mono font-bold {{ $isOwnEditLock ? 'text-yellow-700 dark:text-yellow-300' : 'text-red-700 dark:text-red-300' }} tabular-nums"></span>
                                </div>
                            </div>
                            
                            <!-- Tombol End Session (hanya untuk lock milik sendiri - edit) -->
                            @if($isOwnEditLock)
                                <button wire:click="endEditSession"
                                    wire:confirm="Are you sure you want to end your edit session? All unsaved changes will be lost."
                                    class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 rounded-lg transition-colors shadow-md hover:shadow-lg h-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                        <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm10.72 4.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H9a.75.75 0 0 1 0-1.5h10.94l-1.72-1.72a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="hidden sm:inline">End Session</span>
                                    <span class="sm:hidden">End</span>
                                </button>
                            @endif
                            
                            <!-- Tombol Locked -->
                            <div x-data="{ showTooltip: false }" class="relative inline-block">
                                <button disabled
                                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-gray-400 rounded-lg cursor-not-allowed opacity-60 dark:bg-gray-600 h-10">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    New Request
                                </button>
                                
                                <!-- Tooltip -->
                                <div x-show="showTooltip" 
                                    x-on:mouseenter="showTooltip = true" 
                                    x-on:mouseleave="showTooltip = false"
                                    @click.away="showTooltip = false"
                                    class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 z-50 w-64 p-3 bg-zinc-800 text-white text-xs rounded-lg shadow-lg text-center">
                                    <p class="font-semibold flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        {{ $lockMessage }}
                                    </p>
                                    <p class="mt-1">Oleh: <strong class="text-blue-400">{{ $lockUserName }}</strong></p>
                                    <div class="mt-2 pt-2 border-t border-zinc-700">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                                <polyline points="12 6 12 12 16 14" stroke="currentColor"/>
                                            </svg>
                                            <span class="text-zinc-400">Sisa waktu:</span>
                                            <span class="font-mono font-bold text-green-400 text-sm" x-text="formatTime(timeLeft)"></span>
                                        </div>
                                    </div>
                                    <div class="absolute -bottom-1.5 left-1/2 transform -translate-x-1/2 rotate-45 w-3 h-3 bg-zinc-800"></div>
                                    
                                    @can('feedback uniform request admin')
                                        <div class="mt-2 pt-2 border-t border-zinc-700">
                                            <button wire:click="forceReleaseAllLocks()" 
                                                onclick="if(confirm('Yakin ingin melepas semua lock secara paksa?')){ @this.call('forceReleaseAllLocks') }"
                                                class="text-xs text-red-400 hover:text-red-300 transition-colors flex items-center justify-center gap-1 w-full">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                </svg>
                                                Force Release All Locks (Admin)
                                            </button>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </div>

                    @elseif($isOwnLock)
                        <!-- Lock milik sendiri (create) - tampilkan user + countdown hijau + tombol aktif -->
                        <div x-data="{ 
                            expiresAt: {{ $createLock ? $createLock->expires_at->timestamp : 'null' }},
                            timeLeft: 0,
                            interval: null,
                            init() {
                                if (this.expiresAt) {
                                    this.updateTimer();
                                    this.interval = setInterval(() => this.updateTimer(), 1000);
                                }
                            },
                            updateTimer() {
                                const now = Math.floor(Date.now() / 1000);
                                const diff = this.expiresAt - now;
                                this.timeLeft = diff > 0 ? diff : 0;
                                if (this.timeLeft <= 0 && this.interval) {
                                    clearInterval(this.interval);
                                    this.interval = null;
                                    window.location.reload();
                                }
                            },
                            formatTime(seconds) {
                                const mins = Math.floor(seconds / 60);
                                const secs = seconds % 60;
                                return `${mins}:${secs.toString().padStart(2, '0')}`;
                            }
                        }" 
                        x-init="init()"
                        class="flex items-center gap-2">
                            <!-- User Info + Countdown Hijau -->
                            <div class="flex items-center gap-2 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg px-3 py-2 h-10">
                                <!-- User Avatar/Icon -->
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="text-xs text-green-700 dark:text-green-300 font-medium">You:</span>
                                    <span class="text-xs font-bold text-green-800 dark:text-green-200">{{ auth()->user()->name }}</span>
                                </div>
                                <div class="w-px h-6 bg-green-300 dark:bg-green-700"></div>
                                <!-- Countdown -->
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-green-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor"/>
                                        <polyline points="12 6 12 12 16 14" stroke="currentColor"/>
                                    </svg>
                                    <span x-text="formatTime(timeLeft)" class="font-mono font-bold text-green-700 dark:text-green-300 tabular-nums"></span>
                                </div>
                            </div>
                            
                            <!-- Tombol Aktif -->
                            <flux:button variant="primary" icon="plus-circle" href="{{ route('prod.uniform.request.create') }}" wire:navigate class="h-10">
                                New Request
                            </flux:button>
                        </div>

                    @else
                        <!-- Tidak ada lock - tombol normal -->
                        <flux:button variant="primary" icon="plus-circle" href="{{ route('prod.uniform.request.create') }}" wire:navigate class="h-10">
                            New Request
                        </flux:button>
                    @endif
                </div>
            @endcan
        </div>
    </div>

    <!-- Filters -->
    <div class="space-y-2">
        {{-- BARIS ATAS: Search + Date --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
            <div class="lg:col-span-2">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search by request #..."
                    icon="magnifying-glass"
                    clearable
                />
            </div>

            <div>
                <input type="date" 
                    wire:model.live="dateFrom"
                    class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-zinc-700 dark:text-zinc-300">
            </div>

            <div>
                <input type="date" 
                    wire:model.live="dateTo"
                    class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-zinc-700 dark:text-zinc-300">
            </div>
        </div>

        {{-- BARIS BAWAH: Semua Filter --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
            <div>
                <select wire:model.live="adminFeedbackFilter" 
                    class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-zinc-700 dark:text-zinc-300">
                    <option value="">All Admin Feedback</option>
                    <option value="Open">Open</option>
                    <option value="On Process">On Process</option>
                    <option value="Checked">Checked</option>
                </select>
            </div>

            <div>
                <select wire:model.live="verificationFilter" 
                    class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-zinc-700 dark:text-zinc-300">
                    <option value="">All Verification</option>
                    <option value="Waiting">Waiting</option>
                    <option value="On Process">On Process</option>
                    <option value="Approved">Approved</option>
                    <option value="Completed">Completed</option>
                    <option value="N/A">N/A</option>
                </select>
            </div>

            <div>
                <select wire:model.live="misscStatusFilter" 
                    class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-zinc-700 dark:text-zinc-300">
                    <option value="">All MISSC Status</option>
                    <option value="Waiting">Waiting</option>
                    <option value="On Process">On Process</option>
                    <option value="Accepted">Accepted</option>
                </select>
            </div>

            <div>
                <select wire:model.live="signatureFilter" 
                    class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-zinc-700 dark:text-zinc-300">
                    <option value="">All Signature</option>
                    <option value="Waiting">Waiting</option>
                    <option value="On Process">On Process</option>
                    <option value="Signed">Signed</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
        </div>
    </div>

    @if($adminFeedbackFilter|| $misscStatusFilter || $verificationFilter || $signatureFilter || $dateFrom || $dateTo || $search)
        <div class="flex justify-end">
            <button wire:click="resetFilters" 
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Reset Filters
            </button>
        </div>
    @endif

    <!-- Uniform Request Table -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="overflow-x-auto">
            <table class="w-full" style="min-width: max-content;">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-2 py-3 text-center">
                            @php
                                // Hitung total request yang bisa di-select
                                $selectableIds = [];
                                foreach($requests as $req) {
                                    // Cek missc_status
                                    if (isset($req->missc_status) && $req->missc_status === 'On Process') {
                                        $items = $req->items ?? [];
                                        foreach ($items as $item) {
                                            // ============ GUNAKAN NULL COALESCING UNTUK AMAN ============
                                            $isManual = isset($item['is_manual']) && $item['is_manual'] === true;
                                            $isNewEmployee = isset($item['reason_type']) && $item['reason_type'] === 'new_employee';
                                            $verificationStatus = $item['verification_status'] ?? null;
                                            
                                            // Manual atau New Employee -> LANGSUNG BISA
                                            if ($isManual || $isNewEmployee) {
                                                $selectableIds[] = $req->id;
                                                break;
                                            }
                                            
                                            // System -> harus sudah verified
                                            if ($verificationStatus === 'approved') {
                                                $selectableIds[] = $req->id;
                                                break;
                                            }
                                        }
                                    }
                                }
                                $canSelectAll = count($selectableIds) > 0;
                            @endphp
                            @if($canSelectAll)
                                <input type="checkbox" 
                                    wire:model.live="selectAll" 
                                    wire:click="toggleSelectAll"
                                    class="w-4 h-4 rounded border-zinc-300 dark:border-zinc-600 text-blue-600 focus:ring-blue-500 dark:bg-zinc-800 dark:checked:bg-blue-600 cursor-pointer">
                            @else
                                <input type="checkbox" 
                                    disabled
                                    class="w-4 h-4 rounded border-zinc-300 dark:border-zinc-600 text-gray-400 bg-gray-100 dark:bg-zinc-700 cursor-not-allowed opacity-50">
                            @endif
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">REQUEST NUMBER #</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">TOTAL EMPLOYEE</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">ADMIN FEEDBACK</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">VERIFICATION</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">MISSC STATUS</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">SIGNATURE</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">PREPARED BY</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">DATE</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($requests as $index => $request)
                    @php
                        $adminStatus = $this->getAdminFeedbackStatus($request);
                        $canEdit = ($adminStatus['status'] == 'Open');
                        
                        // ============ MISSC STATUS ============
                        $misscStatusColors = [
                            'Waiting' => 'gray',
                            'On Process' => 'yellow',
                            'Accepted' => 'green',
                        ];
                        
                        $misscStatusIcons = [
                            'Waiting' => 'M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z',
                            'On Process' => 'M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z',
                            'Accepted' => 'M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z',
                        ];
                        
                        $misscStatus = $request->missc_status ?? 'Waiting';
                        $misscColor = $misscStatusColors[$misscStatus] ?? 'gray';
                        $misscIcon = $misscStatusIcons[$misscStatus] ?? $misscStatusIcons['Waiting'];
                        
                        // ============ VERIFICATION STATUS ============
                        $verificationStatus = $this->getVerificationStatus($request);
                        $verificationColors = [
                            'Waiting' => 'gray',
                            'On Process' => 'yellow',
                            'Approved' => 'green',
                            'Completed' => 'blue',
                            'N/A' => 'gray',
                        ];
                        $verificationIcons = [
                            'Waiting' => 'M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z',
                            'On Process' => 'M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z',
                            'Approved' => 'M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z',
                            'Completed' => 'M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z',
                            'N/A' => 'M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z',
                        ];
                        $verificationColor = $verificationColors[$verificationStatus['status']] ?? 'gray';
                        $verificationIcon = $verificationIcons[$verificationStatus['status']] ?? $verificationIcons['Waiting'];
                        
                        // ============ SIGNATURE STATUS ============
                        $signatureStatus = $this->getSignatureStatus($request);
                        $signatureColors = [
                            'Waiting' => 'gray',
                            'On Process' => 'yellow',
                            'Signed' => 'green',
                            'Completed' => 'blue',
                        ];
                        $signatureIcons = [
                            'Waiting' => 'M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z',
                            'On Process' => 'M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z',
                            'Signed' => 'M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z',
                            'Completed' => 'M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z',
                        ];
                        $signatureColor = $signatureColors[$signatureStatus['status']] ?? 'gray';
                        $signatureIcon = $signatureIcons[$signatureStatus['status']] ?? $signatureIcons['Waiting'];
                    @endphp
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                        <td class="px-2 py-3 text-center">
                            @php
                                $items = $request->items ?? [];
                                $canSelect = false;
                                
                                // Cek apakah request memiliki missc_status = 'On Process'
                                if (isset($request->missc_status) && $request->missc_status === 'On Process') {
                                    foreach ($items as $item) {
                                        // ============ GUNAKAN NULL COALESCING UNTUK AMAN ============
                                        $isManual = isset($item['is_manual']) && $item['is_manual'] === true;
                                        $isNewEmployee = isset($item['reason_type']) && $item['reason_type'] === 'new_employee';
                                        $verificationStatus = $item['verification_status'] ?? null;
                                        
                                        // CEK: Manual atau New Employee -> LANGSUNG BISA
                                        if ($isManual || $isNewEmployee) {
                                            $canSelect = true;
                                            break;
                                        }
                                        
                                        // CEK: System -> harus sudah verified
                                        if ($verificationStatus === 'approved') {
                                            $canSelect = true;
                                            break;
                                        }
                                    }
                                }
                            @endphp
                            @if($canSelect)
                                <input type="checkbox" 
                                    wire:model.live="selectedRequests" 
                                    value="{{ $request->id }}"
                                    class="w-4 h-4 rounded border-zinc-300 dark:border-zinc-600 text-blue-600 focus:ring-blue-500 dark:bg-zinc-800 dark:checked:bg-blue-600 cursor-pointer">
                            @else
                                <input type="checkbox" 
                                    disabled
                                    class="w-4 h-4 rounded border-zinc-300 dark:border-zinc-600 text-gray-400 bg-gray-100 dark:bg-zinc-700 cursor-not-allowed opacity-50">
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <span class="text-sm font-semibold">{{ $request->request_number }}</span>
                        </td>
                        
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium bg-blue-100 text-blue-700 rounded-full dark:bg-blue-900/30 dark:text-blue-300 whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                    <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                                </svg>
                                <span>{{ count($request->items) }} employee(s)</span>
                            </span>
                        </td>
                        
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            @if($adminStatus['status'] == 'N/A')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                    </svg>
                                    N/A
                                    <flux:tooltip content="All items are manual input (no admin feedback needed)" position="top">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                        </svg>
                                    </flux:tooltip>
                                </span>
                            @elseif($adminStatus['status'] == 'Checked')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium text-green-700 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                    </svg>
                                    Checked
                                </span>
                            @elseif($adminStatus['status'] == 'On Process')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-900/30 dark:text-yellow-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
                                    </svg>
                                    On Process
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium text-gray-700 bg-gray-100 rounded-full dark:bg-gray-900/30 dark:text-gray-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                    </svg>
                                    Open
                                </span>
                            @endif
                        </td>

                        <!-- Verification Status Column -->
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            @php
                                $verifStatus = $verificationStatus['status'] ?? 'N/A';
                                $verifIcon = $verificationIcon ?? '';
                            @endphp
                            @if($verifStatus == 'N/A')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="{{ $verifIcon }}" clip-rule="evenodd" />
                                    </svg>
                                    N/A
                                    <flux:tooltip content="All items are manual input (no verification needed)" position="top">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                        </svg>
                                    </flux:tooltip>
                                </span>
                            @elseif($verifStatus == 'Waiting')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="{{ $verifIcon }}" clip-rule="evenodd" />
                                    </svg>
                                    Waiting
                                    <flux:tooltip content="All items are waiting for verification" position="top">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                        </svg>
                                    </flux:tooltip>
                                </span>
                            @elseif($verifStatus == 'On Process')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="{{ $verifIcon }}" clip-rule="evenodd" />
                                    </svg>
                                    On Process
                                    <flux:tooltip content="Some items have been verified, some are still pending" position="top">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                        </svg>
                                    </flux:tooltip>
                                </span>
                            @elseif($verifStatus == 'Approved')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="{{ $verifIcon }}" clip-rule="evenodd" />
                                    </svg>
                                    Approved
                                    <flux:tooltip content="All items have been approved" position="top">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                        </svg>
                                    </flux:tooltip>
                                </span>
                            @elseif($verifStatus == 'Completed')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="{{ $verifIcon }}" clip-rule="evenodd" />
                                    </svg>
                                    Completed
                                    <flux:tooltip content="Process completed with some rejected or manual items" position="top">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                        </svg>
                                    </flux:tooltip>
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <div class="flex flex-col items-center gap-1">
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium rounded-full bg-{{ $misscColor }}-100 text-{{ $misscColor }}-700 dark:bg-{{ $misscColor }}-900/30 dark:text-{{ $misscColor }}-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="{{ $misscIcon }}" clip-rule="evenodd" />
                                    </svg>
                                    {{ $misscStatus }}
                                </span>
                                
                                @if($misscStatus == 'Accepted' && $request->missc_accept_at)
                                    <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                        {{ $request->missc_accept_at->format('d M Y H:i') }}
                                    </span>
                                @endif
                            </div>
                        </td>

                        <!-- Signature Status Column -->
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            @if($signatureStatus['status'] == 'Signed')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="{{ $signatureIcon }}" clip-rule="evenodd" />
                                    </svg>
                                    Signed
                                </span>
                            @elseif($signatureStatus['status'] == 'Completed')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="{{ $signatureIcon }}" clip-rule="evenodd" />
                                    </svg>
                                    Completed
                                </span>
                            @elseif($signatureStatus['status'] == 'On Process')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
                                    </svg>
                                    On Process
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 shrink-0">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                    </svg>
                                    Waiting
                                </span>
                            @endif
                        </td>
                        
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <span class="text-sm font-semibold">{{ $request->created_by }}</span>
                        </td>
                        
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <span class="text-sm font-semibold">{{ $request->created_at ? $request->created_at->format('d M Y H:i') : '-' }}</span>
                        </td>
                        
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <!-- View Button -->
                                <flux:tooltip content="View Details" position="bottom">
                                    <flux:button 
                                        href="{{ route('prod.uniform.request.show', $request->id) }}"
                                        wire:navigate
                                        size="xs"
                                        icon="eye"
                                        variant="primary"
                                        color="blue"
                                        class="!p-1.5"
                                    />
                                </flux:tooltip>

                                @can('update uniform request missc status')
                                    @php
                                        $verificationStatus = $this->getVerificationStatus($request);
                                        // Jika status N/A, berarti semua item manual/new employee, bisa langsung update
                                        $canUpdateMissc = in_array($verificationStatus['status'], ['Completed', 'Approved', 'N/A']);
                                    @endphp
                                    @if($request->missc_status != 'Accepted' && $canUpdateMissc)
                                        <flux:tooltip content="Update MISSC Status" position="bottom">
                                            <flux:button 
                                                wire:click="openMisscModal({{ $request->id }})"
                                                size="xs"
                                                icon="pencil"
                                                variant="primary"
                                                color="green"
                                                class="!p-1.5"
                                            />
                                        </flux:tooltip>
                                    @elseif($request->missc_status != 'Accepted')
                                        <flux:tooltip content="Cannot update MISSC Status - Verification must be Completed, Approved, or N/A first" position="bottom">
                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-600 cursor-not-allowed">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </span>
                                        </flux:tooltip>
                                    @endif
                                @endcan
                                
                                @can('edit uniform request')
                                    @php
                                        // Cek lock status
                                        $lockStatus = $this->getLockStatus($request->id);
                                        $isLockedByOther = $lockStatus['is_locked'] && !$lockStatus['is_owner'];
                                        
                                        // Cek apakah bisa diedit
                                        $canEdit = $this->canEditRequest($request);
                                        
                                        // TAMBAHKAN: Jika ada lock dari user lain, tidak bisa edit
                                        $canEdit = $canEdit && !$isLockedByOther;
                                    @endphp
                                    
                                    @if($canEdit && $request->missc_status == 'Waiting')
                                        <flux:tooltip content="Edit Request" position="bottom">
                                            <flux:button 
                                                href="{{ route('prod.uniform.request.edit', $request->id) }}"
                                                wire:navigate
                                                size="xs"
                                                icon="pencil-square"
                                                variant="primary"
                                                color="yellow"
                                                class="!p-1.5"
                                            />
                                        </flux:tooltip>
                                    @elseif($isLockedByOther)
                                        <!-- TAMPILKAN TOMBOL DISABLED DENGAN TOOLTIP LOCK -->
                                        <div x-data="{ showTooltip: false }" class="relative inline-block">
                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400 cursor-not-allowed">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                            </span>
                                            <div x-show="showTooltip" 
                                                x-on:mouseenter="showTooltip = true" 
                                                x-on:mouseleave="showTooltip = false"
                                                @click.away="showTooltip = false"
                                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 z-50 w-48 p-2 bg-zinc-800 text-white text-xs rounded-lg shadow-lg text-center">
                                                <p class="font-semibold">Sedang diedit oleh</p>
                                                <p><strong>{{ $lockStatus['locked_by'] }}</strong></p>
                                                <p class="text-zinc-400 text-[10px] mt-0.5">
                                                    Expired: {{ \Carbon\Carbon::parse($lockStatus['expires_at'])->format('H:i:s') }}
                                                </p>
                                                <div class="absolute -bottom-1.5 left-1/2 transform -translate-x-1/2 rotate-45 w-3 h-3 bg-zinc-800"></div>
                                                
                                                @can('feedback uniform request admin')
                                                    <div class="mt-2 pt-2 border-t border-zinc-700">
                                                        <button wire:click="forceReleaseLock({{ $request->id }})" 
                                                            onclick="if(confirm('Yakin ingin melepas lock secara paksa?')){ @this.call('forceReleaseLock', {{ $request->id }}) }"
                                                            class="text-xs text-red-400 hover:text-red-300 transition-colors w-full">
                                                            Force Release (Admin)
                                                        </button>
                                                    </div>
                                                @endcan
                                            </div>
                                        </div>
                                    @else
                                        @php
                                            $disabledReason = '';
                                            if ($request->missc_status != 'Waiting') {
                                                $disabledReason = 'Cannot edit - MISSC status is ' . $request->missc_status;
                                            } else {
                                                // Cek detail kenapa tidak bisa edit
                                                $items = $request->items ?? [];
                                                $hasSignature = false;
                                                $hasFeedback = false;
                                                foreach ($items as $item) {
                                                    if (!empty($item['digital_signature'])) $hasSignature = true;
                                                    $adminFeedback = $item['admin_feedback'] ?? '';
                                                    if (!empty($adminFeedback) && 
                                                        $adminFeedback !== 'N/A (Manual Input)' &&
                                                        $adminFeedback !== 'N/A (New Employee)') {
                                                        $hasFeedback = true;
                                                    }
                                                }
                                                if ($hasSignature) {
                                                    $disabledReason = 'Cannot edit - Already signed';
                                                } elseif ($hasFeedback) {
                                                    $disabledReason = 'Cannot edit - Already has admin feedback';
                                                } else {
                                                    $disabledReason = 'Cannot edit';
                                                }
                                            }
                                        @endphp
                                        <flux:tooltip content="{{ $disabledReason }}" position="bottom">
                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-600 cursor-not-allowed">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </span>
                                        </flux:tooltip>
                                    @endif
                                @endcan
                                
                                @can('delete uniform request')
                                    @php
                                        $canDelete = $this->canDeleteRequest($request);
                                        
                                        // Cek alasan tidak bisa delete
                                        $deleteDisabledReason = '';
                                        if (!$canDelete) {
                                            if ($request->missc_status === 'Accepted') {
                                                $deleteDisabledReason = 'Cannot delete - Status already Accepted';
                                            } elseif ($this->hasSignedItems($request)) {
                                                $deleteDisabledReason = 'Cannot delete - Items already signed';
                                            } elseif ($this->hasAdminFeedback($request)) {
                                                $deleteDisabledReason = 'Cannot delete - Admin feedback already exists';
                                            } else {
                                                $deleteDisabledReason = 'Cannot delete';
                                            }
                                        }
                                    @endphp
                                    
                                    @if($canDelete)
                                        <flux:tooltip content="Delete Request" position="bottom">
                                            <flux:button 
                                                wire:click="delete({{ $request->id }})"
                                                wire:confirm="Are you sure you want to delete this request? Stock will be returned."
                                                size="xs"
                                                icon="trash"
                                                variant="primary"
                                                color="red"
                                                class="!p-1.5"
                                            />
                                        </flux:tooltip>
                                    @else
                                        <flux:tooltip content="{{ $deleteDisabledReason }}" position="bottom">
                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-600 cursor-not-allowed">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </span>
                                        </flux:tooltip>
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <svg class="w-16 h-16 text-zinc-300 dark:text-zinc-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">No requests found</h3>
                                </div>
                                @if($search)
                                    <flux:button wire:click="$set('search', '')" size="sm" class="mt-2">
                                        Clear Search
                                    </flux:button>
                                @else
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($requests->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $requests->links() }}
        </div>
        @endif
    </flux:card>

    <!-- MODAL MISSC STATUS UPDATE -->
    <div x-data="{ 
        open: @entangle('showMisscModal'), 
        closeModal() { 
            this.open = false; 
            $wire.closeMisscModal(); 
        },
        allItemsSigned: @json($allItemsSigned ?? false)
    }" 
    x-show="open" 
    x-cloak>
        <div class="fixed inset-0 bg-black/50 z-40" @click="closeModal()"></div>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Update MISSC Status</h2>
                        <button @click="closeModal()" class="text-zinc-500 hover:text-zinc-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Request Number</label>
                        <div class="px-3 py-2 bg-zinc-100 dark:bg-zinc-800 rounded-lg text-sm font-semibold">
                            {{ $selectedRequestNumber }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Current Status</label>
                        <div class="px-3 py-2 bg-zinc-100 dark:bg-zinc-800 rounded-lg">
                            @if($currentMisscStatus == 'Waiting')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium text-gray-700 bg-gray-200 rounded-full dark:bg-gray-600 dark:text-gray-200">
                                    Waiting
                                </span>
                            @elseif($currentMisscStatus == 'On Process')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-900/30 dark:text-yellow-300">
                                    On Process
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-sm font-medium text-green-700 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-300">
                                    Accepted
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Info Status yang Akan Diupdate -->
                    @if($currentMisscStatus == 'Waiting')
                        <div class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                            <p class="text-sm text-blue-700 dark:text-blue-300 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Status akan diubah menjadi <strong class="text-yellow-600">On Process</strong></span>
                            </p>
                        </div>
                    @elseif($currentMisscStatus == 'On Process' && $allItemsSigned)
                        <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                            <p class="text-sm text-green-700 dark:text-green-300 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Semua item sudah signed. Status akan diubah menjadi <strong class="text-green-600">Accepted</strong></span>
                            </p>
                        </div>
                        <div class="mb-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                            <p class="text-sm text-yellow-700 dark:text-yellow-400 flex items-start gap-2">
                                <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span><strong>Warning:</strong> Once accepted, this status cannot be changed and the request will be finalized.</span>
                            </p>
                        </div>
                    @elseif($currentMisscStatus == 'On Process' && !$allItemsSigned)
                        <div class="mb-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                            <p class="text-sm text-yellow-700 dark:text-yellow-300 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span>Menunggu semua item di-sign. <br>Status tetap <strong class="text-yellow-600">On Process</strong></span>
                            </p>
                        </div>
                    @endif
                    
                    <div class="flex justify-end gap-2 mt-4">
                        <button @click="closeModal()" 
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                            Cancel
                        </button>
                        <button wire:click="confirmUpdateMisscStatus" 
                            @click="closeModal()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors inline-flex items-center gap-2"
                            :disabled="{{ $currentMisscStatus == 'On Process' && !$allItemsSigned ? 'true' : 'false' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Confirm Update</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL BULK ACTION -->
    <div x-data="{ 
        open: @entangle('showBulkModal'), 
        closeModal() { this.open = false; $wire.closeBulkModal(); }
    }" 
    x-show="open" 
    x-cloak>
        <div class="fixed inset-0 bg-black/50 z-40" @click="closeModal()"></div>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-6xl max-h-[95vh] flex flex-col">
                <!-- Header -->
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-700 flex justify-between items-center flex-shrink-0">
                    <div>
                        <h2 class="text-xl font-bold flex items-center gap-2">
                            <span class="text-green-600 dark:text-green-400">📦</span>
                            Bulk Create Missc Summary
                        </h2>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                            {{ (count($bulkData['regular'] ?? []) + count($bulkData['new_employee'] ?? [])) }} item(s) from {{ count($selectedRequests) }} selected request(s)
                        </p>
                    </div>
                    <button @click="closeModal()" class="text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Body -->
                <div class="p-6 overflow-y-auto flex-1">
                    @php
                        $totalQty = 0;
                        $totalItems = 0;
                        $canProcessCount = 0;
                        $systemCount = 0;
                        $manualCount = 0;
                        $newEmployeeCount = 0;
                        
                        foreach(['regular', 'new_employee'] as $category) {
                            $items = $bulkData[$category] ?? [];
                            foreach($items as $item) {
                                $totalQty += $item['qty'];
                                $totalItems++;
                                if ($item['can_be_processed']) {
                                    $canProcessCount++;
                                }
                                if ($item['type'] === 'System') $systemCount++;
                                if ($item['type'] === 'Manual') $manualCount++;
                                if ($item['type'] === 'New Employee') $newEmployeeCount++;
                            }
                        }
                    @endphp
                    
                    @if($totalItems > 0)
                        <!-- Regular Items -->
                        @if(!empty($bulkData['regular']))
                        <div class="mb-6">
                            <div class="flex items-center gap-3 mb-3">
                                <h3 class="text-lg font-semibold text-blue-700 dark:text-blue-400">🔵 Regular Employee</h3>
                                <span class="text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-2 py-0.5 rounded-full">
                                    {{ count($bulkData['regular']) }} item(s)
                                </span>
                            </div>
                            
                            <div class="border rounded-lg overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead class="bg-blue-50 dark:bg-blue-900/20 sticky top-0 z-10">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">No</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Item Code</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Description</th>
                                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Qty</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Department</th>
                                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Type</th>
                                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Request Numbers</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                            @foreach($bulkData['regular'] as $index => $item)
                                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors {{ !$item['can_be_processed'] ? 'opacity-60' : '' }}">
                                                <td class="px-4 py-3 text-center text-zinc-500 dark:text-zinc-400">{{ $index + 1 }}</td>
                                                <td class="px-4 py-3 font-mono text-sm font-medium text-blue-600 dark:text-blue-400 whitespace-nowrap">
                                                    <span 
                                                        x-data="{ copied: false }"
                                                        @click="
                                                            navigator.clipboard.writeText('{{ $item['item_code'] }}');
                                                            copied = true;
                                                            setTimeout(() => copied = false, 2000);
                                                        "
                                                        class="cursor-pointer hover:underline hover:text-blue-800 dark:hover:text-blue-300 transition-colors inline-flex items-center gap-1.5"
                                                        title="Click to copy"
                                                    >
                                                        {{ $item['item_code'] }}
                                                        <svg x-show="!copied" class="w-4 h-4 text-blue-400 dark:text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                        </svg>
                                                        <svg x-show="copied" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-green-600 dark:text-green-400 flex-shrink-0">
                                                            <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                                                    {{ $item['description'] }}
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <span class="inline-flex items-center justify-center min-w-[30px] px-2 py-0.5 text-xs font-medium text-white bg-blue-600 rounded-full dark:bg-blue-700">
                                                        {{ $item['qty'] }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium bg-purple-100 text-purple-700 rounded-full dark:bg-purple-900/30 dark:text-purple-300">
                                                        {{ $item['department'] }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    @if($item['type'] === 'System')
                                                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-300 whitespace-nowrap">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                                                            </svg>
                                                            System
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-full dark:bg-gray-900/30 dark:text-gray-300 whitespace-nowrap">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                            </svg>
                                                            Manual
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    @if($item['can_be_processed'])
                                                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-300 whitespace-nowrap">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            {{ $item['status'] }}
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full dark:bg-red-900/30 dark:text-red-300 whitespace-nowrap">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                            {{ $item['status'] }}
                                                            <flux:tooltip content="{{ $item['reason_not_processed'] }}" position="top">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </flux:tooltip>
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-xs text-zinc-500 dark:text-zinc-400">
                                                    <div class="flex flex-wrap gap-1 max-w-[150px]">
                                                        @foreach($item['request_numbers'] as $reqNum)
                                                            <span class="inline-block px-1.5 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-[10px] font-medium">
                                                                {{ $reqNum }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- New Employee Items -->
                        @if(!empty($bulkData['new_employee']))
                        <div>
                            <div class="flex items-center gap-3 mb-3">
                                <h3 class="text-lg font-semibold text-yellow-700 dark:text-yellow-400">🟡 New Employee</h3>
                                <span class="text-xs bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 px-2 py-0.5 rounded-full">
                                    {{ count($bulkData['new_employee']) }} item(s)
                                </span>
                            </div>
                            
                            <div class="border rounded-lg overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead class="bg-yellow-50 dark:bg-yellow-900/20 sticky top-0 z-10">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">No</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Item Code</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Description</th>
                                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Qty</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Department</th>
                                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Type</th>
                                                <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Request Numbers</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                            @foreach($bulkData['new_employee'] as $index => $item)
                                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors {{ !$item['can_be_processed'] ? 'opacity-60' : '' }}">
                                                <td class="px-4 py-3 text-center text-zinc-500 dark:text-zinc-400">{{ $index + 1 }}</td>
                                                <td class="px-4 py-3 font-mono text-sm font-medium text-blue-600 dark:text-blue-400 whitespace-nowrap">
                                                    <span 
                                                        x-data="{ copied: false }"
                                                        @click="
                                                            navigator.clipboard.writeText('{{ $item['item_code'] }}');
                                                            copied = true;
                                                            setTimeout(() => copied = false, 2000);
                                                        "
                                                        class="cursor-pointer hover:underline hover:text-blue-800 dark:hover:text-blue-300 transition-colors inline-flex items-center gap-1.5"
                                                        title="Click to copy"
                                                    >
                                                        {{ $item['item_code'] }}
                                                        <svg x-show="!copied" class="w-4 h-4 text-blue-400 dark:text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                        </svg>
                                                        <svg x-show="copied" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-green-600 dark:text-green-400 flex-shrink-0">
                                                            <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                                                    {{ $item['description'] }}
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <span class="inline-flex items-center justify-center min-w-[30px] px-2 py-0.5 text-xs font-medium text-white bg-yellow-600 rounded-full dark:bg-yellow-700">
                                                        {{ $item['qty'] }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium bg-purple-100 text-purple-700 rounded-full dark:bg-purple-900/30 dark:text-purple-300">
                                                        {{ $item['department'] }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-900/30 dark:text-yellow-300 whitespace-nowrap">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                        New Employee
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    @if($item['can_be_processed'])
                                                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-300 whitespace-nowrap">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            Ready
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full dark:bg-red-900/30 dark:text-red-300 whitespace-nowrap">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                            {{ $item['status'] }}
                                                            <flux:tooltip content="{{ $item['reason_not_processed'] }}" position="top">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </flux:tooltip>
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-xs text-zinc-500 dark:text-zinc-400">
                                                    <div class="flex flex-wrap gap-1 max-w-[150px]">
                                                        @foreach($item['request_numbers'] as $reqNum)
                                                            <span class="inline-block px-1.5 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-[10px] font-medium">
                                                                {{ $reqNum }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Summary Footer -->
                        <div class="mt-4 p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700">
                            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                                <div>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Total Items</p>
                                    <p class="text-lg font-bold text-zinc-800 dark:text-zinc-200">{{ $totalItems }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Total Quantity</p>
                                    <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $totalQty }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">System</p>
                                    <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $systemCount }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Manual</p>
                                    <p class="text-lg font-bold text-gray-600 dark:text-gray-400">{{ $manualCount }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">New Employee</p>
                                    <p class="text-lg font-bold text-yellow-600 dark:text-yellow-400">{{ $newEmployeeCount }}</p>
                                </div>
                            </div>
                            
                            @if($canProcessCount < $totalItems)
                            <div class="mt-3 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                                <div class="flex items-center gap-2 text-sm text-yellow-600 dark:text-yellow-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span>
                                        <strong>{{ $totalItems - $canProcessCount }}</strong> item(s) cannot be processed yet. 
                                        @if($systemCount > 0)
                                            System items need user verification first.
                                        @endif
                                    </span>
                                </div>
                            </div>
                            @endif
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <svg class="w-16 h-16 text-zinc-300 dark:text-zinc-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-zinc-500 dark:text-zinc-400">No items with "Create Missc" feedback found</p>
                            <p class="text-sm text-zinc-400 dark:text-zinc-500 mt-1">Only items with status "On Process" are included</p>
                        </div>
                    @endif
                </div>
                
                <!-- Footer -->
                <div class="p-6 border-t border-zinc-200 dark:border-zinc-700 flex justify-end flex-shrink-0">
                    <button @click="closeModal()" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div x-data="{ show: false, message: '', type: 'success' }" 
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
         x-show="show" x-transition class="fixed bottom-4 right-4 z-50"
         :class="{'bg-green-500': type === 'success', 'bg-red-500': type === 'error'}" style="display: none;">
        <div class="text-white px-6 py-3 rounded-lg shadow-lg" x-text="message"></div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        /* Tooltip untuk lock */
        .relative.inline-block {
            cursor: help;
        }
        .absolute.bottom-full {
            pointer-events: auto;
        }
    </style>
</div>