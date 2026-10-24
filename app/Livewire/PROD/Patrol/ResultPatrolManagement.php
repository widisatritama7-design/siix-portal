<?php

namespace App\Livewire\PROD\Patrol;

use App\Models\PROD\Patrol\CategoryPatrol;
use App\Models\PROD\Patrol\ResultPatrol;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Ijpatricio\Mingle\Concerns\InteractsWithMingles;
use Ijpatricio\Mingle\Contracts\HasMingles;
use Livewire\Attributes\Title;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

#[Title('Result Patrol')]
class ResultPatrolManagement extends Component implements HasMingles
{
    use InteractsWithMingles;

    public int $perPage = 10;
    public int $page = 1;

    // State Filter
    public string $search = '';
    public string $filterDateFrom = '';
    public string $filterDateUntil = '';
    public string $filterShift = '';
    public string $filterGroup = '';
    public string $filterLine = '';
    public string $filterStatus = '';
    public string $filterCategory = '';
    public string $filterFindingType = '';       // '' | 'safe' | 'finding'
    public string $filterProgressAction = '';    // '' | 'lengkap' | 'belum_diisi'

    public function mount()
    {
        if (!auth()->user()->can('view result patrol')) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function component(): string
    {
        return 'resources/js/mingle/Prod/Patrol/ResultPatrol/index.js';
    }

    // ============================================================
    // MINGLE DATA
    // ============================================================
    public function mingleData(): array
    {
        $query = $this->buildQuery();

        // ✅ Jika filter Progress Action aktif → filter di collection + manual pagination
        // (karena progress dihitung per finding, tidak bisa di SQL sederhana)
        if ($this->filterProgressAction !== '') {
            $paginator = $this->manualPaginateWithProgressFilter($query);
        } else {
            $paginator = $query->paginate($this->perPage, ['*'], 'page', $this->page);
        }

        return [
            'rows' => collect($paginator->items())->map(function ($r) {
                // ============================================================
                // HITUNG PROGRESS (fix: pakai $findings yg sudah dideklarasi)
                // ============================================================
                $findings        = $r->finding_patrol_items ?? [];
                $totalFindings   = count($findings);
                $completedFindings = 0;

                foreach ($findings as $f) {
                    $hasAction   = !empty(trim(strip_tags($f['action'] ?? '')));
                    $hasEvidence = !empty($f['evidence_action']) && count((array) $f['evidence_action']) > 0;
                    if ($hasAction && $hasEvidence) {
                        $completedFindings++;
                    }
                }

                $progressStatus = 'N/A';
                if ($totalFindings > 0) {
                    if ($completedFindings === $totalFindings) {
                        $progressStatus = 'Lengkap';
                    } elseif ($completedFindings > 0) {
                        $progressStatus = 'Sebagian';
                    } else {
                        $progressStatus = 'Belum Diisi';
                    }
                }

                // ============================================================
                // ENRICH FINDINGS dengan status verifikasi + history
                // ============================================================
                $verificationLog = $r->verification_log ?? [];
                $actionHistory   = $r->action_history ?? [];

                $enrichedFindings = collect($findings)->map(function ($f, $idx) use ($verificationLog, $actionHistory) {
                    $latestVerif = collect($verificationLog)
                        ->where('finding_index', $idx)
                        ->sortByDesc('at')
                        ->first();

                    $verifAction = $latestVerif['action'] ?? 'pending';

                    return array_merge($f, [
                        'verification_status' => $verifAction,
                        'rejection_reason'    => $verifAction === 'reject' ? ($latestVerif['reason'] ?? '') : '',
                        'rejected_by_name'    => $verifAction === 'reject' ? ($latestVerif['by_name'] ?? '') : '',
                        'verified_at'         => $latestVerif['at'] ?? null,
                        'history'             => $actionHistory[$idx] ?? [],
                    ]);
                })->toArray();

                // ✅ Kumpulkan semua feedback_to (unik) dari findings
                $feedbackUserIds = collect($enrichedFindings)
                    ->pluck('feedback_to')
                    ->filter()
                    ->unique()
                    ->values()
                    ->all();

                $feedbackUsers = \App\Models\User::whereIn('id', $feedbackUserIds)
                    ->get(['id', 'name'])
                    ->map(fn($u) => ['id' => (string) $u->id, 'name' => $u->name])
                    ->toArray();

                return [
                    'id'                    => $r->id,
                    'shift'                 => $r->shift,
                    'group'                 => $r->group,
                    'status'                => $r->status,
                    'master_line'           => $r->masterLine ? [
                        'id'          => $r->masterLine->id,
                        'line_number' => $r->masterLine->line_number,
                        'location'    => $r->masterLine->location?->location_name,
                    ] : null,
                    'standard_patrol_items' => $r->standard_patrol_items ?? [],
                    'finding_patrol_items'  => $enrichedFindings,
                    'feedback_users'        => $feedbackUsers,          // ✅ BARU
                    'created_by'            => $r->creator?->name ?? '-',
                    'created_at'            => optional($r->created_at)->format('d/m/Y H:i'),
                    'progress'              => [
                        'status'             => $progressStatus,
                        'total_findings'     => $totalFindings,
                        'completed_findings' => $completedFindings,
                    ],
                ];
            })->toArray(),

            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'from'         => $paginator->firstItem(),
                'to'           => $paginator->lastItem(),
            ],

            'employees' => User::query()
                ->permission('feedback result patrol')
                ->orderBy('name')
                ->get(['id', 'name'])
                ->map(fn($u) => [
                    'id'   => (string) $u->id,
                    'nik'  => (string) $u->id,   // alias agar kompatibel dengan lookup lama
                    'name' => $u->name,
                ])
                ->toArray(),
            'categories' => CategoryPatrol::orderBy('category_name')->get(['id', 'category_name'])->toArray(),

            'permissions' => [
                'canCreate'   => auth()->user()->can('create result patrol'),
                'canEdit'     => auth()->user()->can('edit result patrol'),
                'canDelete'   => auth()->user()->can('delete result patrol'),
                'canVerify'   => auth()->user()->can('verification result patrol'),
                'canFeedback' => auth()->user()->can('feedback result patrol'),   // ✅ BARU
            ],

            'auth_user_id' => (string) auth()->id(),
        ];
    }

