<div class="p-1 space-y-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Locker
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Uniform Recipients
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- ===================== HEADER ===================== -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Uniform Notification Recipients
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Kelola daftar penerima email pengecekan seragam ESD
            </p>
        </div>

        <div class="flex gap-2 flex-wrap items-center">
            {{-- Import & Export --}}
            @can('edit uniform recipient')
                <flux:button wire:click="openImportModal" icon="arrow-up-tray" variant="outline" size="sm">
                    Import
                </flux:button>
                <flux:button wire:click="exportCsv" icon="arrow-down-tray" variant="outline" size="sm">
                    Export
                </flux:button>
            @endcan

            {{-- Tambah --}}
            <flux:button wire:click="openCreateModal" icon="plus" variant="primary" size="sm">
                Tambah
            </flux:button>

            {{-- Divider --}}
            <div class="w-px h-8 bg-zinc-200 dark:bg-zinc-700"></div>

            {{-- Kirim Email --}}
            <flux:button
                wire:click="openEmailModal('info_esd')"
                icon="envelope"
                variant="filled"
                size="sm"
                :disabled="empty($selectedRecipients)"
            >
                Info ({{ count($selectedRecipients) }})
            </flux:button>

            <flux:button
                wire:click="openEmailModal('reminder')"
                icon="bell-alert"
                variant="filled"
                size="sm"
                :disabled="empty($selectedRecipients)"
            >
                Reminder ({{ count($selectedRecipients) }})
            </flux:button>
        </div>
    </div>

    <!-- ===================== STATS ===================== -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <flux:card class="p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="p-2.5 rounded-lg bg-blue-100 dark:bg-blue-900/30">
                    <flux:icon name="users" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">
                        Total Recipients
                    </p>
                    <p class="text-2xl font-bold text-zinc-800 dark:text-white mt-0.5">
                        {{ $totalRecipients }}
                    </p>
                </div>
            </div>
        </flux:card>

        <flux:card class="p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="p-2.5 rounded-lg bg-green-100 dark:bg-green-900/30">
                    <flux:icon name="check-circle" class="w-5 h-5 text-green-600 dark:text-green-400" />
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">
                        Active
                    </p>
                    <p class="text-2xl font-bold text-zinc-800 dark:text-white mt-0.5">
                        {{ $activeRecipients }}
                    </p>
                </div>
            </div>
        </flux:card>

        <flux:card class="p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="p-2.5 rounded-lg bg-red-100 dark:bg-red-900/30">
                    <flux:icon name="x-circle" class="w-5 h-5 text-red-600 dark:text-red-400" />
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">
                        Inactive
                    </p>
                    <p class="text-2xl font-bold text-zinc-800 dark:text-white mt-0.5">
                        {{ $inactiveRecipients }}
                    </p>
                </div>
            </div>
        </flux:card>
    </div>

    <!-- ===================== FILTERS ===================== -->
    <flux:card class="p-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex flex-wrap items-center gap-2">
                <flux:select wire:model.live="statusFilter" class="w-40">
                    <flux:select.option value="">All Status</flux:select.option>
                    <flux:select.option value="active">Active</flux:select.option>
                    <flux:select.option value="inactive">Inactive</flux:select.option>
                </flux:select>

                <flux:select wire:model.live="perPage" class="w-36">
                    <flux:select.option value="10">10 / page</flux:select.option>
                    <flux:select.option value="25">25 / page</flux:select.option>
                    <flux:select.option value="50">50 / page</flux:select.option>
                    <flux:select.option value="100">100 / page</flux:select.option>
                </flux:select>

                @if($search || $statusFilter)
                    <flux:button
                        wire:click="$set('search', ''); $set('statusFilter', '')"
                        size="sm"
                        variant="ghost"
                        icon="x-mark"
                    >
                        Clear Filter
                    </flux:button>
                @endif
            </div>

            <div class="w-full sm:w-80">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search NIK, name, email..."
                    icon="magnifying-glass"
                    clearable
                />
            </div>
        </div>
    </flux:card>

    <!-- Selected Info -->
    @if(!empty($selectedRecipients))
    <div class="flex items-center justify-between bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg px-4 py-2">
        <span class="text-sm text-blue-800 dark:text-blue-300">
            <strong>{{ count($selectedRecipients) }}</strong> recipient terpilih
        </span>
        <flux:button wire:click="clearSelection" size="sm" variant="ghost">Clear</flux:button>
    </div>
    @endif

    <!-- Table -->
    <flux:card class="p-6 shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-center w-12">
                            <input type="checkbox" wire:model.live="selectAll"
                                class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" />
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-16">#</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">NIK</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                            <div class="flex items-center justify-center gap-1">
                                Email
                                @can('edit uniform recipient')
                                    <span class="text-[10px] font-normal text-blue-500 dark:text-blue-400 normal-case">(inline edit)</span>
                                @endcan
                            </div>
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Date Measure</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Department</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-32">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($recipients as $index => $recipient)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="r-{{ $recipient->id }}">
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" wire:model.live="selectedRecipients"
                                value="{{ $recipient->id }}"
                                class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500"
                                @if(!$recipient->is_active) disabled @endif />
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-zinc-500">{{ $recipients->firstItem() + $index }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="font-mono text-sm text-zinc-700 dark:text-zinc-300">{{ $recipient->nik ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="text-sm font-semibold text-zinc-800 dark:text-white">{{ $recipient->name }}</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @can('edit uniform recipient')
                                @if($editingEmailId === $recipient->id)
                                    <div class="flex gap-1.5 items-center justify-center">
                                        <input
                                            type="email"
                                            wire:model.defer="editingEmailValue"
                                            wire:keydown.enter="saveEditEmail"
                                            wire:keydown.escape="cancelEditEmail"
                                            class="w-56 rounded-md border border-blue-400 dark:border-blue-600 bg-white dark:bg-zinc-900 px-2.5 py-1.5 text-sm text-zinc-800 dark:text-zinc-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            autofocus
                                        />
                                        <button
                                            wire:click="saveEditEmail"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-md bg-green-50 hover:bg-green-100 dark:bg-green-900/30 dark:hover:bg-green-900/50 text-green-600 dark:text-green-400 transition"
                                            title="Simpan (Enter)"
                                        >
                                            <flux:icon name="check" variant="mini" class="w-4 h-4" />
                                        </button>
                                        <button
                                            wire:click="cancelEditEmail"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-md bg-red-50 hover:bg-red-100 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400 transition"
                                            title="Batal (Esc)"
                                        >
                                            <flux:icon name="x-mark" variant="mini" class="w-4 h-4" />
                                        </button>
                                    </div>
                                    @error('editingEmailValue')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                @else
                                    <div class="flex gap-2 items-center justify-center group">
                                        <span class="text-sm text-zinc-600 dark:text-zinc-400">
                                            {{ $recipient->email ?? '-' }}
                                        </span>
                                        <button
                                            wire:click="startEditEmail({{ $recipient->id }})"
                                            class="opacity-0 group-hover:opacity-100 inline-flex items-center justify-center w-6 h-6 rounded-md hover:bg-blue-50 dark:hover:bg-blue-900/30 text-blue-600 dark:text-blue-400 transition"
                                            title="Edit email"
                                        >
                                            <flux:icon name="pencil-square" variant="mini" class="w-3.5 h-3.5" />
                                        </button>
                                    </div>
                                @endif
                            @else
                                <span class="text-sm text-zinc-400 dark:text-zinc-500 italic font-mono">
                                    {{ $this->maskEmail($recipient->email) }}
                                </span>
                            @endcan
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($recipient->date_measure)
                                <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ \Carbon\Carbon::parse($recipient->date_measure)->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-sm text-zinc-400 dark:text-zinc-500 italic">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <flux:badge size="sm" color="gray" variant="subtle">{{ $recipient->department ?? '-' }}</flux:badge>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button wire:click="toggleActive({{ $recipient->id }})">
                                @if($recipient->is_active)
                                    <flux:badge size="sm" color="green" variant="subtle">Active</flux:badge>
                                @else
                                    <flux:badge size="sm" color="red" variant="subtle">Inactive</flux:badge>
                                @endif
                            </button>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex gap-1 justify-center">
                                <flux:button wire:click="confirmDelete({{ $recipient->id }})"
                                    size="sm" variant="outline" icon="trash" color="red" class="!p-1.5" />
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <flux:icon name="inbox" class="w-10 h-10 text-zinc-400" />
                                </div>
                                <h3 class="text-lg font-medium text-zinc-900 dark:text-white">Belum ada recipient</h3>
                                <p class="text-sm text-zinc-500">Tambahkan recipient untuk mulai kirim email</p>
                                <flux:button wire:click="openCreateModal" size="sm" variant="primary" icon="plus">
                                    Tambah Recipient
                                </flux:button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($recipients->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $recipients->links() }}
        </div>
        @endif
    </flux:card>

    <!-- ===================== FORM MODAL ===================== -->
    <flux:modal wire:model="showFormModal" class="w-full max-w-2xl">
        <div class="p-6 space-y-4">
            <h2 class="text-xl font-bold text-zinc-800 dark:text-white">
                {{ $formMode === 'create' ? 'Tambah Recipient' : 'Edit Recipient' }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Employee Search -->
                <div class="md:col-span-2 relative" x-data @click.outside="$wire.set('showEmployeeDropdown', false)">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Cari Employee (opsional, untuk auto-fill NIK/Nama/Dept)
                    </label>

                    <div class="relative">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="employeeSearch"
                            wire:focus="$set('showEmployeeDropdown', true)"
                            placeholder="Ketik NIK atau nama employee..."
                            class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm text-zinc-800 dark:text-zinc-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-10"
                        />

                        @if($employee_id)
                            <button
                                type="button"
                                wire:click="clearEmployeeSelection"
                                class="absolute right-2 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-red-500 transition"
                                title="Clear"
                            >
                                ✕
                            </button>
                        @endif
                    </div>

                    @if($showEmployeeDropdown && count($employeeResults) > 0)
                    <div class="absolute z-50 mt-1 w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-lg max-h-64 overflow-y-auto">
                        @foreach($employeeResults as $emp)
                        <button
                            type="button"
                            wire:click="selectEmployee({{ $emp['id'] }})"
                            @if($emp['is_registered']) disabled @endif
                            class="w-full text-left px-3 py-2 border-b border-zinc-100 dark:border-zinc-800 last:border-0 transition
                                {{ $emp['is_registered']
                                    ? 'bg-red-50 dark:bg-red-900/20 cursor-not-allowed opacity-70'
                                    : 'hover:bg-blue-50 dark:hover:bg-blue-900/20' }}"
                        >
                            <div class="flex justify-between items-center gap-2">
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold truncate
                                        {{ $emp['is_registered'] ? 'text-red-700 dark:text-red-400 line-through' : 'text-zinc-800 dark:text-white' }}">
                                        {{ $emp['name'] }}
                                    </p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $emp['nik'] }} • {{ $emp['department'] ?? '-' }}
                                    </p>
                                </div>
                                @if($emp['is_registered'])
                                    <span class="text-xs font-semibold text-red-600 dark:text-red-400 whitespace-nowrap">
                                        Sudah terdaftar
                                    </span>
                                @endif
                            </div>
                        </button>
                        @endforeach
                    </div>
                    @elseif($showEmployeeDropdown && strlen($employeeSearch) >= 2 && count($employeeResults) === 0)
                    <div class="absolute z-50 mt-1 w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-lg p-3 text-center">
                        <p class="text-xs text-zinc-500">Tidak ada employee ditemukan</p>
                    </div>
                    @endif

                    @if($employee_id)
                        <p class="mt-1 text-xs text-green-600 dark:text-green-400">
                            ✓ Terhubung ke employee ID: {{ $employee_id }}
                        </p>
                    @endif
                </div>

                <!-- NIK -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">NIK</label>
                    <flux:input
                        wire:model.live.debounce.500ms="nik"
                        placeholder="NIK..."
                        wire:key="nik-{{ $employee_id ?? 'manual' }}"
                        class="{{ $nikDuplicate ? '!border-red-500 !ring-red-500' : '' }}"
                    />
                    @if($nikDuplicate)
                        <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                            <flux:icon name="exclamation-triangle" class="w-3 h-3" />
                            NIK ini sudah terdaftar di recipient lain.
                        </p>
                    @endif
                    @error('nik') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Name *</label>
                    <flux:input
                        wire:model.live.debounce.500ms="name"
                        placeholder="Nama..."
                        wire:key="name-{{ $employee_id ?? 'manual' }}"
                        class="{{ $nameDuplicate ? '!border-red-500 !ring-red-500' : '' }}"
                    />
                    @if($nameDuplicate)
                        <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                            <flux:icon name="exclamation-triangle" class="w-3 h-3" />
                            Nama ini sudah terdaftar di recipient lain.
                        </p>
                    @endif
                    @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Department -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Department</label>
                    <flux:input wire:model="department" placeholder="Departemen..." />
                </div>

                <!-- Date Measure -->
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Date Measure</label>
                    <flux:input wire:model="date_measure" type="date" />
                    @error('date_measure') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Active -->
                <div class="flex items-center gap-2 pt-6">
                    <input type="checkbox" wire:model="is_active" id="is_active"
                        class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500" />
                    <label for="is_active" class="text-sm text-zinc-700 dark:text-zinc-300">Active</label>
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Notes</label>
                    <textarea wire:model="notes" rows="3"
                        class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm text-zinc-800 dark:text-zinc-200"></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                <flux:button wire:click="closeFormModal" variant="ghost">Batal</flux:button>
                <flux:button
                    wire:click="saveRecipient"
                    variant="primary"
                    icon="check"
                    :disabled="$nikDuplicate || $nameDuplicate"
                >
                    {{ $formMode === 'create' ? 'Simpan' : 'Update' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <!-- ===================== EMAIL MODAL ===================== -->
    <flux:modal wire:model="showEmailModal" class="w-full max-w-3xl">
        <div class="flex flex-col" style="max-height: 85vh; overflow: hidden;">
            <div class="flex justify-between items-center px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex-shrink-0">
                <div>
                    <h2 class="text-xl font-bold text-zinc-800 dark:text-white">
                        @if($emailMethod === 'info_esd')
                            Info: ESD Garment Measurement
                        @else
                            Reminder: ESD Garment Measurement
                        @endif
                    </h2>
                    <p class="text-sm text-zinc-500 mt-1">{{ count($selectedRecipients) }} penerima</p>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                @if($sendResult)
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold text-green-700 dark:text-green-400">{{ $sendResult['success'] }}</p>
                            <p class="text-xs text-green-600 dark:text-green-500">Sukses</p>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold text-red-700 dark:text-red-400">{{ $sendResult['failed'] }}</p>
                            <p class="text-xs text-red-600 dark:text-red-500">Gagal</p>
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
                @else
                    <!-- Subject -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Subject</label>
                        <flux:input wire:model="emailSubject" />
                        @error('emailSubject') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Message</label>
                        <textarea wire:model="emailMessage" rows="10"
                            class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 px-3 py-2 text-sm text-zinc-800 dark:text-zinc-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                        @error('emailMessage') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Attachments -->
                    <div class="space-y-3 border-t border-zinc-200 dark:border-zinc-700 pt-4">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                            📎 Attachment (Opsional)
                        </label>

                        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-2.5">
                            <p class="text-xs text-amber-700 dark:text-amber-300">
                                Upload file atau gambar (max <strong>10 MB</strong> per file). Bisa pilih banyak file sekaligus.
                            </p>
                        </div>

                        <div>
                            <input
                                type="file"
                                wire:model="attachments"
                                multiple
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.webp,.zip"
                                class="block w-full text-sm text-zinc-500 dark:text-zinc-400
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-lg file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100
                                    dark:file:bg-blue-900/30 dark:file:text-blue-400
                                    dark:hover:file:bg-blue-900/50
                                    cursor-pointer"
                            />
                            @error('attachments.*')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror

                            <div wire:loading wire:target="attachments" class="text-xs text-blue-600 dark:text-blue-400 mt-2 flex items-center gap-1">
                                <svg class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Uploading...
                            </div>
                        </div>

                        @if(count($attachments) > 0)
                        <div class="space-y-1.5">
                            <p class="text-xs font-medium text-zinc-600 dark:text-zinc-400">
                                File yang akan dilampirkan ({{ count($attachments) }}):
                            </p>
                            @foreach($attachments as $index => $file)
                            @php
                                $ext = strtolower($file->getClientOriginalExtension());
                                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            @endphp
                            <div class="flex items-center justify-between gap-2 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg px-3 py-2 border border-zinc-200 dark:border-zinc-700">
                                <div class="flex items-center gap-2 min-w-0 flex-1">
                                    @if($isImage)
                                        <flux:icon name="photo" variant="mini" class="w-4 h-4 text-purple-500 shrink-0" />
                                    @elseif($ext === 'pdf')
                                        <flux:icon name="document-text" variant="mini" class="w-4 h-4 text-red-500 shrink-0" />
                                    @elseif(in_array($ext, ['xls', 'xlsx', 'csv']))
                                        <flux:icon name="table-cells" variant="mini" class="w-4 h-4 text-green-500 shrink-0" />
                                    @elseif(in_array($ext, ['doc', 'docx']))
                                        <flux:icon name="document" variant="mini" class="w-4 h-4 text-blue-500 shrink-0" />
                                    @elseif($ext === 'zip')
                                        <flux:icon name="archive-box" variant="mini" class="w-4 h-4 text-amber-500 shrink-0" />
                                    @else
                                        <flux:icon name="paper-clip" variant="mini" class="w-4 h-4 text-zinc-500 shrink-0" />
                                    @endif

                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-medium text-zinc-700 dark:text-zinc-300 truncate">
                                            {{ $file->getClientOriginalName() }}
                                        </p>
                                        <p class="text-[10px] text-zinc-500">
                                            {{ number_format($file->getSize() / 1024, 1) }} KB
                                        </p>
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    wire:click="removeAttachment({{ $index }})"
                                    class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-red-50 hover:bg-red-100 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400 transition shrink-0"
                                    title="Hapus"
                                >
                                    <flux:icon name="x-mark" variant="mini" class="w-3.5 h-3.5" />
                                </button>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex justify-end gap-2 px-6 py-4 border-t border-zinc-200 dark:border-zinc-700 flex-shrink-0">
                @if($sendResult)
                    <flux:button wire:click="closeEmailModal" variant="primary">Tutup</flux:button>
                @else
                    <flux:button wire:click="closeEmailModal" variant="ghost" :disabled="$sending">Batal</flux:button>
                    <flux:button wire:click="sendEmails" variant="primary" icon="paper-airplane" :disabled="$sending">
                        {{ $sending ? 'Mengirim...' : 'Kirim Email' }}
                    </flux:button>
                @endif
            </div>
        </div>
    </flux:modal>

    <!-- ===================== IMPORT MODAL ===================== -->
    <flux:modal wire:model="showImportModal" class="w-full max-w-2xl">
        <div class="p-6 space-y-4">
            <h2 class="text-xl font-bold text-zinc-800 dark:text-white">
                Import Recipients (CSV)
            </h2>

            @if($importResult)
                <div class="space-y-3">
                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold text-green-700 dark:text-green-400">{{ $importResult['imported'] }}</p>
                            <p class="text-xs text-green-600 dark:text-green-500">Baru</p>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold text-blue-700 dark:text-blue-400">{{ $importResult['updated'] }}</p>
                            <p class="text-xs text-blue-600 dark:text-blue-500">Diupdate</p>
                        </div>
                        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-3 text-center">
                            <p class="text-2xl font-bold text-amber-700 dark:text-amber-400">{{ $importResult['skipped'] }}</p>
                            <p class="text-xs text-amber-600 dark:text-amber-500">Dilewati</p>
                        </div>
                    </div>

                    @if(!empty($importResult['delimiter']))
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-2.5">
                        <p class="text-xs text-blue-700 dark:text-blue-300">
                            ℹ️ Delimiter terdeteksi: <strong>{{ $importResult['delimiter'] }}</strong>
                        </p>
                    </div>
                    @endif

                    @if(!empty($importResult['errors']))
                    <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-3 max-h-48 overflow-y-auto">
                        <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-2">Detail Error:</p>
                        <ul class="text-xs text-zinc-500 dark:text-zinc-400 space-y-1">
                            @foreach($importResult['errors'] as $err)
                                <li>• {{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            @else
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 space-y-2">
                    <p class="text-sm font-semibold text-blue-800 dark:text-blue-300">
                        📋 Panduan Import CSV
                    </p>
                    <ul class="text-xs text-blue-700 dark:text-blue-300 space-y-1 list-disc list-inside">
                        <li>Format file: <strong>.csv</strong> atau <strong>.txt</strong></li>
                        <li>Delimiter: <strong>koma (,)</strong>, <strong>TAB</strong>, atau <strong>titik-koma (;)</strong> — otomatis terdeteksi</li>
                        <li>Header wajib: <code>NIK, NAME, DEPT, EMAIL, DATE MEASURE</code></li>
                        <li>Kolom <strong>NAME</strong> wajib diisi</li>
                        <li>Format DATE MEASURE: <code>YYYY-MM-DD</code> (contoh: 2024-01-15)</li>
                        <li>Kalau NIK/Email sudah ada → akan <strong>diupdate</strong></li>
                        <li>Ukuran maksimal <strong>5MB</strong></li>
                    </ul>

                    <flux:button
                        wire:click="downloadTemplate"
                        size="sm"
                        variant="outline"
                        icon="arrow-down-tray"
                        class="mt-2"
                    >
                        Download Template CSV
                    </flux:button>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        File CSV
                    </label>
                    <input
                        type="file"
                        wire:model="importFile"
                        accept=".csv,.txt,text/csv"
                        class="block w-full text-sm text-zinc-500 dark:text-zinc-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100
                            dark:file:bg-blue-900/30 dark:file:text-blue-400
                            dark:hover:file:bg-blue-900/50
                            cursor-pointer"
                    />
                    @error('importFile')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror

                    <div wire:loading wire:target="importFile" class="text-xs text-blue-600 dark:text-blue-400 mt-2 flex items-center gap-1">
                        <svg class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Uploading...
                    </div>
                </div>
            @endif

            <div class="flex justify-end gap-2 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                @if($importResult)
                    <flux:button wire:click="closeImportModal" variant="primary">Tutup</flux:button>
                @else
                    <flux:button wire:click="closeImportModal" variant="ghost">Batal</flux:button>
                    <flux:button
                        wire:click="importCsv"
                        variant="primary"
                        icon="arrow-up-tray"
                        wire:loading.attr="disabled"
                        :disabled="$importFile === null"
                    >
                        <span wire:loading.remove wire:target="importCsv">Import</span>
                        <span wire:loading wire:target="importCsv">Mengimport...</span>
                    </flux:button>
                @endif
            </div>
        </div>
    </flux:modal>

    <!-- ===================== DELETE MODAL ===================== -->
    <flux:modal wire:model="showDeleteModal" class="w-full max-w-md">
        <div class="p-6 space-y-4">
            <h2 class="text-xl font-bold text-zinc-800 dark:text-white">Hapus Recipient?</h2>
            <p class="text-sm text-zinc-500">Data yang dihapus tidak dapat dikembalikan.</p>
            <div class="flex justify-end gap-2 pt-4">
                <flux:button wire:click="$set('showDeleteModal', false)" variant="ghost">Batal</flux:button>
                <flux:button wire:click="deleteRecipient" variant="primary" color="red" icon="trash">
                    Hapus
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>