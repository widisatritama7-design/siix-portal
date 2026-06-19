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
            <p class="text-sm text-zinc-500">Add multiple rows for different employees and uniforms</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
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
        <!-- FORM ADD NEW ROW - DI ATAS -->
        <flux:card class="p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Add New Row</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div>
                    <!-- Employee Dropdown with Search + Manual Input -->
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-sm font-medium">Employee Information<span class="text-red-500">*</span></label>
                            
                            @if($canManual)
                                <button type="button" 
                                    wire:click="toggleManualInput"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition-colors shadow-sm">
                                    @if($isManualInput)
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-4.28 9.22a.75.75 0 0 0 0 1.06l3 3a.75.75 0 1 0 1.06-1.06l-1.72-1.72h5.69a.75.75 0 0 0 0-1.5h-5.69l1.72-1.72a.75.75 0 0 0-1.06-1.06l-3 3Z" clip-rule="evenodd" />
                                        </svg>
                                        Back to Search
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
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
                                <div class="grid grid-cols-3 gap-2">
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
                            <!-- Regular Search Dropdown -->
                            <div x-data="{ show: false, search: @entangle('employeeSearch') }" class="relative">
                                <input 
                                    type="text"
                                    x-model="search"
                                    @input="show = search.trim().length > 0"
                                    placeholder="Search by NIK or name..."
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white"
                                >

                                <div 
                                    x-show="show"
                                    x-transition
                                    @click.outside="show = false"
                                    class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-800 border rounded-lg shadow-lg max-h-60 overflow-y-auto"
                                    style="display: none;"
                                >
                                    @foreach($this->employees as $value => $label)
                                        <div 
                                            x-show="'{{ strtolower($label) }}'.includes(search.toLowerCase()) 
                                                    || '{{ $value }}'.includes(search)"
                                            @click="
                                                $wire.set('current_employee_id', '{{ $value }}'); 
                                                $wire.set('employeeSearch', '{{ $label }}');
                                                search = '{{ $label }}'; 
                                                show = false;
                                            "
                                            class="px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700 cursor-pointer text-sm"
                                        >
                                            <span>{{ $label }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <input type="hidden" wire:model="current_employee_id">

                                @error('current_employee_id') 
                                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                                @enderror
                            </div>
                        @endif
                    </div>

                    <!-- Uniform Dropdown with Search -->
                    <div class="mb-4">
                        <div x-data="{ show: false, search: @entangle('uniformSearch') }" class="relative">
                            <label class="block text-sm font-medium mb-1">Uniform <span class="text-red-500">*</span></label>

                            <input 
                                type="text"
                                x-model="search"
                                @input="show = search.trim().length > 0"
                                placeholder="Search by item code, description, or size..."
                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white"
                            >

                            <div 
                                x-show="show"
                                x-transition
                                @click.outside="show = false"
                                class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-800 border rounded-lg shadow-lg max-h-60 overflow-y-auto"
                                style="display: none;"
                            >
                                @foreach($this->uniforms as $value => $label)
                                    <div 
                                        x-show="'{{ strtolower($label) }}'.includes(search.toLowerCase()) 
                                                || '{{ $value }}'.includes(search)"
                                        @click="
                                            $wire.set('current_master_uniform_id', '{{ $value }}'); 
                                            $wire.set('uniformSearch', '{{ $label }}');
                                            search = '{{ $label }}'; 
                                            show = false;
                                        "
                                        class="px-3 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700 cursor-pointer text-sm"
                                    >
                                        <span>{{ $label }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <input type="hidden" wire:model="current_master_uniform_id">

                            @error('current_master_uniform_id') 
                                <span class="text-red-500 text-xs">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Quantity <span class="text-red-500">*</span></label>
                        <input type="number" wire:model="current_qty" min="1" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800">
                        @error('current_qty') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Group <span class="text-red-500">*</span></label>
                        <select wire:model="current_group" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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

                <!-- Right Column -->
                <div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Request Date <span class="text-red-500">*</span></label>
                        <input type="date" wire:model="current_request_date" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800">
                        @error('current_request_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Reason <span class="text-red-500">*</span></label>
                        <textarea wire:model="current_reason" rows="3" placeholder="Reason for request..." class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800"></textarea>
                        @error('current_reason') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Remarks</label>
                        <textarea wire:model="current_remarks" rows="2" placeholder="Additional remarks..." class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800"></textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="button" wire:click="addRow" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    + Add Row
                </button>
            </div>
        </flux:card>

        <!-- REQUEST ITEMS TABLE - DI BAWAH -->
        @if(count($rows) > 0)
        <flux:card class="p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Request Items</h2>
                <div class="text-sm text-zinc-500">
                    Total: {{ $paginatedRows->total() }} row(s)
                </div>
            </div>
            
            <!-- SCROLL HORIZONTAL - TANPA WRAP -->
            <div class="overflow-x-auto" style="overflow-x: auto !important; white-space: nowrap !important;">
                <table class="w-full text-sm border" style="min-width: 1600px;">
                    <thead class="bg-zinc-100 dark:bg-zinc-800">
                        <tr>
                            <th class="px-3 py-2 text-left">NIK</th>
                            <th class="px-3 py-2 text-left">NAME</th>
                            <th class="px-3 py-2 text-left">DEPARTMENT</th>  {{-- TAMBAHKAN --}}
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
            
            <!-- PAGINATION -->
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
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors inline-flex items-center gap-2">
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
        /* Scroll horizontal smooth */
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