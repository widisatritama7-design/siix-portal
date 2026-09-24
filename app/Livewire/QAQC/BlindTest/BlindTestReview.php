<?php

namespace App\Livewire\QAQC\BlindTest;

use App\Models\QAQC\BlindTest\BlindTest;
use App\Models\QAQC\BlindTest\Deffect;
use Livewire\Component;

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

        $this->answers = $this->blindTest->user_answers ?? [];
    }

    /**
     * Mark satu location valid / invalid.
     */
    public function setLocationStatus($index, $status)
    {
        if (!in_array($status, ['valid', 'invalid'])) return;

        if (!isset($this->answers[$index])) return;

        $this->answers[$index]['location_status'] = $status;
        $this->answers[$index]['reviewed_by'] = auth()->id();
        $this->answers[$index]['reviewed_at'] = now()->toDateTimeString();

        // Update is_correct:
        // - defect match + location valid = correct
        // - defect match + location invalid = wrong
        // - defect tidak match = wrong (apapun locationnya)
        $deffectMatch = $this->answers[$index]['deffect_match'] ?? false;
        $this->answers[$index]['is_correct'] = $deffectMatch && $status === 'valid';
    }

    /**
     * Bulk: valid semua yang pending.
     */
    public function markAllPendingValid()
    {
        foreach ($this->answers as $i => $ans) {
            if (($ans['location_status'] ?? null) === 'pending') {
                $this->setLocationStatus($i, 'valid');
            }
        }
        $this->dispatch('notify', message: 'Semua pending ditandai valid.', type: 'success');
    }

    public function markAllPendingInvalid()
    {
        foreach ($this->answers as $i => $ans) {
            if (($ans['location_status'] ?? null) === 'pending') {
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
            ->contains(fn ($a) => ($a['location_status'] ?? null) === 'pending');

        if ($hasPending) {
            $this->dispatch('notify', message: 'Masih ada yang perlu direview!', type: 'error');
            return;
        }

        // Simpan
        $this->blindTest->user_answers = $this->answers;
        $this->blindTest->overall_result = $this->blindTest->recalculateResult();
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