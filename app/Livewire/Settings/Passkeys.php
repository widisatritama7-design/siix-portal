<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Illuminate\Contracts\View\View;

class Passkeys extends Component
{
    public $showDeleteModal = false;
    public $passkeyIdToDelete = null;

    public function render(): View
    {
        return view('livewire.settings.passkeys');
    }

    /**
     * Buka modal konfirmasi hapus
     */
    public function confirmDelete($id)
    {
        $this->passkeyIdToDelete = $id;
        $this->showDeleteModal = true;
    }

    /**
     * Eksekusi hapus passkey
     */
    public function deletePasskey()
    {
        if ($this->passkeyIdToDelete) {
            $passkey = auth()->user()->passkeys()->find($this->passkeyIdToDelete);
            
            if ($passkey) {
                $passkey->delete();
                session()->flash('status', 'Passkey berhasil dihapus.');
            }
        }

        // Tutup modal dan reset ID
        $this->showDeleteModal = false;
        $this->passkeyIdToDelete = null;
    }
}