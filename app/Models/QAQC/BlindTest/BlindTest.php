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

    // ==================== EVALUATION ====================

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
}