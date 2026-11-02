<?php

namespace App\Livewire\PROD\Tray;

use App\Models\PROD\Tray\MasterRack;
use Ijpatricio\Mingle\Concerns\InteractsWithMingles;
use Ijpatricio\Mingle\Contracts\HasMingles;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Master Rack')]
class MasterRackManagement extends Component implements HasMingles
{
    use InteractsWithMingles;

    public int $perPage = 10;
    public int $page = 1;

    // Pilihan area default
    public array $areaOptions = ['Router', 'PKG'];

    public function mount()
    {
        if (!auth()->user()->can('view master rack')) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function component(): string
    {
        return 'resources/js/mingle/Prod/Tray/MasterRack/index.js';
    }

    public function mingleData(): array
    {
        $permissions = [
            'canCreate' => auth()->user()->can('create master rack'),
            'canEdit'   => auth()->user()->can('edit master rack'),
            'canDelete' => auth()->user()->can('delete master rack'),
        ];

        $paginator = MasterRack::query()
            ->with('creator:id,name')
            ->select('id', 'rack_number', 'area', 'created_by', 'created_at', 'updated_at')
            ->orderBy('rack_number', 'asc')   // ⬅ diubah
            ->paginate($this->perPage, ['*'], 'page', $this->page);

        return [
            'rows' => collect($paginator->items())
                ->map(fn ($r) => [
                    'id'              => $r->id,
                    'rack_number'     => $r->rack_number,
                    'area'            => $r->area,
                    'created_by_name' => $r->creator?->name ?? '-',
                    'created_at'      => optional($r->created_at)->format('d/m/Y H:i'),
                    'updated_at'      => optional($r->updated_at)->format('d/m/Y H:i'),
                    // ⬇️ Tambahkan pengecekan relasi
                    'has_relation'    => $r->locators()->exists() || $r->trays()->exists(), 
                ])
                ->toArray(),

            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'from'         => $paginator->firstItem(),
                'to'           => $paginator->lastItem(),
            ],

            'areaOptions' => $this->areaOptions,

            'permissions' => $permissions,
        ];
    }

    public function gotoPage(int $page): array
    {
        $this->page = max(1, $page);
        return $this->mingleData();
    }

    public function save(array $payload): array
    {
        if (empty($payload['id']) && !auth()->user()->can('create master rack')) {
            return ['success' => false, 'message' => 'You do not have permission to create!'];
        }
        if (!empty($payload['id']) && !auth()->user()->can('edit master rack')) {
            return ['success' => false, 'message' => 'You do not have permission to edit!'];
        }

        $rackNumber = trim($payload['rack_number'] ?? '');
        if ($rackNumber === '') {
            return ['success' => false, 'message' => 'Rack number wajib diisi'];
        }

        $exists = MasterRack::where('rack_number', $rackNumber)
            ->when(!empty($payload['id']), fn ($q) => $q->where('id', '!=', $payload['id']))
            ->exists();

        if ($exists) {
            return ['success' => false, 'message' => 'Rack number sudah ada'];
        }

        $data = [
            'rack_number' => $rackNumber,
            'area'        => $payload['area'] ?? null,
            'updated_by'  => auth()->id(),
        ];

        if (!empty($payload['id'])) {
            $row = MasterRack::find($payload['id']);
            if (!$row) {
                return ['success' => false, 'message' => 'Data tidak ditemukan'];
            }

            // ⬇️ Validasi relasi
            if (($row->locators()->exists() || $row->trays()->exists()) && $row->rack_number !== $rackNumber) {
                return ['success' => false, 'message' => 'Cannot change Rack Number because this rack is already in use.'];
            }
            
            $row->update($data);
            $message = 'Rack berhasil diperbarui';
        } else {
            $data['created_by'] = auth()->id();
            MasterRack::create($data);
            $message = 'Rack berhasil ditambahkan';
        }

        return [
            'success' => true,
            'message' => $message,
            'data'    => $this->mingleData(),
        ];
    }

    public function deleteRow(int $id): array
    {
        if (!auth()->user()->can('delete master rack')) {
            return ['success' => false, 'message' => 'You do not have permission to delete!'];
        }   

        $row = MasterRack::find($id);
        if (!$row) {
            return ['success' => false, 'message' => 'Data tidak ditemukan'];
        }

        // ⬇️ Validasi relasi
        if ($row->locators()->exists() || $row->trays()->exists()) {
            return ['success' => false, 'message' => 'Cannot delete rack because it is already assigned to a Locator or Tray.'];
        }

        $name = $row->rack_number;
        $row->delete();

        return [
            'success' => true,
            'message' => "Rack '{$name}' berhasil dihapus",
            'data'    => $this->mingleData(),
        ];
    }
}