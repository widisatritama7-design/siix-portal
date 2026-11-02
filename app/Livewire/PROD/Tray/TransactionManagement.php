<?php

namespace App\Livewire\PROD\Tray;

use App\Models\PROD\Tray\MasterTray;
use App\Models\PROD\Tray\Transaction;
use Ijpatricio\Mingle\Concerns\InteractsWithMingles;
use Ijpatricio\Mingle\Contracts\HasMingles;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Tray Transaction')]
class TransactionManagement extends Component implements HasMingles
{
    use InteractsWithMingles;

    public int $perPage = 10;
    public int $page = 1;

    // State untuk Filter
    public string $filterType = '';
    public string $dateFrom = '';
    public string $dateUntil = '';

    public function mount(): void
    {
        if (!auth()->check() || !auth()->user()->can('view tray transaction')) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function component(): string
    {
        return 'resources/js/mingle/Prod/Tray/Transaction/index.js';
    }

    public function mingleData(): array
    {
        $permissions = [
            'canCreate' => auth()->user()->can('create tray transaction'),
            'canEdit'   => auth()->user()->can('edit tray transaction'),
            'canDelete' => auth()->user()->can('delete tray transaction'),
        ];

        $query = Transaction::query()
            ->with([
                'tray:id,part_number_tray,item_code_sap,desc,model,master_rack_id,master_locator_id',
                'tray.rack:id,rack_number',
                'tray.locator:id,locator_number',
                'creator:id,name',
            ]);

        // Filter Type
        if ($this->filterType) {
            $query->where('transaction_type', $this->filterType);
        }

        // Filter Date From
        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        // Filter Date Until
        if ($this->dateUntil) {
            $query->whereDate('created_at', '<=', $this->dateUntil);
        }

        $paginator = $query->orderByDesc('id')
            ->paginate($this->perPage, ['*'], 'page', $this->page);

        return [
            'rows' => collect($paginator->items())
                ->map(fn (Transaction $t) => [
                    'id'               => $t->id,
                    'master_tray_id'   => $t->master_tray_id,
                    'part_number_tray' => $t->tray?->part_number_tray,
                    'item_code_sap'    => $t->tray?->item_code_sap,
                    'desc'             => $t->tray?->desc,
                    'model'            => $t->tray?->model,
                    'rack_number'      => $t->tray?->rack?->rack_number,
                    'locator_number'   => $t->tray?->locator?->locator_number,
                    'transaction_type' => $t->transaction_type,
                    'qty_in'           => $t->qty_in,
                    'qty_out'          => $t->qty_out,
                    'reason'           => $t->reason,
                    'created_by_name'  => $t->creator?->name ?? '-',
                    'created_at'       => optional($t->created_at)->format('d/m/Y H:i'),
                    'can_delete'       => now()->diffInHours($t->created_at) <= 24, // ⬅ Cek batas 24 jam
                ])
                ->toArray(),

            'trays' => MasterTray::query()
                ->select('id', 'part_number_tray', 'master_rack_id', 'master_locator_id')
                ->with(['rack:id,rack_number', 'locator:id,locator_number'])
                ->orderBy('part_number_tray')
                ->get()
                ->map(fn ($t) => [
                    'id'               => $t->id,
                    'part_number_tray' => $t->part_number_tray,
                    'rack_number'      => $t->rack?->rack_number,
                    'locator_number'   => $t->locator?->locator_number,
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

            'permissions' => $permissions,
            'filters'     => [
                'type'      => $this->filterType,
                'date_from' => $this->dateFrom,
                'date_until'=> $this->dateUntil,
            ],
        ];
    }

    public function applyFilter(array $payload): array
    {
        $this->filterType = $payload['type'] ?? '';
        $this->dateFrom   = $payload['date_from'] ?? '';
        $this->dateUntil  = $payload['date_until'] ?? '';
        $this->page       = 1;

        return $this->mingleData();
    }

    public function resetFilter(): array
    {
        $this->filterType = '';
        $this->dateFrom   = '';
        $this->dateUntil  = '';
        $this->page       = 1;

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

        if (!$isUpdate && !auth()->user()->can('create tray transaction')) {
            return ['success' => false, 'message' => 'You do not have permission to create!'];
        }
        if ($isUpdate && !auth()->user()->can('edit tray transaction')) {
            return ['success' => false, 'message' => 'You do not have permission to edit!'];
        }

        $trayId = $payload['master_tray_id'] ?? null;
        $type   = strtolower(trim((string) ($payload['transaction_type'] ?? '')));
        $reason = trim((string) ($payload['reason'] ?? ''));
        $qtyIn  = $payload['qty_in'] ?? null;
        $qtyOut = $payload['qty_out'] ?? null;

        if (!$trayId) {
            return ['success' => false, 'message' => 'Tray is required'];
        }
        if (!in_array($type, ['in', 'out'], true)) {
            return ['success' => false, 'message' => 'Transaction type must be IN or OUT'];
        }
        if (!MasterTray::whereKey($trayId)->exists()) {
            return ['success' => false, 'message' => 'Tray not found'];
        }

        if ($type === 'in') {
            if (!is_numeric($qtyIn) || (int) $qtyIn <= 0) {
                return ['success' => false, 'message' => 'Qty IN must be greater than 0'];
            }
            $qtyIn  = (int) $qtyIn;
            $qtyOut = null;
        } else {
            if (!is_numeric($qtyOut) || (int) $qtyOut <= 0) {
                return ['success' => false, 'message' => 'Qty OUT must be greater than 0'];
            }
            $qtyOut = (int) $qtyOut;
            $qtyIn  = null;
        }

        $data = [
            'master_tray_id'   => (int) $trayId,
            'transaction_type' => $type,
            'qty_in'           => $qtyIn,
            'qty_out'          => $qtyOut,
            'reason'           => $reason !== '' ? $reason : null,
            'updated_by'       => auth()->id(),
        ];

        if ($isUpdate) {
            $row = Transaction::find($payload['id']);
            if (!$row) {
                return ['success' => false, 'message' => 'Data not found'];
            }
            $row->update($data);
            $message = 'Transaction updated successfully';
        } else {
            $data['created_by'] = auth()->id();
            Transaction::create($data);
            $message = 'Transaction added successfully';
        }

        return [
            'success' => true,
            'message' => $message,
            'data'    => $this->mingleData(),
        ];
    }

    public function findTraysByLocator(string $locatorNumber): array
    {
        $locatorNumber = trim($locatorNumber);

        if ($locatorNumber === '') {
            return ['success' => false, 'message' => 'Locator number is required'];
        }

        $locator = \App\Models\PROD\Tray\MasterLocator::query()
            ->whereRaw('LOWER(locator_number) = ?', [strtolower($locatorNumber)])
            ->with(['rack:id,rack_number'])
            ->first();

        if (!$locator) {
            return ['success' => false, 'message' => "Locator '{$locatorNumber}' not found"];
        }

        $trays = \App\Models\PROD\Tray\MasterTray::query()
            ->where('master_locator_id', $locator->id)
            ->with(['rack:id,rack_number', 'locator:id,locator_number', 'customer:id,customer_name'])
            ->orderBy('part_number_tray')
            ->get();

        if ($trays->isEmpty()) {
            return ['success' => false, 'message' => "No tray assigned to locator '{$locatorNumber}'"];
        }

        return [
            'success'  => true,
            'message'  => 'Locator found',
            'locator'  => [
                'id'             => $locator->id,
                'locator_number' => $locator->locator_number,
                'rack_number'    => $locator->rack?->rack_number,
            ],
            'trays' => $trays->map(fn ($t) => [
                'id'               => $t->id,
                'part_number_tray' => $t->part_number_tray,
                'item_code_sap'    => $t->item_code_sap,
                'desc'             => $t->desc,
                'model'            => $t->model,
                'cav_tray'         => $t->cav_tray,
                'rack_number'      => $t->rack?->rack_number,
                'locator_number'   => $t->locator?->locator_number,
                'customer_name'    => $t->customer?->customer_name,
            ])->toArray(),
        ];
    }

    public function deleteRow(int $id, string $reason = ''): array
    {
        if (!auth()->user()->can('delete tray transaction')) {
            return ['success' => false, 'message' => 'You do not have permission to delete!'];
        }

        $reason = trim($reason);
        if ($reason === '') {
            return ['success' => false, 'message' => 'Reason is required to delete!'];
        }

        $row = Transaction::find($id);
        if (!$row) {
            return ['success' => false, 'message' => 'Data not found'];
        }

        // Cek batas 24 jam
        if ($row->created_at->diffInHours(now()) > 24) {
            return ['success' => false, 'message' => 'Cannot delete transaction older than 24 hours!'];
        }

        // Simpan alasan hapus & lakukan soft delete
        $row->delete_reason = $reason;
        $row->save();
        $row->delete(); 

        return [
            'success' => true,
            'message' => 'Transaction deleted successfully',
            'data'    => $this->mingleData(),
        ];
    }
}