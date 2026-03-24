<div class="p-1 space-y-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            HR
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('hr.comelate.index') }}" wire:navigate separator="slash">
            Comelate Employee
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Edit
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-zinc-800 dark:text-white">
                Edit Comelate Record
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Edit employee lateness data
            </p>
        </div>
    </div>

    <!-- Form with Left-Right Layout -->
    <form wire:submit="update">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
                <!-- Employee Information Card -->
                <flux:card class="p-6 space-y-4">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-white border-b border-zinc-200 dark:border-zinc-700 pb-2">
                        Employee Information
                    </h2>
                    
                    <!-- Employee (disabled on edit) -->
                    <div>
                        <flux:label required>Employee</flux:label>
                        <flux:input wire:model="employeeLabel" disabled class="w-full bg-zinc-50 dark:bg-zinc-800/50" />
                        <input type="hidden" wire:model="nik">
                        @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Name -->
                    <div>
                        <flux:label>Name</flux:label>
                        <flux:input wire:model="name" type="text" disabled class="w-full bg-zinc-50 dark:bg-zinc-800/50" />
                    </div>
                    
                    <!-- Department -->
                    <div>
                        <flux:label>Department</flux:label>
                        <flux:input wire:model="department" type="text" disabled class="w-full bg-zinc-50 dark:bg-zinc-800/50" />
                    </div>
                    
                    <!-- Status -->
                    <div>
                        <flux:label>Status</flux:label>
                        <flux:input wire:model="status_display" type="text" disabled class="w-full bg-zinc-50 dark:bg-zinc-800/50" />
                    </div>
                    
                    <!-- Shift -->
                    <div>
                        <flux:label required>Shift</flux:label>
                        <flux:select wire:model.live="shift" class="w-full">
                            <flux:select.option value="">Select Shift</flux:select.option>
                            @foreach($this->shifts as $key => $value)
                                <flux:select.option value="{{ $key }}">{{ $value }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        @error('shift') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </flux:card>
            </div>
            
            <!-- Right Column -->
            <div class="space-y-4">
                <!-- Attendance Information Card -->
                <flux:card class="p-6 space-y-4">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-white border-b border-zinc-200 dark:border-zinc-700 pb-2">
                        Attendance Information
                    </h2>
                    
                    <!-- Jam Masuk -->
                    <div>
                        <flux:label>Jam Masuk</flux:label>
                        <flux:input wire:model="jam_masuk" type="text" disabled class="w-full bg-zinc-50 dark:bg-zinc-800/50" />
                    </div>
                    
                    <!-- Jam Datang -->
                    <div>
                        <flux:label required>Jam Datang</flux:label>
                        <div class="flex gap-2 items-center">
                            <input 
                                type="time" 
                                wire:model.live="jam" 
                                step="60"
                                class="flex-1 px-3 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white"
                            />
                            @if($jam)
                                @php
                                    $hour = (int)\Carbon\Carbon::parse($jam)->format('H');
                                    if ($hour >= 1 && $hour <= 12) {
                                        $period = 'Pagi';
                                        $periodColor = 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400';
                                    } elseif ($hour >= 13 && $hour <= 15) {
                                        $period = 'Siang';
                                        $periodColor = 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400';
                                    } elseif ($hour >= 16 && $hour <= 18) {
                                        $period = 'Sore';
                                        $periodColor = 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400';
                                    } else {
                                        $period = 'Malam';
                                        $periodColor = 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400';
                                    }
                                @endphp
                                <span class="px-3 py-2 text-sm font-medium rounded-lg whitespace-nowrap {{ $periodColor }}">
                                    {{ $period }}
                                </span>
                            @endif
                        </div>
                        @error('jam') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Terlambat -->
                    <div>
                        <flux:label>Terlambat</flux:label>
                        <flux:input wire:model="count_jam_display" type="text" disabled class="w-full bg-zinc-50 dark:bg-zinc-800/50" />
                    </div>
                    
                    <!-- Tanggal -->
                    <div>
                        <flux:label required>Tanggal</flux:label>
                        <flux:input type="date" wire:model.live="tanggal" class="w-full" />
                        @error('tanggal') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </flux:card>
                
                <!-- Violation Details Card -->
                <flux:card class="p-6 space-y-4">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-white border-b border-zinc-200 dark:border-zinc-700 pb-2">
                        Comelate Details
                    </h2>
                    
                    <!-- Alasan Terlambat -->
                    <div>
                        <flux:label required>Alasan Terlambat</flux:label>
                        <flux:select wire:model="alasan_terlambat" class="w-full">
                            <flux:select.option value="">Select Reason</flux:select.option>
                            @foreach($this->reasonOptions as $key => $value)
                                <flux:select.option value="{{ $key }}">{{ $value }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        @error('alasan_terlambat') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Nama Security -->
                    <div>
                        <flux:label required>Nama Security</flux:label>
                        <flux:input wire:model="nama_security" type="text" placeholder="Enter security name" class="w-full" />
                        @error('nama_security') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Remarks -->
                    <div>
                        <flux:label>Remarks</flux:label>
                        <flux:textarea wire:model="remarks" rows="3" placeholder="Additional notes..." class="w-full" />
                        @error('remarks') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </flux:card>
            </div>
        </div>
        
        <!-- Employee Call Count Badge - Full Width -->
        @if($employeeCallCount !== null)
        <div class="mt-6">
            <flux:card class="p-4 {{ $employeeCallCount > 0 ? 'bg-yellow-50 dark:bg-yellow-950/30 border border-yellow-200 dark:border-yellow-800' : 'bg-green-50 dark:bg-green-950/30 border border-green-200 dark:border-green-800' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ $employeeCallCount > 0 ? 'text-yellow-600' : 'text-green-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <span class="text-sm font-medium {{ $employeeCallCount > 0 ? 'text-yellow-800 dark:text-yellow-300' : 'text-green-800 dark:text-green-300' }}">
                        {{ $employeeCallCount > 0 ? "Sudah mendapat Panggilan dari HR ({$employeeCallCount} kali)" : "Belum mendapat Panggilan dari HR" }}
                    </span>
                </div>
            </flux:card>
        </div>
        @endif
        
        <!-- Form Actions -->
        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-6">
            <flux:button href="{{ route('hr.comelate.index') }}" wire:navigate variant="outline" class="w-full sm:w-auto">
                Cancel
            </flux:button>
            <flux:button type="submit" variant="primary" class="w-full sm:w-auto">
                Update Record
            </flux:button>
        </div>
    </form>
</div>