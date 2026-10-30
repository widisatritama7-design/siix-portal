<?php

namespace App\Livewire\UTY;

use App\Exports\DailyReportUtilityExport;
use App\Models\UTY\DailyReportUtility;
use Ijpatricio\Mingle\Concerns\InteractsWithMingles;
use Ijpatricio\Mingle\Contracts\HasMingles;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Daily Report Utility')]
class DailyReportUtilityManagement extends Component implements HasMingles
{
    use InteractsWithMingles;
    use WithFileUploads;

    public int $perPage = 10;
    public int $page = 1;

    public $photoBeforeFiles = [];
    public $photoAfterFiles  = [];

    public function mount()
    {
        if (!auth()->user()->can('view daily report utility')) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function component(): string
    {
        return 'resources/js/mingle/Uty/DailyReportUtility/index.js';
    }

    public function exportExcel(array $filters): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        return (new DailyReportUtilityExport($filters))->download();
    }

    public function mingleData(): array
    {
        $permissions = [
            'canCreate' => auth()->user()->can('create daily report utility'),
            'canEdit'   => auth()->user()->can('edit daily report utility'),
            'canDelete' => auth()->user()->can('delete daily report utility'),
        ];

        $paginator = DailyReportUtility::query()
            ->select('id', 'shift', 'report_category', 'problem_desc', 'photo_before', 'action_desc', 'photo_after', 'status', 'created_at', 'updated_at')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage, ['*'], 'page', $this->page);

        return [
            'rows' => collect($paginator->items())
                ->map(fn ($r) => [
                    'id'              => $r->id,
                    'shift'           => $r->shift,
                    'report_category' => $r->report_category,
                    'problem_desc'    => $r->problem_desc,
                    'photo_before'       => collect($r->photo_before ?? [])->map(fn ($p) => Storage::url($p))->toArray(),
                    'photo_before_paths' => $r->photo_before ?? [],
                    'action_desc'     => $r->action_desc,
                    'photo_after'        => collect($r->photo_after ?? [])->map(fn ($p) => Storage::url($p))->toArray(),
                    'photo_after_paths'  => $r->photo_after ?? [],
                    'status'          => $r->status,
                    'created_at'      => optional($r->created_at)->format('d/m/Y H:i'),
                    'updated_at'      => optional($r->updated_at)->format('d/m/Y H:i'),
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

            'options' => [
                'shifts'     => [1, 2, 3],
                'categories' => ['Schedule PM', 'Abnormality'],
                'statuses'   => ['Open', 'Under Maintenance', 'On Progress', 'Closed'],
            ],
        ];
    }

    public function gotoPage(int $page): array
    {
        $this->page = max(1, $page);
        return $this->mingleData();
    }

    public function save(array $payload): array
    {
        $isEdit = !empty($payload['id']);

        if (!$isEdit && !auth()->user()->can('create daily report utility')) {
            return ['success' => false, 'message' => 'You do not have permission to create!'];
        }
        if ($isEdit && !auth()->user()->can('edit daily report utility')) {
            return ['success' => false, 'message' => 'You do not have permission to edit!'];
        }

        $shift          = (int) ($payload['shift'] ?? 0);
        $reportCategory = $payload['report_category'] ?? '';

        if (!in_array($shift, [1, 2, 3], true)) {
            return ['success' => false, 'message' => 'Invalid shift'];
        }
        if (!in_array($reportCategory, ['Schedule PM', 'Abnormality'], true)) {
            return ['success' => false, 'message' => 'Invalid report category'];
        }

        // Store new uploaded files
        $newBefore = [];
        foreach ($this->photoBeforeFiles ?? [] as $file) {
            $newBefore[] = $file->store('uty/daily-report-utility/before', 'public');
        }
        $newAfter = [];
        foreach ($this->photoAfterFiles ?? [] as $file) {
            $newAfter[] = $file->store('uty/daily-report-utility/after', 'public');
        }

        $existingBefore = $payload['photo_before_existing'] ?? [];
        $existingAfter  = $payload['photo_after_existing'] ?? [];

        $data = [
            'shift'           => $shift,
            'report_category' => $reportCategory,
            'problem_desc' => trim((string) ($payload['problem_desc'] ?? ''))
                                ? clean($payload['problem_desc'])
                                : null,
            'action_desc'  => trim((string) ($payload['action_desc'] ?? ''))
                                ? clean($payload['action_desc'])
                                : null,
            'updated_by'      => auth()->id(),
        ];

        if ($isEdit) {
            $row = DailyReportUtility::find($payload['id']);
            if (!$row) {
                return ['success' => false, 'message' => 'Data not found'];
            }
            if ($row->status === 'Closed') {
                return ['success' => false, 'message' => 'Closed reports cannot be edited'];
            }

            // Delete old files that were removed by user
            $oldBefore = $row->photo_before ?? [];
            foreach (array_diff($oldBefore, $existingBefore) as $path) {
                Storage::disk('public')->delete($path);
            }
            $oldAfter = $row->photo_after ?? [];
            foreach (array_diff($oldAfter, $existingAfter) as $path) {
                Storage::disk('public')->delete($path);
            }

            $data['photo_before'] = array_values(array_merge($existingBefore, $newBefore));
            $data['photo_after']  = array_values(array_merge($existingAfter, $newAfter));

            $row->update($data);
            $message = 'Daily report updated successfully';
        } else {
            $data['photo_before'] = $newBefore;
            $data['photo_after']  = $newAfter;
            $data['created_by']   = auth()->id();
            $data['status']       = 'Open'; // forced on create
            DailyReportUtility::create($data);
            $message = 'Daily report created successfully';
        }

        // Reset temporary uploads
        $this->photoBeforeFiles = [];
        $this->photoAfterFiles  = [];

        return [
            'success' => true,
            'message' => $message,
            'data'    => $this->mingleData(),
        ];
    }

    public function updateStatus(int $id, string $status): array
    {
        if (!auth()->user()->can('edit daily report utility')) {
            return ['success' => false, 'message' => 'You do not have permission to update status!'];
        }

        if (!in_array($status, ['On Progress', 'Under Maintenance', 'Closed'], true)) {
            return ['success' => false, 'message' => 'Invalid status'];
        }

        $row = DailyReportUtility::find($id);
        if (!$row) {
            return ['success' => false, 'message' => 'Data not found'];
        }
        if ($row->status === 'Closed') {
            return ['success' => false, 'message' => 'Closed reports cannot be updated'];
        }
        if ($row->status === $status) {
            return ['success' => false, 'message' => 'Status is already ' . $status];
        }

        $row->update([
            'status'     => $status,
            'updated_by' => auth()->id(),
        ]);

        return [
            'success' => true,
            'message' => "Status updated to {$status}",
            'data'    => $this->mingleData(),
        ];
    }

    public function deleteRow(int $id): array
    {
        if (!auth()->user()->can('delete daily report utility')) {
            return ['success' => false, 'message' => 'You do not have permission to delete!'];
        }

        $row = DailyReportUtility::find($id);
        if (!$row) {
            return ['success' => false, 'message' => 'Data not found'];
        }
        if ($row->status !== 'Open') {
            return ['success' => false, 'message' => 'Only reports with status Open can be deleted'];
        }

        foreach (($row->photo_before ?? []) as $p) {
            Storage::disk('public')->delete($p);
        }
        foreach (($row->photo_after ?? []) as $p) {
            Storage::disk('public')->delete($p);
        }

        $row->delete();

        return [
            'success' => true,
            'message' => 'Daily report deleted successfully',
            'data'    => $this->mingleData(),
        ];
    }
}