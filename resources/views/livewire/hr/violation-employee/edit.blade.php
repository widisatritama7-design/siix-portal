<div class="p-1 space-y-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            HR
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('hr.violation.index') }}" wire:navigate separator="slash">
            Violation Employee
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Edit
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Edit Violation Record
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Update employee violation record
            </p>
        </div>
    </div>

    <!-- Form -->
    <form wire:submit.prevent="update">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
                <flux:card class="p-6 space-y-4">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-white border-b border-zinc-200 dark:border-zinc-700 pb-2">
                        Employee Information
                    </h2>
                    
                    <!-- NIK -->
                    <div>
                        <flux:label>NIK</flux:label>
                        <flux:input wire:model="nik" type="text" disabled class="w-full bg-zinc-50 dark:bg-zinc-800/50" />
                    </div>
                    
                    <!-- Name -->
                    <div>
                        <flux:label>Name</flux:label>
                        <flux:input wire:model="name" type="text" disabled class="w-full bg-zinc-50 dark:bg-zinc-800/50" />
                    </div>
                    
                    <!-- Department -->
                    <div>
                        <flux:label>Department</flux:label>
                        <flux:input wire:model="dept" type="text" disabled class="w-full bg-zinc-50 dark:bg-zinc-800/50" />
                    </div>
                    
                    <!-- Status -->
                    <div>
                        <flux:label>Status</flux:label>
                        <flux:input wire:model="status_display" type="text" disabled class="w-full bg-zinc-50 dark:bg-zinc-800/50" />
                    </div>
                    
                    <!-- Shift -->
                    <div>
                        <flux:label>Shift *</flux:label>
                        <flux:select wire:model="shift" class="w-full" required>
                            <flux:select.option value="">Select Shift</flux:select.option>
                            @foreach($shifts as $key => $value)
                                <flux:select.option value="{{ $key }}">{{ $value }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        @error('shift') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </flux:card>
                
                <flux:card class="p-6 space-y-4">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-white border-b border-zinc-200 dark:border-zinc-700 pb-2">
                        Violation Details
                    </h2>
                    
                    <!-- Category -->
                    <div>
                        <flux:label>Category *</flux:label>
                        <flux:select wire:model.live="category" class="w-full" required>
                            <flux:select.option value="">Select Category</flux:select.option>
                            @foreach($categories as $key => $value)
                                <flux:select.option value="{{ $key }}">{{ $value }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        @error('category') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Sub Category -->
                    @if($category === 'Kendaraan')
                    <div>
                        <flux:label>Sub Category *</flux:label>
                        <div class="space-y-2 border border-zinc-200 dark:border-zinc-700 rounded-lg p-3 max-h-60 overflow-y-auto">
                            @foreach($this->subCategoryOptions as $key => $value)
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" wire:model="sub_category" value="{{ $key }}" class="rounded border-zinc-300 dark:border-zinc-600">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $value }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('sub_category') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    @endif
                    
                    <!-- Plate Motor -->
                    @if($category !== 'Uniform' && $category !== 'Membawa Barang Pribadi')
                    <div>
                        <flux:label>Plate Number *</flux:label>
                        <flux:input wire:model="plat_motor" type="text" class="w-full" placeholder="Enter plate number" />
                        @error('plat_motor') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    @endif
                </flux:card>
            </div>
            
            <!-- Right Column -->
            <div class="space-y-4">
                <flux:card class="p-6 space-y-4">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-white border-b border-zinc-200 dark:border-zinc-700 pb-2">
                        Incident Information
                    </h2>
                    
                    <!-- Security Name -->
                    <div>
                        <flux:label>Security Name *</flux:label>
                        <flux:input wire:model="security_name" type="text" class="w-full" placeholder="Enter security name" />
                        @error('security_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Date -->
                    <div>
                        <flux:label>Date *</flux:label>
                        <flux:input wire:model="date" type="date" class="w-full" />
                        @error('date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Reason -->
                    <div>
                        <flux:label>Reason *</flux:label>
                        <flux:textarea wire:model="alasan" rows="3" class="w-full" placeholder="Enter reason for violation" />
                        @error('alasan') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Remarks -->
                    <div>
                        <flux:label>Remarks</flux:label>
                        <flux:textarea wire:model="remarks" rows="2" class="w-full" placeholder="Enter any remarks" />
                    </div>
                    
                    <!-- Photo -->
                    <div>
                        <flux:label>Photo Evidence</flux:label>
                        <input type="file" wire:model="photo" class="w-full border border-zinc-200 dark:border-zinc-700 rounded-lg p-2" accept="image/*">
                        @error('photo') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        @if($photo)
                            <div class="mt-2">
                                <img src="{{ $photo->temporaryUrl() }}" class="max-h-32 rounded-lg">
                            </div>
                        @elseif($existingPhoto)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $existingPhoto) }}" class="max-h-32 rounded-lg">
                            </div>
                        @endif
                    </div>
                </flux:card>
                
                <!-- Employee Call Count Badge -->
                @if($nik)
                <flux:card class="p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">Total Employee Call:</span>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $employee_call_count == 0 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $employee_call_count == 0 ? 'Belum mendapat Panggilan dari HR' : "Sudah mendapat Panggilan dari HR ({$employee_call_count} kali)" }}
                        </span>
                    </div>
                </flux:card>
                @endif
            </div>
        </div>
        
        <!-- Monthly Violation Summary -->
        @if($nik && !empty($sub_category_counts))
        <flux:card class="p-6 mt-6">
            <h2 class="text-lg font-semibold text-zinc-800 dark:text-white border-b border-zinc-200 dark:border-zinc-700 pb-2 mb-4">
                Riwayat Pelanggaran (30 Hari Terakhir)
            </h2>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                            <th class="px-4 py-2 text-left">Kategori</th>
                            <th class="px-4 py-2 text-left">Jenis Pelanggaran</th>
                            <th class="px-4 py-2 text-center">Terakhir</th>
                            <th class="px-4 py-2 text-center">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($sub_category_counts as $subCat => $count)
                        <tr>
                            <td class="px-4 py-2">-</td>
                            <td class="px-4 py-2">{{ $subCat }}</td>
                            <td class="px-4 py-2 text-center">{{ $last_violation_date }}</td>
                            <td class="px-4 py-2 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    {{ $count }}x
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="bg-zinc-100 dark:bg-zinc-800/30 font-medium">
                            <td colspan="2" class="px-4 py-2 text-right">Total Pelanggaran:</td>
                            <td class="px-4 py-2 text-center">{{ $last_violation_date }}</td>
                            <td class="px-4 py-2 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-600 text-white">
                                    {{ $total_monthly_violations }}x
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </flux:card>
        @endif
        
        <!-- Reminder Card -->
        @if($nik && !empty($sub_category_counts))
        <flux:card class="p-6 mt-6 bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-800">
            <h2 class="text-lg font-semibold text-amber-800 dark:text-amber-400 flex items-center gap-2 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                Reminder Panggilan ke Admin
            </h2>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-amber-100 dark:bg-amber-900/30">
                        <tr>
                            <th class="px-4 py-2 text-left">Jenis Pelanggaran</th>
                            <th class="px-4 py-2 text-center">Jumlah</th>
                            <th class="px-4 py-2 text-center">Terakhir</th>
                            <th class="px-4 py-2 text-center">Reminder</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-200 dark:divide-amber-800">
                        @php
                            $reminderRules = [
                                'Tidak Ada Stiker (SIM & STNK Lengkap)' => ['threshold' => 5, 'color' => 'red'],
                                'Tidak membawa STNK/Tidak ada STNK' => ['threshold' => 1, 'color' => 'yellow'],
                                'STNK Expired' => ['threshold' => 1, 'color' => 'yellow'],
                                'Tidak membawa SIM/Tidak ada SIM' => ['threshold' => 1, 'color' => 'yellow'],
                                'SIM Expired' => ['threshold' => 1, 'color' => 'yellow'],
                                'Plat Kendaraan Mati' => ['threshold' => 1, 'color' => 'yellow'],
                                'Kendaraan tidak sesuai standar (cth. Tidak ada spion,tidak ada plat No dll)' => ['threshold' => 1, 'color' => 'yellow'],
                            ];
                            $hasReminder = false;
                        @endphp
                        @foreach($sub_category_counts as $subCat => $count)
                            @php
                                $rule = $reminderRules[$subCat] ?? null;
                            @endphp
                            @if($rule && $count >= $rule['threshold'])
                                @php $hasReminder = true; @endphp
                                <tr class="bg-{{ $rule['color'] == 'red' ? 'red-50' : 'yellow-50' }} dark:bg-{{ $rule['color'] == 'red' ? 'red-950/30' : 'yellow-950/30' }}">
                                    <td class="px-4 py-2">{{ $subCat }}</td>
                                    <td class="px-4 py-2 text-center font-bold">{{ $count }}x</td>
                                    <td class="px-4 py-2 text-center">{{ $last_violation_date }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white border {{ $rule['color'] == 'red' ? 'border-red-300 text-red-700' : 'border-yellow-300 text-yellow-700' }}">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                            </svg>
                                            Panggil ke Admin
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        @if(!$hasReminder)
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500 italic">
                                Tidak ada pelanggaran yang memerlukan panggilan admin
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </flux:card>
        @endif
        
        <!-- Form Actions -->
        <div class="flex justify-end gap-3 mt-6">
            <flux:button wire:click="cancel" variant="outline">
                Cancel
            </flux:button>
            <flux:button type="submit" variant="primary">
                Update Violation Record
            </flux:button>
        </div>
    </form>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>