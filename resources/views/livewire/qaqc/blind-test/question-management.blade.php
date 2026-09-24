<div class="p-1 space-y-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            QA/QC
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Master Question
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">Master Question</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Manage question bank data</p>
        </div>

        @can('create question')
            <flux:button
                variant="primary"
                icon="plus"
                class="bg-blue-600 hover:bg-blue-700"
                wire:click="resetForm"
                x-on:click="$dispatch('open-modal-question')"
            >
                Add New Question
            </flux:button>
        @endcan
    </div>

    <!-- Search & Filter -->
    <div class="flex flex-col sm:flex-row justify-end gap-2">
        <div class="w-full sm:w-48">
            <flux:select wire:model.live="filterSection" placeholder="All Section">
                <flux:select.option value="">All Section</flux:select.option>
                @foreach($sections as $sec)
                    <flux:select.option value="{{ $sec }}">{{ $sec }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>
        <div class="w-full sm:w-80">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search customer or model..."
                icon="magnifying-glass"
                clearable
            />
        </div>
    </div>

    <!-- Table -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col">
        <div class="overflow-x-auto flex-1">
            <table class="w-full" style="min-width: 1000px; white-space: nowrap;">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase" style="min-width: 50px;">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase" style="min-width: 180px;">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase" style="min-width: 180px;">Model</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase" style="min-width: 90px;">Section</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase" style="min-width: 100px;">Items</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase" style="min-width: 150px;">Created By</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase" style="min-width: 150px;">Date</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 uppercase" style="min-width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($questions as $index => $question)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="q-{{ $question->id }}">
                        <td class="px-4 py-3 text-sm text-zinc-500 text-center">
                            {{ $questions->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3 text-left">
                            <span class="text-sm font-semibold text-zinc-800 dark:text-white">
                                {{ $question->customer->customer_name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-left">
                            <span class="text-sm text-zinc-800 dark:text-white">
                                {{ $question->model->model_name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold
                                @if($question->section === 'QC') bg-blue-100 text-blue-700
                                @elseif($question->section === 'SMT') bg-green-100 text-green-700
                                @elseif($question->section === 'BE') bg-yellow-100 text-yellow-700
                                @else bg-purple-100 text-purple-700 @endif">
                                {{ $question->section }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-zinc-600 dark:text-zinc-400">
                            <div class="font-semibold">
                                {{ count($question->items ?? []) }} item(s)
                            </div>

                            @php $usageCount = $question->blindTests()->count(); @endphp
                            @if($usageCount > 0)
                                <div class="mt-1 text-[10px] text-amber-600 dark:text-amber-400 font-semibold inline-flex items-center gap-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                        <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                                    </svg>
                                    Used ({{ $usageCount }})
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400 text-center">
                            {{ $question->creator->name ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400 text-center">
                            {{ $question->created_at ? $question->created_at->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @php
                                // Cek apakah question ini sudah dipakai blind test
                                $usageCount = $question->blindTests()->count();
                                $isUsed = $usageCount > 0;
                            @endphp

                            <div class="flex items-center justify-center gap-1" style="flex-wrap: nowrap;">

                                {{-- VIEW (selalu bisa) --}}
                                @can('view question')
                                <flux:tooltip content="View" position="top">
                                    <flux:button wire:click="view({{ $question->id }})" size="sm" icon="eye" variant="primary" color="blue" class="!p-2" />
                                </flux:tooltip>
                                @endcan

                                {{-- EDIT (disable kalau sudah dipakai) --}}
                                @can('edit question')
                                    @if($isUsed)
                                        <flux:tooltip content="Tidak bisa diedit — sudah dipakai di {{ $usageCount }} blind test" position="top">
                                            <div class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-400 cursor-not-allowed">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </flux:tooltip>
                                    @else
                                        <flux:tooltip content="Edit" position="top">
                                            <flux:button wire:click="edit({{ $question->id }})" size="sm" icon="pencil-square" variant="primary" color="yellow" class="!p-2" />
                                        </flux:tooltip>
                                    @endif
                                @endcan

                                {{-- DELETE (disable kalau sudah dipakai) --}}
                                @can('delete question')
                                    @if($isUsed)
                                        <flux:tooltip content="Tidak bisa dihapus — sudah dipakai di {{ $usageCount }} blind test" position="top">
                                            <div class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-400 cursor-not-allowed">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </flux:tooltip>
                                    @else
                                        <flux:tooltip content="Delete" position="top">
                                            <flux:button wire:click="confirmDelete({{ $question->id }})" size="sm" icon="trash" variant="primary" color="red" class="!p-2" />
                                        </flux:tooltip>
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center">
                            <div class="flex flex-col items-center justify-center gap-2 py-6">
                                <div class="w-16 h-16 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <flux:icon name="question-mark-circle" class="w-8 h-8 text-zinc-400" />
                                </div>
                                <h3 class="text-base font-medium text-zinc-900 dark:text-white">No question records found</h3>
                                <p class="text-sm text-zinc-500">
                                    {{ $search || $filterSection ? 'Try adjusting your filter' : 'Get started by creating a new question' }}
                                </p>
                                @if($search || $filterSection)
                                    <flux:button wire:click="$set('search', ''); $set('filterSection', '')" size="sm" class="mt-1">
                                        Clear Filter
                                    </flux:button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($questions->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 mt-auto">
            {{ $questions->links() }}
        </div>
        @endif
    </flux:card>

    <!-- ================= MODAL FORM (CREATE / EDIT) ================= -->
    <div x-data="{ open: false }"
        x-on:open-modal-question.window="open = true"
        x-on:close-modal-question.window="open = false"
        x-show="open" x-cloak
        @keydown.escape.window="open = false">

        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col overflow-hidden">

                {{-- ==================== HEADER ==================== --}}
                <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-6 py-5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">{{ $modalTitle }}</h2>
                            <p class="text-xs text-blue-100">Setup bank soal — defect item &amp; lokasi</p>
                        </div>
                    </div>
                    <button type="button" @click="open = false"
                        class="w-9 h-9 rounded-lg bg-white/20 hover:bg-white/30 backdrop-blur-sm border border-white/30 text-white flex items-center justify-center transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                {{-- ==================== BODY ==================== --}}
                <div class="flex-1 overflow-y-auto p-6 bg-zinc-50 dark:bg-zinc-950/30">
                    <form wire:submit="save" id="question-form" class="space-y-4">

                        {{-- ========== CARD 1: KATEGORI ========== --}}
                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                            <div class="px-5 py-3.5 border-b border-zinc-200 dark:border-zinc-800 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center shadow-sm shadow-blue-500/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-white">
                                        <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-zinc-800 dark:text-white">Kategori Soal</h3>
                            </div>
                            <div class="p-5 space-y-4">

                                {{-- Customer --}}
                                <div>
                                    <flux:label required>Customer</flux:label>
                                    <flux:select wire:model.live="customer_id" placeholder="Select customer...">
                                        @foreach($customers as $customer)
                                            <flux:select.option value="{{ $customer->id }}">{{ $customer->customer_name }}</flux:select.option>
                                        @endforeach
                                    </flux:select>
                                    @error('customer_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                {{-- Model --}}
                                <div>
                                    <flux:label required>Model</flux:label>
                                    <flux:select wire:model="model_id" placeholder="Select model..." :disabled="!$customer_id">
                                        @foreach($models as $model)
                                            <flux:select.option value="{{ $model->id }}">{{ $model->model_name }}</flux:select.option>
                                        @endforeach
                                    </flux:select>
                                    @error('model_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                {{-- Section --}}
                                <div>
                                    <flux:label required>Section</flux:label>
                                    <flux:select wire:model="section" placeholder="Select section...">
                                        @foreach($sections as $sec)
                                            <flux:select.option value="{{ $sec }}">{{ $sec }}</flux:select.option>
                                        @endforeach
                                    </flux:select>
                                    @error('section') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                            </div>
                        </div>

                        {{-- ========== CARD 2: DEFECT + LOCATION PAIR ========== --}}
                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                            <div class="px-5 py-3.5 border-b border-zinc-200 dark:border-zinc-800 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-950/30 dark:to-orange-950/30 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-amber-500 flex items-center justify-center shadow-sm shadow-amber-500/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-white">
                                            <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-zinc-800 dark:text-white">Defect Item &amp; Location</h3>
                                </div>
                                <span class="text-xs px-2.5 py-1 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 font-semibold">
                                    {{ count($items) }} item(s)
                                </span>
                            </div>
                            <div class="p-5">

                                {{-- Input Pair Baru --}}
                                <div class="p-4 rounded-xl bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-950/20 dark:to-orange-950/20 border-2 border-amber-200 dark:border-amber-800 mb-4">
                                    <div class="text-[10px] text-amber-700 dark:text-amber-400 uppercase font-bold tracking-wider mb-3">
                                        Tambah Item Baru
                                    </div>
                                    <div class="grid grid-cols-12 gap-2 items-start">
                                        <div class="col-span-5">
                                            <flux:select wire:model="tempDeffectId" placeholder="Select defect item...">
                                                @foreach($deffects as $deffect)
                                                    <flux:select.option value="{{ $deffect->id }}">{{ $deffect->deffect_item_name }}</flux:select.option>
                                                @endforeach
                                            </flux:select>
                                            @error('tempDeffectId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-span-5">
                                            <flux:input
                                                wire:model="tempLocation"
                                                wire:keydown.enter.prevent="addItem"
                                                placeholder="Location (ex: A1)"
                                                class="uppercase"
                                            />
                                            @error('tempLocation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-span-2">
                                            <flux:button type="button" wire:click="addItem" icon="plus" variant="primary" color="blue" class="w-full">
                                                Add
                                            </flux:button>
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-amber-700 dark:text-amber-400 mt-2 italic">
                                        Pilih defect item, ketik lokasi, lalu klik <strong>Add</strong> (atau tekan Enter).
                                    </p>
                                </div>

                                @error('items') <span class="text-red-500 text-xs block mb-3">{{ $message }}</span> @enderror

                                {{-- Tabel Item yang Sudah Ditambahkan --}}
                                <div class="border-2 border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden">
                                    <table class="w-full text-sm">
                                        <thead class="bg-gradient-to-r from-zinc-100 to-zinc-50 dark:from-zinc-800 dark:to-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                                            <tr>
                                                <th class="px-3 py-2.5 text-left text-[11px] font-bold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider w-12">#</th>
                                                <th class="px-3 py-2.5 text-left text-[11px] font-bold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider">Defect Item</th>
                                                <th class="px-3 py-2.5 text-left text-[11px] font-bold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider w-32">Location</th>
                                                <th class="px-3 py-2.5 text-center text-[11px] font-bold text-zinc-600 dark:text-zinc-300 uppercase tracking-wider w-16">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                                            @forelse($items as $i => $item)
                                            <tr wire:key="item-{{ $i }}" class="hover:bg-amber-50/50 dark:hover:bg-amber-950/10 transition-colors">
                                                <td class="px-3 py-2.5">
                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 font-bold text-[10px]">
                                                        {{ $i + 1 }}
                                                    </span>
                                                </td>
                                                <td class="px-3 py-2.5">
                                                    <div class="font-semibold text-zinc-800 dark:text-white">
                                                        {{ $item['deffect_name'] ?? '-' }}
                                                    </div>
                                                </td>
                                                <td class="px-3 py-2.5">
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-mono text-[11px] font-bold">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                                            <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                                                        </svg>
                                                        {{ $item['location'] ?? '-' }}
                                                    </span>
                                                </td>
                                                <td class="px-3 py-2.5 text-center">
                                                    <flux:button wire:click="removeItem({{ $i }})" size="sm" icon="trash" variant="primary" color="red" class="!p-2" />
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="px-3 py-10 text-center">
                                                    <div class="flex flex-col items-center gap-2">
                                                        <div class="w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-zinc-400">
                                                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                                            Belum ada item. Tambahkan defect item + location di atas.
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        {{-- ========== CARD 3: QUESTION TEXT ========== --}}
                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                            <div class="px-5 py-3.5 border-b border-zinc-200 dark:border-zinc-800 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-950/30 dark:to-pink-950/30 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-purple-500 flex items-center justify-center shadow-sm shadow-purple-500/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-white">
                                        <path fill-rule="evenodd" d="M4.125 3C3.089 3 2.25 3.84 2.25 4.875V18a3 3 0 0 0 3 3h15a3 3 0 0 1-3-3V4.875C17.25 3.839 16.41 3 15.375 3H4.125ZM12 9.75a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H12Zm-.75-2.25a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5H12a.75.75 0 0 1-.75-.75ZM6 12.75a.75.75 0 0 0 0 1.5h7.5a.75.75 0 0 0 0-1.5H6Zm-.75 3.75a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5H6a.75.75 0 0 1-.75-.75ZM6 6.75a.75.75 0 0 0-.75.75v3c0 .414.336.75.75.75h3a.75.75 0 0 0 .75-.75v-3A.75.75 0 0 0 9 6.75H6Z" clip-rule="evenodd" />
                                        <path d="M18.75 6.75h1.875c.621 0 1.125.504 1.125 1.125V18a1.5 1.5 0 0 1-3 0V6.75Z" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-zinc-800 dark:text-white">Question Text</h3>
                                <span class="ml-auto text-[10px] px-2 py-0.5 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-500 font-semibold uppercase">
                                    Optional
                                </span>
                            </div>
                            <div class="p-5">
                                <flux:textarea wire:model="question_text" rows="3" placeholder="Enter question description..."></flux:textarea>
                                @error('question_text') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                    </form>
                </div>

                {{-- ==================== FOOTER ==================== --}}
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 flex justify-end gap-3">
                    <button type="button" @click="open = false"
                        class="px-5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 text-sm font-medium transition-colors">
                        Cancel
                    </button>
                    <button type="submit" form="question-form"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white text-sm font-medium shadow-lg shadow-blue-500/30 transition-colors"
                        wire:loading.attr="disabled" wire:target="save">
                        <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                            </svg>
                            {{ $question_id ? 'Update' : 'Create' }}
                        </span>
                        <span wire:loading wire:target="save" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= MODAL VIEW ================= -->
    <div x-data="{ open: false }"
        x-on:open-modal-view.window="open = true"
        x-on:close-modal-view.window="open = false"
        x-show="open" x-cloak
        @keydown.escape.window="open = false">

        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden">

                {{-- ==================== HEADER ==================== --}}
                <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-6 py-5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                                <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd" />
                                <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Question Detail</h2>
                            <p class="text-xs text-blue-100">Informasi lengkap bank soal</p>
                        </div>
                    </div>
                    <button type="button" @click="open = false"
                        class="w-9 h-9 rounded-lg bg-white/20 hover:bg-white/30 backdrop-blur-sm border border-white/30 text-white flex items-center justify-center transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                {{-- ==================== BODY ==================== --}}
                <div class="flex-1 overflow-y-auto p-6 bg-zinc-50 dark:bg-zinc-950/30">
                    @if($viewData)

                    {{-- Question ID Badge --}}
                    <div class="mb-5 flex items-center gap-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-xs font-bold shadow-lg shadow-blue-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd" />
                            </svg>
                            Question #{{ $viewData->id }}
                        </span>
                        @if($viewData->section)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold
                                @if($viewData->section === 'QC') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300
                                @elseif($viewData->section === 'SMT') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300
                                @elseif($viewData->section === 'BE') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300
                                @else bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300 @endif">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                    <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3v2.25a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3V6ZM3 15.75a3 3 0 0 1 3-3h2.25a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-2.25Zm9.75 0a3 3 0 0 1 3-3H18a3 3 0 0 1 3 3V18a3 3 0 0 1-3 3h-2.25a3 3 0 0 1-3-3v-2.25Z" clip-rule="evenodd" />
                                </svg>
                                Section {{ $viewData->section }}
                            </span>
                        @endif
                    </div>

                    {{-- ========== INFO GRID ========== --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-5">

                        {{-- Customer --}}
                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-4 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-emerald-600 dark:text-emerald-400">
                                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Customer</div>
                                <div class="text-sm font-bold text-zinc-800 dark:text-white truncate">{{ $viewData->customer->customer_name ?? '-' }}</div>
                            </div>
                        </div>

                        {{-- Model --}}
                        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-4 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-amber-600 dark:text-amber-400">
                                    <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                                    <path fill-rule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Model</div>
                                <div class="text-sm font-bold text-zinc-800 dark:text-white truncate">{{ $viewData->model->model_name ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- ========== QUESTION TEXT ========== --}}
                    @if($viewData->question_text)
                    <div class="mb-5 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-zinc-500">
                                <path fill-rule="evenodd" d="M4.125 3C3.089 3 2.25 3.84 2.25 4.875V18a3 3 0 0 0 3 3h15a3 3 0 0 1-3-3V4.875C17.25 3.839 16.41 3 15.375 3H4.125ZM12 9.75a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H12Zm-.75-2.25a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5H12a.75.75 0 0 1-.75-.75ZM6 12.75a.75.75 0 0 0 0 1.5h7.5a.75.75 0 0 0 0-1.5H6Zm-.75 3.75a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5H6a.75.75 0 0 1-.75-.75ZM6 6.75a.75.75 0 0 0-.75.75v3c0 .414.336.75.75.75h3a.75.75 0 0 0 .75-.75v-3A.75.75 0 0 0 9 6.75H6Z" clip-rule="evenodd" />
                                <path d="M18.75 6.75h1.875c.621 0 1.125.504 1.125 1.125V18a1.5 1.5 0 0 1-3 0V6.75Z" />
                            </svg>
                            <span class="text-[10px] text-zinc-500 uppercase tracking-wider font-bold">Remarks (Opsional)</span>
                        </div>
                        <p class="text-sm text-zinc-800 dark:text-zinc-200 leading-relaxed">{{ $viewData->question_text }}</p>
                    </div>
                    @endif

                    {{-- ========== DEFECT ITEMS TABLE ========== --}}
                    <div class="mb-5">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-zinc-500">
                                    <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-[10px] text-zinc-500 uppercase tracking-wider font-bold">Defect Items & Locations</span>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-semibold">
                                {{ count($viewData->items ?? []) }} item(s)
                            </span>
                        </div>

                        <div class="border-2 border-blue-200 dark:border-blue-800 rounded-xl overflow-hidden bg-white dark:bg-zinc-900">
                            <table class="w-full text-sm">
                                <thead class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wider w-14">#</th>
                                        <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wider">Defect Item</th>
                                        <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wider w-32">Location</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                    @forelse($viewData->items ?? [] as $i => $item)
                                    <tr class="hover:bg-blue-50/50 dark:hover:bg-blue-950/10 transition-colors">
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-bold text-[10px]">
                                                {{ $i + 1 }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="font-semibold text-zinc-800 dark:text-white">{{ $item['deffect_name'] ?? '-' }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-mono text-[11px] font-bold">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                                    <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $item['location'] ?? '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-8 text-center text-zinc-400 italic">
                                            Tidak ada item.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ================= MODAL DELETE ================= -->
    <div x-data="{ open: false }"
        x-show="open"
        x-on:open-modal-delete.window="open = true"
        x-on:close-modal-delete.window="open = false"
        x-cloak @keydown.escape.window="open = false">

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>

                <h3 class="text-lg font-bold mb-2 text-center">Delete Question</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4 text-center">
                    Are you sure you want to delete this question for customer
                    <span class="font-semibold">{{ $questionToDelete?->customer->customer_name }}</span>
                    - model <span class="font-semibold">{{ $questionToDelete?->model->model_name }}</span>?
                </p>

                <div class="flex justify-center gap-3 mt-4">
                    <button @click="open = false"
                        class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800">Cancel</button>
                    <button wire:click="delete"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    <div x-data="{ show: false, message: '', type: 'success' }"
        x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
        x-show="show" x-transition
        class="fixed bottom-4 right-4 z-50"
        :class="{ 'bg-green-500': type === 'success', 'bg-red-500': type === 'error', 'bg-yellow-500': type === 'warning' }"
        style="display: none;">
        <div class="text-white px-6 py-3 rounded-lg shadow-lg">
            <span x-text="message"></span>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>