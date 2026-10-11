<?php

namespace App\Livewire\QAQC\ScanXray\Concerns;

use App\Models\MTC\Master\MasterLine;
use App\Models\QAQC\BlindTest\Customer;
use App\Models\QAQC\BlindTest\Model as BlindTestModel;
use App\Models\QAQC\NCP;
use App\Models\QAQC\ScanXray\ScanXray;
use Illuminate\Support\Facades\Storage;

trait HandlesScanXrayForm
{
    // ============ HEADER FIELDS ============
    public $customer_id;
    public $model_id;
    public $shift = '';
    public $group = '';
    public $master_line_id;
    public $lot_qty = 0;

    // ============ DETAIL GROUPS ============
    public $first_piece_items  = [];
    public $middle_piece_items = [];
    public $last_piece_items   = [];

    // ============ SHIFT & GROUP OPTIONS ============
    public array $shiftOptions = ['NS', '1', '2', '3'];
    public array $groupOptions = ['NS', 'A', 'B', 'C'];

    // ============ NCP INLINE PICKER STATE ============
    public $ncpSearches = [
        'first_piece_items'  => '',
        'middle_piece_items' => '',
        'last_piece_items'   => '',
    ];
    public $ncpPages = [
        'first_piece_items'  => 1,
        'middle_piece_items' => 1,
        'last_piece_items'   => 1,
    ];
    public $openNcpPanels = [
        'first_piece_items'  => false,
        'middle_piece_items' => false,
        'last_piece_items'   => false,
    ];

    // ============ MASTER LINE INLINE PICKER STATE ============
    public $masterLineSearch = '';
    public $masterLinePage = 1;
    public $openMasterLinePanel = false;

    // ============ FORM RULES ============

    protected function formRules(): array
    {
        $rules = [
            'customer_id'    => 'required|exists:tb_qaqc_customer,id',
            'model_id'       => 'required|exists:tb_qaqc_model,id',
            'shift'          => 'required|in:NS,1,2,3',
            'group'          => 'required|in:NS,A,B,C',
            'master_line_id' => 'required|exists:tb_mtc_master_lines,id',
            'lot_qty'        => 'required|integer|min:0',
        ];

        foreach (['first_piece_items', 'middle_piece_items', 'last_piece_items'] as $grp) {
            $rules["$grp.status_running"]         = 'nullable|string|max:50';
            $rules["$grp.filling_ratio"]          = 'nullable|numeric|min:0|max:100';
            $rules["$grp.qty_hold"]               = 'nullable|integer|min:0';
            $rules["$grp.status_after_check.ok"]  = 'nullable|integer|min:0';
            $rules["$grp.status_after_check.ng"]  = 'nullable|integer|min:0';
            $rules["$grp.ncp_id"]                 = 'nullable|exists:tb_qaqc_ncp,id';
            $rules["$grp.remarks"]                = 'nullable|string';
            $rules["$grp.pictures"]               = 'nullable|array';

            // Custom rule: skip string path dari DB, validasi file upload baru
            $rules["$grp.pictures.*"] = [
                function ($attribute, $value, $fail) {
                    if (is_string($value)) return;

                    if ($value instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                        $mime = $value->getMimeType();
                        if (!str_starts_with($mime, 'image/')) {
                            $fail('File harus berupa gambar.');
                        }
                        if ($value->getSize() > 5 * 1024 * 1024) {
                            $fail('Ukuran gambar maksimal 5MB.');
                        }
                        return;
                    }

                    $fail('Format file tidak dikenali.');
                },
            ];
        }

        return $rules;
    }

    protected function formMessages(): array
    {
        $messages = [
            'customer_id.required'    => 'Customer is required.',
            'model_id.required'       => 'Model is required.',
            'shift.required'          => 'Shift is required.',
            'shift.in'                => 'Shift harus salah satu dari: NS, 1, 2, 3.',
            'group.required'          => 'Group is required.',
            'group.in'                => 'Group harus salah satu dari: NS, A, B, C.',
            'master_line_id.required' => 'Master Line is required.',
            'lot_qty.required'        => 'Lot Qty is required.',
        ];

        foreach (['first_piece_items', 'middle_piece_items', 'last_piece_items'] as $grp) {
            $messages["$grp.status_running.required"] = 'Status Running wajib diisi.';
        }

        return $messages;
    }

    // ============ INIT ============