    // ============================================================
    // UPDATE ACTION TAKEN
    // ============================================================
    public function updateActionTaken(int $id, int $index, array $data): array
    {
        if (!auth()->user()->can('edit result patrol')) {
            return ['success' => false, 'message' => 'You do not have permission to edit!'];
        }

        $row = ResultPatrol::find($id);
        if (!$row) return ['success' => false, 'message' => 'Data not found'];

        $findings = $row->finding_patrol_items ?? [];
        if (!isset($findings[$index])) {
            return ['success' => false, 'message' => 'Finding index not found'];
        }

        $finding = $findings[$index];

        // Archive data lama jika sebelumnya reject
        $this->archiveIfRejected($row, $index, $finding);

        if (array_key_exists('action', $data)) {
            $finding['action'] = $data['action'];
        }

        $finding['verification_status'] = 'pending';

        $findings[$index] = $finding;
        $row->finding_patrol_items = $findings;
        $row->updated_by = auth()->id();
        $row->save();

        return [
            'success' => true,
            'message' => 'Action Taken berhasil disimpan',
            'data'    => $this->mingleData(),
        ];
    }

    // ============================================================
    // UPDATE EVIDENCE ACTION
    // ============================================================
    public function updateEvidenceAction(int $id, int $index, array $data): array
    {
        if (!auth()->user()->can('edit result patrol') || !auth()->user()->can('feedback result patrol')) {
            return ['success' => false, 'message' => 'You do not have permission to edit!'];
        }

        $row = ResultPatrol::find($id);
        if (!$row) return ['success' => false, 'message' => 'Data not found'];

        $findings = $row->finding_patrol_items ?? [];
        if (!isset($findings[$index])) {
            return ['success' => false, 'message' => 'Finding index not found'];
        }

        $finding = $findings[$index];

        $this->archiveIfRejected($row, $index, $finding);

        if (array_key_exists('evidence_action', $data)) {
            $ev = $data['evidence_action'];
            if ($ev === null || $ev === '') {
                $finding['evidence_action'] = [];
            } elseif (is_array($ev)) {
                $finding['evidence_action'] = array_values(array_filter($ev));
            } else {
                $finding['evidence_action'] = [$ev];
            }
        }

        $finding['verification_status'] = 'pending';

        $findings[$index] = $finding;
        $row->finding_patrol_items = $findings;
        $row->updated_by = auth()->id();
        $row->save();

        return [
            'success' => true,
            'message' => 'Evidence Action berhasil disimpan',
            'data'    => $this->mingleData(),
        ];
    }

