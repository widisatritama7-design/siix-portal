<?php

namespace App\Livewire\QAQC\BlindTest;

use App\Models\QAQC\BlindTest\BlindTest;
use App\Models\QAQC\BlindTest\Deffect;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class BlindTestExecution extends Component
{
    use WithFileUploads;

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

    // ============ Camera / Browser Proctoring ============
    public $showBrowserCheckModal = false;
    public $browserCheckPassed    = false;
    public $cameraStreamActive    = false;

    // Temporary upload file dari Livewire
    public $cameraRecordingTemp;
    public $screenRecordingTemp;
    public $isUploadingRecording = false;

    // ==================== MOUNT ====================

    public function mount($id)
    {
        $this->blindTestId = $id;
        $this->blindTest = BlindTest::with(['employee', 'customer', 'model'])->findOrFail($id);

        $this->isExpired = $this->blindTest->isExpired();

        if ($this->blindTest->status === 'completed') {
            $this->isFinished       = true;
            $this->evaluationResult = $this->blindTest->user_answers;
            $this->isPendingReview  = $this->blindTest->hasPendingReview();
            $this->overallResult    = $this->blindTest->is_reviewed
                ? $this->blindTest->overall_result
                : null;
            return;
        }

        if (!$this->blindTest->browser_verified) {
            $this->showBrowserCheckModal = true;
            $this->browserCheckPassed    = false;
        } else {
            $this->showBrowserCheckModal = false;
            $this->browserCheckPassed    = true;
        }

        $this->userAnswers = [
            ['deffect_item_id' => '', 'component_location' => ''],
        ];

        if ($this->blindTest->status === 'in_progress' && $this->blindTest->started_at) {
            $this->isStarted = true;
            $this->startedAt = $this->blindTest->started_at->timestamp;
            $this->updateRemaining();

            $this->cameraStreamActive = (bool) $this->blindTest->camera_enabled;
        }
    }

    // ==================== DEADLINE HELPERS ====================

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

    // ==================== CAMERA & BROWSER ====================

    public function confirmBrowserCheck(array $browserInfo): void
    {
        $this->blindTest->update([
            'browser_verified' => true,
            'browser_info'     => $browserInfo,
        ]);

        $this->browserCheckPassed    = true;
        $this->showBrowserCheckModal = false;

        $this->dispatch('notify', message: 'Browser & kamera terverifikasi!', type: 'success');
    }

    public function markCameraStarted(): void
    {
        $this->blindTest->update([
            'camera_enabled'    => true,
            'camera_started_at' => now(),
        ]);

        $this->cameraStreamActive = true;
    }

    public function markScreenStarted(): void
    {
        $this->blindTest->update([
            'screen_enabled'    => true,
            'screen_started_at' => now(),
        ]);
    }

    public function setUploadingRecording(bool $value): void
    {
        $this->isUploadingRecording = $value;
    }

    public function uploadCameraRecording(): void
    {
        if (!$this->cameraRecordingTemp) {
            $this->dispatch('notify', message: 'File rekaman kamera tidak ditemukan.', type: 'error');
            return;
        }

        $this->validate([
            'cameraRecordingTemp' => 'file|max:51200',
        ]);

        $filename = 'blind-test-cam-' . $this->blindTest->id . '-' . now()->format('YmdHis') . '.webm';

        $path = $this->cameraRecordingTemp->storeAs(
            'blind-test-camera',
            $filename,
            'public'
        );

        $size = Storage::disk('public')->size($path);

        $payload = [
            'camera_recording_path' => $path,
            'camera_recording_size' => $size,
            'camera_stopped_at'     => now(),
        ];

        // Kalau ini attempt 1 → sekaligus simpan sebagai first_attempt
        if ($this->blindTest->attempt === 1) {
            $payload['first_attempt_camera_path'] = $path;
            $payload['first_attempt_camera_size'] = $size;
        }

        $this->blindTest->update($payload);

        $this->cameraRecordingTemp = null;

        $this->dispatch('notify', message: 'Rekaman kamera tersimpan (' . round($size / 1024) . ' KB).', type: 'success');
    }

    public function uploadScreenRecording(): void
    {
        if (!$this->screenRecordingTemp) {
            $this->dispatch('notify', message: 'File rekaman layar tidak ditemukan.', type: 'error');
            return;
        }

        $this->validate([
            'screenRecordingTemp' => 'file|max:102400',
        ]);

        $filename = 'blind-test-screen-' . $this->blindTest->id . '-' . now()->format('YmdHis') . '.webm';

        $path = $this->screenRecordingTemp->storeAs(
            'blind-test-screen',
            $filename,
            'public'
        );

        $size = Storage::disk('public')->size($path);

        $payload = [
            'screen_recording_path' => $path,
            'screen_recording_size' => $size,
            'screen_stopped_at'     => now(),
        ];

        // Kalau ini attempt 1 → sekaligus simpan sebagai first_attempt
        if ($this->blindTest->attempt === 1) {
            $payload['first_attempt_screen_path'] = $path;
            $payload['first_attempt_screen_size'] = $size;
        }

        $this->blindTest->update($payload);

        $this->screenRecordingTemp = null;

        $this->dispatch('notify', message: 'Rekaman layar tersimpan (' . round($size / 1024) . ' KB).', type: 'success');
    }

    // ==================== START / SUBMIT ====================

    public function startTest()
    {
        if ($this->isStarted) return;

        if (!$this->browserCheckPassed || !$this->blindTest->browser_verified) {
            $this->showBrowserCheckModal = true;
            $this->dispatch('notify', message: 'Lakukan pemeriksaan browser & izinkan kamera terlebih dahulu!', type: 'error');
            return;
        }

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

        $this->dispatch('camera-start-recording');

        $this->dispatch('notify', message: 'Test started! Timer & kamera berjalan.', type: 'success');
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
        $evaluated  = $this->blindTest->evaluateAnswers($answers);
        $hasPending = collect($evaluated)->contains(fn ($e) => ($e['location_status'] ?? null) === 'pending');

        $result = $hasPending ? 'FAIL' : $this->blindTest->recalculateResult();

        $finishedAt = now();
        $duration   = $this->startedAt ? $finishedAt->timestamp - $this->startedAt : 0;

        $this->blindTest->update([
            'user_answers'     => $evaluated,
            'overall_result'   => $result,
            'status'           => 'completed',
            'finished_at'      => $finishedAt,
            'time_actual'      => $finishedAt->format('H:i'),
            'duration_seconds' => $duration,
            'auto_saved'       => $isAutoSave,
            'auto_saved_at'    => $isAutoSave ? $finishedAt : null,
            'is_reviewed'      => !$hasPending,
        ]);

        if ($this->blindTest->attempt === 1) {
            $this->blindTest->update([
                'first_attempt_answers' => $evaluated,
                'first_attempt_result'  => $result,
                'first_attempt_at'      => $finishedAt,
            ]);
        }

        $this->blindTest->refresh();

        $this->evaluationResult = $evaluated;
        $this->overallResult    = $result;
        $this->isPendingReview  = $hasPending;
        $this->isFinished       = true;
        $this->remainingSeconds = $isAutoSave ? 0 : null;

        $this->dispatch('camera-stop-recording');

        if ($isAutoSave) {
            $this->isExpired = true;
            $this->dispatch('notify', message: "⏰ Waktu habis! Jawaban auto-saved. Menunggu review QC.", type: 'warning');
        } else {
            $this->dispatch('notify',
                message: $hasPending
                    ? "Test selesai! Menunggu review QC."
                    : "Test selesai!",
                type: 'info');
        }
    }

    public function retryTest()
    {
        // Blokir kalau upload belum selesai
        if ($this->isUploadingRecording) {
            $this->dispatch('notify', message: 'Tunggu rekaman selesai diupload dulu.', type: 'warning');
            return;
        }

        if (!$this->blindTest->canRetry()) {
            $this->dispatch('notify', message: 'Tidak bisa retry. Kesempatan sudah habis.', type: 'error');
            return;
        }

        if ($this->blindTest->overall_result !== 'FAIL') {
            $this->dispatch('notify', message: 'Hanya test dengan hasil FAIL yang bisa di-retry.', type: 'error');
            return;
        }

        $bt = $this->blindTest;

        $update = [
            // Pindahkan path rekaman (selalu, sebagai fallback)
            'first_attempt_camera_path' => $bt->first_attempt_camera_path ?: $bt->camera_recording_path,
            'first_attempt_camera_size' => $bt->first_attempt_camera_size ?: $bt->camera_recording_size,
            'first_attempt_screen_path' => $bt->first_attempt_screen_path ?: $bt->screen_recording_path,
            'first_attempt_screen_size' => $bt->first_attempt_screen_size ?: $bt->screen_recording_size,
        ];

        // Simpan history answers attempt pertama kalau belum
        if (!$bt->first_attempt_answers) {
            $update['first_attempt_answers'] = $bt->user_answers;
            $update['first_attempt_result']  = $bt->overall_result;
            $update['first_attempt_at']      = $bt->finished_at;
        }

        // Simpan dulu (biar path tersimpan sebelum reset)
        $bt->update($update);

        // Refresh biar sinkron
        $bt->refresh();

        // Reset untuk attempt berikutnya
        $bt->update([
            'attempt'          => $bt->attempt + 1,
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

            'camera_enabled'         => false,
            'camera_recording_path'  => null,
            'camera_recording_size'  => null,
            'camera_started_at'      => null,
            'camera_stopped_at'      => null,

            'screen_enabled'         => false,
            'screen_recording_path'  => null,
            'screen_recording_size'  => null,
            'screen_started_at'      => null,
            'screen_stopped_at'      => null,

            'browser_verified' => false,
            'browser_info'     => null,
        ]);

        return redirect()->route('qaqc.blind-test.execute', $bt->id);
    }

    // ==================== RENDER ====================

    public function render()
    {
        return view('livewire.qaqc.blind-test.blind-test-execution', [
            'blindTest'           => $this->blindTest,
            'deffects'            => Deffect::orderBy('deffect_item_name')->get(),
            'firstAttemptAnswers' => $this->blindTest->first_attempt_answers ?? [],
            'firstAttemptResult'  => $this->blindTest->first_attempt_result,
            'firstAttemptAt'      => $this->blindTest->first_attempt_at,
        ]);
    }
}