    protected function initDetailStructures(): void
    {
        $this->first_piece_items  = ScanXray::defaultItemStructure();
        $this->middle_piece_items = ScanXray::defaultItemStructure();
        $this->last_piece_items   = ScanXray::defaultItemStructure();
    }

    public function updatedCustomerId(): void
    {
        $this->model_id = null;
    }

    // ============ LIVE SYNC LOGIC ============

    public function updated($property, $value): void
    {
        $parts = explode('.', $property);
        if (count($parts) < 2) {
            return;
        }

        $groupKey = $parts[0];
        if (!in_array($groupKey, ['first_piece_items', 'middle_piece_items', 'last_piece_items'], true)) {
            return;
        }

        $field = $parts[1] ?? null;

        // 1) ok_qty / ng_qty berubah → recalculate reject_rate
        if (in_array($field, ['ok_qty', 'ng_qty'], true)) {
            $this->recalcRejectRate($groupKey);
            return;
        }

        // 2) qty_hold berubah → ok = qty_hold, ng = 0
        if ($field === 'qty_hold') {
            $hold = (int) $value;
            $this->{$groupKey}['status_after_check']['ok'] = $hold;
            $this->{$groupKey}['status_after_check']['ng'] = 0;
            return;
        }

        // 3) status_after_check.ok berubah → ng = qty_hold - ok
        if ($field === 'status_after_check' && isset($parts[2]) && $parts[2] === 'ok') {
            $hold = (int) ($this->{$groupKey}['qty_hold'] ?? 0);
            $ok = (int) $value;
            $this->{$groupKey}['status_after_check']['ng'] = max(0, $hold - $ok);
            return;
        }

        // 4) status_after_check.ng berubah → ok = qty_hold - ng
        if ($field === 'status_after_check' && isset($parts[2]) && $parts[2] === 'ng') {
            $hold = (int) ($this->{$groupKey}['qty_hold'] ?? 0);
            $ng = (int) $value;
            $this->{$groupKey}['status_after_check']['ok'] = max(0, $hold - $ng);
            return;
        }

        // 5) pictures_new → pindahkan ke pictures
        if ($field === 'pictures_new') {
            $newFiles = is_array($value) ? $value : [$value];
            if (!isset($this->{$groupKey}['pictures']) || !is_array($this->{$groupKey}['pictures'])) {
                $this->{$groupKey}['pictures'] = [];
            }
            foreach ($newFiles as $file) {
                if ($file) {
                    $this->{$groupKey}['pictures'][] = $file;
                }
            }
            $this->{$groupKey}['pictures_new'] = [];
            return;
        }

        // 6) side_lh / side_rh berubah → recalculate ok_qty + reject_rate
        if (in_array($field, ['side_lh', 'side_rh'], true)) {
            $this->{$groupKey}['ok_qty'] = $this->calculateOkQtyFromRows($this->{$groupKey});
            $this->recalcRejectRate($groupKey);
            return;
        }
    }