    // ============================================================
    // VERIFIKASI FINDING
    // ============================================================
    public function verifyFinding(int $id, int $index, string $action, string $reason = ''): array
    {
        if (!auth()->user()->can('verification result patrol')) {
            return ['success' => false, 'message' => 'You do not have permission to verify!'];
        }

        if (!in_array($action, ['approve', 'reject'])) {
            return ['success' => false, 'message' => 'Invalid action'];
        }

        if ($action === 'reject' && trim($reason) === '') {
            return ['success' => false, 'message' => 'Alasan reject wajib diisi'];
        }

        $row = ResultPatrol::find($id);
        if (!$row) return ['success' => false, 'message' => 'Data not found'];

        $findings = $row->finding_patrol_items ?? [];
        if (!isset($findings[$index])) {
            return ['success' => false, 'message' => 'Finding index not found'];
        }

        $finding = $findings[$index];

        // Validasi action & evidence
        $hasAction   = !empty(trim(strip_tags($finding['action'] ?? '')));
        $hasEvidence = !empty($finding['evidence_action']) && count((array) $finding['evidence_action']) > 0;
        if (!$hasAction || !$hasEvidence) {
            return ['success' => false, 'message' => 'Action Taken dan Evidence Action harus diisi sebelum verifikasi'];
        }

        // Tambah ke log
        $verificationLog = $row->verification_log ?? [];
        $verificationLog[] = [
            'finding_index' => $index,
            'action'        => $action,
            'reason'        => $reason,
            'by'            => auth()->id(),
            'by_name'       => auth()->user()->name,
            'at'            => now()->toDateTimeString(),
        ];
        $row->verification_log = $verificationLog;

        // Update status finding
        $findings[$index]['verification_status'] = $action === 'approve' ? 'approve' : 'reject';
        $row->finding_patrol_items = $findings;

        // Cek apakah semua finding approve → Closed
        if ($action === 'approve') {
            $allApproved = true;
            foreach ($findings as $idx => $f) {
                $latest = collect($verificationLog)
                    ->where('finding_index', $idx)
                    ->sortByDesc('at')
                    ->first();
                if (!$latest || $latest['action'] !== 'approve') {
                    $allApproved = false;
                    break;
                }
            }

            if ($allApproved && count($findings) > 0) {
                $row->status = 'Closed';
            } else {
                $row->status = 'On Progress';
            }
        } else {
            $row->status = 'On Progress';
        }

        $row->verified_by = auth()->id();
        $row->verified_at = now();
        $row->updated_by  = auth()->id();
        $row->save();

        $message = $action === 'approve'
            ? 'Finding berhasil di-approve'
            : 'Finding di-reject, user harus membuat ulang Action Taken & Evidence Action';

        return [
            'success' => true,
            'message' => $message,
            'data'    => $this->mingleData(),
        ];
    }

    // ============================================================
    // ARCHIVE HELPER
    // ============================================================
    private function archiveIfRejected(ResultPatrol $row, int $index, array $finding): void
    {
        $verificationLog = $row->verification_log ?? [];
        $latestVerif = collect($verificationLog)
            ->where('finding_index', $index)
            ->sortByDesc('at')
            ->first();

        if (!$latestVerif || $latestVerif['action'] !== 'reject') {
            return;
        }

        $history = $row->action_history ?? [];
        $history[$index] = $history[$index] ?? [];

        $history[$index][] = [
            'revision'         => count($history[$index]) + 1,
            'action'           => $finding['action'] ?? '',
            'evidence_action'  => $finding['evidence_action'] ?? [],
            'status'           => 'rejected',
            'rejection_reason' => $latestVerif['reason'] ?? '',
            'rejected_by'      => $latestVerif['by'] ?? null,
            'rejected_by_name' => $latestVerif['by_name'] ?? '-',
            'rejected_at'      => $latestVerif['at'] ?? null,
        ];

        $row->action_history = $history;
    }

    // ============================================================
    // PAGINATION & FILTER
    // ============================================================
    public function gotoPage(int $page): array
    {
        $this->page = max(1, $page);
        return $this->mingleData();
    }

    public function setFilter(array $filters): array
    {
        $this->search               = $filters['search'] ?? '';
        $this->filterDateFrom       = $filters['date_from'] ?? '';
        $this->filterDateUntil      = $filters['date_until'] ?? '';
        $this->filterShift          = $filters['shift'] ?? '';
        $this->filterGroup          = $filters['group'] ?? '';
        $this->filterLine           = $filters['line'] ?? '';
        $this->filterCategory       = $filters['category'] ?? '';
        $this->filterStatus         = $filters['status'] ?? '';
        $this->filterFindingType    = $filters['finding_type'] ?? '';
        $this->filterProgressAction = $filters['progress_action'] ?? '';

        $this->page = 1;

        return $this->mingleData();
    }

