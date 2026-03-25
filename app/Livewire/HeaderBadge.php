<?php

namespace App\Livewire;


use App\Models\SiteNotification;
use Livewire\Component;

class HeaderBadge extends Component
{
    public $notification = null;
    public $dropdownOpen = false;

    public function mount()
    {
        $this->loadNotification();
    }

    public function loadNotification()
    {
        $this->notification = SiteNotification::active()
            ->ordered()
            ->first();
    }

    public function toggleDropdown()
    {
        $this->dropdownOpen = !$this->dropdownOpen;
    }

    public function render()
    {
        return view('livewire.settings.header-badge');
    }
}