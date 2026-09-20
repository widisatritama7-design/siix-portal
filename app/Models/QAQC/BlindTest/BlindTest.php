<?php

namespace App\Models\QAQC\BlindTest;

use App\Models\HR\Employee;
use App\Models\QAQC\BlindTest\Customer;
use App\Models\QAQC\BlindTest\Model as QaqcModel;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlindTest extends EloquentModel
{
    use SoftDeletes;

    protected $table = 'tb_qaqc_blind_test';

    protected $fillable = [
        'employee_id', 'shift', 'group', 'customer_id', 'model_id',
        'blind_test_items', 'user_answers',
        'time_test', 'duration_minutes',
        'time_actual', 'started_at', 'finished_at', 'duration_seconds',
        'status', 'overall_result',
        'check_by_qc', 'check_by_qc_at',
        'check_by_prod', 'check_by_prod_at',
        'acknowledge_by_spv', 'acknowledge_by_spv_at',
        'acknowledge_qc_spv', 'acknowledge_qc_spv_at',
        'created_by', 'updated_by', 'deleted_by', 'deleted_reason',
    ];

    protected $casts = [
        'blind_test_items'  => 'array',
        'user_answers'      => 'array',
        'time_test'         => 'datetime:H:i',
        'time_actual'       => 'datetime:H:i',
        'duration_minutes'  => 'integer',
        'started_at'        => 'datetime',
        'finished_at'       => 'datetime',
        'check_by_qc_at'    => 'datetime',
        'check_by_prod_at'  => 'datetime',
        'acknowledge_by_spv_at'    => 'datetime',
        'acknowledge_qc_spv_at'    => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
        'deleted_at'        => 'datetime',
    ];

    // ==================== RELATIONS ====================

    public function employee()           { return $this->belongsTo(Employee::class, 'employee_id'); }
    public function customer()           { return $this->belongsTo(Customer::class, 'customer_id'); }
    public function model()              { return $this->belongsTo(QaqcModel::class, 'model_id'); }
    public function checkerQc()          { return $this->belongsTo(User::class, 'check_by_qc'); }
    public function checkerProd()        { return $this->belongsTo(User::class, 'check_by_prod'); }
    public function acknowledgerSpv()    { return $this->belongsTo(User::class, 'acknowledge_by_spv'); }
    public function acknowledgerQcSpv()  { return $this->belongsTo(User::class, 'acknowledge_qc_spv'); }
    public function creator()            { return $this->belongsTo(User::class, 'created_by'); }
    public function updater()            { return $this->belongsTo(User::class, 'updated_by'); }
    public function deleter()            { return $this->belongsTo(User::class, 'deleted_by'); }

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

    public function getDeadlineAttribute(): ?CarbonInterface
    {
        if (!$this->time_test) return null;

        $deadline = $this->created_at->copy()->setTimeFrom($this->time_test);
        if ($deadline->lessThan($this->created_at)) {
            $deadline->addDay();
        }
        return $deadline;
    }

    public function getExecutionDeadlineAttribute(): ?CarbonInterface
    {
        if (!$this->started_at || !$this->duration_minutes) return null;
        return $this->started_at->copy()->addMinutes((int) $this->duration_minutes);
    }

    public function getEffectiveDeadlineAttribute(): ?CarbonInterface
    {
        $deadline = $this->deadline;
        $exec     = $this->execution_deadline;

        if ($deadline && $exec) {
            return $deadline->lessThan($exec) ? $deadline : $exec;
        }
        return $deadline ?? $exec;
    }

    public function isExpired(): bool
    {
        if ($this->status === 'completed') return false;

        if (!$this->started_at) {
            return $this->deadline ? now()->greaterThan($this->deadline) : false;
        }

        $eff = $this->effective_deadline;
        return $eff ? now()->greaterThan($eff) : false;
    }

    // ==================== EVALUATION ====================

    public function evaluateAnswers(array $userInputs): array
    {
        $keyMap = collect($this->blind_test_items ?? [])
            ->mapWithKeys(function ($i) {
                $key = (int) ($i['deffect_item_id'] ?? 0) . '|' . strtoupper(trim((string) ($i['component_location'] ?? '')));
                return [$key => true];
            })
            ->toArray();

        $userItems = collect($userInputs)
            ->map(fn ($i) => [
                'deffect_item_id'    => (int) ($i['deffect_item_id'] ?? 0),
                'component_location' => strtoupper(trim((string) ($i['component_location'] ?? ''))),
            ])
            ->values()
            ->toArray();

        $usedKeyIndexes = [];
        $result = [];

        foreach ($userItems as $userItem) {
            $lookupKey = $userItem['deffect_item_id'] . '|' . $userItem['component_location'];
            $isCorrect = false;
            if (isset($keyMap[$lookupKey]) && !in_array($lookupKey, $usedKeyIndexes)) {
                $isCorrect = true;
                $usedKeyIndexes[] = $lookupKey;
            }
            $result[] = [
                'deffect_item_id'    => $userItem['deffect_item_id'],
                'component_location' => $userItem['component_location'],
                'user_answer'        => $isCorrect ? 'MATCH' : 'NOT_MATCH',
                'is_correct'         => $isCorrect,
            ];
        }

        $allKeyItems = collect($this->blind_test_items ?? [])
            ->map(fn ($i) => [
                'deffect_item_id'    => (int) ($i['deffect_item_id'] ?? 0),
                'component_location' => strtoupper(trim((string) ($i['component_location'] ?? ''))),
            ])
            ->values()
            ->toArray();

        foreach ($allKeyItems as $keyItem) {
            $lookupKey = $keyItem['deffect_item_id'] . '|' . $keyItem['component_location'];
            if (!in_array($lookupKey, $usedKeyIndexes)) {
                $result[] = [
                    'deffect_item_id'    => $keyItem['deffect_item_id'],
                    'component_location' => $keyItem['component_location'],
                    'user_answer'        => 'MISSING',
                    'is_correct'         => false,
                ];
            }
        }

        return $result;
    }
}