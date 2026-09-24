<?php

namespace App\Livewire\QAQC\BlindTest;

use App\Models\QAQC\BlindTest\BlindTest;
use App\Models\QAQC\BlindTest\Deffect;
use Livewire\Component;

class BlindTestExecution extends Component
{
    public $blindTestId;
    public $blindTest;
    public $userAnswers = [];
    public $startedAt;
    public $isStarted = false;
    public $isFinished = false;
    public $isExpired = false;
    public $evaluationResult = null;
    public $overallResult = null;

    public $isPendingReview = false;
    public $remainingSeconds = null;

    public function mount($id)
    {
        $this->blindTestId = $id;
        $this->blindTest = BlindTest::with(['employee', 'customer', 'model'])->findOrFail($id);

        $this->isExpired = $this->blindTest->isExpired();

        if ($this->blindTest->status === 'completed') {
            $this->isFinished = true;
            $this->evaluationResult = $this->blindTest->user_answers;
            $this->isPendingReview = !$this->blindTest->is_reviewed;
            $this->overallResult = $this->blindTest->is_reviewed
                ? $this->blindTest->overall_result
                : null;
            return;
        }

        $this->userAnswers = [
            ['deffect_item_id' => '', 'component_location' => ''],
        ];

        if ($this->blindTest->status === 'in_progress' && $this->blindTest->started_at) {
            $this->isStarted = true;
            $this->startedAt = $this->blindTest->started_at->timestamp;
            $this->updateRemaining();
        }
    }

    private function checkExpired(): bool
    {
        return $this->blindTest->isExpired();
    }

    public function getDeadlineProperty()
    {
        return $this->blindTest->effective_deadline;
    }

    private function updateRemaining(): void
    {
        $exec = $this->blindTest->execution_deadline;
        if (!$exec) {
            $this->remainingSeconds = null;
            return;
        }
        $this->remainingSeconds = (int) max(0, now()->diffInSeconds($exec, false));
    }

