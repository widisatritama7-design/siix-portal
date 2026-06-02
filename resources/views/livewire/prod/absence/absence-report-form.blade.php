<div class="p-1 space-y-2">
    @section('title', $reportId ? 'Edit Attendance Report' : 'Create Attendance Report')
    
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">HR</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Attendance</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('prod.absence.report.index') }}" wire:navigate separator="slash">Report</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">{{ $reportId ? 'Edit' : 'Create' }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                {{ $reportId ? 'Edit Attendance Report' : 'Create Attendance Report' }}
            </h1>
            <p class="text-sm text-zinc-500">Add multiple rows for different employees</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="save">
        <!-- FORM ADD NEW ROW -->
        <flux:card class="p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Add New Row</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <!-- Employee Dropdown -->
                    <div class="mb-4">
                        <div x-data="{ show: false, search: @entangle('employeeSearch') }" class="relative">
                            <label class="block text-sm font-medium mb-1">Employee <span class="text-red-500">*</span></label>
                            <input type="text" x-model="search" @input="show = search.trim().length > 0" placeholder="Search by NIK or name..."
                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800">
                            <div x-show="show" x-transition @click.outside="show = false"
                                class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-800 border rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                @foreach($this->employees as $value => $label)
                                    <div x-show="'{{ strtolower($label) }}'.includes(search.toLowerCase()) || '{{ $value }}'.includes(search)"
                                        @click="$wire.set('current_employee_id', '{{ $value }}'); $wire.set('employeeSearch', '{{ $label }}'); search = '{{ $label }}'; show = false;"
                                        class="px-3 py-2 hover:bg-zinc-100 cursor-pointer text-sm">
                                        <span>{{ $label }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" wire:model="current_employee_id">
                            @error('current_employee_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Group <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="current_group" placeholder="e.g., Production A, Maintenance" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800">
                        @error('current_group') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Line <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="current_line" placeholder="e.g., Line 1, Line 2" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800">
                        @error('current_line') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Jenis Ketidakhadiran <span class="text-red-500">*</span></label>
                        <select wire:model="current_jenis_ketidakhadiran" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800">
                            <option value="">Select Type</option>
                            @foreach($jenisOptions as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('current_jenis_ketidakhadiran') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Keterangan</label>
                        <textarea wire:model="current_keterangan" rows="3" placeholder="Additional information..." class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800"></textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="button" wire:click="addRow" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    + Add Row
                </button>
            </div>
        </flux:card>

        <!-- REQUEST ITEMS TABLE -->
        @if(count($rows) > 0)
        <flux:card class="p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Request Items</h2>
                <div class="text-sm text-zinc-500">Total: {{ $totalRows }} row(s)</div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm border min-w-[800px]">
                    <thead class="bg-zinc-100 dark:bg-zinc-800">
                        <tr>
                            <th class="px-3 py-2 text-left">NIK</th>
                            <th class="px-3 py-2 text-left">NAME</th>
                            <th class="px-3 py-2 text-left">GROUP</th>
                            <th class="px-3 py-2 text-left">LINE</th>
                            <th class="px-3 py-2 text-left">JENIS KETIDAKHADIRAN</th>
                            <th class="px-3 py-2 text-left">KETERANGAN</th>
                            <th class="px-3 py-2 text-center">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paginatedRows as $index => $row)
                        <tr class="border-t">
                            <td class="px-3 py-2">{{ $row['employee_nik'] }}</td>
                            <td class="px-3 py-2">{{ $row['employee_name'] }}</td>
                            <td class="px-3 py-2">{{ $row['group'] }}</td>
                            <td class="px-3 py-2">{{ $row['line'] }}</td>
                            <td class="px-3 py-2">
                                @php
                                    $jenisMap = [
                                        'SD' => 'SD - Sakit Dengan Surat Dokter',
                                        'IJ' => 'IJ - Izin Pribadi',
                                        'A' => 'A - Tidak Hadir Tanpa Keterangan',
                                        'CT' => 'CT - Cuti Tahunan',
                                        'CK' => 'CK - Cuti Keguguran',
                                        'CM' => 'CM - Cuti Melahirkan',
                                    ];
                                    $jenisDisplay = $jenisMap[$row['jenis_ketidakhadiran']] ?? $row['jenis_ketidakhadiran'];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-700">
                                    {{ $jenisDisplay }}
                                </span>
                            </td>
                            <td class="px-3 py-2">{{ Str::limit($row['keterangan'], 30) ?? '-' }}</td>
                            <td class="px-3 py-2 text-center">
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
            
            @if($lastPage > 1)
            <div class="flex justify-between items-center mt-4 pt-4 border-t">
                <div class="text-sm text-zinc-500">
                    Showing {{ ($currentPage - 1) * $perPage + 1 }} to {{ min($currentPage * $perPage, $totalRows) }} of {{ $totalRows }} rows
                </div>
                <div class="flex gap-2">
                    <button type="button" wire:click="$set('page', {{ $currentPage - 1 }})" @if($currentPage <= 1) disabled @endif
                        class="px-3 py-1 border rounded-lg {{ $currentPage <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}">
                        Previous
                    </button>
                    <span class="px-3 py-1 border rounded-lg bg-blue-50">Page {{ $currentPage }} of {{ $lastPage }}</span>
                    <button type="button" wire:click="$set('page', {{ $currentPage + 1 }})" @if($currentPage >= $lastPage) disabled @endif
                        class="px-3 py-1 border rounded-lg {{ $currentPage >= $lastPage ? 'opacity-50 cursor-not-allowed' : '' }}">
                        Next
                    </button>
                </div>
            </div>
            @endif
        </flux:card>
        @endif

        <!-- Form Actions -->
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('prod.absence.report.index') }}" wire:navigate class="px-4 py-2 bg-white border rounded-lg hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" wire:loading.attr="disabled" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed inline-flex items-center gap-2">
                <svg wire:loading wire:target="save" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="save">{{ $reportId ? 'Update Report' : 'Create Report' }}</span>
                <span wire:loading wire:target="save">Processing...</span>
            </button>
        </div>
    </form>

    <style>[x-cloak] { display: none !important; }</style>
</div>