    /**
     * Hitung ok_qty = max(row terisi LH, row terisi RH).
     * 1 row LH + 1 row RH dianggap 1 pasang.
     */
    protected function calculateOkQtyFromRows(array $item): int
    {
        $countFilled = function (array $sideData) {
            $maxRows = 0;
            foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                $maxRows = max($maxRows, count($sideData[$col] ?? []));
            }

            $filled = 0;
            for ($i = 0; $i < $maxRows; $i++) {
                foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                    if (!empty($sideData[$col][$i] ?? null)) {
                        $filled++;
                        break;
                    }
                }
            }
            return $filled;
        };

        $lhFilled = $countFilled($item['side_lh'] ?? []);
        $rhFilled = $countFilled($item['side_rh'] ?? []);

        return max($lhFilled, $rhFilled);
    }

    /**
     * Recalculate reject_rate dari ok_qty + ng_qty.
     */
    protected function recalcRejectRate(string $groupKey): void
    {
        $ok = (int) ($this->{$groupKey}['ok_qty'] ?? 0);
        $ng = (int) ($this->{$groupKey}['ng_qty'] ?? 0);
        $total = $ok + $ng;
        $this->{$groupKey}['reject_rate'] = $total > 0 ? round(($ng / $total) * 100, 2) : 0;
    }

    // ============ ROW MANAGEMENT ============

    public function addRow(string $groupKey, string $side): void
    {
        foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
            $this->{$groupKey}[$side][$col][] = '';
        }

        // Recalculate ok_qty
        $this->{$groupKey}['ok_qty'] = $this->calculateOkQtyFromRows($this->{$groupKey});
        $this->recalcRejectRate($groupKey);
    }

    public function removeRow(string $groupKey, string $side, int $index): void
    {
        foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
            if (isset($this->{$groupKey}[$side][$col][$index])) {
                unset($this->{$groupKey}[$side][$col][$index]);
                $this->{$groupKey}[$side][$col] = array_values($this->{$groupKey}[$side][$col]);
            }
        }

        // Recalculate ok_qty
        $this->{$groupKey}['ok_qty'] = $this->calculateOkQtyFromRows($this->{$groupKey});
        $this->recalcRejectRate($groupKey);
    }

    // ============ NCP INLINE PICKER ============

    public function toggleNcpPanel(string $groupKey): void
    {
        $isOpen = $this->openNcpPanels[$groupKey] ?? false;
        $this->openNcpPanels[$groupKey] = !$isOpen;

        if ($this->openNcpPanels[$groupKey]) {
            $this->ncpSearches[$groupKey] = '';
            $this->ncpPages[$groupKey] = 1;
        }
    }

    public function updatedNcpSearches($value, $key): void
    {
        if (isset($this->ncpPages[$key])) {
            $this->ncpPages[$key] = 1;
        }
    }

    public function setNcpPage(string $groupKey, int $page): void
    {
        $this->ncpPages[$groupKey] = $page;
    }

    public function selectNcp(string $groupKey, int $ncpId): void
    {
        if (isset($this->{$groupKey})) {
            $this->{$groupKey}['ncp_id'] = $ncpId;
        }
        $this->openNcpPanels[$groupKey] = false;
        $this->ncpSearches[$groupKey] = '';
        $this->ncpPages[$groupKey] = 1;
    }

    public function clearNcp(string $groupKey): void
    {
        if (isset($this->{$groupKey})) {
            $this->{$groupKey}['ncp_id'] = null;
        }
    }

    public function getNcpListFor(string $groupKey)
    {
        $search = $this->ncpSearches[$groupKey] ?? '';

        $q = NCP::query()->orderByDesc('id');

        if (!empty($search)) {
            $term = '%' . $search . '%';
            $q->where(function ($qq) use ($term) {
                $qq->where('ncp_number', 'like', $term)
                   ->orWhere('part_number', 'like', $term)
                   ->orWhere('part_description', 'like', $term)
                   ->orWhere('customer', 'like', $term)
                   ->orWhere('model_affected', 'like', $term);
            });
        }

        return $q->paginate(5, ['*'], 'ncpPage_' . $groupKey, $this->ncpPages[$groupKey] ?? 1);
    }

    // ============ MASTER LINE INLINE PICKER ============

    public function toggleMasterLinePanel(): void
    {
        $this->openMasterLinePanel = !$this->openMasterLinePanel;

        if ($this->openMasterLinePanel) {
            $this->masterLineSearch = '';
            $this->masterLinePage = 1;
        }
    }

    public function updatedMasterLineSearch(): void
    {
        $this->masterLinePage = 1;
    }

    public function setMasterLinePage(int $page): void
    {
        $this->masterLinePage = $page;
    }

    public function selectMasterLine(int $id): void
    {
        $this->master_line_id = $id;
        $this->openMasterLinePanel = false;
        $this->masterLineSearch = '';
        $this->masterLinePage = 1;
    }

    public function clearMasterLine(): void
    {
        $this->master_line_id = null;
    }

    public function getMasterLineList()
    {
        $search = $this->masterLineSearch ?? '';

        $q = MasterLine::query()
            ->with('location')
            ->join('tb_mtc_master_locations as loc', 'loc.id', '=', 'tb_mtc_master_lines.location_id')
            ->orderBy('loc.location_name', 'asc')
            ->orderBy('tb_mtc_master_lines.line_number', 'asc')
            ->select('tb_mtc_master_lines.*');

        if (!empty($search)) {
            $term = '%' . $search . '%';
            $q->where(function ($qq) use ($term) {
                $qq->where('tb_mtc_master_lines.line_number', 'like', $term)
                   ->orWhere('loc.location_name', 'like', $term);
            });
        }

        return $q->paginate(5, ['*'], 'masterLinePage', $this->masterLinePage ?? 1);
    }

    // ============ FILE UPLOAD HANDLERS ============

    public function removePicture(string $groupKey, int $index): void
    {
        if (isset($this->{$groupKey}['pictures'][$index])) {
            $path = $this->{$groupKey}['pictures'][$index];
            if (is_string($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            unset($this->{$groupKey}['pictures'][$index]);
            $this->{$groupKey}['pictures'] = array_values($this->{$groupKey}['pictures']);
        }
    }

    // ============ BUILD PAYLOAD ============

    protected function buildPayload(array $existingPictures = []): array
    {
        return [
            'customer_id'        => $this->customer_id,
            'model_id'           => $this->model_id,
            'shift'              => $this->shift,
            'group'              => $this->group,
            'master_line_id'     => $this->master_line_id,
            'lot_qty'            => $this->lot_qty,
            'first_piece_items'  => $this->prepareGroupPayload('first_piece_items', $existingPictures),
            'middle_piece_items' => $this->prepareGroupPayload('middle_piece_items', $existingPictures),
            'last_piece_items'   => $this->prepareGroupPayload('last_piece_items', $existingPictures),
        ];
    }

    protected function prepareGroupPayload(string $groupKey, array $existingPictures = []): array
    {
        $item = $this->{$groupKey};

        // Recalculate ok_qty dari row (pastikan konsisten)
        $item['ok_qty'] = $this->calculateOkQtyFromRows($item);

        // Recalculate reject_rate
        $ok = (int) ($item['ok_qty'] ?? 0);
        $ng = (int) ($item['ng_qty'] ?? 0);
        $total = $ok + $ng;
        $item['reject_rate'] = $total > 0 ? round(($ng / $total) * 100, 2) : 0;

        // Set time_scan hanya kalau grup ada isi
        $hasContent = $this->groupHasContent($item);
        $item['time_scan'] = $hasContent ? now()->format('Y-m-d H:i:s') : null;

        // Handle pictures
        $existing = $existingPictures[$groupKey] ?? [];
        $uploaded = [];

        if (isset($item['pictures']) && is_array($item['pictures'])) {
            foreach ($item['pictures'] as $pic) {
                if ($pic instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                    $uploaded[] = $pic->store('scan-xray/pictures', 'public');
                } elseif (is_string($pic)) {
                    $uploaded[] = $pic;
                }
            }
        }

        $item['pictures'] = array_values(array_unique(array_merge($existing, $uploaded)));

        // Sync status_after_check kalau belum konsisten
        $hold = (int) ($item['qty_hold'] ?? 0);
        $okCheck = (int) ($item['status_after_check']['ok'] ?? 0);
        $ngCheck = (int) ($item['status_after_check']['ng'] ?? 0);
        if (($okCheck + $ngCheck) !== $hold && $hold > 0) {
            $item['status_after_check']['ng'] = max(0, $hold - $okCheck);
        }

        // Bersihkan property sementara
        unset($item['pictures_new']);

        return $item;
    }

    protected function groupHasContent(array $item): bool
    {
        if (!empty($item['ok_qty']) || !empty($item['ng_qty'])) return true;

        foreach (['side_lh', 'side_rh'] as $side) {
            foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                $vals = $item[$side][$col] ?? [];
                if (is_array($vals)) {
                    foreach ($vals as $v) {
                        if (!empty($v)) return true;
                    }
                } elseif (!empty($vals)) {
                    return true;
                }
            }
        }

        foreach (['status_running', 'filling_ratio', 'qty_hold', 'ncp_id', 'remarks'] as $field) {
            if (!empty($item[$field])) return true;
        }
        if (!empty($item['pictures']) && is_array($item['pictures'])) return true;
        if (!empty($item['status_after_check']['ok']) || !empty($item['status_after_check']['ng'])) return true;

        return false;
    }

    protected function mergeStructure($data): array
    {
        $default = ScanXray::defaultItemStructure();
        if (!is_array($data)) {
            return $default;
        }

        $merged = array_replace_recursive($default, $data);

        if (!isset($merged['pictures']) || !is_array($merged['pictures'])) {
            $merged['pictures'] = [];
        }

        return $merged;
    }

    protected function getDropdownData(): array
    {
        return [
            'customers'   => Customer::orderBy('customer_name')->get(),
            'models'      => $this->customer_id
                                ? BlindTestModel::where('customer_id', $this->customer_id)
                                    ->orderBy('model_name')->get()
                                : collect(),
        ];
    }
}