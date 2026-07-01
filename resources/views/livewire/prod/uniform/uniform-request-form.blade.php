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

    @php
        $isOneUser = auth()->user()->can('view uniform request one user');
        $isFullAccess = auth()->user()->can('view uniform request');
        $canManual = auth()->user()->can('feedback uniform request admin');
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
                <span>You have Admin access. You can use <strong>"Manual Input"</strong> for employees not registered in database.</span>
            </p>
        </div>
    @endif

    <form wire:submit="save">
        @php
            $isOneUser = auth()->user()->can('view uniform request one user');
            $isFullAccess = auth()->user()->can('view uniform request');
            $canManual = auth()->user()->can('feedback uniform request admin');
            
            $isEmployeeSelected = !is_null($current_employee_id) || ($isManualInput && $canManual && !empty($manualNik) && !empty($manualName));
            $isGroupSelected = !empty($current_group) && $current_group !== '';
            $isFormReady = $isEmployeeSelected && $isGroupSelected;
            $hasCartItems = count($current_uniforms) > 0;
        @endphp
        <!-- FORM ADD NEW ROW -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
            <!-- LEFT COLUMN (70%) -->
            <div class="lg:col-span-8 xl:col-span-8 space-y-6">
                <!-- CARD 1: Input Employee & Uniform -->
                <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h2 class="text-lg font-semibold mb-4">Input Employee & Uniform</h2>
                    
                    <!-- Employee, Request Date & Group in one row -->
                    <div class="mb-4">
                        <!-- 3 Column Row -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Employee Information -->
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <label class="block text-sm font-medium">Employee Information <span class="text-red-500">*</span></label>
                                    
                                    @if($canManual)
                                        <button type="button" 
                                            wire:click="toggleManualInput"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition-colors shadow-sm whitespace-nowrap">
                                            @if($isManualInput)
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3.5">
                                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-4.28 9.22a.75.75 0 0 0 0 1.06l3 3a.75.75 0 1 0 1.06-1.06l-1.72-1.72h5.69a.75.75 0 0 0 0-1.5h-5.69l1.72-1.72a.75.75 0 0 0-1.06-1.06l-3 3Z" clip-rule="evenodd" />
                                                </svg>
                                                Back to Search
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-3.5">
                                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                                </svg>
                                                Manual Input
                                            @endif
                                        </button>
                                    @endif
                                </div>

                                @if($isManualInput && $canManual)
                                    <!-- Manual Input Form -->
                                    <div class="space-y-2 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                        <p class="text-xs text-yellow-600 dark:text-yellow-400">
                                            Manual input for employees not registered in database
                                        </p>
                                        <div class="grid grid-cols-1 gap-2">
                                            <input type="text" 
                                                wire:model="manualNik"
                                                placeholder="NIK | Jika tidak ada beri ( - )"
                                                class="px-3 py-2 border rounded-lg dark:bg-zinc-800 text-sm">
                                            <input type="text" 
                                                wire:model="manualName"
                                                placeholder="Full Name *"
                                                class="px-3 py-2 border rounded-lg dark:bg-zinc-800 text-sm">
                                            <input type="text" 
                                                wire:model="manualDepartment"
                                                placeholder="Department *"
                                                class="px-3 py-2 border rounded-lg dark:bg-zinc-800 text-sm">
                                        </div>
                                        @error('manualNik') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        @error('manualName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        @error('manualDepartment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                @else
                                    <!-- Search Input -->
                                    <div x-data="{ search: @entangle('employeeSearch') }">
                                        <input 
                                            type="text"
                                            x-model="search"
                                            @input="$wire.set('employeeSearch', search)"
                                            placeholder="Search by NIK or name..."
                                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white text-sm"
                                        >

                                        <input type="hidden" wire:model="current_employee_id">

                                        @error('current_employee_id') 
                                            <span class="text-red-500 text-xs">{{ $message }}</span> 
                                        @enderror
                                    </div>
                                @endif
                            </div>

                            <!-- Request Date -->
                            <div>
                                <label class="block text-sm font-medium mb-1">Request Date <span class="text-red-500">*</span></label>
                                <input type="date" 
                                    wire:model="current_request_date" 
                                    disabled
                                    class="w-full px-3 py-2 border rounded-lg bg-gray-100 dark:bg-zinc-700 dark:border-zinc-600 cursor-not-allowed text-gray-500 dark:text-gray-400 text-sm">
                                @error('current_request_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Group -->
                            <div>
                                <label class="block text-sm font-medium mb-1">Group <span class="text-red-500">*</span></label>
                                <select wire:model="current_group" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
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

                        <!-- Results Table & Selected Employee - Full Width di Bawah 3 Column -->
                        @if(!$isManualInput || !$canManual)
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
                </flux:card>

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
                            <div class="overflow-x-auto max-h-60 overflow-y-auto" style="overflow-x: auto !important; white-space: nowrap !important;">
                                <table class="w-full text-sm" style="min-width: 650px;">
                                    <thead class="bg-zinc-100 dark:bg-zinc-800 sticky top-0 z-10">
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Item Code</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Description</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Size</th>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Available</th>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Reserved</th>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                        @forelse($availableUniforms as $uniform)
                                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                            <td class="px-3 py-2 text-sm font-mono whitespace-nowrap">{{ $uniform->item_code }}</td>
                                            <td class="px-3 py-2 text-sm whitespace-nowrap">{{ $uniform->description }}</td>
                                            <td class="px-3 py-2 text-sm whitespace-nowrap">
                                                <flux:badge size="sm" color="purple">{{ $uniform->size }}</flux:badge>
                                            </td>
                                            <td class="px-3 py-2 text-center whitespace-nowrap">
                                                <span class="text-sm font-semibold {{ $uniform->available_qty <= 5 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                                    {{ $uniform->available_qty }}
                                                </span>
                                                @if($uniform->available_qty <= 5 && $uniform->available_qty > 0)
                                                    <flux:badge size="xs" color="red">Low</flux:badge>
                                                @elseif($uniform->available_qty == 0)
                                                    <flux:badge size="xs" color="red">Out</flux:badge>
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
                                                <button type="button" 
                                                    wire:click="$set('current_master_uniform_id', {{ $uniform->id }})"
                                                    class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:hover:bg-blue-900/50 transition-colors">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    Select
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="px-3 py-4 text-center text-sm text-zinc-500">
                                                @if($uniformSearch)
                                                    No uniforms found matching "<span class="font-medium">{{ $uniformSearch }}</span>"
                                                @else
                                                    No uniforms available with stock
                                                @endif
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if($availableUniforms->hasPages())
                            <div class="p-2 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50">
                                {{ $availableUniforms->appends(['uniformSearch' => $uniformSearch])->links() }}
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
                                            class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 dark:text-red-400 dark:bg-red-900/20 dark:hover:bg-red-900/30 rounded-lg transition-colors"
                                            title="Cancel selected uniform">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Input Fields -->
                            <div class="p-3">
                                <div class="grid grid-cols-12 gap-3 items-end">
                                    <!-- Quantity -->
                                    <div class="col-span-12 sm:col-span-2">
                                        <label class="block text-xs font-medium mb-1 text-zinc-600 dark:text-zinc-400 text-center">Qty <span class="text-red-500">*</span></label>
                                        <input type="number" 
                                            wire:model="current_qty" 
                                            min="1"
                                            class="w-full px-2 py-2 border rounded-lg dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center">
                                        @error('current_qty') <span class="text-red-500 text-xs block mt-1 text-center">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <!-- Reason -->
                                    <div class="col-span-12 sm:col-span-4">
                                        <label class="block text-xs font-medium mb-1 text-zinc-600 dark:text-zinc-400">Reason <span class="text-red-500">*</span></label>
                                        <input type="text" 
                                            wire:model="current_reason" 
                                            placeholder="Enter reason..."
                                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        @error('current_reason') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <!-- Remarks -->
                                    <div class="col-span-12 sm:col-span-4">
                                        <label class="block text-xs font-medium mb-1 text-zinc-600 dark:text-zinc-400">Remarks</label>
                                        <input type="text" 
                                            wire:model="current_remarks" 
                                            placeholder="Optional..."
                                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    
                                    <!-- Tombol Add -->
                                    <div class="col-span-12 sm:col-span-2">
                                        <button type="button" 
                                            wire:click="addUniformToCurrent"
                                            class="w-full py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium inline-flex items-center justify-center gap-2 shadow-sm hover:shadow-md"
                                            title="Add Uniform">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                            </svg>
                                            <span>Add</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </flux:card>
            </div>

            <!-- RIGHT CARD - UNIFORM LIST (30%) -->
            <div class="lg:col-span-4 xl:col-span-4">
                <flux:card class="p-4 h-auto shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-lg font-semibold mb-4">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Uniform List
                            </span>
                        </h2>
                        <span class="text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-2 py-0.5 rounded-full font-medium">
                            {{ count($current_uniforms) }} item(s)
                        </span>
                    </div>

                    @if(count($current_uniforms) > 0)
                        <div class="border rounded-lg overflow-hidden max-h-[350px] overflow-y-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-zinc-100 dark:bg-zinc-800 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-2 py-1.5 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Item</th>
                                        <th class="px-2 py-1.5 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Qty</th>
                                        <th class="px-2 py-1.5 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                    @foreach($current_uniforms as $index => $uniform)
                                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                            <td class="px-2 py-1.5">
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400">{{ $uniform['item_code'] }}</span>
                                                    <span class="text-[10px] text-zinc-500 truncate max-w-[100px]">{{ $uniform['description'] }}</span>
                                                    <span class="text-[10px] text-zinc-400">{{ $uniform['size'] }}</span>
                                                </div>
                                            </td>
                                            <td class="px-2 py-1.5 text-center">
                                                <span class="text-xs font-semibold text-blue-600 dark:text-blue-400">x {{ $uniform['qty'] }}</span>
                                            </td>
                                            <td class="px-2 py-1.5 text-center">
                                                <button type="button" 
                                                    wire:click="removeUniformFromCurrent({{ $index }})"
                                                    class="text-red-400 hover:text-red-600 dark:text-red-500 dark:hover:text-red-400 transition-colors p-1.5 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg inline-flex items-center justify-center"
                                                    title="Remove">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Summary -->
                        <div class="mt-2 pt-2 border-t border-zinc-200 dark:border-zinc-700">
                            <div class="flex justify-between text-xs">
                                <span class="text-zinc-500">Total Items:</span>
                                <span class="font-semibold text-zinc-700 dark:text-zinc-300">{{ count($current_uniforms) }}</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-zinc-500">Total Quantity:</span>
                                <span class="font-semibold text-zinc-700 dark:text-zinc-300">{{ array_sum(array_column($current_uniforms, 'qty')) }}</span>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-6 text-center">
                            <svg class="w-12 h-12 text-zinc-300 dark:text-zinc-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">No uniforms added yet</p>
                            <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">Add uniforms using the form on the left</p>
                        </div>
                    @endif

                    <!-- Tombol Add Employee Request di bawah list -->
                    <div class="border-t pt-3 mt-3">
                        <button type="button" 
                            wire:click="addRow" 
                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium text-sm {{ !$hasCartItems ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ !$hasCartItems ? 'disabled' : '' }}
                            title="{{ !$hasCartItems ? 'Please add at least one uniform to cart' : 'Add Employee Request' }}">
                            + Add Employee Request ({{ count($current_uniforms) }} uniform(s))
                        </button>
                    </div>
                </flux:card>
            </div>
        </div>

        <!-- REQUEST ITEMS TABLE -->
        @if(count($rows) > 0)
        <flux:card class="p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Request Items</h2>
                <div class="text-sm text-zinc-500">
                    Total: {{ $paginatedRows->total() }} row(s)
                </div>
            </div>
            
            <div class="overflow-x-auto" style="overflow-x: auto !important; white-space: nowrap !important;">
                <table class="w-full text-sm border" style="min-width: 1600px;">
                    <thead class="bg-zinc-100 dark:bg-zinc-800">
                        <tr>
                            <th class="px-3 py-2 text-left">NIK</th>
                            <th class="px-3 py-2 text-left">NAME</th>
                            <th class="px-3 py-2 text-left">DEPARTMENT</th>
                            <th class="px-3 py-2 text-left">ITEM CODE</th>
                            <th class="px-3 py-2 text-left">DESCRIPTION</th>
                            <th class="px-3 py-2 text-left">SIZE</th>
                            <th class="px-3 py-2 text-center">QTY</th>
                            <th class="px-3 py-2 text-left">REASON</th>
                            <th class="px-3 py-2 text-left">GROUP</th>
                            <th class="px-3 py-2 text-left">REQUEST DATE</th>
                            <th class="px-3 py-2 text-left">REMARKS</th>
                            <th class="px-3 py-2 text-center">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paginatedRows as $index => $row)
                        <tr class="border-t hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="px-3 py-2 whitespace-nowrap">
                                @if(isset($row['is_manual']) && $row['is_manual'])
                                    <div class="flex items-center gap-1">
                                        <span class="text-xs text-yellow-600 dark:text-yellow-400">(Manual)</span>
                                        <span>{{ $row['manual_nik'] ?? $row['employee_nik'] }}</span>
                                    </div>
                                @else
                                    {{ $row['employee_nik'] }}
                                @endif
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap">
                                @if(isset($row['is_manual']) && $row['is_manual'])
                                    {{ $row['manual_name'] ?? $row['employee_name'] }}
                                @else
                                    {{ $row['employee_name'] }}
                                @endif
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap">
                                @if(isset($row['is_manual']) && $row['is_manual'])
                                    {{ $row['manual_department'] ?? $row['employee_department'] }}
                                @else
                                    {{ $row['employee_department'] }}
                                @endif
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ $row['item_code'] }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ $row['description'] }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ $row['size'] }}</td>
                            <td class="px-3 py-2 text-center whitespace-nowrap">{{ $row['qty'] }}</td>
                            <td class="px-3 py-2 min-w-[150px]">{{ Str::limit($row['reason'], 30) }}</td>
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

    <style>
        [x-cloak] { display: none !important; }
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
    </style>
</div>