<div class="p-1 space-y-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            HR
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Employee
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Employee Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage all employee data and information
            </p>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex flex-wrap gap-2">
            <flux:select wire:model.live="departmentFilter" class="w-48">
                <flux:select.option value="">All Departments</flux:select.option>
                @foreach($this->departments as $dept)
                    <flux:select.option value="{{ $dept }}">{{ $dept }}</flux:select.option>
                @endforeach
            </flux:select>
            
            <flux:select wire:model.live="statusFilter" class="w-40">
                <flux:select.option value="">All Status</flux:select.option>
                @foreach($statusOptions as $key => $value)
                    <flux:select.option value="{{ $key }}">{{ $value }}</flux:select.option>
                @endforeach
            </flux:select>
            
            <flux:select wire:model.live="perPage" class="w-32">
                <flux:select.option value="10">10 per page</flux:select.option>
                <flux:select.option value="25">25 per page</flux:select.option>
                <flux:select.option value="50">50 per page</flux:select.option>
                <flux:select.option value="100">100 per page</flux:select.option>
            </flux:select>
        </div>
        
        <div class="w-full sm:w-80">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search by NIK, name, email..."
                icon="magnifying-glass"
                clearable
            />
        </div>
    </div>

    <!-- Employees Table -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-16">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NIK</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Department</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Contract Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">In Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Last Group</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Last Route</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-center">Comelate</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-center">Violation</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-center">Employee Call</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-20">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($employees as $index => $employee)
                    @php
                        $comelateCount = $employee->comelateEmployees->count();
                        $violationCount = $employee->violationEmployees->count();
                        $employeeCallCount = $employee->employeeCalls->count();
                    @endphp
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="employee-{{ $employee->id }}">
                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                            {{ $employees->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="font-mono text-sm text-zinc-700 dark:text-zinc-300">
                                {{ $employee->nik }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div>
                                <span class="text-sm font-semibold text-zinc-800 dark:text-white block">
                                    {{ $employee->name }}
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <flux:badge size="sm" color="gray" variant="subtle">
                                {{ $employee->department }}
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $statusLabel = match($employee->status) {
                                    1 => 'Permanent',
                                    2 => 'Contract',
                                    3 => 'Magang',
                                    default => 'Unknown',
                                };
                                $statusColor = match($employee->status) {
                                    1 => 'blue',
                                    2 => 'yellow',
                                    3 => 'purple',
                                    default => 'gray',
                                };
                            @endphp
                            <flux:badge size="sm" :color="$statusColor">
                                {{ $statusLabel }}
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                            {{ $employee->contract_date ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                            {{ $employee->in_date ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                            {{ $employee->last_group ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                            {{ $employee->last_route ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            @if($comelateCount > 0)
                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-semibold rounded-full {{ $comelateCount >= 5 ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' }}">
                                    {{ $comelateCount }}
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    0
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            @if($violationCount > 0)
                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-semibold rounded-full {{ $violationCount >= 5 ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400' }}">
                                    {{ $violationCount }}
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    0
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            @if($employeeCallCount > 0)
                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-semibold rounded-full {{ $employeeCallCount >= 5 ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : 'bg-teal-100 text-teal-800 dark:bg-teal-900/30 dark:text-teal-400' }}">
                                    {{ $employeeCallCount }}
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    0
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <flux:button 
                                wire:click="view({{ $employee->id }})" 
                                size="sm" 
                                variant="outline"
                                icon="eye"
                                class="!p-1.5"
                            >
                                View
                            </flux:button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="13" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <flux:icon name="users" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        No employees found
                                    </h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                        {{ $search ? 'Try adjusting your search query' : 'No employee data available' }}
                                    </p>
                                </div>
                                @if($search)
                                    <flux:button wire:click="$set('search', '')" size="sm">
                                        Clear Search
                                    </flux:button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($employees->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $employees->links() }}
        </div>
        @endif
    </flux:card>

    <!-- View Employee Modal -->
    <flux:modal wire:model="showViewModal" class="w-full max-w-6xl">
        <div class="flex flex-col" style="height: auto; max-height: 85vh; overflow: hidden;">
            <!-- Modal Header -->
            <div class="flex justify-between items-center px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex-shrink-0">
                <h2 class="text-xl font-bold text-zinc-800 dark:text-white">
                    Employee Details
                </h2>
            </div>

            @if($selectedEmployee)
            <!-- Content with scroll only if needed -->
            <div class="flex-1 overflow-y-auto p-6 pt-4">
                <div class="space-y-6">
                    <!-- Employee Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Left Side - Personal Information -->
                        <div class="space-y-3">
                            <div class="space-y-2 bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-zinc-500 dark:text-zinc-400">NIK</span>
                                    <span class="font-mono text-sm text-zinc-800 dark:text-white">{{ $selectedEmployee->nik }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Name</span>
                                    <span class="text-sm font-semibold text-zinc-800 dark:text-white">{{ $selectedEmployee->name }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Side - Employment Information (simplified) -->
                        <div class="space-y-3">
                            <div class="space-y-2 bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Department</span>
                                    <span class="text-sm text-zinc-800 dark:text-white">{{ $selectedEmployee->department }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Status</span>
                                    <div>
                                        @php
                                            $statusLabel = match($selectedEmployee->status) {
                                                1 => 'Permanent',
                                                2 => 'Contract',
                                                3 => 'Magang',
                                                default => 'Unknown',
                                            };
                                            $statusColor = match($selectedEmployee->status) {
                                                1 => 'blue',
                                                2 => 'yellow',
                                                3 => 'purple',
                                                default => 'gray',
                                            };
                                        @endphp
                                        <flux:badge size="sm" :color="$statusColor">
                                            {{ $statusLabel }}
                                        </flux:badge>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs Navigation -->
                    <div class="flex gap-2 mb-4">
                        <button 
                            wire:click="setActiveTab('comelate')"
                            class="px-4 py-2 text-sm font-medium rounded-full transition-colors {{ $activeTab === 'comelate' ? 'bg-blue-600 text-white' : 'bg-zinc-100 text-zinc-700 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700' }}"
                        >
                            Comelate Records 
                            <span class="ml-1 px-1.5 py-0.5 text-xs {{ $activeTab === 'comelate' ? 'bg-blue-500 text-white' : 'bg-zinc-200 text-zinc-600 dark:bg-zinc-700 dark:text-zinc-300' }} rounded-full">
                                {{ $selectedEmployee->comelateEmployees->count() }}
                            </span>
                        </button>
                        
                        <button 
                            wire:click="setActiveTab('violation')"
                            class="px-4 py-2 text-sm font-medium rounded-full transition-colors {{ $activeTab === 'violation' ? 'bg-blue-600 text-white' : 'bg-zinc-100 text-zinc-700 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700' }}"
                        >
                            Violation Records 
                            <span class="ml-1 px-1.5 py-0.5 text-xs {{ $activeTab === 'violation' ? 'bg-blue-500 text-white' : 'bg-zinc-200 text-zinc-600 dark:bg-zinc-700 dark:text-zinc-300' }} rounded-full">
                                {{ $selectedEmployee->violationEmployees->count() }}
                            </span>
                        </button>
                        
                        <button 
                            wire:click="setActiveTab('employeecall')"
                            class="px-4 py-2 text-sm font-medium rounded-full transition-colors {{ $activeTab === 'employeecall' ? 'bg-blue-600 text-white' : 'bg-zinc-100 text-zinc-700 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700' }}"
                        >
                            Employee Call Records 
                            <span class="ml-1 px-1.5 py-0.5 text-xs {{ $activeTab === 'employeecall' ? 'bg-blue-500 text-white' : 'bg-zinc-200 text-zinc-600 dark:bg-zinc-700 dark:text-zinc-300' }} rounded-full">
                                {{ $selectedEmployee->employeeCalls->count() }}
                            </span>
                        </button>
                    </div>

                    <!-- Comelate Records Tab -->
                    @if($activeTab === 'comelate')
                    <div class="space-y-3">
                        @php
                            $allRecords = $selectedEmployee->comelateEmployees->sortByDesc('tanggal');
                            $totalRecords = $allRecords->count();
                            $currentPage = $comelatePage ?? 1;
                            $perPage = 5;
                            $lastPage = ceil($totalRecords / $perPage);
                            $records = $allRecords->slice(($currentPage - 1) * $perPage, $perPage);
                        @endphp
                        
                        @if($totalRecords > 0)
                        <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Shift</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Jam Masuk</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Jam Datang</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Terlambat</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Alasan</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Security</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                        @foreach($records as $record)
                                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <flux:badge size="sm" color="blue" variant="subtle">
                                                    {{ $this->formatShift($record->shift) }}
                                                </flux:badge>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                                                {{ $record->jam_masuk ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                                                {{ $record->jam ? \Carbon\Carbon::parse($record->jam)->format('H:i') : '-' }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @php
                                                    $delayText = $this->formatDelay($record->count_jam);
                                                    $delayColor = $record->count_jam > 0 ? 'yellow' : 'green';
                                                @endphp
                                                <flux:badge size="sm" :color="$delayColor">
                                                    {{ $delayText }}
                                                </flux:badge>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-500">
                                                <div class="max-w-xs truncate" title="{{ $record->alasan_terlambat }}">
                                                    {{ $record->alasan_terlambat ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                                                {{ $record->nama_security ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($record->tanggal)->format('d M Y') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($lastPage > 1)
                            <div class="flex justify-between items-center px-4 py-3 border-t border-zinc-200 dark:border-zinc-700">
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                    Showing {{ ($currentPage - 1) * $perPage + 1 }} to {{ min($currentPage * $perPage, $totalRecords) }} of {{ $totalRecords }} records
                                </div>
                                <div class="flex gap-2">
                                    <flux:button 
                                        wire:click="setComelatePage({{ $currentPage - 1 }})"
                                        size="sm"
                                        variant="outline"
                                        :disabled="$currentPage <= 1"
                                        class="!px-3"
                                    >
                                        Previous
                                    </flux:button>
                                    @for($i = 1; $i <= $lastPage; $i++)
                                        @if($i == $currentPage)
                                            <flux:button size="sm" variant="primary" class="!px-3">{{ $i }}</flux:button>
                                        @elseif($i == 1 || $i == $lastPage || ($i >= $currentPage - 1 && $i <= $currentPage + 1))
                                            <flux:button wire:click="setComelatePage({{ $i }})" size="sm" variant="outline" class="!px-3">{{ $i }}</flux:button>
                                        @elseif($i == $currentPage - 2 || $i == $currentPage + 2)
                                            <span class="px-2 py-1 text-sm text-zinc-500 dark:text-zinc-400">...</span>
                                        @endif
                                    @endfor
                                    <flux:button 
                                        wire:click="setComelatePage({{ $currentPage + 1 }})"
                                        size="sm"
                                        variant="outline"
                                        :disabled="$currentPage >= $lastPage"
                                        class="!px-3"
                                    >
                                        Next
                                    </flux:button>
                                </div>
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="text-center py-8 bg-zinc-50 dark:bg-zinc-800/30 rounded-lg">
                            <flux:icon name="document-text" class="w-12 h-12 text-zinc-400 dark:text-zinc-500 mx-auto mb-2" />
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">No comelate records found for this employee</p>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Violation Records Tab -->
                    @if($activeTab === 'violation')
                    <div class="space-y-3">
                        @php
                            $allViolations = $selectedEmployee->violationEmployees->sortByDesc('date');
                            $totalViolations = $allViolations->count();
                            $currentViolationPage = $violationPage ?? 1;
                            $perPageViolation = 5;
                            $lastViolationPage = ceil($totalViolations / $perPageViolation);
                            $violations = $allViolations->slice(($currentViolationPage - 1) * $perPageViolation, $perPageViolation);
                        @endphp
                        
                        @if($totalViolations > 0)
                        <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Shift</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Category</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Sub Category</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Plate</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Security</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                        @foreach($violations as $violation)
                                        @php
                                            $subCats = $violation->sub_category ?? [];
                                            $subCount = count($subCats);
                                            $subColor = $subCount >= 5 ? 'red' : ($subCount >= 3 ? 'orange' : 'blue');
                                        @endphp
                                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <flux:badge size="sm" color="blue" variant="subtle">
                                                    {{ $this->formatShift($violation->shift) }}
                                                </flux:badge>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <flux:badge size="sm" color="purple" variant="subtle">
                                                    {{ $violation->category }}
                                                </flux:badge>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <button 
                                                    wire:click="$dispatch('view-sub-categories', { subCategories: {{ json_encode($subCats) }} })"
                                                    class="inline-flex items-center gap-2 hover:opacity-80 transition-opacity"
                                                >
                                                    <span class="inline-block px-3 py-1 text-sm font-medium text-white bg-blue-600 rounded-full cursor-pointer hover:bg-blue-700 transition">
                                                        Klik Detail
                                                    </span>
                                                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold text-white bg-{{ $subColor }}-600 rounded-full min-w-[1.5rem] h-5">
                                                        {{ $subCount }}
                                                    </span>
                                                </button>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                                                {{ $violation->plat_motor ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                                                {{ strtoupper($violation->security_name ?? '-') }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($violation->date)->format('d M Y') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($lastViolationPage > 1)
                            <div class="flex justify-between items-center px-4 py-3 border-t border-zinc-200 dark:border-zinc-700">
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                    Showing {{ ($currentViolationPage - 1) * $perPageViolation + 1 }} to {{ min($currentViolationPage * $perPageViolation, $totalViolations) }} of {{ $totalViolations }} records
                                </div>
                                <div class="flex gap-2">
                                    <flux:button 
                                        wire:click="setViolationPage({{ $currentViolationPage - 1 }})"
                                        size="sm"
                                        variant="outline"
                                        :disabled="$currentViolationPage <= 1"
                                        class="!px-3"
                                    >
                                        Previous
                                    </flux:button>
                                    @for($i = 1; $i <= $lastViolationPage; $i++)
                                        @if($i == $currentViolationPage)
                                            <flux:button size="sm" variant="primary" class="!px-3">{{ $i }}</flux:button>
                                        @elseif($i == 1 || $i == $lastViolationPage || ($i >= $currentViolationPage - 1 && $i <= $currentViolationPage + 1))
                                            <flux:button wire:click="setViolationPage({{ $i }})" size="sm" variant="outline" class="!px-3">{{ $i }}</flux:button>
                                        @elseif($i == $currentViolationPage - 2 || $i == $currentViolationPage + 2)
                                            <span class="px-2 py-1 text-sm text-zinc-500 dark:text-zinc-400">...</span>
                                        @endif
                                    @endfor
                                    <flux:button 
                                        wire:click="setViolationPage({{ $currentViolationPage + 1 }})"
                                        size="sm"
                                        variant="outline"
                                        :disabled="$currentViolationPage >= $lastViolationPage"
                                        class="!px-3"
                                    >
                                        Next
                                    </flux:button>
                                </div>
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="text-center py-8 bg-zinc-50 dark:bg-zinc-800/30 rounded-lg">
                            <flux:icon name="document-text" class="w-12 h-12 text-zinc-400 dark:text-zinc-500 mx-auto mb-2" />
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">No violation records found for this employee</p>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Employee Call Records Tab -->
                    @if($activeTab === 'employeecall')
                    <div class="space-y-3">
                        @php
                            $allCalls = $selectedEmployee->employeeCalls->sortByDesc('date_call');
                            $totalCalls = $allCalls->count();
                            $currentCallPage = $employeeCallPage ?? 1;
                            $perPageCall = 5;
                            $lastCallPage = ceil($totalCalls / $perPageCall);
                            $calls = $allCalls->slice(($currentCallPage - 1) * $perPageCall, $perPageCall);
                        @endphp
                        
                        @if($totalCalls > 0)
                        <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Category</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Date Call</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Time Call</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                        @foreach($calls as $call)
                                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if($call->category == 'Violation')
                                                    <span class="inline-block px-3 py-1 text-sm font-medium text-white bg-red-600 rounded-full cursor-default">Violation</span>
                                                @elseif($call->category == 'Comelate')
                                                    <span class="inline-block px-3 py-1 text-sm font-medium text-black bg-yellow-400 rounded-full cursor-default">Comelate</span>
                                                @else
                                                    <span class="inline-block px-3 py-1 text-sm font-medium text-gray-800 bg-gray-200 rounded-full cursor-default">{{ $call->category }}</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($call->date_call)->format('d M Y') }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-500 whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($call->time_call)->format('H:i') }}
                                            </td>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($lastCallPage > 1)
                            <div class="flex justify-between items-center px-4 py-3 border-t border-zinc-200 dark:border-zinc-700">
                                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                    Showing {{ ($currentCallPage - 1) * $perPageCall + 1 }} to {{ min($currentCallPage * $perPageCall, $totalCalls) }} of {{ $totalCalls }} records
                                </div>
                                <div class="flex gap-2">
                                    <flux:button 
                                        wire:click="setEmployeeCallPage({{ $currentCallPage - 1 }})"
                                        size="sm"
                                        variant="outline"
                                        :disabled="$currentCallPage <= 1"
                                        class="!px-3"
                                    >
                                        Previous
                                    </flux:button>
                                    @for($i = 1; $i <= $lastCallPage; $i++)
                                        @if($i == $currentCallPage)
                                            <flux:button size="sm" variant="primary" class="!px-3">{{ $i }}</flux:button>
                                        @elseif($i == 1 || $i == $lastCallPage || ($i >= $currentCallPage - 1 && $i <= $currentCallPage + 1))
                                            <flux:button wire:click="setEmployeeCallPage({{ $i }})" size="sm" variant="outline" class="!px-3">{{ $i }}</flux:button>
                                        @elseif($i == $currentCallPage - 2 || $i == $currentCallPage + 2)
                                            <span class="px-2 py-1 text-sm text-zinc-500 dark:text-zinc-400">...</span>
                                        @endif
                                    @endfor
                                    <flux:button 
                                        wire:click="setEmployeeCallPage({{ $currentCallPage + 1 }})"
                                        size="sm"
                                        variant="outline"
                                        :disabled="$currentCallPage >= $lastCallPage"
                                        class="!px-3"
                                    >
                                        Next
                                    </flux:button>
                                </div>
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="text-center py-8 bg-zinc-50 dark:bg-zinc-800/30 rounded-lg">
                            <flux:icon name="phone" class="w-12 h-12 text-zinc-400 dark:text-zinc-500 mx-auto mb-2" />
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">No employee call records found for this employee</p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </flux:modal>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>