    // ============================================================
    // MANUAL PAGINATION untuk Progress Filter
    // ============================================================
    private function manualPaginateWithProgressFilter($query)
    {
        $allRows = $query->get();

        $filtered = $allRows->filter(function ($r) {
            $findings = $r->finding_patrol_items ?? [];
            $total = count($findings);

            // Tentukan status progress
            $completed = 0;
            $approved  = 0;

            foreach ($findings as $f) {
                $hasAction   = !empty(trim(strip_tags($f['action'] ?? '')));
                $hasEvidence = !empty($f['evidence_action']) && count((array) $f['evidence_action']) > 0;
                if ($hasAction && $hasEvidence) $completed++;
            }

            // hitung approved (dari verification_log)
            $verificationLog = $r->verification_log ?? [];
            foreach ($findings as $idx => $f) {
                $latest = collect($verificationLog)
                    ->where('finding_index', $idx)
                    ->sortByDesc('at')
                    ->first();
                if ($latest && $latest['action'] === 'approve') $approved++;
            }

            $progressStatus = 'N/A';
            if ($total > 0) {
                if ($completed === $total) {
                    $progressStatus = 'Lengkap';
                } elseif ($completed > 0) {
                    $progressStatus = 'Sebagian';
                } else {
                    $progressStatus = 'Belum Diisi';
                }
            }

            $isWaitingApproval = $progressStatus === 'Lengkap' && $approved < $total;

            // Cocokkan dengan filter
            return match ($this->filterProgressAction) {
                'lengkap'           => $progressStatus === 'Lengkap' && $approved === $total, // lengkap + semua approved
                'waiting_approval'  => $isWaitingApproval,
                'sebagian'          => $progressStatus === 'Sebagian',
                'belum_diisi'       => $progressStatus === 'Belum Diisi',
                default             => true,
            };
        })->values();

        $total      = $filtered->count();
        $lastPage   = $total > 0 ? (int) ceil($total / $this->perPage) : 1;
        $currentPage = min(max(1, $this->page), $lastPage);
        $offset     = ($currentPage - 1) * $this->perPage;

        $items = $filtered->slice($offset, $this->perPage)->values()->all();

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $this->perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    // ============================================================
    // EXPORT PDF
    // ============================================================
    public function exportPdf()
    {
        // ✅ Filter progress juga diterapkan saat export
        $rows = $this->getExportRows();

        $categories = CategoryPatrol::pluck('category_name', 'id')->toArray();
        $employees = \App\Models\User::permission('feedback result patrol')->pluck('name', 'id')->toArray();

        $pdf = Pdf::loadView('livewire.prod.patrol.result-patrol-pdf', compact('rows', 'categories', 'employees'))
            ->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'result-patrol-' . now()->format('YmdHis') . '.pdf');
    }

