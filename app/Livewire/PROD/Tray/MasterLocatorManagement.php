<?php

namespace App\Livewire\PROD\Tray;

use App\Models\PROD\Tray\MasterLocator;
use App\Models\PROD\Tray\MasterRack;
use Ijpatricio\Mingle\Concerns\InteractsWithMingles;
use Ijpatricio\Mingle\Contracts\HasMingles;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Master Locator')]
class MasterLocatorManagement extends Component implements HasMingles
{
    use InteractsWithMingles;

    public int $perPage = 10;
    public int $page = 1;
    public string $search = '';
    
    // Filter Rack
    public string $filterRackId = '';

    public function mount(): void
    {
        if (!auth()->check() || !auth()->user()->can('view master locator')) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function component(): string
    {
        return 'resources/js/mingle/Prod/Tray/MasterLocator/index.js';
    }

    public function mingleData(): array
    {
        $permissions = [
            'canCreate' => auth()->user()->can('create master locator'),
            'canEdit'   => auth()->user()->can('edit master locator'),
            'canDelete' => auth()->user()->can('delete master locator'),
        ];

        $query = MasterLocator::query()
            ->select('tb_prod_master_locator.*')
            ->join('tb_prod_master_rack', 'tb_prod_master_rack.id', '=', 'tb_prod_master_locator.master_rack_id')
            ->with(['rack:id,rack_number', 'creator:id,name', 'trays']);

        // Filter Search
        if ($this->search !== '') {
            $search = strtolower($this->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(tb_prod_master_rack.rack_number) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(tb_prod_master_locator.locator_number) LIKE ?', ["%{$search}%"]);
            });
        }

        // Filter Rack Dropdown
        if ($this->filterRackId !== '') {
            $query->where('tb_prod_master_locator.master_rack_id', $this->filterRackId);
        }

        $paginator = $query->orderBy('tb_prod_master_rack.rack_number', 'asc')
            ->orderBy('tb_prod_master_locator.locator_number', 'asc')
            ->paginate($this->perPage, ['*'], 'page', $this->page);

        return [
            'rows' => collect($paginator->items())
                ->map(fn ($r) => [
                    'id'              => $r->id,
                    'master_rack_id'  => $r->master_rack_id,
                    'rack_number'     => $r->rack?->rack_number,
                    'locator_number'  => $r->locator_number,
                    'created_by_name' => $r->creator?->name ?? '-',
                    'created_at'      => optional($r->created_at)->format('d/m/Y H:i'),
                    'has_tray'        => $r->trays->isNotEmpty(),
                ])
                ->toArray(),

            'racks' => MasterRack::query()
                ->select('id', 'rack_number')
                ->orderBy('rack_number')
                ->get()
                ->toArray(),

            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'from'         => $paginator->firstItem(),
                'to'           => $paginator->lastItem(),
            ],

            'permissions' => $permissions,
        ];
    }

    public function applyFilter(string $search = '', string $rackId = ''): array
    {
        $this->search = $search;
        $this->filterRackId = $rackId;
        $this->page = 1;
        return $this->mingleData();
    }

    public function gotoPage(int $page): array
    {
        $this->page = max(1, $page);
        return $this->mingleData();
    }

    public function save(array $payload): array
    {
        $isUpdate = !empty($payload['id']);

        if (!$isUpdate && !auth()->user()->can('create master locator')) {
            return ['success' => false, 'message' => 'You do not have permission to create!'];
        }
        if ($isUpdate && !auth()->user()->can('edit master locator')) {
            return ['success' => false, 'message' => 'You do not have permission to edit!'];
        }

        $rackId = $payload['master_rack_id'] ?? null;
        $locatorNumber = trim((string) ($payload['locator_number'] ?? ''));

        if (!$rackId) {
            return ['success' => false, 'message' => 'Rack is required'];
        }
        if ($locatorNumber === '') {
            return ['success' => false, 'message' => 'Locator number is required'];
        }
        if (!MasterRack::whereKey($rackId)->exists()) {
            return ['success' => false, 'message' => 'Rack not found'];
        }

        $data = [
            'master_rack_id' => (int) $rackId,
            'locator_number' => $locatorNumber,
            'updated_by'     => auth()->id(),
        ];

        if ($isUpdate) {
            $row = MasterLocator::find($payload['id']);
            if (!$row) {
                return ['success' => false, 'message' => 'Data not found'];
            }

            if ($row->trays()->exists()) {
                if ((int)$row->master_rack_id !== (int)$rackId || $row->locator_number !== $locatorNumber) {
                    return ['success' => false, 'message' => 'Cannot change Rack or Locator Number because this locator is already assigned to a tray.'];
                }
            }

            $row->update($data);
            $message = 'Locator updated successfully';
        } else {
            $exists = MasterLocator::where('master_rack_id', $rackId)
                ->where('locator_number', $locatorNumber)
                ->exists();

            if ($exists) {
                return ['success' => false, 'message' => 'Locator number already exists in this rack'];
            }

            $data['created_by'] = auth()->id();
            MasterLocator::create($data);
            $message = 'Locator added successfully';
        }

        return [
            'success' => true,
            'message' => $message,
            'data'    => $this->mingleData(),
        ];
    }

    public function getTraysByLocator(int $locatorId): array
    {
        $trays = \App\Models\PROD\Tray\MasterTray::query()
            ->where('master_locator_id', $locatorId)
            ->with(['rack:id,rack_number', 'customer:id,customer_name'])
            ->orderBy('part_number_tray')
            ->get();

        return [
            'success' => true,
            'trays'   => $trays->map(fn ($t) => [
                'id'               => $t->id,
                'part_number_tray' => $t->part_number_tray ?: '-',
                'item_code_sap'    => $t->item_code_sap ?: '-',
                'desc'             => $t->desc ?: '-',
                'model'            => $t->model ?: '-',
                'cav_tray'         => $t->cav_tray,
                'customer_name'    => $t->customer?->customer_name ?: '-',
            ])->toArray(),
        ];
    }

    public function getQrDataByRack(string $rackId): array
    {
        $query = MasterLocator::query()
            ->where('master_rack_id', $rackId)
            ->with('rack:id,rack_number')
            ->orderBy('locator_number');

        $locators = $query->get();

        return [
            'success' => true,
            'qr_data' => $locators->map(fn($l) => [
                'id' => $l->id,
                'locator_number' => $l->locator_number,
                'rack_number' => $l->rack?->rack_number,
            ])->toArray(),
        ];
    }

    public function deleteRow(int $id): array
    {
        if (!auth()->user()->can('delete master locator')) {
            return ['success' => false, 'message' => 'You do not have permission to delete!'];
        }

        $row = MasterLocator::find($id);
        if (!$row) {
            return ['success' => false, 'message' => 'Data not found'];
        }

        if ($row->trays()->exists()) {
            return ['success' => false, 'message' => 'Cannot delete locator because it is already assigned to a tray.'];
        }

        $name = $row->locator_number;
        $row->delete();

        return [
            'success' => true,
            'message' => "Locator '{$name}' deleted successfully",
            'data'    => $this->mingleData(),
        ];
    }
}