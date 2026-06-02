{{-- resources/views/livewire/prod/absence/absence-control-generate.blade.php --}}
<div class="p-1 space-y-2">
    @section('title', 'Generate Absence Control')
    
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">HR</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Absence</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('prod.absence.control') }}" wire:navigate separator="slash">Control</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Generate</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">Generate Absence Control</h1>
            <p class="text-sm text-zinc-500">Generate absence control data by department</p>
        </div>
        <div class="flex gap-2">
            <flux:button variant="primary" icon="arrow-left" href="{{ route('prod.absence.control') }}" wire:navigate>
                Back to Control
            </flux:button>
        </div>
    </div>

    <!-- Info Banner untuk One User Access -->
    @if($isOneUserAccess)
    <div class="mb-2 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6M12 15v6" />
            </svg>
            <div>
                <span class="text-sm font-semibold text-blue-800 dark:text-blue-300">Restricted Access</span>
                <p class="text-xs text-blue-700 dark:text-blue-400">You can only generate data for department: <strong>{{ $userDepartment }}</strong></p>
            </div>
        </div>
    </div>
    @endif

    <!-- Success/Error Message -->
    @if($generatedMessage)
    <div class="p-4 rounded-lg {{ $generatedMessage['type'] === 'success' ? 'bg-green-100 text-green-800 border-green-300' : 'bg-red-100 text-red-800 border-red-300' }} border">
        {{ $generatedMessage['message'] }}
    </div>
    @endif

    <!-- Form -->
    <flux:card class="p-6 shadow-lg">
        <div class="space-y-4">
            <!-- Date Range -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Start Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" wire:model="startDate" 
                        class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('startDate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        End Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" wire:model="endDate" 
                        class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('endDate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
            
            <!-- Department Selection -->
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                    Department <span class="text-red-500">*</span>
                </label>
                <select wire:model.live="selectedDepartment" 
                    class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $isOneUserAccess ? 'bg-gray-100 dark:bg-gray-800 cursor-not-allowed opacity-60' : '' }}"
                    {{ $isOneUserAccess ? 'disabled' : '' }}>
                    <option value="">-- Select Department --</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}">{{ $dept }}</option>
                    @endforeach
                </select>
                @if($isOneUserAccess)
                <input type="hidden" wire:model="selectedDepartment" value="{{ $userDepartment }}">
                @endif
                @error('selectedDepartment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
    </flux:card>

    <!-- Employee List with Group & Shift Selection -->
    @if($selectedDepartment && count($currentPageEmployees) > 0)
    <flux:card class="p-0 shadow-lg overflow-hidden">
        <div class="p-4 border-b bg-zinc-50 dark:bg-zinc-800/50">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h2 class="font-semibold text-zinc-800 dark:text-white">Employees in {{ $selectedDepartment }}</h2>
                    <p class="text-xs text-zinc-500">Select employees and configure their group & shift</p>
                </div>
                <div class="flex gap-4 flex-wrap">
                    <!-- Selection Buttons -->
                    <div class="flex gap-2">
                        <button type="button" wire:click="selectAll" class="px-3 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600">
                            Select All
                        </button>
                        <button type="button" wire:click="deselectAll" class="px-3 py-1 text-xs bg-gray-500 text-white rounded hover:bg-gray-600">
                            Deselect All
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-zinc-100 dark:bg-zinc-800/50 sticky top-0">
                    <tr>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 w-10">
                            <input type="checkbox" wire:model.live="selectAllCheckbox" class="rounded border-zinc-300">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">NO</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">NIK</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">NAME</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">STATUS</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">CURRENT GROUP</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">NEW GROUP</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">CURRENT SHIFT</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">NEW SHIFT</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach($currentPageEmployees as $index => $employee)
                    @php
                        $isSelected = in_array($employee->id, $selectedEmployees);
                    @endphp
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors {{ !$isSelected ? 'opacity-60 bg-gray-50 dark:bg-gray-900/30' : '' }}">
                        <td class="px-4 py-2 text-center">
                            <input type="checkbox" wire:model.live="selectedEmployees" value="{{ $employee->id }}" class="rounded border-zinc-300">
                        </td>
                        <td class="px-4 py-2">{{ ($employeesPaginated->currentPage() - 1) * $employeesPaginated->perPage() + $loop->iteration }}</td>
                        <td class="px-4 py-2 font-mono">{{ $employee->nik }}</td>
                        <td class="px-4 py-2">{{ $employee->name }}</td>
                        <td class="px-4 py-2">
                            @php
                                $statusText = [
                                    '1' => 'Permanent',
                                    '2' => 'Contract',
                                    '3' => 'Magang',
                                ][$employee->status] ?? $employee->status;
                                $statusColor = 'text-green-600 bg-green-50';
                            @endphp
                            <span class="px-2 py-1 text-xs rounded-full {{ $statusColor }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 dark:bg-zinc-700">
                                {{ $employee->actual_group ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <select wire:model="employeeGroups.{{ $employee->id }}" 
                                class="px-3 py-1 text-sm border border-zinc-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 {{ !$isSelected ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ !$isSelected ? 'disabled' : '' }}>
                                @foreach($groupOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 dark:bg-zinc-700">
                                {{ $employee->actual_shift ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <select wire:model="employeeShifts.{{ $employee->id }}" 
                                class="px-3 py-1 text-sm border border-zinc-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 {{ !$isSelected ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ !$isSelected ? 'disabled' : '' }}>
                                @foreach($shiftOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Info Selected Employees -->
        <div class="px-4 py-2 border-t bg-blue-50 dark:bg-blue-900/20">
            <div class="flex justify-between items-center flex-wrap gap-2">
                <span class="text-sm text-blue-700 dark:text-blue-300">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Selected: <strong>{{ count($selectedEmployees) }}</strong> employee(s)
                </span>
                <span class="text-xs text-blue-600 dark:text-blue-400">
                    * Only selected employees will be generated
                </span>
            </div>
        </div>
        
        @if($employeesPaginated->hasPages())
        <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700">
            {{ $employeesPaginated->links() }}
        </div>
        @endif
    </flux:card>
    
    <!-- Holiday Info & Generate Button -->
    <div class="flex flex-col md:flex-row gap-4">
        <div class="flex items-center gap-2">
            <button wire:click="generate" wire:loading.attr="disabled" 
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                <svg wire:loading.remove class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <svg wire:loading class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span wire:loading.remove>Generate Selected ({{ count($selectedEmployees) }})</span>
                <span wire:loading>Generating...</span>
            </button>
            
            @if(count($selectedEmployees) > 0 && count($selectedEmployees) < $employeesPaginated->total())
            <button wire:click="generateAll" wire:loading.attr="disabled"
                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-sm flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Generate All ({{ $employeesPaginated->total() }})
            </button>
            @endif
        </div>
    </div>
    @elseif($selectedDepartment && count($currentPageEmployees) == 0)
    <div class="text-center py-8 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
        <svg class="w-12 h-12 mx-auto text-yellow-600 dark:text-yellow-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <p class="text-yellow-800 dark:text-yellow-300">No employees found in this department with active status (Permanent/Contract/Magang) and valid NIK.</p>
    </div>
    @endif

    <!-- Notification -->
    <div x-data="{ show: false, message: '', type: 'success' }" 
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
         x-show="show" x-transition class="fixed bottom-4 right-4 z-50"
         :class="{'bg-green-500': type === 'success', 'bg-red-500': type === 'error'}" style="display: none;">
        <div class="text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2" x-text="message"></div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .animate-spin {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</div>