<?php

namespace App\Models\QAQC\BlindTest;

use App\Models\HR\Employee;
use App\Models\QAQC\BlindTest\Customer;
use App\Models\QAQC\BlindTest\Model as QaqcModel;
use App\Models\QAQC\BlindTest\Question;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class BlindTest extends EloquentModel
{
    use SoftDeletes;

    protected $table = 'tb_qaqc_blind_test';

    protected $fillable = [
        'employee_id', 'shift', 'group', 'section', 'question_id',
        'question_ids',
        'customer_id', 'model_id',
        'blind_test_items', 'question_snapshot', 'user_answers',
        'time_test', 'duration_minutes',
        'time_actual', 'started_at', 'finished_at', 'duration_seconds',
        'status', 'overall_result', 'auto_saved', 'auto_saved_at',
        'is_reviewed', 'reviewed_at', 'reviewed_by',
        'check_by_qc', 'check_by_qc_at',
        'check_by_prod', 'check_by_prod_at',
        'acknowledge_by_spv', 'acknowledge_by_spv_at',
        'acknowledge_qc_spv', 'acknowledge_qc_spv_at',
        'created_by', 'updated_by', 'deleted_by', 'deleted_reason',

        // Attempt columns
        'attempt', 'max_attempt',
        'first_attempt_answers', 'first_attempt_result', 'first_attempt_at',
        'retry_from_id',

        // Camera / browser proctoring
        'browser_verified',
        'camera_enabled',
        'browser_info',
        'camera_recording_path',
        'camera_recording_size',
        'camera_started_at',
        'camera_stopped_at',

        // Screen recording
        'screen_recording_path', 'screen_recording_size',
        'screen_enabled', 'screen_started_at', 'screen_stopped_at',

        // Attempt 1 recordings
        'first_attempt_camera_path', 'first_attempt_camera_size',
        'first_attempt_screen_path', 'first_attempt_screen_size',
    ];

    protected $casts = [
        'question_ids'          => 'array',
        'blind_test_items'      => 'array',
        'question_snapshot'     => 'array',
        'user_answers'          => 'array',
        'first_attempt_answers' => 'array',
        'first_attempt_at'      => 'datetime',
        'time_test'             => 'datetime:H:i',
        'time_actual'           => 'datetime:H:i',
        'duration_minutes'      => 'integer',
        'started_at'            => 'datetime',
        'finished_at'           => 'datetime',
        'auto_saved'            => 'boolean',
        'auto_saved_at'         => 'datetime',
        'is_reviewed'           => 'boolean',
        'reviewed_at'           => 'datetime',
        'check_by_qc_at'        => 'datetime',
        'check_by_prod_at'      => 'datetime',
        'acknowledge_by_spv_at' => 'datetime',
        'acknowledge_qc_spv_at' => 'datetime',
        'created_at'            => 'datetime',
        'updated_at'            => 'datetime',
        'deleted_at'            => 'datetime',
        'attempt'               => 'integer',
        'max_attempt'           => 'integer',

        // Camera / browser proctoring
        'browser_info'          => 'array',
        'browser_verified'      => 'boolean',
        'camera_enabled'        => 'boolean',
        'camera_started_at'     => 'datetime',
        'camera_stopped_at'     => 'datetime',
        'camera_recording_size' => 'integer',

        // Screen recording
        'screen_enabled'        => 'boolean',
        'screen_started_at'     => 'datetime',
        'screen_stopped_at'     => 'datetime',
        'screen_recording_size' => 'integer',

        // Attempt 1 recordings
        'first_attempt_camera_size' => 'integer',
        'first_attempt_screen_size' => 'integer',
    ];

    // ==================== RELATIONS ====================

    public function employee()           { return $this->belongsTo(Employee::class, 'employee_id'); }
    public function customer()           { return $this->belongsTo(Customer::class, 'customer_id'); }
    public function model()              { return $this->belongsTo(QaqcModel::class, 'model_id'); }
    public function question()           { return $this->belongsTo(Question::class, 'question_id'); }
    public function checkerQc()          { return $this->belongsTo(User::class, 'check_by_qc'); }
    public function checkerProd()        { return $this->belongsTo(User::class, 'check_by_prod'); }
    public function acknowledgerSpv()    { return $this->belongsTo(User::class, 'acknowledge_by_spv'); }
    public function acknowledgerQcSpv()  { return $this->belongsTo(User::class, 'acknowledge_qc_spv'); }
    public function creator()            { return $this->belongsTo(User::class, 'created_by'); }
    public function updater()            { return $this->belongsTo(User::class, 'updated_by'); }
    public function deleter()            { return $this->belongsTo(User::class, 'deleted_by'); }
    public function reviewer()           { return $this->belongsTo(User::class, 'reviewed_by'); }

    // ==================== ACCESSORS ====================

    public function getTotalItemsAttribute(): int
    {
        return count($this->blind_test_items ?? []);
    }

    public function getTotalCorrectAttribute(): int
    {
        return collect($this->user_answers ?? [])->where('is_correct', true)->count();
    }

    public function getTotalWrongAttribute(): int
    {
        return collect($this->user_answers ?? [])->where('is_correct', false)->count();
    }

    public function getPassRateAttribute(): float
    {
        $total = $this->total_items;
        return $total === 0 ? 0 : round(($this->total_correct / $total) * 100, 2);
    }

    public function getDurationFormattedAttribute(): string
    {
        if (!$this->duration_seconds) return '-';
        $m = floor($this->duration_seconds / 60);
        $s = $this->duration_seconds % 60;
        return sprintf('%02d:%02d', $m, $s);
    }

    // ==================== DEADLINE HELPERS ====================

    public function getExecutionDeadlineAttribute(): ?CarbonInterface
    {
        if (!$this->started_at || !$this->duration_minutes) return null;
        return $this->started_at->copy()->addMinutes((int) $this->duration_minutes);
    }

    public function getEffectiveDeadlineAttribute(): ?CarbonInterface
    {
        return $this->execution_deadline;
    }

    public function isExpired(): bool
    {
        if ($this->status === 'completed') return false;
        $eff = $this->effective_deadline;
        return $eff ? now()->greaterThan($eff) : false;
    }

    // ==================== ATTEMPT HELPERS ====================

    /**
     * Masih bisa retry? Hanya kalau:
     * - attempt < max_attempt
     * - status completed
     * - hasil FAIL
     * - tidak ada pending review
     */
    public function canRetry(): bool
    {
        return $this->attempt < $this->max_attempt
            && $this->status === 'completed'
            && $this->overall_result === 'FAIL'
            && !$this->hasPendingReview();
    }

    public function isLastAttempt(): bool
    {
        return $this->attempt >= $this->max_attempt;
    }

    public function isFirstAttemptFail(): bool
    {
        return $this->attempt === 1
            && $this->overall_result === 'FAIL'
            && $this->status === 'completed';
    }

    /**
     * Apakah masih ada jawaban yang menunggu review QC?
     * Kalau sudah di-review (is_reviewed = true), tidak dianggap pending lagi.
     */
    public function hasPendingReview(): bool
    {
        if ($this->is_reviewed) return false;

        return collect($this->user_answers ?? [])
            ->contains(fn ($a) => ($a['location_status'] ?? null) === 'pending');
    }

    /**
     * Tampilkan hasil LENGKAP (kunci + semua attempt) HANYA kalau:
     * - Sudah attempt terakhir, DAN
     * - Tidak ada pending review
     */
    public function shouldShowFullResult(): bool
    {
        return $this->isLastAttempt() && !$this->hasPendingReview();
    }

    // ==================== CAMERA RECORDING HELPERS ====================

    /**
     * URL publik untuk streaming rekaman kamera.
     */
    public function getCameraRecordingUrlAttribute(): ?string
    {
        return $this->camera_recording_path
            ? Storage::disk('public')->url($this->camera_recording_path)
            : null;
    }

    /**
     * Ukuran rekaman dalam format manusiawi (B / KB / MB).
     */
    public function getCameraRecordingSizeFormattedAttribute(): ?string
    {
        return $this->formatSize($this->camera_recording_size);
    }

    /**
     * Durasi rekaman kamera (detik).
     */
    public function getCameraDurationSecondsAttribute(): ?int
    {
        if (!$this->camera_started_at || !$this->camera_stopped_at) return null;
        return $this->camera_stopped_at->diffInSeconds($this->camera_started_at);
    }

    /**
     * Cek apakah rekaman kamera sudah tersedia.
     */
    public function hasCameraRecording(): bool
    {
        return !empty($this->camera_recording_path);
    }

    /**
     * Cek apakah user sudah menyelesaikan verifikasi browser & kamera.
     */
    public function isBrowserVerified(): bool
    {
        return (bool) $this->browser_verified;
    }

    // ==================== SCREEN RECORDING HELPERS ====================

    public function getScreenRecordingUrlAttribute(): ?string
    {
        return $this->screen_recording_path
            ? Storage::disk('public')->url($this->screen_recording_path)
            : null;
    }

    public function getScreenRecordingSizeFormattedAttribute(): ?string
    {
        return $this->formatSize($this->screen_recording_size);
    }

    public function hasScreenRecording(): bool
    {
        return !empty($this->screen_recording_path);
    }

    // ==================== ATTEMPT 1 RECORDING HELPERS ====================

    public function getFirstAttemptCameraUrlAttribute(): ?string
    {
        return $this->first_attempt_camera_path
            ? Storage::disk('public')->url($this->first_attempt_camera_path)
            : null;
    }

    public function getFirstAttemptScreenUrlAttribute(): ?string
    {
        return $this->first_attempt_screen_path
            ? Storage::disk('public')->url($this->first_attempt_screen_path)
            : null;
    }

    public function getFirstAttemptCameraSizeFormattedAttribute(): ?string
    {
        return $this->formatSize($this->first_attempt_camera_size);
    }

    public function getFirstAttemptScreenSizeFormattedAttribute(): ?string
    {
        return $this->formatSize($this->first_attempt_screen_size);
    }

    // ==================== RECORDINGS AGGREGATOR ====================

    /**
     * Kumpulkan semua rekaman yang tersedia, dikelompokkan per attempt.
     *
     * Return:
     * [
     *   'attempt1'        => ['label', 'finished_at', 'camera_url', 'camera_size', 'screen_url', 'screen_size'],
     *   'attempt_current' => ['label', 'finished_at', 'camera_url', 'camera_size', 'screen_url', 'screen_size'],
     * ]
     */
    public function getRecordingsAttribute(): array
    {
        $attempts = [];

        // Attempt 1 (hanya tampil kalau sudah lebih dari 1 attempt)
        if ($this->attempt > 1) {
            $attempts['attempt1'] = [
                'label'       => 'Attempt 1',
                'finished_at' => $this->first_attempt_at?->toIso8601String(),
                'camera_url'  => $this->first_attempt_camera_url,
                'camera_size' => $this->first_attempt_camera_size_formatted,
                'screen_url'  => $this->first_attempt_screen_url,
                'screen_size' => $this->first_attempt_screen_size_formatted,
            ];
        }

        // Attempt terakhir (current)
        $attempts['attempt_current'] = [
            'label'       => 'Attempt ' . $this->attempt,
            'finished_at' => $this->finished_at?->toIso8601String(),
            'camera_url'  => $this->camera_recording_url,
            'camera_size' => $this->camera_recording_size_formatted,
            'screen_url'  => $this->screen_recording_url,
            'screen_size' => $this->screen_recording_size_formatted,
        ];

        return $attempts;
    }

    /**
     * Cek apakah ADA rekaman sama sekali (untuk tampilkan tombol preview).
     */
    public function hasAnyRecording(): bool
    {
        return $this->hasCameraRecording()
            || $this->hasScreenRecording()
            || !empty($this->first_attempt_camera_path)
            || !empty($this->first_attempt_screen_path);
    }

    // ==================== FILTER & EVALUATION ====================

    /**
     * Filter baris untuk tampilan "belum full" (tanpa kunci):
     * - Buang jawaban BENAR (is_correct = true)
     * - Buang yang TIDAK DIJAWAB (user_answer = 'MISSING')
     *
     * Yang tersisa:
     * - Jawaban SALAH yang benar-benar diinput user
     * - Jawaban dengan status PENDING (menunggu review QC)
     */
    public function filterVisibleAnswers(?array $answers = null): array
    {
        $answers = $answers ?? $this->user_answers ?? [];

        return collect($answers)
            ->filter(function ($row) {
                $isCorrect  = $row['is_correct'] ?? false;
                $userAnswer = $row['user_answer'] ?? '';
                $isMissing  = $userAnswer === 'MISSING';

                return !$isCorrect && !$isMissing;
            })
            ->values()
            ->toArray();
    }

    public function evaluateAnswers(array $userInputs): array
    {
        $keyMap = collect($this->blind_test_items ?? [])
            ->mapWithKeys(function ($i) {
                $key = (int) ($i['deffect_item_id'] ?? 0);
                return [$key => strtoupper(trim((string) ($i['component_location'] ?? '')))];
            })
            ->toArray();

        $userItems = collect($userInputs)
            ->map(fn ($i) => [
                'deffect_item_id'    => (int) ($i['deffect_item_id'] ?? 0),
                'component_location' => strtoupper(trim((string) ($i['component_location'] ?? ''))),
            ])
            ->values()
            ->toArray();

        $usedDefectIds = [];
        $result = [];

        foreach ($userItems as $userItem) {
            $defectId = $userItem['deffect_item_id'];
            $location = $userItem['component_location'];

            $deffectMatch = isset($keyMap[$defectId]);
            $sameLocation = $deffectMatch && $keyMap[$defectId] === $location;

            if ($deffectMatch && !in_array($defectId, $usedDefectIds)) {
                $usedDefectIds[] = $defectId;

                $result[] = [
                    'deffect_item_id'    => $defectId,
                    'component_location' => $location,
                    'user_answer'        => 'MATCH',
                    'deffect_match'      => true,
                    'location_status'    => $sameLocation ? 'valid' : 'pending',
                    'is_correct'         => $sameLocation,
                    'reviewed_by'        => null,
                    'reviewed_at'        => null,
                ];
            } else {
                $result[] = [
                    'deffect_item_id'    => $defectId,
                    'component_location' => $location,
                    'user_answer'        => 'NOT_MATCH',
                    'deffect_match'      => false,
                    'location_status'    => 'invalid',
                    'is_correct'         => false,
                    'reviewed_by'        => null,
                    'reviewed_at'        => null,
                ];
            }
        }

        $allKeyItems = collect($this->blind_test_items ?? [])
            ->map(fn ($i) => [
                'deffect_item_id'    => (int) ($i['deffect_item_id'] ?? 0),
                'component_location' => strtoupper(trim((string) ($i['component_location'] ?? ''))),
            ])
            ->values()
            ->toArray();

        foreach ($allKeyItems as $keyItem) {
            if (!in_array($keyItem['deffect_item_id'], $usedDefectIds)) {
                $result[] = [
                    'deffect_item_id'    => $keyItem['deffect_item_id'],
                    'component_location' => $keyItem['component_location'],
                    'user_answer'        => 'MISSING',
                    'deffect_match'      => false,
                    'location_status'    => 'invalid',
                    'is_correct'         => false,
                    'reviewed_by'        => null,
                    'reviewed_at'        => null,
                ];
            }
        }

        return $result;
    }

    public function recalculateResult(): string
    {
        $answers = collect($this->user_answers ?? []);
        if ($answers->isEmpty()) return 'FAIL';

        $allCorrect = $answers->every(fn ($a) => ($a['is_correct'] ?? false) === true);
        return $allCorrect ? 'PASS' : 'FAIL';
    }

    // ==================== PRIVATE HELPERS ====================

    /**
     * Helper: format ukuran byte ke string manusiawi.
     */
    private function formatSize(?int $size): ?string
    {
        if (!$size) return null;
        if ($size < 1024) return $size . ' B';
        if ($size < 1024 * 1024) return round($size / 1024, 1) . ' KB';
        return round($size / (1024 * 1024), 2) . ' MB';
    }
}