    // ============================================================
    // EXPORT EXCEL
    // ============================================================
    public function exportExcel()
    {
        if (!auth()->user()->can('view result patrol')) {
            return ['success' => false, 'message' => 'You do not have permission!'];
        }

        $rows = $this->getExportRows();

        if ($rows->isEmpty()) {
            return ['success' => false, 'message' => 'No data to export.'];
        }

        $categories = CategoryPatrol::pluck('category_name', 'id')->toArray();
        $employees = \App\Models\User::permission('feedback result patrol')->pluck('name', 'id')->toArray();

        $tempFiles = [];

        $headerStyle = [
            'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 11],
            'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF4472C4']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, 'wrapText' => true],
        ];

        $totalStyle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFF2CC']],
        ];

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Result Patrol');

        $lastCol = 'M';

        $sheet->setCellValue('A1', 'RESULT PATROL REPORT');
        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14)->getColor()->setARGB('FF1E3A8A');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'PT. SIIX EMS INDONESIA — Production Department');
        $sheet->mergeCells("A2:{$lastCol}2");
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(10)->getColor()->setARGB('FF666666');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $filterText = [];
        if ($this->search)              $filterText[] = 'Search: ' . $this->search;
        if ($this->filterShift)         $filterText[] = 'Shift: ' . $this->filterShift;
        if ($this->filterGroup)         $filterText[] = 'Group: ' . $this->filterGroup;
        if ($this->filterLine)          $filterText[] = 'Line: ' . $this->filterLine;
        if ($this->filterCategory)      $filterText[] = 'Category: ' . ($categories[$this->filterCategory] ?? '-');
        if ($this->filterStatus)        $filterText[] = 'Status: ' . $this->filterStatus;
        if ($this->filterFindingType)   $filterText[] = 'Finding Type: ' . ($this->filterFindingType === 'safe' ? 'Safe' : 'Finding');
        if ($this->filterProgressAction) $filterText[] = 'Progress: ' . ($this->filterProgressAction === 'lengkap' ? 'Lengkap' : 'Belum Diisi');
        if ($this->filterDateFrom)      $filterText[] = 'From: ' . $this->filterDateFrom;
        if ($this->filterDateUntil)     $filterText[] = 'Until: ' . $this->filterDateUntil;

        $sheet->setCellValue('A3', $filterText ? 'Filter: ' . implode(' | ', $filterText) : 'Filter: None');
        $sheet->mergeCells("A3:{$lastCol}3");
        $sheet->getStyle('A3')->getFont()->setItalic(true)->setSize(9)->getColor()->setARGB('FF2563EB');
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A4', 'Generated: ' . now()->format('d M Y, H:i') . ' | By: ' . (auth()->user()?->name ?? '-'));
        $sheet->mergeCells("A4:{$lastCol}4");
        $sheet->getStyle('A4')->getFont()->setSize(9)->getColor()->setARGB('FF666666');
        $sheet->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $headerRow = 6;
        $sheet->setCellValue('A' . $headerRow, 'No');
        $sheet->setCellValue('B' . $headerRow, 'Shift');
        $sheet->setCellValue('C' . $headerRow, 'Group');
        $sheet->setCellValue('D' . $headerRow, 'Line');
        $sheet->setCellValue('E' . $headerRow, 'Category');
        $sheet->setCellValue('F' . $headerRow, 'Finding Result');
        $sheet->setCellValue('G' . $headerRow, 'Feedback To');
        $sheet->setCellValue('H' . $headerRow, 'Reason');
        $sheet->setCellValue('I' . $headerRow, 'Action Taken');
        $sheet->setCellValue('J' . $headerRow, 'Status');
        $sheet->setCellValue('K' . $headerRow, 'Date');
        $sheet->setCellValue('L' . $headerRow, 'Evidence');
        $sheet->setCellValue('M' . $headerRow, 'Evidence Action');

        $sheet->getStyle("A{$headerRow}:{$lastCol}{$headerRow}")->applyFromArray($headerStyle);

        $row = $headerRow + 1;
        $no = 1;

        foreach ($rows as $r) {
            $hasFindings = count($r->finding_patrol_items ?? []) > 0;
            $findings = $hasFindings ? $r->finding_patrol_items : [null];
            $rowCount = count($findings);

            foreach ($findings as $index => $f) {
                $sheet->getRowDimension($row)->setRowHeight(180);

                if ($index === 0) {
                    $sheet->setCellValue('A' . $row, $no++);
                    $sheet->setCellValue('B' . $row, $r->shift);
                    $sheet->setCellValue('C' . $row, $r->group);
                    $sheet->setCellValue('D' . $row, ($r->masterLine?->line_number ?? '-') . ' (' . ($r->masterLine?->location?->location_name ?? '-') . ')');
                    $sheet->setCellValue('J' . $row, $r->status);
                    $sheet->setCellValue('K' . $row, $r->created_at?->format('d/m/Y H:i') ?? '-');
                }

                if ($f) {
                    $catName = $categories[$f['category_id']] ?? '-';
                    $empName = $employees[$f['feedback_to']] ?? $f['feedback_to'] ?? '-';

                    $sheet->setCellValue('E' . $row, $catName);
                    $sheet->setCellValue('F' . $row, $f['finding_result'] ?? '-');
                    $sheet->setCellValue('G' . $row, $empName);
                    $sheet->setCellValue('H' . $row, $f['reason'] ?? '-');
                    $sheet->setCellValue('I' . $row, $f['action'] ?? '-');

                    if (!empty($f['evidence'])) {
                        $photos = is_array($f['evidence']) ? $f['evidence'] : [$f['evidence']];
                        $this->addMultipleImagesToSheet($sheet, $photos, $row, 'L', $tempFiles);
                    }

                    if (!empty($f['evidence_action'])) {
                        $photos = is_array($f['evidence_action']) ? $f['evidence_action'] : [$f['evidence_action']];
                        $this->addMultipleImagesToSheet($sheet, $photos, $row, 'M', $tempFiles);
                    }
                } else {
                    $sheet->setCellValue('E' . $row, '-');
                    $sheet->setCellValue('F' . $row, 'Safe');
                    $sheet->setCellValue('G' . $row, '-');
                    $sheet->setCellValue('H' . $row, '-');
                    $sheet->setCellValue('I' . $row, '-');
                }

                $status = $r->status ?? 'Open';
                $statusColor = match ($status) {
                    'Open'        => 'FF3B82F6',
                    'On Progress' => 'FFF59E0B',
                    'Pending'     => 'FF8B5CF6',
                    'Closed'      => 'FF6B7280',
                    default       => 'FF000000',
                };
                $sheet->getStyle('J' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color($statusColor));

                $sheet->getStyle("A{$row}:{$lastCol}{$row}")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle("A{$row}:{$lastCol}{$row}")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                if ($rowCount > 1 && $index === 0) {
                    $endRow = $row + $rowCount - 1;
                    $sheet->mergeCells("A{$row}:A{$endRow}");
                    $sheet->mergeCells("B{$row}:B{$endRow}");
                    $sheet->mergeCells("C{$row}:C{$endRow}");
                    $sheet->mergeCells("D{$row}:D{$endRow}");
                    $sheet->mergeCells("J{$row}:J{$endRow}");
                    $sheet->mergeCells("K{$row}:K{$endRow}");
                }

                $row++;
            }
        }

        $sheet->setCellValue('A' . $row, 'TOTAL');
        $sheet->mergeCells("A{$row}:D{$row}");
        $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray($totalStyle);
        $sheet->getStyle("A{$row}:{$lastCol}{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $widths = [
            'A' => 5, 'B' => 8, 'C' => 8, 'D' => 25, 'E' => 15, 'F' => 25, 'G' => 20, 'H' => 25, 'I' => 25, 'J' => 15, 'K' => 18,
            'L' => 25, 'M' => 25,
        ];
        foreach ($widths as $col => $w) {
            $sheet->getColumnDimension($col)->setWidth($w);
        }

        $sheet->freezePane('E7');

        $fileName = 'result-patrol-' . now()->format('Ymd-His') . '.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $tempExcel = tempnam(sys_get_temp_dir(), 'excel_');
        $writer->save($tempExcel);
        $fileContent = base64_encode(file_get_contents($tempExcel));

        unlink($tempExcel);
        foreach ($tempFiles as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }

        return [
            'success'  => true,
            'file'     => $fileContent,
            'filename' => $fileName,
        ];
    }

    public function updateActionAndEvidence(int $id, int $index, array $data): array
    {
        if (!auth()->user()->can('feedback result patrol')) {
            return ['success' => false, 'message' => 'You do not have permission to edit!'];
        }

        $row = ResultPatrol::find($id);
        if (!$row) return ['success' => false, 'message' => 'Data not found'];

        $findings = $row->finding_patrol_items ?? [];
        if (!isset($findings[$index])) {
            return ['success' => false, 'message' => 'Finding index not found'];
        }

        $user = auth()->user();
        if ($user->can('feedback result patrol') && !$user->can('verification result patrol')) {
            $fbTo = $findings[$index]['feedback_to'] ?? null;
            $isMine = is_array($fbTo)
                ? in_array((string) $user->id, array_map('strval', $fbTo), true)
                : ((string) $fbTo === (string) $user->id);

            if (!$isMine) {
                return ['success' => false, 'message' => 'You can only edit findings assigned to you.'];
            }
        }

        $finding = $findings[$index];

        $this->archiveIfRejected($row, $index, $finding);

        // Action Taken
        if (array_key_exists('action', $data)) {
            $finding['action'] = $data['action'];
        }

        // Evidence Action
        if (array_key_exists('evidence_action', $data)) {
            $ev = $data['evidence_action'];
            if ($ev === null || $ev === '') {
                $finding['evidence_action'] = [];
            } elseif (is_array($ev)) {
                $finding['evidence_action'] = array_values(array_filter($ev));
            } else {
                $finding['evidence_action'] = [$ev];
            }
        }

        $finding['verification_status'] = 'pending';

        $findings[$index] = $finding;
        $row->finding_patrol_items = $findings;
        $row->updated_by = auth()->id();
        $row->save();

        return [
            'success' => true,
            'message' => 'Action Taken & Evidence Action berhasil disimpan',
            'data'    => $this->mingleData(),
        ];
    }

    // ============================================================
    // HELPER EXPORT: ambil rows + filter progress
    // ============================================================
    private function getExportRows()
    {
        $query = $this->buildQuery();
        $rows  = $query->get();

        if ($this->filterProgressAction !== '') {
            $rows = $rows->filter(function ($r) {
                $findings = $r->finding_patrol_items ?? [];
                $total = count($findings);
                if ($total === 0 && $this->filterProgressAction !== 'belum_diisi') return false;

                $completed = 0;
                foreach ($findings as $f) {
                    $hasAction   = !empty(trim(strip_tags($f['action'] ?? '')));
                    $hasEvidence = !empty($f['evidence_action']) && count((array) $f['evidence_action']) > 0;
                    if ($hasAction && $hasEvidence) $completed++;
                }

                $verificationLog = $r->verification_log ?? [];
                $approved = 0;
                foreach ($findings as $idx => $f) {
                    $latest = collect($verificationLog)
                        ->where('finding_index', $idx)
                        ->sortByDesc('at')
                        ->first();
                    if ($latest && $latest['action'] === 'approve') $approved++;
                }

                $progressStatus = 'N/A';
                if ($total > 0) {
                    if ($completed === $total) $progressStatus = 'Lengkap';
                    elseif ($completed > 0) $progressStatus = 'Sebagian';
                    else $progressStatus = 'Belum Diisi';
                }

                $isWaitingApproval = $progressStatus === 'Lengkap' && $approved < $total;

                return match ($this->filterProgressAction) {
                    'lengkap'          => $progressStatus === 'Lengkap' && $approved === $total,
                    'waiting_approval' => $isWaitingApproval,
                    'sebagian'         => $progressStatus === 'Sebagian',
                    'belum_diisi'      => $progressStatus === 'Belum Diisi',
                    default            => true,
                };
            })->values();
        }

        return $rows;
    }

    // ============================================================
    // HELPER IMAGE
    // ============================================================
    private function base64ToTempImage($base64String)
    {
        try {
            $parts = explode(',', $base64String);
            if (count($parts) < 2) return null;

            $imageData = base64_decode($parts[1]);
            $tempFile = tempnam(sys_get_temp_dir(), 'img_') . '.jpg';
            file_put_contents($tempFile, $imageData);

            return $tempFile;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function addImageToSheet($sheet, $imagePath, $row, $colLetter)
    {
        try {
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('Evidence');
            $drawing->setDescription('Evidence');
            $drawing->setPath($imagePath);
            $drawing->setHeight(80);
            $drawing->setCoordinates($colLetter . $row);
            $drawing->setOffsetX(15);
            $drawing->setOffsetY(10);
            $drawing->setWorksheet($sheet);
        } catch (\Exception $e) {
            // ignore
        }
    }

    private function addMultipleImagesToSheet($sheet, array $photos, $row, $colLetter, array &$tempFiles)
    {
        if (empty($photos)) return;

        try {
            $imageCount = count($photos);
            $cellHeight = $imageCount === 1 ? 160 : 80;

            foreach ($photos as $i => $base64) {
                $tempPath = $this->base64ToTempImage($base64);
                if (!$tempPath) continue;
                $tempFiles[] = $tempPath;

                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('Evidence_' . ($i + 1));
                $drawing->setDescription('Evidence');
                $drawing->setPath($tempPath);
                $drawing->setHeight($cellHeight);

                $colOffset = $i % 2;
                $rowOffset = intdiv($i, 2);

                $drawing->setCoordinates($colLetter . $row);
                $drawing->setOffsetX(15 + $colOffset * ($cellHeight + 5));
                $drawing->setOffsetY(10 + $rowOffset * ($cellHeight + 5));

                $drawing->setWorksheet($sheet);
            }
        } catch (\Exception $e) {
            // ignore
        }
    }

    // ============================================================
    // DELETE & UPDATE STATUS
    // ============================================================
    public function deleteRow(int $id): array
    {
        if (!auth()->user()->can('delete result patrol')) {
            return ['success' => false, 'message' => 'You do not have permission to delete!'];
        }

        $row = ResultPatrol::find($id);
        if (!$row) return ['success' => false, 'message' => 'Data tidak ditemukan'];

        $row->delete();
        return ['success' => true, 'message' => 'Data berhasil dihapus', 'data' => $this->mingleData()];
    }

    public function updateStatus(int $id, string $status): array
    {
        if (!auth()->user()->can('edit result patrol')) {
            return ['success' => false, 'message' => 'You do not have permission to edit!'];
        }

        $row = ResultPatrol::find($id);
        if (!$row) return ['success' => false, 'message' => 'Data not found'];

        if (!in_array($status, ['Open', 'On Progress', 'Pending', 'Closed'])) {
            return ['success' => false, 'message' => 'Invalid status'];
        }

        $row->update([
            'status'     => $status,
            'updated_by' => auth()->id(),
        ]);

        return [
            'success' => true,
            'message' => 'Status updated successfully',
            'data'    => $this->mingleData(),
        ];
    }

    // ============================================================
    // BUILD QUERY (SEMUA FILTER)
    // ============================================================
    private function buildQuery()
    {
        $query = ResultPatrol::query()
            ->with(['masterLine.location', 'creator'])
            ->orderBy('id', 'desc');

        $this->applyFeedbackScope($query);

        // Search
        if ($this->search !== '') {
            $s = $this->search;
            $query->where(function ($q) use ($s) {
                $q->where('shift', 'like', "%{$s}%")
                  ->orWhere('group', 'like', "%{$s}%")
                  ->orWhereHas('masterLine', function ($ml) use ($s) {
                      $ml->where('line_number', 'like', "%{$s}%")
                         ->orWhereHas('location', function ($loc) use ($s) {
                             $loc->where('location_name', 'like', "%{$s}%");
                         });
                  });
            });
        }

        if ($this->filterStatus !== '') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterDateFrom) {
            $query->whereDate('created_at', '>=', $this->filterDateFrom);
        }
        if ($this->filterDateUntil) {
            $query->whereDate('created_at', '<=', $this->filterDateUntil);
        }

        if ($this->filterShift) $query->where('shift', $this->filterShift);
        if ($this->filterGroup) $query->where('group', $this->filterGroup);

        if ($this->filterLine) {
            $query->whereHas('masterLine', function ($ml) {
                $ml->where('line_number', $this->filterLine);
            });
        }

        // ✅ FIX FILTER CATEGORY — JSON_SEARCH (MySQL 8+ & MariaDB 10.4+)
        if ($this->filterCategory !== '') {
            $catId = $this->filterCategory;
            $query->where(function ($q) use ($catId) {
                $q->whereRaw(
                    "JSON_SEARCH(finding_patrol_items, 'one', ?, NULL, '$[*].category_id') IS NOT NULL",
                    [$catId]
                )->orWhereRaw(
                    "JSON_SEARCH(finding_patrol_items, 'one', ?, NULL, '$[*].category_id') IS NOT NULL",
                    [(string) $catId]
                );
            });
        }

        // ✅ FILTER FINDING TYPE (safe / finding)
        if ($this->filterFindingType === 'safe') {
            $query->where(function ($q) {
                $q->whereNull('finding_patrol_items')
                  ->orWhereRaw('JSON_LENGTH(finding_patrol_items) = 0')
                  ->orWhereRaw('JSON_LENGTH(finding_patrol_items) IS NULL');
            });
        } elseif ($this->filterFindingType === 'finding') {
            $query->whereRaw('JSON_LENGTH(finding_patrol_items) > 0');
        }

        // ✅ FILTER PROGRESS ACTION ditangani di manualPaginateWithProgressFilter() / getExportRows()

        return $query;
    }

    private function applyFeedbackScope($query): void
    {
        $user = auth()->user();
        if (!$user) return;

        // Hanya scope jika punya feedback result patrol
        if (!$user->can('feedback result patrol')) return;

        // Jika juga punya verification result patrol → lihat semua
        if ($user->can('verification result patrol')) return;

        $userId = (string) $user->id;

        $query->where(function ($q) use ($userId) {
            // 1) feedback_to berupa string tunggal = user id
            $q->whereRaw(
                "JSON_SEARCH(finding_patrol_items, 'one', ?, NULL, '$[*].feedback_to') IS NOT NULL",
                [$userId]
            )
            // 2) feedback_to berupa array yang berisi user id
            ->orWhereRaw(
                "JSON_CONTAINS(finding_patrol_items, JSON_QUOTE(?), '$[*].feedback_to')",
                [$userId]
            );
        });
    }
}