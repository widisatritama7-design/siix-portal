<?php

namespace App\Livewire\PROD\Tray;

use App\Models\PROD\Tray\MasterLocator;
use App\Models\PROD\Tray\MasterRack;
use App\Models\PROD\Tray\MasterTray;
use App\Models\QAQC\BlindTest\Customer;
use Ijpatricio\Mingle\Concerns\InteractsWithMingles;
use Ijpatricio\Mingle\Contracts\HasMingles;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Master Tray')]
class MasterTrayManagement extends Component implements HasMingles
{
    use InteractsWithMingles;

    public int $perPage = 10;
    public int $page = 1;
    public string $search = '';

    public function mount(): void
    {
        if (!auth()->check() || !auth()->user()->can('view master tray')) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function component(): string
    {
        return 'resources/js/mingle/Prod/Tray/MasterTray/index.js';
    }

    public function mingleData(): array
    {
        $permissions = [
            'canCreate' => auth()->user()->can('create master tray'),
            'canEdit'   => auth()->user()->can('edit master tray'),
            'canDelete' => auth()->user()->can('delete master tray'),
        ];

        $query = MasterTray::query()
            ->with([
                'rack:id,rack_number',
                'locator:id,locator_number,master_rack_id',
                'customer:id,customer_name',
                'creator:id,name',
            ])
            // ⬇ Tambah 2 baris ini untuk menghitung total IN & OUT
            ->withSum('transactions as total_in', 'qty_in')
            ->withSum('transactions as total_out', 'qty_out');

        // Server-side search (biarkan seperti sebelumnya)
        if ($this->search !== '') {
            $search = strtolower($this->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(part_number_tray) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(item_code_sap) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(`desc`) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(model) LIKE ?', ["%{$search}%"])
                  ->orWhereHas('rack', fn($r) => $r->whereRaw('LOWER(rack_number) LIKE ?', ["%{$search}%"]))
                  ->orWhereHas('locator', fn($l) => $l->whereRaw('LOWER(locator_number) LIKE ?', ["%{$search}%"]))
                  ->orWhereHas('customer', fn($c) => $c->whereRaw('LOWER(customer_name) LIKE ?', ["%{$search}%"]));
            });
        }

        $paginator = $query->orderByDesc('id')->paginate($this->perPage, ['*'], 'page', $this->page);

        return [
            'rows' => collect($paginator->items())
                ->map(fn (MasterTray $r) => [
                    'id'                => $r->id,
                    'master_rack_id'    => $r->master_rack_id,
                    'master_locator_id' => $r->master_locator_id,
                    'customer_id'       => $r->customer_id,
                    'rack_number'       => $r->rack?->rack_number,
                    'locator_number'    => $r->locator?->locator_number,
                    'customer_name'     => $r->customer?->customer_name,
                    'part_number_tray'  => $r->part_number_tray,
                    'item_code_sap'     => $r->item_code_sap,
                    'desc'              => $r->desc,
                    'model'             => $r->model,
                    'cav_tray'          => $r->cav_tray,
                    'created_by_name'   => $r->creator?->name ?? '-',
                    'created_at'        => optional($r->created_at)->format('d/m/Y H:i'),
                    
                    // ⬇ Tambah baris ini
                    'current_stock'     => ($r->total_in ?? 0) - ($r->total_out ?? 0),
                ])
                ->toArray(),

            'racks' => MasterRack::query()
                ->select('id', 'rack_number')
                ->orderBy('rack_number')
                ->get()
                ->toArray(),

            'locators' => MasterLocator::query()
                ->select('id', 'master_rack_id', 'locator_number')
                ->orderBy('locator_number')
                ->get()
                ->toArray(),

            'customers' => Customer::query()
                ->select('id', 'customer_name')
                ->orderBy('customer_name')
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

    public function getTrayHistory(int $trayId): array
    {
        $transactions = \App\Models\PROD\Tray\Transaction::query()
            ->where('master_tray_id', $trayId)
            ->with('creator:id,name')
            ->orderByDesc('created_at')
            ->get();

        return [
            'success' => true,
            'rows' => $transactions->map(fn ($t) => [
                'id'               => $t->id,
                'transaction_type' => $t->transaction_type,
                'qty_in'           => $t->qty_in,
                'qty_out'          => $t->qty_out,
                'reason'           => $t->reason,
                'created_by_name'  => $t->creator?->name ?? '-',
                'created_at'       => optional($t->created_at)->format('d/m/Y H:i'),
            ])->toArray(),
        ];
    }

    public function setSearch(string $search): array
    {
        $this->search = $search;
        $this->page = 1;
        return $this->mingleData();
    }

    public function gotoPage(int $page): array
    {
        $query = MasterTray::query();

        if ($this->search !== '') {
            $search = strtolower($this->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(part_number_tray) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(item_code_sap) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(`desc`) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(model) LIKE ?', ["%{$search}%"])
                  ->orWhereHas('rack', fn($r) => $r->whereRaw('LOWER(rack_number) LIKE ?', ["%{$search}%"]))
                  ->orWhereHas('locator', fn($l) => $l->whereRaw('LOWER(locator_number) LIKE ?', ["%{$search}%"]))
                  ->orWhereHas('customer', fn($c) => $c->whereRaw('LOWER(customer_name) LIKE ?', ["%{$search}%"]));
            });
        }

        $lastPage = max(1, (int) ceil($query->count() / $this->perPage));
        $this->page = min(max(1, $page), $lastPage);
        return $this->mingleData();
    }

    public function save(array $payload): array
    {
        $isUpdate = !empty($payload['id']);

        if (!$isUpdate && !auth()->user()->can('create master tray')) {
            return ['success' => false, 'message' => 'You do not have permission to create!'];
        }
        if ($isUpdate && !auth()->user()->can('edit master tray')) {
            return ['success' => false, 'message' => 'You do not have permission to edit!'];
        }

        $rackId     = $payload['master_rack_id'] ?? null;
        $locatorId  = $payload['master_locator_id'] ?? null;
        $customerId = $payload['customer_id'] ?? null;

        $partNumber = trim((string) ($payload['part_number_tray'] ?? ''));
        $itemCode   = trim((string) ($payload['item_code_sap'] ?? ''));
        $desc       = trim((string) ($payload['desc'] ?? ''));
        $model      = trim((string) ($payload['model'] ?? ''));
        $cavRaw     = $payload['cav_tray'] ?? null;

        if (!$rackId) {
            return ['success' => false, 'message' => 'Rack is required'];
        }
        if ($partNumber === '') {
            return ['success' => false, 'message' => 'Part number is required'];
        }
        if (!MasterRack::whereKey($rackId)->exists()) {
            return ['success' => false, 'message' => 'Rack not found'];
        }

        if ($locatorId) {
            $locator = MasterLocator::find($locatorId);
            if (!$locator) {
                return ['success' => false, 'message' => 'Locator not found'];
            }
            if ((int) $locator->master_rack_id !== (int) $rackId) {
                return ['success' => false, 'message' => 'Selected locator does not belong to the selected rack'];
            }
        }

        if ($customerId && !Customer::whereKey($customerId)->exists()) {
            return ['success' => false, 'message' => 'Customer not found'];
        }

        $cavTray = null;
        if ($cavRaw !== null && $cavRaw !== '') {
            if (!is_numeric($cavRaw) || (int) $cavRaw < 0) {
                return ['success' => false, 'message' => 'Cavity must be a non-negative number'];
            }
            $cavTray = (int) $cavRaw;
        }

        $data = [
            'master_rack_id'    => (int) $rackId,
            'master_locator_id' => $locatorId ?: null,
            'customer_id'       => $customerId ?: null,
            'part_number_tray'  => $partNumber,
            'item_code_sap'     => $itemCode !== '' ? $itemCode : null,
            'desc'              => $desc !== '' ? $desc : null,
            'model'             => $model !== '' ? $model : null,
            'cav_tray'          => $cavTray,
            'updated_by'        => auth()->id(),
        ];

        if ($isUpdate) {
            $row = MasterTray::find($payload['id']);
            if (!$row) {
                return ['success' => false, 'message' => 'Data not found'];
            }
            $row->update($data);
            $message = 'Tray updated successfully';
        } else {
            $data['created_by'] = auth()->id();
            MasterTray::create($data);
            $message = 'Tray added successfully';
        }

        return [
            'success' => true,
            'message' => $message,
            'data'    => $this->mingleData(),
        ];
    }

    public function deleteRow(int $id): array
    {
        if (!auth()->user()->can('delete master tray')) {
            return ['success' => false, 'message' => 'You do not have permission to delete!'];
        }

        $row = MasterTray::find($id);
        if (!$row) {
            return ['success' => false, 'message' => 'Data not found'];
        }

        $name = $row->part_number_tray;
        $row->delete();

        return [
            'success' => true,
            'message' => "Tray '{$name}' deleted successfully",
            'data'    => $this->mingleData(),
        ];
    }
}