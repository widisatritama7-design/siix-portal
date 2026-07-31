<div class="p-1 space-y-2">
    @section('title', $requestId ? 'Edit Uniform Request' : 'Create Uniform Request')
    
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">HR</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Uniform</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('prod.uniform.request.index') }}" wire:navigate separator="slash">Request Uniform</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">{{ $requestId ? 'Edit' : 'Create' }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                {{ $requestId ? 'Edit Uniform Request' : 'Create Uniform Request' }}
            </h1>
            <p class="text-sm text-zinc-500">Add multiple uniforms for one employee at a time</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            {{ session('error') }}
        </div>
    @endif

    {{-- NOTIFIKASI LOCK --}}
    @if(!$lockAcquired && $lockOwner)
        <div class="sticky z-40 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-lg shadow-lg p-4 mb-4 dark:from-red-900/20 dark:to-red-800/20 dark:border-red-400 backdrop-blur-sm" style="top: 90px;">
            <div class="flex items-center justify-between">
                <div class="flex items-start gap-4">
                    <!-- Icon SVG -->
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke="currentColor"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke="currentColor"/>
                            <circle cx="12" cy="16" r="1" fill="currentColor"/>
                            <line x1="12" y1="13" x2="12" y2="15" stroke="currentColor"/>
                        </svg>
                    </div>
                    
                    <div>
                        <p class="text-sm font-semibold text-red-800 dark:text-red-200">
                            Form sedang digunakan!
                        </p>
                        <p class="text-sm text-red-700 dark:text-red-300">
                            Oleh: <strong class="font-semibold">{{ $lockOwner }}</strong>
                        </p>
                        <p class="text-xs text-red-600 dark:text-red-400 mt-0.5">
                            Halaman akan di-redirect otomatis setelah waktu habis (10 menit)
                        </p>
                    </div>
                </div>
                
                <!-- Countdown Badge di sisi kanan + Tombol End Session -->
                <div class="flex items-center gap-3 flex-shrink-0 ml-4">
                    <!-- Countdown -->
                    <div class="bg-red-600 dark:bg-red-500 rounded-lg px-4 py-2 shadow-md">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" stroke="currentColor"/>
                                <polyline points="12 6 12 12 16 14" stroke="currentColor"/>
                            </svg>
                            <span x-data="{
                                expiresAt: {{ $this->getLockExpiresAtTimestamp() }},
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
                                        window.location.href = '{{ route('prod.uniform.request.index') }}';
                                    }
                                },
                                formatTime(seconds) {
                                    const mins = Math.floor(seconds / 60);
                                    const secs = seconds % 60;
                                    return `${mins}:${secs.toString().padStart(2, '0')}`;
                                }
                            }" 
                            x-text="formatTime(timeLeft)"
                            class="text-white font-mono font-bold text-lg tabular-nums">
                            </span>
                        </div>
                    </div>
                    
                    <!-- Tombol End Session dengan icon power -->
                    <button type="button"
                        wire:click="endSession"
                        wire:confirm="Are you sure you want to end this session? The form will be released and you will be redirected."
                        class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-white bg-red-700 hover:bg-red-800 dark:bg-red-600 dark:hover:bg-red-700 rounded-lg transition-colors shadow-md hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm10.72 4.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H9a.75.75 0 0 1 0-1.5h10.94l-1.72-1.72a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        <span>End Session</span>
                    </button>
                </div>
            </div>
        </div>
        
    @elseif($lockAcquired)
        <div class="sticky z-40 bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 rounded-lg shadow-lg p-4 mb-4 dark:from-green-900/20 dark:to-green-800/20 dark:border-green-400 backdrop-blur-sm" style="top: 90px;">
            <div class="flex items-center justify-between">
                <div class="flex items-start gap-4">
                    <!-- Icon SVG -->
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-green-500">
                            <path d="M18 1.5c2.9 0 5.25 2.35 5.25 5.25v3.75a.75.75 0 0 1-1.5 0V6.75a3.75 3.75 0 1 0-7.5 0v3a3 3 0 0 1 3 3v6.75a3 3 0 0 1-3 3H3.75a3 3 0 0 1-3-3v-6.75a3 3 0 0 1 3-3h9v-3c0-2.9 2.35-5.25 5.25-5.25Z" />
                        </svg>
                    </div>
                    
                    <div>
                        <p class="text-sm font-semibold text-green-700 dark:text-green-300">
                            Form ini sedang Anda gunakan
                        </p>
                        <p class="text-xs text-green-600 dark:text-green-400 mt-0.5">
                            Lock akan expire otomatis dalam 10 menit
                        </p>
                    </div>
                </div>
                
                <!-- Countdown Badge di sisi kanan + Tombol End Session -->
                <div class="flex items-center gap-3 flex-shrink-0 ml-4">
                    <!-- Countdown -->
                    <div class="bg-green-600 dark:bg-green-500 rounded-lg px-4 py-2 shadow-md">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" stroke="currentColor"/>
                                <polyline points="12 6 12 12 16 14" stroke="currentColor"/>
                            </svg>
                            <span x-data="{
                                expiresAt: {{ $this->getLockExpiresAtTimestamp() }},
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
                                        window.location.href = '{{ route('prod.uniform.request.index') }}';
                                    }
                                },
                                formatTime(seconds) {
                                    const mins = Math.floor(seconds / 60);
                                    const secs = seconds % 60;
                                    return `${mins}:${secs.toString().padStart(2, '0')}`;
                                }
                            }" 
                            x-text="formatTime(timeLeft)"
                            class="text-white font-mono font-bold text-lg tabular-nums">
                            </span>
                        </div>
                    </div>
                    
                    <!-- Tombol End Session -->
                    <button type="button"
                        wire:click="endSession"
                        wire:confirm="Are you sure you want to end this session? The form will be released and you will be redirected."
                        class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 rounded-lg transition-colors shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm10.72 4.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H9a.75.75 0 0 1 0-1.5h10.94l-1.72-1.72a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                        <span>End Session</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @php
        $isOneUser = auth()->user()->can('view uniform request one user');
        $isFullAccess = auth()->user()->can('view uniform request');
        // Gunakan property dari component, bukan auth() langsung
        $canManual = $this->canManual ?? false;
    @endphp

    @if($isOneUser && !$isFullAccess && $userDepartment)
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 mt-0.5 text-blue-600 dark:text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-blue-700 dark:text-blue-300">
                        Department Access Restricted
                    </p>
                    <p class="text-sm text-blue-600 dark:text-blue-400">
                        You can only see and select employees from department: 
                        <strong class="font-semibold">{{ $userDepartment }}</strong>
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if($canManual)
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3">
            <p class="text-sm text-yellow-700 dark:text-yellow-300 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>You have Admin access. You can use <strong>"New Employee"</strong> for employees not registered in database.</span>
            </p>
        </div>
    @endif

    <form wire:submit="save">
        @php
            $isOneUser = auth()->user()->can('view uniform request one user');
            $isFullAccess = auth()->user()->can('view uniform request');
            $canManual = $this->canManual ?? false;
            
            // Perbaiki logika isEmployeeSelected
            $isEmployeeSelected = false;
            if ($isManualInput && $canManual) {
                // Mode manual: cek apakah name dan department sudah diisi
                $isEmployeeSelected = !empty($manualName) && !empty($manualDepartment);
            } else {
                // Mode normal: cek apakah employee sudah dipilih
                $isEmployeeSelected = !is_null($current_employee_id);
            }
            
            $isGroupSelected = !empty($current_group) && $current_group !== '';
            $isFormReady = $isEmployeeSelected && $isGroupSelected;
            $hasCartItems = count($current_uniforms) > 0;
            
            // Cek apakah ada uniform di cart yang reason_type-nya new_employee
            $hasNewEmployeeInCart = false;
            foreach ($current_uniforms as $item) {
                if (isset($item['reason_type']) && $item['reason_type'] === 'new_employee') {
                    $hasNewEmployeeInCart = true;
                    break;
                }
            }
            
            // Mode manual aktif jika: manual input aktif, ATAU ada new_employee di cart, ATAU ada manual rows
            $isManualMode = ($isManualInput && $canManual) || 
                            ($hasNewEmployeeInCart && $canManual) || 
                            ($this->hasManualRows() && $canManual);
        @endphp
        <!-- FORM ADD NEW ROW -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
            <!-- LEFT COLUMN (70%) -->
            <div class="lg:col-span-8 xl:col-span-8 space-y-6">
                <!-- Peringatan Konsistensi Input -->
                @if(count($rows) > 0)
                    @php
                        $existingType = $this->getExistingInputType();
                    @endphp
                    @if($existingType === 'manual')
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-sm text-green-700 dark:text-green-300">
                                    <span class="font-semibold">Mode New Employee Aktif</span> - Isi data karyawan baru pada form di bawah.
                                </p>
                            </div>
                        </div>
                    @elseif($existingType === 'normal')
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    <span class="font-semibold">Mode Normal</span> - Cari dan pilih karyawan dari database.
                                </p>
                            </div>
                        </div>
                    @endif
                @endif

                <!-- CARD 1: Input Employee & Uniform -->
                <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h2 class="text-lg font-semibold mb-4">Input Employee & Uniform</h2>
                    
                    <!-- Employee, Request Date & Group in one row -->
                    <div class="mb-4">
                        @php
                            $isManualMode = ($isManualInput && $canManual) || ($this->hasManualRows() && $canManual);
                        @endphp
                        
                        @if($isManualMode)
                            <!-- Mode Manual: 2 Column Row (Employee Information & Request Date) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Employee Information -->
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <label class="block text-sm font-medium">Employee Information</label>
                                    </div>

                                    <!-- Mode Manual: Tampilkan Badge New Employee dengan tinggi sama -->
                                    <div class="p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg h-[42px] flex items-center">
                                        <div class="flex items-center gap-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-green-500 flex-shrink-0">
                                                <path d="M6.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM3.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM19.75 7.5a.75.75 0 0 0-1.5 0v2.25H16a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H22a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
                                            </svg>
                                            <span class="text-sm font-semibold text-green-700 dark:text-green-300">New Employee</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Request Date -->
                                <div>
                                    <label class="block text-sm font-medium mb-1">Request Date <span class="text-red-500">*</span></label>
                                    <input type="date" 
                                        wire:model="current_request_date" 
                                        disabled
                                        class="w-full px-3 py-2 border rounded-lg bg-gray-100 dark:bg-zinc-700 dark:border-zinc-600 cursor-not-allowed text-gray-500 dark:text-gray-400 text-sm h-[42px]">
                                    @error('current_request_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @else
                            <!-- Mode Normal: 3 Column Row (Employee Information, Request Date & Group) -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Employee Information -->
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <label class="block text-sm font-medium">Employee Information</label>
                                    </div>

                                    <!-- Search Input -->
                                    <div x-data="{ search: @entangle('employeeSearch') }">
                                        <input 
                                            type="text"
                                            x-model="search"
                                            @input="$wire.set('employeeSearch', search)"
                                            placeholder="Search by NIK or name..."
                                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white text-sm h-[42px]"
                                        >

                                        <input type="hidden" wire:model="current_employee_id">

                                        @error('current_employee_id') 
                                            <span class="text-red-500 text-xs">{{ $message }}</span> 
                                        @enderror
                                    </div>
                                </div>

                                <!-- Request Date -->
                                <div>
                                    <label class="block text-sm font-medium mb-1">Request Date <span class="text-red-500">*</span></label>
                                    <input type="date" 
                                        wire:model="current_request_date" 
                                        disabled
                                        class="w-full px-3 py-2 border rounded-lg bg-gray-100 dark:bg-zinc-700 dark:border-zinc-600 cursor-not-allowed text-gray-500 dark:text-gray-400 text-sm h-[42px]">
                                    @error('current_request_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Group -->
                                <div>
                                    <label class="block text-sm font-medium mb-1">Group <span class="text-red-500">*</span></label>
                                    <select wire:model="current_group" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm h-[42px]">
                                        <option value="">Select Group</option>
                                        <option value="GA">GA</option>
                                        <option value="GB">GB</option>
                                        <option value="GC">GC</option>
                                        <option value="TA">TA</option>
                                        <option value="TB">TB</option>
                                        <option value="NS">NS</option>
                                        <option value="1">1</option>
                                    </select>
                                    @error('current_group') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif

                        <!-- Results Table & Selected Employee - Full Width di Bawah Column -->
                        @if(!$isManualMode)
                            <!-- Results Table -->
                            @if(!empty($employeeSearch) && strlen($employeeSearch) >= 2 && empty($current_employee_id))
                                <div class="mt-3 border rounded-lg overflow-hidden">
                                    <div class="overflow-x-auto max-h-60 overflow-y-auto">
                                        <table class="w-full text-sm">
                                            <thead class="bg-zinc-100 dark:bg-zinc-800 sticky top-0 z-10">
                                                <tr>
                                                    <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NIK</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                                                    <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Department</th>
                                                    <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                                @php
                                                    $searchLower = strtolower($employeeSearch);
                                                    $filteredEmployees = [];
                                                    foreach($this->employees as $value => $label) {
                                                        $parts = explode(' - ', $label);
                                                        $nik = $parts[0] ?? '';
                                                        $namePart = $parts[1] ?? '';
                                                        $name = '';
                                                        $department = '';
                                                        if (preg_match('/^(.*?)\s*\(([^)]*)\)$/', $namePart, $matches)) {
                                                            $name = trim($matches[1]);
                                                            $department = trim($matches[2]);
                                                        } else {
                                                            $name = $namePart;
                                                            $department = '-';
                                                        }
                                                        
                                                        if (str_contains(strtolower($nik), $searchLower) || 
                                                            str_contains(strtolower($name), $searchLower) || 
                                                            str_contains(strtolower($department), $searchLower)) {
                                                            $filteredEmployees[] = [
                                                                'value' => $value,
                                                                'nik' => $nik,
                                                                'name' => $name,
                                                                'department' => $department,
                                                                'label' => $label
                                                            ];
                                                        }
                                                    }
                                                    
                                                    // Cek employee yang sudah ada di rows
                                                    $existingEmployeeIds = [];
                                                    $existingManualNiks = [];
                                                    foreach ($rows as $row) {
                                                        if (isset($row['is_manual']) && $row['is_manual']) {
                                                            $existingManualNiks[] = $row['manual_nik'];
                                                        } else {
                                                            $existingEmployeeIds[] = $row['employee_id'];
                                                        }
                                                    }
                                                @endphp
                                                
                                                @forelse($filteredEmployees as $employee)
                                                    @php
                                                        $isAlreadyAdded = in_array($employee['value'], $existingEmployeeIds);
                                                    @endphp
                                                    <tr class="{{ $isAlreadyAdded ? 'bg-gray-50 dark:bg-gray-800/50 cursor-not-allowed opacity-60' : 'hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors cursor-pointer' }}" 
                                                        @if(!$isAlreadyAdded)
                                                            @click="$wire.set('current_employee_id', '{{ $employee['value'] }}'); $wire.set('employeeSearch', '{{ addslashes($employee['label']) }}');"
                                                        @endif
                                                    >
                                                        <td class="px-3 py-2 text-center">{{ $employee['nik'] }}</td>
                                                        <td class="px-3 py-2 text-zinc-800 dark:text-zinc-200">{{ $employee['name'] }}</td>
                                                        <td class="px-3 py-2 text-center">
                                                            <flux:badge size="xs" color="{{ $isAlreadyAdded ? 'gray' : 'sky' }}">{{ $employee['department'] }}</flux:badge>
                                                        </td>
                                                        <td class="px-3 py-2 text-center">
                                                            @if($isAlreadyAdded)
                                                                <div class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-gray-500 bg-gray-100 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                    </svg>
                                                                    Added
                                                                </div>
                                                            @else
                                                                <button type="button" 
                                                                    @click="$wire.set('current_employee_id', '{{ $employee['value'] }}'); $wire.set('employeeSearch', '{{ addslashes($employee['label']) }}');"
                                                                    class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                    </svg>
                                                                    Select
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="px-3 py-4 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                                            <svg class="w-8 h-8 mx-auto mb-2 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                            </svg>
                                                            <p>No employees found</p>
                                                            <p class="text-xs text-zinc-400 dark:text-zinc-500">Try a different search term</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    @if(count($filteredEmployees) > 0)
                                        <div class="px-3 py-1.5 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50 text-xs text-zinc-500">
                                            Found {{ count($filteredEmployees) }} employee(s)
                                            @php
                                                $addedCount = 0;
                                                foreach ($filteredEmployees as $emp) {
                                                    if (in_array($emp['value'], $existingEmployeeIds)) {
                                                        $addedCount++;
                                                    }
                                                }
                                            @endphp
                                            @if($addedCount > 0)
                                                <span class="text-blue-600 dark:text-blue-400">({{ $addedCount }} already added)</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                            <!-- Selected Employee Display - Full Width -->
                            @if(!empty($current_employee_id) && !empty($employeeSearch))
                                <div class="mt-3 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                    <div class="flex items-center gap-3 text-sm">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-green-700 dark:text-green-300 font-medium">Selected Employee:</span>
                                        <span class="font-semibold text-green-800 dark:text-green-200">{{ $employeeSearch }}</span>
                                        <button type="button" 
                                            @click="$wire.set('current_employee_id', ''); $wire.set('employeeSearch', '');"
                                            class="ml-auto text-xs text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>

                    <!-- BUTTON ACTION: New Employee / Back to Search - Full Width -->
                    @if($canManual)
                        <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                            @if($isManualMode)
                                <!-- Mode Manual: Tombol Back to Search -->
                                @php
                                    $hasManualData = $this->hasManualRows();
                                @endphp
                                <button type="button" 
                                    wire:click="toggleManualInput"
                                    {{ $hasManualData ? 'disabled' : '' }}
                                    class="w-full px-4 py-3 rounded-lg font-medium flex items-center justify-center gap-2 shadow-sm transition-colors
                                    {{ $hasManualData 
                                        ? 'bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' 
                                        : 'bg-blue-600 text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-4.28 9.22a.75.75 0 0 0 0 1.06l3 3a.75.75 0 1 0 1.06-1.06l-1.72-1.72h5.69a.75.75 0 0 0 0-1.5h-5.69l1.72-1.72a.75.75 0 0 0-1.06-1.06l-3 3Z" clip-rule="evenodd" />
                                    </svg>
                                    <span>
                                        @if($hasManualData)
                                            Back to Search (Disabled - Hapus data terlebih dahulu)
                                        @else
                                            Back to Search Employee
                                        @endif
                                    </span>
                                </button>
                                @if($hasManualData)
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2 text-center">
                                        Untuk beralih ke mode normal, hapus terlebih dahulu semua data New Employee.
                                    </p>
                                @endif
                            @else
                                <!-- Mode Normal: Tombol New Employee -->
                                @php
                                    $hasNormalData = $this->hasNormalRows();
                                @endphp
                                <button type="button" 
                                    wire:click="toggleManualInput"
                                    {{ $hasNormalData ? 'disabled' : '' }}
                                    class="w-full px-4 py-3 rounded-lg font-medium flex items-center justify-center gap-2 shadow-sm transition-colors
                                    {{ $hasNormalData 
                                        ? 'bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed' 
                                        : 'bg-blue-600 text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                    </svg>
                                    <span>
                                        @if($hasNormalData)
                                            New Employee (Disabled - Hapus data terlebih dahulu)
                                        @else
                                            New Employee
                                        @endif
                                    </span>
                                </button>
                                @if($hasNormalData)
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2 text-center">
                                        Untuk beralih ke mode New Employee, hapus terlebih dahulu semua data yang sudah ada.
                                    </p>
                                @endif
                            @endif
                        </div>
                    @endif
                </flux:card>

                <!-- CARD 1.5: Manual Employee Details (hanya tampil saat manual mode) -->
                @if($isManualMode)
                <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-yellow-500">
                                <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                            </svg>
                            New Employee Details
                        </h2>
                        <span class="text-xs bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 px-3 py-1 rounded-full font-medium">
                            New Employee
                        </span>
                    </div>
                    
                    <!-- BARIS 1: Nama Karyawan, Department, Group (3 kolom) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <!-- Hidden input untuk manualNik dengan default '-' -->
                        <input type="hidden" wire:model="manualNik" value="-">
                        
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">
                                Nama Karyawan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="text" 
                                    wire:model="manualName"
                                    placeholder="Full Name *"
                                    class="w-full pl-10 pr-3 py-2.5 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-all duration-200">
                            </div>
                            @error('manualName') 
                                <span class="text-red-500 text-xs block mt-1.5">{{ $message }}</span> 
                            @enderror
                        </div>
                        
                        <!-- Department - Dropdown dengan pilihan dari database -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">
                                Department <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <select wire:model="manualDepartment" 
                                    class="w-full pl-10 pr-8 py-2.5 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm appearance-none transition-all duration-200">
                                    <option value="">Pilih Department</option>
                                    @foreach($manualDepartmentOptions as $dept)
                                        @if(!in_array($dept, ['Executive Officer', 'OS', 'President Director', 'TRAINING']))
                                            <option value="{{ $dept }}">{{ $dept }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('manualDepartment') 
                                <span class="text-red-500 text-xs block mt-1.5">{{ $message }}</span> 
                            @enderror
                        </div>
                        
                        <!-- Group -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">
                                Group <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <select wire:model="current_group" 
                                    class="w-full pl-10 pr-8 py-2.5 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm appearance-none transition-all duration-200">
                                    <option value="">Pilih Group</option>
                                    <option value="GA">GA</option>
                                    <option value="GB">GB</option>
                                    <option value="GC">GC</option>
                                    <option value="TA">TA</option>
                                    <option value="TB">TB</option>
                                    <option value="NS">NS</option>
                                    <option value="1">1</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('current_group') 
                                <span class="text-red-500 text-xs block mt-1.5">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>
                    
                    <!-- BARIS 2: Tanggal Pemberkasan dan DOJ / Tanggal Join (2 kolom) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Tanggal Pemberkasan -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">
                                Tanggal Pemberkasan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="date" 
                                    wire:model="manualTanggalPemberkasan"
                                    class="w-full pl-10 pr-3 py-2.5 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-all duration-200">
                            </div>
                            @error('manualTanggalPemberkasan') 
                                <span class="text-red-500 text-xs block mt-1.5">{{ $message }}</span> 
                            @enderror
                        </div>
                        
                        <!-- DOJ / Tanggal Join -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5 text-zinc-700 dark:text-zinc-300">
                                DOJ / Tanggal Join <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="date" 
                                    wire:model="manualDoj"
                                    class="w-full pl-10 pr-3 py-2.5 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-all duration-200">
                            </div>
                            @error('manualDoj') 
                                <span class="text-red-500 text-xs block mt-1.5">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Info Card -->
                    <div class="mt-4">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3 shadow-sm">
                            <div class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="text-xs font-medium text-blue-700 dark:text-blue-300">
                                        Informasi
                                    </p>
                                    <p class="text-xs text-blue-600 dark:text-blue-400">
                                        Isi nama, department, group, tanggal pemberkasan dan tanggal join untuk karyawan baru
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </flux:card>
                @endif

                <!-- CARD 2: Select Uniforms (Available Stock) -->
                <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div>
                        <label class="block text-sm font-medium mb-2">Select Uniforms (Available Stock) <span class="text-red-500">*</span></label>
                        
                        <!-- Search Uniform -->
                        <div class="mb-2">
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input type="text" 
                                    wire:model.live.debounce.300ms="uniformSearch" 
                                    placeholder="Search uniform by code, description, or size..."
                                    class="w-full pl-9 pr-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>
                        </div>
                        
                        <!-- Table Uniform yang Tersedia -->
                        <div class="border rounded-lg overflow-hidden mb-3">
                            <div class="overflow-x-auto" style="overflow-x: auto !important; white-space: nowrap !important;">
                                <table class="w-full text-sm" style="min-width: 750px;">
                                    <thead class="bg-zinc-100 dark:bg-zinc-800">
                                        <tr>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Item Code</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Description</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Size</th>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Location</th>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Available</th>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Reserved</th>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                        @forelse($availableUniforms as $uniform)
                                        @php
                                            $isOutOfStock = $uniform->available_qty <= 0 || $uniform->qty <= 0;
                                            $isAlreadyAdded = in_array($uniform->id, collect($this->current_uniforms)->pluck('master_uniform_id')->toArray());
                                        @endphp
                                        <tr class="{{ $isOutOfStock || $isAlreadyAdded ? 'bg-gray-50 dark:bg-gray-800/50 opacity-60' : 'hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors' }}">
                                            <td class="px-3 py-2 text-sm font-mono whitespace-nowrap text-center">{{ $uniform->item_code }}</td>    
                                            <td class="px-3 py-2 text-sm whitespace-nowrap">{{ $uniform->description }}</td>
                                            <td class="px-3 py-2 text-sm whitespace-nowrap">
                                                <flux:badge size="sm" color="purple">{{ $uniform->size }}</flux:badge>
                                            </td>
                                            <td class="px-3 py-2 text-center whitespace-nowrap">
                                                @if($uniform->status == 'Manual')
                                                    <flux:badge size="xs" color="blue">Manual</flux:badge>
                                                @elseif($uniform->status == 'System')
                                                    <flux:badge size="xs" color="green">System</flux:badge>
                                                @elseif($uniform->status == 'Not Use')
                                                    <flux:badge size="xs" color="gray">Not Use</flux:badge>
                                                @else
                                                    <flux:badge size="xs" color="yellow">{{ $uniform->status }}</flux:badge>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2 text-center whitespace-nowrap">
                                                <span class="text-sm font-semibold {{ $uniform->available_qty <= 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                                    {{ $uniform->available_qty }}
                                                </span>
                                                @if($uniform->available_qty <= 0 && $uniform->qty > 0)
                                                    <span class="text-xs text-red-500 block">(Reserved: {{ $uniform->reserved_qty }})</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2 text-center whitespace-nowrap">
                                                @if($uniform->reserved_qty > 0)
                                                    <span class="text-xs text-yellow-600 dark:text-yellow-400 font-medium">
                                                        {{ $uniform->reserved_qty }}
                                                    </span>
                                                @else
                                                    <span class="text-xs text-zinc-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2 text-center whitespace-nowrap">
                                                @if($isOutOfStock)
                                                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-red-600 bg-red-100 rounded-lg dark:text-red-400 dark:bg-red-900/30">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                        </svg>
                                                        No Stock
                                                    </span>
                                                @elseif($isAlreadyAdded)
                                                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-gray-500 bg-gray-100 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                        Added
                                                    </span>
                                                @else
                                                    <button type="button" 
                                                        wire:click="$set('current_master_uniform_id', {{ $uniform->id }})"
                                                        class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:hover:bg-blue-900/50 transition-colors">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                        Select
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="px-3 py-4 text-center text-sm text-zinc-500">
                                                @if($uniformSearch)
                                                    No uniforms found matching "<span class="font-medium">{{ $uniformSearch }}</span>"
                                                @else
                                                    No uniforms available
                                                @endif
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- PAGINATION BAWAAN LIVEWIRE - GANTI DENGAN INI -->
                            @if($availableUniforms->hasPages())
                                <div class="px-3 py-2 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50">
                                    {{ $availableUniforms->links() }}
                                </div>
                            @endif
                        </div>
                        
                        <!-- Form Add Uniform Detail -->
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                            <!-- Selected Uniform Info -->
                            <div class="px-3 py-2 {{ $current_master_uniform_id ? 'bg-green-50 dark:bg-green-900/20 border-b border-green-200 dark:border-green-800' : 'bg-zinc-100 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700' }}">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-xs font-medium {{ $current_master_uniform_id ? 'text-green-700 dark:text-green-300' : 'text-zinc-500 dark:text-zinc-400' }}">
                                            @if($current_master_uniform_id)
                                                <svg class="w-4 h-4 inline-block mr-1 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Selected Uniform:
                                            @else
                                                Selected Uniform:
                                            @endif
                                        </span>
                                        
                                        @if($current_master_uniform_id)
                                            @php
                                                $selectedUniform = \App\Models\PROD\Uniform\MasterUniform::find($current_master_uniform_id);
                                                // Hitung reserved qty dari cart + rows
                                                $reservedQty = 0;
                                                foreach ($this->current_uniforms as $item) {
                                                    if ($item['master_uniform_id'] == $current_master_uniform_id) {
                                                        $reservedQty += $item['qty'];
                                                    }
                                                }
                                                foreach ($this->rows as $row) {
                                                    if ($row['master_uniform_id'] == $current_master_uniform_id) {
                                                        $reservedQty += $row['qty'];
                                                    }
                                                }
                                                $availableQty = $selectedUniform ? $selectedUniform->qty - $reservedQty : 0;
                                            @endphp
                                            @if($selectedUniform)
                                                <span class="text-sm font-semibold text-green-700 dark:text-green-400">{{ $selectedUniform->item_code }}</span>
                                                <span class="text-xs text-green-600 dark:text-green-400">(Stock: <span class="font-semibold {{ $selectedUniform->qty <= 5 ? 'text-red-600' : 'text-green-600' }}">{{ $selectedUniform->qty }}</span>)</span>
                                                <span class="text-xs text-green-300 dark:text-green-600">|</span>
                                                <span class="text-xs text-green-700 dark:text-green-300">{{ $selectedUniform->description }}</span>
                                                <span class="text-xs text-green-300 dark:text-green-600">|</span>
                                                <flux:badge size="xs" color="green">{{ $selectedUniform->size }}</flux:badge>
                                                <span class="text-xs text-green-300 dark:text-green-600">|</span>
                                                @if($selectedUniform->status == 'Manual')
                                                    <flux:badge size="xs" color="blue">Manual</flux:badge>
                                                @elseif($selectedUniform->status == 'System')
                                                    <flux:badge size="xs" color="green">System</flux:badge>
                                                @elseif($selectedUniform->status == 'Not Use')
                                                    <flux:badge size="xs" color="gray">Not Use</flux:badge>
                                                @else
                                                    <flux:badge size="xs" color="yellow">{{ $selectedUniform->status }}</flux:badge>
                                                @endif
                                                @if($reservedQty > 0)
                                                    <span class="text-xs text-yellow-600 dark:text-yellow-400">
                                                        (Reserved: {{ $reservedQty }} | Available: {{ $availableQty }})
                                                    </span>
                                                @endif
                                            @endif
                                        @else
                                            <span class="text-xs text-zinc-400 italic">Select a uniform from the table above</span>
                                        @endif
                                    </div>
                                    
                                    <!-- Tombol Cancel/X -->
                                    @if($current_master_uniform_id)
                                        <button type="button" 
                                            wire:click="$set('current_master_uniform_id', '')"
                                            class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 dark:text-red-400 dark:bg-red-900/20 dark:hover:bg-red-900/30 rounded-lg transition-colors flex-shrink-0"
                                            title="Cancel selected uniform">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Input Fields -->
                            <div class="p-3">
                                <!-- BARIS 1: Quantity, Reason (Dropdown), Remarks, Add Button -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-end">
                                    <!-- Quantity -->
                                    <div class="col-span-1 sm:col-span-1 lg:col-span-2">
                                        <label class="block text-xs font-medium mb-1 text-zinc-600 dark:text-zinc-400 text-center">Qty <span class="text-red-500">*</span></label>
                                        <input type="number" 
                                            wire:model="current_qty" 
                                            min="1"
                                            class="w-full px-2 py-2 border rounded-lg dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center h-[42px]">
                                        @error('current_qty') <span class="text-red-500 text-xs block mt-1 text-center">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <!-- Reason (Pilihan Radio) -->
                                    <div class="col-span-1 sm:col-span-1 lg:col-span-4">
                                        <label class="block text-xs font-medium mb-1.5 text-zinc-600 dark:text-zinc-400">Alasan <span class="text-red-500">*</span></label>
                                        
                                        @if($isManualMode)
                                            <!-- Mode Manual: Hanya New Employee -->
                                            <div class="flex items-center gap-3 px-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg h-[42px]">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-blue-500 flex-shrink-0">
                                                    <path d="M6.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM3.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM19.75 7.5a.75.75 0 0 0-1.5 0v2.25H16a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H22a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
                                                </svg>
                                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">
                                                    New Employee
                                                </span>
                                                <input type="hidden" wire:model="current_reason_type" value="new_employee">
                                            </div>
                                        @else
                                            <!-- Mode Normal: Pergantian & NG ESD -->
                                            <div class="flex gap-2 h-[42px]">
                                                <!-- Pilihan Pergantian -->
                                                <label class="flex-1 cursor-pointer">
                                                    <input type="radio" 
                                                        wire:model.live="current_reason_type" 
                                                        value="pergantian"
                                                        class="hidden peer">
                                                    <div class="flex items-center justify-center gap-2 px-3 py-2 border-2 rounded-lg transition-all duration-200 h-full
                                                        peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20
                                                        border-zinc-300 dark:border-zinc-600 hover:border-blue-400 dark:hover:border-blue-500
                                                        {{ $current_reason_type === 'pergantian' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-blue-500 flex-shrink-0">
                                                            <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="text-sm font-medium {{ $current_reason_type === 'pergantian' ? 'text-blue-600 dark:text-blue-400' : 'text-zinc-600 dark:text-zinc-400' }}">Pergantian</span>
                                                    </div>
                                                </label>

                                                <!-- Pilihan NG ESD -->
                                                <label class="flex-1 cursor-pointer">
                                                    <input type="radio" 
                                                        wire:model.live="current_reason_type" 
                                                        value="ng_esd"
                                                        class="hidden peer">
                                                    <div class="flex items-center justify-center gap-2 px-3 py-2 border-2 rounded-lg transition-all duration-200 h-full
                                                        peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/20
                                                        border-zinc-300 dark:border-zinc-600 hover:border-red-400 dark:hover:border-red-500
                                                        {{ $current_reason_type === 'ng_esd' ? 'border-red-500 bg-red-50 dark:bg-red-900/20' : '' }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 {{ $current_reason_type === 'ng_esd' ? 'text-red-500' : 'text-zinc-400 dark:text-zinc-500' }} flex-shrink-0">
                                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="text-sm font-medium {{ $current_reason_type === 'ng_esd' ? 'text-red-600 dark:text-red-400' : 'text-zinc-600 dark:text-zinc-400' }}">NG ESD</span>
                                                    </div>
                                                </label>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Remarks -->
                                    <div class="col-span-1 sm:col-span-1 lg:col-span-4">
                                        <label class="block text-xs font-medium mb-1 text-zinc-600 dark:text-zinc-400">Remarks</label>
                                        <input type="text" 
                                            wire:model="current_remarks" 
                                            placeholder="Optional..."
                                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 h-[42px]">
                                    </div>
                                    
                                    <!-- Tombol Add -->
                                    <div class="col-span-1 sm:col-span-1 lg:col-span-2">
                                        <button type="button" 
                                            wire:click="addUniformToCurrent"
                                            class="w-full py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium inline-flex items-center justify-center gap-2 shadow-sm hover:shadow-md h-[42px]"
                                            title="Add Uniform">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="hidden sm:inline">Add</span>
                                            <span class="sm:hidden">+</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- BARIS 2: Input Text atau File Upload (FULL WIDTH) -->
                                <div class="mt-3">
                                    @if($current_reason_type === 'pergantian' && !$isManualMode)
                                        <!-- Input Text untuk Pergantian - WAJIB DIISI -->
                                        <div>
                                            <label class="block text-xs font-medium mb-1 text-zinc-600 dark:text-zinc-400">
                                                Alasan Pergantian <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" 
                                                wire:model="current_reason" 
                                                placeholder="Masukkan alasan pergantian..."
                                                class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            @error('current_reason') 
                                                <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> 
                                            @enderror
                                        </div>
                                    @elseif($current_reason_type === 'ng_esd' && !$isManualMode)
                                        <!-- File Upload untuk NG ESD - WAJIB UPLOAD -->
                                        <div>
                                            <label class="block text-xs font-medium mb-1 text-zinc-600 dark:text-zinc-400">
                                                Upload File PDF <span class="text-red-500">*</span>
                                            </label>
                                            
                                            <div wire:key="file-upload-ng-esd">
                                                <div class="relative">
                                                    <input type="file" 
                                                        wire:model.live="current_reason_file"
                                                        accept=".pdf"
                                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                                        id="fileInputNgEsd">
                                                    
                                                    <div class="border-2 border-dashed rounded-lg p-4 sm:p-6 transition-all duration-200 text-center
                                                        {{ $current_reason_file ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-zinc-300 dark:border-zinc-600 hover:border-blue-400 dark:hover:border-blue-500' }}
                                                        {{ $errors->has('current_reason_file') ? 'border-red-500 bg-red-50 dark:bg-red-900/20' : '' }}">
                                                        
                                                        @if($current_reason_file)
                                                            <div class="flex items-center justify-center gap-3 flex-wrap">
                                                                <svg class="w-8 h-8 text-green-500 dark:text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                <div class="text-left min-w-0">
                                                                    <p class="text-sm font-medium text-green-700 dark:text-green-300 truncate max-w-[150px] sm:max-w-[200px]">
                                                                        {{ $current_reason_file->getClientOriginalName() }}
                                                                    </p>
                                                                    <p class="text-xs text-green-600 dark:text-green-400">
                                                                        {{ number_format($current_reason_file->getSize() / 1024, 1) }} KB
                                                                        <span class="text-green-500 ml-2">✓ Uploaded</span>
                                                                    </p>
                                                                </div>
                                                                <button type="button" 
                                                                    wire:click="$set('current_reason_file', null)"
                                                                    class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 p-1 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors flex-shrink-0">
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        @else
                                                            <div class="flex flex-col items-center justify-center gap-2">
                                                                <svg class="w-10 h-10 sm:w-12 sm:h-12 text-blue-400 dark:text-blue-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                                </svg>
                                                                <div>
                                                                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                                                        <span class="font-semibold text-blue-600 dark:text-blue-400">Klik untuk upload file</span>
                                                                    </p>
                                                                    <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">File PDF maksimal 5MB</p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div wire:loading wire:target="current_reason_file" class="mt-2">
                                                <div class="flex items-center gap-2">
                                                    <div class="flex-1 h-1.5 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
                                                        <div class="h-full bg-blue-500 rounded-full animate-pulse" style="width: 100%"></div>
                                                    </div>
                                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Uploading...</span>
                                                </div>
                                            </div>
                                            
                                            @error('current_reason_file') 
                                                <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> 
                                            @enderror
                                        </div>
                                    @elseif($isManualMode)
                                        <!-- Mode Manual: Tampilkan info bahwa reason otomatis New Employee -->
                                        <div>
                                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                                                <div class="flex items-center gap-2 text-sm text-blue-700 dark:text-blue-300">
                                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>Reason type otomatis <strong>New Employee</strong> untuk input manual</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </flux:card>
            </div>

            <!-- RIGHT CARD - UNIFORM LIST (30%) -->
            <div class="lg:col-span-4 xl:col-span-4">
                <!-- Hapus sticky, biar normal mengikuti aliran -->
                <flux:card class="p-4 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">
                            <span class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z" clip-rule="evenodd" />
                                </svg>
                                Uniform List
                            </span>
                        </h2>
                        <span class="text-sm bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full font-semibold">
                            {{ count($current_uniforms) }} item(s)
                        </span>
                    </div>

                    @if(count($current_uniforms) > 0)
                        <!-- List dengan scroll jika > 3 item -->
                        <div class="{{ count($current_uniforms) > 3 ? 'max-h-[400px] overflow-y-auto pr-1' : '' }}">
                            <div class="space-y-3">
                                @foreach($current_uniforms as $index => $uniform)
                                    <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700 hover:border-blue-300 dark:hover:border-blue-700 transition-all duration-200 hover:shadow-md">
                                        <div class="flex items-start justify-between gap-3">
                                            <!-- Left: Item Info -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2 mb-1 flex-wrap">
                                                    <span class="text-sm font-semibold text-blue-600 dark:text-blue-400">{{ $uniform['item_code'] }}</span>
                                                    <span class="text-xs text-zinc-400 dark:text-zinc-500">|</span>
                                                    <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400">{{ $uniform['size'] ?? '-' }}</span>
                                                    <span class="text-xs text-zinc-400 dark:text-zinc-500">|</span>
                                                    @if($uniform['status'] == 'Manual')
                                                        <flux:badge size="xs" color="blue">Manual</flux:badge>
                                                    @elseif($uniform['status'] == 'System')
                                                        <flux:badge size="xs" color="green">System</flux:badge>
                                                    @elseif($uniform['status'] == 'Not Use')
                                                        <flux:badge size="xs" color="gray">Not Use</flux:badge>
                                                    @else
                                                        <flux:badge size="xs" color="yellow">{{ $uniform['status'] }}</flux:badge>
                                                    @endif
                                                </div>
                                                <p class="text-sm text-zinc-700 dark:text-zinc-300 truncate">{{ $uniform['description'] ?? $uniform['item_code'] }}</p>
                                                
                                                <!-- Reason Type & File -->
                                                @if(isset($uniform['reason_type']))
                                                    <div class="flex items-center gap-2 mt-1.5 flex-wrap">
                                                        @if($uniform['reason_type'] === 'ng_esd')
                                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium text-red-700 bg-red-100 rounded-full dark:bg-red-900/30 dark:text-red-300">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3.5">
                                                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                                                </svg>
                                                                NG ESD
                                                            </span>
                                                            @if(!empty($uniform['reason_file']))
                                                                <span class="text-xs text-green-600 dark:text-green-400 flex items-center gap-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3.5">
                                                                        <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clip-rule="evenodd" />
                                                                    </svg>
                                                                    {{ $uniform['reason_file_name'] ?? 'PDF' }}
                                                                </span>
                                                            @endif
                                                        @elseif($uniform['reason_type'] === 'new_employee')
                                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium text-green-700 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-300">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3.5">
                                                                    <path d="M6.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM3.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM19.75 7.5a.75.75 0 0 0-1.5 0v2.25H16a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H22a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
                                                                </svg>
                                                                New Employee
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium text-blue-700 bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-300">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3">
                                                                    <path fill-rule="evenodd" d="M9.75 6.75h-3a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3h7.5a3 3 0 0 0 3-3v-7.5a3 3 0 0 0-3-3h-3V1.5a.75.75 0 0 0-1.5 0v5.25Zm0 0h1.5v5.69l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72V6.75Z" clip-rule="evenodd" />
                                                                    <path d="M7.151 21.75a2.999 2.999 0 0 0 2.599 1.5h7.5a3 3 0 0 0 3-3v-7.5c0-1.11-.603-2.08-1.5-2.599v7.099a4.5 4.5 0 0 1-4.5 4.5H7.151Z" />
                                                                </svg>
                                                                Others
                                                            </span>
                                                            @if(!empty($uniform['reason']))
                                                                <span class="text-xs text-zinc-500 dark:text-zinc-400 truncate max-w-[100px]">
                                                                    {{ Str::limit($uniform['reason'], 20) }}
                                                                </span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <!-- Right: Qty & Action -->
                                            <div class="flex items-center gap-3 flex-shrink-0">
                                                <div class="text-center">
                                                    <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $uniform['qty'] }}</span>
                                                    <span class="text-xs text-zinc-500 dark:text-zinc-400 block">Qty</span>
                                                </div>
                                                <button type="button" 
                                                    wire:click="removeUniformFromCurrent({{ $index }})"
                                                    class="text-red-400 hover:text-red-600 dark:text-red-500 dark:hover:text-red-400 transition-colors p-2 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl inline-flex items-center justify-center"
                                                    title="Remove">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Summary -->
                        <div class="mt-4 pt-3 border-t-2 border-zinc-200 dark:border-zinc-700">
                            <div class="grid grid-cols-2 gap-2">
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-2 text-center">
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Total Items</span>
                                    <p class="text-lg font-bold text-zinc-700 dark:text-zinc-300">{{ count($current_uniforms) }}</p>
                                </div>
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-2 text-center">
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Total Quantity</span>
                                    <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ array_sum(array_column($current_uniforms, 'qty')) }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="flex flex-col items-center justify-center py-8 text-center">
                            <svg class="w-16 h-16 text-zinc-300 dark:text-zinc-600 mb-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                            </svg>
                            <p class="text-base font-medium text-zinc-500 dark:text-zinc-400">No uniforms added yet</p>
                            <p class="text-sm text-zinc-400 dark:text-zinc-500 mt-1">Add uniforms using the form on the left</p>
                        </div>
                    @endif

                    <!-- Tombol Add Employee Request -->
                    <div class="border-t pt-4 mt-4">
                        <button type="button" 
                            wire:click="addRow" 
                            class="w-full px-4 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all font-semibold text-base shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                            {{ !$hasCartItems ? 'disabled' : '' }}
                            title="{{ !$hasCartItems ? 'Please add at least one uniform to cart' : 'Add Employee Request' }}">
                            <span class="flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                </svg>
                                Add Employee Request
                            </span>
                        </button>
                    </div>
                </flux:card>
            </div>

        </div>

        <!-- REQUEST ITEMS TABLE -->
        @if(count($rows) > 0)
        @php
            // Group rows by employee identifier (NIK + Name + Department)
            $groupedRows = [];
            foreach ($paginatedRows as $index => $row) {
                // Buat key unik berdasarkan employee
                $employeeKey = ($row['employee_nik'] ?? $row['manual_nik'] ?? '') . '|' . 
                            ($row['employee_name'] ?? $row['manual_name'] ?? '') . '|' . 
                            ($row['employee_department'] ?? $row['manual_department'] ?? '');
                
                if (!isset($groupedRows[$employeeKey])) {
                    $groupedRows[$employeeKey] = [
                        'employee_nik' => $row['employee_nik'] ?? $row['manual_nik'] ?? '-',
                        'employee_name' => $row['employee_name'] ?? $row['manual_name'] ?? '-',
                        'employee_department' => $row['employee_department'] ?? $row['manual_department'] ?? '-',
                        'is_manual' => isset($row['is_manual']) && $row['is_manual'],
                        'manual_nik' => $row['manual_nik'] ?? null,
                        'manual_name' => $row['manual_name'] ?? null,
                        'manual_department' => $row['manual_department'] ?? null,
                        'manual_tanggal_pemberkasan' => $row['manual_tanggal_pemberkasan'] ?? null,
                        'manual_doj' => $row['manual_doj'] ?? null,
                        'items' => [],
                        'rowspan' => 0
                    ];
                }
                
                $groupedRows[$employeeKey]['items'][] = [
                    'index' => $index,
                    'row' => $row
                ];
            }
            
            // Hitung rowspan untuk setiap group
            foreach ($groupedRows as &$group) {
                $group['rowspan'] = count($group['items']);
            }
            unset($group);
            
            $groupIndex = 0;
        @endphp

        <flux:card class="p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Request Items</h2>
                <div class="text-sm text-zinc-500">
                    Total: {{ $paginatedRows->total() }} row(s)
                </div>
            </div>
            
            <div class="overflow-x-auto" style="overflow-x: auto !important; white-space: nowrap !important;">
                <table class="w-full text-sm border" style="min-width: 1900px;">
                    <thead class="bg-zinc-100 dark:bg-zinc-800">
                        <tr>
                            <th class="px-3 py-2 text-left">NIK</th>
                            <th class="px-3 py-2 text-left">NAME</th>
                            <th class="px-3 py-2 text-left">DEPARTMENT</th>
                            <th class="px-3 py-2 text-left">TANGGAL PEMBERKASAN</th>
                            <th class="px-3 py-2 text-left">DOJ</th>
                            <th class="px-3 py-2 text-left">ITEM CODE</th>
                            <th class="px-3 py-2 text-left">DESCRIPTION</th>
                            <th class="px-3 py-2 text-left">SIZE</th>
                            <th class="px-3 py-2 text-center">LOCATION</th>
                            <th class="px-3 py-2 text-center">QTY</th>
                            <th class="px-3 py-2 text-left">REASON</th>
                            <th class="px-3 py-2 text-left">REASON TYPE</th>
                            <th class="px-3 py-2 text-left">REASON FILE</th>
                            <th class="px-3 py-2 text-left">GROUP</th>
                            <th class="px-3 py-2 text-left">REQUEST DATE</th>
                            <th class="px-3 py-2 text-left">REMARKS</th>
                            <th class="px-3 py-2 text-center">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groupedRows as $group)
                            @php
                                $itemCount = count($group['items']);
                                $isFirst = true;
                            @endphp
                            
                            @foreach($group['items'] as $itemData)
                                @php
                                    $row = $itemData['row'];
                                    $index = $itemData['index'];
                                @endphp
                                <tr class="border-t hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                    <!-- NIK - Merge -->
                                    @if($isFirst)
                                        <td class="px-3 py-2 whitespace-nowrap align-middle" rowspan="{{ $group['rowspan'] }}">
                                            @if(isset($row['is_manual']) && $row['is_manual'])
                                                <div class="flex items-center gap-1">
                                                    <span class="text-xs text-yellow-600 dark:text-yellow-400"></span>
                                                    <span>{{ $group['employee_nik'] }}</span>
                                                </div>
                                            @else
                                                {{ $group['employee_nik'] }}
                                            @endif
                                        </td>
                                        <!-- NAME - Merge -->
                                        <td class="px-3 py-2 whitespace-nowrap align-middle" rowspan="{{ $group['rowspan'] }}">
                                            @if(isset($row['is_manual']) && $row['is_manual'])
                                                {{ $group['manual_name'] ?? $group['employee_name'] }}
                                            @else
                                                {{ $group['employee_name'] }}
                                            @endif
                                        </td>
                                        <!-- DEPARTMENT - Merge -->
                                        <td class="px-3 py-2 whitespace-nowrap align-middle" rowspan="{{ $group['rowspan'] }}">
                                            @if(isset($row['is_manual']) && $row['is_manual'])
                                                {{ $group['manual_department'] ?? $group['employee_department'] }}
                                            @else
                                                {{ $group['employee_department'] }}
                                            @endif
                                        </td>
                                        <!-- TANGGAL PEMBERKASAN - Merge (hanya untuk manual) -->
                                        <td class="px-3 py-2 whitespace-nowrap align-middle" rowspan="{{ $group['rowspan'] }}">
                                            @if(isset($row['is_manual']) && $row['is_manual'])
                                                {{ isset($group['manual_tanggal_pemberkasan']) ? \Carbon\Carbon::parse($group['manual_tanggal_pemberkasan'])->format('d/m/Y') : '-' }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <!-- DOJ - Merge (hanya untuk manual) -->
                                        <td class="px-3 py-2 whitespace-nowrap align-middle" rowspan="{{ $group['rowspan'] }}">
                                            @if(isset($row['is_manual']) && $row['is_manual'])
                                                {{ isset($group['manual_doj']) ? \Carbon\Carbon::parse($group['manual_doj'])->format('d/m/Y') : '-' }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endif
                                    
                                    <!-- Item Details (tidak di-merge) -->
                                    <td class="px-3 py-2 whitespace-nowrap">{{ $row['item_code'] }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">{{ $row['description'] }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">{{ $row['size'] }}</td>
                                    <td class="px-3 py-2 text-center whitespace-nowrap">
                                        @if($row['status'] == 'Manual')
                                            <flux:badge size="xs" color="blue">Manual</flux:badge>
                                        @elseif($row['status'] == 'System')
                                            <flux:badge size="xs" color="green">System</flux:badge>
                                        @elseif($row['status'] == 'Not Use')
                                            <flux:badge size="xs" color="gray">Not Use</flux:badge>
                                        @else
                                            <flux:badge size="xs" color="yellow">{{ $row['status'] }}</flux:badge>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-center whitespace-nowrap">{{ $row['qty'] }}</td>
                                    <td class="px-3 py-2 min-w-[150px]">
                                        @php
                                            $reasonType = isset($row['reason_type']) ? strtolower($row['reason_type']) : 'pergantian';
                                        @endphp
                                        @if($reasonType === 'ng_esd')
                                            @if(!empty($row['reason']))
                                                {{ Str::limit($row['reason'], 30) }}
                                            @else
                                                <span class="text-xs text-zinc-400">-</span>
                                            @endif
                                        @elseif($reasonType === 'new_employee')
                                            <span class="text-xs text-green-600 dark:text-green-400">-</span>
                                        @else
                                            {{ Str::limit($row['reason'] ?? '-', 30) }}
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        @if(isset($row['reason_type']))
                                            @if($row['reason_type'] === 'ng_esd')
                                                <flux:badge size="xs" color="red">NG ESD</flux:badge>
                                            @elseif($row['reason_type'] === 'new_employee')
                                                <flux:badge size="xs" color="green">New Employee</flux:badge>
                                            @else
                                                <flux:badge size="xs" color="blue">Pergantian</flux:badge>
                                            @endif
                                        @else
                                            <span class="text-xs text-zinc-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        @if(isset($row['reason_type']) && $row['reason_type'] === 'ng_esd' && !empty($row['reason_file']))
                                            <a href="{{ Storage::url($row['reason_file']) }}" target="_blank" 
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-xs inline-flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                {{ $row['reason_file_name'] ?? 'View PDF' }}
                                            </a>
                                        @else
                                            <span class="text-xs text-zinc-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">{{ $row['group'] }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">{{ \Carbon\Carbon::parse($row['request_date'])->format('d/m/Y') }}</td>
                                    <td class="px-3 py-2 min-w-[100px]">{{ Str::limit($row['remarks'], 20) ?? '-' }}</td>
                                    <td class="px-3 py-2 text-center whitespace-nowrap">
                                        <button type="button" wire:click="removeRow({{ $index }})" class="text-red-600 hover:text-red-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                @php $isFirst = false; @endphp
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($paginatedRows->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $paginatedRows->links() }}
            </div>
            @endif
        </flux:card>
        @endif
        <!-- Form Actions -->
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('prod.uniform.request.index') }}" wire:navigate 
                class="px-4 py-2 bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-300 dark:border-zinc-600 rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                Cancel
            </a>
            <button type="submit" 
                wire:loading.attr="disabled"
                wire:target="save"
                {{ count($rows) == 0 ? 'disabled' : '' }}
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors inline-flex items-center gap-2 {{ count($rows) == 0 ? 'opacity-50 cursor-not-allowed' : '' }}">
                <svg wire:loading wire:target="save" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="save">{{ $requestId ? 'Update Request' : 'Create Request' }}</span>
                <span wire:loading wire:target="save">Processing...</span>
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('livewire:init', function () {
            // Listener untuk start lock check
            Livewire.on('startLockCheck', (data) => {
                setInterval(() => {
                    @this.call('checkLockStatus');
                }, data.interval * 1000);
            });

            // Listener untuk lock taken
            Livewire.on('lockTaken', (data) => {
                // Tampilkan notifikasi
                const message = `⚠️ Form ini sedang digunakan oleh: ${data.owner}. Akan expired pada ${data.expires_at}`;
                
                // Cek apakah ada notifikasi yang sudah ada
                let notification = document.getElementById('lockNotification');
                if (!notification) {
                    notification = document.createElement('div');
                    notification.id = 'lockNotification';
                    notification.className = 'fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg max-w-md';
                    notification.style.display = 'none';
                    document.body.appendChild(notification);
                }
                
                notification.innerHTML = `
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <p class="font-semibold">Form sedang digunakan!</p>
                            <p class="text-sm">Oleh: <strong>${data.owner}</strong></p>
                            <p class="text-xs opacity-75">Expired: ${data.expires_at}</p>
                        </div>
                    </div>
                `;
                notification.style.display = 'block';
                
                // Hilangkan setelah 5 detik
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 5000);
            });

            // Release lock saat page ditutup atau refresh
            window.addEventListener('beforeunload', function() {
                @this.call('releaseLock');
            });
        });
        document.addEventListener('livewire:init', function () {
            // Debug untuk melihat jumlah item
            Livewire.on('debugUniformCount', (data) => {
                console.log('Jumlah uniform:', data.count);
            });
        });
    </script>

    <style>
        /* Hanya untuk scrollbar - tidak ada override !important */
        .max-h-\[400px\] {
            max-height: 400px !important;
        }

        .overflow-y-auto {
            overflow-y: auto !important;
        }

        /* Custom scrollbar untuk uniform list */
        .max-h-\[400px\]::-webkit-scrollbar {
            width: 4px;
        }

        .max-h-\[400px\]::-webkit-scrollbar-track {
            background: transparent;
        }

        .max-h-\[400px\]::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .max-h-\[400px\]::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .dark .max-h-\[400px\]::-webkit-scrollbar-thumb {
            background: #3f3f46;
        }

        .dark .max-h-\[400px\]::-webkit-scrollbar-thumb:hover {
            background: #52525b;
        }

        /* Firefox */
        .max-h-\[400px\] {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }
        [x-cloak] { display: none !important; }
        [x-cloak] { display: none !important; }
        .overflow-x-auto {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f1f1;
        }
        #lockNotification {
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .overflow-x-auto {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f1f1;
        }
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .dark .overflow-x-auto::-webkit-scrollbar-track {
            background: #1f1f1f;
        }
        .dark .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #3f3f46;
        }
        .dark .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #52525b;
        }
        .max-h-\[400px\]::-webkit-scrollbar {
        width: 4px;
        }
        .max-h-\[400px\]::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .max-h-\[400px\]::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .max-h-\[400px\]::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .dark .max-h-\[400px\]::-webkit-scrollbar-track {
            background: #1f1f1f;
        }
        .dark .max-h-\[400px\]::-webkit-scrollbar-thumb {
            background: #3f3f46;
        }
        .dark .max-h-\[400px\]::-webkit-scrollbar-thumb:hover {
            background: #52525b;
        }
        /* CSS untuk scrollbar yang hilang saat tidak di-hover */
        .uniform-list-scroll {
            scrollbar-width: thin;
            scrollbar-color: transparent transparent;
            transition: scrollbar-color 0.3s ease;
        }
        
        .uniform-list-scroll:hover {
            scrollbar-color: #cbd5e1 #f1f1f1;
        }
        
        .uniform-list-scroll::-webkit-scrollbar {
            width: 4px;
            height: 4px;
            transition: all 0.3s ease;
        }
        
        .uniform-list-scroll::-webkit-scrollbar-track {
            background: transparent;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .uniform-list-scroll::-webkit-scrollbar-thumb {
            background: transparent;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .uniform-list-scroll:hover::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .uniform-list-scroll:hover::-webkit-scrollbar-thumb {
            background: #cbd5e1;
        }
        
        .uniform-list-scroll:hover::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Dark mode */
        .dark .uniform-list-scroll:hover::-webkit-scrollbar-track {
            background: #1f1f1f;
        }
        
        .dark .uniform-list-scroll:hover::-webkit-scrollbar-thumb {
            background: #3f3f46;
        }
        
        .dark .uniform-list-scroll:hover::-webkit-scrollbar-thumb:hover {
            background: #52525b;
        }
        .uniform-list-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .uniform-list-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .uniform-list-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .uniform-list-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        /* Custom Scrollbar */
        .uniform-list-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .uniform-list-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .uniform-list-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .uniform-list-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Firefox */
        .uniform-list-scroll {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }
        /* Custom Scrollbar untuk uniform list */
        .uniform-list-scroll {
            max-height: 400px !important;
            overflow-y: auto !important;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }

        .uniform-list-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .uniform-list-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .uniform-list-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .uniform-list-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Dark mode */
        .dark .uniform-list-scroll::-webkit-scrollbar-thumb {
            background: #3f3f46;
        }

        .dark .uniform-list-scroll::-webkit-scrollbar-thumb:hover {
            background: #52525b;
        }
    </style>
</div>