<?php

namespace App\Livewire\QAQC\BlindTest;

use App\Models\QAQC\BlindTest\BlindTest;
use App\Models\QAQC\BlindTest\Deffect;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Blind Test Review')]
class BlindTestReview extends Component
{
    public $blindTestId;
    public $blindTest;
    public $answers = [];      // array of answers dengan status
    public $reviewNote = '';   // optional remark

    public function mount($id)
    {
        if (!auth()->user()->can('review blind test location')) {
            abort(403, 'You do not have permission to review.');
        }

        $this->blindTestId = $id;
        $this->blindTest = BlindTest::with(['employee', 'customer', 'model', 'question'])
            ->findOrFail($id);

        if ($this->blindTest->status !== 'completed') {
            abort(403, 'Test belum selesai, tidak bisa direview.');
        }

        // Paksa semua jawaban jadi pending — full manual review
        $this->answers = collect($this->blindTest->user_answers ?? [])
            ->map(function ($ans) {
                $isMissing = ($ans['user_answer'] ?? '') === 'MISSING';

                if ($isMissing) {
                    // Baris tidak dijawab → langsung invalid, tidak perlu direview
                    $ans['location_status'] = 'invalid';
                    $ans['is_correct'] = false;
                    $ans['auto_missing'] = true; // flag biar UI tahu ini auto
                } else {
                    $ans['location_status'] = 'pending';
                    $ans['is_correct'] = false;
                    $ans['auto_missing'] = false;
                }

                unset($ans['reviewed_by'], $ans['reviewed_at']);
                return $ans;
            })
            ->values()
            ->toArray();
    }
    /**
     * Mark satu location valid / invalid.
     */
    public function setLocationStatus($index, $status)
    {
        if (!in_array($status, ['valid', 'invalid'])) return;

        if (!isset($this->answers[$index])) return;

        // Baris MISSING tidak boleh direview
        if (($this->answers[$index]['auto_missing'] ?? false) === true) {
            return;
        }

        $this->answers[$index]['location_status'] = $status;
        $this->answers[$index]['reviewed_by'] = auth()->id();
        $this->answers[$index]['reviewed_at'] = now()->toDateTimeString();

        // Semua manual: valid = benar, invalid = salah
        $this->answers[$index]['is_correct'] = ($status === 'valid');
    }

    /**
     * Bulk: valid semua yang pending.
     */
    public function markAllPendingValid()
    {
        foreach ($this->answers as $i => $ans) {
            if (($ans['location_status'] ?? null) === 'pending'
                && !($ans['auto_missing'] ?? false)) {
                $this->setLocationStatus($i, 'valid');
            }
        }
        $this->dispatch('notify', message: 'Semua pending ditandai valid.', type: 'success');
    }

    public function markAllPendingInvalid()
    {
        foreach ($this->answers as $i => $ans) {
            if (($ans['location_status'] ?? null) === 'pending'
                && !($ans['auto_missing'] ?? false)) {
                $this->setLocationStatus($i, 'invalid');
            }
        }
        $this->dispatch('notify', message: 'Semua pending ditandai invalid.', type: 'warning');
    }

    /**
     * Save review → hitung ulang overall_result.
     */
    public function saveReview()
    {
        if (!auth()->user()->can('review blind test location')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        // Cek masih ada pending?
        $hasPending = collect($this->answers)
            ->contains(function ($a) {
                if ($a['auto_missing'] ?? false) return false;
                return ($a['location_status'] ?? null) === 'pending';
            });

        if ($hasPending) {
            $this->dispatch('notify', message: 'Masih ada yang perlu direview!', type: 'error');
            return;
        }

        // Simpan
        $this->blindTest->user_answers = $this->answers;

        // Hitung PASS: SEMUA kunci harus match dengan jawaban user yang valid.
        // Kelebihan jawaban (extra) tidak menggugurkan PASS.
        $totalKeys = count($this->blindTest->blind_test_items ?? []);
        $matchedKeys = 0;

        foreach ($this->blindTest->blind_test_items ?? [] as $keyItem) {
            $keyDefectId = $keyItem['deffect_item_id'] ?? null;

            // Cari baris jawaban user yang match dengan kunci ini
            $matchedRow = collect($this->answers)->first(function ($ans) use ($keyDefectId) {
                // Hanya hitung yang di-mark valid oleh QC
                if (($ans['location_status'] ?? null) !== 'valid') return false;

                // Defect item harus sama
                return (int) ($ans['deffect_item_id'] ?? 0) === (int) $keyDefectId;
            });

            if ($matchedRow) {
                $matchedKeys++;
            }
        }

        // PASS hanya kalau SEMUA kunci terpenuhi
        $overall = ($matchedKeys === $totalKeys && $totalKeys > 0) ? 'PASS' : 'FAIL';

        $this->blindTest->overall_result = $overall;
        $this->blindTest->is_reviewed = true;
        $this->blindTest->reviewed_at = now();
        $this->blindTest->reviewed_by = auth()->id();
        $this->blindTest->save();

        $this->dispatch('notify',
            message: "Review selesai! Hasil akhir: {$this->blindTest->overall_result}",
            type: $this->blindTest->overall_result === 'PASS' ? 'success' : 'error');
    }

    public function render()
    {
        return view('livewire.qaqc.blind-test.blind-test-review', [
            'deffects' => Deffect::orderBy('deffect_item_name')->get(),
        ]);
    }
}