{{-- ==================== MODAL VIEW ==================== --}}
<div x-data="{ open: false }"
    x-on:open-modal-view.window="open = true"
    x-on:close-modal-view.window="open = false"
    x-show="open" x-cloak @keydown.escape.window="open = false">

    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40" @click="open = false"></div>

    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden">

            <div class="relative overflow-hidden bg-gradient-to-r from-cyan-600 via-blue-600 to-indigo-600 px-6 py-5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                            <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">Blind Test Detail</h2>
                        <p class="text-xs text-blue-100">Informasi lengkap blind test</p>
                    </div>
                </div>
                <button type="button" @click="open = false"
                    class="w-9 h-9 rounded-lg bg-white/20 hover:bg-white/30 border border-white/30 text-white flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 bg-zinc-50 dark:bg-zinc-950/30">
                @if($viewData)
                <div class="relative overflow-hidden bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-5 mb-4 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center border-2 border-white/40">
                                <span class="text-xl font-bold text-white">{{ strtoupper(substr($viewData->employee->name ?? 'N', 0, 1)) }}</span>
                            </div>
                            <div>
                                <div class="text-[10px] text-blue-100 uppercase tracking-wider font-semibold">Employee</div>
                                <div class="text-lg font-bold text-white">{{ $viewData->employee->name ?? '-' }}</div>
                                <div class="text-xs text-blue-100 mt-0.5">
                                    {{ $viewData->employee->nik ?? '-' }} • {{ $viewData->shift ?? '-' }} • {{ $viewData->group ?? '-' }} • {{ $viewData->section ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            @php $sc = ['pending' => 'yellow', 'in_progress' => 'blue', 'completed' => 'green']; @endphp
                            <div class="text-[10px] text-blue-100 uppercase tracking-wider font-semibold mb-1">Status</div>
                            <flux:badge size="md" color="{{ $viewData->trashed() ? 'zinc' : ($sc[$viewData->status] ?? 'gray') }}">
                                {{ $viewData->trashed() ? 'Deleted' : ucfirst(str_replace('_', ' ', $viewData->status)) }}
                            </flux:badge>
                            @if($viewData->auto_saved)
                                <div class="text-[10px] text-orange-300 font-bold mt-1 uppercase">Auto Saved</div>
                            @endif
                        </div>
                    </div>
                </div>

                @if($viewData->trashed())
                <div class="mb-4 p-4 rounded-xl bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-800">
                    <div class="text-[10px] text-red-700 dark:text-red-400 uppercase tracking-wider font-semibold">Deleted Reason</div>
                    <div class="text-sm text-red-800 dark:text-red-300 mt-1">{{ $viewData->deleted_reason ?: '-' }}</div>
                    <div class="text-xs text-red-600 dark:text-red-400 mt-1">
                        Deleted at: {{ $viewData->deleted_at ? $viewData->deleted_at->format('d M Y H:i') : '-' }}
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                    <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                        <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Customer</div>
                        <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->customer->customer_name ?? '-' }}</div>
                    </div>
                    @php
                        $viewModelNames = collect($viewData->question_snapshot ?? [])
                            ->flatMap(function ($q) {
                                $items = $q['items'] ?? [];
                                if (!empty($items) && isset($items[0]['model_id'])) {
                                    return collect($items)->pluck('model_name')->filter();
                                }
                                if (!empty($q['model_id'])) {
                                    $m = \App\Models\QAQC\BlindTest\Model::find($q['model_id']);
                                    return $m ? [$m->model_name] : [];
                                }
                                return [];
                            })
                            ->unique()
                            ->values();

                        if ($viewModelNames->isEmpty() && $viewData->model) {
                            $viewModelNames = collect([$viewData->model->model_name]);
                        }
                    @endphp

                    <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                        <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">
                            Model @if($viewModelNames->count() > 1) ({{ $viewModelNames->count() }}) @endif
                        </div>
                        <div class="mt-1 flex flex-wrap gap-1">
                            @forelse($viewModelNames as $mName)
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold
                                    {{ $viewModelNames->count() > 1
                                        ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300'
                                        : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300' }}">
                                    {{ $mName }}
                                </span>
                            @empty
                                <span class="text-xs text-zinc-400">-</span>
                            @endforelse
                        </div>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                        <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Section</div>
                        <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->section ?? '-' }}</div>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                        <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Durasi</div>
                        <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">
                            {{ $viewData->duration_minutes ? $viewData->duration_minutes . ' menit' : '-' }}
                        </div>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                        <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Time Finish</div>
                        <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->finished_at ? $viewData->finished_at->format('H:i') : '-' }}</div>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                        <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Waktu Pengerjaan</div>
                        <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->duration_formatted }}</div>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                        <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Total Soal</div>
                        <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->total_items }}</div>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 p-3">
                        <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Soal Dijawab</div>
                        <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->total_correct }} / {{ $viewData->total_items }}</div>
                    </div>
                </div>

                {{-- Kunci --}}
                <div class="rounded-xl border-2 border-blue-200 dark:border-blue-800 overflow-hidden mb-4 bg-white dark:bg-zinc-900">
                    <div class="px-5 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white flex items-center gap-3">
                        <h3 class="text-sm font-semibold">Tabel Kunci Jawaban</h3>
                        <span class="text-[11px] text-blue-100">{{ count($viewData->blind_test_items ?? []) }} soal</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-blue-50 dark:bg-blue-900/20 border-b border-blue-200 dark:border-blue-800">
                                <tr>
                                    <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-blue-700 uppercase w-10">#</th>
                                    <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-blue-700 uppercase">Defect Item</th>
                                    <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-blue-700 uppercase">Location</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                @foreach($viewData->blind_test_items ?? [] as $i => $item)
                                @php $deffect = \App\Models\QAQC\BlindTest\Deffect::find($item['deffect_item_id'] ?? null); @endphp
                                <tr class="hover:bg-blue-50/50">
                                    <td class="px-3 py-2.5 text-xs">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-700 font-semibold text-[10px]">
                                            {{ $i + 1 }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2.5 text-xs font-semibold text-zinc-800 dark:text-white">{{ $deffect->deffect_item_name ?? '-' }}</td>
                                    <td class="px-3 py-2.5 text-xs">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-mono text-[10px] font-semibold">
                                            {{ $item['component_location'] ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Jawaban User --}}
                @if($viewData->status === 'completed' && $viewData->user_answers)
                <div class="rounded-xl border-2 border-green-200 dark:border-green-800 overflow-hidden mb-4 bg-white dark:bg-zinc-900">
                    <div class="px-5 py-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white flex items-center gap-3">
                        <h3 class="text-sm font-semibold">Tabel Jawaban User & Hasil</h3>
                        <span class="text-[11px] text-green-100">{{ count($viewData->user_answers) }} baris</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-green-50 dark:bg-green-900/20 border-b border-green-200">
                                <tr>
                                    <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-green-700 uppercase w-10">#</th>
                                    <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-green-700 uppercase">Defect Item</th>
                                    <th class="px-3 py-2.5 text-left text-[11px] font-semibold text-green-700 uppercase">Location</th>
                                    <th class="px-3 py-2.5 text-center text-[11px] font-semibold text-green-700 uppercase w-32">Hasil</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                @foreach($viewData->user_answers as $i => $row)
                                @php
                                    $deffect = $row['deffect_item_id'] ? \App\Models\QAQC\BlindTest\Deffect::find($row['deffect_item_id']) : null;
                                    $userAnswer = $row['user_answer'] ?? '';
                                    $isCorrect = $row['is_correct'] ?? false;
                                    $isMissing = $userAnswer === 'MISSING';
                                    $isExtra = $userAnswer === 'EXTRA';
                                @endphp
                                <tr class="@if($isCorrect) hover:bg-green-50/50 @elseif($isMissing) bg-yellow-50/50 @elseif($isExtra) bg-purple-50/50 @else bg-red-50/50 @endif">
                                    <td class="px-3 py-2.5 text-xs">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full font-semibold text-[10px]
                                            @if($isCorrect) bg-green-100 text-green-700
                                            @elseif($isMissing) bg-yellow-100 text-yellow-700
                                            @elseif($isExtra) bg-purple-100 text-purple-700
                                            @else bg-red-100 text-red-700 @endif">
                                            {{ $i + 1 }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2.5 text-xs">
                                        <div class="font-semibold text-zinc-800 dark:text-white">{{ $deffect->deffect_item_name ?? '-' }}</div>
                                        @if($isMissing) <div class="text-[10px] text-orange-600 italic">Dari kunci</div> @endif
                                        @if($isExtra) <div class="text-[10px] text-purple-600 italic">Extra</div> @endif
                                    </td>
                                    <td class="px-3 py-2.5 text-xs">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-mono text-[10px] font-semibold">
                                            {{ $row['component_location'] ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2.5 text-center">
                                        @if($isCorrect)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-[10px] font-semibold border border-green-300">✓ Cocok</span>
                                        @elseif($isMissing)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700 text-[10px] font-semibold border border-yellow-300">⚠ Tidak Dijawab</span>
                                        @elseif($isExtra)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-purple-100 text-purple-700 text-[10px] font-semibold border border-purple-300">+ Extra</span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-100 text-red-700 text-[10px] font-semibold border border-red-300">✗ Tidak Cocok</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                {{-- Signature --}}
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-5">
                    <h3 class="text-sm font-bold text-zinc-800 dark:text-white mb-4">Signatures</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <div class="p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                            <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Check By QC</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->checkerQc->name ?? '-' }}</div>
                        </div>
                        <div class="p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                            <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Check By Prod</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->checkerProd->name ?? '-' }}</div>
                        </div>
                        <div class="p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                            <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Ack. By SPV</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->acknowledgerSpv->name ?? '-' }}</div>
                        </div>
                        <div class="p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                            <div class="text-[10px] text-zinc-500 uppercase tracking-wider font-semibold">Ack. QC SPV</div>
                            <div class="text-sm font-semibold text-zinc-800 dark:text-white mt-1">{{ $viewData->acknowledgerQcSpv->name ?? '-' }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 flex justify-end gap-3">
                <button type="button" @click="open = false"
                    class="px-5 py-2.5 rounded-lg border border-zinc-300 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 text-sm font-medium">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>