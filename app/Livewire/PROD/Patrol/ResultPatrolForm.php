<?php

namespace App\Livewire\PROD\Patrol;

use App\Models\PROD\Patrol\ResultPatrol;
use App\Models\PROD\Patrol\StandardPatrol;
use App\Models\PROD\Patrol\CategoryPatrol;
use App\Models\MTC\Master\MasterLine;
use Ijpatricio\Mingle\Concerns\InteractsWithMingles;
use Ijpatricio\Mingle\Contracts\HasMingles;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Form Result Patrol')]
class ResultPatrolForm extends Component implements HasMingles
{
    use InteractsWithMingles;

    public ?int $id = null;

    public function mount(?int $id = null)
    {
        $this->id = $id;
    }

    public function component(): string
    {
        return 'resources/js/mingle/Prod/Patrol/ResultPatrol/form.js';
    }

    public function mingleData(): array
    {
        // Ambil data existing jika mode edit
        $resultData = null;
        if ($this->id) {
            $r = ResultPatrol::find($this->id);
            if ($r) {
                $resultData = [
                    'id'                    => $r->id,
                    'shift'                 => $r->shift,
                    'group'                 => $r->group,
                    'master_line_id'        => (string) $r->master_line_id,
                    'standard_patrol_items' => $r->standard_patrol_items ?? [],
                    'finding_patrol_items'  => $r->finding_patrol_items ?? [],
                ];
            }
        }

        // Auto-fill mapping Standard Patrol berdasarkan Master Line
        $allStandards = StandardPatrol::all(['line', 'master_line_id', 'item_check', 'standard']);
        $standardsByLineId = [];

        foreach (MasterLine::all(['id']) as $ml) {
            $matchedStandards = $allStandards->filter(function($s) use ($ml) {
                $ids = $s->master_line_id ?? [];
                return in_array($ml->id, $ids);
            });

            $grouped = $matchedStandards->groupBy('line')->map(function ($items, $lineName) {
                return [
                    'line_name' => $lineName,
                    'items'     => $items->map(fn($s) => [
                        'item_check' => $s->item_check,
                        'standard'   => $s->standard,
                    ])->values()->toArray(),
                ];
            })->values()->toArray();

            $standardsByLineId[$ml->id] = $grouped;
        }

        return [
            'result' => $resultData,
            'masterLines' => MasterLine::with(['location.area'])
                ->whereHas('location.area', function($q) {
                    $q->where('area_name', 'Production 01');
                })
                ->orderBy('line_number')
                ->get()
                ->map(function($ml) {
                    return [
                        'id'          => (int) $ml->id, 
                        'line_number' => (string) $ml->line_number,
                        // Tampilkan location_name di tabel, bukan area_name
                        'location'    => (string) ($ml->location?->location_name ?? '-'), 
                        // Kirim area_name juga untuk keperluan filter/sort di React
                        'area_name'   => (string) ($ml->location?->area?->area_name ?? '-'),
                    ];
                })->toArray(),
            'categories' => CategoryPatrol::orderBy('category_name')->get(['id', 'category_name'])->toArray(),
            'employees' => \App\Models\User::query()
                ->permission('feedback result patrol')
                ->orderBy('name')
                ->get(['id', 'name'])
                ->map(fn($u) => [
                    'id'   => (string) $u->id,
                    'nik'  => (string) $u->id,
                    'name' => $u->name,
                ])
                ->toArray(),
            'standardsByLine' => $standardsByLineId,
        ];
    }

    public function save(array $payload): array
    {
        $data = [
            'shift'                 => $payload['shift'] ?? null,
            'group'                 => $payload['group'] ?? null,
            'master_line_id'        => $payload['master_line_id'] ?? null,
            'standard_patrol_items' => $payload['standard_patrol_items'] ?? [],
            'finding_patrol_items'  => $payload['finding_patrol_items'] ?? [],
            'updated_by'            => auth()->id(),
        ];

        if (!$data['master_line_id']) {
            return ['success' => false, 'message' => 'Master Line wajib dipilih'];
        }

        // ✅ BARU — normalisasi: pastikan evidence & evidence_action selalu array, max 4
        $data['finding_patrol_items'] = array_map(function ($f) {
            $f['evidence'] = array_values(array_slice(
                is_array($f['evidence'] ?? null) ? $f['evidence'] : (!empty($f['evidence']) ? [$f['evidence']] : []),
                0, 4
            ));
            $f['evidence_action'] = array_values(array_slice(
                is_array($f['evidence_action'] ?? null) ? $f['evidence_action'] : (!empty($f['evidence_action']) ? [$f['evidence_action']] : []),
                0, 4
            ));
            return $f;
        }, $data['finding_patrol_items']);

        if (!empty($payload['id'])) {
            $row = ResultPatrol::find($payload['id']);
            if (!$row) return ['success' => false, 'message' => 'Data tidak ditemukan'];
            $row->update($data);
            $message = 'Result Patrol berhasil diperbarui';
        } else {
            $data['created_by'] = auth()->id();
            ResultPatrol::create($data);
            $message = 'Result Patrol berhasil disimpan';
        }

        return [
            'success'  => true, 
            'message'  => $message, 
            'redirect' => route('prod.patrol.result-patrol.index')
        ];
    }
}