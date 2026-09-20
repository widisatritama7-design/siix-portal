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

    /** Sisa detik berdasarkan duration_minutes (null kalau tidak ada durasi) */
    public $remainingSeconds = null;

    public function mount($id)
    {
        $this->blindTestId = $id;
        $this->blindTest = BlindTest::with(['employee', 'customer', 'model'])->findOrFail($id);

        $this->isExpired = $this->blindTest->isExpired();

        if ($this->blindTest->status === 'completed') {
            $this->isFinished = true;
            $this->evaluationResult = $this->blindTest->user_answers;
            $this->overallResult = $this->blindTest->overall_result;
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

    /**
     * Cek apakah waktu test sudah habis (delegasi ke model).
     */
    private function checkExpired(): bool
    {
        return $this->blindTest->isExpired();
    }

    /**
     * Ambil effective deadline (deadline vs durasi, mana yang lebih dulu).
     */
    public function getDeadlineProperty()
    {
        return $this->blindTest->effective_deadline;
    }

    /**
     * Hitung sisa detik berdasarkan duration_minutes.
     */
    private function updateRemaining(): void
    {
        $exec = $this->blindTest->execution_deadline;
        if (!$exec) {
            $this->remainingSeconds = null;
            return;
        }
        // cast ke int, jangan biarkan float
        $this->remainingSeconds = (int) max(0, now()->diffInSeconds($exec, false));
    }

    /**
     * Mulai test
     */
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

    /**
     * Sync sisa waktu (dipanggil dari frontend via polling/wire:poll).
     */
    public function syncTimer()
    {
        if (!$this->isStarted || $this->isFinished) return;

        $this->blindTest->refresh();
        $this->updateRemaining();

        if ($this->checkExpired()) {
            $this->isExpired = true;
        }
    }

    /**
     * Submit jawaban
     */
    public function submit()
    {
        if (!$this->isStarted || $this->isFinished) return;

        $this->blindTest->refresh();
        $this->updateRemaining();

        if ($this->checkExpired()) {
            $this->isExpired = true;
            $this->dispatch('notify', message: 'Waktu test sudah habis! Tidak bisa submit.', type: 'error');
            return;
        }

        foreach ($this->userAnswers as $i => $row) {
            if (empty($row['deffect_item_id']) || empty($row['component_location'])) {
                $this->dispatch('notify', message: "Baris #" . ($i + 1) . " belum lengkap!", type: 'error');
                return;
            }
        }

        $evaluated = $this->blindTest->evaluateAnswers($this->userAnswers);
        $anyWrong = collect($evaluated)->where('is_correct', false)->count() > 0;
        $overall = $anyWrong ? 'FAIL' : 'PASS';

        $finishedAt = now();
        $duration = $finishedAt->timestamp - $this->startedAt;

        $this->blindTest->update([
            'user_answers'      => $evaluated,
            'overall_result'    => $overall,
            'status'            => 'completed',
            'finished_at'       => $finishedAt,
            'time_actual'       => $finishedAt->format('H:i'),
            'duration_seconds'  => $duration,
        ]);

        $this->evaluationResult = $evaluated;
        $this->overallResult = $overall;
        $this->isFinished = true;
        $this->remainingSeconds = null;

        $this->dispatch('notify', message: "Test selesai! Hasil: {$overall}",
            type: $overall === 'PASS' ? 'success' : 'error');
    }

    public function render()
    {
        return view('livewire.qaqc.blind-test.blind-test-execution', [
            'blindTest' => $this->blindTest,
            'deffects'  => Deffect::orderBy('deffect_item_name')->get(),
        ]);
    }
}