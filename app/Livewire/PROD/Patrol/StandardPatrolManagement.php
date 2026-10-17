<?php

namespace App\Livewire\PROD\Patrol;

use App\Models\PROD\Patrol\StandardPatrol;
use App\Models\MTC\Master\MasterLine;
use Ijpatricio\Mingle\Concerns\InteractsWithMingles;
use Ijpatricio\Mingle\Contracts\HasMingles;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

#[Title('Standard Patrol')]
class StandardPatrolManagement extends Component implements HasMingles
{
    use InteractsWithMingles;

    public int $perPage = 10;
    public int $page = 1;

    // Cek akses awal saat halaman dibuka
    public function mount()
    {
        if (!auth()->user()->can('view standard patrol')) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function component(): string
    {
        return 'resources/js/mingle/Prod/Patrol/StandardPatrol/index.js';
    }

    public function mingleData(): array
    {
        // 1. Ambil data StandardPatrol (terbaru di atas)
        $paginator = StandardPatrol::query()
            ->select('id', 'line', 'master_line_id', 'item_check', 'standard', 'created_at', 'updated_at')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage, ['*'], 'page', $this->page);

        return [
            // 2. Format data untuk tabel (rows)
            'rows' => collect($paginator->items())
                ->map(function ($r) {
                    // Ambil relasi manual MasterLine dari JSON array
                    $masterLines = $r->getMasterLines()->map(fn($ml) => [
                        'id'          => (int) $ml->id,
                        'line_number' => (string) ($ml->line_number ?? ''),
                        'location'    => $ml->location ? $ml->location->location_name : null,
                    ])->values()->toArray();

                    return [
                        'id'              => $r->id,
                        'line'            => $r->line,
                        'item_check'      => $r->item_check,
                        'standard'        => $r->standard,
                        'master_line_ids' => $r->master_line_id ?? [],
                        'master_lines'    => $masterLines,
                        'created_at'      => optional($r->created_at)->format('d/m/Y H:i'),
                        'updated_at'      => optional($r->updated_at)->format('d/m/Y H:i'),
                    ];
                })
                ->toArray(),

            // 3. Data Pagination
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'from'         => $paginator->firstItem(),
                'to'           => $paginator->lastItem(),
            ],

            // 4. List Line unik untuk autocomplete di form
            'lines' => StandardPatrol::query()
                ->select('line')
                ->distinct()
                ->whereNotNull('line')
                ->orderBy('line')
                ->pluck('line')
                ->values()
                ->toArray(),

            // 5. List MasterLine (dari MTC) untuk checkbox di form
            'masterLines' => MasterLine::query()
                ->leftJoin('tb_mtc_master_locations', 'tb_mtc_master_lines.location_id', '=', 'tb_mtc_master_locations.id')
                ->select('tb_mtc_master_lines.id', 'tb_mtc_master_lines.line_number', 'tb_mtc_master_locations.location_name')
                ->orderBy('tb_mtc_master_locations.location_name', 'asc')
                ->orderBy('tb_mtc_master_lines.line_number', 'asc')
                ->get()
                ->map(fn($ml) => [
                    'id'          => (int) $ml->id,
                    'line_number' => (string) ($ml->line_number ?? ''),
                    'location'    => $ml->location_name ?? null,
                ])
                ->toArray(),

            // 6. Kirim Permission ke React
            'permissions' => [
                'canCreate' => auth()->user()->can('create standard patrol'),
                'canEdit'   => auth()->user()->can('edit standard patrol'),
                'canDelete' => auth()->user()->can('delete standard patrol'),
            ],
        ];
    }

    public function gotoPage(int $page): array
    {
        $this->page = max(1, $page);
        return $this->mingleData();
    }

    /**
     * Simpan / Update multi-item untuk 1 Line beserta relasi MasterLine-nya.
     */
    public function saveBatch(array $payload): array
    {
        // Cek izin (Create atau Edit)
        $isEdit = !empty($payload['items'][0]['id']);
        if ($isEdit && !auth()->user()->can('edit standard patrol')) {
            return ['success' => false, 'message' => 'You do not have permission to edit!'];
        }
        if (!$isEdit && !auth()->user()->can('create standard patrol')) {
            return ['success' => false, 'message' => 'You do not have permission to create!'];
        }

        $line        = trim($payload['line'] ?? '');
        $items       = $payload['items'] ?? [];
        $masterIds   = $payload['master_line_ids'] ?? [];

        if ($line === '') {
            return ['success' => false, 'message' => 'Line wajib diisi'];
        }
        if (empty($items)) {
            return ['success' => false, 'message' => 'Minimal 1 item check harus diisi'];
        }
        if (empty($masterIds)) {
            return ['success' => false, 'message' => 'Pilih minimal 1 Master Line'];
        }

        foreach ($items as $i => $item) {
            if (empty(trim($item['item_check'] ?? ''))) {
                return ['success' => false, 'message' => "Item ke-" . ($i + 1) . " : Item Check wajib diisi"];
            }
            if (empty(trim($item['standard'] ?? ''))) {
                return ['success' => false, 'message' => "Item ke-" . ($i + 1) . " : Standard wajib diisi"];
            }
        }

        DB::beginTransaction();
        try {
            $userId  = auth()->id();
            $saved   = 0;
            $updated = 0;
            
            $masterIds = array_values(array_unique(array_map('intval', $masterIds)));

            foreach ($items as $item) {
                $data = [
                    'line'           => $line,
                    'master_line_id' => $masterIds,
                    'item_check'     => trim($item['item_check']),
                    'standard'       => trim($item['standard']),
                    'updated_by'     => $userId,
                ];

                if (!empty($item['id'])) {
                    $row = StandardPatrol::find($item['id']);
                    if ($row) {
                        $row->update($data);
                        $updated++;
                    }
                } else {
                    $data['created_by'] = $userId;
                    StandardPatrol::create($data);
                    $saved++;
                }
            }

            DB::commit();

            return [
                'success' => true,
                'message' => "Berhasil: {$saved} item baru, {$updated} item diperbarui",
                'data'    => $this->mingleData(),
            ];
        } catch (\Throwable $e) {
            DB::rollBack();
            return ['success' => false, 'message' => 'Gagal menyimpan: ' . $e->getMessage()];
        }
    }

    /**
     * Ambil data item & master line berdasarkan nama Line untuk form Edit
     */
    public function getLineItems(string $line): array
    {
        $rows = StandardPatrol::query()
            ->where('line', $line)
            ->orderBy('item_check')
            ->get();

        $first = $rows->first();
        $masterIds = $first ? ($first->master_line_id ?? []) : [];

        return [
            'items' => $rows->map(fn($r) => [
                'id'         => $r->id,
                'item_check' => $r->item_check,
                'standard'   => $r->standard,
            ])->toArray(),
            'master_line_ids' => $masterIds,
        ];
    }

    /**
     * Hapus semua item di dalam 1 Line
     */
    public function deleteLine(string $line): array
    {
        if (!auth()->user()->can('delete standard patrol')) {
            return ['success' => false, 'message' => 'You do not have permission to delete!'];
        }

        $count = StandardPatrol::where('line', $line)->delete();

        return [
            'success' => true,
            'message' => "Berhasil hapus {$count} item di line '{$line}'",
            'data'    => $this->mingleData(),
        ];
    }
}