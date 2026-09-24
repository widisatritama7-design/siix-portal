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
            Uniform Notification
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Employee Uniform Notification
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Kirim informasi & reminder pengecekan seragam ESD via email
            </p>
        </div>
        <div class="flex gap-2">
            <flux:button
                wire:click="openEmailModal('info_esd')"
                icon="envelope"
                variant="primary"
                :disabled="empty($selectedEmployees)"
            >
                Info Bawa Seragam ({{ count($selectedEmployees) }})
            </flux:button>
            <flux:button
                wire:click="openEmailModal('reminder')"
                icon="bell-alert"
                variant="filled"
                :disabled="empty($selectedEmployees)"
            >
                Reminder Segera Bawa ({{ count($selectedEmployees) }})
            </flux:button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <flux:card class="p-4">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/30">
                    <flux:icon name="users" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                </div>
                <div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Total Employees</p>
                    <p class="text-xl font-bold text-zinc-800 dark:text-white">{{ $totalEmployees }}</p>
                </div>
            </div>
        </flux:card>
        <flux:card class="p-4">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-lg bg-green-100 dark:bg-green-900/30">
                    <flux:icon name="envelope" class="w-5 h-5 text-green-600 dark:text-green-400" />
                </div>
                <div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Punya Email</p>
                    <p class="text-xl font-bold text-zinc-800 dark:text-white">{{ $withEmailCount }}</p>
                </div>
            </div>
        </flux:card>
        <flux:card class="p-4">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-lg bg-amber-100 dark:bg-amber-900/30">
                    <flux:icon name="user" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                </div>
                <div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Punya Transaksi Seragam Aktif</p>
                    <p class="text-xl font-bold text-zinc-800 dark:text-white">{{ $withActiveUniformCount }}</p>
                </div>
            </div>
        </flux:card>
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

            <flux:select wire:model.live="uniformStatusFilter" class="w-56">
                <flux:select.option value="">All Uniform Status</flux:select.option>
                <flux:select.option value="has_active">Punya Transaksi Aktif</flux:select.option>
                <flux:select.option value="no_active">Tidak Ada Transaksi Aktif</flux:select.option>
                <flux:select.option value="has_email">Punya Email</flux:select.option>
                <flux:select.option value="no_email">Tidak Punya Email</flux:select.option>
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

    <!-- Selected Info Bar -->
    @if(!empty($selectedEmployees))
    <div class="flex items-center justify-between bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg px-4 py-2">
        <span class="text-sm text-blue-800 dark:text-blue-300">
            <strong>{{ count($selectedEmployees) }}</strong> employee terpilih
        </span>
        <flux:button wire:click="clearSelection" size="sm" variant="ghost">
            Clear Selection
        </flux:button>
    </div>
    @endif

    <!-- Employees Table -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-left w-12">
                            <input
                                type="checkbox"
                                wire:model.live="selectAll"
                                class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500"
                            />
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-16">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NIK</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Department</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider text-center">Uniform</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-20">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($employees as $index => $employee)
                    @php
                        $latestTx = $employee->esdUniformTransactions
                            ->whereIn('status', ['pending', 'on_progress', 'waiting_pickup'])
                            ->first();
                        $hasActiveTx = $latestTx !== null;
                        $hasValidEmail = !empty($employee->email) && filter_var($employee->email, FILTER_VALIDATE_EMAIL);
                    @endphp
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="emp-{{ $employee->id }}">
                        <td class="px-4 py-3">
                            <input
                                type="checkbox"
                                wire:model.live="selectedEmployees"
                                value="{{ $employee->id }}"
                                class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500"
                                @if(!$hasValidEmail) disabled title="Email tidak valid" @endif
                            />
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $employees->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="font-mono text-sm text-zinc-700 dark:text-zinc-300">{{ $employee->nik }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm font-semibold text-zinc-800 dark:text-white block">{{ $employee->name }}</span>
                        </td>
                        <td class="px-4 py-3">
                            @if($hasValidEmail)
                                <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $employee->email }}</span>
                            @else
                                <flux:badge size="sm" color="red" variant="subtle">No Email</flux:badge>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <flux:badge size="sm" color="gray" variant="subtle">{{ $employee->department }}</flux:badge>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $statusLabel = $this->getStatusLabel($employee->status);
                                $statusColor = $this->getStatusColor($employee->status);
                            @endphp
                            <flux:badge size="sm" :color="$statusColor">{{ $statusLabel }}</flux:badge>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($hasActiveTx)
                                <flux:badge size="sm" color="amber" variant="subtle">
                                    {{ ucfirst(str_replace('_', ' ', $latestTx->status)) }}
                                </flux:badge>
                            @else
                                <flux:badge size="sm" color="green" variant="subtle">Clear</flux:badge>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <flux:button
                                wire:click="viewDetail({{ $employee->id }})"
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
                        <td colspan="9" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <flux:icon name="users" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">No employees found</h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                        {{ $search ? 'Try adjusting your search query' : 'No employee data available' }}
                                    </p>
                                </div>
                                @if($search)
                                    <flux:button wire:click="$set('search', '')" size="sm">Clear Search</flux:button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($employees->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $employees->links() }}
        </div>
        @endif
    </flux:card>

    <!-- ===================== EMAIL MODAL ===================== -->
    <flux:modal wire:model="showEmailModal" class="w-full max-w-3xl">
        <div class="flex flex-col" style="max-height: 85vh; overflow: hidden;">
            <!-- Header -->
            <div class="flex justify-between items-center px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex-shrink-0">
                <div>
                    <h2 class="text-xl font-bold text-zinc-800 dark:text-white">
                        @if($emailMethod === 'info_esd')
                            📧 Info: Bawa Seragam untuk Pengecekan ESD
                        @else
                            🔔 Reminder: Segera Bawa Seragam untuk Pengecekan ESD
                        @endif
                    </h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        {{ count($selectedEmployees) }} penerima
                    </p>
                </div>
            </div>

            <!-- Body -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                @if($sendResult)
                    <!-- Result -->
                    <div class="space-y-3">
                        <div class="grid grid-cols-3 gap-3">
                            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3 text-center">
                                <p class="text-2xl font-bold text-green-700 dark:text-green-400">{{ $sendResult['success'] }}</p>
                                <p class="text-xs text-green-600 dark:text-green-500">Sukses</p>
                            </div>
                            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3 text-center">
                                <p class="text-2xl font-bold text-red-700 dark:text-red-400">{{ $sendResult['failed'] }}</p>
                                <p class="text-xs text-red-600 dark:text-red-500">Gagal</p>
                            </div>
                            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-3 text-center">
                                <p class="text-2xl font-bold text-amber-700 dark:text-amber-400">{{ $sendResult['no_email'] }}</p>
                                <p class="text-xs text-amber-600 dark:text-amber-500">Tanpa Email</p>
                            </div>
                        </div>

                        @if(!empty($sendResult['errors']))
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-3 max-h-40 overflow-y-auto">
                            <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-2">Detail Error:</p>
                            <ul class="text-xs text-zinc-500 dark:text-zinc-400 space-y-1">
                                @foreach($sendResult['errors'] as $err)
                                    <li>• {{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                @else
                    <!-- Form -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Subject</label>
                        <flux:input wire:model="emailSubject" placeholder="Email subject..." />
                        @error('emailSubject') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Message</label>
                        <textarea
                            wire:model="emailMessage"
                            rows="10"
                            class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm text-zinc-800 dark:text-zinc-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        ></textarea>
                        @error('emailMessage') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                        <p class="text-xs text-blue-700 dark:text-blue-300">
                            <strong>Preview penerima:</strong>
                            {{ implode(', ', \App\Models\HR\Employee::whereIn('id', $selectedEmployees)->pluck('name')->take(5)->toArray()) }}
                            @if(count($selectedEmployees) > 5)
                                dan {{ count($selectedEmployees) - 5 }} lainnya
                            @endif
                        </p>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-2 px-6 py-4 border-t border-zinc-200 dark:border-zinc-700 flex-shrink-0">
                @if($sendResult)
                    <flux:button wire:click="closeEmailModal" variant="primary">Tutup</flux:button>
                @else
                    <flux:button wire:click="closeEmailModal" variant="ghost" :disabled="$sending">Batal</flux:button>
                    <flux:button
                        wire:click="sendEmails"
                        variant="primary"
                        icon="paper-airplane"
                        :disabled="$sending"
                    >
                        {{ $sending ? 'Mengirim...' : 'Kirim Email' }}
                    </flux:button>
                @endif
            </div>
        </div>
    </flux:modal>

    <!-- ===================== DETAIL MODAL ===================== -->
    <flux:modal wire:model="showDetailModal" class="w-full max-w-2xl">
        @if($detailEmployee)
        <div class="p-6 space-y-4">
            <h2 class="text-xl font-bold text-zinc-800 dark:text-white">Employe Detail</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2 bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-zinc-500">NIK</span>
                        <span class="font-mono text-sm text-zinc-800 dark:text-white">{{ $detailEmployee->nik }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-zinc-500">Name</span>
                        <span class="text-sm font-semibold text-zinc-800 dark:text-white">{{ $detailEmployee->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-zinc-500">Email</span>
                        <span class="text-sm text-zinc-800 dark:text-white">{{ $detailEmployee->email ?? '-' }}</span>
                    </div>
                </div>
                <div class="space-y-2 bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-zinc-500">Department</span>
                        <span class="text-sm text-zinc-800 dark:text-white">{{ $detailEmployee->department }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-zinc-500">Status</span>
                        <flux:badge size="sm" :color="$this->getStatusColor($detailEmployee->status)">
                            {{ $this->getStatusLabel($detailEmployee->status) }}
                        </flux:badge>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-zinc-500">Active Uniform</span>
                        @if($detailEmployee->hasActiveEsdTransaction())
                            <flux:badge size="sm" color="amber">Yes</flux:badge>
                        @else
                            <flux:badge size="sm" color="green">No</flux:badge>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Uniform Transactions -->
            <div>
                <h3 class="text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-2">Uniform Transactions</h3>
                @if($detailEmployee->esdUniformTransactions->count() > 0)
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 uppercase">Status</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 uppercase">Created</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($detailEmployee->esdUniformTransactions as $tx)
                            <tr>
                                <td class="px-3 py-2">
                                    <flux:badge size="sm" color="blue" variant="subtle">
                                        {{ ucfirst(str_replace('_', ' ', $tx->status)) }}
                                    </flux:badge>
                                </td>
                                <td class="px-3 py-2 text-zinc-500">
                                    {{ $tx->created_at ? \Carbon\Carbon::parse($tx->created_at)->format('d M Y H:i') : '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-sm text-zinc-500 dark:text-zinc-400 italic">No uniform transactions.</p>
                @endif
            </div>

            <div class="flex justify-end">
                <flux:button wire:click="$set('showDetailModal', false)" variant="primary">Tutup</flux:button>
            </div>
        </div>
        @endif
    </flux:modal>
</div>