    public function startTest()
    {
        if ($this->isStarted) return;

        if ($this->checkExpired()) {
            $this->isExpired = true;
            $this->dispatch('notify', message: 'Waktu test sudah habis! Tidak bisa dimulai.', type: 'error');
            return;
        }

        if (!auth()->user()->can('execute blind test')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $this->startedAt = now()->timestamp;
        $this->isStarted = true;

        $this->blindTest->update([
            'status'      => 'in_progress',
            'started_at'  => now(),
            'time_actual' => now()->format('H:i'),
        ]);

        $this->blindTest->refresh();
        $this->updateRemaining();

        $this->dispatch('notify', message: 'Test started! Timer berjalan.', type: 'success');
    }

    public function addRow()
    {
        $this->userAnswers[] = ['deffect_item_id' => '', 'component_location' => ''];
    }

    public function removeRow($index)
    {
        unset($this->userAnswers[$index]);
        $this->userAnswers = array_values($this->userAnswers);
    }

    public function syncTimer()
    {
        if (!$this->isStarted || $this->isFinished) return;

        $this->blindTest->refresh();
        $this->updateRemaining();

        if ($this->checkExpired()) {
            $this->isExpired = true;
            $this->autoSubmitIfExpired();
        }
    }

    public function autoSubmitIfExpired()
    {
        if (!$this->isStarted || $this->isFinished) return;
        if (!$this->blindTest->isExpired()) return;

        $validAnswers = collect($this->userAnswers)
            ->filter(fn ($r) => !empty($r['deffect_item_id']) && !empty($r['component_location']))
            ->values()
            ->toArray();

        $this->finalizeSubmit($validAnswers, true);
    }

    public function submit()
    {
        if (!$this->isStarted || $this->isFinished) return;

        $this->blindTest->refresh();
        $this->updateRemaining();

        if ($this->checkExpired()) {
            $this->isExpired = true;
            $this->autoSubmitIfExpired();
            return;
        }

        foreach ($this->userAnswers as $i => $row) {
            if (empty($row['deffect_item_id']) || empty($row['component_location'])) {
                $this->dispatch('notify', message: "Baris #" . ($i + 1) . " belum lengkap!", type: 'error');
                return;
            }
        }

        $this->finalizeSubmit($this->userAnswers, false);
    }

    private function finalizeSubmit(array $answers, bool $isAutoSave): void
    {
        $evaluated = $this->blindTest->evaluateAnswers($answers);
        $hasPending = collect($evaluated)->contains(fn ($e) => ($e['location_status'] ?? null) === 'pending');

        $finishedAt = now();
        $duration = $this->startedAt ? $finishedAt->timestamp - $this->startedAt : 0;

        $this->blindTest->update([
            'user_answers'     => $evaluated,
            'overall_result'   => null,
            'status'           => 'completed',
            'finished_at'      => $finishedAt,
            'time_actual'      => $finishedAt->format('H:i'),
            'duration_seconds' => $duration,
            'auto_saved'       => $isAutoSave,
            'auto_saved_at'    => $isAutoSave ? $finishedAt : null,
            'is_reviewed'      => !$hasPending,
        ]);

        if (!$hasPending) {
            $result = $this->blindTest->recalculateResult();
            $this->blindTest->overall_result = $result;
            $this->blindTest->save();

            if ($this->blindTest->attempt === 1) {
                $this->blindTest->update([
                    'first_attempt_answers' => $evaluated,
                    'first_attempt_result'  => $result,
                    'first_attempt_at'      => $finishedAt,
                ]);
            }
        }

        $this->evaluationResult = $evaluated;
        $this->overallResult = null;
        $this->isPendingReview = true;
        $this->isFinished = true;
        $this->remainingSeconds = $isAutoSave ? 0 : null;

        if ($isAutoSave) {
            $this->isExpired = true;
            $this->dispatch('notify', message: "⏰ Waktu habis! Jawaban auto-saved. Menunggu review QC.", type: 'warning');
        } else {
            $this->dispatch('notify',
                message: $hasPending
                    ? "Test selesai! Menunggu review QC."
                    : "Test selesai! Hasil akan diumumkan setelah verifikasi QC.",
                type: 'info');
        }
    }

    /**
     * Retry test setelah FAIL attempt pertama.
     */
    public function retryTest()
    {
        if (!$this->blindTest->canRetry()) {
            $this->dispatch('notify', message: 'Tidak bisa retry. Kesempatan sudah habis.', type: 'error');
            return;
        }

        if ($this->blindTest->overall_result !== 'FAIL') {
            $this->dispatch('notify', message: 'Hanya test dengan hasil FAIL yang bisa di-retry.', type: 'error');
            return;
        }

        // Pastikan history attempt pertama tersimpan
        if (!$this->blindTest->first_attempt_answers) {
            $this->blindTest->update([
                'first_attempt_answers' => $this->blindTest->user_answers,
                'first_attempt_result'  => $this->blindTest->overall_result,
                'first_attempt_at'      => $this->blindTest->finished_at,
            ]);
        }

        // Reset untuk attempt berikutnya
        $this->blindTest->update([
            'attempt'          => $this->blindTest->attempt + 1,
            'status'           => 'pending',
            'started_at'       => null,
            'finished_at'      => null,
            'duration_seconds' => null,
            'user_answers'     => null,
            'overall_result'   => null,
            'auto_saved'       => false,
            'auto_saved_at'    => null,
            'is_reviewed'      => false,
            'time_actual'      => null,
        ]);

        return redirect()->route('qaqc.blind-test.execute', $this->blindTest->id);
    }

    public function render()
    {
        return view('livewire.qaqc.blind-test.blind-test-execution', [
            'blindTest' => $this->blindTest,
            'deffects'  => Deffect::orderBy('deffect_item_name')->get(),
            'firstAttemptAnswers' => $this->blindTest->first_attempt_answers ?? [],
            'firstAttemptResult'  => $this->blindTest->first_attempt_result,
            'firstAttemptAt'      => $this->blindTest->first_attempt_at,
        ]);
    }
}