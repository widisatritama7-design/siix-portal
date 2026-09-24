<div class="p-1 space-y-3">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('qaqc.blind-test') }}" wire:navigate separator="slash" class="font-semibold text-blue-600">QA/QC</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Review Blind Test</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 shadow-xl">
        <div class="relative p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-white">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">Review Blind Test</h1>
                    <p class="text-sm text-blue-100 mt-1">
                        {{ $blindTest->employee->name ?? '-' }} ({{ $blindTest->employee->nik ?? '-' }})
                        • {{ $blindTest->section }}
                    </p>
                </div>
            </div>
            <a href="{{ route('qaqc.blind-test') }}" wire:navigate>
                <button type="button" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/20 hover:bg-white/30 border border-white/30 text-white font-medium text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-4.28 9.22a.75.75 0 0 0 0 1.06l3 3a.75.75 0 1 0 1.06-1.06l-1.72-1.72h5.69a.75.75 0 0 0 0-1.5h-5.69l1.72-1.72a.75.75 0 0 0-1.06-1.06l-3 3Z" clip-rule="evenodd" />
                    </svg>
                    Back
                </button>
            </a>
        </div>
    </div>

    <!-- Info Ringkas -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-4">
            <div class="text-[10px] text-zinc-500 uppercase font-semibold tracking-wider">Customer</div>
            <div class="text-sm font-bold text-zinc-800 dark:text-white mt-1">{{ $blindTest->customer->customer_name ?? '-' }}</div>
        </div>
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-4">
            <div class="text-[10px] text-zinc-500 uppercase font-semibold tracking-wider">Model</div>
            <div class="text-sm font-bold text-zinc-800 dark:text-white mt-1">{{ $blindTest->model->model_name ?? '-' }}</div>
        </div>
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-4">
            <div class="text-[10px] text-zinc-500 uppercase font-semibold tracking-wider">Total Soal</div>
            <div class="text-sm font-bold text-zinc-800 dark:text-white mt-1">{{ $blindTest->total_items }}</div>
        </div>
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-4">
            <div class="text-[10px] text-zinc-500 uppercase font-semibold tracking-wider">Status Review</div>
            <div class="mt-1">
                @if($blindTest->is_reviewed)
                    <flux:badge size="sm" color="green">Reviewed</flux:badge>
                @else
                    <flux:badge size="sm" color="yellow">Pending Review</flux:badge>
                @endif
            </div>
        </div>
    </div>

    <!-- Tabel Review -->
    <flux:card class="p-6 shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full" style="min-width: 1400px; white-space: nowrap;">
                <thead>
                    {{-- Row 1: Group header --}}
                    <tr class="bg-zinc-100 dark:bg-zinc-800">
                        <th class="px-3 py-2.5 text-center text-xs font-bold text-zinc-600 dark:text-zinc-300 uppercase border-r border-zinc-200 dark:border-zinc-700 w-12">#</th>

                        <th class="px-3 py-2.5 text-center text-xs font-bold text-blue-700 dark:text-blue-300 uppercase border-r border-zinc-200 dark:border-zinc-700" colspan="2">
                            <div class="flex items-center justify-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                                </svg>
                                Jawaban User
                            </div>
                        </th>

                        <th class="px-3 py-2.5 text-center text-xs font-bold text-amber-700 dark:text-amber-300 uppercase border-r border-zinc-200 dark:border-zinc-700" colspan="2">
                            <div class="flex items-center justify-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                    <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                                </svg>
                                Kunci Jawaban
                            </div>
                        </th>

                        <th class="px-3 py-2.5 text-center text-xs font-bold text-purple-700 dark:text-purple-300 uppercase" colspan="3">
                            <div class="flex items-center justify-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                </svg>
                                Penilaian QC
                            </div>
                        </th>
                    </tr>

                    {{-- Row 2: Sub-header --}}
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700">
                        <th class="px-3 py-2 text-center text-[10px] font-medium text-zinc-500 uppercase border-r border-zinc-200 dark:border-zinc-700"></th>
                        <th class="px-3 py-2 text-left text-[10px] font-semibold text-blue-600 dark:text-blue-400 uppercase border-r border-zinc-200 dark:border-zinc-700" style="min-width: 200px;">Defect Item</th>
                        <th class="px-3 py-2 text-center text-[10px] font-semibold text-blue-600 dark:text-blue-400 uppercase border-r border-zinc-200 dark:border-zinc-700" style="min-width: 130px;">Location</th>
                        <th class="px-3 py-2 text-left text-[10px] font-semibold text-amber-600 dark:text-amber-400 uppercase border-r border-zinc-200 dark:border-zinc-700" style="min-width: 200px;">Defect Item</th>
                        <th class="px-3 py-2 text-center text-[10px] font-semibold text-amber-600 dark:text-amber-400 uppercase border-r border-zinc-200 dark:border-zinc-700" style="min-width: 130px;">Location</th>
                        <th class="px-3 py-2 text-center text-[10px] font-semibold text-purple-600 dark:text-purple-400 uppercase border-r border-zinc-200 dark:border-zinc-700" style="min-width: 110px;">Match Defect</th>
                        <th class="px-3 py-2 text-center text-[10px] font-semibold text-purple-600 dark:text-purple-400 uppercase border-r border-zinc-200 dark:border-zinc-700" style="min-width: 260px;">Review Location</th>
                        <th class="px-3 py-2 text-center text-[10px] font-semibold text-purple-600 dark:text-purple-400 uppercase" style="min-width: 110px;">Final</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($answers as $i => $ans)
                    @php
                        $deffect = \App\Models\QAQC\BlindTest\Deffect::find($ans['deffect_item_id'] ?? null);
                        $isMissing = ($ans['user_answer'] ?? '') === 'MISSING';
                        $deffectMatch = $ans['deffect_match'] ?? false;
                        $locStatus = $ans['location_status'] ?? 'pending';
                        $isCorrect = $ans['is_correct'] ?? false;

                        $keyItem = collect($blindTest->blind_test_items ?? [])
                            ->firstWhere('deffect_item_id', $ans['deffect_item_id'] ?? null);

                        $keyDeffectId = $keyItem['deffect_item_id'] ?? null;
                        $keyDeffect = $keyDeffectId ? \App\Models\QAQC\BlindTest\Deffect::find($keyDeffectId) : null;
                        $keyLocation = $keyItem['component_location'] ?? null;

                        $userLocation = $ans['component_location'] ?? null;
                        $locationSame = $userLocation && $keyLocation && strtoupper(trim($userLocation)) === strtoupper(trim($keyLocation));
                    @endphp
                    <tr wire:key="ans-{{ $i }}"
                        class="@if($isMissing) bg-yellow-50/40 dark:bg-yellow-950/10
                            @elseif(!$deffectMatch) bg-red-50/40 dark:bg-red-950/10
                            @elseif($locStatus === 'valid') bg-green-50/40 dark:bg-green-950/10
                            @elseif($locStatus === 'invalid') bg-red-50/40 dark:bg-red-950/10
                            @else bg-white dark:bg-zinc-900 @endif">

                        {{-- # --}}
                        <td class="px-3 py-3 text-center text-xs font-semibold text-zinc-500 border-r border-zinc-200 dark:border-zinc-700">
                            {{ $i + 1 }}
                        </td>

                        {{-- ========== USER ========== --}}
                        <td class="px-3 py-3 border-r border-zinc-200 dark:border-zinc-700">
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white">
                                {{ $deffect->deffect_item_name ?? '-' }}
                            </div>
                            @if($isMissing)
                                <div class="text-[10px] text-orange-600 dark:text-orange-400 italic mt-0.5 inline-flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                    </svg>
                                    Tidak dijawab
                                </div>
                            @endif
                        </td>
                        <td class="px-3 py-3 text-center border-r border-zinc-200 dark:border-zinc-700">
                            @if($isMissing)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md font-mono text-[11px] font-semibold bg-zinc-100 text-zinc-400 dark:bg-zinc-800 dark:text-zinc-500">
                                    -
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md font-mono text-[11px] font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                    {{ $userLocation ?: '-' }}
                                </span>
                            @endif
                        </td>

                        {{-- ========== KUNCI ========== --}}
                        <td class="px-3 py-3 border-r border-zinc-200 dark:border-zinc-700">
                            <div class="text-sm font-semibold text-amber-800 dark:text-amber-300">
                                {{ $keyDeffect->deffect_item_name ?? '-' }}
                            </div>
                        </td>
                        <td class="px-3 py-3 text-center border-r border-zinc-200 dark:border-zinc-700">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md font-mono text-[11px] font-semibold bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">
                                {{ $keyLocation ?: '-' }}
                            </span>
                            @if(!$isMissing && $deffectMatch)
                                @if($locationSame)
                                    <div class="text-[10px] text-green-600 dark:text-green-400 font-bold mt-1 inline-flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                        </svg>
                                        Sama
                                    </div>
                                @else
                                    <div class="text-[10px] text-orange-600 dark:text-orange-400 font-bold mt-1 inline-flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                        </svg>
                                        Beda
                                    </div>
                                @endif
                            @endif
                        </td>

                        {{-- ========== QC: MATCH ========== --}}
                        <td class="px-3 py-3 text-center border-r border-zinc-200 dark:border-zinc-700">
                            @if($isMissing)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-500 text-[10px] font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                    </svg>
                                    N/A
                                </span>
                                <div class="text-[9px] text-zinc-400 italic mt-0.5">Tidak dijawab</div>
                            @elseif($deffectMatch)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-[10px] font-bold border border-green-300 dark:border-green-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                    </svg>
                                    Cocok
                                </span>
                                <div class="text-[9px] text-green-600 dark:text-green-400 italic mt-0.5">Perlu review lokasi</div>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-[10px] font-bold border border-red-300 dark:border-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                        <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                    </svg>
                                    Tidak
                                </span>
                                <div class="text-[9px] text-red-600 dark:text-red-400 italic mt-0.5">Auto salah</div>
                            @endif
                        </td>

                        {{-- ========== QC: REVIEW LOCATION ========== --}}
                        <td class="px-3 py-3 text-center border-r border-zinc-200 dark:border-zinc-700">
                            @if($isMissing || !$deffectMatch)
                                <span class="inline-flex items-center gap-1 text-[10px] text-zinc-400 italic">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                    </svg>
                                    Auto (tidak perlu review)
                                </span>
                            @else
                                <div class="inline-flex rounded-lg border border-zinc-300 dark:border-zinc-700 overflow-hidden shadow-sm">
                                    <button type="button"
                                        wire:click="setLocationStatus({{ $i }}, 'valid')"
                                        @if($blindTest->is_reviewed) disabled @endif
                                        class="px-3 py-1.5 text-xs font-semibold transition-colors disabled:cursor-not-allowed
                                            {{ $locStatus === 'valid'
                                                ? 'bg-green-600 text-white shadow-inner'
                                                : 'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 hover:bg-green-50 dark:hover:bg-green-950/20' }}">
                                        <span class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                            </svg>
                                            Valid
                                        </span>
                                    </button>
                                    <button type="button"
                                        wire:click="setLocationStatus({{ $i }}, 'invalid')"
                                        @if($blindTest->is_reviewed) disabled @endif
                                        class="px-3 py-1.5 text-xs font-semibold transition-colors border-l border-zinc-300 dark:border-zinc-700 disabled:cursor-not-allowed
                                            {{ $locStatus === 'invalid'
                                                ? 'bg-red-600 text-white shadow-inner'
                                                : 'bg-white dark:bg-zinc-900 text-zinc-600 dark:text-zinc-400 hover:bg-red-50 dark:hover:bg-red-950/20' }}">
                                        <span class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                                <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                            </svg>
                                            Invalid
                                        </span>
                                    </button>
                                </div>
                                @if($locStatus === 'pending')
                                    <div class="text-[10px] text-yellow-600 dark:text-yellow-400 italic mt-1 font-semibold inline-flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd" />
                                        </svg>
                                        Belum direview
                                    </div>
                                @endif
                            @endif
                        </td>

                        {{-- ========== QC: FINAL ========== --}}
                        <td class="px-3 py-3 text-center">
                            @if($isCorrect)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-[11px] font-bold border-2 border-green-300 dark:border-green-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                    </svg>
                                    BENAR
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-[11px] font-bold border-2 border-red-300 dark:border-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                        <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                    </svg>
                                    SALAH
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-zinc-400 italic">
                            Tidak ada jawaban untuk direview.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Summary --}}
        @if(count($answers) > 0)
        @php
            $totalCorrect = collect($answers)->where('is_correct', true)->count();
            $totalAnswers = count($answers);
            $stillPending = collect($answers)->where('location_status', 'pending')->count();
        @endphp
        <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4 text-sm">
                <div>
                    <span class="text-zinc-500">Benar:</span>
                    <strong class="text-green-600 dark:text-green-400">{{ $totalCorrect }}</strong>
                </div>
                <div>
                    <span class="text-zinc-500">Total:</span>
                    <strong class="text-zinc-700 dark:text-zinc-300">{{ $totalAnswers }}</strong>
                </div>
                @if($stillPending > 0)
                <div>
                    <span class="text-zinc-500">Pending:</span>
                    <strong class="text-yellow-600 dark:text-yellow-400">{{ $stillPending }}</strong>
                </div>
                @endif
            </div>

            @if(!$blindTest->is_reviewed)
            <button type="button" wire:click="saveReview"
                @if($stillPending > 0) disabled @endif
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm font-semibold shadow-lg shadow-blue-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                </svg>
                Submit Review
            </button>
            @else
            <div class="text-sm text-green-600 dark:text-green-400 font-semibold inline-flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                </svg>
                Sudah direview oleh {{ $blindTest->reviewer->name ?? '-' }}
                ({{ $blindTest->reviewed_at ? $blindTest->reviewed_at->format('d/m/Y H:i') : '-' }})
            </div>
            @endif
        </div>
        @endif
    </flux:card>

    <!-- Notifikasi -->
    <div x-data="{ show: false, message: '', type: 'success' }"
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3500)"
         x-show="show" x-transition
         class="fixed bottom-4 right-4 z-50"
         :class="{ 'bg-green-500': type === 'success', 'bg-red-500': type === 'error', 'bg-yellow-500': type === 'warning', 'bg-blue-500': type === 'info' }"
         style="display: none;">
        <div class="text-white px-6 py-3 rounded-lg shadow-lg">
            <span x-text="message"></span>
        </div>
    </div>

    <style>[x-cloak] { display: none !important; }</style>
</div>