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
    public $pcb_type = '';
    public $phase = 'first';
    public $shift = '';
    public $group = '';
    public $master_line_id;
    public $lot_qty = 0;

    // ============ DETAIL GROUPS ============
    public $first_piece_items  = [];
    public $middle_piece_items = [];
    public $last_piece_items   = [];

    // ============ SECOND PIECE ============
    public $second_first_items  = [];
    public $second_middle_items = [];
    public $second_last_items   = [];

    public $pic_xray = '';

    // ============ JUDGEMENTS (PER CELL / PCB x ROW) ============
    public $judgements = [
        'first_piece_items'  => [
            'side_single' => ['pcb_a' => [], 'pcb_b' => [], 'pcb_c' => [], 'pcb_circuit' => []],
            'side_lh'     => ['pcb_a' => [], 'pcb_b' => [], 'pcb_c' => [], 'pcb_circuit' => []],
            'side_rh'     => ['pcb_a' => [], 'pcb_b' => [], 'pcb_c' => [], 'pcb_circuit' => []],
        ],
        'middle_piece_items' => [
            'side_single' => ['pcb_a' => [], 'pcb_b' => [], 'pcb_c' => [], 'pcb_circuit' => []],
            'side_lh'     => ['pcb_a' => [], 'pcb_b' => [], 'pcb_c' => [], 'pcb_circuit' => []],
            'side_rh'     => ['pcb_a' => [], 'pcb_b' => [], 'pcb_c' => [], 'pcb_circuit' => []],
        ],
        'last_piece_items'   => [
            'side_single' => ['pcb_a' => [], 'pcb_b' => [], 'pcb_c' => [], 'pcb_circuit' => []],
            'side_lh'     => ['pcb_a' => [], 'pcb_b' => [], 'pcb_c' => [], 'pcb_circuit' => []],
            'side_rh'     => ['pcb_a' => [], 'pcb_b' => [], 'pcb_c' => [], 'pcb_circuit' => []],
        ],
    ];

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

    // ============ COLLAPSE STATE PER GROUP ============
    public array $openGroups = [
        'first_piece_items'   => true,
        'second_first_items'  => false,
        'middle_piece_items'  => false,
        'second_middle_items' => false,
        'last_piece_items'    => false,
        'second_last_items'   => false,
    ];

    public $validationErrors = [];

    // ============ FORM RULES ============
    protected function formRules(): array
    {
        $rules = [
            'customer_id'    => 'required|exists:tb_qaqc_customer,id',
            'model_id'       => 'required|exists:tb_qaqc_model,id',
            'pcb_type'       => 'required|in:SINGLE,LH,RH',
            'shift'          => 'required|in:NS,1,2,3',
            'group'          => 'required|in:NS,A,B,C',
            'master_line_id' => 'required|exists:tb_mtc_master_lines,id',
            'lot_qty'        => 'required|integer|min:0',
            'pic_xray'       => 'required|integer',
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

            $rules["$grp.pictures.*"] = [
                function ($attribute, $value, $fail) {
                    if (is_string($value)) return;
                    if ($value instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                        $mime = $value->getMimeType();
                        if (!str_starts_with($mime, 'image/')) $fail('File harus berupa gambar.');
                        if ($value->getSize() > 5 * 1024 * 1024) $fail('Ukuran gambar maksimal 5MB.');
                        return;
                    }
                    $fail('Format file tidak dikenali.');
                },
            ];
        }

        foreach (['second_first_items', 'second_middle_items', 'second_last_items'] as $grp) {
            $rules["$grp.status_running"] = 'nullable|string|max:50';
        }

        return $rules;
    }

    protected function formMessages(): array
    {
        $messages = [
            'customer_id.required'    => 'Customer is required.',
            'model_id.required'       => 'Model is required.',
            'pcb_type.required'       => 'PCB Type wajib dipilih.',
            'shift.required'          => 'Shift is required.',
            'shift.in'                => 'Shift harus salah satu dari: NS, 1, 2, 3.',
            'group.required'          => 'Group is required.',
            'group.in'                => 'Group harus salah satu dari: NS, A, B, C.',
            'master_line_id.required' => 'Master Line is required.',
            'lot_qty.required'        => 'Lot Qty is required.',
            'pic_xray.required'       => 'PIC X-Ray wajib diisi.',
        ];

        foreach (['first_piece_items', 'middle_piece_items', 'last_piece_items'] as $grp) {
            $messages["$grp.status_running.required"] = 'Status Running wajib diisi.';
        }

        return $messages;
    }

    // ============ INIT ============
    protected function initDetailStructures(): void
    {
        $this->first_piece_items  = $this->buildDefaultRows('first_piece_items');
        $this->middle_piece_items = $this->buildDefaultRows('middle_piece_items');
        $this->last_piece_items   = $this->buildDefaultRows('last_piece_items');

        $this->second_first_items  = $this->buildDefaultSecondRows('second_first_items');
        $this->second_middle_items = $this->buildDefaultSecondRows('second_middle_items');
        $this->second_last_items   = $this->buildDefaultSecondRows('second_last_items');

        $this->initJudgements();
        $this->syncOpenGroupsWithPhase();
    }

    protected function buildDefaultRows(string $groupKey): array
    {
        $item    = ScanXray::defaultItemStructure();
        $stdRows = ScanXray::standardRows($groupKey);

        foreach (['side_single', 'side_lh', 'side_rh'] as $side) {
            foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                $item[$side][$col] = array_fill(0, $stdRows, '');
            }
        }

        return $item;
    }

    protected function buildDefaultSecondRows(string $groupKey): array
    {
        $item    = ScanXray::defaultSecondPieceStructure();
        $stdRows = ScanXray::standardRows($groupKey);

        foreach (['side_single', 'side_lh', 'side_rh'] as $side) {
            foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                $item[$side][$col] = array_fill(0, $stdRows, '');
            }
        }

        return $item;
    }

    protected function initJudgements(): void
    {
        foreach (['first_piece_items', 'middle_piece_items', 'last_piece_items'] as $groupKey) {
            $stdRows = ScanXray::standardRows($groupKey);
            foreach (['side_single', 'side_lh', 'side_rh'] as $side) {
                foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                    $this->judgements[$groupKey][$side][$col] = array_fill(0, $stdRows, null);
                }
            }
        }
    }

    // ============ PHASE HELPERS ============
    protected function phaseOrder(): array
    {
        return [
            'first'         => 1,
            'second_first'  => 2,
            'middle'        => 3,
            'second_middle' => 4,
            'last'          => 5,
            'second_last'   => 6,
            'completed'     => 7,
        ];
    }

    protected function groupToPhase(string $groupKey): ?string
    {
        return match ($groupKey) {
            'first_piece_items'   => 'first',
            'second_first_items'  => 'second_first',
            'middle_piece_items'  => 'middle',
            'second_middle_items' => 'second_middle',
            'last_piece_items'    => 'last',
            'second_last_items'   => 'second_last',
            default               => null,
        };
    }

    public function canEditGroup(string $groupKey): bool
    {
        return match ($this->phase) {
            'first'         => $groupKey === 'first_piece_items',
            'second_first'  => $groupKey === 'second_first_items',
            'middle'        => $groupKey === 'middle_piece_items',
            'second_middle' => $groupKey === 'second_middle_items',
            'last'          => $groupKey === 'last_piece_items',
            'second_last'   => $groupKey === 'second_last_items',
            'completed'     => false,
            default         => false,
        };
    }

    public function isGroupLocked(string $groupKey): bool
    {
        $order       = $this->phaseOrder();
        $groupPhase  = $this->groupToPhase($groupKey);
        if (!$groupPhase) return true;

        $currentOrder = $order[$this->phase] ?? 99;
        return $order[$groupPhase] > $currentOrder;
    }

    public function isGroupCompleted(string $groupKey): bool
    {
        $order       = $this->phaseOrder();
        $groupPhase  = $this->groupToPhase($groupKey);
        if (!$groupPhase) return false;

        $currentOrder = $order[$this->phase] ?? 99;
        return $order[$groupPhase] < $currentOrder;
    }

    // ============ COLLAPSE HELPERS ============
    /**
     * Set grup mana yang terbuka berdasarkan phase saat ini.
     * Grup aktif → open, sisanya → closed.
     */
    public function syncOpenGroupsWithPhase(): void
    {
        $activeGroup = match ($this->phase) {
            'first'         => 'first_piece_items',
            'second_first'  => 'second_first_items',
            'middle'        => 'middle_piece_items',
            'second_middle' => 'second_middle_items',
            'last'          => 'last_piece_items',
            'second_last'   => 'second_last_items',
            default         => null,
        };

        foreach (array_keys($this->openGroups) as $groupKey) {
            $this->openGroups[$groupKey] = ($groupKey === $activeGroup);
        }
    }

    /**
     * Toggle manual oleh user.
     */
    public function toggleGroup(string $groupKey): void
    {
        if (!array_key_exists($groupKey, $this->openGroups)) return;

        // Grup yang belum waktunya (locked) tidak boleh dibuka
        if (!$this->canOpenGroup($groupKey)) return;

        $this->openGroups[$groupKey] = !$this->openGroups[$groupKey];
    }

    /**
     * Cek apakah grup boleh dibuka.
     */
    public function canOpenGroup(string $groupKey): bool
    {
        return $this->isGroupCompleted($groupKey) || $this->canEditGroup($groupKey);
    }

    // ============ UPDATED HOOKS ============
    public function updatedCustomerId(): void
    {
        $this->model_id = null;
        $this->pcb_type = '';
        $this->normalizeSidesForPcbType();
    }

    public function updatedModelId(): void
    {
        if (!$this->model_id) {
            $this->pcb_type = '';
            $this->normalizeSidesForPcbType();
            return;
        }

        $model   = BlindTestModel::find($this->model_id);
        $options = $model->pcb_type ?? [];

        if (count($options) === 1) {
            $this->pcb_type = $options[0];
        } else {
            $this->pcb_type = '';
        }

        $this->normalizeSidesForPcbType();
    }

    public function updatedPcbType($value): void
    {
        if (!in_array($value, ['SINGLE', 'LH', 'RH'], true)) {
            $this->pcb_type = '';
            $this->normalizeSidesForPcbType();
            return;
        }

        $options = $this->getPcbTypeOptionsProperty();
        if (!empty($options) && !in_array($this->pcb_type, $options, true)) {
            $this->pcb_type = '';
        }

        $this->normalizeSidesForPcbType();
    }

    protected function normalizeSidesForPcbType(): void
    {
        $allGroups = [
            'first_piece_items', 'middle_piece_items', 'last_piece_items',
            'second_first_items', 'second_middle_items', 'second_last_items',
        ];

        foreach ($allGroups as $groupKey) {
            $stdRows = ScanXray::standardRows($groupKey);

            foreach (['side_single', 'side_lh', 'side_rh'] as $side) {
                if ($this->isSideActive($side)) continue;

                foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                    $this->{$groupKey}[$side][$col] = array_fill(0, $stdRows, '');

                    if (in_array($groupKey, ['first_piece_items', 'middle_piece_items', 'last_piece_items'], true)) {
                        $this->judgements[$groupKey][$side][$col] = array_fill(0, $stdRows, null);
                    }
                }
            }
        }
    }

    public function getPcbTypeOptionsProperty(): array
    {
        if (!$this->model_id) return [];
        $model   = BlindTestModel::find($this->model_id);
        $options = $model->pcb_type ?? [];
        $order   = ['SINGLE', 'LH', 'RH'];
        return array_values(array_intersect($order, $options));
    }

    public function isSideActive(string $side): bool
    {
        return match ($side) {
            'side_single' => $this->pcb_type === 'SINGLE',
            'side_lh'     => $this->pcb_type === 'LH',
            'side_rh'     => $this->pcb_type === 'RH',
            default       => false,
        };
    }

    public function activeSide(): ?string
    {
        return match ($this->pcb_type) {
            'SINGLE' => 'side_single',
            'LH'     => 'side_lh',
            'RH'     => 'side_rh',
            default  => null,
        };
    }

    // ============ LIVE SYNC ============
    public function updated($property, $value): void
    {
        $parts = explode('.', $property);
        if (count($parts) < 2) return;

        $groupKey = $parts[0];
        $allGroups = [
            'first_piece_items', 'middle_piece_items', 'last_piece_items',
            'second_first_items', 'second_middle_items', 'second_last_items',
        ];
        if (!in_array($groupKey, $allGroups, true)) return;

        $field = $parts[1] ?? null;

        // ============ DETEKSI PERUBAHAN CELL PCB ============
        if (in_array($field, ['side_single', 'side_lh', 'side_rh'], true)) {
            if (in_array($groupKey, ['first_piece_items', 'middle_piece_items', 'last_piece_items'], true)) {
                $this->recalcQtyFromJudgements($groupKey);
            }
            return;
        }

        if ($field === 'qty_hold') {
            $hold = (int) $value;
            $this->{$groupKey}['status_after_check']['ok'] = $hold;
            $this->{$groupKey}['status_after_check']['ng'] = 0;
            return;
        }

        if ($field === 'status_after_check' && isset($parts[2]) && $parts[2] === 'ok') {
            $hold = (int) ($this->{$groupKey}['qty_hold'] ?? 0);
            $ok   = (int) $value;
            $this->{$groupKey}['status_after_check']['ng'] = max(0, $hold - $ok);
            return;
        }

        if ($field === 'status_after_check' && isset($parts[2]) && $parts[2] === 'ng') {
            $hold = (int) ($this->{$groupKey}['qty_hold'] ?? 0);
            $ng   = (int) $value;
            $this->{$groupKey}['status_after_check']['ok'] = max(0, $hold - $ng);
            return;
        }

        if ($field === 'pictures_new') {
            $newFiles = is_array($value) ? $value : [$value];
            if (!isset($this->{$groupKey}['pictures']) || !is_array($this->{$groupKey}['pictures'])) {
                $this->{$groupKey}['pictures'] = [];
            }
            foreach ($newFiles as $file) {
                if ($file) $this->{$groupKey}['pictures'][] = $file;
            }
            $this->{$groupKey}['pictures_new'] = [];
            return;
        }
    }

    // ============ JUDGEMENT (PER CELL - NG ONLY) ============
    public function toggleNg(string $groupKey, string $side, string $col, int $row): void
    {
        if (!in_array($col, ['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'], true)) return;
        if (!in_array($groupKey, ['first_piece_items', 'middle_piece_items', 'last_piece_items'], true)) return;

        $cellValue = $this->{$groupKey}[$side][$col][$row] ?? '';
        if (empty($cellValue)) return;

        $current = $this->judgements[$groupKey][$side][$col][$row] ?? null;
        $this->judgements[$groupKey][$side][$col][$row] = ($current === 'ng') ? null : 'ng';

        $this->recalcQtyFromJudgements($groupKey);
    }

    protected function recalcQtyFromJudgements(string $groupKey): void
    {
        $side = $this->activeSide();
        if (!$side) {
            $this->{$groupKey}['ok_qty'] = 0;
            $this->{$groupKey}['ng_qty'] = 0;
            $this->{$groupKey}['reject_rate'] = 0;
            return;
        }

        $sideData = $this->{$groupKey}[$side] ?? [];
        $pcbCols  = ['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'];

        $maxRows = 0;
        foreach ($pcbCols as $col) {
            $maxRows = max($maxRows, count($sideData[$col] ?? []));
        }

        $ok = 0;
        $ng = 0;

        for ($i = 0; $i < $maxRows; $i++) {
            $hasAnyValue = false;
            $hasNg       = false;

            foreach ($pcbCols as $col) {
                $val   = $sideData[$col][$i] ?? null;
                $judge = $this->judgements[$groupKey][$side][$col][$i] ?? null;

                if (empty($val)) continue;

                $hasAnyValue = true;
                if ($judge === 'ng') {
                    $hasNg = true;
                }
            }

            if (!$hasAnyValue) continue;

            if ($hasNg) $ng++;
            else        $ok++;
        }

        $this->{$groupKey}['ok_qty'] = $ok;
        $this->{$groupKey}['ng_qty'] = $ng;
        $this->recalcRejectRate($groupKey);
    }

    // ============ VALIDASI ============
    protected function validateGroupRows($validator = null): void
    {
        if (empty($this->pcb_type)) {
            $this->addError('pcb_type', 'PCB Type wajib dipilih.');
        } else {
            $options = $this->getPcbTypeOptionsProperty();
            if (!empty($options) && !in_array($this->pcb_type, $options, true)) {
                $this->addError('pcb_type', 'PCB Type tidak sesuai dengan Model yang dipilih.');
            }
        }

        foreach (['first_piece_items', 'middle_piece_items', 'last_piece_items'] as $grp) {
            if (!$this->canEditGroup($grp)) continue;

            $item    = $this->{$grp} ?? [];
            $minRows = ScanXray::standardRows($grp);
            $activeSide = $this->activeSide();

            foreach (['side_single', 'side_lh', 'side_rh'] as $side) {
                if (!$this->isSideActive($side)) continue;
                foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                    $count = count($item[$side][$col] ?? []);
                    if ($count < $minRows) {
                        $this->addError("{$grp}_{$side}_{$col}", "Minimal {$minRows} baris untuk kolom ini.");
                    }
                }
            }

            if ($activeSide && isset($item[$activeSide])) {
                $sideData = $item[$activeSide];

                foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                    $colValues = $sideData[$col] ?? [];
                    $colJudges = $this->judgements[$grp][$activeSide][$col] ?? [];

                    for ($i = 0; $i < count($colValues); $i++) {
                        $val   = $colValues[$i] ?? '';
                        $judge = $colJudges[$i] ?? null;

                        if (empty($val) && $judge === 'ng') {
                            $this->addError(
                                "{$grp}_{$col}_value_{$i}",
                                "Row " . ($i + 1) . " — " . strtoupper(str_replace('_', ' ', $col)) . ": isi PCB dulu sebelum ceklis NG."
                            );
                        }
                    }
                }

                $maxRows = 0;
                foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                    $maxRows = max($maxRows, count($sideData[$col] ?? []));
                }
                for ($i = 0; $i < $maxRows; $i++) {
                    $hasAny = false;
                    foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                        if (!empty($sideData[$col][$i] ?? null)) { $hasAny = true; break; }
                    }
                    if (!$hasAny) {
                        $this->addError(
                            "{$grp}_row_{$i}",
                            "Row " . ($i + 1) . ": minimal salah satu dari PCB A / B / C / Circuit wajib diisi."
                        );
                    }
                }
            }

            if ($this->groupHasContent($item) && empty($item['status_running'])) {
                $this->addError("{$grp}.status_running", 'Status Running wajib diisi.');
            }
        }

        $secondGroupMap = [
            'second_first'  => 'second_first_items',
            'second_middle' => 'second_middle_items',
            'second_last'   => 'second_last_items',
        ];

        if (isset($secondGroupMap[$this->phase])) {
            $secondGrp = $secondGroupMap[$this->phase];
            $item      = $this->{$secondGrp} ?? [];
            $minRows   = ScanXray::standardRows($secondGrp);
            $activeSide = $this->activeSide();

            if ($activeSide) {
                foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                    $count = count($item[$activeSide][$col] ?? []);
                    if ($count < $minRows) {
                        $this->addError("{$secondGrp}_{$activeSide}_{$col}", "Minimal {$minRows} baris untuk kolom ini.");
                    }
                }

                $sideData = $item[$activeSide] ?? [];
                $maxRows  = 0;
                foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                    $maxRows = max($maxRows, count($sideData[$col] ?? []));
                }
                for ($i = 0; $i < $maxRows; $i++) {
                    $hasAny = false;
                    foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                        if (!empty($sideData[$col][$i] ?? null)) { $hasAny = true; break; }
                    }
                    if (!$hasAny) {
                        $this->addError(
                            "{$secondGrp}_row_{$i}",
                            "Second Piece — Row " . ($i + 1) . ": minimal 1 PCB wajib diisi."
                        );
                    }
                }
            }

            if ($this->secondGroupHasContent($item) && empty($item['status_running'])) {
                $this->addError("{$secondGrp}.status_running", 'Second Piece — Status Running wajib diisi.');
            }
        }
    }

    public function getGroupRowErrors(string $groupKey): array
    {
        $errors = $this->getErrorBag();
        $activeSide = $this->activeSide();
        if (!$activeSide) return [];

        $messages = [];
        $isSecond = in_array($groupKey, ['second_first_items', 'second_middle_items', 'second_last_items'], true);

        if (!$isSecond) {
            foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                $maxRows = count($this->{$groupKey}[$activeSide][$col] ?? []);
                for ($i = 0; $i < $maxRows; $i++) {
                    $key = "{$groupKey}_{$col}_value_{$i}";
                    if ($errors->has($key)) $messages[] = $errors->first($key);
                }
            }
        }

        $maxRows = 0;
        foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
            $maxRows = max($maxRows, count($this->{$groupKey}[$activeSide][$col] ?? []));
        }
        for ($i = 0; $i < $maxRows; $i++) {
            $key = "{$groupKey}_row_{$i}";
            if ($errors->has($key)) $messages[] = $errors->first($key);
        }

        return array_values(array_unique($messages));
    }

    protected function recalcRejectRate(string $groupKey): void
    {
        $ok    = (int) ($this->{$groupKey}['ok_qty'] ?? 0);
        $ng    = (int) ($this->{$groupKey}['ng_qty'] ?? 0);
        $total = $ok + $ng;
        $this->{$groupKey}['reject_rate'] = $total > 0 ? round(($ng / $total) * 100, 2) : 0;
    }

    // ============ ROW MANAGEMENT ============
    public function addRow(string $groupKey, string $side): void
    {
        foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
            $this->{$groupKey}[$side][$col][] = '';
        }

        if (in_array($groupKey, ['first_piece_items', 'middle_piece_items', 'last_piece_items'], true)) {
            foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                $this->judgements[$groupKey][$side][$col][] = null;
            }
            $this->recalcQtyFromJudgements($groupKey);
        }
    }

    public function removeRow(string $groupKey, string $side, int $index): void
    {
        $minRows = ScanXray::standardRows($groupKey);
        $currentCount = 0;
        foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
            $currentCount = max($currentCount, count($this->{$groupKey}[$side][$col] ?? []));
        }
        if ($currentCount <= $minRows) {
            $this->dispatch('notify', message: "Minimal {$minRows} baris untuk grup ini.", type: 'warning');
            return;
        }

        $isSecond = in_array($groupKey, ['second_first_items', 'second_middle_items', 'second_last_items'], true);

        foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
            if (isset($this->{$groupKey}[$side][$col][$index])) {
                unset($this->{$groupKey}[$side][$col][$index]);
                $this->{$groupKey}[$side][$col] = array_values($this->{$groupKey}[$side][$col]);
            }

            if (!$isSecond && isset($this->judgements[$groupKey][$side][$col][$index])) {
                unset($this->judgements[$groupKey][$side][$col][$index]);
                $this->judgements[$groupKey][$side][$col] = array_values($this->judgements[$groupKey][$side][$col]);
            }
        }

        if (!$isSecond) {
            $this->recalcQtyFromJudgements($groupKey);
        }
    }

    // ============ NCP PICKER ============
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
        if (isset($this->ncpPages[$key])) $this->ncpPages[$key] = 1;
    }

    public function setNcpPage(string $groupKey, int $page): void
    {
        $this->ncpPages[$groupKey] = $page;
    }

    public function selectNcp(string $groupKey, int $ncpId): void
    {
        if (isset($this->{$groupKey})) $this->{$groupKey}['ncp_id'] = $ncpId;
        $this->openNcpPanels[$groupKey] = false;
        $this->ncpSearches[$groupKey] = '';
        $this->ncpPages[$groupKey] = 1;
    }

    public function clearNcp(string $groupKey): void
    {
        if (isset($this->{$groupKey})) $this->{$groupKey}['ncp_id'] = null;
    }

    public function getNcpListFor(string $groupKey)
    {
        $search = $this->ncpSearches[$groupKey] ?? '';
        $q = NCP::query()->orderByDesc('id');
        if (!empty($search)) {
            $term = '%' . $search . '%';
            $q->where(function ($qq) use ($term) {
                $qq->where('ncp_number', 'like', $term);
            });
        }
        return $q->paginate(5, ['*'], 'ncpPage_' . $groupKey, $this->ncpPages[$groupKey] ?? 1);
    }

    // ============ MASTER LINE ============
    public function toggleMasterLinePanel(): void
    {
        $this->openMasterLinePanel = !$this->openMasterLinePanel;
        if ($this->openMasterLinePanel) {
            $this->masterLineSearch = '';
            $this->masterLinePage = 1;
        }
    }

    public function updatedMasterLineSearch(): void { $this->masterLinePage = 1; }
    public function setMasterLinePage(int $page): void { $this->masterLinePage = $page; }

    public function selectMasterLine(int $id): void
    {
        $this->master_line_id = $id;
        $this->openMasterLinePanel = false;
        $this->masterLineSearch = '';
        $this->masterLinePage = 1;
    }

    public function clearMasterLine(): void { $this->master_line_id = null; }

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

    // ============ FILE UPLOAD ============
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
    protected function buildPayload(array $existingPictures = [], bool $isCreate = false): array
    {
        $hasNg = false;
        $currentPhase = $isCreate ? 'first' : $this->phase;

        if ($currentPhase === 'first') {
            $hasNg = ((int) ($this->first_piece_items['ng_qty'] ?? 0)) > 0;
        } elseif ($currentPhase === 'middle') {
            $hasNg = ((int) ($this->middle_piece_items['ng_qty'] ?? 0)) > 0;
        } elseif ($currentPhase === 'last') {
            $hasNg = ((int) ($this->last_piece_items['ng_qty'] ?? 0)) > 0;
        }

        $payload = [
            'customer_id'         => $this->customer_id,
            'model_id'            => $this->model_id,
            'pcb_type'            => $this->pcb_type,
            'phase'               => ScanXray::nextPhase($currentPhase, $hasNg),
            'shift'               => $this->shift,
            'group'               => $this->group,
            'master_line_id'      => $this->master_line_id,
            'lot_qty'             => $this->lot_qty,
            'pic_xray'            => $this->pic_xray,
            'first_piece_items'   => $this->prepareGroupPayload('first_piece_items', $existingPictures),
            'middle_piece_items'  => $this->prepareGroupPayload('middle_piece_items', $existingPictures),
            'last_piece_items'    => $this->prepareGroupPayload('last_piece_items', $existingPictures),
            'second_first_items'  => $this->prepareSecondGroupPayload('second_first_items'),
            'second_middle_items' => $this->prepareSecondGroupPayload('second_middle_items'),
            'second_last_items'   => $this->prepareSecondGroupPayload('second_last_items'),
            'updated_by'          => auth()->id(),
        ];

        if ($isCreate) {
            $payload['created_by'] = auth()->id();
        }

        return $payload;
    }

    protected function prepareGroupPayload(string $groupKey, array $existingPictures = []): array
    {
        $item    = $this->{$groupKey};
        $side    = $this->activeSide();
        $stdRows = ScanXray::standardRows($groupKey);

        foreach (['side_single', 'side_lh', 'side_rh'] as $s) {
            foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                $arr = $item[$s][$col] ?? [];
                $arr = array_slice(array_values($arr), 0, $stdRows);
                while (count($arr) < $stdRows) $arr[] = '';
                $item[$s][$col] = $arr;
            }
        }

        $judgementData = [];
        if ($side) {
            foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                $arr = $this->judgements[$groupKey][$side][$col] ?? [];
                $arr = array_slice(array_values($arr), 0, $stdRows);
                while (count($arr) < $stdRows) $arr[] = null;
                $judgementData[$col] = $arr;
            }
        }
        $item['judgements'] = $judgementData;

        foreach (['side_single', 'side_lh', 'side_rh'] as $s) {
            if (!$this->isSideActive($s)) {
                foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                    $item[$s][$col] = array_fill(0, $stdRows, '');
                }
            }
        }

        $ok = 0; $ng = 0;
        $pcbCols  = ['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'];
        $sideData = $side ? ($item[$side] ?? []) : [];
        $judgeData = $item['judgements'] ?? [];

        $maxRows = 0;
        foreach ($pcbCols as $col) {
            $maxRows = max($maxRows, count($sideData[$col] ?? []));
        }

        for ($i = 0; $i < $maxRows; $i++) {
            $hasAnyValue = false;
            $hasNg       = false;

            foreach ($pcbCols as $col) {
                $val   = $sideData[$col][$i] ?? null;
                $judge = $judgeData[$col][$i] ?? null;

                if (empty($val)) continue;

                $hasAnyValue = true;
                if ($judge === 'ng') {
                    $hasNg = true;
                }
            }

            if (!$hasAnyValue) continue;

            if ($hasNg) $ng++;
            else        $ok++;
        }

        $item['ok_qty'] = $ok;
        $item['ng_qty'] = $ng;
        $total = $ok + $ng;
        $item['reject_rate'] = $total > 0 ? round(($ng / $total) * 100, 2) : 0;

        $hasContent = $this->groupHasContent($item);
        $item['time_scan'] = $hasContent ? now()->format('Y-m-d H:i:s') : null;

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

        $hold    = (int) ($item['qty_hold'] ?? 0);
        $okCheck = (int) ($item['status_after_check']['ok'] ?? 0);
        $ngCheck = (int) ($item['status_after_check']['ng'] ?? 0);
        if (($okCheck + $ngCheck) !== $hold && $hold > 0) {
            $item['status_after_check']['ng'] = max(0, $hold - $okCheck);
        }

        unset($item['pictures_new']);

        return $item;
    }

    protected function prepareSecondGroupPayload(string $groupKey): array
    {
        $item = $this->{$groupKey};

        if (empty($item)) {
            return [];
        }

        $side    = $this->activeSide();
        $stdRows = ScanXray::standardRows($groupKey);

        foreach (['side_single', 'side_lh', 'side_rh'] as $s) {
            foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                $arr = $item[$s][$col] ?? [];
                $arr = array_slice(array_values($arr), 0, $stdRows);
                while (count($arr) < $stdRows) $arr[] = '';
                $item[$s][$col] = $arr;
            }
        }

        foreach (['side_single', 'side_lh', 'side_rh'] as $s) {
            if (!$this->isSideActive($s)) {
                foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                    $item[$s][$col] = array_fill(0, $stdRows, '');
                }
            }
        }

        $hasContent = $this->secondGroupHasContent($item);
        $item['time_scan'] = $hasContent ? now()->format('Y-m-d H:i:s') : null;

        return $item;
    }

    protected function groupHasContent(array $item): bool
    {
        if (!empty($item['ok_qty']) || !empty($item['ng_qty'])) return true;

        foreach (['side_single', 'side_lh', 'side_rh'] as $side) {
            foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                $vals = $item[$side][$col] ?? [];
                if (is_array($vals)) {
                    foreach ($vals as $v) if (!empty($v)) return true;
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

    protected function secondGroupHasContent(array $item): bool
    {
        if (!empty($item['status_running'])) return true;

        foreach (['side_single', 'side_lh', 'side_rh'] as $side) {
            foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                $vals = $item[$side][$col] ?? [];
                if (is_array($vals)) {
                    foreach ($vals as $v) if (!empty($v)) return true;
                } elseif (!empty($vals)) {
                    return true;
                }
            }
        }
        return false;
    }

    protected function mergeStructure($data, string $groupKey = 'first_piece_items'): array
    {
        $isSecond = in_array($groupKey, ['second_first_items', 'second_middle_items', 'second_last_items'], true);

        $default = $isSecond
            ? ScanXray::defaultSecondPieceStructure()
            : ScanXray::defaultItemStructure();

        $item    = is_array($data) ? array_replace_recursive($default, $data) : $default;
        $minRows = ScanXray::standardRows($groupKey);

        foreach (['side_single', 'side_lh', 'side_rh'] as $side) {
            foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                $arr = $item[$side][$col] ?? [];
                $arr = is_array($arr) ? array_values($arr) : [''];
                while (count($arr) < $minRows) $arr[] = '';
                $item[$side][$col] = $arr;
            }
        }

        if (!$isSecond) {
            $saved = $data['judgements'] ?? [];
            if (!is_array($saved)) $saved = [];

            $judgementData = [];
            foreach (['pcb_a', 'pcb_b', 'pcb_c', 'pcb_circuit'] as $col) {
                $arr = is_array($saved[$col] ?? null) ? $saved[$col] : [];
                $arr = array_values($arr);
                while (count($arr) < $minRows) $arr[] = null;
                $judgementData[$col] = array_slice($arr, 0, $minRows);
            }
            $item['judgements'] = $judgementData;
        }

        if (!isset($item['pictures']) || !is_array($item['pictures'])) {
            $item['pictures'] = [];
        }

        return $item;
    }

    /**
     * Cek apakah NG Detail untuk grup ini perlu di-auto-open.
     * Return true kalau NG Qty > 0 DAN field wajibnya belum lengkap semua.
     */
    public function shouldAutoOpenNgDetail(string $groupKey): bool
    {
        if (!in_array($groupKey, ['first_piece_items', 'middle_piece_items', 'last_piece_items'], true)) {
            return false;
        }

        $item = $this->{$groupKey} ?? [];

        $ngQty = (int) ($item['ng_qty'] ?? 0);
        if ($ngQty <= 0) return false;

        $filled = 0;

        if (!empty($item['filling_ratio'])) {
            $filled++;
        }
        if (!empty($item['qty_hold'])) {
            $filled++;
        }
        if (!empty($item['status_after_check']['ok']) || !empty($item['status_after_check']['ng'])) {
            $filled++;
        }
        if (!empty($item['ncp_id'])) {
            $filled++;
        }
        if (!empty($item['remarks'])) {
            $filled++;
        }
        if (!empty($item['pictures']) && is_array($item['pictures']) && count($item['pictures']) > 0) {
            $filled++;
        }

        return $filled < 6;
    }

    protected function getDropdownData(): array
    {
        return [
            'customers' => Customer::orderBy('customer_name')->get(),
            'models'    => $this->customer_id
                ? BlindTestModel::where('customer_id', $this->customer_id)->orderBy('model_name')->get()
                : collect(),
        ];
    }
}